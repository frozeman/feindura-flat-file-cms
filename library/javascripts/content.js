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
*
* java/content.js version 0.57 (requires mootools-core and mootools-more)
*/

// vars
var toolTips; // holds the instance of the tooltips
var deactivateType = 'disabled'; // disabled/readonly
var myCfe;
var pageContentChanged = false; // used to give a warning, if a page in the editor.php has been changed and not saved

/* GENERAL FUNCTIONS */

// *** ->> TOOLTIPS - functions -----------------------------------------------------------------------------------------------------------------------

/* set toolTips to all objects with a toolTip class */
function setToolTips() {

  //store titles and text
  feindura_storeTipTexts('.toolTip, .inputToolTip, .thumbnailToolTip');
  
  /* add Tooltips */
  toolTips = new Tips('.toolTip',{
    className: 'feindura_toolTipBox',
    //onShow: function(tip){ tip.tween('right','200px');}, //tip.fade('hide'); tip.fade('in');
    //onHide: function(tip){ tip.fade('hide'); }, //tip.fade('hide'); tip.fade('out');
    offset: {'x': 10,'y': 15},
    fixed: false,
    showDelay: 200,
    hideDelay: 0 });
  
  /* thumbnailToolTip */
  var toolTipsInput = new Tips('.thumbnailToolTip',{
    className: 'feindura_toolTipBox',
    offset: {'x': -320,'y': -20},
    fixed: true,
    showDelay: 130,
    hideDelay: 100 });
  
  // -> window is smaller 1255px
  if(window.getSize().x < 1255) {
    /* inputToolTip */
    var toolTipsInput = new Tips('.inputToolTip',{
      className: 'feindura_toolTipBox',
      offset: {'x': -275,'y': -20},
      fixed: true,
      showDelay: 100,
      hideDelay: 100 });    
      
  // -> window is larger 1255px   
  } else {
    /* inputToolTip */
    var toolTipsInput = new Tips('.inputToolTip',{
      className: 'feindura_toolTipBox',
      offset: {'x': 500,'y': -20},
      fixed: true,
      showDelay: 100,
      hideDelay: 100 });

  }
}

// *** ->> SETUP - functions -----------------------------------------------------------------------------------------------------------------------
 
// ------------------------------------------------------------------------------
// ADD a INPUT FIELD
function addField(containerId,inputName) {
  
  //var newInput = new Element('input', {name: inputName});
  
  if(containerId && $(containerId) != null) {
    var newInput  = new Element('input', {name: inputName});
    $(containerId).grab(newInput,'bottom');
		return true;
  } else
    return false;
}

// ------------------------------------------------------------------------------
// SET UP the REALTIME THUMBNAIL SIZE SCALE, all given vars are the object IDs
function setThumbScale(thumbWidth,thumbWidthScale,thumbHeight,thumbHeightScale) {
  
  var scaleWidth = function(){
        $(thumbWidthScale).tween('width',$(thumbWidth).get('value'));
      };
  var scaleHeight = function(){
        $(thumbHeightScale).tween('width',$(thumbHeight).get('value'));
      };
  
  // thumbwidth
  if($(thumbWidth) != null) {
      $(thumbWidth).addEvents({
        'keyup': scaleWidth,
        'mouseup': scaleWidth
      });
  }
  // thumbheight
  if($(thumbHeight) != null) {
      $(thumbHeight).addEvents({
        'keyup': scaleHeight,
        'mouseup': scaleHeight
      });
  }
}

// ------------------------------------------------------------------------------
// DISABLE THUMBNAIL SIZE IF RATIO is ON, all given vars are the object IDs
function setThumbRatio(thumbWidth,thumbWidthRatio,thumbHeight,thumbHeightRatio,thumbNoRatio) {
    
  // thumbwidth
  if($(thumbWidthRatio) != null) {
      $(thumbWidthRatio).addEvent('click', function() {
          $(thumbHeight).setProperty(deactivateType,deactivateType);
          $(thumbWidth).removeProperty(deactivateType);
      });
  }
  
  // thumbheight
  if($(thumbHeightRatio) != null) {
      $(thumbHeightRatio).addEvent('click', function() {
          $(thumbWidth).setProperty(deactivateType,deactivateType);
          $(thumbHeight).removeProperty(deactivateType);
      });
  }
    
  // no Ratio
  if($(thumbNoRatio) != null) {
      $(thumbNoRatio).addEvent('click', function() {
          $(thumbWidth).removeProperty(deactivateType);
          $(thumbHeight).removeProperty(deactivateType);
      });
  }
}

// -------------------------------------------------
// -> editFiles
function changeEditFile( site, fileName, status, anchorName ) {
  window.location.href = window.location.pathname + "?site=" + site + "&status=" + status + "&file=" + fileName + "#" + anchorName ;
}

// -------------------------------------------------
// -> on SUBMIT goto ANCHOR
function submitAnchor(formId,anchorName) {
    
  // IE
  if(Browser.ie6 || Browser.ie7) {
    // get form
    var form = document.getElementById(formId);
    // create new action attribute
    var attr = document.createAttribute('action');
    if(form.getAttributeNode('action').nodeValue.contains('#')) return;
    attr.nodeValue = form.getAttributeNode('action').nodeValue + '#' + anchorName;
    // set new action attribute
    form.setAttributeNode(attr);
  // ALL the OTHERS
  } else {
    if($(formId).getAttribute('action').contains('#')) return;
    $(formId).setAttribute('action',($(formId).getAttribute('action') + '#' + anchorName));
  }
}

// *** ->> CONTENT - functions -----------------------------------------------------------------------------------------------------------------------

// -------------------------------------------------
// remove the checked="checked" property from a selection of elements
function removeChecked(selector) {
  $$(selector).each(function(selection) {
    selection.removeProperty('checked');
  });
}

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
        thumbnail.setStyle('width',oldWidth);
        
        // set tween
        thumbnail.set('tween',{duration: '500', transition: Fx.Transitions.Pow.easeOut});
        
        //mouseover      
        thumbnail.addEvent('mouseenter',function() {
          thumbnail.tween('width',orgWidth);
        });
        
        // mouseout
        thumbnail.addEvent('mouseleave',function() {
        thumbnail.tween('width',oldWidth);
        });
      
      }
    });  
}

