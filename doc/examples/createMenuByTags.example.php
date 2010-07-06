<?php
/*                               *** CODE *** 
--------------------------------------------------------------------------------
This example shows only the usage of tags for creating a menu,
for a detailed menu example see createMenu()
*/

// the feindura.include.php has to be included BEFORE the header of the HTML page is sent
// because a session is startet in this file
require('cms/feindura.include.php');

// creates a new feindura instance
$myCms = new feindura();

// the tags where the pages in the menu should have atleast one
$tags = 'winter summer spring';
// could also be an array like
// $tags = array(0 => 'winter', 1 => 'summer', 2 => 'spring');

// finally create the menu from the category with ID "1" using the above set tags
$menu = $myCms->createMenuByTags($tags,'category',1,'table',true,2,true);

// displays the menu
foreach($menu as $link) {
  echo $link;
}



/*                              *** RESULT *** 
--------------------------------------------------------------------------------
*/

<table>
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
</table>


?>