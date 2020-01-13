<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
global $post;

$author_id = $post->post_author;
$employer_id = WP_Job_Board_User::get_employer_by_user_id($author_id);
?>
<?php 
    if(has_post_thumbnail()){
        $img_bg_src = wp_get_attachment_image_url( get_post_thumbnail_id( $post->ID ), 'full' );
        $style = 'style="background-image:url('.esc_url($img_bg_src).')"';
    }else{
        $style = '';
    }
?>
<div class="job-detail-header v1" <?php echo trim($style); ?>>
    <div class="inner-v1">
        <div class="container">
            <div class="row flex-bottom-in-sm">
                <div class="col-md-4 col-sm-5 col-xs-12">
                    <div class="flex-middle employer-logo-wrapper pull-left">
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
                        <div class="inner-info">
                            <h3 class="employer-title"><?php echo get_the_title($employer_id); ?></h3>
                            <?php workup_employer_display_category($employer_id); ?>
                        </div>
                    </div>
                </div>

                <div class="job-detail-buttons col-md-8 col-sm-7 col-xs-12">
                    <div class="flex-bottom justify-content-end-sm info-right">
                        <?php workup_employer_display_phone($employer_id); ?>
                        <?php workup_job_display_full_location($post, 'icon'); ?>
                        <div class="action hidden-sm hidden-xs">
                            <?php WP_Job_Board_Job_Listing::display_apply_job_btn($post->ID); ?>
                            <?php WP_Job_Board_Job_Listing::display_shortlist_btn($post->ID); ?>
                        </div>
                    </div>
                    <div class="action hidden-lg hidden-md">
                        <?php WP_Job_Board_Job_Listing::display_apply_job_btn($post->ID); ?>
                        <?php WP_Job_Board_Job_Listing::display_shortlist_btn($post->ID); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>