<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
global $post;

?>

<?php do_action( 'wp_job_board_before_employer_content', $post->ID ); ?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <div class="employer-list">
        <div class="flex-middle">
            <?php if ( has_post_thumbnail() ) { ?>
                <div class="left-inner">
                    <?php workup_employer_display_logo($post); ?>
                    <?php workup_employer_display_featured_icon($post); ?>
                </div>
            <?php } ?>
            <div class="flex-middle right-content">
                <div class="employer-information">

                    <div class="title-wrapper">
                        <?php the_title( sprintf( '<h2 class="employer-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
                        <?php if ( !has_post_thumbnail() ) { ?>
                            <?php workup_employer_display_featured_icon($post); ?>
                        <?php } ?>
                    </div>

                    <?php workup_employer_display_category($post->ID,'icon'); ?>
                    <?php workup_employer_display_full_location($post,'icon'); ?>
                </div>
                <div class="ali-right hidden-xs">
                    <?php workup_employer_display_open_position($post); ?>
                    <?php if ( !empty($unfollow) ) { ?>
                        <div class="unfollow-wrapper">
                            <a href="javascript:void(0)" class="btn-loading btn button btn-block btn-danger btn-unfollow-employer" data-employer_id="<?php echo esc_attr($post->ID); ?>" data-nonce="<?php echo esc_attr(wp_create_nonce( 'wp-job-board-unfollow-employer-nonce' )); ?>"><?php esc_html_e('Unfollow', 'workup'); ?></a>
                        </div>
                    <?php } ?>
                </div>

            </div>
        </div>
        <div class="visible-xs bottom-moible">
            <?php workup_employer_display_open_position($post); ?>
            <?php if ( !empty($unfollow) ) { ?>
                <div class="unfollow-wrapper">
                    <a href="javascript:void(0)" class="btn-loading btn button btn-block btn-danger btn-unfollow-employer" data-employer_id="<?php echo esc_attr($post->ID); ?>" data-nonce="<?php echo esc_attr(wp_create_nonce( 'wp-job-board-unfollow-employer-nonce' )); ?>"><?php esc_html_e('Unfollow', 'workup'); ?></a>
                </div>
            <?php } ?>
        </div>
        
    </div>
</article><!-- #post-## -->

<?php do_action( 'wp_job_board_after_employer_content', $post->ID ); ?>