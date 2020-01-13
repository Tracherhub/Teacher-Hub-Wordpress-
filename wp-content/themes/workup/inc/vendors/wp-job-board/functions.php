<?php

function workup_get_jobs( $params = array() ) {
	$params = wp_parse_args( $params, array(
		'limit' => -1,
		'post_status' => 'publish',
		'get_jobs_by' => 'recent',
		'orderby' => '',
		'order' => '',
		'post__in' => array(),
		'fields' => null, // ids
		'author' => null,
		'categories' => array(),
		'types' => array(),
		'locations' => array(),
	));
	extract($params);

	$query_args = array(
		'post_type'         => 'job_listing',
		'posts_per_page'    => $limit,
		'post_status'       => $post_status,
		'orderby'       => $orderby,
		'order'       => $order,
	);

	$meta_query = array();
	switch ($get_jobs_by) {
		case 'recent':
			$query_args['orderby'] = 'date';
			$query_args['order'] = 'DESC';
			break;
		case 'featured':
			$meta_query[] = array(
				'key' => WP_JOB_BOARD_JOB_LISTING_PREFIX.'featured',
	           	'value' => 'on',
	           	'compare' => '=',
			);
			break;
		case 'urgent':
			$meta_query[] = array(
				'key' => WP_JOB_BOARD_JOB_LISTING_PREFIX.'urgent',
	           	'value' => 'on',
	           	'compare' => '=',
			);
			break;
	}

	if ( !empty($post__in) ) {
    	$query_args['post__in'] = $post__in;
    }

    if ( !empty($fields) ) {
    	$query_args['fields'] = $fields;
    }

    if ( !empty($author) ) {
    	$query_args['author'] = $author;
    }

    $tax_query = array();
    if ( !empty($categories) ) {
    	$tax_query[] = array(
            'taxonomy'      => 'job_listing_category',
            'field'         => 'slug',
            'terms'         => implode(",", $categories ),
            'operator'      => 'IN'
        );
    }
    if ( !empty($types) ) {
    	$tax_query[] = array(
            'taxonomy'      => 'job_listing_type',
            'field'         => 'slug',
            'terms'         => implode(",", $types ),
            'operator'      => 'IN'
        );
    }
    if ( !empty($locations) ) {
    	$tax_query[] = array(
            'taxonomy'      => 'job_listing_location',
            'field'         => 'slug',
            'terms'         => implode(",", $locations ),
            'operator'      => 'IN'
        );
    }

    if ( !empty($tax_query) ) {
    	$query_args['tax_query'] = $tax_query;
    }
    
    if ( !empty($meta_query) ) {
    	$query_args['meta_query'] = $meta_query;
    }

	return new WP_Query( $query_args );
}

if ( !function_exists('workup_job_content_class') ) {
	function workup_job_content_class( $class ) {
		$prefix = 'jobs';
		if ( is_singular( 'job_listing' ) ) {
            $prefix = 'job';
        }
		if ( workup_get_config($prefix.'_fullwidth') ) {
			return 'container-fluid';
		}
		return $class;
	}
}
add_filter( 'workup_job_content_class', 'workup_job_content_class', 1 , 1  );

if ( !function_exists('workup_get_jobs_layout_configs') ) {
	function workup_get_jobs_layout_configs() {
		$layout_type = workup_get_jobs_layout_type();
		switch ( $layout_type ) {
		 	case 'left-main':
		 		$configs['left'] = array( 'sidebar' => 'jobs-filter-sidebar', 'class' => 'col-md-4 col-lg-3 col-sm-12 col-xs-12'  );
		 		$configs['main'] = array( 'class' => 'col-md-8 col-lg-9 col-sm-12 col-xs-12' );
		 		break;
		 	case 'main-right':
		 	default:
		 		$configs['right'] = array( 'sidebar' => 'jobs-filter-sidebar',  'class' => 'col-md-4 col-lg-3 col-sm-12 col-xs-12' ); 
		 		$configs['main'] = array( 'class' => 'col-md-8 col-lg-9 col-sm-12 col-xs-12' );
		 		break;
	 		case 'main':
	 			$configs['main'] = array( 'class' => 'col-md-12 col-sm-12 col-xs-12' );
	 			break;
		}
		return $configs; 
	}
}

