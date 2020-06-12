<?php
namespace Basic\Slider;

/**
 * The admin class
 */
class Admin {
	
	function __construct(){
		// add_action('admin_menu', [$this,'bs_slider_register_ref_page']);
	}

	function get_all_image_sizes() {
	        global $_wp_additional_image_sizes;
	        $sizes = array();
	        $rSizes = array();
	        foreach (get_intermediate_image_sizes() as $s) {
	            $sizes[$s] = array(0, 0);
	            if (in_array($s, array('thumbnail', 'medium', 'medium_large', 'large'))) {
	                $sizes[$s][0] = get_option($s . '_size_w');
	                $sizes[$s][1] = get_option($s . '_size_h');
	            }else {
	                if (isset($_wp_additional_image_sizes) && isset($_wp_additional_image_sizes[$s]))
	                    $sizes[$s] = array($_wp_additional_image_sizes[$s]['width'], $_wp_additional_image_sizes[$s]['height'],);
	            }
	        }
	        foreach ($sizes as $size => $atts) {
	            $rSizes[$size] = $size . ' ' . implode('x', $atts);
	        }
	        return $rSizes;
	}


}