<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
global $post;
?>

<?php do_action( 'wp_job_board_before_job_detail', get_the_ID() ); ?>

<article id="post-<?php the_ID(); ?>" <?php post_class('candidate-single-v1'); ?>>
	
	<!-- Main content -->
	<div class="row content-single-candidate">
		<div class="col-xs-12 list-content-candidate col-md-<?php echo esc_attr( is_active_sidebar( 'candidate-single-sidebar' ) ? 8 : 12); ?>">

			<?php do_action( 'wp_job_board_before_job_content', get_the_ID() ); ?>
			<!-- heading -->
			<?php echo WP_Job_Board_Template_Loader::get_template_part( 'single-candidate/header' ); ?>
			<!-- job description -->
			<div id="job-candidate-description" class="job-detail-description box-detail">
				<h3 class="title"><?php esc_html_e('About Me', 'workup'); ?></h3>
				<div class="inner">
					<?php the_content(); ?>
				</div>
			</div>

			<?php echo WP_Job_Board_Template_Loader::get_template_part( 'single-candidate/video' ); ?>
			
			<?php echo WP_Job_Board_Template_Loader::get_template_part( 'single-candidate/education' ); ?>

			<?php echo WP_Job_Board_Template_Loader::get_template_part( 'single-candidate/experience' ); ?>

			<?php echo WP_Job_Board_Template_Loader::get_template_part( 'single-candidate/portfolios' ); ?>

			<?php echo WP_Job_Board_Template_Loader::get_template_part( 'single-candidate/skill' ); ?>

			<?php echo WP_Job_Board_Template_Loader::get_template_part( 'single-candidate/award' ); ?>

			<?php if ( workup_check_employer_candidate_review($post) ) : ?>
				<!-- Review -->
				<?php comments_template(); ?>
			<?php endif; ?>

			<?php do_action( 'wp_job_board_after_job_content', get_the_ID() ); ?>
		</div>
		<?php if ( is_active_sidebar( 'candidate-single-sidebar' ) ): ?>
			<div class="col-xs-12 col-md-4 sidebar-single-candidates">
		   		<?php dynamic_sidebar( 'candidate-single-sidebar' ); ?>
		   	</div>
	   	<?php endif; ?>

	   	<div class="col-xs-12">
			<?php echo WP_Job_Board_Template_Loader::get_template_part( 'single-candidate/releated' ); ?>
		</div>
	</div>

</article><!-- #post-## -->

<?php do_action( 'wp_job_board_after_job_detail', get_the_ID() ); ?>