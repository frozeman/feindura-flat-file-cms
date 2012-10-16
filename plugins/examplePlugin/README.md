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


### USAGE
A plugin can be displayed in your website with the showPlugins('contactForm',$pageId) method from the Feindura class (when the this plugin is activated in that page). See http://feindura.org/api/[Implementation]/Feindura.html#showPlugins for more.

### STYLING
Every plugin will be wraped with a <div class="feinduraPlugins feinduraPlugin_<pluginName>" id="feinduraPlugin_<pluginName>_<currentPageID>"> to make it easy to style. 

### AVAILABLE VARS
In the plugin.php you have the following vars available:

 - $feindura                  -> the current Feindura class instance with all its methods (use "$feindura->..")
 - $feinduraBaseURL           -> the base url of the feindura folder, e.g. "http://mysite.com/cms/"
 - $feinduraBasePath          -> the base path of the feindura folder, e.g. "/cms/". Be aware that this is a file system path and could differ from an URI path.
 - $pluginBaseURL             -> the base url of this plugins folder, e.g. "http://mysite.com/cms/plugins/examplePlugin/"
 - $pluginBasePath            -> the base path of this plugins folder, e.g. "/cms/plugins/examplePlugin/". Be aware that this is a file system path and could differ from an URI path.
 - $pluginConfig              -> contains the changed settings from the "config.php" from this plugin
 - $pluginName                -> the folder name of this plugin
 - $pageContent               -> the pageContent array of the page which contains this plugin
 - the GeneralFunctions class -> for advanced methods. It's a static class so use "GeneralFunctions::exampleMethod(..);"
 

### USES
Nothing but PHP