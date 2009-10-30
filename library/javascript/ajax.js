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
// java/ajax.js version 0.3 (requires mootools-core)

/* ---------------------------------------------------------------------------------- */
// send a HTML request and put the outcome in the windowRequestBox
function requestSite(site,siteTitle,formId) {

  var formular = $(formId);
  var newWindow = true;
  
  // creates the request Object
  var requestSite = new Request.HTML({url:site,
    //-----------------------------------------------------------------------------
    onRequest: function() { //-----------------------------------------------------
        
        //Clear the boxTop <div>
    		$$('#windowBox .boxTop').set('html', '<a href="#" onclick="closeWindowBox(false);"></a>');
        
        // checks if the windowRequestBox is empty, means that an new window is opend
  		  if($('windowRequestBox').get('text') != '')
  		    newWindow = false;
        
        // shows the LOADING on the top left
        if(!newWindow) {
          $('windowRequestBox').grab(new Element('div', {id: 'loadingCircle', style: 'position: absolute !important; top: 20px; left: 55px; width: 48px !important;'}),'top');
        }
    },
    //-----------------------------------------------------------------------------
		onSuccess: function(html) { //-------------------------------------------------

			// then fill in the content
			if(site) {
  			//Clear the text currently inside the results div.
  			$('windowRequestBox').set('text', '');
  			//Inject the new DOM elements into the results div.
  			$('windowRequestBox').adopt(html);
			}
			
			// fire a event if the page is loaded
			$('windowBox').fireEvent('loaded',$('windowRequestBox'));
		
			// resize the box by a slide; set the slide
			$('windowRequestBox').set('slide', {duration: '500', transition: Fx.Transitions.Pow.easeOut});
      
      // sets the height of the wrapper to auto after the slide,
      // so that the windowRequestBox, resizes automaticly when content is changing
      $('windowRequestBox').get('slide').addEvent('complete', function() {
        if($('windowRequestBox').get('slide').wrapper.offsetHeight != 0 && !navigator.appVersion.match(/MSIE ([0-6]\.\d)/))
          $('windowRequestBox').get('slide').wrapper.setStyle('height','auto');
      });
			
			// only when the a new window is opend slide in ------------
			if(newWindow) {
			
  		  // first fill in the title
  		  if(siteTitle) {  		  
    			//Inject the new DOM elements into the boxTop div.
    			$$('#windowBox .boxTop').set('html',siteTitle + '<a href="#" onclick="closeWindowBox();"></a>');
  			}			   
  
        // slides in
        $('windowRequestBox').slide('hide');
        $('windowRequestBox').slide('in');
        
          
        // IE HACK, wont bring the bottom div to the bottom
  			if(navigator.appVersion.match(/MSIE ([0-6]\.\d)/)) {
    			$$('#windowBox .boxBottom')[0].setStyle('top','68px');
    			$$('#windowBox .boxBottom')[0].set('tween',{duration: '500', transition: Fx.Transitions.Pow.easeOut});
    			$$('#windowBox .boxBottom')[0].tween('top',$('windowRequestBox').getSize().y);
  			}
  		
  		// else RESIZE ------------
			} else {
			   
			  // slides out
        $('windowRequestBox').slide('show');
          
        // IE HACK, wont bring the bottom div to the bottom
  			if(navigator.appVersion.match(/MSIE ([0-6]\.\d)/)) {
    			$$('#windowBox .boxBottom')[0].setStyle('top',$('windowRequestBox').getSize().y);
  			}	
      
      }			
			
			/* set toolTips to all objects with a toolTip class */
			setToolTips();
		},
		//-----------------------------------------------------------------------------
		//Our request will most likely succeed, but just in case, we'll add an
		//onFailure method which will let the user know what happened.
		onFailure: function() { //-----------------------------------------------------
			$('result').set('text', 'The request failed.');
		  }
    }).post(formular);

}

