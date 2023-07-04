<?php
/**
 * Settings Page functionality of the plugin.
 *
 * @link       https://wordpress.org/plugins/wc-basic-slider/
 * @since      1.0.0
 *
 * @package    bsfw_Plugin
 * @subpackage bsfw_Plugin/admin
 */

namespace BSFW\Slider\Admin;

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	die;
}

/**
 * Gallery notice
 */
class Notice {
	/**
	 * Gallery Notice
	 *
	 * @return mixed
	 */
	public function notice() {

		global $pagenow;
		$exclude = [
			'themes.php',
			'users.php',
			'tools.php',
			'options-general.php',
			'options-writing.php',
			'options-reading.php',
			'options-discussion.php',
			'options-media.php',
			'options-permalink.php',
			'options-privacy.php',
			'admin.php',
			'import.php',
			'export.php',
			'site-health.php',
			'export-personal-data.php',
			'erase-personal-data.php'
		];

		if ( in_array( $pagenow, $exclude ) ) {
            return ;
        }


		ob_start();
		$activation_time  = get_option( BSFW_PLUGIN_PREFIX . '_plugin_activation_time' );
		$notice_available = strtotime( '+0 day', $activation_time );

		if ( $activation_time && $notice_available < time() ) {
			$using               = human_time_diff( $activation_time, time() );
			$display_rate_notice = $this->display_notice( 'rate-the-plugin' );
			if ( $display_rate_notice ) {
				$plugin_data = get_plugin_data( BSFW_PLUGIN_FILE );
				?>
				<div class="bsfw-notice notice notice-success is-dismissible" data-notice="rate-the-plugin">
                    <div class="bsfw-review-notice_content">
                        <h3>Enjoying "<?php echo esc_html( $plugin_data['Name'] ) ; ?>"? </h3>
                        <p>
                        <?php
                            /* translators: %1$s: For using time */
                            printf( esc_html__( 'Hi there! Stoked to see you\'re using %1$s for %2$s now - hope you like it! And if you do, please consider rating it. It would mean the world to us. keep on rocking!', 'wc-basic-slider' ), esc_html( $plugin_data['Name'] ), esc_html( $using ) );
                        ?>
                        </p>
                        <div class="button-wrapper">
                            <?php
                                $review_url = 'https://wordpress.org/support/plugin/' . basename( BSFW_PLUGIN_DIR ) . '/reviews/?filter=5#new-post';
                            ?>
                            <a class="rate-link button-primary" href="<?php echo esc_url( $review_url ); ?>" target="_blank"> ⭐ <?php esc_html_e( 'Rate the plugin', 'wc-basic-slider' ); ?> </a>
                            <button type="button"  data-dismiss="remind-me-later" class="bsfw-notice-action">😀 <?php esc_html_e( 'Remind me later', 'wc-basic-slider' ); ?> </button>
                            <button type="button" data-dismiss="dont-show-again" class="bsfw-notice-action">🔔 <?php esc_html_e( 'Don\'t show again', 'wc-basic-slider' ); ?> </button>
                            <button type="button" data-dismiss="i-already-did" class="bsfw-notice-action">😐 <?php esc_html_e( 'I already did', 'wc-basic-slider' ); ?> </button>
                        </div>
                    </div>
				</div>

				<?php
			}
		}// activation time
		$default = \ob_get_clean();
		echo wp_kses_post( apply_filters( 'bsfw_mlh_notice', $default ) );
        ?>
        <style>
            .bsfw-notice {
                --e-button-context-color: #5d3dfd;
                --e-button-context-color-dark: #5d3dfd;
                --e-button-context-tint: rgb(75 47 157/4%);
                --e-focus-color: rgb(75 47 157/40%);
            }
            .bsfw-notice {
                position: relative;
                margin: 5px 20px 5px 2px;
                border: 1px solid #ccd0d4;
                background: #fff;
                box-shadow: 0 1px 4px rgba(0,0,0,0.15);
                font-family: Roboto, Arial, Helvetica, Verdana, sans-serif;
                border-inline-start-width: 4px;
            }
            .bsfw-notice.notice {
                padding: 0;
            }

            .bsfw-review-notice_content {
                padding: 20px;
            }

            .bsfw-notice p {
                margin: 15px 0;
                padding: 0;
                line-height: 1.5;
            }

            .bsfw-notice h3 {
                margin: 0;
                font-size: 1.0625rem;
                line-height: 1.2;
            }
            .bsfw-notice h3 + p {
                margin-top: 8px;
            }
            .bsfw-notice button {
                display: inline-block;
                padding: 0.4375rem 0.75rem;
                border: 0;
                border-radius: 3px;
                color: #000;
                vertical-align: middle;
                text-align: center;
                text-decoration: none;
                white-space: nowrap;
                cursor: pointer;
                transition: 0.3s all;
            }
            .bsfw-notice button:active {
                background: var(--e-button-context-color-dark);
                color: #fff;
                text-decoration: none;
            }
            .bsfw-notice button:focus {
                outline: 0;
                background: var(--e-button-context-color-dark);
                box-shadow: 0 0 0 2px var(--e-focus-color);
                color: #fff;
                text-decoration: none;
            }
            .bsfw-notice button:hover {
                background: var(--e-button-context-color-dark);
                color: #fff;
                text-decoration: none;
            }
            .bsfw-notice button:focus {
                outline: 0;
                box-shadow: 0 0 0 2px var(--e-focus-color);
            }

        </style>
        <?php
	}


