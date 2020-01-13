<?php

class Workup_Widget_Candidate_CV extends Apus_Widget {
    public function __construct() {
        parent::__construct(
            'apus_candidate_cv',
            esc_html__('Candidate Detail:: Candidate CV', 'workup'),
            array( 'description' => esc_html__( 'Show candidate cv', 'workup' ), )
        );
        $this->widgetName = 'candidate_cv';
    }

    public function getTemplate() {
        $this->template = 'candidate-cv.php';
    }

    public function widget( $args, $instance ) {
        $this->display($args, $instance);
    }
    
    public function form( $instance ) {
        $defaults = array(
            'title' => '',
        );
        $instance = wp_parse_args((array) $instance, $defaults);
        // Widget admin form
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>"><?php esc_html_e( 'Title:', 'workup' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>" />
        </p>
<?php
    }

    public function update( $new_instance, $old_instance ) {
        return $new_instance;
    }
}
if ( function_exists('apus_framework_reg_widget') ) {
    apus_framework_reg_widget('Workup_Widget_Candidate_CV');
}