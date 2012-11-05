<?php
/*
    feindura - Flat File Content Management System
    Copyright (C) Fabian Vogelsteller [frozeman.de]

    This program is free software;
    you can redistribute it and/or modify it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 3 of the License, or (at your option) any later version.

    This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY;
    without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
    See the GNU General Public License for more details.

    You should have received a copy of the GNU General Public License along with this program;
    if not,see <http://www.gnu.org/licenses/>.

* sidebar.loader.php version 0.8
*
* The rightSideBar shows alwyas site or page relevant information.
*/

// PAGES
if(empty($_GET['site']) && !empty($_GET['page']) && is_numeric($_GET['page'])) {

  if(is_numeric($pageContent['id'])) {

    // vars
    $pageStatistics = StatisticFunctions::readPageStatistics($pageContent['id']);

    $firstVisitDate = GeneralFunctions::formatDate($pageStatistics['firstVisit']);
    $firstVisitTime = formatTime($pageStatistics['firstVisit']);
    $lastVisitDate = GeneralFunctions::formatDate($pageStatistics['lastVisit']);
    $lastVisitTime = formatTime($pageStatistics['lastVisit']);

    $visitTimes_max = unserialize($pageStatistics['visitTimeMax']);
    $visitTimes_min = unserialize($pageStatistics['visitTimeMin']);

    if($pageStatistics['firstVisit']) {
    ?>

    <div class="box">
      <h1><img src="library/images/icons/statisticIcon_small.png" alt="icon" width="30" height="27"><?php echo $langFile['EDITOR_pagestatistics_h1']; ?></h1>
      <!-- VISITOR COUNT -->
      <div class="row">
        <div class="span1">
          <strong><?php echo $langFile['STATISTICS_TEXT_VISITORCOUNT']; ?></strong>
        </div>
        <div class="span1">
          <?php echo formatHighNumber($pageStatistics['visitorCount']); ?>
          <a href="#" class="down inBlockSliderLink toolTipRight" style="position:absolute;right: 10px;" data-inBlockSlider="moreStatistics" title="::<?php echo $langFile['BUTTON_MORE']; ?>">&nbsp;</a>
        </div>
      </div>

      <div class="statistics inBlockSlider hidden" data-inBlockSlider="moreStatistics">
        <div class="spacer"></div>
        <!-- FIRST VISIT -->
        <div class="row">
          <div class="span1">
            <strong><?php echo $langFile['STATISTICS_TEXT_FIRSTVISIT']; ?></strong>
          </div>
          <div class="span1">
            <?php echo '<span class="toolTipRight" title="'.$firstVisitTime.'::">'.$firstVisitDate.'</span>'; ?>
          </div>
        </div>
        <!-- LAST VISIT -->
        <div class="row">
          <div class="span1">
            <strong><?php echo $langFile['STATISTICS_TEXT_LASTVISIT']; ?></strong>
          </div>
          <div class="span1">
            <?php echo '<span class="toolTipRight" title="'.$lastVisitTime.'::">'.$lastVisitDate.'</span>'; ?>
          </div>
        </div>

        <div class="spacer"></div>

        <!-- VISIT TIME MAX -->
        <div class="row">
          <div class="span1">
            <strong><?php echo $langFile['STATISTICS_TEXT_VISITTIME_MAX']; ?></strong>
          </div>
          <div class="span1">
            <?php
            $showTimeHead = true;
            if(is_array($visitTimes_max)) {
              foreach($visitTimes_max as $visitTime_max) {
                if($visitTimeFormated = showVisitTime($visitTime_max)) {
                  if($showTimeHead) {
                    echo '<span class="toolTipRight" title="::';
                    $visitTimeHead = $visitTimeFormated;
                    $showTimeHead = false;
                  } else {

                    echo str_replace(array('<','>'),array('[',']'),$visitTimeFormated).'[br]';
                  }
                }
              }
              echo '">'.$visitTimeHead.'</span>';
            }
            ?>
          </div>
        </div>
        <!-- VISIT TIME MIN -->
        <div class="row">
          <div class="span1">
            <strong><?php echo $langFile['STATISTICS_TEXT_VISITTIME_MIN']; ?></strong>
          </div>
          <div class="span1">
            <?php
            $showTimeHead = true;
            if(is_array($visitTimes_min)) {
              foreach($visitTimes_min as $visitTime_min) {
                if($visitTimeFormated = showVisitTime($visitTime_min)) {
                  if($showTimeHead) {
                    echo '<span class="toolTipRight" title="::';
                    $visitTimeHead = $visitTimeFormated;
                    $showTimeHead = false;
                  } else {

                    echo str_replace(array('<','>'),array('[',']'),$visitTimeFormated).'[br]';
                  }
                }
              }
              echo '">'.$visitTimeHead.'</span>';
            }
            ?>
          </div>
        </div>
      </div>

      <?php
      $searchWords = createTagCloud($pageStatistics['searchWords'],6,9);

      if($searchWords) {
      ?>
      <div class="spacer"></div>

      <!-- SEARCHWORDS -->
      <h2 class="center"><?php echo $langFile['STATISTICS_TEXT_SEARCHWORD_DESCRIPTION']; ?></h2>
      <?php
        echo '<div class="tagCloud">';
        echo createTagCloud($pageStatistics['searchWords'],6,9);
        echo '</div>';

      }
      ?>
    </div>

    <?php
    }
    //$langFile['STATISTICS_TEXT_NOVISIT']
    unset($searchWords,$pageStatistics,$firstVisitDate,$firstVisitTime,$lastVisitDate,$lastVisitTime,$visitTimes_max,$visitTimes_min,$showTimeHead,$visitTimeFormated);


    // THUMBNAIL
    if($categoryConfig[$pageContent['category']]['thumbnails'] || !empty($pageContent['thumbnail'])) {
    ?>
    <div class="box center">
      <h1><img src="library/images/icons/thumbnailIcon_middle.png" alt="icon" style="position:relative; top:-4px; margin-right:5px;"><?php echo $langFile['THUMBNAIL_TEXT_NAME']; ?></h1>
      <?php

      $thumbnailPath = (!empty($pageContent['thumbnail'])) ? GeneralFunctions::Path2URI(dirname(__FILE__).'/../upload/thumbnails/').$pageContent['thumbnail'] : '';
      // -> show THUMBNAIL if the page has one
      $displayThumbnailContainer = ' display:none;';
      if(!$NEWPAGE && !empty($pageContent['thumbnail'])) {
        $displayThumbnailContainer = '';
      }

      // generates a random number to put on the end of the image, to prevent caching
      // $randomImage = '?'.md5(uniqid(rand(),1));

      // thumbnailPreviewContainer
      echo '<div id="thumbnailPreviewContainer" style="position:relative;display:inline-block;'.$displayThumbnailContainer.'">';
        // see if the thumbnails are activated, add upload/delete buttons
        if($categoryConfig[$pageContent['category']]['thumbnails']) {
          echo '<a href="?site=deletePageThumbnail&amp;category='.$_GET['category'].'&amp;page='.$_GET['page'].'" onclick="openWindowBox(\'library/views/windowBox/deletePageThumbnail.php?site='.$_GET['site'].'&amp;category='.$_GET['category'].'&amp;page='.$_GET['page'].'\',\''.$langFile['BUTTON_THUMBNAIL_DELETE'].'\');return false;" title="'.$langFile['BUTTON_TOOLTIP_THUMBNAIL_DELETE'].'::"" class="deleteButton toolTipLeft"></a>';
          echo '<a href="?site=uploadPageThumbnail&amp;category='.$_GET['category'].'&amp;page='.$_GET['page'].'" onclick="openWindowBox(\'library/views/windowBox/uploadPageThumbnail.php?site='.$_GET['site'].'&amp;category='.$_GET['category'].'&amp;page='.$_GET['page'].'\',\''.$langFile['BUTTON_THUMBNAIL_UPLOAD'].'\');return false;" class="image">';
          echo '<img src="'.$thumbnailPath.'" id="thumbnailPreviewImage" class="thumbnail" alt="thumbnail">';
          echo '</a>';
        // if not only show the thumbnailPreviewImage
        } else
          echo '<img src="'.$thumbnailPath.'" id="thumbnailPreviewImage" class="thumbnail" alt="thumbnail">';

      echo '</div>';

      // -> show the thumbnail upload button if there is no thumbnail yet
      $displayThumbnailUploadButton = (!$NEWPAGE && $categoryConfig[$pageContent['category']]['thumbnails'] && empty($pageContent['thumbnail']))
         ? '' : ' style="display:none;"';

      // thumbnailUploadButtonInPreviewArea
      echo '<a href="?site=uploadPageThumbnail&amp;category='.$_GET['category'].'&amp;page='.$_GET['page'].'" id="thumbnailUploadButtonInPreviewArea" onclick="openWindowBox(\'library/views/windowBox/uploadPageThumbnail.php?site='.$_GET['site'].'&amp;category='.$_GET['category'].'&amp;page='.$_GET['page'].'\',\''.$langFile['BUTTON_THUMBNAIL_UPLOAD'].'\');return false;" title="'.$langFile['BUTTON_TOOLTIP_THUMBNAIL_UPLOAD'].'::" class="uploadPageThumbnail toolTipBottom"'.$displayThumbnailUploadButton.'></a>';
      ?>
    </div>
    <?php
    }

    // PLUGINS
    if($categoryConfig[$pageContent['category']]['plugins'])
      include(dirname(__FILE__).'/includes/editPlugins.leftSideBar.include.php');
  }

// SITES
} else {

  // SWITCH the &_GET['site'] var
  switch($_GET['site']) {

    // ***** dashboard sideBar -------------------------------------------------- *********
    case 'dashboard':
    ?>
      <div id="feinduraNewsBlock"></div>

      <!-- NEWS LOADER SCRIPT -->
      <script type="text/javascript">
      /* <![CDATA[ */

        var feinduraNewsBlock = $('feinduraNewsBlock');
        feinduraNewsBlock.setStyle('display','none');

        new Request.HTML({
          url:'library/includes/feinduraNews.include.php',
          method: 'post',
          update: feinduraNewsBlock,
          onSuccess: function(html) {

            var setOpacityTimeout = (function(){feinduraNewsBlock.tween('opacity',0.7);}).delay(3000);


            feinduraNewsBlock.addEvents({
              mouseenter: function(){
                clearTimeout(setOpacityTimeout);
                feinduraNewsBlock.tween('opacity',1);
              },
              mouseleave: function(){
                feinduraNewsBlock.tween('opacity',0.7);
              }
            });

            feinduraNewsBlock.show();
            resizeOnHover();
          }
        }).send();

      /* ]]> */
      </script>
    <?php
      break;

    // ***** pages sideBar -------------------------------------------------- *********
    case 'pages':
        echo '<div class="box">';
          echo '<img src="library/images/icons/hintIcon.png" class="hintIcon" alt="icon" style="width: 65px; height: 65px">'.$langFile['SORTABLEPAGELIST_info'];
          // -> the javascript request of the sortable gets its error messages from this input
          echo '<input type="hidden" id="sortablePageList_status" value="'.$langFile['SORTABLEPAGELIST_save'].'|'.$langFile['SORTABLEPAGELIST_categoryEmpty'].'">';
        echo '</div>';
      break;

    // ***** statisticSetup sideBar -------------------------------------------- *********
    case 'statisticSetup':
      break;

    // ***** websiteSetup sideBar -------------------------------------------- *********
    case 'websiteSetup':
      if(is_array($websiteConfig['localized'])) {
        $websiteConfigLanguages = array_keys($websiteConfig['localized']);
        if(is_array($websiteConfigLanguages) && is_array($websiteConfig['multiLanguageWebsite']['languages']))
          $websiteConfigLanguagesDiff = array_diff($websiteConfig['multiLanguageWebsite']['languages'],$websiteConfigLanguages);
        if($websiteConfig['multiLanguageWebsite']['active'] && !empty($websiteConfigLanguagesDiff)) {
          echo '<div class="box">';
            echo '<img src="library/images/icons/missingLanguages.png" class="hintIcon" width="50" height="50">';
            echo '<h2>'.$langFile['SORTABLEPAGELIST_TOOLTIP_LANGUAGEMISSING'].'</h2>';
            echo '<ul class="flags">';
            foreach ($websiteConfig['multiLanguageWebsite']['languages'] as $langCode) {
              if(!isset($websiteConfig['localized'][$langCode])) {
                echo '<li><img src="'.GeneralFunctions::getFlagSrc($langCode).'" class="flag"> <a href="'.GeneralFunctions::addParameterToUrl('websiteLanguage',$langCode).'" class="link gray">'.$languageNames[$langCode].'</a></li>';
              }
            }
            echo '</ul>';
          echo '</div>';
        }
      }
      unset($websiteConfigLanguages,$websiteConfigLanguagesDiff);
      break;

    // ***** pageSetup sideBar -------------------------------------------- *********
    case 'pageSetup':
      $categoryHasMissingLanguages = false;
      if(is_array($websiteConfig['multiLanguageWebsite']['languages'])) {
        foreach ($categoryConfig as $category) {
          if($category['id'] == 0)
            continue;
          $arrayDifferences = array_diff($websiteConfig['multiLanguageWebsite']['languages'],array_keys($category['localized']));
          if(!empty($arrayDifferences)) {
            $categoryHasMissingLanguages = true;
            break;
          }
        }
      }
      if($categoryHasMissingLanguages) {
        echo '<div class="box">';
          echo '<img src="library/images/icons/missingLanguages.png" class="hintIcon" width="50" height="50">';
          echo '<h2>'.$langFile['WARNING_TITLE_UNTITLEDCATEGORIES'].'</h2>';
          echo '<ul class="flags">';
          foreach ($websiteConfig['multiLanguageWebsite']['languages'] as $langCode) {
            foreach ($categoryConfig as $category) {
              if($category['id'] == 0)
                continue;
              if(!isset($category['localized'][$langCode])) {
                $categoryName = GeneralFunctions::getLocalized($category,'name');
                $categoryName = (!empty($categoryName)) ? ' &rArr; '.$categoryName : '';
                echo '<li><img src="'.GeneralFunctions::getFlagSrc($langCode).'" class="flag"> '.$languageNames[$langCode].'<a href="'.GeneralFunctions::addParameterToUrl('websiteLanguage',$langCode).'" class="link gray">'.$categoryName.'</a></li>';
              }
            }
          }
          echo '</ul>';
        echo '</div>';
      }
      break;

    // ***** DEFAULT --------------------------------------------------------- *********
    default:
      
      break;

  } //switch END
}