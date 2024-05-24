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

	private $textdomain;
	/**
	 * Init
	 *
	 * @return void
	 */
	public function __construct() {
		$this->textdomain = 'bs-slider';
	}

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
			'erase-personal-data.php',
		];

		if ( in_array( $pagenow, $exclude ) ) {
			return;
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
						<h3>Enjoying "<?php echo esc_html( $plugin_data['Name'] ); ?>"? </h3>
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
			[
				'dismiss_type'    => $dismiss_type,
				'notice_type'     => $notice_type,
				'show_again_time' => $show_again ?: 0,
				'action'          => $notice_action,
			]
		);
		$update        = update_user_meta( $user_id, BSFW_PLUGIN_PREFIX . '_rate_the_plugin', $rate_bsfw_mlh );
		wp_send_json( boolval( $update ) );
	}


	// Servay

	/***
	 * @param $mimes
	 *
	 * @return mixed
	 */
	public function deactivation_popup() {
		global $pagenow;
		if ( 'plugins.php' !== $pagenow ) {
			return;
		}

		$this->dialog_box_style();
		$this->deactivation_scripts();
		?>
		<div id="deactivation-dialog-<?php echo $this->textdomain; ?>" title="Quick Feedback">
			<!-- Modal content -->
			<div class="modal-content">
				<div id="feedback-form-body-<?php echo $this->textdomain; ?>">

					<div class="feedback-input-wrapper">
						<input id="feedback-deactivate-<?php echo $this->textdomain; ?>-bug_issue_detected" class="feedback-input"
							   type="radio" name="reason_key" value="bug_issue_detected">
						<label for="feedback-deactivate-<?php echo $this->textdomain; ?>-bug_issue_detected" class="feedback-label">Bug Or Issue detected.</label>
					</div>

					<div class="feedback-input-wrapper">
						<input id="feedback-deactivate-<?php echo $this->textdomain; ?>-no_longer_needed" class="feedback-input" type="radio"
							   name="reason_key" value="no_longer_needed">
						<label for="feedback-deactivate-<?php echo $this->textdomain; ?>-no_longer_needed" class="feedback-label">I no longer
							need the plugin</label>
					</div>
					<div class="feedback-input-wrapper">
						<input id="feedback-deactivate-<?php echo $this->textdomain; ?>-found_a_better_plugin" class="feedback-input"
							   type="radio" name="reason_key" value="found_a_better_plugin">
						<label for="feedback-deactivate-<?php echo $this->textdomain; ?>-found_a_better_plugin" class="feedback-label">I found a
							better plugin</label>
						<input class="feedback-feedback-text" type="text" name="reason_found_a_better_plugin"
							   placeholder="Please share the plugin name">
					</div>
					<div class="feedback-input-wrapper">
						<input id="feedback-deactivate-<?php echo $this->textdomain; ?>-couldnt_get_the_plugin_to_work" class="feedback-input"
							   type="radio" name="reason_key" value="couldnt_get_the_plugin_to_work">
						<label for="feedback-deactivate-<?php echo $this->textdomain; ?>-couldnt_get_the_plugin_to_work" class="feedback-label">I
							couldn't get the plugin to work</label>
					</div>

					<div class="feedback-input-wrapper">
						<input id="feedback-deactivate-<?php echo $this->textdomain; ?>-temporary_deactivation" class="feedback-input"
							   type="radio" name="reason_key" value="temporary_deactivation">
						<label for="feedback-deactivate-<?php echo $this->textdomain; ?>-temporary_deactivation" class="feedback-label">It's a
							temporary deactivation</label>
					</div>
					<span style="color:red;font-size: 16px;"></span>
				</div>
				<p style="margin: 0 0 15px 0;">
					Please let us know about any issues you are facing with the plugin.
					How can we improve the plugin?
				</p>
				<div class="feedback-text-wrapper-<?php echo $this->textdomain; ?>">
					<textarea id="deactivation-feedback-<?php echo $this->textdomain; ?>" rows="4" cols="40"
							  placeholder=" Write something here. How can we improve the plugin?"></textarea>
					<span style="color:red;font-size: 16px;"></span>
				</div>
				<p style="margin: 0;">
					Your satisfaction is our utmost inspiration. Thank you for your feedback.
				</p>
			</div>
		</div>
		<?php
	}

	/***
	 * @param $mimes
	 *
	 * @return mixed
	 */
	public function dialog_box_style() {
		?>
		<style>
			/* Add Animation */
			@-webkit-keyframes animatetop {
				from {
					top: -300px;
					opacity: 0
				}
				to {
					top: 0;
					opacity: 1
				}
			}

			@keyframes animatetop {
				from {
					top: -300px;
					opacity: 0
				}
				to {
					top: 0;
					opacity: 1
				}
			}

			#deactivation-dialog-<?php echo $this->textdomain; ?> {
				display: none;
			}

			.ui-dialog-titlebar-close {
				display: none;
			}

			/* The Modal (background) */
			#deactivation-dialog-<?php echo $this->textdomain; ?> .modal {
				display: none; /* Hidden by default */
				position: fixed; /* Stay in place */
				z-index: 1; /* Sit on top */
				padding-top: 100px; /* Location of the box */
				left: 0;
				top: 0;
				width: 100%; /* Full width */
				height: 100%; /* Full height */
				overflow: auto; /* Enable scroll if needed */
			}

			/* Modal Content */
			#deactivation-dialog-<?php echo $this->textdomain; ?> .modal-content {
				position: relative;
				margin: auto;
				padding: 0;
			}

			#deactivation-dialog-<?php echo $this->textdomain; ?> .feedback-label {
				font-size: 15px;
			}

			div#deactivation-dialog-<?php echo $this->textdomain; ?> p {
				font-size: 16px;
			}

			#deactivation-dialog-<?php echo $this->textdomain; ?> .modal-content > * {
				width: 100%;
				padding: 5px 2px;
				overflow: hidden;
			}

			#deactivation-dialog-<?php echo $this->textdomain; ?> .modal-content textarea {
				border: 1px solid rgba(0, 0, 0, 0.3);
				padding: 15px;
				width: 100%;
			}

			#deactivation-dialog-<?php echo $this->textdomain; ?> .modal-content input.feedback-feedback-text {
				border: 1px solid rgba(0, 0, 0, 0.3);
				min-width: 250px;
			}

			/* The Close Button */
			#deactivation-dialog-<?php echo $this->textdomain; ?> input[type="radio"] {
				margin: 0;
			}

			.ui-dialog-title {
				font-size: 18px;
				font-weight: 600;
			}

			#deactivation-dialog-<?php echo $this->textdomain; ?> .modal-body {
				padding: 2px 16px;
			}

			.ui-dialog-buttonset {
				background-color: #fefefe;
				padding: 0 17px 25px;
				display: flex;
				justify-content: space-between;
				gap: 10px;
			}

			.ui-dialog-buttonset button {
				min-width: 110px;
				text-align: center;
				border: 1px solid rgba(0, 0, 0, 0.1);
				padding: 0 15px;
				border-radius: 5px;
				height: 40px;
				font-size: 15px;
				font-weight: 600;
				display: inline-flex;
				align-items: center;
				justify-content: center;
				cursor: pointer;
				transition: 0.3s all;
				background: rgba(0, 0, 0, 0.02);
				margin: 0;
			}

			.ui-dialog-buttonset button:nth-child(2) {
				background: transparent;
			}

			.ui-dialog-buttonset button:hover {
				background: #2271b1;
				color: #fff;
			}

			.ui-dialog[aria-describedby="deactivation-dialog-bs-slider"] {
				background-color: #fefefe;
				box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
				z-index: 99;
			}

			div#deactivation-dialog-<?php echo $this->textdomain; ?>,
			.ui-draggable .ui-dialog-titlebar {
				padding: 18px 15px;
				box-shadow: 0 0 3px rgba(0, 0, 0, 0.1);
				text-align: left;
			}

			.modal-content .feedback-input-wrapper {
				margin-bottom: 8px;
				display: flex;
				align-items: center;
				gap: 8px;
				line-height: 2;
				padding: 0 2px;
			}

			.ui-widget-overlay.ui-front {
				position: fixed;
				top: 0;
				left: 0;
				right: 0;
				bottom: 0;
				z-index: 9;
				background-color: rgba(0, 0, 0, 0.5);
			}

		</style>

		<?php
	}

	/***
	 * @param $mimes
	 *
	 * @return mixed
	 */
	public function deactivation_scripts() {
		wp_enqueue_script( 'jquery-ui-dialog' );
		?>
		<script>
			jQuery(document).ready(function ($) {

				// Open the deactivation dialog when the 'Deactivate' link is clicked
				$('.deactivate #deactivate-wc-basic-slider').on('click', function (e) {
					e.preventDefault();
					var href = $('.deactivate #deactivate-wc-basic-slider').attr('href');
					var given = localRetrieveData("feedback-given");

					// If set for limited time.
					if ('given' === given) {
						// window.location.href = href;
						// return;
					}
					$('#deactivation-dialog-<?php echo $this->textdomain; ?>').dialog({
						modal: true,
						width: 500,
						show: {
							effect: "fadeIn",
							duration: 400
						},
						hide: {
							effect: "fadeOut",
							duration: 100
						},

						buttons: {
							Submit: function () {
								submitFeedback();
							},
							Cancel: function () {
								$(this).dialog('close');
								window.location.href = href;
							}
						}
					});
					// Customize the button text
					$('.ui-dialog-buttonpane button:contains("Submit")').text('Send Feedback & Deactivate');
					$('.ui-dialog-buttonpane button:contains("Cancel")').text('Skip & Deactivate');
				});

				// Submit the feedback
				function submitFeedback() {
					var href = $('.deactivate #deactivate-wc-basic-slider').attr('href');
					var reasons = $('#deactivation-dialog-<?php echo $this->textdomain; ?> input[type="radio"]:checked').val();
					var feedback = $('#deactivation-feedback-<?php echo $this->textdomain; ?>').val();
					var better_plugin = $('#deactivation-dialog-<?php echo $this->textdomain; ?> .modal-content input[name="reason_found_a_better_plugin"]').val();
					// Perform AJAX request to submit feedback
					if ( ! reasons && ! feedback && ! better_plugin) {
						// Define flag variables
						$('#feedback-form-body-<?php echo $this->textdomain; ?> span').text('Choose The Reason');
						$('.feedback-text-wrapper-<?php echo $this->textdomain; ?> span').text('Please provide me with some advice.');
						return;
					}

					if ('temporary_deactivation' == reasons && !feedback) {
						window.location.href = href;
					}

					$.ajax({
						url: 'https://www.wptinysolutions.com/wp-json/TinySolutions/pluginSurvey/v1/Survey/appendToSheet',
						method: 'GET',
						dataType: 'json',
						data: {
							website: '<?php echo esc_url( home_url() ); ?>',
							reasons: reasons ? reasons : '',
							better_plugin: better_plugin,
							feedback: feedback,
							wpplugin: 'wc-basic-slider',
						},
						success: function (response) {
							if (response.success) {
								console.log('Success');
								localStoreData("feedback-given", 'given');
							}
						},
						error: function (xhr, status, error) {
							// Handle the error response
							console.error('Error', error);
						},
						complete: function (xhr, status) {
							$('#deactivation-dialog-<?php echo $this->textdomain; ?>').dialog('close');
							window.location.href = href;
						}

					});
				}

				// Store data in local storage with an expiration time of 1 hour
				function localStoreData(key, value) {
					// Calculate the expiration time in milliseconds (1 hour = 60 minutes * 60 seconds * 1000 milliseconds)
					var expirationTime = Date.now() + (60 * 60 * 1000);

					// Create an object to store the data and expiration time
					var dataObject = {
						value: value,
						expirationTime: expirationTime
					};

					// Store the object in local storage
					localStorage.setItem(key, JSON.stringify(dataObject));
				}

				// Retrieve data from local storage
				function localRetrieveData(key) {
					// Get the stored data from local storage
					var data = localStorage.getItem(key);
					if (data) {
						// Parse the stored JSON data
						var dataObject = JSON.parse(data);
						// Check if the data has expired
						if (Date.now() <= dataObject.expirationTime) {
							// Return the stored value
							return dataObject.value;
						} else {
							// Data has expired, remove it from local storage
							localStorage.removeItem(key);
						}
					}
					// Return null if data doesn't exist or has expired
					return null;
				}

			});

		</script>

		<?php
	}
}

