<?php
namespace Basic\Slider;

/**
 * The admin class
 */
class Admin {
	
	function __construct(){
		// add_action('admin_menu', [$this,'bs_slider_register_ref_page']);
	}

	/**
	 * Adds a submenu page under a custom post type parent.
	 */
	function bs_slider_register_ref_page() {
	    add_submenu_page(
	        'edit.php?post_type=bs_slider',
	        __( 'Settings', 'bs-slider' ),
	        __( 'Settings', 'bs-slider' ),
	        'manage_options',
	        'bs-settings',
	        array($this,'bs_slider_ref_page_callback')
	    );
	}
 
	/**
	 * Display callback for the submenu page.
	 */
	function bs_slider_ref_page_callback() {

		
	}


}