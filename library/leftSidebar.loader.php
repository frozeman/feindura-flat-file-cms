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
// sidebar.loader.php version 0.60

/**
 * Includes the login.include.php and backend.include.php and filter the basic data
 */
require_once(dirname(__FILE__)."/includes/secure.include.php");

echo ' '; // hack for safari, otherwise it throws an error that he could not find htmlentities like &ouml;

// vars
$tabIndex = 40;


// -----------------------------------------------------------------------------------
// if page ID is given, it LOAD THE EDITOR
// or if $_GET['site'] == 'pages'
if((!empty($_GET['page']) && empty($_GET['site']))) { // || $_GET['site'] == 'pages'

  echo '<div id="sidebarSelection" class="staticScroller">';

    // ----  show QUICKMENU for the NONE-CATEGORY PAGES
    // slide the categories menu IN, when a category is open
    if(empty($_GET['category']))
      $hidden = '';
    else
      $hidden = ' hidden';

    echo '<div class="sidebarMenu fixed brown'.$hidden.'">
    <div class="top"><img src="library/images/icons/pageIcon_middle.png" class="icon" alt="icon" width="35" height="35"><span>'.$langFile['CATEGORIES_TEXT_NONCATEGORY'].'</span><a href="#" class="toolTip" title="'.$langFile['CATEGORIES_TOOLTIP_NONCATEGORY'].'::">&nbsp;</a></div>
    <div class="menuWrapper">
      <menu class="vertical">';

      if($pages = GeneralFunctions::loadPages(0)) {
        foreach($pages as $page) {

          // -> show page ID
          $pageId = (isAdmin())
            ? ' class="toolTip noMark" title="ID '.$page['id'].'"'
            : '';

          if($_GET['page'] == $page['id'])
            $pageSelected = ' class="active"';
          else
            $pageSelected = '';

          echo '<li><a href="?category=0&amp;page='.$page['id'].'" tabindex="'.$tabIndex.'"'.$pageSelected.'><span'.$pageId.'>'.strip_tags(GeneralFunctions::getLocalized($page,'title')).'</span><span style="display:none;" class="toolTip noMark notSavedSignPage'.$page['id'].'" title="'.$langFile['EDITOR_pageNotSaved'].'::"> *</span></a></li>';
          $tabIndex++;
        }
      } else {
        echo '<li><a href="#" onclick="return false;"><span>'.$langFile['SORTABLEPAGELIST_categoryEmpty'].'</span></a></li>';
      }

    echo '</menu>
      </div>
      <div class="bottom"><a href="#">&nbsp;</a></div>
    </div>';

    // ----  show QUICKMENU for the CATEGORIES
    if(!empty($categoryConfig)) {

      // spacer
      echo '<div class="spacer"></div>';

      // slide the categories menu OUT, when a category is open
      if($_GET['site'] != 'pages' && $_GET['category'] == 0) //
        $hidden = ' hidden';
      else $hidden = '';

      echo '<div class="sidebarMenu free blue'.$hidden.'">
      <div class="top"><img src="library/images/icons/categoryIcon_middle.png" class="icon" alt="icon" width="35" height="35"><span>'.$langFile['SIDEBARMENU_TITLE_CATEGORIES'].'</span><a href="#">&nbsp;</a></div>
      <div class="menuWrapper">
        <menu class="vertical">';

        foreach($categoryConfig as $category) {

          // overjump the non-category
          if($category['id'] == 0) continue;

          // -> show category ID
          $categoryId = (isAdmin())
            ? ' class="toolTip noMark" title="ID '.$category['id'].'"'
            : '';

          if($_GET['category'] == $category['id'])
              $categorySelected = ' class="active"';
            else
              $categorySelected = '';
          echo '<li><a href="?site=pages&amp;category='.$category['id'].'" tabindex="'.$tabIndex.'" onclick="requestLeftSidebar(\''.$_GET['site'].'\',\''.$_GET['page'].'\',\''.$category['id'].'\');return false;"'.$categorySelected.'><span'.$categoryId.'>'.GeneralFunctions::getLocalized($category,'name').'</span></a></li>';
          $tabIndex++;
        }
      echo '</menu>
        </div>
        <div class="bottom"><a href="#" onclick="return false;">&nbsp;</a></div>
      </div>';
    }

    // ----  show QUICKMENU for the CATEGORY PAGES
    if(!empty($_GET['category'])) {

      // spacer
      echo '<div class="spacer arrow"></div>';

      echo '<div class="sidebarMenu free gray">
      <div class="top"><img src="library/images/icons/pageIcon_middle.png" class="icon" alt="icon" width="35" height="35"><span>'.GeneralFunctions::getLocalized($categoryConfig[$_GET['category']],'name').'</span><a href="#" class="toolTip" title="'.$langFile['SIDEBARMENU_TITLE_PAGES'].' '.GeneralFunctions::getLocalized($categoryConfig[$_GET['category']],'name').'::">&nbsp;</a></div>
      <div class="menuWrapper">
        <menu class="vertical">';

        if($pages = GeneralFunctions::loadPages($_GET['category'])) {

          foreach($pages as $page) {

            // -> show page ID
            $pageId = (isAdmin())
              ? ' class="toolTip noMark" title="ID '.$page['id'].'"'
              : '';

            if($_GET['page'] == $page['id'])
              $pageSelected = ' class="active"';
            else
              $pageSelected = '';

            echo '<li><a href="?category='.$page['category'].'&amp;page='.$page['id'].'" tabindex="'.$tabIndex.'"'.$pageSelected.'><span'.$pageId.'>'.GeneralFunctions::getLocalized($page,'title').'</span><span style="display:none;" class="toolTip noMark notSavedSignPage'.$page['id'].'" title="'.$langFile['EDITOR_pageNotSaved'].'::"> *</span></a></li>';
            $tabIndex++;
          }
        } else {
          echo '<li><a href="#" onclick="return false;"><span>'.$langFile['SORTABLEPAGELIST_categoryEmpty'].'</span></a></li>';
        }
      echo '</menu>
        </div>
        <div class="bottom"><a href="#" onclick="return false;">&nbsp;</a></div>
      </div>';
    }

    echo '</div>';
// -----------------------------------------------------------------------------------
// SWITCH SITE
} else {

  // SWITCH the &_GET['site'] var
  switch($_GET['site']) {
    // ***** DASHBOARD -------------------------------------------- **********
    case 'dashboard': case 'pages': case '':

      echo '<div class="sidebarInfo"><div class="content">';

      // -> SHOW TASK LOG
      echo '<h2>'.$langFile['DASHBOARD_TITLE_ACTIVITY'].'</h2>';

      if(file_exists(dirname(__FILE__).'/../statistic/activity.statistic.log') &&
         $logContent = file(dirname(__FILE__).'/../statistic/activity.statistic.log')) {

         echo '<div id="sidbarTaskLogScrollUp" class="scrollUpDown" style="background: url(library/images/bg/sidebarScrollUp.png) no-repeat; top: 40px;"></div>';
         echo '<div id="sidebarTaskLog"><br><br>';

              // ->> LIST the tasks
              include(dirname(__FILE__).'/includes/showTaskLog.include.php');

         echo '<br><br></div>';
         echo '<div id="sidbarTaskLogScrollDown" class="scrollUpDown" style="background: url(\'library/images/bg/sidebarScrollDown.png\') no-repeat; margin-top:-30px;"></div>';
      // no log
      } else
        echo $langFile['DASHBOARD_TEXT_ACTIVITY_NONE'];

      echo '<hr>';

      // -> SHOW USERs
      echo '<h2><img src="library/images/icons/userIcon_small.png" alt="icon" width="22" height="21"> '.$langFile['DASHBOARD_TITLE_USER'].'</h2><br>';
        if(!empty($userConfig)) {

          // list user
          echo '<ul class="sidebarListUsers unstyled">';
          foreach($userConfig as $user) {

            echo '<li';
            // your own user
            if($_SESSION['feinduraSession']['login']['user'] == $user['id'])
              echo ' class="toolTip online brown" title="'.$langFile['USER_TEXT_CURRENTUSER'].'::"';
            // users who are online too
            else {
              foreach($userCache as $cachedUser) {
                if($user['username'] == $cachedUser['username']) {
                  echo ' class="toolTip online" title="'.$langFile['USER_TEXT_USERSONLINE'].': '.date("H:i",$cachedUser["timestamp"]).'"';
                    break;
                }
              }
            }

            // list users
            echo '>'.$user['username'].'</li>';
          }
          echo '</ul>';
        // no users
        } else
          echo '<span style="color:#9E0000;">'.$langFile['USER_TEXT_NOUSER'].'</span>';

      echo '</div></div>';

      break;
    // ***** ADMIN SETUP sideBar -------------------------------------------- **********
    case 'adminSetup':
      if(!isAdmin()) break;

      echo '<div class="sidebarInfo"><div class="content">';

      // FEINDURA INFO
      echo '<h2>'.$langFile['ADMINSETUP_TEXT_VERSION'].'</h2>
            <p>'.VERSION.' - Build '.BUILD.'</p>';
      echo '<a href="README.md" class="link">README</a><br>';
      echo '<a href="CHANGELOG" class="link">CHANGELOG</a><br>';
      echo '<a href="LICENSE" class="link">LICENSE</a>';
      echo '<hr>';

      echo '<h3>'.$langFile['ADMINSETUP_TEXT_PHPVERSION'].'</h3>
      <p>'.PHP_VERSION.'</p>';

      echo '<h3>'.$langFile['ADMINSETUP_TITLE_DOCUMENTROOT'].'</h3>';
      echo '<p class="toolTip" title="'.$langFile['ADMINSETUP_TITLE_DOCUMENTROOT'].'::'.DOCUMENTROOT.'">'.DOCUMENTROOT.'</p>
          </div></div>';

      break;

    // ***** PAGESETUP -------------------------------------------- **********
    case 'pageSetup':
      if(!isAdmin()) break;

      // -> CATEGORY ANCHOR LINKS
      echo '<div id="sidebarSelection" class="staticScroller">';

      if(!empty($categoryConfig) && is_array($categoryConfig)) {

        echo '<div class="sidebarMenu fixed blue">
            <div class="top"><img src="library/images/icons/categoryIcon_middle.png" class="icon" alt="icon" width="35" height="35"><span>'.$langFile['SIDEBARMENU_TITLE_CATEGORIES'].'</span><a href="#">&nbsp;</a></div>
            <div class="menuWrapper">
              <menu class="vertical">';

              echo '<li><a href="#top"><i class="icon icon-arrow-up"></i></a></li>';
              echo '<li><a href="#nonCategoryPages"><span>'.GeneralFunctions::getLocalized($categoryConfig[0],'name').'</span></a></li>';

                foreach($categoryConfig as $category) {

                  // overjump the non-category
                  if($category['id'] == 0) continue;

                  echo '<li><a href="#categoryAnchor'.$category['id'].'" tabindex="'.$tabIndex.'"><span>'.GeneralFunctions::getLocalized($category,'name').'</span></a></li>';
                  $tabIndex++;
                }
            echo '</menu>
          </div>
          <div class="bottom"><a href="#" onclick="return false;">&nbsp;</a></div>
        </div>';

      echo '<a href="?site=pageSetup&amp;status=createCategory#category'.getNewCatgoryId().'" class="createCategory toolTip" style="float:none; margin:10px 0px 0px 15px;" title="'.$langFile['PAGESETUP_CATEGORY_TEXT_CREATECATEGORY'].'::"></a><br>';

        // echo '<h2>'.$langFile['SIDEBARMENU_TITLE_CATEGORIES'].'</h2>';
        // echo '<div class="content">';
        // echo '<ul class="nav nav-tabs nav-stacked">';

        //   echo '<li><a href="#top"><i class="icon icon-arrow-up"></i></a></li>';
        //   echo '<li><a href="#nonCategoryPages">'.GeneralFunctions::getLocalized($categoryConfig[0],'name').'</a></li>';

        //   // -> show a anchor link to each category
	       //  foreach($categoryConfig as $category) {
        //     // overjump the non-category
        //     if($category['id'] == 0) continue;

        //     echo '<li><a href="#categoryAnchor'.$category['id'].'">'.GeneralFunctions::getLocalized($category,'name').'</a></li>';

        //   }
        // echo '</ul>';
        // echo '</div>';
        // echo '</div>';
      }
      echo '</div>';

      break;
    // ***** USERSETUP -------------------------------------------- **********
    case 'userSetup':
      if(!isAdmin()) break;

      // -> USER ANCHOR LINKS
      echo '<div id="sidebarSelection" class="staticScroller">';

      if(!empty($userConfig) && is_array($userConfig)) {

        echo '<div class="sidebarMenu fixed gray">
            <div class="top"><img src="library/images/icons/userIcon_middle.png" class="icon" alt="icon" width="35" height="35"><span>'.$langFile['USERSETUP_userSelection'].'</span><a href="#">&nbsp;</a></div>
            <div class="menuWrapper">
              <menu class="vertical">';

              echo '<li><a href="#top"><i class="icon icon-arrow-up"></i></a></li>';

                // -> show a anchor link to each user
                foreach($userConfig as $user) {
                  $userIsAdmin = ($user['admin']) ? ' toolTip" style="font-weight:bold" title="'.$langFile['USERSETUP_admin'].'::"' : '"';
                  echo '<li><a href="#userId'.$user['id'].'" class="'.$userIsAdmin.' tabindex="'.$tabIndex.'"><span>'.$user['username'].'</span></a></li>';
                  $tabIndex++;
                }
            echo '</menu>
          </div>
          <div class="bottom"><a href="#" onclick="return false;">&nbsp;</a></div>
        </div>';

      echo '<a href="?site=userSetup&amp;status=createUser#userId'.getNewUserId().'" class="createUser toolTip" style="float:none; margin:10px 0px 0px 15px;" title="'.$langFile['USERSETUP_createUser'].'::"></a><br>';

       //  echo '<div class="content">';
       //      echo '<h2>'.$langFile['USERSETUP_userSelection'].'</h2>';
       //      echo '<ul class="nav nav-tabs nav-stacked">';

       //        echo '<li><a href="#top"><i class="icon icon-arrow-up"></i></a></li>';

       //      // -> show a anchor link to each user
  	    //     foreach($userConfig as $user) {
  	    //       $userIsAdmin = ($user['admin']) ? ' toolTip" style="font-weight:bold" title="'.$langFile['USERSETUP_admin'].'::"' : '"';
       //        echo '<li><a href="#userId'.$user['id'].'" class="'.$userIsAdmin.'>'.$user['username'].'</a></li>';

       //      } echo '</ul>';
	      // echo '</div>';
      } echo '</div>';

      break;
    // ***** BACKUP sideBar -------------------------------------------- **********
    case 'backup':
      if(!isAdmin()) break;

      echo '<div id="sidebarSelection">';
      echo '<div class="sidebarInfo"><div class="content">';

      // link the backup files
      $backups = GeneralFunctions::readFolder(dirname(__FILE__).'/../backups/');
      if(!empty($backups['files'])) {
        $lastBackups = '<ul class="unstyled backupDownload">';
        natsort($backups['files']);
        $backups['files'] = array_reverse($backups['files']);
        foreach($backups['files'] as $backupFile) {
          $backupTime = filemtime(DOCUMENTROOT.$backupFile);

          $lastBackups .= '<li><a href="'.GeneralFunctions::Path2URI($backupFile).'" class="backup">';
          $lastBackups .= (strpos($backupFile,'restore') === false)
            ? $langFile['BACKUP_TITLE_BACKUP']
            : $langFile['BACKUP_TEXT_RESTORE_BACKUPBEFORERESTORE'];
          $lastBackups .= '<br>'.GeneralFunctions::formatDate(GeneralFunctions::dateDayBeforeAfter($backupTime)).' '.formatTime($backupTime).'</a>';
          $lastBackups .= '<a href="?site=backup&amp;status=deleteBackup&amp;file='.basename($backupFile).'" onclick="openWindowBox(\'library/views/windowBox/deleteBackup.php?status=deleteBackup&amp;file='.basename($backupFile).'\',\''.$langFile['BACKUP_TITLE_BACKUP'].'\');return false;" class="deleteIcon toolTip" title="'.$langFile['BACKUP_TOOLTIP_DELETE'].'::"></a></li>';
        }
        $lastBackups .= '</ul>';
      } else
        $lastBackups = '<p>'.$langFile['BACKUP_TEXT_NOBACKUP'].'</p>';

      // BACKUP DOWNLOADS
      echo '<h2>'.$langFile['BACKUP_TITLE_LASTBACKUPS'].'</h2>';
      echo $lastBackups;
      echo '</div></div>';
      echo '</div>';

      break;
  } //switch END
}

?>