<div id="apus-header-mobile" class="header-mobile hidden-lg clearfix">    
    <div class="container">
        <div class="row">
            <div class="flex-middle">
                <div class="col-xs-3">
                     <a href="#navbar-offcanvas" class="btn btn-showmenu btn-theme">
                        <i class="fa fa-bars"></i>
                    </a>
                </div>
                <div class="col-xs-6 text-center">
                    <?php
                        $logo = workup_get_config('media-mobile-logo');
                    ?>
                    <?php if( isset($logo['url']) && !empty($logo['url']) ): ?>
                        <div class="logo">
                            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" >
                                <img src="<?php echo esc_url( $logo['url'] ); ?>" alt="<?php bloginfo( 'name' ); ?>">
                            </a>
                        </div>
                    <?php else: ?>
                        <div class="logo logo-theme">
                            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" >
                                <img src="<?php echo esc_url( get_template_directory_uri().'/images/logo.png'); ?>" alt="<?php bloginfo( 'name' ); ?>">
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-xs-3">
                        <?php
                            if ( workup_is_wp_job_board_activated() ) {
                                if ( is_user_logged_in() ) {
                                    $user_id = get_current_user_id();
                                    $userdata = get_userdata($user_id);
                                    $user_name = $userdata->display_name;
                                    if ( WP_Job_Board_User::is_employer($user_id) || WP_Job_Board_User::is_candidate($user_id) ) {
                                        if ( WP_Job_Board_User::is_employer($user_id) ) {
                                            $menu_nav = 'employer-menu';
                                            $employer_id = WP_Job_Board_User::get_employer_by_user_id($user_id);
                                            $user_name = get_post_field('post_title', $employer_id);
                                        } else {
                                            $menu_nav = 'candidate-menu';
                                            $candidate_id = WP_Job_Board_User::get_candidate_by_user_id($user_id);
                                            $user_name = get_post_field('post_title', $candidate_id);
                                        }
                                    }
                                    if ( !empty($menu_nav) && has_nav_menu( $menu_nav ) ) {
                                    ?>
                                        <div class="top-wrapper-menu pull-right">
                                            <a class="drop-dow btn-menu-account" href="javascript:void(0);">
                                                <i class="ti-user"></i>
                                            </a>
                                            <?php
                                                
                                                    $args = array(
                                                        'theme_location' => $menu_nav,
                                                        'container_class' => 'inner-top-menu',
                                                        'menu_class' => 'nav navbar-nav topmenu-menu',
                                                        'fallback_cb' => '',
                                                        'menu_id' => '',
                                                        'walker' => new Workup_Nav_Menu()
                                                    );
                                                    wp_nav_menu($args);
                                                
                                            ?>
                                        </div>
                                        <?php } ?>
                            <?php } else {
                                $login_register_page_id = wp_job_board_get_option('login_register_page_id');
                            ?>
                                    <div class="top-wrapper-menu pull-right">
                                        <a class="drop-dow btn-menu-account" href="<?php echo esc_url( get_permalink( $login_register_page_id ) ); ?>">
                                            <i class="ti-user"></i>
                                        </a>
                                    </div>
                            <?php }
                        }
                        ?>
                </div>
            </div>
        </div>
    </div>
</div>