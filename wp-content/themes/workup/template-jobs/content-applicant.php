<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $post;

$candidate_id = get_post_meta( $post->ID, WP_JOB_BOARD_APPLICANT_PREFIX.'candidate_id', true );
$candidate = get_post($candidate_id);

$candidate_url = get_permalink($candidate_id);
$candidate_url = add_query_arg( 'applicant_id', $post->ID, $candidate_url );
$candidate_url = add_query_arg( 'candidate_id', $candidate_id, $candidate_url );
$candidate_url = add_query_arg( 'action', 'view-profile', $candidate_url );

$admin_url = admin_url( 'admin-ajax.php' );
$download_url = add_query_arg(array('action' => 'wp_job_board_ajax_download_resume_cv', 'post_id' => $candidate_id), $admin_url);

$rating_avg = WP_Job_Board_Review::get_ratings_average($candidate_id);

$viewed = get_post_meta( $post->ID, WP_JOB_BOARD_APPLICANT_PREFIX.'viewed', true );
$classes = $viewed ? 'viewed' : '';
?>

<?php do_action( 'wp_job_board_before_applicant_content', $post->ID ); ?>

<article <?php post_class('applicants-job job-applicant-wrapper clearfix '.$classes); ?>>

    <?php if ( has_post_thumbnail($candidate_id) ) { ?>
        <div class="applicant-thumbnail">
            <div class="inner">
                <a href="<?php echo esc_url( $candidate_url ); ?>" rel="bookmark">
                    <?php echo get_the_post_thumbnail( $candidate_id, 'thumbnail' ); ?>
                </a>
            </div>
            <?php if ( !empty($rating_avg) ) { ?>
                <div class="rating-avg"><?php echo round($rating_avg,1,PHP_ROUND_HALF_UP); ?></div>
            <?php } ?>
        </div>
    <?php } ?>
    <div class="applicant-information">
        <div class="flex-middle">
            <div class="left-info">
                <div class="flex-bottom-sm">
                    <h2 class="applicant-title">
                        <a href="<?php echo esc_url( $candidate_url ); ?>" rel="bookmark"><?php the_title(); ?></a>
                    </h2>

                    <div class="applicant-date text-theme">
                        <span class="space hidden-xs"> - </span>
                        <?php the_time( get_option('date_format', 'd M, Y') ); ?>
                    </div>
                </div>
                
                <?php if ( !empty($rating_avg) ) { ?>
                    <div class="rating-avg-star hidden-xs"><?php echo WP_Job_Board_Review::print_review($rating_avg); ?></div>
                <?php } ?>
                
                <div class="metas flex-middle-sm">
                    <?php workup_candidate_display_categories($candidate,'icon'); ?>
                    <div class="visible-lg"><?php workup_candidate_display_short_location($candidate); ?></div>
                    <div class="hidden-xs"><?php WP_Job_Board_Candidate::display_shortlist_link($candidate_id); ?></div>
                </div>
            </div>
            <div class="right-info ali-right hidden-xs">
                <div class="flex-middle">
                    <div class="applicant-action-button">
                        
                        <?php
                        if ( $download_url ) {
                        ?>
                            <a data-toggle="tooltip" href="<?php echo esc_url($download_url); ?>" title="<?php esc_attr_e('Download CV', 'workup'); ?>" class="btn-action-icon download"><i class="ti-download"></i></a>
                        <?php } ?>
                        <a data-toggle="tooltip" href="<?php echo esc_url( $candidate_url ); ?>" class="btn-action-icon view" rel="bookmark" title="<?php esc_attr_e('View Profile', 'workup'); ?>"><i class="ti-eye"></i></a>
                        <?php
                            $rejected = WP_Job_Board_Applicant::get_post_meta($post->ID, 'rejected', true);
                            if ( $rejected ) {
                                $reject_text = esc_html__('Rejected', 'workup');
                                $class = 'rejec rejected';
                            } else {
                                $reject_text = esc_html__('Reject', 'workup');
                                $class = 'rejec reject';
                            }
                        ?>
                        <a data-toggle="tooltip" title="<?php echo esc_attr($reject_text); ?>" href="javascript:void(0);" class="btn-action-icon btn-reject-job-applied <?php echo esc_attr($class); ?>" data-applicant_id="<?php echo esc_attr($post->ID); ?>" data-nonce="<?php echo esc_attr(wp_create_nonce( 'wp-job-board-reject-applied-nonce' )); ?>"><i class="ti-loop"></i></a>

                        <a data-toggle="tooltip" title="<?php esc_attr_e('Remove', 'workup'); ?>" href="javascript:void(0);" class="btn-action-icon btn-remove-job-applied remove" data-applicant_id="<?php echo esc_attr($post->ID); ?>" data-nonce="<?php echo esc_attr(wp_create_nonce( 'wp-job-board-remove-applied-nonce' )); ?>"><i class="ti-close"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="right-info bottom-info visible-xs">
        <div class="flex-middle">
            <div class="applicant-action-button">
                
                <?php
                if ( $download_url ) {
                ?>
                    <a data-toggle="tooltip" href="<?php echo esc_url($download_url); ?>" title="<?php esc_attr_e('Download CV', 'workup'); ?>" class="btn-action-icon download"><i class="ti-download"></i></a>
                <?php } ?>
                <a data-toggle="tooltip" href="<?php echo esc_url( $candidate_url ); ?>" class="btn-action-icon view" rel="bookmark" title="<?php esc_attr_e('View Profile', 'workup'); ?>"><i class="ti-eye"></i></a>
                <?php
                    $rejected = WP_Job_Board_Applicant::get_post_meta($post->ID, 'rejected', true);
                    if ( $rejected ) {
                        $reject_text = esc_html__('Rejected', 'workup');
                        $class = 'rejec rejected';
                    } else {
                        $reject_text = esc_html__('Reject', 'workup');
                        $class = 'rejec reject';
                    }
                ?>
                <a data-toggle="tooltip" title="<?php echo esc_attr($reject_text); ?>" href="javascript:void(0);" class="btn-action-icon btn-reject-job-applied <?php echo esc_attr($class); ?>" data-applicant_id="<?php echo esc_attr($post->ID); ?>" data-nonce="<?php echo esc_attr(wp_create_nonce( 'wp-job-board-reject-applied-nonce' )); ?>"><i class="ti-loop"></i></a>

                <a data-toggle="tooltip" title="<?php esc_attr_e('Remove', 'workup'); ?>" href="javascript:void(0);" class="btn-action-icon btn-remove-job-applied remove" data-applicant_id="<?php echo esc_attr($post->ID); ?>" data-nonce="<?php echo esc_attr(wp_create_nonce( 'wp-job-board-remove-applied-nonce' )); ?>"><i class="ti-close"></i></a>
            </div>
        </div>
    </div>
</article><!-- #post-## -->

<?php do_action( 'wp_job_board_after_applicant_content', $post->ID );