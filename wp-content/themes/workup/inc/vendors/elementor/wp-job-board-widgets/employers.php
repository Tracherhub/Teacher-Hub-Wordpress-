<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Workup_Elementor_Job_Board_Employers extends Elementor\Widget_Base {

	public function get_name() {
        return 'workup_job_board_employers';
    }

	public function get_title() {
        return esc_html__( 'Apus Employers', 'workup' );
    }
    
	public function get_categories() {
        return [ 'workup-elements' ];
    }

	protected function _register_controls() {

        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__( 'Employers', 'workup' ),
                'tab' => Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'title',
            [
                'label' => esc_html__( 'Title', 'workup' ),
                'type' => Elementor\Controls_Manager::TEXT,
                'input_type' => 'text',
                'placeholder' => esc_html__( 'Enter your title here', 'workup' ),
            ]
        );

        $this->add_control(
            'category_slugs',
            [
                'label' => esc_html__( 'Categories Slug', 'workup' ),
                'type' => Elementor\Controls_Manager::TEXTAREA,
                'rows' => 2,
                'default' => '',
                'placeholder' => esc_html__( 'Enter id spearate by comma(,)', 'workup' ),
            ]
        );

        $this->add_control(
            'location_slugs',
            [
                'label' => esc_html__( 'Location Slug', 'workup' ),
                'type' => Elementor\Controls_Manager::TEXTAREA,
                'rows' => 2,
                'default' => '',
                'placeholder' => esc_html__( 'Enter id spearate by comma(,)', 'workup' ),
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

        $this->add_control(
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

        $this->add_control(
            'get_employers_by',
            [
                'label' => esc_html__( 'Get Employers By', 'workup' ),
                'type' => Elementor\Controls_Manager::SELECT,
                'options' => array(
                    'featured' => esc_html__('Featured Employers', 'workup'),
                    'recent' => esc_html__('Recent Employers', 'workup'),
                ),
                'default' => 'recent'
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
                ),
                'default' => 'carousel'
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

        $category_slugs = !empty($category_slugs) ? array_map('trim', explode(',', $category_slugs)) : array();
        $location_slugs = !empty($location_slugs) ? array_map('trim', explode(',', $location_slugs)) : array();

        $args = array(
            'limit' => $limit,
            'get_employers_by' => $get_employers_by,
            'orderby' => $orderby,
            'order' => $order,
            'categories' => $category_slugs,
            'locations' => $location_slugs,
        );
        $loop = workup_get_employers($args);
        if ( $loop->have_posts() ) {
            ?>
            <div class="widget-employers <?php echo esc_attr($layout_type); ?> <?php echo esc_attr($el_class); ?>">
                <?php if ( $title ) { ?>
                    <h2 class="widget-title"><?php echo wp_kses_post($title); ?></h2>
                <?php } ?>
                <div class="widget-content">
                    <?php if ( $layout_type == 'carousel' ): ?>
                        <div class="slick-carousel" data-carousel="slick" data-items="<?php echo esc_attr($columns); ?>" data-smallmedium="2" data-extrasmall="1" data-pagination="<?php echo esc_attr( $show_pagination ? 'true' : 'false' ); ?>" data-nav="<?php echo esc_attr( $show_nav ? 'true' : 'false' ); ?>" data-rows="<?php echo esc_attr( $rows ); ?>" data-infinite="<?php echo esc_attr( $infinite_loop ? 'true' : 'false' ); ?>" data-autoplay="<?php echo esc_attr( $autoplay ? 'true' : 'false' ); ?>">
                            <?php while ( $loop->have_posts() ): $loop->the_post(); ?>
                                <div class="item">
                                    <?php get_template_part( 'template-jobs/employers-styles/inner', 'grid'); ?>
                                </div>
                            <?php endwhile; ?>
                        </div>
                    <?php else: ?>
                        <?php
                            $mdcol = 12/$columns;
                            $smcol = $columns >= 2 ? 6 : 12;
                        ?>
                        <div class="row">
                            <?php while ( $loop->have_posts() ) : $loop->the_post(); ?>
                                <div class="col-md-<?php echo esc_attr($mdcol); ?> col-sm-<?php echo esc_attr($smcol); ?> col-xs-12">
                                    <?php get_template_part( 'template-jobs/employers-styles/inner', 'grid' ); ?>
                                </div>
                            <?php endwhile; ?>
                        </div>
                    <?php endif; ?>
                    <?php wp_reset_postdata(); ?>
                </div>
            </div>
            <?php
        }

    }

}

Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Workup_Elementor_Job_Board_Employers );