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
// java/editor.js version 0.1 (requires ckeditor)


window.addEvent('domready', function() {

  
  if($('HTMLEditor') != null) {
  
    var HTMLEditor = CKEDITOR;
  
  
  
    HTMLEditor.addStylesSet( 'my_styles',
      [
          // Block Styles
          { name : 'Blue Title', element : 'h1', styles : { 'color' : '#cccccc' } },
          { name : 'Red Title' , element : 'h3', styles : { 'color' : 'Red' } },
      
          // Inline Styles
          { name : 'CSS Style', element : 'span', attributes : { 'class' : 'my_style' } },
          { name : 'Marker: Yellow', element : 'span', styles : { 'background-color' : 'Yellow' } }
      ]);
      
      
      
    // ------------------------------
    // CONFIG the HTMlEditor
    HTMLEditor.config.uiColor                   = '#cccccc';
    HTMLEditor.config.width                     = '780';
    HTMLEditor.config.resize_minWidth           = '780';
    HTMLEditor.config.height                    = '450';
    
    //HTMLEditor.config.scayt_autoStartup         = true;
    //HTMLEditor.config.disableNativeSpellChecker = false;
    
    HTMLEditor.config.toolbar                   = [['Save','Preview','-','Source'],
                                              ['Cut','Copy','Paste','PasteText','PasteFromWord','-','Print','SpellChecker', 'Scayt'],
                                              ['Undo','Redo','-','Find','Replace','-','SelectAll','RemoveFormat'],
                                               '/',
                                              ['Bold','Italic','Underline','Strike','-','Subscript','Superscript'],	                                               
                                              ['NumberedList','BulletedList','-','Outdent','Indent','Blockquote'],
                                              ['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
                                            	['Link','Unlink','Anchor'],
                                            	['Image','Flash','Table','HorizontalRule','SpecialChar'],
                                               '/',
                                            	['Styles','Format','FontName','Font','FontSize'],
                                            	['TextColor','BGColor','-'],
                                            	['Maximize','ShowBlocks','-','About']];		// No comma for the last row.
      
      
    
    // ----------------------------------------------------------------------
    // creates the editor instance, with replacing the textarea with the name="HTMLEditor"
  	HTMLEditor.replace( 'HTMLEditor',
      {
          //stylesCombo_stylesSet : 'my_styles',

      });  
      
     
      
    //HTMLeditor.config.stylesCombo_stylesSet = 'my_styles';    
    CKFinder.SetupCKEditor( HTMLEditor, 'library/thirdparty/ckfinder/' ) ;
  }
  
  
  
  // -----------------------------------------
  // ADD SLIDE TO THE HOTKEYs
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
  
  
    
});
