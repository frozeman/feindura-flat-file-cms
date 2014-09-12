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
 * @subpackage imageGallery
 */

/* PLUGIN ************************************************************************************ */

$pluginLangFile['feinduraPlugin_title']        = 'Galería de imágenes desde una carpeta';
$pluginLangFile['feinduraPlugin_description']  = 'Crea una galería de imágenes con las imágenes contenidas en una carpeta. Las miniaturas de las imágenes se crean automáticamente. Al pinchar sobre una imagen ésta se mostrará a tamaño completo en un <a href="http://reghellin.com/milkbox/" target="_blank">panel (lightbox)</a>.';

/* CONFIG ************************************************************************************ */

$pluginLangFile['galleryPath']         = 'Ruta de la galería';
$pluginLangFile['galleryPath_tip']     = 'Ruta absoluta de la carpeta que contiene las imágenes a utilizar en la galería::ej. &quot;/upload/Imagegallery1&quot;';
$pluginLangFile['galleryTitle']              = 'Título de la galería.';
$pluginLangFile['previewImage']              = 'Fichero de imagen que actuará como la vista previa de la galería.';
$pluginLangFile['imageWidthNumber']          = 'Anchura de la imagen';
$pluginLangFile['imageWidthNumber_tip']      = 'en pixels';
$pluginLangFile['imageHeightNumber']         = 'Altura de la imagen';
$pluginLangFile['imageHeightNumber_tip']     = 'en pixels';
$pluginLangFile['thumbnailWidthNumber']      = 'Anchura de la miniatura';
$pluginLangFile['thumbnailWidthNumber_tip']  = 'en pixels';
$pluginLangFile['thumbnailHeightNumber']     = 'Altura de la miniatura';
$pluginLangFile['thumbnailHeightNumber_tip'] = 'en pixels';
$pluginLangFile['filenameCaptions']          = 'Nombre del fichero como título';
$pluginLangFile['filenameCaptions_tip']      = 'Usa el nombre del fichero (sin la extensión) como título, si no se le asigna ninguno.';
$pluginLangFile['tagSelection']              = 'Etiqueta HTML';
$pluginLangFile['tagSelection_tip']          = 'La  etiqueta HTML que se utilizará para crear la galería:: Las etiquetas permitidas son: &quot;table&quot;, &quot;ul&quot; o también es posible no utilizar ninguna etiqueta';
$pluginLangFile['breakAfterNumber']          = 'Imágenes por fila';
$pluginLangFile['breakAfterNumber_tip']      = 'Solo se utiliza cuando la etiqueta HTML elegida para la galería es la etiqueta &quot;table&quot;:: Indica el número de imágenes que contendrá una fila.';


// -----------------------------------------------------------------------------------------------
// RETURN ****************************************************************************************
// -----------------------------------------------------------------------------------------------
return $pluginLangFile;

?>
