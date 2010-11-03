<?php
/*
    feindura - Flat File Content Management System
    Copyright (C) Fabian Vogelsteller [frozeman.de]

    This program is free software;
    you can redistribute it and/or modify it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 3 of the License, or (at your option) any later version.

    This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY;
    without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
    See the GNU General Public License for more details.

    You should have received a copy of the GNU General Public License along with this program;
    if not,see <http://www.gnu.org/licenses/>.

* processes/statisticSetup.process.php version 0.12
*/

/**
 * Includes the login and filters the incoming data by xssFilter
 */
require_once(dirname(__FILE__)."/../includes/secure.include.php");

//var
$messageBox = false;

// ------------>> SAVE the STATISTIC SETTINGS
if($_POST['send'] && isset($_POST['statisticConfig'])) {

    // gets the startPage var and put it in the POST var
    $_POST['startPage'] = $websiteConfig['startPage'];
    
    $_POST['copyright'] = $_POST['websiteConfig_copyright'];
    if(saveStatisticConfig($_POST)) {
      // set documentSaved status
      $documentSaved = true;
      $statisticFunctions->saveTaskLog(19); // <- SAVE the task in a LOG FILE
    } else
      $errorWindow .= $langFile['statisticSetup_statisticConfig_error_save'];
  
  $savedForm = 'statisticConfig';
}

// ------------>> CLEAR the STATISTICs
if($_POST['sendClearstatistics']) {
  
  $messageBoxText = false;
  
  // ->> CLEAR PAGES-STATISTICs
  if($_POST['clearStatistics_pagesStatistics'] == 'true' &&
     $pages = $generalFunctions->loadPages(true,true)) {
      
    foreach($pages as $pageContent) {
      
      // -> CLEAR the page stats
      $pageContent['log_visitorcount'] = '';
      $pageContent['log_visitTime_min'] = '';
      $pageContent['log_visitTime_max'] = '';
      $pageContent['log_firstVisit'] = '';
      $pageContent['log_lastVisit'] = '';
      $pageContent['log_searchwords'] = '';
      
      if($generalFunctions->savePage($pageContent)) {        
        // set documentSaved status
        $documentSaved = true;
      } else
        $errorWindow .= $langFile['statisticSetup_clearStatistic_pagesStatistics_error_read'];
    }
    
    // set the messagebox; save tasklog
    if($documentSaved) {
      $messageBoxText .= '&rArr; '.$langFile['LOG_CLEARSTATISTICS_PAGESTATISTICS'].'<br />';
      $statisticFunctions->saveTaskLog(20); // <- SAVE the task in a LOG FILE
    }
  }
  
  // ->> CLEAR PAGES-LENGTHOFSTAY-STATISTICs
  if($_POST['clearStatistics_pagesStaylengthStatistics'] == 'true' &&
     $pages = $generalFunctions->loadPages(true,true)) {
      
    foreach($pages as $pageContent) {
      
      // -> CLEAR the page stats
      $pageContent['log_visitTime_min'] = '';
      $pageContent['log_visitTime_max'] = '';
      
      if($generalFunctions->savePage($pageContent)) {        
        // set documentSaved status
        $documentSaved = true;
      } else
        $errorWindow .= $langFile['statisticSetup_clearStatistic_pagesStatistics_error_read'];
    }
    
    // set the messagebox; save tasklog
    if($documentSaved) {
      $messageBoxText .= '&rArr; '.$langFile['LOG_CLEARSTATISTICS_PAGESTAYLENGTH'].'<br />';
      $statisticFunctions->saveTaskLog(21); // <- SAVE the task in a LOG FILE
    }
  }  
  
  // ->> CLEAR WEBSITE-STATISTIC
  if($_POST['clearStatistics_websiteStatistic'] == 'true' &&
     file_exists(dirname(__FILE__)."/../../statistic/website.statistic.php") &&
     unlink(dirname(__FILE__)."/../../statistic/website.statistic.php")) {
    
    // set documentSaved status
    $documentSaved = true;
    $messageBoxText .= '&rArr; '.$langFile['LOG_CLEARSTATISTICS_WEBSITESTATISTIC'].'<br />';
    $statisticFunctions->saveTaskLog(22); // <- SAVE the task in a LOG FILE
  }
  
  // ->> CLEAR REFERER-LOG
  if($_POST['clearStatistics_refererLog'] == 'true' &&
     $refererLogFile = fopen(dirname(__FILE__)."/../../statistic/referer.statistic.log","w")) {
    fclose($refererLogFile);
    
    // set documentSaved status
    $documentSaved = true;
    $messageBoxText .= '&rArr; '.$langFile['LOG_CLEARSTATISTICS_REFERERLOG'].'<br />';
    $statisticFunctions->saveTaskLog(23); // <- SAVE the task in a LOG FILE
  }
  
  // ->> CLEAR ACTIVITY-LOG
  if($_POST['clearStatistics_taskLog'] == 'true' &&
     $taskLogFile = fopen(dirname(__FILE__)."/../../statistic/activity.statistic.log","w")) {
    fclose($taskLogFile);
    
    // set documentSaved status
    $documentSaved = true;
    $messageBoxText .= '&rArr; '.$langFile['LOG_CLEARSTATISTICS_ACTIVITYLOG'].'<br />';
    $statisticFunctions->saveTaskLog(24); // <- SAVE the task in a LOG FILE
  }
  
  // SHOWs the MESSAGEBOX
  if($messageBoxText !== false) {
    $messageBox = '<div class="messageBox">';  
    $messageBox .=  '<span class="red">'.$messageBoxText.'</span>';
    $messageBox .=  '</div>';
  }
  
  $savedForm = 'clearStatistics';
}

// RE-INCLUDE
$statisticConfig = @include (dirname(__FILE__)."/../../config/statistic.config.php");
// RESET of the vars in the classes
$statisticFunctions->statisticConfig = $statisticConfig;

?>