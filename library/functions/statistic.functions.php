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
// library/functions/general.functions.php version 0.29


//error_reporting(E_ALL);

// ** -- getmicrotime ------------------------------------------------------------------------------
// returns a unix timestamp as float
// -------------------------------------------------------------------------------------------------
function getMicroTime(){
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

// ** -- showVisitTime -----------------------------------------------------------------------------
// SHOWs the visitTime as text
// -------------------------------------------------------------------------------------------------
function showVisitTime($time) {
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
      $time = '<b>'.$hour.'</b>:'.$minute.':'.$second;
  // 01:01 Stunden
  elseif($hour !== false && $minute !== false && $second === false)
      $time = '<b>'.$hour.'</b>:'.$minute;
  // 01:01 Minuten
  elseif($hour === false && $minute !== false && $second !== false)
      $time = '<b>'.$minute.'</b>:'.$second; 
  
  // 01 Stunden
  elseif($hour !== false && $minute === false && $second === false)
      $time = '<b>'.$hour.'</b>';
  // 01 Minuten
  elseif($hour === false && $minute !== false && $second === false)
      $time = '<b>'.$minute.'</b>';
  // 01 Sekunden
  elseif($hour === false && $minute === false && $second !== false)
      $time = '<b>'.$second.'</b>';
  
  
  // get the time together
  if($hour) {
    if($hour == 1)
      $time = $time.' <b>'.$langFile['log_hour_single'].'</b>';
    else
      $time = $time.' <b>'.$langFile['log_hour_multiple'].'</b>';
  } elseif($minute) {
    if($hour == 1)
      $time = $time.' <b>'.$langFile['log_minute_single'].'</b>';
    else
      $time = $time.' <b>'.$langFile['log_minute_multiple'].'</b>';
  } elseif($second) {
    if($hour == 1)
      $time = $time.' <b>'.$langFile['log_second_single'].'</b>';
    else
      $time = $time.' <b>'.$langFile['log_second_multiple'].'</b>';
  }
  
  
  // RETURN formated time
  return $time;
}

// ** -- createTagCloud --------------------------------------------------------------------------------
// creates a tag cloud out of the searchwords
// -----------------------------------------------------------------------------------------------------
// $searchWordString         [Der String der die suchworte enthält im Format: 'suchwort,1|suchwort,3|...'  (String)],
// $minFontSize              [Die minimal Schriftartgröße (Number)],
// $maxFontSize              [Die maximale Schriftartgröße (Number)]
function createTagCloud($searchWordString,$minFontSize = 10,$maxFontSize = 20) {
  global $langFile;
  
  if(!empty($searchWordString)) {
    foreach(explode('|',$searchWordString) as $searchWord) {   
      $searchWords[] =  explode(',',$searchWord);
    }
    
    $swHighestNumber = $searchWords[0][1];
    $swLowestNumber = $searchWords[count($searchWords)-1][1];
    
    foreach($searchWords as $searchWord) {
      
      $fontSize = $searchWord[1] / $swHighestNumber;
      $fontSize = round($fontSize * $maxFontSize) + $minFontSize;
      
      echo '<span style="font-size:'.$fontSize.'px;color:#C37B43;" class="toolTip" title="[span]&quot;'.$searchWord[0].'&quot;[/span] '.$langFile['log_searchwordtothissite_part1'].' [span]'.$searchWord[1].'[/span] '.$langFile['log_searchwordtothissite_part2'].'::">'.$searchWord[0].',</span>'."\n"; //<span style="color:#888888;">('.$searchWord[1].')</span>
    
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
    // User-Agent is no Bot
    return false;
  
  } else return false; // HTTP_USER_AGENT ist nicht vorhanden
}

// * -- sortSearchwordString ----------------------------------------------------------------------------------
// sorts the searchword string, with the most counted at the beginning
// -----------------------------------------------------------------------------------------------------
function sortSearchwordString($a, $b) {
  $aExp = explode(',',$a);
  $bExp = explode(',',$b);
  
  if ($aExp[1] == $bExp[1]) {
      return 0;
  }      
  //echo 'A:'.$aExp[1].'<br />';
  //echo 'B:'.$bExp[1].'<br />';
  return ($aExp[1] > $bExp[1]) ? -1 : 1;
}

// ** -- savePageStats ----------------------------------------------------------------------------------
// saves the statistics of a page
// needs to have a session startet with: session_start(); in the header of the HTML Page, to prevent multiple count of page visits
// -----------------------------------------------------------------------------------------------------
// $pageContent      [the array, given by the readPage($page,$category) function (Array)]
function savePageStats($pageContent) {
    global $adminConfig;
    global $_SESSION; // needed for check if the user has already visited the page AND reduce memory, because only run once the isSpider() function
    global $HTTP_SESSION_VARS;
    
    //unset($_SESSION);
    
    // if its an older php version, set the session var
    if(phpversion() <= '4.1.0')
      $_SESSION = $HTTP_SESSION_VARS;

    // --------------------------------------------------------------------------------
    // CHECKS if the user is NOT a BOT/SPIDER
    if ((isset($_SESSION['log_userIsSpider']) && $_SESSION['log_userIsSpider'] === false) ||
        ($_SESSION['log_userIsSpider'] = isSpider()) === false) {
      
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
          $exisitingSearchWords = explode('|',$pageContent['log_searchwords']);
          
          // -> COUNTS THE EXISTING SEARCHWORDS
          $countExistingSw = 0;
          $newSearchString = '';
          foreach($exisitingSearchWords as $exisitingSearchWord) {          
            $exisitingSearchWord = explode(',',$exisitingSearchWord);
            $countExistingSw++; 
            
            $countNewSw = -1;
            foreach($searchWords as $searchWord) {            
              $searchWord = cleanSpecialChars($searchWord,''); // entfernt Sonderzeichen
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
          
            $searchWord = cleanSpecialChars($searchWord,''); // entfernt Sonderzeichen
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
        }
      }      
      
      // ->> VISIT TIME
      // --------------
      $newMinVisitTimes = '';
      $newMaxVisitTimes = '';
      $maxCount = 5;
      
      // -> count the time difference, between the last page and the current
      if(isset($_SESSION['log_lastPage'])) {
        $orgVisitTime = getMicroTime() - $_SESSION['log_lastPage_timestamp'];
        
        // makes a time out of seconds
        $orgVisitTime = secToTime($orgVisitTime);
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
        
        // -> adds the new max times to the pageContent Array
        $_SESSION['log_lastPage']['log_visitTime_min'] = $newMinVisitTimes;
        $_SESSION['log_lastPage']['log_visitTime_max'] = $newMaxVisitTimes;
        
        // -> SAVE the LAST PAGE
        savePage($_SESSION['log_lastPage']['category'],$_SESSION['log_lastPage']['id'],$_SESSION['log_lastPage']);
      }
      // stores the time of the LAST PAGE in the session
      $_SESSION['log_lastPage'] = $pageContent;
      $_SESSION['log_lastPage_timestamp'] = getMicroTime();
      

      // -> SAVE the PAGE STATISTICS
      return savePage($pageContent['category'],$pageContent['id'],$pageContent);
    }
}

?>