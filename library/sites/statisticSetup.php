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

* statisticSetup.php version 0.12
*/

$savedForm = false;

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
      $pageContent['log_visitCount'] = '';
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
      $messageBoxText .= '&rArr; '.$langFile['log_clearStatistic_pagesStatistics'].'<br />';
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
      $messageBoxText .= '&rArr; '.$langFile['log_clearStatistic_pagesStaylengthStatistics'].'<br />';
      $statisticFunctions->saveTaskLog(21); // <- SAVE the task in a LOG FILE
    }
  }  
  
  // ->> CLEAR WEBSITE-STATISTIC
  if($_POST['clearStatistics_websiteStatistic'] == 'true' &&
     file_exists(dirname(__FILE__)."/../../statistic/website.statistic.php") &&
     unlink(dirname(__FILE__)."/../../statistic/website.statistic.php")) {
    
    // set documentSaved status
    $documentSaved = true;
    $messageBoxText .= '&rArr; '.$langFile['log_clearStatistic_websiteStatistic'].'<br />';
    $statisticFunctions->saveTaskLog(22); // <- SAVE the task in a LOG FILE
  }
  
  // ->> CLEAR REFERER-LOG
  if($_POST['clearStatistics_refererLog'] == 'true' &&
     $refererLogFile = fopen(dirname(__FILE__)."/../../statistic/referer.statistic.log","w")) {
    fclose($refererLogFile);
    
    // set documentSaved status
    $documentSaved = true;
    $messageBoxText .= '&rArr; '.$langFile['log_clearStatistic_refererLog'].'<br />';
    $statisticFunctions->saveTaskLog(23); // <- SAVE the task in a LOG FILE
  }
  
  // ->> CLEAR ACTIVITY-LOG
  if($_POST['clearStatistics_taskLog'] == 'true' &&
     $taskLogFile = fopen(dirname(__FILE__)."/../../statistic/activity.statistic.log","w")) {
    fclose($taskLogFile);
    
    // set documentSaved status
    $documentSaved = true;
    $messageBoxText .= '&rArr; '.$langFile['log_clearStatistic_taskLog'].'<br />';
    $statisticFunctions->saveTaskLog(24); // <- SAVE the task in a LOG FILE
  }
  
  // SHOWs the MESSAGEBOX
  if($messageBoxText !== false) {
    echo '<div class="messageBox">';  
    echo '<span class="red">'.$messageBoxText.'</span>';
    echo '</div>';
  }
  
  $savedForm = 'clearStatistics';
}

// RE-INCLUDE
$statisticConfig = @include (dirname(__FILE__)."/../../config/statistic.config.php");
// RESET of the vars in the classes
$statisticFunctions->statisticConfig = $statisticConfig;

// ------------------------------- ENDE DES SCRIPTs ZUM SPEICHERN DER VARIABLEN ----------------------------------

?>

<!-- OVERVIEW STATISTIC SETTINGS -->

<form action="index.php?site=statisticSetup#statisticSettings" method="post" enctype="multipart/form-data" accept-charset="UTF-8">
  <div><input type="hidden" name="send" value="true" /></div>

<?php
// show the block below if it is the ones which is saved before
if($savedForm == 'statisticConfig' || $savedForm === false)
    $hidden = '';
  else
    $hidden = ' hidden';  
