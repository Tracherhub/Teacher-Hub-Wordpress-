<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $post;

?>
<?php do_action( 'wp_job_board_before_job_content', $post->ID ); ?>
<article id="post-<?php the_ID(); ?>" <?php post_class('job-list-v1'); ?> <?php workup_job_item_map_meta($post); ?>>

    <div class="vertical-job-header flex-middle">
        <?php workup_job_display_employer_logo($post); ?>
        <div class="job-title-wrapper">
            <?php workup_job_display_employer_title($post); ?>
            <?php the_title( sprintf( '<h2 class="job-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
        </div>
        <div class="ali-right">
            <?php workup_job_display_featured_icon($post); ?>
        </div>
        <?php workup_job_display_urgent_icon($post); ?>
    </div>
    <div class="job-middle flex-middle">
        <div class="job-information">
            <?php workup_job_display_deadline($post, 'title'); ?>
            <?php workup_job_display_job_type($post, 'title'); ?>
            <?php workup_job_display_full_location($post, 'title'); ?>
            <?php workup_job_display_salary($post, 'title'); ?>
        </div>
        <div class="job-btns ali-right flex-column flex align-items-end hidden-xs">
            <?php WP_Job_Board_Job_Listing::display_apply_job_btn($post->ID); ?>
            <a class="btn btn-view" href="<?php echo esc_url( get_permalink() ) ?>"><?php echo esc_html__('View Job', 'workup') ?></a>
        </div>
    </div>

    <div class="job-btns visible-xs mobile-bottom">
        <?php WP_Job_Board_Job_Listing::display_apply_job_btn($post->ID); ?>
        <a class="btn btn-view" href="<?php echo esc_url( get_permalink() ) ?>"><?php echo esc_html__('View Job', 'workup') ?></a>
    </div>

    <div class="job-bottom-tags flex-middle">
        <?php workup_job_display_tags($post, 'title'); ?>
        <div class="ali-right">
            <?php workup_job_display_add_shortlist_btn($post); ?>
        </div>
    </div>

</article><!-- #post-## -->
<?php do_action( 'wp_job_board_after_job_content', $post->ID ); ?>