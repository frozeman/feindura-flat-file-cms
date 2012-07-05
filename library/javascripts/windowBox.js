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
// java/windowBox.js version 0.39 (requires mootools-core and mootools-more)

// vars
var loadingText;
var uploadAnimationElement = null;
var windowBoxIsVisible = false;

/* ---------------------------------------------------------------------------------- */
// dimms the background and calls: requestSite(site,siteTitle);
function openWindowBox(site,siteTitle) {

  if(site) {

    // place window in the useres sight
    $('windowBox').setStyle('top',window.getScroll().y + 150);

    loadingText = $$('#windowBox > h1').get('html');

    // dim container
    $('dimmContainer').setStyle('display','block');
    $('dimmContainer').fade('hide');
    $('dimmContainer').fade(1);

    // setting up the slidecontent
    $('windowRequestBox').set('slide',{duration: 200, transition: Fx.Transitions.Pow.easeOut});
    $('windowRequestBox').slide('show');

    // window box
    $('windowBoxContainer').fade('hide');
    $('windowBoxContainer').fade(1);

    windowBoxIsVisible = true;

		// send HTML request
    requestSite(site,siteTitle);
	}
  return false;
}

/* ---------------------------------------------------------------------------------- */
// fades all windows out and set windowBoxContainer to display:none;
// and remove alle Events from dimmContainer, windowBox, windowRequestBox
function closeWindowBox(redirectAfter) {

  if(!windowBoxIsVisible)
    return;

	// resize the box by a slide
	$('dimmContainer').set('tween', {duration: 300, transition: Fx.Transitions.Pow.easeOut});

	// fades the windowBox
  $('windowBoxContainer').fade('show');
	$('windowBoxContainer').fade(0);

	// fades the dimmContainer
  $('dimmContainer').fade('show');
  $('dimmContainer').fade(0);

  // slides the windowRequestBox out
  $('windowBoxContainer').get('tween').chain(function() {
    // set the html inside the windowRequestBox div back.
    $('windowRequestBox').empty();
    $('windowRequestBox').setStyle('height', 'auto');

    $('dimmContainer').setStyle('display','none');
    $$('#windowBox > h1').set('html',loadingText);

    windowBoxIsVisible = false;

    if(redirectAfter)
      document.location.href = redirectAfter;
  });

  return false;
}

/* ---------------------------------------------------------------------------------- */
// AJAX REQUEST
// send a HTML request and put the outcome in the windowRequestBox
function requestSite(site,siteTitle,formId) {

  // vars
  var formular = $(formId);
  var removeLoadingCircle;
  var windowRequestBox = $('windowRequestBox');
  var windowBox = $('windowBox');

  // creates the request Object
  new Request.HTML({url:site,
    //-----------------------------------------------------------------------------
    onRequest: function() { //-----------------------------------------------------

        // Clear the title <div>
        if(typeOf($$('#windowBox > h1')[0]) !== 'null')
          $$('#windowBox > h1')[0].destroy();

        // shows the LOADING
        if(navigator.appVersion.match(/MSIE ([0-7]\.\d)/)) {
          windowRequestBox.grab(new Element('div', {id: 'loadingCircle', style: 'position: absolute !important; top: 20px; left: 55px; width: 48px !important;'}),'top');
        } else {
          windowRequestBox.grab(new Element('div', {id: 'windowBoxDimmer'}),'top');
          removeLoadingCircle = feindura_loadingCircle('windowBoxDimmer', 23, 35, 12, 5, "#000");
        }
    },
    //-----------------------------------------------------------------------------
		onSuccess: function(html,childs,rawText) { //-------------------------------------------------

      // slide the content out
      windowRequestBox.slide('out');

      //slide out and quit, if the text of the window is "DONTSHOW"
      if(rawText.substring(1,9) == 'DONTSHOW') {
        return;
      }

      windowRequestBox.get('slide').chain(function() {
      // (function() {

        // fill in the content
        if(site) {
          if(!navigator.appVersion.match(/MSIE ([0-7]\.\d)/))
            removeLoadingCircle();
          //Clear the text currently inside the results div.
          windowRequestBox.set('html', '');
          //Inject the new DOM elements into the results div.
          windowRequestBox.adopt(html);
        }

        // fire a event if the page is loaded
        windowBox.fireEvent('loaded',windowRequestBox);

        // first fill in the title
        if(siteTitle) {
          // Inject the new DOM elements into the h1.
          windowBox.grab(new Element('h1',{'text':siteTitle}),'top');
        }

        /* set toolTips to all objects with a toolTip class */
        setToolTips();

        // slides in again
        windowRequestBox.slide('in');


      }).chain(function(){
      // })().chain(function(){
        // sets the height of the wrapper to auto after the slide,
        // so that the windowRequestBox, resizes automaticly when content is changing
        if(windowRequestBox.get('slide').wrapper.offsetHeight !== 0 && !navigator.appVersion.match(/MSIE ([0-6]\.\d)/))
          windowRequestBox.get('slide').wrapper.setStyle('height','auto');
      });

		},
		//-----------------------------------------------------------------------------
		//Our request will most likely succeed, but just in case, we'll add an
		//onFailure method which will let the user know what happened.
		onFailure: function() { //-----------------------------------------------------
			$('windowRequestBox').set('text', 'The request failed.');
    }
  }).post(formular);
}

