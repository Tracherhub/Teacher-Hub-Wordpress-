<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="resume-form-wrapper widget box-dashboard-wrapper">
	<div class="inner-list">
		<h1 class="title"><?php esc_html_e( 'Edit Resume', 'workup' ) ; ?></h1>

		<?php
		$post_status =  get_post_status($post_id);
		if ( $post_status == 'pending' || $post_status == 'pending_approve' ) {
			?>
			<div class="alert alert-danger"><?php esc_html_e('Your resume has to be confirmed by an administrator before publish.', 'workup'); ?></div>
			<?php
			do_action('wp-job-board-resume-form-status-pending', $post_status, $post_id);
		} elseif ( $post_status == 'expired' ) {
			?>
			<div class="alert alert-danger"><?php esc_html_e('Your resume has expired.', 'workup'); ?></div>
			<?php
			do_action('wp-job-board-resume-form-status-expired', $post_status, $post_id);
		}

		do_action('wp-job-board-resume-form-status', $post_status, $post_id);

		if ( ! empty( $_SESSION['messages'] ) ) : ?>

			<ul class="messages">
				<?php foreach ( $_SESSION['messages'] as $message ) { ?>
					<?php
					$status = !empty( $message[0] ) ? $message[0] : 'success';
					if ( !empty( $message[1] ) ) {
					?>
					<li class="message_line <?php echo esc_attr( $status ) ?>">
						<?php echo wp_kses_post( $message[1] ); ?>
					</li>
				<?php
					}
				}
				unset( $_SESSION['messages'] );
				?>
			</ul>

		<?php endif; ?>

		<?php
			echo cmb2_get_metabox_form( $metaboxes_form, $post_id, array(
				'form_format' => '<form action="' . esc_url(WP_Job_Board_Mixes::get_full_current_url()) . '" class="cmb-form" method="post" id="%1$s" enctype="multipart/form-data" encoding="multipart/form-data"><input type="hidden" name="object_id" value="%2$s">%3$s<input type="submit" name="submit-cmb-resume" value="%4$s" class="button-primary"></form>',
				'save_button' => esc_html__( 'Save Resume', 'workup' ),
			) );
		?>
	</div>
</div>