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
* @version 0.11
*/

echo '<ul>';
// ->> LIST the tasks
foreach($logContent as $logRow) {

  $logRow = explode('|-|',$logRow);
  $logDate = $statisticFunctions->formatDate($statisticFunctions->dateDayBeforeAfter($logRow[0]));
  $logTime = $statisticFunctions->formatTime($logRow[0]);
  
  if(isset($logRow[3])) {
    
    //vars
    $taskObject = '';
    $foundObject = false;
    $logObject = explode('|#|',$logRow[3]);
                     
    // -> IF there is a PAGE
    if(substr($logObject[0],0,5) == 'page=') {
      
      $pageId = substr($logObject[0],5);
      $pageId = $generalFunctions->cleanSpecialChars($pageId); // removes \n\r
      $pageContent = $generalFunctions->readPage($pageId,$generalFunctions->getPageCategory($pageId));
      
      $taskObject .= '<a href="?category='.$pageContent['category'].'&amp;page='.$pageContent['id'].'" title="'.$pageContent['title'].'">'.$generalFunctions->shortenTitle($pageContent['title'], 28).'</a>';
      
      $foundObject = true;
    }
    
    // -> IF there is a TEXT BETWEEN page and category
    if(isset($logObject[2])) {
      $taskObject .= '<br />'.$logObject[2];
      
      $foundObject = true;
    }
    
    // -> IF there is an CATEGORY set also
    if(substr($logObject[0],0,9) == 'category=' || substr($logObject[1],0,9) == 'category=') {
      
      $categoryId = (substr($logObject[0],0,9) == 'category=') ? substr($logObject[0],9) : substr($logObject[1],9);
      $categoryId = $generalFunctions->cleanSpecialChars($categoryId); // removes \n\r
      
      $taskObject .= '<a href="?site=pages&amp;category='.$categoryId.'" title="'.$categoryConfig['id_'.$categoryId]['name'].'">'.$categoryConfig['id_'.$categoryId]['name'].'</a>';
      
      $foundObject = true;                  
    }
    
    // -> OTHERWISE just use the task object name/text
    if($foundObject === false)
      $taskObject = '<span title="'.$logObject[0].'">'.$logObject[0].'</span>';
  }                  
  
  $user = (!empty($logRow[1]))
  ? '<br /><span>'.$langFile['home_user_h1'].': <b>'.$logRow[1].'</b></span>'
  : '';
  
  // displays 2 or 3 rows
  echo ($taskObject)
  ? '<li><span class="blue" style="font-weight:bold;">'.$logRow[2].'</span><br /><span>'.$taskObject.'</span><br /><span class="brown">'.$logDate.' '.$logTime.'</span>'.$user.'</li>'
  : '<li><span class="blue" style="font-weight:bold;">'.$logRow[2].'</span><br /><span class="brown">'.$logDate.' '.$logTime.'</span>'.$user.'</li>';
}
echo '</ul>';

?>