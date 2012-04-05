<?php
/* If you call this method and you give as $plugin parameter only a string with a pluginName,
it returns only a string with this plugin content */

$plugins['aPlugin']     = '<p>HTML code created by the Plugin</p>
                             <span>What it is depends on the plugin</span>';
$plugins['anotherPlugin'] = '<p>Another plugin resulting HTML code</p>';
...

return $plugins;
  
?>