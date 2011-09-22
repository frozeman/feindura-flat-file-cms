<?php
/* pageRating plugin */
/*
 * feindura - Flat File Content Management System
 * Copyright (C) Fabian Vogelsteller [frozeman.de]
 *
 * This program is free software;
 * you can redistribute it and/or modify it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY;
 * without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 * See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with this program;
 * if not,see <http://www.gnu.org/licenses/>.
 */
/** 
 * The include file for the pageRating plugin
 * 
 * See the README.md for more.
 * 
 * The following variables are available in this script when it gets included by the {@link Feindura::showPlugins()} method:
 *     - $pluginConfig -> contains the changed settings from the "config.php" from this plugin
 *     - $pluginName -> the folder name of this plugin
 *     - $pageContent -> the pageContent array of the page which has this plugin activated
 *     - and all other variables which are available in the {@link feindura} class (use "$this->..")
 * 
 * This file MUST RETURN the plugin ready to display in a HTML-page
 * 
 * For Example
 * <code>
 * $plugin = '<p>Plugin HTML</p>';
 * 
 * return $plugin;
 * </code>
 * 
 * @package [Plugins]
 * @subpackage pageRating
 * 
 * @version 0.1
 * 
 * @author Fabian Vogelsteller <fabian@feindura.org>
 * @copyright Fabian Vogelsteller
 * @license http://www.gnu.org/licenses GNU General Public License version 3
 * 
 */
//unset($_SESSION['plugin_pageRating'][$pageContent['id']]['rated']);
// var
$filePath = str_replace('\\','/',dirname(__FILE__)); // replace this on windows servers
$filePath = str_replace($_SERVER["DOCUMENT_ROOT"],'',$filePath);
$_SESSION['plugin_pageRating'][$pageContent['id']]['rated'] = ($_SESSION['plugin_pageRating'][$pageContent['id']]['rated'] === 'true') ? 'true' : 'false';
$plugin = '';

// -> add mootools if user is not logged into backend
echo '<script type="text/javascript">
  /* <![CDATA[ */
  if(!window.MooTools) {
    document.write(unescape(\'%3Cscript src="'.$this->adminConfig['basePath'].'library/thirdparty/javascripts/mootools-core-1.3.2.js"%3E%3C/script%3E\'));
  }
  /* ]]> */
</script>';

$alreadyRatedClass = ($_SESSION['plugin_pageRating'][$pageContent['id']]['rated'] === 'false') ? ' unrated': '';

$plugin .= '<div class="plugin_pageRating page'.$pageContent['id'].$alreadyRatedClass.'" data-pageRating="'.$pageContent['id'].' '.$pageContent['category'].'" title="'.$pageContent['plugins']['pageRating']['value'].'">';
$plugin .= '<ul>';
for($i = 1; $i <= 5; $i++) {
  $filled = ($i <= $pageContent['plugins']['pageRating']['value']) ? ' filled' : '' ;
  $plugin .= '<li><a href="#" class="star'.$filled.'" data-pageRating="'.$i.'"></a></li>';
}
$plugin .= '</ul>';
$plugin .= '</div>';

// ->> add script for the pageRating, ONLY when not a robot
if(StatisticFunctions::isRobot() === false) {
$plugin .= '<script type="text/javascript">
  /* <![CDATA[ */
  
  var opacLevel = 0.7;
  
  // set already rated to opacity -> opacLevel
  if('.$_SESSION['plugin_pageRating'][$pageContent['id']]['rated'].') {
    $$("div.plugin_pageRating.page'.$pageContent['id'].' a").set("opacity",opacLevel).removeClass("unrated");
  }
  
  $$("div.plugin_pageRating.unrated.page'.$pageContent['id'].' a").addEvent("click",function(e){
    e.stop();
    // var
    var plugin_pageRating = this.getParent("div.plugin_pageRating");
    plugin_pageRating.set("tween",{duration:300});
    var pageIds = plugin_pageRating.getProperty("data-pageRating").split(" ");
    if(!plugin_pageRating.hasClass("unrated"))
      return;
    
    // save the rating
    new Request({
      url: "'.$filePath.'/saveRating.php",
      data: "page=" + pageIds[0] + "&category=" + pageIds[1] + "&rating="+this.getProperty("data-pageRating"),
      onSuccess: function(rating) {
        if(rating && !isNaN(rating)) {
          plugin_pageRating.fade(0).get("tween").chain(function(){
             var count = 1;
            // change the stars
            $$("div.plugin_pageRating a").each(function(link){
              if(count <= rating)
                link.addClass("filled");
              else
                link.removeClass("filled");
              count++;
            });
            // set rating in title
            plugin_pageRating.setProperty("title",rating);
            plugin_pageRating.store("tip:title",rating);
            // remove unrated class
            plugin_pageRating.fade(opacLevel).removeClass("unrated");
            plugin_pageRating.fireEvent("rated",rating);
          });
        // display notice, when rate twice
        } else {
          plugin_pageRating.set("opacity",opacLevel).removeClass("unrated");
        }
      }
    }).send();

    
  });
  /* ]]> */
  </script>';
}

// RETURN the plugin
// *****************
return $plugin;

?>