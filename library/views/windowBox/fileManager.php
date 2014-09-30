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
 * fileManager.php
 *
 * @version 0.2
 */

/**
 * Includes the login.include.php and backend.include.php and filter the basic data
 */
require_once(dirname(__FILE__)."/../../includes/secure.include.php");

if(!GeneralFunctions::hasPermission('fileManager'))
  die('MooTools FileManager is deactivated');

?>
<!DOCTYPE html>
<html>
  <head>
  <meta charset="UTF-8">
  <meta http-equiv="content-language" content="<?php echo $_GET['langCode']; ?>">

  <title>feindura <?php echo $langFile['BUTTON_FILEMANAGER']; ?></title>

  <!-- thirdparty/MooTools -->
  <script type="text/javascript" src="../../thirdparty/javascripts/mootools-core-1.4.5.js"></script>
  <script type="text/javascript" src="../../thirdparty/javascripts/mootools-more-1.4.0.1.js"></script>

  <!-- thirdparty/MooTools-FileManager -->
  <script type="text/javascript" src="../../thirdparty/MooTools-FileManager/Source/FileManager.js"></script>
  <script type="text/javascript" src="../../thirdparty/MooTools-FileManager/Source/Uploader/Fx.ProgressBar.js"></script>
  <script type="text/javascript" src="../../thirdparty/MooTools-FileManager/Source/Uploader/Swiff.Uploader.js"></script>
  <script type="text/javascript" src="../../thirdparty/MooTools-FileManager/Source/Uploader.js"></script>
  <script type="text/javascript" src="../../thirdparty/MooTools-FileManager/Language/Language.<?php echo $_SESSION['feinduraSession']['backendLanguage']; ?>.js"></script>

  <script type="text/javascript">
  /* <![CDATA[ */
    function openFilemanager(){
      var complete = function(path, file){
        // remove the websitePath from the absolute path, to generate one relative to the websitePath
        // (don't use Path2URI on the websitePath, because the filemanager returns filesystem paths)
        path = path.replace('<?php echo GeneralFunctions::getDirname($adminConfig['websitePath']); ?>','');
        window.opener.CKEDITOR.tools.callFunction('<?php echo $_GET["CKEditorFuncNum"]; ?>', path);
        window.close();
      };

      var fileManager = new FileManager({
          url: '../../controllers/filemanager.controller.php',
          assetBasePath: '../../thirdparty/MooTools-FileManager/Assets',
          documentRootPath: '<?php echo DOCUMENTROOT ?>',
          language: '<?php echo $_SESSION["feinduraSession"]["backendLanguage"]; ?>',
          propagateData: {'<?php echo session_name(); ?>':'<?php echo session_id(); ?>'},
          filter: '<?php echo $_GET["mimType"]; ?>',
          deliverPathAsLegalURL: false,
          destroy: true,
          upload: true,
          move_or_copy: true,
          rename: true,
          download: true,
          createFolders: true,
          selectable: true,
          hideClose: true,
          hideOverlay: true,
          listType: 'thumb',
          listPaginationSize: 100,
          onComplete: complete
      });
      fileManager.filemanager.setStyle('width','100%');
      fileManager.filemanager.setStyle('height','95%');

      fileManager.show();
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
</body>
</html>