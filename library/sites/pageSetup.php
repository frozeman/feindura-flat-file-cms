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

* pageSetup.php version 1.20
*/

include_once(dirname(__FILE__)."/../backend.include.php");

// VARs
// ---------------------------------------------------------------------------
$categoryInfo = false;


// ----------------------------------------------------------------------------------------------------------------------------------------
// **--** SAVE PROCESS --------------------------------------------------------------------------------------------------------------------
// ----------------------------------------------------------------------------------------------------------------------------------------

// ---------------------------------------------------------------------------------------------------
// ****** ---------- SAVE PAGE CONFIG in config/admin.config.php
if(isset($_POST['send']) && $_POST['send'] ==  'pageConfig') {
  
  // ** removes a "/" on the beginning of all relative paths
  if(!empty($_POST['cfg_thumbPath']) && substr($_POST['cfg_thumbPath'],0,1) == '/')
        $_POST['cfg_thumbPath'] = substr($_POST['cfg_thumbPath'],1);
  
  // -> CHECK if the THUMBNAIL HEIGHT/WIDTH is empty, and add the previous ones
  if(!isset($_POST['cfg_thumbWidth']))
    $_POST['cfg_thumbWidth'] = $adminConfig['pageThumbnail']['width'];
  if(!isset($_POST['cfg_thumbHeight']))
    $_POST['cfg_thumbHeight'] = $adminConfig['pageThumbnail']['height'];   
  
  // -> PREPARE CONFIG VARs
  $adminConfig['setStartPage'] = $_POST['cfg_setStartPage'];
  $adminConfig['page']['createPages'] = $_POST['cfg_pageCreatePages'];
  $adminConfig['page']['thumbnailUpload'] = $_POST['cfg_pageThumbnailUpload'];  
  $adminConfig['page']['plugins'] = $_POST['cfg_pagePlugins'];
  $adminConfig['page']['showtags'] = $_POST['cfg_pageTags'];
  
  $adminConfig['pageThumbnail']['width'] =  $_POST['cfg_thumbWidth'];
  $adminConfig['pageThumbnail']['height'] = $_POST['cfg_thumbHeight'];
  $adminConfig['pageThumbnail']['ratio'] = $_POST['cfg_thumbRatio'];
  $adminConfig['pageThumbnail']['path'] = 'images/'.$_POST['cfg_thumbPath'];
  
  // **** opens admin.config.php for writing
  if(saveAdminConfig($adminConfig)) {
     
    // give documentSaved status
    $documentSaved = true;
    $statisticFunctions->saveTaskLog($langFile['log_pageSetup_saved']); // <- SAVE the task in a LOG FILE
    
  } else
    $errorWindow = $langFile['adminSetup_fmsSettings_error_save'];
  
  $savedForm = $_POST['savedBlock'];
}

// ---------------------------------------------------------------------------------------------------
// ****** ---------- SAVE CATEGORY CONFIG in config/category.config.php

// ****** ---------- CREATE NEW CATEGORY
if((isset($_POST['send']) && $_POST['send'] ==  'categorySetup' && isset($_POST['createCategory'])) ||
   $_GET['status'] == 'createCategory') {
   
  // -> GET highest category id
  $newId = getNewCatgoryId();
  
  if($newId == 1)
    $categoryConfig = array();
  
  //fügt dem $categoryConfig array einen leeren array an
  $categoryConfig['id_'.$newId] = array('id' => $newId); // gives the new category a id
  if(saveCategories($categoryConfig)) {

    $categoryInfo = $langFile['pageSetup_createCategory_created'];
    
    // if there is no category dir, try to create one
    if(!is_dir(DOCUMENTROOT.$adminConfig['savePath'].$newId)) {
      // erstellt ein verzeichnis
      if(!mkdir(DOCUMENTROOT.$adminConfig['savePath'].$newId, 0777) ||
         !chmod(DOCUMENTROOT.$adminConfig['savePath'].$newId, 0777)) {
        if($errorWindow) // if there is allready an warning
          $errorWindow .= '<br /><br />'.$langFile['pageSetup_error_createDir'];
        else
          $errorWindow = $langFile['pageSetup_error_createDir'];
      }
    }
    
    $statisticFunctions->saveTaskLog($langFile['log_pageSetup_new']); // <- SAVE the task in a LOG FILE
  } else // throw error
    $errorWindow = $langFile['pageSetup_error_create'];
  
  $savedForm = 'categories';
}

