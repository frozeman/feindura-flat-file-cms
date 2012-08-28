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
 * @subpackage imageGallery
 */

/* PLUGIN ************************************************************************************ */

$pluginLangFile['feinduraPlugin_title']        = 'Фотогалерея';
$pluginLangFile['feinduraPlugin_description']  = 'Списки изображений в галерее. Он автоматически создает миниатюры для каждого изображения. При нажатии на изображение, оно будет показано в полном размере <a href="http://reghellin.com/milkbox/" target="_blank">lightbox</a>.';

/* CONFIG ************************************************************************************ */

$pluginLangFile['selectImagesJsFunction']    = 'Выбор изображений';
$pluginLangFile['galleryTitle']              = 'Название галереи';
$pluginLangFile['previewImage']              = 'имя файла картинки предпросмотра галереи';
$pluginLangFile['imageWidthNumber']          = 'ширина изображения';
$pluginLangFile['imageWidthNumber_tip']      = 'в пикселях';
$pluginLangFile['imageHeightNumber']         = 'высота изображения';
$pluginLangFile['imageHeightNumber_tip']     = 'в пикселях';
$pluginLangFile['thumbnailWidthNumber']      = 'ширина эскиза изображения';
$pluginLangFile['thumbnailWidthNumber_tip']  = 'в пикселях';
$pluginLangFile['thumbnailHeightNumber']     = 'высота миниатюр';
$pluginLangFile['thumbnailHeightNumber_tip'] = 'в пикселях';
$pluginLangFile['filenameCaptions']          = 'имя файла в качестве заголовка';
$pluginLangFile['filenameCaptions_tip']      = 'Использует имя файла (без расширения), а заголовок, Если нет подписи была установлена​​.';
$pluginLangFile['tagSelection']              = 'HTML-тег';
$pluginLangFile['tagSelection_tip']          = 'HTML-тег, который будет использоваться для создания галереи::';
$pluginLangFile['breakAfterNumber']          = 'break after';
$pluginLangFile['breakAfterNumber_tip']      = 'Разве только если список HTML-тегов является &quot;table&quot;:: Говорит после того, как много изображений новая строка начинается.';


// -----------------------------------------------------------------------------------------------
// RETURN ****************************************************************************************
// -----------------------------------------------------------------------------------------------
return $pluginLangFile;

?>