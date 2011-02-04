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

* sites/pluginSetup.php version 0.1
*/

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
?>
<div class="block">
  <h1><?php echo $langFile['PLUGINSETUP_TITLE']; ?></h1>
  <div class="content">
    <p><?php echo $langFile['PLUGINSETUP_TEXT_DESCRIPTION']; ?></p>
    
  </div>
  <div class="bottom"></div>
</div>

<?php
// ->> GOES TROUGH every PLUGIN
// ---------------------------------------------------------------------------------------------------------------
$pluginFolders = generalFunctions::readFolder(DOCUMENTROOT.$adminConfig['basePath'].'plugins/'); //DOCUMENTROOT.$adminConfig['basePath'].'plugins/'; //dirname(__FILE__).'/../../plugins/'

// VARs
  $firstLine = true;

if($pluginFolders) {
  
  foreach($pluginFolders['folders'] as $pluginFolder) {
    
    // ->> IF plugin folder HAS FILES
    if($pluginSubFolders = generalFunctions::readFolderRecursive($pluginFolder)) {
      
      // VARs
      $pluginFolderName = basename($pluginFolder);
      $savedForm = false;      
      $pluginCountryCode = (file_exists($pluginFolder.'/languages/'.$_SESSION['language'].'.php'))
    	  ? $_SESSION['language']
    	  : 'en';
      unset($pluginLangFile);
      $pluginLangFile = @include($pluginFolder.'/languages/'.$pluginCountryCode.'.php');
      $pluginName = (isset($pluginLangFile['plugin_title'])) ? $pluginLangFile['plugin_title'] : $pluginFolderName;

      echo '<a name='.$pluginFolderName.'Anchor" id="'.$pluginFolderName.'Anchor" class="anchorTarget"></a>
            <form action="index.php?site=pluginSetup#'.$pluginFolderName.'Anchor" method="post" enctype="multipart/form-data" accept-charset="UTF-8" id="pluginForm">
              <div>
              <input type="hidden" name="send" value="pluginsConfig" />
              <input type="hidden" name="savedBlock" value="'.$pluginFolderName.'" />
              </div>';
 
      // -> BEGINN PLUGIN FORM
      // ---------------------------------------------------------------------------
      
      // seperation line
      if($firstLine) $firstLine = false;
      else echo '<div class="blockSpacer"></div>';    
      
      echo '<div class="block open">
              <h1>'.$pluginName.'</h1>';
      echo '  <p>'.$pluginLangFile['plugin_description'].'</p>';        
  ?>
              <table>         
                <colgroup>
                <col class="left" />
                </colgroup>                
                
                <tr><td class="left checkboxes">
                <input type="checkbox" id="plugin_<?= $pluginFolderName; ?>_active" name="plugin[<?= $pluginFolderName; ?>][active]" value="true"<?php echo ($pluginsConfig[$pluginFolderName]['active']) ? ' checked="checked"' : ''; ?> />                
                </td><td class="right checkboxes">
                <label for="plugin_<?= $pluginFolderName; ?>_active"><?php echo $langFile['PLUGINSETUP_TEXT_ACTIVE']; ?></label><br />
                </td></tr>
                
                <!--<tr><td class="leftTop"></td><td></td></tr>          
                <tr><td class="leftBottom"></td><td></td></tr>-->
                
              </table>              
  <?php
        echo '<input type="submit" value="" class="button submit center" />';
        echo '</form>';        
              // edit plugin files
              editFiles($pluginFolder, $_GET['site'], "edit".$pluginFolderName,  $pluginName.' '.$langFile['PLUGINSETUP_TITLE_EDITFILES'], $pluginFolderName."EditFilesAnchor", "php",'plugin.config.php');
      echo '</div>';   
      
    }
  } 
}

?>