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
 * @subpackage slideShow
 */

/* PLUGIN ************************************************************************************ */

$pluginLangFile['feinduraPlugin_title']        = 'Rotador de imágenes';
$pluginLangFile['feinduraPlugin_description']  = 'Crea un rotador de imágenes. Las imágenes se redimensionan automáticamente al tamaño seleccionado. Ver <a href="http://www.johannes-fischer.de/labs/nivoo-slider/">Nivooslider</a>.';

/* CONFIG ************************************************************************************ */

$pluginLangFile['selectImagesJsFunction'] = 'Seleccionar imágenes';
$pluginLangFile['widthNumber']            = 'Anchura del rotador';
$pluginLangFile['widthNumber_tip']        = 'en pixels';
$pluginLangFile['heightNumber']           = 'Altura del rotador';
$pluginLangFile['heightNumber_tip']       = 'en pixels';
$pluginLangFile['intervalNumber']         = 'Intervalo';
$pluginLangFile['intervalNumber_tip']     = 'en segundos';
$pluginLangFile['effectSelection']        = 'Efecto';

// -----------------------------------------------------------------------------------------------
// RETURN ****************************************************************************************
// -----------------------------------------------------------------------------------------------
return $pluginLangFile;

?>
