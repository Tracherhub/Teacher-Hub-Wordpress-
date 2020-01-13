<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
global $post;

$education = WP_Job_Board_Candidate::get_post_meta($post->ID, 'education', true );

if ( !empty($education) ) {
?>
    <div id="job-candidate-education" class="candidate-detail-education my_resume_eduarea">
        <h4 class="title"><?php esc_html_e('Education', 'workup'); ?></h4>
        <?php foreach ($education as $item) { ?>

            <div class="content">
                <div class="circle bgc-thm"></div>
                <?php if ( !empty($item['title']) ) { ?>
                    <h4 class="edu_stats text-theme"><?php echo esc_html($item['title']); ?></h4>
                <?php } ?>
                <?php if ( !empty($item['year']) ) { ?>
                    <div class="year"><?php echo esc_html($item['year']); ?></div>
                <?php } ?>
                <div class="edu_center">
                    <?php if ( !empty($item['academy']) ) { ?>
                        <span class="university"><?php echo esc_html($item['academy']); ?></span>
                    <?php } ?>
                </div>
                <?php if ( !empty($item['description']) ) { ?>
                    <p class="mb0"><?php echo esc_html($item['description']); ?></p>
                <?php } ?>
            </div>
            
        <?php } ?>
    </div>
<?php }