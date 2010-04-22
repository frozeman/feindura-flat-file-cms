<?php

require('cms/feindura.include.php');

// creates feindura instance
$myCms = new feindura();

// sets link attributes
$myCms->linkId = 'exampleId';
$myCms->linkClass   = 'exampleClass';
$myCms->linkAttributes = 'test="exampleAttribute1" onclick="exampleAttribute2"';
$myCms->linkBefore = 'text before link ';
$myCms->linkAfter = ' text after link';
$myCms->linkTextBefore = 'text before ';
$myCms->linkTextAfter = ' text after';
$myCms->linkThumbnail = true;
$myCms->linkThumbnailAfterText = false;
$myCms->linkLength = 10;
$myCms->linkShowCategory = true;
$myCms->linkCategorySpacer = ' -> ';
$myCms->linkShowDate = true;


// create link using the above set link attributes
echo $myCms->createLink();

/* RESULT
* 
* text before link 
* <a href="index.php?category=1&amp;page=2" id="exampleId" class="exampleClass" test="exampleAttribute1" onclick="exampleAttribute2">
* text before 
* <span title="Example Category: 12.12.2010 Example Page">
* Example Category: 12.12.2010 Example..
* </span>
* text after
* </a>
* text after link
*
*/

?>