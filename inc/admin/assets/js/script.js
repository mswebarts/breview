(function ($) {
	// do something
	$(".msbr-repeater").repeater({
		initEmpty: false,
		show: function () {
			$(this).slideDown();
		},
		hide: function (deleteElement) {
			if (confirm("Are you sure you want to delete this element?")) {
				$(this).slideUp(deleteElement);
			}
		},
		isFirstItemUndeletable: true,
	});
})(jQuery);
