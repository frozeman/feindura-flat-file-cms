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
 * uploadPageThumbnail.php
 *
 * @version 1.04
 */

/**
 * Includes the login.include.php and backend.include.php and filter the basic data
 */
require_once(dirname(__FILE__)."/../../includes/secure.include.php");

echo ' '; // hack for safari, otherwise it throws an error that he could not find htmlentities like &ouml;

// vars
$error = false;
$response = false;
$site = $_GET['site'];
$page = $_GET['page'];
$category = $_GET['category'];

// ->> CHECK if the upload folder exists and is writeable
if($warning = isWritableWarning(dirname(__FILE__).'/../../../upload/'))
  die('<h2>'.$warning.'</h2>');

$pageContent = GeneralFunctions::readPage($page,$category);

$categoryRatio = false;
$thumbRatioX = false;
$thumbRatioY = false;
$thumbRatio = false;

// GET THUMBNAIL SIZE
// --------------------------
// THUMB WIDTH
if(!empty($categoryConfig[$category]['thumbWidth'])) {
  $thumbWidth = $categoryConfig[$category]['thumbWidth'];
  $categoryRatio = true;
} else
  $thumbWidth = $adminConfig['pageThumbnail']['width'];
// THUMB HEIGHT
if(!empty($categoryConfig[$category]['thumbHeight'])) {
  $thumbHeight = $categoryConfig[$category]['thumbHeight'];
  $categoryRatio = true;
} else
  $thumbHeight = $adminConfig['pageThumbnail']['height'];

// THUMB RATIO X
if($categoryRatio) {
  if($categoryConfig[$category]['thumbRatio'] == 'y' ||
     $categoryConfig[$category]['thumbRatio'] == '') {
    //$thumbRatioX = ' disabled="disabled"';
    $thumbRatioX = true;
  }
} else {
  if($adminConfig['pageThumbnail']['ratio'] == 'y' ||
     $adminConfig['pageThumbnail']['ratio'] == '') {
    //$thumbRatioX = ' disabled="disabled"';
    $thumbRatioX = true;
  }
}

// THUMB RATIO Y
if($categoryRatio) {
  if($categoryConfig[$category]['thumbRatio'] == 'x' ||
     $categoryConfig[$category]['thumbRatio'] == '') {
    //$thumbRatioY = ' disabled="disabled"';
    $thumbRatioY = true;
  }
} else {
  if($adminConfig['pageThumbnail']['ratio'] == 'x' ||
     $adminConfig['pageThumbnail']['ratio'] == '') {
    //$thumbRatioY = ' disabled="disabled"';
    $thumbRatioY = true;
  }
}

// SET RATIO
if($categoryRatio)
  $thumbRatio = $categoryConfig[$category]['thumbRatio'];
else
  $thumbRatio = $adminConfig['pageThumbnail']['ratio'];

