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
// sidebar.loader.php version 0.7


// SWITCH the &_GET['site'] var
switch($_GET['site']) {

  // ***** dashboard sideBar -------------------------------------------------- *********
  case 'dashboard':
    break;

  // ***** pages sideBar -------------------------------------------------- *********
  case 'pages':
      echo '<div id="messageBox_input" class="box">';
        echo '<img src="library/images/icons/hintIcon.png" class="hintIcon" alt="icon" style="width: 65px; height: 65px">'.$langFile['SORTABLEPAGELIST_info'];
        // -> the javascript request of the sortable gets its error messages from this input
        echo '<input type="hidden" id="sortablePageList_status" value="'.$langFile['SORTABLEPAGELIST_save'].'|'.$langFile['SORTABLEPAGELIST_categoryEmpty'].'">';
      echo '</div>';
    break;

  // ***** statisticSetup sideBar -------------------------------------------- *********
  case 'statisticSetup':
    if($deletedStatistics) {
      echo '<div class="box">';
        echo '<img src="library/images/icons/hintIcon.png" class="hintIcon" width="65" height="65">';
        echo $deletedStatistics;
      echo '</div>';
    }
    break;

  // ***** websiteSetup sideBar -------------------------------------------- *********
  case 'websiteSetup':
    if(is_array($websiteConfig['localized'])) {
      $websiteConfigLanguages = array_keys($websiteConfig['localized']);
      if(is_array($websiteConfigLanguages) && is_array($websiteConfig['multiLanguageWebsite']['languages']))
        $websiteConfigLanguagesDiff = array_diff($websiteConfig['multiLanguageWebsite']['languages'],$websiteConfigLanguages);
      if($websiteConfig['multiLanguageWebsite']['active'] && !empty($websiteConfigLanguagesDiff)) {
        echo '<div class="box">';
          echo '<img src="library/images/icons/missingLanguages.png" class="hintIcon" width="50" height="50">';
          echo '<h1>'.$langFile['SORTABLEPAGELIST_TOOLTIP_LANGUAGEMISSING'].'</h1>';
          echo '<ul class="flags">';
          foreach ($websiteConfig['multiLanguageWebsite']['languages'] as $langCode) {
            if(!isset($websiteConfig['localized'][$langCode])) {
              echo '<li><img src="'.GeneralFunctions::getFlagHref($langCode).'" class="flag"> <a href="'.GeneralFunctions::addParameterToUrl('websiteLanguage',$langCode).'" class="link gray">'.$languageNames[$langCode].'</a></li>';
            }
          }
          echo '</ul>';
        echo '</div>';
      } else {
        $currentVisitorFullDetail = false;
        $currentVisitors = include('library/includes/currentVisitors.include.php');
        if($currentVisitors) {
          echo '<div class="box currentVisitorsSideBar">';
            echo $currentVisitors;
          echo '</div>';
        }
      }
    }
    unset($websiteConfigLanguages,$websiteConfigLanguagesDiff);
    break;

  // ***** pageSetup sideBar -------------------------------------------- *********
  case 'pageSetup':
    $categoryHasMissingLanguages = false;
    if(is_array($websiteConfig['multiLanguageWebsite']['languages'])) {
      foreach ($categoryConfig as $category) {
        if($category['id'] == 0)
          continue;
        $arrayDifferences = array_diff($websiteConfig['multiLanguageWebsite']['languages'],array_keys($category['localized']));
        if(!empty($arrayDifferences)) {
          $categoryHasMissingLanguages = true;
          break;
        }
      }
    }
    if($categoryHasMissingLanguages) {
      echo '<div class="box">';
        echo '<img src="library/images/icons/missingLanguages.png" class="hintIcon" width="50" height="50">';
        echo '<h1>'.$langFile['WARNING_TITLE_UNTITLEDCATEGORIES'].'</h1>';
        echo '<ul class="flags">';
        foreach ($websiteConfig['multiLanguageWebsite']['languages'] as $langCode) {
          foreach ($categoryConfig as $category) {
            if($category['id'] == 0)
              continue;
            if(!isset($category['localized'][$langCode])) {
              $categoryName = GeneralFunctions::getLocalized($category,'name');
              $categoryName = (!empty($categoryName)) ? ' &rArr; '.$categoryName : '';
              echo '<li><img src="'.GeneralFunctions::getFlagHref($langCode).'" class="flag"> '.$languageNames[$langCode].'<a href="'.GeneralFunctions::addParameterToUrl('websiteLanguage',$langCode).'" class="link gray">'.$categoryName.'</a></li>';
            }
          }
        }
        echo '</ul>';
      echo '</div>';
    } else {
      $currentVisitorFullDetail = false;
      $currentVisitors = include('library/includes/currentVisitors.include.php');
      if($currentVisitors) {
        echo '<div class="box">';
          echo $currentVisitors;
        echo '</div>';
      }
    }
    break;

  // ***** DEFAULT --------------------------------------------------------- *********
  default:
    $currentVisitorFullDetail = false;
    $currentVisitors = include('library/includes/currentVisitors.include.php');
    if($currentVisitors) {
      echo '<div class="box currentVisitorsSideBar">';
        echo $currentVisitors;
      echo '</div>';
    }
    break;

} //switch END

?>