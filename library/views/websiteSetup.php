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
 * sites/websiteSetup.php
 * 
 * @version 1.9
 */

/**
 * Includes the login.include.php and backend.include.php and filter the basic data
 */
require_once(dirname(__FILE__)."/../includes/secure.include.php");

?>
<form action="index.php?site=websiteSetup#websiteConfig" method="post" enctype="multipart/form-data" accept-charset="UTF-8">
  <div>
  <input type="hidden" name="send" value="websiteSetup">
  <input type="hidden" name="websiteLanguage" value="<?php echo $_SESSION['feinduraSession']['websiteLanguage']; ?>">
  </div>
  
<!-- PAGE SETTINGS -->

<?php
// shows the block below if it is the ones which is saved before
$hidden = ($savedForm != 'websiteConfig') ? ' hidden' : '';
?>
<div class="block<?php /*echo $hidden;*/ ?>">
  <h1><a href="#" id="websiteSettings"><?php echo $langFile['websiteSetup_websiteConfig_h1']; ?></a></h1>
  <div class="content">
    <table>
     
      <colgroup>
      <col class="left">
      </colgroup>
      
      <tbody>
        <tr><td class="leftTop"></td><td></td></tr>
        
        <tr><td class="left">
        <label for="title"><span class="toolTip" title="::<?php echo $langFile['websiteSetup_websiteConfig_field1_tip']; ?>">
        <?php echo $langFile['websiteSetup_websiteConfig_field1']; ?></span></label>
        </td><td class="right">
        <input id="title" name="title" value="<?php echo GeneralFunctions::getLocalized($websiteConfig,'title',true); ?>">
        </td></tr>
        
        <tr><td class="left">
        <label for="publisher"><span class="toolTip" title="::<?php echo $langFile['websiteSetup_websiteConfig_field2_tip']; ?>">
        <?php echo $langFile['websiteSetup_websiteConfig_field2']; ?></span></label>
        </td><td class="right">
        <input id="publisher" name="publisher" value="<?php echo GeneralFunctions::getLocalized($websiteConfig,'publisher',true); ?>">
        </td></tr>
        
        <tr><td class="left">
        <label for="websiteConfig_copyright"><span class="toolTip" title="::<?php echo $langFile['websiteSetup_websiteConfig_field3_tip']; ?>">
        <?php echo $langFile['websiteSetup_websiteConfig_field3']; ?></span></label>
        </td><td class="right">
        <input id="websiteConfig_copyright" name="websiteConfig_copyright" value="<?php echo GeneralFunctions::getLocalized($websiteConfig,'copyright',true); ?>">
        </td></tr>
        
        <tr><td class="spacer"></td><td></td></tr>
        
        <tr><td class="left">
        <label for="keywords"><span class="toolTip" title="::<?php echo $langFile['websiteSetup_websiteConfig_field4_tip']; ?>">
        <?php echo $langFile['websiteSetup_websiteConfig_field4']; ?></span></label>
        </td><td class="right">
        <input id="keywords" name="keywords" value="<?php echo GeneralFunctions::getLocalized($websiteConfig,'keywords',true); ?>" class="inputToolTip" title="<?php echo $langFile['websiteSetup_websiteConfig_field4_inputTip']; ?>">
        </td></tr>
        
        <tr><td class="left">
        <label for="description"><span class="toolTip" title="::<?php echo $langFile['websiteSetup_websiteConfig_field5_tip']; ?>">
        <?php echo $langFile['websiteSetup_websiteConfig_field5']; ?></span></label>
        </td><td class="right">
        <textarea id="description" name="description" cols="50" rows="4" style="white-space:normal;width:500px;height:70px;" class="inputToolTip" title="<?php echo $langFile['websiteSetup_websiteConfig_field5_inputTip']; ?>"><?php echo GeneralFunctions::getLocalized($websiteConfig,'description',true); ?></textarea>
        </td></tr>
        
        <tr><td class="leftBottom"></td><td></td></tr>
      </tbody>
    </table>
    
    <!--<input type="reset" value="" class="button cancel" title="<?php echo $langFile['FORM_BUTTON_CANCEL']; ?>">-->
    <input type="submit" value="" name="websiteConfig" class="button submit center" title="<?php echo $langFile['FORM_BUTTON_SUBMIT']; ?>">
  </div>
  <div class="bottom"></div>
</div>

</form>
<?php

if($adminConfig['user']['editWebsiteFiles']) {  
  // BEARBEITUNG DER ERWEITERTEN WEBSEITEN-EINSTELLUNGEN 
  editFiles($adminConfig['websiteFilesPath'], "editWebsitefile",  $langFile['editFilesSettings_h1_websitefiles'], "websiteFilesAnchor");
}

if($adminConfig['user']['editStyleSheets']) {
  // BEARBEITUNG DER STYLESHEETDATEI
  editFiles($adminConfig['stylesheetPath'], "editCSSfile", $langFile['editFilesSettings_h1_style'], "cssFilesAnchor", "css");
}

?>