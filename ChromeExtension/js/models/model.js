'use strict'

var Model = {
	logIn : function(usr, pwd, callback){
		$.post( "http://mydropper.mathieuletyrant.com/api/connect", { username : usr, password : pwd }, "json")
			.done(function(response) {
				console.log(response);
			})
			.fail(function(){
				alert('Username / Password not correct.\nPlease try again')
			});

		callback.call(this);
	},

	LS : {

	}
}