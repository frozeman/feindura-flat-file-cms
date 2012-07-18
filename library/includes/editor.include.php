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
<div class="block editor">
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
  CKEDITOR.config.baseHref                  = '<?php echo $adminConfig['url'].GeneralFunctions::Path2URI(GeneralFunctions::getDirname($adminConfig['websitePath'])); ?>';
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
if($adminConfig['user']['fileManager']) {
?>
  CKEDITOR.config.filebrowserBrowseUrl      = '<?php echo GeneralFunctions::Path2URI($adminConfig['basePath'])."library/views/windowBox/fileManager.php"; ?>';
  CKEDITOR.config.filebrowserImageBrowseUrl = '<?php echo GeneralFunctions::Path2URI($adminConfig['basePath'])."library/views/windowBox/fileManager.php?mimType=image"; ?>';
  CKEDITOR.config.filebrowserFlashBrowseUrl = '<?php echo GeneralFunctions::Path2URI($adminConfig['basePath'])."library/views/windowBox/fileManager.php?mimType=application"; ?>';
  CKEDITOR.config.filebrowserWindowWidth    = 960;
  CKEDITOR.config.filebrowserWindowHeight   = 600;
  CKEDITOR.config.filebrowserWindowFeatures = 'scrollbars=no,center=yes,status=no';
<?php } ?>
});
/* ]]> */
</script>

  <div class="content">

    <div class="row">
      <div class="span3">
        <a href="#" id="hotKeysToogle" class="down link"><?php echo $langFile['EDITOR_htmleditor_hotkeys_h1']; ?></a>
        <div id="hotKeys">
        <br>
        <table class="hotKeys">
          <tbody>
            <tr>
              <td style="background-color:#EDECEC;">
                <b><?php echo $langFile['EDITOR_htmleditor_hotkeys_field1']; ?></b></td>
              <td style="background-color:#EDECEC;"> STRG + A</td>
            </tr><tr>
              <td style="background-color:#E3E3E3;">
                <b><?php echo $langFile['EDITOR_htmleditor_hotkeys_field2']; ?></b></td>
              <td style="background-color:#E3E3E3;"> STRG + C</td>
            </tr><tr>
              <td style="background-color:#EDECEC;">
                <b><?php echo $langFile['EDITOR_htmleditor_hotkeys_field3']; ?></b></td>
              <td style="background-color:#EDECEC;">
                STRG + V</td>
            </tr><tr>
              <td style="background-color:#E3E3E3;">
                <b><?php echo $langFile['EDITOR_htmleditor_hotkeys_field4']; ?></b></td>
              <td style="background-color:#E3E3E3;">
                STRG + X
                <b><?php echo $langFile['EDITOR_htmleditor_hotkeys_or']; ?></b> SHIFT + Del</td>
            </tr><tr>
              <td colspan="2" style="height: 10px;background-color:#fff;"> </td>
            </tr><tr>
              <td style="background-color:#EDECEC;">
                <b><?php echo $langFile['EDITOR_htmleditor_hotkeys_field5']; ?></b></td>
              <td style="background-color:#EDECEC;"> STRG + Z</td>
            </tr><tr>
              <td style="background-color:#E3E3E3;">
                <b><?php echo $langFile['EDITOR_htmleditor_hotkeys_field6']; ?></b></td>
              <td style="background-color:#E3E3E3;">
                STRG + Y
                <b><?php echo $langFile['EDITOR_htmleditor_hotkeys_or']; ?></b> STRG + SHIFT + Z</td>
            </tr><tr>
              <td colspan="2" style="height: 10px;background-color:#fff;"> </td>
            </tr><tr>
              <td style="background-color:#EDECEC;">
                <b><?php echo $langFile['EDITOR_htmleditor_hotkeys_field7']; ?></b></td>
              <td style="background-color:#EDECEC;"> STRG + L</td>
            </tr><tr>
              <td style="background-color:#E3E3E3;">
                <b><?php echo $langFile['EDITOR_htmleditor_hotkeys_field8']; ?></b></td>
              <td style="background-color:#E3E3E3;"> STRG + B</td>
            </tr><tr>
              <td style="background-color:#EDECEC;">
                <b><?php echo $langFile['EDITOR_htmleditor_hotkeys_field9']; ?></b></td>
              <td style="background-color:#EDECEC;"> STRG + I</td>
            </tr><tr>
              <td style="background-color:#E3E3E3;">
                <b><?php echo $langFile['EDITOR_htmleditor_hotkeys_field10']; ?></b></td>
              <td style="background-color:#E3E3E3;"> STRG + U</td>
            </tr>
          </tbody>
        </table>
        </div>
      </div>

      <div class="span5">
      <?php

      $thumbnailPath = (!empty($pageContent['thumbnail'] )) ? GeneralFunctions::Path2URI($adminConfig['uploadPath']).$adminConfig['pageThumbnail']['path'].$pageContent['thumbnail'] : '#';

      // -> show THUMBNAIL if the page has one
      $displayThumbnailContainer = ' display:none;';
      if(!$newPage && $categoryConfig[$pageContent['category']]['thumbnails'] && !empty($pageContent['thumbnail'])) {

        $displayThumbnailContainer = '';
      }

      // thumb width
      $thumbnailWidth = @getimagesize(DOCUMENTROOT.$adminConfig['uploadPath'].$adminConfig['pageThumbnail']['path'].$pageContent['thumbnail']);
      $thumbnailWidth = $thumbnailWidth[0];

      if($thumbnailWidth >= 200)
        $thumbnailWidthStyle = ' style="width:200px;"';


      // generates a random number to put on the end of the image, to prevent caching
      // $randomImage = '?'.md5(uniqid(rand(),1));

      // thumbnailPreviewContainer
      echo '<div id="thumbnailPreviewContainer" style="z-index:5; position:relative; margin-bottom: 10px; float:right; line-height:28px; text-align:center;'.$displayThumbnailContainer.'">';
      echo $langFile['THUMBNAIL_TEXT_NAME'].'<br>';

        echo '<div>';
        // see if the thumbnails are activated, add upload/delete buttons
        if($categoryConfig[$pageContent['category']]['thumbnails']) {
          echo '<a href="?site=deletePageThumbnail&amp;category='.$_GET['category'].'&amp;page='.$_GET['page'].'" onclick="openWindowBox(\'library/views/windowBox/deletePageThumbnail.php?site='.$_GET['site'].'&amp;category='.$_GET['category'].'&amp;page='.$_GET['page'].'\',\''.$langFile['BUTTON_THUMBNAIL_DELETE'].'\');return false;" title="'.$langFile['BUTTON_TOOLTIP_THUMBNAIL_DELETE'].'::"" class="deleteButton toolTip"></a>';
          echo '<a href="?site=uploadPageThumbnail&amp;category='.$_GET['category'].'&amp;page='.$_GET['page'].'" onclick="openWindowBox(\'library/views/windowBox/uploadPageThumbnail.php?site='.$_GET['site'].'&amp;category='.$_GET['category'].'&amp;page='.$_GET['page'].'\',\''.$langFile['BUTTON_THUMBNAIL_UPLOAD'].'\');return false;" class="image">';
          echo '<img src="'.$thumbnailPath.'" id="thumbnailPreviewImage" class="thumbnail"'.$thumbnailWidthStyle.' data-width="'.$thumbnailWidth.'" alt="thumbnail">';
          echo '</a>';
        // if not only show the thumbnailPreviewImage
        } else
          echo '<img src="'.$thumbnailPath.'" id="thumbnailPreviewImage" class="thumbnail"'.$thumbnailWidthStyle.' data-width="'.$thumbnailWidth.'" alt="thumbnail">';

        echo '</div>';
      echo '</div>';

      // -> show the thumbnail upload button if there is no thumbnail yet
      $displayThumbnailUploadButton = (!$newPage && $categoryConfig[$pageContent['category']]['thumbnails'] && empty($pageContent['thumbnail']))
         ? '' : ' style="display:none;"';

      // thumbnailUploadButtonInPreviewArea
      echo '<a href="?site=uploadPageThumbnail&amp;category='.$_GET['category'].'&amp;page='.$_GET['page'].'" id="thumbnailUploadButtonInPreviewArea" onclick="openWindowBox(\'library/views/windowBox/uploadPageThumbnail.php?site='.$_GET['site'].'&amp;category='.$_GET['category'].'&amp;page='.$_GET['page'].'\',\''.$langFile['BUTTON_THUMBNAIL_UPLOAD'].'\');return false;" title="'.$langFile['BUTTON_TOOLTIP_THUMBNAIL_UPLOAD'].'::" class="uploadPageThumbnail toolTip"'.$displayThumbnailUploadButton.'></a>';


      ?>
      </div>
    </div>
  </div>

  <input type="submit" value="" id="HTMLEditorSubmit" class="button submit center" title="<?php echo $langFile['FORM_BUTTON_SUBMIT']; ?>">
  <br><br>
</div>