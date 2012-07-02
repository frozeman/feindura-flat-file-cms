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
 * The following variables are available in this script when it gets included by the {@link Feindura::showPlugins()} method:
 *     - $feindura                  -> the current {@link Feindura} class instance with all its methods (use "$feindura->..")
 *     - $feinduraBaseURL           -> the base url of the feindura folder, e.g. "http://mysite.com/cms/"
 *     - $feinduraBasePath          -> the base path of the feindura folder, e.g. "/cms/". Be aware that this is a file system path and could differ from an URI path.
 *     - $pluginBaseURL             -> the base url of this plugins folder, e.g. "http://mysite.com/cms/plugins/examplePlugin/"
 *     - $pluginBasePath            -> the base path of this plugins folder, e.g. "/cms/plugins/examplePlugin/". Be aware that this is a file system path and could differ from an URI path.
 *     - $pluginConfig              -> contains the changed settings from the "config.php" from this plugin
 *     - $pluginName                -> the folder name of this plugin
 *     - $pageContent               -> the pageContent array of the page which contains this plugin
 *     - the GeneralFunctions class -> for advanced methods. It's a static class so use "GeneralFunctions::exampleMethod(..);"
 *
 * Example plugin:
 * <code>
 * <?php
 * // Add the stylesheet files of this plugin to the current page
 * echo $feindura->addPluginStylesheets($pluginBasePath);
 *
 * echo '<p>Plugin HTML</p>';
 *
 * ?>
 * </code>
 *
 * @package [Plugins]
 * @subpackage slideShow
 *
 * @author Fabian Vogelsteller <fabian@feindura.org>
 * @copyright Fabian Vogelsteller
 * @license http://www.gnu.org/licenses GNU General Public License version 3
 *
 */

// Add the stylesheet files of this plugin to the current page (these CSS files can be anywhere in this plugin folder or subfolders)
echo $feindura->addPluginStylesheets($pluginBasePath);

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
$resizeWidthAfter = (!empty($pluginConfig['widthNumber']))
  ? "$$('#slideShow".$uniqueId." div.nivoo-slider-holder')[0].setStyle('width',".$pluginConfig['widthNumber'].");"
  : '';
$resizeHeightAfter = (!empty($pluginConfig['heightNumber']))
  ? "$$('#slideShow".$uniqueId." div.nivoo-slider-holder')[0].setStyle('height',".$pluginConfig['heightNumber'].");"
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

  window.addEvent(\'domready\', function() {
    if(document.id(\'slideShow'.$uniqueId.'\') != null) {

      // initialize Nivoo-Slider
      var slideShow = new NivooSlider(document.id(\'slideShow'.$uniqueId.'\'), {
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
require_once('slideShow.php');

// create an instance of the slideShow class
$jsonImages =  str_replace(array('&#34;','&#58;'), array('"',':'), $pluginConfig['imagesHidden']);
$slideShow = new slideShow($jsonImages,$feindura->adminConfig['uploadPath'],DOCUMENTROOT);

// set configs
$slideShow->xHtml = $feindura->xHtml; // set the xHtml property rom the feindura class
$slideShow->resetTimestamp = $pageContent['lastSaveDate'];
if(!empty($pluginConfig['widthNumber'])) {
  $slideShow->width = $pluginConfig['widthNumber'];
  $slideShow->imageWidth = $pluginConfig['widthNumber'];
}
if(!empty($pluginConfig['heightNumber'])) {
  $slideShow->height = $pluginConfig['heightNumber'];
  $slideShow->imageHeight = $pluginConfig['heightNumber'];
}

// SHOW SLIDESHOW
echo $slideShow->show('slideShow'.$uniqueId);


?>