// *** ->> THUMBNAIL - functions -----------------------------------------------------------------------------------------------------------------------

//--------------------------------------------------
// called on the beginning of the upload
function startUploadAnimation() {

  // shows the LOADING
  if(!navigator.appVersion.match(/MSIE ([0-7]\.\d)/)) {
    $('windowRequestBox').grab(new Element('div', {id: 'windowBoxDimmer', style: 'padding-top: 100px;'}),'top');
    $('windowBoxDimmer').setStyle('display','block');
    uploadAnimationElement = feindura_loadingCircle('windowBoxDimmer', 23, 35, 12, 5, "#000");
  } else {
    uploadAnimationElement = new Element('div', {id: 'loadingCircle', style: 'position: absolute !important; top: 20px; left: 55px; width: 48px !important;'});
    $('windowRequestBox').grab(uploadAnimationElement,'top');
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
  if(uploadAnimationElement !== null) {
    // IE HACK
    if(!navigator.appVersion.match(/MSIE ([0-7]\.\d)/)) {
      uploadAnimationElement();
      //$('windowBoxDimmer').setStyle('padding',0);
      //$('windowBoxDimmer').tween('height',0);
      // slides in again
        $('windowRequestBox').slide('out');

        $('windowRequestBox').get('slide').chain(function() {
          $('windowBoxDimmer').setStyle('display','none');
          $('windowRequestBox').slide('in');
        });

    } else {
      uploadAnimationElement.destroy();
    }

    return true;
  }
  return false;
}
//--------------------------------------------------
// called on the SUCCESFULL end of the upload
function finishThumbnailUpload(frameHeight,newImage,ImageWidth) {

  // shows the iframe content
  if($('uploadTargetFrame').tween('height',frameHeight))

  // show the ok button
  $('pageThumbnailOkButton').setStyle('display','block');

  refreshThumbnailImage(newImage,ImageWidth);

  // hides the from and the thumbInfo
  $('pageThumbnailUploadForm').setStyle('display','none');
  $('thumbInfo').setStyle('display','none');
}

// *---------------------------------------------------------------------------------------------------*
//  DOMREADY
// *---------------------------------------------------------------------------------------------------*
window.addEvent('domready', function() {

    // -> CLOSE WINDOW BOX by clicking the dimmContainer or windowBoxContainer
  $$('#dimmContainer, #windowBoxContainer').addEvent('click',function(e) {
    if(e.target.getProperty('id') == 'dimmContainer' || e.target.getProperty('id') == 'windowBoxContainer')
    closeWindowBox();
  });

  // *** ->> THUMBNAIL -----------------------------------------------------------------------------------------------------------------------

  // run the script if the windowBox is loaded with content
  $('windowBox').addEvent('loaded',function(windowContent) {

    // checks if the pageThumbnailUpload site is opend
    if($('pageThumbnailUploadForm') !== null) {
      // hides the iframe on startup
      $('uploadTargetFrame').setStyle('width','0px');
      $('uploadTargetFrame').setStyle('height','0px');

      // hide the ok button
      $('pageThumbnailOkButton').setStyle('display','none');

      // -----------------------------------------
      // ADD SLIDE TO THE THUMB-SIZE
      if($('thumbSize') !== null && !navigator.appVersion.match(/MSIE ([0-6]\.\d)/)) {

        // creates the slide effect
        var slideThumbSize = new Fx.Slide($('thumbSize'),{duration: '750', transition: Fx.Transitions.Pow.easeOut});

        // slides the hotky div in, on start
        slideThumbSize.hide();

        // sets the SLIDE EFFECT to the buttons
        if($('thumbSizeToogle') !== null) {
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