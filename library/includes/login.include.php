<?php 
/*
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
 */
/**
 * This file is inlcuded in the index.php and all standalone files
 *
 * @version 0.11
 */

// var
$loginError = false;
$loggedOut = false;
$resetPassword = false;
//unset($_SESSION);

// -> if NO USER EXISTS
if(empty($userConfig)) {
  $_SESSION['feinduraLogin'][IDENTITY]['username'] = false;
  $_SESSION['feinduraLogin'][IDENTITY]['loggedIn'] = true;
}

// ->> LOGIN FORM SEND
if(isset($_POST) && $_POST['action'] == 'login') {

  // -> if user exits
  if(!empty($userConfig)) {
  
    if(!empty($_POST['username']) && array_key_exists($_POST['username'],$userConfig)) {
      if(md5($_POST['password']) == $userConfig[$_POST['username']]['password']) {
        $_SESSION['feinduraLogin'][IDENTITY]['username'] = $_POST['username'];
        $_SESSION['feinduraLogin'][IDENTITY]['loggedIn'] = true;
      } else
        $loginError = $langFile['LOGIN_ERROR_WRONGPASSWORD'];
    } else
      $loginError = $langFile['LOGIN_ERROR_WRONGUSER'];
  } else
    $loginError = $langFile['LOGIN_ERROR_WRONGUSER'];
}

// -> LOGOUT
if(isset($_GET['logout'])) {
  unset($_SESSION['feinduraLogin'][IDENTITY]);
  $loggedOut = true;
}

// ->> RESET PASSWORD
if(isset($_POST) && $_POST['action'] == 'resetPassword' && !empty($_POST['username'])) {
  $userConfig = @include("config/user.config.php");
  
  if(array_key_exists($_POST['username'],$userConfig)) {
    
    $userEmail = $userConfig[$_POST['username']]['email'];
    
    if(!empty($userEmail)) {
    
      // generate new password
      $chars = array_merge(range(0, 9),range('a', 'z'),range('A', 'Z'));
      shuffle($chars);
      $newPassword = implode('', array_slice($chars, 0, 5)); 
      
      $subject = $langFile['LOGIN_TEXT_NEWPASSWORDEMAIL_SUBJECT'].': '.$adminConfig['url'];
      $message = $langFile['LOGIN_TEXT_NEWPASSWORDEMAIL_MESSAGE']."\n".$_POST['username']."\n".$newPassword;
      $header = 'MIME-Version: 1.0' . "\r\n" . 'Content-type: text/plain; charset=UTF-8' . "\r\n"; // UTF-8 plain text mail
      $header .= 'From: "feindura CMS from '.$adminConfig['url'].'" <noreply@'.str_replace(array('http://','https://','www.'),'',$adminConfig['url']).">\r\n";
      $header .= 'X-Mailer: PHP/' . PHP_VERSION;
      
      // change users password
      $newUserConfig = $userConfig;
      $newUserConfig[$_POST['username']]['password'] = md5($newPassword);
      
      // send mail with the new password
      if(saveUserConfig($newUserConfig)) {
        if(mail($userEmail,'=?UTF-8?B?'.base64_encode($subject).'?=',$message,$header)) {
          $resetPassword = true;
          unset($_GET['resetpassword']);
        } else
          $loginError = $langFile['LOGIN_ERROR_FORGOTPASSWORD_NOTSEND'];
      } else
        $loginError = $langFile['LOGIN_ERROR_FORGOTPASSWORD_NOTSAVED'];
    } else
      $loginError = $langFile['LOGIN_ERROR_FORGOTPASSWORD_NOEMAIL'];
  } else
    $loginError = $langFile['LOGIN_ERROR_WRONGUSER'];
  
}

