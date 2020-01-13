<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Workup_Elementor_Job_Board_Search_Form extends Elementor\Widget_Base {

	public function get_name() {
        return 'workup_job_board_search_form';
    }

	public function get_title() {
        return esc_html__( 'Apus Search Form', 'workup' );
    }
    
	public function get_categories() {
        return [ 'workup-elements' ];
    }

	protected function _register_controls() {

        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__( 'City Banner', 'workup' ),
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
            'show_keyword_field',
            [
                'label' => esc_html__( 'Show keyword field', 'workup' ),
                'type' => Elementor\Controls_Manager::SWITCHER,
                'default' => '',
                'label_on' => esc_html__( 'Hide', 'workup' ),
                'label_off' => esc_html__( 'Show', 'workup' ),
            ]
        );

        $this->add_control(
            'show_location_field',
            [
                'label' => esc_html__( 'Show location field', 'workup' ),
                'type' => Elementor\Controls_Manager::SWITCHER,
                'default' => '',
                'label_on' => esc_html__( 'Hide', 'workup' ),
                'label_off' => esc_html__( 'Show', 'workup' ),
            ]
        );

        $this->add_control(
            'show_type_field',
            [
                'label' => esc_html__( 'Show type field', 'workup' ),
                'type' => Elementor\Controls_Manager::SWITCHER,
                'default' => '',
                'label_on' => esc_html__( 'Hide', 'workup' ),
                'label_off' => esc_html__( 'Show', 'workup' ),
            ]
        );

        $this->add_control(
            'show_category_field',
            [
                'label' => esc_html__( 'Show category field', 'workup' ),
                'type' => Elementor\Controls_Manager::SWITCHER,
                'default' => '',
                'label_on' => esc_html__( 'Hide', 'workup' ),
                'label_off' => esc_html__( 'Show', 'workup' ),
            ]
        );

        $this->add_control(
            'keywords',
            [
                'label' => esc_html__( 'Trending Keywords', 'workup' ),
                'type' => Elementor\Controls_Manager::TEXTAREA,
                'rows' => 2,
                'default' => '',
                'placeholder' => esc_html__( 'Enter id spearate by comma(,)', 'workup' ),
            ]
        );

        $this->add_control(
            'layout_type',
            [
                'label' => esc_html__( 'Layout Type', 'workup' ),
                'type' => Elementor\Controls_Manager::SELECT,
                'options' => array(
                    'layout1' => esc_html__('Layout 1', 'workup'),
                    'layout2' => esc_html__('Layout 2', 'workup'),
                ),
                'default' => 'layout1'
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
            'section_title',
            [
                'label' => esc_html__( 'Title', 'workup' ),
                'tab' =>Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'bg_color',
            [
                'label' => esc_html__( 'Background Color', 'workup' ),
                'type' => Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    // Stronger selector to avoid section style from overwriting
                    '{{WRAPPER}} .search-form-inner ' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'bg_button_color',
            [
                'label' => esc_html__( 'Background Button Color', 'workup' ),
                'type' => Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    // Stronger selector to avoid section style from overwriting
                    '{{WRAPPER}} .form-search .btn-submit' => 'background: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'bg_button_hv_color',
            [
                'label' => esc_html__( 'Background Button Hover Color', 'workup' ),
                'type' => Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    // Stronger selector to avoid section style from overwriting
                    '{{WRAPPER}} .form-search .btn-submit:hover' => 'background: {{VALUE}};',
                    '{{WRAPPER}} .form-search .btn-submit:focus' => 'background: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'section_keywords',
            [
                'label' => esc_html__( 'Keywords', 'workup' ),
                'tab' =>Elementor\Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'title_key',
            [
                'label' => esc_html__( 'Title Color', 'workup' ),
                'type' => Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    // Stronger selector to avoid section style from overwriting
                    '{{WRAPPER}} .form-search .trending-keywords .title' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'key_color',
            [
                'label' => esc_html__( 'Key Color', 'workup' ),
                'type' => Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    // Stronger selector to avoid section style from overwriting
                    '{{WRAPPER}} .form-search .trending-keywords a' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .form-search .trending-keywords' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'key_hover_color',
            [
                'label' => esc_html__( 'Key Hover Color', 'workup' ),
                'type' => Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    // Stronger selector to avoid section style from overwriting
                    '{{WRAPPER}} .form-search .trending-keywords a:hover' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .form-search .trending-keywords a:focus' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_section();
    }

	protected function render() {
        $settings = $this->get_settings();

        extract( $settings );
        $fields = array(
            'title' => array(
                'label' => esc_html__( 'Search Keywords', 'workup' ),
                'show_title' => false,
                'field_call_back' => array( 'WP_Job_Board_Mixes', 'filter_field_input'),
                'placeholder' => esc_html__( 'Job Title or Keywords', 'workup' ),
                'icon' => 'fa fa-pencil'
            ),
            'category' => array(
                'label' => esc_html__( 'Category', 'workup' ),
                'show_title' => false,
                'field_call_back' => array( 'WP_Job_Board_Mixes', 'filter_field_taxonomy_select'),
                'taxonomy' => 'job_listing_category',
                'placeholder' => esc_html__( 'All Categories', 'workup' ),
            ),
            'center-location' => array(
                'label' => esc_html__( 'Location', 'workup' ),
                'show_title' => false,
                'field_call_back' => array( 'WP_Job_Board_Mixes', 'filter_field_input_location'),
                'placeholder' => esc_html__( 'Location', 'workup' ),
                'icon' => 'fa fa-map-marker'
            ),
            'type' => array(
                'label' => esc_html__( 'Type', 'workup' ),
                'show_title' => false,
                'field_call_back' => array( 'WP_Job_Board_Mixes', 'filter_field_taxonomy_select'),
                'taxonomy' => 'job_listing_type',
                'placeholder' => esc_html__( 'All Types', 'workup' ),
            )
        );
        $widget_id = workup_random_key();

        $search_page_url = WP_Job_Board_Mixes::get_jobs_page_url();

        wp_enqueue_script('select2');
        wp_enqueue_style('select2');
        ?>
        <div class="widget-job-search-form <?php echo esc_attr($el_class); ?>">
            <?php if ( !empty($title) ) { ?>
                <h1 class="title">
                    <?php echo wp_kses_post($title); ?>
                </h1>
            <?php } ?>
            <?php  
                $number = array();
                if(!empty($show_location_field)){
                    $number[] = 1;
                }
                if(!empty($show_type_field)){
                    $number[] = 1;
                }
                if(!empty($show_category_field)){
                    $number[] = 1;
                }
            ?>
            <form action="<?php echo esc_url($search_page_url); ?>" class="form-search <?php echo esc_attr($layout_type); ?>" method="GET">
                <div class="<?php echo esc_attr(($layout_type == 'layout2')?'flex-middle':'flex-middle-sm'); ?> search-form-inner 
                    <?php echo esc_attr( (count($number) == 1 ) ? 'group-title-large':'' ); ?>">
                    <?php
                        $instance = array();
                        $args = array( 'widget_id' => $widget_id );
                        if ( $show_keyword_field ) {
                            $key = 'title';
                            $field = $fields['title'];
                            if ( !empty($field['field_call_back']) ) {
                                call_user_func( $field['field_call_back'], $instance, $args, $key, $field );
                            }
                        }
                        if ( $show_location_field ) {
                            $key = 'center-location';
                            $field = $fields['center-location'];
                            if ( !empty($field['field_call_back']) ) {
                                call_user_func( $field['field_call_back'], $instance, $args, $key, $field );
                            }
                        }
                        if ( $show_type_field ) {
                            $key = 'type';
                            $field = $fields['type'];
                            if ( !empty($field['field_call_back']) ) {
                                call_user_func( $field['field_call_back'], $instance, $args, $key, $field );
                            }
                        }
                        if ( $show_category_field ) {
                            $key = 'category';
                            $field = $fields['category'];
                            if ( !empty($field['field_call_back']) ) {
                                call_user_func( $field['field_call_back'], $instance, $args, $key, $field );
                            }
                        }
                    ?>
                    <div class="form-group form-group-search">
                        <button class="btn-submit btn btn-block btn-theme" type="submit"><?php echo esc_html__('Find Jobs','workup') ?></button>
                    </div>
                </div>
                <?php
                    $keywords = !empty($keywords) ? array_map('trim', explode(',', $keywords)) : array();
                    if ( !empty($keywords) ) {
                ?>
                    <div class="content-trending">
                        <ul class="trending-keywords">
                            <li class="title"><?php esc_html_e('Trending Keywords:', 'workup'); ?></li>
                            <?php foreach ($keywords as $keyword) {
                                $link = add_query_arg( 'filter-title', strtolower($keyword), remove_query_arg( 'filter-title', $search_page_url ) );
                            ?>
                                <li class="item"><a href="<?php echo esc_url($link); ?>"><?php echo esc_html($keyword); ?></a></li>
                            <?php } ?>
                        </ul>
                    </div>
                <?php } ?>
            </form>
        </div>
        <?php
    }
}

Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Workup_Elementor_Job_Board_Search_Form );