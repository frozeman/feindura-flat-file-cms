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
// java/sidebar.js version 0.1 (requires mootools-core and mootools-more)



window.addEvent('domready', function() {
  
  // ->> LOG LIST
  var scrollLog = new Scroller('sidebarTaskLog', {area: 300, velocity: 0.4});
	// myContent
	$('sidebarTaskLog').addEvent('mouseenter', scrollLog.start.bind(scrollLog));
	$('sidebarTaskLog').addEvent('mouseleave', scrollLog.stop.bind(scrollLog));  
  
  /*
  if($('sidebarTaskLog') != null) {
    // vars
    var minHeight = '200px';
    var maxHeight = '450px';
  
    // -> adds the SCROLL to the LOG-list
    var logScroll = new Fx.Scroll('sidebarTaskLog', {
      offset: {        
          'x': 0,
          'y': 0
      },
      duration: 2500,
      wait: false
    });
    
    // scroll up
    $('sidbarTaskLogScrollUp').addEvent('mouseover', function() {
      logScroll.toTop();
      // prevent tween back
      $('sidebarTaskLog').tween('height',maxHeight);
    });
    
    // scroll down
    $('sidbarTaskLogScrollDown').addEvent('mouseover', function() {
      logScroll.toBottom();
      // prevent tween back
      $('sidebarTaskLog').tween('height',maxHeight);
    });
    
    // -> adds the TWEEN to the LOG-list
    $('sidebarTaskLog').setStyle('height',minHeight);
    
    // mouseover
    $('sidebarTaskLog').addEvent('mouseover', function() {
      $('sidebarTaskLog').tween('height',maxHeight);
      logScroll.cancel();
    });
    // mouseout
    $('sidebarTaskLog').addEvent('mouseout', function() {
      $('sidebarTaskLog').tween('height',minHeight);
    });
    
    // mouseout scroll UP
    $('sidbarTaskLogScrollUp').addEvent('mouseout', function(){
      $('sidebarTaskLog').tween('height',minHeight);
    });    
    // mouseout scroll DOWN
    $('sidbarTaskLogScrollDown').addEvent('mouseout', function(){
      $('sidebarTaskLog').tween('height',minHeight);
    });    

   }*/
});