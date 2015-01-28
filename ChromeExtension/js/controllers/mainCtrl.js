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
