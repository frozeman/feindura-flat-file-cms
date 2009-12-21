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
// java/windowBox.js version 0.38 (requires mootools-core and mootools-more)

/* ---------------------------------------------------------------------------------- */
// dimms the background and calls: requestSite(site,siteTitle);
function openWindowBox(site,siteTitle,fixed) {

    $('dimmContainer').setStyle('opacity','0');
    $('dimmContainer').setStyle('display','block');
    
    var fadeBg = new Fx.Tween($('dimmContainer'), {duration: 200, transition: Fx.Transitions.Sine.easeOut});
    fadeBg.start('opacity', '0.5');
    
    
   fadeBg.onComplete = function(e){
      if(site) {        
        
        // if fixed is true, than the window positon is relative,
        // means its fixed in the document, and NOT scrolling with the user
        if(fixed || navigator.appVersion.match(/MSIE ([0-6]\.\d)/)) {
          $('windowBox').setStyle('position','relative');
        } else {
          $('windowBox').setStyle('position','fixed');
        }
        
        // set the display to block
        $('windowBoxContainer').fade('show');
        //$('#windowBoxContainer').setStyle('visibility','visible');
        
        // set the fade
        $('windowBox').set('opacity','0');  			
        $('windowBox').tween('opacity','1');
  		  $('windowRequestBox').slide('show');
  		  

        // IE HACK, wont bring the bottom div to the top
  			if(navigator.appVersion.match(/MSIE ([0-6]\.\d)/)) {
  			   $$('#windowBox .boxBottom')[0].setStyle('top','68px');
  			}
        
  			// send HTML request
  			//$('windowBox').removeEvents();
  			//$('windowRequestBox').removeEvents();
        requestSite(site,siteTitle);
  		}
  	}
    
}

/* ---------------------------------------------------------------------------------- */
// fades all windows out and set windowBoxContainer to display:none;
// and remove alle Events from dimmContainer, windowBox, windowRequestBox
function closeWindowBox(redirectAfter) {

			// resize the box by a slide
			$('windowRequestBox').set('slide', {duration: '250', transition: Fx.Transitions.Pow.easeIn});
			$('windowBox').set('fade', {duration: '100', transition: Fx.Transitions.Pow.easeOut});
			$('dimmContainer').set('fade', {duration: '100', transition: Fx.Transitions.Pow.easeOut});
			
			// IE HACK, wont bring the bottom div to the top
			if(navigator.appVersion.match(/MSIE ([0-6]\.\d)/)) {
  			$$('#windowBox .boxBottom')[0].set('tween',{duration: '250', transition: Fx.Transitions.Pow.easeIn});
  			$$('#windowBox .boxBottom')[0].tween('top','0px');
			}	
			
			$('windowRequestBox').get('slide').addEvent('complete', function(e) {
    			// set the html inside the windowRequestBox div back.
    			$('windowRequestBox').set('html', '<div id="loadingCircle"></div>');
    			$('windowRequestBox').setStyle('height', 'auto');
    			
    			// fades the windowBox
    			$('windowBox').tween('opacity','0');
    			// fades the dimmContainer
          $('dimmContainer').tween('opacity','0');
    			
    			this.removeEvents();
        }); 
			
			// slides the windowRequestBox out
			$('windowRequestBox').slide('out');          

      
      // fades the windowBox
      $('windowBox').get('tween').addEvent('complete', function(e) {
            // set the display of the windowBoxContainerto none;
           $('windowBoxContainer').fade('hide');
            
            this.removeEvents();
        });
        
      // fades the dimmContainer // last effect
      $('dimmContainer').get('tween').addEvent('complete', function(e) {
    			   $('dimmContainer').setStyle('display','none');
    			   
    			   this.removeEvents();
    			   
    			   if(redirectAfter)
    			     document.location.href = redirectAfter;
        });
        
      return false;
}