<?php
/*
    feindura - Flat File Content Management System
    Copyright (C) 2009 Fabian Vogelsteller [frozeman.de]

    This program is free software;
    you can redistribute it and/or modify it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 3 of the License, or (at your option) any later version.

    This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY;
    without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
    See the GNU General Public License for more details.

    You should have received a copy of the GNU General Public License along with this program;
    if not,see <http://www.gnu.org/licenses/>.
*/
// sidebar.loader.php version 0.45

// -----------------------------------------------------------------------------------
// if page ID is given, it LOAD THE EDITOR
// or if $_GET['site'] == 'pages'
if((!empty($_GET['page']) && empty($_GET['site'])) || $_GET['site'] == 'pages') {
 
  // ----  show QUICKMENU for the NONE-CATEGORY PAGES
  if($_GET['category'] !== 0 || empty($categories)) {

    // slide the categories menu IN, when a category is open
    if(empty($_GET['category']))
      $hidden = '';
    else $hidden = ' hidden';
    
    echo '<div class="sidebarMenu fixed'.$hidden.'">
    <div class="top brown"><img src="library/image/sign/icon_page_small.png" class="icon" alt="icon" /><span>'.$langFile['categories_nocategories_name'].'</span><a href="#" class="toolTip" title="'.$langFile['categories_nocategories_name'].'::'.$langFile['categories_nocategories_hint'].'">&nbsp;</a></div>
    <div class="content brown">
      <ul class="verticalButtons">';
            
      if($pages = loadPages(0)) {
          
        foreach($pages as $page) {
          if($_GET['page'] == $page['id'])
            $pageSelected = ' class="active"';
          else
            $pageSelected = '';
               
          echo '<li><a href="?category=0&amp;page='.$page['id'].'"'.$pageSelected.'><span>'.$page['title'].'</span></a></li>';
        }        
      } else {
        echo '<li><a href="#"><span>'.$langFile['sortablePageList_categoryEmpty'].'</span></a></li>';
      }
        
    echo '</ul>          
      </div>
      <div class="bottom"><a href="#">&nbsp;</a></div>
    </div>';
    
    // SPACER
    echo '<div class="spacer"></div>';
  }
  
  // ----  show QUICKMENU for the CATEGORIES
  if(!empty($categories)) {   
    
    // slide the categories menu IN, when a category is open
    if($_GET['site'] == 'pages' || $_GET['category'] == 0)
      $hidden = '';
    else $hidden = ' hidden';
  
    echo '<div class="sidebarMenu free'.$hidden.'">
    <div class="top blue"><!--<img src="library/image/bg/sidebarMenu_fixedFade.png" alt="fade"/>--><img src="library/image/sign/icon_category_small.png" class="icon" alt="icon" /><span>'.$langFile['btn_quickmenu_categories'].'</span><a href="#" class="toolTip" title="'.$langFile['btn_quickmenu_categories'].'::">&nbsp;</a></div>
    <div class="content blue">
      <ul class="verticalButtons">';      
        
      foreach($categories as $category) {
        if($_GET['category'] == $category['id'])
            $categorySelected = ' class="active"';
          else
            $categorySelected = '';                  
        echo '<li><a href="?site=pages&amp;category='.$category['id'].'"'.$categorySelected.'><span>'.$category['name'].'</span></a></li>';        
      }        
    echo '</ul>          
      </div>
      <div class="bottom"><a href="#">&nbsp;</a></div>
    </div>';
  }
  
  // ----  show QUICKMENU for the CATEGORY PAGES
  if(!empty($_GET['category'])) {
    
    // SPACER
    echo '<div class="spacer"></div>';
    
    echo '<div class="sidebarMenu free">
    <div class="top blue"><img src="library/image/sign/icon_page_small.png" class="icon" alt="icon" /><span>'.$categories['id_'.$_GET['category']]['name'].'</span><a href="#" class="toolTip" title="'.$langFile['btn_quickmenu_pages'].' '.$categories['id_'.$_GET['category']]['name'].'::">&nbsp;</a></div>
    <div class="content blue">
      <ul class="verticalButtons">';      
      
      if($pages = loadPages($_GET['category'])) { 
  
        foreach($pages as $page) {
          if($_GET['page'] == $page['id'])
            $pageSelected = ' class="active"';
          else
            $pageSelected = '';
               
          echo '<li><a href="?category='.$page['category'].'&amp;page='.$page['id'].'"'.$pageSelected.'><span>'.$page['title'].'</span></a></li>';
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

  // SWITCHES the &_GET['site'] var
  switch($_GET['site']) {
    // ***** home -------------------------------------------- **********
    case 'home': case '':
      
      echo '<div class="sidebarInfo">
            </div>';
      
      break;
    // ***** adminSetup sideBar -------------------------------------------- **********
    case 'adminSetup': //case 'adminSetup_save': case 'advancedsetup_phpaccess': case 'advancedsetup_creategroup': case 'advancedsetup_deletegroup':
      
      echo '<div class="sidebarInfo">';
      
      // FMS INFO
      echo '<h1>'.$langFile['adminSetup_version'].'</h1>
            <p>'.$version[2].' - '.$version[3].'</p>
           <h1>'.$langFile['adminSetup_phpVersion'].'</h1>
            <p>'.phpversion().'</p>
           <h1>'.$langFile['adminSetup_srvRootPath'].'</h1>
            <p class="toolTip" title="'.$langFile['adminSetup_srvRootPath'].'::'.$documentRoot.'">'.$documentRoot.'</p>
          </div>';
      
      break;
    // ***** websiteSetup -------------------------------------------- **********
    case 'websiteSetup': //case 'usersetup_save':

      break;
    // ***** userSetup -------------------------------------------- **********
    case 'userSetup':

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