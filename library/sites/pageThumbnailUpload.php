<?php
/*
    feindura - Flat File Content Management System
    Copyright (C) 2009 Fabian Vogelsteller [frozeman.de]

    This program is free software;
    you can redistribute it and/or modify it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 3 of the License, or (at your option) any later version.

    This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY;
    without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
    See the GNU General Public License for more details.

    You should have received a copy of the GNU General Public License along with this program;
    if not,see <http://www.gnu.org/licenses/>.
*/
// pageThumbnailUpload.php version 1.01

$error = false;
$response = false;
$site = $_GET['site'];
$page = $_GET['page'];
$category = $_GET['category'];

include(dirname(__FILE__)."/../backend.include.php");

$pageContent = readPage($page,$category);

?>

<h1><?php echo $langFile['pagethumbnail_h1_part1'].' &quot;<span style="color:#000000;">'.$pageContent['title'].'</span>&quot; '.$langFile['pagethumbnail_h1_part2']; ?></h1>

<div id="thumbInfo">
<ul>
  <li><?php echo $langFile['pagethumbnail_thumbinfo_formats']; ?></li>
  <li><?php echo $langFile['pagethumbnail_thumbinfo_filesize'].' <b>'.ini_get('upload_max_filesize').'B</b>'; ?></li>
  <li><b><?php echo $langFile['pagethumbnail_thumbinfo_standardthumbsize']; ?></b><br />
  <?php echo $langFile['pagethumbnail_thumbsize_width'].' = <b>'.$adminConfig['pageThumbnail']['width'].'</b> '.$langFile['thumbSize_unit'].'<br />
            '.$langFile['pagethumbnail_thumbsize_height'].' = <b>'.$adminConfig['pageThumbnail']['height'].'</b> '.$langFile['thumbSize_unit']; ?>
  </li>
</ul>
</div>

