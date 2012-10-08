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

* controllers/backup.controller.php version 0.11
*/

/**
 * Includes the login.include.php and backend.include.php and filter the basic data
 */
require_once(dirname(__FILE__)."/../includes/secure.include.php");

// ------------>> CREATE BACKUP
if(isset($_GET['createBackup'])) {

  // -> check backup folder
  $unwriteableList = false;
  $checkFolder = dirname(__FILE__).'/../../backups/';

  // try to create folder
  if(!is_dir($checkFolder))
    mkdir($checkFolder,$adminConfig['permissions']);
  $unwriteableList .= isWritableWarning($checkFolder);

  // ->> create archive
  if(!$unwriteableList) {

    // delete cache before
    GeneralFunctions::deleteFolder(dirname(__FILE__).'/../pages/cache/');

    // generates the file name
    $backupFile = generateBackupFileName();
    // create backup
    $catchError = createBackup($backupFile);

    // -> throw error
    if($catchError !== true) {
      $ERRORWINDOW .= "BACKUP ERROR: ".$catchError;

    // -> or redirect
    } else {

      if(@file_exists($backupFile)) {

        $NOTIFICATION .= '<div class="alert alert-success">'.$langFile['LOG_BACKUP_CREATED'].'</div>';

        saveActivityLog(29); // <- SAVE the task in a LOG FILE

      } else
        $ERRORWINDOW .= $langFile['BACKUP_ERROR_FILENOTFOUND'].'<br>'.$backupFile;
    }

  // -> throw folder error
  } else
    $ERRORWINDOW .= $unwriteableList;
}

// ------------>> DELETE BACKUP
if(isset($_GET['status']) && $_GET['status'] == 'deleteBackup') {
  $_GET['file'] = XssFilter::path($_GET['file']);
  if(!empty($_GET['file']) && unlink(dirname(__FILE__).'/../../backups/'.$_GET['file'])) {

    $NOTIFICATION .= '<div class="alert alert-info">'.$langFile['LOG_BACKUP_DELETED'].'<br>'.$_GET['file'].'</div>';

    saveActivityLog(31); // <- SAVE the task in a LOG FILE
  } else
    $ERRORWINDOW .= $langFile['BACKUP_ERROR_DELETE'];
}

// ------------>> RESTORE THE BACKUP
if(isset($_POST['send']) && $_POST['send'] == 'restore') {

  // var
  $error = false;
  $backupFile =  false;

  // ->> use uploaded backup file
  if(!empty($_FILES['restoreBackupUpload']['tmp_name'])) {
    // Check if the file has been correctly uploaded.
    //if($_FILES['restoreBackupUpload']['name'] == '')
    	//$error .= $langFile['PAGETHUMBNAIL_ERROR_nofile'];

    $backupFile = $_FILES['restoreBackupUpload']['tmp_name'];

    /*
    if($error === false) {
      if($_FILES['restoreBackupUpload']['tmp_name'] == '')
        $error .= $langFile['PAGETHUMBNAIL_ERROR_nouploadedfile'];

      // Check if the file filesize is not 0
      if($_FILES['restoreBackupUpload']['size'] == 0)
        $error .= $langFile['PAGETHUMBNAIL_ERROR_filesize'].' '.ini_get('upload_max_filesize').'B';
    }
    */

  // ->> otherwise use existing backup file
  } elseif(isset($_POST['restoreBackupFile'])) {
    $backupFile = DOCUMENTROOT.$_POST['restoreBackupFile'];
  // -> otherwise throw error
  } else {
    $ERRORWINDOW .= $langFile['BACKUP_ERROR_NORESTROEFILE'];
  }

  // ->> start the restore process
  if($ERRORWINDOW === false && $backupFile) {

    // create backup before
    $backupFileName = generateBackupFileName('restore');
    $catchError = createBackup($backupFileName);
    if($catchError !== true)
      $ERRORWINDOW .= "BACKUP BEFORE RESTORE ERROR: ".$catchError;

    // only proceed when the backup was succesfully created
    if($ERRORWINDOW === false) {

      // -> extracting the backup file
      require_once(dirname(__FILE__).'/../thirdparty/PHP/pclzip.lib.php');
      $archive = new PclZip($backupFile);
      // -> extract CONFIG
      if($archive->extract(PCLZIP_OPT_PATH, '', // extracts to the current folder (which should be the feindura folder)
                           PCLZIP_OPT_BY_PREG, '#([a-z]+\.config\.php$)|(htmlEditorStyles\.js$)#',
                           PCLZIP_OPT_SET_CHMOD, $adminConfig['permissions'],
                           PCLZIP_OPT_REPLACE_NEWER,PCLZIP_OPT_STOP_ON_ERROR) == 1) {
        $ERRORWINDOW .= "ERROR ON RESTORE: ".$archive->errorInfo(true);
      }
      // -> extract STATISTICS
      if($archive->extract(PCLZIP_OPT_PATH, '', // extracts to the current folder (which should be the feindura folder)
                           PCLZIP_OPT_BY_PREG, '#([a-z]+\.statistic\.[a-z]+)#',
                           PCLZIP_OPT_SET_CHMOD, $adminConfig['permissions'],
                           PCLZIP_OPT_REPLACE_NEWER,PCLZIP_OPT_STOP_ON_ERROR) == 0) {
        $ERRORWINDOW .= "ERROR ON RESTORE: ".$archive->errorInfo(true);
      }

      if($ERRORWINDOW === false) {
        // delete the old pages dir
        GeneralFunctions::deleteFolder(dirname(__FILE__).'/../../pages/');
        // -> extract PAGES
        if($archive->extract(PCLZIP_OPT_PATH, '', // extracts to the current folder (which should be the feindura folder)
                             PCLZIP_OPT_BY_PREG, '#\d+\.php$#',
                             PCLZIP_OPT_SET_CHMOD, $adminConfig['permissions'],
                             PCLZIP_OPT_REPLACE_NEWER,PCLZIP_OPT_STOP_ON_ERROR) == 0) {
          $ERRORWINDOW .= "ERROR ON RESTORE: ".$archive->errorInfo(true);
        }
      }
    }

    // delete the tmp file
    if(!empty($_FILES['restoreBackupUpload']['tmp_name']))
      @unlink($_FILES['restoreBackupUpload']['tmp_name']);

    // -> when restore was succesfull
    if($ERRORWINDOW === false) {

      $NOTIFICATION .= '<div class="alert alert-success">'.$langFile['LOG_BACKUP_RESTORED'].'<br>'.basename($backupFile).'</div>';

      saveActivityLog(30); // <- SAVE the task in a LOG FILE

      // set documentSaved status
      $DOCUMENTSAVED = true;
    }
  }

  $SAVEDFORM = 'restorBackup';
}

?>