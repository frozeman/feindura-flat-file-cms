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
// java/windowBox.js version 0.5 (requires mootools-core and mootools-more)

// vars
var windowRequestBox = new Element('div',{'class':'windowRequestBox'});
var windowBox = new Element('div',{'class':'windowBox feindura'}).adopt(new Element('h1'),new Element('a',{'class':'close','href':'#',events: {
  'click': function(){closeWindowBox(false);return false;}
}}),windowRequestBox);
var windowBoxDimmer = new Element('div', {'class': 'windowBoxDimmer'});

var uploadAnimationElement = null;
var windowBoxIsVisible = false;
var removeWindowBoxLoadingCircle;



/* ---------------------------------------------------------------------------------- */
// dimms the background and calls: requestSite(site,siteTitle);
function openWindowBox(site,siteTitle,data) {

  if(site) {

    // inject windowBox
    if(typeOf(windowBox.getParent('body')) === 'null')
      windowBox.inject(document.body);

    // inject dimmContainer
    if(typeOf(dimmContainer.getParent('body')) === 'null')
      dimmContainer.inject(document.body,'top');

    windowBox.getChildren('h1').set('html',feindura_langFile.LOADING_TEXT_LOAD);

    // place window in the useres sight
    windowBox.setStyle('top',window.getScroll().y + 150);
    windowBox.show();
    // dim container
    dimmContainer.show();

    // setting up the slidecontent
    windowRequestBox.set('slide',{duration: 200, transition: Fx.Transitions.Pow.easeOut});
    windowRequestBox.slide('show');

    windowBoxIsVisible = true;

		// send HTML request
    requestSite(site,siteTitle,data);
	}
  return false;
}

/* ---------------------------------------------------------------------------------- */
// fades all windows out
// and remove alle Events from dimmContainer, windowBox, windowRequestBox
function closeWindowBox(redirectAfter) {

  if(!windowBoxIsVisible)
    return;

	// resize the box by a slide
	dimmContainer.set('tween', {duration: 300, transition: Fx.Transitions.Pow.easeOut});

	// fades the windowBox
  windowBox.hide();
	// fades the dimmContainer
  dimmContainer.hide();

  windowBox.removeEvents('loaded'); // prevent the page scripts from the last windowBox beeing executed again
  windowBox.removeEvents('hide');
  // slides the windowRequestBox out
  windowBox.addEvent('hide',function() {

    // clear the html inside the windowRequestBox.
    windowRequestBox.empty();
    windowRequestBox.setStyle('height', 'auto');

    windowBox.getChildren('h1').set('html',feindura_langFile.LOADING_TEXT_LOAD);
    windowBox.dispose();

    windowBoxIsVisible = false;

    if(redirectAfter)
      document.location.href = redirectAfter;
  });

  return false;
}

