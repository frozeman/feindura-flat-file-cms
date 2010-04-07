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

* websiteSetup.php version 1.89
*/

include_once(dirname(__FILE__)."/../backend.include.php");


// ----------------------------------------------------------------------------------------------------------------------------------------
// **--** SAVE PROCESS --------------------------------------------------------------------------------------------------------------------
// ----------------------------------------------------------------------------------------------------------------------------------------


// ------------ SAVE the WEBSITE SETTINGS
if(isset($_POST['send']) && $_POST['send'] ==  'websiteSetup') {

    // gets the startPage var and put it in the POST var
    $_POST['startPage'] = $websiteConfig['startPage'];
    
    $_POST['copyright'] = $_POST['websiteConfig_copyright'];
    if(saveWebsiteConfig($_POST)) {
      // give documentSaved status
      $documentSaved = true;
      $statisticFunctions->saveTaskLog($langFile['log_websiteSetup_saved']); // <- SAVE the task in a LOG FILE
    } else
    $errorWindow = $langFile['websiteSetup_websiteConfig_error_save'];
  
  $savedForm = 'websiteConfig';
}

// ---------- SAVE the editFiles
include(dirname(__FILE__).'/../process/saveEditFiles.php');


@include (dirname(__FILE__)."/../../config/website.config.php"); // loads the saved settings again

// ------------------------------- ENDE of the SAVING SCRIPT -------------------------------------------------------------------------------
?>
<form action="?site=websiteSetup#websiteConfig" method="post" enctype="multipart/form-data" accept-charset="UTF-8">
  <div><input type="hidden" name="send" value="websiteSetup" /></div>
  
<!-- PAGE SETTINGS -->

<?php
// shows the block below if it is the ones which is saved before
if($savedForm != 'websiteConfig')
    $hidden = ' hidden';
  else
    $hidden = '';  
?>
<div class="block<?php /*echo $hidden;*/ ?>">
  <h1><a href="#" id="websiteSettings" name="websiteSettings"><?php echo $langFile['websiteSetup_websiteConfig_h1']; ?></a></h1>
  <div class="content">
    <table>
     
      <colgroup>
      <col class="left" />
      </colgroup>
  
      <tr><td class="leftTop"></td><td></td></tr>
      
      <tr><td class="left">
      <label for="title"><span class="toolTip" title="<?php echo $langFile['websiteSetup_websiteConfig_feld1'].'::'.$langFile['websiteSetup_websiteConfig_feld1_tip']; ?>">
      <?php echo $langFile['websiteSetup_websiteConfig_feld1']; ?></span></label>
      </td><td class="right">
      <input id="title" name="title" value="<?php echo $websiteConfig['title']; ?>" />
      </td></tr>
      
      <tr><td class="left">
      <label for="publisher"><span class="toolTip" title="<?php echo $langFile['websiteSetup_websiteConfig_feld2'].'::'.$langFile['websiteSetup_websiteConfig_feld2_tip']; ?>">
      <?php echo $langFile['websiteSetup_websiteConfig_feld2']; ?></span></label>
      </td><td class="right">
      <input id="publisher" name="publisher" value="<?php echo $websiteConfig['publisher']; ?>" />
      </td></tr>
      
      <tr><td class="left">
      <label for="websiteConfig_copyright"><span class="toolTip" title="<?php echo $langFile['websiteSetup_websiteConfig_feld3'].'::'.$langFile['websiteSetup_websiteConfig_feld3_tip']; ?>">
      <?php echo $langFile['websiteSetup_websiteConfig_feld3']; ?></span></label>
      </td><td class="right">
      <input id="websiteConfig_copyright" name="websiteConfig_copyright" value="<?php echo $websiteConfig['copyright']; ?>" />
      </td></tr>
      
      <tr><td class="spacer"></td><td></td></tr>
      
      <tr><td class="left">
      <label for="keywords"><span class="toolTip" title="<?php echo $langFile['websiteSetup_websiteConfig_feld4'].'::'.$langFile['websiteSetup_websiteConfig_feld4_tip']; ?>">
      <?php echo $langFile['websiteSetup_websiteConfig_feld4']; ?></span></label>
      </td><td class="right">
      <input id="keywords" name="keywords" value="<?php echo $websiteConfig['keywords']; ?>" class="toolTip" title="<?php echo $langFile['websiteSetup_websiteConfig_feld4_inputTip']; ?>" />
      </td></tr>
      
      <tr><td class="left">
      <label for="description"><span class="toolTip" title="<?php echo $langFile['websiteSetup_websiteConfig_feld5'].'::'.$langFile['websiteSetup_websiteConfig_feld5_tip']; ?>">
      <?php echo $langFile['websiteSetup_websiteConfig_feld5']; ?></span></label>
      </td><td class="right">
      <textarea id="description" name="description" cols="50" rows="4" style="white-space:normal;width:500px;height:70px;margin-bottom: 50px;" class="toolTip" title="<?php echo $langFile['websiteSetup_websiteConfig_feld5_inputTip']; ?>"><?php echo $websiteConfig['description']; ?></textarea>
      </td></tr>
      
      <tr><td class="spacer"></td><td></td></tr>
      
      <tr><td class="left">
      <label for="contactMail"><span class="toolTip" title="<?php echo $langFile['websiteSetup_websiteConfig_feld6'].'::'.$langFile['websiteSetup_websiteConfig_feld6_tip']; ?>">
      <?php echo $langFile['websiteSetup_websiteConfig_feld6']; ?></span></label>
      </td><td class="right">
      <input id="contactMail" name="contactMail" value="<?php echo $websiteConfig['contactMail']; ?>" class="toolTip" title="<?php echo $langFile['websiteSetup_websiteConfig_feld6_inputTip']; ?>" />
      </td></tr>
      
      <tr><td class="leftBottom"></td><td></td></tr>
      
    </table>
    
    <!--<input type="reset" value="" class="toolTip button cancel" title="<?php echo $langFile['form_cancel']; ?>" />-->
    <input type="submit" value="" name="websiteConfig" class="toolTip button submit center" title="<?php echo $langFile['form_submit']; ?>" />
  </div>
  <div class="bottom"></div>
</div>

</form>
<?php

if($adminConfig['user']['editLanguage']) {  
  // BEARBEITUNG DER ERWEITERTEN WEBSEITEN-EINSTELLUNGEN 
  editFiles($adminConfig['websitefilesPath'], $_GET['site'], "editWebsitefile",  $langFile['editFilesSettings_h1_websitefiles'], "websiteFilesAnchor", "php");
}

if($adminConfig['user']['editStylesheet']) {
  // BEARBEITUNG DER STYLESHEETDATEI
  editFiles($adminConfig['stylesheetPath'], $_GET['site'], "editCSSfile", $langFile['editFilesSettings_h1_style'], "cssFilesAnchor", "css");
}

?>