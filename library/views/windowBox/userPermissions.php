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
 * deletePageLanguage.php
 *
 * @version 0.1
 */

/**
 * Includes the login.include.php and backend.include.php and filter the basic data
 */
require_once(dirname(__FILE__)."/../../includes/secure.include.php");

echo ' '; // hack for safari, otherwise it throws an error that he could not find htmlentities like &ouml;

?>

<h1><a href="#"><?php echo $langFile['USERSETUP_USERPERMISSIONS_TITLE']; ?></a></h1>
<div class="content">
    <table>

      <colgroup>
      <col class="left">
      </colgroup>

      <tbody>
        <tr><td class="left checkboxes">
        <input type="checkbox" id="cfg_userFrontendEditing" name="cfg_userFrontendEditing" value="true"<?php if(!isset($adminConfig['user']['frontendEditing']) || $adminConfig['user']['frontendEditing']) echo ' checked="checked"'; echo $fmDisabled; ?>><br>
        </td><td class="right checkboxes">
        <label for="cfg_userFrontendEditing"><?php echo $langFile['USERSETUP_USERPERMISSIONS_TEXT_FRONTENDEDITING']; ?></label><br>
        </td></tr>

        <tr><td class="left checkboxes">
        <?php $fmDisabled = (empty($adminConfig['uploadPath'])) ? ' disabled="disabled"' : ''; ?>
        <input type="checkbox" id="cfg_userFileManager" name="cfg_userFileManager" value="true"<?php if($adminConfig['user']['fileManager']) echo ' checked="checked"'; echo $fmDisabled; ?>><br>
        </td><td class="right checkboxes">
        <label for="cfg_userFileManager"<?php echo ($fmDisabled) ? 'class="toolTip disabled" title="'.$langFile['USERSETUP_USERPERMISSIONS_TIP_FILEMANAGER'].'"': ''; ?>><?php echo $langFile['USERSETUP_USERPERMISSIONS_TEXT_FILEMANAGER']; ?></label><br>
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
        <label for="cfg_userStylesheets"><?php echo $langFile['USERSETUP_USERPERMISSIONS_TEXT_EDITSTYLESHEETS']; ?></label>
        </td></tr>
        <?php } ?>

        <?php if(!empty($adminConfig['editor']['snippets'])) { ?>
        <tr><td class="left checkboxes">
        <input type="checkbox" id="cfg_userSnippets" name="cfg_userSnippets" value="true"<?php if($adminConfig['user']['editSnippets']) echo ' checked="checked"'; ?>><br>
        </td><td class="right checkboxes">
        <label for="cfg_userSnippets"><?php echo $langFile['USERSETUP_USERPERMISSIONS_TEXT_EDITSNIPPETS']; ?></label><br>
        </td></tr>
        <?php } ?>

        <tr><td class="leftTop"></td><td></td></tr>

        <tr><td class="left">
        <label for="cfg_userInfo"><span class="toolTip" title="<?php echo $langFile['USERSETUP_USERPERMISSIONS_TIP_USERINFORMATION']; ?>"><?php echo $langFile['USERSETUP_USERPERMISSIONS_TEXT_USERINFORMATION']; ?></span></label>
        </td><td class="right">
        <textarea id="cfg_userInfo" name="cfg_userInfo" cols="50" rows="2" style="white-space:normal;width:500px;" class="inputToolTip autogrow" title="<?php echo $langFile['USERSETUP_USERPERMISSIONS_TIP_USERINFORMATION_NOINFO']; ?>"><?php echo str_replace(array('<br>','<br>','<br/>'),'',$adminConfig['user']['info']); ?></textarea>
        </td></tr>

        <tr><td class="leftBottom"></td><td></td></tr>
      </tbody>
    </table>

    <input type="submit" value="" name="adminConfig" class="button submit center" title="<?php echo $langFile['FORM_BUTTON_SUBMIT']; ?>" onclick="$('savedBlock').value = 'userSettings'; submitAnchor('adminSettingsForm','userSettings');">
  </div>