// ->> CHECK if user is logged in
// *****************************************************
if($_SESSION['feinduraLogin'][IDENTITY]['loggedIn'] === true) {
   
   // does nothing :-)

// ->> SHOW LOGIN FORM
} else {

  ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="content-type" content="application/xhtml+xml; charset=UTF-8" />
  <meta http-equiv="content-language" content="en" />
  
  <title>feindura login</title>
  
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
  
  <!-- thirdparty/MooTools -->
  <script type="text/javascript" src="library/thirdparty/javascripts/mootools-core-1.3.js"></script>
  <script type="text/javascript" src="library/thirdparty/javascripts/mootools-more.js"></script>
  
  <!-- thirdparty/Raphael -->
  <script type="text/javascript" src="library/thirdparty/javascripts/raphael-1.5.2.js"></script>
  
  <!-- javascripts -->
  <script type="text/javascript" src="library/javascripts/shared.js"></script>
  
  <script type="text/javascript">
  window.addEvent('load',function() {  
    new OverText('username',{positionOptions: {offset: {x: 12,y: 5}}});
    new OverText('password',{positionOptions: {offset: {x: 12,y: 5}}});

  });
  
  function startLoadingCircle() {
    $('submitButton').dispose();
    // create loading circle element
    var loginLoadingCircle = new Element('div', {id: 'loginLoadingCircle'});
    $('inputsDiv').grab(loginLoadingCircle,'bottom');
    var removeLoadingCircle = feindura_loadingCircle('loginLoadingCircle', 12, 20, 12, 3, "#000");
  }
  
  </script>
</head>
<body>
  <div id="container">
  <?php if($loggedOut === true || $resetPassword === true) {  ?>
    <div id="loginSuccessBox">
      <div class="top"></div>
      <div class="middle">     
      <?php      
      
      if($loggedOut)
        echo '<h1>'.$langFile['LOGIN_TEXT_LOGOUT_PART1'].'</h1><a href="'.$adminConfig['url'].$adminConfig['websitePath'].'">&rArr; '.$langFile['LOGIN_TEXT_LOGOUT_PART2'].'</a>';
      if($resetPassword)
        echo '<h1>'.$langFile['LOGIN_ERROR_FORGOTPASSWORD_SUCCESS'].'</h1>'.$userEmail;
      ?>
      </div>
      <div class="bottom"></div>
    </div>
  <?php } ?>
    <div id="loginBox">
      <?php
      $currentURL = $_SERVER['REQUEST_URI'];
    
      if(isset($_GET['resetpassword']))
        $currentURL = (strpos($currentURL,'?') === false)
          ? $_SERVER['REQUEST_URI'].'?resetpassword'
          : $_SERVER['REQUEST_URI'].'&resetpassword';
          
      $currentURL = str_replace('logout','',$currentURL);
      
      ?>
      <form action="<?= $currentURL; ?>" method="post" enctype="multipart/form-data" accept-charset="UTF-8" onsubmit="startLoadingCircle();">
        <div id="inputsDiv">
          <input type="text" value="<?= $_POST['username'] ?>" name="username" id="username" title="<?= $langFile['LOGIN_INPUT_USERNAME']; ?>" autofocus="autofocus" /><br />
        <?php if(!isset($_GET['resetpassword'])) { ?>
          <input type="password" value="<?= $_POST['password'] ?>" name="password" id="password" title="<?= $langFile['LOGIN_INPUT_PASSWORD']; ?>" /><br />
        <?php } 
        if(!isset($_GET['resetpassword'])) {
          echo '<input type="hidden" name="action" value="login" />';
          echo '<input type="submit" id="submitButton" class="button" name="loginSubmit" value="'.$langFile['LOGIN_BUTTON_LOGIN'].'" />';
        } else {
          echo '<input type="hidden" name="action" value="resetPassword" />';
          echo '<br /><br /><input type="submit" id="submitButton" class="button" name="resetPasswordSubmit" value="'.$langFile['LOGIN_BUTTON_SENDNEWPASSWORD'].'" />';
        } ?>
        </div>
      </form>
    </div>
  <?php if($loginError) { ?>
    <div id="loginErrorBox">
      <div class="top"></div>
      <div class="middle"><?= $loginError ?></div>      
      <div class="bottom"></div>
    </div>
  <?php } ?>
  <div class="info">
  <?php if(isset($_GET['resetpassword'])) {
    echo '<a href="index.php">'.$langFile['LOGIN_LINK_BACKTOLOGIN'].'</a>';
  } else {
    echo '<a href="index.php?resetpassword">'.$langFile['LOGIN_LINK_FORGOTPASSWORD'].'</a>';
  }?>
    <br /><?= $langFile['LOGIN_TEXT_COOKIESNEEDED']; ?></div>
  </div>
</body>
</html>
  <?php  
  die();
}
?>