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
// javascripts/frontendEditing.js version 0.11 (requires mootools-core and CKEditor)

/*
// ->> FUNCTIONS

// ->> the function to SAVE the edited page data
function saveEditedPage(editorInstance) {
  editorInstance.updateElement();
  alert(editorInstance.getData());
  editorInstance.destroy();
}


// ->> the function will be execute when a user CLICK on the EDIT BUTTON
function feinduraEditPage(pageId,styleFiles,styleId,styleClass) {
  
  var pageContentName = 'feinduraPage' + pageId;
  var pageContentBlock = $(styleId);

  if(pageContentBlock != null) {
  
    // -> CHECK if instance alrady exists, close and save the page
    for(var i in CKEDITOR.instances) {    
       if(CKEDITOR.instances[i].name == pageContentName) {
        saveEditedPage(CKEDITOR.instances[i])
        return;
       }
    }

    // -> CREATES an editor instance by replacing the container DIV fo the page content
  	var editorInstance = CKEDITOR.replace(pageContentName, {
        width       : pageContentBlock.getSize().x + 24, // 2x 12px
        height      : pageContentBlock.getSize().y + 160, // 125px + 35px
        contentsCss : styleFiles,
        bodyId      : styleId,
        bodyClass   : styleClass
    });
    
    
    editorInstance.on('instanceReady',function(){
      var editorBlock = $('cke_' + pageContentName);
    
      editorBlock.setStyle('margin','-125px -12px -35px -12px');
    });
    
    // -> SAVE automatically IF user LET the editor
    editorInstance.on('blur',function() {
      saveEditedPage(editorInstance);
    });
  }
};

// ->> SET UP CKEDITOR
// *******************
CKEDITOR.config.dialog_backgroundCoverColor   = '#fff';
CKEDITOR.config.uiColor                       = '#cccccc';
CKEDITOR.config.forcePasteAsPlainText         = false;
CKEDITOR.config.scayt_autoStartup             = false;
CKEDITOR.config.colorButton_enableMore        = true;
//CKEDITOR.config.disableNativeSpellChecker = false;

CKEDITOR.config.toolbar = [
                          ['Save','-','Maximize','-','Source'],
                          ['Undo','Redo','-','RemoveFormat','SelectAll'],
                          ['Cut','Copy','Paste','PasteText','PasteFromWord'],
                          ['Find','Replace','-','Print','SpellChecker', 'Scayt'],
                           '/',
                          ['Bold','Italic','Underline','Strike','-','Subscript','Superscript'],	                                               
                          ['NumberedList','BulletedList','-','Outdent','Indent','Blockquote'],
                          ['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
                          ['Link','Unlink','Anchor'],
                          ['Image','Flash','Table','HorizontalRule','SpecialChar'],
                           '/',
                          ['Styles','Format','FontSize'], // 'Font','FontName',
                          ['TextColor','BGColor','-'],
                          ['ShowBlocks','-','About']
                          ];		// No comma for the last row.


// *---------------------------------------------------------------------------------------------------*
//  DOMREADY
// *---------------------------------------------------------------------------------------------------*
window.addEvent('domready',function(){
  CKEDITOR.plugins.registered['save'] = {
     init : function( editorInstance )
     {
        var command = editorInstance.addCommand( 'save',
           {
              modes : { wysiwyg:1, source:0 },
              exec : function( editorInstance ) {
                 //var fo=editor.element.$.form;
                 saveEditedPage(editorInstance);
              }
           }
        );
        editorInstance.ui.addButton( 'Save',{label : 'Save',command : 'save'});
     }
  }
});
*/

// var
var feindura_pageSaved = false;

// ->> FUNCTIONS
// *************

/* str_replace function */
function feindura_is_array(value) {
   if (typeof value === 'object' && value && value instanceof Array) {
      return true;
   }
   return false;
}
function feindura_str_replace(s, r, c) {
   if (feindura_is_array(s)) {
      for(i=0; i < s.length; i++) {
         c = c.split(s[i]).join(r[i]);
      }
   }
   else {
      c = c.split(s).join(r);
   }
   return c;
}

