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
// javascript/editFiles.js version 0.1 (requires CodeMirror)


window.addEvent('domready', function() {
    
  // adds CodeMirror to all textareas with class editFiles
  $$('textarea.editFiles').each(function(textarea){
    var textareaId = textarea.getProperty('id');
    
    if(textareaId != null) {
      // multihighlighting
      if(textareaId.substring(0,9) == 'editFiles') {        
    
        CodeMirror.fromTextArea(textareaId, {
          width: "743px",
          height: "500px",
          iframeClass: 'editFilesIFrame',
          textWrapping: false,
          parserfile: ["parsexml.js", "parsecss.js", "tokenizejavascript.js", "parsejavascript.js",
                      "../contrib/php/js/tokenizephp.js", "../contrib/php/js/parsephp.js", "../contrib/php/js/parsephphtmlmixed.js"],
          stylesheet: ["library/thirdparty/javascript/CodeMirror/css/xmlcolors.css", "library/thirdparty/javascript/CodeMirror/css/jscolors.css", "library/thirdparty/javascript/CodeMirror/css/csscolors.css", "library/thirdparty/javascript/CodeMirror/contrib/php/css/phpcolors.css", "library/thirdparty/javascript/CodeMirror/css/general.css"],
          path: "library/thirdparty/javascript/CodeMirror/js/"
        });
      
      // css highlighting
      } else if(textareaId.substring(0,3) == 'css') {
      
        CodeMirror.fromTextArea(textareaId, {
          width: "743px",
          height: "500px",
          iframeClass: 'editFilesIFrame',
          textWrapping: false,
          parserfile: "parsecss.js",
          stylesheet: ["library/thirdparty/javascript/CodeMirror/css/csscolors.css", "library/thirdparty/javascript/CodeMirror/css/general.css"],
          path: "library/thirdparty/javascript/CodeMirror/js/"
        });        
      }
    }
  });
});
