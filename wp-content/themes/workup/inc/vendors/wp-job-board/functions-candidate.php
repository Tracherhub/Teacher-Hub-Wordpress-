<?php

function workup_get_candidates( $params = array() ) {
	$params = wp_parse_args( $params, array(
		'limit' => -1,
		'post_status' => 'publish',
		'get_candidates_by' => 'recent',
		'orderby' => '',
		'order' => '',
		'post__in' => array(),
		'fields' => null, // ids
		'author' => null,
		'categories' => array(),
		'locations' => array(),
	));
	extract($params);

	$query_args = array(
		'post_type'         => 'candidate',
		'posts_per_page'    => $limit,
		'post_status'       => $post_status,
		'orderby'       => $orderby,
		'order'       => $order,
	);

	$meta_query = array();
	switch ($get_candidates_by) {
		case 'recent':
			$query_args['orderby'] = 'date';
			$query_args['order'] = 'DESC';
			break;
		case 'featured':
			$meta_query[] = array(
				'key' => WP_JOB_BOARD_CANDIDATE_PREFIX.'featured',
	           	'value' => 'on',
	           	'compare' => '=',
			);
			break;
		case 'urgent':
			$meta_query[] = array(
				'key' => WP_JOB_BOARD_CANDIDATE_PREFIX.'urgent',
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
            'taxonomy'      => 'candidate_category',
            'field'         => 'slug',
            'terms'         => implode(",", $categories ),
            'operator'      => 'IN'
        );
    }
    if ( !empty($locations) ) {
    	$tax_query[] = array(
            'taxonomy'      => 'candidate_location',
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

if ( !function_exists('workup_candidate_content_class') ) {
	function workup_candidate_content_class( $class ) {
		$prefix = 'candidates';
		if ( is_singular( 'candidate' ) ) {
            $prefix = 'candidate';
        }
		if ( workup_get_config($prefix.'_fullwidth') ) {
			return 'container-fluid';
		}
		return $class;
	}
}
add_filter( 'workup_candidate_content_class', 'workup_candidate_content_class', 1 , 1 );

if ( !function_exists('workup_get_candidates_layout_configs') ) {
	function workup_get_candidates_layout_configs() {
		$layout_type = workup_get_config('candidates_archive_layout');
		switch ( $layout_type ) {
		 	case 'left-main':
		 		$configs['left'] = array( 'sidebar' => 'candidates-filter-sidebar', 'class' => 'col-md-3 col-sm-12 col-xs-12'  );
		 		$configs['main'] = array( 'class' => 'col-md-9 col-sm-12 col-xs-12' );
		 		break;
		 	case 'main-right':
		 	default:
		 		$configs['right'] = array( 'sidebar' => 'candidates-filter-sidebar',  'class' => 'col-md-3 col-sm-12 col-xs-12' ); 
		 		$configs['main'] = array( 'class' => 'col-md-9 col-sm-12 col-xs-12' );
		 		break;
	 		case 'main':
	 			$configs['main'] = array( 'class' => 'col-md-12 col-sm-12 col-xs-12' );
	 			break;
		}
		return $configs; 
	}
}

function workup_get_candidates_display_mode() {
	global $post;
	if ( is_page() && is_object($post) ) {
		$columns = get_post_meta( $post->ID, 'apus_page_candidates_display_mode', true );
	}
	if ( empty($columns) ) {
		$columns = workup_get_config('candidates_display_mode', 3);
	}
	return apply_filters( 'workup_get_candidates_columns', $columns );
}

function workup_get_candidates_columns() {
	global $post;
	if ( is_page() && is_object($post) ) {
		$columns = get_post_meta( $post->ID, 'apus_page_candidates_columns', true );
	}
	if ( empty($columns) ) {
		$columns = workup_get_config('candidates_columns', 3);
	}
	return apply_filters( 'workup_get_candidates_columns', $columns );
}

function workup_get_candidate_layout_type() {
	return 'v1';
}

function workup_get_candidates_pagination() {
	global $post;
	if ( is_page() && is_object($post) ) {
		$pagination = get_post_meta( $post->ID, 'apus_page_candidates_pagination', true );
	}
	if ( empty($pagination) ) {
		$pagination = workup_get_config('candidates_pagination', 'default');
	}
	return apply_filters( 'workup_get_candidates_pagination', $pagination );
}


// post per page
add_filter('wp-job-board-candidate-filter-query', 'workup_candidate_filter_query', 10, 2);
function workup_candidate_filter_query( $query, $params) {
	$query_vars = &$query->query_vars;
	$query_vars['posts_per_page'] = workup_candidate_get_limit_number();
	$query->query_vars = $query_vars;
	
	return $query;
}

add_filter( 'wp-job-board-candidate-query-args', 'workup_candidate_filter_query_args', 10, 2 );
function workup_candidate_filter_query_args($query_args, $params) {
	$query_args['posts_per_page'] = workup_candidate_get_limit_number();
	return $query_args;
}

function workup_candidate_get_limit_number() {
	if ( isset( $_REQUEST['candidates_ppp'] ) ) {
        $number = intval( $_REQUEST['candidates_ppp'] );
    } elseif ( !empty($_COOKIE['candidates_per_page']) ) {
        $number = intval( $_COOKIE['candidates_per_page'] );
    } else {
        $value = wp_job_board_get_option('number_candidates_per_page', 10);
        $number = intval( $value );
    }
    return $number;
}

add_action('init', 'workup_candidate_save_ppp');
function workup_candidate_save_ppp() {
	if ( !empty( $_REQUEST['candidates_ppp'] ) ) {
        $number = intval( $_REQUEST['candidates_ppp'] );
        setcookie('candidates_per_page', $number, time() + 864000);
        $_COOKIE['candidates_per_page'] = $number;
    }
}

function workup_candidate_check_hidden_review() {
	$view = wp_job_board_get_option('candidates_restrict_review', 'all');
	if ( $view == 'always_hidden' ) {
		return false;
	}
	return true;
}