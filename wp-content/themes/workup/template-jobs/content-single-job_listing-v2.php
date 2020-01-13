<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
global $post;
?>

<?php do_action( 'wp_job_board_before_job_detail', $post->ID ); ?>

<article id="post-<?php the_ID(); ?>" <?php post_class('job-single-v2'); ?>>

	<!-- Main content -->
	<div class="row content-job-detail-2">
		<div class="col-xs-12 col-md-<?php echo esc_attr( is_active_sidebar( 'job-single-sidebar' ) ? 8 : 12); ?>">

			<!-- heading -->
			<?php echo WP_Job_Board_Template_Loader::get_template_part( 'single-job_listing/header-v2' ); ?>

			<?php do_action( 'wp_job_board_before_job_content', $post->ID ); ?>
			
			<!-- job description -->
			<div class="job-detail-description">
				<?php the_content(); ?>
			</div>

			<?php do_action( 'wp_job_board_after_job_content', $post->ID ); ?>
		</div>
		
		<?php if ( is_active_sidebar( 'job-single-sidebar' ) ): ?>
			<div class="col-md-4 col-xs-12 sidebar sidebar-job">
		   		<?php dynamic_sidebar( 'job-single-sidebar' ); ?>
		   	</div>
	   	<?php endif; ?>
	   	<!-- job releated -->
		<div class="col-xs-12">
			<?php echo WP_Job_Board_Template_Loader::get_template_part( 'single-job_listing/releated' ); ?>
		</div>
	   	
	</div>

</article><!-- #post-## -->

<?php do_action( 'wp_job_board_after_job_detail', $post->ID ); ?>