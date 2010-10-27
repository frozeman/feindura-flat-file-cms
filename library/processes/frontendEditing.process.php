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
    
* processes/frontendEditing.process.php version 0.1
*/

/**
 * Includes the login and filters the incoming data by xssFilter
 */
require_once(dirname(__FILE__)."/../includes/secure.include.php");

// SAVE the PAGE
// -----------------------------------------------------------------------------
if($_POST['save']) {
  
  // read the page
  $pageContent = $generalFunctions->readPage($_POST['page'],$_POST['category']);
  
  // eventually remove this string
  $container = '';
  $container = ($_POST['type'] == 'title')
    ? '<span class="feindura_editTitle feindura_pageId'.$_POST['page'].' feindura_categoryId'.$_POST['category'].'">'
    : $container;
  $container = ($_POST['type'] == 'content')
    ? '<div class="feindura_editPage feindura_pageId'.$_POST['page'].' feindura_categoryId'.$_POST['category'].'">'
    : $container;
  
  // remove the container element if it exists
  if(strpos($_POST['data'],$container) !== false) {
    $_POST['data'] = str_replace($container,'',$_POST['data']);
    
    preg_match_all ("/<\/?div.*?>", $_POST['data'], $matches);
    print_r(matches);
    die('huhu');
  }
  
  // replace the existing data with the new one  
  $pageContent['title'] = ($_POST['type'] == 'title') ? $_POST['data'] : $pageContent['title'];
  $pageContent['content'] = ($_POST['type'] == 'content') ? $_POST['data'] : $pageContent['content'];
  
  // save the page
  $pageContent = $generalFunctions->savePage($pageContent);
  
  // the data which will be returned, to inject into the element in the frontend  
  $return = ($_POST['type'] == 'title') ? $_POST['data'] : $pageContent['title'] ;
  $return = ($_POST['type'] == 'content') ? $_POST['data'] : $pageContent['content'] ;
  
  echo $return;
}

?>