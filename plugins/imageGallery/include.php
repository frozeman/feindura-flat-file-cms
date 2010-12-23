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
 * The include file for the contactForm plugin  
 * 
 * Generates the plugin with the <var>$pluginConfig</var> array,
 * which is the config Array from this plugin, saved in the respective page and comes from the <var>$pageContent</var> array.
 * Included in the {@link feindura::showPlugins()} method and is therefor available in this file, because this file will be included in the {@link feindura::showPlugins()}.
 * 
 * The following variables are available in this script when it gets include by the {@link feindura::showPlugins()} method:
 *     - $pluginConfig -> contains the changed settings from the "config.php" from this plugin
 *     - $pluginName -> the folder name of this plugin
 *     - and all other variables which are available in the {@link feindura::__construct()} class
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

// var
$filePath = str_replace('\\','/',dirname(__FILE__)); // replace this on windows servers
$filePath = str_replace($_SERVER["DOCUMENT_ROOT"],'',$filePath);
$plugin = '';

$plugin .= '<script type="text/javascript" src="'.$filePath.'/js/jquery-1.4.2.min.js"></script>
  <script type="text/javascript" src="'.$filePath.'/slimBox2/js/slimbox2.js"></script>'."\n";

// load the imageGallery class
require_once('imageGallery.php');

// create an instance of the imageGallery class
$gallery = new imageGallery($pluginConfig['galleryPath']);

// set configs
$gallery->xHtml = $this->xHtml; // set the xHtml property rom the feindura class
$gallery->imageWidth = $pluginConfig['imageWidth'];
$gallery->imageHeight = $pluginConfig['imageHeight'];
$gallery->thumbnailWidth = $pluginConfig['thumbnailWidth'];
$gallery->thumbnailHeight = $pluginConfig['thumbnailHeight'];

$plugin .= $gallery->showGallery($pluginConfig['tag'],$pluginConfig['breakAfter'],$pageContent);

// RETURN the plugin
// *****************
return $plugin;

?>