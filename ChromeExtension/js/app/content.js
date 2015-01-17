// alert('content script loaded');

chrome.extension.onMessage.addListener(
    function(request, sender, sendResponse) {
        debugger;


        if (request.action == 'PageInfo') {
            var inputInfos = [];
            var textInfos = [];

            console.log('input detect');
            // GET input infos
            $('input').each(function() {

                var inputInfo = {};
                var name = $(this).attr('name');
                var type = $(this).attr('type');

                if (type && name) {
                    inputInfo.type = type;
                    inputInfo.name = name;
                    inputInfos.push(inputInfo);
                } else if (name) {
                    inputInfo.name = name;
                    inputInfos.push(inputInfo);
                } else if (type) {
                    inputInfo.type = type;
                    inputInfos.push(inputInfo);
                }
            });

            // GET textarea infos
            $('textarea').each(function() {

                var textInfo = {};
                var name = $(this).attr('name');

                if (name) {
                    textInfo.name = name;
                    textInfos.push(textInfo);
                }
            });

            var pageInfos = {
                'inputs': inputInfos,
                'textareas': textInfos
            }

            sendResponse(pageInfos);
        }
    });
