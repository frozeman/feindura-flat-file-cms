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
// java/content.js version 0.57 (requires mootools-core and mootools-more)
//

// vars
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
  var toolTips = new Tips('.toolTip',{
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
  
  // thumbwidth
  if($(thumbWidth) != null) {
      $(thumbWidth).addEvent('keyup', function(){
          $(thumbWidthScale).tween('width',$(thumbWidth).get('value'));
      });
  }
  // thumbheight
  if($(thumbHeight) != null) {
      $(thumbHeight).addEvent('keyup', function(){
          $(thumbHeightScale).tween('width',$(thumbHeight).get('value'));
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
function changeEditFile( site, fileName, status, anchorName )
{
  window.location.href = window.location.pathname + "?site=" + site + "&status=" + status + "&file=" + fileName + "#" + anchorName ;
}

// -------------------------------------------------
// -> on SUBMIT goto ANCHOR
function submitAnchor(formId,anchorName) {
  
  // IE
  if(navigator.appVersion.match(/MSIE/)) {
    // get form
    var form = document.getElementById(formId);
    // create new action attribute
    var attr = document.createAttribute('action');
    attr.nodeValue = form.getAttributeNode('action').nodeValue + '#' + anchorName;
    // set new action attribute
    form.setAttributeNode(attr);
  // ALL the OTHERS
  } else {
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
function blockSlider(givenId) {
  
  var blocksInDiv = '';
  
  // prepares the given container div id or class
  if(givenId)
    blocksInDiv = givenId + ' ';
  
  $$(blocksInDiv + '.block').each(function(block,i) {	   
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
      if(navigator.appVersion.match(/MSIE ([0-7]\.\d)/))
        bottomBorder.setStyle('display', 'none');
       
  	  // -> CREATE the SLIDE EFFECT
  	  slideVertical = new Fx.Slide(slideContent,{ duration: '500', transition: Fx.Transitions.Back.easeOut }); //Fx.Transitions.Pow.easeOut
      
      slideVertical.onComplete = function(el) {
        // mootools creates an container around slideContent, so that it doesn't resize anymore automaticly, so i have to reset height auto for this container
  	    if(slideVertical.open) {
              slideContent.setStyle('display','none'); // to allow sorting above the slided in box
              slideVertical.wrapper.setStyle('height',slideContent.getSize().y);
              slideVertical.open = false;       
        } else {
              slideVertical.wrapper.setStyle('height','auto');
              slideVertical.open = true;
              new Fx.Scroll(window,{duration: '300',}).start(window.getPosition().x,block.getPosition().y - 80);
        }
        layoutFix();
      }
      
      // -> set click Event for the SLIDE EFFECT to the buttons
      slideButtonH1.addEvent('click', function(e) {
      	  e.stop();

      	  if(!slideVertical.open) {
      	    slideContent.setStyle('display','block'); // to allow sorting above the slided in box
      	    block.removeClass('hidden'); // to change the arrow
          } else { 
            block.addClass('hidden'); // to change the arrow
          }
          
          slideVertical.toggle();          
      });
      
      // -> hide the block at start, if it has class "hidden"
      if(block.hasClass('hidden'))  {
        slideVertical.hide();
        slideVertical.open = false;
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
         // creates the slide effect
    	   var inBlockSliderInstance = new Fx.Slide(insideBlockTable,{duration: '750', transition: Fx.Transitions.Pow.easeOut});  
         
         // ON COMPLETE
         inBlockSliderInstance.onComplete = function(el) {
    
              // mootools creates an container around slideContent, so that it doesn't resize anymore automaticly, so i have to reset height auto for this container
              if(inBlockSliderInstance.open) {
                insideBlockTable.getParent().fade('hide');
                inBlockSliderInstance.open = false;
              } else {              
                insideBlockTable.getParent().fade('show');
                inBlockSliderInstance.open= true;
              }
          }
        
         // slides the hotky div in, on start
         if(insideBlockTable.hasClass('hidden')) {
           // hides the wrapper on start
           inBlockSliderInstance.hide();
           insideBlockTable.getParent().fade('hide');
         }
         
         // sets the SLIDE effect to the SLIDE links
         slideLinks[count].addEvent('click', function(e) {
            if(e.target.match('a'))
        		  e.stop();
        		inBlockSliderInstance.toggle();
        		insideBlockTable.getParent().fade('show');
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

/* scrollToAnchor function */
var scrollToAnchor = function(){ new Fx.Scroll(window,{duration:100}).start(0,this.getPosition().y - 50); };

// *---------------------------------------------------------------------------------------------------*
//  LOAD (if all pics are loaded)
// *---------------------------------------------------------------------------------------------------*
window.addEvent('load', function() {

    autoResizeThumbnailPreview();    
 
    // SCROLL to ANCHORS  (should fix chrome and safari scroll problem)
    var anchorId = window.location.hash.substring(1);
    anchorId = $(anchorId);
    //alert(anchorId + ' -> '+ $(anchorId).getPosition(window).y);
    if(anchorId != null) {
      scrollToAnchor.delay(1,anchorId);
    }

    
});

// *---------------------------------------------------------------------------------------------------*
//  DOMREADY
// *---------------------------------------------------------------------------------------------------*
window.addEvent('domready', function() {
  
  // *** ->> ADMIN-MENU -----------------------------------------------------------------------------------------------------------------------
    
  if($('adminMenu') != null) {
    // set the style back, which is set for non javascript users
    $('adminMenu').setStyle('width','172px');
    $('adminMenu').setStyle('overflow','hidden');
    
    // set tween
    $('adminMenu').set('tween',{duration: '500', transition: Fx.Transitions.Pow.easeOut});
    
    // add resize tween event
    $('adminMenu').addEvents({
      'mouseover' : function() { // resize on mouseover        
          $('adminMenu').tween('height',($$('#adminMenu .content table')[0].offsetHeight + 36) + 'px');
      },
      'mouseout' : function() { // resize on onmouseout
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
  // HIDE FUNCTIONS of the PAGES ---------------------------------------------------------------
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
          
          if(navigator.appVersion.match(/MSIE/))
            functionsDiv.tween('width','140px');
          else
            functionsDiv.tween('opacity','1');
        });
        li.addEvent('mouseout',function(e) {
          e.stop();
          if(navigator.appVersion.match(/MSIE/))
            functionsDiv.tween('width','0px');
          else
            functionsDiv.tween('opacity','0.2');
        });      
      
        // HIDE the functions AT STARTUP
        if(navigator.appVersion.match(/MSIE/))
            functionsDiv.setStyle('width','0px');
          else
            functionsDiv.setStyle('opacity','0.2');            
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
			//$$('.listPagesSortable li').setStyle('cursor','move'); // ändert den Cursor
			el.setStyle('background-position', '0px -81px');
      			
			categoryOld = el.getParent().get('id').substr(8); // gets the category id where the element comes from

		},
    // überprüft ob sortiert wurde oder nicht		
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
			
			// --> sortiert die Seite mithilfe einer AJAX anfrage an library/processes/sortPages.process.php	------------------------------
				var req = new Request({
					url:'library/processes/sortPages.process.php',
					method:'post',
					//autoCancel:true,
					data:'sort_order=' + sort_order + '&categoryOld=' + categoryOld +'&categoryNew=' + categoryNew + '&sortedPageId=' + sortedPageId , // + '&do_submit=1&byajax=1&ajax=' + $('auto_submit').checked
					//-------------------------------------
          onRequest: function() {
            
					
            // put the save new order - text in the loadingBox AND show the loadingBox
            $$('#loadingBox .content')[0].set('html','<span style="color:#D36100;font-weight:bold;font-size:18px;">'+sortablePageList_status[0]+'</span>');
            $('loadingBox').setStyle('display','block');
            $('loadingBox').fade('hide');
            $('loadingBox').fade('in');
            
		},
		//-------------------------------------
		onSuccess: function(responseText) {

		  // FINAL SORT MESSAGE
		  //puts the right message which is get from the sortablePageList_status array (hidden input) in the messageBox
		  //$('messageBox_input').set('html',sortablePageList_status[responseText.substr(6,1)]);
		  $('messageBox_input').set('html','<img src="library/images/sign/hintIcon.png" class="hintIcon" /><span style="color:#407287;font-weight:bold;">' + responseText + '</span>');
			
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
      			  var newLi = new Element('li', {html: '<div>' + sortablePageList_status[1] + '</div>'});
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
      
      /*
      li.hasChild($$('.functions')).addEvent('mouseover',function(e) {
        alert('dd');
        functions.fade('in');
      });
      */
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
        $('cfg_varNameModul').setProperty(deactivateType,deactivateType);
        $('cfg_varNameModul').tween('width',smallSize);
      // activates thema if link with vars
      } else {
        $('cfg_varNamePage').removeProperty(deactivateType);
        $('cfg_varNamePage').tween('width','300px');
        $('cfg_varNameCategory').removeProperty(deactivateType);
        $('cfg_varNameCategory').tween('width','300px');
        $('cfg_varNameModul').removeProperty(deactivateType);
        $('cfg_varNameModul').tween('width','300px');
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
  
  // -----------------------------------------
  // ADD CodeMirror TO ALL TEXTAREAs with class editFiles
  $$('textarea.editFiles').each(function(textarea){
    var textareaId = textarea.getProperty('id');
    
    if(textareaId != null) {
      // multihighlighting
      if(textarea.hasClass('mixed')) { //textareaId.substring(0,9) == 'editFiles'

        CodeMirror.fromTextArea(textareaId, {
          width: "743px",
          height: "500px",
          iframeClass: 'editFilesIFrame',
          textWrapping: false,
          parserfile: ["parsexml.js", "parsecss.js", "tokenizejavascript.js", "parsejavascript.js",
                      "../contrib/php/js/tokenizephp.js", "../contrib/php/js/parsephp.js", "../contrib/php/js/parsephphtmlmixed.js"],
          stylesheet: ["library/thirdparty/javascripts/CodeMirror/css/xmlcolors.css", "library/thirdparty/javascripts/CodeMirror/css/jscolors.css", "library/thirdparty/javascripts/CodeMirror/css/csscolors.css", "library/thirdparty/javascripts/CodeMirror/contrib/php/css/phpcolors.css", "library/thirdparty/javascripts/CodeMirror/css/general.css"],
          path: "library/thirdparty/javascripts/CodeMirror/js/"
        });
      
      // css highlighting
      } else if(textarea.hasClass('css')) {
      
        CodeMirror.fromTextArea(textareaId, {
          width: "743px",
          height: "500px",
          iframeClass: 'editFilesIFrame',
          textWrapping: false,
          parserfile: "parsecss.js",
          stylesheet: ["library/thirdparty/javascripts/CodeMirror/css/csscolors.css", "library/thirdparty/javascripts/CodeMirror/css/general.css"],
          path: "library/thirdparty/javascripts/CodeMirror/js/"
        });        
      }
    }
  });
  
  // *** ->> FORMS -----------------------------------------------------------------------------------------------------------------------
    
  // ------------------------------------------------------------
  // makes inputs who are empty small, and resize it on mouseover
  if($$('.right input') != null) {
        var smallSize = '50';
        
        $$('.right input').each(function(input) {
            
            // looks for empty inputs
            if(!input.hasClass('noResize') && (input.get('value') == '' || input.get('disabled') != false)) {
                
                var hasFocus = false;
                var hasContent = false;
                
                var inputWidthBefore = input.getStyle('width');
                input.setStyle('width', smallSize + 'px'); //makes the input small
                
                input.set('tween',{duration: '500', transition: Fx.Transitions.Sine.easeOut}) //Bounce.easeOut
                
                input.addEvents({
                  'mouseover' : function() { // resize on mouseover
                      input.tween('width',inputWidthBefore);
                  },
                  'focus' : function(){ // if onfocus set hasFocus = true
                      hasFocus = true;
                      input.tween('width',inputWidthBefore);
                  },
                  'blur' : function() { // if onblur set hasFocus = false and tween to small if the input has still no content
                      hasFocus = false;
                      if(input.get('value') == '')
                        input.tween('width',smallSize + 'px');
                  },
                  'mouseout' : function() { // onmouseout, if has not focus tween to small
                      if(!hasFocus && input.get('value') == '')
                        input.tween('width',smallSize + 'px');
                  }
                });
            }
        });
  }
  
  
  // ------------------------------------------------------------
  // REPLACE the CHECKBOXES  
  
  /*
  if(!navigator.appVersion.match(/MSIE ([0-6]\.\d)/)) {
    // path to a 1x1 pixel transparent gif
    cfe.spacer = "library/thirdparty/customformelements/gfx/spacer.gif";
    
    // create a cfe replacement instance
    myCfe =  new cfe.replace();

    
    // ->> create CHECKBOX DEPENDENCIES
    $$('input[type=checkbox]').each(function(checkbox) {
      var checkboxId = checkbox.get('id');
      var categoryNumber;
      var sortbypagedateCheckbox = new Array();
      
      // go trough checkboxes with id
      if(checkboxId) {
        // -> ** categories[0-9]sortbypagedate
        if(checkboxId.match(/^categories[0-9]sortbypagedate$/)) {
          categoryNumber = checkboxId.match(/[0-9]+/);
          myCfe.addDependency(checkbox,'categories'+categoryNumber+'showPageDate');
          
        }
        
        /*
        // -> ** categories[0-9]showPageDate
        if(checkboxId.match(/^categories[0-9]showPageDate$/)) {
          checkbox.addEvent('click',function(){
            categoryNumber = checkboxId.match(/[0-9]+/);

            if($('categories'+categoryNumber+'sortbypagedate').getProperty('checked')) {
              $('categories'+categoryNumber+'sortbypagedate').removeProperty('checked');
              //alert(myCfe($('categories'+categoryNumber+'sortbypagedate')));
            }            
          
          })
        }
        */
        /*
      }
    });
    
    // initialize the replacment
    myCfe.init({scope: $('content')});
  }
  */  
  
  // *** ->> EDITOR -----------------------------------------------------------------------------------------------------------------------
     
  if($('HTMLEditor') != null) {   
    
    // ------------------------------
    // CONFIG the HTMlEditor
    CKEDITOR.config.dialog_backgroundCoverColor   = '#333333';
    CKEDITOR.config.uiColor                       = '#cccccc';
    CKEDITOR.config.width                         = '792';
    CKEDITOR.config.height                        = '450';
    CKEDITOR.config.resize_minWidth               = '780';
    CKEDITOR.config.resize_maxWidth               = '1400';
    CKEDITOR.config.resize_minHeight              = '400';
    CKEDITOR.config.resize_maxHeight              = '900';
    CKEDITOR.config.forcePasteAsPlainText         = false;
    CKEDITOR.config.scayt_autoStartup             = false;
    CKEDITOR.config.colorButton_enableMore        = true;
    
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
                              ['Image','Flash'],
                              ['SpecialChar'],
                               '/',
                              ['Styles','Format','FontSize'], // 'Font','FontName',
                              ['TextColor','BGColor','-'],
                              ['ShowBlocks','-','About']
                              ];		// No comma for the last row.
  
    // ----------------------------------------------------------------------
    // CREATES the editor instance, with replacing the textarea with the id="HTMLEditor"
  	var HTMLEditor = CKEDITOR.replace('HTMLEditor');
     
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
  // ->> CHECKS if changes in the editor page was made
  
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
          openWindowBox('library/sites/windowBox/unsavedPage.php?target=' + escape(href),false,false);
        }
      });
    }    
  });
});