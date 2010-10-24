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

* listPages.php version 0.86
*/

/**
 * Includes the login and filters the incoming data by xssFilter
 */
require_once(dirname(__FILE__)."/../includes/secure.include.php");

?>
<div class="block open noBg">
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
array_unshift($allCategories,array('id' => 0,'name' => $langFile['categories_noncategory_tip']));

// -----------------------------------------------------------------------------------------------------------
// ->> LIST CATEGORIES
foreach($allCategories as $category) {
  
  // -> LOAD the PAGES FROM the CATEGORY
  $pages = $generalFunctions->loadPages($category['id'],true);
  //print_r($pages);

  // shows after saving the right category open
  $hidden = (is_array($pages) && !empty($pages) &&                                          // -> slide in the category if EMPTY
             (!isset($_GET['category']) && $category['id'] == '0') ||                       // -> slide non-category in if no category is selected
             ($opendCategory === $category['id'] || $_GET['category'] == $category['id']))  // -> slide out the category if ACTIVE
  ? '' : ' hidden';
  
  // shows the text of the sorting of a CATEGORY
  $categorySorting = ($category['sortbypagedate'])? '&nbsp;<img src="library/images/sign/sortByDate_small.png" class="blockH1Icon toolTip" title="'.$langFile['sortablePageList_sortOrder_date'].'::" alt="icon" />' : '';
  
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
    $headerColor = ' class="blue"';
    $headerIcon = 'library/images/sign/categoryIcon_small.png';
    $category['name'] = ' '.$category['name'];
  } else {
    //$categoryId = '<span style="color: #999999; font-size: 12px; font-weight: normal;">(ID <b>'.$category['id'].'</b>)</span>';
    $headerColor = ' class="brown"';
    $headerIcon = 'library/images/sign/pageIcon_middle.png';
  }
  
  // -> CREATE CATEGORY HEADLINE
  echo "\n\n".'<div class="block listPages'.$hidden.'">';
  	  // onclick="return false;" and set href to allow open categories olaso without javascript activated //a tag used line-height:30px;??
    echo '<h1'.$headerColor.'><a href="?site=pages&amp;category='.$category['id'].'" onclick="return false;"><span class="toolTip" title="ID '.$category['id'].'::"><img src="'.$headerIcon.'" alt="category icon" />'.$category['name'].'</span> '.$categorySorting.'</a></h1>
          <div class="category">';
      
      // CATEGORY STATUS
      echo '<div class="status">';
      // show category status only if its a category (0 is non-category)
      if($category['id'] != 0)
        echo '<a href="?site='.$_GET['site'].'&amp;status=changeCategoryStatus&amp;public='.$category['public'].'&amp;category='.$category['id'].'" class="toolTip'.$publicClass.'" title="'.$publicText.'::'.$langFile['sortablePageList_changeStatus_linkCategory'].'">&nbsp;</a>';
      echo '</div>';
	
      // CATEGORY FUNCTIONS
      echo '<div class="functions">';
      
      // create page
      if(($category['id'] == 0 && $adminConfig['pages']['createdelete']) || $category['createdelete'])
        echo '<a href="?category='.$category['id'].'&amp;page=new" title="'.$langFile['btn_createPage_tip'].'::" class="createPage toolTip">&nbsp;</a>';
         
  echo '  </div>
        </div>
      <div class="content">';
  
  // -> CHECK if pages are sortable
  $listIsSortableClass = (empty($category['sortbypagedate'])) ? ' class="sortablePageList"' : '';
  
  echo '<ul'.$listIsSortableClass.' id="category'.$category['id'].'">';

  // list the pages of the categories
  // ----------------------------------------------------------
  if(is_array($pages) && !empty($pages)) {
  
    // create array for the sort_order start input value
    $sort_order = array();
  
    // zählt die $pages durch
    foreach ($pages as $pageContent) {

      // vars
      $pageDate = '';
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
      $title = $generalFunctions->shortenTitle($pageContent['title'],31);
      
      // -> show lastsavedate
      $lastSaveDate = $statisticFunctions->formatDate($statisticFunctions->dateDayBeforeAfter($pageContent['lastsavedate'],$langFile)).' '.$statisticFunctions->formatTime($pageContent['lastsavedate']);
      
      // -> show pagedate
      if($statisticFunctions->checkPageDate($pageContent)) {
        
      	$titleDateBefore = '';
      	$titleDateAfter = '';
      	// adds spaces on before and after
      	if($pageContent['pagedate']['before']) $titleDateBefore = $pageContent['pagedate']['before'].' ';
      	if($pageContent['pagedate']['after']) $titleDateAfter = ' '.$pageContent['pagedate']['after'];
	
        // CHECKs the DATE FORMAT
        $pageDate = ($statisticFunctions->validateDateFormat($statisticFunctions->formatDate($pageContent['pagedate']['date'])) === false)
        ? '[br /][br /][b]'.$langFile['sortablePageList_pagedate'].'[/b][br /]'.$titleDateBefore.'[span style=color:#950300]'.$langFile['editor_pageSettings_pagedate_error'].':[/span][br /] '.$pageContent['pagedate']['date'].$titleDateAfter
        : '[br /][br /][b]'.$langFile['sortablePageList_pagedate'].'[/b][br /]'.$titleDateBefore.$statisticFunctions->formatDate($statisticFunctions->dateDayBeforeAfter($pageContent['pagedate']['date'],$langFile)).$titleDateAfter;
        
      } else $pageDate = '';
      
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
        $activeStartPage = ' startPage';
        $startPageText = $langFile['btn_startPage_set'].'[br /][br /]';
      } else {
        $activeStartPage = '';
        $startPageText = '';
      }
      
      echo '<div class="name"><a href="?category='.$category['id'].'&amp;page='.$pageContent['id'].'" class="toolTip'.$activeStartPage.'" title="'.str_replace(array('[',']','<','>','"'),array('(',')','(',')',''),$pageContent['title']).'::'.$startPageText.'[b]ID[/b] '.$pageContent['id'].$pageDate.$showTags.'"><b>'.$title.'</b></a></div>';
      if(!empty($pageContent['lastsaveauthor']))
        echo '<div class="lastSaveDate toolTip" title="'.$langFile['editor_h1_lastsaveauthor'].' '.$pageContent['lastsaveauthor'].'::">&nbsp;&nbsp;'.$lastSaveDate.'</div>';
      else
        echo '<div class="lastSaveDate">&nbsp;&nbsp;'.$lastSaveDate.'</div>';
      echo '<div class="counter">&nbsp;&nbsp;'.$statisticFunctions->formatHighNumber($pageContent['log_visitCount']).'</div>
      <div class="status'.$publicClass.'"><a href="?site='.$_GET['site'].'&amp;status=changePageStatus&amp;public='.$pageContent['public'].'&amp;category='.$category['id'].'&amp;page='.$pageContent['id'].'" class="toolTip" title="'.$publicText.'::'.$langFile['sortablePageList_changeStatus_linkPage'].'">&nbsp;</a></div>';
      
      // PAGE FUCNTIONS
      echo '<div class="functions">';      
 
      // thumbnail upload
      if(($category['id'] == 0 && $adminConfig['pages']['thumbnails']) || $allCategories[$category['id']]['thumbnail'])
        echo '<a href="?site=pageThumbnailUpload&amp;category='.$category['id'].'&amp;page='.$pageContent['id'].'" onclick="openWindowBox(\'library/sites/windowBox/pageThumbnailUpload.php?site='.$_GET['site'].'&amp;category='.$category['id'].'&amp;page='.$pageContent['id'].'\',\''.$langFile['btn_pageThumbnailUpload'].'\');return false;" title="'.$langFile['btn_pageThumbnailUpload_tip'].'::" class="pageThumbnailUpload toolTip">&nbsp;</a>';
      
      // thumbnail upload delete
      if((($category['id'] == 0 && $adminConfig['pages']['thumbnails']) || $allCategories[$category['id']]['thumbnail']) && !empty($pageContent['thumbnail']))
        echo '<a href="?site=pageThumbnailDelete&amp;category='.$category['id'].'&amp;page='.$pageContent['id'].'" onclick="openWindowBox(\'library/sites/windowBox/pageThumbnailDelete.php?site='.$_GET['site'].'&amp;category='.$category['id'].'&amp;page='.$pageContent['id'].'\',\''.$langFile['btn_pageThumbnailDelete'].'\');return false;" title="'.$langFile['btn_pageThumbnailDelete_tip'].'::" class="pageThumbnailDelete toolTip">&nbsp;</a>';
               
      // edit page
      echo '<a href="?category='.$category['id'].'&amp;page='.$pageContent['id'].'" title="'.$langFile['sortablePageList_functions_editPage'].'::" class="editPage toolTip">&nbsp;</a>';
      
      // delete page
      if(($category['id'] == 0 && $adminConfig['pages']['createdelete']) || $allCategories[$category['id']]['createdelete'])
        echo '<a href="?site=deletePage&amp;category='.$category['id'].'&amp;page='.$pageContent['id'].'" onclick="openWindowBox(\'library/sites/windowBox/deletePage.php?category='.$category['id'].'&amp;page='.$pageContent['id'].'\',\''.$langFile['btn_deletePage'].'\');return false;" title="'.$langFile['btn_deletePage'].'::" class="deletePage toolTip">&nbsp;</a>';

      // startpage
      if($adminConfig['setStartPage']) {
        if($pageContent['id'] == $websiteConfig['startPage']) {
          $activeStartPage = ' active';
          $startPageTitle = $langFile['btn_startPage_set'];
        } else {
          $activeStartPage = '';
          $startPageTitle = $langFile['btn_startPage_tip'];
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
    echo '<li><div style="position:relative; top:-2px; left:5px;">'.$langFile['sortablePageList_categoryEmpty'].'</div></li>';
  }

echo '</ul>
     </div>
     <div class="bottom"></div>
  </div>';

echo "\n".'<!-- transport the sortorder to the javascript -->
      <input type="hidden" name="reverse" id="reverse'.$category['id'].'" value="'.$allCategories[$category['id']]['sortascending'].'" /> <!-- reverse order yes/no -->
      <input type="hidden" name="sort_order" id="sort_order'.$category['id'].'" value="'.@implode($sort_order,'|').'" /> <!-- the new page order -->';
}

unset($pageContent);

?>
</form>
</div>