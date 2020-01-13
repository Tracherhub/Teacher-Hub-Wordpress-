<?php
if ( !function_exists ('workup_custom_styles') ) {
	function workup_custom_styles() {
		global $post;	
		
		ob_start();	
		?>
		
			<?php
				$main_font = workup_get_config('main_font');
				$main_font = isset($main_font['font-family']) ? $main_font['font-family'] : false;
			?>
			<?php if ( $main_font ): ?>
				/* Main Font */
				body
				{
					font-family: 
					<?php echo '\'' . $main_font . '\','; ?> 
					sans-serif;
				}
			<?php endif; ?>
			
			<?php
				$heading_font = workup_get_config('heading_font');
				$heading_font = isset($heading_font['font-family']) ? $heading_font['font-family'] : false;
			?>
			<?php if ( $heading_font ): ?>
				/* Heading Font */
				h1, h2, h3, h4, h5, h6, .widget-title,.widgettitle
				{
					font-family:  <?php echo '\'' . $heading_font . '\','; ?> sans-serif;
				}			
			<?php endif; ?>


			<?php if ( workup_get_config('main_color') != "" ) : ?>
				/* seting background main */
				.job-applicants .inner-result > div.active,
				.widget-jobs-tabs .nav-tabs,.skill-percents .skill-process > span,
				.pagination li > span:hover, .pagination li > span.current, .pagination li > a:hover, .pagination li > a.current, .apus-pagination li > span:hover, .apus-pagination li > span.current, .apus-pagination li > a:hover, .apus-pagination li > a.current,
				.cmb-form .cmb2-checkbox-list [type="checkbox"]:checked + label::before,.product-block.grid:hover .add-cart .added_to_cart, .product-block.grid:hover .add-cart .button,.product-block.grid .add-cart .added_to_cart,
				.job-tags a:hover,.cmb-form .button-primary,.cmb-form .cmb-row[data-fieldtype="wp_job_board_file"] .upload-file-btn,
				.pagination > span:hover, .pagination > span.current, .pagination > a:hover, .pagination > a.current, .apus-pagination > span:hover, .apus-pagination > span.current, .apus-pagination > a:hover, .apus-pagination > a.current,
				.btn-readmore::before,.post-layout .top-image .categories-name,
				.map-popup .icon-wrapper,.job_maps_sidebar .map-popup .icon-wrapper::before,
				.filter-listing-form .button,
				.candidate_resume_skill .progress-box .bar-fill,
				.employer-list:hover .open-job,
				.employer-detail-detail .apus-social-share a:hover, .employer-detail-detail .apus-social-share a:focus, .job-detail-detail .apus-social-share a:hover, .job-detail-detail .apus-social-share a:focus,
				.candidate-list:hover .btn-theme.btn-outline,
				.ui-slider-horizontal .ui-slider-range,.filter-listing-form .circle-check .list-item [type="checkbox"]:checked + label::before,
				.filter-listing-form .circle-check .list-item [type="radio"]:checked + label::before,
				.slick-carousel .slick-dots li.slick-active button,.btn-apply,
				.slick-carousel .slick-arrow:hover, .slick-carousel .slick-arrow:active, .slick-carousel .slick-arrow:focus,
				.job-grid:hover .btn-browse,.employer-grid:hover .open-job,
				.apus_socials a:hover, .apus_socials a:focus,
				.subwoo-inner .add-cart .added_to_cart, .subwoo-inner .add-cart .button,
				.subwoo-inner.is_featured .header-sub,
				.widget-achievements .inner-left .verify,
				.btn-theme,
				.bg-theme
				{
					background-color: <?php echo esc_html( workup_get_config('main_color') ) ?> ;
				}
				.map-popup .icon-wrapper,.map-popup .icon-wrapper::before{
					background-color: <?php echo esc_html( workup_get_config('main_color') ) ?> !important;
				}
				/* setting color */
				.job-applicants .inner-result > div,
				.header_transparent .no_keep_header .megamenu > li:hover > a, .header_transparent .no_keep_header .megamenu > li.active > a,
				#order_review .order-total .amount, #order_review .cart-subtotal .amount,
				.product-block.grid .add-cart .added_to_cart, .product-block.grid .add-cart .button,
				.job-detail-header.v1 .employer-logo-wrapper .category-employer,
				.widget-filter-job-top .toggle-adv:hover, .widget-filter-job-top .toggle-adv:focus,
				.btn-theme.btn-outline,.employer-detail-detail .icon, .job-detail-detail .icon,.employer-detail-detail .apus-social-share a, .job-detail-detail .apus-social-share a,
				.search_distance_wrapper .search-distance-label,
				.slick-carousel .slick-arrow,.job-list-v2 .deadline-time strong,.widget-features-box.style2 .features-box-image,
				.megamenu .dropdown-menu li.current-menu-item > a, .megamenu .dropdown-menu li.open > a, .megamenu .dropdown-menu li.active > a,.megamenu .dropdown-menu li:hover > a,
				.widget-mailchimp.style2 .input-group .btn,
				.apus-footer .widget-title, .apus-footer .widgettitle, .apus-footer .widget-heading,
				.widget-jobs-tabs .nav-tabs > li:hover > a, .widget-jobs-tabs .nav-tabs > li.active > a,
				.add-fix-top,
				a:focus,a:hover
				{
					color: <?php echo esc_html( workup_get_config('main_color') ) ?>;
				}

				.megamenu > li:hover > a, .megamenu > li.active > a,.btn-white,
				.text-theme {
					color: <?php echo esc_html( workup_get_config('main_color') ) ?> !important;
				}

				/* setting border color */
				.job-applicants .inner-result,
				.pagination li > span:hover, .pagination li > span.current, .pagination li > a:hover, .pagination li > a.current, .apus-pagination li > span:hover, .apus-pagination li > span.current, .apus-pagination li > a:hover, .apus-pagination li > a.current,
				.product-block.grid .add-cart .added_to_cart,
				.product-block.grid:hover,.product-block.grid:hover .add-cart .added_to_cart, .product-block.grid:hover .add-cart .button,
				.product-block.grid .add-cart .added_to_cart, .product-block.grid .add-cart .button,
				.cmb-form select:focus, .cmb-form textarea:focus, .cmb-form input[type="text"]:focus, .cmb-form input[type="number"]:focus,
				.job-tags a:hover::before,
				.pagination > span:hover, .pagination > span.current, .pagination > a:hover, .pagination > a.current, .apus-pagination > span:hover, .apus-pagination > span.current, .apus-pagination > a:hover, .apus-pagination > a.current,
				.employer-list:hover .open-job,
				.employer-detail-detail .apus-social-share a:hover, .employer-detail-detail .apus-social-share a:focus, .job-detail-detail .apus-social-share a:hover, .job-detail-detail .apus-social-share a:focus,
				.select2-container--default.select2-container.select2-container--open .select2-selection--single,
				.form-control:focus,
				.btn-theme.btn-outline,.candidate-list:hover .btn-theme.btn-outline,
				.ui-slider-horizontal .ui-slider-handle,.filter-listing-form .circle-check .list-item [type="checkbox"]:checked + label::before,
				.slick-carousel .slick-dots li,.btn-apply,
				.job-grid:hover .btn-browse,.employer-grid:hover .open-job,
				.apus_socials a:hover, .apus_socials a:focus,
				.subwoo-inner .add-cart .added_to_cart, .subwoo-inner .add-cart .button,
				.btn-theme,
				.border-theme
				{
					border-color: <?php echo esc_html( workup_get_config('main_color') ) ?>;
				}
				.filter-listing-form .circle-check .list-item [type="checkbox"]:checked + label::before{
					-webkit-box-shadow: 0 0 1px 1px <?php echo esc_html( workup_get_config('main_color') ) ?>;
					box-shadow: 0 0 1px 1px <?php echo esc_html( workup_get_config('main_color') ) ?>;
				}
			<?php endif; ?>

			<?php if ( workup_get_config('button_hover_color') != "" ) : ?>
				/* seting background main */
				.candidate-alert-form .button:hover, .candidate-alert-form .button:focus, .job-alert-form .button:hover, .job-alert-form .button:focus,
				.cmb-form .cmb-row[data-fieldtype="wp_job_board_file"] .upload-file-btn:hover,
				.cmb-form .cmb-row[data-fieldtype="wp_job_board_file"] .upload-file-btn:focus,
				.cmb-form .button-primary:hover,
				.cmb-form .button-primary:focus,
				.filter-listing-form .button:hover,
				.filter-listing-form .button:focus,
				.btn-theme.btn-outline:hover,
				.btn-theme.btn-outline:focus,
				.btn-apply:hover,.btn-apply:focus,
				.subwoo-inner .add-cart .added_to_cart:hover, .subwoo-inner .add-cart .added_to_cart:focus, .subwoo-inner .add-cart .button:hover, .subwoo-inner .add-cart .button:focus,
				.btn-theme:hover,
				.btn-theme:focus,
				.btn-theme.btn-outline:hover,
				.btn-theme.btn-outline:focus{
					border-color: <?php echo esc_html( workup_get_config('button_hover_color') ) ?> ;
					background-color: <?php echo esc_html( workup_get_config('button_hover_color') ) ?> ;
				}
			<?php endif; ?>

	<?php
		$content = ob_get_clean();
		$content = str_replace(array("\r\n", "\r"), "\n", $content);
		$lines = explode("\n", $content);
		$new_lines = array();
		foreach ($lines as $i => $line) {
			if (!empty($line)) {
				$new_lines[] = trim($line);
			}
		}
		
		return implode($new_lines);
	}
}