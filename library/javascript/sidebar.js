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
// javascript/sidebar.js version 0.32 (requires mootools-core and mootools-more)


window.addEvent('domready', function() {
  
  // ->> LOG LIST
  // ------------
  if($('sidebarTaskLog') != null) {

    // vars
    var minHeight = '200px';
    var maxHeight = '450px';
    
    // -> adds the TWEEN to the LOG-list
    $('sidebarTaskLog').setStyle('height',minHeight);
    
    // TWEEN OUT
    $('sidebarTaskLog').addEvent('mouseenter', function() {
      $('sidebarTaskLog').tween('height',maxHeight);
    });
    // TWEEN IN
    $('sidebarTaskLog').addEvent('mouseleave', function() {
      $('sidebarTaskLog').tween('height',minHeight);
    });
    
    // TWEEN OUT sidebarScrollUp
    $('sidbarTaskLogScrollUp').addEvent('mouseenter', function() {
      $('sidebarTaskLog').tween('height',maxHeight);
    });
    // TWEEN IN sidebarScrollUp
    $('sidbarTaskLogScrollUp').addEvent('mouseleave', function() {
      $('sidebarTaskLog').tween('height',minHeight);
    });
    
    // TWEEN OUT sidebarScrollDown
    $('sidbarTaskLogScrollDown').addEvent('mouseenter', function() {
      $('sidebarTaskLog').tween('height',maxHeight);
    });
    // TWEEN IN sidebarScrollDown
    $('sidbarTaskLogScrollDown').addEvent('mouseleave', function() {
      $('sidebarTaskLog').tween('height',minHeight);
    });
    
    // add DIV SCROLLER
    var logScroller = new divScroller('sidebarTaskLog', {area: 150,direction: 'y', velocity: 0.4,scrollSpeed: 60});
  	// myContent
  	$('sidebarTaskLog').addEvent('mouseenter', logScroller.start.bind(logScroller));
  	$('sidebarTaskLog').addEvent('mouseleave', logScroller.stop.bind(logScroller));

   }
});