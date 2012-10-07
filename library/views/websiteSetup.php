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
 * sites/websiteSetup.php
 *
 * @version 2.0
 */

/**
 * Includes the login.include.php and backend.include.php and filter the basic data
 */
require_once(dirname(__FILE__).'/../includes/secure.include.php');

?>
<form action="index.php?site=websiteSetup" method="post" enctype="multipart/form-data" accept-charset="UTF-8" id="websiteSettingsForm" onsubmit="changeWebsiteLanguage(this);return false;">
  <div>
    <input type="hidden" name="send" value="websiteSetup">
    <input type="hidden" name="websiteLanguage" value="<?php echo $_SESSION['feinduraSession']['websiteLanguage']; ?>">
    <input type="hidden" name="savedBlock" id="savedBlock" value="">
  </div>

<!-- WEBSITE SETTINGS -->
<a id="websiteConfig" class="anchorTarget"></a>
<?php
// shows the block below if it is the ones which is saved before
$hidden = ($SAVEDFORM == 'websiteConfig' || empty($SAVEDFORM)) ? '' : ' hidden';
?>
<div class="block<?php echo $hidden; ?>">
  <h1><a href="#"><?php echo $langFile['websiteSetup_websiteConfig_h1']; ?></a></h1>
  <div class="content form">

    <div class="row">
      <div class="span3 formLeft">
        <label for="title"><span class="toolTipLeft" title="::<?php echo $langFile['websiteSetup_websiteConfig_field1_tip']; ?>">
        <?php echo $langFile['websiteSetup_websiteConfig_field1']; ?></span></label>
      </div>
      <div class="span5">
        <input type="text" id="title" name="title" value="<?php echo GeneralFunctions::getLocalized($websiteConfig,'title',false,true); ?>">
      </div>
    </div>

    <div class="row">
      <div class="span3 formLeft">
        <label for="publisher"><span class="toolTipLeft" title="::<?php echo $langFile['websiteSetup_websiteConfig_field2_tip']; ?>">
        <?php echo $langFile['websiteSetup_websiteConfig_field2']; ?></span></label>
      </div>
      <div class="span5">
        <input type="text" id="publisher" name="publisher" value="<?php echo GeneralFunctions::getLocalized($websiteConfig,'publisher',false,true); ?>">
      </div>
    </div>

    <div class="row">
      <div class="span3 formLeft">
        <label for="websiteConfig_copyright"><span class="toolTipLeft" title="::<?php echo $langFile['websiteSetup_websiteConfig_field3_tip']; ?>">
        <?php echo $langFile['websiteSetup_websiteConfig_field3']; ?></span></label>
      </div>
      <div class="span5">
        <input type="text" id="websiteConfig_copyright" name="websiteConfig_copyright" value="<?php echo GeneralFunctions::getLocalized($websiteConfig,'copyright',false,true); ?>">
      </div>
    </div>

    <div class="row">
      <div class="span3 formLeft">
        <label for="keywords"><span class="toolTipLeft" title="::<?php echo $langFile['websiteSetup_websiteConfig_field4_tip']; ?>">
        <?php echo $langFile['websiteSetup_websiteConfig_field4']; ?></span></label>
      </div>
      <div class="span5">
        <input type="text" id="keywords" name="keywords" value="<?php echo GeneralFunctions::getLocalized($websiteConfig,'keywords',false,true); ?>" class="input-xlarge toolTipRight" title="<?php echo $langFile['websiteSetup_websiteConfig_field4_inputTip']; ?>">
      </div>
    </div>

    <div class="row">
      <div class="span3 formLeft">
        <label for="description"><span class="toolTipLeft" title="::<?php echo $langFile['websiteSetup_websiteConfig_field5_tip']; ?>">
        <?php echo $langFile['websiteSetup_websiteConfig_field5']; ?></span></label>
      </div>
      <div class="span5">
        <textarea id="description" name="description" class="input-xlarge toolTipRight autogrow" title="<?php echo $langFile['websiteSetup_websiteConfig_field5_inputTip']; ?>"><?php echo GeneralFunctions::getLocalized($websiteConfig,'description',false,true); ?></textarea>
      </div>
    </div>

    <input type="submit" value="" name="websiteConfig" class="button submit center" title="<?php echo $langFile['FORM_BUTTON_SUBMIT']; ?>">
  </div>
</div>


