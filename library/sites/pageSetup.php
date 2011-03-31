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

// CHECKs THE IF THE NECESSARY FILEs ARE WRITEABLE, otherwise throw an error
// ----------------------------------------------------------------------------------------

// check config files
$unwriteableList .= isWritableWarning($adminConfig['realBasePath'].'config/admin.config.php');
$unwriteableList .= isWritableWarning($adminConfig['realBasePath'].'config/category.config.php');  

// gives the error OUTPUT if one of these files in unwriteable
if($unwriteableList && checkBasePath()) {
  echo '<div class="block warning">
    <h1>'.$langFile['adminSetup_error_title'].'</h1>
    <div class="content">
      <p>'.$unwriteableList.'</p><!-- need <p> tags for margin-left:..-->
    </div>
    <div class="bottom"></div>  
  </div>'; 
  
  echo '<div class="blockSpacer"></div>';
}
// ------------------------------------------------------------------------------------------- end WRITEABLE CHECK

?>

<form action="index.php?site=pageSetup#top" method="post" enctype="multipart/form-data" accept-charset="UTF-8">
  <div>
  <input type="hidden" name="send" value="pageConfig" />
  <input type="hidden" name="savedBlock" id="savedBlock" value="" />
  </div>

<!-- GENERAL PAGE CONFIG -->
<?php
// shows the block below if it is the ones which is saved before
$hidden = ($savedForm != 'generalPageConfig') ? ' hidden' : '';
?>  
<div class="block<?php echo $hidden; ?>">
  <h1><a href="#" id="pageConfig" name="pageConfig"><?php echo $langFile['pageSetup_pageConfig_h1']; ?></a></h1>
  <div class="content">
    <table>
     
      <colgroup>
      <col class="left" />
      </colgroup>
        
      <tr><td class="left checkboxes">
      <input type="checkbox" id="cfg_setStartPage" name="cfg_setStartPage" value="true" class="toolTip" title="<?php echo $langFile['pageSetup_pageConfig_check1'].'::'.$langFile['pageSetup_pageConfig_check1_tip']; ?>"<?php if($adminConfig['setStartPage']) echo ' checked="checked"'; ?> />
      </td><td class="right checkboxes">
      <label for="cfg_setStartPage"><span class="toolTip" title="<?php echo $langFile['pageSetup_pageConfig_check1'].'::'.$langFile['pageSetup_pageConfig_check1_tip']; ?>"><?php echo $langFile['pageSetup_pageConfig_check1']; ?></span></label>
      </td></tr>
      
    </table>
    
    <!--<input type="reset" value="" class="button cancel" title="<?php echo $langFile['form_cancel']; ?>" />-->
    <input type="submit" value="" class="button submit center" title="<?php echo $langFile['form_submit']; ?>" onclick="$('savedBlock').value = 'generalPageConfig';" />
  </div>
  <div class="bottom"></div>
</div>

