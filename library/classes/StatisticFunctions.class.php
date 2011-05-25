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
 * This file contains the {@link StatisticFunctions} class.
 * 
 * @package [Implementation]-[Backend]
 * 
 */

/**
* <b>Classname</b> StatisticFunctions<br>
* 
* Provides public static functions for the website statistics.
* 
* <b>Notice</b>: this class will be used by the implementation classes AND the backend of the feindura-CMS.
* 
* @package [Implementation]-[Backend]
* 
* @version 0.62
* <br>
*  <b>ChangeLog</b><br>
*    - 0.62 change to static class
*    - 0.61 doesnt extend GeneralFunctions anymore, no creates an instance of it
*    - 0.60 add hasVistiCache()
*    - 0.59 savePageStats(): prevent save searchwords to be counted miltuple times
*    - 0.58 fixed isRobot() and saveWebsiteStatistic()
*    - 0.57 add new browsers to createBrowserChart() 
*    - 0.56 started documentation
* 
*/ 

class StatisticFunctions {
 
 /* ---------------------------------------------------------------------------------------------------------------------------- */
 /* *** PROPERTIES *** */
 /* **************************************************************************************************************************** */
 
 // PUBLIC
 // *********
 
  /**
  * Contains the administrator-settings config <var>array</var>
  * 
  * @static
  * @var array
  * @see init()
  * 
  */ 
  public static $adminConfig;
  
  /**
  * Contains the category-settings config <var>array</var>
  * 
  * @static
  * @var array
  * @see init()
  * 
  */ 
  public static $categoryConfig;
 
 /**
  * Contains the website-statistic <var>array</var>
  * 
  * Example array:
  * {@example backend/websiteStatistic.array.example.php}
  * 
  * @static
  * @var array
  * @see init()
  */ 
  public static $websiteStatistic = array();
  
 /**
  * Contains the backend-statistic config <var>array</var>
  * 
  * This <var>array</var> contains the number of task logs and referrer logs saved until the last line is droped.
  * 
  * Example array:
  * {@example backend/statisticConfig.array.example.php}
  * 
  * @static
  * @var array
  * @see init()
  */ 
  public static $statisticConfig = array();
  
 
 /* ---------------------------------------------------------------------------------------------------------------------------- */
 /* *** CONSTRUCTOR *** */
 /* **************************************************************************************************************************** */
 
 /**
  * <b> Type</b>      constructor<br>
  * 
  * Constructor is not callable, {@link StatisticFunctions::init()} is used instead.
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
  
 /**
  * <b> Type</b>      init<br>
  * 
  * The real constructor of the static class, gets the settings.
  * 
  * <b>Used Global Variables</b><br>
  *    - <var>$adminConfig</var> the administrator-settings config (included in the {@link general.include.php})
  *    - <var>$categoryConfig</var> the categories-settings config (included in the {@link general.include.php})  
  *    - <var>$websiteStatistic</var> the website-settings config (included in the {@link general.include.php})
  *    - <var>$statisticConfig</var> the statistic-settings config (included in the {@link general.include.php})
  * 
  * 
  * @return void
  * 
  * @static
  * @version 1.02
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.02 removed instatiating of GeneralFunctions class, because GeneralFunctions is now static  
  *    - 1.01 add $adminConfig and $categoryConfig and creates an instance of the GeneralFunctions class
  *    - 1.0 initial release
  * 
  */ 
  public static function init() {
    
    // GET CONFIG FILES and SET CONFIG PROPERTIES
    self::$adminConfig = (isset($GLOBALS["adminConfig"])) ? $GLOBALS["adminConfig"] : $GLOBALS["feindura_adminConfig"];
    self::$categoryConfig = (isset($GLOBALS["categoryConfig"])) ? $GLOBALS["categoryConfig"] : $GLOBALS["feindura_categoryConfig"];
    self::$websiteStatistic = (isset($GLOBALS["websiteStatistic"])) ? $GLOBALS["websiteStatistic"] : $GLOBALS["feindura_websiteStatistic"];
    self::$statisticConfig = (isset($GLOBALS["statisticConfig"])) ? $GLOBALS["statisticConfig"] : $GLOBALS["feindura_statisticConfig"];
  }
  
 /* ---------------------------------------------------------------------------------------------------------------------------- */
 /* *** METHODS *** */
 /* **************************************************************************************************************************** */
  
 /**
  * <b>Name</b> secToTime()<br>
  * 
  * Converts seconds into a readable time
  * 
  * @return string the seconds in a readable time
  * 
  * @static
  * @version 1.0
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.0 initial release
  * 
  */
  public static function secToTime($sec) {
    $hours = floor($sec / 3600);
    $mins = floor(($sec -= ($hours * 3600)) / 60);  
    $seconds = floor($sec - ($mins * 60));
    
    // adds leading zeros
    if($hours < 10)
      $hours = '0'.$hours;
    if($mins < 10)
      $mins = '0'.$mins;
    if($seconds < 10)
      $seconds = '0'.$seconds;
    
    return $hours.':'.$mins.':'.$seconds;
  }
  
 /**
  * <b>Name</b> formatDate()<br>
  * 
  * Converst a given timestamp into the a specific format type.
  * 
  * @param int    $timeStamp a UNIX-Timestamp
  * @param string $format    (optional) the format type can be "eu" to format into: "DD-MM-YYYY", or "int" to format into: "YYYYY-MM-DD", if FALSE it uses the format set in the administrator-settings config
  * 
  * @uses $adminConfig  to get the right date format, if no format is given
  * 
  * @return string the formated date or the unchanged $timestamp parameter
  * 
  * @static
  * @version 1.01
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.01 changed from date conversion to timestamp
  *    - 1.0 initial release
  * 
  */
  public static function formatDate($timeStamp, $format = false) {
    
    if(empty($timeStamp) || !preg_match('/^[0-9]{1,}$/',$timeStamp))
      return $timeStamp;
             
    if($format === false)
      $format = self::$adminConfig['dateFormat'];
        
    if($format == 'eu') {
        return date('d.m.Y',$timeStamp);
    } elseif($format == 'int') {
        return date('Y-m-d',$timeStamp);
    } else
        return $timeStamp;
  }
  
 /**
  * <b>Name</b> formatTime()<br>
  * 
  * Converts a given timestamp into the following format "12:60" or "12:60:00", if the <var>$showSeconds</var> parameter is TRUE.
  * 
  * @param int    $timeStamp      the given date with following format: "YYYY-MM-DD HH:MM:SS" or "HH:MM:SS"
  * @param bool   $showSeconds    (optional) whether seconds are shown in the time string
  * 
  * @return string the formated time with or without seconds or the $timestamp parameter
  * 
  * @static
  * @version 1.01
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.01 changed from date conversion to timestamp  
  *    - 1.0 initial release
  * 
  */
  public static function formatTime($timeStamp,$showSeconds = false) {
    
    if(empty($timeStamp) || !preg_match('/^[0-9]{1,}$/',$timeStamp))
      return $timeStamp;
    
    return ($showSeconds)
      ? date('H:i:s',$timeStamp)
      : date('H:i',$timeStamp);
  }
  
 /**
  * <b>Name</b> formatHighNumber()<br>
  * 
  * Seperates the thouseds in a number with whitespaces.
  * 
  * Example
  * <samp>
  * 12 050 125
  * </samp>
  * 
  * @param float $number          the number to convert
  * @param int   $decimalsNumber  (optional) the number of decimal places, like "1 250,25"
  * 
  * @return float the converted number
  * 
  * @static
  * @version 1.0
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.0 initial release
  * 
  */
  public static function formatHighNumber($number,$decimalsNumber = 0) {
    $number = floatval($number);
    return number_format($number, $decimalsNumber, ',', ' ');
  }
  
