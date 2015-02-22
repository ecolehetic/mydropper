"use strict";
$(document).ready(function() {

	// Date variables
	var from = "01-01-2015",
		to = new Date();

	/* ---- DROPDOWN LIST ---- */
	Model.tracking.getCategoryList(function(catList){
		UI.tracking.initCategoryList(catList);
		updateCharts(catList[0], from, to);
	});

	/* ---- ON CATEGORY CHANGE ---- */
	$('#categoryChoice').on('select3-selected', function(){
		updateCharts($(this).select3('value'));
	});

	/* ---- SET DATEPICKERS ---- */
	$('.datepicker').datepicker({
		dateFormat: 'mm-dd-yy',
		onSelect: function(selectedDate){
			onDateChange();
		}
	});
	$('#from').datepicker("setDate", from);
	$("#to").datepicker("setDate", to);

	/* ---- ON DATE CHANGE ---- */
	function onDateChange() {
		from = $('#from').val();
		to = $('#to').val();
		updateCharts(catList[0], from, to);
	}

	/* ---- RENDER CHARTS ---- */
	function updateCharts(currentCategory, from, to) {

		/* ---- PREVENT PREVIOUS TOOLTIPS ---- */
		GraphUI.removeTooltips();

		/* ---- CATEGORY CHART ---- */
		Model.tracking.getCategoryGraphData(from, to, function(catLabels, catSeries){
			var catSelector = '.categoryGraph';
			GraphUI.category.render(catSelector, catLabels, catSeries);
		});

		/* ---- TRACKED LINK CHARTS ---- */
		Model.tracking.getTrackedLinkGraphData(from, to, function(categoryName, dataResponse){
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
