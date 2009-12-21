<?php
/*
    feindura - Flat File Content Management System
    Copyright (C) 2009 Fabian Vogelsteller [frozeman.de]

    This program is free software;
    you can redistribute it and/or modify it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 3 of the License, or (at your option) any later version.

    This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY;
    without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
    See the GNU General Public License for more details.

    You should have received a copy of the GNU General Public License along with this program;
    if not,see <http://www.gnu.org/licenses/>.
*/
// editor.php version 1.81

include_once("library/backend.include.php");
//include("library/thirdparty/fckeditor/fckeditor.php");

// VARs
// ---------------------------------------------------------------------------
$savedForm = false;

$page	= $_GET['page'];
$category = $_GET['category'];


// SAVE the PAGE
// -----------------------------------------------------------------------------
if($_POST['save']) {

  $page	= $_POST['id'];
  $category = $_POST['category'];
  $_GET['page'] = $page;
  $_GET['category'] = $category;  
  
  // Datum erzeugung
  $saveDate	= date('Y')."-".date('m')."-".date('d').' '.date("H:i:s",time());
  
  // format tags  
  $_POST['tags'] = str_replace(array(',',';'), ' ', $_POST['tags']);
  $_POST['tags'] = preg_replace("/ +/", ' ', $_POST['tags']);
  $_POST['tags'] = htmlentities($_POST['tags'], ENT_QUOTES, 'UTF-8');
  
  $_POST['title'] = $generalFunctions->clearTitle($_POST['title']);
  
  //$postArray['FCKeditor'] = str_replace("<br />", "<br>", $postArray['FCKeditor'] );
  //$postArray['FCKeditor'] = str_replace("/>", ">", $postArray['FCKeditor'] );
  //$postArray['FCKeditor'] = str_replace("'", "\'", $postArray['FCKeditor'] ); //&#039;
  // entfernt mehrfache leerzeichen hintereinander
  $_POST['HTMLEditor'] = preg_replace("/ +/", ' ', $_POST['HTMLEditor'] );
  $_POST['HTMLEditor'] = str_replace("'", "\'", $_POST['HTMLEditor'] ); //&#039;
  
  
  // *** CREATE NEW PAGE ----------------------  
  if ($page == 'new') {
    
    // looks fore the highest id (FLATFILES)
    $page = getHighestId();
    $page++;
    $_POST['id'] = $page;
    $_POST['sortorder'] = $page;
    $_GET['page'] = $page;
  
    $pageContent['log_visitCount'] = '0';
    
    $logText = $langFile['log_page_new'];
    
  // *** SAVE PAGE ----------------------
  } else {
  
    // wenn die flatfile existiert, lade die content variable (wird für thumbnail benötigt)
    if(!$pageContent = $generalFunctions->readPage($page,$category))
      $errorWindow = $langFile['file_error_read'];
   
    $logText = $langFile['log_page_saved']; 
  }
  
  // only save page if no error occured
  if($errorWindow === false) {
  
  
    // speichert den inhalt in der flatfile
    $_POST['savedate'] = $saveDate;
    $_POST['content'] = $_POST['HTMLEditor'];
    $_POST['thumbnail'] = $pageContent['thumbnail'];
    
    // VALIDATE the SORT DATE
    if(($sortDate = $statisticFunctions->validateDateFormat($_POST['sortdate']['date'])) === false) {
      $sortDate = $_POST['sortdate']['date'];
    }
    // set the validated date to the post var
    $_POST['sortdate']['date'] = $sortDate;
    
    //echo '<br />'.$_POST['sortdate']['before'];
    //echo '<br />'.$_POST['sortdate']['date'];
    
    if(empty($_POST['sortorder']))
      $_POST['sortorder'] = $pageContent['sortorder'];
  
    // checks the Pages Styles
    // if the given Styles DONT MATCH the main HTMl editor Styles, or the Category Sytles, than save these
    if(!empty($categories['id_'.$category]['styleFile'])) { if($_POST['styleFile'] == $categories['id_'.$category]['styleFile']) $_POST['styleFile'] = ''; } elseif($_POST['styleFile'] == $adminConfig['editor']['styleFile']) { $_POST['styleFile'] = ''; }
    if(!empty($categories['id_'.$category]['styleId'])) { if($_POST['styleId'] == $categories['id_'.$category]['styleId']) $_POST['styleId'] = ''; } elseif($_POST['styleId'] == $adminConfig['editor']['styleId']) { $_POST['styleId'] = ''; }
    if(!empty($categories['id_'.$category]['styleClass'])) { if($_POST['styleClass'] == $categories['id_'.$category]['styleClass']) $_POST['styleClass'] = ''; } elseif($_POST['styleClass'] == $adminConfig['editor']['styleClass']) { $_POST['styleClass'] = ''; }
    
    if(!empty($_POST['styleFile']) && substr($_POST['styleFile'],0,1) !== '/')
          $_POST['styleFile'] = '/'.$_POST['styleFile'];
    
    // gets the visit status
    $_POST['log_visitCount'] = $pageContent['log_visitCount'];
    $_POST['log_visitTime_max'] = $pageContent['log_visitTime_max'];
    $_POST['log_visitTime_min'] = $pageContent['log_visitTime_min'];
    $_POST['log_lastVisit'] = $pageContent['log_lastVisit'];
    $_POST['log_firstVisit'] = $pageContent['log_firstVisit'];
    $_POST['log_lastIP'] = $pageContent['log_lastIP'];
    $_POST['log_searchwords'] = $pageContent['log_searchwords'];
      
    if($generalFunctions->savePage($category,$page,$_POST)) {
      $documentSaved = true;
      $statisticFunctions->saveTaskLog($logText,'<a href="index.php?category='.$category.'&amp;page='.$page.'">'.$_POST['title'].'</a>'); // <- SAVE the task in a LOG FILE
    } else
      $errorWindow = $langFile['editor_savepage_error_save'];
  }
  
  // sets which block should be opend after saving
  $savedForm = $_POST['savedBlock'];
}

