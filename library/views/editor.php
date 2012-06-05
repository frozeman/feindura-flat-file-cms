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
$activatedPlugins = ($_GET['category'] === 0)
  ? unserialize($adminConfig['pages']['plugins'])
  : unserialize($categoryConfig[$_GET['category']]['plugins']);


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


if(!$newPage) {
?>
<!-- ***** PAGE STATISTICS -->
<?php
// dont shows the block below if pageSettings is saved
//$hidden = ($savedForm) ? ' hidden' : '';
$hidden = ' hidden';
?>
<div class="block<?php echo $hidden; ?>">
  <h1><a href="#"><img src="library/images/icons/statisticIcon_small.png" alt="icon" width="30" height="27"><?php echo $langFile['EDITOR_pagestatistics_h1']; ?></a></h1>
  <div class="content">
  <?php
  $pageStatistics = StatisticFunctions::readPageStatistics($pageContent['id']);
  // -> statistic vars
  // --------------
  $firstVisitDate = GeneralFunctions::formatDate($pageStatistics['firstVisit']);
  $firstVisitTime = formatTime($pageStatistics['firstVisit']);
  $lastVisitDate = GeneralFunctions::formatDate($pageStatistics['lastVisit']);
  $lastVisitTime = formatTime($pageStatistics['lastVisit']);
  
  $visitTimes_max = unserialize($pageStatistics['visitTimeMax']);
  $visitTimes_min = unserialize($pageStatistics['visitTimeMin']);
  ?>  
  <table>   
    
    <colgroup>
    <col class="left">
    </colgroup>
    
    <tbody>
      <tr><td class="leftTop"></td><td></td></tr>
      
      <?php
      
      if($pageStatistics['firstVisit']) {
      ?>
      <tr>
        <td class="left">
          <?php echo $langFile['STATISTICS_TEXT_VISITORCOUNT']; ?>
        </td><td class="right" style="font-size:15px;">
          <?php
          // -> VISIT COUNT
          echo '<span class="brown" style="font-weight:bold;font-size:20px;">'.formatHighNumber($pageStatistics['visitorCount']).'</span>';
          ?>
        </td>      
      </tr>
      <tr>
        <td class="left">
          <?php echo $langFile['STATISTICS_TEXT_FIRSTVISIT']; ?>
        </td><td class="right" style="font-size:15px;">
          <?php
          // -> FIRST VISIT
          echo '<span class="info brown toolTip" title="'.$firstVisitTime.'::">'.$firstVisitDate.'</span> ';
          ?>
        </td>
      </tr>
      
      <tr>
        <td class="left">
          <?php echo $langFile['STATISTICS_TEXT_LASTVISIT']; ?>
        </td><td class="right" style="font-size:15px;">
          <?php
          // -> LAST VISIT
          echo '<span class="info blue toolTip" title="'.$lastVisitTime.'::">'.$lastVisitDate.'</span> ';
          ?>
        </td>
      </tr>
      
      <tr><td class="spacer"></td><td></td></tr>
      
      <tr>
        <td class="left">
          <?php echo $langFile['STATISTICS_TEXT_VISITTIME_MAX']; ?>
        </td><td class="right">
          <?php
          // -> VISIT TIME MAX
          $showTimeHead = true;
          if(is_array($visitTimes_max)) {
            foreach($visitTimes_max as $visitTime_max) {
              if($visitTime_max_formated = showVisitTime($visitTime_max)) {
                if($showTimeHead)
                  echo '<span class="blue" id="visitTimeMax">'.$visitTime_max_formated.'</span><br>
                  <div id="visitTimeMaxContainer">';
                else            
                  echo '<span class="blue">'.$visitTime_max_formated.'</span><br>';
                
                $showTimeHead = false;            
              }
            }
          }
          echo '</div>';    
          ?>
        </td>
      </tr>
      <tr>
        <td class="left">
          <?php echo $langFile['STATISTICS_TEXT_VISITTIME_MIN']; ?>
        </td><td class="right">
          <?php
          // -> VISIT TIME MIN
          $showTimeHead = true;
          if(is_array($visitTimes_max)) {
            $visitTimes_min = array_reverse($visitTimes_min);
            foreach($visitTimes_min as $visitTime_min) {          
              if($visitTime_min_formated = showVisitTime($visitTime_min)) {
                if($showTimeHead)
                  echo '<span class="blue" id="visitTimeMin">'.$visitTime_min_formated.'</span><br>
                  <div id="visitTimeMinContainer">';
                else            
                  echo '<span class="blue">'.$visitTime_min_formated.'</span><br>';
              
                $showTimeHead = false;
              }          
            }
          }
          echo '</div>';
          ?>
        </td>
      </tr>
      <?php
      // -> show NO VISIT
      } else {
        echo '<tr>
                <td class="left">
                </td><td class="right" style="font-size:15px;">
                  '.$langFile['STATISTICS_TEXT_NOVISIT'].'
                </td>
              </tr>';
      }    
      ?>
      
      <tr><td class="spacer"></td><td></td></tr>
      
      <tr>
        <td class="left">
          <span><?php echo $langFile['STATISTICS_TEXT_SEARCHWORD_DESCRIPTION']; ?></span>
        </td><td class="right">
        <div style="width:95%;max-height:160px;border:0px solid #cccccc;padding:0px 10px;">
        <?php
        
        // -> show TAG CLOUD
        echo '<div class="tagCloud">';
        echo createTagCloud($pageStatistics['searchWords']);
        echo '</div>';

        ?>
        </div>
        </td>
      </tr>
      
      <tr><td class="leftBottom"></td><td></td></tr>
    </tbody>
  </table>
  </div>
  <div class="bottom"></div>
</div>
<?php
}

