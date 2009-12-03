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
* library/classes/frontend.class.php version 1.9
* 
* FUNCTIONS -----------------------------------
* 
*/

//error_reporting(E_ALL);

class frontendFunctions {
  
  // PUBLIC
  // *********
  var $adminConfig;                       // [Array] the Array with the adminConfig Data from the feindura CMS
  var $categoryConfig;                    // [Array] the Array with the categoryConfig Data from the feindura CMS
  
  var $generalFunctions;
  
  // -> START ** constructor *****************************************************************************
  // the class constructor
  // get the config arrays
  // -----------------------------------------------------------------------------------------------------
  function frontendFunctions() {   // (String) string with the COUNTRY CODE ("de", "en", ..)
    global $adminConfig;
    global $categories;
    
    // GET CONFIG FILES and SET CONFIG PROPERTIES
    $this->adminConfig = $adminConfig;
    $this->categoryConfig = $categories;
    
    // GET FUNCTIONS
    $this->generalFunctions = new generalFunctions();
  
    return true;
  }


  // ** -- none ----------------------------------------------------------------------------------
  // text
  // -----------------------------------------------------------------------------------------------------
  function none() {
     return true;
  }
  
}

?>