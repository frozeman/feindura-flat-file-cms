<?php
/**
 * @package [Plugins]
 * @subpackage pageRating
 * 
 * If the key contains "url","path","number","bool" or "text" it will uses these xssFilter to check the values.
 * If none of this keywords is present it uses the {@link xssFilter::text} filter.
 * Bool filter will be detected automatically by an boolean value.
 * 
 * <b>Note</b>: the check is not case sensitive (means "path" and "Path" is the same).
 *  
 * Example
 * $pluginConfig['linkpath'] = ''; // would use the path filter
 * 
 * @see xssFilter::url
 * @see xssFilter::path
 * @see xssFilter::number
 * @see xssFilter::bool
 * @see xssFilter::text
 */ 

$pluginConfig['valueNumber']   = 0;
$pluginConfig['votesNumber']   = 0;

return $pluginConfig;
?>