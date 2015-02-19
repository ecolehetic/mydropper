'use strict';

var UI = {
	'$w' : $(window),

	'initSize' : function() {
		var widthPage = $(window).innerWidth();
		// Header Left Part
		UI.dashboard.$headerRight.innerWidth(widthPage - UI.nav.$searchBar.innerWidth() - 20);

		// Container

		if (UI.$w.innerWidth() > 850) {
			UI.dashboard.$container
				.css({
					'width': widthPage - UI.dashboard.$sideBar.innerWidth(),
					'left': UI.dashboard.$sideBar.innerWidth()
				})
				.removeClass('containerLeft');

			UI.nav.closeBurgerMenu();
		} else {
			UI.dashboard.$container.removeAttr('style');
			if (!UI.nav.burgerTrigger) {
				$('#burger').find('div').removeAttr('style');
			}
		}
	},

	'nav' : {
		'burgerTrigger' : false,
		'$searchBar' : $('#searchBar'),
		'$burger' : $('#burger'),
		'$catLink' : $('.categoryElement').find('a'),
		'$allPlusMinus' : $('.categoryElement').find('span'),
		'$allSnippetsList' : $('.snippetsList'),

		'openBurgerMenu' : function() {
			UI.nav.burgerTrigger = true;

			UI.nav.$burger.addClass('burgerOpen');
			UI.dashboard.$container.addClass('containerLeft');
			UI.dashboard.$sideBar
				.css('marginLeft', '-250px')
				.show();

			setTimeout(function() {
				UI.dashboard.$sideBar.addClass('sideBarLeft');
			}, 1)
		},

		'closeBurgerMenu' : function() {
			UI.nav.burgerTrigger = false;

			UI.nav.$burger.removeClass('burgerOpen');
			UI.dashboard.$sideBar.removeClass('sideBarLeft');
			UI.dashboard.$container.removeClass('containerLeft');

			setTimeout(function() {
				UI.dashboard.$sideBar.hide()
					.removeAttr('style')
					.removeClass('sideBarLeft');
			}, 700);
		},

		'accordeonToggle' : function(self){
			var $snippetsList = self.siblings('ul');
			var $plusMinus = self.siblings('span');

			if (!$snippetsList.is(":visible")) {
				// If Panel Closed
				UI.nav.$allSnippetsList.slideUp("slow");
				$snippetsList.slideDown("slow");

				UI.nav.$allPlusMinus.html('+');
				$plusMinus.html('-');

			} else {
				// If Panel Opened

				UI.nav.$allSnippetsList.slideUp("slow");
				UI.nav.$allPlusMinus.html('+');

			}
		}
	},

	'dashboard' : {
		'$sideBar' : $('#sideBar'),
		'$headerRight' : $('.headerContent'),
		'$container' : $('.container')
	},

	'popin' : {
		'el' : $( "#popin" ),
		'categoryContainer' : $( "#addCategoryFormContainer"),
		'snippetContainer' : $( "#addSnippetFormContainer"),
		'urlCheckboxContainer' : $( '#urlCheckbox' ),
		'urlCheckbox' : $( '#urlCheckbox').find('input'),

		'showAddCategory' : function(){
			UI.popin.el.fadeIn();
			UI.popin.categoryContainer.show();
			UI.popin.snippetContainer.hide();
		},
		'showAddSnippet' : function(){
			UI.popin.el.fadeIn();
			UI.popin.categoryContainer.hide();
			UI.popin.snippetContainer.show();
		},
		'closePopin' : function(){
			UI.popin.el.fadeOut();
		},
		'enableCheckbox' : function(){
			UI.popin.urlCheckboxContainer.removeClass('disabled');
			UI.popin.urlCheckbox.prop( "disabled", false );
		},
		'disableCheckbox' : function(){
			UI.popin.urlCheckboxContainer.addClass('disabled');
			UI.popin.urlCheckbox
				.prop( "disabled", true)
				.prop( "checked", false);
		}
	},

	'profile' : {
		'$menu' : $('#profileMenu'),
		'$form' : $('#editForm'),
		'$editmsg' : $('#editButton span'),
		'$inputs' : $('#editForm input'),
		'$htmlForm' : $('#editForm').html(),

		'toggleEdition' : function() {
			if (UI.profile.$form.hasClass('disabled')) {
				UI.profile.$editmsg.html('Cancel');
				UI.profile.$form.addClass('enabled').removeClass('disabled');
				$('#editForm input').prop('disabled',false);
			}
			else {
				UI.profile.$editmsg.html('Edit profile');
				UI.profile.$form.addClass('disabled').removeClass ('enabled');
				UI.profile.$form.html(UI.profile.$htmlForm).promise ().done (function () {
					UI.profile.$inputs.prop('disabled',true);
				});
			}
		}
	},

	'tracking' : {
		'toggleTabs' : function(self) {
			$('#tabs').find('li').removeClass('selected');
			self.addClass('selected');
		}
	}

};

console.log(UI);