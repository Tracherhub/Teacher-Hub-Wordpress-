<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

global $post;

$rating_avg = WP_Job_Board_Review::get_ratings_average($post->ID);

?>

<?php do_action( 'wp_job_board_before_candidate_content', $post->ID ); ?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <div class="candidate-list candidate-archive-layout">
        <?php workup_candidate_display_urgent_icon($post); ?>
        <div class="flex">
            <?php if ( has_post_thumbnail() ) { ?>
                <div class="candidate-thumbnail">
                    <div class="thumbnail-inner">
                        <a href="<?php the_permalink(); ?>">
                            <?php if ( has_post_thumbnail($post->ID) ) { ?>
                                <?php echo get_the_post_thumbnail( $post->ID, 'thumbnail' ); ?>
                            <?php } else { ?>
                                <img src="<?php echo esc_url(workup_placeholder_img_src()); ?>" alt="<?php echo esc_attr(get_the_title($post->ID)); ?>">
                            <?php } ?>
                        </a>
                        <?php if ( workup_candidate_check_hidden_review() && !empty($rating_avg) ) { ?>
                            <div class="rating-avg"><?php echo round($rating_avg,1,PHP_ROUND_HALF_UP); ?></div>
                        <?php } ?>
                    </div>
                    <?php workup_candidate_display_featured_icon($post); ?>
                </div>
            <?php } ?>
            <div class="flex-middle inner-left">
                <div class="candidate-information">
                    
                    <div class="title-wrapper">
                        <?php the_title( sprintf( '<h2 class="candidate-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
                        <?php if ( !has_post_thumbnail() ) { ?>
                            <?php workup_candidate_display_featured_icon($post); ?>
                        <?php } ?>
                    </div>

                    <?php workup_candidate_display_job_title($post); ?>

                    <!-- rating -->
                    <?php if ( workup_candidate_check_hidden_review() && !empty($rating_avg) ) { ?>
                        <div class="rating-avg-star"><?php echo WP_Job_Board_Review::print_review($rating_avg); ?></div>
                    <?php } ?>
                    <div class="info job-metas clearfix">
                        <?php workup_candidate_display_full_location($post, 'icon'); ?>

                        <?php workup_candidate_display_salary($post, 'icon'); ?>
                    </div>
                </div>
                <div class="ali-right hidden-xs">
                    <a href="<?php the_permalink(); ?>" class="btn btn-sm btn-theme btn-outline"><?php esc_html_e('View Profile', 'workup'); ?><i class="next flaticon-right-arrow"></i></a>
                </div>
            </div>
        </div>
    </div>
</article><!-- #post# -->
<?php do_action( 'wp_job_board_after_candidate_content', $post->ID ); ?>