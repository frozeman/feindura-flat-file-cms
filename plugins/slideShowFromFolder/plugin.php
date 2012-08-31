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
 * @subpackage slideShowFromFolder
 *
 * @author Fabian Vogelsteller <fabian@feindura.org>
 * @copyright Fabian Vogelsteller
 * @license http://www.gnu.org/licenses GNU General Public License version 3
 *
 */


// vars
$uniqueId = uniqid();

if($pluginConfig['effectSelection'] == 'sliceLeftDown' ||
   $pluginConfig['effectSelection'] == 'sliceLeftUp' ||
   $pluginConfig['effectSelection'] == 'sliceLeftRightDown' ||
   $pluginConfig['effectSelection'] == 'sliceLeftRightUp' ||
   $pluginConfig['effectSelection'] == 'sliceRightDown' ||
   $pluginConfig['effectSelection'] == 'sliceRightUp' ||
   $pluginConfig['effectSelection'] == 'wipeDown' ||
   $pluginConfig['effectSelection'] == 'wipeUp')
  $effectsDirection = 'horizontal';
else
  $effectsDirection = 'vertical';

// set new sizes of the slider holder
$resizeWidthAfter = (!empty($pluginConfig['imageWidthNumber']))
  ? "$$('#slideShowFromFolder".$uniqueId." div.nivoo-slider-holder')[0].setStyle('width',".$pluginConfig['imageWidthNumber'].");"
  : '';
$resizeHeightAfter = (!empty($pluginConfig['imageHeightNumber']))
  ? "$$('#slideShowFromFolder".$uniqueId." div.nivoo-slider-holder')[0].setStyle('height',".$pluginConfig['imageHeightNumber'].");"
  : '';

// ->> add MooTools and NivooSlider
echo '<script type="text/javascript">
  /* <![CDATA[ */
  // add mootools if user is not logged into backend
  if(!window.MooTools) {
    document.write(unescape(\'<script src="'.$feinduraBaseURL.'library/thirdparty/javascripts/mootools-core-1.4.5.js"><\/script>\'));
    document.write(unescape(\'<script src="'.$feinduraBaseURL.'library/thirdparty/javascripts/mootools-more-1.4.0.1.js"><\/script>\'));
  }
  // add NivooSlider
  (window.NivooSlider || document.write(unescape(\'<script src="'.$pluginBaseURL.'NivooSlider/NivooSlider.min.js"><\/script>\')));
  /* ]]> */
</script>';

echo '<script type="text/javascript">
  /* <![CDATA[ */
  window.addEvent(\'domready\', function () {
    if(document.id(\'slideShowFromFolder'.$uniqueId.'\') != null) {

      // initialize Nivoo-Slider
      var slideShow = new NivooSlider(document.id(\'slideShowFromFolder'.$uniqueId.'\'), {
        effect: \''.$pluginConfig['effectSelection'].'\',
        interval: '.$pluginConfig['intervalNumber'].'000,
        orientation: \''.$effectsDirection.'\',
        directionNavHide: true
      });

      // set size for the div.nivoo-slider-holder
      // NivooSlider fixes:
      // line 346 in NivooSlider.js: this.containerSize = this.holder.getParent(\'.nivoo-slider\').getSize();
      // all background-image: url() are missing the "" in url(), fixed that
      '.$resizeWidthAfter.'
      '.$resizeHeightAfter.'
    }
  });
  /* ]]> */
</script>';

// load the slideShow class
require_once('slideShowFromFolder.php');

// create an instance of the slideShow class
$slideShow = new slideShowFromFolder($pluginConfig['path'],DOCUMENTROOT);

// set configs
$slideShow->xHtml = $feindura->xHtml; // set the xHtml property rom the feindura class
if(!empty($pluginConfig['imageWidthNumber'])) {
  $slideShow->imageWidth = $pluginConfig['imageWidthNumber'];
  $slideShow->width = $pluginConfig['imageWidthNumber'];
}
if(!empty($pluginConfig['imageHeightNumber']))
  $slideShow->height = $pluginConfig['imageHeightNumber'];
//   $slideShow->imageHeight = $pluginConfig['imageHeightNumber'];
// wont resize the height, to let the picture fit in the slideshow
$slideShow->imageHeight = false;

// SHOW SLIDESHOW
echo $slideShow->show('slideShowFromFolder'.$uniqueId,$pageContent);


?>