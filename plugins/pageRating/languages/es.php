<?php
/**
 * SPANISH (ES) plugin language file
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

$pluginLangFile['feinduraPlugin_title']        = 'Valoración';
$pluginLangFile['feinduraPlugin_description']  = 'Muestra 5 estrellas para valorar.';

/* CONFIG ************************************************************************************ */

$pluginLangFile['valueNumber']     = 'Valoración';
$pluginLangFile['valueNumber_tip'] = 'Valor entre 1 (malísimo) y 5 (buenísimo)';
$pluginLangFile['votesNumber']     = 'Número de votos';


// -----------------------------------------------------------------------------------------------
// RETURN ****************************************************************************************
// -----------------------------------------------------------------------------------------------
return $pluginLangFile;

?>
