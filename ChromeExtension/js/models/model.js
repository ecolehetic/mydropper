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
			$.post("http://mydropper.mathieuletyrant.com/api/stores", {user_id: data.user.id, token_id: data.user.token_api}, "json")
				.done(function(response) {
					console.log(response);
					for(var i = 0; i < response.length; i++) {
						for(var j = 0; j < response[i].stores.length; j++) {
							// Replace quote and double quote by /
							var desc = response[i].stores[j].store_description;
							desc = desc.split('"').join('/');
							desc = desc.split("'").join('/');
							response[i].stores[j].store_description = desc;
						}
					}
					console.log(response);
					callback.call(this,response);
				}).fail(function(response) {
					callback.call(this,false);
				});
		});
	},

	sendDropData : function(storeId, onUrl, fullUrl){

		chrome.storage.local.get('myDropperUser', function(chromeData){
			var data = chromeData.myDropperUser;

			$.post("http://mydropper.mathieuletyrant.com/api/trackstore", {
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
		$.post("http://mydropper.mathieuletyrant.com/api/connect", {username: usr, password: pwd}, "json")
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