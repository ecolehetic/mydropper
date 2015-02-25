'use strict';






/* ----- Handle requests from background.html ----- */
chrome.extension.onRequest.addListener(handleRequest);

function handleRequest(request, sender, sendResponse) {
    if (request.callFunction == "toggleSidebar") {
		Ext.toggleSideBar(request.sideBarContent);
		Ext.init();
    }
};


var Panel = {
	isOpen : false
};

var Ext = {
	'init' : function() {

		/* ---- Inject fonts ---- */
		UI.sideBar.injectFonts();

		/* ---- LogIn ---- */
		$('#submitConnexionForm').click(function(e){
			Ext.submitLoginRequest();
		});

		$('input').on('keyup', function(e){
			e.preventDefault();
			if(e.which == 13) {
				Ext.submitLoginRequest();
				$(this).blur();
			}
		});


		/* ---- Check if user already logged in ---- */
		Model.getDataUser(function(userData){
			//console.log(userData);
			if(typeof userData != 'undefined') {
				Model.getUserSnippets(function(storesData){
					UI.loggedPanel.renderSnippets(storesData);
					UI.user.logIn();

					Ext.loggedPanel.init();
				});
			}
		})

		/* ---- Click on cross ---- */
		$("#closePanelButton").on('click', function(e){
			e.preventDefault();
			Ext.toggleSideBar();
			Panel.isOpen = false;
		});

		/* ---- LogOut ---- */
		$('#logOut').on('click', function(e){
			e.preventDefault();
			Panel.isOpen = false;
			UI.sideBar.close();
			Model.logOut();
		});
	},

	toggleSideBar : function(htmlContent) {
		if(Panel.isOpen) {
			UI.sideBar.close();
			UI.sideBar.removeMarkDropZones();
			Panel.isOpen = false;
		}
		else {
			UI.sideBar.open(htmlContent);
			Panel.isOpen = true;
		}
	},

	submitLoginRequest : function() {
		var username = $('#username').val();
		var password = $('#password').val();
		Model.logIn(username, password, function(response){
			if(response.success === true) {
				Model.getUserSnippets(function(storesData){
					UI.loggedPanel.renderSnippets(storesData);
					UI.user.logIn();

					Ext.loggedPanel.init();
				});
			}
			else if(response.success === false) {
				alert(response.message);
			}
			else {
				alert('Username / Password not correct.\nPlease try again');
			}
		})
	},

	loggedPanel : {
		init : function() {
			Ext.loggedPanel.initAccordeon();
			Ext.loggedPanel.initDroppable();
			Ext.loggedPanel.initDraggable();
			Ext.loggedPanel.initSnippetInfos();

		},
		initDraggable : function() {
			$(".md-dragElmt")
				.on('dragstart', function(event) {
					var self = $(this);
					// Add shortered link instead of description if it's a tracked link

					if(self.data('link')) {
						event.originalEvent.dataTransfer.setData(self.data('type'), self.data('link'));
					}
					else {
						event.originalEvent.dataTransfer.setData(self.data('type'), self.data('text'));
					}

					// Send the storeID for history
					event.originalEvent.dataTransfer.setData('storeid', self.data('storeid'))
				})

				.on('dragend', function(event) {
					event.preventDefault();
					UI.sideBar.dragEndFeedback();
				});

			$(".md-dropElmt")
				.on('dragover', function(event) {
					//add preventDefault to stop default behaviour
					event.preventDefault();
					UI.sideBar.drop.overFeedback($(this));
				})

				.on('dragleave', function(event) {
					//add preventDefault to stop default behaviour
					event.preventDefault();
					UI.sideBar.drop.leaveFeedback($(this));
				});
			},

		initDroppable : function() {
			$(".md-dropElmt").on('drop', function(event) {

				event.stopPropagation();
				event.preventDefault();

				var self = $(this),
					pageTitle = window.location.hostname,
					pageUrl = document.URL,
					storeId = event.originalEvent.dataTransfer.getData('storeid');

				//restore the md-dropElmt after dropevent
				$('.md-dropElmt').css('opacity', 1);

				//Check the Data Type accepted by the drop zone which got the drop event.
				if (self.closest('.md-dropElmt').attr('data-accept-type') == "Text") {
					var dropData = event.originalEvent.dataTransfer.getData('Text');

					if (typeof dropData == "undefined" || dropData == "") {
						return;
					}
					// Insert drop content
					self.attr('value', dropData);

					if(self.prop("tagName")==="TEXTAREA"){
						// Insert drop content for text area
						self.html(dropData);
					};
				}

				// If we want to drop html content
				if (self.closest('.md-dropElmt').attr('data-accept-type') == "HTML") {
					var htmlData = event.originalEvent.dataTransfer.getData('HTML');
					if (typeof htmlData == "undefined" || htmlData == "") {
						return;
					}
					self.html(htmlData);
				}

				Model.sendDropData(storeId ,pageTitle,pageUrl);

			});
		},

		initSnippetInfos : function(){
			$('.md-dragElmt').hover(
				function() {
					UI.loggedPanel.snippetInfos.displayInfo($(this));
				}, function() {
					UI.loggedPanel.snippetInfos.removeInfo();
				}
			);
		},

		initAccordeon : function() {
			var $catLink = $('#accordeon .category h2');
			var $dragList = $('#accordeon .category .dragList');
			$catLink.on('click', function(e) {
				e.preventDefault();
				UI.loggedPanel.snippetNavigation($(this));
			});
		}
	}

};