<!-- ADVANCED WEBSITE SETTINGS -->
<a id="advancedWebsiteConfig" class="anchorTarget"></a>
<?php
// shows the block below if it is the ones which is saved before
$hidden = ($SAVEDFORM == 'advancedWebsiteConfig') ? '' : ' hidden';
?>
<div class="block<?php echo $hidden; ?>">
  <h1><a href="#"><?php echo $langFile['WEBSITESETUP_TITLE_PAGESETTINGS']; ?></a></h1>
  <div class="content form">

    <div class="row">
      <div class="span3 formLeft">
        <input type="checkbox" id="maintenance" name="maintenance" value="true" class="toolTipLeft" title="::<?php echo $langFile['WEBSITESETUP_TIP_MAINTENANCE']; ?>"<?php if($websiteConfig['maintenance']) echo ' checked="checked"'; ?>>
      </div>
      <div class="span5">
        <label for="maintenance"><span class="toolTipRight" title="::<?php echo $langFile['WEBSITESETUP_TIP_MAINTENANCE']; ?>"><?php echo $langFile['WEBSITESETUP_TEXT_MAINTENANCE']; ?></span></label>
      </div>
    </div>

    <div class="row">
      <div class="span3 formLeft">
        <input type="checkbox" id="sitemapFiles" name="sitemapFiles" value="true" class="toolTipLeft" title="::<?php echo $langFile['WEBSITESETUP_TIP_SITEMAPFILES']; ?>"<?php if($websiteConfig['sitemapFiles']) echo ' checked="checked"'; ?>>
      </div>
      <div class="span5">
        <label for="sitemapFiles"><span class="toolTipRight" title="::<?php echo $langFile['WEBSITESETUP_TIP_SITEMAPFILES']; ?>"><?php echo $langFile['WEBSITESETUP_TEXT_SITEMAPFILES']; ?></span></label>
      </div>
    </div>

    <div class="row">
      <div class="span3 formLeft">
        <input type="checkbox" id="visitorTimezone" name="visitorTimezone" value="true" class="toolTipLeft" title="::<?php echo $langFile['WEBSITESETUP_TIP_VISITORTIMEZONE']; ?>"<?php if($websiteConfig['visitorTimezone']) echo ' checked="checked"'; ?>>
      </div>
      <div class="span5">
        <label for="visitorTimezone"><span class="toolTipRight" title="::<?php echo $langFile['WEBSITESETUP_TIP_VISITORTIMEZONE']; ?>"><?php echo $langFile['WEBSITESETUP_TEXT_VISITORTIMEZONE']; ?></span></label>
      </div>
    </div>

    <div class="spacer"></div>

    <div class="row">
      <div class="span3 formLeft">
        <label for="dateFormat"><span class="toolTipLeft" title="::<?php echo $langFile['WEBSITESETUP_TIP_DATEFORMAT'] ?>">
        <?php echo $langFile['WEBSITESETUP_TEXT_DATEFORMAT'] ?></span></label>
      </div>
      <div class="span5">
        <select id="dateFormat" name="dateFormat">
          <option value="Y-M-D"<?php if($websiteConfig['dateFormat'] == 'Y-M-D') echo ' selected="selected"'; ?>><?php echo $langFile['DATE_Y-M-D'];?></option>
          <option value="D.M.Y"<?php if($websiteConfig['dateFormat'] == 'D.M.Y') echo ' selected="selected"'; ?>><?php echo $langFile['DATE_D.M.Y'];?></option>
          <option value="M/D/Y"<?php if($websiteConfig['dateFormat'] == 'M/D/Y') echo ' selected="selected"'; ?>><?php echo $langFile['DATE_M/D/Y'];?></option>
          <option value="D/M/Y"<?php if($websiteConfig['dateFormat'] == 'D/M/Y') echo ' selected="selected"'; ?>><?php echo $langFile['DATE_D/M/Y'];?></option>
        </select>
      </div>
    </div>

    <div class="spacer"></div>

    <div class="row">
      <div class="span3 formLeft">
        <input type="checkbox" id="multiLanguageWebsite" name="multiLanguageWebsite" value="true" <?php if($websiteConfig['multiLanguageWebsite']['active']) echo ' checked="checked"'; ?>>
      </div>
      <div class="span5">
        <label for="multiLanguageWebsite"><span><?php echo $langFile['WEBSITESETUP_TEXT_MULTILANGUAGEWEBSITE']; ?></span></label>
      </div>
    </div>

    <div id="websiteLanguagesSettings"<?php if(!$websiteConfig['multiLanguageWebsite']['active']) echo ' style="display:none"'; ?>>

      <!-- Website Language Selection -->
      <div class="row">
        <div class="offset3 span3">
          <ul id="websiteLanguagesSelect" class="jsMultipleSelect" data-jsMultipleSelect="multiLanguageWebsite" data-name="websiteLanguages" data-type="remove">
            <li class="filter"><input type="text" placeholder="<?php echo $langFile['SORTABLEPAGELIST_headText1']; ?>"></li>
            <?php
              foreach($languageNames as $langKey => $langValue) {
                echo '<li class="jsMultipleSelectOption btn" data-value="'.$langKey.'"><img src="'.GeneralFunctions::getFlagSrc($langKey).'" style="margin-top:8px; margin-left:7px;">'.$langValue.'</li>';
              }
            ?>
          </ul>

          <div class="spacer"></div>

          <ul id="websiteLanguageDestination" class="jsMultipleSelectDestination" data-jsMultipleSelect="multiLanguageWebsite">
            <?php
              if(is_array($websiteConfig['multiLanguageWebsite']['languages'])) {
                foreach($websiteConfig['multiLanguageWebsite']['languages'] as $langKey) {
                  echo '<li data-value="'.$langKey.'" data-name="websiteLanguages"></li>';
                }
              }
            ?>
          </ul>
        </div>
      </div>

      <!-- Websites Main Language -->
      <div class="row" id="websiteMainLanguageRow"<?php if(empty($websiteConfig['multiLanguageWebsite']['languages'])) echo ' style="display:none;"'; ?>>
        <div class="span3 formLeft">
          <label for="websiteMainLanguage"><span class="toolTipLeft" title="::<?php echo $langFile['WEBSITESETUP_TIP_MAINLANGUAGE']; ?>"><?php echo $langFile['WEBSITESETUP_TEXT_MAINLANGUAGE']; ?></span></label>
        </div>
        <div class="span5">
          <select id="websiteMainLanguage" name="websiteMainLanguage"<?php if(!$websiteConfig['multiLanguageWebsite']['active']) echo ' disabled="disabled"'; ?> class="toolTipRight" title="::<?php echo $langFile['WEBSITESETUP_TIP_MAINLANGUAGE']; ?>">
          <?php
            if(is_array($websiteConfig['multiLanguageWebsite']['languages'])) {
              foreach($websiteConfig['multiLanguageWebsite']['languages'] as $langKey) {
                $selected = ($langKey == $websiteConfig['multiLanguageWebsite']['mainLanguage']) ? ' selected="selected"' : '' ;
                echo '<option value="'.$langKey.'"'.$selected.'>'.$languageNames[$langKey].'</option>';
              }
            }
          ?></select>
        </div>
      </div>
    </div>

    <input type="submit" value="" class="button submit center" title="<?php echo $langFile['FORM_BUTTON_SUBMIT']; ?>">
  </div>
