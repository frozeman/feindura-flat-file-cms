feindura - Flat File Content Management System
==============================================
contactForm plugin
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

### VERSION 1.0.1

### AUTHOR
Fabian Vogelsteller <http://frozeman.de>


### DESCRIPTION
This plugin creates an contactform to send an email, it uses also a simple captcha protection

### USAGE
A plugin can be displayed in your website with the showPlugins('contactForm',$pageId) method from the Feindura class (when the this plugin is activated in that page). See http://feindura.org/api/[Implementation]/Feindura.html#showPlugins for more.

### STYLING
This plugin will be wraped with a <div class="feinduraPlugins feinduraPlugin_contactForm" id="feinduraPlugin_contactForm_<currentPageID>"> to make it easy to style. 

### ADDITIONAL
The contactForm class can also be used without feindura in your websites!