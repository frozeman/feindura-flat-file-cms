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
      echo '<div id="rightSidebarMessageBox">';
        echo '<div id="messageBox_input" class="content">';
        echo '<img src="library/images/icons/hintIcon.png" class="hintIcon" width="65" height="65" />'.$langFile['SORTABLEPAGELIST_info'];
        // -> the javascript request of the sortable gets its error messages from this input
        echo '<input type="hidden" id="sortablePageList_status" value="'.$langFile['SORTABLEPAGELIST_save'].'|'.$langFile['SORTABLEPAGELIST_categoryEmpty'].'" />';
        echo '</div>';
      echo '<div class="bottom"></div></div>';
    break;
    
  // ***** statisticSetup sideBar -------------------------------------------- *********
  case 'statisticSetup':    
    if($deletedStatistics) {
      echo '<div id="rightSidebarMessageBox">';
        echo '<div class="content">';
        echo '<img src="library/images/icons/hintIcon.png" class="hintIcon" width="65" height="65" />';
        echo $deletedStatistics;
        echo '</div>';
      echo '<div class="bottom"></div></div>';
    }
    break;

  // ***** websiteSetup sideBar -------------------------------------------- *********
  case 'websiteSetup':
    if($adminConfig['multiLanguageWebsite']['languages'] != array_keys($websiteConfig['localization'])) {
      echo '<div id="rightSidebarMessageBox">';
        echo '<div class="content">';
        echo '<img src="library/images/icons/missingLanguages.png" class="hintIcon" width="50" height="50" />';
        echo '<h1>'.$langFile['SORTABLEPAGELIST_TOOLTIP_LANGUAGEMISSING'].'</h1>';
        echo '<ul class="flags">';
        foreach ($adminConfig['multiLanguageWebsite']['languages'] as $langCode) {
          if(!isset($websiteConfig['localization'][$langCode])) {
            echo '<li><img src="'.getFlag($langCode).'" class="flag"> <a href="'.GeneralFunctions::addParameterToUrl('websiteLanguage',$langCode).'" class="standardLink gray">'.$languageCodes[$langCode].'</a></li>';
          }
        }
        echo '</ul>';
        echo '</div>';
      echo '<div class="bottom"></div></div>';
    }
    break;

  // ***** pageSetup sideBar -------------------------------------------- *********
  case 'pageSetup':
    $categoryHasMissingLanguages = false;
    foreach ($categoryConfig as $category) {
      if($adminConfig['multiLanguageWebsite']['languages'] != array_keys($category['localization']))
        $categoryHasMissingLanguages = true;
    }
    if($categoryHasMissingLanguages) {
      echo '<div id="rightSidebarMessageBox">';
        echo '<div class="content">';
        echo '<img src="library/images/icons/missingLanguages.png" class="hintIcon" width="50" height="50" />';
        echo '<h1>'.$langFile['SORTABLEPAGELIST_TOOLTIP_LANGUAGEMISSING'].'</h1>';
        echo '<ul class="flags">';
        foreach ($categoryConfig as $category) {
          foreach ($adminConfig['multiLanguageWebsite']['languages'] as $langCode) {
            if(!isset($category['localization'][$langCode])) {
              $categoryName = GeneralFunctions::getLocalized($category['localization'],'name');
              $categoryName = (!empty($categoryName)) ? ' &rArr; '.$categoryName : '';
              echo '<li><img src="'.getFlag($langCode).'" class="flag"> <a href="'.GeneralFunctions::addParameterToUrl('websiteLanguage',$langCode).'" class="standardLink gray">'.$languageCodes[$langCode].'</a>'.$categoryName.'</li>';
            }
          }
        }
        echo '</ul>';
        echo '</div>';
      echo '<div class="bottom"></div></div>';
    }
    break; 
    
  // ***** DEFAULT --------------------------------------------------------- *********
  default:
    $currentVisitorFullDetail = false;
    $currentVisitors = include('library/includes/currentVisitors.include.php');
    if($currentVisitors) {
        echo '<div id="rightSidebarMessageBox">';
        echo '<div class="content">';
        echo $currentVisitors;
        echo '</div>';
        echo '<div class="bottom"></div></div>';
    }
    break;
    
} //switch END

?>