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
*
* backend.include.php version 0.16
*/

require_once(dirname(__FILE__)."/general.include.php");

@include_once(dirname(__FILE__)."/../config/adminConfig.php");
@include_once(dirname(__FILE__)."/../config/websiteConfig.php");
@include_once(dirname(__FILE__)."/../config/categoryConfig.php");

@include_once(dirname(__FILE__)."/../statistic/websiteStatistic.php");

//require_once(dirname(__FILE__)."/functions/general.functions.php");
//require_once(dirname(__FILE__)."/functions/statistic.functions.php");
require_once(dirname(__FILE__)."/functions/backend.functions.php");

require_once(dirname(__FILE__)."/classes/general.class.php");
require_once(dirname(__FILE__)."/classes/statistic.class.php");

// GET FUNCTIONS
$generalFunctions = new general();
$statisticFunctions = new statistic();

// *---* choose LANGUAGE START -----------------------------------------------------
// language shortname will be transfered trough a session (needs COOKIES!)
// and includes the langFile

//unset($_SESSION['language']);
//$_SESSION['language'] = 'de';

if(empty($_SESSION['language'])) {
  // gets the BROWSER STANDARD language
  $_SESSION['language'] = $generalFunctions->getLanguage($adminConfig['basePath'].'library/lang/',false); // returns a COUNTRY SHORTNAME
}

// includes the langFile which is set by the session var
$langFile = include(dirname(__FILE__).'/lang/'.$_SESSION['language'].'.backend.php');


// *---* choose LANGUAGE END -----------------------------------------------------

?>