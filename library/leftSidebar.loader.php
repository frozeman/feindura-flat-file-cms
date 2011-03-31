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

// -----------------------------------------------------------------------------------
// if page ID is given, it LOAD THE EDITOR
// or if $_GET['site'] == 'pages'
if((!empty($_GET['page']) && empty($_GET['site'])) || $_GET['site'] == 'pages') {
  
  $tabIndex = 40;
  
  // ----  show QUICKMENU for the NONE-CATEGORY PAGES
  // slide the categories menu IN, when a category is open
  if(empty($_GET['category']))
    $hidden = '';
  else $hidden = ' hidden';
  
  echo '<div class="sidebarMenu fixed'.$hidden.'">
  <div class="top brown"><img src="library/images/icons/pageIcon_middle.png" class="icon" alt="icon" width="35" height="35" /><span>'.$langFile['CATEGORIES_TEXT_NONCATEGORY'].'</span><a href="#" class="toolTip" title="'.$langFile['CATEGORIES_TOOLTIP_NONCATEGORY'].'::">&nbsp;</a></div>
  <div class="content brown">
    <ul class="verticalButtons">';
          
    if($pages = generalFunctions::loadPages(0,true)) {
        
      foreach($pages as $page) {
        if($_GET['page'] == $page['id'])
          $pageSelected = ' class="active"';
        else
          $pageSelected = '';
             
        echo '<li><a href="?category=0&amp;page='.$page['id'].'" tabindex="'.$tabIndex.'"'.$pageSelected.'><span>'.strip_tags($page['title']).'</span><span style="display:none;" class="toolTip noMark notSavedSignPage'.$page['id'].'" title="'.$langFile['editor_pageNotSaved'].'::"> *</span></a></li>';
        $tabIndex++;
      }
    } else {
      echo '<li><a href="#" onclick="return false;"><span>'.$langFile['sortablePageList_categoryEmpty'].'</span></a></li>';
    }
      
  echo '</ul>          
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
  
    echo '<div class="sidebarMenu free'.$hidden.'">
    <div class="top blue"><img src="library/images/icons/categoryIcon_middle.png" class="icon" alt="icon" width="35" height="35" /><span>'.$langFile['btn_quickmenu_categories'].'</span><a href="#">&nbsp;</a></div>
    <div class="content blue">
      <ul class="verticalButtons">';      
        
      foreach($categoryConfig as $category) {
        if($_GET['category'] == $category['id'])
            $categorySelected = ' class="active"';
          else
            $categorySelected = '';                  
        echo '<li><a href="?site=pages&amp;category='.$category['id'].'" tabindex="'.$tabIndex.'" onclick="requestLeftSidebar(\''.$_GET['site'].'\',\''.$_GET['page'].'\',\''.$category['id'].'\');return false;"'.$categorySelected.'><span>'.$category['name'].'</span></a></li>';        
        $tabIndex++;
      }        
    echo '</ul>          
      </div>
      <div class="bottom"><a href="#" onclick="return false;">&nbsp;</a></div>
    </div>';
  }
  
  // ----  show QUICKMENU for the CATEGORY PAGES
  if(!empty($_GET['category'])) {
    
    // spacer
    echo '<div class="spacer arrow"></div>';
    
    echo '<div class="sidebarMenu free">
    <div class="top grey"><img src="library/images/icons/pageIcon_middle.png" class="icon" alt="icon" width="35" height="35" /><span>'.$categoryConfig[$_GET['category']]['name'].'</span><a href="#" class="toolTip" title="'.$langFile['btn_quickmenu_pages'].' '.$categoryConfig[$_GET['category']]['name'].'::">&nbsp;</a></div>
    <div class="content white">
      <ul class="verticalButtons">';      
      
      if($pages = generalFunctions::loadPages($_GET['category'],true)) { 
  
        foreach($pages as $page) {
          if($_GET['page'] == $page['id'])
            $pageSelected = ' class="active"';
          else
            $pageSelected = '';
               
          echo '<li><a href="?category='.$page['category'].'&amp;page='.$page['id'].'" tabindex="'.$tabIndex.'"'.$pageSelected.'><span>'.$page['title'].'</span><span style="display:none;" class="toolTip noMark notSavedSignPage'.$page['id'].'" title="'.$langFile['editor_pageNotSaved'].'::"> *</span></a></li>';
          $tabIndex++;
        }       
      } else {
        echo '<li><a href="#" onclick="return false;"><span>'.$langFile['sortablePageList_categoryEmpty'].'</span></a></li>';
      }        
    echo '</ul>          
      </div>
      <div class="bottom"><a href="#" onclick="return false;">&nbsp;</a></div>
    </div>';
  }

