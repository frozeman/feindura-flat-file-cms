/*
    feindura - Flat File Content Management System
    Copyright (C) Fabian Vogelsteller [frozeman.de]

    This program is free software;
    you can redistribute it and/or modify it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 3 of the License, or (at your option) any later version.

    This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY;
    without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
    See the GNU General Public License for more details.

    You should have received a copy of the GNU General Public License along with this program;
    if not,see <http://www.gnu.org/licenses/>.
*/
// java/content.js version 0.55 (requires mootools-core and mootools-more)
//


// -------------------------------------------------
// auto resize of the THUMBNAIL-PREVIEW
function autoResizeThumbnailPreview() {
  
  $$('.thumbnailPreview').each(function(thumbnail) {
      
      // only set tween if the img tag has a width attribute,
      // prevent double addEvent and double set of vars
      if(thumbnail.getProperty('width')) {
        
        var oldWidth = thumbnail.getSize().x;
      
        // remove the width property to get the real width
        thumbnail.removeProperty('width');
        var orgWidth = thumbnail.getSize().x;
        
        // add the width property again
        thumbnail.setStyle('width',oldWidth + 'px');
        
        // set tween
        thumbnail.set('tween',{duration: '500', transition: Fx.Transitions.Pow.easeOut});
        
        //mouseover      
        thumbnail.addEvent('mouseenter',function() {
          thumbnail.tween('width',orgWidth+'px');
        });
        
        // mouseout
        thumbnail.addEvent('mouseleave',function() {
        thumbnail.tween('width',oldWidth+'px');
        });
      
      }
    });  
}

// -------------------------------------------------
// BLOCK SLIDE IN/OUT
function blockSlideInOut(givenIdCLass) {
  
  var blocksInDiv = '';
  
  // prepares the given container div id or class
  if(givenIdCLass) {
    blocksInDiv = givenIdCLass + ' ';
  }
  
  $$(blocksInDiv + '.block').each(function(block) {
	   
     var slideButtonH1;
	   var slideContent;
	   var bottomBorder;
	   var slideVertical;	   
	   
	   // gets the <a> tag in the <h1>
     if(block.getElement('h1') !== null && block.getElement('h1').getElement('a')) {
      
       slideButtonH1 = block.getElement('h1').getElement('a');
      
       block.getElements('div').each(function(passedDiv) {
         // gets slideing content
         if(passedDiv.hasClass('content')) {
           slideContent = passedDiv;
         }
         if(passedDiv.hasClass('bottom')) {
           bottomBorder = passedDiv;
         }
      });
      
      
      // DONT show the content bottom if IE 0-7
      if(navigator.appVersion.match(/MSIE ([0-7]\.\d)/)) {
        bottomBorder.setStyle('display', 'none');
      }	   

      
      var slideContentHeightOut = slideContent.offsetHeight;
       
  	  // creates the slide effect
  	  slideVertical = new Fx.Slide(slideContent,{duration: '500', transition: Fx.Transitions.Pow.easeOut});	   
      
      
      // mootools creates an container around slideContent, so that it doesn't resize anymore automaticly, so i have to reset height auto for this container
      slideVertical.onStart = function(el) {     
         slideContent.getParent().fade('show');
         //slideContent.getParent().setStyle('height',slideContentHeightOut);
      }      
        
  	  // changes the up and down button class from the <div class="top">
  	  // so that the picture of the upper Toggle Buttons changes
      slideVertical.onComplete = function(el) {

        // mootools creates an container around slideContent, so that it doesn't resize anymore automaticly, so i have to reset height auto for this container
  	    if(slideVertical.open) {
              block.addClass('hidden');
              slideContent.getParent().fade('hide');
              slideVertical.open = false;
        } else {
  	          block.removeClass('hidden');
              slideContent.getParent().setStyle('height','auto');
              slideContent.getParent().fade('show');
              slideVertical.open= true;
        }
        layoutFix();
      }
  
      // sets the SLIDE EFFECT to the buttons
      slideButtonH1.addEvent('click', function(e) {
      	  e.stop();
      	  if(!slideVertical.open) {
      	    block.removeClass('hidden');
          }
          slideVertical.toggle();          
      });
      
      // hide the Menu if it has class "hidden"
      if(block.hasClass('hidden'))  {
        slideVertical.hide();
	      slideVertical.open = false;
      }
      
    } // <-- end go trough blocks      
      
  });
}

// LOAD (all pics are loaded)
window.addEvent('load',autoResizeThumbnailPreview);

// DOMREADY
window.addEvent('domready', function() {
  
  // block SLIDE IN/OUT ----------------------------------------------------------------------------------------------
	blockSlideInOut();
  
  
  // ADDs SMOOTHSCROLL to ANCHORS
  var smoothAnchorScroll = new Fx.SmoothScroll({
      wheelStops: true,
      duration: 200
  });
  
  // SCROLL to ANCHORS  (should fix chrome and safari scroll problem)
  var anchorId = window.location.hash.substring(1);
  //alert(anchorId + ' -> '+ $(anchorId).getPosition(window).y);
  if(anchorId) {
    window.scrollTo(0,$(anchorId).getPosition(window).y - 50);
    //window.scrollTo(100, $(anchorId).getPosition().y);
    //document.getElementById(anchorId)).scrollIntoView(true);
    //window.location.hash = anchorId;
  }

});