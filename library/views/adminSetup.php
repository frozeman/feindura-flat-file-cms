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
 * sites/adminSetup.php
 *
 * @version 2.36
 */

/**
 * Includes the login.include.php and backend.include.php and filter the basic data
 */
require_once(dirname(__FILE__)."/../includes/secure.include.php");

// GET timezones
$timezones = array();
$tab = file(dirname(__FILE__).'/../thirdparty/timezones.tab');
foreach ($tab as $buf) {
    if (substr($buf,0,1)=='#') continue;
    $rec = preg_split('/\s+/',$buf);
    $key = $rec[2];
    $val = $rec[2];
    $c = count($rec);
    for ($i=3;$i<$c;$i++) $val .= ' '.$rec[$i];
    $timezones[$key] = $val;
    ksort($timezones);
}

?>

<form action="index.php?site=adminSetup" method="post" enctype="multipart/form-data" accept-charset="UTF-8" id="adminSettingsForm">
<div>
  <input type="hidden" name="send" value="adminSetup">
  <input type="hidden" name="savedBlock" id="savedBlock" value="">
</div>

<!-- BASIC SETTINGS -->
<a id="adminSettings" class="anchorTarget"></a>
<?php
// shows the block below if it is the ones which is saved before
$hidden = ($SAVEDFORM !== false && $SAVEDFORM != 'adminSettings' && checkBasePathAndURL() && !documentrootWarning()) ? ' hidden' : '';
?>
<div class="block<?php echo $hidden; ?>">
  <h1><a href="#"><img src="library/images/icons/setupIcon_middle.png" class="blockH1Icon" alt="icon"><?php echo $langFile['ADMINSETUP_GENERAL_h1']; ?></a></h1>
  <div class="content form">

    <?php if(documentrootWarning() || !empty($adminConfig['documentroot'])) { ?>
    <div class="row">
      <div class="span3 formLeft">
        <label for="cfg_documentroot"><span class="toolTipLeft<?php if(empty($adminConfig['documentroot'])) echo ' red';  ?>" title="::<?php echo $langFile['ADMINSETUP_GENERAL_TOOLTIP_DOCUMENTROOT'] ?>">
        <?php echo $langFile['ADMINSETUP_GENERAL_TEXT_DOCUMENTROOT'] ?></span></label>
      </div>
      <div class="span5">
        <input type="text" id="cfg_documentroot" name="cfg_documentroot"<?php if(empty($adminConfig['documentroot'])) echo ' value="'.str_replace($adminConfig['basePath'],'',str_replace('library/views','',dirname(__FILE__))).'"'; else echo ' value="'.$adminConfig['documentroot'].'"'; ?> class="toolTipRight" style="width: 400px;" title="::<?php echo $langFile['ADMINSETUP_GENERAL_TOOLTIP_DOCUMENTROOT']; ?>">
      </div>
    </div>
    <?php } ?>

    <div class="row">
      <div class="span3 formLeft">
        <label for="cfg_url"><span class="toolTipLeft" title="::<?php echo $langFile['ADMINSETUP_GENERAL_field1_tip'] ?>">
        <?php echo $langFile['ADMINSETUP_GENERAL_field1'] ?></span></label>
      </div>
      <div class="span5">
        <input type="text" id="cfg_url" name="cfg_url"<?php if($adminConfig['url'] != generateCurrentUrl()) echo ' style="color:#C5451F !important;" value="'.$langFile['ADMINSETUP_GENERAL_field1_inputWarningText'].'"'; else echo ' value="'.$adminConfig['url'].'"'; ?> readonly="readonly" class="toolTipRight" title="<?php echo $langFile['ADMINSETUP_GENERAL_field1_inputTip']; ?>">
      </div>
    </div>

    <div class="row">
      <div class="span3 formLeft">
        <label for="cfg_basePath"><span class="toolTipLeft" title="::<?php echo $langFile['ADMINSETUP_GENERAL_field2_tip'] ?>">
        <?php echo $langFile['ADMINSETUP_GENERAL_field2'] ?></span></label>
      </div>
      <div class="span5">
        <?php
        $checkPath = GeneralFunctions::URI2Path(dirname($_SERVER['PHP_SELF'])).'/';
        ?>
        <input type="text" id="cfg_basePath" name="cfg_basePath"<?php if($adminConfig['basePath'] != $checkPath) echo ' style="color:#C5451F !important;" value="'.$langFile['ADMINSETUP_GENERAL_field2_inputWarningText'].'"'; else echo ' value="'.$adminConfig['basePath'].'"'; ?> readonly="readonly" class="toolTipRight" title="<?php echo $langFile['ADMINSETUP_GENERAL_field2_inputTip']; ?>">
      </div>
    </div>

    <div class="row">
      <div class="span3 formLeft">
        <label for="cfg_websitePath"><span class="toolTipLeft" title="::<?php echo $langFile['ADMINSETUP_GENERAL_field8_tip'] ?>">
        <?php echo $langFile['ADMINSETUP_GENERAL_field8'] ?></span></label>
      </div>
      <div class="span5">
        <input type="text" id="cfg_websitePath" name="cfg_websitePath" value="<?php echo $adminConfig['websitePath']; ?>" class="toolTipRight" title="<?php echo $langFile['PATHS_TOOLTIP_ABSOLUTE']; ?>">
        <span class="badge badge-warning toolTipTop" title="<?php echo $langFile['PATHS_TOOLTIP_ABSOLUTE']; ?>"><?php echo $langFile['PATHS_TEXT_ABSOLUTE']; ?></span>
      </div>
    </div>

    <div class="row">
      <div class="span3 formLeft">
        <label for="cfg_stylesheetPath"><span class="toolTipLeft" title="::<?php echo $langFile['ADMINSETUP_GENERAL_field6_tip'] ?>">
        <?php echo $langFile['ADMINSETUP_GENERAL_field6'] ?></span></label>
      </div>
      <div class="span5">
        <input type="text" id="cfg_stylesheetPath" name="cfg_stylesheetPath" value="<?php echo $adminConfig['stylesheetPath']; ?>" class="toolTipRight" title="<?php echo $langFile['PATHS_TOOLTIP_ABSOLUTE']; ?>">
        <span class="badge badge-warning toolTipTop" title="<?php echo $langFile['PATHS_TOOLTIP_ABSOLUTE']; ?>"><?php echo $langFile['PATHS_TEXT_ABSOLUTE']; ?></span>
      </div>
    </div>

    <div class="row">
      <div class="span3 formLeft">
        <label for="cfg_websiteFilesPath"><span class="toolTipLeft" title="::<?php echo $langFile['ADMINSETUP_GENERAL_field5_tip'] ?>">
        <?php echo $langFile['ADMINSETUP_GENERAL_field5'] ?></span></label>
      </div>
      <div class="span5">
        <input type="text" id="cfg_websiteFilesPath" name="cfg_websiteFilesPath" value="<?php echo $adminConfig['websiteFilesPath']; ?>" class="toolTipRight" title="<?php echo $langFile['PATHS_TOOLTIP_ABSOLUTE']; ?>">
        <span class="badge badge-warning toolTipTop" title="<?php echo $langFile['PATHS_TOOLTIP_ABSOLUTE']; ?>"><?php echo $langFile['PATHS_TEXT_ABSOLUTE']; ?></span>
      </div>
    </div>

    <div class="row">
      <div class="span3 formLeft">
        <label for="cfg_permissions"><span class="toolTipLeft" title="::<?php echo $langFile['ADMINSETUP_GENERAL_TIP_PERMISSIONS'] ?>">
        <?php echo $langFile['ADMINSETUP_GENERAL_TEXT_PERMISSIONS'] ?></span></label>
      </div>
      <div class="span5">
        <select id="cfg_permissions" name="cfg_permissions">

          <option value="0744"<?php if($adminConfig['permissions'] == 0744) echo ' selected="selected"'; ?>>744</option>
          <!--<option value="0754"<?php if($adminConfig['permissions'] == 0754) echo ' selected="selected"'; ?>>754</option>-->
          <option value="0755"<?php if($adminConfig['permissions'] == 0755) echo ' selected="selected"'; ?>>755</option>
          <option value="0775"<?php if($adminConfig['permissions'] == 0775) echo ' selected="selected"'; ?>>775</option>
          <option value="0777"<?php if($adminConfig['permissions'] == 0777) echo ' selected="selected"'; ?>>777</option>
        </select>
      </div>
    </div>

    <div class="row">
      <div class="span3 formLeft">
        <label for="cfg_timeZone"><span class="toolTipLeft" title="::<?php echo $langFile['ADMINSETUP_TIP_TIMEZONE'] ?>">
        <?php echo $langFile['ADMINSETUP_TEXT_TIMEZONE'] ?></span></label>
      </div>
      <div class="span5">
        <select id="cfg_timeZone" name="cfg_timeZone">
          <?php
            if(empty($adminConfig['timezone']))
              $adminConfig['timezone'] = date_default_timezone_get();

            $storedContinent = '';
            foreach($timezones as $zone => $zoneName) {
              $continentCity = explode('/',$zoneName);
              $continent = $continentCity[0];
              array_shift($continentCity);
              $fullCityName = implode('/',$continentCity);

              if($storedContinent != $continent) {
                if($storedContinent != '')
                  echo '</optgroup>'."\n";
                echo '<optgroup label="'.$continent.'">'."\n";
              }

              $selected = ($adminConfig['timezone'] == $zone) ? ' selected="selected"': '';
              echo '<option value="'.$zone.'"'.$selected.'>'.$fullCityName.'</option>'."\n";

              $storedContinent = $continent;
            }
          ?>
          </optgroup>
        </select>
      </div>
    </div>

    <div class="spacer"></div>

    <!-- URL FORMAT -> PRETTY URLS -->
    <div class="row">
      <div class="span3 formLeft">
        <label for="cfg_prettyURL"><span class="toolTipLeft" title="::<?php echo $langFile['ADMINSETUP_GENERAL_PRETTYURL_tip'] ?>">
        <?php echo $langFile['ADMINSETUP_GENERAL_PRETTYURL'] ?></span></label>
      </div>
      <div class="span5">
        <?php
          $apacheModules = (function_exists('apache_get_modules'))
          ? apache_get_modules()
          : array('mod_rewrite');
        ?>
        <select id="cfg_prettyURL" name="cfg_prettyURL" class="toolTipRight" title="<?php echo $langFile['ADMINSETUP_GENERAL_PRETTYURL_warning'] ?>"<?php if(!in_array('mod_rewrite',$apacheModules)) echo ' disabled="disabled"'; ?>>
          <option value="true"<?php if($adminConfig['prettyURL'] == 'true') echo ' selected="selected"'; ?>><?php echo $langFile['ADMINSETUP_GENERAL_PRETTYURL_true'].' -> &quot;'.sprintf($langFile['ADMINSETUP_GENERAL_PRETTYURL_true_example'],$adminConfig['varName']['category']).'&quot;';?></option>
          <option value=""<?php if($adminConfig['prettyURL'] == '') echo ' selected="selected"'; ?>><?php echo $langFile['ADMINSETUP_GENERAL_PRETTYURL_false'].' -> &quot;'.sprintf($langFile['ADMINSETUP_GENERAL_PRETTYURL_false_example'],$adminConfig['varName']['category'],$adminConfig['varName']['page']).'&quot;';?></option>
        </select>
      </div>
    </div>

    <?php

      // add varnames prefixes
      if($adminConfig['prettyURL'] == 'true') {
        $varNamesStyle[0] = '/';
        $varNamesStyle[1] = '/..';
      } else {
        $varNamesStyle[0] = '?';
        $varNamesStyle[1] = '=someID';
      }
    ?>
    <div class="row">
      <div class="span3 formLeft">
        <label for="cfg_varNamePage"><span class="toolTipLeft" title="::<?php echo $langFile['ADMINSETUP_TIP_VARNAME'] ?>">
        <?php echo $langFile['ADMINSETUP_TEXT_VARNAMEPAGE'] ?></span></label>
      </div>
      <div class="span5 input-prepend input-append">
        <span class="add-on"><?php echo $varNamesStyle[0]; ?></span><input type="text" id="cfg_varNamePage" name="cfg_varNamePage" value="<?php echo $adminConfig['varName']['page']; ?>" class="input-small toolTipRight" title="<?php echo $langFile['ADMINSETUP_TEXT_VARNAMEPAGE'].'::'.$langFile['ADMINSETUP_TIP_EMPTYVARNAME'].'&quot;[strong]page[/strong]&quot;'; ?>"><span class="add-on"><?php echo $varNamesStyle[1]; ?></span>
      </div>
    </div>

    <div class="row">
      <div class="span3 formLeft">
        <label for="cfg_varNameCategory"><span class="toolTipLeft" title="::<?php echo $langFile['ADMINSETUP_TIP_VARNAME'] ?>">
        <?php echo $langFile['ADMINSETUP_TEXT_VARNAMECATEGORY'] ?></span></label>
      </div>
      <div class="span5 input-prepend input-append">
        <span class="add-on"><?php echo $varNamesStyle[0]; ?></span><input type="text" id="cfg_varNameCategory" name="cfg_varNameCategory" value="<?php echo $adminConfig['varName']['category']; ?>" class="input-small toolTipRight" title="<?php echo $langFile['ADMINSETUP_TEXT_VARNAMECATEGORY'].'::'.$langFile['ADMINSETUP_TIP_EMPTYVARNAME'].'&quot;[strong]category[/strong]&quot;'; ?>"><span class="add-on"><?php echo $varNamesStyle[1]; ?></span>
      </div>
    </div>

        <!--
    <div class="row">
      <div class="span3 formLeft">
        <label for="cfg_varNameModul"><span class="toolTipLeft" title="::<?php echo $langFile['ADMINSETUP_TIP_VARNAME'] ?>">
        <?php echo $langFile['ADMINSETUP_TEXT_VARNAMEMODUL'] ?></span></label>
      </div>
      <div class="span5">
        <input type="text" id="cfg_varNameModul" name="cfg_varNameModul" value=<?php echo '"'.$adminConfig['varName']['modul'].'"'; ?> class="toolTipRight" title="<?php echo $langFile['ADMINSETUP_TEXT_VARNAMEMODUL'].'::'.$langFile['ADMINSETUP_TIP_EMPTYVARNAME'].'&quot;[strong]modul[/strong]&quot;'; ?>">
      </div>
    </div>
        -->

    <div class="spacer"></div>

    <div class="row">
      <div class="span3 formLeft">
        <input type="checkbox" id="cfg_cache" name="cfg_cache" value="true"<?php if($adminConfig['cache']['active']) echo ' checked="checked"'; ?> class="toolTipLeft" title="<?php echo $langFile['ADMINSETUP_TEXT_CACHE'].'::'.$langFile['ADMINSETUP_TIP_CACHE']; ?>"><br>
      </div>
      <div class="span5">
        <label for="cfg_cache"><span class="toolTipRight" title="::<?php echo $langFile['ADMINSETUP_TIP_CACHE']; ?>"><?php echo $langFile['ADMINSETUP_TEXT_CACHE']; ?></span></label>
      </div>
    </div>

    <div class="row" id="cacheTimeoutRow"<?php if(!$adminConfig['cache']['active']) echo ' style="display:none"'; ?>>
      <div class="span3 formLeft">
        <label for="cfg_cacheTimeout"><span class="toolTipLeft" title="::<?php echo $langFile['ADMINSETUP_TIP_CACHETIMEOUT'] ?>">
        <?php echo $langFile['ADMINSETUP_TEXT_CACHETIMEOUT'] ?></span></label>
      </div>
      <div class="span5">
        <input type="number" step="0.5" id="cfg_cacheTimeout" name="cfg_cacheTimeout" value=<?php echo '"'.$adminConfig['cache']['timeout'].'"'; ?> class="toolTipRight" title="<?php echo $langFile['ADMINSETUP_TEXT_CACHETIMEOUT'].'::'.$langFile['ADMINSETUP_TIP_CACHETIMEOUT']; ?>">
        <?php echo $langFile['ADMINSETUP_HINT_CACHETIMEOUT']; ?>
      </div>
    </div>

    <input type="submit" value="" name="adminConfig" class="button submit center" title="<?php echo $langFile['FORM_BUTTON_SUBMIT']; ?>">
  </div>
