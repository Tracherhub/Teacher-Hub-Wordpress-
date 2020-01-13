<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
wp_enqueue_script('select2');
wp_enqueue_style('select2');
?>
<div class="widget box-dashboard-wrapper">
	<div class="inner-list">
		<h3 class="title"><?php echo esc_html__('Applied Jobs','workup') ?></h3>
		<div class="search-orderby-wrapper flex-middle-sm">
			<div class="search-jobs-applied-form widget-search">
				<form action="" method="get">
					<div class="input-group">
						<input type="text" placeholder="<?php esc_attr_e( 'Search ...', 'workup' ); ?>" class="form-control" name="search" value="<?php echo esc_attr(isset($_GET['search']) ? $_GET['search'] : ''); ?>">
						<span class="input-group-btn">
							<button class="search-submit btn btn-sm btn-search" name="submit">
								<i class="flaticon-magnifying-glass"></i>
							</button>
						</span>
					</div>
					<input type="hidden" name="paged" value="1" />
				</form>
			</div>
			<div class="sort-jobs-applied-form sortby-form">
				<?php
					$orderby_options = apply_filters( 'wp_job_board_my_jobs_orderby', array(
						'menu_order'	=> esc_html__( 'Default', 'workup' ),
						'newest' 		=> esc_html__( 'Newest', 'workup' ),
						'oldest'     	=> esc_html__( 'Oldest', 'workup' ),
					) );

					$orderby = isset( $_GET['orderby'] ) ? wp_unslash( $_GET['orderby'] ) : 'newest'; 
				?>

				<div class="orderby-wrapper flex-middle">
					<span class="text-sort">
						<?php echo esc_html__('Sort by: ','workup'); ?>
					</span>
					<form class="my-jobs-ordering" method="get">
						<select name="orderby" class="orderby">
							<?php foreach ( $orderby_options as $id => $name ) : ?>
								<option value="<?php echo esc_attr( $id ); ?>" <?php selected( $orderby, $id ); ?>><?php echo esc_html( $name ); ?></option>
							<?php endforeach; ?>
						</select>
						<input type="hidden" name="paged" value="1" />
						<?php WP_Job_Board_Mixes::query_string_form_fields( null, array( 'orderby', 'submit', 'paged' ) ); ?>
					</form>
				</div>
			</div>
		</div>
		<?php if ( !empty($applicants) && !empty($applicants->posts) ) {

			foreach ($applicants->posts as $applicant_id) {
				$job_id = get_post_meta($applicant_id, WP_JOB_BOARD_APPLICANT_PREFIX.'job_id', true);
				$post = get_post($job_id);


				$author_id = $post->post_author;
				$employer_id = WP_Job_Board_User::get_employer_by_user_id($author_id);
				$types = get_the_terms( $post->ID, 'job_listing_type' );
				$category = get_the_terms( $post->ID, 'job_listing_category' );
				$address = get_post_meta( $post->ID, WP_JOB_BOARD_JOB_LISTING_PREFIX . 'address', true );
				$salary = WP_Job_Board_Job_Listing::get_salary_html($post->ID);

				?>

				<?php do_action( 'wp_job_board_before_job_content', $post->ID ); ?>

				<article <?php post_class('job-applied-wrapper job-list-small'); ?>>
					<div class="flex-middle">
						<?php if ( has_post_thumbnail($employer_id) ) { ?>
					        <div class="employer-logo">
					            <?php echo get_the_post_thumbnail( $employer_id, 'thumbnail' ); ?>
					        </div>
					    <?php } ?>
					    <div class="job-information flex-middle-sm">
					    	<div class="inner">
						        <h2 class="job-title">
						        	<a href="<?php echo esc_url(get_permalink($job_id)); ?>" rel="bookmark"><?php echo get_the_title($job_id); ?></a>
						        </h2>
						        
						        <div class="job-metas">
						        	<span class="job-date-author hidden-xs">
							        	<i class="ti-time"></i>
							            <?php echo sprintf(esc_html__(' posted %s ago', 'workup'), human_time_diff(get_the_time('U', $job_id), current_time('timestamp')) ); ?>
							        </span>
						        	<?php if ( $category ) { ?>
						        		<div class="category-job">
						        			<i class="ti-home"></i>
								            <?php foreach ($category as $term) { ?>
								                <a href="<?php echo get_term_link($term); ?>"><?php echo wp_kses_post($term->name); ?></a>
								                <?php break; ?>
								            <?php } ?>
							            </div>
							        <?php } ?>
						            <?php if ( $address ) { ?>
						                <div class="location"><i class="flaticon-location-pin"></i><?php echo wp_kses_post($address); ?></div>
						            <?php } ?>
						            <?php if ( $salary ) { ?>
						                <div class="job-salary"><i class="flaticon-price"></i><?php echo wp_kses_post($salary); ?></div>
						            <?php } ?>
						        </div>
						        <div class="hidden-xs"><?php workup_job_display_tags($post, 'title'); ?></div>
					    	</div>
					    	<div class="ali-right">
					    		<a href="javascript:void(0)" class="btn-remove-job-applied btn-action-icon deleted" data-applicant_id="<?php echo esc_attr($applicant_id); ?>" data-nonce="<?php echo esc_attr(wp_create_nonce( 'wp-job-board-remove-applied-nonce' )); ?>"><i class="ti-close"></i></a>
					    	</div>
					    	
						</div>
					</div>
					<div class="mobile-bottom visible-xs">
						<?php workup_job_display_tags($post, 'title'); ?>
			    	</div>
				</article><!-- #post-## -->

				<?php do_action( 'wp_job_board_after_job_content', $post->ID );

			}

			WP_Job_Board_Mixes::custom_pagination( array(
				'wp_query' => $applicants,
				'max_num_pages' => $applicants->max_num_pages,
				'prev_text'     => esc_html__( 'Previous page', 'workup' ),
				'next_text'     => esc_html__( 'Next page', 'workup' ),
			));
		?>

		<?php } else { ?>
			<div class="not-found"><?php esc_html_e('No apply found.', 'workup'); ?></div>
		<?php } ?>
	</div>
</div>