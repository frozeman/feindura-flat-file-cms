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
 * @version 2.3
 */

/**
 * Includes the login and ALSO the backend.include.php
 */
require_once(dirname(__FILE__)."/library/includes/secure.include.php");

/**
 * Includes the process loader, used to process the sites
 */
require_once(dirname(__FILE__)."/library/controller.loader.php");

// VARs
// -----------------------------------------------------------------------------------
// store the current location, this will be used when the user comes back from the frontend
$_SESSION['feinduraSession']['login']['currentBackendLocation'] = (strpos($_SERVER['REQUEST_URI'],'?site=') !== false && strpos($_SERVER['REQUEST_URI'],'&') !== false) ? substr($_SERVER['REQUEST_URI'],0,strpos($_SERVER['REQUEST_URI'],'&')) : $_SERVER['REQUEST_URI'];

// if feindura starts first set page to 'dashboard'
if(empty($_GET['site']) && empty($_GET['category']) && empty($_GET['page']))
  $_GET['site'] = 'dashboard';

?>
<!DOCTYPE html>
<html lang="<?php echo $_SESSION['feinduraSession']['backendLanguage']; ?>">
<head>
  <meta charset="UTF-8">
  
  <title>feindura: <?php
  echo GeneralFunctions::getLocalized($websiteConfig,'title');
  if(isset($_GET['page']) && is_numeric($_GET['page']) && ($pageTitle = GeneralFunctions::readPage($_GET['page'],GeneralFunctions::getPageCategory($_GET['page']))) != false) {
    echo ' - '.GeneralFunctions::getLocalized($pageTitle,'title');
  }
  unset($pageTitle);
  ?></title>
  
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport" content="width=device-width, initial-scale=0.5">
  
  <meta name="robots" content="no-index,nofollow">
  <meta http-equiv="pragma" content="no-cache"> <!--browser/proxy dont cache-->
  <meta http-equiv="cache-control" content="no-cache"> <!--proxy dont cache-->
  <meta http-equiv="accept-encoding" content="gzip, deflate">
  
  <meta name="title" content="feindura: <?php echo GeneralFunctions::getLocalized($websiteConfig,'title'); ?>">    
  <meta name="author" content="Fabian Vogelsteller [frozeman.de]">     
  <meta name="publisher" content="Fabian Vogelsteller [frozeman.de]">
  <meta name="copyright" content="Fabian Vogelsteller [frozeman.de]">    
  <meta name="description" content="A flat file based Content Management System, written in PHP">    
  <meta name="keywords" content="cms,flat,file,content,management,system"> 
   
  <link rel="shortcut icon" href="favicon.ico">
  
  <!-- ************************************************************************************************************ -->
  <!-- STYLESHEETS -->
  
  <!-- thirdparty/CodeMirror -->
  <link rel="stylesheet" type="text/css" href="library/thirdparty/CodeMirror/codemirror-unified.css">
  
  <!-- feindura styles -->
  <link rel="stylesheet" type="text/css" href="library/styles/reset.css<?php echo '?v='.BUILD; ?>">
  <link rel="stylesheet" type="text/css" href="library/styles/layout.css<?php echo '?v='.BUILD; ?>">
  <link rel="stylesheet" type="text/css" href="library/styles/content.css<?php echo '?v='.BUILD; ?>">
  <link rel="stylesheet" type="text/css" href="library/styles/windowBox.css<?php echo '?v='.BUILD; ?>">
  <link rel="stylesheet" type="text/css" href="library/styles/shared.css<?php echo '?v='.BUILD; ?>">
