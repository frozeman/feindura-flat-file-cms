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
    
* controllers/frontendEditing.controller.php version 0.1
*/

$frontendEditing = true; // to prevent that the backend.include.php will be included inside the secure.include.php
/**
 * Includes the login.include.php and backend.include.php and filter the basic data
 */
require_once(dirname(__FILE__)."/../includes/secure.include.php");

// SAVE the PAGE
// -----------------------------------------------------------------------------
if($_POST['save'] == 'true') {
  
  // var
  $return = '';
  $tmpReturn = '';
  
  // read the page
  $pageContent = GeneralFunctions::readPage($_POST['page'],$_POST['category']);

  // -> replace the existing data with the new one
  if(is_array($pageContent['localized'])) {
    $pageContent['localized'][$_POST['language']]['title'] = ($_POST['type'] == 'title') ? $_POST['data'] : $pageContent['localized'][$_POST['language']]['title'];
    $pageContent['localized'][$_POST['language']]['content'] = ($_POST['type'] == 'content') ? $_POST['data'] : $pageContent['localized'][$_POST['language']]['content'];
    $tmpReturn = ($_POST['type'] == 'title') ? $pageContent['localized'][$_POST['language']]['title'] : $tmpReturn;
    $tmpReturn = ($_POST['type'] == 'content') ? $pageContent['localized'][$_POST['language']]['content'] : $tmpReturn;
  // legacy fallback
  } else {
    $pageContent['title'] = ($_POST['type'] == 'title') ? $_POST['data'] : $pageContent['title'];
    $pageContent['content'] = ($_POST['type'] == 'content') ? $_POST['data'] : $pageContent['content'];
    $tmpReturn = ($_POST['type'] == 'title') ? $pageContent['title'] : $tmpReturn;
    $tmpReturn = ($_POST['type'] == 'content') ? $pageContent['content'] : $tmpReturn;
  }

  // ->> save the page
  if(GeneralFunctions::savePage($pageContent)) {
    StatisticFunctions::saveTaskLog(1,'page='.$_POST['page']); // <- SAVE the task in a LOG FILE

    // -> the data which will be returned, to inject into the element in the frontend
    $return = $tmpReturn;
    $return = str_replace("\'", "'", $return);
    $return = str_replace('\"', '"', $return);
    
    // ->> save the FEEDS, if activated
    GeneralFunctions::saveFeeds($pageContent['category']);
    // ->> save the SITEMAP
    GeneralFunctions::saveSitemap();
    
  // ->> on failure, return the unsaved data
  } else {
    $return = '####SAVING-ERROR####';
  }
  echo $return;
}

// ACTIVATE/DEACTIVATE frontend editing
// -----------------------------------------------------------------------------
if($_POST['deactivateFrontendEditing']) {
  if($_POST['deactivateFrontendEditing'] == 'true')
    $_SESSION['feinduraSession']['login']['deactivateFrontendEditing'] = true;
  if($_POST['deactivateFrontendEditing'] == 'false')
    unset($_SESSION['feinduraSession']['login']['deactivateFrontendEditing']);
}

?>