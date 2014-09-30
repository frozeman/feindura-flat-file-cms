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
 * Then you can use the same key names like in the config.php to describe the setting.
 * 
 *  
 * If the array key has an "..._tip" on the end it will be used as toolTip.
 * E.g.:
 * <samp>
 * $pluginLangFile['exampleconfig_tip'] = 'Example config tooltip text';
 * </samp>
 * 
 * @package [Plugins]
 * @subpackage pageRating
 */

/* PLUGIN ************************************************************************************ */

$pluginLangFile['feinduraPlugin_title']        = 'рейтинг';
$pluginLangFile['feinduraPlugin_description']  = 'Вывод 5-звездочный рейтинг.';

/* CONFIG ************************************************************************************ */

$pluginLangFile['valueNumber']     = 'рейтинг';
$pluginLangFile['valueNumber_tip'] = 'Значение между 1 (худший) и 5 ​​(лучше)';
$pluginLangFile['votesNumber']     = 'Количество голосов';


// -----------------------------------------------------------------------------------------------
// RETURN ****************************************************************************************
// -----------------------------------------------------------------------------------------------
return $pluginLangFile;

?>