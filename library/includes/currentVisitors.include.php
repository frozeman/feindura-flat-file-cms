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


if($_POST['mode'] == 'dashboard')
  $currentVisitorDashboard = true;

// ---------------------------------
// -> CURRENT VISITORS
// -> clear cache from visitors over the timelimit and load current visitors
StatisticFunctions::visitorCache(false); // clear the visit cache, from agents wich are over the timeframe
$currentVisitors = StatisticFunctions::getCurrentVisitors();

// CHECK if visitors will be displayed
$showVisitors = false;
$newCurrentVisitors = array();
foreach($currentVisitors as $currentVisitor) {
  if(trim($currentVisitor['ip']) != '::1' && $currentVisitor['type'] != 'robot' && !empty($currentVisitor)) {
    $showVisitors = true;
    $newCurrentVisitors[] = $currentVisitor;
  }
}
if(!empty($currentVisitors) && $showVisitors) {

  // var
  $return = '';

  // ->> write before the listing
  if($currentVisitorDashboard) {
    $return .= '<div class="insetBlock">';
      $return .= '<h2>'.$langFile['STATISTICS_TEXT_CURRENTVISITORS'].' ('.count($newCurrentVisitors).')</h2>';
      $return .= '<div class="insetBlockListPages">';
        $return .= '<table class="coloredList"><tbody>';
  } else {
    $return .= '<div class="box">';
      $return .= '<h1>'.$langFile['STATISTICS_TEXT_CURRENTVISITORS'].' ('.count($newCurrentVisitors).')</h1>';
      $return .= '<ul class="unstyled flags resizeOnHover">';
  }

  /* uses GeoIPLite
   *
   * @link http://geolite.maxmind.com/download/geoip/api/php/
   * @link http://geolite.maxmind.com/download/geoip/database/
   */

  include_once(dirname(__FILE__).'/../thirdparty/GeoIP/geoip.inc');

  // open geodates
  $geoIP = geoip_open(dirname(__FILE__).'/../thirdparty/GeoIP/GeoIP.dat',GEOIP_STANDARD);

  foreach($newCurrentVisitors as $currentVisitor) {
    $ip = trim($currentVisitor['ip']);

    $geoIPCode = geoip_country_code_by_addr($geoIP, $ip);
    $geoIPFlag = (empty($geoIPCode))
      ? '<img src="'.GeneralFunctions::getFlagSrc($geoIPCode).'" alt="flag" width="18" height="12">'
      : '<img src="'.GeneralFunctions::getFlagSrc($geoIPCode).'" alt="flag" class="toolTipLeft" width="18" height="12" title="'.geoip_country_name_by_addr($geoIP, $ip).'">';
    $return .= ($currentVisitorDashboard)
      ? '<tr><td style="text-align:center; vertical-align:middle;">'.$geoIPFlag.'</td><td style="font-size:11px;text-align:left;"><b><a href="http://www.ip2location.com/'.$ip.'" target="_blank">'.$ip.'</a></b></td><td>'.$langFile['STATISTICS_TEXT_LASTACTIVITY'].' <b class="toolTipRight" title="'.GeneralFunctions::formatDate($currentVisitor['time']).'">'.formatTime($currentVisitor['time']).'</b></td></tr>'
      : '<li>'.$geoIPFlag.' <a href="http://www.ip2location.com/'.$ip.'" target="_blank" class="link toolTipRight" title="'.$langFile['STATISTICS_TEXT_LASTACTIVITY'].'::'.GeneralFunctions::formatDate($currentVisitor['time']).' - '.formatTime($currentVisitor['time']).'">'.$ip.'</a></li>';
    // change row color
  }
  // close geodates
  geoip_close($geoIP);

  // ->> write after the listing
  if($currentVisitorDashboard) {
      $return .= '</tbody></table>';
      $return .= '</div>';
    $return .= '</div>';
  } else {
    $return .= '</ul>';
    $return .= '</div>';
  }

  if(isset($_POST['request']) && $_POST['request'] == true) echo $return;
    return $return;
}
return false;
?>