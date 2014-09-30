<?php
/*  feindura - Flat File Content Management System
    Copyright (C) Fabian Vogelsteller [frozeman.de]

    This program is free software;
    you can redistribute it and/or modify it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 3 of the License, or (at your option) any later version.

    This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY;
    without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
    See the GNU General Public License for more details.

    You should have received a copy of the GNU General Public License along with this program;
    if not,see <http://www.gnu.org/licenses/>.

* controllers/listPages.controller.php version 0.86
*/

/**
 * Includes the login.include.php and backend.include.php and filter the basic data
 */
require_once(dirname(__FILE__)."/../includes/secure.include.php");

// VAR
$openCategory = false;

// ->> CHANGE MENU STATUS
if(isset($_GET['status']) && $_GET['status'] == 'changeMenuStatus') {

    if($contentArray = GeneralFunctions::readPage($_GET['page'],$_GET['category'])) {
      // change the status
      $contentArray['showInMenus'] = ($_GET['showInMenus']) ? false : true;

      // save the new status
      if(GeneralFunctions::savePage($contentArray)) {
        $DOCUMENTSAVED = true;
        $NOTIFICATION .= '<div class="alert alert-success">'.$langFile['MESSAGE_TEXT_CHANGEDSHOWINMENU'].'</div>';

      } else
        $ERRORWINDOW .= sprintf($langFile['EDITOR_savepage_error_save'],$adminConfig['basePath']);

    } else
      $ERRORWINDOW .= sprintf($langFile['file_error_read'],$adminConfig['basePath']);

  // shows the category open, after saving
  $openCategory = $_GET['category'];
}

// ->> CHANGE CATEGORY STATUS
if(isset($_GET['status']) &&
   $_GET['status'] == 'changeCategoryStatus' &&
   GeneralFunctions::hasPermission('editableCategories',$_GET['category'])) {

  // change the status
  $categoryConfig[$_GET['category']]['public'] = ($_GET['public']) ? false : true;

  // save the new status
  if(saveCategories($categoryConfig)) {
    $DOCUMENTSAVED = true;
    $NOTIFICATION .= '<div class="alert alert-success">'.$langFile['MESSAGE_TEXT_CHANGEDSTATUS'].'</div>';

    // ->> save the FEEDS, if activated
    GeneralFunctions::$categoryConfig = $categoryConfig;
    saveFeeds($_GET['category']);
    // ->> save the SITEMAP
    saveSitemap();

  } else
    $ERRORWINDOW .= sprintf($langFile['SORTABLEPAGELIST_changeStatusPage_error_save'],$adminConfig['basePath']);

 // shows after saving the category open
 $openCategory = $_GET['category'];
}

// ->> SET THE STARTPAGE
if(isset($_GET['status']) && $_GET['status'] == 'setStartPage' && !empty($_GET['page'])) {

  // sets the new startPage
  if( $websiteConfig['startPage'] == $_GET['page'])
      $websiteConfig['startPage'] = 0;
  else
    $websiteConfig['startPage'] = $_GET['page'];

  if(savewebsiteConfig($websiteConfig)) {
    // give documentSaved status
    $DOCUMENTSAVED = true;

  } else $ERRORWINDOW .= sprintf($langFile['SORTABLEPAGELIST_setStartPage_error_save'],$adminConfig['basePath']);


  // shows after saving the category open
 $openCategory = $_GET['category'];
}

?>