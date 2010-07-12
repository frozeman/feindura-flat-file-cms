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

* backend.include.php version 0.24
*/

error_reporting(E_ALL & ~E_NOTICE); //E_ALL & ~E_NOTICE

// -> START SESSION (for the language and storedPages [currently deactivated])
session_cache_limiter(60);
session_name("feinduraBackend");
session_start();

// INCLUDES
require_once(dirname(__FILE__)."/general.include.php");
require_once(dirname(__FILE__)."/functions/backend.functions.php");

// GET FUNCTIONS
$generalFunctions = new generalFunctions();
$statisticFunctions = new statisticFunctions();

// *---* sets the basic VARIABLEs ---------------------------------------------------------
$errorWindow = false;
$documentSaved = false;
$savedForm = false;
$newPage = false;


// ->> choose LANGUAGE START -----------------------------------------------------
// language shortname will be transfered trough a session (needs COOKIES!)
// and includes the langFile

if(isset($_GET['language']))
  $_SESSION['language'] = $_GET['language'];

//unset($_SESSION['language']);

if(empty($_SESSION['language'])) {
  // gets the BROWSER LANGUAGE
  $_SESSION['language'] = $generalFunctions->checkLanguageFiles(false,false,'en'); // returns a COUNTRY SHORTNAME
}

// includes the langFile which is set by the session var
$langFile = include(dirname(__FILE__).'/lang/'.$_SESSION['language'].'.backend.php');

// *---* choose LANGUAGE END -----------------------------------------------------

?>