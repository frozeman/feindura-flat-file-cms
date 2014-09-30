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

<!-- gives a warning if javascript is not activated -->
<noscript>
<div class="block alert warning">
  <h1><?php echo $langFile['WARNING_TITLE_JAVASCRIPT']; ?></h1>
  <div class="content">
    <p><?php echo $langFile['WARNING_TEXT_JAVASCRIPT']; ?></p>
  </div>
</div>
</noscript>

<div class="spacer"></div>

<!-- <div class="block open"> -->
  <h1><?php echo $langFile['DASHBOARD_TITLE_WELCOME']; ?></h1>
<!-- </div> -->

<div class="spacer"></div>

<?php

// SHOW the BROWSER HINT
if(preg_match("/MSIE [0-8]/", $_SERVER['HTTP_USER_AGENT']) &&
   !preg_match("/chromeframe/", $_SERVER['HTTP_USER_AGENT'])) {
?>
<div class="block alert warning">
  <h1><a href="#"><?php echo $langFile['DASHBOARD_TITLE_IEWARNING']; ?></a></h1>
  <div class="content">
    <p><?php echo $langFile['DASHBOARD_TEXT_IEWARNING']; ?></p>
  </div>
</div>
<?php }

// SHOW the USER HINTs
if(!empty($userConfig[USERID]['info'])) {
?>
<div class="block alert info">
  <h1><a href="#"><?php echo $langFile['DASHBOARD_TITLE_USERINFO']; ?></a></h1>
  <div class="content">
    <p><?php echo $userConfig[USERID]['info']; ?></p>
  </div>
</div>
<?php } ?>


<!-- WEBSITE STATISTIC -->

