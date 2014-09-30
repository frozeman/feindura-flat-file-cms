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

$pluginLangFile['feinduraPlugin_title']        = 'gal&eacute;rie des images';
$pluginLangFile['feinduraPlugin_description']  = 'Etablit une liste des images dans la gal&eacute;rie.Chaque image dans le dossier sera affich&eacute;e par une miniature. En cliquant sur les images, elles <a href="http://reghellin.com/milkbox/" target="_blank">lightbox</a> seront affich&eacute;es.';

/* CONFIG ************************************************************************************ */

$pluginLangFile['selectImagesJsFunction']    = 'sélectionnez les images';
$pluginLangFile['galleryTitle']              = 'titre de la gal&eacute;rie';
$pluginLangFile['previewImage']              = 'nom du fichier en miniature';
$pluginLangFile['imageWidthNumber']          = 'largeur de limage';
$pluginLangFile['imageWidthNumber_tip']      = 'en pixel';
$pluginLangFile['imageHeightNumber']         = 'hauteur de limage';
$pluginLangFile['imageHeightNumber_tip']     = 'en pixel';
$pluginLangFile['thumbnailWidthNumber']      = 'largeur de limage en miniature';
$pluginLangFile['thumbnailWidthNumber_tip']  = 'en pixel';
$pluginLangFile['thumbnailHeightNumber']     = 'hauteur de limage en miniature';
$pluginLangFile['thumbnailHeightNumber_tip'] = 'en pixel';
$pluginLangFile['filenameCaptions']          = 'nom de fichier comme légende';
$pluginLangFile['filenameCaptions_tip']      = 'Utilise le nom de fichier (sans extensions) comme légende, si aucun sous-titres a été fixé.';
$pluginLangFile['tagSelection']              = 'HTML-Tag';
$pluginLangFile['tagSelection_tip']          = 'Le code HTML-Tag qui sera utilisé pour créer la galerie::';
$pluginLangFile['breakAfterNumber']          = 'mise en page apr&egrave;s';
$pluginLangFile['breakAfterNumber_tip']      = 'Sera seulement &eacute;ffectu&eacute; si la liste contient le tag HTML &quot;table&quot; :: Le nombre dimages indique la cr&eacute;ation dune nouvelle linie.';


// -----------------------------------------------------------------------------------------------
// RETURN ****************************************************************************************
// -----------------------------------------------------------------------------------------------
return $pluginLangFile;

?>