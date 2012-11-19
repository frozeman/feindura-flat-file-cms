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

// create a menu from the category with ID "1"
$menu = $feindura->createMenu('category',1,'ul.myNav');

// displays the menu
foreach($menu as $item) {
  echo $item['menuItem'];
}

                               *** RESULT *** 
--------------------------------------------------------------------------------

<ul class="myNav">
  <li><a href="?category=1&amp;page=1" title="Example Page 1">Example Page 1</a></li>
  <li><a href="?category=1&amp;page=2" title="Example Page 2">Example Page 2</a></li>
</ul>


/*                               *** EXTENDED EXAMPLE *** 
--------------------------------------------------------------------------------
This example uses all possible properties.
It's also works much more simple: just call createMenu('category',1)
and you have a simple array with links of the pages from this category.
*/

// add before any HTML Tag. (eg. before the <!doctype html>)
require('cms/feindura.include.php');

// creates a new Feindura instance
$feindura = new Feindura();

?>
<!DOCTYPE html>
<html>
...

<?php

// set menu properties
$feindura->menuShowAllPages           = true; // will overwrite the pages "show in menu" setting
$feindura->menuId                     = 'menuId';
$feindura->menuClass                  = 'menuClass';
$feindura->menuAttributes             = 'test="menuAttribute1" onclick="menuAttribute2"';

// set link properties
$feindura->linkLength                 = 20; // shortens the page title in the link
$feindura->linkId                     = false; // set no id otherwise it will be repeated
$feindura->linkClass                  = 'linkClass';
$feindura->linkAttributes             = 'test="linkAttribute1" onclick="linkAttribute2"';
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
$feindura->thumbnailId                = false; // set no id otherwise it will be repeated
$feindura->thumbnailClass             = 'thumbnailClass';
$feindura->thumbnailAttributes        = 'test="thumbnailAttribute1" onclick="thumbnailAttribute2"';
$feindura->thumbnailBefore            = 'text before thumbnail ';
$feindura->thumbnailAfter             = ' text after thumbnail';

// finally create the menu from the category with ID "1" using the above set properties
$menu = $feindura->createMenu('category',1,'table',true,2);

// displays the menu
foreach($menu as $item) {
  echo $item['menuItem'];
}



                               *** RESULT *** 
--------------------------------------------------------------------------------

<table id="menuId" class="menuClass" test="menuAttribute1" onclick="menuAttribute2">
  <tbody>
    <tr><td>
      text before link <a href="?category=1&amp;page=1" title="Example Category -> 2010-12-31 - Example Page 1"
      class="linkClass" test="linkAttribute1" onclick="linkAttribute2">
      text before thumbnail
      <img src="/path/thumb_page1.png" class="feinduraThumbnail" alt="Thumbnail" title="Example Page 1"
      class="thumbnailClass" test="thumbnailAttribute1" onclick="thumbnailAttribute2" style="float:left;">
      text after thumbnail
      text before Example Category -> 2010-12-31 - Example ... text after
      </a> text after link
    </td><td>
      text before link <a href="?category=1&amp;page=2" title="Example Category -> 2010-11-25 - Example Page 2"
      class="linkClass" test="linkAttribute1" onclick="linkAttribute2">
      text before thumbnail
      <img src="/path/thumb_page2.png" class="feinduraThumbnail" alt="Thumbnail" title="Example Page 2"
      class="thumbnailClass" test="thumbnailAttribute1" onclick="thumbnailAttribute2" style="float:left;">
      text after thumbnail
      text before Example Category -> 2010-11-25 - Example ... text after
      </a> text after link
    </td>
    </tr><tr>
    <td>
      text before link <a href="?category=1&amp;page=3" title="Example Category -> 2010-10-15 - Example Page 3"
      class="linkClass" test="linkAttribute1" onclick="linkAttribute2">
      text before thumbnail
      <img src="/path/thumb_page3.png" class="feinduraThumbnail" alt="Thumbnail" title="Example Page 3"
      class="thumbnailClass" test="thumbnailAttribute1" onclick="thumbnailAttribute2" style="float:left;">
      text after thumbnail
      text before Example Category -> 2010-10-15 - Example ... text after
      </a> text after link
    </td><td>
      text before link <a href="?category=1&amp;page=4" title="Example Category -> 2010-09-05 - Example Page 4"
      class="linkClass" test="linkAttribute1" onclick="linkAttribute2">
      text before thumbnail
      <img src="/path/thumb_page4.png" class="feinduraThumbnail" alt="Thumbnail" title="Example Page 4"
      class="thumbnailClass" test="thumbnailAttribute1" onclick="thumbnailAttribute2" style="float:left;">
      text after thumbnail
      text before Example Category -> 2010-09-05 - Example ... text after
      </a> text after link
    </td></tr>
  </tbody>
</table>

?>