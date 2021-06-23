<?php // phpcs:ignore WordPress.NamingConventions.ValidHookName.UseUnderscores
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
			'name'               => _x( 'Wc Slider', 'post type general name', 'bs-slider' ),
			'singular_name'      => _x( 'Wc Slider', 'post type singular name', 'bs-slider' ),
			'menu_name'          => _x( 'Wc Slider', 'admin menu', 'bs-slider' ),
			'name_admin_bar'     => _x( 'Wc Slider', 'add new on admin bar', 'bs-slider' ),
			'add_new'            => _x( 'Add New', 'book', 'bs-slider' ),
			'add_new_item'       => __( 'Add New Slider', 'bs-slider' ),
			'new_item'           => __( 'New Slider', 'bs-slider' ),
			'edit_item'          => __( 'Edit Slider', 'bs-slider' ),
			'view_item'          => __( 'View Slider', 'bs-slider' ),
			'all_items'          => __( 'All Sliders', 'bs-slider' ),
			'search_items'       => __( 'Search Slider', 'bs-slider' ),
			'parent_item_colon'  => __( 'Parent Slider:', 'bs-slider' ),
			'not_found'          => __( 'No Slider found.', 'bs-slider' ),
			'not_found_in_trash' => __( 'No Slider found in Trash.', 'bs-slider' ),
		);

		$args = array(
			'labels'             => $labels,
			'description'        => __( 'Description.', 'bs-slider' ),
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
			'rewrite'             => array(
				'slug'       => apply_filters( 'bs_slider_slug', 'bs-slider' ),
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
		$columns['shortcode'] = __( 'Shortcode', 'bs-slider' );
		$columns['date']      = __( 'Date', 'bs-slider' );
		return $columns;
	}

	/**
	 * Show shortcode column data
	 *
	 * @param string $column column value.
	 * @param int    $post_id post id.
	 */
	public function shortocode_column_data( $column, $post_id ) {
		$slider_type = carbon_get_post_meta( $post_id, 'select_slider_type' );
		$shortcode_id   = '';
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

