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
	/*******ajax pagination*******/
	jQuery(document).on("click", ".woocommerce-Tabs-panel--msbr_reviews .page-numbers a", function (e) {
		e.preventDefault();
		var link = jQuery(this).attr("href");
		jQuery(".woocommerce-Tabs-panel--msbr_reviews .woocommerce-Reviews").html("Loading..."); //the 'main' div is inside the 'content' div
		jQuery(".woocommerce-Tabs-panel--msbr_reviews .woocommerce-Reviews").load(link + " #comments");
	});

	console.log("Hello World");
})(jQuery);
