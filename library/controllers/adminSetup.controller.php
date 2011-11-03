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

* controllers/adminSetup.controller.php version 2.36
*/

/**
 * Includes the login.include.php and backend.include.php and filter the basic data
 */
require_once(dirname(__FILE__)."/../includes/secure.include.php");

// ****** ---------- SAVE ADMIN CONFIG in config/admin.config.php
if(isset($_POST['send']) && $_POST['send'] ==  'adminSetup') {
  
  $checkBasePathAndURL = checkBasePathAndURL();
  
  // ** ensure the the post vars with a 'Path' in the key value ending with a '/'
  $_POST = addSlashesToPaths($_POST);
  $_POST = removeDocumentRootFromPaths($_POST);
  
  // ** ensure that the website path with a filename, doesnt have aslahs on the end
  if(!empty($_POST['cfg_websitePath']) && strpos($_POST['cfg_websitePath'],'.') !== false)
    $_POST['cfg_websitePath'] = substr($_POST['cfg_websitePath'],0,-1);

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
  
  // -> check Filter settings
  if(empty($_POST['cfg_editorHtmlLawed']))
    unset($_POST['cfg_editorSafeHtml']);
  
  // -> add <br> to the USER-INFO and check html code
  $_POST['cfg_userInfo'] = nl2br($_POST['cfg_userInfo']);
  $_POST['cfg_userInfo'] = GeneralFunctions::htmLawed($_POST['cfg_userInfo'],array(
    'comment'=> 1,
    'cdata'=> 1,
    'safe'=> 1
  ));
  
  // -> CLEAN all " out of the strings
  foreach($_POST as $postKey => $post)
    $_POST[$postKey] = str_replace(array('\"',"\'"),'',$post);
  
  // -> PREPARE CONFIG VARs
  $serverProtocol = strtolower(substr($_SERVER["SERVER_PROTOCOL"],0,strpos($_SERVER["SERVER_PROTOCOL"],'/'))).((empty($_SERVER["HTTPS"])) ? '' : ($_SERVER["HTTPS"] == "on") ? "s" : "");
  
  $adminConfig['url'] = $serverProtocol."://".$_SERVER['SERVER_NAME'];
  $adminConfig['basePath'] = preg_replace('#/+#','/',dirname($_SERVER['PHP_SELF']).'/');
  
  // set the REAL BASE PATH
  if((empty($adminConfig['realBasePath']) || !$checkBasePathAndURL) && !isset($_POST['cfg_realBasePath'])) {
    $_POST['cfg_realBasePath'] = $adminConfig['basePath'];
  }
  
  $adminConfig['realBasePath'] = $_POST['cfg_realBasePath'];
  $adminConfig['websitePath'] =  $_POST['cfg_websitePath'];
  
  $adminConfig['uploadPath'] = $_POST['cfg_uploadPath'];  
  $adminConfig['websiteFilesPath'] = $_POST['cfg_websiteFilesPath'];
  $adminConfig['stylesheetPath'] = $_POST['cfg_stylesheetPath'];
  
  $adminConfig['permissions'] = $_POST['cfg_permissions'];
  $adminConfig['timeZone'] = $_POST['cfg_timeZone'];
  $adminConfig['dateFormat'] = $_POST['cfg_dateFormat'];
  $adminConfig['speakingUrl'] = $_POST['cfg_speakingUrl'];
    
  $adminConfig['varName']['page'] = $_POST['cfg_varNamePage'];  
  $adminConfig['varName']['category'] = $_POST['cfg_varNameCategory'];  
  $adminConfig['varName']['modul'] = $_POST['cfg_varNameModul'];
  
  $adminConfig['user']['frontendEditing'] = $_POST['cfg_userFrontendEditing'];
  $adminConfig['user']['fileManager'] = (empty($adminConfig['uploadPath'])) ? false : $_POST['cfg_userFileManager'];
  $adminConfig['user']['editWebsiteFiles'] = $_POST['cfg_userWebsiteFiles'];
  $adminConfig['user']['editStyleSheets'] = $_POST['cfg_userStylesheets'];  
  $adminConfig['user']['info'] = $_POST['cfg_userInfo'];
    
  // -> saved in pageSetup.php
  //$adminConfig['setStartPage'] = $_POST['cfg_setStartPage'];
  //$adminConfig['pages']['createDelete'] = $_POST['cfg_pageCreatePages'];
  //$adminConfig['pages']['thumbnails'] = $_POST['cfg_pageThumbnailUpload'];  
  //$adminConfig['pages']['plugins'] = $_POST['cfg_pagePlugins'];
  //$adminConfig['pages']['showTags'] = $_POST['cfg_pageTags'];
  
  $adminConfig['editor']['htmlLawed'] = $_POST['cfg_editorHtmlLawed'];
  $adminConfig['editor']['safeHtml'] = $_POST['cfg_editorSafeHtml'];
  $adminConfig['editor']['enterMode'] = $_POST['cfg_editorEnterMode'];
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
    StatisticFunctions::saveTaskLog(8); // <- SAVE the task in a LOG FILE
    
  } else
    $errorWindow .= sprintf($langFile['ADMINSETUP_GENERAL_error_save'],$adminConfig['realBasePath']);
  
  $savedForm = $_POST['savedBlock'];
  $savedSettings = true;
}

