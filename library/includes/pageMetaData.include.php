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
 * includes/pageMetaData.include.php
 *
 * @version 0.1
 */

/**
 * Includes the login.include.php and backend.include.php and filter the basic data
 */
require_once(dirname(__FILE__)."/../includes/secure.include.php");

// vars
$autofocus = ($NEWPAGE) ? ' autofocus="autofocus"' : '';

?>

<div class="row">
  <div class="span3 formLeft">
    <label for="edit_title"><span class="toolTipLeft" title="::<?php echo $langFile['EDITOR_pageSettings_title_tip'] ?>">
    <?php echo $langFile['EDITOR_pageSettings_title'] ?></span></label>
  </div>
  <div class="span5">
    <input type="text" id="edit_title" name="title" value="<?php echo str_replace('"','&quot;',GeneralFunctions::getLocalized($pageContent,'title',false,true)); ?>"<?php echo $autofocus; ?> class="input-xlarge toolTipRight" title="<?php echo $langFile['EDITOR_pageSettings_title'].'::'.$langFile['EDITOR_pageSettings_title_tip'] ?>">
  </div>
</div>

<!-- ***** PAGE DESCRIPTION -->
<div class="row">
  <div class="span3 formLeft">
    <label for="edit_description"><span class="toolTipLeft" title="::<?php echo $langFile['EDITOR_pageSettings_field1_tip']; ?>">
    <?php echo $langFile['EDITOR_pageSettings_field1']; ?></span></label>
  </div>
  <div class="span5">
    <textarea id="edit_description" name="description" style="white-space:normal;" class="input-xlarge toolTipRight autogrow" title="::<?php echo $langFile['EDITOR_pageSettings_field1_inputTip']; ?>"><?php echo GeneralFunctions::getLocalized($pageContent,'description',false,true); ?></textarea>
  </div>
</div>
<?php

// -> CHECK if page date or tags are activated, show the spacer
if($categoryConfig[$_GET['category']]['showPageDate'] ||
   $categoryConfig[$_GET['category']]['showTags']) {
  echo '<div class="spacer"></div>';
}

// ->> CHECK if activated
if($categoryConfig[$_GET['category']]['showPageDate']) { ?>

<!-- ***** PAGE DATE -->
<div class="row">
  <div class="span3 formLeft">
    <?php

      // add the DATE of TODAY, if its a NEW PAGE
      if($categoryConfig[$_GET['category']]['pageDateAsRange']) {

        if(empty($pageContent['pageDate']['end']))
          $pageContent['pageDate']['end'] = $pageContent['pageDate']['start'];

        $pageDate = ($NEWPAGE)
          ? GeneralFunctions::formatDate(time()).' - '.GeneralFunctions::formatDate(strtotime('+1 day'))
          : GeneralFunctions::formatDate($pageContent['pageDate']['start']).' - '.GeneralFunctions::formatDate($pageContent['pageDate']['end']);
        $dateFormatExample = $langFile['DATE_'.$backendDateFormat].' - '.$langFile['DATE_'.$backendDateFormat];
        if($pageDate == ' - ' || $pageDate == '0 - 0')
          $pageDate = false;
      } else {
        $pageDate = ($NEWPAGE)
          ? GeneralFunctions::formatDate(time())
          : GeneralFunctions::formatDate($pageContent['pageDate']['start']);
        $dateFormatExample = $langFile['DATE_'.$backendDateFormat];
        if($pageDate == '0')
          $pageDate = false;
      }

      // CHECKs the DATE FORMAT
      if(empty($pageDate))
        echo '<label for="pageDate" class="toolTipLeft red" title="::[strong][span class=red]'.$langFile['EDITOR_PAGESETTINGS_NOPAGEDATE'].'[/span][br]'.$langFile['WEBSITESETUP_TEXT_DATEFORMAT'].'[/strong][br]'.$dateFormatExample.'">'.$langFile['EDITOR_pageSettings_field3'].'</label>';
      else
        echo '<label for="pageDate" class="toolTipLeft" title="'.$langFile['EDITOR_pageSettings_field3'].'::'.$langFile['EDITOR_pageSettings_field3_tip'].'">'.$langFile['EDITOR_pageSettings_field3'].'</label>';
    ?>
  </div>
  <div class="span5">
      <input type="text" class="datePicker toolTipTop" name="pageDate" id="pageDate" value="<?php echo $pageDate; ?>" title="::<?php echo $langFile['EDITOR_pageSettings_field3_tip']; ?>">
  </div>
</div>

<div class="spacer"></div>

<?php }

// ->> CHECK if activated
if($categoryConfig[$_GET['category']]['showTags']) {
?>
<!-- ***** TAGS -->
<div class="row">
  <div class="span3 formLeft">
    <label for="edit_tags"><span class="toolTipLeft" title="::<?php echo $langFile['EDITOR_pageSettings_field2_tip'] ?>">
    <?php echo $langFile['EDITOR_pageSettings_field2'] ?></span></label>
  </div>
  <div class="span5">
      <input type="text" id="edit_tags" name="tags" class="toolTipRight" value="<?php echo GeneralFunctions::getLocalized($pageContent,'tags',false,true); ?>" title="<?php echo $langFile['EDITOR_pageSettings_field2'].'::'.$langFile['EDITOR_pageSettings_field2_tip_inputTip']; ?>">
  </div>
</div>
<?php } ?>

<div class="spacer"></div>

