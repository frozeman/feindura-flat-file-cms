<?php
/*  feindura - Flat File Content Management System
    Copyright (C) 2009 Fabian Vogelsteller [frozeman.de]

    This program is free software;
    you can redistribute it and/or modify it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 3 of the License, or (at your option) any later version.

    This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY;
    without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
    See the GNU General Public License for more details.

    You should have received a copy of the GNU General Public License along with this program;
    if not,see <http://www.gnu.org/licenses/>.

pages.php version 0.76

*/

include_once(dirname(__FILE__).'/../backend.include.php');

$documentSaved = false;
$errorWindow = false;
$opendCategory = false;

// -> CHANGE PAGE STATUS
if($_GET['status'] == 'changePageStatus') {
    
    if($contentArray = readPage($_GET['page'],$_GET['category'])) {      
      // change the status
      if($_GET['public'])
        $contentArray['public'] = '';
      else
        $contentArray['public'] = 'true';      
      // save the new status
      if(savePage($_GET['category'],$_GET['page'],$contentArray))
        $documentSaved = true;
      else
        $errorWindow = $langFile['sortablePageList_changeStatusPage_error_save'];
        
    } else
      $errorWindow = $langFile['file_error_read'];
  
  // shows after saving the category open
  $opendCategory = $_GET['category'];
}

