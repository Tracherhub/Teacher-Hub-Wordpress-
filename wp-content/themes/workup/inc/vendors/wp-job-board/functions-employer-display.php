<?php

function workup_employer_display_logo($post) {
	?>
    <div class="employer-logo text-center">
        <a href="<?php echo esc_url( get_permalink($post) ); ?>">
        	<?php if ( has_post_thumbnail($post->ID) ) { ?>
                <?php echo get_the_post_thumbnail( $post->ID, 'thumbnail' ); ?>
            <?php } else { ?>
            	<img src="<?php echo esc_url(workup_placeholder_img_src()); ?>" alt="<?php echo esc_attr(get_the_title($post->ID)); ?>">
            <?php } ?>
        </a>
    </div>
    <?php
}

function workup_employer_display_full_location($post,$display_type = 'normal') {
	$location = WP_Job_Board_Employer::get_post_meta( $post->ID, 'address', true );
	if ( empty($location) ) {
		$location = WP_Job_Board_Employer::get_post_meta( $post->ID, 'map_location_address', true );
	}
	if($display_type == 'icon'){
		$icon = '<i class="flaticon-location-pin"></i>';
	}else{
		$icon = '';
	}
	if ( $location ) {
		?>
		<div class="job-location"><?php echo trim($icon); ?><?php echo wp_kses_post($location); ?></div>
		<?php
    }
}

function workup_employer_display_open_position($post) {
	$user_id = WP_Job_Board_User::get_user_by_employer_id($post->ID);
	$args = array(
	        'post_type' => 'job_listing',
	        'post_per_page' => -1,
	        'post_status' => 'publish',
	        'fields' => 'ids',
	        'author' => $user_id
	    );
	$jobs = WP_Job_Board_Query::get_posts($args);
	$count_jobs = $jobs->found_posts;
	
	?>
	<div class="open-job">
        <?php echo sprintf(_n('<span>%d</span> Open Job', '<span>%d</span> Open Jobs', intval($count_jobs), 'workup'), intval($count_jobs)); ?>
    </div>
    <?php
}

function workup_employer_display_nb_jobs($post) {
	$user_id = WP_Job_Board_User::get_user_by_employer_id($post->ID);
	$args = array(
	        'post_type' => 'job_listing',
	        'post_per_page' => -1,
	        'post_status' => 'publish',
	        'fields' => 'ids',
	        'author' => $user_id
	    );
	$jobs = WP_Job_Board_Query::get_posts($args);
	$count_jobs = $jobs->found_posts;
	
	?>
	<div class="nb-job">
        <?php echo sprintf(_n('<span class="text-red">%d</span> <span class="text">Job</span>', '<span class="text-red">%d</span> <span class="text">Jobs</span>', intval($count_jobs), 'workup'), intval($count_jobs)); ?>
    </div>
    <?php
}

function workup_employer_display_nb_reviews($post) {
	if ( workup_check_employer_candidate_review($post) ) {
		$employer_id = $post->ID;
		$total_reviews = WP_Job_Board_Review::get_total_reviews($employer_id);
		$total_reviews_display = $total_reviews ? WP_Job_Board_Mixes::format_number($total_reviews) : 0;
		?>
		<div class="nb_reviews">
	        <?php echo sprintf(_n('<span class="text-green">%d</span> <span class="text">Review</span>', '<span class="text-green">%d</span> <span class="text">Reviews</span>', intval($total_reviews), 'workup'), $total_reviews_display); ?>
	    </div>
	    <?php
	}
}

function workup_employer_display_nb_views($post) {
	$employer_id = $post->ID;
	$views = WP_Job_Board_Employer::get_post_meta($employer_id, 'views_count', true);
	$views_display = $views ? WP_Job_Board_Mixes::format_number($views) : 0;
	?>
	<div class="nb_views">
        <?php echo sprintf(_n('<span class="text-blue">%d</span> <span class="text">View</span>', '<span class="text-blue">%d</span> <span class="text">Views</span>', intval($views), 'workup'), $views_display); ?>
    </div>
    <?php
}

function workup_employer_display_featured_icon($post) {
	$featured = WP_Job_Board_Employer::get_post_meta( $post->ID, 'featured', true );
	if ( $featured ) { ?>
        <span class="featured" data-toggle="tooltip" title="<?php esc_attr_e('featured', 'workup'); ?>"><i class="fa fa-star"></i></span>
    <?php }
}

