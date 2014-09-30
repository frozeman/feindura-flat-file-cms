<?php
/**
 * RUSSIAN (RU) plugin language file
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

$pluginLangFile['feinduraPlugin_title']        = 'Пример плагина';
$pluginLangFile['feinduraPlugin_description']  = 'Разве только для показа, как можно сделать свой собственный плагин!';

/* CONFIG ************************************************************************************ */

$pluginLangFile['textToDisplay']       = 'плагин текста';
$pluginLangFile['textToDisplay_tip']   = 'Этот текст будет показан в плагин';
$pluginLangFile['numberToDisplay']     = 'Количество плагинов';
$pluginLangFile['numberToDisplay_tip'] = 'Это Nummer будет показан в плагин';

// -----------------------------------------------------------------------------------------------
// RETURN ****************************************************************************************
// -----------------------------------------------------------------------------------------------
return $pluginLangFile;

?>