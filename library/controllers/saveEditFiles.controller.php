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

* saveEditFiles.controller.php version 0.1
*/

/**
 * Includes the login.include.php and backend.include.php and filter the basic data
 */
require_once(dirname(__FILE__)."/../includes/secure.include.php");

// ->> SAVE the editFiles
if(isset($_POST['send']) && $_POST['send'] == 'saveEditedFiles') {

  //var
  $file = (!empty($_POST['newFile'])) ? $_POST['newFile'].$_POST['fileType'] : $_POST['file'];

  if(saveEditedFiles($SAVEDFORM)) {
    $DOCUMENTSAVED = true; // give documentSaved status
    // -> tasklog is saved in the saveEditFiles() function
  } else {
    $ERRORWINDOW .= $langFile['EDITFILESSETTINGS_ERROR_SAVEFILE'].' '.$file;
  }
}

// ->> DELETE editFiles File
if($_GET['status'] == 'deleteEditFiles' && !empty($_GET['file'])) {

  // -> will be deleted in the editFiles() function

  $SAVEDFORM = $_GET['editFilesStatus'];
}

?>