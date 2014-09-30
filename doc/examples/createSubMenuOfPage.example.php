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

// will create a <ul> menu from the non category (ID 0)
$menu = $feindura->createMenu('category',0,'ul');

// displays the menu
foreach($menu as $item) {
  echo $item['startTag'].$item['link'];
  // when a page has a submenu it will create a <ul> menu inside this <li></li>,
  // which can be used as a CSS dropdown menu. e.g. see http://www.cssnewbie.com/easy-css-dropdown-menus/
  foreach($feindura->createSubMenuOfPage($item['pageId'],'ul') as $subItem) {
    echo $subItem['menuItem'];
  }
  echo $item['endTag'];
}


                               *** RESULT *** 
--------------------------------------------------------------------------------

<ul>
  <li>
    <a href="?category=1&page=1" title="Example Page 1">
    Example Page 1
    </a>
    
    <ul>
      <li>
        <a href="?category=2&page=4" title="Example Page in SubCategory 1">
        Example Page in SubCategory 1
        </a>
      </li>
      <li>
        <a href="?category=2&page=5" title="Example Page in SubCategory 2">
        Example Page in SubCategory 2
        </a>
      </li>
    </ul>

  </li>
  <li>
    <a href="?category=1&page=2" title="Example Page 2">
    Example Page 2
    </a>
  </li>
  <li>
    <a href="?category=1&page=3" title="Example Page 3">
    Example Page 3
    </a>
  </li>
</ul>

?>