"use strict";

$(document).ready(function() {

	/* INIT SIZE */
	UI.initSize();

	$(window).resize(function() {
		UI.initSize();
	});

	/* TOGGLE BURGER MENU */
	$('#burger').click(function(e) {
		e.preventDefault();
		if(!UI.nav.burgerTrigger) {
			UI.nav.openBurgerMenu();
		}
		else {
			UI.nav.closeBurgerMenu();
		}
	});

	/* FLASH MESSAGES */
	UI.flashMsg.removeMsgTimeout(3000);

	$('#flashMsg').find('li').click(function(e){
	    e.preventDefault();
		UI.flashMsg.removeMsg($(this));
	});


	/* PROFILE AVATAR HOVER */
	$('#profile').hover(function() {
			UI.profile.$menu.fadeIn();
		}, function() {
			UI.profile.$menu.fadeOut();
		});

	/* ACCORDEON MENU */
	$('.categoryElement > a').click(function(e) {
		UI.nav.accordeonToggle($(this));
	});

	/* EDIT PROFILE */
	$("#editButton").click(function(e) {
		e.preventDefault();
		UI.profile.toggleEdition();
	});

	/* SUBMIT FORM */
	$('.submitBtn').click(function(e) {
		e.preventDefault();
		$(this).siblings("input[type='submit']").trigger('click');
	});

	/* TRACKING TABS */
	$('#tabs li').click(function(e) {
		e.preventDefault();
		var $this = $(this);
		UI.tracking.toggleTabs($this);
	});

	/* POPIN ADD DATA */

	// ----- Add Category
	$('#addCategory').click(function(e) {
		e.preventDefault();
		UI.popin.showAddCategory();
	});
	// ----- Add Snippet
	$('.addSnippetLink').click(function(e) {
		e.preventDefault();
		var $dataId = $(this).data('id');

		UI.popin.showAddSnippet();
		$('#categoryID').attr('value',$dataId);
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
	// ----- Check URL for traking
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
		var pattern = new RegExp('^(https?:\\/\\/)?' + // protocol
		'((([a-z\\d]([a-z\\d-]*[a-z\\d])*)\\.)+[a-z]{2,}|' + // domain name
		'((\\d{1,3}\\.){3}\\d{1,3}))' + // OR ip (v4) address
		'(\\:\\d+)?(\\/[-a-z\\d%_.~+]*)*' + // port and path
		'(\\?[;&a-z\\d%_.~+=-]*)?' + // query string
		'(\\#[-a-z\\d_]*)?$', 'i'); // fragment locator
		if(!pattern.test(str)) {
			return false;
		}
		else {
			return true;
		}
	}

});