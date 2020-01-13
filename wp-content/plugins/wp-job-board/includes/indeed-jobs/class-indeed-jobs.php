<?php
/**
 * Indeed Jobs
 *
 * @package    wp-job-board
 * @author     Habq 
 * @license    GNU General Public License, version 3
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class WP_Job_Board_Indeed_Jobs {

    public static function init() {
        self::load_files();
        add_action( 'admin_enqueue_scripts', array(__CLASS__, 'admin_enqueue_scripts') );
    }

    public static function admin_enqueue_scripts() {
        
        wp_enqueue_script( 'wp-job-board-indeed-jobs', WP_JOB_BOARD_PLUGIN_URL . 'assets/js/admin-indeed-job-impport.js', array( 'jquery' ), '1.0.0', true );

        $args = array(
            'ajaxurl' => admin_url('admin-ajax.php'),
            'error_msg' => esc_html__('There is some problem.', 'wp-job-board'),
            'submit_txt' => esc_html__('Submit', 'wp-job-board'),
        );

        wp_localize_script('wp-job-board-indeed-jobs', 'wp_job_board_indeed_opts', $args);
        
    }

    public static function load_files() {
        require_once WP_JOB_BOARD_PLUGIN_DIR . 'includes/indeed-jobs/include/indeed-jobs-api.php';
        require_once WP_JOB_BOARD_PLUGIN_DIR . 'includes/indeed-jobs/include/indeed-jobs-hooks.php';
    }

}

WP_Job_Board_Indeed_Jobs::init();