/**
 * Include the editor
 */
if(!$newPage)
  include_once(dirname(__FILE__).'/../includes/editor.include.php');
  
?>

<!-- page information anchor is here -->
<a id="pageInformation" class="anchorTarget"></a>


<div class="block open pageHead">
<?php

// LOAD PAGE as TEMPLATE
if($newPage && isset($_GET['template']) && is_numeric($_GET['template']))
  $pageContent = GeneralFunctions::readPage($_GET['template'],GeneralFunctions::getPageCategory($_GET['template']));


// shows ID and different header color if its a CATEGORY
$headerColorClass = ($_GET['category'] != 0)
  ? 'blue' //" comes in the h1
  : 'brown'; //" comes in the h1

// get Title
$pageTitle = ($newPage)
  ? $langFile['EDITOR_h1_createpage']
  : strip_tags(GeneralFunctions::getLocalized($pageContent,'title',true));

// adds the page and category IDs for the MooRTE saving of the title
$titleData = (!$newPage) // data-feindura format: "pageID categoryID"
  ? ' data-feindura="'.$_GET['page'].' '.$_GET['category'].' '.$_SESSION['feinduraSession']['websiteLanguage'].'"'
  : '';

$titleIsEditable = (!$newPage)
  ? ' id="editablePageTitle"'
  : '';

// -> show NEWPAGE ICON
if($newPage) {
  $newPageIcon = '<img src="library/images/icons/newPageIcon_middle.png" width="33" height="30">';  
}

// -> checks for startpage, and show STARTPAGE ICON
if($adminConfig['setStartPage'] && $pageContent['id'] == $websiteConfig['startPage']) {
  $startPageIcon = '<img src="library/images/icons/startPageIcon_middle.png" width="33" height="30">';
  $startPageTitle = ' toolTip" title="'.$langFile['SORTABLEPAGELIST_functions_startPage_set'].'::" style="line-height:left;'; //" comes in the h1
}

// shows the text of the sorting of a CATEGORY
if($categoryConfig[$_GET['category']]['sorting'] == 'byPageDate')
  $sorting = '&nbsp;<img src="library/images/icons/sortByDate_small.png" class="blockH1Icon toolTip" title="'.$langFile['SORTABLEPAGELIST_TIP_SORTBYPAGEDATE'].'::" alt="icon" width="27" height="23">';
elseif($categoryConfig[$_GET['category']]['sorting'] == 'alphabetical')
  $sorting = '&nbsp;<img src="library/images/icons/sortAlphabetical_small.png" class="blockH1Icon toolTip" title="'.$langFile['SORTABLEPAGELIST_TIP_SORTALPHABETICAL'].'::" alt="icon" width="27" height="23">';
else
  $sorting = '';

// -> show the page PAGE HEADLINE
echo '<h1 class="'.$headerColorClass.$startPageTitle.'">'.$newPageIcon.$startPageIcon.'<span class="'.$headerColorClasses.'"'.$titleIsEditable.$titleData.'>'.$pageTitle.'</span>'.$sorting.'<span style="display:none;" class="toolTip noMark notSavedSignPage'.$pageContent['id'].'" title="'.$langFile['EDITOR_pageNotSaved'].'::"> *</span></h1>';

// shows the PUBLIC OR UNPUBLIC in headline
if(!$newPage) {
  echo '<div style="z-index: 2;position:absolute;top: -5px; right:15px;">';
  if($pageContent['public'])
    echo ' <a href="?category='.$pageContent['category'].'&page='.$pageContent['id'].'&status=changePageStatus&public=1&reload='.rand(0,999).'#pageInformation" class="toolTip noMark image" title="'.$langFile['STATUS_PAGE_PUBLIC'].'::'.$langFile['SORTABLEPAGELIST_changeStatus_linkPage'].'"><img src="library/images/icons/page_public.png" '.$publicSignStyle.' alt="public" width="27" height="27"></a>';
  else
    echo ' <a href="?category='.$pageContent['category'].'&page='.$pageContent['id'].'&status=changePageStatus&reload='.rand(0,999).'#pageInformation" class="toolTip noMark image" title="'.$langFile['STATUS_PAGE_NONPUBLIC'].'::'.$langFile['SORTABLEPAGELIST_changeStatus_linkPage'].'"><img src="library/images/icons/page_nonpublic.png"'.$publicSignStyle.' alt="nonpublic" width="27" height="27"></a>';
  echo '</div>';
}

