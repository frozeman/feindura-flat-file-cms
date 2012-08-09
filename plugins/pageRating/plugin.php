<?php
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
 * The plugin file
 *
 * See the README.md for more.
 *
 * The following variables are available in this script when it gets included by the {@link Feindura::showPlugins()} method:
 *     - $feindura                  -> the current {@link Feindura} class instance with all its methods (use "$feindura->..")
 *     - $feinduraBaseURL           -> the base url of the feindura folder, e.g. "http://mysite.com/cms/"
 *     - $feinduraBasePath          -> the base path of the feindura folder, e.g. "/cms/". Be aware that this is a file system path and could differ from an URI path.
 *     - $pluginBaseURL             -> the base url of this plugins folder, e.g. "http://mysite.com/cms/plugins/examplePlugin/"
 *     - $pluginBasePath            -> the base path of this plugins folder, e.g. "/cms/plugins/examplePlugin/". Be aware that this is a file system path and could differ from an URI path.
 *     - $pluginConfig              -> contains the changed settings from the "config.php" from this plugin
 *     - $pluginName                -> the folder name of this plugin
 *     - $pluginNumber              -> the number of the plugin (to differ multiple plugins on the same page)
 *     - $pageContent               -> the pageContent array of the page which contains this plugin
 *     - the GeneralFunctions class -> for advanced methods. It's a static class so use "GeneralFunctions::exampleMethod(..);"
 *
 * Example plugin:
 * <code>
 * <?php
 * // Add the stylesheet files of this plugin to the current page
 * echo $feindura->addPluginStylesheets($pluginBasePath);
 *
 * echo '<p>Plugin HTML</p>';
 *
 * ?>
 * </code>
 *
 * @package [Plugins]
 * @subpackage pageRating
 *
 * @author Fabian Vogelsteller <fabian@feindura.org>
 * @copyright Fabian Vogelsteller
 * @license http://www.gnu.org/licenses GNU General Public License version 3
 *
 */

// Add the stylesheet files of this plugin to the current page (these CSS files can be anywhere in this plugin folder or subfolders)
echo $feindura->addPluginStylesheets($pluginBasePath);

// unset($_SESSION['feinduraPlugin_pageRating'][$pageContent['id']]['rated']);

// vars
$uniqueId = uniqid();
$_SESSION['feinduraPlugin_pageRating'][$pageContent['id']]['rated'] = ($_SESSION['feinduraPlugin_pageRating'][$pageContent['id']]['rated'] === 'true') ? 'true' : 'false';

// -> add mootools if user is not logged into backend
echo '<script type="text/javascript">
  /* <![CDATA[ */
  if(!window.MooTools) {
    document.write(unescape(\'%3Cscript src="'.$feinduraBaseURL.'library/thirdparty/javascripts/mootools-core-1.4.5.js"%3E%3C/script%3E\'));
  }
  /* ]]> */
</script>';

$alreadyRatedClass = ($_SESSION['feinduraPlugin_pageRating'][$pageContent['id']]['rated'] === 'false') ? ' unrated': '';

echo '  <ul id="pageRating'.$uniqueId.'" class="'.$alreadyRatedClass.'" data-pageRating="'.$pageContent['id'].' '.$pageContent['category'].'" title="'.$pageContent['plugins']['pageRating']['valueNumber'].'">';
for($i = 1; $i <= 5; $i++) {
  $filled = ($i <= $pageContent['plugins']['pageRating']['valueNumber']) ? ' filled' : '' ;
  echo '    <li><a href="#" class="star'.$filled.'" data-pageRating="'.$i.'" onclick="return false;"></a></li>';
}
echo '  </ul>';

// ->> add script for the pageRating, ONLY when not a robot
if(StatisticFunctions::isRobot() === false) {
echo '<script type="text/javascript">
  /* <![CDATA[ */

  var opacLevel = 0.7;

  // set already rated to opacity -> opacLevel
  if('.$_SESSION['feinduraPlugin_pageRating'][$pageContent['id']]['rated'].') {
    $$("#pageRating'.$uniqueId.' a").setStyle("opacity",opacLevel).removeClass("unrated");
  }

  $$("#pageRating'.$uniqueId.' a").addEvent("click",function(e){
    e.stop();

    // var
    var feinduraPlugin_pageRating = $("pageRating'.$uniqueId.'");
    var pageIds = feinduraPlugin_pageRating.getProperty("data-pageRating").split(" ");
    if(!feinduraPlugin_pageRating.hasClass("unrated"))
      return;

    // save the rating
    new Request({
      url: "'.$pluginBaseURL.'saveRating.php",
      data: "page=" + pageIds[0] + "&category=" + pageIds[1] + "&pluginNumber="+'.$pluginNumber.'+"&rating="+this.getProperty("data-pageRating"),
      onRequest: function() {
        feinduraPlugin_pageRating.set("tween",{duration:300});
      },
      onSuccess: function(rating) {
        if(rating && !isNaN(rating)) {
          feinduraPlugin_pageRating.fade(0).get("tween").chain(function(){
             var count = 1;
            // change the stars
            $$("#pageRating'.$uniqueId.' a").each(function(link){
              if(count <= rating)
                link.addClass("filled");
              else
                link.removeClass("filled");
              count++;
            });
            // set rating in title
            feinduraPlugin_pageRating.setProperty("title",rating);
            feinduraPlugin_pageRating.store("tip:title",rating);
            // remove unrated class
            feinduraPlugin_pageRating.fade(opacLevel).removeClass("unrated");
            feinduraPlugin_pageRating.fireEvent("rated",rating);
          });
        // display notice, when rate twice
        } else {
          feinduraPlugin_pageRating.setStyle("opacity",opacLevel).removeClass("unrated");
        }
      }
    }).send();


  });
  /* ]]> */
  </script>';
}


?>