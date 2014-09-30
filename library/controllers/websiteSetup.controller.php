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

* controllers/websiteSetup.controller.php version 2.0
*/

/**
 * Includes the login.include.php and backend.include.php and filter the basic data
 */
require_once(dirname(__FILE__)."/../includes/secure.include.php");


// ------------ SAVE the WEBSITE SETTINGS
if(isset($_POST['send']) && $_POST['send'] ==  'websiteSetup') {

  $newWebsiteConfig = $websiteConfig;

  // STORE LOCALIZED CONTENT
  $newWebsiteConfig['localized'][$_POST['websiteLanguage']]['title']       = $_POST['title'];
  $newWebsiteConfig['localized'][$_POST['websiteLanguage']]['publisher']   = $_POST['publisher'];
  $newWebsiteConfig['localized'][$_POST['websiteLanguage']]['copyright']   = $_POST['websiteConfig_copyright'];
  $newWebsiteConfig['keywords']                                               = str_replace(";", ',', $_POST['keywords']);
  $newWebsiteConfig['localized'][$_POST['websiteLanguage']]['keywords']    = preg_replace("# +#", ' ', $_POST['keywords']);
  $newWebsiteConfig['localized'][$_POST['websiteLanguage']]['description'] = $_POST['description'];

  // -> check if languages exist, otherwise deactivate multilanguage pages
  if(empty($_POST['websiteLanguages']))
    $_POST['multiLanguageWebsite'] = false;

  // RENAME advanced websitesettings vars
  $newWebsiteConfig['maintenance']                          = $_POST['maintenance'];
  $newWebsiteConfig['dateFormat']                           = $_POST['dateFormat'];
  $newWebsiteConfig['sitemapFiles']                         = $_POST['sitemapFiles'];
  $newWebsiteConfig['visitorTimezone']                      = $_POST['visitorTimezone'];
  $newWebsiteConfig['multiLanguageWebsite']['active']       = $_POST['multiLanguageWebsite'];
  $newWebsiteConfig['multiLanguageWebsite']['mainLanguage'] = $_POST['websiteMainLanguage'];
  $newWebsiteConfig['multiLanguageWebsite']['languages']    = $_POST['websiteLanguages'];


  // remove the sitemap files, if deactivated
  if(empty($newWebsiteConfig['sitemapFiles'])) {
    $websitePath = GeneralFunctions::getDirname($GLOBALS['adminConfig']['websitePath']);
    $websitePath = (empty($websitePath)) ? '/': $websitePath;
    $realWebsitePath = GeneralFunctions::getRealPath($websitePath);
    if($realWebsitePath) {
      @unlink($realWebsitePath.'/sitemap-index.xml');
      $sitemapFileNumber = 1;
      while(file_exists($realWebsitePath.'/sitemap-pages-'.$sitemapFileNumber.'.xml')) {
        @unlink($realWebsitePath.'/sitemap-pages-'.$sitemapFileNumber.'.xml');
        $sitemapFileNumber++;
      }
      unset($sitemapFileNumber);
    }
  } else {
    saveSitemap(true);
  }


  // ------------------------------------------------------------------
  // ->> CHANGE PAGES to MULTI LANGUAGE pages
  if($newWebsiteConfig['multiLanguageWebsite']['active'] == 'true') {

    // GET the REMOVED LANGUAGES
    $removedLanguages = array();
    if(is_array($websiteConfig['multiLanguageWebsite']['languages'])) {
      foreach ($websiteConfig['multiLanguageWebsite']['languages'] as $langCode) {
        if(!in_array($langCode, $newWebsiteConfig['multiLanguageWebsite']['languages']))
          $removedLanguages[] = $langCode;
      }
    }

    // -> CHANGE PAGES
    $allPages = GeneralFunctions::loadPages(true);
    foreach($allPages as $pageContent) {

      // $pageContent['localized'][0] = (!isset($pageContent['localized'][0])) ? array() : $pageContent['localized'][0];

      // change the non localized content to the mainLanguage
      if(is_array($pageContent['localized']) && is_array(current($pageContent['localized']))) {

        // USE LOCALIZATION: Get either the already existing mainLanguage, or use the next following language as the mainLanguage
        $useLocalization = (isset($pageContent['localized'][$newWebsiteConfig['multiLanguageWebsite']['mainLanguage']]))
          ? $pageContent['localized'][$newWebsiteConfig['multiLanguageWebsite']['mainLanguage']]
          : current($pageContent['localized']);

        // REMOVE old LANGUAGES
        foreach ($removedLanguages as $langCode) {
          unset($pageContent['localized'][$langCode]);
        }

        // put the mainLanguage on the top
        $pageContent['localized'] = array_merge(array($newWebsiteConfig['multiLanguageWebsite']['mainLanguage'] => $useLocalization), $pageContent['localized']);
        unset($pageContent['localized'][0]);
      }
      if(!GeneralFunctions::savePage($pageContent,false,false))
        $ERRORWINDOW .= sprintf($langFile['EDITOR_savepage_error_save'],$adminConfig['basePath']);
    }

    // SAVE the pagesMetaData array
    GeneralFunctions::savePagesMetaData();


    // -> CHANGE WEBSITE CONFIG
    if(is_array($newWebsiteConfig['localized']) && is_array(current($newWebsiteConfig['localized']))) {
      // get the either the already existing mainLanguage, or use the next following language as the mainLanguage
      $useLocalization = (isset($newWebsiteConfig['localized'][$newWebsiteConfig['multiLanguageWebsite']['mainLanguage']]))
        ? $newWebsiteConfig['localized'][$newWebsiteConfig['multiLanguageWebsite']['mainLanguage']]
        : current($newWebsiteConfig['localized']);

      // put the mainLanguage on the top
      $newWebsiteConfig['localized'] = array_merge(array($newWebsiteConfig['multiLanguageWebsite']['mainLanguage'] => $useLocalization), $newWebsiteConfig['localized']);
      unset($newWebsiteConfig['localized'][0]);

      // REMOVE old LANGUAGES
      foreach ($removedLanguages as $langCode) {
        unset($newWebsiteConfig['localized'][$langCode]);
      }
    }

    // -> CHANGE CATEGORY CONFIG
    // change the localized content to non localized content using the the mainLanguage
    if(is_array($categoryConfig)) {
      $newCategoryConfig = array();
      foreach ($categoryConfig as $key => $category) {
        $newCategoryConfig[$key] = $category;

        // get the either the already existing mainLanguage, or use the next following language as the mainLanguage
        $useLocalization = (isset($category['localized'][$newWebsiteConfig['multiLanguageWebsite']['mainLanguage']]))
          ? $category['localized'][$newWebsiteConfig['multiLanguageWebsite']['mainLanguage']]
          : current($category['localized']);

        // put the mainLanguage on the top
        $newCategoryConfig[$key]['localized'] = array_merge(array($newWebsiteConfig['multiLanguageWebsite']['mainLanguage'] => $useLocalization), $category['localized']);
        unset($newCategoryConfig[$key]['localized'][0]);

        // REMOVE old LANGUAGES
        foreach ($removedLanguages as $langCode) {
          unset($newCategoryConfig[$key]['localized'][$langCode]);
        }
      }
      if(!saveCategories($newCategoryConfig))
        $ERRORWINDOW .= sprintf($langFile['PAGESETUP_CATEGORY_ERROR_CREATECATEGORY'],$adminConfig['basePath']);
    }

    // -> add to SESSION
    if($_SESSION['feinduraSession']['websiteLanguage'] === 0)
      $_SESSION['feinduraSession']['websiteLanguage'] = $newWebsiteConfig['multiLanguageWebsite']['mainLanguage'];

  // ->> CHANGE TO SINGLE LANGUAGE
  } else {

    // -> CHANGE PAGES
    $allPages = GeneralFunctions::loadPages(true);
    foreach($allPages as $pageContent) {

      // change the localized content to non localized content using the the mainLanguage
      if(is_array($pageContent['localized']) && isset($pageContent['localized'][$websiteConfig['multiLanguageWebsite']['mainLanguage']])) {
        $storedMainLanguageArray = $pageContent['localized'][$websiteConfig['multiLanguageWebsite']['mainLanguage']];
        unset($pageContent['localized']);
        $pageContent['localized'][0] = $storedMainLanguageArray;

      // if the mainLanguage didnt exist create an empty array
      } else
        $pageContent['localized'][0] = array();

      if(!GeneralFunctions::savePage($pageContent,false,false))
        $ERRORWINDOW .= sprintf($langFile['EDITOR_savepage_error_save'],$adminConfig['basePath']);
    }

    // SAVE the pagesMetaData array
    GeneralFunctions::savePagesMetaData();

    // -> CHANGE WEBSITE CONFIG
    // change the localized content to non localized content using the the mainLanguage
    if(is_array($newWebsiteConfig['localized']) && isset($newWebsiteConfig['localized'][$websiteConfig['multiLanguageWebsite']['mainLanguage']])) {
      $storedMainLanguageArray = $newWebsiteConfig['localized'][$websiteConfig['multiLanguageWebsite']['mainLanguage']];
      unset($newWebsiteConfig['localized']);
      $newWebsiteConfig['localized'][0] = $storedMainLanguageArray;

    // if the mainLanguage didnt exist create an empty array
    } else
      $newWebsiteConfig['localized'][0] = array();


    // -> CHANGE CATEGORY CONFIG
    // change the localized content to non localized content using the the mainLanguage
    if(is_array($categoryConfig)) {
      $newCategoryConfig = array();
      foreach ($categoryConfig as $key => $category) {
        $newCategoryConfig[$key] = $category;

        if(is_array($category['localized']) && isset($category['localized'][$websiteConfig['multiLanguageWebsite']['mainLanguage']])) {
          $storedMainLanguageArray = $category['localized'][$websiteConfig['multiLanguageWebsite']['mainLanguage']];
          unset($newCategoryConfig[$key]['localized']);
          $newCategoryConfig[$key]['localized'][0] = $storedMainLanguageArray;

        // if the mainLanguage didnt existed create an empty array
        } else
          $newCategoryConfig[$key]['localized'][0] = array();
      }
      if(!saveCategories($newCategoryConfig))
        $ERRORWINDOW .= sprintf($langFile['PAGESETUP_CATEGORY_ERROR_CREATECATEGORY'],$adminConfig['basePath']);
    }

    // -> add to SESSION
    if($_SESSION['feinduraSession']['websiteLanguage'] !== 0)
      $_SESSION['feinduraSession']['websiteLanguage'] = 0;
  }
  // ------------------------------------------------------------------

  // delete the pageContent var used above
  unset($pageContent);

  if(saveWebsiteConfig($newWebsiteConfig)) {
    // give documentSaved status
    $DOCUMENTSAVED = true;
    saveActivityLog(7); // <- SAVE the task in a LOG FILE
  } else
  $ERRORWINDOW .= sprintf($langFile['websiteSetup_websiteConfig_error_save'],$adminConfig['basePath']);

  $SAVEDFORM = $_POST['savedBlock'];
  $SAVEDSETTINGS = true;
}


// ---------- SAVE the editFiles
include_once(dirname(__FILE__).'/../controllers/saveEditFiles.controller.php');

// RE-INCLUDE
if($SAVEDSETTINGS) {
  unset($websiteConfig);
  $websiteConfig = @include (dirname(__FILE__)."/../../config/website.config.php");
  GeneralFunctions::$websiteConfig = $websiteConfig;
  StatisticFunctions::$websiteConfig = $websiteConfig;
}
?>