<?php
/**
 * ROMANIAN (RO) plugin language file
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

$pluginLangFile['feinduraPlugin_title']        = 'Formular contact';
$pluginLangFile['feinduraPlugin_description']  = 'Creaza un formular de contact pentru trimitere mail-uri.';

/* CONFIG ************************************************************************************ */

$pluginLangFile['captcha'] = 'utilizeaza captcha';
$pluginLangFile['recipient'] = 'Destinatar';
$pluginLangFile['appellation'] = 'afiseaza formula adresare';
$pluginLangFile['appellation_mandatory'] = 'formula adresare este obligatoriu/e?';
$pluginLangFile['firstname'] = 'afiseaza nume';
$pluginLangFile['firstname_mandatory'] = 'numele este obligatoriu/e?';
$pluginLangFile['lastname'] = 'afiseaza prenume';
$pluginLangFile['lastname_mandatory'] = 'prenumele este obligatoriu/e?';
$pluginLangFile['company'] = 'afiseaza companie';
$pluginLangFile['company_mandatory'] = 'compania este obligatoriu/e?';
$pluginLangFile['street'] = 'afiseaza strada';
$pluginLangFile['street_mandatory'] = 'strada este obligatoriu/e?';
$pluginLangFile['housenumber'] = 'afiseaza numar strada';
$pluginLangFile['housenumber_mandatory'] = 'numarul de strada este obligatoriu/e?';
$pluginLangFile['zipcode'] = 'afiseaza cod postal';
$pluginLangFile['zipcode_mandatory'] = 'codul postal este obligatoriu/e?';
$pluginLangFile['city'] = 'afiseaza oras';
$pluginLangFile['city_mandatory'] = 'orasul este obligatoriu/e?';
$pluginLangFile['country'] = 'afiseaza tara';
$pluginLangFile['country_mandatory'] = 'tara este obligatoriu/e?';
$pluginLangFile['website'] = 'afiseaza website';
$pluginLangFile['website_mandatory'] = 'website-ul este obligatoriu/e?';
$pluginLangFile['email'] = 'afiseaza e-mail';
$pluginLangFile['email_mandatory'] = 'e-mail-ul este obligatoriu/e?';
$pluginLangFile['phone'] = 'afiseaza telefon';
$pluginLangFile['phone_mandatory'] = 'telefonul este obligatoriu/e?';
$pluginLangFile['fax'] = 'afiseaza fax';
$pluginLangFile['fax_mandatory'] = 'fax-ul este obligatoriu/e?';

/* CONTACTFORM ******************************************************************************* */

$pluginLangFile['form_title'] = 'Formular contact';
$pluginLangFile['form_send'] = 'Mesajul a fost trimis cu succes!';
$pluginLangFile['link_back'] = 'inapoi';
$pluginLangFile['text_mandatoryfields'] = 'Informatie obligatorie';
$pluginLangFile['error_mandatoryfields'] = 'Urmatoarele campuri trebuie completate:';
$pluginLangFile['error_captcha'] = '<b>Numarul de verificare este gresit!</b><br>Reverificati numarul de verificare din 4 cifre.';
$pluginLangFile['field_appellation'] = 'formula adresare';
$pluginLangFile['field_appellation_man'] = 'Dl';
$pluginLangFile['field_appellation_woman'] = 'D-na';
$pluginLangFile['field_firstname'] = 'Nume';
$pluginLangFile['field_lastname'] = 'Prenume';
$pluginLangFile['field_company'] = 'Companie';
$pluginLangFile['field_street'] = 'Strada';
$pluginLangFile['field_housenumber'] = 'Numar';
$pluginLangFile['field_zipcode'] = 'Cod postal';
$pluginLangFile['field_city'] = 'Oras';
$pluginLangFile['field_country'] = 'Tara';
$pluginLangFile['field_website'] = 'Website';
$pluginLangFile['field_email'] = 'E-Mail';
$pluginLangFile['field_phone'] = 'Telefon';
$pluginLangFile['field_fax'] = 'Fax';
$pluginLangFile['field_message'] = 'Mesaj';
$pluginLangFile['field_captcha'] = 'Introduceti cifrele in urmatorul camp.';
$pluginLangFile['button_send'] = 'TRIMITE';

$pluginLangFile['message_subject'] = 'Formular contact'; // Websitetitle contact form
$pluginLangFile['message_title1'] = 'Ai primit un mesaj de la'; // You get a mesage from the Website title contact formular
$pluginLangFile['message_title2'] = 'formular contact';
$pluginLangFile['message_block1_title'] = 'MESSAGE';
$pluginLangFile['message_block2_title'] = 'FROM';
$pluginLangFile['message_senddate'] = 'Send on'; // Send on dd.mm.yyyy at 12:00
$pluginLangFile['message_sendtime'] = 'at';
$pluginLangFile['message_address'] = 'Address';


// -----------------------------------------------------------------------------------------------
// RETURN ****************************************************************************************
// -----------------------------------------------------------------------------------------------
return $pluginLangFile;

?>