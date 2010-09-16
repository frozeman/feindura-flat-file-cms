<?php 
/*
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
 */
/**
 * This file includes all necessary <var>classes</var> and configs for the use in the FRONTEND and the BACKEND
 *
 * @version 0.13
 */

error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING); //E_ALL & ~E_NOTICE

/**
 * The absolut path of the webserver
 */ 
define('DOCUMENTROOT',$_SERVER["DOCUMENT_ROOT"]);

$phpTags = file(dirname(__FILE__)."/process/phptags.txt"); 
/**
 * The php start tag for us in saveing functions
 */ 
define('PHPSTARTTAG',$phpTags[0]."\n");
/**
 * The php end tag for us in saveing functions
 */ 
define('PHPENDTAG',"\n".$phpTags[1]);

// get SETTINGS

/**
 * The administrator-settings config
 * 
 * This config <var>array</var> is included from: <i>"feindura-CMS/config/admin.config.php"</i>
 * 
 * @global array $GLOBALS['adminConfig']
 */
$GLOBALS['adminConfig'];
if(!$adminConfig =      @include_once(dirname(__FILE__)."/../config/admin.config.php"))
  $adminConfig =      array();

/**
 * The website-settings config
 * 
 * This config <var>array</var> is included from: <i>"feindura-CMS/config/website.config.php"</i>
 * 
 * @global array $GLOBALS['websiteConfig']
 */
$GLOBALS['websiteConfig'];
if(!$websiteConfig =    @include_once(dirname(__FILE__)."/../config/website.config.php"))
  $websiteConfig =    array();

/**
 * The categories-settings config
 * 
 * This config <var>array</var> is included from: <i>"feindura-CMS/config/category.config.php"</i>
 * 
 * @global array $GLOBALS['categoryConfig']
 */
$GLOBALS['categoryConfig'];
if(!$categoryConfig =   @include_once(dirname(__FILE__)."/../config/category.config.php"))
  $categoryConfig =       array();

/**
 * The statistic-settings config
 * 
 * This config <var>array</var> is included from: <i>"feindura-CMS/config/statistic.config.php"</i>
 * 
 * @global array $GLOBALS['statisticConfig']
 */
$GLOBALS['statisticConfig'];
if(!$statisticConfig =  @include_once(dirname(__FILE__)."/../config/statistic.config.php"))
  $statisticConfig =  array();

/**
 * The plugin-settings config
 * 
 * This config <var>array</var> is included from: <i>"feindura-CMS/config/plugin.config.php"</i>
 * 
 * @global array $GLOBALS['pluginsConfig']
 */
$GLOBALS['pluginsConfig'];
if(!$pluginsConfig =  @include_once(dirname(__FILE__)."/../config/plugins.config.php"))
  $pluginsConfig =  array();


/**
 * The website-statistics
 * 
 * This statistics <var>array</var> is included from: <i>"feindura-CMS/config/website.statistic.php"</i>
 * 
 * @global array $GLOBALS['websiteStatistic']
 */
$GLOBALS['websiteStatistic'];
if(!$websiteStatistic = @include_once(dirname(__FILE__)."/../statistic/website.statistic.php"))
  $websiteStatistic = array();


// INCLUDES
/**
 * Includes the {@link sort.functions.php}
 */ 
require_once(dirname(__FILE__)."/functions/sort.functions.php");

/**
 * Includes the {@link generalFunctions} <var>class</var>
 */
require_once(dirname(__FILE__)."/classes/generalFunctions.class.php");

/**
 * Includes the {@link statisticFunctions} <var>class</var>
 */
require_once(dirname(__FILE__)."/classes/statisticFunctions.class.php");

?>