// ->> ADD TOOLTIPS
function feindura_addToolTips() {
  // store titles and text
	$$('.feindura_toolTip').each(function(element,index) {

	  if(element.get('title')) {
      var content = element.get('title').split('::');
     		
     	// converts "[" , "]" in "<" , ">"  but BEFORE it changes "<" and ">" in "&lt;","&gt;"
  		if(content[1])
    		content[1] = feindura_str_replace(new Array("<",">","[", "]"), new Array("&lt;","&gt;","<", ">"), content[1]);

  		if(content[0])
    		content[0] = feindura_str_replace(new Array("<",">","[", "]"), new Array("&lt;","&gt;","<", ">"), content[0]);

  		element.store('tip:title', content[0]);
  		element.store('tip:text', content[1]);    		
  	}
	});
	
	// add the tooltips to the elements
  var feindura_toolTips = new Tips('.feindura_toolTip',{
    className: 'feindura_toolTipBox',
    offset: {'x': 10,'y': 15},
    fixed: false,
    showDelay: 200,
    hideDelay: 0 });
}

// ->> GET PAGE ID
function feindura_getPageIds(pageBlock) {
  if(pageBlock.hasClass('feindura_editPage') || pageBlock.hasClass('feindura_editTitle'))
    return { page: pageBlock.get('class').split(' ')[1].substr(15), category: pageBlock.get('class').split(' ')[2].substr(19)};
  else
    return { page: null, category: null};
}

/* ---------------------------------------------------------------------------------- */
// SIDEBAR AJAX REQUEST
// send a HTML request to load the new Sidebar content
function feindura_request(aniContainer,url,data,method) {
  
  // vars
  if(!method) method = 'get';
  var jsLoadingCircleContainer = new Element('div',{class:'feindura_loadingCircleContainer'});
  var jsLoadingCircle = new Element('div',{class: 'feindura_loadingCircleHolder',style:'margin-left: -40px;margin-top: -20px;'});
  jsLoadingCircleContainer.grab(jsLoadingCircle);
  var finishPicture = new Element('div',{class:'feindura_requestFinish'});
  var failedPicture = new Element('div',{class:'feindura_requestFailed'});
  
  var removeLoadingCircle;
  
  //console.debug(aniContainer);
  
  // creates the request Object
  var request = new Request({
    url: url,
    method: method,
    //data: data, //'site=' + site + '&category=' + category + '&page=' + page,
    
    //-----------------------------------------------------------------------------
    onRequest: function() { //-----------------------------------------------------		

        // -> ADD the LOADING CIRCLE
    		aniContainer.grab(jsLoadingCircleContainer,'top');
    		removeLoadingCircle = loadingCircle(jsLoadingCircle, 24, 40, 12, 4, "#000");
    		
    		// -> TWEEN jsLoadingCircleContainer    
        jsLoadingCircleContainer.set('tween',{duration: 100});
        jsLoadingCircleContainer.setStyle('opacity',0);
        jsLoadingCircleContainer.tween('opacity',0.5);

    },
    //-----------------------------------------------------------------------------
		onSuccess: function(html) { //-------------------------------------------------
			
			// -> TWEEN leftSidebar
			jsLoadingCircleContainer.set('tween',{duration: 200});
			jsLoadingCircleContainer.fade('out');
			jsLoadingCircleContainer.get('tween').chain(function(){
			   // -> REMOVE the LOADING CIRCLE
			   removeLoadingCircle();
         jsLoadingCircleContainer.setStyle('background','transparent');
         jsLoadingCircleContainer.setStyle('border','none');
         jsLoadingCircleContainer.setStyle('opacity',1);
         // request finish picture
			   jsLoadingCircleContainer.grab(finishPicture,'top');
      });
			
      finishPicture.set('tween',{duration: 400});
      finishPicture.fade('in');
      finishPicture.get('tween').chain(function(){
        finishPicture.tween('opacity',0);
      }).chain(function(){
        finishPicture.destroy();
        jsLoadingCircleContainer.destroy();
      });

		},
		//-----------------------------------------------------------------------------
		//Our request will most likely succeed, but just in case, we'll add an
		//onFailure method which will let the user know what happened.
		onFailure: function() { //-----------------------------------------------------
		  
		  // DONT work??
      
      // -> TWEEN leftSidebar
			jsLoadingCircleContainer.set('tween',{duration: 200});
			jsLoadingCircleContainer.fade('out');
			jsLoadingCircleContainer.get('tween').chain(function(){
			   // -> REMOVE the LOADING CIRCLE
			   removeLoadingCircle();
         jsLoadingCircleContainer.setStyle('background','transparent');
         jsLoadingCircleContainer.setStyle('border','none');
         jsLoadingCircleContainer.setStyle('opacity',1);
         // request finish picture
			   jsLoadingCircleContainer.grab(failedPicture,'top');
      });
			
      failedPicture.set('tween',{duration: 400});
      failedPicture.fade('in');
      failedPicture.get('tween').chain(function(){
        failedPicture.tween('opacity',0);
      }).chain(function(){
        failedPicture.destroy();
        jsLoadingCircleContainer.destroy();
      });
		}
  }).send(data);
}

