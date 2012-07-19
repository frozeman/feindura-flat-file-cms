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

// vars
$post = (!empty($_POST)) ? $_POST : $_GET;
$error = false;

// WHEN THE FORM WAS SEND
if($post['send'] == 'true') {

  $newUserConfig = $userConfig;
  $newUserConfig[$post['userId']]['permissions']['frontendEditing']  = $post['frontendEditing'];
  $newUserConfig[$post['userId']]['permissions']['fileManager']      = (empty($adminConfig['uploadPath'])) ? false : $post['fileManager'];
  $newUserConfig[$post['userId']]['permissions']['editWebsiteFiles'] = $post['editWebsiteFiles'];
  $newUserConfig[$post['userId']]['permissions']['editStyleSheets']  = $post['editStyleSheets'];
  $newUserConfig[$post['userId']]['permissions']['editSnippets']     = $post['editSnippets'];

  if(saveUserConfig($newUserConfig)) {
    saveActivityLog(28,$savedUsername); // <- SAVE the task in a LOG FILE

    // CLOSE the windowBox, if the first part of the response is '#CLOSE#'
    die('#CLOSE#');

  } else
    echo '<div class="alert alert-error">'.sprintf($langFile['USERSETUP_error_save'],$adminConfig['basePath']).'</div>';
    echo '<a href="?site=userSetup" class="button ok center" onclick="closeWindowBox();return false;"></a>';

// SHOW THE FORM
} else {

?>

<form action="?site=userPermissions" method="post" enctype="multipart/form-data" id="userPermissionsForm" onsubmit="requestSite('<?php echo $_SERVER['PHP_SELF']; ?>','','userPermissionsForm');return false;" accept-charset="UTF-8">
  <div>
    <input type="hidden" name="send" value="true">
    <input type="hidden" name="userId" value="<?php echo $post['userId']; ?>">
  </div>

  <div class="row">
    <div class="span3 right">
      <input type="checkbox" id="frontendEditing" name="frontendEditing" value="true"<?php if($userConfig[$post['userId']]['permissions']['frontendEditing']) echo ' checked="checked"'; echo $fmDisabled; ?>>
    </div>
    <div class="span5">
      <label for="frontendEditing"><?php echo $langFile['USERSETUP_USERPERMISSIONS_TEXT_FRONTENDEDITING']; ?></label>
    </div>
  </div>

  <?php $fmDisabled = (empty($adminConfig['uploadPath'])) ? ' disabled="disabled"' : ''; ?>
  <div class="row">
    <div class="span3 right">
      <input type="checkbox" id="fileManager" name="fileManager" value="true"<?php if($userConfig[$post['userId']]['permissions']['fileManager']) echo ' checked="checked"'; echo $fmDisabled; ?>>
    </div>
    <div class="span5">
      <label for="fileManager"<?php echo ($fmDisabled) ? 'class="toolTipLeft disabled" title="'.$langFile['USERSETUP_USERPERMISSIONS_TIP_FILEMANAGER'].'"': ''; ?>><?php echo $langFile['USERSETUP_USERPERMISSIONS_TEXT_FILEMANAGER']; ?></label>
    </div>
  </div>

  <?php if(!empty($adminConfig['websiteFilesPath'])) { ?>
  <div class="row">
    <div class="span3 right">
      <input type="checkbox" id="editWebsiteFiles" name="editWebsiteFiles" value="true"<?php if($userConfig[$post['userId']]['permissions']['editWebsiteFiles']) echo ' checked="checked"'; ?>>
    </div>
    <div class="span5">
      <label for="editWebsiteFiles"><?php echo $langFile['ADMINSETUP_USERPERMISSIONS_check1']; ?></label>
    </div>
  </div>
  <?php } ?>

  <?php if(!empty($adminConfig['stylesheetPath'])) { ?>
  <div class="row">
    <div class="span3 right">
      <input type="checkbox" id="editStyleSheets" name="editStyleSheets" value="true"<?php if($userConfig[$post['userId']]['permissions']['editStyleSheets']) echo ' checked="checked"'; ?>>
    </div>
    <div class="span5">
      <label for="editStyleSheets"><?php echo $langFile['USERSETUP_USERPERMISSIONS_TEXT_EDITSTYLESHEETS']; ?></label>
    </div>
  </div>
  <?php } ?>

  <?php if(!empty($adminConfig['editor']['snippets'])) { ?>
  <div class="row">
    <div class="span3 right">
      <input type="checkbox" id="editSnippets" name="editSnippets" value="true"<?php if($userConfig[$post['userId']]['permissions']['editSnippets']) echo ' checked="checked"'; ?>>
    </div>
    <div class="span5">
      <label for="editSnippets"><?php echo $langFile['USERSETUP_USERPERMISSIONS_TEXT_EDITSNIPPETS']; ?></label>
    </div>
  </div>
  <?php } ?>

  <div class="row buttons">
    <div class="span4 center">
      <a href="?site=userSetup" class="button cancel" onclick="closeWindowBox();return false;"></a>
    </div>
    <div class="span4 center">
      <input type="submit" value="" class="button submit">
    </div>
  </div>

</form>

<!-- PAGE SCRIPTS -->
<script type="text/javascript">
/* <![CDATA[ */
  $('windowBox').addEvent('loaded',function(){
    new FancyForm('#windowBox input[type="checkbox"], #windowBox input[type="radio"]');
    $$('#windowBox textarea.autogrow').each(function(textarea){
      new Form.AutoGrow(textarea);
    });
  });
/* ]]> */
</script>

<?php } ?>