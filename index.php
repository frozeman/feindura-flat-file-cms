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
 * @version 2.1
 */

/**
 * Includes the login and ALSO the backend.include.php
 */
require_once(dirname(__FILE__)."/library/includes/secure.include.php");

/**
 * Includes the process loader, used to process the sites
 */
require_once(dirname(__FILE__)."/library/processes.loader.php");

// VARs
// -----------------------------------------------------------------------------------
// store the current location, this will be used when the user comes back from the frontend
$_SESSION['feindura']['session']['currentBackendLocation'] = (strpos($_SERVER['REQUEST_URI'],'?site=') !== false && strpos($_SERVER['REQUEST_URI'],'&') !== false) ? substr($_SERVER['REQUEST_URI'],0,strpos($_SERVER['REQUEST_URI'],'&')) : $_SERVER['REQUEST_URI'];

// if feindura starts first set page to 'dashboard'
if(empty($_GET['site']) && empty($_GET['category']) && empty($_GET['page']))
  $_GET['site'] = 'dashboard';

?>
<!DOCTYPE html>
<html lang="<?= $_SESSION['feindura']['language']; ?>" xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta charset="UTF-8" />
  <meta http-equiv="content-type" value="text/html; charset=UTF-8" />
  <meta http-equiv="content-language" content="<?php echo $_SESSION['feindura']['language']; ?>" />
  
  <title>feindura: <?php echo $websiteConfig['title']; ?></title>
  
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <meta name="viewport" content="width=device-width, initial-scale=0.5" />
  
  <meta name="robots" content="no-index,nofollow" />
  <meta http-equiv="pragma" content="no-cache" /> <!--browser/proxy dont cache-->
  <meta http-equiv="cache-control" content="no-cache" /> <!--proxy dont cache-->
  <meta http-equiv="accept-encoding" content="gzip, deflate" />
  
  <meta name="title" content="feindura: <?php echo $websiteConfig['title']; ?>" />    
  <meta name="author" content="Fabian Vogelsteller [frozeman.de]" />     
  <meta name="publisher" content="Fabian Vogelsteller [frozeman.de]" />
  <meta name="copyright" content="Fabian Vogelsteller [frozeman.de]" />    
  <meta name="description" content="A flat file based Content Management System, written in PHP" />    
  <meta name="keywords" content="cms,flat,file,content,management,system" /> 
   
  <link rel="shortcut icon" href="favicon.ico" />
  
  <!-- ************************************************************************************************************ -->
  <!-- STYLESHEETS -->
  
  <!-- thirdparty/CodeMirror -->
  <link rel="stylesheet" type="text/css" href="library/thirdparty/CodeMirror/codemirror-unified.css" />
  
  <!-- feindura styles -->
  <link rel="stylesheet" type="text/css" href="library/styles/reset.css<?= '?v='.BUILD; ?>" />
  <link rel="stylesheet" type="text/css" href="library/styles/layout.css<?= '?v='.BUILD; ?>" />
  <link rel="stylesheet" type="text/css" href="library/styles/content.css<?= '?v='.BUILD; ?>" />
  <link rel="stylesheet" type="text/css" href="library/styles/windowBox.css<?= '?v='.BUILD; ?>" />
  <link rel="stylesheet" type="text/css" href="library/styles/shared.css<?= '?v='.BUILD; ?>" />
<?php
if($_GET['site'] == 'addons') {  
  if($addonStyles = GeneralFunctions::createStyleTags(dirname(__FILE__).'/addons/')) {
    echo "\n  <!-- addons stylesheets -->\n";
    echo $addonStyles;
  }
}
?>  
  <!--[if IE 6]><link rel="stylesheet" type="text/css" href="library/styles/ie6.css" /><![endif]-->
  <!--[if IE 7]><link rel="stylesheet" type="text/css" href="library/styles/ie7.css" /><![endif]-->
  
  <noscript>
  <link rel="stylesheet" type="text/css" href="library/styles/noJavascript.css" media="screen" />
  </noscript>
  
  <!-- ************************************************************************************************************ -->
  <!-- JAVASCRIPT -->

  <!-- thirdparty/MooTools -->
  <script type="text/javascript" src="library/thirdparty/javascripts/mootools-core-1.3.2.js"></script>
  <script type="text/javascript" src="library/thirdparty/javascripts/mootools-more-1.3.2.1.js"></script>
  
  <!-- thirdparty/Raphael -->
  <script type="text/javascript" src="library/thirdparty/javascripts/raphael-1.5.2.js"></script>
  
  <!-- javascripts (only loading.js is up here, so the loading box appears soon) -->
  <script type="text/javascript" src="library/javascripts/loading.js<?= '?v='.BUILD; ?>"></script>
  
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
  <script type="text/javascript" src="library/thirdparty/ckeditor/ckeditor.js<?= '?v='.BUILD; ?>"></script>
  
  <!-- thirdparty/MooRTE -->
  <script type="text/javascript" src="library/thirdparty/MooRTE/Source/moorte.js<?= '?v='.BUILD; ?>"></script>