?>
  <div class="content">   
    <?php

    // -> show LAST SAVE DATE TIME
    $lastSaveDate =  GeneralFunctions::formatDate(GeneralFunctions::dateDayBeforeAfter($pageContent['lastSaveDate'],$langFile));
    $lastSaveTime =  formatTime($pageContent['lastSaveDate']);
    
    $editedByUser = ($pageContent['lastSaveAuthor'])
      ? '</b> '.$langFile['EDITOR_pageinfo_lastsaveauthor'].' <b>'.$userConfig[$pageContent['lastSaveAuthor']]['username']
      : '';
    
    echo ($newPage)
      ? ''
      : '<div style="font-size:11px; text-align:right;">'.$langFile['EDITOR_pageinfo_lastsavedate'].': <b>'.$lastSaveDate.' '.$lastSaveTime.$editedByUser.'</b></div>';
      

    // -> show THUMBNAIL if the page has one
    $displayThumbnailContainer = ' display:none;';
    if(!$newPage && !empty($pageContent['thumbnail'])) {

      $displayThumbnailContainer = '';

      // vars
      $thumbnailWidth = @getimagesize(DOCUMENTROOT.$adminConfig['uploadPath'].$adminConfig['pageThumbnail']['path'].$pageContent['thumbnail']);
      $thumbnailWidth = $thumbnailWidth[0];
      
      if($thumbnailWidth >= 200)        
        $thumbnailWidthStyle = ' style="width:200px;"';

    }

    // generates a random number to put on the end of the image, to prevent caching
    // $randomImage = '?'.md5(uniqid(rand(),1));

    // thumbnailPreviewContainer
    echo '<br><div id="thumbnailPreviewContainer" style="z-index:5; position:relative; margin-bottom: 10px; float:right; line-height:28px; text-align:center;'.$displayThumbnailContainer.'">';
    echo '<span class="thumbnailToolTip" title="::'.$adminConfig['uploadPath'].$adminConfig['pageThumbnail']['path'].$pageContent['thumbnail'].'">'.$langFile['THUMBNAIL_TEXT_NAME'].'</span><br>';
    echo '<span class="deleteIcon">';

    // see if the thumbnails are activated, add upload/delete buttons
    if(($pageContent['category'] == 0 && $adminConfig['pages']['thumbnails']) || ($pageContent['category'] != 0 && $categoryConfig[$pageContent['category']]['thumbnails'])) {
      echo '<a href="?site=pageThumbnailDelete&amp;category='.$_GET['category'].'&amp;page='.$_GET['page'].'" onclick="openWindowBox(\'library/views/windowBox/pageThumbnailDelete.php?site='.$_GET['site'].'&amp;category='.$_GET['category'].'&amp;page='.$_GET['page'].'\',\''.$langFile['BUTTON_THUMBNAIL_DELETE'].'\',false);return false;" title="'.$langFile['BUTTON_TOOLTIP_THUMBNAIL_DELETE'].'::"" class="deleteIcon toolTip"></a>';
      echo '<a href="?site=pageThumbnailUpload&amp;category='.$_GET['category'].'&amp;page='.$_GET['page'].'" onclick="openWindowBox(\'library/views/windowBox/pageThumbnailUpload.php?site='.$_GET['site'].'&amp;category='.$_GET['category'].'&amp;page='.$_GET['page'].'\',\''.$langFile['BUTTON_THUMBNAIL_UPLOAD'].'\',false);return false;" class="image">';
      echo '<img src="'.$adminConfig['uploadPath'].$adminConfig['pageThumbnail']['path'].$pageContent['thumbnail'].'" id="thumbnailPreviewImage" class="thumbnailPreview thumbnailToolTip"'.$thumbnailWidthStyle.' data-width="'.$thumbnailWidth.'" alt="thumbnail" title="::'.$adminConfig['uploadPath'].$adminConfig['pageThumbnail']['path'].$pageContent['thumbnail'].'">';
      echo '</a>';
    // if not only show the thumbnailPreviewImage
    } else
      echo '<img src="'.$adminConfig['uploadPath'].$adminConfig['pageThumbnail']['path'].$pageContent['thumbnail'].'" id="thumbnailPreviewImage" class="thumbnailPreview thumbnailToolTip"'.$thumbnailWidthStyle.' data-width="'.$thumbnailWidth.'" alt="thumbnail" title="::'.$adminConfig['uploadPath'].$adminConfig['pageThumbnail']['path'].$pageContent['thumbnail'].'">';
    
    echo '</span>';
    echo '</div>';
    
    // -> show the thumbnail upload button if there is no thumbnail yet
    $displayThumbnailUploadButton = (!$newPage &&
       (($_GET['category'] == 0 && $adminConfig['pages']['thumbnails']) ||
       $categoryConfig[$_GET['category']]['thumbnails']))
       ? '' : ' style="display:none;"';

    // thumbnailUploadButtonInPreviewArea
    echo '<a href="?site=pageThumbnailUpload&amp;category='.$_GET['category'].'&amp;page='.$_GET['page'].'" id="thumbnailUploadButtonInPreviewArea" onclick="openWindowBox(\'library/views/windowBox/pageThumbnailUpload.php?site='.$_GET['site'].'&amp;category='.$_GET['category'].'&amp;page='.$_GET['page'].'\',\''.$langFile['BUTTON_THUMBNAIL_UPLOAD'].'\',false);return false;" title="'.$langFile['BUTTON_TOOLTIP_THUMBNAIL_UPLOAD'].'::" class="pageThumbnailUpload toolTip"'.$displayThumbnailUploadButton.'>&nbsp;</a>';
    ?>
    
    <table>     
      <colgroup>
      <col class="left">
      </colgroup>
    
      <tbody>
        <tr><td class="leftTop"></td><td></td></tr>      
        <?php
        
        if(!$newPage && isAdmin())
          echo '<tr>
                <td class="left">      
                <span class="info toolTip" title="::'.$langFile['EDITOR_pageinfo_id_tip'].'"><strong>'.$langFile['EDITOR_pageinfo_id'].'</strong></span>
                </td><td class="right">
                <span class="info">'.$_GET['page'].'</span>
                </td>
                </tr>';
        
        if($_GET['category'] == 0) {// show only if categories exist
          $categoryName = $langFile['EDITOR_pageinfo_category_noCategory'];
          if(isAdmin())
            $categoryName .= ' <span style="color:#A6A6A6;">(ID 0)</span>';
        } else {
          $categoryName = GeneralFunctions::getLocalized($categoryConfig[$_GET['category']],'name');
          if(isAdmin())
            $categoryName .= ' <span style="color:#A6A6A6;">(ID '.$_GET['category'].')</span>';
        }
        
      
        // ->> if newPage
        if($newPage && $_GET['status'] != 'addLanguage') {
        
          // -> show a CATEGORY SELECTION
          echo '<tr>
                <td class="left">
                <label for="categorySelection" class="info"><strong>'.$langFile['EDITOR_pageinfo_category'].'</strong></label>
                </td><td class="right">
                <select name="categorySelection" id="categorySelection">';
                
                // -> shows non-category selection if create pages is allowed
                if($adminConfig['pages']['createDelete'])
                  echo '<option value="0">'.$langFile['EDITOR_pageinfo_category_noCategory'].'</option>';
                
                // ->> goes trough categories and list them
                foreach($categoryConfig as $listCategory) {
                  $selected = ($listCategory['id'] == $_GET['category']) ? ' selected="selected"' : $selected = '';
                  $categoryId = (isAdmin()) ? ' (ID '.$listCategory['id'].')' : '';

                  // -> shows category selection if create pages is allowed
                  if($listCategory['createDelete'])
                    echo '<option value="'.$listCategory['id'].'"'.$selected.'>'.GeneralFunctions::getLocalized($listCategory,'name').$categoryId.'</option>'."\n";
                }
                
          echo '</select>
                </td>
                </tr>';
          
          // -> SHOW TEMPLATE SELECTION
          echo '<tr>
                <td class="left">
                <label for="templateSelection" class="info"><strong>'.$langFile['EDITOR_TEXT_CHOOSETEMPLATE'].'</strong></label>
                </td><td class="right">
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
                
          echo '</select>
                </td>
                </tr>';
          
        // not a new page        
        } else {  
          echo '<tr>
                <td class="left">
                <span class="info"><strong>'.$langFile['EDITOR_pageinfo_category'].'</strong></span>
                </td><td class="right">
                <span class="info">'.$categoryName.'</span>
                </td>
                </tr>';
        }
        
        if(!$newPage) {
          // shows the category var in the link or not
          if($_GET['category'] == 0)
            $categoryInLink = '';
          else
            $categoryInLink = $adminConfig['varName']['category'].'='.$pageContent['category'].'&amp;';
          
          // shows the page languages
          if(!isset($pageContent['localized'][0])) {
            echo '<tr>
                  <td class="left">
                  <span class="info"><strong>'.$langFile['SORTABLEPAGELIST_TIP_LOCALIZATION'].'</strong></span>
                  </td><td class="right">';
                  foreach ($pageContent['localized'] as $langCode => $values) {
                    echo '<a href="'.GeneralFunctions::addParameterToUrl(array('websiteLanguage','status'),array($langCode,'')).'" class="image" style="font-size:12px;"><img src="'.GeneralFunctions::getFlagHref($langCode).'" class="flag"> '.$languageNames[$langCode].'</a>';
                    if($_SESSION['feinduraSession']['websiteLanguage'] == $langCode) echo '<img src="library/images/icons/edited_small.png" style="position:absolute; margin-top:1px;">';
                    echo '<br>';
                  }
                  // list not yet existing languages of the page
                  if($missingLanguages) {
                    foreach ($missingLanguages as $langCode) {
                        echo '<a href="'.GeneralFunctions::addParameterToUrl(array('websiteLanguage','status'),array($langCode,'addLanguage')).'" class="image gray" style="font-size:12px;"><img src="'.GeneralFunctions::getFlagHref($langCode).'" class="flag"> <s>'.$languageNames[$langCode].'</s></a>';
                        if($_SESSION['feinduraSession']['websiteLanguage'] == $langCode) echo '<img src="library/images/icons/edited_small.png" style="position:absolute; margin-top:1px;">';
                        echo '<br>';
                    }
                  }
            echo '</td>
                  </tr>';
          }

          // shows the page link
          echo '<tr>
                <td class="left">
                <span class="info"><strong>'.$langFile['EDITOR_pageinfo_linktothispage'].'</strong></span>
                </td><td class="right">
                <span class="info" style="font-size:11px;"><a href="'.GeneralFunctions::createHref($pageContent,false,false,true).'" class="extern">'.GeneralFunctions::createHref($pageContent,false,false,true).'</a></span>
                </td>
                </tr>';
       
        }
        ?>        
        <tr><td class="leftBottom"></td><td></td></tr>
      </tbody>
    </table>    
    
  </div>
  <div class="bottom" style="height:0px; clear:all;"></div>
