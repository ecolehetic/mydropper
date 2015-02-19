"use strict";

$(document).ready(function() {

	var categoryList = ['Amsterdam', 'Antwerp'];
	$('#categoryChoice').select3({
		allowClear: true,
		items: ['Amsterdam', 'Antwerp'],
		placeholder: categoryList[0]
	});

	$('#categoryChoice').on('select3-selected', function(){
		alert('change for' +$(this).select3('value'))
	});

	var catSelector = '.categoryGraph';
	var catLabels = ['12/02', '13/02', '14/02', '15/02', '16/02', '17/02', '18/02', '19/02'];
	var catSeries = [
		{
			name: 'categoryname',
			data: [1, 2, 3, 5, 8, 13]
		}
	];
	GraphUI.category.init(catSelector, catLabels, catSeries);

	var clickRateSelector = '.clickRateGraph-1';
	var clickRateSelector2 = '.clickRateGraph-2';
	var clickRateSeries = [{
		data: 60, className: 'clickRate'
	}, {
		data: 40, className: 'unclickRate'
	}]

	GraphUI.clickRate.init(clickRateSelector, clickRateSeries);
	GraphUI.clickRate.init(clickRateSelector2, clickRateSeries);

	var snippetSelector = '.snippetGraph-1';
	var snippetSelector2 = '.snippetGraph-2';
	var snippetLabels = ['12/02', '13/02', '14/02', '15/02', '16/02', '17/02', '18/02', '19/02'];
	var snippetSeries = [[5, 9, 7, 8, 5, 3, 5, 4]];

	GraphUI.snippet.init(snippetSelector, snippetLabels, snippetSeries, 'categoryGraphTooltip1');
	GraphUI.snippet.init(snippetSelector2, snippetLabels, snippetSeries, 'categoryGraphTooltip1');
});
