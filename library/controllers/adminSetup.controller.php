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

* controllers/adminSetup.controller.php version 3.0
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

  // ensure that the website path with a filename, doesnt have a slashs on the end -> check if is file
  if(is_file(DOCUMENTROOT.substr($_POST['cfg_websitePath'],0,-1)))
    $_POST['cfg_websitePath'] = substr($_POST['cfg_websitePath'],0,-1);

  // -> CHECK if the VARNAMES are EMPTY, and add the previous ones, if pretty url = true
  if(empty($_POST['cfg_varNamePage']))
    $_POST['cfg_varNamePage'] = 'page';
  if(empty($_POST['cfg_varNameCategory']))
    $_POST['cfg_varNameCategory'] = 'category';
  if(empty($_POST['cfg_varNameModul']))
    $_POST['cfg_varNameModul'] = 'modul';

  // ->> add PRETTY URL to .htaccess
  // --------------------------
  savePrettyUrlCode($ERRORWINDOW);

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

  // deactivate the editing of the snippets in the website config, if snippets is deactivated
  if(empty($_POST['cfg_snippets']))
    $_POST['cfg_userSnippets'] = false;

  // -> CLEAN all " out of the strings
  foreach($_POST as $postKey => $post)
    $_POST[$postKey] = str_replace(array('\"',"\'"),'',$post);

  // remove last "/"
  if(substr($_POST['cfg_documentroot'], -1) == '/')
    $_POST['cfg_documentroot'] = substr($_POST['cfg_documentroot'], 0, -1);

  // -> PREPARE CONFIG VARs
  $adminConfig['documentroot']             = $_POST['cfg_documentroot'];
  $adminConfig['url']                      = generateCurrentUrl();
  $adminConfig['basePath']                 = GeneralFunctions::URI2Path(dirname($_SERVER['PHP_SELF'])).'/';

  $adminConfig['websitePath']              = GeneralFunctions::URI2Path($_POST['cfg_websitePath']);

  $adminConfig['websiteFilesPath']         = GeneralFunctions::URI2Path($_POST['cfg_websiteFilesPath']);
  $adminConfig['stylesheetPath']           = GeneralFunctions::URI2Path($_POST['cfg_stylesheetPath']);

  $adminConfig['permissions']              = $_POST['cfg_permissions'];
  $adminConfig['timezone']                 = $_POST['cfg_timeZone'];
  $adminConfig['prettyURL']                = $_POST['cfg_prettyURL'];

  $adminConfig['cache']['active']          = $_POST['cfg_cache'];
  $adminConfig['cache']['timeout']         = $_POST['cfg_cacheTimeout'];

  $adminConfig['varName']['page']          = $_POST['cfg_varNamePage'];
  $adminConfig['varName']['category']      = $_POST['cfg_varNameCategory'];
  $adminConfig['varName']['modul']         = $_POST['cfg_varNameModul'];

  $adminConfig['editor']['htmlLawed']      = $_POST['cfg_editorHtmlLawed'];
  $adminConfig['editor']['safeHtml']       = $_POST['cfg_editorSafeHtml'];
  $adminConfig['editor']['editorStyles']   = $_POST['cfg_editorStyles'];
  $adminConfig['editor']['snippets']       = $_POST['cfg_snippets'];
  $adminConfig['editor']['enterMode']      = $_POST['cfg_editorEnterMode'];


  // -> saved in pageSetup.php
  //$adminConfig['pageThumbnail']['width']  =  $_POST['cfg_thumbWidth'];
  //$adminConfig['pageThumbnail']['height'] = $_POST['cfg_thumbHeight'];
  //$adminConfig['pageThumbnail']['ratio']  = $_POST['cfg_thumbRatio'];

  // **** opens admin.config.php for writing
  if(saveAdminConfig($adminConfig)) {
    // give documentSaved status
    $DOCUMENTSAVED = true;
    saveActivityLog(8); // <- SAVE the task in a LOG FILE

  } else
    $ERRORWINDOW .= sprintf($langFile['ADMINSETUP_GENERAL_error_save'],$adminConfig['basePath']);


  // adds the HTML-Editor stylesheets to the NON-CATEGORY
  $categoryConfig[0]['styleFile']    = prepareStyleFilePaths($_POST['cfg_editorStyleFile']);
  $categoryConfig[0]['styleId']      = str_replace(array('#','.'),'',$_POST['cfg_editorStyleId']);
  $categoryConfig[0]['styleClass']   = str_replace(array('#','.'),'',$_POST['cfg_editorStyleClass']);
  saveCategories($categoryConfig);

  $SAVEDFORM = $_POST['savedBlock'];
  $SAVEDSETTINGS = true;
}

