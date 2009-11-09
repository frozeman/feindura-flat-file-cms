<?php
/*
    feindura - Flat File Content Management System
    Copyright (C) 2009 Fabian Vogelsteller [frozeman.de]

    This program is free software;
    you can redistribute it and/or modify it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 3 of the License, or (at your option) any later version.

    This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY;
    without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
    See the GNU General Public License for more details.

    You should have received a copy of the GNU General Public License along with this program;
    if not,see <http://www.gnu.org/licenses/>.

* websiteSetup.php version 1.84
*/

include_once(dirname(__FILE__)."/../backend.include.php");

$documentSaved = false;
$errorWindow = false;
$savedForm = '';

// ------------ SPEICHERT die BENUTZER EINSTELLUNGEN, schreibe in usersettings.php
if($_POST['send'] && isset($_POST['websiteConfig'])) {

    // gets the startPage var and put it in the POST var
    $_POST['startPage'] = $websiteConfig['startPage'];
    
    $_POST['copyright'] = $_POST['websiteConfig_copyright'];
    if(saveWebsiteConfig($_POST)) {
      // give documentSaved status
      $documentSaved = true;
      saveLog($langFile['log_websiteSetup_saved']); // <- SAVE the task in a LOG FILE
    } else
    $errorWindow = $langFile['websiteSetup_websiteConfig_error_save'];
  
  $savedForm = 'websiteConfig';
}

// ---------- SAVE the editFiles
if(isset($_POST['saveEditedFiles'])) {

  if(saveEditedFiles($_POST)) { 
    $documentSaved = true; // give documentSaved status
     saveLog($langFile['log_file_saved'],$_POST['file']); // <- SAVE the task in a LOG FILE
  } else
    $errorWindow = $langFile['editFilesSettings_error_save'];
  
  $savedForm = $_POST['status'];
}


include (dirname(__FILE__)."/../../config/websiteConfig.php"); // loads the saved settings again

// ------------------------------- ENDE DES SCRIPTs ZUM SPEICHERN DER VARIABLEN ----------------------------------
?>

<!-- documentSaved -->
<div id="documentSaved"<?php if($documentSaved) echo ' class="saved"'; ?>></div>

<!-- errorWindow -->
<?php if($errorWindow !== false) { ?>
<div id="errorWindow">
  <div class="top"><?php echo $langFile['form_errorWindow_h1'];?></div>
  <div class="content warning">
    <p><?php echo $errorWindow; ?></p>
    <a href="?site=<?php echo $_GET['site'] ?>" onclick="$('errorWindow').fade('out');return false;" class="ok"></a>
  </div>
  <div class="bottom"></div>
</div>
<?php } ?>

<form action="?site=websiteSetup#websiteConfig" method="post" enctype="multipart/form-data" accept-charset="ISO-8859-1,ISO-8859-2,ISO-8859-15,UTF-8">
  <div><input type="hidden" name="send" value="true" /></div>
  
<!-- PAGE SETTINGS -->

<?php
// shows the block below if it is the ones which is saved before
if($savedForm != 'websiteConfig')
    $hidden = ' hidden';
  else
    $hidden = '';  
