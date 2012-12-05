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
 * This file includes all necessary <var>classes</var> and configs for the use in the FRONTEND and the BACKEND
 *
 * @version 0.5
 */

// BENCHMARK start
// $timer = explode( ' ', microtime() );
// $startTime = $timer[1] + $timer[0];

// set error reporting
error_reporting(E_ALL & ~E_NOTICE);// E_ALL ^ E_NOTICE ^ E_WARNING // ~E_NOTICE

/**
 * set mb_ functions encoding
 */
mb_internal_encoding('UTF-8');
mb_http_output('UTF-8');

// ->> autoload CLASSES
/**
 * Autoloads all classes
 *
 */
function __autoload($class_name) {
  if($class_name == 'FeinduraBase' ||
     $class_name == 'Feindura' ||
     $class_name == 'GeneralFunctions' ||
     $class_name == 'StatisticFunctions' ||
     $class_name == 'XssFilter' ||
     $class_name == 'Search' ||
     $class_name == 'DebugTools')
    require_once(dirname(__FILE__)."/../classes/".$class_name.".class.php");

  if($class_name == 'ZenPHP')
    require_once(dirname(__FILE__)."/../thirdparty/ZenPHP/".$class_name.".php");

  return true;
}

/**
 * Fix the $_SERVER['REQUEST_URI'] for IIS Server
 */
if (!isset($_SERVER['REQUEST_URI'])) {
  $_SERVER['REQUEST_URI'] = substr(XssFilter::path($_SERVER['PHP_SELF']),0);
  if (isset($_SERVER['QUERY_STRING']) AND $_SERVER['QUERY_STRING'] != "") {
    $_SERVER['REQUEST_URI'] .= '?'.$_SERVER['QUERY_STRING'];
  }
}


// ->> FUNCTIONS
/**
 * Includes the main functions
 */
require_once(dirname(__FILE__)."/../functions/sort.functions.php");



// ->> get CONFIGS
/**
 * The administrator-settings config
 *
 * This config <var>array</var> is included from: <i>"feindura-CMS/config/admin.config.php"</i>
 *
 * @global array $GLOBALS['adminConfig']
 */
$adminConfig = GeneralFunctions::includeFile(dirname(__FILE__)."/../../config/admin.config.php");
if(empty($adminConfig))
  $adminConfig = array();
if(empty($adminConfig['permissions'])) $adminConfig['permissions'] = 0755;
$GLOBALS['adminConfig'] = $adminConfig;

/**
 * The statistic-settings config
 *
 * This config <var>array</var> is included from: <i>"feindura-CMS/config/statistic.config.php"</i>
 *
 * @global array $GLOBALS['statisticConfig']
 */
$statisticConfig = GeneralFunctions::includeFile(dirname(__FILE__)."/../../config/statistic.config.php");
if(empty($statisticConfig))
  $statisticConfig = array();
$GLOBALS['statisticConfig'] = $statisticConfig;

/**
 * The website-statistics
 *
 * This statistics <var>array</var> is included from: <i>"feindura-CMS/config/website.statistic.php"</i>
 *
 * @global array $GLOBALS['websiteStatistic']
 */
$websiteStatistic = GeneralFunctions::includeFile(dirname(__FILE__)."/../../statistics/website.statistic.php");
if($websiteStatistic === null)
  $websiteStatistic = array('locked' => true);
elseif(empty($websiteStatistic))
  $websiteStatistic = array();
$GLOBALS['websiteStatistic'] = $websiteStatistic;

/**
 * The pagesMetaData array
 *
 * This <var>array</var> is included from: <i>"feindura-CMS/pages/pagesMetaData.array.php"</i>
 *
 * @global array $GLOBALS['pagesMetaData']
 */
$pagesMetaData = GeneralFunctions::includeFile(dirname(__FILE__)."/../../pages/pagesMetaData.array.php");
if(empty($pagesMetaData))
  $pagesMetaData = array();
$GLOBALS['pagesMetaData'] = $pagesMetaData;


/**
 * Set the Timezone
 * needs the $adminConfig
 */
