<?php
/*
    feindura - Flat File Content Management System
    Copyright (C) 2009 Fabian Vogelsteller [frozeman.de]

    This program is free software;
    you can redistribute it and/or modify it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 3 of the License, or (at your option) any later version.

    This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY;
    without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
    See the GNU General Public License for more details.

    You should have received a copy of the GNU General Public License along with this program;
    if not,see <http://www.gnu.org/licenses/>.

* FRONTEND feindura functions
* 
* library/functions/frontend.functions.php version 1.89
* 
* FUNCTIONS -----------------------------------
* 
* createTitleDate($date)
* 
* createTitle($category, $page, $title, $titleTag, $titleId = false, $titleClass = false, $titleLength = false, $titleAsLink = false, $titleWithCategory = false, $titleDate = false)
*
*/

$feindura_categories = @include(dirname(__FILE__).'/../../config/category.config.php');

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
// sort an Array with the pageContent Array by DATE
// -------------------------------------------------------------------------------------
function sortByDate($a, $b) {     // (Array) $a = current; $b = follwing value
  
  $a['sortdate'] = str_replace('-','',$a['sortdate']['date']);
  $b['sortdate'] = str_replace('-','',$b['sortdate']['date']);

  //echo $a['sortdate'].'<br>';
  //echo $b['sortdate'].'<br><br>';
  
  if ($a['sortdate'] == $b['sortdate']) {
    return 0;
  }
  return ($a['sortdate'] > $b['sortdate']) ? -1 : 1;
}
// ---- sortByDate is used by the function sortPages -----------------------------------

// ** -- sortByLastSaveDate ********************************************************************
// sort an Array with the pageContent Array by LASTSAVEDATE
// -------------------------------------------------------------------------------------
function sortByLastSaveDate($a, $b) {     // (Array) $a = current; $b = follwing value
  
  $a['lastsavedate'] = str_replace(array('-',':',' '),'',$a['lastsavedate']);
  $b['lastsavedate'] = str_replace(array('-',':',' '),'',$b['lastsavedate']); 
  
  //echo $a['lastsavedate'].'<br>';
  //echo $b['lastsavedate'].'<br><br>';
  
  if ($a['lastsavedate'] == $b['lastsavedate']) {
    return 0;
  }
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
  
  if($a['category'] == $b['category'] ||
     (empty($a['category']) && $a['category'] !== 0) || (empty($b['category']) && $b['category'] !== 0)) {
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
  if ($a['log_visitCount'] == $b['log_visitCount']) {
    return 0;
  }
  return ($a['log_visitCount'] > $b['log_visitCount']) ? -1 : 1;
}

// ** -- sortByVisitTimeMax ***************************************************************
// sort an Array with the pageContent Array by MAX VISIT TIME
// -------------------------------------------------------------------------------------
function sortByVisitTimeMax($a, $b) {     // (Array) $a = current; $b = follwing value
  $aMaxVisitTime = substr($a['log_visitTime_max'],0,strpos($a['log_visitTime_max'],'|'));
  $bMaxVisitTime = substr($b['log_visitTime_max'],0,strpos($b['log_visitTime_max'],'|'));

  if ($aMaxVisitTime == $bMaxVisitTime) {
    return 0;
  }
  return ($aMaxVisitTime > $bMaxVisitTime) ? -1 : 1;
}


// * -- sortSearchwordString ----------------------------------------------------------------------------------
// sorts the searchword string, with the most counted at the beginning
// -----------------------------------------------------------------------------------------------------
function sortSearchwordString($a, $b) {
  $aExp = explode(',',$a);
  $bExp = explode(',',$b);
  
  if ($aExp[1] == $bExp[1]) {
      return 0;
  }      
  //echo 'A:'.$aExp[1].'<br />';
  //echo 'B:'.$bExp[1].'<br />';
  return ($aExp[1] > $bExp[1]) ? -1 : 1;
}

?>