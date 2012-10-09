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

// VARS
// $plugins - from editor.controller.php

?>

<div class="box" id="selectPluginsBox">
  <h1 class="toolTipTop" title="::<?php echo sprintf($langFile['EDITOR_TEXT_EDITPLUGINSINEDITOR'],'[i class=\'icons codeSnippets\'][/i]'); ?>"><img src="library/images/icons/pluginsIcon_middle.png" alt="icon" style="position:relative; top:-2px; margin-right:0px;"><?php echo $langFile['EDITOR_pluginSettings_h1']; ?></h1>
  <ul class="jsMultipleSelect resizeOnHover" data-jsMultipleSelect="plugins" data-name="newPlugins" data-type="duplicates">
    <li class="filter"><input type="text" placeholder="<?php echo $langFile['SORTABLEPAGELIST_headText1']; ?>"></li>
    <?php

      // ->> SHOW PLUGINS as OPTIONS
      foreach($plugins as $pluginFolder) {

        // // vars
        $pluginFolderName = basename($pluginFolder);
        $pluginnumberryCode = (file_exists(dirname(__FILE__).'/../../plugins/'.$pluginFolderName.'/languages/'.$_SESSION['feinduraSession']['backendLanguage'].'.php'))
          ? $_SESSION['feinduraSession']['backendLanguage']
          : 'en';
        unset($pluginLangFile);
        $pluginLangFile = @include(dirname(__FILE__).'/../../plugins/'.$pluginFolderName.'/languages/'.$pluginnumberryCode.'.php');
        // $pluginConfig = @include(dirname(__FILE__).'/../../plugins/'.$pluginFolderName.'/config.php');
        // $pluginName = (isset($pluginLangFile['feinduraPlugin_title'])) ? $pluginLangFile['feinduraPlugin_title'] : $pluginFolderName;

        $pluginTitle = (!empty($pluginLangFile['feinduraPlugin_title'])) ? $pluginLangFile['feinduraPlugin_title'] : $pluginFolderName;

        echo '<li class="jsMultipleSelectOption btn" data-value="'.$pluginFolderName.'">'.$pluginTitle.'</li>';
      }
    ?>
  </ul>


  <ul id="pluginMultipleDestination" class="jsMultipleSelectDestination" data-jsMultipleSelect="plugins">
    <?php
      if(is_array($pageContent['plugins'])) {
        foreach ($pageContent['plugins'] as $pluginName => $plugins) {
          foreach ($plugins as $pluginNumber => $plugin) {
            echo '<li data-name="newPlugins" data-value="'.$pluginName.'" data-number="'.$pluginNumber.'"></li>';
          }
        }
      }
    ?>
  </ul>

  <a href="#" class="ok button center" id="savePluginSelectionSubmit" style="display:none"></a>
  <div id="savePluginSelectionLoadingCircleHolder" class="center" style="z-index: 10;"></div>

  <!-- EDIT PLUGINS SCRIPTS -->
  <script type="text/javascript">
  /* <![CDATA[ */
    (function(){

      // ADD the LINK to EDIT THE PLUGIN TO the OPTION
      var modifyOption = function(value,name,clone){

        // vars
        var holdTimeout;
        var pluginName = clone.get('text').replace('×','');
        var number     = clone.retrieve('number');
        var input      = clone.getChildren('input')[0];
        input.setProperty('value',value+'#'+number);

        // modify the selected plugin
        var closeButton = clone.getChildren('a.remove')[0];
        var newLink     = new Element('a',{'text':pluginName, 'class':'editSelection', 'href': '#', events:{
          click: function(e){
            e.stop();
            openWindowBox('library/views/windowBox/editPlugins.php?page='+<?php echo $pageContent['id']; ?>+'&category='+<?php echo $pageContent['category']; ?>+'&plugin='+value+'&number='+number,newLink.get('text'));
          }
        }});
        clone.set('html','');
        clone.grab(newLink).grab(closeButton);
        closeButton.set('text','×'); // ie fix

        // STORE INPUT in the CLONE
        clone.store('input',input);

        // MOVE INPUT to the EDITOR FORM
        $('editorForm').grab(clone.retrieve('input'));


        // MAKE the OPTION DRAGGABLE
        var pluginPlaceholder = new Element('img',{
          'src':'library/thirdparty/ckeditor/plugins/feinduraSnippets/snippetFill.gif',
          'class':'feinduraPlugin',
          'draggable':true,
          styles: {
            'width':'100%'
          },
          'alt':pluginName,
          'title':value+'#'+number
        });
        clone.store('pluginPlaceholder',pluginPlaceholder.clone().setProperty('src','#'));

        // ADD TOOLTIP TEXT
        clone.setProperty('title','::<?php echo $langFile['EDITOR_TIP_DRAGPLUGIN']; ?>');
        feindura_storeTipTexts(clone);
        clone.removeProperty('title');

        var clearPluginPlacholder = function(){
          clearTimeout(holdTimeout);
          if(pluginPlaceholder.getParent('body') !== null) {
            newLink.replaces(pluginPlaceholder);

            // remove toolTips
            toolTipsBottom.detach(clone);
          }
        };

        clone.addEvent('mouseenter',function(e){
          holdTimeout = (function(){
            clearTimeout(holdTimeout);
            if(newLink.getParent('body') !== null) {
              pluginPlaceholder.replaces(newLink);

              // add tooltips
              toolTipsBottom.show(clone);
            }
          }).delay(800);
        });
        clone.addEvent('mouseup',clearPluginPlacholder);
        clone.addEvent('mouseleave',clearPluginPlacholder);
        $('pluginMultipleDestination').addEvent('mouseleave',clearPluginPlacholder);

      };


      // ->> EVENTS

      // PARSED
      $('pluginMultipleDestination').addEvent('parsed',modifyOption);

      // SELECT
      $('pluginMultipleDestination').addEvent('select',function(value,name,clone,option){
        modifyOption(value,name,clone);

        // UPDATE the feindura_plugins array
        feindura_plugins.push([clone.get('text').replace('×',''),value+'#'+clone.retrieve('number')]);

        // mark page as unsaved
        pageContentChangedSign();

        // savePlugins();

        // ADD PLUGIN to the EDITOR
        HTMLEditor.insertHtml(clone.retrieve('pluginPlaceholder').getString());

        // fix the WEBKIT BUG, when selecting, that it scrolls
        if(Browser.chrome || Browser.safari)
          new Fx.Scroll(window.document,{duration:0}).toElement($('selectPluginsBox'));
      });

      // REMOVE
      $('pluginMultipleDestination').addEvent('remove',function(value,name,clone,option,select){

        // UPDATE the feindura_plugins array
        feindura_plugins.each(function(feindura_plugin,i){
          if(feindura_plugin.contains(value+'#'+clone.retrieve('number')))
            feindura_plugins.erase(feindura_plugin);
        });

        // mark page as unsaved
        pageContentChangedSign();

        // remove input from the form
        clone.retrieve('input').dispose();

        // savePlugins();

        // REMOVE PLUGIN from EDITOR
        // almost the same regex like in GeneralFunctions::replaceSnippets()
        var pluginPlaceholderRegEx = new RegExp('<img(?:(?!class).)*class\=\"feinduraPlugin\"(?:(?:(?!style).)*style\=\"((?:(?!").)*)")?(?:(?!title).)*title\="'+value+'\#'+clone.retrieve('number')+'"(?:(?!>).)*>');
        HTMLEditor.setData(HTMLEditor.getData().replace(pluginPlaceholderRegEx,''));
      });


      // var savePlugins = function(){

      //   // vars
      //   var removeLoadingCircle;
      //   var selectedOptions = $('pluginMultipleDestination').retrieve('selectedOptions');
      //   var selectedJson = {
      //     'page': <?php echo $pageContent['id']; ?>,
      //     'category': <?php echo $pageContent['category']; ?>,
      //     'return':false,
      //     'type':'plugins',
      //     'data':[]
      //   };

      //   // prepare post data
      //   selectedOptions.each(function(option){

      //     var value = option.retrieve('value');
      //     var number = option.retrieve('number');
      //     value += '#'+ number;

      //     if(typeOf(value) !== 'null')
      //     selectedJson.data.push(value);
      //   });

      //   new Request({
      //     url: 'library/controllers/savePage.controller.php',
      //     method: 'post',
      //     data: selectedJson,
      //     evalScripts: true,
      //     onRequest: function(){
      //       $('savePluginSelectionSubmit').setStyle('display','none');
      //       $('savePluginSelectionDivBlocked').reveal();
      //       // add loading circle
      //       removeLoadingCircle = feindura_loadingCircle('savePluginSelectionLoadingCircleHolder', 14, 23, 12, 3, "#000");
      //     },
      //     onSuccess: function(responseText){
      //       $('savePluginSelectionDivBlocked').dissolve();
      //       removeLoadingCircle();
      //       feindura_showNotification('<?php echo $langFile['EDITOR_MESSAGE_PLUGINSSAVED']; ?>');
      //     }
      //   }).send();
      // };

    })();
  /* ]]> */
  </script>

</div>