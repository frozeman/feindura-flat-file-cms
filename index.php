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
*
* index.php version 1.95
*/

session_cache_limiter(60);
session_start();

//error_reporting(E_ALL);
include("library/backend.include.php");

// *---* holt die VARIABLEN ---------------------------------------------------------
//$category = $_GET['category'];

//$is_ie = eregi("(msie) ([0-9]{1,2}.[0-9]{1,3})",$_SERVER['HTTP_USER_AGENT']);

// gets the version of the feindura CMS
$version = file("version.txt");
$version = str_replace("\n",'',$version);
$version = str_replace("\r",'',$version);

// -----------------------------------------------------------------------------------
// generates the DOCUMENT TYPE
// kind of hack, because i use iframes for uploading the thumbnail
if($_GET['site'] == 'pages' || $_GET['site'] == 'userSetup' || !empty($_GET['page'])) {
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
    feindura CMS -> <?php echo $websiteConfig['seitentitel']; ?>
  </title>  
    
  <meta name="siteinfo" content="<?php echo $adminConfig['basePath'] ?>robots.txt" />
  <meta name="revisit_after" content="12" />
  <meta name="robots" content="index" />
  <meta name="robots" content="nofollow" />
  <meta http-equiv="pragma" content="no-cache" /> <!--browser/proxy würde die seite nicht cachen-->
  <meta http-equiv="cache-control" content="no-cache" /> <!--proxy würde die seite nicht cachen-->  
      
  <meta name="title" content="feindura CMS -> <?php echo $websiteConfig['seitentitel']; ?>" />    
  <meta name="author" content="Fabian Vogelsteller [frozeman.de]" />     
  <meta name="publisher" content="Fabian Vogelsteller [frozeman.de]" />
  <meta name="copyright" content="Fabian Vogelsteller [frozeman.de]" />    
  <meta name="description" content="Ein Content Managemant System, welches auf Flatfiles basiert" />    
  <meta name="keywords" content="fmx,cms,conte,management,system,flatfiles" /> 
   
  <link rel="shortcut icon" href="<?php echo dirname($_SERVER['PHP_SELF']).'/'; ?>favicon.ico" />
  
  <link rel="stylesheet" type="text/css" href="library/style/layout.css" media="all" />
  <link rel="stylesheet" type="text/css" href="library/style/headerMenus.css" media="screen" />
  <link rel="stylesheet" type="text/css" href="library/style/subMenu.css" media="screen" />
  <link rel="stylesheet" type="text/css" href="library/style/sidebar.css" media="screen" />  
  <link rel="stylesheet" type="text/css" href="library/style/content.css" media="screen" />
  <link rel="stylesheet" type="text/css" href="library/style/statistic.css" media="screen" />
  <link rel="stylesheet" type="text/css" href="library/style/categorySetup.css" media="screen" />
  <link rel="stylesheet" type="text/css" href="library/style/footerMenu.css" media="screen" />
  <link rel="stylesheet" type="text/css" href="library/style/loading.css" media="screen" />
  <link rel="stylesheet" type="text/css" href="library/style/windowBox.css" media="screen" />
  <link rel="stylesheet" type="text/css" href="library/style/errorWindow.css" media="screen" />
  <link rel="stylesheet" type="text/css" href="library/style/listPages.css" media="screen" />
  <link rel="stylesheet" type="text/css" href="library/style/forms.css" media="screen" />
  <link rel="stylesheet" type="text/css" href="library/style/toolTip.css" media="screen" />
  <link rel="stylesheet" type="text/css" href="library/style/editor.css" media="screen" />
  <link rel="stylesheet" type="text/css" href="library/style/pageThumbnail.css" media="screen" />
  
  <link rel="stylesheet" type="text/css" href="library/thirdparty/customformelements/css/cfe.css" />
  
  <link rel="stylesheet" type="text/css" href="library/style/print.css" media="print, embossed" />  
  <!--[if IE 6]><link rel="stylesheet" type="text/css" href="library/style/ie.css" /><![endif]-->
  
  
  <!--[if IE 6]><script type="text/javascript" src="library/thirdparty/iepngfix_v2/iepngfix_tilebg.js"></script><![endif]-->
  <!--[if IE 6]><script type="text/javascript" src="library/javascript/ie.js"></script><![endif]-->
  
  <!-- thirdparty/MooTools -->
  <script type="text/javascript" src="library/thirdparty/mootools-1.2.4-core.js"></script>
  <script type="text/javascript" src="library/thirdparty/mootools-1.2.3.1-more.js"></script>
  
  <!-- thirdparty/CustomFormElements -->
  <script type="text/javascript" src="library/thirdparty/customformelements/cfe-min/cfe.base.js"></script>
  <script type="text/javascript" src="library/thirdparty/customformelements/cfe-min/cfe.replace.js"></script>
  <script type="text/javascript" src="library/thirdparty/customformelements/cfe-min/cfe.module.checkbox.js"></script>
  <script type="text/javascript" src="library/thirdparty/customformelements/cfe-min/cfe.addon.dependencies.js"></script>
  
  <!-- thirdparty/CKEditor -->
  <script type="text/javascript" src="library/thirdparty/ckeditor/ckeditor.js"></script>
  <script type="text/javascript" src="library/thirdparty/ckfinder/ckfinder.js"></script>
  
  <!-- javascripts -->
  <script type="text/javascript" src="library/javascript/adminMenu.js"></script>  
  <script type="text/javascript" src="library/javascript/sidebar.js"></script>
  <script type="text/javascript" src="library/javascript/sidebarMenu.js"></script>  
  <script type="text/javascript" src="library/javascript/sortPages.js"></script>
  <script type="text/javascript" src="library/javascript/setup.js"></script>
  <script type="text/javascript" src="library/javascript/content.js"></script>
  <script type="text/javascript" src="library/javascript/forms.js"></script>
  <script type="text/javascript" src="library/javascript/loading.js"></script>
  <script type="text/javascript" src="library/javascript/ajax.js"></script>
  <script type="text/javascript" src="library/javascript/windowBox.js"></script>
  <script type="text/javascript" src="library/javascript/toolTips.js"></script>
  <script type="text/javascript" src="library/javascript/layoutFix.js"></script>
  <script type="text/javascript" src="library/javascript/editor.js"></script>
  <script type="text/javascript" src="library/javascript/pageThumbnail.js"></script>
    
</head>
<body>
  <div id="dimmContainer">
  </div>
  
  <div id="windowBoxContainer">
    <div id="windowBox">
      <div class="boxTop"><?php echo $langFile['txt_loading']; ?><a href="#" onclick="closeWindowBox(false);"></a></div>
      <div id="windowRequestBox"><div id="loadingCircle"></div></div>
      <div class="boxBottom"></div>
    </div>
  </div>

  <!-- ***************************************************************************************** -->
  <!-- ** HEADER ******************************************************************************* -->
  <div id="header">
    <a id="top" name="top" style="visibility:hidden;"></a>
    
    <div id="headerBlock">
          
      <img src="library/image/bg/logo.png" id="logo" title="<?php echo $langFile['txt_logo'].$version[2].' - '.$version[3]; ?>" alt="feindura logo" />
      <div id="version"><?php echo $version[2]; ?></div>
      
      <div id="mainMenu">
        <table>
          <tr>
          <td><a href="?site=home" class="home" title="<?php echo $langFile['btn_home']; ?>"><span><?php echo $langFile['btn_home']; ?></span></a></td>
          <td><a href="?site=pages" class="pages" title="<?php echo $langFile['btn_pages']; ?>"><span><?php echo $langFile['btn_pages']; ?></span></a></td>
          <?php
          // checks if there any modules or plugins, if not dont show the menupoint
          if(folderIsEmpty($adminConfig['basePath'].'addons/')) { ?>
          <td><a href="" class="plugins" title="<?php echo $langFile['btn_addons']; ?>"><span><?php echo $langFile['btn_addons']; ?></span></a></td>
          <?php } ?>
          <td><a href="?site=websiteSetup" class="websiteSetup" title="<?php echo $langFile['btn_settings']; ?>"><span><?php echo $langFile['btn_settings']; ?></span></a></td>
          <td><a href="?site=search" class="search" title="<?php echo $langFile['btn_search']; ?>"><span><?php echo $langFile['btn_search']; ?></span></a></td>
          </tr>
        </table>
                
        <!--
        <ul class="horizontalButtons">
          <li><a href="?site=home" class="home" title="<?php echo $langFile['btn_home']; ?>"><span><?php echo $langFile['btn_home']; ?></span></a></li>
          <li><a href="?site=pages" class="pages" title="<?php echo $langFile['btn_pages']; ?>"><span><?php echo $langFile['btn_pages']; ?></span></a></li>
          <?php
          // checks if there any modules or plugins, if not dont show the menupoint
          if(folderIsEmpty($adminConfig['basePath'].'addons/')) { ?>
          <li><a href="" class="plugins" title="<?php echo $langFile['btn_addons']; ?>"><span><?php echo $langFile['btn_addons']; ?></span></a></li>
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
          <td><a href="?site=adminSetup" class="adminSetup" title="<?php  echo $langFile['btn_adminSetup']; ?>"><span><?php echo $langFile['btn_adminSetup']; ?></span></a></td>
          <td><a href="?site=categorySetup" class="categorySetup" title="<?php  echo $langFile['btn_categorySetup']; ?>"><span><?php echo $langFile['btn_categorySetup']; ?></span></a></td>
          </tr><tr>
          <td><a href="?site=userSetup" onclick="openWindowBox('library/sites/userSetup.php','<?php echo $langFile['btn_userSetup']; ?>',true);return false;" class="userSetup" title="<?php echo $langFile['btn_userSetup']; ?>"><span><?php echo $langFile['btn_userSetup']; ?></span></a></td>
          <td></td>
          </tr>
        </table>
      </div>      
    </div>
    <?php } ?>
    <a href="http://frozeman.de" id="createdBy" title="created by Fabian Vogelsteller [frozeman.de]">&nbsp;</a>
  </div>     
  
  
  <!-- ***************************************************************************************** -->
  <!-- ** MAINBODY ***************************************************************************** -->
  <div id="mainBody">
  
    <!-- ************************************************************************* -->    
    <!-- ** CONTENT ************************************************************** -->
    <div id="content"<?php if(($_GET['site'] == 'pages' || !empty($_GET['page'])) && $_GET['category'] != '') echo ' style="padding-top: 70px;"'; ?>>
      <?php
  
      include('library/content.loader.php');
      
      ?>
      <a href="#top" class="fastUp smoothAnchor" title="<?php echo $langFile['btn_fastUp']; ?>">&nbsp;</a>
    </div>    
    <?php    
    // ---------------------------------------------------------------
    // CHECK to show BUTTONs in subMenu and FooterMenu
    
    // show createPage
    if(($_GET['category'] == 0 && $adminConfig['page']['createPages']) || $categories['id_'.$_GET['category']]['createdelete'])
      $showCreatePage = true;
    else
      $showCreatePage = false;
    
    // show deletePage
    if(empty($_GET['site']) && !empty($_GET['page']) && $_GET['page'] != 'new')
      $showDeletePage = true;
    else
      $showDeletePage = false;
      
    // show pageThumbnailUpload
    if(empty($_GET['site']) && (($_GET['category'] == 0 && $adminConfig['page']['thumbnailUpload']) || $categories['id_'.$_GET['category']]['thumbnail']) && !empty($_GET['page']) &&  $_GET['page'] != 'new')
      $showPageThumbnailUpload = true;
    else
      $showPageThumbnailUpload = false;
    
    // show pageThumbnailDelete
    if(empty($_GET['site']) && !empty($pageContent['thumbnail']))
      $showPageThumbnailDelete = true;
    else
      $showPageThumbnailDelete = false;
      
    // ---------------------------------------------------------------
    // CHECK to show subMenu and FooterMenu
    
    // show subMenu and FooterMenu
    /* if(((empty($_GET['site']) && !empty($_GET['page'])) || $_GET['site'] == 'pages') &&
      ($_GET['category'] == 0 && $adminConfig['page']['createPages']) ||
      $categories['id_'.$_GET['category']]['createdelete'] ||
      (!empty($_GET['page']) && (($_GET['category'] == 0 && $adminConfig['page']['thumbnailUpload']) || $categories['id_'.$_GET['category']]['thumbnail']))) */
    if(($_GET['site'] == 'pages' || !empty($_GET['page'])) && $_GET['category'] != '' && ($showCreatePage || $showPageThumbnailUpload))
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
          
          // create new page
          if($showCreatePage) { ?>
          <li><a href="<?php echo '?category='.$_GET['category'].'&amp;page=new'; ?>" class="createPage toolTip" title="<?php echo $langFile['btn_createPage_title']; ?>::">&nbsp;</a></li>
          <?php
          // deletePage
          if($showDeletePage) { ?>
          <li><a <?php echo 'href="?site=deletePage&amp;category='.$_GET['category'].'&amp;page='.$_GET['page'].'" onclick="openWindowBox(\'library/sites/deletePage.php?category='.$_GET['category'].'&amp;page='.$_GET['page'].'\',\''.$langFile['btn_deletePage'].'\',true);return false;" title="'.$langFile['btn_deletePage_title'].'::"'; ?> class="deletePage toolTip">&nbsp;</a></li>
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
          <li><a <?php echo 'href="?site=pageThumbnailUpload&amp;category='.$_GET['category'].'&amp;page='.$_GET['page'].'" onclick="openWindowBox(\'library/sites/pageThumbnailUpload.php?site='.$_GET['site'].'&amp;category='.$_GET['category'].'&amp;page='.$_GET['page'].'\',\''.$langFile['btn_pageThumbnailUpload'].'\',true);return false;" title="'.$langFile['btn_pageThumbnailUpload_title'].'::"'; ?> class="pageThumbnailUpload toolTip">&nbsp;</a></li>
          <?php
          // pageThumbnailDelete
          if($showPageThumbnailDelete) { ?>
          <li><a <?php echo 'href="?site=pageThumbnailDelete&amp;category='.$_GET['category'].'&amp;page='.$_GET['page'].'" onclick="openWindowBox(\'library/sites/pageThumbnailDelete.php?site='.$_GET['site'].'&amp;category='.$_GET['category'].'&amp;page='.$_GET['page'].'\',\''.$langFile['btn_pageThumbnailDelete'].'\',true);return false;" title="'.$langFile['btn_pageThumbnailDelete_title'].'::"'; ?> class="pageThumbnailDelete toolTip">&nbsp;</a></li>
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
  <!-- ** SIDEBAR ************************************************************** -->
  <!-- requires the <span> tag inside the <li><a> tag for measure the text width -->
  <div id="leftSidebar">
    <?php

    include('library/sidebar.loader.php');
    
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
          
          // create new page
          if($showCreatePage) { ?>
          <li><a href="<?php echo '?category='.$_GET['category'].'&amp;page=new'; ?>" class="createPage toolTip" title="<?php echo $langFile['btn_createPage_title']; ?>::"><span><?php echo $langFile['btn_createPage']; ?></span></a></li>
          <?php
          // deletePage
          if($showDeletePage) { ?>
          <li><a <?php echo 'href="?site=deletePage&amp;category='.$_GET['category'].'&amp;page='.$_GET['page'].'" onclick="openWindowBox(\'library/sites/deletePage.php?category='.$_GET['category'].'&amp;page='.$_GET['page'].'\',\''.$langFile['btn_deletePage'].'\');return false;" title="'.$langFile['btn_deletePage_title'].'::"'; ?> class="deletePage toolTip"><span><?php echo $langFile['btn_deletePage']; ?></span></a></li>
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
          <li><a <?php echo 'href="?site=pageThumbnailUpload&amp;category='.$_GET['category'].'&amp;page='.$_GET['page'].'" onclick="openWindowBox(\'library/sites/pageThumbnailUpload.php?site='.$_GET['site'].'&amp;category='.$_GET['category'].'&amp;page='.$_GET['page'].'\',\''.$langFile['btn_pageThumbnailUpload'].'\');return false;" title="'.$langFile['btn_pageThumbnailUpload_title'].'::"'; ?> class="pageThumbnailUpload toolTip"><span><?php echo $langFile['btn_pageThumbnailUpload']; ?></span></a></li>
          <?php
          // pageThumbnailDelete
          if($showPageThumbnailDelete) { ?>
          <li><a <?php echo 'href="?site=pageThumbnailDelete&amp;category='.$_GET['category'].'&amp;page='.$_GET['page'].'" onclick="openWindowBox(\'library/sites/pageThumbnailDelete.php?site='.$_GET['site'].'&amp;category='.$_GET['category'].'&amp;page='.$_GET['page'].'\',\''.$langFile['btn_pageThumbnailDelete'].'\');return false;" title="'.$langFile['btn_pageThumbnailDelete_title'].'::"'; ?> class="pageThumbnailDelete toolTip"><span><?php echo $langFile['btn_pageThumbnailDelete']; ?></span></a></li>
          <?php }          
            $showSpacer = true;
          }           
          ?>          
        </ul>
        <?php } ?>
      </div>
    
      <div id="copyright">
        <span class="logoname">fein<span>dura</span></span> - Flat File Content Management System, Copyright &copy; 2009 <a href="http://frozeman.de">Fabian Vogelsteller</a> - <span class="logoname">fein<span>dura</span></span> is published under the <a href="license.txt">GNU General Public License, version 3</a>
      </div>
    </div>
  </div>

</body>
</html>