	/**
	 * Notice show or hide.
	 *
	 * @param  string $notice_type Notice meta field.
	 * @return boolean
	 */
	private function display_notice( $notice_type ) {
		$user_id      = get_current_user_id();
		$admin_notice = get_user_meta( $user_id, BSFW_PLUGIN_PREFIX . '_rate_the_plugin', true );
		$admin_notice = maybe_unserialize( $admin_notice );
		if ( isset( $admin_notice['notice_type'] ) && $notice_type === $admin_notice['notice_type'] ) {
			$notice_expire = isset( $admin_notice['show_again_time'] ) ? $admin_notice['show_again_time'] : 0;
			if ( ! $notice_expire || time() <= $notice_expire ) {
				return false;
			} else {
				return true;
			}
		}
		return true;
	}

	/**
	 * Plugin rated notification
	 *
	 * @return mixed
	 */
	public function rate_the_plugin_action() {
		if ( ! isset( $_POST['ajx_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['ajx_nonce'] ) ), 'ajax-nonce' ) ) {
			wp_send_json( boolval( 0 ) );
		}
		$user_id       = get_current_user_id();
		$dismiss_type  = isset( $_POST['dismiss_type'] ) ? sanitize_text_field( wp_unslash( $_POST['dismiss_type'] ) ) : '';
		$notice_type   = isset( $_POST['notice_type'] ) ? sanitize_text_field( wp_unslash( $_POST['notice_type'] ) ) : '';
		$notice_action = isset( $_POST['action'] ) ? sanitize_text_field( wp_unslash( $_POST['action'] ) ) : '';

		if ( 'i-already-did' === $dismiss_type ) {
			$show_again = 0;
		} elseif ( 'dont-show-again' === $dismiss_type ) {
			$show_again = strtotime( '+10 day', time() );
		} else {
			$show_again = strtotime( '+1 day', time() );
		}

		$rate_bsfw_mlh = maybe_serialize(
			array(
				'dismiss_type'    => $dismiss_type,
				'notice_type'     => $notice_type,
				'show_again_time' => $show_again ? $show_again : 0,
				'action'          => $notice_action,
			)
		);
		$update        = update_user_meta( $user_id, BSFW_PLUGIN_PREFIX . '_rate_the_plugin', $rate_bsfw_mlh );
		wp_send_json( boolval( $update ) );

	}


	/**
	 * Notice
	 *
	 * @return void
	 */
//	public function bs_slider_notice_message() {
//		if ( ! class_exists( 'woocommerce' ) ) {
//			echo '<div class="error notice notice-sp-wcsp-woo"><p>';
//			_e( 'Please active WooCommerce plugin to make the <b>Category Slider for WooCommerce</b>.', 'bs-slider' );
//			echo '</p></div>';
//		}
//	}


}

