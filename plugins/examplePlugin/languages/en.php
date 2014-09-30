<?php
/**
 * ENGLISH (EN) plugin language file
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

$pluginLangFile['feinduraPlugin_title']        = 'Example Plugin';
$pluginLangFile['feinduraPlugin_description']  = 'Is just for showing how you could make your own plugins!';

/* CONFIG ************************************************************************************ */

$pluginLangFile['textToDisplay']       = 'Plugin Text';
$pluginLangFile['textToDisplay_tip']   = 'This text will be shown in the Plugin';
$pluginLangFile['numberToDisplay']     = 'Plugin Number';
$pluginLangFile['numberToDisplay_tip'] = 'This Nummer will be shown in the Plugin';

// -----------------------------------------------------------------------------------------------
// RETURN ****************************************************************************************
// -----------------------------------------------------------------------------------------------
return $pluginLangFile;

?>