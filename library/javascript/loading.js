/*  feindura - Flat File Content Management System
    Copyright (C) 2009 Fabian Vogelsteller [frozeman.de]

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
* loading.php version 0.3 (require mootools-core AND mootools-more)  */


// create the LOADING-CIRCLE
if(navigator.appVersion.match(/MSIE ([0-6]\.\d)/)) {
  var loadingCircleContent = new Element('div', {id: 'loadingCircleContent', style: 'z-index: 4; display: block; position: relative; width: 48px; height: 48px; background: url(library/image/sign/loadingCircle.gif) no-repeat;'});
} else {
  var loadingCircleContent = new Element('div', {id: 'loadingCircleContent', style: 'z-index: 4; display: block; position: relative; left: 115px; width: 48px; height: 48px; background: url(library/image/sign/loadingCircle.gif) no-repeat;'});
}

/* LOADING-CIRCLE when the DOM is loading
*
* creates loadingCircle and disappears when domready*/
window.addEvent('load', function() {
  //loadingCircle(false);
  
   var lastLoadingTween = false;    
    
  // add the loading circle to the #content div
  if($('content') != null)
    //$('content').grab(loadingCircleContent,'top');
    $$('#loadingBox .content')[0].grab(loadingCircleContent,'top');

  // show the loadingCircle
  $('loadingBox').fade('in');
  
  // disply none the documentsaved, after blending in and out
  $('loadingBox').get('tween').addEvent('complete', function() {   
      if(lastLoadingTween) {
        $('loadingBox').setStyle('display','none');
        $('loadingBox').setStyle('opacity','1');
        $('loadingBox').removeEvents();
      }
  }); 
      
  window.addEvent('domready', function() {
      $('loadingBox').tween('opacity','0');
      lastLoadingTween = true;
  });
  
});

/* LOADING-CIRCLE when the DOM is unloading
*
* creates a loadingCircle and disappears new site is loaded and site will change*/
window.addEvent('unload',  function() {
  //loadingCircle(true);
  
  // empties the loadingBox, and refill with the loadingCircle
  $$('#loadingBox .content')[0].set('html','');
  $$('#loadingBox .content')[0].grab(loadingCircleContent,'top');
  
  $('loadingBox').setStyle('display','block'); 
  //loadingCircleContent.setStyle('opacity','0');
  //loadingCircleContent.setStyle('opacity','1');
  //loadingCircleContent.fade('show');
});



/* ---------------------------------------------------------------------------------
* when the DOM is ready */
window.addEvent('domready', function() {
    
    
    // SHOWS UP IF THE PAGE HAS BEEN SAVED!
    var lastTween = false;    
    
    // if documentSaved has given the class from the php script
    if($('documentSaved') != null && $('documentSaved').hasClass('saved')) {    
    
      // disply none the documentsaved, after blending in and out
      $('documentSaved').get('tween').addEvent('complete', function() {      
          if(lastTween) {
            $('documentSaved').setStyle('display','none');
            $('documentSaved').removeClass('saved');
          }
      });

      $('documentSaved').fade('hide');
      $('dimmContainer').set('tween', {duration: '300', transition: Fx.Transitions.Pow.easeOut});
      $('documentSaved').tween('opacity','1');
      
      
      $('documentSaved').addEvent('load', function() {
          $('documentSaved').tween('opacity','0');
          
          lastTween = true;
      });
      
      $('documentSaved').fireEvent('load', $('documentSaved'), 1000);
      
    }
  });
