<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$candidate_layout = workup_get_candidate_layout_type();
$candidate_layout = !empty($candidate_layout) ? $candidate_layout : 'v1';

workup_render_breadcrumbs();
?>
<section class="<?php echo 'candidate_single_layout'.esc_attr($candidate_layout) ?>">
	<section id="primary" class="content-area <?php echo apply_filters('workup_candidate_content_class', 'container');?> inner">
		<div id="main" class="site-main content" role="main">
			<?php if ( have_posts() ) : ?>
				<?php while ( have_posts() ) : the_post();
					global $post;
					if ( method_exists('WP_Job_Board_Candidate', 'check_view_candidate_detail') && !WP_Job_Board_Candidate::check_view_candidate_detail() ) {
						?>
						<div class="restrict-wrapper container">
							<!-- list cv package -->
							<?php
								$restrict_detail = wp_job_board_get_option('candidate_restrict_detail', 'all');
								switch ($restrict_detail) {
									case 'register_user':
										?>
										<h2 class="restrict-title"><?php esc_html_e( 'The page is restricted only for register user.', 'workup' ); ?></h2>
										<div class="restrict-content"><?php esc_html_e( 'You need login to view this page', 'workup' ); ?></div>
										<?php
										break;
									case 'only_applicants':
										?>
										<h2 class="restrict-title"><?php esc_html_e( 'The page is restricted only for employers view his applicants.', 'workup' ); ?></h2>
										<?php
										break;
									case 'register_employer':
										?>
										<h2 class="restrict-title"><?php esc_html_e( 'The page is restricted only for employers.', 'workup' ); ?></h2>
										<?php
										break;
									default:
										$content = apply_filters('wp-job-board-restrict-candidate-detail-information', '', $post);
										echo trim($content);
										break;
								}
							?>
						</div><!-- /.alert -->

						<?php
					} else {
						$latitude = WP_Job_Board_Candidate::get_post_meta( $post->ID, 'map_location_latitude', true );
						$longitude = WP_Job_Board_Candidate::get_post_meta( $post->ID, 'map_location_longitude', true );
					?>
						<div class="single-listing-wrapper" data-latitude="<?php echo esc_attr($latitude); ?>" data-longitude="<?php echo esc_attr($longitude); ?>">
							<?php
								if ( $candidate_layout !== 'v1' ) {
									echo WP_Job_Board_Template_Loader::get_template_part( 'content-single-candidate-'.$candidate_layout );
								} else {
									echo WP_Job_Board_Template_Loader::get_template_part( 'content-single-candidate' );
								}
							?>
						</div>
					<?php } ?>
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
<?php get_footer();
