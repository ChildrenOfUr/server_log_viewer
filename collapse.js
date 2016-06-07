function updateLines() {
	$('pre').each((function() {
		// Remove old listeners
		$(this).off('click');

		if ($(this).innerHeight() > 16) {
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
}

$(document).ready(function() {
	updateLines();
});


$(window).resize(function() {
	updateLines();
});
