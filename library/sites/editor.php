<?php
/*
    feindura - Flat File Content Management System
    Copyright (C) Fabian Vogelsteller [frozeman.de]

    This program is free software;
    you can redistribute it and/or modify it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 3 of the License, or (at your option) any later version.

    This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY;
    without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
    See the GNU General Public License for more details.

    You should have received a copy of the GNU General Public License along with this program;
    if not,see <http://www.gnu.org/licenses/>.
*/
// editor.php version 1.97

include_once(dirname(__FILE__)."/../backend.include.php");

// VARs
// -----------------------------------------------------------------------------
$page	= $_GET['page'];
$category = $_GET['category'];


// ----------------------------------------------------------------------------------------------------------------------------------------
// **--** SAVE PROCESS --------------------------------------------------------------------------------------------------------------------
// ----------------------------------------------------------------------------------------------------------------------------------------


// SAVE the PAGE
// -----------------------------------------------------------------------------
if($_POST['save']) {
  
  // vars
  $page	= $_POST['id'];
  $category = $_POST['category'];
  $_GET['page'] = $page;
  $_GET['category'] = $category;  
  
  // format tags  
  $_POST['tags'] = str_replace(array(',',';'), ' ', $_POST['tags']);
  $_POST['tags'] = preg_replace("/ +/", ' ', $_POST['tags']);
  $_POST['tags'] = htmlentities($_POST['tags'], ENT_QUOTES, 'UTF-8');
  
  $_POST['title'] = $generalFunctions->prepareStringInput($_POST['title']);
  
  $_POST['description'] = $generalFunctions->prepareStringInput($_POST['description']);
  
  //$postArray['FCKeditor'] = str_replace("<br />", "<br>", $postArray['FCKeditor'] );
  //$postArray['FCKeditor'] = str_replace("/>", ">", $postArray['FCKeditor'] );
  //$postArray['FCKeditor'] = str_replace("'", "\'", $postArray['FCKeditor'] ); //&#039;
  // entfernt mehrfache leerzeichen hintereinander
  $_POST['HTMLEditor'] = preg_replace("/ +/", ' ', $_POST['HTMLEditor'] );
  $_POST['HTMLEditor'] = str_replace("'", "\'", $_POST['HTMLEditor'] ); //&#039;
  
  
  // *** CREATE NEW PAGE ----------------------
  if ($page == 'new') {
    
    // looks fore the highest id (FLATFILES)
    $page = getNewPageId();
    $_POST['id'] = $page;
    $_POST['sortorder'] = $page;
    $_GET['page'] = $page;
    
    // sets the selected category
    $category = $_POST['categoryId'];
    $_GET['category'] = $category;
    $_POST['category'] = $category;       
  
    $pageContent['log_visitCount'] = '0';
    
    $logText = 0;
    
    $generalFunctions->storedPageIds = null; // set storedPageIds to null so the page IDs will be reloaded next time
    
  // *** SAVE PAGE ----------------------
  } else {
  
    // if flatfile exists, load $pageContent array
    // (necessary for: thumbnail, sortorder and logs)
    if(!$pageContent = $generalFunctions->readPage($page,$category))
      $errorWindow .= $langFile['file_error_read'];
   
    $logText = 1; 
  }
  
  // only save page if no error occured
  if($errorWindow === false) {  
  
    // speichert den inhalt in der flatfile
    $_POST['lastsavedate'] = time();
    $_POST['lastsaveauthor'] = $_SERVER["REMOTE_USER"];
    $_POST['content'] = $_POST['HTMLEditor'];
    $_POST['thumbnail'] = $pageContent['thumbnail'];
    
    // generates pagedate
    if(!empty($_POST['pagedate']['day']) && !empty($_POST['pagedate']['month']))
    $generatedPageDate = $_POST['pagedate']['year'].'-'.$_POST['pagedate']['month'].'-'.$_POST['pagedate']['day'];
    
    // VALIDATE the SORT DATE
    if(($pageDate = $statisticFunctions->validateDateFormat($generatedPageDate)) === false)
      $pageDate = $generatedPageDate;
    // if VALID set the validated date to the post var
    else {
      $_POST['pagedate']['date'] = $pageDate;
      unset($pageDate);
    }
    
    //echo '<br />'.$_POST['pagedate']['before'];
    //echo '<br />'.$_POST['pagedate']['date'];
    
    if(empty($_POST['sortorder']))
      $_POST['sortorder'] = $pageContent['sortorder'];
    
    // adds absolute path slash on the beginning and implode the stylefiles
    $_POST['styleFile'] = prepareStyleFilePaths($_POST['styleFile']);
    
    // bubbles through the page, category and adminConfig to see if it should save the styleheet-file path, id or class-attribute
    $_POST['styleFile'] = setStylesByPriority($_POST['styleFile'],'styleFile',$category);
    $_POST['styleId'] = setStylesByPriority($_POST['styleId'],'styleId',$category);
    $_POST['styleClass'] = setStylesByPriority($_POST['styleClass'],'styleClass',$category);

    /*
    if(!empty($categoryConfig['id_'.$category]['styleFile'])) { if($_POST['styleFile'] == $categoryConfig['id_'.$category]['styleFile']) $_POST['styleFile'] = ''; } elseif($_POST['styleFile'] == $adminConfig['editor']['styleFile']) { $_POST['styleFile'] = ''; }
    if(!empty($categoryConfig['id_'.$category]['styleId'])) { if($_POST['styleId'] == $categoryConfig['id_'.$category]['styleId']) $_POST['styleId'] = ''; } elseif($_POST['styleId'] == $adminConfig['editor']['styleId']) { $_POST['styleId'] = ''; }
    if(!empty($categoryConfig['id_'.$category]['styleClass'])) { if($_POST['styleClass'] == $categoryConfig['id_'.$category]['styleClass']) $_POST['styleClass'] = ''; } elseif($_POST['styleClass'] == $adminConfig['editor']['styleClass']) { $_POST['styleClass'] = ''; }
    
    $_POST['styleId'] = str_replace(array('#','.'),'',$_POST['styleId']);
    $_POST['styleClass'] = str_replace(array('#','.'),'',$_POST['styleClass']);
   
    
    if(!empty($_POST['styleFile']) && substr($_POST['styleFile'],0,1) !== '/')
          $_POST['styleFile'] = '/'.$_POST['styleFile'];
    */
    
    // gets the visit status
    $_POST['log_visitCount'] = $pageContent['log_visitCount'];
    $_POST['log_visitTime_max'] = $pageContent['log_visitTime_max'];
    $_POST['log_visitTime_min'] = $pageContent['log_visitTime_min'];
    $_POST['log_lastVisit'] = $pageContent['log_lastVisit'];
    $_POST['log_firstVisit'] = $pageContent['log_firstVisit'];
    $_POST['log_lastIP'] = $pageContent['log_lastIP'];
    $_POST['log_searchwords'] = $pageContent['log_searchwords'];
      
    if($generalFunctions->savePage($_POST)) {
      $documentSaved = true;
      $statisticFunctions->saveTaskLog($logText,'page='.$page); // <- SAVE the task in a LOG FILE
    } else
      $errorWindow .= $langFile['editor_savepage_error_save'];
  }
  
  // sets which block should be opend after saving
  $savedForm = $_POST['savedBlock'];
}

