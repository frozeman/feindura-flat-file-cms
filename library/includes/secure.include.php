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
if((isset($_GET[$category]) && $this->xssFilter->int($_GET[$category]) === false) ||
   (isset($_POST[$category]) && $this->xssFilter->int($_POST[$category]) === false))
  die('Wrong &quot;'.$category.'&quot; parameter! Script will be terminated.');
// -> check PAGE
if((isset($_GET[$page]) && $_GET[$page] != 'new' && $this->xssFilter->int($_GET[$page]) === false) ||
   (isset($_POST[$page]) && $_POST[$page] != 'new' && $this->xssFilter->int($_POST[$page]) === false))
  die('Wrong &quot;'.$page.'&quot; parameter! Script will be terminated.');

// ->> CHECK INPUTS
// ****************

// -> check SITE
if(isset($_GET['site'])) $_GET['site'] = $xssFilter->alphaNumeric($_GET['site']);

// -> check SEARCH
if(isset($_GET['search'])) $_GET['search'] = $xssFilter->textVar($_GET['search']);
if(isset($_POST['search'])) $_POST['search'] = $xssFilter->textVar($_POST['search']);

// -> check USERNAME
if(isset($_POST['username'])) $_POST['username'] = $xssFilter->textVar($_POST['username']);
// -> check PASSWORD
if(isset($_POST['password'])) $_POST['password'] = $xssFilter->textVar($_POST['password']);

// -> check USERNAME and PASSWORD while SAVING
if(is_array($_POST['users'])) {
  foreach($_POST['users'] as $key => $users) {
    $_POST['users'][$key]['username'] = (isset($_POST['users'][$key]['username']))? $xssFilter->textVar($_POST['users'][$key]['username']) : '';
    $_POST['users'][$key]['password'] = (isset($_POST['users'][$key]['password']))? $xssFilter->textVar($_POST['users'][$key]['password']) : '';
    $_POST['users'][$key]['password_confirm'] = (isset($_POST['users'][$key]['password_confirm']))? $xssFilter->textVar($_POST['users'][$key]['password_confirm']) : '';
  }
}

//echo 'GET->'.$_GET['page'].'<br>';
//echo 'POST->'.$_POST['username'];

/**
 * Then includes the login
 */
require_once(dirname(__FILE__).'/login.include.php');

?>