(function ($) {
	// initialize magnific popup
	$(".msbr-open-add-review-modal, .msbr-open-show-review-modal").magnificPopup({
		type: "inline",
		midClick: true, // Allow opening popup on middle mouse click. Always set it to true if you don't provide alternative source in href.
	});

	// initialize rating
	var starRatingControl = new StarRating(".msbr-star-rating", {
		maxStars: 5,
		tooltip: "Select a Rating",
	});

	// ajaxify list of review pagination
	$(document).on("click", ".woocommerce-Tabs-panel--msbr_reviews .page-numbers a", function (e) {
		e.preventDefault();
		var link = $(this).attr("href");
		$(".woocommerce-Tabs-panel--msbr_reviews .woocommerce-Reviews").html("Loading..."); //the 'main' div is inside the 'content' div
		$(".woocommerce-Tabs-panel--msbr_reviews .woocommerce-Reviews").load(link + " #comments");
	});

	// ajaxify add review form
	$(".msbr-review-form .comment-form").attr("novalidate", "novalidate");
	$(document).on("submit", ".msbr-add-review-modal", function (e) {
		e.preventDefault();

		$(".msbr-review-form .comment-form").validate({
			// Specify validation rules
			rules: {
				// The key name on the left side is the name attribute
				// of an input field. Validation rules are defined
				// on the right side
				rating: "required",
				comment: {
					required: true,
					minlength: 10,
					maxlength: 300,
				},
			},
			// Specify validation error messages
			messages: {
				rating: "Rating is required",
				comment: {
					required: "Review description is required",
					minlength: "Your review must be at least 10 characters long",
					maxlength: "Your review must be maximum 300 characters long",
				},
			},
			// Make sure the form is submitted to the destination defined
			// in the "action" attribute of the form when valid
			submitHandler: function (formSubmit) {
				var modal = $(this);
				var form = modal.find("form");

				var formData = form.serialize();
				var formAction = form.attr("action");
				var formMethod = form.attr("method");
				var formSubmitBtn = form.find("input[type=submit]");
				var formSubmitBtnText = formSubmitBtn.text();
				formSubmitBtn.val("Submitting...");

				$.ajax({
					url: formAction,
					type: formMethod,
					data: formData,
					success: function () {
						formSubmitBtn.val("Submitted!");
						modal.find(".msbr-review-form").hide(function () {
							modal.find(".msbr-review-success").css({
								display: "block",
							});
						});
					},
					error: function (XMLHttpRequest, textStatus, errorThrown) {
						formSubmitBtn.val("Submit");
						alert(errorThrown + " occured. Please refresh the page and try again");
					},
				});
			},
		});
	});
})(jQuery);
