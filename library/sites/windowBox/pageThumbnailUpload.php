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
*/
// pageThumbnailUpload.php version 1.04

$error = false;
$response = false;
$site = $_GET['site'];
$page = $_GET['page'];
$category = $_GET['category'];

include(dirname(__FILE__)."/../../includes/backend.include.php");

echo ' '; // hack for safari, otherwise it throws an error that he could not find htmlentities like &ouml;

$pageContent = $generalFunctions->readPage($page,$category);

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
    $thumbRatio = 'y';
  }
} else {
  if($adminConfig['pageThumbnail']['ratio'] == 'y' ||
     $adminConfig['pageThumbnail']['ratio'] == '') {
    //$thumbRatioX = ' disabled="disabled"';
    $thumbRatioX = true;
    $thumbRatio = 'y';
  }
}

// THUMB RATIO Y
if($categoryRatio) {
  if($categoryConfig[$category]['thumbRatio'] == 'x' ||
     $categoryConfig[$category]['thumbRatio'] == '') {
    //$thumbRatioY = ' disabled="disabled"';
    $thumbRatioY = true;
    $thumbRatio = 'x';
  }
} else {
  if($adminConfig['pageThumbnail']['ratio'] == 'x' ||
     $adminConfig['pageThumbnail']['ratio'] == '') {
    //$thumbRatioY = ' disabled="disabled"';
    $thumbRatioY = true;
    $thumbRatio = 'x';
  }
}

?>
<h1><?php echo $langFile['pagethumbnail_h1_part1'].' &quot;<span style="color:#000000;">'.$pageContent['title'].'</span>&quot; '.$langFile['pagethumbnail_h1_part2']; ?></h1>

<div id="thumbInfo">
<ul>
  <li><?php echo $langFile['pagethumbnail_thumbinfo_formats']; ?><br /><b>JPG</b>, <b>JPEG</b>, <b>GIF</b>, <b>PNG</b></li>
  <li><?php echo $langFile['pagethumbnail_thumbinfo_filesize'].' <b>'.ini_get('upload_max_filesize').'B</b>'; ?></li>
  <li><b><?php echo $langFile['pagethumbnail_thumbinfo_standardthumbsize']; ?></b><br />
  <?php 
  
    if($thumbRatioY) echo $langFile['pagethumbnail_thumbsize_width'].' = <b>'.$thumbWidth.'</b> '.$langFile['thumbSize_unit'].'<br />';
    if($thumbRatioX) echo $langFile['pagethumbnail_thumbsize_height'].' = <b>'.$thumbHeight.'</b> '.$langFile['thumbSize_unit'];
  ?>
  </li>
</ul>
</div>

