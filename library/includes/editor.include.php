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
<a id="editorAnchor" class="anchorTarget"></a>
<div class="editor">
<textarea name="HTMLEditor" id="HTMLEditor" cols="90" rows="30">
<?php echo htmlspecialchars(GeneralFunctions::getLocalized($pageContent,'content',true),ENT_NOQUOTES,'UTF-8'); ?>
</textarea>
<?php

// -> CHOOSES the RIGHT EDITOR ID and/or CLASS
// -------------------------------------------
// gives the editor the StyleFile/StyleId/StyleClass
// from the Page, if empty,
// than from the Category if empty,
// than from the HTMl-Editor Settings
$editorStyleFiles = GeneralFunctions::getStylesByPriority($pageContent['styleFile'],'styleFile',$pageContent['category']);
$editorStyleId = GeneralFunctions::getStylesByPriority($pageContent['styleId'],'styleId',$pageContent['category']);
$editorStyleClass = GeneralFunctions::getStylesByPriority($pageContent['styleClass'],'styleClass',$pageContent['category']);

// -> CREATES the EDITOR-INSTANCE
// ------------------------------
?>
<script type="text/javascript">
/* <![CDATA[ */  

  // -> TRANSPORT Snippets to CKEditor feinduraSnippets plugin
  var feindura_plugins = [
    <?php
      // check if plugins are activated
      if(is_array($pageContent['plugins']) && is_array($activatedPlugins) && count($activatedPlugins) >= 1) {
        $hasPlugins = false;
        foreach ($pageContent['plugins'] as $pluginName => $pluginValues) {
          if(in_array($pluginName,$activatedPlugins)) {
            $pluginFolder = $adminConfig['basePath'].'plugins/'.$pluginName;
            $pluginCountryCode = (file_exists(DOCUMENTROOT.$pluginFolder.'/languages/'.$_SESSION['feinduraSession']['backendLanguage'].'.php'))
              ? $_SESSION['feinduraSession']['backendLanguage']
              : 'en';
            $pluginLangFile = @include(DOCUMENTROOT.$pluginFolder.'/languages/'.$pluginCountryCode.'.php');
            $hasPlugins = true;
            echo '["'.str_replace('"','',$pluginLangFile['feinduraPlugin_title']).'","'.$pluginName.'"],';
          }
        }
      }
      unset($pluginLangFile);
    ?>
  ];

