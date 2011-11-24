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
 * @subpackage slideShow
 */


/* PLUGIN ************************************************************************************ */

$pluginLangFile['feinduraPlugin_title']        = 'diaporama';
$pluginLangFile['feinduraPlugin_description']  = 'Crée un diaporama à partir d\'images dans un dossier. Les images seront automatiquement redimensionnées à la taille donnée. Voir <a href="http://www.johannes-fischer.de/labs/nivoo-slider/">Nivooslider</a>.';

/* CONFIG ************************************************************************************ */

$pluginLangFile['path']         = 'chemin pour les images';
$pluginLangFile['path_tip']     = 'chemin absolue du dossier contenant les images:par ex. &quot;/upload/slideshow1&quot;';
$pluginLangFile['imageWidth']          = 'largeur de limage';
$pluginLangFile['imageWidth_tip']      = 'en pixel';
$pluginLangFile['imageHeight']         = 'hauteur de limage';
$pluginLangFile['imageHeight_tip']     = 'en pixel';

// -----------------------------------------------------------------------------------------------
// RETURN ****************************************************************************************
// -----------------------------------------------------------------------------------------------
return $pluginLangFile;

?>