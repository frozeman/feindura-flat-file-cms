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
 * Includes the login and filters the incoming data by xssFilter
 */
require_once(dirname(__FILE__)."/../includes/secure.include.php");

// VARs
$categoryInfo = false;

// ---------------------------------------------------------------------------------------------------
// ****** ---------- SAVE PAGE CONFIG in config/admin.config.php
if(isset($_POST['send']) && $_POST['send'] ==  'pageConfig') {
  
  // ** removes a "/" on the beginning of all relative paths
  if(!empty($_POST['cfg_thumbPath']) && substr($_POST['cfg_thumbPath'],0,1) == '/')
        $_POST['cfg_thumbPath'] = substr($_POST['cfg_thumbPath'],1);
  
  // -> CHECK if the THUMBNAIL HEIGHT/WIDTH is empty, and add the previous ones
  if(!isset($_POST['cfg_thumbWidth']))
    $_POST['cfg_thumbWidth'] = $adminConfig['pageThumbnail']['width'];
  if(!isset($_POST['cfg_thumbHeight']))
    $_POST['cfg_thumbHeight'] = $adminConfig['pageThumbnail']['height'];   
  
  // -> PREPARE CONFIG VARs
  $adminConfig['setStartPage'] = $_POST['cfg_setStartPage'];
  $adminConfig['pages']['createdelete'] = $_POST['cfg_pageCreatePages'];
  $adminConfig['pages']['thumbnails'] = $_POST['cfg_pageThumbnailUpload'];  
  $adminConfig['pages']['plugins'] = $_POST['cfg_pagePlugins'];
  $adminConfig['pages']['showtags'] = $_POST['cfg_pageTags'];
  
  $adminConfig['pageThumbnail']['width'] =  $_POST['cfg_thumbWidth'];
  $adminConfig['pageThumbnail']['height'] = $_POST['cfg_thumbHeight'];
  $adminConfig['pageThumbnail']['ratio'] = $_POST['cfg_thumbRatio'];
  $adminConfig['pageThumbnail']['path'] = $_POST['cfg_thumbPath'];
  
  // **** opens admin.config.php for writing
  if(saveAdminConfig($adminConfig)) {
     
    // give documentSaved status
    $documentSaved = true;
    statisticFunctions::saveTaskLog(14); // <- SAVE the task in a LOG FILE
    
  } else
    $errorWindow .= $langFile['adminSetup_fmsSettings_error_save'];
  
  $savedForm = $_POST['savedBlock'];
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
    if(@is_dir(DOCUMENTROOT.$adminConfig['basePath'].'pages/'.$newId)) {
      $isDir = true;
    } else {
      // erstellt ein verzeichnis
      if(!@mkdir(DOCUMENTROOT.$adminConfig['basePath'].'pages/'.$newId, PERMISSIONS) ||
         !@chmod(DOCUMENTROOT.$adminConfig['basePath'].'pages/'.$newId, PERMISSIONS)) {
          $isDir = false;
          $errorWindow .= $langFile['pageSetup_error_createDir'];      
      // save category dir could be created
      } else
        $isDir = true;
    }      
    
    // finaly if category directory exists
    if($isDir) {         
      // add a new id to the category array
      $categoryConfig[$newId] = array('id' => $newId); // gives the new category a id  
      if(saveCategories($categoryConfig)) {
         $categoryInfo = $langFile['pageSetup_createCategory_created'];
         statisticFunctions::saveTaskLog(15); // <- SAVE the task in a LOG FILE
      } else { // throw error
        $errorWindow .= ($errorWindow) // if there is allready an warning
          ? '<br /><br />'.$langFile['pageSetup_error_create']
          : $langFile['pageSetup_error_create']; 
      }
    }
     
  } else // throw error
    $errorWindow .= $langFile['pageSetup_error_create'];
    
  $savedForm = 'categories';
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
    $categoryInfo = $langFile['pageSetup_deleteCategory_deleted'].': '.$storedCategoryName;
  
    // if there is a category dir, trys to delete it !important deletes all files in it
    if(is_dir(DOCUMENTROOT.$adminConfig['basePath'].'pages/'.$_GET['category'])) {
    
      if($pageContents = generalFunctions::loadPages($_GET['category'],true)) {
      
        // deletes possible thumbnails before deleting the category
        foreach($pageContents as $page) {
          if(!empty($page['thumbnail']) && is_file(DOCUMENTROOT.$adminConfig['uploadPath'].$adminConfig['pageThumbnail']['path'].$page['thumbnail'])) {
            @chmod(DOCUMENTROOT.$adminConfig['uploadPath'].$adminConfig['pageThumbnail']['path'].$page['thumbnail'], PERMISSIONS);          
            // DELETING    
            @unlink(DOCUMENTROOT.$adminConfig['uploadPath'].$adminConfig['pageThumbnail']['path'].$page['thumbnail']);
          }
        }
      }
      
      // deletes the dir with subdirs and files
      if(!delDir($adminConfig['basePath'].'pages/'.$_GET['category'].'/')) {
        $errorWindow .= ($errorWindow) // if there is allready an warning
          ? '<br /><br />'.$langFile['pageSetup_error_deleteDir']
          : $langFile['pageSetup_error_deleteDir'];
      }    
    }
    
    statisticFunctions::saveTaskLog(16,$storedCategoryName); // <- SAVE the task in a LOG FILE
  } else // throw error
    $errorWindow .= $langFile['pageSetup_error_delete'];

  $savedForm = 'categories';
}

