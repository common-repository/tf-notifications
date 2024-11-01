(function( $ ) {
	'use strict';

	/**
	 * All of the code for your admin-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */

	jQuery(document).ready(function($) {
		$(function() {
			$(".showDateTime").datetimepicker({
				dateFormat: 'yy-mm-dd',
				timeFormat: 'HH:mm:ss'
			});
		});

		$(function() {
			$(".showDateTime.startdate").datetimepicker("option", {
				onClose: function(dateText, inst) {
					if(dateText != "" || $(".startdate").val() != "") {
						$(".displaydate").removeAttr("disabled");
						var theDate = $(".startdate").datetimepicker("getDate");

						//$(".showDateTime.displaydate").datetimepicker('option', 'minDate', new Date());
						//$(".showDateTime.displaydate").datetimepicker('option', 'maxDate', theDate);
						//$(".showDateTime.displaydate").datetimepicker('option', 'minDateTime', new Date());
						//$(".showDateTime.displaydate").datetimepicker('option', 'maxDateTime', theDate);

						$(".showDateTime.enddate").datetimepicker('option', 'minDate', theDate);
						$(".showDateTime.enddate").datetimepicker('option', 'minDateTime', theDate);
					} else {
						$(".displaydate").attr("disabled","disabled");
						$(".displaydate").val("");
					}
				}
			});
		});

		if($(".showDateTime.startdate") && $(".showDateTime.startdate").val() != "") {
			$(".displaydate").removeAttr("disabled");
		}

	});

})( jQuery );
