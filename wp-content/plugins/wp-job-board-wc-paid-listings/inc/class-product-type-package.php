<?php
/**
 * product type: package
 *
 * @package    wp-job-board-wc-paid-listings
 * @author     Habq 
 * @license    GNU General Public License, version 3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function wp_job_board_wc_paid_listings_register_package_product_type() {
	class WP_Job_Board_Wc_Paid_Listings_Product_Type_Package extends WC_Product_Simple {
		
		public function __construct( $product ) {
			$this->product_type = 'job_package';
			parent::__construct( $product );
		}

		public function get_type() {
	        return 'job_package';
	    }

	    public function is_sold_individually() {
			return apply_filters( 'wp_job_board_wc_paid_listings_' . $this->product_type . '_is_sold_individually', true );
		}

		public function is_purchasable() {
			return true;
		}

		public function is_virtual() {
			return true;
		}
	}

	class WP_Job_Board_Wc_Paid_Listings_Product_Type_CV_Package extends WC_Product_Simple {
		
		public function __construct( $product ) {
			$this->product_type = 'cv_package';
			parent::__construct( $product );
		}

		public function get_type() {
	        return 'cv_package';
	    }

	    public function is_sold_individually() {
			return apply_filters( 'wp_job_board_wc_paid_listings_' . $this->product_type . '_is_sold_individually', true );
		}

		public function is_purchasable() {
			return true;
		}

		public function is_virtual() {
			return true;
		}
	}

	class WP_Job_Board_Wc_Paid_Listings_Product_Type_Contact_Package extends WC_Product_Simple {
		
		public function __construct( $product ) {
			$this->product_type = 'contact_package';
			parent::__construct( $product );
		}

		public function get_type() {
	        return 'contact_package';
	    }

	    public function is_sold_individually() {
			return apply_filters( 'wp_job_board_wc_paid_listings_' . $this->product_type . '_is_sold_individually', true );
		}

		public function is_purchasable() {
			return true;
		}

		public function is_virtual() {
			return true;
		}
	}

	class WP_Job_Board_Wc_Paid_Listings_Product_Type_Candidate_Package extends WC_Product_Simple {
		
		public function __construct( $product ) {
			$this->product_type = 'candidate_package';
			parent::__construct( $product );
		}

		public function get_type() {
	        return 'candidate_package';
	    }

	    public function is_sold_individually() {
			return apply_filters( 'wp_job_board_wc_paid_listings_' . $this->product_type . '_is_sold_individually', true );
		}

		public function is_purchasable() {
			return true;
		}

		public function is_virtual() {
			return true;
		}
	}

	class WP_Job_Board_Wc_Paid_Listings_Product_Type_Resume_Package extends WC_Product_Simple {
		
		public function __construct( $product ) {
			$this->product_type = 'resume_package';
			parent::__construct( $product );
		}

		public function get_type() {
	        return 'resume_package';
	    }

	    public function is_sold_individually() {
			return apply_filters( 'wp_job_board_wc_paid_listings_' . $this->product_type . '_is_sold_individually', true );
		}

		public function is_purchasable() {
			return true;
		}

		public function is_virtual() {
			return true;
		}
	}
}

add_action( 'init', 'wp_job_board_wc_paid_listings_register_package_product_type' );


function wp_job_board_wc_paid_listings_add_job_package_product( $types ) {
	$types[ 'job_package' ] = __( 'Job Package', 'wp-job-board-wc-paid-listings' );
	$types[ 'cv_package' ] = __( 'CV Package', 'wp-job-board-wc-paid-listings' );
	$types[ 'contact_package' ] = __( 'Contact Package', 'wp-job-board-wc-paid-listings' );
	$types[ 'candidate_package' ] = __( 'Candidate Package', 'wp-job-board-wc-paid-listings' );
	$types[ 'resume_package' ] = __( 'Resume Package', 'wp-job-board-wc-paid-listings' );
	

	return $types;
}

add_filter( 'product_type_selector', 'wp_job_board_wc_paid_listings_add_job_package_product' );

function wp_job_board_wc_paid_listings_woocommerce_product_class( $classname, $product_type ) {

    if ( $product_type == 'job_package' ) { // notice the checking here.
        $classname = 'WP_Job_Board_Wc_Paid_Listings_Product_Type_Package';
    }

    if ( $product_type == 'cv_package' ) { // notice the checking here.
        $classname = 'WP_Job_Board_Wc_Paid_Listings_Product_Type_CV_Package';
    }

    if ( $product_type == 'contact_package' ) { // notice the checking here.
        $classname = 'WP_Job_Board_Wc_Paid_Listings_Product_Type_Contact_Package';
    }

    if ( $product_type == 'candidate_package' ) { // notice the checking here.
        $classname = 'WP_Job_Board_Wc_Paid_Listings_Product_Type_Candidate_Package';
    }

    if ( $product_type == 'resume_package' ) { // notice the checking here.
        $classname = 'WP_Job_Board_Wc_Paid_Listings_Product_Type_Resume_Package';
    }

    return $classname;
}

add_filter( 'woocommerce_product_class', 'wp_job_board_wc_paid_listings_woocommerce_product_class', 10, 2 );


/**
 * Show pricing fields for package product.
 */