 /**
  * <b>Name</b> dateDayBeforeAfter()<br>
  * 
  * Replaces the given <var>$date</var> parameter with "yesterday", "today" or "tomorrow" if it is one day before or the same day or one day after today.
  * 
  * <b>Used Global Variables</b><br>
  *    - <var>$langFile</var> the backend language-file array (included in the {@link backend.include.php})
  * 
  * @param int          $timestamp      the timestamp to check
  * @param array|false  $givenLangFile  the languageFile which contains the ['DATE_TEXT_YESTERDAY'], ['DATE_TEXT_TODAY'] and ['DATE_TEXT_TOMORROW'] texts, if FALSE it loads the backend language-file
  * 
  * @return string|int a string with "yesterday", "today" or "tomorrow" or the unchanged timestamp
  * 
  * @static
  * @version 1.0
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.0 initial release
  * 
  */ 
  public static function dateDayBeforeAfter($timestamp,$givenLangFile = false) {
    
    if(empty($timestamp) || !preg_match('/^[0-9]{1,}$/',$timestamp))
      return $timestamp;

    //var
    $date = date('Y-m-d',$timestamp);
    
    if($givenLangFile === false)
      $givenLangFile = $GLOBALS['langFile'];
    
    // if the date is TODAY
    if(substr($date,0,10) == date('Y-m-d'))
      return $givenLangFile['DATE_TEXT_TODAY'];
    
    // if the date is YESTERDAY
    elseif(substr($date,0,10) == date('Y-m-').sprintf("%02d",(date('d')-1)))
      return $givenLangFile['DATE_TEXT_YESTERDAY'];
    
    // if the date is TOMORROW
    elseif(substr($date,0,10) == date('Y-m-').sprintf("%02d",(date('d')+1)))
      return $givenLangFile['DATE_TEXT_TOMORROW'];
  
    else
      return $timestamp;
  }
  
 /**
  * <b>Name</b> checkPageDate()<br>
  * 
  * Checks if the page date exists and is activated in the category-settings config.
  * Returns TRUE if the page date exists and is activated for this category which contains the page.
  * 
  * @param array $pageContent the $pageContent array of a page
  * 
  * @uses $categoryConfig to check if in the category the page date is activated
  * 
  * @return bool
  * 
  * @static
  * @version 1.1
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.1 add pagedate for non-categories  
  *    - 1.0 initial release
  * 
  */
  public static function checkPageDate($pageContent) {
    if((isset(self::$categoryConfig[$pageContent['category']]) && ($pageContent['category'] != 0 && self::$categoryConfig[$pageContent['category']]['showPageDate']) ||
       ($pageContent['category'] == 0 && self::$adminConfig['pages']['showPageDate'])) &&
       (!empty($pageContent['pageDate']['before']) || !empty($pageContent['pageDate']['date']) || !empty($pageContent['pageDate']['after'])))
       return true;
    else
       return false;
  }  

 /**
  * <b>Name</b> validateDateFormat()<br>
  * 
  * Check if a date is valid and returns the date as UNIX-Timestamp
  * 
  * @param string $dateString a UNIX-Timestamp or the date to validate, with the following format: "YYYY-MM-DD", "DD-MM-YYYY" or "YYYY-DD-MM" and the follwing seperators ".", "-", "/", " ", '", "," or ";"
  * 
  * @return int|false the timestamp of the date or FALSE if the date is not valid
  * 
  * @static
  * @version 1.0
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.0 initial release
  * 
  */
  public static function validateDateFormat($dateString) {
    
    // if its a unix timestamp return immediately
    if(preg_match('/^[0-9]{1,}$/',$dateString))
      return $dateString;
    
    if(!is_string($dateString) && !is_numeric($dateString))
      return false;
      
    // get the date out of the $dateString
    //$date = substr($dateString, -10);
    //$beforeDate = substr($dateString,0, -10);
    $date = str_replace(array('\'', ';', ' ', '-', '.', ','), '/', $dateString);
    
    $date = explode('/', $date);
  
    // CHECK a date with no seperation signs -> has to have the format YYYYMMDD or DDMMYYYY
    if(count($date) == 1)  {
      $date[0] = substr($date[0],-8);
      
      if(is_numeric($date[0])) {
      
        // YYYYMMDD
        if(checkdate(substr($date[0], 4, 2),
                     substr($date[0], 6, 2),
                     substr($date[0], 0, 4)))
          return mktime(23,59,59,substr($date[0], 4, 2),substr($date[0], 6, 2),substr($date[0], 0, 4));
        // DDMMYYYY
        elseif(checkdate(substr($date[0], 2, 2),
                         substr($date[0], 0, 2),
                         substr($date[0], 4, 4)))
          return mktime(23,59,59,substr($date[0], 2, 2),substr($date[0], 0, 2),substr($date[0], 4, 4));
        else
          return false;
      } else
        return false;
      
    // -> CHECK the array with the date
    } elseif(count($date) == 3 &&
       is_numeric($date[0]) &&
       is_numeric($date[1]) &&
       is_numeric($date[2])) {
      
      // adds ZEROs before the number IF number is only one character
      if(strlen($date[0]) == 1)
        $date[0] = '0'.$date[0];
      if(strlen($date[1]) == 1)
        $date[1] = '0'.$date[1];
      if(strlen($date[2]) == 1)
        $date[2] = '0'.$date[2];
      //echo 'dd:'.$date[0].'-'.$date[1].'-'.$date[2];
      //ddmmyyyy
      if(strlen($date[2]) == 4 && checkdate($date[1], $date[0], $date[2]))
        return mktime(23,59,59,$date[1],$date[0],$date[2]);
      //yyyymmdd
      elseif(strlen($date[0]) == 4 && checkdate($date[1], $date[2], $date[0]))
        return mktime(23,59,59,$date[1],$date[2],$date[0]);
      //mmddyyyy
      elseif(strlen($date[2]) == 4 && checkdate($date[0], $date[1], $date[2]))
        return mktime(23,59,59,$date[0],$date[1],$date[2]);
      else
        return false;
    }
    
    // if the public static function doesn't return something, return false
    return false;
  }

 /**
  * <b>Name</b> showVisitTime()<br>
  * 
  * Converts a given time into "12 Seconds", "01:15 Minutes" or "01:30:20 Hours".
  * 
  * @param string $time     the time in the following format: "HH:MM:SS"
  * @param string $langFile the backend language-file
  * 
  * @return string the formated time
  * 
  * @static
  * @version 1.0
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.0 initial release
  * 
  */
  public static function showVisitTime($time,$langFile) {
    
    // change seconds to the following format: hh:mm:ss
    $time = self::secToTime($time);
    
    $hour = substr($time,0,2);
    $minute = substr($time,3,2);
    $second = substr($time,6,2);
    
    // adds the text for the HOURs
    if($hour == 0)
        $hour = false;
    // adds the text for the MINUTEs
    if($minute == 0)
        $minute = false;  
    // adds the text for the SECONDs
    if($second == 0)
        $second = false;
    
    // 01:01:01 Stunden
    if($hour !== false && $minute !== false && $second !== false)
        $printTime = $hour.':'.$minute.':'.$second;
    // 01:01 Stunden
    elseif($hour !== false && $minute !== false && $second === false)
        $printTime = $hour.':'.$minute;
    // 01:01 Minuten
    elseif($hour === false && $minute !== false && $second !== false)
        $printTime = $minute.':'.$second; 
    
    // 01 Stunden
    elseif($hour !== false && $minute === false && $second === false)
        $printTime = $hour;
    // 01 Minuten
    elseif($hour === false && $minute !== false && $second === false)
        $printTime = $minute;
    // 01 Sekunden
    elseif($hour === false && $minute === false && $second !== false)
        $printTime = $second;
    
    
    // get the time together
    if($hour) {
      if($hour == 1)
        $printTime = $printTime.' <b>'.$langFile['STATISTICS_TEXT_HOUR_SINGULAR'].'</b>';
      else
        $printTime = $printTime.' <b>'.$langFile['STATISTICS_TEXT_HOUR_PLURAL'].'</b>';
    } elseif($minute) {
      if($minute == 1)
        $printTime = $printTime.' <b>'.$langFile['STATISTICS_TEXT_MINUTE_SINGULAR'].'</b>';
      else
        $printTime = $printTime.' <b>'.$langFile['STATISTICS_TEXT_MINUTE_PLURAL'].'</b>';
    } elseif($second) {
      if($second == 1)
        $printTime = $printTime.' <b>'.$langFile['STATISTICS_TEXT_SECOND_SINGULAR'].'</b>';
      else
        $printTime = $printTime.' <b>'.$langFile['STATISTICS_TEXT_SECOND_PLURAL'].'</b>';
    }
    
    // RETURN formated time
    if($time != '00:00:00')
      return $printTime;
    else
      return false;
  }
  