function workup_get_jobs_layout_type() {
	global $post;
	if ( is_page() && is_object($post) ) {
		$layout_type = get_post_meta( $post->ID, 'apus_page_layout_type', true );
	}
	if ( empty($layout_type) ) {
		$layout_type = workup_get_config('jobs_layout_type', 'main-right');
	}
	return apply_filters( 'workup_get_jobs_layout_type', $layout_type );
}

function workup_get_jobs_display_mode() {
	global $post;
	if ( is_page() && is_object($post) ) {
		$display_mode = get_post_meta( $post->ID, 'apus_page_display_mode', true );
	}
	if ( empty($display_mode) ) {
		$display_mode = workup_get_config('jobs_display_mode', 'list');
	}
	return apply_filters( 'workup_get_jobs_display_mode', $display_mode );
}

function workup_get_jobs_inner_style() {
	global $post;
	if ( is_page() && is_object($post) ) {
		$inner_style = get_post_meta( $post->ID, 'apus_page_inner_style', true );
	}
	if ( empty($inner_style) ) {
		$inner_style = workup_get_config('jobs_inner_style', 'list');
	}
	return apply_filters( 'workup_get_jobs_inner_style', $inner_style );
}

function workup_get_jobs_columns() {
	global $post;
	if ( is_page() && is_object($post) ) {
		$columns = get_post_meta( $post->ID, 'apus_page_jobs_columns', true );
	}
	if ( empty($columns) ) {
		$columns = workup_get_config('jobs_columns', 3);
	}
	return apply_filters( 'workup_get_jobs_columns', $columns );
}

function workup_get_job_layout_type() {
	global $post;
	$layout_type = get_post_meta($post->ID, WP_JOB_BOARD_JOB_LISTING_PREFIX.'layout_type', true);
	
	if ( empty($layout_type) ) {
		$layout_type = workup_get_config('job_layout_type', 'v1');
	}
	return apply_filters( 'workup_get_job_layout_type', $layout_type );
}

function workup_get_jobs_pagination() {
	global $post;
	if ( is_page() && is_object($post) ) {
		$pagination = get_post_meta( $post->ID, 'apus_page_jobs_pagination', true );
	}
	if ( empty($pagination) ) {
		$pagination = workup_get_config('jobs_pagination', 'default');
	}
	return apply_filters( 'workup_get_jobs_pagination', $pagination );
}

function workup_job_scripts() {
	
	wp_enqueue_style( 'leaflet' );
	wp_enqueue_script( 'jquery-highlight' );
    wp_enqueue_script( 'leaflet' );
    wp_enqueue_script( 'leaflet-GoogleMutant' );
    wp_enqueue_script( 'control-geocoder' );
    wp_enqueue_script( 'esri-leaflet' );
    wp_enqueue_script( 'esri-leaflet-geocoder' );
    wp_enqueue_script( 'leaflet-markercluster' );
    wp_enqueue_script( 'leaflet-HtmlIcon' );


	wp_register_script( 'workup-job', get_template_directory_uri() . '/js/job.js', array( 'jquery', 'wp-job-board-main' ), '20150330', true );
	wp_localize_script( 'workup-job', 'workup_job_opts', array(
		'ajaxurl' => admin_url( 'admin-ajax.php' ),
	));
	wp_enqueue_script( 'workup-job' );


	$mapbox_token = '';
	$mapbox_style = '';
	$custom_style = '';
	if ( wp_job_board_get_option('map_service', '') == 'mapbox' ) {
		$mapbox_token = wp_job_board_get_option('mapbox_token', '');
		$mapbox_style = wp_job_board_get_option('mapbox_style', 'mapbox.streets-basic');
	} else {
		$custom_style = wp_job_board_get_option('google_map_style', '');
	}

	wp_register_script( 'workup-job-map', get_template_directory_uri() . '/js/job-map.js', array( 'jquery' ), '20150330', true );
	wp_localize_script( 'workup-job-map', 'workup_job_map_opts', array(
		'mapbox_token' => $mapbox_token,
		'mapbox_style' => $mapbox_style,
		'custom_style' => $custom_style,
	));
	wp_enqueue_script( 'workup-job-map' );
}
add_action( 'wp_enqueue_scripts', 'workup_job_scripts', 10 );