// ---------- Speichern in EditorStyles.js
if(isset($_POST['saveFckStyleFile'])) {

  $fckstylewrite = $_POST['fckStyleFile'];

  $fckstylewrite 	= GeneralFunctions::smartStripslashes($fckstylewrite);

  // -> write file
  if(file_put_contents(dirname(__FILE__)."/../../config/EditorStyles.js", $fckstylewrite, LOCK_EX)) {

    // give documentSaved status
    $DOCUMENTSAVED = true;
    saveActivityLog(9); // <- SAVE the task in a LOG FILE
  } elseif(empty($fckstylewrite)) {
    @unlink(dirname(__FILE__)."/../../config/EditorStyles.js");
  } else {
    $ERRORWINDOW .= $langFile['adminSetup_styleFileSettings_error_save'];
  }

  $SAVEDFORM = 'fckStyleFile';
}

// ---------- SAVE the editFiles
include_once(dirname(__FILE__).'/saveEditFiles.controller.php');

// RE-INCLUDE
if($SAVEDSETTINGS) {
  if($fp = @fopen(dirname(__FILE__).'/../../config/admin.config.php','r')) {
    flock($fp,LOCK_SH);
    unset($adminConfig);
    $adminConfig = include(dirname(__FILE__)."/../../config/admin.config.php");
    flock($fp,LOCK_UN);
    fclose($fp);
  }
  // RESET of the vars in the classes
  GeneralFunctions::$storedPages = null;
  GeneralFunctions::$adminConfig = $adminConfig;
  StatisticFunctions::$adminConfig = $adminConfig;
}

// ->> SET PERMISSIONS
if(!empty($adminConfig['permissions']) && !is_string($adminConfig['permissions'])) {
  if(is_file(dirname(__FILE__)."/../../statistics/activity.statistic.log")) @chmod(dirname(__FILE__)."/../../statistics/activity.statistic.log", $adminConfig['permissions']);
  if(is_file(dirname(__FILE__)."/../../statistics/referer.statistic.log")) @chmod(dirname(__FILE__)."/../../statistics/referer.statistic.log", $adminConfig['permissions']);
  if(is_file(dirname(__FILE__)."/../../statistics/website.statistic.php")) @chmod(dirname(__FILE__)."/../../statistics/website.statistic.php", $adminConfig['permissions']);

  if(is_file(dirname(__FILE__)."/../../config/admin.config.php")) @chmod(dirname(__FILE__)."/../../config/admin.config.php", $adminConfig['permissions']);
  if(is_file(dirname(__FILE__)."/../../config/category.config.php")) @chmod(dirname(__FILE__)."/../../config/category.config.php", $adminConfig['permissions']);
  if(is_file(dirname(__FILE__)."/../../config/statistic.config.php")) @chmod(dirname(__FILE__)."/../../config/statistic.config.php", $adminConfig['permissions']);
  if(is_file(dirname(__FILE__)."/../../config/user.config.php")) @chmod(dirname(__FILE__)."/../../config/user.config.php", $adminConfig['permissions']);
  if(is_file(dirname(__FILE__)."/../../config/website.config.php")) @chmod(dirname(__FILE__)."/../../config/website.config.php", $adminConfig['permissions']);
  if(is_file(dirname(__FILE__)."/../../config/EditorStyles.js")) @chmod(dirname(__FILE__)."/../../config/EditorStyles.js", $adminConfig['permissions']);
}
?>