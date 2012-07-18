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

* controllers/filemanager.controller.php
* @version 0.2
*/

// FORCE using the existing session, when request comes from FLASH
if(isset($_POST['session'])) session_id($_POST['session']);

/**
 * Includes the login.include.php and backend.include.php and filter the basic data
 */
require_once(dirname(__FILE__)."/../includes/secure.include.php");

define("FILEMANAGER_CODE", true);

if(!GeneralFunctions::hasPermission('fileManager') || empty($adminConfig['uploadPath']) || empty($adminConfig['basePath']))
  die('MooTools FileManager is deactivated');

if(!empty($adminConfig['uploadPath']) && !is_dir(DOCUMENTROOT.$adminConfig['uploadPath'].$adminConfig['pageThumbnail']['path']))
  if(!@mkdir(DOCUMENTROOT.$adminConfig['uploadPath'].$adminConfig['pageThumbnail']['path'],$adminConfig['permissions'],true))
    die('Couldn\'t create the thumbnail folder');


require_once(dirname(__FILE__).'/../thirdparty/MooTools-FileManager/Assets/Connector/FileManagerWithAliasSupport.php');

// set the right dateformat
switch ($adminConfig['dateFormat']) {
  case 'YMD':
    $dateFormat = 'Y-m-d H:i';
    break;
  case 'DMY':
    $dateFormat = 'd.m.Y H:i';
    break;
  case 'MDY':
    $dateFormat = 'm/d/Y H:i';
    break;

  default:
    $dateFormat = 'Y-m-d H:i';
    break;
}

$browser = new FileManagerWithAliasSupport(array(
  'Aliases' => array(URIEXTENSION => DOCUMENTROOT),
  'directory' =>  GeneralFunctions::Path2URI($adminConfig['uploadPath']),
  // 'directory' =>  $adminConfig['uploadPath'],
  'thumbnailPath' => GeneralFunctions::Path2URI($adminConfig['uploadPath']).$adminConfig['pageThumbnail']['path'],
  'assetBasePath' => GeneralFunctions::Path2URI($adminConfig['basePath']).'library/thirdparty/MooTools-FileManager/Assets',
  'documentRootPath' => DOCUMENTROOT,
  'chmod' => $adminConfig['permissions'],
  'dateFormat' => $dateFormat,
  'upload' => true,
  'destroy' => true,
  'create' => true,
  'move' => true,
  'download' => true,
  'safe' => false // If true, disallows 'exe', 'dll', 'php', 'php3', 'php4', 'php5', 'phps' and saves them as 'txt' instead.
));
$browser->fireEvent(!empty($_GET['event']) ? $_GET['event'] : null);