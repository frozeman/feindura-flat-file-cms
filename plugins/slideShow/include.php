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
 * The plugin include file
 * 
 * See the README.md for more.
 * 
 * The following variables are available in this script when it gets included by the {@link Feindura::showPlugins()} method:
 *     - $this          -> the current {@link Feindura} class instance with all its methods (use "$this->..")
 *     - $pluginConfig  -> contains the changed settings from the "config.php" from this plugin
 *     - $pluginName    -> the folder name of this plugin
 *     - $pageContent   -> the pageContent array of the page which has this plugin activated 
 * 
 * This file MUST RETURN the plugin ready to display in a HTML-page, like:
 * <code>
 * <?php
 * // Add the stylesheet files of this plugin to the current page
 * echo $this->addPluginStylesheets(dirname(__FILE__));
 * 
 * $plugin = '<p>Plugin HTML</p>';
 * 
 * return $plugin;
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

// Add the stylesheet files of this plugin to the current page
echo $this->addPluginStylesheets(dirname(__FILE__));

// vars
$plugin = '';
$filePath = str_replace('\\','/',dirname(__FILE__)); // replace this on windows servers
$filePath = str_replace(DOCUMENTROOT,'',$filePath);
$uniqueId = rand(0,999);

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
    document.write(unescape(\'<script src="'.$this->adminConfig['basePath'].'library/thirdparty/javascripts/mootools-core-1.4.5.js"><\/script>\'));
    document.write(unescape(\'<script src="'.$this->adminConfig['basePath'].'library/thirdparty/javascripts/mootools-more-1.4.0.1.js"><\/script>\'));
  }
  // add NivooSlider
  (window.NivooSlider || document.write(unescape(\'<script src="'.$filePath.'/NivooSlider/NivooSlider.min.js"><\/script>\'))); 
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
$slideShow = new slideShow($jsonImages,$this->adminConfig['uploadPath'],DOCUMENTROOT);

// set configs
$slideShow->xHtml = $this->xHtml; // set the xHtml property rom the feindura class
if(!empty($pluginConfig['widthNumber'])) {
  $slideShow->imageWidth = $pluginConfig['widthNumber'];
  $slideShow->width = $pluginConfig['widthNumber'];
}
if(!empty($pluginConfig['heightNumber']))
  $slideShow->height = $pluginConfig['heightNumber'];
//   $slideShow->imageHeight = $pluginConfig['heightNumber'];
// wont resize the height, to let the picture fit in the slideshow
$slideShow->imageHeight = false;

$plugin .= $slideShow->show('slideShow'.$uniqueId);

// RETURN the plugin
// *****************
return $plugin;

?>