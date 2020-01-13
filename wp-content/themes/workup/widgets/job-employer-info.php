<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
global $post;
if ( empty($post->post_type) || $post->post_type != 'job_listing' ) {
    return;
}
extract( $args );
extract( $instance );
$title = apply_filters('widget_title', $instance['title']);

if ( $title ) {
    echo trim($before_title)  . trim( $title ) . $after_title;
}

$author_id = $post->post_author;
$employer_id = WP_Job_Board_User::get_employer_by_user_id($author_id);
if ( empty($employer_id) ) {
    return;
}
$address = get_post_meta($employer_id, WP_JOB_BOARD_EMPLOYER_PREFIX.'address', true);
$phone = get_post_meta($employer_id, WP_JOB_BOARD_EMPLOYER_PREFIX.'phone', true);
$email = get_post_meta($employer_id, WP_JOB_BOARD_EMPLOYER_PREFIX.'email', true);
?>
<div class="job-detail-employer-info">

    <?php if ( has_post_thumbnail($employer_id) ) { ?>
        <div class="employer-thumbnail">
            <?php echo get_the_post_thumbnail( $employer_id, 'thumbnail' ); ?>
        </div>
    <?php } ?>

    <div class="employer-links">
        <?php
            $jobs_page = WP_Job_Board_Mixes::get_jobs_page_url();
            $filter_url = add_query_arg( 'filter-author', $author_id, $jobs_page );
        ?>
        <a href="<?php echo esc_url($filter_url); ?>"><?php esc_html_e('View all jobs', 'workup'); ?> <i class="flaticon-right-arrow"></i></a>
        <a href="<?php echo get_permalink($employer_id); ?>"><?php esc_html_e('Company Profile', 'workup'); ?> <i class="flaticon-right-arrow"></i></a>
    </div>

    <?php if ( !empty($address) ) { ?>
        <div class="employer-address">
            <?php echo wp_kses_post($address); ?>
        </div>
    <?php } ?>
    <?php if ( !empty($phone) || !empty($email) ) { ?>
        <div class="bottom-inner">
    <?php } ?>
        <?php if ( !empty($phone) ) { ?>
            <div class="employer-phone">
                <?php echo wp_kses_post($phone); ?>
            </div>
        <?php } ?>
        <?php if ( !empty($email) ) { ?>
            <div class="employer-email">
                <?php echo wp_kses_post($email); ?>
            </div>
        <?php } ?>
    <?php if ( !empty($phone) || !empty($email) ) { ?>
        </div>
    <?php } ?>
</div>