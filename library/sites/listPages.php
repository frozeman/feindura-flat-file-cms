<?php
/*  feindura - Flat File Content Management System
    Copyright (C) Fabian Vogelsteller [frozeman.de]

    This program is free software;
    you can redistribute it and/or modify it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 3 of the License, or (at your option) any later version.

    This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY;
    without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
    See the GNU General Public License for more details.

    You should have received a copy of the GNU General Public License along with this program;
    if not,see <http://www.gnu.org/licenses/>.

listPages.php version 0.84

*/

include_once(dirname(__FILE__).'/../backend.include.php');

$opendCategory = false;

// -> CHANGE PAGE STATUS
if($_GET['status'] == 'changePageStatus') {
    
    if($contentArray = $generalFunctions->readPage($_GET['page'],$_GET['category'])) {      
      // change the status
      if($_GET['public'])
        $contentArray['public'] = '';
      else
        $contentArray['public'] = 'true';      
      // save the new status
      if($generalFunctions->savePage($_GET['category'],$_GET['page'],$contentArray))
        $documentSaved = true;
      else
        $errorWindow = $langFile['sortablePageList_changeStatusPage_error_save'];
        
    } else
      $errorWindow = $langFile['file_error_read'];
  
  // shows after saving the category open
  $opendCategory = $_GET['category'];
}

// -> CHANGE CATEGORY STATUS
if($_GET['status'] == 'changeCategoryStatus') {    
     
      // change the status
      if($_GET['public'])
        $categoryConfig['id_'.$_GET['category']]['public'] = '';
      else
        $categoryConfig['id_'.$_GET['category']]['public'] = 'true';      
      // save the new status
      if(saveCategories($categoryConfig))
        $documentSaved = true;
      else
        $errorWindow = $langFile['sortablePageList_changeStatusPage_error_save'];
   
   // shows after saving the category open
   $opendCategory = $_GET['category'];
}

// -> SET THE STARTPAGE
if($_GET['status'] == 'setStartPage' && !empty($_GET['page'])) {
  
    // sets the new startPage
    $websiteConfig['startPage'] = $_GET['page'];
    
    if(savewebsiteConfig($websiteConfig)) {
      // give documentSaved status
      $documentSaved = true;
      
    } else $errorWindow = $langFile['sortablePageList_setStartPage_error_save'];

  
  // shows after saving the category open
   $opendCategory = $_GET['category'];
}


// ***********************************************************************
// CHECKs if a STARTPAGE is SET and if this page exists
// if not throw a warning
startPageWarning();

//<!--<a href="#" onclick="activateSortPages();">sdfsdf</a> in sortPages.js-->

?>

<h1><?php echo $langFile['sortablePageList_h1']; ?></h1>

<div class="listPagesHead">
  <div class="name"><?php echo $langFile['sortablePageList_headText1']; ?></div>
  <div class="lastSaveDate"><?php echo $langFile['sortablePageList_headText2']; ?></div>
  <div class="status"><?php echo $langFile['sortablePageList_headText3']; ?></div>
  <div class="counter"><?php echo $langFile['sortablePageList_headText4']; ?></div>
  <div class="functions"><?php echo $langFile['sortablePageList_headText5']; ?></div>
</div>

<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post" accept-charset="UTF-8">
<?php

// shows the PAGES in NO CATEGORIES (the page/ folder),
// by adding a empty category to the $categoryConfig array
$allCategories= $categoryConfig;
array_unshift($allCategories,array('id' => 0,'name' => $langFile['categories_nocategories_name'].' <span style="font-size:12px;color:#9FA0A0;">('.$langFile['categories_nocategories_hint'].')</span>'));

