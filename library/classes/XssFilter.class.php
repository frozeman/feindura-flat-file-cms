<?php
/*
 * feindura - Flat File Content Management System
 * Copyright (C) Fabian Vogelsteller [frozeman.de]
 *
 * This program is free software;
 * you can redistribute it and/or modify it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY;
 * without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 * See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with this program;
 * if not,see <http://www.gnu.org/licenses/>.
 */
/**
 * This file contains the {@link XssFilter} class.
 *
 * @package [Implementation]-[Backend]
 *
 */

/**
* <b>Classname</b> XssFilter<br>
*
* Provides a set of filters, to filter data from possible xss attacks
* based on the PHP Secure Class to prevent XSS Attacks from {@link http://www.webkami.com/programming/php/php-secure-class-to-avoid-xss/php-secure-class-to-avoid-xss-1-0-2.php},
* but it's a complete rewrite.
*
* <b>Note</b>: this class will be used by the implementation classes AND the backend of the feindura-CMS.
*
* @package [Implementation]-[Backend]
*
* @author Fabian Vogelsteller
*
* @since feindura version 1.1
*
* @version 0.1.3
* <br>
*  <b>ChangeLog</b><br>
*    - 0.1.3 replaced alphaNumeric xss filters with stringStrict filter
*    - 0.1.2 change to static class
*    - 0.1.1 changed to preg_match_all
*    - 0.1 initial release
*
*/
class XssFilter {

 /* ---------------------------------------------------------------------------------------------------------------------------- */
 /* *** CONSTRUCTOR *** */
 /* **************************************************************************************************************************** */

 /**
  * <b> Type</b>      constructor<br>
  *
  * Constructor is not callable, {@link XssFilter::init()} is used instead.
  *
  * @return void
  *
  * @version 1.0
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.0 initial release
  *
  */
  private function __construct() {
  }

 /* ---------------------------------------------------------------------------------------------------------------------------- */
 /* *** METHODS *** */
 /* **************************************************************************************************************************** */

 /**
  * <b>Name</b> escapeBasics()<br>
  *
  * Escapes basic chars like \ and ' .
  *
  * @param array $array the data to escape the \ and '
  *
  * @return string the escaped string
  *
  * @static
  * @version 1.0
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.0 initial release
  *
  */
  public static function escapeBasics($array) {
    if(is_array($array)) {
      foreach($array as $key => &$value)
        if(is_array($value)) $value = self::escapeBasics($value);
        else {
          if(is_bool($value) || is_numeric($value))
            $array[$key] = $value;
          else {
            $value = GeneralFunctions::smartStripslashes($value);
            $value = addslashes($value);
            $value = str_replace('\"','"',$value);
            $array[$key] = $value;
          }
        }
    }
    return $array;
  }

 /**
  * <b>Name</b> bool()<br>
  *
  * Check if the data is a boolean.
  *
  * @param bool|string $data            the data to check against
  * @param bool        $returnAsString  (optional) if TRUE it returns the bool as a string like: "true" or "false"
  * @param mixed       $default         (optional) the default value return if the $data parameter couldn't be validated
  *
  * @return bool the right boolean, otherwise $default
  *
  * @static
  * @version 1.0.1
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.0.1 fixed checking and returning string
  *    - 1.0 initial release
  *
  */
  public static function bool($data, $returnAsString = false ,$default = false) {
    if(is_bool($data)) {
      if($data)
        return ($returnAsString) ? 'true' : true;
      else
        return ($returnAsString) ? 'false' : false;
    } elseif(isset($data) && !empty($data) && (strtolower($data) == 'true' || $data == '1'))
      return ($returnAsString) ? 'true' : true;
    elseif(!isset($data) || empty($data) || strtolower($data) == 'false' || $data == '0')
      return ($returnAsString) ? 'false' : false;
    else {
      if($default)
        return ($returnAsString) ? 'true' : true;
      else
        return ($returnAsString) ? 'false' : false;
    }
  }

 /**
  * <b>Name</b> number()<br>
  *
  * Check if the data is a number.
  *
  * @param int   $data     the data to check against
  * @param mixed $default  (optional) the default value return if the $data parameter couldn't be validated
  *
  * @return int the integer, otherwise FALSE
  *
  * @static
  * @version 1.0
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.0 initial release
  *
  */
  public static function number($data, $default = 0) {
    if(!empty($data) || $data == 0)
      return (is_numeric($data)) ? $data : $default;
    else
      return $default;
  }

