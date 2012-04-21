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
 * @subpackage pageRating
 */


/* PLUGIN ************************************************************************************ */

$pluginLangFile['feinduraPlugin_title']        = 'Cote';
$pluginLangFile['feinduraPlugin_description']  = 'Affiche une cote de 5 étoiles.';

/* CONFIG ************************************************************************************ */

$pluginLangFile['valueNumber']     = 'cote';
$pluginLangFile['valueNumber_tip'] = 'Valeur entre 1 (pire) et 5 (le meilleur)';
$pluginLangFile['votesNumber']     = 'nombre de cote';


// -----------------------------------------------------------------------------------------------
// RETURN ****************************************************************************************
// -----------------------------------------------------------------------------------------------
return $pluginLangFile;

?>