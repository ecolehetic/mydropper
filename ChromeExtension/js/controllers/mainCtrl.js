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


	var dataUser;

	Model.getDataUser(function(data){
		dataUser = data;

		if(typeof dataUser != 'undefined') {
			console.log('in');
			UI.user.logIn();
		}
	})

	console.log('dataUser : ',  dataUser);

	/* ---- Inject fonts ---- */
	UI.sideBar.injectFonts();

	/* ---- Check if user already log ---- */


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



	/* ---- Hover a snippet --- */
	$('.md-dragElmt').hover(
		function() {
			UI.sideBar.snippetInfos.show($(this));
		}, function() {
			UI.sideBar.snippetInfos.hide();
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