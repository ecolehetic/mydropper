"use strict";

$(document).ready(function() {

	/* ---- DROPDOWN LIST ---- */
	Model.tracking.getCategoryList(function(categoryList){
		UI.tracking.initCategoryList(categoryList);
		updateCharts(categoryList[0]);
	});

	/* ---- ON CATEGORY CHANGE ---- */

	$('#categoryChoice').on('select3-selected', function(){
		updateCharts($(this).select3('value'));
	});

	/* RENDER CHARTS */
	function updateCharts(currentCategory) {
		console.log('Category load :' + currentCategory);

		/* ---- PREVENT PREVIOUS TOOLTIPS ---- */
		GraphUI.removeTooltips();

		/* ---- CATEGORY CHART ---- */
		Model.tracking.getCategoryGraphData(function(catLabels, catSeries){
			var catSelector = '.categoryGraph';
			GraphUI.category.init(catSelector, catLabels, catSeries);
		});

		/* ---- CLICK RATE CHART ---- */
		Model.tracking.getClickRateGraphData(function(clickRateSeries){
			var clickRateSelector = '.clickRateGraph-1';
			var clickRateSelector2 = '.clickRateGraph-2';
			GraphUI.clickRate.init(clickRateSelector, clickRateSeries);
			GraphUI.clickRate.init(clickRateSelector2, clickRateSeries);
		});

		/* ---- SNIPPET GRAPH---- */
		Model.tracking.getSnippetGraphData(function(snippetLabels, snippetSeries){
			var snippetSelector = '.snippetGraph-1';
			var snippetSelector2 = '.snippetGraph-2';
			GraphUI.snippet.init(snippetSelector, snippetLabels, snippetSeries, 'categoryGraphTooltip1');
			GraphUI.snippet.init(snippetSelector2, snippetLabels, snippetSeries, 'categoryGraphTooltip1');
		})
	}
});
