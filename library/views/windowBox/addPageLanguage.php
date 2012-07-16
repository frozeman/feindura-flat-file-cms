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
 * addPageLanguage.php
 *
 * @version 0.1
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
$pageContent = GeneralFunctions::readPage($page,$category);

// LANGUAGE SELECTION
$question = '<div class="row">
                <div class="span3 right">
                  <label for="addLanguageSelection">'.$langFile['WINDOWBOX_TEXT_ADDPAGE_SELECTLANGUAGE'].'</label>
                </div>
                <div class="span5">
                  <select name="addLanguageSelection" id="addLanguageSelection">'."\n";
                  // create language selection
                  foreach ($websiteConfig['multiLanguageWebsite']['languages'] as $langCode) {
                    if(!array_key_exists($langCode, $pageContent['localized'])) {
                      $question .= '<option value="'.$langCode.'">'.$languageNames[$langCode].'</option>';
                    }
                  }
$question .= '    </select>
                </div>
              </div>';

// -> SHOW TEMPLATE SELECTION
$question .= '<div class="row">
                <div class="span3 right">
                  <label for="useLanguageSelection">'.$langFile['EDITOR_TEXT_CHOOSETEMPLATE'].'</label>
                </div>
                <div class="span5">
                  <select name="useLanguageSelection" id="useLanguageSelection">
                  <option value="none">-</option>'."\n";
                  // -> goes trough categories and list them
                  foreach(array_keys($pageContent['localized']) as $langCode) {
                    $question .= '<option value="'.$langCode.'">'.$languageNames[$langCode].'</option>';
                  }
$question .= '    </select>
                </div>
              </div>';


// ADD LANGUAGE
if($_POST['asking']) {

  // if($_POST['useLanguageSelection'] != 'none')
  //   $pageContent['localized'][$_POST['addLanguageSelection']] = $pageContent['localized'][$_POST['useLanguageSelection']];
  // else
  //   $pageContent['localized'][$_POST['addLanguageSelection']] = array();


  // if(GeneralFunctions::savePage($pageContent)) {
  //   saveActivityLog(array(33,$languageNames[$_POST['addLanguageSelection']]),'page='.$pageContent['id']); // <- SAVE the task in a LOG FILE

    $question = false;
    // create redirect
    $redirect = '?category='.$category.'&page='.$page.'&websiteLanguage='.$_POST['addLanguageSelection'].'&status=addLanguage&template='.$_POST['useLanguageSelection'];
    // CLOSE the windowBox and REDIRECT, if the first part of the response is '#REDIRECT#'
    die('#REDIRECT#'.$redirect);

}

if(!$asking) {

echo $question;

?>

<form action="?site=addPageLanguage" method="post" enctype="multipart/form-data" id="addPageLanguageForm" onsubmit="requestSite('<?php echo $_SERVER['PHP_SELF']; ?>','','addPageLanguageForm');return false;" accept-charset="UTF-8">
  <div>
    <input type="hidden" name="category" value="<?php echo $category; ?>">
    <input type="hidden" name="page" value="<?php echo $page; ?>">
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