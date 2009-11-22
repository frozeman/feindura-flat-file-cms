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
// java/content.js version 0.51 (requires mootools-core and mootools-more)
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
        thumbnail.setStyle('width',oldWidth+'px');      
        
        // set tween
        thumbnail.set('tween',{duration: '500', transition: Fx.Transitions.Pow.easeOut});
        
        //mouseover      
        thumbnail.addEvent('mouseover',function() {
          thumbnail.tween('width',orgWidth+'px');
        });
        
        // mouseout
        thumbnail.addEvent('mouseout',function() {
        thumbnail.tween('width',oldWidth+'px');
        });
      
      }
    });
  
}

// LOAD (all pics are loaded)
window.addEvent('load',autoResizeThumbnailPreview);

// DOMREADY
window.addEvent('domready', function() {
  
  // creates a smooth Scroll effect to anchors
  /* new Fx.SmoothScroll({
        links: '.smoothAnchors',
        wheelStops: true,
        duration: 1200
    });*/

  
  // block SLIDE IN/OUT ----------------------------------------------------------------------------------------------
	$$('.block').each(function(block) {
	   
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

      
       var slideContentHeightOut = slideContent.offsetHeight;
       
  	   // creates the slide effect
  	   slideVertical = new Fx.Slide(slideContent,{duration: '500', transition: Fx.Transitions.Pow.easeOut});	   

  	   // --- IE 6 HACK fixes the problem in ie 6, that the bottom div stays at the bottom ---
  	   /* ie hack vars */
  	   /*if(bottomBorder != null && navigator.appVersion.match(/MSIE ([0-6]\.\d)/)) {
  	     var blockHeightOut = (block.offsetHeight - 9) + 'px';
  	     var blockHeightIn = (block.getElement('h1').offsetHeight + 20) + 'px';
  	     bottomBorder.setStyle('top',blockHeightOut);
  	     bottomBorder.set('tween',{duration: '500', transition: Fx.Transitions.Pow.easeOut});
    	   
    	   slideVertical.onStart = function(el) {
    	       if(slideVertical.open) {  	           
                bottomBorder.tween('top',blockHeightIn);
                slideVertical.open = false;
            } else {        
                bottomBorder.tween('top',blockHeightOut);
                slideVertical.open = true;
            }         
    	   }
    	 }*/
    	 // --- IE 6 HACK end ----
      
      
      // mootools creates an container around slideContent, so that it doesn't resize anymore automaticly, so i have to reset height auto for this container
      slideVertical.onStart = function(el) {     
        slideContent.getParent().fade('show');  
        slideContent.getParent().setStyle('height',slideContentHeightOut);
      }      
        
  	   // changes the up and down button class from the <div class="top">
  	   // so that the picture of the upper Toggle Buttons changes
       slideVertical.onComplete = function(el) {            
                 
            // mootools creates an container around slideContent, so that it doesn't resize anymore automaticly, so i have to reset height auto for this container
            if(slideVertical.open) {
              block.toggleClass('hidden'); // hides it
              slideContent.getParent().fade('hide');
              slideVertical.open = false;
            } else {              
              slideContent.getParent().setStyle('height','auto');
              slideContent.getParent().fade('show');
              slideVertical.open= true;
            }           
            
            layoutFix();
       }

  
  	   // sets the SLIDE EFFECT to the buttons
  	   slideButtonH1.addEvent('click', function(e){  	   
      		e.stop();
      		if(!slideVertical.open)
      		  block.toggleClass('hidden'); // shows it
          slideVertical.toggle();
      	});

      } // <-- end go trough blocks
      
      // hide the Menu if it has class "hidden"
    	if(block.hasClass('hidden'))  { 	 
    	  slideVertical.hide();
    	  slideVertical.open = false;
    	}
  });
  
  // ADDs SMOOTHSCROLL to all ANCHORs
  var smoothAnchorScroll = new Fx.SmoothScroll({
      links: '.smoothAnchor',
      wheelStops: true,
      duration: 200
  });  
});
