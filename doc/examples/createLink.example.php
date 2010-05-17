<?php
/*                               *** CODE *** 
--------------------------------------------------------------------------------
This example uses all possible properties.
It's also goes much more simple: just call createLink(1) without setting properties
and you have a simple link with the page title.
*/

require('cms/feindura.include.php');

// creates a new feindura instance
$myCms = new feinduraPages();

// set link properties
$myCms->linkLength =                  10; // shortens the page title in the link
$myCms->linkId =                      'exampleId';
$myCms->linkClass   =                 'exampleClass';
$myCms->linkAttributes =              'test="exampleAttribute1" onclick="exampleAttribute2"';
$myCms->linkBefore =                  'text before link ';
$myCms->linkAfter =                   ' text after link';
$myCms->linkTextBefore =              'text before ';
$myCms->linkTextAfter =               ' text after';
$myCms->linkShowThumbnail =           true;
$myCms->linkShowThumbnailAfterText =  false;
$myCms->linkShowPageDate =            true;
$myCms->linkShowCategory =            true;
$myCms->linkCategorySeperator =       ' -> ';

// set thumbnail properties
$myCms->thumbnailAlign =              'left';
$myCms->thumbnailId =                 'thumbId';
$myCms->thumbnailClass =              'thumbClass';
$myCms->thumbnailAttributes =         'test="thumbnailAttr1" onclick="thumbnailAttr2"';
$myCms->thumbnailBefore =             'text before thumbnail ';
$myCms->thumbnailAfter =              ' text after thumbnail';


// finally create the link from the page with ID "1" using the above set link properties
$link = $myCms->createLink(1);

// displays the link
echo $link;


/*                              *** RESULT *** 
--------------------------------------------------------------------------------
*/

text before link <a href="?category=1&amp;page=1" title="Example Category: 2010-12-31 Example Page"
id="exampleId" class="exampleClass" test="exampleAttribute1" onclick="exampleAttribute2">
text before thumbnail <img src="/path/thumb_cat1page1.png" alt="Thumbnail" title="Example Page"
id="thumbId" class="thumbClass" test="thumbnailAttr1" onclick="thumbnailAttr2" style="float:left;" />
text after thumbnail
text before Example Category: 2010-12-31 Example.. text after
</a> text after link

?>