function workup_employer_display_phone($employer_id, $echo = true) {
	$post = get_post($employer_id);
	$phone = WP_Job_Board_Employer::get_display_phone( $post );
	ob_start();
	if ( $phone ) {
		?>
		<div class="job-phone"><i class="fa fa-phone"></i> <?php echo wp_kses_post($phone); ?></div>
		<?php
    }
    $output = ob_get_clean();
    if ( $echo ) {
    	echo wp_kses_post($output);
    } else {
    	return $output;
    }
}

function workup_employer_display_email($employer_id, $echo = true) {
	$post = get_post($employer_id);
	$email = WP_Job_Board_Employer::get_display_email( $post );
	ob_start();
	if ( $email ) {
		?>
		<div class="job-email"><i class="ti-email"></i> <?php echo wp_kses_post($email); ?></div>
		<?php
    }
    $output = ob_get_clean();
    if ( $echo ) {
    	echo wp_kses_post($output);
    } else {
    	return $output;
    }
}
function workup_employer_display_category($employer_id, $display_type = 'no-title') {
	$categories = get_the_terms( $employer_id, 'employer_category' );
	if ( $categories ) {
		?>
		<?php if($display_type == "icon"){ ?> 
			<div class="job-category">
				<i class="ti-home"></i>
				<?php
				foreach ($categories as $term) {
					?>
		            	<a class="category-employer" href="<?php echo get_term_link($term); ?>"><?php echo esc_html($term->name); ?></a>
		        	<?php
		    	} ?>
	    	</div>
		<?php } else { ?>
			<div class="job-category">
				<?php
				foreach ($categories as $term) {
					?>
		            	<a class="category-employer" href="<?php echo get_term_link($term); ?>"><?php echo esc_html($term->name); ?></a>
		        	<?php
		    	} ?>
	    	</div>
    	<?php } ?>
    	<?php
    }
}

function workup_employer_display_follow_btn($employer_id) {
	if ( WP_Job_Board_Candidate::check_following($employer_id) ) {
		$classes = 'btn-unfollow-employer';
		$nonce = wp_create_nonce( 'wp-job-board-unfollow-employer-nonce' );
		$text = esc_html__('Following', 'workup');
	} else {
		$classes = 'btn-follow-employer';
		$nonce = wp_create_nonce( 'wp-job-board-follow-employer-nonce' );
		$text = esc_html__('Follow us', 'workup');
	}
	?>
	<a href="javascript:void(0)" class="btn-loading btn button btn-theme <?php echo esc_attr($classes); ?>" data-employer_id="<?php echo esc_attr($employer_id); ?>" data-nonce="<?php echo esc_attr($nonce); ?>"><i class="ti-plus pre"></i><span><?php echo esc_html($text); ?></span></a>
	<?php
}


// Employer Archive hooks
function workup_employer_display_per_page_form($wp_query) {
    $total              = $wp_query->found_posts;
    $per_page           = $wp_query->get( 'posts_per_page' );
    $_per_page          = wp_job_board_get_option('number_employers_per_page', 12);

    // Generate per page options
    $products_per_page_options = array();
    while ( $_per_page < $total ) {
        $products_per_page_options[] = $_per_page;
        $_per_page = $_per_page * 2;
    }

    if ( empty( $products_per_page_options ) ) {
        return;
    }

    $products_per_page_options[] = -1;

    ?>
    <form method="POST" action="<?php echo esc_url(WP_Job_Board_Mixes::get_employers_page_url()); ?>" class="form-workup-ppp">
        
    	<select name="employers_ppp" onchange="this.form.submit()">
            <?php foreach( $products_per_page_options as $key => $value ) { ?>
                <option value="<?php echo esc_attr( $value ); ?>" <?php selected( $value, $per_page ); ?>>
                	<?php
                		if ( $value == -1 ) {
                			esc_html_e( 'All', 'workup' );
                		} else {
                			echo sprintf( esc_html__( '%s Per Page', 'workup' ), $value );
                		}
                	?>
                </option>
            <?php } ?>
        </select>

        <input type="hidden" name="paged" value="1" />
		<?php WP_Job_Board_Mixes::query_string_form_fields( null, array( 'employers_ppp', 'submit', 'paged' ) ); ?>
    </form>
    <?php
}

add_action( 'wp_job_board_before_employer_archive', 'workup_employer_display_per_page_form', 26 );