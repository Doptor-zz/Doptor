/**
 * jQuery Mobile Menu 
 * Turn unordered list menu into dropdown select menu
 * version 1.0(31-OCT-2011)
 * 
 * Built on top of the jQuery library
 *   http://jquery.com
 * 
 * Documentation
 * 	 http://github.com/mambows/mobilemenu
 */
(function($){
$.fn.mobileMenu = function(options) {
		
		function isMobile(){
		return ($('body').width() < 760);
	}
	
	var defaults = {
			defaultText: 'Navigate to...',
			className: 'select-menu',
			subMenuClass: 'sub-menu',
			subMenuDash: '&ndash;'
		},
		settings = $.extend( defaults, options ),
		el = $(this);
	
	this.each(function(){
		// ad class to submenu list
		el.find('ul').addClass(settings.subMenuClass);

		// Create base menu
		$('<select />',{
			'class' : settings.className
		}).insertAfter( el );

		// Create default option
		$('<option />', {
			"value"		: '#',
			"text"		: settings.defaultText
		}).appendTo( '.' + settings.className );

		// Create select option from menu
		el.find('a,.separator').each(function(){
			var $this 	= $(this),
					optText	= $this.text(),
					optSub	= $this.parents( '.' + settings.subMenuClass ),
					len			= optSub.length,
					dash;
			
			// if menu has sub menu
			if( $this.parents('ul').hasClass( settings.subMenuClass ) ) {
				dash = Array( len+1 ).join( settings.subMenuDash );
				optText = dash + optText;
			}
			if($this.is('span')){
				// Now build menu and append it
			$('<optgroup />', {
				"label"	: optText,
			}).appendTo( '.' + settings.className );
			}
			else{
				// Now build menu and append it
			$('<option />', {
				"value"	: this.href,
				"html"	: '&nbsp'+optText,
				"selected" : (this.href == window.location.href)
			}).appendTo( '.' + settings.className );
			}

		}); // End el.find('a').each

		// Change event on select element
		$('.' + settings.className).change(function(){
			var locations = $(this).val();
			if( locations !== '#' ) {
				window.location.href = $(this).val();
			}
		});

	}); // End this.each
	function runPlugin(){
		
		//menu exists, and browser is mobile width
		if(isMobile()){
			$('.select-menu').show();
			$('nav.primary .sf-menu').hide();
		}
			
		//otherwise, hide the mobile menu
		else{
			$('.select-menu').hide();
			$('nav.primary .sf-menu').show();
		}
		
	}//runPlugin()
	
runPlugin();
			$(window).resize(function(){runPlugin();});

	return this;
};
})(jQuery);