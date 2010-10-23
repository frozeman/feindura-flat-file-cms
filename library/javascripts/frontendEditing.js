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


// ->> SAVE PAGE
function feindura_savePage(page) {
  if(feindura_pageSaved === false) {
  
    //alert(page.get('html'));
    page.set('html',page.get('html')+'saved')
    
		//new Request({url:MooRTE.Elements.save.src}).send(content.toQueryString());
		
		
	  feindura_pageSaved = true;
  }
}

// ->> DOMREADY
// ************
window.addEvent('domready',function() {

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