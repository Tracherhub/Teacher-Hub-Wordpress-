<?php

function workup_candidate_display_logo($post) {
	?>
    <div class="candidate-logo text-center">
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

function workup_candidate_display_categories($post, $display_type = 'no-icon') {
	$categories = get_the_terms( $post->ID, 'candidate_category' );
	if ( $categories ) {
		?>
		<div class="candidate-category">
			<?php if ($display_type == 'icon') { ?>
					<i class="ti-home"></i>
			<?php } ?>
            <?php $i=1; foreach ($categories as $term) { ?>
                <a href="<?php echo get_term_link($term); ?>"><?php echo wp_kses_post($term->name); ?></a><?php echo esc_html( $i < count($categories) ? ', ' : '' ); ?>
            <?php $i++; } ?>
        </div>
		<?php
    }
}

function workup_candidate_display_short_location($post) {
	$locations = get_the_terms( $post->ID, 'candidate_location' );
	if ( $locations ) {
		?>
		<div class="candidate-location">
            <i class="flaticon-location-pin"></i>
            <?php $i=1; foreach ($locations as $term) { ?>
                <a href="<?php echo get_term_link($term); ?>"><?php echo wp_kses_post($term->name); ?></a><?php echo esc_html( $i < count($locations) ? ', ' : '' ); ?>
            <?php $i++; } ?>
        </div>
		<?php
    }
}

function workup_candidate_display_full_location($post, $display_type = 'no-icon-title', $echo = true) {
	$location = WP_Job_Board_Candidate::get_post_meta( $post->ID, 'address', true );
	if ( empty($location) ) {
		$location = WP_Job_Board_Candidate::get_post_meta( $post->ID, 'map_location_address', true );
	}
	ob_start();
	if ( $location ) {
		
		if ( $display_type == 'icon' ) {
			?>
			<div class="candidate-location with-icon"><i class="ti-location-pin"></i> <?php echo wp_kses_post($location); ?></div>
			<?php
		} elseif ( $display_type == 'title' ) {
			?>
			<div class="candidate-location with-title">
				<strong><?php esc_html_e('Location:', 'workup'); ?></strong> <span><?php echo wp_kses_post($location); ?></span>
			</div>
			<?php
		} else {
			?>
			<div class="candidate-location"><?php echo wp_kses_post($location); ?></div>
			<?php
		}
    }
    $output = ob_get_clean();
    if ( $echo ) {
    	echo wp_kses_post($output);
    } else {
    	return $output;
    }
}

function workup_candidate_display_job_title($post) {
	$job_title = WP_Job_Board_Candidate::get_post_meta( $post->ID, 'job_title', true );
	if ( $job_title ) { ?>
        <div class="candidate-job">
            <?php echo wp_kses_post($job_title); ?>
        </div>
    <?php }
}

function workup_candidate_display_featured_icon($post) {
	$featured = WP_Job_Board_Candidate::get_post_meta( $post->ID, 'featured', true );
	if ( $featured ) { ?>
        <span class="featured" data-toggle="tooltip" title="<?php esc_attr_e('featured', 'workup'); ?>"><i class="fa fa-star"></i></span>
    <?php }
}

function workup_candidate_display_urgent_icon($post) {
	$urgent = WP_Job_Board_Candidate::get_post_meta( $post->ID, 'urgent', true );
	if ( $urgent ) { ?>
        <span class="urgent"><?php esc_html_e('Urgent', 'workup'); ?></span>
    <?php }
}

function workup_candidate_display_phone($post, $echo = true) {
	$phone = WP_Job_Board_Candidate::get_display_phone( $post->ID );
	ob_start();
	if ( $phone ) { ?>
        <div class="candidate-phone"><i class="ti-mobile"></i><?php echo wp_kses_post($phone); ?></div>
    <?php }
    $output = ob_get_clean();
    if ( $echo ) {
    	echo wp_kses_post($output);
    } else {
    	return $output;
    }
}

function workup_candidate_display_email($post, $echo = true) {
	$email = WP_Job_Board_Candidate::get_display_email( $post->ID );
	ob_start();
	if ( $email ) { ?>
        <div class="candidate-email"><i class="ti-email"></i><?php echo wp_kses_post($email); ?></div>
    <?php }
    $output = ob_get_clean();
    if ( $echo ) {
    	echo wp_kses_post($output);
    } else {
    	return $output;
    }
}

function workup_candidate_display_salary($post, $display_type = 'no-icon-title', $echo = true) {
	$salary = WP_Job_Board_Candidate::get_salary_html($post->ID);
	ob_start();
	if ( $salary ) {
		if ( $display_type == 'icon' ) {
			?>
			<div class="candidate-salary with-icon"><i class="ti-credit-card"></i> <?php echo wp_kses_post($salary); ?></div>
			<?php
		} elseif ( $display_type == 'title' ) {
			?>
			<div class="candidate-salary with-title">
				<strong><?php esc_html_e('Salary:', 'workup'); ?></strong> <span><?php echo wp_kses_post($salary); ?></span>
			</div>
			<?php
		} else {
			?>
			<div class="candidate-salary"><?php echo wp_kses_post($salary); ?></div>
			<?php
		}
    }
    $output = ob_get_clean();
    if ( $echo ) {
    	echo wp_kses_post($output);
    } else {
    	return $output;
    }
}

function workup_candidate_display_birthday($post, $display_type = 'no-icon-title', $echo = true) {
	$birthday = WP_Job_Board_Candidate::get_post_meta($post->ID, 'founded_date', true);
	ob_start();
	if ( $birthday ) {
		$birthday = strtotime($birthday);
		$birthday = date(get_option('date_format'), $birthday);
		if ( $display_type == 'icon' ) {
			?>
			<div class="candidate-birthday with-icon"><i class="ti-shield"></i> <?php echo wp_kses_post($birthday); ?></div>
			<?php
		} elseif ( $display_type == 'title' ) {
			?>
			<div class="candidate-birthday with-title">
				<strong><?php esc_html_e('Birthday:', 'workup'); ?></strong> <span><?php echo wp_kses_post($birthday); ?></span>
			</div>
			<?php
		} else {
			?>
			<div class="candidate-birthday"><?php echo wp_kses_post($birthday); ?></div>
			<?php
		}
    }
    $output = ob_get_clean();
    if ( $echo ) {
    	echo wp_kses_post($output);
    } else {
    	return $output;
    }
}

function workup_candidate_display_shortlist_btn($post) {
	if ( WP_Job_Board_Employer::check_added_shortlist($post->ID) ) {
        $classes = 'btn-action-job added btn-added-candidate-shortlist';
        $nonce = wp_create_nonce( 'wp-job-board-remove-candidate-shortlist-nonce' );
        $text = esc_html__('Shortlisted', 'workup');
    } else {
        $classes = 'btn-action-job btn-add-candidate-shortlist';
        $nonce = wp_create_nonce( 'wp-job-board-add-candidate-shortlist-nonce' );
        $text = esc_html__('Shortlist', 'workup');
    }
    ?>
    <a title="<?php echo esc_attr($text); ?>" href="javascript:void(0);" class="<?php echo esc_attr($classes); ?>" data-candidate_id="<?php echo esc_attr($post->ID); ?>" data-nonce="<?php echo esc_attr($nonce); ?>"><i class="fa fa-heart"></i></a>
    <?php
}



// Cndidate Archive hooks
function workup_candidate_display_per_page_form($wp_query) {
    $total              = $wp_query->found_posts;
    $per_page           = $wp_query->get( 'posts_per_page' );
    $_per_page          = wp_job_board_get_option('number_candidates_per_page', 12);

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
    <form method="POST" action="<?php echo esc_url(WP_Job_Board_Mixes::get_candidates_page_url()); ?>" class="form-workup-ppp">
        
    	<select name="candidates_ppp" onchange="this.form.submit()">
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
		<?php WP_Job_Board_Mixes::query_string_form_fields( null, array( 'candidates_ppp', 'submit', 'paged' ) ); ?>
    </form>
    <?php
}

remove_action( 'wp_job_board_before_candidate_archive', array( 'WP_Job_Board_Candidate', 'display_candidates_count_results' ), 10 );
remove_action( 'wp_job_board_before_candidate_archive', array( 'WP_Job_Board_Candidate', 'display_candidates_alert_form' ), 20 );

add_action( 'wp_job_board_before_candidate_archive', array( 'WP_Job_Board_Candidate', 'display_candidates_count_results' ), 20 );
add_action( 'wp_job_board_before_candidate_archive', 'workup_candidate_display_per_page_form', 26 );