?>
<div class="block<?php echo $hidden; ?>">
  <h1><a href="#" id="statisticSettings" name="statisticSettings"><?php echo $langFile['statisticSetup_statisticConfig_h1']; ?></a></h1>
  <div class="content">
    <table>
     
      <colgroup>
      <col class="left" />
      </colgroup>
  
      <tr><td class="leftTop"></td><td></td></tr>
      
      <tr><td class="left">
      <label for="numberMostVisitedPages"><span class="toolTip" title="<?php echo '::'.$langFile['statisticSetup_statisticConfig_field1_tip']; ?>">
      <?php echo $langFile['statisticSetup_statisticConfig_field1']; ?></span></label>
      </td><td class="right">
      <input id="numberMostVisitedPages" name="number[mostVisitedPages]" class="short" value="<?php echo $statisticConfig['number']['mostVisitedPages']; ?>" />
      </td></tr>
      
      <tr><td class="left">
      <label for="numberLongestVisitedPages"><span class="toolTip" title="<?php echo '::'.$langFile['statisticSetup_statisticConfig_field2_tip']; ?>">
      <?php echo $langFile['statisticSetup_statisticConfig_field2']; ?></span></label>
      </td><td class="right">
      <input id="numberLongestVisitedPages" name="number[longestVisitedPages]" class="short" value="<?php echo $statisticConfig['number']['longestVisitedPages']; ?>" />
      </td></tr>
      
      <tr><td class="left">
      <label for="numberLastEditedPages"><span class="toolTip" title="<?php echo '::'.$langFile['statisticSetup_statisticConfig_field3_tip']; ?>">
      <?php echo $langFile['statisticSetup_statisticConfig_field3']; ?></span></label>
      </td><td class="right">
      <input id="numberLastEditedPages" name="number[lastEditedPages]" class="short" value="<?php echo $statisticConfig['number']['lastEditedPages']; ?>" />
      </td></tr>
      
      <tr><td class="leftSpacer"></td><td></td></tr>
      
      <tr><td class="left">
      <label for="numberRefererLog"><span class="toolTip" title="<?php echo '::'.$langFile['statisticSetup_statisticConfig_field4_tip']; ?>">
      <?php echo $langFile['statisticSetup_statisticConfig_field4']; ?></span></label>
      </td><td class="right">
      <input id="numberRefererLog" name="number[refererLog]" class="short" value="<?php echo $statisticConfig['number']['refererLog']; ?>" />
      </td></tr>

      <tr><td class="left">
      <label for="numberTaskLog"><span class="toolTip" title="<?php echo '::'.$langFile['statisticSetup_statisticConfig_field5_tip']; ?>">
      <?php echo $langFile['statisticSetup_statisticConfig_field5']; ?></span></label>
      </td><td class="right">
      <input id="numberTaskLog" name="number[taskLog]" class="short" value="<?php echo $statisticConfig['number']['taskLog']; ?>" />
      </td></tr>
      
      <!--<tr><td class="spacer"></td><td></td></tr>-->

      
      <tr><td class="leftBottom"></td><td></td></tr>
      
    </table>
    
    <!--<input type="reset" value="" class="button cancel" title="<?php echo $langFile['form_cancel']; ?>" />-->
    <input type="submit" value="" name="statisticConfig" class="button submit center" title="<?php echo $langFile['form_submit']; ?>" />
  </div>
  <div class="bottom"></div>
</div>

</form>


<!-- CLEAR STATISTICS -->

<form action="index.php?site=statisticSetup" method="post" enctype="multipart/form-data" id="clearStatisticsForm" name="clearStatisticsForm" accept-charset="UTF-8">
  <div><input type="hidden" name="sendClearstatistics" value="true" /></div>
  
<?php
// shows the block below if it is the ones which is saved before
if($savedForm == 'clearStatistics')
    $hidden = '';
  else
    $hidden = ' hidden';  
