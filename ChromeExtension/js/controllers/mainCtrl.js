'use strict';

var sideBar = {
	isOpen : false
};

/*Handle requests from background.html*/
chrome.extension.onRequest.addListener(handleRequest);

function handleRequest(request, sender, sendResponse) {
    if (request.callFunction == "toggleSidebar") {
		toggleSideBar(request.sideBarContent);
    }
    initSideBarHandler();
}

function toggleSideBar(htmlContent) {
	if(sideBar.isOpen) {
		UI.sideBar.close();
		UI.sideBar.removeMarkDropZones();
	}
	else {
		UI.sideBar.open(htmlContent);
		UI.sideBar.addMarkDropZones();
		UI.sideBar.initDroppable();
		UI.sideBar.initDraggable();
		UI.sideBar.initAccordeon();
	}
}

function initSideBarHandler() {

	/* ---- Inject fonts ---- */
	UI.sideBar.injectFonts();

	/* ---- LogIn ---- */
	$('#submitConnexionForm').on('click', function(e){
		e.preventDefault();
		submitLoginRequest();
	});
	$('input').on('keyup', function(e){
	    e.preventDefault();
		if(e.which == 13) {
			submitLoginRequest();
		}
	});

	/* ---- LogOut ---- */
	$('#logOut').on('click', function(e){
		e.preventDefault();
		UI.user.logOut();
		Model.LS.logOut();
	});



	/* ---- Hover a snippet --- */
	$('.md-dragElmt').hover(
		function() {
			UI.sideBar.snippetInfos.show($(this));
		}, function() {
			UI.sideBar.snippetInfos.hide();
		}
	);

	/* ---- Click on cross ---- */

	$("#closePanelButton").click(function(){
		toggleSideBar();
	});
}

function submitLoginRequest() {
	var username = $('#username').val();
	var password = $('#password').val();
	Model.logIn(username, password, function(response){
		if(response.success === true) {
			UI.user.logIn();
		}
		else if(response.success === false) {
			alert(response.message);
		}
		else {
			alert('Username / Password not correct.\nPlease try again');
		}
	})
}