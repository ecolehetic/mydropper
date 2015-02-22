"use strict";
$(document).ready(function() {

	/* ---- DROPDOWN LIST ---- */
	Model.tracking.getCategoryList(function(catList){
		UI.tracking.initCategoryList(catList);
		updateCharts(catList[0]);
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

		/* ---- TRACKED LINK CHARTS ---- */
		Model.tracking.getTrackedLinkGraphData(function(clickRateSeries,snippetLabels, snippetSeries){
			for(var i = 1; i <= 2; i++) {
				var clickRateSelector = '.clickRateGraph-' + i;
				var snippetSelector = '.snippetGraph-' + i;

				GraphUI.clickRate.init(clickRateSelector, clickRateSeries);
				GraphUI.snippet.init(snippetSelector, snippetLabels, snippetSeries, 'categoryGraphTooltip' + i);
			}
		});

	}
});
