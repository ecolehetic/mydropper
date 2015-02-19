"use strict";

$ (document).ready (function() {
	var catSelector = '.categoryGraph';
	var catLabels = ['12/02', '13/02', '14/02', '15/02', '16/02', '17/02', '18/02', '19/02'];
	var catSeries = [[5, 9, 7, 8, 5, 3, 5, 4]];
	GraphUI.category.init (catSelector, catLabels, catSeries);

	var clickRateSelector = '.clickRateGraph';
	var clickRateSeries = [{
		data: 60, className: 'clickRate'
	}, {
		data: 40, className: 'unclickRate'
	}]

	GraphUI.clickRate.init (clickRateSelector, clickRateSeries);

	var snippetSelector = '.snippetGraph';
	var snippetLabels = ['12/02', '13/02', '14/02', '15/02', '16/02', '17/02', '18/02', '19/02'];
	var snippetSeries = [[5, 9, 7, 8, 5, 3, 5, 4]];
	GraphUI.snippet.init (snippetSelector, snippetLabels, snippetSeries);
	)
};