<!-- THUMBNAIL SETTINGS -->
<?php
// shows the block below if it is the ones which is saved before
$hidden = ($savedForm != 'thumbnailConfig') ? ' hidden' : '';
?>
<div class="block<?php echo $hidden; ?>">
  <h1><a href="#" id="thumbnailSettings" name="thumbnailSettings"><?php echo $langFile['adminSetup_thumbnailSettings_h1']; ?></a></h1>
  <div class="content">
    <table>
     
      <colgroup>
      <col class="left" />
      </colgroup>
  
      <tr><td class="leftTop"></td><td></td></tr>
      
      <!-- THUMB WIDTH -->
      <tr><td class="left">
      <label for="cfg_thumbWidth"><span class="toolTip" title="<?php echo $langFile['THUMBNAIL_TOOLTIP_WIDTH'] ?>">
      <?php echo $langFile['THUMBNAIL_TEXT_WIDTH'] ?></span></label>
      </td><td class="right">
        <input type="number" step="1" min="0" id="cfg_thumbWidth" name="cfg_thumbWidth" class="short" value="<?php echo $adminConfig['pageThumbnail']['width']; ?>" <?php if($adminConfig['pageThumbnail']['ratio'] == 'y') echo ' disabled="disabled"'; ?> />
        <?php echo $langFile['THUMBNAIL_TEXT_UNIT']; ?>
        &nbsp;&nbsp;&nbsp;&nbsp;
        <input type="radio" id="ratioX" name="cfg_thumbRatio" value="x"<?php if($adminConfig['pageThumbnail']['ratio'] == 'x') echo ' checked="checked"'; ?> />
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
        <input type="number" step="1" min="0" id="cfg_thumbHeight" name="cfg_thumbHeight" class="short" value="<?php echo $adminConfig['pageThumbnail']['height']; ?>" <?php if($adminConfig['pageThumbnail']['ratio'] == 'x') echo ' disabled="disabled"'; ?> />
        <?php echo $langFile['THUMBNAIL_TEXT_UNIT']; ?>
        &nbsp;&nbsp;&nbsp;&nbsp;
        <input type="radio" id="ratioY" name="cfg_thumbRatio" value="y"<?php if($adminConfig['pageThumbnail']['ratio'] == 'y') echo ' checked="checked"'; ?> />
        <label for="ratioY" class="toolTip" title="<?php echo $langFile['THUMBNAIL_TOOLTIP_KEEPRATIO_Y']; ?>::"> <?php echo $langFile['THUMBNAIL_TEXT_KEEPRATIO']; ?></label>
      </td></tr>
      
      <!-- shows the height in a scale -->
      <?php
      if(!empty($adminConfig['pageThumbnail']['height']))
        $style_thumbHeight = 'width:'.$adminConfig['pageThumbnail']['height'].'px;';
      else
        $style_thumbHeight = 'width:0px;';
      ?>
      <tr><td class="left">
      </td><td class="right">
      <div id="thumbHeightScale" class="scale" style="<?php echo $style_thumbHeight; ?>max-width:520px;"><div></div></div>
      </td></tr>
      
      <!-- NO THUMB RATIO -->
      <tr><td class="left">
      <input type="radio" id="noRatio" name="cfg_thumbRatio" value=""<?php if($adminConfig['pageThumbnail']['ratio'] == '') echo ' checked="checked"'; ?> />
      </td><td class="right">
      <label for="noRatio" class="toolTip" title="<?php echo $langFile['THUMBNAIL_TOOLTIP_FIXEDRATIO']; ?>::"> <?php echo $langFile['THUMBNAIL_TEXT_FIXEDRATIO']; ?></label>
      </td></tr>
      
      <tr><td class="spacer"></td><td></td></tr>
      
      <!-- THUMB PATH -->
      <tr><td class="left">
      <label for="cfg_thumbPath"><span class="toolTip" title="<?php echo $langFile['adminSetup_thumbnailSettings_field3'].'::'.$langFile['adminSetup_thumbnailSettings_field3_tip'] ?>">
      <?php echo $langFile['adminSetup_thumbnailSettings_field3'] ?></span></label>
      </td><td class="right">
      <input style="width:auto;" readonly="readonly" size="<?php echo strlen($adminConfig['uploadPath'])+5; ?>" value="<?php echo $adminConfig['uploadPath']; ?>" class="toolTip" title="<?php echo $langFile['adminSetup_thumbnailSettings_field3_inputTip1']; ?>" />
      <input id="cfg_thumbPath" name="cfg_thumbPath" style="width:150px;" value="<?php echo $adminConfig['pageThumbnail']['path']; ?>" class="toolTip" title="<?php echo $langFile['adminSetup_thumbnailSettings_field3_inputTip2']; ?>" />
      </td></tr>
      
            
      <tr><td class="leftBottom"></td><td></td></tr>
      
    </table>
    
    <!--<input type="reset" value="" class="button cancel" title="<?php echo $langFile['form_cancel']; ?>" />-->
    <input type="submit" value="" class="button submit center" title="<?php echo $langFile['form_submit']; ?>" onclick="$('savedBlock').value = 'thumbnailConfig';" />
  </div>
  <div class="bottom"></div>
</div>

