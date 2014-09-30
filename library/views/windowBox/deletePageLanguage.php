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
 * deletePageLanguage.php
 *
 * @version 0.2
 */

/**
 * Includes the login.include.php and backend.include.php and filter the basic data
 */
require_once(dirname(__FILE__)."/../../includes/secure.include.php");

echo ' '; // hack for safari, otherwise it throws an error that he could not find htmlentities like &ouml;

// gets the vars
$category = (isset($_POST['category'])) ? $_POST['category'] : $_GET['category'];
$page = (isset($_POST['page'])) ? $_POST['page'] : $_GET['page'];
$language = (isset($_POST['language'])) ? $_POST['language'] : $_GET['language'];
$asking = $_POST['asking'];

// QUESTION
$question = '<h2 class="red">'.sprintf($langFile['WINDOWBOX_TEXT_DELETEPAGELANGUAGE_QUESTION'],'<span style="color:#000000;">'.$languageNames[$language].'</span>').'</h2>';

// DELETING PROCESS
if($_POST['asking']) {
  // load the page
  $pageContent = GeneralFunctions::readPage($page,$category);

  unset($pageContent['localized'][$language]);

  if(GeneralFunctions::savePage($pageContent)) {
    saveActivityLog(array(32,$languageNames[$language]),'page='.$pageContent['id']); // <- SAVE the task in a LOG FILE

    // ->> save the FEEDS, if activated
    saveFeeds($pageContent['category']);

    $question = '';
    $redirect = '?category='.$category.'&page='.$page.'&status=reload'.rand(1,99).'&websiteLanguage='.key($pageContent['localized']).'#pageInformation';
    // CLOSE the windowBox and REDIRECT, if the first part of the response is '#REDIRECT#'
    die('#REDIRECT#'.$redirect);

  } else
    $ERRORWINDOW .= sprintf($langFile['EDITOR_savepage_error_save'],$adminConfig['basePath']);

}

echo $question;

if(!$asking) {

?>
<form action="?site=deletePageLanguage" method="post" enctype="multipart/form-data" id="deletePageLanguageForm" onsubmit="requestSite('<?php echo $_SERVER['PHP_SELF']; ?>','','deletePageLanguageForm');return false;" accept-charset="UTF-8">
  <div>
    <input type="hidden" name="category" value="<?php echo $category; ?>">
    <input type="hidden" name="page" value="<?php echo $page; ?>">
    <input type="hidden" name="language" value="<?php echo $language; ?>">
    <input type="hidden" name="asking" value="true">
  </div>

  <div class="row buttons">
    <div class="span4 center">
      <a href="?site=pages&amp;category=<?php echo $category; ?>&amp;page=<?php echo $page; ?>" class="button cancel" onclick="closeWindowBox();return false;">&nbsp;</a>
    </div>
    <div class="span4 center">
      <input type="submit" value="" class="button submit">
    </div>
  </div>
</form>
<?php
}
?>