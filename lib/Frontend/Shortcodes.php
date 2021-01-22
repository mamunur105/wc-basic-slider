<?php
/**
 * Shortcode functionality
 *
 * @package  shortcode
 */

namespace BSFW\Slider\Frontend;

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	die;
}

/**
 * Redister shortcode
 */
class Shortcodes {

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	private $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of the plugin.
	 */
	private $version;

	/**
	 * Class constructor.
	 *
	 * @access public
	 * @since  1.0
	 */
	public function __construct() {
	}
	/**
	 * SHortcode Function Registered here
	 *
	 * @return void
	 */
	public function shortcode_list() {
		$shortcodes = array(
			'woocategory_slider',
		);

		foreach ( $shortcodes as $shortcode ) :
			add_shortcode( $shortcode, array( $this, $shortcode . '_shortcode' ) );
		endforeach;
	}

	/**
	 * Photo gallery shortcode
	 *
	 * @param array  $atts Shortcode attributes.
	 * @param string $content shortcode content.
	 * @return mixed
	 */
	public function woocategory_slider_shortcode( $atts, $content = null ) {

		$ngatts = shortcode_atts(
			array(
				'id' => '',
			),
			$atts
		);
		$id     = $ngatts['id'];
		$result = '';
		if ( ! empty( $id ) ) {
			wp_dequeue_script( 'cdxn-ig-activation' );
			$ids = explode( ',', $id );
			ob_start();
			$args = array(
				'post_type'      => CDXN_IG_POST_TYPE,
				'posts_per_page' => -1,
				'orderby'        => 'post__in',
				'post__in'       => $ids,
			);
			$loop = new \WP_Query( $args ); ?>
			<?php if ( $loop->have_posts() ) : ?>
				<?php
				while ( $loop->have_posts() ) :
					$loop->the_post();
					$this->render_content();
				endwhile;
				?>
				<?php
			endif;
			\wp_reset_postdata();
			$result .= ob_get_clean();
		}
		return $result;
	}
	/**
	 * Retunr column number.
	 *
	 * @param   string $column_number shortcode column number.
	 * @param   int    $post_id Post id.
	 * @return  int
	 */
	private function column_number( $column_number = 0, $post_id ) {

	}

	/**
	 * Retunr column number.
	 *
	 * @return mixed
	 */
	public function render_content() {

	}


}
