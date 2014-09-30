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

// will list the subpages of the current page. The 200 is the maximum number of characters we want to display
foreach($feindura->listSubPages(false,200) as $subPage) {
   echo '<h1>'.$subPage['title'].'</h1>';
   echo $subPage['content']."\n";
   echo "<br>-----------------------<br>\n";
}


                               *** RESULT *** 
--------------------------------------------------------------------------------

<h1>Example SubPage 1</h1>
<p>Lorem ipsum dolor sit amet, consetetur sadipscing dolores et ea rebum.
Stet clita kasd gubergren, no sea takimata sanctus.</p>
<a href="?category=1&amp;page=2">mehr</a>

<br>-----------------------<br>

<h1>Example SubPage 2</h1>
<p>Lorem ipsum dolor sit amet, consetetur sadipscing dolores et ea rebum.</p>
<h2>And one more Example Headline</h2>
<p>Stet clita kasd gubergren, no sea takimata sanctus est...</p>
<a href="?category=1&amp;page=3">mehr</a>

<br>-----------------------<br>

?>