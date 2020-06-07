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
	function random_shortcode($atts,$contant){
		extract(shortcode_atts(array(
			'slider_id' => '',
		), $atts));
		if (!$slider_id) {
			return ;
		}
		wp_enqueue_script( 'swiper-slider-script' );
		wp_enqueue_script( 'swiper-animation-script' );
		wp_enqueue_script( 'activation-script' );
		wp_enqueue_style( 'swiper-style' );
		wp_enqueue_style( 'animate-style' );
		wp_enqueue_style( 'bs-frontend-style' );

		$result = '';
		ob_start(); 
		// echo $slider_id ;

		?>
	
		<div class="primary_slider swiper-container slider-type-1">
			<!-- Slides -->
			<div class="swiper-wrapper">
			<?php
				$args = array(
					'post_type'  		=> 'bs_slider',
					'posts_per_page'   	=> 1,
					'post__in'			=>array($slider_id),
				);
				$slider_loop = new \WP_Query( $args );
				// echo  $loop->found_posts;
				if ( $slider_loop->have_posts() ) {
					
					while ( $slider_loop->have_posts() ) { 
						$slider_loop->the_post();
						$slider_item = carbon_get_the_post_meta("slider_item"); 
						foreach ($slider_item as $slider) {
							$attachment_id = $slider['main_slider_image'];
							$slider_image = wp_get_attachment_image_src( $attachment_id,'full');
							$slider_image_url = $slider_image[0];

							$animate_text = $slider['slider_title'] ;
							$item = 1;
							$title_content = "";
							foreach ($animate_text as $slider_text) {
								
								if (1 == $item) {
									$title_content .= "<h1 class='main-title' data-swiper-animation='{$slider_text['select_slider_animation']}' data-duration='{$slider_text['animation_duration']}'><span>{$slider_text['main_slider_title']}</span></h1>";
								}else{
									$title_content .= "<p class='subtitle' data-swiper-animation='{$slider_text['select_slider_animation']}' data-duration='{$slider_text['animation_duration']}' data-delay='1s'>{$slider_text['main_slider_title']}</p>";
								}
								
								$item++;
							}
							
						?>
							<div class="swiper-slide bg-img-wrapper">
								<div class="slide-inner image-placeholder pos-r" style="height:500px;background-image: url(<?php echo $slider_image_url ; ?>);">
									
									<div class="slide-content ">
										<?php echo $title_content ; ?>
									</div> <!-- end of slide-content -->
						
								</div> <!-- end of slider-inner -->
							</div> <!-- end of swiper-slide -->
						<?php }

					}
				} wp_reset_postdata();
			?>
			</div> <!-- end of swiper-slide -->

			<!-- Slider Navigation -->
			<div class="swiper-arrow next slide swiper-btn-next"></div>
			<div class="swiper-arrow prev slide swiper-btn-prev"></div>

			<!-- Slider Pagination -->
			<div class="swiper-pagination"></div>

		</div>

		<?php
		$result .= ob_get_clean();
		return $result;
	}
}