</div>

<!-- EDITOR SETTINGS -->
<a id="editorSettings" class="anchorTarget"></a>
<?php
// shows the block below if it is the ones which is saved before
$hidden = ($SAVEDFORM != 'editorSettings') ? ' hidden' : '';
?>
<div class="block<?php echo $hidden; ?>">
  <h1><a href="#"><img src="library/images/icons/editorIcon_middle.png" class="blockH1Icon" alt="icon" style="margin-right: 5px;"><?php echo $langFile['adminSetup_editorSettings_h1']; ?></a></h1>
  <div class="content form">

    <div class="row">
      <div class="span3 formLeft">
        <input type="checkbox" id="cfg_editorHtmlLawed" name="cfg_editorHtmlLawed" onclick="disableSafeHtml(this);" value="true"<?php if($adminConfig['editor']['htmlLawed']) echo ' checked="checked"'; ?>>
      </div>
      <div class="span5">
        <label for="cfg_editorHtmlLawed"><span class="toolTipRight" title="::<?php echo $langFile['ADMINSETUP_TIP_EDITOR_HTMLLAWED']; ?>"><?php echo $langFile['ADMINSETUP_TEXT_EDITOR_HTMLLAWED']; ?></span></label>
      </div>
    </div>

    <div class="row">
      <div class="span3 formLeft">
        <input type="checkbox" id="cfg_editorSafeHtml" name="cfg_editorSafeHtml" value="true"<?php if(!$adminConfig['editor']['htmlLawed']) echo ' disabled="disabled"';if($adminConfig['editor']['safeHtml']) echo ' checked="checked"'; ?>>
      </div>
      <div class="span5">
        <label for="cfg_editorSafeHtml"><span class="toolTipRight" title="::<?php echo $langFile['ADMINSETUP_TIP_EDITOR_SAFEHTML']; ?>"><?php echo $langFile['ADMINSETUP_TEXT_EDITOR_SAFEHTML']; ?></span></label>
      </div>
    </div>

    <div class="row">
      <div class="span3 formLeft">
        <input type="checkbox" id="cfg_editorStyles" name="cfg_editorStyles" value="true"<?php if($adminConfig['editor']['editorStyles']) echo ' checked="checked"'; ?>>
      </div>
      <div class="span5">
        <label for="cfg_editorStyles"><span class="toolTipRight" title="::<?php echo $langFile['ADMINSETUP_TIP_EDITOR_EDITORSTYLES']; ?>"><?php echo $langFile['ADMINSETUP_TEXT_EDITOR_EDITORSTYLES']; ?></span></label>
      </div>
    </div>

    <div class="row">
      <div class="span3 formLeft">
        <input type="checkbox" id="cfg_snippets" name="cfg_snippets" value="true"<?php if($adminConfig['editor']['snippets']) echo ' checked="checked"'; ?>>
      </div>
      <div class="span5">
        <label for="cfg_snippets"><span class="toolTipRight" title="::<?php echo $langFile['ADMINSETUP_TIP_EDITOR_SNIPPETS']; ?>"><?php echo $langFile['ADMINSETUP_TEXT_EDITOR_SNIPPETS']; ?></span></label>
      </div>
    </div>

    <div class="spacer"></div>

    <div class="row">
      <div class="span3 formLeft">
        <label for="cfg_editorEnterMode"><span class="toolTipLeft" title="::<?php echo $langFile['adminSetup_editorSettings_field1_tip'] ?>">
        <?php echo $langFile['adminSetup_editorSettings_field1'] ?></span></label>
      </div>
      <div class="span5">
        <select id="cfg_editorEnterMode" name="cfg_editorEnterMode">
          <option value="p" <?php if($adminConfig['editor']['enterMode'] == 'p') echo 'selected="selected"'; ?>>&lt;p&gt;</option>
          <option value="br" <?php if($adminConfig['editor']['enterMode'] == 'br') echo 'selected="selected"'; ?>>&lt;br&gt;</option>
        </select>
        <?php
        $enterMode = ($adminConfig['editor']['enterMode'] == 'p') ? '&lt;br&gt;': '&lt;p&gt;';
        ?>
        <div class="alert center"><?php echo sprintf($langFile['adminSetup_editorSettings_field1_hint'],'<span id="enterModeOpposite" style="font-weight:bold;">'.$enterMode.'</span>'); ?></div>
      </div>
    </div>

    <div class="spacer"></div>

    <div class="row">
      <div class="span3 formLeft">
        <span class="toolTipLeft" title="::<?php echo $langFile['STYLESHEETS_TOOLTIP_STYLEFILE'] ?>">
        <?php echo $langFile['STYLESHEETS_TEXT_STYLEFILE'] ?></span>
      </div>
      <div class="span5">
        <div id="adminStyleFilesInputs">
        <?php

          echo showStyleFileInputs($categoryConfig[0]['styleFile'],'cfg_editorStyleFile');

        ?>
        </div>
        <a href="#" class="addStyleFilePath addButton toolTipLeft" style="margin-right: 10px;float:left;" title="<?php echo $langFile['STYLESHEETS_TOOLTIP_ADDSTYLEFILE']; ?>::"></a>
        <span class="badge" style="position:relative; top: 3px;"><?php echo $langFile['STYLESHEETS_EXAMPLE_STYLEFILE']; ?></span>
      </div>
    </div>

    <div class="row">
      <div class="span3 formLeft">
        <label for="cfg_editorStyleId"><span class="toolTipLeft" title="::<?php echo $langFile['STYLESHEETS_TOOLTIP_ID'] ?>">
        <?php echo $langFile['STYLESHEETS_TEXT_ID'] ?></span></label>
      </div>
      <div class="span5">
        <input type="text" id="cfg_editorStyleId" name="cfg_editorStyleId" class="toolTipRight" value="<?php echo $categoryConfig[0]['styleId']; ?>" title="<?php echo $langFile['adminSetup_editorSettings_field3_inputTip']; ?>">
      </div>
    </div>

    <div class="row">
      <div class="span3 formLeft">
        <label for="cfg_editorStyleClass"><span class="toolTipLeft" title="::<?php echo $langFile['STYLESHEETS_TOOLTIP_CLASS'] ?>">
        <?php echo $langFile['STYLESHEETS_TEXT_CLASS'] ?></span></label>
      </div>
      <div class="span5">
        <input type="text" id="cfg_editorStyleClass" name="cfg_editorStyleClass" class="toolTipRight" value="<?php echo $categoryConfig[0]['styleClass']; ?>" title="<?php echo $langFile['adminSetup_editorSettings_field4_inputTip']; ?>">
      </div>
    </div>

    <input type="submit" value="" name="adminConfig" class="button submit center" title="<?php echo $langFile['FORM_BUTTON_SUBMIT']; ?>">
  </div>