</div>

</form>

<?php if((!empty($adminConfig['websiteFilesPath']) && GeneralFunctions::hasPermission('editWebsiteFiles')) ||
         (!empty($adminConfig['stylesheetPath']) &&GeneralFunctions::hasPermission('editStyleSheets')) ||
         ($adminConfig['editor']['snippets'] && GeneralFunctions::hasPermission('editSnippets'))) { ?>
<div class="blockSpacer"></div>
<?php


  // EDIT snippets
  if($adminConfig['editor']['snippets'] && GeneralFunctions::hasPermission('editSnippets')) {
    if(!is_dir(dirname(__FILE__).'/../../snippets/')) mkdir(dirname(__FILE__).'/../../snippets/');
    editFiles(dirname(__FILE__).'/../../snippets/', 'snippetFiles', '<img src="library/images/icons/snippetsIcon_middle.png" class="blockH1Icon" alt="icon">'.$langFile['EDITFILESSETTINGS_TITLE_SNIPPETS'], 'snippetsFilesAnchor', 'php');
  }

  // EDIT stylesheets
  if(GeneralFunctions::hasPermission('editStyleSheets')) {
    editFiles($adminConfig['stylesheetPath'], 'cssFiles', '<img src="library/images/icons/stylesheetsIcon_middle.png" class="blockH1Icon" alt="icon">'.$langFile['EDITFILESSETTINGS_TITLE_STYLESHEETS'], 'cssFilesAnchor', 'css');
  }

  // EDIT websitefiles
  if(GeneralFunctions::hasPermission('editWebsiteFiles')) {
    editFiles($adminConfig['websiteFilesPath'], 'websiteFiles',  '<img src="library/images/icons/websitefilesIcon_middle.png" class="blockH1Icon" alt="icon">'.$langFile['EDITFILESSETTINGS_TITLE_WEBSITEFILES'], 'websiteFilesAnchor');
  }

}

?>

