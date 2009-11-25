<?php
/*
    feindura - Flat File Content Management System
    Copyright (C) 2009 Fabian Vogelsteller [frozeman.de]

    This program is free software;
    you can redistribute it and/or modify it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 3 of the License, or (at your option) any later version.

    This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY;
    without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
    See the GNU General Public License for more details.

    You should have received a copy of the GNU General Public License along with this program;
    if not,see <http://www.gnu.org/licenses/>.
*/
// library/classes/general.class.php version 0.35


//error_reporting(E_ALL);


class statisticFunctions {
  
  // PUBLIC
  // *********
  var $adminConfig;                       // [Array] the Array with the adminConfig Data from the feindura CMS
  var $categoryConfig;                    // [Array] the Array with the categoryConfig Data from the feindura CMS
  
  var $generalFunctions;
  
  // -> START ** constructor *****************************************************************************
  // the class constructor
  // get the config arrays
  // -----------------------------------------------------------------------------------------------------
  public function statisticFunctions() {   // (String) string with the COUNTRY CODE ("de", "en", ..)
    global $adminConfig;
    global $categories;
    
    // GET CONFIG FILES and SET CONFIG PROPERTIES
    $this->adminConfig = $adminConfig;
    $this->categoryConfig = $categories;
    
    // GET FUNCTIONS
    $this->generalFunctions = new generalFunctions();
  
    return true;
  }

  // ** -- getmicrotime ------------------------------------------------------------------------------
  // returns a unix timestamp as float
  // -------------------------------------------------------------------------------------------------
  public function getMicroTime(){
    list($usec, $sec) = explode(" ",microtime());
    return ((float)$usec + (float)$sec);
  }
  
