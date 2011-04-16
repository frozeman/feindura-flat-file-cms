<?php
/**
 * ENGLISH (EN) language-file for the pageRating plugin
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

$pluginLangFile['plugin_title']        = 'Rating';
$pluginLangFile['plugin_description']  = 'Displays a 5 star rating.';

/* CONFIG ************************************************************************************ */

$pluginLangFile['value'] = 'Rating';
$pluginLangFile['votes'] = 'Number of votes';


// -----------------------------------------------------------------------------------------------
// RETURN ****************************************************************************************
// -----------------------------------------------------------------------------------------------
return $pluginLangFile;

?>