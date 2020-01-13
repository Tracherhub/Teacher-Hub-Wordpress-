<?php

function workup_wp_job_board_redux_config($sections, $sidebars, $columns) {
    
    $sections[] = array(
        'icon' => 'el el-pencil',
        'title' => esc_html__('Jobs Settings', 'workup'),
        'fields' => array(
            array(
                'id' => 'show_job_breadcrumbs',
                'type' => 'switch',
                'title' => esc_html__('Breadcrumbs', 'workup'),
                'default' => 1
            ),
            array(
                'title' => esc_html__('Breadcrumbs Background Color', 'workup'),
                'subtitle' => '<em>'.esc_html__('The breadcrumbs background color of the site.', 'workup').'</em>',
                'id' => 'job_breadcrumb_color',
                'type' => 'color',
                'transparent' => false,
            ),
            array(
                'id' => 'job_breadcrumb_image',
                'type' => 'media',
                'title' => esc_html__('Breadcrumbs Background', 'workup'),
                'subtitle' => esc_html__('Upload a .jpg or .png image that will be your breadcrumbs.', 'workup'),
            ),
            array(
                'id' => 'job_breadcrumb_style',
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
        'title' => esc_html__('Job Archives', 'workup'),
        'subsection' => true,
        'fields' => array(
            array(
                'id' => 'jobs_general_setting',
                'icon' => true,
                'type' => 'info',
                'raw' => '<h3 style="margin: 0;"> '.esc_html__('General Setting', 'workup').'</h3>',
            ),
            array(
                'id' => 'jobs_fullwidth',
                'type' => 'switch',
                'title' => esc_html__('Is Full Width?', 'workup'),
                'default' => false
            ),
            array(
                'id' => 'jobs_layout_type',
                'type' => 'select',
                'title' => esc_html__('Jobs Layout', 'workup'),
                'subtitle' => esc_html__('Choose a default layout archive job.', 'workup'),
                'options' => array(
                    'main' => esc_html__('Main Content', 'workup'),
                    'left-main' => esc_html__('Left Sidebar - Main Content', 'workup'),
                    'main-right' => esc_html__('Main Content - Right Sidebar', 'workup'),
                ),
                'default' => 'main-right',
            ),
            array(
                'id' => 'jobs_display_mode',
                'type' => 'select',
                'title' => esc_html__('Jobs display mode', 'workup'),
                'subtitle' => esc_html__('Choose a default display mode for archive job.', 'workup'),
                'options' => array(
                    'grid' => esc_html__('Grid', 'workup'),
                    'list' => esc_html__('List', 'workup'),
                ),
                'default' => 'list'
            ),
            array(
                'id' => 'jobs_inner_style',
                'type' => 'select',
                'title' => esc_html__('Jobs item style', 'workup'),
                'subtitle' => esc_html__('Choose a job style.', 'workup'),
                'options' => array(
                    'list' => esc_html__('List Default', 'workup'),
                    'list-v1' => esc_html__('List V1', 'workup'),
                    'list-v2' => esc_html__('List V2', 'workup'),
                ),
                'default' => 'list',
                'required' => array('jobs_display_mode', '=', array('list'))
            ),
            array(
                'id' => 'jobs_columns',
                'type' => 'select',
                'title' => esc_html__('Job Columns', 'workup'),
                'options' => $columns,
                'default' => 3,
                'required' => array('jobs_display_mode', '=', array('grid'))
            ),
            array(
                'id' => 'jobs_pagination',
                'type' => 'select',
                'title' => esc_html__('Pagination Type', 'workup'),
                'options' => array(
                    'default' => esc_html__('Default', 'workup'),
                    'loadmore' => esc_html__('Load More Button', 'workup'),
                    'infinite' => esc_html__('Infinite Scrolling', 'workup'),
                ),
                'default' => 'default'
            ),
            array(
                'id' => 'job_placeholder_image',
                'type' => 'media',
                'title' => esc_html__('Placeholder Image', 'workup'),
                'subtitle' => esc_html__('Upload a .jpg or .png image that will be your placeholder.', 'workup'),
            ),
        )
    );
    
    
    // Job Page
    $sections[] = array(
        'title' => esc_html__('Single Job', 'workup'),
        'subsection' => true,
        'fields' => array(
            array(
                'id' => 'job_general_setting',
                'icon' => true,
                'type' => 'info',
                'raw' => '<h3 style="margin: 0;"> '.esc_html__('General Setting', 'workup').'</h3>',
            ),
            array(
                'id' => 'job_fullwidth',
                'type' => 'switch',
                'title' => esc_html__('Is Full Width?', 'workup'),
                'default' => false
            ),
            array(
                'id' => 'job_layout_type',
                'type' => 'select',
                'title' => esc_html__('Job Layout', 'workup'),
                'subtitle' => esc_html__('Choose a default layout single job.', 'workup'),
                'options' => array(
                    'v1' => esc_html__('Version 1', 'workup'),
                    'v2' => esc_html__('Version 2', 'workup'),
                ),
                'default' => 'v1',
            ),
            array(
                'id' => 'show_job_social_share',
                'type' => 'switch',
                'title' => esc_html__('Show Social Share', 'workup'),
                'default' => 1
            ),
            array(
                'id' => 'job_block_setting',
                'icon' => true,
                'type' => 'info',
                'raw' => '<h3 style="margin: 0;"> '.esc_html__('Job Block Setting', 'workup').'</h3>',
            ),
            array(
                'id' => 'job_releated_show',
                'type' => 'switch',
                'title' => esc_html__('Show Jobs Releated', 'workup'),
                'default' => 1
            ),
            array(
                'id' => 'job_releated_number',
                'title' => esc_html__('Number of related jobs to show', 'workup'),
                'default' => 4,
                'min' => '1',
                'step' => '1',
                'max' => '50',
                'type' => 'slider',
                'required' => array('job_releated_show', '=', true)
            ),
            array(
                'id' => 'job_releated_columns',
                'type' => 'select',
                'title' => esc_html__('Releated Jobs Columns', 'workup'),
                'options' => $columns,
                'default' => 4,
                'required' => array('job_releated_show', '=', true)
            ),
        )
    );
	
    return $sections;
}
add_filter( 'workup_redux_framwork_configs', 'workup_wp_job_board_redux_config', 10, 3 );


// employers
function workup_wp_job_board_employer_redux_config($sections, $sidebars, $columns) {
    
    $sections[] = array(
        'icon' => 'el el-pencil',
        'title' => esc_html__('Employer Settings', 'workup'),
        'fields' => array(
            array(
                'id' => 'show_employer_breadcrumbs',
                'type' => 'switch',
                'title' => esc_html__('Breadcrumbs', 'workup'),
                'default' => 1
            ),
            array(
                'title' => esc_html__('Breadcrumbs Background Color', 'workup'),
                'subtitle' => '<em>'.esc_html__('The breadcrumbs background color of the site.', 'workup').'</em>',
                'id' => 'employer_breadcrumb_color',
                'type' => 'color',
                'transparent' => false,
            ),
            array(
                'id' => 'employer_breadcrumb_image',
                'type' => 'media',
                'title' => esc_html__('Breadcrumbs Background', 'workup'),
                'subtitle' => esc_html__('Upload a .jpg or .png image that will be your breadcrumbs.', 'workup'),
            ),
            array(
                'id' => 'employer_breadcrumb_style',
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
        'title' => esc_html__('Employer Archives', 'workup'),
        'subsection' => true,
        'fields' => array(
            array(
                'id' => 'employers_general_setting',
                'icon' => true,
                'type' => 'info',
                'raw' => '<h3 style="margin: 0;"> '.esc_html__('General Setting', 'workup').'</h3>',
            ),
            array(
                'id' => 'employers_fullwidth',
                'type' => 'switch',
                'title' => esc_html__('Is Full Width?', 'workup'),
                'default' => false
            ),
            
            array(
                'id' => 'employers_display_mode',
                'type' => 'select',
                'title' => esc_html__('Employers display mode', 'workup'),
                'subtitle' => esc_html__('Choose a default display mode for archive employer.', 'workup'),
                'options' => array(
                    'grid' => esc_html__('Grid', 'workup'),
                    'list' => esc_html__('List', 'workup'),
                    'simple' => esc_html__('Simple', 'workup'),
                ),
                'default' => 'list'
            ),
            array(
                'id' => 'employers_columns',
                'type' => 'select',
                'title' => esc_html__('Employer Columns', 'workup'),
                'options' => $columns,
                'default' => 4,
                'required' => array('employers_display_mode', '=', array('grid', 'simple'))
            ),
            array(
                'id' => 'employers_pagination',
                'type' => 'select',
                'title' => esc_html__('Pagination Type', 'workup'),
                'options' => array(
                    'default' => esc_html__('Default', 'workup'),
                    'loadmore' => esc_html__('Load More Button', 'workup'),
                    'infinite' => esc_html__('Infinite Scrolling', 'workup'),
                ),
                'default' => 'default'
            ),
            array(
                'id' => 'employers_sidebar_setting',
                'icon' => true,
                'type' => 'info',
                'raw' => '<h3 style="margin: 0;"> '.esc_html__('Sidebar Setting', 'workup').'</h3>',
            ),
            array(
                'id' => 'employers_archive_layout',
                'type' => 'image_select',
                'compiler' => true,
                'title' => esc_html__('Archive Product Layout', 'workup'),
                'subtitle' => esc_html__('Select the layout you want to apply on your archive employers page.', 'workup'),
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
                'default' => 'main-right'
            ),
        )
    );
    
    
    // Employer Page
    $sections[] = array(
        'title' => esc_html__('Single Employer', 'workup'),
        'subsection' => true,
        'fields' => array(
            array(
                'id' => 'employer_general_setting',
                'icon' => true,
                'type' => 'info',
                'raw' => '<h3 style="margin: 0;"> '.esc_html__('General Setting', 'workup').'</h3>',
            ),
            array(
                'id' => 'employer_fullwidth',
                'type' => 'switch',
                'title' => esc_html__('Is Full Width?', 'workup'),
                'default' => false
            ),
            array(
                'id' => 'show_employer_social_share',
                'type' => 'switch',
                'title' => esc_html__('Show Social Share', 'workup'),
                'default' => 1
            ),
            array(
                'id' => 'employer_block_setting',
                'icon' => true,
                'type' => 'info',
                'raw' => '<h3 style="margin: 0;"> '.esc_html__('Employer Block Setting', 'workup').'</h3>',
            ),
            array(
                'id' => 'employer_releated_show',
                'type' => 'switch',
                'title' => esc_html__('Show Employers Releated', 'workup'),
                'default' => 1
            ),
            array(
                'id' => 'employer_releated_number',
                'title' => esc_html__('Number of related employers to show', 'workup'),
                'default' => 4,
                'min' => '1',
                'step' => '1',
                'max' => '50',
                'type' => 'slider',
                'required' => array('employer_releated_show', '=', true)
            ),
            array(
                'id' => 'employer_releated_columns',
                'type' => 'select',
                'title' => esc_html__('Releated Employers Columns', 'workup'),
                'options' => $columns,
                'default' => 4,
                'required' => array('employer_releated_show', '=', true)
            ),
        )
    );
    
    return $sections;
}
add_filter( 'workup_redux_framwork_configs', 'workup_wp_job_board_employer_redux_config', 10, 3 );


// candidates
function workup_wp_job_board_candidate_redux_config($sections, $sidebars, $columns) {
    
    $sections[] = array(
        'icon' => 'el el-pencil',
        'title' => esc_html__('Candidate Settings', 'workup'),
        'fields' => array(
            array(
                'id' => 'show_candidate_breadcrumbs',
                'type' => 'switch',
                'title' => esc_html__('Breadcrumbs', 'workup'),
                'default' => 1
            ),
            array(
                'title' => esc_html__('Breadcrumbs Background Color', 'workup'),
                'subtitle' => '<em>'.esc_html__('The breadcrumbs background color of the site.', 'workup').'</em>',
                'id' => 'candidate_breadcrumb_color',
                'type' => 'color',
                'transparent' => false,
            ),
            array(
                'id' => 'candidate_breadcrumb_image',
                'type' => 'media',
                'title' => esc_html__('Breadcrumbs Background', 'workup'),
                'subtitle' => esc_html__('Upload a .jpg or .png image that will be your breadcrumbs.', 'workup'),
            ),
            array(
                'id' => 'candidate_breadcrumb_style',
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
        'title' => esc_html__('Candidate Archives', 'workup'),
        'subsection' => true,
        'fields' => array(
            array(
                'id' => 'candidates_general_setting',
                'icon' => true,
                'type' => 'info',
                'raw' => '<h3 style="margin: 0;"> '.esc_html__('General Setting', 'workup').'</h3>',
            ),
            array(
                'id' => 'candidates_fullwidth',
                'type' => 'switch',
                'title' => esc_html__('Is Full Width?', 'workup'),
                'default' => false
            ),
            array(
                'id' => 'candidates_display_mode',
                'type' => 'select',
                'title' => esc_html__('Candidates display mode', 'workup'),
                'subtitle' => esc_html__('Choose a default display mode for archive candidate.', 'workup'),
                'options' => array(
                    'grid' => esc_html__('Grid', 'workup'),
                    'list' => esc_html__('List', 'workup'),
                ),
                'default' => 'list'
            ),
            array(
                'id' => 'candidates_columns',
                'type' => 'select',
                'title' => esc_html__('Candidate Columns', 'workup'),
                'options' => $columns,
                'default' => 4,
                'required' => array('candidates_display_mode', '=', array('grid'))
            ),
            array(
                'id' => 'candidates_pagination',
                'type' => 'select',
                'title' => esc_html__('Pagination Type', 'workup'),
                'options' => array(
                    'default' => esc_html__('Default', 'workup'),
                    'loadmore' => esc_html__('Load More Button', 'workup'),
                    'infinite' => esc_html__('Infinite Scrolling', 'workup'),
                ),
                'default' => 'default'
            ),
            array(
                'id' => 'candidates_sidebar_setting',
                'icon' => true,
                'type' => 'info',
                'raw' => '<h3 style="margin: 0;"> '.esc_html__('Sidebar Setting', 'workup').'</h3>',
            ),
            array(
                'id' => 'candidates_archive_layout',
                'type' => 'image_select',
                'compiler' => true,
                'title' => esc_html__('Archive Product Layout', 'workup'),
                'subtitle' => esc_html__('Select the layout you want to apply on your archive candidates page.', 'workup'),
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
                'default' => 'main-right'
            ),
        )
    );
    
    
    // Candidate Page
    $sections[] = array(
        'title' => esc_html__('Single Candidate', 'workup'),
        'subsection' => true,
        'fields' => array(
            array(
                'id' => 'candidate_general_setting',
                'icon' => true,
                'type' => 'info',
                'raw' => '<h3 style="margin: 0;"> '.esc_html__('General Setting', 'workup').'</h3>',
            ),
            array(
                'id' => 'candidate_fullwidth',
                'type' => 'switch',
                'title' => esc_html__('Is Full Width?', 'workup'),
                'default' => false
            ),
            array(
                'id' => 'show_candidate_social_share',
                'type' => 'switch',
                'title' => esc_html__('Show Social Share', 'workup'),
                'default' => 1
            ),
            array(
                'id' => 'candidate_block_setting',
                'icon' => true,
                'type' => 'info',
                'raw' => '<h3 style="margin: 0;"> '.esc_html__('Candidate Block Setting', 'workup').'</h3>',
            ),
            array(
                'id' => 'candidate_releated_show',
                'type' => 'switch',
                'title' => esc_html__('Show Candidates Releated', 'workup'),
                'default' => 1
            ),
            array(
                'id' => 'candidate_releated_number',
                'title' => esc_html__('Number of related candidates to show', 'workup'),
                'default' => 4,
                'min' => '1',
                'step' => '1',
                'max' => '50',
                'type' => 'slider',
                'required' => array('candidate_releated_show', '=', true)
            ),
            array(
                'id' => 'candidate_releated_columns',
                'type' => 'select',
                'title' => esc_html__('Releated Candidates Columns', 'workup'),
                'options' => $columns,
                'default' => 3,
                'required' => array('candidate_releated_show', '=', true)
            ),
        )
    );
    
    return $sections;
}
add_filter( 'workup_redux_framwork_configs', 'workup_wp_job_board_candidate_redux_config', 10, 3 );
