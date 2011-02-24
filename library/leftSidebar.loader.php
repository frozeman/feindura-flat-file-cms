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
 * Includes the login and filters the incoming data by xssFilter
 */
require_once(dirname(__FILE__)."/includes/secure.include.php");

echo ' '; // hack for safari, otherwise it throws an error that he could not find htmlentities like &ouml;

// -----------------------------------------------------------------------------------
// if page ID is given, it LOAD THE EDITOR
// or if $_GET['site'] == 'pages'
if((!empty($_GET['page']) && empty($_GET['site'])) || $_GET['site'] == 'pages') {
 
  // ----  show QUICKMENU for the NONE-CATEGORY PAGES
  if($_GET['category'] !== 0 || empty($categoryConfig)) {

    // slide the categories menu IN, when a category is open
    if(empty($_GET['category']))
      $hidden = '';
    else $hidden = ' hidden';
    
    echo '<div class="sidebarMenu fixed'.$hidden.'">
    <div class="top brown"><img src="library/images/sign/pageIcon_middle.png" class="icon" alt="icon" /><span>'.$langFile['CATEGORIES_TEXT_NONCATEGORY'].'</span><a href="#" class="toolTip" title="'.$langFile['CATEGORIES_TOOLTIP_NONCATEGORY'].'::">&nbsp;</a></div>
    <div class="content brown">
      <ul class="verticalButtons">';
            
      if($pages = generalFunctions::loadPages(0,true)) {
          
        foreach($pages as $page) {
          if($_GET['page'] == $page['id'])
            $pageSelected = ' class="active"';
          else
            $pageSelected = '';
               
          echo '<li><a href="?category=0&amp;page='.$page['id'].'"'.$pageSelected.'><span>'.strip_tags($page['title']).'</span><span style="display:none;" class="toolTip noMark notSavedSignPage'.$page['id'].'" title="'.$langFile['editor_pageNotSaved'].'::"> *</span></a></li>';
        }        
      } else {
        echo '<li><a href="#"><span>'.$langFile['sortablePageList_categoryEmpty'].'</span></a></li>';
      }
        
    echo '</ul>          
      </div>
      <div class="bottom"><a href="#">&nbsp;</a></div>
    </div>';
  }
  
  // ----  show QUICKMENU for the CATEGORIES
  if(!empty($categoryConfig)) {
    
    // spacer
    echo '<div class="spacer"></div>';

    // slide the categories menu OUT, when a category is open
    if($_GET['site'] != 'pages' && $_GET['category'] == 0) // 
      $hidden = ' hidden';
    else $hidden = '';
  
    echo '<div class="sidebarMenu free'.$hidden.'">
    <div class="top blue"><img src="library/images/sign/categoryIcon_middle.png" class="icon" alt="icon" /><span>'.$langFile['btn_quickmenu_categories'].'</span><a href="#">&nbsp;</a></div>
    <div class="content blue">
      <ul class="verticalButtons">';      
        
      foreach($categoryConfig as $category) {
        if($_GET['category'] == $category['id'])
            $categorySelected = ' class="active"';
          else
            $categorySelected = '';                  
        echo '<li><a href="?site=pages&amp;category='.$category['id'].'" onclick="requestLeftSidebar(\''.$_GET['site'].'\',\''.$_GET['page'].'\',\''.$category['id'].'\');return false;"'.$categorySelected.'><span>'.$category['name'].'</span></a></li>';        
      }        
    echo '</ul>          
      </div>
      <div class="bottom"><a href="#">&nbsp;</a></div>
    </div>';
  }
  
  // ----  show QUICKMENU for the CATEGORY PAGES
  if(!empty($_GET['category'])) {
    
    // spacer
    echo '<div class="spacer arrow"></div>';
    
    echo '<div class="sidebarMenu free">
    <div class="top grey"><img src="library/images/sign/pageIcon_middle.png" class="icon" alt="icon" /><span>'.$categoryConfig[$_GET['category']]['name'].'</span><a href="#" class="toolTip" title="'.$langFile['btn_quickmenu_pages'].' '.$categoryConfig[$_GET['category']]['name'].'::">&nbsp;</a></div>
    <div class="content white">
      <ul class="verticalButtons">';      
      
      if($pages = generalFunctions::loadPages($_GET['category'],true)) { 
  
        foreach($pages as $page) {
          if($_GET['page'] == $page['id'])
            $pageSelected = ' class="active"';
          else
            $pageSelected = '';
               
          echo '<li><a href="?category='.$page['category'].'&amp;page='.$page['id'].'"'.$pageSelected.'><span>'.$page['title'].'</span><span style="display:none;" class="toolTip noMark notSavedSignPage'.$page['id'].'" title="'.$langFile['editor_pageNotSaved'].'::"> *</span></a></li>';
        }       
      } else {
        echo '<li><a href="#"><span>'.$langFile['sortablePageList_categoryEmpty'].'</span></a></li>';
      }        
    echo '</ul>          
      </div>
      <div class="bottom"><a href="#">&nbsp;</a></div>
    </div>';
  }

// -----------------------------------------------------------------------------------
// SWITCH SITE
} else {

  // SWITCH the &_GET['site'] var
  switch($_GET['site']) {
    // ***** HOME -------------------------------------------- **********
    case 'home': case '':
      
      echo '<div class="sidebarInfo"><div class="content">';
      
      // -> SHOW TASK LOG
      echo '<h1>'.$langFile['home_taskLog_h1'].'</h1>';
      
      if(file_exists(DOCUMENTROOT.$adminConfig['basePath'].'statistic/activity.statistic.log') &&
         $logContent = file(DOCUMENTROOT.$adminConfig['basePath'].'statistic/activity.statistic.log')) {
         
         echo '<div id="sidbarTaskLogScrollUp" class="scrollUpDown" style="background: url(library/images/bg/sidebarScrollUp.png) no-repeat;margin-bottom:-30px;"></div>';
         echo '<div id="sidebarTaskLog"><br /><br />';
         
              // ->> LIST the tasks
              include(dirname(__FILE__).'/processes/showTaskLog.process.php');
              
         echo '<br /><br /></div>';
         echo '<div id="sidbarTaskLogScrollDown" class="scrollUpDown" style="background: url(library/images/bg/sidebarScrollDown.png) no-repeat;margin-top:-30px;"></div>';
      // no log
      } else
        echo $langFile['home_taskLog_nolog'];
      
      echo '<hr />';
      
      // -> SHOW USERs
      echo '<h1><img src="library/images/sign/userIcon_small.png" alt="icon" style="position:relative;top:5px;" /> '.$langFile['home_user_h1'].'</h1><br />';
        if(!empty($userConfig)) {
        
          unset($sessions,$sessionLister);
          
          // crreate an instance of sessionLister
          if(include(dirname(__FILE__).'/thirdparty/php/sessionLister.php'))
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
      echo '<h1>'.$langFile['ADMINSETUP_TEXT_VERSION'].'</h1>
            <p>'.$version[2].' - '.$version[3].'</p>';
      echo '<a href="README.md" class="standardLink">README</a><br />';
      echo '<a href="CHANGELOG" class="standardLink">CHANGELOG</a><br />';
      echo '<a href="LICENSE" class="standardLink">LICENSE</a>';
      echo '<hr />';
      
      echo '<h1>'.$langFile['ADMINSETUP_TEXT_PHPVERSION'].'</h1>
      <p>'.PHP_VERSION.'</p>';
       
      echo '<h1>'.$langFile['adminSetup_srvRootPath'].'</h1>';   
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
            echo '<h1>'.$langFile['btn_quickmenu_categories'].'</h1>';
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
            echo '<h1>'.$langFile['userSetup_userSelection'].'</h1>';
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
      $backups = generalFunctions::readFolder($adminConfig['basePath'].'backups/');      
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
      
      // FEINDURA INFO
      echo '<h1>'.$langFile['BACKUP_TITLE_LASTBACKUPS'].'</h1>';
      echo $lastBackups;
      echo '</div></div>';
      echo '</div>';
      
      break;   
  } //switch END
}

?>