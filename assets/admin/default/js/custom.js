/*================================
	SCROLL TOP
=================================*/
$(function () {
    $(".scroll-top").hide();
    $(window).scroll(function () {
        if ($(this).scrollTop() > 100) {
            $('.scroll-top').fadeIn();
        } else {
            $('.scroll-top').fadeOut();
        }
    });

    $('.scroll-top a').click(function () {
        $('body,html').animate({
            scrollTop: 0
        }, 500);
        return false;
    });
});


/*================================
	LEFT BAR TAB
=================================*/

$(function () {

    $('#myTab a').click(function (e) {
        e.preventDefault();
        $(this).tab('show');
    });
	$('#myTab1 a').click(function (e) {
        e.preventDefault();
        $(this).tab('show');
    });
	$('#myTab2 a').click(function (e) {
        e.preventDefault();
        $(this).tab('show');
    });
	$('#chat-tab a').click(function (e) {
        e.preventDefault();
        $(this).tab('show');
    });
    $('.left-primary-nav li a').tooltip({
        placement: 'right'
    });
});


/*================================
	TOP TOOLBAR TOOL TIP
=================================*/

$(function () {

    $('.top-right-toolbar a').tooltip({
        placement: "top"
    });


});


/*================================
	SYNTAX HIGHLIGHTER
=================================*/
$(function () {
// make code pretty
window.prettyPrint && prettyPrint()
});


/*================================
RESPONSIVE NAV $ THEME SELECTOR
=================================*/
$(function() {
		  
			  $('.responsive-leftbar').click(function()
			{
				$('.leftbar').toggleClass('leftbar-close expand',500, 'easeOutExpo');
				});

			}); 
	$(function() {
		  
			  $('.theme-setting').click(function()
			{
				$('.theme-slector').toggleClass('theme-slector-close theme-slector-open',500, 'easeOutExpo');
				});

			}); 



		$(function()
		{
			$('.theme-color').click(function()
			{
				var stylesheet = $(this).attr('title').toLowerCase();
				$('#themes').attr('href','css'+'/'+stylesheet+'.css');
				});
			});
			
			$(function(){
				$('.theme-default').click(function(){
				$('#themes').removeAttr("href");
			});
				});