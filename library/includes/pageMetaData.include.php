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
$autofocus = ($newPage) ? ' autofocus="autofocus"' : '';

?>

<div class="row">
  <div class="span3 formLeft">
    <label for="edit_title"><span class="toolTipLeft" title="::<?php echo $langFile['EDITOR_pageSettings_title_tip'] ?>">
    <?php echo $langFile['EDITOR_pageSettings_title'] ?></span></label>
  </div>
  <div class="span5">
    <input type="text" id="edit_title" name="title" value="<?php echo str_replace('"','&quot;',GeneralFunctions::getLocalized($pageContent,'title',true)); ?>"<?php echo $autofocus; ?> class="toolTipRight" title="<?php echo $langFile['EDITOR_pageSettings_title'].'::'.$langFile['EDITOR_pageSettings_title_tip'] ?>">
  </div>
</div>

<!-- ***** PAGE DESCRIPTION -->
<div class="row">
  <div class="span3 formLeft">
    <label for="edit_description"><span class="toolTipLeft" title="::<?php echo $langFile['EDITOR_pageSettings_field1_tip']; ?>">
    <?php echo $langFile['EDITOR_pageSettings_field1']; ?></span></label>
  </div>
  <div class="span5">
    <textarea id="edit_description" name="description" style="white-space:normal;" class="toolTipRight autogrow" title="<?php echo $langFile['EDITOR_pageSettings_field1_inputTip']; ?>"><?php echo GeneralFunctions::getLocalized($pageContent,'description',true); ?></textarea>
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

<!-- ***** SORT DATE -->
<?php

// check if already a (wrong) pageDate exists
$pageDate = (isset($pageDate))
  ? $pageDate
  : $pageContent['pageDate']['date'];

// add the DATE of TODAY, if its a NEW PAGE
$pageDate = ($newPage)
  ? time()
  : $pageDate;

?>