function workup_job_create_resume_pdf_styles() {
	return array(
		get_template_directory() . '/css/resume-pdf.css'
	);
}
add_filter( 'wp-job-board-style-pdf', 'workup_job_create_resume_pdf_styles', 10 );

function workup_job_metaboxes(array $metaboxes) {
	// jobs
	$prefix = WP_JOB_BOARD_JOB_LISTING_PREFIX;
	if ( isset($metaboxes[ $prefix . 'general' ]) && isset($metaboxes[ $prefix . 'general' ]['fields']) ) {
		$metaboxes[ $prefix . 'general' ]['fields'][] = array(
			'name'              => esc_html__( 'Layout Type', 'workup' ),
			'id'                => $prefix . 'layout_type',
			'type'              => 'select',
			'options'			=> array(
                '' => esc_html__('Global Settings', 'workup'),
                'v1' => esc_html__('Version 1', 'workup'),
                'v2' => esc_html__('Version 2', 'workup')
            ),
		);
	}
	return $metaboxes;
}
add_filter( 'cmb2_meta_boxes', 'workup_job_metaboxes' );


function workup_job_template_folder_name($folder) {
	$folder = 'template-jobs';
	return $folder;
}
add_filter( 'wp-job-board-theme-folder-name', 'workup_job_template_folder_name', 10 );


function workup_job_get_filter_fields() {
	return apply_filters( 'workup_job_get_filter_fields', array(
		'title'	=> array(
			'label' => esc_html__( 'Search Keywords', 'workup' ),
			'field_call_back' => array( 'WP_Job_Board_Mixes', 'filter_field_input'),
			'placeholder' => esc_html__( 'e.g. web design', 'workup' ),
			'show_title' => false,
			'for_post_type' => 'job_listing',
		),
		'category' => array(
			'label' => esc_html__( 'Category', 'workup' ),
			'field_call_back' => array( 'WP_Job_Board_Mixes', 'filter_field_taxonomy_select'),
			'taxonomy' => 'job_listing_category',
			'toggle' => false,
			'show_title' => false,
			'for_post_type' => 'job_listing',
		),
		'center-location' => array(
			'label' => esc_html__( 'Location', 'workup' ),
			'field_call_back' => array( 'WP_Job_Board_Mixes', 'filter_field_input_location'),
			'placeholder' => esc_html__( 'All Location', 'workup' ),
			'show_distance' => false,
			'toggle' => false,
			'show_title' => false,
			'for_post_type' => 'job_listing',
		),
		'location' => array(
			'label' => esc_html__( 'Location list', 'workup' ),
			'field_call_back' => array( 'WP_Job_Board_Mixes', 'filter_field_taxonomy_select'),
			'taxonomy' => 'job_listing_location',
			'placeholder' => esc_html__( 'All Locations', 'workup' ),
			'toggle' => false,
			'show_title' => false,
			'for_post_type' => 'job_listing',
		),
		'type' => array(
			'label' => esc_html__( 'Job Type', 'workup' ),
			'field_call_back' => array( 'WP_Job_Board_Mixes', 'filter_field_taxonomy_select'),
			'taxonomy' => 'job_listing_type',
			'placeholder' => esc_html__( 'All Types', 'workup' ),
			'toggle' => false,
			'show_title' => false,
			'for_post_type' => 'job_listing',
		),
		'salary' => array(
			'label' => esc_html__( 'Salary', 'workup' ),
			'field_call_back' => 'workup_filter_field_job_salary',
			'toggle' => false,
			'show_title' => false,
			'for_post_type' => 'job_listing',
		),
		'date-posted' => array(
			'label' => esc_html__( 'Date Posted', 'workup' ),
			'field_call_back' => 'workup_filter_field_input_date_posted',
			'toggle' => false,
			'show_title' => false,
			'for_post_type' => 'job_listing',
		),
		'tag' => array(
			'label' => esc_html__( 'Job Tag', 'workup' ),
			'field_call_back' => array( 'WP_Job_Board_Mixes', 'filter_field_taxonomy_select'),
			'taxonomy' => 'job_listing_tag',
			'toggle' => false,
			'show_title' => false,
			'for_post_type' => 'job_listing',
		),
		'featured' => array(
			'label' => esc_html__( 'Featured', 'workup' ),
			'field_call_back' => array( 'WP_Job_Board_Mixes', 'filter_field_checkbox'),
			'for_post_type' => 'job_listing',
		),
		'urgent' => array(
			'label' => esc_html__( 'Urgent', 'workup' ),
			'field_call_back' => array( 'WP_Job_Board_Mixes', 'filter_field_checkbox'),
			'for_post_type' => 'job_listing',
		),
	));
}

