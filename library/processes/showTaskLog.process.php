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
*    - $logRow[2] = log text
*    - $logRow[3] = log data
* 
* @version 0.11
*/

echo '<ul>';
// ->> LIST the tasks
foreach($logContent as $logRow) {
  
  //vars
  $maxLength = 28;
  $taskObject = null;
  $logUser = null;
  
  $logRow = explode('|#|',$logRow);
  $logDate = $statisticFunctions->formatDate($statisticFunctions->dateDayBeforeAfter($logRow[0]));
  $logTime = $statisticFunctions->formatTime($logRow[0]);  
  $logUser = (!empty($logRow[1]))
  ? '<br /><span>'.$langFile['home_user_h1'].': <b>'.$logRow[1].'</b></span>'
  : '';
  
  // add the right languageText
  switch($logRow[2]) {
    case 0:
        $logText = $langFile['log_page_new'];
        break;
    case 1:
        $logText = $langFile['log_page_saved'];
        break;
    case 2:
        $logText = $langFile['log_page_delete'];
        break;
    case 3:
        $logText = $langFile['log_listPages_moved'];
        break;
    case 4:
        $logText = $langFile['log_listPages_sorted'];
        break;
    case 5:
        $logText = $langFile['log_pageThumbnail_delete'];
        break;
    case 6:
        $logText = $langFile['log_pageThumbnail_upload'];
        break;
    case 7:
        $logText = $langFile['log_websiteSetup_saved'];
        break;
    case 8:
        $logText = $langFile['log_adminSetup_saved'];
        break;
    case 9:
        $logText = $langFile['log_adminSetup_ckstyles'];
        break;
    case 10:
        $logText = $langFile['log_websiteSetup_saved'];
        break;
    case 11:
        $logText = $langFile['log_pluginSetup_saved'];
        break;
    case 12:
        $logText = $langFile['log_file_saved'];
        break;
    case 13:
        $logText = $langFile['log_file_deleted'];
        break;
    case 14:
        $logText = $langFile['log_pageSetup_saved'];
        break;
    case 15:
        $logText = $langFile['log_pageSetup_new'];
        break;
    case 16:
        $logText = $langFile['log_pageSetup_delete'];
        break;
    case 17:
        $logText = $langFile['log_pageSetup_move'];
        break;
    case 18:
        $logText = $langFile['log_pageSetup_categories_saved'];
        break;
    case 19:
        $logText = $langFile['log_statisticSetup_saved'];
        break;
    case 20:
        $logText = $langFile['log_clearStatistic_pagesStatistics'];
        break;
    case 21:
        $logText = $langFile['log_clearStatistic_pagesStaylengthStatistics'];
        break;
    case 22:
        $logText = $langFile['log_clearStatistic_websiteStatistic'];
        break;
    case 23:
        $logText = $langFile['log_clearStatistic_refererLog'];
        break;
    case 24:
        $logText = $langFile['log_clearStatistic_taskLog'];
        break;
    case 25:
        $logText = $langFile['log_userSetup_useradd'];
        break;
    case 26:
        $logText = $langFile['log_userSetup_userdeleted'];
        break;
    case 27:
        $logText = $langFile['log_userSetup_userpass_changed'];
        break;
    case 28:
        $logText = $langFile['log_userSetup_userchanged'];
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
      $pageId = $generalFunctions->cleanSpecialChars($pageId); // removes \n\r
      $pageContent = $generalFunctions->readPage($pageId,$generalFunctions->getPageCategory($pageId));
      
      $taskObject .= '<a href="?category='.$pageContent['category'].'&amp;page='.$pageContent['id'].'" title="'.$pageContent['title'].'">'.$generalFunctions->shortenTitle($pageContent['title'], $maxLength).'</a>';
      
      $foundObject = true;
    }
    
    // -> IF there is a TEXT BETWEEN page and category
    if(isset($logObject[2]) == 'moved') {
      $taskObject .= '<br />'.$langFile['log_listPages_moved_in'].'<br />';
      
      $foundObject = true;
    }
    
    // -> IF there is an CATEGORY set also
    if(substr($logObject[0],0,9) == 'category=' || substr($logObject[1],0,9) == 'category=') {
      
      $categoryId = (substr($logObject[0],0,9) == 'category=') ? substr($logObject[0],9) : substr($logObject[1],9);
      $categoryId = $generalFunctions->cleanSpecialChars($categoryId); // removes \n\r
      
      $categoryName = ($categoryId == 0)
        ? $langFile['categories_noncategory_tip']
        : $categoryConfig[$categoryId]['name'];
      
      $taskObject .= '<a href="?site=pages&amp;category='.$categoryId.'" title="'.$categoryName.'">'.$generalFunctions->shortenTitle($categoryName, $maxLength).'</a>';
      
      $foundObject = true;                  
    }
    
    // -> OTHERWISE just use the task object name/text
    if($foundObject === false)
      $taskObject = '<span title="'.$logObject[0].'">'.$generalFunctions->shortenTitle($logObject[0], $maxLength).'</span>';
  }                  
  
  
  
  // displays 2 or 3 rows
  echo ($taskObject)
  ? '<li><span class="blue" style="font-weight:bold;">'.$logText.'</span><br /><span>'.$taskObject.'</span><br /><span class="brown">'.$logDate.' '.$logTime.'</span>'.$logUser.'</li>'
  : '<li><span class="blue" style="font-weight:bold;">'.$logText.'</span><br /><span class="brown">'.$logDate.' '.$logTime.'</span>'.$logUser.'</li>';
}
echo '</ul>';

?>