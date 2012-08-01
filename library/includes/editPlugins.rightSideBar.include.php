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
// $blockContentEdited = (isset($pageContent['plugins']))
//   ? '&nbsp;<img src="library/images/icons/edited_small.png" class="toolTipLeft" title="'.$langFile['EDITOR_pluginSettings_h1'].' '.$langFile['EDITOR_block_edited'].'::" alt="icon" width="27" height="23">'
//   : '';

?>

<div class="box">
  <h1><?php echo $langFile['EDITOR_pluginSettings_h1']; ?></h1>
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
        $pluginnumberryCode = (file_exists(dirname(__FILE__).'/../../plugins/'.$pluginFolderName.'/languages/'.$_SESSION['feinduraSession']['backendLanguage'].'.php'))
          ? $_SESSION['feinduraSession']['backendLanguage']
          : 'en';
        unset($pluginLangFile);
        $pluginLangFile = @include(dirname(__FILE__).'/../../plugins/'.$pluginFolderName.'/languages/'.$pluginnumberryCode.'.php');
        // $pluginConfig = @include(dirname(__FILE__).'/../../plugins/'.$pluginFolderName.'/config.php');
        // $pluginName = (isset($pluginLangFile['feinduraPlugin_title'])) ? $pluginLangFile['feinduraPlugin_title'] : $pluginFolderName;


        echo '<li class="jsMultipleSelectOption btn" data-value="'.$pluginFolderName.'" data-name="plugins">'.$pluginLangFile['feinduraPlugin_title'].'</li>';
      }
    ?>
  </ul>


  <ul id="pluginMultipleSelect" class="jsMultipleSelectDestination" data-jsMultipleSelect="plugins">
    <?php
      foreach ($pageContent['plugins'] as $pluginName => $plugins) {
        foreach ($plugins as $pluginNumber => $plugin) {
          echo '<li data-name="plugins" data-value="'.$pluginName.'" data-number="'.$pluginNumber.'"></li>';
        }
      }
    ?>
  </ul>

  <a href="#" class="ok button center" id="savePluginSelectionSubmit" style="display:none"></a>

  <!-- EDIT PLUGINS SCRIPTS -->
  <script type="text/javascript">
  /* <![CDATA[ */
    (function(){

      // ADD the LINK to EDIT THE PLUGIN TO the OPTION
      var modifyOption = function(value,name,clone){
        // modify the selected plugin
        var closeButton = clone.getChildren('a')[0];
        var newLink     = new Element('a',{'text':clone.get('text').replace('×',''), 'class':'editSelection', 'href': '#', events:{
          click: function(e){
            e.stop();

            // vars
            number = clone.retrieve('number');
            openWindowBox('library/views/windowBox/editPlugins.php?plugin='+value+'&number='+number,newLink.get('text'));
          }
        }});
        clone.set('html','');
        clone.grab(newLink).grab(closeButton);
      };


      // ->> EVENTS
      // SELECT
      $('pluginMultipleSelect').addEvent('select',function(value,name,clone,option){
        modifyOption(value,name,clone);

        // show the save button
        $('savePluginSelectionSubmit').show();

      });

      // PARESED
      $('pluginMultipleSelect').addEvent('parsed',modifyOption);

      // REMOVE
      $('pluginMultipleSelect').addEvent('remove',function(value,name,clone,option,select){
        // show the save button
        $('savePluginSelectionSubmit').show();
      });


      // ON SAVE
      $('savePluginSelectionSubmit').addEvent('click',function(e){
        e.stop();

        var selectedOptions = $('pluginMultipleSelect').retrieve('selectedOptions');
        var selectedJson = {
          'page': <?php echo $pageContent['id']; ?>,
          'category': <?php echo $pageContent['category']; ?>,
          'return':false,
          'type':'plugins',
          'data':[]
        };

        selectedOptions.each(function(option){

          var value = option.retrieve('value');
          var number = option.retrieve('number');
          value += '#'+ number;

          if(typeOf(value) !== 'null')
          selectedJson.data.push(value);
        });

        new Request({
          url: 'library/controllers/savePage.controller.php',
          method: 'post',
          data: selectedJson,
          evalScripts: true,
          onRequest: function(){

          },
          onSuccess: function(responseText){
            console.log(responseText);
          }
        }).send();

      });

    })();
  /* ]]> */
  </script>

</div>