  // ** -- secToMin ----------------------------------------------------------------------------------
  // changes seconds in minutes
  // -------------------------------------------------------------------------------------------------
  public function secToTime($sec) {
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
  public function formatDate($givenDate,               // (String like: yyyy-mm-dd hh:mm:ss) the date given in a database-date-format like: yyyy-mm-dd hh:mm:ss
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
  public function formatTime($givenDate,$showSeconds = false) {
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
  public function formatHighNumber($number,$decimalsNumber = 0) {  
    return number_format($number, $decimalsNumber, ',', ' ');
  }
  
   // ** -- validateDateFormat ----------------------------------------------------------------------------------
  // checks the date,
  // RETURNs a validated array
  // with the array[0] =text before the date,
  // and array[1] = the date (in FORMAT YYYY-MM-DD), or FALSE
  // -----------------------------------------------------------------------------------------------------
  public function validateDateFormat($dateString) {       // (String) the given string with an date on the end
    
    if(!is_string($dateString))
      return false;
      
    // get the date out of the $dateString
    //$date = substr($dateString, -10);
    //$beforeDate = substr($dateString,0, -10);
    $date = str_replace(array('\'', ';', '-', '.', ','), '/', $dateString);
    
    $date = explode('/', $date);
  
    // checks a date with no seperation signs -> has to have the format YYYYMMDD or DDMMYYYY
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
    }
    
    // check if it is a date format 'de' or 'int'
    /*
    if (($format == 'eu' && !preg_match('/^(\d{2})\/(\d{2})\/(\d{4})$/', trim($date), $matches)) ||
        ($format == 'int' && !preg_match('/^(\d{4})\/(\d{2})\/(\d{2})$/', trim($date), $matches))) {
        return false;
    }
    */
    
    // checks the array with the date
    if(count($date) == 3 &&
       is_numeric($date[0]) &&
       is_numeric($date[1]) &&
       is_numeric($date[2])) {
  
      //ddmmyyyy
      if(checkdate($date[1], $date[0], $date[2]))
        return $date[2].'-'.$date[1].'-'.$date[0];
      //yyyymmdd
      elseif(checkdate($date[1], $date[2], $date[0]))
        return $date[0].'-'.$date[1].'-'.$date[2];
      //mmddyyyy
      elseif(checkdate($date[0], $date[1], $date[2]))
        return $date[2].'-'.$date[0].'-'.$date[1];    
      else
        return false;
    }
   
    // wenn die funktion nichts anderes zurückgegeben hat return false
    return false;
  }
  
  // ** -- showVisitTime -----------------------------------------------------------------------------
  // SHOWs the visitTime as text
  // -------------------------------------------------------------------------------------------------
  public function showVisitTime($time) {
    global $langFile;
    
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
        $time = $time.' <b>'.$langFile['log_hour_single'].'</b>';
      else
        $time = $time.' <b>'.$langFile['log_hour_multiple'].'</b>';
    } elseif($minute) {
      if($minute == 1)
        $time = $time.' <b>'.$langFile['log_minute_single'].'</b>';
      else
        $time = $time.' <b>'.$langFile['log_minute_multiple'].'</b>';
    } elseif($second) {
      if($second == 1)
        $time = $time.' <b>'.$langFile['log_second_single'].'</b>';
      else
        $time = $time.' <b>'.$langFile['log_second_multiple'].'</b>';
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
  public function saveTaskLog($task,               // (String) a description of the task which was performed
                   $object = false) {   // (String) the page name or the name of the object on which the task was performed
    global $langFile;
    
    $maxEntries = 119;
    $logFile = dirname(__FILE__).'/../../'.'statistic/log_tasks.txt';
    
    if(file_exists($logFile))
      $oldLog = file($logFile);
      
    if($logFile = @fopen($logFile,"w")) {
      
      // adds a break before the object
      if($object)
        $object = '::'.$object;
      
      // -> create the new log string
      $newLog = date('Y')."-".date('m')."-".date('d').' '.date("H:i:s",time()).' '.$task.$object;
      
      // -> write the new log file
      flock($logFile,2);    
      fwrite($logFile,$newLog."\n");    
      $count = 1;
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
  
  // ** -- saveRefererLog --------------------------------------------------------------------------------
  // SAVE a log file with links where the people are coming from
  // -----------------------------------------------------------------------------------------------------
  public function saveRefererLog() {   // (String) the page name or the name of the object on which the task was performed
    global $langFile;
    
    $maxEntries = 300;
    $logFile = dirname(__FILE__).'/../../'.'statistic/log_referers.txt';
    
    if(file_exists($logFile))
      $oldLog = file($logFile);
      
    if(isset($_SERVER['HTTP_REFERER']) && !empty($_SERVER['HTTP_REFERER']) && $logFile = @fopen($logFile,"w")) {
      
      // -> create the new log string
      $newLog = date('Y')."-".date('m')."-".date('d').' '.date("H:i:s",time()).' '.$_SERVER['HTTP_REFERER'];
      
      // -> write the new log file
      flock($logFile,2);    
      fwrite($logFile,$newLog."\n");    
      $count = 1;
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
  
  // ** -- createBrowserChart --------------------------------------------------------------------------------
  // creates a chart to display the browsers, used by the users
  // -----------------------------------------------------------------------------------------------------
  // $searchWordString         [Der String der die suchworte enthält im Format: 'suchwort,1|suchwort,3|...'  (String)],
  // $minFontSize              [Die minimal Schriftartgröße (Number)],
  // $maxFontSize              [Die maximale Schriftartgröße (Number)]
  public function createBrowserChart() {
    global $websiteStatistic;
    global $langFile;
    
    foreach(explode('|',$websiteStatistic['userBrowsers']) as $browser) {   
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
        $browserColor = 'browserBg_firefox.png';
        $browserLogo = 'browser_firefox.png';
      } elseif($browser[0] == 'netscape') {
        $browserName = 'Netscape Navigator';
        $browserColor = 'browserBg_netscape.png';
        $browserLogo = 'browser_netscape.png';
      } elseif($browser[0] == 'chrome') {
        $browserName = 'Google Chrome';
        $browserColor = 'browserBg_chrome.png';
        $browserLogo = 'browser_chrome.png';
      } elseif($browser[0] == 'ie') {
        $browserName = 'Internet Explorer';
        $browserColor = 'browserBg_ie.png';
        $browserLogo = 'browser_ie.png';
      } elseif($browser[0] == 'opera') {
        $browserName = 'Opera';
        $browserColor = 'browserBg_opera.png';
        $browserLogo = 'browser_opera.png';
      } elseif($browser[0] == 'konqueror') {
        $browserName = 'Konqueror';
        $browserColor = 'browserBg_konqueror.png';
        $browserLogo = 'browser_konqueror.png';
      } elseif($browser[0] == 'lynx') {
        $browserName = 'Lynx';
        $browserColor = 'browserBg_lynx.png';
        $browserLogo = 'browser_lynx.png';
      } elseif($browser[0] == 'safari') {
        $browserName = 'Safari';
        $browserColor = 'browserBg_safari.png';
        $browserLogo = 'browser_safari.png';
      } elseif($browser[0] == 'mozilla') {
        $browserName = 'Mozilla';
        $browserColor = 'browserBg_mozilla.png';
        $browserLogo = 'browser_mozilla.png';
      } elseif($browser[0] == 'others') {
        $browserName = $langFile['log_browser_others'];
        $browserColor = 'browserBg_others.png';
        $browserLogo = 'browser_others.png';
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
      echo '<td style="'.$cellpadding.';width:'.$tablePercent.'%;background:url(library/image/bg/'.$browserColor.') repeat-x;" class="toolTip" title="[span]'.$browserName.'[/span] ('.$tablePercent.'%)::'.$browser[1].' '.$langFile['log_visitCount'].'"><img src="library/image/sign/'.$browserLogo.'" style="float:left;'.$logoSize.'" alt="browser logo" />'.$cellText.'</td>';
    
    }
    echo '</tr></table>';
  
  
  }
  
  // ** -- createTagCloud --------------------------------------------------------------------------------
  // creates a tag cloud out of the searchwords
  // -----------------------------------------------------------------------------------------------------
  // $searchWordString         [Der String der die suchworte enthält im Format: 'suchwort,1|suchwort,3|...'  (String)],
  // $minFontSize              [Die minimal Schriftartgröße (Number)],
  // $maxFontSize              [Die maximale Schriftartgröße (Number)]
  public function createTagCloud($searchWordString,$minFontSize = 10,$maxFontSize = 20) {
    global $langFile;
    
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
        
        echo '<span style="font-size:'.$fontSize.'px;" class="toolTip brown" title="[span]&quot;'.$searchWord[0].'&quot;[/span] '.$langFile['log_searchwordtothissite_part1'].' [span]'.$searchWord[1].'[/span] '.$langFile['log_searchwordtothissite_part2'].'::">'.$searchWord[0].'</span>&nbsp;&nbsp;'."\n"; //<span style="color:#888888;">('.$searchWord[1].')</span>
      
      }
    } else {
      echo '<span class="blue" style="font-size:15px;">'.$langFile['log_notags'].'</span>';
    }
  }
  
  
  // ** -- isSpider ----------------------------------------------------------------------------------
  // checks if the user-agent is bot/spider
  // actual botlist from http://spiderlist.codeforgers.com/
  // require spiders.xml/spiders.txt
  // ---------------------------------------------------------------------------------------------------
  public function isSpider() {
  
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
      // User-Agent is no Bot
      return false;
    
    } else return false; // HTTP_USER_AGENT ist nicht vorhanden
  }

  
  // ** -- addDataToString ----------------------------------------------------------------------------------
  // adds to a string like "wordula,1|wordlem,5|wordquer,3" a new word or count up an exisiting word
  // -----------------------------------------------------------------------------------------------------
  public function addDataToString($dataArray,       // (Array) an array with Strings to look for in the dataString
                                  $dataString) {    // (String) the data String in the FORMAT: "wordula,1|wordlem,5|wordquer,3"
            
    $exisitingDatas = explode('|',$dataString);
            
    // -> COUNTS THE EXISTING SEARCHWORDS
    $countExistingData = 0;
    $newDataString = '';
    foreach($exisitingDatas as $exisitingData) {          
      $exisitingData = explode(',',$exisitingData);
      $countExistingData++; 
      
      $countNewData = -1;
      foreach($dataArray as $data) {            
        $data = $this->generalFunctions->cleanSpecialChars($data,''); // entfernt Sonderzeichen
        $data = htmlentities($data,ENT_QUOTES, 'UTF-8');
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
    foreach($dataArray as $data) {
    
      $data = $this->generalFunctions->cleanSpecialChars($data,''); // entfernt Sonderzeichen
      $data = htmlentities($data,ENT_QUOTES, 'UTF-8');
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
          
          if($countNewData < count($dataArray))
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
    if($dataArray = explode('|',$newDataString)) {
    
      // sortiert den array, mithilfe der funktion sortArray
      natsort($dataArray);
      usort($dataArray, "sortSearchwordString");          
  
      // fügt den neugeordneten Suchworte String wieder zu einem Array zusammen
      $newDataString = implode('|',$dataArray);
    }
    
    // RETURNs the new data String
    return $newDataString;
  }
  
  // ** -- saveLog --------------------------------------------------------------------------------
  // saves the the website statistic
  // - count user visits
  // - count bot visits 
  // - register user browser
  // - logs the last referers
  // -----------------------------------------------------------------------------------------------------
  public function saveWebsiteStats() {
    global $generalFunctions; 
    global $websiteStatistic;
    global $_SESSION; // needed for check if the user has already visited the page AND reduce memory, because only run once the isSpider() function
    global $HTTP_SESSION_VARS;
    
      //unset($_SESSION);
      
      // if its an older php version, set the session var
      if(phpversion() <= '4.1.0')
        $_SESSION = $HTTP_SESSION_VARS;
      
      // COUNT if the user/spider isn't already counted
      if(!isset($_SESSION['log_agentVisited']) || $_SESSION['log_agentVisited'] === false) {
        
        // -> saves the FIRST WEBSITE VISIT
        // -----------------------------
        if(empty($websiteStatistic['firstVisit']))
          $websiteStatistic['firstVisit'] = date('Y')."-".date('m')."-".date('d').' '.date("H:i:s",time());
        
        // -> saves the LAST WEBSITE VISIT
        // ----------------------------
        $websiteStatistic['lastVisit'] = date('Y')."-".date('m')."-".date('d').' '.date("H:i:s",time());
        
        // -> saves the HTTP REFERER
        // ----------------------------
        $this->saveRefererLog();
        
        // -> CHECKS if the user is NOT a BOT/SPIDER
        if ((isset($_SESSION['log_userIsSpider']) && $_SESSION['log_userIsSpider'] === false) ||
            ($_SESSION['log_userIsSpider'] = $this->isSpider()) === false) {
          
          // -> COUNT the USER UP
          if($websiteStatistic['userVisitCount'] == '')
            $websiteStatistic['userVisitCount'] = '1';
          else
            $websiteStatistic['userVisitCount']++;
          
          // -> adds the user BROWSER
          $userBrowser = $this->generalFunctions->getBrowser($_SERVER['HTTP_USER_AGENT']);
          $websiteStatistic["userBrowsers"] = $this->addDataToString(array($userBrowser),$websiteStatistic["userBrowsers"]);
          
        // -> COUNT the SPIDER UP
        } elseif($websiteStatistic['spiderVisitCount'] == '')
          $websiteStatistic['spiderVisitCount'] = '1';
        else
          $websiteStatistic['spiderVisitCount']++;
        
        // ->> OPEN websiteStatistic.php for writing
        if($statisticFile = @fopen(dirname(__FILE__)."/../../statistic/websiteStatistic.php","w")) {
  
          
          flock($statisticFile,2);        
          fwrite($statisticFile,PHPSTARTTAG);  
                
          fwrite($statisticFile,"\$websiteStatistic['userVisitCount'] =    '".$websiteStatistic["userVisitCount"]."';\n");
          fwrite($statisticFile,"\$websiteStatistic['spiderVisitCount'] =  '".$websiteStatistic["spiderVisitCount"]."';\n\n");
          
          fwrite($statisticFile,"\$websiteStatistic['firstVisit'] =        '".$websiteStatistic["firstVisit"]."';\n");
          fwrite($statisticFile,"\$websiteStatistic['lastVisit'] =         '".$websiteStatistic["lastVisit"]."';\n\n");
          
          fwrite($statisticFile,"\$websiteStatistic['userBrowsers'] =      '".$websiteStatistic["userBrowsers"]."';\n\n");
          
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
  public function savePageStats($pageContent) {
      global $generalFunctions;
      global $_SESSION; // needed for check if the user has already visited the page AND reduce memory, because only run once the isSpider() function
      global $HTTP_SESSION_VARS;
      
      //unset($_SESSION);
      
      // if its an older php version, set the session var
      if(phpversion() <= '4.1.0')
        $_SESSION = $HTTP_SESSION_VARS;    
      
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
          
          // -> SAVE the LAST PAGE
          $this->generalFunctions->savePage($_SESSION['log_lastPage']['category'],$_SESSION['log_lastPage']['id'],$_SESSION['log_lastPage']);
        }
        // stores the time of the LAST PAGE in the session
        $_SESSION['log_lastPage'] = $pageContent;
        $_SESSION['log_lastPage_timestamp'] = $this->getMicroTime();
        
      
      // -------------------------------------------------------------------------------------
      // -->> --------------------------------------------------------------------------------
      // CHECKS if the user is NOT a BOT/SPIDER
      if ((isset($_SESSION['log_userIsSpider']) && $_SESSION['log_userIsSpider'] === false) ||
          ($_SESSION['log_userIsSpider'] = $this->isSpider()) === false) {
        
        // -> saves the FIRST PAGE VISIT
        // -----------------------------
        if(empty($pageContent['log_firstVisit'])) {
          $pageContent['log_firstVisit'] = date('Y')."-".date('m')."-".date('d').' '.date("H:i:s",time());
          $pageContent['log_visitCount'] = 1;
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
        if(!empty($_SERVER['HTTP_REFERER'])) {
          $searchWords = parse_url($_SERVER['HTTP_REFERER']);
          // test search url strings:
          //$searchWords = parse_url('http://www.google.de/search?q=mair%E4nd+%26+geld+syteme%3F&ie=utf-8&oe=utf-8&aq=t&rls=org.mozilla:de:official&client=firefox-a');
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
            //$searchWords = urldecode($searchWords);
            $searchWords = explode('+',$searchWords);    
            
            // adds the searchwords to the searchword data string
            $pageContent['log_searchwords'] = $this->addDataToString($searchWords,$pageContent['log_searchwords']);
            
            /*
            $exisitingSearchWords = explode('|',$pageContent['log_searchwords']);
            
            // -> COUNTS THE EXISTING SEARCHWORDS
            $countExistingSw = 0;
            $newSearchString = '';
            foreach($exisitingSearchWords as $exisitingSearchWord) {          
              $exisitingSearchWord = explode(',',$exisitingSearchWord);
              $countExistingSw++; 
              
              $countNewSw = -1;
              foreach($searchWords as $searchWord) {            
                $searchWord = $generalFunctions->cleanSpecialChars($searchWord,''); // entfernt Sonderzeichen
                $searchWord = htmlentities($searchWord,ENT_QUOTES, 'UTF-8');
                $searchWord = strtolower($searchWord);
                $countNewSw++;
                
                // wenn es das Stichwort schon gibt
                if($exisitingSearchWord[0] == $searchWord) {
                  // zählt ein die Anzahl des Stichworts höher
                  $exisitingSearchWord[1]++;
                  $foundSw[] = $searchWord;
                }
              }
              
              // adds the old Searchwords (maybe counted up) to the String with the new ones            
              if(!empty($exisitingSearchWord[0])) {
                $newSearchString .= $exisitingSearchWord[0].','.$exisitingSearchWord[1];
                if($countExistingSw < count($exisitingSearchWords))
                  $newSearchString .= '|';
              }
            }
            
            // -> ADDS NEW SEARCHWORDS
            $countNewSw = 0;
            foreach($searchWords as $searchWord) {
            
              $searchWord = $generalFunctions->cleanSpecialChars($searchWord,''); // entfernt Sonderzeichen
              $searchWord = htmlentities($searchWord,ENT_QUOTES, 'UTF-8');
              $searchWord = strtolower($searchWord);
              $countNewSw++;
              
              if(isset($foundSw) && is_array($foundSw))
                $foundSwStr = implode('|',$foundSw);
           
              if(!isset($foundSw) || (!empty($searchWord) && strstr($foundSwStr,$searchWord) == false)) {
                if(!empty($searchWord)) {// verhindert das leere Suchwort strings gespeichert werden
                  if(substr($newSearchString,-1) != '|')
                    $newSearchString .= '|';
                  // fügt ein neues Suchwort in den String mit den Suchwörtern ein                
                  $newSearchString .= $searchWord.',1';
                  
                  if($countNewSw < count($searchWords))
                    $newSearchString .= '|';
                }
              }
            }          
            //echo $newSearchString.'<br />';
            
            // removes the FIRST "|"
            while(substr($newSearchString,0,1) == '|') {
              $newSearchString = substr($newSearchString, 1);
            }
            // removes the LAST "|"
            while(substr($newSearchString,-1) == '|') {
              $newSearchString = substr($newSearchString, 0, -1);
            }
            
            // -> SORTS the NEW SEARCHWORD STRING with THE SEARCHWORD with MOST COUNT at the BEGINNING
            if($searchWords = explode('|',$newSearchString)) {
            
              // sortiert den array, mithilfe der funktion sortArray
              natsort($searchWords);
              usort($searchWords, "sortSearchwordString");          
        
              // fügt den neugeordneten Suchworte String wieder zu einem Array zusammen
              $newSearchString = implode('|',$searchWords);
            }          
            
            // replace the SEARCHWORDS var
            $pageContent['log_searchwords'] = $newSearchString;
            */       
          }
        }
  
        // -> SAVE the PAGE STATISTICS
        return $this->generalFunctions->savePage($pageContent['category'],$pageContent['id'],$pageContent);
      }
  }
}

?>