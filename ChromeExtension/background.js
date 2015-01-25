chrome.browserAction.onClicked.addListener(function(tab) {
    chrome.tabs.getSelected(null, function(tab) {
        chrome.tabs.sendRequest(
            tab.id,
            {
                callFunction: "toggleSidebar",
                sideBarContent: document.getElementById('contentToLoad').innerHTML,
            },
            function(response) {
                console.log(response);
            }
        );
        chrome.tabs.query({currentWindow:true, active:true}, function(tabs){
                var spectTab = tabs[0];
                chrome.tabs.insertCSS(spectTab.id, {file:'css/sidebar-reset.css'});
                chrome.tabs.insertCSS(spectTab.id, {file:'css/styles.css'});
                chrome.tabs.insertCSS(spectTab.id, {file:'css/jquery-ui.min.css'});
                chrome.tabs.insertCSS(spectTab.id, {file:'css/jquery-ui.structure.min.css'});
        });
    });
});