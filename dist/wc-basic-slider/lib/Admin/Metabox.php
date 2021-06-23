<?php // phpcs:ignore WordPress.NamingConventions.ValidHookName.UseUnderscores
/**
 * Metabox functionality of the plugin.
 *
 * @link       https://wordpress.org/plugins/wc-basic-slider/
 * @since      1.0.0
 *
 * @package    bsfw_Plugin
 * @subpackage bsfw_Plugin/admin
 */

namespace BSFW\Slider\Admin;

use Carbon_Fields\Container;
use Carbon_Fields\Field;
use BSFW\Slider\Common\Helpers;

/**
 * Undocumented class
 */
class Metabox {
	/**
	 * Register Metabox
	 *
	 * @return void
	 */
	public function register_metabox() {
		$this->slider();
	}
	/**
	 * Slider Item.
	 *
	 * @return void
	 */
	private function slider() {
		Container::make( 'post_meta', __( 'Slider Settings' ) )
			->where( 'post_type', '=', 'bs_slider' )
			->add_tab( __( 'Settings', 'bs_slider' ), $this->settings() )
			->add_tab( __( 'Slider Items', 'bs_slider' ), $this->slider_items() )
			->add_tab( __( 'Additional', 'bs_slider' ), $this->additional() )
			->add_tab( __( 'Responsive', 'bs_slider' ), $this->responsive() );
	}
	/**
	 * Slider Settings.
	 *
	 * @return Array
	 */
	private function settings() {
		$fields   = array();
		$fields[] = Field::make( 'radio_image', 'select_slider_type', 'Select Type' )
		->add_options(
			array(
				'category_slider' => BSFW_ASSETS . '/images/Category-slider.jpg',
				'main_slider'     => BSFW_ASSETS . '/images/Promotional-Slider.jpg',
			)
		)->set_required( true );

		$fields[] = Field::make( 'radio_image', 'category_layout', 'Select Layout' )
					->set_conditional_logic(
						array(
							'relation' => 'AND',
							array(
								'field'   => 'select_slider_type',
								'value'   => 'category_slider',
								'compare' => '=',
							),
						)
					)
					->add_options(
						array(
							'slider' => BSFW_ASSETS . '/images/slider.png',
							'grid'   => BSFW_ASSETS . '/images/grid.png',
						)
					)->set_required( true );
		$fields[] = Field::make( 'radio_image', 'category_content_position', 'Content Posotion' )
					->set_conditional_logic(
						array(
							'relation' => 'AND',
							array(
								'field'   => 'select_slider_type',
								'value'   => 'category_slider',
								'compare' => '=',
							),
						)
					)
					->add_options(
						array(
							'below-content'   => BSFW_ASSETS . '/images/below-content.png',
							'overlay-content' => BSFW_ASSETS . '/images/overlay-content.png',
						)
					)->set_required( true );

		return $fields;
	}
	/**
	 * Slider Settings.
	 *
	 * @return Array
	 */
	private function additional() {
		$fields   = array();
		$image_size = Helpers::get_all_image_sizes();
		$fields[] = Field::make( 'select', 'select_perview', __( 'Slider per view' ) )
			->set_conditional_logic(
				array(
					'relation' => 'AND',
					array(
						'field'   => 'select_slider_type',
						'value'   => 'category_slider',
						'compare' => '=',
					),
				)
			)
			->set_options(
				array(
					'3' => __( '3 Items', 'bs-slider' ),
					'4' => __( '4 Items', 'bs-slider' ),
					'5' => __( '5 Items', 'bs-slider' ),
					'6' => __( '6 Items', 'bs-slider' ),
				)
			);
		$fields[] = Field::make( 'select', 'select_image_size', __( 'Choose Image size' ) )
					->set_options( $image_size );
		$fields[] = Field::make( 'checkbox', 'slider_pagination', __( 'Show Pagination' ) )->set_option_value( 'yes' );
		$fields[] = Field::make( 'checkbox', 'slider_arrow', __( 'Show Arrow' ) )->set_option_value( 'yes' );
		$fields[] = Field::make( 'checkbox', 'hide_title', __( 'Hide Title' ) )
					->set_conditional_logic(
						array(
							'relation' => 'AND',
							array(
								'field'   => 'select_slider_type',
								'value'   => 'category_slider',
								'compare' => '=',
							),
						)
					)->set_option_value( 'yes' );
		$fields[] = Field::make( 'checkbox', 'hide_button', __( 'Hide Button' ) )
					->set_conditional_logic(
						array(
							'relation' => 'AND',
							array(
								'field'   => 'select_slider_type',
								'value'   => 'category_slider',
								'compare' => '=',
							),
						)
					)->set_option_value( 'yes' );
		$fields[] = Field::make( 'text', 'category_button_text', __( 'Button Text' ) )
					->set_conditional_logic(
						array(
							'relation' => 'AND',
							array(
								'field'   => 'select_slider_type',
								'value'   => 'category_slider',
								'compare' => '=',
							),
						)
					)->set_help_text( 'Leave empty for default image' );
		return $fields;
	}
	/**
	 * Slider Settings.
	 *
	 * @return Array
	 */
	private function responsive() {
		$fields   = array();
		$fields[] = Field::make( 'html', 'bs_slider_pro' )
					->set_conditional_logic(
						array(
							'relation' => 'AND',
							array(
								'field'   => 'select_slider_type',
								'value'   => 'main_slider',
								'compare' => '=',
							),
						)
					)
				->set_html( '<h1>Responsive Slider Height</h1>' );
		$fields[] = Field::make( 'text', 'height_for_min_1200', __( 'Device min width: 1200px' ) )
					->set_conditional_logic(
						array(
							'relation' => 'AND',
							array(
								'field'   => 'select_slider_type',
								'value'   => 'main_slider',
								'compare' => '=',
							),
						)
					)
					->set_help_text( 'Example: 750px' );
		$fields[] = Field::make( 'text', 'height_for_min_992', __( 'Device min width:992px' ) )
				->set_conditional_logic(
					array(
						'relation' => 'AND',
						array(
							'field'   => 'select_slider_type',
							'value'   => 'main_slider',
							'compare' => '=',
						),
					)
				)
				->set_help_text( 'Example: 700px' );
		$fields[] = Field::make( 'text', 'height_for_min_768', __( 'Device min width:768px' ) )
				->set_conditional_logic(
					array(
						'relation' => 'AND',
						array(
							'field'   => 'select_slider_type',
							'value'   => 'main_slider',
							'compare' => '=',
						),
					)
				)
				->set_help_text( 'Example: 600px' );
		$fields[] = Field::make( 'text', 'height_for_min_600', __( 'Device min width:600px' ) )
				->set_conditional_logic(
					array(
						'relation' => 'AND',
						array(
							'field'   => 'select_slider_type',
							'value'   => 'main_slider',
							'compare' => '=',
						),
					)
				)
				->set_help_text( 'Example: 500px' );
		$fields[] = Field::make( 'text', 'height_for_min_320', __( 'Device more small' ) )
					->set_conditional_logic(
						array(
							'relation' => 'AND',
							array(
								'field'   => 'select_slider_type',
								'value'   => 'main_slider',
								'compare' => '=',
							),
						)
					)
					->set_help_text( 'Example: 400px' );
		$fields[] = Field::make( 'html', 'bs_slider_pro_category' )
					->set_conditional_logic(
						array(
							'relation' => 'AND',
							array(
								'field'   => 'select_slider_type',
								'value'   => 'category_slider',
								'compare' => '=',
							),
						)
					)
				->set_html( '<h1>Responsive Setting Is not available For Category Slider</h1>' );
		return $fields;
	}
	/**
	 * Slider Items.
	 *
	 * @return array
	 */
	private function slider_items() {
		$fields        = array();
		$category_list = array();
		global $wpdb;
		$categories        = $wpdb->get_results(
			"SELECT ter.name ,ter.slug ,tax.count
			FROM {$wpdb->term_taxonomy} AS tax,{$wpdb->terms} AS ter
			WHERE tax.taxonomy = 'product_cat'
			AND ter.term_id = tax.term_id
			AND tax.count > 0 "
		);
		$category_list[''] = __( '--Select One--', 'bs-slider' );
		if ( $categories ) {
			foreach ( $categories as $cat ) {
				$category_name               = $cat->name . ' (' . $cat->count . ')';
				$category_list[ $cat->slug ] = esc_html( $category_name );
			}
		}

		$fields[] = Field::make( 'complex', 'category_slider', __( 'Category slider' ) )
					->set_layout( 'tabbed-vertical' )
					->set_conditional_logic(
						array(
							'relation' => 'AND',
							array(
								'field'   => 'select_slider_type',
								'value'   => 'category_slider',
								'compare' => '=',
							),
						)
					)
					->add_fields(
						array(
							Field::make( 'select', 'select_category', __( 'Choose One Category' ) )
								->set_options( $category_list )
								->set_help_text( 'Note: Empty category are hidden' ),
							Field::make( 'image', 'category_image', __( 'Category Image' ) )
							->set_conditional_logic(
								array(
									'relation' => 'AND',
									array(
										'field'   => 'select_category',
										'value'   => '',
										'compare' => '!=',
									),
								)
							)->set_help_text( 'Leave empty for default image' ),
						)
					);
		$fields[] = Field::make( 'complex', 'slider_item', 'Add Slider Items' )
					->set_layout( 'tabbed-vertical' )
					->set_conditional_logic(
						array(
							'relation' => 'AND',
							array(
								'field'   => 'select_slider_type',
								'value'   => 'main_slider',
								'compare' => '=',
							),
						)
					)
					->add_fields(
						array(
							Field::make( 'image', 'main_slider_image', __( 'Slider Image' ) )
							->set_required( true ),
							Field::make( 'complex', 'slider_title', __( 'Add more content ' ) )
							->set_layout( 'tabbed-vertical' )
							->add_fields(
								array(
									Field::make( 'textarea', 'main_slider_title', __( 'Slide Content' ) )
										->set_help_text( 'Enter text here' ),
									Field::make( 'text', 'animation_duration', __( 'Animation duration' ) )
										->set_help_text( 'Animation duration Example: 0.5s' ),
									Field::make( 'text', 'animation_delay', __( 'Animation delay' ) )
										->set_help_text( 'Animation delay Example: 0.5s' ),
									Field::make( 'select', 'select_slider_animation', __( 'Choose slider Animation' ) )
									->set_options(
										Helpers::dropdown_animation()
									),

								)
							),

						)
					);
		return $fields;
	}

