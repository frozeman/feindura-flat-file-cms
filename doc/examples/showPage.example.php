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

// get the page, which is currently selected, if not page is selected it uses the $feindura->startPage property
$currentPage = $feindura->showPage();

// displays the page
echo '<h1>'.$page['title'].'</h1>';
echo $page['content'];


                               *** RESULT *** 
--------------------------------------------------------------------------------

<h1>Example Page 1</h1>

<p>Lorem ipsum dolor sit amet, consetetur sadipscing dolores et ea rebum.
Stet clita kasd gubergren, no sea takimata sanctus.</p>


/*                               *** EXTENDED EXAMPLE *** 
--------------------------------------------------------------------------------
This example uses all possible properties.
It's also works much more simple: just call showPage() without setting properties
and it shows the current page given by the $_GET variable.
*/

// add before any HTML Tag. (eg. before the <!doctype html>)
require('cms/feindura.include.php');

// creates a new Feindura instance
$feindura = new Feindura();

// set properties
$feindura->xHtml =                  true;

$feindura->titleLength =            20;
$feindura->titleAsLink =            true;
$feindura->titleShowPageDate =      true;
$feindura->titlePageDateSeparator = ' - ';
$feindura->titleShowCategory =      false; // would have no effect, because page with ID "1" has no category
$feindura->titleCategorySeparator = ' -> '; // would have no effect, because $titleShowCategory = FALSE

$feindura->thumbnailAlign =         'left';
$feindura->thumbnailId =            'thumbId';
$feindura->thumbnailClass =         'thumbCLass';
$feindura->thumbnailAttributes =    'test="exampleAttribute1" onclick="exampleAttribute2"';
$feindura->thumbnailBefore =        false;
$feindura->thumbnailAfter =         false;

$feindura->showErrors =              true;
$feindura->errorTag =               'div.alertClass';


// finally, get the page, with ID "1", using the above set properties
$page = $feindura->showPage(1);

// displays the page (the "\n" creates a line break for a better look)
echo $page['title'];
echo $page['thumbnail'];
echo $page['content'];


                               *** RESULT *** 
--------------------------------------------------------------------------------

<a href="?page=1" title="2010-12-31 - Example Page">
2010-12-31 - Example...
</a>
<img src="/path/thumb_page3.png" class="feinduraThumbnail" alt="Thumbnail" title="Example Page 1" id="thumbId"
class="thumbCLass" test="exampleAttribute1" onclick="exampleAttribute2" style="float:left;">

<h2>Example Headline</h2>
<p>Lorem ipsum dolor sit amet, consetetur sadipscing dolores et ea rebum.
Stet clita kasd gubergren, no sea takimata sanctus.</p>
<p>Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.
Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam...</p>


                          *** RESULT with error *** 
--------------------------------------------------------------------------------


<div class="alertClass">
The requested page is deactivated.
</div>

?>