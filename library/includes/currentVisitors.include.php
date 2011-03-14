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
 * includes/currentVisitors.include.php
 * 
 * @version 0.1
 */
 
/**
 * Includes the login.include.php and backend.include.php and filter the basic data
 */
require_once(dirname(__FILE__)."/../includes/secure.include.php");

// ---------------------------------
// -> CURRENT VISITORS
// -> clear cache from visotrs over the timelimit and load current visitors
statisticFunctions::hasVisitCache(true); // clear the visit cache, from agents wich are over the timeframe
$currentVisitors = statisticFunctions::getCurrentVisitors();
if(!empty($currentVisitors) && $currentVisitors[0]['ip'] != '::1') {
  
  // var
  $return = '';
 
  $return .= (!$currentVisitorFullDetail) 
    ? '<table>'
    : '<table class="coloredList">';
  
  /* uses GeoIPLite
   * 
   * @link http://geolite.maxmind.com/download/geoip/api/php/
   * @link http://geolite.maxmind.com/download/geoip/database/
   */
  
  include_once(dirname(__FILE__).'/../thirdparty/GeoIP/geoip.inc');
  
  // open geodates
  $geoIP = geoip_open(dirname(__FILE__).'/../thirdparty/GeoIP/GeoIP.dat',GEOIP_STANDARD);
  
  $count = 1;      
  foreach($currentVisitors as $currentVisitor) {
    if($currentVisitor['ip'] == '::1') continue;
    $geoIPCode = geoip_country_code_by_addr($geoIP, $currentVisitor['ip']);        
    $geoIPFlag = (!empty($geoIPCode))
      ? '<img src="library/thirdparty/GeoIP/flags/'.$geoIPCode.'.png" class="toolTip" title="'.geoip_country_name_by_addr($geoIP, $currentVisitor['ip']).'" />'
      : '';
    if(!empty($currentVisitor) && $currentVisitor['type'] != 'spider') {
      $return .= (!$currentVisitorFullDetail)
        ? '<tr class="'.$rowColor.'"><td style="text-align:center; vertical-align:middle;">'.$geoIPFlag.'</td><td><a href="http://www.ip2location.com/'.$currentVisitor['ip'].'" class="standardLink toolTip" title="'.$langFile['STATISTICS_TEXT_LASTACTIVITY'].'::'.statisticFunctions::formatDate($currentVisitor['time']).' - '.statisticFunctions::formatTime($currentVisitor['time']).'">'.$currentVisitor['ip'].'</a></td></tr>'
        : '<tr class="'.$rowColor.'"><td style="text-align:center; vertical-align:middle;">'.$geoIPFlag.'</td><td style="font-size:11px;text-align:left;"><b><a href="http://www.ip2location.com/'.$currentVisitor['ip'].'">'.$currentVisitor['ip'].'</a></b></td><td>'.$langFile['STATISTICS_TEXT_LASTACTIVITY'].' <b class="toolTip" title="'.statisticFunctions::formatDate($currentVisitor['time']).'">'.statisticFunctions::formatTime($currentVisitor['time']).'</b></td></tr>';
    }
    // change row color
    $rowColor = ($rowColor == 'light') ? 'dark' : 'light';        
    // count
    if($count == $statisticConfig['number']['longestVisitedPages']) break;
    else $count++;
  }
  
  // close geodates
  geoip_close($geoIP);
  
  $return .= '</table>';
  
  if(isset($_POST['request']) && $_POST['request'] == true) echo $return;
  return $return;
}
return false;
?>