</div>

</form>

<?php if(!empty($adminConfig['websiteFilesPath']) || !empty($adminConfig['stylesheetPath']) || $adminConfig['editor']['editorStyles']) { ?>
<div class="blockSpacer"></div>
<?php }


// EDIT snippets
if($adminConfig['editor']['snippets']) {
  if(!is_dir(dirname(__FILE__).'/../../snippets/')) mkdir(dirname(__FILE__).'/../../snippets/');
  editFiles(dirname(__FILE__).'/../../snippets/', 'snippetFiles', '<img src="library/images/icons/snippetsIcon_middle.png" class="blockH1Icon" alt="icon">'.$langFile['EDITFILESSETTINGS_TITLE_SNIPPETS'], 'snippetsFilesAnchor', 'php');
}

// EDIT stylesheets
editFiles($adminConfig['stylesheetPath'], 'cssFiles', '<img src="library/images/icons/stylesheetsIcon_middle.png" class="blockH1Icon" alt="icon">'.$langFile['EDITFILESSETTINGS_TITLE_STYLESHEETS'], 'cssFilesAnchor', 'css');

// EDIT websitefiles
editFiles($adminConfig['websiteFilesPath'], 'websiteFiles',  '<img src="library/images/icons/websitefilesIcon_middle.png" class="blockH1Icon" alt="icon">'.$langFile['EDITFILESSETTINGS_TITLE_WEBSITEFILES'], 'websiteFilesAnchor');

