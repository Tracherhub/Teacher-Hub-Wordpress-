<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

global $post;
$category = get_the_terms( $post->ID, 'job_listing_category' );
?>
<?php do_action( 'wp_job_board_before_job_content', $post->ID ); ?>
<article id="post-<?php the_ID(); ?>" <?php post_class('job-list-small'); ?> <?php workup_job_item_map_meta($post); ?>>
    <div class="flex-middle">
        <?php workup_job_display_employer_logo($post); ?>
        <div class="job-information flex-middle-sm">
            <div class="inner">
                <?php the_title( sprintf( '<h2 class="job-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
                <div class="job-metas">
                    <?php if ( $category ) { ?>
                        <div class="category-job hidden-xs">
                            <i class="ti-home"></i>
                            <?php foreach ($category as $term) { ?>
                                <a href="<?php echo get_term_link($term); ?>"><?php echo wp_kses_post($term->name); ?></a>
                                <?php break; ?>
                            <?php } ?>
                        </div>
                    <?php } ?>
                    <?php workup_job_display_full_location($post, 'icon'); ?>
                    <?php workup_job_display_salary($post, 'icon'); ?>
                </div>
                <div class="hidden-xs"><?php workup_job_display_tags($post); ?></div>
            </div>
            <div class="ali-right">
                <?php workup_job_display_add_shortlist_btn($post); ?>
            </div>
        </div>
    </div>
    <div class="visible-xs mobile-bottom"><?php workup_job_display_tags($post); ?></div>
</article><!-- #post-## -->
<?php do_action( 'wp_job_board_after_job_content', $post->ID ); ?>