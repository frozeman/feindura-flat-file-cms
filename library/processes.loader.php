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
// processes.loader.php version 0.1

/**
 * Includes the login.include.php and backend.include.php and filter the basic data
 */
require_once(dirname(__FILE__)."/includes/secure.include.php");

// when page ID is given, it loads the HTML-Editor
// --------------------------------------------
if(empty($_GET['site']) && ($_GET['category'] == 0 || !empty($_GET['category'])) && !empty($_GET['page'])) {
  
  // set the category 0 if there are no categories in the categoriesSettings.php
  if(empty($categoryConfig))
    $_GET['category'] = 0;
  
  include (dirname(__FILE__).'/controllers/editor.controller.php'); // isBlocked() is inside editor.controller.php
  
// OTHER BUTTONSwise, load the sites
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
      if(isAdmin()) include (dirname(__FILE__).'/controllers/adminSetup.controller.php');
      break;
    // PAGE SETUP
    case 'pageSetup':
      if(isBlocked()) break;
      if(isAdmin()) include (dirname(__FILE__).'/controllers/pageSetup.controller.php');
      break;
    // STATISTIC SETUP
    case 'statisticSetup':
      if(isBlocked()) break;
      if(isAdmin()) include (dirname(__FILE__).'/controllers/statisticSetup.controller.php');
      break;
    // USER SETUP
    case 'userSetup':
      if(isBlocked()) break;
      include (dirname(__FILE__).'/controllers/userSetup.controller.php');
      break;
    // PLUGIN SETUP
    case 'pluginSetup':
      if(isBlocked()) break;
      if(isAdmin()) include (dirname(__FILE__).'/controllers/pluginSetup.controller.php');
      break;
    // MODUL SETUP
    case 'modulSetup':
      if(isBlocked()) break;
      if(isAdmin()) include (dirname(__FILE__).'/controllers/modulSetup.controller.php');
      break;
    // BACKUP
    case 'backup':
      if(isAdmin()) include (dirname(__FILE__).'/controllers/backup.controller.php');
      break;
  } //switch END

}

?>