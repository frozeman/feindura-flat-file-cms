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

* controllers/savePage.controller.php version 0.1
*
* Takes data and saves it in the pageContent array of the page.
*
* Needs the following POST array format:
*
* <code>
* array (
*   'page' => 2,
*   'category' => 0,
*   'return' => false, // whether or not the saved data should be returned
*   'language' => 'en' // let it empty if the data is not localized
*   'type' => 'title'
*   'data' => array(
*         0 => 'New Title'
*       )
* )
* </code>
*
*/

/**
 * Includes the login.include.php and feindura.include.php and filter the basic data
 */
require_once(dirname(__FILE__)."/../includes/secure.include.php");


// SAVE the PAGE
// -----------------------------------------------------------------------------
if(is_numeric($_POST['page']) && !empty($_POST['type']) && is_array($_POST['data'])) {

  // var
  $return = '';
  $langCode = ($websiteConfig['multiLanguageWebsite']['active']) ? $_POST['language'] : 0;

  // read the page
  $pageContent = GeneralFunctions::readPage($_POST['page'],$_POST['category']);

  // switch the types
  switch ($_POST['type']) {

    // save the PLUGINS
    case 'plugins':
      $pluginsBefore = $pageContent['plugins'];
      unset($pageContent['plugins']);
      foreach ($_POST['data'] as $plugins) {
        $pluginNumber = substr($plugins, strpos($plugins, '#')+1);
        $pluginName = substr($plugins, 0 ,strpos($plugins, '#'));
        $pluginConfig = @include(dirname(__FILE__).'/../../plugins/'.$pluginName.'/config.php');

        // DebugTools::dump($pluginConfig);

        // add new plugins, but prevent to overwrite existing ones
        if(is_array($pluginsBefore[$pluginName][$pluginNumber]))
          $pageContent['plugins'][$pluginName][$pluginNumber] = $pluginsBefore[$pluginName][$pluginNumber];
        else {
          $pageContent['plugins'][$pluginName][$pluginNumber] = $pluginConfig;
          $pageContent['plugins'][$pluginName][$pluginNumber]['active'] = true;
        }

        unset($pluginConfig,$pluginName,$pluginNumber);
      }
      break;

    default:
      # code...
      break;
  }

  // ->> SAVE the PAGE
  if(GeneralFunctions::savePage($pageContent)) {
    // clear cache
    GeneralFunctions::deleteFolder(dirname(__FILE__).'/../../pages/cache/');

    // ->> save the FEEDS, if activated
    saveFeeds($pageContent['category']);
    // ->> save the SITEMAP
    saveSitemap();

    // show the saved data if return is TRUE
    if($_POST['return']) {
      $return = str_replace("\'", "'", $return);
      $return = str_replace('\"', '"', $return);
      die($return);
    }

  // ->> on FAILURE
  } else {
    ?>
    <script type="text/javascript">
    /* <![CDATA[ */
      var errorWindow = feindura_showError('<?php echo $langFile['errorWindow_h1']; ?>','<?php echo $langFile['ERROR_SAVEPAGE']; ?>');
      errorWindow.fade('hide');
      errorWindow.inject(document.body);
      errorWindow.fade(1);
    /* ]]> */
    </script>
    <?php
  }



  // -> replace the existing data with the new one
  // if(is_array($pageContent['localized'])) {
  //   $pageContent['localized'][$langCode]['title'] = ($_POST['type'] == 'title') ? $_POST['data'] : $pageContent['localized'][$langCode]['title'];
  //   $pageContent['localized'][$langCode]['content'] = ($_POST['type'] == 'editContent') ? $_POST['data'] : $pageContent['localized'][$langCode]['content'];
  //   $tmpReturn = ($_POST['type'] == 'title') ? $pageContent['localized'][$langCode]['title'] : $tmpReturn;
  //   $tmpReturn = ($_POST['type'] == 'editContent') ? $pageContent['localized'][$langCode]['content'] : $tmpReturn;
  // // legacy fallback
  // } else {
  //   $pageContent['title'] = ($_POST['type'] == 'title') ? $_POST['data'] : $pageContent['title'];
  //   $pageContent['content'] = ($_POST['type'] == 'editContent') ? $_POST['data'] : $pageContent['content'];
  //   $tmpReturn = ($_POST['type'] == 'title') ? $pageContent['title'] : $tmpReturn;
  //   $tmpReturn = ($_POST['type'] == 'editContent') ? $pageContent['content'] : $tmpReturn;
  // }


}

?>