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
 * @subpackage imageGallery
 */

/* PLUGIN ************************************************************************************ */

$pluginLangFile['feinduraPlugin_title']        = 'Image Gallery';
$pluginLangFile['feinduraPlugin_description']  = 'Lists images as gallery. It automatically creates a thumbnail for every image. When you click on a image, it will be shown in full size in a <a href="http://reghellin.com/milkbox/" target="_blank">lightbox</a>.';

/* CONFIG ************************************************************************************ */

$pluginLangFile['selectImagesJsFunction']    = 'Select images';
$pluginLangFile['galleryTitle']              = 'title of the gallery';
$pluginLangFile['previewImage']              = 'filename of the gallery preview picture';
$pluginLangFile['imageWidthNumber']          = 'image width';
$pluginLangFile['imageWidthNumber_tip']      = 'in pixel';
$pluginLangFile['imageHeightNumber']         = 'image height';
$pluginLangFile['imageHeightNumber_tip']     = 'in pixel';
$pluginLangFile['thumbnailWidthNumber']      = 'thumbnail width';
$pluginLangFile['thumbnailWidthNumber_tip']  = 'in pixel';
$pluginLangFile['thumbnailHeightNumber']     = 'thumbnail height';
$pluginLangFile['thumbnailHeightNumber_tip'] = 'in pixel';
$pluginLangFile['filenameCaptions']          = 'filename as caption';
$pluginLangFile['filenameCaptions_tip']      = 'Uses the filename (without extension) as caption, if no captions was set.';
$pluginLangFile['tagSelection']              = 'HTML-Tag';
$pluginLangFile['tagSelection_tip']          = 'The HTML-Tag which will be used to create the gallery::';
$pluginLangFile['breakAfterNumber']          = 'break after';
$pluginLangFile['breakAfterNumber_tip']      = 'Does only work if the list HTML-Tag is &quot;table&quot;:: Tells after how many images a new row starts.';


// -----------------------------------------------------------------------------------------------
// RETURN ****************************************************************************************
// -----------------------------------------------------------------------------------------------
return $pluginLangFile;

?>