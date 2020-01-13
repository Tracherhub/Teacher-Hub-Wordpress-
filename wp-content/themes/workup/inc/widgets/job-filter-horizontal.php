<?php

if ( ! defined( 'ABSPATH' ) ) {
  	exit;
}

class Workup_Widget_Job_Filter_Horizontal extends Apus_Widget {
	
	function __construct() {
		parent::__construct(
			'job_filter_horizontal_widget',
			esc_html__( 'Job Filter (Horizontal)', 'workup' ),
			array(
				'description' => esc_html__( 'Filter for filtering jobs.', 'workup' ),
			)
		);

		add_action('admin_enqueue_scripts', array($this, 'scripts'));
	}

	public function scripts() {
        wp_enqueue_script( 'apus-upload-image', get_template_directory_uri() . '/js/admin-filter-horizontal.js', array( 'jquery' ), '1.0', true );
    }

	public function getTemplate() {
        $this->template = 'job-filter-horizontal.php';
    }

	public function widget( $args, $instance ) {
		$this->display($args, $instance);
	}

	public function update( $new_instance, $old_instance ) {
		return $new_instance;
	}

	public function form( $instance ) {

		$title = ! empty( $instance['title'] ) ? $instance['title'] : '';
		$button_text = ! empty( $instance['button_text'] ) ? $instance['button_text'] : '';
		$sort = ! empty( $instance['sort'] ) ? $instance['sort'] : '';
		$sort_adv = ! empty( $instance['sort_adv'] ) ? $instance['sort_adv'] : '';

		$_id = workup_random_key();

		?>
		<div id="filter-job-<?php echo esc_attr($_id); ?>" class="filter-job-horizontal">
			<!-- TITLE -->
			<p>
			    <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>">
			        <?php echo esc_html__( 'Title', 'workup' ); ?>
			    </label>

			    <input  class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
			</p>

			<!-- BUTTON TEXT -->
			<p>
			    <label for="<?php echo esc_attr( $this->get_field_id( 'button_text' ) ); ?>">
			        <?php echo esc_html__( 'Button text', 'workup' ); ?>
			    </label>

			    <input  class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'button_text' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'button_text' ) ); ?>" type="text" value="<?php echo esc_attr( $button_text ); ?>">
			</p>

			<h3><?php esc_html_e('Filter Fields', 'workup'); ?></h3>
			<ul class="wp-job-board-filter-fields wp-job-board-filter-job-fields workup-filter-job-fields">
				<?php
				$fields = workup_job_get_filter_fields();
				if ( ! empty( $sort ) ) {
					$filtered_keys = array_filter( explode( ',', $sort ) );
					$fields = array_replace( array_flip( $filtered_keys ), $fields );
				}
				
				?>
				<input type="hidden" value="<?php echo esc_attr( $sort ); ?>" class="wp-job-board-filter-sort-field" id="<?php echo esc_attr( $this->get_field_id( 'sort' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'sort' ) ); ?>" value="<?php echo esc_attr( $sort ); ?>">

				<?php foreach ( $fields as $key => $value ) : ?>
					<li data-field-id="<?php echo esc_attr( $key ); ?>" <?php if ( ! empty( $instance[ 'hide_' . $key ] ) ) : ?>class="invisible"<?php endif; ?>>
						<p>
							<label for="<?php echo esc_attr( $this->get_field_id( 'hide_' . $key ) ); ?>">
								<?php echo esc_attr( $value['label'] ); ?>
							</label>

							<span class="visibility">
								<input 	type="checkbox" class="checkbox field-visibility" <?php echo ! empty( $instance[ 'hide_'. $key ] ) ? 'checked="checked"' : ''; ?> name="<?php echo esc_attr( $this->get_field_name( 'hide_' . $key ) ); ?>">

								<i class="dashicons dashicons-visibility"></i>
							</span>
						</p>
					</li>
				<?php endforeach ?>
			</ul>

			<p>
				<h3><label><?php echo esc_html__( 'Show Advance Filter Fields', 'workup' ); ?></label></h3>
				<label>
					<input type="checkbox" class="checkbox field-visibility show_adv_fields"
							<?php echo trim(! empty( $instance['show_adv_fields'] ) ? 'checked="checked"' : ''); ?>
				            name="<?php echo esc_attr( $this->get_field_name( 'show_adv_fields' ) ); ?>">
			        <?php echo esc_html__( 'Show Advance Filter Fields', 'workup' ); ?>
			    </label>
			</p>
			<hr>
			<div class="workup-filter-job-adv-fields-wrapper">
				<h3><?php echo esc_html__('Advance Filter Fields', 'workup'); ?></h3>
				<ul class="wp-job-board-filter-fields wp-job-board-filter-job-fields workup-filter-job-adv-fields">
					<?php
					$fields = workup_job_get_filter_fields();
					if ( ! empty( $sort_adv ) ) {
						$filtered_keys = array_filter( explode( ',', $sort_adv ) );
						$fields = array_replace( array_flip( $filtered_keys ), $fields );
					}
					
					?>
					<input type="hidden" value="<?php echo esc_attr( $sort_adv ); ?>" class="wp-job-board-filter-sort-adv-field" id="<?php echo esc_attr( $this->get_field_id( 'sort_adv' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'sort_adv' ) ); ?>" value="<?php echo esc_attr( $sort_adv ); ?>">

					<?php foreach ( $fields as $key => $value ) : ?>
						<li data-field-id="<?php echo esc_attr( $key ); ?>" <?php if ( ! empty( $instance[ 'hide_adv_' . $key ] ) ) : ?>class="invisible"<?php endif; ?>>
							<p>
								<label for="<?php echo esc_attr( $this->get_field_id( 'hide_adv_' . $key ) ); ?>">
									<?php echo esc_attr( $value['label'] ); ?>
								</label>

								<span class="visibility">
									<input 	type="checkbox" class="checkbox field-visibility" <?php echo ! empty( $instance[ 'hide_adv_'. $key ] ) ? 'checked="checked"' : ''; ?> name="<?php echo esc_attr( $this->get_field_name( 'hide_adv_' . $key ) ); ?>">

									<i class="dashicons dashicons-visibility"></i>
								</span>
							</p>
						</li>
					<?php endforeach ?>
				</ul>
			</div>
		</div>
		

		<?php
	}
}
if ( function_exists('apus_framework_reg_widget') ) {
    apus_framework_reg_widget('Workup_Widget_Job_Filter_Horizontal');
}