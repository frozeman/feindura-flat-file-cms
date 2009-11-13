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
// library/functions/general.functions.php version 0.12


//error_reporting(E_ALL);

// ** -- preventInjections -----------------------------------------------------------------------------
// VERHINDERT MYSQL INJECTIONs
// -----------------------------------------------------------------------------------------------------
// $sqlDataArray   [Der Array mit den Daten die in eine Datenbank geschrieben werden sollen (Array)],
// $arrayType      [Typ des Arrays entweder GET oder POST (String)]
function preventInjections($sqlDataArray, $arrayType) {

  foreach($sqlDataArray as $key => $wert) {
    
    // Die Auswirkungen von magic_quotes_gpc/magic_quotes_sybase zurücksetzen,
    // sofern die Option auf ON gesetzt ist
    if(get_magic_quotes_gpc()) {
      $sqlDataArray[$key] = stripslashes($sqlDataArray[$key]);         
    }
    
    // escaped alle " und '
    $sqlDataArray[$key] = addslashes($sqlDataArray[$key]);
    
    if($arrayType == 'GET') {
      $sqlDataArray[$key] = urldecode($sqlDataArray[$key]);
    }

    // entfernt ; und = um eine weitere ausführung von befehlen zu verhindern
    $sqlDataArray[$key] = str_replace(";","",$sqlDataArray[$key]);
    $sqlDataArray[$key] = str_replace("=","",$sqlDataArray[$key]);
    $sqlDataArray[$key] = str_replace("'",'',$sqlDataArray[$key]);
    $sqlDataArray[$key] = str_replace("´",'',$sqlDataArray[$key]);
    $sqlDataArray[$key] = str_replace('"','',$sqlDataArray[$key]);
    $sqlDataArray[$key] = str_replace('DROP','',$sqlDataArray[$key]);
    $sqlDataArray[$key] = str_replace('drop','',$sqlDataArray[$key]);
    $sqlDataArray[$key] = str_replace('TABLE','',$sqlDataArray[$key]);
    $sqlDataArray[$key] = str_replace('table','',$sqlDataArray[$key]);
        
    //$_POST[$key] = mysql_real_escape_string($_POST[$key]);
       
  }
  
  return $sqlDataArray;

}

?>