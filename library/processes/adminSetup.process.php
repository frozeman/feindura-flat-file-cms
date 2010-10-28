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
  foreach($_POST as $postKey => $post) {
    
    if(strstr($postKey,'Path')) {
      if(!empty($post) && substr($post,-1) !== '/') {
        $post = $post.'/';        
      }
      $post = preg_replace("#/+#",'/',$post);
      
      $_POST[$postKey] = $post;
    }
  }
  
  // ** adds a "/" on the beginning of all absolute paths
  if(!empty($_POST['cfg_savePath']) && substr($_POST['cfg_savePath'],0,1) !== '/')
        $_POST['cfg_savePath'] = '/'.$_POST['cfg_savePath'];
  if(!empty($_POST['cfg_uploadPath']) && substr($_POST['cfg_uploadPath'],0,1) !== '/')
        $_POST['cfg_uploadPath'] = '/'.$_POST['cfg_uploadPath'];
  if(!empty($_POST['cfg_websitefilesPath']) && substr($_POST['cfg_websitefilesPath'],0,1) !== '/')
        $_POST['cfg_websitefilesPath'] = '/'.$_POST['cfg_websitefilesPath'];
  if(!empty($_POST['cfg_stylesheetPath']) && substr($_POST['cfg_stylesheetPath'],0,1) !== '/')
        $_POST['cfg_stylesheetPath'] = '/'.$_POST['cfg_stylesheetPath'];  
  
  // ->> add SPEAKING URL to .htaccess
  // --------------------------
    $speakingUrlCode = '<IfModule mod_rewrite.c>
