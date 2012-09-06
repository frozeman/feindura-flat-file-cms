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
 * sites/backup.php
 *
 * @version 0.1
 */


/**
 * Includes the login.include.php and backend.include.php and filter the basic data
 */
require_once(dirname(__FILE__)."/../includes/secure.include.php");

?>
<!-- <div class="block"> -->
  <h1><?php echo $langFile['ADDONS_TITLE_ADDON']; ?></h1>
<!-- </div> -->

<?php

foreach ($addons as $addon) {
  echo '<div class="block">
      <h2><a href="?site=addons&amp;addon='.$addon['name'].'"><img src="library/images/icons/addonIcon_middle.png" class="icons blockH2Icon">'.$addon['title'].'</a></h2>
    <div class="content">';

    echo '<div class="row">';
      echo '<div class="span7">';
        echo $addon['langFile']['feinduraAddon_description'];
      echo '</div>';

      // INFO BUTTON
      if(!empty($addon['website']) || !empty($addon['author']) || !empty($addon['version'])) {
        echo '<div class="span1 right">';
          echo '<a href="#" class="btn btn-small inBlockSliderLink" data-inBlockSlider="'.$addon['name'].'Info">'.$langFile['BUTTON_INFO'].'</a>';
        echo '</div>';
      }
    echo '</div>';

    // CREDITS
    if(!empty($addon['website']) || !empty($addon['author']) || !empty($addon['version'])) {
      echo '<div class="inBlockSlider hidden" data-inBlockSlider="'.$addon['name'].'Info"><div class="spacer"></div>';
      echo '<div class="well">';

        if(!empty($addon['author'])) {
          echo '<div class="row">
            <div class="span1">
            <strong>'.$langFile['ADDONS_TEXT_AUTHOR'].'</strong>
            </div>
            <div class="span3">
            '.$addon['author'].'
            </div>
          </div>';
        }

        if(!empty($addon['website'])) {
          echo '<div class="row">
            <div class="span1">
            <strong>'.$langFile['ADDONS_TEXT_WEBSITE'].'</strong>
            </div>
            <div class="span3">
            <a href="'.$addon['website'].'" target="_blank">'.$addon['website'].'</a>
            </div>
          </div>';
        }

        if(!empty($addon['version'])) {
          echo '<div class="row">
            <div class="span1">
            <strong>'.$langFile['ADDONS_TEXT_VERSION'].'</strong>
            </div>
            <div class="span3">
            '.$addon['version'].'
            </div>
          </div>';
        }

        if(!empty($addon['requirements'])) {
          echo '<div class="row">
            <div class="span1">
            <strong>'.$langFile['ADDONS_TEXT_REQUIREMENTS'].'</strong>
            </div>
            <div class="span3">
            '.$addon['requirements'].'
            </div>
          </div>';
        }

        echo '</div>';
      echo '</div>';
    }

  echo '</div>
  </div>';
}