 /**
  * <b>Name</b> int()<br>
  *
  * Check if the data is a integer.
  *
  * @param int   $data     the data to check against
  * @param mixed $default  (optional) the default value return if the $data parameter couldn't be validated
  *
  * @return int the integer, otherwise FALSE
  *
  * @static
  * @version 1.0
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.0 initial release
  *
  */
  public static function int($data, $default = 0) {
    if(!empty($data) || $data == 0)
      return (is_numeric($data)) ? (int)$data : $default;
    else
      return $default;
  }

 /**
  * <b>Name</b> float()<br>
  *
  * Check if the data is a float.
  *
  * @param number $data     the data to check against
  * @param mixed  $default  (optional) the default value return if the $data parameter couldn't be validated
  *
  * @return number the integer, otherwise FALSE
  *
  * @static
  * @version 1.0
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.0 initial release
  *
  */
  public static function float($data, $default = 0) {
     if(!empty($data) || $data == 0)
      return (is_numeric($data)) ? (float)$data : $default;
    else
      return $default;
  }

 /**
  * <b>Name</b> alphaOrNumeric()<br>
  *
  * Check if the data is alphanumeric string with some special chars.
  * Allowed chars are:
  *     - ()
  *     - []
  *     - '
  *     - ,
  *     - .
  *     - $
  *     - &
  *     - £
  *     - @
  *     - ?
  *     - #
  *     - _
  *     - -
  *
  * <samp>
  * Test-Name 123
  * </sample>
  *
  * @param string       $data     the data to check against
  * @param string|null  $addChars (optional) a string with allowed characters (they are implemented in a regex so some chars have to be escaped like: "\$")
  * @param mixed        $default  (optional) the default value return if the $data parameter couldn't be validated
  *
  * @return string|number|null an alphabetical string or number, otherwise FALSE
  *
  * @static
  * @version 1.0
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.0 initial release
  *
  */
  public static function string($data, $addChars = null, $default = false) {
      if(!empty($data) || $data == 0) {
         // start with aplhabetic, may include space, end with alhabetic
         preg_match_all("/^['.$addChars.'\(\)\[\]\/\,\.\'\-\$\&\£\s@\?#_a-zA-Z\d]+$/i",$data,$find);
         // if you have caught something return it
         if(!empty($find[0])) return implode('',$find[0]);
     }
     return $default;
  }

 /**
  * <b>Name</b> stringStrict()<br>
  *
  * Check if the data is a alphanumerical string, allowing only underscores "_" and spaces.
  *
  * <samp>
  * Product_With_Color 123
  * </sample>
  *
  * @param string $data     the data to check against
  * @param mixed  $default  (optional) the default value return if the $data parameter couldn't be validated
  *
  * @return string|null an alphanumerical string allowing underscores and spaces, otherwise FALSE
  *
  * @static
  * @version 1.0
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.0 initial release
  *
  */
  public static function stringStrict($data, $default = false) {
      if(!empty($data) || $data == 0) {
         preg_match_all("#^[A-Za-z0-9]([A-Za-z0-9\s_]*[A-Za-z0-9])*$#i",$data,$find);
         if(!empty($find[0])) return implode('',$find[0]);
     }
     return $default;
  }

 /**
  * <b>Name</b> alphabetical()<br>
  *
  * Check if the data is a alphabetical string.
  *
  * @param string $data     the data to check against
  * @param mixed  $default  (optional) the default value return if the $data parameter couldn't be validated
  *
  * @return string|null an alphabetical string, otherwise FALSE
  *
  * @static
  * @version 1.0
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.0 initial release
  *
  */
  public static function alphabetical($data, $default = false) {
     if(!empty($data)) {
        preg_match_all("#^[A-Za-z]+$#i",$data,$find); //check strictly there is one alphabetic at least
        if(!empty($find[0])) return implode('',$find[0]);
     }
     return $default;
  }


