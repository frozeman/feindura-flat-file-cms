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

<form action="index.php?site=adminSetup" method="post" enctype="multipart/form-data" accept-charset="UTF-8" id="adminSettingsForm">
  <div>
  <input type="hidden" name="send" value="adminSetup">
  <input type="hidden" name="savedBlock" id="savedBlock" value="">
  </div>

<!-- BASIC SETTINGS -->
<a id="adminSettings" class="anchorTarget"></a>
<?php
// shows the block below if it is the ones which is saved before
$hidden = ($savedForm !== false && $savedForm != 'adminSettings' && checkBasePathAndURL() && !documentrootWarning()) ? ' hidden' : '';
?>
<div class="block<?php echo $hidden; ?>">
  <h1><a href="#"><?php echo $langFile['ADMINSETUP_GENERAL_h1']; ?></a></h1>
  <div class="content">
    <table>

      <colgroup>
      <col class="left">
      </colgroup>

      <tbody>
        <tr><td class="leftTop"></td><td></td></tr>

        <tr><td class="left">
        <label for="cfg_url"><span class="toolTip" title="::<?php echo $langFile['ADMINSETUP_GENERAL_field1_tip'] ?>">
        <?php echo $langFile['ADMINSETUP_GENERAL_field1'] ?></span></label>
        </td><td class="right">
        <?php
        $baseUrl = preg_replace('#^[a-zA-Z]+[:]{1}[\/\/]{2}#','',$GLOBALS['adminConfig']['url']);
        $checkUrl = preg_replace('#^[a-zA-Z]+[:]{1}[\/\/]{2}#','',$_SERVER["SERVER_NAME"]);
        ?>
        <input id="cfg_url" name="cfg_url"<?php if($baseUrl != $checkUrl) echo ' style="color:#C5451F !important;" value="'.$langFile['ADMINSETUP_GENERAL_field1_inputWarningText'].'"'; else echo ' value="'.$adminConfig['url'].'"'; ?> readonly="readonly" class="inputToolTip" title="<?php echo $langFile['ADMINSETUP_GENERAL_field1_inputTip']; ?>">
        </td></tr>

        <tr><td class="left">
        <label for="cfg_basePath"><span class="toolTip" title="::<?php echo $langFile['ADMINSETUP_GENERAL_field2_tip'] ?>">
        <?php echo $langFile['ADMINSETUP_GENERAL_field2'] ?></span></label>
        </td><td class="right">
        <?php
        $checkPath = GeneralFunctions::URI2Path(GeneralFunctions::getDirname($_SERVER['PHP_SELF']));
        ?>
        <input id="cfg_basePath" name="cfg_basePath"<?php if($adminConfig['basePath'] != $checkPath) echo ' style="color:#C5451F !important;" value="'.$langFile['ADMINSETUP_GENERAL_field2_inputWarningText'].'"'; else echo ' value="'.$adminConfig['basePath'].'"'; ?> readonly="readonly" class="inputToolTip" title="<?php echo $langFile['ADMINSETUP_GENERAL_field2_inputTip']; ?>">
        </td></tr>

        <tr><td class="left">
        <label for="cfg_websitePath"><span class="toolTip" title="::<?php echo $langFile['ADMINSETUP_GENERAL_field8_tip'] ?>">
        <?php echo $langFile['ADMINSETUP_GENERAL_field8'] ?></span></label>
        </td><td class="right">
        <input size="40" id="cfg_websitePath" name="cfg_websitePath" value="<?php echo $adminConfig['websitePath']; ?>" class="inputToolTip" title="<?php echo $langFile['PATHS_TOOLTIP_ABSOLUTE']; ?>">
        <span class="hint toolTip" title="<?php echo $langFile['PATHS_TOOLTIP_ABSOLUTE']; ?>"><?php echo $langFile['PATHS_TEXT_ABSOLUTE']; ?></span>
        </td></tr>

        <tr><td class="spacer"></td><td></td></tr>

        <tr><td class="left">
        <label for="cfg_uploadPath"><span class="toolTip" title="::<?php echo $langFile['ADMINSETUP_GENERAL_field4_tip'] ?>">
        <?php echo $langFile['ADMINSETUP_GENERAL_field4'] ?></span></label>
        </td><td class="right">
        <input size="40" id="cfg_uploadPath" name="cfg_uploadPath" value="<?php echo $adminConfig['uploadPath']; ?>" class="inputToolTip" title="<?php echo $langFile['PATHS_TOOLTIP_ABSOLUTE']; ?>::">
        <span class="hint toolTip" title="<?php echo $langFile['PATHS_TOOLTIP_ABSOLUTE']; ?>"><?php echo $langFile['PATHS_TEXT_ABSOLUTE']; ?></span>
        </td></tr>

        <tr><td class="left">
        <label for="cfg_stylesheetPath"><span class="toolTip" title="::<?php echo $langFile['ADMINSETUP_GENERAL_field6_tip'] ?>">
        <?php echo $langFile['ADMINSETUP_GENERAL_field6'] ?></span></label>
        </td><td class="right">
        <input size="40" id="cfg_stylesheetPath" name="cfg_stylesheetPath" value="<?php echo $adminConfig['stylesheetPath']; ?>" class="inputToolTip" title="<?php echo $langFile['PATHS_TOOLTIP_ABSOLUTE']; ?>">
        <span class="hint toolTip" title="<?php echo $langFile['PATHS_TOOLTIP_ABSOLUTE']; ?>"><?php echo $langFile['PATHS_TEXT_ABSOLUTE']; ?></span>
        </td></tr>

        <tr><td class="left">
        <label for="cfg_websiteFilesPath"><span class="toolTip" title="::<?php echo $langFile['ADMINSETUP_GENERAL_field5_tip'] ?>">
        <?php echo $langFile['ADMINSETUP_GENERAL_field5'] ?></span></label>
        </td><td class="right">
        <input size="40" id="cfg_websiteFilesPath" name="cfg_websiteFilesPath" value="<?php echo $adminConfig['websiteFilesPath']; ?>" class="inputToolTip" title="<?php echo $langFile['PATHS_TOOLTIP_ABSOLUTE']; ?>">
        <span class="hint toolTip" title="<?php echo $langFile['PATHS_TOOLTIP_ABSOLUTE']; ?>"><?php echo $langFile['PATHS_TEXT_ABSOLUTE']; ?></span>
        </td></tr>

        <tr><td class="spacer"></td><td></td></tr>

        <tr><td class="left">
        <label for="cfg_permissions"><span class="toolTip" title="::<?php echo $langFile['ADMINSETUP_GENERAL_TIP_PERMISSIONS'] ?>">
        <?php echo $langFile['ADMINSETUP_GENERAL_TEXT_PERMISSIONS'] ?></span></label>
        </td><td class="right">
        <select id="cfg_permissions" name="cfg_permissions">
          <!--
          <option value="0744"<?php if($adminConfig['permissions'] == 0744) echo ' selected="selected"'; ?>>744</option>
          <option value="0754"<?php if($adminConfig['permissions'] == 0754) echo ' selected="selected"'; ?>>754</option>
          -->
          <option value="0755"<?php if($adminConfig['permissions'] == 0755) echo ' selected="selected"'; ?>>755</option>
          <option value="0775"<?php if($adminConfig['permissions'] == 0775) echo ' selected="selected"'; ?>>775</option>
          <option value="0777"<?php if($adminConfig['permissions'] == 0777) echo ' selected="selected"'; ?>>777</option>
        </select>
        </td></tr>

        <tr><td class="left">
        <label for="cfg_timeZone"><span class="toolTip" title="::<?php echo $langFile['ADMINSETUP_TIP_TIMEZONE'] ?>">
        <?php echo $langFile['ADMINSETUP_TEXT_TIMEZONE'] ?></span></label>
        </td><td class="right">
        <select id="cfg_timeZone" name="cfg_timeZone" style="width: 310px;">
          <?php
            if(empty($adminConfig['timezone']))
              $adminConfig['timezone'] = date_default_timezone_get();

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

              $selected = ($adminConfig['timezone'] == $zone) ? ' selected="selected"': '';
              echo '<option value="'.$zone.'"'.$selected.'>'.$fullCityName.'</option>'."\n";

              $storedContinent = $continent;
            }
          ?>
          </optgroup>
        </select>
        </td></tr>

        <tr><td class="left">
        <label for="cfg_dateFormat"><span class="toolTip" title="::<?php echo $langFile['ADMINSETUP_GENERAL_field7_tip'] ?>">
        <?php echo $langFile['ADMINSETUP_GENERAL_field7'] ?></span></label>
        </td><td class="right">
        <select id="cfg_dateFormat" name="cfg_dateFormat">
          <option value="YMD"<?php if($adminConfig['dateFormat'] == 'YMD') echo ' selected="selected"'; ?>><?php echo $langFile['DATE_YMD'];?></option>
          <option value="DMY"<?php if($adminConfig['dateFormat'] == 'DMY') echo ' selected="selected"'; ?>><?php echo $langFile['DATE_DMY'];?></option>
          <option value="MDY"<?php if($adminConfig['dateFormat'] == 'MDY') echo ' selected="selected"'; ?>><?php echo $langFile['DATE_MDY'];?></option>
        </select>
        </td></tr>

        <tr><td class="spacer"></td><td></td></tr>

        <!-- URL FORMAT -> SPEAKING URLS -->
        <tr><td class="left">
        <label for="cfg_speakingUrl"><span class="toolTip" title="::<?php echo $langFile['ADMINSETUP_GENERAL_speakingUrl_tip'] ?>">
        <?php echo $langFile['ADMINSETUP_GENERAL_speakingUrl'] ?></span></label>
        </td><td class="right">
        <?php
          $apacheModules = (function_exists('apache_get_modules'))
          ? apache_get_modules()
          : array('mod_rewrite');
        ?>
        <select id="cfg_speakingUrl" name="cfg_speakingUrl" style="width:160px;" class="inputToolTip" title="<?php echo $langFile['ADMINSETUP_GENERAL_speakingUrl_warning'] ?>"<?php if(!in_array('mod_rewrite',$apacheModules)) echo ' disabled="disabled"'; ?>>
          <option value="true"<?php if($adminConfig['speakingUrl'] == 'true') echo ' selected="selected"'; ?>><?php echo $langFile['ADMINSETUP_GENERAL_speakingUrl_true'].' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-> '.$langFile['ADMINSETUP_GENERAL_speakingUrl_true_example'];?></option>
          <option value=""<?php if($adminConfig['speakingUrl'] == '') echo ' selected="selected"'; ?>><?php echo $langFile['ADMINSETUP_GENERAL_speakingUrl_false'].' &nbsp;&nbsp;&nbsp;-> '.sprintf($langFile['ADMINSETUP_GENERAL_speakingUrl_false_example'],$adminConfig['varName']['category'],$adminConfig['varName']['page']);?></option>
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
            echo sprintf($langFile['ADMINSETUP_GENERAL_speakingUrl_false_example'],$adminConfig['varName']['category'],$adminConfig['varName']['page']);
            $varNamesStyle = '';
          }
        ?>
        </span>
        </td></tr>

        <tr><td class="spacer"></td><td></td></tr>

        <tr><td class="left">
        <label for="cfg_varNamePage"><span class="toolTip" title="::<?php echo $langFile['ADMINSETUP_GENERAL_varName_tip'] ?>">
        <?php echo $langFile['ADMINSETUP_GENERAL_varName1'] ?></span></label>
        </td><td class="right">
        <input size="40" id="cfg_varNamePage" name="cfg_varNamePage" value=<?php echo '"'.$adminConfig['varName']['page'].'"'.$varNamesStyle; ?> class="inputToolTip" title="<?php echo $langFile['ADMINSETUP_GENERAL_varName1'].'::'.$langFile['ADMINSETUP_GENERAL_varName1_inputTip']; ?>">
        </td></tr>

        <tr><td class="left">
        <label for="cfg_varNameCategory"><span class="toolTip" title="::<?php echo $langFile['ADMINSETUP_GENERAL_varName_tip'] ?>">
        <?php echo $langFile['ADMINSETUP_GENERAL_varName2'] ?></span></label>
        </td><td class="right">
        <input size="40" id="cfg_varNameCategory" name="cfg_varNameCategory" value=<?php echo '"'.$adminConfig['varName']['category'].'"'.$varNamesStyle; ?> class="inputToolTip" title="<?php echo $langFile['ADMINSETUP_GENERAL_varName2'].'::'.$langFile['ADMINSETUP_GENERAL_varName2_inputTip']; ?>">
        </td></tr>

        <!--
        <tr><td class="left">
        <label for="cfg_varNameModul"><span class="toolTip" title="::<?php echo $langFile['ADMINSETUP_GENERAL_varName_tip'] ?>">
        <?php echo $langFile['ADMINSETUP_GENERAL_varName3'] ?></span></label>
        </td><td class="right">
        <input size="40" id="cfg_varNameModul" name="cfg_varNameModul" value=<?php echo '"'.$adminConfig['varName']['modul'].'"'.$varNamesStyle; ?> class="inputToolTip" title="<?php echo $langFile['ADMINSETUP_GENERAL_varName3'].'::'.$langFile['ADMINSETUP_GENERAL_varName3_inputTip']; ?>">
        </td></tr>
        -->

        <tr><td class="leftBottom"></td><td></td></tr>
        <tr><td class="spacer checkboxes"></td><td></td></tr>

        <tr><td class="left checkboxes">
        <input type="checkbox" id="cfg_cache" name="cfg_cache" value="true"<?php if($adminConfig['cache']['active']) echo ' checked="checked"'; ?> class="toolTip" title="<?php echo $langFile['ADMINSETUP_TEXT_CACHE'].'::'.$langFile['ADMINSETUP_TIP_CACHE']; ?>"><br>
        </td><td class="right checkboxes">
        <label for="cfg_cache" class="toolTip" title="::<?php echo $langFile['ADMINSETUP_TIP_CACHE']; ?>"><?php echo $langFile['ADMINSETUP_TEXT_CACHE']; ?></label><br>
        </td></tr>

        <!-- <tr><td class="leftTop"></td><td></td></tr> -->

        <tr><td class="left leftTop">
        <label for="cfg_cacheTimeout"><span class="toolTip" title="::<?php echo $langFile['ADMINSETUP_TIP_CACHETIMEOUT'] ?>">
        <?php echo $langFile['ADMINSETUP_TEXT_CACHETIMEOUT'] ?></span></label>
        </td><td class="right">
        <input type="number" step="0.5" size="40" id="cfg_cacheTimeout" name="cfg_cacheTimeout" value=<?php echo '"'.$adminConfig['cache']['timeout'].'"'; ?> class="inputToolTip short" title="<?php echo $langFile['ADMINSETUP_TEXT_CACHETIMEOUT'].'::'.$langFile['ADMINSETUP_TIP_CACHETIMEOUT']; ?>"<?php if(!$adminConfig['cache']['active']) echo ' disabled="disabled"'; ?>><span class="hint"><?php echo $langFile['ADMINSETUP_HINT_CACHETIMEOUT']; ?></span>
        </td></tr>

        <tr><td class="leftBottom"></td><td></td></tr>
      </tbody>
    </table>

    <!--<input type="reset" value="" class="button cancel" title="<?php echo $langFile['FORM_BUTTON_CANCEL']; ?>">-->
    <input type="submit" value="" name="adminConfig" class="button submit center" title="<?php echo $langFile['FORM_BUTTON_SUBMIT']; ?>" onclick="$('savedBlock').value = 'adminSettings'; submitAnchor('adminSettingsForm','adminSettings');">
  </div>
  <div class="bottom"></div>
