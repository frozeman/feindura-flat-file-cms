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
 * sites/userSetup.php
 *
 * @version 0.1.2
 */

/**
 * Includes the login.include.php and backend.include.php and filter the basic data
 */
require_once(dirname(__FILE__)."/../includes/secure.include.php");

?>
<!-- USER SETTINGS -->

<form action="index.php?site=userSetup" method="post" enctype="multipart/form-data" accept-charset="UTF-8" id="userForm">
  <div>
  <input type="hidden" name="send" value="userSetup">
  <input type="hidden" name="savedUserId" id="savedUserId" value="">
  </div>

<div class="block">
  <h1><?php echo $langFile['USERSETUP_h1']; ?></h1>
  <div class="content form">

    <div class="row">
      <div class="span3 formLeft">
          <a href="?site=userSetup&amp;status=createUser#userId<?php echo getNewUserId(); ?>" class="createUser toolTip" title="<?php echo $langFile['USERSETUP_createUser']; ?>::"></a>
      </div>
      <div class="span5">
        <br>
        <?php
        // user info
        if($userInfo)
          echo '<span class="hint"><b>'.$userInfo.'</b></span>';
        ?>
      </div>
    </div>

    <div class="spacer2x"></div>

    <?php

      // lists the users
      if(is_array($userConfig)) {
        foreach($userConfig as $user) {

          // prevent using the $check vars from the last user
          unset($checked);

          // checks the user settings
          $checked[1] = ($user['admin']) ? 'checked="checked"' : '';


          echo '<div class="verticalSeparator"></div>';

          // user anchor
          echo '<a id="userId'.$user['id'].'" class="anchorTarget"></a>';


          // user NAME
          $userName = (empty($user['username']))
            ? '<i>'.$langFile['USERSETUP_createUser_unnamed'].'</i>'
            : $user['username'];
          echo '<div class="row"><div class="offset3 span5">';
          echo '<h2>'.$userName.'</h2><!--<br>ID '.$user['id'].'-->';
          echo '<input type="hidden" name="users['.$user['id'].'][id]" value="'.$user['id'].'">';

                // deleteUser
          echo '<a href="?site=userSetup&amp;status=deleteUser&amp;userId='.$user['id'].'#top" class="deleteUser toolTip" title="'.$langFile['USERSETUP_deleteUser'].'::'.$user['username'].'"></a>';
          echo '</div></div>';

                // user name
                $markUsername = (empty($user['username']))
                  ? ' class="toolTip red" title="'.$langFile['USERSETUP_username_missing'].'::"'
                  : '';
                $autofocus = (empty($user['username']))
                  ? ' autofocus="autofocus"'
                  : '';
          echo '<div class="row"><div class="span3 formLeft">';
          echo '<label for="users'.$user['id'].'username"'.$markUsername.'>'.$langFile['USERSETUP_username'].'</label>
                </div><div class="span5">
                <input id="users'.$user['id'].'username" name="users['.$user['id'].'][username]" value="'.$user['username'].'" autocomplete="off"'.$autofocus.' required="required">
                </div></div>';

                // user email
          echo '<div class="row"><div class="span3 formLeft">';
          echo '<label for="users'.$user['id'].'email" class="toolTip" title="::'.$langFile['USERSETUP_email_tip'].'">'.$langFile['USERSETUP_email'].'</label>
                </div><div class="span5">
                <input type="email" id="users'.$user['id'].'email" name="users['.$user['id'].'][email]" value="'.$user['email'].'" class="toolTip" title="'.$langFile['USERSETUP_email'].'::'.$langFile['USERSETUP_email_tip'].'" autocomplete="off">
                </div></div>';

          echo '<div class="spacer"></div>';

                // user password
                $passwordTitle = (empty($user['password']))
                  ? $langFile['USERSETUP_password']
                  : $langFile['USERSETUP_password_change'];
                $markPassword = (empty($user['password']))
                  ? ' class="toolTip red" title="'.$langFile['USERSETUP_password_missing'].'::"'
                  : '';
          echo $userInfoPassword[$user['id']];

          echo '<div class="row"><div class="span3 formLeft">';
          echo '<label for="users'.$user['id'].'password"'.$markPassword.'>'.$passwordTitle.'</label>
                </div><div class="span5">
                <input type="password" id="users'.$user['id'].'password" name="users['.$user['id'].'][password]" value="" autocomplete="off" required="required">
                </div></div>';

                // user password confirm
          echo '<div class="row"><div class="span3 formLeft">';
          echo '<label for="users'.$user['id'].'passwordConfirm"'.$markPassword.'>'.$langFile['USERSETUP_password_confirm'].'</label>
                </div><div class="span5">
                <input type="password" id="users'.$user['id'].'passwordConfirm" name="users['.$user['id'].'][password_confirm]" value="" required="required">
                </div></div>';

          // USER PERMISSIONS
          echo '<div class="row"><div class="span3 formLeft">';
          echo '<input type="checkbox" id="users'.$user['id'].'admin" name="users['.$user['id'].'][admin]" class="toolTip userAdminCheckbox" value="true" '.$checked[1].' title="'.$langFile['USERSETUP_admin'].'::'.$langFile['USERSETUP_admin_tip'].'"><br>
                </div><div class="span5">
                <label for="users'.$user['id'].'admin">';
                echo '<span class="toolTip" title="::'.$langFile['USERSETUP_admin_tip'].'">'.$langFile['USERSETUP_admin'].'</span></label>
                </div></div>';


          $hidden = ($checked[1]) ? ' hidden' : '';

          echo '<div class="row userPermissionsRow'.$hidden.'"><div class="offset3 span5 buttons">
                  <a href="?site=userPermissions" class="btn btn-large" onclick="openWindowBox(\'library/views/windowBox/userPermissions.php\',\''.$langFile['USERSETUP_USERPERMISSIONS_TITLE'].'\');return false;"'.$keyTip.'>'.$langFile['USERSETUP_USERPERMISSIONS_TITLE'].'</a>
                </div></div>';

          echo '<input type="submit" value="" name="saveUserSetup" class="button submit center" title="'.$langFile['FORM_BUTTON_SUBMIT'].'" onclick="$(\'savedUserId\').value = \''.$user['id'].'\'; submitAnchor(\'userForm\',\'userId'.$user['id'].'\');">'; // end slide in box

        }
      }
      ?>

  </div>
</div>
</form>