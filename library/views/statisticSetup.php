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
 * sites/statisticSetup.php
 *
 * @version 0.2
 */

/**
 * Includes the login.include.php and backend.include.php and filter the basic data
 */
require_once(dirname(__FILE__)."/../includes/secure.include.php");

?>
<!-- OVERVIEW STATISTIC SETTINGS -->

<form action="index.php?site=statisticSetup#statisticSettings" method="post" enctype="multipart/form-data" accept-charset="UTF-8">
  <div><input type="hidden" name="send" value="statisticSetup"></div>

<?php
// show the block below if it is the ones which is saved before
if($SAVEDFORM == 'statisticConfig' || $SAVEDFORM === false)
    $hidden = '';
  else
    $hidden = ' hidden';
?>
<div class="block<?php echo $hidden; ?>">
  <h1><a href="#" id="statisticSettings"><img src="library/images/icons/statisticIcon_small.png" class="blockH1Icon" alt="icon" style="top:4px; left:5px;"><?php echo $langFile['STATISTICSSETUP_TITLE_STATISTICSSETTINGS']; ?></a></h1>
  <div class="content form">

    <div class="row">
      <div class="span3 formLeft">
        <label for="numberRefererLog"><span class="toolTipLeft" title="<?php echo '::'.$langFile['STATISTICSSETUP_TIP_REFERERNUMBER']; ?>">
        <?php echo $langFile['STATISTICSSETUP_TEXT_REFERERNUMBER']; ?></span></label>
      </div>
      <div class="span5">
        <input type="number" step="5" min="0" id="numberRefererLog" name="number[refererLog]" value="<?php echo $statisticConfig['number']['refererLog']; ?>">
        </div>
    </div>

    <div class="row">
      <div class="span3 formLeft">
        <label for="numberTaskLog"><span class="toolTipLeft" title="<?php echo '::'.$langFile['STATISTICSSETUP_TIP_ACTIVITYNUMBER']; ?>">
        <?php echo $langFile['STATISTICSSETUP_TEXT_ACTIVITYNUMBER']; ?></span></label>
      </div>
      <div class="span5">
        <input type="number" step="5" min="0" id="numberTaskLog" name="number[taskLog]" value="<?php echo $statisticConfig['number']['taskLog']; ?>">
        </div>
    </div>

    <input type="submit" value="" name="statisticConfig" class="button submit center" title="<?php echo $langFile['FORM_BUTTON_SUBMIT']; ?>">
  </div>
</div>

</form>


<!-- CLEAR STATISTICS -->

<form action="index.php?site=statisticSetup" method="post" enctype="multipart/form-data" id="clearStatisticsForm" name="clearStatisticsForm" accept-charset="UTF-8">
  <div><input type="hidden" name="sendClearstatistics" value="true"></div>

<?php
// shows the block below if it is the ones which is saved before
if($SAVEDFORM == 'clearStatistics')
    $hidden = '';
  else
    $hidden = ' hidden';
?>
<div class="block<?php echo $hidden; ?>">
  <h1><a href="#" id="clearStatistics"><img src="library/images/icons/statisticIcon_small.png" class="blockH1Icon" alt="icon" style="top:4px; left:5px;"><?php echo $langFile['statisticSetup_clearStatistic_h1']; ?></a></h1>
  <div class="content form">

    <div class="row">
      <div class="span3 formLeft">
        <input type="checkbox" id="clearStatistics_websiteStatistic" name="clearStatistics_websiteStatistic" value="true" class="toolTipLeft" title="::<?php echo $langFile['statisticSetup_clearStatistics_websiteStatistic_tip']; ?>">
      </div>
      <div class="span5">
        <label for="clearStatistics_websiteStatistic"><span class="toolTipRight" title="::<?php echo $langFile['statisticSetup_clearStatistics_websiteStatistic_tip']; ?>"><?php echo $langFile['statisticSetup_clearStatistics_websiteStatistic']; ?></span></label>
        </div>
    </div>

    <div class="row">
      <div class="span3 formLeft">
        <input type="checkbox" id="clearStatistics_pagesStatistics" name="clearStatistics_pagesStatistics" value="true" class="toolTipLeft" title="::<?php echo $langFile['statisticSetup_clearStatistics_pagesStatistic_tip']; ?>">
      </div>
      <div class="span5">
        <label for="clearStatistics_pagesStatistics"><span class="toolTipRight" title="::<?php echo $langFile['statisticSetup_clearStatistics_pagesStatistic_tip']; ?>"><?php echo $langFile['statisticSetup_clearStatistics_pagesStatistic']; ?></span></label>
        </div>
    </div>

    <div class="row">
      <div class="span3 formLeft">
        <input type="checkbox" id="clearStatistics_pagesStaylengthStatistics" name="clearStatistics_pagesStaylengthStatistics" value="true">
      </div>
      <div class="span5">
        <label for="clearStatistics_pagesStaylengthStatistics"><?php echo $langFile['statisticSetup_clearStatistics_pagesStaylengthStatistics']; ?></label>
        </div>
    </div>

    <div class="row">
      <div class="span3 formLeft">
        <input type="checkbox" id="clearStatistics_refererLog" name="clearStatistics_refererLog" value="true" class="toolTipLeft" title="::<?php echo $langFile['statisticSetup_clearStatistics_refererLog_tip']; ?>">
      </div>
      <div class="span5">
        <label for="clearStatistics_refererLog"><span class="toolTipRight" title="::<?php echo $langFile['statisticSetup_clearStatistics_refererLog_tip']; ?>"><?php echo $langFile['statisticSetup_clearStatistics_refererLog']; ?></span></label>
        </div>
    </div>

    <div class="row">
      <div class="span3 formLeft">
        <input type="checkbox" id="clearStatistics_taskLog" name="clearStatistics_taskLog" value="true" class="toolTipLeft" title="::<?php echo $langFile['statisticSetup_clearStatistics_taskLog_tip']; ?>">
      </div>
      <div class="span5">
        <label for="clearStatistics_taskLog"><span class="toolTipRight" title="::<?php echo $langFile['statisticSetup_clearStatistics_taskLog_tip']; ?>"><?php echo $langFile['statisticSetup_clearStatistics_taskLog']; ?></span></label>
        </div>
    </div>

    <input type="submit" value="" class="button submit center" title="<?php echo $langFile['FORM_BUTTON_SUBMIT']; ?>" onclick="openWindowBox('library/views/windowBox/clearStatistics.php','<?php echo $langFile['statisticSetup_clearStatistic_h1']; ?>');return false;">
  </div>
</div>
</form>