</div>

<!-- USER PERMISSIONS -->
<a id="userSettings" class="anchorTarget"></a>
<?php
// shows the block below if it is the ones which is saved before
$hidden = ($savedForm != 'userSettings') ? ' hidden' : '';
?>
<div class="block<?php echo $hidden; ?>">
<h1><a href="#"><?php echo $langFile['ADMINSETUP_USERPERMISSIONS_TITLE']; ?></a></h1>
<div class="content">
    <table>

      <colgroup>
      <col class="left">
      </colgroup>

      <tbody>
        <tr><td class="left checkboxes">
        <input type="checkbox" id="cfg_userFrontendEditing" name="cfg_userFrontendEditing" value="true"<?php if(!isset($adminConfig['user']['frontendEditing']) || $adminConfig['user']['frontendEditing']) echo ' checked="checked"'; echo $fmDisabled; ?>><br>
        </td><td class="right checkboxes">
        <label for="cfg_userFrontendEditing"><?php echo $langFile['ADMINSETUP_USERPERMISSIONS_TEXT_FRONTENDEDITING']; ?></label><br>
        </td></tr>

        <tr><td class="left checkboxes">
        <?php $fmDisabled = (empty($adminConfig['uploadPath'])) ? ' disabled="disabled"' : ''; ?>
        <input type="checkbox" id="cfg_userFileManager" name="cfg_userFileManager" value="true"<?php if($adminConfig['user']['fileManager']) echo ' checked="checked"'; echo $fmDisabled; ?>><br>
        </td><td class="right checkboxes">
        <label for="cfg_userFileManager"<?php echo ($fmDisabled) ? 'class="toolTip disabled" title="'.$langFile['ADMINSETUP_USERPERMISSIONS_TIP_WARNING_FILEMANAGER'].'"': ''; ?>><?php echo $langFile['ADMINSETUP_USERPERMISSIONS_TEXT_FILEMANAGER']; ?></label><br>
        </td></tr>

        <?php if(!empty($adminConfig['websiteFilesPath'])) { ?>
        <tr><td class="left checkboxes">
        <input type="checkbox" id="cfg_userWebsiteFiles" name="cfg_userWebsiteFiles" value="true"<?php if($adminConfig['user']['editWebsiteFiles']) echo ' checked="checked"'; ?>><br>
        </td><td class="right checkboxes">
        <label for="cfg_userWebsiteFiles"><?php echo $langFile['ADMINSETUP_USERPERMISSIONS_check1']; ?></label><br>
        </td></tr>
        <?php } ?>

        <?php if(!empty($adminConfig['stylesheetPath'])) { ?>
        <tr><td class="left checkboxes">
        <input type="checkbox" id="cfg_userStylesheets" name="cfg_userStylesheets" value="true"<?php if($adminConfig['user']['editStyleSheets']) echo ' checked="checked"'; ?>>
        </td><td class="right checkboxes">
        <label for="cfg_userStylesheets"><?php echo $langFile['ADMINSETUP_USERPERMISSIONS_check2']; ?></label>
        </td></tr>
        <?php } ?>

        <?php if(!empty($adminConfig['editor']['snippets'])) { ?>
        <tr><td class="left checkboxes">
        <input type="checkbox" id="cfg_userSnippets" name="cfg_userSnippets" value="true"<?php if($adminConfig['user']['editSnippets']) echo ' checked="checked"'; ?>><br>
        </td><td class="right checkboxes">
        <label for="cfg_userSnippets"><?php echo $langFile['ADMINSETUP_TEXT_USEREDITSNIPPETS']; ?></label><br>
        </td></tr>
        <?php } ?>

        <tr><td class="leftTop"></td><td></td></tr>

        <tr><td class="left">
        <label for="cfg_userInfo"><span class="toolTip" title="<?php echo $langFile['ADMINSETUP_USERPERMISSIONS_textarea1_tip']; ?>"><?php echo $langFile['ADMINSETUP_USERPERMISSIONS_textarea1']; ?></span></label>
        </td><td class="right">
        <textarea id="cfg_userInfo" name="cfg_userInfo" cols="50" rows="2" style="white-space:normal;width:500px;" class="inputToolTip autogrow" title="<?php echo $langFile['ADMINSETUP_USERPERMISSIONS_textarea1_inputTip']; ?>"><?php echo str_replace(array('<br>','<br>','<br/>'),'',$adminConfig['user']['info']); ?></textarea>
        </td></tr>

        <tr><td class="leftBottom"></td><td></td></tr>
      </tbody>
    </table>

    <!--<input type="reset" value="" class="button cancel" title="<?php echo $langFile['FORM_BUTTON_CANCEL']; ?>">-->
    <input type="submit" value="" name="adminConfig" class="button submit center" title="<?php echo $langFile['FORM_BUTTON_SUBMIT']; ?>" onclick="$('savedBlock').value = 'userSettings'; submitAnchor('adminSettingsForm','userSettings');">
  </div>
  <div class="bottom"></div>
