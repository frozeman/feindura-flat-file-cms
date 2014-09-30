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

* controllers/editor.controller.php version 1.97
*/

/**
 * Includes the login.include.php and backend.include.php and filter the basic data
 */
require_once(dirname(__FILE__)."/../includes/secure.include.php");

// VARs
// -----------------------------------------------------------------------------
$page = $_GET['page'];
$category = $_GET['category'];

// REVERT to a PREVIOUS STATE
// -----------------------------------------------------------------------------
if(isBlocked() === false && $_GET['status'] == 'restorePageToLastState') {

  // vars
  $categoryFolder = ($category == 0) ? '' : $category.'/';

  if(file_exists(dirname(__FILE__).'/../../pages/'.$categoryFolder.$page.'.previous.php')) {

    $currentState = GeneralFunctions::readPage($page,$category);
    if(($previousState = GeneralFunctions::readPage($page,$category,true)) !== false) {

      GeneralFunctions::savePage($previousState);
      GeneralFunctions::savePage($currentState,true);

      $NOTIFICATION .= '<div class="alert alert-info">'.sprintf($langFile['EDITOR_MESSAGE_RESTOREDTOLASTSTATE'],GeneralFunctions::dateDayBeforeAfter($previousState['lastSaveDate']).' '.formatTime($previousState['lastSaveDate'])).'</div>';
    }
    unset($currentState,$previousState);
  }
}