function wp_job_board_wc_paid_listings_package_custom_js() {

	if ( 'product' != get_post_type() ) {
		return;
	}

	?><script type='text/javascript'>
		jQuery( document ).ready( function() {
			// job package
			jQuery('.product_data_tabs .general_tab').show();
        	jQuery('#general_product_data .pricing').addClass('show_if_job_package').show();
			jQuery('.inventory_options').addClass('show_if_job_package').show();
			jQuery('.inventory_options').addClass('show_if_job_package').show();
            jQuery('#inventory_product_data ._manage_stock_field').addClass('show_if_job_package').show();
            jQuery('#inventory_product_data ._sold_individually_field').parent().addClass('show_if_job_package').show();
            jQuery('#inventory_product_data ._sold_individually_field').addClass('show_if_job_package').show();

            // cv
            jQuery('#general_product_data .pricing').addClass('show_if_cv_package').show();
			jQuery('.inventory_options').addClass('show_if_cv_package').show();
			jQuery('.inventory_options').addClass('show_if_cv_package').show();
            jQuery('#inventory_product_data ._manage_stock_field').addClass('show_if_cv_package').show();
            jQuery('#inventory_product_data ._sold_individually_field').parent().addClass('show_if_cv_package').show();
            jQuery('#inventory_product_data ._sold_individually_field').addClass('show_if_cv_package').show();

            // contact
            jQuery('#general_product_data .pricing').addClass('show_if_contact_package').show();
			jQuery('.inventory_options').addClass('show_if_contact_package').show();
			jQuery('.inventory_options').addClass('show_if_contact_package').show();
            jQuery('#inventory_product_data ._manage_stock_field').addClass('show_if_contact_package').show();
            jQuery('#inventory_product_data ._sold_individually_field').parent().addClass('show_if_contact_package').show();
            jQuery('#inventory_product_data ._sold_individually_field').addClass('show_if_contact_package').show();

            // candidate
            jQuery('#general_product_data .pricing').addClass('show_if_candidate_package').show();
			jQuery('.inventory_options').addClass('show_if_candidate_package').show();
			jQuery('.inventory_options').addClass('show_if_candidate_package').show();
            jQuery('#inventory_product_data ._manage_stock_field').addClass('show_if_candidate_package').show();
            jQuery('#inventory_product_data ._sold_individually_field').parent().addClass('show_if_candidate_package').show();
            jQuery('#inventory_product_data ._sold_individually_field').addClass('show_if_candidate_package').show();

            // resume
            jQuery('#general_product_data .pricing').addClass('show_if_resume_package').show();
			jQuery('.inventory_options').addClass('show_if_resume_package').show();
			jQuery('.inventory_options').addClass('show_if_resume_package').show();
            jQuery('#inventory_product_data ._manage_stock_field').addClass('show_if_resume_package').show();
            jQuery('#inventory_product_data ._sold_individually_field').parent().addClass('show_if_resume_package').show();
            jQuery('#inventory_product_data ._sold_individually_field').addClass('show_if_resume_package').show();
		});
	</script><?php
}
add_action( 'admin_footer', 'wp_job_board_wc_paid_listings_package_custom_js' );