</div>

<!-- EDITOR SETTINGS -->
<a id="editorSettings" class="anchorTarget"></a>
<?php
// shows the block below if it is the ones which is saved before
$hidden = ($savedForm != 'editorSettings') ? ' hidden' : '';
?>
<div class="block<?php echo $hidden; ?>">
  <h1><a href="#"><?php echo $langFile['adminSetup_editorSettings_h1']; ?></a></h1>
  <div class="content">
    <table>

      <colgroup>
      <col class="left">
      </colgroup>

      <tbody>
        <tr><td class="left checkboxes">
        <input type="checkbox" id="cfg_editorHtmlLawed" name="cfg_editorHtmlLawed" onclick="disableSafeHtml(this);" value="true"<?php if($adminConfig['editor']['htmlLawed']) echo ' checked="checked"'; ?>><br>
        </td><td class="right checkboxes">
        <label for="cfg_editorHtmlLawed" class="toolTip" title="::<?php echo $langFile['ADMINSETUP_TIP_EDITOR_HTMLLAWED']; ?>"><?php echo $langFile['ADMINSETUP_TEXT_EDITOR_HTMLLAWED']; ?></label><br>
        </td></tr>

        <tr><td class="left checkboxes">
        <input type="checkbox" id="cfg_editorSafeHtml" name="cfg_editorSafeHtml" value="true"<?php if(!$adminConfig['editor']['htmlLawed']) echo ' disabled="disabled"';if($adminConfig['editor']['safeHtml']) echo ' checked="checked"'; ?>><br>
        </td><td class="right checkboxes">
        <label for="cfg_editorSafeHtml" class="toolTip" title="::<?php echo $langFile['ADMINSETUP_TIP_EDITOR_SAFEHTML']; ?>"><?php echo $langFile['ADMINSETUP_TEXT_EDITOR_SAFEHTML']; ?></label><br>
        </td></tr>

        <tr><td class="left checkboxes">
        <input type="checkbox" id="cfg_editorStyles" name="cfg_editorStyles" value="true"<?php if($adminConfig['editor']['editorStyles']) echo ' checked="checked"'; ?>><br>
        </td><td class="right checkboxes">
        <label for="cfg_editorStyles" class="toolTip" title="::<?php echo $langFile['ADMINSETUP_TIP_EDITOR_EDITORSTYLES']; ?>"><?php echo $langFile['ADMINSETUP_TEXT_EDITOR_EDITORSTYLES']; ?></label><br>
        </td></tr>

        <tr><td class="left checkboxes">
        <input type="checkbox" id="cfg_snippets" name="cfg_snippets" value="true"<?php if($adminConfig['editor']['snippets']) echo ' checked="checked"'; ?>><br>
        </td><td class="right checkboxes">
        <label for="cfg_snippets" class="toolTip" title="::<?php echo $langFile['ADMINSETUP_TIP_EDITOR_SNIPPETS']; ?>"><?php echo $langFile['ADMINSETUP_TEXT_EDITOR_SNIPPETS']; ?></label><br>
        </td></tr>

        <tr><td class="leftTop"></td><td></td></tr>

        <tr><td class="left">
        <label for="cfg_editorEnterMode"><span class="toolTip" title="::<?php echo $langFile['adminSetup_editorSettings_field1_tip'] ?>">
        <?php echo $langFile['adminSetup_editorSettings_field1'] ?></span></label>
        </td><td class="right">
        <select id="cfg_editorEnterMode" name="cfg_editorEnterMode">
          <option value="p" <?php if($adminConfig['editor']['enterMode'] == 'p') echo 'selected="selected"'; ?>>&lt;p&gt;</option>
          <option value="br" <?php if($adminConfig['editor']['enterMode'] == 'br') echo 'selected="selected"'; ?>>&lt;br&gt;</option>
        </select>
        <?php
        $enterMode = ($adminConfig['editor']['enterMode'] == 'p') ? '&lt;br&gt;': '&lt;p&gt;';
        ?>
        &nbsp;<span class="hint"><?php echo sprintf($langFile['adminSetup_editorSettings_field1_hint'],'<span id="enterModeOpposite" style="font-weight:bold;">'.$enterMode.'</span>'); ?></span>
        </td></tr>

        <tr><td class="left">
        <span class="toolTip" title="::<?php echo $langFile['STYLESHEETS_TOOLTIP_STYLEFILE'] ?>">
        <?php echo $langFile['STYLESHEETS_TEXT_STYLEFILE'] ?></span>
        </td><td class="right">
        <div id="adminStyleFilesInputs" class="inputToolTip" title="<?php echo $langFile['PATHS_TOOLTIP_ABSOLUTE']; ?>">
        <span class="hint" style="float:right;width:190px;"><?php echo $langFile['STYLESHEETS_EXAMPLE_STYLEFILE']; ?></span>
        <?php

          echo showStyleFileInputs($categoryConfig[0]['styleFile'],'cfg_editorStyleFile');

        ?>
        </div>
        <a href="#" class="addStyleFilePath toolTip" title="<?php echo $langFile['STYLESHEETS_TOOLTIP_ADDSTYLEFILE']; ?>::"></a>
        </td></tr>

        <tr><td class="left">
        <label for="cfg_editorStyleId"><span class="toolTip" title="::<?php echo $langFile['STYLESHEETS_TOOLTIP_ID'] ?>">
        <?php echo $langFile['STYLESHEETS_TEXT_ID'] ?></span></label>
        </td><td class="right">
        <input id="cfg_editorStyleId" name="cfg_editorStyleId" class="inputToolTip" value="<?php echo $categoryConfig[0]['styleId']; ?>" title="<?php echo $langFile['adminSetup_editorSettings_field3_inputTip']; ?>">
        </td></tr>

        <tr><td class="left">
        <label for="cfg_editorStyleClass"><span class="toolTip" title="::<?php echo $langFile['STYLESHEETS_TOOLTIP_CLASS'] ?>">
        <?php echo $langFile['STYLESHEETS_TEXT_CLASS'] ?></span></label>
        </td><td class="right">
        <input id="cfg_editorStyleClass" name="cfg_editorStyleClass" class="inputToolTip" value="<?php echo $categoryConfig[0]['styleClass']; ?>" title="<?php echo $langFile['adminSetup_editorSettings_field4_inputTip']; ?>">
        </td></tr>

        <tr><td class="leftBottom"></td><td></td></tr>
      </tbody>
    </table>

    <input type="submit" value="" name="adminConfig" class="button submit center" title="<?php echo $langFile['FORM_BUTTON_SUBMIT']; ?>" onclick="$('savedBlock').value = 'editorSettings'; submitAnchor('adminSettingsForm','editorSettings');">
  </div>
  <div class="bottom"></div>
