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
if(!$adminConfig = @include_once(dirname(__FILE__)."/../../config/admin.config.php"))
  $adminConfig = array();
if(empty($adminConfig['permissions'])) $adminConfig['permissions'] = 0755;
$GLOBALS['adminConfig'];

/**
 * The user-settings config
 * 
 * This config <var>array</var> is included from: <i>"feindura-CMS/config/user.config.php"</i>
 * 
 * @global array $GLOBALS['userConfig']
 */
if(!$userConfig = @include_once(dirname(__FILE__)."/../../config/user.config.php"))
  $userConfig = array();
$GLOBALS['userConfig'];

/**
 * The website-settings config
 * 
 * This config <var>array</var> is included from: <i>"feindura-CMS/config/website.config.php"</i>
 * 
 * @global array $GLOBALS['websiteConfig']
 */
if(!$websiteConfig = @include_once(dirname(__FILE__)."/../../config/website.config.php"))
  $websiteConfig = array();
$GLOBALS['websiteConfig'];

/**
 * The categories-settings config
 * 
 * This config <var>array</var> is included from: <i>"feindura-CMS/config/category.config.php"</i>
 * 
 * @global array $GLOBALS['categoryConfig']
 */
if(!$categoryConfig = @include_once(dirname(__FILE__)."/../../config/category.config.php"))
  $categoryConfig = array();
$GLOBALS['categoryConfig'];

/**
 * The statistic-settings config
 * 
 * This config <var>array</var> is included from: <i>"feindura-CMS/config/statistic.config.php"</i>
 * 
 * @global array $GLOBALS['statisticConfig']
 */
if(!$statisticConfig = @include_once(dirname(__FILE__)."/../../config/statistic.config.php"))
  $statisticConfig = array();
$GLOBALS['statisticConfig'];

/**
 * The plugin-settings config
 * 
 * This config <var>array</var> is included from: <i>"feindura-CMS/config/plugin.config.php"</i>
 * 
 * @global array $GLOBALS['pluginsConfig']
 */
if(!$pluginsConfig = @include_once(dirname(__FILE__)."/../../config/plugins.config.php"))
  $pluginsConfig = array();
$GLOBALS['pluginsConfig'];


/**
 * The website-statistics
 * 
 * This statistics <var>array</var> is included from: <i>"feindura-CMS/config/website.statistic.php"</i>
 * 
 * @global array $GLOBALS['websiteStatistic']
 */
if($fp = @fopen(dirname(__FILE__).'/../../statistic/website.statistic.php','r')) {
  flock($fp,LOCK_SH);
  if(!$websiteStatistic = @include_once(dirname(__FILE__)."/../../statistic/website.statistic.php")) $websiteStatistic = array();
  flock($fp,LOCK_UN);
  fclose($fp);
} else
  $websiteStatistic = array();
$GLOBALS['websiteStatistic'];


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
define('DOCUMENTROOT', str_replace($adminConfig['basePath'].'library/includes/general.include.php','',__FILE__));

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
if($_SERVER['REMOTE_ADDR'] == '::1') $_SERVER['REMOTE_ADDR'] = '127.0.0.1';
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
?>