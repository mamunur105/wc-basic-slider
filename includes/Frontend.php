<?php
namespace BasicSliderForWooCommerce;

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