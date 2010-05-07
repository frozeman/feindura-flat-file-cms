<?php
/*  feindura - Flat File Content Management System
    Copyright (C) Fabian Vogelsteller [frozeman.de]

    This program is free software;
    you can redistribute it and/or modify it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 3 of the License, or (at your option) any later version.

    This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY;
    without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
    See the GNU General Public License for more details.

    You should have received a copy of the GNU General Public License along with this program;
    if not,see <http://www.gnu.org/licenses/>.

home.php version 0.86

*/

include_once(dirname(__FILE__).'/../backend.include.php');

//echo '->'.$_SERVER['HTTP_USER_AGENT'].'<br />';
//echo '->'.$statisticFunctions->getBrowser($_SERVER['HTTP_USER_AGENT']);  

?>

<div class="block">
  <h1><?php echo $langFile['home_welcome_h1']; ?></h1>
  <div class="content">
    <p><?php echo $langFile['home_welcome_text']; ?></p>
    
  </div>
  <div class="bottom"></div>
</div>

<!-- gives a warning if javascript is not activated -->
<noscript>
<div class="block warning">
  <h1><?php echo $langFile['warning_jsWarning_h1']; ?></h1>
  <div class="content">
    <p><?php echo $langFile['warning_jsWarning']; ?></p><!-- needs <p> tags for margin-left:..--> 
  </div>
  <div class="bottom"></div>  
</div>
</noscript>

<?php

// SHOW the BROWSER HINT
if(preg_match("/MSIE [0-6]/", $_SERVER['HTTP_USER_AGENT']) &&
   !preg_match("/chromeframe/", $_SERVER['HTTP_USER_AGENT'])) {
?>  
<div class="block info hidden">
  <h1><a href="#"><?php echo $langFile['warning_ieOld_h1']; ?></a></h1>
  <div class="content">
    <p><?php echo $langFile['warning_ieOld']; ?></p><!-- needs <p> tags for margin-left:..-->
  </div>
  <div class="bottom"></div>
</div>
<?php } 

// SHOW the USER HINTs
if(!empty($adminConfig['user']['info'])) {
?>
<div class="block info">
  <h1><a href="#"><?php echo $langFile['home_userInfo_h1']; ?></a></h1>
  <div class="content">
    <p><?php echo $adminConfig['user']['info']; ?></p><!-- needs <p> tags for margin-left:..-->
  </div>
  <div class="bottom"></div>
</div>
<?php } ?>


<!-- WEBSITE STATISTIC -->