// -------------------------------------------------------------------------------------------------------------------
// show the PAGE CONTENT
// ------------------------------------------------------------------------------

// -> read PAGE (saved or given)
// -> CHECK for NEW PAGE
if($pageContent = $generalFunctions->readPage($page,$category))
  $newPage = false;
else
  $newPage = true;

// set Title
if($newPage) {
  //$pageContent = '';  
  $pageTitle = $langFile['editor_h1_createpage'];
  $_GET['page'] = 'new';
  $page = 'new';
  
} else {  
  $pageTitle = $pageContent['title'];  
}

?>
<script type="text/javascript">
/* <![CDATA[ */

// FCK Editor Toolbar wechseln
function ChangeToolbar( toolbarName )
{
  var page = "<?php echo $pageId; ?>";
  var group = "<?php echo $_GET['category']; ?>";
  window.location.href = window.location.pathname + "?category=" + group + "&id=" + page + "&Toolbar=" + toolbarName ;
}
function FCKeditor_OnComplete( editorInstance )
{
  var oCombo = document.getElementById( 'cmbToolbars' ) ;
  oCombo.value = editorInstance.ToolbarSet.Name ;
  oCombo.style.visibility = '' ;
}

/* ]]> */
</script>
<?php

// create the FORM
echo '<form action="'.$_SERVER['PHP_SELF'].'?category='.$category.'&amp;page='.$page.'" method="post" accept-charset="UTF-8">
      <div>
      <input type="hidden" name="save" value="true" />
      <input type="hidden" name="category" value="'.$category.'" />
      <input type="hidden" name="id" value="'.$page.'" />
      <input type="hidden" name="savedBlock" id="savedBlock" value="" />
      </div>';

?>
<div class="block pageHead">  
<?php

// shows ID and differtnet header color if its a CATEGORY
if($category['id'] != 0) {
  $headerColor = 'blue'; //" comes in the h1
} else {
  $headerColor = 'brown'; //" comes in the h1
}

// -> show NEWPAGE ICON
if($newPage) {
  $newPageIcon = '<img src="library/image/sign/newPageIcon_middle.png" style="float:left;" />';  
}

// -> checks for startpage, and show STARTPAGE ICON
if($adminConfig['setStartPage'] && $pageContent['id'] == $websiteConfig['startPage']) {
  $startPageIcon = '<img src="library/image/sign/startPageIcon_middle.png" style="float:left;" />';
  $startPageTitle = ' toolTip" title="'.$langFile['btn_startPage_set'].'::" style="line-height:left;'; //" comes in the h1
}

// -> show the page PAGE HEADLINE
echo '<h1 class="'.$headerColor.$startPageTitle.'">'.$newPageIcon.$startPageIcon.'<span class="'.$headerColor.'">'.$pageTitle.'</span>';

// -> show LAST SAVE DATE TIME
$saveDate =  $statisticFunctions->formatDate($pageContent['savedate']);
$saveTime =  $statisticFunctions->formatTime($pageContent['savedate']);

if(!$newPage)
  echo '<br /><span style="font-size:11px;">[ '.$langFile['editor_h1_savedate'].' '.$saveDate.' '.$saveTime.' ]</span></h1>';
else
  echo '</h1>';
