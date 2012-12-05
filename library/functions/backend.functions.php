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
 * This file contains the main functions used by the backend of the feindura-CMS.
 *
 * @package [Backend]
 *
 * @version 1.4
 * <br>
 * <b>ChangeLog</b><br>
 *    - 1.4 changed all save…() functions from fopen() to file_put_contents()
 *    - 1.33 isAdmin(): add immediately return true if no remote_user exists
 *    - 1.32 fixed editFiles()
 *    - 1.31 add checkStyleFiles()
 *
 */

/**
 * <b>Name</b> showErrorsInWindow()<br>
 *
 * gets the PHP errors, to show them in the errorWindow
 *
 *
 * <b>Used Global Variables</b><br>
 *    - <var>$ERRORWINDOW</var> the errorWindow text which will extended with the given errors from PHP
 *
 * @param int     $errorCode the PHP errorcode
 * @param string  $errorText the PHP error message
 * @param string  $errorFile the filename of the file where the erro occurred
 * @param int     $errorLine the line number where the error occurred
 *
 * @return bool TRUE if PHP should not handle th errors, FALSE if PHP should show the errors
 *
 *
 * @version 1.0
 * <br>
 * <b>ChangeLog</b><br>
 *    - 1.0 initial release
 *
 */
function showErrorsInWindow($errorCode, $errorText, $errorFile, $errorLine) {

    // var
    $error = '<span class="rawError">'.$errorText."<br><br>".$errorFile.' on line '.$errorLine."</span>\n";

    // suppress Error reporting with @
    if(0 == error_reporting()) { return; }

    switch ($errorCode) {
    case E_USER_ERROR:
        return false;
        break;

    //case E_USER_WARNING: case E_USER_NOTICE:
        //$GLOBALS['errorWindow'] .= $error;
        //break;

    default:
        $GLOBALS['errorWindow'] .= $error;
        break;
    }

    /* to prevent the internal PHP error reporting */
    return true;
}

/**
 * <b>Name</b> isBlocked()<br>
 *
 * Check if an other user is on the current site.
 *
 * @param bool $returnBool (optional) Whether the content blocked or a bool will be returned
 *
 * @return string|false The #contentBlocked DIV, if another user is on that site, otherwise FALSE
 *
 * @version 1.0
 * <br>
 * <b>ChangeLog</b><br>
 *    - 1.0 initial release
 *
 */
function isBlocked($returnBool = true) {


  if($_GET['site'] === 'dashboard' ||
     $_GET['site'] === 'pages' ||
     $_GET['site'] === 'search')
    return false;

  $return = '';
  foreach($GLOBALS['USERCACHE'] as $cachedUser) {
    $location = trim($cachedUser['location']);
    if($cachedUser['identity'] != IDENTITY &&
       $cachedUser['edit'] &&
       $location != 'new' && // dont block when createing a new page (multiple user can do that)
       ($location == $_GET['page'] || $location == $_GET['site'])) {

      if($returnBool) {
        $return = true;
      } else {
        $return = '<div id="contentBlocked" class="divBlocked"><div>'.$GLOBALS['langFile']['GENERAL_TEXT_CURRENTLYEDITED'];
        if(!empty($cachedUser['username']))
          $return .= '<br><span style="font-size:15px;">'.$GLOBALS['langFile']['USER_TEXT_USER'].': <span class="brown toolTipBottom noMark" title="::'.ucfirst($cachedUser['browser']).'">'.$cachedUser['username'].'</span></span>';
        $return .= '</div></div>';
      }
      return $return;
    }
  }
  return false;
}

/**
 * <b>Name</b> showCategory()<br>
 *
 * Check the current category has the permission to be displayed.
 *
 * It checks the category permission and then if at least on page inside the category has the permission to be edited.
 *
 * @param int $categoryId the ID of the category to check
 *
 * @return bool whether or not the category has permission
 *
 * @version 1.0
 * <br>
 * <b>ChangeLog</b><br>
 *    - 1.0 initial release
 *
 */
function showCategory($categoryId){
  // vars
  $return = false;

  if(GeneralFunctions::hasPermission('editableCategories',$categoryId))
    return true;

  // if not check the pages in it, if one has permission
  foreach($GLOBALS['pagesMetaData'] as $pageMetaData) {
    if($pageMetaData['category'] == $categoryId &&
       GeneralFunctions::hasPermission('editablePages',$pageMetaData['id']))
      $return = true;
  }

  return $return;
}

/**
 * <b>Name</b> userCache()<br>
 *
 * Creates a <var>user.statistic.cache</var> file and store the username and the currently visited site/page.
 *
 * An example of the saved cache lines
 * <samp>
 * c5b5533c8475801044fb7680059d5846|#|1306781298|#|chrome|#|frozeman|#|websiteSetup|#|edit
 * 4afe1d41e2f2edbf07086b1c2c492c10|#|1306781299|#|firefox|#|test|#|websiteSetup
 * </samp>
 *
 * <b>Used Global Variables</b><br>
 *    - <var>$userConfig</var> the user-settings config (included in the {@link general.include.php})
 *
 *
 * @return array an array with all users and current sites/pages
 *
 * @version 1.0
 * <br>
 * <b>ChangeLog</b><br>
 *    - 1.0 initial release
 *
 */
function userCache() {

  //var
  $location = (isset($_GET['page']) && !empty($_GET['page'])) ? $_GET['page'] : $_GET['site'];
  if(empty($location)) $location = 'dashboard';
  $return = array();
  $stored = false;
  $maxTime = 200; // 2min+, 3600 seconds = 1 hour
  $timeStamp = time();
  $browser = StatisticFunctions::getBrowser();
  $cacheFile = dirname(__FILE__)."/../../statistics/user.statistic.cache";
  $newLines = array();
  $cachedLines = false;

  // -> OPEN user.statistic.cache for reading
  if($cache = @fopen($cacheFile,"r")) {
    flock($cache,LOCK_SH);
    if(is_file($cacheFile))
      $cachedLines = @file($cacheFile);
    flock($cache,LOCK_UN);
    fclose($cache);
  }

  // STORE OLD CACHE LINES
  if(is_array($cachedLines)) {

    // check if a user is already on the current location
    $free = true;
    foreach($cachedLines as $cachedLine) {
      $cachedLineArray = explode('|#|', $cachedLine);
      if(IDENTITY != trim($cachedLineArray[0]) &&
         trim($cachedLineArray[4]) == $location &&
         isset($cachedLineArray[5]))
        $free = false;
    }

    foreach($cachedLines as $cachedLine) {
      $cachedLineArray = explode('|#|', $cachedLine);

      // stores the user AGAIN with new timestamp, if the user was less than $maxTime on the page,
      // otherwise remove the user form the cache (dont save his line)
      if(!empty($location) && $timeStamp - $cachedLineArray[1] < $maxTime) {

        if($cachedLineArray[0] == IDENTITY) {
          $edit = ($free) ? '|#|edit' : false;

          $newLines[] = IDENTITY.'|#|'.$timeStamp.'|#|'.$browser.'|#|'.$GLOBALS['userConfig'][$_SESSION['feinduraSession']['login']['user']]['username'].'|#|'.$location.$edit;
          $addArray = array('identity' => IDENTITY, 'timestamp' => $timeStamp, 'browser' => $browser, 'username' => $GLOBALS['userConfig'][$_SESSION['feinduraSession']['login']['user']]['username'], 'location' => $location);

          if($free) $addArray['edit'] = true;
          $return[] = $addArray;
          $stored = true;
        } elseif(!empty($cachedLineArray[0])) {
          $newLines[] = $cachedLine;

          $addArray = array('identity' => $cachedLineArray[0], 'timestamp' => $cachedLineArray[1], 'browser' => $cachedLineArray[2], 'username' => $cachedLineArray[3], 'location' => trim($cachedLineArray[4]));

          if(isset($cachedLineArray[5])) $addArray['edit'] = true;
          $return[] = $addArray;
        }
      }
    }
  }

  // STORE NEW CACHE LINE
  if($stored === false && !empty($location)) {
    $edit = ($free) ? '|#|edit' : false;
    $newLines[] = IDENTITY.'|#|'.$timeStamp.'|#|'.$browser.'|#|'.$GLOBALS['userConfig'][$_SESSION['feinduraSession']['login']['user']]['username'].'|#|'.$location.$edit;
    $addArray = array('identity' => IDENTITY, 'timestamp' => $timeStamp, 'browser' => $browser, 'username' => $GLOBALS['userConfig'][$_SESSION['feinduraSession']['login']['user']]['username'], 'location' => $location);
    if($free) $addArray['edit'] = true;
    $return[] = $addArray;
  }

  // CREATE file content
  $fileContent = '';
  foreach($newLines as $newLine) {
    $newLine = trim($newLine);
    $fileContent .= $newLine."\n";
  }

  // -> write file
  if(file_put_contents($cacheFile, $fileContent, LOCK_EX))
    // -> add permissions on the first creation
    if(!$cachedLines) @chmod($cacheFile, $GLOBALS['adminConfig']['permissions']);

  // return the right users
  return $return;
}

/**
 * <b>Name</b> getNewPageId()<br>
 *
 * Returns a new page ID, which is the highest page ID + 1.
 *
 * <b>Used Global Variables</b><br>
 *    - <var>$pageMetaData</var> to get the highest id (included in the {@link general.include.php})
 *
 * @return int a new page ID
 *
 *
 * @version 2.0
 * <br>
 * <b>ChangeLog</b><br>
 *    - 2.0 uses now $pagesMetaData
 *    - 1.0 initial release
 *
 */
function getNewPageId() {
  $highestId = 0;

  // go trough the file list and look for the highest number
  if(is_array($GLOBALS['pagesMetaData'])) {
    foreach($GLOBALS['pagesMetaData'] as $pageMetaData) {
      if($pageMetaData['id'] > $highestId)
        $highestId = $pageMetaData['id'];
    }
  }
  $highestId++;
  return $highestId;
}

/**
 * <b>Name</b> getNewCatgoryId()<br>
 *
 * Returns a new category ID, which is the highest category ID + 1.
 *
 * <b>Used Global Variables</b><br>
 *    - <var>$categoryConfig</var> the categories-settings config (included in the {@link general.include.php})
 *
 * @return int a new category ID
 *
 *
 * @version 1.0
 * <br>
 * <b>ChangeLog</b><br>
 *    - 1.0 initial release
 *
 */
function getNewCatgoryId() {

  // gets the highest id
  $highestId = 0;
  if(is_array($GLOBALS['categoryConfig'])) {
    foreach($GLOBALS['categoryConfig'] as $category) {
      if($category['id'] > $highestId)
        $highestId = $category['id'];
    }
    return ++$highestId;
  } else
    return 1;
}

/**
 * <b>Name</b> getNewUserId()<br>
 *
 * Returns a new user ID, which is the highest user ID + 1.
 *
 * <b>Used Global Variables</b><br>
 *    - <var>$userConfig</var> the user-settings config (included in the {@link general.include.php})
 *
 * @return int a new user ID
 *
 *
 * @version 1.0
 * <br>
 * <b>ChangeLog</b><br>
 *    - 1.0 initial release
 *
 */
function getNewUserId() {

  // gets the highest id
  $highestId = 0;
  if(is_array($GLOBALS['userConfig'])) {
    foreach($GLOBALS['userConfig'] as $user) {
      if($user['id'] > $highestId)
        $highestId = $user['id'];
    }
    return ++$highestId;
  } else
    return 1;
}

/**
 * <b>Name</b> checkPagesMetaData()<br>
 *
 * Check all pages in if they were changed (changed the modified timestamp). If so save the {@link GeneralFunctions::pagesMetaData} again.
 *
 *
 * Example of the $pagesMetaData array:
 * {@example pagesMetaData.array.example.php}
 *
 * <b>Used Global Variables</b><br>
 *    - <var>$pageMetaData</var> to get the highest id (included in the {@link general.include.php})
 *
 * @uses GeneralFunctions::savePagesMetaData()
 *
 * @return bool TRUE if the pagesMetaData was saved again, otherwise FALSE
 *
 * @static
 * @version 1.0
 * <br>
 * <b>ChangeLog</b><br>
 *    - 1.0 initial release
 *
 */
function checkPagesMetaData() {

  // vars
  $savepagesMetaData = false;
  $pages = array();

  // clearstatcache();

  // ->> GET ALL PAGES, which are inside the /pages/ folder
  $files = GeneralFunctions::readFolderRecursive(dirname(__FILE__).'/../../pages/');
  if(is_array($files['files'])) {
    foreach ($files['files'] as $file) {
      // load category pages
      if(preg_match('#^.*\/([0-9]+)/([0-9]+)\.php$#',$file,$match)) {
        if(!isset($GLOBALS['pagesMetaData'][$match[2]]) || $GLOBALS['pagesMetaData'][$match[2]]['category'] != $match[1] || $GLOBALS['pagesMetaData'][$match[2]]['modified'] < @filemtime(DOCUMENTROOT.$file))
          $savepagesMetaData = true;
      // load non category pages
      } elseif(preg_match('#^.*/([0-9]+)\.php$#',$file,$match)) {
        if(!isset($GLOBALS['pagesMetaData'][$match[1]]) || $GLOBALS['pagesMetaData'][$match[1]]['category'] != 0 || $GLOBALS['pagesMetaData'][$match[1]]['modified'] < @filemtime(DOCUMENTROOT.$file))
          $savepagesMetaData = true;
      }
    }
  }

  if($savepagesMetaData) {
    // echo 'RESAVED PAGESMETADATA';
    GeneralFunctions::savePagesMetaData();
    return true;
  } else {
    // echo 'PAGESMETADATA UNTOUCHED';
    return false;
  }
}

/**
 * <b>Name</b> addSlashesToPaths()<br>
 *
 * Ensures that all values of the $postData var with a 'Path' in the key value start and end with a slash.
 *
 * @param array $postData an array with path values
 *
 * @return array the changed $postData parameter
 *
 * @version 1.1
 * <br>
 * <b>ChangeLog</b><br>
 *    - 1.2 now returns the changed $postData parameter
 *    - 1.0.1 add slash to start also
 *    - 1.0 initial release
 *
 */
function addSlashesToPaths($postData) {
  foreach($postData as $postKey => $post) {
    if(strpos($postKey,'Path')!== false) {
      if(!empty($post) && substr($post,-1) !== '/')
        $post = $post.'/'; // add slash to the end
      if(!empty($post) && substr($post,0,1) !== '/')
        $post = '/'.$post; // add slash to the start
      $post = preg_replace("#/+#",'/',$post);

      $return[$postKey] = $post;

    } elseif(is_array($post))
      $return[$postKey] = addSlashesToPaths($post);
    else
      $return[$postKey] = $post;
  }
  return $return;
}

/**
 * <b>Name</b> removeDocumentRootFromPaths()<br>
 *
 * Removes the DOCUMENTROOT from all values of the $postData var with a 'Path' in the key value.
 *
 * <b>Used Constants</b><br>
 *    - <var>DOCUMENTROOT</var> the absolut path of the webserver
 *
 * @param array $postData an array with path values
 *
 * @return array the changed $postData parameter
 *
 * @version 1.0
 * <br>
 * <b>ChangeLog</b><br>
 *    - 1.0 initial release
 *
 */
function removeDocumentRootFromPaths($postData) {
  foreach($postData as $postKey => $post) {
    if(strpos($postKey,'Path')!== false)
      $return[$postKey] = str_replace(DOCUMENTROOT,'',$post);
    elseif(is_array($post))
      $return[$postKey] = removeDocumentRootFromPaths($post);
    else
      $return[$postKey] = $post;

  }
  return $return;
}

/**
 * <b>Name</b> createBasicFilesAndFolders()<br>
 *
 * Check if the config, pages and statistic folders exist, if not try to create these.
 *
 *
 * @version 1.1
 * <br>
 * <b>ChangeLog</b><br>
 *    - 1.1 add categoryConfig
 *    - 1.0.1 add backups folder
 *    - 1.0 initial release
 *
 */
