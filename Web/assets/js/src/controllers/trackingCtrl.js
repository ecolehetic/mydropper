"use strict";
$(document).ready(function() {
    // Load users data
    API.start();

	// Reformat date in yyyymmdd
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

	/* ---- DROPDOWN LIST ---- */
	API.tracking.getCategoryList(function(catList, catId){
		UI.tracking.initCategoryList(catList,catId);
		currentCat = catList[0].id;
		updateCharts(currentCat, from, to);
	});

	/* ---- ON CATEGORY CHANGE ---- */
	$('#categoryChoice').on('change', function(){
		currentCat = $(this).select3('value');
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
		API.tracking.getCategoryGraphData(cat, from, to, function(catLabels, catSeries){
			var catSelector = '.categoryGraph';
			if(catLabels[0]=="N/A") {
				GraphUI.category.noData();
			} else {
				GraphUI.category.render(catSelector, catLabels, catSeries);
			}
		});

		/* ---- TRACKED LINK CHARTS ---- */
		API.tracking.getTrackedLinkGraphData(cat, from, to, function(dataResponse){
			if(dataResponse.length>0) {
				for(var i = 0; i < dataResponse.length; i++) {

					var currentData = dataResponse[i];

					var graphSettings = {
						"nbClick"        : currentData.nbClick,
						"createdAt"      : currentData.createdAt,
						"since"          : currentData.since,
						"snippetName"    : currentData.snippetName,
						"snippetSelector": "snippetGraph-" + (i + 1),
						"graphTooltipId" : "snippetTooltip-" + (i + 1),
						"snippetLabels"  : Object.keys(currentData.graphData),
						"snippetSeries"  : [[]]
					};

					if(graphSettings.snippetLabels.length>0) {
						// Insert snippetSeries in chartist format
						for(var j = 0; j < graphSettings.snippetLabels.length; j++) {
							graphSettings.snippetSeries[0].push(currentData.graphData[graphSettings.snippetLabels[j]]);
						}
					} else {
						graphSettings.snippetLabels = ['N/A'];
						graphSettings.snippetSeries[0].push(0);
					}

					GraphUI.snippet.render(graphSettings);
				}
			}

		});

	}


});
