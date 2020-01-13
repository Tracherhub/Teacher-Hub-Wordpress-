<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
global $post;
?>
<?php do_action( 'wp_job_board_before_job_content', $post->ID ); ?>
<article id="post-<?php the_ID(); ?>" <?php post_class('job-list-v2'); ?> <?php workup_job_item_map_meta($post); ?>>
	<div class="flex-middle-sm inner">
		<div class="left-inner">
			<div class="flex-middle">
				<?php workup_job_display_employer_logo($post); ?>
				<?php the_title( sprintf( '<h2 class="job-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
			</div>
		</div>
		<?php workup_job_display_short_location($post, 'icon'); ?>
		<?php workup_job_display_job_type($post); ?>
		<?php workup_job_display_salary($post, 'icon'); ?>
		<div class="ali-right">
			<?php WP_Job_Board_Job_Listing::display_apply_job_btn($post->ID); ?>
		</div>
	</div>
</article><!-- #post-## -->
<?php do_action( 'wp_job_board_after_job_content', $post->ID ); ?>