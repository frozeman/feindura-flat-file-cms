/*
    feindura - Flat File Content Management System
    Copyright (C) 2009 Fabian Vogelsteller [frozeman.de]

    This program is free software;
    you can redistribute it and/or modify it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 3 of the License, or (at your option) any later version.

    This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY;
    without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
    See the GNU General Public License for more details.

    You should have received a copy of the GNU General Public License along with this program;
    if not,see <http://www.gnu.org/licenses/>.
*/
// javascript/divScroller.js version 0.1 (requires mootools-core and mootools-more)

/*
Class: divScroller
	The Scroller is a class to scroll any element with an overflow (including the window) when the mouse cursor reaches certain buondaries of that element.
	You must call its start method to start listening to mouse movements.

Note:
	The Scroller requires an XHTML doctype.

Arguments:
	element - required, the element to scroll.
	options - optional, see options below, and <Fx.Base> options.

Options:
	area - integer, the necessary boundaries to make the element scroll.
	direction - 'x', 'y', ('xy' or 'both')
	velocity - integer, velocity ratio, the modifier for the window scrolling speed.
	scrollSpeed - the speed in Pixel to scroll if youre directly on the border of the element to scroll

*/

var divScroller = new Class({
  
  Implements: [Options], 
  
	options: {
		area: 50,
		direction: 'both',
		velocity: 1,
    scrollSpeed: 50 
	},

	initialize: function(element, options){
		this.setOptions(options);
		this.element = $(element);
		this.mousemover = ([window, document].contains(element)) ? $(document.body) : this.element;
	},

	/*
	Property: start
		The scroller starts listening to mouse movements.
	*/

	start: function() {
		this.coord = this.getCoords.bindWithEvent(this);
		this.mousemover.addListener('mousemove', this.coord);
	},

	/*
	Property: stop
		The scroller stops listening to mouse movements.
	*/

	stop: function() {
		this.mousemover.removeListener('mousemove', this.coord);
		this.timer = $clear(this.timer);
	},

	getCoords: function(event) { 
		
		this.elementScroll = this.element.getScroll();		
		this.elementPos = this.element.getPosition();
		
    this.elementPosX = this.elementPos.x + this.elementScroll.x;
    this.elementPosY = this.elementPos.y + this.elementScroll.y;
		
	  this.mousePosX = event.pageX - this.elementPosX;
	  this.mousePosY = event.pageY - this.elementPosY;
		
		this.scrollWidthTopY = (1 - (this.mousePosY / this.options.area)) * this.options.scrollSpeed * this.options.velocity;
		this.scrollWidthBottomY = (1 - ((this.element.getSize().y - this.mousePosY) / this.options.area)) * this.options.scrollSpeed * this.options.velocity;
		this.scrollWidthLeftX = (1 - (this.mousePosX / this.options.area)) * this.options.scrollSpeed * this.options.velocity;
		this.scrollWidthRightX = (1 - ((this.element.getSize().x - this.mousePosX) / this.options.area)) * this.options.scrollSpeed * this.options.velocity;
		
		if(!this.timer) this.timer = this.scroll.periodical(50, this);
	},

	scroll: function() { 
	 
  	 /*
     $('output').set('html',
      'elementScroll X: ' + this.elementScroll.x + '<br />',
      'elementScroll Y: ' + this.elementScroll.y + '<br />',
      'elementPos X: ' + this.elementPosX + '<br />',
      'elementPos Y: ' + this.elementPosY + '<br />',
      'mousePosX: ' + this.mousePosX + '<br />',
      'mousePosY: ' + this.mousePosY + '<br />',
      'add to Scroll: ' + this.scrollWidthBottomY + '<br />' );
     */
   
    // SCROLL Y
    // --------
    // TOP BOUNDARY
    if((this.options.direction == 'y' || this.options.direction == 'xy' || this.options.direction == 'both') &&
       this.mousePosY < this.options.area && this.element.getScroll().y > 0) {       
  		this.element.scrollTo(this.element.getScroll().x,this.element.getScroll().y - this.scrollWidthTopY);
  	}
    // BOTTOM BOUNDARY
    if((this.options.direction == 'y' || this.options.direction == 'xy' || this.options.direction == 'both') &&
       (this.element.getSize().y - this.mousePosY) < this.options.area && this.element.getScroll().y < this.element.getScrollSize().y) {       
  		this.element.scrollTo(this.element.getScroll().x,this.element.getScroll().y + this.scrollWidthBottomY);
  	}
    
    // SCROLL X
    // --------
    // LEFT BOUNDARY
    if((this.options.direction == 'x' || this.options.direction == 'xy' || this.options.direction == 'both') &&
       this.mousePosX < this.options.area && this.element.getScroll().x > 0) {       
  		this.element.scrollTo(this.element.getScroll().x - this.scrollWidthLeftX,this.element.getScroll().y);
  	}
    // RIGHT BOUNDARY
    if((this.options.direction == 'x' || this.options.direction == 'xy' || this.options.direction == 'both') &&
      (this.element.getSize().x - this.mousePosX) < this.options.area && this.element.getScroll().x < this.element.getScrollSize().x) {
  		this.element.scrollTo(this.element.getScroll().x + this.scrollWidthRightX,this.element.getScroll().y);
  	}   
	}
});