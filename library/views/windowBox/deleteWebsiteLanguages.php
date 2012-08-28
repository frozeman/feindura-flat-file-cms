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
 * deleteWebsiteLanguages.php
 *
 * @version 0.1
 */

/**
 * Includes the login.include.php and backend.include.php and filter the basic data
 */
require_once(dirname(__FILE__)."/../../includes/secure.include.php");

echo ' '; // hack for safari, otherwise it throws an error that he could not find htmlentities like &ouml;

// gets the vars
$site = $_GET['site'];
$languages = explode(',',$_GET['languages']);
$languageString = '';

foreach ($languages as $langCode) {
  if($langCode != $_GET['mainLanguage']) {
    $languageString .= $languageNames[$langCode];
    if($langCode != $languages[count($languages)-1])
      $languageString .= ', ';
  }
}

$languageString = trim($languageString,', ');

// QUESTION
if(!empty($languageString))
  echo '<h2 class="red">'.sprintf($langFile['WINDOWBOX_TITLE_DELETEWEBSITELANGUAGES_QUESTION'],'<span style="color:#000000;">'.$languageString.'</span>').'</h2>';

if($_GET['status'] == 'deactivated')
  echo '<div class="alert alert-info center">'.sprintf($langFile['WINDOWBOX_TEXT_DELETEWEBSITELANGUAGES_QUESTION'],$languageNames[$_GET['mainLanguage']]).'</div>';

?>

<div class="row buttons">
  <div class="span4 center">
    <a href="?site=<?php echo $site ?>" class="button cancel" onclick="closeWindowBox();return false;">&nbsp;</a>
  </div>
  <div class="span4 center">
    <a href="#" class="button ok" onclick="$('websiteSettingsForm').submit();return false;">&nbsp;</a>
  </div>
</div>
