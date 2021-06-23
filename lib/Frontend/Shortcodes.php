<?php
/**
 * Shortcode functionality
 *
 * @package  shortcode
 */

namespace BSFW\Slider\Frontend;

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	die;
}

/**
 * Redister shortcode
 */
class Shortcodes {

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	private $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of the plugin.
	 */
	private $version;

	/**
	 * Class constructor.
	 *
	 * @access public
	 * @since  1.0
	 */
	public function __construct() {
	}
	/**
	 * SHortcode Function Registered here
	 *
	 * @return void
	 */
	public function shortcode_list() {
		$shortcodes = array(
			'woocategory_slider',
			'bs_slider',
		);

		foreach ( $shortcodes as $shortcode ) :
			add_shortcode( $shortcode, array( $this, $shortcode . '_shortcode' ) );
		endforeach;

	}

	/**
	 * Shortcode handles class
	 *
	 * @param  array $atts shortcodew attribute.
	 * @param  mixed $content shortcode default content.
	 *
	 * @return string
	 */
	public function bs_slider_shortcode( $atts, $content ) {
		$slider = shortcode_atts(
			array(
				'slider_id' => '',
			),
			$atts
		);
		if ( ! $slider['slider_id'] ) {
			return;
		}
		$slider_id  = $slider['slider_id'];
		$swiper_js  = carbon_get_theme_option( 'deactive_js' );
		$swiper_css = carbon_get_theme_option( 'deactive_css' );

		if ( ! $swiper_js ) {
			wp_enqueue_script( 'swiper-slider-script' );
			wp_enqueue_script( 'swiper-animation-script' );
		}
		if ( ! $swiper_css ) {
			wp_enqueue_style( 'swiper-style' );
			wp_enqueue_style( 'animate-style' );
		}
		wp_enqueue_script( 'activation-script' );
		wp_enqueue_style( 'bs-frontend-style' );

		$result = '';
		ob_start();
		$args        = array(
			'post_type'      => 'bs_slider',
			'posts_per_page' => 1,
			'post__in'       => array( $slider_id ),
		);
		$slider_loop = new \WP_Query( $args );
		if ( $slider_loop->have_posts() ) {

			while ( $slider_loop->have_posts() ) {
				$slider_loop->the_post();

				$slider_item       = carbon_get_the_post_meta( 'slider_item' );
				$show_pagination   = carbon_get_the_post_meta( 'slider_pagination' );
				$show_arrow        = carbon_get_the_post_meta( 'slider_arrow' );
				$select_image_size = carbon_get_the_post_meta( 'select_image_size' );

				$height_for_min_1200 = carbon_get_the_post_meta( 'height_for_min_1200' );
				$height_for_min_992  = carbon_get_the_post_meta( 'height_for_min_992' );
				$height_for_min_768  = carbon_get_the_post_meta( 'height_for_min_768' );
				$height_for_min_600  = carbon_get_the_post_meta( 'height_for_min_600' );
				$height_for_min_320  = carbon_get_the_post_meta( 'height_for_min_320' );

				$height_for_min_320  = $height_for_min_320 ? $height_for_min_320 : '500px';
				$height_for_min_600  = $height_for_min_600 ? $height_for_min_600 : $height_for_min_320;
				$height_for_min_768  = $height_for_min_768 ? $height_for_min_768 : $height_for_min_600;
				$height_for_min_992  = $height_for_min_992 ? $height_for_min_992 : $height_for_min_768;
				$height_for_min_1200 = $height_for_min_1200 ? $height_for_min_1200 : $height_for_min_992;

				?>
				<style>
					@media (min-width: 300px) {
						.primary_slider .slide-inner{<?php echo esc_attr( "height:$height_for_min_320;" ); ?>}
					}
					@media (min-width: 600px) {
						.primary_slider .slide-inner{<?php echo esc_attr( "height:$height_for_min_600;" ); ?>}
					}
					@media (min-width: 768px) {
						.primary_slider .slide-inner{<?php echo esc_attr( "height:$height_for_min_768;" ); ?>}
					}
					@media (min-width: 992px) {
						.primary_slider .slide-inner{<?php echo esc_attr( "height:$height_for_min_992;" ); ?>}
					}
					@media (min-width: 1200px) {
						.primary_slider .slide-inner{<?php echo esc_attr( "height:$height_for_min_1200;" ); ?>;}
					}
				</style>
				<?php $parent_class = apply_filters( 'primary_slider_parent_class', 'slider-wrapper-class' ); ?>
				<div class="primary_slider swiper-container slider-type-1
				<?php echo esc_attr( $parent_class ); ?>">
						<!-- Slides -->
						<div class="swiper-wrapper">
						<?php
						foreach ( $slider_item as $slider ) {
							$attachment_id        = $slider['main_slider_image'];
							$slider_image         = wp_get_attachment_image_src( $attachment_id, $select_image_size );
							$slider_image_url     = $slider_image[0];
							$animate_text         = $slider['slider_title'];
							$background_image     = "background-image: url($slider_image_url)";
							$content_parent_class = apply_filters( 'primary_slider_slide_content_parent_class', 'slide-content-test' );

							include BSFW_PLUGIN_DIR . '/templates/simple_slider_1.php';
						}
						?>
						</div> <!-- end of swiper-slide -->
							<?php if ( $show_arrow ) { ?>
						<!-- Slider Navigation -->
						<div class="swiper-arrow next slide swiper-btn-next"></div>
						<div class="swiper-arrow prev slide swiper-btn-prev"></div>
					<?php } ?>
							<?php if ( $show_pagination ) { ?>
						<!-- Slider Pagination -->
						<div class="swiper-pagination"></div>
					<?php } ?>

				</div>

				<?php
			}
		} wp_reset_postdata();

		$result .= ob_get_clean();
		return $result;
	}
	/**
	 * Woocommearce shortcode handler.
	 *
	 * @param array $atts shortcode attribute.
	 * @param mixed $contant others content.
	 * @return void
	 */
	public function woocategory_slider_shortcode( $atts, $contant ) {
		$slider    = shortcode_atts(
			array(
				'slider_id' => '',
			),
			$atts
		);
		$slider_id = $slider['slider_id'];
		if ( ! $slider_id ) {
			return;
		}

		$result = '';
		ob_start();
		$args            = array(
			'post_type'      => 'bs_slider',
			'posts_per_page' => 1,
			'post__in'       => array( $slider_id ),
		);
		$cat_slider_loop = new \WP_Query( $args );
		if ( $cat_slider_loop->have_posts() ) {
			while ( $cat_slider_loop->have_posts() ) {
				$cat_slider_loop->the_post();
				$category_slider        = carbon_get_the_post_meta( 'category_slider' );
				$show_pagination        = carbon_get_the_post_meta( 'slider_pagination' );
				$button_text            = carbon_get_the_post_meta( 'category_button_text' );
				$show_arrow             = carbon_get_the_post_meta( 'slider_arrow' );
				$category_layout        = carbon_get_the_post_meta( 'category_layout' );
				$category_slidesperview = carbon_get_the_post_meta( 'select_perview' );
				$content_position       = carbon_get_the_post_meta( 'category_content_position' );
				$hide_title             = carbon_get_the_post_meta( 'hide_title' );
				$hide_button            = carbon_get_the_post_meta( 'hide_button' );
				$select_image_size      = carbon_get_the_post_meta( 'select_image_size' );
				$classes                = array();
				if ( $show_pagination ) {
					$classes[] = 'cat-slider-pagination';
				}
				if ( $show_arrow ) {
					$classes[] = 'cat-slider-arrow';
				}
				if ( 'slider' === $category_layout ) {
					$classes[] = 'category_slider_1';
				}
				if ( 'grid' === $category_layout ) {
					$classes[] = 'category_slider_2';
				}

				$class = implode( ' ', $classes );
				?>
					<div class="<?php echo esc_attr( $class ); ?> swiper-container content-align " data-slidesPerView="<?php echo esc_attr( $category_slidesperview ); ?>"  >

						<div class="swiper-wrapper">
							<?php
							foreach ( $category_slider as $value ) {
								if ( ! $value['select_category'] ) {
									continue;
								}
								$term           = get_term_by( 'slug', $value['select_category'], 'product_cat' );
								$categoryname   = $term->name;
								$category_link  = get_category_link( $term->term_id );
								$thumbnail_id   = get_term_meta( $term->term_id, 'thumbnail_id', true );
								$category_image = wp_get_attachment_image_src( $thumbnail_id, $select_image_size );
								if ( $value['category_image'] ) {
									$category_image = $value['category_image'];
									$category_image = wp_get_attachment_image_src( $category_image, $select_image_size );
									$category_image = $category_image[0];
								}

								include BSFW_PLUGIN_DIR . '/templates/category_slider_1.php';

							}
							?>
						</div>

						<?php if ( $show_arrow ) { ?>
							<!-- Slider Navigation -->
							<div class="swiper-arrow next swiper-btn-next"></div>
							<div class="swiper-arrow prev swiper-btn-prev"></div>
						<?php } ?>
						<?php if ( $show_pagination ) { ?>
							<!-- Slider Pagination -->
							<div class="swiper-pagination"></div>
						<?php } ?>

					</div>
				<?php

			}
		} wp_reset_postdata();

		$swiper_js  = carbon_get_theme_option( 'deactive_js' );
		$swiper_css = carbon_get_theme_option( 'deactive_css' );

		if ( ! $swiper_js ) {
			wp_enqueue_script( 'swiper-slider-script' );
			wp_enqueue_script( 'swiper-animation-script' );
		}
		if ( ! $swiper_css ) {
			wp_enqueue_style( 'swiper-style' );
			wp_enqueue_style( 'animate-style' );
		}

		wp_enqueue_script( 'activation-script' );
		wp_enqueue_style( 'bs-frontend-style' );

		$result .= ob_get_clean();
		return $result;

	}
}
