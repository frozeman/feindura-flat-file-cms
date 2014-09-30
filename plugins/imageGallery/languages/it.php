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
 * @subpackage imageGallery
 */

/* PLUGIN ************************************************************************************ */

$pluginLangFile['feinduraPlugin_title']        = 'Galleria Immagini';
$pluginLangFile['feinduraPlugin_description']  = 'Lista immagini in una galleria. Una miniatura verra creata automaticamente per ogni immagine. Quando si fa clic su un\'immagine, sar&#224; mostrata con le sue dimensioni reali in un <a href="http://reghellin.com/milkbox/" target="_blank">lightbox</a>.';

/* CONFIG ************************************************************************************ */

$pluginLangFile['selectImagesJsFunction']    = 'selezionare le immagini';
$pluginLangFile['galleryTitle']              = 'titolo della galleria';
$pluginLangFile['previewImage']              = 'nome del file immagine di anteprima della galleria';
$pluginLangFile['imageWidthNumber']          = 'larghezza immagine';
$pluginLangFile['imageWidthNumber_tip']      = 'in pixel';
$pluginLangFile['imageHeightNumber']         = 'altezza immagine';
$pluginLangFile['imageHeightNumber_tip']     = 'in pixel';
$pluginLangFile['thumbnailWidthNumber']      = 'larghezza anteprima';
$pluginLangFile['thumbnailWidthNumber_tip']  = 'in pixel';
$pluginLangFile['thumbnailHeightNumber']     = 'altezza anteprima';
$pluginLangFile['thumbnailHeightNumber_tip'] = 'in pixel';
$pluginLangFile['filenameCaptions']          = 'nome del file come didascalia';
$pluginLangFile['filenameCaptions_tip']      = 'Utilizza il nome del file (senza estensione), come didascalia, se non le didascalie è stato impostato.';
$pluginLangFile['tagSelection']              = 'HTML-Tag';
$pluginLangFile['tagSelection_tip']          = 'Il HTML-Tag che sarà utilizzato per creare la galleria::';
$pluginLangFile['breakAfterNumber']          = 'break after';
$pluginLangFile['breakAfterNumber_tip']      = 'Non funziona solo se la lista HTML-Tag è &quot;table&quot;:: Indica dopo quante immagini una nuova riga inizia.';


// -----------------------------------------------------------------------------------------------
// RETURN ****************************************************************************************
// -----------------------------------------------------------------------------------------------
return $pluginLangFile;

?>