<?php

function workup_job_display_employer_logo($post, $link = true) {
	$author_id = $post->post_author;
	$employer_id = WP_Job_Board_User::get_employer_by_user_id($author_id);

	?>
    <div class="employer-logo text-center">
    	<?php if ( $link ) { ?>
        	<a href="<?php echo esc_url( get_permalink($post) ); ?>">
        <?php } ?>
        		<?php if ( has_post_thumbnail($employer_id) ) { ?>
            		<?php echo get_the_post_thumbnail( $employer_id, 'thumbnail' ); ?>
            	<?php } else { ?>
            		<img src="<?php echo esc_url(workup_placeholder_img_src()); ?>" alt="<?php echo esc_attr(get_the_title($employer_id)); ?>">
            	<?php } ?>
        <?php if ( $link ) { ?>
        	</a>
        <?php } ?>
    </div>
    <?php
}

function workup_job_display_employer_title($post, $display_type = 'no-icon') {
	$author_id = $post->post_author;
	$employer_id = WP_Job_Board_User::get_employer_by_user_id($author_id);
	if ( $employer_id ) {
		?>
	        <h3 class="employer-title">
	            <a href="<?php echo esc_url( get_permalink($post) ); ?>">
	            	<?php if ($display_type == 'icon') { ?>
							<i class="ti-home"></i>
					<?php } ?>
	                <?php echo get_the_title( $employer_id ); ?>
	            </a>
	        </h3>
	    <?php
	}
}

function workup_job_display_job_category($post, $display_category = 'no-title') {
	$categories = get_the_terms( $post->ID, 'job_listing_category' );
	if ( $categories ) {
		?>
		<div class="category-job">
			<?php
			if ( $display_category == 'title' ) {
				?>
				<div class="job-category with-title">
					<strong><?php esc_html_e('Job Type:', 'workup'); ?></strong>
				<?php
			} elseif ($display_category == 'icon') {
				?>
				<div class="job-category with-icon">
					<i class="ti-home"></i>
			<?php
			} else {
				?>
				<div class="job-category">
				<?php
			}
				foreach ($categories as $term) {
					$color = get_term_meta( $term->term_id, '_color', true );
					$style = '';
					if ( $color ) {
						$style = 'color: '.$color;
					}
					?>
		            	<a class="category-job" href="<?php echo get_term_link($term); ?>" style="<?php echo esc_attr($style); ?>"><?php echo esc_html($term->name); ?></a>
		        	<?php
		    	}
	    	?>
	    	</div>
	    </div>
    	<?php
    }
}

function workup_job_display_job_type($post, $display_type = 'no-title', $echo = true) {
	$types = get_the_terms( $post->ID, 'job_listing_type' );
	ob_start();
	if ( $types ) {
		?>
		<div class="job-type">
			<?php
			if ( $display_type == 'title' ) {
				?>
				<div class="job-type with-title">
					<strong><?php esc_html_e('Job Type:', 'workup'); ?></strong>
				<?php
			} elseif ($display_type == 'icon') {
				?>
				<div class="job-type with-icon">
					<i class="ti-calendar"></i>
			<?php
			} else {
				?>
				<div class="job-type with-title">
				<?php
			}
				foreach ($types as $term) {
					$color = get_term_meta( $term->term_id, '_color', true );
					$style = '';
					if ( $color ) {
						$style = 'color: '.$color;
					}
					?>
		            	<a class="type-job" href="<?php echo get_term_link($term); ?>" style="<?php echo esc_attr($style); ?>"><?php echo esc_html($term->name); ?></a>
		        	<?php
		    	}
	    	?>
	    	</div>
	    </div>
    	<?php
    }
    $output = ob_get_clean();
    if ( $echo ) {
    	echo wp_kses_post($output);
    } else {
    	return $output;
    }
}