<!-- NON CATEGORY PAGES CONFIG -->
<?php
// shows the block below if it is the ones which is saved before
$hidden = ($savedForm !== false && $savedForm != 'nonCategoryPages') ? ' hidden' : '';
?>  
<div class="block<?php echo $hidden; ?>">
  <h1><a href="#" id="pageConfig" name="pageConfig"><?php echo $langFile['pageSetup_pageConfig_noncategorypages_h1']; ?></a></h1>
  <div class="content">
    <table>
     
      <colgroup>
      <col class="left" />
      </colgroup>  
      
      <tr><td class="left checkboxes">
      <input type="checkbox" id="cfg_pageCreatePages" name="cfg_pageCreatePages" value="true" class="toolTip" title="<?php echo $langFile['pageSetup_pageConfig_check2'].'::'.$langFile['pageSetup_pageConfig_check2_tip']; ?>"<?php if($adminConfig['pages']['createDelete']) echo ' checked="checked"'; ?> /><br />
      </td><td class="right checkboxes">
      <label for="cfg_pageCreatePages"><span class="toolTip" title="<?php echo $langFile['pageSetup_pageConfig_check2'].'::'.$langFile['pageSetup_pageConfig_check2_tip']; ?>"><?php echo $langFile['pageSetup_pageConfig_check2']; ?></span></label><br />
      </td></tr>
      
      <tr><td class="left checkboxes">
      <input type="checkbox" id="cfg_pageThumbnailUpload" name="cfg_pageThumbnailUpload" value="true" class="toolTip" title="<?php echo $langFile['pageSetup_pageConfig_check3'].'::'.$langFile['pageSetup_pageConfig_check3_tip']; ?>"<?php if($adminConfig['pages']['thumbnails']) echo ' checked="checked"'; ?> /><br />
      </td><td class="right checkboxes">
      <label for="cfg_pageThumbnailUpload"><span class="toolTip" title="<?php echo $langFile['pageSetup_pageConfig_check3'].'::'.$langFile['pageSetup_pageConfig_check3_tip']; ?>"><?php echo $langFile['pageSetup_pageConfig_check3']; ?></span></label><br />
      </td></tr>
      
      <tr><td class="left checkboxes">
      <input type="checkbox" id="cfg_pagePlugins" name="cfg_pagePlugins" value="true" class="toolTip" title="<?php echo $langFile['pageSetup_pageConfig_check5'].'::'.$langFile['pageSetup_pageConfig_check5_tip']; ?>"<?php if($adminConfig['pages']['plugins']) echo ' checked="checked"'; ?> /><br />
      </td><td class="right checkboxes">
      <label for="cfg_pagePlugins"><span class="toolTip" title="<?php echo $langFile['pageSetup_pageConfig_check5'].'::'.$langFile['pageSetup_pageConfig_check5_tip']; ?>"><?php echo $langFile['pageSetup_pageConfig_check5']; ?></span></label><br />
      </td></tr>
      
      <tr><td class="left checkboxes">
      <input type="checkbox" id="cfg_pageTags" name="cfg_pageTags" value="true" class="toolTip" title="<?php echo $langFile['pageSetup_pageConfig_check4'].'::'.$langFile['pageSetup_pageConfig_check4_tip']; ?>"<?php if($adminConfig['pages']['showTags']) echo ' checked="checked"'; ?> />
      </td><td class="right checkboxes">
      <label for="cfg_pageTags"><span class="toolTip" title="<?php echo $langFile['pageSetup_pageConfig_check4'].'::'.$langFile['pageSetup_pageConfig_check4_tip']; ?>"><?php echo $langFile['pageSetup_pageConfig_check4']; ?></span></label>
      </td></tr> 
      
    </table>
    
    <!--<input type="reset" value="" class="button cancel" title="<?php echo $langFile['form_cancel']; ?>" />-->
    <input type="submit" value="" class="button submit center" title="<?php echo $langFile['form_submit']; ?>" onclick="$('savedBlock').value = 'nonCategoryPages';" />
  </div>
  <div class="bottom"></div>
</div>

</form>

<!-- CATEGORIES SETTINGS -->

<form action="index.php?site=pageSetup" id="categoriesForm" method="post" enctype="multipart/form-data" accept-charset="UTF-8">
  <div>
  <input type="hidden" name="send" value="categorySetup" />
  <input type="hidden" name="savedCategory" id="savedCategory" value="" />
  </div>

