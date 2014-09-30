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

* sidebar.loader.php version 0.7
*
* The leftSideBar shows always websiteand cms relevant information. like users, visitors, last activity etc.
*/

/**
 * Includes the login.include.php and backend.include.php and filter the basic data
 */
require_once(dirname(__FILE__)."/includes/secure.include.php");

echo ' '; // hack for safari, otherwise it throws an error that he could not find htmlentities like &ouml;

// vars
$tabIndex = 40;
$showCurrentVisitors = true;


// -----------------------------------------------------------------------------------
// if page ID is given, it LOAD THE EDITOR
// or if $_GET['site'] == 'pages'
if((!empty($_GET['page']) && empty($_GET['site']))) { // || $_GET['site'] == 'pages'

  // dont show the current visitors when sidebarmenu
  $showCurrentVisitors = false;

  if(!$_GET['loadSideBarMenu'])
    echo '<div id="sidebarMenu" class="staticScroller" data-offset="-2">';

    // ----  show QUICKMENU for the NONE-CATEGORY PAGES
    // slide the categories menu IN, when a category is open
    if(empty($_GET['category']))
      $hidden = '';
    else
      $hidden = ' hidden';

    // SHOW only if the USER has PERMISSION for that CATEGORY (or any of the pages in it)
    if(showCategory(0)) {

      echo '<div class="sidebarMenu brown'.$hidden.'">
      <div class="top"><img src="library/images/icons/pageIcon_middle.png" class="icons" alt="icon" width="35" height="35"><span>'.$langFile['CATEGORIES_TEXT_NONCATEGORY'].'</span><a href="#" class="toolTipLeft" title="'.$langFile['CATEGORIES_TOOLTIP_NONCATEGORY'].'::">&nbsp;</a></div>
      <div class="menuWrapper">
        <menu class="vertical nonCategory">';

        if(is_array($pagesMetaData)) {
          $filteredPagesMetaData = GeneralFunctions::getPagesMetaDataOfCategory(0);
          foreach($filteredPagesMetaData as $pageMetaData) {
            if(!GeneralFunctions::hasPermission('editablePages',$pageMetaData['id']))
              continue;

            // -> show page ID
            $showPageId = (GeneralFunctions::isAdmin())
              ? ' class="toolTipLeft noMark" title="'.strip_tags(GeneralFunctions::getLocalized($pageMetaData,'title')).'::ID '.$pageMetaData['id'].'"'
              : ' class="toolTipLeft noMark" title="'.strip_tags(GeneralFunctions::getLocalized($pageMetaData,'title')).'"';

            if($_GET['page'] == $pageMetaData['id'])
              $pageSelected = ' class="active"';
            else
              $pageSelected = '';

            echo '<li'.$showPageId.'><a href="?category=0&amp;page='.$pageMetaData['id'].'" tabindex="'.$tabIndex++.'"'.$pageSelected.'>'.strip_tags(GeneralFunctions::getLocalized($pageMetaData,'title')).'<span style="display:none;" class="toolTipLeft noMark notSavedSignPage'.$pageMetaData['id'].'" title="'.$langFile['EDITOR_pageNotSaved'].'::"> *</span></a></li>';
          }
          unset($filteredPagesMetaData);
        } else {
          echo '<li><a href="#" onclick="return false;"><span>'.$langFile['SORTABLEPAGELIST_categoryEmpty'].'</span></a></li>';
        }

      echo '</menu>
        </div>
        <div class="bottom"><a href="#">&nbsp;</a></div>
      </div>';
    }

    // ----  show QUICKMENU for the CATEGORIES
    if(!empty($categoryConfig)) {

      // vars
      $showCategories = false;
      foreach ($categoryConfig as $category) {
        if(showCategory($category['id']) && $category['id'] !== 0)
          $showCategories[] = $category;
      }

      if($showCategories !== false) {

        // spacer
        echo '<div class="spacer"></div>';

        // slide the categories menu OUT, when a category is open
        if($_GET['site'] != 'pages' && $_GET['category'] == 0) //
          $hidden = ' hidden';
        else $hidden = '';

        echo '<div class="sidebarMenu blue'.$hidden.'">
        <div class="top"><img src="library/images/icons/categoryIcon_middle.png" class="icons" alt="icon" width="35" height="35"><span>'.$langFile['SIDEBARMENU_TITLE_CATEGORIES'].'</span><a href="#">&nbsp;</a></div>
        <div class="menuWrapper">
          <menu class="vertical categories">';

          foreach($showCategories as $category) {

            // overjump the non-category
            if($category['id'] == 0) continue;

            // -> show category ID
            $categoryId = (GeneralFunctions::isAdmin())
              ? ' class="toolTipLeft noMark" title="ID '.$category['id'].'"'
              : '';

            if($_GET['category'] == $category['id'])
                $categorySelected = ' class="active"';
              else
                $categorySelected = '';
            echo '<li><a href="?site=pages&amp;category='.$category['id'].'" tabindex="'.$tabIndex++.'" onclick="loadSideBarMenu(\''.$_GET['site'].'\',\''.$_GET['page'].'\',\''.$category['id'].'\');return false;"'.$categorySelected.'><span'.$categoryId.'>'.GeneralFunctions::getLocalized($category,'name').'</span></a></li>';
          }
        echo '</menu>
          </div>
          <div class="bottom"><a href="#" onclick="return false;">&nbsp;</a></div>
        </div>';
      }
    }

    // ----  show QUICKMENU for the CATEGORY PAGES
    // page has a subcategory, show it
    $loadCategory = (!empty($pageContent['subCategory'])) ? $pageContent['subCategory'] : $_GET['category'];

    if(!empty($loadCategory) && showCategory($loadCategory)) {

      // spacer
      echo '<div class="spacer arrow"></div>';

      echo '<div class="sidebarMenu gray">
      <div class="top"><img src="library/images/icons/pageIcon_middle.png" class="icons" alt="icon" width="35" height="35"><span>'.GeneralFunctions::getLocalized($categoryConfig[$loadCategory],'name').'</span><a href="#" class="toolTipLeft" title="'.$langFile['SIDEBARMENU_TITLE_PAGES'].' '.GeneralFunctions::getLocalized($categoryConfig[$loadCategory],'name').'::">&nbsp;</a></div>
      <div class="menuWrapper">
        <menu class="vertical category">';

        if(is_array($pageMetaData)) {

          $filteredPagesMetaData = GeneralFunctions::getPagesMetaDataOfCategory($loadCategory);
          foreach($filteredPagesMetaData as $pageMetaData) {
            if(!GeneralFunctions::hasPermission('editablePages',$pageMetaData['id']))
              continue;

            // -> show page ID
            $showPageId = (GeneralFunctions::isAdmin())
              ? ' class="toolTipLeft noMark" title="'.strip_tags(GeneralFunctions::getLocalized($pageMetaData,'title')).'::ID '.$pageMetaData['id'].'"'
              : ' class="toolTipLeft noMark" title="'.strip_tags(GeneralFunctions::getLocalized($pageMetaData,'title')).'"';

            if($_GET['page'] == $pageMetaData['id'])
              $pageSelected = ' class="active"';
            else
              $pageSelected = '';

            echo '<li'.$showPageId.'><a href="?category='.$pageMetaData['category'].'&amp;page='.$pageMetaData['id'].'" tabindex="'.$tabIndex++.'"'.$pageSelected.'>'.GeneralFunctions::getLocalized($pageMetaData,'title').'<span style="display:none;" class="toolTipLeft noMark notSavedSignPage'.$pageMetaData['id'].'" title="'.$langFile['EDITOR_pageNotSaved'].'::"> *</span></a></li>';
          }
          unset($filteredPagesMetaData);
        } else {
          echo '<li><a href="#" onclick="return false;"><span>'.$langFile['SORTABLEPAGELIST_categoryEmpty'].'</span></a></li>';
        }
      echo '</menu>
        </div>
        <div class="bottom"><a href="#" onclick="return false;">&nbsp;</a></div>
      </div>';
    }

    // sidebarSelection end
    if(!$_GET['loadSideBarMenu'])
      echo '</div>';
// -----------------------------------------------------------------------------------
// SWITCH SITE
} else {

  // SWITCH the &_GET['site'] var
  switch($_GET['site']) {
    // ***** LAST ACTIVITY -------------------------------------------- **********
    case 'dashboard': case 'pages': case '':

      // dont show the current visitors when user menu
      if($_GET['site'] != 'pages')
        $showCurrentVisitors = false;

      // -> SHOW TASK LOG
      echo '<div class="box">';
      echo '<h1><img src="library/images/icons/activityLogIcon.png" alt="icon" style="position:relative; top:-2px;margin-right: 4px;"> '.$langFile['DASHBOARD_TITLE_ACTIVITY'].'</h1>';

      if(file_exists(dirname(__FILE__).'/../statistics/activity.statistic.log') &&
         $logContent = file(dirname(__FILE__).'/../statistics/activity.statistic.log')) {

         // echo '<div id="sidbarTaskLogScrollUp" class="scrollUpDown" style="background: url(library/images/bg/sidebarScrollUp.png) no-repeat; top: 0px;"></div>';
         echo '<div id="sideBarActivityLog">';

              // ->> LIST the tasks
              include(dirname(__FILE__).'/includes/activityLog.include.php');

         echo '</div>';
         // echo '<div id="sidbarTaskLogScrollDown" class="scrollUpDown" style="background: url(\'library/images/bg/sidebarScrollDown.png\') no-repeat; margin-top:-30px;"></div>';
      // no log
      } else
        echo $langFile['DASHBOARD_TEXT_ACTIVITY_NONE'];

      echo '</div>';


      break;
    // ***** ADMIN SETUP sideBar -------------------------------------------- **********
    case 'adminSetup':
      if(!GeneralFunctions::isAdmin()) break;

      echo '<div class="box">';

      // FEINDURA INFO
      echo '<h1>'.$langFile['ADMINSETUP_TEXT_VERSION'].'</h1>';
      echo '<p>'.VERSION.' - Build '.BUILD.'</p>';
      echo '<a href="README.md" class="link">README</a><br>';
      echo '<a href="CHANGELOG" class="link">CHANGELOG</a><br>';
      echo '<a href="LICENSE" class="link">LICENSE</a>';

      echo '<h2>'.$langFile['ADMINSETUP_TEXT_PHPVERSION'].'</h2>
      <p class="center">'.PHP_VERSION.'</p>';

      echo '<h2>'.$langFile['ADMINSETUP_TITLE_DOCUMENTROOT'].'</h2>';
      echo '<p class="toolTipLeft" title="'.$langFile['ADMINSETUP_TITLE_DOCUMENTROOT'].'::'.DOCUMENTROOT.'">'.DOCUMENTROOT.'</p>
          </div>';

      break;

    // ***** PAGESETUP -------------------------------------------- **********
    case 'pageSetup':
      if(!GeneralFunctions::isAdmin()) break;

      // dont show the current visitors when category menu
      $showCurrentVisitors = false;

      // -> CATEGORY ANCHOR LINKS

      if(!empty($categoryConfig) && is_array($categoryConfig)) {
        echo '<div class="sidebarMenu blue staticScroller" data-offset="-2">
            <div class="top"><img src="library/images/icons/categoryIcon_middle.png" class="icons" alt="icon" width="35" height="35"><span>'.$langFile['SIDEBARMENU_TITLE_CATEGORIES'].'</span><a href="#">&nbsp;</a></div>
            <div class="menuWrapper">
              <menu class="vertical">';

              echo '<li><a href="#top"><i class="icon icon-arrow-up icon-white"></i></a></li>';
              echo '<li><a href="#nonCategoryPages"><span>'.GeneralFunctions::getLocalized($categoryConfig[0],'name').'</span></a></li>';

                foreach($categoryConfig as $category) {

                  // overjump the non-category
                  if($category['id'] == 0) continue;

                  echo '<li><a href="#categoryAnchor'.$category['id'].'" tabindex="'.$tabIndex++.'"><span>'.GeneralFunctions::getLocalized($category,'name').'</span></a></li>';
                }
            echo '</menu>
          </div>
          <div class="bottom"><a href="#" onclick="return false;">&nbsp;</a></div>
        </div>';
      }

      break;
    // ***** USERSETUP -------------------------------------------- **********
    case 'userSetup':
      if(!GeneralFunctions::isAdmin()) break;

      // dont show the current visitors when user menu
      $showCurrentVisitors = false;

      // -> USER ANCHOR LINKS
      if(!empty($userConfig) && is_array($userConfig)) {
        echo '<div class="sidebarMenu gray staticScroller" data-offset="-2">
            <div class="top"><img src="library/images/icons/userIcon_middle.png" class="icons" alt="icon" width="35" height="35"><span>'.$langFile['USERSETUP_userSelection'].'</span><a href="#">&nbsp;</a></div>
            <div class="menuWrapper">
              <menu class="vertical">';

              echo '<li><a href="#top"><i class="icon icon-arrow-up icon-white"></i></a></li>';

                // -> show a anchor link to each user
                foreach($userConfig as $user) {
                  $userIsAdminToolTip = ($user['admin']) ? ' class="toolTipLeft" title="'.$langFile['USERSETUP_admin'].'::"' : '';
                  $userIsAdminHint = ($user['admin']) ? ' *' : '';
                  echo '<li><a href="#userId'.$user['id'].'"'.$userIsAdminToolTip.' tabindex="'.$tabIndex++.'"><span>'.$user['username'].$userIsAdminHint.'</span></a></li>';
                }
            echo '</menu>
          </div>
          <div class="bottom"><a href="#" onclick="return false;">&nbsp;</a></div>
        </div>';
      }

      break;
    // ***** BACKUP sideBar -------------------------------------------- **********
    case 'backup':
      if(!GeneralFunctions::isAdmin()) break;

      echo '<div class="box">';

      // link the backup files
      $backups = GeneralFunctions::readFolder(dirname(__FILE__).'/../backups/');
      if(!empty($backups['files'])) {
        $lastBackups = '<ul class="unstyled backupDownload">';
        usort($backups['files'],'sortFilesByModifiedDate');
        foreach($backups['files'] as $backupFile) {
          $backupTime = filemtime(DOCUMENTROOT.$backupFile);

          $lastBackups .= '<li><a href="'.GeneralFunctions::Path2URI($backupFile).'" class="backup">';
          $lastBackups .= (strpos($backupFile,'restore') === false)
            ? $langFile['BACKUP_TITLE_BACKUP']
            : $langFile['BACKUP_TEXT_RESTORE_BACKUPBEFORERESTORE'];
          $lastBackups .= '<br>'.GeneralFunctions::dateDayBeforeAfter($backupTime).' '.formatTime($backupTime).'</a>';
          $lastBackups .= '<a href="?site=backup&amp;status=deleteBackup&amp;file='.basename($backupFile).'" onclick="openWindowBox(\'library/views/windowBox/deleteBackup.php?status=deleteBackup&amp;file='.basename($backupFile).'\',\''.$langFile['BACKUP_TITLE_BACKUP'].'\');return false;" class="deleteButton toolTipTop" title="'.$langFile['BACKUP_TOOLTIP_DELETE'].'::"></a></li>';
        }
        $lastBackups .= '</ul>';
      } else
        $lastBackups = '<p>'.$langFile['BACKUP_TEXT_NOBACKUP'].'</p>';

      // BACKUP DOWNLOADS
      echo '<h1>'.$langFile['BACKUP_TITLE_LASTBACKUPS'].'</h1>';
      echo $lastBackups;
      echo '</div>';

      break;

    // ***** ADDONS -------------------------------------------- **********
    case 'addons':
      if(!GeneralFunctions::isAdmin()) break;

      // dont show the current visitors when addon menu
      $showCurrentVisitors = false;

      // -> ADDONS LINKS
      if(!empty($addons) && is_array($addons)) {
        echo '<div class="sidebarMenu gray staticScroller" data-offset="-2">
            <div class="top"><img src="library/images/icons/addonsIcon_middle.png" class="icons" alt="icon" width="35" height="35"><span>'.$langFile['BUTTON_ADDONS'].'</span><a href="#">&nbsp;</a></div>
            <div class="menuWrapper">
              <menu class="vertical">';

              echo '<li><a href="#top"><i class="icon icon-arrow-up icon-white"></i></a></li>';

                // -> show a anchor link to each user
                foreach($addons as $addon) {
                  $currentAddon = ($addon['name'] == $_GET['addon']) ? ' class="active"' : '';
                  echo '<li><a href="?site=addons&amp;addon='.$addon['name'].'"'.$currentAddon.' tabindex="'.$tabIndex++.'"><span>'.$addon['title'].'</span></a></li>';
                }
            echo '</menu>
          </div>
          <div class="bottom"><a href="#" onclick="return false;">&nbsp;</a></div>
        </div>';
      }
  } //switch END
}

// -> Show the current visitors
if($showCurrentVisitors) {
  $currentVisitorDashboard = false;
  $currentVisitors = include('library/includes/currentVisitors.include.php');
  echo '<div id="currentVisitorsSideBar">';
    echo $currentVisitors;
  echo '</div>';
}
