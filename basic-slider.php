<?php
/**
 * Plugin Name:       Category Slider for WooCommerce
 * Plugin URI:        https://wordpress.org/plugins/wc-basic-slider
 * Description:       This is for woocommerce Category,Related product, And also For Promotional slider.
 * Version:           2.2.0
 * Requires at least: 5.0
 * Requires PHP:      7.0
 * Tested up to:      6.5
 * WC tested up to:   8.8
 * Author:            Mamunur Rashid
 * Author URI:        https://profiles.wordpress.org/mamunur105/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       bs-slider
 * Domain Path:       /languages
 */

// If this file is called directly, abort.

if ( ! defined( 'WPINC' ) ) {
	die;
}

define( 'BSFW_VERSION', '2.2.0' );

define( 'BSFW_PLUGIN_PREFIX', 'bsfw' );

define( 'BSFW_POST_TYPE', 'bs_slider' );

define( 'BSFW_PLUGIN_NAME', 'wc-basic-slider' );

define( 'BSFW_PLUGIN_DIR', __DIR__ );

define( 'BSFW_PLUGIN_FILE', __FILE__ );

define( 'BSFW_URL', plugins_url( '', BSFW_PLUGIN_FILE ) );

define( 'Carbon_Fields\URL', BSFW_URL . '/vendor/htmlburger/carbon-fields/' );

define( 'BSFW_ASSETS', BSFW_URL . '/assets' );

define( 'BSFW_BASENAME', plugin_basename( __FILE__ ) );

/**
 * The code that runs during plugin activation.
 * This action is documented in lib/Activator.php
 */
\register_activation_hook( __FILE__, '\BSFW\Slider\Activator::activate' );

/**
 * The code that runs during plugin deactivation.
 * This action is documented in lib/Deactivator.php
 */
\register_deactivation_hook( __FILE__, '\BSFW\Slider\Deactivator::deactivate' );

if ( file_exists( __DIR__ . '/vendor/autoload.php' ) ) {
	require_once __DIR__ . '/vendor/autoload.php';
}


/**
 * Begins execution of the plugin.
 *
 * @since    1.0.0
 */
\add_action(
	'plugins_loaded',
	function () {
		$plugin = new \BSFW\Slider\Plugin();
		$plugin->run();
	}
);
