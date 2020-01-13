<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$job_layout = workup_get_job_layout_type();
$job_layout = !empty($job_layout) ? $job_layout : 'v1';

if ( $job_layout != 'v1' ) {
	workup_render_breadcrumbs();
}
?>
<section class="detail-version-<?php echo esc_attr($job_layout); ?>">
	<?php if ( $job_layout == 'v1' ) { ?>
		<?php if ( have_posts() ) : ?>
			<?php while ( have_posts() ) : the_post(); ?>
				<!-- heading -->
				<?php echo WP_Job_Board_Template_Loader::get_template_part( 'single-job_listing/header' ); ?>
			<?php endwhile; ?>
		<?php endif; ?>
	<?php } ?>
	<section id="primary" class="content-area <?php echo apply_filters('workup_job_content_class', 'container');?> inner">
		<div id="main" class="site-main content" role="main">
			<?php if ( have_posts() ) : ?>

				<?php while ( have_posts() ) : the_post();
					global $post;
					$latitude = WP_Job_Board_Job_Listing::get_post_meta( $post->ID, 'map_location_latitude', true );
					$longitude = WP_Job_Board_Job_Listing::get_post_meta( $post->ID, 'map_location_longitude', true );
				?>
					<div class="single-listing-wrapper" data-latitude="<?php echo esc_attr($latitude); ?>" data-longitude="<?php echo esc_attr($longitude); ?>">
						<?php
							if ( $job_layout !== 'v1' ) {
								echo WP_Job_Board_Template_Loader::get_template_part( 'content-single-job_listing-'.$job_layout );
							} else {
								echo WP_Job_Board_Template_Loader::get_template_part( 'content-single-job_listing' );
							}
						?>
					</div>
				<?php endwhile; ?>

				<?php the_posts_pagination( array(
					'prev_text'          => esc_html__( 'Previous page', 'workup' ),
					'next_text'          => esc_html__( 'Next page', 'workup' ),
					'before_page_number' => '<span class="meta-nav screen-reader-text">' . esc_html__( 'Page', 'workup' ) . ' </span>',
				) ); ?>
			<?php else : ?>
				<?php get_template_part( 'content', 'none' ); ?>
			<?php endif; ?>
		</div><!-- .site-main -->
	</section><!-- .content-area -->
</section>
<?php get_footer(); ?>