?>
  <div class="content">
   
    <?php 
    // -> show thumbnail if the page has one
    if(!empty($pageContent['thumbnail'])) {
      
      $thumbnailWidth = getimagesize(DOCUMENTROOT.$adminConfig['uploadPath'].$adminConfig['pageThumbnail']['path'].$pageContent['thumbnail']);
      $thumbnailWidth = $thumbnailWidth[0];
      
      if($thumbnailWidth <= 200)
        $thumbnailWidth = ' width="'.$thumbnailWidth.'"';
      else
        $thumbnailWidth = ' width="200"';
      
      echo '<div style="z-index:5; position:relative; margin-bottom: 10px; float:right; line-height:28px; text-align:center;">';
      echo '<span class="toolTip" title="'.$adminConfig['uploadPath'].$adminConfig['pageThumbnail']['path'].$pageContent['thumbnail'].'::'.$langFile['thumbnail_tip'].'">'.$langFile['thumbnail_name'].'</span><br />';
      echo '<img src="'.$adminConfig['uploadPath'].$adminConfig['pageThumbnail']['path'].$pageContent['thumbnail'].'" class="thumbnailPreview toolTip"'.$thumbnailWidth.' alt="thumbnail" title="'.$adminConfig['uploadPath'].$adminConfig['pageThumbnail']['path'].$pageContent['thumbnail'].'::'.$langFile['thumbnail_tip'].'" />';
      echo '</div>';
    
    // -> show the thumbnail upload button if there is no thumbnail yet
    } elseif(!$newPage &&
            (($pageContent['category'] == 0 && $adminConfig['page']['thumbnailUpload']) ||
            $categories['id_'.$pageContent['category']]['thumbnail'])) {  
      
        echo '<a href="?site=pageThumbnailUpload&amp;category='.$_GET['category'].'&amp;page='.$_GET['page'].'" onclick="openWindowBox(\'library/sites/pageThumbnailUpload.php?site='.$_GET['site'].'&amp;category='.$_GET['category'].'&amp;page='.$_GET['page'].'\',\''.$langFile['btn_pageThumbnailUpload'].'\',true);return false;" title="'.$langFile['btn_pageThumbnailUpload_title'].'::" class="pageThumbnailUpload toolTip">&nbsp;</a>';
    }
    ?>
    
    <table>     
      <colgroup>
      <col class="left" />
      </colgroup>
  
      <tr><td class="leftTop"></td><td></td></tr>      
      <?php
      
      if(!$newPage)
      echo '<tr>
            <td class="left">      
            <span class="info toolTip" title="'.$langFile['editor_h1_id'].'::'.$langFile['editor_h1_id_tip'].'"><strong>'.$langFile['editor_h1_id'].'</strong></span>
            </td><td class="right">
            <span class="info">'.$_GET['page'].'</span>
            </td>
            </tr>';
      
      if($_GET['category'] == 0) // show only if categories exist
        $categoryName = '<span style="color:#A6A6A6;">'.$langFile['editor_h1_categoryid_noCategory'].'</span>';
      else
        $categoryName = $_GET['category'].' <span style="color:#A6A6A6;">&rArr; '.$categories['id_'.$_GET['category']]['name'].'</span>';
        
      echo '<tr>
            <td class="left">
            <span class="info"><strong>'.$langFile['editor_h1_categoryid'].'</strong></span>
            </td><td class="right">
            <span class="info">'.$categoryName.'</span>
            </td>
            </tr>';
      
      if(!$newPage) {
        // shows the category var in the link or not
        if($_GET['category'] == 0)
          $categoryInLink = '';
        else
          $categoryInLink = $adminConfig['varName']['category'].'='.$_GET['category'].'&amp;';
        
        
        // shows the page link
        if($adminConfig['speakingUrl'] == '')
          $hostUrl = $adminConfig['url'].'/';
        else
          $hostUrl = $adminConfig['url'];
        echo '<tr>
              <td class="left">
              <span class="info"><strong>'.$langFile['editor_h1_linktothispage'].'</strong></span>
              </td><td class="right">
              <span class="info" style="font-size:11px;"><a href="http://'.$hostUrl.$generalFunctions->createHref($pageContent).'" class="extern">'.$hostUrl.$generalFunctions->createHref($pageContent).'</a></span>
              </td>
              </tr>';
      }
      ?>        
      <tr><td class="leftBottom"></td><td></td></tr>
    </table>    
    
  </div>
  <div class="bottom"></div>
</div>

