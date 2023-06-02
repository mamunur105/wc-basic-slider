<?php
/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://wordpress.org/plugins/wc-basic-slider/
 * @since      1.0.0
 *
 * @package    wc-basic-slider
 * @subpackage wc-basic-slider/Frontend
 */

namespace BSFW\Slider;

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the dashboard-specific stylesheet and JavaScript.
 *
 * @package    wc-basic-slider
 * @subpackage wc-basic-slider/Frontend
 * @author     Your Name <email@admin.com>
 */
class Frontend {

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
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Loader as all of the hooks are defined in that particular
		 * class.
		 *
		 * The Loader will then create the relationship between the defined
		 * hooks and the functions defined in this class.
		 */
		$css_list = array(
			'swiper-style'      => array(
				'src'     => BSFW_ASSETS . '/vendors/swiper.min.css',
				'version' => filemtime( BSFW_PLUGIN_DIR . '/assets/vendors/swiper.min.css' ),
			),
			'animate-style'     => array(
				'src'     => BSFW_ASSETS . '/vendors/animate.min.css',
				'version' => filemtime( BSFW_PLUGIN_DIR . '/assets/vendors/animate.min.css' ),
			),
			'bs-frontend-style' => array(
				'src'     => BSFW_ASSETS . '/styles/frontend.css',
				'version' => filemtime( BSFW_PLUGIN_DIR . '/assets/styles/frontend.css' ),
			),
		);

		foreach ( $css_list as $handle => $style ) {
			$deps = isset( $style['deps'] ) ? $style['deps'] : false;
			wp_register_style( $handle, $style['src'], $deps, $style['version'] );
		}

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Loader as all of the hooks are defined in that particular
		 * class.
		 *
		 * The Loader will then create the relationship between the defined
		 * hooks and the functions defined in this class.
		 */

		$js_list = array(
			'swiper-slider-script'    => array(
				'src'     => BSFW_ASSETS . '/vendors/swiper.min.js',
				'version' => filemtime( BSFW_PLUGIN_DIR . '/assets/vendors/swiper.min.js' ),
				'deps'    => array( 'jquery' ),
			),
			'swiper-animation-script' => array(
				'src'     => BSFW_ASSETS . '/vendors/swiper-animation.min.js',
				'version' => filemtime( BSFW_PLUGIN_DIR . '/assets/vendors/swiper-animation.min.js' ),
				'deps'    => array( 'jquery' ),
			),
			'activation-script'       => array(
				'src'     => BSFW_ASSETS . '/scripts/frontend.js',
				'version' => filemtime( BSFW_PLUGIN_DIR . '/assets/scripts/frontend.js' ),
				'deps'    => array( 'jquery' ),
			),
		);

		foreach ( $js_list as $handle => $script ) {
			$deps = isset( $script['deps'] ) ? $script['deps'] : false;
			wp_register_script( $handle, $script['src'], $deps, $script['version'], true );
		}
		wp_set_script_translations(
			$this->plugin->get_plugin_name(),
			'wc-basic-slider',
			BSFW_PLUGIN_DIR . '/languages'
		);

	}


}
