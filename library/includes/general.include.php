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
 * @version 0.15
 */

header('Content-Type:text/html; charset=UTF-8');
error_reporting(E_ALL & ~E_NOTICE);// E_ALL ^ E_NOTICE ^ E_WARNING


// ->> get CONFIGS
/**
 * The administrator-settings config
 * 
 * This config <var>array</var> is included from: <i>"feindura-CMS/config/admin.config.php"</i>
 * 
 * @global array $GLOBALS['adminConfig']
 */
if(!$adminConfig = @include(dirname(__FILE__)."/../../config/admin.config.php"))
  $adminConfig = array();
if(empty($adminConfig['permissions'])) $adminConfig['permissions'] = 0755;
$GLOBALS['adminConfig'] = $adminConfig;

/**
 * The user-settings config
 * 
 * This config <var>array</var> is included from: <i>"feindura-CMS/config/user.config.php"</i>
 * 
 * @global array $GLOBALS['userConfig']
 */
if(!$userConfig = @include(dirname(__FILE__)."/../../config/user.config.php"))
  $userConfig = array();
$GLOBALS['userConfig'] = $userConfig;

/**
 * The website-settings config
 * 
 * This config <var>array</var> is included from: <i>"feindura-CMS/config/website.config.php"</i>
 * 
 * @global array $GLOBALS['websiteConfig']
 */
if(!$websiteConfig = @include(dirname(__FILE__)."/../../config/website.config.php"))
  $websiteConfig = array();
$GLOBALS['websiteConfig'] = $websiteConfig;

/**
 * The categories-settings config
 * 
 * This config <var>array</var> is included from: <i>"feindura-CMS/config/category.config.php"</i>
 * 
 * @global array $GLOBALS['categoryConfig']
 */
if(!$categoryConfig = @include(dirname(__FILE__)."/../../config/category.config.php"))
  $categoryConfig = array();
$GLOBALS['categoryConfig'] = $categoryConfig;

/**
 * The statistic-settings config
 * 
 * This config <var>array</var> is included from: <i>"feindura-CMS/config/statistic.config.php"</i>
 * 
 * @global array $GLOBALS['statisticConfig']
 */
if(!$statisticConfig = @include(dirname(__FILE__)."/../../config/statistic.config.php"))
  $statisticConfig = array();
$GLOBALS['statisticConfig'] = $statisticConfig;

/**
 * The website-statistics
 * 
 * This statistics <var>array</var> is included from: <i>"feindura-CMS/config/website.statistic.php"</i>
 * 
 * @global array $GLOBALS['websiteStatistic']
 */
if(!$websiteStatistic = @include(dirname(__FILE__)."/../../statistic/website.statistic.php"))
  $websiteStatistic = array();
$GLOBALS['websiteStatistic'] = $websiteStatistic;


/**
 * Fix the $_SERVER['REQUEST_URI'] for IIS Server
 */
if (!isset($_SERVER['REQUEST_URI'])) {
  $_SERVER['REQUEST_URI'] = substr($_SERVER['PHP_SELF'],0);
  if (isset($_SERVER['QUERY_STRING']) AND $_SERVER['QUERY_STRING'] != "") {
    $_SERVER['REQUEST_URI'] .= '?'.$_SERVER['QUERY_STRING'];
  }
}

/**
 * The absolut path of the webserver, with fix for IIS Server
 */
// ->> if no realBasePath exists, GENERATE the DOCUMENTROOT FROM the $_SERVER["SCRIPT_NAME"]
if(empty($adminConfig['realBasePath']) && !isset($_POST['cfg_basePath'])) {
  //echo 'generate the docRoot from PHP_SELF';
  $localpath=$_SERVER["PHP_SELF"];
  $absolutepath=realpath($localPath);
  // a fix for Windows slashes
  $absolutepath=str_replace("\\","/",$absolutepath);
  $docRoot = (dirname($localpath) != '/') ? str_replace(dirname($localpath),'',$absolutepath) : $absolutepath;
  
// ->> else GENERATE the DOCUMENTROOT THROUGH "__FILE__" - "$adminConfig['realBasePath']"
} else {
  // -> if the SETTINGS were SAVED FOR THE FIRST TIME (because of a basePathWarning())
  if(isset($_POST['cfg_basePath']) && $_POST['cfg_basePath'] != preg_replace('#/+#','/',dirname($_SERVER['PHP_SELF']).'/')) {
    //echo 'settings saved for the first time';
    $basePath = preg_replace('#/+#','/',dirname($_SERVER['PHP_SELF']).'/');
    
  // -> if the REAL BASE PATH was JUST SAVED, add slashes when missing
  } elseif((isset($_POST['cfg_realBasePath']))) {
    //echo 'realBasePath just saved';
    $basePath = $_POST['cfg_realBasePath'];
    if(substr($basePath,-1) !== '/')
      $basePath = $basePath.'/'; // add slash to the end
    if(substr($basePath,0,1) !== '/')
      $basePath = '/'.$basePath; // add slash to the start
    $basePath = preg_replace("#/+#",'/',$basePath);
    
  // -> else USE the REAL BASE PATH
  } else {
    //echo 'use the realBasePath';
    $basePath = $adminConfig['realBasePath'];
  }

  $docRoot = str_replace($basePath.'library/includes/general.include.php','',str_replace("\\","/",__FILE__));
  $docRoot = (strpos($docRoot,'general.include.php') !== false || empty($docRoot)) ? false : $docRoot;
}

define('DOCUMENTROOT', $docRoot); unset($docRoot,$basePath,$localpath,$absolutepath);

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

$phpTags = file(dirname(__FILE__)."/../includes/phpTags.include.php");
/**
 * The php start tag for us in saveing functions
 */ 
define('PHPSTARTTAG',$phpTags[0]."\n");
/**
 * The php end tag for us in saveing functions
 */ 
define('PHPENDTAG',"\n".$phpTags[1]);

// -> GET VERSION and BUILD nr
$changelogFile = file(dirname(__FILE__)."/../../CHANGELOG");
$version = trim($changelogFile[2]);
$buildNr = explode(' ',$changelogFile[3]);

/**
 * The version of feindura
 */ 
define('VERSION',$version);

/**
 * The build number of feindura
 */ 
define('BUILD',trim($buildNr[1]));


// ->> autoload CLASSES
/**
 * Autoloads all classes
 * 
 */
function __autoload($class_name) {
  if($class_name == 'GeneralFunctions' ||
     $class_name == 'StatisticFunctions' ||
     $class_name == 'XssFilter' ||
     $class_name == 'Search' ||
     $class_name == 'FeinduraBase' ||
     $class_name == 'Feindura')
  require_once(dirname(__FILE__)."/../classes/".$class_name.".class.php");
  return true;
}
  
// ->> FUNCTIONS
/**
 * Includes the main functions
 */ 
require_once(dirname(__FILE__)."/../functions/sort.functions.php");
require_once(dirname(__FILE__)."/../thirdparty/PHP/htmLawed.php");

// INIT STATIC CLASSES
GeneralFunctions::init();
StatisticFunctions::init();
?>