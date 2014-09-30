<?php
/*
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
 */
/**
* showTaksLog.php
*
* Lists all tasks in an unorderd list (<ul><li></li></ul>).
*
* log Data
*    - $logRow[0] = date and time
*    - $logRow[1] = username
*    - $logRow[2] = log text (can also be an serialized array with [logTextNumber,LogFormatStringValue])
*    - $logRow[3] = log data
*
* @version 0.2
*/

/**
 * Includes the login.include.php and backend.include.php and filter the basic data
 */
require_once(dirname(__FILE__)."/../includes/secure.include.php");

echo '<ul class="unstyled resizeOnHover">';
// ->> LIST the tasks
$count = 100;
foreach($logContent as $logRow) {

  //vars
  $maxLength = 30;
  $taskObject = null;
  $logUser = null;

  $logRow = explode('|#|',$logRow);
  $logDate = GeneralFunctions::dateDayBeforeAfter($logRow[0]);
  $logTime = formatTime($logRow[0]);
  if(!empty($logRow[1])) {
    if(is_numeric($logRow[1]))
      $logUser = '<br><span>'.$langFile['DASHBOARD_TITLE_USER'].': <b>'.$userConfig[$logRow[1]]['username'].'</b></span>';
    else
      $logUser = '<br><span>'.$langFile['DASHBOARD_TITLE_USER'].': <b>'.$logRow[1].'</b></span>';
  } else
    $logUser = '';

  // LOGTEXT NUMBER can also be an array with: [logText,logTextValue]
  // legacy Fallback
  $logTextNumber = (is_numeric($logRow[2])) ? $logRow[2] : unserialize($logRow[2]);

  if(is_array($logTextNumber)) {
    $logRow[2] = $logTextNumber[0];
    $logTextValue = $logTextNumber[1];
  } elseif(is_numeric($logTextNumber))
    $logRow[2] = $logTextNumber;

  // add the right languageText
  switch($logRow[2]) {
    case 0:
        $logText = $langFile['LOG_PAGE_NEW'];
        break;
    case 1:
        $logText = $langFile['LOG_PAGE_SAVED'];
        break;
    case 2:
        $logText = $langFile['LOG_PAGE_DELETE'];
        break;
    case 3:
        $logText = $langFile['LOG_PAGE_MOVEDINCATEGORY'];
        break;
    case 4:
        $logText = $langFile['LOG_PAGE_SORTED'];
        break;
    case 5:
        $logText = $langFile['LOG_THUMBNAIL_DELETE'];
        break;
    case 6:
        $logText = $langFile['LOG_THUMBNAIL_UPLOAD'];
        break;
    case 7:
        $logText = $langFile['LOG_WEBSITESETUP_SAVED'];
        break;
    case 8:
        $logText = $langFile['LOG_ADMINSETUP_SAVED'];
        break;
    case 9:
        $logText = $langFile['LOG_ADMINSETUP_CKSTYLES'];
        break;
    case 10:
        $logText = $langFile['LOG_WEBSITESETUP_SAVED'];
        break;
    case 11:
        //$logText = $langFile['LOG_PLUGINSETUP_SAVED'];
        break;
    case 12:
        $logText = $langFile['LOG_FILE_SAVED'];
        break;
    case 13:
        $logText = $langFile['LOG_FILE_DELETED'];
        break;
    case 14:
        $logText = $langFile['LOG_PAGESETUP_SAVED'];
        break;
    case 15:
        $logText = $langFile['LOG_PAGESETUP_CATEGORIES_NEW'];
        break;
    case 16:
        $logText = $langFile['LOG_PAGESETUP_CATEGORIES_DELETED'];
        break;
    case 17:
        $logText = $langFile['LOG_PAGESETUP_CATEGORIES_MOVED'];
        break;
    case 18:
        $logText = $langFile['LOG_PAGESETUP_CATEGORIES_SAVED'];
        break;
    case 19:
        $logText = $langFile['LOG_STATISTICSETUP_SAVED'];
        break;
    case 20:
        $logText = $langFile['LOG_CLEARSTATISTICS_PAGESTATISTICS'];
        break;
    case 21:
        $logText = $langFile['LOG_CLEARSTATISTICS_PAGESTAYLENGTH'];
        break;
    case 22:
        $logText = $langFile['LOG_CLEARSTATISTICS_WEBSITESTATISTIC'];
        break;
    case 23:
        $logText = $langFile['LOG_CLEARSTATISTICS_REFERERLOG'];
        break;
    case 24:
        $logText = $langFile['LOG_CLEARSTATISTICS_ACTIVITYLOG'];
        break;
    case 25:
        $logText = $langFile['LOG_USER_ADD'];
        break;
    case 26:
        $logText = $langFile['LOG_USER_DELETED'];
        break;
    case 27:
        $logText = $langFile['LOG_USER_PASSWORD_CHANGED'];
        break;
    case 28:
        $logText = $langFile['LOG_USER_SAVED'];
        break;
    case 29:
        $logText = $langFile['LOG_BACKUP_CREATED'];
        break;
    case 30:
        $logText = $langFile['LOG_BACKUP_RESTORED'];
        break;
    case 31:
        $logText = $langFile['LOG_BACKUP_DELETED'];
        break;
    case 32:
        $logText = sprintf($langFile['LOG_PAGELANGUAGE_DELETED'],$logTextValue);
        break;
    case 33:
        $logText = sprintf($langFile['LOG_PAGELANGUAGE_ADD'],$logTextValue);
        break;
  }

  // ->> PROCESS LOG DATA
  if(isset($logRow[3])) {

    //vars
    $taskObject = '';
    $foundObject = false;
    $logObject = explode('|-|',$logRow[3]);

    // -> IF there is a PAGE
    if(substr($logObject[0],0,5) == 'page=') {

      $pageId = substr($logObject[0],5);
      $pageId = GeneralFunctions::cleanSpecialChars($pageId); // removes \n\r
      $pageContent = GeneralFunctions::readPage($pageId,GeneralFunctions::getPageCategory($pageId));

      $taskObject .= '<a href="?category='.$pageContent['category'].'&amp;page='.$pageContent['id'].'" tabindex="'.$count.'" title="'.strip_tags(GeneralFunctions::getLocalized($pageContent,'title')).'">'.GeneralFunctions::shortenString(strip_tags(GeneralFunctions::getLocalized($pageContent,'title')), $maxLength).'</a>';

      $foundObject = true;
    }

    // -> IF there is a TEXT BETWEEN page and category
    if(isset($logObject[2]) == 'moved') {
      $taskObject .= ' '.$langFile['LOG_PAGE_MOVEDTOCATEGORY_CATEGORY'].' ';

      $foundObject = true;
    }

    // COUNT the tabindex here
    $count++;

    // -> IF there is an CATEGORY set also
    if(substr($logObject[0],0,9) == 'category=' || substr($logObject[1],0,9) == 'category=') {

      $categoryId = (substr($logObject[0],0,9) == 'category=') ? substr($logObject[0],9) : substr($logObject[1],9);
      $categoryId = GeneralFunctions::cleanSpecialChars($categoryId); // removes \n\r

      $categoryName = GeneralFunctions::getLocalized($categoryConfig[$categoryId],'name');

      $taskObject .= '<a href="?site=pages&amp;category='.$categoryId.'" tabindex="'.$count.'" title="'.$categoryName.'">'.GeneralFunctions::shortenString($categoryName, $maxLength).'</a>';

      $foundObject = true;
    }

    // -> OTHERWISE just use the task object name/text
    if($foundObject === false)
      $taskObject = '<span title="'.strip_tags($logObject[0]).'">'.GeneralFunctions::shortenString(strip_tags($logObject[0]), $maxLength).'</span>';

    $taskObject = '<br>'.$taskObject;
  }



  // displays 2 or 3 rows
  echo ($taskObject)
  ? '<li><h3>'.$logDate.' '.$logTime.'</h3><span class="blue" style="font-weight:bold;">'.$logText.'</span>'.$taskObject.$logUser.'</li>'."\n"
  : '<li><h3>'.$logDate.' '.$logTime.'</h3><span class="blue" style="font-weight:bold;">'.$logText.'</span>'.$logUser.'</li>'."\n";
}
echo '</ul>';

?>