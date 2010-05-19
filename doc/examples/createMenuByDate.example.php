<?php
/*                               *** CODE *** 
--------------------------------------------------------------------------------
This example shows only the usage of a time period for creating a menu,
for a detailed menu example see createMenu()
*/

require('cms/feindura.include.php');

// creates a new feindura instance
$myCms = new feinduraPages();

// set this property to show the pagedate in the menu linktext
// the "text before date" and "text after date:" was set in the page editor in the backend
$myCms->linkShowPageDate = true;

// create the menu from the category with ID "1" using the time period:
// load all pages in the past until 8 months in the future starting from the date today: 31.05.2010
$menu = $myCms->createMenuByDate('category',1,true,8,'table',true,2,true,true);

// displays the menu
foreach($menu as $link) {
  echo $link;
}



/*                              *** RESULT *** 
--------------------------------------------------------------------------------
*/

<table>
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
</table>

?>