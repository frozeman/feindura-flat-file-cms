<?php
/*
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
 */
/**
 * The plugin file
 *
 * See the README.md for more.
 *
 *
 * @package [Plugins]
 * @subpackage imageGalleryFromFolder
 *
 * @author Fabian Vogelsteller <fabian@feindura.org>
 * @copyright Fabian Vogelsteller
 * @license http://www.gnu.org/licenses GNU General Public License version 3
 *
 */


// ->> add MooTools and MilkBox
echo '<script type="text/javascript">
  /* <![CDATA[ */
  // add mootools if user is not logged into backend
  if(!window.MooTools) {
    document.write(unescape(\'<script src="'.$feinduraBaseURL.'library/thirdparty/javascripts/mootools-core-1.4.5.js"><\/script>\'));
    document.write(unescape(\'<script src="'.$feinduraBaseURL.'library/thirdparty/javascripts/mootools-more-1.4.0.1.js"><\/script>\'));
  }
  // add milkbox
  (window.MilkBox || document.write(unescape(\'<script src="'.$pluginBaseURL.'milkbox/milkbox.js"><\/script>\')));
  /* ]]> */
</script>';

// load the imageGalleryFromFolder class
require_once('imageGalleryFromFolder.php');

// create an instance of the imageGalleryFromFolder class
$gallery = new imageGalleryFromFolder($pluginConfig['galleryPath'],DOCUMENTROOT);

// set configs
$gallery->xHtml = $feindura->xHtml; // set the xHtml property rom the feindura class
$gallery->imageWidth = $pluginConfig['imageWidthNumber'];
$gallery->imageHeight = $pluginConfig['imageHeightNumber'];
$gallery->thumbnailWidth = $pluginConfig['thumbnailWidthNumber'];
$gallery->thumbnailHeight = $pluginConfig['thumbnailHeightNumber'];
$gallery->filenameCaptions = $pluginConfig['filenameCaptions'];
$gallery->emptyImage = $feinduraBaseURL.'library/images/icons/emptyImage.gif';

// SHOW IMAGE GALLERY
echo $gallery->showGallery($pluginConfig['tagSelection'],$pluginConfig['breakAfterNumber'],$pageContent);


?>