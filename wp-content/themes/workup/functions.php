<?php
/**
 * workup functions and definitions
 *
 * Set up the theme and provides some helper functions, which are used in the
 * theme as custom template tags. Others are attached to action and filter
 * hooks in WordPress to change core functionality.
 *
 * When using a child theme you can override certain functions (those wrapped
 * in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before
 * the parent theme's file, so the child theme functions would be used.
 *
 * @link https://codex.wordpress.org/Theme_Development
 * @link https://codex.wordpress.org/Child_Themes
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are
 * instead attached to a filter or action hook.
 *
 * For more information on hooks, actions, and filters,
 * {@link https://codex.wordpress.org/Plugin_API}
 *
 * @package WordPress
 * @subpackage Workup
 * @since Workup 1.0.5
 */

define( 'WORKUP_THEME_VERSION', '1.0.5' );
define( 'WORKUP_DEMO_MODE', false );

if ( ! isset( $content_width ) ) {
	$content_width = 660;
}

if ( ! function_exists( 'workup_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 *
 * @since Workup 1.0
 */
function workup_setup() {

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on workup, use a find and replace
	 * to change 'workup' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'workup', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * See: https://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 1200, 750, true );
	add_image_size( 'workup-blog-small', 55, 55, true );

	// This theme uses wp_nav_menu() in two locations.
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary Menu', 'workup' ),
		'employer-menu' => esc_html__( 'Employer Menu', 'workup' ),
		'candidate-menu' => esc_html__( 'Candidate Menu', 'workup' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
	) );

	add_theme_support( "woocommerce", array('gallery_thumbnail_image_width' => 410) );
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );

	
	/*
	 * Enable support for Post Formats.
	 *
	 * See: https://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'aside', 'image', 'video', 'quote', 'link', 'gallery', 'status', 'audio', 'chat'
	) );

	$color_scheme  = workup_get_color_scheme();
	$default_color = trim( $color_scheme[0], '#' );

	// Setup the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'workup_custom_background_args', array(
		'default-color'      => $default_color,
		'default-attachment' => 'fixed',
	) ) );

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	// Add support for Block Styles.
	add_theme_support( 'wp-block-styles' );

	// Add support for full and wide align images.
	add_theme_support( 'align-wide' );

	// Add support for editor styles.
	add_theme_support( 'editor-styles' );

	// Add support for responsive embeds.
	add_theme_support( 'responsive-embeds' );

	// Enqueue editor styles.
	add_editor_style( array( 'css/style-editor.css', workup_get_fonts_url() ) );

	workup_get_load_plugins();
}
endif; // workup_setup
add_action( 'after_setup_theme', 'workup_setup' );

/**
 * Load Google Front
 */

function workup_get_fonts_url() {
    $fonts_url = '';

    /* Translators: If there are characters in your language that are not
    * supported by Montserrat, translate this to 'off'. Do not translate
    * into your own language.
    */
    $montserrat = _x( 'on', 'Montserrat font: on or off', 'workup' );
    $josefin = _x( 'on', 'Josefin Sans font: on or off', 'workup' );
    $poppins = _x( 'on', 'Poppins Sans font: on or off', 'workup' );

    if ( 'off' !== $montserrat || 'off' !== $josefin || 'off' !== $poppins ) {
        $font_families = array();
        if ( 'off' !== $montserrat ) {
            $font_families[] = 'Montserrat:400,500,600,700,800';
        }
        if ( 'off' !== $josefin ) {
            $font_families[] = 'Josefin+Sans:300,300i';
        }

        if ( 'off' !== $poppins ) {
            $font_families[] = 'Poppins:400,600';
        }

        $query_args = array(
            'family' => ( implode( '|', $font_families ) ),
            'subset' => urlencode( 'latin,latin-ext' ),
        );
 		
 		$protocol = is_ssl() ? 'https:' : 'http:';
        $fonts_url = add_query_arg( $query_args, $protocol .'//fonts.googleapis.com/css' );
    }
 
    return esc_url( $fonts_url );
}

/**
 * Enqueue styles.
 *
 * @since Workup 1.0
 */
function workup_enqueue_styles() {
	
	// load font
	wp_enqueue_style( 'workup-theme-fonts', workup_get_fonts_url(), array(), null );

	//load font awesome
	wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/css/font-awesome.css', array(), '4.5.0' );

	//load font flaticon
	wp_enqueue_style( 'workup-flaticon', get_template_directory_uri() . '/css/flaticon.css', array(), '1.0.0' );

	// load font themify icon
	wp_enqueue_style( 'themify-icons', get_template_directory_uri() . '/css/themify-icons.css', array(), '1.0.0' );
	
	wp_enqueue_style( 'line-font', get_template_directory_uri() . '/css/line-font.css', array(), '1.0.0' );
		
	// load animate version 3.6.0
	wp_enqueue_style( 'animate', get_template_directory_uri() . '/css/animate.css', array(), '3.6.0' );

	// load bootstrap style
	if( is_rtl() ){
		wp_enqueue_style( 'bootstrap-rtl', get_template_directory_uri() . '/css/bootstrap-rtl.css', array(), '3.2.0' );
	} else {
		wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/css/bootstrap.css', array(), '3.2.0' );
	}
	// slick
	wp_enqueue_style( 'slick', get_template_directory_uri() . '/css/slick.css', array(), '1.8.0' );
	// magnific-popup
	wp_enqueue_style( 'magnific-popup', get_template_directory_uri() . '/css/magnific-popup.css', array(), '1.1.0' );
	// perfect scrollbar
	wp_enqueue_style( 'perfect-scrollbar', get_template_directory_uri() . '/css/perfect-scrollbar.css', array(), '0.6.12' );
	// mobile menu
	wp_enqueue_style( 'jquery-mmenu', get_template_directory_uri() . '/js/mmenu/jquery.mmenu.css', array(), '0.6.12' );
	// main style
	wp_enqueue_style( 'workup-template', get_template_directory_uri() . '/css/template.css', array(), '1.0' );
	
	$custom_style = workup_custom_styles();
	if ( !empty($custom_style) ) {
		wp_add_inline_style( 'workup-template', $custom_style );
	}
	wp_enqueue_style( 'workup-style', get_template_directory_uri() . '/style.css', array(), '1.0' );

	wp_deregister_style('yith-wcwl-font-awesome');
}
add_action( 'wp_enqueue_scripts', 'workup_enqueue_styles', 100 );

function workup_login_enqueue_styles() {
	wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/css/font-awesome.css', array(), '4.5.0' );
	wp_enqueue_style( 'workup-login-style', get_template_directory_uri() . '/css/login-style.css', array(), '1.0' );
}
add_action( 'login_enqueue_scripts', 'workup_login_enqueue_styles', 10 );
/**
 * Enqueue scripts.
 *
 * @since Workup 1.0
 */
function workup_enqueue_scripts() {
	
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
	// bootstrap
	wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/js/bootstrap.min.js', array( 'jquery' ), '20150330', true );
	// slick
	wp_enqueue_script( 'slick', get_template_directory_uri() . '/js/slick.min.js', array( 'jquery' ), '1.8.0', true );
	// countdown
	wp_register_script( 'countdown', get_template_directory_uri() . '/js/countdown.js', array( 'jquery' ), '20150315', true );
	wp_localize_script( 'countdown', 'workup_countdown_opts', array(
		'days' => esc_html__('Days', 'workup'),
		'hours' => esc_html__('Hrs', 'workup'),
		'mins' => esc_html__('Mins', 'workup'),
		'secs' => esc_html__('Secs', 'workup'),
	));
	wp_enqueue_script( 'countdown' );
	// popup
	wp_enqueue_script( 'jquery-magnific-popup', get_template_directory_uri() . '/js/jquery.magnific-popup.min.js', array( 'jquery' ), '1.1.0', true );
	// unviel
	wp_enqueue_script( 'jquery-unveil', get_template_directory_uri() . '/js/jquery.unveil.js', array( 'jquery' ), '1.1.0', true );
	// perfect scrollbar
	wp_enqueue_script( 'perfect-scrollbar', get_template_directory_uri() . '/js/perfect-scrollbar.jquery.min.js', array( 'jquery' ), '0.6.12', true );
	
	if ( workup_get_config('enable_smooth_scroll') ) {
		wp_enqueue_script( 'SmoothScroll', get_template_directory_uri() . '/js/SmoothScroll.js', '1.3.0', true );
	}
	// mobile menu script
	wp_enqueue_script( 'jquery-mmenu', get_template_directory_uri() . '/js/mmenu/jquery.mmenu.js', array( 'jquery' ), '0.6.12', true );
	
	// addthis
	wp_register_script('addthis', '//s7.addthis.com/js/250/addthis_widget.js', array(), '0.6.12', true);
	
	// main script
	wp_register_script( 'workup-functions', get_template_directory_uri() . '/js/functions.js', array( 'jquery' ), '20150330', true );
	wp_localize_script( 'workup-functions', 'workup_ajax', array(
		'ajaxurl' => admin_url( 'admin-ajax.php' ),
		'previous' => esc_html__('Previous', 'workup'),
		'next' => esc_html__('Next', 'workup'),
	));
	wp_enqueue_script( 'workup-functions' );
	
	wp_add_inline_script( 'workup-functions', "(function(html){html.className = html.className.replace(/\bno-js\b/,'js')})(document.documentElement);" );
}
add_action( 'wp_enqueue_scripts', 'workup_enqueue_scripts', 1 );

/**
 * Add a `screen-reader-text` class to the search form's submit button.
 *
 * @since Workup 1.0
 *
 * @param string $html Search form HTML.
 * @return string Modified search form HTML.
 */
function workup_search_form_modify( $html ) {
	return str_replace( 'class="search-submit"', 'class="search-submit screen-reader-text"', $html );
}
add_filter( 'get_search_form', 'workup_search_form_modify' );

/**
 * Function get opt_name
 *
 */
function workup_get_opt_name() {
	return 'workup_theme_options';
}
add_filter( 'apus_framework_get_opt_name', 'workup_get_opt_name' );


function workup_register_demo_mode() {
	if ( defined('WORKUP_DEMO_MODE') && WORKUP_DEMO_MODE ) {
		return true;
	}
	return false;
}
add_filter( 'apus_framework_register_demo_mode', 'workup_register_demo_mode' );

function workup_get_demo_preset() {
	$preset = '';
    if ( defined('WORKUP_DEMO_MODE') && WORKUP_DEMO_MODE ) {
        if ( isset($_REQUEST['_preset']) && $_REQUEST['_preset'] ) {
            $presets = get_option( 'apus_framework_presets' );
            if ( is_array($presets) && isset($presets[$_REQUEST['_preset']]) ) {
                $preset = $_REQUEST['_preset'];
            }
        } else {
            $preset = get_option( 'apus_framework_preset_default' );
        }
    }
    return $preset;
}

function workup_get_config($name, $default = '') {
	global $workup_options;
    if ( isset($workup_options[$name]) ) {
        return $workup_options[$name];
    }
    return $default;
}

function workup_set_exporter_settings_option_keys($option_keys) {
	return array(
		'elementor_disable_color_schemes',
		'elementor_disable_typography_schemes',
		'elementor_allow_tracking',
		'elementor_cpt_support',
		'wp_job_board_settings',
	);
}
add_filter( 'apus_exporter_ocdi_settings_option_keys', 'workup_set_exporter_settings_option_keys' );

function workup_disable_one_click_import() {
	return false;
}
add_filter('apus_frammework_enable_one_click_import', 'workup_disable_one_click_import');

function workup_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar Default', 'workup' ),
		'id'            => 'sidebar-default',
		'description'   => esc_html__( 'Add widgets here to appear in your Sidebar.', 'workup' ),
		'before_widget' => '<aside class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
	
	register_sidebar( array(
		'name'          => esc_html__( 'Jobs filter sidebar', 'workup' ),
		'id'            => 'jobs-filter-sidebar',
		'description'   => esc_html__( 'Add widgets here to appear in your sidebar.', 'workup' ),
		'before_widget' => '<aside class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title"><span>',
		'after_title'   => '</span></h2>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Jobs filter top sidebar', 'workup' ),
		'id'            => 'jobs-filter-top-sidebar',
		'description'   => esc_html__( 'Add widgets here to appear in your sidebar.', 'workup' ),
		'before_widget' => '<aside class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title"><span>',
		'after_title'   => '</span></h2>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Job single sidebar', 'workup' ),
		'id'            => 'job-single-sidebar',
		'description'   => esc_html__( 'Add widgets here to appear in your sidebar.', 'workup' ),
		'before_widget' => '<aside class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title"><span>',
		'after_title'   => '</span></h2>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Employers filter sidebar', 'workup' ),
		'id'            => 'employers-filter-sidebar',
		'description'   => esc_html__( 'Add widgets here to appear in your sidebar.', 'workup' ),
		'before_widget' => '<aside class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title"><span>',
		'after_title'   => '</span></h2>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Employer single sidebar', 'workup' ),
		'id'            => 'employer-single-sidebar',
		'description'   => esc_html__( 'Add widgets here to appear in your sidebar.', 'workup' ),
		'before_widget' => '<aside class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title"><span>',
		'after_title'   => '</span></h2>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Candidates filter sidebar', 'workup' ),
		'id'            => 'candidates-filter-sidebar',
		'description'   => esc_html__( 'Add widgets here to appear in your sidebar.', 'workup' ),
		'before_widget' => '<aside class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title"><span>',
		'after_title'   => '</span></h2>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Candidate single sidebar', 'workup' ),
		'id'            => 'candidate-single-sidebar',
		'description'   => esc_html__( 'Add widgets here to appear in your sidebar.', 'workup' ),
		'before_widget' => '<aside class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title"><span>',
		'after_title'   => '</span></h2>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'User Profile sidebar', 'workup' ),
		'id'            => 'user-profile-sidebar',
		'description'   => esc_html__( 'Add widgets here to appear in your sidebar.', 'workup' ),
		'before_widget' => '<aside class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title"><span>',
		'after_title'   => '</span></h2>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Blog sidebar', 'workup' ),
		'id'            => 'blog-sidebar',
		'description'   => esc_html__( 'Add widgets here to appear in your sidebar.', 'workup' ),
		'before_widget' => '<aside class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title"><span>',
		'after_title'   => '</span></h2>',
	) );

}
add_action( 'widgets_init', 'workup_widgets_init' );

