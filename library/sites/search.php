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
/**
 * The Backend search file.
 * 
 * @uses search::find() to search in the pages
 * 
 * @version 1.0
 * <br />
 * <b>ChangeLog</b><br />
 *    - 1.0 initial release
 *      
 */ 


/* LANGUAGE-VARS

$langFile['SEARCH_TITLE'] = 'Seiten durchsuchen';
$langFile['SEARCH_TITLE_RESULTS'] = 'Suchergebnisse f&uuml;r';
$langFile['SEARCH_TEXT_MATCH_TITLE'] = '&Uuml;bereinstimmungen im Titel';
$langFile['SEARCH_TEXT_MATCH_DATE'] = '&Uuml;bereinstimmungen im Seitendatum';
$langFile['SEARCH_TEXT_MATCH_WORDS'] = '&Uuml;bereinstimmende W&ouml;rter:';
$langFile['SEARCH_TEXT_MATCH_CATEGORY'] = '&Uuml;bereinstimmender Kategoriename';
$langFile['SEARCH_TEXT_MATCH_ID'] = '&Uuml;bereinstimmung mit der Seiten ID';
$langFile['SEARCH_TEXT_RESULTS'] = 'Treffer';
$langFile['SEARCH_TEXT_TIME_1'] = 'in'; // 12 Treffer in 0.32 Sekunden
$langFile['SEARCH_TEXT_TIME_2'] = 'Sekunden';

*/

// LADEZEIT MESSEN
$time_start = microtime(); //Zeitbeginn am Seitenanfang

/**
 * Includes the login and filters the incoming data by xssFilter
 */
require_once(dirname(__FILE__)."/../includes/secure.include.php");

// set the GET searchword as the POST searchword, IF exists
$searchWords = (isset($_GET['search'])) ? urldecode($_GET['search']) : $_POST['search'];

?>

<form action="index.php?site=<?= $_GET['site']; ?>" method="post" enctype="multipart/form-data" accept-charset="UTF-8">
  <div class="block">
  <h1><?= $langFile['SEARCH_TITLE']; ?></h1>
    <div class="content">
      <input name="search" type="text" size="50" value="<?= $searchWords; ?>" style="float:left; margin-top: 12px; margin-right:10px;" />
      <input type="submit" value="" class="button search" />
    </div>
    <div class="bottom"></div>
  </div>
</form>
<?php

// ->> SEARCHING, if searchwords are given
if(!empty($searchWords)) {
  
  // var
  $count = 0;

  // SEARCH RESULTS HEADLINE
  echo '<div class="block"><h1>'.$langFile['SEARCH_TITLE_RESULTS'].' &quot;'.$searchWords.'&quot;</h1><div class="bottom"></div></div>';
    
  // START SEARCH
  $search = new search();
  $search->checkIfPublic = false;
  $results = $search->find($searchWords);
  
  /*
  echo '<pre>';
  var_dump($results);
  echo '</pre>';
  */
  	
  // ->> OUTPUT
  // **********
  
  // -> messure end time
  $time_end = microtime();
  $time = round($time_end - $time_start,2);
  echo '<h2>'.count($results).' '.$langFile['SEARCH_TEXT_RESULTS'].' <span style="font-size:10px;">'.$langFile['SEARCH_TEXT_TIME_1'].' '.$time.' '.$langFile['SEARCH_TEXT_TIME_2'].'</span></h2>';
  
  // -> display results
  $countoutput = 0; 
  // FERTIGE AUSGABE sortiert nach prioritität 
  if(isset($results)) {
    foreach($results as $result) {
      
      $page = generalFunctions::readPage($result['page']['id'],$result['page']['category']);
      
      // -> generate toolTip information
      $pageDate = showPageDate($page);
      if($categoryConfig[$page['category']]['showTags'] && !empty($page['tags'])) {
        $pageTags = '[br /][br /]';
        $pageTags .= '[b]'.$langFile['sortablePageList_tags'].'[/b][br /]'.$page['tags'];
      }      
      $startPageText = ($adminConfig['setStartPage'] && $page['id'] == $websiteConfig['startPage'])
        ? $langFile['sortablePageList_functions_startPage_set'].'[br /][br /]'
        : '';
      
      echo '<div class="block open search"><h1>&nbsp;</h1>';
      
      // found ID
      if($result['id']) {
        echo '<span class="resultHeadline matchingID">';
        echo $langFile['SEARCH_TEXT_MATCH_ID'].' &rArr; ';      
        echo '</span>';
      }
      
      // first TITLE
      echo '<span class="resultHeadline">';
      echo '<a href="?category='.$page['category'].'&amp;page='.$page['id'].'" class="toolTip" title="'.str_replace(array('[',']','<','>','"'),array('(',')','(',')',''),$page['title']).'::'.$startPageText.'[b]ID[/b] '.$page['id'].$pageDate.$pageTags.'">';
      echo ($result['title']) ? $result['title'] : $page['title'];
      echo '</a>';
      echo '</span>';
      
      // otherwise display all results
      if($result['id'] === false) {
        echo '  <div class="content">';
        
        // CATEGORY
        if($result['category']) {
          echo '<br /><span class="keywords category">';
          echo ' '.$langFile['SEARCH_TEXT_MATCH_CATEGORY'].': '.$result['category'];
          echo '</span>';
        }
        
        // SEARCHWORDS
        if($result['searchwords']) {
          echo '<br /><span class="keywords blue">';
          echo ' '.$langFile['SEARCH_TEXT_MATCH_SEARCHWORDS'].': '.$result['searchwords'];
          echo '</span>';
        }
        
        // TAGS
        if($result['tags']) {
          echo '<br /><span class="keywords blue">';
          echo ' '.$langFile['SEARCH_TEXT_MATCH_TAGS'].': '.$result['tags'];
          echo '</span>';
        }
        
        echo '<p>';
        if($result['description'] || $result['content']) {
          // DESCRIPTION
          if($result['description']) {
            echo '<span class="description">'.$result['description'].'</span>';
          }
          if($result['content']) {
            echo $result['content'];
          }
          
        // if nothing in the content or description is found its shows the description
        } elseif(!empty($page['description']))
          echo '<span class="description">'.$page['description'].'</span>';
        else
          echo substr(strip_tags($page['content']),0,200);
          
        echo '</p>';
        echo '  </div>';
      }      
      
      //echo '  <div class="bottom"></div>';
      echo '</div>';
      
      $count++;
    }
    echo '<div style="height: 60px;">&nbsp;</div>';
  }
}
?>