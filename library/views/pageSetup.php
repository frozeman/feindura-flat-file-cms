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
 * @version 1.2.3
 */

/**
 * Includes the login.include.php and backend.include.php and filter the basic data
 */
require_once(dirname(__FILE__)."/../includes/secure.include.php");

// LOAD PLUGINS
$plugins = GeneralFunctions::readFolder(dirname(__FILE__).'/../../plugins/');
$newPlugins = array();
foreach($plugins['folders'] as $pluginFolder)
  $newPlugins[] = basename($pluginFolder);
$plugins = $newPlugins;

?>
<form action="index.php?site=pageSetup" method="post" enctype="multipart/form-data" accept-charset="UTF-8" id="pageSettingsForm">
  <div>
  <input type="hidden" name="send" value="pageConfig">
  <input type="hidden" name="savedBlock" id="savedBlock" value="">
  </div>

<!-- GENERAL PAGE SETTINGS -->
<a id="generalPageConfig" class="anchorTarget"></a>
<?php
// shows the block below if it is the ones which is saved before
$hidden = ($savedForm != 'generalPageConfig') ? ' hidden' : '';
?>  
<div class="block<?php echo $hidden; ?>">
  <h1><a href="#"><?php echo $langFile['PAGESETUP_PAGES_TITLE_PAGESETTINGS']; ?></a></h1>
  <div class="content">
    <table>
     
      <colgroup>
      <col class="left">
      </colgroup>
      
      <tbody>
        <tr><td class="left checkboxes">
        <input type="checkbox" id="cfg_setStartPage" name="cfg_setStartPage" value="true" class="toolTip" title="<?php echo $langFile['PAGESETUP_PAGES_TEXT_SETSTARTPAGE'].'::'.$langFile['PAGESETUP_PAGES_TIP_SETSTARTPAGE']; ?>"<?php if($adminConfig['setStartPage']) echo ' checked="checked"'; ?>>
        </td><td class="right checkboxes">
        <label for="cfg_setStartPage"><span class="toolTip" title="<?php echo $langFile['PAGESETUP_PAGES_TEXT_SETSTARTPAGE'].'::'.$langFile['PAGESETUP_PAGES_TIP_SETSTARTPAGE']; ?>"><?php echo $langFile['PAGESETUP_PAGES_TEXT_SETSTARTPAGE']; ?></span></label>
        </td></tr>

        <tr><td class="spacer checkboxes"></td><td>

        <tr><td class="left checkboxes">
        <input type="checkbox" id="cfg_multiLanguageWebsite" name="cfg_multiLanguageWebsite" value="true" <?php if($adminConfig['multiLanguageWebsite']['active']) echo ' checked="checked"'; ?> class="toolTip" title="<?php echo $langFile['PAGESETUP_PAGES_TEXT_MULTILANGUAGEWEBSITE'].'::'.$langFile['PAGESETUP_PAGES_TIP_MULTILANGUAGEWEBSITE'] ; ?>">
        </td><td class="right checkboxes">
        <label for="cfg_multiLanguageWebsite" class="toolTip" title="<?php echo $langFile['PAGESETUP_PAGES_TEXT_MULTILANGUAGEWEBSITE'].'::'.$langFile['PAGESETUP_PAGES_TIP_MULTILANGUAGEWEBSITE'] ; ?>"><?php echo $langFile['PAGESETUP_PAGES_TEXT_MULTILANGUAGEWEBSITE']; ?></label>
        </td></tr>

        <!-- Website Language Selection -->
        <tr><td class="left checkboxes">
        </td><td class="right checkboxes">
        <select id="cfg_websiteLanguageChoices" name="cfg_websiteLanguageChoices[]" multiple="multiple"<?php if(!$adminConfig['multiLanguageWebsite']['active']) echo ' disabled="disabled"'; ?> class="toolTip" title="<?php echo '::'.$langFile['PAGESETUP_PAGES_TIP_MULTILANGUAGEWEBSITE'] ; ?>">
        <?php
          foreach($languageNames as $langKey => $langValue) {
            if(!in_array($langKey, $adminConfig['multiLanguageWebsite']['languages']))
              echo '<option value="'.$langKey.'">'.$langValue.'</option>';    
          }
        ?>
        </select>
        <select id="cfg_websiteLanguages" name="cfg_websiteLanguages[]" multiple="multiple"<?php if(!$adminConfig['multiLanguageWebsite']['active']) echo ' disabled="disabled"'; ?>>
        <?php
          if(!empty($adminConfig['multiLanguageWebsite']['languages'])) {
            foreach($adminConfig['multiLanguageWebsite']['languages'] as $langKey) {
              echo '<option value="'.$langKey.'" selected="selected">'.$languageNames[$langKey].'</option>';  
            }
          }
        ?>
        </select>
        </td></tr>

        <!-- Websites Main Language -->
        <tr id="websiteMainLanguageTr"<?php if(empty($adminConfig['multiLanguageWebsite']['languages'])) echo ' style="display:none;"'; ?>><td class="left checkboxes">
        <label for="cfg_multiLanguageWebsite"><span class="toolTip" title="<?php echo $langFile['PAGESETUP_PAGES_TEXT_MAINLANGUAGE'].'::'.$langFile['PAGESETUP_PAGES_TIP_MAINLANGUAGE']; ?>"><?php echo $langFile['PAGESETUP_PAGES_TEXT_MAINLANGUAGE']; ?></span></label>
        </td><td class="right checkboxes">
        <select id="cfg_websiteMainLanguage" name="cfg_websiteMainLanguage"<?php if(!$adminConfig['multiLanguageWebsite']['active']) echo ' disabled="disabled"'; ?> class="toolTip" title="<?php echo $langFile['PAGESETUP_PAGES_TEXT_MAINLANGUAGE'].'::'.$langFile['PAGESETUP_PAGES_TIP_MAINLANGUAGE']; ?>">
        <?php
          foreach($adminConfig['multiLanguageWebsite']['languages'] as $langKey) {
            $selected = ($langKey == $adminConfig['multiLanguageWebsite']['mainLanguage']) ? ' selected="selected"' : '' ;
            echo '<option value="'.$langKey.'"'.$selected.'>'.$languageNames[$langKey].'</option>';    
          }
        ?></select>
        </td></tr>

        <tr><td class="spacer checkboxes"></td><td>
      </tbody>
    </table>
    
    <!--<input type="reset" value="" class="button cancel" title="<?php echo $langFile['FORM_BUTTON_CANCEL']; ?>">-->
    <input type="submit" value="" class="button submit center" title="<?php echo $langFile['FORM_BUTTON_SUBMIT']; ?>" onclick="$('savedBlock').value = 'generalPageConfig'; submitAnchor('pageSettingsForm','generalPageConfig');">
  </div>
  <div class="bottom"></div>
