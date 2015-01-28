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
                console.log('tabs = ',tabs);
                tabs.forEach(function(sTab) {
                    chrome.tabs.insertCSS(sTab.id, {file:'css/styles.css'});
                });
        });
    });
});