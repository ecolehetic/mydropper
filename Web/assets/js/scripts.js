'use strict';

$(document).ready(function() {
    var $w = $(window),
        $sideBar = $('#sideBar'),
        $headerRight = $('.headerContent'),
        $container = $('#container'),
        $searchBar = $('#searchBar'),
        $burger = $('#burger'),
        $profileMenu = $('#profileMenu');
        
    var burgerTrigger = false;

    // ------- UI Size Init & Responsive -------
    function initSize() {
        var widthPage = $(window).innerWidth();
        // Header Left Part
        $headerRight.innerWidth(widthPage - $searchBar.innerWidth());

        // Container

        if ($w.innerWidth() > 700) {
            $container
                .css({
                    'width': widthPage - $sideBar.innerWidth(),
                    'left': $sideBar.innerWidth()
                })
                .removeClass('menuOpen');

            closeBurgerMenu();
        } else {
            $container.removeAttr('style');
            if (!burgerTrigger) {
                $('#burger>div').removeAttr('style');
            }
        }
    };

    initSize();

    $w.resize(function() {
        initSize();
    });

    // ------- Burger - Responsive Menu -------

    $burger.click(function() {
        if (!burgerTrigger) {
            openBurgerMenu();
        } else {
            closeBurgerMenu();
        }
    });

    // ------- Accordeon -------
    var $catLink = $('.categoryElement a');
    var $allPlusMinus = $('.categoryElement span');
    var $allSnippetsList = $('.snippetsList');

    $catLink.click(function(e) {
        e.preventDefault();
        var $cat = $(this).parent();
        var $snippetsList = $(this).siblings('ul');
        var $plusMinus = $(this).siblings('span');

        if (!$snippetsList.is(":visible")) {
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

    // ------- Profile Hover -------
    $('#profile').hover(
        function() {
            $profileMenu.fadeIn();
        },
        function() {
            $profileMenu.fadeOut();
        }
    );


    // ------- Functions --------
    function openBurgerMenu() {
        burgerTrigger = true;
        $('#row3').stop().transition({
            rotate: "45",
            "margin-top": "13px"
        });
        $('#row2').stop().transition({
            opacity: "0"
        }, "fast");
        $('#row1').stop().transition({
            rotate: "-45",
            "margin-top": "13px"
        });

        $burger.addClass('open');

        $container.addClass('menuOpen');

        $sideBar
            .css('marginLeft', '-300px')
            .show();

        setTimeout(function() {
            $sideBar.addClass('left');
        }, 300)
    };

    function closeBurgerMenu() {
        $('#row3').stop().transition({
            rotate: "+=135",
            "margin-top": "3px"
        });
        $('#row2').transition({
            opacity: "1"
        }, "fast");
        $('#row1').stop().transition({
            rotate: "-=135",
            "margin-top": "23px"
        });
        burgerTrigger = false;

        $burger.removeClass('open');
        $sideBar.removeClass('left');
        $container.removeClass('menuOpen');

        setTimeout(function() {
            $sideBar.hide()
                .removeAttr('style')
                .removeClass('left');
        }, 500);
    };
}); // End Doc ready
