<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
global $post;

$rating_avg = WP_Job_Board_Review::get_ratings_average($post->ID);
$socials = WP_Job_Board_Candidate::get_post_meta($post->ID, 'socials');
?>
<?php do_action( 'wp_job_board_before_candidate_content', $post->ID ); ?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <div class="candidate-grid">
         <div class="wrapper-shortlist">
            <?php workup_candidate_display_shortlist_btn($post); ?>
        </div>
        <div class="top-inner">
        	<?php workup_candidate_display_logo($post); ?>

            <?php if ( workup_candidate_check_hidden_review() && !empty($rating_avg) ) { ?>
                <div class="rating-avg-star"><?php echo WP_Job_Board_Review::print_review($rating_avg); ?></div>
            <?php } ?>
            
            <?php the_title( sprintf( '<h2 class="candidate-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>

            <?php workup_candidate_display_job_title($post); ?>
        </div>
        <?php if ( $socials ) {?>
            <div class="social-share-user">
                <?php foreach ($socials as $social) { ?>
                    <?php if ( !empty($social['url']) && !empty($social['network']) ) { ?>
                        <a href="<?php echo esc_html($social['url']); ?>" class="<?php echo esc_attr($social['network']); ?>"><i class="fa fa-<?php echo esc_attr($social['network']); ?>"></i></a>
                    <?php } ?>
                <?php } ?>
            </div>
        <?php } ?>

        <div class="candidate-information flex justify-content-between">
            <?php if ( WP_Job_Board_Candidate::check_restrict_view_contact_info($post) ) { ?>
                <a class="btn-link-candidate btn-candidate-private-message" href="#" data-candidate_id="<?php echo esc_attr($post->ID); ?>" data-nonce="<?php echo esc_attr(wp_create_nonce( 'wp-private-message-send-message-form-nonce' )); ?>"><i class="ti-email"></i><?php esc_html_e('Message', 'workup'); ?></a>
            <?php } ?>
	        <a href="<?php the_permalink(); ?>" class="btn-link-candidate"><i class="ti-eye"></i><?php esc_html_e('View Profile', 'workup'); ?></a>
    	</div>
    </div>
</article><!-- #post-## -->
<?php do_action( 'wp_job_board_after_candidate_content', $post->ID ); ?>