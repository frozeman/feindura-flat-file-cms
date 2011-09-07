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
  
  // format tags  
  //$_POST['tags'] = str_replace(array(',',';'), ' ', $_POST['tags']);
  $_POST['tags'] = preg_replace("/ +/", ' ', $_POST['tags']);
  
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
    $category = $_POST['categoryId'];
    $_GET['category'] = $category;
    $_POST['category'] = $category;
    $pageContent['category'] = $category;
    
    $logText = 0;
    
    GeneralFunctions::$storedPageIds = null; // set storedPageIds to null so the page IDs will be reloaded next time
    
  // *** SAVE PAGE ----------------------
  } else {
  
    // if flatfile exists, load $pageContent array
    // (necessary for: thumbnail, sortOrder and logs)
    if(!$pageContent = GeneralFunctions::readPage($page,$category))
      $errorWindow .= $langFile['file_error_read'];
   
    $logText = 1; 
  }
  
  // only save page if no error occured
  if($errorWindow === false) {
  
    // speichert den inhalt in der flatfile
    $_POST['lastSaveDate'] = time();
    $_POST['lastSaveAuthor'] = $_SESSION['feinduraSession']['login']['username'];
    $_POST['content'] = $_POST['HTMLEditor'];
    $_POST['thumbnail'] = $pageContent['thumbnail'];
    
    // generates pageDate
    if(!empty($_POST['pageDate']['day']) && !empty($_POST['pageDate']['month']))
    $generatedPageDate = $_POST['pageDate']['year'].'-'.$_POST['pageDate']['month'].'-'.$_POST['pageDate']['day'];
    
    // VALIDATE the SORT DATE
    if(($pageDate = StatisticFunctions::validateDateFormat($generatedPageDate)) === false)
      $pageDate = $generatedPageDate;
    // if VALID set the validated date to the post var
    else {
      $_POST['pageDate']['date'] = $pageDate;
      unset($pageDate);
    }
    
    //echo '<br />'.$_POST['pageDate']['before'];
    //echo '<br />'.$_POST['pageDate']['date'];
    
    if(empty($_POST['sortOrder']))  $_POST['sortOrder'] = $pageContent['sortOrder'];
    
    // adds absolute path slash on the beginning and implode the stylefiles
    $_POST['styleFile'] = prepareStyleFilePaths($_POST['styleFile']);
    
    // bubbles through the page, category and adminConfig to see if it should save the styleheet-file path, id or class-attribute
    $_POST['styleFile'] = setStylesByPriority($_POST['styleFile'],'styleFile',$category);
    $_POST['styleId'] = setStylesByPriority($_POST['styleId'],'styleId',$category);
    $_POST['styleClass'] = setStylesByPriority($_POST['styleClass'],'styleClass',$category);
    
    if(GeneralFunctions::savePage($_POST)) {
      $documentSaved = true;
      StatisticFunctions::saveTaskLog($logText,'page='.$page); // <- SAVE the task in a LOG FILE
      
      // set PERMISSIONS of the page
      $filePath = ($pageContent['category'] == 0)
        ? dirname(__FILE__).'/../../pages/'.$pageContent['id'].'.php'
        : dirname(__FILE__).'/../../pages/'.$pageContent['category'].'/'.$pageContent['id'].'.php';
      chmod($filePath, $adminConfig['permissions']);
      
      // ->> save the FEEDS, if activated
      GeneralFunctions::saveFeeds($pageContent['category']);
      // ->> save the SITEMAP
      GeneralFunctions::saveSitemap();
      
    } else
      $errorWindow .= $langFile['editor_savepage_error_save'];
  }
  
  // sets which block should be opend after saving
  $savedForm = $_POST['savedBlock'];
}

// ->> LOAD PAGE and CHECK for NEW PAGE
if($pageContent = GeneralFunctions::readPage($page,$category))
  $newPage = false;
else
  $newPage = true;

// -> set Title
if($newPage) {
  //$pageContent = '';  
  $pageTitle = $langFile['editor_h1_createpage'];
  $_GET['page'] = 'new';
  $page = 'new';
  
} else {  
  $pageTitle = strip_tags($pageContent['title']);
}

// -> check if the thumbnail still exists, if not clear the thumbnail state of the file
if(!file_exists(DOCUMENTROOT.$adminConfig['uploadPath'].$adminConfig['pageThumbnail']['path'].$pageContent['thumbnail']) && isBlocked() === false) {
  $pageContent['thumbnail'] = '';
  GeneralFunctions::savePage($pageContent);
}

?>