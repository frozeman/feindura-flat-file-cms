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

  <title>[feindura] <?php
  echo GeneralFunctions::getLocalized($websiteConfig,'title');
  if(isset($_GET['page']) && is_numeric($_GET['page']) && ($pageTitle = GeneralFunctions::readPage($_GET['page'],GeneralFunctions::getPageCategory($_GET['page']))) != false) {
    echo ' | '.GeneralFunctions::getLocalized($pageTitle,'title');
  }
  unset($pageTitle);
  ?></title>

  <?php
  include(dirname(__FILE__).'/library/includes/metaTags.include.php');
  ?>

  <script type="text/javascript">
  /* <![CDATA[ */

    // -> TRANSPORT feindura PHP VARS to JAVASCRIPT
    var feindura_basePath    = '<?php echo GeneralFunctions::Path2URI($adminConfig['basePath']); ?>';
    var feindura_websitePath = '<?php echo GeneralFunctions::Path2URI(GeneralFunctions::getDirname($adminConfig['websitePath'])); ?>';

    var feindura_langFile    = {
      ERRORWINDOW_TITLE:              "<?php echo $langFile['errorWindow_h1']; ?>",
      ERROR_SAVE:                     "<?php echo sprintf($langFile['EDITOR_savepage_error_save'],$adminConfig['basePath']); ?>",
      LOADING_TEXT_LOAD:              "<?php echo $langFile['LOADING_TEXT_LOAD']; ?>",
      CKEDITOR_TITLE_LINKS:           "<?php echo (!empty($langFile['CKEDITOR_TITLE_LINKS'])) ? $langFile['CKEDITOR_TITLE_LINKS'] : 'feindura pages'; ?>",
      CKEDITOR_TITLE_SNIPPETS:        "<?php echo (!empty($langFile['CKEDITOR_TITLE_SNIPPETS'])) ? $langFile['CKEDITOR_TITLE_SNIPPETS'] : 'Snippets'; ?>",
      CKEDITOR_TEXT_SNIPPETS:         "<?php echo (!empty($langFile['CKEDITOR_TEXT_SNIPPETS'])) ? $langFile['CKEDITOR_TEXT_SNIPPETS'] : ''; ?>",
      CKEDITOR_BUTTON_EDITSNIPPET:    "<?php echo (!empty($langFile['CKEDITOR_BUTTON_EDITSNIPPET'])) ? $langFile['CKEDITOR_BUTTON_EDITSNIPPET'] : 'edit snippet'; ?>",
      CKEDITOR_BUTTON_EDITPLUGIN:     "<?php echo (!empty($langFile['CKEDITOR_BUTTON_EDITPLUGIN'])) ? $langFile['CKEDITOR_BUTTON_EDITPLUGIN'] : 'edit plugin'; ?>",
      CKEDITOR_TITLE_PLUGINS:         "<?php echo (!empty($langFile['CKEDITOR_TITLE_PLUGINS'])) ? $langFile['CKEDITOR_TITLE_PLUGINS'] : 'Plugins'; ?>",
      CKEDITOR_TEXT_PLUGINS:          "<?php echo (!empty($langFile['CKEDITOR_TEXT_PLUGINS'])) ? $langFile['CKEDITOR_TEXT_PLUGINS'] : ''; ?>"
    };
    var currentSite     = '<?php echo $_GET["site"]; ?>';
    var currentPage     = '<?php echo $_GET["page"]; ?>';
    var currentCategory = '<?php echo $_GET["category"]; ?>';


    // -> TRANSPORT pages for CKEditor FEINDURA LINKS
    var feindura_pages = [
      ['-',''],
<?php
      if(isset($_GET['page']) && is_array($pagesMetaData)) {
        $transportPages = '';
        foreach($pagesMetaData as $pageMetaData) {
          $categoryText = ($pageMetaData['category'] != 0) ? GeneralFunctions::getLocalized($categoryConfig[$pageMetaData['category']],'name').' » ' : '';
          $transportPages .= "      ['".str_replace("'",'',$categoryText.GeneralFunctions::getLocalized($pageMetaData,'title'))."','?feinduraPageID=".$pageMetaData['id']."'],\n";
        }
        echo trim($transportPages,",\n")."\n";
      } ?>
    ];

    // -> TRANSPORT Snippets to CKEditor feinduraSnippets plugin
    var feindura_snippets = [
      ['-',''],
      <?php if($adminConfig['editor']['snippets'] && !empty($_GET['page'])) {
        $transportSnippets = '';
        $snippets = GeneralFunctions::readFolderRecursive(dirname(__FILE__).'/snippets/');
        foreach($snippets['files'] as $snippet) {
          $snippetShort = str_replace($adminConfig['basePath'].'snippets/', '', $snippet);
          $transportSnippets .= '["'.$snippetShort.'","'.$snippetShort.'"],'."\n";
        }
        echo trim($transportSnippets,",\n")."\n";
        unset($transportSnippets,$snippets,$snippet,$snippetShort);
      } ?>
    ];
    var feindura_snippets_editInWebsiteSettings = <?php echo (GeneralFunctions::hasPermission('editSnippets')) ? 'true' : 'false' ?>;
    var feindura_snippets_isAdmin               = <?php echo (GeneralFunctions::isAdmin()) ? 'true' : 'false' ?>;


    //  MORE SEE PAGE SCRIPT BELOW

  /* ]]> */
  </script>