function workup_get_load_plugins() {

	$plugins[] = array(
		'name'                     => esc_html__( 'Apus Framework For Themes', 'workup' ),
        'slug'                     => 'apus-framework',
        'required'                 => true ,
        'source'				   => get_template_directory() . '/inc/plugins/apus-framework.zip'
	);

	$plugins[] = array(
		'name'                     => esc_html__( 'Elementor Page Builder', 'workup' ),
	    'slug'                     => 'elementor',
	    'required'                 => true,
	);
	
	$plugins[] = array(
		'name'                     => esc_html__( 'Cmb2', 'workup' ),
	    'slug'                     => 'cmb2',
	    'required'                 => true,
	);

	$plugins[] = array(
		'name'                     => esc_html__( 'MailChimp for WordPress', 'workup' ),
	    'slug'                     => 'mailchimp-for-wp',
	    'required'                 =>  true
	);

	$plugins[] = array(
		'name'                     => esc_html__( 'Contact Form 7', 'workup' ),
	    'slug'                     => 'contact-form-7',
	    'required'                 => true,
	);

	// woocommerce plugins
	$plugins[] = array(
		'name'                     => esc_html__( 'Woocommerce', 'workup' ),
	    'slug'                     => 'woocommerce',
	    'required'                 => true,
	);
	
	// Job plugins
	$plugins[] = array(
		'name'                     => esc_html__( 'WP Job Board', 'workup' ),
        'slug'                     => 'wp-job-board',
        'required'                 => true ,
        'source'				   => get_template_directory() . '/inc/plugins/wp-job-board.zip'
	);

	$plugins[] = array(
		'name'                     => esc_html__( 'WP Job Board - WooCommerce Paid Listings', 'workup' ),
        'slug'                     => 'wp-job-board-wc-paid-listings',
        'required'                 => true ,
        'source'				   => get_template_directory() . '/inc/plugins/wp-job-board-wc-paid-listings.zip'
	);

	$plugins[] = array(
		'name'                     => esc_html__( 'WP Private Message', 'workup' ),
        'slug'                     => 'wp-private-message',
        'required'                 => true ,
        'source'				   => get_template_directory() . '/inc/plugins/wp-private-message.zip'
	);
	
	$plugins[] = array(
        'name'                  => esc_html__( 'One Click Demo Import', 'workup' ),
        'slug'                  => 'one-click-demo-import',
        'required'              => false,
        'force_activation'      => false,
        'force_deactivation'    => false,
        'external_url'          => '',
    );

	tgmpa( $plugins );
}

