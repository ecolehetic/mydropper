'use strict';

var sideBar={
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
		UI.closeSideBar();
        UI.removeMarkDropZones();
	}
	else {
		UI.openSideBar(htmlContent);
		UI.addMarkDropZones();
        UI.initDroppable();
        UI.initDraggable();
        UI.initAccordeon();
	}
}

function initSideBarHandler() {
	UI.injectFonts();
	/* ---- LogIn ---- */
	$('#submitConnexionForm').click(function(e){
		e.preventDefault();
		UI.logIn();
		LS.logIn();
	});

	/* ---- LogOut ---- */
	$('#logOut').click(function(e){
		e.preventDefault();
		UI.logOut();
		LS.logOut();
	});

	/* ---- Click on cross ---- */
	$('#close').click(function(e){
	    e.preventDefault();
	    toggleSideBar();
	});

	/* ---- Hover a snippet --- */
	$('.md-dragElmt').hover(
		function() {
			UI.snippetInfos.show($(this).data('text'));
		}, function() {
			UI.snippetInfos.hide();
		}
	);
}