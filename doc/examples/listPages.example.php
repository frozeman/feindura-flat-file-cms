<?php
/*                               *** SIMPLE EXAMPLE *** 
-------------------------------------------------------------------------------- */

// add before any HTML Tag. (eg. before the <!doctype html>)
require('cms/feindura.include.php');

// creates a new Feindura instance
$feindura = new Feindura();

?>
<!DOCTYPE html>
<html>
...

<?php

// Get the pages from the category with ID "1"
// the page content will be shorten to "200" characters
$pages = $feindura->listPages('category',1,200);

// displays the pages
foreach($pages as $page) {
  echo '<h1>'.$page['title'].'</h1>';
  echo $page['content'];
  echo '<br>-----------------------<br>\n';
}

                               *** RESULT *** 
--------------------------------------------------------------------------------

<h1>Example Page 1</h1>
<p>Lorem ipsum dolor sit amet, consetetur sadipscing dolores et ea rebum.
Stet clita kasd gubergren, no sea takimata sanctus.</p>
<a href="?category=1&amp;page=1">mehr</a>

<br>-----------------------<br>

<h1>Example Page 2</h1>
<p>Lorem ipsum dolor sit amet, consetetur sadipscing dolores et ea rebum.
Stet clita kasd gubergren, no sea takimata sanctus.</p>
<a href="?category=1&amp;page=2">mehr</a>

<br>-----------------------<br>


/*                               *** EXTENDED EXAMPLE *** 
--------------------------------------------------------------------------------
This example uses all possible properties.
It's also works much more simple: just call listPages() without setting properties
and list the current category given by $_GET variable.
*/

// add before any HTML Tag. (eg. before the <!doctype html>)
require('cms/feindura.include.php');

// creates a new Feindura instance
$feindura = new Feindura();

// set properties
$feindura->xHtml =                  true;

$feindura->showErrors =              true;
$feindura->errorTag =               'div.alertClass';

$feindura->titleLength =            20;
$feindura->titleAsLink =            true;
$feindura->titleShowPageDate =      true;
$feindura->titlePageDateSeparator = ' - ';
$feindura->titleShowCategory =      false;
$feindura->titleCategorySeparator = ' -> '; // has no effect, because $titleShowCategory = FALSE

$feindura->thumbnailAlign =         'left';
$feindura->thumbnailId =            'thumbId';
$feindura->thumbnailClass =         'thumbCLass';
$feindura->thumbnailAttributes =    'test="exampleAttribute1" onclick="exampleAttribute2"';
$feindura->thumbnailBefore =        false;
$feindura->thumbnailAfter =         false;


// finally get the pages from the category with ID "1" and "2" using the above set properties
// the page content will be shorten to "200" characters
$pages = $feindura->listPages('category',array(1,2),200,true,true);

// displays the pages
foreach($pages as $page) {
  echo $page['title'];
  echo $page['thumbnail'];
  echo $page['content'];
  echo '<br>-----------------------<br>\n';
}


                               *** RESULT ***
--------------------------------------------------------------------------------


<a href="?category=1&amp;page=2" title="2010-12-31 - Example Page 2">
2010-12-31 - Example...
</a>
<h2>Example Headline 2</h2>
<p>Lorem ipsum dolor sit amet, consetetur sadipscing dolores et ea rebum.
Stet clita kasd gubergren, no sea takimata sanctus.</p>
<a href="?category=1&amp;page=2">mehr</a>

<br>-----------------------<br>

<a href="?category=1&amp;page=3" title="2010-12-31 - Example Page 2">
2010-12-31 - Example...
</a>
<h2>Another Example Headline</h2>
<p>Lorem ipsum dolor sit amet, consetetur sadipscing dolores et ea rebum.</p>
<h2>And one more Example Headline</h2>
<p>Stet clita kasd gubergren, no sea takimata sanctus est...</p>
<a href="?category=1&amp;page=3">mehr</a>

<br>-----------------------<br>

<a href="?category=2&amp;page=1" title="Example Page 1">
Example Page 1
</a>
<img src="/path/thumb_page3.png" class="feinduraThumbnail" alt="Thumbnail" title="Example Page 1" id="thumbId"
class="thumbCLass" test="exampleAttribute1" onclick="exampleAttribute2" style="float:left;">
<p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor
invidunt ut labore et dolore magna aliquyam erat, ur sadipscing elitr,
Stet clita kasd...</p>
<a href="?category=2&amp;page=1">mehr</a>

<br>-----------------------<br>

?>