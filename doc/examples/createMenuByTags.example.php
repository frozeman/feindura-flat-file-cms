<?php
/*                               *** CODE *** 
--------------------------------------------------------------------------------
This example shows only the usage of tags for creating a menu,
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

// the tags where the pages in the menu should have atleast one
$tags = 'winter summer spring';
// could also be an array like
// $tags = array(0 => 'winter', 1 => 'summer', 2 => 'spring');

// finally create the menu from the category with ID "1" using the above set tags
$menu = $feindura->createMenuByTags($tags,'category',1,array('table',2));

// displays the menu
foreach($menu as $item) {
  echo $item['menuItem'];
}


                               *** RESULT *** 
--------------------------------------------------------------------------------

<table>
  <tbody>
    <tr><td>
      <a href="?category=1&amp;page=1" title="Summer Page">
      Summer Page
      </a>
    </td><td>
      <a href="?category=1&amp;page=2" title="Winter Page">
      Winter Page
      </a>
    </td>
    </tr><tr>
    <td>
      <a href="?category=1&amp;page=6" title="Spring Page">
      Spring Page
      </a>
    </td><td></td>
    </tr>
  </tbody>
</table>


?>