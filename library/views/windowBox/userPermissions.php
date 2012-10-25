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
 * userPermissions.php
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

// WHEN THE FORM WAS SEND
if($post['send'] == 'true') {

  $newUserConfig = $userConfig;
  $newUserConfig[$post['userId']]['permissions']['frontendEditing']    = $post['frontendEditing'];
  $newUserConfig[$post['userId']]['permissions']['fileManager']        = $post['fileManager'];
  $newUserConfig[$post['userId']]['permissions']['websiteSettings']    = $post['websiteSettings'];
  $newUserConfig[$post['userId']]['permissions']['editWebsiteFiles']   = $post['editWebsiteFiles'];
  $newUserConfig[$post['userId']]['permissions']['editStyleSheets']    = $post['editStyleSheets'];
  $newUserConfig[$post['userId']]['permissions']['editSnippets']       = $post['editSnippets'];

  $newUserConfig[$post['userId']]['permissions']['editableCategories'] = $post['editableCategories'];
  $newUserConfig[$post['userId']]['permissions']['editablePages']      = $post['editablePages'];

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

<!--   <div class="row">
    <div class="span3 right">
      <input type="checkbox" id="frontendEditing" name="frontendEditing" value="true"<?php if($userConfig[$post['userId']]['permissions']['frontendEditing']) echo ' checked="checked"'; echo $fmDisabled; ?>>
    </div>
    <div class="span5">
      <label for="frontendEditing"><?php echo $langFile['USERSETUP_USERPERMISSIONS_TEXT_FRONTENDEDITING']; ?></label>
    </div>
  </div> -->

  <div class="row">
    <div class="span3 right">
      <input type="checkbox" id="fileManager" name="fileManager" value="true"<?php if($userConfig[$post['userId']]['permissions']['fileManager']) echo ' checked="checked"'; ?>>
    </div>
    <div class="span5">
      <label for="fileManager"><?php echo $langFile['USERSETUP_USERPERMISSIONS_TEXT_FILEMANAGER']; ?></label>
    </div>
  </div>

  <div class="spacer"></div>

  <div class="row">
    <div class="span3 right">
      <input type="checkbox" id="websiteSettings" name="websiteSettings" value="true"<?php if($userConfig[$post['userId']]['permissions']['websiteSettings']) echo ' checked="checked"'; ?>>
    </div>
    <div class="span5">
      <label for="websiteSettings"><?php echo $langFile['USERSETUP_USERPERMISSIONS_TEXT_ACTIVATEWEBSITESETTINGS']; ?></label>
    </div>
  </div>

  <div id="additionalWebsiteSettings" <?php if(!$userConfig[$post['userId']]['permissions']['websiteSettings']) echo ' style="display:none;"'; ?>>

    <?php if(!empty($adminConfig['websiteFilesPath'])) { ?>
    <div class="row">
      <div class="span3 right">
        <input type="checkbox" id="editWebsiteFiles" name="editWebsiteFiles" value="true"<?php if($userConfig[$post['userId']]['permissions']['editWebsiteFiles']) echo ' checked="checked"'; ?>>
      </div>
      <div class="span5">
        <label for="editWebsiteFiles"><?php echo $langFile['USERSETUP_USERPERMISSIONS_TEXT_EDITWEBSITEFILES']; ?></label>
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

  </div>

  <div class="spacer2x"></div>

  <div class="row">
    <div class="offset1 span6"><h3 class="center"><?php echo $langFile['USERSETUP_USERPERMISSIONS_TITLE_EDITABLECATEGORIES-PAGES']; ?></h3></div>
  </div>
  <div class="row">
    <div class="offset1 span3">
      <ul class="jsMultipleSelect" data-jsMultipleSelect="editables" data-name="editableCategories" data-type="remove">
        <li class="filter"><input type="text" placeholder="<?php echo $langFile['SORTABLEPAGELIST_headText1']; ?>"></li>
        <?php
          foreach ($categoryConfig as $config) {
            echo '<li class="jsMultipleSelectOption btn" data-value="'.$config['id'].'"><img src="library/images/icons/categoryIcon_small.png" alt="category icon"><strong>'.GeneralFunctions::getLocalized($config,'name').'</strong></li>';
          }
        ?>
      </ul>
      <?php
      if(!empty($pagesMetaData) && is_array($pagesMetaData)) {
      ?>
      <div class="spacer"></div>
      <ul class="jsMultipleSelect" data-jsMultipleSelect="editables" data-name="editablePages" data-type="remove">
        <li class="filter"><input type="text" placeholder="<?php echo $langFile['SORTABLEPAGELIST_headText1']; ?>"></li>
        <?php
          foreach ($pagesMetaData as $pageMetaData) {
            if($pageMetaData['category'] != 0)
              $category = '<strong>'.GeneralFunctions::getLocalized($categoryConfig[$pageMetaData['category']],'name').'</strong> » ';
            echo '<li class="jsMultipleSelectOption btn" data-value="'.$pageMetaData['id'].'"><img src="library/images/icons/pageIcon_small.png" alt="page icon">'.$category.GeneralFunctions::getLocalized($pageMetaData,'title').'</li>';
          }
        ?>
      </ul>
      <?php } ?>
    </div>
    <div class="span3 right">
      <ul class="jsMultipleSelectDestination" data-jsMultipleSelect="editables">
        <?php
          // add selected editableCategories
          if(is_array($userConfig[$post['userId']]['permissions']['editableCategories'])) {
            foreach ($userConfig[$post['userId']]['permissions']['editableCategories'] as $editableCategory) {
              echo '<li data-value="'.$editableCategory.'" data-name="editableCategories"></li>';
            }
          }
          // add selected editablePages
          if(is_array($userConfig[$post['userId']]['permissions']['editablePages'])) {
            foreach ($userConfig[$post['userId']]['permissions']['editablePages'] as $editablePage) {
              echo '<li data-value="'.$editablePage.'" data-name="editablePages"></li>';
            }
          }
        ?>
      </ul>
      <a class="clearJsMultipleSelect btn btn-mini" data-jsMultipleSelect="editables"><?php echo $langFile['USERSETUP_USERPERMISSIONS_TEXT_CLEARSELECTION']; ?></a>
    </div>
  </div>

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
  windowBox.addEvent('loaded',function(){ // event is fired when the windowBox is ready

    // adds cross browser placeholder support
    new PlaceholderSupport();

    // enable drag selection
    new jsMultipleSelect();

    $$('input#websiteSettings').addEvent('change',function(){
      if(this.checked && $('additionalWebsiteSettings') !== null)
        $('additionalWebsiteSettings').setStyle('display','block');
      else
        $('additionalWebsiteSettings').setStyle('display','none');
    });
  });
/* ]]> */
</script>
<?php } ?>