// -------------------------------------------------------------------------------------------------------------------
// show the PAGE CONTENT
// ------------------------------------------------------------------------------

// -> LOAD PAGE and CHECK for NEW PAGE
if($pageContent = $generalFunctions->readPage($page,$category))
  $newPage = false;
else
  $newPage = true;

// check if already a (wrong) pageDate exists
$pageDate = (isset($pageDate))
  ? $pageDate
  : $pageContent['pagedate']['date'];

// set Title
if($newPage) {
  //$pageContent = '';  
  $pageTitle = $langFile['editor_h1_createpage'];
  $_GET['page'] = 'new';
  $page = 'new';
  
} else {  
  $pageTitle = $pageContent['title'];  
}

//-------------------------------------------------------------------------------------------------------------------------------------------
//-------------------------------------------------------------------------------------------------------------------------------------------

// ->> SHOW the FORM
echo '<form action="'.$_SERVER['PHP_SELF'].'?category='.$category.'&amp;page='.$page.'" method="post" accept-charset="UTF-8" id="editorForm">
      <div>
      <input type="hidden" name="save" value="true" />
      <input type="hidden" name="category" value="'.$category.'" />
      <input type="hidden" name="id" value="'.$page.'" />
      <input type="hidden" name="savedBlock" id="savedBlock" value="" />
      </div>';

?>
<div class="block open pageHead">
<?php

// shows ID and different header color if its a CATEGORY
$headerColor = ($category['id'] != 0)
  ? 'blue' //" comes in the h1
  : 'brown'; //" comes in the h1

// -> show NEWPAGE ICON
if($newPage) {
  $newPageIcon = '<img src="library/image/sign/newPageIcon_middle.png" />';  
}

// -> checks for startpage, and show STARTPAGE ICON
if($adminConfig['setStartPage'] && $pageContent['id'] == $websiteConfig['startPage']) {
  $startPageIcon = '<img src="library/image/sign/startPageIcon_middle.png" />';
  $startPageTitle = ' toolTip" title="'.$langFile['btn_startPage_set'].'::" style="line-height:left;'; //" comes in the h1
}

// shows the text of the sorting of a CATEGORY
$categorySorting = ($categoryConfig['id_'.$_GET['category']]['sortbypagedate'])
  ? '&nbsp;<img src="library/image/sign/sortByDate_small.png" class="blockH1Icon toolTip" title="'.$langFile['sortablePageList_sortOrder_date'].'::" alt="icon" />'
  : '';

// -> show the page PAGE HEADLINE
echo '<h1 class="'.$headerColor.$startPageTitle.'">'.$newPageIcon.$startPageIcon.'<span class="'.$headerColor.'">'.$pageTitle.$categorySorting.'</span>';

// -> show LAST SAVE DATE TIME
$lastSaveDate =  $statisticFunctions->formatDate($statisticFunctions->dateDayBeforeAfter($pageContent['lastsavedate'],$langFile));
$lastSaveTime =  $statisticFunctions->formatTime($pageContent['lastsavedate']);

$editedByUser = (!empty($pageContent['lastsaveauthor']))
  ? ' '.$langFile['editor_pageinfo_lastsaveauthor'].' '.$pageContent['lastsaveauthor']
  : '';

echo ($newPage)
  ? '</h1>'
  : '<br /><span style="font-size:11px;">[ '.$langFile['editor_pageinfo_lastsavedate'].': '.$lastSaveDate.' '.$lastSaveTime.$editedByUser.' ]</span></h1>';
  
