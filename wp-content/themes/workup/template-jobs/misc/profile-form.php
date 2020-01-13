<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="profile-form-wrapper box-dashboard-wrapper">
	<div class="inner-list">
		<h1 class="title"><?php esc_html_e( 'Edit Profile', 'workup' ) ; ?></h1>

		<?php if ( ! empty( $_SESSION['messages'] ) ) : ?>

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
				'form_format' => '<form action="' . esc_url(WP_Job_Board_Mixes::get_full_current_url()) . '" class="cmb-form" method="post" id="%1$s" enctype="multipart/form-data" encoding="multipart/form-data"><input type="hidden" name="object_id" value="%2$s">%3$s<input type="submit" name="submit-cmb-profile" value="%4$s" class="button-primary"></form>',
				'save_button' => esc_html__( 'Save Profile', 'workup' ),
			) );
		?>
	</div>
</div>
