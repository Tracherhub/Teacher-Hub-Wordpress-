<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
global $post;

$limit = apply_filters('wp_job_board_employer_limit_open_jobs', 12);

$user_id = WP_Job_Board_User::get_user_by_employer_id($post->ID);
$args = array(
    'post_type' => 'job_listing',
    'posts_per_page' => $limit,
    'author' => $user_id
);
$jobs = new WP_Query( $args );
if( $jobs->have_posts() ):
?>
    <div class="widget">
        <h4 class="widget-title">
            <span><?php esc_html_e( 'Open Position', 'workup' ); ?></span>
        </h4>
        <div class="widget-content">
            <div class="row">
                <?php
                    $i = 1;
                    while ( $jobs->have_posts() ) : $jobs->the_post();
                        ?>
                        <div class="col-md-4 col-sm-6 col-xs-12 <?php echo esc_attr($i%3 == 1)?'md-clearfix':''; ?> <?php echo esc_attr($i%2 == 1)?'sm-clearfix':''; ?>">
                            <?php echo WP_Job_Board_Template_Loader::get_template_part( 'jobs-styles/inner-grid' ); ?>
                        </div>
                        <?php
                    $i++; endwhile;
                ?>
            </div>
            <?php wp_reset_postdata(); ?>
        </div>
    </div>
<?php endif; ?>