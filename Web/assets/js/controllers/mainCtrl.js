"use strict";

$(document).ready(function() {

	/* INIT SIZE */
	UI.initSize();

	$( window ).resize( function () {
		UI.initSize();
	});

	/* TOGGLE BURGER MENU */
	$( '#burger' ).click( function (e) {
		e.preventDefault();
		if (!UI.nav.burgerTrigger) {
			UI.nav.openBurgerMenu();
		}
		else {
			UI.nav.closeBurgerMenu();
		}
	});

	/* PROFILE AVATAR HOVER */
	$( '#profile' ).hover( function () {
			UI.profile.$menu.fadeIn();
		}, function () {
			UI.profile.$menu.fadeOut();
		}
	);

	/* ACCORDEON MENU */
	$( '.categoryElement > a').click( function(e){
		UI.nav.accordeonToggle($(this));
	});

	/* EDIT PROFILE */
	$( "#editButton" ).click( function(e){
		e.preventDefault();
		UI.profile.toggleEdition();
	});

	/* SUBMIT FORM */
	$('.submitBtn').click( function(e){
		e.preventDefault();
		$( this ).siblings("input[type='submit']").trigger('click');
	});

	/* TRACKING TABS */
	$('#tabs li').click(function(e){
	    e.preventDefault();
		var $this = $( this );
		UI.tracking.toggleTabs($this);
	});

	/* INIT TRAKING GRAPH */

	if($(location).attr('pathname').indexOf("tracking") > -1){
		/* Category Graph */
		var catSelector = '.categoryGraph';
		var catLabels = ['12/02', '13/02', '14/02', '15/02', '16/02', '17/02', '18/02', '19/02'];
		var catSeries = [[5, 9, 7, 8, 5, 3, 5, 4]];
		Graph.category.init(catSelector, catLabels, catSeries);

		var clickRateSelector = '.clickRateGraph';
		var clickRateSeries =  [{
			data: 60,
			className: 'clickRate'
		}, {
			data: 40,
			className: 'unclickRate'
		}]

		Graph.clickRate.init(clickRateSelector, clickRateSeries);

		var snippetSelector = '.snippetGraph';
		var snippetLabels = ['12/02', '13/02', '14/02', '15/02', '16/02', '17/02', '18/02', '19/02'];
		var snippetSeries = [[5, 9, 7, 8, 5, 3, 5, 4]];
		Graph.snippet.init(snippetSelector, snippetLabels, snippetSeries);
	}

	/* POPIN ADD DATA */

	// ----- Add Category
	$('#addCategory').click(function(e){
	    e.preventDefault();
		$( "#popin" ).fadeIn();
		$( "addSnippetFormContainer").hide();
	});
	// ----- Add Snippet
	$('.addSnippetLink').click(function(e){
	    e.preventDefault();
		$( "#popin" ).fadeIn();
		$( "addSnippetFormContainer").hide();
	});
	// ----- Close PopIn
	$('#closePopin, #popinBg').click(function(e){
		e.preventDefault();
		$( "#popin" ).fadeOut();
	});
	// ----- Check URL for traking
	$('#addSnippetForm textarea').keyup(function(e){
	    e.preventDefault();
		var $str = $( this ).val();

		if(validateUrl($str)){
			console.log('true');
			$('#urlCheckbox').removeClass('disabled');

			$( "#urlCheckbox input" ).prop( "disabled", false );

		}
		else {
			console.log('false');
			$('#urlCheckbox').addClass('disabled');
			$( "#urlCheckbox input" ).prop( "disabled", true );
		}
	});

	function validateUrl(str) {
		var pattern = new RegExp('^(https?:\\/\\/)?'+ // protocol
		'((([a-z\\d]([a-z\\d-]*[a-z\\d])*)\\.)+[a-z]{2,}|'+ // domain name
		'((\\d{1,3}\\.){3}\\d{1,3}))'+ // OR ip (v4) address
		'(\\:\\d+)?(\\/[-a-z\\d%_.~+]*)*'+ // port and path
		'(\\?[;&a-z\\d%_.~+=-]*)?'+ // query string
		'(\\#[-a-z\\d_]*)?$','i'); // fragment locator
		if(!pattern.test(str)) {
			return false;
		} else {
			return true;
		}
	}

});