function createBasicFilesAndFolders() {

  // config folder
  if(!is_dir(dirname(__FILE__).'/../../config'))
    mkdir(dirname(__FILE__).'/../../config',$GLOBALS['adminConfig']['permissions']);

  // upload folder
  if(!is_dir(dirname(__FILE__).'/../../upload'))
    mkdir(dirname(__FILE__).'/../../upload',$GLOBALS['adminConfig']['permissions']);

  // create CategoryConfig
  if(!is_file(dirname(__FILE__).'/../../config/category.config.php')) {
    $categoryConfig[0]['id'] = 0;
    saveCategories($categoryConfig);
    $GLOBALS['categoryConfig'] = include(dirname(__FILE__).'/../../config/category.config.php');
  }

  // pages folder
  if(!is_dir(dirname(__FILE__).'/../../pages'))
    if(mkdir(dirname(__FILE__).'/../../pages',$GLOBALS['adminConfig']['permissions']))
      file_put_contents(dirname(__FILE__).'/../../pages/VERSION', "feindura - content version\n".VERSION."\n".BUILD);
  // statistic folder
  if(!is_dir(dirname(__FILE__).'/../../statistics'))
    mkdir(dirname(__FILE__).'/../../statistics',$GLOBALS['adminConfig']['permissions']);
  // backups folder
  if(!is_dir(dirname(__FILE__).'/../../backups'))
    mkdir(dirname(__FILE__).'/../../backups',$GLOBALS['adminConfig']['permissions']);
}

/**
 * <b>Name</b> saveCategories()<br>
 *
 * Saves the category-settings config array to the "config/category.config.php" file.
 *
 * <b>Used Constants</b><br>
 *    - <var>"<?php\n"</var> the php start tag
 *    - <var>"\n?>"</var> the php end tag
 *
 * <b>Used Global Variables</b><br>
 *    - <var>$GeneralFunctions</var> to reset the {@link getStoredPagesIds} (included in the {@link general.include.php})
 *
 * @param array $newCategories a $categoryConfig array to save
 *
 * @return bool TRUE if the file was succesfull saved, otherwise FALSE
 *
 * @example backend/categoryConfig.array.example.php of the $categoryConfig array
 *
 * @version 1.4
 * <br>
 * <b>ChangeLog</b><br>
 *    - 1.4 changed 'plugins' to bool
 *    - 1.3 moved ['pages'] and styleFile, class, id from the adminConfig to the categoryConfig
 *    - 1.2 add localization
 *    - 1.1 change from fopen() to file_put_contents()
 *    - 1.0.2 add prevent resetting check
 *    - 1.0.1 add XssFilter to every value
 *    - 1.0 initial release
 *
 */
function saveCategories($newCategories) {

  // prevent resetting config
  if($newCategories == 1)
    return false;

  // CREATE file content
  $fileContent = '';
  $fileContent .= "<?php\n"; //< ?php

  // ->> GO through EVERY catgory and write it
  foreach($newCategories as $category) {
    // -> CHECK depency of PAGEDATE
    if(!isset($category['showPageDate']) && $category['sorting'] == 'byPageDate' && $GLOBALS['categoryConfig'][$category['id']]['showPageDate'])
      $category['sorting'] = 'manually';
    if($category['sorting'] == 'byPageDate' && !isset($category['showPageDate']))
      $category['showPageDate'] = 'true';

    // -> CHECK if the THUMBNAIL HEIGHT/WIDTH is empty, and add the previous ones
    if(!isset($category['thumbWidth']))
      $category['thumbWidth'] = $GLOBALS['categoryConfig'][$category['id']]['thumbWidth'];
    if(!isset($category['thumbHeight']))
      $category['thumbHeight'] = $GLOBALS['categoryConfig'][$category['id']]['thumbHeight'];

    // -> escape \ and '
    $category = XssFilter::escapeBasics($category);

    // adds absolute path slash on the beginning and serialize the stylefiles
    $category['styleFile'] = prepareStyleFilePaths($category['styleFile']);

    // bubbles through the page, category and adminConfig to see if it should save the styleheet-file path, id or class-attribute
    $category['styleFile']  = setStylesByPriority($category['styleFile'],'styleFile',$category['id'],true);
    $category['styleId']    = setStylesByPriority($category['styleId'],'styleId',$category['id'],true);
    $category['styleClass'] = setStylesByPriority($category['styleClass'],'styleClass',$category['id'],true);

    // WRITE
    $fileContent .= "\$categoryConfig[".$category['id']."]['id']                  = ".XssFilter::int($category['id'],0).";\n";
    $fileContent .= "\$categoryConfig[".$category['id']."]['public']              = ".XssFilter::bool($category['public'],true).";\n";
    $fileContent .= "\$categoryConfig[".$category['id']."]['isSubCategory']       = ".XssFilter::bool($category['isSubCategory'],true).";\n";
    $fileContent .= "\$categoryConfig[".$category['id']."]['isSubCategoryOf']     = '".$category['isSubCategoryOf']."';\n";
    $fileContent .= "\$categoryConfig[".$category['id']."]['createDelete']        = ".XssFilter::bool($category['createDelete'],true).";\n";
    $fileContent .= "\$categoryConfig[".$category['id']."]['thumbnails']          = ".XssFilter::bool($category['thumbnails'],true).";\n";
    $fileContent .= "\$categoryConfig[".$category['id']."]['plugins']             = ".XssFilter::bool($category['plugins'],true).";\n";
    $fileContent .= "\$categoryConfig[".$category['id']."]['showTags']            = ".XssFilter::bool($category['showTags'],true).";\n";
    $fileContent .= "\$categoryConfig[".$category['id']."]['showPageDate']        = ".XssFilter::bool($category['showPageDate'],true).";\n";
    $fileContent .= "\$categoryConfig[".$category['id']."]['pageDateAsRange']     = ".XssFilter::bool($category['pageDateAsRange'],true).";\n";
    $fileContent .= "\$categoryConfig[".$category['id']."]['showSubCategory']     = ".XssFilter::bool($category['showSubCategory'],true).";\n";
    $fileContent .= "\$categoryConfig[".$category['id']."]['feeds']               = ".XssFilter::bool($category['feeds'],true).";\n\n";

    $fileContent .= "\$categoryConfig[".$category['id']."]['sorting']             = '".XssFilter::alphabetical($category['sorting'],'manually')."';\n";
    $fileContent .= "\$categoryConfig[".$category['id']."]['sortReverse']         = ".XssFilter::bool($category['sortReverse'],true).";\n\n";

    $fileContent .= "\$categoryConfig[".$category['id']."]['styleFile']           = '".$category['styleFile']."';\n"; //XssFilter is in prepareStyleFilePaths() function
    $fileContent .= "\$categoryConfig[".$category['id']."]['styleId']             = '".XssFilter::string($category['styleId'])."';\n";
    $fileContent .= "\$categoryConfig[".$category['id']."]['styleClass']          = '".XssFilter::string($category['styleClass'])."';\n\n";

    $fileContent .= "\$categoryConfig[".$category['id']."]['thumbWidth']          = ".XssFilter::int($category['thumbWidth']).";\n";
    $fileContent .= "\$categoryConfig[".$category['id']."]['thumbHeight']         = ".XssFilter::int($category['thumbHeight']).";\n";
    $fileContent .= "\$categoryConfig[".$category['id']."]['thumbRatio']          = '".XssFilter::alphabetical($category['thumbRatio'])."';\n\n";

    // save localized
    if($category['id'] !== 0 && is_array($category['localized'])) {
      foreach ($category['localized'] as $langCode => $categoryLocalized) {

        // remove the '' when its 0 (for non localized pages)
        $langCode = (is_numeric($langCode)) ? $langCode : "'".$langCode."'";

        $fileContent .= "\$categoryConfig[".$category['id']."]['localized'][".$langCode."]['name']   = '".XssFilter::text($categoryLocalized['name'])."';\n";
       }
    }
    $fileContent .= "\n\n";

  }
  $fileContent .= 'return $categoryConfig;';
  $fileContent .= "\n?>"; //? >

  // -> SAVE the flat file
  if(file_put_contents(dirname(__FILE__)."/../../config/category.config.php", $fileContent, LOCK_EX)) {
    // reload the $pagesMetaData array
    GeneralFunctions::savePagesMetaData();
    return true;
  } else
    return false;
}

/**
 * <b>Name</b> moveCategories()<br>
 *
 * Change the order of the <var>$categoryConfig</var> array.
 *
 * @param array       &$categoryConfig the $categoryConfig array (will also be changed global)
 * @param int         $category        the ID of the category to move
 * @param string      $direction       the direction to move, can be "up" or "down"
 * @param false|int   $position        (optional) the exact position where the category should be moved ("1" is top), if is number the $direction paramter doesn't count
 *
 * @return bool TRUE if the category was succesfull moved, otherwise FALSE
 *
 * @example backend/categoryConfig.array.example.php of the $categoryConfig array
 *
 * @version 1.1
 * <br>
 * <b>ChangeLog</b><br>
 *    - 1.1 prevent moving of the non-category
 *    - 1.0 initial release
 *
 */
function moveCategories(&$categoryConfig, $category, $direction, $position = false) {

  // deny if its the non category
  if(empty($category))
    return false;

  $direction = strtolower($direction);


  // ->> CHECKS
  // if they fail it returns the unchanged $categoryConfig array
  if(is_array($categoryConfig) &&                     // is categories is array
    is_numeric($category) &&                          // have the given category id is a number
    $category == $categoryConfig[$category]['id'] &&  // dows the category exists in the $categoryConfig array
    (!$direction || $direction == 'up' || $direction == 'down') &&
    (!$position || is_numeric($position))) {   // is the right direction is given

    // vars
    $count = 1;
    $currentPosition = false;
    $dropedCategories = array();

    $nonCat[0] = $categoryConfig[0];
    unset($categoryConfig[0]);

    // -> finds out the position in the $categoryConfig array
    // and extract this category from it
    foreach($categoryConfig as $sortCategory) {
      //echo '>'.$sortCategory['id'].' -> '.$count.'<br>';

      if($sortCategory['id'] == $category) {
        $currentPosition = $count;
        $extractCategory = $sortCategory;
      } else
        $dropedCategories[$sortCategory['id']] = $sortCategory;

      $count++;
    }
    //echo 'currentPos: '.$currentPosition;

    // -> creates a new array with the category at the new position
    $count = 1;
    $sortetCategories = array();
    foreach($dropedCategories as $sortCategory) {

      // MOVE BY POSITION
      if($position !== false && is_numeric($position)) {

         //echo 'exactPos: '.$position;

        // if the position is lower than 1
        if($position < 1) {
          if($count == 1)
            $sortetCategories[] = $extractCategory;
          // put it at the first position
         $sortetCategories[] = $dropedCategories[$sortCategory['id']];
        }

        // if the position is higher than the count() of the array
        if($position > count($dropedCategories)) {
          $sortetCategories[] = $dropedCategories[$sortCategory['id']];
          // put it at the last position
          if($count == count($dropedCategories))
            $sortetCategories[] = $extractCategory;
        }

        // if it is in the array put it at the exact position
        if($position >= 1 && $position <= count($dropedCategories)) {
          if($position == $count)
            $sortetCategories[] = $extractCategory;
          // put it at the first position
          $sortetCategories[] = $dropedCategories[$sortCategory['id']];
        }

      // MOVE BY DIRECTION
      } else {
        // move the category UP
        // -------------
        if($direction == 'up') {

          // if the currentPosition is outside of the foreach
          if(($currentPosition - 1) <= 1) {
            // add the extract at the beginging of the array
            if($count == 1)
              $sortetCategories[] = $extractCategory;

          // add the extract at the new position
          } elseif(($currentPosition - 1) == $count)
              $sortetCategories[] = $extractCategory;
        }

        // adds the unmoved categories to the array
        // -------------
        $sortetCategories[] = $dropedCategories[$sortCategory['id']];

        // move the category DOWN
        // -------------
        if($direction == 'down') {

          // if the currentPosition is outside of the foreach
          if(($currentPosition + 1) > count($dropedCategories)) {
            // add the extract at the end of the array
            if($count == count($dropedCategories))
              $sortetCategories[] = $extractCategory;

          // add the extract at the new position
          } elseif($currentPosition == $count)
              $sortetCategories[] = $extractCategory;
        }
      }

      $count++;
    }

    // -> set back the id as index
    $categoryConfig = array();
    foreach($sortetCategories as $sortetCategory) {
      $categoryConfig[$sortetCategory['id']] = $sortetCategory;
    }

    // merge non category into the categoryConfig, again
    $categoryConfig = array_merge($nonCat, $categoryConfig);

    return true;

  } else
    return false;
}

/**
 * <b>Name</b> checkSubCategories()<br>
 *
 * Goes through all pages and recheckes the <var>$categoryConfig['isSubCategoryOf']</var> and <var>$pageContent['subCategory']</var> values.
 * In Case a category was deleted it will erase this subcategory from the pages. In case a page is deleted it will erase the page from the isSubCategoryOf array.
 *
 * <b>Used Global Variables</b><br>
 *    - <var>$adminConfig</var> the administrator-settings config (included in the {@link general.include.php})
 *    - <var>$categoryConfig</var> the categories-settings config (included in the {@link general.include.php})
 *
 * @return bool TRUE if the cateogires were succesfull checked, otherwise FALSE
 *
 *
 * @version 1.0
 * <br>
 * <b>ChangeLog</b><br>
 *    - 1.0 initial release
 *
 */
function checkSubCategories() {

  // vars
  $allPages = GeneralFunctions::loadPages(true);
  $pageContents = array();

  // -> CHECK in PAGES, if the sub category still exists and if the pages have subCategories activated
  foreach($allPages as $pageContent) {
    if(is_numeric($pageContent['subCategory']) &&
       (!isset($GLOBALS['categoryConfig'][$pageContent['subCategory']]) || !$GLOBALS['categoryConfig'][$pageContent['category']]['showSubCategory'])) {
      $pageContent['subCategory'] = false;
      GeneralFunctions::savePage($pageContent,false,false);
    }

    $pageContents[$pageContent['id']] = $pageContent;
  }
  unset($pageContent);

  // SAVE the pagesMetaData array
  GeneralFunctions::savePagesMetaData();


  // return here if no categories exist
  if(empty($GLOBALS['categoryConfig']))
    return true;

  // -> CHECK in SUB CATEGORY if the pages still exists
  $newCategoryConfig = $GLOBALS['categoryConfig'];
  foreach ($GLOBALS['categoryConfig'] as $categoryId => $categoryConfig) {
    $subCategoryPages = unserialize($categoryConfig['isSubCategoryOf']);

    // check if the page still exists and has this category as subcategory
    $newSubCategoryPages = array();
    if(is_array($subCategoryPages)) {
      foreach ($subCategoryPages as $pageId => $pageCatId) {
        if(isset($pageContents[$pageId]) && $pageContents[$pageId]['subCategory'] == $categoryId)
          $newSubCategoryPages[$pageId] = $pageCatId;
      }
    }

    // serialize the checked isSubCategoryOf array
    $newCategoryConfig[$categoryId]['isSubCategoryOf'] = serialize($newSubCategoryPages);
    // set isSubCategory to false if isSubCategoryOf is empty
    if(empty($newSubCategoryPages))
      $newCategoryConfig[$categoryId]['isSubCategory'] = false;

    unset($newSubCategoryPages,$subCategoryPages);
  }


  if(saveCategories($newCategoryConfig))
    return true;
  else
    return false;

}

/**
 * <b>Name</b> movePage()<br>
 *
 * Moves a file into a new category directory.
 *
 * <b>Used Global Variables</b><br>
 *    - <var>$adminConfig</var> the administrator-settings config (included in the {@link general.include.php})
 *
 * @param int $page         the page ID
 * @param int $fromCategory the ID of the category where the page is situated
 * @param int $toCategory   the ID of the category where the file will be moved to
 *
 * @return bool TRUE if the page was succesfull moved, otherwise FALSE
 *
 * @version 1.1
 * <br>
 * <b>ChangeLog</b><br>
 *    - 1.1 add moving the previous page too
 *    - 1.0.1 add create category folder, if not exiting
 *    - 1.0 initial release
 *
 */