?>

<?php if($adminConfig['editor']['editorStyles']) { ?>
<!-- EDIT editor-styles -->
<form action="index.php?site=adminSetup#fckstyleFileAnchor" method="post" enctype="multipart/form-data" accept-charset="UTF-8">
<div>
  <input type="hidden" name="saveFckStyleFile" value="true">
</div>
<?php

$htmlEditorStyleFilePath = "config/EditorStyles.js";
if($htmlEditorStyleFile = @fopen($htmlEditorStyleFilePath,"r")) {
  $htmlEditorStyleContent = fread($htmlEditorStyleFile,filesize($htmlEditorStyleFilePath));
  fclose($htmlEditorStyleFile);
} else
  $htmlEditorStyleContent = '';

// -> fill when with standard styles when its empty
if(strpos($htmlEditorStyleContent,'CKEDITOR.addStylesSet') === false)
  $htmlEditorStyleContent = "CKEDITOR.addStylesSet( 'htmlEditorStyles',
[

{name:'Blue Title',element:'h1',styles:{color:'Blue'}},
{name:'Red Title',element:'h3',styles:{color:'Red'}},
{name:'Marker: Yellow',element:'span',styles:{'background-color':'Yellow'}},
{name:'Marker: Green',element:'span',styles:{'background-color':'Lime'}},
{name:'Big',element:'big'},
{name:'Small',element:'small'},
{name:'Typewriter',element:'tt'},
{name:'Computer Code',element:'code'},
{name:'Keyboard Phrase',element:'kbd'},
{name:'Sample Text',element:'samp'},
{name:'Variable',element:'var'},
{name:'Deleted Text',element:'del'},
{name:'Inserted Text',element:'ins'},
{name:'Cited Work',element:'cite'},
{name:'Inline Quotation',element:'q'},
{name:'Language: RTL',element:'span',attributes:{dir:'rtl'}},
{name:'Language: LTR',element:'span',attributes:{dir:'ltr'}},
{name:'Bild nach links',element:'img',attributes:{align:'left'},styles:{'margin':'4px 6px 4px 0px'}},
{name:'Bild nach Rechts',element:'img',attributes:{align:'right'},styles:{'margin':'4px 0px 4px 6px'}}

]);";

