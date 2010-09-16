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
 * This file contains the {@link statisticFunctions} class.
 * 
 * @package [Implementation]-[Backend]
 * 
 */

/**
* <b>Classname</b> statisticFunctions<br>
* 
* Provides functions for the website statistics.
* 
* <b>Notice</b>: this class will be used by the implementation classes AND the backend of the feindura-CMS.
* 
* @package [Implementation]-[Backend]
* 
* @version 0.60
* <br>
*  <b>ChangeLog</b><br>
*    - 0.60 add hasVistiCache()
*    - 0.59 savePageStats(): prevent save searchwords to be counted miltuple times
*    - 0.58 fixed isSpider() and saveWebsiteStatistic()
*    - 0.57 add new browsers to createBrowserChart() 
*    - 0.56 started documentation
* 
*/ 
class statisticFunctions extends generalFunctions {
 
 /* ---------------------------------------------------------------------------------------------------------------------------- */
 /* *** PROPERTIES *** */
 /* **************************************************************************************************************************** */
 
 // PUBLIC
 // *********
  
 /**
  * Contains the website-statistic <var>array</var>
  * 
  * Example array:
  * {@example backend/websiteStatistic.array.example.php}
  * 
  * @var array
  * @see statisticFunctions()
  */ 
  var $websiteStatistic = array();
  
 /**
  * Contains the backend-statistic config <var>array</var>
  * 
  * This <var>array</var> contains the number of task logs and referrer logs saved until the last line is droped.
  * 
  * Example array:
  * {@example backend/statisticConfig.array.example.php}
  * 
  * @var array
  * @see statisticFunctions()
  */ 
  var $statisticConfig = array();
  
 
 /* ---------------------------------------------------------------------------------------------------------------------------- */
 /* *** CONSTRUCTOR *** */
 /* **************************************************************************************************************************** */
  
 /**
  * <b> Type</b>      constructor<br>
  * <b> Name</b>      statisticFunctions()<br><br>
  * The constructor of the class, runs the gerneralFunctions constructor and gets the settings.
  * 
  * <b>Used Global Variables</b><br>
  *    - <var>$websiteStatistic</var> the website-settings config (included in the {@link general.include.php})
  *    - <var>$statisticConfig</var> the statistic-settings config (included in the {@link general.include.php})
  * 
  * @return void
  * 
  * @version 1.0
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.0 initial release
  * 
  */ 
  function statisticFunctions() {

    // run the parent class constructor
    $this->generalFunctions();
    
    // GET CONFIG FILES and SET CONFIG PROPERTIES
    $this->websiteStatistic = (isset($GLOBALS["websiteStatistic"])) ? $GLOBALS["websiteStatistic"] : $GLOBALS["feindura_websiteStatistic"];
    $this->statisticConfig = (isset($GLOBALS["statisticConfig"])) ? $GLOBALS["statisticConfig"] : $GLOBALS["feindura_statisticConfig"];
  }
  
 /* ---------------------------------------------------------------------------------------------------------------------------- */
 /* *** METHODS *** */
 /* **************************************************************************************************************************** */
  
 /**
  * <b>Name</b> getMicroTime()<br>
  * 
  * Returns a UNIX-Timestamp as float
  * 
  * @return float the UNIX-Timestamp
  * 
  * @version 1.0
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.0 initial release
  * 
  */
  function getMicroTime() {
    list($usec, $sec) = explode(" ",microtime());
    return ((float)$usec + (float)$sec);
  }
  