// -------------------------------------------------
// BLOCK SLIDE IN/OUT
function blockSlider(givenId) {
  
  var blocksInDiv = '';
  var scrollToElement = new Fx.Scroll(window,{duration: 300,transition: Fx.Transitions.Quint.easeInOut});
  
  // prepares the given container div id or class
  if(givenId)
    blocksInDiv = givenId + ' ';
  
  $$(blocksInDiv + '.block').each(function(block,i) {	   
     var h1SlideButton;
	   var slideContent;
	   var bottomBorder;
	   
	   // gets the <a> tag in the <h1>
     if(block.getElement('h1') !== null && block.getElement('h1').getElement('a')) {
      
       h1SlideButton = block.getElement('h1').getElement('a');
      
       block.getElements('div').each(function(passedDiv) {
         // gets slideing content
         if(passedDiv.hasClass('content')) {
           slideContent = passedDiv;
         }
         if(passedDiv.hasClass('bottom')) {
           bottomBorder = passedDiv;
         }
      });      
      
  	  // -> CREATE the SLIDE EFFECT
  	  slideContent.set('slide',{
        duration: 500,
        //transition: Fx.Transitions.Pow.easeInOut, //Fx.Transitions.Back.easeInOut
        transition: Fx.Transitions.Quint.easeInOut,
        onComplete: function(el) {
          layoutFix();
          if(!slideContent.getChildren('textarea.editFiles')[0]) { // necessary for CodeMirror to calculate the size of the Codemirror div
            if(!this.open) {
                slideContent.setStyle('display','none'); // to allow sorting above the slided in box
                this.wrapper.setStyle('height',slideContent.getSize().y);
                //this.open = false;
            } else {
                this.wrapper.setStyle('height','auto'); // mootools creates an container around slideContent, so that it doesn't resize anymore automaticly, so i have to reset height auto for this container
                //this.open = true;              
            }
          }
        }
      });

      // DONT show the content bottom if IE 0-7
      if(Browser.ie6 || Browser.ie7)
        bottomBorder.setStyle('display', 'none');
      if(Browser.ie6 || Browser.ie7 || Browser.ie8)
        slideContent.set('slide',{transition: Fx.Transitions.Pow.easeInOut});

      // -> set click Event for the SLIDE EFFECT to the buttons
      h1SlideButton.addEvent('click', function(e) {
      	  e.stop();
     	    if(!slideContent.get('slide').open) {
     	      scrollToElement.start(window.getPosition().x,block.getPosition().y - 80);
      	    slideContent.setStyle('display','block'); // to allow sorting above the slided in box (reset)
      	    block.removeClass('hidden'); // change the arrow
          } else
            block.addClass('hidden'); // change the arrow
          slideContent.slide('toggle');
      });
      
      // -> hide the block at start, if it has class "hidden"
      if(block.hasClass('hidden'))  {
        slideContent.slide('hide');
        if(!slideContent.getChildren('textarea.editFiles')[0]) // necessary for CodeMirror to calculate the size of the Codemirror div
          slideContent.setStyle('display','none'); // to allow sorting above the slided in box	    
      }
    } // <-- end go trough blocks      
  });
}

// -------------------------------------------------
// BLOCK SLIDE IN/OUT
function inBlockTableSlider() {
  
  var count = 0;
  var slideLinks = new Array();
  
  // -> GO TROUGH every CATEGORY
  if($$('.block .inBlockSlider') != null && $$('.block .inBlockSliderLink') != null) {
    
    // -----------------------------------------
    // ADD SLIDE TO TABLEs inside a BLOCK
    $$('.block').each(function(block) {
      
      // gets the SLIDE links
      block.getElements('.inBlockSliderLink').each(function(insideBlockLinks) {
        slideLinks.push(insideBlockLinks);
      });
      
      block.getElements('.inBlockSlider').each(function(insideBlockTable) {        
         
         // ON COMPLETE
         insideBlockTable.get('slide').addEvent('complete', function(el) {
              layoutFix();
              // mootools creates an container around slideContent, so that it doesn't resize anymore automaticly, so i have to reset height auto for this container
              if(this.open) {
                insideBlockTable.get('slide').wrapper.fade('show');
              } else {              
                insideBlockTable.get('slide').wrapper.fade('hide');
              }
          });
        
         // slides the hotky div in, on start
         if(insideBlockTable.hasClass('hidden')) {
           //hides the wrapper on start
           insideBlockTable.slide('hide');
           insideBlockTable.get('slide').wrapper.fade('hide');
         }
         
         // sets the SLIDE effect to the SLIDE links
         slideLinks[count].addEvent('click', function(e) {
            if(e.target.match('a')) e.stop();
        		insideBlockTable.get('slide').toggle();
        		insideBlockTable.get('slide').wrapper.fade('show');
        		insideBlockTable.toggleClass('hidden');
        	});
         
         count++;      
      });       
    });
  }
}

/* pageChangedSign function 
adds a * to the head and the sideBarMenu link of the page, to show that the page was modified, but not saved yet */
function pageContentChangedSign() {
  if($('editorForm') != null && !pageContentChanged) {
    $$('.notSavedSign' + $('editorForm').get('class')).each(function(notSavedSign) {
      notSavedSign.setStyle('display','inline');
    });
  }
}

// *** ->> SIDEBARS - functions -----------------------------------------------------------------------------------------------------------------------
  
// vars
var sidbarMenuTextLength;

function setSidbarMenuTextLength() {
  sidbarMenuTextLength = 0;
  // gets the length of the longest text
  // walk trough all <li> <a> ellements an messure the <span> length
  $$('.sidebarMenu ul li').each(function(passedLi) {
    var textLength = passedLi.getElement('a').getElement('span').offsetWidth;
    if(sidbarMenuTextLength < textLength) {
      sidbarMenuTextLength = textLength + 30; //+ 30 for padding
    }
  });
}

