<?php
/*  feindura - Flat File Content Management System
    Copyright (C) Fabian Vogelsteller [frozeman.de]

    This program is free software;
    you can redistribute it and/or modify it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 3 of the License, or (at your option) any later version.

    This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY;
    without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
    See the GNU General Public License for more details.

    You should have received a copy of the GNU General Public License along with this program;
    if not,see <http://www.gnu.org/licenses/>.

* processes/listPages.process.php version 0.86
*/

// VAR
$opendCategory = false;

// ->> CHANGE PAGE STATUS
if(isset($_GET['status']) && $_GET['status'] == 'changePageStatus') {
    
    if($contentArray = $generalFunctions->readPage($_GET['page'],$_GET['category'])) {      
         
      // change the status
      $contentArray['public'] = ($_GET['public']) ? false : true;
      
      // save the new status
      if($generalFunctions->savePage($contentArray))
        $documentSaved = true;
      else
        $errorWindow .= $langFile['sortablePageList_changeStatusPage_error_save'];
        
    } else
      $errorWindow .= $langFile['file_error_read'];
  
  // shows after saving the category open
  $opendCategory = $_GET['category'];
}

// ->> CHANGE CATEGORY STATUS
if(isset($_GET['status']) && $_GET['status'] == 'changeCategoryStatus') {    
     
      // change the status
      $categoryConfig[$_GET['category']]['public'] = ($_GET['public']) ? false : true;
  
      // save the new status
      if(saveCategories($categoryConfig))
        $documentSaved = true;
      else
        $errorWindow .= $langFile['sortablePageList_changeStatusPage_error_save'];
   
   // shows after saving the category open
   $opendCategory = $_GET['category'];
}

// ->> SET THE STARTPAGE
if(isset($_GET['status']) && $_GET['status'] == 'setStartPage' && !empty($_GET['page'])) {
  
    // sets the new startPage
    $websiteConfig['startPage'] = $_GET['page'];
    
    if(savewebsiteConfig($websiteConfig)) {
      // give documentSaved status
      $documentSaved = true;
      
    } else $errorWindow .= $langFile['sortablePageList_setStartPage_error_save'];

  
  // shows after saving the category open
   $opendCategory = $_GET['category'];
}

?>