</div>

<!-- THUMBNAIL SETTINGS -->
<a id="thumbnailSettings" class="anchorTarget"></a>
<?php
// shows the block below if it is the ones which is saved before
$hidden = ($savedForm != 'thumbnailSettings') ? ' hidden' : '';
?>
<div class="block<?php echo $hidden; ?>">
  <h1><a href="#"><?php echo $langFile['adminSetup_thumbnailSettings_h1']; ?></a></h1>
  <div class="content">
    <table>
     
      <colgroup>
      <col class="left">
      </colgroup>
    
      <tbody>
        <tr><td class="leftTop"></td><td></td></tr>
        
        <!-- THUMB WIDTH -->
        <tr><td class="left">
        <label for="cfg_thumbWidth"><span class="toolTip" title="<?php echo $langFile['THUMBNAIL_TOOLTIP_WIDTH'] ?>">
        <?php echo $langFile['THUMBNAIL_TEXT_WIDTH'] ?></span></label>
        </td><td class="right">
          <input type="number" step="1" min="0" id="cfg_thumbWidth" name="cfg_thumbWidth" class="short" value="<?php echo $adminConfig['pageThumbnail']['width']; ?>" <?php if($adminConfig['pageThumbnail']['ratio'] == 'y') echo ' disabled="disabled"'; ?>>
          <?php echo $langFile['THUMBNAIL_TEXT_UNIT']; ?>
          &nbsp;&nbsp;&nbsp;&nbsp;
          <input type="radio" id="ratioX" name="cfg_thumbRatio" value="x"<?php if($adminConfig['pageThumbnail']['ratio'] == 'x') echo ' checked="checked"'; ?>>
          <label for="ratioX" class="toolTip" title="<?php echo $langFile['THUMBNAIL_TOOLTIP_KEEPRATIO_X']; ?>::"> <?php echo $langFile['THUMBNAIL_TEXT_KEEPRATIO']; ?></label>
        </td></tr>
        
        <!-- shows the width in a scale -->
        <?php
        if(!empty($adminConfig['pageThumbnail']['width']))
          $style_thumbWidth = 'width:'.$adminConfig['pageThumbnail']['width'].'px;';
        else
          $style_thumbWidth = 'width:0px;';
        ?>
        <tr><td class="left">
        </td><td class="right">
        <div id="thumbWidthScale" class="scale" style="<?php echo $style_thumbWidth; ?>max-width:520px;">
          <div></div>
        </div>
        </td></tr>
        
        <!-- THUMB HEIGHT -->
        <tr><td class="left">
        <label for="cfg_thumbHeight"><span class="toolTip" title="<?php echo $langFile['THUMBNAIL_TOOLTIP_HEIGHT'] ?>">
        <?php echo $langFile['THUMBNAIL_TEXT_HEIGHT'] ?></span></label>
        </td><td class="right">
          <input type="number" step="1" min="0" id="cfg_thumbHeight" name="cfg_thumbHeight" class="short" value="<?php echo $adminConfig['pageThumbnail']['height']; ?>" <?php if($adminConfig['pageThumbnail']['ratio'] == 'x') echo ' disabled="disabled"'; ?>>
          <?php echo $langFile['THUMBNAIL_TEXT_UNIT']; ?>
          &nbsp;&nbsp;&nbsp;&nbsp;
          <input type="radio" id="ratioY" name="cfg_thumbRatio" value="y"<?php if($adminConfig['pageThumbnail']['ratio'] == 'y') echo ' checked="checked"'; ?>>
          <label for="ratioY" class="toolTip" title="<?php echo $langFile['THUMBNAIL_TOOLTIP_KEEPRATIO_Y']; ?>::"> <?php echo $langFile['THUMBNAIL_TEXT_KEEPRATIO']; ?></label>
        </td></tr>
        
        <!-- shows the height in a scale -->
        <?php
        if(!empty($adminConfig['pageThumbnail']['height']))
          $style_thumbHeight = 'width:'.$adminConfig['pageThumbnail']['height'].'px;';
        else
          $style_thumbHeight = 'width:0px;';
        ?>
        <tr><td class="left leftBottom">
        </td><td class="right">
        <div id="thumbHeightScale" class="scale" style="<?php echo $style_thumbHeight; ?>max-width:520px;"><div></div></div>
        </td></tr>
        
        <!-- NO THUMB RATIO -->
        <tr><td class="left checkboxes">
        <input type="radio" id="noRatio" name="cfg_thumbRatio" value=""<?php if($adminConfig['pageThumbnail']['ratio'] == '') echo ' checked="checked"'; ?>>
        </td><td class="right checkboxes">
        <label for="noRatio" class="toolTip" title="<?php echo $langFile['THUMBNAIL_TOOLTIP_FIXEDRATIO']; ?>::"> <?php echo $langFile['THUMBNAIL_TEXT_FIXEDRATIO']; ?></label>
        </td></tr>
        
        <tr><td class="spacer checkboxes"></td><td>
        
        <tr><td class="leftTop"></td><td>
        
        <!-- THUMB PATH -->
        <tr><td class="left">
        <label for="cfg_thumbPath"><span class="toolTip" title="<?php echo $langFile['adminSetup_thumbnailSettings_field3'].'::'.$langFile['adminSetup_thumbnailSettings_field3_tip'] ?>">
        <?php echo $langFile['adminSetup_thumbnailSettings_field3'] ?></span></label>
        </td><td class="right">
        <input style="width:auto;" readonly="readonly" size="<?php echo strlen($adminConfig['uploadPath'])+5; ?>" value="<?php echo $adminConfig['uploadPath']; ?>" class="toolTip" title="<?php echo $langFile['adminSetup_thumbnailSettings_field3_inputTip1']; ?>">
        <input id="cfg_thumbPath" name="cfg_thumbPath" style="width:150px;" value="<?php echo $adminConfig['pageThumbnail']['path']; ?>" class="toolTip" title="<?php echo sprintf($langFile['adminSetup_thumbnailSettings_field3_inputTip2'],$adminConfig['uploadPath']); ?>">
        </td></tr>
        
              
        <tr><td class="leftBottom"></td><td></td></tr>
      </tbody>
    </table>
    
    <!--<input type="reset" value="" class="button cancel" title="<?php echo $langFile['FORM_BUTTON_CANCEL']; ?>">-->
    <input type="submit" value="" class="button submit center" title="<?php echo $langFile['FORM_BUTTON_SUBMIT']; ?>" onclick="$('savedBlock').value = 'thumbnailSettings'; submitAnchor('pageSettingsForm','thumbnailSettings');">
  </div>
  <div class="bottom"></div>
