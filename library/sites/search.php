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
// setup.php version 2.44 (BACKEND)


/* LANGUAGE-VARS

$langFile['search_h1'] = 'Seiten durchsuchen';
$langFile['search_results_h1'] = 'Suchergebnisse f&uuml;r';
$langFile['search_results_text1'] = '&Uuml;bereinstimmungen im Titel';
$langFile['search_results_text2'] = '&Uuml;bereinstimmungen im Datum oder der Kategorie';
$langFile['search_results_text3'] = '&Uuml;bereinstimmende W&ouml;rter:';
$langFile['search_results_text4'] = '&Uuml;bereinstimmenden Satz gefunden';
$langFile['search_results_text8'] = '&Uuml;bereinstimmung mit der Seiten ID';
$langFile['search_results_count'] = 'Treffer';
$langFile['search_results_time_part1'] = 'in'; // 12 Treffer in 0.32 Sekunden
$langFile['search_results_time_part2'] = 'Sekunden';

*/

// LADEZEIT MESSEN
$time_start = microtime(); //Zeitbeginn am Seitenanfang

/**
 * Includes the login and filters the incoming data by xssFilter
 */
require_once(dirname(__FILE__)."/../includes/secure.include.php");

// set the GET searchword as the POST searchword, IF exists
if(isset($_GET['search']))
  $_POST['search'] = urldecode($_GET['search']);

// clean up the searchWord
$searchWord = stripslashes($_POST['search']);
//$searchWord = htmlentities($searchWord,ENT_NOQUOTES,'UTF-8');

// show the form
echo '<form action="index.php?site='.$_GET['site'].'" method="post" enctype="multipart/form-data" accept-charset="UTF-8">';

echo '<div class="block">
      <h1>'.$langFile['search_h1'].'</h1>
        <div class="content">
          <input name="search" type="text" size="50" value="'.$searchWord.'" style="float:left; margin-top: 12px; margin-right:10px;" />
          <input type="submit" value="" class="button search" />
        </div>
        <div class="bottom"></div>
      </div>
      </form>';

$count = '0';
// -------------------------------------------------------------------------------------------
// STARTS SEARCH
if(!empty($searchWord)) {

//$categoriesList = $categoryConfig;
//array_unshift($categoriesList,array('id' => 0,'name' => $langFile['categories_nocategories_name']));
$allPageContents = generalFunctions::loadPages(true,true);

// SEARCH RESULTS HEADLINE
echo '<div class="block"><h1>'.$langFile['search_results_h1'].' &quot;'.$searchWord.'&quot;</h1><div class="bottom"></div></div>';

// ------------------------
// --->> OUTPUT LAYOUT
function ausgabeblock_start($count,$pageContent) {
  global $categoryConfig;
  
  // set category name
  if(isset($categoryConfig[$pageContent['category']]['name']))
    $categoryName = '&rArr; '.$categoryConfig[$pageContent['category']]['name'];
  elseif($pageContent['category'] == 0)
    $categoryName = '&rArr; '.$GLOBALS['langFile']['CATEGORIES_TOOLTIP_NONCATEGORY'];
  
  // -> RETURN OUTPUT LAYOUT
  return '<div class="content"><h3><a href="?category='.$pageContent['category'].'&amp;page='.$pageContent['id'].'">'.$pageContent['title'].'</a> <span>'.$categoryName.'</span></h3><p>';
}
function ausgabeblock_end() {
  return '</p></div>
  <div class="bottom"></div>';
}
// --- ENDE OUTPUT LAYOUT
// ---------------------------




$search = new search();
$findings = $search->find($searchWord);

echo '<pre>';
var_dump($findings);
echo '</pre>';


	
// AUSGABE angabe der Treffer vor ausgabe
// LADEZEIT MESSEN ausgabe
$time_end = microtime();
$time = round($time_end - $time_start,2);

$timeOutputText = '<h2>'.$count.' '.$langFile['search_results_count'].' <span style="font-size:10px;">'.$langFile['search_results_time_part1'].' '.$time.' '.$langFile['search_results_time_part2'].'</span></h2>';

// show time and result number above
echo $timeOutputText;


$countoutput = 0; 
// FERTIGE AUSGABE sortiert nach prioritität 
if(isset($ausgabe)) {
	array_multisort($ausgabe,SORT_DESC, SORT_REGULAR);

  foreach($ausgabe as $output) {
    $countoutput++;
    //echo '|-'.$output['priority'].'-||';
    echo '<div class="block"><h1>'.$countoutput.'. <span style="font-size:10px;">'.$output['words'].'</span></h1>'.$output['output'].'</div>';
  }
  
  // show time and result number below
  //echo $timeOutputText;
}

unset($searchWord,$ausgabe);
} // ende if suche


?>