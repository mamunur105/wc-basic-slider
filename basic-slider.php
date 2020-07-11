<?php
/**
 * Plugin Name:       Wc Basic Slider
 * Plugin URI:        https://wordpress.org/plugins/wc-basic-slider
 * Description:       This is for woocommerce Category,Related product, And also For Promotional basic slider. 
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Mamunur rashid
 * Author URI:        https://profiles.wordpress.org/mamunur105
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       bs-slider
 * Domain Path:       /languages
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// use Carbon_Fields;
require_once __DIR__.'/vendor/autoload.php';  

final class BS_Slider{

   /**
	* Plugin version 
	*/
	const version = '1.0.0';

	/**
	 * class constructr 
	 *
	 */
	private function __construct(){

		$this->define_constant();
		new Basic\Slider\BSCpt(); 
		// new Basic\Slider\BsOptions();
		if (is_admin()) {
			new Basic\Slider\Admin();	
		}

		register_activation_hook(__FILE__,[ $this,'activate' ]);
		add_action('init',[ $this,'init_plugin' ]);
		add_action( 'plugins_loaded', [ $this , 'load_textdomain'] );
		add_action( 'after_setup_theme', 'crb_load',99 );
		add_action( 'carbon_fields_register_fields','bs_slider_attach_post_meta' );
		add_action( 'carbon_fields_register_fields','bs_slider_settings' );
		add_action( 'after_setup_theme', [$this,'after_setup_theme']);

		add_action( 'admin_notices', [$this,'bs_slider_notice_message'] );
		// add_filter('','<');

	}

  	function load_textdomain() {
		load_plugin_textdomain( 'bs-slider', false, plugin_dir_path( __FILE__ ) . "languages" );
	}

	function after_setup_theme(){
		add_image_size( 'custom-size', 220, 180, true );
	}
	/**
	 * initilize a singleton instance
	 * @return \WD_ac
	 */
	public static function init(){
		static $instance = false;
		if (!$instance) {
			$instance = new self();
		}
		return $instance;
	}

	/**
	 *  Requred constant
	 * @return \WD_ac
	 */
	public function define_constant(){
		define('BS_VERSION', self::version);
		define('BS_FILE', __FILE__);
		define('BS_PATH', __DIR__);
		define('BS_URL', plugins_url('',BS_FILE));
		define('BS_ASSETS', BS_URL.'/assets');
	
	}

	/**
	 *  Do stuff upon activation
	 * @return 
	 */
	public function activate(){ }

	public function init_plugin(){ 
		new Basic\Slider\Assets(); 

		if (!is_admin()) {
			new Basic\Slider\Frontend();	 
		}
		
	}

	public function bs_slider_notice_message( $type ) {
		if ( !class_exists( 'woocommerce' ) ) {
			echo '<div class="updated notice is-dismissible notice-sp-wcsp-woo"><p>';
			echo __( 'Please active WooCommerce plugin to make the <b>Category Slider for WooCommerce</b>.', 'bs-slider' );
			echo '</p></div>';
		}
	}



}

function basic_slider(){
	return BS_Slider::init();
}

basic_slider();

