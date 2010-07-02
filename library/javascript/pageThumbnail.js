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
// java/pageThumbnail.js version 0.22


var startUploadAnimationElement = null;

//--------------------------------------------------
// called on the beginning of the upload
function startUploadAnimation() {
  
  // shows the LOADING
  if(!navigator.appVersion.match(/MSIE ([0-7]\.\d)/)) {
    $('windowRequestBox').grab(new Element('div', {id: 'windowBoxDimmer'}),'top');
    startUploadAnimationElement = loadingCircle('windowBoxDimmer', 30, 50, 12, 10, "#fff");
  } else {
    startUploadAnimationElement = new Element('div', {id: 'loadingCircle', style: 'position: absolute !important; top: 20px; left: 55px; width: 48px !important;'});
    $('windowRequestBox').grab(startUploadAnimationElement,'top'); 
  }
  
  return true;

}
//--------------------------------------------------
// called on the end of the upload
function stopUploadAnimation() {
  
  // shows the iframe content
  $('uploadTargetFrame').setStyle('width','100%');
  $('uploadTargetFrame').tween('height','100px');
  
  // removes the loading animation
  if(startUploadAnimationElement != null) {
  
    if(!navigator.appVersion.match(/MSIE ([0-7]\.\d)/)) {
      startUploadAnimationElement();
      $('windowBoxDimmer').setStyle('padding',0);
      $('windowBoxDimmer').tween('height',0);
      
    } else {
      startUploadAnimationElement.destroy();
    } 
    
    return true;
  }
  return false;
}
//--------------------------------------------------
// called on the SUCCESFULL end of the upload
function finishUpload(frameHeight) {

  // shows the iframe content
  if($('uploadTargetFrame').tween('height',frameHeight + 'px'))
  
  // show the ok button
  $('pageThumbnailOkButton').setStyle('display','block');
  
  // hides the from and the thumbInfo
  $('pageThumbnailUploadForm').setStyle('display','none');
  $('thumbInfo').setStyle('display','none');
}

// DOMREADY ---------------------------------------------------
window.addEvent('domready', function() {
  
  // run the script if the windowBox is loaded with content
  $('windowBox').addEvent('loaded',function(windowContent) {
    
    // checks if the pageThumbnailUpload site is opend
    if($('pageThumbnailUploadForm') != null) {
      // hides the iframe on startup
      $('uploadTargetFrame').setStyle('width','0px');
      $('uploadTargetFrame').setStyle('height','0px');
      
      // hide the ok button
      $('pageThumbnailOkButton').setStyle('display','none');
    
      // -----------------------------------------
      // ADD SLIDE TO THE THUMB-SIZE
      if($('thumbSize') != null && !navigator.appVersion.match(/MSIE ([0-6]\.\d)/)) {  
    
         // creates the slide effect
    	   var slideThumbSize = new Fx.Slide($('thumbSize'),{duration: '750', transition: Fx.Transitions.Pow.easeOut});  
        
         // slides the hotky div in, on start
         slideThumbSize.hide();
        
         // sets the SLIDE EFFECT to the buttons
         if($('thumbSizeToogle') != null) {
           $('thumbSizeToogle').addEvent('click', function(e){  	   
          		e.stop();    		
          		slideThumbSize.toggle();
          	});
         }
      }
      
      // sets the realtime
      setThumbScale('windowBox_thumbWidth','windowBox_thumbWidthScale','windowBox_thumbHeight','windowBox_thumbHeightScale');
    
      /* set autoresize to THUMBNAIL PREVIEW */
			//autoResizeThumbnailPreview();
    }
  });
});

