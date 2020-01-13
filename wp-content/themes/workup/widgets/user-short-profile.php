<?php 
if ( !is_user_logged_in() || !class_exists('WP_Job_Board_User') ) {
    return;
}

$title = apply_filters('widget_title', $instance['title']);
if ( $title ) {
    echo trim($before_title)  . trim( $title ) . $after_title;
}
$user_id = get_current_user_id();
if ( WP_Job_Board_User::is_employer($user_id) ) {
        $employer_id = WP_Job_Board_User::get_employer_by_user_id($user_id);
        if ( has_post_thumbnail($employer_id) ) {
            $logo = get_the_post_thumbnail( $employer_id, 'thumbnail' );
        }
        $title = get_the_title($employer_id);
        $locations = get_the_terms( $employer_id, 'employer_location' );

        if ($nav_menu_employer) {
            $term = get_term_by( 'slug', $nav_menu_employer, 'nav_menu' );
            if ( !empty($term) ) {
                $nav_menu_id = $term->term_id;
            }
        }
    } elseif ( WP_Job_Board_User::is_candidate() ) {
        $candidate_id = WP_Job_Board_User::get_candidate_by_user_id($user_id);
        if ( has_post_thumbnail($candidate_id) ) {
            $logo = get_the_post_thumbnail( $candidate_id, 'thumbnail' );
        }
        $title = get_the_title($candidate_id);
        $locations = get_the_terms( $candidate_id, 'candidate_location' );

        if ($nav_menu_candidate) {
            $term = get_term_by( 'slug', $nav_menu_candidate, 'nav_menu' );
            if ( !empty($term) ) {
                $nav_menu_id = $term->term_id;
            }
        }
        $profile_percents = WP_Job_Board_User::compute_profile_percent($candidate_id);
    } else {
        return;
    }
?>
<?php if ( $nav_menu_id ) { ?>
    <div class="user_short_profile">
        <?php
            $args = array(
                'menu'        => $nav_menu_id,
                'container_class' => 'navbar-collapse no-padding',
                'menu_class' => 'menu_short_profile',
                'fallback_cb' => '',
                'walker' => new Workup_Nav_Menu()
            );
            wp_nav_menu($args);
        ?>
    </div>
<?php } ?>

<?php if ( !empty($profile_percents) ) { ?>
    <div class="skill-percents">
        <h4><?php esc_html_e('Skills Percentage:', 'workup'); ?> <span><?php echo esc_html($profile_percents['percent']*100).'%'; ?></span></h4>
        <div class="skill-process">
            <span style="width:<?php echo esc_html($profile_percents['percent']*100); ?>%;"></span>
        </div>
        <?php if ( !empty($profile_percents['empty_fields']) ) { ?>
            <div class="value-percents">
                <?php
                    if ( count($profile_percents['empty_fields']) < 4 ) {
                        echo sprintf(__('Put value for %s field to increase your skill up to <strong class="text-info">"%s"</strong>', 'workup'), '<span class="text-theme">"'.implode('"</span>, <span class="text-theme">"', $profile_percents['empty_fields']).'"</span>', ((1 - $profile_percents['percent'])*100).'%' );
                    } else {
                        echo sprintf(__('Put value for resume, profile fields to increase your skill up to <strong class="text-info">"%s"</strong>', 'workup'), ((1 - $profile_percents['percent'])*100).'%' );
                    }
                ?>
            </div>
        <?php } else { ?>
        <?php } ?>
    </div>
<?php } ?>