'use strict'

var Model;

Model = {

	getDataUser : function(callback) {
		chrome.storage.local.get('myDropperUser', function(chromeData){
			callback.call(this, chromeData.myDropperUser);
		});
	},

	logIn : function(usr, pwd, callback) {
		$.post("http://localhost:8080/api/connect", {username: usr, password: pwd}, "json")
			.done(function(response) {
				if(response.success) {
					chrome.storage.local.set({'myDropperUser': response}, function() {
						Model.getDataUser(function(data){
							console.log('SET := ', data);
						})
					});
				}
				callback.call(this,response);
			})
			.fail(function(response) {
				callback.call(this);
			});
	},

	logOut : function() {
		chrome.storage.local.clear(function(){
			console.log('My dropper user logged out');
		});
	}


};