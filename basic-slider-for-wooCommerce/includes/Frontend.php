<?php
namespace Basic\Slider;

/**
 * 
 */
class Frontend
{
	
	function __construct(){
		new Frontend\Shortcode();
		new Frontend\ProductSlider();
		
	}
}