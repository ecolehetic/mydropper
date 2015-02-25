'use strict'

var Model;

Model = {

	getDataUser : function(callback) {
		chrome.storage.local.get('myDropperUser', function(chromeData){
			callback.call(this, chromeData.myDropperUser);
		});
	},

	getUserSnippets : function(callback) {
		Model.getDataUser(function(data) {
			$.post("http://localhost:8080/api/stores", {user_id: data.user.id, token_id: data.user.token_api}, "json")
				.done(function(response) {
					callback.call(this,response);
				}).fail(function(response) {
					callback.call(this,false);
				});
		});
	},

	sendDropData : function(storeId, onUrl, fullUrl){
		console.log(storeId + '  ' +  onUrl + '   ' + fullUrl);

		chrome.storage.local.get('myDropperUser', function(chromeData){
			var data = chromeData.myDropperUser;

			$.post("http://localhost:8080/api/trackstore", {
				user_id: data.user.id,
				token_id: data.user.token_api,
				store_id: storeId,
				on_url: onUrl,
				full_url : fullUrl
			}, "json")
				.done(function(response) {
					console.log('Drop data send : success');
				}).fail(function(response) {
					console.log('Drop data send to server : fail');
				});
		});
	},


	logIn : function(usr, pwd, callback) {
		$.post("http://localhost:8080/api/connect", {username: usr, password: pwd}, "json")
			.done(function(response) {
				if(response.success) {
					chrome.storage.local.set({'myDropperUser': response}, function() {
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