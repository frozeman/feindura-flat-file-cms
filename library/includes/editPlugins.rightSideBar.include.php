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
 * /includes/editPlugins.rightSideBar.include.php
 *
 * @version 0.1
 */

// AVAILABLE VARS
// $activatedPlugins from editor.php

// vars
$blockContentEdited = (isset($pageContent['plugins']))
  ? '&nbsp;<img src="library/images/icons/edited_small.png" class="toolTipLeft" title="'.$langFile['EDITOR_pluginSettings_h1'].' '.$langFile['EDITOR_block_edited'].'::" alt="icon" width="27" height="23">'
  : '';

?>

<div class="box">
  <h1><?php echo $langFile['EDITOR_pluginSettings_h1'].$blockContentEdited; ?></h1>
  <ul class="jsMultipleSelect resizeOnHover" data-jsMultipleSelect="plugins" data-name="plugins" data-type="duplicates">
    <li class="filter"><input type="text" placeholder="<?php echo $langFile['SORTABLEPAGELIST_headText1']; ?>"></li>
    <?php

      // ->> SHOW PLUGINS as OPTIONS
      $activatedPluginsPaths = array();
      foreach ($activatedPlugins as $activatedPlugin)
        $activatedPluginsPaths[] = dirname(__FILE__).'/../../plugins/'.$activatedPlugin.'/';

      foreach($activatedPluginsPaths as $pluginFolder) {

        // // vars
        $pluginFolderName = basename($pluginFolder);
        $pluginCountryCode = (file_exists(dirname(__FILE__).'/../../plugins/'.$pluginFolderName.'/languages/'.$_SESSION['feinduraSession']['backendLanguage'].'.php'))
          ? $_SESSION['feinduraSession']['backendLanguage']
          : 'en';
        // unset($pluginConfig,$pluginLangFile);
        $pluginLangFile = @include(dirname(__FILE__).'/../../plugins/'.$pluginFolderName.'/languages/'.$pluginCountryCode.'.php');
        // $pluginConfig = @include(dirname(__FILE__).'/../../plugins/'.$pluginFolderName.'/config.php');
        // $pluginName = (isset($pluginLangFile['feinduraPlugin_title'])) ? $pluginLangFile['feinduraPlugin_title'] : $pluginFolderName;


        echo '<li class="jsMultipleSelectOption btn" data-value="'.$pluginFolderName.'" data-name="plugins">'.$pluginLangFile['feinduraPlugin_title'].'</li>';
      }
    ?>
  </ul>


  <ul class="jsMultipleSelectDestination" data-jsMultipleSelect="plugins">

  </ul>
</div>