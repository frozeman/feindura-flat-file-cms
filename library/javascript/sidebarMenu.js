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
// java/sidebarMeu.js version 0.24 (requires mootools-core and mootools-more)
//
// let the sideBarMenu SLIDE IN/OUT and RESIZE on mouseover


window.addEvent('domready', function() {

	$$('.sidebarMenu').each(function(sideBarMenu) {
	   
     var slideTopButton;
	   var slideBottomButton;
	   var slideContent;
	   var slideVertical;
	   
	   // gets the <a> tag in the <div class="content"> container and <div class="bottom">
	   sideBarMenu.getElements('div').each(function(passedDiv) {
	      // gets the upper toogle button
        if(passedDiv.hasClass('top')) {
          slideTopButton = passedDiv.getElement('a');
        }
        // gets the bottom toogle button
        if(passedDiv.hasClass('bottom')) {
          slideBottomButton = passedDiv.getElement('a');
        }
        // gets slideing content
        if(passedDiv.hasClass('content')) {
          slideContent = passedDiv;
        }
     });
	   

	   // creates the slide effect
	   slideVertical = new Fx.Slide(slideContent,{duration: '750', transition: Fx.Transitions.Pow.easeOut});	   

	   // changes the up and down button class from the <div class="top">
	   // so that the picture of the upper Toogle Buttons changes
	   slideVertical.onComplete = function(el) {
          sideBarMenu.toggleClass('hidden');
          layoutFix();
     }

	   // sets the SLIDE EFFECT to the buttons
	   slideTopButton.addEvent('click', function(e){
    		e.stop();    		
    		slideVertical.toggle();
    	});
      slideBottomButton.addEvent('click', function(e){
    		e.stop();
    		slideVertical.toggle();
    	});
    	
    	// hide the Menu if it has class "hidden"
    	if(sideBarMenu.hasClass('hidden'))    	 
    	  slideVertical.hide();
    	
     // RESIZE on MouseOver -------------------------------------------------------------------------------------------
     
     // gets the length of the longest text
      var maxTextLength = 0;
      // walk trough all <li> <a> ellements an messure the <span> length
      slideContent.getElement('ul').getElements('li').each(function(passedLi) {      
        var textLength = passedLi.getElement('a').getElement('span').offsetWidth;        
        if(maxTextLength < textLength) {
          maxTextLength = textLength + 30; //+ 10 for padding
        }
      });
    	
     // sets the RESIZE-TWEEN to the sideBarMenu
	   sideBarMenu.set('tween', {duration: '650', transition: Fx.Transitions.Pow.easeOut});
	   
     slideContent.addEvent('mouseover', function(e){
    		e.stop();
    		if(maxTextLength > 210) {
    		  sideBarMenu.tween('width', maxTextLength);
    		} else {
    		  sideBarMenu.tween('width', 210);
    		}
    	});
      slideContent.addEvent('mouseout', function(e){
    		e.stop();
    		sideBarMenu.tween('width', '210');
    	});
            
  });	
});
