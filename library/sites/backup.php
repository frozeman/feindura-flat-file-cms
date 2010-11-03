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
$unwriteableList = false;
$checkFolder = $adminConfig['basePath'].'backups/';
$unwriteableList .= isWritableWarning($checkFolder);

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
<div class="block">
  <h1><?= $langFile['BACKUP_TITLE_RESTORE']; ?></h1>
  <div class="content">  
  
  <form action="index.php?site=backup" method="post" enctype="multipart/form-data" accept-charset="UTF-8" id="restoreForm">
    <div>
    <input type="hidden" name="send" value="restore" />
    </div>
    
    <?= $langFile['BACKUP_TEXT_RESTORE']; ?><br />
    <br />
    <div style="text-align: center;">
    <img src="library/images/sign/backup_restore.png" /><input type="file" name="backupRestoreFile" style="position: relative;top: -25px;" />
    </div>
    
    <input type="submit" value="" name="restoreBackup" class="button submit center" title="<?php echo $langFile['form_submit']; ?>" />
  </form>
  </div>
  <div class="bottom"></div>
</div>