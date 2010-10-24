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
*/
// clearStatistics.php version 0.1

require_once(dirname(__FILE__).'/../../includes/login.include.php');

echo ' '; // hack for safari, otherwise it throws an error that he could not find htmlentities like &ouml;

// QUESTION
echo '<h1 class="red">'.$langFile['statisticSetup_clearStatistics_question_h1'].'</h1>';

?>
<div>
<a href="?site=statisticSetup#clearStatistics" class="ok left" onclick="$('clearStatisticsForm').submit();return false;">&nbsp;</a>
<a href="?site=statisticSetup#clearStatistics" class="cancel" onclick="closeWindowBox();return false;">&nbsp;</a>
</div>