</div>

<!-- NON CATEGORY PAGES CONFIG -->
<a id="nonCategoryPages" class="anchorTarget"></a>
<?php
// shows the block below if it is the ones which is saved before
$hidden = ($savedForm !== false && $savedForm != 'nonCategoryPages') ? ' hidden' : '';
?>  
<div class="block<?php echo $hidden; ?>">
  <h1><a href="#"><?php echo $langFile['PAGESETUP_PAGES_TITLE_NONCATEGORYPAGES']; ?></a></h1>
  <div class="content">
    <table>
     
      <colgroup>
      <col class="left">
      </colgroup>  
      
      <tbody>
        <tr><td class="left checkboxes">
        <input type="checkbox" id="cfg_pageCreatePages" name="cfg_pageCreatePages" value="true" class="toolTip" title="<?php echo $langFile['PAGESETUP_PAGES_TEXT_CREATEPAGES'].'::'.$langFile['PAGESETUP_PAGES_TIP_CREATEPAGES']; ?>"<?php if($adminConfig['pages']['createDelete']) echo ' checked="checked"'; ?>><br>
        </td><td class="right checkboxes">
        <label for="cfg_pageCreatePages"><span class="toolTip" title="<?php echo $langFile['PAGESETUP_PAGES_TEXT_CREATEPAGES'].'::'.$langFile['PAGESETUP_PAGES_TIP_CREATEPAGES']; ?>"><?php echo $langFile['PAGESETUP_PAGES_TEXT_CREATEPAGES']; ?></span></label><br>
        </td></tr>
        
        <tr><td class="left checkboxes">
        <input type="checkbox" id="cfg_pageThumbnailUpload" name="cfg_pageThumbnailUpload" value="true" class="toolTip" title="<?php echo $langFile['PAGESETUP_PAGES_TEXT_UPLOADTHUMBNAILS'].'::'.$langFile['PAGESETUP_PAGES_TIP_UPLOADTHUMBNAILS']; ?>"<?php if($adminConfig['pages']['thumbnails']) echo ' checked="checked"'; ?>><br>
        </td><td class="right checkboxes">
        <label for="cfg_pageThumbnailUpload"><span class="toolTip" title="<?php echo $langFile['PAGESETUP_PAGES_TEXT_UPLOADTHUMBNAILS'].'::'.$langFile['PAGESETUP_PAGES_TIP_UPLOADTHUMBNAILS']; ?>"><?php echo $langFile['PAGESETUP_PAGES_TEXT_UPLOADTHUMBNAILS']; ?></span></label><br>
        </td></tr>
        
        <tr><td class="left checkboxes">
        <input type="checkbox" id="cfg_pageTags" name="cfg_pageTags" value="true" class="toolTip" title="<?php echo $langFile['PAGESETUP_PAGES_TEXT_EDITTAGS'].'::'.$langFile['PAGESETUP_PAGES_TIP_EDITTAGS']; ?>"<?php if($adminConfig['pages']['showTags']) echo ' checked="checked"'; ?>>
        </td><td class="right checkboxes">
        <label for="cfg_pageTags"><span class="toolTip" title="<?php echo $langFile['PAGESETUP_PAGES_TEXT_EDITTAGS'].'::'.$langFile['PAGESETUP_PAGES_TIP_EDITTAGS']; ?>"><?php echo $langFile['PAGESETUP_PAGES_TEXT_EDITTAGS']; ?></span></label>
        </td></tr>
        
        <tr><td class="left checkboxes">
        <input type="checkbox" id="cfg_pagePageDate" name="cfg_pagePageDate" value="true" class="toolTip" title="<?php echo $langFile['PAGESETUP_TEXT_EDITPAGEDATE'].'::'.$langFile['PAGESETUP_TIP_EDITPAGEDATE']; ?>"<?php if($adminConfig['pages']['showPageDate']) echo ' checked="checked"'; ?>>
        </td><td class="right checkboxes">
        <label for="cfg_pagePageDate"><span class="toolTip" title="<?php echo $langFile['PAGESETUP_TEXT_EDITPAGEDATE'].'::'.$langFile['PAGESETUP_TIP_EDITPAGEDATE']; ?>"><?php echo $langFile['PAGESETUP_TEXT_EDITPAGEDATE']; ?></span></label>
        </td></tr>
        
        <tr><td class="left checkboxes">
        <input type="checkbox" id="cfg_pagefeeds" name="cfg_pagefeeds" value="true" class="toolTip" title="<?php echo $langFile['PAGESETUP_TEXT_FEEDS'].'::'.$langFile['PAGESETUP_TIP_FEEDS']; ?>"<?php if($adminConfig['pages']['feeds']) echo ' checked="checked"'; ?>>
        </td><td class="right checkboxes">
        <label for="cfg_pagefeeds"><span class="toolTip" title="<?php echo $langFile['PAGESETUP_TEXT_FEEDS'].'::'.$langFile['PAGESETUP_TIP_FEEDS']; ?>"><?php echo $langFile['PAGESETUP_TEXT_FEEDS']; ?></span></label>
        </td></tr>

        <tr><td class="left checkboxes">
        <input type="checkbox" id="cfg_subCategory" name="cfg_subCategory" value="true" class="toolTip" title="<?php echo $langFile['PAGESETUP_TEXT_SUBCATEGORY'].'::'.$langFile['PAGESETUP_TIP_SUBCATEGORY']; ?>"<?php if($adminConfig['pages']['showSubCategory']) echo ' checked="checked"'; ?>>
        </td><td class="right checkboxes">
        <label for="cfg_subCategory"><span class="toolTip" title="<?php echo $langFile['PAGESETUP_TEXT_SUBCATEGORY'].'::'.$langFile['PAGESETUP_TIP_SUBCATEGORY']; ?>"><?php echo $langFile['PAGESETUP_TEXT_SUBCATEGORY']; ?></span></label>
        </td></tr>
        
        <tr><td class="spacer checkboxes"></td><td></td></tr>

        <!-- SORTING -->
        <!-- manually -->
        <tr><td class="left checkboxes">
        <input type="radio" id="cfg_pageSortManually" name="cfg_pageSorting" value="manually" class="toolTip" title="<?php echo $langFile['PAGESETUP_TEXT_SORTMANUALLY'].'::'.$langFile['PAGESETUP_TIP_SORTMANUALLY']; ?>"<?php if($adminConfig['pages']['sorting'] == 'manually' || empty($adminConfig['pages']['sorting'])) echo ' checked="checked"'; ?>>
        </td><td class="right checkboxes">
        <label for="cfg_pageSortManually"><span class="toolTip" title="<?php echo $langFile['PAGESETUP_TEXT_SORTMANUALLY'].'::'.$langFile['PAGESETUP_TIP_SORTMANUALLY'] ?>"><?php echo $langFile['PAGESETUP_TEXT_SORTMANUALLY']; ?></span></label>          
        </td></tr>
        <!-- sort by date    -->
        <tr><td class="left checkboxes">
        <input type="radio" id="cfg_pageSortByPageDate" name="cfg_pageSorting" value="byPageDate" class="toolTip" title="<?php echo $langFile['PAGESETUP_TIP_SORTBYPAGEDATE'].'::'.$langFile['PAGESETUP_TIP_SORTBYDATE']; ?>"<?php if($adminConfig['pages']['sorting'] == 'byPageDate') echo ' checked="checked"'; ?>>
        </td><td class="right checkboxes">
        <label for="cfg_pageSortByPageDate"><span class="toolTip" title="<?php echo $langFile['PAGESETUP_TIP_SORTBYPAGEDATE'].'::'.$langFile['PAGESETUP_TIP_SORTBYDATE'] ?>"><?php echo $langFile['PAGESETUP_TIP_SORTBYPAGEDATE']; ?></span></label>          
        </td></tr>
        <!-- sort alphabetical -->
        <tr><td class="left checkboxes">
        <input type="radio" id="cfg_pageSortAlphabetical" name="cfg_pageSorting" value="alphabetical" class="toolTip" title="<?php echo $langFile['PAGESETUP_TEXT_SORTALPHABETICAL'].'::'.$langFile['PAGESETUP_TIP_SORTALPHABETICAL']; ?>"<?php if($adminConfig['pages']['sorting'] == 'alphabetical') echo ' checked="checked"'; ?>>
        </td><td class="right checkboxes">
        <label for="cfg_pageSortAlphabetical"><span class="toolTip" title="<?php echo $langFile['PAGESETUP_TEXT_SORTALPHABETICAL'].'::'.$langFile['PAGESETUP_TIP_SORTALPHABETICAL'] ?>"><?php echo $langFile['PAGESETUP_TEXT_SORTALPHABETICAL']; ?></span></label>          
        </td></tr>

        <!-- sortReverse -->
        <tr><td class="left checkboxes">
        <input type="checkbox" id="cfg_pageSortReverse" name="cfg_pageSortReverse" value="true" class="toolTip" title="<?php echo $langFile['PAGESETUP_TEXT_SORTREVERSE'].'::'.$langFile['PAGESETUP_TIP_SORTREVERSE']; ?>"<?php if($adminConfig['pages']['sortReverse']) echo ' checked="checked"'; ?>>
        </td><td class="right checkboxes">
        <label for="cfg_pageSortReverse"><span class="toolTip" title="<?php echo $langFile['PAGESETUP_TEXT_SORTREVERSE'].'::'.$langFile['PAGESETUP_TIP_SORTREVERSE'] ?>"><?php echo $langFile['PAGESETUP_TEXT_SORTREVERSE']; ?></span></label>          
        </td></tr>
        
        <?php if(!empty($plugins)) { ?>
        <tr><td class="leftTop"></td><td>
        
        <tr><td class="left">
        <label for="cfg_pagePlugins"><span class="toolTip" title="<?php echo $langFile['PAGESETUP_CATEGORY_TEXT_ACTIVATEPLUGINS'].'::' ?>">
        <?php echo $langFile['PAGESETUP_CATEGORY_TEXT_ACTIVATEPLUGINS'] ?></span></label>
        </td><td class="right">
        <select id="cfg_pagePlugins" name="cfg_pagePlugins[]" multiple="multiple">
          <?php
          foreach($plugins as $pluginName) {
            $selected = (in_array($pluginName,unserialize($adminConfig['pages']['plugins']))) ? ' selected="selected"' : '' ;
            echo '<option value="'.$pluginName.'"'.$selected.'>'.$pluginName.'</option>';    
          }
          ?>
        </select>
        &nbsp;
        <span class="hint"><?php echo $langFile['PAGESETUP_CATEGORY_HINT_ACTIVATEPLUGINS'] ?></span>
        </td></tr>
        
        <tr><td class="leftBottom"></td><td>
        <?php } ?>
      </tbody>
    </table>
    
    <!--<input type="reset" value="" class="button cancel" title="<?php echo $langFile['FORM_BUTTON_CANCEL']; ?>">-->
    <input type="submit" value="" class="button submit center" title="<?php echo $langFile['FORM_BUTTON_SUBMIT']; ?>" onclick="$('savedBlock').value = 'nonCategoryPages'; submitAnchor('pageSettingsForm','nonCategoryPages');">
  </div>
  <div class="bottom"></div>
