<?php
/**
 * GERMAN (DE) language-file for the imageGallery plugin
 * 
 * NEEDS a RETURN $pluginLangFile; at the END
 * 
 * 
 * Every plugin language file has to have:
 *    - $pluginLangFile['plugin_title']        = 'Exampletitle';
 *    - $pluginLangFile['plugin_description']  = 'This is an example plugin dscription.';
 *  
 * If the array key has an "configname_tip" on the end it will be used as toolTip.
 * E.g.:
 * $pluginLangFile['exampleconfig_tip'] = 'Example config tooltip text';
 * 
 * @package [Plugins]
 * @subpackage imageGallery
 */

/* PLUGIN ************************************************************************************ */

$pluginLangFile['plugin_title']        = 'Bildergalerie';
$pluginLangFile['plugin_description']  = 'Listet Bilder aus einem Ordner als Galerie auf. Dabei wird für jedes Bild im Ordner automatisch ein Vorschaubild erstellt. Beim anklicken werden die Bilder in einer <a href="http://www.digitalia.be/software/slimbox2">Box</a> vergr&ouml;&szlig;ert.';

/* CONFIG ************************************************************************************ */

$pluginLangFile['galleryPath']         = 'Pfad der Galerie';
$pluginLangFile['galleryPath_tip']     = 'Absoluter Pfad des Ordners in dem sich die Bilder befinden::z.B. &quot;/upload/Bildergalerie1&quot;';
$pluginLangFile['galleryTitle']        = 'Galerietitel';
$pluginLangFile['previewImage']        = 'Dateiname des Vorschaubildes';
$pluginLangFile['imageWidth']          = 'Bilderbreite';
$pluginLangFile['imageWidth_tip']      = 'in Pixel';
$pluginLangFile['imageHeight']         = 'Bilderh&ouml;he';
$pluginLangFile['imageHeight_tip']     = 'in Pixel';
$pluginLangFile['thumbnailWidth']      = 'Vorschaubildbreite';
$pluginLangFile['thumbnailWidth_tip']  = 'in Pixel';
$pluginLangFile['thumbnailHeight']     = 'Vorschaubildh&ouml;he';
$pluginLangFile['thumbnailHeight_tip'] = 'in Pixel';
$pluginLangFile['tag']                 = 'Auflistungs HTML-Tag';
$pluginLangFile['tag_tip']             = 'Der HTML-Tag f&uuml;r die Auflistung der Bilder::Folgende HTML-Tags sind erlaubt: &quot;table&quot;, &quot;ul&quot; oder nichts.';
$pluginLangFile['breakAfter']          = 'Umbruch nach';
$pluginLangFile['breakAfter_tip']      = 'Ist nur wirksam wenn bei Auflistungs HTML-Tag &quot;table&quot; angegeben wurde:: Gibt dann an nach wieviel Bildern eine neue Zeile erzeugt wird.';


// -----------------------------------------------------------------------------------------------
// RETURN ****************************************************************************************
// -----------------------------------------------------------------------------------------------
return $pluginLangFile;

?>