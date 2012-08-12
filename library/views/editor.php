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
 * sites/editor.php
 *
 * @version 2.0
 */

/**
 * Includes the login.include.php and backend.include.php and filter the basic data
 */
require_once(dirname(__FILE__)."/../includes/secure.include.php");

// -> available VARs from the editor.controller.php
// string   $pageTitle

// -> available VARs from index.php -> subMenu
// array    $missingLanguages

// VARS
// get the activated plugins
$activatedPlugins = unserialize($categoryConfig[$_GET['category']]['plugins']);

// ->> SHOW the FORM
echo '<form action="index.php?category='.$_GET['category'].'&amp;page='.$_GET['page'].'" method="post" accept-charset="UTF-8" id="editorForm" class="Page'.$_GET['page'].'">
      <div>
        <input type="hidden" name="save" value="true">
        <input type="hidden" name="category" value="'.$_GET['category'].'">
        <input type="hidden" name="id" value="'.$_GET['page'].'">
        <input type="hidden" name="websiteLanguage" value="'.$_SESSION['feinduraSession']['websiteLanguage'].'">
        <input type="hidden" name="status" value="'.$_GET['status'].'">
        <input type="hidden" name="savedBlock" id="savedBlock" value="">
      </div>';
?>

<!-- page information anchor is here -->
<a id="pageInformation" class="anchorTarget"></a>

<div class="block open pageHeader">
<?php


// shows ID and different header color if its a CATEGORY
$headerColorClass = ($_GET['category'] != 0)
  ? 'blue' //" comes in the h1
  : 'brown'; //" comes in the h1

// get Title
if($newPage && $_GET['status'] == 'addLanguage')
  $pageTitle = sprintf($langFile['EDITOR_TITLE_ADDLANGUAGE'],$languageNames[$_SESSION['feinduraSession']['websiteLanguage']]);
elseif($newPage)
  $pageTitle = $langFile['EDITOR_TITLE_CREATEPAGE'];
else
  $pageTitle = strip_tags(GeneralFunctions::getLocalized($pageContent,'title',true));

// adds the page and category IDs for the MooRTE saving of the title
$titleData = (!$newPage) // data-feindura format: "pageID categoryID"
  ? ' data-feindura="'.$_GET['page'].' '.$_GET['category'].' '.$_SESSION['feinduraSession']['websiteLanguage'].'"'
  : '';

$titleIsEditable = (!$newPage)
  ? ' id="editablePageTitle"'
  : '';

// -> show NEWPAGE ICON
if($newPage) {
  $newPageIcon = '<img src="library/images/icons/newPageIcon_middle.png" class="blockH1Icon" width="33" height="30" alt="icon">';
}

// -> checks for startpage, and show STARTPAGE ICON
if($websiteConfig['setStartPage'] && $pageContent['id'] == $websiteConfig['startPage']) {
  $startPageIcon = '<img src="library/images/icons/startPageIcon_middle.png" class="blockH1Icon" width="33" height="30" alt="icon">';
  $startPageTitle = ' toolTipTop" title="'.$langFile['SORTABLEPAGELIST_functions_startPage_set'].'::" style="line-height:left;'; //" comes in the h1
}

// shows the text of the sorting of a CATEGORY
if($categoryConfig[$_GET['category']]['sorting'] == 'byPageDate')
  $sorting = '&nbsp;<img src="library/images/icons/sortByDate_small.png" class="toolTipTop" title="'.$langFile['SORTABLEPAGELIST_TIP_SORTBYPAGEDATE'].'::" alt="icon" width="27" height="23">';
elseif($categoryConfig[$_GET['category']]['sorting'] == 'alphabetical')
  $sorting = '&nbsp;<img src="library/images/icons/sortAlphabetical_small.png" class="toolTipTop" title="'.$langFile['SORTABLEPAGELIST_TIP_SORTALPHABETICAL'].'::" alt="icon" width="27" height="23">';
else
  $sorting = '';

// -> show the page PAGE HEADLINE
echo '<h1 class="'.$headerColorClass.$startPageTitle.'">'.$newPageIcon.$startPageIcon.'<span class="'.$headerColorClasses.'"'.$titleIsEditable.$titleData.'>'.$pageTitle.'</span>'.$sorting.'<span style="display:none;" class="toolTipRight noMark notSavedSignPage'.$pageContent['id'].'" title="'.$langFile['EDITOR_pageNotSaved'].'::"> *</span></h1>';

