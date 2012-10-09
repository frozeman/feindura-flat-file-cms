<?php
/**
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
 *
 * sites/pageSetup.php
 *
 * @version 1.4
 */

/**
 * Includes the login.include.php and backend.include.php and filter the basic data
 */
require_once(dirname(__FILE__)."/../includes/secure.include.php");

// VARS from pageSetup.controller.php
// - $plugins = a list with all plugins available

?>
<form action="index.php?site=pageSetup" id="pageSettingsForm" method="post" enctype="multipart/form-data" accept-charset="UTF-8">
  <div>
    <input type="hidden" name="send" value="pageConfig">
    <input type="hidden" name="savedBlock" id="savedBlock" value="">
  </div>


<!-- THUMBNAIL SETTINGS -->
<a id="thumbnailSettings" class="anchorTarget"></a>
<?php
// shows the block below if it is the ones which is saved before
$hidden = ($SAVEDFORM != 'thumbnailSettings') ? ' hidden' : '';
?>
<div class="block<?php echo $hidden; ?>">
  <h1><a href="#"><img src="library/images/icons/thumbnailIcon_middle.png" class="blockH1Icon" alt="thumbnail icon" width="35" height="35"><?php echo $langFile['adminSetup_thumbnailSettings_h1']; ?></a></h1>
  <div class="content form">

    <!-- THUMB WIDTH -->
    <div class="row">
      <div class="span3 formLeft">
        <label for="cfg_thumbWidth"><span class="toolTipLeft" title="<?php echo $langFile['THUMBNAIL_TOOLTIP_WIDTH'] ?>">
        <?php echo $langFile['THUMBNAIL_TEXT_WIDTH'] ?></span></label>
      </div>
      <div class="span5">
          <input type="number" step="1" min="0" id="cfg_thumbWidth" name="cfg_thumbWidth" value="<?php echo $adminConfig['pageThumbnail']['width']; ?>" <?php if($adminConfig['pageThumbnail']['ratio'] == 'y') echo ' disabled="disabled"'; ?>>
          <?php echo $langFile['THUMBNAIL_TEXT_UNIT']; ?>
          &nbsp;&nbsp;&nbsp;&nbsp;
          <input type="radio" id="ratioX" name="cfg_thumbRatio" value="x"<?php if($adminConfig['pageThumbnail']['ratio'] == 'x') echo ' checked="checked"'; ?>>
          <label for="ratioX"><span class="toolTipRight" title="<?php echo $langFile['THUMBNAIL_TOOLTIP_KEEPRATIO_X']; ?>::"> <?php echo $langFile['THUMBNAIL_TEXT_KEEPRATIO']; ?></span></label>
      </div>
    </div>

    <!-- shows the width in a scale -->
    <?php
    if(!empty($adminConfig['pageThumbnail']['width']))
      $style_thumbWidth = 'width:'.$adminConfig['pageThumbnail']['width'].'px;';
    else
      $style_thumbWidth = 'width:0px;';
    ?>
    <div class="row">
      <div class="offset3 span5">
        <div id="thumbWidthScale" class="thumbnailScale" style="<?php echo $style_thumbWidth; ?>max-width:520px;">
          <div></div>
        </div>
      </div>
    </div>

    <!-- THUMB HEIGHT -->
    <div class="row">
      <div class="span3 formLeft">
        <label for="cfg_thumbHeight"><span class="toolTipLeft" title="<?php echo $langFile['THUMBNAIL_TOOLTIP_HEIGHT'] ?>">
        <?php echo $langFile['THUMBNAIL_TEXT_HEIGHT'] ?></span></label>
      </div>
      <div class="span5">
          <input type="number" step="1" min="0" id="cfg_thumbHeight" name="cfg_thumbHeight" value="<?php echo $adminConfig['pageThumbnail']['height']; ?>" <?php if($adminConfig['pageThumbnail']['ratio'] == 'x') echo ' disabled="disabled"'; ?>>
          <?php echo $langFile['THUMBNAIL_TEXT_UNIT']; ?>
          &nbsp;&nbsp;&nbsp;&nbsp;
          <input type="radio" id="ratioY" name="cfg_thumbRatio" value="y"<?php if($adminConfig['pageThumbnail']['ratio'] == 'y') echo ' checked="checked"'; ?>>
          <label for="ratioY"><span class="toolTipRight" title="<?php echo $langFile['THUMBNAIL_TOOLTIP_KEEPRATIO_Y']; ?>::"> <?php echo $langFile['THUMBNAIL_TEXT_KEEPRATIO']; ?></span></label>
      </div>
    </div>

    <!-- shows the height in a scale -->
    <?php
    if(!empty($adminConfig['pageThumbnail']['height']))
      $style_thumbHeight = 'width:'.$adminConfig['pageThumbnail']['height'].'px;';
    else
      $style_thumbHeight = 'width:0px;';
    ?>
    <div class="row">
      <div class="offset3 span5">
        <div id="thumbHeightScale" class="thumbnailScale" style="<?php echo $style_thumbHeight; ?>max-width:520px;"><div></div></div>
      </div>
    </div>

    <!-- NO THUMB RATIO -->
    <div class="row">
      <div class="span3 formLeft">
        <input type="radio" id="noRatio" name="cfg_thumbRatio" value=""<?php if($adminConfig['pageThumbnail']['ratio'] == '') echo ' checked="checked"'; ?>>
      </div>
      <div class="span5">
        <label for="noRatio"><span class="toolTipRight" title="<?php echo $langFile['THUMBNAIL_TOOLTIP_FIXEDRATIO']; ?>::"> <?php echo $langFile['THUMBNAIL_TEXT_FIXEDRATIO']; ?></span></label>
      </div>
    </div>

    <input type="submit" value="" class="button submit center" title="<?php echo $langFile['FORM_BUTTON_SUBMIT']; ?>">
  </div>
