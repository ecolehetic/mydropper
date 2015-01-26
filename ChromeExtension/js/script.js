/*Handle requests from background.html*/
function handleRequest(request, sender, sendResponse) {
    if (request.callFunction == "toggleSidebar") {
        toggleSidebar(request.sideBarContent);
    }
}

chrome.extension.onRequest.addListener(handleRequest);

//  TOGGLE SIDEBAR 
var sidebarOpen = false;

function toggleSidebar(htmlContent) {

    // ------ Open & Close panel 
    if (sidebarOpen) {

        var el = document.getElementById('myDropperSideBar');

        // Add animation before kill the element
        el.classList.add("hideBar");
        // Remove Class to all input/textarea elements
        removeMarkDropZones();

        setTimeout(function() {
            

            // Kill the element
            el.parentNode.removeChild(el);
            sidebarOpen = false;
        }, 1000)
    } else {

        var sidebar = document.createElement('div');
        sidebar.id = "myDropperSideBar";
        sidebar.innerHTML = htmlContent;
        document.body.appendChild(sidebar);
        sidebar.style.display = 'block'
        sidebarOpen = true;

        //  Add Class to all input/textarea elements
        addMarkDropZones();
    }


    // ------ Hover accordeon
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

    //  ------ Init draggable/droppable from jquery UI
    initDraggable();
    initDroppable();
}

function addMarkDropZones() {
    $('input').each(function() {
        if ($(this).attr('type') == "text" ||
            $(this).attr('type') == "email" ||
            $(this).attr('type') == "number") {
            $(this).addClass('md-dropElmt');
        }
    });
    $('textarea').addClass('md-dropElmt');
}
function removeMarkDropZones() {
    $('.md-dropElmt').removeClass('md-dropElmt');
}

function initDraggable() {
    var offset = 0;
    $('.md-dragElmt')
        .draggable({
            start: function(event,ui) {
                var offset = $(this).offset();
                $(this).addClass('md-draging');
                $(this).css({
                    'z-index': '999999999',
                    // 'left': '1000px',
                    'top': offset.top,
                    'left': offset.left
                });
            },
            drag: function(event,ui) {
            },
            stop: function(event,ui) {
            	$(this).removeClass('md-draging');
                $(this).attr('style','');
            }
        });
}

function initDroppable() {
    $(".md-dropElmt").droppable({
        accept: ".md-dragElmt", 
        tolerance: "intersect",
        hoverClass: "mad-dragHovered",
        drop: function(event, ui) {
            var elmtAttr = event.toElement.attributes;
            var txtToImport = ui.draggable.data('text');
            $(this).attr('value', txtToImport);
        }
    });
}