// shows the PUBLIC OR UNPUBLIC in headline
if(!$newPage) {
  echo '<div style="z-index: 2;position:absolute;top: 10px; right:15px;">';
  if($pageContent['public'])
    echo ' <a href="?category='.$pageContent['category'].'&amp;page='.$pageContent['id'].'&amp;status=changePageStatus&amp;public=1&amp;reload='.rand(0,999).'#pageInformation" class="toolTipTop noMark image" title="'.$langFile['STATUS_PAGE_PUBLIC'].'::'.$langFile['SORTABLEPAGELIST_TIP_CHANGESTATUS'].'"><img src="library/images/icons/page_public.png" '.$publicSignStyle.' alt="icon public" width="27" height="27"></a>';
  else
    echo ' <a href="?category='.$pageContent['category'].'&amp;page='.$pageContent['id'].'&amp;status=changePageStatus&amp;reload='.rand(0,999).'#pageInformation" class="toolTipTop noMark image" title="'.$langFile['STATUS_PAGE_NONPUBLIC'].'::'.$langFile['SORTABLEPAGELIST_TIP_CHANGESTATUS'].'"><img src="library/images/icons/page_nonpublic.png"'.$publicSignStyle.' alt="icon nonpublic" width="27" height="27"></a>';
  echo '</div>';
}

