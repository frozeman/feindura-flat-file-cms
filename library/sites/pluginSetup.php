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

* pluginSetup.php version 0.1
*/

//include_once(dirname(__FILE__)."/../backend.include.php");


// ----------------------------------------------------------------------------------------------------------------------------------------
// **--** SAVE PROCESS --------------------------------------------------------------------------------------------------------------------
// ----------------------------------------------------------------------------------------------------------------------------------------

// ---------------------------------------------------------------------------------------------------
// ****** ---------- SAVE PLUGIN CONFIG in config/admin.config.php
if(isset($_POST['send']) && $_POST['send'] ==  'pluginsConfig') {
  
  // prepare vars
  $pluginsConfig[$_POST['savedBlock']]['active'] = $_POST['plugin'][$_POST['savedBlock']]['active'];
  
  // **** opens admin.config.php for writing
  if(savePluginsConfig($pluginsConfig)) {
     
    // give documentSaved status
    $documentSaved = true;
    $statisticFunctions->saveTaskLog(11,$_POST['savedBlock']); // <- SAVE the task in a LOG FILE
    
  } else
    $errorWindow .= $langFile['pluginSetup_pluginconfig_error_save'].' '.$adminConfig['basePath'].'config/plugin.config.php';
  
  $savedForm = $_POST['savedBlock'];
}

// ---------- SAVE the editFiles
include(dirname(__FILE__).'/../process/saveEditFiles.php');

// RE-INCLUDE
$pluginsConfig = @include (dirname(__FILE__)."/../../config/plugins.config.php");

// ------------------------------- ENDE of the SAVING SCRIPT -------------------------------------------------------------------------------


// CHECKs if the ncessary FILEs are WRITEABLE, otherwise throw an error
// ----------------------------------------------------------------------------------------
$checkFolders[] = $adminConfig['basePath'].'plugins/';

// gives the error OUTPUT if one of these files in unwriteable
if(($unwriteableList = isWritableWarningRecursive($checkFolders)) && checkBasePath()) {
  echo '<div class="block warning">
    <h1>'.$langFile['adminSetup_error_title'].'</h1>
    <div class="content">
      <p>'.$unwriteableList.'</p><!-- needs <p> tags for margin-left:..-->
    </div>
    <div class="bottom"></div>  
  </div>'; 
  
  echo '<div class="blockSpacer"></div>';
}


// ->> GOES TROUGH every PLUGIN
// ---------------------------------------------------------------------------------------------------------------
$pluginFolders = $generalFunctions->readFolder(DOCUMENTROOT.$adminConfig['basePath'].'plugins/'); //DOCUMENTROOT.$adminConfig['basePath'].'plugins/'; //dirname(__FILE__).'/../../plugins/'

// VARs
  $firstLine = true;

if($pluginFolders) {
  
  foreach($pluginFolders['folders'] as $pluginFolder) {
    
    // ->> IF plugin folder HAS FILES
    if($pluginSubFolders = $generalFunctions->readFolderRecursive($pluginFolder)) {
      
      // VARs
      $pluginName = basename($pluginFolder);
      $savedForm = false;
      
      echo '<a name='.$pluginName.'Anchor" id="'.$pluginName.'Anchor" class="anchorTarget"></a>
            <form action="?site=pluginSetup#'.$pluginName.'Anchor" method="post" enctype="multipart/form-data" accept-charset="UTF-8" id="pluginForm">
              <div>
              <input type="hidden" name="send" value="pluginsConfig" />
              <input type="hidden" name="savedBlock" value="'.$pluginName.'" />
              </div>';
 
      // -> BEGINN PLUGIN FORM
      // ---------------------------------------------------------------------------
      
      // seperation line
      if($firstLine) $firstLine = false;
      else echo '<div class="blockSpacer"></div>';    
      
      echo '<div class="block open">
              <h1>'.$pluginName.'</h1>';
  ?>
              <table>
         
                <colgroup>
                <col class="left" />
                </colgroup>
                
                
                <tr><td class="left checkboxes">
                <input type="checkbox" id="plugin_<?= $pluginName; ?>" name="plugin[<?= $pluginName; ?>][active]" value="true"<?php echo ($pluginsConfig[$pluginName]['active']) ? ' checked="checked"' : ''; ?> />                
                </td><td class="right checkboxes">
                <label for="plugin_<?= $pluginName; ?>"><?php echo $langFile['pluginSetup_pluginconfig_active']; ?></label><br />
                </td></tr>
                
                <!--<tr><td class="leftTop"></td><td></td></tr>
  
          
                <tr><td class="leftBottom"></td><td></td></tr>-->
                
              </table>
              
  <?php
        echo '<input type="submit" value="" class="button submit center" />';
        echo '</form>';
        
              // edit plugin files
              editFiles($pluginFolder, $_GET['site'], "edit".$pluginName,  $pluginName.' '.$langFile['pluginSetup_editFiles_h1'], $pluginName."EditFilesAnchor", "php",'plugin.config.php');
  
      echo '</div>';   
      
    }
  } 
}

?>