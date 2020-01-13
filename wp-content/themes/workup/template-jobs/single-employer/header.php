<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
global $post;

?>
<div class="employer-detail-header">
    <div class="flex-middle-sm row">
        <div class="col-xs-12 col-sm-8">  
            <div class="flex-middle">
                <?php if ( has_post_thumbnail() ) { ?>
                    <div class="inner-image">
                        <div class="employer-thumbnail">
                            <?php if ( has_post_thumbnail($post->ID) ) { ?>
                                <?php echo get_the_post_thumbnail( $post->ID, 'thumbnail' ); ?>
                            <?php } else { ?>
                                <img src="<?php echo esc_url(workup_placeholder_img_src()); ?>" alt="<?php echo esc_attr(get_the_title($post->ID)); ?>">
                            <?php } ?>
                        </div>
                        <?php workup_employer_display_featured_icon($post); ?>
                    </div>
                <?php } ?>

                <div class="employer-information">
                    <div class="title-wrapper">
                        <?php the_title( '<h1 class="employer-title">', '</h1>' ); ?>
                        <?php if ( !has_post_thumbnail() ) { ?>
                            <?php workup_employer_display_featured_icon($post); ?>
                        <?php } ?>
                    </div>
                    <?php workup_employer_display_category($post->ID); ?>
                    <?php workup_employer_display_full_location($post); ?>

                    <div class="employer-detail-buttons hidden-xs">
                        <?php workup_employer_display_follow_btn($post->ID); ?>
                        <a href="#review_form_wrapper" class="btn button btn-theme btn-outline add-a-review"><i class="ti-email pre"></i><?php esc_html_e('Add review', 'workup'); ?></a>
                    </div>
                    
                </div>
            </div>
        </div>
        <div class="col-xs-12 visible-xs">
            <div class="employer-detail-buttons">
                <?php workup_employer_display_follow_btn($post->ID); ?>
                <?php if ( workup_check_employer_candidate_review($post) ) { ?>
                    <a href="#review_form_wrapper" class="btn button btn-theme btn-outline add-a-review"><i class="ti-email pre"></i><?php esc_html_e('Add review', 'workup'); ?></a>
                <?php } ?>
            </div>
        </div>
        <div class="col-xs-12 col-sm-4">  
            <div class="employer-detail-header-right justify-content-end-sm flex-middle">
                <?php workup_employer_display_nb_jobs($post); ?>
                <?php workup_employer_display_nb_reviews($post); ?>
                <?php workup_employer_display_nb_views($post); ?>
            </div>
        </div>
    </div>
</div>