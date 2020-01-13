<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @package WordPress
 * @subpackage Workup
 * @since Workup 1.0
 */
/*
*Template Name: 404 Page
*/
get_header();
$icon = workup_get_config('icon-img');
?>
<section class="page-404">
	<div id="main-container" class="inner">
		<div id="main-content" class="main-page">
			<section class="error-404 not-found clearfix">
				<div class="container">
					<div class="clearfix text-center">
						<div class="top-image">
							<?php if( !empty($icon) && !empty($icon['url'])) { ?>
								<img src="<?php echo esc_url( $icon['url']); ?>" alt="<?php bloginfo( 'name' ); ?>">
							<?php }else{ ?>
								<img src="<?php echo esc_url( get_template_directory_uri().'/images/error.jpg'); ?>" alt="<?php bloginfo( 'name' ); ?>">
							<?php } ?>
						</div>
						<div class="slogan">
							<?php if(!empty(workup_get_config('404_title', '404')) ) { ?>
								<h4 class="title-big"><?php echo workup_get_config('404_title', 'Oops! That page can&rsquo;t be found.'); ?></h4>
							<?php } ?>
						</div>
						<div class="page-content">
							<div class="description">
								<?php echo workup_get_config('404_description', 'It looks like nothing was found at this location. Maybe try a search?'); ?>
							</div>
							<div class="return">
								<a class="btn-theme btn" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php echo esc_html__('Go To Home Page','workup') ?></a>
							</div>
						</div><!-- .page-content -->
					</div>
				</div>
			</section><!-- .error-404 -->
		</div><!-- .content-area -->
	</div>
</section>
<?php get_footer(); ?>