<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
global $post;

$profile_photos = WP_Job_Board_Employer::get_post_meta($post->ID, 'profile_photos', true );

if ( !empty($profile_photos) ) {
?>
    <div id="job-employer-portfolio" class="employer-detail-portfolio candidate-detail-portfolio widget">
    	<h4 class="widget-title"><?php esc_html_e('Office Photos', 'workup'); ?></h4>
        <div class="content-bottom">
            <div class="row">
                <?php foreach ($profile_photos as $attach_id => $img_url) { ?>
                    <div class="col-xs-4 col-sm-3">
                        <div class="photo-item education-item">
                        	<a href="<?php echo esc_url($img_url); ?>" class="popup-image item">
                            	<img src="<?php echo esc_url($img_url); ?>" alt="<?php esc_attr_e('Image', 'workup'); ?>">
                            </a>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
<?php }