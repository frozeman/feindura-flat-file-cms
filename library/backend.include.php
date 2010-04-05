<?php 
/*
    feindura - Flat File Content Management System
    Copyright (C) 2009 Fabian Vogelsteller [frozeman.de]

    This program is free software;
    you can redistribute it and/or modify it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 3 of the License, or (at your option) any later version.

    This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY;
    without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
    See the GNU General Public License for more details.

    You should have received a copy of the GNU General Public License along with this program;
    if not,see <http://www.gnu.org/licenses/>.
*
* backend.include.php version 0.23
*/

error_reporting(E_ALL & ~E_NOTICE); //E_ALL & ~E_NOTICE


// -> START SESSION (for what?)
session_cache_limiter(60);
session_start();

require_once(dirname(__FILE__)."/general.include.php");


// *---* sets the basic VARIABLEs ---------------------------------------------------------
$errorWindow = false;
$documentSaved = false;
$savedForm = false;
$newPage = false;


// get SETTINGS
$adminConfig =       @include_once(dirname(__FILE__)."/../config/admin.config.php");
$websiteConfig =     @include_once(dirname(__FILE__)."/../config/website.config.php");
$statisticConfig =   @include_once(dirname(__FILE__)."/../config/statistic.config.php");
$categories =        @include_once(dirname(__FILE__)."/../config/category.config.php");
$websiteStatistic =  @include_once(dirname(__FILE__)."/../statistic/website.statistic.php");

require_once(dirname(__FILE__)."/functions/backend.functions.php");

require_once(dirname(__FILE__)."/classes/generalFunctions.class.php");
require_once(dirname(__FILE__)."/classes/statisticFunctions.class.php");

// GET FUNCTIONS
$generalFunctions = new generalFunctions();
$statisticFunctions = new statisticFunctions();


// ->> choose LANGUAGE START -----------------------------------------------------
// language shortname will be transfered trough a session (needs COOKIES!)
// and includes the langFile

//unset($_SESSION['language']);
//$_SESSION['language'] = 'de';

if(empty($_SESSION['language'])) {
  // gets the BROWSER STANDARD language
  $_SESSION['language'] = $generalFunctions->getLanguage($adminConfig['basePath'].'library/lang/',false); // returns a COUNTRY SHORTNAME
}

// includes the langFile which is set by the session var
$langFile = include(dirname(__FILE__).'/lang/'.$_SESSION['language'].'.backend.php');

// *---* choose LANGUAGE END -----------------------------------------------------

?>