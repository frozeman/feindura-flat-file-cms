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

* categorySetup.php version 1.18
*/

include_once(dirname(__FILE__)."/../backend.include.php");

// VARs
// ---------------------------------------------------------------------------
$categoryInfo = false;


// ----------------------------------------------------------------------------------------------------------------------------------------
// **--** SAVE PROCESS --------------------------------------------------------------------------------------------------------------------
// ----------------------------------------------------------------------------------------------------------------------------------------

// ****** ---------- CREATE NEW CATEGORY
if((isset($_POST['send']) && $_POST['send'] ==  'categorySetup' && isset($_POST['createCategory'])) ||
   $_GET['status'] == 'createCategory') {
   
  // -> GET highest category id
  $newId = getNewCatgoryId();
  
  if($newId == 1)
    $categories = array();
  
  //f�gt dem $categories array einen leeren array an
  array_push($categories, array('id' => $newId)); // gives the new category a id
  if(saveCategories($categories)) {
    
    $categoryInfo = $langFile['categorySetup_createCategory_created'];
    
    // if there is no category dir, trys to create one
    if(!is_dir(DOCUMENTROOT.$adminConfig['savePath'].$newId)) {
        // erstellt ein verzeichnis
        if(!mkdir(DOCUMENTROOT.$adminConfig['savePath'].$newId, 0777)) {
          if($errorWindow) // if there is allready an warning
            $errorWindow .= '<br /><br />'.$langFile['categorySetup_error_createDir'];
          else
            $errorWindow = $langFile['categorySetup_error_createDir'];
      }
    }
    
    $statisticFunctions->saveTaskLog($langFile['log_categorySetup_new']); // <- SAVE the task in a LOG FILE
  } else // throw error
    $errorWindow = $langFile['categorySetup_error_create'];
  
  $savedForm = 'categories';
}