function movePage($page, $fromCategory, $toCategory) {

  // if there are pages not in a category set the category to empty
  $fromCategory = ($fromCategory === false || $fromCategory == 0)
    ? '' : $fromCategory.'/';
  $toCategory = ($toCategory === false || $toCategory == 0)
    ? '' : $toCategory.'/';

  // create category folder if its not exist
  if(!empty($toCategory) && !is_dir(dirname(__FILE__).'/../../pages/'.$toCategory))
    mkdir(dirname(__FILE__).'/../../pages/'.$toCategory,$GLOBALS['adminConfig']['permissions'],true);

  // MOVE categories
  if(rename(dirname(__FILE__).'/../../pages/'.$fromCategory.$page.'.php',
            dirname(__FILE__).'/../../pages/'.$toCategory.$page.'.php')) {

    // move the previous page too
    if(file_exists(dirname(__FILE__).'/../../pages/'.$fromCategory.$page.'.previous.php')) {
       rename(dirname(__FILE__).'/../../pages/'.$fromCategory.$page.'.previous.php',
              dirname(__FILE__).'/../../pages/'.$toCategory.$page.'.previous.php');
    }

    // reset the stored page ids
    GeneralFunctions::$storedPages = null;

    // reload the $pagesMetaData array
    GeneralFunctions::savePagesMetaData();

    return true;
  } else
    return false;
}

/**
 * <b>Name</b> saveAdminConfig()<br>
 *
 * Saves the administrator-settings config array to the "config/admin.config.php" file.
 *
 * <b>Used Constants</b><br>
 *    - <var>"<?php\n"</var> the php start tag
 *    - <var>"\n?>"</var> the php end tag
 *
 * @param array $adminConfig a $adminConfig array to save
 *
 * @return bool TRUE if the file was succesfull saved, otherwise FALSE
 *
 * @example backend/adminConfig.array.example.php of the $adminConfig array
 *
 * @version 1.3
 * <br>
 * <b>ChangeLog</b><br>
 *    - 1.3 moved ['pages'] and styleFile, class, id to the categoryConfig
 *    - 1.2 change from fopen() to file_put_contents()
 *    - 1.1.2 add prevent resetting check
 *    - 1.1.1 fixed chmod permissions
 *    - 1.1 add sorting
 *    - 1.0.2 add XssFilter to every value
 *    - 1.0.1 add websitePath
 *    - 1.0 initial release
 *
 */

function saveAdminConfig($adminConfig) {

  // prevent resetting config
  if($adminConfig !== 1) {

    // -> escape \ and '
    $adminConfig = XssFilter::escapeBasics($adminConfig);

    $permissions = (is_string($adminConfig['permissions']))
       ? octdec($adminConfig['permissions'])
       : $adminConfig['permissions'];

    @chmod(dirname(__FILE__)."/../../config/admin.config.php", $permissions);

    // CREATE file content
    $fileContent = '';
    $fileContent .= "<?php\n"; // < ?php

    $fileContent .= "\$adminConfig['documentroot']      = '".XssFilter::path($adminConfig['documentroot'])."';\n";
    $fileContent .= "\$adminConfig['url']               = '".XssFilter::url($adminConfig['url'])."';\n";
    $fileContent .= "\$adminConfig['basePath']          = '".XssFilter::path($adminConfig['basePath'])."';\n";
    $fileContent .= "\$adminConfig['websitePath']       = '".XssFilter::path($adminConfig['websitePath'],false,'/')."';\n";
    $fileContent .= "\$adminConfig['websiteFilesPath']  = '".XssFilter::path($adminConfig['websiteFilesPath'])."';\n";
    $fileContent .= "\$adminConfig['stylesheetPath']    = '".XssFilter::path($adminConfig['stylesheetPath'])."';\n\n";

    $fileContent .= "\$adminConfig['permissions']       = ".XssFilter::number($adminConfig['permissions']).";\n";
    $fileContent .= "\$adminConfig['timezone']          = '".XssFilter::string($adminConfig['timezone'],'\/','Europe/London')."';\n";
    $fileContent .= "\$adminConfig['prettyURL']         = ".XssFilter::bool($adminConfig['prettyURL'],true).";\n\n";

    $fileContent .= "\$adminConfig['varName']['page']      = '".XssFilter::stringStrict($adminConfig['varName']['page'],'page')."';\n";
    $fileContent .= "\$adminConfig['varName']['category']  = '".XssFilter::stringStrict($adminConfig['varName']['category'],'category')."';\n";
    $fileContent .= "\$adminConfig['varName']['modul']     = '".XssFilter::stringStrict($adminConfig['varName']['modul'],'modul')."';\n\n";

    $fileContent .= "\$adminConfig['cache']['active']      = ".XssFilter::bool($adminConfig['cache']['active'],true).";\n";
    $fileContent .= "\$adminConfig['cache']['timeout']     = ".XssFilter::number($adminConfig['cache']['timeout'],5).";\n\n";

    $fileContent .= "\$adminConfig['editor']['htmlLawed']    = ".XssFilter::bool($adminConfig['editor']['htmlLawed'],true).";\n";
    $fileContent .= "\$adminConfig['editor']['safeHtml']     = ".XssFilter::bool($adminConfig['editor']['safeHtml'],true).";\n";
    $fileContent .= "\$adminConfig['editor']['editorStyles'] = ".XssFilter::bool($adminConfig['editor']['editorStyles'],true).";\n";
    $fileContent .= "\$adminConfig['editor']['snippets']     = ".XssFilter::bool($adminConfig['editor']['snippets'],true).";\n";
    $fileContent .= "\$adminConfig['editor']['enterMode']    = '".XssFilter::alphabetical($adminConfig['editor']['enterMode'])."';\n\n";

    $fileContent .= "\$adminConfig['pageThumbnail']['width']   = ".XssFilter::int($adminConfig['pageThumbnail']['width']).";\n";
    $fileContent .= "\$adminConfig['pageThumbnail']['height']  = ".XssFilter::int($adminConfig['pageThumbnail']['height']).";\n";
    $fileContent .= "\$adminConfig['pageThumbnail']['ratio']   = '".XssFilter::alphabetical($adminConfig['pageThumbnail']['ratio'])."';\n";

    $fileContent .= "return \$adminConfig;";
    $fileContent .= "\n?>"; //? >

    // -> SAVE the flat file
    if(file_put_contents(dirname(__FILE__)."/../../config/admin.config.php", $fileContent, LOCK_EX))
      return true;
    else
      return false;
  } else
    return false;
}

/**
 * <b>Name</b> saveUserConfig()<br>
 *
 * Saves the user-settings config array to the "config/user.config.php" file.
 *
 * <b>Used Constants</b><br>
 *    - <var>"<?php\n"</var> the php start tag
 *    - <var>"\n?>"</var> the php end tag
 *
 * @param array $userConfig a $userConfig array to save
 *
 * @return bool TRUE if the file was succesfull saved, otherwise FALSE
 *
 * @example backend/userConfig.array.example.php of the $userConfig array
 *
 * @version 1.1
 * <br>
 * <b>ChangeLog</b><br>
 *    - 1.1 change from fopen() to file_put_contents()
 *    - 1.0.2 add prevent resetting check
 *    - 1.0.1 add XssFilter to every value
 *    - 1.0 initial release
 *
 */
function saveUserConfig($userConfig) {

  // prevent resetting config
  if($userConfig !== 1) {

    // -> escape \ and '
    $userConfig = XssFilter::escapeBasics($userConfig);

    // CREATE file content
    $fileContent = '';
    $fileContent .= "<?php\n"; //< ?php
    foreach($userConfig as $user => $configs) {

      $fileContent .= "\$userConfig[".$user."]['id']       = ".XssFilter::int($configs['id'],0).";\n";
      $fileContent .= "\$userConfig[".$user."]['admin']    = ".XssFilter::bool($configs['admin'],true).";\n";
      $fileContent .= "\$userConfig[".$user."]['username'] = '".XssFilter::text($configs['username'])."';\n";
      $fileContent .= "\$userConfig[".$user."]['email']    = '".XssFilter::string($configs['email'])."';\n";
      $fileContent .= "\$userConfig[".$user."]['password'] = '".XssFilter::text($configs['password'])."';\n";
      $fileContent .= "\$userConfig[".$user."]['info']     = '".$configs['info']."';\n\n";// htmLawed in userSetup.controller.php

      $fileContent .= "\$userConfig[".$user."]['permissions']['frontendEditing']      = ".XssFilter::bool($configs['permissions']['frontendEditing'],true).";\n";
      $fileContent .= "\$userConfig[".$user."]['permissions']['fileManager']          = ".XssFilter::bool($configs['permissions']['fileManager'],true).";\n";
      $fileContent .= "\$userConfig[".$user."]['permissions']['websiteSettings']      = ".XssFilter::bool($configs['permissions']['websiteSettings'],true).";\n";
      $fileContent .= "\$userConfig[".$user."]['permissions']['editWebsiteFiles']     = ".XssFilter::bool($configs['permissions']['editWebsiteFiles'],true).";\n";
      $fileContent .= "\$userConfig[".$user."]['permissions']['editStyleSheets']      = ".XssFilter::bool($configs['permissions']['editStyleSheets'],true).";\n";
      $fileContent .= "\$userConfig[".$user."]['permissions']['editSnippets']         = ".XssFilter::bool($configs['permissions']['editSnippets'],true).";\n\n";

      // editable categories
      if(is_array($configs['permissions']['editableCategories'])) {
        foreach ($configs['permissions']['editableCategories'] as $editableCategory) {
          $fileContent .= "\$userConfig[".$user."]['permissions']['editableCategories'][]  = ".XssFilter::int($editableCategory).";\n";
        }
      }
      // editable pages
      if(is_array($configs['permissions']['editablePages'])) {
        foreach ($configs['permissions']['editablePages'] as $editablePage) {
          // check that the add page is not already in one of the activated categories (prevent double adding)
          if(!in_array($GLOBALS['pagesMetaData'][$editablePage]['category'], $configs['permissions']['editableCategories']))
            $fileContent .= "\$userConfig[".$user."]['permissions']['editablePages'][]  = ".XssFilter::int($editablePage).";\n";
        }
      }

      $fileContent .= "\n\n";
    }
    $fileContent .= "return \$userConfig;";

    $fileContent .= "\n?>"; //? >

    // -> SAVE the flat file
    if(file_put_contents(dirname(__FILE__)."/../../config/user.config.php", $fileContent, LOCK_EX))
      return true;
    else
      return false;
  } else
    return false;
}

/**
 * <b>Name</b> saveWebsiteConfig()<br>
 *
 * Saves the website-settings config array to the "config/website.config.php" file.
 *
 * <b>Used Constants</b><br>
 *    - <var>"<?php\n"</var> the php start tag
 *    - <var>"\n?>"</var> the php end tag
 *
 * @param array $websiteConfig a $websiteConfig array to save
 *
 * @return bool TRUE if the file was succesfull saved, otherwise FALSE
 *
 * @example backend/websiteConfig.array.example.php of the $websiteConfig array
 *
 * @version 1.3
 * <br>
 * <b>ChangeLog</b><br>
 *    - 1.3 add sitemap files option
 *    - 1.2 add localization
 *    - 1.1 change from fopen() to file_put_contents()
 *    - 1.0.3 add prevent resetting check
 *    - 1.0.2 add XssFilter to every value
 *    - 1.0.1 removed $websiteconfig['email'], because its now set up in the contactForm plugin
 *    - 1.0 initial release
 *
 */
function saveWebsiteConfig($websiteConfig) {

  // opens the file for writing
  if($websiteConfig !== 1) { // prevent resetting config

    // -> escape \ and '
    $websiteConfig = XssFilter::escapeBasics($websiteConfig);

    // CREATE file content
    $fileContent = '';
    $fileContent .= "<?php\n"; //< ?php

    $fileContent .= "\$websiteConfig['maintenance']                          = ".XssFilter::bool($websiteConfig['maintenance'],true).";\n";
    $fileContent .= "\$websiteConfig['dateFormat']                           = '".XssFilter::string($websiteConfig['dateFormat'])."';\n";
    $fileContent .= "\$websiteConfig['sitemapFiles']                         = ".XssFilter::bool($websiteConfig['sitemapFiles'],true).";\n";
    $fileContent .= "\$websiteConfig['visitorTimezone']                      = ".XssFilter::bool($websiteConfig['visitorTimezone'],true).";\n\n";

    $fileContent .= "\$websiteConfig['startPage']                            = ".XssFilter::int($websiteConfig['startPage'],0).";\n\n";

    $fileContent .= "\$websiteConfig['multiLanguageWebsite']['active']       = ".XssFilter::bool($websiteConfig['multiLanguageWebsite']['active'],true).";\n";
    if(is_array($websiteConfig['multiLanguageWebsite']['languages'])) {
      foreach ($websiteConfig['multiLanguageWebsite']['languages'] as $langKey) {
        $langCode = XssFilter::alphabetical($langKey,$_SESSION['feinduraSession']);
        if($langCode && strlen($langCode) == 2)
          $fileContent .= "\$websiteConfig['multiLanguageWebsite']['languages'][]    = '".$langCode."';\n";
      }
    }
    $fileContent .= "\$websiteConfig['multiLanguageWebsite']['mainLanguage']   = '".XssFilter::alphabetical($websiteConfig['multiLanguageWebsite']['mainLanguage'],0)."';\n\n";

    // save localized
    if(is_array($websiteConfig['localized'])) {
      foreach ($websiteConfig['localized'] as $langCode => $websiteConfigLocalized) {

        // remove the '' when its 0 (for non localized pages)
        $langCode = (is_numeric($langCode)) ? $langCode : "'".$langCode."'";

        $fileContent .= "\$websiteConfig['localized'][".$langCode."]['title']          = '".XssFilter::text($websiteConfigLocalized['title'])."';\n";
        $fileContent .= "\$websiteConfig['localized'][".$langCode."]['publisher']      = '".XssFilter::text($websiteConfigLocalized['publisher'])."';\n";
        $fileContent .= "\$websiteConfig['localized'][".$langCode."]['copyright']      = '".XssFilter::text($websiteConfigLocalized['copyright'])."';\n";
        $fileContent .= "\$websiteConfig['localized'][".$langCode."]['keywords']       = '".XssFilter::text(trim(preg_replace("#[\;,]+#", ',', $websiteConfigLocalized['keywords']),','))."';\n";
        $fileContent .= "\$websiteConfig['localized'][".$langCode."]['description']    = '".XssFilter::text($websiteConfigLocalized['description'])."';\n\n";
      }
    }

    $fileContent .= "return \$websiteConfig;";

    $fileContent .= "\n?>"; //? >

    // -> SAVE the flat file
    if(file_put_contents(dirname(__FILE__).'/../../config/website.config.php', $fileContent, LOCK_EX)) {
      unset($GLOBALS['websiteConfig']); $GLOBALS['websiteConfig'] = include(dirname(__FILE__).'/../../config/website.config.php');
      // reload $pagesMetaData array, because of the startPage
      GeneralFunctions::savePagesMetaData();
      return true;
    } else
      return false;
  } else
    return false;
}


/**
 * <b>Name</b> saveStatisticConfig()<br>
 *
 * Saves the statiostic-settings config array to the "config/statistic.config.php" file.
 *
 * <b>Used Constants</b><br>
 *    - <var>"<?php\n"</var> the php start tag
 *    - <var>"\n?>"</var> the php end tag
 *
 * @param array $statisticConfig a $statisticConfig array to save
 *
 * @return bool TRUE if the file was succesfull saved, otherwise FALSE
 *
 * @example backend/statisticConfig.array.example.php of the $statisticConfig array
 *
 * @version 1.2
 * <br>
 * <b>ChangeLog</b><br>
 *    - 1.2 removed numbers fro the listpage in dashboard (mostvied, lastpages, etc..)
 *    - 1.1 change from fopen() to file_put_contents()
 *    - 1.0.2 add prevent resetting check
 *    - 1.0.1 add XssFilter to every value
 *    - 1.0 initial release
 *
 */
function saveStatisticConfig($statisticConfig) {

  // prevent resetting config
  if($statisticConfig !== 1) {

    // -> escape \ and '
    $statisticConfig = XssFilter::escapeBasics($statisticConfig);

    /// CREATE file content
    $fileContent = '';
    $fileContent .= "<?php\n"; //< ?php

    $fileContent .= "\$statisticConfig['number']['refererLog']    = ".XssFilter::int($statisticConfig['number']['refererLog'],100).";\n";
    $fileContent .= "\$statisticConfig['number']['taskLog']       = ".XssFilter::int($statisticConfig['number']['taskLog'],50).";\n\n";

    $fileContent .= "return \$statisticConfig;";

    $fileContent .= "\n?>"; //? >

    // -> SAVE the flat file
    if(file_put_contents(dirname(__FILE__)."/../../config/statistic.config.php", $fileContent, LOCK_EX))
      return true;
    else
      return false;
  } else
    return false;
}