?>
  <div class="content">
   
    <?php 
    // -> show thumbnail if the page has one
    if(!empty($pageContent['thumbnail'])) {
      
      $thumbnailWidth = @getimagesize(DOCUMENTROOT.$adminConfig['uploadPath'].$adminConfig['pageThumbnail']['path'].$pageContent['thumbnail']);
      $thumbnailWidth = $thumbnailWidth[0];
      
      
      if($thumbnailWidth >= 200)        
        $thumbnailWidth = ' width="200"';
      //else
        //$thumbnailWidth = ' width="'.$thumbnailWidth.'"';
        
      
      echo '<div style="z-index:5; position:relative; margin-bottom: 10px; float:right; line-height:28px; text-align:center;">';
      echo '<span class="thumbnailToolTip" title="'.$adminConfig['uploadPath'].$adminConfig['pageThumbnail']['path'].$pageContent['thumbnail'].'::'.$langFile['thumbnail_tip'].'">'.$langFile['thumbnail_name'].'</span><br />';
      echo '<img src="'.$adminConfig['uploadPath'].$adminConfig['pageThumbnail']['path'].$pageContent['thumbnail'].'" class="thumbnailPreview thumbnailToolTip"'.$thumbnailWidth.' alt="thumbnail" title="'.$adminConfig['uploadPath'].$adminConfig['pageThumbnail']['path'].$pageContent['thumbnail'].'::'.$langFile['thumbnail_tip'].'" />';
      echo '</div>';
    
    // -> show the thumbnail upload button if there is no thumbnail yet
    } elseif(!$newPage &&
            (($pageContent['category'] == 0 && $adminConfig['page']['thumbnails']) ||
            $categoryConfig['id_'.$pageContent['category']]['thumbnail'])) {  
      
        echo '<a href="?site=pageThumbnailUpload&amp;category='.$_GET['category'].'&amp;page='.$_GET['page'].'" onclick="openWindowBox(\'library/sites/windowBox/pageThumbnailUpload.php?site='.$_GET['site'].'&amp;category='.$_GET['category'].'&amp;page='.$_GET['page'].'\',\''.$langFile['btn_pageThumbnailUpload'].'\',true);return false;" title="'.$langFile['btn_pageThumbnailUpload_tip'].'::" class="pageThumbnailUpload toolTip">&nbsp;</a>';
    }
    ?>
    
    <table>     
      <colgroup>
      <col class="left" />
      </colgroup>
  
      <tr><td class="leftTop"></td><td></td></tr>      
      <?php
      
      if(!$newPage)
        echo '<tr>
              <td class="left">      
              <span class="info toolTip" title="'.$langFile['editor_pageinfo_id'].'::'.$langFile['editor_pageinfo_id_tip'].'"><strong>'.$langFile['editor_pageinfo_id'].'</strong></span>
              </td><td class="right">
              <span class="info">'.$_GET['page'].'</span>
              </td>
              </tr>';
              
      
      if($_GET['category'] == 0) // show only if categories exist
        $categoryName = '<span style="color:#A6A6A6;">'.$langFile['editor_pageinfo_category_noCategory'].'</span>';
      else
        $categoryName = '<span style="color:#A6A6A6;">'.$categoryConfig['id_'.$_GET['category']]['name'].' (ID </span>'.$_GET['category'].'<span style="color:#A6A6A6;">)</span>';
      
      if(!$newPage)
        echo '<tr>
              <td class="left">
              <span class="info"><strong>'.$langFile['editor_pageinfo_category'].'</strong></span>
              </td><td class="right">
              <span class="info">'.$categoryName.'</span>
              </td>
              </tr>';
      // -> if newPage, show a category selection
      else {
        echo '<tr>
              <td class="left">
              <span class="info"><strong>'.$langFile['editor_pageinfo_category'].'</strong></span>
              </td><td class="right">
              <select name="categoryId">';
              
              // -> shows non-category selection if create pages is allowed
              if($adminConfig['page']['createdelete'])
                echo '<option value="0">'.$langFile['editor_pageinfo_category_noCategory'].'</option>';
              
              // ->> goes trough categories and list them
              foreach($categoryConfig as $listCategory) {
                
                if($listCategory['id'] == $_GET['category'])
                  $selected = ' selected="selected"';
                else
                  $selected = '';
                
                // -> shows category selection if create pages is allowed
                if($listCategory['createdelete'])
                  echo '<option value="'.$listCategory['id'].'"'.$selected.'>'.$listCategory['name'].' (ID '.$listCategory['id'].')</option>'."\n";
              }             
              
        echo '</select>
              </td>
              </tr>';
      }
      
      if(!$newPage) {
        // shows the category var in the link or not
        if($_GET['category'] == 0)
          $categoryInLink = '';
        else
          $categoryInLink = $adminConfig['varName']['category'].'='.$_GET['category'].'&amp;';
        
        
        // shows the page link
        if($adminConfig['speakingUrl'] == '')
          $hostUrl = $adminConfig['url'].'/';
        else $hostUrl = $adminConfig['url'];
        
        echo '<tr>
              <td class="left">
              <span class="info"><strong>'.$langFile['editor_pageinfo_linktothispage'].'</strong></span>
              </td><td class="right">
              <span class="info" style="font-size:11px;"><a href="'.$hostUrl.$generalFunctions->createHref($pageContent).'" class="extern">'.$hostUrl.$generalFunctions->createHref($pageContent).'</a></span>
              </td>
              </tr>';
      }
      ?>        
      <tr><td class="leftBottom"></td><td></td></tr>
    </table>    
    
  </div>
  <div class="bottom" style="height:0px; clear:all;"></div>
</div>

<!-- page settings anchor is here -->
<a name="pageSettingsAnchor" id="pageSettingsAnchor" class="anchorTarget"></a>
<?php

