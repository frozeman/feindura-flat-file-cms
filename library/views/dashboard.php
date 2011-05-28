<?php
/**
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
 * 
 * dashboard.php
 * 
 * @version 0.9
 */

/**
 * Includes the login.include.php and backend.include.php and filter the basic data
 */
require_once(dirname(__FILE__)."/../includes/secure.include.php");

?>
<div class="block">
  <h1><?php echo $langFile['DASHBOARD_TITLE_WELCOME']; ?></h1>
  <div class="content">
    <p><?php echo $langFile['DASHBOARD_TEXT_WELCOME']; ?></p>
    
  </div>
  <div class="bottom"></div>
</div>

<!-- gives a warning if javascript is not activated -->
<noscript>
<div class="block warning">
  <h1><?php echo $langFile['warning_jsWarning_h1']; ?></h1>
  <div class="content">
    <p><?php echo $langFile['warning_jsWarning']; ?></p><!-- need <p> tags for margin-left:..--> 
  </div>
  <div class="bottom"></div>  
</div>
</noscript>

<?php

// SHOW the BROWSER HINT
if(preg_match("/MSIE [0-7]/", $_SERVER['HTTP_USER_AGENT']) &&
   !preg_match("/chromeframe/", $_SERVER['HTTP_USER_AGENT'])) {
?>  
<div class="block warning">
  <h1><a href="#"><?php echo $langFile['DASHBOARD_TITLE_IEWARNING']; ?></a></h1>
  <div class="content">
    <p><?php echo $langFile['DASHBOARD_TEXT_IEWARNING']; ?></p><!-- need <p> tags for margin-left:..-->
  </div>
  <div class="bottom"></div>
</div>
<?php } 

// SHOW the USER HINTs
if(!empty($adminConfig['user']['info'])) {
?>
<div class="block info">
  <h1><a href="#"><?php echo $langFile['DASHBOARD_TITLE_USERINFO']; ?></a></h1>
  <div class="content">
    <p><?php echo $adminConfig['user']['info']; ?></p><!-- need <p> tags for margin-left:..-->
  </div>
  <div class="bottom"></div>
</div>
<?php } ?>


<!-- WEBSITE STATISTIC -->

