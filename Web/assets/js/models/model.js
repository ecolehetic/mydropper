"use strict";
var Model = {
	"userId" : $('#user_id').val(),

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

	'LS' : {
		set : function(item,value) {
			localStorage.setItem(item, value);
		},
		get : function(item) {
			localStorage.getItem(item);
		}

	}
}