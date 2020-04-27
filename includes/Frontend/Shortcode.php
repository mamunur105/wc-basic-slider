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

        return '<div class="academy-shortcode">Hello from Shortcode</div>';
	}
}