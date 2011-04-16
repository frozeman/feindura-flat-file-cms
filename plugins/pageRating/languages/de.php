<?php
/**
 * GERMAN (DE) language-file for the pageRating plugin
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
 * @subpackage pageRating
 */

/* PLUGIN ************************************************************************************ */

$pluginLangFile['plugin_title']        = 'Bewertung';
$pluginLangFile['plugin_description']  = 'Zeigt eine 5 Sterne Bewertungsmöglichkeit an.';

/* CONFIG ************************************************************************************ */

$pluginLangFile['value'] = 'Bewertung';
$pluginLangFile['votes'] = 'Anazhl der Bewertungen';


// -----------------------------------------------------------------------------------------------
// RETURN ****************************************************************************************
// -----------------------------------------------------------------------------------------------
return $pluginLangFile;

?>