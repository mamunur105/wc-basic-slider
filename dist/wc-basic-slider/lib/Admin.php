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
			\plugin_dir_url( dirname( __FILE__ ) ) . 'assets/styles/admin' . $this->suffix . '.css',
			array(),
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
			\plugin_dir_url( dirname( __FILE__ ) ) . 'assets/scripts/admin' . $this->suffix . '.js',
			array( 'jquery' ),
			$this->plugin->get_version(),
			false
		);
		wp_localize_script(
			$this->plugin->get_plugin_name(),
			'bsfw_script',
			array(
				'admin_ajax'    => admin_url( 'admin-ajax.php' ),
				'ajx_nonce'     => wp_create_nonce( 'ajax-nonce' ),
				'plugin_prefix' => BSFW_PLUGIN_PREFIX,
			)
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
