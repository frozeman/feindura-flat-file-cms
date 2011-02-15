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
if(preg_match("/MSIE [0-7]/", $_SERVER['HTTP_USER_AGENT']) &&
   !preg_match("/chromeframe/", $_SERVER['HTTP_USER_AGENT'])) {
?>  
<div class="block warning hidden">
  <h1><a href="#;"><?php echo $langFile['warning_ieOld_h1']; ?></a></h1>
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
  <h1><a href="#;"><?php echo $langFile['home_userInfo_h1']; ?></a></h1>
  <div class="content">
    <p><?php echo $adminConfig['user']['info']; ?></p><!-- needs <p> tags for margin-left:..-->
  </div>
  <div class="bottom"></div>
</div>
<?php } ?>


<!-- WEBSITE STATISTIC -->

<div class="block">
  <h1><img src="library/images/sign/statisticIcon_small.png" alt="icon" /><?php echo $langFile['home_statistic_h1']; ?></h1>
  <div class="content">
    <?php
    
    // vars
    $rowColor = 'dark'; // starting row color
    
    // ->> LOAD all PAGES
    $orgPages = generalFunctions::loadPages(true,true);
    $pages = $orgPages;
    
    // -> clear cache from visotrs over the timelimit and load current visitors
    statisticFunctions::hasVisitCache(true); // clear the visit cache, from agents wich are over the timeframe
    $currentVisitors = statisticFunctions::getCurrentVisitors();
    
    
    // --------------------------------
    // USER COUNTER
    echo '<div class="innerBlockLeft">';
    echo '<h2>'.$langFile['STATISTICS_TEXT_VISITORCOUNT'].'</h2>';
      
      $latestVisitCacheTimeText = (!empty($currentVisitors[0]['time']))
        ? $langFile['STATISTICS_TEXT_LASTACTIVITY'].' '.statisticFunctions::formatTime($currentVisitors[0]['time'])
        : $langFile['STATISTICS_TEXT_CURRENTVISITORS'];
      
      echo '<div style="width:100%; text-align:center;margin-top: -10px;">';
      
      echo '<span class="visitCountNumber brown">'.statisticFunctions::formatHighNumber($websiteStatistic['userVisitCount']).'</span><br />';
      
      echo '<div style="line-height: 18px;">';
        echo '<span class="toolTip blue" title="'.$langFile['STATISTICS_TOOLTIP_SPIDERCOUNT'].'">'.$langFile['STATISTICS_TEXT_SPIDERCOUNT'].' '.statisticFunctions::formatHighNumber($websiteStatistic['spiderVisitCount']).'</span><br />';
        // CURRENT VISITORS
        $countVisitor = 0;
        $countSpider = 0;
        foreach($currentVisitors as $currentVisitor) {
          if($currentVisitor['type'] == 'visitor')
            $countVisitor++;
          else
            $countSpider++;
        }
        echo '<span class="toolTip blue" title="'.$latestVisitCacheTimeText.'::"><b>'.$langFile['STATISTICS_TEXT_CURRENTVISITORS'].'</b> '.$countVisitor.' ('.$langFile['STATISTICS_TEXT_SPIDERCOUNT'].' '.$countSpider.')</span>';
      echo '</div>';  
      echo '<hr class="small" />';
      echo '</div>';     
      
      
      if(!empty($websiteStatistic['firstVisit'])) {
        echo '<div style="width:100%; text-align:right;">';       
        // FIRST VISIT
        echo '<span class="toolTip" title="'.statisticFunctions::formatTime($websiteStatistic['firstVisit']).'::">'.$langFile['STATISTICS_TEXT_FIRSTVISIT'].' <span class="brown">'.statisticFunctions::formatDate($websiteStatistic['firstVisit']).'</span></span><br />';
        // LADST VISIT
        echo '<span class="toolTip" title="'.statisticFunctions::formatTime($websiteStatistic['lastVisit']).'::">'.$langFile['STATISTICS_TEXT_LASTVISIT'].' <span class="blue"><b>'.statisticFunctions::formatDate($websiteStatistic['lastVisit']).'</b></span></span>';
        
        echo '</div>';
      }
    echo '</div>';
    
    // ---------------------------------
    // -> CURRENT VISITORS
    echo '<div class="innerBlockRight">';    
    echo '<h2>'.$langFile['STATISTICS_TEXT_CURRENTVISITORS'].'</h2>';    
      echo '<div class="innerBlockListPages">
            <table class="coloredList">';
      
      /*
       * uses GeoIPLite
       * 
       * @link http://geolite.maxmind.com/download/geoip/api/php/
       * @link http://geolite.maxmind.com/download/geoip/database/
       */
      
      include(dirname(__FILE__).'/../thirdparty/GeoIP/geoip.inc');
      
      // open geodates
      $geoIP = geoip_open(dirname(__FILE__).'/../thirdparty/GeoIP/GeoIP.dat',GEOIP_STANDARD);
      
      $count = 1;      
      foreach($currentVisitors as $currentVisitor) {

        $geoIPCode = geoip_country_code_by_addr($geoIP, $currentVisitor['ip']);        
        $geoIPFlag = (!empty($geoIPCode))
          ? '<img src="library/thirdparty/GeoIP/flags/'.$geoIPCode.'.png" class="toolTip" title="'.geoip_country_name_by_addr($geoIP, $currentVisitor['ip']).'" />'
          : '';
                
        if(!empty($currentVisitor) && $currentVisitor['type'] != 'spider')
          echo '<tr class="'.$rowColor.'"><td style="text-align:center; vertical-align:middle;">'.$geoIPFlag.'</td><td style="font-size:11px;text-align:left;"><b><a href="http://www.ip2location.com/'.$currentVisitor['ip'].'">'.$currentVisitor['ip'].'</a></b></td><td>'.$langFile['STATISTICS_TEXT_LASTACTIVITY'].' <b class="toolTip" title="'.statisticFunctions::formatDate($currentVisitor['time']).'">'.statisticFunctions::formatTime($currentVisitor['time']).'</b></td></tr>';
        
        // change row color
        $rowColor = ($rowColor == 'light') ? 'dark' : 'light';        
        // count
        if($count == $statisticConfig['number']['longestVisitedPages']) break;
        else $count++;
      }
      
      // close geodates
      geoip_close($geoIP);
      
      echo '</table>
            </div>';                           
    echo '</div>';
    
    echo '<br style="clear:both;" /><br />';
    
    // -> inBlockSlider
    echo '<div style="text-align:center;"><a href="#;" class="inBlockSliderLink down">'.$langFile['STATISTICS_TITLE_PAGESTATISTICS'].'</a></div><br />';
    
    echo '<div class="verticalSeparator"></div>';
    
    echo '<div class="inBlockSlider hidden">';
    
    // ---------------------------------
    // -> MOST VISITED PAGE
    echo '<div class="innerBlockLeft">';    
    echo '<h2>'.$langFile['home_h1_article'].' '.$statisticConfig['number']['mostVisitedPages'].' '.$langFile['home_mostVisitedPages_h1'].'</h2>';    
      echo '<div class="innerBlockListPages">
            <table class="coloredList">';      
      // SORT the Pages by VISIT COUNT
      usort($pages, 'sortByVisitCount');
      
      $count = 1;
      foreach($pages as $page) {
        if(!empty($page['log_visitorCount'])) {
          echo '<tr class="'.$rowColor.'"><td style="font-size:11px;text-align:center;"><b>'.$page['log_visitorCount'].'</b></td><td><a href="?category='.$page['category'].'&amp;page='.$page['id'].'" class="blue">'.$page['title'].'</a></td></tr>';  
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
      foreach($pages as $page) {
        
        // get highest time
        $highestTime = unserialize($page['log_visitTime_max']);
        
        if($pageVisitTime = statisticFunctions::showVisitTime($highestTime[0],$langFile))
          echo '<tr class="'.$rowColor.'"><td style="font-size:11px;text-align:center;">'.$pageVisitTime.'</td><td><a href="?category='.$page['category'].'&amp;page='.$page['id'].'" class="blue">'.$page['title'].'</a></td></tr>';
        // change row color
        $rowColor = ($rowColor == 'light') ? 'dark' : 'light';         
        // count
        if($count == $statisticConfig['number']['longestVisitedPages']) break;
        else $count++;
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
        echo '<tr class="'.$rowColor.'"><td style="font-size:11px;text-align:left;"><b>'.statisticFunctions::formatDate(statisticFunctions::dateDayBeforeAfter($page['lastSaveDate'])).'</b> '.statisticFunctions::formatTime($page['lastSaveDate']).'</td><td><a href="?category='.$page['category'].'&amp;page='.$page['id'].'" class="blue">'.$page['title'].'</a></td></tr>';        
        // change row color
        $rowColor = ($rowColor == 'light') ? 'dark' : 'light';    
        // count
        if($count == $statisticConfig['number']['lastEditedPages']) break;
        else $count++;
      }
      echo '</table>
            </div>';
    echo '</div>';
    
    $pages = $orgPages;    
    
    echo '<br style="clear:both;" />';
    
    // ---------------------------------
    // ->> SEARCHWORD CLOUD    
    
    // -> create SEARCHWORD DATASTRING of ALL PAGES
    $allSearchwords = false;
    foreach($pages as $page) {
      // if page has searchwords
      if(!empty($page['log_searchWords'])) {
        $allSearchwords = statisticFunctions::addDataToDataString($allSearchwords,$page['log_searchWords']);
      }
    }
    echo '<br style="clear:both;" /><div class="verticalSeparator"></div>';
    echo '</div>'; // <- inBlockSlider End
    
    echo '<br />';
    
    // SHOW tag CLOUD
    if($tagCloud = statisticFunctions::createTagCloud($allSearchwords)) {
      echo '<h3 style="text-align:center;">'.$langFile['STATISTICS_TEXT_SEARCHWORD_DESCRIPTION'].'</h3>';
      echo '<div class="tagCloud">'.$tagCloud.'</div>';
      
      echo '<br /><hr class="small"><br />';
    }
     
    // ---------------------------------
    // -> BROWSER CHART
    echo '<h3 style="text-align:center;">'.$langFile['STATISTICS_TITLE_BROWSERCHART'].'</h3>';
    if($browserChart = statisticFunctions::createBrowserChart($websiteStatistic['browser']))
      echo $browserChart;
    else
      echo $GLOBALS['langFile']['home_novisitors'];

    // ---------------------------------
    // -> SHOW REFERER LOG
    if(file_exists(DOCUMENTROOT.$adminConfig['basePath'].'statistic/referer.statistic.log') &&
       $logContent = file(DOCUMENTROOT.$adminConfig['basePath'].'statistic/referer.statistic.log')) {
       
      echo '<br /><br /><hr class="small"><br />';
      echo '<h3 style="text-align:center;">'.$langFile['home_refererLog_h1'].'</h3>';
       
      echo '<div id="refererLogContainer">
            <ul class="coloredList">';
      foreach($logContent as $logRow) {
        $logRow = explode('|#|',$logRow);
        $logDate = statisticFunctions::formatDate($logRow[0]);
        $logTime = statisticFunctions::formatTime($logRow[0]);
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
