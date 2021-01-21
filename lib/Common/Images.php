<?php
/**
 * Dsd.
 */

namespace BSFW\Slider\Common;

/**
 * The admin class
 */
class Images {
	/**
	 * Image size
	 *
	 * @return array
	 */
	public static function get_all_image_sizes() {
		global $_wp_additional_image_sizes;
		$sizes  = array();
		$rsizes = array();
		foreach ( get_intermediate_image_sizes() as $s ) {
			$sizes[ $s ] = array( 0, 0 );
			if ( in_array( $s, array( 'thumbnail', 'medium', 'medium_large', 'large' ), true ) ) {
				$sizes[ $s ][0] = get_option( $s . '_size_w' );
				$sizes[ $s ][1] = get_option( $s . '_size_h' );
			} else {
				if ( isset( $_wp_additional_image_sizes ) && isset( $_wp_additional_image_sizes[ $s ] ) ) {
					$sizes[ $s ] = array( $_wp_additional_image_sizes[ $s ]['width'], $_wp_additional_image_sizes[ $s ]['height'] );
				}
			}
		}
		foreach ( $sizes as $size => $atts ) {
			$rsizes[ $size ] = $size . ' ' . implode( 'x', $atts );
		}
		return $rsizes;
	}


}
