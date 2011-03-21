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
// content.loader.php version 0.32

  
// ***********************************************************************
// CHECKs if the current basePath is matching the real basePath
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
  
  include (dirname(__FILE__).'/sites/editor.php');
  
// OTHER BUTTONSwise, load the sites
// -------------------------------------------------------------------------------------------------------------
} else {
  
  // SWITCHES the &_GET['site'] var
  switch($_GET['site']) {
    // dashboard
    case 'dashboard': case '':
      include (dirname(__FILE__).'/sites/dashboard.php');
      break;
    // pages
    case 'pages':
      if(empty($categoryConfig))
        $_GET['category'] = 0;
      include (dirname(__FILE__).'/sites/listPages.php');
      break;
    // adminSetup
    case 'adminSetup':
      include (dirname(__FILE__).'/sites/adminSetup.php');
      break;
    // adminSetup
    case 'pageSetup':
      include (dirname(__FILE__).'/sites/pageSetup.php');
      break;
    // websiteSetup
    case 'websiteSetup':
      include (dirname(__FILE__).'/sites/websiteSetup.php');
      break;
    // statisticSetup
    case 'statisticSetup':
      include (dirname(__FILE__).'/sites/statisticSetup.php');
      break;
    // backup
    case 'backup':
      include (dirname(__FILE__).'/sites/backup.php');
      break;
    // userSetup
    case 'userSetup':
      include (dirname(__FILE__).'/sites/userSetup.php');
      break;
    // pluginSetup
    case 'pluginSetup':
      include (dirname(__FILE__).'/sites/pluginSetup.php');
      break;
    // modulSetup
    case 'modulSetup':
      include (dirname(__FILE__).'/sites/modulSetup.php');
      break;
    // search
    case 'search':
      include (dirname(__FILE__).'/sites/search.php');
      break;
    // fileManager
    case 'fileManager':
      include (dirname(__FILE__).'/sites/windowBox/fileManager.php');
      break; 
    // deletePage
    case 'deletePage':
      include (dirname(__FILE__).'/sites/windowBox/deletePage.php');
      break;
    // pageThumbnailUpload
    case 'pageThumbnailUpload':
      include (dirname(__FILE__).'/sites/windowBox/pageThumbnailUpload.php');
      break;
    // pageThumbnailDelete
    case 'pageThumbnailDelete':
      include (dirname(__FILE__).'/sites/windowBox/pageThumbnailDelete.php');
      break;
  } //switch END

}

?>