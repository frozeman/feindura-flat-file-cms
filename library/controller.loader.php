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
*/
// controller.loader.php version 0.2

/**
 * Includes the login.include.php and backend.include.php and filter the basic data
 */
require_once(dirname(__FILE__)."/includes/secure.include.php");


// SHARED CONTROLLERs
// -------------------------------------------------------------------------------------------------------------
// ->> CHANGE PAGE STATUS
if(isset($_GET['status']) && $_GET['status'] == 'changePageStatus') {

    if($contentArray = GeneralFunctions::readPage($_GET['page'],$_GET['category'])) {
      // change the status
      $contentArray['public'] = ($_GET['public']) ? false : true;

      // save the new status
      if(GeneralFunctions::savePage($contentArray)) {
        $DOCUMENTSAVED = true;
        $NOTIFICATION .= '<div class="alert alert-success">'.$langFile['MESSAGE_TEXT_CHANGEDSTATUS'].'</div>';

        // ->> save the FEEDS, if activated
        saveFeeds($_GET['category']);
        // ->> save the SITEMAP
        saveSitemap();

      } else
        $ERRORWINDOW .= sprintf($langFile['SORTABLEPAGELIST_changeStatusPage_error_save'],$adminConfig['basePath']);

    } else
      $ERRORWINDOW .= sprintf($langFile['file_error_read'],$adminConfig['basePath']);

  // shows the category open, after saving
  $openCategory = $_GET['category'];
}



// when PAGE ID is given, it loads EDITOR CONTROLLER
// --------------------------------------------
if(empty($_GET['site']) && ($_GET['category'] == 0 || !empty($_GET['category'])) && !empty($_GET['page'])) {

  // set the category 0 if there are no categories in the categoriesSettings.php
  if(empty($categoryConfig))
    $_GET['category'] = 0;

  include_once(dirname(__FILE__).'/controllers/editor.controller.php'); // isBlocked() is inside editor.controller.php


// OTHERWISE, load the controllers
// -------------------------------------------------------------------------------------------------------------
} else {

  // SWITCHES the &_GET['site'] var
  switch($_GET['site']) {
    // PAGES
    case 'pages':
      if(empty($categoryConfig))
        $_GET['category'] = 0;
      include (dirname(__FILE__).'/controllers/listPages.controller.php');
      break;
    // WEBSITE SETUP
    case 'websiteSetup':
      if(isBlocked()) break;
      include (dirname(__FILE__).'/controllers/websiteSetup.controller.php');
      break;
    // ADMIN SETUP
    case 'adminSetup':
      if(isBlocked()) break;
      if(GeneralFunctions::isAdmin()) include (dirname(__FILE__).'/controllers/adminSetup.controller.php');
      break;
    // PAGE SETUP
    case 'pageSetup':
      if(isBlocked()) break;
      if(GeneralFunctions::isAdmin()) include (dirname(__FILE__).'/controllers/pageSetup.controller.php');
      break;
    // STATISTIC SETUP
    case 'statisticSetup':
      if(isBlocked()) break;
      if(GeneralFunctions::isAdmin()) include (dirname(__FILE__).'/controllers/statisticSetup.controller.php');
      break;
    // USER SETUP
    case 'userSetup':
      if(isBlocked()) break;
      include (dirname(__FILE__).'/controllers/userSetup.controller.php');
      break;
    // MODUL SETUP
    case 'modulSetup':
      if(isBlocked()) break;
      if(GeneralFunctions::isAdmin()) include (dirname(__FILE__).'/controllers/modulSetup.controller.php');
      break;
    // BACKUP
    case 'backup':
      if(GeneralFunctions::isAdmin()) include (dirname(__FILE__).'/controllers/backup.controller.php');
      break;
    // ADDONS
    case 'addons':
      include (dirname(__FILE__).'/controllers/addons.controller.php');
      break;
  } //switch END

}

// -> CLEAR CACHE ON SAVING
if($DOCUMENTSAVED == true)
  GeneralFunctions::deleteFolder(dirname(__FILE__).'/../pages/cache/');

?>