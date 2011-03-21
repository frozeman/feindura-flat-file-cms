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
 * @version 1.0
 */
 
/**
 * Includes the login.include.php and backend.include.php and filter the basic data
 */
require_once(dirname(__FILE__)."/../includes/secure.include.php");
 
?>
<div class="editor">
<textarea name="HTMLEditor" id="HTMLEditor" cols="90" rows="30">
<?php
echo htmlspecialchars($pageContent['content'],ENT_NOQUOTES,'UTF-8',false); ?>
</textarea>
<?php

// -> CHOOSES the RIGHT EDITOR ID and/or CLASS
// -------------------------------------------
// gives the editor the StyleFile/StyleId/StyleClass
// from the Page, if empty,
// than from the Category if empty,
// than from the HTMl-Editor Settings
$editorStyleFiles = generalFunctions::getStylesByPriority($pageContent['styleFile'],'styleFile',$pageContent['category']);
$editorStyleId = generalFunctions::getStylesByPriority($pageContent['styleId'],'styleId',$pageContent['category']);
$editorStyleClass = generalFunctions::getStylesByPriority($pageContent['styleClass'],'styleClass',$pageContent['category']);

// -> CREATES the EDITOR-INSTANCE
// ------------------------------
?>
<script type="text/javascript">
/* <![CDATA[ */  

window.addEvent('domready',function(){

  // set the CONFIGs of the editor with PHP vars (more configs are set in the content.js)
  CKEDITOR.config.baseHref                  = '<?php echo $adminConfig['basePath']."library/thirdparty/ckeditor/"; ?>';
  CKEDITOR.config.language                  = '<?php echo $_SESSION["language"]; ?>';
  CKEDITOR.config.contentsCss               = ['<?php if(($editorStyleFiles = unserialize($editorStyleFiles)) !== false) { $echoStyleFile = ''; foreach($editorStyleFiles as $editorStyleFile) {$uniqueStyleId = (strpos($editorStyleFile,"?") === false) ? "?=".md5(uniqid(rand(),1)) : ''; $echoStyleFile .= $editorStyleFile.$uniqueStyleId."','";} echo substr($echoStyleFile,0,-3); } ?>'];
  CKEDITOR.config.bodyId                    = '<?php echo $editorStyleId; ?>';
  CKEDITOR.config.bodyClass                 = '<?php echo $editorStyleClass; ?>';
  CKEDITOR.config.enterMode                 = <?php if($adminConfig['editor']['enterMode'] == "br") echo "CKEDITOR.ENTER_BR"; else echo "CKEDITOR.ENTER_P"; ?>;
  CKEDITOR.config.stylesSet                 = 'htmlEditorStyles:../../../config/htmlEditorStyles.js';
<?php if($adminConfig['user']['fileManager']) { ?>
  CKEDITOR.config.filebrowserBrowseUrl      = '<?= $adminConfig['basePath']."library/sites/windowBox/filemanager.php"; ?>';
  CKEDITOR.config.filebrowserImageBrowseUrl = '<?= $adminConfig['basePath']."library/sites/windowBox/filemanager.php?mimType=image"; ?>';
  CKEDITOR.config.filebrowserFlashBrowseUrl = '<?= $adminConfig['basePath']."library/sites/windowBox/filemanager.php?mimType=application"; ?>';
  CKEDITOR.config.filebrowserWindowWidth    = 1024;
  CKEDITOR.config.filebrowserWindowHeight   = 700;
  CKEDITOR.config.filebrowserWindowFeatures = 'scrollbars=no,center=yes,status=no';
<?php } ?>
});
/* ]]> */
</script>

    <div class="content">
      <a href="#" id="hotKeysToogle" class="down standardLink"><?php echo $langFile['editor_htmleditor_hotkeys_h1']; ?></a>
      <div id="hotKeys">
      <br />
      <table width="450" cellspacing="0" cellpadding="8" border="0" style="border:1px solid #B3B3B4;">
        <tr>
          <td style="background-color:#EDECEC;">
            <b><?php echo $langFile['editor_htmleditor_hotkeys_field1']; ?></b></td>
          <td align="left" style="background-color:#EDECEC;"> STRG + A</td>
        </tr><tr>
          <td style="background-color:#E3E3E3;">
            <b><?php echo $langFile['editor_htmleditor_hotkeys_field2']; ?></b></td>
          <td align="left" style="background-color:#E3E3E3;"> STRG + C</td>
        </tr><tr>
          <td style="background-color:#EDECEC;">
            <b><?php echo $langFile['editor_htmleditor_hotkeys_field3']; ?></b></td>
          <td align="left" style="background-color:#EDECEC;">
            STRG + V</td>
        </tr><tr>
          <td style="background-color:#E3E3E3;">
            <b><?php echo $langFile['editor_htmleditor_hotkeys_field4']; ?></b></td>
          <td align="left" style="background-color:#E3E3E3;">
            STRG + X 
            <b><?php echo $langFile['editor_htmleditor_hotkeys_or']; ?></b> SHIFT + Del</td>
        </tr><tr>
          <td colspan="2" style="height: 10px;background-color:#fff;"> </td>
        </tr><tr>
          <td style="background-color:#EDECEC;">
            <b><?php echo $langFile['editor_htmleditor_hotkeys_field5']; ?></b></td>
          <td align="left" style="background-color:#EDECEC;"> STRG + Z</td>
        </tr><tr>
          <td style="background-color:#E3E3E3;">
            <b><?php echo $langFile['editor_htmleditor_hotkeys_field6']; ?></b></td>
          <td align="left" style="background-color:#E3E3E3;">
            STRG + Y 
            <b><?php echo $langFile['editor_htmleditor_hotkeys_or']; ?></b> STRG + SHIFT + Z</td>
        </tr><tr>
          <td colspan="2" style="height: 10px;background-color:#fff;"> </td>
        </tr><tr>
          <td style="background-color:#EDECEC;">
            <b><?php echo $langFile['editor_htmleditor_hotkeys_field7']; ?></b></td>
          <td align="left" style="background-color:#EDECEC;"> STRG + L</td>
        </tr><tr>
          <td style="background-color:#E3E3E3;">
            <b><?php echo $langFile['editor_htmleditor_hotkeys_field8']; ?></b></td>
          <td align="left" style="background-color:#E3E3E3;"> STRG + B</td>
        </tr><tr>
          <td style="background-color:#EDECEC;">
            <b><?php echo $langFile['editor_htmleditor_hotkeys_field9']; ?></b></td>
          <td align="left" style="background-color:#EDECEC;"> STRG + I</td>
        </tr><tr>
          <td style="background-color:#E3E3E3;">
            <b><?php echo $langFile['editor_htmleditor_hotkeys_field10']; ?></b></td>
          <td align="left" style="background-color:#E3E3E3;"> STRG + U</td>
        </tr>
      </table>
      </div>
    </div>
    
    <input type="submit" value="" id="HTMLEditorSubmit" class="button submit center" title="<?php echo $langFile['form_submit']; ?>" />
</div>