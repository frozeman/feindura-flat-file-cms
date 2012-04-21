<?php
/**
 * GERMAN (DE) plugin language file
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

$pluginLangFile['feinduraPlugin_title']        = 'Slideshow';
$pluginLangFile['feinduraPlugin_description']  = 'Erzeugt eine Bilder-Slideshow. Die Bilder werden automatisch verkleinert. Siehe <a href="http://www.johannes-fischer.de/labs/nivoo-slider/">Nivooslider</a>.';

/* CONFIG ************************************************************************************ */

$pluginLangFile['selectImagesJsFunction'] = 'Bilder auswählen';
$pluginLangFile['widthNumber']            = 'Slideshow-Breite';
$pluginLangFile['widthNumber_tip']        = 'in Pixel';
$pluginLangFile['heightNumber']           = 'Slideshow-H&ouml;he';
$pluginLangFile['heightNumber_tip']       = 'in Pixel';
$pluginLangFile['intervalNumber']         = 'Intervall';
$pluginLangFile['intervalNumber_tip']     = 'in sekunden';
$pluginLangFile['effectSelection']        = 'Effekt';

// -----------------------------------------------------------------------------------------------
// RETURN ****************************************************************************************
// -----------------------------------------------------------------------------------------------
return $pluginLangFile;

?>