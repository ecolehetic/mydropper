"use strict";
var Model = {
	"userId" : $('#user_id').val(),

	"tracking" : {

		'getCategoryList' : function(callback) {
			console.log('UserId : ' + Model.userId);
			$.getJSON( "../integration/json/categoryList.json", function( response ) {
				var categoryList = [];
				var categoryId = [];
				for(var i = 0; i < response.categoryList.length; i++) {
					categoryList.push(response.categoryList[i].label);
					categoryId.push(response.categoryList[i].id);
				}
				callback.call(this, categoryList, categoryId);
			});
		},

		'getCategoryGraphData' : function(callback) {
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

		'getTrackedLinkGraphData' : function(callback) {
			$.getJSON( "../integration/json/trackedLink.json", function( response ) {

				var dataResponse = response.data,
					categoryName = dataResponse.categoryName

				callback.call(this, categoryName, dataResponse);
			});
		}
	}

}