window.addEvent('domready',function() {

  // -> set the CONFIGs of the editor with PHP vars (more configs are set in the content.js)

// BASE
  CKEDITOR.config.baseHref                  = '<?php echo $adminConfig['url'].GeneralFunctions::getDirname($adminConfig['websitePath']); ?>'; //$adminConfig['basePath']."library/thirdparty/ckeditor/"
  CKEDITOR.config.language                  = '<?php echo $_SESSION["feinduraSession"]["backendLanguage"]; ?>';
  CKEDITOR.config.extraPlugins              = 'Media,codemirror'; //stylesheetparser
  CKEDITOR.config.blockedKeystrokes.push(CKEDITOR.CTRL + 83);
  CKEDITOR.config.docType                   = '<!doctype html">';
  CKEDITOR.config.entities                  = false;

<?php 
// SNIPPETS
if($adminConfig['editor']['snippets'] || $hasPlugins) { ?>
  CKEDITOR.config.extraPlugins              += ',feinduraSnippets';
  CKEDITOR.config.menu_groups               += ',feinduraSnippetsGroup';
<?php }

// CSS
if(($editorStyleFiles = unserialize($editorStyleFiles)) !== false && !empty($editorStyleFiles)) { ?>
  CKEDITOR.config.contentsCss               = ['<?php $echoStyleFile = ''; foreach($editorStyleFiles as $editorStyleFile) {$uniqueStyleId = (strpos($editorStyleFile,"?") === false) ? "?".md5(uniqid(rand(),1)) : ''; $echoStyleFile .= $editorStyleFile.$uniqueStyleId."','";} echo substr($echoStyleFile,0,-3); ?>','<?php echo $adminConfig['basePath']; ?>library/thirdparty/ckeditor/plugins/feinduraSnippets/styles.css'];
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
<? } if(!$adminConfig['editor']['editorStyles']) { ?>
  CKEDITOR.config.removePlugins = 'stylescombo';
<?php } if($adminConfig['editor']['editorStyles'] && file_exists(dirname(__FILE__)."/../../config/EditorStyles.js")) { ?>
  CKEDITOR.config.stylesSet                 = 'htmlEditorStyles:../../../config/EditorStyles.js?<?php echo md5(uniqid(rand(),1)); ?>';
<?php }

// FILEMANAGER
if($adminConfig['user']['fileManager']) {
?>
  CKEDITOR.config.filebrowserBrowseUrl      = '<?php echo $adminConfig['basePath']."library/views/windowBox/fileManager.php"; ?>';
  CKEDITOR.config.filebrowserImageBrowseUrl = '<?php echo $adminConfig['basePath']."library/views/windowBox/fileManager.php?mimType=image"; ?>';
  CKEDITOR.config.filebrowserFlashBrowseUrl = '<?php echo $adminConfig['basePath']."library/views/windowBox/fileManager.php?mimType=application"; ?>';
  CKEDITOR.config.filebrowserWindowWidth    = 960;
  CKEDITOR.config.filebrowserWindowHeight   = 600;
  CKEDITOR.config.filebrowserWindowFeatures = 'scrollbars=no,center=yes,status=no';
<?php } ?>
});
/* ]]> */
</script>

    <div class="content">
      <a href="#" id="hotKeysToogle" class="down standardLink"><?php echo $langFile['EDITOR_htmleditor_hotkeys_h1']; ?></a>
      <div id="hotKeys">
      <br>
      <table style="width:450px; padding: 8px; border-spacing: 0; border:1px solid #B3B3B4;">
        <tbody>
          <tr>
            <td style="background-color:#EDECEC;">
              <b><?php echo $langFile['EDITOR_htmleditor_hotkeys_field1']; ?></b></td>
            <td align="left" style="background-color:#EDECEC;"> STRG + A</td>
          </tr><tr>
            <td style="background-color:#E3E3E3;">
              <b><?php echo $langFile['EDITOR_htmleditor_hotkeys_field2']; ?></b></td>
            <td align="left" style="background-color:#E3E3E3;"> STRG + C</td>
          </tr><tr>
            <td style="background-color:#EDECEC;">
              <b><?php echo $langFile['EDITOR_htmleditor_hotkeys_field3']; ?></b></td>
            <td align="left" style="background-color:#EDECEC;">
              STRG + V</td>
          </tr><tr>
            <td style="background-color:#E3E3E3;">
              <b><?php echo $langFile['EDITOR_htmleditor_hotkeys_field4']; ?></b></td>
            <td align="left" style="background-color:#E3E3E3;">
              STRG + X 
              <b><?php echo $langFile['EDITOR_htmleditor_hotkeys_or']; ?></b> SHIFT + Del</td>
          </tr><tr>
            <td colspan="2" style="height: 10px;background-color:#fff;"> </td>
          </tr><tr>
            <td style="background-color:#EDECEC;">
              <b><?php echo $langFile['EDITOR_htmleditor_hotkeys_field5']; ?></b></td>
            <td align="left" style="background-color:#EDECEC;"> STRG + Z</td>
          </tr><tr>
            <td style="background-color:#E3E3E3;">
              <b><?php echo $langFile['EDITOR_htmleditor_hotkeys_field6']; ?></b></td>
            <td align="left" style="background-color:#E3E3E3;">
              STRG + Y 
              <b><?php echo $langFile['EDITOR_htmleditor_hotkeys_or']; ?></b> STRG + SHIFT + Z</td>
          </tr><tr>
            <td colspan="2" style="height: 10px;background-color:#fff;"> </td>
          </tr><tr>
            <td style="background-color:#EDECEC;">
              <b><?php echo $langFile['EDITOR_htmleditor_hotkeys_field7']; ?></b></td>
            <td align="left" style="background-color:#EDECEC;"> STRG + L</td>
          </tr><tr>
            <td style="background-color:#E3E3E3;">
              <b><?php echo $langFile['EDITOR_htmleditor_hotkeys_field8']; ?></b></td>
            <td align="left" style="background-color:#E3E3E3;"> STRG + B</td>
          </tr><tr>
            <td style="background-color:#EDECEC;">
              <b><?php echo $langFile['EDITOR_htmleditor_hotkeys_field9']; ?></b></td>
            <td align="left" style="background-color:#EDECEC;"> STRG + I</td>
          </tr><tr>
            <td style="background-color:#E3E3E3;">
              <b><?php echo $langFile['EDITOR_htmleditor_hotkeys_field10']; ?></b></td>
            <td align="left" style="background-color:#E3E3E3;"> STRG + U</td>
          </tr>
        </tbody>
      </table>
      </div>
    </div>
    
    <input type="submit" value="" id="HTMLEditorSubmit" class="button submit center" title="<?php echo $langFile['FORM_BUTTON_SUBMIT']; ?>">
</div>