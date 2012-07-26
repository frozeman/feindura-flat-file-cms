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
$page	= $_GET['page'];
$category = $_GET['category'];

// SAVE the PAGE
// -----------------------------------------------------------------------------
if($_POST['save'] && isBlocked() === false) {

  // vars
  $page	= $_POST['id'];
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
    if(is_file(dirname(__FILE__).'/../../statistic/pages/'.$page.'.statistics.php'))
      @unlink(dirname(__FILE__).'/../../statistic/pages/'.$page.'.statistics.php');

  // *** SAVE PAGE ----------------------
  } else {

    // if flatfile exists, load $pageContent array
    // (necessary for: thumbnail, sortOrder and logs)
    if(!$pageContent = GeneralFunctions::readPage($page,$category))
      $errorWindow .= sprintf($langFile['file_error_read'],$adminConfig['basePath']);

    $logText = ($_POST['status'] == 'addLanguage')
      ? 33
      : 1;

    // get OTHER LOCALIZED content
    $_POST['localized'] = $pageContent['localized'];
  }

  // -> only save page if no error occured
  if($errorWindow === false) {

    // STORE LOCALIZED CONTENT
    $_POST['localized'][$_POST['websiteLanguage']]['pageDate']['before'] = $_POST['pageDate']['before'];
    $_POST['localized'][$_POST['websiteLanguage']]['pageDate']['after'] = $_POST['pageDate']['after'];
    $_POST['tags'] = trim(preg_replace("#[\;,]+#", ',', $_POST['tags']),',');
    $_POST['tags'] = preg_replace("# +#", ' ', $_POST['tags']); // replace multiple whitespaces with one whitespace
    $_POST['localized'][$_POST['websiteLanguage']]['tags'] = preg_replace("# *, *#", ',', $_POST['tags']); // make " , " to  ","
    $_POST['localized'][$_POST['websiteLanguage']]['title'] = $_POST['title'];
    $_POST['localized'][$_POST['websiteLanguage']]['description'] = $_POST['description'];
    $_POST['localized'][$_POST['websiteLanguage']]['content'] = $_POST['HTMLEditor'];

    // delete unnecessary variables
    unset($_POST['pageDate']['before'],$_POST['pageDate']['after'],$_POST['tags'],$_POST['title'],$_POST['description'],$_POST['HTMLEditor']);

    // STORE data right
    $_POST['lastSaveDate'] = time();
    $_POST['lastSaveAuthor'] = $_SESSION['feinduraSession']['login']['user'];
    $_POST['thumbnail'] = $pageContent['thumbnail'];

    // generates pageDate
    $generatedPageDate = '';
    if(!empty($_POST['pageDate']['day']) && !empty($_POST['pageDate']['month']))
      $generatedPageDate = $_POST['pageDate']['year'].'-'.$_POST['pageDate']['month'].'-'.$_POST['pageDate']['day'];

    // VALIDATE the SORT DATE
    if(($pageDate = validateDateString($generatedPageDate)) === false)
      $pageDate = $generatedPageDate;
    // if VALID set the validated date to the post var
    else {
      $_POST['pageDate']['date'] = $pageDate;
      unset($pageDate);
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
      $documentSaved = true;

      if($_POST['status'] == 'addLanguage')
        saveActivityLog(array($logText,$languageNames[$_POST['websiteLanguage']]),'page='.$page); // <- SAVE the task in a LOG FILE
      else
        saveActivityLog($logText,'page='.$page); // <- SAVE the task in a LOG FILE

      // set PERMISSIONS of the page
      $filePath = ($category == 0)
        ? dirname(__FILE__).'/../../pages/'.$page.'.php'
        : dirname(__FILE__).'/../../pages/'.$category.'/'.$page.'.php';
      @chmod($filePath, $adminConfig['permissions']);

      // ->> save the FEEDS, if activated
      saveFeeds($category);
      // ->> save the SITEMAP
      saveSitemap();

    } else
      $errorWindow .= sprintf($langFile['EDITOR_savepage_error_save'],$adminConfig['basePath']);
  }

  // sets which block should be opend after saving
  $savedForm = $_POST['savedBlock'];
}


// -> LOAD PAGE
if($pageContent = GeneralFunctions::readPage($page,$category))
  $newPage = false;
// otherwise offer NEW PAGE
else
  $newPage = true;

// set to new page if i couldn't load the page
if($newPage) {
  $_GET['page'] = 'new';
  $page = 'new';
}

// -> check if the thumbnail still exists, if not clear the thumbnail state of the file
if(!file_exists(DOCUMENTROOT.$adminConfig['uploadPath'].$adminConfig['pageThumbnail']['path'].$pageContent['thumbnail']) && isBlocked() === false) {
  $pageContent['thumbnail'] = '';
  GeneralFunctions::savePage($pageContent);
}

// if ADD LANGUAGE set the $newPage var to TRUE, and ADD TITLE TEXT
if($_GET['status'] == 'addLanguage') {
  $newPage = true;
  $pageTitle = $langFile['BUTTON_WEBSITELANGUAGE_ADD'].': '.$languageNames[$_SESSION['feinduraSession']['websiteLanguage']];

  // LOAD LANGUAGE as template
  if(isset($_GET['template']) && is_string($_GET['template']) && strlen($_GET['template']) == 2)
    $pageContent['localized'][$_SESSION['feinduraSession']['websiteLanguage']] = $pageContent['localized'][$_GET['template']];
}

// LOAD PAGE as TEMPLATE
if($newPage && isset($_GET['template']) && is_numeric($_GET['template'])) {
  $pageContent = GeneralFunctions::readPage($_GET['template'],GeneralFunctions::getPageCategory($_GET['template']));

  foreach ($pageContent['localized'] as $langCode => $localized) {
    $pageContent['localized'][$langCode]['title'] = $localized['title'].' ('.$langFile['EDITOR_TEXT_TEMPALATECOPYADDITION'].')';
  }

  unset($localized,$langCode);
}

?>