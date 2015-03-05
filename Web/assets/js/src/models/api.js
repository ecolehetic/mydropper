'use strict';


// helper to connect to api
var API = {
    tokenApi : null,
    userId : null,
    origin : '',
    path : null,

    start : function(){
        API.tokenApi = $('#token_api').text();
        API.userId = $('#user_id').text();
        API.path = window.location.pathname;
    },
    hist : {
        pagination : 12,
        getStores : function(currentPage, callback){
            $.post(API.origin+'/api/historyasync', {user_id: API.userId, token_api: API.tokenApi, pagination: API.hist.pagination, pages : currentPage}, "json")
                .done(function(response) {
                    callback.call(this, response);
                });
        }
    },
    tracking : {
        getCategoryList : function(callback) {
            $.post(API.origin+'/api/categories', { user_id: API.userId, token_api: API.tokenApi }, "json")
                .done(function(response){
                    callback.call(this, response.categoryList);
                });
        },

        getCategoryGraphData : function(cat, fromDate, toDate, callback) {
            $.post(API.origin+'/api/categoryglobal/', { user_id : API.userId, token_api: API.tokenApi, cat_id : cat, from : fromDate, to : toDate }, function(response) {
                if(response.data.graphData) {
                    var dataResponse = response.data,
                        graphData = dataResponse.graphData,
                        catLabels = Object.keys(graphData),
                        catSeries = [
                            {
                                name: dataResponse.categoryName,
                                data: []
                            }
                        ];

                    // Insert values in catSeries for ChartistJs
                    for(var i = 0; i < catLabels.length; i++) {
                        catSeries[0].data.push(graphData[catLabels[i]]);
                    }
                    callback.call(this, catLabels,catSeries);
                } else {
                    var catSeries = [
                        {
                            name: response.data.categoryName,
                            data: [['0']]
                        }
                    ];
                    callback.call(this, ['N/A'],catSeries);
                }
            }, 'json');
        },

        getTrackedLinkGraphData : function(cat, fromDate, toDate, callback) {
            $.post('/api/trackedlink/', { user_id : API.userId, token_api: API.tokenApi, cat_id : cat, from : fromDate, to : toDate }, function(response) {
                callback.call(this, response.data);
            }, 'json');
        }
    }
};

