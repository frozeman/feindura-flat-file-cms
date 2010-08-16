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
 * index.php
 *
 * @version 2.01
 */


/**
 * Includes all necessary configs, functions and classes
 */
include("library/backend.include.php");

// VARs
// -----------------------------------------------------------------------------------
// gets the version of the feindura CMS
$version = file("CHANGELOG");
$version[2] = $generalFunctions->cleanSpecialChars($version[2]);
$version[3] = $generalFunctions->cleanSpecialChars($version[3]);
//$version[2] = str_replace(array("\n","\n"),'',$version[2]);
//$version[3] = str_replace(array("\n","\n"),'',$version[3]);


// if feindura starts first set page to 'home'
if(empty($_GET['site']) && empty($_GET['category']) && empty($_GET['page']))
  $_GET['site'] = 'home';


// -----------------------------------------------------------------------------------
// generates the DOCUMENT TYPE
// kind of hack, because i use iframes for uploading the thumbnail
if($_GET['site'] == 'pages' || !empty($_GET['page']) ||
   $_GET['site'] == 'userSetup' ||
   $_GET['site'] == 'adminSetup' ||
   $_GET['site'] == 'websiteSetup' ||
   $_GET['site'] == 'pluginSetup') {
  echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
      "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
';
} else {
  echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
     "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
';
}
?>
<html lang="<?php echo $_SESSION['language']; ?>" xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="content-type" content="application/xhtml+xml; charset=UTF-8" /> <!-- iso-8859-1 -->
  <meta http-equiv="content-language" content="<?php echo $_SESSION['language']; ?>" />
  
  <title>      
    feindura > <?php echo $websiteConfig['title']; ?> 
  </title>
  
  <meta http-equiv="X-UA-Compatible" content="chrome=1">
  
  <meta name="siteinfo" content="<?php echo $adminConfig['basePath'] ?>robots.txt" />
  <meta name="revisit_after" content="12" />
  <meta name="robots" content="index,nofollow" />
  <meta http-equiv="pragma" content="no-cache" /> <!--browser/proxy würde die seite nicht cachen-->
  <meta http-equiv="cache-control" content="no-cache" /> <!--proxy würde die seite nicht cachen-->
      
  <meta name="title" content="feindura > <?php echo $websiteConfig['title']; ?>" />    
  <meta name="author" content="Fabian Vogelsteller [frozeman.de]" />     
  <meta name="publisher" content="Fabian Vogelsteller [frozeman.de]" />
  <meta name="copyright" content="Fabian Vogelsteller [frozeman.de]" />    
  <meta name="description" content="Ein Content Managemant System, welches auf Flatfiles basiert" />    
  <meta name="keywords" content="fmx,cms,conte,management,system,flatfiles" /> 
   
  <link rel="shortcut icon" href="<?php echo dirname($_SERVER['PHP_SELF']).'/'; ?>favicon.ico" />
  
  <!-- ************************************************************************************************************ -->
  <!-- STYLESHEETS -->
  
  <link rel="stylesheet" type="text/css" href="library/style/reset.css" media="all" />
  <link rel="stylesheet" type="text/css" href="library/style/layout.css" media="all" />
  <link rel="stylesheet" type="text/css" href="library/style/headerMenus.css" media="screen" />
  <link rel="stylesheet" type="text/css" href="library/style/subMenu.css" media="screen" />
  <link rel="stylesheet" type="text/css" href="library/style/leftSidebar.css" media="screen" />
  <link rel="stylesheet" type="text/css" href="library/style/rightSidebar.css" media="screen" /> 
  <link rel="stylesheet" type="text/css" href="library/style/content.css" media="screen" />
  <link rel="stylesheet" type="text/css" href="library/style/statistic.css" media="screen" />
  <link rel="stylesheet" type="text/css" href="library/style/pageSetup.css" media="screen" />
  <link rel="stylesheet" type="text/css" href="library/style/footerMenu.css" media="screen" />
  <link rel="stylesheet" type="text/css" href="library/style/loading.css" media="screen" />
  <link rel="stylesheet" type="text/css" href="library/style/windowBox.css" media="screen" />
  <link rel="stylesheet" type="text/css" href="library/style/fileManager.css" media="screen" />
  <link rel="stylesheet" type="text/css" href="library/style/errorWindow.css" media="screen" />
  <link rel="stylesheet" type="text/css" href="library/style/listPages.css" media="screen" />
  <link rel="stylesheet" type="text/css" href="library/style/notifications.css" media="screen" />
  <link rel="stylesheet" type="text/css" href="library/style/forms.css" media="screen" />
  <link rel="stylesheet" type="text/css" href="library/style/toolTip.css" media="screen" />
  <link rel="stylesheet" type="text/css" href="library/style/editor.css" media="screen" />
  <link rel="stylesheet" type="text/css" href="library/style/pageThumbnail.css" media="screen" />
  
