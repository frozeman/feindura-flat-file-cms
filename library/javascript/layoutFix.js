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
    
* set the Hight of the #mainBody element as high as #leftSidebar or #content
* depending on which is higher
* 
* layoutFix.php version 0.21 (require mootools-core) */

// fixes the problem that the leftSidebar is absoolute,
// so it will not aitosize the relative parent element
function layoutFix() {
  
  if($('leftSidebar') != null) {
    // get the high of both elements
    var leftSideBarHeight = $('leftSidebar').getSize().y;
    var contentHeight = $('content').getSize().y;
    
    // set the high of #mainBody as high as the highest element
    $('mainBody').set('tween', {duration: '550', transition: Fx.Transitions.Pow.easeOut});
    
    if(leftSideBarHeight > contentHeight) {
      $('mainBody').tween('height',leftSideBarHeight);
    } else {    
    	$('mainBody').setStyle('height', 'auto');
    }
  }
}

/* when the DOM is ready */
window.addEvent('domready', function() {

  layoutFix();
  
  // IE HACK for dimmContainer
	if(navigator.appVersion.match(/MSIE ([0-6]\.\d)/)) {
		$('dimmContainer').setStyle('height',$(document.body).offsetHeight); //,$('window').getSize().y);
	}

});