'use strict';

$(document).ready(function() {
	$('.submitBtn').click(function(e){
		$("input[type='submit']").trigger('click');
	});
});