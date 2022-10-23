(function ($) {
	// initialize magnific popup
	$(".msbr-open-add-review-modal").magnificPopup({
		type: "inline",
		midClick: true, // Allow opening popup on middle mouse click. Always set it to true if you don't provide alternative source in href.
	});

	// initialize rating
	var starRatingControl = new StarRating(".msbr-star-rating", {
		maxStars: 5,
	});
	console.log("Hello World");
})(jQuery);
