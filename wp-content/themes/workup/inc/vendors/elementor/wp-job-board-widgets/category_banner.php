<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Workup_Elementor_Job_Board_Category_Banner extends Elementor\Widget_Base {

	public function get_name() {
        return 'workup_job_board_category_banner';
    }

	public function get_title() {
        return esc_html__( 'Apus Category Banner', 'workup' );
    }
    
	public function get_categories() {
        return [ 'workup-elements' ];
    }

	protected function _register_controls() {

        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__( 'Category Banner', 'workup' ),
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
            'slug',
            [
                'label' => esc_html__( 'Category Slug', 'workup' ),
                'type' => Elementor\Controls_Manager::TEXT,
                'placeholder' => esc_html__( 'Enter your Category Slug here', 'workup' ),
            ]
        );

        $this->add_control(
            'icon',
            [
                'label' => esc_html__( 'Category Icon', 'workup' ),
                'type' => Elementor\Controls_Manager::ICON,
            ]
        );

        $this->add_control(
            'show_nb_jobs',
            [
                'label' => esc_html__( 'Show Number Jobs', 'workup' ),
                'type' => Elementor\Controls_Manager::SWITCHER,
                'default' => '',
                'label_on' => esc_html__( 'Hide', 'workup' ),
                'label_off' => esc_html__( 'Show', 'workup' ),
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


        $this->start_controls_section(
            'section_icon_style',
            [
                'label' => esc_html__( 'Style Icon', 'workup' ),
                'tab' => Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'icon_color',
            [
                'label' => esc_html__( 'Icon Color', 'workup' ),
                'type' => Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .category-banner-inner .category-icon' => 'color: {{VALUE}} !important;',
                ],
            ]
        );

        $this->add_control(
            'heading_color',
            [
                'label' => esc_html__( 'Heading Color', 'workup' ),
                'type' => Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .category-banner-inner .title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

    }

	protected function render() {
        $settings = $this->get_settings();

        extract( $settings );

        if ( empty($slug) ) {
            return;
        }
        ?>
        <div class="widget-job-category-banner <?php echo esc_attr($el_class); ?>">
            
            <?php
            $term = get_term_by( 'slug', $slug, 'job_listing_category' );
            if ($term) {

            ?>
                <a href="<?php echo esc_url(get_term_link( $term, 'job_listing_category' )); ?>">
                    <div class="category-banner-inner justify-content-center flex-middle">
                        <div class="content-inner">
                            <?php if ( !empty($icon) ) { ?>
                                <div class="category-icon text-theme"><i class="<?php echo esc_attr($icon); ?>"></i></div>
                            <?php } ?>
                            <div class="inner">
                                <?php if ( !empty($title) ) { ?>
                                    <h4 class="title">
                                        <?php echo trim($title); ?>
                                    </h4>
                                <?php } ?>

                                <?php if ( $show_nb_jobs ) {
                                        $args = array(
                                            'fields' => 'ids',
                                            'categories' => array($term->slug),
                                            'limit' => 1
                                        );
                                        $query = workup_get_jobs($args);
                                        $number_jobs = $count = $query->found_posts;
                                        $number_jobs = $number_jobs ? WP_Job_Board_Mixes::format_number($number_jobs) : 0;
                                ?>
                                    <div class="number"><?php echo sprintf(_n('<span>%d</span> Job', '<span>%d</span> Jobs', $count, 'workup'), $number_jobs); ?></div>
                                <?php } ?>
                            </div>
                        </div>
                        <?php if ( !empty($icon) ) { ?>
                            <div class="category-icon second-icon text-theme"><i class="<?php echo esc_attr($icon); ?>"></i></div>
                        <?php } ?>
                    </div>
                </a>
            <?php } ?>
        </div>
        <?php
    }
}
Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Workup_Elementor_Job_Board_Category_Banner );