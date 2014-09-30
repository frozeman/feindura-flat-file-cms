<?php
/*                               *** CODE *** 
--------------------------------------------------------------------------------
This example uses all possible properties.
It's also works much more simple: just call createMenu('category',1)
and you have a simple array with links of the pages from this category.
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

// create the sort function, which we use with the createMenuBySortFunction() method
function sortByLastEditDate($a,$b) {
  if ($a['lastSaveDate'] == $b['lastSaveDate'])
    return 0;
  return ($a['lastSaveDate'] > $b['lastSaveDate']) ? -1 : 1;
}

// now we create the menu from the category with ID "1"
$menu = $feindura->createMenuBySortFunction('sortByLastEditDate','category',1,array('table',2));

// displays the menu
foreach($menu as $item) {
  echo $item['menuItem'];
}



                               *** RESULT *** 
--------------------------------------------------------------------------------

<table>
  <tbody>
    <tr><td>
      <a href="?category=1&amp;page=2" title="Example Page 2">
      Example Page 2
      </a>
    </td>
    <td>
      <a href="?category=1&amp;page=1" title="Example Page 1">
      Example Page 1
      </a>
    </td>
    </tr><tr>
    <td>
      <a href="?category=1&amp;page=4" title="Example Page 4">
      Example Page 4
      </a>
    </td>
    <td>
      <a href="?category=1&amp;page=3" title="Example Page 3">
      Example Page 3
      </a>
    </td></tr>
  </tbody>
</table>

?>