<?php
if(!$newPage) {
?>
<!-- ***** PAGE STATISTICS -->
<?php
// dont shows the block below if pageSettings is saved
//if($savedForm)  $hidden = ' hidden';
//else $hidden = '';
$hidden = ' hidden';
?>
<div class="block<?php echo $hidden; ?>">
  <h1><a href="#"><img src="library/image/sign/statisticIcon_small.png" alt="icon" /><?php echo $langFile['editor_pagestatistics_h1']; ?></a></h1>
  <div class="content">
  <?php
  // -> format vars
  // --------------
  $firstVisitDate = $statisticFunctions->formatDate($pageContent['log_firstVisit']);
  $firstVisitTime = $statisticFunctions->formatTime($pageContent['log_firstVisit']);
  $lastVisitDate = $statisticFunctions->formatDate($pageContent['log_lastVisit']);
  $lastVisitTime = $statisticFunctions->formatTime($pageContent['log_lastVisit']);
  
  $visitTimes_max = explode('|',$pageContent['log_visitTime_max']);
  $visitTimes_min = explode('|',$pageContent['log_visitTime_min']);
  ?>  
  <table>   
    
    <colgroup>
    <col class="left" />
    </colgroup>
    
    <tr><td class="leftTop"></td><td></td></tr>
    
    <?php
    
    if($pageContent['log_firstVisit']) {
    ?>
    <tr>
      <td class="left">
        <?php echo $langFile['log_visitCount']; ?>
      </td><td class="right" style="font-size:15px;">
        <?php
        // -> VISIT COUNT
        echo '<span class="brown" style="font-weight:bold;font-size:20px;">'.$statisticFunctions->formatHighNumber($pageContent['log_visitCount']).'</span>';
        ?>
      </td>      
    </tr>
    <tr>
      <td class="left">
        <?php echo $langFile['log_firstVisit']; ?>
      </td><td class="right" style="font-size:15px;">
        <?php
        // -> FIRST VISIT
        echo '<span class="info brown toolTip" title="'.$firstVisitTime.'::">'.$firstVisitDate.'</span> ';
        ?>
      </td>
    </tr>
    
    <tr>
      <td class="left">
        <?php echo $langFile['log_lastVisit']; ?>
      </td><td class="right" style="font-size:15px;">
        <?php
        // -> LAST VISIT
        echo '<span class="info blue toolTip" title="'.$lastVisitTime.'::">'.$lastVisitDate.'</span> ';
        ?>
      </td>
    </tr>
    
    <tr><td class="spacer"></td><td></td></tr>
    
    <tr>
      <td class="left">
        <?php echo $langFile['log_visitTime_max']; ?>
      </td><td class="right">
        <?php
        // -> VISIT TIME MAX
        $showTimeHead = true;
        foreach($visitTimes_max as $visitTime_max) {          
          if($visitTime_max_formated = $statisticFunctions->showVisitTime($visitTime_max)) {
            if($showTimeHead)
              echo '<span class="blue toolTip" id="visitTimeMax" title="'.$visitTime_max.'::">'.$visitTime_max_formated.'</span><br />
              <div id="visitTimeMaxContainer">';
            else            
              echo '<span class="blue toolTip" title="'.$visitTime_max.'::">'.$visitTime_max_formated.'</span><br />';
            
            $showTimeHead = false;            
          }
        }
        echo '</div>';    
        ?>
      </td>
    </tr>
    <tr>
      <td class="left">
        <?php echo $langFile['log_visitTime_min']; ?>
      </td><td class="right">
        <?php
        // -> VISIT TIME MIN
        $showTimeHead = true;
        $visitTimes_min = array_reverse($visitTimes_min);
        foreach($visitTimes_min as $visitTime_min) {          
          if($visitTime_min_formated = $statisticFunctions->showVisitTime($visitTime_min)) {
            if($showTimeHead)
              echo '<span class="blue toolTip" id="visitTimeMin" title="'.$visitTime_min.'::">'.$visitTime_min_formated.'</span><br />
              <div id="visitTimeMinContainer">';
            else            
              echo '<span class="blue toolTip" title="'.$visitTime_min.'::">'.$visitTime_min_formated.'</span><br />';
          
            $showTimeHead = false;
          }          
        }
        echo '</div>';
        ?>
      </td>
    </tr>
    <?php
    // -> show NO VISIT
    } else {
      echo '<tr>
              <td class="left">
              </td><td class="right" style="font-size:15px;">
                '.$langFile['log_novisit'].'
              </td>
            </tr>';
    }    
    ?>
    
    <tr><td class="spacer"></td><td></td></tr>
    
    <tr>
      <td class="left">
        <span><?php echo $langFile['log_tags_description']; ?></span>
      </td><td class="right">
      <div style="width:95%;max-height:160px;border:0px solid #cccccc;padding:0px 10px;">
      <?php
      
      // -> show TAG CLOUD
      echo '<div class="tagCloud">';
      $statisticFunctions->createTagCloud($pageContent['log_searchwords']);
      echo '</div>';

      ?>
      </div>
      </td>
    </tr>
    
    <tr><td class="leftBottom"></td><td></td></tr>
    
  </table>
  </div>
  <div class="bottom"></div>
</div>
<?php
}
?>