require get_template_directory() . '/inc/plugins/class-tgm-plugin-activation.php';
require get_template_directory() . '/inc/functions-helper.php';
require get_template_directory() . '/inc/functions-frontend.php';

/**
 * Implement the Custom Header feature.
 *
 */
require get_template_directory() . '/inc/custom-header.php';
require get_template_directory() . '/inc/classes/megamenu.php';
require get_template_directory() . '/inc/classes/mobilemenu.php';

/**
 * Custom template tags for this theme.
 *
 */
require get_template_directory() . '/inc/template-tags.php';

if ( defined( 'APUS_FRAMEWORK_REDUX_ACTIVED' ) ) {
	require get_template_directory() . '/inc/vendors/redux-framework/redux-config.php';
	define( 'WORKUP_REDUX_FRAMEWORK_ACTIVED', true );
}
if( workup_is_cmb2_activated() ) {
	require get_template_directory() . '/inc/vendors/cmb2/page.php';
	define( 'WORKUP_CMB2_ACTIVED', true );
}
if( workup_is_woocommerce_activated() ) {
	require get_template_directory() . '/inc/vendors/woocommerce/functions.php';
	require get_template_directory() . '/inc/vendors/woocommerce/functions-redux-configs.php';
	define( 'WORKUP_WOOCOMMERCE_ACTIVED', true );
}

