<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


$applicants = WP_Job_Board_Query::get_posts(array(
    'post_type' => 'job_applicant',
    'post_status' => 'publish',
    'fields' => 'ids',
    'meta_query' => array(
    	array(
	    	'key' => WP_JOB_BOARD_APPLICANT_PREFIX . 'candidate_id',
	    	'value' => $candidate_id,
	    	'compare' => '=',
	    )
    )
));
$count_applicants = $applicants->post_count;

$shortlist = get_post_meta($candidate_id, WP_JOB_BOARD_CANDIDATE_PREFIX.'shortlist', true);
$shortlist = is_array($shortlist) ? count($shortlist) : 0;
$total_reviews = WP_Job_Board_Review::get_total_reviews($candidate_id);
$views = get_post_meta($candidate_id, WP_JOB_BOARD_CANDIDATE_PREFIX.'views_count', true);
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
						<i class="flaticon-paper-plane"></i>
					</div>
					</div>
					<div class="inner">
						<div class="number-count"><?php echo esc_html( $count_applicants ? WP_Job_Board_Mixes::format_number($count_applicants) : 0); ?></div>
						<span><?php esc_html_e('Applied Jobs', 'workup'); ?></span>
					</div>
				</div>
				</div>
			</div>
			<div class="col-xs-12 col-lg-3 col-sm-6">
				<div class="inner-header">
				<div class="shortlist list-item flex-middle justify-content-between text-right">
					<div class="icon-wrapper">
					<div class="icon">
						<i class="flaticon-favorites"></i>
					</div>
					</div>
					<div class="inner">
						<div class="number-count"><?php echo esc_html( $shortlist ? WP_Job_Board_Mixes::format_number($shortlist) : 0 ); ?></div>
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
						<i class="flaticon-alarm"></i>
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
						<i class="flaticon-tag"></i>
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
		<h3 class="title"><?php esc_html_e('Jobs Applied Recently', 'workup'); ?></h3>
		<div class="applicants">
			<?php
				$job_ids = array();
				if ( !empty($applicants) && !empty($applicants->posts) ) {
					foreach ($applicants->posts as $applicant_id) {
						$job_ids[] = intval(get_post_meta($applicant_id, WP_JOB_BOARD_APPLICANT_PREFIX.'job_id', true));
					}
				}
				if ( !empty($job_ids) ) {
					$query_args = array(
						'post_type'         => 'job_listing',
						'posts_per_page'    => 5,
						'post_status'       => 'publish',
						'post__in'       => $job_ids,
					);

					$applicants = new WP_Query($query_args);
					
					if ( $applicants->have_posts() ) {
						while ( $applicants->have_posts() ) : $applicants->the_post();
							echo WP_Job_Board_Template_Loader::get_template_part( 'jobs-styles/inner-list-small' );
						endwhile;
						wp_reset_postdata();
					} else {
						?>
						<div class=""><?php esc_html_e('No Applicants found.', 'workup'); ?></div>
						<?php
					}
				} else {
					?>
					<div class=""><?php esc_html_e('No Applicants found.', 'workup'); ?></div>
					<?php
				}
			?>
		</div>
	</div>
</div>