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
 * includes/editor.include.php
 *
 * @version 1.0.1
 */

/**
 * Includes the login.include.php and backend.include.php and filter the basic data
 */
require_once(dirname(__FILE__)."/../includes/secure.include.php");


?>
<!-- editor anchor is here -->
<a id="editorAnchor" class="anchorTarget"></a>

<div class="block editor">
  <textarea name="HTMLEditor" id="HTMLEditor" cols="90" rows="30">
    <?php echo htmlspecialchars(GeneralFunctions::getLocalized($pageContent,'content',false,true),ENT_NOQUOTES,'UTF-8'); ?>
  </textarea>
<?php

// -> CHOOSES the RIGHT EDITOR ID and/or CLASS
// -------------------------------------------
// gives the editor the StyleFile/StyleId/StyleClass
// from the Page, if empty,
// than from the Category if empty,
// than from the HTMl-Editor Settings
$editorStyleFiles = getStylesByPriority($pageContent['styleFile'],'styleFile',$pageContent['category']);
$editorStyleId    = getStylesByPriority($pageContent['styleId'],'styleId',$pageContent['category']);
$editorStyleClass = getStylesByPriority($pageContent['styleClass'],'styleClass',$pageContent['category']);

// -> CREATES the EDITOR-INSTANCE
// ------------------------------
?>
<script type="text/javascript">
/* <![CDATA[ */

  // -> TRANSPORT Snippets to CKEditor feinduraSnippets plugin
  var feindura_plugins = [
    ['-',''],
<?php
      // check if plugins are activated in the category
      $hasPlugins = false;
      if(is_array($pageContent['plugins']) && $categoryConfig[$pageContent['category']]['plugins']) {
        $transportPlugins = '';
        foreach ($pageContent['plugins'] as $pluginFolderName => $plugins) {
          foreach ($plugins as $pluginNumber => $pluginValues) {
            $pluginFolder = $adminConfig['basePath'].'plugins/'.$pluginFolderName;
            $pluginCountryCode = (file_exists(DOCUMENTROOT.$pluginFolder.'/languages/'.$_SESSION['feinduraSession']['backendLanguage'].'.php'))
              ? $_SESSION['feinduraSession']['backendLanguage']
              : 'en';
            $pluginLangFile = @include(DOCUMENTROOT.$pluginFolder.'/languages/'.$pluginCountryCode.'.php');
            $hasPlugins = true;

            $pluginName = str_replace('"','',$pluginLangFile['feinduraPlugin_title']) ;
            $pluginName .= ($pluginNumber > 1) ? ' #'.$pluginNumber : '';
            $transportPlugins .= '    ["'.$pluginName.'","'.$pluginFolderName.'#'.$pluginNumber.'"],'."\n";
          }
        }
        echo trim($transportPlugins,",\n")."\n";
      }
      unset($pluginLangFile,$plugins,$pluginValues,$pluginNumber);
?>
  ];

  var feinduraSnippetsActive = <?php echo ($adminConfig['editor']['snippets']) ? 'true' : 'false'; ?>;
  var feinduraPluginsActive  = <?php echo ($categoryConfig[$pageContent['category']]['plugins']) ? 'true' : 'false'; ?>;


