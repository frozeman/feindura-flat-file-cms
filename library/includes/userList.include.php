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
 * includes/userList.include.php
 *
 * @version 0.1
 */

/**
 * Includes the login.include.php and backend.include.php and filter the basic data
 */
require_once(dirname(__FILE__)."/../includes/secure.include.php");

//$langFile['DASHBOARD_TITLE_USER']

if(empty($userConfig) || (is_array($userConfig) && count($userConfig) > 1)) {
    if(!empty($userConfig) && is_array($userConfig)) {

      // sort the user by online status
      $editableUserConfig = $userConfig;
      $sortedUsers = array();

      // add current user
      foreach($editableUserConfig as $user) {
        if($_SESSION['feinduraSession']['login']['user'] == $user['id']){
          $user['status'] = 'current';
          array_push($sortedUsers, $user);
          unset($editableUserConfig[$user['id']]);
          break;
        }
      }
      // add online user
      foreach($editableUserConfig as $user) {
        foreach($USERCACHE as $cachedUser) {
          if($user['username'] == $cachedUser['username']) {
            $user['status'] = 'online';
            array_push($sortedUsers, $user);
            unset($editableUserConfig[$user['id']]);
            break;
          }
        }
      }
      $sortedUsers = $sortedUsers + $editableUserConfig;

      // list user 1st part
      echo '<ul class="userList unstyled">';
      foreach($sortedUsers as $user) {

        echo '<li class="toolTipLeft'; //..."

        // current user
        if($user['status'] == 'current')
          echo ' online current" title="::'.$langFile['USER_TEXT_CURRENTUSER'].'::'; //..."
        // users who are online
        elseif($user['status'] == 'online')
          echo ' online" title="'.$langFile['USER_TEXT_USERSONLINE'].': '.date("H:i",$cachedUser["timestamp"]).'[br]('.ucfirst($cachedUser["browser"]).')'; //..."

        // list users 2nd part
        echo '">';
          echo (GeneralFunctions::isAdmin()) ? '<a href="?site=userSetup#userId'.$user['id'].'">': '';
          echo $user['username'];
          echo (GeneralFunctions::isAdmin()) ? '</a>': '';
        echo '</li>';
      }
      echo '</ul>';
    // no users
    } else
      echo '<div class="alert alert-error" style="position:relative; top: 50px; font-size: 11px;"><a href="?site=userSetup" class="red">'.$langFile['USER_TEXT_NOUSER'].'</div></a>';

}