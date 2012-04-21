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
 * @subpackage examplePlugin
 */

/* PLUGIN ************************************************************************************ */

$pluginLangFile['feinduraPlugin_title']        = 'Beispiel Plugin';
$pluginLangFile['feinduraPlugin_description']  = 'Dies ist nur dazu da um zu zeigen wie du deine eigenen Plugins schreiben kannst!';

/* CONFIG ************************************************************************************ */

$pluginLangFile['textToDisplay']       = 'Plugin Text';
$pluginLangFile['textToDisplay_tip']   = 'Dieser Text wird im Plugin gezeigt';
$pluginLangFile['numberToDisplay']     = 'Plugin Nummer';
$pluginLangFile['numberToDisplay_tip'] = 'Diese Nummer wird im Plugin gezeigt';

// -----------------------------------------------------------------------------------------------
// RETURN ****************************************************************************************
// -----------------------------------------------------------------------------------------------
return $pluginLangFile;

?>