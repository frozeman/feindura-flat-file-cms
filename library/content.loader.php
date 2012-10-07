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
// content.loader.php version 0.5

// ***********************************************************************
// CHECKs if the DOCUMENTROOT could be resolved succesfully
// if not throw an warning
echo documentrootWarning();

// ***********************************************************************
// CHECKs if the current basePath is matching the url basePath
// if not throw an warning
if($_GET['site'] != 'adminSetup')
  echo basePathWarning();

checkPagesMetaData();

// ***********************************************************************
// CHECKs if the necessary FILEs are WRITEABLE, otherwise show an warnings
if($_GET['site'] != 'pages' && empty($_GET['page']) && checkBasePathAndURL()) {
  if($writeableWarning = basicFilesAreWriteableWarning())
    echo $writeableWarning.'<div class="blockSpacer"></div>';

  unset($writeableWarning);
}

// ***********************************************************************
// CHECKs if a STARTPAGE is SET and if this page exists
// if not throw a warning
echo startPageWarning();

// ***********************************************************************
// CHECKs if the CATEGORY CONFIG or the WEBSITE CONFIG has missing languages
if($_GET['site'] != 'websiteSetup' && $_GET['site'] != 'pageSetup')
echo missingLanguageWarning();

// start of loading the content
// -------------------------------------------------------------------------------------------------------------

// if page ID is given, it loads the HTML-Editor
// --------------------------------------------
if(empty($_GET['site']) && ($_GET['category'] == 0 || !empty($_GET['category'])) && !empty($_GET['page'])) {

  // set the category 0 if there are no categories in the categoriesSettings.php
  if(empty($categoryConfig))
    $_GET['category'] = 0;

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
    // PAGE THUMBNAIL UPLOAD
    case 'uploadPageThumbnail':
      include (dirname(__FILE__).'/views/windowBox/uploadPageThumbnail.php');
      break;
    // PAGE THUMBNAIL DELETE
    case 'deletePageThumbnail':
      include (dirname(__FILE__).'/views/windowBox/deletePageThumbnail.php');
      break;
    // ADD PAGE LANGUAGE
    case 'addPageLanguage':
      include (dirname(__FILE__).'/views/windowBox/addPageLanguage.php');
      break;
    // REMOVE PAGE LANGUAGE
    case 'deletePageLanguage':
      include (dirname(__FILE__).'/views/windowBox/deletePageLanguage.php');
      break;
    // EDIT LINK
    case 'editLink':
      include (dirname(__FILE__).'/views/windowBox/editLink.php');
      break;
    // USER PERMISSIONS
    case 'userPermissions':
      include (dirname(__FILE__).'/views/windowBox/userPermissions.php');
      break;
    // WEBSITE SETUP
    case 'websiteSetup':
      include (dirname(__FILE__).'/views/websiteSetup.php');
      break;
    // ADMIN SETUP
    case 'adminSetup':
      if(GeneralFunctions::isAdmin()) include (dirname(__FILE__).'/views/adminSetup.php');
      break;
    // PAGE SETUP
    case 'pageSetup':
      if(GeneralFunctions::isAdmin()) include (dirname(__FILE__).'/views/pageSetup.php');
      break;
    // STATISTIC SETUP
    case 'statisticSetup':
      if(GeneralFunctions::isAdmin()) include (dirname(__FILE__).'/views/statisticSetup.php');
      break;
    // USER SETUP
    case 'userSetup':
      if(GeneralFunctions::isAdmin()) include (dirname(__FILE__).'/views/userSetup.php');
      break;
    // MODUL SETUP
    case 'modulSetup':
      if(GeneralFunctions::isAdmin()) include (dirname(__FILE__).'/views/modulSetup.php');
      break;
    // BACKUP
    case 'backup':
      if(GeneralFunctions::isAdmin()) include (dirname(__FILE__).'/views/backup.php');
      break;
    // ADDONS
    case 'addons':
      if(empty($_GET['addon']))
        include (dirname(__FILE__).'/views/addons.php');
      else
        include (dirname(__FILE__).'/../addons/'.$_GET['addon'].'/addon.php');
      break;
  } //switch END

}

?>