// -----------------------------------------------------------------------------------------------------------
// ->> LIST CATEGORIES
foreach($allCategories as $category) {
  
  // -> LOAD the PAGES FROM the CATEGORY
  $pages = $generalFunctions->loadPages($category['id']);
  //print_r($pages);

  // shows after saving the right category open
  if(is_array($pages) &&                                                            // -> slide in the category if EMPTY
     (!isset($_GET['category']) && $category['id'] == 0) ||                                             // -> slide non-category in if no category is selected
     ($opendCategory === $category['id'] || $_GET['category'] == $category['id']))   // -> slide out the category if ACTIVE
    $hidden = '';
  else
    $hidden = ' hidden';
  
  // shows the text of the sorting of a CATEGORY
  if($category['sortbypagedate'] == 'true') {
    $categorySorting = '&nbsp;<img src="library/image/sign/sortByDate_small.png" class="sortIcon toolTip" title="'.$langFile['sortablePageList_sortOrder_date'].'::" alt="icon" />';
  } else {
    $categorySorting = '';
    //$categorySorting = '<span style="font-size: 12px; font-weight: normal;">('.$langFile['sortablePageList_sortOrder_manuell'].')</span>';
  }
  
  // show whether the category is public or nonpublic
  if($category['public']) {
    $publicClass = ' public';
    $publicText = $langFile['status_category_public'];
  } else {
    $publicClass = ' nonpublic';
    $publicText = $langFile['status_category_nonpublic'];
  }
  
  // shows ID and different header color if its a CATEGORY
  if($category['id'] != 0) {
    //$categoryId = '<span style="font-size: 12px; font-weight: normal;">(ID <b>'.$category['id'].'</b>)</span>';
    $headerColor = ' class="toolTip blue"';
    $headerIcon = 'library/image/sign/categoryIcon_small.png';
    $category['name'] = ' '.$category['name'];
  } else {
    //$categoryId = '<span style="color: #999999; font-size: 12px; font-weight: normal;">(ID <b>'.$category['id'].'</b>)</span>';
    $headerColor = ' class="toolTip brown"';
    $headerIcon = 'library/image/sign/pageIcon_middle.png';
  }
  
  // -> CREATE CATEGORY HEADLINE
  echo "\n\n".'<div class="block listPages'.$hidden.'" style="margin-top:-20px;">
          <h1'.$headerColor.' title="ID '.$category['id'].'::"><a href="?site=pages&amp;category='.$category['id'].'" style="font-size:15px; font-weight:bold; line-height:30px;" onclick="return false;"><img src="'.$headerIcon.'" alt="category icon" />'.$category['name'].' '.$categorySorting.'</a></h1>
          <div class="category">';
    
    // show category status only if its a category (0 is none)
    if($category['id'] != 0)
      echo '<a href="?site='.$_GET['site'].'&amp;status=changeCategoryStatus&amp;public='.$category['public'].'&amp;category='.$category['id'].'" class="changeStatusCategory toolTip'.$publicClass.'" title="'.$publicText.'::'.$langFile['sortablePageList_changeStatus_linkCategory'].'">&nbsp;</a>';
  
      // CATEGORY FUNCTIONS
      echo '<div class="functions">';
      
      // create page
      if(($category['id'] == 0 && $adminConfig['page']['createPages']) || $category['createdelete'])
        echo '<a href="?category='.$category['id'].'&amp;page=new" title="'.$langFile['btn_createPage_title'].'::" class="createPage toolTip">&nbsp;</a>';
         
  echo '    </div>
          </div>          
        <div class="content">';
  
  // -> CHECK if pages are sortable
  if(empty($category['sortbypagedate']))
    $listIsSortableClass = ' class="sortablePageList"';
  else
    $listIsSortableClass = '';
  
  echo '<ul'.$listIsSortableClass.' id="category'.$category['id'].'">';

  // list the pages of the categories
  // ----------------------------------------------------------
  if(is_array($pages) && !empty($pages)) {
  
    // create array for the sort_order start input value
    $sort_order = array();
  
    // zählt die $pages durch
    foreach ($pages as $pageContent) {

      // vars
      $showDate = '';
      $showTags = '';
      $sort_order[] = $pageContent['sortorder'];
    
      // show whether the page is public or nonpublic
      if($pageContent['public']) {
        $publicClass = ' public';
        $publicText = $langFile['status_page_public'];
      } else {
        $publicClass = ' nonpublic';
        $publicText = $langFile['status_page_nonpublic'];
      }
      
      // shorten the title
      if(strlen($pageContent['title']) <= $generalFunctions->getCharacterNumber($pageContent['title'],31)) {
        $titleShort = $pageContent['title'];
      } else {
        $titleShort = substr($pageContent['title'],0,$generalFunctions->getCharacterNumber($pageContent['title'],29)).'..';      // (String) the string to shorten 
      }
      
      // -> show lastsavedate
      $lastSaveDate = $statisticFunctions->formatDate($pageContent['lastsavedate']).' '.$statisticFunctions->formatTime($pageContent['lastsavedate']);
      
      // -> show pagedate
      if($category['showpagedate'] &&
        (!empty($pageContent['pagedate']['before']) || !empty($pageContent['pagedate']['date']) || !empty($pageContent['pagedate']['after']))) {
        
        // CHECKs the DATE FORMAT
        if(!empty($pageContent['pagedate']['date']) && $statisticFunctions->validateDateFormat($pageContent['pagedate']['date']) === false)
          $showDate = '[br /][br /][b]'.$langFile['sortablePageList_pagedate'].'[/b][br /]'.$pageContent['pagedate']['before'].' '.'[span style=color:#950300;]'.$langFile['editor_pageSettings_pagedate_error'].':[/span] '.$pageContent['pagedate']['date'].' '.$pageContent['pagedate']['after'];
        else
          $showDate = '[br /][br /][b]'.$langFile['sortablePageList_pagedate'].'[/b][br /]'.$pageContent['pagedate']['before'].' '.$statisticFunctions->formatDate($pageContent['pagedate']['date']).' '.$pageContent['pagedate']['after'];
        
      } else $showDate = '';
      
      // -> show tags
      if($category['showtags'] && !empty($pageContent['tags'])) {
        $showTags = '[br /][br /]';
        $showTags .= '[b]'.$langFile['sortablePageList_tags'].'[/b][br /]'.$pageContent['tags'];
      }

      
      // -----------------------   ********  ---------------------- 
      // LIST PAGES
      // id'.$pageContent['id'].' sort'.$pageContent['sortorder'].' cat: '.$pageContent['category'].' 
      echo '<li id="page'.$pageContent['id'].'">';
      
      // startpage icon before the name
      if($adminConfig['setStartPage'] && $pageContent['id'] == $websiteConfig['startPage']) {
        $activeStartPage = ' style="background: url(library/image/key/listPages_startPage.png) no-repeat 0px -27px !important;"';
      } else {
        $activeStartPage = '';
      }
      
      echo '<div class="name"><a href="?category='.$category['id'].'&amp;page='.$pageContent['id'].'"'.$activeStartPage.' class="toolTip" title="'.str_replace(array('[',']','<','>','"'),array('(',')','(',')',''),$pageContent['title']).'::[b]ID[/b] '.$pageContent['id'].$showDate.$showTags.'"><b>'.$titleShort.'</b></a></div>';
      if(!empty($pageContent['lastsaveauthor']))
        echo '<div class="lastSaveDate toolTip" title="'.$langFile['editor_h1_lastsaveauthor'].' '.$pageContent['lastsaveauthor'].'::">&nbsp;&nbsp;'.$lastSaveDate.'</div>';
      else
        echo '<div class="lastSaveDate">&nbsp;&nbsp;'.$lastSaveDate.'</div>';
      echo '<div class="counter">&nbsp;&nbsp;'.$statisticFunctions->formatHighNumber($pageContent['log_visitCount']).'</div>
      <div class="status'.$publicClass.'"><a href="?site='.$_GET['site'].'&amp;status=changePageStatus&amp;public='.$pageContent['public'].'&amp;category='.$category['id'].'&amp;page='.$pageContent['id'].'" class="toolTip" title="'.$publicText.'::'.$langFile['sortablePageList_changeStatus_linkPage'].'">&nbsp;</a></div>';
      
      // PAGE FUCNTIONS
      echo '<div class="functions">';      
      
      // thumbnail upload
      if(($category['id'] == 0 && $adminConfig['page']['thumbnailUpload']) || $allCategories['id_'.$category['id']]['thumbnail'])
        echo '<a href="?site=pageThumbnailUpload&amp;category='.$category['id'].'&amp;page='.$pageContent['id'].'" onclick="openWindowBox(\'library/sites/pageThumbnailUpload.php?site='.$_GET['site'].'&amp;category='.$category['id'].'&amp;page='.$pageContent['id'].'\',\''.$langFile['btn_pageThumbnailUpload'].'\');return false;" title="'.$langFile['btn_pageThumbnailUpload_title'].'::" class="pageThumbnailUpload toolTip">&nbsp;</a>';
      
      // thumbnail upload delete
      if((($category['id'] == 0 && $adminConfig['page']['thumbnailUpload']) || $allCategories['id_'.$category['id']]['thumbnail']) && !empty($pageContent['thumbnail']))
        echo '<a href="?site=pageThumbnailDelete&amp;category='.$category['id'].'&amp;page='.$pageContent['id'].'" onclick="openWindowBox(\'library/sites/pageThumbnailDelete.php?site='.$_GET['site'].'&amp;category='.$category['id'].'&amp;page='.$pageContent['id'].'\',\''.$langFile['btn_pageThumbnailDelete'].'\');return false;" title="'.$langFile['btn_pageThumbnailDelete_title'].'::" class="pageThumbnailDelete toolTip">&nbsp;</a>';
               
      // edit page
      echo '<a href="?category='.$category['id'].'&amp;page='.$pageContent['id'].'" title="'.$langFile['sortablePageList_functions_editPage'].'::" class="editPage toolTip">&nbsp;</a>';
      
      // delete page
      if(($category['id'] == 0 && $adminConfig['page']['createPages']) || $allCategories['id_'.$category['id']]['createdelete'])
        echo '<a href="?site=deletePage&amp;category='.$category['id'].'&amp;page='.$pageContent['id'].'" onclick="openWindowBox(\'library/sites/deletePage.php?category='.$category['id'].'&amp;page='.$pageContent['id'].'\',\''.$langFile['btn_deletePage'].'\');return false;" title="'.$langFile['sortablePageList_functions_deletePage'].'::" class="deletePage toolTip">&nbsp;</a>';
         
      
      // startpage
      if($adminConfig['setStartPage']) {
        if($pageContent['id'] == $websiteConfig['startPage']) {
          $activeStartPage = ' active';
          $startPageTitle = $langFile['btn_startPage_set'];
        } else {
          $activeStartPage = '';
          $startPageTitle = $langFile['btn_startPage_title'];
        }        
        echo '<a href="?site='.$_GET['site'].'&amp;status=setStartPage&amp;category='.$category['id'].'&amp;page='.$pageContent['id'].'" title="'.$startPageTitle.'::" class="startPage'.$activeStartPage.' toolTip">&nbsp;</a>';
      }
            
      echo '</div>
      </li>'."\n";
      // backup download <a href="download.php?filename='.$pageContent['id'].'.php&amp;category='.$category['id'].'" class="extern" title="'.$adminConfig['savePath'].$gruppe['short'].'/'.$pageContent['id'].'.php">Download</a>
      // LIST PAGES END
      // -----------------------   ********  ----------------------      
      
      } 
   
  } else {
    echo '<li><div>'.$langFile['sortablePageList_categoryEmpty'].'</div></li>';
  }

echo '</ul>
     </div>
     <div class="bottom"></div>
  </div>';


echo "\n".'<!-- transport the sortorder to the javascript -->
      <input type="hidden" name="reverse" id="reverse'.$category['id'].'" value="'.$allCategories['id_'.$category['id']]['sortascending'].'" /> <!-- reverse order yes/no -->
      <input type="hidden" name="sort_order" id="sort_order'.$category['id'].'" value="'.@implode($sort_order,'|').'" /> <!-- the new page order -->';
}

unset($pageContent);

?>
</form>