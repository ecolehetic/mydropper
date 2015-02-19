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
	$( '.categoryElement a' ).click( function(e){
	    e.preventDefault();
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
		$("input[type='submit']").trigger('click');
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
		var clickRateSeries = [60,40];
		Graph.clickRate.init(clickRateSelector, clickRateSeries);

		var snippetSelector = '.snippetGraph';
		var snippetLabels = ['12/02', '13/02', '14/02', '15/02', '16/02', '17/02', '18/02', '19/02'];
		var snippetSeries = [[5, 9, 7, 8, 5, 3, 5, 4]];
		Graph.snippet.init(snippetSelector, snippetLabels, snippetSeries);

	}
});