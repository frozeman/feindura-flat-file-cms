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
 * fileManager.php
 *
 * @version 0.2
 */

//echo ' '; // hack for safari, otherwise it throws an error that he could not find htmlentities like &ouml;

/**
 * Includes the login and filters the incoming data by xssFilter
 */
require_once(dirname(__FILE__)."/../../includes/secure.include.php");

?>
<!DOCTYPE html>
<html>
  <head>
  <meta charset="UTF-8" />
  <meta http-equiv="content-language" content="<?php echo $_GET['langCode']; ?>" />
  
  <title>feindura: FileManager</title>
  
  <!-- thirdparty/MooTools -->
  <script type="text/javascript" src="../../thirdparty/javascripts/mootools-core-1.3.js"></script>
  <script type="text/javascript" src="../../thirdparty/javascripts/mootools-more.js"></script>
  
  <!-- thirdparty/MooTools-FileManager -->
  <script type="text/javascript" src="../../thirdparty/MooTools-FileManager/Source/FileManager.js"></script>
  <script type="text/javascript" src="../../thirdparty/MooTools-FileManager/Source/Uploader/Fx.ProgressBar.js"></script>
  <script type="text/javascript" src="../../thirdparty/MooTools-FileManager/Source/Uploader/Swiff.Uploader.js"></script>
  <script type="text/javascript" src="../../thirdparty/MooTools-FileManager/Source/Uploader.js"></script>
  <script type="text/javascript" src="../../thirdparty/MooTools-FileManager/Language/Language.<?= $_GET['langCode']; ?>.js"></script>

  <script type="text/javascript">
  /* <![CDATA[ */
    function openFilemanager(){
        var complete = function(path, file){
          window.opener.CKEDITOR.tools.callFunction('<?= $_GET["CKEditorFuncNum"]; ?>', path);
          window.close();
        };
  
        var fileManager = new FileManager({
            url: '../../processes/filemanager.process.php',
            assetBasePath: '../../thirdparty/MooTools-FileManager/Assets',
            language: '<?= $_GET["langCode"]; ?>',
            destroy: true,
            upload: true,
            rename: true,
            download: true,
            selectable: true,
            hideClose: true,
            onComplete: complete
        });
        fileManager.filemanager.setStyle('width','100%');
        fileManager.filemanager.setStyle('height','95%'); 
  
      $('filemanager_open').set('html', fileManager.show());
    }
    
    window.addEvent('domready', function(){
      openFilemanager();
    });
  /* ]]> */
  </script>
  
  <style type="text/css">
  body {
    overflow: hidden;
  }
  </style>
</head>
<body>
<div id="filemanager_open"></div>
</body>
</html>

<!-- FILEMANAGER IFRAME
<iframe id="fileManagerFrame" name="fileManagerFrame" scrolling="no" src="library/thirdparty/filemanager/index.php?langCode=<?php echo $_SESSION["language"]; ?>"></iframe>-->