function wp_job_board_wc_paid_listings_custom_product_tabs( $tabs) {
	$tabs['job_package_option'] = array(
		'label'		=> __( 'Job Package Options', 'wp-job-board-wc-paid-listings' ),
		'target'	=> 'job_package_options',
		'class'		=> array( 'show_if_job_package' ),
	);
	$tabs['cv_package_option'] = array(
		'label'		=> __( 'CV Package Options', 'wp-job-board-wc-paid-listings' ),
		'target'	=> 'cv_package_options',
		'class'		=> array( 'show_if_cv_package' ),
	);
	$tabs['contact_package_option'] = array(
		'label'		=> __( 'Contact Package Options', 'wp-job-board-wc-paid-listings' ),
		'target'	=> 'contact_package_options',
		'class'		=> array( 'show_if_contact_package' ),
	);

	$tabs['candidate_package_option'] = array(
		'label'		=> __( 'Candidate Package Options', 'wp-job-board-wc-paid-listings' ),
		'target'	=> 'candidate_package_options',
		'class'		=> array( 'show_if_candidate_package' ),
	);

	$tabs['resume_package_option'] = array(
		'label'		=> __( 'Resume Package Options', 'wp-job-board-wc-paid-listings' ),
		'target'	=> 'resume_package_options',
		'class'		=> array( 'show_if_resume_package' ),
	);
	return $tabs;
}
add_filter( 'woocommerce_product_data_tabs', 'wp_job_board_wc_paid_listings_custom_product_tabs' );
/**
 * Contents of the package options product tab.
 */
