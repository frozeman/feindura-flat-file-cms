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
 * @subpackage contactForm
 */

/* PLUGIN ************************************************************************************ */

$pluginLangFile['feinduraPlugin_title']       = 'Modulo Di Contatto';
$pluginLangFile['feinduraPlugin_description'] = 'Crea un modulo di contatto per inviare emails.';

/* CONFIG ************************************************************************************ */

$pluginLangFile['captcha']                 = 'Usa captcha';
$pluginLangFile['recipient']               = 'Destinatario';
$pluginLangFile['appellation']             = 'mostra denominazione';
$pluginLangFile['appellation_mandatory']   = 'denominazione &#232; obbligatoria?';
$pluginLangFile['firstname']               = 'mostra nome';
$pluginLangFile['firstname_mandatory']     = 'nome &#232; obbligatorio?';
$pluginLangFile['lastname']                = 'mostra cognome';
$pluginLangFile['lastname_mandatory']      = 'cognome &#232; obbligatorio?';
$pluginLangFile['company']                 = 'mostrano azienda';
$pluginLangFile['company_mandatory']       = 'azienda &#232; obbligatoria?';
$pluginLangFile['street']                  = 'mostra strada';
$pluginLangFile['street_mandatory']        = 'strada &#232; obbligatoria?';
$pluginLangFile['housenumber']             = 'mostra numero civico';
$pluginLangFile['housenumber_mandatory']   = 'numero civico &#232; obbligatorio?';
$pluginLangFile['zipcode']                 = 'mostra codice postale';
$pluginLangFile['zipcode_mandatory']       = 'codice postale &#232; obbligatorio?';
$pluginLangFile['city']                    = 'mostra citt&#224;';
$pluginLangFile['city_mandatory']          = 'citt&#224; &#232; obbligatoria?';
$pluginLangFile['country']                 = 'mostra provincia';
$pluginLangFile['country_mandatory']       = 'provincia &#232; obbligatoria?';
$pluginLangFile['website']                 = 'mostra website';
$pluginLangFile['website_mandatory']       = 'website &#232; obbligatorio?';
$pluginLangFile['email']                   = 'mostra e-mail';
$pluginLangFile['email_mandatory']         = 'e-mail &#232; obbligatoria?';
$pluginLangFile['phone']                   = 'mostra telefono';
$pluginLangFile['phone_mandatory']         = 'telefono &#232; obbligatorio?';
$pluginLangFile['fax']                     = 'mostra fax';
$pluginLangFile['fax_mandatory']           = 'fax &#232; obbligatorio?';

/* CONTACTFORM ******************************************************************************* */

$pluginLangFile['form_title']              = 'Modulo Di Contatto';
$pluginLangFile['form_send']               = 'Il tuo messaggio &#232; stato inviato con successo!';
$pluginLangFile['link_back']               = 'indietro';
$pluginLangFile['text_mandatoryfields']    = 'Le informazioni con l\'asterisco sono obbligatorie.';
$pluginLangFile['error_mandatoryfields']   = 'I seguenti campi devono essere riempiti:';
$pluginLangFile['error_captcha']           = '<b>Numero di verifica fallito!</b><br>Si prega di controllare il numero di 4 cifre di verifica.';
$pluginLangFile['field_appellation']       = 'appellativo';
$pluginLangFile['field_appellation_man']   = 'Mr';
$pluginLangFile['field_appellation_woman'] = 'Mrs';
$pluginLangFile['field_firstname']         = 'Nome';
$pluginLangFile['field_lastname']          = 'Cognome';
$pluginLangFile['field_company']           = 'Azienda';
$pluginLangFile['field_street']            = 'Via';
$pluginLangFile['field_housenumber']       = 'Numero';
$pluginLangFile['field_zipcode']           = 'Codice Postale';
$pluginLangFile['field_city']              = 'Citt&#224;';
$pluginLangFile['field_country']           = 'Provincia';
$pluginLangFile['field_website']           = 'Website';
$pluginLangFile['field_email']             = 'E-Mail';
$pluginLangFile['field_phone']             = 'Telefono';
$pluginLangFile['field_fax']               = 'Fax';
$pluginLangFile['field_message']           = 'Messaggio';
$pluginLangFile['field_captcha']           = 'Si prega di inserire il numero di 4 cifre nel campo sottostante.';
$pluginLangFile['button_send']             = 'INVIA';

$pluginLangFile['message_subject']         = 'modulo di contatto'; // Websitetitle contact form
$pluginLangFile['message_title1']          = 'Hai ricevuto un messaggio dal tuo website'; // You get a mesage from the Website title contact formular
$pluginLangFile['message_title2']          = 'modulo di contatto';
$pluginLangFile['message_block1_title']    = 'MESSAGGIO';
$pluginLangFile['message_block2_title']    = 'DA';
$pluginLangFile['message_senddate']        = 'Inviato il'; // Send on dd.mm.yyyy at 12:00
$pluginLangFile['message_sendtime']        = 'da';
$pluginLangFile['message_address']         = 'Indirizzo';


// -----------------------------------------------------------------------------------------------
// RETURN ****************************************************************************************
// -----------------------------------------------------------------------------------------------
return $pluginLangFile;

?>