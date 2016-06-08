var lastWidth = -1;

function updateLines() {
	var singleLineSize = $('#sizing').height();

	if (lastWidth !== -1 && lastWidth === $(window).width()) {
		// No horizontal size change
		return;
	}

	$('pre').each((function() {
		// Remove old listeners
		$(this).off('click');
		$(this).attr('closed', 'false');

		if ($(this).innerHeight() > singleLineSize) {
			// Multiple lines
			$(this).addClass('collapse');
			$(this).attr('closed', 'true');
			$(this).click(function() {
				if ($(this).attr('closed') === 'true') {
					$(this).attr('closed', 'false');
				} else {
					$(this).attr('closed', 'true');
				}
			});
		} else {
			// Single line
			$(this).removeClass('collapse');
			$(this).attr('closed', 'false');
		}
	}));

	lastWidth = $(window).width();
}

$(document).ready(function() {
	$('body').append('<pre id="sizing">&nbsp</pre>');
	updateLines();
});


$(window).resize(function() {
	updateLines();
});
