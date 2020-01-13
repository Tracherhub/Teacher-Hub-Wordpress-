<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$jobs_display_mode = workup_get_jobs_display_mode();
$job_inner_style = workup_get_jobs_inner_style();

$args = array(
	'jobs' => $jobs,
	'job_inner_style' => $job_inner_style,
	'jobs_display_mode' => $jobs_display_mode,
);
?>

<?php
	echo WP_Job_Board_Template_Loader::get_template_part('loop/job/archive-inner', $args);
?>

<?php echo WP_Job_Board_Template_Loader::get_template_part('loop/job/pagination', array('jobs' => $jobs) ); ?>


<?php

$layout_type = workup_get_jobs_layout_type();
if ( $layout_type == 'half-map' ) {
	dynamic_sidebar( 'jobs-filter-sidebar' );
} else {
	$sidebar_configs = workup_get_jobs_layout_configs();

	if ( workup_get_jobs_layout_type() == 'main' && is_active_sidebar( 'jobs-filter-top-sidebar' ) ) {
		dynamic_sidebar( 'jobs-filter-top-sidebar' );
   	} else {
		workup_display_sidebar_left( $sidebar_configs );
		workup_display_sidebar_right( $sidebar_configs );
	}
}

?>