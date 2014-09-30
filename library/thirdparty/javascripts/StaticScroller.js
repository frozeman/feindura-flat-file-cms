/*
---
description: StaticScroller

license:
  MIT-style

authors:
  - Luke Ehresman (http://luke.ehresman.org)
  - Ryan Florence <rpforence@gmail.com>

fixes
  - Fabian Vogelsteller <fabian.vogelsteller@gmail.com>

requires:
  core/1.3 and more 1.3.0.1

provides: [StaticScroller]

*/
var StaticScroller = new Class({

	Implements: Options,

		options: {
			offset: 0,
			scrollElement: window
		},

	initialize: function(element, options) {
		this.setOptions(options);
		this.element = document.id(element);

		if(this.element === null)
			return false;

		this.scrollElement = document.id(this.options.scrollElement);
		this.originalPosition = this.element.getPosition();
		this.bound = {
			scroll: this.scroll.bind(this),
			resize: this.resize.bind(this)
		};
		this.stylePosition = this.element.getStyle('position');
		this.styleTop      = this.element.getStyle('top');
		this.styleLeft     = this.element.getStyle('left');
		this.styleRight    = this.element.getStyle('right');
		this.attachWindow();
		this.checkHeight();
	},

	attachScroll: function(){
		this.scrollElement.addEvent('scroll', this.bound.scroll);
		return this;
	},

	attachWindow: function(){
		window.addEvent('resize', this.bound.resize);
		return this;
	},

	detachScroll: function(){
		this.scrollElement.removeEvent('scroll', this.bound.scroll);
		return this;
	},

	detachWindow: function(){
		window.removeEvent('resize', this.bound.resize);
		return this;
	},

	checkHeight: function(){
		if(document.getSize().y < this.element.getSize().y) {
			this.detachScroll().reset();
		} else {
			this.attachScroll().scroll();
		}
		return this;
	},

	isPinned: function(){
		return (this.element.retrieve('pinned'));
	},

	scroll: function(){
		var collision = (this.scrollElement.getScroll().y > this.originalPosition.y - this.options.offset);
		var isPinned = this.isPinned();

		if(collision) {
			if(!isPinned) {
				this.element.pin();
        if(this.options.offset.toInt() !== 0)
          this.element.setStyle('top', this.options.offset.toInt());
				this.element.store('pinned',true);
			}
		} else {
			if(isPinned) this.reset();
		}
		return this;
	},

	resize: function(){
		if(this.isPinned()) this.reset();
		this.checkHeight();
		return this;
	},

	reset: function(){
		if(this.isPinned()) {
      this.element.unpin().setStyles({
				'position':this.stylePosition,
				'top':this.styleTop,
				'left':this.styleLeft,
				'right':this.styleRight
			});
      this.element.store('pinned',false);
    }
	}
});
