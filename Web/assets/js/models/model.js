"use strict";
var Model = {
	"userId" : $('#user_id').val(),

	"tracking" : {

		'getCategoryList' : function(callback) {
			console.log('UserId : ' + Model.userId);
			$.getJSON( "/api/categories/"+ Model.userId, function( response ) {
				callback.call(this, response.categoryList);
			});
		},

		'getCategoryGraphData' : function(cat, from, to, callback) {
			$.getJSON( "../integration/json/categoryGlobal.json", function( response ) {
				var dataResponse = response.data[0],
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
			});
		},

		'getTrackedLinkGraphData' : function(cat, from, to, callback) {
			$.getJSON( "/api/trackedlink/" + Model.userId + "/" + cat, function( response ) {

				callback.call(this, response.data);
			});
		}
	}

}