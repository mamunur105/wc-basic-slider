<?php
/**
 * Custom Post Type functionality of the plugin.
 *
 * @link       https://wordpress.org/plugins/wc-basic-slider/
 * @since      1.0.0
 *
 * @package    bsfw_Plugin
 * @subpackage bsfw_Plugin/admin
 */

namespace BSFW\Slider\Admin;

/**
 * The admin class
 */
class Custom_Post_Type {

	/**
	 * Slug
	 *
	 * @var string slug
	 */
	public $slug;

	/**
	 * Const
	 */
	public function __construct() {
		if ( defined( 'BSFW_POST_TYPE' ) ) {
			$this->slug = BSFW_POST_TYPE;
		} else {
			$this->slug = 'bs_slider';
		}
	}

	/**
	 * Register post type
	 */
	public function register_bs_slider() {

		$labels = array(
			'name'               => _x( 'Wc Slider', 'post type general name', 'wc-basic-slider' ),
			'singular_name'      => _x( 'Wc Slider', 'post type singular name', 'wc-basic-slider' ),
			'menu_name'          => _x( 'Wc Slider', 'admin menu', 'wc-basic-slider' ),
			'name_admin_bar'     => _x( 'Wc Slider', 'add new on admin bar', 'wc-basic-slider' ),
			'add_new'            => _x( 'Add New', 'book', 'wc-basic-slider' ),
			'add_new_item'       => __( 'Add New Slider', 'wc-basic-slider' ),
			'new_item'           => __( 'New Slider', 'wc-basic-slider' ),
			'edit_item'          => __( 'Edit Slider', 'wc-basic-slider' ),
			'view_item'          => __( 'View Slider', 'wc-basic-slider' ),
			'all_items'          => __( 'All Sliders', 'wc-basic-slider' ),
			'search_items'       => __( 'Search Slider', 'wc-basic-slider' ),
			'parent_item_colon'  => __( 'Parent Slider:', 'wc-basic-slider' ),
			'not_found'          => __( 'No Slider found.', 'wc-basic-slider' ),
			'not_found_in_trash' => __( 'No Slider found in Trash.', 'wc-basic-slider' ),
		);

		$args = array(
			'labels'             => $labels,
			'description'        => __( 'Description.', 'wc-basic-slider' ),
			'public'             => false,
			'publicly_queryable' => false,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'can_export'         => true,
			'capability_type'    => 'post',
			'has_archive'        => false,
			'hierarchical'       => false,
			'menu_position'      => null,
			'menu_icon'          => 'dashicons-images-alt',
			'supports'           => array( 'title' ),
			'show_in_rest'       => true,
			'rewrite'            => array(
				'slug'       => apply_filters( 'bsfw_slider_slug', 'wc-basic-slider' ),
				'with_front' => false,
			),
		);

		register_post_type( $this->slug, $args );
	}

	/**
	 * Register shortcode column
	 *
	 * @param string $columns Table column.
	 *
	 * @return mixed
	 */
	public function set_shortocode_column( $columns ) {
		unset( $columns['date'] );
		$columns['shortcode'] = esc_html__( 'Shortcode', 'wc-basic-slider' );
		$columns['date']      = esc_html__( 'Date', 'wc-basic-slider' );
		return $columns;
	}

	/**
	 * Show shortcode column data
	 *
	 * @param string $column column value.
	 * @param int    $post_id post id.
	 */
	public function shortocode_column_data( $column, $post_id ) {
		$slider_type  = carbon_get_post_meta( $post_id, 'select_slider_type' );
		$shortcode_id = '';
		if ( 'main_slider' === $slider_type ) {
			$shortcode_id = '[bs_slider slider_id="' . $post_id . '"]';
		}
		if ( 'category_slider' === $slider_type ) {
			$shortcode_id = '[woocategory_slider slider_id="' . $post_id . '"]';
		}
		$shortcode = '<div class="tooltip"><span class="copy-button"  ><span class="tooltiptext" >Copy to clipboard</span><input class="copy_shortcode" type="text" value="' . esc_html( $shortcode_id ) . '" readonly></span></div>';
		switch ( $column ) {
			case 'shortcode':
				echo wp_kses(
					$shortcode,
					array(
						'input' => array(
							'class'    => array(),
							'type'     => 'text',
							'value'    => array(),
							'disabled' => true,
							'readonly' => true,
						),
						'div'   => array(
							'class' => array(),
						),
						'span'  => array(
							'class' => array(),
						),

					)
				);
				break;
		}
	}

}

