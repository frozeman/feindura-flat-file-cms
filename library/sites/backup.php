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

?>

<!-- BACKUP -->
<a href=""><?= $langFile['backup_downloadBackup']; ?></a>

<!-- RESTORE -->
<form action="index.php?site=backup" method="post" enctype="multipart/form-data" accept-charset="UTF-8" id="backupForm">
  <div>
  <input type="hidden" name="send" value="backup" />
  </div>

<div class="block">
  <h1><?= $langFile['backup_restore_h1']; ?></h1>
  <div class="content">
    
  </div>
  <div class="bottom"></div>
</div>
</form>