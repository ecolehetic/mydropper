'use strict';


var UI={

    openSideBar: function(htmlContent) {
        var sideBarElmt = document.createElement('div');
        sideBarElmt.id = "myDropperSideBar";
        sideBarElmt.innerHTML = htmlContent;
        document.body.appendChild(sideBarElmt);
        sideBarElmt.style.display = 'block';
        sideBarElmt.classList.add('showBar');

        sideBar.isOpen = true;
		$('#logo').find('img').attr('src', chrome.extension.getURL('img/logo.png'));
    },


    closeSideBar: function() {
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


    addMarkDropZones: function() {
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
            $('.md-dropElmt').css('opacity', 1);
            event.stopPropagation();$('#notLoggedInContainer').hide();
            event.preventDefault();
            
            $(this).attr('value',textData);

            //Check the Data Type accepted by the drop zone which got the drop event.
            if ($(this).closest('.md-dropElmt').attr('data-accept-type') == "Text") {
                var textData = event.originalEvent.dataTransfer.getData('Text');
                if (typeof textData == "undefined" || textData == "") {
                    return;
                }
                $(this).attr('value', textData);
            }
            if ($(this).closest('.md-dropElmt').attr('data-accept-type') == "HTML") {
                var htmlData = event.originalEvent.dataTransfer.getData('HTML');
                if (typeof htmlData == "undefined" || htmlData == "") {
                    return;
                }
                $(this).html(htmlData);
            }
        });
    },

    logIn: function() {
        $('#loggedInContainer').show().removeClass('hidden');
        $('#notLoggedInContainer').hide();
    },

    logOut: function() {
        UI.closeSideBar();
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

}
