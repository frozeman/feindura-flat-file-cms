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
* backend.include.php version 0.22
*/

//error_reporting(E_ALL | E_STRICT); //E_ALL & ~E_NOTICE


// -> START SESSION (for what?)
session_cache_limiter(60);
session_start();

require_once(dirname(__FILE__)."/general.include.php");

/*
// GET VARs
if(isset($_GET['site']))  $GETsite = $_GET['site'];
else  $GETsite = null;

if(isset($_GET['page']))  $GETpage = $_GET['page'];
else  $GETpage = null;

if(isset($_GET['category']))  $GETcategory = $_GET['category'];
else  $GETcategory = null;

if(isset($_GET['status']))  $GETstatus = $_GET['status'];
else  $GETstatus = null;

if(isset($_GET['public']))  $GETpublic = $_GET['public'];
else  $GETpublic = null;

if(isset($_GET['file']))  $GETfile = $_GET['file'];
else  $GETfile = null;

if(isset($_GET['search']))  $GETsearch = $_GET['search'];
else  $GETsearch = null;
*/

// *---* sets the basic VARIABLEs ---------------------------------------------------------
$errorWindow = false;
$documentSaved = false;
$savedForm = false;
$newPage = false;


// get SETTINGS
$adminConfig =       @include_once(dirname(__FILE__)."/../config/adminConfig.php");
$websiteConfig =     @include_once(dirname(__FILE__)."/../config/websiteConfig.php");
$statisticConfig =   @include_once(dirname(__FILE__)."/../config/statisticConfig.php");
$categories =        @include_once(dirname(__FILE__)."/../config/categoryConfig.php");
$websiteStatistic =  @include_once(dirname(__FILE__)."/../statistic/websiteStatistic.php");

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