</div>

<!-- page settings anchor is here -->
<a id="pageSettings" class="anchorTarget"></a>


<!-- ***** PAGE SETTINGS -->
<?php
// shows the block below if it is the ones which is saved before
$hidden = ($newPage || $savedForm == 'pageSettings' || !$savedForm) ? '' : ' hidden';
?>
<div class="block<?php echo $hidden; ?>">
  <h1><a href="#"><?php echo $langFile['EDITOR_pageSettings_h1']; ?></a></h1>
  <div class="content">
    <table>
     
      <colgroup>
      <col class="left">
      </colgroup>
    
      <tbody>
        <tr><td class="leftTop"></td><td></td></tr>
        
        <!-- ***** PAGE TITLE -->
        <?php
          $autofocus = ($newPage)
            ? ' autofocus="autofocus"'
            : '';
        ?>
        <tr><td class="left">
        <label for="edit_title"><span class="toolTip" title="::<?php echo $langFile['EDITOR_pageSettings_title_tip'] ?>">
        <?php echo $langFile['EDITOR_pageSettings_title'] ?></span></label>
        </td><td class="right">
          <input id="edit_title" name="title" style="width:492px;" value="<?php echo str_replace('"','&quot;',GeneralFunctions::getLocalized($pageContent,'title',true)); ?>"<?php echo $autofocus; ?> class="inputToolTip" title="<?php echo $langFile['EDITOR_pageSettings_title'].'::'.$langFile['EDITOR_pageSettings_title_tip'] ?>">        
        </td></tr>
        
        <!-- ***** PAGE DESCRIPTION -->      
        <tr><td class="left">
        <label for="edit_description"><span class="toolTip" title="::<?php echo $langFile['EDITOR_pageSettings_field1_tip']; ?>">
        <?php echo $langFile['EDITOR_pageSettings_field1']; ?></span></label>
        </td><td class="right">
        <textarea id="edit_description" name="description" cols="50" rows="2" style="white-space:normal;width:480px;" class="inputToolTip autogrow" title="<?php echo $langFile['EDITOR_pageSettings_field1_inputTip']; ?>"><?php echo GeneralFunctions::getLocalized($pageContent,'description',true); ?></textarea>
        </td></tr>
        <?php
        
        // -> CHECK if page date or tags are activated, show the spacer
        if($categoryConfig[$_GET['category']]['showPageDate'] ||
           $categoryConfig[$_GET['category']]['showTags'] ||
           $adminConfig['pages']['showPageDate'] ||
           $adminConfig['pages']['showTags']) {
          echo '<tr><td class="spacer"></td><td></td></tr>';
        }
              
        // ->> CHECK if activated
        if(($_GET['category'] != 0 && $categoryConfig[$_GET['category']]['showPageDate']) ||
           ($_GET['category'] == 0 && $adminConfig['pages']['showPageDate'])) { ?>
        
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
        <tr><td class="left">
        <?php
          // GET date format LANGUAGE TEXT
          $dateFormat = $langFile['DATE_'.$adminConfig['dateFormat']];
          
          // CHECKs the DATE FORMAT
          if(empty($pageDate) || validateDateString($pageDate) === false)
            echo '<label for="pageDate[before]" class="toolTip red" title="'.$langFile['EDITOR_pageSettings_pagedate_error'].'::'.$langFile['EDITOR_pageSettings_pagedate_error_tip'].'[br][strong]'.$dateFormat.'[/strong]"><strong>'.$langFile['EDITOR_pageSettings_pagedate_error'].'</strong></label>'; 
          else
            echo '<label for="pageDate[before]" class="toolTip" title="'.$langFile['EDITOR_pageSettings_field3'].'::'.$langFile['EDITOR_pageSettings_field3_tip'].'">'.$langFile['EDITOR_pageSettings_field3'].'</label>';
        ?>      
        </td><td class="right">
          <?php
          $pageDateBeforeAfter = GeneralFunctions::getLocalized($pageContent,'pageDate',true);
          ?>
          <input name="pageDate[before]" id="pageDate[before]" value="<?php echo $pageDateBeforeAfter['before']; ?>" class="inputToolTip" title="<?php echo $langFile['EDITOR_pageSettings_pagedate_before_inputTip']; ?>" style="width:130px;">
          
          <?php
          
          // -> creates DAY selection
          $pageDateTags['day'] = '<select name="pageDate[day]" class="toolTip" title="'.$langFile['EDITOR_pageSettings_pagedate_day_inputTip'].'">'."\n";
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
          $pageDateTags['month'] = '<select name="pageDate[month]" class="toolTip" title="'.$langFile['EDITOR_pageSettings_pagedate_month_inputTip'].'">'."\n";
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
            
          $pageDateTags['year'] = '<input class="short toolTip" name="pageDate[year]" title="'.$langFile['EDITOR_pageSettings_pagedate_year_inputTip'].'" value="'.$year.'" maxlength="4">'."\n";
          
          // -> SHOWS the PAGE DATE INPUTS
          switch ($adminConfig['dateFormat']) {
            case 'YMD':
              echo $pageDateTags['year'].' - '.$pageDateTags['month'].' - '.$pageDateTags['day'];
              break;
            case 'DMY':
              echo $pageDateTags['day'].' . '.$pageDateTags['month'].' . '.$pageDateTags['year'];
              break;
            case 'MDY':
              echo $pageDateTags['month'].' / '.$pageDateTags['day'].' / '.$pageDateTags['year'];
              break;
            
            default:
              echo $pageDateTags['year'].' - '.$pageDateTags['month'].' - '.$pageDateTags['day'];
              break;
          }
          
          ?>
          
          <input name="pageDate[after]" value="<?php echo $pageDateBeforeAfter['after']; ?>" class="toolTip" title="<?php echo $langFile['EDITOR_pageSettings_pagedate_after_inputTip']; ?>" style="width:122px;">
        </td></tr>
        <?php }
        
        // ->> CHECK if activated
        if($categoryConfig[$_GET['category']]['showTags'] || $adminConfig['pages']['showTags']) {
        ?>      
        <!-- ***** TAGS -->
        
        <tr><td class="left">
        <label for="edit_tags"><span class="toolTip" title="::<?php echo $langFile['EDITOR_pageSettings_field2_tip'] ?>">
        <?php echo $langFile['EDITOR_pageSettings_field2'] ?></span></label>
        </td><td class="right">
          <input id="edit_tags" name="tags" class="inputToolTip" style="width:492px;" value="<?php echo GeneralFunctions::getLocalized($pageContent,'tags',true); ?>" title="<?php echo $langFile['EDITOR_pageSettings_field2'].'::'.$langFile['EDITOR_pageSettings_field2_tip_inputTip']; ?>">        
        </td></tr>
        <?php } ?>
        
        <tr><td class="spacer"></td><td></td></tr>

        <?php
        if((($_GET['category'] != 0 && $categoryConfig[$_GET['category']]['showSubCategory']) ||
           ($_GET['category'] == 0 && $adminConfig['pages']['showSubCategory']))) {
        ?>
        <!-- ***** Subcategory selection -->
        <tr>
        <td class="left">
        <label for="subCategory" class="toolTip" title="::<?php echo $langFile['EDITOR_TIP_SUBCATEGORY']; ?>"><strong><?php echo $langFile['EDITOR_TEXT_SUBCATEGORY']; ?></strong></label>
        </td><td class="right">
        <img src="library/images/icons/categoryIcon_subCategory_middle.png" style="position:absolute; top: 2px;">
        <select name="subCategory" id="subCategory" class="toolTip" style="margin-left: 45px;" title="<?php echo $langFile['EDITOR_TEXT_SUBCATEGORY'].'::'.$langFile['EDITOR_TIP_SUBCATEGORY']; ?>">';
        <?php
          echo '<option>-</option>';
          // ->> goes trough categories and list them
          foreach($categoryConfig as $listCategory) {
            $selected = ($listCategory['id'] == $pageContent['subCategory']) ? ' selected="selected"' : $selected = '';
            echo '<option value="'.$listCategory['id'].'"'.$selected.'>'.GeneralFunctions::getLocalized($listCategory,'name').'</option>'."\n";
          }

        ?>  
        </select>
        </td>
        </tr>
        <?php } ?>

        <tr><td class="leftBottom"></td><td></td></tr>      
        
        <tr><td class="spacer checkboxes"></td><td></td></tr>
        
        <!-- ***** PUBLIC/UNPUBLIC -->
        
        <tr><td class="left checkboxes">    
          <input type="checkbox" id="edit_public" name="public" value="true" <?php if($pageContent['public']) echo 'checked'; ?>>
        </td><td class="right checkboxes">
          <label for="edit_public">
          <?php          
            $publicSignStyle = ' style="position:relative; top:-3px; float:left;"';
          
          // shows the public or unpublic picture
          if($pageContent['public'])
            echo '<img src="library/images/icons/page_public.png" class="toolTip" title="'.$langFile['STATUS_PAGE_PUBLIC'].'"'.$publicSignStyle.' alt="public" width="27" height="27">';
          else
            echo '<img src="library/images/icons/page_nonpublic.png" class="toolTip" title="'.$langFile['STATUS_PAGE_NONPUBLIC'].'"'.$publicSignStyle.' alt="nonpublic" width="27" height="27">';

          ?>
          &nbsp;<span class="toolTip" title="::<?php echo $langFile['EDITOR_pageSettings_field4_tip'] ?>">
          <?php echo $langFile['EDITOR_pageSettings_field4']; ?></span></label>        
        </td></tr>
        
        <tr><td class="spacer checkboxes"></td><td></td></tr>
      </tbody>
    </table>
    <?php $setAnchor = ($newPage) ? 'pageInformation' : 'pageSettings';  ?>
    <input type="submit" value="" class="button submit center" title="<?php echo $langFile['FORM_BUTTON_SUBMIT']; ?>" onclick="$('savedBlock').value = 'pageSettings'; submitAnchor('editorForm','<?php echo $setAnchor; ?>');">
  </div>
  <div class="bottom"></div>