// -> CHANGE STATUS OF THE WHOLE CATEGORY
if($_GET['status'] == 'changeCategoryStatus') {    
     
      // change the status
      if($_GET['public'])
        $categories['id_'.$_GET['category']]['public'] = '';
      else
        $categories['id_'.$_GET['category']]['public'] = 'true';      
      // save the new status
      if(saveCategories($categories))
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

?>
<!-- documentSaved -->
<div id="documentSaved"<?php if($documentSaved) echo ' class="saved"'; ?>></div>

<div id="sortPagesMessageBox"><?php echo $langFile['sortablePageList_info']; ?></div>
<!-- the javascript request of the sortable gets its error messages from this input -->
<div><input type="hidden" id="sortablePageList_status" value="<?php echo $langFile['sortablePageList_save'].'|'.$langFile['sortablePageList_categoryEmpty']; ?>" /></div>



<h1><?php echo $langFile['sortablePageList_h1']; ?></h1>

<div class="listPagesHead">
  <div class="name"><?php echo $langFile['sortablePageList_headText1']; ?></div>
  <div class="saveDate"><?php echo $langFile['sortablePageList_headText2']; ?></div>
  <div class="status"><?php echo $langFile['sortablePageList_headText3']; ?></div>
  <div class="counter"><?php echo $langFile['sortablePageList_headText4']; ?></div>
  <div class="functions"><?php echo $langFile['sortablePageList_headText5']; ?></div>
</div>

<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">
<?php

// shows the PAGES in NO CATEGORIES (the page/ folder),
// by adding a empty category to the $categories array
array_unshift($categories,array('id' => 0,'name' => $langFile['categories_nocategories_name'].' <span style="font-size:12px;color:#9FA0A0;">('.$langFile['categories_nocategories_hint'].')</span>'));

// -----------------------------------------------------------------------------------------------------------
// LIST CATEGORIES
foreach($categories as $category) {

  // shows after saving the right category open
  if(empty($_GET['category']) || $opendCategory == $category['id'] || $_GET['category'] == $category['id'])
    $hidden = '';
  else
    $hidden = ' hidden';
  
  // shows the text of the sorting of a CATEGORY
  if($category['sortdate'] == 'true') {
    $categorySorting = '<img src="library/image/sign/sortByDate_small.png" class="toolTip" title="'.$langFile['sortablePageList_sortOrder_date'].'::" />';
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
  
  // shows ID and differtnet header color if its a CATEGORY
  if($category['id'] != 0) {
    //$categoryId = '<span style="font-size: 12px; font-weight: normal;">(ID <b>'.$category['id'].'</b>)</span>';
    $headerColor = ' class="blue"';
  } else {
    //$categoryId = '<span style="color: #999999; font-size: 12px; font-weight: normal;">(ID <b>'.$category['id'].'</b>)</span>';
    $headerColor = ' class="brown"';
  }

  echo '<div class="block listPages'.$hidden.'" style="margin-top:-20px;">
          <h1'.$headerColor.'><a href="#" style="font-size:15px; font-weight:bold; line-height:30px;"><span class="toolTip" title="ID '.$category['id'].'::"><img src="library/image/sign/categoryIcon_small.png" alt="category icon" /> '.$category['name'].'</span> '.$categorySorting.'</a></h1>
          <div class="category">';
    
    // show category status only if its a category (0 is none)
    if($category['id'] != 0)
      echo '<a href="?site='.$_GET['site'].'&amp;status=changeCategoryStatus&amp;public='.$category['public'].'&amp;category='.$category['id'].'" class="changeStatusCategory toolTip'.$publicClass.'" title="'.$publicText.'::'.$langFile['sortablePageList_changeStatus_linkCategory'].'">&nbsp;</a>';
  
    // CATEGORY FUNCTIONS
    echo '<div class="functions">';
    
    // create page
    if(($category['id'] == 0 && $adminConfig['page']['createPages']) || $categories['id_'.$category['id']]['createdelete'])
      echo '<a href="?category='.$category['id'].'&amp;page=new" title="'.$langFile['btn_createPage_title'].'::" class="createPage toolTip">&nbsp;</a>';
      
    echo '</div>';
            
  echo ' </div>          
        <div class="content">';
  
  echo '<ul class="sortablePageList" id="category'.$category['id'].'">';

//lädt die seiten aus den gruppenverzeichnis in einen array
$pages = loadPages($category['id']);
//print_r($pages);

// list the pages of the categories
// ----------------------------------------------------------
if(is_array($pages)) {
  
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
      
      // kürzt den titel
      if(strlen($pageContent['title'])<= 21) {
        $titleShort = $pageContent['title'];
      } else {
        $titleShort = substr($pageContent['title'],0,20).'..';
      }
      
      // show savedate
      $date = formatDate($pageContent['savedate']).' '.formatTime($pageContent['savedate']);
      
      // show sortdate
      if(!empty($pageContent['sortdate'])) {
        
        // CHECKs the DATE FORMAT
        if(!empty($pageContent['sortdate']) && !empty($pageContent['sortdate'][1]) && validateDateFormat($pageContent['sortdate'][1]) === false)
          $showDate = '[b]'.$langFile['sortablePageList_sortDate'].'[/b][br /]'.$pageContent['sortdate'][0].' '.'[span style=color:#950300;]'.$langFile['editor_pageSettings_sortDate_error'].':[/span] '.$pageContent['sortdate'][1].' '.$pageContent['sortdate'][2];
        else
          $showDate = '[b]'.$langFile['sortablePageList_sortDate'].'[/b][br /]'.$pageContent['sortdate'][0].' '.formatDate($pageContent['sortdate'][1]).' '.$pageContent['sortdate'][2];
        
      } else $showDate = '';
      
      // show tags
      if(!empty($pageContent['tags'])) {
        if(!empty($showDate))
          $showTags = '[br /][br /]';
        $showTags .= '[b]'.$langFile['sortablePageList_tags'].'[/b][br /]'.$pageContent['tags'];
      }

      
      // -----------------------   ********  ---------------------- 
      // LIST PAGES
      // id'.$pageContent['id'].' sort'.$pageContent['sortorder'].' cat: '.$pageContent['category'].' 
      echo '<li id="page'.$pageContent['id'].'">
      <div class="name"><a href="?category='.$category['id'].'&amp;page='.$pageContent['id'].'" class="toolTip" title="'.str_replace(array('[',']','<','>','"'),array('(',')','(',')',''),$pageContent['title']).'::[b]ID[/b] '.$pageContent['id'].'[br /][br /]'.$showDate.$showTags.'"><b>'.$titleShort.'</b></a></div>
      <div class="saveDate">&nbsp;&nbsp;'.$date.'</div>
      <div class="counter">&nbsp;&nbsp;'.$pageContent['log_visitCount'].'</div>
      <div class="status'.$publicClass.'"><a href="?site='.$_GET['site'].'&amp;status=changePageStatus&amp;public='.$pageContent['public'].'&amp;category='.$category['id'].'&amp;page='.$pageContent['id'].'" class="toolTip" title="'.$publicText.'::'.$langFile['sortablePageList_changeStatus_linkPage'].'">&nbsp;</a></div>';
      
      // PAGE FUCNTIONS
      echo '<div class="functions">';
      
      // thumbnail upload delete
      if((($category['id'] == 0 && $adminConfig['page']['thumbnailUpload']) || $categories['id_'.$category['id']]['thumbnail']) && !empty($pageContent['thumbnail']))
        echo '<a href="?site=pageThumbnailDelete&amp;category='.$category['id'].'&amp;page='.$pageContent['id'].'" onclick="openWindowBox(\'library/sites/pageThumbnailDelete.php?site='.$_GET['site'].'&amp;category='.$category['id'].'&amp;page='.$pageContent['id'].'\',\''.$langFile['btn_pageThumbnailDelete'].'\');return false;" title="'.$langFile['btn_pageThumbnailDelete_title'].'::" class="pageThumbnailDelete toolTip">&nbsp;</a>';
      
      // thumbnail upload
      if(($category['id'] == 0 && $adminConfig['page']['thumbnailUpload']) || $categories['id_'.$category['id']]['thumbnail'])
        echo '<a href="?site=pageThumbnailUpload&amp;category='.$category['id'].'&amp;page='.$pageContent['id'].'" onclick="openWindowBox(\'library/sites/pageThumbnailUpload.php?site='.$_GET['site'].'&amp;category='.$category['id'].'&amp;page='.$pageContent['id'].'\',\''.$langFile['btn_pageThumbnailUpload'].'\');return false;" title="'.$langFile['btn_pageThumbnailUpload_title'].'::" class="pageThumbnailUpload toolTip">&nbsp;</a>';
      
      // delete page
      if(($category['id'] == 0 && $adminConfig['page']['createPages']) || $categories['id_'.$category['id']]['createdelete'])
        echo '<a href="?site=deletePage&amp;category='.$category['id'].'&amp;page='.$pageContent['id'].'" onclick="openWindowBox(\'library/sites/deletePage.php?category='.$category['id'].'&amp;page='.$pageContent['id'].'\',\''.$langFile['btn_deletePage'].'\');return false;" title="'.$langFile['sortablePageList_functions_deletePage'].'::" class="deletePage toolTip">&nbsp;</a>';
            
      // edit page
      echo '<a href="?category='.$category['id'].'&amp;page='.$pageContent['id'].'" title="'.$langFile['sortablePageList_functions_editPage'].'::" class="editPage toolTip">&nbsp;</a>';
      
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
      </li>'."\n";  // backup download <a href="download.php?filename='.$pageContent['id'].'.php&amp;category='.$category['id'].'" class="extern" title="'.$adminConfig['savePath'].$gruppe['short'].'/'.$pageContent['id'].'.php">Download</a>
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


echo '<!-- Übergibt variablen an das Javascript -->
      <input type="hidden" name="reverse" id="reverse'.$category['id'].'" value="'.$categories['id_'.$category['id']]['sortascending'].'" /> <!-- absteigede reihenfolge ja/nein -->
      <input type="hidden" name="sort_order" id="sort_order'.$category['id'].'" value="'.@implode($sort_order,'|').'" />             <!-- die neue ordnung der Seiten -->';
}

unset($pageContent);
// include the the categoryConfig.php again, to overwrite the eventually changed $categories var
include(dirname(__FILE__)."/../../config/categoryConfig.php");
?>


</form>


<!-- errorWindow -->
<?php if($errorWindow !== false) { ?>
<div id="errorWindow">
  <div class="top"><?php echo $langFile['form_errorWindow_h1'];?></div>
  <div class="content warning">
    <p><?php echo $errorWindow; ?></p>
    <a href="?site=<?php echo $_GET['site'] ?>" onclick="$('errorWindow').fade('out');return false;" class="ok"></a>
  </div>
  <div class="bottom"></div>
</div>
<?php } ?>
