(function($) {
	'use strict';


 	// Check if element exists
	$.fn.elExists = function() {
		return this.length > 0;
	};

	$(document).ready(function() {
		/**
		 * Admin code for dismissing notifications.
		 *
		 */
		$('.bsfw-notice').on('click', '.notice-dismiss, .bsfw-notice-action', function() {
			let $this = $(this);
			let admin_ajax = bsfw_script.admin_ajax;
			let parents = $this.parents('.bsfw-notice');
			let dismiss_type = $this.data('dismiss');
			let notice_type = parents.data('notice');
			if (!dismiss_type) {
				dismiss_type = '';
			}
			var data = {
				action: 'bsfw_rate_the_plugin',
				dismiss_type: dismiss_type,
				notice_type: notice_type,
				cx_nonce: bsfw_script.ajx_nonce
			};
			// console.log( data );
			jQuery.ajax({
				type: 'POST',
				url: admin_ajax,
				data: data,
				success: function(response) {
					if (response) {
						$this.parents('.bsfw-notice').remove();
					}
				}
			});
		});
	});



})(jQuery);