// ---------- Speichern in fckstyles.xml
if(isset($_POST['saveFckStyleFile'])) {

  $fckstylewrite = $_POST['fckStyleFile'];
  
  // -> fill when with standard styles when its empty
  if(strpos($fckstylewrite,'CKEDITOR.addStylesSet') === false)
    $fckstylewrite = "CKEDITOR.addStylesSet( 'htmlEditorStyles',
[

{name:'Blue Title',element:'h1',styles:{color:'Blue'}},
{name:'Red Title',element:'h3',styles:{color:'Red'}},
{name:'Marker: Yellow',element:'span',styles:{'background-color':'Yellow'}},
{name:'Marker: Green',element:'span',styles:{'background-color':'Lime'}},
{name:'Big',element:'big'},
{name:'Small',element:'small'},
{name:'Typewriter',element:'tt'},
{name:'Computer Code',element:'code'},
{name:'Keyboard Phrase',element:'kbd'},
{name:'Sample Text',element:'samp'},
{name:'Variable',element:'var'},
{name:'Deleted Text',element:'del'},
{name:'Inserted Text',element:'ins'},
{name:'Cited Work',element:'cite'},
{name:'Inline Quotation',element:'q'},
{name:'Language: RTL',element:'span',attributes:{dir:'rtl'}},
{name:'Language: LTR',element:'span',attributes:{dir:'ltr'}},
{name:'Bild nach links',element:'img',attributes:{align:'left'},styles:{'margin':'4px 6px 4px 0px'}},
{name:'Bild nach Rechts',element:'img',attributes:{align:'right'},styles:{'margin':'4px 0px 4px 6px'}}

]);";
  
  $fckstylewrite 	= GeneralFunctions::smartStripslashes($fckstylewrite);
    
  // -> write file
  if(file_put_contents(dirname(__FILE__)."/../../config/htmlEditorStyles.js", $fckstylewrite, LOCK_EX)) {
    
    // give documentSaved status
    $documentSaved = true;
    StatisticFunctions::saveTaskLog(9); // <- SAVE the task in a LOG FILE
  } else {
    $errorWindow .= $langFile['adminSetup_styleFileSettings_error_save'];
  }
  
  $savedForm = 'fckStyleFile';
}

// ---------- SAVE the editFiles
include_once(dirname(__FILE__).'/saveEditFiles.controller.php');

// RE-INCLUDE
if($savedSettings) {
  if($fp = @fopen(dirname(__FILE__).'/../../config/admin.config.php','r')) {
    flock($fp,LOCK_SH);
    $adminConfig = include(dirname(__FILE__)."/../../config/admin.config.php");
    flock($fp,LOCK_UN);
    fclose($fp);
  }
  // RESET of the vars in the classes
  GeneralFunctions::$storedPageIds = null;
  GeneralFunctions::$storedPages = null;
  GeneralFunctions::$adminConfig = $adminConfig;
  StatisticFunctions::$adminConfig = $adminConfig;
}

// ->> SET PERMISSIONS
if(!empty($adminConfig['permissions']) && !is_string($adminConfig['permissions'])) {
  if(is_file(dirname(__FILE__)."/../../statistic/activity.statistic.log")) chmod(dirname(__FILE__)."/../../statistic/activity.statistic.log", $adminConfig['permissions']);
  if(is_file(dirname(__FILE__)."/../../statistic/referer.statistic.log")) chmod(dirname(__FILE__)."/../../statistic/referer.statistic.log", $adminConfig['permissions']);
  if(is_file(dirname(__FILE__)."/../../statistic/website.statistic.php")) chmod(dirname(__FILE__)."/../../statistic/website.statistic.php", $adminConfig['permissions']);
  
  if(is_file(dirname(__FILE__)."/../../config/admin.config.php")) chmod(dirname(__FILE__)."/../../config/admin.config.php", $adminConfig['permissions']);
  if(is_file(dirname(__FILE__)."/../../config/category.config.php")) chmod(dirname(__FILE__)."/../../config/category.config.php", $adminConfig['permissions']);
  if(is_file(dirname(__FILE__)."/../../config/statistic.config.php")) chmod(dirname(__FILE__)."/../../config/statistic.config.php", $adminConfig['permissions']);
  if(is_file(dirname(__FILE__)."/../../config/user.config.php")) chmod(dirname(__FILE__)."/../../config/user.config.php", $adminConfig['permissions']);
  if(is_file(dirname(__FILE__)."/../../config/website.config.php")) chmod(dirname(__FILE__)."/../../config/website.config.php", $adminConfig['permissions']);
  if(is_file(dirname(__FILE__)."/../../config/htmlEditorStyles.js")) chmod(dirname(__FILE__)."/../../config/htmlEditorStyles.js", $adminConfig['permissions']);
}
?>