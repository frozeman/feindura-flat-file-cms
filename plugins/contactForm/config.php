<?php
/**
 * @package [Plugins]
 * @subpackage imageGallery
 */ 

$pluginConfig['recipient'] = 'name@providor.net';
$pluginConfig['appellation'] = true;
$pluginConfig['appellation_mandatory'] = true;
$pluginConfig['firstname'] = true;
$pluginConfig['firstname_mandatory'] = true;
$pluginConfig['lastname'] = true;
$pluginConfig['lastname_mandatory'] = true;
$pluginConfig['company'] = false;
$pluginConfig['company_mandatory'] = false;
$pluginConfig['street'] = false;
$pluginConfig['street_mandatory'] = false;
$pluginConfig['housenumber'] = false;
$pluginConfig['housenumber_mandatory'] = false;
$pluginConfig['zipcode'] = false;
$pluginConfig['zipcode_mandatory'] = false;
$pluginConfig['city'] = false;
$pluginConfig['city_mandatory'] = false;
$pluginConfig['country'] = false;
$pluginConfig['country_mandatory'] = false;
$pluginConfig['website'] = true;
$pluginConfig['website_mandatory'] = false;
$pluginConfig['email'] = true;
$pluginConfig['email_mandatory'] = true;
$pluginConfig['phone'] = true;
$pluginConfig['phone_mandatory'] = false;
$pluginConfig['fax'] = false;
$pluginConfig['fax_mandatory'] = false;

return $pluginConfig;
?>