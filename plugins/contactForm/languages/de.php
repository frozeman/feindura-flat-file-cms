<?php
/**
 * GERMAN (DE) plugin language file
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

$pluginLangFile['feinduraPlugin_title']        = 'Kontaktformular';
$pluginLangFile['feinduraPlugin_description']  = 'Erzeugt ein Kontaktformular zum senden von E-Mails.';

/* CONFIG ************************************************************************************ */

$pluginLangFile['captcha'] = 'Verwende Captcha';
$pluginLangFile['recipient'] = 'Empf&auml;nger';
$pluginLangFile['appellation'] = 'Anrede anzeigen';
$pluginLangFile['appellation_mandatory'] = 'Anrede als Pflichfeld?';
$pluginLangFile['firstname'] = 'Vorname anzeigen';
$pluginLangFile['firstname_mandatory'] = 'Vorname als Pflichfeld?';
$pluginLangFile['lastname'] = 'Nachname anzeigen';
$pluginLangFile['lastname_mandatory'] = 'Nachname als Pflichfeld?';
$pluginLangFile['company'] = 'Firma anzeigen';
$pluginLangFile['company_mandatory'] = 'Firma als Pflichfeld?';
$pluginLangFile['street'] = 'Strasse anzeigen';
$pluginLangFile['street_mandatory'] = 'Strasse als Pflichfeld?';
$pluginLangFile['housenumber'] = 'Hausnummer anzeigen';
$pluginLangFile['housenumber_mandatory'] = 'Hausnummer als Pflichfeld?';
$pluginLangFile['zipcode'] = 'PLZ anzeigen';
$pluginLangFile['zipcode_mandatory'] = 'PLZ als Pflichfeld?';
$pluginLangFile['city'] = 'Ort anzeigen';
$pluginLangFile['city_mandatory'] = 'Ort als Pflichfeld?';
$pluginLangFile['country'] = 'Land anzeigen';
$pluginLangFile['country_mandatory'] = 'Land als Pflichfeld?';
$pluginLangFile['website'] = 'Webseite anzeigen';
$pluginLangFile['website_mandatory'] = 'Webseite als Pflichfeld?';
$pluginLangFile['email'] = 'E-Mail anzeigen';
$pluginLangFile['email_mandatory'] = 'E-Mail als Pflichfeld?';
$pluginLangFile['phone'] = 'Telefon anzeigen';
$pluginLangFile['phone_mandatory'] = 'Telefon als Pflichfeld?';
$pluginLangFile['fax'] = 'Fax anzeigen';
$pluginLangFile['fax_mandatory'] = 'Fax als Pflichfeld?';

/* CONTACTFORM ******************************************************************************* */

$pluginLangFile['form_title'] = 'Kontaktformular';
$pluginLangFile['form_send'] = 'Ihre Nachricht wurde erfolgreich verschickt!';
$pluginLangFile['link_back'] = 'Zur&uuml;ck';
$pluginLangFile['text_mandatoryfields'] = 'Notwendige Angaben';
$pluginLangFile['error_mandatoryfields'] = 'Folgende Felder m&uuml;ssen noch ausgef&uuml;llt werden:';
$pluginLangFile['error_captcha'] = '<b>Zahlenverifikation fehlgeschlagen!</b><br>Bitte &uuml;berpr&uuml;fe die 4-stellige Zahlenverifikation.';
$pluginLangFile['field_appellation'] = 'Anrede';
$pluginLangFile['field_appellation_man'] = 'Herr';
$pluginLangFile['field_appellation_woman'] = 'Frau';
$pluginLangFile['field_firstname'] = 'Vorname';
$pluginLangFile['field_lastname'] = 'Nachname';
$pluginLangFile['field_company'] = 'Firma';
$pluginLangFile['field_street'] = 'Strasse';
$pluginLangFile['field_housenumber'] = 'Nr.';
$pluginLangFile['field_zipcode'] = 'PLZ';
$pluginLangFile['field_city'] = 'Ort';
$pluginLangFile['field_country'] = 'Land';
$pluginLangFile['field_website'] = 'Webseite';
$pluginLangFile['field_email'] = 'E-Mail';
$pluginLangFile['field_phone'] = 'Telefon';
$pluginLangFile['field_fax'] = 'Fax';
$pluginLangFile['field_message'] = 'Nachricht';
$pluginLangFile['field_captcha'] = '&Uuml;bertrage bitte die Zahl in das Feld.';
$pluginLangFile['button_send'] = 'SENDEN';

$pluginLangFile['message_subject'] = 'Kontaktformular'; // Websitetitle contact form
$pluginLangFile['message_title1'] = 'Ihnen wurde eine Nachricht vom'; // You get a mesage from the Website title contact formular
$pluginLangFile['message_title2'] = 'Kontaktformular zugesendet';
$pluginLangFile['message_block1_title'] = 'NACHRICHT';
$pluginLangFile['message_block2_title'] = 'VON';
$pluginLangFile['message_senddate'] = 'Gesendet am'; // Send on dd.mm.yyyy at 12:00
$pluginLangFile['message_sendtime'] = 'um';
$pluginLangFile['message_address'] = 'Anschrift';


// -----------------------------------------------------------------------------------------------
// RETURN ****************************************************************************************
// -----------------------------------------------------------------------------------------------
return $pluginLangFile;

?>