<!-- ***** PAGE SETTINGS -->
<?php
// shows the block below if it is the ones which is saved before
if($newPage || $savedForm == 'pageSettings')  $hidden = '';
else $hidden = ' hidden';
?>
<div class="block<?php echo $hidden; ?>">
  <h1><a href="#"><?php echo $langFile['editor_pageSettings_h1']; ?></a></h1>
  <div class="content">
    <table>
     
      <colgroup>
      <col class="left" />
      </colgroup>
  
      <tr><td class="leftTop"></td><td></td></tr>
      
      <!-- ***** PAGE TITLE -->
      
      <tr><td class="left">
      <label for="edit_title"><span class="toolTip" title="<?php echo $langFile['editor_pageSettings_feld1'].'::'.$langFile['editor_pageSettings_feld1_tip'] ?>">
      <?php echo $langFile['editor_pageSettings_feld1'] ?></span></label>
      </td><td class="right">
        <input id="edit_title" name="title" value="<?php echo $pageContent['title']; ?>" />        
      </td></tr>
      
      <tr><td class="spacer"></td><td></td></tr>      
      
      <?php
      // shows only if activated
      if($categories['id_'.$_GET['category']]['sortdate']) { ?>  
      <!-- ***** SORT DATE -->
      
      <?php
      
      if($adminConfig['dateFormat'] == 'eu')
        $dateFormat = $langFile['date_eu'];
      else
        $dateFormat = $langFile['date_int'];
        
      // add the DATE of TODAY, if its a NEW PAGE
      if($newPage) {
          $pageContent['sortdate']['date'] = date('Y')."-".date('m')."-".date('d');
      }
      
      ?>      
      <tr><td class="left">
      <label for="edit_sortdate">
      <?php
      // CHECKs the DATE FORMAT
      if(!empty($pageContent['sortdate']) && !empty($pageContent['sortdate']['date']) && $statisticFunctions->validateDateFormat($pageContent['sortdate']['date']) === false)
        echo '<span class="toolTip" style="color:#950300;" title="'.$langFile['editor_pageSettings_sortDate_error'].'::'.$langFile['editor_pageSettings_sortDate_error_tip'].'[br /][b]'.$dateFormat.'[/b]"><b>'.$langFile['editor_pageSettings_sortDate_error'].'</b></span>'; 
      else
        echo '<span class="toolTip" title="'.$langFile['editor_pageSettings_feld3'].'::'.$langFile['editor_pageSettings_feld3_tip'].'">'.$langFile['editor_pageSettings_feld3'].'</span>';
      ?>
      </label>
      </td><td class="right">
        <input name="sortdate[before]" value="<?php echo $pageContent['sortdate']['before']; ?>" class="toolTip" title="<?php echo $langFile['editor_pageSettings_feld3_inpuTip_part1']; ?>" style="width:140px;" />
        <input id="edit_sortdate" name="sortdate[date]" value="<?php echo $statisticFunctions->formatDate($pageContent['sortdate']['date']); ?>" class="toolTip" title="<?php echo $langFile['editor_pageSettings_feld3'].'::'.$langFile['editor_pageSettings_feld3_inpuTip_part2'].' '.$dateFormat; ?>" style="width:90px; text-align:center;" />
        <input name="sortdate[after]" value="<?php echo $pageContent['sortdate']['after']; ?>" class="toolTip" title="<?php echo $langFile['editor_pageSettings_feld3_inpuTip_part3']; ?>" style="width:140px;" />
      </td></tr>
      <?php } ?>
      
      <!-- ***** TAGS -->
      
      <tr><td class="left">
      <label for="edit_tags"><span class="toolTip" title="<?php echo $langFile['editor_pageSettings_feld2'].'::'.$langFile['editor_pageSettings_feld2_tip'] ?>">
      <?php echo $langFile['editor_pageSettings_feld2'] ?></span></label>
      </td><td class="right">
        <input id="edit_tags" name="tags" class="toolTip" value="<?php echo $pageContent['tags']; ?>" title="<?php echo $langFile['editor_pageSettings_feld2'].'::'.$langFile['editor_pageSettings_feld2_tip_inputTip']; ?>" />        
      </td></tr>
      
      <tr><td class="leftBottom"></td><td></td></tr>      
      
      <tr><td class="spacer checkboxes"></td><td></td></tr>
      
      <!-- ***** PUBLIC/UNPUBLIC -->
      
      <tr><td class="left checkboxes">    
        <input type="checkbox" id="edit_public" name="public" value="true" <?php if($pageContent['public']) echo 'checked'; ?> />
      </td><td class="right">
        <label for="edit_public">
        <?php          
          $publicSignStyle = ' style="position:relative; top:-3px; float:left;"';
        
        // shows the public or unpublic picture
        if($pageContent['public'])
          echo '<img src="library/image/sign/page_public.png" alt="public" class="toolTip" title="'.$langFile['status_page_public'].'"'.$publicSignStyle.' />';
        else
          echo '<img src="library/image/sign/page_nonpublic.png" alt="closed" class="toolTip" title="'.$langFile['status_page_nonpublic'].'"'.$publicSignStyle.' />';

        ?>
        &nbsp;<span class="toolTip" title="<?php echo $langFile['editor_pageSettings_feld4'].'::'.$langFile['editor_pageSettings_feld4_tip'] ?>">
        <?php echo $langFile['editor_pageSettings_feld4']; ?></span></label>        
      </td></tr>
      
      <tr><td class="spacer checkboxes"></td><td></td></tr>
      <tr><td class="spacer checkboxes"></td><td></td></tr> 
      
    </table>
    
    <!--<input type="reset" value="" class="toolTip button cancel" title="<?php echo $langFile['form_cancel']; ?>" />-->
    <input type="submit" value="" class="toolTip button submit center" title="<?php echo $langFile['form_submit']; ?>" onclick="$('savedBlock').value = 'pageSettings';" />
  </div>
  <div class="bottom"></div>
