"use strict";
var Model = {
	"userId" : $('#user_id').val(),
	"tokenApi" : $('#token_api').text(),

	"tracking" : {

		getCategoryList : function(callback) {
			console.log('UserId : ' + Model.userId);
			$.getJSON( "/api/categories/"+ Model.userId, function( response ) {
				callback.call(this, response.categoryList);
			});
		},

		getCategoryGraphData : function(cat, fromDate, toDate, callback) {
			$.post('/api/categoryglobal/', { user_id : Model.userId, cat_id : cat, from : fromDate, to : toDate }, function(response) {
				console.log('getCategoryGraphData response : ', response.data);
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
			$.post('/api/trackedlink/', { user_id : Model.userId, cat_id : cat, from : fromDate, to : toDate }, function(response) {
				callback.call(this, response.data);
			}, 'json');
		}
	},

	// TODO Nico 
	'History' : {
		'get' : function() {
			$.post(admin.origin+"/api/historyasync/", {user_id: Model.userId, token_api: Model.tokenApi, pagination: 10, pages : currentPage}, "json")
				.done(function(response) {
					callback.call(this, response);
				}).fail(function(response) {
					console.log('error : ', response);
				});
		}
	},

	'LS' : {
		set : function(item,value) {
			localStorage.setItem(item, JSON.stringify(value));
		},
		'get' : function(item) {
			return JSON.parse(localStorage.getItem(('tpTest')));
		},

		tpTest : function(callback) {
			// Check if tooltip object is in LS
			if(!localStorage.getItem('tpTest')) {
				var tpTest= {
					tooltipHistory : false,
					tooltipTracking : false,
					tooltipCategory : false
				}
				Model.LS.set('tpTest', tpTest);
			}
			
			// Return the object store in LS
			callback.call(this, Model.LS.get('tpTest'));
		}

	}
}