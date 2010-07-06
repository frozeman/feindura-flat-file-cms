<?php
/*                               *** CODE *** 
--------------------------------------------------------------------------------
This example uses all possible properties.
It's also works much more simple: just call createMenu('category',1)
and you have a simple array with links of the pages from this category.
*/

require('cms/feindura.include.php');

// the feindura.include.php has to be included BEFORE the header of the HTML page is sent
// because a session is startet in this file
$myCms = new feindura();

// set menu properties
$myCms->menuId =                      'menuId';
$myCms->menuClass =                   'menuClass';
$myCms->menuAttributes =              'test="menuAttribute1" onclick="menuAttribute2"';

// set link properties
$myCms->linkLength =                  50; // shortens the page title in the link
$myCms->linkId =                      false; // set no id otherwise it will be repeated
$myCms->linkClass   =                 'linkClass';
$myCms->linkAttributes =              'test="linkAttribute1" onclick="linkAttribute2"';
$myCms->linkBefore =                  'text before link ';
$myCms->linkAfter =                   ' text after link';
$myCms->linkBeforeText =              'text before ';
$myCms->linkAfterText =               ' text after';
$myCms->linkShowThumbnail =           true;
$myCms->linkShowThumbnailAfterText =  false;
$myCms->linkShowPageDate =            true;
$myCms->linkShowCategory =            true;
$myCms->linkCategorySeperator =       ' -> ';

// set thumbnail properties
$myCms->thumbnailAlign =              'left';
$myCms->thumbnailId =                 false; // set no id otherwise it will be repeated
$myCms->thumbnailClass =              'thumbnailClass';
$myCms->thumbnailAttributes =         'test="thumbnailAttribute1" onclick="thumbnailAttribute2"';
$myCms->thumbnailBefore =             'text before thumbnail ';
$myCms->thumbnailAfter =              ' text after thumbnail';

// finally create the menu from the category with ID "1" using the above set properties
$menu = $myCms->createMenu('category',1,'table',true,2,true);

// displays the menu
foreach($menu as $link) {
  echo $link;
}



/*                              *** RESULT *** 
--------------------------------------------------------------------------------
*/

<table id="menuId" class="menuClass" test="menuAttribute1" onclick="menuAttribute2">
<tr><td>
text before link <a href="?category=1&amp;page=1" title="Example Category: 2010-12-31 Example Page 1"
class="linkClass" test="linkAttribute1" onclick="linkAttribute2">
text before thumbnail
<img src="/path/thumb_cat1page1.png" alt="Thumbnail" title="Example Page 1"
class="thumbnailClass" test="thumbnailAttribute1" onclick="thumbnailAttribute2" style="float:left;" />
text after thumbnail
text before Example Category: 2010-12-31 Example... text after
</a> text after link
</td><td>
text before link <a href="?category=1&amp;page=2" title="Example Category: 2010-11-25 Example Page 2"
class="linkClass" test="linkAttribute1" onclick="linkAttribute2">
text before thumbnail
<img src="/path/thumb_cat1page2.png" alt="Thumbnail" title="Example Page 2"
class="thumbnailClass" test="thumbnailAttribute1" onclick="thumbnailAttribute2" style="float:left;" />
text after thumbnail
text before Example Category: 2010-11-25 Example... text after
</a> text after link
</td>
</tr><tr>
<td>
text before link <a href="?category=1&amp;page=3" title="Example Category: 2010-10-15 Example Page 3"
class="linkClass" test="linkAttribute1" onclick="linkAttribute2">
text before thumbnail
<img src="/path/thumb_cat1page3.png" alt="Thumbnail" title="Example Page 3"
class="thumbnailClass" test="thumbnailAttribute1" onclick="thumbnailAttribute2" style="float:left;" />
text after thumbnail
text before Example Category: 2010-10-15 Example... text after
</a> text after link
</td><td>
text before link <a href="?category=1&amp;page=4" title="Example Category: 2010-09-05 Example Page 4"
class="linkClass" test="linkAttribute1" onclick="linkAttribute2">
text before thumbnail
<img src="/path/thumb_cat1page4.png" alt="Thumbnail" title="Example Page 4"
class="thumbnailClass" test="thumbnailAttribute1" onclick="thumbnailAttribute2" style="float:left;" />
text after thumbnail
text before Example Category: 2010-09-05 Example... text after
</a> text after link
</td></tr>
</table>

?>