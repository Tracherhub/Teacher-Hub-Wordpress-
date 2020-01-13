<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
global $post;
if ( empty($post->post_type) || $post->post_type != 'employer' ) {
    return;
}
$user_id = WP_Job_Board_User::get_user_by_employer_id($post->ID);
$author_email = WP_Job_Board_Employer::get_display_email( $post );
if ( ! empty( $author_email ) ) :
	extract( $args );
	extract( $instance );
	$title = !empty($instance['title']) ? sprintf($instance['title'], $post->post_title) : '';
	$title = apply_filters('widget_title', $title);

	if ( $title ) {
	    echo trim($before_title)  . trim( $title ) . $after_title;
	}

	$email = $phone = '';
	if ( is_user_logged_in() ) {
		$current_user_id = get_current_user_id();
		$userdata = get_userdata( $current_user_id );
		$email = $userdata->user_email;
		if ( WP_Job_Board_User::is_employer() ) {
			$employer_id = WP_Job_Board_User::get_employer_by_user_id($current_user_id);
			$phone = WP_Job_Board_Employer::get_display_phone( $employer_id );
		} elseif( WP_Job_Board_User::is_candidate() ) {
			$candidate_id = WP_Job_Board_User::get_candidate_by_user_id($current_user_id);
			$phone = WP_Job_Board_Candidate::get_display_phone($candidate_id);
		}
	}
?>


	<div class="contact-form">
		
	    <form method="post" action="?" class="contact-form-employer in-sidebar contact-form-wrapper">
	    	<div class="row">
		        <div class="col-sm-12">
			        <div class="form-group">
			            <input type="text" class="form-control style2" name="subject" placeholder="<?php esc_attr_e( 'Subject', 'workup' ); ?>" required="required">
			        </div><!-- /.form-group -->
			    </div>
			    <div class="col-sm-12">
			        <div class="form-group">
			            <input type="email" class="form-control style2" name="email" placeholder="<?php esc_attr_e( 'E-mail', 'workup' ); ?>" required="required" value="<?php echo esc_attr($email); ?>">
			        </div><!-- /.form-group -->
			    </div>
			    <div class="col-sm-12">
			        <div class="form-group">
			            <input type="text" class="form-control style2" name="phone" placeholder="<?php esc_attr_e( 'Phone', 'workup' ); ?>" required="required" value="<?php echo esc_attr($phone); ?>">
			        </div><!-- /.form-group -->
			    </div>
	        </div>
	        <div class="form-group space-30">
	            <textarea class="form-control style2" name="message" placeholder="<?php esc_attr_e( 'Message', 'workup' ); ?>" required="required"></textarea>
	        </div><!-- /.form-group -->

	        <?php if ( WP_Job_Board_Recaptcha::is_recaptcha_enabled() ) { ?>
	            <div id="recaptcha-contact-form" class="ga-recaptcha" data-sitekey="<?php echo esc_attr(wp_job_board_get_option( 'recaptcha_site_key' )); ?>"></div>
	      	<?php } ?>

	      	<input type="hidden" name="post_id" value="<?php echo esc_attr($post->ID); ?>">
	        <button class="button btn btn-theme btn-block" name="contact-form"><?php echo esc_html__( 'Send Message', 'workup' ); ?></button>

	        
	    </form>

	    <?php do_action('workup_after_contact_form', $post, $user_id); ?>
		
	</div>
<?php endif;