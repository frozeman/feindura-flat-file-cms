<?php
/**
 * FRENCH (FR) plugin language file
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

$pluginLangFile['feinduraPlugin_title']        = 'Galerie d\'images des dossiers';
$pluginLangFile['feinduraPlugin_description']  = 'Etablit une liste des images dapr&egrave;s un dossier dans la gal&eacute;rie.Chaque image dans le dossier sera affich&eacute;e par une miniature. En cliquant sur les images, elles <a href="http://reghellin.com/milkbox/">lightbox</a> seront affich&eacute;es.';

/* CONFIG ************************************************************************************ */

$pluginLangFile['galleryPath']         = 'trace de la gal&eacute;rie';
$pluginLangFile['galleryPath_tip']     = 'trace absolue du dossier contenant les images:par ex. &quot;/upload/gallery1&quot;';
$pluginLangFile['galleryTitle']        = 'titre de la gal&eacute;rie';
$pluginLangFile['previewImage']        = 'nom du fichier en miniature';
$pluginLangFile['imageWidthNumber']          = 'largeur de limage';
$pluginLangFile['imageWidthNumber_tip']      = 'en pixel';
$pluginLangFile['imageHeightNumber']         = 'hauteur de limage';
$pluginLangFile['imageHeightNumber_tip']     = 'en pixel';
$pluginLangFile['thumbnailWidthNumber']      = 'largeur de limage en miniature';
$pluginLangFile['thumbnailWidthNumber_tip']  = 'en pixel';
$pluginLangFile['thumbnailHeightNumber']     = 'hauteur de limage en miniature';
$pluginLangFile['thumbnailHeightNumber_tip'] = 'en pixel';
$pluginLangFile['filenameCaptions']    = 'nom de fichier comme légende';
$pluginLangFile['filenameCaptions_tip'] = 'Utilise le nom de fichier (sans extensions) comme légende, si aucune ligne dans un captions.txt existent pour ce fichier.';
$pluginLangFile['tagSelection']                 = 'tag HTML';
$pluginLangFile['tagSelection_tip']             = 'Le tag HTML pour la liste des images::le tags HTML suivants sont possible: &quot;table&quot;, &quot;ul&quot; o&ugrave; rien.';
$pluginLangFile['breakAfterNumber']          = 'mise en page apr&egrave;s';
$pluginLangFile['breakAfterNumber_tip']      = 'Sera seulement &eacute;ffectu&eacute; si la liste contient le tag HTML &quot;table&quot; :: Le nombre dimages indique la cr&eacute;ation dune nouvelle linie.';


// -----------------------------------------------------------------------------------------------
// RETURN ****************************************************************************************
// -----------------------------------------------------------------------------------------------
return $pluginLangFile;

?>