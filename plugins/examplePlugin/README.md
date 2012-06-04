feindura - Flat File Content Management System
==============================================
example plugin
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
This plugin shows you how you can create your own plugins.
A plugin is piece of extra code which can be add to each page in the backend.
It consist of basically 3 files:

- config.php          <- here you can set configs for your plugin, which the user can then edit in any page (the category must have this plugin activated)
- languages/en.php    <- this are the language files for the settings of your plugin, these will be shown in the plugin config of each page (backend)
- plugin.php          <- this is the actual plugin, here comes your plugin code and you can access the plugin configs (changed by the user for each page)

basically you need only the "plugin.php", but the config gives you the ability to let your users set some settings for each page where the plugin is activated. These changed settings can then change your plugin behavior.
The language files are necessary, so that you can give names to your settings.

Take a look in each of the example files to see how they are written.

If you made a plugin and you want to share it, let me know -> fabian@feindura.org

To displa

### USAGE
A plugin can be displayed in your website with the showPlugins('contactForm',$pageId) method from the Feindura class (when the this plugin is activated in that page). See http://feindura.org/api/[Implementation]/Feindura.html#showPlugins for more.

### STYLING
Every plugin will be wraped with a <div class="feinduraPlugins feinduraPlugin_<pluginName>" id="feinduraPlugin_<pluginName>_<currentPageID>"> to make it easy to style. 

### USES
Nothing but PHP