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
 * @subpackage imageGallery
 */

/* PLUGIN ************************************************************************************ */

$pluginLangFile['feinduraPlugin_title']        = 'Ordner-Bildergalerie';
$pluginLangFile['feinduraPlugin_description']  = 'Listet Bilder aus einem Ordner als Galerie auf. Dabei wird für jedes Bild im Ordner automatisch ein Vorschaubild erstellt. Beim anklicken werden die Bilder in einer <a href="http://reghellin.com/milkbox/">Lightbox</a> vergr&ouml;&szlig;ert.';

/* CONFIG ************************************************************************************ */

$pluginLangFile['galleryPath']         = 'Pfad der Galerie';
$pluginLangFile['galleryPath_tip']     = 'Absoluter Pfad des Ordners in dem sich die Bilder befinden::z.B. &quot;/upload/Bildergalerie1&quot;';
$pluginLangFile['galleryTitle']        = 'Galerietitel';
$pluginLangFile['previewImage']        = 'Dateiname des Vorschaubildes';
$pluginLangFile['imageWidthNumber']          = 'Bilderbreite';
$pluginLangFile['imageWidthNumber_tip']      = 'in Pixel';
$pluginLangFile['imageHeightNumber']         = 'Bilderh&ouml;he';
$pluginLangFile['imageHeightNumber_tip']     = 'in Pixel';
$pluginLangFile['thumbnailWidthNumber']      = 'Vorschaubildbreite';
$pluginLangFile['thumbnailWidthNumber_tip']  = 'in Pixel';
$pluginLangFile['thumbnailHeightNumber']     = 'Vorschaubildh&ouml;he';
$pluginLangFile['thumbnailHeightNumber_tip'] = 'in Pixel';
$pluginLangFile['filenameCaptions']    = 'Dateiname als Bildunterschriften';
$pluginLangFile['filenameCaptions_tip'] = 'Verwendet den Dateinamen (ohne Endung) als Bildunterschriften, wenn keine Zeile für diese Datei in einer captions.txt existiert.';
$pluginLangFile['tagSelection']                 = 'HTML-Tag';
$pluginLangFile['tagSelection_tip']             = 'Der HTML-Tag f&uuml;r die Auflistung der Bilder::Folgende HTML-Tags sind erlaubt: &quot;table&quot;, &quot;ul&quot; oder nichts.';
$pluginLangFile['breakAfterNumber']          = 'Umbruch nach';
$pluginLangFile['breakAfterNumber_tip']      = 'Ist nur wirksam wenn bei Auflistungs HTML-Tag &quot;table&quot; angegeben wurde:: Gibt dann an nach wieviel Bildern eine neue Zeile erzeugt wird.';


// -----------------------------------------------------------------------------------------------
// RETURN ****************************************************************************************
// -----------------------------------------------------------------------------------------------
return $pluginLangFile;

?>