 /**
  * <b>Name</b> filename()<br>
  *
  * Check if the data is filename string.
  *
  * <samp>
  * file_n-am e1.php
  * </sample>
  *
  * @param string $data    the data to check against
  * @param bool   $encode  (optional) tell if the filename should be urlencoded before
  * @param mixed  $default (optional) the default value return if the $data parameter couldn't be validated
  *
  * @return int|false a filename string, otherwise FALSE
  *
  * @static
  * @version 1.0
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.0 initial release
  *
  */
  public static function filename($data, $encode = false, $default = false){
     if(!empty($data) || $data == 0) {
        $data = ($encode) ? urlencode($data) : $data;
        preg_match_all("/^[\.\-\s#_a-zA-Z\d]+$/i",$data,$find);
        if(!empty($find[0])) return implode('',$find[0]);
     }
     return $default;
  }

 /**
  * <b>Name</b> path()<br>
  *
  * Check if the data is local path string.
  * The path cannot have ".." .
  *
  * <samp>
  * /path/to/example/file.php
  * </sample>
  *
  * @param int   $data    the data to check against
  * @param bool  $encode  (optional) whether the path should be urlencoded before
  * @param mixed $default (optional) the default value return if the $data parameter couldn't be validated
  *
  * @return int|false a path string, otherwise FALSE
  *
  * @static
  * @version 1.0
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.0 initial release
  *
  */
  public static function path($data, $encode = false, $default = false){
     if(!empty($data) || $data == 0) {
        preg_match("#^[~\:\\\/\.\-\s_a-zA-Z\d]*$#i",$data,$find);
         if (!empty($find[0])) {
           preg_match("#\.\.#",$find[0],$findCatch); // disallow ".."
           $data = preg_replace('#/+#','/',$find[0]);
           if(!empty($findCatch))
            return $default;
           else
            return ($encode) ? urlencode($data) : $data;
         }
     }
     return $default;
  }

 /**
  * <b>Name</b> url()<br>
  *
  * Check if the data is a URL.
  * The path cannot have ".." .
  *
  * <samp>
  * http://path/to/example/file.php?var=value
  * </sample>
  *
  * @param int   $data    the data to check against
  * @param bool  $encode  (optional) whether the path should be urlencoded before
  * @param mixed $default (optional) the default value return if the $data parameter couldn't be validated
  *
  * @return int|false a path string, otherwise FALSE
  *
  * @static
  * @version 1.0
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.0 initial release
  *
  */
  public static function url($data, $encode = false, $default = false){
     if(!empty($data) || $data == 0) {
        preg_match("#^[a-zA-Z]+[:]{1}[\/\/]{2}[A-Za-z0-9ßöäüÖÄÜ\-_]+\.*[\+\[\]A-Za-z0-9\.\/|:%&\#\=\?\-_]+$#iu",$data,$find);
         if (!empty($find[0])) {
           preg_match("#\.\.#",$find[0],$findCatch); // disallow ".."
           $data = preg_replace('#/{2,}#','//',$find[0]);
           if(!empty($findCatch))
            return $default;
           else
            return ($encode) ? urlencode($data) : $data;
         }
     }
     return $default;
  }

 /**
  * <b>Name</b> text()<br>
  *
  * Change the HTML important signs to htmlspecialchars with the htmlspecialchars() function.
  *
  * <samp>
  * Text &lt;a href=&quot;test&quot;&gt; other text
  * </samp>
  *
  * @param string  $data     the data to check against
  * @param string  $charset  (optional) the charset used by the htmlspecialchars public static function
  * @param mixed   $default  (optional) the default value return if the $data parameter couldn't be validated
  *
  * @return string|null an alphanumerical string allowing underscores and spaces, otherwise FALSE
  *
  * @static
  * @version 1.0
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.0 initial release
  *
  */
  public static function text($data, $charset = 'UTF-8' ,$default = false) {
      if(!empty($data) || $data == 0) {

        //$data = htmlspecialchars_decode($data,ENT_QUOTES);
        //$data = str_replace(';','&#59;',$data);
        //$data = htmlspecialchars($data,ENT_QUOTES,$charset);
        //$data = str_replace(array('&amp;#59;','\\','=','&#92;&#039;'),array('&#59;','&#92;','&#61;','&#039;'),$data);
        $data = str_replace(array(
          '>',
          '<',
          '=',
          ':',
          "\'",
          "'",
          '"',
          //"\\"
          ),array(
          '&gt;',
          '&lt;',
          '&#61;',
          '&#58;',
          '&#39;',
          '&#39;',
          '&#34;',
          //'&#92;'
          ),$data);

        //$data = preg_replace('#(\&\#92\;)+#','&#92;',$data);
        return $data;
     }
     return $default;
  }
}

?>