window.addEvent('domready',function() {

  // -> set the CONFIGs of the editor with PHP vars (more configs are set in the content.js)

  // BASE
  CKEDITOR.config.baseHref                  = '<?php echo $adminConfig['url'].GeneralFunctions::Path2URI(GeneralFunctions::getDirname($adminConfig['websitePath'])); ?>';
  CKEDITOR.config.language                  = '<?php echo $_SESSION["feinduraSession"]["backendLanguage"]; ?>';
  CKEDITOR.config.extraPlugins              = 'codemirror,tableresize,magicline,scayt,mediaembed'; //stylesheetparser,Media
  CKEDITOR.config.magicline_color           = '#2480f9';
  CKEDITOR.config.blockedKeystrokes.push(CKEDITOR.CTRL + 83);
  CKEDITOR.config.docType                   = '<!doctype html">';
  CKEDITOR.config.entities                  = false;

<?php
  // SNIPPETS
if($adminConfig['editor']['snippets'] || $categoryConfig[$pageContent['category']]['plugins']) { ?>
  CKEDITOR.config.extraPlugins              += ',feinduraSnippets';
  CKEDITOR.config.menu_groups               += ',feinduraSnippetsGroup';
<?php }

  // CSS
if(($editorStyleFiles = unserialize($editorStyleFiles)) !== false && !empty($editorStyleFiles)) { ?>
  CKEDITOR.config.contentsCss               = ['<?php $echoStyleFile = '';
                                                      foreach($editorStyleFiles as $editorStyleFile) {
                                                        $uniqueStyleId = (strpos($editorStyleFile,"?") === false)
                                                          ? "?".md5(uniqid(rand(),1))
                                                          : '';
                                                        $echoStyleFile .= GeneralFunctions::Path2URI($editorStyleFile).$uniqueStyleId."','";
                                                      }
                                                      echo substr($echoStyleFile,0,-3);
                                                      ?>','<?php echo GeneralFunctions::Path2URI($adminConfig['basePath']); ?>library/thirdparty/ckeditor/plugins/feinduraSnippets/styles.css'];
<?php } ?>
  CKEDITOR.config.bodyId                    = '<?php echo $editorStyleId; ?>';
  CKEDITOR.config.bodyClass                 = '<?php echo $editorStyleClass; ?>';

  CKEDITOR.config.forceEnterMode            = true; // forces p inside a div


<?php
  // ENTER MODE
if($adminConfig['editor']['enterMode'] == 'br') { ?>
  CKEDITOR.config.enterMode                 = CKEDITOR.ENTER_BR;
  CKEDITOR.config.shiftEnterMode            = CKEDITOR.ENTER_P;
<?php } else { ?>
  CKEDITOR.config.enterMode                 = CKEDITOR.ENTER_P;
  CKEDITOR.config.shiftEnterMode            = CKEDITOR.ENTER_BR;

  // CUSTOM STYLES
<?php } if(!$adminConfig['editor']['editorStyles']) { ?>
  CKEDITOR.config.removePlugins = 'stylescombo';
<?php } if(GeneralFunctions::hasPermission('editorStyles') && file_exists(dirname(__FILE__)."/../../config/EditorStyles.js")) { ?>
  CKEDITOR.config.stylesSet                 = 'htmlEditorStyles:../../../config/EditorStyles.js?<?php echo md5(uniqid(rand(),1)); ?>';
<?php }

  // FILEMANAGER
if(GeneralFunctions::hasPermission('fileManager')) {
?>
  CKEDITOR.config.filebrowserBrowseUrl      = '<?php echo GeneralFunctions::Path2URI($adminConfig['basePath'])."library/views/windowBox/fileManager.php"; ?>';
  CKEDITOR.config.filebrowserImageBrowseUrl = '<?php echo GeneralFunctions::Path2URI($adminConfig['basePath'])."library/views/windowBox/fileManager.php?mimType=image"; ?>';
  CKEDITOR.config.filebrowserFlashBrowseUrl = '<?php echo GeneralFunctions::Path2URI($adminConfig['basePath'])."library/views/windowBox/fileManager.php?mimType=application"; ?>';
  CKEDITOR.config.filebrowserWindowWidth    = 1000;
  CKEDITOR.config.filebrowserWindowHeight   = 650;
  CKEDITOR.config.filebrowserWindowFeatures = 'scrollbars=no,center=yes,status=no';
<?php } ?>
});
/* ]]> */
</script>

  <div class="content form">
    <!-- page settings anchor is here -->
    <a id="pageSettings" class="anchorTarget"></a>

    <span id="hotKeysToogle" class="down link toolTipRight" title="::[table]
      [tbody]
        [tr]
          [td]
            [strong]<?php echo $langFile['EDITOR_htmleditor_hotkeys_field1']; ?>[/strong][/td]
          [td] STRG + A[/td]
        [/tr][tr]
          [td]
            [strong]<?php echo $langFile['EDITOR_htmleditor_hotkeys_field2']; ?>[/strong][/td]
          [td] STRG + C[/td]
        [/tr][tr]
          [td]
            [strong]<?php echo $langFile['EDITOR_htmleditor_hotkeys_field3']; ?>[/strong][/td]
          [td]
            STRG + V[/td]
        [/tr][tr]
          [td]
            [strong]<?php echo $langFile['EDITOR_htmleditor_hotkeys_field4']; ?>[/strong][/td]
          [td]
            STRG + X
            [strong]<?php echo $langFile['EDITOR_htmleditor_hotkeys_or']; ?>[/strong] SHIFT + Del[/td]
        [/tr][tr]
          [td colspan=2 style=height: 10px;background-color:#fff;] [/td]
        [/tr][tr]
          [td]
            [strong]<?php echo $langFile['EDITOR_htmleditor_hotkeys_field5']; ?>[/strong][/td]
          [td] STRG + Z[/td]
        [/tr][tr]
          [td]
            [strong]<?php echo $langFile['EDITOR_htmleditor_hotkeys_field6']; ?>[/strong][/td]
          [td]
            STRG + Y
            [strong]<?php echo $langFile['EDITOR_htmleditor_hotkeys_or']; ?>[/strong] STRG + SHIFT + Z[/td]
        [/tr][tr]
          [td colspan=2 style=height: 10px;background-color:#fff;] [/td]
        [/tr][tr]
          [td]
            [strong]<?php echo $langFile['EDITOR_htmleditor_hotkeys_field7']; ?>[/strong][/td]
          [td] STRG + L[/td]
        [/tr][tr]
          [td]
            [strong]<?php echo $langFile['EDITOR_htmleditor_hotkeys_field8']; ?>[/strong][/td]
          [td] STRG + B[/td]
        [/tr][tr]
          [td]
            [strong]<?php echo $langFile['EDITOR_htmleditor_hotkeys_field9']; ?>[/strong][/td]
          [td] STRG + I[/td]
        [/tr][tr]
          [td]
            [strong]<?php echo $langFile['EDITOR_htmleditor_hotkeys_field10']; ?>[/strong][/td]
          [td] STRG + U[/td]
        [/tr]
      [/tbody]
    [/table]">
    <?php echo $langFile['EDITOR_htmleditor_hotkeys_h1']; ?>
    </span>
    <br class="clear">
    <?php

    if(!$NEWPAGE)
      include(dirname(__FILE__).'/pageMetaData.include.php');

    ?>
    <input type="submit" value="" class="button submit center" title="<?php echo $langFile['FORM_BUTTON_SUBMIT']; ?>">
  </div>
</div>