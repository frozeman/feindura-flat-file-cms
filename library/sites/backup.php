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

* sites/backup.php version 0.1
*/


/**
 * Includes the login and filters the incoming data by xssFilter
 */
require_once(dirname(__FILE__)."/../includes/secure.include.php");

// CHECKs if the ncessary FILEs are WRITEABLE, otherwise throw an error
// ----------------------------------------------------------------------------------------

// -> var
$backupFolder = $adminConfig['basePath'].'backups/';

// -> check if the folder is writeable
$unwriteableList = false;
$unwriteableList .= isWritableWarning($backupFolder);

// gives the error OUTPUT if one of these files in unwriteable
if($unwriteableList && checkBasePath()) {
  echo '<div class="block warning">
    <h1>'.$langFile['adminSetup_error_title'].'</h1>
    <div class="content">
      <p>'.$unwriteableList.'</p><!-- needs <p> tags for margin-left:..-->
    </div>
    <div class="bottom"></div>  
  </div>'; 
  
  echo '<div class="blockSpacer"></div>';
}

?>
<!-- BACKUP -->
<div class="block">
  <h1><?= $langFile['BACKUP_TITLE_BACKUP']; ?></h1>
  <div class="content" style="text-align: center;">
  
  <a href="index.php?site=backup&amp;downloadBackup" class="downloadBackup"><?= $langFile['BACKUP_BUTTON_DOWNLOAD']; ?></a>
  
  </div>
  <div class="bottom"></div>
</div>

<!-- RESTORE -->
<?php
// shows the block below if it is the ones which is saved before
$hidden = ($savedForm != 'restorBackup') ? ' hidden' : '';
?>
<div class="block<?= $hidden ?>">
  <h1><a href="#"><?= $langFile['BACKUP_TITLE_RESTORE']; ?></a></h1>
  <div class="content">  
  
  <form action="index.php?site=backup" method="post" enctype="multipart/form-data" accept-charset="UTF-8" id="restoreForm">
    <div>
    <input type="hidden" name="send" value="restore" />
    </div>
    <p><?= $langFile['BACKUP_TEXT_RESTORE']; ?></p><br />
    <br />
    <div style="text-align: center;">
    <?php
    
    $backups = $generalFunctions->readFolder($backupFolder);      
    if(!empty($backups['files'])) {
      
      echo '<h3>'.$langFile['BACKUP_TITLE_RESTORE_FROMFILES'].'</h3>';
      echo '<div class="verticalSeparator"></div><br />';
      
      natsort($backups['files']);
      $backups['files'] = array_reverse($backups['files']);
      foreach($backups['files'] as $backupFile) {
        $backupTime = filemtime(DOCUMENTROOT.$backupFile);
        $backupTime = $statisticFunctions->formatDate($statisticFunctions->dateDayBeforeAfter($backupTime)).' '.$statisticFunctions->formatTime($backupTime);
        echo '<input type="radio" name="restoreBackupFile" class="restoreBackupFiles" id="backupFile'.$backupFile.'" value="'.$backupFile.'"> <label for="backupFile'.$backupFile.'">'.$backupTime."</label><br /><br />\n";
      } 
    }
    
    ?>
    <br />
    <h3><?= $langFile['BACKUP_TITLE_RESTORE_FROMUPLOAD']; ?></h3>
    <div class="verticalSeparator"></div>
    <img src="library/images/sign/backup_restore.png" /><input type="file" name="restoreBackupUpload" style="position: relative;top: -25px;" onclick="removeChecked('.restoreBackupFiles');" />
    </div>    
    <br />
    <br />    
    <input type="submit" value="" name="restoreBackup" class="button submit center" title="<?php echo $langFile['form_submit']; ?>" />
  </form>
  </div>
  <div class="bottom"></div>
</div>