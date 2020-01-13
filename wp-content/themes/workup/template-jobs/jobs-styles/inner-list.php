<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

global $post;

?>
<?php do_action( 'wp_job_board_before_job_content', $post->ID ); ?>
<article id="post-<?php the_ID(); ?>" <?php post_class('job-list'); ?> <?php workup_job_item_map_meta($post); ?>>
    <div class="vertical-job-header flex-middle">
        <?php workup_job_display_employer_logo($post); ?>
        <div class="job-title-wrapper">
            <?php workup_job_display_employer_title($post); ?>
            <?php the_title( sprintf( '<h2 class="job-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
        </div>
        <div class="ali-right">
            <?php workup_job_display_job_type($post); ?>
        </div>
        <?php workup_job_display_urgent_icon($post); ?>
    </div>
    <div class="job-middle">
        <?php workup_job_display_full_location($post, 'icon'); ?>
        <?php workup_job_display_salary($post, 'icon'); ?>
    </div>
    
    <div class="job-bottom-tags flex-middle">
        <?php workup_job_display_tags($post, 'title'); ?>
        <div class="ali-right">
            <?php workup_job_display_add_shortlist_btn($post); ?>
        </div>
    </div>
</article><!-- #post-## -->
<?php do_action( 'wp_job_board_after_job_content', $post->ID ); ?>