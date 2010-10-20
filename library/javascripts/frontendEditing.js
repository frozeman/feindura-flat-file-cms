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


// ->> the function to SAVE the edited page data
function saveEditedPage(editorInstance) {
  editorInstance.updateElement();
  alert(editorInstance.getData());
  editorInstance.destroy();
}


// ->> the function will be execute when a user CLICK on the EDIT BUTTON
function feinduraEditPage(pageId,styleFiles,styleId,styleClass) {
  
  var pageContentName = 'feinduraPage' + pageId;
  var pageContentBlock = $(pageContentName);
  
  if(pageContentBlock != null) {
    
    if(CKEDITOR.instances.pageContentName != null) {
      saveEditedPage(CKEDITOR.instances.pageContentName)
      return;
    }

    // CREATES an editor instance by replacing the container DIV fo the page content
  	var editorInstance = CKEDITOR.replace(pageContentName, {
        contentsCss : styleFiles,
        bodyId      : styleId,
        bodyClass   : styleClass
    });
    
    editorInstance.on('blur',function() {
      saveEditedPage(editorInstance);
    });
  }
};

// *---------------------------------------------------------------------------------------------------*
//  DOMREADY
// *---------------------------------------------------------------------------------------------------*
window.addEvent('domready',function(){
  CKEDITOR.plugins.registered['save'] = {
     init : function( editorInstance )
     {
        var command = editorInstance.addCommand( 'save',
           {
              //modes : { wysiwyg:1, source:1 },
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
