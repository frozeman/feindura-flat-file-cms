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
 * @version 0.25
 */

// -> START SESSION (for the login, language and storedPages [currently deactivated])
ini_set('session.gc_maxlifetime', 10800); // saves the session for 180 minutes
session_name("session");
session_start();

// INCLUDE GENERAL
require_once(dirname(__FILE__)."/general.include.php");

// ->> CHECK PHP VERSION
// *********************
if(PHP_VERSION < REQUIREDPHPVERSION) {
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="content-type" content="application/xhtml+xml; charset=UTF-8" />
  <meta http-equiv="content-language" content="en" />
  
  <title>feindura PHP error</title>
  
  <meta http-equiv="X-UA-Compatible" content="chrome=1">
  
  <meta name="robots" content="no-index,nofollow" />
  <meta http-equiv="pragma" content="no-cache" /> <!--browser/proxy dont cache-->
  <meta http-equiv="cache-control" content="no-cache" /> <!--proxy dont cache-->
  <meta http-equiv="accept-encoding" content="gzip, deflate" />
  
  <meta name="title" content="feindura login" />    
  <meta name="author" content="Fabian Vogelsteller [frozeman.de]" />     
  <meta name="publisher" content="Fabian Vogelsteller [frozeman.de]" />
  <meta name="copyright" content="Fabian Vogelsteller [frozeman.de]" />    
  <meta name="description" content="A flat file based Content Management System, written in PHP" />    
  <meta name="keywords" content="cms,content,management,system,flat,file" />
   
  <link rel="shortcut icon" href="favicon.ico" />
  
  <link rel="stylesheet" type="text/css" href="library/styles/reset.css" media="all" />
  <link rel="stylesheet" type="text/css" href="library/styles/login.css" media="all" />

</head>
<body>
  <div id="container">
    <div id="loginSuccessBox">
      <div class="top"></div>
      <div class="middle">     
      <?php      
      echo 'ERROR<br /><br /><span class="logoname">fein<span>dura</span></span> requires at least PHP version '.REQUIREDPHPVERSION;
      ?>
      </div>
      <div class="bottom"></div>
    </div>
</body>
</html>
<?php
  die();
}
// PHP VERSION CHECK *** END
// *************************

// INCLUDE FUNCTIONS
require_once(dirname(__FILE__)."/../functions/backend.functions.php");

// -> SET ERROR HANDLER
@set_error_handler("showErrorsInWindow",E_ALL ^ E_NOTICE);// E_ALL ^ E_NOTICE ^ E_WARNING

// set the time zone
ini_set('date.timezone',$adminConfig['timeZone']);
date_default_timezone_set($adminConfig['timeZone']);
mb_internal_encoding('UTF-8');
mb_http_output('UTF-8');

// create the config, pages and statistic folders if they dont exist
createBasicFolders();

// INIT STATIC CLASSES
generalFunctions::init();
statisticFunctions::init();

// *---* sets the basic VARIABLEs ---------------------------------------------------------
$frontendEditing  = false; // used to include this backend.inlcude.php script into the secure.include.php, if true it only loads the feindura.include.php
$errorWindow      = false; // when string the errorWindow with this string is displayed
$documentSaved    = false; // when true the document saved icon is displayed
$savedForm        = false; // to tell wich part fo the form was saved
$savedSettings    = false; // to tell wich settings were saved, to re-include the settings
$newPage          = false; // tells the editor whether a new page is created

// ->> choose LANGUAGE * START * -----------------------------------------------------
// language shortname will be transfered trough a session (need COOKIES!)
// and includes the langFile

// -> check language
//unset($_SESSION['feindura']['language']);
if(isset($_GET['language'])) $_GET['language'] = xssFilter::alphabetical($_GET['language']);
if(isset($_SESSION['feindura']['language'])) $_SESSION['feindura']['language'] = xssFilter::alphabetical($_SESSION['feindura']['language']);
if(isset($_GET['language'])) $_SESSION['feindura']['language'] = $_GET['language'];

$backendLangFile = generalFunctions::loadLanguageFile(false,'%lang%.backend.php',$_SESSION['feindura']['language']);
$sharedLangFile = generalFunctions::loadLanguageFile(false,'%lang%.shared.php',$_SESSION['feindura']['language']);

$langFile = array_merge($sharedLangFile,$backendLangFile);
unset($backendLangFile,$sharedLangFile);
// *---* choose LANGUAGE * END * -----------------------------------------------------

?>