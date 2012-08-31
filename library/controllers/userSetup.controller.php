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

* controllers/userSetup.controller.php version 0.1
*/

/**
 * Includes the login.include.php and backend.include.php and filter the basic data
 */
require_once(dirname(__FILE__)."/../includes/secure.include.php");

// VARs
// ---------------------------------------------------------------------------
$newUserConfig = array();


// ****** ---------- CREATE NEW USER
if((isset($_POST['send']) && $_POST['send'] ==  'userSetup' && isset($_POST['createUser'])) ||
   $_GET['status'] == 'createUser') {

  // -> GET highest user id
  $newId = getNewUserId();

  if(is_numeric($newId)) {
    if($newId == 1)
      $userConfig = array();

  // add a new user to the user array
  $userConfig[$newId] = array('id' => $newId);

  // default user settings
  $userConfig[$newId]['permissions']['websiteSettings'] = true;

  if(saveUserConfig($userConfig)) {
     $notification .= '<div class="alert alert-success">'.$langFile['USERSETUP_createUser_created'].'</div>';
     saveActivityLog(25); // <- SAVE the task in a LOG FILE
  } else { // throw error
    $errorWindow .= ($errorWindow) // if there is already an warning
      ? '<br><br>'.sprintf($langFile['USERSETUP_error_create'],$adminConfig['basePath'])
      : sprintf($langFile['USERSETUP_error_create'],$adminConfig['basePath']);
  }

  } else // throw error
    $errorWindow .= sprintf($langFile['USERSETUP_error_create'],$adminConfig['basePath']);

  $savedSettings = true;
}

// ****** ---------- DELETE USER
if(((isset($_POST['send']) && $_POST['send'] ==  'userSetup' && isset($_POST['deleteUser'])) ||
   $_GET['status'] == 'deleteUser')) {

  $newUserConfig = $userConfig;
  foreach($newUserConfig as $key => $value) {
    if($value['id'] == $_GET['userId']) {
      // save the name, to put it in the info
      $storedUserName = $value['username'];
      unset($newUserConfig[$key]);
    }
  }

  if(saveUserConfig($newUserConfig)) {
    $notification .= '<div class="alert alert-info">'.$langFile['USERSETUP_deleteUser_deleted'].'<br><strong>'.$storedUserName.'</strong></div>';
    $documentSaved = true; // set documentSaved status
    saveActivityLog(26,$storedUserName); // <- SAVE the task in a LOG FILE
  } else
    $errorWindow .= sprintf($langFile['USERSETUP_error_save'],$adminConfig['basePath']);

  $savedSettings = true;
}

// ****** ---------- SAVE USERS
if(isset($_POST['send']) && $_POST['send'] == 'userSetup') {

// GeneralFunctions::dump($_POST);

  // var
  $userPassChanged = false;
  $userPassError = false;
  $newUserConfig = $_POST['users'];

  // prepare user POST data
  foreach($newUserConfig as $user => $configs) {

    // transfer the permssions
    $newUserConfig[$configs['id']]['permissions'] = $userConfig[$configs['id']]['permissions'];
    $newUserConfig[$configs['id']]['info']       = GeneralFunctions::htmLawed($configs['info'],array('tidy'=>1));

    // filter password
    $configs['password'] = XssFilter::text($configs['password']);
    $configs['password_confirm'] = XssFilter::text($configs['password_confirm']);

    // CHECK for password change
    if(!empty($configs['password']) && $configs['password'] != $userConfig[$configs['id']]['password']) {
      // check confirmation
      if($configs['password'] == $configs['password_confirm']) {
        $newUserConfig[$configs['id']]['password'] = md5($newUserConfig[$configs['id']]['password']);
        $userPassChanged = true;
        $notification .= '<div class="alert alert-success">'.$langFile['USERSETUP_password_success'].'</div>';
      } else {
        $newUserConfig[$configs['id']]['password'] = $userConfig[$configs['id']]['password'];
        $notification .= '<div class="alert alert-error">'.$langFile['USERSETUP_password_confirm_wrong'].'</div>';
        $userPassError = true;
      }
    } else
      $newUserConfig[$configs['id']]['password'] = $userConfig[$configs['id']]['password'];

    // clear the password confirm var
    unset($newUserConfig[$configs['id']]['password_confirm']);
  }

  ksort($newUserConfig);

// GeneralFunctions::dump($newUserConfig);

  if(saveUserConfig($newUserConfig)) {

    if(!$userPassError)
      $documentSaved = true; // set documentSaved status
    if($userPassChanged)
      saveActivityLog(27,$savedUsername); // <- SAVE the task in a LOG FILE
    else
      saveActivityLog(28,$savedUsername); // <- SAVE the task in a LOG FILE
  } else
    $errorWindow .= sprintf($langFile['USERSETUP_error_save'],$adminConfig['basePath']);

  $savedSettings = true;
}

// RE-INCLUDE
if($savedSettings) {
  unset($userConfig);
  $userConfig = @include(dirname(__FILE__)."/../../config/user.config.php");
}

?>