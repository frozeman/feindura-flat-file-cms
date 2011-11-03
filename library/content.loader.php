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
// content.loader.php version 0.4


// ***********************************************************************
// CHECKs if the DOCUMENTROOT could be resolved succesfully
// if not throw an warning
echo documentrootWarning();

// ***********************************************************************
// CHECKs if the current basePath is matching the url basePath
// if not throw an warning
if($_GET['site'] != 'adminSetup')
  echo basePathWarning();

// ***********************************************************************
// CHECKs if a STARTPAGE is SET and if this page exists
// if not throw a warning
echo startPageWarning();

// start of loading the content
// -------------------------------------------------------------------------------------------------------------

// if page ID is given, it loads the HTML-Editor
// --------------------------------------------
if(empty($_GET['site']) && ($_GET['category'] == 0 || !empty($_GET['category'])) && !empty($_GET['page'])) {

  // set the category 0 if there are no categories in the categoriesSettings.php
  if(empty($categoryConfig))
    $_GET['category'] = 0;
  
  echo isBlocked();
  include (dirname(__FILE__).'/views/editor.php');
  
// otherwise, load the sites
// -------------------------------------------------------------------------------------------------------------
} else {
  
  // SWITCHES the &_GET['site'] var
  switch($_GET['site']) {
    // DASHBOARD
    case 'dashboard': case '':
      include (dirname(__FILE__).'/views/dashboard.php');
      break;
    // PAGES
    case 'pages':
      if(empty($categoryConfig))
        $_GET['category'] = 0;
      include (dirname(__FILE__).'/views/listPages.php');
      break;
    // SEARCH
    case 'search':
      include (dirname(__FILE__).'/views/search.php');
      break;
    // FILEMANAGER
    case 'fileManager':
      include (dirname(__FILE__).'/views/windowBox/fileManager.php');
      break; 
    // DELETPAGE
    case 'deletePage':
      include (dirname(__FILE__).'/views/windowBox/deletePage.php');
      break;
    // PGAETHUMBNAIL UPLOAD
    case 'pageThumbnailUpload':
      include (dirname(__FILE__).'/views/windowBox/pageThumbnailUpload.php');
      break;
    // PGAETHUMBNAIL DELETE
    case 'pageThumbnailDelete':
      include (dirname(__FILE__).'/views/windowBox/pageThumbnailDelete.php');
      break;
    // WEBSITE SETUP
    case 'websiteSetup':
      echo isBlocked();
      include (dirname(__FILE__).'/views/websiteSetup.php');
      break;
    // ADMIN SETUP
    case 'adminSetup':
      echo isBlocked();
      if(isAdmin()) include (dirname(__FILE__).'/views/adminSetup.php');
      break;
    // PAGE SETUP
    case 'pageSetup':
      echo isBlocked();
      if(isAdmin()) include (dirname(__FILE__).'/views/pageSetup.php');
      break;
    // STATISTIC SETUP
    case 'statisticSetup':
      echo isBlocked();
      if(isAdmin()) include (dirname(__FILE__).'/views/statisticSetup.php');
      break;
    // USER SETUP
    case 'userSetup':
      echo isBlocked();
      if(isAdmin()) include (dirname(__FILE__).'/views/userSetup.php');
      break;
    // MODUL SETUP
    case 'modulSetup':
      echo isBlocked();
      if(isAdmin()) include (dirname(__FILE__).'/views/modulSetup.php');
      break;
    // BACKUP
    case 'backup':
      if(isAdmin()) include (dirname(__FILE__).'/views/backup.php');
      break;
  } //switch END

}

?>