// SAVE the PAGE
// -----------------------------------------------------------------------------
if(isBlocked() === false && $_POST['save']) {
  // vars
  $page = $_POST['id'];
  $category = $_POST['category'];
  $_GET['page'] = $page;
  $_GET['category'] = $category;

  // removes double whitespaces and slashes
  $_POST['HTMLEditor'] = preg_replace("/ +/", ' ', $_POST['HTMLEditor'] );
  $_POST['HTMLEditor'] = str_replace('\"', '"', $_POST['HTMLEditor'] );


  // *** CREATE NEW PAGE ----------------------
  if ($page == 'new') {

    // looks fore the highest id (FLATFILES)
    $page = getNewPageId();
    $_POST['id'] = $page;
    $pageContent['id'] = $page;
    $_POST['sortOrder'] = $page;
    $_GET['page'] = $page;

    // sets the selected category
    $category = $_POST['categorySelection'];
    $_GET['category'] = $_POST['categorySelection'];
    $_POST['category'] = $_POST['categorySelection'];
    $pageContent['category'] = $_POST['categorySelection'];

    $logText = 0;

    // delete statistics, if still exist
    if(is_file(dirname(__FILE__).'/../../statistics/pages/'.$page.'.statistics.php'))
      @unlink(dirname(__FILE__).'/../../statistics/pages/'.$page.'.statistics.php');

  // *** SAVE PAGE ----------------------
  } else {

    // if flatfile exists, load the existing $pageContent array
    if(!$pageContent = GeneralFunctions::readPage($page,$category)) {
      $ERRORWINDOW .= sprintf($langFile['file_error_read'],$adminConfig['basePath']);

    // create a BACKUP of the PREVIOUS STATE
    } else {
      $categoryFolder = ($category == 0) ? '' : $category.'/';
      copy(dirname(__FILE__).'/../../pages/'.$categoryFolder.$page.'.php', dirname(__FILE__).'/../../pages/'.$categoryFolder.$page.'.previous.php');
    }

    $logText = ($_POST['status'] == 'addLanguage')
      ? 33
      : 1;

    // get OTHER LOCALIZED content
    $_POST['localized'] = $pageContent['localized'];

    // transfer plugins
    $_POST['plugins'] = $pageContent['plugins'];
  }

  // -> only save page if no error occured
  if($ERRORWINDOW === false) {


    // SAVE NEW PLUGINS and REMOVE OLD ONES
    $pluginsBefore = $_POST['plugins'];
    unset($_POST['plugins']);
    if(is_array($_POST['newPlugins'])){
      foreach($_POST['newPlugins'] as $plugins) {
        $pluginNumber = substr($plugins, strpos($plugins, '#')+1);
        $pluginName = substr($plugins, 0 ,strpos($plugins, '#'));
        $pluginConfig = @include(dirname(__FILE__).'/../../plugins/'.$pluginName.'/config.php');

        // DebugTools::dump($pluginConfig);

        // add new plugins, but prevent to overwrite existing ones
        if(is_array($pluginsBefore[$pluginName][$pluginNumber]))
          $_POST['plugins'][$pluginName][$pluginNumber] = $pluginsBefore[$pluginName][$pluginNumber];
        else {
          $_POST['plugins'][$pluginName][$pluginNumber] = $pluginConfig;
          $_POST['plugins'][$pluginName][$pluginNumber]['active'] = true;
        }

        unset($pluginConfig,$pluginName,$pluginNumber);
      }
    }


    // STORE LOCALIZED CONTENT
    $_POST['tags'] = trim(preg_replace("#[,]+#", ',', $_POST['tags']),',');
    $_POST['tags'] = preg_replace("# +#", ' ', $_POST['tags']); // replace multiple whitespaces with one whitespace
    $_POST['tags'] = preg_replace("# *, *#", ',', $_POST['tags']); // make " , " to  ","

    $_POST['localized'][$_POST['websiteLanguage']]['tags'] = $_POST['tags'];
    $_POST['localized'][$_POST['websiteLanguage']]['title'] = $_POST['title'];
    $_POST['localized'][$_POST['websiteLanguage']]['description'] = $_POST['description'];
    $_POST['localized'][$_POST['websiteLanguage']]['content'] = $_POST['HTMLEditor'];

    // delete unnecessary variables
    unset($_POST['tags'],$_POST['title'],$_POST['description'],$_POST['HTMLEditor']);

    // STORE data right
    $_POST['lastSaveDate'] = time();
    $_POST['lastSaveAuthor'] = $_SESSION['feinduraSession']['login']['user'];
    $_POST['thumbnail'] = $pageContent['thumbnail'];

    // PAGE DATE
    if($categoryConfig[$category]['showPageDate']) {

      // vars
      $pageDate = $_POST['pageDate'];
      unset($_POST['pageDate']);
      $_POST['pageDate'] = array();

      // PREPARE PAGEDATE
      if($backendDateFormat == 'D/M/Y')
        $_POST['pageDate'] = str_replace('/','.',$_POST['pageDate']);

      // SET PAGEDATE
      if($categoryConfig[$category]['pageDateAsRange']) {
        $pageDate = explode(' - ', $pageDate);
        $_POST['pageDate']['start'] = strtotime($pageDate[0]);
        $_POST['pageDate']['end']   = strtotime($pageDate[1]);

        unset($_POST['pageDate'][0],$_POST['pageDate'][1]);
      } else {
        $_POST['pageDate']['start'] = strtotime($pageDate);
        $_POST['pageDate']['end'] = false;
      }
    }

    if(empty($_POST['sortOrder']))  $_POST['sortOrder'] = $pageContent['sortOrder'];

    // ->> add page and subcategory bool to the categoryConfig array
    $newCategoryConfig = $categoryConfig;
    // first clear this page put of every other categoryConfig
    foreach ($categoryConfig as $key => $config) {
      $pagesWithSubCategory = unserialize($config['isSubCategoryOf']);
      if(!is_array($pagesWithSubCategory))
        $pagesWithSubCategory = array();
      else
        unset($pagesWithSubCategory[$page]);
      if(empty($pagesWithSubCategory))
        $newCategoryConfig[$key]['isSubCategory'] = false;
     $newCategoryConfig[$key]['isSubCategoryOf'] = serialize($pagesWithSubCategory);
    }
    // store it in a new category config, if is the subCategory
    if(!empty($_POST['subCategory']) && is_numeric($_POST['subCategory'])) {
      $pagesWithSubCategory = unserialize($newCategoryConfig[$_POST['subCategory']]['isSubCategoryOf']);
      $pagesWithSubCategory[$page] = $category;
      $newCategoryConfig[$_POST['subCategory']]['isSubCategory']   = true;
      $newCategoryConfig[$_POST['subCategory']]['isSubCategoryOf'] = serialize($pagesWithSubCategory);
    }
    saveCategories($newCategoryConfig);
    GeneralFunctions::$categoryConfig = $newCategoryConfig;

    // adds absolute path slash on the beginning and implode the stylefiles
    $_POST['styleFile'] = prepareStyleFilePaths($_POST['styleFile']);

    // bubbles through the page, category and adminConfig to see if it should save the styleheet-file path, id or class-attribute
    $_POST['styleFile']  = setStylesByPriority($_POST['styleFile'],'styleFile',$category);
    $_POST['styleId']    = setStylesByPriority($_POST['styleId'],'styleId',$category);
    $_POST['styleClass'] = setStylesByPriority($_POST['styleClass'],'styleClass',$category);


    if(GeneralFunctions::savePage($_POST)) {
      $DOCUMENTSAVED = true;

      if($_POST['status'] == 'addLanguage')
        saveActivityLog(array($logText,$languageNames[$_POST['websiteLanguage']]),'page='.$page); // <- SAVE the task in a LOG FILE
      else
        saveActivityLog($logText,'page='.$page); // <- SAVE the task in a LOG FILE

      // set PERMISSIONS of the page
      $filePath = ($category == 0)
        ? dirname(__FILE__).'/../../pages/'.$page.'.php'
        : dirname(__FILE__).'/../../pages/'.$category.'/'.$page.'.php';
      @chmod($filePath, $adminConfig['permissions']);


      // -> set as startpage, if activated
      if($_POST['setStartPage']) {
        $websiteConfig['startPage'] = $page;
        saveWebsiteConfig($websiteConfig);
      }

      // ->> save the FEEDS, if activated
      saveFeeds($category);
      // ->> save the SITEMAP
      saveSitemap();

    } else
      $ERRORWINDOW .= sprintf($langFile['EDITOR_savepage_error_save'],$adminConfig['basePath']);
  }

  // sets which block should be opend after saving
  $SAVEDFORM = $_POST['savedBlock'];
}