 /**
  * <b>Name</b> saveTaskLog()<br>
  * 
  * Adds a entry to the task log-file with time and task which was performed.
  * 
  * Example entry:
  * <samp>
  * 2010-12-31 12:00:00|-|Username|-|Moved Page|-|page=5|#|category=1
  * </samp>
  * 
  * @param string $task     a description of the task which was performed
  * @param string $object   (optional) the page name or the name of the object on which the task was performed
  * 
  * @uses $statisticConfig to get the number of maxmial task log entries
  * 
  * @return bool
  * 
  * @static
  * @version 1.0
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.0 initial release
  * 
  */
  public static function saveTaskLog($task, $object = false) {
    
    $maxEntries = self::$statisticConfig['number']['taskLog'];
    $logFilePath = dirname(__FILE__).'/../../'.'statistic/activity.statistic.log';
    $oldLog = false;
    
    if(file_exists($logFilePath))
      $oldLog = file($logFilePath);
      
    if($logFile = @fopen($logFilePath,"wb")) {
      
      // adds the Object
      $object = ($object) ? '|#|'.$object : false;
      
      // -> create the new log string
      $newLog = time().'|#|'.$_SESSION['feindura']['session']['username'].'|#|'.$task.$object;
      
      // -> write the new log file
      flock($logFile,LOCK_EX);    
      fwrite($logFile,$newLog."\n");    
      $count = 2;
      if(is_array($oldLog)) {
        foreach($oldLog as $oldLogRow) {
          fwrite($logFile,$oldLogRow);
          // stops the log after 120 entries
          if($count == $maxEntries)
            break;
          $count++;
        }
      }
      flock($logFile,LOCK_UN);
      fclose($logFile);
      
      // -> add permissions on the first creation
      if(!$oldLog) @chmod($logFilePath, self::$adminConfig['permissions']);
      
      return true;
    } else
      return false;
  }
  
 /**
  * <b>Name</b> saveRefererLog()<br>
  * 
  * Adds a entry to the referer log-file. This log file saves the referer URLS of the users visiting the website.
  * 
  * @uses $statisticConfig to get the number of maxmial referer log entries
  * @uses $adminConfig     to prevent storing the own website URL in the referer log
  * 
  * @return bool
  * 
  * @static
  * @version 1.0
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.0 initial release
  * 
  */
  public static function saveRefererLog() {
    
    if(($_SERVER['HTTP_REFERER'] = XssFilter::url($_SERVER['HTTP_REFERER'])) === false)
      return false;
      
    $maxEntries = self::$statisticConfig['number']['refererLog'];
    $logFilePath = dirname(__FILE__).'/../../'.'statistic/referer.statistic.log';
    $oldLog =  false;
    
    if(file_exists($logFilePath))
      $oldLog = file($logFilePath);
    
    // -> SAVE REFERER LOG
    if(isset($_SERVER['HTTP_REFERER']) &&
       !empty($_SERVER['HTTP_REFERER']) &&
       strpos($_SERVER['HTTP_REFERER'],str_replace('www.','',self::$adminConfig['url'])) === false && // checks if referer is not the own page
       $logFile = @fopen($logFilePath,"wb")) {
      
      // -> create the new log string
      $newLog = time().'|#|'.$_SERVER['HTTP_REFERER'];
      
      // -> write the new log file
      flock($logFile,LOCK_EX);
      fwrite($logFile,$newLog."\n");    
      $count = 2;
      if(is_array($oldLog)) {
        foreach($oldLog as $oldLogRow) {
          fwrite($logFile,$oldLogRow);
          // stops the log after 120 entries
          if($count == $maxEntries)
            break;      
          $count++;
        }
      }
      flock($logFile,LOCK_UN);
      fclose($logFile);
      
      // -> add permissions on the first creation
      if(!$oldLog) @chmod($logFilePath, self::$adminConfig['permissions']);
      
      return true;
    } else
      return false;
  }
  
 /**
  * <b>Name</b> getBrowser()<br>
  * 
  * Returns the right browser name.
  * 
  * @uses Browser::getBrowser to get the right browser
  * 
  * @return string|false the right browser name or FALSE if no useragent is available
  * 
  * @static
  * @version 1.01
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.01 add the browser detection class from {@link http://chrisschuld.com/projects/browser-php-detecting-a-users-browser-from-php}
  *    - 1.0 initial release
  * 
  */
  public static function getBrowser() {
    
    require_once(dirname(__FILE__).'/../thirdparty/PHP/BrowserDetection.php');
    
    $browser = new Browser();
	  $return = $browser->getBrowser();
	  
	  // check if older IE
	  if($return == 'Internet Explorer' && $browser->getVersion() <= 6)
	   $return = 'Internet Explorer old';	 
    
    if($return == 'Shiretoko')// || $return == 'Mozilla')
      $return = 'Firefox';
    
    // -> return
	  return strtolower($return);
  }
  
