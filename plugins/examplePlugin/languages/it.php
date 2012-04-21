<?php
/**
 * ITALIAN (IT) plugin language file
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
 * @subpackage examplePlugin
 */

/* PLUGIN ************************************************************************************ */

$pluginLangFile['feinduraPlugin_title']        = 'Esempio plugin';
$pluginLangFile['feinduraPlugin_description']  = 'È solo per mostrare come si potrebbe fare i propri plugin!';

/* CONFIG ************************************************************************************ */

$pluginLangFile['textToDisplay']       = 'testo di plugin';
$pluginLangFile['textToDisplay_tip']   = 'Questo testo verrà mostrato nella Plugin';
$pluginLangFile['numberToDisplay']     = 'Numero di plugin';
$pluginLangFile['numberToDisplay_tip'] = 'Questo Nummer verrà mostrato nella Plugin';

// -----------------------------------------------------------------------------------------------
// RETURN ****************************************************************************************
// -----------------------------------------------------------------------------------------------
return $pluginLangFile;

?>