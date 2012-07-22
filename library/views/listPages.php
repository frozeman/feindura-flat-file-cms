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
<div class="block listPages" id="listPagesBlock">
<h1><?php echo $langFile['SORTABLEPAGELIST_h1']; ?></h1>

<div class="listPagesHead">
  <div class="row">
    <div class="span4 left name"><div><input type="text" value="" id="listPagesFilter" placeholder="<?php echo $langFile['SORTABLEPAGELIST_headText1']; ?>" autofocus="autofocus"><a href="#" id="listPagesFilterCancel">&#215;</a></div></div>
    <div class="span1 center">
      <?php echo $langFile['SORTABLEPAGELIST_headText3']; ?>
    </div>
    <div class="span1">
      <?php echo $langFile['SORTABLEPAGELIST_headText4']; ?>
    </div>
    <div class="span2 right"><?php echo $langFile['SORTABLEPAGELIST_headText5']; ?></div>
  </div>
</div>

<form action="<?php echo GeneralFunctions::getCurrentUrl(); ?>" method="post" accept-charset="UTF-8">
<?php

// vars
// for checking if is parent pages
$allPages = GeneralFunctions::loadPages(true);

// used to add the sub category arrows
$pagesWithSubCategories  = array();


// -----------------------------------------------------------------------------------------------------------
// ->> LIST CATEGORIES
foreach($categoryConfig as $category) {

  // vars
  $categoryTitle = '';
  $categoryName = GeneralFunctions::getLocalized($category,'name');

  // -> LOAD PAGES of this CATEGORY
  $pages = GeneralFunctions::loadPages($category['id']);

  // -> GET PAGES WHICH HAVE THIS CATEGORY AS SUBCATEGORY
  if($category['id'] != 0) {
    $parentPages = array();
    foreach ($allPages as $pageContent) {
      if($pageContent['subCategory'] == $category['id'] && $categoryConfig[$pageContent['category']]['showSubCategory'])
        $parentPages[] = $pageContent;
    }
    unset($pageContent);
  }

  // shows after saving the right category open
  $hidden = (is_array($pages) && !empty($pages) &&                                         // -> slide in the category if EMPTY
             (!isset($_GET['category']) && $category['id'] == 0) ||                        // -> slide non-category in if no category is selected
             ($opendCategory === $category['id'] || $_GET['category'] == $category['id'])) // -> slide out the category if ACTIVE
  ? '' : ' hidden';

  // shows the text of the sorting of a CATEGORY
  if($category['sorting'] == 'byPageDate')
    $sorting = '&nbsp;<img src="library/images/icons/sortByDate_small.png" class="toolTipTop" title="'.$langFile['SORTABLEPAGELIST_TIP_SORTBYPAGEDATE'].'::" alt="icon" width="27" height="23">';
  elseif($category['sorting'] == 'alphabetical')
    $sorting = '&nbsp;<img src="library/images/icons/sortAlphabetical_small.png" class="toolTipTop" title="'.$langFile['SORTABLEPAGELIST_TIP_SORTALPHABETICAL'].'::" alt="icon" width="27" height="23">';
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
    $headerColor = ' class="blue"';
    $categoryIcon = (!empty($parentPages))
      ? 'library/images/icons/categoryIcon_subCategory_middle.png'
      : 'library/images/icons/categoryIcon_middle.png';
  } else {
    $headerColor = ' class="brown"';
    $categoryIcon = 'library/images/icons/pageIcon_middle.png';
  }

  // show category id
  $categoryTitle .= (GeneralFunctions::isAdmin())
    ? '[strong]ID:[/strong] '.$category['id']
    : '';

  // show pages which have this category as subcategory
  if(!empty($parentPages)) {
    $categoryTitle .= (count($parentPages) ==  1)
      ? '[br][strong]'.$langFile['SORTABLEPAGELIST_TIP_SUBCATEGORYOFPAGES_SINGULAR'].'[/strong][br]'
      : '[br][strong]'.$langFile['SORTABLEPAGELIST_TIP_SUBCATEGORYOFPAGES_PLURAL'].'[/strong][br]';
    foreach($parentPages as $parentPage) {
      if($categoryConfig[$parentPage['category']]['showSubCategory']) {
        $parentPageCategory = ($parentPage['category'] != 0 ) ? GeneralFunctions::getLocalized($categoryConfig[$pageOfSubCategory['category']],'name').' &rArr; ' : '';
        $categoryTitle .= '[img src=library/images/icons/pageIcon_subCategory_small.png style=position:relative;margin-bottom:-10px;] '.$parentPageCategory.GeneralFunctions::getLocalized($parentPage,'title').'[br]';
      }
    }
  }

  // display ANCHOR
  echo '<!-- categoryAnchor'.$category['id'].' is here -->';
  echo '<a id="categoryAnchor'.$category['id'].'" class="anchorTarget"></a>';

  // -> CATEGORY HEADLINE
  echo "\n\n".'<div class="block open listPagesBlock'.$hidden.'">';
  	  // onclick="return false;" and set href to allow open categories olaso without javascript activated //a tag used line-height:30px;??
    echo '<h1'.$headerColor.'><a href="?site=pages&amp;category='.$category['id'].'" onclick="return false;"><span class="toolTipLeft" title="'.$categoryName.'::'.$categoryClass.$categoryTitle.'"><img src="'.$categoryIcon.'" class="blockH1Icon" alt="category icon" width="35" height="35"> '.$categoryName.'</span> '.$sorting.'</a></h1>
          <div class="categoryHeader">';

      // CATEGORY STATUS
      // show category status only if its a category (0 is non-category)
      if($category['id'] != 0)
        echo '<a href="?site='.$_GET['site'].'&amp;status=changeCategoryStatus&amp;public='.$category['public'].'&amp;category='.$category['id'].'#categoryAnchor'.$category['id'].'" class="toolTipTop status'.$publicClass.'" title="'.$publicText.'::'.$langFile['SORTABLEPAGELIST_changeStatus_linkCategory'].'">&nbsp;</a>';

      // CATEGORY FUNCTIONS
      echo '<div class="functions right">';

      // create page
      if($category['createDelete'])
        echo '<a href="?category='.$category['id'].'&amp;page=new" title="'.$langFile['BUTTON_TOOLTIP_CREATEPAGE'].'::" class="createPage toolTipLeft">&nbsp;</a>';

  echo '  </div>
        </div>
      <div class="content">';

  // -> CHECK if pages are sortable
  $listIsSortableClass = ($category['sorting'] == 'manually') ? ' sortablePageList' : '';

  echo '<ul class="unstyled'.$listIsSortableClass.'" id="category'.$category['id'].'">';

  // list the pages of the category
  // ----------------------------------------------------------
  if(is_array($pages) && !empty($pages)) {

    // create array for the sort_order start input value
    $sort_order = array();

    // zählt die $pages durch
    foreach ($pages as $pageContent) {
      if(!isset($pageContent['id']))
        continue;

      $pageStatistics = StatisticFunctions::readPageStatistics($pageContent['id']);

      // vars
      $pageTitle_pageDate      = '';
      $pageTitle_tags          = '';
      $pageTitle_pageLanguages = '';
      $missingLanguages        = '';
      $startPageIcon           = '';
      $pageTitle_startPageText = '';
      $sort_order[]            = $pageContent['sortOrder'];

      // add pageContent to this array to create later the arrows to the sub categories
      if(is_numeric($pageContent['subCategory']))
        $pagesWithSubCategories[] = $pageContent;

      // show whether the page is public or nonpublic
      if($pageContent['public']) {
        $publicClass = ' public';
        $publicText  = $langFile['STATUS_PAGE_PUBLIC'];
      } else {
        $publicClass = ' nonpublic';
        $publicText  = $langFile['STATUS_PAGE_NONPUBLIC'];
      }

      // shorten the title
      $title = GeneralFunctions::shortenString(strip_tags(GeneralFunctions::getLocalized($pageContent,'title')),25);
      $visitorCount = GeneralFunctions::shortenString(formatHighNumber($pageStatistics['visitorCount']),12);

      // -> show lastSaveDate
      $lastSaveDate = GeneralFunctions::formatDate(GeneralFunctions::dateDayBeforeAfter($pageContent['lastSaveDate'],$langFile)).' '.formatTime($pageContent['lastSaveDate']);
      $lastSaveDate = ($pageContent['lastSaveAuthor'])
          ? '[strong]'.$langFile['SORTABLEPAGELIST_TIP_LASTEDIT'].'[/strong][br]'.$lastSaveDate.' ('.$userConfig[$pageContent['lastSaveAuthor']]['username'].')[br]'
          : '[strong]'.$langFile['SORTABLEPAGELIST_TIP_LASTEDIT'].'[/strong] '.$lastSaveDate.'[br]';

      // -> show page ID
      $pageTitle_Id = (GeneralFunctions::isAdmin())
        ? '[strong]ID[/strong] '.$pageContent['id'].'[br]'
        : '';

      // -> show subcategory in toolTip
      $pageTitle_subCategory = ($pageContent['subCategory'] && $categoryConfig[$pageContent['category']]['showSubCategory'])
        ? '[strong]'.$langFile['EDITOR_TEXT_SUBCATEGORY'].'[/strong][br][img src=library/images/icons/categoryIcon_subCategory_small.png style=position:relative;margin-bottom:-10px;] '.GeneralFunctions::getLocalized($categoryConfig[$pageContent['subCategory']],'name').'[br]'
        : '';

      // -> generate pageDate for toolTip
      if($pageTitle_pageDate = showPageDate($pageContent))
        $pageTitle_pageDate .= '[br]';

      // -> generate tags for toolTip
      $localizedTags = GeneralFunctions::getLocalized($pageContent,'tags');
      if(!empty($localizedTags) && $categoryConfig[$pageContent['category']]['showTags']) {
        $pageTitle_tags = '[strong]'.$langFile['SORTABLEPAGELIST_TIP_TAGS'].'[/strong] '.$localizedTags.'[br]';
      }

      // -> generate page languages for toolTip
      if(!isset($pageContent['localized'][0])) {
        $pageTitle_pageLanguages .= '[strong]'.$langFile['SORTABLEPAGELIST_TIP_LOCALIZATION'].'[/strong][br]';
        if(is_array($pageContent['localized'][0])) {
          foreach ($pageContent['localized'] as $langCode => $values) {
            $pageTitle_pageLanguages .= '[img src='.GeneralFunctions::getFlagHref($langCode).' class=flag] '.$languageNames[$langCode].'[br]';
          }
        }
        // list not yet existing languages of the page
        if(is_array($websiteConfig['multiLanguageWebsite']['languages'])) {
          foreach($websiteConfig['multiLanguageWebsite']['languages'] as $langCode) {
            if(!isset($pageContent['localized'][$langCode])) {
              $pageTitle_pageLanguages .= '[img src='.GeneralFunctions::getFlagHref($langCode).' class=flag] [span class=gray][s]'.$languageNames[$langCode].'[/s][/span][br]';
              $missingLanguages .= '[img src='.GeneralFunctions::getFlagHref($langCode).' class=flag] '.$languageNames[$langCode].'[br]';
            }
          }
        }
      }

      $hasSubCategoryClass = (is_numeric($pageContent['subCategory'])) ? ' class="hasSubCategory"' : '';

      // -----------------------  ********  ----------------------
      // LIST PAGES
      // id'.$pageContent['id'].' sort'.$pageContent['sortOrder'].' cat: '.$pageContent['category'].'
      echo '<li id="page'.$pageContent['id'].'"'.$hasSubCategoryClass.' data-pageId="'.$pageContent['id'].'" data-categoryId="'.$pageContent['category'].'">';

      // -> display other icon for pages
      $subCategoryIcon = ($pageContent['subCategory'] && $categoryConfig[$pageContent['category']]['showSubCategory'])
        ? ' hasSubCategory'
        : '';

      // -> startpage icon before the name
      if($websiteConfig['setStartPage'] && $pageContent['id'] == $websiteConfig['startPage']) {
        $startPageIcon = ' isStartPage';
        $pageTitle_startPageText = $langFile['SORTABLEPAGELIST_functions_startPage_set'].'[br]';
      }

      echo '<div class="row">';

        echo '<div class="span4 name left">
                <a href="?category='.$category['id'].'&amp;page='.$pageContent['id'].'" class="toolTipLeft'.$subCategoryIcon.$startPageIcon.'"
                title="'.str_replace(array('[',']','<','>','"'),array('(',')','(',')','&quot;'),strip_tags(GeneralFunctions::getLocalized($pageContent,'title'))).'::
                '.trim(' '.$pageTitle_startPageText.$pageTitle_Id.$lastSaveDate.$pageTitle_subCategory.$pageTitle_pageDate.$pageTitle_tags.$pageTitle_pageLanguages,'[br]').'">
                  <strong>'.$title.'</strong>
                </a>
              </div>';
        echo '<div class="span1 center">';
          // VISITOR COUNT
          echo '<span class="toolTipTop" title="'.formatHighNumber($pageStatistics['visitorCount']).'">'.$visitorCount.'</span>';
        echo '</div>';
        echo '<div class="span1">';
          // PAGE and LANGUAGE STATUS
          echo ' <a href="?site='.$_GET['site'].'&amp;status=changePageStatus&amp;public='.$pageContent['public'].'&amp;category='.$category['id'].'&amp;page='.$pageContent['id'].'#categoryAnchor'.$category['id'].'" class="toolTipTop status'.$publicClass.'" title="'.$publicText.'::'.$langFile['SORTABLEPAGELIST_changeStatus_linkPage'].'"></a>';
          // show language status (is everything translated)
          if($websiteConfig['multiLanguageWebsite']['active'] && !empty($missingLanguages))
            echo ' <span class="toolTipTop missingLanguages" title="'.$langFile['SORTABLEPAGELIST_TOOLTIP_LANGUAGEMISSING'] .'::'.$missingLanguages.'"></span>';
        echo '</div>';

        // PAGE FUNCTIONS
        echo '<div class="span2 functions right">';

          // thumbnail upload
          if($category['thumbnails'])
            echo '<a href="?site=uploadPageThumbnail&amp;category='.$category['id'].'&amp;page='.$pageContent['id'].'" onclick="openWindowBox(\'library/views/windowBox/uploadPageThumbnail.php?site='.$_GET['site'].'&amp;category='.$category['id'].'&amp;page='.$pageContent['id'].'\',\''.$langFile['BUTTON_THUMBNAIL_UPLOAD'].'\');return false;" title="'.$langFile['BUTTON_TOOLTIP_THUMBNAIL_UPLOAD'].'::" class="uploadPageThumbnail toolTipTop"></a>';

          // thumbnail upload delete
          if($category['thumbnails'] && !empty($pageContent['thumbnail']))
            echo '<a href="?site=deletePageThumbnail&amp;category='.$category['id'].'&amp;page='.$pageContent['id'].'" onclick="openWindowBox(\'library/views/windowBox/deletePageThumbnail.php?site='.$_GET['site'].'&amp;category='.$category['id'].'&amp;page='.$pageContent['id'].'\',\''.$langFile['BUTTON_THUMBNAIL_DELETE'].'\');return false;" title="'.$langFile['BUTTON_TOOLTIP_THUMBNAIL_DELETE'].'::" class="deletePageThumbnail toolTipTop"></a>';

          // frontend editing
          echo '<a href="'.$adminConfig['url'].GeneralFunctions::Path2URI($adminConfig['websitePath']).'?'.$adminConfig['varName']['category'].'='.$category['id'].'&amp;'.$adminConfig['varName']['page'].'='.$pageContent['id'].'" title="'.$langFile['BUTTON_FRONTENDEDITPAGE'].'::" class="frontendEditing toolTipTop"></a>';

          // edit page
          echo '<a href="?category='.$category['id'].'&amp;page='.$pageContent['id'].'" title="'.$langFile['SORTABLEPAGELIST_functions_editPage'].'::" class="editPage toolTipTop"></a>';

          // delete page
          if($category['createDelete'])
            echo '<a href="?site=deletePage&amp;category='.$category['id'].'&amp;page='.$pageContent['id'].'" onclick="openWindowBox(\'library/views/windowBox/deletePage.php?category='.$category['id'].'&amp;page='.$pageContent['id'].'\',\''.$langFile['BUTTON_DELETEPAGE'].'\');return false;" title="'.$langFile['BUTTON_DELETEPAGE'].'::" class="deletePage toolTipTop"></a>';

          // startpage
          if($websiteConfig['setStartPage']) {
            if($pageContent['id'] == $websiteConfig['startPage']) {
              $activeStartPage = ' active';
              $startPageTitle = $langFile['SORTABLEPAGELIST_functions_startPage_set'];
            } else {
              $activeStartPage = '';
              $startPageTitle = $langFile['SORTABLEPAGELIST_functions_startPage'];
            }
            echo '<a href="?site='.$_GET['site'].'&amp;status=setStartPage&amp;refresh='.uniqid().'&amp;category='.$category['id'].'&amp;page='.$pageContent['id'].'#categoryAnchor'.$category['id'].'" title="'.$startPageTitle.'::" class="startPage'.$activeStartPage.' toolTipTop"></a>';
          }

        echo '</div>';
      echo '</div>';
      echo '</li>'."\n";

      unset($pageContent);
      // LIST PAGES END
      // -----------------------   ********  ----------------------
    }

  } else {
    echo '<li><div class="emptyList">'.$langFile['SORTABLEPAGELIST_categoryEmpty'].'</div></li>';
  }

  echo '</ul>';
  echo '</div>';

  echo '</div>';

  echo "\n".'<!-- transport the sortOrder to the javascript -->
        <!-- reverse order yes/no -->
        <input type="hidden" name="reverse" id="reverse'.$category['id'].'" value="'.$category['sortReverse'].'">
        <!-- the new page order -->
        <input type="hidden" name="sort_order" id="sort_order'.$category['id'].'" value="'.@implode($sort_order,'|').'">';

}


// arrows to the sub categories
foreach ($pagesWithSubCategories as $pageWithSubCategory) {
  $categoryClass = ($pageWithSubCategory['category'] != 0) ? ' categories' : ' nonCategory';
  echo '<div class="subCategoryArrowLine'.$categoryClass.'" data-parentPage="page'.$pageWithSubCategory['id'].'" data-category="category'.$pageWithSubCategory['category'].'" data-subCategory="category'.$pageWithSubCategory['subCategory'].'">
  <div class="subCategoryInLineArrow"></div>
  <div class="subCategoryArrowStart"></div>
  <div class="subCategoryArrowEnd"></div>
  </div>';
}
unset($pagesWithSubCategories);

?>
</form>
</div>