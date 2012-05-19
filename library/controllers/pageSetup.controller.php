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

* controllers/pageSetup.controller.php version 1.22
*/

/**
 * Includes the login.include.php and backend.include.php and filter the basic data
 */
require_once(dirname(__FILE__)."/../includes/secure.include.php");

// VARs
$categoryInfo = false;

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

  // -> PREPARE CONFIG VARs
  $newAdminConfig                                         = $adminConfig; // transfer the rest if the adminConfig
  $newAdminConfig['setStartPage']                         = $_POST['cfg_setStartPage'];
  $newAdminConfig['multiLanguageWebsite']['active']       = $_POST['cfg_multiLanguageWebsite'];
  $newAdminConfig['multiLanguageWebsite']['mainLanguage'] = $_POST['cfg_websiteMainLanguage'];
  $newAdminConfig['multiLanguageWebsite']['languages']    = $_POST['cfg_websiteLanguages'];
  
  $newAdminConfig['pages']['createDelete']                = $_POST['cfg_pageCreatePages'];
  $newAdminConfig['pages']['thumbnails']                  = $_POST['cfg_pageThumbnailUpload'];  
  $newAdminConfig['pages']['plugins']                     = serialize($_POST['cfg_pagePlugins']);
  $newAdminConfig['pages']['showTags']                    = $_POST['cfg_pageTags'];
  $newAdminConfig['pages']['showPageDate']                = $_POST['cfg_pagePageDate'];
  $newAdminConfig['pages']['showSubCategory']             = $_POST['cfg_subCategory'];
  $newAdminConfig['pages']['feeds']                       = $_POST['cfg_pagefeeds'];
  $newAdminConfig['pages']['sorting']                     = $_POST['cfg_pageSorting'];
  $newAdminConfig['pages']['sortReverse']                 = $_POST['cfg_pageSortReverse'];
  
  $newAdminConfig['pageThumbnail']['width']               =  $_POST['cfg_thumbWidth'];
  $newAdminConfig['pageThumbnail']['height']              = $_POST['cfg_thumbHeight'];
  $newAdminConfig['pageThumbnail']['ratio']               = $_POST['cfg_thumbRatio'];
  $newAdminConfig['pageThumbnail']['path']                = $_POST['cfg_thumbPath'];

  // ------------------------------------------------------------------

  // ->> CHANGE PAGES to MULTI LANGUAGE pages
  if($newAdminConfig['multiLanguageWebsite']['active'] == 'true') {

    // GET the REMOVED LANGUAGES
    $removedLanguages = array();
    if(is_array($adminConfig['multiLanguageWebsite']['languages'])) {
      foreach ($adminConfig['multiLanguageWebsite']['languages'] as $langCode) {
        if(!in_array($langCode, $newAdminConfig['multiLanguageWebsite']['languages']))
          $removedLanguages[] = $langCode;
      }
    }
        
    // -> CHANGE PAGES
    $allPages = GeneralFunctions::loadPages(true);
    foreach($allPages as $pageContent) {

      // $pageContent['localized'][0] = (!isset($pageContent['localized'][0])) ? array() : $pageContent['localized'][0];

      // change the non localized content to the mainLanguage
      if(is_array($pageContent['localized']) && is_array(current($pageContent['localized']))) {
        
        // USE LOCALIZATION: Get either the already existing mainLanguage, or use the next following language as the mainLanguage
        $useLocalization = (isset($pageContent['localized'][$newAdminConfig['multiLanguageWebsite']['mainLanguage']]))
          ? $pageContent['localized'][$newAdminConfig['multiLanguageWebsite']['mainLanguage']]
          : current($pageContent['localized']);

        // REMOVE old LANGUAGES
        foreach ($removedLanguages as $langCode) {
          unset($pageContent['localized'][$langCode]);
        }

        // put the mainLanguage on the top
        $pageContent['localized'] = array_merge(array($newAdminConfig['multiLanguageWebsite']['mainLanguage'] => $useLocalization), $pageContent['localized']);
        unset($pageContent['localized'][0]);
      }
      if(!GeneralFunctions::savePage($pageContent))
        $errorWindow .= sprintf($langFile['EDITOR_savepage_error_save'],$adminConfig['realBasePath']);
    }

    // -> CHANGE WEBSITE CONFIG
    if(is_array($websiteConfig['localized']) && is_array(current($websiteConfig['localized']))) {
      // get the either the already existing mainLanguage, or use the next following language as the mainLanguage
      $useLocalization = (isset($websiteConfig['localized'][$newAdminConfig['multiLanguageWebsite']['mainLanguage']]))
        ? $websiteConfig['localized'][$newAdminConfig['multiLanguageWebsite']['mainLanguage']]
        : current($websiteConfig['localized']);

      // put the mainLanguage on the top
      $websiteConfig['localized'] = array_merge(array($newAdminConfig['multiLanguageWebsite']['mainLanguage'] => $useLocalization), $websiteConfig['localized']);
      unset($websiteConfig['localized'][0]);

      // REMOVE old LANGUAGES
      foreach ($removedLanguages as $langCode) {
        unset($websiteConfig['localized'][$langCode]);
      }
    }
    if(!saveWebsiteConfig($websiteConfig))
      $errorWindow .= sprintf($langFile['websiteSetup_websiteConfig_error_save'],$adminConfig['realBasePath']);    

    // -> CHANGE CATEGORY CONFIG
    // change the localized content to non localized content using the the mainLanguage
    if(is_array($categoryConfig)) {
      $newCategoryConfig = array();
      foreach ($categoryConfig as $key => $category) {
        $newCategoryConfig[$key] = $category;

        // get the either the already existing mainLanguage, or use the next following language as the mainLanguage
        $useLocalization = (isset($category['localized'][$newAdminConfig['multiLanguageWebsite']['mainLanguage']]))
          ? $category['localized'][$newAdminConfig['multiLanguageWebsite']['mainLanguage']]
          : current($category['localized']);

        // put the mainLanguage on the top
        $newCategoryConfig[$key]['localized'] = array_merge(array($newAdminConfig['multiLanguageWebsite']['mainLanguage'] => $useLocalization), $category['localized']);
        unset($newCategoryConfig[$key]['localized'][0]);

        // REMOVE old LANGUAGES
        foreach ($removedLanguages as $langCode) {
          unset($newCategoryConfig[$key]['localized'][$langCode]);
        }
      }
      if(!saveCategories($newCategoryConfig))
        $errorWindow .= sprintf($langFile['PAGESETUP_CATEGORY_ERROR_CREATECATEGORY'],$adminConfig['realBasePath']);
    }

    // -> add SESSION
    $_SESSION['feinduraSession']['websiteLanguage'] = $newAdminConfig['multiLanguageWebsite']['mainLanguage'];


  // ->> CHANGE TO SINGLE LANGUAGE
  } else {

    // -> CHANGE PAGES
    $allPages = GeneralFunctions::loadPages(true);
    foreach($allPages as $pageContent) {

      // change the localized content to non localized content using the the mainLanguage
      if(is_array($pageContent['localized']) && isset($pageContent['localized'][$adminConfig['multiLanguageWebsite']['mainLanguage']])) {
        $storedMainLanguageArray = $pageContent['localized'][$adminConfig['multiLanguageWebsite']['mainLanguage']];
        unset($pageContent['localized']);
        $pageContent['localized'][0] = $storedMainLanguageArray;
      
      // if the mainLanguage didnt exist create an empty array
      } else
        $pageContent['localized'][0] = array();

      if(!GeneralFunctions::savePage($pageContent))
        $errorWindow .= sprintf($langFile['EDITOR_savepage_error_save'],$adminConfig['realBasePath']);
    }

    // -> CHANGE WEBSITE CONFIG
    // change the localized content to non localized content using the the mainLanguage
    if(is_array($websiteConfig['localized']) && isset($websiteConfig['localized'][$adminConfig['multiLanguageWebsite']['mainLanguage']])) {
      $storedMainLanguageArray = $websiteConfig['localized'][$adminConfig['multiLanguageWebsite']['mainLanguage']];
      unset($websiteConfig['localized']);
      $websiteConfig['localized'][0] = $storedMainLanguageArray;
    
    // if the mainLanguage didnt exist create an empty array
    } else
      $websiteConfig['localized'][0] = array();
    if(!saveWebsiteConfig($websiteConfig))
      $errorWindow .= sprintf($langFile['websiteSetup_websiteConfig_error_save'],$adminConfig['realBasePath']);


    // -> CHANGE CATEGORY CONFIG
    // change the localized content to non localized content using the the mainLanguage
    if(is_array($categoryConfig)) {
      $newCategoryConfig = array();
      foreach ($categoryConfig as $key => $category) {
        $newCategoryConfig[$key] = $category;

        if(is_array($category['localized']) && isset($category['localized'][$adminConfig['multiLanguageWebsite']['mainLanguage']])) {
          $storedMainLanguageArray = $category['localized'][$adminConfig['multiLanguageWebsite']['mainLanguage']];
          unset($newCategoryConfig[$key]['localized']);
          $newCategoryConfig[$key]['localized'][0] = $storedMainLanguageArray;
        
        // if the mainLanguage didnt exist create an empty array
        } else
          $newCategoryConfig[$key]['localized'][0] = array();
      }
      if(!saveCategories($newCategoryConfig))
        $errorWindow .= sprintf($langFile['PAGESETUP_CATEGORY_ERROR_CREATECATEGORY'],$adminConfig['realBasePath']);
    }

    // -> unset SESSION
    unset($_SESSION['feinduraSession']['websiteLanguage']);
  }
  // ------------------------------------------------------------------

  // -> save ADMIN SETTINGS
  if(saveAdminConfig($newAdminConfig)) {
    // give documentSaved status
    $documentSaved = true;
    saveActivityLog(14); // <- SAVE the task in a LOG FILE
    
  } else
    $errorWindow .= sprintf($langFile['ADMINSETUP_GENERAL_error_save'],$adminConfig['realBasePath']);
  
  $savedForm = $_POST['savedBlock'];
  $savedSettings = true;
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
    if($newId == 1)
      $categoryConfig = array();
    
    // if there is no category dir, try to create one
    if(@is_dir(dirname(__FILE__).'/../../pages/'.$newId)) {
      $isDir = true;
    } else {
      // creates a new category folder
      if(!@mkdir(dirname(__FILE__).'/../../pages/'.$newId, $adminConfig['permissions'],true)) {
          $isDir = false;
          $errorWindow .= sprintf($langFile['PAGESETUP_CATEGORY_ERROR_CREATEDIR'],$adminConfig['realBasePath']);      
      // save category dir could be created
      } else
        $isDir = true;
    }      
    
    // finaly if category directory exists
    if($isDir) {         
      // add a new id to the category array
      $categoryConfig[$newId] = array('id' => $newId); // gives the new category a id  
      if(saveCategories($categoryConfig)) {
         $categoryInfo = $langFile['PAGESETUP_CATEGORY_TEXT_CREATECATEGORY_CREATED'];
         saveActivityLog(15); // <- SAVE the task in a LOG FILE
      } else { // throw error
        $errorWindow .= ($errorWindow) // if there is allready an warning
          ? '<br><br>'.sprintf($langFile['PAGESETUP_CATEGORY_ERROR_CREATECATEGORY'],$adminConfig['realBasePath'])
          : sprintf($langFile['PAGESETUP_CATEGORY_ERROR_CREATECATEGORY'],$adminConfig['realBasePath']); 
      }
    }
     
  } else // throw error
    $errorWindow .= sprintf($langFile['PAGESETUP_CATEGORY_ERROR_CREATECATEGORY'],$adminConfig['realBasePath']);
    
  $savedForm = 'categories';
  $savedSettings = true;
}

