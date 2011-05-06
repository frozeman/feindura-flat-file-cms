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

* processes/userSetup.process.php version 0.1
*/

/**
 * Includes the login.include.php and backend.include.php and filter the basic data
 */
require_once(dirname(__FILE__)."/../includes/secure.include.php");

// VARs
// ---------------------------------------------------------------------------
$userInfo = false;
$userInfoPassword = false;
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
  $userConfig['UnnamedUser'] = array('id' => $newId);
  if(saveUserConfig($userConfig)) {
     $userInfo = $langFile['userSetup_createUser_created'];
     StatisticFunctions::saveTaskLog(25); // <- SAVE the task in a LOG FILE
  } else { // throw error
    $errorWindow .= ($errorWindow) // if there is allready an warning
      ? '<br /><br />'.$langFile['userSetup_error_create']
      : $langFile['userSetup_error_create']; 
  }
     
  } else // throw error
    $errorWindow .= $langFile['userSetup_error_create'];
    
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
    $userInfo = $langFile['userSetup_deleteUser_deleted'].': '.$storedUserName;
    $documentSaved = true; // set documentSaved status
    StatisticFunctions::saveTaskLog(26,$storedUserName); // <- SAVE the task in a LOG FILE
  } else
    $errorWindow .= $langFile['userSetup_error_save'];
    
  $savedSettings = true;
}

// ****** ---------- SAVE USERS
if(isset($_POST['send']) && $_POST['send'] == 'userSetup') {
  
  // var
  $userPassChanged = false;
    
  $newUserConfig = $_POST['users'];
  // prepare user POST data
  foreach($newUserConfig as $user => $configs) {
    $newUserConfig[$configs['username']] = $configs;
    unset($newUserConfig[$user]);
    $configs['password'] = XssFilter::text($configs['password']);
    $configs['password_confirm'] = XssFilter::text($configs['password_confirm']);
    
    // CHECK for password change
    if(!empty($configs['password']) && $configs['password'] != $userConfig[$configs['username']]['password']) {
      // check confirmation
      if($configs['password'] == $configs['password_confirm']) {
        $newUserConfig[$configs['username']]['password'] = md5($newUserConfig[$configs['username']]['password']);
        $userPassChanged = true;        
        $userInfoPassword[$configs['username']] = '<tr><td clas="left"></td><td><span class="blue">'.$langFile['userSetup_password_success'].'</span></td></tr>';
      } else {
        $userInfo = $langFile['userSetup_password_confirm_wrong'];
        $userInfoPassword[$configs['username']] = '<tr><td clas="left"></td><td><span class="red">'.$userInfo.'</span></td></tr>';
        $newUserConfig[$configs['username']]['password'] = $userConfig[$configs['username']]['password'];
      }
    } else
      $newUserConfig[$configs['username']]['password'] = $userConfig[$configs['username']]['password'];
    
    // clear the password confirm var
    unset($newUserConfig[$configs['username']]['password_confirm']);
    
    // get the username which was saved
    $savedUsername = ($_POST['savedUserId'] = $configs['id']) ? $configs['username'] : '';
  }
  
  ksort($newUserConfig);
  
  if(saveUserConfig($newUserConfig)) {
    $documentSaved = true; // set documentSaved status
    if($userPassChanged)
      StatisticFunctions::saveTaskLog(27,$savedUsername); // <- SAVE the task in a LOG FILE
    else
      StatisticFunctions::saveTaskLog(28,$savedUsername); // <- SAVE the task in a LOG FILE
  } else
    $errorWindow .= $langFile['userSetup_error_save'];
    
  $savedSettings = true;
}

// RE-INCLUDE
if($savedSettings) {
  unset($userConfig);
  $userConfig = @include(dirname(__FILE__)."/../../config/user.config.php");
}

?>