// ****** ---------- DELETE CATEGORY
if(((isset($_POST['send']) && $_POST['send'] ==  'categorySetup' && isset($_POST['deleteCategory'])) ||
   $_GET['status'] == 'deleteCategory') && isset($categoryConfig['id_'.$_GET['category']])) {  
  
  // save the name, to put it in the info
  $storedCategoryName = $categoryConfig['id_'.$_GET['category']]['name'];
  
  // deletes the category with the given id from the array and saves the categoriesSettings.php
  unset($categoryConfig['id_'.$_GET['category']]);  
  if(saveCategories($categoryConfig)) {
  
    // Hinweis für den Benutzer welche Gruppe gelöscht wurde
    $categoryInfo = $langFile['pageSetup_deleteCategory_deleted'].' &quot;<b>'.$storedCategoryName.'</b>&quot;';
  
    // if there is a category dir, trys to delete it !important deletes all files in it
    if(is_dir(DOCUMENTROOT.$adminConfig['savePath'].$_GET['category'])) {
    
      if($pageContents = $generalFunctions->loadPages($_GET['category'],true)) {
      
        // deletes possible thumbnails before deleting the category
        foreach($pageContents as $page) {
          if(!empty($page['thumbnail']) && is_file(DOCUMENTROOT.$adminConfig['uploadPath'].$adminConfig['pageThumbnail']['path'].$page['thumbnail'])) {
            @chmod(DOCUMENTROOT.$adminConfig['uploadPath'].$adminConfig['pageThumbnail']['path'].$page['thumbnail'], 0777);          
            // DELETING    
            @unlink(DOCUMENTROOT.$adminConfig['uploadPath'].$adminConfig['pageThumbnail']['path'].$page['thumbnail']);
          }
        }
      }
      
      // deletes the dir with subdirs and files
      if(!delDir(DOCUMENTROOT.$adminConfig['savePath'].$_GET['category'].'/')) {
        if($errorWindow) // if there is allready an warning
          $errorWindow .= '<br /><br />'.$langFile['pageSetup_error_deleteDir'];
        else
          $errorWindow = $langFile['pageSetup_error_deleteDir'];
      }    
    }
    
    $statisticFunctions->saveTaskLog($langFile['log_pageSetup_delete'],$storedCategoryName); // <- SAVE the task in a LOG FILE
  } else // throw error
    $errorWindow = $langFile['pageSetup_error_delete'];

  $savedForm = 'categories';
}

// ****** ---------- MOVE CATEGORY
if(substr($_GET['status'],0,12) == 'moveCategory' && !empty($_GET['category']) && is_numeric($_GET['category'])) {
  
  // move the categories in the categories array
  if($_GET['status'] == 'moveCategoryUp')
    $direction = 'up';
  if($_GET['status'] == 'moveCategoryDown')
    $direction = 'down';
    
  if(moveCategories($categoryConfig,$_GET['category'],$direction)) {
  
    $categoryInfo = $langFile['pageSetup_moveCategory_moved'];
    
    // save the categories array
    if(saveCategories($categoryConfig)) {
      $documentSaved = true; // set documentSaved status
      $statisticFunctions->saveTaskLog($langFile['log_pageSetup_move'],'category='.$_GET['category']); // <- SAVE the task in a LOG FILE
    } else
      $errorWindow = $langFile['pageSetup_error_save'];
    
  }
    
  $savedForm = 'categories';
}


// ****** ---------- SAVE CATEGORIES
if(isset($_POST['send']) && $_POST['send'] ==  'categorySetup' && isset($_POST['saveCategories'])) {
  
  // cleans the category names
  $catewgoriesCleaned = array();
  foreach($_POST['categories'] as $category) {
      $category['name'] = $generalFunctions->clearText($category['name']);
      $categoriesCleaned[$category['id']] = $category;
  }

  if(saveCategories($categoriesCleaned)) {
    $documentSaved = true; // set documentSaved status
    $statisticFunctions->saveTaskLog($langFile['log_pageSetup_saved']); // <- SAVE the task in a LOG FILE
  } else
    $errorWindow = $langFile['pageSetup_error_save'];
  
  $savedForm = 'categories';
}