</div>


<div class="block editor">
<?php

// gives the editor the StyleFile/StyleId/StyleClass
// from the Page, if empty,
// than from the Category if empty,
// than from the HTMl-Editor Settings
if(empty($pageContent['styleFile'])) { if(!empty($categories['id_'.$_GET['category']]['styleFile'])) $editorStyleFile = $categories['id_'.$_GET['category']]['styleFile']; else $editorStyleFile = $adminConfig['editor']['styleFile']; } else $editorStyleFile = $pageContent['styleFile'];  
if(empty($pageContent['styleId'])) { if(!empty($categories['id_'.$_GET['category']]['styleId'])) $editorStyleId = $categories['id_'.$_GET['category']]['styleId']; else $editorStyleId = $adminConfig['editor']['styleId']; } else $editorStyleId = $pageContent['styleId'];  
if(empty($pageContent['styleClass'])) { if(!empty($categories['id_'.$_GET['category']]['styleClass'])) $editorStyleClass = $categories['id_'.$_GET['category']]['styleClass']; else $editorStyleClass = $adminConfig['editor']['styleClass']; } else $editorStyleClass = $pageContent['styleClass'];  


?>
<textarea name="HTMLEditor" id="HTMLEditor" cols="90" rows="30">
<?php echo $pageContent['content']; ?>
</textarea>

<script type="text/javascript">
/* <![CDATA[ */
  
  var HTMLEditor = CKEDITOR;
  
  // set the CONFIGs of the editor
  HTMLEditor.config.baseHref                  = '<?php echo $adminConfig['basePath']."library/thirdparty/ckeditor/"; ?>';
  HTMLEditor.config.language                  = '<?php echo $_SESSION["language"]; ?>';
  HTMLEditor.config.contentsCss               = '<?php echo $editorStyleFile; ?>';
  HTMLEditor.config.enterMode                 = '<?php if($adminConfig['editor']['enterMode'] == "p") echo "CKEDITOR.ENTER_P"; else echo "CKEDITOR.ENTER_BR"; ?>';
  HTMLEditor.config.stylesCombo_stylesSet     = 'htmlEditorStyles:config/htmlEditorStyles.js';

  
  
  // adds the ID and a CLASS to the body element of the editor instance
  var setIdClass = HTMLEditor.on( 'instanceReady', function(e)
  {     
      // adds ID and a CLASS to the editors body tag
      <?php if(!empty($editorStyleId)) echo "e.editor.document.getBody().setAttribute('id', '".$editorStyleId."');"; ?>
      <?php if(!empty($editorStyleClass)) echo "e.editor.document.getBody().setAttribute('class', '".$editorStyleClass."');"; ?>      
      
      //alert( HTMLEditor.instances.HTMLEditor.document.getBody().getAttribute('id') );
      //alert( HTMLEditor.instances.HTMLEditor.document.getBody().getAttribute('class') );
      
      // removes the eventlistener
      HTMLEditor.removeListener( setIdClass );
      
      
      // HACK1: onSelectionChange; because looses the body id and class on edit mode switching
      e.editor.on( 'selectionChange', function(e) //selectionChange
      {      
          if(HTMLEditor.instances.HTMLEditor.document !== null) {
          <?php if(!empty($editorStyleId)) echo "HTMLEditor.instances.HTMLEditor.document.getBody().setAttribute('id', '".$editorStyleId."');"; ?>
          <?php if(!empty($editorStyleClass)) echo "HTMLEditor.instances.HTMLEditor.document.getBody().setAttribute('class', '".$editorStyleClass."');"; ?>
          }
      });
      
      // HACK2: onmouseout; because looses the body id and class on edit mode switching
      $$('.cke_button_source')[0].addEvent( 'mouseout', function(e) {
          if(HTMLEditor.instances.HTMLEditor.document !== null) {
          <?php if(!empty($editorStyleId)) echo "HTMLEditor.instances.HTMLEditor.document.getBody().setAttribute('id', '".$editorStyleId."');"; ?>
          <?php if(!empty($editorStyleClass)) echo "HTMLEditor.instances.HTMLEditor.document.getBody().setAttribute('class', '".$editorStyleClass."');"; ?>
          }
      });

  });

/* ]]> */
</script>
<?php

