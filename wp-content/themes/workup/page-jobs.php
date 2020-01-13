<?php
/**
 * The template for displaying pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that
 * other "pages" on your WordPress site will use a different template.
 *
 * @package WordPress
 * @subpackage Workup
 * @since Workup 1.0
 */
/*
*Template Name: Jobs Template
*/

if ( isset( $_REQUEST['load_type'] ) && WP_Job_Board_Mixes::is_ajax_request() ) {
	if ( get_query_var( 'paged' ) ) {
	    $paged = get_query_var( 'paged' );
	} elseif ( get_query_var( 'page' ) ) {
	    $paged = get_query_var( 'page' );
	} else {
	    $paged = 1;
	}

	$query_args = array(
		'post_type' => 'job_listing',
	    'post_status' => 'publish',
	    'post_per_page' => wp_job_board_get_option('number_jobs_per_page', 10),
	    'paged' => $paged,
	);
	$params = null;
	if ( WP_Job_Board_Job_Filter::has_filter() ) {
		$params = $_GET;
	}

	$jobs = WP_Job_Board_Query::get_posts($query_args, $params);
	
	if ( 'jobs' !== $_REQUEST['load_type'] ) {
		echo WP_Job_Board_Template_Loader::get_template_part('archive-job_listing-ajax-full', array('jobs' => $jobs));
	} else {
		echo WP_Job_Board_Template_Loader::get_template_part('archive-job_listing-ajax-jobs', array('jobs' => $jobs));
	}
} else {
	get_header();

	$layout_type = workup_get_jobs_layout_type();

	if ( $layout_type == 'half-map' ) {
	?>
		<section id="main-container" class="inner">
			<div class="row no-margin layout-type-<?php echo esc_attr($layout_type); ?>">
				<div id="main-content" class="col-sm-12 col-md-7 no-padding">
					<div class="inner-left">
						<?php if ( is_active_sidebar( 'jobs-filter-sidebar' ) ): ?>
							<div class="filter-sidebar">
								<div class="mobile-groups-button hidden-lg hidden-md clearfix text-center">
									<button class=" btn btn-sm btn-theme btn-view-map" type="button"><i class="fa fa-map-o" aria-hidden="true"></i> <?php esc_html_e( 'Map View', 'workup' ); ?></button>
									<button class=" btn btn-sm btn-theme  btn-view-listing hidden-sm hidden-xs" type="button"><i class="fa fa-list" aria-hidden="true"></i> <?php esc_html_e( 'Listing View', 'workup' ); ?></button>
								</div>
								<span class="filter-in-sidebar visible-xs visible-sm"><i class="fa fa-sliders"></i></span>
								<div class="filter-scroll">
						   			<?php dynamic_sidebar( 'jobs-filter-sidebar' ); ?>
						   		</div>
						   	</div>
						   	<div class="over-dark"></div>
					   	<?php endif; ?>
					   	<div class="content-listing">
					   		
							<?php
							// Start the loop.
							while ( have_posts() ) : the_post();
								
								// Include the page content template.
								the_content();

								// If comments are open or we have at least one comment, load up the comment template.
								if ( comments_open() || get_comments_number() ) :
									comments_template();
								endif;

							// End the loop.
							endwhile;
							?>
						</div>
					</div><!-- .site-main -->
				</div><!-- .content-area -->
				<div class="col-md-5 no-padding">
					<div id="jobs-google-maps" class="hidden-sm hidden-xs fix-map"></div>
				</div>
			</div>
		</section>
	<?php
	} else {
		$sidebar_configs = workup_get_jobs_layout_configs();

		workup_render_breadcrumbs();
	?>
		<?php if ( workup_get_jobs_layout_type() == 'main' && is_active_sidebar( 'jobs-filter-top-sidebar' ) ) { ?>
			<div class="jobs-filter-top-sidebar-wrapper filter-top-sidebar-wrapper">
		   		<?php dynamic_sidebar( 'jobs-filter-top-sidebar' ); ?>
		   	</div>
		<?php } ?>
		<section id="main-container" class=" main-content <?php echo apply_filters('workup_page_content_class', 'container');?> inner">
			<?php workup_before_content( $sidebar_configs ); ?>
			<div class="row">
				<?php workup_display_sidebar_left( $sidebar_configs ); ?>

				<div id="main-content" class="col-sm-12 <?php echo esc_attr($sidebar_configs['main']['class']); ?>">
					<main id="main" class="site-main layout-type-<?php echo esc_attr($layout_type); ?>" role="main">

						<?php
						// Start the loop.
						while ( have_posts() ) : the_post();
							
							// Include the page content template.
							the_content();

							// If comments are open or we have at least one comment, load up the comment template.
							if ( comments_open() || get_comments_number() ) :
								comments_template();
							endif;

						// End the loop.
						endwhile;
						?>

					</main><!-- .site-main -->
				</div><!-- .content-area -->
				
				<?php workup_display_sidebar_right( $sidebar_configs ); ?>
			</div>
		</section>
	<?php
	}

	get_footer();
}