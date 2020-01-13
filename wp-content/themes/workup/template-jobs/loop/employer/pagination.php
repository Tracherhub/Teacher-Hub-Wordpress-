<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


?>
<div class="employers-pagination-wrapper main-pagination-wrapper">
	<?php
		$pagination_type = workup_get_employers_pagination();
		if ( $pagination_type == 'loadmore' || $pagination_type == 'infinite' ) {
			$next_link = get_next_posts_link( '&nbsp;', $employers->max_num_pages );
			if ( $next_link ) {
		?>
				<div class="ajax-pagination <?php echo trim($pagination_type == 'loadmore' ? 'loadmore-action' : 'infinite-action'); ?>">
					<div class="apus-pagination-next-link hidden"><?php echo wp_kses_post($next_link); ?></div>
					<a href="#" class="apus-loadmore-btn"><?php esc_html_e( 'Load more', 'workup' ); ?></a>
					<span href="#" class="apus-allproducts"><?php esc_html_e( 'All employers loaded.', 'workup' ); ?></span>
				</div>
		<?php
			}
		} else {
			WP_Job_Board_Mixes::custom_pagination( array(
				'wp_query' => $employers,
				'max_num_pages' => $employers->max_num_pages,
				'prev_text'     => '<i class="flaticon-left-arrow"></i>',
				'next_text'     => '<i class="flaticon-right-arrow"></i>',
			));
		}
	?>
</div>