if(function_exists('date_default_timezone_set') && !empty($adminConfig['timezone']))
  date_default_timezone_set($adminConfig['timezone']);


/**
 * *** CACHE ****
 * Build/Get cache
 * needs the $adminConfig
 */
// $RECACHE = true;
// constant UPDATE is defined in the update.php, to prevent caching
if(!defined('FEINDURA_UPDATE') &&
   $adminConfig['cache']['active'] &&
   !$_SESSION['feinduraSession']['login']['loggedIn'] &&
   empty($_GET['timezone'])) { // don't cache if its requesting the visitors timezone
  require_once(dirname(__FILE__)."/../thirdparty/PHP/ACcache.php");
  // create cache folder
  if(!is_dir(dirname(__FILE__).'/../../pages/cache/')) {
    mkdir(dirname(__FILE__).'/../../pages/cache/');
    @chmod(dirname(__FILE__).'/../../pages/cache/', $adminConfig['permissions']);
  }
  // unset($_SESSION);
  StatisticFunctions::init();
  StatisticFunctions::saveWebsiteStats();
  new cache(dirname(__FILE__).'/../../pages/cache/', $_SESSION['feinduraSession']['language'], ($adminConfig['cache']['timeout']*60*60), "html" );
}

/**
 * The website-settings config
 *
 * This config <var>array</var> is included from: <i>"feindura-CMS/config/website.config.php"</i>
 *
 * @global array $GLOBALS['websiteConfig']
 */
$websiteConfig = GeneralFunctions::includeFile(dirname(__FILE__)."/../../config/website.config.php");
if(empty($websiteConfig))
  $websiteConfig = array();
$GLOBALS['websiteConfig'] = $websiteConfig;

/**
 * The categories-settings config
 *
 * This config <var>array</var> is included from: <i>"feindura-CMS/config/category.config.php"</i>
 *
 * @global array $GLOBALS['categoryConfig']
 */
$categoryConfig = GeneralFunctions::includeFile(dirname(__FILE__)."/../../config/category.config.php");
if(empty($categoryConfig))
  $categoryConfig = array();
$GLOBALS['categoryConfig'] = $categoryConfig;


/**
 * The user-settings config
 *
 * This config <var>array</var> is included from: <i>"feindura-CMS/config/user.config.php"</i>
 *
 * @global array $GLOBALS['userConfig']
 */
$userConfig = GeneralFunctions::includeFile(dirname(__FILE__)."/../../config/user.config.php");
if(empty($userConfig))
  $userConfig = array();
$GLOBALS['userConfig'] = $userConfig;


/**
 * The languages array
 *
 * This languages <var>array</var> is included from: <i>"feindura-CMS/library/thirdparty/languages.array.php"</i>
 *
 * @global array $GLOBALS['languageNames']
 */
$languageNames = GeneralFunctions::includeFile(dirname(__FILE__)."/../../library/thirdparty/languages.array.php");
if(empty($languageNames))
  $languageNames = array();
natsort($languageNames);
$GLOBALS['languageNames'] = $languageNames;


// ->> DOCUMENTROOT
/**
 * The absolut path of the webserver, with fix for IIS Server
 */
// use getcwd()?
// $filePath = (empty($_SERVER["SCRIPT_FILENAME"])) ? realpath(null) : realpath($_SERVER["SCRIPT_FILENAME"]);
// should realpath() fail, use just the $_SERVER["SCRIPT_FILENAME"] variable
// if($filePath === false && !empty($_SERVER["SCRIPT_FILENAME"])) $filePath = $_SERVER["SCRIPT_FILENAME"];
$filePath = str_replace('library/includes/general.include.php', '', __FILE__);

if(@is_file($_SERVER['DOCUMENT_ROOT'].XssFilter::path($_SERVER['PHP_SELF']))) {
  $docRoot = realpath($_SERVER['DOCUMENT_ROOT']);
} else {
  $fileDir = str_replace("\\","/",$filePath);
  $docRootPattern = str_replace('/','|',XssFilter::path($_SERVER['PHP_SELF']));
  $docRoot = preg_replace('#'.$docRootPattern.'#', '', $fileDir);
  if(substr($docRoot, -1) == '/')
    $docRoot = substr(preg_replace('#/+#','/',$docRoot), 0, -1);
}
// use the manual set documentroot if retrieving automatically didn't work
if(empty($docRoot) && !empty($adminConfig['documentroot']))
  $docRoot = $adminConfig['documentroot'];
