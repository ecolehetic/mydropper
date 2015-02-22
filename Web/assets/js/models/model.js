"use strict";

var Model = {
	tracking : {
		'getCategoryList' : function(callback) {
			$.getJSON( "../integration/json/categoryList.json", function( response ) {
				var categoryList = response.categoryList;
				callback.call(this, categoryList);
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
				for(var i = 0; i < catLabels.length-1; i++) {
					catSeries[0].data.push(graphData[catLabels[i]]);
				}

				callback.call(this, catLabels,catSeries);
			});
		},

		'getTrackedLinkGraphData' : function(callback) {
			var clickRateSeries = [{
				data: 60, className: 'clickRate'
			}, {
				data: 40, className: 'unclickRate'
			}];

			var snippetLabels = ['12/02', '13/02', '14/02', '15/02', '16/02', '17/02', '18/02', '19/02'];
			var snippetSeries = [[5, 9, 7, 8, 5, 3, 5, 4]];

			callback.call(this, clickRateSeries, snippetLabels, snippetSeries);
		}
	}

}