 /**
  * <b>Name</b> createBrowserChart()<br>
  * 
  * Create the browser chart out of the browser's list saved in the website-statistic.
  * 
  * @param string $browserString the browsers with their number of visits in a string with the format: "firefox,34|chrome,12"
  * 
  * 
  * @return string|false the browser chart or FALSE
  * 
  * @static
  * @version 1.01
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.01 add a lot of new browsers  
  *    - 1.0 initial release
  * 
  */
  public static function createBrowserChart($browserString) {
    
    //var
    $return = false;
    $listBrowser = array();
    
    if(isset($browserString) && !empty($browserString)) {
         
      $browsers = unserialize($browserString);
      
      if(is_array($browsers)) {
        
        //  number of all visits
        $sumOfNumbers = 0;
        foreach($browsers as $browser) {
          $sumOfNumbers += $browser['number'];
        }
        
        foreach($browsers as $browser) {
          
          // var
          $default = false;
          
          //echo $browser['data'].' - '.$browser['number'].'<br>';

          // change the Names and the Colors
          switch($browser['data']) {
            case 'firefox':
              $browserName = 'Firefox';
              $browserColor = 'url(library/images/bg/browserBg_firefox.png)';
              $browserLogo = 'browser_firefox.png';
              $browserTextColor = '#ffffff';
              break;
            case 'firefox':
              $browserName = 'Firefox';
              $browserColor = 'url(library/images/bg/browserBg_firefox.png)';
              $browserLogo = 'browser_firefox.png';
              $browserTextColor = '#ffffff';
              break;
            case 'netscape navigator':
              $browserName = 'Netscape Navigator';
              $browserColor = 'url(library/images/bg/browserBg_netscape.png)';
              $browserLogo = 'browser_netscape.png';
              $browserTextColor = '#ffffff';
              break;
            case 'chrome':
              $browserName = 'Google Chrome';
              $browserColor = 'url(library/images/bg/browserBg_chrome.png)';
              $browserLogo = 'browser_chrome.png';
              $browserTextColor = '#000000';
              break;
            case 'internet explorer':
              $browserName = 'Internet Explorer';
              $browserColor = 'url(library/images/bg/browserBg_ie.png)';
              $browserLogo = 'browser_ie.png';
              $browserTextColor = '#000000';
              break;
            case 'internet explorer old':
              $browserName = 'Internet Explorer 1-6';
              $browserColor = 'url(library/images/bg/browserBg_ie_old.png)';
              $browserLogo = 'browser_ie_old.png';
              $browserTextColor = '#000000';
              break;
            case 'opera':
              $browserName = 'Opera';
              $browserColor = 'url(library/images/bg/browserBg_opera.png)';
              $browserLogo = 'browser_opera.png';
              $browserTextColor = '#000000';
              break;
            case 'konqueror':
              $browserName = 'Konqueror';
              $browserColor = 'url(library/images/bg/browserBg_konqueror.png)';
              $browserLogo = 'browser_konqueror.png';
              $browserTextColor = '#ffffff';
              break;
            case 'lynx':
              $browserName = 'Lynx';
              $browserColor = 'url(library/images/bg/browserBg_lynx.png)';
              $browserLogo = 'browser_lynx.png';
              $browserTextColor = '#ffffff';
              break;
            case 'safari':
              $browserName = 'Safari';
              $browserColor = 'url(library/images/bg/browserBg_safari.png)';
              $browserLogo = 'browser_safari.png';
              $browserTextColor = '#000000';
              break;
            case 'mozilla':
              $browserName = 'Mozilla';
              $browserColor = 'url(library/images/bg/browserBg_mozilla.png)';
              $browserLogo = 'browser_mozilla.png';
              $browserTextColor = '#ffffff';
              break;
            case 'iphone':
              $browserName = 'iPhone';
              $browserColor = 'url(library/images/bg/browserBg_iphone.png)';
              $browserLogo = 'browser_iphone.png';
              $browserTextColor = '#ffffff';
              break;
            case 'ipad':
              $browserName = 'iPad';
              $browserColor = 'url(library/images/bg/browserBg_ipad.png)';
              $browserLogo = 'browser_ipad.png';
              $browserTextColor = '#000000';
              break;
            case 'ipod':
              $browserName = 'iPod';
              $browserColor = 'url(library/images/bg/browserBg_ipod.png)';
              $browserLogo = 'browser_ipod.png';
              $browserTextColor = '#000000';
              break;
            case 'amaya':
              $browserName = 'Amaya';
              $browserColor = 'url(library/images/bg/browserBg_amaya.png)';
              $browserLogo = 'browser_amaya.png';
              $browserTextColor = '#000000';
              break;
            case 'phoenix':
              $browserName = 'Phoenix';
              $browserColor = 'url(library/images/bg/browserBg_phoenix.png)';
              $browserLogo = 'browser_phoenix.png';
              $browserTextColor = '#000000';
              break;
            case 'icab':
              $browserName = 'iCab';
              $browserColor = 'url(library/images/bg/browserBg_icab.png)';
              $browserLogo = 'browser_icab.png';
              $browserTextColor = '#000000';
              break;
            case 'omniweb':
              $browserName = 'OmniWeb';
              $browserColor = 'url(library/images/bg/browserBg_omniweb.png)';
              $browserLogo = 'browser_omniweb.png';
              $browserTextColor = '#000000';
              break;
            case 'galeon':
              $browserName = 'Galeon';
              $browserColor = 'url(library/images/bg/browserBg_galeon.png)';
              $browserLogo = 'browser_galeon.png';
              $browserTextColor = '#000000';
              break;
            case 'netpositive':
              $browserName = 'NetPositive';
              $browserColor = 'url(library/images/bg/browserBg_netpositive.png)';
              $browserLogo = 'browser_netpositive.png';
              $browserTextColor = '#000000';
              break;
            case 'opera mini':
              $browserName = 'Opera Mini';
              $browserColor = 'url(library/images/bg/browserBg_opera_mini.png)';
              $browserLogo = 'browser_opera_mini.png';
              $browserTextColor = '#000000';
              break;
            case 'blackberry':
              $browserName = 'BlackBerry';
              $browserColor = 'url(library/images/bg/browserBg_blackberry.png)';
              $browserLogo = 'browser_blackberry.png';
              $browserTextColor = '#000000';
              break;
            case 'android':
              $browserName = 'Android';
              $browserColor = 'url(library/images/bg/browserBg_android.png)';
              $browserLogo = 'browser_android.png';
              $browserTextColor = '#ffffff';
              break;
            case 'icecat':
              $browserName = 'IceCat';
              $browserColor = 'url(library/images/bg/browserBg_icecat.png)';
              $browserLogo = 'browser_icecat.png';
              $browserTextColor = '#000000';
              break;
            case 'nokia browser': case 'Nokia S60 OSS Browser':
              $browserName = 'Nokia Browser';
              $browserColor = 'url(library/images/bg/browserBg_nokia.png)';
              $browserLogo = 'browser_nokia.png';
              $browserTextColor = '#000000';
              break;
            default:
              $default = true;
              $browserName = $GLOBALS['langFile']['STATISTICS_TEXT_BROWSERCHART_OTHERS'];
              $browserColor = 'url(library/images/bg/browserBg_others.png)';
              $browserLogo = 'browser_others.png';
              $browserTextColor = '#000000';
              break;
          }
          
          if($default) {            
            $listBrowser['unknown']['name'] = $browserName;
            $listBrowser['unknown']['bgImage'] = $browserColor;
            $listBrowser['unknown']['logo'] = $browserLogo;
            $listBrowser['unknown']['textColor'] = $browserTextColor;
            $listBrowser['unknown']['percent'] = round((($browser['number'] + $listBrowser['unknown']['number'])  / $sumOfNumbers) * 100);
            $listBrowser['unknown']['number'] += $browser['number'];
          } else {   
            $listBrowser[$browser['data']]['name'] = $browserName;
            $listBrowser[$browser['data']]['bgImage'] = $browserColor;
            $listBrowser[$browser['data']]['logo'] = $browserLogo;
            $listBrowser[$browser['data']]['textColor'] = $browserTextColor;
            $listBrowser[$browser['data']]['percent'] = round(($browser['number'] / $sumOfNumbers) * 100);
            $listBrowser[$browser['data']]['number'] = $browser['number'];
          }
        }
        
        // sort by number
        usort($listBrowser,'sortDataString');
        
        $return = '<table class="tableChart"><tr>';        
        foreach($listBrowser as $displayBrowser) {
        
          // calculates the text width and the cell width
          $textWidth = round(((strlen($displayBrowser['name']) + strlen($displayBrowser['number']) + 15) * 4) + 45); // +45 = logo width + padding; +15 = for the "(54)"; the visitor count
          $cellWidth = round(780 * ($displayBrowser['percent'] / 100)); // 780px = the width of the 100% table    
          //$return .= '<div style="border-bottom:1px solid red;width:'.$textWidth.'px;">'.$cellWidth.' -> '.$textWidth.'</div>';
          
          // show text only if cell is big enough
          if($cellWidth < $textWidth) {
            $cellText = '';
            $cellWidth -= 10;
            
            //echo $displayBrowser['name'].': '.$cellWidth.'<br>';
            
            // makes the browser logo smaller
            if($cellWidth < 40) {// 40 = logo width
              
              // change logo size
              if($cellWidth <= 0)
                $logoSize = 'width: 0px;';
              else
                $logoSize = 'width: '.$cellWidth.'px;';
              
              // change cellpadding
              $createPadding = round(($cellWidth / 40) * 10);
              if($bigLogo === false && $createPadding < 5 && $createPadding > 0)
                $cellpadding = $createPadding.'px 5px;';
              else
                $cellpadding = 'padding: 0px 5px;';
      
            }
              
            $bigLogo = false;
          } else {      
            $cellText = '<span style="position: absolute; left: 45px; top: 13px;"><b>'.$displayBrowser['name'].'</b> ('.$displayBrowser['percent'].'%)</span>';
            $logoSize = '';
            $bigLogo = true;
            $cellpadding = '';
          }
          
          // SHOW the table cell with the right browser and color
          $return .= '<td valign="middle" style="padding: '.$cellpadding.'; color: '.$displayBrowser['textColor'].'; width: '.$displayBrowser['percent'].'%; background: '.$displayBrowser['bgImage'].' repeat-x;" class="toolTip" title="[span]'.$displayBrowser['name'].'[/span] ('.$displayBrowser['percent'].'%)::'.$displayBrowser['number'].' '.$GLOBALS['langFile']['STATISTICS_TEXT_VISITORCOUNT'].'">
                      <div style="position: relative;">
                      <img src="library/images/icons/'.$displayBrowser['logo'].'" style="float: left;'.$logoSize.';" alt="browser logo" />'.$cellText.'
                      </div>
                      </td>';
                      
          unset($logoSize,$cellText);
        }
        $return .= '</tr></table>';
        
      }
    }    
    
    // return the chart or false
    return $return;
  }
  
