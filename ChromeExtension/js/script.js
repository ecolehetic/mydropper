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
        el.classList.add("hideBar")
        setTimeout(function() {
            el.parentNode.removeChild(el);
            sidebarOpen = false;
            console.log('sidebar : close');
        }, 1000)
    } else {
        var sidebar = document.createElement('div');
        sidebar.id = "myDropperSideBar";
        sidebar.innerHTML = htmlContent;
        document.body.appendChild(sidebar);
        sidebar.style.display = 'block'
        sidebarOpen = true;
        console.log('sidebar : open');
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

    // ------ Add Class to all input/textarea elements
    markDropZones();
    initDraggable();
    initDroppable();
}

function markDropZones() {
    $('input').each(function() {
        if ($(this).attr('type') == "text" ||
            $(this).attr('type') == "email" ||
            $(this).attr('type') == "number") {
            $(this).addClass('md-dropElmt');
        }
    });
    $('textarea').addClass('md-dropElmt');
}

function initDraggable() {
    var offset = 0;
    $('.md-dragElmt')
        .draggable({
            start: function(event,ui) {
                var offset = $(this).offset();
                console.log('start dragging');
                $(this).addClass('md-draging');
                $(this).css({
                    'z-index': '999999999',
                    // 'left': '1000px',
                    'top': offset.top,
                    'left': offset.left
                });
            },
            drag: function(event,ui) {
                console.log('dragging');
            },
            stop: function(event,ui) {
            	$(this).removeClass('md-draging');
                console.log('stop dragging');
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
            var txt = $(this).data('text');
            $(this).attr('value', 'Je depose mon texte');
        }
    });
}