<div style="position: relative">
<!-- <form action="?site=pageThumbnail&amp;category=<?php echo $category; ?>&amp;id=<?php echo $page; ?>" id="pageThumbnailUploadForm" enctype="multipart/form-data" method="post" onsubmit="requestSite('<?php echo $_SERVER['PHP_SELF']; ?>','','pageThumbnailUploadForm');return false;"> -->
<form action="library/sites/pageThumbnail/upload.php" id="pageThumbnailUploadForm" enctype="multipart/form-data" method="post" onsubmit="startUploadAnimation();" target="uploadTargetFrame">
	<input type="hidden" name="upload" value="true" />
	<input type="hidden" name="category" value="<?php echo $category; ?>" />
  <input type="hidden" name="id" value="<?php echo $page; ?>" />

	<!-- file selection -->
  <h2><?php echo $langFile['pagethumbnail_feld1']; ?></h2>
  
	<input type="file" name="thumbFile" style="z-index:10;"/>
  <br />	
	<br />
  
	<a href="#" id="thumbSizeToogle" class="down"><?php echo $langFile['pagethumbnail_thumbsize_h1']; ?></a><br />
	<br clear="all"/>
	
  <table id="thumbSize">  
  <tr><td style="width: 80px">
  <label for="windowBox_thumbWidth"><span class="toolTip" title="<?php echo $langFile['pagethumbnail_thumbsize_width'].'::'.$langFile['adminSetup_thumbnailSettings_feld1_tip'] ?>">
  <?php echo $langFile['pagethumbnail_thumbsize_width'] ?></span></label>
  </td><td>
  <input id="windowBox_thumbWidth" name="thumbWidth" class="short" value="<?php if(!empty($categories['id_'.$category]['thumbWidth'])) echo $categories['id_'.$category]['thumbWidth']; else echo $adminConfig['pageThumbnail']['width']; ?>" />
  <?php echo $langFile['pagethumbnail_thumbsize_unit']; ?>
  </td></tr>
  
  <!-- shows the width in a scale -->
  <?php
  if(!empty($categories['id_'.$category]['thumbWidth']))
    $styleThumbWidth = 'width:'.$categories['id_'.$category]['thumbWidth'].'px';
  elseif(!empty($adminConfig['pageThumbnail']['width']))
    $styleThumbWidth = 'width:'.$adminConfig['pageThumbnail']['width'].'px';
  else
    $styleThumbWidth = 'width:0px';
  ?>
  <tr><td>
  </td><td style="height:40px;">
  <div id="windowBox_thumbWidthScale" class="scale" style="<?php echo $styleThumbWidth; ?>"><div></div></div>
  </td></tr>
  
  <tr><td>
  <label for="windowBox_thumbHeight"><span class="toolTip" title="<?php echo $langFile['pagethumbnail_thumbsize_height'].'::'.$langFile['adminSetup_thumbnailSettings_feld2_tip'] ?>">
  <?php echo $langFile['pagethumbnail_thumbsize_height'] ?></span></label>
  </td><td>
  <input id="windowBox_thumbHeight" name="thumbHeight" class="short" value="<?php if(!empty($categories['id_'.$category]['thumbHeight'])) echo $categories['id_'.$category]['thumbHeight']; else echo $adminConfig['pageThumbnail']['height']; ?>" />
  <?php echo $langFile['pagethumbnail_thumbsize_unit']; ?>
  </td></tr>
  
  <!-- shows the height in a scale -->
  <?php
  if(!empty($categories['id_'.$category]['thumbHeight']))
    $styleThumbHeight = 'width:'.$categories['id_'.$category]['thumbHeight'].'px';
  elseif(!empty($adminConfig['pageThumbnail']['height']))
    $styleThumbHeight = 'width:'.$adminConfig['pageThumbnail']['height'].'px';
  else
    $styleThumbHeight = 'width:0px';
  ?>
  <tr><td>
  </td><td style="height:40px;">
  <div id="windowBox_thumbHeightScale" class="scale" style="<?php echo $styleThumbHeight; ?>"><div></div></div>
  </td></tr>  
  </table>
  
  <!-- show a PREVIEW of the current THUMBNAIL -->
  <?php 
  // show thumbnail if the page has one
  if(!empty($pageContent['thumbnail'])) {
    
    $thumbnailWidth = getimagesize(DOCUMENTROOT.$adminConfig['uploadPath'].$adminConfig['pageThumbnail']['path'].$pageContent['thumbnail']);
    $thumbnailWidth = $thumbnailWidth[0];
    
    if($thumbnailWidth <= 200)
      $thumbnailWidth = ' width="'.$thumbnailWidth.'"';
    else
      $thumbnailWidth = ' width="200"';
    
    echo '<div style="z-index:0; position:relative; margin-bottom: 10px; float:right;">';
    echo '<img src="'.$adminConfig['uploadPath'].$adminConfig['pageThumbnail']['path'].$pageContent['thumbnail'].'" class="thumbnailPreview toolTip"'.$thumbnailWidth.' alt="thumbnail" title="'.$adminConfig['uploadPath'].$adminConfig['pageThumbnail']['path'].$pageContent['thumbnail'].'::'.$langFile['thumbnail_tip'].'" />';
    echo '</div>';
  }
  ?> 
  
	<input type="submit" value="" class="toolTip button thumbnailUpload" title="<?php echo $langFile['pagethumbnail_submit_tip']; ?>" />
</form>
</div>

<!-- ok button, after upload -->
<a href="?category=<?php echo $category; ?>&amp;page=<?php echo $page; ?>" onclick="closeWindowBox('index.php?site=<?php echo $site; ?>&amp;category=<?php echo $category; ?>&amp;page=<?php echo $page; ?>');return false;" id="pageThumbnailOkButton" class="ok center">&nbsp;</a>

<!-- UPLOAD IFRAME -->
<iframe id="uploadTargetFrame" name="uploadTargetFrame" src="library/sites/pageThumbnail/upload.php"></iframe>