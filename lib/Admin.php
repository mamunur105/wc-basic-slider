<?php
/**
 * The dashboard-specific functionality of the plugin.
 *
 * @link       https://wordpress.org/plugins/wc-basic-slider/
 * @since      1.0.0
 *
 * @package    wc-basic-slider
 * @subpackage wc-basic-slider/admin
 */

namespace BSFW\Slider;

/**
 * The dashboard-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the dashboard-specific stylesheet and JavaScript.
 *
 * @package    wc-basic-slider
 * @subpackage wc-basic-slider/admin
 * @author     Your Name <email@admin.com>
 */
class Admin {

	/**
	 * The plugin's instance.
	 *
	 * @since  1.0.0
	 * @access private
	 * @var    Plugin $plugin This plugin's instance.
	 */
	private $plugin;
	/**
	 * The plugin's script.
	 *
	 * @since  1.0.0
	 * @access private
	 * @var    Plugin $suffix This plugin's script.
	 */
	private $suffix;
	/**
	 * Initialize the class and set its properties.
	 *
	 * @since 1.0.0
	 *
	 * @param Plugin $plugin This plugin's instance.
	 */
	public function __construct( Plugin $plugin ) {
		$this->suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';
		$this->plugin = $plugin;
	}

	/**
	 * @param array $links default plugin action link.
	 *
	 * @return array [array] plugin action link
	 */
	public static function plugins_setting_links( $links ) {
		$new_links                  = [];
		$new_links['bsfw_settings'] = '<a href="' . admin_url( 'edit.php?post_type=bs_slider' ) . '">' . esc_html__( 'Settings', 'wc-basic-slider' ) . '</a>';
		return array_merge( $new_links, $links );
	}

	/**
	 * @param $links
	 * @param $file
	 *
	 * @return array
	 */
	public function plugin_row_meta( $links, $file ) {
		if ( $file == BSFW_BASENAME ) {
			$row_meta['issues'] = 'Please open a support ticket. Email:<span style="color: red;font-weight: 700;"> support@tinysolutions.freshdesk.com</span>';
			return array_merge( $links, $row_meta );
		}
		return (array) $links;
	}

	/**
	 * Enqueue css and js
	 *
	 * @return void
	 */
	public function enqueue() {
		$my_current_screen = get_current_screen();
		if ( 'bs_slider' === $my_current_screen->post_type ) {
			$this->enqueue_styles()->enqueue_scripts();
		}
	}
	/**
	 * Register the stylesheets for the Dashboard. dependency
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in wc-basic-slider_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The wc-basic-slider_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		\wp_enqueue_style(
			$this->plugin->get_plugin_name(),
			\plugin_dir_url( __DIR__ ) . 'assets/styles/admin.css',
			[],
			$this->plugin->get_version(),
			'all'
		);
		return $this;
	}

	/**
	 * Register the JavaScript for the dashboard.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Plugin_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Plugin_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		\wp_enqueue_script(
			$this->plugin->get_plugin_name(),
			\plugin_dir_url( __DIR__ ) . 'assets/scripts/admin.js',
			[ 'jquery' ],
			$this->plugin->get_version(),
			false
		);
		wp_localize_script(
			$this->plugin->get_plugin_name(),
			'bsfw_script',
			[
				'admin_ajax'    => admin_url( 'admin-ajax.php' ),
				'ajx_nonce'     => wp_create_nonce( 'ajax-nonce' ),
				'plugin_prefix' => BSFW_PLUGIN_PREFIX,
				'post_id'       => get_the_ID(),
			]
		);
	}
	/**
	 * Carbon field metabox and settings page
	 *
	 * @return void
	 */
	public function boot() {
		if ( class_exists( '\Carbon_Fields\Carbon_Fields' ) ) {
			\Carbon_Fields\Carbon_Fields::boot();
		}
	}
}