?>
  <div class="content form">
    <?php

    // -> show LAST SAVE DATE TIME
    $lastSaveDate =  GeneralFunctions::formatDate(GeneralFunctions::dateDayBeforeAfter($pageContent['lastSaveDate'],$langFile));
    $lastSaveTime =  formatTime($pageContent['lastSaveDate']);

    $editedByUser = ($pageContent['lastSaveAuthor'])
      ? '</b> '.$langFile['EDITOR_pageinfo_lastsaveauthor'].' <b>'.$userConfig[$pageContent['lastSaveAuthor']]['username']
      : '';

    echo ($newPage)
      ? ''
      : '<div style="font-size:11px; text-align:right;">'.$langFile['EDITOR_pageinfo_lastsavedate'].' <b>'.$lastSaveDate.' '.$lastSaveTime.$editedByUser.'</b></div>';


    // PAGE ID
    if(!$newPage && GeneralFunctions::isAdmin())
      echo '<div class="row">
              <div class="span3 formLeft">
                <span class="info toolTipLeft" title="::'.$langFile['EDITOR_pageinfo_id_tip'].'"><strong>'.$langFile['EDITOR_pageinfo_id'].'</strong></span>
              </div>
              <div class="span5">
                <span>'.$_GET['page'].'</span>
              </div>
            </div>';

    // ->> IF NEWPAGE
    if($newPage && $_GET['status'] != 'addLanguage') {

      // -> show a CATEGORY SELECTION
      echo '<div class="row">
              <div class="span3 formLeft">
                <label for="categorySelection"><span><strong>'.$langFile['EDITOR_pageinfo_category'].'</strong></span></label>
              </div>
              <div class="span5">
                <select name="categorySelection" id="categorySelection">';

                // ->> goes trough categories and list them
                foreach($categoryConfig as $listCategory) {

                  $selected = ($listCategory['id'] == $_GET['category']) ? ' selected="selected"' : $selected = '';
                  $categoryId = (GeneralFunctions::isAdmin()) ? ' (ID '.$listCategory['id'].')' : '';

                  // -> shows category selection if create pages is allowed
                  if($listCategory['createDelete'] && GeneralFunctions::hasPermission('editableCategories',$listCategory['id']))
                    echo '<option value="'.$listCategory['id'].'"'.$selected.'>'.GeneralFunctions::getLocalized($listCategory,'name').$categoryId.'</option>'."\n";
                }

      echo '    </select>
              </div>
            </div>';

      // -> SHOW TEMPLATE SELECTION
      echo '<div class="row">
              <div class="span3 formLeft">
                <label for="templateSelection"><strong>'.$langFile['EDITOR_TEXT_CHOOSETEMPLATE'].'</strong></label>
              </div>
              <div class="span5">
                <select name="templateSelection" id="templateSelection">
                  <option>-</option>'."\n";

                // -> loads all pages
                $allPages = GeneralFunctions::loadPages(true);
                // -> goes trough categories and list them
                foreach($allPages as $curPage) {
                  $selected = ($curPage['id'] == $_GET['template']) ? ' selected="selected"' : $selected = '';
                  $categoryText = ($curPage['category'] != 0) ? GeneralFunctions::getLocalized($categoryConfig[$curPage['category']],'name').' » ' : '';
                  echo '<option value="'.$curPage['id'].'"'.$selected.'>'.$categoryText.GeneralFunctions::getLocalized($curPage,'title').'</option>'."\n";
                }

      echo '    </select>
              </div>
            </div>';

    // not a new page
    } else {

      if($_GET['category'] == 0) {// show only if categories exist
        $categoryName = $langFile['EDITOR_pageinfo_category_noCategory'];
        if(GeneralFunctions::isAdmin())
          $categoryName .= ' <span style="color:#A6A6A6;">(ID 0)</span>';
      } else {
        $categoryName = GeneralFunctions::getLocalized($categoryConfig[$_GET['category']],'name');
        if(GeneralFunctions::isAdmin())
          $categoryName .= ' <span style="color:#A6A6A6;">(ID '.$_GET['category'].')</span>';
      }

      echo '<div class="row">
              <div class="span3 formLeft">
                <span><strong>'.$langFile['EDITOR_pageinfo_category'].'</strong></span>
              </div>
              <div class="span5">
                <span>'.$categoryName.'</span>
              </div>
            </div>';
    }

    // SHOW PAGE LINK and LANGUAGES
    if(!$newPage) {
      // shows the category var in the link or not
      if($_GET['category'] == 0)
        $categoryInLink = '';
      else
        $categoryInLink = $adminConfig['varName']['category'].'='.$pageContent['category'].'&amp;';

      // shows the page languages
      if(!isset($pageContent['localized'][0])) {
        echo '<div class="row">
                <div class="span3 formLeft">
                  <span><strong>'.$langFile['SORTABLEPAGELIST_TIP_LOCALIZATION'].'</strong></span>
                </div>
                <div class="span5">';
                  if(is_array($pageContent['localized'])) {
                    foreach ($pageContent['localized'] as $langCode => $values) {
                      echo '<a href="'.GeneralFunctions::addParameterToUrl(array('websiteLanguage','status'),array($langCode,'')).'" class="image" style="font-size:12px;"><img src="'.GeneralFunctions::getFlagSrc($langCode).'" class="flag" alt="flag icon"> '.$languageNames[$langCode].'</a>';
                      if($_SESSION['feinduraSession']['websiteLanguage'] == $langCode) echo '<img src="library/images/icons/edited_small.png" style="position:absolute; margin-top:1px;" alt="icon">';
                      echo '<br>';
                    }
                  }
                  // list not yet existing languages of the page
                  if($missingLanguages) {
                    foreach ($missingLanguages as $langCode) {
                        echo '<a href="'.GeneralFunctions::addParameterToUrl(array('websiteLanguage','status'),array($langCode,'addLanguage')).'" class="image gray" style="font-size:12px;"><img src="'.GeneralFunctions::getFlagSrc($langCode).'" class="flag" alt="flag icon"> <s>'.$languageNames[$langCode].'</s></a>';
                        if($_SESSION['feinduraSession']['websiteLanguage'] == $langCode) echo '<img src="library/images/icons/edited_small.png" style="position:absolute; margin-top:1px;" alt="icon">';
                        echo '<br>';
                    }
                  }
        echo '  </div>
              </div>';
      }

      // shows the page link
      echo '<div class="row">
              <div class="span3 formLeft">
                <span><strong>'.$langFile['EDITOR_pageinfo_linktothispage'].'</strong></span>
              </div>
              <div class="span5">
                <span style="font-size:11px; word-wrap: break-word;"><a href="'.GeneralFunctions::createHref($pageContent,false,false,true).'" class="extern">'.GeneralFunctions::createHref($pageContent,false,false,true).'</a></span>
              </div>
            </div>';

    }
    ?>
  </div>
</div>

<?php

/**
 * Include the editor
 */
if(!$newPage) {
  include_once(dirname(__FILE__).'/../includes/editor.include.php');
}


if($newPage) {
?>
  <!-- ***** PAGE SETTINGS on NEW PAGE -->
  <div class="block<?php echo $hidden; ?>">
    <div class="content form">
      <?php

          include(dirname(__FILE__).'/../includes/pageMetaData.include.php');
      ?>
      <input type="submit" value="" class="button submit center" title="<?php echo $langFile['FORM_BUTTON_SUBMIT']; ?>" onclick="$('savedBlock').value = 'pageSettings'; submitAnchor('editorForm','pageInformation');">
    </div>
  </div>
<?php
}

