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
// sidebar.loader.php version 0.6

if(isset($_GET['site']) && !empty($_GET['site']) && $_GET['site'] != 'home')
  echo '<div id="rightSidebarMessageBox">';

// SWITCH the &_GET['site'] var
switch($_GET['site']) {
  
  // ***** home sideBar -------------------------------------------------- *********
  case 'home':
    break;
  
  // ***** pages sideBar -------------------------------------------------- *********
  case 'pages':
      echo '<div id="messageBox_input" class="content">';
      echo '<img src="library/images/icons/hintIcon.png" class="hintIcon" />'.$langFile['sortablePageList_info'];
      // -> the javascript request of the sortable gets its error messages from this input
      echo '<input type="hidden" id="sortablePageList_status" value="'.$langFile['sortablePageList_save'].'|'.$langFile['sortablePageList_categoryEmpty'].'" />';
      echo '</div>';
    break;
    
  // ***** adminSetup sideBar -------------------------------------------- *********
  case 'statisticSetup':    
    if($deletedStatistics) {
      echo '<div class="content">';
      echo '<img src="library/images/icons/hintIcon.png" class="hintIcon" />';
      echo $deletedStatistics;
      echo '</div>';
    }
    break;
    
  // ***** DEFAULT --------------------------------------------------------- *********
  default:
    $currentVisitorFullDetail = false;
    $currentVisitors = include('library/includes/currentVisitors.include.php');
    if($currentVisitors) {
      echo '<div id="currentVisitorsSideBar" class="content">';
      echo '<h1>'.$langFile['STATISTICS_TEXT_CURRENTVISITORS'].'</h1>';
      echo $currentVisitors;
      echo '</div>';
    }
    break;
    
} //switch END

if(isset($_GET['site']) && !empty($_GET['site']) && $_GET['site'] != 'home')
  echo '<div class="bottom"></div></div>';

?>