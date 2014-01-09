$('.button').click(function() {
	if($(this).attr('type') == 'Submit') {
		$(this).append('<p>Sup</p>')
	}
})