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

* 
* library/functions/sort.functions.php
*
* @version 0.13
* 
*/

$feindura_categories = $categoryConfig;

// ** -- sortCurrentUserByTime ***************************************************************
// sort an Array with the current users by the TIMESTAMP
// -------------------------------------------------------------------------------------
function sortCurrentUserByTime($a, $b) {     // (Array) $a = current; $b = follwing value
  
  $a = explode('|',$a);
  $b = explode('|',$b);

  return ($a[2] > $b[2]) ? -1 : 1;
}
// ---- sortBySortOrder is used by the function sortPages ------------------------------

// ** -- sortBySortOrder ***************************************************************
// sort an Array with the pageContent Array by SORTORDER
// -------------------------------------------------------------------------------------
function sortBySortOrder($a, $b) {     // (Array) $a = current; $b = follwing value
  if ($a['sortorder'] == $b['sortorder']) {
    return 0;
  }
  return ($a['sortorder'] > $b['sortorder']) ? -1 : 1;
}
// ---- sortBySortOrder is used by the function sortPages ------------------------------

// ** -- sortByDate ********************************************************************
// sort an Array with the pageContent Array by DATE TIMESTAMP
// -------------------------------------------------------------------------------------
function sortByDate($a, $b) {     // (Array) $a = current; $b = follwing value
  
  if ($a['pagedate']['date'] == $b['pagedate']['date'])
    return 0;
  return ($a['pagedate']['date'] > $b['pagedate']['date']) ? -1 : 1;
}
// ---- sortByDate is used by the function sortPages -----------------------------------

// ** -- sortByLastSaveDate ********************************************************************
// sort an Array with the pageContent Array by LASTSAVEDATE TIMESTAMP
// -------------------------------------------------------------------------------------
function sortByLastSaveDate($a, $b) {     // (Array) $a = current; $b = follwing value
    
  if ($a['lastsavedate'] == $b['lastsavedate'])
    return 0;
  return ($a['lastsavedate'] > $b['lastsavedate']) ? -1 : 1;
}
// ---- sortByLastSaveDate is used by the function sortPages -----------------------------------

// ** -- sortbyCategory ****************************************************************
// sort an Array with the pageContent Array by CATEGORY
// -------------------------------------------------------------------------------------
function sortByCategory($a, $b) {     // (Array) $a = current; $b = following value
  global $feindura_categories;
  
  // puts the categories order in a string for comparision
  $categoryIds = '0 ';
  foreach($feindura_categories as $category) {
    $categoryIds .= $category['id'].' ';
  }
  
  if($a['category'] == $b['category']) {
     // would put the non-category on the end
     // ||
     //(empty($a['category']) && $a['category'] !== 0) ||
     //(empty($b['category']) && $b['category'] !== 0)) {
    return 0;
  }

  // sorts the array like the categories array order is
  return (strpos($categoryIds,$a['category']) < strpos($categoryIds,$b['category'])) ? -1 : 1;
}
// ---- sortbyCategory is used by the function sortPages -------------------------------

// ** -- sortByVisitCount ***************************************************************
// sort an Array with the pageContent Array by VISIT COUNT
// -------------------------------------------------------------------------------------
function sortByVisitCount($a, $b) {     // (Array) $a = current; $b = follwing value
  if ($a['log_visitCount'] == $b['log_visitCount'])
    return 0;
  return ($a['log_visitCount'] > $b['log_visitCount']) ? -1 : 1;
}

// ** -- sortByVisitTimeMax ***************************************************************
// sort an Array with the pageContent Array by MAX VISIT TIME
// -------------------------------------------------------------------------------------
function sortByVisitTimeMax($a, $b) {     // (Array) $a = current; $b = follwing value

 // get highest time
  $aMaxVisitTime = explode('|',$a['log_visitTime_max']);
  $bMaxVisitTime = explode('|',$b['log_visitTime_max']);

  if ($aMaxVisitTime[0] == $bMaxVisitTime[0])
    return 0;
  return ($aMaxVisitTime[0] > $bMaxVisitTime[0]) ? -1 : 1;
}


// * -- sortSearchwordString ----------------------------------------------------------------------------------
// sorts the searchword string, with the most counted at the beginning
// -----------------------------------------------------------------------------------------------------
function sortSearchwordString($a, $b) {
  $aExp = explode(',',$a);
  $bExp = explode(',',$b);
  
  if ($aExp[1] == $bExp[1])
      return 0;
  //echo 'A:'.$aExp[1].'<br />';
  //echo 'B:'.$bExp[1].'<br />';
  return ($aExp[1] > $bExp[1]) ? -1 : 1;
}

?>