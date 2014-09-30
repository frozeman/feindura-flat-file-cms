<?php
/*                               *** CODE *** 
--------------------------------------------------------------------------------
This example uses all possible properties.
It's also works much more simple: just call listPages() without setting properties
and list the current category given by $_GET variable.
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

// create the sort function, which we use with the listPagesBySortFunction() method
function sortByLastEditDate($a,$b) {
  if ($a['lastSaveDate'] == $b['lastSaveDate'])
    return 0;
  return ($a['lastSaveDate'] > $b['lastSaveDate']) ? -1 : 1;
}

// now we return the pages from the category with ID "1" and "2"
// the page content will be shorten to "200" characters
$pages = $feindura->listPagesBySortFunction('sortByLastEditDate','category',array(1,2),200);

// displays the pages (the "\n" creates a line break for a better look)
foreach($pages as $page) {
  echo $page['title']."\n\n";
  echo $page['thumbnail']."\n";
  echo $page['content']."\n";
  echo "<br>-----------------------<br>\n";
}


                               *** RESULT *** 
--------------------------------------------------------------------------------

Example Page 2

<h2>Example Headline</h2>
<p>Lorem ipsum dolor sit amet, consetetur sadipscing dolores et ea rebum.
Stet clita kasd gubergren, no sea takimata sanctus.</p>
<a href="?category=1&amp;page=2">mehr</a>

<br>-----------------------<br>

Example Page 3

<h2>Another Example Headline</h2>
<p>Lorem ipsum dolor sit amet, consetetur sadipscing dolores et ea rebum.</p>
<h2>And one more Example Headline</h2>
<p>Stet clita kasd gubergren, no sea takimata sanctus est...</p>
<a href="?category=1&amp;page=3">mehr</a>

<br>-----------------------<br>

Example Page 1

<p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor
invidunt ut labore et dolore magna aliquyam erat, ur sadipscing elitr,
Stet clita kasd...</p>
<a href="?category=2&amp;page=1">mehr</a>

<br>-----------------------<br>

?>