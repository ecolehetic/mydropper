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
			}, 1000);
		},

		drop : {
			overFeedback : function(el) {
				el.addClass('md-dragOver');
			},
			leaveFeedback : function(el) {
				el.removeClass('md-dragOver');
			}
		},

		dragEndFeedback : function (){
			$('.md-dropElmt').removeClass('md-dragOver')
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
				"@font-face { font-family: 'icomoonMD'; src: url('"
				+ chrome.extension.getURL("fonts/Icomoon/icomoon.woff")
				+ "'); font-style: normal; font-weight:  400;} "
			document.head.appendChild (styleNode);
		}
	},

	user : {
		logIn: function() {
			$('#loggedInContainer').show().removeClass('hidden');
			$('#notLoggedInContainer').hide();
		}
	},

	loggedPanel : {
		renderSnippets : function(storesData){
			/* ---- TEMPLATING ---- */
			//console.log(storesData);
			for(var i = 0; i < storesData.length; i++) {
				var snippets = "";

				for(var j = 0; j < storesData[i].stores.length; j++) {
					var shorteredLink ="";
					if(storesData[i].stores[j].store_shorter) {
						shorteredLink ="data-link='" + storesData[i].stores[j].store_url_shorter + "'";
					}

					snippets +=
					"<li class='md-dragElmt' " + shorteredLink
					+ "data-text='"+ storesData[i].stores[j].store_description
					+ "' data-sid='"+ storesData[i].stores[j].store_id
					+ "' draggable='true' data-type='Text'><i class='MDIcon-tag'></i>"
					+ storesData[i].stores[j].store_label + "</li>"
				}

				var categoryHtml = "\
					<li class='category'><h2>" + storesData[i].category_label + "</h2>\
						<span>-</span>\
						<ul class='dragList'>\
							<li class='editCat'><a href='http://mydropper.mathieuletyrant.com/category/"+ storesData[i].category_id+"' target='_blank'><i class='MDIcon-list'></i></i>Edit category</a></li>"
								+ snippets +
						"</ul>\
					</li>";
				// Inject templates
				$('#accordeon').append(categoryHtml);
			}

			UI.sideBar.addMarkDropZones();
		},

		snippetNavigation : function(self) {
			var $navMenuParent = self.parent(),
				$navSous = self.siblings('.dragList'),
				$allNavSous = $('.category .dragList'),
				$allPlusMoins = $('.category  span');

			if (!$navSous.hasClass("open")) {
				// Si navSous fermé
				$allNavSous.removeClass('open');
				$navSous.addClass('open');
			} else {
				// Si navSous ouvert
				$allNavSous.removeClass('open');
			}
		},

		snippetInfos : {
			'displayInfo' : function(self) {
				var offset = self.offset(),
					el = $('#moreInfo')	;
				el.css('top', offset.top- $(document).scrollTop() + 5);
				if(self.data('link')) {
					el.stop().html(self.data('text') + ' (shortered)').fadeIn(600);
				} else {
					el.stop().html(self.data('text')).fadeIn(600);
				}
			},
			'removeInfo' : function() {
				$('#moreInfo').stop().fadeOut(1000);
			}
		}
	}
}