</div>

</form>

<?php if(!empty($adminConfig['websiteFilesPath']) || !empty($adminConfig['stylesheetPath']) || $adminConfig['editor']['editorStyles']) { ?>
<div class="blockSpacer"></div>
<?php }


// EDIT stylesheets
if(!empty($adminConfig['stylesheetPath']))
  editFiles($adminConfig['stylesheetPath'], 'cssFiles', $langFile['EDITFILESSETTINGS_TITLE_STYLESHEETS'], 'cssFilesAnchor', 'css');

// EDIT snippets
if($adminConfig['editor']['snippets']) {
  if(!is_dir(dirname(__FILE__).'/../../snippets/')) mkdir(dirname(__FILE__).'/../../snippets/');
  editFiles(dirname(__FILE__).'/../../snippets/', 'snippetFiles', $langFile['EDITFILESSETTINGS_TITLE_SNIPPETS'], 'snippetsFilesAnchor', 'php');
}

// EDIT websitefiles
if(!empty($adminConfig['websiteFilesPath']))
  editFiles($adminConfig['websiteFilesPath'], 'websiteFiles',  $langFile['EDITFILESSETTINGS_TITLE_WEBSITEFILES'], 'websiteFilesAnchor');

?>

<?php if($adminConfig['editor']['editorStyles']) { ?>
<!-- EDIT editor-styles -->
<form action="index.php?site=adminSetup#fckstyleFileAnchor" method="post" enctype="multipart/form-data" accept-charset="UTF-8">
<div><input type="hidden" name="saveFckStyleFile" value="true"></div>
<?php

$htmlEditorStyleFilePath = "config/EditorStyles.js";
if($htmlEditorStyleFile = @fopen($htmlEditorStyleFilePath,"r")) {
  $htmlEditorStyleContent = fread($htmlEditorStyleFile,filesize($htmlEditorStyleFilePath));
  fclose($htmlEditorStyleFile);
} else
  $htmlEditorStyleContent = '';

// -> fill when with standard styles when its empty
if(strpos($htmlEditorStyleContent,'CKEDITOR.addStylesSet') === false)
  $htmlEditorStyleContent = "CKEDITOR.addStylesSet( 'htmlEditorStyles',
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

// shows the block below if it is the ones which is saved before
$hidden = ($savedForm != 'fckStyleFile') ? ' hidden' : '';
?>
<div class="block<?php echo $hidden; ?>">
  <h1><a href="#" id="fckstyleFileAnchor"><?php echo $langFile['adminSetup_styleFileSettings_h1']; ?></a></h1>
  <div class="content">
    <span style="font-size:10px">&nbsp;&nbsp;Details: <a href="http://docs.cksource.com/CKEditor_3.x/Developers_Guide/Styles" target="_blank">http://docs.cksource.com/CKEditor_3.x/Developers_Guide/Styles</a></span>
    <textarea name="fckStyleFile" cols="90" rows="30" spellcheck="false" class="editFiles js" id="fckStyleFile"><?php echo $htmlEditorStyleContent; ?></textarea>
    <br><br>
    <!--<input type="reset" value="" class="button cancel" title="<?php echo $langFile['FORM_BUTTON_CANCEL']; ?>">-->
    <input type="submit" value="" name="saveFckStyles" class="button submit center" title="<?php echo $langFile['FORM_BUTTON_SUBMIT']; ?>">
  </div>
  <div class="bottom"></div>
</div>
</form>
<?php } ?>