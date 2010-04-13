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

* adminSetup.php version 2.33
*/

include_once(dirname(__FILE__)."/../backend.include.php");


// ----------------------------------------------------------------------------------------------------------------------------------------
// **--** SAVE PROCESS --------------------------------------------------------------------------------------------------------------------
// ----------------------------------------------------------------------------------------------------------------------------------------


// ****** ---------- SAVE ADMIN CONFIG in config/admin.config.php
if(isset($_POST['send']) && $_POST['send'] ==  'adminSetup') {
  
  // ** ensure the the post vars with a 'Path' in the key value ending with a '/'
  foreach($_POST as $postKey => $post) {    
    
    if(strstr($postKey,'Path'))
      if(!empty($post) && substr($post,-1) !== '/')
        $_POST[$postKey] = $post.'/';
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
        
  if(!empty($_POST['cfg_editorStyleFile']) && substr($_POST['cfg_editorStyleFile'],0,1) !== '/')
        $_POST['cfg_editorStyleFile'] = '/'.$_POST['cfg_editorStyleFile'];

  
  // ->> add SPEAKING URL to .htaccess
  // --------------------------
    $speakingUrlCode = '<IfModule mod_rewrite.c>
RewriteEngine On
RewriteBase /
# rewrite "/page/*.html" and "/category/*/*.html"
# and also passes the session var
RewriteRule ^category/([^/]+)/(.*)\.html?$ index.php?category=$1&page=$2$3 [QSA,L]
RewriteRule ^page/(.*)\.html?$ index.php?page=$1$2 [QSA,L]
</IfModule>';
    
    $htaccessFile = DOCUMENTROOT.'/.htaccess';
  
  // ** looks for the apache modules
  if(function_exists('apache_get_modules'))
    $apacheModules = apache_get_modules();
  else
    $apacheModules = array(false);
  
  // ** looks if the MOD_REWRITE modul exists
  if(!in_array('mod_rewrite',$apacheModules))
    $_POST['cfg_speakingUrl'] = '';
  // ** ->> looks for a .htacces file with the speaking url mod_rewrite
  elseif(in_array('mod_rewrite',$apacheModules) && $_POST['cfg_speakingUrl'] == 'true') {

    // -> looks if the existing .htaccess file has the SPEAKING URL code
    if(file_exists($htaccessFile)) {

      if(strstr(file_get_contents($htaccessFile),$speakingUrlCode) === false) {
        if($htaccess = @fopen($htaccessFile,"a")) {
          flock($htaccess,2); // LOCK_EX
          fwrite($htaccess,"\n".$speakingUrlCode);
          flock($htaccess,3); //LOCK_UN
          fclose($htaccess);
        } else {
          $_POST['cfg_speakingUrl'] = '';
          $errorWindow = $langFile['adminSetup_fmsSettings_speakingUrl_error_save'];
        }
      }
    // -> creates a NEW .htaccess file
    } else {
      if($htaccess = @fopen($htaccessFile,"w")) {
        flock($htaccess,2); // LOCK_EX
        fwrite($htaccess,$speakingUrlCode);
        flock($htaccess,3); //LOCK_UN
        fclose($htaccess);
      } else {
        $_POST['cfg_speakingUrl'] = '';
        $errorWindow = $langFile['adminSetup_fmsSettings_speakingUrl_error_save'];
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
        $newHtaccess = preg_replace("/\n+/", "\n", $newHtaccess);
        
        if($htaccess = @fopen($htaccessFile,"w")) {
          flock($htaccess,2); // LOCK_EX
          fwrite($htaccess,$newHtaccess);
          flock($htaccess,3); //LOCK_UN
          fclose($htaccess);
        } else {
          $errorWindow = $langFile['adminSetup_fmsSettings_speakingUrl_error_save'];
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
  $adminConfig['url'] = $_SERVER["HTTP_HOST"];
  $adminConfig['basePath'] = dirname($_SERVER['PHP_SELF']).'/';
  $adminConfig['savePath'] =  $_POST['cfg_savePath'];
  
  $adminConfig['uploadPath'] = $_POST['cfg_uploadPath'];  
  $adminConfig['websitefilesPath'] = $_POST['cfg_websitefilesPath'];
  $adminConfig['stylesheetPath'] = $_POST['cfg_stylesheetPath'];    
  $adminConfig['dateFormat'] = $_POST['cfg_dateFormat'];
  $adminConfig['speakingUrl'] = $_POST['cfg_speakingUrl'];
    
  $adminConfig['varName']['page'] = $_POST['cfg_varNamePage'];  
  $adminConfig['varName']['category'] = $_POST['cfg_varNameCategory'];  
  $adminConfig['varName']['modul'] = $_POST['cfg_varNameModul'];
    
  $adminConfig['user']['editWebsiteFiles'] = $_POST['cfg_userWebsiteFiles'];
  $adminConfig['user']['editStylesheets'] = $_POST['cfg_userStylesheets'];  
  $adminConfig['user']['info'] = $_POST['cfg_userInfo'];
    
  // -> saved in pageSetup.php
  //$adminConfig['setStartPage'] = $_POST['cfg_setStartPage'];
  //$adminConfig['page']['createPages'] = $_POST['cfg_pageCreatePages'];
  //$adminConfig['page']['thumbnailUpload'] = $_POST['cfg_pageThumbnailUpload'];  
  //$adminConfig['page']['plugins'] = $_POST['cfg_pagePlugins'];
  //$adminConfig['page']['showtags'] = $_POST['cfg_pageTags'];
    
  $adminConfig['editor']['enterMode'] = strtolower($_POST['cfg_editorEnterMode']);
  $adminConfig['editor']['styleFile'] = $_POST['cfg_editorStyleFile'];
  $adminConfig['editor']['styleId'] = str_replace(array('#','.'),'',$_POST['cfg_editorStyleId']);  
  $adminConfig['editor']['styleClass'] = str_replace(array('#','.'),'',$_POST['cfg_editorStyleClass']);  
  
  // -> saved in pageSetup.php
  //$adminConfig['pageThumbnail']['width'] =  $_POST['cfg_thumbWidth'];
  //$adminConfig['pageThumbnail']['height'] = $_POST['cfg_thumbHeight'];
  //$adminConfig['pageThumbnail']['ratio'] = $_POST['cfg_thumbRatio'];
  //$adminConfig['pageThumbnail']['path'] = 'images/'.$_POST['cfg_thumbPath'];
  
  // **** opens admin.config.php for writing
  if(saveAdminConfig($adminConfig)) {   
     
    // give documentSaved status
    $documentSaved = true;
    $statisticFunctions->saveTaskLog($langFile['log_adminSetup_saved']); // <- SAVE the task in a LOG FILE
    
  } else
    $errorWindow = $langFile['adminSetup_fmsSettings_error_save'];
  
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
    $statisticFunctions->saveTaskLog($langFile['log_adminSetup_ckstyles']); // <- SAVE the task in a LOG FILE
  } else {
    $errorWindow = $langFile['adminSetup_styleFileSettings_error_save'];
  }
  
  $savedForm = 'fckStyleFile';
}

// ---------- SAVE the editFiles
include_once(dirname(__FILE__).'/../process/saveEditFiles.php');


@include (dirname(__FILE__)."/../../config/admin.config.php"); // loads the saved settings again
@include (dirname(__FILE__)."/../../config/category.config.php"); // loads the saved categories again

// ------------------------------- ENDE of the SAVING SCRIPT -------------------------------------------------------------------------------


// didnt show the Setup for non-adminstrators
if(isAdmin()) {

// show basePath warning if necessary
basePathWarning();

// CHECKs THE IF THE NECESSARY FILEs ARE WRITEABLE, otherwise throw an error
// ----------------------------------------------------------------------------------------
$unwriteableList = '';

$checkFolders[] = $adminConfig['basePath'].'config/';
$checkFolders[] = $adminConfig['basePath'].'statistic/';
$checkFolders[] = $adminConfig['basePath'].'plugins/';
$checkFolders[] = $adminConfig['savePath'];
$checkFolders[] = $adminConfig['websitefilesPath'];
$checkFolders[] = $adminConfig['stylesheetPath'];
$checkFolders[] = $adminConfig['uploadPath'];

foreach($checkFolders as $checkFolder) {
  if(!empty($checkFolder)) {
    if($isFolder = isFolderWarning($checkFolder)) {
      $unwriteableList .= $isFolder;
    } else {
      $unwriteableList .= fileFolderIsWritableWarning($checkFolder);
      if($readFolder = readFolderRecursive($checkFolder)) {
        if(is_array($readFolder['folders'])) {
          foreach($readFolder['folders'] as $folder) {
            $unwriteableList .= fileFolderIsWritableWarning($folder);
          }
        }
        if(is_array($readFolder['files'])) {
          foreach($readFolder['files'] as $files) {
            $unwriteableList .= fileFolderIsWritableWarning($files);
          }
        }
      }
    }
  }
}


// gives the error OUTPUT if one of these files in unwriteable
if($unwriteableList && checkBasePath()) {
  echo '<div class="block warning">
    <h1>'.$langFile['adminSetup_error_title'].'</h1>
    <div class="content">
      <p>'.$unwriteableList.'</p><!-- needs <p> tags for margin-left:..-->
    </div>
    <div class="bottom"></div>  
  </div>'; 
  
  echo '<div class="blockSpacer"></div>';
}
// ------------------------------------------------------------------------------------------- end WRITEABLE CHECK

?>

<!-- anchor for the adminSettings 
<a name="adminSettingsTop" id="adminSettingsTop" class="anchor"></a>-->

<form action="?site=adminSetup" method="post" enctype="multipart/form-data" accept-charset="UTF-8">
  <div>
  <input type="hidden" name="send" value="adminSetup" />
  <input type="hidden" name="savedBlock" id="savedBlock" value="" />
  </div>
  
<!-- FMS SETTINGS -->
<?php
// shows the block below if it is the ones which is saved before
if($savedForm != 'fmsSettings')  $hidden = ' hidden';
else $hidden = '';  
?>
<div class="block<?php echo $hidden; ?>">
  <h1><a href="#" id="fmsSettings" name="fmsSettings"><?php echo $langFile['adminSetup_fmsSettings_h1']; ?></a></h1>
  <div class="content">
    <table>
     
      <colgroup>
      <col class="left" />
      </colgroup>
  
      <tr><td class="leftTop"></td><td></td></tr>
      
      <tr><td class="left">
      <label for="cfg_url"><span class="toolTip" title="<?php echo $langFile['adminSetup_fmsSettings_field1'].'::'.$langFile['adminSetup_fmsSettings_field1_tip'] ?>">
      <?php echo $langFile['adminSetup_fmsSettings_field1'] ?></span></label>
      </td><td class="right">
      <?php
      $basePath = str_replace('www.','',$adminConfig['url']);
      $checkPath = str_replace('www.','',$_SERVER["HTTP_HOST"]);
      ?>
      <input id="cfg_url" name="cfg_url"<?php if($basePath != $checkPath) echo ' style="color:#C5451F;" value="'.$langFile['adminSetup_fmsSettings_field1_inputWarningText'].'"'; else echo ' value="'.$adminConfig['url'].'"'; ?> readonly="readonly" class="toolTip" title="<?php echo $langFile['adminSetup_fmsSettings_field1_inputTip']; ?>" />
      </td></tr>
      
      <tr><td class="left">
      <label for="cfg_basePath"><span class="toolTip" title="<?php echo $langFile['adminSetup_fmsSettings_field2'].'::'.$langFile['adminSetup_fmsSettings_field2_tip'] ?>">
      <?php echo $langFile['adminSetup_fmsSettings_field2'] ?></span></label>
      </td><td class="right">
      <input id="cfg_basePath" name="cfg_basePath"<?php if($adminConfig['basePath'] != dirname($_SERVER['PHP_SELF']).'/') echo ' style="color:#C5451F;" value="'.$langFile['adminSetup_fmsSettings_field2_inputWarningText'].'"'; else echo ' value="'.$adminConfig['basePath'].'"'; ?> readonly="readonly" class="toolTip" title="<?php echo $langFile['adminSetup_fmsSettings_field2_inputTip']; ?>" />
      </td></tr>
      
      <tr><td class="spacer"></td><td></td></tr>
      
      <tr><td class="left">
      <label for="cfg_savePath"><span class="toolTip" title="<?php echo $langFile['adminSetup_fmsSettings_field3'].'::'.$langFile['adminSetup_fmsSettings_field3_tip'] ?>">
      <?php echo $langFile['adminSetup_fmsSettings_field3'] ?></span></label>
      </td><td class="right">
      <input size="40" id="cfg_savePath" name="cfg_savePath" value="<?php echo $adminConfig['savePath']; ?>" class="toolTip" title="<?php echo $langFile['path_absolutepath_tip']; ?>" />
      <span class="hint"><?php echo $langFile['path_absolutepath']; ?></span>
      </td></tr>
      
      <tr><td class="spacer"></td><td></td></tr>
      
      <tr><td class="left">
      <label for="cfg_uploadPath"><span class="toolTip" title="<?php echo $langFile['adminSetup_fmsSettings_field4'].'::'.$langFile['adminSetup_fmsSettings_field4_tip'] ?>">
      <?php echo $langFile['adminSetup_fmsSettings_field4'] ?></span></label>
      </td><td class="right">
      <input size="40" id="cfg_uploadPath" name="cfg_uploadPath" value="<?php echo $adminConfig['uploadPath']; ?>" class="toolTip" title="<?php echo $langFile['path_absolutepath_tip']; ?>" />
      <span class="hint"><?php echo $langFile['path_absolutepath']; ?></span>
      </td></tr>
      
      <tr><td class="left">
      <label for="cfg_websitefilesPath"><span class="toolTip" title="<?php echo $langFile['adminSetup_fmsSettings_field5'].'::'.$langFile['adminSetup_fmsSettings_field5_tip'] ?>">
      <?php echo $langFile['adminSetup_fmsSettings_field5'] ?></span></label>
      </td><td class="right">
      <input size="40" id="cfg_websitefilesPath" name="cfg_websitefilesPath" value="<?php echo $adminConfig['websitefilesPath']; ?>" class="toolTip" title="<?php echo $langFile['path_absolutepath_tip']; ?>" />
      <span class="hint"><?php echo $langFile['path_absolutepath']; ?></span>
      </td></tr>
      
      <tr><td class="left">
      <label for="cfg_stylesheetPath"><span class="toolTip" title="<?php echo $langFile['adminSetup_fmsSettings_field6'].'::'.$langFile['adminSetup_fmsSettings_field6_tip'] ?>">
      <?php echo $langFile['adminSetup_fmsSettings_field6'] ?></span></label>
      </td><td class="right">
      <input size="40" id="cfg_stylesheetPath" name="cfg_stylesheetPath" value="<?php echo $adminConfig['stylesheetPath']; ?>" class="toolTip" title="<?php echo $langFile['path_absolutepath_tip']; ?>" />
      <span class="hint"><?php echo $langFile['path_absolutepath']; ?></span>
      </td></tr>      
      
      <tr><td class="spacer"></td><td></td></tr>
      
      <tr><td class="left">
      <label for="cfg_dateFormat"><span class="toolTip" title="<?php echo $langFile['adminSetup_fmsSettings_field7'].'::'.$langFile['adminSetup_fmsSettings_field7_tip'] ?>">
      <?php echo $langFile['adminSetup_fmsSettings_field7'] ?></span></label>
      </td><td class="right">
      <select id="cfg_dateFormat" name="cfg_dateFormat">
        <option value="eu"<?php if($adminConfig['dateFormat'] == 'eu') echo ' selected="selected"'; ?>><?php echo $langFile['date_eu'];?></option>
        <option value="int"<?php if($adminConfig['dateFormat'] == 'int') echo ' selected="selected"'; ?>><?php echo $langFile['date_int'];?></option>
      </select>
      </td></tr>
      
      <tr><td class="spacer"></td><td></td></tr>
      
      <!-- URL FORMAT -> SPEAKING URLS -->
      <tr><td class="left">
      <label for="cfg_speakingUrl"><span class="toolTip" title="<?php echo $langFile['adminSetup_fmsSettings_speakingUrl'].'::'.$langFile['adminSetup_fmsSettings_speakingUrl_tip'] ?>">
      <?php echo $langFile['adminSetup_fmsSettings_speakingUrl'] ?></span></label>
      </td><td class="right">
      <select id="cfg_speakingUrl" name="cfg_speakingUrl" style="width:160px;" <?php if(!in_array('mod_rewrite',$apacheModules)) echo 'disabled="disabled"'; ?>>
        <option value="true"<?php if($adminConfig['speakingUrl'] == 'true') echo ' selected="selected"'; echo ' class="toolTip" title="'.$langFile['adminSetup_fmsSettings_speakingUrl_warning'].'"'; ?>><?php echo $langFile['adminSetup_fmsSettings_speakingUrl_true'].' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-> '.$langFile['adminSetup_fmsSettings_speakingUrl_true_example'];?></option>
        <option value=""<?php if($adminConfig['speakingUrl'] == '') echo ' selected="selected"'; ?>><?php echo $langFile['adminSetup_fmsSettings_speakingUrl_false'].' &nbsp;&nbsp;&nbsp;-> '.$langFile['adminSetup_fmsSettings_speakingUrl_false_example'];?></option>
      </select>
      <span class="hint">
      <?php
        echo '<b>'.$langFile['text_example'].':</b> ';
        
        // show the right example
        // AND disable varNames if speaking urls = true
        if($adminConfig['speakingUrl'] == 'true') {
          echo $langFile['adminSetup_fmsSettings_speakingUrl_true_example'];
          $varNamesStyle = ' disabled="disabled"';
        } else {
          echo $langFile['adminSetup_fmsSettings_speakingUrl_false_example'];
          $varNamesStyle = '';
        }
      ?>
      </span>
      </td></tr>
      
      <tr><td class="spacer"></td><td></td></tr>
      
      <tr><td class="left">
      <label for="cfg_varNamePage"><span class="toolTip" title="<?php echo $langFile['adminSetup_fmsSettings_varName1'].'::'.$langFile['adminSetup_fmsSettings_varName_tip'] ?>">
      <?php echo $langFile['adminSetup_fmsSettings_varName1'] ?></span></label>
      </td><td class="right">
      <input size="40" id="cfg_varNamePage" name="cfg_varNamePage" value=<?php echo '"'.$adminConfig['varName']['page'].'"'.$varNamesStyle; ?> class="toolTip" title="<?php echo $langFile['adminSetup_fmsSettings_varName1'].'::'.$langFile['adminSetup_fmsSettings_varName1_inputTip']; ?>" />
      </td></tr>
      
      <tr><td class="left">
      <label for="cfg_varNameCategory"><span class="toolTip" title="<?php echo $langFile['adminSetup_fmsSettings_varName2'].'::'.$langFile['adminSetup_fmsSettings_varName_tip'] ?>">
      <?php echo $langFile['adminSetup_fmsSettings_varName2'] ?></span></label>
      </td><td class="right">
      <input size="40" id="cfg_varNameCategory" name="cfg_varNameCategory" value=<?php echo '"'.$adminConfig['varName']['category'].'"'.$varNamesStyle; ?> class="toolTip" title="<?php echo $langFile['adminSetup_fmsSettings_varName2'].'::'.$langFile['adminSetup_fmsSettings_varName2_inputTip']; ?>" />
      </td></tr>
      
      <tr><td class="left">
      <label for="cfg_varNameModul"><span class="toolTip" title="<?php echo $langFile['adminSetup_fmsSettings_varName3'].'::'.$langFile['adminSetup_fmsSettings_varName_tip'] ?>">
      <?php echo $langFile['adminSetup_fmsSettings_varName3'] ?></span></label>
      </td><td class="right">
      <input size="40" id="cfg_varNameModul" name="cfg_varNameModul" value=<?php echo '"'.$adminConfig['varName']['modul'].'"'.$varNamesStyle; ?> class="toolTip" title="<?php echo $langFile['adminSetup_fmsSettings_varName3'].'::'.$langFile['adminSetup_fmsSettings_varName3_inputTip']; ?>" />
      </td></tr>
      
      <tr><td class="leftBottom"></td><td></td></tr>
      
    </table>
    
    <!--<input type="reset" value="" class="toolTip button cancel" title="<?php echo $langFile['form_cancel']; ?>" />-->
    <input type="submit" value="" name="adminConfig" class="toolTip button submit center" title="<?php echo $langFile['form_submit']; ?>" onclick="$('savedBlock').value = 'fmsSettings';" />
  </div>
  <div class="bottom"></div>
</div>

<!-- USER SETTINGS -->
<?php
// shows the block below if it is the ones which is saved before
if($savedForm != 'userSettings')  $hidden = ' hidden';
else $hidden = '';  
?>
<div class="block<?php echo $hidden; ?>">
<h1><a href="#" id="userSettings" name="userSettings"><?php echo $langFile['adminSetup_userSettings_h1']; ?></a></h1>
<div class="content">
    <table>
     
      <colgroup>
      <col class="left" />
      </colgroup>
      
      
      <tr><td class="left checkboxes">
      <input type="checkbox" id="cfg_userWebsiteFiles" name="cfg_userWebsiteFiles" value="true"<?php if($adminConfig['user']['editWebsiteFiles']) echo ' checked="checked"'; ?> /><br />
      <input type="checkbox" id="cfg_userStylesheets" name="cfg_userStylesheets" value="true"<?php if($adminConfig['user']['editStylesheets']) echo ' checked="checked"'; ?> />
      
      </td><td class="right checkboxes">
      <label for="cfg_userWebsiteFiles"><?php echo $langFile['adminSetup_userSettings_check1']; ?></label><br />
      <label for="cfg_userStylesheets"><?php echo $langFile['adminSetup_userSettings_check2']; ?></label>
      </td></tr>
      
      <tr><td class="leftTop"></td><td></td></tr>
      
      <tr><td class="left">
      <label for="cfg_userInfo"><span class="toolTip" title="<?php echo $langFile['adminSetup_userSettings_textarea1_tip']; ?>"><?php echo $langFile['adminSetup_userSettings_textarea1']; ?></span></label>
      </td><td class="right">
      <textarea id="cfg_userInfo" name="cfg_userInfo"  cols="50" rows="8" style="white-space:normal;width:500px;height:250px;" class="toolTip" title="<?php echo $langFile['adminSetup_userSettings_textarea1_inputTip']; ?>"><?php echo str_replace(array('<br>','<br />','<br/>'),'',$adminConfig['user']['info']); ?></textarea>
      </td></tr>

      <tr><td class="leftBottom"></td><td></td></tr>
      
    </table>
    
    <!--<input type="reset" value="" class="toolTip button cancel" title="<?php echo $langFile['form_cancel']; ?>" />-->
    <input type="submit" value="" name="adminConfig" class="toolTip button submit center" title="<?php echo $langFile['form_submit']; ?>" onclick="$('savedBlock').value = 'userSettings';" />
  </div>
  <div class="bottom"></div>
</div>

<!-- EDITOR SETTINGS -->
<?php
// shows the block below if it is the ones which is saved before
if($savedForm != 'editorSettings')  $hidden = ' hidden';
else $hidden = '';  
?>
<div class="block<?php echo $hidden; ?>">
  <h1><a href="#" id="editorSettings" name="editorSettings"><?php echo $langFile['adminSetup_editorSettings_h1']; ?></a></h1>
  <div class="content">
    <table>
     
      <colgroup>
      <col class="left" />
      </colgroup>
  
      <tr><td class="leftTop"></td><td></td></tr>
      
      <tr><td class="left">
      <label for="cfg_editorEnterMode"><span class="toolTip" title="<?php echo $langFile['adminSetup_editorSettings_field1'].'::'.$langFile['adminSetup_editorSettings_field1_tip'] ?>">
      <?php echo $langFile['adminSetup_editorSettings_field1'] ?></span></label>
      </td><td class="right">
      <select id="cfg_editorEnterMode" name="cfg_editorEnterMode">
        <option value="p" <?php if($adminConfig['editor']['enterMode'] == 'p') echo 'selected="selected"'; ?>>&lt;p&gt;</option>
        <option value="br" <?php if($adminConfig['editor']['enterMode'] == 'br') echo 'selected="selected"'; ?>>&lt;br /&gt;</option>
      </select>
      </td></tr>
      
      <tr><td class="left">
      <label for="cfg_editorStyleFile"><span class="toolTip" title="<?php echo $langFile['stylesheet_name_styleFile'].'::'.$langFile['stylesheet_styleFile_tip'] ?>">
      <?php echo $langFile['stylesheet_name_styleFile'] ?></span></label>
      </td><td class="right">
      <input id="cfg_editorStyleFile" name="cfg_editorStyleFile" class="toolTip" value="<?php echo $adminConfig['editor']['styleFile']; ?>" title="<?php echo $langFile['path_absolutepath_tip']; ?>" />
      <span class="hint"><?php echo $langFile['stylesheet_styleFile_example']; ?></span>
      </td></tr>
      
      <tr><td class="left">
      <label for="cfg_editorStyleId"><span class="toolTip" title="<?php echo $langFile['stylesheet_name_styleId'].'::'.$langFile['stylesheet_styleId_tip'] ?>">
      <?php echo $langFile['stylesheet_name_styleId'] ?></span></label>
      </td><td class="right">
      <input id="cfg_editorStyleId" name="cfg_editorStyleId" class="toolTip" value="<?php echo $adminConfig['editor']['styleId']; ?>" title="<?php echo $langFile['adminSetup_editorSettings_field3_inputTip']; ?>" />
      </td></tr>
      
      <tr><td class="left">
      <label for="cfg_editorStyleClass"><span class="toolTip" title="<?php echo $langFile['stylesheet_name_styleClass'].'::'.$langFile['stylesheet_styleClass_tip'] ?>">
      <?php echo $langFile['stylesheet_name_styleClass'] ?></span></label>
      </td><td class="right">
      <input id="cfg_editorStyleClass" name="cfg_editorStyleClass" class="toolTip" value="<?php echo $adminConfig['editor']['styleClass']; ?>" title="<?php echo $langFile['adminSetup_editorSettings_field4_inputTip']; ?>" />
      </td></tr>
      
      <tr><td class="leftBottom"></td><td></td></tr>
      
    </table>
    
    <!--<input type="reset" value="" class="toolTip button cancel" title="<?php echo $langFile['form_cancel']; ?>" />-->
    <input type="submit" value="" name="adminConfig" class="toolTip button submit center" title="<?php echo $langFile['form_submit']; ?>" onclick="$('savedBlock').value = 'editorSettings';" />
  </div>
  <div class="bottom"></div>
</div>

</form>

<div class="blockSpacer"></div>


<!-- HIER BEGINNT DIE STIL-AUSWAHL BEARBEITUNG DES HTML EDITORS -->

<form action="?site=adminSetup#fckstyleFileAnchor" method="post" enctype="multipart/form-data" accept-charset="UTF-8">
  <div><input type="hidden" name="saveFckStyleFile" value="true" /></div>

<?php

$htmlEditorStyleFilePath = "config/htmlEditorStyles.js";
$htmlEditorStyleFile = @fopen($htmlEditorStyleFilePath,"r");
$htmlEditorStyleContent = @fread($htmlEditorStyleFile,filesize($htmlEditorStyleFilePath));
@fclose($htmlEditorStyleFile);


// shows the block below if it is the ones which is saved before
if($savedForm != 'fckStyleFile')
    $hidden = ' hidden';
  else
    $hidden = '';    
?>
<div class="block<?php echo $hidden; ?>">
  <h1><a href="#" name="fckstyleFileAnchor"><?php echo $langFile['adminSetup_styleFileSettings_h1']; ?></a></h1>
  <div class="content">
    <textarea name="fckStyleFile" cols="90" rows="30" class="editFiles"><?php echo $htmlEditorStyleContent; ?></textarea>
 
    <!--<input type="reset" value="" class="toolTip button cancel" title="<?php echo $langFile['form_cancel']; ?>" />-->
    <input type="submit" value="" name="saveCategories" class="toolTip button submit center" title="<?php echo $langFile['form_submit']; ?>" />
  </div>
  <div class="bottom"></div>
</div>
</form>

<?php

// BEARBEITUNG DER SPRACHDATEI
editFiles($adminConfig['websitefilesPath'], $_GET['site'], "editWebsitefile",  $langFile['editFilesSettings_h1_websitefiles'], "websiteFilesAnchor");
  

// BEARBEITUNG DER STYLESHEETDATEI
editFiles($adminConfig['stylesheetPath'], $_GET['site'], "editCSSfile", $langFile['editFilesSettings_h1_style'], "cssFilesAnchor", "css");

} // <-- END isAdmin()
?>