app.service('pageInfoService', function() {
    this.getInfo = function(callback) {
        var model = {};

        chrome.tabs.query({
                'active': true
            },
            function(tabs) {
                if (tabs.length > 0) {
                    model.title = tabs[0].title;
                    model.url = tabs[0].url;

                    chrome.tabs.sendMessage(tabs[0].id, {
                        'action': 'PageInfo'
                    }, function(response) {
                        model.pageInfos = response;
                        callback(model);
                    });
                }

            });
    };
});

app.controller("PageController", function($scope, pageInfoService) {
    pageInfoService.getInfo(function(info) {
        console.log(info);
        $scope.title = info.title;
        $scope.url = info.url;
        $scope.inputsInfo = info.pageInfos.inputs;
        $scope.textAreasInfo = info.pageInfos.textareas;
        $scope.$apply();
    });
});
