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

* controllers/pageSetup.controller.php version 1.4
*/

/**
 * Includes the login.include.php and backend.include.php and filter the basic data
 */
require_once(dirname(__FILE__)."/../includes/secure.include.php");

// vars
$categoriesForFeedSaving = array();


// ---------------------------------------------------------------------------------------------------
// ****** ---------- SAVE PAGE CONFIG in config/admin.config.php
if(isset($_POST['send']) && $_POST['send'] ==  'pageConfig') {

  // ** ensure the the post vars with a 'Path' in the key value ending with a '/'
  $_POST = addSlashesToPaths($_POST);
  $_POST = removeDocumentRootFromPaths($_POST);

  // ** removes a "/" on the beginning of all relative paths
  if(!empty($_POST['cfg_thumbPath']) && substr($_POST['cfg_thumbPath'],0,1) == '/')
        $_POST['cfg_thumbPath'] = substr($_POST['cfg_thumbPath'],1);

  // -> CHECK if the THUMBNAIL HEIGHT/WIDTH is empty, and add the previous ones
  if(!isset($_POST['cfg_thumbWidth']))
    $_POST['cfg_thumbWidth'] = $adminConfig['pageThumbnail']['width'];
  if(!isset($_POST['cfg_thumbHeight']))
    $_POST['cfg_thumbHeight'] = $adminConfig['pageThumbnail']['height'];

  $newAdminConfig                                         = $adminConfig; // transfer the rest of the adminConfig
  $newAdminConfig['pageThumbnail']['width']               = $_POST['cfg_thumbWidth'];
  $newAdminConfig['pageThumbnail']['height']              = $_POST['cfg_thumbHeight'];
  $newAdminConfig['pageThumbnail']['ratio']               = $_POST['cfg_thumbRatio'];


  // -> save ADMIN SETTINGS
  if(saveAdminConfig($newAdminConfig)) {
    // give documentSaved status
    $DOCUMENTSAVED = true;
    saveActivityLog(14); // <- SAVE the task in a LOG FILE

  } else
    $ERRORWINDOW .= sprintf($langFile['ADMINSETUP_GENERAL_error_save'],$adminConfig['basePath']);

  $SAVEDFORM = $_POST['savedBlock'];
  $SAVEDSETTINGS = true;
}

// ---------------------------------------------------------------------------------------------------
// ****** ---------- SAVE CATEGORY CONFIG in config/category.config.php

// ****** ---------- CREATE NEW CATEGORY
if((isset($_POST['send']) && $_POST['send'] == 'categorySetup' && isset($_POST['createCategory'])) ||
   $_GET['status'] == 'createCategory') {

  // var
  $isDir = false;

  // -> GET highest category id
  $newId = getNewCatgoryId();

  if(is_numeric($newId)) {

    // if there is no category dir, try to create one
    if(@is_dir(dirname(__FILE__).'/../../pages/'.$newId)) {
      $isDir = true;
    } else {
      // creates a new category folder
      if(!@mkdir(dirname(__FILE__).'/../../pages/'.$newId, $adminConfig['permissions'],true)) {
          $isDir = false;
          $ERRORWINDOW .= sprintf($langFile['PAGESETUP_CATEGORY_ERROR_CREATEDIR'],$adminConfig['basePath']);
      // save category dir could be created
      } else
        $isDir = true;
    }

    // finaly if category directory exists
    if($isDir) {
      // add a new id to the category array
      $categoryConfig[$newId] = array('id' => $newId); // gives the new category a id
      if(saveCategories($categoryConfig)) {
         $NOTIFICATION .= '<div class="alert alert-success">'.$langFile['PAGESETUP_CATEGORY_TEXT_CREATECATEGORY_CREATED'].'</div>';
         saveActivityLog(15); // <- SAVE the task in a LOG FILE
      } else { // throw error
        $ERRORWINDOW .= ($ERRORWINDOW) // if there is allready an warning
          ? '<br><br>'.sprintf($langFile['PAGESETUP_CATEGORY_ERROR_CREATECATEGORY'],$adminConfig['basePath'])
          : sprintf($langFile['PAGESETUP_CATEGORY_ERROR_CREATECATEGORY'],$adminConfig['basePath']);
      }
    }

  } else // throw error
    $ERRORWINDOW .= sprintf($langFile['PAGESETUP_CATEGORY_ERROR_CREATECATEGORY'],$adminConfig['basePath']);

  $SAVEDFORM = 'categories';
  $SAVEDSETTINGS = true;
}