// -------------------------------------------------
// SLIDE IN/OUT and MOUSEOVER RESIZE
function sidebarMenu() {
    
    setSidbarMenuTextLength();
  
  	$$('.sidebarMenu').each(function(sideBarMenu) {
	       
    // ->> SLIDE IN/OUT on click -------------------------------------------------------------------------------------------	   
    // gets the <a> tag in the <div class="content"> container and <div class="bottom">
    
    // gets the upper toogle button    
    var slideTopButton = sideBarMenu.getChildren('div.top a')[0];    
    // gets the bottom toogle button    
    var slideBottomButton = sideBarMenu.getChildren('div.bottom a')[0];    
    // gets slideing content
    var slideContent = sideBarMenu.getChildren('div.content')[0];
    
    
    // creates the slide effect
    slideContent.set('slide',{duration: '750', transition: Fx.Transitions.Pow.easeOut});	   
    
    // changes the up and down button class from the <div class="top">
    // so that the picture of the upper Toogle Buttons changes
    slideContent.get('slide').addEvent('complete', function(el) {
        if(!navigator.appVersion.match(/MSIE ([0-6]\.\d)/))
          sideBarMenu.toggleClass('hidden');
        layoutFix();
    });
    
    // -> sets the SLIDE EFFECT to the buttons
    slideTopButton.addEvent('click', function(e){
    	e.stop();    		
    	slideContent.get('slide').toggle();
    });
    slideBottomButton.addEvent('click', function(e){
    	e.stop();
    	slideContent.get('slide').toggle();
    });
    
    // -> HIDE the Menu IF it has CLASS "HIDDEN"
    if(sideBarMenu.hasClass('hidden')) {
      slideContent.get('slide').hide();
    }     	  
    
    // ->> RESIZE on MouseOver -------------------------------------------------------------------------------------------     
    
    // -> sets the RESIZE-TWEEN to the sideBarMenu
    sideBarMenu.set('tween', {duration: '650', transition: Fx.Transitions.Pow.easeOut});
    
    slideContent.addEvent('mouseover', function(e){
    	e.stop();
    	
    	if(sidbarMenuTextLength > 210) {
    	  sideBarMenu.tween('width', sidbarMenuTextLength);
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
function requestLeftSidebar(site,page,category) {
  
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
  });
  
  // send only the site
  if(!page && !category)
    requestCategory.send('site=' + site);
  // or with the data string
  else
    requestCategory.send();
}

// *---------------------------------------------------------------------------------------------------*
//  LOAD (if all pics are loaded)
// *---------------------------------------------------------------------------------------------------*
window.addEvent('load', function() {

    autoResizeThumbnailPreview();    
    
    // SCROLL to ANCHORS  (should fix chrome and safari scroll problem)
    if(Browser.safari || Browser.chrome) {
      var anchorId = window.location.hash.substring(1);
      if($(anchorId) != null)
        (function(){ new Fx.Scroll(window,{duration:100}).set(0,this.getPosition().y); }).delay(100,$(anchorId));
    }
});

// *---------------------------------------------------------------------------------------------------*
//  DOMREADY
// *---------------------------------------------------------------------------------------------------*
window.addEvent('domready', function() {
  
  // *** ->> SIDEBAR MENU -----------------------------------------------------------------------------------------------------------------------
  
  // makes sidebarmenu dynamic
  sidebarMenu();
  
  // let the errorWindow clos by ESC or ENTER keys
  if($('feindura_errorWindow') != null) {
    document.addEvent('keyup',function(e){
      if(e.key == 'esc' || e.key == 'enter')
        feindura_closeErrorWindow(e);
    });
  }
  
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
  if($('sidebarSelection') != null && $('sidebarSelection').hasClass('staticScroller')) {
    // adds static scroller
    new StaticScroller('sidebarSelection');
  }

  // reload the currentVisitors statistic every 1/2 minute
  if($('currentVisitorsSideBar') != null) {
    (function(){
      new Request({
        url:'library/includes/currentVisitors.include.php',
        data: 'request=true',
        onSuccess: function(html) {
          if(html) {
            toolTips.detach('a.toolTip');
            $('currentVisitorsSideBar').set('html',html);
            feindura_storeTipTexts('a.toolTip');
            toolTips.attach('a.toolTip');
          } else
            $('currentVisitorsSideBar').set('html','');
        }      
      }).send();
    }).periodical(30000);
  }
  
  // *** ->> ADMIN-MENU -----------------------------------------------------------------------------------------------------------------------
    
  if($('adminMenu') != null) {
    // set the style back, which is set for non javascript users
    $('adminMenu').setStyle('width','172px');
    $('adminMenu').setStyle('overflow','hidden');
    
    // set tween
    $('adminMenu').set('tween',{duration: 350, transition: Fx.Transitions.Quint.easeInOut});
    
    // add resize tween event
    $('adminMenu').addEvents({
      mouseenter : function() { // resize on mouseover
        $('adminMenu').scrollTo(0,0);
        $('adminMenu').tween('height',($('adminMenu').getChildren('.content table')[0].offsetHeight + 40) + 'px');
      },
      mouseleave : function() { // resize on onmouseout
        $('adminMenu').tween('height','140px');
      }
    });
  }
  
  // *** ->> CONTENT -----------------------------------------------------------------------------------------------------------------------
  
  // BLOCK SLIDE IN/OUT
	blockSlider();
	inBlockTableSlider();
  
  // ADDs SMOOTHSCROLL to ANCHORS
  var smoothAnchorScroll = new Fx.SmoothScroll({
      wheelStops: true,
      duration: 200
  });
  
  // -------------------------------------------------------------------------------------------
  // TOOLTIPS
  setToolTips();
  
  // *** ->> LISTPAGES -----------------------------------------------------------------------------------------------------------------------
    
  // -------------------------------------------------------------------------------------------
  // TWEEN FUNCTIONS in LIST PAGES ---------------------------------------------------------------
  if($$('ul li div.functions') != null) {
    
    $$('ul li').each(function(li) {
      var functionsDiv = false;
      
      // get the .functions div
      li.getElements('div').each(function(divs) {
        if(divs.hasClass('functions')) {
          functionsDiv = divs;
        }
      });
      
      // add fade in and out event on mouseover
      if(functionsDiv != false) {
        functionsDiv.set('tween',{duration: '1500', transition: Fx.Transitions.Pow.easeOut});
        
        li.addEvent('mouseover',function(e) {
          e.stop();
          
          if(navigator.appVersion.match(/MSIE [0-8]/)) functionsDiv.tween('width','140px');
          else functionsDiv.tween('opacity','1');
        });
        li.addEvent('mouseout',function(e) {
          e.stop();
          if(navigator.appVersion.match(/MSIE [0-8]/)) functionsDiv.tween('width','0px');
          else functionsDiv.tween('opacity','0.2');
        });      
      
        // HIDE the functions AT STARTUP
        if(navigator.appVersion.match(/MSIE [0-8]/)) functionsDiv.setStyle('width','0px');
        else functionsDiv.setStyle('opacity','0.2');          
      }
      
    });    
  }
  
  // -------------------------------------------------------------------------------------------
  // FILTER LIST PAGES -------------------------------------------------------------------------
  if($('listPagesFilter') != null) {
    var cancelListPagesFilter = function() {$('listPagesFilter').set('value',''); $('listPagesFilter').fireEvent('keyup');};
    var openBlocks = new Array();
    var storedOpenBlocks = false;
    $('listPagesFilter').addEvent('keyup',function(e){
      
      // vars
      var filter = this.get('value');
      
      // ->> FILTER the PAGES
      if(filter) {
        $$('div.block.listPages li').each(function(page) {
          if(page.getChildren('div.name a')[0] != null && !page.getChildren('div.name a')[0].get('text').toLowerCase().contains(filter.toLowerCase()))
            page.setStyle('display','none');
          else
            page.setStyle('display','block');
        });
      } else {
        $$('div.block.listPages li').each(function(page) {
          page.setStyle('display','block');
        });
      }
      
      // ->> SLIDE all blocks IN
      if(filter.length == 1) {
        $('listPagesFilterCancel').addEvent('click',cancelListPagesFilter);
        $('listPagesFilterCancel').setStyle('display','block');
        
        $$('div.block.listPages div.content').each(function(block){
          if(block.getParent('div.listPages').hasClass('hidden')) {
      	    block.getParent('div.listPages').removeClass('hidden'); // change the arrow
      	    block.setStyle('display','block'); // to allow sorting above the slided in box (reset)
      	    block.slide('show');
      	    block.get('slide').wrapper.setStyle('height','auto');
      	    layoutFix();
      	  
      	  // store the open blocks
    	    } else if(!storedOpenBlocks) {
            openBlocks.push(block);
          }
        });
        storedOpenBlocks = true;
        
      // ->> SLIDE the blocks OUT again, besides the one which was in at the beginning
      } else if(filter == '' && storedOpenBlocks) {
        $('listPagesFilterCancel').removeEvent('click',cancelListPagesFilter);
        $('listPagesFilterCancel').setStyle('display','none');
        
        $$('div.block.listPages div.content').each(function(block){
          if(!openBlocks.contains(block)) {    	    
      	    block.getParent('div.listPages').addClass('hidden'); // change the arrow
            block.slide('hide');          
            block.setStyle('display','none'); // to allow sorting above the slided in box (reset)
            block.get('slide').wrapper.setStyle('height',block.getSize().y);
            layoutFix();
          }
        });
        // clean the stored blocks array      
        if(storedOpenBlocks) {       
          openBlocks.empty();
          storedOpenBlocks = false;
        }
      }
    });
  }
  
  // -------------------------------------------------------------------------------------------
  // LIST PAGES SORTABLE -----------------------------------------------------------------------
  var clicked = false;
  var categoryOld;
  var categoryNew;
    
  if($('sortablePageList_status') != null)
    var sortablePageList_status = $('sortablePageList_status').get('value').split("|");

  var preventLink = function (){
      return false;
  }  
  
	var sb = new Sortables('.sortablePageList', {
		/* set options */
		//clone: true,
		revert: true,
		opacity: 1,
		snap: 10,
			
		/* --> initialization stuff here */
		initialize: function() {
        
		},
		/* --> once an item is selected */
		onStart: function(el,elClone) {
			el.setStyle('background-position', '0px -81px');
      			
			categoryOld = el.getParent().get('id').substr(8); // gets the category id where the element comes from

		},
    // check if sorted	
		onSort: function(el){
  		clicked = true;
  		$$('.sortablePageList a').each(function(a) { a.addEvent('click',preventLink); }); // prevent clicking the link on sort
  	},		
		/* --> when a drag is complete */
		onComplete: function(el) {
			
			// --> SAVE SORT ----------------------
			/* nur wenn sortiert wurde wird werden die seiten neu gespeichert */
			if(clicked) {
			clicked = false;
			
			categoryNew = el.getParent().get('id').substr(8); // gets the category id where the element comes from
			var sortedPageId = el.get('id').substr(4);

			// build a string of the order
			var sort_order = '';
      var count_sort = 0;
          
			$$('.sortablePageList li').each(function(li) {
        if(li.getParent().get('id') == el.getParent().get('id') && li.get('id') != null) {
          sort_order = sort_order + li.get('id').substr(4)  + '|'; count_sort++;
        } });
			$('sort_order' + categoryNew).value = sort_order;
			
			// if pages has changed the category id in the href!
			if(categoryOld != categoryNew) {
        el.getElements('div').each(function(div){
            if(div.hasClass('name')) {
                var oldHref = String(div.getElement('a').get('href'));
                var newHref = oldHref.replace('category=' + categoryOld,'category=' + categoryNew);                
                div.getElement('a').set('href',newHref);
            }
            
            if(div.hasClass('status')) {
                var oldHref = String(div.getElement('a').get('href'));      
                var newHref = oldHref.replace('category=' + categoryOld,'category=' + categoryNew);                
                div.getElement('a').set('href',newHref);
            }
            
            if(div.hasClass('functions')) {
                div.getElements('a').each(function(a){
                  var oldHref = String(a.get('href'));
                  var newHref = oldHref.replace('category=' + categoryOld,'category=' + categoryNew);                
                  a.set('href',newHref);
                  
                  if(a.hasClass('deletePage')) {
                      var oldHref = String(a.get('onclick'));
                      var newHref = oldHref.replace('category=' + categoryOld,'category=' + categoryNew);                
                      a.set('onclick',newHref);
                  }                    
                });                
            }
        });
      }
			
			// --> sortiert die Seite mithilfe einer AJAX anfrage an library/controllers/sortPages.controller.php	------------------------------
				var req = new Request({
					url:'library/controllers/sortPages.controller.php',
					method:'post',
					//autoCancel:true,
					data:'sort_order=' + sort_order + '&categoryOld=' + categoryOld +'&categoryNew=' + categoryNew + '&sortedPageId=' + sortedPageId , // + '&do_submit=1&byajax=1&ajax=' + $('auto_submit').checked
					//-------------------------------------
          onRequest: function() {
            
					
            // put the save new order - text in the loadingBox AND show the loadingBox
            $('loadingBox').getChildren('.content').set('html','<span style="color:#D36100;font-weight:bold;font-size:18px;">'+sortablePageList_status[0]+'</span>');
            $('loadingBox').setStyle('display','block');
            $('loadingBox').fade('hide');
            $('loadingBox').fade('in');
            
		},
		//-------------------------------------
		onSuccess: function(responseText) {

		  // FINAL SORT MESSAGE
		  //puts the right message which is get from the sortablePageList_status array (hidden input) in the messageBox
		  //$('messageBox_input').set('html',sortablePageList_status[responseText.substr(6,1)]);
		  $('messageBox_input').set('html','<img src="library/images/icons/hintIcon.png" class="hintIcon" /><span style="color:#407287;font-weight:bold;">' + responseText + '</span>');
			
			// remove prevent clicking the link on sort
			$$('.sortablePageList a').each(function(a) { a.removeEvent('click',preventLink); });
			
			// remove the "no pages notice" li if there is a page put in this category
		    $$('.sortablePageList li').each(function(li) { 
			if(li.get('id') == null && li.getParent().get('id').substr(8) == categoryNew && responseText.substr(-1) != '4') {
			  li.destroy();
			}
		    });

		    // adds the "no page - notice" li if the old category is empty
		    if(responseText.substr(0,13) == '<span></span>') {              
		      $$('.sortablePageList').each(function(ul) {
      			if(ul.get('id').substr(8) == categoryOld) { // && responseText.substr(-1) != '4'
      			  var newLi = new Element('li', {html: '<div class="emptyList">' + sortablePageList_status[1] + '</div>'});
      			  newLi.setStyle('cursor','auto');
      			  ul.grab(newLi,'top');
      			}
		      });
		    }

		    // RELOADS the sidebarMenu
		    requestLeftSidebar('pages','0',categoryNew);

		    // hide the loadingBox
		    //$('loadingBox').setStyle('visibility','hidden');
		    $('loadingBox').fade('show');
		    $('loadingBox').fade('out');
		}
	     }).send();

	   } // <-- SAVE SORT -- END --------------------
	 }
	});  
  
  // makes the "no pages notice" li un-dragable
  $$('.sortablePageList li').each(function(li) {
      if(li.get('id') == null) {
        li.removeEvents(); 
        li.setStyle('cursor','auto');
      }
  });
  
  // *** ->> SETUP -----------------------------------------------------------------------------------------------------------------------
  
  // -> ADD auto grow to textareas which have the "autogrow" class
  $$('textarea.autogrow').each(function(textarea){
    new Form.AutoGrow(textarea);
  });  
  
  // ->> ADMIN-SETUP
  // ---------------
  
  // -> adds realtime THUMBSCALE to the thumbnail Settings
  setThumbScale('cfg_thumbWidth','thumbWidthScale','cfg_thumbHeight','thumbHeightScale');
  
  // -> adds THUMBRATIO deactivation
  setThumbRatio('cfg_thumbWidth','ratioX','cfg_thumbHeight','ratioY','noRatio');
  
  // -> adds Fields to styleSheetsFilePaths
  $$('.addStyleFilePath').each(function(addButton){
    if(addButton != null) {
      var containerId = addButton.getParent().getElement('div').getProperty('id');
      var inputName = addButton.getParent().getElement('div').getElement('input').getProperty('name');
      
      addButton.addEvent('click', function(e) {
        e.stop();
  			addField(containerId,inputName);
  		});
    }
  });
    
  // -> DISABLE varNames if SPEAKING URL is selected
  if($('cfg_speakingUrl') != null) {
    var smallSize = '50px';
    
    $('cfg_speakingUrl').addEvent('change',function() {      
      // disables all varNames fields is option value == true; speaking url
      if($('cfg_speakingUrl')[$('cfg_speakingUrl').selectedIndex].value == 'true') {
        $('cfg_varNamePage').setProperty(deactivateType,deactivateType);
        $('cfg_varNamePage').tween('width',smallSize);
        $('cfg_varNameCategory').setProperty(deactivateType,deactivateType);
        $('cfg_varNameCategory').tween('width',smallSize);
        //$('cfg_varNameModul').setProperty(deactivateType,deactivateType);
        //$('cfg_varNameModul').tween('width',smallSize);
      // activates thema if link with vars
      } else {
        $('cfg_varNamePage').removeProperty(deactivateType);
        $('cfg_varNamePage').tween('width','300px');
        $('cfg_varNameCategory').removeProperty(deactivateType);
        $('cfg_varNameCategory').tween('width','300px');
        //$('cfg_varNameModul').removeProperty(deactivateType);
        //$('cfg_varNameModul').tween('width','300px');
      }      
    });
  }
  
  
  // ->> PAGE SETUP
  // ---------------
  
  // -> GO TROUGH every CATEGORY and add thumbScale to the advanced category settings
  if($$('.advancedcategoryConfig') != null) {    
    var countCategories = 0;
    // -----------------------------------------
    // ADD SLIDE TO THE ADVANCED CATEGORY SETTINGS
    // go trough every advancedcategoryConfig class and add the slide effect
    $$('.categoryConfig').each(function(categoryConfig) {
      // count categories
      countCategories++;
      // -----------------------------------------
      // adds realtime THUMBSCALE to the advanced category settings
      setThumbScale('categories'+countCategories+'thumbWidth','categories'+countCategories+'thumbWidthScale','categories'+countCategories+'thumbHeight','categories'+countCategories+'thumbHeightScale');
      // adds THUMBRATIO deactivation
      setThumbRatio('categories'+countCategories+'thumbWidth','categories'+countCategories+'ratioX','categories'+countCategories+'thumbHeight','categories'+countCategories+'ratioY','categories'+countCategories+'noRatio'); 
    });
  }
  
  // ----------------------------------------------------
  // ADD CodeMirror TO ALL TEXTAREAs with class editFiles
  $$('textarea.editFiles').each(function(textarea){
    // var
    var hlLine;
    var mode;
    if(textarea.hasClass('css') || textarea.hasClass('php'))
      mode = textarea.getProperty('class').replace('editFiles ','');
    else if(textarea.hasClass('js'))
      mode = 'javascript';
    else
      mode = 'htmlmixed';
     
    var editor = CodeMirror.fromTextArea(textarea, {
      mode: mode,
      lineNumbers: false,
      onCursorActivity: function() {
        editor.setLineClass(hlLine, null);
        hlLine = editor.setLineClass(editor.getCursor().line, "CodeMirrorActiveline");
      }
    });
  });
  
  // *** ->> FORMS -----------------------------------------------------------------------------------------------------------------------
    
  // ------------------------------------------------------------
  // makes inputs who are empty transparent, and fade in on mouseover
  if($$('.right input') != null) {
        //var smallSize = 50;
        var fade = 0.6;
        
        $$('.right input, .listPagesHead input').each(function(input) {
            // looks for empty inputs
            if(!input.hasClass('noResize') && (input.get('value') == '' || input.get('disabled') != false)) {
                
                var hasFocus = false;
                var hasContent = false;
                
                var inputWidthBefore = input.getStyle('opacity');
                input.setStyle('opacity', fade); //makes the input small
                
                input.set('tween',{duration: '500', transition: Fx.Transitions.Sine.easeOut}) //Bounce.easeOut
                
                input.addEvents({
                  'mouseover' : function() { // resize on mouseover
                      input.tween('opacity',inputWidthBefore);
                  },
                  'focus' : function(){ // if onfocus set hasFocus = true
                      hasFocus = true;
                      input.tween('opacity',inputWidthBefore);
                  },
                  'blur' : function() { // if onblur set hasFocus = false and tween to small if the input has still no content
                      hasFocus = false;
                      if(input.get('value') == '')
                        input.tween('opacity',fade);
                  },
                  'mouseout' : function() { // onmouseout, if has not focus tween to small
                      if(!hasFocus && input.get('value') == '')
                        input.tween('opacity',fade);
                  }
                });
            }
        });
  }
  
  
  // ------------------------------------------------------------
  // ADD FANCY-FORM
  feinduraFancyForm = new FancyForm('input[type="checkbox"], input[type="radio"]');
  
  // ADD DEPENCIES for CHECKBOXES
  $$('input[type="radio"]').each(function(checkbox) {
    var checkboxId = checkbox.get('id');
    
    // go trough checkboxes with id
    if(checkboxId) {

      // -> ** categories[0-9]sortByPageDate
      if(checkboxId.match(/^categories[0-9]+sortByPageDate$/)) {
        var categoryNumber = checkboxId.match(/[0-9]+/);
        feinduraFancyForm.setDepency(checkbox,$('categories'+categoryNumber+'showPageDate'));
        feinduraFancyForm.setDepency($('categories'+categoryNumber+'showPageDate'),$('categories'+categoryNumber+'sortByPageDate'),false,false); 
      }
    }
  });
  // set depency for page sortingByDate
  feinduraFancyForm.setDepency($('cfg_pageSortByPageDate'),$('cfg_pagePageDate'));
  feinduraFancyForm.setDepency($('cfg_pagePageDate'),$('cfg_pageSortByPageDate'),false,false);
  
  
  // *** ->> EDITOR -----------------------------------------------------------------------------------------------------------------------
  if($('HTMLEditor') != null) { 
    
    // vars
    var editorStartHeight = window.getSize().y * 0.25;
    var editorTweenToHeight = (window.getSize().y * 0.42 > 380) ? window.getSize().y * 0.42 : 380;
    var editorHasFocus = false;
    var editorIsClicked = false;
    var editorSubmited = false;
    var editorSubmitHeight = $('HTMLEditorSubmit').getSize().y;
    //$('HTMLEditorSubmit').setStyle('height',0);
    $$('#content .editor .content').setStyle('display','block'); // shows the hot keys  

    // ------------------------------
    // CONFIG the HTMlEditor
    CKEDITOR.config.dialog_backgroundCoverColor   = '#333333';
    CKEDITOR.config.uiColor                       = '#cccccc';
    CKEDITOR.config.width                         = 792;
    if($('documentSaved') != null && $('documentSaved').hasClass('saved'))
      CKEDITOR.config.height                      = editorTweenToHeight;
    else
      CKEDITOR.config.height                      = editorStartHeight;
    CKEDITOR.config.resize_minWidth               = 792;
    CKEDITOR.config.resize_maxWidth               = 1400;
    CKEDITOR.config.resize_minHeight              = (editorStartHeight+136);
    CKEDITOR.config.resize_maxHeight              = 900;
    CKEDITOR.config.forcePasteAsPlainText         = true;
    CKEDITOR.config.scayt_autoStartup             = false;
    CKEDITOR.config.colorButton_enableMore        = true;
    CKEDITOR.config.entities                      = false;
    CKEDITOR.config.extraPlugins                  = 'stylesheetparser,Media';
    CKEDITOR.config.protectedSource.push( /<\?[\s\S]*?\?>/g ); // protect php code
    
    //CKEDITOR.config.disableNativeSpellChecker = false;
    
    CKEDITOR.config.toolbar = [
                              ['Save','-','Maximize','-','Source'],
                              ['Undo','Redo','-','RemoveFormat','SelectAll'],
                              ['Paste','PasteText','PasteFromWord'],
                              ['Print'],
                              ['Find','Replace','-','SpellChecker', 'Scayt'],
                               '/',
                              ['Bold','Italic','Underline','Strike'],
                              ['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
                              ['Outdent','Indent'],
                              ['Subscript','Superscript'],                                          
                              ['NumberedList','BulletedList'],
                              ['Blockquote','HorizontalRule','Table'],                              
                              ['Link','Unlink','Anchor'],
                              ['Image','Flash','Media'],
                              ['SpecialChar'],
                               '/',
                              ['Styles','Format','FontSize'], // 'Font','FontName',
                              ['TextColor','BGColor','-'],
                              ['ShowBlocks','-','About']
                              ];		// No comma for the last row.
  
    // -> CREATES the editor instance, with replacing the textarea with the id="HTMLEditor"
  	var HTMLEditor = CKEDITOR.replace('HTMLEditor');
  	
  	// -> adds the EDITOR SLIDE IN/OUT tweens
  	if($('documentSaved') != null && !$('documentSaved').hasClass('saved')) {
    	HTMLEditor.on('instanceReady',function() {
    	  $('cke_contents_HTMLEditor').set('tween',{duration:300, transition: Fx.Transitions.Pow.easeOut});
    	  
    	  var editorTweenTimeout;
    	  
        $('cke_HTMLEditor').addEvent('mouseenter',function(e){
          if(!editorIsClicked && !editorSubmited && !editorHasFocus && $('cke_contents_HTMLEditor').getHeight() <= (editorStartHeight+20)) editorTweenTimeout = (function(){$('cke_contents_HTMLEditor').tween('height',editorTweenToHeight)}).delay(1000);
          
        });
        $$('div.editor').addEvent('mouseleave',function(e){
          clearTimeout(editorTweenTimeout);
          if(!editorIsClicked && !editorSubmited && !editorHasFocus && $('cke_contents_HTMLEditor').getHeight() <= (editorTweenToHeight+5) && $('cke_contents_HTMLEditor').getHeight() >= (editorTweenToHeight-5)) $('cke_contents_HTMLEditor').tween('height',editorStartHeight);
          //editorIsClicked = false;
        });
        /*
        $('cke_HTMLEditor').addEvent('mousedown',function(e){
          editorIsClicked = true;
          $('cke_contents_HTMLEditor').get('tween').cancel();
          clearTimeout(editorTweenTimeout);
        });
        $('cke_HTMLEditor').addEvent('mouseup',function(e){
          editorIsClicked = false;
          $('cke_contents_HTMLEditor').get('tween').cancel();
          clearTimeout(editorTweenTimeout);
        });
        */
        
        /*
        HTMLEditor.on('blur',function() {
          editorHasFocus = false;
          clearTimeout(editorTweenTimeout);
          if(!editorSubmited && $('cke_contents_HTMLEditor').getHeight() <= (editorTweenToHeight+20)) $('cke_contents_HTMLEditor').tween('height',editorStartHeight);
          //$('HTMLEditorSubmit').tween('height',0);
        });
        */
        HTMLEditor.on('focus',function() {
          editorHasFocus = true;
          clearTimeout(editorTweenTimeout);
          if(!editorSubmited && $('cke_contents_HTMLEditor').getHeight() <= (editorStartHeight+20)) $('cke_contents_HTMLEditor').tween('height',editorTweenToHeight);
          //$('HTMLEditorSubmit').tween('height',editorSubmitHeight);
        });
        
        /*
        HTMLEditor.on('dialogShow',function() {
          editorHasFocus = true;
          clearTimeout(editorTweenTimeout);
          $('cke_contents_HTMLEditor').get('tween').cancel();
          //$('HTMLEditorSubmit').get('tween').cancel();
          if(!editorSubmited && $('cke_contents_HTMLEditor').getHeight() <= (editorStartHeight+20)) $('cke_contents_HTMLEditor').setStyle('height',editorTweenToHeight);
          //$('HTMLEditorSubmit').setStyle('height',editorSubmitHeight);
        });
        */
        
        $('HTMLEditorSubmit').addEvent('mousedown',function(){
          editorSubmited = true;
        });      
      });
    }
  }
  // ->> make PAGE TITLE EDITABLE
  if($('editablePageTitle') != null) {
    
    // vars
    var titleSaved = false;
    var titleContent = '';
    
    $('editablePageTitle').moorte({location:'none'});
    
    // ->> SAVE TITLE
    function saveTitle(title,type) {
      if(titleContent != title.get('html')) {
 
        // var
        var jsLoadingCircle = new Element('div',{'class': 'smallLoadingCircle'});
        var removeLoadingCircle = function(){};
        
        // url encodes the string
        title.getChildren('#rteMozFix').destroy();
        var content = encodeURIComponent(title.get('html')).replace( /\%20/g, '+' ).replace( /!/g, '%21' ).replace( /'/g, '%27' ).replace( /\(/g, '%28' ).replace( /\)/g, '%29' ).replace( /\*/g, '%2A' ).replace( /\~/g, '%7E' );
        //request(title,,,{title: feindura_langFile.ERRORWINDOW_TITLE,text: feindura_langFile.ERROR_SAVE},'post',true);
        
        // save the title
        new Request({
          url: feindura_basePath + 'library/controllers/frontendEditing.controller.php',
          method: 'post',
          data: 'save=true&type='+type+'&category='+title.retrieve('category')+'&page='+title.retrieve('page')+'&data='+content,
          
          onRequest: function() {
            
            // -> ADD the LOADING CIRCLE     
            if(!title.contains(jsLoadingCircle))
        		  title.grab(jsLoadingCircle,'top');
        		removeLoadingCircle = feindura_loadingCircle(jsLoadingCircle, 8, 15, 12, 2, "#000");  
          },
      		onSuccess: function(html) {
      			
      			// -> fade out the loadingCircle
      			jsLoadingCircle.set('tween',{duration: 200});
      			jsLoadingCircle.fade('out');
      			jsLoadingCircle.get('tween').chain(function(){
              // -> REMOVE the LOADING CIRCLE
              removeLoadingCircle();
              jsLoadingCircle.dispose();
              
              if(html.contains('####SAVING-ERROR####'))
                document.body.grab(feindura_displayError(feindura_langFile.ERRORWINDOW_TITLE,feindura_langFile.ERROR_SAVE),'top');
              else {
        			  // -> UPDATE the TITLE everywhere
                title.set('html', html+"<p id='rteMozFix' style='display:none'><br></p>");
                $('edit_title').set('value',html);
                $$('#leftSidebar .verticalButtons a.active').getLast().getChildren('span').set('html',html);
                setSidbarMenuTextLength();
                titleContent = $('editablePageTitle').get('html');
          			// display document saved
          			showDocumentSaved();
        			}
            });
      		},
      		//-----------------------------------------------------------------------------
      		//Our request will most likely succeed, but just in case, we'll add an
      		//onFailure method which will let the user know what happened.
      		onFailure: function() { //-----------------------------------------------------

            // -> fade out the loadingCircle
            if(!title.contains(jsLoadingCircle))
              title.grab(jsLoadingCircle,'top');
        			jsLoadingCircle.set('tween',{duration: 200});
        			jsLoadingCircle.fade('out');
        			jsLoadingCircle.get('tween').chain(function(){
              // -> REMOVE the LOADING CIRCLE
              removeLoadingCircle();
              jsLoadingCircle.dispose();
              // add errorWindow
              document.body.grab(feindura_displayError(feindura_langFile.ERRORWINDOW_TITLE,feindura_langFile.ERROR_SAVE),'top');
            });
            
      		}
        }).send();
        
        titleSaved = true;
      }
    }
    
    // ->> GO TROUGH ALL EDITABLE BLOCK
    
    // STORE page IDS in the elements storage
    feindura_setPageIds($('editablePageTitle'));
    
    // save on enter
    $('editablePageTitle').addEvent('keydown', function(e) {
      if(e.key == 'enter' && $(e.target) != null && ((MooRTE.Elements.linkPop && MooRTE.Elements.linkPop.visible === false) || MooRTE.Elements.linkPop == null )) {
          e.stop();
          saveTitle($(e.target),'title');
      }
    });
    // save on blur
    $('editablePageTitle').addEvent('blur', function(e) {
      if($(e.target) != null && ((MooRTE.Elements.linkPop && MooRTE.Elements.linkPop.visible === false) || MooRTE.Elements.linkPop == null )) {
          saveTitle($(e.target),'title');   
      }
    });    
    // on focus
    $('editablePageTitle').addEvent('focus', function() {
      titleContent = $('editablePageTitle').get('html');
      if(titleSaved)
        titleSaved = false;
    });
  }

  // -----------------------------------------
  // ADD SLIDE TO THE VISIT TIME MAX
  if($('visitTimeMax') != null) {

     // creates the slide effect
	   var slideVisitTimeMax = new Fx.Slide($('visitTimeMaxContainer'),{duration: 300, transition: Fx.Transitions.Pow.easeOut});
     // slides the hotky div in, on start
     slideVisitTimeMax.hide();
     // sets the SLIDE OUT on MOUSE ENTER
     $('visitTimeMax').addEvent('mouseenter', function(e){  	   
    		e.stop();    		
    		slideVisitTimeMax.slideIn();
     });
     // sets the SLIDE IN on MOUSE LEAVE
     $('visitTimeMax').addEvent('mouseleave', function(e){   
    		e.stop();    		
    		//slideVisitTimeMax.slideOut();
     });
     // sets the SLIDE OUT on MOUSE ENTER
     $('visitTimeMaxContainer').addEvent('mouseenter', function(e){  	   
    		e.stop();    		
    		slideVisitTimeMax.slideIn();
     });
     // sets the SLIDE IN on MOUSE LEAVE
     $('visitTimeMaxContainer').addEvent('mouseleave', function(e){   
    		e.stop();    		
    		slideVisitTimeMax.slideOut();
     });
  }
  
  // -----------------------------------------
  // ADD SLIDE TO THE VISIT TIME MIN
  if($('visitTimeMin') != null) {

     // creates the slide effect
	   var slideVisitTimeMin = new Fx.Slide($('visitTimeMinContainer'),{duration: '300', transition: Fx.Transitions.Pow.easeOut});
     // slides the hotky div in, on start
     slideVisitTimeMin.hide();
     // sets the SLIDE OUT on MOUSE ENTER
     $('visitTimeMin').addEvent('mouseenter', function(e){  	   
    		e.stop();    		
    		slideVisitTimeMin.slideIn();
     });
     // sets the SLIDE IN on MOUSE LEAVE
     $('visitTimeMin').addEvent('mouseleave', function(e){   
    		e.stop();
    		//slideVisitTimeMin.slideOut();
     });
     // sets the SLIDE OUT on MOUSE ENTER
     $('visitTimeMinContainer').addEvent('mouseenter', function(e){  	   
    		e.stop();    		
    		slideVisitTimeMin.slideIn();
     });
     // sets the SLIDE IN on MOUSE LEAVE
     $('visitTimeMinContainer').addEvent('mouseleave', function(e){   
    		e.stop();
    		slideVisitTimeMin.slideOut();
     });
  }
    
  // -----------------------------------------
  // ADD SLIDE TO THE HOTKEYs (Tastenkürzel)
  if($('hotKeys') != null) {

     // creates the slide effect
	   var slideHotkeys = new Fx.Slide($('hotKeys'),{duration: '750', transition: Fx.Transitions.Pow.easeOut});  
    
     // slides the hotky div in, on start
     slideHotkeys.hide();
    
     // sets the SLIDE EFFECT to the buttons
     if($('hotKeysToogle') != null) {
       $('hotKeysToogle').addEvent('click', function(e){  	   
      		e.stop();    		
      		slideHotkeys.toggle();
      	});
     }
  }
  
  // -----------------------------------------
  // ->> CHECKS if changes in the editor page was made and add a *
  
  // CHECK if fields are changed
  $$('#editorForm input, #editorForm textarea').each(function(formfields){
    formfields.addEvent('change',function() {
      pageContentChangedSign();
      pageContentChanged = true;
    });
  });
  // CHECK if the HTMLeditor content was changed
  if($('HTMLEditor') != null) {
    HTMLEditor.on('blur',function() {
      if(HTMLEditor.checkDirty()) {        
        pageContentChangedSign();
        pageContentChanged = true;
      }
    });
  }
  
  // throw a warning when user want to leave the page and the page content was changed
  $$('a').each(function(link) {
    var href = link.get('href');
    var onclick = link.get('onclick');
    
    // only on external links, or the sideBarMenu category selection
    if((onclick == null || (onclick != null && onclick.toString().substr(0,18) == 'requestLeftSidebar')) &&
        href != null &&
        href.toString().indexOf('#') == -1) {

      link.addEvent('click',function(e) {
        if(pageContentChanged) {
          e.stop();
          openWindowBox('library/views/windowBox/unsavedPage.php?target=' + escape(href),false,false);
        }
      });
    }    
  });
  
  layoutFix();
});