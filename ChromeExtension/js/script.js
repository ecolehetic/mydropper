/*Handle requests from background.html*/
function handleRequest(request, sender, sendResponse) {
    if (request.callFunction == "toggleSidebar") {
        toggleSidebar(request.sideBarContent);
    }
}

chrome.extension.onRequest.addListener(handleRequest);

//  ------------------ TOGGLE SIDEBAR 
var sidebarOpen = false;

function toggleSidebar(htmlContent) {
    // ------ Open & Close panel 
    if (sidebarOpen) {
        var el = document.getElementById('myDropperSideBar');
        // Add animation before kill the element
        el.classList.remove("showBar");
        el.classList.add("hideBar");
        // Remove Class to all input/textarea elements
        removeMarkDropZones();

        setTimeout(function() {
            // Kill the element
            el.parentNode.removeChild(el);
            sidebarOpen = false;
        }, 1000)
    } 
    else {

        var sidebar = document.createElement('div');
        sidebar.id = "myDropperSideBar";
        sidebar.innerHTML = htmlContent;
        document.body.appendChild(sidebar);
        $('#myDropperSideBar').css({
            'position': 'fixed',
            'top': '0px',
            'right': '0px',
            'max-width': '300px',
            'width': '300px',
            'overflow-x': 'visible',
            'overflow-y': 'auto',
            'height': '100%',
            'background': '#FFFFFF',
            'z-index': '99999999999999',
            'display': 'none',
            'font-family': 'helvetica, arial',
            'color': '#212121',
            'border-left': '1px solid #727272'
        });
        sidebar.style.display = 'block';
        sidebar.classList.add('showBar');
        sidebarOpen = true;

        //  Add Class to all input/textarea elements
        addMarkDropZones();
        initDroppable();
        initDraggable();
        initAccordeon();
    }
}



function addMarkDropZones() {
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
}

function removeMarkDropZones() {
    $('.md-dropElmt').removeClass('md-dropElmt');
}

function initAccordeon() {
    $catLink = $('#accordeon .category h2');
    $dragList = $('#accordeon .category .dragList');


    $catLink.click(function(e) {
        e.preventDefault();

        $navMenuParent = $(this).parent();
        $navSous = $(this).siblings('.dragList');
        $allNavSous = $('.category .dragList');
        $plusMoins = $('span', this);
        $allPlusMoins = $('.category h2 span');


        if (!$navSous.is(":visible")) {
            // Si navSous fermé
            $allNavSous.slideUp('slow');
            $navSous.slideDown('slow');

            e.preventDefault();
            $allPlusMoins.html('+');
            $plusMoins.html('-');

        } else {
            // Si navSous ouvert
            $allNavSous.slideUp('slow');
            e.preventDefault();
            $allPlusMoins.html('+');
        }
    });
}


function initDraggable() {
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

} 

function initDroppable() {
    console.log('dropZoneInit');

    $(".md-dropElmt").on('drop', function(event) {
        //restore the md-dropElmt after dropevent
        $('.md-dropElmt').css('opacity', 1);
        event.stopPropagation();
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
}
