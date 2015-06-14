(function($) {
	/*
		jquery.twitter.js v1.0
		Last updated: 26 October 2008

		Created by Damien du Toit
		http://coda.co.za/blog/2008/10/26/jquery-plugin-for-twitter

		Licensed under a Creative Commons Attribution-Non-Commercial 3.0 Unported License
		http://creativecommons.org/licenses/by-nc/3.0/
	*/
	
	$.fn.getTwitter = function(options) {
		var o = $.extend({}, $.fn.getTwitter.defaults, options);
		
		// hide container element
		$(this).hide();
	
		// add heading to container element
		if (o.showHeading) {
			$(this).append(o.beforeHeading+o.headingText+o.afterHeading);
		}

		// add twitter list to container element
		$(this).append('<ul class="twitter_update_list"><li></li></ul>');

		// hide twitter list
		$("ul.twitter_update_list").hide();

		// add preLoader to container element
		var pl = $('<p class="'+o.preloaderId+'">'+o.loaderText+'</p>');
		$(this).append(pl);

		// add Twitter profile link to container element
		if (o.showProfileLink) {
			$(this).append('<a class="profileLink" href="http://twitter.com/'+o.userName+'"><span class="inner">Follow Us</span></a>');
		}

		// show container element
		$(this).show();
		
		
		
		function twitterCallback2(twitters) {
		  var statusHTML = [];
		  for (var i=0; i<twitters.length; i++){
			var username = twitters[i].user.screen_name;
			var status = twitters[i].text.replace(/((https?|s?ftp|ssh)\:\/\/[^"\s\<\>]*[^.,;'">\:\s\<\>\)\]\!])/g, function(url) {
			  return '<a href="'+url+'">'+url+'</a>';
			}).replace(/\B@([_a-z0-9]+)/ig, function(reply) {		  return  reply.charAt(0)+'<a href="http://twitter.com/'+reply.substring(1)+'">'+reply.substring(1)+'</a>';
			});
			statusHTML.push('<li><div class="twitt-body">'+status+'</div> <a class="timesince" href="http://twitter.com/'+username+'/statuses/'+twitters[i].id_str+'">'+relative_time(twitters[i].created_at)+'</a></li>');
		  }
		  var id = '';
		  id = o.id;
		  $(id).find('ul').html(statusHTML.join(''));
		  //document.getElementById(id).innerHTML = statusHTML.join('');
		}
		
		
		function relative_time(time_value) {
		  var values = time_value.split(" ");
		  time_value = values[1] + " " + values[2] + ", " + values[5] + " " + values[3];
		  var parsed_date = Date.parse(time_value);
		  var relative_to = (arguments.length > 1) ? arguments[1] : new Date();
		  var delta = parseInt((relative_to.getTime() - parsed_date) / 1000);
		  delta = delta + (relative_to.getTimezoneOffset() * 60);
		
		  if (delta < 60) {
			return 'less than a minute ago';
		  } else if(delta < 120) {
			return 'about a minute ago';
		  } else if(delta < (60*60)) {
			return (parseInt(delta / 60)).toString() + ' minutes ago';
		  } else if(delta < (120*60)) {
			return 'about an hour ago';
		  } else if(delta < (24*60*60)) {
			return 'about ' + (parseInt(delta / 3600)).toString() + ' hours ago';
		  } else if(delta < (48*60*60)) {
			return '1 day ago';
		  } else if(delta < (30*48*60*60)) {
			return (parseInt(delta / 86400)).toString() + ' days ago';
		  } else if(delta < (60*48*60*60)) {
			return '1 month ago';
		  } else {
			return (parseInt(delta / 2592000)).toString() + ' months ago';
		  }
		}
		
		
		
 
    
		
		$.getJSON("http://twitter.com/statuses/user_timeline.json?screen_name="+o.userName+"&callback=?&count="+o.numTweets, function(data) {twitterCallback2(data);
			  
			  // remove preLoader from container element
				$(pl).remove();
			  })
		
				
	
				// show twitter list
				if (o.slideIn) {
					$("ul.twitter_update_list").slideDown(1000);
				}
				else {
					$("ul.twitter_update_list").show();
				}
	
				// give first list item a special class
				$("ul.twitter_update_list li:first").addClass("firstTweet");
	
				// give last list item a special class
				$("ul.twitter_update_list li:last").addClass("lastTweet");
			
			
		
		
		};
	 
	// plugin defaults
	$.fn.getTwitter.defaults = {
		userName: null,
		numTweets: 5,
		preloaderId: "preloader",
		loaderText: "Loading tweets...",
		slideIn: false,
		showHeading: true,
		beforeHeading: "<h3>",
		afterHeading: "</h3>",
		headingText: "Latest Tweets",
		id: "",
		showProfileLink: true
	};
})(jQuery);