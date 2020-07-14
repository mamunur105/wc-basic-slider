<?php
namespace Basic\Slider\Frontend;

/**
 * 
 */
class ProductSlider 
{
	
	function __construct(){
		remove_action('woocommerce_after_single_product_summary','woocommerce_output_related_products',20);
		add_action('woocommerce_after_single_product_summary',[$this,'relatedProduct'],21);
		add_filter( 'post_class', [$this,'cx_filter_related_product_post_class'], 10, 3 );
	}

	function cx_filter_related_product_post_class( $classes, $class, $product_id ){
	    // Only on shop page
		global $woocommerce_loop;

		if ( is_product() && $woocommerce_loop['name'] == 'related' ) {
		    $classes[] = 'swiper-slide';
		}
	    return $classes;
	}

	function  relatedProduct(){ 

		$swiper_js = carbon_get_theme_option( 'deactive_js' );
		$swiper_css = carbon_get_theme_option( 'deactive_css' );
		$pagination = carbon_get_theme_option( 'related_product_pagination' );
		$arrow = carbon_get_theme_option( 'related_product_arrow' );
		if (!$swiper_js) {
			wp_enqueue_script( 'swiper-slider-script' );
			wp_enqueue_script( 'swiper-animation-script' );
		}
		if (!$swiper_css) {
			wp_enqueue_style( 'swiper-style' );
			wp_enqueue_style( 'animate-style' );
		}

		wp_enqueue_script( 'activation-script' );
		wp_enqueue_style( 'bs-frontend-style' );

		global $product;

		if ( ! $product ) {
			return;
		}
		$args = array(
			'posts_per_page' => 10,
			'columns'        => esc_attr( wc_get_loop_prop( 'columns' ) ),
			'orderby'        => 'rand', // @codingStandardsIgnoreLine.
			'order'          => 'desc',
		);
		// Get visible related products then sort them at random.
		$args['related_products'] = array_filter( array_map( 'wc_get_product', wc_get_related_products( $product->get_id(), $args['posts_per_page'], $product->get_upsell_ids() ) ), 'wc_products_array_filter_visible' );
		// Handle orderby.
		$args['related_products'] = wc_products_array_orderby( $args['related_products'], $args['orderby'], $args['order'] );
		// Set global loop values.
		wc_set_loop_prop( 'name', 'related' );
		wc_set_loop_prop( 'columns', apply_filters( 'woocommerce_related_products_columns', $args['columns'] ) );
		extract($args);
		$total = count($related_products);
		if ( $related_products ) : ?>
			<section class="related products">
				<?php
				$heading = apply_filters( 'woocommerce_product_related_products_heading', __( 'Related products here', 'woocommerce' ) );
				$column = esc_attr( wc_get_loop_prop( 'columns' ) ) ;
				if ( $heading ) :
					?>
					<h2><?php echo esc_html( $heading ); ?></h2>
				<?php endif; ?>
				<div class="related_product swiper-container" data-slidesPerView="<?php echo esc_attr($column);?>">
					<?php 
						$loop_start = '<ul class="swiper-wrapper products columns-'.esc_attr($column).'">';
						echo $loop_start = apply_filters( 'woocommerce_product_loop_start', $loop_start );
					?>

						<?php foreach ( $related_products as $related_product ) : ?>

								<?php
								$post_object = get_post( $related_product->get_id() );

								setup_postdata( $GLOBALS['post'] =& $post_object ); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited, Squiz.PHP.DisallowMultipleAssignments.Found

								wc_get_template_part( 'content', 'product' );
								?>

						<?php endforeach; ?>

					<?php woocommerce_product_loop_end(); ?>
					
					<?php if($pagination){ ?>
						<?php if($total > $column){ ?>
						    <!-- Add Pagination -->
						    <div class="swiper-pagination"></div>
						<?php } ?>
					<?php } ?>

					<?php if($arrow){ ?>
						<!-- Slider Navigation -->
						<div class="swiper-arrow next slide swiper-btn-next"></div>
						<div class="swiper-arrow prev slide swiper-btn-prev"></div>
					<?php  } ?>
					

				 </div>

			</section>
			<?php
		endif;

		wp_reset_postdata();


	}



}