 /**
  * <b>Name</b> createTagCloud()<br>
  * 
  * Create a tag-cloud out of the given <var>$tagString</var>.
  * 
  * @param string $tagString      the words with their number of importance in a string with the format: "lake,3|mountain,5"
  * @param int    $minFontSize    (optional) the minimal font size in the tag-cloud
  * @param int    $maxFontSize    (optional) the maximal font size in the tag-cloud  
  * 
  * @return string|false the tag-cloud or FALSE if the $tagString parameter is empty
  * 
  * @static
  * @version 1.0
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.0 initial release
  * 
  */
  public static function createTagCloud($serializedTags,$minFontSize = 10,$maxFontSize = 20) {
    
    //var
    $return = false;
    
    if(!empty($serializedTags) && is_string($serializedTags)) {
         
      $tags = unserialize($serializedTags);
      
      $highestNumber = $tags[0]['number'];
      
      // sort alphabetical
      asort($tags);
      
      foreach($tags as $tag) {
        
        $fontSize = $tag['number'] / $highestNumber;
        $fontSize = round($fontSize * $maxFontSize) + $minFontSize;
        
        // create href
        $tagsHref = urlencode(html_entity_decode($tag['data'],ENT_QUOTES,'UTF-8'));
        
        $return .= '<a href="?site=search&amp;search='.$tagsHref.'" style="font-size:'.$fontSize.'px;" class="toolTip" title="[span]&quot;'.$tag['data'].'&quot;[/span] '.$GLOBALS['langFile']['STATISTICS_TEXT_SEARCHWORD_PART1'].' [span]'.$tag['number'].'[/span] '.$GLOBALS['langFile']['STATISTICS_TEXT_SEARCHWORD_PART2'].'::'.$GLOBALS['langFile']['STATISTICS_TOOLTIP_SEARCHWORD'].'">'.$tag['data'].'</a>&nbsp;&nbsp;'."\n"; //<span style="color:#888888;">('.$tag['number'].')</span>
      
      }
    }    
    
    // return the tag-cloud or false
    return $return;
  }

 /**
  * <b>Name</b> addDataToDataString()<br>
  * 
  * Adds a new string to a data-string and counts the string up if its already existing.
  * 
  * Example dataString:
  * {@example dataString.array.example.php}
  * 
  * @param string       $dataString           the data-string which the $dataToAdd parameter will be add to
  * @param string|array $dataToAdd            a string or an array with data to add, OR a unserialized data-string  
  * 
  * @uses GeneralFunctions::cleanSpecialChars() to clean the data variable
  * 
  * @return string the modified data-string
  * 
  * @static
  * @version 1.1
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.1 changed to searialize data
  *    - 1.0 initial release
  * 
  */
  public static function addDataToDataString($dataString, $dataToAdd) {
    
    // if dataToAdd is a serialized data-string
    if(is_string($dataToAdd) && !empty($dataToAdd) && ($unserializedDataToAdd = unserialize($dataToAdd)) !== false) {
      if(is_string($dataString) && !empty($dataString)) {
      
        // var
        $dataArray = unserialize($dataString);
        $newDataArray = $dataArray;
        $newDataToAddArray = $unserializedDataToAdd;
        
        // -> check if data already exists, if then add the number from one array to the other one
        foreach($dataArray as $key => $dataArrayVariable) {
          foreach($unserializedDataToAdd as $dataToAddKey => $dataToAddArrayVariable) {
            if($dataArrayVariable['data'] == $dataToAddArrayVariable['data']) {
              $newDataArray[$key]['number'] += $dataToAddArrayVariable['number'];
              unset($newDataToAddArray[$dataToAddKey]);
            }            
          }
        }
        
        foreach($newDataToAddArray as $key => $value) {
          $newDataToAddArray[$key]['data'] = XssFilter::text($value['data']);
          $newDataToAddArray[$key]['number'] = XssFilter::int($value['number'],1);
        }
        
        $newDataArray = array_merge($newDataArray,$newDataToAddArray);

        // sort the new created array
        usort($newDataArray, 'sortDataString');

        return serialize($newDataArray);
      } else
        return $dataToAdd;
      
    } else {
    
      // var
      $newdata = (!is_array($dataToAdd))
        ? array($dataToAdd)
        : $dataToAdd;
      if(($exisitingData = unserialize($dataString)) === false)
        $exisitingData = array();
      $newDataArray = $exisitingData;
      
      // ->> add new data
      
      // -> check if data already exists, if then count up the number of the data
      if(is_array($exisitingData) && !empty($exisitingData)) {
        foreach($exisitingData as $key => $exisitingDataVariable) {
          // if then count up the number of the data
          if(false !== ($foundKey = array_search(mb_strtolower($exisitingDataVariable['data'],'UTF-8'),$newdata))) {
            $newDataArray[$key]['number']++;
            // and remove the data from the $data array
            unset($newdata[$foundKey]);
          }
        }
      }
      
      // -> add the new data
      if(is_array($newdata) && !empty($newdata)) {    
        foreach($newdata as $dataVariable) {
          $dataVariable = XssFilter::text($dataVariable);
          $newDataArray[] = array('data' => mb_strtolower($dataVariable,'UTF-8'), 'number' => 1);
        }
      }
      
      // sort the new created array
      usort($newDataArray, 'sortDataString');
      
      return serialize($newDataArray);
    }
  }

 /**
  * <b>Name</b> isLoggedUser()<br>
  * 
  * Check if the current session user is logged into the feindura backend
  * 
  * 
  * @return bool TRUE if the surrent user is logged in, otherwise false
  * 
  * @static
  * @version 1.0
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.0 initial release
  * 
  */
  public static function isLoggedUser() {
    return (isset($_SESSION['feindura'][md5($_SERVER['HTTP_USER_AGENT'].'::'.$_SERVER['REMOTE_ADDR'].'::'.$_SERVER["HTTP_HOST"])]['loggedIn']) &&
            $_SESSION['feindura'][md5($_SERVER['HTTP_USER_AGENT'].'::'.$_SERVER['REMOTE_ADDR'].'::'.$_SERVER["HTTP_HOST"])]['loggedIn'])
      ? true : false;
  }
  