<div class="block">
  <h1><?php echo $langFile['pageSetup_h1']; ?></h1>
  <div class="content">
  
    <table>     
      <colgroup>
      <col class="left" />
      </colgroup>
  
      <tr><td class="leftTop"></td><td></td></tr>

      <tr><td class="left">
        <a href="?site=pageSetup&amp;status=createCategory#category<?php echo getNewCatgoryId(); ?>" class="createCategory toolTip" title="<?php echo $langFile['pageSetup_createCategory']; ?>::"></a>
      </td><td class="right">
      <br />
      <?php
      // user info          
      if($categoryInfo)
        echo '<span class="hint"><b>'.$categoryInfo.'</b></span>';
      ?>
      </td></tr>
      
      <tr><td class="leftBottom"></td><td></td></tr>
      
    </table>
    <?php        

      // lists the categories
      if(is_array($categoryConfig)) {
        $lastCategory = end($categoryConfig);
        $firstCategory = reset($categoryConfig);
        
        foreach($categoryConfig as $category) {
        
          // prevent using the $check vars from the last category
          unset($checked);
          
          // checks the category settings
          $checked[1] = ($category['public']) ? 'checked="checked"' : '';

          $checked[2] = ($category['createDelete']) ? 'checked="checked"' : '';
            
          $checked[3] = ($category['thumbnail']) ? 'checked="checked"' : '';
            
          $checked[11] = ($category['plugins']) ? 'checked="checked"' : '';
          
          $checked[4] = ($category['showTags']) ? 'checked="checked"' : ''; 
          
          $checked[5] = ($category['showPageDate']) ? 'checked="checked"' : '';
            
          $checked[6] = ($category['sortByPageDate']) ? 'checked="checked"' : '';
          
          $checked[7] = ($category['sortAscending']) ? 'checked="checked"' : '';
            
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
          // anchor
          echo '<a name="category'.$category['id'].'" id="category'.$category['id'].'" class="anchorTarget"></a>';
          
          // --------------------------------------
          // first TABLE (normal category settings)
          echo '<table>     
                <colgroup>
                <col class="left" />
                </colgroup>
                
                <tr><td class="leftTop"></td><td></td></tr>';
          
          // category NAME
          $categoryName = (empty($category['name']))
            ? '<i>'.$langFile['pageSetup_createCategory_unnamed'].'</i>'
            : $category['name'];
            
          $autofocus = (empty($category['name']))
            ? ' autofocus="autofocus"'
            : '';
          
          echo '<tr><td class="left">';
          echo '<span style="font-size:20px;font-weight:bold;">'.$categoryName.'</span><br />ID '.$category['id'];
          echo '<input type="hidden" name="categories['.$category['id'].'][id]" value="'.$category['id'].'" />';
          echo '</td>'; 
          
                // deleteCategory
          echo '<td class="right" style="width:525px;">
                <div style="border-bottom: 1px dotted #cccccc;width:400px;height:15px;float:left !important;"></div>
                <a href="?site=pageSetup&amp;status=deleteCategory&amp;category='.$category['id'].'#categories" class="deleteCategory toolTip" onclick="openWindowBox(\'library/sites/windowBox/deleteCategory.php?status=deleteCategory&amp;category='.$category['id'].'\',\''.$langFile['pageSetup_deleteCategory'].'\');return false;" title="'.$langFile['pageSetup_deleteCategory'].'::'.$category['name'].'[br /][br /][span style=color:#990000;]'.$langFile['pageSetup_deleteCategory_warning'].'[/span]"></a>';          
          echo '</td></tr>';
                // category name
          echo '<tr><td class="left">
                <label for="categories'.$category['id'].'name">'.$langFile['pageSetup_field1'].'</label>
                </td><td class="right">
                <input id="categories'.$category['id'].'name" name="categories['.$category['id'].'][name]" value="'.$category['name'].'"'.$autofocus.' />
                </td></tr>';
          
          echo '<tr><td class="leftBottom"></td><td>';
          
          // category up / down               
          if(count($categoryConfig) > 1) {
          
            if($firstCategory['id'] != $category['id'])
              echo '<a href="?site=pageSetup&amp;status=moveCategoryUp&amp;category='.$category['id'].'&amp;load='.rand(0,999).'#category'.$category['id'].'" class="categoryUp toolTip" title="'.$langFile['pageSetup_moveCategory_up_tip'].'::"></a>';
            if($lastCategory['id'] != $category['id'])
              echo '<a href="?site=pageSetup&amp;status=moveCategoryDown&amp;category='.$category['id'].'&amp;load='.rand(0,999).'#category'.$category['id'].'" class="categoryDown toolTip" title="'.$langFile['pageSetup_moveCategory_down_tip'].'::"></a>';
          }
          
          echo '</td></tr>';
                    
               // category SETTINGS
          echo '<tr><td class="left checkboxes">
                <input type="checkbox" id="categories'.$category['id'].'public" name="categories['.$category['id'].'][public]" value="true" '.$checked[1].' class="toolTip" title="'.$langFile['pageSetup_check1'].'::'.$langFile['pageSetup_check1_tip'].'" /><br />
                </td><td class="right checkboxes">
                <label for="categories'.$category['id'].'public">';          
                $publicSignStyle = ' style="position:relative; top:-3px; float:left;"';        
                // shows the public or unpublic picture
                if($checked[1])
                  echo '<img src="library/images/icons/category_public.png" alt="public" class="toolTip" title="'.$langFile['STATUS_CATEGORY_PUBLIC'].'"'.$publicSignStyle.' />&nbsp;';
                else
                  echo '<img src="library/images/icons/category_nonpublic.png" alt="closed" class="toolTip" title="'.$langFile['STATUS_CATEGORY_NONPUBLIC'].'"'.$publicSignStyle.' />&nbsp;';
                
                echo '<span class="toolTip" title="'.$langFile['pageSetup_check1'].'::'.$langFile['pageSetup_check1_tip'].'">'.$langFile['pageSetup_check1'].'</span></label>
                </td></tr>';
                          
          echo '<tr><td class="spacer checkboxes"></td><td></td></tr>';
                
          echo '<tr><td class="left checkboxes">
                <input type="checkbox" id="categories'.$category['id'].'createDelete" name="categories['.$category['id'].'][createDelete]" value="true" '.$checked[2].' class="toolTip" title="'.$langFile['pageSetup_check2'].'::'.$langFile['pageSetup_check2_tip'].'" /><br />
                </td><td class="right checkboxes">
                <label for="categories'.$category['id'].'createDelete"><span class="toolTip" title="'.$langFile['pageSetup_check2'].'::'.$langFile['pageSetup_check2_tip'].'">'.$langFile['pageSetup_check2'].'</span></label>
                </td></tr>';          
          
          echo '<tr><td class="left checkboxes">
                <input type="checkbox" id="categories'.$category['id'].'thumbnail" name="categories['.$category['id'].'][thumbnail]" value="true" '.$checked[3].' class="toolTip" title="'.$langFile['pageSetup_check3'].'::'.$langFile['pageSetup_check3_tip'].'" /><br />                
                </td><td class="right checkboxes">
                <label for="categories'.$category['id'].'thumbnail"><span class="toolTip" title="'.$langFile['pageSetup_check3'].'::'.$langFile['pageSetup_check3_tip'].'">'.$langFile['pageSetup_check3'].'</span></label>             
                </td></tr>';
                
          echo '<tr><td class="spacer checkboxes"></td><td></td></tr>';
 
          echo '<tr><td class="left checkboxes">
                <input type="checkbox" id="categories'.$category['id'].'plugins" name="categories['.$category['id'].'][plugins]" value="true" '.$checked[11].' class="toolTip" title="'.$langFile['pageSetup_check8'].'::'.$langFile['pageSetup_check8_tip'].'" /><br />
                </td><td class="right checkboxes">
                <label for="categories'.$category['id'].'plugins"><span class="toolTip" title="'.$langFile['pageSetup_check8'].'::'.$langFile['pageSetup_check8_tip'].'">'.$langFile['pageSetup_check8'].'</span></label>
                </td></tr>';
          
          echo '<tr><td class="left checkboxes">
                <input type="checkbox" id="categories'.$category['id'].'showTags" name="categories['.$category['id'].'][showTags]" value="true" '.$checked[4].' class="toolTip" title="'.$langFile['pageSetup_check4'].'::'.$langFile['pageSetup_check4_tip'].'" /><br />
                </td><td class="right checkboxes">
                <label for="categories'.$category['id'].'showTags"><span class="toolTip" title="'.$langFile['pageSetup_check4'].'::'.$langFile['pageSetup_check4_tip'].'">'.$langFile['pageSetup_check4'].'</span></label>
                </td></tr>';
                
          echo '<tr><td class="spacer checkboxes"></td><td></td></tr>';

          echo '<tr><td class="left checkboxes">
                <input type="checkbox" id="categories'.$category['id'].'showPageDate" name="categories['.$category['id'].'][showPageDate]" value="true" '.$checked[5].' class="toolTip" title="'.$langFile['pageSetup_check5'].'::'.$langFile['pageSetup_check5_tip'].'" /><br />
                </td><td class="right checkboxes">
                <label for="categories'.$category['id'].'showPageDate"><span class="toolTip" title="'.$langFile['pageSetup_check5'].'::'.$langFile['pageSetup_check5_tip'].'">'.$langFile['pageSetup_check5'].'</span></label>
                </td></tr>';
                
          echo '<tr><td class="left checkboxes">
                <input type="checkbox" id="categories'.$category['id'].'sortByPageDate" name="categories['.$category['id'].'][sortByPageDate]" value="true" '.$checked[6].' class="toolTip" title="'.$langFile['pageSetup_check6'].'::'.$langFile['pageSetup_check6_tip'].'" /><br />
                </td><td class="right checkboxes">
                <label for="categories'.$category['id'].'sortByPageDate"><span class="toolTip" title="'.$langFile['pageSetup_check6'].'::'.$langFile['pageSetup_check6_tip'].'">'.$langFile['pageSetup_check6'].'</span></label>
                </td></tr>';
                
          echo '<tr><td class="spacer checkboxes"></td><td></td></tr>';
          
          echo '<tr><td class="left checkboxes">
                <input type="checkbox" id="categories'.$category['id'].'sortAscending" name="categories['.$category['id'].'][sortAscending]" value="true" '.$checked[7].' class="toolTip" title="'.$langFile['pageSetup_check7'].'::'.$langFile['pageSetup_check7_tip'].'" />
                </td><td class="right checkboxes">
                <label for="categories'.$category['id'].'sortAscending"><span class="toolTip" title="'.$langFile['pageSetup_check7'].'::'.$langFile['pageSetup_check7_tip'].'">'.$langFile['pageSetup_check7'].'</span></label>          
                </td></tr>';
          
          echo '<tr><td class="left checkboxes"></td>
                <td><a href="#" class="down inBlockSliderLink" style="position:relative; left:-20px; bottom: -15px;">'.$langFile['pageSetup_advancedSettings'].'</a>
                </td></tr>';
          
          echo '<tr><td class="spacer checkboxes"></td><td></td></tr>';
          
          // end of the TABLE for one category
          echo '</table>';
          
          // -----------------------------------------------
          // second TABLE (advanced settings) (with slide in)
          $hidden = ($_POST['savedCategory'] != $category['id']) ? ' hidden' : '';
          
          echo '<table id="advancedConfigTable'.$category['id'].'" class="inBlockSlider'.$hidden.'">     
                <colgroup>
                <col class="left" />
                </colgroup>
                
                <tr><td class="leftTop"></td><td><span class="hint">'.$langFile['pageSetup_advancedSettings_hint'].'</span></td></tr>';
          
          echo '<tr><td class="left">
                <span class="toolTip" title="'.$langFile['STYLESHEETS_TEXT_STYLEFILE'].'::'.$langFile['STYLESHEETS_TOOLTIP_STYLEFILE'].'[br /][br /][span class=hint]'.$langFile['pageSetup_stylesheet_ifempty'].'[/span]">
                '.$langFile['STYLESHEETS_TEXT_STYLEFILE'].'</span>
                </td><td class="right">
                <div id="categoryStyleFilesInputs'.$category['id'].'" class="inputToolTip" title="'.$langFile['PATHS_TOOLTIP_ABSOLUTE'].'::[span class=hint]'.$langFile['pageSetup_stylesheet_ifempty'].'[/span]">
                <span class="hint" style="float:right;width:190px;">'.$langFile['STYLESHEETS_EXAMPLE_STYLEFILE'].'</span>';
                
          echo showStyleFileInputs(generalFunctions::getStylesByPriority($category['styleFile'],'styleFile',$pageContent['category']),'categories['.$category['id'].'][styleFile]');

          echo '</div>
                <a href="#" class="addStyleFilePath toolTip" title="'.$langFile['STYLESHEETS_TOOLTIP_ADDSTYLEFILE'].'::"></a>              
                </td></tr>';
                
          echo '<tr><td class="left">
                <label for="categories'.$category['id'].'styleId"><span class="toolTip" title="'.$langFile['STYLESHEETS_TEXT_ID'].'::'.$langFile['STYLESHEETS_TOOLTIP_ID'].'[br /][br /][span class=hint]'.$langFile['pageSetup_stylesheet_ifempty'].'[/span]">
                '.$langFile['STYLESHEETS_TEXT_ID'].'</span></label>
                </td><td class="right">
                <input id="categories'.$category['id'].'styleId" name="categories['.$category['id'].'][styleId]" value="'.generalFunctions::getStylesByPriority($category['styleId'],'styleId',$category['id']).'" class="inputToolTip" title="'.$langFile['pageSetup_stylesheet_ifempty'].'" />
                </td></tr>';
                
          echo '<tr><td class="left">
                <label for="categories'.$category['id'].'styleClass"><span class="toolTip" title="'.$langFile['STYLESHEETS_TEXT_CLASS'].'::'.$langFile['STYLESHEETS_TOOLTIP_CLASS'].'[br /][br /][span class=hint]'.$langFile['pageSetup_stylesheet_ifempty'].'[/span]">
                '.$langFile['STYLESHEETS_TEXT_CLASS'].'</span></label>
                </td><td class="right">
                <input id="categories'.$category['id'].'styleClass" name="categories['.$category['id'].'][styleClass]" value="'.generalFunctions::getStylesByPriority($category['styleClass'],'styleClass',$category['id']).'" class="inputToolTip" title="'.$langFile['pageSetup_stylesheet_ifempty'].'" />
                </td></tr>';
          
          echo '<tr><td class="spacer"></td><td></td></tr>';
          
               // category thumbSize 
          echo '<tr><td class="left">
                <label for="categories'.$category['id'].'thumbWidth"><span class="toolTip" title="'.$langFile['THUMBNAIL_TOOLTIP_WIDTH'].'">
                '.$langFile['THUMBNAIL_TEXT_WIDTH'].'</span></label>
                </td><td class="right">
                <input type="number" step="1" min="0" id="categories'.$category['id'].'thumbWidth" name="categories['.$category['id'].'][thumbWidth]" class="short" value="'.$category['thumbWidth'].'" '.$disabled[9].' />
                '.$langFile['THUMBNAIL_TEXT_UNIT'].'
                  &nbsp;&nbsp;&nbsp;&nbsp;
                  <input type="radio" id="categories'.$category['id'].'ratioX" name="categories['.$category['id'].'][thumbRatio]" value="x" '.$checked[9].' />
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
                <input type="number" step="1" min="0" id="categories'.$category['id'].'thumbHeight" name="categories['.$category['id'].'][thumbHeight]" class="short" value="'.$category['thumbHeight'].'" '.$disabled[10].' />
                '.$langFile['THUMBNAIL_TEXT_UNIT'].'
                  &nbsp;&nbsp;&nbsp;&nbsp;
                  <input type="radio" id="categories'.$category['id'].'ratioY" name="categories['.$category['id'].'][thumbRatio]" value="y" '.$checked[10].' />
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
                <input type="radio" id="categories'.$category['id'].'noRatio" name="categories['.$category['id'].'][thumbRatio]" value="" '.$checked[8].' />
                </td><td class="right">
                <label for="categories'.$category['id'].'noRatio" class="toolTip" title="'.$langFile['THUMBNAIL_TEXT_RATIO'].'::'.$langFile['THUMBNAIL_TOOLTIP_FIXEDRATIO'].'"> '.$langFile['THUMBNAIL_TEXT_FIXEDRATIO'].'</label>
                </td></tr>';
          
          // finish the TABLE for one category
          echo '<tr><td class="leftBottom"></td><td></td></tr>
                </table>';
          
          // SUBMIT: IF advancedConfigTable has not Class "hidden" it stores the categoryId in the savedCategory input
          // and gives the submit anchor to the FORM      
          echo '<input type="submit" value="" name="saveCategories" class="button submit center" title="'.$langFile['form_submit'].'" onclick="if(!$(\'advancedConfigTable'.$category['id'].'\').hasClass(\'hidden\')) $(\'savedCategory\').value = \''.$category['id'].'\'; submitAnchor(\'categoriesForm\',\'category'.$category['id'].'\');" />
                </div>'; // end slide in box
          
        }
      }        
      ?>    
    <!--<input type="reset" value="" class="button cancel" title="<?php echo $langFile['form_cancel']; ?>" />-->
    
  </div>
  <div class="bottom"></div>
</div>

</form>