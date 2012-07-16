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
 * deleteEditFiles.php
 *
 * @version 0.2
 */

/**
 * Includes the login.include.php and backend.include.php and filter the basic data
 */
require_once(dirname(__FILE__)."/../../includes/secure.include.php");

echo ' '; // hack for safari, otherwise it throws an error that he could not find htmlentities like &ouml;

// QUESTION
echo '<h2 class="red">'.sprintf($langFile['EDITFILESSETTINGS_TEXT_DELETEFILE_QUESTION'],'<span style="color:#000000;">'.$_GET['file'].'</span>').'</h2>';

?>

<div class="row buttons">
  <div class="span4 center">
    <a href="?site=<?php echo $_GET['site']; ?>" class="button cancel" onclick="closeWindowBox();return false;"></a>
  </div>
  <div class="span4 center">
    <a href="<?php echo '?site='.$_GET['site'].'&amp;status='.$_GET['status'].'&amp;editFilesStatus='.$_GET['editFilesStatus'].'&amp;file='.$_GET['file'].'#'.$_GET['anchorName']; ?>" class="button ok" onclick="closeWindowBox('index.php?<?php echo 'site='.$_GET['site'].'&amp;status='.$_GET['status'].'&amp;editFilesStatus='.$_GET['editFilesStatus'].'&amp;file='.$_GET['file'].'#'.$_GET['anchorName']; ?>');return false;"></a>
  </div>
</div>
