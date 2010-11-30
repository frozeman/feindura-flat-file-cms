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
  $pageContent = generalFunctions::readPage($_POST['page'],$_POST['category']);
  
  // url decodes the string
  $_POST['data'] = urldecode($_POST['data']);
  $_POST['data'] = preg_replace('/ +/',' ',$_POST['data']);
  $_POST['data'] = preg_replace('/\\n+/',"\n",$_POST['data']);
  $_POST['data'] = str_replace('<br>',"<br />\n",$_POST['data']);
  $_POST['data'] = htmlentities($_POST['data'],ENT_NOQUOTES,'UTF-8');
  $_POST['data'] = str_replace(array('&lt;','&gt;','&amp;'),array('<','>','&'),$_POST['data']);
  
  // replace the existing data with the new one  
  $pageContent['title'] = ($_POST['type'] == 'title') ? $_POST['data'] : $pageContent['title'];
  $pageContent['content'] = ($_POST['type'] == 'content') ? $_POST['data'] : $pageContent['content'];
  
  // save the page
  if(generalFunctions::savePage($pageContent));
    $statisticFunctions->saveTaskLog(1,'page='.$_POST['page']); // <- SAVE the task in a LOG FILE
  
  // the data which will be returned, to inject into the element in the frontend 
  $return = '';
  $return = ($_POST['type'] == 'title') ? $_POST['data'] : $return;
  $return = ($_POST['type'] == 'content') ? $_POST['data'] : $return;
  
  $return = str_replace("\'", "'", $return);
  $return = str_replace('\"', '"', $return);
  
  echo $return;
}

?>