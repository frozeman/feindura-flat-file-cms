<?php
/*                               *** CODE *** 
--------------------------------------------------------------------------------
This example uses all possible properties.
It's also works much more simple: just call createLink(1) without setting properties
and you have a simple link with the page title.
*/

// a session will be started in the "feindura.include.php",
// therefor you have to include this file before the header of the HTML page is sent,
// which means before any HTML Tag.
require('cms/feindura.include.php');

// creates a new Feindura instance
$myCms = new Feindura();

// set title properties
$myCms->titleLength =              10;
$myCms->titleAsLink =              true;
$myCms->titleShowPageDate =        true;
$myCms->titleShowCategory =        true;
$myCms->titleCategorySeperator =   ' -> ';


// finally create the title from the page with ID "1" using the above set title properties
$title = $myCms->getPageTitle(1);

// displays the link
echo $title;


/*                              *** RESULT *** 
--------------------------------------------------------------------------------
*/

<a href="?category=1&amp;page=3" title="Example Category 1 -> 31.12.2010 Example Page">
Example Category -> 31.12.2010 Example...
</a>

?>