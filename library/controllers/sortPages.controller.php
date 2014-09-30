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
*/
// controllers/sortPages.controller.php version 0.32

/**
 * Includes the login.include.php and backend.include.php and filter the basic data
 */
require_once(dirname(__FILE__)."/../includes/secure.include.php");

/* split the value of the sortation */
$sortOrder = explode('|',$_POST['sort_order']);

// reverse the array when sortReverse == true
if(!$categoryConfig[$_POST['categoryNew']]['sortReverse'])
  $sortOrder = array_reverse($sortOrder);

// MOVE the file if it is sorted in an new category
if($_POST['categoryOld'] != $_POST['categoryNew']) {
  if(!movePage($_POST['sortedPageId'],$_POST['categoryOld'],$_POST['categoryNew'])) {
      echo '<span style="color: #960000;">'.sprintf($langFile['SORTABLEPAGELIST_error_move'],$adminConfig['basePath']).'</span>';
      die();
  }
}

// go trough the sort_order which has the id of the pages in the new order
foreach($sortOrder as $sort) {
  static $count = 1;

  if($sort != '') {

    // ->> SORT the pages new
    if($pageContent = GeneralFunctions::readPage($sort,$_POST['categoryNew'])) {

      // -> changes the properties of the page
      $pageContent['sortOrder'] = $count; // get a new sort order number
      $pageContent['category'] = $_POST['categoryNew']; // eventually get a new category id


      // ->> save the new sorting
      if(GeneralFunctions::savePage($pageContent,false,false)) {
        $status = $langFile['SORTABLEPAGELIST_save_finished'];
        $count++;

        // -> saves the task log
        if($_POST['sortedPageId'] == $pageContent['id'] && $categoryConfig[$_POST['categoryNew']]['sorting'] != 'byPageDate') {
          $logText = ($_POST['categoryOld'] != $_POST['categoryNew'])
            ? 3 : 4;
          // save log
          saveActivityLog($logText,'page='.$pageContent['id'].'|-|category='.$_POST['categoryNew'].'|-|moved'); // <- SAVE the task in a LOG FILE
        }
      // -X ERROR savePage
      } else {
        $status = sprintf($langFile['SORTABLEPAGELIST_error_save'],$adminConfig['basePath']);
      }

      /*
      echo substr(GeneralFunctions::getLocalized($pageContent,'title'),0,4).',';
      echo $pageContent['id'].',';
      echo $pageContent['sortOrder'].'|';
      */

    // -X ERROR readPage
    } else
      $status = sprintf($langFile['SORTABLEPAGELIST_error_read'],$adminConfig['basePath']);
  }
}

// SAVE the PAGESMETADATAARRAY
GeneralFunctions::savePagesMetaData();

// -> CHECKs if the category folder is empty,
// if its empty: the "<span></span>" is read by the content.js sort request and puts, a "no pages" - notice into the listPages
if(!GeneralFunctions::getPagesMetaDataOfCategory($_POST['categoryOld']))
  echo '<span></span>';

// clean up the $pageContent array
unset($pageContent);

echo $status;
?>