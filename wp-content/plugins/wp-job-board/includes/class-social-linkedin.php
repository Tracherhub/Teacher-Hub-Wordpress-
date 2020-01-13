<?php
/**
 * Social: LinkedIn
 *
 * @package    wp-job-board
 * @author     Habq 
 * @license    GNU General Public License, version 3
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class WP_Job_Board_Social_Linkedin {
    
    const _AUTHORIZE_URL = 'https://www.linkedin.com/uas/oauth2/authorization';

    const _TOKEN_URL = 'https://www.linkedin.com/uas/oauth2/accessToken';

    const _BASE_URL = 'https://api.linkedin.com/v1';

    // LinkedIn Application Key
    public $li_api_key;

    // LinkedIn Application Secret
    public $li_secret_key;

    // Stores Access Token
    public $access_token;

    // Stores OAuth Object
    public $oauth;

    // Stores the user redirect after login
    public $user_redirect = false;

    private $redirect_url = '';

    private $linkedin_user_datas;

    private $linkedin_user_email_datas;

    // Stores our LinkedIn options 
    public $li_options;

    private static $_instance = null;

    public static function get_instance() {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function __construct() {
        $this->li_api_key = wp_job_board_get_option( 'linkedin_api_client_id' );
        $this->li_secret_key = wp_job_board_get_option( 'linkedin_api_client_secret' );

        if ( $this->is_linkedin_login_enabled() || $this->is_linkedin_apply_enabled() ) {
            $this->li_options = array(
                'li_cancel_redirect_url' => '',
                'li_redirect_url' => '',
                'li_auto_profile_update' => '',
                'li_registration_redirect_url' => '',
                'li_logged_in_message' => '',
            );

            require_once WP_JOB_BOARD_PLUGIN_DIR . 'libraries/linkedin/linkedin_oauth2.class.php';

            // Create new Oauth client
            $this->oauth = new WP_Job_Board_OAuth2Client($this->li_api_key, $this->li_secret_key);

            // Set Oauth URLs
            $this->oauth->redirect_uri = home_url('/') . '?action=linkedin_login';
            $this->oauth->authorize_url = self::_AUTHORIZE_URL;
            $this->oauth->token_url = self::_TOKEN_URL;
            $this->oauth->api_base_url = self::_BASE_URL;

            // Set user token if user is logged in
            if (get_current_user_id()) {
                $this->oauth->access_token = get_user_meta(get_current_user_id(), 'wp_job_board_access_token', true);
            }

            $this->process_linkedin_login();

            //add_action( 'wp_job_board_after_linkedin_login', array( $this, 'process_apply_job'), 10, 1 );
            if ( $this->is_linkedin_login_enabled() ) {
                add_action( 'login_form', array( $this, 'display_login_btn') );
            }
            if ( $this->is_linkedin_apply_enabled() ) {
                add_action( 'wp_job_board_social_apply_btn', array( $this, 'display_apply_btn') );
            }
            
            // Start session
            if (!session_id()) {
                session_start();
            }
        }
    }

    public function is_linkedin_login_enabled() {
        if ( wp_job_board_get_option('enable_linkedin_login') && ! empty( $this->li_api_key ) && ! empty( $this->li_secret_key ) ) {
            return true;
        }

        return false;
    }

    public function is_linkedin_apply_enabled() {
        if ( wp_job_board_get_option('enable_linkedin_apply') && ! empty( $this->li_api_key ) && ! empty( $this->li_secret_key ) ) {
            return true;
        }

        return false;
    }

    public function process_linkedin_login() {
        // If this is not a linkedin sign-in request, do nothing
        if (!$this->is_linkedin_signin()) {
            return;
        }

        // If this is a user sign-in request, but the user denied granting access, redirect to login URL
        if (isset($_REQUEST['error']) && $_REQUEST['error'] == 'access_denied') {

            // Get our cancel redirect URL
            $cancel_redirect_url = $this->li_options['li_cancel_redirect_url'];

            // Redirect to login URL if left blank
            if (empty($cancel_redirect_url)) {
                wp_redirect(home_url('/'));
            }

            // Redirect to our given URL
            wp_safe_redirect($cancel_redirect_url);
        }

        // Another error occurred, create an error log entry
        if (isset($_REQUEST['error'])) {
            $error = $_REQUEST['error'];
            $error_description = $_REQUEST['error_description'];
            error_log("WP LinkedIn Login Error\nError: $error\nDescription: $error_description");
        }

        // Get profile XML response
        $xml = $this->get_linkedin_profile();
        $xml = json_decode($xml, true);

        $email_xml = $this->get_linkedin_profile_email();
        $email_xml = json_decode($email_xml, true);

        if (!is_array($xml) || !isset($xml['id'])) {
            return false;
        }

        $this->linkedin_user_datas = $xml;
        $this->linkedin_user_email_datas = $email_xml;

        // We first try to login the user
        $this->login_user();

        // Otherwise, we create a new account
        $this->create_user();
        
        if ( empty($this->redirect_url) ) {
            $user_dashboard_page_id = wp_job_board_get_option('user_dashboard_page_id');
            $this->redirect_url = $user_dashboard_page_id > 0 ? get_permalink($user_dashboard_page_id) : home_url('/');
        }

        WP_Job_Board_Mixes::redirect($this->redirect_url);
    }

    private function is_linkedin_signin() {

        // If no action is requested or the action is not ours
        if (!isset($_REQUEST['action']) || ($_REQUEST['action'] != "linkedin_login")) {
            return false;
        }

        // If a code is not returned, and no error as well, then OAuth did not proceed properly
        if (!isset($_REQUEST['code']) && !isset($_REQUEST['error'])) {
            return false;
        }

        /*
         * Temporarily disabled this because we're getting two different states at random times

          // If state is not set, or it is different than what we expect there might be a request forgery
          if ( ! isset($_SESSION['li_api_state'] ) || $_REQUEST['state'] != $_SESSION['li_api_state']) {
          return false;
          }
         */

        // This is a LinkedIn signing-request - unset state and return true
        unset($_SESSION['li_api_state']);

        return true;
    }

    private function get_linkedin_profile() {

        // Use GET method since POST isn't working
        $this->oauth->curl_authenticate_method = 'GET';

        // Request access token
        $response = $this->oauth->authenticate($_REQUEST['code']);
        if ($response) {
            $this->access_token = $response->{'access_token'};
        }

        // Get first name, last name and email address, and load 
        // response into XML object
        $xml = ($this->oauth->get('https://api.linkedin.com/v2/me?projection=(id,firstName,lastName,email-address,profilePicture(displayImage~:playableStreams))'));

        return $xml;
    }

    private function get_linkedin_profile_email() {

        // Use GET method since POST isn't working
        $this->oauth->curl_authenticate_method = 'GET';

        // Request access token
        $response = $this->oauth->authenticate($_REQUEST['code']);
        
        if ($response) {
            $this->access_token = $response->{'access_token'};
        }

        // Get first name, last name and email address, and load 
        // response into XML object
        $xml = ($this->oauth->get('https://api.linkedin.com/v2/emailAddress?q=members&projection=(elements*(handle~))'));
        
        return $xml;
    }

    private function login_user() {
        $linkedin_user = $this->linkedin_user_datas;
        $user_id = isset($linkedin_user['id']) ? $linkedin_user['id'] : '';
        
        // We look for the `eo_linkedin_id` to see if there is any match
        $wp_users = get_users(array(
            'number' => 1,
            'count_total' => false,
            'fields' => 'ids',
            'meta_query' => array(
                array(
                    'key' => 'wp_job_board_linkedin_id',
                    'value' => $user_id,
                    'compare' => "=",
                )
            )
        ));

        if (empty($wp_users[0])) {
            return false;
        }

        $user_login_auth = WP_Job_Board_User::get_user_status($wp_users[0]);
        if ( $user_login_auth == 'pending' ) {
            $user_data = get_userdata($wp_users[0]);
            $jsondata = array(
                'error' => false,
                'msg' => WP_Job_Board_User::register_msg($user_data),
            );
            $_SESSION['register_msg'] = $jsondata;
            $login_register_page_id = wp_job_board_get_option('login_register_page_id');
            $this->redirect_url = $login_register_page_id > 0 ? get_permalink($login_register_page_id) : home_url('/');
        } elseif ( $user_login_auth == 'denied' ) {
            $jsondata = array(
                'status' => false,
                'msg' => __('Your account denied', 'wp-job-board')
            );
            $_SESSION['register_msg'] = $jsondata;
            $login_register_page_id = wp_job_board_get_option('login_register_page_id');
            $this->redirect_url = $login_register_page_id > 0 ? get_permalink($login_register_page_id) : home_url('/');
        } else {
            wp_set_auth_cookie($wp_users[0]);

            // apply job
            $this->process_apply_job($wp_users[0]);

            do_action('wp_job_board_after_linkedin_login', $wp_users[0]);
        }

        WP_Job_Board_Mixes::redirect($this->redirect_url);
    }

    private function create_user() {
        $linkedin_user = $this->linkedin_user_datas;
        $linkedin_user_email = $this->linkedin_user_email_datas;
        
        $linkedin_user_id = isset($linkedin_user['id']) ? $linkedin_user['id'] : '';

        $first_name = $last_name = '';
        
        if (!empty($linkedin_user['firstName']['localized'])) {
            foreach ($linkedin_user['firstName']['localized'] as $value) {
                $first_name = $value;
            }
        }
        if (!empty($linkedin_user['lastName']['localized'])) {
            foreach ($linkedin_user['lastName']['localized'] as $value) {
                $last_name = $value;
            }
        }

        $email = isset($linkedin_user_email['elements'][0]['handle~']['emailAddress']) ? $linkedin_user_email['elements'][0]['handle~']['emailAddress'] : '';

        $_social_user_obj = get_user_by('email', $email);
        if (is_object($_social_user_obj) && isset($_social_user_obj->ID)) {
            update_user_meta($_social_user_obj->ID, 'wp_job_board_linkedin_id', $linkedin_user_id);
            $this->login_user();
        }

        if ($first_name != '' && $last_name != '') {
            $name = $first_name . '_' . $last_name;
            $name = str_replace(array(' '), array('_'), $name);
            $username = sanitize_user(str_replace(' ', '_', strtolower($name)));
        } else {
            $username = $email;
        }

        if (username_exists($username)) {
            $username .= '_' . rand(10000, 99999);
        }

        ///
        $userdata = array(
            'user_login' => sanitize_user( $username ),
            'user_email' => sanitize_email( $email ),
            'user_pass' => wp_generate_password(),
            'role' => 'wp_job_board_candidate',
        );
        $userdata = apply_filters('wp-job-board-linkedin-login-userdata', $userdata, $linkedin_user);

        $_POST['action'] = 'wp_job_board_ajax_register';
        // Creating our user
        $user_id = wp_insert_user( $userdata );
        if ( ! is_wp_error( $user_id ) ) {
            
            update_user_meta($user_id, 'first_name', $first_name);
            update_user_meta($user_id, 'last_name', $last_name);
            update_user_meta($user_id, 'wp_job_board_linkedin_id', $linkedin_user_id);
            update_user_meta($user_id, 'wp_job_board_access_token', $this->access_token, true);

            if ( WP_Job_Board_User::is_candidate($user_id) && wp_job_board_get_option('candidates_requires_approval', 'auto') != 'auto' ) {
                $user_data = get_userdata($user_id);
                $jsondata = array(
                    'error' => false,
                    'msg' => WP_Job_Board_User::register_msg($user_data),
                );
                $_SESSION['register_msg'] = $jsondata;
                $login_register_page_id = wp_job_board_get_option('login_register_page_id');
                $this->redirect_url = $login_register_page_id > 0 ? get_permalink($login_register_page_id) : home_url('/');

            } else {
                // apply job
                $this->process_apply_job($user_id);

                do_action('wp_job_board_after_linkedin_login', $user_id);

                wp_set_auth_cookie($user_id);
            }
        } else {
            set_transient('wp_job_board_linkedin_message', $user_id->get_error_message(), 60 * 60 * 24 * 30);
            echo $user_id->get_error_message();
            die;
        }
    }


    public function process_apply_job($user_id) {
        if ( isset( $_COOKIE['wp_job_board_linkedin_job_id'] ) && $_COOKIE['wp_job_board_linkedin_job_id'] > 0 ) {
            $job_id = $_COOKIE['wp_job_board_linkedin_job_id'];
            $job = get_post($job_id);

            if ( WP_Job_Board_User::is_candidate( $user_id ) ) {
                WP_Job_Board_Candidate::insert_applicant($user_id, $job);
            }

            $this->redirect_url = get_permalink($job_id);

            unset($_COOKIE['wp_job_board_linkedin_job_id']);
            setcookie('wp_job_board_linkedin_job_id', null, -1, '/');
        }
    }

    // Returns LinkedIn login URL
    public function get_login_url($redirect = false) {
        $state = wp_generate_password(12, false);
        $authorize_url = $this->oauth->authorizeUrl(array('scope' => 'r_liteprofile r_emailaddress',
            'state' => $state));

        // Store state in database in temporarily till checked back
        if (!isset($_SESSION['li_api_state'])) {
            $_SESSION['li_api_state'] = $state;
        }

        // Store redirect URL in session
        $_SESSION['li_api_redirect'] = $redirect;

        return $authorize_url;
    }

    public function display_message() {
        if ( get_transient('wp_job_board_linkedin_message') ) {
            $message = get_transient('wp_job_board_linkedin_message');
            echo '<div class="alert alert-danger linkedin-message">' . $message . '</div>';
            delete_transient('wp_job_board_linkedin_message');
        }
    }

    public function display_login_btn() {
        if ( is_user_logged_in() ) {
            return;
        }
        ob_start();
        $this->display_message();
        ?>
        <div class="linkedin-login-btn-wrapper">
            <a class="linkedin-login-btn" href="<?php echo esc_url($this->get_login_url()); ?>"><i class="fa fa-linkedin"></i> <?php esc_html_e('LinkedIn', 'wp-job-board'); ?></a>
        </div>
        <?php
        $output = ob_get_clean();
        echo apply_filters('wp-job-board-linkedin-login-btn', $output, $this);
    }

    public function display_apply_btn($job) {
        if ( !WP_Job_Board_Job_Listing::check_can_apply_social($job->ID) ) {
            return;
        }
        ob_start();
        $this->display_message();
        ?>
        <div class="linkedin-apply-btn-wrapper">
            <a class="linkedin-apply-btn" href="<?php echo esc_url($this->get_login_url()); ?>" data-job_id="<?php echo esc_attr($job->ID); ?>"><i class="fa fa-linkedin"></i> <?php esc_html_e('LinkedIn', 'wp-job-board'); ?></a>
        </div>
        <?php
        $output = ob_get_clean();
        echo apply_filters('wp-job-board-linkedin-apply-btn', $output, $this);
    }

}


function wp_job_board_social_linkedin() {
    WP_Job_Board_Social_Linkedin::get_instance();
}
add_action( 'init', 'wp_job_board_social_linkedin' );