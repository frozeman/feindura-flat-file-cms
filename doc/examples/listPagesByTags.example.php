<?php
/*                               *** CODE *** 
--------------------------------------------------------------------------------
This example shows only the usage of tags for listing pages,
for a detailed example see listPages()
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


// get the pages from the category with ID "1"
// the page content will be shorten to "200" characters
foreach($feindura->listPagesByTags($tags,'category',1,200) as $page) {
  echo $page['title'].'<br>
       Has the following Tags: '.$page['tags']."\n";
  echo $page['content']."\n";
  echo "<br>-----------------------<br>\n";
}


                               *** RESULT *** 
--------------------------------------------------------------------------------

Example Page 1<br>
Has the following Tags: Winter antum

<h2>Example Headline</h2>
<p>Lorem ipsum dolor sit amet, consetetur sadipscing dolores et ea rebum.
Stet clita kasd gubergren, no sea takimata sanctus.</p>
<a href="?category=1&amp;page=1">mehr</a>

<br>-----------------------<br>

Example Page 2<br>
Has the following Tags: winter spring summer

<h2>Another Example Headline</h2>
<p>Lorem ipsum dolor sit amet, consetetur sadipscing dolores et ea rebum.</p>
<h2>And one more Example Headline</h2>
<p>Stet clita kasd gubergren, no sea takimata sanctus est...</p>
<a href="?category=1&amp;page=2">mehr</a>

<br>-----------------------<br>

Example Page 3<br>
Has the following Tags: spring antum

<p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor
invidunt ut labore et dolore magna aliquyam erat, ur sadipscing elitr,
Stet clita kasd...</p>
<a href="?category=1&amp;page=3">mehr</a>

<br>-----------------------<br>

?>