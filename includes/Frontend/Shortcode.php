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
		add_shortcode('bs_slider',[$this,'main_slider_shortcode']);
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
	function main_slider_shortcode($atts,$contant){
		extract(shortcode_atts(array(
			'slider_id' => '',
		), $atts));
		if (!$slider_id) {
			return ;
		}
		
		$swiper_js = carbon_get_theme_option( 'deactive_js' );
		$swiper_css = carbon_get_theme_option( 'deactive_css' );
		
		if (!$swiper_js) {
			wp_enqueue_script( 'swiper-slider-script' );
			wp_enqueue_script( 'swiper-animation-script' );
		}
		if (!$swiper_css) {
			wp_enqueue_style( 'swiper-style' );
			wp_enqueue_style( 'animate-style' );
		}

		$result = '';
		ob_start(); 
		// echo $slider_id ;

		$args = array(
			'post_type'  		=> 'bs_slider',
			'posts_per_page'   	=> 1,
			'post__in'			=> array($slider_id),
		);
		$slider_loop = new \WP_Query( $args );
		// echo  $loop->found_posts;
		if ( $slider_loop->have_posts() ) {
			
			while ( $slider_loop->have_posts() ) { $slider_loop->the_post();

				$slider_item = carbon_get_the_post_meta("slider_item"); 
				$show_pagination = carbon_get_the_post_meta("slider_pagination"); 
				$show_arrow = carbon_get_the_post_meta("slider_arrow"); 
				$select_image_size = carbon_get_the_post_meta("select_image_size"); 

				$height_for_min_1200 = carbon_get_the_post_meta("height_for_min_1200"); 
				$height_for_min_992 = carbon_get_the_post_meta("height_for_min_992"); 
				$height_for_min_768 = carbon_get_the_post_meta("height_for_min_768"); 
				$height_for_min_600 = carbon_get_the_post_meta("height_for_min_600"); 
				$height_for_min_320 = carbon_get_the_post_meta("height_for_min_320"); 

				$height_for_min_320 = $height_for_min_320 ? $height_for_min_320 :'500px'; 
				$height_for_min_600 =  $height_for_min_600 ? $height_for_min_600 : $height_for_min_320; 
				$height_for_min_768 =  $height_for_min_768 ? $height_for_min_768 :$height_for_min_600; 
				$height_for_min_992 =  $height_for_min_992 ? $height_for_min_992 :$height_for_min_768; 
				$height_for_min_1200 =  $height_for_min_1200 ? $height_for_min_1200 :$height_for_min_992; 


			?>
				<style>

					/*.bg-img-wrapper .image-placeholder{height:500px}*/
					@media (min-width: 300px) { 
						.primary_slider .slide-inner{<?php echo "height:$height_for_min_320;";?>} 
					}
					@media (min-width: 600px) {
						.primary_slider .slide-inner{<?php echo "height:$height_for_min_600;";?>} 
					}
					@media (min-width: 768px) {
						.primary_slider .slide-inner{<?php echo "height:$height_for_min_768;";?>} 
					}
					@media (min-width: 992px) { 
						.primary_slider .slide-inner{<?php echo "height:$height_for_min_992;";?>} 
					}
					@media (min-width: 1200px) { 
						.primary_slider .slide-inner{<?php echo "height:$height_for_min_1200;";?>;} 
					}

				</style>

			<div class="primary_slider swiper-container slider-type-1 
				<?php echo apply_filters('primary_slider_parent_class', 'slider-wrapper-class' ); ?>">
				<!-- Slides -->
				<div class="swiper-wrapper">
					<?php 
						foreach ($slider_item as $slider) {
							$attachment_id = $slider['main_slider_image'];
							$slider_image = wp_get_attachment_image_src( $attachment_id,$select_image_size);
							$slider_image_url = $slider_image[0];
							$animate_text = $slider['slider_title'] ;

							$image_url = "background-image: url($slider_image_url)";

							
						?>

						<div class="swiper-slide bg-img-wrapper">
							<div class="slide-inner image-placeholder pos-r" style="<?php echo $image_url;?>">
								<div class="slide-content <?php echo apply_filters('primary_slider_slide_content_parent_class', 'slide-content-test' ); ?> ">
									<?php 
										$item = 1;
										foreach ($animate_text as $slider_text) {
											if (1 == $item) {
												echo "<h1 class='main-title' data-swiper-animation='".esc_attr($slider_text['select_slider_animation'])."' data-duration='".esc_attr($slider_text['animation_duration'])."' data-delay='".esc_attr($slider_text['animation_delay'])."'><span>{$slider_text['main_slider_title']}</span></h1>";
											}else{
												echo "<p class='subtitle' data-swiper-animation='".esc_attr($slider_text['select_slider_animation'])."' data-duration='".esc_attr($slider_text['animation_duration'])."' data-delay='".esc_attr($slider_text['animation_delay'])."'>{$slider_text['main_slider_title']}</p>";
											}	
											$item++;
										} 
									?>
								</div> <!-- end of slide-content -->
							</div> <!-- end of slider-inner -->
						</div> <!-- end of swiper-slide -->

					<?php } ?>
				</div> <!-- end of swiper-slide -->
				<?php if($show_arrow){ ?>
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
			}
		} wp_reset_postdata();

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

		$result = '';
		ob_start(); 
		// echo $slider_id ;
		$args = array(
			'post_type'  		=> 'bs_slider',
			'posts_per_page'   	=> 1,
			'post__in'			=> array($slider_id),
		);
		$cat_slider_loop = new \WP_Query( $args );
	
		// echo  $loop->found_posts;
		if ( $cat_slider_loop->have_posts() ) {
			while ( $cat_slider_loop->have_posts() ) {  $cat_slider_loop->the_post(); 
				$category_slider = carbon_get_the_post_meta("category_slider");
				$show_pagination = carbon_get_the_post_meta("slider_pagination");
				$button_text = carbon_get_the_post_meta("category_button_text"); 
				$show_arrow = carbon_get_the_post_meta("slider_arrow"); 
				$category_layout = carbon_get_the_post_meta("category_layout");
				$category_slidesPerView = carbon_get_the_post_meta("select_perview");
				$content_position = carbon_get_the_post_meta("category_content_position");
				$hide_title = carbon_get_the_post_meta("hide_title");
				$hide_button = carbon_get_the_post_meta("hide_button");
				$select_image_size = carbon_get_the_post_meta("select_image_size"); 
 				$classes = [] ;
				if ($show_pagination) {
					$classes[] = 'cat-slider-pagination'; 
				}
				if ($show_arrow) {
					$classes[] = 'cat-slider-arrow'; 
				}
				if ('slider' == $category_layout) {
					$classes[] = 'category_slider_1'; 	
				}
				if ('grid' == $category_layout) {
					$classes[] = 'category_slider_2'; 	
				}
		
				$class = implode(' ',$classes);
				?>
				
					<div class="<?php echo esc_attr($class); ?> swiper-container content-align " data-slidesPerView="<?php echo esc_attr($category_slidesPerView); ?>"  >

						<div class="swiper-wrapper">
							<?php 
								foreach ($category_slider as $value) { 
									if (!$value['select_category']) {
										continue;
									}
									$term = get_term_by('slug', $value['select_category'], 'product_cat'); 
									$categoryname = $term->name;
									$category_link = get_category_link( $term->term_id );
									$thumbnail_id = get_term_meta( $term->term_id, 'thumbnail_id', true );
		    						$category_image = wp_get_attachment_image_src( $thumbnail_id, $select_image_size);;
									// $category_image = "";
									if ($value['category_image']) {
										$category_image = $value['category_image'];
										$category_image = wp_get_attachment_image_src( $category_image, $select_image_size);
										$category_image = $category_image[0];
									}

									?>

									<div class="swiper-slide <?php  echo esc_attr($content_position).' ';  echo apply_filters('categpry_slider', 'slider_content_class' );?>">
										<a class="category_image" href="<?php echo esc_attr($category_link); ?>">
											<img src="<?php echo esc_url($category_image) ; ?>" alt="<?php echo esc_attr($categoryname);?>">
										</a>

										<div class="cat-slide-content">
											<?php if(!$hide_title){?>
												<div class="name"><?php echo $categoryname;?></div>
											<?php } ?>
											<?php if(!$hide_button){?>

											<div class="cat-buttno">
												<a href="<?php echo $category_link; ?>">
												<?php echo $button_text;?></a>
											</div>
											<?php } ?>

										</div>
									</div>
								
								<?php  }
							?>
						</div>

						<?php if($show_arrow){ ?>
							<!-- Slider Navigation -->
							<div class="swiper-arrow next swiper-btn-next"></div>
							<div class="swiper-arrow prev swiper-btn-prev"></div>
						<?php } ?>
						
						<?php if($show_pagination){ ?>
							<!-- Slider Pagination -->
							<div class="swiper-pagination"></div>
						<?php } ?>

					</div>
				<?php

			}
		} wp_reset_postdata();


		$swiper_js = carbon_get_theme_option( 'deactive_js' );
		$swiper_css = carbon_get_theme_option( 'deactive_css' );
		
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

		$result .= ob_get_clean();
		return $result;

	}

}