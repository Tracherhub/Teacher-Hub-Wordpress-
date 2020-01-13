<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
global $post;

$experience = WP_Job_Board_Candidate::get_post_meta($post->ID, 'experience', true );

if ( !empty($experience) ) {
?>
    <div id="job-candidate-experience" class="candidate-detail-experience my_resume_eduarea">
        <h4 class="title"><?php esc_html_e('Work &amp; Experience', 'workup'); ?></h4>
        <?php foreach ($experience as $item) { ?>
            <div class="content">
                <div class="circle bgc-thm"></div>
                <div class="edu_center">
                    <?php if ( !empty($item['title']) ) { ?>
                        <h4 class="edu_stats"><?php echo esc_html($item['title']); ?></h4>
                    <?php } ?>
                    <?php if ( !empty($item['start_date']) || !empty($item['end_date']) ) { ?>
                        <div class="start_date">
                            <?php if ( !empty($item['start_date']) ) { ?>
                                <?php echo esc_html($item['start_date']); ?>
                            <?php } ?>
                            <?php if ( !empty($item['end_date']) ) { ?>
                                - <?php echo esc_html($item['end_date']); ?>
                            <?php } ?>
                        </div>
                    <?php } ?>
                    <?php if ( !empty($item['company']) ) { ?>
                        <span class="university"><?php echo esc_html($item['company']); ?></span>
                    <?php } ?>
                </div>
                
                <?php if ( !empty($item['description']) ) { ?>
                    <p class="mb0"><?php echo esc_html($item['description']); ?></p>
                <?php } ?>
            </div>
        <?php } ?>
    </div>
<?php }