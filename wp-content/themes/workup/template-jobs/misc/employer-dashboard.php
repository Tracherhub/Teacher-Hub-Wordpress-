<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$jobs = WP_Job_Board_Query::get_posts(array(
    'post_type' => 'job_listing',
    'post_status' => 'publish',
    'author' => $user_id,
    'fields' => 'ids'
));
$count_jobs = $jobs->post_count;
$shortlist = get_post_meta($employer_id, WP_JOB_BOARD_EMPLOYER_PREFIX.'shortlist', true);
$shortlist = is_array($shortlist) ? count($shortlist) : 0;
$total_reviews = WP_Job_Board_Review::get_total_reviews($employer_id);
$views = get_post_meta($employer_id, WP_JOB_BOARD_EMPLOYER_PREFIX.'views_count', true);
?>
<div class="box-dashboard-wrapper">
	<div class="inner-list bg-transparent no-padding">
		<h3 class="title"><?php esc_html_e('Applications statistics', 'workup'); ?></h3>
		<div class="statistics row">
			<div class="col-xs-12 col-lg-3 col-sm-6">
				<div class="inner-header">
					<div class="posted-jobs list-item flex-middle justify-content-between text-right">
						<div class="icon-wrapper">
							<div class="icon">
								<i class="icon-briefcase"></i>
							</div>
						</div>
						<div class="inner">
							<div class="number-count"><?php echo esc_html( $count_jobs ? WP_Job_Board_Mixes::format_number($count_jobs) : 0); ?></div>
							<span><?php esc_html_e('Posted Jobs', 'workup'); ?></span>
						</div>
					</div>
				</div>
			</div>
			<div class="col-xs-12 col-lg-3 col-sm-6">
				<div class="inner-header">
				<div class="shortlist list-item flex-middle justify-content-between text-right">
					<div class="icon-wrapper">
					<div class="icon">
						<i class="icon-heart"></i>
					</div>
					</div>
					<div class="inner">
						<div class="number-count"><?php echo esc_html($shortlist ? WP_Job_Board_Mixes::format_number($shortlist) : 0); ?></div>
						<span><?php esc_html_e('Shortlisted', 'workup'); ?></span>
					</div>
				</div>
				</div>
			</div>
			<div class="col-xs-12 col-lg-3 col-sm-6">
				<div class="inner-header">
				<div class="review-count-wrapper list-item flex-middle justify-content-between text-right">
					<div class="icon-wrapper">
					<div class="icon">
						<i class="icon-megaphone"></i>
					</div>
					</div>
					<div class="inner">
						<div class="number-count"><?php echo esc_html( $total_reviews ? WP_Job_Board_Mixes::format_number($total_reviews) : 0 ); ?></div>
						<span><?php esc_html_e('Review', 'workup'); ?></span>
					</div>
				</div>
				</div>
			</div>
			<div class="col-xs-12 col-lg-3 col-sm-6">
				<div class="inner-header">
				<div class="views-count-wrapper list-item flex-middle justify-content-between text-right">
					<div class="icon-wrapper">
					<div class="icon">
						<i class="ti-eye"></i>
					</div>
					</div>
					<div class="inner">
						<div class="number-count"><?php echo esc_html( $views ? WP_Job_Board_Mixes::format_number($views) : 0 ); ?></div>
						<span><?php esc_html_e('Views', 'workup'); ?></span>
					</div>
				</div>
				</div>
			</div>
		</div>
	</div>
	<div class="inner-list">
		<h3 class="title"><?php esc_html_e('Recent Applicants', 'workup'); ?></h3>
		<div class="applicants">
			<?php
				$jobs_loop = WP_Job_Board_Query::get_posts(array(
					'post_type' => 'job_listing',
					'fields' => 'ids',
					'author' => $user_id,
				));
				$job_ids = array();
				if ( !empty($jobs_loop) && !empty($jobs_loop->posts) ) {
					$job_ids = $jobs_loop->posts;
				}
				if ( !empty($job_ids) ) {
					$query_args = array(
						'post_type'         => 'job_applicant',
						'posts_per_page'    => 5,
						'post_status'       => 'publish',
						'meta_query'       => array(
							array(
								'key' => WP_JOB_BOARD_APPLICANT_PREFIX.'job_id',
								'value'     => $job_ids,
								'compare'   => 'IN',
							),
						)
					);

					$applicants = new WP_Query($query_args);
					
					if ( $applicants->have_posts() ) {
						while ( $applicants->have_posts() ) : $applicants->the_post();
							echo WP_Job_Board_Template_Loader::get_template_part( 'content-applicant' );
						endwhile;
						wp_reset_postdata();
					} else {
						?>
						<div class="no-found"><?php esc_html_e('No applicants found.', 'workup'); ?></div>
						<?php
					}
				} else {
					?>
					<div class="no-found"><?php esc_html_e('No applicants found.', 'workup'); ?></div>
					<?php
				}
			?>
		</div>
	</div>
</div>