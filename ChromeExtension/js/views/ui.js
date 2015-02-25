'use strict';


var UI={

    sideBar : {
		open : function(htmlContent) {
			var sideBarElmt = document.createElement('div');
			sideBarElmt.id = "myDropperSideBar";
			sideBarElmt.innerHTML = htmlContent;
			document.body.appendChild(sideBarElmt);
			sideBarElmt.style.display = 'block';
			sideBarElmt.classList.add('showBar');

			sideBar.isOpen = true;

			// --- Load logo
			$('#myDropperLogo').attr('src', chrome.extension.getURL("img/logo.png"));
		},


		close : function() {
			var el = $('#myDropperSideBar');

			// Add animation before remove the sideBar
			el.removeClass("showBar");
			el.addClass("hideBar");

			setTimeout(function() {
				// Remove the sideBar
				el.remove();
				sideBar.isOpen = false;
			}, 1000);
		},

		addMarkDropZones : function() {
			$('input').each(function() {
				if ($(this).attr('type') == "text" ||
					$(this).attr('type') == "email" ||
					$(this).attr('type') == "textarea" ||
					$(this).attr('type') == "number") {

					$(this).addClass('md-dropElmt');
					$(this).attr('data-accept-type', 'Text');
				}
			});
			$('textarea').each(function() {
				$(this).addClass('md-dropElmt');
				$(this).attr('data-accept-type', 'Text');
			});
		},


		removeMarkDropZones: function() {
			$('.md-dropElmt').removeClass('md-dropElmt');
		},


		initDraggable: function() {
			$(".md-dragElmt")
				.on('dragstart', function(event) {
					event.originalEvent.dataTransfer.setData($(this).data('type'), $(this).data('text'));
				})

				.on('dragend', function(event) {
					event.preventDefault();
					$('.md-dropElmt').removeClass('md-dragOver')
				});

			$(".md-dropElmt")
				.on('dragover', function(event) {
					//add preventDefault to stop default behaviour
					event.preventDefault();
					$(this).addClass('md-dragOver');
				})

				.on('dragleave', function(event) {
					//add preventDefault to stop default behaviour
					event.preventDefault();
					$(this).removeClass('md-dragOver');
				});
		},

		initDroppable: function() {
			$(".md-dropElmt").on('drop', function(event) {
				//restore the md-dropElmt after dropevent

				self = $(this);
				$('.md-dropElmt').css('opacity', 1);
				event.stopPropagation();$('#notLoggedInContainer').hide();
				event.preventDefault();

				self.attr('value',textData);

				//Check the Data Type accepted by the drop zone which got the drop event.
				if (self.closest('.md-dropElmt').attr('data-accept-type') == "Text") {
					var textData = event.originalEvent.dataTransfer.getData('Text');
					if (typeof textData == "undefined" || textData == "") {
						return;
					}
					self.attr('value', textData);
					
					if(self.prop("tagName")==="TEXTAREA"){
						self.html(textData);
					};
				}

				if (self.closest('.md-dropElmt').attr('data-accept-type') == "HTML") {
					var htmlData = event.originalEvent.dataTransfer.getData('HTML');
					if (typeof htmlData == "undefined" || htmlData == "") {
						return;
					}
					self.html(htmlData);
				}
			});
		},

		injectFonts : function() {
			var styleNode           = document.createElement ("style");
			styleNode.type          = "text/css";
			styleNode.textContent   =
				"@font-face { font-family: 'AvenirNext'; src: url('"
				+ chrome.extension.getURL("fonts/Avenir/Avenir-Next_10.woff")
				+ "'); font-style: normal; font-weight:  400;} " +
				"@font-face { font-family: 'AvenirNext'; src: url('"
				+ chrome.extension.getURL("fonts/Avenir/Avenir-Next_7.woff")
				+ "'); font-style: normal; font-weight:  700;} " +
				"@font-face { font-family: 'icomoon'; src: url('"
				+ chrome.extension.getURL("fonts/Icomoon/icomoon.woff")
				+ "'); font-style: normal; font-weight:  400;} "
			document.head.appendChild (styleNode);
		}
	},

	user : {
		logIn: function() {
			$('#loggedInContainer').show().removeClass('hidden');
			$('#notLoggedInContainer').hide();
		},

		logOut: function() {
			UI.sideBar.close();
		}
	},

	loggedPanel : {

		renderSnippets : function(storesData){
			/* ---- TEMPLATING ---- */

			for(var i = 0; i < storesData.length; i++) {
				var snippets = "";

				for(var j = 0; j < storesData[i].stores.length; j++) {
					snippets += "<li class='md-dragElmt' data-text='"+ storesData[i].stores[j].store_description +"' draggable='true' data-type='Text'><i class='icon-tag'></i>" + storesData[i].stores[j].store_label + "</li>"
				}

				var categoryHtml = "\
					<li class='category'><h2>" + storesData[i].category_label + "</h2>\
						<span>-</span>\
						<ul class='dragList'>\
							<li class='editCat'><a href='http://mydropper.mathieuletyrant.com/category/"+ storesData[i].category_id+"' target='_blank'><i class='icon-list'></i></i>Edit category</a></li>"
								+ snippets +
						"</ul>\
					</li>";
				// Inject templates
				$('#accordeon').append(categoryHtml);
			}

			UI.loggedPanel.initAccordeon();
			UI.loggedPanel.snippetInfos();
			UI.sideBar.addMarkDropZones();
			UI.sideBar.initDroppable();
			UI.sideBar.initDraggable();
		},

		initAccordeon : function() {
			var $catLink = $('#accordeon .category h2');
			var $dragList = $('#accordeon .category .dragList');

			$catLink.click(function(e) {
				e.preventDefault();

				var $navMenuParent = $(this).parent();
				var $navSous = $(this).siblings('.dragList');
				var $allNavSous = $('.category .dragList');
				var $plusMoins = $(this).siblings('span');
				var $allPlusMoins = $('.category  span');


				if (!$navSous.hasClass("open")) {
					// Si navSous fermé
					$allNavSous.removeClass('open');
					$navSous.addClass('open');

					$allPlusMoins.html('+');
					$plusMoins.html('-');

				} else {
					// Si navSous ouvert
					$allNavSous.removeClass('open');
					$allPlusMoins.html('+');
				}
			});
		},

		snippetInfos : function() {
			$('.md-dragElmt').hover(
				function() {
					var offset = $(this).offset(),
						el = $('#moreInfo');
					el.css('top', offset.top- $(document).scrollTop() + 5);
					el.stop().html($(this).data('text')).fadeIn(600);
				}, function() {
					$('#moreInfo').stop().fadeOut(1000);
				}
			);
		}
	}
}
