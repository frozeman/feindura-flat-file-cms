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
 * deletePage.php
 *
 * @version 1.2
 */

/**
 * Includes the login.include.php and backend.include.php and filter the basic data
 */
require_once(dirname(__FILE__)."/../../includes/secure.include.php");

echo ' '; // hack for safari, otherwise it throws an error that he could not find htmlentities like &ouml;

// gets the vars
$category = (isset($_POST['category'])) ? $_POST['category'] : $_GET['category'];
$page = (isset($_POST['page'])) ? $_POST['page'] : $_GET['page'];
$asking = $_POST['asking'];

// load the page
$pageContent = GeneralFunctions::readPage($page,$category);

// sets the none category (0) to empty
$categoryPath = ($category == 0) ? '' : $category.'/';

// QUESTION
if(is_file(dirname(__FILE__).'/../../../pages/'.$categoryPath.$page.'.php')) {
  $question = '<h2 class="red">'.$langFile['deletePage_question_part1'].' &quot;<span style="color:#000000;">'.strip_tags(GeneralFunctions::getLocalized($pageContent,'title')).'</span>&quot; '.$langFile['deletePage_question_part2'].'</h2>';

// NOT EXISTING
} else {
  $question = '<div class="alert alert-error">'.$langFile['deletePage_notexisting_part1'].' &quot;<span style="color:#000000;">'.$adminConfig['basePath'].'pages/'.$categoryPath.$page.'.php</span>&quot; '.$langFile['deletePage_notexisting_part2'].'</div>
  <a href="?site=pages&amp;category='.$category.'&amp;page='.$page.'" class="button ok center" onclick="closeWindowBox(\'index.php?site=pages&category='.$category.'&status=reload'.rand(1,99).'#categoryAnchor'.$category.'\');return false;">&nbsp;</a>';

  // reload the $pagesMetaData array
  GeneralFunctions::savePagesMetaData();

  // show only the ok button
  $asking = true;
}

// DELETING PROCESS
if($asking) {

  // DELETING PAGE
  if(GeneralFunctions::deletePage($pageContent)) {

    saveActivityLog(2,strip_tags(GeneralFunctions::getLocalized($pageContent,'title'))); // <- SAVE the task in a LOG FILE

    saveFeeds($pageContent['category']);
    saveSitemap();

    $question = false;
    $redirect = '?site=pages&category='.$category.'&status=reload'.rand(1,99).'#categoryAnchor'.$category;
    // CLOSE the windowBox and REDIRECT, if the first part of the response is '#REDIRECT#'
    die('#REDIRECT#'.$redirect);

  } else {
    // DELETING ERROR --------------
    $question = '<div class="alert alert-error">'.$langFile['deletePage_finish_error'].'</div>
    <a href="?site=pages&amp;category='.$category.'&amp;page='.$page.'" class="button ok center" onclick="closeWindowBox();return false;"></a>'."\n";
  }
}

echo $question;


if(!$asking) {

?>

<form action="?site=deletePage" method="post" enctype="multipart/form-data" id="deletePageForm" onsubmit="requestSite('<?php echo $_SERVER['PHP_SELF']; ?>','','deletePageForm');return false;" accept-charset="UTF-8">
  <div>
    <input type="hidden" name="category" value="<?php echo $category; ?>">
    <input type="hidden" name="page" value="<?php echo $page; ?>">
    <input type="hidden" name="id" value="<?php echo $page; ?>">
    <input type="hidden" name="asking" value="true">
  </div>
<div class="row buttons">
  <div class="span4 center">
    <a href="?site=pages&amp;category=<?php echo $category; ?>&amp;page=<?php echo $page; ?>" class="button cancel" onclick="closeWindowBox();return false;"></a>
  </div>
  <div class="span4 center">
    <input type="submit" value="" class="button submit">
  </div>
</div>
</form>
<?php
}
?>