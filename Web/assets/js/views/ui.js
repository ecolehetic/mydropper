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
		'$allPlusMinus' : $('.categoryElement').find('.plusMinus'),
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

		'checkActiveCategory' : function() {
			$('.categoryElement').each(function(){
				if($(this).hasClass('active')) {
					UI.nav.accordeonToggle($('.categoryName', this),false);
				}
			});
		},
		'accordeonToggle' : function(self, animation){
			var $snippetsList = self.siblings('ul');
			var $plusMinus = self.siblings('.plusMinus');

			if (!$snippetsList.is(":visible")) {
				// If Panel Closed
				if(animation) {
					UI.nav.$allSnippetsList.slideUp("slow");
					$snippetsList.slideDown("slow");
				} else {
					UI.nav.$allSnippetsList.hide();
					$snippetsList.show();
				}


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

	'flashMsg' : {
		'removeMsg' : function(el){
			el.removeClass('fadeInRight').addClass('fadeOutRight');
			setTimeout(function() {
				el.remove();
			}, 800);
		},
		'removeMsgTimeout' : function(time){
			setTimeout(function(){
			    UI.flashMsg.removeMsg($('#flashMsg').find('li'));
			},time);
		}
	},

	'popin' : {
		'el' : $( "#popin" ),
		'categoryContainer' : $( "#addCategoryFormContainer"),
		'snippetContainer' : $( "#addSnippetFormContainer"),
		'checkboxContainer' : $( '.checkboxContainer' ),
		'checkbox' : $('.checkbox'),

		'showCategoryPopin' : function(){
			UI.popin.el.fadeIn();
			UI.popin.categoryContainer.show();
			UI.popin.snippetContainer.hide();
		},
		'showSnippetPopin' : function(version, name){
			if(version === "add") {
				UI.popin.snippetContainer.find('h2').html('Add a snippet');
			} else {
				UI.popin.snippetContainer.find('h2').html('Edit ' + name +  ' snippet');

			}
			UI.popin.el.fadeIn();
			UI.popin.categoryContainer.hide();
			UI.popin.snippetContainer.show();
		},
		'closePopin' : function(){
			UI.popin.el.fadeOut();
		},
		'enableCheckbox' : function(){
			UI.popin.checkboxContainer.removeClass('disabled');
			UI.popin.checkbox.prop( "disabled", false );
		},
		'disableCheckbox' : function(){
			UI.popin.checkboxContainer.addClass('disabled');
			UI.popin.checkbox
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
		'$date' : $('#birthdayProfile').data('date'),

		'toggleEdition' : function() {
			if (UI.profile.$form.hasClass('disabled')) {
				UI.profile.$editmsg.html('Cancel');
				UI.profile.$form.addClass('enabled').removeClass('disabled');
				$('#editForm input').prop('disabled',false);
			}
			else {
				UI.profile.$editmsg.html('Edit profile');
				UI.profile.$form.addClass('disabled').removeClass ('enabled');
				UI.profile.$form.html(UI.profile.$htmlForm).promise().done (function () {
					UI.profile.$inputs.prop('disabled',true);
					console.log(UI.profile.$date);
					$('#birthdayProfile')
						.datepicker({ dateFormat: 'mm-dd-yy' })
						.datepicker("setDate", UI.profile.$date);
				});
			}
		}
	},

	'tracking' : {
		'initCategoryList' : function(categoryList){
			$('#categoryChoice').select3({
				items: categoryList,
				placeholder: categoryList[0].text
			});
		}
	}

};