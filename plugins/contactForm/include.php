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
/*
* Plugin include
* 
* Generates the plugin with the <var>$pluginConfig</var> array,
* which comes from the <var>$pageContent</var> array in the {@link feindura::showPlugins()} method
* and therefor also available in this file.
* 
* The following variables are available in this script when it gets include by the {@link feindura::showPlugins()} method:
*     - $pluginConfig -> contains the changed settings from the "config.php" from this plugin
*     - $pluginName -> the folder name of this plugin
*     - and all other variables which are available in the {@link feindura::feindura()} class
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
* @author Fabian Vogelsteller <fabian@feindura.org>
* @copyright Fabian Vogelsteller
* @license http://www.gnu.org/licenses GNU General Public License version 3
* 
*/
/**
 * The inlcude file for the contactForm plugin
 * 
 * @package [Plugins]
 * @subpackage contactForm
 */ 

// load the contactForm class
require('contactForm.php');

// create an instance of the imageGallery class
$contactForm = new contactForm($pluginConfig['recipient']);

// set configs
$contactForm->xHtml = $this->xHtml; // set the xHtml property from the feindura class
$contactForm->websiteTitle = $this->websiteConfig['title'];
$contactForm->websiteUrl = $this->adminConfig['url'];
$contactForm->config = $pluginConfig;
// include the $pluginLangFile
if($pluginLangFile = @include('lang/'.$this->language.'.php'))
  $contactForm->langFile = $pluginLangFile;

$plugin = $contactForm->showContactForm();

// RETURN the plugin
// *****************
return $plugin;

?>