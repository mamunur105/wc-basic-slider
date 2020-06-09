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
		add_shortcode('woocategory_slider',[$this,'woocategory_slider']); 
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
	
		<div class="primary_slider swiper-container slider-type-1 
			<?php echo apply_filters('primary_slider_parent_class', 'slider-wrapper-class' ); ?>">
			<!-- Slides -->
			<div class="swiper-wrapper">
			<?php
				$args = array(
					'post_type'  		=> 'bs_slider',
					'posts_per_page'   	=> 1,
					'post__in'			=> array($slider_id),
				);
				$slider_loop = new \WP_Query( $args );
				$show_pagination = 0 ;
				$show_arrow = 0 ;
				// echo  $loop->found_posts;
				if ( $slider_loop->have_posts() ) {
					
					while ( $slider_loop->have_posts() ) { 
						$slider_loop->the_post();
						$slider_item = carbon_get_the_post_meta("slider_item"); 
						$show_pagination = carbon_get_the_post_meta("slider_pagination"); 
						$show_arrow = carbon_get_the_post_meta("slider_arrow"); 

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
									
									<div class="slide-content <?php echo apply_filters('primary_slider_slide_content_parent_class', 'slide-content-test' ); ?> ">
										<?php echo $title_content ; ?>
									</div> <!-- end of slide-content -->
						
								</div> <!-- end of slider-inner -->
							</div> <!-- end of swiper-slide -->
						<?php }

					}
				} wp_reset_postdata();
			?>
			</div> <!-- end of swiper-slide -->
			<?php if($show_arrow){?>
			<!-- Slider Navigation -->
			<div class="swiper-arrow next slide swiper-btn-next"></div>
			<div class="swiper-arrow prev slide swiper-btn-prev"></div>
			<?php } ?>
			
			<?php if($show_pagination){ ?>
				<!-- Slider Pagination -->
				<div class="swiper-pagination"></div>
			<?php } ?>

		</div>

		<?php
		$result .= ob_get_clean();
		return $result;
	}
	// woocommearce shortcode handler 
	function woocategory_slider($atts,$contant){
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
		<!-- Swiper -->
		<div class="cat-slider-pagination swiper-container <?php echo apply_filters('category_slider_activation_class', 'category_slider_1' ); ?>" >

			<div class="swiper-wrapper">
				<div class="swiper-slide">
					<img src="/wp-content/uploads/2020/06/hoodie-2.jpg" alt="">
					<div class="cat-slide-content">
						<div class="name">Lorem ipsum dolor</div>
						<div class="cat-buttno"><a href="#">Shop now</a></div>
					</div>
				</div>
				<div class="swiper-slide">
					<img src="/wp-content/uploads/2020/06/hoodie-2.jpg" alt="">
					<div class="cat-slide-content">
						<div class="name">Lorem ipsum dolor</div>
						<div class="cat-buttno"><a href="#">Shop now</a></div>
					</div>
				</div>
				<div class="swiper-slide">
					<img src="/wp-content/uploads/2020/06/hoodie-2.jpg" alt="">
					<div class="cat-slide-content">
						<div class="name">Lorem ipsum dolor</div>
						<div class="cat-buttno"><a href="#">Shop now</a></div>
					</div>
				</div>
				<div class="swiper-slide">
					<img src="/wp-content/uploads/2020/06/hoodie-2.jpg" alt="">
					<div class="cat-slide-content">
						<div class="name">Lorem ipsum dolor</div>
						<div class="cat-buttno"><a href="#">Shop now</a></div>
					</div>
				</div>
				<div class="swiper-slide">
					<img src="/wp-content/uploads/2020/06/hoodie-2.jpg" alt="">
					<div class="cat-slide-content">
						<div class="name">Lorem ipsum dolor</div>
						<div class="cat-buttno"><a href="#">Shop now</a></div>
					</div>
				</div>
				<div class="swiper-slide">
					<img src="/wp-content/uploads/2020/06/hoodie-2.jpg" alt="">
					<div class="cat-slide-content">
						<div class="name">Lorem ipsum dolor</div>
						<div class="cat-buttno"><a href="#">Shop now</a></div>
					</div>
				</div>
				<div class="swiper-slide">
					<img src="/wp-content/uploads/2020/06/hoodie-2.jpg" alt="">
					<div class="cat-slide-content">
						<div class="name">Lorem ipsum dolor</div>
						<div class="cat-buttno"><a href="#">Shop now</a></div>
					</div>
				</div>
				<div class="swiper-slide">
					<img src="/wp-content/uploads/2020/06/hoodie-2.jpg" alt="">
					<div class="cat-slide-content">
						<div class="name">Lorem ipsum dolor</div>
						<div class="cat-buttno"><a href="#">Shop now</a></div>
					</div>
				</div>
				<div class="swiper-slide">
					<img src="/wp-content/uploads/2020/06/hoodie-2.jpg" alt="">
					<div class="cat-slide-content">
						<div class="name">Lorem ipsum dolor</div>
						<div class="cat-buttno"><a href="#">Shop now</a></div>
					</div>
				</div>
				
				
				
			</div>
			<!-- Add Pagination -->
			<div class="swiper-pagination"></div>
		</div>
		<?php
		$result .= ob_get_clean();
		return $result;

	}
}