/**
 * Include the editor when newpage
 */
if($newPage) {
  include_once(dirname(__FILE__).'/../includes/editor.include.php');
  echo '<div class="spacer2x"></div>';
}

if(GeneralFunctions::isAdmin()) {
?>
<!-- ***** ADVANCED PAGE SETTINGS -->
<a id="advancedPageSettingsAnchor" class="anchorTarget"></a>
<?php
// shows the block below if it is the ones which is saved before
$hidden = ($savedForm == 'advancedPageSettings') ? '' : ' hidden';
$blockContentEdited = ((!empty($pageContent['styleFile']) && $pageContent['styleFile'] != 'a:0:{}') ||
                       (!empty($pageContent['styleId']) &&  $pageContent['styleId'] != 'a:0:{}') ||
                       (!empty($pageContent['styleClass']) && $pageContent['styleClass'] != 'a:0:{}'))
  ? '&nbsp;<img src="library/images/icons/edited_small.png" class="toolTipLeft" title="'.$langFile['EDITOR_advancedpageSettings_h1'].' '.$langFile['EDITOR_block_edited'].'::" alt="icon" style="width:27px;height:23px;">'
  : '';
?>
<div class="block<?php echo $hidden; ?>">
  <h1><a href="#"><?php echo $langFile['EDITOR_advancedpageSettings_h1'].$blockContentEdited; ?></a></h1>
  <div class="content form">

    <div class="row">
      <div class="span3 formLeft">
        <span class="toolTipLeft" title="::<?php echo $langFile['STYLESHEETS_TOOLTIP_STYLEFILE'].'[br][br][span class=hint]'.$langFile['EDITOR_advancedpageSettings_stylesheet_ifempty'].'[/span]'; ?>"><?php echo $langFile['STYLESHEETS_TEXT_STYLEFILE']; ?></span>
      </div>
      <div class="span5">
        <div id="pageStyleFilesInputs" class="toolTipTop" title="::<?php echo $langFile['EDITOR_advancedpageSettings_stylesheet_ifempty']; ?>">
        <?php

          echo showStyleFileInputs(getStylesByPriority($pageContent['styleFile'],'styleFile',$pageContent['category']),'styleFile');

        ?>
        </div>
        <a href="#" class="addStyleFilePath addButton toolTipLeft" style="margin-right: 10px;float:left;" title="<?php echo $langFile['STYLESHEETS_TOOLTIP_ADDSTYLEFILE']; ?>::"></a>
        <span class="badge" style="position:relative; top: 8px;"><?php echo $langFile['STYLESHEETS_EXAMPLE_STYLEFILE']; ?></span>
      </div>
    </div>

    <div class="row">
      <div class="span3 formLeft">
        <span class="toolTipLeft" title="::<?php echo $langFile['STYLESHEETS_TOOLTIP_ID'].'[br][br][span class=hint]'.$langFile['EDITOR_advancedpageSettings_stylesheet_ifempty'].'[/span]'; ?>"><?php echo $langFile['STYLESHEETS_TEXT_ID']; ?></span>
      </div>
      <div class="span5">
        <input type="text" name="styleId" value="<?php echo getStylesByPriority($pageContent['styleId'],'styleId',$pageContent['category']); ?>" class="toolTipRight" title="::<?php echo $langFile['EDITOR_advancedpageSettings_stylesheet_ifempty']; ?>">
      </div>
    </div>

    <div class="row">
      <div class="span3 formLeft">
        <span class="toolTipLeft" title="::<?php echo $langFile['STYLESHEETS_TOOLTIP_CLASS'].'[br][br][span class=hint]'.$langFile['EDITOR_advancedpageSettings_stylesheet_ifempty'].'[/span]'; ?>"><?php echo $langFile['STYLESHEETS_TEXT_CLASS']; ?></span>
      </div>
      <div class="span5">
        <input type="text" name="styleClass" value="<?php echo getStylesByPriority($pageContent['styleClass'],'styleClass',$pageContent['category']); ?>" class="toolTipRight" title="::<?php echo $langFile['EDITOR_advancedpageSettings_stylesheet_ifempty']; ?>">
      </div>
    </div>

    <input type="submit" value="" class="button submit center" title="<?php echo $langFile['FORM_BUTTON_SUBMIT']; ?>" onclick="$('savedBlock').value = 'advancedPageSettings'; submitAnchor('editorForm','advancedPageSettingsAnchor');">
  </div>
</div>
<?php }
?>
</form>