</div>
<?php

/**
 * Include the editor when newpage
 */
if($newPage)
  include_once(dirname(__FILE__).'/../includes/editor.include.php');

// $activatedPlugins is on the top of the page

if(is_array($activatedPlugins) && count($activatedPlugins) >= 1) {
?>
<!-- ***** PLUGIN SETTINGS -->
<a id="pluginSettings" class="anchorTarget"></a>
<?php
// shows the block below if it is the ones which is saved before
$hidden = ($newPage || $savedForm == 'pluginSettings') ? '' : ' hidden';
$blockContentEdited = (isset($pageContent['plugins']))
  ? '&nbsp;<img src="library/images/icons/edited_small.png" class="blockH1Icon toolTip" title="'.$langFile['EDITOR_pluginSettings_h1'].' '.$langFile['EDITOR_block_edited'].'::" alt="icon" width="27" height="23">'
  : '';
?>
<div class="block<?php echo $hidden; ?>">
  <h1><a href="#"><?php echo $langFile['EDITOR_pluginSettings_h1'].$blockContentEdited; ?></a></h1>
  <div class="content">
    <p><?php echo sprintf($langFile['EDITOR_TEXT_EDITPLUGINSINEDITOR'],' <a href="#editorAnchor" class="image"><img src="library/thirdparty/ckeditor/plugins/feinduraSnippets/feinduraSnippetsIcon.png" style="margin-bottom: -4px;"></a>'); ?></p>
    <!-- <div class="verticalSeparator"></div> --><br><br>
      <?php
      
      // ->> LOAD PLUGINS      
      $plugins = GeneralFunctions::readFolder(dirname(__FILE__).'/../../plugins/');
      foreach($plugins['folders'] as $pluginFolder) {
      
        // vars
      	$pluginCountryCode = (file_exists(DOCUMENTROOT.$pluginFolder.'/languages/'.$_SESSION['feinduraSession']['backendLanguage'].'.php'))
      	  ? $_SESSION['feinduraSession']['backendLanguage']
      	  : 'en';
        unset($pluginConfig,$pluginLangFile);
        $pluginFolderName = basename($pluginFolder);       
        $pluginConfig = @include(DOCUMENTROOT.$pluginFolder.'/config.php');
        $pluginLangFile = @include(DOCUMENTROOT.$pluginFolder.'/languages/'.$pluginCountryCode.'.php');
        $pluginName = (isset($pluginLangFile['feinduraPlugin_title'])) ? $pluginLangFile['feinduraPlugin_title'] : $pluginFolderName;
        
        // LIST PLUGINS
        if(in_array($pluginFolderName,$activatedPlugins)) {
          ?>          
          <table>
            <tbody>      
              <tr><td class="left checkboxes">
              <input type="checkbox" class="inBlockSliderLink" id="feinduraPlugin_<?php echo $pluginFolderName; ?>" name="plugins[<?php echo $pluginFolderName; ?>][active]" value="true" <?php echo ($pageContent['plugins'][$pluginFolderName]['active']) ? 'checked' : ''; ?>>
              </td><td class="right checkboxes">
                <label for="feinduraPlugin_<?php echo $pluginFolderName; ?>"><b><?php echo $pluginName; ?></b></label>
                <p><?php echo $pluginLangFile['feinduraPlugin_description']; ?></p>
              </td></tr>
            </tbody>
          </table>                   
          <?php
          
          $hidden = ($pageContent['plugins'][$pluginFolderName]['active']) ? '' : ' hidden';

          // show SCRIPT config, if available
          if(!empty($pluginConfig) && is_array($pluginConfig)) {
            foreach($pluginConfig as $key => $value) {
              if(strpos(strtolower($key),'script') !== false)
                echo '<script type="text/javascript">'.$value.'</script>';
            }
          }

          ?>
          <table class="inBlockSlider<?php echo $hidden; ?>">
          <colgroup>
          <col class="left">
          </colgroup>
          <tbody>         
          <?php          
          // var
          $checkboxes = true;
          
          // ->> LIST PLUGIN SETTINGS          
          if(!empty($pluginConfig) && is_array($pluginConfig)) {
            foreach($pluginConfig as $key => $orgValue) {
              
              $value = (!isset($pageContent['plugins'][$pluginFolderName][$key]) && $pageContent['plugins'][$pluginFolderName][$key] !== false)
                ? $orgValue
                : $pageContent['plugins'][$pluginFolderName][$key];
              $keyName = (isset($pluginLangFile[$key]))
                ? $pluginLangFile[$key]
                : $key ;
              $inputLength = (strpos(strtolower($key),'number') !== false || is_numeric($value)) ? ' short' : '';
              $keyTip = (isset($pluginLangFile[$key.'_tip'])) ? ' class="toolTip'.$inputLength.'" title="'.$pluginLangFile[$key.'_tip'].'::"' : '';
              
              
              // BOOL
              if(is_bool($value)) {
                echo (!$checkboxes) ? '<tr><td class="leftBottom"></td><td></td></tr>' : '';
                
                $checked = ($value) ? ' checked' : '';
                echo '<tr><td class="left checkboxes">
                      <input type="hidden" name="plugins['.$pluginFolderName.']['.$key.']" value="false">
                      <input type="checkbox" id="feinduraPlugin_'.$pluginFolderName.'_config_'.$key.'" name="plugins['.$pluginFolderName.']['.$key.']" value="true"'.$keyTip.$checked.'>
                      </td><td class="right checkboxes">
                        <label for="feinduraPlugin_'.$pluginFolderName.'_config_'.$key.'"'.$keyTip.'>'.$keyName.'</label>        
                      </td></tr>';
                      
                $checkboxes = true;
              
              // SCRIPT
              } elseif(strpos(strtolower($key),'script') !== false) {
                // will show nothing, it was already displayed before the <table>

              // HIDDEN
              } elseif(strpos(strtolower($key),'hidden') !== false) {
                echo '<tr><td class="left checkboxes" colspan="2"><input type="hidden" id="feinduraPlugin_'.$pluginFolderName.'_config_'.$key.'" name="plugins['.$pluginFolderName.']['.$key.']" value="'.$value.'"></td></tr>';
                $checkboxes = true;

              // ECHO
              } elseif(strpos(strtolower($key),'echo') !== false) {

                echo $value;
                $checkboxes = true;

              // SELECTION
              } elseif(strpos(strtolower($key),'selection') !== false) {
                echo ($checkboxes) ? '<tr><td class="leftTop"></td><td></td></tr>' : '';
                echo '<tr><td class="left">
                      <label for="feinduraPlugin_'.$pluginFolderName.'_config_'.$key.'"'.$keyTip.'>'.$keyName.'</label>
                      </td><td class="right">
                      <select id="feinduraPlugin_'.$pluginFolderName.'_config_'.$key.'" name="plugins['.$pluginFolderName.']['.$key.']"'.$keyTip.'>';
                      foreach ($orgValue as $optionkey => $option) {
                        if($value == $option)
                          echo '<option value="'.$option.'" selected="selected">'.$option.'</option>';
                        else
                          echo '<option value="'.$option.'">'.$option.'</option>';
                      }

                echo '</select>
                      </td></tr>';
                $checkboxes = false;

              // JS FUNCTION
              } elseif(strpos(strtolower($key),'jsfunction') !== false) {

                echo '<tr><td class="left checkboxes">
                      </td><td class="right checkboxes">
                        <a href="#" class="button" onclick="'.$value.'();return false;"'.$keyTip.'>'.$keyName.'</label>        
                      </td></tr>';
                $checkboxes = true;

              // JS NUMBER
              } elseif(strpos(strtolower($key),'number') !== false || is_numeric($value)) {
                echo ($checkboxes) ? '<tr><td class="leftTop"></td><td></td></tr>' : '';

                if($keyTip == '')
                  $keyTip = ' class="short"';
                
                echo '<tr><td class="left">
                      <label for="feinduraPlugin_'.$pluginFolderName.'_config_'.$key.'"'.$keyTip.'>'.$keyName.'</label>
                      </td><td class="right">
                        <input type="number" id="feinduraPlugin_'.$pluginFolderName.'_config_'.$key.'" name="plugins['.$pluginFolderName.']['.$key.']" value="'.$value.'"'.$keyTip.'>        
                      </td></tr>';

                $checkboxes = false;

              // XSSFILTER VALUE
              } else {
                echo ($checkboxes) ? '<tr><td class="leftTop"></td><td></td></tr>' : '';

                echo '<tr><td class="left">
                      <label for="feinduraPlugin_'.$pluginFolderName.'_config_'.$key.'"'.$keyTip.'>'.$keyName.'</label>
                      </td><td class="right">
                        <input type="text" id="feinduraPlugin_'.$pluginFolderName.'_config_'.$key.'" name="plugins['.$pluginFolderName.']['.$key.']" value="'.$value.'"'.$keyTip.'>        
                      </td></tr>';
                      
                $checkboxes = false;              
              }  
            }
          }          
          echo (!$checkboxes) ? '<tr><td class="leftBottom"></td><td></td></tr>' : '';
          echo '</tr></tbody></table>
                <div class="verticalSeparator"></div>';                
        }
      }     
      ?>
    <p>&nbsp;</p>
    <!--<input type="reset" value="" class="button cancel" title="<?php echo $langFile['FORM_BUTTON_CANCEL']; ?>">-->
    <input type="submit" value="" class="button submit center" title="<?php echo $langFile['FORM_BUTTON_SUBMIT']; ?>" onclick="$('savedBlock').value = 'pluginSettings'; submitAnchor('editorForm','pluginSettings');">
  </div>
  <div class="bottom"></div>
</div>
<?php
}

