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
 *
 * The Backend search file.
 *
 * @uses Search::find() to search in the pages
 *
 * @version 1.0
 * <br>
 * <b>ChangeLog</b><br>
 *    - 1.0 initial release
 *
 */


/* LANGUAGE-VARS

$langFile['SEARCH_TITLE'] = 'Seiten durchsuchen';
$langFile['SEARCH_TITLE_RESULTS'] = 'Suchergebnisse für';
$langFile['SEARCH_TEXT_MATCH_ID'] = 'Übereinstimmung mit der Seiten ID';
$langFile['SEARCH_TEXT_MATCH_CATEGORY'] = 'Kategorie';
$langFile['SEARCH_TEXT_MATCH_SEARCHWORDS'] = 'Suchworte';
$langFile['SEARCH_TEXT_MATCH_TAGS'] = 'Tags';
$langFile['SEARCH_TEXT_RESULTS'] = 'Treffer';
$langFile['SEARCH_TEXT_TIME_1'] = 'in'; // 12 Treffer in 0.32 Sekunden
$langFile['SEARCH_TEXT_TIME_2'] = 'Sekunden';

*/

// LADEZEIT MESSEN
$time_start = microtime(); //Zeitbeginn am Seitenanfang

/**
 * Includes the login.include.php and backend.include.php and filter the basic data
 */
require_once(dirname(__FILE__)."/../includes/secure.include.php");

// set the GET searchword as the POST searchword, IF exists
$searchWords = (isset($_GET['search'])) ? urldecode($_GET['search']) : $_POST['search'];
$searchWords = GeneralFunctions::smartStripslashes($searchWords);
?>

<form action="index.php?site=<?php echo $_GET['site']; ?>" method="post" enctype="multipart/form-data" accept-charset="UTF-8">
  <div class="block">
  <h1><?php echo $langFile['BUTTON_SEARCH']; ?></h1>
    <div class="content">
      <input type="search" name="search" class="input-xxlarge" value="<?php echo htmlentities($searchWords,ENT_QUOTES,'UTF-8'); ?>" style="float:left; margin-top: 12px; margin-right:10px;" autofocus="autofocus">
      <input type="submit" value="" class="button searchSubmit">
    </div>
  </div>
</form>
<?php

// ->> SEARCHING, if searchwords are given
if(!empty($searchWords)) {

  // var
  $count = 0;

  // ->> START SEARCH
  // ****************
  $search = new Search(); //$_SESSION['feinduraSession']['websiteLanguage']
  $search->onlyPublic = false;
  $search->checkPermissions = true;
  $results = $search->find($searchWords);

  /*
  echo '<pre>';
  var_dump($results);
  echo '</pre>';
  */

  // ->> OUTPUT
  // **********

  // SEARCH RESULTS HEADLINE
  echo '<h1>'.$langFile['SEARCH_TITLE_RESULTS'].' &quot;'.htmlentities($searchWords,ENT_QUOTES,'UTF-8').'&quot;</h1>';

  // -> messure end time
  $time_end = microtime();
  $time = round($time_end - $time_start,2);
  echo '<h2>'.count($results).' '.$langFile['SEARCH_TEXT_RESULTS'].' <span style="font-size:10px;">'.$langFile['SEARCH_TEXT_TIME_1'].' '.$time.' '.$langFile['SEARCH_TEXT_TIME_2'].'</span></h2>';

  // -> display results
  $countoutput = 0;
  // FERTIGE AUSGABE sortiert nach prioritität
  if(isset($results)) {
    foreach($results as $result) {

      $page = GeneralFunctions::readPage($result['page']['id'],$result['page']['category']);

      // echo '<div class="searchResults">';
      echo '<div class="block searchResults">';//<h1>&nbsp;</h1>

      // first TITLE
      echo '<h2>';
      echo '<a href="?category='.$page['category'].'&amp;page='.$page['id'].'" class="toolTipLeft" title="'.showPageToolTip($page).'">';
      echo ($result['title']) ? $result['title'] : strip_tags(GeneralFunctions::getLocalized($page,'title'));
      echo '</a>';
      echo '</h2>';
      echo '<div class="content">';

      // found ID
      if($result['id']) {
        echo '<span class="matchingID">';
        echo $langFile['SEARCH_TEXT_MATCH_ID'].' &rArr; '.$result['id'];
        echo '</span>';
      }

      // otherwise display all results
      if($result['id'] === false) {

        // CATEGORY
        if($result['category']) {
          echo '<br><span class="keywords category">';
          echo ' '.$langFile['SEARCH_TEXT_MATCH_CATEGORY'].': '.$result['category'];
          echo '</span>';
        }

        // SEARCHWORDS
        if($result['searchwords']) {
          echo '<br><span class="keywords blue">';
          echo ' '.$langFile['SEARCH_TEXT_MATCH_SEARCHWORDS'].': '.$result['searchwords'];
          echo '</span>';
        }

        // TAGS
        if($result['tags']) {
          echo '<br><span class="keywords blue">';
          echo ' '.$langFile['SEARCH_TEXT_MATCH_TAGS'].': '.$result['tags'];
          echo '</span>';
        }

        echo '<p>';
        if($result['description'] || $result['content']) {
          // DESCRIPTION
          if($result['description']) {
            echo '<span class="description">'.$result['description'].'</span>';
          }
          // CONTENT
          if($result['content']) {
            echo $result['content'];
          }

        // if nothing in the content or description is found its shows the description
        $localizedDescription = GeneralFunctions::getLocalized($page,'description');
        } elseif(!empty($localizedDescription))
          echo '<span class="description">'.GeneralFunctions::getLocalized($page,'description').'</span>';
        else
          echo substr(strip_tags(GeneralFunctions::getLocalized($page,'content')),0,200);

        echo '</p>';
      }

        echo '</div>';
      echo '</div>';

      $count++;
    }
    echo '<div class="spacer"></div>';
  }
}
?>