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
// java/editor.js version 0.14 (requires CKEditor)


window.addEvent('domready', function() {
  
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
                              ['Save','Preview','-','Maximize','-','Source'],
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
  
      
    
    // ----------------------------------------------------------------------
    // CREATES the editor instance, with replacing the textarea with the id="HTMLEditor"
  	CKEDITOR.replace('HTMLEditor',{
  	  
    });

    
    // ADDS the CKFinder as filemanager to the CKEditor
    //CKFinder.SetupCKEditor(CKEDITOR, 'library/thirdparty/ckfinder/');
    
    
     
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
