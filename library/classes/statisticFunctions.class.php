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
 * This file contains the {@link statisticFunctions} <var>class</var>
 *
 * This <var>class</var> provides statistic-functions which will be used by the FRONTEND and the BACKEND.
 */ 

/**
 * Provides functions for the website statistics
 * 
 * @version 0.56
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
  * @var array
  * @see statisticFunctions()
  */ 
  var $websiteStatistics = array();
  
 /**
  * Contains the backend-statistic config <var>array</var>
  * 
  * This <var>array</var> contains the number of task logs and referrer logs saved until the last line is droped.
  * 
  * @var array
  * @see statisticFunctions()
  */ 
  var $statisticConfig = array();
  //var $adminConfig;                       // [Array] the Array with the adminConfig Data from the feindura CMS
  //var $categoryConfig;                    // [Array] the Array with the categoryConfig Data from the feindura CMS
 
 /* ---------------------------------------------------------------------------------------------------------------------------- */
 /* *** METHODS *** */
 /* **************************************************************************************************************************** */
 
  // -> START ** constructor *****************************************************************************
  // the class constructor
  // get the config arrays
  // -----------------------------------------------------------------------------------------------------
  function statisticFunctions() {

    // GET CONFIG FILES and SET CONFIG PROPERTIES
    $this->generalFunctions();
    $this->statisticConfig = $GLOBALS["statisticConfig"];
    $this->websiteStatistic = $GLOBALS["websiteStatistic"];    
    //$this->adminConfig = $adminConfig;    
    //$this->categoryConfig = $categoryConfig;
    
    // GET FUNCTIONS
    //$this->generalFunctions = new generalFunctions();
    
    return true;
  }

  // ** -- getmicrotime ------------------------------------------------------------------------------
  // returns a unix timestamp as float
  // -------------------------------------------------------------------------------------------------
  function getMicroTime() {
    list($usec, $sec) = explode(" ",microtime());
    return ((float)$usec + (float)$sec);
  }
  
  // ** -- secToMin ----------------------------------------------------------------------------------
  // changes seconds in minutes
  // -------------------------------------------------------------------------------------------------
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
  
    // ** -- formatDate ----------------------------------------------------------------------------------
  // returns the date out of a database-date-format in the choosen format
  // -------------------------------------------------------------------------------------------------
  // $givenDate       [],
  // $format          [the format of the date, "de" = dd.mm.yyyy or "int" = yyyy.mm.dd (String)]
  function formatDate($givenDate,               // (String like: yyyy-mm-dd hh:mm:ss) the date given in a database-date-format like: yyyy-mm-dd hh:mm:ss
                      $format = false) {        // (false or String) the format to use ("eu" or "int")
                              
      $year = substr($givenDate,0,4);
      $month = substr($givenDate,5,2);
      $day = substr($givenDate,8,2);
      
      if(strstr($givenDate,'-') && is_numeric($year) && is_numeric($month) && is_numeric($day)) {
  
        if($format === false)
          $format = $this->adminConfig['dateFormat'];
        
        if($format == 'eu') {
            return $day.'.'.$month.'.'.$year;        
        } elseif($format == 'int') {
            return $year.'-'.$month.'-'.$day;
        } else
            return false;
      } else return $givenDate;
  }
  
  // ** -- formatTime ----------------------------------------------------------------------------------
  // returns the time out of a database-date-format with or without seconds
  // -------------------------------------------------------------------------------------------------
  // $givenDate       [the date given in a database-date-format like: yyyy-mm-dd hh:mm:ss],
  // $showSeconds     [if true the secondes in the time will also be returned (Boolean)]
  function formatTime($givenDate,$showSeconds = false) {
      $hour = substr($givenDate,-8,2);
      $minute = substr($givenDate,-5,2);
      $second = ':'.substr($givenDate,-2,2);
   
      if(!$showSeconds) {
          $second = '';
      }    
    
      return $hour.':'.$minute.$second;
  }
  
  // ** -- formatHighNumber ----------------------------------------------------------------------------------
  // format a high number to 1 000 000,00
  // -------------------------------------------------------------------------------------------------
  function formatHighNumber($number,$decimalsNumber = 0) {
    $number = floatval($number);
    return number_format($number, $decimalsNumber, ',', ' ');
  }
  
  // ** -- validateDateFormat ----------------------------------------------------------------------------------
  // checks the date,
  // RETURNs a validated array
  // with the array[0] =text before the date,
  // and array[1] = the date (in FORMAT YYYY-MM-DD), or false
  // -----------------------------------------------------------------------------------------------------
  function validateDateFormat($dateString) {       // (String) the given string with an date on the end
    
    if(!is_string($dateString))
      return false;
      
    // get the date out of the $dateString
    //$date = substr($dateString, -10);
    //$beforeDate = substr($dateString,0, -10);
    $date = str_replace(array('\'', ';', '-', '.', ','), '/', $dateString);
    
    $date = explode('/', $date);
  
    // CHECK a date with no seperation signs -> has to have the format YYYYMMDD or DDMMYYYY
    if(count($date) == 1)  {
      $date[0] = substr($date[0],-8);
      
      if(is_numeric($date[0])) {
      
        // YYYYMMDD
        if(checkdate(substr($date[0], 4, 2),
                     substr($date[0], 6, 2),
                     substr($date[0], 0, 4)))
          return substr($date[0], 0, 4).'-'.substr($date[0], 4, 2).'-'.substr($date[0], 6, 2);
        // DDMMYYYY
        elseif(checkdate(substr($date[0], 2, 2),
                     substr($date[0], 0, 2),
                     substr($date[0], 4, 4)))
          return substr($date[0], 4, 4).'-'.substr($date[0], 2, 2).'-'.substr($date[0], 0, 2);
        else
          return false;
      } else return false;
      
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
      
      //ddmmyyyy
      if(strlen($date[2]) == 4 && checkdate($date[1], $date[0], $date[2]))
        return $date[2].'-'.$date[1].'-'.$date[0];
      //yyyymmdd
      elseif(strlen($date[0]) == 4 && checkdate($date[1], $date[2], $date[0]))
        return $date[0].'-'.$date[1].'-'.$date[2];
      //mmddyyyy
      elseif(strlen($date[2]) == 4 && checkdate($date[0], $date[1], $date[2]))
        return $date[2].'-'.$date[0].'-'.$date[1];    
      else
        return false;
    }
    
    // check if it is a date format 'de' or 'int'
    /*
    if (($format == 'eu' && !preg_match('/^(\d{2})\/(\d{2})\/(\d{4})$/', trim($date), $matches)) ||
        ($format == 'int' && !preg_match('/^(\d{4})\/(\d{2})\/(\d{2})$/', trim($date), $matches))) {
        return false;
    }
    */
   
    // wenn die funktion nichts anderes zurückgegeben hat return false
    return false;
  }

  // ** -- showVisitTime -----------------------------------------------------------------------------
  // SHOWs the visitTime as text
  // -------------------------------------------------------------------------------------------------
  function showVisitTime($time) {
    
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
        $time = $hour.':'.$minute.':'.$second;
    // 01:01 Stunden
    elseif($hour !== false && $minute !== false && $second === false)
        $time = $hour.':'.$minute;
    // 01:01 Minuten
    elseif($hour === false && $minute !== false && $second !== false)
        $time = $minute.':'.$second; 
    
    // 01 Stunden
    elseif($hour !== false && $minute === false && $second === false)
        $time = $hour;
    // 01 Minuten
    elseif($hour === false && $minute !== false && $second === false)
        $time = $minute;
    // 01 Sekunden
    elseif($hour === false && $minute === false && $second !== false)
        $time = $second;
    
    
    // get the time together
    if($hour) {
      if($hour == 1)
        $time = $time.' <b>'.$GLOBALS['langFile']['log_hour_single'].'</b>';
      else
        $time = $time.' <b>'.$GLOBALS['langFile']['log_hour_multiple'].'</b>';
    } elseif($minute) {
      if($minute == 1)
        $time = $time.' <b>'.$GLOBALS['langFile']['log_minute_single'].'</b>';
      else
        $time = $time.' <b>'.$GLOBALS['langFile']['log_minute_multiple'].'</b>';
    } elseif($second) {
      if($second == 1)
        $time = $time.' <b>'.$GLOBALS['langFile']['log_second_single'].'</b>';
      else
        $time = $time.' <b>'.$GLOBALS['langFile']['log_second_multiple'].'</b>';
    }
    
    
    // RETURN formated time
    if($time != '00:00:00')
      return $time;
    else
      return false;
  }
  
  // ** -- saveTaskLog --------------------------------------------------------------------------------
  // SAVE a log file with time and task which was done
  // -----------------------------------------------------------------------------------------------------
  function saveTaskLog($task,               // (String) a description of the task which was performed
                       $object = false) {   // (String) the page name or the name of the object on which the task was performed
    
    $maxEntries = $this->statisticConfig['number']['taskLog'];
    $logFile = dirname(__FILE__).'/../../'.'statistic/task.statistic.txt';
    
    if(file_exists($logFile))
      $oldLog = file($logFile);
      
    if($logFile = @fopen($logFile,"w")) {
      
      // adds the Object
      if($object)
        $object = '|-|'.$object;
      
      // -> create the new log string
      $newLog = date('Y')."-".date('m')."-".date('d').' '.date("H:i:s",time()).'|-|'.$_SERVER["REMOTE_USER"].'|-|'.$task.$object;
      
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
    } else return false;
  }
  
  // ** -- saveRefererLog --------------------------------------------------------------------------------
  // SAVE a log file with links where the people are coming from
  // -----------------------------------------------------------------------------------------------------
  function saveRefererLog() {   // (String) the page name or the name of the object on which the task was performed
    
    $maxEntries = $this->statisticConfig['number']['refererLog'];
    $logFile = dirname(__FILE__).'/../../'.'statistic/referer.statistic.txt';
    
    if(file_exists($logFile))
      $oldLog = file($logFile);
    
    // -> SAVE REFERER LOG
    if(isset($_SERVER['HTTP_REFERER']) &&
       !empty($_SERVER['HTTP_REFERER']) &&
       !strstr($_SERVER['HTTP_REFERER'],str_replace('www.','',$this->adminConfig['url'])) && // checks if referer is not the own page
       $logFile = @fopen($logFile,"w")) {       
      
      // -> create the new log string
      $newLog = date('Y')."-".date('m')."-".date('d').' '.date("H:i:s",time()).' '.$_SERVER['HTTP_REFERER'];
      
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
    } else return false;
  }
  
  // ** -- getBrowser -------------------------------------------------------------------------------
  // returns a the Browser Name
  // -----------------------------------------------------------------------------------------------------
  function getBrowser($agent) {
    if(preg_match("/Firefox/", $agent)) $c_browser = "firefox";                       // Phoenix oder Firefox
    elseif((preg_match("/Nav/", $agent)) ||
    (preg_match("/Gold/", $agent)) ||
    (preg_match("/X11/", $agent)) ||
    (preg_match("/Netscape/", $agent)) AND
    (!preg_match("/MSIE 6/", $agent))) $c_browser = "netscape";                       // Netscape Navigator
    elseif(preg_match("/Chrome/", $agent)) $c_browser  = "chrome";                    // Google Chrome
    elseif(preg_match("/MSIE [0-6]/", $agent)) $c_browser = "ie_old";                 // Internet Explorer 1-6
    elseif(preg_match("/MSIE/", $agent)) $c_browser = "ie";                           // Internet Explorer
    elseif(preg_match("/Opera/", $agent)) $c_browser = "opera";                       // Opera
    elseif(preg_match("/Konqueror/", $agent)) $c_browser = "konqueror";               // Konqueror
    elseif(preg_match("/Lynx/", $agent)) $c_browser = "lynx";                         // Lynx
    elseif(preg_match("/iCab/", $agent)) $c_browser = "safari";                       // Safari
    elseif(preg_match("/Safari/", $agent)) $c_browser = "safari";                     // Safari
    elseif(preg_match("/gecko/", $agent)) $c_browser = "mozilla";                     // Mozilla oder kompatibel
    elseif(preg_match("/Mozilla/", $agent)) $c_browser = "mozilla";                   // Mozilla oder kompatibel
    else $c_browser = "others";
    
    return $c_browser;
  }
  
  // ** -- createBrowserChart --------------------------------------------------------------------------------
  // creates a chart to display the browsers, used by the users
  // -----------------------------------------------------------------------------------------------------
  function createBrowserChart() {
    
    if(isset($this->websiteStatistic['userBrowsers']) && !empty($this->websiteStatistic['userBrowsers'])) {
      foreach(explode('|',$this->websiteStatistic['userBrowsers']) as $browser) {   
        $browsers[] =  explode(',',$browser);
      }
      
      $highestNumber = 1;
      foreach($browsers as $browser) {
        $highestNumber += $browser[1];
      }
      
      echo '<table class="tableChart"><tr>';
      foreach($browsers as $browser) {
        
        $tablePercent = $browser[1] / $highestNumber;
        $tablePercent = round($tablePercent * 100);
        
        // change the Names and the Colors
        if($browser[0] == 'firefox') {
          $browserName = 'Firefox';
          $browserColor = 'url(library/image/bg/browserBg_firefox.png) repeat-x';
          $browserLogo = 'browser_firefox.png';
          $browserTextColor = '#ffffff';
        } elseif($browser[0] == 'netscape') {
          $browserName = 'Netscape Navigator';
          $browserColor = 'url(library/image/bg/browserBg_netscape.png) repeat-x';
          $browserLogo = 'browser_netscape.png';
          $browserTextColor = '#ffffff';
        } elseif($browser[0] == 'chrome') {
          $browserName = 'Google Chrome';
          $browserColor = 'url(library/image/bg/browserBg_chrome.png) repeat-x';
          $browserLogo = 'browser_chrome.png';
          $browserTextColor = '#000000';
        } elseif($browser[0] == 'ie') {
          $browserName = 'Internet Explorer';
          $browserColor = 'url(library/image/bg/browserBg_ie.png) repeat-x';
          $browserLogo = 'browser_ie.png';
          $browserTextColor = '#000000';
        } elseif($browser[0] == 'ie_old') {
          $browserName = 'Internet Explorer 1-6';
          $browserColor = 'url(library/image/bg/browserBg_ie_old.png) repeat-x';
          $browserLogo = 'browser_ie_old.png';
          $browserTextColor = '#000000';
        } elseif($browser[0] == 'opera') {
          $browserName = 'Opera';
          $browserColor = 'url(library/image/bg/browserBg_opera.png) repeat-x';
          $browserLogo = 'browser_opera.png';
          $browserTextColor = '#000000';
        } elseif($browser[0] == 'konqueror') {
          $browserName = 'Konqueror';
          $browserColor = 'url(library/image/bg/browserBg_konqueror.png) repeat-x';
          $browserLogo = 'browser_konqueror.png';
          $browserTextColor = '#ffffff';
        } elseif($browser[0] == 'lynx') {
          $browserName = 'Lynx';
          $browserColor = 'url(library/image/bg/browserBg_lynx.png) repeat-x';
          $browserLogo = 'browser_lynx.png';
          $browserTextColor = '#ffffff';
        } elseif($browser[0] == 'safari') {
          $browserName = 'Safari';
          $browserColor = 'url(library/image/bg/browserBg_safari.png) repeat-x';
          $browserLogo = 'browser_safari.png';
          $browserTextColor = '#000000';
        } elseif($browser[0] == 'mozilla') {
          $browserName = 'Mozilla';
          $browserColor = 'url(library/image/bg/browserBg_mozilla.png) repeat-x';
          $browserLogo = 'browser_mozilla.png';
          $browserTextColor = '#ffffff';
        } elseif($browser[0] == 'others') {
          $browserName = $GLOBALS['langFile']['log_browser_others'];
          $browserColor = 'url(library/image/bg/browserBg_others.png) repeat-x';
          $browserLogo = 'browser_others.png';
          $browserTextColor = '#000000';
        }  
    
        // calculates the text width and the cell width
        $textWidth = round(((strlen($browserName) + strlen($browser[1]) + 15) * 4) + 45); // +45 = logo width + padding; +15 = for the "(54)"; the visitor count
        $cellWidth = round(780 * ($tablePercent / 100)); // 780px = the width of the 100% table    
        //echo '<div style="border-bottom:1px solid red;width:'.$textWidth.'px;">'.$cellWidth.' -> '.$textWidth.'</div>';
        
        // show tex only if cell is big enough
        if($cellWidth < $textWidth) {
          $cellText = '';
          $cellWidth -= 10;
          
          //echo $browserName.': '.$cellWidth.'<br>';
          
          // makes the browser logo smaller
          if($cellWidth < 40) {// 40 = logo width
            
            // change logo size
            if($cellWidth <= 0)
              $logoSize = 'width:0px;';
            else
              $logoSize = 'width:'.$cellWidth.'px;';
            
            // change cellpadding
            $createPadding = round(($cellWidth / 40) * 10);
            if($bigLogo === false && $createPadding < 5 && $createPadding > 0)
              $cellpadding = 'padding: '.$createPadding.'px 5px;';
            else
              $cellpadding = 'padding: 0px 5px;';
    
          }
            
          $bigLogo = false;
        } else {      
          $cellText = '&nbsp;&nbsp;<span style="position:relative; top:12px;"><b>'.$browserName.'</b> ('.$browser[1].')</span>';
          $logoSize = '';
          $bigLogo = true;
          $cellpadding = '';
        }
        
        // SHOW the table cell with the right browser and color
        echo '<td style="'.$cellpadding.';color:'.$browserTextColor.';width:'.$tablePercent.'%;background:'.$browserColor.';" class="toolTip" title="[span]'.$browserName.'[/span] ('.$tablePercent.'%)::'.$browser[1].' '.$GLOBALS['langFile']['log_visitCount'].'"><img src="library/image/sign/'.$browserLogo.'" style="float:left;'.$logoSize.'" alt="browser logo" />'.$cellText.'</td>';
      
      }
      echo '</tr></table>';
      
    } else
      echo $GLOBALS['langFile']['home_novisitors']; 
  }
  
  // ** -- createTagCloud --------------------------------------------------------------------------------
  // creates a tag cloud out of the searchwords
  // -----------------------------------------------------------------------------------------------------
  // $searchWordString         [Der String der die suchworte enthält im Format: 'suchwort,1|suchwort,3|...'  (String)],
  // $minFontSize              [Die minimal Schriftartgröße (Number)],
  // $maxFontSize              [Die maximale Schriftartgröße (Number)]
  function createTagCloud($searchWordString,$minFontSize = 10,$maxFontSize = 20) {
    
    if(!empty($searchWordString)) {
      foreach(explode('|',$searchWordString) as $searchWord) {   
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
        
        echo '<a href="?site=search&amp;search='.$searchWordHref.'" style="font-size:'.$fontSize.'px;" class="toolTip" title="[span]&quot;'.$searchWord[0].'&quot;[/span] '.$GLOBALS['langFile']['log_searchwordtothissite_part1'].' [span]'.$searchWord[1].'[/span] '.$GLOBALS['langFile']['log_searchwordtothissite_part2'].'::'.$GLOBALS['langFile']['log_searchwordtothissite_tip'].'">'.$searchWord[0].'</a>&nbsp;&nbsp;'."\n"; //<span style="color:#888888;">('.$searchWord[1].')</span>
      
      }
    } else {
      echo '<span class="blue" style="font-size:15px;">'.$GLOBALS['langFile']['log_notags'].'</span>';
    }
  }

  // ** -- isSpider ----------------------------------------------------------------------------------
  // checks if the user-agent is bot/spider
  // actual botlist from http://spiderlist.codeforgers.com/
  // require spiders.xml/spiders.txt
  // ---------------------------------------------------------------------------------------------------
  function isSpider() {
  
    if(isset($_SERVER['HTTP_USER_AGENT'])) {
      $userAgent = ($_SERVER['HTTP_USER_AGENT']);
      
      // hohlt die botliste aus der spiders.xml liste
      // wenn php version > 5
      if(substr(phpversion(),0,1) >= 5) {
        if($xml = simplexml_load_file(dirname(__FILE__)."/../thirdparty/spiders.xml", 'SimpleXMLElement', LIBXML_NOCDATA)) {
         
          foreach($xml as $xmlData) {
              $bots[] = strtolower($xmlData['ident']);            
          }
        }
        
        /*
        //listet die bots auf damit ich sie in einer datei speicher kann
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
    
      while ($i < $summe) {
        if ( strstr($userAgent, $bots[$i]))
          return true; // User-Agent ist ein Bot
        $i++;
      }
      // User-Agent is not a Bot
      return false;
    
    } else return false; // HTTP_USER_AGENT ist nicht vorhanden
  }

  // ** -- addDataToString ----------------------------------------------------------------------------------
  // adds to a string like "wordula,1|wordlem,5|wordquer,3" a new word or count up an exisiting word
  // RETURNs a new data String with the words counted up and/or add
  // -----------------------------------------------------------------------------------------------------
  function addDataToString($givenData,                     // (Array or dataString) an array with Strings to look for in the dataString, or a dataString in the FORMAT: "wordula,1|wordlem,5|wordquer,3"
                           $dataString,                    // (String) the data String in the FORMAT: "wordula,1|wordlem,5|wordquer,3"
                           $encodeSpecialChars = true) {   // (Boolean) if TRUE it clean Speacial Chars and encode the htmlentities
            
    $exisitingDatas = explode('|',$dataString);
    
    // ->> IF given DATA is a DATASTRING
    //------------------------------
    if(is_string($givenData)) {
      $newDataString = $dataString;
      
      $givenData = explode('|',$givenData);
      
      // goes trough all searchwords
      foreach($givenData as $data) {
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
    } elseif(is_array($givenData)) {
    
      // -> COUNTS THE EXISTING SEARCHWORDS
      $countExistingData = 0;
      $newDataString = '';
      foreach($exisitingDatas as $exisitingData) {
        $exisitingData = explode(',',$exisitingData);
        $countExistingData++; 
        
        $countNewData = -1;
        foreach($givenData as $data) {
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
            $newDataString .= '|';
        }
      }
      
      // -> ADDS NEW SEARCHWORDS
      $countNewData = 0;
      foreach($givenData as $data) {
        if($encodeSpecialChars === true) {
          $data = $this->cleanSpecialChars($data,''); // entfernt Sonderzeichen
          $data = htmlentities($data,ENT_QUOTES, 'UTF-8');
          //$data = str_replace('&amp;','&',$data); // prevent double decoding
        }
        $data = strtolower($data);
        $countNewData++;
        
        if(isset($foundSw) && is_array($foundSw))
          $foundSwStr = implode('|',$foundSw);
     
        if(!isset($foundSw) || (!empty($data) && strstr($foundSwStr,$data) == false)) {
          if(!empty($data)) {// verhindert das leere Suchwort strings gespeichert werden
            if(substr($newDataString,-1) != '|')
              $newDataString .= '|';
            // fügt ein neues Suchwort in den String mit den Suchwörtern ein                
            $newDataString .= $data.',1';
            
            if($countNewData < count($givenData))
              $newDataString .= '|';
          }
        }
      }          
      //echo $newDataString.'<br />';
      
      // removes the FIRST "|"
      while(substr($newDataString,0,1) == '|') {
        $newDataString = substr($newDataString, 1);
      }
      // removes the LAST "|"
      while(substr($newDataString,-1) == '|') {
        $newDataString = substr($newDataString, 0, -1);
      }
      
      // -> SORTS the NEW SEARCHWORD STRING with THE SEARCHWORD with MOST COUNT at the BEGINNING
      if($givenData = explode('|',$newDataString)) {
      
        // sortiert den array, mithilfe der funktion sortArray
        natsort($givenData);
        usort($givenData, "sortSearchwordString");          
    
        // fügt den neugeordneten Suchworte String wieder zu einem Array zusammen
        $newDataString = implode('|',$givenData);
      }
      
      // -> RETURNs the new data String
      return $newDataString;
      
    } else return $dataString;
  }
  
  // ** -- saveLog --------------------------------------------------------------------------------
  // saves the the website statistic
  // - count user visits
  // - count bot visits 
  // - register user browser
  // - logs the last referers
  // -----------------------------------------------------------------------------------------------------
  function saveWebsiteStats() {
    global $HTTP_SESSION_VARS;
    
      //unset($_SESSION);
      
      // needed for check if the user has already visited the page AND reduce memory, because only run once the isSpider() function
      // if its an older php version, set the session var
      if(phpversion() <= '4.1.0')
        $_SESSION = $HTTP_SESSION_VARS;
      
      // COUNT if the user/spider isn't already counted
      if(!isset($_SESSION['log_agentVisited']) || $_SESSION['log_agentVisited'] === false) {
        
        // -> saves the FIRST WEBSITE VISIT
        // -----------------------------
        if(!isset($this->websiteStatistic['firstVisit']) ||
          (isset($this->websiteStatistic['firstVisit']) && empty($this->websiteStatistic['firstVisit'])))
          $this->websiteStatistic['firstVisit'] = date('Y')."-".date('m')."-".date('d').' '.date("H:i:s",time());
        
        // -> saves the LAST WEBSITE VISIT
        // ----------------------------
        $this->websiteStatistic['lastVisit'] = date('Y')."-".date('m')."-".date('d').' '.date("H:i:s",time());
        
        // -> saves the HTTP REFERER
        // ----------------------------
        $this->saveRefererLog();
        
        // ->> CHECKS if the user is NOT a BOT/SPIDER
        if ((isset($_SESSION['log_userIsSpider']) && $_SESSION['log_userIsSpider'] === false) ||
            ($_SESSION['log_userIsSpider'] = $this->isSpider()) === false) {
          
          // -> COUNT the USER UP
          if(!isset($this->websiteStatistic['userVisitCount']) ||
             (isset($this->websiteStatistic['userVisitCount']) && $this->websiteStatistic['userVisitCount'] == ''))
            $this->websiteStatistic['userVisitCount'] = '1';
          else
            $this->websiteStatistic['userVisitCount']++;
          
          // -> adds the user BROWSER
          $userBrowser = $this->getBrowser($_SERVER['HTTP_USER_AGENT']);
          if(isset($this->websiteStatistic["userBrowsers"]))
            $this->websiteStatistic["userBrowsers"] = $this->addDataToString(array($userBrowser),$this->websiteStatistic["userBrowsers"]);
          else
            $this->websiteStatistic["userBrowsers"] = '';
          
          if(!isset($this->websiteStatistic["spiderVisitCount"]))
            $this->websiteStatistic["spiderVisitCount"] = '0';
          
        // ->> COUNT the SPIDER UP
        } elseif(!isset($this->websiteStatistic['spiderVisitCount']) ||
                 (isset($this->websiteStatistic['spiderVisitCount']) && $this->websiteStatistic['spiderVisitCount'] == ''))
          $this->websiteStatistic['spiderVisitCount'] = '1';
        else
          $this->websiteStatistic['spiderVisitCount']++;

        
        // ->> OPEN website.statistic.php for writing
        if($statisticFile = @fopen(dirname(__FILE__)."/../../statistic/website.statistic.php","w")) {
          
          flock($statisticFile,2);        
          fwrite($statisticFile,PHPSTARTTAG);  
                
          fwrite($statisticFile,"\$websiteStatistic['userVisitCount'] =    '".$this->websiteStatistic["userVisitCount"]."';\n");
          fwrite($statisticFile,"\$websiteStatistic['spiderVisitCount'] =  '".$this->websiteStatistic["spiderVisitCount"]."';\n\n");
          
          fwrite($statisticFile,"\$websiteStatistic['firstVisit'] =        '".$this->websiteStatistic["firstVisit"]."';\n");
          fwrite($statisticFile,"\$websiteStatistic['lastVisit'] =         '".$this->websiteStatistic["lastVisit"]."';\n\n");
          
          fwrite($statisticFile,"\$websiteStatistic['userBrowsers'] =      '".$this->websiteStatistic["userBrowsers"]."';\n\n");
          
          fwrite($statisticFile,"return \$websiteStatistic;");
                
          fwrite($statisticFile,PHPENDTAG);        
          flock($statisticFile,3);
          fclose($statisticFile);
          
          // saves the user as visited
          $_SESSION['log_agentVisited'] = true;
        }
      }  
  }
  
  // ** -- savePageStats ----------------------------------------------------------------------------------
  // saves the statistics of a page
  // needs to have a session startet with: session_start(); in the header of the HTML Page, to prevent multiple count of page visits
  // -----------------------------------------------------------------------------------------------------
  // $pageContent      [the array, given by the readPage($page,$category) function (Array)]
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
      if ((isset($_SESSION['log_userIsSpider']) && $_SESSION['log_userIsSpider'] === false) ||
          ($_SESSION['log_userIsSpider'] = $this->isSpider()) === false) {
      
      
        // -------------------------------------------------------------------------------------
        // -->> --------------------------------------------------------------------------------
        // ->> VISIT TIME
        // --------------
        $newMinVisitTimes = '';
        $newMaxVisitTimes = '';
        $maxCount = 5;
        
        // -> count the time difference, between the last page and the current
        if(isset($_SESSION['log_lastPage'])) {
          $orgVisitTime = $this->getMicroTime() - $_SESSION['log_lastPage_timestamp'];
          // makes a time out of seconds
          $orgVisitTime = $this->secToTime($orgVisitTime);
          $visitTime = $orgVisitTime;
          
          // -> saves the MAX visitTime
          // ****
          if(!empty($_SESSION['log_lastPage']['log_visitTime_max']) && $visitTime !== false) {
          
            $maxVisitTimes = explode('|',$_SESSION['log_lastPage']['log_visitTime_max']);
            
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
            $newMaxVisitTimes = implode('|',$newMaxVisitTimes);
            
          } elseif(!empty($_SESSION['log_lastPage']['log_visitTime_max']))
            $newMaxVisitTimes = $_SESSION['log_lastPage']['log_visitTime_max'];
          else
            $newMaxVisitTimes = $orgVisitTime;
          
          // -> saves the MIN visitTime
          // ****
          if(!empty($_SESSION['log_lastPage']['log_visitTime_min']) && $visitTime !== false) {
          
            $minVisitTimes = explode('|',$_SESSION['log_lastPage']['log_visitTime_min']);
            
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
            $newMinVisitTimes = implode('|',$newMinVisitTimes);
            
          } elseif(!empty($_SESSION['log_lastPage']['log_visitTime_min']))
            $newMinVisitTimes = $_SESSION['log_lastPage']['log_visitTime_min'];
          else
            $newMinVisitTimes = '00:00:00';
            
          //echo '-> '.$newMaxVisitTimes.'<br />';
          //echo '-> '.$newMinVisitTimes.'<br />';
          
          // -> adds the new max times to the pageContent Array
          $_SESSION['log_lastPage']['log_visitTime_max'] = $newMaxVisitTimes;
          $_SESSION['log_lastPage']['log_visitTime_min'] = $newMinVisitTimes;        
          
          // -> SAVE the LAST PAGE // if file exists (problem when sorting pages, and user is on the page)
          if(file_exists(DOCUMENTROOT.$this->adminConfig['savePath'].'/'.$_SESSION['log_lastPage']['category'].'/'.$_SESSION['log_lastPage']['id'].'.php')) {
            $this->savePage($_SESSION['log_lastPage']['category'],$_SESSION['log_lastPage']['id'],$_SESSION['log_lastPage']);
            }
        }

        
        // -> saves the FIRST PAGE VISIT
        // -----------------------------
        if(empty($pageContent['log_firstVisit'])) {
          $pageContent['log_firstVisit'] = date('Y')."-".date('m')."-".date('d').' '.date("H:i:s",time());
          $pageContent['log_visitCount'] = 0;
        }
        
        // -> saves the LAST PAGE VISIT
        // ----------------------------
        $pageContent['log_lastVisit'] = date('Y')."-".date('m')."-".date('d').' '.date("H:i:s",time());
        
        // -> COUNT UP, if the user haven't already visited this page in this session
        // --------------------------------------------------------------------------
        if(!isset($_SESSION['log_visitedPages']))
          $_SESSION['log_visitedPages'] = array();
          
        if(in_array($pageContent['id'],$_SESSION['log_visitedPages']) === false) {
          //echo $pageContent['id'].' -> '.$pageContent['log_visitCount'];
          $pageContent['log_visitCount']++;
          // add to the array of already visited pages
          array_push($_SESSION['log_visitedPages'],$pageContent['id']);
        }
        
        // ->> SAVE THE SEARCHWORDs from GOOGLE, YAHOO, MSN (Bing)
        // -------------------------------------------------------
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
            
            // adds the searchwords to the searchword data string
            $pageContent['log_searchwords'] = $this->addDataToString($searchWords,$pageContent['log_searchwords']);
                  
          }
        }
        
        // stores the time of the LAST PAGE in the session
        $_SESSION['log_lastPage'] = $pageContent;
        $_SESSION['log_lastPage_timestamp'] = $this->getMicroTime();
        
        // -> SAVE the PAGE STATISTICS
        return $this->savePage($pageContent['category'],$pageContent['id'],$pageContent);
      } else return null;
      
  }

}

?>