/* ---------------------------------------------------------------------------------- */
// AJAX REQUEST
// send a HTML request and put the outcome in the windowRequestBox
function requestSite(site,siteTitle,dataOrFormId) {

  // vars
  var data = (typeOf(dataOrFormId) == 'object') ? dataOrFormId : $(dataOrFormId);

  // creates the request Object
  new Request.HTML({
    url:site,
    evalScripts: true,
    //-----------------------------------------------------------------------------
    onRequest: function() { //-----------------------------------------------------

        // shows the LOADING
        windowRequestBox.grab(windowBoxDimmer,'top');
        removeWindowBoxLoadingCircle = feindura_loadingCircle(windowBoxDimmer, 24, 38, 12, 5, "#000");
    },
    //-----------------------------------------------------------------------------
		onSuccess: function(html,childs,rawText,responseJavaScript) { //-------------------------------------------------


      // CLOSE the windowBox AND REDIRECT, if the first part of the response is '#REDIRECT#'
      // the first character is a " " because of the safari htmlentities bug, thats why its starting with 1.
      if(rawText.substring(1,11) == '#REDIRECT#') {
        removeWindowBoxLoadingCircle();
        closeWindowBox(rawText.substring(11));
        return;
      // CLOSE the windowBox, if the first part of the response is '#CLOSE#'
      } else if(rawText.substring(1,8) == '#CLOSE#') {
        removeWindowBoxLoadingCircle();
        closeWindowBox();
        return;
      // LOGOUT when logged out
      } else if(rawText == '#LOGOUT#') {
        window.location.href = '?logout';
        return;
      }

      // slide the content out
      windowRequestBox.slide('out');

      windowRequestBox.get('slide').chain(function() {

        // fill in the content
        if(site) {

          removeWindowBoxLoadingCircle();

          //Clear the text currently inside the results div.
          windowRequestBox.set('html', '');

          //Inject the new DOM elements into the results div.
          windowRequestBox.adopt(html);
        }

        // fire a event if the page is loaded
        windowBox.fireEvent('loaded',windowRequestBox);
        windowBox.fireEvent('loadDefaults',windowRequestBox);

        // fill in the TITLE
        if(siteTitle) {

          // Clear the title <div>
          if(typeOf(windowBox.getChildren('h1')[0]) !== 'null')
            windowBox.getChildren('h1')[0].destroy();

          // Inject the new DOM elements into the h1.
          windowBox.grab(new Element('h1',{'text':siteTitle}),'top');
        } else {
          if(typeOf(windowBox.getChildren('h1')[0]) !== 'null')
            windowBox.getChildren('h1')[0].destroy();
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
      removeWindowBoxLoadingCircle();
			windowRequestBox.set('html', '<div class="alert alert-error center">Couldn\'t load the Page</div><a href="#" class="ok button center" onclick="closeWindowBox();return false;"></a>');
    }
  }).post(data);
}

// *** ->> THUMBNAIL - functions -----------------------------------------------------------------------------------------------------------------------

//--------------------------------------------------
// called on the beginning of the upload
function startUploadAnimation() {

  // shows the LOADING
  windowRequestBox.grab(windowBoxDimmer.setStyle('padding-top','100px;'),'top');
  windowBoxDimmer.setStyle('display','block');
  uploadAnimationElement = feindura_loadingCircle(windowBoxDimmer, 23, 35, 12, 5, "#000");
  return true;
}
//--------------------------------------------------
// called on the end of the upload
function stopUploadAnimation() {

  // shows the iframe content
  $('uploadTargetFrame').setStyle('width','100%');
  $('uploadTargetFrame').setStyle('height','100px');

  // removes the loading animation
  if(uploadAnimationElement !== null) {
    // IE HACK
    if(!navigator.appVersion.match(/MSIE ([0-7]\.\d)/)) {
      uploadAnimationElement();
      //$('windowBoxDimmer').setStyle('padding',0);
      //$('windowBoxDimmer').tween('height',0);
      // slides in again
        windowRequestBox.slide('out');

        windowRequestBox.get('slide').chain(function() {
          windowBoxDimmer.setStyle('display','none');
          windowRequestBox.slide('in');
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
function finishThumbnailUpload(frameHeight,newImage) {

  // delete the previous preview image
  if($('windowBoxThumbnailPreview') !== null)
    $('windowBoxThumbnailPreview').destroy();

  // shows the iframe content
  $('uploadTargetFrame').tween('height',frameHeight);

  // show the ok button
  $('pageThumbnailOkButton').setStyle('display','inline-block');

  refreshThumbnailImage(newImage);

  // hides the from and the thumbInfo
  $('uploadPageThumbnailForm').setStyle('display','none');

  // automatically close
  // (function(){closeWindowBox()}).delay(1000);
}

// *---------------------------------------------------------------------------------------------------*
//  DOMREADY
// *---------------------------------------------------------------------------------------------------*
window.addEvent('domready', function() {

    // -> CLOSE WINDOW BOX by clicking the dimmContainer
  dimmContainer.addEvent('click',function(e) {
    if(e.target.hasClass('dimmContainer'))
      closeWindowBox();
  });


  // run the scripts if the windowBox is loaded with content
  windowBox.addEvent('loadDefaults',function(windowContent) {

    // ADD FANCY FORMS
    new FancyForm(windowBox.getElements('input[type="checkbox"], input[type="radio"]'));

    // ADD FORM AUTOGROW
    windowBox.getElements('textarea.autogrow').each(function(textarea){
      new Form.AutoGrow(textarea);
    });

    // THUMBNAIL SCALE
    // checks if the uploadPageThumbnail site is opend
    if($('uploadPageThumbnailForm') !== null) {
      // hides the iframe on startup
      $('uploadTargetFrame').setStyle('width','0px');
      $('uploadTargetFrame').setStyle('height','0px');

      // hide the ok button
      $('pageThumbnailOkButton').setStyle('display','none');

      // -----------------------------------------
      // ADD SLIDE TO THE THUMB-SIZE
      if($('thumbnailSizeBox') !== null && !navigator.appVersion.match(/MSIE ([0-6]\.\d)/)) {

        // creates the slide effect
        var slideThumbSize = new Fx.Slide($('thumbnailSizeBox'),{duration: '750', transition: Fx.Transitions.Pow.easeOut});

        // slides the hotky div in, on start
        slideThumbSize.hide();

        // sets the SLIDE EFFECT to the buttons
        if($('thumbSizeToogle') !== null) {
          $('thumbSizeToogle').setStyle('opacity',0.5);
          $('thumbSizeToogle').addEvents({
            'click': function(e){
                e.stop();
                slideThumbSize.toggle();
              },
            mouseenter: function(){
              $('thumbSizeToogle').tween('opacity',1);
            },
            mouseleave: function(){
              $('thumbSizeToogle').tween('opacity',0.5);
            }
          });
        }
      }

      // sets the realtime
      setThumbScale('windowBox_thumbWidth','windowBox_thumbWidthScale','windowBox_thumbHeight','windowBox_thumbHeightScale');
    }
  });
});