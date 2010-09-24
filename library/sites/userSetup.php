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

* userSetup.php version 0.1
*/

// VARs
// ---------------------------------------------------------------------------
$userInfo = false;
$userInfoPassword = false;
$newUserConfig = array();

// ----------------------------------------------------------------------------------------------------------------------------------------
// **--** SAVE PROCESS --------------------------------------------------------------------------------------------------------------------
// ----------------------------------------------------------------------------------------------------------------------------------------

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
     $statisticFunctions->saveTaskLog(25); // <- SAVE the task in a LOG FILE
  } else { // throw error
    $errorWindow .= ($errorWindow) // if there is allready an warning
      ? '<br /><br />'.$langFile['userSetup_error_create']
      : $langFile['userSetup_error_create']; 
  }
     
  } else // throw error
    $errorWindow .= $langFile['userSetup_error_create'];
    
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
    $statisticFunctions->saveTaskLog(26,$storedUserName); // <- SAVE the task in a LOG FILE
  } else
    $errorWindow .= $langFile['userSetup_error_save'];
}

// ****** ---------- SAVE USERS
if(isset($_POST['send']) && $_POST['send'] == 'userSetup') {  
  
  // var
  $userPassChanged = false;
    
  $newUserConfig = $_POST['users'];
  // prepare user POST data
  foreach($newUserConfig as $user => $configs) {
    $configs['username'] = $generalFunctions->cleanSpecialChars($configs['username'],'');
    $newUserConfig[$configs['username']] = $configs;
    unset($newUserConfig[$user]);
    
    // CHECK for password change
    if(!empty($configs['password']) && $configs['password'] != $userConfig[$configs['username']]['password']) {
      // check confirmation
      if($configs['password'] == $configs['password_confirm']) {
        $newUserConfig[$configs['username']]['password'] = md5($newUserConfig[$configs['username']]['password']);
        $userPassChanged = true;
      } else {
        $userInfo = $langFile['userSetup_password_confirm_wrong'];
        $userInfoPassword = '<tr><td clas="left"></td><td><span class="red">'.$userInfo.'</span></td></tr>';
        $userChangedPasword = $configs['username'];
        $newUserConfig[$configs['username']]['password'] = $userConfig[$configs['username']]['password'];
      }
    } else
      $newUserConfig[$configs['username']]['password'] = $userConfig[$configs['username']]['password'];
    
    // clear the password confirm var
    unset($newUserConfig[$configs['username']]['password_confirm']);
  }

  if(saveUserConfig($newUserConfig)) {
    $documentSaved = true; // set documentSaved status
    if($userPassChanged)
      $statisticFunctions->saveTaskLog(27,$_POST['savedUser']); // <- SAVE the task in a LOG FILE
    else
      $statisticFunctions->saveTaskLog(28,$_POST['savedUser']); // <- SAVE the task in a LOG FILE
  } else
    $errorWindow .= $langFile['userSetup_error_save'];
}


// RE-INCLUDE
unset($userConfig);
$userConfig = include(dirname(__FILE__)."/../../config/user.config.php");

// ------------------------------- ENDE of the SAVING SCRIPT -------------------------------------------------------------------------------


// CHECKs THE IF THE NECESSARY FILEs ARE WRITEABLE, otherwise throw an error
// ----------------------------------------------------------------------------------------

// check config files
$unwriteableList .= isWritableWarning($adminConfig['basePath'].'config/user.config.php');

// gives the error OUTPUT if one of these files in unwriteable
if($unwriteableList && checkBasePath()) {
  echo '<div class="block warning">
    <h1>'.$langFile['adminSetup_error_title'].'</h1>
    <div class="content">
      <p>'.$unwriteableList.'</p><!-- needs <p> tags for margin-left:..-->
    </div>
    <div class="bottom"></div>  
  </div>'; 
  
  echo '<div class="blockSpacer"></div>';
}
// ------------------------------------------------------------------------------------------- end WRITEABLE CHECK

?>

<!-- USER SETTINGS -->

<form action="index.php?site=userSetup" method="post" enctype="multipart/form-data" accept-charset="UTF-8" id="userForm">
  <div>
  <input type="hidden" name="send" value="userSetup" />
  <input type="hidden" name="savedUser" id="savedUser" value="" />
  </div>

