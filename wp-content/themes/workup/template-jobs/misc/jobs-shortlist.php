<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
wp_enqueue_script('select2');
wp_enqueue_style('select2');
?>
<div class="widget box-dashboard-wrapper">
	<div class="inner-list">
		<h3 class="widget-title"><?php echo esc_html__('Jobs Shortlist','workup') ?></h3>

		<div class="search-orderby-wrapper flex-middle-sm">
			<div class="search-jobs-shortlist-form widget-search">
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
			<div class="sort-jobs-shortlist-form sortby-form">
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

		<?php
		if ( !empty($job_ids) && is_array($job_ids) ) {
			if ( get_query_var( 'paged' ) ) {
			    $paged = get_query_var( 'paged' );
			} elseif ( get_query_var( 'page' ) ) {
			    $paged = get_query_var( 'page' );
			} else {
			    $paged = 1;
			}
			$query_vars = array(
				'post_type'         => 'job_listing',
				'posts_per_page'    => get_option('posts_per_page'),
				'paged'    			=> $paged,
				'post_status'       => 'publish',
				'post__in'       	=> $job_ids,
			);

			if ( isset($_GET['search']) ) {
				$query_vars['s'] = $_GET['search'];
			}
			if ( isset($_GET['orderby']) ) {
				switch ($_GET['orderby']) {
					case 'menu_order':
						$query_vars['orderby'] = array(
							'menu_order' => 'ASC',
							'date'       => 'DESC',
							'ID'         => 'DESC',
						);
						break;
					case 'newest':
						$query_vars['orderby'] = 'date';
						$query_vars['order'] = 'DESC';
						break;
					case 'oldest':
						$query_vars['orderby'] = 'date';
						$query_vars['order'] = 'ASC';
						break;
				}
			}
			$jobs = new WP_Query($query_vars);
			
			if ( $jobs->have_posts() ) {
				while ( $jobs->have_posts() ) : $jobs->the_post();
					global $post;

					$author_id = $post->post_author;
					$employer_id = WP_Job_Board_User::get_employer_by_user_id($author_id);
					$types = get_the_terms( $post->ID, 'job_listing_type' );
					$address = get_post_meta( $post->ID, WP_JOB_BOARD_JOB_LISTING_PREFIX . 'address', true );
					$salary = WP_Job_Board_Job_Listing::get_salary_html($post->ID);

					$job_id = $post->ID;
					?>

					<?php do_action( 'wp_job_board_before_job_content', $post->ID ); ?>

					<article <?php post_class('job-shortlist-wrapper job-list-small'); ?>>
						<div class="flex-middle">
							<?php if ( has_post_thumbnail($employer_id) ) { ?>
						        <div class="employer-logo ">
						            <?php echo get_the_post_thumbnail( $employer_id, 'thumbnail' ); ?>
						        </div>
						    <?php } ?>
						    <div class="job-information flex-middle-sm">
						    	<div class="inner">
						        	<h2 class="job-title">
							        	<a href="<?php echo esc_url(get_permalink($job_id)); ?>" rel="bookmark"><?php echo get_the_title($job_id); ?></a>
							        </h2>
							        
							        <div class="job-metas">
							        	<span class="job-date-author">
								        	<i class="ti-time"></i>
								            <?php echo sprintf(esc_html__('Posted %s ago', 'workup'), human_time_diff(get_the_time('U', $job_id), current_time('timestamp')) ); ?>
								        </span>
							        	<?php workup_job_display_job_category($post, 'icon'); ?>

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
						        	<a href="javascript:void(0)" class="btn-remove-job-shortlist btn-action-icon deleted" data-job_id="<?php echo esc_attr($post->ID); ?>" data-nonce="<?php echo esc_attr(wp_create_nonce( 'wp-job-board-remove-job-shortlist-nonce' )); ?>"><i class="ti-close"></i></a>
						        </div>
							</div>
						</div>
						<div class="visible-xs mobile-bottom">
							<?php workup_job_display_tags($post, 'title'); ?>
						</div>
					</article><!-- #post-## -->

					<?php do_action( 'wp_job_board_after_job_content', $post->ID );
				endwhile;

				WP_Job_Board_Mixes::custom_pagination( array(
					'wp_query' => $jobs,
					'max_num_pages' => $jobs->max_num_pages,
					'prev_text'     => esc_html__( 'Previous page', 'workup' ),
					'next_text'     => esc_html__( 'Next page', 'workup' ),
				));

				wp_reset_postdata();
			}
		?>

		<?php } else { ?>
			<div class="not-found"><?php esc_html_e('No jobs found.', 'workup'); ?></div>
		<?php } ?>
	</div>
</div>