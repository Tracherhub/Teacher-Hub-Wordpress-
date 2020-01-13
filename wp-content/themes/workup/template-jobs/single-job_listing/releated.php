<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
global $post;

$relate_count = apply_filters('wp_job_board_number_job_releated', 3);
$relate_columns = workup_get_config('job_releated_columns', 4);

$tax_query = array();
$terms = WP_Job_Board_Job_Listing::get_job_taxs( $post->ID, 'job_listing_type' );
if ($terms) {
    $termids = array();
    foreach($terms as $term) {
        $termids[] = $term->term_id;
    }
    $tax_query[] = array(
        'taxonomy' => 'job_listing_type',
        'field' => 'id',
        'terms' => $termids,
        'operator' => 'IN'
    );
}
$terms = WP_Job_Board_Job_Listing::get_job_taxs( $post->ID, 'job_listing_category' );
if ($terms) {
    $termids = array();
    foreach($terms as $term) {
        $termids[] = $term->term_id;
    }
    $tax_query[] = array(
        'taxonomy' => 'job_listing_category',
        'field' => 'id',
        'terms' => $termids,
        'operator' => 'IN'
    );
}
if ( empty($tax_query) ) {
    return;
}
$args = array(
    'post_type' => 'job_listing',
    'posts_per_page' => $relate_count,
    'post__not_in' => array( get_the_ID() ),
    'tax_query' => array_merge(array( 'relation' => 'AND' ), $tax_query)
);
$relates = new WP_Query( $args );
if( $relates->have_posts() ):
?>
    <div class="widget releated-jobs">
        <h4 class="widget-title">
            <?php esc_html_e( 'Related Jobs', 'workup' ); ?>
        </h4>
        <div class="widget-content">
            <div class="row">
                <?php $i = 1;
                    while ( $relates->have_posts() ) : $relates->the_post(); ?>
                        <div class="col-xs-12 col-sm-6 col-md-<?php echo esc_attr(12/$relate_columns); ?> <?php echo esc_attr( ( $i%$relate_columns == 1)?'md-clearfix':''); ?> <?php echo esc_attr( ( $i%2 == 1)?'sm-clearfix':''); ?>">
                           <?php echo WP_Job_Board_Template_Loader::get_template_part( 'jobs-styles/inner-grid' ); ?>
                        </div>
                    <?php $i++; endwhile;
                ?>
            </div>
            <?php wp_reset_postdata(); ?>
        </div>
    </div>
<?php endif; ?>