<?php
if($_GET['site'] == 'addons') {  
  if($addonStyles = GeneralFunctions::createStyleTags(dirname(__FILE__).'/addons/')) {
    echo "\n  <!-- addons stylesheets -->\n";
    echo $addonStyles;
  }
}
?>  
  <!--[if IE 6]><link rel="stylesheet" type="text/css" href="library/styles/ie6.css"><![endif]-->
  <!--[if IE 7]><link rel="stylesheet" type="text/css" href="library/styles/ie7.css"><![endif]-->
  
  <noscript>
  <link rel="stylesheet" type="text/css" href="library/styles/noJavascript.css">
  </noscript>
  
  <!-- ************************************************************************************************************ -->
  <!-- JAVASCRIPT -->

  <!-- thirdparty/MooTools -->
  <script type="text/javascript" src="library/thirdparty/javascripts/mootools-core-1.4.5.js"></script>
  <script type="text/javascript" src="library/thirdparty/javascripts/mootools-more-1.4.0.1.js"></script>
  
  <!-- thirdparty/Raphael -->
  <script type="text/javascript" src="library/thirdparty/javascripts/raphael-1.5.2.js"></script>
  
  <!-- thirdparty/AutoGrow [http://cpojer.net/PowerTools/] (need MooTools) -->
  <script type="text/javascript" src="library/thirdparty/javascripts/powertools-1.0.1.js"></script>
  
  <!-- thirdparty/StaticScroller (need MooTools) -->
  <script type="text/javascript" src="library/thirdparty/javascripts/StaticScroller.js"></script>
  
  <!-- thirdparty/FancyForm (need MooTools) -->
  <script type="text/javascript" src="library/thirdparty/javascripts/fancyform.js"></script>
<?php if(!empty($userConfig)) { ?>

  <!-- thirdparty/CountDown (need MooTools) -->
  <script type="text/javascript" src="library/thirdparty/javascripts/CountDown.js"></script>
  
<?php } ?>
  <!-- thirdparty/CodeMirror -->
  <script type="text/javascript" src="library/thirdparty/CodeMirror/codemirror-compressed.js"></script>
  <script type="text/javascript" src="library/thirdparty/CodeMirror/modes-compressed.js"></script>
<?php
  if(!empty($_GET['page'])) { ?>
  
  <!-- thirdparty/CKEditor -->
  <script type="text/javascript" src="library/thirdparty/ckeditor/ckeditor.js<?php echo '?v='.BUILD; ?>"></script>
  
  <!-- thirdparty/MooRTE -->
  <script type="text/javascript" src="library/thirdparty/MooRTE/Source/moorte.min.js<?php echo '?v='.BUILD; ?>"></script>
<?php
  }
  if($adminConfig['user']['fileManager'] && (!empty($_GET['page']) || $_GET['site'] == 'pages' || $_GET['site'] == 'websiteSetup' || $_GET['site'] == 'pageSetup')) { ?>
  
  <!-- thirdparty/MooTools-FileManager -->
  <script type="text/javascript" src="library/thirdparty/MooTools-FileManager/Source/FileManager.js<?php echo '?v='.BUILD; ?>"></script>
  <script type="text/javascript" src="library/thirdparty/MooTools-FileManager/Source/Uploader/Fx.ProgressBar.js"></script>
  <script type="text/javascript" src="library/thirdparty/MooTools-FileManager/Source/Uploader/Swiff.Uploader.js"></script>
  <script type="text/javascript" src="library/thirdparty/MooTools-FileManager/Source/Uploader.js"></script>
  <script type="text/javascript" src="library/thirdparty/MooTools-FileManager/Language/Language.<?php echo $_SESSION['feinduraSession']['backendLanguage']; ?>.js"></script>
<?php } ?>
 
  <!-- javascripts -->
  <script type="text/javascript" src="library/javascripts/shared.js<?php echo '?v='.BUILD; ?>"></script>
  <script type="text/javascript" src="library/javascripts/loading.js<?php echo '?v='.BUILD; ?>"></script>
  <script type="text/javascript" src="library/javascripts/windowBox.js<?php echo '?v='.BUILD; ?>"></script>
  <script type="text/javascript" src="library/javascripts/content.js<?php echo '?v='.BUILD; ?>"></script>
  
  <script type="text/javascript">
  /* <![CDATA[ */
  // transport feindura PHP vars to javascript
  var feindura_basePath = '<?php echo $adminConfig['basePath']; ?>';
  var feindura_langFile = {
    ERRORWINDOW_TITLE:                "<?php echo $langFile['errorWindow_h1']; ?>",
    ERROR_SAVE:                       "<?php echo sprintf($langFile['EDITOR_savepage_error_save'],$adminConfig['realBasePath']); ?>",
    CKEDITOR_TITLE_LINKS:             "<?php echo (!empty($langFile['CKEDITOR_TITLE_LINKS'])) ? $langFile['CKEDITOR_TITLE_LINKS'] : 'feindura pages'; ?>"
  };
  var currentSite = '<?php echo $_GET["site"]; ?>';
  var currentPage = '<?php echo $_GET["page"]; ?>';
  
  /* transport pages for CKEditor feindura links */
  <?php
  if(!empty($_GET['page'])) {
    $getPages = GeneralFunctions::loadPages(true);
  ?>
  var feindura_pages = [
  ['-',''],
  <?php foreach($getPages as $getPage) {
    $categoryText = ($getPage['category'] != 0) ? GeneralFunctions::getLocalized($categoryConfig[$getPage['category']],'name').' » ' : '';
    echo "['".str_replace("'",'',$categoryText.GeneralFunctions::getLocalized($getPage,'title'))."','?feinduraPageID=".$getPage['id']."'],\n";
    } ?>  ];
  <?php } ?>
  
  window.addEvent('domready', function () {
    <?php if($adminConfig['user']['fileManager'] && (!empty($_GET['page']) || $_GET['site'] == 'pages' || $_GET['site'] == 'websiteSetup' || $_GET['site'] == 'pageSetup')) { ?>
    // ->> include filemanager
    var hideFileManager = function(){this.hide();}
    var fileManager = new FileManager({
        url: 'library/controllers/filemanager.controller.php',
        assetBasePath: 'library/thirdparty/MooTools-FileManager/Assets',
        documentRootPath: '<?php echo DOCUMENTROOT; ?>',
        language: '<?php echo $_SESSION["feinduraSession"]["backendLanguage"]; ?>',
        propagateData: {'<?php echo session_name(); ?>':'<?php echo session_id(); ?>'},
        destroy: true,
        upload: true,
        move_or_copy: true,
        rename: true,
        createFolders: true,
        download: true,
        hideOnClick: true,
        hideOverlay: true,
        hideOnDelete: false,
        listType: 'thumb',
        listPaginationSize: 100,
        onShow: function() {
            window.location.hash = '#none';
            $('dimContainer').setStyle('opacity',0);
            $('dimContainer').setStyle('display','block');
            $('dimContainer').set('tween', {duration: 350, transition: Fx.Transitions.Pow.easeOut});
            $('dimContainer').fade('in');
            $('dimContainer').addEvent('click',hideFileManager.bind(this));
          },
        onHide: function() {
            $('dimContainer').removeEvent('click',hideFileManager);
            $('dimContainer').set('tween', {duration: 350, transition: Fx.Transitions.Pow.easeOut});
            $('dimContainer').fade('out');
            $('dimContainer').get('tween').chain(function() {
              $('dimContainer').setStyle('display','none');
            });
          }
    });
    fileManager.filemanager.setStyle('width','75%');
    fileManager.filemanager.setStyle('height','70%');

    // -> open filemanager when button get clicked
    $$('a.fileManager').each(function(fileManagerButton){
      fileManagerButton.addEvent('click',function(e){
        e.stop();
        fileManager.show();
      });
    });
    <?php }
    
    if(!empty($userConfig) && isset($_SESSION['feinduraSession']['login']['end'])) {
    ?>
    // ->> starts the session counter
    var div = $('sessionTimer'),
    coundown = new CountDown({
      //initialized 30s from now
      date: new Date(<?php echo $_SESSION['feinduraSession']['login']['end'].'000'; ?>),
      //update every 100ms
      frequency: 1000,
      //update the div#counter
      onChange: function(counter) {
        var text = '';
        if(counter.hours < 1 && counter.minutes < 10) {
          div.removeClass('blue');
          div.addClass('red');
          div.setStyle('font-weight','bold');
        }
        text += (counter.hours > 9 ? '' : '0') + counter.hours + ':';
        text += (counter.minutes > 9 ? '' : '0') + counter.minutes + ':';
        text += (counter.second > 9 ? '' : '0') + counter.second;
        div.set('text', text);
      },
      //complete
      onComplete: function () {
        window.location = 'index.php?logout';
      }
    })
    <?php } ?>
  })
  /* ]]> */
  </script>
</head>
<body>
  <div id="dimContainer">
  </div>

  <!-- loadingBox -->
  <div id="loadingBox"></div>
  
  <div id="windowBoxContainer">
    <div id="windowBox">
      <h1><?php echo $langFile['LOADING_TEXT_LOAD']; ?></h1>
      <a href="#" class="close" onclick="closeWindowBox(false);return false;"></a>
      <div id="windowRequestBox"></div>
    </div>
  </div>

  <!-- ***************************************************************************************** -->
  <!-- ** HEADER ******************************************************************************* -->
  <div id="header">
    <div id="sessionTimer" class="toolTip blue" title="<?php echo $langFile['LOGIN_TIP_AUTOLOGOUT']; ?>::"></div>
    <a id="top"></a>
    
    <div id="headerBlock">
      
      <a href="index.php?logout"  tabindex="1" class="logout toolTip" title="<?php echo $langFile['HEADER_BUTTON_LOGOUT']; ?>"></a>
      <?php if($adminConfig['user']['frontendEditing']) { ?>
      <a href="<?php echo $adminConfig['url'].$adminConfig['websitePath']; ?>"  tabindex="2" class="toWebsite toolTip" title="<?php echo $langFile['HEADER_BUTTON_GOTOWEBSITE_FRONTENDEDITING']; ?>"></a>
      <?php } ?>

      <div id="languageSelection">        
        <a href="<?php echo GeneralFunctions::addParameterToUrl('backendLanguage','de'); ?>" tabindex="20" class="de toolTip" title="Deutsch::"></a>
        <a href="<?php echo GeneralFunctions::addParameterToUrl('backendLanguage','en'); ?>" tabindex="21" class="en toolTip" title="English::"></a>
        <a href="<?php echo GeneralFunctions::addParameterToUrl('backendLanguage','fr'); ?>" tabindex="22" class="fr toolTip" title="français::"></a>
        <a href="<?php echo GeneralFunctions::addParameterToUrl('backendLanguage','it'); ?>" tabindex="23" class="it toolTip" title="italiano::"></a>
        <a href="<?php echo GeneralFunctions::addParameterToUrl('backendLanguage','ru'); ?>" tabindex="24" class="ru toolTip" title="русский::"></a>
      </div>
      
      <h1 style="display:none;">feindura - flat file cms</h1><!-- just for the outline of the HTML page -->
      <div id="logo"></div>
      <div id="version" class="toolTip" title="<?php echo $langFile['LOGO_TEXT'].' '.VERSION.' - Build '.BUILD; ?>::"><?php echo VERSION; ?></div>
      
      <div id="mainMenu"<?php if(!isAdmin()) echo ' style="width:830px"'; ?>>
        <table>
          <tbody>
            <tr>
            <td><a href="?site=dashboard" tabindex="3" accesskey="d" class="dashboard<?php if($_GET['site'] == 'dashboard') echo ' active'; ?>" title="<?php echo $langFile['BUTTON_DASHBOARD']; ?> (D)"><span><?php echo $langFile['BUTTON_DASHBOARD']; ?></span></a></td>
            <td><a href="?site=pages" tabindex="4" accesskey="p" class="pages<?php if($_GET['site'] == 'pages' || !empty($_GET['page'])) echo ' active'; ?>" title="<?php echo $langFile['BUTTON_PAGES']; ?> (P)"><span><?php echo $langFile['BUTTON_PAGES']; ?></span></a></td>
            <?php
            // CHECKS if the addons/ folder is empty
            if(!GeneralFunctions::folderIsEmpty(dirname(__FILE__).'/addons/')) { ?>
            <td><a href="?site=addons" tabindex="5" accesskey="a" class="addons<?php if($_GET['site'] == 'addons') echo ' active'; ?>" title="<?php echo $langFile['BUTTON_ADDONS']; ?> (A)"><span><?php echo $langFile['BUTTON_ADDONS']; ?></span></a></td>
            <?php } ?>
            <td><a href="?site=websiteSetup" tabindex="6" accesskey="w" class="websiteSetup<?php if($_GET['site'] == 'websiteSetup') echo ' active'; ?>" title="<?php echo $langFile['BUTTON_WEBSITESETTINGS']; ?> (W)"><span><?php echo $langFile['BUTTON_WEBSITESETTINGS']; ?></span></a></td>
            <td><a href="?site=search" tabindex="7" accesskey="s" class="search<?php if($_GET['site'] == 'search') echo ' active'; ?>" title="<?php echo $langFile['BUTTON_SEARCH']; ?> (S)"><span><?php echo $langFile['BUTTON_SEARCH']; ?></span></a></td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
    
    <!-- ADMIN MENU -->
    <?php if(isAdmin()) { ?>
    <div id="adminMenu">
      <?php // show the admin part if the user is admin, or no other user is admin, administrator, root or superuser
      ?>
      <h2><?php echo $langFile['HEADER_TITLE_ADMINMENU']; ?></h2>
      <div class="content">
        <table>
          <tbody>
            <tr>
            <td><a href="?site=adminSetup" tabindex="10" class="adminSetup<?php if($_GET['site'] == 'adminSetup') echo ' active'; ?>" title="<?php  echo $langFile['BUTTON_ADMINSETUP']; ?>"><span><?php echo $langFile['BUTTON_ADMINSETUP']; ?></span></a></td>
            <td><a href="?site=pageSetup" tabindex="11" class="pageSetup<?php if($_GET['site'] == 'pageSetup') echo ' active'; ?>" title="<?php  echo $langFile['BUTTON_PAGESETUP']; ?>"><span><?php echo $langFile['BUTTON_PAGESETUP']; ?></span></a></td>
            </tr><tr>
            <td><a href="?site=statisticSetup" tabindex="12" class="statisticSetup<?php if($_GET['site'] == 'statisticSetup') echo ' active'; ?>" title="<?php  echo $langFile['BUTTON_STATISTICSETUP']; ?>"><span><?php echo $langFile['BUTTON_STATISTICSETUP']; ?></span></a></td>
            <td><a href="?site=backup" tabindex="13" class="backup<?php if($_GET['site'] == 'backup') echo ' active'; ?>" title="<?php echo $langFile['BUTTON_BACKUP']; ?>"><span><?php echo $langFile['BUTTON_BACKUP']; ?></span></a></td>
            </tr>
            <tr>
            <td><a href="?site=userSetup" tabindex="14" class="userSetup<?php if($_GET['site'] == 'userSetup') echo ' active'; ?>" title="<?php echo $langFile['BUTTON_USERSETUP']; ?>"><span><?php echo $langFile['BUTTON_USERSETUP']; ?></span></a></td>
            <?php //}
            // CHECKS if the modlues/ folder is empty
            if(!GeneralFunctions::folderIsEmpty(dirname(__FILE__).'/modules/')) { ?>
            <td><a href="?site=modulSetup" tabindex="15" class="modulSetup<?php if($_GET['site'] == 'modulSetup') echo ' active'; ?>" title="<?php  echo $langFile['btn_modulSetup']; ?>"><span><?php echo $langFile['btn_modulSetup']; ?></span></a></td>
            <?php } ?>
            </tr> 
          </tbody>     
        </table>
      </div>      
    </div>
    <?php } ?>
  </div>     
  
  <!-- ************************************************************************* -->
  <!-- ** DOCUMENT SAVED ******************************************************* -->
  <div id="documentSaved"<?php if($documentSaved === true) echo ' class="saved"'; ?>></div>
  
  <?php if($errorWindow !== false) { ?>
  <!-- ************************************************************************* -->
  <!-- ** ERROR WINDOW ********************************************************* -->    
  <div id="feindura_errorWindow">
    <h1><?php echo $langFile['errorWindow_h1'];?></h1>
    <div class="feindura_content feindura_warning">
      <div class="scroll"><?php echo $errorWindow; ?></div>
      <a href="?site=<?php echo $_GET['site'] ?>" onclick="$('feindura_errorWindow').fade('out');return false;" class="feindura_ok"></a>
    </div>
  </div>  
  <?php } ?>
  
  <!-- ***************************************************************************************** -->
  <!-- ** MAINBODY ***************************************************************************** -->
  <div id="mainBody">
    <?php
    
    // ---------------------------------------------------------------
    // ->> CHECK to show BUTTONs in subMenu and FooterMenu 
     
    // -> CHECK if show createPage
    $generallyCreatePages = false;
    // check if non-category can create pages
    if($adminConfig['pages']['createDelete'])
      $generallyCreatePages = true;
    // if not check if one category can create pages
    else {
      foreach($categoryConfig as $category) {
        if($category['createDelete'])
          $generallyCreatePages = true;
      }
    }
    
    $showCreatePage = ($generallyCreatePages || //&& $_GET['site'] == 'pages'
                       (!empty($_GET['page']) &&
                       ($_GET['category'] === 0 && $adminConfig['pages']['createDelete']) ||
                       ($_GET['category'] !== 0 && $categoryConfig[$_GET['category']]['createDelete']))) ? true : false;
    
     // -> CHECK for DELETE PAGE
    $showDeletePage = ($generallyCreatePages && !$newPage && empty($_GET['site']) && !empty($_GET['page']) && $_GET['page'] != 'new' &&
                       ($_GET['category'] === 0 && $adminConfig['pages']['createDelete']) ||
                       ($_GET['category'] !== 0 && $categoryConfig[$_GET['category']]['createDelete'])) ? true : false;
    
    $isInPageEditor = (isset($_GET['page']) && !$newPage) ? true : false;
    
    // ->CHECK frontend editing
    $showFrontendEditing = ($isInPageEditor && $adminConfig['user']['frontendEditing']) ? true : false;

    // -> CHECK for pageThumbnailUpload
    $showPageThumbnailUpload = (!$newPage &&
                                empty($_GET['site']) && !empty($_GET['page']) &&
                                (($_GET['category'] === 0 && $adminConfig['pages']['thumbnails']) || $categoryConfig[$_GET['category']]['thumbnail'])) ? true : false;

    
    // -> CHECK for pageThumbnailDelete
    $showPageThumbnailDelete = (empty($_GET['site']) && !empty($pageContent['thumbnail'])) ? true : false;
    
    // -> CHECK if show SUBMENU
    $showSubMenu = ((isset($_GET['page']) || $_GET['site'] == 'pages' || $_GET['site'] == 'websiteSetup' || $_GET['site'] == 'pageSetup') && 
       ($showPageThumbnailUpload || $showCreatePage || $showPageThumbnailUpload || $adminConfig['user']['fileManager'] || $showDeletePage)) ? true : false;
      

    // ->> RE-SET CURRENT WEBSITE LANGUAGE based on the pages languages
    if($adminConfig['multiLanguageWebsite']['active']) {

      // -> use the languages of the page
      $currentlanguageSlection = (isset($pageContent['localized'])) ? array_keys($pageContent['localized']) : $adminConfig['multiLanguageWebsite']['languages'];

      // -> add new language to the page languages selection, if $_GET['status'] = "addLanguage"
      if($_GET['status'] == 'addLanguage')
        $currentlanguageSlection = array_unique(array_merge($adminConfig['multiLanguageWebsite']['languages'],array_keys($pageContent['localized'])));
      $_SESSION['feinduraSession']['websiteLanguage'] = in_array($_SESSION['feinduraSession']['websiteLanguage'], $currentlanguageSlection) ? $_SESSION['feinduraSession']['websiteLanguage']: current($currentlanguageSlection);

      // if NEW PAGE, overwrite with the mainLanguage
      if($newPage)
        $currentlanguageSlection = $adminConfig['multiLanguageWebsite']['languages'];

      // find out if there are missing languages
      if($isInPageEditor) {
        $missingLanguages = false;
        foreach ($adminConfig['multiLanguageWebsite']['languages'] as $langCode) {
          if(!isset($pageContent['localized'][$langCode]))
            $missingLanguages[] = $langCode;
        }
      } else
        $missingLanguages = false;
    }
    ?>
    
    <!-- ************************************************************************* -->
    <!-- ** LEFT-SIDEBAR ************************************************************** -->
    <!-- requires the <span> tag inside the <li><a> tag for measure the text width -->
    <div id="leftSidebar">
      <?php
    
      include('library/leftSidebar.loader.php');
      
      ?>
    </div>
    
    <!-- ************************************************************************* -->    
    <!-- ** CONTENT ************************************************************** -->
    <div id="content"<?php if($showSubMenu) echo 'class="hasSubMenu"'; ?>>
      <!-- ************************************************************************* -->
      <!-- ** SUBMENU ************************************************************** -->
      <?php if($showSubMenu) { ?>
      <div class="subMenu">
        <div class="left"></div>
        <div class="content">
          <ul class="horizontalButtons">         
            <?php

            // vars
            $showSpacer = false;

            // FILE MANAGER
            if($adminConfig['user']['fileManager']) { ?>
              <li><a href="?site=fileManager" tabindex="29" class="fileManager toolTip" title="<?php echo $langFile['BUTTON_FILEMANAGER'].'::'.$langFile['BUTTON_TOOLTIP_FILEMANAGER']; ?>">&nbsp;</a></li>
            <?php
              $showSpacer = true;
            }

            // CREATE NEW PAGE
            if($showCreatePage) { 
              if($showSpacer) { ?>
              <li class="spacer">&nbsp;</li>
              <?php } ?>
              <li><a href="<?php echo '?category='.$_GET['category'].'&amp;page=new'; ?>" tabindex="31" class="createPage toolTip" title="<?php echo $langFile['BUTTON_CREATEPAGE'].'::'.$langFile['BUTTON_TOOLTIP_CREATEPAGE']; ?>">&nbsp;</a></li>
            <?php
              $showSpacer = true;
            }
            
            // FRONTEND EDITING
            if($showFrontendEditing) { 
              if($showSpacer) { ?>
              <li class="spacer">&nbsp;</li>
              <?php } ?>
              <li><a <?php echo 'href="'.$adminConfig['url'].$adminConfig['websitePath'].'?'.$adminConfig['varName']['category'].'='.$_GET['category'].'&amp;'.$adminConfig['varName']['page'].'='.$_GET['page'].'" title="'.$langFile['BUTTON_FRONTENDEDITPAGE'].'::'.$langFile['BUTTON_TOOLTIP_FRONTENDEDITPAGE'].'"'; ?> tabindex="30" class="editPage toolTip">&nbsp;</a></li>
            <?php $showSpacer = true;
            }
            // DELETEPAGE
            if($showDeletePage) {
              if($showSpacer) { ?>
              <li class="spacer">&nbsp;</li>
              <?php } ?>
              <li><a <?php echo 'href="?site=deletePage&amp;category='.$_GET['category'].'&amp;page='.$_GET['page'].'" onclick="openWindowBox(\'library/views/windowBox/deletePage.php?category='.$_GET['category'].'&amp;page='.$_GET['page'].'\',\''.$langFile['BUTTON_DELETEPAGE'].'\',true);return false;" title="'.$langFile['BUTTON_DELETEPAGE'].'::'.$langFile['BUTTON_TOOLTIP_DELETEPAGE'].'"'; ?> tabindex="32" class="deletePage toolTip">&nbsp;</a></li>
            <?php $showSpacer = true;
            }       
            
            // PAGETHUMBNAILUPLOAD
            if($showPageThumbnailUpload) {
              if($showSpacer) { ?>
              <li class="spacer">&nbsp;</li>
              <?php } ?>
              <li><a <?php echo 'href="?site=pageThumbnailUpload&amp;category='.$_GET['category'].'&amp;page='.$_GET['page'].'" onclick="openWindowBox(\'library/views/windowBox/pageThumbnailUpload.php?site='.$_GET['site'].'&amp;category='.$_GET['category'].'&amp;page='.$_GET['page'].'\',\''.$langFile['BUTTON_THUMBNAIL_UPLOAD'].'\',true);return false;" title="'.$langFile['BUTTON_THUMBNAIL_UPLOAD'].'::'.$langFile['BUTTON_TOOLTIP_THUMBNAIL_UPLOAD'].'"'; ?> tabindex="33" class="pageThumbnailUpload toolTip">&nbsp;</a></li>
            <?php
            // PAGETHUMBNAILDELETE
            if($showPageThumbnailDelete) { ?>
              <li><a <?php echo 'href="?site=pageThumbnailDelete&amp;category='.$_GET['category'].'&amp;page='.$_GET['page'].'" onclick="openWindowBox(\'library/views/windowBox/pageThumbnailDelete.php?site='.$_GET['site'].'&amp;category='.$_GET['category'].'&amp;page='.$_GET['page'].'\',\''.$langFile['BUTTON_THUMBNAIL_DELETE'].'\',true);return false;" title="'.$langFile['BUTTON_THUMBNAIL_DELETE'].'::'.$langFile['BUTTON_TOOLTIP_THUMBNAIL_DELETE'].'"'; ?> tabindex="34" class="pageThumbnailDelete toolTip">&nbsp;</a></li>
            <?php }
            $showSpacer = true;
            }
            
            // WEBSITE LANGUAGE BUTTONS and SELECTION
            if($adminConfig['multiLanguageWebsite']['active']) {

              // ADD PAGE LANGUAGE
              if($isInPageEditor) {
                if($showSpacer) { ?>
                <li class="spacer">&nbsp;</li>
                <?php } 
                if($missingLanguages) { ?>
                <li><a <?php echo 'href="?site=addPageLanguage&amp;category='.$_GET['category'].'&amp;page='.$_GET['page'].'" onclick="openWindowBox(\'library/views/windowBox/addPageLanguage.php?site='.$_GET['site'].'&amp;category='.$_GET['category'].'&amp;page='.$_GET['page'].'\',\''.$langFile['BUTTON_WEBSITELANGUAGE_ADD'].'\',true);return false;" title="'.$langFile['BUTTON_WEBSITELANGUAGE_ADD'].'::'.$langFile['BUTTON_TOOLTIP_WEBSITELANGUAGE_ADD'].'"'; ?> tabindex="35" class="addPageLanguage toolTip">&nbsp;</a></li>
              <?php
              }
              // DELETE PAGE LANGUAGE
              if(isset($_GET['page']) && !isset($pageContent['localized'][0]) && isset($pageContent['localized'][$_SESSION['feinduraSession']['websiteLanguage']])) { ?>
                <!-- <li class="spacer">&nbsp;</li> -->
                <li><a <?php echo 'href="?site=deletePageLanguage&amp;category='.$_GET['category'].'&amp;page='.$_GET['page'].'&amp;language='.$_SESSION['feinduraSession']['websiteLanguage'].'" onclick="openWindowBox(\'library/views/windowBox/deletePageLanguage.php?site='.$_GET['site'].'&amp;category='.$_GET['category'].'&amp;page='.$_GET['page'].'&amp;language='.$_SESSION['feinduraSession']['websiteLanguage'].'\',\''.$langFile['BUTTON_WEBSITELANGUAGE_DELETE'].'\',true);return false;" title="'.$langFile['BUTTON_WEBSITELANGUAGE_DELETE'].'::'.sprintf($langFile['BUTTON_TOOLTIP_WEBSITELANGUAGE_DELETE'],'[b]'.$languageNames[$_SESSION['feinduraSession']['websiteLanguage']].'[/b]').'"'; ?> tabindex="36" class="removePageLanguage toolTip">&nbsp;</a></li>
              <?php }
              $showSpacer = true;
              }

              // PAGE LANGUAGE SELECTION with
              if(!empty($adminConfig['multiLanguageWebsite']['languages']) && (empty($pageContent) || !empty($pageContent['localized']))) {
                ?>
                <li class="spacer">&nbsp;</li>
                <li>
                  <img src="<?php echo GeneralFunctions::getFlagHref($_SESSION['feinduraSession']['websiteLanguage']); ?>" class="flag" title="<?php echo $languageNames[$_SESSION['feinduraSession']['websiteLanguage']]; ?>">
                  <select name="websiteLanguageSelection" id="websiteLanguageSelection" tabindex="37">
                  <?php
                    // create language selection
                    foreach($currentlanguageSlection as $langCode) {
                      if($newPage || empty($pageContent) || isset($pageContent['localized'][$langCode]) || ($_GET['status'] == 'addLanguage' && $_SESSION['feinduraSession']['websiteLanguage'] == $langCode)) {
                        $selected = ($_SESSION['feinduraSession']['websiteLanguage'] == $langCode) ? ' selected="selected"' : '';
                        echo '<option value="'.$langCode.'"'.$selected.'>'.$languageNames[$langCode].'</option>';
                      }
                    }
                  ?>
                  </select>
              <?php
              }

            }
            ?>          
          </ul>
        </div>        
        <div class="right"></div>
      </div>
      <?php }

      include('library/content.loader.php');
      
      ?>
      <a href="#top" class="fastUp" title="<?php echo $langFile['BUTTON_UP']; ?>">&nbsp;</a>
    </div>
    
    <!-- ************************************************************************* -->
    <!-- ** RIGHT-SIDEBAR ************************************************************** -->
    <!-- requires the <span> tag inside the <li><a> tag for measure the text width -->
    <div id="rightSidebar">
      <?php
  
      include('library/rightSidebar.loader.php');
      
      ?>
    </div>    
  </div> 
  
  <!-- ******************************************************************************************* -->
  <!-- ** FOOTER ********************************************************************************* -->
  <div id="footer">
    <div id="footerBlock">      
      <div id="copyright">
        <span class="logoname">fein<span>dura</span></span> - Flat File Content Management System, Copyright &copy; 2009-<?php echo date('Y'); ?> <a href="http://frozeman.de">Fabian Vogelsteller</a> - <span class="logoname">fein<span>dura</span></span> is published under the <a href="LICENSE">GNU General Public License, version 3</a>
      </div>
    </div>
  </div>
</body>
</html>