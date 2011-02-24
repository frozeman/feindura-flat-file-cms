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
    
* processes/filemanager.process.php version 0.1
*/

/**
 * Includes the login and filters the incoming data by xssFilter
 */
require_once(dirname(__FILE__)."/../includes/secure.include.php");

if(!$adminConfig['user']['fileManager'])
  die('MooTools FileManager deactivated');

require_once(dirname(__FILE__).'/../thirdparty/MooTools-FileManager/Assets/Connector/FileManager.php');

$browser = new FileManager(array(
  'directory' => DOCUMENTROOT.$adminConfig['uploadPath'],
  'thumbnailPath' => DOCUMENTROOT.$adminConfig['uploadPath'].$adminConfig['pageThumbnail']['path'],
  'assetBasePath' => dirname(__FILE__).'/../thirdparty/MooTools-FileManager/Assets',
  'chmod' => $adminConfig['permissions']
));
$browser->fireEvent(!empty($_GET['event']) ? $_GET['event'] : null);