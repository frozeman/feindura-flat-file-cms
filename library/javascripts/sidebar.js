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
// javascripts/sidebar.js version 0.33 (requires mootools-core and mootools-more)

// -------------------------------------------------
// SLIDE IN/OUT and MOUSEOVER RESIZE
function sidebarMenu() {
  
  	$$('.sidebarMenu').each(function(sideBarMenu) {
	   
     var slideTopButton;
	   var slideBottomButton;
	   var slideContent;
	   var slideVertical;
	   
	   
	   // ->> SLIDE IN/OUT on click -------------------------------------------------------------------------------------------
	   
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
	        if(!navigator.appVersion.match(/MSIE ([0-6]\.\d)/))
            sideBarMenu.toggleClass('hidden');
          layoutFix();          
     }

	   // -> sets the SLIDE EFFECT to the buttons
	   slideTopButton.addEvent('click', function(e){
    		e.stop();    		
    		slideVertical.toggle();
    	});
      slideBottomButton.addEvent('click', function(e){
    		e.stop();
    		slideVertical.toggle();
    	});
    	
    	// -> HIDE the Menu IF it has CLASS "HIDDEN"
    	if(sideBarMenu.hasClass('hidden')) {
          slideVertical.hide();
      }     	  
    	
     // ->> RESIZE on MouseOver -------------------------------------------------------------------------------------------
     
     // gets the length of the longest text
      var maxTextLength = 0;
      // walk trough all <li> <a> ellements an messure the <span> length
      slideContent.getElement('ul').getElements('li').each(function(passedLi) {      
        var textLength = passedLi.getElement('a').getElement('span').offsetWidth;        
        if(maxTextLength < textLength) {
          maxTextLength = textLength + 40; //+ 10 for padding
        }
      });
    	
     // -> sets the RESIZE-TWEEN to the sideBarMenu
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
}

/* ---------------------------------------------------------------------------------- */
// SIDEBAR AJAX REQUEST
// send a HTML request to load the new Sidebar content
function requestLeftSidebar(category,page,site) {
  
  var leftSideBarloadingCircle = new Element('img',{
        'id': 'leftSidebarLoadingCircle',
        'src': 'library/images/sign/loadingCircle.gif',
        'alt': 'loadingCircle'
      });
  
  // creates the request Object
  var requestCategory = new Request.HTML({
    url:'library/leftSidebar.loader.php',
    method: 'get',
    data: 'site=' + site + '&category=' + category + '&page=' + page,
    
    //-----------------------------------------------------------------------------
    onRequest: function() { //-----------------------------------------------------		
    	
        // -> TWEEN leftSidebar
        $('leftSidebar').set('tween',{duration: 150});
        $('leftSidebar').tween('left','-200px');
        //$('leftSidebar').tween('opacity',0);
        
        // -> ADD the LOADING CIRCLE
    		$('leftSidebar').grab(leftSideBarloadingCircle,'before');
    		

    },
    //-----------------------------------------------------------------------------
		onSuccess: function(html) { //-------------------------------------------------

			// Clear the text currently inside the leftSidebar div.
			$('leftSidebar').set('text', '');
			// -> ADD the new HTML elements into the leftSidebar div.
			$('leftSidebar').adopt(html);
			
			// -> TWEEN leftSidebar
			$('leftSidebar').set('tween',{duration: 500});
			$('leftSidebar').tween('left','0px');
			//$('leftSidebar').tween('opacity',1);
			
			// -> REMOVE the LOADING CIRCLE
			leftSideBarloadingCircle.destroy();
			
	    sidebarMenu();
	    layoutFix();
		},
		//-----------------------------------------------------------------------------
		//Our request will most likely succeed, but just in case, we'll add an
		//onFailure method which will let the user know what happened.
		onFailure: function() { //-----------------------------------------------------
		  var failureText = new Element('p');
		  failureText.set('text','The request failed.');
			$('leftSidebar').inject(failureText);
		  }
  }).send();
}

// *---------------------------------------------------------------------------------------------------*
//  DOMREADY
// *---------------------------------------------------------------------------------------------------*
window.addEvent('domready', function() {
  
  // makes sidebarmenu dynamic
  sidebarMenu();
  
  // ->> LOG LIST
  // ------------
  if($('sidebarTaskLog') != null) {

    // vars
    var minHeight = '200px';
    var maxHeight = '450px';
    
    // -> adds the TWEEN to the LOG-list
    $('sidebarTaskLog').setStyle('height',minHeight);
    $('sidebarTaskLog').setStyle('overflow','hidden');
    
    // TWEEN OUT
    $('sidebarTaskLog').addEvent('mouseenter', function() {
      $('sidebarTaskLog').tween('height',maxHeight);
    });
    // TWEEN IN
    $('sidebarTaskLog').addEvent('mouseleave', function() {
      $('sidebarTaskLog').tween('height',minHeight);
    });
    
    // TWEEN OUT sidebarScrollUp
    $('sidbarTaskLogScrollUp').addEvent('mouseenter', function() {
      $('sidebarTaskLog').tween('height',maxHeight);
    });
    // TWEEN IN sidebarScrollUp
    $('sidbarTaskLogScrollUp').addEvent('mouseleave', function() {
      $('sidebarTaskLog').tween('height',minHeight);
    });
    
    // TWEEN OUT sidebarScrollDown
    $('sidbarTaskLogScrollDown').addEvent('mouseenter', function() {
      $('sidebarTaskLog').tween('height',maxHeight);
    });
    // TWEEN IN sidebarScrollDown
    $('sidbarTaskLogScrollDown').addEvent('mouseleave', function() {
      $('sidebarTaskLog').tween('height',minHeight);
    });
    
    // add DIV SCROLLER
    var logScroller = new divScroller('sidebarTaskLog', {area: 200,direction: 'y', velocity: 0.4,scrollSpeed: 60});
  	// myContent
  	$('sidebarTaskLog').addEvent('mouseenter', logScroller.start.bind(logScroller));
  	$('sidebarTaskLog').addEvent('mouseleave', logScroller.stop.bind(logScroller));

   }
  
  // ->> SIDEBAR SCROLLES LIKE FIXED
  // ---------------------------
  if($('sidebarSelection') != null) {
  
    if(navigator.appVersion.match(/MSIE ([0-8]\.\d)/)) {
      $('sidebarSelection').setStyle('position','fixed');
    } else {
      // adds static scroller
      new StaticScroller('sidebarSelection',{
        offset: 1
      });
    }
  }
  
});