function workup_filter_field_input_date_posted($instance, $args, $key, $field) {
	$name = 'filter-'.$key;
	$selected = !empty( $_GET[$name] ) ? $_GET[$name] : 'all';
	$options = WP_Job_Board_Abstract_Filter::date_posted_options();

	include WP_Job_Board_Template_Loader::locate( 'widgets/filter-fields/select' );
}

function workup_filter_field_job_salary($instance, $args, $key, $field) {
	$name = 'filter-'.$key;
	$selected = !empty( $_GET[$name] ) ? $_GET[$name] : '';

	$salary_min = WP_Job_Board_Query::get_min_max_meta_value(WP_JOB_BOARD_JOB_LISTING_PREFIX.'salary', 'job_listing');
	$salary_max = WP_Job_Board_Query::get_min_max_meta_value(WP_JOB_BOARD_JOB_LISTING_PREFIX.'max_salary', 'job_listing');
	if ( empty($salary_min) && empty($salary_max) ) {
		return;
	}
	$min = $max = 0;
	$min = $salary_min->min < $salary_max->min ? $salary_min->min : $salary_max->min;
	$max = $salary_min->max > $salary_max->max ? $salary_min->max : $salary_max->max;
	
	if ( $min >= $max ) {
		return;
	}
	include WP_Job_Board_Template_Loader::locate( 'widgets/filter-fields/salary_horizontal_range_slider' );
}


add_filter( 'workup_job_get_filter_fields', 'workup_add_filter_fields_job_listing' );
function workup_add_filter_fields_job_listing($fields) {

	$post_type = 'job_cfield';
	$prefix = WP_JOB_BOARD_JOB_CUSTOM_FIELD_PREFIX;
	
	$cfields = workup_generate_filter_fields($post_type, $prefix, 'job_listing');

	if ( $cfields ) {
		$fields = array_merge($fields, $cfields);
	}
	return $fields;
}

function workup_generate_filter_fields($post_type, $prefix, $for_post_type) {
	$custom_fields = WP_Job_Board_Post_Type_Job_Custom_Fields::get_custom_fields($post_type);
	$fields = array();
	foreach ($custom_fields as $post) {
		$field_type = get_post_meta( $post->ID, $prefix . 'field_type', true );
        $show_filter = get_post_meta( $post->ID, $prefix . 'show_filter', true );

        if ( $show_filter && in_array($field_type, array('text', 'select', 'radio', 'checkbox', 'multicheck')) ) {
        	$toggle = true;
        	if ( $field_type == 'checkbox' ) {
        		$toggle = false;
        	}
        	$callback = array( __CLASS__, 'filter_field_'.$field_type );
        	if ( in_array($field_type, array( 'select', 'radio', 'multicheck')) ) {
        		$callback = 'workup_filter_field_select';
        	}
        	$fields[$post->post_name] = array(
        		'label' => $post->post_title,
        		'post_type' => $post_type,
        		'for_post_type' => $for_post_type,
        		'prefix' => $prefix,
        		'toggle' => false,
        		'field_call_back' => $callback,
        		'show_title' => false,
        	);
        }
	}
	return $fields;
}

