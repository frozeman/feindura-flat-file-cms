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
 * includes/metaTags.include.php
 *
 * @version 0.1
 */
?>

  <meta charset="UTF-8">

  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport" content="width=device-width, initial-scale=0.5">

  <meta name="robots" content="noindex,nofollow">
  <meta http-equiv="pragma" content="no-cache"> <!--browser/proxy dont cache-->
  <meta http-equiv="cache-control" content="no-cache"> <!--proxy dont cache-->
  <meta http-equiv="accept-encoding" content="gzip, deflate">

  <meta name="author" content="Fabian Vogelsteller [frozeman.de]">
  <meta name="publisher" content="Fabian Vogelsteller [frozeman.de]">
  <meta name="copyright" content="Fabian Vogelsteller [frozeman.de]">
  <meta name="description" content="A flat file based Content Management System, written in PHP">
  <meta name="keywords" content="cms,flat,file,content,management,system">

  <link rel="icon" href="library/images/icons/favicon.ico" type="image/x-icon">
  <link rel="shortcut icon" href="library/images/icons/favicon.ico" type="image/x-icon">

  <!-- ************************************************************************************************************ -->
  <!-- STYLESHEETS -->

  <!-- feindura styles -->
  <link rel="stylesheet" type="text/css" href="library/styles/css/styles.css<?php echo '?v='.BUILD; ?>">

  <!-- thirdparty/CodeMirror -->
  <link rel="stylesheet" type="text/css" href="library/thirdparty/CodeMirror/codemirror-unified.css">

  <?php
  if($_GET['site'] == 'addons' && !empty($_GET['addon'])) {
    $addonStylesheets = GeneralFunctions::createStyleTags(dirname(__FILE__).'/../../addons/'.$_GET['addon'].'/');
    if(!empty($addonStylesheets)) {
      echo '<!-- Addon stylesheets -->';
      echo $addonStylesheets;
    }
  }
  ?>

  <!-- ************************************************************************************************************ -->
  <!-- JAVASCRIPT -->

  <!-- thirdparty/Html5Shiv -->
  <!--[if lt IE 9]><script type="text/javascript" src="library/thirdparty/javascripts/html5shiv.min.js"></script><![endif]-->

  <!-- thirdparty/MooTools -->
  <script type="text/javascript" src="library/thirdparty/javascripts/mootools-core-1.4.5.js"></script>
  <script type="text/javascript" src="library/thirdparty/javascripts/mootools-more-1.4.0.1.js"></script>

  <!-- thirdparty/PlaceholderSupport -->
  <script type="text/javascript" src="library/thirdparty/javascripts/PlaceholderSupport.js"></script>

  <!-- thirdparty/jsMultipleSelect -->
  <script type="text/javascript" src="library/thirdparty/javascripts/jsMultipleSelect.js"></script>

  <!-- thirdparty/FloatingTips -->
  <script type="text/javascript" src="library/thirdparty/javascripts/FloatingTips.js"></script>

  <!-- thirdparty/DatePicker -->
  <script type="text/javascript" src="library/thirdparty/MooTools-DatePicker/Locale.<?php echo $_SESSION['feinduraSession']['backendLanguageLocale']; ?>.DatePicker.js"></script>
  <script type="text/javascript" src="library/thirdparty/MooTools-DatePicker/Picker.js"></script>
  <script type="text/javascript" src="library/thirdparty/MooTools-DatePicker/Picker.Attach.js"></script>
  <script type="text/javascript" src="library/thirdparty/MooTools-DatePicker/Picker.Date.js"></script>
  <script type="text/javascript" src="library/thirdparty/MooTools-DatePicker/Picker.Date.Range.js"></script>

  <!-- thirdparty/Raphael -->
  <script type="text/javascript" src="library/thirdparty/javascripts/raphael-1.5.2.js"></script>

  <!-- thirdparty/AutoGrow [http://cpojer.net/PowerTools/] (need MooTools) -->
  <script type="text/javascript" src="library/thirdparty/javascripts/powertools-1.0.1.js"></script>

  <!-- thirdparty/StaticScroller (need MooTools) -->
  <script type="text/javascript" src="library/thirdparty/javascripts/StaticScroller.js"></script>

  <!-- thirdparty/FancyForm (need MooTools) -->
  <script type="text/javascript" src="library/thirdparty/javascripts/fancyform.js"></script>

  <?php if(!empty($userConfig)) { ?>
  <!-- thirdparty/CountDown (need MooTools) -->
  <script type="text/javascript" src="library/thirdparty/javascripts/CountDown.js"></script>
  <?php } ?>

  <!-- thirdparty/CodeMirror -->
  <script type="text/javascript" src="library/thirdparty/CodeMirror/codemirror-compressed.js"></script>
  <script type="text/javascript" src="library/thirdparty/CodeMirror/modes-compressed.js"></script>
  <?php
  if(!empty($_GET['page'])) { ?>

  <!-- thirdparty/CKEditor -->
  <script type="text/javascript" src="library/thirdparty/ckeditor/ckeditor.js<?php echo '?v='.BUILD; ?>"></script>

  <!-- thirdparty/MooRTE -->
  <script type="text/javascript" src="library/thirdparty/MooRTE/Source/moorte.min.js<?php echo '?v='.BUILD; ?>"></script>
  <?php
  }
  if(GeneralFunctions::hasPermission('fileManager')) { ?>

  <!-- thirdparty/MooTools-FileManager -->
  <script type="text/javascript" src="library/thirdparty/MooTools-FileManager/Source/FileManager.js<?php echo '?v='.BUILD; ?>"></script>
  <script type="text/javascript" src="library/thirdparty/MooTools-FileManager/Source/Uploader/Fx.ProgressBar.js"></script>
  <script type="text/javascript" src="library/thirdparty/MooTools-FileManager/Source/Uploader/Swiff.Uploader.js"></script>
  <script type="text/javascript">
  /* <![CDATA[ */
    // Uses the non flash uploader when flash is not installed
    if(Browser.Plugins.Flash.version == 0) {
      document.write(unescape('<script src="library/thirdparty/MooTools-FileManager/Source/NoFlash.Uploader.js"><\/script>'));
    } else
      document.write(unescape('<script src="library/thirdparty/MooTools-FileManager/Source/Uploader.js"><\/script>'));
  /* ]]> */
  </script>
  <script type="text/javascript" src="library/thirdparty/MooTools-FileManager/Language/Language.<?php echo $_SESSION['feinduraSession']['backendLanguage']; ?>.js"></script>
  <?php } ?>

  <?php if($_GET['site'] == 'websiteSetup' || (!empty($_GET['page']) && $categoryConfig[$_GET['category']]['showTags'])) { ?>
  <!-- thirdparty/TextboxList -->
  <script type="text/javascript" src="library/thirdparty/TextboxList/TextboxList.js<?php echo '?v='.BUILD; ?>"></script>
  <script type="text/javascript" src="library/thirdparty/TextboxList/TextboxList.Autocomplete.js<?php echo '?v='.BUILD; ?>"></script>

  <?php } ?>
  <!-- feindura javascripts -->
  <script type="text/javascript" src="library/javascripts/shared.js<?php echo '?v='.BUILD; ?>"></script>
  <script type="text/javascript" src="library/javascripts/loading.js<?php echo '?v='.BUILD; ?>"></script>
  <script type="text/javascript" src="library/javascripts/windowBox.js<?php echo '?v='.BUILD; ?>"></script>
  <script type="text/javascript" src="library/javascripts/content.js<?php echo '?v='.BUILD; ?>"></script>