<?php
/*                               *** CODE *** 
--------------------------------------------------------------------------------
This example uses all possible properties.
It's also works much more simple: just call showPage() without setting properties
and it shows the current page given by the $_GET variable.
*/

// a session will be started in the "feindura.include.php",
// therefor you have to include this file before the header of the HTML page is sent,
// which means before any HTML Tag.
require('cms/feindura.include.php');

// creates a new Feindura instance
$myCms = new Feindura();

// set properties
$myCms->xHtml =                  true;

$myCms->showErrors =              true;
$myCms->errorTag =               'span';
$myCms->errorId =                'errorId';
$myCms->errorClass =             'errorClass';
$myCms->errorAttributes =        'test="exampleAttribute1" onclick="exampleAttribute2"';

$myCms->titleLength =            20;
$myCms->titleAsLink =            true;
$myCms->titleShowPageDate =      true;
$myCms->titleShowCategory =      false; // has no effect, because page with ID "1" has no category
$myCms->titleCategorySeperator = ' -> ';

$myCms->thumbnailAlign =         'left';
$myCms->thumbnailId =            'thumbId';
$myCms->thumbnailClass =         'thumbCLass';
$myCms->thumbnailAttributes =    'test="exampleAttribute1" onclick="exampleAttribute2"';
$myCms->thumbnailBefore =        false;
$myCms->thumbnailAfter =         false;


// finally, return the page, with ID "1", using the above set properties
$page = $myCms->showPage(1,100,true,true);

// displays the page (the "\n" creates a line break for a better look)
echo $page['title']."\n";
echo $page['thumbnail']."\n";
echo $page['content'];


/*                              *** RESULT with page *** 
--------------------------------------------------------------------------------
*/

<a href="?page=1" title="2010-12-31 Example Page">
2010-12-31 Example...
</a>
<img src="/path/thumb_page3.png" alt="Thumbnail" title="Example Page 1" id="thumbId"
class="thumbCLass" test="exampleAttribute1" onclick="exampleAttribute2" style="float:left;" />

<h2>Example Headline</h2>
<p>Lorem ipsum dolor sit amet, consetetur sadipscing dolores et ea rebum.
Stet clita kasd gubergren, no sea takimata sanctus.</p>
<p>Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.
Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam...</p>
<a href="?page=1">mehr</a>


/*                              *** RESULT with error *** 
--------------------------------------------------------------------------------
*/

<span id="errorId" class="errorClass" test="exampleAttribute1" onclick="exampleAttribute2">
The requested page is currently not available.
</span>

?>