'use strict';

var UI={

    openSideBar: function(htmlContent) {
        var sideBarElmt = document.createElement('div');
        sideBarElmt.id = "myDropperSideBar";
        sideBarElmt.innerHTML = htmlContent;
        document.body.appendChild(sideBarElmt);

        // $('#myDropperSideBar').css({
        //     'position': 'fixed',
        //     'top': '0px',
        //     'right': '0px',
        //     'max-width': '300px',
        //     'width': '300px',
        //     'overflow-x': 'visible',
        //     'overflow-y': 'auto',
        //     'height': '100%',
        //     'background': '#FFFFFF',
        //     'z-index': '99999999999999',
        //     'display': 'none',
        //     'font-family': 'helvetica, arial',
        //     'color': '#212121',
        //     'border-left': '1px solid #727272'
        // });

        sideBarElmt.style.display = 'block';

        sideBarElmt.classList.add('showBar');

        sideBar.isOpen = true;

    },


    closeSideBar: function() {

        var el = document.getElementById('myDropperSideBar');

        // Add animation before kill the element
        el.classList.remove("showBar");
        el.classList.add("hideBar");

        setTimeout(function() {
            // Kill the element
            el.parentNode.removeChild(el);
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
                // $allNavSous.removeAttr('style');
                $allNavSous.removeClass('open');
                $navSous.addClass('open');
                // $navSous.animate({
                //     'display' : 'block',
                //     'height': 'auto',
                //     'max-height' : '1500px',
                //     'transition' : 'all 1s ease'
                // },2000);
                
                console.log('in on ouvre');
                e.preventDefault();
                $allPlusMoins.html('+');
                $plusMoins.html('-');

            } else {
                // Si navSous ouvert
                e.preventDefault();

                $allNavSous.removeClass('open');
                console.log('in on ferme');
                
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
    }

}
