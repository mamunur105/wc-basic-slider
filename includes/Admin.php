<?php
namespace Basic\Slider;

/**
 * The admin class
 */
class Admin {
	
	function __construct(){
		new Admin\BSCpt(); 
	}

	function dispatch_action($addressbook){
		// add_action('admin_init',[$addressbook,'form_handaler']);
		// add_action( 'admin_post_wd-ac-delete-address', [ $addressbook, 'delete_address' ] );
	}
}