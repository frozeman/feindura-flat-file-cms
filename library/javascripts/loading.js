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
* loading.php version 0.3 (require mootools-core AND mootools-more)  */

// fix the layout height
function layoutFix() {  
  if($('leftSidebar') != null) {
    // get the high of both elements
    var leftSideBarHeight = $('leftSidebar').getSize().y;
    var contentHeight = $('content').getSize().y;
    
    if(leftSideBarHeight > contentHeight) {
      $('mainBody').setStyle('height',leftSideBarHeight);
    } else {
    	$('mainBody').setStyle('height', 'auto');
    }
  }
}

// create the JS LOADING-CIRCLE
function loadingCircle(holderid, R1, R2, count, stroke_width, colour) {
    var sectorsCount = count || 12,
        color = colour || "#fff",
        width = stroke_width || 15,
        r1 = Math.min(R1, R2) || 35,
        r2 = Math.max(R1, R2) || 60,
        cx = r2 + width,
        cy = r2 + width,
        r = Raphael(holderid, r2 * 2 + width * 2, r2 * 2 + width * 2),
        
        sectors = [],
        opacity = [],
        beta = 2 * Math.PI / sectorsCount,

        pathParams = {stroke: color, "stroke-width": width, "stroke-linecap": "round"};
        Raphael.getColor.reset();
    for (var i = 0; i < sectorsCount; i++) {
        var alpha = beta * i - Math.PI / 2,
            cos = Math.cos(alpha),
            sin = Math.sin(alpha);
        opacity[i] = 1 / sectorsCount * i;
        sectors[i] = r.path([["M", cx + r1 * cos, cy + r1 * sin], ["L", cx + r2 * cos, cy + r2 * sin]]).attr(pathParams);
        if (color == "rainbow") {
            sectors[i].attr("stroke", Raphael.getColor());
        }
    }
    var tick;
    (function ticker() {
        opacity.unshift(opacity.pop());
        for (var i = 0; i < sectorsCount; i++) {
            sectors[i].attr("opacity", opacity[i]);
        }
        r.safari();
        tick = setTimeout(ticker, 1000 / sectorsCount);
    })();
    return function () {
        clearTimeout(tick);
        r.remove();
    };
}

// create loading circle element
var jsLoadingCircleContent = new Element('div', {id: 'loadingCircleContent'});

// create the LOADING-CIRCLE
var loadingCircleContent = new Element('div', {id: 'loadingCircle'});

/* LOADING-CIRCLE when the DOM is loading
*
* creates loadingCircle and disappears when domready
*/
window.addEvent('domready', function() {
    
  var loadingBoxContent = $$('#loadingBox .content')[0];

  // ->> SHOW the loading circle 
  if($('content') != null && loadingBoxContent != null &&
     $('documentSaved') != null && !$('documentSaved').hasClass('saved')) {
    // -> add to the #content div
    loadingBoxContent.grab(loadingCircleContent,'top');
    //var removeLoadingCircle = loadingCircle('jsLoadingCircleContent', 20, 30, 12, 3, "#000");
    
    // set tween
    $('loadingBox').set('tween',{duration: 400})
    
    // show the loadingCircle
    $('loadingBox').fade('show');
    //$('loadingBox').setStyle('display','block');
    
    // disply none the documentsaved, after blending in and out
    $('loadingBox').get('tween').chain(function() {
        //removeLoadingCircle();
        loadingBoxContent.set('html','');
        $('loadingBox').setStyle('display','none');
        $('loadingBox').setStyle('opacity','1');
    }); 
    
    // blend out after page is loaded 
    window.addEvent('load', function() {
        $('loadingBox').tween('opacity','0');
    });
    
  // ->> hide loading circle, when it was not animated
  } else {
    loadingBoxContent.set('html','');
        $('loadingBox').setStyle('display','none');
        $('loadingBox').setStyle('opacity','1');
  }
});

// LOADING-CIRCLE when the website will be left
window.addEvent('unload',  function() {

  var loadingBox = $$('#loadingBox .content')[0];
   
  // empties the loadingBox, and refill with the loadingCircle
  if(loadingBox != null) {
    loadingBox.set('html','');
    loadingBox.grab(loadingCircleContent,'top');
    //loadingCircle('jsLoadingCircleContent', 20, 30, 12, 3, "#000");    

    $('loadingBox').setStyle('display','block');
  }  
});


/* ---------------------------------------------------------------------------------
* when the DOM is ready
*/
window.addEvent('domready', function() {
  
  // LAYOUTFIX
  layoutFix();
  
  // IE HACK for dimmContainer
	if(navigator.appVersion.match(/MSIE ([0-6]\.\d)/) && $('dimmContainer') != null) {
		$('dimmContainer').setStyle('height',$(document.body).offsetHeight); //,$('window').getSize().y);
	}
  
  // ->> if DOCUMENT SAVED has given the class from the php script
  if($('documentSaved') != null && $('documentSaved').hasClass('saved')) {

    // set tween
    $('dimmContainer').set('tween', {duration: 200, transition: Fx.Transitions.Pow.easeOut});
    
    // start tween
    $('documentSaved').fade('hide');
    $('documentSaved').tween('opacity','1');
    
    // hide the documentsaved, after blending in and out
    $('documentSaved').get('tween').chain(function() {      
      $('documentSaved').tween('opacity','0');
    }).chain(function(){
      $('documentSaved').setStyle('display','none');
      $('documentSaved').removeClass('saved');
    });
    
    //$('documentSaved').fireEvent('load', $('documentSaved'), 300);    
  }
  });
