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
 * backend.include.php
 *
 * @version 0.3
 */

$sessionLifeTime = (60 * 60 * 3); // logout after 3 hours of inactivity

// -> START SESSION (for the login, language and storedPages [currently deactivated])
ini_set('session.gc_maxlifetime', $sessionLifeTime * 10); // saves the session for a long time, so it doesnt expire (feindura handles this)
ini_set('session.cookie_lifetime', $sessionLifeTime * 10); // saves the session for a long time, so it doesnt expire (feindura handles this)
session_name('session');
session_start();

// set the execution time limit higher
@set_time_limit(50);

// INCLUDE GENERAL
require_once(dirname(__FILE__)."/general.include.php");

// ->> CHECK PHP VERSION
// *********************
if(PHP_VERSION < REQUIREDPHPVERSION) {
?>
<!DOCTYPE html>
<html class="feindura">
<head>

  <title>feindura | PHP Error</title>

  <?php
  include(dirname(__FILE__).'/metaTags.include.php');
  ?>

</head>
<body>
  <div class="container">
    <div class="alert alert-error center">
      <?php
      echo '<h1>PHP ERROR</h1><span class="feinduraInline">fein<em>dura</em></span> requires at least PHP version '.REQUIREDPHPVERSION;
      ?>
    </div>
</body>
</html>
<?php
  die();
}
// PHP VERSION CHECK *** END
// *************************

// -> INCLUDE FUNCTIONS
require_once(dirname(__FILE__)."/../functions/backend.functions.php");

// -> SET ERROR HANDLER
@set_error_handler("showErrorsInWindow",E_ALL ^ E_NOTICE);// E_ALL ^ E_NOTICE ^ E_WARNING

// -> CREATE the CONFIG, PAGES and STATISTIC FOLDERS if they dont exist
createBasicFilesAndFolders();

// -> SET the BASIC VARIABLEs
$errorWindow      = false; // when it contains a string the errorWindow with this string is displayed
$messagePopUp     = false; // when it contains a string a message popup will be displayed
$documentSaved    = false; // when true the document saved icon is displayed
$savedForm        = false; // to tell wich part fo the form was saved
$savedSettings    = false; // to tell wich settings were saved, to re-include the settings
$newPage          = false; // tells the editor whether a new page is created
$userCache        = ((!isset($_GET['status']) && !isset($_POST['status'])) || $_GET['status'] == 'updateUserCache') ? userCache() : array();

// ->> SEND INFO to CONTENT.JS, so when updated the user config and a page gets free, it can remove the "contentBlocked" DIV
if($_GET['status'] == 'updateUserCache' && isBlocked() === false) {
  die('###RELEASEBLOCK###');
}


/**
 * SET the WEBSITE LANGUAGE
 *
 */
if($websiteConfig['multiLanguageWebsite']['active']) {
  //XSS Filter
  if(isset($_GET['websiteLanguage'])) $_GET['websiteLanguage'] = XssFilter::alphabetical($_GET['websiteLanguage']);
  if(isset($_SESSION['feinduraSession']['websiteLanguage'])) $_SESSION['feinduraSession']['websiteLanguage'] = XssFilter::alphabetical($_SESSION['feinduraSession']['websiteLanguage']);

  if($websiteConfig['multiLanguageWebsite']['active'] && isset($_GET['websiteLanguage']))
    $websiteLanguage = $_GET['websiteLanguage'];
  elseif($websiteConfig['multiLanguageWebsite']['active'] && !isset($_GET['websiteLanguage']) && !empty($_SESSION['feinduraSession']['websiteLanguage']))
    $websiteLanguage = $_SESSION['feinduraSession']['websiteLanguage'];
  elseif(!empty($websiteConfig['multiLanguageWebsite']['mainLanguage']))
    $websiteLanguage = $websiteConfig['multiLanguageWebsite']['mainLanguage'];
  // reset the websiteLanguage SESSION var
  $_SESSION['feinduraSession']['websiteLanguage'] = $websiteLanguage;
  unset($websiteLanguage);
} else {
  unset($_SESSION['feinduraSession']['websiteLanguage']);
  $_SESSION['feinduraSession']['websiteLanguage'] = 0;
}

/**
 * SET the BACKEND LANGUAGE
 * And loads the language files
 *
 */
// unset($_SESSION['feinduraSession']['backendLanguage']);
// unset($_SESSION['feinduraSession']['backendLanguageLocale']);
//XSS Filter
if(isset($_GET['backendLanguage'])) $_GET['backendLanguage'] = XssFilter::string($_GET['backendLanguage']);
if(isset($_SESSION['feinduraSession']['backendLanguage'])) $_SESSION['feinduraSession']['backendLanguage'] = XssFilter::string($_SESSION['feinduraSession']['backendLanguage']);

// GET BROWSER LANGUAGE
if(isset($_GET['backendLanguage'])) $_SESSION['feinduraSession']['backendLanguage'] = $_GET['backendLanguage'];
// if no language is given
elseif(empty($_SESSION['feinduraSession']['backendLanguage']))
  $_SESSION['feinduraSession']['backendLanguage'] = GeneralFunctions::getBrowserLanguages();

// save the locale
$_SESSION['feinduraSession']['backendLanguageLocale'] = (strlen($_SESSION['feinduraSession']['backendLanguage']) == 5) ? $_SESSION['feinduraSession']['backendLanguage'] : $_SESSION['feinduraSession']['backendLanguageLocale'];
// shorten the language to its basic language
$_SESSION['feinduraSession']['backendLanguage'] = substr($_SESSION['feinduraSession']['backendLanguage'],0,2);

// LOAD LANG FILES
$backendLangFile = GeneralFunctions::loadLanguageFile(false,'%lang%.backend.php',$_SESSION['feinduraSession']['backendLanguage']);
$sharedLangFile = GeneralFunctions::loadLanguageFile(false,'%lang%.shared.php',$_SESSION['feinduraSession']['backendLanguage']);

$langFile = array_merge($sharedLangFile,$backendLangFile);
unset($backendLangFile,$sharedLangFile);

// set the BACKEND DATEFORMAT
// ...is used in the GeneralFunctions::formatDate() function
switch ($_SESSION['feinduraSession']['backendLanguage']) {
  case 'fr':
    $backendDateFormat = 'D/M/Y';
    break;
  case 'en':
    if($_SESSION['feinduraSession']['backendLanguageLocale'] == 'en-US') {
      $backendDateFormat = 'M/D/Y';
      break;
    } // else buble through to default
  default: // en-GB, ru, de, it
    $backendDateFormat = 'D.M.Y';
    break;
}

// -> ADD NON-CATEGORY name from the current language file
$categoryConfig[0]['localized'][0]['name'] = $langFile['CATEGORIES_TOOLTIP_NONCATEGORY'];


// -> SEND BACKEND HEADER
header('Content-Type:text/html; charset=UTF-8');
header('Content-Language:'.$_SESSION['feinduraSession']['backendLanguage']);

?>