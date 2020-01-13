<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
global $post;

$relate_count = apply_filters('wp_job_board_number_candidate_releated', 3);

$tax_query = array();

$terms = WP_Job_Board_Job_Listing::get_job_taxs( $post->ID, 'candidate_category' );
$relate_columns = workup_get_config('candidate_releated_columns', 3);
if ($terms) {
    $termids = array();
    foreach($terms as $term) {
        $termids[] = $term->term_id;
    }
    $tax_query[] = array(
        'taxonomy' => 'candidate_category',
        'field' => 'id',
        'terms' => $termids,
        'operator' => 'IN'
    );
}
if ( empty($tax_query) ) {
    return;
}
$args = array(
    'post_type' => 'candidate',
    'posts_per_page' => $relate_count,
    'post__not_in' => array( get_the_ID() ),
    'tax_query' => $tax_query
);
$relates = new WP_Query( $args );
if( $relates->have_posts() ):
?>
    <div class="widget releated-candidates">
        <h4 class="widget-title">
            <span><?php esc_html_e( 'Related Candidates', 'workup' ); ?></span>
        </h4>
        <div class="widget-content">
            <div class="row">
                <?php $i=1;
                    while ( $relates->have_posts() ) : $relates->the_post();
                        ?>
                        <div class="col-xs-12 col-sm-6 col-md-<?php echo esc_attr(12/$relate_columns); ?> <?php echo esc_attr( ( $i%$relate_columns == 1)?'md-clearfix':''); ?> <?php echo esc_attr( ( $i%2 == 1)?'sm-clearfix':''); ?>">
                            <?php echo WP_Job_Board_Template_Loader::get_template_part( 'candidates-styles/inner-grid' ); ?>
                        </div>
                        <?php
                    $i++; endwhile;
                ?>
            </div>
            <?php wp_reset_postdata(); ?>
        </div>
    </div>
<?php endif; ?>