<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $post;

?>

<?php do_action( 'wp_job_board_before_job_content', $post->ID ); ?>

<article <?php post_class('job-grid'); ?> <?php workup_job_item_map_meta($post); ?>>
    <div class="top-info flex-middle">
        <?php workup_job_display_job_type($post); ?>
        <div class="ali-right">
            <?php workup_job_display_add_shortlist_btn($post); ?>
        </div>
    </div>
	<?php workup_job_display_employer_logo($post); ?>

    <div class="job-information">

        <?php the_title( sprintf( '<h2 class="job-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>

        <?php workup_job_display_full_location($post); ?>

        <a class="btn btn-browse" href="<?php echo esc_url( get_permalink() ) ?>"><?php echo esc_html__('Browse Job', 'workup') ?></a>

	</div>
</article><!-- #post-## -->

<?php do_action( 'wp_job_board_after_job_content', $post->ID ); ?>