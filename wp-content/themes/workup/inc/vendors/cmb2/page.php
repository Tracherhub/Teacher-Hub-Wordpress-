<?php

if ( !function_exists( 'workup_page_metaboxes' ) ) {
	function workup_page_metaboxes(array $metaboxes) {
		global $wp_registered_sidebars;
        $sidebars = array();

        if ( !empty($wp_registered_sidebars) ) {
            foreach ($wp_registered_sidebars as $sidebar) {
                $sidebars[$sidebar['id']] = $sidebar['name'];
            }
        }
        $headers = array_merge( array('global' => esc_html__( 'Global Setting', 'workup' )), workup_get_header_layouts() );
        $footers = array_merge( array('global' => esc_html__( 'Global Setting', 'workup' )), workup_get_footer_layouts() );

		$prefix = 'apus_page_';

        $columns = array(
            '' => esc_html__( 'Global Setting', 'workup' ),
            '1' => esc_html__('1 Column', 'workup'),
            '2' => esc_html__('2 Columns', 'workup'),
            '3' => esc_html__('3 Columns', 'workup'),
            '4' => esc_html__('4 Columns', 'workup'),
            '6' => esc_html__('6 Columns', 'workup')
        );
        // Jobs Page
        $fields = array(
            array(
                'name' => esc_html__( 'Jobs Layout', 'workup' ),
                'id'   => $prefix.'layout_type',
                'type' => 'select',
                'options' => array(
                    '' => esc_html__( 'Global Setting', 'workup' ),
                    'main' => esc_html__('Main Content', 'workup'),
                    'left-main' => esc_html__('Left Sidebar - Main Content', 'workup'),
                    'main-right' => esc_html__('Main Content - Right Sidebar', 'workup'),
                )
            ),
            array(
                'id' => $prefix.'display_mode',
                'type' => 'select',
                'name' => esc_html__('Default Display Mode', 'workup'),
                'options' => array(
                    '' => esc_html__( 'Global Setting', 'workup' ),
                    'grid' => esc_html__('Grid', 'workup'),
                    'list' => esc_html__('List', 'workup'),
                )
            ),
            array(
                'id' => $prefix.'inner_style',
                'type' => 'select',
                'name' => esc_html__('Jobs item style', 'workup'),
                'options' => array(
                    '' => esc_html__( 'Global Setting', 'workup' ),
                    'list' => esc_html__('List Default', 'workup'),
                    'list-v1' => esc_html__('List V1', 'workup'),
                    'list-v2' => esc_html__('List V2', 'workup'),
                ),
            ),
            array(
                'id' => $prefix.'jobs_columns',
                'type' => 'select',
                'name' => esc_html__('Grid Listing Columns', 'workup'),
                'options' => $columns,
            ),
            array(
                'id' => $prefix.'jobs_pagination',
                'type' => 'select',
                'name' => esc_html__('Pagination Type', 'workup'),
                'options' => array(
                    '' => esc_html__( 'Global Setting', 'workup' ),
                    'default' => esc_html__('Default', 'workup'),
                    'loadmore' => esc_html__('Load More Button', 'workup'),
                    'infinite' => esc_html__('Infinite Scrolling', 'workup'),
                ),
            ),
        );
        
        $metaboxes[$prefix . 'jobs_setting'] = array(
            'id'                        => $prefix . 'jobs_setting',
            'title'                     => esc_html__( 'Jobs Settings', 'workup' ),
            'object_types'              => array( 'page' ),
            'context'                   => 'normal',
            'priority'                  => 'high',
            'show_names'                => true,
            'fields'                    => $fields
        );


        // Employers Page
        $fields = array(
            array(
                'id' => $prefix.'employers_display_mode',
                'type' => 'select',
                'name' => esc_html__('Employers display mode', 'workup'),
                'options' => array(
                    '' => esc_html__( 'Global Setting', 'workup' ),
                    'grid' => esc_html__('Grid', 'workup'),
                    'list' => esc_html__('List', 'workup'),
                    'simple' => esc_html__('Simple', 'workup'),
                )
            ),
            array(
                'id' => $prefix.'employers_columns',
                'type' => 'select',
                'name' => esc_html__('Employer Columns', 'workup'),
                'options' => $columns,
                'description' => esc_html__('Apply for display mode is grid and simple.', 'workup'),
            ),
            array(
                'id' => $prefix.'employers_pagination',
                'type' => 'select',
                'name' => esc_html__('Pagination Type', 'workup'),
                'options' => array(
                    '' => esc_html__( 'Global Setting', 'workup' ),
                    'default' => esc_html__('Default', 'workup'),
                    'loadmore' => esc_html__('Load More Button', 'workup'),
                    'infinite' => esc_html__('Infinite Scrolling', 'workup'),
                ),
            ),
        );
        $metaboxes[$prefix . 'employers_setting'] = array(
            'id'                        => $prefix . 'employers_setting',
            'title'                     => esc_html__( 'Employers Settings', 'workup' ),
            'object_types'              => array( 'page' ),
            'context'                   => 'normal',
            'priority'                  => 'high',
            'show_names'                => true,
            'fields'                    => $fields
        );

        // Candidates Page
        $fields = array(
            array(
                'id' => $prefix.'candidates_display_mode',
                'type' => 'select',
                'name' => esc_html__('Candidates display mode', 'workup'),
                'options' => array(
                    '' => esc_html__( 'Global Setting', 'workup' ),
                    'grid' => esc_html__('Grid', 'workup'),
                    'list' => esc_html__('List', 'workup'),
                )
            ),
            array(
                'id' => $prefix.'candidates_columns',
                'type' => 'select',
                'name' => esc_html__('Candidate Columns', 'workup'),
                'options' => $columns,
                'description' => esc_html__('Apply for display mode is grid.', 'workup'),
            ),
            array(
                'id' => $prefix.'candidates_pagination',
                'type' => 'select',
                'name' => esc_html__('Pagination Type', 'workup'),
                'options' => array(
                    '' => esc_html__( 'Global Setting', 'workup' ),
                    'default' => esc_html__('Default', 'workup'),
                    'loadmore' => esc_html__('Load More Button', 'workup'),
                    'infinite' => esc_html__('Infinite Scrolling', 'workup'),
                ),
            ),
        );
        $metaboxes[$prefix . 'candidates_setting'] = array(
            'id'                        => $prefix . 'candidates_setting',
            'title'                     => esc_html__( 'Candidates Settings', 'workup' ),
            'object_types'              => array( 'page' ),
            'context'                   => 'normal',
            'priority'                  => 'high',
            'show_names'                => true,
            'fields'                    => $fields
        );

        // General
	    $fields = array(
			array(
				'name' => esc_html__( 'Select Layout', 'workup' ),
				'id'   => $prefix.'layout',
				'type' => 'select',
				'options' => array(
					'main' => esc_html__('Main Content Only', 'workup'),
					'left-main' => esc_html__('Left Sidebar - Main Content', 'workup'),
					'main-right' => esc_html__('Main Content - Right Sidebar', 'workup')
				)
			),
			array(
                'id' => $prefix.'fullwidth',
                'type' => 'select',
                'name' => esc_html__('Is Full Width?', 'workup'),
                'default' => 'no',
                'options' => array(
                    'no' => esc_html__('No', 'workup'),
                    'yes' => esc_html__('Yes', 'workup')
                )
            ),
            array(
                'id' => $prefix.'left_sidebar',
                'type' => 'select',
                'name' => esc_html__('Left Sidebar', 'workup'),
                'options' => $sidebars
            ),
            array(
                'id' => $prefix.'right_sidebar',
                'type' => 'select',
                'name' => esc_html__('Right Sidebar', 'workup'),
                'options' => $sidebars
            ),
            array(
                'id' => $prefix.'show_breadcrumb',
                'type' => 'select',
                'name' => esc_html__('Show Breadcrumb?', 'workup'),
                'options' => array(
                    'no' => esc_html__('No', 'workup'),
                    'yes' => esc_html__('Yes', 'workup')
                ),
                'default' => 'yes',
            ),
            array(
                'id' => $prefix.'breadcrumb_color',
                'type' => 'colorpicker',
                'name' => esc_html__('Breadcrumb Background Color', 'workup')
            ),
            array(
                'id' => $prefix.'breadcrumb_image',
                'type' => 'file',
                'name' => esc_html__('Breadcrumb Background Image', 'workup')
            ),
            array(
                'id' => $prefix.'breadcrumb_style',
                'type' => 'select',
                'name' => esc_html__('Breadcrumb Style', 'workup'),
                'options' => array(
                    'default' => esc_html__('Default', 'workup'),
                    'center' => esc_html__('Style 1', 'workup'),
                ),
                'default' => 'default',
            ),
            array(
                'id' => $prefix.'header_type',
                'type' => 'select',
                'name' => esc_html__('Header Layout Type', 'workup'),
                'description' => esc_html__('Choose a header for your website.', 'workup'),
                'options' => $headers,
                'default' => 'global'
            ),
            array(
                'id' => $prefix.'header_transparent',
                'type' => 'select',
                'name' => esc_html__('Header Transparent', 'workup'),
                'description' => esc_html__('Choose a header for your website.', 'workup'),
                'options' => array(
                    'no' => esc_html__('No', 'workup'),
                    'yes' => esc_html__('Yes', 'workup')
                ),
                'default' => 'global'
            ),
            array(
                'id' => $prefix.'header_fixed',
                'type' => 'select',
                'name' => esc_html__('Header Fixed Top', 'workup'),
                'description' => esc_html__('Choose a header position', 'workup'),
                'options' => array(
                    'no' => esc_html__('No', 'workup'),
                    'yes' => esc_html__('Yes', 'workup')
                ),
                'default' => 'no'
            ),
            array(
                'id' => $prefix.'footer_type',
                'type' => 'select',
                'name' => esc_html__('Footer Layout Type', 'workup'),
                'description' => esc_html__('Choose a footer for your website.', 'workup'),
                'options' => $footers,
                'default' => 'global'
            ),
            array(
                'id' => $prefix.'extra_class',
                'type' => 'text',
                'name' => esc_html__('Extra Class', 'workup'),
                'description' => esc_html__('If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'workup')
            )
    	);
		
	    $metaboxes[$prefix . 'display_setting'] = array(
			'id'                        => $prefix . 'display_setting',
			'title'                     => esc_html__( 'Display Settings', 'workup' ),
			'object_types'              => array( 'page' ),
			'context'                   => 'normal',
			'priority'                  => 'high',
			'show_names'                => true,
			'fields'                    => $fields
		);

	    return $metaboxes;
	}
}
add_filter( 'cmb2_meta_boxes', 'workup_page_metaboxes' );

if ( !function_exists( 'workup_cmb2_style' ) ) {
	function workup_cmb2_style() {
        wp_enqueue_style( 'workup-cmb2-style', get_template_directory_uri() . '/inc/vendors/cmb2/assets/style.css', array(), '1.0' );
		wp_enqueue_script( 'workup-admin', get_template_directory_uri() . '/js/admin.js', array( 'jquery' ), '20150330', true );
	}
}
add_action( 'admin_enqueue_scripts', 'workup_cmb2_style' );


