<?php
/*
    feindura - Flat File Content Management System
    Copyright (C) 2009 Fabian Vogelsteller [frozeman.de]

    This program is free software;
    you can redistribute it and/or modify it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 3 of the License, or (at your option) any later version.

    This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY;
    without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
    See the GNU General Public License for more details.

    You should have received a copy of the GNU General Public License along with this program;
    if not,see <http://www.gnu.org/licenses/>.
*/
// deleteCategory.php version 0.1

include_once(dirname(__FILE__).'/../backend.include.php');

// QUESTION
echo '<h1>'.$langFile['categorySetup_question_part1'].' &quot;<span style="color:#000000;">'.$categories['id_'.$_GET['category']]['name'].'</span>&quot; '.$langFile['categorySetup_question_part2'].'</h1>';
echo '<h2 style="color:#960000; text-align:center;">'.$langFile['categorySetup_deleteCategory_warning'].'</h2>';

?>
<div>
<a href="?site=categorySetup" class="toolTip cancel" title="<?php echo $langFile['categorySetup_question_cancel']; ?>::" onclick="closeWindowBox();return false;">&nbsp;</a>
<a href="?site=categorySetup&amp;status=<?php echo $_GET['status']; ?>&amp;category=<?php echo $_GET['category']; ?>" class="toolTip ok left" title="<?php echo $langFile['categorySetup_question_ok']; ?>::" onclick="closeWindowBox('index.php?site=categorySetup&amp;status=<?php echo $_GET['status']; ?>&amp;category=<?php echo $_GET['category']; ?>');return false;">&nbsp;</a>
</div>