<div class="block dashboard">
  <h1><img src="library/images/icons/statisticIcon_small.png" class="blockH1Icon" alt="icon" style="top:4px; left:5px;"><?php echo $langFile['DASHBOARD_TITLE_STATISTICS']; ?></h1>
  <div class="content">
    <?php

    // vars
    $maxListEntries = 300;

    // ->> LOAD all PAGES
    $orgPagesStats = GeneralFunctions::loadPagesStatistics();
    $pagesStats = $orgPagesStats;

    // --------------------------------
    // VISITOR COUNTER
    echo '<div class="row">';
      echo '<div class="span4">';
        echo '<div id="visitorCountInsetBox" class="insetBlock">';
          include('library/includes/visitorCount.include.php');
        echo '</div>';
      echo '</div>';


    // ---------------------------------
    // -> CURRENT VISITORS
    $currentVisitorDashboard = true;
    $currentVisitors = include('library/includes/currentVisitors.include.php');
    if($currentVisitors) {
      echo '<div id="currentVisitorsDashboard" class="span4">';
        echo $currentVisitors;
      echo '</div>';
    }
    echo '</div>';

    echo '<div class="spacer"></div>';

    // inblockslider link is in the main count
    echo '<div class="inBlockSlider hidden" data-inBlockSlider="1">';

    $pagesStats = $orgPagesStats;

    echo '<div class="row">';
      echo '<div class="span4">';

        // ---------------------------------
        // -> MOST VISITED PAGE
        echo '<div class="insetBlock">';
        echo '<h2>'.$langFile['DASHBOARD_TITLE_STATISTICS_MOSTVISITED'].'</h2>';
          echo '<div class="insetBlockListPages">
                <table class="coloredList"><tbody>';
          // SORT the Pages by VISIT COUNT
          usort($pagesStats, 'sortByVisitCount');

          $count = 1;
          foreach($pagesStats as $pageStats) {
            if(!empty($pageStats['visitorCount'])) {
              // get page category and title
              $pageStats['title'] = GeneralFunctions::getLocalized($pagesMetaData[$pageStats['id']],'title');
              $pageStats['category'] = $pagesMetaData[$pageStats['id']]['category'];
              echo '<tr><td style="font-size:11px;text-align:center;"><strong>'.$pageStats['visitorCount'].'</strong></td><td><a href="?category='.$pageStats['category'].'&amp;page='.$pageStats['id'].'" class="blue">'.strip_tags($pageStats['title']).'</a></td></tr>';
              // count
              if($count == $maxListEntries) break;
              else $count++;
            }
          }
          echo '</tbody></table>
                </div>';
        echo '</div>';

      echo '</div>';

      $pagesStats = $orgPagesStats;

      echo '<div class="span4">';

        // ---------------------------------
        // -> LAST VISITED PAGES
        echo '<div class="insetBlock">';
        echo '<h2>'.$langFile['DASHBOARD_TITLE_STATISTICS_LASTVISITED'].'</h2>';
          echo '<div class="insetBlockListPages">
                <table class="coloredList"><tbody>';
          // SORT the Pages by VISIT SAVEDATE
          usort($pagesStats, 'sortByLastVisitDate');

          $count = 1;
          foreach($pagesStats as $pageStats) {
            if($pageStats['lastVisit'] != 0) {
              // get page category and title
              $pageStats['title'] = GeneralFunctions::getLocalized($pagesMetaData[$pageStats['id']],'title');
              $pageStats['category'] = $pagesMetaData[$pageStats['id']]['category'];
              echo '<tr><td style="font-size:11px;text-align:left;"><strong>'.GeneralFunctions::dateDayBeforeAfter($pageStats['lastVisit']).'</strong> '.formatTime($pageStats['lastVisit']).'</td><td><a href="?category='.$pageStats['category'].'&amp;page='.$pageStats['id'].'" class="blue">'.strip_tags($pageStats['title']).'</a></td></tr>';
              // count
              if($count == $maxListEntries) break;
              else $count++;
            }
          }
          echo '</tbody></table>
                </div>';
        echo '</div>';
      echo '</div>';
    echo '</div>';

    $pagesStats = $orgPagesStats;

    //  spacer
    echo '<div class="spacer"></div>';

    echo '<div class="row">';
      echo '<div class="span4">';

        // ---------------------------------
        // -> LONGEST VIEWED PAGE
        echo '<div class="insetBlock">';
        echo '<h2>'.$langFile['DASHBOARD_TITLE_STATISTICS_LONGESTVIEWED'].'</h2>';
          echo '<div class="insetBlockListPages">
                <table class="coloredList"><tbody>';
          // SORT the Pages by MAX VISIT TIME
          usort($pagesStats, 'sortByVisitTimeMax');

          $count = 1;
          foreach($pagesStats as $pageStats) {
            // get page category and title
            $pageStats['title'] = GeneralFunctions::getLocalized($pagesMetaData[$pageStats['id']],'title');
            $pageStats['category'] = $pagesMetaData[$pageStats['id']]['category'];

            // get highest time
            $highestTime = unserialize($pageStats['visitTimeMax']);

            if($pageVisitTime = showVisitTime($highestTime[0]))
              echo '<tr><td style="font-size:11px;text-align:center;">'.$pageVisitTime.'</td><td><a href="?category='.$pageStats['category'].'&amp;page='.$pageStats['id'].'" class="blue">'.strip_tags($pageStats['title']).'</a></td></tr>';
            // count
            if($count == $maxListEntries) break;
            else $count++;
          }
          echo '</tbody></table>
                </div>';
        echo '</div>';

      echo '</div>';

      $pagesStats = $orgPagesStats;

      echo '<div class="span4">';

        // ---------------------------------
        // -> LAST EDITED PAGES
        echo '<div class="insetBlock">';
        echo '<h2>'.$langFile['DASHBOARD_TITLE_STATISTICS_LASTEDITED'].'</h2>';
          echo '<div class="insetBlockListPages">
                <table class="coloredList"><tbody>';
          $pages = GeneralFunctions::loadPages(true);
          // SORT the Pages by VISIT SAVEDATE
          usort($pages, 'sortByLastSaveDate');

          $count = 1;
          foreach($pages as $page) {
            if($page['lastSaveDate'] != 0) {
              echo '<tr><td style="font-size:11px;text-align:left;"><strong>'.GeneralFunctions::dateDayBeforeAfter($page['lastSaveDate']).'</strong> '.formatTime($page['lastSaveDate']).'</td><td><a href="?category='.$page['category'].'&amp;page='.$page['id'].'" class="blue">'.strip_tags(GeneralFunctions::getLocalized($page,'title')).'</a></td></tr>';
              // count
              if($count == $maxListEntries) break;
              else $count++;
            }
          }
          echo '</tbody></table>
                </div>';
        echo '</div>';

        echo '</div>';
    echo '</div>';

    echo '</div>'; // <- inBlockSlider End

    //  spacer
    echo '<div class="spacer2x"></div>';

    // ---------------------------------
    // -> BROWSER CHART
    if($browserChart = createBrowserChart($websiteStatistic['browser'])) {
      echo '<div class="spacer"></div>';
      echo '<h2 class="center">'.$langFile['STATISTICS_TITLE_BROWSERCHART'].'</h2>';
      echo '<div class="spacer"></div>';
      echo $browserChart;
    }

    // ---------------------------------
    // ->> SEARCHWORD CLOUD
    // -> create a DATASTRING of ALL PAGES
    $allSearchwords = false;
    foreach($pagesStats as $pageStats) {
      // if page has searchwords
      if(!empty($pageStats['searchWords'])) {
        $allSearchwords = StatisticFunctions::addDataToDataString($allSearchwords,$pageStats['searchWords']);
      }
    }
    if($tagCloud = createTagCloud($allSearchwords)) {
      echo '<div class="spacer2x"></div>';
      echo '<h2 class="center">'.$langFile['STATISTICS_TEXT_SEARCHWORD_DESCRIPTION'].'</h2>';
      echo '<div class="spacer"></div>';
      echo '<div class="well tagCloud">'.$tagCloud.'</div>';
    }

    // ---------------------------------
    // -> SHOW REFERER LOG
    if(file_exists(dirname(__FILE__).'/../../statistics/referer.statistic.log') &&
       $logContent = file(dirname(__FILE__).'/../../statistics/referer.statistic.log')) {

      // echo '<div class="verticalSeparator"></div>';
      echo '<div class="spacer"></div>';

      echo '<h2 class="center">'.$langFile['DASHBOARD_TITLE_REFERER'].'</h2>';

      echo '<div class="row">';
        echo '<div class="refererBox span8">';
          echo '<ul class="coloredList">';
            foreach($logContent as $logRow) {
              $logRow = explode('|#|',$logRow);
              $logDate = GeneralFunctions::dateDayBeforeAfter($logRow[0]);
              $logTime = formatTime($logRow[0]);
              $logUrl = str_replace('&','&amp;',$logRow[1]);

              echo '<li><strong>'.$logDate.'</strong>  '.$logTime.' <a href="'.$logUrl.'" class="blue" target="_blank">'.str_replace('http://','',$logUrl).'</a></li>';
            }
          echo '</ul>';
        echo '</div>';
      echo '</div>';
    }
    ?>
  </div>
</div>