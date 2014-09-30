<?php
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
 * The plugin file
 *
 * See the README.md for more.
 *
 * @package [Plugins]
 * @subpackage contactForm
 *
 * @author Fabian Vogelsteller <fabian@feindura.org>
 * @copyright Fabian Vogelsteller
 * @license http://www.gnu.org/licenses GNU General Public License version 3
 *
 */

// load the contactForm class
require_once('contactForm.php');

// create an instance of the imageGallery class
$contactForm = new contactForm($pluginConfig['recipient']);

// set configs
$contactForm->currentUrl = $feindura->createHref();
$contactForm->xHtml = $feindura->xHtml;
$contactForm->websiteTitle = $feindura->metaData['title'];
$contactForm->websiteUrl = $feindura->adminConfig['url'];
$contactForm->config = $pluginConfig;
// include the $pluginLangFile
$pluginCountryCode = (file_exists(dirname(__FILE__).'/languages/'.$feindura->language.'.php'))
	  ? $feindura->language
	  : 'en';
if($pluginLangFile = @include(dirname(__FILE__).'/languages/'.$pluginCountryCode.'.php'))
  $contactForm->langFile = $pluginLangFile;

// SHOW CONTACT FORM
echo $contactForm->showContactForm();


?>