// RE-INCLUDE
$adminConfig = @include (dirname(__FILE__)."/../../config/admin.config.php");
$categoryConfig = @include (dirname(__FILE__)."/../../config/category.config.php");
// RESET of the vars in the classes
$generalFunctions->adminConfig = $adminConfig;
$statisticFunctions->adminConfig = $adminConfig;
$generalFunctions->categoryConfig = $categoryConfig;
$statisticFunctions->categoryConfig = $categoryConfig;
$generalFunctions->storedPageIds = null;
$generalFunctions->storedPages = null;

// ------------------------------- ENDE of the SAVING SCRIPT -------------------------------------------------------------------------------


// CHECKs THE IF THE NECESSARY FILEs ARE WRITEABLE, otherwise throw an error
// ----------------------------------------------------------------------------------------

// check config files
$unwriteableList .= isWritableWarning($adminConfig['basePath'].'config/admin.config.php');
$unwriteableList .= isWritableWarning($adminConfig['basePath'].'config/category.config.php');  

// gives the error OUTPUT if one of these files in unwriteable
if($unwriteableList && checkBasePath()) {
  echo '<div class="block warning">
    <h1>'.$langFile['adminSetup_writeAccess'].'</h1>
    <div class="content">
      <p>'.$unwriteableList.'</p><!-- needs <p> tags for margin-left:..-->
    </div>
    <div class="bottom"></div>  
  </div>'; 
  
  echo '<div class="blockSpacer"></div>';
}
// ------------------------------------------------------------------------------------------- end WRITEABLE CHECK

?>

