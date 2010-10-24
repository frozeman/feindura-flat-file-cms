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
 * This file contains the {@link xssFilter} class.
 * 
 * @package [Implementation]-[Backend]
 * 
 */

/**
* <b>Classname</b> xssFilter<br>
* 
* Provides a set of filters, to filter data from possible xss attacks
* based on the PHP Secure Class to prevent XSS Attacks from {@link http://www.webkami.com/programming/php/php-secure-class-to-avoid-xss/php-secure-class-to-avoid-xss-1-0-2.php},
* but it's a complete rewrite.
* 
* <b>Notice</b>: this class will be used by the implementation classes AND the backend of the feindura-CMS.
* 
* @package [Implementation]-[Backend]
* 
* @version 0.11
* <br>
*  <b>ChangeLog</b><br>
*    - 0.11 changed to preg_match_all
*    - 0.1 initial release
* 
*/ 
class xssFilter {
 
 /* ---------------------------------------------------------------------------------------------------------------------------- */
 /* *** PROPERTIES *** */
 /* **************************************************************************************************************************** */
 
 // PUBLIC
 // *********
 
  /**
  * Contains the administrator-settings config <var>array</var>
  * 
  * @var array
  * @see generalFunctions()
  * 
  */ 
  var $adminConfig;
  
 
 /* ---------------------------------------------------------------------------------------------------------------------------- */
 /* *** CONSTRUCTOR *** */
 /* **************************************************************************************************************************** */
  
 /**
  * <b> Type</b>      constructor<br>
  * <b> Name</b>      xssFilter()<br><br>
  * The constructor of the class, does nothing.
  * 
  * @return void
  * 
  * @version 1.01
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.01 add $adminConfig and $categoryConfig and creates an instance of the generalFunctions class
  *    - 1.0 initial release
  * 
  */ 
  function xssFilter() {
  }
  
 /* ---------------------------------------------------------------------------------------------------------------------------- */
 /* *** METHODS *** */
 /* **************************************************************************************************************************** */
  
