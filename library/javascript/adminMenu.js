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
// java/adminMenu.js version 0.12 (requires mootools-core and mootools-more)

// DOMREADY
window.addEvent('domready', function() {
  
  if($('adminMenu') != null) {
    // set the style back, which is set for non javascript users
    $('adminMenu').setStyle('width','172px');
    $('adminMenu').setStyle('overflow','hidden');
    
    // set tween
    $('adminMenu').set('tween',{duration: '500', transition: Fx.Transitions.Pow.easeOut});
    
    // add resize tween event
    $('adminMenu').addEvents({
      'mouseover' : function() { // resize on mouseover        
          $('adminMenu').tween('height',($$('#adminMenu .content table')[0].offsetHeight + 36) + 'px');
      },
      'mouseout' : function() { // resize on onmouseout
          $('adminMenu').tween('height','140px');
      }
    });
  }
  
});