</div>

</form>

<!-- CATEGORIES SETTINGS -->

<form action="index.php?site=pageSetup" id="categoriesForm" method="post" enctype="multipart/form-data" accept-charset="UTF-8">
  <div>
  <input type="hidden" name="send" value="categorySetup">
  <input type="hidden" name="savedCategory" id="savedCategory" value="">
  <input type="hidden" name="websiteLanguage" value="<?php echo $_SESSION['feinduraSession']['websiteLanguage']; ?>">
  </div>

<div class="block">
  <h1><?php echo $langFile['PAGESETUP_CATEGORY_TITLE_CATEGORIES']; ?></h1>
  <div class="content">
  
    <table>     
      <colgroup>
      <col class="left">
      </colgroup>
      
      <tbody>
        <tr><td class="leftTop"></td><td></td></tr>

        <tr><td class="left">
          <a href="?site=pageSetup&amp;status=createCategory#category<?php echo getNewCatgoryId(); ?>" class="createCategory toolTip" title="<?php echo $langFile['PAGESETUP_CATEGORY_TEXT_CREATECATEGORY']; ?>::"></a>
        </td><td class="right">
        <br>
        <?php
        // user info          
        if($categoryInfo)
          echo '<span class="hint"><b>'.$categoryInfo.'</b></span>';
        ?>
        </td></tr>
        
        <tr><td class="leftBottom"></td><td></td></tr>
      </tbody>
    </table>
    <?php        

      // lists the categories
      if(is_array($categoryConfig)) {
        $lastCategory = end($categoryConfig);
        $firstCategory = reset($categoryConfig);
        $autoFocusFirst = true;
        
        foreach($categoryConfig as $category) {
        
          // prevent using the $check vars from the last category
          unset($checked);
          
          // checks the category settings
          $checked[1]  = ($category['public']) ? 'checked="checked"' : '';
          
          $checked[2]  = ($category['createDelete']) ? 'checked="checked"' : '';
          
          $checked[3]  = ($category['thumbnail']) ? 'checked="checked"' : '';
          
          $checked[11] = ($category['plugins']) ? 'checked="checked"' : '';
          
          $checked[4]  = ($category['showTags']) ? 'checked="checked"' : ''; 
          
          $checked[5]  = ($category['showPageDate']) ? 'checked="checked"' : '';
          
          $checked[13] = ($category['showSubCategory']) ? 'checked="checked"' : '';
          
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
          
          // slide container (help for the javascript to find the right elements)
          echo '<div class="categoryConfig">';

          // --------------------------------------
          // first TABLE (normal category settings)
          echo '<table>     
                <colgroup>
                <col class="left">
                </colgroup>
                <tbody>';
                
          // category anchor
          echo '<tr><td class="leftTop">
                <a name="category'.$category['id'].'" id="categoryAnchor'.$category['id'].'" class="anchorTarget"></a>
                </td><td></td></tr>';
          
          // category NAME
          $categoryName = GeneralFunctions::getLocalized($category['localized'],'name',true);
          $autofocus = '';
          // change to "unnamed category" if text is missing
          if(empty($categoryName)) {
            $categoryName = '<i>'.$langFile['PAGESETUP_CATEGORY_TEXT_CREATECATEGORY_UNNAMED'].'</i>';
            if($autoFocusFirst) {
              $autofocus = ' autofocus="autofocus"';
              $autoFocusFirst = false;
            }
          }
          
          echo '<tr><td class="left">';
          echo '<span style="font-size:20px;font-weight:bold;">'.$categoryName.'</span><br>ID '.$category['id'];
          echo '<input type="hidden" name="categories['.$category['id'].'][id]" value="'.$category['id'].'">';
          echo '</td>'; 
          
                // deleteCategory
          echo '<td class="right" style="width:525px;">
                <div style="border-bottom: 1px dotted #cccccc;width:400px;height:15px;float:left !important;"></div>
                <a href="?site=pageSetup&amp;status=deleteCategory&amp;category='.$category['id'].'#categories" class="deleteCategory toolTip" onclick="openWindowBox(\'library/views/windowBox/deleteCategory.php?status=deleteCategory&amp;category='.$category['id'].'\',\''.$langFile['PAGESETUP_CATEGORY_TEXT_DELETECATEGORY'].'\');return false;" title="'.$langFile['PAGESETUP_CATEGORY_TEXT_DELETECATEGORY'].'::'.GeneralFunctions::getLocalized($category['localized'],'name',true).'[br][br][span style=color:#990000;]'.$langFile['PAGESETUP_CATEGORY_TEXT_DELETECATEGORY_WARNING'].'[/span]"></a>';          
          echo '</td></tr>';
                // category name
          echo '<tr><td class="left">
                <label for="categories'.$category['id'].'name">'.$langFile['PAGESETUP_CATEGORY_TEXT_CATEGORYNAME'].'</label>
                </td><td class="right">
                <input id="categories'.$category['id'].'name" name="categories['.$category['id'].'][name]" value="'.GeneralFunctions::getLocalized($category['localized'],'name',true).'"'.$autofocus.'>
                </td></tr>';
          
          echo '<tr><td class="leftBottom"></td><td>';
          
          // category up / down               
          if(count($categoryConfig) > 1) {
          
            if($firstCategory['id'] != $category['id'])
              echo '<a href="?site=pageSetup&amp;status=moveCategoryUp&amp;category='.$category['id'].'&amp;load='.rand(0,999).'#category'.$category['id'].'" class="categoryUp toolTip" title="'.$langFile['PAGESETUP_CATEGORY_TIP_MOVECATEGORY_UP'].'::"></a>';
            if($lastCategory['id'] != $category['id'])
              echo '<a href="?site=pageSetup&amp;status=moveCategoryDown&amp;category='.$category['id'].'&amp;load='.rand(0,999).'#category'.$category['id'].'" class="categoryDown toolTip" title="'.$langFile['PAGESETUP_CATEGORY_TIP_MOVECATEGORY_DOWN'].'::"></a>';
          }
          
          echo '</td></tr>';
                    
               // category SETTINGS
          echo '<tr><td class="left checkboxes">
                <input type="checkbox" id="categories'.$category['id'].'public" name="categories['.$category['id'].'][public]" value="true" '.$checked[1].' class="toolTip" title="'.$langFile['PAGESETUP_CATEGORY_TEXT_CATEGORYSTATUS'].'::'.$langFile['PAGESETUP_CATEGORY_TIP_CATEGORYSTATUS'].'"><br>
                </td><td class="right checkboxes">
                <label for="categories'.$category['id'].'public">';          
                $publicSignStyle = ' style="position:relative; top:-3px; float:left;"';        
                // shows the public or unpublic picture
                if($checked[1])
                  echo '<img src="library/images/icons/category_public.png" class="toolTip" title="'.$langFile['STATUS_CATEGORY_PUBLIC'].'"'.$publicSignStyle.' alt="public" width="27" height="27">&nbsp;';
                else
                  echo '<img src="library/images/icons/category_nonpublic.png" class="toolTip" title="'.$langFile['STATUS_CATEGORY_NONPUBLIC'].'"'.$publicSignStyle.' alt="nonpublic" width="27" height="27">&nbsp;';
                
                echo '<span class="toolTip" title="'.$langFile['PAGESETUP_CATEGORY_TEXT_CATEGORYSTATUS'].'::'.$langFile['PAGESETUP_CATEGORY_TIP_CATEGORYSTATUS'].'">'.$langFile['PAGESETUP_CATEGORY_TEXT_CATEGORYSTATUS'].'</span></label>
                </td></tr>';
                          
          echo '<tr><td class="spacer checkboxes"></td><td></td></tr>';
                
          echo '<tr><td class="left checkboxes">
                <input type="checkbox" id="categories'.$category['id'].'createDelete" name="categories['.$category['id'].'][createDelete]" value="true" '.$checked[2].' class="toolTip" title="'.$langFile['PAGESETUP_CATEGORY_TEXT_CREATEPAGES'].'::'.$langFile['PAGESETUP_CATEGORY_TIP_CREATEPAGES'].'"><br>
                </td><td class="right checkboxes">
                <label for="categories'.$category['id'].'createDelete"><span class="toolTip" title="'.$langFile['PAGESETUP_CATEGORY_TEXT_CREATEPAGES'].'::'.$langFile['PAGESETUP_CATEGORY_TIP_CREATEPAGES'].'">'.$langFile['PAGESETUP_CATEGORY_TEXT_CREATEPAGES'].'</span></label>
                </td></tr>';          
          
          echo '<tr><td class="left checkboxes">
                <input type="checkbox" id="categories'.$category['id'].'thumbnail" name="categories['.$category['id'].'][thumbnail]" value="true" '.$checked[3].' class="toolTip" title="'.$langFile['PAGESETUP_CATEGORY_TEXT_UPLOADTHUMBNAILS'].'::'.$langFile['PAGESETUP_CATEGORY_TIP_UPLOADTHUMBNAILS'].'"><br>                
                </td><td class="right checkboxes">
                <label for="categories'.$category['id'].'thumbnail"><span class="toolTip" title="'.$langFile['PAGESETUP_CATEGORY_TEXT_UPLOADTHUMBNAILS'].'::'.$langFile['PAGESETUP_CATEGORY_TIP_UPLOADTHUMBNAILS'].'">'.$langFile['PAGESETUP_CATEGORY_TEXT_UPLOADTHUMBNAILS'].'</span></label>             
                </td></tr>';
          
          echo '<tr><td class="left checkboxes">
                <input type="checkbox" id="categories'.$category['id'].'showTags" name="categories['.$category['id'].'][showTags]" value="true" '.$checked[4].' class="toolTip" title="'.$langFile['PAGESETUP_CATEGORY_TEXT_EDITTAGS'].'::'.$langFile['PAGESETUP_CATEGORY_TIP_EDITTAGS'].'"><br>
                </td><td class="right checkboxes">
                <label for="categories'.$category['id'].'showTags"><span class="toolTip" title="'.$langFile['PAGESETUP_CATEGORY_TEXT_EDITTAGS'].'::'.$langFile['PAGESETUP_CATEGORY_TIP_EDITTAGS'].'">'.$langFile['PAGESETUP_CATEGORY_TEXT_EDITTAGS'].'</span></label>
                </td></tr>';

          echo '<tr><td class="left checkboxes">
                <input type="checkbox" id="categories'.$category['id'].'showPageDate" name="categories['.$category['id'].'][showPageDate]" value="true" '.$checked[5].' class="toolTip" title="'.$langFile['PAGESETUP_TEXT_EDITPAGEDATE'].'::'.$langFile['PAGESETUP_TIP_EDITPAGEDATE'].'"><br>
                </td><td class="right checkboxes">
                <label for="categories'.$category['id'].'showPageDate"><span class="toolTip" title="'.$langFile['PAGESETUP_TEXT_EDITPAGEDATE'].'::'.$langFile['PAGESETUP_TIP_EDITPAGEDATE'].'">'.$langFile['PAGESETUP_TEXT_EDITPAGEDATE'].'</span></label>
                </td></tr>';
          
          echo '<tr><td class="left checkboxes">
                <input type="checkbox" id="categories'.$category['id'].'feeds" name="categories['.$category['id'].'][feeds]" value="true" '.$checked[12].' class="toolTip" title="'.$langFile['PAGESETUP_TEXT_FEEDS'].'::'.$langFile['PAGESETUP_CATEGORY_TIP_FEEDS'].'"><br>
                </td><td class="right checkboxes">
                <label for="categories'.$category['id'].'feeds"><span class="toolTip" title="'.$langFile['PAGESETUP_TEXT_FEEDS'].'::'.$langFile['PAGESETUP_CATEGORY_TIP_FEEDS'].'">'.$langFile['PAGESETUP_TEXT_FEEDS'].'</span></label>
                </td></tr>';

          echo '<tr><td class="left checkboxes">
                <input type="checkbox" id="categories'.$category['id'].'subCategory" name="categories['.$category['id'].'][showSubCategory]" value="true" '.$checked[13].' class="toolTip" title="'.$langFile['PAGESETUP_TEXT_SUBCATEGORY'].'::'.$langFile['PAGESETUP_TIP_SUBCATEGORY'].'">
                </td><td class="right checkboxes">
                <label for="categories'.$category['id'].'subCategory"><span class="toolTip" title="'.$langFile['PAGESETUP_TEXT_SUBCATEGORY'].'::'.$langFile['PAGESETUP_TIP_SUBCATEGORY'].'">'.$langFile['PAGESETUP_TEXT_SUBCATEGORY'].'</span></label>
                </td></tr>';

          echo '<tr><td class="spacer checkboxes"></td><td></td></tr>';          
          
          // SORTING
          // manually
          echo '<tr><td class="left checkboxes">
                <input type="radio" id="categories'.$category['id'].'manually" name="categories['.$category['id'].'][sorting]" value="manually" '.$checked[71].' class="toolTip" title="'.$langFile['PAGESETUP_TEXT_SORTMANUALLY'].'::'.$langFile['PAGESETUP_TIP_SORTMANUALLY'].'">
                </td><td class="right checkboxes">
                <label for="categories'.$category['id'].'manually"><span class="toolTip" title="'.$langFile['PAGESETUP_TEXT_SORTMANUALLY'].'::'.$langFile['PAGESETUP_TIP_SORTMANUALLY'].'">'.$langFile['PAGESETUP_TEXT_SORTMANUALLY'].'</span></label>          
                </td></tr>';
          // sort by date   
          echo '<tr><td class="left checkboxes">
                <input type="radio" id="categories'.$category['id'].'sortByPageDate" name="categories['.$category['id'].'][sorting]" value="byPageDate" '.$checked[72].' class="toolTip" title="'.$langFile['PAGESETUP_TIP_SORTBYPAGEDATE'].'::'.$langFile['PAGESETUP_TIP_SORTBYDATE'].'">
                </td><td class="right checkboxes">
                <label for="categories'.$category['id'].'sortByPageDate"><span class="toolTip" title="'.$langFile['PAGESETUP_TIP_SORTBYPAGEDATE'].'::'.$langFile['PAGESETUP_TIP_SORTBYDATE'].'">'.$langFile['PAGESETUP_TIP_SORTBYPAGEDATE'].'</span></label>          
                </td></tr>';
          // sort alphabetical
          echo '<tr><td class="left checkboxes">
                <input type="radio" id="categories'.$category['id'].'sortAlphabetical" name="categories['.$category['id'].'][sorting]" value="alphabetical" '.$checked[73].' class="toolTip" title="'.$langFile['PAGESETUP_TEXT_SORTALPHABETICAL'].'::'.$langFile['PAGESETUP_TIP_SORTALPHABETICAL'].'">
                </td><td class="right checkboxes">
                <label for="categories'.$category['id'].'sortAlphabetical"><span class="toolTip" title="'.$langFile['PAGESETUP_TEXT_SORTALPHABETICAL'].'::'.$langFile['PAGESETUP_TIP_SORTALPHABETICAL'].'">'.$langFile['PAGESETUP_TEXT_SORTALPHABETICAL'].'</span></label>          
                </td></tr>';
          
          // sortReverse
          echo '<tr><td class="left checkboxes">
                <input type="checkbox" id="categories'.$category['id'].'sortReverse" name="categories['.$category['id'].'][sortReverse]" value="true" '.$checked[6].' class="toolTip" title="'.$langFile['PAGESETUP_TEXT_SORTREVERSE'].'::'.$langFile['PAGESETUP_TIP_SORTREVERSE'].'">
                </td><td class="right checkboxes">
                <label for="categories'.$category['id'].'sortReverse"><span class="toolTip" title="'.$langFile['PAGESETUP_TEXT_SORTREVERSE'].'::'.$langFile['PAGESETUP_TIP_SORTREVERSE'].'">'.$langFile['PAGESETUP_TEXT_SORTREVERSE'].'</span></label>          
                </td></tr>';
          
          if(!empty($plugins)) {
            echo '<tr><td class="leftTop"></td><td>';
  
            echo '<tr><td class="left">';
            echo '<label for="categories'.$category['id'].'plugins"><span class="toolTip" title="'.$langFile['PAGESETUP_CATEGORY_TEXT_ACTIVATEPLUGINS'].'::'.$langFile['PAGESETUP_CATEGORY_TIP_ACTIVATEPLUGINS'].'">';
            echo $langFile['PAGESETUP_CATEGORY_TEXT_ACTIVATEPLUGINS'].'</span></label>';
            echo '</td><td class="right">';
            echo '<select id="categories'.$category['id'].'plugins" name="categories['.$category['id'].'][plugins][]" multiple="multiple">';
              foreach($plugins as $pluginName) {
                $selected = (in_array($pluginName,unserialize($category['plugins']))) ? ' selected="selected"' : '' ;
                echo '<option value="'.$pluginName.'"'.$selected.'>'.$pluginName.'</option>';   
              }            
            echo '</select>';
            echo '&nbsp;<span class="hint">'.$langFile['PAGESETUP_CATEGORY_HINT_ACTIVATEPLUGINS'].'</span>';
            echo '</td></tr>';
            
            echo '<tr><td class="leftBottom"></td><td>';                
          }
          
          echo '<tr><td class="left checkboxes"></td>
                <td><a href="#" class="down inBlockSliderLink" style="position:relative; left:-20px; bottom: -15px;">'.$langFile['PAGESETUP_CATEGORY_TITLE_ADVANCEDSETTINGS'].'</a>
                </td></tr>';
            echo '<tr><td class="spacer checkboxes"></td><td></td></tr>';
          
          // end of the TABLE for one category
          echo '</tbody></table>';
          
          // -----------------------------------------------
          // second TABLE (advanced settings) (with slide in)
          $hidden = ($_POST['savedCategory'] != $category['id']) ? ' hidden' : '';
          
          echo '<table id="advancedConfigTable'.$category['id'].'" class="inBlockSlider'.$hidden.'">     
                <colgroup>
                <col class="left">
                </colgroup>
                
                <tbody>
                <tr><td class="leftTop"></td><td><span class="hint">'.$langFile['PAGESETUP_CATEGORY_HINT_ADVANCEDSETTINGS'].'</span></td></tr>';
          
          echo '<tr><td class="left">
                <span class="toolTip" title="'.$langFile['STYLESHEETS_TEXT_STYLEFILE'].'::'.$langFile['STYLESHEETS_TOOLTIP_STYLEFILE'].'[br][br][span class=hint]'.$langFile['PAGESETUP_CATEGORY_TIP_STYLESHEETS_EMPTY'].'[/span]">
                '.$langFile['STYLESHEETS_TEXT_STYLEFILE'].'</span>
                </td><td class="right">
                <div id="categoryStyleFilesInputs'.$category['id'].'" class="inputToolTip" title="'.$langFile['PATHS_TOOLTIP_ABSOLUTE'].'::[span class=hint]'.$langFile['PAGESETUP_CATEGORY_TIP_STYLESHEETS_EMPTY'].'[/span]">
                <span class="hint" style="float:right;width:190px;">'.$langFile['STYLESHEETS_EXAMPLE_STYLEFILE'].'</span>';
                
          echo showStyleFileInputs(GeneralFunctions::getStylesByPriority($category['styleFile'],'styleFile',$pageContent['category']),'categories['.$category['id'].'][styleFile]');

          echo '</div>
                <a href="#" class="addStyleFilePath toolTip" title="'.$langFile['STYLESHEETS_TOOLTIP_ADDSTYLEFILE'].'::"></a>              
                </td></tr>';
                
          echo '<tr><td class="left">
                <label for="categories'.$category['id'].'styleId"><span class="toolTip" title="'.$langFile['STYLESHEETS_TEXT_ID'].'::'.$langFile['STYLESHEETS_TOOLTIP_ID'].'[br][br][span class=hint]'.$langFile['PAGESETUP_CATEGORY_TIP_STYLESHEETS_EMPTY'].'[/span]">
                '.$langFile['STYLESHEETS_TEXT_ID'].'</span></label>
                </td><td class="right">
                <input id="categories'.$category['id'].'styleId" name="categories['.$category['id'].'][styleId]" value="'.GeneralFunctions::getStylesByPriority($category['styleId'],'styleId',$category['id']).'" class="inputToolTip" title="'.$langFile['PAGESETUP_CATEGORY_TIP_STYLESHEETS_EMPTY'].'">
                </td></tr>';
                
          echo '<tr><td class="left">
                <label for="categories'.$category['id'].'styleClass"><span class="toolTip" title="'.$langFile['STYLESHEETS_TEXT_CLASS'].'::'.$langFile['STYLESHEETS_TOOLTIP_CLASS'].'[br][br][span class=hint]'.$langFile['PAGESETUP_CATEGORY_TIP_STYLESHEETS_EMPTY'].'[/span]">
                '.$langFile['STYLESHEETS_TEXT_CLASS'].'</span></label>
                </td><td class="right">
                <input id="categories'.$category['id'].'styleClass" name="categories['.$category['id'].'][styleClass]" value="'.GeneralFunctions::getStylesByPriority($category['styleClass'],'styleClass',$category['id']).'" class="inputToolTip" title="'.$langFile['PAGESETUP_CATEGORY_TIP_STYLESHEETS_EMPTY'].'">
                </td></tr>';
          
          echo '<tr><td class="spacer"></td><td></td></tr>';
          
               // category thumbSize 
          echo '<tr><td class="left">
                <label for="categories'.$category['id'].'thumbWidth"><span class="toolTip" title="'.$langFile['THUMBNAIL_TOOLTIP_WIDTH'].'">
                '.$langFile['THUMBNAIL_TEXT_WIDTH'].'</span></label>
                </td><td class="right">
                <input type="number" step="1" min="0" id="categories'.$category['id'].'thumbWidth" name="categories['.$category['id'].'][thumbWidth]" class="short" value="'.$category['thumbWidth'].'" '.$disabled[9].'>
                '.$langFile['THUMBNAIL_TEXT_UNIT'].'
                  &nbsp;&nbsp;&nbsp;&nbsp;
                  <input type="radio" id="categories'.$category['id'].'ratioX" name="categories['.$category['id'].'][thumbRatio]" value="x" '.$checked[9].'>
                  <label for="categories'.$category['id'].'ratioX" class="toolTip" title="'.$langFile['THUMBNAIL_TEXT_RATIO'].'::'.$langFile['THUMBNAIL_TOOLTIP_KEEPRATIO_X'].'"> '.$langFile['THUMBNAIL_TEXT_KEEPRATIO'].'</label>
                </td></tr>';
          
                // <!-- shows the width in a scale -->
                if(!empty($category['thumbWidth']))
                  $catThumbWidth = 'width:'.$category['thumbWidth'].'px;';
                else
                  $catThumbWidth = 'width:0px;';
          echo '<tr><td class="left">
                </td><td class="right">
                <div id="categories'.$category['id'].'thumbWidthScale" class="scale" style="'.$catThumbWidth.'max-width:520px;"><div></div></div>
                </td></tr>';
              
          echo '<tr><td class="left">
                <label for="categories'.$category['id'].'thumbHeight"><span class="toolTip" title="'.$langFile['THUMBNAIL_TOOLTIP_HEIGHT'].'">
                '.$langFile['THUMBNAIL_TEXT_HEIGHT'].'</span></label>
                </td><td class="right">
                <input type="number" step="1" min="0" id="categories'.$category['id'].'thumbHeight" name="categories['.$category['id'].'][thumbHeight]" class="short" value="'.$category['thumbHeight'].'" '.$disabled[10].'>
                '.$langFile['THUMBNAIL_TEXT_UNIT'].'
                  &nbsp;&nbsp;&nbsp;&nbsp;
                  <input type="radio" id="categories'.$category['id'].'ratioY" name="categories['.$category['id'].'][thumbRatio]" value="y" '.$checked[10].'>
                  <label for="categories'.$category['id'].'ratioY" class="toolTip" title="'.$langFile['THUMBNAIL_TEXT_RATIO'].'::'.$langFile['THUMBNAIL_TOOLTIP_KEEPRATIO_Y'].'"> '.$langFile['THUMBNAIL_TEXT_KEEPRATIO'].'</label>
                </td></tr>';
                
                // <!-- shows the height in a scale -->
                if(!empty($category['thumbHeight']))
                  $catThumbHeight = 'width:'.$category['thumbHeight'].'px;';
                else
                  $catThumbHeight = 'width:0px;';
          echo '<tr><td class="left">
                </td><td class="right">
                <div id="categories'.$category['id'].'thumbHeightScale" class="scale"  style="'.$catThumbHeight.'max-width:520px;"><div></div></div>
                </td></tr>';
          
          echo '<!-- NO THUMB RATIO -->
                <tr><td class="left">
                <input type="radio" id="categories'.$category['id'].'noRatio" name="categories['.$category['id'].'][thumbRatio]" value="" '.$checked[8].'>
                </td><td class="right">
                <label for="categories'.$category['id'].'noRatio" class="toolTip" title="'.$langFile['THUMBNAIL_TEXT_RATIO'].'::'.$langFile['THUMBNAIL_TOOLTIP_FIXEDRATIO'].'"> '.$langFile['THUMBNAIL_TEXT_FIXEDRATIO'].'</label>
                </td></tr>';
          
          // finish the TABLE for one category
          echo '<tr><td class="leftBottom"></td><td></td></tr>
                </tbody>
                </table>';
          
          // SUBMIT: IF advancedConfigTable has not Class "hidden" it stores the categoryId in the savedCategory input
          // and gives the submit anchor to the FORM      
          echo '<input type="submit" value="" name="saveCategories" class="button submit center" title="'.$langFile['FORM_BUTTON_SUBMIT'].'" onclick="if(!$(\'advancedConfigTable'.$category['id'].'\').hasClass(\'hidden\')) $(\'savedCategory\').value = \''.$category['id'].'\'; submitAnchor(\'categoriesForm\',\'categoryAnchor'.$category['id'].'\');">
                </div>'; // end slide in box
          
        }
      }        
      ?>    
    <!--<input type="reset" value="" class="button cancel" title="<?php echo $langFile['FORM_BUTTON_CANCEL']; ?>">-->
    
  </div>
  <div class="bottom"></div>
</div>

</form>