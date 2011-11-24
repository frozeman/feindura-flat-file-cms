<?php
/**
 * GERMAN (DE) language-file for the imageGallery plugin
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
$pluginLangFile['feinduraPlugin_description']  = 'Erzeugt eine Bilder-Slideshow. Dabei wird für jedes Bild im Ordner automatisch auf die angegebene größe skaliert. Siehe <a href="http://www.johannes-fischer.de/labs/nivoo-slider/">Nivooslider</a>.';

/* CONFIG ************************************************************************************ */

$pluginLangFile['path']         = 'Pfad der Bilder';
$pluginLangFile['path_tip']     = 'Absoluter Pfad des Ordners in dem sich die Bilder befinden::z.B. &quot;/upload/slideshow1&quot;';
$pluginLangFile['imageWidth']          = 'Bilderbreite';
$pluginLangFile['imageWidth_tip']      = 'in Pixel';
$pluginLangFile['imageHeight']         = 'Bilderh&ouml;he';
$pluginLangFile['imageHeight_tip']     = 'in Pixel';

// -----------------------------------------------------------------------------------------------
// RETURN ****************************************************************************************
// -----------------------------------------------------------------------------------------------
return $pluginLangFile;

?>