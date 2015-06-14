/**
 * @package OptimaSales
 * @subpackage OptimaSales HTML
 * @since OptimaSales HTML 1.0
 * 
 * Template Scripts
 * Created by Olechka
 * 
 */

$(function(){

	// ---------------------------------------------------------
	// Tabs
	// ---------------------------------------------------------
	$(".tabs").each(function(){

		$(this).find(".tab").hide();
		$(this).find(".tab-menu li:first a").addClass("active").show();
		$(this).find(".tab:first").show();

	});

	$(".tabs").each(function(){

		$(this).find(".tab-menu a").click(function() {

			$(this).parent().parent().find("a").removeClass("active");
			$(this).addClass("active");
			$(this).parent().parent().parent().parent().find(".tab").hide();
			var activeTab = $(this).attr("href");
			$(activeTab).fadeIn();
			return false;

		});

	});
	
	// ---------------------------------------------------------
	// Accordion (Toggle)
	// ---------------------------------------------------------

	(function() {
		var $container = $('.acc-body'),
			$acc_head   = $('.acc-head');

		$container.hide();
		$acc_head.first().addClass('active').next().show();
		$acc_head.last().addClass('last');
		
		$acc_head.on('click', function(e) {
			if( $(this).next().is(':hidden') ) {
				$acc_head.removeClass('active').next().slideUp(300);
				$(this).toggleClass('active').next().slideDown(300);
			}
			e.preventDefault();
		});

	})();
	/* END Accordion (Toggle) */
	

	// initialise superfish menu
	$('ul.sf-menu').superfish({
		autoArrows	: true,
		dropShadows : false,
		delay		: 800,
		animation	: {opacity:'show'},
		speed		: 'fast'
	});

	/* Mobile Menu */
	$('nav.primary .sf-menu').mobileMenu();
	
	
	// Prettyphoto
	
	// store the viewport width in a variable
	var viewportWidth = $('body').innerWidth();
	
	$("a[rel^='prettyPhoto']").prettyPhoto({
		overlay_gallery: false,
		theme: 'pp_default',
		social_tools: false,
    changepicturecallback: function(){
        // 1024px is presumed here to be the widest mobile device. Adjust at will.
        if (viewportWidth < 1025) {
            $(".pp_pic_holder.pp_default").css("top",window.pageYOffset+"px");
        }
    }
	});
	
	
	// initialise twitter widget
	// $('#twitter').getTwitter({
	// 	userName: 'envato',
	// 	numTweets: 2,
	// 	preloaderId: "preloader",
	// 	loaderText: "Loading tweets...",
	// 	slideIn: false,
	// 	showHeading: true,
	// 	beforeHeading: "<h4>",
	// 	afterHeading: "</h4>",
	// 	headingText: "Latest tweets",
	// 	id: "#twitter",
	// 	showProfileLink: false
	// });
	
	
	// Elastslide init (Customers)
	$('#carousel1').elastislide({
		imageW 		: 190,
		border		: 0,
		margin      : 26,
		minItems    : 2,
		current		: 4
	});
	
	// Elastslide init (Partners)
	$('#carousel2').elastislide({
		imageW 		: 190,
		border		: 0,
		margin      : 26,
		minItems    : 2,
		current		: 4
	});
	
	// Misc
	$('.home-services li:nth-child(even), .services li:nth-child(even)').addClass('even');
	$('.tabs .tab-menu li:last-child').addClass("last-child");
	
	
	// Styleswitcher Panel
	$themePanel = $('#styleswitcher_panel');
	$theme_control_panel_label = $('#control_label');
	
	$theme_control_panel_label.click(function() {
		if ($themePanel.hasClass('visible')) {
			$themePanel.removeClass('visible');
			$themePanel.animate({left: -114}, 400);
		} else {
			$themePanel.addClass('visible');
			$themePanel.animate({left: 0}, 400);
		}
		return false;
	});
	
	
	// Modal Window init
	$('#myModal').reveal({
		animation: 'fadeAndPop',    
		animationspeed: 300,      
		closeonbackgroundclick: true,     
		dismissmodalclass: 'close-reveal-modal' 
	});
	
	
	// We should help browser if it can't display placeholder by himself
	if(!Modernizr.input.placeholder){
 
		$('[placeholder]').focus(function() {
			var input = $(this);
			if (input.val() == input.attr('placeholder')) {
				input.val('');
				input.removeClass('placeholder');
			}
		}).blur(function() {
			var input = $(this);
			if (input.val() == '' || input.val() == input.attr('placeholder')) {
				input.addClass('placeholder');
				input.val(input.attr('placeholder'));
			}
		}).blur();
		$('[placeholder]').parents('form').submit(function() {
			$(this).find('[placeholder]').each(function() {
				var input = $(this);
				if (input.val() == input.attr('placeholder')) {
					input.val('');
				}
			})
		});
	}
	
});