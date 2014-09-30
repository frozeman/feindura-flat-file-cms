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
* @version 0.1.6
*
*/
/**
 * This file contains the sort functions used by the backend and the frontend.
 *
 * @package [Backend]
 *
 * @version 0.2
 * <br>
 * <b>ChangeLog</b><br>
 *    - 0.2 removed: $feindura_categories = $categoryConfig;
 *    - 0.1.2 add this file comment
 *
 */

/**
 * <b>Name</b> sortBySortOrder()<br>
 *
 * Sort an Array with the pageContent Array by SORTORDER.
 *
 */
function sortBySortOrder($a, $b) {     // (Array) $a = current; $b = follwing value
  if ($a['sortOrder'] == $b['sortOrder']) {
    return 0;
  }
  return ($a['sortOrder'] > $b['sortOrder']) ? -1 : 1;
}

/**
 * <b>Name</b> sortAlphabetical()<br>
 *
 * Sort an Array with the pageContent Array by ALPHABETICAL by TITLE.
 *
 */
function sortAlphabetical($a, $b) {     // (Array) $a = current; $b = follwing value

  // make comparinssion multibyte save
  $a = iconv("UTF-8", "ASCII//TRANSLIT", GeneralFunctions::getLocalized($a,'title'));//GeneralFunctions::getLocalized($a,'title');//
  $a = strtolower($a);
  $a = preg_replace('#[^-a-z0-9_ ]+#', '', $a);
  $b = iconv("UTF-8", "ASCII//TRANSLIT", GeneralFunctions::getLocalized($b,'title'));//GeneralFunctions::getLocalized($b,'title');//
  $b = strtolower($b);
  $b = preg_replace('#[^-a-z0-9_ ]+#', '', $b);

  $result = strnatcmp($a, $b);
  if ($result == 0)
    return 0;
  else
    return ($result < 0) ? -1 : 1;
}


/**
 * <b>Name</b> sortByStartDate()<br>
 *
 * Sort an Array with the pageContent Array by DATE TIMESTAMP.
 *
 */
function sortByStartDate($a, $b) {     // (Array) $a = current; $b = follwing value

  if ($a['pageDate']['start'] == $b['pageDate']['start'])
    return 0;
  return ($a['pageDate']['start'] > $b['pageDate']['start']) ? -1 : 1;
}

/**
 * <b>Name</b> sortByEndDate()<br>
 *
 * Sort an Array with the pageContent Array by DATE TIMESTAMP.
 *
 */
function sortByEndDate($a, $b) {     // (Array) $a = current; $b = follwing value

  if ($a['pageDate']['end'] == $b['pageDate']['end'])
    return 0;
  return ($a['pageDate']['end'] > $b['pageDate']['end']) ? -1 : 1;
}

/**
 * <b>Name</b> sortByCategory()<br>
 *
 * Sort an Array with the pageContent Array by CATEGORY.
 *
 */
function sortByCategory($a, $b) {     // (Array) $a = current; $b = following value

  // var
  $categoryConfig = (isset($GLOBALS['feindura_categoryConfig']))
    ? $GLOBALS['feindura_categoryConfig']
    : $GLOBALS['categoryConfig'];

  // puts the categories order in a string for comparision
  if(is_array($categoryConfig)) {
    foreach($categoryConfig as $category) {
      $categoryIds .= $category['id'].'-';
    }
  }

  if($a['category'] == $b['category']) {
     // would put the non-category on the end
     // ||
     //(empty($a['category']) && $a['category'] !== 0) ||
     //(empty($b['category']) && $b['category'] !== 0)) {
    return 0;
  }

  // sorts the array like the categories array order is
  return (strpos($categoryIds,$a['category'].'-') < strpos($categoryIds,$b['category'].'-')) ? -1 : 1;
}


/**
 * <b>Name</b> sortByLastSaveDate()<br>
 *
 * Sort an Array with the pageContent Array by LASTSAVEDATE TIMESTAMP.
 *
 */
function sortByLastSaveDate($a, $b) {     // (Array) $a = current; $b = follwing value

  if ($a['lastSaveDate'] == $b['lastSaveDate'])
    return 0;
  return ($a['lastSaveDate'] > $b['lastSaveDate']) ? -1 : 1;
}

/**
 * <b>Name</b> sortByVisitTimeMax()<br>
 *
 * Sort an Array with the pageContent Array by MAX VISIT TIME.
 *
 */
function sortByVisitTimeMax($a, $b) {     // (Array) $a = current; $b = follwing value

 // get highest time
  $aMaxVisitTime = unserialize($a['visitTimeMax']);
  $bMaxVisitTime = unserialize($b['visitTimeMax']);

  if ($aMaxVisitTime[0] == $bMaxVisitTime[0])
    return 0;
  return ($aMaxVisitTime[0] > $bMaxVisitTime[0]) ? -1 : 1;
}

/**
 * <b>Name</b> sortByLastVisitDate()<br>
 *
 * Sort an Array with the pageStatistics Array by LASTVISIT TIMESTAMP.
 *
 */
function sortByLastVisitDate($a, $b) {     // (Array) $a = current; $b = follwing value

  if ($a['lastVisit'] == $b['lastVisit'])
    return 0;
  return ($a['lastVisit'] > $b['lastVisit']) ? -1 : 1;
}

/**
 * <b>Name</b> sortByVisitCount()<br>
 *
 * Sort an Array with the pageContent Array by VISIT COUNT.
 *
 */
function sortByVisitCount($a, $b) {     // (Array) $a = current; $b = follwing value
  if ($a['visitorCount'] == $b['visitorCount'])
    return 0;
  return ($a['visitorCount'] > $b['visitorCount']) ? -1 : 1;
}

/**
 * <b>Name</b> sortByPriority()<br>
 *
 * Sort an Array with the searchresults from {@link Search::searchPages()} by PRIORITY.
 *
 */
function sortByPriority($a, $b) {     // (Array) $a = current; $b = follwing value

  $aPriority = $a['priority'];
  $bPriority = $b['priority'];

  if($aPriority == $bPriority)
    return 0;
  return ($aPriority > $bPriority) ? -1 : 1;
}

/**
 * <b>Name</b> sortDataString()<br>
 *
 * Sorts the dataString array, with data with the highest number the beginning.
 *
 */
function sortDataString($a, $b) {
  if($a['number'] == $b['number'])
    return 0;
  return ($a['number'] > $b['number']) ? -1 : 1;
}

/**
 * <b>Name</b> sortCurrentVisitorsByTime()<br>
 *
 * Sort an Array with the current visitors by TIMESTAMP.
 *
 */
function sortCurrentVisitorsByTime($a, $b) {     // (Array) $a = current; $b = follwing value

  $a = explode('|#|',$a);
  $b = explode('|#|',$b);

  return ($a[2] > $b[2]) ? -1 : 1;
}

/**
 * <b>Name</b> sortFilesByModifiedDate()<br>
 *
 * Sort an Array of filepaths by modified timestamp. With the newest timestamp first.
 *
 */
function sortFilesByModifiedDate($a, $b) {     // (Array) $a = current; $b = follwing value

  return (filemtime(DOCUMENTROOT.$a) > filemtime(DOCUMENTROOT.$b)) ? -1 : 1;
}

?>