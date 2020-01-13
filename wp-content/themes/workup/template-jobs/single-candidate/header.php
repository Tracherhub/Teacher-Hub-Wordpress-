<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
global $post;

$location_html = workup_candidate_display_full_location($post, 'icon', false);
$phone_html = workup_candidate_display_phone($post, false);
$email_html = workup_candidate_display_email($post, false);
$salary_html = workup_candidate_display_salary($post, 'icon', false);
$birthday_html = workup_candidate_display_birthday($post, 'icon', false);
?>
<div class="candidate-detail-header box-detail">
    
    <div class="candidate-top-wrapper text-center">
        <?php workup_candidate_display_urgent_icon($post); ?>
        <?php if ( has_post_thumbnail() ) { ?>
            <div class="candidate-thumbnail">
                <?php workup_candidate_display_featured_icon($post); ?>
                <div class="inner-image">
                    <?php if ( has_post_thumbnail($post->ID) ) { ?>
                        <?php echo get_the_post_thumbnail( $post->ID, 'thumbnail' ); ?>
                    <?php } else { ?>
                        <img src="<?php echo esc_url(workup_placeholder_img_src()); ?>" alt="<?php echo esc_attr(get_the_title($post->ID)); ?>">
                    <?php } ?>
                </div>
            </div>
        <?php } ?>
        <div class="clearfix">
            <div class="title-wrapper">
                <?php the_title( '<h1 class="candidate-title">', '</h1>' ); ?>
                <?php if ( !has_post_thumbnail() ) { ?>
                    <?php workup_candidate_display_featured_icon($post); ?>
                <?php } ?>
            </div>
            <?php workup_candidate_display_job_title($post); ?>
        </div>
    </div>

    <div class="candidate-information">
        <ul class="list-detail-candidate clearfix">
            <?php if ( $location_html ) { ?>
                <li>
                    <?php echo wp_kses_post($location_html); ?>
                </li>
            <?php } ?>
            <?php if ( $email_html ) { ?>
                <li>
                    <?php echo wp_kses_post($email_html); ?>
                </li>
            <?php } ?>
            <?php if ( $phone_html ) { ?>
                <li>
                    <?php echo wp_kses_post($phone_html); ?>
                </li>
            <?php } ?>
            <?php if ( $salary_html ) { ?>
                <li>
                    <?php echo wp_kses_post($salary_html); ?>
                </li>
            <?php } ?>
            <?php if ( $birthday_html ) { ?>
                <li>
                    <?php echo wp_kses_post($birthday_html); ?>
                </li>
            <?php } ?>
        </ul>
    </div>

</div>