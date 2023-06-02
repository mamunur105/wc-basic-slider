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
	 * Get the template path.
	 *
	 * @return string
	 */
	public static function get_template_path() {
		return apply_filters( 'bsfw_template_path', 'wc-basic-slider/' );
	}

	/**
	 * Error function
	 *
	 * @param [type] $function function name.
	 * @param [type] $message message.
	 * @param [type] $version version.
	 *
	 * @return void
	 */
	public static function doing_it_wrong( $function, $message, $version ) {
		$message .= ' Backtrace: ' . wp_debug_backtrace_summary();
		_doing_it_wrong( $function, $message, $version );
	}

	/**
	 * @param string $template_name Template name.
	 * @param string $template_path Template path. (default: '').
	 * @param string $plugin_path Plugin path. (default: ''). fallback file from plugin
	 *
	 * @return mixed|void
	 */
	public static function locate_template( $template_name, $template_path = '', $plugin_path = '' ) {
		$template_name = $template_name . '.php';
		if ( ! $template_path ) {
			$template_path = self::get_template_path();
		}
		if ( ! $plugin_path ) {
			$plugin_path = BSFW_PLUGIN_DIR . '/templates/';
		}

		$template_bsfw_path = trailingslashit( $template_path ) . $template_name;
		$template_path      = '/' . $template_name;
		$plugin_path        = $plugin_path . $template_name;

		$located = locate_template(
			apply_filters(
				'bsfw_locate_template_files',
				[
					$template_bsfw_path, // Search in <theme>/shopbuilder/.
					$template_path,             // Search in <theme>/.
				]
			)
		);

		if ( ! $located && file_exists( $plugin_path ) ) {
			return apply_filters( 'bsfw_locate_template', $plugin_path, $template_name );
		}

		/**
		 * APPLY_FILTERS: bsfw_locate_template
		 *
		 * Filter the location of the templates.
		 *
		 * @param string $located Template found
		 * @param string $path Template path
		 *
		 * @return string
		 */
		return apply_filters( 'bsfw_locate_template', $located, $template_name );
	}

	/**
	 * Template Content
	 *
	 * @param string $template_name Template name.
	 * @param array  $args Arguments. (default: array).
	 * @param bool   $return Whether to return or print the template.
	 * @param string $template_path Template path. (default: '').
	 * @param string $plugin_path Fallback path from where file will load if fail to load from template. (default: '').
	 *
	 * @return false|string|void
	 */
	public static function load_template( $template_name, array $args = null, $return = false, $template_path = '', $plugin_path = '' ) {
		$located = self::locate_template( $template_name, $template_path, $plugin_path );

		if ( ! file_exists( $located ) ) {
			// translators: %s template.
			self::doing_it_wrong( __FUNCTION__, sprintf( __( '%s does not exist.', 'shopbuilder' ), '<code>' . $located . '</code>' ), '1.0' );

			return;
		}

		if ( ! empty( $args ) && is_array( $args ) ) {
			$atts = $args;
			extract( $args ); // @codingStandardsIgnoreLine
		}

		// Allow 3rd party plugin filter template file from their plugin.
		$located = apply_filters( 'bsfw_get_template', $located, $template_name, $args );

		if ( $return ) {
			ob_start();
		}

		do_action( 'bsfw_before_template_part', $template_name, $located, $args );
		include $located;
		do_action( 'bsfw_after_template_part', $template_name, $located, $args );

		if ( $return ) {
			return ob_get_clean();
		}
	}

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
