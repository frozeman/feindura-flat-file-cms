<?php
/**
 * ENGLISH (EN) plugin language file
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

$pluginLangFile['feinduraPlugin_title']        = 'Contact Form';
$pluginLangFile['feinduraPlugin_description']  = 'Creates a contact form to send emails.';

/* CONFIG ************************************************************************************ */

$pluginLangFile['captcha'] = 'use captcha';
$pluginLangFile['recipient'] = 'Recipient';
$pluginLangFile['appellation'] = 'show appellation';
$pluginLangFile['appellation_mandatory'] = 'appellation is mandatory?';
$pluginLangFile['firstname'] = 'show first name';
$pluginLangFile['firstname_mandatory'] = 'first name is mandatory?';
$pluginLangFile['lastname'] = 'show last name';
$pluginLangFile['lastname_mandatory'] = 'last name is mandatory?';
$pluginLangFile['company'] = 'show company';
$pluginLangFile['company_mandatory'] = 'company is mandatory?';
$pluginLangFile['street'] = 'show street';
$pluginLangFile['street_mandatory'] = 'street is mandatory?';
$pluginLangFile['housenumber'] = 'show house number';
$pluginLangFile['housenumber_mandatory'] = 'house number is mandatory?';
$pluginLangFile['zipcode'] = 'show zipcode';
$pluginLangFile['zipcode_mandatory'] = 'zipcode is mandatory?';
$pluginLangFile['city'] = 'show city';
$pluginLangFile['city_mandatory'] = 'city is mandatory?';
$pluginLangFile['country'] = 'show country';
$pluginLangFile['country_mandatory'] = 'country is mandatory?';
$pluginLangFile['website'] = 'show website';
$pluginLangFile['website_mandatory'] = 'website is mandatory?';
$pluginLangFile['email'] = 'show e-mail';
$pluginLangFile['email_mandatory'] = 'e-mail is mandatory?';
$pluginLangFile['phone'] = 'show phone';
$pluginLangFile['phone_mandatory'] = 'phone is mandatory?';
$pluginLangFile['fax'] = 'show fax';
$pluginLangFile['fax_mandatory'] = 'fax is mandatory?';

/* CONTACTFORM ******************************************************************************* */

$pluginLangFile['form_title'] = 'Contact Form';
$pluginLangFile['form_send'] = 'Youre message was succesfully sent!';
$pluginLangFile['link_back'] = 'back';
$pluginLangFile['text_mandatoryfields'] = 'Mandatory information';
$pluginLangFile['error_mandatoryfields'] = 'The following fields have to be filled:';
$pluginLangFile['error_captcha'] = '<b>Number verification failed!</b><br>Please check the 4-digit verification number.';
$pluginLangFile['field_appellation'] = 'appellation';
$pluginLangFile['field_appellation_man'] = 'Mr';
$pluginLangFile['field_appellation_woman'] = 'Mrs';
$pluginLangFile['field_firstname'] = 'First Name';
$pluginLangFile['field_lastname'] = 'Last Name';
$pluginLangFile['field_company'] = 'Company';
$pluginLangFile['field_street'] = 'Street';
$pluginLangFile['field_housenumber'] = 'Number';
$pluginLangFile['field_zipcode'] = 'Zipcode';
$pluginLangFile['field_city'] = 'City';
$pluginLangFile['field_country'] = 'Country';
$pluginLangFile['field_website'] = 'Website';
$pluginLangFile['field_email'] = 'E-Mail';
$pluginLangFile['field_phone'] = 'Phone';
$pluginLangFile['field_fax'] = 'Fax';
$pluginLangFile['field_message'] = 'Message';
$pluginLangFile['field_captcha'] = 'Please enter the number into the field.';
$pluginLangFile['button_send'] = 'SEND';

$pluginLangFile['message_subject'] = 'contact form'; // Websitetitle contact form
$pluginLangFile['message_title1'] = 'You got a mesage from the'; // You get a mesage from the Website title contact form
$pluginLangFile['message_title2'] = 'contact form';
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