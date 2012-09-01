<?php
/**
 * feindura - Flat File Content Management System
 * Copyright (C) Fabian Vogelsteller [frozeman.de]
 *
 * This program is free software;
 * you can redistribute it and/or modify it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY;
 * without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 * See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with this program;
 * if not,see <http://www.gnu.org/licenses/>.
 *
 * sites/backup.php
 *
 * @version 0.11
 */


/**
 * Includes the login.include.php and backend.include.php and filter the basic data
 */
require_once(dirname(__FILE__)."/../includes/secure.include.php");

// CHECKs if the ncessary FILEs are WRITEABLE, otherwise throw an error
// ----------------------------------------------------------------------------------------

// -> var
$backupFolder = 'backups/';

// -> check if the folder is writeable
$unwriteableList = isWritableWarning($backupFolder);

// gives the error OUTPUT if one of these files in unwriteable
if($unwriteableList && checkBasePathAndURL()) {
  echo '<div class="block warning">
    <h1>'.$langFile['ADMINSETUP_TITLE_ERROR'].'</h1>
    <div class="content">
      <p>'.$unwriteableList.'</p><!-- need <p> tags for margin-left:..-->
    </div>
  </div>';

  echo '<div class="blockSpacer"></div>';
}

?>
<!-- BACKUP -->
<div class="block">
  <h1><?php echo $langFile['BACKUP_TITLE_BACKUP']; ?></h1>
  <div class="content">
    <p><?php echo $langFile['BACKUP_TEXT_BACKUP']; ?></p><br>
    <div class="center">
    <a href="index.php?site=backup&amp;createBackup" class="createBackup"><?php echo $langFile['BACKUP_BUTTON_DOWNLOAD']; ?></a>
    </div>
  </div>
</div>


<form action="index.php?site=backup" method="post" enctype="multipart/form-data" accept-charset="UTF-8" id="restoreForm">
  <div>
    <input type="hidden" name="send" value="restore">
  </div>

  <!-- RESTORE -->
  <?php
  // shows the block below if it is the ones which is saved before
  $hidden = ($SAVEDFORM != 'restorBackup') ? ' hidden' : '';
  ?>
  <div class="block<?php echo $hidden ?>">
    <h1><a href="#"><?php echo $langFile['BACKUP_TITLE_RESTORE']; ?></a></h1>
    <div class="content form">
      <?php echo $langFile['BACKUP_TEXT_RESTORE']; ?>

      <div class="spacer2x"></div>

      <h2 class="center"><?php echo $langFile['BACKUP_TITLE_RESTORE_FROMUPLOAD']; ?></h2>

      <div class="row">
        <div class="span3 formLeft"><img src="library/images/icons/backup_restore.png" width="70" height="78"></div>
        <div class="span5"><br><input type="file" class="btn" name="restoreBackupUpload" onclick="removeChecked('.restoreBackupFiles');"></div>
      </div>

      <div class="spacer"></div>

      <?php

        $backups = GeneralFunctions::readFolder($backupFolder);
        if(!empty($backups['files'])) {

          echo '<h2 class="center">'.$langFile['BACKUP_TITLE_RESTORE_FROMFILES'].'</h2>';

          natsort($backups['files']);
          $backups['files'] = array_reverse($backups['files']);
          foreach($backups['files'] as $backupFile) {
            $backupTime = filemtime(DOCUMENTROOT.$backupFile);
            $backupTime = GeneralFunctions::dateDayBeforeAfter($backupTime).' '.formatTime($backupTime);

            echo '<div class="row"><div class="span3 formLeft">';
            echo '<input type="radio" name="restoreBackupFile" class="restoreBackupFiles" id="backupFile'.$backupFile.'" value="'.$backupFile.'">';
            echo '</div><div class="span5">';
            echo (strpos($backupFile,'restore') === false)
              ? '<label for="backupFile'.$backupFile.'">'.$langFile['BACKUP_TITLE_BACKUP'].'<br>'.$backupTime."</label>\n"
              : '<label for="backupFile'.$backupFile.'">'.$langFile['BACKUP_TEXT_RESTORE_BACKUPBEFORERESTORE'].'<br>'.$backupTime."</label>\n";
            echo '</div></div>';
          }
        }

      ?>

        <input type="submit" value="" name="restoreBackup" class="button submit center" title="<?php echo $langFile['FORM_BUTTON_SUBMIT']; ?>" />
    </div>
  </div>
</form>