function workup_job_display_tags($post, $display_type = 'no-title') {
	$tags = get_the_terms( $post->ID, 'job_listing_tag' );
	if ( $tags ) {
		?>
		<div class="job-tags">
			<?php
			if ( $display_type == 'title' ) {
				?>
				<div class="job-tags with-title">
				<strong><?php esc_html_e('Tagged as:', 'workup'); ?></strong>
				<?php
			} else {
				?>
				<div class="job-tags with-title">
				<?php
			}
				foreach ($tags as $term) {
					?>
		            	<a class="tag-job" href="<?php echo get_term_link($term); ?>"><?php echo esc_html($term->name); ?></a>
		        	<?php
		    	}
	    	?>
	    	</div>
	    </div>
    	<?php
    }
}

function workup_job_display_short_location($post, $echo = true) {
	$locations = get_the_terms( $post->ID, 'job_listing_location' );
	ob_start();
	if ( $locations ) {
		?>
		<div class="job-location">
            <i class="flaticon-location-pin"></i>
            <?php $i=1; foreach ($locations as $term) { ?>
                <a href="<?php echo get_term_link($term); ?>"><?php echo wp_kses_post($term->name); ?></a><?php echo esc_html( $i < count($locations) ? ', ' : '' ); ?>
            <?php $i++; } ?>
        </div>
		<?php
    }
    $output = ob_get_clean();
    if ( $echo ) {
    	echo wp_kses_post($output);
    } else {
    	return $output;
    }
}

function workup_job_display_full_location($post, $display_type = 'no-icon-title') {
	$location = WP_Job_Board_Job_Listing::get_post_meta( $post->ID, 'address', true );
	if ( empty($location) ) {
		$location = WP_Job_Board_Job_Listing::get_post_meta( $post->ID, 'map_location_address', true );
	}
	if ( $location ) {
		if ( $display_type == 'icon' ) {
			?>
			<div class="job-location with-icon"><i class="ti-location-pin"></i> <?php echo wp_kses_post($location); ?></div>
			<?php
		} elseif ( $display_type == 'title' ) {
			?>
			<div class="job-location with-title">
				<strong><?php esc_html_e('Location:', 'workup'); ?></strong> <?php echo wp_kses_post($location); ?>
			</div>
			<?php
		} else {
			?>
			<div class="job-location"><?php echo wp_kses_post($location); ?></div>
			<?php
		}
    }
}

