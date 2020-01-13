<div class="hidden" id="apus_login_register_form_wrapper">
	<div class="apus_login_register_form" data-effect="fadeIn">
		<div class="form-login-register-inner">
			<!-- Social -->
			<ul class="nav nav-tabs nav-tabs-login hidden">
			  	<li class="active"><a id="apus_login_forgot_tab" class="text-theme" data-toggle="tab" href="#apus_login_forgot_form"><?php esc_html_e( 'Login', 'workup' ); ?></a></li>
			  	<li><a id="apus_register_tab" class="text-theme" data-toggle="tab" href="#apus_register_form"><?php esc_html_e( 'Register', 'workup' ); ?></a></li>
			</ul>
			
			<div class="tab-content">
				<div id="apus_login_forgot_form" class="tab-pane fade active in">
					<?php echo do_shortcode( '[wp_job_board_login]' ); ?>
			  	</div>
			  	<div id="apus_register_form" class="tab-pane fade in">
					<?php echo do_shortcode( '[wp_job_board_register]' ); ?>
			  	</div>
			</div>
			
		</div>
	</div>
</div>