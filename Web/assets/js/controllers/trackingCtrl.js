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

		/* ---- PREVENT PREVIOUS TOOLTIPS ---- */
		GraphUI.removeTooltips();



		/* ---- CATEGORY CHART ---- */
		Model.tracking.getCategoryGraphData(function(catLabels, catSeries){
			var catSelector = '.categoryGraph';
			GraphUI.category.render(catSelector, catLabels, catSeries);
		});



		/* ---- TRACKED LINK CHARTS ---- */
		Model.tracking.getTrackedLinkGraphData(function(categoryName, dataResponse){
			for(var i = 0; i < dataResponse.length; i++) {

					var currentData = dataResponse[i];

					var	graphSettings = {
						"nbClick" : currentData.nbClick,
						"createdAt" : currentData.createdAt,
						"snippetName" : currentData.snippetName,
						"snippetSelector" : "snippetGraph-" + (i+1),
						"graphTooltipId" : "snippetTooltip-" + (i+1),
						"snippetLabels" : Object.keys(currentData.graphData ),
						"snippetSeries" : [[]]
					};
				
					// Insert snippetSeries in chartist format
					for(var j = 0; j < graphSettings.snippetLabels.length; j++) {
						graphSettings.snippetSeries[0].push(currentData.graphData[graphSettings.snippetLabels[j]]);
					}
					GraphUI.snippet.render(graphSettings);
			}
		});

	}
});