function workup_job_display_salary($post, $display_type = 'no-icon-title', $echo = true) {
	$salary = WP_Job_Board_Job_Listing::get_salary_html($post->ID);
	ob_start();
	if ( $salary ) {
		if ( $display_type == 'icon' ) {
			?>
			<div class="job-salary with-icon"><i class="ti-credit-card"></i> <?php echo wp_kses_post($salary); ?></div>
			<?php
		} elseif ( $display_type == 'title' ) {
			?>
			<div class="job-salary with-title">
				<strong><?php esc_html_e('Salary:', 'workup'); ?></strong> <span><?php echo wp_kses_post($salary); ?></span>
			</div>
			<?php
		} else {
			?>
			<div class="job-salary"><?php echo wp_kses_post($salary); ?></div>
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

function workup_job_display_add_shortlist_btn($post) {
    if ( WP_Job_Board_Candidate::check_added_shortlist($post->ID) ) {
        $classes = 'btn-action-job added btn-added-job-shortlist';
        $nonce = wp_create_nonce( 'wp-job-board-remove-job-shortlist-nonce' );
    } else {
        $classes = 'btn-action-job btn-add-job-shortlist';
        $nonce = wp_create_nonce( 'wp-job-board-add-job-shortlist-nonce' );
    }
    ?>
    <div class="wrapper-shortlist">
        <a href="javascript:void(0);" class="<?php echo esc_attr($classes); ?>" data-job_id="<?php echo esc_attr($post->ID); ?>" data-nonce="<?php echo esc_attr($nonce); ?>"><i class="fa fa-heart"></i></a>
    </div>
    <?php
}


function workup_job_display_deadline($post, $display_type = 'no-icon-title', $echo = true) {

	$application_deadline_date = WP_Job_Board_Job_Listing::get_post_meta( $post->ID, 'application_deadline_date', true );
	ob_start();
	if ( empty($application_deadline_date) || strtotime($application_deadline_date) >= strtotime('now') ) {
		if ( $application_deadline_date ) {
			$deadline_date = strtotime($application_deadline_date);
			?>
			<div class="deadline-time"><?php echo date(get_option('date_format'), $deadline_date); ?></div>
			<?php
		}
	} else {
		?>
		<div class="deadline-closed"><?php esc_html_e('Application deadline closed.', 'workup'); ?></div>
		<?php
	}
	$ouput = ob_get_clean();

	ob_start();
	if ( $display_type == 'icon' ) {
		?>
		<div class="job-deadline with-icon"><i class="ti-credit-card"></i> <?php echo wp_kses_post($ouput); ?></div>
		<?php
	} elseif ( $display_type == 'title' ) {
		?>
		<div class="job-deadline with-title">
			<strong><?php esc_html_e('Deadline date:', 'workup'); ?></strong> <?php echo wp_kses_post($ouput); ?>
		</div>
		<?php
	} else {
		?>
		<div class="job-deadline"><?php echo wp_kses_post($ouput); ?></div>
		<?php
	}
	$output = ob_get_clean();
    if ( $echo ) {
    	echo wp_kses_post($output);
    } else {
    	return $output;
    }
}

function workup_job_display_postdate($post, $display_type = 'no-icon-title', $echo = true) {

	ob_start();
	if ( $display_type == 'icon' ) {
		?>
		<div class="job-deadline with-icon"><i class="ti-credit-card"></i> <?php the_time(get_option('date_format')); ?></div>
		<?php
	} elseif ( $display_type == 'title' ) {
		?>
		<div class="job-deadline with-title">
			<strong><?php esc_html_e('Deadline date:', 'workup'); ?></strong> <?php the_time(get_option('date_format')); ?>
		</div>
		<?php
	} else {
		?>
		<div class="job-deadline"><?php the_time(get_option('date_format')); ?></div>
		<?php
	}
	$output = ob_get_clean();
    if ( $echo ) {
    	echo wp_kses_post($output);
    } else {
    	return $output;
    }
}

function workup_job_display_featured_icon($post) {
	$featured = WP_Job_Board_Job_Listing::get_post_meta( $post->ID, 'featured', true );
	if ( $featured ) { ?>
        <span class="featured" data-toggle="tooltip" title="<?php esc_attr_e('featured', 'workup'); ?>"><i class="fa fa-star"></i></span>
    <?php }
}

function workup_job_display_urgent_icon($post) {
	$urgent = WP_Job_Board_Job_Listing::get_post_meta( $post->ID, 'urgent', true );
	if ( $urgent ) { ?>
        <span class="urgent"><?php esc_html_e('Urgent', 'workup'); ?></span>
    <?php }
}

function workup_job_item_map_meta($post) {
	$latitude = WP_Job_Board_Job_Listing::get_post_meta( $post->ID, 'map_location_latitude', true );
	$longitude = WP_Job_Board_Job_Listing::get_post_meta( $post->ID, 'map_location_longitude', true );
	
	echo 'data-latitude="'.esc_attr($latitude).'" data-longitude="'.esc_attr($longitude).'"';
}




// Job Archive hooks

function workup_job_display_per_page_form($wp_query) {
    $total              = $wp_query->found_posts;
    $per_page           = $wp_query->get( 'posts_per_page' );
    $_per_page          = wp_job_board_get_option('number_jobs_per_page', 12);

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
    <form method="POST" action="<?php echo esc_url(WP_Job_Board_Mixes::get_jobs_page_url()); ?>" class="form-workup-ppp">
        
    	<select name="jobs_ppp" onchange="this.form.submit()">
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
		<?php WP_Job_Board_Mixes::query_string_form_fields( null, array( 'jobs_ppp', 'submit', 'paged' ) ); ?>
    </form>
    <?php
}

remove_action( 'wp_job_board_before_job_archive', array( 'WP_Job_Board_Job_Listing', 'display_jobs_count_results' ), 10 );
remove_action( 'wp_job_board_before_job_archive', array( 'WP_Job_Board_Job_Listing', 'display_jobs_alert_form' ), 20 );

add_action( 'wp_job_board_before_job_archive', array( 'WP_Job_Board_Job_Listing', 'display_jobs_count_results' ), 20 );
add_action( 'wp_job_board_before_job_archive', 'workup_job_display_per_page_form', 26 );