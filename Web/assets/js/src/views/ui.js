'use strict';

var UI = {
	'$w' : $(window),

	'renderSize' : function() {
		var widthPage = $(window).innerWidth();

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

		'openBurgerMenu' : function() {
			UI.nav.burgerTrigger = true;

			$('#burger').addClass('burgerOpen');
			UI.dashboard.$container.addClass('containerLeft');
			UI.dashboard.$sideBar
				.css('marginLeft', '-250px')
				.show();

			setTimeout(function() {
				UI.dashboard.$sideBar.addClass('sideBarLeft');
				UI.profile.$container.addClass('profileOut');
			}, 100)
		},

		'closeBurgerMenu' : function() {
			UI.nav.burgerTrigger = false;

			$('#burger').removeClass('burgerOpen');
			UI.dashboard.$sideBar.removeClass('sideBarLeft');
			UI.dashboard.$container.removeClass('containerLeft');
			UI.profile.$container.removeClass('profileOut');
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
			var $snippetsList = self.siblings('ul'),
				$plusMinus = self.siblings('.plusMinus'),
				$allSnippetsList = $('.snippetsList'),
				$allPlusMinus = $('.categoryElement').find('.plusMinus');

			if (!$snippetsList.is(":visible")) {
				// If Panel Closed
				if(animation) {
					$allSnippetsList.slideUp("slow");
					$snippetsList.slideDown("slow");
				} else {
					$allSnippetsList.hide();
					$snippetsList.show();
				}

				$allPlusMinus.html('+');
				$plusMinus.html('-');

			} else {
				// If Panel Opened

				$allSnippetsList.slideUp("slow");
				$allPlusMinus.html('+');

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
		'$el' : $( "#popin" ),
		'$categoryContainer' : $( "#addCategoryFormContainer"),
		'$snippetContainer' : $( "#addSnippetFormContainer"),
		'$checkboxContainer' : $( '.checkboxContainer' ),
		'$checkbox' : $('.checkbox'),

		'showCategoryPopin' : function(){
			UI.popin.$el.fadeIn();
			UI.popin.$categoryContainer.show();
			UI.popin.$snippetContainer.hide();
		},
		'showSnippetPopin' : function(version, name){
			if(version === "add") {
				UI.popin.$snippetContainer.find('h2').html('Add a snippet');
			} else {
				UI.popin.$snippetContainer.find('h2').html('Edit ' + name +  ' snippet');

			}
			UI.popin.$el.fadeIn();
			UI.popin.$categoryContainer.hide();
			UI.popin.$snippetContainer.show();
		},
		'closePopin' : function(){
			UI.popin.$el.fadeOut();
		},
		'enableCheckbox' : function(){
			UI.popin.$checkboxContainer.removeClass('disabled');
			UI.popin.$checkbox.prop( "disabled", false );
		},
		'disableCheckbox' : function(){
			UI.popin.$checkboxContainer.addClass('disabled');
			UI.popin.$checkbox
				.prop( "disabled", true)
				.prop( "checked", false);
		}
	},

	'profile' : {
		'$container' : $('#profile'),
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
				// Reset info in profile
				UI.profile.$form.html(UI.profile.$htmlForm).promise().done (function () {
					//Disabled inpts when edition cancel
					UI.profile.$inputs.prop('disabled',true);
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
	},

	'tooltips' : {
		'render' : function(tpTest){
			var tpPos = UI.tooltips.getPosition();
			
			for(var tp in tpPos) {
				if(!tpTest[tp]){
					$('#' + tp).show().css('top', tpPos[tp].top - $(document).scrollTop()+ 20);
				}
			}
		},

		'show' : function(self) {

			var offset = self.offset(),
				$content = $('#tooltipsContent');

			$content.animate({
				top : offset.top-20,
				left : offset.left+40
			},300)

			$content
				.fadeIn()
				.data('current',self.attr('id'));

			switch(self.attr('id')){
				case 'tooltipHistory':
					$content.find('.nextTooltip').data('next','tooltipTracking').show();
					if(!$('#tooltipTracking').is(':visible')) {
						$content.find('.nextTooltip').hide();
					}
					$content.find('p').html('When you drag and drop a snippet from your My Dropper extension to a website, it will be added to your history.' +
					'This page will be filled as you start using the My Dropper extension designed for Google Chrome.');
					break;

				case 'tooltipTracking' :
					$content.find('.nextTooltip').data('next','tooltipCategory').show();
					if(!$('#tooltipCategory').is(':visible')) {
						$content.find('.nextTooltip').hide();
					}
					$content.find('p').html('You want to know who uses your data ? ' +
					'Thanks to the Tracking feature, you will know exactly how many times your links have been clicked and evalute the visibility of your links.');
					break;

				case 'tooltipCategory' :
					$content.find('.nextTooltip').hide();
					$content.find('p').html('Your can gather all your snippets together in a cateogry, ' +
					'to get an easy and quick access to your informations once you have activated the My Dropper extension for Chrome.');
					break;
			}

		},

		'next' : function(self) {
			$('#'+ self.parent().data('current')).fadeOut();
			UI.tooltips.show($('#' + self.data('next')));

		},

		'close' : function(self) {
			$('#tooltipsContent').fadeOut();
			$('#'+ self.parent().data('current')).fadeOut();

		},
 		'getPosition' : function() {
			var tpPos = [];

			$('.tooltipsCircle').each(function(){
				var el = $(this);
				var elId = el.attr('id');
				if (el.data('ref')==='categoryElement') {
					tpPos[elId] = $('.categoryElement:first-child').offset();
				} else {
					tpPos[elId] = $('#' + el.data('ref')).offset();
				}
			});

			return tpPos;
		}
	}

};