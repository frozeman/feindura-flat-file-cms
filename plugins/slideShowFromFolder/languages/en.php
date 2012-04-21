<?php
/**
 * ENGLISH (EN) plugin language file
 * 
 * NEEDS a RETURN $pluginLangFile; at the END
 * 
 * 
 * Every plugin language file has to have:
 *    - $pluginLangFile['feinduraPlugin_title']        = 'Exampletitle';
 *    - $pluginLangFile['feinduraPlugin_description']  = 'This is an example plugin dscription.';
 *  
 * If the array key has an "configname_tip" on the end it will be used as toolTip.
 * E.g.:
 * $pluginLangFile['exampleconfig_tip'] = 'Example config tooltip text';
 * 
 * @package [Plugins]
 * @subpackage slideShowFromFolder
 */

/* PLUGIN ************************************************************************************ */

$pluginLangFile['feinduraPlugin_title']        = 'Slide show from folder';
$pluginLangFile['feinduraPlugin_description']  = 'Creates a slide show from images in a folder. The images will be automatically resized to the given size. See <a href="http://www.johannes-fischer.de/labs/nivoo-slider/">Nivooslider</a>.';

/* CONFIG ************************************************************************************ */

$pluginLangFile['path']                  = 'path to the images';
$pluginLangFile['path_tip']              = 'absolut path of the folderr, which contains the images::e.g &quot;/upload/slideshow1&quot;';
$pluginLangFile['imageWidthNumber']      = 'image width';
$pluginLangFile['imageWidthNumber_tip']  = 'in pixel';
$pluginLangFile['imageHeightNumber']     = 'image height';
$pluginLangFile['imageHeightNumber_tip'] = 'in pixel';
$pluginLangFile['intervalNumber']         = 'Interval';
$pluginLangFile['intervalNumber_tip']     = 'in seconds';
$pluginLangFile['effectSelection']       = 'Effect';

// -----------------------------------------------------------------------------------------------
// RETURN ****************************************************************************************
// -----------------------------------------------------------------------------------------------
return $pluginLangFile;

?>