/* toolbar auswahl des fckeditor 2.6
echo '<div style="float:right">
      <sup>Men&uuml; Elemente:</sup>
      <select id="cmbToolbars" onchange="ChangeToolbar(this.value);">
        <option value="FMSbasic" selected>Basic</option>
        <option value="FMSadvanced">Erweitert</option>
      </select>
    </div>';


// Automatically calculates the editor base path based on the _samples directory.
// This is usefull only for these samples. A real application should use something like this:
// $oFCKeditor->BasePath = '/cms/htmleditor/' ; // '/fckeditor/' is the default value.
//$adminConfig['basePath'] = $_SERVER['PHP_SELF'] ;
//$adminConfig['basePath'] = substr( $adminConfig['basePath'], 0, strpos( $adminConfig['basePath'], "_samples" ) ) ;
$oFCKeditor = new FCKeditor('FCKeditor') ;
$oFCKeditor->BasePath	= $adminConfig['basePath'].'library/thirdparty/fckeditor/' ;

if ( isset($_GET['Toolbar']) )
	$oFCKeditor->ToolbarSet = htmlspecialchars($_GET['Toolbar']);
else
  $oFCKeditor->ToolbarSet = 'FMSbasic';
 
// gives the editor the StyleFile/StyleId/StyleClass
// from the Page, if empty,
// than from the Category if empty,
// than from the HTMl-Editor Settings
if(empty($pageContent['styleFile'])) { if(!empty($categories['id_'.$_GET['category']]['styleFile'])) $editorStyleFile = $categories['id_'.$_GET['category']]['styleFile']; else $editorStyleFile = $adminConfig['editor']['styleFile']; } else $editorStyleFile = $pageContent['styleFile'];  
if(empty($pageContent['styleId'])) { if(!empty($categories['id_'.$_GET['category']]['styleId'])) $editorStyleId = $categories['id_'.$_GET['category']]['styleId']; else $editorStyleId = $adminConfig['editor']['styleId']; } else $editorStyleId = $pageContent['styleId'];  
if(empty($pageContent['styleClass'])) { if(!empty($categories['id_'.$_GET['category']]['styleClass'])) $editorStyleClass = $categories['id_'.$_GET['category']]['styleClass']; else $editorStyleClass = $adminConfig['editor']['styleClass']; } else $editorStyleClass = $pageContent['styleClass'];  

$oFCKeditor->Config['EditorAreaCSS'] = $editorStyleFile;
$oFCKeditor->Config['BodyId'] = $editorStyleId;
$oFCKeditor->Config['BodyClass'] = $editorStyleClass;

$oFCKeditor->Config['EnterMode'] = $adminConfig['editor']['enterMode'];
$oFCKeditor->Config['StylesXmlPath'] = $adminConfig['basePath'].'config/htmlEditorStyles.xml';
$oFCKeditor->Config['SkinPath'] = $adminConfig['basePath'].'library/thirdparty/fckeditor/editor/skins/SilverNarrow/';

$oFCKeditor->Height = '540';

$oFCKeditor->Value = $pageContent['content'];
//$oFCKeditor->Create() ;
*/
?>

    <div class="content">    
    
    <a href="#" id="hotKeysToogle" class="down"><?php echo $langFile['editor_htmleditor_hotkeys_h1']; ?></a><br />
    <br />
    <div id="hotKeys" style="border:1px solid #B3B3B4; width: 450px; background-color:#B3B3B4;">    
    <table width="450" cellspacing="0" cellpadding="8" border="0">
      <tr>
        <td style="background-color:#EDECEC;">
          <b><?php echo $langFile['editor_htmleditor_hotkeys_feld1']; ?></b></td>
        <td align="left" style="background-color:#EDECEC;"> STRG + A</td>
      </tr><tr>
        <td style="background-color:#E3E3E3;">
          <b><?php echo $langFile['editor_htmleditor_hotkeys_feld2']; ?></b></td>
        <td align="left" style="background-color:#E3E3E3;"> STRG + C</td>
      </tr><tr>
        <td style="background-color:#EDECEC;">
          <b><?php echo $langFile['editor_htmleditor_hotkeys_feld3']; ?></b></td>
        <td align="left" style="background-color:#EDECEC;">
          STRG + V</td>
      </tr><tr>
        <td style="background-color:#E3E3E3;">
          <b><?php echo $langFile['editor_htmleditor_hotkeys_feld4']; ?></b></td>
        <td align="left" style="background-color:#E3E3E3;">
          STRG + X 
          <b><?php echo $langFile['editor_htmleditor_hotkeys_or']; ?></b> SHIFT + Del</td>
      </tr><tr>
        <td colspan="2" height="5" style="background-color:#B3B3B4;"> </td>
      </tr><tr>
        <td style="background-color:#EDECEC;">
          <b><?php echo $langFile['editor_htmleditor_hotkeys_feld5']; ?></b></td>
        <td align="left" style="background-color:#EDECEC;"> STRG + Z</td>
      </tr><tr>
        <td style="background-color:#E3E3E3;">
          <b><?php echo $langFile['editor_htmleditor_hotkeys_feld6']; ?></b></td>
        <td align="left" style="background-color:#E3E3E3;">
          STRG + Y 
          <b><?php echo $langFile['editor_htmleditor_hotkeys_or']; ?></b> STRG + SHIFT + Z</td>
      </tr><tr>
        <td colspan="2" height="5" style="background-color:#B3B3B4;"> </td>
      </tr><tr>
        <td style="background-color:#EDECEC;">
          <b><?php echo $langFile['editor_htmleditor_hotkeys_feld7']; ?></b></td>
        <td align="left" style="background-color:#EDECEC;"> STRG + L</td>
      </tr><tr>
        <td style="background-color:#E3E3E3;">
          <b><?php echo $langFile['editor_htmleditor_hotkeys_feld8']; ?></b></td>
        <td align="left" style="background-color:#E3E3E3;"> STRG + B</td>
      </tr><tr>
        <td style="background-color:#EDECEC;">
          <b><?php echo $langFile['editor_htmleditor_hotkeys_feld9']; ?></b></td>
        <td align="left" style="background-color:#EDECEC;"> STRG + I</td>
      </tr><tr>
        <td style="background-color:#E3E3E3;">
          <b><?php echo $langFile['editor_htmleditor_hotkeys_feld10']; ?></b></td>
        <td align="left" style="background-color:#E3E3E3;"> STRG + U</td>
      </tr>
    </table>
    </div>
    
    <!--<input type="reset" value="" class="toolTip button cancel" title="<?php echo $langFile['form_cancel']; ?>" />-->
    <input type="submit" value="" class="toolTip button submit center" title="<?php echo $langFile['form_submit']; ?>" />
  </div>