	/**
	 * Register Custom Meta Box
	 *
	 * @param mixed $post_type current post type name.
	 * @return void
	 */
	public function shortcode_register_meta_box( $post_type ) {
		$types = array( BSFW_POST_TYPE );
		if ( in_array( $post_type, $types, true ) ) {
			add_meta_box(
				'bs-slider-metabox-shortcode',
				esc_html__( 'Shortcode', 'bs-slider' ),
				array( $this, 'shortcode_meta_box_callback' ),
				$types,
				'side',
				'low'
			);
		}

	}

	/**
	 * Add shortcode field
	 *
	 * @param object $post Post Object.
	 * @return void
	 */
	public function shortcode_meta_box_callback( $post ) {

		$slider_type = carbon_get_post_meta( $post->ID, 'select_slider_type' );
		$shortcode_by_id   = '';
		if ( 'main_slider' === $slider_type ) {
			$shortcode_by_id = '[bs_slider slider_id="' . $post->ID . '"]';
		}
		if ( 'category_slider' === $slider_type ) {
			$shortcode_by_id = '[woocategory_slider slider_id="' . $post->ID . '"]';
		}
		$shortcode = '<div class="tooltip"><span class="copy-button"  ><span class="tooltiptext" >Copy to clipboard</span><input class="copy_shortcode" type="text" value="' . esc_html( $shortcode_by_id ) . '" readonly></span></div>';
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
	}
}