if( workup_is_wp_job_board_activated() ) {
	require get_template_directory() . '/inc/vendors/wp-job-board/functions-redux-configs.php';
	require get_template_directory() . '/inc/vendors/wp-job-board/functions.php';
	require get_template_directory() . '/inc/vendors/wp-job-board/functions-employer.php';
	require get_template_directory() . '/inc/vendors/wp-job-board/functions-candidate.php';

	require get_template_directory() . '/inc/vendors/wp-job-board/functions-job-display.php';
	require get_template_directory() . '/inc/vendors/wp-job-board/functions-employer-display.php';
	require get_template_directory() . '/inc/vendors/wp-job-board/functions-candidate-display.php';
}

if ( workup_is_wp_job_board_wc_paid_listings_activated() ) {
	require get_template_directory() . '/inc/vendors/wp-job-board-wc-paid-listings/functions.php';
}

if( workup_is_apus_framework_activated() ) {
	require get_template_directory() . '/inc/widgets/custom_menu.php';
	require get_template_directory() . '/inc/widgets/recent_post.php';
	require get_template_directory() . '/inc/widgets/search.php';
	require get_template_directory() . '/inc/widgets/socials.php';
	require get_template_directory() . '/inc/widgets/user-short-profile.php';
	
	if ( workup_is_wp_job_board_activated() ) {
		require get_template_directory() . '/inc/widgets/candidate-contact-form.php';
		require get_template_directory() . '/inc/widgets/candidate-info.php';
		require get_template_directory() . '/inc/widgets/candidate-cv.php';
		require get_template_directory() . '/inc/widgets/candidate-buttons.php';

		require get_template_directory() . '/inc/widgets/employer-contact-form.php';
		require get_template_directory() . '/inc/widgets/employer-info.php';
		require get_template_directory() . '/inc/widgets/employer-maps.php';
		
		require get_template_directory() . '/inc/widgets/job-info.php';
		require get_template_directory() . '/inc/widgets/job-maps.php';
		require get_template_directory() . '/inc/widgets/job-statistics.php';
		require get_template_directory() . '/inc/widgets/job-also-viewed.php';
		require get_template_directory() . '/inc/widgets/job-buttons.php';
		require get_template_directory() . '/inc/widgets/job-social-share.php';
		require get_template_directory() . '/inc/widgets/job-employer-info.php';
		
		require get_template_directory() . '/inc/widgets/job-filter-horizontal.php';
	}
	define( 'WORKUP_FRAMEWORK_ACTIVED', true );
}
if ( workup_is_wp_private_message() ) {
	require get_template_directory() . '/inc/vendors/wp-private-message/functions.php';
}

require get_template_directory() . '/inc/vendors/elementor/functions.php';
require get_template_directory() . '/inc/vendors/one-click-demo-import/functions.php';

function workup_register_post_types($post_types) {
	foreach ($post_types as $key => $post_type) {
		if ( $post_type == 'brand' || $post_type == 'testimonial' ) {
			unset($post_types[$key]);
		}
	}
	if ( !in_array('header', $post_types) ) {
		$post_types[] = 'header';
	}
	return $post_types;
}
add_filter( 'apus_framework_register_post_types', 'workup_register_post_types' );


/**
 * Customizer additions.
 *
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Custom Styles
 *
 */
require get_template_directory() . '/inc/custom-styles.php';