if(isAdmin()) {
?>
<!-- ***** ADVANCED PAGE SETTINGS -->
<a id="advancedPageSettingsAnchor" class="anchorTarget"></a>
<?php
// shows the block below if it is the ones which is saved before
$hidden = ($savedForm == 'advancedPageSettings') ? '' : ' hidden';
$blockContentEdited = ((!empty($pageContent['styleFile']) && $pageContent['styleFile'] != 'a:0:{}') ||
                       (!empty($pageContent['styleId']) &&  $pageContent['styleId'] != 'a:0:{}') ||
                       (!empty($pageContent['styleClass']) && $pageContent['styleClass'] != 'a:0:{}'))
  ? '&nbsp;<img src="library/images/icons/edited_small.png" class="blockH1Icon toolTip" title="'.$langFile['EDITOR_advancedpageSettings_h1'].' '.$langFile['EDITOR_block_edited'].'::" alt="icon" width="27" height="23">'
  : '';
?>
<div class="block<?php echo $hidden; ?>">
  <h1><a href="#"><?php echo $langFile['EDITOR_advancedpageSettings_h1'].$blockContentEdited; ?></a></h1>
  <div class="content">
    <table>
     
      <colgroup>
      <col class="left">
      </colgroup>
    
      <tbody>
        <tr><td class="leftTop"></td><td></td></tr>
        
        <tr><td class="left">
        <span class="toolTip" title="::<?php echo $langFile['STYLESHEETS_TOOLTIP_STYLEFILE'].'[br][br][span class=hint]'.$langFile['EDITOR_advancedpageSettings_stylesheet_ifempty'].'[/span]'; ?>"><?php echo $langFile['STYLESHEETS_TEXT_STYLEFILE']; ?></span>
        </td><td class="right">
        <div id="pageStyleFilesInputs" class="inputToolTip" title="<?php echo $langFile['PATHS_TOOLTIP_ABSOLUTE'].'[br][br][span class=hint]'.$langFile['EDITOR_advancedpageSettings_stylesheet_ifempty'].'[/span]'; ?>">
        <span class="hint" style="float:right;width:190px;"><?php echo $langFile['STYLESHEETS_EXAMPLE_STYLEFILE']; ?></span>
        <?php
        
        echo showStyleFileInputs(GeneralFunctions::getStylesByPriority($pageContent['styleFile'],'styleFile',$pageContent['category']),'styleFile');

        ?>      
        </div>
        <a href="#" class="addStyleFilePath toolTip" title="<?php echo $langFile['STYLESHEETS_TOOLTIP_ADDSTYLEFILE']; ?>::"></a>
        </td></tr>
                    
        <tr><td class="left">
        <span class="toolTip" title="::<?php echo $langFile['STYLESHEETS_TOOLTIP_ID'].'[br][br][span class=hint]'.$langFile['EDITOR_advancedpageSettings_stylesheet_ifempty'].'[/span]'; ?>"><?php echo $langFile['STYLESHEETS_TEXT_ID']; ?></span>
        </td><td class="right">
        <input name="styleId" value="<?php echo GeneralFunctions::getStylesByPriority($pageContent['styleId'],'styleId',$pageContent['category']); ?>" class="inputToolTip" title="<?php echo $langFile['EDITOR_advancedpageSettings_stylesheet_ifempty']; ?>">
        </td></tr>
              
        <tr><td class="left">
        <span class="toolTip" title="::<?php echo $langFile['STYLESHEETS_TOOLTIP_CLASS'].'[br][br][span class=hint]'.$langFile['EDITOR_advancedpageSettings_stylesheet_ifempty'].'[/span]'; ?>"><?php echo $langFile['STYLESHEETS_TEXT_CLASS']; ?></span>
        </td><td class="right">
        <input name="styleClass" value="<?php echo GeneralFunctions::getStylesByPriority($pageContent['styleClass'],'styleClass',$pageContent['category']); ?>" class="inputToolTip" title="<?php echo $langFile['EDITOR_advancedpageSettings_stylesheet_ifempty']; ?>">
        </td></tr>

        <tr><td class="leftBottom"></td><td></td></tr>
      </tbody>
    </table>
    
    <!--<input type="reset" value="" class="button cancel" title="<?php echo $langFile['FORM_BUTTON_CANCEL']; ?>">-->
    <input type="submit" value="" class="button submit center" title="<?php echo $langFile['FORM_BUTTON_SUBMIT']; ?>" onclick="$('savedBlock').value = 'advancedPageSettings'; submitAnchor('editorForm','advancedPageSettingsAnchor');">
  </div>
  <div class="bottom"></div>
</div>
<?php } else
  echo '<div style="height:20px;"></div>';
?>
</form>