// -> LOAD PAGE
if($pageContent = GeneralFunctions::readPage($page,$category)) {
  $NEWPAGE = false;
  $previousStatePageContent = GeneralFunctions::readPage($pageContent['id'],$pageContent['category'],true);
}
// otherwise offer NEW PAGE
else
  $NEWPAGE = true;

// set to new page if i couldn't load the page
if($NEWPAGE) {
  $_GET['page'] = 'new';
  $page = 'new';
}

// -> check if the thumbnail still exists, if not clear the thumbnail state of the file
if(!empty($pageContent['thumbnail']) && isBlocked() === false && !file_exists(dirname(__FILE__).'/../../upload/thumbnails/'.$pageContent['thumbnail'])) {
  $pageContent['thumbnail'] = '';
  GeneralFunctions::savePage($pageContent);
}

// if ADD LANGUAGE set the $NEWPAGE var to TRUE, and ADD TITLE TEXT
if($_GET['status'] == 'addLanguage') {
  $NEWPAGE = true;
  $pageTitle = $langFile['BUTTON_WEBSITELANGUAGE_ADD'].': '.$languageNames[$_SESSION['feinduraSession']['websiteLanguage']];

  // LOAD LANGUAGE as template
  if(isset($_GET['template']) && is_string($_GET['template']) && strlen($_GET['template']) == 2)
    $pageContent['localized'][$_SESSION['feinduraSession']['websiteLanguage']] = $pageContent['localized'][$_GET['template']];
}

// LOAD PAGE as TEMPLATE
if($NEWPAGE && isset($_GET['template']) && is_numeric($_GET['template'])) {
  $pageContent = GeneralFunctions::readPage($_GET['template'],GeneralFunctions::getPageCategory($_GET['template']));

  foreach ($pageContent['localized'] as $langCode => $localized) {
    $pageContent['localized'][$langCode]['title'] = $localized['title'].' ('.$langFile['EDITOR_TEXT_TEMPALATECOPYADDITION'].')';
  }

  unset($localized,$langCode);
}


// LOAD PLUGINS
$plugins = GeneralFunctions::readFolder(dirname(__FILE__).'/../../plugins/');
$newPlugins = array();
if(is_array($plugins['folders'])) {
  foreach($plugins['folders'] as $pluginFolder)
    $newPlugins[] = basename($pluginFolder);
}
$plugins = $newPlugins;
unset($newPlugins);

?>