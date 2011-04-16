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
Just add the plugin to a page (with the showPlugins() method of the feindura class), and your visitors can rate this page.

### EVENTS
Event 'rated' will be fired on the "div.plugin_pageRating" element, and the passed parameter is the new rating value.
Example to catch a rating event:

    $$('div.plugin_pageRating').addEvent('rated',function(rating){
      alert('The new value is: ' + rating);
    });
    

### STYLING
To generally style the rating with css use the ".plugin_pageRating" class.
You can use your own stars by just overwriting the "a.star" class, and set your own background-image and size.
When a star is selected it gets the ".filled" class too.
You should apply only hover/focus effects to a "a.star" link when the ratings div has the class "unrated" like here:
".plugin_pageRating.unrated a.star:hover" (so the hover effect get disabled when the user rated already, because then the unrated class will be removed).

The HTML structure goes like that:

    <div class="plugin_pageRating unrated">
      <ul>
        <li><a href="#" class="star filled"></a></li>
        <li><a href="#" class="star filled"></a></li>
        <li><a href="#" class="star filled"></a></li>
        <li><a href="#" class="star"></a></li>
        <li><a href="#" class="star"></a></li>
      </ul>
    </div>