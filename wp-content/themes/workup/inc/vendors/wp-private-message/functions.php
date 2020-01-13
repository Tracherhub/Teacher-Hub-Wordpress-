<?php

remove_action( 'widgets_init', array( WP_Private_Message::getInstance(), 'register_widgets' ) );

add_action( 'workup_after_contact_form', 'workup_private_message_form', 10, 2 );
function workup_private_message_form($post, $user_id) {
	?>
	<div class="send-private-wrapper">
		<a href="javascript:void(0);" class="send-private-message-btn"><i class="fa fa-hand-o-right" aria-hidden="true"></i><?php esc_html_e('Send Private Message', 'workup'); ?></a>
	</div>
	<div class="send-private-message-wrapper-hidden hidden">
		<div class="send-private-message-wrapper">
			<h3 class="title"><?php echo sprintf(esc_html__('Send message to "%s"', 'workup'), $post->post_title); ?></h3>
			<?php
			if ( is_user_logged_in() ) {
				?>
				<form id="send-message-form" class="send-message-form" action="?" method="post">
	                <div class="form-group">
	                    <input type="text" class="form-control style2" name="subject" placeholder="<?php esc_attr_e( 'Subject', 'workup' ); ?>" required="required">
	                </div><!-- /.form-group -->
	                <div class="form-group">
	                    <textarea class="form-control message style2" name="message" placeholder="<?php esc_attr_e( 'Enter text here...', 'workup' ); ?>" required="required"></textarea>
	                </div><!-- /.form-group -->

	                <?php wp_nonce_field( 'wp-private-message-send-message', 'wp-private-message-send-message-nonce' ); ?>
	              	<input type="hidden" name="recipient" value="<?php echo esc_attr($user_id); ?>">
	              	<input type="hidden" name="action" value="wp_private_message_send_message">
	                <button class="button btn btn-theme btn-block send-message-btn"><?php echo esc_html__( 'Send Message', 'workup' ); ?></button>
	        	</form>
				<?php
			} else {
				$login_url = '';
				if ( function_exists('wp_job_board_get_option') ) {
					$login_register_page_id = wp_job_board_get_option('login_register_page_id');
					$login_url = get_permalink( $login_register_page_id );
				}
				?>
				<a href="<?php echo esc_url($login_url); ?>" class="login"><?php esc_html_e('Please login to send a private message', 'workup'); ?></a>
				<?php
			}
			?>
		</div>
	</div>
	<?php
}

add_action( 'wp_ajax_wp_private_message_send_message_form',  'workup_private_message_form_candidate' );
add_action( 'wp_ajax_nopriv_wp_private_message_send_message_form',  'workup_private_message_form_candidate' );

function workup_private_message_form_candidate() {
	$candidate_id = isset($_POST['candidate_id']) ? $_POST['candidate_id'] : '';
	$nonce = isset($_POST['nonce']) ? $_POST['nonce'] : '';

	?>
	<div class="send-private-message-wrapper">
		<?php
		if ( !isset( $_POST['nonce'] ) || ! wp_verify_nonce( $_POST['nonce'], 'wp-private-message-send-message-form-nonce' )  ) {
			?>
			<div class="text-danger">
				<?php esc_html_e('Your nonce did not verify.', 'workup'); ?>
			</div>
			<?php
		} elseif ( empty($candidate_id) || !($post = get_post($candidate_id)) ) {
			?>
			<div class="text-danger">
				<?php esc_html_e('Candidate is not exits.', 'workup'); ?>
			</div>
			<?php
		} else {
			$user_id = WP_Job_Board_User::get_user_by_candidate_id($post->ID);
		?>
			<h3 class="title"><?php echo sprintf(esc_html__('Send message to "%s"', 'workup'), $post->post_title); ?></h3>
			<?php
			if ( is_user_logged_in() ) {
				?>
				<form id="send-message-form" class="send-message-form" action="?" method="post">
	                <div class="form-group">
	                    <input type="text" class="form-control style2" name="subject" placeholder="<?php esc_attr_e( 'Subject', 'workup' ); ?>" required="required">
	                </div><!-- /.form-group -->
	                <div class="form-group">
	                    <textarea class="form-control message style2" name="message" placeholder="<?php esc_attr_e( 'Enter text here...', 'workup' ); ?>" required="required"></textarea>
	                </div><!-- /.form-group -->

	                <?php wp_nonce_field( 'wp-private-message-send-message', 'wp-private-message-send-message-nonce' ); ?>
	              	<input type="hidden" name="recipient" value="<?php echo esc_attr($user_id); ?>">
	              	<input type="hidden" name="action" value="wp_private_message_send_message">
	                <button class="button btn btn-theme btn-block send-message-btn"><?php echo esc_html__( 'Send Message', 'workup' ); ?></button>
	        	</form>
				<?php
			} else {
				$login_url = '';
				if ( function_exists('wp_job_board_get_option') ) {
					$login_register_page_id = wp_job_board_get_option('login_register_page_id');
					$login_url = get_permalink( $login_register_page_id );
				}
				?>
				<a href="<?php echo esc_url($login_url); ?>" class="login"><?php esc_html_e('Please login to send a private message', 'workup'); ?></a>
				<?php
			}
		}
		?>
	</div>
	<?php
}

function workup_private_message_user_avarta($user_id) {
	if ( class_exists('WP_Job_Board_User') && (WP_Job_Board_User::is_employer($user_id) || WP_Job_Board_User::is_candidate($user_id)) ) {
	    if ( WP_Job_Board_User::is_employer($user_id) ) {
	        $employer_id = WP_Job_Board_User::get_employer_by_user_id($user_id);
	        $avatar = get_the_post_thumbnail( $employer_id, 'thumbnail' );
	    } else {
	        $candidate_id = WP_Job_Board_User::get_candidate_by_user_id($user_id);
	        $avatar = get_the_post_thumbnail( $candidate_id, 'thumbnail' );
	    }
	}

	if ( !empty($avatar)) {
        echo trim($avatar);
    } else {
        echo get_avatar($user_id, 54);
    }
}