elseif(empty($docRoot))
  $docRoot = false;
// remove last "/"
if(substr($docRoot, -1) == '/')
  $docRoot = substr($docRoot, 0, -1);

if(!@is_dir($docRoot))
  $docRoot = false;

define('DOCUMENTROOT', $docRoot);
unset($fileDir,$docRoot,$docRootPattern); //unset($docRoot,$basePath,$localpath,$absolutepath);

// ->> URIEXTENSION
/**
 * The URI extension which is add by a redirected url.<br>
 * E.g. "mysite.com/user/index.php" is in real "/server/username/htdocs/index.php".<br>
 * So URIEXTENSION contains "/user", which will be add to absolute paths, so they will work also as URL paths.
 */
// get the filepath of the index.php file
// use getcwd()?
$filePath = (empty($_SERVER["SCRIPT_FILENAME"])) ? realpath(null) : realpath($_SERVER["SCRIPT_FILENAME"]);
// should realpath() fail, use just the $_SERVER["SCRIPT_FILENAME"] variable
if($filePath === false && !empty($_SERVER["SCRIPT_FILENAME"])) $filePath = $_SERVER["SCRIPT_FILENAME"];

if(!empty($filePath)) {
  $uriExtension = str_replace(DOCUMENTROOT, '', str_replace("\\","/",$filePath));
  $uriPattern = str_replace('/','|',preg_quote($uriExtension));
  $uriExtension = preg_replace('#'.$uriPattern.'#', '', dirname(XssFilter::path($_SERVER['PHP_SELF'])));
  $uriExtension = preg_replace('#/+#','/',$uriExtension);
  if(substr($uriExtension, -1) == '/')
   $uriExtension = substr($uriExtension, 0, -1);
  $uriExtension = (empty($uriExtension)) ? false : $uriExtension;
} else
  $uriExtension = '';

define('URIEXTENSION', $uriExtension);
unset($uriPattern,$uriExtension,$filePath);

// DebugTools::dump('DOCROOT: '.DOCUMENTROOT);
// DebugTools::dump('URI: '.URIEXTENSION);

/**
 * The required PHP version
 */
define('REQUIREDPHPVERSION','5.1');


/**
 * The host of feindura
 */
define('HOST', $_SERVER['SERVER_NAME']);


/**
 * The identity of the user
 */
if(strpos($_SERVER['REMOTE_ADDR'],'::1') !== false) $_SERVER['REMOTE_ADDR'] = '127.0.0.1';
  define('IDENTITY', md5($_SERVER['HTTP_USER_AGENT'].'::'.$_SERVER['REMOTE_ADDR']));


// -> GET VERSION and BUILD
// use VERSION file
if(is_dir(dirname(__FILE__).'/../../pages')) {
  $changelogFile = @file(dirname(__FILE__)."/../../pages/VERSION");
  $version = trim($changelogFile[1]);
  $buildNr = trim($changelogFile[2]);

// if no pages folder exist (new feindura installation) use the CHANGELOG file (to create VERSION file later in createBasicFilesAndFolders())
} elseif($prevVersionFile = @file(dirname(__FILE__).'/../../CHANGELOG')) {
  $version = trim($prevVersionFile[2]);
  $buildNr = trim($prevVersionFile[3]);
  $buildNr = str_replace('Build ', '', $buildNr);
}

/**
 * The version of feindura
 */
define('VERSION',$version);

/**
 * The build number of feindura
 */
define('BUILD',$buildNr);
unset($changelogFile,$prevVersionFile,$version,$buildNr);


// INIT STATIC CLASSES
GeneralFunctions::init();
StatisticFunctions::init();

// BENCHMARK end
// $timer = explode( ' ', microtime() );
// $endTime = $timer[1] + $timer[0];
// echo round($endTime - $startTime,4).'<br>';
?>