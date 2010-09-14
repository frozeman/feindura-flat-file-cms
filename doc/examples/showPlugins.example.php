<?php
/*                               *** CODE *** 
--------------------------------------------------------------------------------
This example gets all plugins which are activated in the page with ID "2".
You can also request only single plugins, it will then only return a string, with the HTML of the plugin.
*/

// a session will be started in the "feindura.include.php",
// therefor you have to include this file before the header of the HTML page is sent,
// which means before any HTML Tag.
require('cms/feindura.include.php');

// creates a new feindura instance
$myCms = new feindura();

// get the all plugins, which are activated in the page with ID "2"
$plugins = $myCms->showPlugins(true,2);

// displays the page (the "\n" creates a line break for a better look)
foreach($plugins as $plugin) {
  echo $plugin;
}


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