/**
 * <b>Name</b> savePrettyUrlCode()<br>
 *
 * Check if Pretty URLs are activated and save a Pretty URL redirect code (needs mod_rewrite) to the .htacces file in the document root.
 *
 *
 * <b>Used Constants</b><br>
 *    - <var>DOCUMENTROOT</var> the absolut path of the webserver
 *
 * <b>Used Global Variables</b><br>
 *    - <var>$adminConfig</var> the administrator-settings config (included in the {@link general.include.php})
 *    - <var>$langFile</var> the language file of the backend (included in the {@link general.include.php})
 *    - <var>$XssFilter</var> the {@link XssFilter::__construct()} class instance created in the {@link general.include.php})
 *
 * @param false|string $ERRORWINDOW will be filled with an error message if an error occurs
 *
 * @return void
 *
 *
 * @version 1.1
 * <br>
 * <b>ChangeLog</b><br>
 *    - 1.1 fixed changing from old website url to a new one
 *    - 1.0.2 add "(?:[a-z]{2}/{1})?" to allow "en/" etc.
 *    - 1.0.1 small fix with website path; add GeneralFunctions::getRealPath()
 *    - 1.0 initial release
 *
 */
function savePrettyUrlCode(&$ERRORWINDOW) {

  // vars
  $save = false;
  $data = false;
  $websitePath = GeneralFunctions::getDirname($_POST['cfg_websitePath']);
  $websitePath = (empty($websitePath)) ? '/': $websitePath;
  $websitePath = GeneralFunctions::getRealPath($websitePath);
  if($websitePath === false) {
    $_POST['cfg_prettyURL'] = '';
    return false;
  }
  $htaccessFile = $websitePath.'/.htaccess';

  // page/category names
  $newPageName     = $_POST['cfg_varNamePage'];
  $newCategoryName = $_POST['cfg_varNameCategory'];
  $oldPageName     = $GLOBALS['adminConfig']['varName']['page'];
  $oldCategoryName = $GLOBALS['adminConfig']['varName']['category'];

  // (?:[\/a-z0-9_-]*/{1})?  <- is only to add parent pages
  $categoryRegEx = '  RewriteRule ^(?:([a-zA-Z]{2})/{1})?%s/([a-zA-Z0-9_-]+)/(?:[\/a-zA-Z0-9_-]*/{1})?([a-zA-Z0-9_-]+).*?$ ';
  $pageRegEx     = '  RewriteRule ^(?:([a-zA-Z]{2})/{1})?%s/(?:[\/a-zA-Z0-9_-]*/{1})?([a-zA-Z0-9_-]+).*?$ ';

  $newRewriteRule  = sprintf($pageRegEx,$newPageName).GeneralFunctions::Path2URI(XssFilter::path($_POST['cfg_websitePath'])).'?page=$2&language=$1 [QSA,L]'."\n";
  $newRewriteRule .= sprintf($categoryRegEx,$newCategoryName).GeneralFunctions::Path2URI(XssFilter::path($_POST['cfg_websitePath'])).'?category=$2&page=$3&language=$1 [QSA,L]';
  $oldRewriteRule  = sprintf($pageRegEx,$oldPageName).GeneralFunctions::Path2URI(XssFilter::path($GLOBALS['adminConfig']['websitePath'])).'?page=$2&language=$1 [QSA,L]'."\n";
  $oldRewriteRule .= sprintf($categoryRegEx,$oldCategoryName).GeneralFunctions::Path2URI(XssFilter::path($GLOBALS['adminConfig']['websitePath'])).'?category=$2&page=$3&language=$1 [QSA,L]';

  $prettyURLCode = '
#
# feindura - Flat File CMS -> Pretty URL Rewrite Code
#
<IfModule mod_rewrite.c>
  RewriteEngine on
  RewriteBase /
  # rewrite "/page/example-page" and "/category/example-category/example-page"
  # also passes the session var
  RewriteCond %{REQUEST_URI} !\.(css|jpg|gif|png|js)$ [NC] #do the stuff that follows only if the request doesnt end in one of these file extensions.
  RewriteCond %{HTTP_HOST} ^'.str_replace(array('http://www.','https://www.','http://','https://'),'',$_SERVER["HTTP_HOST"]).'$
'.$newRewriteRule.'
</IfModule>';

  $oldPrettyURLCode = str_replace($newRewriteRule,$oldRewriteRule,$prettyURLCode);

  // -> looks if the MOD_REWRITE modul exists
  $apacheModules = (function_exists('apache_get_modules')) ? apache_get_modules() : array('mod_rewrite');
  if(!in_array('mod_rewrite',$apacheModules)) {
    $_POST['cfg_prettyURL'] = '';
    return;
  }

  // **********************************
  // ->> if a the .htaccess file exists
  if(file_exists($htaccessFile)) {

    // vars
    $currrentContent = trim(file_get_contents($htaccessFile));

    // ->> create or change the .htaccess file
    if($_POST['cfg_prettyURL'] == 'true') {

      // -> if no prettyURL code exists, add new one (or update the old one)
      if(strpos($currrentContent,$prettyURLCode) === false) {

        $save = true;
        $currrentContent = str_replace($oldPrettyURLCode,'', $currrentContent); // removes perhaps existing old one
        $data = $currrentContent."\n".$prettyURLCode;

      }

    // ->> delete the .htaccess file or remove the prettyURL code
    } else {

      // -> ONLY if the PRETTY URL code is in the .htaccess then DELTE the .htaccess file
      if($currrentContent == $prettyURLCode ||
         $currrentContent == $oldPrettyURLCode) {
        @unlink($htaccessFile);

      // -> looks if PRETTY URL code EXISTs in the .htaccess file and remove it
      } elseif(strpos($currrentContent,$prettyURLCode) !== false ||
               strpos($currrentContent,$oldPrettyURLCode) !== false) {
        $newContent = str_replace($prettyURLCode,'',$currrentContent);
        $newContent = str_replace($oldPrettyURLCode,'',$currrentContent);

        $save = true;
        $data = $newContent;
      }
    }

  // -> if no .htaccess exists and pretty url is activated
  } elseif($_POST['cfg_prettyURL'] == 'true') {
    $save = true;
    $data = $prettyURLCode;
  }

  // **************************
  // ->> saves the htacces file
  if($save && !empty($data)) {

    $data = preg_replace("#\\n+$#","\n",$data); // prevent growing of the file with line endings

    // -> SAVE the .htaccess
    file_put_contents($htaccessFile, $data, LOCK_EX);

    @chmod($htaccessFile,0644);

  // ->> throw error
  } elseif($save) {
    $_POST['cfg_prettyURL'] = '';
    $ERRORWINDOW .= $GLOBALS['langFile']['ADMINSETUP_GENERAL_PRETTYURL_error_save'];
  }

  return;
}

/**
 * <b>Name</b> saveActivityLog()<br>
 *
 * Adds a entry to the task log-file with time and task which was performed.
 *
 * Example entry:
 * <samp>
 * 1334313735|#|frozeman|#|i:1;|#|page=3
 * </samp>
 *
 * <b>Used Global Variables</b><br>
 *   - <var>$adminConfig</var> the administrator-settings config (included in the {@link general.include.php})
 *   - <var>$statisticConfig</var> the statistic config (included in the {@link general.include.php})
 *
 *
 * @param string $task     a description of the task which was performed
 * @param string $object   (optional) the page name or the name of the object on which the task was performed
 *
 *
 * @return bool
 *
 * @static
 * @version 1.1
 * <br>
 * <b>ChangeLog</b><br>
 *    - 1.1 moved tobackend functions again
 *    - 1.0 initial release
 *
 */
function saveActivityLog($task, $object = false) {

  $maxEntries = $GLOBALS['statisticConfig']['number']['taskLog'];
  $logFilePath = dirname(__FILE__).'/../../'.'statistics/activity.statistic.log';
  $oldLog = false;

  if($logFile = @fopen($logFilePath,"r")) {
    flock($logFile,LOCK_SH);
    if(is_file($logFilePath))
      $oldLog = @file($logFilePath);
    flock($logFile,LOCK_UN);
    fclose($logFile);
  }


  // adds the Object
  $object = ($object) ? '|#|'.$object : false;

  // -> create the new log string
  $newLog = time().'|#|'.$_SESSION['feinduraSession']['login']['user'].'|#|'.serialize($task).$object;

  // CREATE file content
  $fileContent = '';
  $fileContent .= $newLog."\n";
  $count = 2;
  if(is_array($oldLog)) {
    foreach($oldLog as $oldLogRow) {
      $fileContent .= $oldLogRow;
      // stops the log after 120 entries
      if($count == $maxEntries)
        break;
      $count++;
    }
  }

  // -> write file
  if(file_put_contents($logFilePath, $fileContent, LOCK_EX)) {
    // -> add permissions on the first creation
    if(!$oldLog) @chmod($logFilePath, $GLOBALS['adminConfig']['permissions']);

    return true;
  } else
    return false;
}

/**
* <b>Name</b> saveSitemap()<br>
*
* Saves a sitemap xml file (see http://www.sitemaps.org).
*
* <b>Used Global Variables</b><br>
*    - <var>$adminConfig</var> the administrator-settings config (included in the {@link general.include.php})
*    - <var>$categoryConfig</var> the categories-settings config (included in the {@link general.include.php})
*    - <var>$websiteConfig</var> the website-settings config (included in the {@link general.include.php})
*
* @param bool $force (optional) When its true, it will save the sitemaps, even if the generation of sitemap files is deactivated.
*
* @return bool whether the saving of the sitemap was done or not
*
* @link http://www.sitemaps.org
* @version 0.5
* <br>
* <b>ChangeLog</b><br>
*    - 0.5 add frequency detection, using the previousPage versions lastSaveDate
*    - 0.4 changed modification time to "daily"
*    - 0.3 moved to backend.functions.php
*    - 0.2 return false if the real website path, couldn't be resolved
*    - 0.1 initial release
*
*/
function saveSitemap($force = false) {

  if(!$GLOBALS['websiteConfig']['sitemapFiles'] && $force === false)
    return false;

  // vars
  $websitePath = GeneralFunctions::getDirname($GLOBALS['adminConfig']['websitePath']);
  $websitePath = (empty($websitePath)) ? '/': $websitePath;
  $realWebsitePath = GeneralFunctions::getRealPath($websitePath);
  if($realWebsitePath == '/')
    return false;
  $baseUrl = $GLOBALS['adminConfig']['url'].GeneralFunctions::Path2URI($websitePath);

  // get the Sitemap class
  require_once(dirname(__FILE__).'/../thirdparty/PHP/Sitemap.php');

  // vars
  $sitemapPages = GeneralFunctions::loadPages(true);

  // ->> START sitemap
  $sitemap = new Sitemap($baseUrl,$realWebsitePath.'/',false); // not compressed
  $sitemap->showError = false;
  $sitemap->filePermissions = $GLOBALS['adminConfig']['permissions'];
  $sitemap->page('pages');

  // ->> adds the sitemap ENTRIES
  foreach($sitemapPages as $pageContent) {

    $changeFreq = 'never';
    $priority = '1.0';

    // FIND THE RIGHT FREQUENCY
    if($previousPage = GeneralFunctions::readPage($pageContent['id'],$pageContent['category'],true)) {
      $daysInBetween = $pageContent['lastSaveDate'] - $previousPage['lastSaveDate'];
      $daysInBetween = abs(round($daysInBetween / 60 / 60 / 24,3));

      if($daysInBetween >= 365) {
        $changeFreq = 'yearly';
        $priority = '0.3';
      } elseif($daysInBetween >= 30) {
        $changeFreq = 'monthly';
        $priority = '0.6';
      } elseif($daysInBetween >= 7) {
        $changeFreq = 'weekly';
        $priority = '0.8';
      } elseif($daysInBetween >= 2) {
        $changeFreq = 'daily';
        $priority = '0.9';
      } elseif($daysInBetween < 1) {
        $changeFreq = 'hourly';
        $priority = '1.0';
      }
    }

    // ->> if category is deactivated jump to the next item in the foreach loop
    if($pageContent['category'] != 0 && !$GLOBALS['categoryConfig'][$pageContent['category']]['public'])
      continue;

    if($pageContent['public']) {
      // generate page link
      $link = GeneralFunctions::createHref($pageContent,false,$GLOBALS['websiteConfig']['multiLanguageWebsite']['mainLanguage'],true);
      // add page to sitemap
      $sitemap->url($link, GeneralFunctions::getDateTimeValue($pageContent['lastSaveDate']), $changeFreq, $priority);
    }
  }

  $sitemap->close();
  unset ($sitemap);
  return true;
}

/**
 * <b>Name</b> clearFeeds()<br>
 *
 * Deletes all the Atom and RSS 2.0 Feeds for all category.
 *
 * <b>Used Global Variables</b><br>
 *    - <var>$adminConfig</var> the administrator-settings config (included in the {@link general.include.php})
 *    - <var>$categoryConfig</var> the categories-settings config (included in the {@link general.include.php})
 *    - <var>$websiteConfig</var> the website-settings config (included in the {@link general.include.php})
 *
 *
 * @version 0.1
 * <br>
 * <b>ChangeLog</b><br>
 *    - 0.1 initial release
 *
 */
function clearFeeds() {

    // ->> DELETE ALL OLD Feeds
    if(is_array($category) || $category === true) {
      if($category === true) {
        $category = array_keys($GLOBALS['categoryConfig']);
        array_push($category,0); // add non-category
      }
      foreach ($category as $catId) {
        $atomFileName = ($catId == 0)
          ? dirname(__FILE__).'/../../pages/atom*.xml'
          : dirname(__FILE__).'/../../pages/'.$catId.'/atom*.xml';
        $rss2FileName = ($catId == 0)
          ? dirname(__FILE__).'/../../pages/rss2*.xml'
          : dirname(__FILE__).'/../../pages/'.$catId.'/rss2*.xml';

        if(is_file($atomFileName)) unlink($atomFileName);
        if(is_file($rss2FileName)) unlink($rss2FileName);
      }
    } elseif($category === false) {
      $atomFileName = ($catId == 0)
        ? dirname(__FILE__).'/../../pages/atom*.xml'
        : dirname(__FILE__).'/../../pages/'.$catId.'/atom*.xml';
      $rss2FileName = ($catId == 0)
        ? dirname(__FILE__).'/../../pages/rss2*.xml'
        : dirname(__FILE__).'/../../pages/'.$catId.'/rss2*.xml';

      if(is_file($atomFileName)) unlink($atomFileName);
      if(is_file($rss2FileName)) unlink($rss2FileName);
    }

}

/**
 * <b>Name</b> saveFeeds()<br>
 *
 * Saves an Atom and RSS 2.0 Feed for the given category.
 *
 * <b>Used Global Variables</b><br>
 *    - <var>$adminConfig</var> the administrator-settings config (included in the {@link general.include.php})
 *    - <var>$categoryConfig</var> the categories-settings config (included in the {@link general.include.php})
 *    - <var>$websiteConfig</var> the website-settings config (included in the {@link general.include.php})
 *
 * @param string $category the category of which feeds should be created, must be an ID number
 *
 *  @return bool whether the saving of the feeds succeed or not
 *
 *
 * @version 0.4
 * <br>
 * <b>ChangeLog</b><br>
 *    - 0.4 removes all feed files before saving the new ones
 *    - 0.3 moved to backend.functions.php
 *    - 0.2 add multilanguage website, creating multiple feeds
 *    - 0.1 initial release
 *
 */
