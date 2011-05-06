<?php
/**
 * @package [Plugins]
 * @subpackage imageGallery
 * 
 * If the key contains "url","path","number","bool" or "text" it will uses these XssFilter to check the values.
 * If none of this keywords is present it uses the {@link XssFilter::text} filter.
 * Bool filter will be detected automatically by an boolean value.
 * 
 * <b>Note</b>: the check is not case sensitive (means "path" and "Path" is the same).
 *  
 * Example
 * $pluginConfig['linkpath'] = ''; // would use the path filter
 * 
 * @see XssFilter::url
 * @see XssFilter::path
 * @see XssFilter::number
 * @see XssFilter::bool
 * @see XssFilter::text
 */ 

$pluginConfig['recipient'] = 'name@providor.net';
$pluginConfig['appellation'] = true;
$pluginConfig['appellation_mandatory'] = false;
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