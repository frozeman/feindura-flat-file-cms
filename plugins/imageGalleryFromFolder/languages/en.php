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

$pluginLangFile['feinduraPlugin_title']        = 'Image Gallery from folder';
$pluginLangFile['feinduraPlugin_description']  = 'Lists images from a folder. A thumbnail will be created automatically for every image. When you click on a image, it will be shown in full size in a <a href="http://reghellin.com/milkbox/">lightbox</a>.';

/* CONFIG ************************************************************************************ */

$pluginLangFile['galleryPath']         = 'path to the gallery';
$pluginLangFile['galleryPath_tip']     = 'absolut path of the folder, which contains the images::e.g &quot;/upload/Imagegallery1&quot;';
$pluginLangFile['galleryTitle']        = 'title of the gallery';
$pluginLangFile['previewImage']        = 'filename of the gallery preview picture';
$pluginLangFile['imageWidthNumber']          = 'image width';
$pluginLangFile['imageWidthNumber_tip']      = 'in pixel';
$pluginLangFile['imageHeightNumber']         = 'image height';
$pluginLangFile['imageHeightNumber_tip']     = 'in pixel';
$pluginLangFile['thumbnailWidthNumber']      = 'thumbnail width';
$pluginLangFile['thumbnailWidthNumber_tip']  = 'in pixel';
$pluginLangFile['thumbnailHeightNumber']     = 'thumbnail height';
$pluginLangFile['thumbnailHeightNumber_tip'] = 'in pixel';
$pluginLangFile['filenameCaptions']    = 'filename as caption';
$pluginLangFile['filenameCaptions_tip'] = 'Uses the filename (without extension) as caption, if no line in a captions.txt exist for this file.';
$pluginLangFile['tagSelection']                 = 'HTML-Tag';
$pluginLangFile['tagSelection_tip']             = 'The HTML-Tag which will be used to list the pictures::The Following HTML-Tags are allowed: &quot;table&quot;, &quot;ul&quot; oder nothing.';
$pluginLangFile['breakAfterNumber']          = 'break after';
$pluginLangFile['breakAfterNumber_tip']      = 'Does only work if the list HTML-Tag is &quot;table&quot;:: Tells after how many images a new row starts.';


// -----------------------------------------------------------------------------------------------
// RETURN ****************************************************************************************
// -----------------------------------------------------------------------------------------------
return $pluginLangFile;

?>