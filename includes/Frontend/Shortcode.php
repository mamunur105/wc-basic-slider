<?php

namespace Basic\Slider\Frontend;

/**
 * Shortcode handaler class 
 */
class Shortcode 
{
	/**
	 * Initilize the class 
	 */
	function __construct(){
		add_shortcode('bs_slider',[$this,'random_shortcode']);
	}
	/**
	 * Shortcode handles class
	 *
	 * @param array $atts
	 * @param string $content
	 *
	 * @return string 
	 */
	function random_shortcode($attr,$contant){
		extract(shortcode_atts(array(
			'slider_id' => ''
		), $atts));
		// if (!$slider_id) {
		// 	return ;
		// }
		wp_enqueue_script( 'swiper-slider-script' );
		wp_enqueue_script( 'swiper-animation-script' );
		wp_enqueue_script( 'activation-script' );
		wp_enqueue_style( 'swiper-style' );
		wp_enqueue_style( 'animate-style' );
		wp_enqueue_style( 'bs-frontend-style' );

		$result = '';
		ob_start(); 


		?>
	
		<div class="primary_slider swiper-container slider-type-1">
			<!-- Slides -->
			<div class="swiper-wrapper">
			<?php
				$args = array(
					'post_type'  		=> 'bs_slider',
					'posts_per_page'   	=> 1,
					'post__in'			=> $slider_id,
				);
				$loop = new \WP_Query( $args );
				if ( $loop->have_posts() ) {
			?>
					<div class="swiper-slide bg-img-wrapper">
						<div class="slide-inner image-placeholder pos-r" style="height:500px;background-image: url(http://product.test/wp-content/uploads/2020/06/cotton-french-terry-close-up-min.jpg);">
							
							<div class="slide-content ">
								<h1 class="main-title  " data-swiper-animation="slideInLeft" data-duration=".5s" ><span>Specialist in Knitted Fabric</span></h1>
								<p class="subtitle" data-swiper-animation="fadeIn" data-duration=".5s" data-delay="1s">Lorem Ipsum is simply dummy text of the printing and typesetting industry. </p>
								<p class="subtitle" data-swiper-animation="fadeInUp" data-duration=".5s" data-delay="1.5s"> <a class="more-link" href="#">Read more</a> </p>
								
							</div> <!-- end of slide-content -->
				
						</div> <!-- end of slider-inner -->
					</div> <!-- end of swiper-slide -->
			<?php 
				}
				wp_reset_postdata();
			?>
			</div> <!-- end of swiper-slide -->

			<!-- Slider Navigation -->
			<div class="swiper-arrow next slide swiper-btn-next"><i class="fa fa-angle-right"></i></div>
			<div class="swiper-arrow prev slide swiper-btn-prev"><i class="fa fa-angle-left"></i></div>

			<!-- Slider Pagination -->
			<div class="swiper-pagination"></div>

		</div>

		<?php
		$result .= ob_get_clean();
		return $result;
	}
}