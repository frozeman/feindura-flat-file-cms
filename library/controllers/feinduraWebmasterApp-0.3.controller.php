<?php
/*
    feindura - Flat File Content Management System
    Copyright © Fabian Vogelsteller [frozeman.de]

    This program is free software;
    you can redistribute it and/or modify it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 3 of the License, or (at your option) any later version.

    This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY;
    without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
    See the GNU General Public License for more details.

    You should have received a copy of the GNU General Public License along with this program;
    if not,see <http://www.gnu.org/licenses/>.

* controllers/feinduraWebmasterTool.controller.php version 0.3
*/

/**
 * Includes the login.include.php and backend.include.php and filter the basic data
 */
require_once(dirname(__FILE__)."/../includes/backend.include.php");

// -> GET current USER
$currentUser = false;
foreach($userConfig as $user) {
  if($user['username'] == $_POST['username'])
    $currentUser = $user;
}

// ->> CHECK LOGIN
if(is_array($currentUser) && $currentUser['password'] == $_POST['password']) {
  // return only TRUE, if an account will be add in the AddFeinduraViewController class
  if($_POST['status'] == 'CHECK') die('TRUE');

  // ->> RETURN STATISTICS JSON OBJECT
  elseif($_POST['status'] == 'FETCH') {

    $returnJSON = array();
    $returnJSON['feinduraVersion'] =  VERSION;
    $returnJSON['feinduraBuild'] =  BUILD;
    $returnJSON['title'] = GeneralFunctions::getLocalized($websiteConfig,'title',$websiteConfig['multiLanguageWebsite']['mainLanguage']);
    $returnJSON['websiteUrl'] = $adminConfig['url'].GeneralFunctions::Path2URI(GeneralFunctions::getDirname($adminConfig['websitePath']));
    $returnJSON['statistics'] = array();
    $returnJSON['statistics']['userVisitCount'] = $websiteStatistic['userVisitCount'];
    $returnJSON['statistics']['robotVisitCount'] = $websiteStatistic['robotVisitCount'];
    $returnJSON['statistics']['firstVisit'] = $websiteStatistic['firstVisit'];
    $returnJSON['statistics']['lastVisit'] = $websiteStatistic['lastVisit'];

    // browser
    $returnJSON['statistics']['browser'] = unserialize($websiteStatistic['browser']);

    // searchwords
    $pagesStats = GeneralFunctions::loadPagesStatistics();
    $allSearchwords = array();
    foreach($pagesStats as $pageStats) {
      if(!empty($pageStats['searchWords'])) {
        $allSearchwords = StatisticFunctions::addDataToDataString($allSearchwords,$pageStats['searchWords']);
      }
    }
    $returnJSON['statistics']['searchWords'] = unserialize($allSearchwords);

    // pages
    $pagesArray = array();
    foreach($pagesStats as $pageStats) {
      $tmpPage['data']['title'] = GeneralFunctions::getLocalized(GeneralFunctions::$pagesMetaData[$pageStats['id']],'title',$websiteConfig['multiLanguageWebsite']['mainLanguage']);
      $tmpPage['data']['firstVisit'] = $pageStats['firstVisit'];
      $tmpPage['data']['lastVisit'] = $pageStats['lastVisit'];
      $tmpPage['data']['visitTimeMin'] = unserialize($pageStats['visitTimeMin']);
      $tmpPage['data']['visitTimeMax'] = unserialize($pageStats['visitTimeMax']);
      $tmpPage['number'] = $pageStats['visitorCount'];

      $pagesArray[] = $tmpPage;
    }
    $returnJSON['statistics']['pages'] = $pagesArray;

    // TODO
    // add refere
    // add activity

    $returnJSON = json_encode($returnJSON);
    die($returnJSON);
  }
} else
  die('FALSE');

?>