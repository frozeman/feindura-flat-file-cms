<?php
/**
 * SPANISH (ES) plugin language file
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

$pluginLangFile['feinduraPlugin_title']        = 'Rotador de imágenes desde una carpeta';
$pluginLangFile['feinduraPlugin_description']  = 'Crea un rotador de imágenes a partir de la imágenes contenidas en una carpeta. Las imágenes se redimensionan automáticamente al tamaño seleccionado. Ver <a href="http://www.johannes-fischer.de/labs/nivoo-slider/">Nivooslider</a>.';

/* CONFIG ************************************************************************************ */

$pluginLangFile['path']                  = 'Ruta a las imágenes';
$pluginLangFile['path_tip']              = 'Ruta absoluta de la carpeta que contiene las imágnes::e.g &quot;/upload/slideshow1&quot;';
$pluginLangFile['imageWidthNumber']      = 'Anchura de la imagen';
$pluginLangFile['imageWidthNumber_tip']  = 'en pixels';
$pluginLangFile['imageHeightNumber']     = 'Altura de la imagen';
$pluginLangFile['imageHeightNumber_tip'] = 'en pixels';
$pluginLangFile['intervalNumber']         = 'Intervalo';
$pluginLangFile['intervalNumber_tip']     = 'en segundos';
$pluginLangFile['effectSelection']       = 'Efecto';

// -----------------------------------------------------------------------------------------------
// RETURN ****************************************************************************************
// -----------------------------------------------------------------------------------------------
return $pluginLangFile;

?>
