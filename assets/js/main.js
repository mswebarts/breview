(function ($) {
	// initialize magnific popup
	$(".msbr-open-add-review-modal, .msbr-open-show-review-modal").magnificPopup({
		type: "inline",
		midClick: true, // Allow opening popup on middle mouse click. Always set it to true if you don't provide alternative source in href.
	});

	// initialize rating
	var starRatingControl = new StarRating(".msbr-star-rating", {
		maxStars: 5,
	});

	// ajaxify list of review pagination
	jQuery(document).on("click", ".woocommerce-Tabs-panel--msbr_reviews .page-numbers a", function (e) {
		e.preventDefault();
		var link = jQuery(this).attr("href");
		jQuery(".woocommerce-Tabs-panel--msbr_reviews .woocommerce-Reviews").html("Loading..."); //the 'main' div is inside the 'content' div
		jQuery(".woocommerce-Tabs-panel--msbr_reviews .woocommerce-Reviews").load(link + " #comments");
	});

	console.log(msbr_review);
	// ajaxify add review form
	jQuery(document).on("submit", ".msbr-add-review-modal", function (e) {
		e.preventDefault();
		var modal = jQuery(this);
		var form = modal.find("form");

		// validate if rating has been selected
		if (form.find("select[name='rating']").find(":selected").val() == "") {
			form.find(".gl-star-rating").addClass("msbr-error");
			return;
		} else {
			form.find(".gl-star-rating").removeClass("msbr-error");
		}

		// validate if review is empty
		if (form.find("textarea[name='comment']").val() == "") {
			// add error class to the field
			form.find("textarea[name='comment']").addClass("msbr-error");
			// change error message
			form.find("textarea[name='comment'] + .msbr-error-message").text("Review can't be empty");
			return;
		} else if (form.find("textarea[name='comment']").val().length > 300) {
			// validate if review is more than x characters

			// add error class to the field
			form.find("textarea[name='comment']").addClass("msbr-error");
			// change error message
			form.find("textarea[name='comment'] + .msbr-error-message").text("Review can't be more than 300 characters");
			return;
		} else {
			form.find("textarea[name='comment']").removeClass("msbr-error");
		}

		var formData = form.serialize();
		var formAction = form.attr("action");
		var formMethod = form.attr("method");
		var formSubmitBtn = form.find("input[type=submit]");
		var formSubmitBtnText = formSubmitBtn.text();
		formSubmitBtn.val("Submitting...");

		jQuery.ajax({
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
	});
})(jQuery);
