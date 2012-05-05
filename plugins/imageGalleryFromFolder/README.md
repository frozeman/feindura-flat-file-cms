feindura - Flat File Content Management System
==============================================
imageGalleryFromFolder plugin
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

### VERSION 1.2

### AUTHOR
Fabian Vogelsteller <http://frozeman.de>


### DESCRIPTION
This plugin creates automatically an gallery from a folder containing images. On the first load of the plugin in the website,
the images will be resized to the size set in the plugin settings and thumbnails will be created.

NOTE
It will put the image thumbnails in <a..><img></a> tags,
but when both height and width for the thumbnail are set
it will only create a <a..></a> and set the image as style="background:url(..)",
to ensures that the image thumbnails have a fixed size.

### USAGE
The imageGalleryFromFolder plugin can be displayed in your website with the showPlugins('imageGalleryFromFolder',$pageId) method from the feindura class (when activated in the page with the $pageId).

### STYLING
To style the imageGalleryFromFolder with css use the ".feinduraPlugin_imageGalleryFromFolder" class.

### ADDITIONAL
You can also add image captions by placing a "texts.txt" or "captions.txt" in the folder where the images are, with the following format:
filename1.jpg###image text
filename2.png###another image text
...

The imageGalleryFromFolder class can also be used without feindura as a image gallery in your websites!


### USES
milkbox http://reghellin.com/milkbox/
MooTools http://mootools.net/ (Attention!! could have conflicts with other frameworks, used by your website!!)