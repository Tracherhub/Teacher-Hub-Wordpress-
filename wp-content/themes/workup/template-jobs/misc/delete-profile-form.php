<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( empty($user_id) ) {
	return;
}
?>
<div class="box-dashboard-wrapper ">
	<div class="inner-list">
		<div class="widget-delete">
			<h3 class="widget-title"><?php echo esc_html__('Delete Profile','workup') ?></h3>
			<div class="conf-messages"><?php esc_html_e('Are you sure! You want to delete your profile.', 'workup'); ?></div>
			<div class="undone-messages"><?php esc_html_e('This can\'t be undone!', 'workup'); ?></div>

			<form method="post" action="" class="delete-profile-form">

				<div class="form-group">
					<div class="conf-deleted"><?php esc_html_e( 'Please enter your login Password to confirm:', 'workup' ); ?></div>
					<input id="delete-profile-password" class="form-control" type="password" name="password" required="required" placeholder="<?php esc_attr_e('Password', 'workup'); ?>">
				</div><!-- /.form-control -->

				<?php
					do_action('wp-job-board-delete-profile-form-fields');
					wp_nonce_field('wp-job-board-delete-profile-nonce', 'nonce');
				?>

				<button type="submit" class="btn btn-danger delete-profile-btn"><?php esc_html_e( 'Delete Profile', 'workup' ); ?></button>
			</form>
		</div>
	</div>
</div>