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
*/
// process/sortPages.php version 0.3

include(dirname(__FILE__)."/../backend.include.php");


/* split the value of the sortation */
$sortOrder = explode('|',$_POST['sort_order']);

// dreht die reihenfolge um, wenn sortascending == true
if(!$categories['id_'.$_POST['categoryNew']]['sortascending'])
  $sortOrder = array_reverse($sortOrder);

// move the file if it is sorted in an new category
if($_POST['categoryOld'] != $_POST['categoryNew']) {
  if(!movePage($_POST['sortedPageId'],$_POST['categoryOld'],$_POST['categoryNew'])) {
      echo '<span style="color: #960000;">'.$langFile['sortablePageList_error_move'].'</span>';
      die();
  }      
}

// go trough the sort_order which has the id of the pages in the new order
foreach($sortOrder as $sort) {
  static $count = 1;
  if($sort != '') {
   
    
    // ordnet die seiten neu
    if($pageContent = readPage($sort.'.php',$_POST['categoryNew'])) {
      
      // changes the properties of the page
      $pageContent['sortorder'] = $count; // get a new sort order number
      $pageContent['category'] = $_POST['categoryNew']; // eventually get a new category id
       
      
      // speichert die neue ordung
      if(savePage($_POST['categoryNew'],$pageContent['id'],$pageContent)) {
          $status = $langFile['sortablePageList_save_finished'];
          $count++;
      } else {
        $status = $langFile['sortablePageList_error_save'];
      }        
      
      /*
      echo substr($pageContent['title'],0,4).',';
      echo $pageContent['id'].',';
      echo $pageContent['sortorder'].'|';
      */
      
      
    } else
      $status = $langFile['sortablePageList_error_read'];
  }  
}

// checks if the category folder is empty,
// if yes: the "&nbsp;" is read by the sortPages.js and it puts, a "no pages" - notice
if(!loadPages($_POST['categoryOld'],false))
  echo '&nbsp;';  
  
echo $status;
?>