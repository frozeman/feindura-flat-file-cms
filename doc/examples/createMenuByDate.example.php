<?php
/*                               *** CODE *** 
--------------------------------------------------------------------------------
This example shows only the usage of a time period for creating a menu,
for a detailed menu example see createMenu()
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

// set this property to show the page date in the links text
// the "text before date" and "text after date" was set in the page editor in the backend
$feindura->linkShowPageDate      = true;
$feindura->linkPageDateSeparator = ': ';

// create the menu from the category with ID "1" using the time period:
// load all pages in the past until 8 months in the future starting from the date today: 31.05.2010
$menu = $feindura->createMenuByDate('category',1,array('table',2));

// displays the menu
foreach($menu as $item) {
  echo $item['menuItem'];
}



                               *** RESULT *** 
--------------------------------------------------------------------------------

<table>
  <tbody>
    <tr><td>
      <a href="?category=1&amp;page=1" title="text before date 2005-10-31 text after date: Oldest Page">
      text before date 2005-10-31 text after date: Oldest Page
      </a>
    </td><td>
      <a href="?category=1&amp;page=2" title="text before date 2010-11-31 text after date: Newer Page">
      text before date 2010-11-31 text after date: Newer Page
      </a>
    </td>
    </tr><tr>
    <td>
      <a href="?category=1&amp;page=3" title="text before date 2010-12-31 text after date: Newest Page">
      text before date 2010-12-31 text after date: Newest Page
      </a>
    </td><td></td>
    </tr>
  </tbody>
</table>

?>