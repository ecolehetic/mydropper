'use strict'

var Model;
Model = {
	logIn : function(usr, pwd, callback) {
		$.post("https://mydropper.mathieuletyrant.com/api/connect", {username: usr, password: pwd}, "json")
			.done(function(response) {
				callback.call(this,response);
			})
			.fail(function(response) {
				callback.call(this);
			});
	},

	LS : {
		userData : JSON.parse(localStorage.getItem( 'myDropperUser' )),

		set : function(name, json) {
			localStorage.setItem(name, JSON.stringify(json));
		}
	}
};