 /**
  * <b>Name</b> isRobot()<br>
  * 
  * Check if the user-agent is a spider/bot/webcrawler.
  * This method uses the "library/thirdparty/spider.xml".
  * 
  * The list of spiders it uses is from: {@link http://www.wolfshead-solutions.com/spiders-list}
  * 
  * @return bool TRUE if its a spider/bot/webcrawler, FALSE if not
  * 
  * @static
  * @version 1.0
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.0 initial release
  * 
  */
  public static function isRobot() {

    if(isset($_SERVER['HTTP_USER_AGENT'])) {
      
      // var
      $userAgent = $_SERVER['HTTP_USER_AGENT'];
      
      // get the list of bots from the spiders.xml
      if($xml = simplexml_load_file(dirname(__FILE__)."/../thirdparty/spiders.xml", 'SimpleXMLElement', LIBXML_NOCDATA)) {         
        foreach($xml as $xmlData) {
            $bots[] = strtolower($xmlData['ident']);            
        }
      }
      //var_dump($bots);
      
      $userAgent = strtolower($userAgent);
      $i = 0;
      $summe = count($bots);

      foreach($bots as $bot) {
        if(strpos(strtolower($userAgent), strtolower($bot)) !== false) {
          //echo $_SERVER['HTTP_USER_AGENT'].'<br>'.$bot;
          return true; // User-Agent is a Bot
        }           
      }
      // User-Agent is no Bot
      return false;

    } else
      return false; // no HTTP_USER_AGENT available
  }
  
 /**
  * <b>Name</b> hasVisitCache()<br>
  * 
  * Creates a <var>visit.statistic.cache</var> file and store the md5 sum of the user agent + ip with a timestamp.
  * If the agent load again the website, it check if the agent is already in the cache and the timelimit of 10 min is not passed.
  * 
  * This public static function is used when the session ID cannot be transfered, because of deactivated cookies or no session ID in the link was transfered. 
  * 
  * @param bool $clear if this is TRUE, it only check if the agents in the cache are still up to date, without adding a user agent
  * 
  * @return bool TRUE the user agent is in the cache, FALSE if not
  * 
  * @static
  * @version 1.01
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.01 add type, which can be "robot" or "visitor" 
  *    - 1.0 initial release
  * 
  */
  public static function hasVisitCache($clear = false) {
    
    //var
    $return = false;
    $maxTime = 700; // 3600 seconds = 1 hour
    $userAgentMd5 = md5($_SERVER['HTTP_USER_AGENT'].'::'.$_SERVER['REMOTE_ADDR']);
    $timeStamp = time();
    $cacheFile = dirname(__FILE__)."/../../statistic/visit.statistic.cache";
    $newLines = array();
    $cachedLines = false;
    
    // -> OPEN visit.statistic.cache for reading
    if(is_file($cacheFile))
      $cachedLines = @file($cacheFile);
    
    if(is_array($cachedLines)) {
      foreach($cachedLines as $cachedLine) {
        $cachedLineArray = explode('|#|', $cachedLine);
        
        // stores the agent again with new timestamp, if the user was less than $maxTime on the page,
        // after that the agent is deleted form the cache
        if($timeStamp - $cachedLineArray[3] < $maxTime) {
          if($clear === false && $cachedLineArray[1] == $userAgentMd5) {
            $newLines[] = $cachedLineArray[0].'|#|'.$cachedLineArray[1].'|#|'.$_SERVER['REMOTE_ADDR'].'|#|'.$timeStamp;
            $return = true;
          } else
            $newLines[] = $cachedLine;
        }
      }
    }
    // agent doesn't exist, create a new cache
    if($return === false && $clear === false) {
      $robot = (self::isRobot()) ? 'robot' : 'visitor';
      $newLines[] = $robot.'|#|'.$userAgentMd5.'|#|'.$_SERVER['REMOTE_ADDR'].'|#|'.$timeStamp;
    }
    
    // ->> OPEN visit.statistic.cache for writing
    if($cache = @fopen($cacheFile,"wb")) {
      flock($cache,LOCK_EX);
      foreach($newLines as $newLine) {
        $newLine = preg_replace('#[\r\n]+#','',$newLine);
        fwrite($cache,$newLine."\n");
      }
      flock($cache,LOCK_UN);
      fclose($cache);
      
      // -> add permissions on the first creation
      if(!$cachedLines) @chmod($cacheFile, self::$adminConfig['permissions']);   
    }
    
    // return the right value
    return $return;
  }
  
 /**
  * <b>Name</b> getCurrentVisitors()<br>
  * 
  * Gets the current user from the visitCache file (<var>statistic/visit.statistic.cache</var>)
  * 
  * @return array the current visitors with $returnVisitors['ip'], $returnVisitors['time'] and $returnVisitors['type']
  * 
  * @static
  * @version 1.0
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.0 initial release
  * 
  */
  public static function getCurrentVisitors() {
    
    //var
    $returnVisitors = array();
    $cacheFile = dirname(__FILE__)."/../../statistic/visit.statistic.cache";
    
    if(!file_exists($cacheFile)) return $returnVisitors;
    if($currentVisitors = @file($cacheFile)) {
      
      // sort the visitors, the latest one first
      usort($currentVisitors, 'sortCurrentVisitorsByTime');
    
      foreach($currentVisitors as $currentVisitor) {
        $currentVisitor = explode('|#|',$currentVisitor);
          $returnVisitor['type'] = $currentVisitor[0];
          $returnVisitor['ip'] = $currentVisitor[2];
          $returnVisitor['time'] = $currentVisitor[3];
          $returnVisitors[] = $returnVisitor;
      }
    }    
    return $returnVisitors;
  }
  
