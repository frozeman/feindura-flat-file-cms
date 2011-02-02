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

* processes/adminSetup.process.php version 2.36
*/

/**
 * Includes the login and filters the incoming data by xssFilter
 */
require_once(dirname(__FILE__)."/../includes/secure.include.php");

// ****** ---------- SAVE ADMIN CONFIG in config/admin.config.php
if(isset($_POST['send']) && $_POST['send'] ==  'adminSetup') {
  
  // ** ensure the the post vars with a 'Path' in the key value ending with a '/'
  addSlashToPathsEnd($_POST);
  
  // ** adds a "/" on the beginning of all absolute paths
  if(!empty($_POST['cfg_websitePath']) && substr($_POST['cfg_websitePath'],0,1) !== '/')
        $_POST['cfg_websitePath'] = '/'.$_POST['cfg_websitePath'];
  if(!empty($_POST['cfg_uploadPath']) && substr($_POST['cfg_uploadPath'],0,1) !== '/')
        $_POST['cfg_uploadPath'] = '/'.$_POST['cfg_uploadPath'];
  if(!empty($_POST['cfg_websiteFilesPath']) && substr($_POST['cfg_websiteFilesPath'],0,1) !== '/')
        $_POST['cfg_websiteFilesPath'] = '/'.$_POST['cfg_websiteFilesPath'];
  if(!empty($_POST['cfg_stylesheetPath']) && substr($_POST['cfg_stylesheetPath'],0,1) !== '/')
        $_POST['cfg_stylesheetPath'] = '/'.$_POST['cfg_stylesheetPath'];  
  
  // ->> add SPEAKING URL to .htaccess
  // --------------------------
  saveSpeakingUrl($errorWindow);
  
  // -> CHECK if the VARNAMES are EMPTY, and add the previous ones, if speaking url = true
  if($_POST['cfg_speakingUrl'] == 'true') {
    if(!isset($_POST['cfg_varNamePage']))
      $_POST['cfg_varNamePage'] = $adminConfig['varName']['page'];
    if(!isset($_POST['cfg_varNameCategory']))
      $_POST['cfg_varNameCategory'] = $adminConfig['varName']['category'];
    if(!isset($_POST['cfg_varNameModul']))
      $_POST['cfg_varNameModul'] = $adminConfig['varName']['modul'];
  } else {
    if(empty($_POST['cfg_varNamePage']))
      $_POST['cfg_varNamePage'] = 'page';
    if(empty($_POST['cfg_varNameCategory']))
      $_POST['cfg_varNameCategory'] = 'category';
    if(empty($_POST['cfg_varNameModul']))
      $_POST['cfg_varNameModul'] = 'modul';
  }
  
  // -> CHANGE HTMLENTITIES from the USER-INFO
  $_POST['cfg_userInfo'] = nl2br(stripslashes(htmlentities($_POST['cfg_userInfo'],ENT_QUOTES, 'UTF-8')));
  $_POST['cfg_userInfo'] = str_replace('&lt;','<',$_POST['cfg_userInfo']);
  $_POST['cfg_userInfo'] = str_replace('&gt;','>',$_POST['cfg_userInfo']);
  $_POST['cfg_userInfo'] = str_replace('&quot;','"',$_POST['cfg_userInfo']);
  
  // -> CLEAN all " out of the strings
  foreach($_POST as $postKey => $post) {    
    $_POST[$postKey] = str_replace(array('\"',"\'"),'',$post);
  }
  
  // -> PREPARE CONFIG VARs
    $hostProtocol = (empty($_SERVER["HTTPS"]) || $_SERVER["HTTPS"] == 'off') ? 'http://' : 'https://';
  $adminConfig['url'] = $hostProtocol.$_SERVER["HTTP_HOST"];
  $adminConfig['basePath'] = (substr(dirname($_SERVER['PHP_SELF']),-1) == '/')
  ? dirname($_SERVER['PHP_SELF'])
  : dirname($_SERVER['PHP_SELF']).'/';
  $adminConfig['websitePath'] =  $_POST['cfg_websitePath'];
  
  $adminConfig['uploadPath'] = $_POST['cfg_uploadPath'];  
  $adminConfig['websiteFilesPath'] = $_POST['cfg_websiteFilesPath'];
  $adminConfig['stylesheetPath'] = $_POST['cfg_stylesheetPath'];
  $adminConfig['timeZone'] = $_POST['cfg_timeZone'];
  $adminConfig['dateFormat'] = $_POST['cfg_dateFormat'];
  $adminConfig['speakingUrl'] = $_POST['cfg_speakingUrl'];
    
  $adminConfig['varName']['page'] = $_POST['cfg_varNamePage'];  
  $adminConfig['varName']['category'] = $_POST['cfg_varNameCategory'];  
  $adminConfig['varName']['modul'] = $_POST['cfg_varNameModul'];
  
  $adminConfig['user']['fileManager'] = $_POST['cfg_userFileManager'];
  $adminConfig['user']['editWebsiteFiles'] = $_POST['cfg_userWebsiteFiles'];
  $adminConfig['user']['editStyleSheets'] = $_POST['cfg_userStylesheets'];  
  $adminConfig['user']['info'] = $_POST['cfg_userInfo'];
    
  // -> saved in pageSetup.php
  //$adminConfig['setStartPage'] = $_POST['cfg_setStartPage'];
  //$adminConfig['pages']['createDelete'] = $_POST['cfg_pageCreatePages'];
  //$adminConfig['pages']['thumbnails'] = $_POST['cfg_pageThumbnailUpload'];  
  //$adminConfig['pages']['plugins'] = $_POST['cfg_pagePlugins'];
  //$adminConfig['pages']['showTags'] = $_POST['cfg_pageTags'];

  $adminConfig['editor']['enterMode'] = strtolower($_POST['cfg_editorEnterMode']);
  $adminConfig['editor']['styleFile'] = prepareStyleFilePaths($_POST['cfg_editorStyleFile']);
  $adminConfig['editor']['styleId'] = str_replace(array('#','.'),'',$_POST['cfg_editorStyleId']);  
  $adminConfig['editor']['styleClass'] = str_replace(array('#','.'),'',$_POST['cfg_editorStyleClass']);  
  
  // -> saved in pageSetup.php
  //$adminConfig['pageThumbnail']['width'] =  $_POST['cfg_thumbWidth'];
  //$adminConfig['pageThumbnail']['height'] = $_POST['cfg_thumbHeight'];
  //$adminConfig['pageThumbnail']['ratio'] = $_POST['cfg_thumbRatio'];
  //$adminConfig['pageThumbnail']['path'] = $_POST['cfg_thumbPath'];
  
  // **** opens admin.config.php for writing
  if(saveAdminConfig($adminConfig)) {
     
    // give documentSaved status
    $documentSaved = true;
    statisticFunctions::saveTaskLog(8); // <- SAVE the task in a LOG FILE
    
  } else
    $errorWindow .= $langFile['adminSetup_fmsSettings_error_save'];
  
  $savedForm = $_POST['savedBlock'];

}

// ---------- Speichern in fckstyles.xml
if(isset($_POST['saveFckStyleFile'])) {

  $fckstylewrite = $_POST['fckStyleFile'];
  
  $fckstylewrite 	= str_replace('\"', '"', $fckstylewrite);
  $fckstylewrite 	= str_replace("\'", "'", $fckstylewrite);
  $fckstylewrite 	= stripslashes($fckstylewrite);
  
  if($file = fopen("config/htmlEditorStyles.js","w")) {
    flock($file,2);
    fwrite($file,$fckstylewrite);
    flock($file,3);
    fclose($file);
  
    // give documentSaved status
    $documentSaved = true;
    statisticFunctions::saveTaskLog(9); // <- SAVE the task in a LOG FILE
  } else {
    $errorWindow .= $langFile['adminSetup_styleFileSettings_error_save'];
  }
  
  $savedForm = 'fckStyleFile';
}

// ---------- SAVE the editFiles
include_once(dirname(__FILE__).'/../processes/saveEditFiles.process.php');

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