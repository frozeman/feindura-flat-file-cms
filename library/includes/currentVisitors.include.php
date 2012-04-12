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

// available VARs from dashboard.php
// $currentVisitorDashboard

// ---------------------------------
// -> CURRENT VISITORS
// -> clear cache from visitors over the timelimit and load current visitors
StatisticFunctions::visitorCache(false); // clear the visit cache, from agents wich are over the timeframe
$currentVisitors = StatisticFunctions::getCurrentVisitors();

// CHECK if visitors will be displayed
$showVisitors = false;
foreach($currentVisitors as $currentVisitor) if(trim($currentVisitor['ip']) != '::1' && $currentVisitor['type'] != 'robot') $showVisitors = true;
if(!empty($currentVisitors) && $showVisitors) {
  
  // var
  $return = '';
  
  // ->> write before the listing
  if($currentVisitorDashboard)
    $return .= '<table class="coloredList"><tbody>';
  else {
    $return .= '<h1>'.$langFile['STATISTICS_TEXT_CURRENTVISITORS'].'</h1>';
    $return .= '<ul class="flags">';
  }

  /* uses GeoIPLite
   * 
   * @link http://geolite.maxmind.com/download/geoip/api/php/
   * @link http://geolite.maxmind.com/download/geoip/database/
   */
  
  include_once(dirname(__FILE__).'/../thirdparty/GeoIP/geoip.inc');
  
  // open geodates
  $geoIP = geoip_open(dirname(__FILE__).'/../thirdparty/GeoIP/GeoIP.dat',GEOIP_STANDARD);
  
  foreach($currentVisitors as $currentVisitor) {
    $ip = trim($currentVisitor['ip']);
    if(empty($currentVisitor) || $currentVisitor['type'] == 'robot' || $ip == '::1') continue;
    $geoIPCode = geoip_country_code_by_addr($geoIP, $ip);
    $geoIPFlag = (empty($geoIPCode))
      ? '<img src="'.getFlag($geoIPCode).'" width="18" height="12">'
      : '<img src="'.getFlag($geoIPCode).'" class="toolTip" width="18" height="12" title="'.geoip_country_name_by_addr($geoIP, $ip).'">';
    $return .= ($currentVisitorDashboard)
      ? '<tr class="'.$rowColor.'"><td style="text-align:center; vertical-align:middle;">'.$geoIPFlag.'</td><td style="font-size:11px;text-align:left;"><b><a href="http://www.ip2location.com/'.$ip.'" target="_blank">'.$ip.'</a></b></td><td>'.$langFile['STATISTICS_TEXT_LASTACTIVITY'].' <b class="toolTip" title="'.StatisticFunctions::formatDate($currentVisitor['time']).'">'.StatisticFunctions::formatTime($currentVisitor['time']).'</b></td></tr>'
      : '<li>'.$geoIPFlag.' <a href="http://www.ip2location.com/'.$ip.'" target="_blank" class="standardLink toolTip" title="'.$langFile['STATISTICS_TEXT_LASTACTIVITY'].'::'.StatisticFunctions::formatDate($currentVisitor['time']).' - '.StatisticFunctions::formatTime($currentVisitor['time']).'">'.$ip.'</a></li>';
    // change row color
    $rowColor = ($rowColor == 'light') ? 'dark' : 'light';        
  }  
  // close geodates
  geoip_close($geoIP);
  
  // ->> write after the listing
  if($currentVisitorDashboard)
    $return .= '</tbody></table>';
  else {
    $return .= '</ul>';
  }
  
  if(isset($_POST['request']) && $_POST['request'] == true) echo $return;
  return $return;
}
return false;
?>