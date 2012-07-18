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

?><!DOCTYPE html>
<html lang="<?php echo $_SESSION['feinduraSession']['backendLanguage']; ?>" class="feindura">
<head>
  <meta charset="UTF-8">

  <title>feindura &gt; <?php
  echo GeneralFunctions::getLocalized($websiteConfig,'title');
  if(isset($_GET['page']) && is_numeric($_GET['page']) && ($pageTitle = GeneralFunctions::readPage($_GET['page'],GeneralFunctions::getPageCategory($_GET['page']))) != false) {
    echo ' | '.GeneralFunctions::getLocalized($pageTitle,'title');
  }
  unset($pageTitle);
  ?></title>

  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport" content="width=device-width, initial-scale=0.5">

  <meta name="robots" content="no-index,nofollow">
  <meta http-equiv="pragma" content="no-cache"> <!--browser/proxy dont cache-->
  <meta http-equiv="cache-control" content="no-cache"> <!--proxy dont cache-->
  <meta http-equiv="accept-encoding" content="gzip, deflate">

  <meta name="author" content="Fabian Vogelsteller [frozeman.de]">
  <meta name="publisher" content="Fabian Vogelsteller [frozeman.de]">
  <meta name="copyright" content="Fabian Vogelsteller [frozeman.de]">
  <meta name="description" content="A flat file based Content Management System, written in PHP">
  <meta name="keywords" content="cms,flat,file,content,management,system">

  <link rel="shortcut icon" href="favicon.ico">

  <!-- ************************************************************************************************************ -->
  <!-- STYLESHEETS -->

  <!-- feindura styles -->
  <link rel="stylesheet" type="text/css" href="library/styles/shared.css<?php echo '?v='.BUILD; ?>">

  <link rel="stylesheet" type="text/css" href="library/styles/styles.css<?php echo '?v='.BUILD; ?>">

  <!-- thirdparty/CodeMirror -->
  <link rel="stylesheet" type="text/css" href="library/thirdparty/CodeMirror/codemirror-unified.css">

  <?php
  if($_GET['site'] == 'addons') {
    if($addonStyles = GeneralFunctions::createStyleTags(dirname(__FILE__).'/addons/')) {
      echo "\n  <!-- addons stylesheets -->\n";
      echo $addonStyles;
    }
  }
  ?>
  <!--[if IE 7]><link rel="stylesheet" type="text/css" href="library/styles/ie7.css"><![endif]-->

  <noscript>
  <link rel="stylesheet" type="text/css" href="library/styles/noJavascript.css">
  </noscript>

  <!-- ************************************************************************************************************ -->
  <!-- JAVASCRIPT -->

  <!-- thirdparty/Html5Shiv -->
  <!--[if lt IE 9]><script type="text/javascript" src="library/thirdparty/javascripts/html5shiv.min.js"></script><![endif]-->

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
  if(GeneralFunctions::hasPermission('fileManager') && (!empty($_GET['page']) || $_GET['site'] == 'pages' || $_GET['site'] == 'websiteSetup' || $_GET['site'] == 'pageSetup')) { ?>

  <!-- thirdparty/MooTools-FileManager -->
  <script type="text/javascript" src="library/thirdparty/MooTools-FileManager/Source/FileManager.js<?php echo '?v='.BUILD; ?>"></script>
  <script type="text/javascript" src="library/thirdparty/MooTools-FileManager/Source/Uploader/Fx.ProgressBar.js"></script>
  <script type="text/javascript" src="library/thirdparty/MooTools-FileManager/Source/Uploader/Swiff.Uploader.js"></script>
  <script type="text/javascript" src="library/thirdparty/MooTools-FileManager/Source/Uploader.js"></script>
  <script type="text/javascript" src="library/thirdparty/MooTools-FileManager/Language/Language.<?php echo $_SESSION['feinduraSession']['backendLanguage']; ?>.js"></script>
  <?php } ?>

  <?php if(isset($_GET['page']) && $categoryConfig[$_GET['category']]['showTags']) { ?>
  <!-- thirdparty/TextboxList -->
  <script type="text/javascript" src="library/thirdparty/TextboxList/TextboxList.js<?php echo '?v='.BUILD; ?>"></script>
  <script type="text/javascript" src="library/thirdparty/TextboxList/TextboxList.Autocomplete.js<?php echo '?v='.BUILD; ?>"></script>
  <?php } ?>

  <!-- javascripts -->
  <script type="text/javascript" src="library/javascripts/shared.js<?php echo '?v='.BUILD; ?>"></script>
  <script type="text/javascript" src="library/javascripts/loading.js<?php echo '?v='.BUILD; ?>"></script>
  <script type="text/javascript" src="library/javascripts/windowBox.js<?php echo '?v='.BUILD; ?>"></script>
  <script type="text/javascript" src="library/javascripts/content.js<?php echo '?v='.BUILD; ?>"></script>

  <script type="text/javascript">
  /* <![CDATA[ */

    // -> TRANSPORT feindura PHP VARS to JAVASCRIPT
    var feindura_basePath    = '<?php echo GeneralFunctions::Path2URI($adminConfig['basePath']); ?>';
    var feindura_websitePath = '<?php echo GeneralFunctions::Path2URI(GeneralFunctions::getDirname($adminConfig['websitePath'])); ?>';

    var feindura_langFile    = {
      ERRORWINDOW_TITLE:              "<?php echo $langFile['errorWindow_h1']; ?>",
      ERROR_SAVE:                     "<?php echo sprintf($langFile['EDITOR_savepage_error_save'],$adminConfig['basePath']); ?>",
      CKEDITOR_TITLE_LINKS:           "<?php echo (!empty($langFile['CKEDITOR_TITLE_LINKS'])) ? $langFile['CKEDITOR_TITLE_LINKS'] : 'feindura pages'; ?>",
      CKEDITOR_TITLE_SNIPPETS:        "<?php echo (!empty($langFile['CKEDITOR_TITLE_SNIPPETS'])) ? $langFile['CKEDITOR_TITLE_SNIPPETS'] : 'Snippets'; ?>",
      CKEDITOR_TEXT_SNIPPETS:         "<?php echo (!empty($langFile['CKEDITOR_TEXT_SNIPPETS'])) ? $langFile['CKEDITOR_TEXT_SNIPPETS'] : ''; ?>",
      CKEDITOR_BUTTON_EDITSNIPPET:    "<?php echo (!empty($langFile['CKEDITOR_BUTTON_EDITSNIPPET'])) ? $langFile['CKEDITOR_BUTTON_EDITSNIPPET'] : 'edit snippet'; ?>",
      CKEDITOR_TITLE_PLUGINS:         "<?php echo (!empty($langFile['CKEDITOR_TITLE_PLUGINS'])) ? $langFile['CKEDITOR_TITLE_PLUGINS'] : 'Plugins'; ?>",
      CKEDITOR_TEXT_PLUGINS:          "<?php echo (!empty($langFile['CKEDITOR_TEXT_PLUGINS'])) ? $langFile['CKEDITOR_TEXT_PLUGINS'] : ''; ?>"
    };
    var currentSite = '<?php echo $_GET["site"]; ?>';
    var currentPage = '<?php echo $_GET["page"]; ?>';

    // -> TRANSPORT pages for CKEditor FEINDURA LINKS
    <?php
    if(isset($_GET['page'])) {
      $getPages = GeneralFunctions::loadPages(true);
    ?>
    var feindura_pages = [
      ['-',''],
      <?php foreach($getPages as $getPage) {
      $categoryText = ($getPage['category'] != 0) ? GeneralFunctions::getLocalized($categoryConfig[$getPage['category']],'name').' » ' : '';
      echo "['".str_replace("'",'',$categoryText.GeneralFunctions::getLocalized($getPage,'title'))."','?feinduraPageID=".$getPage['id']."'],\n";
      } ?>  ];
    <?php } ?>

    // -> TRANSPORT Snippets to CKEditor feinduraSnippets plugin
    var feindura_snippets = [
      <?php if($adminConfig['editor']['snippets'] && !empty($_GET['page'])) {
        $snippets = GeneralFunctions::readFolderRecursive(dirname(__FILE__).'/snippets/');
        foreach($snippets['files'] as $snippet) {
          $snippetShort = str_replace($adminConfig['basePath'].'snippets/', '', $snippet);
          echo '["'.$snippetShort.'","'.$snippetShort.'"],';
        }
        unset($snippets,$snippet,$snippetShort);
      } ?>
    ];
    var feindura_snippets_editInWebsiteSettings = <?php echo (GeneralFunctions::hasPermission('editSnippets')) ? 'true' : 'false' ?>;
    var feindura_snippets_isAdmin               = <?php echo (GeneralFunctions::isAdmin()) ? 'true' : 'false' ?>;

    window.addEvent('domready', function () {

      // ->> include FILEMANAGER
      <?php if(GeneralFunctions::hasPermission('fileManager') && (!empty($_GET['page']) || $_GET['site'] == 'pages' || $_GET['site'] == 'websiteSetup' || $_GET['site'] == 'pageSetup')) { ?>
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
              $('dimmContainer').setStyle('opacity',0);
              $('dimmContainer').setStyle('display','block');
              $('dimmContainer').set('tween', {duration: 350, transition: Fx.Transitions.Pow.easeOut});
              $('dimmContainer').fade('in');
              $('dimmContainer').addEvent('click',hideFileManager.bind(this));
            },
          onHide: function() {
              $('dimmContainer').removeEvent('click',hideFileManager);
              $('dimmContainer').set('tween', {duration: 350, transition: Fx.Transitions.Pow.easeOut});
              $('dimmContainer').fade('out');
              $('dimmContainer').get('tween').chain(function() {
                $('dimmContainer').setStyle('display','none');
              });
            }
      });
      fileManager.filemanager.setStyle('width','75%');
      fileManager.filemanager.setStyle('height','70%');

      // -> OPEN FILEMANAGER when button get clicked
      $$('a.fileManager').each(function(fileManagerButton){
        fileManagerButton.addEvent('click',function(e){
          e.stop();
          fileManager.show();
        });
      });
      <?php } ?>

      <?php if(isset($_GET['page']) && $categoryConfig[$_GET['category']]['showTags']) { ?>
      // TEXTBOX LIST (TAG AUTOCOMPLETION)
      if($('edit_tags') !== null) {
        var editableTags = new TextboxList('edit_tags', {
          unique: true,
          inBetweenEditableBits: false,
          // startEditableBit: false,
          bitsOptions: {
            editable: {
              addOnBlur: true,
              stopEnter: true
              // addKeys: [188, 32, 13]
            }
          },
          plugins: {
            autocomplete: {
              placeholder: false,
              showAllValues: true
            }
          }
        });
        editableTags.plugins['autocomplete'].setValues(
          [
          <?php
          foreach ($pagesMetaData as $pageMetaData) {
            foreach ($pageMetaData['localized'] as $langCode => $pageMetaDataLocalized) {
              $tags = explode(',', $pageMetaDataLocalized['tags']);
              foreach($tags as $tag) {
                // add tag only when the current page dont have them
                if(!empty($tag) && !GeneralFunctions::compareTags($pageContent, $tag))
                  echo '["'.$tag.'","'.$tag.'"],';
              }
            }
          }
          ?>
          ]
        );
      }
      <?php } ?>

      <?php
      // ->> STARTS the session COUNTER
      if(!empty($userConfig) && isset($_SESSION['feinduraSession']['login']['end'])) {
      ?>
      var div = $('sessionTimout'),
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
  <div id="dimmContainer">
  </div>

  <!-- loadingBox -->
  <div id="loadingBox"></div>

  <!-- ************************************************************************* -->
  <!-- ** WINDOW BOX *********************************************************** -->
  <div id="windowBox">
    <!-- <h1><?php echo $langFile['LOADING_TEXT_LOAD']; ?></h1> -->
    <a href="#" class="close" onclick="closeWindowBox(false);return false;"></a>
    <div id="windowRequestBox"></div>
  </div>

  <!-- ************************************************************************* -->
  <!-- ** DOCUMENT SAVED ******************************************************* -->
  <div id="documentSaved"<?php if($documentSaved === true) echo ' class="saved"'; ?>></div>

  <!-- ***************************************************************************************** -->
  <!-- ** HEADER ******************************************************************************* -->
  <header class="main">
    <div id="sessionTimout" class="toolTip blue" title="<?php echo $langFile['LOGIN_TIP_AUTOLOGOUT']; ?>::"></div>

    <!-- Top Anchor -->
    <a id="top"></a>

    <div class="menuBlock">

      <a href="index.php?logout"  tabindex="1" class="logout toolTip" title="<?php echo $langFile['HEADER_BUTTON_LOGOUT']; ?>"></a>
      <?php if(GeneralFunctions::hasPermission('frontendEditing')) { ?>
      <a href="<?php echo $adminConfig['url'].GeneralFunctions::Path2URI($adminConfig['websitePath']); ?>"  tabindex="2" class="toWebsite toolTip" title="<?php echo $langFile['HEADER_BUTTON_GOTOWEBSITE_FRONTENDEDITING']; ?>"></a>
      <?php } ?>

      <div class="languageSelection">
        <a href="<?php echo GeneralFunctions::addParameterToUrl('backendLanguage','de'); ?>" tabindex="20" class="de toolTip" title="Deutsch::"></a>
        <a href="<?php echo GeneralFunctions::addParameterToUrl('backendLanguage','en'); ?>" tabindex="21" class="en toolTip" title="English::"></a>
        <a href="<?php echo GeneralFunctions::addParameterToUrl('backendLanguage','fr'); ?>" tabindex="22" class="fr toolTip" title="français::"></a>
        <a href="<?php echo GeneralFunctions::addParameterToUrl('backendLanguage','it'); ?>" tabindex="23" class="it toolTip" title="italiano::"></a>
        <a href="<?php echo GeneralFunctions::addParameterToUrl('backendLanguage','ru'); ?>" tabindex="24" class="ru toolTip" title="русский::"></a>
      </div>

      <h1 style="display:none;">feindura - flat file cms</h1><!-- just for the outline of the HTML page -->
      <a href="http://feindura.org" class="feinduraLogo" target="_blank"></a>
      <div class="feinduraVersion toolTip" title="<?php echo $langFile['LOGO_TEXT'].' '.VERSION.' - Build '.BUILD; ?>::"><?php echo VERSION; ?></div>

      <nav class="mainMenu"<?php if(!GeneralFunctions::isAdmin()) echo ' style="width:830px"'; ?>>
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
      </nav>
    </div>

    <!-- ADMIN MENU -->
    <?php if(GeneralFunctions::isAdmin()) { ?>
    <div id="adminMenu">
      <h2><?php echo $langFile['HEADER_TITLE_ADMINMENU']; ?></h2>
      <table>
        <tbody>
          <tr>
          <td><a href="?site=pageSetup" tabindex="10" class="pageSetup<?php if($_GET['site'] == 'pageSetup') echo ' active'; ?>" title="<?php  echo $langFile['BUTTON_PAGESETUP']; ?>"><span><?php echo $langFile['BUTTON_PAGESETUP']; ?></span></a></td>
          <td><a href="?site=adminSetup" tabindex="11" class="adminSetup<?php if($_GET['site'] == 'adminSetup') echo ' active'; ?>" title="<?php  echo $langFile['BUTTON_ADMINSETUP']; ?>"><span><?php echo $langFile['BUTTON_ADMINSETUP']; ?></span></a></td>
          </tr><tr>
          <td><a href="?site=statisticSetup" tabindex="12" class="statisticSetup<?php if($_GET['site'] == 'statisticSetup') echo ' active'; ?>" title="<?php  echo $langFile['BUTTON_STATISTICSETUP']; ?>"><span><?php echo $langFile['BUTTON_STATISTICSETUP']; ?></span></a></td>
          <td><a href="?site=userSetup" tabindex="13" class="userSetup<?php if($_GET['site'] == 'userSetup') echo ' active'; ?>" title="<?php echo $langFile['BUTTON_USERSETUP']; ?>"><span><?php echo $langFile['BUTTON_USERSETUP']; ?></span></a></td>
          </tr><tr>
          <td><a href="?site=backup" tabindex="14" class="backup<?php if($_GET['site'] == 'backup') echo ' active'; ?>" title="<?php echo $langFile['BUTTON_BACKUP']; ?>"><span><?php echo $langFile['BUTTON_BACKUP']; ?></span></a></td>
          <?php //}
          // CHECKS if the modlues/ folder is empty
          if(!GeneralFunctions::folderIsEmpty(dirname(__FILE__).'/modules/')) { ?>
          <td><a href="?site=modulSetup" tabindex="15" class="modulSetup<?php if($_GET['site'] == 'modulSetup') echo ' active'; ?>" title="<?php  echo $langFile['btn_modulSetup']; ?>"><span><?php echo $langFile['btn_modulSetup']; ?></span></a></td>
          <?php } else { ?>
          <td></td>
          <?php } ?>
          </tr>
        </tbody>
      </table>
    </div>
    <?php } ?>
  </header>

  <!-- ***************************************************************************************** -->
  <!-- ** MAINBODY ***************************************************************************** -->
  <div class="mainBody" role="main">
    <?php

    // ---------------------------------------------------------------
    // ->> CHECK to show BUTTONs in subMenu and FooterMenu

    $generallyCreatePages = false;
    // CHECK if one category can create pages
    if(!empty($categoryConfig)) {
      foreach($categoryConfig as $category) {
        if($category['createDelete'])
          $generallyCreatePages = true;
      }
      unset($category);
    }


    $showCreatePage = ($generallyCreatePages || //&& $_GET['site'] == 'pages'
                       (!empty($_GET['page']) && $categoryConfig[$_GET['category']]['createDelete'])) ? true : false;

     // -> CHECK for DELETE PAGE
    $showDeletePage = ($generallyCreatePages && !$newPage && empty($_GET['site']) && !empty($_GET['page']) && $_GET['page'] != 'new' &&
                       $categoryConfig[$_GET['category']]['createDelete']) ? true : false;

    $isInPageEditor = (isset($_GET['page']) && !$newPage) ? true : false;

    // ->CHECK frontend editing
    $showFrontendEditing = ($isInPageEditor && GeneralFunctions::hasPermission('frontendEditing')) ? true : false;

    // -> CHECK for uploadPageThumbnail
    $showPageThumbnailUpload = (!$newPage &&
                                empty($_GET['site']) && !empty($_GET['page']) &&
                                $categoryConfig[$_GET['category']]['thumbnails']) ? true : false;


    // -> CHECK for deletePageThumbnail
    $showPageThumbnailDelete = (empty($_GET['site']) && !empty($pageContent['thumbnail'])) ? true : false;

    // -> CHECK if show SUBMENU
    $showSubMenu = ((isset($_GET['page']) || $_GET['site'] == 'pages' || $_GET['site'] == 'websiteSetup' || $_GET['site'] == 'pageSetup') &&
       ($showPageThumbnailUpload || $showCreatePage || $showPageThumbnailUpload || GeneralFunctions::hasPermission('fileManager') || $showDeletePage)) ? true : false;


    // ->> RE-SET CURRENT WEBSITE LANGUAGE based on the pages languages
    if($websiteConfig['multiLanguageWebsite']['active']) {

      // -> use the languages of the page
      $currentlanguageSlection = (isset($pageContent['localized'])) ? array_keys($pageContent['localized']) : $websiteConfig['multiLanguageWebsite']['languages'];

      // -> add new language to the page languages selection, if $_GET['status'] = "addLanguage"
      if($_GET['status'] == 'addLanguage' && is_array($pageContent['localized']))
          $currentlanguageSlection = array_unique(array_merge($websiteConfig['multiLanguageWebsite']['languages'],array_keys($pageContent['localized'])));
      $_SESSION['feinduraSession']['websiteLanguage'] = (in_array($_SESSION['feinduraSession']['websiteLanguage'], $currentlanguageSlection)) ? $_SESSION['feinduraSession']['websiteLanguage']: current($currentlanguageSlection);

      // if NEW PAGE, overwrite with the mainLanguage
      if($newPage)
        $currentlanguageSlection = $websiteConfig['multiLanguageWebsite']['languages'];

      // find out if there are missing languages
      if($isInPageEditor) {
        $missingLanguages = false;
        foreach ($websiteConfig['multiLanguageWebsite']['languages'] as $langCode) {
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
      <div class="mainContent<?php if($showSubMenu) echo ' hasSubMenu'; ?>">

        <!-- ************************************************************************* -->
        <!-- ** SUBMENU ************************************************************** -->
        <?php if($showSubMenu) { ?>
          <div class="subMenu">
            <menu class="horizontal">
              <?php

              // vars
              $showSpacer = false;

              // FILE MANAGER
              if(GeneralFunctions::hasPermission('fileManager')) { ?>
                <li><a href="?site=fileManager" tabindex="29" class="fileManager toolTip" title="<?php echo $langFile['BUTTON_FILEMANAGER'].'::'.$langFile['BUTTON_TOOLTIP_FILEMANAGER']; ?>"></a></li>
              <?php
                $showSpacer = true;
              }

              // CREATE NEW PAGE
              if($showCreatePage) {
                if($showSpacer) { ?>
                <li class="spacer"></li>
                <?php } ?>
                <li><a href="<?php echo '?category='.$_GET['category'].'&amp;page=new'; ?>" tabindex="31" class="createPage toolTip" title="<?php echo $langFile['BUTTON_CREATEPAGE'].'::'.$langFile['BUTTON_TOOLTIP_CREATEPAGE']; ?>"></a></li>
              <?php
                $showSpacer = true;
              }

              // FRONTEND EDITING
              if($showFrontendEditing) {
                if($showSpacer) { ?>
                <li class="spacer"></li>
                <?php } ?>
                <li><a <?php echo 'href="'.$adminConfig['url'].GeneralFunctions::Path2URI($adminConfig['websitePath']).'?'.$adminConfig['varName']['category'].'='.$_GET['category'].'&amp;'.$adminConfig['varName']['page'].'='.$_GET['page'].'" title="'.$langFile['BUTTON_FRONTENDEDITPAGE'].'::'.$langFile['BUTTON_TOOLTIP_FRONTENDEDITPAGE'].'"'; ?> tabindex="30" class="editPage toolTip"></a></li>
              <?php $showSpacer = true;
              }
              // DELETEPAGE
              if($showDeletePage) {
                if($showSpacer) { ?>
                <li class="spacer"></li>
                <?php } ?>
                <li><a <?php echo 'href="?site=deletePage&amp;category='.$_GET['category'].'&amp;page='.$_GET['page'].'" onclick="openWindowBox(\'library/views/windowBox/deletePage.php?category='.$_GET['category'].'&amp;page='.$_GET['page'].'\',\''.$langFile['BUTTON_DELETEPAGE'].'\');return false;" title="'.$langFile['BUTTON_DELETEPAGE'].'::'.$langFile['BUTTON_TOOLTIP_DELETEPAGE'].'"'; ?> tabindex="32" class="deletePage toolTip"></a></li>
              <?php $showSpacer = true;
              }

              // PAGETHUMBNAILUPLOAD
              if($showPageThumbnailUpload) {
                if($showSpacer) { ?>
                <li class="spacer"></li>
                <?php } ?>
                <li><a <?php echo 'href="?site=uploadPageThumbnail&amp;category='.$_GET['category'].'&amp;page='.$_GET['page'].'" onclick="openWindowBox(\'library/views/windowBox/uploadPageThumbnail.php?site='.$_GET['site'].'&amp;category='.$_GET['category'].'&amp;page='.$_GET['page'].'\',\''.$langFile['BUTTON_THUMBNAIL_UPLOAD'].'\');return false;" title="'.$langFile['BUTTON_THUMBNAIL_UPLOAD'].'::'.$langFile['BUTTON_TOOLTIP_THUMBNAIL_UPLOAD'].'"'; ?> tabindex="33" class="uploadPageThumbnail toolTip"></a></li>
              <?php
              // PAGETHUMBNAILDELETE
              if($showPageThumbnailDelete) { ?>
                <li><a <?php echo 'href="?site=deletePageThumbnail&amp;category='.$_GET['category'].'&amp;page='.$_GET['page'].'" onclick="openWindowBox(\'library/views/windowBox/deletePageThumbnail.php?site='.$_GET['site'].'&amp;category='.$_GET['category'].'&amp;page='.$_GET['page'].'\',\''.$langFile['BUTTON_THUMBNAIL_DELETE'].'\');return false;" title="'.$langFile['BUTTON_THUMBNAIL_DELETE'].'::'.$langFile['BUTTON_TOOLTIP_THUMBNAIL_DELETE'].'"'; ?> tabindex="34" class="deletePageThumbnail toolTip"></a></li>
              <?php }
              $showSpacer = true;
              }

              // WEBSITE LANGUAGE BUTTONS and SELECTION
              if($websiteConfig['multiLanguageWebsite']['active']) {

                // ADD PAGE LANGUAGE
                if($isInPageEditor) {
                  if($showSpacer) { ?>
                  <li class="spacer"></li>
                  <?php }
                  if($missingLanguages) { ?>
                  <li><a <?php echo 'href="?site=addPageLanguage&amp;category='.$_GET['category'].'&amp;page='.$_GET['page'].'" onclick="openWindowBox(\'library/views/windowBox/addPageLanguage.php?site='.$_GET['site'].'&amp;category='.$_GET['category'].'&amp;page='.$_GET['page'].'\',\''.$langFile['BUTTON_WEBSITELANGUAGE_ADD'].'\');return false;" title="'.$langFile['BUTTON_WEBSITELANGUAGE_ADD'].'::'.$langFile['BUTTON_TOOLTIP_WEBSITELANGUAGE_ADD'].'"'; ?> tabindex="35" class="addPageLanguage toolTip"></a></li>
                <?php
                }
                // DELETE PAGE LANGUAGE
                if(isset($_GET['page']) && !isset($pageContent['localized'][0]) && isset($pageContent['localized'][$_SESSION['feinduraSession']['websiteLanguage']])) { ?>
                  <!-- <li class="spacer"></li> -->
                  <li><a <?php echo 'href="?site=deletePageLanguage&amp;category='.$_GET['category'].'&amp;page='.$_GET['page'].'&amp;language='.$_SESSION['feinduraSession']['websiteLanguage'].'" onclick="openWindowBox(\'library/views/windowBox/deletePageLanguage.php?site='.$_GET['site'].'&amp;category='.$_GET['category'].'&amp;page='.$_GET['page'].'&amp;language='.$_SESSION['feinduraSession']['websiteLanguage'].'\',\''.$langFile['BUTTON_WEBSITELANGUAGE_DELETE'].'\');return false;" title="'.$langFile['BUTTON_WEBSITELANGUAGE_DELETE'].'::'.sprintf($langFile['BUTTON_TOOLTIP_WEBSITELANGUAGE_DELETE'],'[strong]'.$languageNames[$_SESSION['feinduraSession']['websiteLanguage']].'[/strong]').'"'; ?> tabindex="36" class="removePageLanguage toolTip"></a></li>
                <?php }
                $showSpacer = true;
                }

                // PAGE LANGUAGE SELECTION with
                if(!empty($websiteConfig['multiLanguageWebsite']['languages']) && (empty($pageContent) || !empty($pageContent['localized']))) {
                  ?>
                  <li class="spacer"></li>
                  <li style="top: -20px;">
                    <img src="<?php echo GeneralFunctions::getFlagHref($_SESSION['feinduraSession']['websiteLanguage']); ?>" title="<?php echo $languageNames[$_SESSION['feinduraSession']['websiteLanguage']]; ?>">
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
            </menu>
          </div>
        <?php }

        include('library/content.loader.php');

        ?>
        <a href="#top" class="fastUp" title="<?php echo $langFile['BUTTON_UP']; ?>"></a>
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
  <footer class="main">
    <div class="sideBarBottom"></div>
      <div class="copyright">
        <span class="feinduraName">fein<span>dura</span></span> - Flat File Content Management System, Copyright &copy; 2009-<?php echo date('Y'); ?> <a href="http://frozeman.de">Fabian Vogelsteller</a> - <span class="feinduraName">fein<span>dura</span></span> is published under the <a href="LICENSE">GNU General Public License, version 3</a>
      </div>
  </footer>

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

</body>
</html>