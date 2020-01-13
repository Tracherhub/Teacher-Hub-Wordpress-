<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
global $post;

$portfolio_photos = WP_Job_Board_Candidate::get_post_meta($post->ID, 'portfolio_photos', true );

if ( !empty($portfolio_photos) ) {
?>
    <div id="job-candidate-portfolio" class="candidate-detail-portfolio widget">
    	<h4 class="widget-title"><?php esc_html_e('Portfolio', 'workup'); ?></h4>
    	<div class="content-bottom">
	    	<div class="row row-36">
		        <?php foreach ($portfolio_photos as $attach_id => $img_url) { ?>
		            <div class="col-xs-4">
		            	<div class="education-item">
		            		<a class="item" href="javascript:void(0);">
		                		<img src="<?php echo esc_url($img_url); ?>" alt="<?php esc_attr_e('Image', 'workup'); ?>">
		                	</a>
		                </div>
		            </div>
		        <?php } ?>
	        </div>
        </div>
    </div>
<?php }