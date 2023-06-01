<?php
/**
 * Dsd.
 */

namespace BSFW\Slider\Common;

/**
 * The admin class
 */
class Helpers {
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
	/**
	 * Dropdown Animation.
	 *
	 * @return array
	 */
	public static function dropdown_animation(){
		return array(
			'none'         => '--Select One--',
			'bounce'       => 'bounce',
			'flash'        => 'flash',
			'pulse'        => 'pulse',
			'rubberBand'   => 'rubberBand',
			'shakeX'       => 'shakeX',
			'shakeY'       => 'shakeY',
			'headShake'    => 'headShake',
			'swing'        => 'swing',
			'tada'         => 'tada',
			'wobble'       => 'wobble',
			'jello'        => 'jello',
			'heartBeat'    => 'heartBeat',
			'backInDown'   => 'backInDown',
			'backInLeft'   => 'backInLeft',
			'backInRight'  => 'backInRight',
			'backInUp'     => 'backInUp',
			'backOutDown'  => 'backOutDown',
			'backOutLeft'  => 'backOutLeft',
			'backOutRight' => 'backOutRight',
			'backOutUp'    => 'backOutUp',
			'bounceIn'     => 'bounceIn',
			'bounceInDown' => 'bounceInDown',
			'bounceInLeft' => 'bounceInLeft',
			'bounceInRight' => 'bounceInRight',
			'bounceInUp'   => 'bounceInUp',
			'bounceOut'    => 'bounceOut',
			'bounceOutDown' => 'bounceOutDown',
			'bounceOutLeft' => 'bounceOutLeft',
			'bounceOutRight' => 'bounceOutRight',
			'bounceOutUp'  => 'bounceOutUp',
			'fadeIn'       => 'fadeIn',
			'fadeInDown'   => 'fadeInDown',
			'fadeInDownBig' => 'fadeInDownBig',
			'fadeInLeft'   => 'fadeInLeft',
			'fadeInLeftBig' => 'fadeInLeftBig',
			'fadeInRight'  => 'fadeInRight',
			'fadeInRightBig' => 'fadeInRightBig',
			'fadeInUp'     => 'fadeInUp',
			'fadeInUpBig'  => 'fadeInUpBig',
			'fadeInTopLeft' => 'fadeInTopLeft',
			'fadeInTopRight' => 'fadeInTopRight',
			'fadeInBottomLeft' => 'fadeInBottomLeft',
			'fadeInBottomRight' => 'fadeInBottomRight',
			'fadeOut'      => 'fadeOut',
			'fadeOutDown'  => 'fadeOutDown',
			'fadeOutDownBig' => 'fadeOutDownBig',
			'fadeOutLeft'  => 'fadeOutLeft',
			'fadeOutLeftBig' => 'fadeOutLeftBig',
			'fadeOutRight' => 'fadeOutRight',
			'fadeOutRightBig' => 'fadeOutRightBig',
			'fadeOutUp'    => 'fadeOutUp',
			'fadeOutUpBig' => 'fadeOutUpBig',
			'fadeOutTopLeft' => 'fadeOutTopLeft',
			'fadeOutTopRight' => 'fadeOutTopRight',
			'fadeOutBottomRight' => 'fadeOutBottomRight',
			'fadeOutBottomLeft' => 'fadeOutBottomLeft',
			'flip'         => 'flip',
			'flipInX'      => 'flipInX',
			'flipInY'      => 'flipInY',
			'flipOutX'     => 'flipOutX',
			'flipOutY'     => 'flipOutY',
			'Lightspeed'   => 'Lightspeed',
			'lightSpeedInRight' => 'lightSpeedInRight',
			'lightSpeedInLeft' => 'lightSpeedInLeft',
			'lightSpeedOutRight' => 'lightSpeedOutRight',
			'lightSpeedOutLeft' => 'lightSpeedOutLeft',
			'rotateIn'     => 'rotateIn',
			'rotateInDownLeft' => 'rotateInDownLeft',
			'rotateInDownRight' => 'rotateInDownRight',
			'rotateInUpLeft' => 'rotateInUpLeft',
			'rotateInUpRight' => 'rotateInUpRight',
			'rotateOut'    => 'rotateOut',
			'rotateOutDownLeft' => 'rotateOutDownLeft',
			'rotateOutDownRight' => 'rotateOutDownRight',
			'rotateOutUpLeft' => 'rotateOutUpLeft',
			'rotateOutUpRight' => 'rotateOutUpRight',
			'hinge'        => 'hinge',
			'jackInTheBox' => 'jackInTheBox',
			'rollIn'       => 'rollIn',
			'rollOut'      => 'rollOut',
			'zoomIn'       => 'zoomIn',
			'zoomInDown'   => 'zoomInDown',
			'zoomInLeft'   => 'zoomInLeft',
			'zoomInRight'  => 'zoomInRight',
			'zoomInUp'     => 'zoomInUp',
			'zoomOut'      => 'zoomOut',
			'zoomOutDown'  => 'zoomOutDown',
			'zoomOutLeft'  => 'zoomOutLeft',
			'zoomOutRight' => 'zoomOutRight',
			'zoomOutUp'    => 'zoomOutUp',
			'slideInDown'  => 'slideInDown',
			'slideInLeft'  => 'slideInLeft',
			'slideInRight' => 'slideInRight',
			'slideInUp'    => 'slideInUp',
			'slideOutDown' => 'slideOutDown',
			'slideOutLeft' => 'slideOutLeft',
			'slideOutRight' => 'slideOutRight',
			'slideOutUp'   => 'slideOutUp',
		);
	}

}
