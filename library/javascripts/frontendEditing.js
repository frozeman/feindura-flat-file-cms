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
// javascripts/frontendEditing.js version 0.1 (requires mootools-core and CKEditor)
var editPageEditor
function feinduraEditPage(pageId,styleFiles,styleId,styleClass) {
  
  var pageContent = $('feinduraPage' + pageId);
  
  if(pageContent != null) {

    // CREATES an editor instance by replacing the container DIV fo the page content
  	editPageEditor = CKEDITOR.replace('feinduraPage' + pageId,{
        contentsCss : styleFiles,
        bodyId      : styleId,
        bodyClass   : styleClass
    });
  }
};

window.addEvent('click',function(e){
  if(editPageEditor != null && e.target.getParent() == editPageEditor)
    alert(e.target);
  //editPageEditor.destroy();
});