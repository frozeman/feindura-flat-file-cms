feindura - Flat File Content Management System
==============================================
slideShow plugin
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

### VERSION 1.0

### AUTHOR
Fabian Vogelsteller <http://frozeman.de>


### DESCRIPTION
This plugin creates automatically a slide show from images selected in the backend. On the first load of the plugin in the website,
the images will be resized to the size set in the plugin settings.

### USAGE
The slideShow plugin can be displayed in your website with the showPlugins('slideShow',$pageId) method from the feindura class (when activated in the page with the $pageId).

### STYLING
To style the slideShow with css use the ".feinduraPlugin_slideShow" class.


### USES
NivooSlider http://www.johannes-fischer.de/labs/nivoo-slider/
MooTools http://mootools.net/ (Attention!! could have conflicts with other frameworks, used by your website!!)