</div>

<!-- ***** ADVANCED PAGE SETTINGS -->
<?php
// shows the block below if it is the ones which is saved before
if($savedForm == 'advancedPageSettings')  $hidden = '';
else $hidden = ' hidden';
?>
<div class="block<?php echo $hidden; ?>">
  <h1><a href="#"><?php echo $langFile['editor_advancedpageSettings_h1']; ?></a></h1>
  <div class="content">
    <table>
     
      <colgroup>
      <col class="left" />
      </colgroup>
  
      <tr><td class="leftTop"></td><td></td></tr>
      
      <tr><td class="left">
      <span class="toolTip" title="<?php echo $langFile['editor_advancedpageSettings_feld1'].'::'.$langFile['editor_advancedpageSettings_feld1_tip']; ?>"><?php echo $langFile['editor_advancedpageSettings_feld1']; ?></span>
      </td><td class="right">
      <input name="styleFile" value="<?php if(empty($pageContent['styleFile'])) { if(!empty($categories['id_'.$_GET['category']]['styleFile'])) echo $categories['id_'.$_GET['category']]['styleFile']; else echo $adminConfig['editor']['styleFile']; } else echo $pageContent['styleFile']; ?>" class="toolTip" title="<?php echo $langFile['path_absolutepath_tip']; ?>" />
      <span class="hint"><?php echo $langFile['editor_advancedpageSettings_feld1_inputTip2']; ?></span>                
      </td></tr>
                  
      <tr><td class="left">
      <span class="toolTip" title="<?php echo $langFile['editor_advancedpageSettings_feld3'].'::'.$langFile['editor_advancedpageSettings_feld3_tip']; ?>"><?php echo $langFile['editor_advancedpageSettings_feld3']; ?></span>
      </td><td class="right">
      <input name="styleId" value="<?php if(empty($pageContent['styleId'])) { if(!empty($categories['id_'.$_GET['category']]['styleId'])) echo $categories['id_'.$_GET['category']]['styleId']; else echo $adminConfig['editor']['styleId']; } else echo $pageContent['styleId']; ?>" class="toolTip" title="<?php echo $langFile['editor_advancedpageSettings_feld3_inputTip']; ?>" />
      </td></tr>
                  
      <tr><td class="left">
      <span class="toolTip" title="<?php echo $langFile['editor_advancedpageSettings_feld4'].'::'.$langFile['editor_advancedpageSettings_feld4_tip']; ?>"><?php echo $langFile['editor_advancedpageSettings_feld4']; ?></span>
      </td><td class="right">
      <input name="styleClass" value="<?php if(empty($pageContent['styleClass'])) { if(!empty($categories['id_'.$_GET['category']]['styleClass'])) echo $categories['id_'.$_GET['category']]['styleClass']; else echo $adminConfig['editor']['styleClass']; } else echo $pageContent['styleClass']; ?>" class="toolTip" title="<?php echo $langFile['editor_advancedpageSettings_feld4_inputTip']; ?>" />
      </td></tr>

      <tr><td class="leftBottom"></td><td></td></tr>
      
    </table>
    
    <!--<input type="reset" value="" class="toolTip button cancel" title="<?php echo $langFile['form_cancel']; ?>" />-->
    <input type="submit" value="" class="toolTip button submit center" title="<?php echo $langFile['form_submit']; ?>" onclick="$('savedBlock').value = 'advancedPageSettings';" />
  </div>
  <div class="bottom"></div>
</div>
</form>
