/**
 * jQuery PrintMe v.1.0
 * 
 * A jquery plugin that prints the given element
 *
 * Copyright 2014, Daniel Arlandis <daniarlandis@gmail.com> www.daniarlandis.es
 * Released under the WTFPL license
 * http://sam.zoy.org/wtfpl/
 *
 * Date: Mon Feb 10 19:23:00 2014
 * Last modified: Sat Dec 12 22:00:00 2015
 */
jQuery.fn.printMe=function(t){var e=$.extend({path:[],title:"",head:!1},t);return this.each(function(){var t=$(this),n=window.open();n.document.write('<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">'),n.document.write("<html>"),n.document.write("<head>"),n.document.write("<meta charset='utf-8'>");for(i in e.path)n.document.write('<link rel="stylesheet" href="'+e.path[i]+'">');n.document.write("</head><body>"),""!=e.title&&n.document.write("<h1>"+e.title+"</h1>"),n.document.write(t.html()),n.document.write('<script type="text/javascript">function closeme(){window.close();}setTimeout(closeme,50);window.print();</script></body></html>'),n.document.close()})};