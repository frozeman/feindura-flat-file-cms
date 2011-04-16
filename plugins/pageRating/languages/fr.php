<?php
/**
 * FRENCH (FR) language-file for the pageRating plugin
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

$pluginLangFile['plugin_title']        = 'Cote';
$pluginLangFile['plugin_description']  = 'Affiche une cote de 5 étoiles.';

/* CONFIG ************************************************************************************ */

$pluginLangFile['value'] = 'cote';
$pluginLangFile['votes'] = 'nombre de cote';


// -----------------------------------------------------------------------------------------------
// RETURN ****************************************************************************************
// -----------------------------------------------------------------------------------------------
return $pluginLangFile;

?>