?>
<div class="block<?php /*echo $hidden;*/ ?>">
  <h1><a href="#" name="fmsSettings"><?php echo $langFile['websiteSetup_websiteConfig_h1']; ?></a></h1>
  <div class="content">
    <table>
     
      <colgroup>
      <col class="left" />
      </colgroup>
  
      <tr><td class="leftTop"></td><td></td></tr>
      
      <tr><td class="left">
      <label for="seitentitel"><span class="toolTip mark" title="<?php echo $langFile['websiteSetup_websiteConfig_feld1'].'::'.$langFile['websiteSetup_websiteConfig_feld1_tip']; ?>">
      <?php echo $langFile['websiteSetup_websiteConfig_feld1']; ?></span></label>
      </td><td class="right">
      <input id="seitentitel" name="seitentitel" value="<?php echo $websiteConfig['seitentitel']; ?>" />
      </td></tr>
      
      <tr><td class="left">
      <label for="publisher"><span class="toolTip mark" title="<?php echo $langFile['websiteSetup_websiteConfig_feld2'].'::'.$langFile['websiteSetup_websiteConfig_feld2_tip']; ?>">
      <?php echo $langFile['websiteSetup_websiteConfig_feld2']; ?></span></label>
      </td><td class="right">
      <input id="publisher" name="publisher" value="<?php echo $websiteConfig['publisher']; ?>" class="toolTip" title="<?php echo $langFile['websiteSetup_websiteConfig_feld2_inputTip']; ?>" />
      </td></tr>
      
      <tr><td class="left">
      <label for="websiteConfig_copyright"><span class="toolTip mark" title="<?php echo $langFile['websiteSetup_websiteConfig_feld3'].'::'.$langFile['websiteSetup_websiteConfig_feld3_tip']; ?>">
      <?php echo $langFile['websiteSetup_websiteConfig_feld3']; ?></span></label>
      </td><td class="right">
      <input id="websiteConfig_copyright" name="websiteConfig_copyright" value="<?php echo $websiteConfig['copyright']; ?>" class="toolTip" title="<?php echo $langFile['websiteSetup_websiteConfig_feld3_inputTip']; ?>" />
      </td></tr>
      
      <tr><td class="spacer"></td><td></td></tr>
      
      <tr><td class="left">
      <label for="keywords"><span class="toolTip mark" title="<?php echo $langFile['websiteSetup_websiteConfig_feld4'].'::'.$langFile['websiteSetup_websiteConfig_feld4_tip']; ?>">
      <?php echo $langFile['websiteSetup_websiteConfig_feld4']; ?></span></label>
      </td><td class="right">
      <input id="keywords" name="keywords" value="<?php echo $websiteConfig['keywords']; ?>" class="toolTip" title="<?php echo $langFile['websiteSetup_websiteConfig_feld4_inputTip']; ?>" />
      </td></tr>
      
      <tr><td class="left">
      <label for="description"><span class="toolTip mark" title="<?php echo $langFile['websiteSetup_websiteConfig_feld5'].'::'.$langFile['websiteSetup_websiteConfig_feld5_tip']; ?>">
      <?php echo $langFile['websiteSetup_websiteConfig_feld5']; ?></span></label>
      </td><td class="right">
      <textarea id="description" name="description" cols="50" rows="4" style="white-space:normal;width:500px;height:70px;margin-bottom: 50px;" class="toolTip" title="<?php echo $langFile['websiteSetup_websiteConfig_feld5_inputTip']; ?>"><?php echo $websiteConfig['description']; ?></textarea>
      </td></tr>
      
      <tr><td class="spacer"></td><td></td></tr>
      
      <tr><td class="left">
      <label for="contactMail"><span class="toolTip mark" title="<?php echo $langFile['websiteSetup_websiteConfig_feld6'].'::'.$langFile['websiteSetup_websiteConfig_feld6_tip']; ?>">
      <?php echo $langFile['websiteSetup_websiteConfig_feld6']; ?></span></label>
      </td><td class="right">
      <input id="contactMail" name="contactMail" value="<?php echo $websiteConfig['contactMail']; ?>" class="toolTip" title="<?php echo $langFile['websiteSetup_websiteConfig_feld6_inputTip']; ?>" />
      </td></tr>
      
      <tr><td class="leftBottom"></td><td></td></tr>
      
    </table>
    
    <!--<input type="reset" value="" class="toolTip button cancel" title="<?php echo $langFile['form_cancel']; ?>" />-->
    <input type="submit" value="" name="websiteConfig" class="toolTip button submit" title="<?php echo $langFile['form_submit']; ?>" />
  </div>
  <div class="bottom"></div>
</div>

</form>


<?php

if($adminConfig['user']['editLanguage']) {  
// BEARBEITUNG DER SPRACHDATEI
editFiles($adminConfig['langPath'], $_GET['site'], "editLangfile",  $langFile['editFilesSettings_h1_lang'], "langFilesAnchor", "php");
}

if($adminConfig['user']['editStylesheet']) {
  // BEARBEITUNG DER STYLESHEETDATEI
  editFiles($adminConfig['stylesheetPath'], $_GET['site'], "editCSSfile", $langFile['editFilesSettings_h1_style'], "cssFilesAnchor", "css");
}

?>