// ****** ---------- DELETE CATEGORY
if(((isset($_POST['send']) && $_POST['send'] ==  'categorySetup' && isset($_POST['deleteCategory'])) ||
   $_GET['status'] == 'deleteCategory') && isset($categoryConfig[$_GET['category']])) {  
  
  // save the name, to put it in the info
  $storedCategoryName = GeneralFunctions::getLocalized($categoryConfig[$_GET['category']],'name');

  // deletes the category with the given id from the array and saves the categoriesSettings.php
  unset($categoryConfig[$_GET['category']],$pageContent);  
  if(saveCategories($categoryConfig)) {
  
    // Hinweis für den Benutzer welche Gruppe gelöscht wurde
    $categoryInfo = $langFile['PAGESETUP_CATEGORY_TEXT_DELETECATEGORY_DELETED'].': '.$storedCategoryName;
  
    // if there is a category dir, trys to delete it !important deletes all files in it
    if(is_dir(dirname(__FILE__).'/../../pages/'.$_GET['category'])) {
    
      if($pageContents = GeneralFunctions::loadPages($_GET['category'])) {
      
        // deletes possible thumbnails before deleting the category
        foreach($pageContents as $page) {
          if(!empty($page['thumbnail']) && is_file(DOCUMENTROOT.$adminConfig['uploadPath'].$adminConfig['pageThumbnail']['path'].$page['thumbnail'])) {
            @chmod(DOCUMENTROOT.$adminConfig['uploadPath'].$adminConfig['pageThumbnail']['path'].$page['thumbnail'], $adminConfig['permissions']);          
            // DELETING    
            @unlink(DOCUMENTROOT.$adminConfig['uploadPath'].$adminConfig['pageThumbnail']['path'].$page['thumbnail']);
          }
        }
      }
      
      // deletes the dir with subdirs and files
      if(!GeneralFunctions::deleteFolder(dirname(__FILE__).'/../../pages/'.$_GET['category'].'/')) {
        $errorWindow .= ($errorWindow) // if there is allready an warning
          ? '<br><br>'.sprintf($langFile['PAGESETUP_CATEGORY_ERROR_DELETEDIR'],$adminConfig['realBasePath'])
          : sprintf($langFile['PAGESETUP_CATEGORY_ERROR_DELETEDIR'],$adminConfig['realBasePath']);
      }    
    }
    
    saveActivityLog(16,$storedCategoryName); // <- SAVE the task in a LOG FILE
  } else // throw error
    $errorWindow .= sprintf($langFile['PAGESETUP_CATEGORY_ERROR_DELETECATEGORY'],$adminConfig['realBasePath']);

  $savedForm = 'categories';
  $savedSettings = true;
}