function saveFeeds($category) {

  if(!is_numeric($category))
    return;

  // vars
  $return = false;
  $languages = ($GLOBALS['websiteConfig']['multiLanguageWebsite']['active'])
    ? $GLOBALS['websiteConfig']['multiLanguageWebsite']['languages']
    : array(0 => 0);

  // get the FeedWriter class
  require_once(dirname(__FILE__).'/../thirdparty/FeedWriter/FeedWriter.php');


  foreach ($languages as $langCode) {

    $addLanguageToFilename = (!empty($langCode)) ? '.'.$langCode : '';

    // vars
    $atomFileName = ($category == 0)
      ? dirname(__FILE__).'/../../pages/atom'.$addLanguageToFilename.'.xml'
      : dirname(__FILE__).'/../../pages/'.$category.'/atom'.$addLanguageToFilename.'.xml';
    $rss2FileName = ($category == 0)
      ? dirname(__FILE__).'/../../pages/rss2'.$addLanguageToFilename.'.xml'
      : dirname(__FILE__).'/../../pages/'.$category.'/rss2'.$addLanguageToFilename.'.xml';

    // DELETE OLD FILES
    if(is_file($atomFileName)) unlink($atomFileName);
    if(is_file($rss2FileName)) unlink($rss2FileName);

    // QUIT IF feeds are DEACTIVATED for that category, (but after they are deleted)
    if(!$GLOBALS['categoryConfig'][$category]['feeds'])
      continue;


    $feedsPages = GeneralFunctions::loadPages($category);
    $channelTitle = ($category == 0)
      ? GeneralFunctions::getLocalized($GLOBALS['websiteConfig'],'title',$langCode)
      : GeneralFunctions::getLocalized($GLOBALS['categoryConfig'][$category],'name',$langCode).' | '.GeneralFunctions::getLocalized($GLOBALS['websiteConfig'],'title',$langCode);

    // ->> START feeds
    $atom = new FeedWriter(ATOM);
    $rss2 = new FeedWriter(RSS2);

    // ->> CHANNEL
    // -> ATOM
    $atom->setTitle($channelTitle);
    $atom->setLink($GLOBALS['adminConfig']['url']);
    $atom->setChannelElement('updated', date(DATE_ATOM , time()));
    $atom->setChannelElement('author', array('name'=>GeneralFunctions::getLocalized($GLOBALS['websiteConfig'],'publisher',$langCode)));
    $atom->setChannelElement('rights', GeneralFunctions::getLocalized($GLOBALS['websiteConfig'],'copyright',$langCode));
    $atom->setChannelElement('generator', 'feindura - flat file cms',array('uri'=>'http://feindura.org','version'=>VERSION));

    // -> RSS2
    $rss2->setTitle($channelTitle);
    $rss2->setLink($GLOBALS['adminConfig']['url']);
    $rss2->setDescription(GeneralFunctions::getLocalized($GLOBALS['websiteConfig'],'description',$langCode));
    //$rss2->setChannelElement('language', 'en-us');
    $rss2->setChannelElement('pubDate', date(DATE_RSS, time()));
    $rss2->setChannelElement('copyright', GeneralFunctions::getLocalized($GLOBALS['websiteConfig'],'copyright',$langCode));

    // ->> adds the feed ENTRIES/ITEMS
    if($GLOBALS['categoryConfig'][$category]['public']) {
      foreach($feedsPages as $feedsPage) {

        if($feedsPage['public']) {

          // shows the page link
          $link = GeneralFunctions::createHref($feedsPage,false,$langCode,true);
          $title = strip_tags(GeneralFunctions::getLocalized($feedsPage,'title',$langCode));
          $description = GeneralFunctions::getLocalized($feedsPage,'description',$langCode);

          $thumbnail = (!empty($feedsPage['thumbnail'])) ? '<img src="'.$GLOBALS['adminConfig']['url'].GeneralFunctions::Path2URI(dirname(__FILE__).'/../../upload/thumbnails/').$feedsPage['thumbnail'].'"><br>': '';

          $content = GeneralFunctions::replaceLinks(GeneralFunctions::getLocalized($feedsPage,'content',$langCode),false,$langCode,true);
          $content = GeneralFunctions::replaceSnippets($content,$feedsPage['id']); // Has to create a new Feindura class instance inside
          $content = preg_replace('#<script\b[^>]*>[\s\S]*?<\/script>#i', '', $content); // remove script tags
          $content = GeneralFunctions::htmLawed($content,array(
            'comment'=> 1,
            'cdata'=> 1,
            'safe'=> 1
          ));
          $content = strip_tags($content,'<h1><h2><h3><h4><h5><h6><p><ul><ol><li><br><a><b><i><em><s><u><strong><small><span><img><table><tr><td><thead><tbody><object>');
          // $content = preg_replace('#<h[0-6]>#','<strong>',$content);
          // $content = preg_replace('#</h[0-6]>#','</strong><br>',$content);

          // ATOM
          $atomItem = $atom->createNewItem();
          $atomItem->setTitle($title);
          $atomItem->setLink($link);
          $atomItem->setDate($feedsPage['lastSaveDate']);
          $atomItem->addElement('content',$thumbnail.$content,array('src'=>$link));

          // RSS2
          $rssItem = $rss2->createNewItem();
          $rssItem->setTitle($title);
          $rssItem->setLink($link);
          $rssItem->setDate($feedsPage['lastSaveDate']);
          $rssItem->addElement('guid', $link,array('isPermaLink'=>'true'));

          // BOTH
          if(empty($description)) {
            //$atomItem->setDescription($thumbnail.GeneralFunctions::shortenString(strip_tags($content),450)); // dont create Atom description when, there is already an content tag
            $rssItem->setDescription($thumbnail.GeneralFunctions::shortenString(strip_tags($content),450));
          } else {
            $atomItem->setDescription($thumbnail.$description);
            $rssItem->setDescription($thumbnail.$description);
          }

          //Now add the feeds item
          $atom->addItem($atomItem);
          //Now add the feeds item
          $rss2->addItem($rssItem);
        }
      }
    }

    require_once(dirname(__FILE__).'/../thirdparty/PHP/Encoding.php');

    // -> SAVE
    if(file_put_contents($atomFileName,Encoding::toUTF8($atom->generateFeed()),LOCK_EX) !== false &&
       file_put_contents($rss2FileName,Encoding::toUTF8($rss2->generateFeed()),LOCK_EX) !== false) {
      @chmod($atomFileName, $GLOBALS['adminConfig']['permissions']);
      @chmod($rss2FileName, $GLOBALS['adminConfig']['permissions']);
      $return = true;
    } else
      $return = false;

  }
  return $return;
}

/**
 * <b>Name</b> generateBackupFileName()<br>
 *
 * Generates the backup file name like:
 *
 * <samp>
 * feinduraBackup_localhost_2010-11-17_17-36.zip
 * </samp>
 *
 * <b>Used Global Variables</b><br>
 *    - <var>$adminConfig</var> the administrator-settings config (included in the {@link general.include.php})
 *
 * @param string $backupAppendix (optional) a name which will be appended to the backup file name
 *
 * @return string the generated backup file name with full path
 *
 *
 * @version 1.0
 * <br>
 * <b>ChangeLog</b><br>
 *    - 1.0 initial release
 *
 */
function generateBackupFileName($backupAppendix = false) {

  $backupAppendix = ($backupAppendix) ? '_'.$backupAppendix : '';
  $websitePath = GeneralFunctions::getDirname($GLOBALS['adminConfig']['websitePath']);
  $websitePath = str_replace(array('/',"\\"),'-',$websitePath);
  $websitePath = ($websitePath != '-') ? substr($websitePath,0,-1) : '';
  $backupName = 'feinduraBackup_'.$_SERVER['SERVER_NAME'].$websitePath.'_'.date('Y-m-d_H-i').'_build'.BUILD.$backupAppendix.'.zip';
  $backupFileName = dirname(__FILE__).'/../../backups/'.$backupName;

  return $backupFileName;
}

/**
 * <b>Name</b> createBackup()<br>
 *
 * Creates a backup file from the "config", "statistic" and "pages" folder.
 *
 * <b>Used Global Variables</b><br>
 *    - <var>$adminConfig</var> the administrator-settings config (included in the {@link general.include.php})
 *
 * @param string $backupFileName the full path of the new backup file
 *
 * @return true|string TRUE if the creation of a backup zip was successfull, otherwise a string with the error warning
 *
 *
 * @version 1.0
 * <br>
 * <b>ChangeLog</b><br>
 *    - 1.0 initial release
 *
 */
function createBackup($backupFile) {

  // -> generate archive
  require_once(dirname(__FILE__).'/../thirdparty/PHP/pclzip.lib.php');
  $archive = new PclZip($backupFile);
  $catchError = $archive->add('config/,statistics/,pages/',PCLZIP_OPT_REMOVE_PATH, $GLOBALS['adminConfig']['realBasePath']);//,PCLZIP_OPT_SET_CHMOD,$GLOBALS['adminConfig']['permissions']);

  if($catchError == 0)
    return $archive->errorInfo(true);
  else {
    @chmod($backupFile, $GLOBALS['adminConfig']['permissions']);
    return true;
  }
}

/**
 * <b>Name</b> prepareStyleFilePaths()<br>
 *
 * Check the array with stylesheet file paths, whether they have a slash on the beginnging and that they are not empty.
 * If slash is missing, it adds one and return the serialized the array as string.
 *
 * If the $givenStyleFiles parameter is already a string it passes it trough.
 *
 * @param array $givenStyleFiles the array with stylesheetfile paths
 *
 * @return string the checked stylesheet files path as serialized array
 *
 *
 * @version 1.2
 * <br>
 * <b>ChangeLog</b><br>
 *    - 1.2 add GeneralFunctions::URI2Path()
 *    - 1.1 add XssFilter test
 *    - 1.0 initial release
 *
 */
function prepareStyleFilePaths($givenStyleFiles) {

  //vars
  $styleFiles = array();

  if(is_string($givenStyleFiles))
    return $givenStyleFiles;

  if(is_array($givenStyleFiles)) {
    foreach($givenStyleFiles as $styleFile) {
      // ** adds a "/" on the beginning of all absolute paths
      if(!empty($styleFile) && !strstr($styleFile,'://') && substr($styleFile,0,1) !== '/')
          $styleFile = '/'.$styleFile;

      if(strstr($styleFile,'://'))
        $styleFile = XssFilter::url($styleFile);
      else
        $styleFile = GeneralFunctions::URI2Path(XssFilter::path($styleFile));

      // adds back to the string only if its not empty
      if(!empty($styleFile))
        $styleFiles[] = $styleFile;
    }
  }
  return serialize($styleFiles);
}

/**
 * <b>Name</b> setStylesByPriority()<br>
 *
 * Bubbles through the stylesheet-file path, ID or class-attribute
 * of the page, category and adminSetup and check if the stylesheet-file path, ID or class-attribute already exist.
 * If the <var>$givenStyle</var> parameter is empty,
 * it check if the category has a styleheet-file path, ID or class-attribute set return the value if not return the value from the {@link $adminConfig administartor-settings config}.
 *
 * <b>Used Global Variables</b><br>
 *    - <var>$adminConfig</var> the administrator-settings config (included in the {@link general.include.php})
 *    - <var>$categoryConfig</var> the categories-settings config (included in the {@link general.include.php})
 *
 * @param string   $givenStyle    the string with the stylesheet-file path, id or class
 * @param string   $styleType     the key for the $pageContent, $categoryConfig or $adminConfig array can be "styleFile", "styleId" or "styleClass"
 * @param int|true $category      the ID of the category to bubble through
 * @param bool     $saveCategory  (optional) TRUE when the $givenStyle is from a category
 *
 * @return string an empty string or the $givenStyle parameter if it was not found through while bubbleing up
 *
 *
 * @version 1.1
 * <br>
 * <b>ChangeLog</b><br>
 *    - 1.1 moved adminConfig styles to categoryConfig[0]
 *    - 1.0 initial release
 *
 */
function setStylesByPriority($givenStyle,$styleType,$category,$saveCategory = false) {

  // prepare string
  if($styleType != 'styleFile')
    $givenStyle = str_replace(array('#','.'),'',$givenStyle);
  elseif($styleType == 'styleFile' && !empty($givenStyle) && substr($givenStyle,0,2) !== 'a:' &&substr($givenStyle,0,1) !== '/')
    $givenStyle = '/'.$givenStyle;

  // IS NON CATEGORY
  if($saveCategory && $category == 0) {
    return $givenStyle;

  // COMPARE string with CATEGORY STYLES
  } elseif($saveCategory === false &&
     (!empty($GLOBALS['categoryConfig'][$category][$styleType]) || $GLOBALS['categoryConfig'][$category][$styleType] != 'a:0:{}') &&
     $givenStyle == $GLOBALS['categoryConfig'][$category][$styleType]) {
    return '';

  //  COMPARE with HTML-EDITOR STYLES (non-category styles)
  } elseif($givenStyle == $GLOBALS['categoryConfig'][0][$styleType]) {
    return '';
  } else
    return $givenStyle;
}

/**
 * <b>Name</b> getStylesByPriority()<br>
 *
 * Returns the right stylesheet-file path, ID or class-attribute.
 * If the <var>$givenStyle</var> parameter is empty,
 * it check if the category has a styleheet-file path, ID or class-attribute set return the value if not return the value from the {@link $adminConfig administartor-settings config}.
 *
 * <b>Used Global Variables</b><br>
 *    - <var>$adminConfig</var> the administrator-settings config (included in the {@link general.include.php})
 *    - <var>$categoryConfig</var> the categories-settings config (included in the {@link general.include.php})
 *
 * @param string $givenStyle the string with the stylesheet-file path, id or class
 * @param string $styleType  the key for the $pageContent, {@link $categoryConfig} or {@link $adminConfig} array can be "styleFile", "styleId" or "styleClass"
 * @param int    $category   the ID of the category to bubble through
 *
 * @return string the right stylesheet-file, ID or class
 *
 * @static
 * @version 1.1
 * <br>
 * <b>ChangeLog</b><br>
 *    - 1.1 moved back to backend.functions.php
 *    - 1.0.1 moved to GeneralFunctions class
 *    - 1.0 initial release
 *
 */
function getStylesByPriority($givenStyle,$styleType,$category) {

  // check if the $givenStyle is empty
  if(empty($givenStyle) || $givenStyle == 'a:0:{}') {

    return (empty($GLOBALS['categoryConfig'][$category][$styleType]) || $GLOBALS['categoryConfig'][$category][$styleType] == 'a:0:{}')
      ? $GLOBALS['categoryConfig'][0][$styleType]
      : $GLOBALS['categoryConfig'][$category][$styleType];

  // OTHERWISE it pass returns the $givenStyle parameter
  } else
    return $givenStyle;

}

/**
 * <b>Name</b> showStyleFileInputs()<br>
 *
 * Lists the styleFile inputs from a given styleFile data-string.
 *
 *
 * @param string   $styleFiles the string with the stylesheet-file path, id or class
 * @param string   $inputNames  the key for the $pageContent, $categoryConfig or $adminConfig array can be "styleFile", "styleId" or "styleClass"
 *
 * @return string the style File inputs
 *
 *
 * @version 1.0
 * <br>
 * <b>ChangeLog</b><br>
 *    - 1.0 initial release
 *
 */
function showStyleFileInputs($styleFiles,$inputNames) {

  // var
  $return = false;

  if(!empty($styleFiles) &&
     $styleFiles != 'a:0:{}' &&
     ($styleFileInputs = unserialize($styleFiles)) !== false) {
    foreach($styleFileInputs as $styleFileInput) {
      $return .= '<input type="text" name="'.$inputNames.'[]" value="'.$styleFileInput.'" class="input-xlarge toolTipRight" title="'.$GLOBALS['langFile']['PATHS_TOOLTIP_ABSOLUTE'].'"><br>';
    }
  } else
    $return = '<input type="text" name="'.$inputNames.'[]" value="" class="noResize input-xlarge toolTipRight" title="'.$GLOBALS['langFile']['PATHS_TOOLTIP_ABSOLUTE'].'"><br>';

  // return the result
  return $return;
}

/**
 * <b>Name</b> showPageToolTip()<br>
 *
 * Generates the toolTip for a page.
 *
 * <b>Used Global Variables</b><br>
 *    - <var>$websiteConfig</var> the website-settings config (included in the {@link general.include.php})
 *    - <var>$languageNames</var> an array with country codes and language names (included in the {@link general.include.php})
 *    - <var>$categoryConfig</var> the categories-settings config (included in the {@link general.include.php})
 *    - <var>$userConfig</var> the user-settings config (included in the {@link general.include.php})
 *    - <var>$langFile</var> the language file of the backend (included in the {@link general.include.php})
 *
 * @param array $pageContent the $pageContent array of a page
 *
 * @uses GeneralFunctions::showPageDate()         to format the unix timstamp into the right date format
 *
 * @return string the tooltip ready to be put inside a title="..." attribute
 *
 * @version 1.0
 * <br>
 * <b>ChangeLog</b><br>
 *    - 1.0 initial release
 *
 */