<!-- PAGE SCRIPTS -->
<script type="text/javascript">
/* <![CDATA[ */

  // setup the AUTOMATICALLY ADDING OF the ANCHORS
  setupForm('websiteSettingsForm');


  // KEYWORDs as TAGS
  if($('keywords') !== null) {
    new TextboxList('keywords', {
      unique: true,
      inBetweenEditableBits: false,
      // startEditableBit: false,
      bitsOptions: {
        editable: {
          addOnBlur: true,
          stopEnter: true
          // addKeys: [188, 32, 13]
        }
      },
      plugins: {
        autocomplete: {
          placeholder: false,
          showAllValues: true,
          reAddValues: true
        }
      }
    });
  }

  // -> MULTI LANGUAGE WEBSITE

  // vars
  var multiLanguageWebsiteCheckbox = $('multiLanguageWebsite');
  var hideShowMultiLanguageWebsiteBoxes = function() {
    if(multiLanguageWebsiteCheckbox.checked === true) {
      $('websiteLanguagesSettings').reveal();
      $('websiteMainLanguage').removeProperty(deactivateType);
    } else {
      $('websiteLanguagesSettings').dissolve();
      $('websiteMainLanguage').setProperty(deactivateType,deactivateType);

      // delete all languages
      $('websiteLanguageDestination').empty();
    }
  };
  var websiteLanguagesBefore = [];

  // store the opacity of the hidden /visible multi..boxes
  hideShowMultiLanguageWebsiteBoxes();

  // -> HIDE THE MULTIPLE LANGUAGE fields if "multiple languages" checkbox is deactivated
  multiLanguageWebsiteCheckbox.addEvent('change',hideShowMultiLanguageWebsiteBoxes);


  // MULTI SELECT EVENTS

  // PARSED
  $('websiteLanguageDestination').addEvent('parsed',function(value,name,clone,option){
    websiteLanguagesBefore.push(value);
  });

  // SELECT
  $('websiteLanguageDestination').addEvent('select',function(value,name,clone,option){

    // ADD to MAIN LANGUAGES
    // get selected languages
    var option = new Element('option',{
      'value':value,
      'text':clone.get('text').replace('×','')
    });
    // -> add the selection to the mainLanguage <select>
    option.inject($('websiteMainLanguage'));

    // show the mainLanguage <select> if its not empty
    if($('websiteMainLanguage').getChildren().length === 1) $('websiteMainLanguageRow').show();
  });

  // REMOVE
  $('websiteLanguageDestination').addEvent('remove',function(value,name,clone,option){

    // REMOVE the MAIN LANGUAGE
    $('websiteMainLanguage').getChildren().each(function(mainLanguageOption) {
      if(mainLanguageOption.get('value') === value)
        mainLanguageOption.destroy();
    });

    // HIDE the multiLangaugeSelections, if the MAINLANGUAGE <select> IS EMPTY
    if($('websiteMainLanguage').getChildren().length === 0) {
      $('websiteMainLanguageRow').hide();
      $('websiteLanguagesSettings').dissolve();
      multiLanguageWebsiteCheckbox.checked = false;
      multiLanguageWebsiteCheckbox.retrieve('fancyform_replacment').removeClass('fancyform_checked').addClass('fancyform_unchecked');
    }
  });


  // -> ONSUBMIT CHECK for DELTED LANGUAGES
  var changeWebsiteLanguage = function(form){

    // vars
    var newLangs = $('websiteLanguageDestination').getElements('input').get('value');
    var removedLangs = [];
    var removedLangString = '';
    var status = '';

    // get removed languages
    websiteLanguagesBefore.each(function(value){
      if(!newLangs.contains(value)) {
        removedLangs.push(value);
      }
    });

    // IF MULTI LANGUAGES were DEACTIVATED
    if(!multiLanguageWebsiteCheckbox.checked) {
      status = 'deactivated';
      websiteLanguagesBefore.each(function(lang){
        removedLangString += lang;
        if(lang != websiteLanguagesBefore[websiteLanguagesBefore.length-1])
          removedLangString += ',';
      });
    // IF LANGUAGES were REMOVED
    } else if(removedLangs.length > 0) {
      status = 'changed';
      removedLangs.each(function(lang){
        removedLangString += lang;
        if(lang != removedLangs[removedLangs.length-1])
          removedLangString += ',';
      });
    }


    // -> show dialog if languages will be deleted
    if(removedLangString !== '') {
      // e.stop();
      openWindowBox('library/views/windowBox/deleteWebsiteLanguages.php?site=pageSetup&status='+status+'&mainLanguage='+$('websiteMainLanguage').get('value')+'&languages='+removedLangString,'');
    } else {
      form.submit();
    }

    // reset the website Languages variable
    // websiteLanguages = Array.clone($('websiteLanguages').getChildren('option').get('value'));
  };

  // // -> before submit CHECK if languages were changed
  // if(navigator.appVersion.match(/MSIE ([0-8]\.\d)/))
  //   $$('#websiteSettingsForm input.submit').addEvent('click',changeWebsiteLanguage);
  // else
  //   $('websiteSettingsForm').addEvent('submit',changeWebsiteLanguage);

/* ]]> */
</script>