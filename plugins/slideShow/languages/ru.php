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
 * @subpackage slideShow
 */

/* PLUGIN ************************************************************************************ */

$pluginLangFile['feinduraPlugin_title']        = 'Слайд-шоу';
$pluginLangFile['feinduraPlugin_description']  = 'Создание слайд-шоу из изображений.Изображения будут автоматически изменяется до заданного размера. посмотреть <a href="http://www.johannes-fischer.de/labs/nivoo-slider/">Nivooslider</a>.';

/* CONFIG ************************************************************************************ */

$pluginLangFile['selectImagesJsFunction'] = 'Выбор изображений';
$pluginLangFile['widthNumber']            = 'Слайд-шоу ширина';
$pluginLangFile['widthNumber_tip']        = 'в пикселях';
$pluginLangFile['heightNumber']           = 'Слайд-шоу высоте';
$pluginLangFile['heightNumber_tip']       = 'в пикселях';
$pluginLangFile['intervalNumber']         = 'интервал';
$pluginLangFile['intervalNumber_tip']     = 'в секундах';
$pluginLangFile['effectSelection']        = 'эффект';

// -----------------------------------------------------------------------------------------------
// RETURN ****************************************************************************************
// -----------------------------------------------------------------------------------------------
return $pluginLangFile;

?>