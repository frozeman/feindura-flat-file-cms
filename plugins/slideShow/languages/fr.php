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
 * @subpackage slideShow
 */


/* PLUGIN ************************************************************************************ */

$pluginLangFile['feinduraPlugin_title']        = 'diaporama';
$pluginLangFile['feinduraPlugin_description']  = 'Crée un diaporama d\'images. Les images seront automatiquement redimensionnées à la taille donnée. Voir <a href="http://www.johannes-fischer.de/labs/nivoo-slider/">Nivooslider</a>.';

/* CONFIG ************************************************************************************ */

$pluginLangFile['selectImagesJsFunction'] = 'sélectionnez les images';
$pluginLangFile['widthNumber']            = 'largeur de diaporama';
$pluginLangFile['widthNumber_tip']        = 'en pixel';
$pluginLangFile['heightNumber']           = 'hauteur de diaporama';
$pluginLangFile['heightNumber_tip']       = 'en pixel';
$pluginLangFile['intervalNumber']         = 'intervalle';
$pluginLangFile['intervalNumber_tip']     = 'en secondes';
$pluginLangFile['effectSelection']        = 'effet';

// -----------------------------------------------------------------------------------------------
// RETURN ****************************************************************************************
// -----------------------------------------------------------------------------------------------
return $pluginLangFile;

?>