<div class="block">
  <h1><img src="library/images/icons/statisticIcon_small.png" alt="icon" width="30" height="27" /><?php echo $langFile['DASHBOARD_TITLE_STATISTICS']; ?></h1>
  <div class="content">
    <?php
    
    // vars
    $rowColor = 'dark'; // starting row color
    
    // ->> LOAD all PAGES
    $orgPages = GeneralFunctions::loadPages(true,true);
    $pages = $orgPages;
    $orgPagesStats = GeneralFunctions::loadPagesStatistics(true);
    $pagesStats = $orgPagesStats;

    // --------------------------------
    // USER COUNTER
    echo '<div class="innerBlockLeft">';
    echo '<h2>'.$langFile['STATISTICS_TEXT_VISITORCOUNT'].'</h2>';
      echo '<div style="width:100%; text-align:center;margin-top: -10px;">';
      echo '<span class="visitCountNumber brown">'.StatisticFunctions::formatHighNumber($websiteStatistic['userVisitCount']).'</span><br />';
      echo '<div style="line-height: 18px;">';
        echo '<span class="toolTip blue" title="'.$langFile['STATISTICS_TOOLTIP_ROBOTCOUNT'].'">'.$langFile['STATISTICS_TEXT_ROBOTCOUNT'].' '.StatisticFunctions::formatHighNumber($websiteStatistic['robotVisitCount']).'</span><br />';
        // CURRENT VISITORS
        $currentVisitors = StatisticFunctions::getCurrentVisitors();
        $countVisitor = 0;
        $countRobots = 0;
        foreach($currentVisitors as $currentVisitor) {
          if($currentVisitor['type'] == 'visitor')
            $countVisitor++;
          else
            $countRobots++;
        }
        echo '<span class="blue"><b>'.$langFile['STATISTICS_TEXT_CURRENTVISITORS'].'</b> '.$countVisitor.' ('.$langFile['STATISTICS_TEXT_ROBOTCOUNT'].' '.$countRobots.')</span>';
      echo '</div>';  
      echo '<hr class="small" />';
      echo '</div>';     
      
      
      if(!empty($websiteStatistic['firstVisit'])) {
        echo '<div style="width:100%; text-align:right;">';       
        // FIRST VISIT
        echo '<span class="toolTip" title="'.StatisticFunctions::formatTime($websiteStatistic['firstVisit']).'::">'.$langFile['STATISTICS_TEXT_FIRSTVISIT'].' <span class="brown">'.StatisticFunctions::formatDate($websiteStatistic['firstVisit']).'</span></span><br />';
        // LADST VISIT
        echo '<span class="toolTip" title="'.StatisticFunctions::formatTime($websiteStatistic['lastVisit']).'::">'.$langFile['STATISTICS_TEXT_LASTVISIT'].' <span class="blue"><b>'.StatisticFunctions::formatDate($websiteStatistic['lastVisit']).'</b></span></span>';
        
        echo '</div>';
      }
    echo '</div>';
    
    // ---------------------------------
    // -> CURRENT VISITORS
    $currentVisitorDashboard = true;
    $currentVisitors = include('library/includes/currentVisitors.include.php');
    if($currentVisitors) {
      echo '<div class="innerBlockRight">';    
      echo '<h2>'.$langFile['STATISTICS_TEXT_CURRENTVISITORS'].'</h2>';    
        echo '<div class="innerBlockListPages">';
        echo $currentVisitors;
        echo '</div>';
      echo '</div>';
    }
    
    echo '<br style="clear:both;" /><br />';
    
    // -> inBlockSlider
    echo '<div style="text-align:center;"><a href="#" tabindex="30" class="inBlockSliderLink down">'.$langFile['STATISTICS_TITLE_PAGESTATISTICS'].'</a></div><br />';
    
    echo '<div class="verticalSeparator"></div>';
    
    echo '<div class="inBlockSlider hidden">';
    
    // ---------------------------------
    // -> MOST VISITED PAGE
    echo '<div class="innerBlockLeft">';    
    echo '<h2>'.$langFile['DASHBOARD_TITLE_STATISTICS_START'].' '.$statisticConfig['number']['mostVisitedPages'].' '.$langFile['DASHBOARD_TITLE_STATISTICS_MOSTVISITED'].'</h2>';    
      echo '<div class="innerBlockListPages">
            <table class="coloredList">';      
      // SORT the Pages by VISIT COUNT
      usort($pagesStats, 'sortByVisitCount');
      
      $count = 1;
      foreach($pagesStats as $pageStats) {
        if(!empty($pageStats['visitorCount'])) {
          // get page category and title
          foreach($pages as $page) {
            if($pageStats['id'] == $page['id']) {
              $pageStats['title'] = $page['title'];
              $pageStats['category'] = $page['category'];
            }
          }
          echo '<tr class="'.$rowColor.'"><td style="font-size:11px;text-align:center;"><b>'.$pageStats['visitorCount'].'</b></td><td><a href="?category='.$pageStats['category'].'&amp;page='.$pageStats['id'].'" class="blue">'.strip_tags($pageStats['title']).'</a></td></tr>';  
          // change row color
          $rowColor = ($rowColor == 'light') ? 'dark' : 'light';        
          // count
          if($count == $statisticConfig['number']['mostVisitedPages']) break;
          else $count++;
        }
      }
      echo '</table>
            </div>';
    echo '</div>';
    
    $pagesStats = $orgPagesStats;
    
    // ---------------------------------
    // -> LAST VISITED PAGES
    echo '<div class="innerBlockRight">';    
    echo '<h2>'.$langFile['DASHBOARD_TITLE_STATISTICS_START'].' '.$statisticConfig['number']['lastVisitedPages'].' '.$langFile['DASHBOARD_TITLE_STATISTICS_LASTVISITED'].'</h2>';    
      echo '<div class="innerBlockListPages">
            <table class="coloredList">';      
      // SORT the Pages by VISIT SAVEDATE
      usort($pagesStats, 'sortByLastVisitDate');
      
      $count = 1;
      $rowColor = 'dark'; // starting row color
      foreach($pagesStats as $pageStats) {
        if($pageStats['lastVisit'] != 0) {
          // get page category and title
          foreach($pages as $page) {
            if($pageStats['id'] == $page['id']) {
              $pageStats['title'] = $page['title'];
              $pageStats['category'] = $page['category'];
            }
          }
          echo '<tr class="'.$rowColor.'"><td style="font-size:11px;text-align:left;"><b>'.StatisticFunctions::formatDate(StatisticFunctions::dateDayBeforeAfter($pageStats['lastVisit'])).'</b> '.StatisticFunctions::formatTime($pageStats['lastVisit']).'</td><td><a href="?category='.$pageStats['category'].'&amp;page='.$pageStats['id'].'" class="blue">'.strip_tags($pageStats['title']).'</a></td></tr>';        
          // change row color
          $rowColor = ($rowColor == 'light') ? 'dark' : 'light';    
          // count
          if($count == $statisticConfig['number']['lastVisitedPages']) break;
          else $count++;
        }
      }
      echo '</table>
            </div>';
    echo '</div>';
    
    $pagesStats = $orgPagesStats;
    
    // ---------------------------------
    // -> LONGEST VIEWED PAGE
    echo '<div class="innerBlockLeft">';    
    echo '<h2>'.$langFile['DASHBOARD_TITLE_STATISTICS_START'].' '.$statisticConfig['number']['longestVisitedPages'].' '.$langFile['DASHBOARD_TITLE_STATISTICS_LONGESTVIEWED'].'</h2>';    
      echo '<div class="innerBlockListPages">
            <table class="coloredList">';      
      // SORT the Pages by MAX VISIT TIME
      usort($pagesStats, 'sortByVisitTimeMax');
      
      $count = 1;
      foreach($pagesStats as $pageStats) {
        // get page category and title
        foreach($pages as $page) {
          if($pageStats['id'] == $page['id']) {
            $pageStats['title'] = $page['title'];
            $pageStats['category'] = $page['category'];
          }
        }
          
        // get highest time
        $highestTime = unserialize($pageStats['visitTimeMax']);
        
        if($pageVisitTime = StatisticFunctions::showVisitTime($highestTime[0],$langFile))
          echo '<tr class="'.$rowColor.'"><td style="font-size:11px;text-align:center;">'.$pageVisitTime.'</td><td><a href="?category='.$pageStats['category'].'&amp;page='.$pageStats['id'].'" class="blue">'.strip_tags($pageStats['title']).'</a></td></tr>';
        // change row color
        $rowColor = ($rowColor == 'light') ? 'dark' : 'light';         
        // count
        if($count == $statisticConfig['number']['longestVisitedPages']) break;
        else $count++;
      }
      echo '</table>
            </div>';                        
    echo '</div>';
    
    $pagesStats = $orgPagesStats;
    
    // ---------------------------------
    // -> LAST EDITED PAGES
    echo '<div class="innerBlockRight">';    
    echo '<h2>'.$langFile['DASHBOARD_TITLE_STATISTICS_START'].' '.$statisticConfig['number']['lastEditedPages'].' '.$langFile['DASHBOARD_TITLE_STATISTICS_LASTEDITED'].'</h2>';    
      echo '<div class="innerBlockListPages">
            <table class="coloredList">';      
      // SORT the Pages by VISIT SAVEDATE
      usort($pages, 'sortByLastSaveDate');
      
      $count = 1;
      $rowColor = 'dark'; // starting row color
      foreach($pages as $page) {
        if($page['lastSaveDate'] != 0) {
          echo '<tr class="'.$rowColor.'"><td style="font-size:11px;text-align:left;"><b>'.StatisticFunctions::formatDate(StatisticFunctions::dateDayBeforeAfter($page['lastSaveDate'])).'</b> '.StatisticFunctions::formatTime($page['lastSaveDate']).'</td><td><a href="?category='.$page['category'].'&amp;page='.$page['id'].'" class="blue">'.strip_tags($page['title']).'</a></td></tr>';        
          // change row color
          $rowColor = ($rowColor == 'light') ? 'dark' : 'light';    
          // count
          if($count == $statisticConfig['number']['lastEditedPages']) break;
          else $count++;
        }
      }
      echo '</table>
            </div>';
    echo '</div>';
    
    $pages = $orgPages;    
    
    echo '<br style="clear:both;" /><br /><div class="verticalSeparator"></div>';
    echo '</div>'; // <- inBlockSlider End
    
    echo '<br />';
    
    // ---------------------------------
    // ->> SEARCHWORD CLOUD    
    
    // -> create SEARCHWORD DATASTRING of ALL PAGES
    $allSearchwords = false;
    foreach($pagesStats as $pageStats) {
      // if page has searchwords
      if(!empty($pageStats['searchWords'])) {
        $allSearchwords = StatisticFunctions::addDataToDataString($allSearchwords,$pageStats['searchWords']);
      }
    }
    
    // SHOW tag CLOUD
    if($tagCloud = StatisticFunctions::createTagCloud($allSearchwords)) {
      echo '<h2 style="font-size:15px;text-align:center;border:none;margin-bottom:8px;">'.$langFile['STATISTICS_TEXT_SEARCHWORD_DESCRIPTION'].'</h2>';
      echo '<div class="tagCloud">'.$tagCloud.'</div>';
      echo '<br /><div class="verticalSeparator"></div><br />';
    }
     
    // ---------------------------------
    // -> BROWSER CHART
    
    if($browserChart = StatisticFunctions::createBrowserChart($websiteStatistic['browser'])) {
      echo '<h2 style="font-size:15px;text-align:center;border:none;margin-bottom:8px;">'.$langFile['STATISTICS_TITLE_BROWSERCHART'].'</h2>';
      echo $browserChart;
      echo '<br /><br /><div class="verticalSeparator"></div><br />';
    }

    // ---------------------------------
    // -> SHOW REFERER LOG
    if(file_exists(dirname(__FILE__).'/../../statistic/referer.statistic.log') &&
       $logContent = file(dirname(__FILE__).'/../../statistic/referer.statistic.log')) {
       
      echo '<h2 style="font-size:15px;text-align:center;border:none;margin-bottom:8px;">'.$langFile['DASHBOARD_TITLE_REFERER'].'</h2>';
       
      echo '<div id="refererLogContainer">
            <ul class="coloredList">';
      foreach($logContent as $logRow) {
        $logRow = explode('|#|',$logRow);
        $logDate = StatisticFunctions::formatDate($logRow[0]);
        $logTime = StatisticFunctions::formatTime($logRow[0]);
        $logUrl = $logRow[1];
 
        echo '<li class="'.$rowColor.'"><span style="font-size:11px;">'.$logDate.' '.$logTime.'</span> <a href="'.$logUrl.'" class="blue">'.str_replace('http://','',$logUrl).'</a></li>';
        
        // change row color
        $rowColor = ($rowColor == 'light') ? 'dark' : 'light';  
      }
      echo '</ul>
            </div>';
    // no log
    }    
    ?>
  </div>
  <div class="bottom"></div>
</div>
