<?php
/**
 * feindura - Flat File Content Management System
 * Copyright (C) Fabian Vogelsteller [frozeman.de]
 * 
 * This program is free software;
 * you can redistribute it and/or modify it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY;
 * without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 * See the GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License along with this program;
 * if not,see <http://www.gnu.org/licenses/>.
 * 
 * sites/adminSetup.php
 * 
 * @version 2.36
 */

/**
 * Includes the login.include.php and backend.include.php and filter the basic data
 */
require_once(dirname(__FILE__)."/../includes/secure.include.php");

// didnt show the Setup for non-adminstrators
if(isAdmin()) {

// CHECKs if the necessary FILEs are WRITEABLE, otherwise show an warnings
// ----------------------------------------------------------------------------------------
$checkFolders[] = $adminConfig['realBasePath'].'config/';
$checkFolders[] = $adminConfig['realBasePath'].'statistic/';
$checkFolders[] = $adminConfig['realBasePath'].'pages/';
$checkFolders[] = $adminConfig['websiteFilesPath'];
$checkFolders[] = $adminConfig['stylesheetPath'];
$checkFolders[] = $adminConfig['uploadPath'];

// gives the error OUTPUT if one of these files in unwriteable
if(($unwriteableList = isWritableWarningRecursive($checkFolders)) && checkBasePath()) {
  echo '<div class="block warning">
    <h1>'.$langFile['adminSetup_error_title'].'</h1>
    <div class="content">
      <p>'.$unwriteableList.'</p><!-- need <p> tags for margin-left:..-->
    </div>
    <div class="bottom"></div>  
  </div>'; 
  
  echo '<div class="blockSpacer"></div>';
}

// GET timezones
$timezones = array();
$tab = file(dirname(__FILE__).'/../thirdparty/timezones.tab');
foreach ($tab as $buf) {
    if (substr($buf,0,1)=='#') continue;
    $rec = preg_split('/\s+/',$buf);
    $key = $rec[2];
    $val = $rec[2];
    $c = count($rec);
    for ($i=3;$i<$c;$i++) $val .= ' '.$rec[$i];
    $timezones[$key] = $val;
    ksort($timezones);
}

?>

<!-- anchor for the adminSettings 
<a name="adminSettingsTop" id="adminSettingsTop" class="anchor"></a>-->

<form action="index.php?site=adminSetup" method="post" enctype="multipart/form-data" accept-charset="UTF-8">
  <div>
  <input type="hidden" name="send" value="adminSetup" />
  <input type="hidden" name="savedBlock" id="savedBlock" value="" />
  </div>
  
<!-- BASIC SETTINGS -->
<?php
// shows the block below if it is the ones which is saved before
$hidden = ($savedForm != 'fmsSettings' && checkBasePath()) ? ' hidden' : '';
?>
<div class="block<?php echo $hidden; ?>">
  <h1><a href="#" id="fmsSettings" name="fmsSettings"><?php echo $langFile['ADMINSETUP_GENERAL_h1']; ?></a></h1>
  <div class="content">
    <table>
     
      <colgroup>
      <col class="left" />
      </colgroup>
  
      <tr><td class="leftTop"></td><td></td></tr>
      
      <tr><td class="left">
      <label for="cfg_url"><span class="toolTip" title="<?php echo $langFile['ADMINSETUP_GENERAL_field1'].'::'.$langFile['ADMINSETUP_GENERAL_field1_tip'] ?>">
      <?php echo $langFile['ADMINSETUP_GENERAL_field1'] ?></span></label>
      </td><td class="right">
      <?php
      $baseUrl = preg_replace('#^[a-zA-Z]+[:]{1}[\/\/]{2}#','',$GLOBALS['adminConfig']['url']);
      $checkUrl = preg_replace('#^[a-zA-Z]+[:]{1}[\/\/]{2}#','',$_SERVER["SERVER_NAME"]);
      ?>
      <input id="cfg_url" name="cfg_url"<?php if($baseUrl != $checkUrl) echo ' style="color:#C5451F !important;" value="'.$langFile['ADMINSETUP_GENERAL_field1_inputWarningText'].'"'; else echo ' value="'.$adminConfig['url'].'"'; ?> readonly="readonly" class="inputToolTip" title="<?php echo $langFile['ADMINSETUP_GENERAL_field1_inputTip']; ?>" />
      </td></tr>
      
      <tr><td class="left">
      <label for="cfg_basePath"><span class="toolTip" title="<?php echo $langFile['ADMINSETUP_GENERAL_field2'].'::'.$langFile['ADMINSETUP_GENERAL_field2_tip'] ?>">
      <?php echo $langFile['ADMINSETUP_GENERAL_field2'] ?></span></label>
      </td><td class="right">
      <?php
      $checkPath = preg_replace('#/+#','/',dirname($_SERVER['SCRIPT_NAME']).'/');
      ?>
      <input id="cfg_basePath" name="cfg_basePath"<?php if($adminConfig['basePath'] != $checkPath) echo ' style="color:#C5451F !important;" value="'.$langFile['ADMINSETUP_GENERAL_field2_inputWarningText'].'"'; else echo ' value="'.$adminConfig['basePath'].'"'; ?> readonly="readonly" class="inputToolTip" title="<?php echo $langFile['ADMINSETUP_GENERAL_field2_inputTip']; ?>" />
      </td></tr>

      <tr><td class="left">
      <label for="cfg_websitePath"><span class="toolTip" title="<?php echo $langFile['ADMINSETUP_GENERAL_field8'].'::'.$langFile['ADMINSETUP_GENERAL_field8_tip'] ?>">
      <?php echo $langFile['ADMINSETUP_GENERAL_field8'] ?></span></label>
      </td><td class="right">
      <input size="40" id="cfg_websitePath" name="cfg_websitePath" value="<?php echo $adminConfig['websitePath']; ?>" class="inputToolTip" title="<?php echo $langFile['PATHS_TOOLTIP_ABSOLUTE']; ?>::" />
      <span class="hint"><?php echo $langFile['PATHS_TEXT_ABSOLUTE']; ?></span>
      </td></tr>
      
      <tr><td class="spacer"></td><td></td></tr>
      
      <tr><td class="left">
      <label for="cfg_uploadPath"><span class="toolTip" title="<?php echo $langFile['ADMINSETUP_GENERAL_field4'].'::'.$langFile['ADMINSETUP_GENERAL_field4_tip'] ?>">
      <?php echo $langFile['ADMINSETUP_GENERAL_field4'] ?></span></label>
      </td><td class="right">
      <input size="40" id="cfg_uploadPath" name="cfg_uploadPath" value="<?php echo $adminConfig['uploadPath']; ?>" class="inputToolTip" title="<?php echo $langFile['PATHS_TOOLTIP_ABSOLUTE']; ?>::" />
      <span class="hint"><?php echo $langFile['PATHS_TEXT_ABSOLUTE']; ?></span>
      </td></tr>
      
      <tr><td class="left">
      <label for="cfg_websiteFilesPath"><span class="toolTip" title="<?php echo $langFile['ADMINSETUP_GENERAL_field5'].'::'.$langFile['ADMINSETUP_GENERAL_field5_tip'] ?>">
      <?php echo $langFile['ADMINSETUP_GENERAL_field5'] ?></span></label>
      </td><td class="right">
      <input size="40" id="cfg_websiteFilesPath" name="cfg_websiteFilesPath" value="<?php echo $adminConfig['websiteFilesPath']; ?>" class="inputToolTip" title="<?php echo $langFile['PATHS_TOOLTIP_ABSOLUTE']; ?>::" />
      <span class="hint"><?php echo $langFile['PATHS_TEXT_ABSOLUTE']; ?></span>
      </td></tr>
      
      <tr><td class="left">
      <label for="cfg_stylesheetPath"><span class="toolTip" title="<?php echo $langFile['ADMINSETUP_GENERAL_field6'].'::'.$langFile['ADMINSETUP_GENERAL_field6_tip'] ?>">
      <?php echo $langFile['ADMINSETUP_GENERAL_field6'] ?></span></label>
      </td><td class="right">
      <input size="40" id="cfg_stylesheetPath" name="cfg_stylesheetPath" value="<?php echo $adminConfig['stylesheetPath']; ?>" class="inputToolTip" title="<?php echo $langFile['PATHS_TOOLTIP_ABSOLUTE']; ?>::" />
      <span class="hint"><?php echo $langFile['PATHS_TEXT_ABSOLUTE']; ?></span>
      </td></tr>      
      
      <tr><td class="spacer"></td><td></td></tr>
      
      <tr><td class="left">
      <label for="cfg_permissions"><span class="toolTip" title="<?php echo $langFile['ADMINSETUP_GENERAL_TEXT_PERMISSIONS'].'::'.$langFile['ADMINSETUP_GENERAL_TIP_PERMISSIONS'] ?>">
      <?= $langFile['ADMINSETUP_GENERAL_TEXT_PERMISSIONS'] ?></span></label>
      </td><td class="right">
      <select id="cfg_permissions" name="cfg_permissions">
        <option value="0644"<?php if($adminConfig['permissions'] == 0644) echo ' selected="selected"'; ?>>644</option>
        <option value="0744"<?php if($adminConfig['permissions'] == 0744) echo ' selected="selected"'; ?>>744</option>
        <option value="0755"<?php if($adminConfig['permissions'] == 0755) echo ' selected="selected"'; ?>>755</option>
        <option value="0774"<?php if($adminConfig['permissions'] == 0774) echo ' selected="selected"'; ?>>774</option>
        <option value="0775"<?php if($adminConfig['permissions'] == 0775) echo ' selected="selected"'; ?>>775</option>
        <option value="0777"<?php if($adminConfig['permissions'] == 0777) echo ' selected="selected"'; ?>>777</option>
      </select>
      </td></tr>
      
      <tr><td class="left">
      <label for="cfg_timeZone"><span class="toolTip" title="<?php echo $langFile['ADMINSETUP_TEXT_TIMEZONE'].'::'.$langFile['ADMINSETUP_TIP_TIMEZONE'] ?>">
      <?php echo $langFile['ADMINSETUP_TEXT_TIMEZONE'] ?></span></label>
      </td><td class="right">
      <select id="cfg_timeZone" name="cfg_timeZone" style="width: 310px;">
        <?php
          if(empty($adminConfig['timeZone']))
            $adminConfig['timeZone'] = date_default_timezone_get();
        
          $storedContinent = '';
          foreach($timezones as $zone => $zoneName) {
            $continentCity = explode('/',$zoneName);
            $continent = $continentCity[0];
            array_shift($continentCity);
            $fullCityName = implode('/',$continentCity);
            
            if($storedContinent != $continent) {
              if($storedContinent != '') 
                echo '</optgroup>'."\n";
              echo '<optgroup label="'.$continent.'">'."\n";
            }
            
            $selected = ($adminConfig['timeZone'] == $zone) ? ' selected="selected"': '';
            echo '<option value="'.$zone.'"'.$selected.'>'.$fullCityName.'</option>'."\n";
            
            $storedContinent = $continent;
          }        
        ?>
        </optgroup>
      </select>
      </td></tr>
      
      <tr><td class="left">
      <label for="cfg_dateFormat"><span class="toolTip" title="<?php echo $langFile['ADMINSETUP_GENERAL_field7'].'::'.$langFile['ADMINSETUP_GENERAL_field7_tip'] ?>">
      <?php echo $langFile['ADMINSETUP_GENERAL_field7'] ?></span></label>
      </td><td class="right">
      <select id="cfg_dateFormat" name="cfg_dateFormat">
        <option value="eu"<?php if($adminConfig['dateFormat'] == 'eu') echo ' selected="selected"'; ?>><?php echo $langFile['DATE_EU'];?></option>
        <option value="int"<?php if($adminConfig['dateFormat'] == 'int') echo ' selected="selected"'; ?>><?php echo $langFile['DATE_INT'];?></option>
      </select>
      </td></tr>
      
      <tr><td class="spacer"></td><td></td></tr>
      
      <!-- URL FORMAT -> SPEAKING URLS -->
      <tr><td class="left">
      <label for="cfg_speakingUrl"><span class="toolTip" title="<?php echo $langFile['ADMINSETUP_GENERAL_speakingUrl'].'::'.$langFile['ADMINSETUP_GENERAL_speakingUrl_tip'] ?>">
      <?php echo $langFile['ADMINSETUP_GENERAL_speakingUrl'] ?></span></label>
      </td><td class="right">
      <?php
        $apacheModules = (function_exists('apache_get_modules'))
        ? apache_get_modules()
        : array(false);

      ?>
      <select id="cfg_speakingUrl" name="cfg_speakingUrl" style="width:160px;" <?php if(!in_array('mod_rewrite',$apacheModules)) echo 'disabled="disabled"'; ?>>
        <option value="true"<?php if($adminConfig['speakingUrl'] == 'true') echo ' selected="selected"'; echo ' class="inputToolTip" title="'.$langFile['ADMINSETUP_GENERAL_speakingUrl_warning'].'"'; ?>><?php echo $langFile['ADMINSETUP_GENERAL_speakingUrl_true'].' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-> '.$langFile['ADMINSETUP_GENERAL_speakingUrl_true_example'];?></option>
        <option value=""<?php if($adminConfig['speakingUrl'] == '') echo ' selected="selected"'; ?>><?php echo $langFile['ADMINSETUP_GENERAL_speakingUrl_false'].' &nbsp;&nbsp;&nbsp;-> '.$langFile['ADMINSETUP_GENERAL_speakingUrl_false_example'];?></option>
      </select>
      <span class="hint">
      <?php
        echo '<b>'.$langFile['TEXT_EXAMPLE'].':</b> ';
        
        // show the right example
        // AND disable varNames if speaking urls = true
        if($adminConfig['speakingUrl'] == 'true') {
          echo $langFile['ADMINSETUP_GENERAL_speakingUrl_true_example'];
          $varNamesStyle = ' disabled="disabled"';
        } else {
          echo $langFile['ADMINSETUP_GENERAL_speakingUrl_false_example'];
          $varNamesStyle = '';
        }
      ?>
      </span>
      </td></tr>
      
      <tr><td class="spacer"></td><td></td></tr>
      
      <tr><td class="left">
      <label for="cfg_varNamePage"><span class="toolTip" title="<?php echo $langFile['ADMINSETUP_GENERAL_varName1'].'::'.$langFile['ADMINSETUP_GENERAL_varName_tip'] ?>">
      <?php echo $langFile['ADMINSETUP_GENERAL_varName1'] ?></span></label>
      </td><td class="right">
      <input size="40" id="cfg_varNamePage" name="cfg_varNamePage" value=<?php echo '"'.$adminConfig['varName']['page'].'"'.$varNamesStyle; ?> class="inputToolTip" title="<?php echo $langFile['ADMINSETUP_GENERAL_varName1'].'::'.$langFile['ADMINSETUP_GENERAL_varName1_inputTip']; ?>" />
      </td></tr>
      
      <tr><td class="left">
      <label for="cfg_varNameCategory"><span class="toolTip" title="<?php echo $langFile['ADMINSETUP_GENERAL_varName2'].'::'.$langFile['ADMINSETUP_GENERAL_varName_tip'] ?>">
      <?php echo $langFile['ADMINSETUP_GENERAL_varName2'] ?></span></label>
      </td><td class="right">
      <input size="40" id="cfg_varNameCategory" name="cfg_varNameCategory" value=<?php echo '"'.$adminConfig['varName']['category'].'"'.$varNamesStyle; ?> class="inputToolTip" title="<?php echo $langFile['ADMINSETUP_GENERAL_varName2'].'::'.$langFile['ADMINSETUP_GENERAL_varName2_inputTip']; ?>" />
      </td></tr>
      
      <tr><td class="left">
      <label for="cfg_varNameModul"><span class="toolTip" title="<?php echo $langFile['ADMINSETUP_GENERAL_varName3'].'::'.$langFile['ADMINSETUP_GENERAL_varName_tip'] ?>">
      <?php echo $langFile['ADMINSETUP_GENERAL_varName3'] ?></span></label>
      </td><td class="right">
      <input size="40" id="cfg_varNameModul" name="cfg_varNameModul" value=<?php echo '"'.$adminConfig['varName']['modul'].'"'.$varNamesStyle; ?> class="inputToolTip" title="<?php echo $langFile['ADMINSETUP_GENERAL_varName3'].'::'.$langFile['ADMINSETUP_GENERAL_varName3_inputTip']; ?>" />
      </td></tr>
      
      <tr><td class="leftBottom"></td><td></td></tr>
      
    </table>
    
    <!--<input type="reset" value="" class="button cancel" title="<?php echo $langFile['form_cancel']; ?>" />-->
    <input type="submit" value="" name="adminConfig" class="button submit center" title="<?php echo $langFile['form_submit']; ?>" onclick="$('savedBlock').value = 'fmsSettings';" />
  </div>
  <div class="bottom"></div>
</div>

<!-- USER PERMISSIONS -->
<?php
// shows the block below if it is the ones which is saved before
$hidden = ($savedForm != 'userSettings') ? ' hidden' : '';
?>
<div class="block<?php echo $hidden; ?>">
<h1><a href="#" id="userSettings" name="userSettings"><?php echo $langFile['ADMINSETUP_USERPERMISSIONS_TITLE']; ?></a></h1>
<div class="content">
    <table>
     
      <colgroup>
      <col class="left" />
      </colgroup>      
      <?php
      
      $fmDisabled = (empty($adminConfig['uploadPath'])) ? ' disabled="disabled"' : '';
      
      ?>
      <tr><td class="left checkboxes">
      <input type="checkbox" id="cfg_userFileManager" name="cfg_userFileManager" value="true"<?php if($adminConfig['user']['fileManager']) echo ' checked="checked"'; echo $fmDisabled; ?> /><br />
      </td><td class="right checkboxes">
      <label for="cfg_userFileManager"<?= ($fmDisabled) ? 'class="toolTip disabled" title="'.$langFile['ADMINSETUP_USERPERMISSIONS_TIP_WARNING_FILEMANAGER'].'"': ''; ?>><?php echo $langFile['ADMINSETUP_USERPERMISSIONS_TEXT_FILEMANAGER']; ?></label><br />
      </td></tr>
      
      <tr><td class="left checkboxes">
      <input type="checkbox" id="cfg_userWebsiteFiles" name="cfg_userWebsiteFiles" value="true"<?php if($adminConfig['user']['editWebsiteFiles']) echo ' checked="checked"'; ?> /><br />
      </td><td class="right checkboxes">
      <label for="cfg_userWebsiteFiles"><?php echo $langFile['ADMINSETUP_USERPERMISSIONS_check1']; ?></label><br />
      </td></tr>
      
      <tr><td class="left checkboxes">
      <input type="checkbox" id="cfg_userStylesheets" name="cfg_userStylesheets" value="true"<?php if($adminConfig['user']['editStyleSheets']) echo ' checked="checked"'; ?> />
      </td><td class="right checkboxes">
      <label for="cfg_userStylesheets"><?php echo $langFile['ADMINSETUP_USERPERMISSIONS_check2']; ?></label>
      </td></tr>
      
      <tr><td class="leftTop"></td><td></td></tr>
      
      <tr><td class="left">
      <label for="cfg_userInfo"><span class="toolTip" title="<?php echo $langFile['ADMINSETUP_USERPERMISSIONS_textarea1_tip']; ?>"><?php echo $langFile['ADMINSETUP_USERPERMISSIONS_textarea1']; ?></span></label>
      </td><td class="right">
      <textarea id="cfg_userInfo" name="cfg_userInfo" cols="50" rows="2" style="white-space:normal;width:500px;" class="inputToolTip autogrow" title="<?php echo $langFile['ADMINSETUP_USERPERMISSIONS_textarea1_inputTip']; ?>"><?php echo str_replace(array('<br>','<br />','<br/>'),'',$adminConfig['user']['info']); ?></textarea>
      </td></tr>

      <tr><td class="leftBottom"></td><td></td></tr>
      
    </table>
    
    <!--<input type="reset" value="" class="button cancel" title="<?php echo $langFile['form_cancel']; ?>" />-->
    <input type="submit" value="" name="adminConfig" class="button submit center" title="<?php echo $langFile['form_submit']; ?>" onclick="$('savedBlock').value = 'userSettings';" />
  </div>
  <div class="bottom"></div>
</div>

<!-- EDITOR SETTINGS -->
<?php
// shows the block below if it is the ones which is saved before
$hidden = ($savedForm != 'editorSettings') ? ' hidden' : '';
?>
<div class="block<?php echo $hidden; ?>">
  <h1><a href="#" id="editorSettings" name="editorSettings"><?php echo $langFile['adminSetup_editorSettings_h1']; ?></a></h1>
  <div class="content">
    <table>
     
      <colgroup>
      <col class="left" />
      </colgroup>

      <tr><td class="left checkboxes">
      <input type="checkbox" id="cfg_editorSafeHtml" name="cfg_editorSafeHtml" value="true"<?php if(!isset($adminConfig['editor']['safeHtml']) || $adminConfig['editor']['safeHtml']) echo ' checked="checked"'; ?> /><br />
      </td><td class="right checkboxes">
      <label for="cfg_editorSafeHtml" class="toolTip" title="::<?= $langFile['ADMINSETUP_TIP_EDITOR_SAFEHTML']; ?>"><?= $langFile['ADMINSETUP_TEXT_EDITOR_SAFEHTML']; ?></label><br />
      </td></tr>
      
      <tr><td class="leftTop"></td><td></td></tr>
      
      <tr><td class="left">
      <label for="cfg_editorEnterMode"><span class="toolTip" title="<?php echo $langFile['adminSetup_editorSettings_field1'].'::'.$langFile['adminSetup_editorSettings_field1_tip'] ?>">
      <?php echo $langFile['adminSetup_editorSettings_field1'] ?></span></label>
      </td><td class="right">
      <select id="cfg_editorEnterMode" name="cfg_editorEnterMode">
        <option value="p" <?php if($adminConfig['editor']['enterMode'] == 'p') echo 'selected="selected"'; ?>>&lt;p&gt;</option>
        <option value="br" <?php if($adminConfig['editor']['enterMode'] == 'br') echo 'selected="selected"'; ?>>&lt;br&gt;</option>
      </select>
      &nbsp;<span class="hint"><?php echo $langFile['adminSetup_editorSettings_field1_hint']; ?></span>
      </td></tr>
      
      <tr><td class="left">
      <span class="toolTip" title="<?php echo $langFile['STYLESHEETS_TEXT_STYLEFILE'].'::'.$langFile['STYLESHEETS_TOOLTIP_STYLEFILE'] ?>">
      <?php echo $langFile['STYLESHEETS_TEXT_STYLEFILE'] ?></span>
      </td><td class="right">
      <div id="adminStyleFilesInputs" class="inputToolTip" title="<?php echo $langFile['PATHS_TOOLTIP_ABSOLUTE']; ?>::">
      <span class="hint" style="float:right;width:190px;"><?php echo $langFile['STYLESHEETS_EXAMPLE_STYLEFILE']; ?></span>
      <?php      
      
      echo showStyleFileInputs($adminConfig['editor']['styleFile'],'cfg_editorStyleFile');

      ?>
      </div>
      <a href="#" class="addStyleFilePath toolTip" title="<?php echo $langFile['STYLESHEETS_TOOLTIP_ADDSTYLEFILE']; ?>::"></a>
      </td></tr>
      
      <tr><td class="left">
      <label for="cfg_editorStyleId"><span class="toolTip" title="<?php echo $langFile['STYLESHEETS_TEXT_ID'].'::'.$langFile['STYLESHEETS_TOOLTIP_ID'] ?>">
      <?php echo $langFile['STYLESHEETS_TEXT_ID'] ?></span></label>
      </td><td class="right">
      <input id="cfg_editorStyleId" name="cfg_editorStyleId" class="inputToolTip" value="<?php echo $adminConfig['editor']['styleId']; ?>" title="<?php echo $langFile['adminSetup_editorSettings_field3_inputTip']; ?>" />
      </td></tr>
      
      <tr><td class="left">
      <label for="cfg_editorStyleClass"><span class="toolTip" title="<?php echo $langFile['STYLESHEETS_TEXT_CLASS'].'::'.$langFile['STYLESHEETS_TOOLTIP_CLASS'] ?>">
      <?php echo $langFile['STYLESHEETS_TEXT_CLASS'] ?></span></label>
      </td><td class="right">
      <input id="cfg_editorStyleClass" name="cfg_editorStyleClass" class="inputToolTip" value="<?php echo $adminConfig['editor']['styleClass']; ?>" title="<?php echo $langFile['adminSetup_editorSettings_field4_inputTip']; ?>" />
      </td></tr>
      
      <tr><td class="leftBottom"></td><td></td></tr>
      
    </table>
    
    <!--<input type="reset" value="" class="button cancel" title="<?php echo $langFile['form_cancel']; ?>" />-->
    <input type="submit" value="" name="adminConfig" class="button submit center" title="<?php echo $langFile['form_submit']; ?>" onclick="$('savedBlock').value = 'editorSettings';" />
  </div>
  <div class="bottom"></div>
</div>

</form>

<div class="blockSpacer"></div>


<!-- HIER BEGINNT DIE STIL-AUSWAHL BEARBEITUNG DES HTML EDITORS -->

<form action="index.php?site=adminSetup#fckstyleFileAnchor" method="post" enctype="multipart/form-data" accept-charset="UTF-8">
  <div><input type="hidden" name="saveFckStyleFile" value="true" /></div>

<?php

$htmlEditorStyleFilePath = "config/htmlEditorStyles.js";
$htmlEditorStyleFile = fopen($htmlEditorStyleFilePath,"r");
$htmlEditorStyleContent = fread($htmlEditorStyleFile,filesize($htmlEditorStyleFilePath));
fclose($htmlEditorStyleFile);

// shows the block below if it is the ones which is saved before
$hidden = ($savedForm != 'fckStyleFile') ? ' hidden' : '';
?>
<div class="block<?php echo $hidden; ?>">
  <h1><a href="#" name="fckstyleFileAnchor"><?php echo $langFile['adminSetup_styleFileSettings_h1']; ?></a></h1>
  <div class="content">
    <textarea name="fckStyleFile" cols="90" rows="30" class="editFiles js" id="fckStyleFile"><?php echo $htmlEditorStyleContent; ?></textarea>
    <br /><br />
    <!--<input type="reset" value="" class="button cancel" title="<?php echo $langFile['form_cancel']; ?>" />-->
    <input type="submit" value="" name="saveFckStyles" class="button submit center" title="<?php echo $langFile['form_submit']; ?>" />
  </div>
  <div class="bottom"></div>
</div>
</form>

<?php

// BEARBEITUNG DER SPRACHDATEI
editFiles($adminConfig['websiteFilesPath'], "editWebsitefile",  $langFile['editFilesSettings_h1_websitefiles'], "websiteFilesAnchor");
  

// BEARBEITUNG DER STYLESHEETDATEI
editFiles($adminConfig['stylesheetPath'], "editCSSfile", $langFile['editFilesSettings_h1_style'], "cssFilesAnchor", "css");

} // <-- END isAdmin()
?>