?>
<form action="library/controllers/thumbnailUpload.controller.php" id="uploadPageThumbnailForm" enctype="multipart/form-data" method="post" onsubmit="startUploadAnimation();" target="uploadTargetFrame" accept-charset="UTF-8">
  <div>
    <input type="hidden" name="upload" value="true">
    <input type="hidden" name="category" value="<?php echo $category; ?>">
    <input type="hidden" name="id" value="<?php echo $page; ?>">
    <input type="hidden" name="thumbRatio" value="<?php echo $thumbRatio; ?>">
  </div>


  <h2><?php echo $langFile['pagethumbnail_h1_part1'].' &quot;<span style="color:#000000;">'.strip_tags(GeneralFunctions::getLocalized($pageContent,'title')).'</span>&quot; '.$langFile['pagethumbnail_h1_part2']; ?></h2>

  <div class="row">
    <div class="span4">

      <!-- file selection -->
      <h3 style="margin-bottom: -20px;"><?php echo $langFile['pagethumbnail_field1']; ?></h3>

      <input type="file" name="thumbFile" class="btn" style="width: 220px;">
      <input type="submit" value="" class="button thumbnailUpload toolTipTop" title="<?php echo $langFile['pagethumbnail_submit_tip']; ?>">

    </div>
    <div class="span4">
      <div class="well">
        <ul>
          <li><?php echo $langFile['pagethumbnail_thumbinfo_formats']; ?><br><strong>JPG</strong>, <strong>JPEG</strong>, <strong>GIF</strong>, <strong>PNG</strong></li>
          <li><?php echo $langFile['pagethumbnail_thumbinfo_filesize'].' <strong>'.ini_get('upload_max_filesize').'B</strong>'; ?></li>
          <li><strong><?php echo $langFile['pagethumbnail_thumbinfo_standardthumbsize']; ?></strong><br>
          <?php

            if($thumbRatioY) echo $langFile['pagethumbnail_thumbsize_width'].' = <strong>'.$thumbWidth.'</strong> '.$langFile['THUMBNAIL_TEXT_UNIT'].'<br>';
            if($thumbRatioX) echo $langFile['pagethumbnail_thumbsize_height'].' = <strong>'.$thumbHeight.'</strong> '.$langFile['THUMBNAIL_TEXT_UNIT'];
          ?>
          </li>
        </ul>
      </div>
    </div>
  </div>

  <?php if($thumbRatioY || $thumbRatioX) { ?>
  <div style="position:relative; top: -45px;">
    <a href="#" id="thumbSizeToogle" class="btn"><?php echo $langFile['pagethumbnail_thumbsize_h1']; ?> <span class="caret" onclick="return false;"></span></a>
  </div>
  <div style="margin-top: -35px;">
    <div id="thumbnailSizeBox" class="insetBlock">
      <?php
      // -> THUMB-WIDTH
      if($thumbRatioY) {
      ?>
        <div class="row">
          <div class="span1">
            <label for="windowBox_thumbWidth">
            <?php echo $langFile['pagethumbnail_thumbsize_width'] ?></label>
          </div>
          <div class="span1">
            <input type="number" id="windowBox_thumbWidth" name="thumbWidth" value="<?php echo $thumbWidth; ?>"<?php echo $thumbRatioX; ?>>
            <?php echo $langFile['pagethumbnail_thumbsize_unit']; ?>
          </div>
          <!-- shows the width in a scale -->
          <?php
          if($thumbWidth)
            $styleThumbWidth = 'width:'.$thumbWidth.'px';
          else
            $styleThumbWidth = 'width:0px';
          ?>
          <div class="span5">
            <div id="windowBox_thumbWidthScale" class="thumbnailScale" style="top:8px; <?php echo $styleThumbWidth; ?>"><div></div></div>
          </div>
        </div>


      <?php
      }
      // -> THUMB-HEIGHT
      if($thumbRatioX) {
      ?>
        <div class="row">
          <div class="span1">
            <label for="windowBox_thumbHeight">
            <?php echo $langFile['pagethumbnail_thumbsize_height'] ?></label>
          </div>
          <div class="span1">
            <input type="number" id="windowBox_thumbHeight" name="thumbHeight" value="<?php echo $thumbHeight; ?>"<?php echo $thumbRatioY; ?>>
            <?php echo $langFile['pagethumbnail_thumbsize_unit']; ?>
          </div>
          <!-- shows the height in a scale -->
          <?php
          if($thumbHeight)
            $styleThumbHeight = 'width:'.$thumbHeight.'px';
          else
            $styleThumbHeight = 'width:0px';
          ?>
          <div class="span5">
            <div id="windowBox_thumbHeightScale" class="thumbnailScale" style="top:8px; <?php echo $styleThumbHeight; ?>"><div></div></div>
          </div>
        </div>
      <?php
      }
      ?>
    </div>
  </div>
  <?php } ?>
</form>


<!-- ok button, after upload -->
<?php

// CREATE REDIRECT
$redirect = (empty($site))
  ? '?category='.$category.'&page='.$page.'&status=reload'.rand(1,99).'#pageInformation'
  : '?site='.$site.'&category='.$category;

if($site == 'pages')
  $redirect .= '&status=reload'.rand(1,99).'#categoryAnchor'.$category;

// when in the editor, clear the redirect
else
  $redirect = '';


?>
<div class="center">
  <a href="index.php<?php echo $redirect; ?>" onclick="closeWindowBox(<?php echo $redirect; ?>);return false;" id="pageThumbnailOkButton" class="ok button"></a>
</div>

<!-- UPLOAD IFRAME -->
<iframe id="uploadTargetFrame" name="uploadTargetFrame" src="library/controllers/thumbnailUpload.controller.php"></iframe>


<!-- show a PREVIEW of the current THUMBNAIL -->
<?php
// show thumbnail if the page has one
if(!empty($pageContent['thumbnail'])) {

  $thumbnailWidth = @getimagesize(dirname(__FILE__).'/../../../upload/thumbnails/'.$pageContent['thumbnail']);

  if($thumbnailWidth[0] <= 700)
    $thumbnailWidth = ' style="width: '.$thumbnailWidth[0].'px;"';
  else
    $thumbnailWidth = ' style="width: 700px;"';

  // generates a random number to put on the end of the image, to prevent caching
  $randomImage = '?'.md5(uniqid(rand(),1));

  echo '<div class="center" id="windowBoxThumbnailPreview">';
    echo '<img src="'.GeneralFunctions::Path2URI(dirname(__FILE__).'/../../../upload/thumbnails/').$pageContent['thumbnail'].$randomImage.'" class="thumbnail toolTipLeft"'.$thumbnailWidth.' alt="thumbnail" title="::'.dirname(__FILE__).'/../../../upload/thumbnails/'.$pageContent['thumbnail'].'::">';
  echo '</div>';
}

?>
<!-- UPDATE THE IMAGE -->
<script type="text/javascript">
/* <![CDATA[ */
  function refreshThumbnailImage(newImage) {
    if($('thumbnailPreviewImage') != null) {
      $$('img.thumbnail').setProperty('src','<?php echo GeneralFunctions::Path2URI(dirname(__FILE__).'/../../../upload/thumbnails/'); ?>'+newImage);
    }

    if($('thumbnailUploadButtonInPreviewArea') != null)
      $('thumbnailUploadButtonInPreviewArea').setStyle('display','none');
    if($('thumbnailPreviewContainer') != null)
      $('thumbnailPreviewContainer').setStyle('display','inline-block');
  }
/* ]]> */
</script>