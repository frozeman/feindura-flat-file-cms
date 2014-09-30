feindura - Flat File Content Management System
==============================================
slideShowFromFolder plugin
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
This plugin creates automatically a slide show from a folder containing images. On the first load of the plugin in the website,
the images will be resized to the size set in the plugin settings.

### USAGE
A plugin can be displayed in your website with the showPlugins('contactForm',$pageId) method from the Feindura class (when the this plugin is activated in that page). See http://feindura.org/api/[Implementation]/Feindura.html#showPlugins for more.

### STYLING
This plugin will be wraped with a <div class="feinduraPlugins feinduraPlugin_slideShowFromFolder" id="feinduraPlugin_slideShowFromFolder_<currentPageID>"> to make it easy to style. 

### ADDITIONAL
You can also add image captions by placing a "texts.txt" or "captions.txt" in the folder where the images are, with the following format:
filename1.jpg###image text
filename2.png###another image text
...

The imageGallery class can also be used without feindura as a slideShowFromFolder in your websites!


### USES
NivooSlider http://www.johannes-fischer.de/labs/nivoo-slider/
MooTools http://mootools.net/ (Attention!! could have conflicts with other frameworks, used by your website!!)