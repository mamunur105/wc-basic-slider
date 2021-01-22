<?php // phpcs:ignore WordPress.NamingConventions.ValidHookName.UseUnderscores

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the dashboard.
 *
 * @link       https://wordpress.org/plugins/wc-basic-slider/
 * @since      1.0.0
 *
 * @package    bsfw_Plugin
 * @subpackage bsfw_Plugin/includes
 */

namespace BSFW\Slider;

use BSFW\Slider\Admin\Notice;
use BSFW\Slider\Admin\Custom_Post_Type;
use BSFW\Slider\Admin\Metabox;
use BSFW\Slider\Frontend\Shortcodes;
/**
 * The core plugin class.
 *
 * This is used to define internationalization, dashboard-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    bsfw_Plugin
 * @subpackage bsfw_Plugin/includes
 * @author     Your Name <email@admin.com>
 */
class Plugin {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      bsfw_Plugin_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $pluginname    The string used to uniquely identify this plugin.
	 */
	protected $pluginname;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'BSFW_VERSION' ) ) {
			$this->version = BSFW_VERSION;
		} else {
			$this->version = '1.0.0';
		}

		if ( defined( 'BSFW_PLUGIN_NAME' ) ) {
			$this->pluginname = BSFW_PLUGIN_NAME;
		} else {
			$this->pluginname = 'PluginBoilerplate';
		}
		$this->loader = new Loader();
	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the I18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new I18n();
		$plugin_i18n->set_domain( $this->get_plugin_name() );
		$plugin_i18n->load_plugin_textdomain();

	}

	/**
	 * Register all of the hooks related to the dashboard functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Admin( $this );
		$notice       = new Notice();
		$metabox      = new Metabox();
		$post_type    = new Custom_Post_Type();
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue' );
		$this->loader->add_action( 'after_setup_theme', $plugin_admin, 'boot' );
		$this->loader->add_action( 'admin_notices', $notice, 'notice' );
		$this->loader->add_action( 'wp_ajax_bsfw_rate_the_plugin', $notice, 'rate_the_plugin_action' );
		$this->loader->add_action( 'admin_notices', $notice, 'bs_slider_notice_message' );
		$this->loader->add_action( 'init', $post_type, 'register_bs_slider', 0 );
		$this->loader->add_filter( 'manage_' . $post_type->slug . '_posts_columns', $post_type, 'set_shortocode_column' );
		$this->loader->add_action( 'manage_' . $post_type->slug . '_posts_custom_column', $post_type, 'shortocode_column_data', 10, 2 );
		$this->loader->add_action( 'carbon_fields_register_fields', $metabox, 'bsfw_slider_attach_post_meta' );

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_frontend_hooks() {
		$plugin_frontend = new Frontend( $this );
		$wc_shortcode    = new Shortcodes();
		$this->loader->add_action( 'init', $wc_shortcode, 'shortcode_list' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_frontend, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_frontend, 'enqueue_scripts' );

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * Load the dependencies, define the locale, and set the hooks for the Dashboard and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_frontend_hooks();
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->pluginname;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    bsfw_Plugin_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
