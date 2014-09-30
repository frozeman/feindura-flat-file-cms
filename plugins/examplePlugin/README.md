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

### AUTHOR
Fabian Vogelsteller <http://feindura.org>


### DESCRIPTION
This plugin shows you how you can create your own plugins.
A plugin is piece of code which can be add to each page.

It basically consist of 4 files:

- config.php          <- here you can set configs for your plugin, which the user can then edit in any page (the category must have this plugin activated)
- languages/en.php    <- this are the language files for the settings of your plugin, these will be used when you edit a plugin in the backend (The default fallback language is english, so an "en.php" should at least exist)
- plugin.php          <- here comes your plugin code and you here you can access the plugin configs (changed by the user for each page) through the $pluginConfig variable
- credits.yml        <- this file contains the authors name and website

basically you need only the "plugin.php", but the config gives you the ability to let your users set some settings for each page where the plugin is inserted. These changed settings can then change your plugins behavior.
The language files are necessary, so that you can give names to your settings.

If you have stylesheets files inside your plugins folder (or subfolders), then they will be automatically add to the pages <head>.

Take a look in each of the example files to see how they are written.

If you made a plugin and you want to share it, let me know -> fabian@feindura.org


### USAGE
A plugin can be displayed in your website by dragged it directly into the page in the Editor, or using the showPlugins('examplePlugin',$pageId); method from the Feindura class (when this plugin is activated in that page). See http://feindura.org/api/[Implementation]/Feindura.html#showPlugins for more.


### STYLING
Every plugin will be wraped with a <div class="feinduraPlugins feinduraPlugin_<pluginName>" id="feinduraPlugin_<pluginName>_<currentPageID>"> to make it easy to style.


### AVAILABLE VARS
See the plugin.php for more.


### JAVASCRIPT
If you need to add javascript or an library like mootools in your plugin, add the code to your plugin.php like this:

echo '<script type="text/javascript">
/* <![CDATA[ */

  // Add mootools if it is not already loaded
  if(!window.MooTools) {
    document.write(unescape(\'<script src="'.$feinduraBaseURL.'library/thirdparty/javascripts/mootools-core-1.4.5.js"><\/script>\'));
    document.write(unescape(\'<script src="'.$feinduraBaseURL.'library/thirdparty/javascripts/mootools-more-1.4.0.1.js"><\/script>\'));
  }

  // Add another script from inside the plugin folder (e.g. MilkBox)
  (window.MilkBox || document.write(unescape(\'<script src="'.$pluginBaseURL.'milkbox/milkbox.js"><\/script>\')));


  // add some custom js code
  var test = "my string";
  ...

/* ]]> */
</script>';