// ->> DOMREADY
// ************
window.addEvent('domready',function() {
  
  // ->> add TOP BAR
  // ***************
  var feindura_topBar = Mooml.render('feindura_topBarTemplate');
  feindura_topBar.inject($(document.body),'top');
  $(document.body).setStyle('padding-top','60px');
  
  // ->> add BAR to EACH PAGE BLOCK  
  // ******************************  
  $$('.feindura_editPage').each(function(pageBlock) {
    
    //var      
    var pageBarVisible = false;
    var pageBlockFocused = false;
    var parent = pageBlock.getParent();
    var ids = feindura_getPageIds(pageBlock);
    
    // ->> create PAGE BAR
    var pageBar = new Element('div',{class: 'feindura_pageBar'});
    var pageBarContent = Mooml.render('feindura_pageBarTemplate', { pageId: ids.page, categoryId: ids.category, pageBlockClasses: pageBlock.get('class') });
    pageBarContent.each(function(link){
      link.inject(pageBar,'bottom');
    });
    // -> inject the page bar
    pageBar.inject(pageBlock,'before');
    pageBar.set('tween',{duration: 300});
    pageBar.fade('hide');      
    
    // -> set the parent to position: relative      
    if(parent.getStyle('position') != 'relative' && parent.getStyle('position') != 'absolute') { parent.setStyle('position','relative'); }      
    
    // ->> add page bar on focus
    pageBlock.addEvent('mouseenter', function() {
      // -> show the page bar
      // -> set the position of the page bar
      pageBar.setPosition({
        x: pageBlock.getPosition(parent).x + (pageBlock.getSize().x - pageBar.getSize().x),
        y: pageBlock.getPosition(parent).y - pageBar.getSize().y - 15}
      );    
      pageBar.fade('in');
    });
    // ->> set pageBlockFocused on focus
    pageBlock.addEvent('focus', function(e) { pageBlockFocused = true; });
    
    // ->> remove all page bars on mouseout
    pageBlock.addEvent('mouseleave', function(e) {      
      // -> check if target is not feindura_editPage block
      if(!pageBlockFocused) {          
        pageBar.fade('out');
      }
    });
    // ->> set pageBlockFocused on focus
    pageBlock.addEvent('blur', function(e) {
      pageBar.fade('out');
      pageBlockFocused = false;
    });
    
    // ->> set page bar mouse events
    pageBar.addEvent('mouseenter', function(e) { pageBar.fade('in'); });
    pageBar.addEvent('mouseleave', function(e) { if(!pageBlockFocused) pageBar.fade('out'); });    
  });
  
  feindura_addToolTips()
  
  // ->> ADD EDITOR
  // **************
  
  // -> add save button
  MooRTE.Elements.extend({
    save : { img:27, onClick: function() {
        $$('.feindura_editPage, .feindura_editTitle').each(function(page) {                                     
            if(MooRTE.activeField == page) {
              feindura_pageSaved =  false;
              feindura_savePage(page);
            }
        });
      }}
  });
    
  // ->> add save on blur
  $$('.feindura_editPage, .feindura_editTitle').each(function(page) {    
    // on blur
    page.addEvent('blur', function(e) {
      var page = e.target;
      //alert(MooRTE.Elements.linkPop.visible);
      if(page != null && MooRTE.Elements.linkPop.visible === false) {
        feindura_savePage(page);
      }
    });    
    // on focus
    page.addEvent('focus', function() {
      if(feindura_pageSaved)
        feindura_pageSaved = false;
    });
    
  });
  
  // -> set up toolbar  
  var feindura_MooRTEButtons = {Toolbar:['save.saveBtn','undo','redo','removeformat', // 'Html/Text'
                                        'bold','italic','underline','strikethrough',
                                        'justifyleft','justifycenter','justifyright','justifyfull',
                                        'outdent','indent','superscript','subscript',
                                        'insertorderedlist','insertunorderedlist','blockquote','inserthorizontalrule',
                                        'decreasefontsize','increasefontsize','hyperlink'
                                        ]};
                                        
  // -> create editor instance to edit all divs which have the class "feindura_editPage"
  new MooRTE({elements:'div.feindura_editPage, span.feindura_editTitle',skin:'rteFeinduraSkin', buttons: feindura_MooRTEButtons,location:'pageTop'});
});