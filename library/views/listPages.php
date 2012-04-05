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
 * listPages.php 
 * 
 * @version 0.86
 */

/**
 * Includes the login.include.php and backend.include.php and filter the basic data
 */
require_once(dirname(__FILE__)."/../includes/secure.include.php");

?>
<div class="block open noBg">
<h1><?php echo $langFile['SORTABLEPAGELIST_h1']; ?></h1>

<div class="listPagesHead">
  <div class="name"><?php echo $langFile['SORTABLEPAGELIST_headText1']; ?> <input type="text" value="" size="25" id="listPagesFilter"><a href="#" id="listPagesFilterCancel"></a></div>
  <div class="lastSaveDate"><?php echo $langFile['SORTABLEPAGELIST_headText2']; ?></div>
  <div class="counter"><?php echo $langFile['SORTABLEPAGELIST_headText3']; ?></div>
  <div class="status"><?php echo $langFile['SORTABLEPAGELIST_headText4']; ?></div>
  <div class="functions"><?php echo $langFile['SORTABLEPAGELIST_headText5']; ?></div>
</div>

<form action="<?php echo GeneralFunctions::getCurrentUrl(); ?>" method="post" accept-charset="UTF-8">
<?php

// shows the PAGES in NO CATEGORIES (the page/ folder),
// by adding a empty category to the $categoryConfig array
$nonCategory[0] = array('id' => 0,'localization' => array( 0 => array( 'name' => $langFile['CATEGORIES_TOOLTIP_NONCATEGORY'])));
$allCategories = $nonCategory + $categoryConfig;
// -----------------------------------------------------------------------------------------------------------
// ->> LIST CATEGORIES
foreach($allCategories as $category) {

  // vars
  $categoryName = GeneralFunctions::getLocalized($category['localized'],'name');
  
  // -> LOAD the PAGES FROM the CATEGORY
  $pages = GeneralFunctions::loadPages($category['id'],true);
  //print_r($pages);

  // shows after saving the right category open
  $hidden = (is_array($pages) && !empty($pages) &&                                         // -> slide in the category if EMPTY
             (!isset($_GET['category']) && $category['id'] == 0) ||                        // -> slide non-category in if no category is selected
             ($opendCategory === $category['id'] || $_GET['category'] == $category['id'])) // -> slide out the category if ACTIVE
  ? '' : ' hidden';
  
  // shows the text of the sorting of a CATEGORY
  if(($category['id'] != 0 && $category['sorting'] == 'byPageDate') ||
     ($category['id'] == 0 && $adminConfig['pages']['sorting'] == 'byPageDate'))
    $sorting = '&nbsp;<img src="library/images/icons/sortByDate_small.png" class="listPagesH1Icon toolTip" title="'.$langFile['SORTABLEPAGELIST_TIP_SORTBYPAGEDATE'].'::" alt="icon" width="27" height="23">';
  elseif(($category['id'] != 0 && $category['sorting'] == 'alphabetical') ||
         ($category['id'] == 0 && $adminConfig['pages']['sorting'] == 'alphabetical'))
    $sorting = '&nbsp;<img src="library/images/icons/sortAlphabetical_small.png" class="listPagesH1Icon toolTip" title="'.$langFile['SORTABLEPAGELIST_TIP_SORTALPHABETICAL'].'::" alt="icon" width="27" height="23">';
  else
    $sorting = '';
  
  // show whether the category is public or nonpublic
  if($category['public']) {
    $publicClass = ' public';
    $publicText = $langFile['STATUS_CATEGORY_PUBLIC'];
  } else {
    $publicClass = ' nonpublic';
    $publicText = $langFile['STATUS_CATEGORY_NONPUBLIC'];
  }
  
  // shows ID and different header color if its a CATEGORY
  if($category['id'] != 0) {
    //$categoryId = '<span style="font-size: 12px; font-weight: normal;">(ID <b>'.$category['id'].'</b>)</span>';
    $headerColor = ' class="blue"';
    $headerIcon = 'library/images/icons/categoryIcon_middle.png';
  } else {
    //$categoryId = '<span style="color: #999999; font-size: 12px; font-weight: normal;">(ID <b>'.$category['id'].'</b>)</span>';
    $headerColor = ' class="brown"';
    $headerIcon = 'library/images/icons/pageIcon_middle.png';
  }
  
  // display ANCHOR
  echo '<!-- categoryAnchor'.$category['id'].' is here -->';
  echo '<a id="categoryAnchor'.$category['id'].'" class="anchorTarget"></a>';
  
  // -> CATEGORY HEADLINE
  echo "\n\n".'<div class="block listPages'.$hidden.'">';
  	  // onclick="return false;" and set href to allow open categories olaso without javascript activated //a tag used line-height:30px;??
    echo '<h1'.$headerColor.'><a href="?site=pages&amp;category='.$category['id'].'" onclick="return false;"><span class="toolTip" title="ID '.$category['id'].'::"><img src="'.$headerIcon.'" alt="category icon" width="35" height="35"> '.$categoryName.'</span> '.$sorting.'</a></h1>
          <div class="category">';
      
      // CATEGORY STATUS
      echo '<div class="status">';
      // show category status only if its a category (0 is non-category)
      if($category['id'] != 0)
        echo '<a href="?site='.$_GET['site'].'&amp;status=changeCategoryStatus&amp;public='.$category['public'].'&amp;category='.$category['id'].'#categoryAnchor'.$category['id'].'" class="toolTip'.$publicClass.'" title="'.$publicText.'::'.$langFile['SORTABLEPAGELIST_changeStatus_linkCategory'].'">&nbsp;</a>';
      echo '</div>';
	
      // CATEGORY FUNCTIONS
      echo '<div class="functions">';
      
      // create page
      if(($category['id'] != 0 && $category['createDelete']) ||
         ($category['id'] == 0 && $adminConfig['pages']['createDelete']))
        echo '<a href="?category='.$category['id'].'&amp;page=new" title="'.$langFile['BUTTON_TOOLTIP_CREATEPAGE'].'::" class="createPage toolTip">&nbsp;</a>';
         
  echo '  </div>
        </div>
      <div class="content">';
  
  // -> CHECK if pages are sortable
  $listIsSortableClass = (($category['id'] != 0 && $category['sorting'] == 'manually') ||
                          ($category['id'] == 0 && $adminConfig['pages']['sorting'] == 'manually')) ? ' class="sortablePageList"' : '';
  
  echo '<ul'.$listIsSortableClass.' id="category'.$category['id'].'">';

  // list the pages of the categories
  // ----------------------------------------------------------
  if(is_array($pages) && !empty($pages)) {
  
    // create array for the sort_order start input value
    $sort_order = array();
  
    // zählt die $pages durch
    foreach ($pages as $pageContent) {
    
      $pageStatistics = GeneralFunctions::readPageStatistics($pageContent['id']);

      // vars
      $toolTipPageDate = '';
      $toolTipTags = '';
      $toolTipPageLanguages = '';
      $missingLanguages = '';
      $sort_order[] = $pageContent['sortOrder'];
    
      // show whether the page is public or nonpublic
      if($pageContent['public']) {
        $publicClass = ' public';
        $publicText = $langFile['STATUS_PAGE_PUBLIC'];
      } else {
        $publicClass = ' nonpublic';
        $publicText = $langFile['STATUS_PAGE_NONPUBLIC'];
      }
      
      // shorten the title
      $title = GeneralFunctions::shortenString(strip_tags(GeneralFunctions::getLocalized($pageContent['localized'],'title')),27);
      $visitorCount = GeneralFunctions::shortenString(StatisticFunctions::formatHighNumber($pageStatistics['visitorCount']),12);
      
      // -> show lastSaveDate
      $lastSaveDate = StatisticFunctions::formatDate(StatisticFunctions::dateDayBeforeAfter($pageContent['lastSaveDate'],$langFile)).' '.StatisticFunctions::formatTime($pageContent['lastSaveDate']);
      
      // -> generate pageDate for toolTip
      $toolTipPageDate = showPageDate($pageContent);
      
      // -> generate tags for toolTip
      $localizedTags = GeneralFunctions::getLocalized($pageContent['localized'],'tags');
      if($category['showTags'] && !empty($localizedTags)) {
        $toolTipTags = '[br]';
        $toolTipTags .= '[b]'.$langFile['SORTABLEPAGELIST_TIP_TAGS'].':[/b] '.$localizedTags;
      }

      // -> generate page languages for toolTip
      if(!isset($pageContent['localized'][0])) {
        $toolTipPageLanguages .= '[br][b]'.$langFile['SORTABLEPAGELIST_TIP_LOCALIZATION'].':[/b]';
        foreach ($pageContent['localized'] as $langCode => $values) {
          $toolTipPageLanguages .= ' [br][img src='.getFlag($langCode).' class=flag] '.$languageCodes[$langCode];
        }
        // list not yet existing languages of the page
        foreach ($adminConfig['multiLanguageWebsite']['languages'] as $langCode) {
          if(!isset($pageContent['localized'][$langCode])) {
            $toolTipPageLanguages .= ' [br][img src='.getFlag($langCode).' class=flag] [span class=gray][s]'.$languageCodes[$langCode].'[/s][/span]';
            $missingLanguages .= ' [br][img src='.getFlag($langCode).' class=flag] '.$languageCodes[$langCode];
          }
        }
      }

      // -----------------------  ********  ---------------------- 
      // LIST PAGES
      // id'.$pageContent['id'].' sort'.$pageContent['sortOrder'].' cat: '.$pageContent['category'].' 
      echo '<li id="page'.$pageContent['id'].'">';
      
      // startpage icon before the name
      if($adminConfig['setStartPage'] && $pageContent['id'] == $websiteConfig['startPage']) {
        $activeStartPage = ' startPage';
        $startPageText = $langFile['SORTABLEPAGELIST_functions_startPage_set'].'[br]';
      } else {
        $activeStartPage = '';
        $startPageText = '';
      }
      
      echo '<div class="name">
            <a href="?category='.$category['id'].'&amp;page='.$pageContent['id'].'" class="toolTip'.$activeStartPage.'"
            title="'.str_replace(array('[',']','<','>','"'),array('(',')','(',')','&quot;'),strip_tags(GeneralFunctions::getLocalized($pageContent['localized'],'title'))).'::
            '.$startPageText.'[b]ID:[/b] '.$pageContent['id'].$toolTipPageDate.$toolTipTags.$toolTipPageLanguages.'">
            <b>'.$title.'</b>
            </a></div>';
      echo (!empty($pageContent['lastSaveAuthor']))
        ? '<div class="lastSaveDate toolTip" title="'.$langFile['EDITOR_h1_lastsaveauthor'].' '.$pageContent['lastSaveAuthor'].'::">'.$lastSaveDate.'</div>'
        : '<div class="lastSaveDate">'.$lastSaveDate.'</div>';
      echo '<div class="counter toolTip" title="'.StatisticFunctions::formatHighNumber($pageStatistics['visitorCount']).'">'.$visitorCount.'</div>';
      
      // PAGE and LANGUAGE STATUS
      echo '<div class="status'.$publicClass.'">';
      echo '<a href="?site='.$_GET['site'].'&amp;status=changePageStatus&amp;public='.$pageContent['public'].'&amp;category='.$category['id'].'&amp;page='.$pageContent['id'].'#categoryAnchor'.$category['id'].'" class="toolTip" title="'.$publicText.'::'.$langFile['SORTABLEPAGELIST_changeStatus_linkPage'].'">&nbsp;</a>';
      // show language status (is everything translated)
      if($adminConfig['multiLanguageWebsite']['active'] && !empty($missingLanguages))
        echo '<span class="toolTip missingLanguages" title="'.$langFile['SORTABLEPAGELIST_TOOLTIP_LANGUAGEMISSING'] .'::'.$missingLanguages.'"></span>';
      echo '</div>';

      // PAGE FUCNTIONS
      echo '<div class="functions">';      
 
      // thumbnail upload
      if(($category['id'] == 0 && $adminConfig['pages']['thumbnails']) || $allCategories[$category['id']]['thumbnail'])
        echo '<a href="?site=pageThumbnailUpload&amp;category='.$category['id'].'&amp;page='.$pageContent['id'].'" onclick="openWindowBox(\'library/views/windowBox/pageThumbnailUpload.php?site='.$_GET['site'].'&amp;category='.$category['id'].'&amp;page='.$pageContent['id'].'\',\''.$langFile['BUTTON_THUMBNAIL_UPLOAD'].'\');return false;" title="'.$langFile['BUTTON_TOOLTIP_THUMBNAIL_UPLOAD'].'::" class="pageThumbnailUpload toolTip">&nbsp;</a>';
      
      // thumbnail upload delete
      if((($category['id'] == 0 && $adminConfig['pages']['thumbnails']) || $allCategories[$category['id']]['thumbnail']) && !empty($pageContent['thumbnail']))
        echo '<a href="?site=pageThumbnailDelete&amp;category='.$category['id'].'&amp;page='.$pageContent['id'].'" onclick="openWindowBox(\'library/views/windowBox/pageThumbnailDelete.php?site='.$_GET['site'].'&amp;category='.$category['id'].'&amp;page='.$pageContent['id'].'\',\''.$langFile['BUTTON_THUMBNAIL_DELETE'].'\');return false;" title="'.$langFile['BUTTON_TOOLTIP_THUMBNAIL_DELETE'].'::" class="pageThumbnailDelete toolTip">&nbsp;</a>';
      
      // frontend editing
      echo '<a href="'.$adminConfig['url'].$adminConfig['websitePath'].'?'.$adminConfig['varName']['category'].'='.$category['id'].'&amp;'.$adminConfig['varName']['page'].'='.$pageContent['id'].'" title="'.$langFile['BUTTON_FRONTENDEDITPAGE'].'::" class="frontendEditing toolTip">&nbsp;</a>';
      
      // edit page
      echo '<a href="?category='.$category['id'].'&amp;page='.$pageContent['id'].'" title="'.$langFile['SORTABLEPAGELIST_functions_editPage'].'::" class="editPage toolTip">&nbsp;</a>';
      
      // delete page
      if(($category['id'] == 0 && $adminConfig['pages']['createDelete']) || $allCategories[$category['id']]['createDelete'])
        echo '<a href="?site=deletePage&amp;category='.$category['id'].'&amp;page='.$pageContent['id'].'" onclick="openWindowBox(\'library/views/windowBox/deletePage.php?category='.$category['id'].'&amp;page='.$pageContent['id'].'\',\''.$langFile['BUTTON_DELETEPAGE'].'\');return false;" title="'.$langFile['BUTTON_DELETEPAGE'].'::" class="deletePage toolTip">&nbsp;</a>';

      // startpage
      if($adminConfig['setStartPage']) {
        if($pageContent['id'] == $websiteConfig['startPage']) {
          $activeStartPage = ' active';
          $startPageTitle = $langFile['SORTABLEPAGELIST_functions_startPage_set'];
        } else {
          $activeStartPage = '';
          $startPageTitle = $langFile['SORTABLEPAGELIST_functions_startPage'];
        }        
        echo '<a href="?site='.$_GET['site'].'&amp;status=setStartPage&amp;category='.$category['id'].'&amp;page='.$pageContent['id'].'#categoryAnchor'.$category['id'].'" title="'.$startPageTitle.'::" class="startPage'.$activeStartPage.' toolTip">&nbsp;</a>';
      }
            
      echo '</div>
      </li>'."\n";
      // LIST PAGES END
      // -----------------------   ********  ----------------------      
    } 
   
  } else {
    echo '<li><div class="emptyList">'.$langFile['SORTABLEPAGELIST_categoryEmpty'].'</div></li>';
  }

echo '</ul>
     </div>
     <div class="bottom"></div>
  </div>';

echo "\n".'<!-- transport the sortOrder to the javascript -->
      <input type="hidden" name="reverse" id="reverse'.$category['id'].'" value="'.$allCategories[$category['id']]['sortReverse'].'"> <!-- reverse order yes/no -->
      <input type="hidden" name="sort_order" id="sort_order'.$category['id'].'" value="'.@implode($sort_order,'|').'"> <!-- the new page order -->';
}

unset($pageContent);

?>
</form>
</div>