<div class="block">
  <h1><a href="#"><img src="library/image/sign/statisticIcon_small.png" alt="icon" /><?php echo $langFile['home_statistic_h1']; ?></a></h1>
  <div class="content">
    <?php

    // --------------------------------
    // USER COUNTER
    echo '<div class="innerBlockLeft">';
    echo '<h2>'.$langFile['log_visitCount'].'</h2>';
    
      echo '<div style="width:100%; text-align:center;">';
      
      echo '<span class="visitCountNumber brown">'.$statisticFunctions->formatHighNumber($websiteStatistic['userVisitCount']).'</span><br />';
      echo '<span class="toolTip blue" title="'.$langFile['log_spiderCount_tip'].'"><b>'.$langFile['log_spiderCount'].'</b> '.$statisticFunctions->formatHighNumber($websiteStatistic['spiderVisitCount']).'</span>
          <hr class="small" />';
      echo '</div>';
      
      if(!empty($websiteStatistic['firstVisit'])) {
        echo '<div style="width:100%; text-align:right;">';
        // FIRST VISIT
        echo '<span class="toolTip" title="'.$statisticFunctions->formatTime($websiteStatistic['firstVisit']).'::">'.$langFile['log_firstVisit'].' <span class="brown">'.$statisticFunctions->formatDate($websiteStatistic['firstVisit']).'</span></span><br />';
        // LADST VISIT
        echo '<span class="toolTip" title="'.$statisticFunctions->formatTime($websiteStatistic['lastVisit']).'::">'.$langFile['log_lastVisit'].' <span class="blue"><b>'.$statisticFunctions->formatDate($websiteStatistic['lastVisit']).'</b></span></span>';
        echo '</div>';
      }
    echo '</div>';
    
    // ->> LOAD all PAGES
    $orgPages = $generalFunctions->loadPages(true,true);
    $pages = $orgPages;
    
    //print_r($orgPages);
    
    // ---------------------------------
    // -> MOST VISITED PAGE
    echo '<div class="innerBlockRight">';    
    echo '<h2>'.$langFile['home_h1_article'].' '.$statisticConfig['number']['mostVisitedPages'].' '.$langFile['home_mostVisitedPages_h1'].'</h2>';    
      echo '<div class="innerBlockListPages">
            <table class="coloredList">';      
      // SORT the Pages by VISIT COUNT
      usort($pages, 'sortByVisitCount');
      
      $count = 1;
      $rowColor = 'dark'; // starting row color
      foreach($pages as $page) {
        if(!empty($page['log_visitCount'])) {
          echo '<tr><td class="'.$rowColor.'" style="font-size:11px;text-align:center;"><b>'.$page['log_visitCount'].'</b></td><td class="'.$rowColor.'"><a href="?category='.$page['category'].'&amp;page='.$page['id'].'" class="blue">'.$page['title'].'</a></td></tr>';  
          // change row color
          if($rowColor == 'light') $rowColor = 'dark';
          else $rowColor = 'light';        
          // count
          if($count == $statisticConfig['number']['mostVisitedPages']) break;
          else $count++;
        }
      }
      echo '</table>
            </div>';
    echo '</div>';
    
    $pages = $orgPages;
    
    // ---------------------------------
    // -> LAST EDITED PAGES
    echo '<div class="innerBlockLeft">';    
    echo '<h2>'.$langFile['home_lastEditedPages_h1'].'</h2>';    
      echo '<div class="innerBlockListPages">
            <table class="coloredList">';      
      // SORT the Pages by VISIT SAVEDATE
      usort($pages, 'sortByLastSaveDate');
      
      $count = 1;
      $rowColor = 'dark'; // starting row color
      foreach($pages as $page) { 
        echo '<tr><td class="'.$rowColor.'" style="font-size:11px;text-align:left;"><b>'.$statisticFunctions->formatDate($generalFunctions->dateDayBeforeAfter($page['lastsavedate'])).'</b> '.$statisticFunctions->formatTime($page['lastsavedate']).'</td><td class="'.$rowColor.'"><a href="?category='.$page['category'].'&amp;page='.$page['id'].'" class="blue">'.$page['title'].'</a></td></tr>';        
        // change row color
        if($rowColor == 'light') $rowColor = 'dark';
        else $rowColor = 'light';        
        // count
        if($count == $statisticConfig['number']['lastEditedPages']) break;
        else $count++;
      }
      echo '</table>
            </div>';
    echo '</div>';
    
    $pages = $orgPages;
    
    // ---------------------------------
    // -> LONGEST VIEWED PAGE
    echo '<div class="innerBlockRight">';    
    echo '<h2>'.$langFile['home_h1_article'].' '.$statisticConfig['number']['longestVisitedPages'].' '.$langFile['home_longestViewedPages_h1'].'</h2>';    
      echo '<div class="innerBlockListPages">
            <table class="coloredList">';      
      // SORT the Pages by MAX VISIT TIME
      usort($pages, 'sortByVisitTimeMax');
      
      $count = 1;
      $rowColor = 'dark'; // starting row color
      foreach($pages as $page) {        
        if($pageVisitTime = $statisticFunctions->showVisitTime(substr($page['log_visitTime_max'],0,strpos($page['log_visitTime_max'],'|'))))
          echo '<tr><td class="'.$rowColor.'" style="font-size:11px;text-align:center;">'.$pageVisitTime.'</td><td class="'.$rowColor.'"><a href="?category='.$page['category'].'&amp;page='.$page['id'].'" class="blue">'.$page['title'].'</a></td></tr>';
        // change row color
        if($rowColor == 'light') $rowColor = 'dark';
        else $rowColor = 'light';        
        // count
        if($count == $statisticConfig['number']['longestVisitedPages']) break;
        else $count++;
      }
      echo '</table>
            </div>';                        
    echo '</div>';
    
    //echo '<br /><hr class="small" /><br />';
    echo '<br style="clear:both;" /><br />';
    
    $pages = $orgPages;
    
    // ---------------------------------
    // ->> SEARCHWORD CLOUD    
    
    // -> create SEARCHWORD DATASTRING of ALL PAGES
    $allSearchwords = false;
    foreach($pages as $page) {      
      // if page has searchwords
      if(!empty($page['log_searchwords'])) {        
        $allSearchwords = $statisticFunctions->addDataToString($page['log_searchwords'],$allSearchwords);
      }
    }
    // SHOW tag CLOUD
    echo '<h3>'.$langFile['log_tags_description'].'</h3>';
    echo '<div class="tagCloud">';
    $statisticFunctions->createTagCloud($allSearchwords);
    echo '</div>';
    
    echo '<br /><br /><hr class="small" /><br />';
    
    // ---------------------------------
    // -> BROWSER CHART
    echo '<h3>'.$langFile['home_browser_h1'].'</h3>';
    $statisticFunctions->createBrowserChart();
    
    echo '<br /><hr class="small" /><br />';
    
    // ---------------------------------
    // -> SHOW REFERER LOG
    echo '<h3>'.$langFile['home_refererLog_h1'].'</h3>';
    
    if(file_exists(DOCUMENTROOT.$adminConfig['basePath'].'statistic/referer.statistic.txt') &&
       $logContent = file(DOCUMENTROOT.$adminConfig['basePath'].'statistic/referer.statistic.txt')) {
      ;
       
      echo '<div id="refererLogContainer">
            <ul class="coloredList">';
      $rowColor = 'dark'; // starting row color
      foreach($logContent as $logRow) {
        $logDateTime = substr($logRow,0,19);
        $logDate = $statisticFunctions->formatDate($logDateTime);
        $logTime = $statisticFunctions->formatTime($logDateTime);
        $logUrl = substr($logRow,20);
 
        echo '<li class="'.$rowColor.'"><span style="font-size:11px;">'.$logDate.' '.$logTime.'</span> <a href="'.$logUrl.'" class="blue">'.str_replace('http://','',$logUrl).'</a></li>';
        
        // change row color
        if($rowColor == 'light') $rowColor = 'dark';
        else $rowColor = 'light';
      }
      echo '</ul>
            </div>';
    // no log
    } else
      echo $langFile['home_refererLog_nolog'];
    
    ?>
  </div>
  <div class="bottom"></div>
</div>
