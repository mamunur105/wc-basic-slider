<?php
/**
 * Fired during plugin activation
 *
 * @link       https://wordpress.org/plugins/wc-basic-slider/
 * @since      1.0.0
 *
 * @package    wc-basic-slider
 * @subpackage wc-basic-slider/includes
 */

namespace BSFW\Slider;

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    wc-basic-slider
 * @subpackage wc-basic-slider/includes
 * @author     Your Name <email@admin.com>
 */
class Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		update_option( 'bsfw_plugin_activation_time', time() );
	}

}
