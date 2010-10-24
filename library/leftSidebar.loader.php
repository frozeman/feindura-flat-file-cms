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
    <div class="top brown"><img src="library/images/sign/pageIcon_middle.png" class="icon" alt="icon" /><span>'.$langFile['categories_noncategory_name'].'</span><a href="#" class="toolTip" title="'.$langFile['categories_noncategory_tip'].'::">&nbsp;</a></div>
    <div class="content brown">
      <ul class="verticalButtons">';
            
      if($pages = $generalFunctions->loadPages(0,true)) {
          
        foreach($pages as $page) {
          if($_GET['page'] == $page['id'])
            $pageSelected = ' class="active"';
          else
            $pageSelected = '';
               
          echo '<li><a href="?category=0&amp;page='.$page['id'].'"'.$pageSelected.'><span>'.$page['title'].'</span><span style="display:none;" class="toolTip noMark notSavedSignPage'.$page['id'].'" title="'.$langFile['editor_pageNotSaved'].'::"> *</span></a></li>';
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
    
    // SPACER
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
        echo '<li><a href="?site=pages&amp;category='.$category['id'].'" onclick="requestLeftSidebar(\''.$category['id'].'\',\''.$_GET['page'].'\',\''.$_GET['site'].'\');return false;"'.$categorySelected.'><span>'.$category['name'].'</span></a></li>';        
      }        
    echo '</ul>          
      </div>
      <div class="bottom"><a href="#">&nbsp;</a></div>
    </div>';
  }
  
  // ----  show QUICKMENU for the CATEGORY PAGES
  if(!empty($_GET['category'])) {
    
    // SPACER
    echo '<div class="spacer arrow"></div>';
    
    echo '<div class="sidebarMenu free">
    <div class="top grey"><img src="library/images/sign/pageIcon_middle.png" class="icon" alt="icon" /><span>'.$categoryConfig[$_GET['category']]['name'].'</span><a href="#" class="toolTip" title="'.$langFile['btn_quickmenu_pages'].' '.$categoryConfig[$_GET['category']]['name'].'::">&nbsp;</a></div>
    <div class="content white">
      <ul class="verticalButtons">';      
      
      if($pages = $generalFunctions->loadPages($_GET['category'],true)) { 
  
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
    // ***** home -------------------------------------------- **********
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
              
         echo '<br />
              <br /></div>';
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
          if(include(dirname(__FILE__).'/thirdparty/sessionLister.php'))
            $sessionLister = new sessionLister();         

          // list user
          echo '<ul id="sidebarListUsers">';
          foreach($userConfig as $user) {
            
            echo '<li><span';
            
            // your own user
            if($_SESSION['feinduraLogin'][IDENTITY]['username'] == $user['username'])
              echo ' class="toolTip brown" style="font-weight:bold;" title="'.$langFile['user_currentuser'].'::"';
            // users who are online too
            elseif(is_array(($sessions = $sessionLister->getSessions()))) {              
              foreach($sessions as $sessionName => $sessionData) {
                if((time() - $sessionData["modification"]) < 1800 ) { // show only sessions within the last half hour
                  if(isset($sessionData['raw']['login_username']) && $sessionData['raw']['login_username'] == $user['username']) {
                    echo ' class="toolTip blue" style="font-weight:bold;" title="'.$langFile['user_onlineusers'].': '.date("H:i",$sessionData["modification"]).'"';
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
          echo '<span style="color:#9E0000;">'.$langFile['user_nousers'].'</span>';
      
      echo '</div></div>';
      
      break;
    // ***** adminSetup sideBar -------------------------------------------- **********
    case 'adminSetup':
      
      echo '<div class="sidebarInfo"><div class="content">';
      
      // FEINDURA INFO
      echo '<h1>'.$langFile['adminSetup_version'].'</h1>
            <p>'.$version[2].' - '.$version[3].'</p>';
      echo '<a href="README.md" class="standardLink">README</a><br />';
      echo '<a href="CHANGELOG" class="standardLink">CHANGELOG</a><br />';
      echo '<a href="LICENSE" class="standardLink">LICENSE</a>';
      echo '<hr />';
      
      if(substr(phpversion(),0,3) >= '4.3') {
           echo '<h1>'.$langFile['adminSetup_phpVersion'].'</h1>
            <p>'.phpversion().'</p>';
      } else {
          echo '<h1 style="color:#B70000;">'.$langFile['adminSetup_phpVersion'].'</h1>
            <p style="color:#B70000;">'.phpversion().'<br /><br /><b>'.$langFile['adminSetup_warning_phpversion'].' PHP 4.3.0</b></p>'; 
      }
      
      echo '<h1>'.$langFile['adminSetup_srvRootPath'].'</h1>';   
      echo '<p class="toolTip" title="'.$langFile['adminSetup_srvRootPath'].'::'.DOCUMENTROOT.'">'.DOCUMENTROOT.'</p>
          </div></div>';
      
      break;
    // ***** websiteSetup -------------------------------------------- **********
    case 'websiteSetup':     
      
      break;
    // ***** pageSetup -------------------------------------------- **********
    case 'pageSetup':
      
      // -> CATEGORY ANCHOR LINKS
      echo '<div id="sidebarSelection">';
      
      echo '<a href="?site=pageSetup&amp;status=createCategory#category'.getNewCatgoryId().'" class="createCategory toolTip" style="float:none; margin:10px 0px 0px 15px;" title="'.$langFile['pageSetup_createCategory'].'::"></a>'; 
      
      if(!empty($categoryConfig)) {
        echo '<div class="sidebarInfo"><div class="content">';
        echo '<a href="#top" class="up" style="padding-top: 2px;" title="'.$langFile['btn_fastUp'].'">'.$langFile['btn_fastUp'].'</a>';
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
    // ***** userSetup -------------------------------------------- **********
    case 'userSetup':
      
      // -> USER ANCHOR LINKS
      echo '<div id="sidebarSelection">';
      
      echo '<a href="?site=userSetup&amp;status=createUser#userId'.getNewUserId().'" class="createUser toolTip" style="float:none; margin:10px 0px 0px 15px;" title="'.$langFile['userSetup_createUser'].'::"></a>'; 
      
      if(!empty($userConfig)) {
        echo '<div class="sidebarInfo"><div class="content">';
        echo '<a href="#top" class="up" style="padding-top: 2px;" title="'.$langFile['btn_fastUp'].'">'.$langFile['btn_fastUp'].'</a>';
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
    // ***** search -------------------------------------------- **********
    case 'search':

      break;
    // ***** deletePage -------------------------------------------- **********
    case 'deletePage':

      break;     
  } //switch END

}

?>