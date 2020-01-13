<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Workup_Elementor_Jobs_Packages extends Elementor\Widget_Base {

	public function get_name() {
        return 'workup_jobs_packages';
    }

	public function get_title() {
        return esc_html__( 'Apus Packages', 'workup' );
    }
    
	public function get_categories() {
        return [ 'workup-elements' ];
    }

	protected function _register_controls() {
        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__( 'Content', 'workup' ),
                'tab' => Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_control(
            'package_type',
            [
                'label' => esc_html__( 'Packages Type', 'workup' ),
                'type' => Elementor\Controls_Manager::SELECT,
                'options' => array(
                    'job_package' => esc_html__('Job Package', 'workup'),
                    'cv_package' => esc_html__('CV Package', 'workup'),
                    'contact_package' => esc_html__('Contact Package', 'workup'),
                    'candidate_package' => esc_html__('Canidate Package', 'workup'),
                    'resume_package' => esc_html__('Resume Package', 'workup'),
                ),
                'default' => 'job_package'
            ]
        );
        $this->add_control(
            'number',
            [
                'label' => esc_html__( 'Number Product', 'workup' ),
                'type' => Elementor\Controls_Manager::NUMBER,
                'input_type' => 'number',
                'description' => esc_html__( 'Number Product to display', 'workup' ),
                'default' => 3
            ]
        );
        $this->add_control(
            'columns',
            [
                'label' => esc_html__( 'Columns', 'workup' ),
                'type' => Elementor\Controls_Manager::TEXT,
                'input_type' => 'number',
                'default' => 3,
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
            'section_title_style',
            [
                'label' => esc_html__( 'Style', 'workup' ),
                'tab' => Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'bg_color',
            [
                'label' => esc_html__( 'Background for Highlight', 'workup' ),
                'type' => Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    // Stronger selector to avoid section style from overwriting
                    '{{WRAPPER}} .subwoo-inner.is_featured .header-sub' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_section();
    }

	protected function render() {
        $settings = $this->get_settings();

        extract( $settings );

        $loop = workup_get_products( array('product_type' => $package_type, 'post_per_page' => $number));
        ?>
        <div class="widget woocommerce widget-subwoo <?php echo esc_attr($el_class); ?>">
            <?php if ($loop->have_posts()): ?>
                <div class="row">
                    <?php while ( $loop->have_posts() ) : $loop->the_post(); global $product; ?>
                        <div class="col-xs-12 col-sm-<?php echo esc_attr(12/$columns); ?>">
                            <div class="subwoo-inner <?php echo esc_attr( $product->is_featured() ? ' is_featured' : '' ); ?>">
                                <div class="item">
                                    <div class="header-sub">
                                        <div class="icon-wrapper">
                                            <?php
                                            $icon_class = get_post_meta($product->get_id(), '_jobs_icon_class', true);
                                            if ( $icon_class ) {
                                                ?>
                                                <span class="<?php echo esc_attr($icon_class); ?>"></span>
                                                <?php
                                            }
                                            ?>
                                        </div>
                                        <h3 class="title"><?php the_title(); ?></h3>
                                    </div>
                                    <div class="bottom-sub">
                                        <div class="price"><?php echo (!empty($product->get_price())) ? $product->get_price_html() : esc_html__('Free','workup'); ?></div>
                                        <?php if ( has_excerpt() ) { ?>
                                            <div class="short-des"><?php the_excerpt(); ?></div>
                                        <?php } ?>
                                        <div class="button-action"><?php do_action( 'woocommerce_after_shop_loop_item' ); ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>  
                    <?php endwhile; ?>
                </div>
                <?php wp_reset_postdata(); ?>
            <?php endif; ?>
        </div>
        <?php
    }
}

Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Workup_Elementor_Jobs_Packages );