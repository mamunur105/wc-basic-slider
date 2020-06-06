<?php
namespace Basic\Slider;

use Carbon_Fields\Container;
use Carbon_Fields\Field;

class Options{
	
	function __construct(){
		add_action( 'after_setup_theme',[ $this,'carbon_fields_boot_plugin' ],99);
		add_action( 'carbon_fields_register_fields', [ $this,'bs_slider_attach_post_meta' ]);
	}

	function carbon_fields_boot_plugin(){
		// var_dump(class_exists('\Carbon_Fields\Carbon_Fields'));
		if (!class_exists('\Carbon_Fields\Carbon_Fields')) {
			require_once( BS_PATH. '/lib/carbon-fields/vendor/autoload.php' ); 
		}
		\Carbon_Fields\Carbon_Fields::boot(); 
		// require_once BS_PATH.'/includes/carbonbox.php'; 
	}

	// function 
	function bs_slider_attach_post_meta(){

	    Container::make( 'post_meta', __( 'Slider option' ) )
	        ->where( 'post_type', '=', 'bs_slider' )
	        ->add_fields( array(
	            Field::make( 'select', 'select_slider_type', __( 'Choose slider type' ) )
				    ->set_options( array(
				        'main_slider' => __('Main Slider','bs-slider'),
				        'category_slider' => __('Woocommerce Category','bs-slider'),
				        'releted_product' => __('Related Product','bs-slider'),
				        'upsell_product' => __('Upsell Product','bs-slider'),
				    ) ),

			    Field::make( 'complex', 'models', 'Models' )
				    ->set_conditional_logic( array(
				        'relation' => 'AND', // Optional, defaults to "AND"
				        array(
				            'field' => 'select_slider_type',
				            'value' => 'main_slider', // Optional, defaults to "". 
				            'compare' => '=', // Optional, defaults to "=". Available operators: =, <, >, <=, >=, IN, NOT IN
				        )
				    ) )
		            ->add_fields( array(
		                Field::make( 'image', 'main_slider_image', __( 'Slider Image' ) ),
		                Field::make( 'complex', 'slider_title', __( 'Add slider title' ) )
		                ->set_layout( 'tabbed-vertical' )
						    ->add_fields( array(
						        Field::make( 'text', 'main_slider_title', __( '' ) )
						        ->set_help_text( 'Enter text here' ),

						         Field::make( 'select', 'select_slider_animation', __( 'Choose slider Animation' ) )
								    ->set_options( array(
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
						        Field::make( 'text', 'animation_duration', __( 'Animation duration' ) )
						        ->set_help_text( 'Animation duration is second Example: 0.5s' ),

						        
								     
						    ) )

		            ) )

				
	        ) );
	}

}


