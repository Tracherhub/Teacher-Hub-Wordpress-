<?php
/**
 * Social: Google
 *
 * @package    wp-job-board
 * @author     Habq 
 * @license    GNU General Public License, version 3
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/*
 * Import the Google SDK and load all the classes
 */
require_once WP_JOB_BOARD_PLUGIN_DIR . 'libraries/google-sdk/autoload.php';


class WP_Job_Board_Social_Google {
    
    private $client_id;
    private $client_secret;
    private $redirect_url;
    private $callback_url;
    private $google_user_datas;

    private static $_instance = null;

    public static function get_instance() {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function __construct() {
        $this->client_id = wp_job_board_get_option( 'google_api_client_id' );
        $this->client_secret = wp_job_board_get_option( 'google_api_client_secret' );

        if ( $this->is_google_login_enabled() || $this->is_google_apply_enabled() ) {
            $user_dashboard_page_id = wp_job_board_get_option('user_dashboard_page_id');
            $this->redirect_url = $user_dashboard_page_id > 0 ? get_permalink($user_dashboard_page_id) : home_url('/');
            $this->callback_url = admin_url('admin-ajax.php?action=wp_job_board_google_login');

            $this->set_access_tokes();

            add_action( 'wp_ajax_wp_job_board_google_login', array( $this, 'process_google_login' ) );
            add_action( 'wp_ajax_nopriv_wp_job_board_google_login', array( $this, 'process_google_login' ) );

            add_action( 'wp_job_board_after_google_login', array( $this, 'process_apply_job'), 10, 1 );

            add_action( 'login_form', array( $this, 'display_login_btn') );
            if ( $this->is_google_apply_enabled() ) {
                add_action( 'wp_job_board_social_apply_btn', array( $this, 'display_apply_btn') );
            }
        }
    }

    public function is_google_login_enabled() {
        if ( wp_job_board_get_option('enable_google_login') && ! empty( $this->client_id ) && ! empty( $this->client_secret ) ) {
            return true;
        }

        return false;
    }

    public function is_google_apply_enabled() {
        if ( wp_job_board_get_option('enable_google_apply') && ! empty( $this->client_id ) && ! empty( $this->client_secret ) ) {
            return true;
        }

        return false;
    }
    
    private function set_access_tokes() {
        
        if ( isset($_GET['code']) && !isset($_GET['state']) && !isset($_GET['redirect_from']) ) {

            $client = new Google_Client();
            $client->setApplicationName('Login Check');
            $client->setClientId($this->client_id);
            $client->setClientSecret($this->client_secret);
            $client->setRedirectUri($this->redirect_url);
            $client->addScope("email");
            $client->addScope("profile");

            $client->authenticate($_GET['code']);
            set_transient('access_token', $client->getAccessToken(), 60 * 60 * 24 * 30);
            setcookie('wp_hob_board_gdetct_acc_token', $client->getAccessToken(), time() + (86400 * 7), "/");

            WP_Job_Board_Mixes::redirect(admin_url('admin-ajax.php?action=wp_job_board_google_login'));
        }
    }

    public function process_google_login() {
        if (isset($_GET['logout'])) {
            delete_transient('access_token');
        }

        $client = new Google_Client();
        $client->setApplicationName('Login Check');
        $client->setClientId($this->client_id);
        $client->setClientSecret($this->client_secret);
        $client->setRedirectUri($this->redirect_url);
        $client->addScope("email");
        $client->addScope("profile");

        /*         * **********************************************
          When we create the service here, we pass the
          client to it. The client then queries the service
          for the required scopes, and uses that when
          generating the authentication URL later.
         * ********************************************** */
        $service = new Google_Service_Oauth2($client);

        if (get_transient('access_token')) {
            $client->setAccessToken(get_transient('access_token'));
            $this->google_user_datas = $service->userinfo->get();
            
            // We first try to login the user
            $this->login_user();

            // Otherwise, we create a new account
            $this->create_user();
        }

        WP_Job_Board_Mixes::redirect($this->redirect_url);
    }

    private function login_user() {
        $wp_users = get_users(array(
            'number' => 1,
            'count_total' => false,
            'fields' => 'ids',
            'meta_query' => array(
                array(
                    'key' => 'wp_job_board_google_id',
                    'value' => $this->google_user_datas->id,
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

            do_action('wp_job_board_after_google_login', $wp_users[0]);
        }

        WP_Job_Board_Mixes::redirect($this->redirect_url);
    }

    private function create_user() {
        $google_user = $this->google_user_datas;
        
        $google_user_id = isset($google_user->id) ? $google_user->id : '';
        $name = isset($google_user->name) ? $google_user->name : '';
        $email = isset($google_user->email) ? $google_user->email : '';

        $_social_user_obj = get_user_by('email', $email);
        if (is_object($_social_user_obj) && isset($_social_user_obj->ID)) {
            update_user_meta($_social_user_obj->ID, 'wp_job_board_google_id', $google_user_id);
            $this->login_user();
        }

        // Create a username
        $username = sanitize_user(str_replace(' ', '_', strtolower($name)));
        if ($username == '') {
            $username = 'user_' . rand(10000, 99999);
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
        $userdata = apply_filters('wp-job-board-google-login-userdata', $userdata, $google_user);
        
        $_POST['action'] = 'wp_job_board_ajax_register';

        // Creating our user
        $user_id = wp_insert_user( $userdata );
        if ( ! is_wp_error( $user_id ) ) {
            
            $first_name = isset($google_user->given_name) ? $google_user->given_name : '';
            $last_name = isset($google_user->family_name) ? $google_user->family_name : '';
            $user_pic = isset($google_user->picture) ? $google_user->picture : '';

            update_user_meta($user_id, 'first_name', $first_name);
            update_user_meta($user_id, 'last_name', $last_name);
            update_user_meta($user_id, 'wp_job_board_google_id', $google_user_id);

            $user_candidate_id = WP_Job_Board_User::get_candidate_by_user_id($user_id);
            if ( $user_pic != '' ) {
                WP_Job_Board_Image::upload_attach_with_external_url($user_pic, $user_candidate_id);
            }

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
                do_action('wp_job_board_after_google_login', $user_id);

                wp_set_auth_cookie($user_id);
            }
            
        } else {
            set_transient('wp_job_board_google_message', $user_id->get_error_message(), 60 * 60 * 24 * 30);
            echo $user_id->get_error_message();
            die;
        }
    }


    public function process_apply_job($user_id) {
        if ( isset( $_COOKIE['wp_job_board_google_job_id'] ) && $_COOKIE['wp_job_board_google_job_id'] > 0 ) {
            $job_id = $_COOKIE['wp_job_board_google_job_id'];
            $job = get_post($job_id);

            if ( WP_Job_Board_User::is_candidate( $user_id ) ) {
                WP_Job_Board_Candidate::insert_applicant($user_id, $job);
            }

            $this->redirect_url = get_permalink($job_id);

            unset($_COOKIE['wp_job_board_google_job_id']);
            setcookie('wp_job_board_google_job_id', null, -1, '/');
        }
    }

    public function get_login_url() {

        if (isset($_GET['logout'])) {
            delete_transient('access_token');
        }

        $client = new Google_Client();
        $client->setApplicationName('Login Check');
        $client->setClientId($this->client_id);
        $client->setClientSecret($this->client_secret);
        $client->setRedirectUri($this->redirect_url);
        $client->addScope("email");
        //$client->addScope("profile");
        //$client->setApprovalPrompt("force");

        $service = new Google_Service_Oauth2($client);

        $authUrl = $client->createAuthUrl();

        return $authUrl;
    }

    public function display_message() {
        if ( get_transient('wp_job_board_google_message') ) {
            $message = get_transient('wp_job_board_google_message');
            echo '<div class="alert alert-danger twitter-message">' . $message . '</div>';
            delete_transient('wp_job_board_google_message');
        }
    }

    public function display_login_btn() {
        if ( is_user_logged_in() ) {
            return;
        }
        ob_start();
        $this->display_message();
        ?>
        <div class="google-login-btn-wrapper">
            <a class="google-login-btn" href="<?php echo esc_url($this->get_login_url()); ?>"><i class="fa fa-google"></i> <?php esc_html_e('Google', 'wp-job-board'); ?></a>
        </div>
        <?php
        $output = ob_get_clean();
        echo apply_filters('wp-job-board-google-login-btn', $output, $this);
    }

    public function display_apply_btn($job) {
        if ( !WP_Job_Board_Job_Listing::check_can_apply_social($job->ID) ) {
            return;
        }
        ob_start();
        $this->display_message();
        ?>
        <div class="google-apply-btn-wrapper">
            <a class="google-apply-btn" href="<?php echo esc_url($this->get_login_url()); ?>" data-job_id="<?php echo esc_attr($job->ID); ?>"><i class="fa fa-google"></i> <?php esc_html_e('Google', 'wp-job-board'); ?></a>
        </div>
        <?php
        $output = ob_get_clean();
        echo apply_filters('wp-job-board-google-apply-btn', $output, $this);
    }

}

function wp_job_board_social_google() {
    WP_Job_Board_Social_Google::get_instance();
}
add_action( 'init', 'wp_job_board_social_google' );