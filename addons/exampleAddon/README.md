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
This Add-on shows you how you can create your own one.
An Add-on is piece of code which can be run in the feindura backend to create extensions or even own applications using the feindura classes.

It basically consist of 3 files:

- languages/en.php       <- this are the language files which can acces in your Add-on through the $addonLangFile variable (The default fallback language is english, so an "en.php" should at least exist)
- addon.php              <- here comes your add-on code
- addon.controller.php   <- here comes your code to process your forms $_POST variable
- credits.yml            <- this file contains the authors name and website

If you have stylesheets files inside your add-on folder (or subfolders), then they will be automatically add to the <head>.

Take a look in each of the example files to see how they are written.

If you made an add-on and you want to share it, let me know -> fabian@feindura.org


### USAGE
An Add-on will automatically add to the list of Add-ons in the backend, as soon as you copy it into the "feindura/addons/" folder.


### STYLING
You can write your own style files and place them anywhere in your add-on folder (even subfolders). But its recommended that you use the standard feindura classes to fit the feindura backend design. To see what elements you can use take a look in the addon.php.
You also have all the classes from the Bootstrap CSS Framework available.


### AVAILABLE VARS
See the addon.php for more.


### JAVASCRIPT
Note that feindura uses the MooTools Framework, so you can use the MooTools functions.
For a complete list of all available MooTools More packages see the feindura/library/NOTES.md

If you want to add javascript add it like this on the end of your addon.php:

<!-- ADDON SCRIPTS -->
<script type="text/javascript">
/* <![CDATA[ */

  ...

/* ]]> */
</script>