// ****** ---------- DELETE CATEGORY
if(((isset($_POST['send']) && $_POST['send'] ==  'categorySetup' && isset($_POST['deleteCategory'])) ||
   $_GET['status'] == 'deleteCategory') && isset($categoryConfig[$_GET['category']])) {

  // save the name, to put it in the info
  $storedCategoryName = GeneralFunctions::getLocalized($categoryConfig[$_GET['category']],'name');

  // deletes the category with the given id from the array and saves the categoriesSettings.php
  unset($categoryConfig[$_GET['category']]);
  if(saveCategories($categoryConfig)) {

    $NOTIFICATION .= '<div class="alert alert-info">'.$langFile['PAGESETUP_CATEGORY_TEXT_DELETECATEGORY_DELETED'].'<br><strong>'.$storedCategoryName.'</strong></div>';

    // if there is a category dir, trys to delete it !important deletes all files in it
    if(is_dir(dirname(__FILE__).'/../../pages/'.$_GET['category'])) {

      if($pages = GeneralFunctions::loadPages($_GET['category'])) {

        // deletes possible thumbnails before deleting the category
        foreach($pages as $page) {
          if(!empty($page['thumbnail']) && is_file(dirname(__FILE__).'/../../upload/thumbnails/'.$page['thumbnail'])) {
            @chmod(dirname(__FILE__).'/../../upload/thumbnails/'.$page['thumbnail'], $adminConfig['permissions']);
            // DELETING
            @unlink(dirname(__FILE__).'/../../upload/thumbnails/'.$page['thumbnail']);
          }
        }
      }

      // deletes the dir with subdirs and files
      if(!GeneralFunctions::deleteFolder(dirname(__FILE__).'/../../pages/'.$_GET['category'].'/')) {
        $ERRORWINDOW .= ($ERRORWINDOW) // if there is allready an warning
          ? '<br><br>'.sprintf($langFile['PAGESETUP_CATEGORY_ERROR_DELETEDIR'],$adminConfig['basePath'])
          : sprintf($langFile['PAGESETUP_CATEGORY_ERROR_DELETEDIR'],$adminConfig['basePath']);
      }
    }

    saveActivityLog(16,$storedCategoryName); // <- SAVE the task in a LOG FILE
  } else // throw error
    $ERRORWINDOW .= sprintf($langFile['PAGESETUP_CATEGORY_ERROR_DELETECATEGORY'],$adminConfig['basePath']);

  $SAVEDFORM = 'categories';
  $SAVEDSETTINGS = true;
}

// ****** ---------- MOVE CATEGORY
if(substr($_GET['status'],0,12) == 'moveCategory' && !empty($_GET['category']) && is_numeric($_GET['category'])) {

  $categoryName = GeneralFunctions::getLocalized($categoryConfig[$_GET['category']],'name');

  // move the categories in the categories array
  if($_GET['status'] == 'moveCategoryUp')
    $direction = 'up';
  if($_GET['status'] == 'moveCategoryDown')
    $direction = 'down';

  if(moveCategories($categoryConfig,$_GET['category'],$direction)) {

    $NOTIFICATION .= '<div class="alert alert-success">'.$langFile['PAGESETUP_CATEGORY_TEXT_MOVECATEGORY_MOVED'].'<br><strong>'.$categoryName.'</strong></div>';

    // save the categories array
    if(saveCategories($categoryConfig)) {
      $DOCUMENTSAVED = true; // set documentSaved status
      saveActivityLog(17,'category='.$_GET['category']); // <- SAVE the task in a LOG FILE
    } else
      $ERRORWINDOW .= sprintf($langFile['PAGESETUP_CATEGORY_ERROR_SAVE'],$adminConfig['basePath']);

  }

  unset($categoryName,$direction);

  $SAVEDFORM = 'categories';
  $SAVEDSETTINGS = true;
}


