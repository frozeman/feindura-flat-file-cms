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

// set link properties
$feindura->linkLength                 = 20; // shortens the page title in the link
$feindura->linkId                     = 'exampleId';
$feindura->linkClass                  = 'exampleClass';
$feindura->linkAttributes             = 'test="exampleAttribute1" onclick="exampleAttribute2"';
$feindura->linkBefore                 = 'text before link ';
$feindura->linkAfter                  = ' text after link';
$feindura->linkBeforeText             = 'text before ';
$feindura->linkAfterText              = ' text after';
$feindura->linkShowThumbnail          = true;
$feindura->linkShowThumbnailAfterText = false;
$feindura->linkShowPageDate           = true;
$feindura->linkPageDateSeparator      = ' - ';
$feindura->linkShowCategory           = true;
$feindura->linkCategorySeparator      = ' -> ';

// set thumbnail properties
$feindura->thumbnailAlign             = 'left';
$feindura->thumbnailId                = 'thumbId';
$feindura->thumbnailClass             = 'thumbClass';
$feindura->thumbnailAttributes        = 'test="thumbnailAttr1" onclick="thumbnailAttr2"';
$feindura->thumbnailBefore            = 'text before thumbnail ';
$feindura->thumbnailAfter             = ' text after thumbnail';


// finally create the link from the page with ID "1" using the above set link properties
$link = $feindura->createLink(1);

// displays the link
echo $link;


                               *** RESULT *** 
--------------------------------------------------------------------------------

text before link <a href="?category=1&amp;page=1" title="Example Category -> 2010-12-31 - Example Page"
id="exampleId" class="exampleClass" test="exampleAttribute1" onclick="exampleAttribute2">
text before thumbnail <img src="/path/thumb_page1.png" class="feinduraThumbnail" alt="Thumbnail" title="Example Page"
id="thumbId" class="thumbClass" test="thumbnailAttr1" onclick="thumbnailAttr2" style="float:left;">
text after thumbnail
text before Example Category -> 2010-12-31 - Example ... text after
</a> text after link

?>