function wp_job_board_wc_paid_listings_package_options_product_tab_content() {
	?>
	<!-- Job Package -->
	<div id='job_package_options' class='panel woocommerce_options_panel'>
		<div class='options_group'>
			<?php
				woocommerce_wp_checkbox( array(
					'id' 		=> '_urgent_jobs',
					'label' 	=> __( 'Urgent Jobs?', 'wp-job-board-wc-paid-listings' ),
					'description'	=> __( 'Urgent this listing - it will be styled differently and sticky.', 'wp-job-board-wc-paid-listings' ),
				) );
				woocommerce_wp_checkbox( array(
					'id' 		=> '_feature_jobs',
					'label' 	=> __( 'Feature Jobs?', 'wp-job-board-wc-paid-listings' ),
					'description'	=> __( 'Feature this listing - it will be styled differently and sticky.', 'wp-job-board-wc-paid-listings' ),
				) );
				woocommerce_wp_text_input( array(
					'id'			=> '_jobs_limit',
					'label'			=> __( 'Jobs Limit', 'wp-job-board-wc-paid-listings' ),
					'desc_tip'		=> 'true',
					'description'	=> __( 'The number of listings a user can post with this package', 'wp-job-board-wc-paid-listings' ),
					'type' 			=> 'number',
				) );
				woocommerce_wp_text_input( array(
					'id'			=> '_jobs_duration',
					'label'			=> __( 'Jobs Duration (Days)', 'wp-job-board-wc-paid-listings' ),
					'desc_tip'		=> 'true',
					'description'	=> __( 'The number of days that the listings will be active', 'wp-job-board-wc-paid-listings' ),
					'type' 			=> 'number',
				) );

				do_action('wp_job_board_wc_paid_listings_package_options_product_tab_content');
			?>
		</div>
	</div>

	<!-- CV Package -->
	<div id='cv_package_options' class='panel woocommerce_options_panel'>
		<div class='options_group'>
			<?php
				woocommerce_wp_text_input( array(
					'id'			=> '_cv_package_expiry_time',
					'label'			=> __( 'Package Expiry Time (Days)', 'wp-job-board-wc-paid-listings' ),
					'desc_tip'		=> 'true',
					'description'	=> __( 'The number of days that the user package active. Leave this field blank for unlimited', 'wp-job-board-wc-paid-listings' ),
					'type' 			=> 'number',
					'default'		=> 30
				) );
				woocommerce_wp_text_input( array(
					'id'			=> '_cv_number_of_cv',
					'label'			=> __( 'Number of CV\'s', 'wp-job-board-wc-paid-listings' ),
					'desc_tip'		=> 'true',
					'description'	=> __( 'The number of CV to view in this package. Leave this field blank for unlimited', 'wp-job-board-wc-paid-listings' ),
					'type' 			=> 'number',
					'default'		=> 10
				) );

				do_action('wp_job_board_wc_paid_cv_listings_package_options_product_tab_content');
			?>
		</div>
	</div>

	<!-- Contact Package -->
	<div id='contact_package_options' class='panel woocommerce_options_panel'>
		<div class='options_group'>
			<?php
				woocommerce_wp_text_input( array(
					'id'			=> '_contact_package_expiry_time',
					'label'			=> __( 'Package Expiry Time (Days)', 'wp-job-board-wc-paid-listings' ),
					'desc_tip'		=> 'true',
					'description'	=> __( 'The number of days that the user package active. Leave this field blank for unlimited', 'wp-job-board-wc-paid-listings' ),
					'type' 			=> 'number',
					'default'		=> 30
				) );
				woocommerce_wp_text_input( array(
					'id'			=> '_contact_number_of_cv',
					'label'			=> __( 'Number of CV\'s', 'wp-job-board-wc-paid-listings' ),
					'desc_tip'		=> 'true',
					'description'	=> __( 'The number of CV to view in this package. Leave this field blank for unlimited', 'wp-job-board-wc-paid-listings' ),
					'type' 			=> 'number',
					'default'		=> 10
				) );

				do_action('wp_job_board_wc_paid_contact_listings_package_options_product_tab_content');
			?>
		</div>
	</div>

	<!-- Candidate package -->
	<div id='candidate_package_options' class='panel woocommerce_options_panel'>
		<div class='options_group'>
			<?php
				woocommerce_wp_text_input( array(
					'id'			=> '_candidate_package_expiry_time',
					'label'			=> __( 'Package Expiry Time (Days)', 'wp-job-board-wc-paid-listings' ),
					'desc_tip'		=> 'true',
					'description'	=> __( 'The number of days that the user package active. Leave this field blank for unlimited', 'wp-job-board-wc-paid-listings' ),
					'type' 			=> 'number',
					'default'		=> 30
				) );
				woocommerce_wp_text_input( array(
					'id'			=> '_candidate_number_of_applications',
					'label'			=> __( 'Number of Applications', 'wp-job-board-wc-paid-listings' ),
					'desc_tip'		=> 'true',
					'description'	=> __( 'The number of Applications to candidate apply. Leave this field blank for unlimited', 'wp-job-board-wc-paid-listings' ),
					'type' 			=> 'number',
					'default'		=> 10
				) );

				do_action('wp_job_board_wc_paid_candidate_listings_package_options_product_tab_content');
			?>
		</div>
	</div>

	<!-- Resume package -->
	<div id='resume_package_options' class='panel woocommerce_options_panel'>
		<div class='options_group'>
			<?php
				woocommerce_wp_checkbox( array(
					'id' 		=> '_urgent_resumes',
					'label' 	=> __( 'Urgent Jobs?', 'wp-job-board-wc-paid-listings' ),
					'description'	=> __( 'Urgent this listing - it will be styled differently and sticky.', 'wp-job-board-wc-paid-listings' ),
				) );
				woocommerce_wp_checkbox( array(
					'id' 		=> '_featured_resumes',
					'label' 	=> __( 'Featured Jobs?', 'wp-job-board-wc-paid-listings' ),
					'description'	=> __( 'Feature this listing - it will be styled differently and sticky.', 'wp-job-board-wc-paid-listings' ),
				) );
				woocommerce_wp_text_input( array(
					'id'			=> '_resumes_duration',
					'label'			=> __( 'Resume Duration (Days)', 'wp-job-board-wc-paid-listings' ),
					'desc_tip'		=> 'true',
					'description'	=> __( 'The number of days that the resume will be active', 'wp-job-board-wc-paid-listings' ),
					'type' 			=> 'number',
				) );
				do_action('wp_job_board_wc_paid_resume_listings_package_options_product_tab_content');
			?>
		</div>
	</div>
	<?php
}
add_action( 'woocommerce_product_data_panels', 'wp_job_board_wc_paid_listings_package_options_product_tab_content' );

