'use strict';

var API = {
    tokenApi : null,
    userId : null,
    origin : '',
    path : window.location.pathname,

    start : function(){
        API.tokenApi = $('#token_api').text();
        API.userId = $('#user_id').text();
    },
    hist : {
        pagination : 12,
        getStores : function(currentPage, callback){
            $.post(API.origin+"/historyasync", {user_id: API.userId, token_api: API.tokenApi, pagination: API.hist.pagination, pages : currentPage}, "json")
                .done(function(response) {
                    callback.call(this, response);
                });
        }
    }
};