<form action="?site=pageSetup#top" method="post" enctype="multipart/form-data" accept-charset="UTF-8">
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
    
    <!--<input type="reset" value="" class="toolTip button cancel" title="<?php echo $langFile['form_cancel']; ?>" />-->
    <input type="submit" value="" class="toolTip button submit center" title="<?php echo $langFile['form_submit']; ?>" onclick="$('savedBlock').value = 'generalPageConfig';" />
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
      <label for="cfg_thumbWidth"><span class="toolTip" title="<?php echo $langFile['thumbnail_width_tip'] ?>">
      <?php echo $langFile['thumbnail_name_width'] ?></span></label>
      </td><td class="right">
        <input id="cfg_thumbWidth" name="cfg_thumbWidth" class="short" value="<?php echo $adminConfig['pageThumbnail']['width']; ?>" <?php if($adminConfig['pageThumbnail']['ratio'] == 'y') echo ' disabled="disabled"'; ?> />
        <?php echo $langFile['thumbSize_unit']; ?>
        &nbsp;&nbsp;&nbsp;&nbsp;
        <span class="toolTip" title="<?php echo $langFile['thumbnail_ratio_x_tip']; ?>::">
          <input type="radio" id="ratioX" name="cfg_thumbRatio" value="x"<?php if($adminConfig['pageThumbnail']['ratio'] == 'x') echo ' checked="checked"'; ?> />
          <label for="ratioX"> <?php echo $langFile['thumbnail_ratio_fieldText']; ?></label>
        </span>
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
      <label for="cfg_thumbHeight"><span class="toolTip" title="<?php echo $langFile['thumbnail_height_tip'] ?>">
      <?php echo $langFile['thumbnail_name_height'] ?></span></label>
      </td><td class="right">
        <input id="cfg_thumbHeight" name="cfg_thumbHeight" class="short" value="<?php echo $adminConfig['pageThumbnail']['height']; ?>" <?php if($adminConfig['pageThumbnail']['ratio'] == 'x') echo ' disabled="disabled"'; ?> />
        <?php echo $langFile['thumbSize_unit']; ?>
        &nbsp;&nbsp;&nbsp;&nbsp;
        <span class="toolTip" title="<?php echo $langFile['thumbnail_ratio_y_tip']; ?>::">
          <input type="radio" id="ratioY" name="cfg_thumbRatio" value="y"<?php if($adminConfig['pageThumbnail']['ratio'] == 'y') echo ' checked="checked"'; ?> />
          <label for="ratioY"> <?php echo $langFile['thumbnail_ratio_fieldText']; ?></label>
        </span>
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
        <span class="toolTip" title="<?php echo $langFile['thumbnail_ratio_noRatio_tip']; ?>::">
          <label for="noRatio"> <?php echo $langFile['thumbnail_ratio_noRatio']; ?></label>
        </span>
      </td></tr>
      
      <tr><td class="spacer"></td><td></td></tr>
      
      <!-- THUMB PATH -->
      <tr><td class="left">
      <label for="cfg_thumbPath"><span class="toolTip" title="<?php echo $langFile['adminSetup_thumbnailSettings_field3'].'::'.$langFile['adminSetup_thumbnailSettings_field3_tip'] ?>">
      <?php echo $langFile['adminSetup_thumbnailSettings_field3'] ?></span></label>
      </td><td class="right">
      <input style="width:auto;" readonly="readonly" size="<?php echo strlen($adminConfig['uploadPath'])+5; ?>" value="<?php echo $adminConfig['uploadPath']; ?>images/" class="toolTip" title="<?php echo $langFile['adminSetup_thumbnailSettings_field3_inputTip1']; ?>" />
      <input id="cfg_thumbPath" name="cfg_thumbPath" style="width:150px;" value="<?php echo str_replace("images/","",$adminConfig['pageThumbnail']['path']); ?>" class="toolTip" title="<?php echo $langFile['adminSetup_thumbnailSettings_field3_inputTip2']; ?>" />
      </td></tr>
      
            
      <tr><td class="leftBottom"></td><td></td></tr>
      
    </table>
    
    <!--<input type="reset" value="" class="toolTip button cancel" title="<?php echo $langFile['form_cancel']; ?>" />-->
    <input type="submit" value="" class="toolTip button submit center" title="<?php echo $langFile['form_submit']; ?>" onclick="$('savedBlock').value = 'thumbnailConfig';" />
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
      <input type="checkbox" id="cfg_pageCreatePages" name="cfg_pageCreatePages" value="true" class="toolTip" title="<?php echo $langFile['pageSetup_pageConfig_check2'].'::'.$langFile['pageSetup_pageConfig_check2_tip']; ?>"<?php if($adminConfig['page']['createPages']) echo ' checked="checked"'; ?> /><br />
      </td><td class="right checkboxes">
      <label for="cfg_pageCreatePages"><span class="toolTip" title="<?php echo $langFile['pageSetup_pageConfig_check2'].'::'.$langFile['pageSetup_pageConfig_check2_tip']; ?>"><?php echo $langFile['pageSetup_pageConfig_check2']; ?></span></label><br />
      </td></tr>
      
      <tr><td class="left checkboxes">
      <input type="checkbox" id="cfg_pageThumbnailUpload" name="cfg_pageThumbnailUpload" value="true" class="toolTip" title="<?php echo $langFile['pageSetup_pageConfig_check3'].'::'.$langFile['pageSetup_pageConfig_check3_tip']; ?>"<?php if($adminConfig['page']['thumbnailUpload']) echo ' checked="checked"'; ?> /><br />
      </td><td class="right checkboxes">
      <label for="cfg_pageThumbnailUpload"><span class="toolTip" title="<?php echo $langFile['pageSetup_pageConfig_check3'].'::'.$langFile['pageSetup_pageConfig_check3_tip']; ?>"><?php echo $langFile['pageSetup_pageConfig_check3']; ?></span></label><br />
      </td></tr>
      
      <tr><td class="left checkboxes">
      <input type="checkbox" id="cfg_pagePlugins" name="cfg_pagePlugins" value="true" class="toolTip" title="<?php echo $langFile['pageSetup_pageConfig_check5'].'::'.$langFile['pageSetup_pageConfig_check5_tip']; ?>"<?php if($adminConfig['page']['plugins']) echo ' checked="checked"'; ?> /><br />
      </td><td class="right checkboxes">
      <label for="cfg_pagePlugins"><span class="toolTip" title="<?php echo $langFile['pageSetup_pageConfig_check5'].'::'.$langFile['pageSetup_pageConfig_check5_tip']; ?>"><?php echo $langFile['pageSetup_pageConfig_check5']; ?></span></label><br />
      </td></tr>
      
      <tr><td class="left checkboxes">
      <input type="checkbox" id="cfg_pageTags" name="cfg_pageTags" value="true" class="toolTip" title="<?php echo $langFile['pageSetup_pageConfig_check4'].'::'.$langFile['pageSetup_pageConfig_check4_tip']; ?>"<?php if($adminConfig['page']['showtags']) echo ' checked="checked"'; ?> />
      </td><td class="right checkboxes">
      <label for="cfg_pageTags"><span class="toolTip" title="<?php echo $langFile['pageSetup_pageConfig_check4'].'::'.$langFile['pageSetup_pageConfig_check4_tip']; ?>"><?php echo $langFile['pageSetup_pageConfig_check4']; ?></span></label>
      </td></tr> 
      
    </table>
    
    <!--<input type="reset" value="" class="toolTip button cancel" title="<?php echo $langFile['form_cancel']; ?>" />-->
    <input type="submit" value="" class="toolTip button submit center" title="<?php echo $langFile['form_submit']; ?>" onclick="$('savedBlock').value = 'nonCategoryPages';" />
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
        foreach($categoryConfig as $category) {
        
          // prevent using the $check vars from the last category
          unset($checked);
          
          // checks the category settings
          $checked[1] = ($category['public']) ? 'checked="checked"' : '';

          $checked[2] = ($category['createdelete']) ? 'checked="checked"' : '';
            
          $checked[3] = ($category['thumbnail']) ? 'checked="checked"' : '';
            
          $checked[11] = ($category['plugins']) ? 'checked="checked"' : '';
          
          $checked[4] = ($category['showtags']) ? 'checked="checked"' : ''; 
          
          $checked[5] = ($category['showpagedate']) ? 'checked="checked"' : '';
            
          $checked[6] = ($category['sortbypagedate']) ? 'checked="checked"' : '';
          
          $checked[7] = ($category['sortascending']) ? 'checked="checked"' : '';
            
          $checked[8] = ($category['thumbRatio']) ? 'checked="checked"' : '';
            
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
          if(empty($category['name']))
            $categoryName = '<i>'.$langFile['pageSetup_createCategory_unnamed'].'</i>';
          else
            $categoryName = $category['name'];
          
          echo '<tr><td class="left">';
          echo '<span style="font-size:20px;font-weight:bold;">'.$categoryName.'</span><br />ID '.$category['id'];
          echo '<input type="hidden" name="categories['.$category['id'].'][id]" value="'.$category['id'].'" />';
          echo '</td>'; 
          
                // deleteCategory
          echo '<td class="right" style="width:525px;">
                <div style="border-bottom: 1px dotted #cccccc;width:400px;height:15px;float:left !important;"></div>
                <a href="?site=pageSetup&amp;status=deleteCategory&amp;category='.$category['id'].'#categories" class="deleteCategory toolTip" onclick="openWindowBox(\'library/sites/deleteCategory.php?status=deleteCategory&amp;category='.$category['id'].'\',\''.$langFile['btn_pageThumbnailDelete'].'\');return false;" title="'.$langFile['pageSetup_deleteCategory'].'::'.$category['name'].'[br /][br /][span style=color:#990000;]'.$langFile['pageSetup_deleteCategory_warning'].'[/span]"></a>';
                // advanced Settings slide link
          echo '<a href="#" class="down" style="position:relative; bottom:-11px;">'.$langFile['pageSetup_advancedSettings'].'</a>
                </td></tr>';          
                // category name
          echo '<tr><td class="left">
                '.$langFile['pageSetup_field1'].'
                </td><td class="right">
                <input name="categories['.$category['id'].'][name]" value="'.$category['name'].'" />
                </td></tr>';
          
          echo '<tr><td class="leftBottom"></td><td>';
               // category up / down
          echo '<a href="?site=pageSetup&amp;status=moveCategoryUp&amp;category='.$category['id'].'&amp;load='.rand(0,999).'#category'.$category['id'].'" class="categoryUp toolTip" title="'.$langFile['pageSetup_moveCategory_up_tip'].'::"></a>
                <a href="?site=pageSetup&amp;status=moveCategoryDown&amp;category='.$category['id'].'&amp;load='.rand(0,999).'#category'.$category['id'].'" class="categoryDown toolTip" title="'.$langFile['pageSetup_moveCategory_down_tip'].'::"></a>';
          echo '</td></tr>';
                    
               // category SETTINGS
          echo '<tr><td class="left checkboxes">
                <input type="checkbox" id="categories'.$category['id'].'public" name="categories['.$category['id'].'][public]" value="true" '.$checked[1].' class="toolTip" title="'.$langFile['pageSetup_check1'].'::'.$langFile['pageSetup_check1_tip'].'" /><br />
                </td><td class="right checkboxes">
                <label for="categories'.$category['id'].'public">';          
                $publicSignStyle = ' style="position:relative; top:-3px; float:left;"';        
                // shows the public or unpublic picture
                if($checked[1])
                  echo '<img src="library/image/sign/category_public.png" alt="public" class="toolTip" title="'.$langFile['status_category_public'].'"'.$publicSignStyle.' />&nbsp;';
                else
                  echo '<img src="library/image/sign/category_nonpublic.png" alt="closed" class="toolTip" title="'.$langFile['status_category_nonpublic'].'"'.$publicSignStyle.' />&nbsp;';
                
                echo '<span class="toolTip" title="'.$langFile['pageSetup_check1'].'::'.$langFile['pageSetup_check1_tip'].'">'.$langFile['pageSetup_check1'].'</span></label><br />
                </td></tr>';
                          
          echo '<tr><td class="spacer checkboxes"></td><td></td></tr>';
                
          echo '<tr><td class="left checkboxes">
                <input type="checkbox" id="categories'.$category['id'].'createdelete" name="categories['.$category['id'].'][createdelete]" value="true" '.$checked[2].' class="toolTip" title="'.$langFile['pageSetup_check2'].'::'.$langFile['pageSetup_check2_tip'].'" /><br />
                </td><td class="right checkboxes">
                <label for="categories'.$category['id'].'createdelete"><span class="toolTip" title="'.$langFile['pageSetup_check2'].'::'.$langFile['pageSetup_check2_tip'].'">'.$langFile['pageSetup_check2'].'</span></label><br />  
                </td></tr>';          
          
          echo '<tr><td class="left checkboxes">
                <input type="checkbox" id="categories'.$category['id'].'thumbnail" name="categories['.$category['id'].'][thumbnail]" value="true" '.$checked[3].' class="toolTip" title="'.$langFile['pageSetup_check3'].'::'.$langFile['pageSetup_check3_tip'].'" /><br />                
                </td><td class="right checkboxes">
                <label for="categories'.$category['id'].'thumbnail"><span class="toolTip" title="'.$langFile['pageSetup_check3'].'::'.$langFile['pageSetup_check3_tip'].'">'.$langFile['pageSetup_check3'].'</span></label><br />                
                </td></tr>';
                
          echo '<tr><td class="spacer checkboxes"></td><td></td></tr>';
 
          echo '<tr><td class="left checkboxes">
                <input type="checkbox" id="categories'.$category['id'].'plugins" name="categories['.$category['id'].'][plugins]" value="true" '.$checked[11].' class="toolTip" title="'.$langFile['pageSetup_check8'].'::'.$langFile['pageSetup_check8_tip'].'" /><br />
                </td><td class="right checkboxes">
                <label for="categories'.$category['id'].'plugins"><span class="toolTip" title="'.$langFile['pageSetup_check8'].'::'.$langFile['pageSetup_check8_tip'].'">'.$langFile['pageSetup_check8'].'</span></label><br />
                </td></tr>';
          
          echo '<tr><td class="left checkboxes">
                <input type="checkbox" id="categories'.$category['id'].'showtags" name="categories['.$category['id'].'][showtags]" value="true" '.$checked[4].' class="toolTip" title="'.$langFile['pageSetup_check4'].'::'.$langFile['pageSetup_check4_tip'].'" /><br />
                </td><td class="right checkboxes">
                <label for="categories'.$category['id'].'showtags"><span class="toolTip" title="'.$langFile['pageSetup_check4'].'::'.$langFile['pageSetup_check4_tip'].'">'.$langFile['pageSetup_check4'].'</span></label><br />
                </td></tr>';
                
          echo '<tr><td class="spacer checkboxes"></td><td></td></tr>';

          echo '<tr><td class="left checkboxes">
                <input type="checkbox" id="categories'.$category['id'].'showpagedate" name="categories['.$category['id'].'][showpagedate]" value="true" '.$checked[5].' class="toolTip" title="'.$langFile['pageSetup_check5'].'::'.$langFile['pageSetup_check5_tip'].'" /><br />
                </td><td class="right checkboxes">
                <label for="categories'.$category['id'].'showpagedate"><span class="toolTip" title="'.$langFile['pageSetup_check5'].'::'.$langFile['pageSetup_check5_tip'].'">'.$langFile['pageSetup_check5'].'</span></label><br />
                </td></tr>';
                
          echo '<tr><td class="left checkboxes">
                <input type="checkbox" id="categories'.$category['id'].'sortbypagedate" name="categories['.$category['id'].'][sortbypagedate]" value="true" '.$checked[6].' class="toolTip" title="'.$langFile['pageSetup_check6'].'::'.$langFile['pageSetup_check6_tip'].'" /><br />
                </td><td class="right checkboxes">
                <label for="categories'.$category['id'].'sortbypagedate"><span class="toolTip" title="'.$langFile['pageSetup_check6'].'::'.$langFile['pageSetup_check6_tip'].'">'.$langFile['pageSetup_check6'].'</span></label><br /> 
                </td></tr>';
                
          echo '<tr><td class="spacer checkboxes"></td><td></td></tr>';
          
          echo '<tr><td class="left checkboxes">
                <input type="checkbox" id="categories'.$category['id'].'sortascending" name="categories['.$category['id'].'][sortascending]" value="true" '.$checked[7].' class="toolTip" title="'.$langFile['pageSetup_check7'].'::'.$langFile['pageSetup_check7_tip'].'" />
                </td><td class="right checkboxes">
                <label for="categories'.$category['id'].'sortascending"><span class="toolTip" title="'.$langFile['pageSetup_check7'].'::'.$langFile['pageSetup_check7_tip'].'">'.$langFile['pageSetup_check7'].'</span></label>          
                </td></tr>';

          // end of the TABLE for one category
          echo '</table>';
          
          // -----------------------------------------------
          // second TABLE (advanced settings) (with slide in)
          $hidden = ($_POST['savedCategory'] != $category['id']) ? ' class="hidden"' : '';
          
          echo '<table id="advancedConfigTable'.$category['id'].'"'.$hidden.'>     
                <colgroup>
                <col class="left" />
                </colgroup>
                
                <tr><td class="leftTop"></td><td><span class="hint">'.$langFile['pageSetup_advancedSettings_hint'].'</span></td></tr>';
          
          echo '<tr><td class="left">
                <label for="categories'.$category['id'].'styleFile"><span class="toolTip" title="'.$langFile['stylesheet_name_styleFile'].'::'.$langFile['stylesheet_styleFile_tip'].'[br /][br /][span class=hint]'.$langFile['pageSetup_stylesheet_ifempty'].'[/span]">
                '.$langFile['stylesheet_name_styleFile'].'</span></label>
                </td><td class="right">
                <input id="categories'.$category['id'].'styleFile" name="categories['.$category['id'].'][styleFile]" value="'.getStylesByPriority($category['styleFile'],'styleFile',$category['id']).'" class="toolTip" title="'.$langFile['path_absolutepath_tip'].'" />
                <span class="hint">'.$langFile['stylesheet_styleFile_example'].'</span>                
                </td></tr>';
                
          echo '<tr><td class="left">
                <label for="categories'.$category['id'].'styleId"><span class="toolTip" title="'.$langFile['stylesheet_name_styleId'].'::'.$langFile['stylesheet_styleId_tip'].'[br /][br /][span class=hint]'.$langFile['pageSetup_stylesheet_ifempty'].'[/span]">
                '.$langFile['stylesheet_name_styleId'].'</span></label>
                </td><td class="right">
                <input id="categories'.$category['id'].'styleId" name="categories['.$category['id'].'][styleId]" value="'.getStylesByPriority($category['styleId'],'styleId',$category['id']).'" class="toolTip" title="'.$langFile['pageSetup_stylesheet_ifempty'].'" />
                </td></tr>';
                
          echo '<tr><td class="left">
                <label for="categories'.$category['id'].'styleClass"><span class="toolTip" title="'.$langFile['stylesheet_name_styleClass'].'::'.$langFile['stylesheet_styleClass_tip'].'[br /][br /][span class=hint]'.$langFile['pageSetup_stylesheet_ifempty'].'[/span]">
                '.$langFile['stylesheet_name_styleClass'].'</span></label>
                </td><td class="right">
                <input id="categories'.$category['id'].'styleClass" name="categories['.$category['id'].'][styleClass]" value="'.getStylesByPriority($category['styleClass'],'styleClass',$category['id']).'" class="toolTip" title="'.$langFile['pageSetup_stylesheet_ifempty'].'" />
                </td></tr>';
          
          echo '<tr><td class="spacer"></td><td></td></tr>';
          
               // category thumbSize 
          echo '<tr><td class="left">
                <label for="categories'.$category['id'].'thumbWidth"><span class="toolTip" title="'.$langFile['thumbnail_width_tip'].'">
                '.$langFile['thumbnail_name_width'].'</span></label>
                </td><td class="right">
                <input id="categories'.$category['id'].'thumbWidth" name="categories['.$category['id'].'][thumbWidth]" class="short" value="'.$category['thumbWidth'].'" '.$disabled[9].' />
                '.$langFile['thumbSize_unit'].'
                  &nbsp;&nbsp;&nbsp;&nbsp;
                  <span class="toolTip" title="'.$langFile['thumbnail_ratio_name'].'::'.$langFile['thumbnail_ratio_x_tip'].'">
                    <input type="radio" id="categories'.$category['id'].'ratioX" name="categories['.$category['id'].'][thumbRatio]" value="x" '.$checked[9].' />
                    <label for="categories'.$category['id'].'ratioX"> '.$langFile['thumbnail_ratio_fieldText'].'</label>
                  </span>
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
                <label for="categories'.$category['id'].'thumbHeight"><span class="toolTip" title="'.$langFile['thumbnail_height_tip'].'">
                '.$langFile['thumbnail_name_height'].'</span></label>
                </td><td class="right">
                <input id="categories'.$category['id'].'thumbHeight" name="categories['.$category['id'].'][thumbHeight]" class="short" value="'.$category['thumbHeight'].'" '.$disabled[10].' />
                '.$langFile['thumbSize_unit'].'
                  &nbsp;&nbsp;&nbsp;&nbsp;
                  <span class="toolTip" title="'.$langFile['thumbnail_ratio_name'].'::'.$langFile['thumbnail_ratio_y_tip'].'">
                    <input type="radio" id="categories'.$category['id'].'ratioY" name="categories['.$category['id'].'][thumbRatio]" value="y" '.$checked[10].' />
                    <label for="categories'.$category['id'].'ratioY"> '.$langFile['thumbnail_ratio_fieldText'].'</label>
                  </span>
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
                  <span class="toolTip" title="'.$langFile['thumbnail_ratio_name'].'::'.$langFile['thumbnail_ratio_noRatio_tip'].'">
                    <label for="categories'.$category['id'].'noRatio"> '.$langFile['thumbnail_ratio_noRatio'].'</label>
                  </span>
                </td></tr>';
          
          // finish the TABLE for one category
          echo '<tr><td class="leftBottom"></td><td></td></tr>
                </table>';
          
          // SUBMIT: IF advancedConfigTable has not Class "hidden" it stores the categoryId in the savedCategory input
          // and gives the submit anchor to the FORM      
          echo '<input type="submit" value="" name="saveCategories" class="toolTip button submit center" title="'.$langFile['form_submit'].'" onclick="if(!$(\'advancedConfigTable'.$category['id'].'\').hasClass(\'hidden\')) $(\'savedCategory\').value = \''.$category['id'].'\'; submitAnchor(\'categoriesForm\',\'category'.$category['id'].'\');" />
                </div>'; // end slide in box
          
        }
      }        
      ?>    
    <!--<input type="reset" value="" class="toolTip button cancel" title="<?php echo $langFile['form_cancel']; ?>" />-->
    
  </div>
  <div class="bottom"></div>
</div>

</form>