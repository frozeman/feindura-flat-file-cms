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
 * includes/secure.include.php
 *
 * This file will be included to run the login.include.php and check untrusted data before executing the script.
 *
 * @version 0.3
 *
 */


/**
 * first includes all necessary configs, functions and classes
 */
require_once(dirname(__FILE__)."/backend.include.php");

// ->> Then check incoming data like category and page vars
// *****************************

// -> check PHP vars
$_SERVER['PHP_SELF'] = XssFilter::path($_SERVER['PHP_SELF']);

// ->> CHECK the GET and POST variables
if(isset($_GET['category'])) $_GET['category']   = XssFilter::int($_GET['category'],0);
if(isset($_POST['category'])) $_POST['category'] = XssFilter::int($_POST['category'],0);
if(isset($_GET['page']) && $_GET['page'] !== 'new') $_GET['page']    = XssFilter::int($_GET['page'],0);
if(isset($_POST['page']) && $_POST['page'] !== 'new') $_POST['page'] = XssFilter::int($_POST['page'],0);

if(isset($_GET['site'])) $_GET['site']   = XssFilter::stringStrict($_GET['site']);
if(isset($_GET['addon'])) $_GET['addon'] = XssFilter::path($_GET['addon']);
if(isset($_GET['file'])) $_GET['file']   = XssFilter::path($_GET['file']);

/**
 * Then includes the login
 */
require_once(dirname(__FILE__).'/login.include.php');


// ->> CHECK PERMISSIONS

// pages
if(!empty($_GET['page']) && !GeneralFunctions::hasPermission('editablePages',$_GET['page']))
  unset($_GET);

// websiteSetup
if($_GET['site'] == 'websiteSetup' && !GeneralFunctions::hasPermission('websiteSettings'))
  unset($_GET['site']);

?>