"use strict";
$(document).ready(function() {

	// Generate date in good yyyymmdd
	Date.prototype.yyyymmdd = function() {
		var yyyy = this.getFullYear().toString();
		var mm = (this.getMonth()+1).toString(); // getMonth() is zero-based
		var dd  = this.getDate().toString();
		return yyyy + '-' + (mm[1]?mm:"0"+mm[0]) + '-' + (dd[1]?dd:"0"+dd[0]);
	};

	// Date variables
	var d = new Date(),
		from = "2015-01-01",
		to = d.yyyymmdd(),
		currentCat = '';

	console.log('TOOOOO' + to);

	/* ---- DROPDOWN LIST ---- */
	Model.tracking.getCategoryList(function(catList, catId){
		UI.tracking.initCategoryList(catList,catId);
		currentCat = catList[0].id;
		updateCharts(currentCat, from, to);
	});

	/* ---- ON CATEGORY CHANGE ---- */
	$('#categoryChoice').on('change', function(){
		currentCat = $(this).select3('value');
		console.log('value  ' + $(this).select3('value'));

		updateCharts(currentCat, from, to);
	});

	/* ---- SET DATEPICKERS ---- */
	$('.datepicker').datepicker({
		format    : 'yy-mm-dd',
		onSelect: function(selectedDate){
			onDateChange();
		}
	})

	$('#from').datepicker("setDate", '01/01/2015');
	$('#to').datepicker("setDate", new Date);

	/* ---- ON DATE CHANGE ---- */
	function onDateChange() {

		var fromTemp = $('#from').val().split('/');
		var toTemp = $('#to').val().split('/');

		from = fromTemp[2] + '-' + fromTemp[0] + '-' + fromTemp[1];
		to = toTemp[2] + '-' + toTemp[0] + '-' + toTemp[1];

		updateCharts(currentCat, from, to);

	}

	/* ---- RENDER CHARTS ---- */
	function updateCharts(cat, from, to) {

		/* ---- REMOVE PREVIOUS GRAPHS ---- */
		GraphUI.removeGraphs();
		GraphUI.removeTooltips();

		/* ---- CATEGORY CHART ---- */
		Model.tracking.getCategoryGraphData(cat, from, to, function(catLabels, catSeries){
			var catSelector = '.categoryGraph';
			GraphUI.category.render(catSelector, catLabels, catSeries);
		});

		/* ---- TRACKED LINK CHARTS ---- */
		Model.tracking.getTrackedLinkGraphData(cat, from, to, function(dataResponse){
			for(var i = 0; i < dataResponse.length; i++) {

				var currentData = dataResponse[i];

				var	graphSettings = {
					"nbClick" : currentData.nbClick,
					"createdAt" : currentData.createdAt,
					"since" : currentData.since,
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
