(function ($) {
	// initialize magnific popup
	$(".msbr-open-add-review-modal, .msbr-open-show-review-modal").magnificPopup({
		type: "inline",
		midClick: true, // Allow opening popup on middle mouse click. Always set it to true if you don't provide alternative source in href.
	});

	// initialize rating
	var starRatingControl = new StarRating(".msbr-star-rating", {
		maxStars: 5,
		tooltip: msbr_review.rating_tooltip,
	});

	// initialize rating svg
	$(".msbr-rating-svg").starRating({
		totalStars: 5,
		starSize: 25,
		readOnly: true,
		useFullStars: false,
		emptyColor: "#E3E3E3",
		activeColor: "#F8AC08",
		ratedColor: "#F8AC08",
		useGradient: false,
		strokeWidth: 0,
	});
	$(".msbr-rating-svg-small").starRating({
		totalStars: 5,
		starSize: 22,
		readOnly: true,
		useFullStars: false,
		emptyColor: "#E3E3E3",
		activeColor: "#F8AC08",
		ratedColor: "#F8AC08",
		useGradient: false,
		strokeWidth: 0,
	});
	$(".msbr-rating-svg-mini").starRating({
		totalStars: 5,
		starSize: 18,
		readOnly: true,
		useFullStars: false,
		emptyColor: "#E3E3E3",
		activeColor: "#F8AC08",
		ratedColor: "#F8AC08",
		useGradient: false,
		strokeWidth: 0,
	});

	// calculate average of multi-rating
	$(".msbr-review-form").each(function (formInd) {
		// get the form
		var form = $(this);
		// get each select fields of the form
		$count = 0;
		form.find("select").each(function (selectInd) {
			// get the exact value of the number of select fields
			$count++;
			// create an array of sum to store the total values of each form ( needed when using ajax )
			$sumRating = [];

			// create an object to store the select field values
			var selectVals = [];

			// create a multi dimensional array to store the select field values
			/*
				form[
					0: [ select value, select value, select value, select value ],
					0: [ select value, select value, select value, select value ],
					0: [ select value, select value, select value, select value ],
				]
			*/
			// assign 0 as placeholder to each form field indexes
			for (var i = 0; i <= formInd; i++) {
				// assign 0 as placeholder to form sumRatings
				$sumRating[i] = 0;

				// Create subArray to store the select field values
				selectVals[i] = [];

				for (var j = 0; j <= selectInd; j++) {
					selectVals[i].push(0); // Add 0 as element to subArray
				}
			}

			// get the current select field
			$select = $(this);
			// on change of the current select field
			$select.change(function () {
				// check if selected
				if ($(this).val() != "") {
					if (selectVals[formInd][selectInd] == 0) {
						// override the placeholder select field index value with the current value
						selectVals[formInd][selectInd] = $(this).val();

						// calculate the sum of all select field values
						$sumRating[formInd] += parseInt(selectVals[formInd][selectInd]);
					} else {
						// subtract the existing value first and then add the new value to the sum
						$sumRating[formInd] -= parseInt(selectVals[formInd][selectInd]);
						$sumRating[formInd] += parseInt($(this).val());
						// override the select field index value with the current value
						selectVals[formInd][selectInd] = $(this).val();
					}
				} else {
					// when deselelcted a rating
					// subtract the previous value from the sum
					$sumRating[formInd] -= parseInt(selectVals[formInd][selectInd]);
					// override the placeholder select field index value with the current value
					selectVals[formInd][selectInd] = 0;
				}
				form.find("input[name='rating']").val($sumRating[formInd] / $count);
			});
		});
	});

	// ajaxify list of review pagination
	$(document).on("click", ".woocommerce-Tabs-panel--msbr_reviews .page-numbers a", function (e) {
		e.preventDefault();
		var link = $(this).attr("href");
		if (msbr_review.review_list_design == "default") {
			// for default design
			$(".woocommerce-Tabs-panel--msbr_reviews .woocommerce-Reviews").html(msbr_review.review_list_loading_msg); //the 'main' div is inside the 'content' div
			$(".woocommerce-Tabs-panel--msbr_reviews .woocommerce-Reviews").load(link + " #comments");
		} else {
			// for custom designs
			$(".woocommerce-Tabs-panel--msbr_reviews .msbr-reviews-wrapper").html(msbr_review.review_list_loading_msg); //the 'main' div is inside the 'content' div
			$(".woocommerce-Tabs-panel--msbr_reviews .msbr-reviews-wrapper").load(link + " #msbr-reviews-wrapper");
		}
	});

	// ajaxify add review form
	$(".msbr-add-review-modal").each(function () {
		var modal = $(this);
		var form = modal.find("form");

		form.validate({
			// Specify validation rules
			rules: {
				// The key name on the left side is the name attribute
				// of an input field. Validation rules are defined
				// on the right side
				msbr_review_title: {
					required: true,
					minlength: 10,
					maxlength: 100,
				},
				comment: {
					required: true,
					minlength: msbr_review.min_char,
					maxlength: msbr_review.max_char,
				},
			},
			// Specify validation error messages
			messages: {
				comment: {
					required: msbr_review.review_empty_msg,
					minlength: msbr_review.min_char_msg,
					maxlength: msbr_review.max_char_msg,
				},
			},
			// Make sure the form is submitted to the destination defined
			// in the "action" attribute of the form when valid
			submitHandler: function (formSubmit) {
				var formData = form.serialize();
				var formAction = form.attr("action");
				var formMethod = form.attr("method");
				var formSubmitBtn = form.find("input[type=submit]");
				var formSubmitBtnText = formSubmitBtn.text();
				formSubmitBtn.val(msbr_review.review_sub_msg);

				$.ajax({
					url: formAction,
					type: formMethod,
					data: formData,
					success: function () {
						formSubmitBtn.val(msbr_review.review_sub_success_btn_msg);
						modal.find(".msbr-review-form").hide(function () {
							modal.find(".msbr-review-success").css({
								display: "block",
							});
						});
					},
					error: function (XMLHttpRequest, textStatus, errorThrown) {
						formSubmitBtn.val("Submit");
						alert(errorThrown + msbr_review.review_sub_err_msg);
					},
				});
			},
		});

		// find all the star ratings of the form
		form.find(".msbr-star-rating").each(function () {
			//add the rule to the rating
			$(this).rules("add", {
				required: true,
				messages: {
					required: msbr_review.rating_empty_msg,
				},
			});
		});
	});
})(jQuery);
