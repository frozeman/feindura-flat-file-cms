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

* processes/pageSetup.process.php version 1.22
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
  addSlashesToPOSTPaths($_POST);
  
  // ** removes a "/" on the beginning of all relative paths
  if(!empty($_POST['cfg_thumbPath']) && substr($_POST['cfg_thumbPath'],0,1) == '/')
        $_POST['cfg_thumbPath'] = substr($_POST['cfg_thumbPath'],1);
  
  // -> CHECK if the THUMBNAIL HEIGHT/WIDTH is empty, and add the previous ones
  if(!isset($_POST['cfg_thumbWidth']))
    $_POST['cfg_thumbWidth'] = $adminConfig['pageThumbnail']['width'];
  if(!isset($_POST['cfg_thumbHeight']))
    $_POST['cfg_thumbHeight'] = $adminConfig['pageThumbnail']['height'];   
  
  // -> PREPARE CONFIG VARs
  $newAdminConfig = $adminConfig;
  $newAdminConfig['setStartPage'] = $_POST['cfg_setStartPage'];
  $newAdminConfig['pages']['createDelete'] = $_POST['cfg_pageCreatePages'];
  $newAdminConfig['pages']['thumbnails'] = $_POST['cfg_pageThumbnailUpload'];  
  $newAdminConfig['pages']['plugins'] = serialize($_POST['cfg_pagePlugins']);
  $newAdminConfig['pages']['showTags'] = $_POST['cfg_pageTags'];
  $newAdminConfig['pages']['showPageDate'] = $_POST['cfg_pagePageDate'];
  $newAdminConfig['pages']['feeds'] = $_POST['cfg_pagefeeds'];
  $newAdminConfig['pages']['sorting'] = $_POST['cfg_pageSorting'];
  $newAdminConfig['pages']['sortReverse'] = $_POST['cfg_pageSortReverse'];
  
  $newAdminConfig['pageThumbnail']['width'] =  $_POST['cfg_thumbWidth'];
  $newAdminConfig['pageThumbnail']['height'] = $_POST['cfg_thumbHeight'];
  $newAdminConfig['pageThumbnail']['ratio'] = $_POST['cfg_thumbRatio'];
  $newAdminConfig['pageThumbnail']['path'] = $_POST['cfg_thumbPath'];
  
  // **** opens admin.config.php for writing
  if(saveAdminConfig($newAdminConfig)) {
     
    // give documentSaved status
    $documentSaved = true;
    statisticFunctions::saveTaskLog(14); // <- SAVE the task in a LOG FILE
    
  } else
    $errorWindow .= $langFile['ADMINSETUP_GENERAL_error_save'];
  
  $savedForm = $_POST['savedBlock'];
  $savedSettings = true;
}

// ---------------------------------------------------------------------------------------------------
// ****** ---------- SAVE CATEGORY CONFIG in config/category.config.php

// ****** ---------- CREATE NEW CATEGORY
if((isset($_POST['send']) && $_POST['send'] ==  'categorySetup' && isset($_POST['createCategory'])) ||
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
          $errorWindow .= $langFile['PAGESETUP_CATEGORY_ERROR_CREATEDIR'];      
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
         statisticFunctions::saveTaskLog(15); // <- SAVE the task in a LOG FILE
      } else { // throw error
        $errorWindow .= ($errorWindow) // if there is allready an warning
          ? '<br /><br />'.$langFile['PAGESETUP_CATEGORY_ERROR_CREATECATEGORY']
          : $langFile['PAGESETUP_CATEGORY_ERROR_CREATECATEGORY']; 
      }
    }
     
  } else // throw error
    $errorWindow .= $langFile['PAGESETUP_CATEGORY_ERROR_CREATECATEGORY'];
    
  $savedForm = 'categories';
  $savedSettings = true;
}

// ****** ---------- DELETE CATEGORY
if(((isset($_POST['send']) && $_POST['send'] ==  'categorySetup' && isset($_POST['deleteCategory'])) ||
   $_GET['status'] == 'deleteCategory') && isset($categoryConfig[$_GET['category']])) {  
  
  // save the name, to put it in the info
  $storedCategoryName = $categoryConfig[$_GET['category']]['name'];
  
  // deletes the category with the given id from the array and saves the categoriesSettings.php
  unset($categoryConfig[$_GET['category']]);  
  if(saveCategories($categoryConfig)) {
  
    // Hinweis für den Benutzer welche Gruppe gelöscht wurde
    $categoryInfo = $langFile['PAGESETUP_CATEGORY_TEXT_DELETECATEGORY_DELETED'].': '.$storedCategoryName;
  
    // if there is a category dir, trys to delete it !important deletes all files in it
    if(is_dir(dirname(__FILE__).'/../../pages/'.$_GET['category'])) {
    
      if($pageContents = generalFunctions::loadPages($_GET['category'],true)) {
      
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
      if(!delDir(dirname(__FILE__).'/../../pages/'.$_GET['category'].'/')) {
        $errorWindow .= ($errorWindow) // if there is allready an warning
          ? '<br /><br />'.$langFile['PAGESETUP_CATEGORY_ERROR_DELETEDIR']
          : $langFile['PAGESETUP_CATEGORY_ERROR_DELETEDIR'];
      }    
    }
    
    statisticFunctions::saveTaskLog(16,$storedCategoryName); // <- SAVE the task in a LOG FILE
  } else // throw error
    $errorWindow .= $langFile['PAGESETUP_CATEGORY_ERROR_DELETECATEGORY'];

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
      statisticFunctions::saveTaskLog(17,'category='.$_GET['category']); // <- SAVE the task in a LOG FILE
    } else
      $errorWindow .= $langFile['PAGESETUP_CATEGORY_ERROR_SAVE'];
    
  }
    
  $savedForm = 'categories';
  $savedSettings = true;
}


// ****** ---------- SAVE CATEGORIES
if(isset($_POST['send']) && $_POST['send'] ==  'categorySetup' && isset($_POST['saveCategories'])) {
  
  // serialize the plugins array
  foreach($_POST['categories'] as $key => $value)
    $_POST['categories'][$key]['plugins'] = serialize($value['plugins']);
  
  if(saveCategories($_POST['categories'])) {
    $documentSaved = true; // set documentSaved status
    statisticFunctions::saveTaskLog(18); // <- SAVE the task in a LOG FILE
  } else
    $errorWindow .= $langFile['PAGESETUP_CATEGORY_ERROR_SAVE'];
  
  $savedForm = 'categories';
  $savedSettings = true;
}


// RE-INCLUDE
if($savedSettings) {
  $adminConfig = @include (dirname(__FILE__)."/../../config/admin.config.php");
  $categoryConfig = @include (dirname(__FILE__)."/../../config/category.config.php");
  // RESET of the vars in the classes
  generalFunctions::$storedPageIds = null;
  generalFunctions::$storedPages = null;
  generalFunctions::$adminConfig = $adminConfig;
  generalFunctions::$categoryConfig = $categoryConfig;
  statisticFunctions::$adminConfig = $adminConfig;
  statisticFunctions::$categoryConfig = $categoryConfig;
}
?>