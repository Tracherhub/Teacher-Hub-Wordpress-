<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
wp_enqueue_script('select2');
wp_enqueue_style('select2');
?>


<div class="box-employer">
  	<div class="register-form-wrapper">
	  	<div class="container-form">
          	<form name="registerForm" method="post" class="register-form">
          		<div class="form-group space-25 text-center">
					<ul class="role-tabs">
						<li class="active"><input id="cadidate" type="radio" name="role" value="wp_job_board_candidate" checked="checked"><label for="cadidate"><i class="ti-user"></i><?php esc_html_e('Candidate', 'workup'); ?></label></li>
						<li><input type="radio" id="employer" name="role" value="wp_job_board_employer"><label for="employer"><i class="ti-user"></i><?php esc_html_e('Employer', 'workup'); ?></label></li>
					</ul>
				</div>
				<div class="form-group">
					<label><?php esc_attr_e('Username *','workup'); ?></label>
					<input type="text" class="form-control" name="username" id="register-username" placeholder="<?php esc_attr_e('Username *','workup'); ?>">
				</div>
				<div class="form-group">
					<label><?php esc_attr_e('Email *','workup'); ?></label>
					<input type="text" class="form-control" name="email" id="register-email" placeholder="<?php esc_attr_e('Email *','workup'); ?>">
				</div>
				<div class="form-group">
					<label><?php esc_attr_e('Password *','workup'); ?></label>
					<input type="password" class="form-control" name="password" id="password" placeholder="<?php esc_attr_e('Password *','workup'); ?>">
				</div>
				<div class="form-group">
					<label><?php esc_attr_e('Confirm Password *','workup'); ?></label>
					<input type="password" class="form-control" name="confirmpassword" id="confirmpassword" placeholder="<?php esc_attr_e('Confirm Password *','workup'); ?>">
				</div>

				<div class="form-group wp_job_board_employer_show">
					<label><?php esc_attr_e('Company Name','workup'); ?></label>
					<input type="text" class="form-control" name="company_name" id="register-company-name" placeholder="<?php esc_attr_e('Company Name','workup'); ?>">
				</div>

				<div class="form-group">
					<label><?php esc_attr_e('Phone','workup'); ?></label>
					<input type="text" class="form-control" name="phone" id="register-phone" placeholder="<?php esc_attr_e('Phone','workup'); ?>">
				</div>
				<?php
					$candidate_args = array(
			            'taxonomy' => 'candidate_category',
			            'orderby' => 'name',
			            'order' => 'ASC',
			            'hide_empty' => false,
			            'number' => false,
				    );
				    $terms = get_terms($candidate_args);

				    if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
				    	?>
				    	<div class="form-group space-25 wp_job_board_candidate_show select2-wrapper">
				    		<div class="flex-middle">
								<span class="text-medium"><?php esc_html_e('Category', 'workup'); ?></span>
								<select id="register-candidate-category" class="orderby" name="candidate_category">
									<option value=""><?php esc_html_e('Select Category', 'workup'); ?></option>
									<?php foreach ($terms as $term) { ?>
										<option class="<?php echo esc_attr($term->term_id); ?>"><?php echo esc_html($term->name); ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
				    	<?php
				    }
				?>
				<?php
					$employer_args = array(
			            'taxonomy' => 'employer_category',
			            'orderby' => 'name',
			            'order' => 'ASC',
			            'hide_empty' => false,
			            'number' => false,
				    );
				    $terms = get_terms($employer_args);

				    if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
				    	?>
				    	<div class="form-group space-25 wp_job_board_employer_show select2-wrapper ">
				    		<div class="flex-middle">
								<span class="text-medium"><?php esc_html_e('Category', 'workup'); ?></span>
								<select id="register-employer-category" class="orderby" name="employer_category">
									<option value=""><?php esc_html_e('Select Category', 'workup'); ?></option>
									<?php foreach ($terms as $term) { ?>
										<option class="<?php echo esc_attr($term->term_id); ?>"><?php echo esc_html($term->name); ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
				    	<?php
				    }
				?>
				<?php wp_nonce_field('ajax-register-nonce', 'security_register'); ?>

				<div class="form-group text-center">
					<button type="submit" class="btn btn-success" name="submitRegister">
						<?php echo esc_html__('Register now', 'workup'); ?>
					</button>
				</div>

				<?php do_action('register_form'); ?>
          	</form>
	    </div>

  	</div>
 </div>
