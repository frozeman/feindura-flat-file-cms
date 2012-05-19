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
 * deleteCategory.php
 * 
 * @version 0.11
 */

/**
 * Includes the login.include.php and backend.include.php and filter the basic data
 */
require_once(dirname(__FILE__)."/../../includes/secure.include.php");

echo ' '; // hack for safari, otherwise it throws an error that he could not find htmlentities like &ouml;

// QUESTION
echo '<h1 class="red">'.$langFile['PAGESETUP_CATEGORY_TEXT_DELETECATEGORY_QUESTION_START'].' <span style="color:#000000;">'.GeneralFunctions::getLocalized($categoryConfig[$_GET['category']],'name').'</span> '.$langFile['PAGESETUP_CATEGORY_TEXT_DELETECATEGORY_QUESTION_END'].'</h1>';
echo '<h2 style="color:#A02F00; text-align:center;">'.$langFile['PAGESETUP_CATEGORY_TEXT_DELETECATEGORY_WARNING'].'</h2>';

?>
<div>
<a href="?site=pageSetup&amp;status=<?php echo $_GET['status']; ?>&amp;category=<?php echo $_GET['category']; ?>" class="ok left" onclick="closeWindowBox('index.php?site=pageSetup&amp;status=<?php echo $_GET['status']; ?>&amp;category=<?php echo $_GET['category']; ?>');return false;">&nbsp;</a>
<a href="?site=pageSetup" class="cancel" onclick="closeWindowBox();return false;">&nbsp;</a>
</div>