</head>
<body>

  <!-- ************************************************************************* -->
  <!-- ** DOCUMENT SAVED ******************************************************* -->
  <div id="documentSaved"<?php if($DOCUMENTSAVED === true) echo ' class="saved"'; ?>></div>

  <!-- ************************************************************************* -->
  <!-- ** LOADING BOX ********************************************************** -->
  <div id="loadingBox"></div>

  <!-- LOADING BOX and DOCUMENT SAVED SCRIPTS -->
  <script type="text/javascript">
  /* <![CDATA[ */
    var loadingBox = $('loadingBox');

    // ->> SHOW the loading circle
    if(!$('documentSaved').hasClass('saved')) {
      onStartLoadingCircle();

    // ->> hide loading circle, when it was not animated
    } else if(loadingBox !== null) {
      loadingBox.empty();
      loadingBox.setStyle('display','none');
      // loadingBox.setStyle('opacity','1');
    }

    // ->> if DOCUMENT SAVED has given the class from the php script
    if($('documentSaved') !== null && $('documentSaved').hasClass('saved')) {
      // display document saved
      showDocumentSaved();
    }
  /* ]]> */
  </script>


  <!-- Top Anchor -->
  <a id="top" class="anchorTarget"></a>

  <!-- ***************************************************************************************** -->
  <!-- ** HEADER ******************************************************************************* -->
  <header class="main">
    <div class="container">

      <div class="menuBlock">

        <h1 style="display:none;">feindura - flat file cms</h1><!-- just for the outline of the HTML page -->
        <a href="http://feindura.org" class="feinduraLogo" target="_blank"></a>
        <div class="feinduraVersion toolTipRight" title="::<?php echo $langFile['LOGO_TEXT'].' '.VERSION.' - Build '.BUILD; ?>::"><?php echo VERSION; ?></div>

        <nav class="mainMenu"<?php if(!GeneralFunctions::isAdmin()) echo ' style="width: 850px;"'; ?>>
          <table>
            <tbody>
              <tr>
              <td><a href="?site=dashboard" tabindex="3" accesskey="d" class="dashboard<?php if($_GET['site'] == 'dashboard') echo ' active'; ?>" title="<?php echo $langFile['BUTTON_DASHBOARD']; ?> (D)"><span><?php echo $langFile['BUTTON_DASHBOARD']; ?></span></a></td>
              <td><a href="?site=pages" tabindex="4" accesskey="p" class="pages<?php if($_GET['site'] == 'pages' || !empty($_GET['page'])) echo ' active'; ?>" title="<?php echo $langFile['BUTTON_PAGES']; ?> (P)"><span><?php echo $langFile['BUTTON_PAGES']; ?></span></a></td>
              <?php
              // CHECKS if the addons/ folder is empty
              if(!GeneralFunctions::folderIsEmpty(dirname(__FILE__).'/addons/')) { ?>
              <td><a href="?site=addons" tabindex="5" accesskey="a" class="addons<?php if($_GET['site'] == 'addons') echo ' active'; ?>" title="<?php echo $langFile['BUTTON_ADDONS']; ?> (A)"><span><?php echo $langFile['BUTTON_ADDONS']; ?></span></a></td>
              <?php }
              if(GeneralFunctions::hasPermission('websiteSettings')) { ?>
              <td><a href="?site=websiteSetup" tabindex="6" accesskey="w" class="websiteSetup<?php if($_GET['site'] == 'websiteSetup') echo ' active'; ?>" title="<?php echo $langFile['BUTTON_WEBSITESETTINGS']; ?> (W)"><span><?php echo $langFile['BUTTON_WEBSITESETTINGS']; ?></span></a></td>
              <?php } ?>
              <td><a href="?site=search" tabindex="7" accesskey="s" class="search<?php if($_GET['site'] == 'search') echo ' active'; ?>" title="<?php echo $langFile['BUTTON_SEARCH']; ?> (S)"><span><?php echo $langFile['BUTTON_SEARCH']; ?></span></a></td>
              </tr>
            </tbody>
          </table>
        </nav>

        <!-- ADMIN MENU -->
        <?php if(GeneralFunctions::isAdmin()) { ?>
        <div class="adminMenuContainer">
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
        </div>

        <!-- ADMIN MENU SCRIPTS -->
        <script type="text/javascript">
        /* <![CDATA[ */

          var adminMenu = $('adminMenu');

          if(adminMenu !== null) {
            // set the style back, which is set for non javascript users
            adminMenu.setStyle('width','172px');
            adminMenu.setStyle('overflow','hidden');

            // set tween
            adminMenu.set('tween',{duration: 350, transition: Fx.Transitions.Quint.easeInOut});

            // add resize tween event
            adminMenu.addEvents({
              mouseenter : function() { // resize on mouseover
                adminMenu.scrollTo(0,0);
                adminMenu.tween('height',(adminMenu.getChildren('table')[0].offsetHeight + 40) + 'px');
              },
              mouseleave : function() { // resize on onmouseout
                adminMenu.tween('height','140px');
              }
            });
          }

        /* ]]> */
        </script>

        <?php } ?>
      </div>

      <div class="sideBar">
        <?php if(!empty($userConfig)) { ?>
        <div id="sessionTimout" class="toolTipBottom" title="::<?php echo $langFile['LOGIN_TIP_AUTOLOGOUT']; ?>::">00:00:00</div>
        <?php } ?>

        <?php include(dirname(__FILE__).'/library/includes/userList.include.php'); ?>

        <div class="btn-group headerCornerButtons">
          <?php if(GeneralFunctions::hasPermission('frontendEditing')) { ?>
          <a href="<?php echo $adminConfig['url'].GeneralFunctions::Path2URI($adminConfig['websitePath']); ?>"  tabindex="2" class="btn btn-large frontend toolTipBottom" title="<?php echo $langFile['HEADER_BUTTON_GOTOWEBSITE_FRONTENDEDITING']; ?>"><img src="library/images/buttons/subMenu_frontendEditing.png"></a>
          <?php } ?>
          <a href="index.php?logout" tabindex="1" class="btn btn-large logout toolTipBottom" title="::<?php echo $langFile['HEADER_BUTTON_LOGOUT']; ?>">&#215;</a>
        </div>


        <div class="languageSelection">
          <a href="<?php echo GeneralFunctions::addParameterToUrl('backendLanguage','en-US'); ?>" tabindex="20" class="en-us toolTipBottom<?php if($_SESSION['feinduraSession']['backendLanguageLocale'] == 'en-US') echo ' active'; ?>" title="English US::"></a>
          <a href="<?php echo GeneralFunctions::addParameterToUrl('backendLanguage','en-GB'); ?>" tabindex="20" class="en-gb toolTipBottom<?php if($_SESSION['feinduraSession']['backendLanguageLocale'] == 'en-GB') echo ' active'; ?>" title="English GB::"></a>
          <a href="<?php echo GeneralFunctions::addParameterToUrl('backendLanguage','de-DE'); ?>" tabindex="21" class="de toolTipBottom<?php if($_SESSION['feinduraSession']['backendLanguageLocale'] == 'de-DE') echo ' active'; ?>" title="Deutsch::"></a>
          <a href="<?php echo GeneralFunctions::addParameterToUrl('backendLanguage','fr-FR'); ?>" tabindex="22" class="fr toolTipBottom<?php if($_SESSION['feinduraSession']['backendLanguageLocale'] == 'fr-FR') echo ' active'; ?>" title="français::"></a>
          <a href="<?php echo GeneralFunctions::addParameterToUrl('backendLanguage','it-IT'); ?>" tabindex="23" class="it toolTipBottom<?php if($_SESSION['feinduraSession']['backendLanguageLocale'] == 'it-IT') echo ' active'; ?>" title="italiano::"></a>
          <a href="<?php echo GeneralFunctions::addParameterToUrl('backendLanguage','ru-RU'); ?>" tabindex="24" class="ru toolTipBottom<?php if($_SESSION['feinduraSession']['backendLanguageLocale'] == 'ru-RU') echo ' active'; ?>" title="русский::"></a>
          <a href="<?php echo GeneralFunctions::addParameterToUrl('backendLanguage','ro-RO'); ?>" tabindex="25" class="ro toolTipBottom<?php if($_SESSION['feinduraSession']['backendLanguageLocale'] == 'ro-RO') echo ' active'; ?>" title="român::"></a>

        </div>
      </div>
  </header>

  <!-- ***************************************************************************************** -->
  <!-- ** MAINBODY ***************************************************************************** -->
  <div class="mainBody" role="main">
    <div class="container">
      <?php

      // ---------------------------------------------------------------
      // ->> CHECK to show BUTTONs in subMenu and FooterMenu

      // vars
      $isInPageEditor = (!empty($_GET['page']) && empty($_GET['site']) && !$NEWPAGE) ? true : false;

      $generallyCreatePages = false;
      // CHECK if one category can create pages
      if(!empty($categoryConfig)) {
        foreach($categoryConfig as $category) {
          if($category['createDelete'] && GeneralFunctions::hasPermission('editableCategories',$category['id']))
            $generallyCreatePages = true;
        }
        unset($category);
      }


      $showCreatePage = ($generallyCreatePages) ? true : false;

       // -> CHECK for DELETE PAGE
      $showDeletePage = ($generallyCreatePages && !$NEWPAGE && empty($_GET['site']) && !empty($_GET['page']) && $_GET['page'] != 'new' &&
                         $categoryConfig[$_GET['category']]['createDelete']) ? true : false;

      // ->CHECK frontend editing
      $showFrontendEditing = ($isInPageEditor && GeneralFunctions::hasPermission('frontendEditing')) ? true : false;

      // -> CHECK for uploadPageThumbnail
      $showPageThumbnailUpload = (!$NEWPAGE &&
                                  empty($_GET['site']) && !empty($_GET['page']) &&
                                  $categoryConfig[$_GET['category']]['thumbnails']) ? true : false;


      // -> CHECK for deletePageThumbnail
      $showPageThumbnailDelete = (empty($_GET['site']) && !empty($pageContent['thumbnail'])) ? true : false;

      // -> CHECK for restore page (if and old state exists)
      $showRestorePage = ($previousStatePageContent) ? true : false;

      $showFileManager = (GeneralFunctions::hasPermission('fileManager')) ? true : false;

      // -> CHECK if show SUBMENU
      $showSubMenu = ($showPageThumbnailUpload || $showCreatePage || $showPageThumbnailUpload || $showFileManager || $showDeletePage) ? true : false;


      // -> CHECK if multiple lang on
      $showMultilanguageWebsite = ($websiteConfig['multiLanguageWebsite']['active'] && !empty($websiteConfig['multiLanguageWebsite']['languages']) && (empty($pageContent) || !empty($pageContent['localized']))) ? true : false;

      // ->> RE-SET CURRENT WEBSITE LANGUAGE based on the pages languages
      if($websiteConfig['multiLanguageWebsite']['active']) {

        // -> use the languages of the page
        $currentlanguageSlection = (isset($pageContent['localized'])) ? array_keys($pageContent['localized']) : $websiteConfig['multiLanguageWebsite']['languages'];

        // -> add new language to the page languages selection, if $_GET['status'] = "addLanguage"
        if($_GET['status'] == 'addLanguage' && is_array($pageContent['localized']))
            $currentlanguageSlection = array_unique(array_merge($websiteConfig['multiLanguageWebsite']['languages'],array_keys($pageContent['localized'])));
        $_SESSION['feinduraSession']['websiteLanguage'] = (in_array($_SESSION['feinduraSession']['websiteLanguage'], $currentlanguageSlection)) ? $_SESSION['feinduraSession']['websiteLanguage']: current($currentlanguageSlection);
        // if NEW PAGE, overwrite with the mainLanguage
        if($NEWPAGE)
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
        <section id="leftSidebar">
          <?php

          include('library/leftSidebar.loader.php');

          ?>
        </section>


        <!-- ************************************************************************* -->
        <!-- ** CONTENT ************************************************************** -->
        <section class="mainContent<?php if($showSubMenu) echo ' hasSubMenu'; ?>">

          <!-- ************************************************************************* -->
          <!-- ** SUBMENU ************************************************************** -->
          <?php if($showSubMenu) { ?>

            <div class="subMenu staticScroller" data-offset="-8">
              <?php if($showFileManager || $showCreatePage || $showMultilanguageWebsite) { ?>
              <menu class="horizontal">
                <?php

                // vars
                $showSpacer = false;

                // FILE MANAGER
                if($showFileManager) { ?>

                  <li><a href="?site=fileManager" tabindex="29" class="fileManager toolTipBottom" title="<?php echo $langFile['BUTTON_FILEMANAGER'].'::'.$langFile['BUTTON_TOOLTIP_FILEMANAGER']; ?>"></a></li>

                <?php
                  $showSpacer = true;
                }

                // CREATE NEW PAGE
                if($showCreatePage) {
                  if($showSpacer) { ?>

                  <li class="spacer"></li>

                  <?php } ?>

                  <li><a href="<?php echo '?category='.$_GET['category'].'&amp;page=new'; ?>" tabindex="31" class="createPage toolTipBottom" title="<?php echo $langFile['BUTTON_CREATEPAGE'].'::'.$langFile['BUTTON_TOOLTIP_CREATEPAGE']; ?>"></a></li>

                <?php
                  $showSpacer = true;
                }

                // PAGE LANGUAGE SELECTION with
                if($showMultilanguageWebsite) {
                  ?>

                  <li class="spacer"></li>
                  <li class="langSelect">
                    <img src="<?php echo GeneralFunctions::getFlagSrc($_SESSION['feinduraSession']['websiteLanguage']); ?>" class="toolTipBottom" title="::<?php echo $languageNames[$_SESSION['feinduraSession']['websiteLanguage']]; ?>">
                    <select name="websiteLanguageSelection" id="websiteLanguageSelection" tabindex="37">
                    <?php
                      // create language selection
                      foreach($currentlanguageSlection as $langCode) {
                        if($NEWPAGE || empty($pageContent) || isset($pageContent['localized'][$langCode]) || ($_GET['status'] == 'addLanguage' && $_SESSION['feinduraSession']['websiteLanguage'] == $langCode)) {
                          $selected = ($_SESSION['feinduraSession']['websiteLanguage'] == $langCode) ? ' selected="selected"' : '';
                          echo '<option value="'.$langCode.'"'.$selected.'>'.$languageNames[$langCode].'</option>';
                        }
                      }
                    ?>
                    </select>
                <?php
                }
                ?>
              </menu>
              <?php } ?>
              <?php if($showFrontendEditing ||
                       $showDeletePage ||
                       $showRestorePage ||
                       $showPageThumbnailUpload ||
                       $showPageThumbnailDelete ||
                       ($websiteConfig['multiLanguageWebsite']['active'] && $isInPageEditor) ||
                       $_GET['site'] == 'userSetup' ||
                       $_GET['site'] == 'pageSetup') { ?>

              <menu class="horizontal">

                <?php if($_GET['site'] == 'userSetup') { ?>

                  <li><a href="?site=userSetup&amp;status=createUser#userId<?php echo getNewUserId(); ?>" tabindex="30" class="createUser toolTipBottom" title="<?php echo $langFile['USERSETUP_createUser']; ?>::"></a></li>

                <?php $showSpacer = true;
                } ?>

                <?php if($_GET['site'] == 'pageSetup') { ?>

                  <li><a href="?site=pageSetup&amp;status=createCategory#category<?php echo getNewCatgoryId(); ?>" tabindex="30" class="createCategory toolTipBottom" title="<?php echo $langFile['PAGESETUP_CATEGORY_TEXT_CREATECATEGORY']; ?>::"></a></li>

                <?php $showSpacer = true;
                } ?>


                <?php
                $showSpacer = false;
                // FRONTEND EDITING
                if($showFrontendEditing) {
                  if($showSpacer) { ?>

                  <li class="spacer"></li>

                  <?php } ?>

                  <li><a <?php echo 'href="'.$adminConfig['url'].GeneralFunctions::Path2URI($adminConfig['websitePath']).'?'.$adminConfig['varName']['category'].'='.$_GET['category'].'&amp;'.$adminConfig['varName']['page'].'='.$_GET['page'].'" title="'.$langFile['BUTTON_FRONTENDEDITPAGE'].'::'.$langFile['BUTTON_TOOLTIP_FRONTENDEDITPAGE'].'"'; ?> tabindex="30" class="frontendEditing toolTipBottom"></a></li>

                <?php $showSpacer = true;
                }
                // RESTORE PAGE
                if($showRestorePage) {
                  if($showSpacer) { ?>

                  <li class="spacer"></li>

                  <?php } ?>

                  <li><a <?php echo 'href="index.php?category='.$pageContent['category'].'&amp;page='.$pageContent['id'].'&amp;status=restorePageToLastState&amp;reload='.rand(0,999).'" title="::'.sprintf($langFile['EDITOR_BUTTON_RESTORELASTSTATE'],str_replace(array('<','>','"'),array('[',']',"'"),GeneralFunctions::dateDayBeforeAfter($previousStatePageContent['lastSaveDate'])).' '.formatTime($previousStatePageContent['lastSaveDate'])).'"'; ?> tabindex="33" class="restorePage toolTipBottom"></a></li>

                <?php $showSpacer = false;
                }

                // DELETEPAGE
                if($showDeletePage) {
                  if($showSpacer) { ?>

                  <li class="spacer"></li>

                  <?php } ?>

                  <li><a <?php echo 'href="?site=deletePage&amp;category='.$_GET['category'].'&amp;page='.$_GET['page'].'" onclick="openWindowBox(\'library/views/windowBox/deletePage.php?category='.$_GET['category'].'&amp;page='.$_GET['page'].'\',\''.$langFile['BUTTON_DELETEPAGE'].'\');return false;" title="'.$langFile['BUTTON_DELETEPAGE'].'::'.$langFile['BUTTON_TOOLTIP_DELETEPAGE'].'"'; ?> tabindex="32" class="deletePage toolTipBottom"></a></li>

                <?php
                } if($showDeletePage || $showRestorePage) $showSpacer = true;

                // PAGETHUMBNAILUPLOAD
                if($showPageThumbnailUpload) {
                  if($showSpacer) { ?>

                  <li class="spacer"></li>

                  <?php } ?>

                  <li><a <?php echo 'href="?site=uploadPageThumbnail&amp;category='.$_GET['category'].'&amp;page='.$_GET['page'].'" onclick="openWindowBox(\'library/views/windowBox/uploadPageThumbnail.php?site='.$_GET['site'].'&amp;category='.$_GET['category'].'&amp;page='.$_GET['page'].'\',\''.$langFile['BUTTON_THUMBNAIL_UPLOAD'].'\');return false;" title="'.$langFile['BUTTON_THUMBNAIL_UPLOAD'].'::'.$langFile['BUTTON_TOOLTIP_THUMBNAIL_UPLOAD'].'"'; ?> tabindex="34" class="uploadPageThumbnail toolTipBottom"></a></li>

                <?php
                // PAGETHUMBNAILDELETE
                if($showPageThumbnailDelete) { ?>

                  <li><a <?php echo 'href="?site=deletePageThumbnail&amp;category='.$_GET['category'].'&amp;page='.$_GET['page'].'" onclick="openWindowBox(\'library/views/windowBox/deletePageThumbnail.php?site='.$_GET['site'].'&amp;category='.$_GET['category'].'&amp;page='.$_GET['page'].'\',\''.$langFile['BUTTON_THUMBNAIL_DELETE'].'\');return false;" title="'.$langFile['BUTTON_THUMBNAIL_DELETE'].'::'.$langFile['BUTTON_TOOLTIP_THUMBNAIL_DELETE'].'"'; ?> tabindex="35" class="deletePageThumbnail toolTipBottom"></a></li>

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

                    <li><a <?php echo 'href="?site=addPageLanguage&amp;category='.$_GET['category'].'&amp;page='.$_GET['page'].'" onclick="openWindowBox(\'library/views/windowBox/addPageLanguage.php?site='.$_GET['site'].'&amp;category='.$_GET['category'].'&amp;page='.$_GET['page'].'\',\''.$langFile['BUTTON_WEBSITELANGUAGE_ADD'].'\');return false;" title="'.$langFile['BUTTON_WEBSITELANGUAGE_ADD'].'::'.$langFile['BUTTON_TOOLTIP_WEBSITELANGUAGE_ADD'].'"'; ?> tabindex="36" class="addPageLanguage toolTipBottom"></a></li>

                  <?php
                  }
                  // DELETE PAGE LANGUAGE
                  if(isset($_GET['page']) && !isset($pageContent['localized'][0]) && isset($pageContent['localized'][$_SESSION['feinduraSession']['websiteLanguage']])) { ?>

                    <!-- <li class="spacer"></li> -->
                    <li><a <?php echo 'href="?site=deletePageLanguage&amp;category='.$_GET['category'].'&amp;page='.$_GET['page'].'&amp;language='.$_SESSION['feinduraSession']['websiteLanguage'].'" onclick="openWindowBox(\'library/views/windowBox/deletePageLanguage.php?site='.$_GET['site'].'&amp;category='.$_GET['category'].'&amp;page='.$_GET['page'].'&amp;language='.$_SESSION['feinduraSession']['websiteLanguage'].'\',\''.$langFile['BUTTON_WEBSITELANGUAGE_DELETE'].'\');return false;" title="'.$langFile['BUTTON_WEBSITELANGUAGE_DELETE'].'::'.sprintf($langFile['BUTTON_TOOLTIP_WEBSITELANGUAGE_DELETE'],'[strong]'.$languageNames[$_SESSION['feinduraSession']['websiteLanguage']].'[/strong]').'"'; ?> tabindex="37" class="removePageLanguage toolTipBottom"></a></li>

                  <?php }
                  $showSpacer = true;
                  }
                }
                ?>

              </menu>
              <?php } ?>

              <?php if(!empty($_GET['page']) && empty($_GET['site'])) { ?>

              <menu id="subMenuSubmit" class="horizontal right" style="display:none;">
                <li><a href="#" class="submit" onclick="$('editorForm').submit(); return false;"></a></li>
              </menu>

              <?php } ?>
            </div>
          <?php }

          include('library/content.loader.php');

          ?>
        </section>


        <!-- ************************************************************************* -->
        <!-- ** RIGHT-SIDEBAR ************************************************************** -->
        <!-- requires the <span> tag inside the <li><a> tag for measure the text width -->
        <section id="rightSidebar">
          <?php

          include('library/rightSidebar.loader.php');

          ?>
        </section>
        <a href="#top" class="fastUp" title="<?php echo $langFile['BUTTON_UP']; ?>"></a>

        <?php echo isBlocked(false); ?>
      </div>
  </div>

  <!-- ******************************************************************************************* -->
  <!-- ** FOOTER ********************************************************************************* -->
  <footer class="main">
      <div class="container copyright">
        <span class="feinduraInline">fein<em>dura</em></span> - Flat File Content Management System, Copyright &copy; 2009-<?php echo date('Y'); ?> <a href="http://frozeman.de">Fabian Vogelsteller</a> - <span class="feinduraInline">fein<em>dura</em></span> is published under the <a href="LICENSE">GNU General Public License, version 3</a>
      </div>
  </footer>

  <?php if($ERRORWINDOW !== false) { ?>
  <!-- ************************************************************************* -->
  <!-- ** ERROR WINDOW ********************************************************* -->
  <script type="text/javascript">
    feindura_showError('<?php echo $langFile['errorWindow_h1']; ?>','<?php echo str_replace(array("\n","\t"),'',$ERRORWINDOW); ?>');
  </script>
  <?php } ?>

  <?php if($NOTIFICATION !== false) {
    $NOTIFICATION = str_replace(array("\n","\t"), '', $NOTIFICATION);
  ?>
  <!-- ************************************************************************* -->
  <!-- ** NOTIFICATION  ******************************************************** -->
  <script type="text/javascript">
    feindura_showNotification('<?php echo $NOTIFICATION; ?>');
  </script>
  <?php } ?>