?>
<div class="block<?php echo $hidden; ?>">
  <h1><a href="#" id="clearStatistics" name="clearStatistics"><?php echo $langFile['statisticSetup_clearStatistic_h1']; ?></a></h1>
  <div class="content">
    <table>
          
      <tr><td class="left checkboxes">
      <input type="checkbox" id="clearStatistics_websiteStatistic" name="clearStatistics_websiteStatistic" value="true" class="toolTip" title="<?php echo $langFile['statisticSetup_clearStatistics_websiteStatistic'].'::'.$langFile['statisticSetup_clearStatistics_websiteStatistic_tip']; ?>" />
      </td><td class="right checkboxes">
      <label for="clearStatistics_websiteStatistic"><span class="toolTip" title="<?php echo $langFile['statisticSetup_clearStatistics_websiteStatistic'].'::'.$langFile['statisticSetup_clearStatistics_websiteStatistic_tip']; ?>"><?php echo $langFile['statisticSetup_clearStatistics_websiteStatistic']; ?></span></label>
      </td></tr>
      
      <tr><td class="left checkboxes">
      <input type="checkbox" id="clearStatistics_pagesStatistics" name="clearStatistics_pagesStatistics" value="true" class="toolTip" title="<?php echo $langFile['statisticSetup_clearStatistics_pagesStatistic'].'::'.$langFile['statisticSetup_clearStatistics_pagesStatistic_tip']; ?>" />
      </td><td class="right checkboxes">
      <label for="clearStatistics_pagesStatistics"><span class="toolTip" title="<?php echo $langFile['statisticSetup_clearStatistics_pagesStatistic'].'::'.$langFile['statisticSetup_clearStatistics_pagesStatistic_tip']; ?>"><?php echo $langFile['statisticSetup_clearStatistics_pagesStatistic']; ?></span></label>
      </td></tr>
      
      <tr><td class="left checkboxes">
      <input type="checkbox" id="clearStatistics_pagesStaylengthStatistics" name="clearStatistics_pagesStaylengthStatistics" value="true" class="toolTip" title="<?php echo $langFile['statisticSetup_clearStatistics_clearStatistics_pagesStaylengthStatistics'].'::'.$langFile['statisticSetup_clearStatistics_clearStatistics_pagesStaylengthStatistics_tip']; ?>" />
      </td><td class="right checkboxes">
      <label for="clearStatistics_pagesStaylengthStatistics"><span class="toolTip" title="<?php echo $langFile['statisticSetup_clearStatistics_pagesStaylengthStatistics'].'::'.$langFile['statisticSetup_clearStatistics_pagesStaylengthStatistics_tip']; ?>"><?php echo $langFile['statisticSetup_clearStatistics_pagesStaylengthStatistics']; ?></span></label>
      </td></tr>
      
      <tr><td class="left checkboxes">
      <input type="checkbox" id="clearStatistics_refererLog" name="clearStatistics_refererLog" value="true" class="toolTip" title="<?php echo $langFile['statisticSetup_clearStatistics_refererLog'].'::'.$langFile['statisticSetup_clearStatistics_refererLog_tip']; ?>" />
      </td><td class="right checkboxes">
      <label for="clearStatistics_refererLog"><span class="toolTip" title="<?php echo $langFile['statisticSetup_clearStatistics_pagesStatistic'].'::'.$langFile['statisticSetup_clearStatistics_refererLog_tip']; ?>"><?php echo $langFile['statisticSetup_clearStatistics_refererLog']; ?></span></label>
      </td></tr>
      
      <tr><td class="left checkboxes">
      <input type="checkbox" id="clearStatistics_taskLog" name="clearStatistics_taskLog" value="true" class="toolTip" title="<?php echo $langFile['statisticSetup_clearStatistics_taskLog'].'::'.$langFile['statisticSetup_clearStatistics_taskLog_tip']; ?>" />
      </td><td class="right checkboxes">
      <label for="clearStatistics_taskLog"><span class="toolTip" title="<?php echo $langFile['statisticSetup_clearStatistics_taskLog'].'::'.$langFile['statisticSetup_clearStatistics_taskLog_tip']; ?>"><?php echo $langFile['statisticSetup_clearStatistics_taskLog']; ?></span></label>
      </td></tr>
      
      <tr><td class="leftSpacer"></td><td></td></tr>
      
    </table>
    
    <!--<input type="reset" value="" class="button cancel" title="<?php echo $langFile['form_cancel']; ?>" />-->
    <input type="submit" value="" class="button submit center" title="<?php echo $langFile['form_submit']; ?>" onclick="openWindowBox('library/sites/windowBox/clearStatistics.php','<?php echo $langFile['statisticSetup_clearStatistic_h1']; ?>');return false;" />
  </div>
  <div class="bottom"></div>
</div>

</form>