// ****** ---------- MOVE CATEGORY
if(substr($_GET['status'],0,12) == 'moveCategory' && !empty($_GET['category']) && is_numeric($_GET['category'])) {
  
  // move the categories in the categories array
  if($_GET['status'] == 'moveCategoryUp')
    $direction = 'up';
  if($_GET['status'] == 'moveCategoryDown')
    $direction = 'down';
    
  if(moveCategories($categoryConfig,$_GET['category'],$direction)) {
  
    $categoryInfo = $langFile['pageSetup_moveCategory_moved'];
    
    // save the categories array
    if(saveCategories($categoryConfig)) {
      $documentSaved = true; // set documentSaved status
      statisticFunctions::saveTaskLog(17,'category='.$_GET['category']); // <- SAVE the task in a LOG FILE
    } else
      $errorWindow .= $langFile['pageSetup_error_save'];
    
  }
    
  $savedForm = 'categories';
}


// ****** ---------- SAVE CATEGORIES
if(isset($_POST['send']) && $_POST['send'] ==  'categorySetup' && isset($_POST['saveCategories'])) {
  
  // cleans the category names
  $catewgoriesCleaned = array();
  foreach($_POST['categories'] as $category) {
      $category['name'] = generalFunctions::prepareStringInput($category['name']);
      $categoriesCleaned[$category['id']] = $category;
  }

  if(saveCategories($categoriesCleaned)) {
    $documentSaved = true; // set documentSaved status
    statisticFunctions::saveTaskLog(18); // <- SAVE the task in a LOG FILE
  } else
    $errorWindow .= $langFile['pageSetup_error_save'];
  
  $savedForm = 'categories';
}


// RE-INCLUDE
$adminConfig = @include (dirname(__FILE__)."/../../config/admin.config.php");
$categoryConfig = @include (dirname(__FILE__)."/../../config/category.config.php");
// RESET of the vars in the classes
generalFunctions::$storedPageIds = null;
generalFunctions::$storedPages = null;
generalFunctions::$adminConfig = $adminConfig;
generalFunctions::$categoryConfig = $categoryConfig;
statisticFunctions::$adminConfig = $adminConfig;
statisticFunctions::$categoryConfig = $categoryConfig;

?>