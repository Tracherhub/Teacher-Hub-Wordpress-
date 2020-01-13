<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
wp_enqueue_script('select2');
wp_enqueue_style('select2');

$my_jobs_page_id = wp_job_board_get_option('my_jobs_page_id');
$my_jobs_url = get_permalink( $my_jobs_page_id );

?>

<div class="box-dashboard-wrapper my-job-employer">
	<div class="inner-list">
	<h3 class="widget-title"><?php echo esc_html__('Manage Jobs','workup') ?></h3>

	<div class="search-orderby-wrapper flex-middle-sm">
		<div class="search-my-jobs-form widget-search">
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
		<div class="sort-my-jobs-form sortby-form">
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
		$paged = (get_query_var( 'paged' )) ? get_query_var( 'paged' ) : 1;
		$query_vars = array(
			'post_type'     => 'job_listing',
			'post_status'   => apply_filters('wp-job-board-my-jobs-post-statuses', array( 'publish', 'expired', 'pending', 'draft', 'preview' )),
			'paged'         => $paged,
			'author'        => get_current_user_id(),
			'orderby'		=> 'date',
			'order'			=> 'DESC',
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
		
		if ( $jobs->have_posts() ) :
		?>
		<div class="table-responsive">
			<table class="job-table">
				<thead>
					<tr>
						<th class="job-logo"><?php esc_html_e('Logo', 'workup'); ?></th>
						<th class="job-title"><?php esc_html_e('Job Title', 'workup'); ?></th>
						<th class="job-applicants"><?php esc_html_e('Applicants', 'workup'); ?></th>
						<th class="job-status"><?php esc_html_e('Status', 'workup'); ?></th>
						<th class="job-actions"><?php esc_html_e('Actions', 'workup'); ?></th>
					</tr>
				</thead>
				<tbody>
				<?php while ( $jobs->have_posts() ) : $jobs->the_post(); global $post; ?>
					<tr>
						<td>

							<div class="left-inner">
								<?php if (has_post_thumbnail( $post->ID ) ): ?>
									<?php workup_job_display_featured_icon($post); ?>
								<?php endif; ?>
								<?php workup_job_display_employer_logo($post, false); ?>
							</div>
						</td>
						<td class="job-table-info">
							
							<div class="job-table-info-content">
								<h3 class="job-table-info-content-title">
									<?php if ( $post->post_status == 'publish' ) { ?>
										<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
									<?php } else { ?>
										<?php the_title(); ?>
									<?php } ?>

									<?php if (!has_post_thumbnail( $post->ID ) ): ?>
										<?php workup_job_display_featured_icon($post); ?>
									<?php endif; ?>
									<?php workup_job_display_urgent_icon($post); ?>
								</h3>
								<div class="job-table-info-employer-location">
									<?php workup_job_display_short_location($post); ?>
								</div>
								<div class="job-table-info-content-date-expiry flex-middle-lg">
									<div class="job-table-info-content-date">
										<span class="sub-date"><i class="flaticon-event"></i><?php esc_html_e('Created: ', 'workup'); ?></span>
										<?php the_time( get_option('date_format') ); ?>
									</div>
									<div class="job-table-info-content-expiry">
										<span class="sub-date"><i class="ti-time"></i><?php esc_html_e('Expiry: ', 'workup'); ?></span>
										<?php
											$expires = get_post_meta( $post->ID, WP_JOB_BOARD_JOB_LISTING_PREFIX.'expiry_date', true);
											if ( $expires ) {
												echo esc_html( date_i18n( get_option( 'date_format' ), strtotime( $expires ) ) );
											} else {
												echo '--';
											}
										?>
									</div>
								</div>
							</div>
						</td>

						<td class="job-table-applicants min-width nowrap">
							<div class="job-table-applicants-inner">
								<?php
									$count_applicants = WP_Job_Board_Job_Listing::count_applicants($post->ID);
									echo sprintf(wp_kses(__('<span class="number">%d</span> Applicant(s)', 'workup'), array( 'span' => array('class' => array()) ) ), $count_applicants);
								?>
							</div>
						</td>

						<td class="job-table-status min-width nowrap">
							<div class="job-table-actions-inner <?php echo esc_attr($post->post_status); ?>">
								<?php
									$post_status = get_post_status_object( $post->post_status );
									if ( !empty($post_status->label) ) {
										echo esc_html($post_status->label);
									} else {
										echo esc_html($post_status->post_status);
									}
								?>
							</div>
						</td>

						<td class="job-table-actions min-width nowrap td-action">

							<?php
							$my_jobs_url = add_query_arg( 'job_id', $post->ID, remove_query_arg( 'job_id', $my_jobs_url ) );
							switch ( $post->post_status ) {
								case 'publish' :
									$edit_url = add_query_arg( 'action', 'edit', remove_query_arg( 'action', $my_jobs_url ) );
									?>
									<a class="edit-btn btn-action-icon edit job-table-action" href="<?php echo esc_url($edit_url); ?>" title="<?php esc_attr_e('Edit', 'workup'); ?>">
										<i class="ti-pencil-alt"></i>
									</a>
									<?php
									break;
								case 'expired' :
									$relist_url = add_query_arg( 'action', 'relist', remove_query_arg( 'action', $my_jobs_url ) );
									?>
									<a href="<?php echo esc_url($relist_url); ?>" class="btn-action-icon edit job-table-action" title="<?php esc_attr_e('Relist', 'workup'); ?>">
										<i class="fa fa-registered"></i>
									</a>
									<?php
									break;
								case 'pending_payment' :
								case 'pending' :
									$edit_url = add_query_arg( 'action', 'edit', remove_query_arg( 'action', $my_jobs_url ) );
									?>
									<a class="edit-btn btn-action-icon edit job-table-action" href="<?php echo esc_url($edit_url); ?>" title="<?php esc_attr_e('Edit', 'workup'); ?>">
										<i class="ti-pencil-alt"></i>
									</a>
									<?php
								break;
								case 'draft' :
								case 'preview' :
									$continue_url = add_query_arg( 'action', 'continue', remove_query_arg( 'action', $my_jobs_url ) );
									?>
									<a href="<?php echo esc_url($continue_url); ?>" class="edit-btn btn-action-icon edit job-table-action" title="<?php esc_attr_e('Continue', 'workup'); ?>">
										<i class="flaticon-right-arrow"></i>
									</a>
									<?php
									break;
							}
							?>


							<a class="remove-btn btn-action-icon deleted" href="javascript:void(0)" class="job-table-action job-button-delete" data-job_id="<?php echo esc_attr($post->ID); ?>" data-nonce="<?php echo esc_attr(wp_create_nonce( 'wp-job-board-delete-job-nonce' )); ?>" title="<?php esc_attr_e('Remove', 'workup'); ?>">
								<i class="ti-close"></i>
							</a>

						</td>
					</tr>
				<?php endwhile; ?>
				</tbody>
			</table>
		</div>
		<?php
			WP_Job_Board_Mixes::custom_pagination( array(
				'wp_query' => $jobs,
				'max_num_pages' => $jobs->max_num_pages,
				'prev_text'     => '<i class="flaticon-left-arrow"></i>',
				'next_text'     => '<i class="flaticon-right-arrow"></i>',
			));

			wp_reset_postdata();
		?>
	<?php else : ?>
		<div class="alert alert-warning">
			<p><?php esc_html_e( 'You don\'t have any jobs, yet. Start by creating new one.', 'workup' ); ?></p>
		</div>
	<?php endif; ?>
	</div>
</div>