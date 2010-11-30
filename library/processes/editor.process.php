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
    
* processes/editor.process.php version 1.97
*/

/**
 * Includes the login and filters the incoming data by xssFilter
 */
require_once(dirname(__FILE__)."/../includes/secure.include.php");

// VARs
// -----------------------------------------------------------------------------
$page	= $_GET['page'];
$category = $_GET['category'];


// SAVE the PAGE
// -----------------------------------------------------------------------------
if($_POST['save']) {
  
  // vars
  $page	= $_POST['id'];
  $category = $_POST['category'];
  $_GET['page'] = $page;
  $_GET['category'] = $category;  
  
  // format tags  
  $_POST['tags'] = str_replace(array(',',';'), ' ', $_POST['tags']);
  $_POST['tags'] = preg_replace("/ +/", ' ', $_POST['tags']);
  $_POST['tags'] = htmlentities($_POST['tags'], ENT_QUOTES, 'UTF-8');
  
  $_POST['title'] = generalFunctions::prepareStringInput($_POST['title']);
  
  $_POST['description'] = generalFunctions::prepareStringInput($_POST['description']);
  
  // removes double whitespaces and slashes
  $_POST['HTMLEditor'] = preg_replace("/ +/", ' ', $_POST['HTMLEditor'] );
  //$_POST['HTMLEditor'] = str_replace("'", "\'", $_POST['HTMLEditor'] ); //&#039;
  
  
  // *** CREATE NEW PAGE ----------------------
  if ($page == 'new') {
    
    // looks fore the highest id (FLATFILES)
    $page = getNewPageId();
    $_POST['id'] = $page;
    $_POST['sortorder'] = $page;
    $_GET['page'] = $page;
    
    // sets the selected category
    $category = $_POST['categoryId'];
    $_GET['category'] = $category;
    $_POST['category'] = $category;       
  
    $pageContent['log_visitorcount'] = 0;
    
    $logText = 0;
    
    generalFunctions::$storedPageIds = null; // set storedPageIds to null so the page IDs will be reloaded next time
    
  // *** SAVE PAGE ----------------------
  } else {
  
    // if flatfile exists, load $pageContent array
    // (necessary for: thumbnail, sortorder and logs)
    if(!$pageContent = generalFunctions::readPage($page,$category))
      $errorWindow .= $langFile['file_error_read'];
   
    $logText = 1; 
  }
  
  // only save page if no error occured
  if($errorWindow === false) {
  
    // speichert den inhalt in der flatfile
    $_POST['lastsavedate'] = time();
    $_POST['lastsaveauthor'] = $_SESSION['feinduraLogin'][IDENTITY]['username'];
    $_POST['content'] = $_POST['HTMLEditor'];
    $_POST['thumbnail'] = $pageContent['thumbnail'];
    
    // generates pagedate
    if(!empty($_POST['pagedate']['day']) && !empty($_POST['pagedate']['month']))
    $generatedPageDate = $_POST['pagedate']['year'].'-'.$_POST['pagedate']['month'].'-'.$_POST['pagedate']['day'];
    
    // VALIDATE the SORT DATE
    if(($pageDate = statisticFunctions::validateDateFormat($generatedPageDate)) === false)
      $pageDate = $generatedPageDate;
    // if VALID set the validated date to the post var
    else {
      $_POST['pagedate']['date'] = $pageDate;
      unset($pageDate);
    }
    
    //echo '<br />'.$_POST['pagedate']['before'];
    //echo '<br />'.$_POST['pagedate']['date'];
    
    if(empty($_POST['sortorder']))
      $_POST['sortorder'] = $pageContent['sortorder'];
    
    // adds absolute path slash on the beginning and implode the stylefiles
    $_POST['styleFile'] = prepareStyleFilePaths($_POST['styleFile']);
    
    // bubbles through the page, category and adminConfig to see if it should save the styleheet-file path, id or class-attribute
    $_POST['styleFile'] = setStylesByPriority($_POST['styleFile'],'styleFile',$category);
    $_POST['styleId'] = setStylesByPriority(xssFilter::string($_POST['styleId']),'styleId',$category);
    $_POST['styleClass'] = setStylesByPriority(xssFilter::string($_POST['styleClass']),'styleClass',$category);
    
    // gets the visit status
    $_POST['log_visitorcount'] = $pageContent['log_visitorcount'];
    $_POST['log_visitTime_max'] = $pageContent['log_visitTime_max'];
    $_POST['log_visitTime_min'] = $pageContent['log_visitTime_min'];
    $_POST['log_lastVisit'] = $pageContent['log_lastVisit'];
    $_POST['log_firstVisit'] = $pageContent['log_firstVisit'];
    $_POST['log_lastIP'] = $pageContent['log_lastIP'];
    $_POST['log_searchwords'] = $pageContent['log_searchwords'];
      
    if(generalFunctions::savePage($_POST)) {
      $documentSaved = true;
      statisticFunctions::saveTaskLog($logText,'page='.$page); // <- SAVE the task in a LOG FILE
    } else
      $errorWindow .= $langFile['editor_savepage_error_save'];
  }
  
  // sets which block should be opend after saving
  $savedForm = $_POST['savedBlock'];
}

// ->> LOAD PAGE and CHECK for NEW PAGE
if($pageContent = generalFunctions::readPage($page,$category))
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
  $pageTitle = $pageContent['title'];  
}

?>