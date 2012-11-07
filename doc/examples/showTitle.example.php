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
$feindura = new Feindura();

?>
<!DOCTYPE html>
<html>
...

<?php

// set title properties
$feindura->titleLength =              10;
$feindura->titleAsLink =              true;
$feindura->titleShowPageDate =        true;
$feindura->titlePageDateSeparator =   ' - ';
$feindura->titleShowCategory =        true;
$feindura->titleCategorySeparator =   ' -> ';


// finally create the title from the page with ID "1" using the above set title properties
$title = $feindura->getPageTitle(1);

// displays the link
echo $title;


                               *** RESULT *** 
--------------------------------------------------------------------------------

<a href="?category=1&amp;page=3" title="Example Category 1 -> 31.12.2010 - Example Page">
Example Category -> 31.12.2010 - Example...
</a>

?>