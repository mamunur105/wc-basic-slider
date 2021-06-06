<?php // phpcs:ignore WordPress.NamingConventions.ValidHookName.UseUnderscores
/**
 * The plugin bootstrap file
 *
 * @link              https://wordpress.org/plugins/wc-basic-slider
 * @since             1.0.3
 * @package           BSFW_Slider
 *
 * @wordpress-plugin
 * Plugin Name:       WooCommerce Slider
 * Plugin URI:        https://wordpress.org/plugins/wc-basic-slider
 * Description:       This is for woocommerce Category,Related product, And also For Promotional slider.
 * Version:           2.0.0
 * Requires at least: 5.0
 * Requires PHP:      7.0
 * Author:            Mamunur rashid
 * Author URI:        https://profiles.wordpress.org/mamunur105
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       bs-slider
 * Domain Path:       /languages
 */

if ( file_exists( dirname( __FILE__ ) . '/vendor/autoload.php' ) ) {
	require_once dirname( __FILE__ ) . '/vendor/autoload.php';
}

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

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

/**
 * Begins execution of the plugin.
 *
 * @since    1.0.0
 */
\add_action(
	'plugins_loaded',
	function () {
		define( 'BSFW_VERSION', '2.0.0' );
		define( 'BSFW_PLUGIN_PREFIX', 'bsfw' );
		define( 'BSFW_PLUGIN_NAME', 'wc-basic-slider' );
		define( 'BSFW_PLUGIN_DIR', __DIR__ );
		define( 'BSFW_PLUGIN_FILE', __FILE__ );
		define( 'BSFW_URL', plugins_url( '', BSFW_PLUGIN_FILE ) );
		define( 'BSFW_ASSETS', BSFW_URL . '/assets' );
		$plugin = new \BSFW\Slider\Plugin();
		$plugin->run();
	}
);
