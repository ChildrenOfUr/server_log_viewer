function scroll(to) {
	$('html, body').animate({
		scrollTop: (to == 1 ? $(document).height() : 0)
	}, 'fast');
}

$(document).ready(function() {
	$('#top').click(function() {
		scroll(0);
	});

	$('#bottom').click(function() {
		scroll(1);
	});
});
