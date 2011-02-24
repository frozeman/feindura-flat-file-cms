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

* includes/secure.include.php version 0.1
* 
* this file will be included to run the login.include.php and check untrusted data before executing the script
*/

/**
 * first includes all necessary configs, functions and classes
 */
require_once(dirname(__FILE__)."/backend.include.php");

// ->> Then check incoming data like category and page vars
// *****************************

// ->> CHECK the GET and POST variables
// -> check CATEGORY
if((isset($_GET[$category]) && xssFilter::int($_GET[$category]) === false) ||
   (isset($_POST[$category]) && xssFilter::int($_POST[$category]) === false))
  die('Wrong &quot;'.$category.'&quot; parameter! Script will be terminated.');
// -> check PAGE
if((isset($_GET[$page]) && $_GET[$page] != 'new' && xssFilter::int($_GET[$page]) === false) ||
   (isset($_POST[$page]) && $_POST[$page] != 'new' && xssFilter::int($_POST[$page]) === false))
  die('Wrong &quot;'.$page.'&quot; parameter! Script will be terminated.');

// ->> CHECK INPUTS
// ****************

// -> check SITE
if(isset($_GET['site'])) $_GET['site'] = xssFilter::alphaNumeric($_GET['site']);

// -> check USERNAME
if(isset($_POST['username'])) $_POST['username'] = xssFilter::text($_POST['username']);
// -> check PASSWORD
if(isset($_POST['password'])) $_POST['password'] = xssFilter::text($_POST['password']);

// -> check USERNAME and PASSWORD while SAVING
if(is_array($_POST['users'])) {
  foreach($_POST['users'] as $key => $users) {
    $_POST['users'][$key]['username'] = (isset($_POST['users'][$key]['username']))? xssFilter::text($_POST['users'][$key]['username']) : '';
    $_POST['users'][$key]['password'] = (isset($_POST['users'][$key]['password']))? xssFilter::text($_POST['users'][$key]['password']) : '';
    $_POST['users'][$key]['password_confirm'] = (isset($_POST['users'][$key]['password_confirm']))? xssFilter::text($_POST['users'][$key]['password_confirm']) : '';
  }
}

//echo 'GET->'.$_GET['page'].'<br>';
//echo 'POST->'.$_POST['username'];

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
  
  <meta name="siteinfo" content="<?= dirname($_SERVER['PHP_SELF']).'/'; ?>robots.txt" />
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
   
  <link rel="shortcut icon" href="<?= dirname($_SERVER['PHP_SELF']).'/'; ?>favicon.ico" />
  
  <link rel="stylesheet" type="text/css" href="library/styles/reset.css" media="all" />
  <link rel="stylesheet" type="text/css" href="library/styles/login.css" media="all" />

</head>
<body>
  <div id="container">
    <div id="loginSuccessBox">
      <div class="top"></div>
      <div class="middle">     
      <?php      
      echo $langFile['ADMINSETUP_ERROR_PHPVERSION'].' '.REQUIREDPHPVERSION;
      ?>
      </div>
      <div class="bottom"></div>
    </div>
</body>
</html>
<?php
  die();
}

/**
 * Then includes the login
 */
require_once(dirname(__FILE__).'/login.include.php');

?>