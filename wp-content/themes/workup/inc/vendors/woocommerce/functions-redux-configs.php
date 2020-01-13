<?php

// Shop Archive settings
function workup_woo_redux_config($sections, $sidebars, $columns) {
    
    $sections[] = array(
        'icon' => 'el el-shopping-cart',
        'title' => esc_html__('Shop Settings', 'workup'),
        'fields' => array(
            array(
                'id' => 'products_breadcrumb_setting',
                'icon' => true,
                'type' => 'info',
                'raw' => '<h3 style="margin: 0;"> '.esc_html__('Breadcrumbs Setting', 'workup').'</h3>',
            ),
            array(
                'id' => 'show_product_breadcrumbs',
                'type' => 'switch',
                'title' => esc_html__('Breadcrumbs', 'workup'),
                'default' => 1
            ),
            array(
                'title' => esc_html__('Breadcrumbs Background Color', 'workup'),
                'subtitle' => '<em>'.esc_html__('The breadcrumbs background color of the site.', 'workup').'</em>',
                'id' => 'woo_breadcrumb_color',
                'type' => 'color',
                'transparent' => false,
            ),
            array(
                'id' => 'woo_breadcrumb_image',
                'type' => 'media',
                'title' => esc_html__('Breadcrumbs Background', 'workup'),
                'subtitle' => esc_html__('Upload a .jpg or .png image that will be your breadcrumbs.', 'workup'),
            ),
            array(
                'id' => 'woo_breadcrumb_style',
                'type' => 'select',
                'title' => esc_html__('Breadcrumbs Style', 'workup'),
                'options' => array(
                    'default' => esc_html__('Default', 'workup'),
                    'center' => esc_html__('Style 1', 'workup'),
                ),
                'default' => 'default'
            ),
        )
    );
    // Archive settings
    $sections[] = array(
        'title' => esc_html__('Product Archives', 'workup'),
        'subsection' => true,
        'fields' => array(
            array(
                'id' => 'products_general_setting',
                'icon' => true,
                'type' => 'info',
                'raw' => '<h3 style="margin: 0;"> '.esc_html__('General Setting', 'workup').'</h3>',
            ),
            array(
                'id' => 'show_shop_cat_title',
                'type' => 'switch',
                'title' => esc_html__('Show Shop/Category Title ?', 'workup'),
                'default' => 1
            ),
            array(
                'id' => 'product_display_mode',
                'type' => 'select',
                'title' => esc_html__('Products Layout', 'workup'),
                'subtitle' => esc_html__('Choose a default layout archive product.', 'workup'),
                'options' => array(
                    'grid' => esc_html__('Grid', 'workup'),
                    'list' => esc_html__('List', 'workup'),
                ),
                'default' => 'grid'
            ),
            array(
                'id' => 'product_columns',
                'type' => 'select',
                'title' => esc_html__('Product Columns', 'workup'),
                'options' => $columns,
                'default' => 4,
                'required' => array('product_display_mode', '=', array('grid'))
            ),
            array(
                'id' => 'number_products_per_page',
                'type' => 'text',
                'title' => esc_html__('Number of Products Per Page', 'workup'),
                'default' => 12,
                'min' => '1',
                'step' => '1',
                'max' => '100',
                'type' => 'slider'
            ),
            array(
                'id' => 'enable_swap_image',
                'type' => 'switch',
                'title' => esc_html__('Enable Swap Image', 'workup'),
                'default' => 1
            ),

            array(
                'id' => 'products_sidebar_setting',
                'icon' => true,
                'type' => 'info',
                'raw' => '<h3 style="margin: 0;"> '.esc_html__('Sidebar Setting', 'workup').'</h3>',
            ),
            array(
                'id' => 'product_archive_fullwidth',
                'type' => 'switch',
                'title' => esc_html__('Is Full Width?', 'workup'),
                'default' => false
            ),
            array(
                'id' => 'product_archive_layout',
                'type' => 'image_select',
                'compiler' => true,
                'title' => esc_html__('Archive Product Layout', 'workup'),
                'subtitle' => esc_html__('Select the layout you want to apply on your archive product page.', 'workup'),
                'options' => array(
                    'main' => array(
                        'title' => esc_html__('Main Content', 'workup'),
                        'alt' => esc_html__('Main Content', 'workup'),
                        'img' => get_template_directory_uri() . '/inc/assets/images/screen1.png'
                    ),
                    'left-main' => array(
                        'title' => esc_html__('Left Sidebar - Main Content', 'workup'),
                        'alt' => esc_html__('Left Sidebar - Main Content', 'workup'),
                        'img' => get_template_directory_uri() . '/inc/assets/images/screen2.png'
                    ),
                    'main-right' => array(
                        'title' => esc_html__('Main Content - Right Sidebar', 'workup'),
                        'alt' => esc_html__('Main Content - Right Sidebar', 'workup'),
                        'img' => get_template_directory_uri() . '/inc/assets/images/screen3.png'
                    ),
                ),
                'default' => 'main'
            ),
            array(
                'id' => 'product_archive_left_sidebar',
                'type' => 'select',
                'title' => esc_html__('Archive Left Sidebar', 'workup'),
                'subtitle' => esc_html__('Choose a sidebar for left sidebar.', 'workup'),
                'options' => $sidebars
            ),
            array(
                'id' => 'product_archive_right_sidebar',
                'type' => 'select',
                'title' => esc_html__('Archive Right Sidebar', 'workup'),
                'subtitle' => esc_html__('Choose a sidebar for right sidebar.', 'workup'),
                'options' => $sidebars
            ),
        )
    );
    
    
    // Product Page
    $sections[] = array(
        'title' => esc_html__('Single Product', 'workup'),
        'subsection' => true,
        'fields' => array(
            array(
                'id' => 'product_general_setting',
                'icon' => true,
                'type' => 'info',
                'raw' => '<h3 style="margin: 0;"> '.esc_html__('General Setting', 'workup').'</h3>',
            ),
            array(
                'id' => 'product_thumbs_position',
                'type' => 'select',
                'title' => esc_html__('Thumbnails Position', 'workup'),
                'options' => array(
                    'thumbnails-left' => esc_html__('Thumbnails Left', 'workup'),
                    'thumbnails-right' => esc_html__('Thumbnails Right', 'workup'),
                    'thumbnails-bottom' => esc_html__('Thumbnails Bottom', 'workup'),
                ),
                'default' => 'thumbnails-bottom',
            ),
            array(
                'id' => 'number_product_thumbs',
                'title' => esc_html__('Number Thumbnails Per Row', 'workup'),
                'default' => 5,
                'min' => '1',
                'step' => '1',
                'max' => '8',
                'type' => 'slider',
            ),
            array(
                'id' => 'show_product_social_share',
                'type' => 'switch',
                'title' => esc_html__('Show Social Share', 'workup'),
                'default' => 1
            ),
            array(
                'id' => 'show_product_review_tab',
                'type' => 'switch',
                'title' => esc_html__('Show Product Review Tab', 'workup'),
                'default' => 1
            ),
            array(
                'id' => 'product_sidebar_setting',
                'icon' => true,
                'type' => 'info',
                'raw' => '<h3 style="margin: 0;"> '.esc_html__('Sidebar Setting', 'workup').'</h3>',
            ),
            array(
                'id' => 'product_single_layout',
                'type' => 'image_select',
                'compiler' => true,
                'title' => esc_html__('Single Product Sidebar Layout', 'workup'),
                'subtitle' => esc_html__('Select the layout you want to apply on your Single Product Page.', 'workup'),
                'options' => array(
                    'main' => array(
                        'title' => esc_html__('Main Only', 'workup'),
                        'alt' => esc_html__('Main Only', 'workup'),
                        'img' => get_template_directory_uri() . '/inc/assets/images/screen1.png'
                    ),
                    'left-main' => array(
                        'title' => esc_html__('Left - Main Sidebar', 'workup'),
                        'alt' => esc_html__('Left - Main Sidebar', 'workup'),
                        'img' => get_template_directory_uri() . '/inc/assets/images/screen2.png'
                    ),
                    'main-right' => array(
                        'title' => esc_html__('Main - Right Sidebar', 'workup'),
                        'alt' => esc_html__('Main - Right Sidebar', 'workup'),
                        'img' => get_template_directory_uri() . '/inc/assets/images/screen3.png'
                    ),
                ),
                'default' => 'main'
            ),
            array(
                'id' => 'product_single_fullwidth',
                'type' => 'switch',
                'title' => esc_html__('Is Full Width?', 'workup'),
                'default' => false
            ),
            array(
                'id' => 'product_single_left_sidebar',
                'type' => 'select',
                'title' => esc_html__('Single Product Left Sidebar', 'workup'),
                'subtitle' => esc_html__('Choose a sidebar for left sidebar.', 'workup'),
                'options' => $sidebars
            ),
            array(
                'id' => 'product_single_right_sidebar',
                'type' => 'select',
                'title' => esc_html__('Single Product Right Sidebar', 'workup'),
                'subtitle' => esc_html__('Choose a sidebar for right sidebar.', 'workup'),
                'options' => $sidebars
            ),
            array(
                'id' => 'product_block_setting',
                'icon' => true,
                'type' => 'info',
                'raw' => '<h3 style="margin: 0;"> '.esc_html__('Product Block Setting', 'workup').'</h3>',
            ),
            array(
                'id' => 'show_product_releated',
                'type' => 'switch',
                'title' => esc_html__('Show Products Releated', 'workup'),
                'default' => 1
            ),
            array(
                'id' => 'number_product_releated',
                'title' => esc_html__('Number of related products to show', 'workup'),
                'default' => 3,
                'min' => '1',
                'step' => '1',
                'max' => '50',
                'type' => 'slider',
                'required' => array('show_product_releated', '=', true)
            ),
            array(
                'id' => 'releated_product_columns',
                'type' => 'select',
                'title' => esc_html__('Releated Products Columns', 'workup'),
                'options' => $columns,
                'default' => 3,
                'required' => array('show_product_releated', '=', true)
            ),

            array(
                'id' => 'show_product_upsells',
                'type' => 'switch',
                'title' => esc_html__('Show Products upsells', 'workup'),
                'default' => 1
            ),
            array(
                'id' => 'upsells_product_columns',
                'type' => 'select',
                'title' => esc_html__('Upsells Products Columns', 'workup'),
                'options' => $columns,
                'default' => 3,
                'required' => array('show_product_upsells', '=', true)
            ),
        )
    );
    
    return $sections;
}
add_filter( 'workup_redux_framwork_configs', 'workup_woo_redux_config', 10, 3 );