"use strict";

(function ($) {
  'use strict'; // Check if element exists

  $.fn.elExists = function () {
    return this.length > 0;
  };

  $(document).ready(function () {
    /**
     * Admin code for dismissing notifications.
     *
     */
    $('.bsfw-notice').on('click', '.notice-dismiss, .bsfw-notice-action', function () {
      var $this = $(this);
      var admin_ajax = bsfw_script.admin_ajax;
      var parents = $this.parents('.bsfw-notice');
      var dismiss_type = $this.data('dismiss');
      var notice_type = parents.data('notice');

      if (!dismiss_type) {
        dismiss_type = '';
      }

      var data = {
        action: 'bsfw_rate_the_plugin',
        dismiss_type: dismiss_type,
        notice_type: notice_type,
        cx_nonce: bsfw_script.ajx_nonce
      }; // console.log( data );

      jQuery.ajax({
        type: 'POST',
        url: admin_ajax,
        data: data,
        success: function success(response) {
          if (response) {
            $this.parents('.bsfw-notice').remove();
          }
        }
      });
    });
  });
})(jQuery);