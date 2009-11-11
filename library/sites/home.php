<?php
/*  feindura - Flat File Content Management System
    Copyright (C) 2009 Fabian Vogelsteller [frozeman.de]

    This program is free software;
    you can redistribute it and/or modify it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 3 of the License, or (at your option) any later version.

    This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY;
    without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
    See the GNU General Public License for more details.

    You should have received a copy of the GNU General Public License along with this program;
    if not,see <http://www.gnu.org/licenses/>.

home.php version 0.7

*/

include_once(dirname(__FILE__).'/../backend.include.php');

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
// show the user hints
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
    
    echo '<div class="visitCountBox">';
    echo '<h2>'.$langFile['log_visitCount'].'</h2>';
    
    echo '<div style="width:100%; text-align:center;">';
    // USER COUNTER
    echo '<span class="visitCountNumber brown">'.formatHighNumber($websiteStatistic['userVisitCount']).'</span><br />';
    echo '<span class="toolTip blue" title="'.$langFile['log_spiderCount_tip'].'"><b>'.$langFile['log_spiderCount'].'</b> '.formatHighNumber($websiteStatistic['spiderVisitCount']).'</span>
          <hr class="small" />';
    echo '</div>';
    
    echo '<div style="width:100%; text-align:right;">';
    // FIRST VISIT
    echo '<span class="toolTip" title="'.formatTime($websiteStatistic['firstVisit']).'::">'.$langFile['log_firstVisit'].' <span class="brown">'.formatDate($websiteStatistic['firstVisit']).'</span></span><br />';
    // LADST VISIT
    echo '<span class="toolTip" title="'.formatTime($websiteStatistic['lastVisit']).'::">'.$langFile['log_lastVisit'].' <span class="blue"><b>'.formatDate($websiteStatistic['lastVisit']).'</b></span></span>';
    echo '</div></div>';
    
    echo '<br /><hr class="small" /><br />';
    
    // -> BROWSER CHART
    echo '<h3>'.$langFile['home_browser_h1'].'</h3>';
    createBrowserChart();
    
    echo '<br /><hr class="small" /><br />';
    
    // -> SHOW REFERER LOG
    echo '<h3>'.$langFile['home_refererLog_h1'].'</h3>';
    
    if(file_exists($documentRoot.$adminConfig['basePath'].'statistic/log_referers.txt')) {
       $logContent = file($documentRoot.$adminConfig['basePath'].'statistic/log_referers.txt');
       
       echo '<div id="refererLogContainer">
            <ul>';
       $rowColor = 'dark'; // starting row color
       foreach($logContent as $logRow) {
        $logDateTime = substr($logRow,0,19);
        $logDate = formatDate($logDateTime);
        $logTime = formatTime($logDateTime);
 
        echo '<li class="'.$rowColor.'"><span style="font-size:11px;">'.$logDate.' '.$logTime.'</span> <a href="'.$logRow.'" class="blue">'.str_replace('http://','',substr($logRow,20)).'</a></li>';
        
        // change row color
        if($rowColor == 'light')
          $rowColor = 'dark';
        else
          $rowColor = 'light';
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
