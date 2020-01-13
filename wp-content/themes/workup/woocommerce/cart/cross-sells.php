<?php
/**
 * Cross-sells
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product;

$crosssells = WC()->cart->get_cross_sells();

if ( sizeof( $crosssells ) == 0 ) return;

$args = array(
	'post_type'           => 'product',
	'ignore_sticky_posts' => 1,
	'no_found_rows'       => 1,
	'posts_per_page'      => -1,
	'post__in'            => $crosssells
);

$products = new WP_Query( $args );

if ( $products->have_posts() ) : ?>

	<div class="cross-sells products widget">
		<div class="woocommerce">
			<h2 class="widget-title"><?php esc_html_e( 'You may be interested in&hellip;', 'workup' ) ?></h2>

		<?php wc_get_template( 'layout-products/carousel.php',array( 'loop'=>$products,'columns'=> 4, 'show_nav' => 1, 'slick_top' => 'slick-carousel-top' ) ); ?>

	</div>

<?php endif;
