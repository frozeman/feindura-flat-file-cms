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

* processes/pluginSetup.process.php version 0.1
*/

/**
 * Includes the login and filters the incoming data by xssFilter
 */
require_once(dirname(__FILE__)."/../includes/secure.include.php");

// ---------------------------------------------------------------------------------------------------
// ****** ---------- SAVE PLUGIN CONFIG in config/admin.config.php
if(isset($_POST['send']) && $_POST['send'] ==  'pluginsConfig') {
  
  // prepare vars
  $pluginsConfig[$_POST['savedBlock']]['active'] = $_POST['plugin'][$_POST['savedBlock']]['active'];
  
  // **** opens admin.config.php for writing
  if(savePluginsConfig($pluginsConfig)) {
     
    // give documentSaved status
    $documentSaved = true;
    statisticFunctions::saveTaskLog(11,$_POST['savedBlock']); // <- SAVE the task in a LOG FILE
    
  } else
    $errorWindow .= $langFile['pluginSetup_pluginconfig_error_save'].' '.$adminConfig['basePath'].'config/plugin.config.php';
  
  $savedForm = $_POST['savedBlock'];
}

// ---------- SAVE the editFiles
include(dirname(__FILE__).'/../processes/saveEditFiles.process.php');

// RE-INCLUDE
$pluginsConfig = @include(dirname(__FILE__)."/../../config/plugins.config.php");

?>