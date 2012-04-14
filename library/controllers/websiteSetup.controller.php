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

* controllers/websiteSetup.controller.php version 1.9
*/

/**
 * Includes the login.include.php and backend.include.php and filter the basic data
 */
require_once(dirname(__FILE__)."/../includes/secure.include.php");

// ------------ SAVE the WEBSITE SETTINGS
if(isset($_POST['send']) && $_POST['send'] ==  'websiteSetup') {

    // gets the startPage var and put it in the POST var
    $_POST['startPage']    = $websiteConfig['startPage'];
    $_POST['localized'] = $websiteConfig['localized'];

    // STORE LOCALIZED CONTENT
    $_POST['localized'][$_POST['websiteLanguage']]['title']       = $_POST['title'];
    $_POST['localized'][$_POST['websiteLanguage']]['publisher']   = $_POST['publisher'];
    $_POST['localized'][$_POST['websiteLanguage']]['copyright']   = $_POST['websiteConfig_copyright'];
    $_POST['keywords']                                               = str_replace(";", ',', $_POST['keywords']);
    $_POST['localized'][$_POST['websiteLanguage']]['keywords']    = preg_replace("# +#", ' ', $_POST['keywords']);
    $_POST['localized'][$_POST['websiteLanguage']]['description'] = $_POST['description'];
    
    // delete unnecessary variables
    unset($_POST['title'],$_POST['publisher'],$_POST['websiteConfig_copyright'],$_POST['keywords'],$_POST['description']);

    if(saveWebsiteConfig($_POST)) {
      // give documentSaved status
      $documentSaved = true;
      saveActivityLog(7); // <- SAVE the task in a LOG FILE
    } else
    $errorWindow .= sprintf($langFile['websiteSetup_websiteConfig_error_save'],$adminConfig['realBasePath']);
  
  $savedForm = 'websiteConfig';
  $savedSettings = true;
}

// ---------- SAVE the editFiles
include_once(dirname(__FILE__).'/../controllers/saveEditFiles.controller.php');

// RE-INCLUDE
if($savedSettings) {
  unset($websiteConfig);
  $websiteConfig = @include (dirname(__FILE__)."/../../config/website.config.php");
}
?>