<div style="position: relative">
<!-- <form action="?site=pageThumbnail&amp;category=<?php echo $category; ?>&amp;id=<?php echo $page; ?>" id="pageThumbnailUploadForm" enctype="multipart/form-data" method="post" onsubmit="requestSite('<?php echo $_SERVER['PHP_SELF']; ?>','','pageThumbnailUploadForm');return false;" accept-charset="UTF-8"> -->
<form action="library/processes/thumbnailUpload.process.php" id="pageThumbnailUploadForm" enctype="multipart/form-data" method="post" onsubmit="startUploadAnimation();" target="uploadTargetFrame" accept-charset="UTF-8">
	<input type="hidden" name="upload" value="true" />
	<input type="hidden" name="category" value="<?php echo $category; ?>" />
  <input type="hidden" name="id" value="<?php echo $page; ?>" />
  <input type="hidden" name="thumbRatio" value="<?php echo $thumbRatio; ?>" />

	<!-- file selection -->
  <h2><?php echo $langFile['pagethumbnail_field1']; ?></h2>
  
	<input type="file" name="thumbFile" style="z-index:10;"/>
  <br />	
	<br />
  
	<a href="#" id="thumbSizeToogle" class="down"><?php echo $langFile['pagethumbnail_thumbsize_h1']; ?></a><br />
	<br clear="all"/>
	
  <table id="thumbSize">  
  <?php
  // -> THUMB-WIDTH
  if($thumbRatioY) {
  ?>
  <tr><td style="width: 80px">
  <label for="windowBox_thumbWidth">
  <?php echo $langFile['pagethumbnail_thumbsize_width'] ?></label>
  </td><td>
  <input id="windowBox_thumbWidth" name="thumbWidth" class="short" value="<?php echo $thumbWidth; ?>"<?php echo $thumbRatioX; ?> />
  <?php echo $langFile['pagethumbnail_thumbsize_unit']; ?>
  </td></tr>
  
  <!-- shows the width in a scale -->
  <?php
  if($thumbWidth)
    $styleThumbWidth = 'width:'.$thumbWidth.'px';
  else
    $styleThumbWidth = 'width:0px';
  ?>
  <tr><td>
  </td><td style="height:40px;">
  <div id="windowBox_thumbWidthScale" class="scale" style="<?php echo $styleThumbWidth; ?>"><div></div></div>
  </td></tr>
  <?php
  }
  // -> THUMB-HEIGHT
  if($thumbRatioX) {
  ?>  
  <tr><td style="width: 80px">
  <label for="windowBox_thumbHeight">
  <?php echo $langFile['pagethumbnail_thumbsize_height'] ?></label>
  </td><td>
  <input id="windowBox_thumbHeight" name="thumbHeight" class="short" value="<?php echo $thumbHeight; ?>"<?php echo $thumbRatioY; ?> />
  <?php echo $langFile['pagethumbnail_thumbsize_unit']; ?>
  </td></tr>
  
  <!-- shows the height in a scale -->
  <?php
  if($thumbHeight)
    $styleThumbHeight = 'width:'.$thumbHeight.'px';
  else
    $styleThumbHeight = 'width:0px';
  ?>
  <tr><td>
  </td><td style="height:40px;">
  <div id="windowBox_thumbHeightScale" class="scale" style="<?php echo $styleThumbHeight; ?>"><div></div></div>
  </td></tr>
  <?php
  }
  ?>
  </table>
  
  <!-- show a PREVIEW of the current THUMBNAIL -->
  <?php 
  // show thumbnail if the page has one
  if(!empty($pageContent['thumbnail'])) {
    
    $thumbnailWidth = @getimagesize(DOCUMENTROOT.$adminConfig['uploadPath'].$adminConfig['pageThumbnail']['path'].$pageContent['thumbnail']);
    
    if($thumbnailWidth[0] <= 250)
      $thumbnailWidth = ' width="'.$thumbnailWidth[0].'"';
    else
      $thumbnailWidth = ' width="250"';
    
    echo '<div style="z-index:0; position:relative; width: 280px; margin-bottom: 10px; float:right; text-align: center;">';
    echo '<img src="'.$adminConfig['uploadPath'].$adminConfig['pageThumbnail']['path'].$pageContent['thumbnail'].'" class="thumbnailPreview toolTip"'.$thumbnailWidth.' alt="thumbnail" title="'.$adminConfig['uploadPath'].$adminConfig['pageThumbnail']['path'].$pageContent['thumbnail'].'::'.$langFile['thumbnail_tip'].'" />';
    echo '</div>';
  }
  ?>
	<input type="submit" value="" class="button thumbnailUpload" title="<?php echo $langFile['pagethumbnail_submit_tip']; ?>" />
</form>
</div>

<!-- ok button, after upload -->
<a href="?category=<?= $category; ?>&amp;page=<?= $page; ?>" onclick="closeWindowBox('index.php?site=<?= $site; ?>&amp;category=<?= $category; ?>&amp;page=<?= $page; ?>');return false;" id="pageThumbnailOkButton" class="ok center">&nbsp;</a>

<!-- UPLOAD IFRAME -->
<iframe id="uploadTargetFrame" name="uploadTargetFrame" src="library/processes/thumbnailUpload.process.php"></iframe>