// shows the block below if it is the ones which is saved before
$hidden = ($SAVEDFORM != 'fckStyleFile') ? ' hidden' : '';
?>
<div class="block<?php echo $hidden; ?>">
  <h1><a href="#" id="fckstyleFileAnchor"><img src="library/images/icons/stylesSelectionIcon_middle.png" class="blockH1Icon" alt="icon" style="margin-right: 3px;"><?php echo $langFile['adminSetup_styleFileSettings_h1']; ?></a></h1>
  <div class="content">
    <div class="alert">
      Details: <a href="http://docs.cksource.com/CKEditor_3.x/Developers_Guide/Styles" target="_blank">http://docs.cksource.com/CKEditor_3.x/Developers_Guide/Styles</a>
    </div>
    <textarea name="fckStyleFile" cols="90" rows="30" spellcheck="false" class="editFiles js" id="fckStyleFile"><?php echo $htmlEditorStyleContent; ?></textarea>
    <br><br>
    <input type="submit" value="" name="saveFckStyles" class="button submit center" title="<?php echo $langFile['FORM_BUTTON_SUBMIT']; ?>">
  </div>
</div>
</form>
<?php } ?>


<!-- PAGE SCRIPTS -->
<script type="text/javascript">
/* <![CDATA[ */

  // setup the AUTOMATICALLY ADDING OF the ANCHORS
  setupForm('adminSettingsForm');

/* ]]> */
</script>