<?php
/**
 * Plugin Name:       Basic slider
 * Plugin URI:        https://wordpress.org/plugins/basic-slider
 * Description:       This is basic slider 
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
		add_action('plugin_loaded',[ $this,'init_plugin' ]);
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


}

function basic_slider(){
	return BS_Slider::init();
}

basic_slider();

