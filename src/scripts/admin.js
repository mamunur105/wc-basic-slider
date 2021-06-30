(function($) {
	'use strict';

	$(document).ready(function() {
		// Check if element exists
		$.fn.elExists = function() {
			return this.length > 0;
		};


		function copyToClipboard(selector) {
			const str = selector.value;
			const tooltip = selector.previousElementSibling;
			const el = document.createElement('textarea');
			el.value = str;
			el.setAttribute('readonly', '');
			el.style.position = 'absolute';
			el.style.left = '-9999px';
			document.body.appendChild(el);
			el.select();
			document.execCommand('copy');
			tooltip.innerHTML = "Copied!";
			document.body.removeChild(el);
		}

		// Click button
		var copyButton = document.querySelectorAll(".copy_shortcode");
		if(copyButton){
			console.log('ok')
			copyButton.forEach(function(item){
				item.addEventListener('click', function(){
					item.style.color = '#0073aa';
					item.style.borderColor = '#0073aa';
					copyToClipboard(item);
					console.log('click');
				});
				item.addEventListener('mouseout', function(){
					var tooltip = item.previousElementSibling;
					tooltip.innerHTML = "Copy to clipboard";
					item.style.color = '';
					item.style.borderColor = '';
				});
			});
		}
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
				ajx_nonce: bsfw_script.ajx_nonce
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