<!-- PAGE SCRIPTS -->
<script type="text/javascript">
/* <![CDATA[ */

  // ->> include FILEMANAGER
  <?php if(GeneralFunctions::hasPermission('fileManager')) { ?>
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
      zIndex: 20020,
      onShow: function() {
          window.location.hash = '#none';
          dimmContainer.show();
          dimmContainer.addEvent('click',hideFileManager.bind(this));
        },
      onHide: function() {
          dimmContainer.removeEvent('click',hideFileManager);
          dimmContainer.hide();
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
          showAllValues: true,
          reAddValues: true
        }
      }
    });
    editableTags.plugins['autocomplete'].setValues(
      [
      <?php
      $allTags = array();
      foreach ($pagesMetaData as $pageMetaData) {
        foreach ($pageMetaData['localized'] as $langCode => $pageMetaDataLocalized) {
          $tags = explode(',', $pageMetaDataLocalized['tags']);
          $allTags = array_merge($allTags,$tags);
        }
      }
      $allTags = array_unique($allTags);
      natcasesort($allTags);
      foreach($allTags as $tag) {
        // add tag only when the current page dont have them
        if(!empty($tag) && !GeneralFunctions::compareTags($pageContent, $tag)) {
          echo '["'.$tag.'","'.$tag.'"],';
        }
      }
      unset($allTags);
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
      window.location.href = 'index.php?logout';
    }
  })
  <?php } ?>

/* ]]> */
</script>

</body>
</html>