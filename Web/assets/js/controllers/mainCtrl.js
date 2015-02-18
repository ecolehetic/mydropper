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
});