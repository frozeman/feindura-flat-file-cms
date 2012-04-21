<?php
/**
 * FRENCH (FR) plugin language file
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

$pluginLangFile['feinduraPlugin_title']        = 'plugin Exemple';
$pluginLangFile['feinduraPlugin_description']  = 'C\'est juste pour montrer comment vous pourriez faire vos propres plugins!';

/* CONFIG ************************************************************************************ */

$pluginLangFile['textToDisplay']       = 'Texte plugin';
$pluginLangFile['textToDisplay_tip']   = 'Ce texte sera affiché dans le plug-in';
$pluginLangFile['numberToDisplay']     = 'Nombre plugin';
$pluginLangFile['numberToDisplay_tip'] = 'Ce Numéro sera affiché dans le plug-in';

// -----------------------------------------------------------------------------------------------
// RETURN ****************************************************************************************
// -----------------------------------------------------------------------------------------------
return $pluginLangFile;

?>