<?php
if($_GET['site'] == 'addons') {
  echo "  <!-- addons stylesheets -->\n";
  echo createStyleTags($adminConfig['basePath'].'addons/');
}
?>
  
  <!--[if IE 6]><link rel="stylesheet" type="text/css" href="library/style/ie6.css" /><![endif]-->
  <!--[if IE 7]><link rel="stylesheet" type="text/css" href="library/style/ie7.css" /><![endif]-->
  
  <noscript>
  <link rel="stylesheet" type="text/css" href="library/style/noJavascript.css" media="screen" />
  </noscript>
  
  <!-- thirdparty/customformelements -->
  <link rel="stylesheet" type="text/css" href="library/thirdparty/customformelements/css/cfe.css" />
  
  <!-- ************************************************************************************************************ -->
  <!-- JAVASCRIPT -->
  
  <!-- thirdparty/iePNGfix -->
  <!--[if IE 6]><script type="text/javascript" src="library/thirdparty/iepngfix_v2/iepngfix_tilebg.js"></script><![endif]-->
  <!--[if IE 6]><script type="text/javascript" src="library/javascript/ie.js"></script><![endif]-->

  <!-- thirdparty/MooTools -->
  <script type="text/javascript" src="library/thirdparty/javascript/mootools-1.2.4-core.js"></script>
  <script type="text/javascript" src="library/thirdparty/javascript/mootools-1.2.4.4-more.js"></script>
  
  <!-- thirdparty/AutoGrow (needs MooTools) -->
  <script type="text/javascript" src="library/thirdparty/javascript/autogrow-1.0.js"></script>
  
  <!-- thirdparty/StaticScroller (needs MooTools) -->
  <script type="text/javascript" src="library/thirdparty/javascript/staticScroller/Source/StaticScroller.js"></script>
	<script type="text/javascript" src="library/thirdparty/javascript/staticScroller/Requires/Element.Pin.js"></script>
	
	<!-- thirdparty/Raphael -->
  <script type="text/javascript" src="library/thirdparty/javascript/raphael-1.4.3.js"></script>
	
  <!-- thirdparty/CodeMirror -->
  <script type="text/javascript" src="library/thirdparty/javascript/CodeMirror/js/codemirror.js"></script>
  
  <!-- thirdparty/CustomFormElements -->
  <script type="text/javascript" src="library/thirdparty/customformelements/cfe-min/cfe.base.js"></script>
  <script type="text/javascript" src="library/thirdparty/customformelements/cfe-min/cfe.replace.js"></script>
  <script type="text/javascript" src="library/thirdparty/customformelements/cfe-min/cfe.module.checkbox.js"></script>
  <!--<script type="text/javascript" src="library/thirdparty/customformelements/cfe-min/cfe.module.radio.js"></script>-->
  <script type="text/javascript" src="library/thirdparty/customformelements/cfe-min/cfe.addon.dependencies.js"></script>
  
  <!-- thirdparty/CKEditor -->
  <script type="text/javascript" src="library/thirdparty/ckeditor/ckeditor.js"></script>
 
  <!-- javascripts -->
  <script type="text/javascript" src="library/javascript/loading.js"></script>
  <script type="text/javascript" src="library/javascript/layoutFix.js"></script>
  <script type="text/javascript" src="library/javascript/divScroller.js"></script>
  <script type="text/javascript" src="library/javascript/adminMenu.js"></script>  
  <script type="text/javascript" src="library/javascript/sidebar.js"></script>
  <script type="text/javascript" src="library/javascript/sidebarMenu.js"></script>  
  <script type="text/javascript" src="library/javascript/sortPages.js"></script>
  <script type="text/javascript" src="library/javascript/setup.js"></script>
  <script type="text/javascript" src="library/javascript/content.js"></script>
  <script type="text/javascript" src="library/javascript/forms.js"></script>
  <script type="text/javascript" src="library/javascript/windowBox.js"></script>
  <script type="text/javascript" src="library/javascript/ajax.js"></script>
  <script type="text/javascript" src="library/javascript/toolTips.js"></script>
  <script type="text/javascript" src="library/javascript/editor.js"></script>
  <script type="text/javascript" src="library/javascript/editFiles.js"></script>
  <script type="text/javascript" src="library/javascript/pageThumbnail.js"></script>
  
