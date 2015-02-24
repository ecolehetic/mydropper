'use strict'

var Model = {
	logIn : function(usr, pwd, callback){
		$.post( "http://mydropper.mathieuletyrant.com/api/connect", { username : usr, password : pwd }, "json")
			.done(function(response) {
				if(response.success){
					localStorage.setItem("myDropperUser", JSON.stringify(response));
				}else {
					alert(response.message);
				}

			})
			.fail(function(response){
				alert('Username / Password not correct.\nPlease try again')
			});

		callback.call(this);
	},

	LS : {

	}
}