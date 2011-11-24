<?php
/**
 * FRENCH (FR) language-file for the imageGallery plugin
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

$pluginLangFile['feinduraPlugin_title']        = 'gal&eacute;rie des images';
$pluginLangFile['feinduraPlugin_description']  = 'Etablit une liste des images dapr&egrave;s un dossier dans la gal&eacute;rie.Chaque image dans le dossier sera affich&eacute;e par une miniature. En cliquant sur les images, elles <a href="http://reghellin.com/milkbox/">lightbox</a> seront affich&eacute;es.';

/* CONFIG ************************************************************************************ */

$pluginLangFile['galleryPath']         = 'trace de la gal&eacute;rie';
$pluginLangFile['galleryPath_tip']     = 'trace absolue du dossier contenant les images:par ex. &quot;/upload/gallery1&quot;';
$pluginLangFile['galleryTitle']        = 'titre de la gal&eacute;rie';
$pluginLangFile['previewImage']        = 'nom du fichier en miniature';
$pluginLangFile['imageWidth']          = 'largeur de limage';
$pluginLangFile['imageWidth_tip']      = 'en pixel';
$pluginLangFile['imageHeight']         = 'hauteur de limage';
$pluginLangFile['imageHeight_tip']     = 'en pixel';
$pluginLangFile['thumbnailWidth']      = 'largeur de limage en miniature';
$pluginLangFile['thumbnailWidth_tip']  = 'en pixel';
$pluginLangFile['thumbnailHeight']     = 'hauteur de limage en miniature';
$pluginLangFile['thumbnailHeight_tip'] = 'en pixel';
$pluginLangFile['tag']                 = 'liste des tags HTML';
$pluginLangFile['tag_tip']             = 'Le tag HTML pour la liste des images::le tags HTML suivants sont possible: &quot;table&quot;, &quot;ul&quot; o&ugrave; rien.';
$pluginLangFile['breakAfter']          = 'mise en page apr&egrave;s';
$pluginLangFile['breakAfter_tip']      = 'Sera seulement &eacute;ffectu&eacute; si la liste contient le tag HTML &quot;table&quot; :: Le nombre dimages indique la cr&eacute;ation dune nouvelle linie.';


// -----------------------------------------------------------------------------------------------
// RETURN ****************************************************************************************
// -----------------------------------------------------------------------------------------------
return $pluginLangFile;

?>