</div>

</form>


<form action="index.php?site=pageSetup" id="categoriesForm" method="post" enctype="multipart/form-data" accept-charset="UTF-8">
  <div>
    <input type="hidden" name="send" value="categorySetup">
    <input type="hidden" name="savedCategory" id="savedCategory" value="">
    <input type="hidden" name="websiteLanguage" value="<?php echo $_SESSION['feinduraSession']['websiteLanguage']; ?>">
    <input type="hidden" name="categories[0][id]" value="0">
  </div>

<!-- NON CATEGORY PAGES CONFIG -->
<a id="nonCategoryPages" class="anchorTarget"></a>
<?php
// shows the block below if it is the ones which is saved before
$hidden = ($SAVEDFORM !== false && $_POST['savedCategory'] != '0') ? ' hidden' : '';
?>
<div class="block<?php echo $hidden; ?>">
  <h1 class="brown"><a href="#"><img src="library/images/icons/pageIcon_middle.png" class="blockH1Icon" alt="non category icon" width="35" height="35"><?php echo $langFile['PAGESETUP_PAGES_TITLE_NONCATEGORYPAGES']; ?></a></h1>
  <div class="content form">

    <input type="hidden" name="categories[0][public]" value="true">

    <div class="row">
      <div class="span4">

        <div class="row">
          <div class="span1 formLeft">
            <input type="checkbox" id="nonCategoryCreateDelete" name="categories[0][createDelete]" value="true" class="toolTipLeft" title="::<?php echo $langFile['PAGESETUP_PAGES_TIP_CREATEPAGES']; ?>"<?php if($categoryConfig[0]['createDelete']) echo ' checked="checked"'; ?>><br>
          </div>
          <div class="span3">
            <label for="nonCategoryCreateDelete"><span class="toolTipRight" title="::<?php echo $langFile['PAGESETUP_PAGES_TIP_CREATEPAGES']; ?>"><?php echo $langFile['PAGESETUP_PAGES_TEXT_CREATEPAGES']; ?></span></label><br>
          </div>
        </div>

        <div class="row">
          <div class="span1 formLeft">
            <input type="checkbox" id="nonCategoryThumbnails" name="categories[0][thumbnails]" value="true" class="toolTipLeft" title="::<?php echo $langFile['PAGESETUP_PAGES_TIP_UPLOADTHUMBNAILS']; ?>"<?php if($categoryConfig[0]['thumbnails']) echo ' checked="checked"'; ?>><br>
          </div>
          <div class="span3">
            <label for="nonCategoryThumbnails"><span class="toolTipRight" title="::<?php echo $langFile['PAGESETUP_PAGES_TIP_UPLOADTHUMBNAILS']; ?>"><?php echo $langFile['PAGESETUP_PAGES_TEXT_UPLOADTHUMBNAILS']; ?></span></label><br>
          </div>
        </div>

        <div class="row">
          <div class="span1 formLeft">
            <input type="checkbox" id="nonCategoryShowTags" name="categories[0][showTags]" value="true" class="toolTipLeft" title="::<?php echo $langFile['PAGESETUP_PAGES_TIP_EDITTAGS']; ?>"<?php if($categoryConfig[0]['showTags']) echo ' checked="checked"'; ?>>
          </div>
          <div class="span3">
            <label for="nonCategoryShowTags"><span class="toolTipRight" title="::<?php echo $langFile['PAGESETUP_PAGES_TIP_EDITTAGS']; ?>"><?php echo $langFile['PAGESETUP_PAGES_TEXT_EDITTAGS']; ?></span></label>
          </div>
        </div>

        <div class="row">
          <div class="span1 formLeft">
            <input type="checkbox" id="nonCategoryShowPageDate" class="pageDates" name="categories[0][showPageDate]" value="true" class="toolTipLeft" title="::<?php echo $langFile['PAGESETUP_TIP_EDITPAGEDATE']; ?>"<?php if($categoryConfig[0]['showPageDate']) echo ' checked="checked"'; ?>>
          </div>
          <div class="span3">
            <label for="nonCategoryShowPageDate"><span class="toolTipRight" title="::<?php echo $langFile['PAGESETUP_TIP_EDITPAGEDATE']; ?>"><?php echo $langFile['PAGESETUP_TEXT_EDITPAGEDATE']; ?></span></label>
          </div>
        </div>
        <div class="row pageDatesRange"<?php if(!$categoryConfig[0]['showPageDate']) echo ' style="display:none;"'; ?>>
          <div class="offset1 span2 subOption">
            <input type="checkbox" id="nonCategoryPageDateRange" name="categories[0][pageDateAsRange]" value="true"<?php if($categoryConfig[0]['pageDateAsRange']) echo ' checked="checked"'; ?>>
            <label for="nonCategoryPageDateRange"><span><?php echo $langFile['PAGESETUP_TEXT_PAGEDATERANGE']; ?></span></label>
          </div>
        </div>

        <div class="row">
          <div class="span1 formLeft">
            <input type="checkbox" id="nonCategoryShowSubCategory" name="categories[0][showSubCategory]" value="true" class="toolTipLeft" title="::<?php echo $langFile['PAGESETUP_TIP_SUBCATEGORY']; ?>"<?php if($categoryConfig[0]['showSubCategory']) echo ' checked="checked"'; ?>>
          </div>
          <div class="span3">
            <label for="nonCategoryShowSubCategory"><span class="toolTipRight" title="::<?php echo $langFile['PAGESETUP_TIP_SUBCATEGORY']; ?>"><?php echo $langFile['PAGESETUP_TEXT_SUBCATEGORY']; ?></span></label>
          </div>
        </div>

        <div class="row">
          <div class="span1 formLeft">
            <input type="checkbox" id="nonCategoryFeeds" name="categories[0][feeds]" value="true" class="toolTipLeft" title="::<?php echo $langFile['PAGESETUP_TIP_FEEDS']; ?>"<?php if($categoryConfig[0]['feeds']) echo ' checked="checked"'; ?>>
          </div>
          <div class="span3">
            <label for="nonCategoryFeeds"><span class="toolTipRight" title="::<?php echo $langFile['PAGESETUP_TIP_FEEDS']; ?>"><?php echo $langFile['PAGESETUP_TEXT_FEEDS']; ?></span></label>
          </div>
        </div>

        <div class="row">
          <div class="span1 formLeft">
            <input type="checkbox" id="nonCategoryPlugins" name="categories[0][plugins]" value="true" class="toolTipLeft" title="::<?php echo $langFile['PAGESETUP_PAGES_TIP_ACTIVATEPLUGINS']; ?>"<?php if($categoryConfig[0]['plugins']) echo ' checked="checked"'; ?>>
          </div>
          <div class="span3">
            <label for="nonCategoryPlugins"><span class="toolTipRight" title="::<?php echo $langFile['PAGESETUP_PAGES_TIP_ACTIVATEPLUGINS']; ?>"><?php echo $langFile['PAGESETUP_PAGES_TEXT_ACTIVATEPLUGINS']; ?></span></label>
          </div>
        </div>

      </div>
      <div class="span4">
        <!-- SORTING -->
        <!-- manually -->
        <div class="row">
          <div class="span1 formLeft">
            <input type="radio" id="nonCategorySortManually" name="categories[0][sorting]" value="manually" class="toolTipLeft" title="::<?php echo $langFile['PAGESETUP_TIP_SORTMANUALLY']; ?>"<?php if($categoryConfig[0]['sorting'] == 'manually' || empty($categoryConfig[0]['sorting'])) echo ' checked="checked"'; ?>>
          </div>
          <div class="span3">
            <label for="nonCategorySortManually"><span class="toolTipRight" title="::<?php echo $langFile['PAGESETUP_TIP_SORTMANUALLY'] ?>"><?php echo $langFile['PAGESETUP_TEXT_SORTMANUALLY']; ?></span></label>
          </div>
        </div>
        <!-- sort by date    -->
        <div class="row">
          <div class="span1 formLeft">
            <input type="radio" id="nonCategorySortByPageDate" name="categories[0][sorting]" value="byPageDate" class="toolTipLeft" title="::<?php echo $langFile['PAGESETUP_TIP_SORTBYDATE']; ?>"<?php if($categoryConfig[0]['sorting'] == 'byPageDate') echo ' checked="checked"'; ?>>
          </div>
          <div class="span3">
            <label for="nonCategorySortByPageDate"><span class="toolTipRight" title="::<?php echo $langFile['PAGESETUP_TIP_SORTBYDATE'] ?>"><?php echo $langFile['PAGESETUP_TIP_SORTBYPAGEDATE']; ?></span></label>
          </div>
        </div>
        <!-- sort alphabetical -->
        <div class="row">
          <div class="span1 formLeft">
            <input type="radio" id="nonCategorySortAlphabetical" name="categories[0][sorting]" value="alphabetical" class="toolTipLeft" title="::<?php echo $langFile['PAGESETUP_TIP_SORTALPHABETICAL']; ?>"<?php if($categoryConfig[0]['sorting'] == 'alphabetical') echo ' checked="checked"'; ?>>
          </div>
          <div class="span3">
            <label for="nonCategorySortAlphabetical"><span class="toolTipRight" title="::<?php echo $langFile['PAGESETUP_TIP_SORTALPHABETICAL'] ?>"><?php echo $langFile['PAGESETUP_TEXT_SORTALPHABETICAL']; ?></span></label>
          </div>
        </div>
        <!-- sortReverse -->
        <div class="row">
          <div class="span1 formLeft">
            <input type="checkbox" id="nonCategorySortReverse" name="categories[0][sortReverse]" value="true" class="toolTipLeft" title="::<?php echo $langFile['PAGESETUP_TIP_SORTREVERSE']; ?>"<?php if($categoryConfig[0]['sortReverse']) echo ' checked="checked"'; ?>>
          </div>
          <div class="span3">
            <label for="nonCategorySortReverse"><span class="toolTipRight" title="::<?php echo $langFile['PAGESETUP_TIP_SORTREVERSE'] ?>"><?php echo $langFile['PAGESETUP_TEXT_SORTREVERSE']; ?></span></label>
          </div>
        </div>
      </div>
    </div>

    <div class="spacer"></div>

    <input type="submit" value="" class="button submit center" title="<?php echo $langFile['FORM_BUTTON_SUBMIT']; ?>" onclick="$('savedCategory').value = 0;">
  </div>
