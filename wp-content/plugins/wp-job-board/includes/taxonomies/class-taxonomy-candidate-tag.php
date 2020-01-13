<?php
/**
 * Tags
 *
 * @package    wp-job-board
 * @author     ApusTheme <apusthemes@gmail.com >
 * @license    GNU General Public License, version 3
 * @copyright  13/06/2016 ApusTheme
 */
 
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
class WP_Job_Board_Taxonomy_Candidate_Tag{

	/**
	 *
	 */
	public static function init() {
		add_action( 'init', array( __CLASS__, 'definition' ), 1 );
	}

	/**
	 *
	 */
	public static function definition() {
		$labels = array(
			'name'              => __( 'Tags', 'wp-job-board' ),
			'singular_name'     => __( 'Tag', 'wp-job-board' ),
			'search_items'      => __( 'Search Tags', 'wp-job-board' ),
			'all_items'         => __( 'All Tags', 'wp-job-board' ),
			'parent_item'       => __( 'Parent Tag', 'wp-job-board' ),
			'parent_item_colon' => __( 'Parent Tag:', 'wp-job-board' ),
			'edit_item'         => __( 'Edit', 'wp-job-board' ),
			'update_item'       => __( 'Update', 'wp-job-board' ),
			'add_new_item'      => __( 'Add New', 'wp-job-board' ),
			'new_item_name'     => __( 'New Tag', 'wp-job-board' ),
			'menu_name'         => __( 'Tags', 'wp-job-board' ),
		);

		register_taxonomy( 'candidate_tag', 'candidate', array(
			'labels'            => apply_filters( 'wp_job_board_taxomony_job_tag_labels', $labels ),
			'hierarchical'      => false,
			'query_var'         => 'candidate-tag',
			'rewrite'           => array( 'slug' => _x( 'candidate-tag', 'Candidate tag slug - resave permalinks after changing this', 'wp-job-board' ) ),
			'public'            => true,
			'show_ui'           => true,
			'show_in_rest'		=> true
		) );
	}

}

WP_Job_Board_Taxonomy_Candidate_Tag::init();