 /**
  * <b>Name</b> secToTime()<br>
  * 
  * Converts seconds into a readable time
  * 
  * @return string the seconds in a readable time
  * 
  * @version 1.0
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.0 initial release
  * 
  */
  function secToTime($sec) {
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
  * @version 1.01
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.01 changed from date conversion to timestamp
  *    - 1.0 initial release
  * 
  */
  function formatDate($timeStamp, $format = false) {
    
    if(empty($timeStamp) || !preg_match('/^[0-9]{1,}$/',$timeStamp))
      return $timeStamp;
             
    if($format === false)
      $format = $this->adminConfig['dateFormat'];
        
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
  * @version 1.01
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.01 changed from date conversion to timestamp  
  *    - 1.0 initial release
  * 
  */
  function formatTime($timeStamp,$showSeconds = false) {
    
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
  * 
  * @version 1.0
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.0 initial release
  * 
  */
  function formatHighNumber($number,$decimalsNumber = 0) {
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
  * @param array|false  $givenLangFile  the languageFile which contains the ['date_yesterday'], ['date_today'] and ['date_tomorrow'] texts, if FALSE it loads the backend language-file
  * 
  * @return string|int a string with "yesterday", "today" or "tomorrow" or the unchanged timestamp
  * 
  * 
  * @version 1.0
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.0 initial release
  * 
  */ 
  function dateDayBeforeAfter($timestamp,$givenLangFile = false) {
    
    if(empty($timestamp) || !preg_match('/^[0-9]{1,}$/',$timestamp))
      return $timestamp;

    //var
    $date = date('Y-m-d',$timestamp);
    
    if($givenLangFile === false)
      $givenLangFile = $GLOBALS['langFile'];
    
    // if the date is TODAY
    if(substr($date,0,10) == date('Y-m-d'))
      return $givenLangFile['date_today'];
    
    // if the date is YESTERDAY
    elseif(substr($date,0,10) == date('Y-m-').sprintf("%02d",(date('d')-1)))
      return $givenLangFile['date_yesterday'];
    
    // if the date is TOMORROW
    elseif(substr($date,0,10) == date('Y-m-').sprintf("%02d",(date('d')+1)))
      return $givenLangFile['date_tomorrow'];
  
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
  * @uses generalFunctions::$categoryConfig to check if in the category the page date is activated
  * 
  * @return bool
  * 
  * 
  * @version 1.0
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.0 initial release
  * 
  */
  function checkPageDate($pageContent) {
             
    if(isset($this->categoryConfig['id_'.$pageContent['category']]) &&  // to prevent missing index error
       $this->categoryConfig['id_'.$pageContent['category']]['showpagedate'] &&
       (!empty($pageContent['pagedate']['before']) || !empty($pageContent['pagedate']['date']) || !empty($pageContent['pagedate']['after'])))
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
  * @version 1.0
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.0 initial release
  * 
  */
  function validateDateFormat($dateString) {
    
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
    
    // if the function doesn't return something, return false
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
  * 
  * @version 1.0
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.0 initial release
  * 
  */
  function showVisitTime($time,$langFile) {
    
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
        $printTime = $printTime.' <b>'.$langFile['log_hour_single'].'</b>';
      else
        $printTime = $printTime.' <b>'.$langFile['log_hour_multiple'].'</b>';
    } elseif($minute) {
      if($minute == 1)
        $printTime = $printTime.' <b>'.$langFile['log_minute_single'].'</b>';
      else
        $printTime = $printTime.' <b>'.$langFile['log_minute_multiple'].'</b>';
    } elseif($second) {
      if($second == 1)
        $printTime = $printTime.' <b>'.$langFile['log_second_single'].'</b>';
      else
        $printTime = $printTime.' <b>'.$langFile['log_second_multiple'].'</b>';
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
  * 
  * @version 1.0
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.0 initial release
  * 
  */
  function saveTaskLog($task, $object = false) {
    
    $maxEntries = $this->statisticConfig['number']['taskLog'];
    $logFilePath = dirname(__FILE__).'/../../'.'statistic/activity.statistic.log';
    
    if(file_exists($logFilePath))
      $oldLog = file($logFilePath);
      
    if($logFile = @fopen($logFilePath,"w")) {
      
      // adds the Object
      $object = ($object) ? '|-|'.$object : false;
      
      // -> create the new log string
      $newLog = time().'|-|'.$_SERVER["REMOTE_USER"].'|-|'.$task.$object;
      
      // -> write the new log file
      flock($logFile,2);    
      fwrite($logFile,$newLog."\n");    
      $count = 2;
      if(!empty($oldLog)) {
        foreach($oldLog as $oldLogRow) {
          fwrite($logFile,$oldLogRow);
          // stops the log after 120 entries
          if($count == $maxEntries)
            break;
          $count++;
        }
      }  
      flock($logFile,3);
      fclose($logFile);
      
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
  * 
  * @version 1.0
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.0 initial release
  * 
  */
  function saveRefererLog() {
    
    $maxEntries = $this->statisticConfig['number']['refererLog'];
    $logFile = dirname(__FILE__).'/../../'.'statistic/referer.statistic.log';
    
    if(file_exists($logFile))
      $oldLog = file($logFile);
    
    // -> SAVE REFERER LOG
    if(isset($_SERVER['HTTP_REFERER']) &&
       !empty($_SERVER['HTTP_REFERER']) &&
       !strstr($_SERVER['HTTP_REFERER'],str_replace('www.','',$this->adminConfig['url'])) && // checks if referer is not the own page
       $logFile = @fopen($logFile,"w")) {
      
      // -> create the new log string
      $newLog = time().'|#|'.$_SERVER['HTTP_REFERER'];
      
      // -> write the new log file
      flock($logFile,2);
      fwrite($logFile,$newLog."\n");    
      $count = 2;
      foreach($oldLog as $oldLogRow) {
        fwrite($logFile,$oldLogRow);
        // stops the log after 120 entries
        if($count == $maxEntries)
          break;      
        $count++;
      }    
      flock($logFile,3);
      fclose($logFile);
      
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
  * 
  * @version 1.01
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.01 add the browser detection class from {@link http://chrisschuld.com/projects/browser-php-detecting-a-users-browser-from-php}
  *    - 1.0 initial release
  * 
  */
  function getBrowser() {
    
    require_once(dirname(__FILE__).'/../thirdparty/BrowserDetection.php');
    
    $browser = new Browser();
	  $return = $browser->getBrowser();
	  
	  // check if older IE
	  if($return == 'Internet Explorer' && $browser->getVersion() <= 6)
	   $return = 'Internet Explorer old';	 
    
    if($return == 'Shiretoko')
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
  * @uses $websiteStatistic to get the browsers which visited to the website
  * 
  * @return string|false the browser chart or FALSE
  * 
  * @version 1.01
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.01 add a lot of new browsers  
  *    - 1.0 initial release
  * 
  */
  function createBrowserChart($browserString) {
    
    //var
    $return = false;
    
    if(isset($browserString) && !empty($browserString)) {
    
      foreach(explode('|#|',$browserString) as $browser) {
        $browsers[] =  explode(',',$browser);
      }
      
      $highestNumber = 0;
      foreach($browsers as $browser) {
        $highestNumber += $browser[1];
      }
      
      $return = '<table class="tableChart"><tr>';
      foreach($browsers as $browser) {
        
        $tablePercent = $browser[1] / $highestNumber;
        $tablePercent = round($tablePercent * 100);
        
        // change the Names and the Colors
        if($browser[0] == 'firefox') {
          $browserName = 'Firefox';
          $browserColor = 'url(library/image/bg/browserBg_firefox.png)';
          $browserLogo = 'browser_firefox.png';
          $browserTextColor = '#ffffff';
        } elseif($browser[0] == 'netscape navigator') {
          $browserName = 'Netscape Navigator';
          $browserColor = 'url(library/image/bg/browserBg_netscape.png)';
          $browserLogo = 'browser_netscape.png';
          $browserTextColor = '#ffffff';
        } elseif($browser[0] == 'chrome') {
          $browserName = 'Google Chrome';
          $browserColor = 'url(library/image/bg/browserBg_chrome.png)';
          $browserLogo = 'browser_chrome.png';
          $browserTextColor = '#000000';
        } elseif($browser[0] == 'internet explorer') {
          $browserName = 'Internet Explorer';
          $browserColor = 'url(library/image/bg/browserBg_ie.png)';
          $browserLogo = 'browser_ie.png';
          $browserTextColor = '#000000';
        } elseif($browser[0] == 'internet explorer old') {
          $browserName = 'Internet Explorer 1-6';
          $browserColor = 'url(library/image/bg/browserBg_ie_old.png)';
          $browserLogo = 'browser_ie_old.png';
          $browserTextColor = '#000000';
        } elseif($browser[0] == 'opera') {
          $browserName = 'Opera';
          $browserColor = 'url(library/image/bg/browserBg_opera.png)';
          $browserLogo = 'browser_opera.png';
          $browserTextColor = '#000000';
        } elseif($browser[0] == 'konqueror') {
          $browserName = 'Konqueror';
          $browserColor = 'url(library/image/bg/browserBg_konqueror.png)';
          $browserLogo = 'browser_konqueror.png';
          $browserTextColor = '#ffffff';
        } elseif($browser[0] == 'lynx') {
          $browserName = 'Lynx';
          $browserColor = 'url(library/image/bg/browserBg_lynx.png)';
          $browserLogo = 'browser_lynx.png';
          $browserTextColor = '#ffffff';
        } elseif($browser[0] == 'safari') {
          $browserName = 'Safari';
          $browserColor = 'url(library/image/bg/browserBg_safari.png)';
          $browserLogo = 'browser_safari.png';
          $browserTextColor = '#000000';
        } elseif($browser[0] == 'mozilla') {
          $browserName = 'Mozilla';
          $browserColor = 'url(library/image/bg/browserBg_mozilla.png)';
          $browserLogo = 'browser_mozilla.png';
          $browserTextColor = '#ffffff';
        } elseif($browser[0] == 'iphone') {
          $browserName = 'iPhone';
          $browserColor = 'url(library/image/bg/browserBg_iphone.png)';
          $browserLogo = 'browser_iphone.png';
          $browserTextColor = '#ffffff';
        } elseif($browser[0] == 'ipad') {
          $browserName = 'iPad';
          $browserColor = 'url(library/image/bg/browserBg_ipad.png)';
          $browserLogo = 'browser_ipad.png';
          $browserTextColor = '#000000';
        } elseif($browser[0] == 'ipod') {
          $browserName = 'iPod';
          $browserColor = 'url(library/image/bg/browserBg_ipod.png)';
          $browserLogo = 'browser_ipod.png';
          $browserTextColor = '#000000';
        } elseif($browser[0] == 'amaya') {
          $browserName = 'Amaya';
          $browserColor = 'url(library/image/bg/browserBg_amaya.png)';
          $browserLogo = 'browser_amaya.png';
          $browserTextColor = '#000000';
        } elseif($browser[0] == 'phoenix') {
          $browserName = 'Phoenix';
          $browserColor = 'url(library/image/bg/browserBg_phoenix.png)';
          $browserLogo = 'browser_phoenix.png';
          $browserTextColor = '#000000';
        } elseif($browser[0] == 'icab') {
          $browserName = 'iCab';
          $browserColor = 'url(library/image/bg/browserBg_icab.png)';
          $browserLogo = 'browser_icab.png';
          $browserTextColor = '#000000';
        } elseif($browser[0] == 'omniweb') {
          $browserName = 'OmniWeb';
          $browserColor = 'url(library/image/bg/browserBg_omniweb.png)';
          $browserLogo = 'browser_omniweb.png';
          $browserTextColor = '#000000';
        } elseif($browser[0] == 'galeon') {
          $browserName = 'Galeon';
          $browserColor = 'url(library/image/bg/browserBg_galeon.png)';
          $browserLogo = 'browser_galeon.png';
          $browserTextColor = '#000000';
        } elseif($browser[0] == 'netpositive') {
          $browserName = 'NetPositive';
          $browserColor = 'url(library/image/bg/browserBg_netpositive.png)';
          $browserLogo = 'browser_netpositive.png';
          $browserTextColor = '#000000';
        } elseif($browser[0] == 'opera mini') {
          $browserName = 'Opera Mini';
          $browserColor = 'url(library/image/bg/browserBg_opera_mini.png)';
          $browserLogo = 'browser_opera_mini.png';
          $browserTextColor = '#000000';
        } elseif($browser[0] == 'blackberry') {
          $browserName = 'BlackBerry';
          $browserColor = 'url(library/image/bg/browserBg_blackberry.png)';
          $browserLogo = 'browser_blackberry.png';
          $browserTextColor = '#000000';
        } elseif($browser[0] == 'icecat') {
          $browserName = 'IceCat';
          $browserColor = 'url(library/image/bg/browserBg_icecat.png)';
          $browserLogo = 'browser_icecat.png';
          $browserTextColor = '#000000';
        } elseif($browser[0] == 'nokia browser' || $browser[0] == 'Nokia S60 OSS Browser') {
          $browserName = 'Nokia Browser';
          $browserColor = 'url(library/image/bg/browserBg_nokia.png)';
          $browserLogo = 'browser_nokia.png';
          $browserTextColor = '#000000';
        } else {
          $browserName = $GLOBALS['langFile']['log_browser_others'];
          $browserColor = 'url(library/image/bg/browserBg_others.png)';
          $browserLogo = 'browser_others.png';
          $browserTextColor = '#000000';
        }  
    
        // calculates the text width and the cell width
        $textWidth = round(((strlen($browserName) + strlen($browser[1]) + 15) * 4) + 45); // +45 = logo width + padding; +15 = for the "(54)"; the visitor count
        $cellWidth = round(780 * ($tablePercent / 100)); // 780px = the width of the 100% table    
        //$return .= '<div style="border-bottom:1px solid red;width:'.$textWidth.'px;">'.$cellWidth.' -> '.$textWidth.'</div>';
        
        // show tex only if cell is big enough
        if($cellWidth < $textWidth) {
          $cellText = '';
          $cellWidth -= 10;
          
          //$return .= $browserName.': '.$cellWidth.'<br>';
          
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
          $cellText = '<span style="position: absolute; left: 45px; top: 13px;"><b>'.$browserName.'</b> ('.$browser[1].')</span>';
          $logoSize = '';
          $bigLogo = true;
          $cellpadding = '';
        }
        
        // SHOW the table cell with the right browser and color
        $return .= '<td valign="middle" style="padding: '.$cellpadding.'; color: '.$browserTextColor.'; width: '.$tablePercent.'%; background: '.$browserColor.' repeat-x;" class="toolTip" title="[span]'.$browserName.'[/span] ('.$tablePercent.'%)::'.$browser[1].' '.$GLOBALS['langFile']['log_visitCount'].'">
                    <div style="position: relative;">
                    <img src="library/image/sign/'.$browserLogo.'" style="float: left; '.$logoSize.';" alt="browser logo" />'.$cellText.'
                    </div>
                    </td>';
      
      }
      $return .= '</tr></table>';      
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
  * @version 1.0
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.0 initial release
  * 
  */
  function createTagCloud($tagString,$minFontSize = 10,$maxFontSize = 20) {
    
    //var
    $return = false;
    
    if(!empty($tagString)) {
    
      foreach(explode('|#|',$tagString) as $searchWord) {   
        $searchWords[] =  explode(',',$searchWord);
      }
      
      $highestNumber = $searchWords[0][1];
      //$lowestNumber = $searchWords[count($searchWords)-1][1];
      
      // sort alphabetical
      sort($searchWords);
      
      foreach($searchWords as $searchWord) {
        
        $fontSize = $searchWord[1] / $highestNumber;
        $fontSize = round($fontSize * $maxFontSize) + $minFontSize;
        
        // create href
        if(substr(phpversion(),0,3) >= '5')
          $searchWordHref = urlencode(html_entity_decode($searchWord[0],ENT_QUOTES,'UTF-8'));
        else
          $searchWordHref = urlencode(utf8_encode(html_entity_decode($searchWord[0],ENT_QUOTES,'ISO-8859-15')));
        
        $return .= '<a href="?site=search&amp;search='.$searchWordHref.'" style="font-size:'.$fontSize.'px;" class="toolTip" title="[span]&quot;'.$searchWord[0].'&quot;[/span] '.$GLOBALS['langFile']['log_searchwordtothissite_part1'].' [span]'.$searchWord[1].'[/span] '.$GLOBALS['langFile']['log_searchwordtothissite_part2'].'::'.$GLOBALS['langFile']['log_searchwordtothissite_tip'].'">'.$searchWord[0].'</a>&nbsp;&nbsp;'."\n"; //<span style="color:#888888;">('.$searchWord[1].')</span>
      
      }
    }    
    
    // return the tag-cloud or false
    return $return;
  }

 /**
  * <b>Name</b> addDataToString()<br>
  * 
  * Adds a new string to a data-string in the format: "stringa,42|stringb,23|stringc,1" and counts the string up if its already existing.
  * 
  * @param string|array $dataToAdd            a data-string in the format "stringa,42|stringb,23|stringc,1" or an array with strings to add
  * @param string       $dataString           the data-string which the $dataToAdd parameter will be add to
  * @param bool         $encodeSpecialChars   (optional) if TRUE it clean speacial chars and encode htmlentities before adding to the data-string
  * 
  * @return string the modified data-string parameter or the unchanged $dataString parameter if its not a string or array
  * 
  * @version 1.0
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.0 initial release
  * 
  */
  function addDataToString($dataToAdd, $dataString, $encodeSpecialChars = true) {
            
    $exisitingDatas = explode('|#|',$dataString);
    
    // ->> IF given DATA is a DATASTRING
    //------------------------------
    if(is_string($dataToAdd)) {
      $newDataString = $dataString;
      
      $dataToAdd = explode('|#|',$dataToAdd);
      
      // goes trough all searchwords
      foreach($dataToAdd as $data) {
        $data = explode(',',$data);
        
        //echo '<br />->'.$data[0].'-'.$data[1].'<br />';
        // add every word
        for($i = 0; $i < $data[1]; $i++) {
          $newDataString = $this->addDataToString(array($data[0]),$newDataString,false);
        }
      }
      
      // -> RETURNs the new data String
      return $newDataString;
    
    // ->> IF given DATA is a ARRAY WITH DATA
    //------------------------------
    } elseif(is_array($dataToAdd)) {
    
      // -> COUNTS THE EXISTING SEARCHWORDS
      $countExistingData = 0;
      $newDataString = '';
      foreach($exisitingDatas as $exisitingData) {
        $exisitingData = explode(',',$exisitingData);
        $countExistingData++; 
        
        $countNewData = -1;
        foreach($dataToAdd as $data) {
          if($encodeSpecialChars === true) {
            $data = $this->cleanSpecialChars($data,''); // entfernt Sonderzeichen
            $data = htmlentities($data,ENT_QUOTES, 'UTF-8');
            //$data = str_replace('&amp;','&',$data); // prevent double decoding        
          }
          $data = strtolower($data);
          $countNewData++;
          
          // wenn es das Stichwort schon gibt
          if($exisitingData[0] == $data) {
            // zählt ein die Anzahl des Stichworts höher
            $exisitingData[1]++;
            $foundSw[] = $data;
          }
        }
        
        // adds the old Searchwords (maybe counted up) to the String with the new ones            
        if(!empty($exisitingData[0])) {
          $newDataString .= $exisitingData[0].','.$exisitingData[1];
          if($countExistingData < count($exisitingDatas))
            $newDataString .= '|#|';
        }
      }
      
      // -> ADDS NEW SEARCHWORDS
      $countNewData = 0;
      foreach($dataToAdd as $data) {
        if($encodeSpecialChars === true) {
          $data = $this->cleanSpecialChars($data,''); // entfernt Sonderzeichen
          $data = htmlentities($data,ENT_QUOTES, 'UTF-8');
          //$data = str_replace('&amp;','&',$data); // prevent double decoding
        }
        $data = strtolower($data);
        $countNewData++;
        
        if(isset($foundSw) && is_array($foundSw))
          $foundSwStr = implode('|#|',$foundSw);
     
        if(!isset($foundSw) || (!empty($data) && strstr($foundSwStr,$data) === false)) {
          if(!empty($data)) {// verhindert das leere Suchwort strings gespeichert werden
            if(substr($newDataString,-1) != '|#|')
              $newDataString .= '|#|';
            // fügt ein neues Suchwort in den String mit den Suchwörtern ein                
            $newDataString .= $data.',1';
            
            if($countNewData < count($dataToAdd))
              $newDataString .= '|#|';
          }
        }
      }          
      //echo $newDataString.'<br />';
      
      // removes the FIRST "|"
      while(substr($newDataString,0,1) == '|#|') {
        $newDataString = substr($newDataString, 1);
      }
      // removes the LAST "|"
      while(substr($newDataString,-1) == '|#|') {
        $newDataString = substr($newDataString, 0, -1);
      }
      
      // -> SORTS the NEW SEARCHWORD STRING with THE SEARCHWORD with MOST COUNT at the BEGINNING
      if($dataToAdd = explode('|#|',$newDataString)) {
      
        // sortiert den array, mithilfe der funktion sortArray
        natsort($dataToAdd);
        usort($dataToAdd, "sortSearchwordString");          
    
        // fügt den neugeordneten Suchworte String wieder zu einem Array zusammen
        $newDataString = implode('|#|',$dataToAdd);
      }
      
      // -> RETURNs the new data String
      return $newDataString;
      
    } else
      return $dataString;
  }
  
 /**
  * <b>Name</b> isSpider()<br>
  * 
  * Check if the user-agent is a spider/bot/webcrawler.
  * This method uses the "library/thirdparty/spiders.xml" or "library/thirdparty/spiders.txt" (depending on the php version)
  * 
  * The list of spiders it uses is from: {@link http://www.wolfshead-solutions.com/spiders-list}
  * 
  * @return bool TRUE if its a spider/bot/webcrawler, FALSE if not
  * 
  * @version 1.0
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.0 initial release
  * 
  */
  function isSpider() {

    if(isset($_SERVER['HTTP_USER_AGENT'])) {
      
      // var
      $userAgent = $_SERVER['HTTP_USER_AGENT'];
      
      // hohlt die botliste aus der spiders.xml liste
      // wenn php version > 5
      if(substr(phpversion(),0,1) >= 5) {      
        if($xml = simplexml_load_file(dirname(__FILE__)."/../thirdparty/spiders.xml", 'SimpleXMLElement', LIBXML_NOCDATA)) {         
          foreach($xml as $xmlData) {
              $bots[] = strtolower($xmlData['ident']);            
          }
        }
        
        /*
        // list bots so i can save them in a text file
        foreach($bots as $bot) {
          echo $bot.',';
        }
        */
        
      } else { // php version 4
        // hohlt die botliste aus der spiders.txt liste
        $filename = dirname(__FILE__)."/../thirdparty/spiders.txt";
        $fd = fopen ($filename, "r");
        $bots = fread ($fd, filesize($filename));
        fclose ($fd);
        $bots = explode(',',$bots);
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
  * This function is used when the session ID cannot be transfered, because of deactivated cookies or no session ID in the link was transfered. 
  * 
  * @param bool $clear if this is TRUE, it only check if the agents in the cache are still up to date, without adding a user agent
  * 
  * @return bool TRUE the user agent is in the cache, FALSE if not
  * 
  * @version 1.01
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.01 add type, which can be "spider" or "visitor" 
  *    - 1.0 initial release
  * 
  */
  function hasVisitCache($clear = false) {
    
    //var
    $return = false;
    $maxTime = 700; // 3600 seconds = 1 hour
    $userAgentMd5 = md5($_SERVER['HTTP_USER_AGENT'].'::'.$_SERVER['REMOTE_ADDR']);
    $currentDate = time(); //date("YmdHis");
    $cacheFile = dirname(__FILE__)."/../../statistic/visit.statistic.cache";
    $newLines = array();
    
    // -> OPEN visit.statistic.cache for reading
    $cachedLines = @file($cacheFile);
    
    if(!empty($cachedLines) && is_array($cachedLines)) {
      
      foreach($cachedLines as $cachedLine) {
        $cachedLineArray = explode('|#|', $cachedLine);
        
        // stores the agent again with new timestamp, if the user was less than 1h on the page,
        // after 1 hour the agent is deleted form the cache
        if($currentDate - $cachedLineArray[3] < $maxTime) {
          if($clear === false && $cachedLineArray[1] == $userAgentMd5) {          
            $newLines[] = $cachedLineArray[0].'|#|'.$cachedLineArray[1].'|#|'.$_SERVER['REMOTE_ADDR'].'|#|'.$currentDate;
            $return = true;
          } else
            $newLines[] = $cachedLine;
        }
      }
    }
    // agent doesn't exist, create a new cache
    if($return === false && $clear === false) {
      $spider = ($this->isSpider()) ? 'spider' : 'visitor';
      $newLines[] = $spider.'|#|'.$userAgentMd5.'|#|'.$_SERVER['REMOTE_ADDR'].'|#|'.$currentDate;
    }
    
    // ->> OPEN visit.statistic.cache for writing
    if($cache = @fopen($cacheFile,"w")) {      
      flock($cache,2);
      foreach($newLines as $newLine) {
        $newLine = preg_replace('#[\r\n]+#','',$newLine);
        fwrite($cache,$newLine."\n");
      }
      flock($cache,3);
      fclose($cache);      
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
  * @version 1.0
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.0 initial release
  * 
  */
  function getCurrentVisitors() {
    
    //var
    $returnVisitors = array();
    
    if($currentVisitors = @file(dirname(__FILE__).'/../../statistic/visit.statistic.cache')) {
      
      // sort the visitors, the latest one first
      usort($currentVisitors, 'sortCurrentUserByTime');
    
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
  * @uses $websiteStatistic for the old website-statistics
  * @uses saveRefererLog()  to save the referer log-file
  * @uses isSpider()        to check whether the user-agent is a spider or a human
  * @uses addDataToString() to add a browser to the browser data-string
  *  
  * @return bool TRUE if the website-statistics were saved, otherwise FALSE
  * 
  * @version 1.01
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.01 if spider it will only be counted nothing else  
  *    - 1.0 initial release
  * 
  */
  function saveWebsiteStats() {
    global $HTTP_SESSION_VARS;
    
    //unset($_SESSION);
    
    // needed for check if the user has already visited the page AND reduce memory, because only run once the isSpider() function
    // if its an older php version, set the session var
    if(phpversion() <= '4.1.0')
      $_SESSION = $HTTP_SESSION_VARS;
    
    // refresh the visit cache
    $hasVisitCache = $this->hasVisitCache();
    
    // COUNT if the user/spider isn't already counted
    if((isset($_SESSION['log_visited']) && $_SESSION['log_visited'] === false) ||
       (!isset($_SESSION['log_visited']) && $hasVisitCache === false)) {
   
      // ->> CHECKS if the user is NOT a BOT/SPIDER
      if((isset($_SESSION['log_isSpider']) && $_SESSION['log_isSpider'] === false) ||
         (!isset($_SESSION['log_isSpider']) && ($_SESSION['log_isSpider'] = $this->isSpider()) === false)) {
   
        // -------------------------------------------------------------------------------------
        // -->> --------------------------------------------------------------------------------
        // ->> WEBSITE STATISTIC
        // -------------- 
        
        // -> saves the FIRST WEBSITE VISIT
        // -----------------------------
        if(!isset($this->websiteStatistic['firstVisit']) ||
          (isset($this->websiteStatistic['firstVisit']) && empty($this->websiteStatistic['firstVisit'])))
          $this->websiteStatistic['firstVisit'] = time();
        
        // -> saves the LAST WEBSITE VISIT
        // ----------------------------
        $this->websiteStatistic['lastVisit'] = time();
        
        // -> saves the HTTP REFERER
        // ----------------------------
        $this->saveRefererLog();
        
        // -> COUNT the USER UP
        if(!isset($this->websiteStatistic['userVisitCount']) ||
           (isset($this->websiteStatistic['userVisitCount']) && $this->websiteStatistic['userVisitCount'] == ''))
          $this->websiteStatistic['userVisitCount'] = '1';
        else
          $this->websiteStatistic['userVisitCount']++;
        
        // -> adds the user BROWSER
        $browser = $this->getBrowser();
        if(isset($this->websiteStatistic['browser']))
          $this->websiteStatistic['browser'] = $this->addDataToString(array($browser),$this->websiteStatistic['browser']);
        else
          $this->websiteStatistic['browser'] = $browser.',1';
        
        if(!isset($this->websiteStatistic["spiderVisitCount"]))
          $this->websiteStatistic["spiderVisitCount"] = '0';

        
      // ->> COUNT the SPIDER UP
      } elseif($_SESSION['log_isSpider'] === true && 
               (!isset($this->websiteStatistic['spiderVisitCount']) ||
               (isset($this->websiteStatistic['spiderVisitCount']) && $this->websiteStatistic['spiderVisitCount'] == ''))) {
        $this->websiteStatistic['spiderVisitCount'] = '1';
      }elseif($_SESSION['log_isSpider'] === true) {
        $this->websiteStatistic['spiderVisitCount']++;
      }
      
      // ->> OPEN website.statistic.php for writing
      if($statisticFile = @fopen(dirname(__FILE__)."/../../statistic/website.statistic.php","w")) {
        
        flock($statisticFile,2);        
        fwrite($statisticFile,PHPSTARTTAG);  
              
        fwrite($statisticFile,"\$websiteStatistic['userVisitCount'] =    '".$this->websiteStatistic["userVisitCount"]."';\n");
        fwrite($statisticFile,"\$websiteStatistic['spiderVisitCount'] =  '".$this->websiteStatistic["spiderVisitCount"]."';\n\n");
        
        fwrite($statisticFile,"\$websiteStatistic['firstVisit'] =        '".$this->websiteStatistic["firstVisit"]."';\n");
        fwrite($statisticFile,"\$websiteStatistic['lastVisit'] =         '".$this->websiteStatistic["lastVisit"]."';\n\n");
        
        fwrite($statisticFile,"\$websiteStatistic['browser'] =      '".$this->websiteStatistic["browser"]."';\n\n");
        
        fwrite($statisticFile,"return \$websiteStatistic;");
              
        fwrite($statisticFile,PHPENDTAG);        
        flock($statisticFile,3);
        fclose($statisticFile);
        
        // saves the user as visited
        $_SESSION['log_visited'] = true;
        
      }
    } else {
      
      // ->> CHECKS if the user is NOT a BOT/SPIDER
      if((isset($_SESSION['log_isSpider']) && $_SESSION['log_isSpider'] === false) ||
         (!isset($_SESSION['log_isSpider']) && ($_SESSION['log_isSpider'] = $this->isSpider()) === false)) {
        
        // -------------------------------------------------------------------------------------
        // ->> VISIT TIME of PAGES
        // -----------------------
        
        $newMinVisitTimes = '';
        $newMaxVisitTimes = '';
        $maxCount = 5;

        // -> count the time difference, between the last page and the current
        if(isset($_SESSION['log_lastPages']) && isset($_SESSION['log_lastPage_timestamp'])) {
             
          foreach($_SESSION['log_lastPages'] as $log_lastPage) {
          
            // load the last page again
            $lastPage = $this->readPage($log_lastPage,$this->getPageCategory($log_lastPage));
            
            $orgVisitTime = $this->getMicroTime() - $_SESSION['log_lastPage_timestamp'];
            // makes a time out of seconds
            $orgVisitTime = $this->secToTime($orgVisitTime);
            $visitTime = $orgVisitTime;

            // -> saves the MAX visitTime
            // ****
            if(!empty($lastPage['log_visitTime_max']) && $visitTime !== false) {
            
              $maxVisitTimes = explode('|#|',$lastPage['log_visitTime_max']);
              
              // adds the new time if it is bigger than the highest min time
              if($visitTime > $maxVisitTimes[count($maxVisitTimes) - 1]) {
                array_unshift($maxVisitTimes,$visitTime);
                $visitTime = false;
              }
              // adds the new time on the beginnig of the array          
              $newMaxVisitTimes = array_slice($maxVisitTimes,0,$maxCount);
              
              // sort array
              natsort($newMaxVisitTimes);
              $newMaxVisitTimes = array_reverse($newMaxVisitTimes);
              // make array to string
              $newMaxVisitTimes = implode('|#|',$newMaxVisitTimes);
              
            } elseif(!empty($lastPage['log_visitTime_max']))
              $newMaxVisitTimes = $lastPage['log_visitTime_max'];
            else
              $newMaxVisitTimes = $orgVisitTime;
            
            // -> saves the MIN visitTime
            // ****
            if(!empty($lastPage['log_visitTime_min']) && $visitTime !== false) {
            
              $minVisitTimes = explode('|#|',$lastPage['log_visitTime_min']);
              
              // adds the new time if it is bigger than the highest min time
              if($visitTime > $minVisitTimes[0]) {
                array_unshift($minVisitTimes,$visitTime);
              }
              // adds the new time on the beginnig of the array  
              $newMinVisitTimes = array_slice($minVisitTimes,0,$maxCount);
    
              // sort array
              natsort($newMinVisitTimes);
              $newMinVisitTimes = array_reverse($newMinVisitTimes);
              // make array to string
              $newMinVisitTimes = implode('|#|',$newMinVisitTimes);
              
            } elseif(!empty($lastPage['log_visitTime_min']))
              $newMinVisitTimes = $lastPage['log_visitTime_min'];
            else
              $newMinVisitTimes = '00:00:00';
            
            //echo '-> '.$newMaxVisitTimes.'<br />';
            //echo '-> '.$newMinVisitTimes.'<br />';
                 
            // -> adds the new max times to the pageContent Array
            $lastPage['log_visitTime_max'] = $newMaxVisitTimes;
            $lastPage['log_visitTime_min'] = $newMinVisitTimes;
            
            $seconds = str_replace(':','',$orgVisitTime);
            $category = ($lastPage['category'] != 0) ? $lastPage['category'].'/' : '';
            
            // -> SAVE the LAST PAGE // if file exists (problem when sorting pages, and user is on the page)
            if($seconds > 5 && // save only pages which where visited longer than 5 seconds
               @file_exists(DOCUMENTROOT.$this->adminConfig['savePath'].$category.$lastPage['id'].'.php'))
              $this->savePage($lastPage);
          }
          
          // -> clear the lastPages IDs, after saved their visit time
          $_SESSION['log_lastPages'] = array();
        }
      }
    }
    
    // -> store the visitime start
    $_SESSION['log_lastPage_timestamp'] = $this->getMicroTime();   
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
  *    - <var>$_SESSION</var> to store whether the user is a spider and save the time and ID of the last page to calculate the time viewed the pages
  *     
  * <b>Used Constants</b><br>
  *    - <var>PHPSTARTTAG</var> the php start tag
  *    - <var>PHPENDTAG</var> the php end tag  
  * 
  * @param $pageContent     the $pageContent array of the page
  * 
  * @uses $adminConfig                    for the save path of the pages
  * @uses isSpider()                      to check whether the user-agent is a spider or a human
  * @uses addDataToString()               to add the searchwords to the searchword data-string
  * @uses generalFunctions::readPage()    to read the last visited page for the view-time
  * @uses generalFunctions::savePage()    to save the page and also the last visited page with the calculated view-time
  * 
  * @return bool TRUE if the page-statistic was saved succesfully or FALSE if the user agent is a spider, or the $pageContent parameter is not a valid $pageContent array
  * 
  * @version 1.01
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.01 prevent save searchwords to be counted miltuple times
  *    - 1.0 initial release
  * 
  */
  function savePageStats($pageContent) {
    global $HTTP_SESSION_VARS;
    
    //unset($_SESSION);
    
    // needed for check if the user has already visited the page AND reduce memory, because only run once the isSpider() function
    // if its an older php version, set the session var
    if(phpversion() <= '4.1.0')
      $_SESSION = $HTTP_SESSION_VARS;

    // -------------------------------------------------------------------------------------
    // -->> --------------------------------------------------------------------------------
    // CHECKS if the user is NOT a BOT/SPIDER
    if((isset($_SESSION['log_isSpider']) && $_SESSION['log_isSpider'] === false) ||
       (!isset($_SESSION['log_isSpider']) && ($_SESSION['log_isSpider'] = $this->isSpider()) === false)) {
         
      // CHECK if the $pageContent parameter is a valid $pageContent array
      if($this->isPageContentArray($pageContent) === false)
        return false;
      
      // STORE last visited page IDs in a session array and the time
      $_SESSION['log_lastPages'][] = $pageContent['id'];      
      
      // -> saves the FIRST PAGE VISIT
      // -----------------------------
      if(empty($pageContent['log_firstVisit'])) {
        $pageContent['log_firstVisit'] = time();
        $pageContent['log_visitCount'] = 0;
      }
      
      // -> saves the LAST PAGE VISIT
      // ----------------------------
      $pageContent['log_lastVisit'] = time();
      
      // -> COUNT UP, if the user haven't already visited this page in this session
      // --------------------------------------------------------------------------
      if(!isset($_SESSION['log_visitedPages']))
        $_SESSION['log_visitedPages'] = array();
        
      if(in_array($pageContent['id'],$_SESSION['log_visitedPages']) === false) {
        //echo $pageContent['id'].' -> '.$pageContent['log_visitCount'];
        $pageContent['log_visitCount']++;
        // add to the array of already visited pages
        $_SESSION['log_visitedPages'][] = $pageContent['id'];
      }
      
      // ->> SAVE THE SEARCHWORDs from GOOGLE, YAHOO, MSN (Bing)
      // -------------------------------------------------------
      if(!isset($_SESSION['log_searchwords']))
        $_SESSION['log_searchwords'] = array();

      if(isset($_SERVER['HTTP_REFERER']) &&
         !empty($_SERVER['HTTP_REFERER'])) {        
         
        $searchWords = parse_url($_SERVER['HTTP_REFERER']);
        // test search url strings:
        //$searchWords = parse_url('http://www.google.de/search?q=mair%C3%A4nd+%26+geld+syteme%3F&ie=utf-8&oe=utf-8&aq=t&rls=org.mozilla:de:official&client=firefox-a');
        //$searchWords = parse_url('http://www.google.de/search?hl=de&safe=off&client=firefox-a&rls=org.mozilla%3Ade%3Aofficial&hs=pLl&q=umlaute+aus+url+umwandeln&btnG=Suche&meta=');
        //$searchWords = parse_url('http://www.bing.com/search?q=hll%C3%B6le+ich+such+ein+wort+f%C3%BCr+mich&go=&form=QBRE&filt=all');
        //$searchWords = parse_url('http://de.search.yahoo.com/search;_ylt=A03uv8f1RWxKvX8BGYMzCQx.?p=wurmi&y=Suche&fr=yfp-t-501&fr2=sb-top&rd=r1&sao=1');
        //$searchWords = parse_url('http://de.search.yahoo.com/search;_ylt=A03uv8f1RWxKvX8BGYMzCQx.?p=umlaute&y=Suche&fr=yfp-t-501&fr2=sb-top&rd=r1&sao=1');
        if(strstr($searchWords['host'],'google') || strstr($searchWords['host'],'bing') || strstr($searchWords['host'],'yahoo')) {
  
          //sucht das suchwort beginn aus dem url-query string heraus
          if(strstr($searchWords['host'],'yahoo'))
            $searchWords = strstr($searchWords['query'],'p=');
          else
            $searchWords = strstr($searchWords['query'],'q=');
          $searchWords = substr($searchWords,2,strpos($searchWords,'&')-2);
  
          $searchWords = rawurldecode($searchWords);
          $searchWords = explode('+',$searchWords);
          
          // gos through searchwords and check if there already saved  
          $newSearchWords = array();
          foreach($searchWords as $searchWord) {
            if(in_array($searchWord,$_SESSION['log_searchwords']) === false) {
              $newSearchWords[] = $searchWord;
              $_SESSION['log_searchwords'][] = $searchWord;
            }
          }
          
          if(!empty($newSearchWords)) {
               
            // adds the searchwords to the searchword data string
            $pageContent['log_searchwords'] = $this->addDataToString($searchWords,$pageContent['log_searchwords']);   
          }
        }
      }
      
      // -> SAVE the PAGE STATISTICS
      return $this->savePage($pageContent);
      
    } else
      return false;
  }
}

?>