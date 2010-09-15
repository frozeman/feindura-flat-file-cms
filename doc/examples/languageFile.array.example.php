<?php
/* If you call this method and you give as $plugin parameter only a string with a pluginName,
it returns only a string with this plugin content */

$plugins['onePlugin'] = '<p>HTML created by the Plugin</p>
                         <span>What it is depends on the plugin :-)</span>';
$plugins['anotherPlugin'] = '<h1>Another plugin which follows the first one</h1>
                             <p>You can alsocall specific plugins directly
                             when you give the plugin name instead of "true",
                             like in this example</p>';
...

return $plugins;
  
?>