 /**
  * <b>Name</b> saveWebsiteStats()<br>
  * 
  * Saves the following values of the website-statistic:
  *   - number of user visits
  *   - number of bot visits
  *   - first visit date time
  *   - last visit date time
  *   - which browser and how often visited this website
  * 
  * <b>Used Global Variables</b>
  *    - <var>$_SESSION</var> to store whether the user visited the website already, to prevent double counting
  *    - <var>DOCUMENTROOT</var> the absolut path of the webserver  
  * 
  * <b>Used Constants</b>
  *    - <var>PHPSTARTTAG</var> the php start tag
  *    - <var>PHPENDTAG</var> the php end tag
  * 
  * @uses $websiteStatistic         for the old website-statistics
  * @uses saveRefererLog()          to save the referer log-file
  * @uses isRobot()                to check whether the user-agent is a robot or a human
  * @uses addDataToDataString()     to add a browser to the browser data-string
  * @uses GeneralFunctions::readPage()        to read the last page again, to save the time spend on the page
  * @uses GeneralFunctions::getPageCategory() to get the category of the last page
  * @uses GeneralFunctions::savePage()        to save the current page statictics
  * 
  * @return bool TRUE if the website-statistics were saved, otherwise FALSE
  * 
  * @static
  * @version 1.02
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.02 fixed save visit Time with unix timestamps
  *    - 1.01 if Robot it will only be counted nothing else
  *    - 1.0 initial release
  * 
  */
  public static function saveWebsiteStats() {
    
    // $_SESSION needed for check if the user has already visited the page AND reduce memory, because only run once the isRobot() public static function
    //unset($_SESSION);
    
    // doesnt save anything if visitor is a logged in user
    if(self::isLoggedUser())
      return false;
    
    // refresh the visit cache
    $hasVisitCache = self::hasVisitCache();
    
    // COUNT if the user/robot isn't already counted
    // **********************************************
    if((isset($_SESSION['feindura']['log']['visited']) && $_SESSION['feindura']['log']['visited'] === false) ||
       (!isset($_SESSION['feindura']['log']['visited']) && $hasVisitCache === false)) {
   
      // ->> CHECKS if the user is NOT a BOT/SPIDER
      if((isset($_SESSION['feindura']['log']['isRobot']) && $_SESSION['feindura']['log']['isRobot'] === false) ||
         (!isset($_SESSION['feindura']['log']['isRobot']) && ($_SESSION['feindura']['log']['isRobot'] = self::isRobot()) === false)) {
   
        // -------------------------------------------------------------------------------------
        // -->> --------------------------------------------------------------------------------
        // ->> WEBSITE STATISTIC
        // -------------- 
        
        // -> saves the FIRST WEBSITE VISIT
        // -----------------------------
        if(!isset(self::$websiteStatistic['firstVisit']) ||
          (isset(self::$websiteStatistic['firstVisit']) && empty(self::$websiteStatistic['firstVisit'])))
          self::$websiteStatistic['firstVisit'] = time();
        
        // -> saves the LAST WEBSITE VISIT
        // ----------------------------
        self::$websiteStatistic['lastVisit'] = time();
        
        // -> saves the HTTP REFERER
        // ----------------------------
        self::saveRefererLog();
        
        // -> COUNT the USER UP
        if(!isset(self::$websiteStatistic['userVisitCount']) ||
           (isset(self::$websiteStatistic['userVisitCount']) && empty(self::$websiteStatistic['userVisitCount'])))
          self::$websiteStatistic['userVisitCount'] = 1;
        else
          self::$websiteStatistic['userVisitCount']++;
        
        // -> adds the user BROWSER
        $browser = self::getBrowser();
        if(isset(self::$websiteStatistic['browser']))
          self::$websiteStatistic['browser'] = self::addDataToDataString(self::$websiteStatistic['browser'],$browser);
        else
          self::$websiteStatistic['browser'] = $browser.',1';
        
        if(!isset(self::$websiteStatistic["robotVisitCount"]))
          self::$websiteStatistic["robotVisitCount"] = 0;

        
      // ->> COUNT the ROBOT UP
      } elseif($_SESSION['feindura']['log']['isRobot'] === true && 
               (!isset(self::$websiteStatistic['robotVisitCount']) ||
               (isset(self::$websiteStatistic['robotVisitCount']) && empty(self::$websiteStatistic['robotVisitCount'])))) {
        self::$websiteStatistic['robotVisitCount'] = 1;
      }elseif($_SESSION['feindura']['log']['isRobot'] === true) {
        self::$websiteStatistic['robotVisitCount']++;
      }
      
      // ->> OPEN website.statistic.php for writing
      if($statisticFile = @fopen(dirname(__FILE__)."/../../statistic/website.statistic.php","wb")) {
        
        flock($statisticFile,LOCK_EX);
        fwrite($statisticFile,PHPSTARTTAG);  
              
        fwrite($statisticFile,"\$websiteStatistic['userVisitCount'] =    ".XssFilter::int(self::$websiteStatistic["userVisitCount"],0).";\n");
        fwrite($statisticFile,"\$websiteStatistic['robotVisitCount'] =   ".XssFilter::int(self::$websiteStatistic["robotVisitCount"],0).";\n\n");
        
        fwrite($statisticFile,"\$websiteStatistic['firstVisit'] =        ".XssFilter::int(self::$websiteStatistic["firstVisit"],0).";\n");
        fwrite($statisticFile,"\$websiteStatistic['lastVisit'] =         ".XssFilter::int(self::$websiteStatistic["lastVisit"],0).";\n\n");
        
        fwrite($statisticFile,"\$websiteStatistic['browser'] =           '".self::$websiteStatistic["browser"]."';\n\n"); // XssFilter in the addDataToDataString() method
        
        fwrite($statisticFile,"return \$websiteStatistic;");
              
        fwrite($statisticFile,PHPENDTAG);        
        flock($statisticFile,LOCK_UN);
        fclose($statisticFile);
        
        // -> add permissions on the first creation
        if(self::$websiteStatistic["userVisitCount"] === 1) @chmod(dirname(__FILE__)."/../../statistic/website.statistic.php", self::$adminConfig['permissions']);
        
        // saves the user as visited
        $_SESSION['feindura']['log']['visited'] = true;
      }
    } else {
      
      // ->> CHECKS if the user is NOT a BOT/SPIDER
      if((isset($_SESSION['feindura']['log']['isRobot']) && $_SESSION['feindura']['log']['isRobot'] === false) ||
         (!isset($_SESSION['feindura']['log']['isRobot']) && ($_SESSION['feindura']['log']['isRobot'] = self::isRobot()) === false)) {
        
        // -------------------------------------------------------------------------------------
        // ->> VISIT TIME of PAGES
        // -----------------------
        
        $newMinVisitTimes = '';
        $newMaxVisitTimes = '';
        $maxCount = 10;

        // -> count the time difference, between the last page and the current
        if(isset($_SESSION['feindura']['log']['lastPages']) && isset($_SESSION['feindura']['log']['lastTimestamp'])) {
          
          // ->> start of foreach(lastPages)
          foreach($_SESSION['feindura']['log']['lastPages'] as $log_lastPage) {
          
            // load the last page again
            $lastPage = GeneralFunctions::readPage($log_lastPage,GeneralFunctions::getPageCategory($log_lastPage));
            
            $visitTime = time() - XssFilter::int($_SESSION['feindura']['log']['lastTimestamp'],0);
            
            // saves times longer than 5 seconds
            if($visitTime > 5) {
              $isNotMax = true;

              // -> saves the MAX visitTime
              // **************************
              if(!empty($lastPage['log_visitTime_max'])) {
              
                $maxVisitTimes = unserialize($lastPage['log_visitTime_max']);
    
                // adds the new time if it is bigger than the highest min time
                if($visitTime > $maxVisitTimes[0]) {
                  array_unshift($maxVisitTimes,$visitTime);
                  $isNotMax = false;
                }
                // adds the new time on the beginnig of the array          
                $newMaxVisitTimes = array_slice($maxVisitTimes,0,$maxCount);
                
                // sort array
                natsort($newMaxVisitTimes);
                $newMaxVisitTimes = array_reverse($newMaxVisitTimes);
                // make array to string
                $newMaxVisitTimes = serialize($newMaxVisitTimes);
                
              } else
                $newMaxVisitTimes = serialize(array($visitTime));
              
              // -> saves the MIN visitTime
              // **************************
              if(!empty($lastPage['log_visitTime_min']) && $isNotMax) {
              
                $minVisitTimes = unserialize($lastPage['log_visitTime_min']);
                
                // adds the new time if it is bigger than the highest min time
                if($visitTime > $minVisitTimes[count($minVisitTimes)-1]) {
                  array_unshift($minVisitTimes,$visitTime);
                }
                // adds the new time on the beginnig of the array  
                $newMinVisitTimes = array_slice($minVisitTimes,0,$maxCount);
      
                // sort array
                natsort($newMinVisitTimes);
                $newMinVisitTimes = array_reverse($newMinVisitTimes);
                // make array to string
                $newMinVisitTimes = serialize($newMinVisitTimes);
              
              } elseif(!empty($lastPage['log_visitTime_min']))
                $newMinVisitTimes = $lastPage['log_visitTime_min'];
              else
                $newMinVisitTimes = serialize(array(0));
              
              //echo 'MAX -> '.$newMaxVisitTimes.'<br />';
              //echo 'MIN -> '.$newMinVisitTimes.'<br />';
                   
              // -> adds the new max times to the pageContent Array
              $lastPage['log_visitTime_max'] = $newMaxVisitTimes;
              $lastPage['log_visitTime_min'] = $newMinVisitTimes;
              
              $category = ($lastPage['category'] != 0) ? $lastPage['category'].'/' : '';
              
              // -> SAVE the LAST PAGE // if file exists (problem when sorting pages, and user is on the page)
              if(@is_file(dirname(__FILE__).'/../../pages/'.$category.$lastPage['id'].'.php'))
                GeneralFunctions::savePage($lastPage);
            }
            
          } // <- end of foreach(lastPages)          
          
          // -> clear the lastPages IDs, after saved their visit time
          unset($_SESSION['feindura']['log']['lastPages']);
          $_SESSION['feindura']['log']['lastPages'] = array();
        }
      }
    }
    
    // -> store the visitime start
    $_SESSION['feindura']['log']['lastTimestamp'] = time();
  }
  