 /**
  * <b>Name</b> int()<br>
  * 
  * Check if the data is a integer.
  * 
  * @param int $data     the data to check against
  * @param int $default  (optional) the default value return if the $data parameter couldn't be validated
  * 
  * @return int the integer, otherwise FALSE
  *   
  * @version 1.0
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.0 initial release
  * 
  */
  function int($data, $default = false) {
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
  * @param int    $default  (optional) the default value return if the $data parameter couldn't be validated
  * 
  * @return number the integer, otherwise FALSE
  * 
  * @version 1.0
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.0 initial release
  * 
  */
  function float($data, $default = false) {
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
  * <sample>
  * Test-Name 123
  * </sample>
  * 
  * @param string $data     the data to check against
  * @param int    $max      (optional) the maximal number of characters returned
  * @param null   $default  (optional) the default value return if the $data parameter couldn't be validated  
  * 
  * @return string|number|null an alphabetical string or number, otherwise FALSE
  * 
  * @version 1.0
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.0 initial release
  * 
  */
  function string($data, $max = 0, $default = false) {
      if(!empty($data) || $data == 0) {
         //start with aplhabetic, may include space, end with alhabetic
         preg_match_all("/[\(\)\[\]\,\.\-\$\&\£\s@\?#_a-zA-Z\d]+/",$data,$find); 
         //if you have caught something as alphabetic with/without space, return it 
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
  * @param int    $max      (optional) the maximal number of characters returned
  * @param null   $default  (optional) the default value return if the $data parameter couldn't be validated  
  * 
  * @return string|null an alphabetical string, otherwise FALSE
  * 
  * @version 1.0
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.0 initial release
  * 
  */
  function alphabetical($data, $max = 0, $default = false) {
     if(!empty($data) || $data == 0) {
        preg_match_all("/[A-Za-z]+/",$data,$find); //check strictly there is one alphabetic at least
        if(!empty($find[0])) {
          $find = implode('',$find[0]);
          return ($max > 0) 
           ? substr($find,0,$max) // truncate the length
           : $find;
        }
     }
     return $default;
  }

  
 /**
  * <b>Name</b> filename()<br>
  * 
  * Check if the data is filename string.
  * 
  * <sample>
  * file.php
  * </sample>
  * 
  * @param string $data    the data to check against
  * @param bool   $encode  (optional) tell if the filename should be urlencoded before
  * @param null   $default (optional) the default value return if the $data parameter couldn't be validated  
  * 
  * @return int|false a filename string, otherwise FALSE
  * 
  * @version 1.0
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.0 initial release
  * 
  */
  function filename($data, $encode = false, $default = false){
     if(!empty($data) || $data == 0) {
        $data = ($encode) ? urlencode($data) : $data;        
        preg_match_all("/^[\.\-\s#_a-zA-Z\d]+$/",$data,$find);          
         if(!empty($find[0])) {
            return $find[0];
         }
     }
     return $default;
  }
  
 /**
  * <b>Name</b> path()<br>
  * 
  * Check if the data is local path string.
  * The path cannot have "//" or ".."
  * 
  * <sample>
  * /path/to/example/file.php
  * </sample>
  * 
  * @param int  $data    the data to check against
  * @param bool $encode  (optional) tell if the filename should be urlencoded before
  * @param null $default (optional) the default value return if the $data parameter couldn't be validated  
  *      
  * @return int|false a path string, otherwise FALSE
  * 
  * @version 1.0
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.0 initial release
  * 
  */
  function path($data, $encode = false, $default = false){
     if(!empty($data) || $data == 0) {
        $data = ($encode) ? urlencode($data) : $data;
        preg_match_all("/^[/\.\-\s_a-zA-Z\d][\/\.\-\s_a-zA-Z\d]*$/",$data,$find); 
         if (!empty($find)) {
           preg_match_all("/\/\/|\.\./",$find[0],$findCatch); // disallow // or ..
           if(!empty($findCatch))
            return $default;
           else
            return $find[0];
         }
     }
     return $default;
  }
  
 /**
  * <b>Name</b> alphaSpace()<br>
  * 
  * Check if the data is a alphabetical string, allowing spaces.
  * 
  * <sample>
  * Fred Hubert
  * </sample>
  * 
  * @param string $data     the data to check against
  * @param int    $max      (optional) the maximal number of characters returned
  * @param null   $default  (optional) the default value return if the $data parameter couldn't be validated  
  * 
  * @return string|null an alphabetical string allowing spaces, otherwise FALSE
  * 
  * @version 1.0
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.0 initial release
  * 
  */
  function alphaSpace($data, $max = 0, $default = false) {
      if(!empty($data) || $data == 0) {
         preg_match_all("/[A-Za-z]([A-Za-z\s]*[A-Za-z])*/",$data,$find); 
         if(!empty($find[0])) {
          $find = implode('',$find[0]);
          return ($max > 0) 
           ? substr($find,0,$max) // truncate the length
           : $find;
        }
     }
     return $default;
  }
  
 /**
  * <b>Name</b> alphaNumeric()<br>
  * 
  * Check if the data is a alphanumerical string.
  * 
  * <sample>
  * user123
  * </sample>
  * 
  * @param string $data     the data to check against
  * @param int    $max      (optional) the maximal number of characters returned
  * @param null   $default  (optional) the default value return if the $data parameter couldn't be validated  
  * 
  * @return string|null an alphanumerical string, otherwise FALSE
  * 
  * @version 1.0
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.0 initial release
  * 
  */
  function alphaNumeric($data, $max = 0, $default = false) {
      if(!empty($data) || $data == 0) {
         preg_match_all("/[A-Za-z0-9][A-Za-z0-9]*/",$data,$find); 
         if(!empty($find[0])) {
          $find = implode('',$find[0]);
          return ($max > 0) 
           ? substr($find,0,$max) // truncate the length
           : $find;
         }
     }
     return $default;
  }
  
 /**
  * <b>Name</b> alphaNumericSpace()<br>
  * 
  * Check if the data is a alphanumerical string, allowing spaces.
  * 
  * <sample>
  * Fake Name 123
  * </sample>
  * 
  * @param string $data     the data to check against
  * @param int    $max      (optional) the maximal number of characters returned
  * @param null   $default  (optional) the default value return if the $data parameter couldn't be validated  
  * 
  * @return string|null an alphanumerical string allowing spaces, otherwise FALSE
  * 
  * @version 1.0
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.0 initial release
  * 
  */
  function alphaNumericSpace($data, $max = 0, $default = false) {
      if(!empty($data) || $data == 0) {
         preg_match_all("/[A-Za-z0-9]([A-Za-z0-9\s]*[A-Za-z0-9])*/",$data,$find); 
         if(!empty($find[0])) {
          $find = implode('',$find[0]);
          return ($max > 0) 
           ? substr($find,0,$max) // truncate the length
           : $find;
         }
     }
     return $default;
  }

 /**
  * <b>Name</b> alpha_Numeric()<br>
  * 
  * Check if the data is a alphanumerical string, allowing underscores "_" but no spaces.
  * 
  * <sample>
  * Product_With_Color123
  * </sample>
  * 
  * @param string $data     the data to check against
  * @param int    $max      (optional) the maximal number of characters returned
  * @param null   $default  (optional) the default value return if the $data parameter couldn't be validated  
  * 
  * @return string|null an alphanumerical string allowing underscores, otherwise FALSE
  * 
  * @version 1.0
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.0 initial release
  * 
  */
  function alpha_Numeric($data, $max = 0, $default = false) {
      if(!empty($data) || $data == 0) {
         preg_match_all("/[A-Za-z0-9]([A-Za-z0-9\s]*[A-Za-z0-9])*/",$data,$find); 
         if(!empty($find[0])) {
          $find = implode('',$find[0]);
          return ($max > 0) 
           ? substr($find,0,$max) // truncate the length
           : $find;
         }
     }
     return $default;
  }

 /**
  * <b>Name</b> alpha_NumericSpace()<br>
  * 
  * Check if the data is a alphanumerical string, allowing underscores "_" and spaces.
  * 
  * <sample>
  * Product_With_Color 123
  * </sample>
  * 
  * @param string $data     the data to check against
  * @param int    $max      (optional) the maximal number of characters returned
  * @param null   $default  (optional) the default value return if the $data parameter couldn't be validated  
  * 
  * @return string|null an alphanumerical string allowing underscores and spaces, otherwise FALSE
  * 
  * @version 1.0
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.0 initial release
  * 
  */
  function alpha_NumericSpace($data, $max = 0, $default = false) {
      if(!empty($data) || $data == 0) {
         preg_match_all("/[A-Za-z0-9]([A-Za-z0-9\s_]*[A-Za-z0-9])*/",$data,$find); 
         if(!empty($find[0])) {
          $find = implode('',$find[0]);
          return ($max > 0) 
           ? substr($find,0,$max) // truncate the length
           : $find;
         }
     }
     return $default;
  }

 /**
  * <b>Name</b> textVar()<br>
  * 
  * Change the HTML important signs to htmlentities with the htmlspecialchars function.
  * 
  * <sample>
  * Text &lt;a href=&quot;test&quot;&gt; other text
  * </sample>
  * 
  * @param string $data     the data to check against
  * @param int    $max      (optional) the maximal number of characters returned
  * @param string $charset  (optional) the charset used by the htmlspecialchars function  
  * @param null   $default  (optional) the default value return if the $data parameter couldn't be validated  
  * 
  * @return string|null an alphanumerical string allowing underscores and spaces, otherwise FALSE
  * 
  * @version 1.0
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.0 initial release
  * 
  */
  function textVar($data, $max = 0, $charset = 'UTF-8' ,$default = false) {
      if(!empty($data) || $data == 0) {
        $data = stripslashes($data);
        $data = str_replace('/','&#47;',$data);
        $data = str_replace('\\','&#92;',$data);
        $data = str_replace('=','&#61;',$data);
        $data = str_replace(';','&#59;',$data);
        $data = htmlentities($data,ENT_QUOTES,$charset);
        return ($max > 0)
          ? substr($data,0,$max) // truncate the length
          : $data;
     }
     return $default;
  }

}

?>