"use strict";

$(document).ready(function() {

	/* ---- INIT SIZE ---- */
	UI.initSize();

	$(window).resize(function() {
		UI.initSize();
	});

	/* ---- TOGGLE BURGER MENU ---- */
	$('#burger').click(function(e) {
		e.preventDefault();
		if(!UI.nav.burgerTrigger) {
			UI.nav.openBurgerMenu();
		}
		else {
			UI.nav.closeBurgerMenu();
		}
	});

	/* ---- FLASH MESSAGES ---- */
	UI.flashMsg.removeMsgTimeout(3000);

	$('#flashMsg').find('li').click(function(e){
	    e.preventDefault();
		UI.flashMsg.removeMsg($(this));
	});


	/* ---- PROFILE AVATAR HOVER ---- */
	$('#profile').hover(function() {
			UI.profile.$menu.fadeIn();
		}, function() {
			UI.profile.$menu.fadeOut();
		}
	);

	/* ---- ACCORDEON MENU --- -*/
	UI.nav.checkActiveCategory();
	$('.categoryElement > a').click(function(e) {
		UI.nav.accordeonToggle($(this), 'animated');
	});

	/* ---- EDIT PROFILE ---- */
	$("#editButton").click(function(e) {
		e.preventDefault();
		UI.profile.toggleEdition();
	});

	/* ---- SUBMIT FORM ---- */
	$('.submitBtn').click(function(e) {
		e.preventDefault();
		$(this).siblings("input[type='submit']").trigger('click');
	});


	/* ---- POPIN ADD DATA ----*/

	// ----- Add Category
	$('#addCategory').click(function(e) {
		e.preventDefault();
		UI.popin.showCategoryPopin();
	});

	// ----- Add Snippet
	$('.addSnippetLink').click(function(e) {
		e.preventDefault();
		var $dataId = $(this).data('id');

		UI.popin.showSnippetPopin('add');
		$('#categoryID').attr('value',$dataId);
	});

	$('.snippet').click(function(e){
	    e.preventDefault();
		var $dataId = $(this).data('sid');
		var name = $('.name',this).text();
		UI.popin.showSnippetPopin('edit', name);
		$('#snippetID').attr('value', $dataId);
	});

	// ----- Close PopIn
	$('#closePopin, #popinBg').click(function(e) {
		e.preventDefault();
		UI.popin.closePopin();
	});


	$(document).keyup(function(e) {
		if (e.keyCode == 27) {
			if($('#popin').is(':visible')) {
				UI.popin.closePopin();
			}
		}
	});

	/* ---- CHECK URL FOR TRACKING ---- */
	$('#addSnippetForm textarea').keyup(function(e) {
		e.preventDefault();
		var $str = $(this).val();

		if(validateUrl($str)) {
			UI.popin.enableCheckbox();
		}
		else {
			UI.popin.disableCheckbox();
		}
	});

	function validateUrl(str) {
		var pattern = new RegExp("^((http|https):\/\/){1}(www[.])?([a-zA-Z0-9]|-)+([.][a-zA-Z0-9(-|\/|=|?)?]+)+$"); // fragment locator
		if(!pattern.test(str)) {
			return false;
		}
		else {
			return true;
		}
	}

});