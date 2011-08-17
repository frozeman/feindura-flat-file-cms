<?php
/**
 * @package [Plugins]
 * @subpackage pageRating
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

$pluginConfig['valueNumber']   = 0;
$pluginConfig['votesNumber']   = 0;

return $pluginConfig;
?>