function workup_filter_field_select($instance, $args, $key, $field) {
	$options = WP_Job_Board_Post_Type_Job_Custom_Fields::get_options_by_name($key, $field);
    $name = 'filter-custom-'.$key;
    $selected = ! empty( $_GET[$name] ) ? $_GET[$name] : '';
	
	if ( $options ) {
		foreach ($options as $key => $option) {
			$options[$key]['count'] = WP_Job_Board_Abstract_Filter::filter_count($name, $option['value'], $field);
		}
	}
	
	include WP_Job_Board_Template_Loader::locate( 'widgets/filter-fields/select' );
}

// post per page
add_filter('wp-job-board-job_listing-filter-query', 'workup_job_filter_query', 10, 2);
function workup_job_filter_query( $query, $params) {
	$query_vars = &$query->query_vars;
	$query_vars['posts_per_page'] = workup_job_get_limit_number();
	$query->query_vars = $query_vars;
	
	return $query;
}

add_filter( 'wp-job-board-job_listing-query-args', 'workup_job_filter_query_args', 10, 2 );
function workup_job_filter_query_args($query_args, $params) {
	$query_args['posts_per_page'] = workup_job_get_limit_number();
	return $query_args;
}

function workup_job_get_limit_number() {
	if ( isset( $_REQUEST['jobs_ppp'] ) ) {
        $number = intval( $_REQUEST['jobs_ppp'] );
    } elseif ( !empty($_COOKIE['jobs_per_page']) ) {
        $number = intval( $_COOKIE['jobs_per_page'] );
    } else {
        $value = wp_job_board_get_option('number_jobs_per_page', 10);
        $number = intval( $value );
    }
    return $number;
}

add_action('init', 'workup_job_save_ppp');
function workup_job_save_ppp() {
	if ( !empty( $_REQUEST['jobs_ppp'] ) ) {
        $number = intval( $_REQUEST['jobs_ppp'] );
        setcookie('jobs_per_page', $number, time() + 864000);
        $_COOKIE['jobs_per_page'] = $number;
    }
}

function workup_check_employer_candidate_review($post) {
	if ( (comments_open($post) || get_comments_number($post)) ) {
		if ( method_exists('WP_Job_Board_Employer', 'check_restrict_review') ) {
			if ( WP_Job_Board_Employer::check_restrict_review($post) ) {
				return true;
			} else {
				return false;
			}
		}
		return true;
	}
	return false;
}

function workup_placeholder_img_src( $size = 'thumbnail' ) {
	$src               = get_template_directory_uri() . '/images/placeholder.png';
	$placeholder_image = workup_get_config('job_placeholder_image');
	if ( !empty($placeholder_image['id']) ) {
        if ( is_numeric( $placeholder_image['id'] ) ) {
			$image = wp_get_attachment_image_src( $placeholder_image['id'], $size );

			if ( ! empty( $image[0] ) ) {
				$src = $image[0];
			}
		} else {
			$src = $placeholder_image;
		}
    }

	return apply_filters( 'workup_job_placeholder_img_src', $src );
}

// demo function
function workup_check_demo_account() {
	if ( defined('WORKUP_DEMO_MODE') && WORKUP_DEMO_MODE ) {
		$user_id = get_current_user_id();
		$user_obj = get_user_by('ID', $user_id);
		if ( strtolower($user_obj->data->user_login) == 'candidate' || strtolower($user_obj->data->user_login) == 'employer' ) {
			$return = array( 'status' => false, 'msg' => esc_html__('Demo users are not allowed to modify information.', 'workup') );
		   	echo wp_json_encode($return);
		   	exit;
		}
	}
}
add_action('wp-job-board-process-apply-email', 'workup_check_demo_account', 10);
add_action('wp-job-board-process-apply-internal', 'workup_check_demo_account', 10);
add_action('wp-job-board-process-remove-applied', 'workup_check_demo_account', 10);
add_action('wp-job-board-process-add-job-shortlist', 'workup_check_demo_account', 10);
add_action('wp-job-board-process-remove-job-shortlist', 'workup_check_demo_account', 10);
add_action('wp-job-board-process-follow-employer', 'workup_check_demo_account', 10);
add_action('wp-job-board-process-unfollow-employer', 'workup_check_demo_account', 10);

