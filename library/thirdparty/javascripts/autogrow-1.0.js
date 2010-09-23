/* 
 * AUTOGROW TEXTAREA
 * Version 1.0
 * A mooTools plugin
 * by Gary Glass (www.bookballoon.com)
 * mailto:bookballoon -at- bookballoon.com
 *
 * Based on a jQuery plugin by Chrys Bader (www.chrysbader.com).
 * Thanks to Aaron Newton for reviews and improvements.
 *
 * Copyright (c) 2009 Gary Glass (www.bookballoon.com)
 * Dual licensed under the MIT (MIT-LICENSE.txt)
 * and GPL (GPL-LICENSE.txt) licenses. 
 *
 * NOTE: This script requires mooTools. Download mooTools at mootools.net.
 *
 * USAGE:
 *		new AutoGrow(element);
 * where 'element' is a textarea element. For example:
 *		new AutoGrow($('myTextarea'));
 */
var AutoGrow = new Class({

	Implements: [Options, Events],

	options: {
		interval: 333, // update interval in milliseconds
		margin: 30, // gap (in px) to maintain between last line of text and bottom of textarea
		minHeight: 0 // minimum height of textarea
	},

	initialize: function(textarea, options) {
		this.textarea = $(textarea);
		this.options.minHeight = textarea.clientHeight;
		this.setOptions(options);
		this.dummy =  new Element("div", {
			styles:	{
				"overflow-x" : "hidden",
				"position"   : "absolute",
				"top"        : 0,
				"left"       : "-9999px"
			}
		}).setStyles(this.textarea.getStyles("font-size", "font-family", "width", "line-height", "padding")).inject(document.body);
		this.resize.periodical(this.options.interval, this);
	},

	resize: function() {
		var html = this.textarea.get('value').replace(/\n|\r\n/g, '<br>X');
		if (this.dummy.get("html").toLowerCase() != html.toLowerCase()){
			this.dummy.set("html", html);
			var triggerHeight = this.dummy.getSize().y + this.options.margin;
			if (this.textarea.clientHeight != triggerHeight)
			{
				var newHeight = Math.max(this.options.minHeight, triggerHeight);
				this.textarea.tween("height", newHeight);
			}
		}
	}

});