// ****** ---------- MOVE CATEGORY
if(substr($_GET['status'],0,12) == 'moveCategory' && !empty($_GET['category']) && is_numeric($_GET['category'])) {
  
  // move the categories in the categories array
  if($_GET['status'] == 'moveCategoryUp')
    $direction = 'up';
  if($_GET['status'] == 'moveCategoryDown')
    $direction = 'down';
    
  if(moveCategories($categoryConfig,$_GET['category'],$direction)) {
  
    $categoryInfo = $langFile['PAGESETUP_CATEGORY_TEXT_MOVECATEGORY_MOVED'];
    
    // save the categories array
    if(saveCategories($categoryConfig)) {
      $documentSaved = true; // set documentSaved status
      saveActivityLog(17,'category='.$_GET['category']); // <- SAVE the task in a LOG FILE
    } else
      $errorWindow .= sprintf($langFile['PAGESETUP_CATEGORY_ERROR_SAVE'],$adminConfig['realBasePath']);
    
  }
    
  $savedForm = 'categories';
  $savedSettings = true;
}


// ****** ---------- SAVE CATEGORIES
if(isset($_POST['send']) && $_POST['send'] ==  'categorySetup' && isset($_POST['saveCategories'])) {
  
  

  // transfer data from the categoryConfig
  foreach($_POST['categories'] as $categoryId => $value) {
    $_POST['categories'][$categoryId]['plugins']         = serialize($value['plugins']);
    $_POST['categories'][$categoryId]['isSubCategory']   = $categoryConfig[$categoryId]['isSubCategory'];
    $_POST['categories'][$categoryId]['isSubCategoryOf'] = $categoryConfig[$categoryId]['isSubCategoryOf'];
    $_POST['categories'][$categoryId]['localized']       = $categoryConfig[$categoryId]['localized'];

    // STORE LOCALIZED CONTENT
    if(!empty($value['name']))
      $_POST['categories'][$categoryId]['localized'][$_POST['websiteLanguage']]['name'] = $value['name'];
    
    // delete unnecessary variables
    unset($_POST['categories'][$categoryId]['name']);
  }

  if(saveCategories($_POST['categories'])) {
    $documentSaved = true; // set documentSaved status
    saveActivityLog(18); // <- SAVE the task in a LOG FILE
    
  } else
    $errorWindow .= $langFile['PAGESETUP_CATEGORY_ERROR_SAVE'];
  
  $savedForm = 'categories';
  $savedSettings = true;
}


// RE-INCLUDE
if($savedSettings) {
  unset($adminConfig); $adminConfig = @include (dirname(__FILE__)."/../../config/admin.config.php");
  unset($categoryConfig); $categoryConfig = @include (dirname(__FILE__)."/../../config/category.config.php");
  // reload the $pagesMetaData array
  GeneralFunctions::savePagesMetaData();
  // RESET of the vars in the classes
  GeneralFunctions::$storedPages = null;
  GeneralFunctions::$adminConfig = $adminConfig;
  GeneralFunctions::$categoryConfig = $categoryConfig;
  StatisticFunctions::$adminConfig = $adminConfig;
  
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
  
  // -> delete old feeds
  clearFeeds();
  // ->> save the FEEDS for non-category pages, if activated
  saveFeeds(0);
  // ->> save the FEEDS for categories, if activated
  if(is_array($categoryConfig)) {
    foreach($categoryConfig as $category)
      saveFeeds($category['id']);
  }
  
  // ->> save the SITEMAP
  saveSitemap();
}
?>