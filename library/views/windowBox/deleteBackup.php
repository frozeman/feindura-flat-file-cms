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
 * deleteBackup.php
 * 
 * @version 0.1.1
 */

/**
 * Includes the login.include.php and backend.include.php and filter the basic data
 */
require_once(dirname(__FILE__)."/../../includes/secure.include.php");

echo ' '; // hack for safari, otherwise it throws an error that he could not find htmlentities like &ouml;
$_GET['file'] = XssFilter::path($_GET['file']);

$backupTime = filemtime(DOCUMENTROOT.$adminConfig['realBasePath'].'/backups/'.$_GET['file']);
$backupName .= (strpos($_GET['file'],'restore') === false)
          ? $langFile['BACKUP_TITLE_BACKUP'].'<br>'.GeneralFunctions::formatDate(GeneralFunctions::dateDayBeforeAfter($backupTime)).' '.formatTime($backupTime)
          : $langFile['BACKUP_TEXT_RESTORE_BACKUPBEFORERESTORE'].'<br>'.GeneralFunctions::formatDate(GeneralFunctions::dateDayBeforeAfter($backupTime)).' '.formatTime($backupTime);
          

// QUESTION
echo '<h2 class="red">'.sprintf($langFile['BACKUP_TEXT_DELETE_QUESTION'],'<span style="color:#000000;">'.$backupName.'</span> ').'</h2>';

?>
<div>
<a href="?site=backup&amp;status=<?php echo $_GET['status']; ?>&amp;file=<?php echo $_GET['file']; ?>" class="ok left" onclick="closeWindowBox('index.php?site=backup&amp;status=<?php echo $_GET['status']; ?>&amp;file=<?php echo $_GET['file']; ?>');return false;">&nbsp;</a>
<a href="?site=backup" class="cancel" onclick="closeWindowBox();return false;">&nbsp;</a>
</div>
