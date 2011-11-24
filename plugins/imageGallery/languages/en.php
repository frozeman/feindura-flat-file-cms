<?php
/**
 * ENGLISH (EN) language-file for the imageGallery plugin
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
$pluginLangFile['feinduraPlugin_description']  = 'Lists images from a folder. A thumbnail will be created automatically for every image. When you click on a image, it will be shown in full size in a <a href="http://reghellin.com/milkbox/">lightbox</a>.';

/* CONFIG ************************************************************************************ */

$pluginLangFile['galleryPath']         = 'path to the gallery';
$pluginLangFile['galleryPath_tip']     = 'absolut path of the folder, which contains the images::e.g &quot;/upload/Imagegallery1&quot;';
$pluginLangFile['galleryTitle']        = 'title of the gallery';
$pluginLangFile['previewImage']        = 'filename of the gallery preview picture';
$pluginLangFile['imageWidth']          = 'image width';
$pluginLangFile['imageWidth_tip']      = 'in pixel';
$pluginLangFile['imageHeight']         = 'image height';
$pluginLangFile['imageHeight_tip']     = 'in pixel';
$pluginLangFile['thumbnailWidth']      = 'thumbnail width';
$pluginLangFile['thumbnailWidth_tip']  = 'in pixel';
$pluginLangFile['thumbnailHeight']     = 'thumbnail height';
$pluginLangFile['thumbnailHeight_tip'] = 'in pixel';
$pluginLangFile['tag']                 = 'list HTML-Tag';
$pluginLangFile['tag_tip']             = 'The HTML-Tag which will be used to list the pictures::The Following HTML-Tags are allowed: &quot;table&quot;, &quot;ul&quot; oder nothing.';
$pluginLangFile['breakAfter']          = 'break after';
$pluginLangFile['breakAfter_tip']      = 'Does only work if the list HTML-Tag is &quot;table&quot;:: Tells after how many images a new row starts.';


// -----------------------------------------------------------------------------------------------
// RETURN ****************************************************************************************
// -----------------------------------------------------------------------------------------------
return $pluginLangFile;

?>