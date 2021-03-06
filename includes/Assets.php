<?php
/**
 * Assets load
 *
 * @package Assets
 */

namespace BasicSliderForWooCommerce;

/**
 * Assets handlers class
 */
class Assets {

	/**
	 * Class constructor
	 */
	public function __construct() {
		add_action( 'wp_enqueue_scripts', array( $this, 'register_assets' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'register_assets' ) );
	}

	/**
	 * All available scripts
	 *
	 * @return array
	 */
	public function get_scripts() {
		return array(
			'swiper-slider-script'    => array(
				'src'     => BSFW_ASSETS . '/js/swiper.min.js',
				'version' => filemtime( BSFW_PATH . '/assets/js/swiper.min.js' ),
				'deps'    => array( 'jquery' ),
			),
			'swiper-animation-script' => array(
				'src'     => BSFW_ASSETS . '/js/swiper-animation.min.js',
				'version' => filemtime( BSFW_PATH . '/assets/js/swiper-animation.min.js' ),
				'deps'    => array( 'jquery' ),
			),
			'activation-script'       => array(
				'src'     => BSFW_ASSETS . '/js/activation.js',
				'version' => filemtime( BSFW_PATH . '/assets/js/activation.js' ),
				'deps'    => array( 'jquery' ),
			),
		);
	}

	/**
	 * All available styles
	 *
	 * @return array
	 */
	public function get_styles() {
		return array(
			'swiper-style'      => array(
				'src'     => BSFW_ASSETS . '/css/swiper.min.css',
				'version' => filemtime( BSFW_PATH . '/assets/css/swiper.min.css' ),
			),
			'animate-style'     => array(
				'src'     => BSFW_ASSETS . '/css/animate.min.css',
				'version' => filemtime( BSFW_PATH . '/assets/css/animate.min.css' ),
			),
			'bs-frontend-style' => array(
				'src'     => BSFW_ASSETS . '/css/bs-frontend.css',
				'version' => filemtime( BSFW_PATH . '/assets/css/bs-frontend.css' ),
			),
			'admin-style'       => array(
				'src'     => BSFW_ASSETS . '/css/admin.css',
				'version' => filemtime( BSFW_PATH . '/assets/css/admin.css' ),
			),
		);
	}

	/**
	 * Register scripts and styles
	 *
	 * @return void
	 */
	public function register_assets() {
		$scripts = $this->get_scripts();
		$styles  = $this->get_styles();

		foreach ( $scripts as $handle => $script ) {

			$deps = isset( $script['deps'] ) ? $script['deps'] : false;
			wp_register_script( $handle, $script['src'], $deps, $script['version'], true );

		}

		foreach ( $styles as $handle => $style ) {
			$deps = isset( $style['deps'] ) ? $style['deps'] : false;

			wp_register_style( $handle, $style['src'], $deps, $style['version'] );
		}
	}

}