/**
 * Save the Job Package custom fields.
 */
function wp_job_board_wc_paid_listings_save_package_option_field( $post_id ) {
	$urgent_jobs = isset( $_POST['_urgent_jobs'] ) ? 'yes' : 'no';
	update_post_meta( $post_id, '_urgent_jobs', $urgent_jobs );
	
	$feature_jobs = isset( $_POST['_feature_jobs'] ) ? 'yes' : 'no';
	update_post_meta( $post_id, '_feature_jobs', $feature_jobs );
	
	if ( isset( $_POST['_jobs_limit'] ) ) {
		update_post_meta( $post_id, '_jobs_limit', sanitize_text_field( $_POST['_jobs_limit'] ) );
	}

	if ( isset( $_POST['_jobs_duration'] ) ) {
		update_post_meta( $post_id, '_jobs_duration', sanitize_text_field( $_POST['_jobs_duration'] ) );
	}
}
add_action( 'woocommerce_process_product_meta_job_package', 'wp_job_board_wc_paid_listings_save_package_option_field'  );

/**
 * Save the CV Package custom fields.
 */
function wp_job_board_wc_paid_listings_save_cv_package_option_field( $post_id ) {
	if ( isset( $_POST['_cv_package_expiry_time'] ) ) {
		update_post_meta( $post_id, '_cv_package_expiry_time', sanitize_text_field( $_POST['_cv_package_expiry_time'] ) );
	}

	if ( isset( $_POST['_cv_number_of_cv'] ) ) {
		update_post_meta( $post_id, '_cv_number_of_cv', sanitize_text_field( $_POST['_cv_number_of_cv'] ) );
	}
}
add_action( 'woocommerce_process_product_meta_cv_package', 'wp_job_board_wc_paid_listings_save_cv_package_option_field'  );

/**
 * Save the Contact Package custom fields.
 */
function wp_job_board_wc_paid_listings_save_contact_package_option_field( $post_id ) {
	if ( isset( $_POST['_contact_package_expiry_time'] ) ) {
		update_post_meta( $post_id, '_contact_package_expiry_time', sanitize_text_field( $_POST['_contact_package_expiry_time'] ) );
	}

	if ( isset( $_POST['_contact_number_of_cv'] ) ) {
		update_post_meta( $post_id, '_contact_number_of_cv', sanitize_text_field( $_POST['_contact_number_of_cv'] ) );
	}
}
add_action( 'woocommerce_process_product_meta_contact_package', 'wp_job_board_wc_paid_listings_save_contact_package_option_field'  );

/**
 * Save the Candidate Package custom fields.
 */
function wp_job_board_wc_paid_listings_save_candidate_package_option_field( $post_id ) {
	if ( isset( $_POST['_candidate_package_expiry_time'] ) ) {
		update_post_meta( $post_id, '_candidate_package_expiry_time', sanitize_text_field( $_POST['_candidate_package_expiry_time'] ) );
	}
	
	if ( isset( $_POST['_candidate_number_of_applications'] ) ) {
		update_post_meta( $post_id, '_candidate_number_of_applications', sanitize_text_field( $_POST['_candidate_number_of_applications'] ) );
	}
}
add_action( 'woocommerce_process_product_meta_candidate_package', 'wp_job_board_wc_paid_listings_save_candidate_package_option_field'  );

/**
 * Save the Resume Package custom fields.
 */
function wp_job_board_wc_paid_listings_save_resume_package_option_field( $post_id ) {
	$urgent_resumes = isset( $_POST['_urgent_resumes'] ) ? 'yes' : 'no';
	update_post_meta( $post_id, '_urgent_resumes', $urgent_resumes );
	
	$featured_resumes = isset( $_POST['_featured_resumes'] ) ? 'yes' : 'no';
	update_post_meta( $post_id, '_featured_resumes', $featured_resumes );

	if ( isset( $_POST['_resumes_duration'] ) ) {
		update_post_meta( $post_id, '_resumes_duration', sanitize_text_field( $_POST['_resumes_duration'] ) );
	}
}
add_action( 'woocommerce_process_product_meta_resume_package', 'wp_job_board_wc_paid_listings_save_resume_package_option_field'  );