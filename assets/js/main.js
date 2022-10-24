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

	// TODO: validate ajax form before submission

	// ajaxify add review form
	jQuery(document).on("submit", ".msbr-add-review-modal form", function (e) {
		e.preventDefault();
		var form = jQuery(this);
		var formData = form.serialize();
		var formAction = form.attr("action");
		var formMethod = form.attr("method");
		var formSubmitBtn = form.find("input[type=submit]");
		var formSubmitBtnText = formSubmitBtn.text();
		formSubmitBtn.text("Loading...");
		console.log("before ajax");

		jQuery.ajax({
			url: formAction,
			type: formMethod,
			data: formData,
			/*success: function (response) {
				console.log("success");
				formSubmitBtn.text("Submitted");
				if (response.success) {
					jQuery.magnificPopup.close();
					jQuery(".woocommerce-Tabs-panel--msbr_reviews .woocommerce-Reviews").html(response.data);
				} else {
					form.html(response.data);
				}
			},*/
			success: function () {
				$(".msbr-add-review-modal #review_form").hide(function () {
					$(".msbr-review-success").css({
						display: "block",
					});
				});
			},
			error: function (XMLHttpRequest, textStatus, errorThrown) {
				alert("Status: " + textStatus);
				alert("Error: " + errorThrown);
			},
		});
		console.log("after ajax");
	});
})(jQuery);
