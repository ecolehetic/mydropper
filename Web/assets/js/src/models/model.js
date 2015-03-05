"use strict";
var Model = {

	'LS' : {
		set : function(item,value) {
			localStorage.setItem(item, JSON.stringify(value));
		},
		'get' : function(item) {
			return JSON.parse(localStorage.getItem(('tpTest')));
		},

		tpTest : function(callback) {
			// Check if tooltip object is in LS
			if(!localStorage.getItem('tpTest')) {
				var tpTest= {
					tooltipHistory : false,
					tooltipTracking : false,
					tooltipCategory : false
				}
				Model.LS.set('tpTest', tpTest);
			}
			
			// Return the object store in LS
			callback.call(this, Model.LS.get('tpTest'));
		}

	}
};