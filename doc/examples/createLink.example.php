<!-- *** CODE *** -->
<?php

require('cms/feindura.include.php');

// creates a new feindura instance
$myCms = new feinduraPages();

// sets link attributes
$myCms->linkLength =                  10;
$myCms->linkId =                      'exampleId';
$myCms->linkClass   =                 'exampleClass';
$myCms->linkAttributes =              'test="exampleAttribute1" onclick="exampleAttribute2"';
$myCms->linkBefore =	                'text before link ';
$myCms->linkAfter =	                  ' text after link';
$myCms->linkTextBefore =              'text before ';
$myCms->linkTextAfter =	              ' text after';
$myCms->linkShowThumbnail =           true;
$myCms->linkShowThumbnailAfterText =  false;
$myCms->linkShowPageDate =            true;
$myCms->linkShowCategory =            true;
$myCms->linkCategorySpacer =          ' -> ';


// create link of the page with ID "1" using the above set link properties
echo $myCms->createLink(1);

?>

<!-- *** RESULT *** -->

text before link 
<a href="index.php?category=1&amp;page=1" id="exampleId" class="exampleClass" test="exampleAttribute1" onclick="exampleAttribute2">
text before 
<span title="Example Category: 12.12.2010 Example Page">
Example Category: 12.12.2010 Example..
</span>
text after
</a>
text after link
