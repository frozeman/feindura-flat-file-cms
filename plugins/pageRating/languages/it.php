<?php
/**
 * ITALIAN (IT) plugin language file
 * Traslated in Italian By Raffaele Panariello [Social Service] unuomoinblues@gmail.com
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

$pluginLangFile['feinduraPlugin_title']        = 'Valutazione';
$pluginLangFile['feinduraPlugin_description']  = 'Visualizza una valutazione <i>(rating)</i> restituita con 5 stelle.';

/* CONFIG ************************************************************************************ */

$pluginLangFile['valueNumber']     = 'Valutazione';
$pluginLangFile['valueNumber_tip'] = 'Valore compreso tra 1 (peggiore) e 5 (migliore)';
$pluginLangFile['votesNumber']     = 'Numero di voti';


// -----------------------------------------------------------------------------------------------
// RETURN ****************************************************************************************
// -----------------------------------------------------------------------------------------------
return $pluginLangFile;

?>