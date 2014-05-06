/*
 jQuery Plugin to give bootstrap tab ajax capabilities
 author:jcgarciam [ad] gmail [dot] com
*/
(function ($, window, undefined) {
    $.fn.ajaxTab = function (tabId) {
        var $this = $(this);
        var tbCnt = $this.next("div.tab-content");
        var selector_no_hash = $this.selector.substr(1);
        if (tbCnt.length === 0) {
            var div_tab_content = [];
            div_tab_content.push("<div class='tab-content'>")
            div_tab_content.push("<div class='tab-pane active' id='" + selector_no_hash + "-content'>");
            div_tab_content.push("</div>");
            div_tab_content.push("</div>");

            $this.parent().append(div_tab_content.join(""));
        } else {
            tbCnt.find(".tab-pane").attr("id", selector_no_hash + "-content");
        }
        $this.find("li>a").each(function (idx, el) {
            var $el = $(el);
            var href = $el.attr("href");
            var newHref = href + $this.selector + "-content";
            $el.attr("href", newHref);
        });

        $this.bind("show", function (e) {
            var $anchor = $(e.target);
            var href = $anchor.attr("href");
            var hash = href.indexOf("#");
            var target = href.substr(hash);
            href = href.substr(0, hash);
              
            $.get(href, function (data, statusText, jqXHR) {
	           $(target).html(data);
            });			  
        });
        if(tabId === undefined || tabId === "" || tabId === null){
            $this.find('a:first').tab("show");
        }else{
            $this.find('a'+tabId).tab("show");
        }

    }
})(jQuery, window, undefined);