<?php
/**
 * FRENCH (FR) plugin language file
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

$pluginLangFile['feinduraPlugin_title']        = 'fiche contact';
$pluginLangFile['feinduraPlugin_description']  = 'Cr&eacute;e un fiche contact pour envoyer un courrier &eacute;lectronique.';


/* CONFIG ************************************************************************************ */

$pluginLangFile['captcha'] = 'utilisez captcha';
$pluginLangFile['recipient'] = 'destinataire';
$pluginLangFile['appellation'] = 'montrer le titre';
$pluginLangFile['appellation_mandatory'] = 'titre comme champs obligatoire?';
$pluginLangFile['firstname'] = 'montrer pr&eacute;nom?';
$pluginLangFile['firstname_mandatory'] = 'pr&eacute;nom comme champs obligatoire?';
$pluginLangFile['lastname'] = 'montrer le nom de famille?';
$pluginLangFile['lastname_mandatory'] = 'nom de famille comme champs obligatoire?';
$pluginLangFile['company'] = 'montrer entreprise';
$pluginLangFile['company_mandatory'] = 'entreprise comme champs obligatoire?';
$pluginLangFile['street'] = 'montrer rue';
$pluginLangFile['street_mandatory'] = 'rue comme champs obligatoire?';
$pluginLangFile['housenumber'] = 'montrer num&eacute;ro';
$pluginLangFile['housenumber_mandatory'] = 'num&eacute;ro comme champs obligatoire?';
$pluginLangFile['zipcode'] = 'montrer code postale';
$pluginLangFile['zipcode_mandatory'] = 'code postale come champs obligatoire?';
$pluginLangFile['city'] = 'montrer ville';
$pluginLangFile['city_mandatory'] = 'ville comme champs obligatoire?';
$pluginLangFile['country'] = 'montrer pays';
$pluginLangFile['country_mandatory'] = 'pays comme champs obligatoire?';
$pluginLangFile['website'] = 'montrer site web';
$pluginLangFile['website_mandatory'] = 'site web comme champs obligatoire?';
$pluginLangFile['email'] = 'montrer adresse &eacute;lectronique';
$pluginLangFile['email_mandatory'] = 'adresse &eacute;lectronique comme champs obligatoire?';
$pluginLangFile['phone'] = 'montrer num&eacute;ro de t&eacute;l&eacute;phone';
$pluginLangFile['phone_mandatory'] = 'num&eacute;ro de t&eacute;l&eacute;phone comme champs obligatoire?';
$pluginLangFile['fax'] = 'montrer t&eacute;l&eacute;copie';
$pluginLangFile['fax_mandatory'] = 't&eacute;l&eacute;copie comme champs obligatoire?';


/* CONTACTFORM ******************************************************************************* */


$pluginLangFile['form_title'] = 'fiche contact';
$pluginLangFile['form_send'] = 'Votre courrier a &eacute;t&eacute; envoy&eacute; avec succ&egrave;s!';
$pluginLangFile['link_back'] = 'en arri&egrave;re';
$pluginLangFile['text_mandatoryfields'] = 'champs obligatoires';
$pluginLangFile['error_mandatoryfields'] = 'Les champs suivants doivent &ecirc;tre remplis:';
$pluginLangFile['error_captcha'] = '<b>V&eacute;rification a &eacute;t&eacute; &eacute;chou&eacute;!</b><br>SVP v&eacute;rifiez la v&eacute;rification a quatre num&eacute;ros.';
$pluginLangFile['field_appellation'] = 'Titre';
$pluginLangFile['field_appellation_man'] = 'Monsieur';
$pluginLangFile['field_appellation_woman'] = 'Madame';
$pluginLangFile['field_firstname'] = 'Pr&eacute;nom';
$pluginLangFile['field_lastname'] = 'Nom de famille';
$pluginLangFile['field_company'] = 'Entreprise';
$pluginLangFile['field_street'] = 'Adresse';
$pluginLangFile['field_housenumber'] = 'Num&eacute;ro';
$pluginLangFile['field_zipcode'] = 'Code postal';
$pluginLangFile['field_city'] = 'Ville';
$pluginLangFile['field_country'] = 'Pays';
$pluginLangFile['field_website'] = 'Site web';
$pluginLangFile['field_email'] = 'Adresse &eacute;lectronique';
$pluginLangFile['field_phone'] = 'T&eacute;l&eacute;phone';
$pluginLangFile['field_fax'] = 'T&eacute;l&eacute;copie';
$pluginLangFile['field_message'] = 'Courrier';
$pluginLangFile['field_captcha'] = 'SVP &eacute;crivez le chiffre dans le champs.';
$pluginLangFile['button_send'] = 'ENVOYER';

$pluginLangFile['message_subject'] = 'fiche contact'; // Websitetitle contact form
$pluginLangFile['message_title1'] = 'Vous avez recu un courrier'; // You get a mesage from the Website title contact formular
$pluginLangFile['message_title2'] = 'par votre fiche contact';
$pluginLangFile['message_block1_title'] = 'MESSAGE';
$pluginLangFile['message_block2_title'] = 'DE';
$pluginLangFile['message_senddate'] = 'Envoy&eacute; le'; // Send on dd.mm.yyyy at 12:00
$pluginLangFile['message_sendtime'] = '&agrave;';
$pluginLangFile['message_address'] = 'Adresse';


// -----------------------------------------------------------------------------------------------
// RETURN ****************************************************************************************
// -----------------------------------------------------------------------------------------------
return $pluginLangFile;

?>