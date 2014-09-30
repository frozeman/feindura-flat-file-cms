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
 *
 * @package [Plugins]
 * @subpackage pageRating
 *
 * @author Fabian Vogelsteller <fabian@feindura.org>
 * @copyright Fabian Vogelsteller
 * @license http://www.gnu.org/licenses GNU General Public License version 3
 *
 */

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

echo '  <ul id="pageRating'.$uniqueId.'" class="'.$alreadyRatedClass.'" data-pageRating="'.$pageContent['id'].' '.$pageContent['category'].'" title="'.$pluginConfig['valueNumber'].'">';
for($i = 1; $i <= 5; $i++) {
  $filled = ($i <= $pluginConfig['valueNumber']) ? ' filled' : '' ;
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

  // var
  var feinduraPlugin_pageRating = document.id("pageRating'.$uniqueId.'");
  var pageIds = feinduraPlugin_pageRating.getProperty("data-pageRating").split(" ");
  feinduraPlugin_pageRating.set("tween",{duration:300});

  feinduraPlugin_pageRating.getElements("a").addEvent("click",function(e){
    e.stop();

    if(!feinduraPlugin_pageRating.hasClass("unrated"))
      return;

    // save the rating
    new Request({
      url: "'.$pluginBaseURL.'saveRating.php",
      link: "cancel",
      data: "page=" + pageIds[0] + "&category=" + pageIds[1] + "&pluginNumber="+'.$pluginNumber.'+"&rating="+this.getProperty("data-pageRating"),
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