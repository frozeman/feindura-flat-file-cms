<?php
/*                               *** CODE *** 
--------------------------------------------------------------------------------
This example uses no extra properties. To see an example using all the properties, see the createMenu() method example.
*/

// a session will be started in the "feindura.include.php",
// therefor you have to include this file before the header of the HTML page is sent,
// which means before any HTML Tag.
require('cms/feindura.include.php');

// creates a new Feindura instance
$feindura = new Feindura();

?>
<!DOCTYPE html>
<html>
...

<?php

// will create a <ul> language menu
$menu = $feindura->createLanguageMenu('ul.langMenu');

// displays the menu
foreach($menu as $item) {
  echo $item['item'];
}


                               *** RESULT *** 
--------------------------------------------------------------------------------

<ul class="langMenu">
  <li><a href="/en/page/current-page-with-english-title" title="English">
  English
  </a></li>
  <li><a href="/nl/page/current-page-with-dutch-title" title="Dutch">
  Dutch
  </a></li>
</ul>

?>