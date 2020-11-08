<?php
namespace BasicSliderForWooCommerce;

/**
 * Frontend functionality
 */
class Frontend {

	/**
	 * Front end const
	 */
	public function __construct() {
		new Frontend\Shortcode();
		new Frontend\ProductSlider();

	}
}
