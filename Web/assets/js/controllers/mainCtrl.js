"use strict";

$(document).ready(function() {

	/* ---- INIT SIZE ---- */
	UI.initSize();

	$(window).on('resize', function() {
		UI.initSize();
	});

	/* ---- INSTALL CHROME EXTENSION LINK --- */
	$('.installExtensionLink').on('click', function(e){
		chrome.webstore.install('',
			function(){
				console.log('Installation launched');
			},
			function(){
				console.log('Auto Installation failed');
			}
		);
	});
	/* ---- TOGGLE BURGER MENU ---- */
	$('#burger').on('click', function(e) {
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

	$('#flashMsg').find('li').on('click', function(e){
	    e.preventDefault();
		UI.flashMsg.removeMsg($(this));
	});


	/* ---- PROFILE AVATAR HOVER ---- */
	$('#profile').hover(
		function() {
			UI.profile.$menu.fadeIn();
		}, function() {
			UI.profile.$menu.fadeOut();
		}
	);

	/* ---- ACCORDEON MENU --- -*/
	UI.nav.checkActiveCategory();
	$('.categoryElement > a').on('click', function(e) {
		UI.nav.accordeonToggle($(this), 'animated');
	});

	/* ---- EDIT PROFILE ---- */
	$("#editButton").on('click', function(e) {
		e.preventDefault();
		UI.profile.toggleEdition();
	});

	/* ---- SUBMIT FORM ---- */
	$('.submitBtn').on('click', function(e) {
		e.preventDefault();
		$(this).siblings("input[type='submit']").trigger('click');
	});


	/* ---- POPIN ADD DATA ----*/

	// ----- Add Category
	$('#addCategory').on('click', function(e) {
		e.preventDefault();
		UI.popin.showCategoryPopin();
	});

	// ----- Add Snippet
	$('.addSnippetLink').on('click', function(e) {
		e.preventDefault();
		var $dataId = $(this).data('id');

		UI.popin.showSnippetPopin('add');
		$('#categoryID').attr('value',$dataId);
	});

	$('#addSnippetAlias').on('click', function(e){
	    e.preventDefault();
		$('.categoryElement.active .addSnippetLink').trigger('click');
	});

	/*$('.snippet').on('click', function(e){
	    e.preventDefault();
		var $dataId = $(this).data('sid');
		var name = $('.name',this).text();
		UI.popin.showSnippetPopin('edit', name);
		$('#snippetID').attr('value', $dataId);
	});*/



	// ----- Close PopIn
	$('#closePopin, #popinBg').on('click', function(e) {
		e.preventDefault();
		UI.popin.closePopin();
	});


	$(document).on('keyup', function(e) {
		if (e.keyCode == 27) {
			if($('#popin').is(':visible')) {
				UI.popin.closePopin();
			}
		}
	});

	/* ---- DELETE LINK ---- */
	$('.deleteLink').on('click', function(e){
	    e.preventDefault();
	    var href = $(this).attr('href');
		var delOk=confirm('Do you really want to delete this ' + $(this).data('del') + ' ?');
		if (delOk) {
			window.location.href = href;
		}
	});
	/* ---- CHECK URL FOR TRACKING ---- */
	$('#addSnippetForm textarea').on('keyup', function(e) {
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