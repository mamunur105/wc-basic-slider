<?php

use Carbon_Fields\Container;
use Carbon_Fields\Field;

function crb_load() {

    if (!class_exists('\Carbon_Fields\Carbon_Fields')) {
		require_once( BS_PATH. '/lib/carbon-fields/vendor/autoload.php' ); 
	}
    \Carbon_Fields\Carbon_Fields::boot();
}


// print_r(_get_all_image_sizes());
// function 
function bs_slider_attach_post_meta(){

	$admin = new \Basic\Slider\Admin();

	global $wpdb;
	
	$categories = $wpdb->get_results(
		"SELECT ter.name ,ter.slug ,tax.count
		FROM {$wpdb->term_taxonomy} AS tax,{$wpdb->terms} AS ter 
		WHERE tax.taxonomy = 'product_cat' 
		AND ter.term_id = tax.term_id 
		AND tax.count > 0
		");

	$category_list = [];
	$category_list[''] = __('--Select One--','bs-slider');

    // $categories = get_terms( 'product_cat', 'orderby=name&hide_empty=0' );
    if ( $categories ) {
        foreach ( $categories as $cat ) {
        	$category_name = $cat->name.' ('.$cat->count.')' ;
            $category_list[$cat->slug] = esc_html( $category_name );
        }
    }

    Container::make( 'post_meta', __( 'Slider option' ) )
        ->where( 'post_type', '=', 'bs_slider' )
        ->add_fields( array(
        	Field::make( 'checkbox', 'slider_pagination', __( 'Show Pagination' ) )->set_option_value( 'yes' ),
	        Field::make( 'checkbox', 'slider_arrow', __( 'Show Arrow' ) )->set_option_value( 'yes' ),
            Field::make( 'select', 'select_slider_type', __( 'Choose slider type' ) )
			    ->set_options( array(
			        'main_slider' => __('Main Slider','bs-slider'),
			        'category_slider' => __('Woocommerce Category','bs-slider'),
			    ) ),
			Field::make( 'select', 'select_image_size', __( 'Choose Image size' ) )
			    ->set_options( 
			    	$admin->get_all_image_sizes()
			    ),

		    Field::make( 'complex', 'slider_item', 'Add Slider Items' )
		    	->set_layout( 'tabbed-vertical' )
			    ->set_conditional_logic( array(
			        'relation' => 'AND', 
			        array(
			            'field' => 'select_slider_type',
			            'value' => 'main_slider',  
			            'compare' => '=', 
			        )
			    ) )
	            ->add_fields( array(
	                Field::make( 'image', 'main_slider_image', __( 'Slider Image' ) )
	                ->set_required( true ),
	                Field::make( 'complex', 'slider_title', __( 'Add more content ' ) )
	                ->set_layout( 'tabbed-vertical' )
				    ->add_fields( array(
				        Field::make( 'textarea', 'main_slider_title', __( 'Slide Content' ) )
				        	->set_help_text( 'Enter text here' ),
				        Field::make( 'text', 'animation_duration', __( 'Animation duration' ) )
				        	->set_help_text( 'Animation duration Example: 0.5s' ),
				        Field::make( 'text', 'animation_delay', __( 'Animation delay' ) )
				        	->set_help_text( 'Animation delay Example: 0.5s' ),
						Field::make( 'select', 'select_slider_animation', __( 'Choose slider Animation' ) )
						    ->set_options( array(
								'none'=> '--Select One--' ,
								'bounce'=> 'bounce' ,
								'flash'=> 'flash' ,
								'pulse'=> 'pulse' ,
								'rubberBand'=> 'rubberBand' ,
								'shakeX'=> 'shakeX' ,
								'shakeY'=> 'shakeY' ,
								'headShake'=> 'headShake' ,
								'swing'=> 'swing' ,
								'tada'=> 'tada' ,
								'wobble'=> 'wobble' ,
								'jello'=> 'jello' ,
								'heartBeat'=> 'heartBeat' ,
								'backInDown'=> 'backInDown' ,
								'backInLeft'=> 'backInLeft' ,
								'backInRight'=> 'backInRight' ,
								'backInUp'=> 'backInUp' ,
								'backOutDown'=> 'backOutDown' ,
								'backOutLeft'=> 'backOutLeft' ,
								'backOutRight'=> 'backOutRight' ,
								'backOutUp'=> 'backOutUp' ,
								'bounceIn'=> 'bounceIn' ,
								'bounceInDown'=> 'bounceInDown' ,
								'bounceInLeft' => 'bounceInLeft' ,
								'bounceInRight' => 'bounceInRight' ,
								'bounceInUp' => 'bounceInUp' ,
								'bounceOut' => 'bounceOut' ,
								'bounceOutDown' => 'bounceOutDown' ,
								'bounceOutLeft' => 'bounceOutLeft' ,
								'bounceOutRight' => 'bounceOutRight' ,
								'bounceOutUp' => 'bounceOutUp' ,
								'fadeIn' => 'fadeIn' ,
								'fadeInDown' => 'fadeInDown' ,
								'fadeInDownBig' => 'fadeInDownBig' ,
								'fadeInLeft' => 'fadeInLeft' ,
								'fadeInLeftBig' => 'fadeInLeftBig' ,
								'fadeInRight' => 'fadeInRight' ,
								'fadeInRightBig' => 'fadeInRightBig' ,
								'fadeInUp' => 'fadeInUp' ,
								'fadeInUpBig' => 'fadeInUpBig' ,
								'fadeInTopLeft' => 'fadeInTopLeft' ,
								'fadeInTopRight' => 'fadeInTopRight' ,
								'fadeInBottomLeft' => 'fadeInBottomLeft' ,
								'fadeInBottomRight' => 'fadeInBottomRight' ,
								'fadeOut' => 'fadeOut' ,
								'fadeOutDown' => 'fadeOutDown' ,
								'fadeOutDownBig' => 'fadeOutDownBig' ,
								'fadeOutLeft' => 'fadeOutLeft' ,
								'fadeOutLeftBig' => 'fadeOutLeftBig' ,
								'fadeOutRight' => 'fadeOutRight' ,
								'fadeOutRightBig' => 'fadeOutRightBig' ,
								'fadeOutUp' => 'fadeOutUp' ,
								'fadeOutUpBig' => 'fadeOutUpBig',
								'fadeOutTopLeft' => 'fadeOutTopLeft',
								'fadeOutTopRight' => 'fadeOutTopRight',
								'fadeOutBottomRight' => 'fadeOutBottomRight',
								'fadeOutBottomLeft' => 'fadeOutBottomLeft',
								'flip' => 'flip',
								'flipInX' => 'flipInX',
								'flipInY' => 'flipInY',
								'flipOutX' => 'flipOutX',
								'flipOutY' => 'flipOutY',
								'Lightspeed' => 'Lightspeed',
								'lightSpeedInRight' => 'lightSpeedInRight',
								'lightSpeedInLeft' => 'lightSpeedInLeft',
								'lightSpeedOutRight' => 'lightSpeedOutRight',
								'lightSpeedOutLeft' => 'lightSpeedOutLeft',
								'rotateIn' => 'rotateIn',
								'rotateInDownLeft' => 'rotateInDownLeft',
								'rotateInDownRight' => 'rotateInDownRight',
								'rotateInUpLeft' => 'rotateInUpLeft',
								'rotateInUpRight' => 'rotateInUpRight',
								'rotateOut' => 'rotateOut',
								'rotateOutDownLeft' => 'rotateOutDownLeft',
								'rotateOutDownRight' => 'rotateOutDownRight',
								'rotateOutUpLeft' => 'rotateOutUpLeft',
								'rotateOutUpRight' => 'rotateOutUpRight',
								'hinge' => 'hinge',
								'jackInTheBox' => 'jackInTheBox',
								'rollIn' => 'rollIn',
								'rollOut' => 'rollOut',
								'zoomIn' => 'zoomIn' ,
								'zoomInDown' => 'zoomInDown' ,
								'zoomInLeft' => 'zoomInLeft' ,
								'zoomInRight' => 'zoomInRight' ,
								'zoomInUp' => 'zoomInUp' ,
								'zoomOut' => 'zoomOut' ,
								'zoomOutDown' => 'zoomOutDown' ,
								'zoomOutLeft' => 'zoomOutLeft' ,
								'zoomOutRight' => 'zoomOutRight' ,
								'zoomOutUp' => 'zoomOutUp' ,
								'slideInDown' => 'slideInDown' ,
								'slideInLeft' => 'slideInLeft' ,
								'slideInRight' => 'slideInRight' ,
								'slideInUp' => 'slideInUp' ,
								'slideOutDown' => 'slideOutDown' ,
								'slideOutLeft' => 'slideOutLeft' ,
								'slideOutRight' => 'slideOutRight' ,
								'slideOutUp' => 'slideOutUp' ,
							) ),
				        
				    ) )

	            ) ),

	    	Field::make( 'radio_image', 'category_layout', 'Select Layout' )
		    	->set_conditional_logic( array(
			        'relation' => 'AND', 
			        array(
			            'field' => 'select_slider_type',
			            'value' => 'category_slider',
			            'compare' => '='
			        )
			    ) )
			    ->add_options( array(
			        'slider' => BS_ASSETS.'/image/slider.png',
			        'grid' => BS_ASSETS.'/image/grid.png',
			    ) )->set_required( true ),
	    	Field::make( 'radio_image', 'category_content_position', 'Content Posotion' )
		    	->set_conditional_logic( array(
			        'relation' => 'AND', 
			        array(
			            'field' => 'select_slider_type',
			            'value' => 'category_slider',
			            'compare' => '='
			        )
			    ) )
			    ->add_options( array(
			        'below-content' => BS_ASSETS.'/image/below-content.png',
			        'overlay-content' => BS_ASSETS.'/image/overlay-content.png',
			    ) )->set_required( true ),
			
			Field::make( 'select', 'select_perview', __( 'Choose slider perview' ) )
				->set_conditional_logic( array(
			        'relation' => 'AND', 
			        array(
			            'field' => 'select_slider_type',
			            'value' => 'category_slider',
			            'compare' => '='
			        )
			    ) )
			    ->set_options( array(
			        '3' => __('3 Items','bs-slider'),
			        '4' => __('4 Items','bs-slider'),
			        '5' => __('5 Items','bs-slider'),
			        '6' => __('6 Items','bs-slider'),
			    ) ),			
			Field::make( 'checkbox', 'hide_title', __( 'Hide Title' ) )
				->set_conditional_logic( array(
			        'relation' => 'AND', 
			        array(
			            'field' => 'select_slider_type',
			            'value' => 'category_slider',
			            'compare' => '='
			        )
			    ) )->set_option_value( 'yes' ),
			Field::make( 'checkbox', 'hide_button', __( 'Hide Button' ) )
				->set_conditional_logic( array(
			        'relation' => 'AND', 
			        array(
			            'field' => 'select_slider_type',
			            'value' => 'category_slider',
			            'compare' => '='
			        )
			    ) )->set_option_value( 'yes' ),
			Field::make( 'text', 'category_button_text', __( 'Button Text' ) )
		        ->set_conditional_logic( array(
			        'relation' => 'AND', 
			        array(
			            'field' => 'select_slider_type',
			            'value' => 'category_slider', 
			            'compare' => '='
			        )
			    ) )->set_help_text( 'Leave empty for default image' ) ,
		       

			Field::make( 'complex', 'category_slider', __( 'Category slider' ) )
				->set_layout( 'tabbed-vertical' )
				->set_conditional_logic( array(
			        'relation' => 'AND', 
			        array(
			            'field' => 'select_slider_type',
			            'value' => 'category_slider', 
			            'compare' => '='
			        )
			    ) )
			    ->add_fields( array(
			    	
			        Field::make( 'select', 'select_category', __( 'Choose One Category' ) )
					    ->set_options( $category_list )
			        	->set_help_text( 'Note: Empty category are hidden' ) ,
			        Field::make( 'image', 'category_image', __( 'Category Image' ) )
				        ->set_conditional_logic( array(
				        'relation' => 'AND', 
				        array(
				            'field' => 'select_category',
				            'value' => '', 
				            'compare' => '!='
				        )
				    ) )->set_help_text( 'Leave empty for default image' ) ,
			       
			        // Field::make( 'text', 'category_custom_url', __( 'Category Custom URL' ) )
			        // 	->set_help_text( 'Leave empty for default category archive page' ),
			    ) ),

			
        ) );
}

function bs_slider_settings(){
	Container::make( 'theme_options', __( 'Settings', 'bs-slider' ) )
	    ->set_page_parent( 'edit.php?post_type=bs_slider' )
	    ->add_fields( array(

	        Field::make( 'checkbox', 'deactive_css', __( 'Deactive Swiper CSS if already included', 'bs-slider' ) )->set_help_text( 'Don\'t deactive if Swiper css is not previously included.' ),
	        Field::make( 'checkbox', 'deactive_js', __( 'Deactive Swiper Js if included', 'bs-slider' ) )->set_help_text( 'Don\'t deactive if Swiper js is not previously included.' ),
	        // Field::make( 'separator', 'crb_style_options', 'Style' ),
	        Field::make( 'checkbox', 'related_product_slider', __( 'Related product slider', 'bs-slider' ) )->set_help_text( 'Visit Product page and see the change.' ),


	        Field::make( 'checkbox', 'related_product_pagination', __( 'Show Pagination' ) )
	        	->set_conditional_logic( array(
			        'relation' => 'AND', 
			        array(
			            'field' => 'related_product_slider',
			            'value' => true  
			        )
			    ) )
	        	->set_option_value( 'yes' ),
	        Field::make( 'checkbox', 'related_product_arrow', __( 'Show Arrow' ) )
	        	->set_conditional_logic( array(
			        'relation' => 'AND', 
			        array(
			            'field' => 'related_product_slider',
			            'value' => true  
			        )
			    ) )
	        	->set_option_value( 'yes' ),


	      //   Field::make( 'checkbox', 'upsel_product_slider', __( 'Upsel product slider', 'bs-slider' ) 
	    		// )->set_help_text( 'Visit Product page and see the change.' ),
	        Field::make( 'html', 'bs_slider_pro' )
    			->set_html( '<p>For more customization please <a href="mailto:rmamunur105@gmail.com"> contact here. </a>If you like  Wc Basic Slider please leave us a rating <a href="https://profiles.wordpress.org/mamunur105/#content-plugins"> ★★★★★ </a>. Your Review is very important to us as it helps us to grow more.</p><p>And you can create <a href="https://github.com/mamunur105/basic-slider/issues" target="_blank"> issues here. </a></p>' ),

	    ) );
	Container::make( 'theme_options', __( 'PRO', 'bs-slider' ) )
	    ->set_page_parent( 'edit.php?post_type=bs_slider' )
	    ->add_fields( array(
	        Field::make( 'separator', 'crb_style_options', 'Pro Services' ),
	        Field::make( 'html', 'bs_slider_pro' )
    			->set_html( '<p>For more customization please <a href="mailto:rmamunur105@gmail.com"> contact here. </a>If you like  Wc Basic Slider please leave us a rating <a href="https://profiles.wordpress.org/mamunur105/#content-plugins"> ★★★★★ </a>. Your Review is very important to us as it helps us to grow more.</p><p>And you can create <a href="https://github.com/mamunur105/basic-slider/issues" target="_blank"> issues here. </a></p>' ),

	    ) );

}

