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
 * @version 0.1
 */

/**
 * Includes all necessary configs, functions and classes
 */
include_once(dirname(__FILE__)."/../includes/backend.include.php");

// var
$loginError = false;
$loggedOut = false;
//unset($_SESSION);

// ->> if LOGIN FORM was SEND
if(isset($_POST) && !empty($_POST['username']) && !empty($_POST['password'])) {
  $userConfig = @include("config/user.config.php");
  
  if(array_key_exists($_POST['username'],$userConfig)) {
    if(md5($_POST['password']) == $userConfig[$_POST['username']]['password']) {
      $_SESSION['login_user'] = md5($_SERVER['HTTP_USER_AGENT'].'::'.$_SERVER['REMOTE_ADDR']);
      $_SESSION['login_loggedIn'] = true;
    } else
      $loginError = $langFile['login_error_wrongPassword'];
  } else
    $loginError = $langFile['login_error_wrongUser'];
}

// -> LOGOUT
if(isset($_GET['logout'])) {
  unset($_SESSION['login_user'],$_SESSION['login_loggedIn']);
  $loggedOut = true;
}

// ->> CHECK if user is logged in
if(isset($_SESSION['login_user']) &&
   $_SESSION['login_user'] == md5($_SERVER['HTTP_USER_AGENT'].'::'.$_SERVER['REMOTE_ADDR']) &&
   $_SESSION['login_loggedIn'] === true) {
   
   // does nothing :-)

// ->> SHOW LOGIN FORM
} else {

  ?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="content-type" content="application/xhtml+xml; charset=UTF-8" />
  <meta http-equiv="content-language" content="en" />
  
  <title>      
    feindura login
  </title>
  
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
  
  <link rel="stylesheet" type="text/css" href="library/style/reset.css" media="all" />
  <link rel="stylesheet" type="text/css" href="library/style/login.css" media="all" />
  
  <!-- thirdparty/MooTools -->
  <script type="text/javascript" src="library/thirdparty/javascripts/mootools-1.2.5-core.js"></script>
  <script type="text/javascript" src="library/thirdparty/javascripts/mootools-1.2.4.4-more.js"></script>  
  
  <!-- thirdparty/Raphael -->
  <script type="text/javascript" src="library/thirdparty/javascripts/raphael-1.4.3.js"></script>
  
  <!-- javascripts -->
  <script type="text/javascript" src="library/javascripts/loading.js"></script>
  
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
    var removeLoadingCircle = loadingCircle('loginLoadingCircle', 12, 20, 12, 3, "#000");
  }
  
  </script>

</head>
<body>
  <div id="container">
  <?php if($loggedOut === true) {  ?>
    <div id="logoutBox">
    <?= '<h1>'.$langFile['login_logout_part1'].'</h1><a href="'.$adminConfig['url'].'">&rArr; '.$langFile['login_logout_part2'].'</a>'; ?>
    </div>
  <?php }  ?>
    <div id="loginBox">
      <form action="<?= $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data" accept-charset="UTF-8" onsubmit="startLoadingCircle();">
        <div id="inputsDiv">
          <input type="text" value="<?= $_POST['username'] ?>" name="username" id="username" title="<?= $langFile['login_username']; ?>" /><br />
          <input type="password" value="<?= $_POST['password'] ?>" name="password" id="password" title="<?= $langFile['login_password']; ?>" /><br />
          <input type="submit" id="submitButton" class="button" value="<?= $langFile['login_button_login'] ?>" />
        </div>
      </form>
    </div>
  <?php if($loginError) { ?>
    <div id="loginErrorBox">
      <?= $loginError ?>
    </div>
  <?php } ?>
    <div class="info"><?= $langFile['login_info_cookie']; ?></div>
  </div>
</body>
</html>
  <?php  
  die();
}
?>