<?php
  }
  if($adminConfig['user']['fileManager'] && ($_GET['site'] == 'pages' || !empty($_GET['page']))) { ?>
  
  <!-- thirdparty/MooTools-FileManager -->
  <script type="text/javascript" src="library/thirdparty/MooTools-FileManager/Source/FileManager.js<?= '?v='.BUILD; ?>"></script>
  <script type="text/javascript" src="library/thirdparty/MooTools-FileManager/Source/Uploader/Fx.ProgressBar.js"></script>
  <script type="text/javascript" src="library/thirdparty/MooTools-FileManager/Source/Uploader/Swiff.Uploader.js"></script>
  <script type="text/javascript" src="library/thirdparty/MooTools-FileManager/Source/Uploader.js"></script>
  <script type="text/javascript" src="library/thirdparty/MooTools-FileManager/Language/Language.<?= $_SESSION['feindura']['language']; ?>.js"></script>
<?php } ?>
 
  <!-- javascripts -->
  <script type="text/javascript" src="library/javascripts/shared.js<?= '?v='.BUILD; ?>"></script>
  <script type="text/javascript" src="library/javascripts/windowBox.js<?= '?v='.BUILD; ?>"></script>
  <script type="text/javascript" src="library/javascripts/content.js<?= '?v='.BUILD; ?>"></script>
  
  <script type="text/javascript">
  /* <![CDATA[ */
  // transport feindura PHP vars to javascript
  var feindura_basePath = '<?= $adminConfig['basePath']; ?>';
  var feindura_langFile = {
    ERRORWINDOW_TITLE:                "<?= $langFile['errorWindow_h1']; ?>",
    ERROR_SAVE:                       "<?= $langFile['editor_savepage_error_save']; ?>",
    CKEDITOR_TITLE_LINKS:             "<?= (!empty($langFile['CKEDITOR_TITLE_LINKS'])) ? $langFile['CKEDITOR_TITLE_LINKS'] : 'feindura pages'; ?>"
  };
  
  /* transport for CKEditor feindura links */
  <?php
  if(!empty($_GET['page'])) {
    $getPages = GeneralFunctions::loadPages(true,true);
  ?>
var feindura_pages = [
['-',''],
<?php foreach($getPages as $getPage) {
    echo "['".str_replace("'",'',$getPage['title'])."','".$adminConfig['websitePath']."?page=".$getPage['id']."'],\n";
    } ?>  ];
  <?php } ?>
  
  window.addEvent('domready', function () {
    <?php if(($_GET['site'] == 'pages' || !empty($_GET['page'])) && $adminConfig['user']['fileManager']) { ?>
    // ->> include filemanager
    var hideFileManager = function(){this.hide();}
    var fileManager = new FileManager({
        url: 'library/processes/filemanager.process.php',
        assetBasePath: 'library/thirdparty/MooTools-FileManager/Assets',
        language: '<?= $_SESSION["feindura"]["language"]; ?>',
        destroy: true,
        upload: true,
        move_or_copy: true,
        rename: true,
        createFolders: true,
        download: true,
        hideOnClick: true,
        hideOverlay: true,
        hideQonDelete: false,
        listPaginationSize: 100,
        detailInfoMode: false,
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
    
    if(!empty($userConfig)) {
    ?>
    // ->> starts the session counter
    var div = $('sessionTimer'),
    coundown = new CountDown({
      //initialized 30s from now
      date: new Date(<?= $_SESSION['feindura']['session']['end'].'000'; ?>),
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
  <div id="loadingBox">
    <div class="top"></div>
    <div class="content">
    </div>
    <div class="bottom"></div>
  </div>
  
  <div id="windowBoxContainer">
    <div id="windowBox">
      <div class="boxTop"><?php echo $langFile['LOADING_TEXT_LOAD']; ?><a href="#" onclick="closeWindowBox(false);return false;"></a></div>
      <div id="windowRequestBox"></div>
      <div class="boxBottom"></div>
    </div>
  </div>

  <!-- ***************************************************************************************** -->
  <!-- ** HEADER ******************************************************************************* -->
  <div id="header">
    <div id="sessionTimer" class="toolTip blue" title="<?= $langFile['LOGIN_TIP_AUTOLOGOUT']; ?>::"></div>
    <a id="top" name="top" class="anchorTarget"></a>
    
    <div id="headerBlock">
      
      <a href="index.php?logout"  tabindex="1" class="logout toolTip" title="<?= $langFile['HEADER_BUTTON_LOGOUT']; ?>"></a>
      <a href="<?= $adminConfig['url'].$adminConfig['websitePath']; ?>"  tabindex="2" class="toWebsite toolTip" title="<?= $langFile['HEADER_BUTTON_GOTOWEBSITE']; ?>"></a>
      
      <div id="languageSelection">        
        <a href="<?= (strpos($_SERVER['REQUEST_URI'],'?site=') !== false && strpos($_SERVER['REQUEST_URI'],'&') !== false) ? substr($_SERVER['REQUEST_URI'],0,strpos($_SERVER['REQUEST_URI'],'&')) : $_SERVER['REQUEST_URI']; ?><?= (strpos($_SERVER['REQUEST_URI'],'?') === false) ? '?' : '&'; ?>language=de" tabindex="20" class="de toolTip" title="deutsch::"></a>
        <a href="<?= (strpos($_SERVER['REQUEST_URI'],'?site=') !== false && strpos($_SERVER['REQUEST_URI'],'&') !== false) ? substr($_SERVER['REQUEST_URI'],0,strpos($_SERVER['REQUEST_URI'],'&')) : $_SERVER['REQUEST_URI']; ?><?= (strpos($_SERVER['REQUEST_URI'],'?') === false) ? '?' : '&'; ?>language=en" tabindex="21" class="en toolTip" title="english::"></a>
        <a href="<?= (strpos($_SERVER['REQUEST_URI'],'?site=') !== false && strpos($_SERVER['REQUEST_URI'],'&') !== false) ? substr($_SERVER['REQUEST_URI'],0,strpos($_SERVER['REQUEST_URI'],'&')) : $_SERVER['REQUEST_URI']; ?><?= (strpos($_SERVER['REQUEST_URI'],'?') === false) ? '?' : '&'; ?>language=fr" tabindex="22" class="fr toolTip" title="français::"></a>
      </div>
      
      <h1 style="display:none;">feindura - flat file cms</h1><!-- just for the outline of the HTML page -->
      <div id="logo"></div>
      <div id="version" class="toolTip" title="<?php echo $langFile['LOGO_TEXT'].' '.VERSION.' - Build '.BUILD; ?>::"><?= VERSION; ?></div>
      
      <div id="mainMenu"<?php if(!isAdmin()) echo ' style="width:830px"'; ?>>
        <table>
          <tr>
          <td><a href="?site=dashboard" tabindex="3" class="dashboard<?php if($_GET['site'] == 'dashboard') echo ' active'; ?>" title="<?php echo $langFile['BUTTON_DASHBOARD']; ?>"><span><?php echo $langFile['BUTTON_DASHBOARD']; ?></span></a></td>
          <td><a href="?site=pages" tabindex="4" class="pages<?php if($_GET['site'] == 'pages' || !empty($_GET['page'])) echo ' active'; ?>" title="<?php echo $langFile['BUTTON_PAGES']; ?>"><span><?php echo $langFile['BUTTON_PAGES']; ?></span></a></td>
          <?php
          // CHECKS if the addons/ folder is empty
          if(!GeneralFunctions::folderIsEmpty(dirname(__FILE__).'/addons/')) { ?>
          <td><a href="?site=addons" tabindex="5" class="addons<?php if($_GET['site'] == 'addons') echo ' active'; ?>" title="<?php echo $langFile['BUTTON_ADDONS']; ?>"><span><?php echo $langFile['BUTTON_ADDONS']; ?></span></a></td>
          <?php } ?>
          <td><a href="?site=websiteSetup" tabindex="4" class="websiteSetup<?php if($_GET['site'] == 'websiteSetup') echo ' active'; ?>" title="<?php echo $langFile['BUTTON_WEBSITESETTINGS']; ?>"><span><?php echo $langFile['BUTTON_WEBSITESETTINGS']; ?></span></a></td>
          <td><a href="?site=search" tabindex="6" class="search<?php if($_GET['site'] == 'search') echo ' active'; ?>" title="<?php echo $langFile['BUTTON_SEARCH']; ?>"><span><?php echo $langFile['BUTTON_SEARCH']; ?></span></a></td>
          </tr>
        </table>
      </div>
    </div>
    
    <!-- ADMIN-SPACE -->
    <?php if(isAdmin()) { ?>
    <div id="adminMenu">
      <?php // show the admin part if the user is admin, or no other user is admin, administrator, root or superuser
      ?>
      <h2><?php echo $langFile['HEADER_TITLE_ADMINMENU']; ?></h2>
      <div class="content">
        <table>
          <tr>
          <td><a href="?site=adminSetup" tabindex="10" class="adminSetup<?php if($_GET['site'] == 'adminSetup') echo ' active'; ?>" title="<?php  echo $langFile['BUTTON_ADMINSETUP']; ?>"><span><?php echo $langFile['BUTTON_ADMINSETUP']; ?></span></a></td>
          <td><a href="?site=pageSetup" tabindex="11" class="pageSetup<?php if($_GET['site'] == 'pageSetup') echo ' active'; ?>" title="<?php  echo $langFile['BUTTON_PAGESETUP']; ?>"><span><?php echo $langFile['BUTTON_PAGESETUP']; ?></span></a></td>
          </tr><tr>
          <td><a href="?site=userSetup" tabindex="12" class="userSetup<?php if($_GET['site'] == 'userSetup') echo ' active'; ?>" title="<?php echo $langFile['BUTTON_USERSETUP']; ?>"><span><?php echo $langFile['BUTTON_USERSETUP']; ?></span></a></td>
          <td><a href="?site=backup" tabindex="13" class="backup<?php if($_GET['site'] == 'backup') echo ' active'; ?>" title="<?php echo $langFile['BUTTON_BACKUP']; ?>"><span><?php echo $langFile['BUTTON_BACKUP']; ?></span></a></td>
          </tr><tr>
          <td><a href="?site=statisticSetup" tabindex="14" class="statisticSetup<?php if($_GET['site'] == 'statisticSetup') echo ' active'; ?>" title="<?php  echo $langFile['BUTTON_STATISTICSETUP']; ?>"><span><?php echo $langFile['BUTTON_STATISTICSETUP']; ?></span></a></td>
          <?php
          // CHECKS if one of the plugins/ or modules/ folders is empty
          if(!GeneralFunctions::folderIsEmpty(dirname(__FILE__).'/plugins/') || !GeneralFunctions::folderIsEmpty(dirname(__FILE__).'/modules/')) { ?>
          <?php
          // CHECKS if the plugins/ folder is empty
          if(!GeneralFunctions::folderIsEmpty(dirname(__FILE__).'/plugins/')) { ?>
          <td><a href="?site=pluginSetup" tabindex="14" class="pluginSetup<?php if($_GET['site'] == 'pluginSetup') echo ' active'; ?>" title="<?php  echo $langFile['BUTTON_PLUGINSETUP']; ?>"><span><?php echo $langFile['BUTTON_PLUGINSETUP']; ?></span></a></td>
          </tr>
          <?php }
          // CHECKS if the modlues/ folder is empty
          if(!GeneralFunctions::folderIsEmpty(dirname(__FILE__).'/modules/')) { ?>
          <tr>
          <td><a href="?site=modulSetup" tabindex="15" class="modulSetup<?php if($_GET['site'] == 'modulSetup') echo ' active'; ?>" title="<?php  echo $langFile['btn_modulSetup']; ?>"><span><?php echo $langFile['btn_modulSetup']; ?></span></a></td>
          <td</td>
          <?php }
          } ?>
          </tr>       
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
    <div class="feindura_top"><?php echo $langFile['errorWindow_h1'];?></div>
    <div class="feindura_content feindura_warning">
      <div class="scroll"><?php echo $errorWindow; ?></div>
      <a href="?site=<?php echo $_GET['site'] ?>" onclick="$('feindura_errorWindow').fade('out');return false;" class="feindura_ok"></a>
    </div>
    <div class="feindura_bottom"></div>
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
    
    $showFrontendEditing = ($newPage || $_GET['site'] == 'pages') ? false : true;
    
    // -> CHECK if show pageThumbnailUpload
    $showPageThumbnailUpload = (!$newPage &&
                                empty($_GET['site']) && !empty($_GET['page']) &&
                                (($_GET['category'] === 0 && $adminConfig['pages']['thumbnails']) || $categoryConfig[$_GET['category']]['thumbnail'])) ? true : false;

    
    // -> CHECK if show pageThumbnailDelete
    $showPageThumbnailDelete = (empty($_GET['site']) && !empty($pageContent['thumbnail'])) ? true : false;
    
    // -> CHECK if show SUB- FOOTERMENU
    $showSubFooterMenu = (($_GET['site'] == 'pages' || !empty($_GET['page'])) && 
       ($showPageThumbnailUpload || $showCreatePage || $showPageThumbnailUpload || $adminConfig['user']['fileManager'])) ? true : false;
      
     // -> CHEACK if show DELETE PAGE
    $showDeletePage = (!$newPage && empty($_GET['site']) && !empty($_GET['page']) && $_GET['page'] != 'new') ? true : false;
    
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
    <div id="content"<?php if($showSubFooterMenu) echo 'class="hasSubMenu"'; ?>>
      <!-- ************************************************************************* -->
      <!-- ** SUBMENU ************************************************************** -->
      <?php if($showSubFooterMenu) { ?>
      <div class="subMenu">
        <div class="left"></div>
        <div class="content">
          <ul class="horizontalButtons">         
            <?php
            $showSpacer = false;
            
            // frontend editing
            if($showFrontendEditing) { ?>
              <li><a <?php echo 'href="'.$adminConfig['url'].$adminConfig['websitePath'].'?'.$adminConfig['varName']['category'].'='.$_GET['category'].'&amp;'.$adminConfig['varName']['page'].'='.$_GET['page'].'" title="'.$langFile['BUTTON_TOOLTIP_FRONTENDEDITPAGE'].'::"'; ?> tabindex="30" class="editPage toolTip">&nbsp;</a></li>
            <?php
              $showSpacer = true;
            }
            // create new page
            if($showCreatePage) { ?>
              <li><a href="<?php echo '?category='.$_GET['category'].'&amp;page=new'; ?>" tabindex="31" class="createPage toolTip" title="<?php echo $langFile['BUTTON_TOOLTIP_CREATEPAGE']; ?>::">&nbsp;</a></li>
            <?php
            // deletePage
            if($showDeletePage) { ?>
              <li><a <?php echo 'href="?site=deletePage&amp;category='.$_GET['category'].'&amp;page='.$_GET['page'].'" onclick="openWindowBox(\'library/sites/windowBox/deletePage.php?category='.$_GET['category'].'&amp;page='.$_GET['page'].'\',\''.$langFile['BUTTON_DELETEPAGE'].'\',true);return false;" title="'.$langFile['BUTTON_TOOLTIP_DELETEPAGE'].'::"'; ?> tabindex="32" class="deletePage toolTip">&nbsp;</a></li>
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
              <li><a <?php echo 'href="?site=pageThumbnailUpload&amp;category='.$_GET['category'].'&amp;page='.$_GET['page'].'" onclick="openWindowBox(\'library/sites/windowBox/pageThumbnailUpload.php?site='.$_GET['site'].'&amp;category='.$_GET['category'].'&amp;page='.$_GET['page'].'\',\''.$langFile['BUTTON_THUMBNAIL_UPLOAD'].'\',true);return false;" title="'.$langFile['BUTTON_TOOLTIP_THUMBNAIL_UPLOAD'].'::"'; ?> tabindex="33" class="pageThumbnailUpload toolTip">&nbsp;</a></li>
            <?php
            // pageThumbnailDelete
            if($showPageThumbnailDelete) { ?>
              <li><a <?php echo 'href="?site=pageThumbnailDelete&amp;category='.$_GET['category'].'&amp;page='.$_GET['page'].'" onclick="openWindowBox(\'library/sites/windowBox/pageThumbnailDelete.php?site='.$_GET['site'].'&amp;category='.$_GET['category'].'&amp;page='.$_GET['page'].'\',\''.$langFile['BUTTON_THUMBNAIL_DELETE'].'\',true);return false;" title="'.$langFile['BUTTON_TOOLTIP_THUMBNAIL_DELETE'].'::"'; ?> tabindex="34" class="pageThumbnailDelete toolTip">&nbsp;</a></li>
            <?php }          
              $showSpacer = true;
            }
            
            if($showSpacer && ($showPageThumbnailUpload || $adminConfig['user']['fileManager'])) { ?>
              <li class="spacer">&nbsp;</li>
            <?php 
              $showSpacer = false;
            } 
            
            // file manager
            if($adminConfig['user']['fileManager']) { ?>
              <li><a href="?site=fileManager" tabindex="35" class="fileManager toolTip" title="<?php echo $langFile['BUTTON_TOOLTIP_FILEMANAGER']; ?>::">&nbsp;</a></li>
            <?php
              $showSpacer = true;
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
      <div id="footerMenu">
        <?php if($showSubFooterMenu) { /* show only when the editor is open */ ?>
        <ul class="horizontalButtons">
          <?php
          $showSpacer = false;
          
          // frontend editing
          if($showFrontendEditing) { ?>
            <li><a <?php echo 'href="'.$adminConfig['url'].$adminConfig['websitePath'].'?'.$adminConfig['varName']['category'].'='.$_GET['category'].'&amp;'.$adminConfig['varName']['page'].'='.$_GET['page'].'" title="'.$langFile['BUTTON_TOOLTIP_FRONTENDEDITPAGE'].'::"'; ?> class="editPage toolTip"><span><?php echo $langFile['BUTTON_FRONTENDEDITPAGE']; ?></span></a></li>
          <?php
          $showSpacer = true;
          }
          // create new page
          if($showCreatePage) { ?>
            <li><a href="<?php echo '?category='.$_GET['category'].'&amp;page=new'; ?>" class="createPage toolTip" title="<?php echo $langFile['BUTTON_TOOLTIP_CREATEPAGE']; ?>::"><span><?php echo $langFile['BUTTON_CREATEPAGE']; ?></span></a></li>
          <?php
          // deletePage
          if($showDeletePage) { ?>
            <li><a <?php echo 'href="?site=deletePage&amp;category='.$_GET['category'].'&amp;page='.$_GET['page'].'" onclick="openWindowBox(\'library/sites/windowBox/deletePage.php?category='.$_GET['category'].'&amp;page='.$_GET['page'].'\',\''.$langFile['BUTTON_DELETEPAGE'].'\');return false;" title="'.$langFile['BUTTON_TOOLTIP_DELETEPAGE'].'::"'; ?> class="deletePage toolTip"><span><?php echo $langFile['BUTTON_DELETEPAGE']; ?></span></a></li>
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
            <li><a <?php echo 'href="?site=pageThumbnailUpload&amp;category='.$_GET['category'].'&amp;page='.$_GET['page'].'" onclick="openWindowBox(\'library/sites/windowBox/pageThumbnailUpload.php?site='.$_GET['site'].'&amp;category='.$_GET['category'].'&amp;page='.$_GET['page'].'\',\''.$langFile['BUTTON_THUMBNAIL_UPLOAD'].'\');return false;" title="'.$langFile['BUTTON_TOOLTIP_THUMBNAIL_UPLOAD'].'::"'; ?> class="pageThumbnailUpload toolTip"><span><?php echo $langFile['BUTTON_THUMBNAIL_UPLOAD']; ?></span></a></li>
          <?php
          // pageThumbnailDelete
          if($showPageThumbnailDelete) { ?>
            <li><a <?php echo 'href="?site=pageThumbnailDelete&amp;category='.$_GET['category'].'&amp;page='.$_GET['page'].'" onclick="openWindowBox(\'library/sites/windowBox/pageThumbnailDelete.php?site='.$_GET['site'].'&amp;category='.$_GET['category'].'&amp;page='.$_GET['page'].'\',\''.$langFile['BUTTON_THUMBNAIL_DELETE'].'\');return false;" title="'.$langFile['BUTTON_TOOLTIP_THUMBNAIL_DELETE'].'::"'; ?> class="pageThumbnailDelete toolTip"><span><?php echo $langFile['BUTTON_THUMBNAIL_DELETE']; ?></span></a></li>
          <?php }          
            $showSpacer = true;
          }
          
          if($showSpacer && ($showPageThumbnailUpload || $adminConfig['user']['fileManager'])) { ?>
            <li class="spacer">&nbsp;</li>
          <?php
            $showSpacer = false;
          }
          
          // file manager
          if($adminConfig['user']['fileManager']) { ?>
            <li><a href="?site=fileManager" class="fileManager toolTip" title="<?php echo $langFile['BUTTON_TOOLTIP_FILEMANAGER']; ?>::"><span><?php echo $langFile['BUTTON_FILEMANAGER']; ?></span></a></li>
          <?php
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