<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Workup_Elementor_Job_Board_Jobs_Tabs extends Elementor\Widget_Base {

	public function get_name() {
        return 'workup_job_board_jobs_tabs';
    }

	public function get_title() {
        return esc_html__( 'Apus Jobs Tabs', 'workup' );
    }
    
	public function get_categories() {
        return [ 'workup-elements' ];
    }

	protected function _register_controls() {

        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__( 'Jobs', 'workup' ),
                'tab' => Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'title', [
                'label' => esc_html__( 'Tab Title', 'workup' ),
                'type' => Elementor\Controls_Manager::TEXT
            ]
        );

        $repeater->add_control(
            'category_slugs',
            [
                'label' => esc_html__( 'Categories Slug', 'workup' ),
                'type' => Elementor\Controls_Manager::TEXTAREA,
                'rows' => 2,
                'default' => '',
                'placeholder' => esc_html__( 'Enter id spearate by comma(,)', 'workup' ),
            ]
        );

        $repeater->add_control(
            'type_slugs',
            [
                'label' => esc_html__( 'Types Slug', 'workup' ),
                'type' => Elementor\Controls_Manager::TEXTAREA,
                'rows' => 2,
                'default' => '',
                'placeholder' => esc_html__( 'Enter id spearate by comma(,)', 'workup' ),
            ]
        );

        $repeater->add_control(
            'location_slugs',
            [
                'label' => esc_html__( 'Location Slug', 'workup' ),
                'type' => Elementor\Controls_Manager::TEXTAREA,
                'rows' => 2,
                'default' => '',
                'placeholder' => esc_html__( 'Enter id spearate by comma(,)', 'workup' ),
            ]
        );

        $repeater->add_control(
            'orderby',
            [
                'label' => esc_html__( 'Order by', 'workup' ),
                'type' => Elementor\Controls_Manager::SELECT,
                'options' => array(
                    '' => esc_html__('Default', 'workup'),
                    'date' => esc_html__('Date', 'workup'),
                    'ID' => esc_html__('ID', 'workup'),
                    'author' => esc_html__('Author', 'workup'),
                    'title' => esc_html__('Title', 'workup'),
                    'modified' => esc_html__('Modified', 'workup'),
                    'rand' => esc_html__('Random', 'workup'),
                    'comment_count' => esc_html__('Comment count', 'workup'),
                    'menu_order' => esc_html__('Menu order', 'workup'),
                ),
                'default' => ''
            ]
        );

        $repeater->add_control(
            'order',
            [
                'label' => esc_html__( 'Sort order', 'workup' ),
                'type' => Elementor\Controls_Manager::SELECT,
                'options' => array(
                    '' => esc_html__('Default', 'workup'),
                    'ASC' => esc_html__('Ascending', 'workup'),
                    'DESC' => esc_html__('Descending', 'workup'),
                ),
                'default' => ''
            ]
        );

        $repeater->add_control(
            'get_jobs_by',
            [
                'label' => esc_html__( 'Get Jobs By', 'workup' ),
                'type' => Elementor\Controls_Manager::SELECT,
                'options' => array(
                    'featured' => esc_html__('Featured Jobs', 'workup'),
                    'urgent' => esc_html__('Urgent Jobs', 'workup'),
                    'recent' => esc_html__('Recent Jobs', 'workup'),
                ),
                'default' => 'recent'
            ]
        );

        $this->add_control(
            'tabs',
            [
                'label' => esc_html__( 'Tabs', 'workup' ),
                'type' => Elementor\Controls_Manager::REPEATER,
                'placeholder' => esc_html__( 'Enter your job tabs here', 'workup' ),
                'fields' => $repeater->get_controls(),
            ]
        );

        $this->add_control(
            'limit',
            [
                'label' => esc_html__( 'Limit', 'workup' ),
                'type' => Elementor\Controls_Manager::NUMBER,
                'input_type' => 'number',
                'description' => esc_html__( 'Limit jobs to display', 'workup' ),
                'default' => 4
            ]
        );
        
        

        $this->add_control(
            'job_item_style',
            [
                'label' => esc_html__( 'Job Item Style', 'workup' ),
                'type' => Elementor\Controls_Manager::SELECT,
                'options' => array(
                    'list' => esc_html__('List Style (Default)', 'workup'),
                    'list-v1' => esc_html__('List Style v1', 'workup'),
                    'list-v2' => esc_html__('List Style v2', 'workup'),
                    'grid' => esc_html__('Grid Style', 'workup'),
                ),
                'default' => 'list'
            ]
        );

        $this->add_control(
            'layout_type',
            [
                'label' => esc_html__( 'Layout', 'workup' ),
                'type' => Elementor\Controls_Manager::SELECT,
                'options' => array(
                    'grid' => esc_html__('Grid', 'workup'),
                    'carousel' => esc_html__('Carousel', 'workup'),
                    'list' => esc_html__('List', 'workup'),
                ),
                'default' => 'list'
            ]
        );

        $this->add_control(
            'columns',
            [
                'label' => esc_html__( 'Columns', 'workup' ),
                'type' => Elementor\Controls_Manager::TEXT,
                'input_type' => 'number',
                'placeholder' => esc_html__( 'Enter your column number here', 'workup' ),
                'default' => 4,
                'condition' => [
                    'layout_type' => ['carousel', 'grid'],
                ],
            ]
        );

        $this->add_control(
            'rows',
            [
                'label' => esc_html__( 'Rows', 'workup' ),
                'type' => Elementor\Controls_Manager::TEXT,
                'input_type' => 'number',
                'placeholder' => esc_html__( 'Enter your rows number here', 'workup' ),
                'default' => 1,
                'condition' => [
                    'layout_type' => 'carousel',
                ],
            ]
        );

        $this->add_control(
            'show_nav',
            [
                'label'         => esc_html__( 'Show Navigation', 'workup' ),
                'type'          => Elementor\Controls_Manager::SWITCHER,
                'label_on'      => esc_html__( 'Show', 'workup' ),
                'label_off'     => esc_html__( 'Hide', 'workup' ),
                'return_value'  => true,
                'default'       => true,
                'condition' => [
                    'layout_type' => 'carousel',
                ],
            ]
        );

        $this->add_control(
            'show_pagination',
            [
                'label'         => esc_html__( 'Show Pagination', 'workup' ),
                'type'          => Elementor\Controls_Manager::SWITCHER,
                'label_on'      => esc_html__( 'Show', 'workup' ),
                'label_off'     => esc_html__( 'Hide', 'workup' ),
                'return_value'  => true,
                'default'       => true,
                'condition' => [
                    'layout_type' => 'carousel',
                ],
            ]
        );

        $this->add_control(
            'autoplay',
            [
                'label'         => esc_html__( 'Autoplay', 'workup' ),
                'type'          => Elementor\Controls_Manager::SWITCHER,
                'label_on'      => esc_html__( 'Yes', 'workup' ),
                'label_off'     => esc_html__( 'No', 'workup' ),
                'return_value'  => true,
                'default'       => true,
                'condition' => [
                    'layout_type' => 'carousel',
                ],
            ]
        );

        $this->add_control(
            'infinite_loop',
            [
                'label'         => esc_html__( 'Infinite Loop', 'workup' ),
                'type'          => Elementor\Controls_Manager::SWITCHER,
                'label_on'      => esc_html__( 'Yes', 'workup' ),
                'label_off'     => esc_html__( 'No', 'workup' ),
                'return_value'  => true,
                'default'       => true,
                'condition' => [
                    'layout_type' => 'carousel',
                ],
            ]
        );

        $this->add_control(
            'view_more_text',
            [
                'label' => esc_html__( 'View More Button Text', 'workup' ),
                'type' => Elementor\Controls_Manager::TEXT,
                'placeholder' => esc_html__( 'Enter your view more text here', 'workup' ),
            ]
        );

        $this->add_control(
            'view_more_url',
            [
                'label' => esc_html__( 'View More URL', 'workup' ),
                'type' => Elementor\Controls_Manager::URL,
                'placeholder' => esc_html__( 'Enter your view more url here', 'workup' ),
            ]
        );

   		$this->add_control(
            'el_class',
            [
                'label'         => esc_html__( 'Extra class name', 'workup' ),
                'type'          => Elementor\Controls_Manager::TEXT,
                'placeholder'   => esc_html__( 'If you wish to style particular content element differently, please add a class name to this field and refer to it in your custom CSS file.', 'workup' ),
            ]
        );

        $this->end_controls_section();

    }

	protected function render() {
        $settings = $this->get_settings();

        extract( $settings );
        $_id = workup_random_key();
        ?>
        <div class="widget-jobs-tabs <?php echo esc_attr($layout_type); ?> <?php echo esc_attr($el_class); ?>">

            <div class="top-info">
                <ul role="tablist" class="nav nav-tabs">
                    <?php $tab_count = 0; foreach ($tabs as $tab) : ?>
                        <li class="<?php echo esc_attr($tab_count == 0 ? 'active' : '');?>">
                            <a href="#tab-<?php echo esc_attr($_id);?>-<?php echo esc_attr($tab_count); ?>" data-toggle="tab">
                                <?php if ( !empty($tab['title']) ) { ?>
                                    <?php echo trim($tab['title']); ?>
                                <?php } ?>
                            </a>
                        </li>
                    <?php $tab_count++; endforeach; ?>
                </ul>
            </div>
            <div class="tab-content">
                <?php $tab_count = 0; foreach ($tabs as $tab) : ?>
                    <div id="tab-<?php echo esc_attr($_id);?>-<?php echo esc_attr($tab_count); ?>" class="tab-pane <?php echo esc_attr($tab_count == 0 ? 'active' : ''); ?>">
                        <?php

                        $category_slugs = !empty($tab['category_slugs']) ? array_map('trim', explode(',', $tab['category_slugs'])) : array();
                        $type_slugs = !empty($tab['type_slugs']) ? array_map('trim', explode(',', $tab['type_slugs'])) : array();
                        $location_slugs = !empty($tab['location_slugs']) ? array_map('trim', explode(',', $tab['location_slugs'])) : array();

                        $args = array(
                            'limit' => $limit,
                            'get_jobs_by' => !empty($tab['get_jobs_by']) ? $tab['get_jobs_by'] : 'recent',
                            'orderby' => !empty($tab['orderby']) ? $tab['orderby'] : '',
                            'order' => !empty($tab['order']) ? $tab['order'] : '',
                            'categories' => $category_slugs,
                            'types' => $type_slugs,
                            'locations' => $location_slugs,
                        );
                        $loop = workup_get_jobs($args);
                        if ( $loop->have_posts() ) {
                            ?>
                            <?php if ( $layout_type == 'carousel' ): ?>
                                <div class="slick-carousel" data-carousel="slick" data-items="<?php echo esc_attr($columns); ?>" data-smallmedium="2" data-extrasmall="1" data-pagination="<?php echo esc_attr( $show_pagination ? 'true' : 'false' ); ?>" data-nav="<?php echo esc_attr( $show_nav ? 'true' : 'false' ); ?>" data-rows="<?php echo esc_attr( $rows ); ?>" data-infinite="<?php echo esc_attr( $infinite_loop ? 'true' : 'false' ); ?>" data-autoplay="<?php echo esc_attr( $autoplay ? 'true' : 'false' ); ?>">
                                    <?php while ( $loop->have_posts() ): $loop->the_post(); ?>
                                        <div class="cl-inner">
                                            <?php get_template_part( 'template-jobs/jobs-styles/inner', $job_item_style); ?>
                                        </div>
                                    <?php endwhile; ?>
                                </div>
                            <?php elseif( $layout_type == 'grid' ): ?>
                                <?php
                                    $mdcol = 12/$columns;
                                ?>
                                <div class="row">
                                    <?php $i = 1; while ( $loop->have_posts() ) : $loop->the_post(); ?>
                                        <div class="col-md-<?php echo esc_attr($mdcol); ?> col-sm-6 col-xs-12 <?php echo esc_attr(($i%$columns == 1)?'md-clearfix':''); ?> <?php echo esc_attr(($i%2 == 1)?'sm-clearfix':''); ?>">
                                            <?php get_template_part( 'template-jobs/jobs-styles/inner', $job_item_style ); ?>
                                        </div>
                                    <?php $i++; endwhile; ?>
                                </div>
                            <?php else: ?>
                                <div class="row">
                                    <?php while ( $loop->have_posts() ) : $loop->the_post(); ?>
                                        <div class="col-xs-12">
                                            <?php get_template_part( 'template-jobs/jobs-styles/inner', $job_item_style ); ?>
                                        </div>
                                    <?php endwhile; ?>
                                </div>
                            <?php endif; ?>
                            <?php wp_reset_postdata(); ?>
                        <?php } ?>
                    </div>
                <?php $tab_count++; endforeach; ?>
            </div>
        </div>
        <?php
    }
}

Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Workup_Elementor_Job_Board_Jobs_Tabs );