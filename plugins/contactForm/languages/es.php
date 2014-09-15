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
 * @subpackage contactForm
 */

/* PLUGIN ************************************************************************************ */

$pluginLangFile['feinduraPlugin_title']        = 'Formulario de contacto';
$pluginLangFile['feinduraPlugin_description']  = 'Crea un formulario de contacto para enviar por correo electrónico.';

/* CONFIG ************************************************************************************ */

$pluginLangFile['captcha'] = 'usar captcha';
$pluginLangFile['recipient'] = 'Cuenta de correo destino';
$pluginLangFile['appellation'] = 'Mostrar origen';
$pluginLangFile['appellation_mandatory'] = 'Origen obligatorio';
$pluginLangFile['firstname'] = 'Mostrar nombre';
$pluginLangFile['firstname_mandatory'] = 'Nombre obligatorio';
$pluginLangFile['lastname'] = 'Mostrar apellidos';
$pluginLangFile['lastname_mandatory'] = 'Apellidos obligatorios';
$pluginLangFile['company'] = 'Mostrar empresa';
$pluginLangFile['company_mandatory'] = 'Empresa obligatorio';
$pluginLangFile['street'] = 'Mostrar calle';
$pluginLangFile['street_mandatory'] = 'Calle obligatorio';
$pluginLangFile['housenumber'] = 'Mostrar número del domicilio';
$pluginLangFile['housenumber_mandatory'] = 'Número del domicilio obligatorio';
$pluginLangFile['zipcode'] = 'Mostrar código postal';
$pluginLangFile['zipcode_mandatory'] = 'Código postal obligatorio';
$pluginLangFile['city'] = 'Mostrar ciudad';
$pluginLangFile['city_mandatory'] = 'Ciudad obligatorio';
$pluginLangFile['country'] = 'Mostrar país';
$pluginLangFile['country_mandatory'] = 'País obligatorio';
$pluginLangFile['website'] = 'Mostrar página web';
$pluginLangFile['website_mandatory'] = 'Página web obligatorio';
$pluginLangFile['email'] = 'Mostrar correo electrónico';
$pluginLangFile['email_mandatory'] = 'Correo electrónico obligatorio';
$pluginLangFile['phone'] = 'Mostrar teléfono';
$pluginLangFile['phone_mandatory'] = 'Teléfono obligatorio';
$pluginLangFile['fax'] = 'Mostrar fax';
$pluginLangFile['fax_mandatory'] = 'Fax obligatorio';

/* CONTACTFORM ******************************************************************************* */

$pluginLangFile['form_title'] = 'Formulario de contacto';
$pluginLangFile['form_send'] = 'El mensaje se envió correctamente';
$pluginLangFile['link_back'] = 'atrás';
$pluginLangFile['text_mandatoryfields'] = 'Información obligatoria';
$pluginLangFile['error_mandatoryfields'] = 'Los siguientes campos son obligatorios:';
$pluginLangFile['error_captcha'] = '<b>¡Numero de verificación erróneo!</b><br>Por favor, compruebe los 4 dígitos del número de verificación.';
$pluginLangFile['field_appellation'] = 'appellation';
$pluginLangFile['field_appellation_man'] = 'Sr';
$pluginLangFile['field_appellation_woman'] = 'Sra';
$pluginLangFile['field_firstname'] = 'First Name';
$pluginLangFile['field_lastname'] = 'Last Name';
$pluginLangFile['field_company'] = 'Empresa';
$pluginLangFile['field_street'] = 'Calle';
$pluginLangFile['field_housenumber'] = 'Número';
$pluginLangFile['field_zipcode'] = 'Codigo postal';
$pluginLangFile['field_city'] = 'Ciudad';
$pluginLangFile['field_country'] = 'Pais';
$pluginLangFile['field_website'] = 'Página web';
$pluginLangFile['field_email'] = 'Correo electrónico';
$pluginLangFile['field_phone'] = 'Teléfono';
$pluginLangFile['field_fax'] = 'Fax';
$pluginLangFile['field_message'] = 'Mensaje';
$pluginLangFile['field_captcha'] = 'Por favor introduzca el número en el campo de texto.';
$pluginLangFile['button_send'] = 'ENVIAR';

$pluginLangFile['message_subject'] = 'Formulario de contacto'; // Websitetitle contact form
$pluginLangFile['message_title1'] = 'Tienes un mensaje de '; // You get a mesage from the Website title contact form
$pluginLangFile['message_title2'] = 'Formulario de contacto';
$pluginLangFile['message_block1_title'] = 'MENSAJE';
$pluginLangFile['message_block2_title'] = 'DE';
$pluginLangFile['message_senddate'] = 'Enviado el '; // Send on dd.mm.yyyy at 12:00
$pluginLangFile['message_sendtime'] = 'a';
$pluginLangFile['message_address'] = 'Dirección';


// -----------------------------------------------------------------------------------------------
// RETURN ****************************************************************************************
// -----------------------------------------------------------------------------------------------
return $pluginLangFile;

?>
