// Plugin created by Brock Nusser - http://brocknusser.com
// Demo site: http://mlamenu.brocknusser.com/index.htm
// Download: http://mlamenu.brocknusser.com/mlamenu.zip

/*
SETUP
*/
var slideSpeed = 'slow';    // 'slow', 'normal', 'fast', or miliseconds
//end setup

var pathname = window.location.pathname;

$(function() {



    /*
        add 'Current' class to the current page
    */
    $('.accordion-nav a').each(function() {
        var thisHref = $(this).attr('href')
        if ((window.location.pathname.indexOf(thisHref) == 0) || (window.location.pathname.indexOf('/' + thisHref) == 0)) {
        $(this).addClass('Current');
    }
    });

    /*
        display the current page
    */
    $('.Current').parent('li').children('ul').show();
    $('.Current').parents('ul').show();

    /*
        add expand/collapse icons
    */
    $('.accordion-nav li').each(function () {
        if ($(this).children('ul').length > 0) {
            if ($(this).children('ul').is(":visible")) {
                $(this).prepend('<img src="' + window.base_url + '/images/imgOnOpen.png" />');
            }
            else {
                $(this).prepend('<img src="' + window.base_url + '/images/imgOffClosed.png" />');
            }
        }
    });

    /*
        open/close current each list on click
    */
    $('.accordion-nav img').click(function() {
        if ($(this).parent('li').children('ul').html() != null) {
            $(this).parent('li').parent('ul').children('li').children('ul').hide(slideSpeed);
            $(this).parent('li').parent('ul').children('li').children('img').attr('src', window.base_url + '/images/imgOffClosed.png');
            $(this).delay(100).is(':hidden');
            if ($(this).parent('li').children('ul').css('display') == "block") {
                $(this).parent('li').children('ul').hide(slideSpeed);
                $(this).attr('src', window.base_url + '/images/imgOffClosed.png');
            } else {
                $(this).parent('li').children('ul').show(slideSpeed);
                $(this).attr('src', window.base_url + '/images/imgOnOpen.png');
            }
            return false;
        }

    });

    //End Required Section



});