function showPageToolTip($pageContent) {

  // vars
  $pageTitle_pageDate      = '';
  $pageTitle_tags          = '';
  $pageTitle_pageLanguages = '';
  $pageTitle_startPageText = '';
  $pageTitle_lastSaveDate  = '';

  $pageTitle_title = str_replace(array('[',']','<','>','"'),array('(',')','(',')','&quot;'),strip_tags(GeneralFunctions::getLocalized($pageContent,'title'))).'::';

  // -> startpage icon before the name
  if($pageContent['id'] == $GLOBALS['websiteConfig']['startPage']) {
    $pageTitle_startPageText = $GLOBALS['langFile']['SORTABLEPAGELIST_functions_startPage_set'].'[br]';
  }

  // -> show page ID
  // $pageTitle_Id = (GeneralFunctions::isAdmin())
  //   ? '[strong]ID[/strong] '.$pageContent['id'].'[br]'
  //   : '';
  $pageTitle_Id = '[strong]ID[/strong] '.$pageContent['id'].'[br]';

  // -> show lastSaveDate
  $pageTitle_lastSaveDate = GeneralFunctions::dateDayBeforeAfter($pageContent['lastSaveDate'],$GLOBALS['langFile']).' '.formatTime($pageContent['lastSaveDate']);
  $pageTitle_lastSaveDate = ($pageContent['lastSaveAuthor'])
    ? '[strong]'.$GLOBALS['langFile']['SORTABLEPAGELIST_TIP_LASTEDIT'].'[/strong][br]'.$pageTitle_lastSaveDate.' ('.$GLOBALS['userConfig'][$pageContent['lastSaveAuthor']]['username'].')[br][br]'
    : '[strong]'.$GLOBALS['langFile']['SORTABLEPAGELIST_TIP_LASTEDIT'].'[/strong][br]'.$pageTitle_lastSaveDate.'[br][br]';


  // -> show subcategory in toolTip
  $pageTitle_subCategory = ($pageContent['subCategory'] && $GLOBALS['categoryConfig'][$pageContent['category']]['showSubCategory'])
    ? '[strong]'.$GLOBALS['langFile']['EDITOR_TEXT_SUBCATEGORY'].'[/strong][br][img src=library/images/icons/categoryIcon_subCategory_small.png style=position:relative;margin-bottom:-10px;] '.GeneralFunctions::getLocalized($GLOBALS['categoryConfig'][$pageContent['subCategory']],'name').'[br]'
    : '';

  // -> generate pageDate for toolTip
  if($pageDate = GeneralFunctions::showPageDate($pageContent)) {
    $pageTitle_pageDate = '[strong]'.$GLOBALS['langFile']['SORTABLEPAGELIST_TIP_PAGEDATE'].':[/strong][br]'.$pageDate.'[br]';
  } elseif($GLOBALS['categoryConfig'][$pageContent['category']]['showPageDate'])
    $pageTitle_pageDate = '[strong]'.$GLOBALS['langFile']['SORTABLEPAGELIST_TIP_PAGEDATE'].':[/strong][br][span class=red]'.$GLOBALS['langFile']['EDITOR_PAGESETTINGS_NOPAGEDATE'].'[/span][br]';

  // -> generate tags for toolTip
  $localizedTags = GeneralFunctions::getLocalized($pageContent,'tags');
  if(!empty($localizedTags) && $GLOBALS['categoryConfig'][$pageContent['category']]['showTags']) {
    $pageTitle_tags = '[strong]'.$GLOBALS['langFile']['SORTABLEPAGELIST_TIP_TAGS'].'[/strong][br]'.$localizedTags.'[br]';
  }

  // -> generate page languages for toolTip
  if(!isset($pageContent['localized'][0])) {
    $pageTitle_pageLanguages .= '[strong]'.$GLOBALS['langFile']['SORTABLEPAGELIST_TIP_LOCALIZATION'].'[/strong][br]';
    if(is_array($pageContent['localized'][0])) {
      foreach ($pageContent['localized'] as $langCode => $values) {
        $pageTitle_pageLanguages .= '[img src='.GeneralFunctions::getFlagSrc($langCode).' class=flag] '.$GLOBALS['languageNames'][$langCode].'[br]';
      }
    }
    // list not yet existing languages of the page (also in listPages.php)
    if(is_array($GLOBALS['websiteConfig']['multiLanguageWebsite']['languages'])) {
      foreach($GLOBALS['websiteConfig']['multiLanguageWebsite']['languages'] as $langCode) {
        if(!isset($pageContent['localized'][$langCode])) {
          $pageTitle_pageLanguages .= '[img src='.GeneralFunctions::getFlagSrc($langCode).' class=flag] [span class=gray][s]'.$GLOBALS['languageNames'][$langCode].'[/s][/span][br]';
          $missingLanguages .= '[img src='.GeneralFunctions::getFlagSrc($langCode).' class=flag] '.$GLOBALS['languageNames'][$langCode].'[br]';
        }
      }
    }
  }

  $return = trim(' '.$pageTitle_title.$pageTitle_startPageText.$pageTitle_Id.$pageTitle_lastSaveDate.$pageTitle_pageDate.$pageTitle_tags.$pageTitle_subCategory.$pageTitle_pageLanguages,'[br]');
  return str_replace(array('<','>','"'),array('[',']',"'"),$return);
}

/**
 * <b>Name</b> showVisitTime()<br>
 *
 * Converts a given time into "12 Seconds", "01:15 Minutes" or "01:30:20 Hours".
 *
 * <b>Used Global Variables</b><br>
 *    - <var>$langFile</var> the backend language-file (included in the {@link general.include.php})
 *
 * @param string $time     the time in the following format: "HH:MM:SS"
 *
 * @return string the formated time
 *
 * @static
 * @version 1.1
 * <br>
 * <b>ChangeLog</b><br>
 *    - 1.1 moved to backend.functions.php
 *    - 1.0 initial release
 *
 */
function showVisitTime($time) {

  // change seconds to the following format: hh:mm:ss
  $time = secToTime($time);

  $hour = substr($time,0,2);
  $minute = substr($time,3,2);
  $second = substr($time,6,2);

  // adds the text for the HOURs
  if($hour == 0)
      $hour = false;
  // adds the text for the MINUTEs
  if($minute == 0)
      $minute = false;
  // adds the text for the SECONDs
  if($second == 0)
      $second = false;

  // 01:01:01 Stunden
  if($hour !== false && $minute !== false && $second !== false)
      $printTime = $hour.':'.$minute.':'.$second;
  // 01:01 Stunden
  elseif($hour !== false && $minute !== false && $second === false)
      $printTime = $hour.':'.$minute;
  // 01:01 Minuten
  elseif($hour === false && $minute !== false && $second !== false)
      $printTime = $minute.':'.$second;

  // 01 Stunden
  elseif($hour !== false && $minute === false && $second === false)
      $printTime = $hour;
  // 01 Minuten
  elseif($hour === false && $minute !== false && $second === false)
      $printTime = $minute;
  // 01 Sekunden
  elseif($hour === false && $minute === false && $second !== false)
      $printTime = $second;


  // get the time together
  if($hour) {
    if($hour == 1)
      $printTime = $printTime.' '.$GLOBALS['langFile']['STATISTICS_TEXT_HOUR_SINGULAR'].'';
    else
      $printTime = $printTime.' '.$GLOBALS['langFile']['STATISTICS_TEXT_HOUR_PLURAL'].'';
  } elseif($minute) {
    if($minute == 1)
      $printTime = $printTime.' '.$GLOBALS['langFile']['STATISTICS_TEXT_MINUTE_SINGULAR'].'';
    else
      $printTime = $printTime.' '.$GLOBALS['langFile']['STATISTICS_TEXT_MINUTE_PLURAL'].'';
  } elseif($second) {
    if($second == 1)
      $printTime = $printTime.' '.$GLOBALS['langFile']['STATISTICS_TEXT_SECOND_SINGULAR'].'';
    else
      $printTime = $printTime.' '.$GLOBALS['langFile']['STATISTICS_TEXT_SECOND_PLURAL'].'';
  }

  // RETURN formated time
  if($time != '00:00:00')
    return $printTime;
  else
    return false;
}

/**
 * <b>Name</b> secToTime()<br>
 *
 * Converts seconds into a readable time
 *
 * @return string the seconds in a readable time
 *
 * @static
 * @version 1.1
 * <br>
 * <b>ChangeLog</b><br>
 *    - 1.1 moved to backend.functions.php
 *    - 1.0 initial release
 *
 */
function secToTime($sec) {
  $hours = floor($sec / 3600);
  $mins = floor(($sec -= ($hours * 3600)) / 60);
  $seconds = floor($sec - ($mins * 60));

  // adds leading zeros
  if($hours < 10)
    $hours = '0'.$hours;
  if($mins < 10)
    $mins = '0'.$mins;
  if($seconds < 10)
    $seconds = '0'.$seconds;

  return $hours.':'.$mins.':'.$seconds;
}

/**
 * <b>Name</b> formatTime()<br>
 *
 * Converts a given timestamp into the following format "12:60" or "12:60:00", if the <var>$showSeconds</var> parameter is TRUE.
 *
 * @param int    $timeStamp      the given date with following format: "YYYY-MM-DD HH:MM:SS" or "HH:MM:SS"
 * @param bool   $showSeconds    (optional) whether seconds are shown in the time string
 *
 * @return string the formated time with or without seconds or the $timestamp parameter
 *
 * @static
 * @version 1.1
 * <br>
 * <b>ChangeLog</b><br>
 *    - 1.1 moved to backend.functions.php
 *    - 1.01 changed from date conversion to timestamp
 *    - 1.0 initial release
 *
 */
function formatTime($timeStamp,$showSeconds = false) {

  if(empty($timeStamp) || !preg_match('/^[0-9]{1,}$/',$timeStamp))
    return $timeStamp;

  return ($showSeconds)
    ? date('H:i:s',$timeStamp)
    : date('H:i',$timeStamp);
}

/**
 * <b>Name</b> formatHighNumber()<br>
 *
 * Seperates the thouseds in a number with whitespaces.
 *
 * Example
 * <samp>
 * 12 050 125
 * </samp>
 *
 * @param float $number          the number to convert
 * @param int   $decimalsNumber  (optional) the number of decimal places, like "1 250,25"
 *
 * @return float the converted number
 *
 * @static
 * @version 1.1
 * <br>
 * <b>ChangeLog</b><br>
 *    - 1.1 moved to backend.functions.php
 *    - 1.0 initial release
 *
 */
function formatHighNumber($number,$decimalsNumber = 0) {
  $number = floatval($number);
  return number_format($number, $decimalsNumber, ',', ' ');
}

/**
 * <b>Name</b> editFiles()<br>
 *
 * Generates a editable textfield with a file selection and a input for creating new files.
 *
 * <b>Used Constants</b><br>
 *    - <var>DOCUMENTROOT</var> the absolut path of the webserver
 *
 * <b>Used Global Variables</b><br>
 *    - <var>$_POST</var> to get which form is open
 *    - <var>$langFile</var> the backend language-file (included in the {@link general.include.php})
 *    - <var>$SAVEDFORM</var> the variable to tell which form was saved (set in the {@link saveEditedFiles})
 *
 * @param string    $filesPath           the absolute file system path to the files (also files in subfolders), which will be editable
 * @param string    $status              a status name which will be set to the $_GET['status'] variable in the formular action attribute
 * @param string    $titleText           a title text which will be displayed as the title of the edit files textfield
 * @param string    $anchorName          the name of the anchor which will be added to the formular action attribute
 * @param string|false    $fileType      (optional) a filetype which will be added to each ne created file
 * @param string|array|false  $excluded  (optional) a string (seperated with ",") or array with files or folder names which should be excluded from the file selection, if FALSE no file will be excluded
 *
 * @uses GeneralFunctions::readFolderRecursive()  reads the $filesPath folder recursive and loads all file paths in an array
 *
 * @return void displayes the file edit textfield
 *
 * @version 2.0
 * <br>
 * <b>ChangeLog</b><br>
 *    - 2.0 moved delete files in here; deletes now also empty folders of files which were deleted
 *    - 1.0.1 put fileType to the classe instead of the id of the textarea
 *    - 1.0 initial release
 *
 */
function editFiles($filesPath, $status, $titleText, $anchorName, $fileType = false, $excluded = false) {

  if(empty($filesPath))
    return;

  // var
  $fileTypeText = '';
  $fileType = str_replace('.', '', $fileType); // remove . from the given extension
  $isFiles = false;
  $_GET['file'] = XssFilter::path($_GET['file']);
  $filesPath = GeneralFunctions::getRealPath($filesPath);
  $filesPath = str_replace(DOCUMENTROOT,'',$filesPath);

  // GET current FILE
  if($_GET['status'] == $status)
    $editFile = $_GET['file'];
  else
    $editFile = false;

  // ->> DELETE FILE if delete status is given
  if($_GET['status'] == 'deleteEditFiles' && !empty($_GET['file'])) {
    if(@unlink(DOCUMENTROOT.$filesPath.$_GET['file'])) {

      // check if file was in a sub dir
      $editFileDir = dirname($_GET['file']);
      if(!empty($editFileDir) && $editFileDir !== '/' && $editFileDir !== '\\' && GeneralFunctions::readFolder(DOCUMENTROOT.$filesPath.$editFileDir) === false)
        // if empty delete it
        GeneralFunctions::deleteFolder(DOCUMENTROOT.$filesPath.$editFileDir);

      saveActivityLog(13,$filesPath.$_GET['file']); // <- SAVE the task in a LOG FILE
    } else
      $ERRORWINDOW .= $langFile['EDITFILESSETTINGS_ERROR_DELETEFILE'].' '.$filesPath.$_GET['file'];
  }


  // shows the block below if it is the ones which is saved before
  $hidden = ($_GET['status'] == $status || $GLOBALS['SAVEDFORM'] === $status) ? '' : ' hidden';

  echo '<form action="index.php?site='.$_GET['site'].'#'.$anchorName.'" method="post" enctype="multipart/form-data" accept-charset="UTF-8">
        <div>
          <input type="hidden" name="send" value="saveEditedFiles">
          <input type="hidden" name="status" value="'.$status.'">
          <input type="hidden" name="filesPath" value="'.$filesPath.'">';
          if($fileType)
            echo '<input type="hidden" name="fileType" value=".'.$fileType.'">';
  echo '</div>';

  echo '<a href="#" id="'.$anchorName.'" class="anchorTarget"></a>';

  echo '<div class="block'.$hidden.'">
          <h1><a href="#">'.$titleText.'</a></h1>
          <div class="content editFiles">';


  //echo $filesPath.'<br>';
  // gets the files out of the directory --------------
  // adds the DOCUMENTROOT
  $dir = DOCUMENTROOT.$filesPath;
  if(!empty($filesPath) && is_dir($dir)) {
    $files = GeneralFunctions::readFolderRecursive($filesPath);
    $files = $files['files'];

    // FILTER by EXTENSION
    if($files && $fileType) {
      $newFiles = array();

      foreach ($files as $file) {
        $ext = pathinfo($file, PATHINFO_EXTENSION);
        if($ext == $fileType)
          $newFiles[] = $file;
      }

      // set new files array to the old one
      $files = $newFiles;
    }

    // ->> EXLUDES files or folders
    if($files && $excluded !== false) {

      // -> is string convert to array
      if(is_string($excluded))
        $excluded = explode(',',$excluded);

      if(is_array($excluded)) {
        $newFiles = array();

        foreach($files as $file) {
          $foundToExclud = false;
          // looks if any of a excluded file is found
          foreach($excluded as $excl) {
            if(strpos($file,$excl) !== false)
              $foundToExclud = true;
          }

          // then exclud them
          if($foundToExclud === false)
            $newFiles[] = $file;
        }
        // set new files array to the old one
        $files = $newFiles;
      }
    }
    $isDir = true;

    // only if still are files left
    if(is_array($files) && !empty($files)) {
      $isFiles = true;
      // sort the files in a natural way (alphabetical)
      natsort($files);
    }
  // dont show files but show directory error
  } else {
    echo '<code>"'.$filesPath.'"</code> <b>'.$GLOBALS['langFile']['EDITFILESSETTINGS_TEXT_NODIR'].'</b>';
    $isDir = false;
  }

  // if no files was given, set the first one ine the list
  if(empty($editFile) && isset($files)) {
    $editFile = str_replace($filesPath,'',$files[0]);
  }

  echo '<div class="row">';


  // ->> CHECK DIR
  if($isDir) {


    // FILE SELECTION ------------------------------------
    if($isFiles && isset($files)) {

      echo '<div class="span5">';
        //<div class="editFiles left">
        echo '<h3>'.$GLOBALS['langFile']['EDITFILESSETTINGS_TEXT_CHOOSEFILE'].'</h3>
              <input type="text" value="'.$filesPath.'" readonly="readonly" style="width:auto;max-width:230px;" size="'.(strlen($filesPath)-2).'">'."\n";
        echo '<select onchange="changeEditFile(\''.$_GET['site'].'\',this.value,\''.$status.'\',\''.$anchorName.'\');">'."\n";

              // listet die Dateien aus dem Ordner als Mehrfachauswahl auf
              foreach($files as $cFile) {
                $onlyFile = substr($cFile, strlen($filesPath));
                // $onlyFile = substr($filesPath,'',$cFile);
                if($editFile == $onlyFile)
                  echo '<option value="'.$onlyFile.'" selected="selected">'.$onlyFile.'</option>'."\n";
                else
                  echo '<option value="'.$onlyFile.'">'.$onlyFile.'</option>'."\n";
              }
        echo '</select>';

      echo '</div>';

    // NO FILES
    } else {
      echo '<div class="span5">';
        echo '<h3>'.$GLOBALS['langFile']['EDITFILESSETTINGS_TEXT_NOFILE'].'</h3>';
      echo '</div>';
    }


    // create a NEW FILE ---------------------------------
    if($fileType)
      $fileTypeText = '<b>.'.$fileType.'</b>';

    echo '<div class="span3">';
      echo '<h3>'.$GLOBALS['langFile']['EDITFILESSETTINGS_TEXT_CREATEFILE'].'</h3>
            <input type="text" name="newFile" class="toolTipLeft" title="'.$GLOBALS['langFile']['EDITFILESSETTINGS_TEXT_CREATEFILE'].'::'.$GLOBALS['langFile']['EDITFILESSETTINGS_TIP_CREATEFILE'].'"> '.$fileTypeText;
    echo '</div>';
  }

  echo '</div>'; // end .row

  // OPEN THE FILE -------------------------------------
  if(@is_file(DOCUMENTROOT.$filesPath.$editFile)) {
    $editFileOpen = fopen(DOCUMENTROOT.$filesPath.$editFile,"r");
    $file = @fread($editFileOpen,filesize(DOCUMENTROOT.$filesPath.$editFile));
    fclose($editFileOpen);
    $file = str_replace(array('<','>'),array('&lt;','&gt;'),$file);

    echo '<input type="hidden" name="file" value="'.$editFile.'">'."\n";
    echo '<textarea name="fileContent" spellcheck="false" class="editFiles '.substr($filesPath.$editFile, strrpos($filesPath.$editFile, '.') + 1).'" id="editFiles'.uniqid().'">'.$file.'</textarea>';
  }

  // SAVE/DELETE BUTTONS
  if($isDir) {
    echo '<div class="spacer"></div>';
    echo '<div class="row">';
      echo '<div class="span4 center">';
          if($isFiles)
            echo '<a href="?site='.$_GET['site'].'&amp;status=deleteEditFiles&amp;editFilesStatus='.$status.'&amp;file='.$editFile.'#'.$anchorName.'" onclick="openWindowBox(\'library/views/windowBox/deleteEditFiles.php?site='.$_GET['site'].'&amp;status=deleteEditFiles&amp;editFilesStatus='.$status.'&amp;file='.$editFile.'&amp;anchorName='.$anchorName.'\',\''.$GLOBALS['langFile']['EDITFILESSETTINGS_TEXT_DELETEFILE'].'\');return false;" class="button cancel toolTipLeft" title="'.$GLOBALS['langFile']['EDITFILESSETTINGS_TEXT_DELETEFILE'].'::"></a>';
      echo '</div>';
      echo '<div class="span4 center">';
          echo '<input type="submit" value="" name="saveEditedFiles" class="button submit right" title="'.$GLOBALS['langFile']['FORM_BUTTON_SUBMIT'].'">';
      echo '</div>';
    echo '</div>';
  }
  echo '</div>
    </div>
    </form>';
}

