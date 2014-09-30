feindura - Flat File Content Management System
==============================================
rating pageRating
==============================================
Copyright (C) Fabian Vogelsteller [frozeman.de]
published under the GNU General Public License version 3

This program is free software;
you can redistribute it and/or modify it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 3 of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY;
without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program;
if not,see <http://www.gnu.org/licenses/>.
_____________________________________________

### VERSION 0.1

### AUTHOR
Fabian Vogelsteller <http://frozeman.de>


### DESCRIPTION
This plugin allows you to create a rating for each page.

### USAGE
A plugin can be displayed in your website with the showPlugins('contactForm',$pageId) method from the Feindura class (when the this plugin is activated in that page). See http://feindura.org/api/[Implementation]/Feindura.html#showPlugins for more.

### EVENTS
Event 'rated' will be fired on the "div.feinduraPlugin_pageRating" element, and the passed parameter is the new rating value.
Example to catch a rating event:

    $$('div.feinduraPlugin_pageRating').addEvent('rated',function(rating){
      alert('The new value is: ' + rating);
    });
    

### STYLING
This plugin will be wraped with a <div class="feinduraPlugins feinduraPlugin_pageRating" id="feinduraPlugin_PageRating_<currentPageID>"> to make it easy to style. 

You can use your own stars by just overwriting the "a.star" class, and set your own background-image and size.
When a star is selected it gets the ".filled" class too.
You should apply only hover/focus effects to a "a.star" link when the ratings div has the class "unrated" like here:
".feinduraPlugin_pageRating ul.unrated a.star:hover" (so the hover effect get disabled when the user has already rated, because the unrated class will be removed).

The HTML structure goes like that:

    <ul class="unrated" ...>
      <li><a href="#" class="star filled"></a></li>
      <li><a href="#" class="star filled"></a></li>
      <li><a href="#" class="star filled"></a></li>
      <li><a href="#" class="star"></a></li>
      <li><a href="#" class="star"></a></li>
    </ul>
