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

// creates a new Feindura instance
$feindura = new Feindura();

?>
<!DOCTYPE html>
<html>
...

<?php

// get the all plugins from the page with ID "2"
$plugins = $feindura->showPlugins(true,2);
// you could also call
// $plugins = $feindura->showPlugins('imageGallery');
// it would get the imageGallery plugin of the current page

// displays the page (the "\n" creates a line break for a better look)
foreach($plugins as $plugin) {
  echo $plugin;
  echo '------';
}


                               *** RESULT *** 
--------------------------------------------------------------------------------

<p>HTML created by the Plugin</p>
<span>What it is depends on the plugin :-)</span>
-----
<h1>Another plugin which follows the first one</h1>
<p>You can also call specific plugins directly. To do that
give it the plugin name, instead of "TRUE".</p>
-----

?>