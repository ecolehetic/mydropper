"use strict";

var GraphUI = {

	'category' : {
		'render' : function(selector, importLabels, importSeries){
			new Chartist.Line(selector, {
				labels: importLabels,
				series: importSeries
			}, {
				low: 0,
				showArea: true
			});

			GraphUI.renderHoverInfos(selector, 'categoryGraphTooltip');
		}
	},

	'snippet' : {
		'render' : function(stg) {
			var htmlTemplate = "\
			<li>\
				<div class='snippetDetails'>\
					<div class='text'>\
						<h2>"+stg.snippetName+"</h2>\
						<p>Create at " + stg.createdAt + "</p>\
					</div>\
				</div>\
				<div class='graphContainer'>\
					<div class='clickRateGraphContainer'><span>"+
						stg.nbClick +"</span> clicks\
					</div>\
					<div class='snippetGraphContainer'>\
						<div class='snippetGraph "+ stg.snippetSelector +" ct-chart'></div>\
					</div>\
				</div>\
			</li>"
			$('#snippetGraphList').append(htmlTemplate);
			GraphUI.snippet.graphInit('.' + stg.snippetSelector, stg.snippetLabels, stg.snippetSeries, stg.graphTooltipId);
		},
		'graphInit' : function(selector, importLabels, importSeries, graphTooltipId){
			var data = {
				labels: importLabels,
				series: importSeries
			};

			var options = {
				seriesBarDistance: 10
			};

			new Chartist.Bar(selector, data, options);

			GraphUI.renderHoverInfos(selector, graphTooltipId);
		}
	},

	'clickRate' : {
		'render' : function(selector, importSeries){
			var data = {
				series: importSeries
			};

			var options = {
				donut: true,
				donutWidth: 20,
				total: 100,
				labelOffset: -30,
				labelInterpolationFnc: function(value) {
					return value + '%';
				}
			};

			new Chartist.Pie(selector, data, options);
		}
	},

	'removeTooltips' : function() {
		$('.graphTooltip').remove();
	},

	'renderHoverInfos' : function(selector, id) {
		var $graph = $(selector);

		var $toolTip = $graph
						.append("<div id='" + id + "' class='graphTooltip' ></div>")
						.find('#' + id)
						.hide();

		$graph.on('mouseenter', '.ct-point', function() {
			var $point = $(this),
				value = $point.attr('ct:value') + ' click(s)',
				seriesName = $point.parent().attr('ct:series-name');
			$toolTip.html(seriesName + '<br/>' + value).show();
		});

		$graph.on('mouseenter', '.ct-bar', function() {
			var $bar = $(this),
				value = $bar.attr('ct:value') + ' click(s)';
			$toolTip.html(value).show();
		});


		$graph.on('mouseleave', '.ct-point,.ct-bar', function() {
			$toolTip.hide();
		});

		$graph.on('mousemove', function(event) {
			$toolTip.css({
				position : 'absolute',
				left: (event.offsetX || event.originalEvent.layerX) - $toolTip.width() / 2 - 10,
				top: (event.offsetY || event.originalEvent.layerY) - $toolTip.height() - 20
			});
		});
	}
}