add_action('wp-job-board-process-add-candidate-shortlist', 'workup_check_demo_account', 10);
add_action('wp-job-board-process-remove-candidate-shortlist', 'workup_check_demo_account', 10);

add_action('wp-job-board-process-forgot-password', 'workup_check_demo_account', 10);
add_action('wp-job-board-process-change-password', 'workup_check_demo_account', 10);
add_action('wp-job-board-before-delete-profile', 'workup_check_demo_account', 10);
add_action('wp-job-board-before-remove-job-alert', 'workup_check_demo_account', 10 );

function workup_check_demo_account2($error) {
	if ( defined('WORKUP_DEMO_MODE') && WORKUP_DEMO_MODE ) {
		$user_id = get_current_user_id();
		$user_obj = get_user_by('ID', $user_id);
		if ( strtolower($user_obj->data->user_login) == 'candidate' || strtolower($user_obj->data->user_login) == 'employer' ) {
			$error[] = esc_html__('Demo users are not allowed to modify information.', 'workup');
		}
	}
	return $error;
}
add_filter('wp-job-board-submission-validate', 'workup_check_demo_account2', 10, 2);
add_filter('wp-job-board-edit-validate', 'workup_check_demo_account2', 10, 2);

function workup_check_demo_account3($post_id, $prefix) {
	if ( defined('WORKUP_DEMO_MODE') && WORKUP_DEMO_MODE ) {
		$user_id = get_current_user_id();
		$user_obj = get_user_by('ID', $user_id);
		if ( strtolower($user_obj->data->user_login) == 'candidate' || strtolower($user_obj->data->user_login) == 'employer' ) {
			$_SESSION['messages'][] = array( 'danger', esc_html__('Demo users are not allowed to modify information.', 'workup') );
			$redirect_url = get_permalink( wp_job_board_get_option('edit_profile_page_id') );
			WP_Job_Board_Mixes::redirect( $redirect_url );
			exit();
		}
	}
}
add_action('wp-job-board-process-profile-before-change', 'workup_check_demo_account3', 10, 2);

function workup_check_demo_account5($post_id, $prefix) {
	if ( defined('WORKUP_DEMO_MODE') && WORKUP_DEMO_MODE ) {
		$user_id = get_current_user_id();
		$user_obj = get_user_by('ID', $user_id);
		if ( strtolower($user_obj->data->user_login) == 'candidate' || strtolower($user_obj->data->user_login) == 'employer' ) {
			$_SESSION['messages'][] = array( 'danger', esc_html__('Demo users are not allowed to modify information.', 'workup') );
			$redirect_url = get_permalink( wp_job_board_get_option('my_resume_page_id') );
			WP_Job_Board_Mixes::redirect( $redirect_url );
			exit();
		}
	}
}
add_action('wp-job-board-process-resume-before-change', 'workup_check_demo_account5', 10, 2);

function workup_check_demo_account4() {
	if ( defined('WORKUP_DEMO_MODE') && WORKUP_DEMO_MODE ) {
		$user_id = get_current_user_id();
		$user_obj = get_user_by('ID', $user_id);
		if ( strtolower($user_obj->data->user_login) == 'candidate' || strtolower($user_obj->data->user_login) == 'employer' ) {
			$return['msg'] = esc_html__('Demo users are not allowed to modify information.', 'workup');
			$return['status'] = false;
			echo json_encode($return); exit;
		}
	}
}
add_action('wp-private-message-before-reply-message', 'workup_check_demo_account4');
add_action('wp-private-message-before-add-message', 'workup_check_demo_account4');
add_action('wp-private-message-before-delete-message', 'workup_check_demo_account4');