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
			$(this).blur();
		}
	});

	/* ---- LogOut ---- */
	$('#logOut').on('click', function(e){
		e.preventDefault();
		UI.user.logOut();
		Model.logOut();
	});

	/* ---- Check if user already logged in ---- */
	Model.getDataUser(function(userData){
		console.log(userData);
		if(typeof userData != 'undefined') {
			Model.getUserSnippets(function(storesData){
				UI.loggedPanel.renderSnippets(storesData);
				UI.user.logIn();
			});
		}
	})

	/* ---- Hover a snippet --- */
	$('.md-dragElmt').hover(
		function() {
			UI.loggedPanel.snippetInfos.show($(this));
		}, function() {
			UI.loggedPanel.snippetInfos.hide();
		}
	);

	/* ---- Click on cross ---- */
	$("#closePanelButton").on('click', function(){
		toggleSideBar();
	});


	/* ---- Clear chrome storage debug ---- */
	$("#clearStorageLink").click(function(){
		console.log('clear clicked');
		chrome.storage.local.clear(function(){
			console.log('all clear');	
		});
	});
}

function submitLoginRequest() {
	var username = $('#username').val();
	var password = $('#password').val();
	Model.logIn(username, password, function(response){
		if(response.success === true) {
			Model.getUserSnippets(function(storesData){
				UI.loggedPanel.renderSnippets(storesData);
				UI.user.logIn();
			});
		}
		else if(response.success === false) {
			alert(response.message);
		}
		else {
			alert('Username / Password not correct.\nPlease try again');
		}
	})
}