/**
 * <b>Name</b> saveEditedFiles()<br>
 *
 * Save the files edited in {@link editFiles()}.
 *
 * <b>Used Constants</b><br>
 *    - <var>$_POST</var> for the file data
 *    - <var>DOCUMENTROOT</var> the absolut path of the webserver
 *
 * @param string &$SAVEDFORM  to set which form was is saved
 *
 * @return bool TRUE if the file was succesfull saved, otherwise FALSE
 *
 * @version 1.0.1
 * <br>
 * <b>ChangeLog</b><br>
 *    - 1.0.1 add XssFilter and removed htmlentities
 *    - 1.0 initial release
 *
 */
function saveEditedFiles(&$SAVEDFORM) {

  // var
  $_POST['filesPath'] = DOCUMENTROOT.str_replace(DOCUMENTROOT,'',$_POST['filesPath']);
  $_POST['file'] = XssFilter::path($_POST['file']);

  // ->> SAVE FILE
  if(@is_file($_POST['filesPath'].$_POST['file']) && empty($_POST['newFile'])) {

    // encode when ISO-8859-1
    if(mb_detect_encoding($_POST['fileContent']) == 'ISO-8859-1') $_POST['fileContent'] = utf8_encode($_POST['fileContent']);
    $_POST['fileContent'] = GeneralFunctions::smartStripslashes($_POST['fileContent']);
    $_POST['fileContent'] = preg_replace("#\\n#","",$_POST['fileContent']); // prevent double line breaks

    // -> SAVE
    if(file_put_contents($_POST['filesPath'].$_POST['file'],$_POST['fileContent'],LOCK_EX) !== false) {

      @chmod($_POST['filesPath'].$_POST['file'], $GLOBALS['adminConfig']['permissions']);
      $_GET['file'] = $_POST['file'];
      $_GET['status'] = $_POST['status'];
      $SAVEDFORM = $_POST['status'];

      saveActivityLog(12,$_GET['file']); // <- SAVE the task in a LOG FILE
      return true;
    } else
      return false;

  // ->> NEW FILE
  } elseif(!empty($_POST['newFile'])) { // creates a new file if a filename was input in the field

    // get extension, to add when filename is wrong to save and unnamed files
    $ext = (empty($_POST['fileType'])) ? '.'.pathinfo($_POST['newFile'], PATHINFO_EXTENSION) : $_POST['fileType'];

    $_POST['newFile'] = XssFilter::path($_POST['newFile'],false,'unnamed'.$ext);

    // check if a path is included
    if(strpos($_POST['newFile'],'/') !== false) {
      $directory = dirname($_POST['newFile']);
      $directory = preg_replace("/\/+/", '/', $_POST['filesPath'].'/'.dirname($_POST['newFile']));
      if(!is_dir($directory))
        mkdir($directory,$GLOBALS['adminConfig']['permissions'],true);
      $_POST['newFile'] = dirname($_POST['newFile']).'/'.GeneralFunctions::cleanSpecialChars(basename($_POST['newFile']),'-');
    } else {
      $_POST['newFile'] = GeneralFunctions::cleanSpecialChars($_POST['newFile'],'-');
    }

    $_POST['newFile'] = str_replace($_POST['fileType'],'',$_POST['newFile']);
    $fullFilePath = $_POST['filesPath'].'/'.$_POST['newFile'].$_POST['fileType'];
    $fullFilePath = preg_replace("/\/+/", '/', $fullFilePath);

    if($file = fopen($fullFilePath,"wb")) {

      @chmod($fullFilePath, $GLOBALS['adminConfig']['permissions']);
      $_GET['file'] = '/'.$_POST['newFile'].$_POST['fileType'];
      $_GET['status'] = $_POST['status'];
      $SAVEDFORM = $_POST['status'];

      fclose($file);
      saveActivityLog(12,$_GET['file']); // <- SAVE the task in a LOG FILE
      return true;
    } else
      return false;
  }
}

/**
 * <b>Name</b> isFolderWarning()<br>
 *
 * Check if the <var>$folder</var> parameter is a directory, otherwise it return a warning text.
 *
 *
 * <b>Used Global Variables</b><br>
 *    - <var>$langFile</var> the backend language-file (included in the {@link general.include.php})
 *
 * @param string $folder the absolut path of the folder to check
 *
 * @return string|false a warning text if it's not a directory, otherwise FALSE
 *
 * @version 1.0
 * <br>
 * <b>ChangeLog</b><br>
 *    - 1.0 initial release
 *
 */
function isFolderWarning($folder) {

  if(!GeneralFunctions::getRealPath($folder) && is_dir($folder) === false) {
      return '<span class="warning"><b>&quot;'.$folder.'&quot;</b> -> '.$GLOBALS['langFile']['ADMINSETUP_TEXT_ISFOLDERERROR'].'</span><br>';
  } else
    return false;
}

/**
 * <b>Name</b> isWritableWarning()<br>
 *
 * Check if a file/folder is writeable, otherwise it return a warning text.
 *
 * <b>Used Constants</b><br>
 *    - <var>DOCUMENTROOT</var> the absolut path of the webserver
 *
 * <b>Used Global Variables</b><br>
 *    - <var>$langFile</var> the backend language-file (included in the {@link general.include.php})
 *
 * @param string $fileFolder the absolut path of a file/folder to check
 *
 * @return string|false a warning text if it's not writable, otherwise FALSE
 *
 * @version 1.0
 * <br>
 * <b>ChangeLog</b><br>
 *    - 1.0 initial release
 *
 */
function isWritableWarning($fileFolder) {

  $filename = basename($fileFolder);
  $fileFolder = GeneralFunctions::getRealPath($fileFolder);

  // add the filename again
  if(is_file($fileFolder.'/'.$filename))
    $fileFolder = $fileFolder.'/'.$filename;

  if(file_exists($fileFolder) && is_writable($fileFolder) === false) {
    return '<span class="warning toolTipLeft" title="'.$fileFolder.'::'.sprintf($GLOBALS['langFile']['ADMINSETUP_TOOLTIP_WRITEACCESSERROR'],$GLOBALS['adminConfig']['permissions']).'"><b>&quot;'.$fileFolder.'&quot;</b> -> '.$GLOBALS['langFile']['ADMINSETUP_TEXT_WRITEACCESSERROR'].'</span><br>';
  } else
    return false;
}

/**
 * <b>Name</b> isWritableWarningRecursive()<br>
 *
 * Check if folders and it's containing files are writeable, otherwise it return a warning text.
 *
 * @param array $folders an array with absolut paths of folders to check
 *
 * @uses isFolderWarning()                        to check if the folder is a valid directory, if not return a warning
 * @uses isWritableWarning()                      to check every file/folder if it's writable, if not return a warning
 * @uses GeneralFunctions::readFolderRecursive()  to read all subfolders and files in a directory
 *
 * @return string|false warning texts if they are not writable, otherwise FALSE
 *
 * @version 1.0
 * <br>
 * <b>ChangeLog</b><br>
 *    - 1.0 initial release
 *
 */
function isWritableWarningRecursive($folders) {

  // var
  $return = false;

  foreach($folders as $folder) {
    if(!empty($folder)) {
      if($isFolder = isFolderWarning($folder)) {
        $return .= $isFolder;
      } else {
        $return .= isWritableWarning($folder);
        if(!$return && $readFolder = GeneralFunctions::readFolderRecursive($folder)) { // doesnt check folders deeper, which have a writable warning
          if(is_array($readFolder['folders'])) {
            foreach($readFolder['folders'] as $folder) {
              $return .= isWritableWarning($folder);
            }
          }
          if(is_array($readFolder['files'])) {
            foreach($readFolder['files'] as $files) {
              $return .= isWritableWarning($files);
            }
          }
        }
      }
    }
  }
  return $return;
}

/**
 * <b>Name</b> basicFilesAreWriteableWarning()<br>
 *
 * Checks if the basics config and other files are writeable.
 *
 *
 * @return string|true a warning or FALSE,
 *
 * @version 1.0
 * <br>
 * <b>ChangeLog</b><br>
 *    - 1.0 initial release
 *
 */
function basicFilesAreWriteableWarning() {

  // var
  $return = false;

  $checkFolders[] = dirname(__FILE__).'/../../config/';
  $checkFolders[] = dirname(__FILE__).'/../../statistics/';
  $checkFolders[] = dirname(__FILE__).'/../../pages/';
  $checkFolders[] = dirname(__FILE__).'/../../upload/';
  $checkFolders[] = $adminConfig['websiteFilesPath'];
  $checkFolders[] = $adminConfig['stylesheetPath'];

  // DOCUMENTROOT is set: gives the error OUTPUT if one of these files in unwriteable
  if(DOCUMENTROOT !== false && $unwriteableList = isWritableWarningRecursive($checkFolders)) {
    $return = '<div class="block alert warning">
      <h1>'.$GLOBALS['langFile']['ADMINSETUP_TITLE_ERROR'].'</h1>
      <div class="content">
        <p>'.$unwriteableList.'</p>
      </div>
    </div>';

  // DOCUMENTROOT is NOT set: show error if admin.config.php is not readable
  } elseif(DOCUMENTROOT === false && $unwriteableConfig = isWritableWarningRecursive(array($checkFolders[0]))) {
    $return = '<div class="block alert warning">
      <h1>'.$GLOBALS['langFile']['ADMINSETUP_TITLE_ERROR'].'</h1>
      <div class="content">
        <p>'.$unwriteableConfig.'</p>
      </div>
    </div>';
  }

  return $return;
}

/**
 * <b>Name</b> generateCurrentUrl()<br>
 *
 * Generates the current URL.
 *
 *
 * @return string the current url
 *
 * @version 1.0
 * <br>
 * <b>ChangeLog</b><br>
 *    - 1.0 initial release
 *
 */
function generateCurrentUrl() {
  $serverProtocol = strtolower(substr($_SERVER["SERVER_PROTOCOL"],0,strpos($_SERVER["SERVER_PROTOCOL"],'/')));//.((empty($_SERVER["HTTPS"])) ? '' : ($_SERVER["HTTPS"] == "on") ? "s" : "");
  $serverPort = ($_SERVER['SERVER_PORT'] == 80 || $_SERVER['SERVER_PORT'] == 443) ? '' : ':'.$_SERVER['SERVER_PORT'];
  return $serverProtocol."://".$_SERVER['SERVER_NAME'].$serverPort;
}

/**
 * <b>Name</b> checkBasePathAndURL()<br>
 *
 * Check if the current path of the CMS is matching the <var>$adminConfig['basePath']</var>
 * And if the current URL is matching the <var>$adminConfig['url']</var>.
 *
 * <b>Used Global Variables</b><br>
 *    - <var>$adminConfig</var> the administrator-settings config (included in the {@link general.include.php})
 *
 * @return bool TRUE if there are matching, otherwise FALSE
 *
 * @version 1.0
 * <br>
 * <b>ChangeLog</b><br>
 *    - 1.0 initial release
 *
 */
function checkBasePathAndURL() {
  $checkPath = GeneralFunctions::URI2Path(dirname($_SERVER['PHP_SELF'])).'/';

  if($GLOBALS['adminConfig']['basePath'] == $checkPath &&
     $GLOBALS['adminConfig']['url'] == generateCurrentUrl())
    return true;
  else
    return false;
}

/**
 * <b>Name</b> documentrootWarning()<br>
 *
 * Returns a warning if the DOCUMENTROOT couldn't be resolved automaticaly.
 *
 * <b>Used Global Variables</b><br>
 *    - <var>$adminConfig</var> the administrator-settings config (included in the {@link general.include.php})
 *    - <var>$langFile</var> the backend language-file (included in the {@link general.include.php})
 *
 *
 * @return string|false a warning if the basePath is wrong, otherwise FALSE
 *
 * @version 1.0
 * <br>
 * <b>ChangeLog</b><br>
 *    - 1.0 initial release
 *
 */
function documentrootWarning() {
  if(checkBasePathAndURL() && (empty($GLOBALS['adminConfig']['documentroot']) || !@is_dir($GLOBALS['adminConfig']['documentroot'])) && (DOCUMENTROOT === false)) {
    return '<div class="block alert warning">
            <h1>'.$GLOBALS['langFile']['WARNING_TITLE_DOCUMENTROOT'].'</h1>
            <div class="content">
              <p>'.$GLOBALS['langFile']['WARNING_TEXT_DOCUMENTROOT'].'</p><!-- need <p> tags for margin-left:..-->
            </div>
          </div>';
  } else
    return false;
}

