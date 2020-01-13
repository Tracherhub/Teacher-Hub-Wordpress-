<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
global $post;

$author_id = $post->post_author;
$employer_id = WP_Job_Board_User::get_employer_by_user_id($author_id);

$salary_html = workup_job_display_salary($post, 'icon', false);
$phone_html = workup_employer_display_phone($employer_id, false);
$email_html = workup_employer_display_email($employer_id, false);
$type_html = workup_job_display_job_type($post, 'icon', false);
$location_html = workup_job_display_short_location($post, false);
$postdate_html = workup_job_display_postdate($post, 'icon', false);
?>
<div class="job-detail-header job-detail-header-v2 clearfix">
    
     <div class="employer-logo-wrapper-v2">
        <div class="left-inner">
            <?php if ( has_post_thumbnail($employer_id) ) { ?>
                <div class="job-detail-thumbnail">
                    <a href="<?php echo esc_url(get_permalink($employer_id)); ?>">
                        <?php if ( has_post_thumbnail($employer_id) ) { ?>
                            <?php echo get_the_post_thumbnail( $employer_id, 'thumbnail' ); ?>
                        <?php } else { ?>
                            <img src="<?php echo esc_url(workup_placeholder_img_src()); ?>" alt="<?php echo esc_attr(get_the_title($employer_id)); ?>">
                        <?php } ?>
                    </a>
                </div>
            <?php } ?>
        </div>
        <div class="inner-info">
            <?php the_title( '<h1 class="job-detail-title">', '</h1>' ); ?>
            <?php workup_job_display_full_location($post, 'icon'); ?>
        </div>
    </div>

    <div class="job-information clearfix">
        <ul class="list-detail-candidate">
            <?php if ( $salary_html ) { ?>
                <li>
                    <?php echo wp_kses_post($salary_html); ?>
                </li>
            <?php } ?>
            <?php if ( $phone_html ) { ?>
                <li>
                    <?php echo wp_kses_post($phone_html); ?>
                </li>
            <?php } ?>
            <?php if ( $email_html ) { ?>
                <li>
                    <?php echo wp_kses_post($email_html); ?>
                </li>
            <?php } ?>
            <?php if ( $type_html ) { ?>
                <li>
                    <?php echo wp_kses_post($type_html); ?>
                </li>
            <?php } ?>
            <?php if ( $location_html ) { ?>
                <li>
                    <?php echo wp_kses_post($location_html); ?>
                </li>
            <?php } ?>
            <?php if ( $postdate_html ) { ?>
                <li>
                    <?php echo wp_kses_post($postdate_html); ?>
                </li>
            <?php } ?>
        </ul>
    </div>

</div>