</head>
<body>
  <div id="dimmContainer">
  </div>
  
  <!-- loadingBox -->
  <div id="loadingBox">
    <div class="top"></div>
    <div class="content">
    </div>
    <div class="bottom"></div>
  </div>
  
  <div id="windowBoxContainer">
    <div id="windowBox">
      <div class="boxTop"><?php echo $langFile['txt_loading']; ?><a href="#" onclick="closeWindowBox(false);return false;"></a></div>
      <div id="windowRequestBox"></div>
      <div class="boxBottom"></div>
    </div>
  </div>

  <!-- ***************************************************************************************** -->
  <!-- ** HEADER ******************************************************************************* -->
  <div id="header">
    <a id="top" name="top" class="anchorTarget"></a>
    
    <div id="headerBlock">
      
      <div id="languageSelection">
        <a href="?language=en" class="en"></a>
        <a href="?language=de" class="de"></a>
      </div>
          
      <a href="http://<?= $adminConfig['url'] ?>" id="logo" class="toolTip" title="<?php echo $langFile['txt_logo'].$version[2].' - '.$version[3]; ?>::"></a>
      <div id="version"><?php echo $version[2]; ?></div>
      
      <div id="mainMenu">
        <table>
          <tr>
          <td><a href="?site=home" class="home<?php if($_GET['site'] == 'home') echo ' active'; ?>" title="<?php echo $langFile['btn_home']; ?>"><span><?php echo $langFile['btn_home']; ?></span></a></td>
          <td><a href="?site=pages" class="pages<?php if($_GET['site'] == 'pages' || !empty($_GET['page'])) echo ' active'; ?>" title="<?php echo $langFile['btn_pages']; ?>"><span><?php echo $langFile['btn_pages']; ?></span></a></td>
          <?php
          // CHECKS if the addons/ folder is empty
          if(!$generalFunctions->folderIsEmpty($adminConfig['basePath'].'addons/')) { ?>
          <td><a href="?site=addons" class="addons<?php if($_GET['site'] == 'addons') echo ' active'; ?>" title="<?php echo $langFile['btn_addons']; ?>"><span><?php echo $langFile['btn_addons']; ?></span></a></td>
          <?php } ?>
          <td><a href="?site=websiteSetup" class="websiteSetup<?php if($_GET['site'] == 'websiteSetup') echo ' active'; ?>" title="<?php echo $langFile['btn_settings']; ?>"><span><?php echo $langFile['btn_settings']; ?></span></a></td>
          <td><a href="?site=search" class="search<?php if($_GET['site'] == 'search') echo ' active'; ?>" title="<?php echo $langFile['btn_search']; ?>"><span><?php echo $langFile['btn_search']; ?></span></a></td>
          </tr>
        </table>
                
        <!--
        <ul class="horizontalButtons">
          <li><a href="?site=home" class="home" title="<?php echo $langFile['btn_home']; ?>"><span><?php echo $langFile['btn_home']; ?></span></a></li>
          <li><a href="?site=pages" class="pages" title="<?php echo $langFile['btn_pages']; ?>"><span><?php echo $langFile['btn_pages']; ?></span></a></li>
          <?php
          // checks if there any modules or plugins, if not dont show the menupoint
          if(!$generalFunctions->folderIsEmpty($adminConfig['basePath'].'addons/')) { ?>
          <li><a href="" class="addons" title="<?php echo $langFile['btn_addons']; ?>"><span><?php echo $langFile['btn_addons']; ?></span></a></li>
          <?php } ?>
          <li><a href="?site=websiteSetup" class="websiteSetup" title="<?php echo $langFile['btn_settings']; ?>"><span><?php echo $langFile['btn_settings']; ?></span></a></li>
          <li><a href="?site=search" class="search" title="<?php echo $langFile['btn_search']; ?>"><span><?php echo $langFile['btn_search']; ?></span></a></li>
        </ul>
        -->
      </div>
    </div>
    
    <!-- ADMIN-SPACE -->
    <?php if(isAdmin()) { ?>
    <div id="adminMenu">
      <?php // show the admin part if the user is admin, or no other user is admin, administrator, root or superuser
      ?>
      <h1><?php echo $langFile['title_adminMenu']; ?></h1>
      <div class="content">
        <table>
          <tr>
          <td><a href="?site=adminSetup" class="adminSetup<?php if($_GET['site'] == 'adminSetup') echo ' active'; ?>" title="<?php  echo $langFile['btn_adminSetup']; ?>"><span><?php echo $langFile['btn_adminSetup']; ?></span></a></td>
          <td><a href="?site=pageSetup" class="pageSetup<?php if($_GET['site'] == 'pageSetup') echo ' active'; ?>" title="<?php  echo $langFile['btn_pageSetup']; ?>"><span><?php echo $langFile['btn_pageSetup']; ?></span></a></td>
          </tr><tr>
          <td><a href="?site=statisticSetup" class="statisticSetup<?php if($_GET['site'] == 'statisticSetup') echo ' active'; ?>" title="<?php  echo $langFile['btn_statisticSetup']; ?>"><span><?php echo $langFile['btn_statisticSetup']; ?></span></a></td>
          <td><a href="?site=userSetup" class="userSetup<?php if($_GET['site'] == 'userSetup') echo ' active'; ?>" onclick="openWindowBox('library/sites/userSetup.php','<?php echo $langFile['btn_userSetup']; ?>',true);return false;" title="<?php echo $langFile['btn_userSetup']; ?>"><span><?php echo $langFile['btn_userSetup']; ?></span></a></td>
          <?php
          // CHECKS if one of the plugins/ or modules/ folders is empty
          if(!$generalFunctions->folderIsEmpty($adminConfig['basePath'].'plugins/') || !$generalFunctions->folderIsEmpty($adminConfig['basePath'].'modules/')) { ?>
          </tr><tr>
          <?php
          // CHECKS if the plugins/ folder is empty
          if(!$generalFunctions->folderIsEmpty($adminConfig['basePath'].'plugins/')) { ?>
          <td><a href="?site=pluginSetup" class="pluginSetup<?php if($_GET['site'] == 'pluginSetup') echo ' active'; ?>" title="<?php  echo $langFile['btn_pluginSetup']; ?>"><span><?php echo $langFile['btn_pluginSetup']; ?></span></a></td>
          <?php } else { ?>
          <td</td>
          <?php }

          // CHECKS if the modlues/ folder is empty
          if(!$generalFunctions->folderIsEmpty($adminConfig['basePath'].'modules/')) { ?>
          <td><a href="?site=modulSetup" class="modulSetup<?php if($_GET['site'] == 'modulSetup') echo ' active'; ?>" title="<?php  echo $langFile['btn_modulSetup']; ?>"><span><?php echo $langFile['btn_modulSetup']; ?></span></a></td>
          <?php } else { ?>
          <td</td>
          <?php }
          } ?>
          </tr>       
        </table>
      </div>      
    </div>
    <?php } ?>
    <!--<a href="http://frozeman.de" id="createdBy" title="created by Fabian Vogelsteller [frozeman.de]">&nbsp;</a>-->
  </div>     
  
  
  <!-- ***************************************************************************************** -->
  <!-- ** MAINBODY ***************************************************************************** -->
  <div id="mainBody">
    <?php   
     
    // CHECK createPage
    $generallyCreatePages = false;
    // check if non-category can create pages
    if($adminConfig['page']['createdelete'])
      $generallyCreatePages = true;
    // if not check if one category can create pages
    else {
      foreach($categoryConfig as $category) {
        if($category['createdelete'])
          $generallyCreatePages = true;
      }
    }
    
    if($generallyCreatePages && $_GET['site'] == 'pages' ||
       (!empty($_GET['page']) &&
       ($_GET['category'] == 0 && $adminConfig['page']['createdelete']) ||
        $categoryConfig['id_'.$_GET['category']]['createdelete']))
      $showCreatePage = true;
    else
      $showCreatePage = false;
    
    // CHECK 1. pageThumbnailUpload
    if(empty($_GET['site']) && !empty($_GET['page']) && (($_GET['category'] == 0 && $adminConfig['page']['thumbnails']) || $categoryConfig['id_'.$_GET['category']]['thumbnail']))
      $showPageThumbnailUpload = true;
    else
      $showPageThumbnailUpload = false;
    
    // CHECK 1. SHOW SUB- FOOTERMENU
    if(//$_GET['status'] != 'changePageStatus' &&
       //$_GET['status'] != 'changeCategoryStatus' &&
       //$_GET['category'] != '' &&
       ($_GET['site'] == 'pages' || !empty($_GET['page'])) && 
       ($showPageThumbnailUpload || $showCreatePage || $adminConfig['user']['fileManager']))
      $showSubFooterMenu = true;
    else
      $showSubFooterMenu = false;          
    
    ?>
    <!-- ************************************************************************* -->    
    <!-- ** CONTENT ************************************************************** -->
    <div id="content"<?php if($showSubFooterMenu) echo 'class="hasSubMenu"'; ?>>      
      <?php
      
      include('library/content.loader.php');
      
      ?>
      <a href="#top" class="fastUp" title="<?php echo $langFile['btn_fastUp']; ?>">&nbsp;</a>
    </div>    
    <?php    
    // ---------------------------------------------------------------
    // CHECK to show BUTTONs in subMenu and FooterMenu
    
    // show deletePage
    if(!$newPage && empty($_GET['site']) && !empty($_GET['page']) && $_GET['page'] != 'new')
      $showDeletePage = true;
    else
      $showDeletePage = false;
      
    // CHECK 2. pageThumbnailUpload
    if(!$newPage && $showPageThumbnailUpload)
      $showPageThumbnailUpload = true;
    else
      $showPageThumbnailUpload = false;
    
    // show pageThumbnailDelete
    if(empty($_GET['site']) && !empty($pageContent['thumbnail']))
      $showPageThumbnailDelete = true;
    else
      $showPageThumbnailDelete = false;
      
    // ---------------------------------------------------------------
    // CHECK 2. SHOW SUB- FOOTERMENU
    if(($_GET['site'] == 'pages' || !empty($_GET['page'])) && 
       (($showSubFooterMenu && ($showCreatePage || $showPageThumbnailUpload)) || $adminConfig['user']['fileManager']))
      $showSubFooterMenu = true;
    else
      $showSubFooterMenu = false;

    ?>
    <!-- ************************************************************************* -->
    <!-- ** SUBMENU ************************************************************** -->
    <?php if($showSubFooterMenu) { ?>
    <div class="subMenu">
      <div class="left"></div>
      <div class="content">
        <ul class="horizontalButtons">         
          <?php
          $showSpacer = false;
          
          // file manager
          if($adminConfig['user']['fileManager']) { ?>
          <li><a href="?site=fileManager" onclick="openWindowBox('library/sites/fileManager.php','<?php echo $langFile['btn_fileManager']; ?>',true);return false;" class="fileManager toolTip" title="<?php echo $langFile['btn_fileManager_tip']; ?>::">&nbsp;</a></li>
          <?php
            $showSpacer = true;
          }
          
          if($showSpacer && ($showPageThumbnailUpload || $showCreatePage)) { ?>
          <li class="spacer">&nbsp;</li>
          <?php 
            $showSpacer = false;
          } 
          
          // create new page
          if($showCreatePage) { ?>
          <li><a href="<?php echo '?category='.$_GET['category'].'&amp;page=new'; ?>" class="createPage toolTip" title="<?php echo $langFile['btn_createPage_tip']; ?>::">&nbsp;</a></li>
          <?php
          // deletePage
          if($showDeletePage) { ?>
          <li><a <?php echo 'href="?site=deletePage&amp;category='.$_GET['category'].'&amp;page='.$_GET['page'].'" onclick="openWindowBox(\'library/sites/deletePage.php?category='.$_GET['category'].'&amp;page='.$_GET['page'].'\',\''.$langFile['btn_deletePage'].'\',true);return false;" title="'.$langFile['btn_deletePage_tip'].'::"'; ?> class="deletePage toolTip">&nbsp;</a></li>
          <?php }          
            $showSpacer = true;
          }
          
          if($showSpacer && $showPageThumbnailUpload) { ?>
          <li class="spacer">&nbsp;</li>
          <?php 
            $showSpacer = false;
          }          
          
          // pageThumbnailUpload
          if($showPageThumbnailUpload) { ?>
          <li><a <?php echo 'href="?site=pageThumbnailUpload&amp;category='.$_GET['category'].'&amp;page='.$_GET['page'].'" onclick="openWindowBox(\'library/sites/pageThumbnailUpload.php?site='.$_GET['site'].'&amp;category='.$_GET['category'].'&amp;page='.$_GET['page'].'\',\''.$langFile['btn_pageThumbnailUpload'].'\',true);return false;" title="'.$langFile['btn_pageThumbnailUpload_tip'].'::"'; ?> class="pageThumbnailUpload toolTip">&nbsp;</a></li>
          <?php
          // pageThumbnailDelete
          if($showPageThumbnailDelete) { ?>
          <li><a <?php echo 'href="?site=pageThumbnailDelete&amp;category='.$_GET['category'].'&amp;page='.$_GET['page'].'" onclick="openWindowBox(\'library/sites/pageThumbnailDelete.php?site='.$_GET['site'].'&amp;category='.$_GET['category'].'&amp;page='.$_GET['page'].'\',\''.$langFile['btn_pageThumbnailDelete'].'\',true);return false;" title="'.$langFile['btn_pageThumbnailDelete_tip'].'::"'; ?> class="pageThumbnailDelete toolTip">&nbsp;</a></li>
          <?php }          
            $showSpacer = true;
          }           
          ?>          
        </ul>
      </div>        
      <div class="right"></div>
    </div>
    <?php } ?>
    
  </div>
  
  <!-- ************************************************************************* -->
  <!-- ** DOCUMENT SAVED ******************************************************* -->
  <div id="documentSaved"<?php if($documentSaved === true) echo ' class="saved"'; ?>></div>
  
  <!-- ************************************************************************* -->
  <!-- ** ERROR WINDOW ********************************************************* -->
  <?php if($errorWindow !== false) { ?>
  <div id="errorWindow">
    <div class="top"><?php echo $langFile['form_errorWindow_h1'];?></div>
    <div class="content warning">
      <p><?php echo $errorWindow; ?></p>
      <a href="?site=<?php echo $_GET['site'] ?>" onclick="$('errorWindow').fade('out');return false;" class="ok"></a>
    </div>
    <div class="bottom"></div>
  </div>
  <?php } ?>
  
  <!-- ************************************************************************* -->
  <!-- ** LEFT-SIDEBAR ************************************************************** -->
  <!-- requires the <span> tag inside the <li><a> tag for measure the text width -->
  <div id="leftSidebar">
    <?php

    include('library/leftSidebar.loader.php');
    
    ?>
  </div>
  
  <!-- ************************************************************************* -->
  <!-- ** RIGHT-SIDEBAR ************************************************************** -->
  <!-- requires the <span> tag inside the <li><a> tag for measure the text width -->
  <div id="rightSidebar">
    <?php

    include('library/rightSidebar.loader.php');
    
    ?>
  </div>
  
  <!-- ******************************************************************************************* -->
  <!-- ** FOOTER ********************************************************************************* -->
  <div id="footer">
    <div id="footerBlock">
      <div id="footerMenu">
        <?php if($showSubFooterMenu) { /* show only when the editor is open */ ?>
        <ul class="horizontalButtons">
          <?php
          $showSpacer = false;
          
          // file manager
          if($adminConfig['user']['fileManager']) { ?>
          <li><a href="?site=fileManager" onclick="openWindowBox('library/sites/fileManager.php','<?php echo $langFile['btn_fileManager']; ?>');return false;" class="fileManager toolTip" title="<?php echo $langFile['btn_fileManager_tip']; ?>::"><span><?php echo $langFile['btn_fileManager']; ?></span></a></li>
          <?php
            $showSpacer = true;
          }
          
          if($showSpacer && ($showPageThumbnailUpload || $showCreatePage)) { ?>
          <li class="spacer">&nbsp;</li>
          <?php 
            $showSpacer = false;
          }
          
          // create new page
          if($showCreatePage) { ?>
          <li><a href="<?php echo '?category='.$_GET['category'].'&amp;page=new'; ?>" class="createPage toolTip" title="<?php echo $langFile['btn_createPage_tip']; ?>::"><span><?php echo $langFile['btn_createPage']; ?></span></a></li>
          <?php
          // deletePage
          if($showDeletePage) { ?>
          <li><a <?php echo 'href="?site=deletePage&amp;category='.$_GET['category'].'&amp;page='.$_GET['page'].'" onclick="openWindowBox(\'library/sites/deletePage.php?category='.$_GET['category'].'&amp;page='.$_GET['page'].'\',\''.$langFile['btn_deletePage'].'\');return false;" title="'.$langFile['btn_deletePage_tip'].'::"'; ?> class="deletePage toolTip"><span><?php echo $langFile['btn_deletePage']; ?></span></a></li>
          <?php }          
          $showSpacer = true;
          }
          
          
          if($showSpacer && $showPageThumbnailUpload) { ?>
          <li class="spacer">&nbsp;</li>
          <?php 
            $showSpacer = false;
          }
          
          
          // pageThumbnailUpload
          if($showPageThumbnailUpload) { ?>
          <li><a <?php echo 'href="?site=pageThumbnailUpload&amp;category='.$_GET['category'].'&amp;page='.$_GET['page'].'" onclick="openWindowBox(\'library/sites/pageThumbnailUpload.php?site='.$_GET['site'].'&amp;category='.$_GET['category'].'&amp;page='.$_GET['page'].'\',\''.$langFile['btn_pageThumbnailUpload'].'\');return false;" title="'.$langFile['btn_pageThumbnailUpload_tip'].'::"'; ?> class="pageThumbnailUpload toolTip"><span><?php echo $langFile['btn_pageThumbnailUpload']; ?></span></a></li>
          <?php
          // pageThumbnailDelete
          if($showPageThumbnailDelete) { ?>
          <li><a <?php echo 'href="?site=pageThumbnailDelete&amp;category='.$_GET['category'].'&amp;page='.$_GET['page'].'" onclick="openWindowBox(\'library/sites/pageThumbnailDelete.php?site='.$_GET['site'].'&amp;category='.$_GET['category'].'&amp;page='.$_GET['page'].'\',\''.$langFile['btn_pageThumbnailDelete'].'\');return false;" title="'.$langFile['btn_pageThumbnailDelete_tip'].'::"'; ?> class="pageThumbnailDelete toolTip"><span><?php echo $langFile['btn_pageThumbnailDelete']; ?></span></a></li>
          <?php }          
            $showSpacer = true;
          }           
          ?>          
        </ul>
        <?php } ?>
      </div>
      
      <div id="copyright">
        <span class="logoname">fein<span>dura</span></span> - Flat File Content Management System, Copyright &copy; 2009-<?php echo date('Y'); ?> <a href="http://frozeman.de">Fabian Vogelsteller</a> - <span class="logoname">fein<span>dura</span></span> is published under the <a href="LICENSE">GNU General Public License, version 3</a>
      </div>
    </div>
  </div>
    
</body>
</html>