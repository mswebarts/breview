(function ($) {
	$('.msbr-upgrade').on('click', function (e) {
		// init sweetalert2
		Swal.fire({
			title: 'Upgrade to Pro',
			text: 'You can upgrade to pro version for more features and options.',
			icon: 'info',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Upgrade Now',
		}).then((result) => {
			if (result.isConfirmed) {
				window.open('https://www.mswebarts.com/products/breview/', '_blank').focus();
			}
		});
	});
})(jQuery);
