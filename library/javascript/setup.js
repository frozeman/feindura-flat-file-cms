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
// java/setup.js version 0.23 (requires mootools-core and mootools-more)


var deactivateType = 'disabled'; // disabled/readonly

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

// DOMREADY ------------
// ->> LOADED ON STARTUP
window.addEvent('domready', function() {
  
  // adds realtime THUMBSCALE to the thumbnail Settings
  setThumbScale('cfg_thumbWidth','thumbWidthScale','cfg_thumbHeight','thumbHeightScale');
  
  // adds THUMBRATIO deactivation
  setThumbRatio('cfg_thumbWidth','ratioX','cfg_thumbHeight','ratioY','noRatio'); 
  
  // -----------------------------------------
  // GO TROUGH every CATEGORY
  if($$('.advancedcategoryConfig') != null) {
    
    var countCategories = 0;
    
    // -----------------------------------------
    // ADD SLIDE TO THE ADVANCED CATEGORY SETTINGS
    // go trough every advancedcategoryConfig class and add the slide effect
    $$('.categoryConfig').each(function(categoryConfig) {
       // count categories
       countCategories++;
       
       // var
       var advancedcategoryConfigTable = categoryConfig.getElements('table')[1];
    
       // creates the slide effect
  	   var slideAdvancedcategoryConfig = new Fx.Slide(advancedcategoryConfigTable,{duration: '750', transition: Fx.Transitions.Pow.easeOut});  
       
       
      
       // ON COMPLETE
       slideAdvancedcategoryConfig.onComplete = function(el) {
  
            // mootools creates an container around slideContent, so that it doesn't resize anymore automaticly, so i have to reset height auto for this container
            if(slideAdvancedcategoryConfig.open) {
              advancedcategoryConfigTable.getParent().fade('hide');
              slideAdvancedcategoryConfig.open = false;
            } else {              
              advancedcategoryConfigTable.getParent().fade('show');
              slideAdvancedcategoryConfig.open= true;
            }
        }
      
       // slides the hotky div in, on start
       if(advancedcategoryConfigTable.hasClass('hidden')) {
         // hides the wrapper on start
         slideAdvancedcategoryConfig.hide();
         advancedcategoryConfigTable.getParent().fade('hide');
       }
      
       // sets the SLIDE EFFECT to the buttons
       if(categoryConfig.getElements('a')[2] != null) {
         categoryConfig.getElements('a')[2].addEvent('click', function(e) {
        		e.stop();	
        		slideAdvancedcategoryConfig.toggle();
        		advancedcategoryConfigTable.getParent().fade('show');
        		advancedcategoryConfigTable.toggleClass('hidden');
        	});
       }
       
      // -----------------------------------------
      // adds realtime THUMBSCALE to the advanced category settings
      setThumbScale('categories'+countCategories+'thumbWidth','categories'+countCategories+'thumbWidthScale','categories'+countCategories+'thumbHeight','categories'+countCategories+'thumbHeightScale');
    
      // adds THUMBRATIO deactivation
      setThumbRatio('categories'+countCategories+'thumbWidth','categories'+countCategories+'ratioX','categories'+countCategories+'thumbHeight','categories'+countCategories+'ratioY','categories'+countCategories+'noRatio'); 
    });
  }
  
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
  
  
  
});

// -> editFiles
function changeFile( site, fileName, status, anchorName )
{
  window.location.href = window.location.pathname + "?site=" + site + "&status=" + status + "&file=" + fileName + "#" + anchorName ;
}

// -> NO SUBMIT goto ANCHOR
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
  } else
    $(formId).setAttribute('action',($(formId).getAttribute('action') + '#' + anchorName));
}