<div class="row">
  <div class="span3 formLeft">
    <?php
      // GET date format LANGUAGE TEXT
      $dateFormat = $langFile['DATE_'.$websiteConfig['dateFormat']];

      // CHECKs the DATE FORMAT
      if(empty($pageDate) || validateDateString($pageDate) === false)
        echo '<label for="pageDate[before]" class="toolTipLeft red" title="'.$langFile['EDITOR_pageSettings_pagedate_error'].'::'.$langFile['EDITOR_pageSettings_pagedate_error_tip'].'[br][strong]'.$langFile['DATE_'.$dateFormat].'[/strong]"><strong>'.$langFile['EDITOR_pageSettings_pagedate_error'].'</strong></label>';
      else
        echo '<label for="pageDate[before]" class="toolTipLeft" title="'.$langFile['EDITOR_pageSettings_field3'].'::'.$langFile['EDITOR_pageSettings_field3_tip'].'">'.$langFile['EDITOR_pageSettings_field3'].'</label>';
    ?>
  </div>
  <div class="span5">
      <?php
      $pageDateBeforeAfter = GeneralFunctions::getLocalized($pageContent,'pageDate',true);
      ?>
      <input type="text" class="datePicker" name="pageDate[before]" id="pageDate[before]" value="<?php echo $pageDateBeforeAfter['before']; ?>" class="toolTipTop" title="<?php echo $langFile['EDITOR_pageSettings_pagedate_before_inputTip']; ?>" style="width:130px;">

      <?php

      // -> creates DAY selection
      $pageDateTags['day'] = '<select name="pageDate[day]" class="toolTipTop" title="'.$langFile['EDITOR_pageSettings_pagedate_day_inputTip'].'">'."\n";
      for($i = 1; $i <= 31; $i++) {
        // adds following zero
        if(strlen($i) == 1)
          $countDays = '0'.$i;
        else $countDays = $i;
        // selects the selected month
        if(substr($pageDate,-2) == $countDays ||
           (preg_match('/^[0-9]{1,}$/',$pageDate) && date('d',$pageDate) == $countDays))
          $selected = ' selected="selected"';
        else $selected = null;
        $pageDateTags['day'] .= '<option value="'.$countDays.'"'.$selected.'>'.$countDays.'</option>'."\n";
      }
      $pageDateTags['day'] .= '</select>'."\n";

      // -> creates MONTH selection
      $pageDateTags['month'] = '<select name="pageDate[month]" class="toolTipTop" title="'.$langFile['EDITOR_pageSettings_pagedate_month_inputTip'].'">'."\n";
      for($i = 1; $i <= 12; $i++) {
        // adds following zero
        if(strlen($i) == 1)
          $countMonths = '0'.$i;
        else $countMonths = $i;
        // selects the selected month
        if(substr($pageDate,-5,2) == $countMonths ||
           (preg_match('/^[0-9]{1,}$/',$pageDate) && date('m',$pageDate) == $countMonths))
          $selected = ' selected="selected"';
        else $selected = null;
        $pageDateTags['month'] .= '<option value="'.$countMonths.'"'.$selected.'>'.$countMonths.'</option>'."\n";
      }
      $pageDateTags['month'] .= '</select>'."\n";

      // -> creates YEAR selection
      $year = substr($pageDate,0,4);
      if(strlen($pageDate) > 4 && preg_match('/^[0-9]{1,}$/',$pageDate))
        $year = date('Y',$pageDate);
      elseif(preg_match('/^[0-9]{4}$/',$year))
        $year = $year;
      else
        $year = null;

      $pageDateTags['year'] = '<input type="number" step="1" class="short toolTipTop" name="pageDate[year]" title="'.$langFile['EDITOR_pageSettings_pagedate_year_inputTip'].'" value="'.$year.'" maxlength="4">'."\n";

      // -> SHOWS the PAGE DATE INPUTS
      switch ($websiteConfig['dateFormat']) {
        case 'D.M.Y':
          echo $pageDateTags['day'].' . '.$pageDateTags['month'].' . '.$pageDateTags['year'];
          break;
        case 'M/D/Y':
          echo $pageDateTags['month'].' / '.$pageDateTags['day'].' / '.$pageDateTags['year'];
          break;
        case 'D/M/Y':
          echo $pageDateTags['month'].' / '.$pageDateTags['day'].' / '.$pageDateTags['year'];
          break;

        default:
          echo $pageDateTags['year'].' - '.$pageDateTags['month'].' - '.$pageDateTags['day'];
          break;
      }

      ?>

      <input type="number" step="1" name="pageDate[after]" value="<?php echo $pageDateBeforeAfter['after']; ?>" class="toolTipTop" title="<?php echo $langFile['EDITOR_pageSettings_pagedate_after_inputTip']; ?>" style="width:122px;">
  </div>
</div>

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
      <input type="text" id="edit_tags" name="tags" class="toolTipRight" value="<?php echo GeneralFunctions::getLocalized($pageContent,'tags',true); ?>" title="<?php echo $langFile['EDITOR_pageSettings_field2'].'::'.$langFile['EDITOR_pageSettings_field2_tip_inputTip']; ?>">
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

<?php

switch (variable) {
  case 'value':
    # code...
    break;
  
  default:
    # code...
    break;
}

?>


<!-- PAGE SCRIPTS -->
<script type="text/javascript">
/* <![CDATA[ */

  // set the localization for the datepicker (and all other Mootools tools, which need localization)
  Locale.use('<?php
  switch($_SESSION['feinduraSession']['backendLanguage']) {
    case 'en-US':
      echo  'en-US';
      break;
    case 'de':
      echo  'de-DE';
      break;
    case 'fr':
      echo  'fr-FR';
      break;
    case 'it':
      echo  'it-IT';
      break;
    case 'ru':
      echo  'ru-RU';
      break;
    default:
      echo  'en-GB';
      break;
  }
  ?>');

  // translate the date format
  var jsDateFormat = '<?php
  switch($backendDateFormat) {
    case 'D.M.Y':
      echo  '%d.%m.%Y';
      break;
    case 'M/D/Y':
      echo  '%m/%d/%Y';
      break;
    case 'D/M/Y':
      echo  '%d/%m/%Y';
      break;
    default:
      echo  '%Y-%m-%d';
      break;
  }
  ?>';

  // ADD DATEPICKER
  new Picker.Date($$('input.datePicker'), {
    format: jsDateFormat,
    openLastView: true,
    // timePicker: true,
    positionOffset: {x: 0, y: 5},
    pickerClass: 'datepicker_feindura',
    useFadeInOut: !Browser.ie
  });

/* ]]> */
</script>