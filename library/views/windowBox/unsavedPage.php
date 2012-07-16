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
 * unsavedPage.php
 *
 * @version 0.1
 */

/**
 * Includes the login.include.php and backend.include.php and filter the basic data
 */
require_once(dirname(__FILE__)."/../../includes/secure.include.php");

echo ' '; // hack for safari, otherwise it throws an error that he could not find htmlentities like &ouml;

// var
$target = urldecode($_GET['target']);

// QUESTION
echo '<h2 class="red">'.$langFile['UNSAVEDPAGE_QUESTION_CONTINUE'].'</h2>';

?>
<div class="row buttons">
  <div class="span4 center">
    <a href="<?php echo $target; ?>" class="button cancel" onclick="closeWindowBox();return false;">&nbsp;</a>
  </div>
  <div class="span4 center">
    <a href="#" class="button ok" onclick="closeWindowBox('<?php echo $target; ?>');return false;">&nbsp;</a> <!-- $('editorForm').submit();return false; -->
  </div>
</div>
