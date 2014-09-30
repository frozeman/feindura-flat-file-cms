<?php
/**
 * @package [Plugins]
 * @subpackage slideShowFromFolder
 * 
 * If the key contains certain words, it will create different inputs. The check for this keywords in case insensitive (means "path" and "Path" is the same).
 * 
 * key contains (without the ...):<br>
 * - "...Url"                        The value of this setting will be checked by {@link XssFilter::url()}<br>
 * - "...Path"                       The value of this setting will be checked by {@link XssFilter::path()}<br>
 * - "...Number"                     The value of this setting will be checked by {@link XssFilter::number()}<br>
 * - "...Text" or nothing            The value of this setting will be checked by {@link XssFilter::text()}<br>
 * - "...Selection"                  Will create a <select>. value is also the name and should be an array like: array(0 => 'value1', 1 => 'value2')
 * - "...JsFunction"                 Creates a button, which will call a javascript function with this value as name, like <a href="#" onclick="exampleFunction(); return false;">
 * - "...Hidden"                     It will create a hidden text input field, with the setting value as input value
 * - "...Script"                     It will create a <script> tag with the value as content, before the plugin settings <table> tag.
 * - "...Print"                      It will just display this string after the last plugin setting ..</td></tr> and before the next <tr><td>... This could be used to create custom config settings in the plugin settings table.
 * - if the value is a boolean       It will create a checkbox and will check this value against {@link XssFilter::bool()}<br>
 * 
 *  
 * Example
 * <samp>
 * $pluginConfig['linkPath'] = ''; // would use the path filter
 * </samp>
 * 
 * @see XssFilter::url()
 * @see XssFilter::path()
 * @see XssFilter::number()
 * @see XssFilter::bool()
 * @see XssFilter::text()
 */ 

$pluginConfig['path']              = '';
$pluginConfig['imageWidthNumber']  = 800;
$pluginConfig['imageHeightNumber'] = null;
$pluginConfig['intervalNumber']    = 3;
// effects
$pluginConfig['effectSelection'][] = 'fade';
$pluginConfig['effectSelection'][] = 'fold';
$pluginConfig['effectSelection'][] = 'random';
// horizontal effects
$pluginConfig['effectSelection'][] = 'wipeDown';
$pluginConfig['effectSelection'][] = 'wipeUp';
$pluginConfig['effectSelection'][] = 'sliceLeftDown';
$pluginConfig['effectSelection'][] = 'sliceLeftUp';
$pluginConfig['effectSelection'][] = 'sliceLeftRightDown';
$pluginConfig['effectSelection'][] = 'sliceLeftRightUp';
$pluginConfig['effectSelection'][] = 'sliceRightDown';
$pluginConfig['effectSelection'][] = 'sliceRightUp';
// vertical effects
$pluginConfig['effectSelection'][] = 'wipeRight';
$pluginConfig['effectSelection'][] = 'wipeLeft';
$pluginConfig['effectSelection'][] = 'sliceDownLeft';
$pluginConfig['effectSelection'][] = 'sliceDownRight';
$pluginConfig['effectSelection'][] = 'sliceUpDownLeft';
$pluginConfig['effectSelection'][] = 'sliceUpDownRight';
$pluginConfig['effectSelection'][] = 'sliceUpLeft';
$pluginConfig['effectSelection'][] = 'sliceUpRight';

return $pluginConfig;
?>