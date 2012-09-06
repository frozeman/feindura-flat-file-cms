/*  feindura - Flat File Content Management System
    Copyright (C) Fabian Vogelsteller [frozeman.de]

    This program is free software;
    you can redistribute it and/or modify it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 3 of the License, or (at your option) any later version.

    This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY;
    without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
    See the GNU General Public License for more details.

    You should have received a copy of the GNU General Public License along with this program;
    if not,see <http://www.gnu.org/licenses/>.

*
*
* loading.php version 2.0.1 (require mootools-core AND mootools-more)  */


// vars
var dimmContainer = new Element('div',{'class':'dimmContainer'});


function showDocumentSaved() {

  var documentSaved = $('documentSaved');
  documentSaved.set('tween',{duration:500});

  // start tween
  documentSaved.setStyle('display','block').fade('hide').fade(1);

  // hide the documentsaved, after blending in and out
  documentSaved.get('tween').chain(function() {
    documentSaved.fade(0);
    documentSaved.get('tween').chain(function(){
      documentSaved.setStyle('display','none');
      documentSaved.removeClass('saved');
    });
  });
}

// create loading circle container
var jsLoadingCircleContainer = new Element('div', {'style': 'position: relative;top:4px;margin: auto;width: 100%;height: 100%;'});
var removeLoadingCircle = feindura_loadingCircle(jsLoadingCircleContainer, 18, 30, 12, 4, "#000");

// ->> LOADING CIRCLE FUNCTIONS

// -> show loading circle
function onStartLoadingCircle() {

  var loadingBox = $('loadingBox');

  // -> add to the .mainContent div
  loadingBox.grab(jsLoadingCircleContainer,'top');

  // set tween
 loadingBox.set('tween',{duration: 400});
  // show the loadingCircle
  loadingBox.setStyle('display','block');

  // add the loading circle
  if(!removeLoadingCircle)
    removeLoadingCircle = feindura_loadingCircle(jsLoadingCircleContainer, 18, 30, 12, 4, "#000");

  // blend out after page is loaded
  window.addEvent('load', function() {
    loadingBox.tween('opacity','0');

    // disply none the documentsaved, after blending in and out
    loadingBox.get('tween').chain(function() {
        removeLoadingCircle();
        removeLoadingCircle = false;
        loadingBox.setStyle('display','none');
        loadingBox.empty();
    });
  });
}

// -> hide loading circle
function onEndLoadingCircle() {

  // set tween
  // $('loadingBox').set('tween',{duration: 200});
  var loadingBox = $('loadingBox');

  // empties the loadingBox, and refill with the loadingCircle
  if(loadingBox !== null) {
    loadingBox.empty();
    loadingBox.grab(jsLoadingCircleContainer,'top');
    if(!removeLoadingCircle)
      removeLoadingCircle = feindura_loadingCircle(jsLoadingCircleContainer, 18, 30, 12, 4, "#000");
    loadingBox.setStyle('display','block');
    loadingBox.setStyle('opacity','1');
  }
}

/* LOADING-CIRCLE when the DOM is loading
*
* creates loadingCircle and disappears when domready
*/
window.addEvent('domready', function() {

  // inject the dimmContainer for the backend
  dimmContainer.inject(document.body,'top');

  // IE HACK for dimmContainer
	if(navigator.appVersion.match(/MSIE ([0-6]\.\d)/) && dimmContainer !== null) {
		dimmContainer.setStyle('height',$(document.body).offsetHeight); //,$('window').getSize().y);
	}
});

// LOADING-CIRCLE when the website will be left
window.addEvent('beforeunload',  function() {
  onEndLoadingCircle();
});
// LOADING-CIRCLE when the website will is left
window.addEvent('unload',  function() {
  if($('loadingBox') !== null) {
    $('loadingBox').setStyle('display','none');
    $('loadingBox').empty();
  }
});