<?php
if($categoryConfig[$_GET['category']]['showSubCategory']) {
?>
<!-- ***** Subcategory selection -->
<div class="row">
  <div class="span3 formLeft">
    <label for="subCategory" class="toolTipLeft" title="::<?php echo $langFile['EDITOR_TIP_SUBCATEGORY']; ?>"><strong><?php echo $langFile['EDITOR_TEXT_SUBCATEGORY']; ?></strong>
    <img src="library/images/icons/categoryIcon_subCategory_middle.png" style="margin-top: -5px;" alt="icon">
    </label>
  </div>
  <div class="span5">
    <select name="subCategory" id="subCategory" class="toolTipRight" title="<?php echo $langFile['EDITOR_TEXT_SUBCATEGORY'].'::'.$langFile['EDITOR_TIP_SUBCATEGORY']; ?>">';
    <?php
      echo '<option>-</option>';
      // ->> goes trough categories and list them
      foreach($categoryConfig as $listCategory) {
        // overjump the non-category
        if($listCategory['id'] == 0) continue;

        $selected = ($listCategory['id'] == $pageContent['subCategory']) ? ' selected="selected"' : $selected = '';
        echo '<option value="'.$listCategory['id'].'"'.$selected.'>'.GeneralFunctions::getLocalized($listCategory,'name').'</option>'."\n";
      }

    ?>
    </select>
  </div>
</div>
<?php } ?>

<div class="spacer"></div>

<!-- ***** PUBLIC/UNPUBLIC -->
<?php

if($NEWPAGE)
  $pageContent['public'] = false;

?>
<div class="row">
  <div class="span3 formLeft">
    <input type="checkbox" id="edit_public" name="public" value="true" <?php if($pageContent['public']) echo 'checked'; ?>>
  </div>
  <div class="span5">
    <label for="edit_public">
    <?php
      $publicSignStyle = ' style="position:relative; top:-3px; float:left;"';

    // shows the public or unpublic picture
    if($pageContent['public'])
      echo '<img src="library/images/icons/page_public.png" class="toolTipBottom" title="'.$langFile['STATUS_PAGE_PUBLIC'].'"'.$publicSignStyle.' alt="icon public" width="27" height="27">';
    else
      echo '<img src="library/images/icons/page_nonpublic.png" class="toolTipBottom" title="'.$langFile['STATUS_PAGE_NONPUBLIC'].'"'.$publicSignStyle.' alt="icon nonpublic" width="27" height="27">';

    ?>
    &nbsp;<span class="toolTipRight" title="::<?php echo $langFile['EDITOR_pageSettings_field4_tip'] ?>">
    <?php echo $langFile['EDITOR_pageSettings_field4']; ?></span></label>
  </div>
</div>

<!-- **** MENU STATUS -->
<div class="row">
  <div class="span3 formLeft">
    <input type="checkbox" id="edit_showInMenus" name="showInMenus" value="true" <?php if($pageContent['showInMenus'] || $NEWPAGE) echo 'checked'; ?>>
  </div>
  <div class="span5">
    <label for="edit_showInMenus">
    <span class="toolTipRight" title="::<?php echo $langFile['BUTTON_TOOLTIP_SHOWHIDEINMENU'] ?>">
    <?php echo $langFile['BUTTON_SHOWINMENU']; ?></span></label>
  </div>
</div>

<!-- **** STARTPAGE -->
<div class="row">
  <div class="span3 formLeft">
    <input type="checkbox" id="edit_setStartPage" name="setStartPage" value="true" <?php if($pageContent['id'] == $websiteConfig['startPage']) echo 'checked'; ?>>
  </div>
  <div class="span5">
    <label for="edit_setStartPage">
    <?php echo $langFile['SORTABLEPAGELIST_functions_startPage']; ?></label>
  </div>
</div>


<!-- PAGE SCRIPTS -->
<script type="text/javascript">
/* <![CDATA[ */

  // set the localization for the datepicker (and all other Mootools tools, which need localization)
  <?php
  switch($_SESSION['feinduraSession']['backendLanguage']) {
    case 'de':
      echo  'Locale.use("de-DE");';
      echo 'var jsDateFormat = "%d.%m.%Y"';
      break;
    case 'fr':
      echo  'Locale.use("fr-FR");';
      echo 'var jsDateFormat = "%d/%m/%Y"';
      break;
    case 'it':
      echo  'Locale.use("it-IT");';
      echo 'var jsDateFormat = "%d.%m.%Y"';
      break;
    case 'ru':
      echo  'Locale.use("ru-RU");';
      echo 'var jsDateFormat = "%d.%m.%Y"';
      break;
    case 'en':
      if($_SESSION['feinduraSession']['backendLanguageLocale'] == 'en-US') {
        echo 'Locale.use("en-US");';
        echo 'var jsDateFormat = "%m/%d/%Y"';
        break;
      }
    default:
      echo  'Locale.use("en-GB");';
      echo 'var jsDateFormat = "%d.%m.%Y"';
      break;
  }
  ?>

  <?php if($categoryConfig[$_GET['category']]['pageDateAsRange']) { ?>

  // DATE RANGE
  var datePicker = new Picker.Date.Range($$('input.datePicker'), {
    format: jsDateFormat,
    openLastView: true,
    // timePicker: true,
    positionOffset: {x: -140, y: 5},
    pickerClass: 'datepicker_feindura range',
    useFadeInOut: !Browser.ie
  }).addEvent('open',function(e){
    datePicker.footer.getElements('button').addClass('btn');
    datePicker.footer.getElements('button').setStyle('float','right');
    datePicker.footer.getElements('input').setProperty('type','text');
    datePicker.footer.getElements('input').setStyle('width',150);
  });

  <?php } else { ?>

  // SINGLE DATE
  new Picker.Date($$('input.datePicker'), {
    format: jsDateFormat,
    openLastView: true,
    // timePicker: true,
    positionOffset: {x: -40, y: 5},
    pickerClass: 'datepicker_feindura',
    useFadeInOut: !Browser.ie
  });

  <?php } ?>

/* ]]> */
</script>