 /**
  * <b>Name</b> savePageStats()<br>
  * 
  * Saves the following values of the page-statistic:<br>
  *   - number of user visits
  *   - minimal time spend on the page
  *   - maxmimal time spend on the page
  *   - first visit date time
  *   - last visit date time
  *   - which searchwords and how often they occured
  * 
  * <b>Used Global Variables</b><br>
  *    - <var>$_SESSION</var> to store whether the user is a robots and save the time and ID of the last page to calculate the time viewed the pages
  *     
  * <b>Used Constants</b><br>
  *    - <var>PHPSTARTTAG</var> the php start tag
  *    - <var>PHPENDTAG</var> the php end tag  
  * 
  * @param $pageContent     the $pageContent array of the page
  * 
  * @uses $adminConfig                            for the save path of the pages
  * @uses isRobot()                               to check whether the user-agent is a robot or a human
  * @uses addDataToDataString()                   to add the searchwords to the searchword data-string
  * @uses GeneralFunctions::isPageContentArray()  check if the $pageContent parameter is a valid pageContent array    
  * @uses GeneralFunctions::savePage()            to save the page and also the last visited page with the calculated view-time
  * 
  * @return bool TRUE if the page-statistic was saved succesfully or FALSE if the user agent is a robot, or the $pageContent parameter is not a valid $pageContent array
  * 
  * @static
  * @version 1.01
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.01 prevent save searchwords to be counted miltuple times
  *    - 1.0 initial release
  * 
  */
  public static function savePageStats($pageContent) {

    // $_SESSION needed for check if the user has already visited the page AND reduce memory, because only run once the isRobot() public static function
    //unset($_SESSION);
    
    // doesnt save anything if visitor is a logged in user
    if(self::isLoggedUser())
      return false;

    // -------------------------------------------------------------------------------------
    // -->> --------------------------------------------------------------------------------
    // CHECKS if the user is NOT a BOT/SPIDER
    if((isset($_SESSION['feindura']['log']['isRobot']) && $_SESSION['feindura']['log']['isRobot'] === false) ||
       (!isset($_SESSION['feindura']['log']['isRobot']) && ($_SESSION['feindura']['log']['isRobot'] = self::isRobot()) === false)) {
         
      // CHECK if the $pageContent parameter is a valid $pageContent array
      if(GeneralFunctions::isPageContentArray($pageContent) === false)
        return false;
      
      // STORE last visited page IDs in a session array and the time
      $_SESSION['feindura']['log']['lastPages'][] = $pageContent['id'];      
      
      // -> saves the FIRST PAGE VISIT
      // -----------------------------
      if(empty($pageContent['log_firstVisit'])) {
        $pageContent['log_firstVisit'] = time();
        $pageContent['log_visitorCount'] = 0;
      }
      
      // -> saves the LAST PAGE VISIT
      // ----------------------------
      $pageContent['log_lastVisit'] = time();
      
      // -> COUNT vistor, if the user haven't already visited this page in this session
      // --------------------------------------------------------------------------
      if(!isset($_SESSION['feindura']['log']['visitedPages']))
        $_SESSION['feindura']['log']['visitedPages'] = array();
        
      if(in_array($pageContent['id'],$_SESSION['feindura']['log']['visitedPages']) === false) {
        //echo $pageContent['id'].' -> '.$pageContent['log_visitorCount'];
        $pageContent['log_visitorCount']++;
        // add to the array of already visited pages
        $_SESSION['feindura']['log']['visitedPages'][] = $pageContent['id'];
      }
      
      // ->> SAVE THE SEARCHWORDs from GOOGLE, YAHOO, MSN (Bing)
      // -------------------------------------------------------
      if(!isset($_SESSION['feindura']['log']['searchwords']))
        $_SESSION['feindura']['log']['searchwords'] = array();

      if(isset($_SERVER['HTTP_REFERER']) &&
         !empty($_SERVER['HTTP_REFERER'])) {   
         
        $searchWords = $_SERVER['HTTP_REFERER'];
        // test search url strings:
        //$searchWords = 'http://www.google.com/search?hl=de&q=hall%C3%B6fsdfs++ds%C3%B6%C3%A4&btnG=Suche&aq=f&aqi=&oq=#sclient=psy&hl=de&q=hall%C3%B6fsdfs++da%C3%B6+%C3%9Fddd&aq=f&aqi=&aql=&oq=&pbx=1&fp=59d7fcbbee5898f6';
        //$searchWords = 'http://www.google.de/#sclient=psy&num=10&hl=de&safe=off&q=ich+suche+was&aq=f&aqi=g1&aql=&oq=&gs_rfai=&pbx=1&fp=bea9cbc9f7597291';
        //$searchWords = 'http://www.bing.com/search?q=halo+wich+suche+was&go=&form=QBLH&filt=all';
        //$searchWords = 'http://de.search.yahoo.com/search;_ylt=AoJmH5FT4CkRvDpo3RuiawIqrK5_?vc=&p=hallo+ich+suche+was&toggle=1&cop=mss&ei=UTF-8&fr=yfp-t-708';
        //$searchWords = 'http://de.search.yahoo.com/search;_ylt=A03uv8f1RWxKvX8BGYMzCQx.?p=umlaute+fdgdfg&y=Suche&fr=yfp-t-501&fr2=sb-top&rd=r1&sao=1';
        if(strpos($searchWords,'google') !== false || strpos($searchWords,'bing') !== false || strpos($searchWords,'yahoo') !== false) {

          // gets the searchwords
          $parts = parse_url($searchWords);
          parse_str($parts['query'], $query1);
          parse_str($parts['fragment'], $query2);
          $query = array_merge($query1, $query2);
          
          $search_engines = array(
              'bing' => 'q',
              'google' => 'q',
              'yahoo' => 'p'
          );
          
          preg_match('/('.implode('|', array_keys($search_engines)).')\./', $parts['host'], $matches);
          $searchWords = (isset($matches[1]) && isset($query[$search_engines[$matches[1]]])) ? $query[$search_engines[$matches[1]]] : '';
          echo '-> '.$searchWords;
          $searchWords = explode(' ',$searchWords);
          
          // gos through searchwords and check if there already saved
          $newSearchWords = array();
          foreach($searchWords as $searchWord) {
            if(in_array($searchWord,$_SESSION['feindura']['log']['searchwords']) === false) {
              $newSearchWords[] = $searchWord;
              $_SESSION['feindura']['log']['searchwords'][] = $searchWord;
            }
          }
          
          if(!empty($newSearchWords)) {
            // adds the searchwords to the searchword data string
            $pageContent['log_searchWords'] = self::addDataToDataString($pageContent['log_searchWords'],$searchWords);   
          }
        }
      }
      
      // -> SAVE the PAGE STATISTICS
      return GeneralFunctions::savePage($pageContent);
      
    } else
      return false;
  }
}

?>