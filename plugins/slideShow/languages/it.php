<?php
/**
 * ITALIAN (IT) language-file for the imageGallery plugin
 * Traslated in Italian By Raffaele Panariello [Social Service] unuomoinblues@gmail.com
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

$pluginLangFile['feinduraPlugin_title']        = 'Proiezione Di Diapositive';
$pluginLangFile['feinduraPlugin_description']  = 'Crea una proiezione di diapositive <i>slideshow</i> delle immagini di una cartella sul server. Le immagini verranno automaticamente ridimensionate alla dimensione data. Vedere <a href="http://www.johannes-fischer.de/labs/nivoo-slider/">Nivooslider</a>.';

/* CONFIG ************************************************************************************ */

$pluginLangFile['path']         = 'percorso delle immagini';
$pluginLangFile['path_tip']     = 'percorso assoluto della cartella, che contiene le immagini::ad esempio &quot;/upload/slideshow1&quot;';
$pluginLangFile['imageWidth']          = 'larghezza immagine';
$pluginLangFile['imageWidth_tip']      = 'in pixel';
$pluginLangFile['imageHeight']         = 'altezza immagine';
$pluginLangFile['imageHeight_tip']     = 'in pixel';

// -----------------------------------------------------------------------------------------------
// RETURN ****************************************************************************************
// -----------------------------------------------------------------------------------------------
return $pluginLangFile;

?>