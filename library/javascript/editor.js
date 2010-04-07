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
// java/editor.js version 0.11 (requires ckeditor)


window.addEvent('domready', function() {

  
  if($('HTMLEditor') != null) {
    
    // var
    var HTMLEditor = CKEDITOR;      
      
    // ------------------------------
    // CONFIG the HTMlEditor
    HTMLEditor.config.dialog_backgroundCoverColor   = '#333333';
    HTMLEditor.config.uiColor                       = '#cccccc';
    HTMLEditor.config.width                         = '792';
    HTMLEditor.config.resize_minWidth               = '780';
    HTMLEditor.config.height                        = '450';
    HTMLEditor.config.resize_minHeight              = '400';
    
    //HTMLEditor.config.scayt_autoStartup         = true;
    //HTMLEditor.config.disableNativeSpellChecker = false;
    
    HTMLEditor.config.toolbar               = [['Save','Preview','Maximize','-','Source'],
                                              ['Cut','Copy','Paste','PasteText','PasteFromWord','-','Print','SpellChecker', 'Scayt'],
                                              ['Undo','Redo','-','Find','Replace','-','SelectAll','RemoveFormat'],
                                               '/',
                                              ['Bold','Italic','Underline','Strike','-','Subscript','Superscript'],	                                               
                                              ['NumberedList','BulletedList','-','Outdent','Indent','Blockquote'],
                                              ['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
                                            	['Link','Unlink','Anchor'],
                                            	['Image','Flash','Table','HorizontalRule','SpecialChar'],
                                               '/',
                                            	['Styles','Format','FontSize'], // 'Font','FontName',
                                            	['TextColor','BGColor','-'],
                                            	['ShowBlocks','-','About']];		// No comma for the last row.
      
      
    
    // ----------------------------------------------------------------------
    // creates the editor instance, with replacing the textarea with the name="HTMLEditor"
  	HTMLEditor.replace( 'HTMLEditor',
      {
          //stylesCombo_stylesSet : 'htmlEditorStyles:../../../config/htmlEditorStyles.js',

      });
         
    CKFinder.SetupCKEditor( HTMLEditor, 'library/thirdparty/ckfinder/' ) ;
  }
  
  // -----------------------------------------
  // ADD SLIDE TO THE VISIT TIME MAX
  if($('visitTimeMax') != null) {

     // creates the slide effect
	   var slideVisitTimeMax = new Fx.Slide($('visitTimeMaxContainer'),{duration: '300', transition: Fx.Transitions.Pow.easeOut});  
    
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
    
});
