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
  
  // vars
  if(!page) page = 0;
  if(!category) category = 0;
  var jsLoadingCircleContainer = new Element('div', {'class':'leftSidebarLoadingCircle'});
  var removeLoadingCircle;
  
  // creates the request Object
  var requestCategory = new Request.HTML({
    url:'library/leftSidebar.loader.php',
    method: 'get',
    data: 'site=' + site + '&category=' + category + '&page=' + page,
    update: $('leftSidebar'),
    
    //-----------------------------------------------------------------------------
    onRequest: function() { //-----------------------------------------------------		
    	
        // -> TWEEN leftSidebar
        $('leftSidebar').set('tween',{duration: 150});
        $('leftSidebar').tween('left','-200px');
        //$('leftSidebar').tween('opacity',0);
        
        // -> ADD the LOADING CIRCLE
    		$('leftSidebar').grab(jsLoadingCircleContainer,'before');
    		removeLoadingCircle = feindura_loadingCircle(jsLoadingCircleContainer, 25, 40, 12, 4, "#999");

    },
    //-----------------------------------------------------------------------------
		onSuccess: function(html) { //-------------------------------------------------
			
			// -> TWEEN leftSidebar
			$('leftSidebar').set('tween',{duration: 300});
			$('leftSidebar').tween('left','0px');
			//$('leftSidebar').tween('opacity',1);
			
			$('leftSidebar').get('tween').chain(function(){
        // -> REMOVE the LOADING CIRCLE
        jsLoadingCircleContainer.destroy();
        removeLoadingCircle();
      });			
			
	    sidebarMenu();
	    setToolTips();
	    layoutFix();
		},
		//-----------------------------------------------------------------------------
		//Our request will most likely succeed, but just in case, we'll add an
		//onFailure method which will let the user know what happened.
		onFailure: function() { //-----------------------------------------------------
		  var failureText = new Element('p');
		  failureText.set('text','Couldn\'t load the sidebar?');
			$('leftSidebar').set('html',failureText);
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
    var minHeight = 200;
    var maxHeight = 450;
    
    var myScroller = new Scroller('sidebarTaskLog', {area: 150, velocity: 0.1});
    myScroller.start();
    
    // -> adds the TWEEN to the LOG-list
    $('sidebarTaskLog').setStyle('height',minHeight);
    //$('sidebarTaskLog').setStyle('overflow','hidden'); // currently deactivated, allows alos scrolling with mousewheel
 
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