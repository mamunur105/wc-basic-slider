<?php

namespace Basic\Slider;

/**
 * Assets handlers class
 */
class Assets {

	/**
	 * Class constructor
	 */
	function __construct() {
		add_action( 'wp_enqueue_scripts', [ $this, 'register_assets' ] );
		add_action( 'admin_enqueue_scripts', [ $this, 'register_assets' ] );
	}

	/**
	 * All available scripts
	 *
	 * @return array
	 */
	public function get_scripts() {
		return [
			'slick-slider-script' => [
				'src'     	=> BS_ASSETS . '/js/slick.min.js',
				'version'	=> filemtime( BS_PATH . '/assets/js/slick.min.js' ),
				'deps'   	=> [ 'jquery' ]
			],
			'activation-script' => [
				'src'     	=> BS_ASSETS . '/js/activation.js',
				'version'	=> filemtime( BS_PATH . '/assets/js/activation.js' ),
				'deps'   	=> [ 'jquery' ]
			],
		];
	}

	/**
	 * All available styles
	 *
	 * @return array
	 */
	public function get_styles() {
		return [
			'academy-style' => [
				'src'     => BS_ASSETS . '/css/slick.css',
				'version' => filemtime( BS_PATH . '/assets/css/slick.css' )
			],
			'academy-admin-style' => [
				'src'     => BS_ASSETS . '/css/admin.css',
				'version' => filemtime( BS_PATH . '/assets/css/admin.css' )
			]
		];
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