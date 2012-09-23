<?php
/*
    feindura - Flat File Content Management System
    Copyright (C) Fabian Vogelsteller [frozeman.de]

    This program is free software;
    you can redistribute it and/or modify it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 3 of the License, or (at your option) any later version.

    This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY;
    without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
    See the GNU General Public License for more details.

    You should have received a copy of the GNU General Public License along with this program;
    if not,see <http://www.gnu.org/licenses/>.

* controllers/addons.controller.php version 0.1
*/

/**
 * Includes the login.include.php and backend.include.php and filter the basic data
 */
require_once(dirname(__FILE__)."/../includes/secure.include.php");


// LOAD ADDONS
$addons = GeneralFunctions::readFolder(dirname(__FILE__).'/../../addons/');
$newAddons = array();
if(is_array($addons['folders'])) {
  foreach($addons['folders'] as $addonFolder){

    $addonFolderName = basename($addonFolder);
    $addonCountryCode = (file_exists(dirname(__FILE__).'/../../addons/'.$addonFolderName.'/languages/'.$_SESSION['feinduraSession']['backendLanguage'].'.php'))
      ? $_SESSION['feinduraSession']['backendLanguage']
      : 'en';
    $addonCredits   = @file(dirname(__FILE__).'/../../addons/'.$addonFolderName.'/credits.yml');

    $newAddons[$addonFolderName]['name']         = $addonFolderName;
    $newAddons[$addonFolderName]['author']       = trim(str_replace('author:','',$addonCredits[1]));
    $newAddons[$addonFolderName]['website']      = trim(str_replace('website:','',$addonCredits[2]));
    $newAddons[$addonFolderName]['version']      = trim(str_replace('version:','',$addonCredits[3]));
    $newAddons[$addonFolderName]['requirements'] = trim(str_replace('requirements:','',$addonCredits[4]));

    $newAddons[$addonFolderName]['config']       = @include(dirname(__FILE__).'/../../addons/'.$addonFolderName.'/config.php');
    $newAddons[$addonFolderName]['langFile']     = @include(dirname(__FILE__).'/../../addons/'.$addonFolderName.'/languages/'.$addonCountryCode.'.php');
    $newAddons[$addonFolderName]['title']        = (isset($newAddons[$addonFolderName]['langFile']['feinduraAddon_title'])) ? $newAddons[$addonFolderName]['langFile']['feinduraAddon_title'] : $addonFolderName;
  }
}
$addons = $newAddons;
unset($newAddons,$addonCountryCode,$addonFolderName,$addonCredits);


// set the current ADDON LANGUAGEFILE
if($_GET['addon'])
  $addonLangFile = $addons[$_GET['addon']]['langFile'];


// LOAD the current ADDON CONTROLLER
if($_GET['addon'] && !isBlocked()) {
  @include(dirname(__FILE__).'/../../addons/'.$addons[$_GET['addon']]['name'].'/addon.controller.php');
}