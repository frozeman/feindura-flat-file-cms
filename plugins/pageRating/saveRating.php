<?php
/* rating plugin */
/*
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
 */
/** 
 * This files saves the rating by an ajax request come from the include.php
 * 
 * @package [Plugins]
 * @subpackage pageRating
 * 
 */

if(isset($_POST['rating'])) {

  /**
   * Includes the feindura.include.php to be able to load and save pages
   */
  require_once(dirname(__FILE__)."/../../feindura.include.php");

  if($_SESSION['plugin_pageRating'][$_POST['page']]['rated'] === 'true')
    die('###RATED###');
  
  // read the page
  $pageContent = generalFunctions::readPage($_POST['page'],$_POST['category']);

  $currentSum = $pageContent['plugins']['pageRating']['value'] * $pageContent['plugins']['pageRating']['votes'];
  $pageContent['plugins']['pageRating']['value'] = ($currentSum + $_POST['rating']) / ++$pageContent['plugins']['pageRating']['votes'];
  $pageContent['plugins']['pageRating']['value'] = round($pageContent['plugins']['pageRating']['value'],3);

  // ->> save the page
  if(generalFunctions::savePage($pageContent)) {
    $_SESSION['plugin_pageRating'][$_POST['page']]['rated'] = 'true';
  // ->> on failure, return the unsaved data
  } else {
    $return = '####SAVING-ERROR####';
  }
  
  // return the new rating
  echo $pageContent['plugins']['pageRating']['value'];
}

?>