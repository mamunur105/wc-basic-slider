<?php
/**
 * The plugin bootstrap file
 *
 * @link              https://wordpress.org/plugins/wc-basic-slider
 * @since             1.0.3
 * @package           BSFW_Slider
 *
 * @wordpress-plugin
 * Plugin Name:       WooCommerce Category Slider
 * Plugin URI:        https://wordpress.org/plugins/wc-basic-slider
 * Description:       This is for woocommerce Category,Related product, And also For Promotional slider.
 * Version:           1.0.2
 * Requires at least: 5.0
 * Requires PHP:      7.0
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

/**
 * Autoload all file
 */
require_once __DIR__ . '/vendor/autoload.php';
/**
 * Plugin main class
 */
final class BSFW_Slider {

	/**
	 * Plugin version
	 *
	 * @var   string
	 */
	public const VERSION = '1.0.1';

	/**
	 * Constructr
	 */
	private function __construct() {

		$this->define_constant();
		new BasicSliderForWooCommerce\BSCpt();
		if ( is_admin() ) {
			new BasicSliderForWooCommerce\Admin();
		}
		register_activation_hook( __FILE__, array( $this, 'activate' ) );
		add_action( 'init', array( $this, 'init_plugin' ) );
		add_action( 'plugins_loaded', array( $this, 'load_textdomain' ) );
		add_action( 'after_setup_theme', 'bsfw_crb_load', 99 );
		add_action( 'carbon_fields_register_fields', 'bsfw_slider_attach_post_meta' );
		add_action( 'carbon_fields_register_fields', 'bsfw_slider_settings' );
		add_action( 'after_setup_theme', array( $this, 'after_setup_theme' ) );
		add_action( 'admin_notices', array( $this, 'bs_slider_notice_message' ) );
	}
	/**
	 * Lode textdomain
	 *
	 * @return void
	 */
	public function load_textdomain() {
		load_plugin_textdomain( 'bs-slider', false, plugin_dir_path( __FILE__ ) . 'languages' );
	}
	/**
	 * Undocumented function
	 *
	 * @return void
	 */
	public function after_setup_theme() {
		add_image_size( 'custom-size', 220, 180, true );
	}
	/**
	 * Initilize a singleton instance
	 *
	 * @return \BSFW_Slider
	 */
	public static function init() {
		static $instance = false;
		if ( ! $instance ) {
			$instance = new self();
		}
		return $instance;
	}

	/**
	 *  Requred constant
	 *
	 * @return void
	 */
	public function define_constant() {
		define( 'BSFW_VERSION', self::VERSION );
		define( 'BSFW_FILE', __FILE__ );
		define( 'BSFW_PATH', __DIR__ );
		define( 'BSFW_URL', plugins_url( '', BSFW_FILE ) );
		define( 'BSFW_ASSETS', BSFW_URL . '/assets' );

	}

	/**
	 *  Do stuff upon activation
	 *
	 * @return void
	 */
	public function activate() {
		flush_rewrite_rules( false );
	}
	/**
	 * Init Function
	 *
	 * @return void
	 */
	public function init_plugin() {
		new BasicSliderForWooCommerce\Assets();
		if ( ! is_admin() ) {
			new BasicSliderForWooCommerce\Frontend();
		}
	}

	/**
	 * Notice
	 *
	 * @return void
	 */
	public function bs_slider_notice_message() {
		if ( ! class_exists( 'woocommerce' ) ) {
			echo '<div class="error notice notice-sp-wcsp-woo"><p>';
			_e( 'Please active WooCommerce plugin to make the <b>Category Slider for WooCommerce</b>.', 'bs-slider' );
			echo '</p></div>';
		}
	}



}
/**
 * Activation slider
 *
 * @return BSFW_Slider
 */
function bsfw_slider() {
	return BSFW_Slider::init();
}

bsfw_slider();

