<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
global $post;
?>
<div class="reply-message-form-wrapper">
	<form id="reply-message-form" class="reply-message-form" action="?" method="post">
        
        <div class="form-group space-30">
            <textarea class="form-control" name="message" placeholder="<?php esc_attr_e( 'Write your message...', 'workup' ); ?>" required="required"></textarea>
        </div><!-- /.form-group -->

        <button class="button btn btn-dark-normal reply-message-btn"><i class="fa fa-paper-plane"></i></button>

        <?php wp_nonce_field( 'wp-private-message-reply-message', 'wp-private-message-reply-message-nonce' ); ?>
      	<input type="hidden" name="parent" value="<?php echo esc_attr($parent); ?>">
      	<input type="hidden" name="action" value="wp_private_message_reply_message">
	</form>
</div>