<div class="block">
  <h1><?php echo $langFile['userSetup_h1']; ?></h1>
  <div class="content">
  
    <table>     
      <colgroup>
      <col class="left" />
      </colgroup>
  
      <tr><td class="leftTop"></td><td></td></tr>

      <tr><td class="left">
        <a href="?site=userSetup&amp;status=createUser#userId<?= getNewUserId(); ?>" class="createUser toolTip" title="<?php echo $langFile['userSetup_createUser']; ?>::"></a>
      </td><td class="right">
      <br />
      <?php
      // user info          
      if($userInfo)
        echo '<span class="hint"><b>'.$userInfo.'</b></span>';
      ?>
      </td></tr>
      
      <tr><td class="leftBottom"></td><td></td></tr>
      
    </table>
    <?php        

      // lists the users
      if(is_array($userConfig)) {
        foreach($userConfig as $user) {
        
          // prevent using the $check vars from the last user
          unset($checked);
          
          // checks the user settings
          $checked[1] = ($user['admin']) ? 'checked="checked"' : '';
          
          // anchor
          echo '<a name="userId'.$user['id'].'" id="userId'.$user['id'].'" class="anchorTarget"></a>';
          
          // --------------------------------------
          // basic user settings
          echo '<table>     
                <colgroup>
                <col class="left" />
                </colgroup>
                
                <tr><td class="leftTop"></td><td></td></tr>';
          
          // user NAME
          $userName = (empty($user['username']))
            ? '<i>'.$langFile['userSetup_createUser_unnamed'].'</i>'
            : $user['username'];
          
          echo '<tr><td class="left">';
          echo '<span style="font-size:20px;font-weight:bold;">'.$userName.'</span><!--<br />ID '.$user['id'].'-->';
          echo '<input type="hidden" name="users['.$user['id'].'][id]" value="'.$user['id'].'" />';
          echo '</td>'; 
          
                // deleteUser
          echo '<td class="right" style="width:525px;">
                <div style="border-bottom: 1px dotted #cccccc;width:400px;height:15px;float:left !important;"></div>
                <a href="?site=userSetup&amp;status=deleteUser&amp;userId='.$user['id'].'#top" class="deleteUser toolTip" title="'.$langFile['userSetup_deleteUser'].'::'.$user['username'].'"></a>';          
          echo '</td></tr>';
          
                // user name
                $markUsername = (empty($user['username']))
                  ? ' class="toolTip red" title="'.$langFile['userSetup_username_missing'].'::"'
                  : '';
          echo '<tr><td class="left">
                <label for="users'.$user['id'].'username"'.$markUsername.'>'.$langFile['userSetup_username'].'</label>
                </td><td class="right">
                <input type="text" id="users'.$user['id'].'username" name="users['.$user['id'].'][username]" value="'.$user['username'].'" />
                </td></tr>';
                
                // user email
          echo '<tr><td class="left">
                <label for="users'.$user['id'].'email" class="toolTip" title="'.$langFile['userSetup_email'].'::'.$langFile['userSetup_email_tip'].'">'.$langFile['userSetup_email'].'</label>
                </td><td class="right">
                <input type="text" id="users'.$user['id'].'email" name="users['.$user['id'].'][email]" value="'.$user['email'].'" class="toolTip" title="'.$langFile['userSetup_email'].'::'.$langFile['userSetup_email_tip'].'" />
                </td></tr>';
                
          echo '<tr><td class="left spacer"></td><td>';
                
                // user password
                $passwordTitle = (empty($user['password']))
                  ? $langFile['userSetup_password']
                  : $langFile['userSetup_password_change'];
                $markPassword = (empty($user['password']))
                  ? ' class="toolTip red" title="'.$langFile['userSetup_password_missing'].'::"'
                  : '';
          echo $userInfoPassword;        
                
          echo '<tr><td class="left">
                <label for="users'.$user['id'].'password"'.$markPassword.'>'.$passwordTitle.'</label>
                </td><td class="right">
                <input type="password" id="users'.$user['id'].'password" name="users['.$user['id'].'][password]" value="" />
                </td></tr>';
                // user password confirm
          echo '<tr><td class="left">
                <label for="users'.$user['id'].'passwordConfirm"'.$markPassword.'>'.$langFile['userSetup_password_confirm'].'</label>
                </td><td class="right">
                <input type="password" id="users'.$user['id'].'passwordConfirm" name="users['.$user['id'].'][password_confirm]" value="" />
                </td></tr>';
          
          echo '<tr><td class="leftBottom"></td><td>';
          
          echo '</td></tr>';
                    
                // USER SETTINGS
          echo '<tr><td class="left checkboxes">
                <input type="checkbox" id="users'.$user['id'].'admin" name="users['.$user['id'].'][admin]" value="true" '.$checked[1].' class="toolTip" title="'.$langFile['userSetup_admin'].'::'.$langFile['userSetup_admin_tip'].'" /><br />
                </td><td class="right checkboxes">
                <label for="users'.$user['id'].'admin">';          
                echo '<span class="toolTip" title="'.$langFile['userSetup_admin'].'::'.$langFile['userSetup_admin_tip'].'">'.$langFile['userSetup_admin'].'</span></label>
                </td></tr>';
                          
          echo '<tr><td class="spacer checkboxes"></td><td></td></tr>';
          echo '</table>';
           
          echo '<input type="submit" value="" name="saveUserSetup" class="button submit center" title="'.$langFile['form_submit'].'" onclick="$(\'savedUser\').value = \''.$user['username'].'\'; submitAnchor(\'userForm\',\'userId'.$user['id'].'\');" />'; // end slide in box
          
        }
      }        
      ?>
    
  </div>
  <div class="bottom"></div>
</div>
</form>