// ****** ---------- SAVE CATEGORIES
if(isset($_POST['send']) && $_POST['send'] ==  'categorySetup' && isset($_POST['categories'])) {


  // transfer data from the categoryConfig
  foreach($_POST['categories'] as $categoryId => $value) {
    $_POST['categories'][$categoryId]['isSubCategory']   = $categoryConfig[$categoryId]['isSubCategory'];
    $_POST['categories'][$categoryId]['isSubCategoryOf'] = $categoryConfig[$categoryId]['isSubCategoryOf'];
    $_POST['categories'][$categoryId]['localized']       = $categoryConfig[$categoryId]['localized'];

    // add categories which have a changed feed status to the array
    if($categoryConfig[$categoryId]['feeds'] != $_POST['categories'][$categoryId]['feeds'])
      $categoriesForFeedSaving[] = $categoryId;

    // set the PAGE DATE TIME PERIOD to FALSE, if the PAGE DATE was DEACTIVATED
    if(!$_POST['categories'][$categoryId]['showPageDate']) {
      $_POST['categories'][$categoryId]['pageDateAsRange'] = false;


      // clear the page date on all pages in that category (DEACTIVATED, have t think about it)
      // $catPages = GeneralFunctions::loadPages($categoryId);
      // foreach ($catPages as $catPage) {
      //   $catPage['pageDate'] = false;
      //   GeneralFunctions::savePage($catPage);
      // }
      // unset($catPages);
    }

    // STORE LOCALIZED CONTENT
    if(!empty($value['name']))
      $_POST['categories'][$categoryId]['localized'][$_POST['websiteLanguage']]['name'] = $value['name'];

    // delete unnecessary variables
    unset($_POST['categories'][$categoryId]['name']);
  }

  // transfer the style settings
  $_POST['categories'][0]['styleFile']  = $categoryConfig[0]['styleFile'];
  $_POST['categories'][0]['styleId']    = $categoryConfig[0]['styleId'];
  $_POST['categories'][0]['styleClass'] = $categoryConfig[0]['styleClass'];

  if(saveCategories($_POST['categories'])) {
    $DOCUMENTSAVED = true; // set documentSaved status
    saveActivityLog(18); // <- SAVE the task in a LOG FILE

  } else
    $ERRORWINDOW .= $langFile['PAGESETUP_CATEGORY_ERROR_SAVE'];

  $SAVEDFORM = 'categories';
  $SAVEDSETTINGS = true;
}


// RE-INCLUDE
if($SAVEDSETTINGS) {
  unset($adminConfig); $adminConfig = @include (dirname(__FILE__)."/../../config/admin.config.php");
  unset($categoryConfig); $categoryConfig = @include (dirname(__FILE__)."/../../config/category.config.php");

  // ADD NON-CATEGORY name from the current language file AGAIN (before in backend.include.php)
  $categoryConfig[0]['localized'][0]['name'] = $langFile['CATEGORIES_TOOLTIP_NONCATEGORY'];

  // reload the $pagesMetaData array
  GeneralFunctions::savePagesMetaData();
  // RESET of the vars in the classes
  GeneralFunctions::$storedPages = null;
  GeneralFunctions::$adminConfig = $adminConfig;
  GeneralFunctions::$categoryConfig = $categoryConfig;
  StatisticFunctions::$adminConfig = $adminConfig;
  StatisticFunctions::$categoryConfig = $categoryConfig;

  // DELETE old FEED FILES
  // non category
  $feedFiles = glob(dirname(__FILE__).'/../../pages/*.xml');
  foreach ($feedFiles as $feedFile) {
    unlink($feedFile);
  }
  if(is_array($categoryConfig)) {
    foreach ($categoryConfig as $category) {
      $feedFiles = glob(dirname(__FILE__).'/../../pages/'.$category['id'].'/*.xml');
      foreach ($feedFiles as $feedFile) {
        unlink($feedFile);
      }
    }
  }

  // -> check isSubCategoryOf in categories and subCategory in pages
  checkSubCategories();

  // ->> save the FEEDS for categories, if activated
  foreach($categoriesForFeedSaving as $categoryForFeedSaving)
    saveFeeds($categoryForFeedSaving);

  // ->> save the SITEMAP
  saveSitemap();
}

?>