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
 * includes/currentVisitors.include.php
 *
 * @version 0.1
 */

/**
 * Includes the login.include.php and backend.include.php and filter the basic data
 */
require_once(dirname(__FILE__)."/../includes/secure.include.php");

// vars
$items = false;

// get the feindura.org news (try first rss2, its smaller, then atom)
if($feinduraNewsXml = simplexml_load_file('http://feindura.org/cms/pages/2/rss2.xml')) {

  foreach ($feinduraNewsXml->channel->item as $entries) {
    // DebugTools::dump($entries);
    $item['title'] = (string) $entries->title;
    $item['link'] = (string) $entries->link;
    $item['date'] = strtotime((string) $entries->pubDate);
    $items[] = $item;
  }

} elseif($feinduraNewsXml = simplexml_load_file('http://feindura.org/cms/pages/2/atom.xml')) {

  foreach ($feinduraNewsXml->entry as $entries) {
    $item['title'] = (string) $entries->title;
    $item['link'] = (string) $entries->link->attributes();
    $item['date'] = strtotime((string) $entries->updated);
    $items[] = $item;
  }
}

// display the links
if(!empty($items)) {
// DebugTools::dump($items);
  echo '<div class="box">';
    echo '<h1><span class="feinduraInline">fein<em>dura</em></span> News</h1>';
    echo '<ul class="unstyled resizeOnHover center">';
    foreach ($items as $item) {
      echo '<li><h3>'.GeneralFunctions::dateDayBeforeAfter($item['date']).'</h3><a href="'.$item['link'].'" target="_blank">'.$item['title'].'</a></li>';
    }
    echo '</ul>';
  echo '</div>';
}
