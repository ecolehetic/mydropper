$(document).ready(function(){

	// Burger 
	var burgerTrigger = false;

	$('#burger').click(function(){
	  if(!burgerTrigger){
		  $('#row3').stop().transition({rotate: "45", "margin-top": "13px"});
		  $('#row2').stop().transition({opacity: "0"}, "fast");
		  $('#row1').stop().transition({rotate: "-45", "margin-top": "13px"});
		    burgerTrigger = true;
		    $('#burger').addClass('open');
		    $('nav')
		    	.css('marginLeft', '-300px')
		    	.show();
		    setTimeout(function(){
		    	$('nav').addClass('left');
		    }, 300)
	  }
	  else{
		  $('#row3').stop().transition({rotate: "+=135", "margin-top": "3px"});
		  $('#row2').transition({opacity: "1"}, "fast");
		  $('#row1').stop().transition({rotate: "-=135", "margin-top": "23px"});
		  burgerTrigger = false;
		  $('#burger').removeClass('open');
		  $('nav').removeClass('left');
		  setTimeout(function(){
		  	$('nav').hide()
			  	.removeAttr('style')
			  	.removeClass('left');
		  }, 500);
	  }
	});
	// Catégory Accordeon
	var $catLink = $('.categoryElement a');
	var $allPlusMinus = $('.categoryElement span');
	var $allSnippetsList = $('.snippetsList');

	$catLink.click(function(e){
		e.preventDefault();
		var $cat = $(this).parent();
		var $snippetsList = $(this).siblings('ul');
		var $plusMinus = $(this).siblings('span');

		if(!$snippetsList.is(":visible")) {
			// If Closed
			$allSnippetsList.slideUp("slow");
			$snippetsList.slideDown("slow");

			$allPlusMinus.html('+');
			$plusMinus.html('-');

		} else {
			// If Opened
			$allSnippetsList.slideUp("slow");
			$allPlusMinus.html('+');
			
		}
	});

});