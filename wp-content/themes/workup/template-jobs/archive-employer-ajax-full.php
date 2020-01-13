<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$args = array(
	'employers' => $employers,
);
?>

<?php
	echo WP_Job_Board_Template_Loader::get_template_part('loop/employer/archive-inner', $args);
?>

<?php echo WP_Job_Board_Template_Loader::get_template_part('loop/employer/pagination', array('employers' => $employers) ); ?>


<?php

$sidebar_configs = workup_get_employers_layout_configs();

workup_display_sidebar_left( $sidebar_configs );
workup_display_sidebar_right( $sidebar_configs );

?>