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

// set properties
$feindura->xHtml =                  true;

$feindura->showErrors =              true;
$feindura->errorTag =               'span';
$feindura->errorId =                'errorId';
$feindura->errorClass =             'errorClass';
$feindura->errorAttributes =        'test="exampleAttribute1" onclick="exampleAttribute2"';

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


// finally return the pages from the category with ID "1" and "2" using the above set properties
// the page content will be shorten to "200" characters
$pages = $feindura->listPages('category',array(1,2),200,true,true);

// displays the pages (the "\n" creates a line break for a better look)
foreach($pages as $page) {
  echo $page['title']."\n\n";
  echo $page['thumbnail']."\n";
  echo $page['content']."\n<br />-----------------------<br />\n";
}


/*                              *** RESULT with page *** 
--------------------------------------------------------------------------------
*/

<a href="?category=1&amp;page=2" title="2010-12-31 - Example Page 2">
2010-12-31 - Example...
</a>
<h2>Example Headline</h2>
<p>Lorem ipsum dolor sit amet, consetetur sadipscing dolores et ea rebum.
Stet clita kasd gubergren, no sea takimata sanctus.</p>
<a href="?category=1&amp;page=2">mehr</a>

<br />-----------------------<br />

<a href="?category=1&amp;page=3" title="2010-12-31 - Example Page 2">
2010-12-31 - Example...
</a>
<h2>Another Example Headline</h2>
<p>Lorem ipsum dolor sit amet, consetetur sadipscing dolores et ea rebum.</p>
<h2>And one more Example Headline</h2>
<p>Stet clita kasd gubergren, no sea takimata sanctus est...</p>
<a href="?category=1&amp;page=3">mehr</a>

<br />-----------------------<br />

<a href="?category=2&amp;page=1" title="Example Page 1">
Example Page 1
</a>
<img src="/path/thumb_page3.png" alt="Thumbnail" title="Example Page 1" id="thumbId"
class="thumbCLass" test="exampleAttribute1" onclick="exampleAttribute2" style="float:left;" />
<p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor
invidunt ut labore et dolore magna aliquyam erat, ur sadipscing elitr,
Stet clita kasd...</p>
<a href="?category=2&amp;page=1">mehr</a>

<br />-----------------------<br />

?>