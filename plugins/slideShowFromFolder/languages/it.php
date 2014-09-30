<?php
/**
 * ITALIAN (IT) plugin language file
 * Traslated in Italian By Raffaele Panariello [Social Service] unuomoinblues@gmail.com
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

$pluginLangFile['feinduraPlugin_title']        = 'Proiezione Di Diapositive da cartella';
$pluginLangFile['feinduraPlugin_description']  = 'Crea una proiezione di diapositive <i>slideshow</i> delle immagini di una cartella sul server. Le immagini verranno automaticamente ridimensionate alla dimensione data. Vedere <a href="http://www.johannes-fischer.de/labs/nivoo-slider/">Nivooslider</a>.';

/* CONFIG ************************************************************************************ */

$pluginLangFile['path']                  = 'percorso delle immagini';
$pluginLangFile['path_tip']              = 'percorso assoluto della cartella, che contiene le immagini::ad esempio &quot;/upload/slideshow1&quot;';
$pluginLangFile['imageWidthNumber']      = 'larghezza immagine';
$pluginLangFile['imageWidthNumber_tip']  = 'in pixel';
$pluginLangFile['imageHeightNumber']     = 'altezza immagine';
$pluginLangFile['imageHeightNumber_tip'] = 'in pixel';
$pluginLangFile['intervalNumber']         = 'intervallo';
$pluginLangFile['intervalNumber_tip']     = 'in secondo';
$pluginLangFile['effectSelection']       = 'effetto';

// -----------------------------------------------------------------------------------------------
// RETURN ****************************************************************************************
// -----------------------------------------------------------------------------------------------
return $pluginLangFile;

?>