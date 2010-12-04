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

* processes/websiteSetup.process.php version 1.9
*/

/**
 * Includes the login and filters the incoming data by xssFilter
 */
require_once(dirname(__FILE__)."/../includes/secure.include.php");

// ------------ SAVE the WEBSITE SETTINGS
if(isset($_POST['send']) && $_POST['send'] ==  'websiteSetup') {

    // gets the startPage var and put it in the POST var
    $_POST['startPage'] = $websiteConfig['startPage'];
    
    $_POST['copyright'] = $_POST['websiteConfig_copyright'];
    if(saveWebsiteConfig($_POST)) {
      // give documentSaved status
      $documentSaved = true;
      statisticFunctions::saveTaskLog(7); // <- SAVE the task in a LOG FILE
    } else
    $errorWindow .= $langFile['websiteSetup_websiteConfig_error_save'];
  
  $savedForm = 'websiteConfig';
}

// ---------- SAVE the editFiles
include_once(dirname(__FILE__).'/../processes/saveEditFiles.process.php');

// RE-INCLUDE
$websiteConfig = @include (dirname(__FILE__)."/../../config/website.config.php");

?>