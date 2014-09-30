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
 * @subpackage slideShowFromFolder
 */


/* PLUGIN ************************************************************************************ */

$pluginLangFile['feinduraPlugin_title']        = 'Diaporama du dossier';
$pluginLangFile['feinduraPlugin_description']  = 'Crée un diaporama à partir d\'images dans un dossier. Les images seront automatiquement redimensionnées à la taille donnée. Voir <a href="http://www.johannes-fischer.de/labs/nivoo-slider/">Nivooslider</a>.';

/* CONFIG ************************************************************************************ */

$pluginLangFile['path']                  = 'chemin pour les images';
$pluginLangFile['path_tip']              = 'chemin absolue du dossier contenant les images:par ex. &quot;/upload/slideshow1&quot;';
$pluginLangFile['imageWidthNumber']      = 'largeur de limage';
$pluginLangFile['imageWidthNumber_tip']  = 'en pixel';
$pluginLangFile['imageHeightNumber']     = 'hauteur de limage';
$pluginLangFile['imageHeightNumber_tip'] = 'en pixel';
$pluginLangFile['intervalNumber']         = 'intervalle';
$pluginLangFile['intervalNumber_tip']     = 'en secondes';
$pluginLangFile['effectSelection']       = 'effet';

// -----------------------------------------------------------------------------------------------
// RETURN ****************************************************************************************
// -----------------------------------------------------------------------------------------------
return $pluginLangFile;

?>