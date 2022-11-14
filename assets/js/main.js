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
			// create an object to store the select field values
			let selectVals = {};
			$sumRating = 0;

			// assign 0 as placeholder to each select field indexes
			for (var i = 0; i <= selectInd; i++) {
				selectVals[i] = 0;
			}

			// get the current select field
			$select = $(this);
			// on change of the current select field
			$select.change(function () {
				if (selectVals[selectInd] == 0) {
					// override the placeholder select field index value with the current value
					selectVals[selectInd] = $(this).val();

					// calculate the sum of all select field values
					$sumRating += parseInt(selectVals[selectInd]);
				} else {
					// calculate the sum of all select field values
					$sumRating -= parseInt(selectVals[selectInd]);
					$sumRating += parseInt($(this).val());
					// override the placeholder select field index value with the current value
					selectVals[selectInd] = $(this).val();
				}

				form.find("input[name='rating']").val($sumRating / $count);
			});
		});
	});

	// ajaxify list of review pagination
	$(document).on("click", ".woocommerce-Tabs-panel--msbr_reviews .page-numbers a", function (e) {
		e.preventDefault();
		var link = $(this).attr("href");
		$(".woocommerce-Tabs-panel--msbr_reviews .woocommerce-Reviews").html(msbr_review.review_list_loading_msg); //the 'main' div is inside the 'content' div
		$(".woocommerce-Tabs-panel--msbr_reviews .woocommerce-Reviews").load(link + " #comments");
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