// ****** ---------- DELETE CATEGORY
if(((isset($_POST['send']) && $_POST['send'] ==  'categorySetup' && isset($_POST['deleteCategory'])) ||
   $_GET['status'] == 'deleteCategory') && isset($categories['id_'.$_GET['category']])) {  
  
  // save the name, to put it in the info
  $storedCategoryName = $categories['id_'.$_GET['category']]['name'];
  
  // deletes the category with the given id from the array and saves the categoriesSettings.php
  unset($categories['id_'.$_GET['category']]);  
  if(saveCategories($categories)) {
  
    // Hinweis f�r den Benutzer welche Gruppe gel�scht wurde
    $categoryInfo = $langFile['categorySetup_deleteCategory_deleted'].' &quot;<b>'.$storedCategoryName.'</b>&quot;';
  
    // if there is a category dir, trys to delete it !important deletes all files in it
    if(is_dir(DOCUMENTROOT.$adminConfig['savePath'].$_GET['category'])) {
    
      if($pageContent = $generalFunctions->loadPages($_GET['category'])) {
      
        // deletes possible thumbnails before deleting the category
        foreach($pageContent as $page) {
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
          $errorWindow .= '<br /><br />'.$langFile['categorySetup_error_deleteDir'];
        else
          $errorWindow = $langFile['categorySetup_error_deleteDir'];
      }    
    }
    
    $statisticFunctions->saveTaskLog($langFile['log_categorySetup_delete'],$storedCategoryName); // <- SAVE the task in a LOG FILE
  } else // throw error
    $errorWindow = $langFile['categorySetup_error_delete'];

  $savedForm = 'categories';
}

// ****** ---------- MOVE CATEGORY
if(substr($_GET['status'],0,12) == 'moveCategory' && !empty($_GET['category']) && is_numeric($_GET['category'])) {
  
  // move the categories in the categories array
  if($_GET['status'] == 'moveCategoryUp')
    $direction = 'up';
  if($_GET['status'] == 'moveCategoryDown')
    $direction = 'down';
    
  if($categories = moveCategories($_GET['category'],$direction)) {
  
    $categoryInfo = $langFile['categorySetup_moveCategory_moved'];
    
    // save the categories array
    if(saveCategories($categories)) {
      $documentSaved = true; // set documentSaved status
      $statisticFunctions->saveTaskLog($langFile['log_categorySetup_move'],$categories['id_'.$_GET['category']]['name']); // <- SAVE the task in a LOG FILE
    } else
      $errorWindow = $langFile['categorySetup_error_save'];
    
  }
    
  $savedForm = 'categories';
}


// ****** ---------- SAVE CATEGORIES
if(isset($_POST['send']) && $_POST['send'] ==  'categorySetup' && isset($_POST['saveCategories'])) {
  
  // cleans the category names
  $catewgoriesCleaned = array();
  foreach($_POST['categories'] as $category) {
      $category['name'] = $generalFunctions->clearTitle($category['name']);
      $catewgoriesCleaned[$category['id']] = $category;
  }

  if(saveCategories($catewgoriesCleaned)) {
    $documentSaved = true; // set documentSaved status
    $statisticFunctions->saveTaskLog($langFile['log_categorySetup_saved']); // <- SAVE the task in a LOG FILE
  } else
    $errorWindow = $langFile['categorySetup_error_save'];
  
  $savedForm = 'categories';
}

@include (dirname(__FILE__)."/../../config/category.config.php"); // loads the saved categories again

// ------------------------------- ENDE of the SAVING SCRIPT -------------------------------------------------------------------------------


// CHECKs THE IF THE NECESSARY FILEs ARE WRITEABLE, otherwise throw an error
// ----------------------------------------------------------------------------------------
$unwriteableList = '';

// check config files
$unwriteableList .= fileFolderIsWritableWarning($adminConfig['basePath'].'config/');
if(file_exists(DOCUMENTROOT.$adminConfig['basePath'].'config/category.config.php'))
  $unwriteableList .= fileFolderIsWritableWarning($adminConfig['basePath'].'config/category.config.php');

// gives the error OUTPUT if one of these files in unwriteable
if($unwriteableList) {
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

<!-- CATEGORIES SETTINGS -->

<form action="?site=categorySetup" id="categoriesForm" method="post" enctype="multipart/form-data" accept-charset="UTF-8">
  <div>
  <input type="hidden" name="send" value="categorySetup" />
  <input type="hidden" name="savedCategory" id="savedCategory" value="" />
  </div>

<div class="block">
  <h1><a href="#" name="categories"><?php echo $langFile['categorySetup_h1']; ?></a></h1>
  <div class="content">
  
    <table>     
      <colgroup>
      <col class="left" />
      </colgroup>
  
      <tr><td class="leftTop"></td><td></td></tr>

      <tr><td class="left">
        <a href="?site=categorySetup&amp;status=createCategory#category<?php echo getNewCatgoryId(); ?>" class="createCategory toolTip" title="<?php echo $langFile['categorySetup_createCategory']; ?>::"></a>
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
      if(is_array($categories)) {
        foreach($categories as $category) {
        
          // prevent using the $check vars from the last category
          unset($checked);
          
          // checks the category settings
          if($category['public'])
            $checked[1] = 'checked="checked"';

          if($category['createdelete'])
            $checked[2] = 'checked="checked"';
            
          if($category['thumbnail'])
            $checked[3] = 'checked="checked"';
          
          if($category['tags'])
            $checked[4] = 'checked="checked"';
          
          if($category['sortdate'])
            $checked[5] = 'checked="checked"';
            
          if($category['sortbydate'])
            $checked[6] = 'checked="checked"';
          
          if($category['sortascending'])
            $checked[7] = 'checked="checked"';
            
          if($category['thumbRatio'] == '')
            $checked[8] = 'checked="checked"';
            
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
            $categoryName = '<i>'.$langFile['categorySetup_createCategory_unnamed'].'</i>';
          else
            $categoryName = $category['name'];
          
          echo '<tr><td class="left">';
          echo '<span style="font-size:20px;font-weight:bold;">'.$categoryName.'</span><br />ID '.$category['id'];
          echo '<input type="hidden" name="categories['.$category['id'].'][id]" value="'.$category['id'].'" />';
          echo '</td>'; 
          
                // deleteCategory
          echo '<td class="right" style="width:525px;">
                <div style="border-bottom: 1px dotted #cccccc;width:400px;height:15px;float:left !important;"></div>
                <a href="?site=categorySetup&amp;status=deleteCategory&amp;category='.$category['id'].'#categories" class="deleteCategory toolTip" onclick="openWindowBox(\'library/sites/deleteCategory.php?status=deleteCategory&amp;category='.$category['id'].'\',\''.$langFile['btn_pageThumbnailDelete'].'\');return false;" title="'.$langFile['categorySetup_deleteCategory'].'::'.$category['name'].'[br /][br /][span style=color:#990000;]'.$langFile['categorySetup_deleteCategory_warning'].'[/span]"></a>';
                // advanced Settings slide link
          echo '<a href="#" class="down" style="position:relative; bottom:-11px;">'.$langFile['categorySetup_advancedSettings'].'</a>
                </td></tr>';          
                // category name
          echo '<tr><td class="left">
                '.$langFile['categorySetup_feld1'].'
                </td><td class="right">
                <input name="categories['.$category['id'].'][name]" value="'.$category['name'].'" />
                </td></tr>';
          
          echo '<tr><td class="leftBottom"></td><td></td></tr>';
          
          echo '<tr><td class="left checkboxes">';
          
               // category settings
          echo '<input type="checkbox" id="categories'.$category['id'].'public" name="categories['.$category['id'].'][public]" value="true" '.$checked[1].' class="toolTip" title="'.$langFile['categorySetup_check1'].'::'.$langFile['categorySetup_check1_tip'].'" /><br />
                <br />
                <input type="checkbox" id="categories'.$category['id'].'createdelete" name="categories['.$category['id'].'][createdelete]" value="true" '.$checked[2].' class="toolTip" title="'.$langFile['categorySetup_check2'].'::'.$langFile['categorySetup_check2_tip'].'" /><br />
                <input type="checkbox" id="categories'.$category['id'].'thumbnail" name="categories['.$category['id'].'][thumbnail]" value="true" '.$checked[3].' class="toolTip" title="'.$langFile['categorySetup_check3'].'::'.$langFile['categorySetup_check3_tip'].'" /><br />                
                <br />
                <input type="checkbox" id="categories'.$category['id'].'tags" name="categories['.$category['id'].'][tags]" value="true" '.$checked[4].' class="toolTip" title="'.$langFile['categorySetup_check4'].'::'.$langFile['categorySetup_check4_tip'].'" /><br />
                <br />
                <input type="checkbox" id="categories'.$category['id'].'sortdate" name="categories['.$category['id'].'][sortdate]" value="true" '.$checked[5].' class="toolTip" title="'.$langFile['categorySetup_check5'].'::'.$langFile['categorySetup_check5_tip'].'" /><br />
                <input type="checkbox" id="categories'.$category['id'].'sortbydate" name="categories['.$category['id'].'][sortbydate]" value="true" '.$checked[6].' class="toolTip" title="'.$langFile['categorySetup_check6'].'::'.$langFile['categorySetup_check6_tip'].'" /><br />
                <br />
                <input type="checkbox" id="categories'.$category['id'].'sortascending" name="categories['.$category['id'].'][sortascending]" value="true" '.$checked[7].' class="toolTip" title="'.$langFile['categorySetup_check7'].'::'.$langFile['categorySetup_check7_tip'].'" />
                
                </td><td class="right checkboxes">';
        
              // category up / down
              //(!!!problem with #category'.$category['id'].' in the link; no ANCHOR possible?)
          echo '<a href="?site=categorySetup&amp;status=moveCategoryUp&amp;category='.$category['id'].'#category'.$category['id'].'" class="categoryUp toolTip" title="'.$langFile['categorySetup_moveCategory_up_tip'].'::"></a>
                <a href="?site=categorySetup&amp;status=moveCategoryDown&amp;category='.$category['id'].'#category'.$category['id'].'" class="categoryDown toolTip" title="'.$langFile['categorySetup_moveCategory_down_tip'].'::"></a>';
                
                
          echo '<label for="categories'.$category['id'].'public">';
          
              $publicSignStyle = ' style="position:relative; top:-3px; float:left;"';        
              // shows the public or unpublic picture
              if($checked[1])
                echo '<img src="library/image/sign/category_public.png" alt="public" class="toolTip" title="'.$langFile['status_category_public'].'"'.$publicSignStyle.' />&nbsp;';
              else
                echo '<img src="library/image/sign/category_nonpublic.png" alt="closed" class="toolTip" title="'.$langFile['status_category_nonpublic'].'"'.$publicSignStyle.' />&nbsp;';
                
          echo '<span class="toolTip" title="'.$langFile['categorySetup_check1'].'::'.$langFile['categorySetup_check1_tip'].'">'.$langFile['categorySetup_check1'].'</span></label><br />
                <br />';
          
          echo '<label for="categories'.$category['id'].'createdelete"><span class="toolTip" title="'.$langFile['categorySetup_check2'].'::'.$langFile['categorySetup_check2_tip'].'">'.$langFile['categorySetup_check2'].'</span></label><br />  
                <label for="categories'.$category['id'].'thumbnail"><span class="toolTip" title="'.$langFile['categorySetup_check3'].'::'.$langFile['categorySetup_check3_tip'].'">'.$langFile['categorySetup_check3'].'</span></label><br />                
                <br />
                <label for="categories'.$category['id'].'tags"><span class="toolTip" title="'.$langFile['categorySetup_check4'].'::'.$langFile['categorySetup_check4_tip'].'">'.$langFile['categorySetup_check4'].'</span></label><br />
                <br />
                <label for="categories'.$category['id'].'sortdate"><span class="toolTip" title="'.$langFile['categorySetup_check5'].'::'.$langFile['categorySetup_check5_tip'].'">'.$langFile['categorySetup_check5'].'</span></label><br />
                <label for="categories'.$category['id'].'sortbydate"><span class="toolTip" title="'.$langFile['categorySetup_check6'].'::'.$langFile['categorySetup_check6_tip'].'">'.$langFile['categorySetup_check6'].'</span></label><br /> 
                <br />
                <label for="categories'.$category['id'].'sortascending"><span class="toolTip" title="'.$langFile['categorySetup_check7'].'::'.$langFile['categorySetup_check7_tip'].'">'.$langFile['categorySetup_check7'].'</span></label>          
                </td></tr>';
          
          // finish the TABLE for one category
          echo '</table>';
          
          // -----------------------------------------------
          // second TABLE (advanced settings) (with slide in)
          if($_POST['savedCategory'] != $category['id'])
            $hidden = ' class="hidden"';
          else
            $hidden = '';
          
          echo '<table id="advancedConfigTable'.$category['id'].'"'.$hidden.'>     
                <colgroup>
                <col class="left" />
                </colgroup>
                
                <tr><td class="leftTop"></td><td><span class="hint">'.$langFile['categorySetup_advancedSettings_hint'].'</span></td></tr>';
          
          echo '<tr><td class="left">
                <label for="categories'.$category['id'].'styleFile"><span class="toolTip" title="'.$langFile['stylesheet_name_styleFile'].'::'.$langFile['stylesheet_styleFile_tip'].'[br /][br /]'.$langFile['categorySetup_stylesheet_ifempty'].'">
                '.$langFile['stylesheet_name_styleFile'].'</span></label>
                </td><td class="right">
                <input id="categories'.$category['id'].'styleFile" name="categories['.$category['id'].'][styleFile]" value="'.$category['styleFile'].'" class="toolTip" title="'.$langFile['path_absolutepath_tip'].'" />
                <span class="hint">'.$langFile['stylesheet_styleFile_example'].'</span>                
                </td></tr>';
                
          echo '<tr><td class="left">
                <label for="categories'.$category['id'].'styleId"><span class="toolTip" title="'.$langFile['stylesheet_name_styleId'].'::'.$langFile['stylesheet_styleId_tip'].'[br /][br /]'.$langFile['categorySetup_stylesheet_ifempty'].'">
                '.$langFile['stylesheet_name_styleId'].'</span></label>
                </td><td class="right">
                <input id="categories'.$category['id'].'styleId" name="categories['.$category['id'].'][styleId]" value="'.$category['styleId'].'" class="toolTip" title="'.$langFile['categorySetup_stylesheet_ifempty'].'" />
                </td></tr>';
                
          echo '<tr><td class="left">
                <label for="categories'.$category['id'].'styleClass"><span class="toolTip" title="'.$langFile['stylesheet_name_styleClass'].'::'.$langFile['stylesheet_styleClass_tip'].'[br /][br /]'.$langFile['categorySetup_stylesheet_ifempty'].'">
                '.$langFile['stylesheet_name_styleClass'].'</span></label>
                </td><td class="right">
                <input id="categories'.$category['id'].'styleClass" name="categories['.$category['id'].'][styleClass]" value="'.$category['styleClass'].'" class="toolTip" title="'.$langFile['categorySetup_stylesheet_ifempty'].'" />
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