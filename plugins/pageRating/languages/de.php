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
 * @subpackage pageRating
 */

/* PLUGIN ************************************************************************************ */

$pluginLangFile['feinduraPlugin_title']        = 'Bewertung';
$pluginLangFile['feinduraPlugin_description']  = 'Zeigt eine 5 Sterne Bewertungsmöglichkeit an.';

/* CONFIG ************************************************************************************ */

$pluginLangFile['valueNumber']     = 'Bewertung';
$pluginLangFile['valueNumber_tip'] = 'Wert zwischen 1 (schlechteste) und 5 (beste)';
$pluginLangFile['votesNumber']     = 'Anazhl der Bewertungen';


// -----------------------------------------------------------------------------------------------
// RETURN ****************************************************************************************
// -----------------------------------------------------------------------------------------------
return $pluginLangFile;

?>