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
 * includes/visitorCount.include.php
 *
 * @version 0.1
 */

/**
 * Includes the login.include.php and backend.include.php and filter the basic data
 */
require_once(dirname(__FILE__)."/../includes/secure.include.php");


echo '<h2>'.$langFile['STATISTICS_TEXT_VISITORCOUNT'].'</h2>';
echo '<div class="center">';
  echo '<span class="visitCountNumber brown">'.formatHighNumber($websiteStatistic['userVisitCount']).'</span><br><br>';
  // CURRENT VISITORS
  $currentVisitors = StatisticFunctions::getCurrentVisitors();
  $countRobots = 0;
  foreach($currentVisitors as $currentVisitor) {
    if($currentVisitor['type'] != 'visitor')
      $countRobots++;
  }
  echo '<span class="toolTipBottom blue" title="'.$langFile['STATISTICS_TOOLTIP_ROBOTCOUNT'].'">'.$langFile['STATISTICS_TEXT_ROBOTCOUNT'].' '.formatHighNumber($websiteStatistic['robotVisitCount']).'</span><br><span class="gray">('.$langFile['STATISTICS_TEXT_CURRENT'].' '.$countRobots.')</span>';
  echo '<hr class="small">';
echo '</div>';

echo '<div class="row">';
  echo '<div class="span center" style="width: 160px;">';

    echo '<a href="#" tabindex="30" class="inBlockSliderLink btn" data-inBlockSlider="1">'.$langFile['STATISTICS_TITLE_PAGESTATISTICS'].' <span class="caret" onclick="return false;"></span></a>';
  echo '</div>';

  if(!empty($websiteStatistic['firstVisit'])) {
    echo '<div class="span right" style="width: 160px;">';
      // FIRST VISIT
      echo '<span class="toolTipLeft" title="'.formatTime($websiteStatistic['firstVisit']).'::">'.$langFile['STATISTICS_TEXT_FIRSTVISIT'].' <span class="brown">'.GeneralFunctions::formatDate($websiteStatistic['firstVisit']).'</span></span><br>';
      // LADST VISIT
      echo '<span class="toolTipLeft" title="'.formatTime($websiteStatistic['lastVisit']).'::">'.$langFile['STATISTICS_TEXT_LASTVISIT'].' <span class="blue"><strong>'.GeneralFunctions::formatDate($websiteStatistic['lastVisit']).'</strong></span></span>';
    echo '</div>';
  }
echo '</div>';