RewriteEngine on
RewriteBase /
# rewrite "/page/*.html" and "/category/*/*.html"
# and also passes the session var
RewriteCond %{HTTP_HOST} ^'.str_replace(array('http://www.','https://www.'),'',$_SERVER["HTTP_HOST"]).'$ [OR]
RewriteCond %{HTTP_HOST} ^'.str_replace(array('http://','https://'),'',$_SERVER["HTTP_HOST"]).'$
RewriteRule ^category/([^/]+)/(.*)\.html?$ ?category=$1&page=$2$3 [QSA,L]
RewriteRule ^page/(.*)\.html?$ ?page=$1$2 [QSA,L]
</IfModule>';
    
  $htaccessFile = DOCUMENTROOT.'/.htaccess';
  
  // ** looks for the apache modules
  $apacheModules = (function_exists('apache_get_modules'))
  ? apache_get_modules()
  : array(false);
  
  // ** looks if the MOD_REWRITE modul exists
  if(!in_array('mod_rewrite',$apacheModules)) {
    $_POST['cfg_speakingUrl'] = '';
    //$errorWindow .= $langFile['adminSetup_fmsSettings_speakingUrl_error_modul'];
  // ** ->> looks for a .htacces file with the speaking url mod_rewrite
  } elseif($_POST['cfg_speakingUrl'] == 'true') {
    
    // -> looks if the existing .htaccess file has the SPEAKING URL code
    if(file_exists($htaccessFile)) {
      
      /*echo $htaccessFile;      
      echo file_get_contents($htaccessFile);      
      echo '<br>-----<br>'.$speakingUrlCode;
      */
      
      if(strstr(file_get_contents($htaccessFile),$speakingUrlCode) === false) {
        if($htaccess = fopen($htaccessFile,"a")) {
          flock($htaccess,2); // LOCK_EX
          fwrite($htaccess,"\n".$speakingUrlCode);
          flock($htaccess,3); //LOCK_UN
          fclose($htaccess);
        } else {
          $_POST['cfg_speakingUrl'] = '';
          $errorWindow .= $langFile['adminSetup_fmsSettings_speakingUrl_error_save'];
        }
      }
    // -> creates a NEW .htaccess file
    } else {
      if($htaccess = fopen($htaccessFile,"w")) {
        flock($htaccess,2); // LOCK_EX
        fwrite($htaccess,$speakingUrlCode);
        flock($htaccess,3); //LOCK_UN
        fclose($htaccess);
      } else {
        $_POST['cfg_speakingUrl'] = '';
        $errorWindow .= $langFile['adminSetup_fmsSettings_speakingUrl_error_save'];
      }
    }
    
  // ->> deletes the SPEAKING URL code if SPEAKING URL turned OFF
  } elseif($_POST['cfg_speakingUrl'] == '') {
    
    if(file_exists($htaccessFile)) {
      $currrentHtaccess = file_get_contents($htaccessFile);
      // if ONLY the SPEAKING URL code is in the .htaccess then DELTE the .htaccess file
      if($currrentHtaccess == $speakingUrlCode ||
         $currrentHtaccess == "\n".$speakingUrlCode ||
         $currrentHtaccess == "\n\n".$speakingUrlCode) {
        @unlink($htaccessFile);
           
      // looks if SPEAKING URL code EXISTs in the .htaccess file
      } elseif(strstr($currrentHtaccess,$speakingUrlCode)) {
        $newHtaccess = str_replace($speakingUrlCode,'',$currrentHtaccess);
        $newHtaccess = preg_replace("/ +/", ' ', $newHtaccess);
        $newHtaccess = preg_replace("/[\r\n]+/", "\n", $newHtaccess);
        
        if($htaccess = fopen($htaccessFile,"w")) {
          flock($htaccess,2); // LOCK_EX
          fwrite($htaccess,$newHtaccess);
          flock($htaccess,3); //LOCK_UN
          fclose($htaccess);
        } else {
          $errorWindow .= $langFile['adminSetup_fmsSettings_speakingUrl_error_save'];
        }
      }
    }
  }
  
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
  $adminConfig['savePath'] =  $_POST['cfg_savePath'];
  
  $adminConfig['uploadPath'] = $_POST['cfg_uploadPath'];  
  $adminConfig['websitefilesPath'] = $_POST['cfg_websitefilesPath'];
  $adminConfig['stylesheetPath'] = $_POST['cfg_stylesheetPath'];    
  $adminConfig['dateFormat'] = $_POST['cfg_dateFormat'];
  $adminConfig['speakingUrl'] = $_POST['cfg_speakingUrl'];
    
  $adminConfig['varName']['page'] = $_POST['cfg_varNamePage'];  
  $adminConfig['varName']['category'] = $_POST['cfg_varNameCategory'];  
  $adminConfig['varName']['modul'] = $_POST['cfg_varNameModul'];
  
  $adminConfig['user']['fileManager'] = $_POST['cfg_userFileManager'];
  $adminConfig['user']['editWebsiteFiles'] = $_POST['cfg_userWebsiteFiles'];
  $adminConfig['user']['editStylesheets'] = $_POST['cfg_userStylesheets'];  
  $adminConfig['user']['info'] = $_POST['cfg_userInfo'];
    
  // -> saved in pageSetup.php
  //$adminConfig['setStartPage'] = $_POST['cfg_setStartPage'];
  //$adminConfig['pages']['createdelete'] = $_POST['cfg_pageCreatePages'];
  //$adminConfig['pages']['thumbnails'] = $_POST['cfg_pageThumbnailUpload'];  
  //$adminConfig['pages']['plugins'] = $_POST['cfg_pagePlugins'];
  //$adminConfig['pages']['showtags'] = $_POST['cfg_pageTags'];

  $adminConfig['editor']['enterMode'] = strtolower($_POST['cfg_editorEnterMode']);
  $adminConfig['editor']['styleFile'] = prepareStyleFilePaths($_POST['cfg_editorStyleFile']);
  $adminConfig['editor']['styleId'] = $xssFilter->string(str_replace(array('#','.'),'',$_POST['cfg_editorStyleId']));  
  $adminConfig['editor']['styleClass'] = $xssFilter->string(str_replace(array('#','.'),'',$_POST['cfg_editorStyleClass']));  
  
  // -> saved in pageSetup.php
  //$adminConfig['pageThumbnail']['width'] =  $_POST['cfg_thumbWidth'];
  //$adminConfig['pageThumbnail']['height'] = $_POST['cfg_thumbHeight'];
  //$adminConfig['pageThumbnail']['ratio'] = $_POST['cfg_thumbRatio'];
  //$adminConfig['pageThumbnail']['path'] = $_POST['cfg_thumbPath'];
  
  // **** opens admin.config.php for writing
  if(saveAdminConfig($adminConfig)) {
     
    // give documentSaved status
    $documentSaved = true;
    $statisticFunctions->saveTaskLog(8); // <- SAVE the task in a LOG FILE
    
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
    $statisticFunctions->saveTaskLog(9); // <- SAVE the task in a LOG FILE
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
$generalFunctions->adminConfig = $adminConfig;
$statisticFunctions->adminConfig = $adminConfig;
$generalFunctions->categoryConfig = $categoryConfig;
$statisticFunctions->categoryConfig = $categoryConfig;
$generalFunctions->storedPageIds = null;
$generalFunctions->storedPages = null;

?>