<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
global $post;


$categories = get_the_terms( $post->ID, 'candidate_category' );
$location_html = workup_candidate_display_full_location($post, 'icon', false);

$phone_html = workup_candidate_display_phone($post, false);
$email_html = workup_candidate_display_email($post, false);

$urgent = WP_Job_Board_Candidate::get_post_meta( $post->ID, 'urgent', true );
?>
<div class="candidate-detail-header">
    <div class="flex-sm row">
        <div class="col-xs-12"> 
            <div class="flex">
                <?php if ( has_post_thumbnail() ) { ?>
                    <div class="candidate-thumbnail flex-middle">
                        <div class="inner-image">
                            <a href="<?php the_permalink(); ?>">
                                <?php echo get_the_post_thumbnail( $post->ID, 'full' ); ?>
                            </a>
                        </div>
                    </div>
                <?php } ?>
                <div class="candidate-information">
                    <div class="title-wrapper">
                        <h1 class="candidate-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
                        <?php if ( $urgent ) { ?>
                            <span class="urgent"><?php esc_html_e('Urgent', 'workup'); ?></span>
                        <?php } ?>
                    </div>
                    <?php if ( ! empty( $categories ) && ! is_wp_error( $categories ) ) { ?>
                        <?php foreach ($categories as $term) { ?>
                            <a href="<?php echo get_term_link($term); ?>"><?php echo wp_kses_post($term->name); ?></a>
                        <?php } ?>
                    <?php } ?>

                    <div class="job-metas-cadidate">
                        <?php if ( $phone_html ) { ?>
                            <?php echo wp_kses_post($phone_html); ?>
                        <?php } ?>
                        <?php if ( $email_html ) { ?>
                            <?php echo wp_kses_post($email_html); ?>
                        <?php } ?>
                    </div>
                    <div class="job-metas-cadidate">
                        <?php if ( $location_html ) { ?>
                            <?php echo wp_kses_post($location_html); ?>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>  
        
    </div>
</div>