/**
 * <b>Name</b> basePathWarning()<br>
 *
 * Returns a warning if the current path of the CMS and the current URL is not matching with the ones set in the <var>$adminConfig</var>.
 *
 * <b>Used Global Variables</b><br>
 *    - <var>$langFile</var> the backend language-file (included in the {@link general.include.php})
 *
 * @uses checkBasePathAndURL() to check if the current pathand URL are matching
 *
 * @return string|false a warning if the basePath is wrong, otherwise FALSE
 *
 * @version 1.0
 * <br>
 * <b>ChangeLog</b><br>
 *    - 1.0 initial release
 *
 */
function basePathWarning() {
  if(checkBasePathAndURL() === false) {
    return '<div class="block alert warning">
            <h1>'.$GLOBALS['langFile']['WARNING_TITLE_BASEPATH'].'</h1>
            <div class="content">
              <p>'.$GLOBALS['langFile']['WARNING_TEXT_BASEPATH'].'</p><!-- need <p> tags for margin-left:..-->
            </div>
          </div>';
  } else
    return false;
}

/**
 * <b>Name</b> startPageWarning()<br>
 *
 * Retruns a warning if the current set start page is existing.
 *
 * <b>Used Global Variables</b><br>
 *    - <var>$adminConfig</var> the administrator-settings config (included in the {@link general.include.php})
 *    - <var>$websiteConfig</var> the website-settings config (included in the {@link general.include.php})
 *    - <var>$GeneralFunctions</var> for the {@link GeneralFunctions::getPageCategory()} method (included in the {@link general.include.php})
 *    - <var>$langFile</var> the backend language-file (included in the {@link general.include.php})
 *
 * @uses GeneralFunctions::getPageCategory() to get the category of the start page
 *
 * @return string|false a warning if the start page doesn't exist, otherwise FALSE
 *
 * @version 1.0
 * <br>
 * <b>ChangeLog</b><br>
 *    - 1.0 initial release
 *
 */
function startPageWarning() {

  if(checkBasePathAndURL() === false || !is_dir(dirname(__FILE__).'/../../pages/'))
    return false;

  if(!empty($GLOBALS['websiteConfig']['startPage']) && ($startPageCategory = GeneralFunctions::getPageCategory($GLOBALS['websiteConfig']['startPage'])) != 0)
    $startPageCategory .= '/';
  else
    $startPageCategory = '';

  if(empty($GLOBALS['websiteConfig']['startPage']) || !file_exists(dirname(__FILE__).'/../../pages/'.$startPageCategory.$GLOBALS['websiteConfig']['startPage'].'.php')) {
    return '<div class="block alert info">
            <h1>'.$GLOBALS['langFile']['WARNING_TITLE_STARTPAGE'].'</h1>
            <div class="content">
              <p>'.$GLOBALS['langFile']['WARNING_TEXT_STARTPAGE'].'</p><!-- need <p> tags for margin-left:..-->
            </div>
          </div>';
  } else
    return false;
}

/**
 * <b>Name</b> missingLanguageWarning()<br>
 *
 * Retruns a warning if the <var>$categoryConfig</var> or <var>$websiteConfig</var> has missing languages.
 *
 * <b>Used Global Variables</b><br>
 *    - <var>$adminConfig</var> the administrator-settings config (included in the {@link general.include.php})
 *    - <var>$websiteConfig</var> the website-settings config (included in the {@link general.include.php})
 *    - <var>$languageNames</var> an array with country codes and language names (included in the {@link general.include.php})
 *    - <var>$categoryConfig</var> the categories-settings config (included in the {@link general.include.php})
 *    - <var>$langFile</var> the language file of the backend (included in the {@link general.include.php})
 *
 * @return string|false a warning if the there are still missing languages, otherwise FALSE
 *
 * @version 1.0
 * <br>
 * <b>ChangeLog</b><br>
 *    - 1.0 initial release
 *
 */
function missingLanguageWarning() {

  // var
  $return = false;

  if(!$GLOBALS['websiteConfig']['multiLanguageWebsite']['active'])
    return false;

  // -> websiteConfig
  $websiteConfig = '';
  if($GLOBALS['websiteConfig']['multiLanguageWebsite']['languages'] != array_keys($GLOBALS['websiteConfig']['localized'])) {
    foreach ($GLOBALS['websiteConfig']['multiLanguageWebsite']['languages'] as $langCode) {
      if(!isset($GLOBALS['websiteConfig']['localized'][$langCode])) {
        $websiteConfig .= '<span><img src="'.GeneralFunctions::getFlagSrc($langCode).'" class="flag"> <a href="?site=websiteSetup&amp;websiteLanguage='.$langCode.'" class="link gray">'.$GLOBALS['languageNames'][$langCode].'</a></span><br>';
      }
    }
  }

  // -> categoryConfig
  $categoryHasMissingLanguages = false;
    foreach ($GLOBALS['categoryConfig'] as $category) {
      if($category['id'] == 0)
          continue;
      $arrayDifferences = array_diff($GLOBALS['websiteConfig']['multiLanguageWebsite']['languages'],array_keys($category['localized']));
      if(!empty($arrayDifferences)) {
        $categoryHasMissingLanguages = true;
        break;
      }
    }
    if($categoryHasMissingLanguages) {
      foreach ($GLOBALS['websiteConfig']['multiLanguageWebsite']['languages'] as $langCode) {
        foreach ($GLOBALS['categoryConfig'] as $category) {
          if($category['id'] == 0)
            continue;
          if(!isset($category['localized'][$langCode])) {
            $categoryName = GeneralFunctions::getLocalized($category,'name');
            $categoryName = (!empty($categoryName)) ? ' &rArr; '.$categoryName : '';
            $categoryConfig .= '<span><img src="'.GeneralFunctions::getFlagSrc($langCode).'" class="flag"> '.$GLOBALS['languageNames'][$langCode].'<a href="?site=pageSetup&amp;websiteLanguage='.$langCode.'" class="link gray">'.$categoryName.'</a></span><br>';
          }
        }
      }
    }

  if(!empty($websiteConfig) || !empty($categoryConfig)) {
    $return .= '<div class="block alert info missingLanguages">
            <h1>'.$GLOBALS['langFile']['SORTABLEPAGELIST_TOOLTIP_LANGUAGEMISSING'].'</h1>
            <div class="content">
              ';
    if(!empty($websiteConfig))
      $return .= '<h2>'.$GLOBALS['langFile']['BUTTON_WEBSITESETTINGS'].'</h2><p>'.$websiteConfig.'</p><!-- need <p> tags for margin-left:..-->';
    if(!empty($categoryConfig))
      $return .= '<h2>'.$GLOBALS['langFile']['WARNING_TITLE_UNTITLEDCATEGORIES'].'</h2><p>'.$categoryConfig.'</p><!-- need <p> tags for margin-left:..-->';

    $return .= '</div>
          </div>';

  }

  return $return;
}

/**
* <b>Name</b> createBrowserChart()<br>
*
* Create the browser chart out of the browser's list saved in the website-statistic.
*
* @param string $browserString the browsers with their number of visits in a string with the format: "firefox,34|chrome,12"
*
*
* @return string|false the browser chart or FALSE
*
* @version 1.0.2
* <br>
* <b>ChangeLog</b><br>
*    - 1.0.2 transfered this function to the backend.functions.php
*    - 1.0.1 add a lot of new browsers
*    - 1.0 initial release
*
*/
function createBrowserChart($browserString) {

  //var
  $return = false;
  $listBrowser = array();

  if(isset($browserString) && !empty($browserString)) {

    $browsers = unserialize($browserString);

    if(is_array($browsers)) {

      //  number of all visits
      $sumOfNumbers = 0;
      foreach($browsers as $browser) {
        $sumOfNumbers += $browser['number'];
      }

      foreach($browsers as $browser) {

        // var
        $default = false;

        //echo $browser['data'].' - '.$browser['number'].'<br>';

        // change the Names and the Colors
        switch($browser['data']) {
          case 'firefox':
            $browserName = 'Firefox';
            $browserLogo = 'browser_firefox.png';
            $browserTextColor = '#ffffff';
            break;
          case 'firefox':
            $browserName = 'Firefox';
            $browserLogo = 'browser_firefox.png';
            break;
          case 'netscape navigator':
            $browserName = 'Netscape Navigator';
            $browserLogo = 'browser_netscape.png';
            break;
          case 'chrome':
            $browserName = 'Google Chrome';
            $browserLogo = 'browser_chrome.png';
            break;
          case 'internet explorer':
            $browserName = 'Internet Explorer';
            $browserLogo = 'browser_ie.png';
            break;
          case 'internet explorer old':
            $browserName = 'Internet Explorer 1-6';
            $browserLogo = 'browser_ie_old.png';
            break;
          case 'opera':
            $browserName = 'Opera';
            $browserLogo = 'browser_opera.png';
            break;
          case 'konqueror':
            $browserName = 'Konqueror';
            $browserLogo = 'browser_konqueror.png';
            break;
          case 'lynx':
            $browserName = 'Lynx';
            $browserLogo = 'browser_lynx.png';
            break;
          case 'safari':
            $browserName = 'Safari';
            $browserLogo = 'browser_safari.png';
            break;
          case 'mozilla':
            $browserName = 'Mozilla';
            $browserLogo = 'browser_mozilla.png';
            break;
          case 'iphone':
            $browserName = 'iPhone';
            $browserLogo = 'browser_iphone.png';
            break;
          case 'ipad':
            $browserName = 'iPad';
            $browserLogo = 'browser_ipad.png';
            break;
          case 'ipod':
            $browserName = 'iPod';
            $browserLogo = 'browser_ipod.png';
            break;
          case 'amaya':
            $browserName = 'Amaya';
            $browserLogo = 'browser_amaya.png';
            break;
          case 'phoenix':
            $browserName = 'Phoenix';
            $browserLogo = 'browser_phoenix.png';
            break;
          case 'icab':
            $browserName = 'iCab';
            $browserLogo = 'browser_icab.png';
            break;
          case 'omniweb':
            $browserName = 'OmniWeb';
            $browserLogo = 'browser_omniweb.png';
            break;
          case 'galeon':
            $browserName = 'Galeon';
            $browserLogo = 'browser_galeon.png';
            break;
          case 'netpositive':
            $browserName = 'NetPositive';
            $browserLogo = 'browser_netpositive.png';
            break;
          case 'opera mini':
            $browserName = 'Opera Mini';
            $browserTextColor = '#000000';
            break;
          case 'blackberry':
            $browserName = 'BlackBerry';
            $browserLogo = 'browser_blackberry.png';
            break;
          case 'android':
            $browserName = 'Android';
            $browserLogo = 'browser_android.png';
            break;
          case 'icecat':
            $browserName = 'IceCat';
            $browserLogo = 'browser_icecat.png';
            break;
          case 'nokia browser': case 'Nokia S60 OSS Browser':
            $browserName = 'Nokia Browser';
            $browserLogo = 'browser_nokia.png';
            break;
          default:
            $default = true;
            $browserName = $GLOBALS['langFile']['STATISTICS_TEXT_BROWSERCHART_OTHERS'];
            $browserLogo = 'browser_others.png';
            break;
        }

        if($default) {
          $listBrowser['unknown']['name'] = $browserName;
          $listBrowser['unknown']['class'] = 'unknown';
          $listBrowser['unknown']['logo'] = $browserLogo;
          $listBrowser['unknown']['percent'] = round((($browser['number'] + $listBrowser['unknown']['number'])  / $sumOfNumbers) * 100);
          $listBrowser['unknown']['number'] += $browser['number'];
        } else {
          $listBrowser[$browser['data']]['name'] = $browserName;
          $listBrowser[$browser['data']]['class'] = $browser['data'];
          $listBrowser[$browser['data']]['logo'] = $browserLogo;
          $listBrowser[$browser['data']]['percent'] = round(($browser['number'] / $sumOfNumbers) * 100);
          $listBrowser[$browser['data']]['number'] = $browser['number'];
        }
      }

      // sort by number
      usort($listBrowser,'sortDataString');

      $return = '<table class="tableChart"><tbody><tr>';
      foreach($listBrowser as $displayBrowser) {

        // calculates the text width and the cell width
        $textWidth = round(((strlen($displayBrowser['name']) + strlen($displayBrowser['number']) + 15) * 4) + 45); // +45 = logo width + padding; +15 = for the "(54)"; the visitor count
        $cellWidth = round(780 * ($displayBrowser['percent'] / 100)); // 780px = the width of the 100% table
        //$return .= '<div style="border-bottom:1px solid red;width:'.$textWidth.'px;">'.$cellWidth.' -> '.$textWidth.'</div>';

        // show text only if cell is big enough
        if($cellWidth < $textWidth) {
          $cellText = '';
          $cellWidth -= 10;

          //echo $displayBrowser['name'].': '.$cellWidth.'<br>';

          // makes the browser logo smaller
          if($cellWidth < 40) {// 40 = logo width

            // change logo size
            if($cellWidth <= 0)
              $logoSize = 'width: 0px;';
            else
              $logoSize = 'width: '.$cellWidth.'px;';

            // change cellpadding
            $createPadding = round(($cellWidth / 40) * 10);
            if($bigLogo === false && $createPadding < 5 && $createPadding > 0)
              $cellpadding = $createPadding.'px 5px;';
            else
              $cellpadding = 'padding: 0px 5px;';

          }

          $bigLogo = false;
        } else {
          $cellText = '<span style="position: absolute; left: 45px; top: 11px;"><strong>'.$displayBrowser['name'].'</strong> ('.$displayBrowser['percent'].'%)</span>';
          $logoSize = '';
          $bigLogo = true;
          $cellpadding = '';
        }

        // SHOW the table cell with the right browser and color
        $return .= '<td style="padding: '.$cellpadding.'; width: '.$displayBrowser['percent'].'%;" class="toolTipBottom '.$displayBrowser['class'].'" title="[span]'.$displayBrowser['name'].'[/span] ('.$displayBrowser['percent'].'%)::'.$displayBrowser['number'].' '.$GLOBALS['langFile']['STATISTICS_TEXT_VISITORCOUNT'].'">
                    <div style="position: relative;">
                    <img src="library/images/icons/'.$displayBrowser['logo'].'" style="float: left;'.$logoSize.';" alt="browser logo">'.$cellText.'
                    </div>
                    </td>';

        unset($logoSize,$cellText);
      }
      $return .= '</tr></tbody></table>';

    }
  }

  // return the chart or false
  return $return;
}

/**
* <b>Name</b> createTagCloud()<br>
*
* Create a tag-cloud out of the given <var>$tagString</var>.
*
* @param string $tagString      the words with their number of importance in a string with the format: "lake,3|mountain,5"
* @param int    $minFontSize    (optional) the minimal font size in the tag-cloud
* @param int    $maxFontSize    (optional) the maximal font size in the tag-cloud
*
* @return string|false the tag-cloud or FALSE if the $tagString parameter is empty
*
* @version 1.0.1
* <br>
* <b>ChangeLog</b><br>
*    - 1.0.1 transfered this function to the backend.functions.php
*    - 1.0 initial release
*
*/
function createTagCloud($serializedTags,$minFontSize = 10,$maxFontSize = 20) {

  //var
  $return = false;

  if(!empty($serializedTags) && is_string($serializedTags)) {

    $tags = unserialize($serializedTags);

    $highestNumber = $tags[0]['number'];

    // sort alphabetical
    asort($tags);

    foreach($tags as $tag) {

      $fontSize = $tag['number'] / $highestNumber;
      $fontSize = round($fontSize * $maxFontSize) + $minFontSize;

      // create href
      $tagsHref = urlencode(html_entity_decode($tag['data'],ENT_QUOTES,'UTF-8'));

      $return .= '<a href="?site=search&amp;search='.$tagsHref.'" style="font-size:'.$fontSize.'px;" class="toolTipTop" title="[span]&quot;'.$tag['data'].'&quot;[/span] '.$GLOBALS['langFile']['STATISTICS_TEXT_SEARCHWORD_PART1'].' [span]'.$tag['number'].'[/span] '.$GLOBALS['langFile']['STATISTICS_TEXT_SEARCHWORD_PART2'].'::'.$GLOBALS['langFile']['STATISTICS_TOOLTIP_SEARCHWORD'].'">'.$tag['data'].'</a>&nbsp;&nbsp;'."\n";

    }
  }

  // return the tag-cloud or false
  return $return;
}