</div>


<!-- CATEGORIES SETTINGS -->
<div class="block">
  <h1 class="blue"><img src="library/images/icons/categoryIcon_middle.png" class="blockH1Icon" alt="non category icon" width="35" height="35"><?php echo $langFile['PAGESETUP_CATEGORY_TITLE_CATEGORIES']; ?></h1>
  <div class="content form">
    <div class="row">
      <div class="span8 center">
          <a href="?site=pageSetup&amp;status=createCategory#category<?php echo getNewCatgoryId(); ?>" class="createCategory toolTipLeft" title="<?php echo $langFile['PAGESETUP_CATEGORY_TEXT_CREATECATEGORY']; ?>::"></a>
      </div>
    </div>
    <?php

      // draw separator line
      if(count($categoryConfig) > 0)
        echo '<div class="verticalSeparator"></div>';

      // lists the categories
      if(is_array($categoryConfig)) {
        $lastCategory = end($categoryConfig);
        reset($categoryConfig);
        $firstCategory = next($categoryConfig); // gets the first category after the non-category
        $autoFocusFirst = true;

        foreach($categoryConfig as $category) {

          // overjump the non-category
          if($category['id'] == 0) continue;

          // prevent using the $check vars from the last category
          unset($checked);

          // checks the category settings
          $checked[1]  = ($category['public']) ? 'checked="checked"' : '';

          $checked[2]  = ($category['createDelete']) ? 'checked="checked"' : '';

          $checked[3]  = ($category['thumbnails']) ? 'checked="checked"' : '';

          $checked[11] = ($category['plugins']) ? 'checked="checked"' : '';

          $checked[4]  = ($category['showTags']) ? 'checked="checked"' : '';

          $checked[5]  = ($category['showPageDate']) ? 'checked="checked"' : '';

          $checked[13] = ($category['showSubCategory']) ? 'checked="checked"' : '';

          $checked[14] = ($category['pageDateAsRange']) ? 'checked="checked"' : '';

          $checked[12] = ($category['feeds']) ? 'checked="checked"' : '';

          $checked[6]  = ($category['sortReverse']) ? 'checked="checked"' : '';

          $checked[71] = ($category['sorting'] == 'manually' || empty($category['sorting'])) ? 'checked="checked"' : '';
          $checked[72] = ($category['sorting'] == 'byPageDate') ? 'checked="checked"' : '';
          $checked[73] = ($category['sorting'] == 'alphabetical') ? 'checked="checked"' : '';

          $checked[8] = (empty($category['thumbRatio'])) ? 'checked="checked"' : '';

          if($category['thumbRatio'] == 'x') {
            $checked[9] = 'checked="checked"';
            $disabled[10] = 'disabled="disabled"';
          }

          if($category['thumbRatio'] == 'y') {
            $checked[10] = 'checked="checked"';
            $disabled[9] = 'disabled="disabled"';
          }

          echo '<div class="spacer2x"></div>';

          // slide container (help for the javascript to find the right elements)
          echo '<div class="categoryConfig">';

          // --------------------------------------
          // first TABLE (normal category settings)

          // category anchor
          echo '<a name="category'.$category['id'].'" id="categoryAnchor'.$category['id'].'" class="anchorTarget"></a>';

          // category NAME
          $categoryName = GeneralFunctions::getLocalized($category,'name',false,true);
          $autofocus = '';
          // change to "unnamed category" if text is missing
          if(empty($categoryName)) {
            $categoryName = '<i>'.$langFile['PAGESETUP_CATEGORY_TEXT_CREATECATEGORY_UNNAMED'].'</i>';
            if($autoFocusFirst) {
              $autofocus = ' autofocus="autofocus"';
              $autoFocusFirst = false;
            }
          }

          echo '<div class="row">
                  <div class="span8" style="position:relative;">';
              echo '<h2 class="center">'.$categoryName.' (ID '.$category['id'].')</h2>';
              echo '<input type="hidden" name="categories['.$category['id'].'][id]" value="'.$category['id'].'">';

                // deleteCategory
              echo '<a href="?site=pageSetup&amp;status=deleteCategory&amp;category='.$category['id'].'#categories" class="deleteCategory toolTipLeft" onclick="openWindowBox(\'library/views/windowBox/deleteCategory.php?status=deleteCategory&amp;category='.$category['id'].'\',\''.$langFile['PAGESETUP_CATEGORY_TEXT_DELETECATEGORY'].'\');return false;" title="'.$langFile['PAGESETUP_CATEGORY_TEXT_DELETECATEGORY'].'::'.GeneralFunctions::getLocalized($category,'name',false,true).'"></a>';
          echo '  </div>
                </div>';
                // category name
          echo '<div class="row">
                  <div class="span3 formLeft">
                    <label for="categories'.$category['id'].'name">'.$langFile['PAGESETUP_CATEGORY_TEXT_CATEGORYNAME'].'</label>
                  </div>
                  <div class="span5">
                    <input type="text" id="categories'.$category['id'].'name" name="categories['.$category['id'].'][name]" value="'.GeneralFunctions::getLocalized($category,'name',false,true).'"'.$autofocus.'>
                  </div>
                </div>';

          // category up / down
          if(count($categoryConfig) > 1) {

            if($firstCategory['id'] != $category['id'])
              echo '<a href="?site=pageSetup&amp;status=moveCategoryUp&amp;category='.$category['id'].'&amp;load='.rand(0,999).'#category'.$category['id'].'" class="categoryUp toolTipLeft" title="'.$langFile['PAGESETUP_CATEGORY_TIP_MOVECATEGORY_UP'].'::"></a>';
            if($lastCategory['id'] != $category['id'])
              echo '<a href="?site=pageSetup&amp;status=moveCategoryDown&amp;category='.$category['id'].'&amp;load='.rand(0,999).'#category'.$category['id'].'" class="categoryDown toolTipLeft" title="'.$langFile['PAGESETUP_CATEGORY_TIP_MOVECATEGORY_DOWN'].'::"></a>';
          }

          // CATEGORY STATUS
          echo '<div class="row">
                  <div class="span3 formLeft">
                    <input type="checkbox" id="categories'.$category['id'].'public" name="categories['.$category['id'].'][public]" value="true" '.$checked[1].' class="toolTipLeft" title="::'.$langFile['PAGESETUP_CATEGORY_TIP_CATEGORYSTATUS'].'"><br>
                  </div>
                  <div class="span5">
                    <label for="categories'.$category['id'].'public">';
                    $publicSignStyle = ' style="position:relative; top:-1px; float:left;"';
                    // shows the public or unpublic picture
                    if($checked[1])
                      echo '<img src="library/images/icons/category_public.png" class="toolTipBottom" title="'.$langFile['STATUS_CATEGORY_PUBLIC'].'"'.$publicSignStyle.' alt="public" width="27" height="27">&nbsp;';
                    else
                      echo '<img src="library/images/icons/category_nonpublic.png" class="toolTipBottom" title="'.$langFile['STATUS_CATEGORY_NONPUBLIC'].'"'.$publicSignStyle.' alt="nonpublic" width="27" height="27">&nbsp;';

                    echo '<span class="toolTipRight" title="::'.$langFile['PAGESETUP_CATEGORY_TIP_CATEGORYSTATUS'].'">'.$langFile['PAGESETUP_CATEGORY_TEXT_CATEGORYSTATUS'].'</span></label>
                  </div>
                </div>';

          echo '<div class="spacer"></div>';


          // CATEGORY SETTINGS
          echo '<div class="row">';
            echo '<div class="span4">';

              echo '<div class="row">
                      <div class="span1 formLeft">
                        <input type="checkbox" id="categories'.$category['id'].'createDelete" name="categories['.$category['id'].'][createDelete]" value="true" '.$checked[2].' class="toolTipLeft" title="::'.$langFile['PAGESETUP_CATEGORY_TIP_CREATEPAGES'].'"><br>
                      </div>
                      <div class="span3">
                        <label for="categories'.$category['id'].'createDelete"><span class="toolTipRight" title="::'.$langFile['PAGESETUP_CATEGORY_TIP_CREATEPAGES'].'">'.$langFile['PAGESETUP_CATEGORY_TEXT_CREATEPAGES'].'</span></label>
                      </div>
                    </div>';

              echo '<div class="row">
                      <div class="span1 formLeft">
                        <input type="checkbox" id="categories'.$category['id'].'thumbnails" name="categories['.$category['id'].'][thumbnails]" value="true" '.$checked[3].' class="toolTipLeft" title="::'.$langFile['PAGESETUP_CATEGORY_TIP_UPLOADTHUMBNAILS'].'"><br>
                      </div>
                      <div class="span3">
                        <label for="categories'.$category['id'].'thumbnails"><span class="toolTipRight" title="::'.$langFile['PAGESETUP_CATEGORY_TIP_UPLOADTHUMBNAILS'].'">'.$langFile['PAGESETUP_CATEGORY_TEXT_UPLOADTHUMBNAILS'].'</span></label>
                      </div>
                    </div>';

              echo '<div class="row">
                      <div class="span1 formLeft">
                        <input type="checkbox" id="categories'.$category['id'].'showTags" name="categories['.$category['id'].'][showTags]" value="true" '.$checked[4].' class="toolTipLeft" title="::'.$langFile['PAGESETUP_CATEGORY_TIP_EDITTAGS'].'"><br>
                      </div>
                      <div class="span3">
                        <label for="categories'.$category['id'].'showTags"><span class="toolTipRight" title="::'.$langFile['PAGESETUP_CATEGORY_TIP_EDITTAGS'].'">'.$langFile['PAGESETUP_CATEGORY_TEXT_EDITTAGS'].'</span></label>
                      </div>
                    </div>';

              echo '<div class="row">
                      <div class="span1 formLeft">
                        <input type="checkbox" id="categories'.$category['id'].'showPageDate" class="pageDates" name="categories['.$category['id'].'][showPageDate]" value="true" '.$checked[5].' class="toolTipLeft" title="::'.$langFile['PAGESETUP_TIP_EDITPAGEDATE'].'"><br>
                      </div>
                      <div class="span3">
                        <label for="categories'.$category['id'].'showPageDate"><span class="toolTipRight" title="::'.$langFile['PAGESETUP_TIP_EDITPAGEDATE'].'">'.$langFile['PAGESETUP_TEXT_EDITPAGEDATE'].'</span></label>
                      </div>
                    </div>';
              $showPageDateRange = (!$category['showPageDate']) ? ' style="display:none;"' : '';
              echo '<div class="row pageDatesRange"'.$showPageDateRange.'>
                      <div class="offset1 span2 subOption">
                        <input type="checkbox" id="categories'.$category['id'].'PageDateRange" name="categories['.$category['id'].'][pageDateAsRange]" value="true"'.$checked[14].'>
                        <label for="categories'.$category['id'].'PageDateRange"><span>'.$langFile['PAGESETUP_TEXT_PAGEDATERANGE'].'</span></label>
                      </div>
                    </div>';

              echo '<div class="row">
                      <div class="span1 formLeft">
                        <input type="checkbox" id="categories'.$category['id'].'showSubCategory" name="categories['.$category['id'].'][showSubCategory]" value="true" '.$checked[13].' class="toolTipLeft" title="::'.$langFile['PAGESETUP_TIP_SUBCATEGORY'].'">
                      </div>
                      <div class="span3">
                        <label for="categories'.$category['id'].'showSubCategory"><span class="toolTipRight" title="::'.$langFile['PAGESETUP_TIP_SUBCATEGORY'].'">'.$langFile['PAGESETUP_TEXT_SUBCATEGORY'].'</span></label>
                      </div>
                    </div>';

              echo '<div class="row">
                      <div class="span1 formLeft">
                        <input type="checkbox" id="categories'.$category['id'].'feeds" name="categories['.$category['id'].'][feeds]" value="true" '.$checked[12].' class="toolTipLeft" title="::'.$langFile['PAGESETUP_CATEGORY_TIP_FEEDS'].'"><br>
                      </div>
                      <div class="span3">
                        <label for="categories'.$category['id'].'feeds"><span class="toolTipRight" title="::'.$langFile['PAGESETUP_CATEGORY_TIP_FEEDS'].'">'.$langFile['PAGESETUP_TEXT_FEEDS'].'</span></label>
                      </div>
                    </div>';

              echo '<div class="row">
                      <div class="span1 formLeft">
                        <input type="checkbox" id="categories'.$category['id'].'plugins" name="categories['.$category['id'].'][plugins]" value="true" '.$checked[11].' class="toolTipLeft" title="::'.$langFile['PAGESETUP_CATEGORY_TIP_ACTIVATEPLUGINS'].'"><br>
                      </div>
                      <div class="span3">
                        <label for="categories'.$category['id'].'plugins"><span class="toolTipRight" title="::'.$langFile['PAGESETUP_CATEGORY_TIP_ACTIVATEPLUGINS'].'">'.$langFile['PAGESETUP_CATEGORY_TEXT_ACTIVATEPLUGINS'].'</span></label>
                      </div>
                    </div>';

            echo '</div>';

            // SORTING
            echo '<div class="span4">';

              // manually
              echo '<div class="row">
                      <div class="span1 formLeft">
                        <input type="radio" id="categories'.$category['id'].'sortManually" name="categories['.$category['id'].'][sorting]" value="manually" '.$checked[71].' class="toolTipLeft" title="::'.$langFile['PAGESETUP_TIP_SORTMANUALLY'].'">
                      </div>
                      <div class="span3">
                        <label for="categories'.$category['id'].'sortManually"><span class="toolTipRight" title="::'.$langFile['PAGESETUP_TIP_SORTMANUALLY'].'">'.$langFile['PAGESETUP_TEXT_SORTMANUALLY'].'</span></label>
                      </div>
                    </div>';
              // sort by date
              echo '<div class="row">
                      <div class="span1 formLeft">
                        <input type="radio" id="categories'.$category['id'].'sortByPageDate" name="categories['.$category['id'].'][sorting]" value="byPageDate" '.$checked[72].' class="toolTipLeft" title="::'.$langFile['PAGESETUP_TIP_SORTBYDATE'].'">
                      </div>
                      <div class="span3">
                        <label for="categories'.$category['id'].'sortByPageDate"><span class="toolTipRight" title="::'.$langFile['PAGESETUP_TIP_SORTBYDATE'].'">'.$langFile['PAGESETUP_TIP_SORTBYPAGEDATE'].'</span></label>
                      </div>
                    </div>';
              // sort alphabetical
              echo '<div class="row">
                      <div class="span1 formLeft">
                        <input type="radio" id="categories'.$category['id'].'sortAlphabetical" name="categories['.$category['id'].'][sorting]" value="alphabetical" '.$checked[73].' class="toolTipLeft" title="::'.$langFile['PAGESETUP_TIP_SORTALPHABETICAL'].'">
                      </div>
                      <div class="span3">
                        <label for="categories'.$category['id'].'sortAlphabetical"><span class="toolTipRight" title="::'.$langFile['PAGESETUP_TIP_SORTALPHABETICAL'].'">'.$langFile['PAGESETUP_TEXT_SORTALPHABETICAL'].'</span></label>
                      </div>
                    </div>';

              // sortReverse
              echo '<div class="row">
                      <div class="span1 formLeft">
                        <input type="checkbox" id="categories'.$category['id'].'sortReverse" name="categories['.$category['id'].'][sortReverse]" value="true" '.$checked[6].' class="toolTipLeft" title="::'.$langFile['PAGESETUP_TIP_SORTREVERSE'].'">
                      </div>
                      <div class="span3">
                        <label for="categories'.$category['id'].'sortReverse"><span class="toolTipRight" title="::'.$langFile['PAGESETUP_TIP_SORTREVERSE'].'">'.$langFile['PAGESETUP_TEXT_SORTREVERSE'].'</span></label>
                      </div>
                    </div>';

            echo '</div>';
          echo '</div>';

          echo '<div class="spacer"></div>';

          $advancedSettingsEdited = ((!empty($category['styleFile']) && $category['styleFile'] != 'a:0:{}') ||
                                     (!empty($category['styleId']) &&  $category['styleId'] != 'a:0:{}') ||
                                     (!empty($category['styleClass']) && $category['styleClass'] != 'a:0:{}') ||
                                      !empty($category['thumbWidth']) || !empty($category['thumbHeight']) || !empty($category['thumbRatio']))
            ? '&nbsp;<img src="library/images/icons/edited_small.png" class="toolTipRight" title="'.$langFile['EDITOR_advancedpageSettings_h1'].' '.$langFile['EDITOR_block_edited'].'::" alt="icon" style="position:relative;left: -10px;" onclick="return false;">'
            : '';

          echo '<div class="row">
                  <div class="span8 center">
                      <a href="#" class="btn inBlockSliderLink" data-inBlockSlider="'.$category['id'].'">'.$advancedSettingsEdited.$langFile['PAGESETUP_CATEGORY_TITLE_ADVANCEDSETTINGS'].' <span class="caret" onclick="return false;"></span></a>
                  </div>
                </div>';

          // -----------------------------------------------
          // second TABLE (advanced settings) (with slide in)
          $hidden = ($_POST['savedCategory'] != $category['id']) ? ' hidden' : '';

          echo '<div id="advancedConfigTable'.$category['id'].'" class="inBlockSlider insetBlock'.$hidden.'" data-inBlockSlider="'.$category['id'].'">

                <div class="row">
                    <div class="span8">
                      <div class="alert" style="margin-top: -5px;">'.$langFile['PAGESETUP_CATEGORY_HINT_ADVANCEDSETTINGS'].'</div>
                    </div>
                </div>';

          echo '<div class="row">
                  <div class="span3 formLeft">
                    <span class="toolTipLeft" title="::'.$langFile['STYLESHEETS_TOOLTIP_STYLEFILE'].'[br][br][span class=hint]'.$langFile['PAGESETUP_CATEGORY_TIP_STYLESHEETS_EMPTY'].'[/span]">
                    '.$langFile['STYLESHEETS_TEXT_STYLEFILE'].'</span>
                  </div>
                  <div class="span5">
                    <div id="categoryStyleFilesInputs'.$category['id'].'" class="toolTipTop" title="::'.$langFile['PAGESETUP_CATEGORY_TIP_STYLESHEETS_EMPTY'].'">';

                        echo showStyleFileInputs(getStylesByPriority($category['styleFile'],'styleFile',$pageContent['category']),'categories['.$category['id'].'][styleFile]');

          echo '    </div>
                    <a href="#" class="addStyleFilePath addButton toolTipLeft" style="margin-right: 10px;float:left;" title="'.$langFile['STYLESHEETS_TOOLTIP_ADDSTYLEFILE'].'::"></a>
                    <span class="badge" style="position:relative; top: 8px;">'.$langFile['STYLESHEETS_EXAMPLE_STYLEFILE'].'</span>
                  </div>
                </div>';

          echo '<div class="row">
                  <div class="span3 formLeft">
                    <label for="categories'.$category['id'].'styleId"><span class="toolTipLeft" title="::'.$langFile['STYLESHEETS_TOOLTIP_ID'].'[br][br][span class=hint]'.$langFile['PAGESETUP_CATEGORY_TIP_STYLESHEETS_EMPTY'].'[/span]">
                    '.$langFile['STYLESHEETS_TEXT_ID'].'</span></label>
                  </div>
                  <div class="span5">
                    <input type="text" id="categories'.$category['id'].'styleId" name="categories['.$category['id'].'][styleId]" value="'.getStylesByPriority($category['styleId'],'styleId',$category['id']).'" class="toolTipRight" title="::'.$langFile['PAGESETUP_CATEGORY_TIP_STYLESHEETS_EMPTY'].'">
                  </div>
                </div>';

          echo '<div class="row">
                  <div class="span3 formLeft">
                    <label for="categories'.$category['id'].'styleClass"><span class="toolTipLeft" title="::'.$langFile['STYLESHEETS_TOOLTIP_CLASS'].'[br][br][span class=hint]'.$langFile['PAGESETUP_CATEGORY_TIP_STYLESHEETS_EMPTY'].'[/span]">
                    '.$langFile['STYLESHEETS_TEXT_CLASS'].'</span></label>
                  </div>
                  <div class="span5">
                    <input type="text" id="categories'.$category['id'].'styleClass" name="categories['.$category['id'].'][styleClass]" value="'.getStylesByPriority($category['styleClass'],'styleClass',$category['id']).'" class="toolTipRight" title="::'.$langFile['PAGESETUP_CATEGORY_TIP_STYLESHEETS_EMPTY'].'">
                  </div>
                </div>';

          echo '<div class="spacer"></div>';

               // category thumbSize
          echo '<div class="row">
                  <div class="span3 formLeft">
                    <label for="categories'.$category['id'].'thumbWidth"><span class="toolTipLeft" title="'.$langFile['THUMBNAIL_TOOLTIP_WIDTH'].'">
                    '.$langFile['THUMBNAIL_TEXT_WIDTH'].'</span></label>
                  </div>
                  <div class="span5">
                    <input type="number" step="1" min="0" id="categories'.$category['id'].'thumbWidth" name="categories['.$category['id'].'][thumbWidth]" value="'.$category['thumbWidth'].'" '.$disabled[9].'>
                    '.$langFile['THUMBNAIL_TEXT_UNIT'].'
                    &nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="radio" id="categories'.$category['id'].'ratioX" name="categories['.$category['id'].'][thumbRatio]" value="x" '.$checked[9].'>
                    <label for="categories'.$category['id'].'ratioX" class="toolTipRight" title="'.$langFile['THUMBNAIL_TOOLTIP_KEEPRATIO_X'].'"> '.$langFile['THUMBNAIL_TEXT_KEEPRATIO'].'</label>
                  </div>
                </div>';

                // <!-- shows the width in a scale -->
                if(!empty($category['thumbWidth']))
                  $catThumbWidth = 'width:'.$category['thumbWidth'].'px;';
                else
                  $catThumbWidth = 'width:0px;';
          echo '<div class="row">
                  <div class="offset3 span5">
                    <div id="categories'.$category['id'].'thumbWidthScale" class="thumbnailScale" style="'.$catThumbWidth.'max-width:520px;"><div></div></div>
                  </div>
                </div>';

          echo '<div class="row">
                  <div class="span3 formLeft">
                    <label for="categories'.$category['id'].'thumbHeight"><span class="toolTipLeft" title="'.$langFile['THUMBNAIL_TOOLTIP_HEIGHT'].'">
                    '.$langFile['THUMBNAIL_TEXT_HEIGHT'].'</span></label>
                  </div>
                  <div class="span5">
                    <input type="number" step="1" min="0" id="categories'.$category['id'].'thumbHeight" name="categories['.$category['id'].'][thumbHeight]" value="'.$category['thumbHeight'].'" '.$disabled[10].'>
                    '.$langFile['THUMBNAIL_TEXT_UNIT'].'
                    &nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="radio" id="categories'.$category['id'].'ratioY" name="categories['.$category['id'].'][thumbRatio]" value="y" '.$checked[10].'>
                    <label for="categories'.$category['id'].'ratioY" class="toolTipRight" title="'.$langFile['THUMBNAIL_TOOLTIP_KEEPRATIO_Y'].'"> '.$langFile['THUMBNAIL_TEXT_KEEPRATIO'].'</label>
                  </div>
                </div>';

                // <!-- shows the height in a scale -->
                if(!empty($category['thumbHeight']))
                  $catThumbHeight = 'width:'.$category['thumbHeight'].'px;';
                else
                  $catThumbHeight = 'width:0px;';
          echo '<div class="row">
                  <div class="offset3 span5">
                    <div id="categories'.$category['id'].'thumbHeightScale" class="thumbnailScale"  style="'.$catThumbHeight.'max-width:520px;"><div></div></div>
                  </div>
                </div>';

          echo '<!-- NO THUMB RATIO -->
                <div class="row">
                  <div class="span3 formLeft">
                    <input type="radio" id="categories'.$category['id'].'noRatio" name="categories['.$category['id'].'][thumbRatio]" value="" '.$checked[8].'>
                  </div>
                  <div class="span5">
                    <label for="categories'.$category['id'].'noRatio" class="toolTipRight" title="'.$langFile['THUMBNAIL_TOOLTIP_FIXEDRATIO'].'"> '.$langFile['THUMBNAIL_TEXT_FIXEDRATIO'].'</label>
                  </div>
                </div>';

          // finish the TABLE for one category
          echo '</div>';

          // SUBMIT: If advancedConfigTable has not Class "hidden" it stores the categoryId in the savedCategory input
          // and gives the submit anchor to the FORM
          echo '<input type="submit" value="" class="button submit center" style="top:-25px;" title="'.$langFile['FORM_BUTTON_SUBMIT'].'" onclick="if(!$(\'advancedConfigTable'.$category['id'].'\').hasClass(\'hidden\')) $(\'savedCategory\').value = \''.$category['id'].'\';">';
          echo '</div>'; // end slide in box

        }
      }
      ?>
  </div>
</div>

</form>

<!-- PAGE SCRIPTS -->
<script type="text/javascript">
/* <![CDATA[ */

  // setup the AUTOMATICALLY ADDING OF the ANCHORS
  setupForm('pageSettingsForm');
  setupForm('categoriesForm');

  // PAGE DATE extra OPTION
  $$('input.pageDates').addEvent('change',function(e){
    if(this.checked)
      this.getParent('.row').getNext('.pageDatesRange').reveal();
    else
      this.getParent('.row').getNext('.pageDatesRange').dissolve();
  });

/* ]]> */
</script>