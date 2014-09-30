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

<form action="index.php?site=userSetup" method="post" enctype="multipart/form-data" accept-charset="UTF-8" id="userSettingsForm">
  <div>
  <input type="hidden" name="send" value="userSetup">
  </div>

<div class="block">
  <h1><img src="library/images/icons/userIcon_middle.png" class="blockH1Icon" alt="user icon" width="35" height="35"><?php echo $langFile['USERSETUP_h1']; ?></h1>
  <div class="content form">

    <div class="spacer"></div>

    <div class="row">
      <div class="span8 center">
          <a href="?site=userSetup&amp;status=createUser#userId<?php echo getNewUserId(); ?>" class="createUser toolTipLeft" title="<?php echo $langFile['USERSETUP_createUser']; ?>::"></a>
      </div>
    </div>

    <div class="verticalSeparator"></div>

    <div class="spacer"></div>

    <?php

      // lists the users
      if(is_array($userConfig)) {
        foreach($userConfig as $user) {

          // prevent using the $check vars from the last user
          unset($checked);

          // checks the user settings
          $checked[1] = ($user['admin']) ? 'checked="checked"' : '';


          // echo '<div class="verticalSeparator"></div>';
          echo '<div class="spacer2x"></div>';

          // user ANCHOR
          echo '<a id="userId'.$user['id'].'" class="anchorTarget"></a>';


          // USER NAME
          $userName = (empty($user['username']))
            ? '<i>'.$langFile['USERSETUP_createUser_unnamed'].'</i>'
            : $user['username'];

          echo '<div class="row">
                  <div class="span8" style="position:relative;">';
              echo '<h2>'.$userName.' (ID '.$user['id'].')</h2>';
              echo '<input type="hidden" name="users['.$user['id'].'][id]" value="'.$user['id'].'">';

            // DELETEUSER
              echo '<a href="?site=userSetup&amp;status=deleteUser&amp;userId='.$user['id'].'#top" class="deleteUser toolTipBottom" title="'.$langFile['USERSETUP_deleteUser'].'::'.$user['username'].'"></a>';
          echo '  </div>
                </div>';

          // USER NAME
          $markUsername = (empty($user['username']))
            ? ' class="toolTipLeft red" title="'.$langFile['USERSETUP_username_missing'].'::"'
            : '';
          $autofocus = (empty($user['username']))
            ? ' autofocus="autofocus"'
            : '';
          echo '<div class="row"><div class="span3 formLeft">';
          echo '<label for="users'.$user['id'].'username"'.$markUsername.'>'.$langFile['USERSETUP_username'].'</label>
                </div><div class="span5">
                <input type="text" id="users'.$user['id'].'username" name="users['.$user['id'].'][username]" value="'.$user['username'].'" autocomplete="off"'.$autofocus.' required="required">
                </div></div>';

          // USER EMAIL
          echo '<div class="row"><div class="span3 formLeft">';
          echo '<label for="users'.$user['id'].'email" class="toolTipLeft" title="::'.$langFile['USERSETUP_email_tip'].'">'.$langFile['USERSETUP_email'].'</label>
                </div><div class="span5">
                <input type="email" id="users'.$user['id'].'email" name="users['.$user['id'].'][email]" value="'.$user['email'].'" class="toolTipRight" title="'.$langFile['USERSETUP_email'].'::'.$langFile['USERSETUP_email_tip'].'" autocomplete="off">
                </div></div>';

          echo '<div class="spacer"></div>';

          // USER PASSWORD
          $passwordTitle = (empty($user['password']))
            ? $langFile['USERSETUP_password']
            : $langFile['USERSETUP_password_change'];
          $markPassword = (empty($user['password']))
            ? ' class="toolTipLeft red" title="'.$langFile['USERSETUP_password_missing'].'::"'
            : '';
          $requirePassword = (empty($user['password']))
            ? ' required="required"'
            : '';

          echo '<div class="row"><div class="span3 formLeft">';
          echo '<label for="users'.$user['id'].'password"'.$markPassword.'>'.$passwordTitle.'</label>
                </div><div class="span5">
                <input type="password" id="users'.$user['id'].'password" name="users['.$user['id'].'][password]" value="" autocomplete="off"'.$requirePassword.'>
                </div></div>';

          // USER PASSWORD CONFIRM
          echo '<div class="row"><div class="span3 formLeft">';
          echo '<label for="users'.$user['id'].'passwordConfirm"'.$markPassword.'>'.$langFile['USERSETUP_password_confirm'].'</label>
                </div><div class="span5">
                <input type="password" id="users'.$user['id'].'passwordConfirm" name="users['.$user['id'].'][password_confirm]" value=""'.$requirePassword.'>
                </div></div>';

          echo '<div class="spacer"></div>';

          // USER INFORMATION
          echo '<div class="row">
                  <div class="span3 formLeft">
                    <label for="users'.$user['id'].'info"><span class="toolTipLeft" title="'.$langFile['USERSETUP_USERPERMISSIONS_TIP_USERINFORMATION'].'">'.$langFile['USERSETUP_USERPERMISSIONS_TEXT_USERINFORMATION'].'</span></label>
                  </div>
                  <div class="span5">
                    <textarea id="users'.$user['id'].'info" name="users['.$user['id'].'][info]" style="white-space:normal;width:400px;" class="toolTipRight autogrow" title="'.$langFile['USERSETUP_USERPERMISSIONS_TIP_USERINFORMATION_NOINFO'].'">'.str_replace(array('<br>','<br />','<br/>'),"\n",$userConfig[$user['id']]['info']).'</textarea>
                  </div>
                </div>';


          // USER PERMISSIONS
          echo '<div class="row"><div class="span3 formLeft">';
          echo '<input type="checkbox" id="users'.$user['id'].'admin" name="users['.$user['id'].'][admin]" class="toolTipLeft userAdminCheckbox" value="true" '.$checked[1].' title="'.$langFile['USERSETUP_admin'].'::'.$langFile['USERSETUP_admin_tip'].'"><br>
                </div><div class="span5">
                <label for="users'.$user['id'].'admin">';
                echo '<span class="toolTipRight" title="::'.$langFile['USERSETUP_admin_tip'].'">'.$langFile['USERSETUP_admin'].'</span></label>
                </div></div>';


          $hidden = ($checked[1]) ? ' hidden' : '';

          echo '<div class="row userPermissionsRow'.$hidden.'">
                  <div class="span8 center">
                    <a href="?site=userPermissions&amp;userId='.$user['id'].'" class="btn btn-warning btn-large" onclick="openWindowBox(\'library/views/windowBox/userPermissions.php\',\''.$langFile['USERSETUP_USERPERMISSIONS_TITLE'].'\',{userId:'.$user['id'].'});return false;"'.$keyTip.'>'.$langFile['USERSETUP_USERPERMISSIONS_TITLE'].'</a>
                  </div>
                </div>';

          echo '<input type="submit" value="" name="saveUserSetup" class="button submit center" title="'.$langFile['FORM_BUTTON_SUBMIT'].'">'; // end slide in box
        }
      }
      ?>

  </div>
</div>
</form>

<!-- PAGE SCRIPTS -->
<script type="text/javascript">
/* <![CDATA[ */

  // setup the AUTOMATICALLY ADDING OF the ANCHORS
  setupForm('userSettingsForm');


  if(typeOf($$('input.userAdminCheckbox')[0]) !== 'null') {

    $$('input.userAdminCheckbox').addEvent('change',function(){
      if(this.checked) {
        this.getParent('div.row').getNext('div.userPermissionsRow').hide();
      } else
        this.getParent('div.row').getNext('div.userPermissionsRow').show();
    });

  }
/* ]]> */
</script>