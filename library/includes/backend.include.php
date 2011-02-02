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

* backend.include.php version 0.25
*/

// -> START SESSION (for the login, language and storedPages [currently deactivated])
ini_set('session.gc_maxlifetime', 10800); // saves the session for 180 minutes
session_name("session");
session_start();

// INCLUDES
require_once(dirname(__FILE__)."/general.include.php");
require_once(dirname(__FILE__)."/../functions/backend.functions.php");

// set the time zone
ini_set('date.timezone',$adminConfig['timeZone']);
date_default_timezone_set($adminConfig['timeZone']);

// create the config, pages and statistic folders if they dont exist
createBasicFolders();

// INIT STATIC CLASSES
generalFunctions::init();
statisticFunctions::init();

// *---* sets the basic VARIABLEs ---------------------------------------------------------
$errorWindow = false;
$documentSaved = false;
$savedForm = false;
$newPage = false;

// -> SET ERROR HANDLER
@set_error_handler("showErrorsInWindow",E_ALL ^ E_NOTICE);// E_ALL ^ E_NOTICE ^ E_WARNING

// ->> choose LANGUAGE * START * -----------------------------------------------------
// language shortname will be transfered trough a session (needs COOKIES!)
// and includes the langFile

// -> check language
if((isset($_GET['language']) && ($_GET['language'] = xssFilter::alphabetical($_GET['language'])) === false) ||
   (isset($_SESSION['language']) && ($_SESSION['language'] = xssFilter::alphabetical($_SESSION['language'])) === false))
  die('Wrong &quot;language&quot; parameter! Parameter can only have alphabetical characters. Script will be terminated.');

if(isset($_GET['language']))
  $_SESSION['language'] = $_GET['language'];

//unset($_SESSION['language']);

if(empty($_SESSION['language'])) {
  // gets the BROWSER LANGUAGE
  $_SESSION['language'] = generalFunctions::checkLanguageFiles(false,false,'en'); // returns a COUNTRY SHORTNAME
}

$frontendLangFilePath = dirname(__FILE__).'/../languages/'.$_SESSION['language'].'.backend.php';
$sharedLangFilePath = dirname(__FILE__).'/../languages/'.$_SESSION['language'].'.shared.php';
// includes the langFiles which is set by the session var
if(file_exists($frontendLangFilePath) && file_exists($sharedLangFilePath)) {
  $sharedLangFile = include($sharedLangFilePath);
  $backendLangFile = include($frontendLangFilePath);  

  $langFile = $sharedLangFile + $backendLangFile;
      
  unset($backendLangFile,$sharedLangFile);
}
// *---* choose LANGUAGE * END * -----------------------------------------------------

?>