"use strict";

var Model = {
	tracking : {
		'getCategoryList' : function(callback) {
			var categoryList = ['test','test2'];
			callback.call(this,categoryList);
		},
		'getCategoryGraphData' : function(callback) {
			var catLabels = ['12/02', '13/02', '14/02', '15/02', '16/02', '17/02', '18/02', '19/02'];
			var catSeries = [
				{
					name: 'categoryname',
					data: [1, 2, 3, 5, 8, 13]
				}
			];
			callback.call(this, catLabels,catSeries);
		},
		'getClickRateGraphData' : function(callback) {

			var clickRateSeries = [{
				data: 60, className: 'clickRate'
			}, {
				data: 40, className: 'unclickRate'
			}]

			callback.call(this, clickRateSeries);
		},
		'getSnippetGraphData' : function(callback) {
			var snippetLabels = ['12/02', '13/02', '14/02', '15/02', '16/02', '17/02', '18/02', '19/02'];
			var snippetSeries = [[5, 9, 7, 8, 5, 3, 5, 4]];
			callback.call(this, snippetLabels, snippetSeries);
		},

	}

}