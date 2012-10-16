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
 * This file contains the {@link DebugTools} class.
 *
 * @package [Implementation]-[Backend]
 */

/**
* <b>Classname</b> DebugTools<br>
*
* Contains some helpfull functions for debugging your scripts.
*
* <b>Note</b>: this class will be used by the implementation classes AND the backend of the feindura-CMS.
*
* @package [Implementation]-[Backend]
*
* @version 0.1
* <br>
*  <b>ChangeLog</b><br>
*    - 0.1 initial version
*/
class DebugTools {

 /* ---------------------------------------------------------------------------------------------------------------------------- */
 /* *** PROPERTIES *** */
 /* **************************************************************************************************************************** */

 // PROTECTED
 // *********

 /**
  * {@link DebugTools::scriptBenchmark()} variables
  *
  *
  * @static
  * @var number
  *
  */
  private static $scriptBenchmarkTime = null;
  private static $scriptBenchmarkPoint = 0;

 /* ---------------------------------------------------------------------------------------------------------------------------- */
 /* *** CONSTRUCTOR *** */
 /* **************************************************************************************************************************** */

 /**
  * <b> Type</b>      constructor<br>
  *
  * Constructor does nothing, this class is just a collection of debugging methods
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
  * <b>Name</b> scriptBenchmark()<br>
  *
  * Shows th time the scipt need between this call and the last call of this function.
  * And shows the memory usage at the point of the script where this public static function is called.
  *
  * @param bool $shouldReturn if TRUE it will return the values, if FALSE it will print them.
  *
  * @return string the time and memory used at this point
  *
  * @static
  * @version 1.0
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.0 initial release
  *
  */
  function scriptBenchmark($shouldReturn = false) {
    $return = '<br>*** BENCHMARK ***<br>Time: ';

    // ->> time
    $timer = explode( ' ', microtime() );
    $timer = $timer[1] + $timer[0];

    if(self::$scriptBenchmarkTime) {
      ++self::$scriptBenchmarkPoint;
      $return .= round($timer - self::$scriptBenchmarkTime,4).' seconds on point: '.self::$scriptBenchmarkPoint.'<br>';
      // self::$debug_showTime = $timer;

    // first run
    } else {
      self::$scriptBenchmarkPoint = 0;
      self::$scriptBenchmarkTime = $timer;
      $return .= round($timer,4).' start time<br>';
    }

    // ->> memory
    $mem_usage = memory_get_usage(true);

    $return .= 'Memory: ';//.$mem_usage.' -> ';

    if ($mem_usage < 1024)
        $return .= $mem_usage." bytes";
    elseif ($mem_usage < 1048576)
        $return .= round($mem_usage/1024,2)." kilobytes";
    else
        $return .= round($mem_usage/1048576,2)." megabytes";

    $return .= '<br>';

    if($shouldReturn)
      return $return;
    else
      echo $return;
  }

   /**
  * <b>Name</b> dump()<br>
  *
  * Simply lists arrays or echo an string inside a box, to see the content of a variable.
  * It will add a &lt;br&gt; after each value so it can be better read.
  *
  * @param mixed $values all kinds of variables, which should be displayed
  * @param bool  $shouldReturn (optional) whether or not the content should be displayed or returned.
  *
  * @return string a <div> block with the given values, nicly printed
  *
  * @static
  * @version 1.0
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.0 initial release
  *
  */
  function dump($values, $shouldReturn = false) {

    // vars
    $return = '';

    if(is_array($values)) {
      $return  .= 'Array:<br>';
      $return .= '<pre>';
      $return .= print_r($values,true);
      $return .= '</pre>';
    } elseif(is_object($values)) {
      $return  .= 'Object:<br>';
      $return .= '<pre>';
      $return .= print_r($values,true);
      $return .= '</pre>';
    } elseif(is_bool($values)) {
      $values = ($values) ? 'TRUE' : 'FALSE';
      $return = "Bool: ".$values."<br>";
    } elseif(is_numeric($values)) {
      $return = "Numeric: ".$values."<br>";
    } elseif(!empty($values)) {
      $return = "'".$values."'<br>";
    } elseif(empty($values)) {
      $return = "EMPTY<br>";
    } else
      $return = "'".$values."'<br>";

    $return = '<div style="background-color:white !important;color:black !important; padding: 10px;font-size: 14px;"><strong>Dump:</strong><br><br>'.$return.'</div>';

    if($shouldReturn)
      return $return;
    else
      echo $return;
  }
}