if(!$newPage) {
?>
<!-- ***** PAGE STATISTICS -->
<?php
// dont shows the block below if pageSettings is saved
//$hidden = ($savedForm) ? ' hidden' : '';
$hidden = ' hidden';
?>
<div class="block<?php echo $hidden; ?>">
  <h1><a href="#"><img src="library/image/sign/statisticIcon_small.png" alt="icon" /><?php echo $langFile['editor_pagestatistics_h1']; ?></a></h1>
  <div class="content">
  <?php
  // -> format vars
  // --------------
  $firstVisitDate = $statisticFunctions->formatDate($pageContent['log_firstVisit']);
  $firstVisitTime = $statisticFunctions->formatTime($pageContent['log_firstVisit']);
  $lastVisitDate = $statisticFunctions->formatDate($pageContent['log_lastVisit']);
  $lastVisitTime = $statisticFunctions->formatTime($pageContent['log_lastVisit']);
  
  $visitTimes_max = explode('|#|',$pageContent['log_visitTime_max']);
  $visitTimes_min = explode('|#|',$pageContent['log_visitTime_min']);
  ?>  
  <table>   
    
    <colgroup>
    <col class="left" />
    </colgroup>
    
    <tr><td class="leftTop"></td><td></td></tr>
    
    <?php
    
    if($pageContent['log_firstVisit']) {
    ?>
    <tr>
      <td class="left">
        <?php echo $langFile['log_visitCount']; ?>
      </td><td class="right" style="font-size:15px;">
        <?php
        // -> VISIT COUNT
        echo '<span class="brown" style="font-weight:bold;font-size:20px;">'.$statisticFunctions->formatHighNumber($pageContent['log_visitCount']).'</span>';
        ?>
      </td>      
    </tr>
    <tr>
      <td class="left">
        <?php echo $langFile['log_firstVisit']; ?>
      </td><td class="right" style="font-size:15px;">
        <?php
        // -> FIRST VISIT
        echo '<span class="info brown toolTip" title="'.$firstVisitTime.'::">'.$firstVisitDate.'</span> ';
        ?>
      </td>
    </tr>
    
    <tr>
      <td class="left">
        <?php echo $langFile['log_lastVisit']; ?>
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
        <?php echo $langFile['log_visitTime_max']; ?>
      </td><td class="right">
        <?php
        // -> VISIT TIME MAX
        $showTimeHead = true;
        foreach($visitTimes_max as $visitTime_max) {          
          if($visitTime_max_formated = $statisticFunctions->showVisitTime($visitTime_max,$langFile)) {
            if($showTimeHead)
              echo '<span class="blue" id="visitTimeMax" title="'.$visitTime_max.'">'.$visitTime_max_formated.'</span><br />
              <div id="visitTimeMaxContainer">';
            else            
              echo '<span class="blue" title="'.$visitTime_max.'">'.$visitTime_max_formated.'</span><br />';
            
            $showTimeHead = false;            
          }
        }
        echo '</div>';    
        ?>
      </td>
    </tr>
    <tr>
      <td class="left">
        <?php echo $langFile['log_visitTime_min']; ?>
      </td><td class="right">
        <?php
        // -> VISIT TIME MIN
        $showTimeHead = true;
        $visitTimes_min = array_reverse($visitTimes_min);
        foreach($visitTimes_min as $visitTime_min) {          
          if($visitTime_min_formated = $statisticFunctions->showVisitTime($visitTime_min,$langFile)) {
            if($showTimeHead)
              echo '<span class="blue" id="visitTimeMin" title="'.$visitTime_min.'">'.$visitTime_min_formated.'</span><br />
              <div id="visitTimeMinContainer">';
            else            
              echo '<span class="blue" title="'.$visitTime_min.'">'.$visitTime_min_formated.'</span><br />';
          
            $showTimeHead = false;
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
                '.$langFile['log_novisit'].'
              </td>
            </tr>';
    }    
    ?>
    
    <tr><td class="spacer"></td><td></td></tr>
    
    <tr>
      <td class="left">
        <span><?php echo $langFile['log_tags_description']; ?></span>
      </td><td class="right">
      <div style="width:95%;max-height:160px;border:0px solid #cccccc;padding:0px 10px;">
      <?php
      
      // -> show TAG CLOUD
      echo '<div class="tagCloud">';
      $statisticFunctions->createTagCloud($pageContent['log_searchwords']);
      echo '</div>';

      ?>
      </div>
      </td>
    </tr>
    
    <tr><td class="leftBottom"></td><td></td></tr>
    
  </table>
  </div>
  <div class="bottom"></div>
</div>
<?php
}
?>

<!-- ***** PAGE SETTINGS -->
<?php
// shows the block below if it is the ones which is saved before
$hidden = ($newPage || $savedForm == 'pageSettings') ? '' : ' hidden';
?>
<div class="block<?php echo $hidden; ?>">
  <h1><a href="#"><?php echo $langFile['editor_pageSettings_h1']; ?></a></h1>
  <div class="content">
    <table>
     
      <colgroup>
      <col class="left" />
      </colgroup>
  
      <tr><td class="leftTop"></td><td></td></tr>
      
      <!-- ***** PAGE TITLE -->
      
      <tr><td class="left">
      <label for="edit_title"><span class="toolTip" title="<?php echo $langFile['editor_pageSettings_title'].'::'.$langFile['editor_pageSettings_title_tip'] ?>">
      <?php echo $langFile['editor_pageSettings_title'] ?></span></label>
      </td><td class="right">
        <input id="edit_title" name="title" style="width:492px;" value="<?php echo $pageContent['title']; ?>" />        
      </td></tr>
      
      <!-- ***** PAGE DESCRIPTION -->
      
      <tr><td class="left">
      <label for="edit_description"><span class="toolTip" title="<?php echo $langFile['editor_pageSettings_field1'].'::'.$langFile['editor_pageSettings_field1_tip']; ?>">
      <?php echo $langFile['editor_pageSettings_field1']; ?></span></label>
      </td><td class="right">
      <textarea id="edit_description" name="description" cols="50" rows="2" style="white-space:normal;width:480px;" class="inputToolTip" title="<?php echo $langFile['editor_pageSettings_field1_inputTip']; ?>"><?php echo $pageContent['description']; ?></textarea>
      </td></tr>
      <?php
      
      // -> CHECK if page date or tags are activated, show the spacer
      if($categoryConfig['id_'.$_GET['category']]['showpagedate'] ||
         $categoryConfig['id_'.$_GET['category']]['showtags']) {
        echo '<tr><td class="spacer"></td><td></td></tr>';
      }
      
      // ->> CHECK if activated
      if($categoryConfig['id_'.$_GET['category']]['showpagedate']) { ?>
      
      <!-- ***** SORT DATE -->
      
      <?php      
        
      // add the DATE of TODAY, if its a NEW PAGE
      if($newPage) {
          $pageDate = time();
      }
      
      ?>      
      <tr><td class="left">
      <label for="edit_pagedate">
      <?php
      
      // get date format
      if($adminConfig['dateFormat'] == 'eu')
        $dateFormat = $langFile['date_eu'];
      else
        $dateFormat = $langFile['date_int'];
      
      // CHECKs the DATE FORMAT
      if(!empty($pageDate) && $statisticFunctions->validateDateFormat($pageDate) === false)
        echo '<span class="toolTip" style="color:#950300;" title="'.$langFile['editor_pageSettings_pagedate_error'].'::'.$langFile['editor_pageSettings_pagedate_error_tip'].'[br /][b]'.$dateFormat.'[/b]"><b>'.$langFile['editor_pageSettings_pagedate_error'].'</b></span>'; 
      else
        echo '<span class="toolTip" title="'.$langFile['editor_pageSettings_field3'].'::'.$langFile['editor_pageSettings_field3_tip'].'">'.$langFile['editor_pageSettings_field3'].'</span>';
      ?>
      </label>
      
      </td><td class="right">
        <input name="pagedate[before]" value="<?php echo $pageContent['pagedate']['before']; ?>" class="inputToolTip" title="<?php echo $langFile['editor_pageSettings_pagedate_before_inputTip']; ?>" style="width:130px;" />
        
        <?php
        
        // -> creates DAY selection
        $pageDateTags['day'] = '<select name="pagedate[day]" class="toolTip" title="'.$langFile['editor_pageSettings_pagedate_day_inputTip'].'">'."\n";
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
        $pageDateTags['month'] = '<select name="pagedate[month]" class="toolTip" title="'.$langFile['editor_pageSettings_pagedate_month_inputTip'].'">'."\n";
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
          
        $pageDateTags['year'] = '<input type="text" class="short toolTip" name="pagedate[year]" title="'.$langFile['editor_pageSettings_pagedate_year_inputTip'].'" value="'.$year.'" maxlength="4" />'."\n";
        
        // -> WRITES the SORT DATE TAGS
        if($adminConfig['dateFormat'] == 'eu') {
          echo $pageDateTags['day'].' . '.$pageDateTags['month'].' . '.$pageDateTags['year'];
        } elseif($adminConfig['dateFormat'] == 'int') {
          echo $pageDateTags['year'].' - '.$pageDateTags['month'].' - '.$pageDateTags['day'];
        }
        
        ?>
        
        <input name="pagedate[after]" value="<?php echo $pageContent['pagedate']['after']; ?>" class="toolTip" title="<?php echo $langFile['editor_pageSettings_pagedate_after_inputTip']; ?>" style="width:120px;" />
      </td></tr>
      <?php }
      
      // ->> CHECK if activated
      if($categoryConfig['id_'.$_GET['category']]['showtags']) {
      ?>      
      <!-- ***** TAGS -->
      
      <tr><td class="left">
      <label for="edit_tags"><span class="toolTip" title="<?php echo $langFile['editor_pageSettings_field2'].'::'.$langFile['editor_pageSettings_field2_tip'] ?>">
      <?php echo $langFile['editor_pageSettings_field2'] ?></span></label>
      </td><td class="right">
        <input id="edit_tags" name="tags" class="inputToolTip" style="width:492px;" value="<?php echo $pageContent['tags']; ?>" title="<?php echo $langFile['editor_pageSettings_field2'].'::'.$langFile['editor_pageSettings_field2_tip_inputTip']; ?>" />        
      </td></tr>
      <?php } ?>
      
      <tr><td class="leftBottom"></td><td></td></tr>      
      
      <tr><td class="spacer checkboxes"></td><td></td></tr>
      
      <!-- ***** PUBLIC/UNPUBLIC -->
      
      <tr><td class="left checkboxes">    
        <input type="checkbox" id="edit_public" name="public" value="true" <?php if($pageContent['public']) echo 'checked'; ?> />
      </td><td class="right checkboxes">
        <label for="edit_public">
        <?php          
          $publicSignStyle = ' style="position:relative; top:-3px; float:left;"';
        
        // shows the public or unpublic picture
        if($pageContent['public'])
          echo '<img src="library/image/sign/page_public.png" alt="public" class="toolTip" title="'.$langFile['status_page_public'].'"'.$publicSignStyle.' />';
        else
          echo '<img src="library/image/sign/page_nonpublic.png" alt="closed" class="toolTip" title="'.$langFile['status_page_nonpublic'].'"'.$publicSignStyle.' />';

        ?>
        &nbsp;<span class="toolTip" title="<?php echo $langFile['editor_pageSettings_field4'].'::'.$langFile['editor_pageSettings_field4_tip'] ?>">
        <?php echo $langFile['editor_pageSettings_field4']; ?></span></label>        
      </td></tr>
      
      <tr><td class="spacer checkboxes"></td><td></td></tr>      
    </table>
    
    <!--<input type="reset" value="" class="button cancel" title="<?php echo $langFile['form_cancel']; ?>" />-->
    <input type="submit" value="" class="button submit center" title="<?php echo $langFile['form_submit']; ?>" onclick="$('savedBlock').value = 'pageSettings'; submitAnchor('editorForm','pageSettingsAnchor');" />
  </div>
  <div class="bottom"></div>
</div>

<?php
// ->> CHECK if plugins are activated
$pluginsActive = false;
foreach($pluginsConfig as $pluginConfig) {
  if($pluginConfig['active'])
    $pluginsActive = true;    
}
if($pluginsActive && (($pageContent['category'] == 0 && $adminConfig['page']['plugins']) ||
   $categoryConfig['id_'.$pageContent['category']]['plugins'])) {
?>
<!-- ***** PLUGIN SETTINGS -->
<a name="pluginSettingsAnchor" id="pluginSettingsAnchor" class="anchorTarget"></a>
<?php
// shows the block below if it is the ones which is saved before
$hidden = ($newPage || $savedForm == 'pluginSettings') ? '' : ' hidden';
$blockContentEdited = (isset($pageContent['plugins']))
  ? '&nbsp;<img src="library/image/sign/edited_small.png" class="blockH1Icon toolTip" title="'.$langFile['editor_pluginSettings_h1'].' '.$langFile['editor_block_edited'].'::" alt="icon" />'
  : '';
?>
<div class="block<?php echo $hidden; ?>">
  <h1><a href="#"><?php echo $langFile['editor_pluginSettings_h1'].$blockContentEdited; ?></a></h1>
  <div class="content">
      <?php
      
      // ->> LOAD PLUGINS      
      $plugins = $generalFunctions->readFolder($adminConfig['basePath'].'plugins/');
      foreach($plugins['folders'] as $pluginFolder) {
        // vars
        unset($pluginConfig,$pluginLangFile);
        $pluginFolderName = basename($pluginFolder);       
        $pluginConfig = @include(DOCUMENTROOT.$pluginFolder.'/config.php');
        $pluginLangFile = @include(DOCUMENTROOT.$pluginFolder.'/lang/'.$_SESSION['language'].'.php');
        $pluginName = (isset($pluginLangFile['plugin_title'])) ? $pluginLangFile['plugin_title'] : $pluginFolderName;
        
        // LIST PLUGINS
        if($pluginsConfig[$pluginFolderName]['active']) {
          ?>          
          <table>          
          <tr><td class="left checkboxes">
          <input type="checkbox" class="slideTableLink" id="plugin_<?= $pluginFolderName; ?>" name="plugins[<?= $pluginFolderName; ?>][active]" value="true" <?php echo ($pageContent['plugins'][$pluginFolderName]['active']) ? 'checked' : ''; ?> />
          </td><td class="right checkboxes">
            <label for="plugin_<?= $pluginFolderName; ?>"><b><?= $pluginName; ?></b></label>
            <p><?= $pluginLangFile['plugin_description']; ?></p>
          </td></tr>
          </table>                   
          <?php
          
          $hidden = ($pageContent['plugins'][$pluginFolderName]['active']) ? '' : ' hidden';
          ?>
          <table class="slideTable<?= $hidden; ?>">
          <colgroup>
          <col class="left" />
          </colgroup>          
          <?php          
          // var
          $checkboxes = true;
          
          // ->> LIST PLUGIN SETTINGS          
          if(!empty($pluginConfig) && is_array($pluginConfig)) {
            foreach($pluginConfig as $key => $value) {
              
              $keyName = (isset($pluginLangFile[$key])) ? $pluginLangFile[$key] : $key;
              $keyTip = (isset($pluginLangFile[$key.'_tip'])) ? ' class="toolTip" title="'.$pluginLangFile[$key.'_tip'].'::"' : '';
              $value = (empty($pageContent['plugins'][$pluginFolderName][$key]) && $pageContent['plugins'][$pluginFolderName][$key] !== false)
                ? $value
                : $pageContent['plugins'][$pluginFolderName][$key];
              
              if(is_bool($value)) {
                echo (!$checkboxes) ? '<tr><td class="leftBottom"></td><td></td></tr>' : '';
                
                $checked = ($value) ? 'checked' : '';
                echo '<tr><td class="left checkboxes">
                      <input type="hidden" name="plugins['.$pluginFolderName.']['.$key.']" value="false" />
                      <input type="checkbox" id="plugin_'.$pluginFolderName.'_config_'.$key.'" name="plugins['.$pluginFolderName.']['.$key.']" value="true"'.$keyTip.' '.$checked.' />
                      </td><td class="right checkboxes">
                        <label for="plugin_'.$pluginFolderName.'_config_'.$key.'"'.$keyTip.'>'.$keyName.'</label>        
                      </td>';
                      
                $checkboxes = true;
                          
              } else {
                echo ($checkboxes) ? '<tr><td class="leftTop"></td><td></td></tr>' : '';
                
                $inputLength = (is_numeric($value)) ? ' class="short"' : '';
                echo '<tr><td class="left">
                      <label for="plugin_'.$pluginFolderName.'_config_'.$key.'"'.$keyTip.'>'.$keyName.'</label>
                      </td><td class="right">
                        <input id="plugin_'.$pluginFolderName.'_config_'.$key.'"'.$inputLength.' name="plugins['.$pluginFolderName.']['.$key.']" value="'.$value.'"'.$keyTip.' />        
                      </td></tr>';
                      
                $checkboxes = false;              
              }  
            }
          }          
          echo (!$checkboxes) ? '<tr><td class="leftBottom"></td><td></td></tr>' : '';
          echo '</tr></table>
                <div class="verticalSeparator"></div>';                
        }
      }     
      ?>
    <br />
    <!--<input type="reset" value="" class="button cancel" title="<?php echo $langFile['form_cancel']; ?>" />-->
    <input type="submit" value="" class="button submit center" title="<?php echo $langFile['form_submit']; ?>" onclick="$('savedBlock').value = 'pluginSettings'; submitAnchor('editorForm','pluginSettingsAnchor');" />
  </div>
  <div class="bottom"></div>
</div>
<?php } ?>

<a name="htmlEditorAnchor" id="htmlEditorAnchor" class="anchorTarget"></a>
<div class="editor">
<?php

// -> CHOOSES the RIGHT EDITOR ID and/or CLASS
// -------------------------------------------
// gives the editor the StyleFile/StyleId/StyleClass
// from the Page, if empty,
// than from the Category if empty,
// than from the HTMl-Editor Settings

//if(empty($pageContent['styleFile'])) { if(!empty($categoryConfig['id_'.$_GET['category']]['styleFile'])) $editorStyleFile = $categoryConfig['id_'.$_GET['category']]['styleFile']; else $editorStyleFile = $adminConfig['editor']['styleFile']; } else $editorStyleFile = $pageContent['styleFile'];  
//if(empty($pageContent['styleId'])) { if(!empty($categoryConfig['id_'.$_GET['category']]['styleId'])) $editorStyleId = $categoryConfig['id_'.$_GET['category']]['styleId']; else $editorStyleId = $adminConfig['editor']['styleId']; } else $editorStyleId = $pageContent['styleId'];  
//if(empty($pageContent['styleClass'])) { if(!empty($categoryConfig['id_'.$_GET['category']]['styleClass'])) $editorStyleClass = $categoryConfig['id_'.$_GET['category']]['styleClass']; else $editorStyleClass = $adminConfig['editor']['styleClass']; } else $editorStyleClass = $pageContent['styleClass'];  
$editorStyleFile = getStylesByPriority($pageContent['styleFile'],'styleFile',$pageContent['category']);
$editorStyleId = getStylesByPriority($pageContent['styleId'],'styleId',$pageContent['category']);
$editorStyleClass = getStylesByPriority($pageContent['styleClass'],'styleClass',$pageContent['category']);

// -> CREATES the EDITOR-INSTANCE
// ------------------------------
?>
<textarea name="HTMLEditor" id="HTMLEditor" cols="90" rows="30">
<?php echo htmlspecialchars($pageContent['content'],ENT_NOQUOTES,'UTF-8'); ?>
</textarea>

<script type="text/javascript">
/* <![CDATA[ */  

window.addEvent('domready',function(){

  // set the CONFIGs of the editor
  CKEDITOR.config.baseHref                  = '<?php echo $adminConfig['basePath']."library/thirdparty/ckeditor/"; ?>';
  CKEDITOR.config.language                  = '<?php echo $_SESSION["language"]; ?>';
  CKEDITOR.config.contentsCss               = [<?php echo "'".str_replace('|#|',"','",$editorStyleFile)."'"; ?>];
  CKEDITOR.config.bodyId                    = '<?php echo $editorStyleId; ?>';
  CKEDITOR.config.bodyClass                 = '<?php echo $editorStyleClass; ?>';
  CKEDITOR.config.enterMode                 = <?php if($adminConfig['editor']['enterMode'] == "br") echo "CKEDITOR.ENTER_BR"; else echo "CKEDITOR.ENTER_P"; ?>;
  CKEDITOR.config.stylesSet                 = 'htmlEditorStyles:../../../config/htmlEditorStyles.js';
  CKEDITOR.config.filebrowserBrowseUrl      = <?php if($adminConfig['user']['fileManager']) echo "'library/thirdparty/filemanager/index.php'"; else echo "''"; ?>;

});
/* ]]> */
</script>

    <div class="content">    
    
    <a href="#" id="hotKeysToogle" class="down standardLink"><?php echo $langFile['editor_htmleditor_hotkeys_h1']; ?></a><br />
    <br />
    <div id="hotKeys" style="border:1px solid #B3B3B4; width: 450px; background-color:#B3B3B4;">    
    <table width="450" cellspacing="0" cellpadding="8" border="0">
      <tr>
        <td style="background-color:#EDECEC;">
          <b><?php echo $langFile['editor_htmleditor_hotkeys_field1']; ?></b></td>
        <td align="left" style="background-color:#EDECEC;"> STRG + A</td>
      </tr><tr>
        <td style="background-color:#E3E3E3;">
          <b><?php echo $langFile['editor_htmleditor_hotkeys_field2']; ?></b></td>
        <td align="left" style="background-color:#E3E3E3;"> STRG + C</td>
      </tr><tr>
        <td style="background-color:#EDECEC;">
          <b><?php echo $langFile['editor_htmleditor_hotkeys_field3']; ?></b></td>
        <td align="left" style="background-color:#EDECEC;">
          STRG + V</td>
      </tr><tr>
        <td style="background-color:#E3E3E3;">
          <b><?php echo $langFile['editor_htmleditor_hotkeys_field4']; ?></b></td>
        <td align="left" style="background-color:#E3E3E3;">
          STRG + X 
          <b><?php echo $langFile['editor_htmleditor_hotkeys_or']; ?></b> SHIFT + Del</td>
      </tr><tr>
        <td colspan="2" height="5" style="background-color:#B3B3B4;"> </td>
      </tr><tr>
        <td style="background-color:#EDECEC;">
          <b><?php echo $langFile['editor_htmleditor_hotkeys_field5']; ?></b></td>
        <td align="left" style="background-color:#EDECEC;"> STRG + Z</td>
      </tr><tr>
        <td style="background-color:#E3E3E3;">
          <b><?php echo $langFile['editor_htmleditor_hotkeys_field6']; ?></b></td>
        <td align="left" style="background-color:#E3E3E3;">
          STRG + Y 
          <b><?php echo $langFile['editor_htmleditor_hotkeys_or']; ?></b> STRG + SHIFT + Z</td>
      </tr><tr>
        <td colspan="2" height="5" style="background-color:#B3B3B4;"> </td>
      </tr><tr>
        <td style="background-color:#EDECEC;">
          <b><?php echo $langFile['editor_htmleditor_hotkeys_field7']; ?></b></td>
        <td align="left" style="background-color:#EDECEC;"> STRG + L</td>
      </tr><tr>
        <td style="background-color:#E3E3E3;">
          <b><?php echo $langFile['editor_htmleditor_hotkeys_field8']; ?></b></td>
        <td align="left" style="background-color:#E3E3E3;"> STRG + B</td>
      </tr><tr>
        <td style="background-color:#EDECEC;">
          <b><?php echo $langFile['editor_htmleditor_hotkeys_field9']; ?></b></td>
        <td align="left" style="background-color:#EDECEC;"> STRG + I</td>
      </tr><tr>
        <td style="background-color:#E3E3E3;">
          <b><?php echo $langFile['editor_htmleditor_hotkeys_field10']; ?></b></td>
        <td align="left" style="background-color:#E3E3E3;"> STRG + U</td>
      </tr>
    </table>
    </div>
    
    <!--<input type="reset" value="" class="button cancel" title="<?php echo $langFile['form_cancel']; ?>" />-->
    <input type="submit" value="" class="button submit center" title="<?php echo $langFile['form_submit']; ?>" onclick="submitAnchor('editorForm','htmlEditorAnchor');" />
  </div>
</div>

<!-- ***** ADVANCED PAGE SETTINGS -->
<a name="advancedPageSettingsAnchor" id="advancedPageSettingsAnchor" class="anchorTarget"></a>
<?php
// shows the block below if it is the ones which is saved before
$hidden = ($savedForm == 'advancedPageSettings') ? '' : ' hidden';
$blockContentEdited = (!empty($pageContent['styleFile']) || !empty($pageContent['styleId']) || !empty($pageContent['styleClass']))
  ? '&nbsp;<img src="library/image/sign/edited_small.png" class="blockH1Icon toolTip" title="'.$langFile['editor_advancedpageSettings_h1'].' '.$langFile['editor_block_edited'].'::" alt="icon" />'
  : '';
?>
<div class="block<?php echo $hidden; ?>">
  <h1><a href="#"><?php echo $langFile['editor_advancedpageSettings_h1'].$blockContentEdited; ?></a></h1>
  <div class="content">
    <table>
     
      <colgroup>
      <col class="left" />
      </colgroup>
  
      <tr><td class="leftTop"></td><td></td></tr>
      
      <tr><td class="left">
      <span class="toolTip" title="<?php echo $langFile['stylesheet_name_styleFile'].'::'.$langFile['stylesheet_styleFile_tip'].'[br /][br /][span class=hint]'.$langFile['editor_advancedpageSettings_stylesheet_ifempty'].'[/span]'; ?>"><?php echo $langFile['stylesheet_name_styleFile']; ?></span>
      </td><td class="right">
      <div id="pageStyleFilesInputs" class="inputToolTip" title="<?php echo $langFile['path_absolutepath_tip'].'::[span class=hint]'.$langFile['editor_advancedpageSettings_stylesheet_ifempty'].'[/span]'; ?>">
      <span class="hint" style="float:right;width:190px;"><?php echo $langFile['stylesheet_styleFile_example']; ?></span>
      <?php      
      $styleFileInputs = explode('|#|',getStylesByPriority($pageContent['styleFile'],'styleFile',$pageContent['category']));
      
      foreach($styleFileInputs as $styleFileInput) {
        echo '<input name="styleFile[]" value="'.$styleFileInput.'" />';
      }      
      ?>
      </div>
      <a href="#" class="addStyleFilePath toolTip" title="<?php echo $langFile['stylesheet_styleFile_addButton_tip']; ?>::"></a>
      </td></tr>
                  
      <tr><td class="left">
      <span class="toolTip" title="<?php echo $langFile['stylesheet_name_styleId'].'::'.$langFile['stylesheet_styleId_tip'].'[br /][br /][span class=hint]'.$langFile['editor_advancedpageSettings_stylesheet_ifempty'].'[/span]'; ?>"><?php echo $langFile['stylesheet_name_styleId']; ?></span>
      </td><td class="right">
      <input name="styleId" value="<?php echo getStylesByPriority($pageContent['styleId'],'styleId',$pageContent['category']); ?>" class="inputToolTip" title="<?php echo $langFile['editor_advancedpageSettings_stylesheet_ifempty']; ?>" />
      </td></tr>
                  
      <tr><td class="left">
      <span class="toolTip" title="<?php echo $langFile['stylesheet_name_styleClass'].'::'.$langFile['stylesheet_styleClass_tip'].'[br /][br /][span class=hint]'.$langFile['editor_advancedpageSettings_stylesheet_ifempty'].'[/span]'; ?>"><?php echo $langFile['stylesheet_name_styleClass']; ?></span>
      </td><td class="right">
      <input name="styleClass" value="<?php echo getStylesByPriority($pageContent['styleClass'],'styleClass',$pageContent['category']); ?>" class="inputToolTip" title="<?php echo $langFile['editor_advancedpageSettings_stylesheet_ifempty']; ?>" />
      </td></tr>

      <tr><td class="leftBottom"></td><td></td></tr>
      
    </table>
    
    <!--<input type="reset" value="" class="button cancel" title="<?php echo $langFile['form_cancel']; ?>" />-->
    <input type="submit" value="" class="button submit center" title="<?php echo $langFile['form_submit']; ?>" onclick="$('savedBlock').value = 'advancedPageSettings'; submitAnchor('editorForm','advancedPageSettingsAnchor');" />
  </div>
  <div class="bottom"></div>
</div>
</form>
