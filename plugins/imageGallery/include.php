<?php
/* imageGallery plugin */
/*
 * feindura - Flat File Content Management System
 * Copyright (C) Fabian Vogelsteller [frozeman.de]
 *
 * This program is free software;
 * you can redistribute it and/or modify it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY;
 * without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 * See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with this program;
 * if not,see <http://www.gnu.org/licenses/>.
 */
/** 
 * The include file for the imageGallery plugin  
 * 
 * See the README.md for more.
 * 
 * The following variables are available in this script when it gets included by the {@link Feindura::showPlugins()} method:
 *     - $pluginConfig -> contains the changed settings from the "config.php" from this plugin
 *     - $pluginName -> the folder name of this plugin
 *     - $pageContent -> the pageContent array of the page which has this plugin activated 
 *     - and all other variables which are available in the {@link feindura} class (use "$this->..")
 * 
 * This file MUST RETURN the plugin ready to display in a HTML-page
 * 
 * For Example
 * <code>
 * $plugin = '<p>Plugin HTML</p>';
 * 
 * return $plugin;
 * </code>
 * 
 * @package [Plugins]
 * @subpackage imageGallery
 * 
 * @author Fabian Vogelsteller <fabian@feindura.org>
 * @copyright Fabian Vogelsteller
 * @license http://www.gnu.org/licenses GNU General Public License version 3
 * 
 */

// vars
$filePath = str_replace('\\','/',dirname(__FILE__)); // replace this on windows servers
$filePath = str_replace(DOCUMENTROOT,'',$filePath);
$plugin = '';

// ->> add MooTools and MilkBox
echo '<script type="text/javascript">
  /* <![CDATA[ */
  // add mootools if user is not logged into backend
  if(!window.MooTools) {
    document.write(unescape(\'%3Cscript src="'.$this->adminConfig['basePath'].'library/thirdparty/javascripts/mootools-core-1.3.2.js"%3E%3C/script%3E\'));
    document.write(unescape(\'%3Cscript src="'.$this->adminConfig['basePath'].'library/thirdparty/javascripts/mootools-more-1.3.2.1.js"%3E%3C/script%3E\'));
  }
  // add milkbox
  document.write(unescape(\'%3Cscript src="'.$filePath.'/milkbox/milkbox.js"%3E%3C/script%3E\')); 
  /* ]]> */
</script>';

// load the imageGallery class
require_once('imageGallery.php');

// create an instance of the imageGallery class
$gallery = new imageGallery($pluginConfig['galleryPath'],DOCUMENTROOT);

// set configs
$gallery->xHtml = $this->xHtml; // set the xHtml property rom the feindura class
$gallery->imageWidth = $pluginConfig['imageWidth'];
$gallery->imageHeight = $pluginConfig['imageHeight'];
$gallery->thumbnailWidth = $pluginConfig['thumbnailWidth'];
$gallery->thumbnailHeight = $pluginConfig['thumbnailHeight'];
$gallery->filenameCaptions = $pluginConfig['filenameCaptions'];

$plugin .= $gallery->showGallery($pluginConfig['tag'],$pluginConfig['breakAfter'],$pageContent);

// RETURN the plugin
// *****************
return $plugin;

?>