// -----------------------------------------------------------------------------------
// SWITCH SITE
} else {

  // SWITCH the &_GET['site'] var
  switch($_GET['site']) {
    // ***** DASHBOARD -------------------------------------------- **********
    case 'dashboard': case '':
      
      echo '<div class="sidebarInfo"><div class="content">';
      
      // -> SHOW TASK LOG
      echo '<h2>'.$langFile['DASHBOARD_TITLE_ACTIVITY'].'</h2>';
      
      if(file_exists(dirname(__FILE__).'/../statistic/activity.statistic.log') &&
         $logContent = file(dirname(__FILE__).'/../statistic/activity.statistic.log')) {
         
         echo '<div id="sidbarTaskLogScrollUp" class="scrollUpDown" style="background: url(library/images/bg/sidebarScrollUp.png) no-repeat;margin-bottom:-30px;"></div>';
         echo '<div id="sidebarTaskLog"><br /><br />';
         
              // ->> LIST the tasks
              include(dirname(__FILE__).'/includes/showTaskLog.include.php');
              
         echo '<br /><br /></div>';
         echo '<div id="sidbarTaskLogScrollDown" class="scrollUpDown" style="background: url(library/images/bg/sidebarScrollDown.png) no-repeat;margin-top:-30px;"></div>';
      // no log
      } else
        echo $langFile['DASHBOARD_TEXT_ACTIVITY_NONE'];
      
      echo '<hr />';
      
      // -> SHOW USERs
      echo '<h2><img src="library/images/icons/userIcon_small.png" alt="icon" width="22" height="21" style="position:relative;top:5px;" /> '.$langFile['DASHBOARD_TITLE_USER'].'</h2><br />';
        if(!empty($userConfig)) {
        
          unset($sessions,$sessionLister);
          
          // crreate an instance of sessionLister
          if(include(dirname(__FILE__).'/thirdparty/PHP/sessionLister.php'))
            $sessionLister = new sessionLister();         

          // list user
          echo '<ul id="sidebarListUsers">';
          foreach($userConfig as $user) {
            
            echo '<li><span';
            
            // your own user
            if($_SESSION['feinduraLogin'][IDENTITY]['username'] == $user['username'])
              echo ' class="toolTip brown" style="font-weight:bold;" title="'.$langFile['USER_TEXT_CURRENTUSER'].'::"';
            // users who are online too
            elseif(is_array(($sessions = $sessionLister->getSessions()))) {              
              foreach($sessions as $sessionName => $sessionData) {
                if((time() - $sessionData["modification"]) < 1800 ) { // show only sessions within the last half hour
                  if(isset($sessionData['raw']['LOGIN_INPUT_USERNAME']) && $sessionData['raw']['LOGIN_INPUT_USERNAME'] == $user['username']) {
                    echo ' class="toolTip blue" style="font-weight:bold;" title="'.$langFile['USER_TEXT_USERSONLINE'].': '.date("H:i",$sessionData["modification"]).'"';
                    break;
                  }
                }
              }
            }  
              
            // list users
            echo '>'.$user['username'].'</span></li>';
          }
          echo '</ul>';
        // no users
        } else
          echo '<span style="color:#9E0000;">'.$langFile['USER_TEXT_NOUSER'].'</span>';
      
      echo '</div></div>';
      
      break;
    // ***** ADMINSETUP sideBar -------------------------------------------- **********
    case 'adminSetup':
      
      echo '<div class="sidebarInfo"><div class="content">';
      
      // FEINDURA INFO
      echo '<h2>'.$langFile['ADMINSETUP_TEXT_VERSION'].'</h2>
            <p>'.$version[2].' - '.$version[3].'</p>';
      echo '<a href="README.md" class="standardLink">README</a><br />';
      echo '<a href="CHANGELOG" class="standardLink">CHANGELOG</a><br />';
      echo '<a href="LICENSE" class="standardLink">LICENSE</a>';
      echo '<hr />';
      
      echo '<h3>'.$langFile['ADMINSETUP_TEXT_PHPVERSION'].'</h3>
      <p>'.PHP_VERSION.'</p>';
       
      echo '<h3>'.$langFile['adminSetup_srvRootPath'].'</h3>';   
      echo '<p class="toolTip" title="'.$langFile['adminSetup_srvRootPath'].'::'.DOCUMENTROOT.'">'.DOCUMENTROOT.'</p>
          </div></div>';
      
      break;
    // ***** PAGESETUP -------------------------------------------- **********
    case 'pageSetup':
      
      // -> CATEGORY ANCHOR LINKS
      echo '<div id="sidebarSelection" class="staticScroller">';
      
      echo '<a href="?site=pageSetup&amp;status=createCategory#category'.getNewCatgoryId().'" class="createCategory toolTip" style="float:none; margin:10px 0px 0px 15px;" title="'.$langFile['pageSetup_createCategory'].'::"></a>'; 
      
      if(!empty($categoryConfig)) {
        echo '<div class="sidebarInfo"><div class="content">';
        echo '<a href="#top" class="up" style="padding-top: 2px;" title="'.$langFile['BUTTON_UP'].'">'.$langFile['BUTTON_UP'].'</a>';
        if(is_array($categoryConfig)) {
  	      echo '<hr />';
            echo '<h2>'.$langFile['btn_quickmenu_categories'].'</h2>';
            echo '<ul>';      
          
            // -> show a anchor link to each category
  	        foreach($categoryConfig as $category) {
              echo '<li><a href="#category'.$category['id'].'" class="standardLink">'.$category['name'].'</a></li>';
          
            }	echo '</ul>';
	      } echo '</div></div>';
      } echo '</div>';

      break;
    // ***** USERSETUP -------------------------------------------- **********
    case 'userSetup':
      
      // -> USER ANCHOR LINKS
      echo '<div id="sidebarSelection" class="staticScroller">';
      
      echo '<a href="?site=userSetup&amp;status=createUser#userId'.getNewUserId().'" class="createUser toolTip" style="float:none; margin:10px 0px 0px 15px;" title="'.$langFile['userSetup_createUser'].'::"></a>'; 
      
      if(!empty($userConfig)) {
        echo '<div class="sidebarInfo"><div class="content">';
        echo '<a href="#top" class="up" style="padding-top: 2px;" title="'.$langFile['BUTTON_UP'].'">'.$langFile['BUTTON_UP'].'</a>';
        if(is_array($userConfig)) {
  	      echo '<hr />';
            echo '<h2>'.$langFile['userSetup_userSelection'].'</h2>';
            echo '<ul>';      
          
            // -> show a anchor link to each user
  	        foreach($userConfig as $user) {
  	          $userIsAdmin = ($user['admin']) ? ' toolTip" style="font-weight:bold" title="'.$langFile['userSetup_admin'].'::"' : '"';
              echo '<li><a href="#userId'.$user['id'].'" class="standardLink'.$userIsAdmin.'>'.$user['username'].'</a></li>';
          
            } echo '</ul>';
	      } echo '</div></div>';
      } echo '</div>';

      break;
    // ***** BACKUP sideBar -------------------------------------------- **********
    case 'backup':
      
      echo '<div id="sidebarSelection">';
      echo '<div class="sidebarInfo"><div class="content">';
      
      // link the backup files
      $backups = generalFunctions::readFolder(dirname(__FILE__).'/../backups/');      
      if(!empty($backups['files'])) {
        $lastBackups = '<ul>';
        natsort($backups['files']);
        $backups['files'] = array_reverse($backups['files']);
        foreach($backups['files'] as $backupFile) {
          $backupTime = filemtime(DOCUMENTROOT.$backupFile);

          $lastBackups .= '<span class="deleteIcon" style="width:100%;">';
          $lastBackups .= '<a href="?site=backup&amp;status=deleteBackup&amp;file='.$backupFile.'" onclick="openWindowBox(\'library/sites/windowBox/deleteBackup.php?status=deleteBackup&amp;file='.$backupFile.'\',\''.$langFile['BACKUP_TITLE_BACKUP'].'\');return false;" class="deleteIcon toolTip" title="'.$langFile['BACKUP_TOOLTIP_DELETE'].'::" style="top:14px;"></a>';
          $lastBackups .= (strpos($backupFile,'restore') === false)
            ? '<li class="backupLink"><a href="'.$backupFile.'">'.$langFile['BACKUP_TITLE_BACKUP'].'<br />'.statisticFunctions::formatDate(statisticFunctions::dateDayBeforeAfter($backupTime)).' '.statisticFunctions::formatTime($backupTime).'</a></li>'."\n"
            : '<li class="backupLink"><a href="'.$backupFile.'">'.$langFile['BACKUP_TEXT_RESTORE_BACKUPBEFORERESTORE'].'<br />'.statisticFunctions::formatDate(statisticFunctions::dateDayBeforeAfter($backupTime)).' '.statisticFunctions::formatTime($backupTime).'</a></li>'."\n";
          
          $lastBackups .= '</span>';
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