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
 * @version 1.33
 * <br />
 * <b>ChangeLog</b><br />
 *    - 1.33 isAdmin(): add immediately return true if no remote_user exists 
 *    - 1.32 fixed editFiles()
 *    - 1.31 add checkStyleFiles()
 * 
 */

/**
 * <b>Name</b> showErrorsInWindow()<br />
 * 
 * gets the PHP errors, to show them in the errorWindow
 * 
 * 
 * <b>Used Global Variables</b><br />
 *    - <var>$errorWindow</var> the errorWindow text which will extended with the given errors from PHP
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
 * <br />
 * <b>ChangeLog</b><br />
 *    - 1.0 initial release
 * 
 */
function showErrorsInWindow($errorCode, $errorText, $errorFile, $errorLine) {
    
    // var
    $error = '<span class="rawError">'.$errorText."<br /><br />".$errorFile.' on line '.$errorLine."</span>\n";
    
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
 * <b>Name</b> isAdmin()<br />
 * 
 * Check if the current user is an admin. If no users exist everyone is an admin.
 * 
 * 
 * <b>Used Global Variables</b><br />
 *    - <var>$userConfig</var> the user-settings config (included in the {@link general.include.php})
 * 
 * @return bool TRUE if the current user is an admin, or no admins exist, otherwise FALSE
 * 
 * 
 * @version 1.1
 * <br />
 * <b>ChangeLog</b><br />
 *    - 1.1 changed user managament system, it now get the users from the user.config.php 
 *    - 1.01 add immediately return true if no remote_user exists
 *    - 1.0 initial release
 * 
 */
function isAdmin() {
  
  if(!empty($GLOBALS['userConfig'])) {
    
    $username = $_SESSION['feindura']['session']['username'];
    
    // check if the user exists
    if(!empty($username)) {
      if(array_key_exists($username,$GLOBALS['userConfig'])) {
        
        // check if the user is admin
        return ($GLOBALS['userConfig'][$username]['admin'])
          ? true
          : false;
        
      }
    }
  }
  // if no user, all are Admins
  return true;
}

/**
 * <b>Name</b> getNewPageId()<br />
 * 
 * Returns a new page ID, which is the highest page ID + 1.
 * 
 * <b>Used Global Variables</b><br />
 *    - <var>$generalFunctions</var> for the {@link getStoredPagesIds} (included in the {@link general.include.php})
 * 
 * @return int a new page ID
 * 
 * 
 * @version 1.0
 * <br />
 * <b>ChangeLog</b><br />
 *    - 1.0 initial release
 * 
 */
function getNewPageId() {
  
  // loads the file list in an array
  $pages = generalFunctions::getStoredPageIds();
  
  $highestId = 0;
  
  // go trough the file list and look for the highest number
  if(is_array($pages)) {
    foreach($pages as $page) {
      $pageId = $page['page'];
          
      if($pageId > $highestId)
        $highestId = $pageId;
    }
  }
  $highestId++;
  
  return $highestId;
}

/**
 * <b>Name</b> getNewCatgoryId()<br />
 * 
 * Returns a new category ID, which is the highest category ID + 1.
 * 
 * <b>Used Global Variables</b><br />
 *    - <var>$categoryConfig</var> the categories-settings config (included in the {@link general.include.php})
 *     
 * @return int a new category ID
 * 
 * 
 * @version 1.0
 * <br />
 * <b>ChangeLog</b><br />
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
 * <b>Name</b> getNewUserId()<br />
 * 
 * Returns a new user ID, which is the highest user ID + 1.
 * 
 * <b>Used Global Variables</b><br />
 *    - <var>$userConfig</var> the user-settings config (included in the {@link general.include.php})
 *     
 * @return int a new user ID
 * 
 * 
 * @version 1.0
 * <br />
 * <b>ChangeLog</b><br />
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
 * <b>Name</b> addSlashesToPOSTPaths()<br />
 * 
 * Ensures that the the post vars with a 'Path' in the key value start and end with a slash.
 * 
 * 
 * @version 1.0.1
 * <br />
 * <b>ChangeLog</b><br />
 *    - 1.0.1 add slash to start also 
 *    - 1.0 initial release
 * 
 */
function addSlashesToPOSTPaths($postData) {
  foreach($postData as $postKey => $post) {  
    if(strpos($postKey,'Path')!== false) {
      if(!empty($post) && substr($post,-1) !== '/')
        $post = $post.'/'; // add slash to the end
      if(!empty($post) && substr($post,0,1) !== '/')
        $post = '/'.$post; // add slash to the start
      $post = preg_replace("#/+#",'/',$post);
      
      $_POST[$postKey] = $post;
    
    } elseif(is_array($post))
      addSlashesToPOSTPaths($post);
  }
}

/**
 * <b>Name</b> createBasicFolders()<br />
 * 
 * Check if the config, pages and statistic folders exist, if not try to create these.
 * 
 * 
 * @version 1.0.1
 * <br />
 * <b>ChangeLog</b><br />
 *    - 1.0.1 add backups folder 
 *    - 1.0 initial release
 * 
 */
function createBasicFolders() {
  // config folder
  if(!is_dir(dirname(__FILE__).'/../../config'))
    mkdir(dirname(__FILE__).'/../../config',$GLOBALS['adminConfig']['permissions']);    
  // pages folder
  if(!is_dir(dirname(__FILE__).'/../../pages'))
    mkdir(dirname(__FILE__).'/../../pages',$GLOBALS['adminConfig']['permissions']);  
  // statistic folder
  if(!is_dir(dirname(__FILE__).'/../../statistic'))
    mkdir(dirname(__FILE__).'/../../statistic',$GLOBALS['adminConfig']['permissions']);
  // backups folder
  if(!is_dir(dirname(__FILE__).'/../../backups'))
    mkdir(dirname(__FILE__).'/../../backups',$GLOBALS['adminConfig']['permissions']);
}

/**
 * <b>Name</b> saveCategories()<br />
 * 
 * Saves the category-settings config array to the "config/category.config.php" file.
 * 
 * <b>Used Constants</b><br />
 *    - <var>PHPSTARTTAG</var> the php start tag
 *    - <var>PHPENDTAG</var> the php end tag
 * 
 * <b>Used Global Variables</b><br />
 *    - <var>$generalFunctions</var> to reset the {@link getStoredPagesIds} (included in the {@link general.include.php})
 * 
 * @param array $newCategories a $categoryConfig array to save
 * 
 * @return bool TRUE if the file was succesfull saved, otherwise FALSE
 * 
 * @example backend/categoryConfig.array.example.php of the $categoryConfig array
 * 
 * @version 1.0.1
 * <br />
 * <b>ChangeLog</b><br />
 *    - 1.0.1 add xssFilter to every value
 *    - 1.0 initial release
 * 
 */
function saveCategories($newCategories) {
  
  createBasicFolders();
  
  // öffnet die category.config.php zum schreiben
  if($file = fopen(dirname(__FILE__)."/../../config/category.config.php","wb")) {

      // *** write CATEGORIES
      flock($file,2); //LOCK_EX
      fwrite($file,PHPSTARTTAG); //< ?php
      
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
        
        // escape \ and '
        xssFilter::escapeBasics($category);
        
        // adds absolute path slash on the beginning and serialize the stylefiles
        $category['styleFile'] = prepareStyleFilePaths($category['styleFile']);
      
        // bubbles through the page, category and adminConfig to see if it should save the styleheet-file path, id or class-attribute
        $category['styleFile'] = setStylesByPriority($category['styleFile'],'styleFile',true);
        $category['styleId'] = setStylesByPriority($category['styleId'],'styleId',true);
        $category['styleClass'] = setStylesByPriority($category['styleClass'],'styleClass',true);        
        
        // WRITE
        fwrite($file,"\$categoryConfig[".$category['id']."]['id'] =              ".xssFilter::int($category['id'],0).";\n");
        fwrite($file,"\$categoryConfig[".$category['id']."]['name'] =            '".xssFilter::text($category['name'])."';\n");
        
        fwrite($file,"\$categoryConfig[".$category['id']."]['public'] =          ".xssFilter::bool($category['public'],true).";\n");        
        fwrite($file,"\$categoryConfig[".$category['id']."]['createDelete'] =    ".xssFilter::bool($category['createDelete'],true).";\n");
        fwrite($file,"\$categoryConfig[".$category['id']."]['thumbnail'] =       ".xssFilter::bool($category['thumbnail'],true).";\n");        
        fwrite($file,"\$categoryConfig[".$category['id']."]['plugins'] =         '".$category['plugins']."';\n");
        fwrite($file,"\$categoryConfig[".$category['id']."]['showTags'] =        ".xssFilter::bool($category['showTags'],true).";\n");
        fwrite($file,"\$categoryConfig[".$category['id']."]['showPageDate'] =    ".xssFilter::bool($category['showPageDate'],true).";\n\n");
        
        fwrite($file,"\$categoryConfig[".$category['id']."]['sorting'] =         '".xssFilter::alphabetical($category['sorting'],'manually')."';\n");
        fwrite($file,"\$categoryConfig[".$category['id']."]['sortReverse'] =     ".xssFilter::bool($category['sortReverse'],true).";\n\n");
        
        fwrite($file,"\$categoryConfig[".$category['id']."]['styleFile'] =       '".$category['styleFile']."';\n"); //xssFilter is in prepareStyleFilePaths() function
        fwrite($file,"\$categoryConfig[".$category['id']."]['styleId'] =         '".xssFilter::string($category['styleId'])."';\n");
        fwrite($file,"\$categoryConfig[".$category['id']."]['styleClass'] =      '".xssFilter::string($category['styleClass'])."';\n\n");
        
        fwrite($file,"\$categoryConfig[".$category['id']."]['thumbWidth'] =      '".xssFilter::int($category['thumbWidth'])."';\n");
        fwrite($file,"\$categoryConfig[".$category['id']."]['thumbHeight'] =     '".xssFilter::int($category['thumbHeight'])."';\n");
        fwrite($file,"\$categoryConfig[".$category['id']."]['thumbRatio'] =      '".xssFilter::alphabetical($category['thumbRatio'])."';\n\n\n");
        
      }    
      fwrite($file,'return $categoryConfig;');
      
      fwrite($file,PHPENDTAG); //? >
    flock($file,3); //LOCK_UN
    fclose($file);
    
    // reset the stored page ids
    generalFunctions::$storedPageIds = null;
    
    return true;
  } else
    return false;
}

/**
 * <b>Name</b> moveCategories()<br />
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
 * @version 1.0
 * <br />
 * <b>ChangeLog</b><br />
 *    - 1.0 initial release
 * 
 */
function moveCategories(&$categoryConfig, $category, $direction, $position = false) {
  
  $direction = strtolower($direction);
  
  // ->> CHECKS
  // if they fail it returns the unchanged $categoryConfig array
  if(is_array($categoryConfig) &&                         // is categories is array
    is_numeric($category) &&                          // have the given category id is a number
    $category == $categoryConfig[$category]['id'] &&     // dows the category exists in the $categoryConfig array
    (!$direction || $direction == 'up' || $direction == 'down') &&
    (!$position || is_numeric($position))) {   // is the right direction is given
    
    // vars
    $count = 1;
    $currentPosition = false;
    $dropedCategories = array();
    
    // -> finds out the position in the $categoryConfig array
    // and extract this category from it
    foreach($categoryConfig as $sortCategory) {
      //echo '>'.$sortCategory['id'].' -> '.$count.'<br />';
      
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
      echo '';
      $categoryConfig[$sortetCategory['id']] = $sortetCategory;
    }
    
    return true;
  
  } else
    return false;
}

/**
 * <b>Name</b> movePage()<br />
 * 
 * Moves a file into a new category directory.
 * 
 * <b>Used Global Variables</b><br />
 *    - <var>$adminConfig</var> the administrator-settings config (included in the {@link general.include.php})
 *    - <var>$generalFunctions</var> to reset the {@link getStoredPagesIds} (included in the {@link general.include.php})
 * 
 * @param int $page         the page ID
 * @param int $fromCategory the ID of the category where the page is situated
 * @param int $toCategory   the ID of the category where the file will be moved to 
 * 
 * @return bool TRUE if the page was succesfull moved, otherwise FALSE
 * 
 * @version 1.01
 * <br />
 * <b>ChangeLog</b><br />
 *    - 1.01 add create category folder, if not exiting
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
  if(copy(dirname(__FILE__).'/../../pages/'.$fromCategory.$page.'.php',
    dirname(__FILE__).'/../../pages/'.$toCategory.$page.'.php') &&
    unlink(dirname(__FILE__).'/../../pages/'.$fromCategory.$page.'.php')) {
    // reset the stored page ids
    generalFunctions::$storedPages = null;
    generalFunctions::$storedPageIds = null;
    
    return true;
  } else
    return false;
}

/**
 * <b>Name</b> saveAdminConfig()<br />
 * 
 * Saves the administrator-settings config array to the "config/admin.config.php" file.
 * 
 * <b>Used Constants</b><br />
 *    - <var>PHPSTARTTAG</var> the php start tag
 *    - <var>PHPENDTAG</var> the php end tag
 * 
 * @param array $adminConfig a $adminConfig array to save
 * 
 * @return bool TRUE if the file was succesfull saved, otherwise FALSE
 * 
 * @example backend/adminConfig.array.example.php of the $adminConfig array
 * 
 * @version 1.1
 * <br />
 * <b>ChangeLog</b><br />
 *    - 1.1 add sorting
 *    - 1.0.2 add xssFilter to every value
 *    - 1.0.1 add websitePath
 *    - 1.0 initial release
 * 
 */
function saveAdminConfig($adminConfig) {

  // **** opens admin.config.php for writing
  if($file = fopen(dirname(__FILE__)."/../../config/admin.config.php","wb")) {
    
    // clear the thumbnail path, when no upload path is specified
    if(empty($adminConfig['uploadPath'])) $adminConfig['pageThumbnail']['path'] = '';
    // -> CHECK depency of PAGEDATE
    if(!isset($adminConfig['pages']['showPageDate']) && $adminConfig['pages']['sorting'] == 'byPageDate' && $GLOBALS['adminConfig']['pages']['showPageDate'])
      $adminConfig['pages']['sorting'] = 'manually';
    
    if($adminConfig['pages']['sorting'] == 'byPageDate' && !isset($adminConfig['pages']['showPageDate']))
      $adminConfig['pages']['showPageDate'] = 'true';
    
    // escape \ and '
    xssFilter::escapeBasics($adminConfig);

    flock($file,2); // LOCK_EX
    fwrite($file,PHPSTARTTAG); // < ?php

    fwrite($file,"\$adminConfig['url'] =              '".xssFilter::url($adminConfig['url'])."';\n");
    fwrite($file,"\$adminConfig['basePath'] =         '".xssFilter::path($adminConfig['basePath'])."';\n");
    fwrite($file,"\$adminConfig['realBasePath'] =     '".xssFilter::path($adminConfig['realBasePath'])."';\n");
    fwrite($file,"\$adminConfig['websitePath'] =      '".xssFilter::path($adminConfig['websitePath'],false,'/')."';\n");
    fwrite($file,"\$adminConfig['uploadPath'] =       '".xssFilter::path($adminConfig['uploadPath'])."';\n");  
    fwrite($file,"\$adminConfig['websiteFilesPath'] = '".xssFilter::path($adminConfig['websiteFilesPath'])."';\n");
    fwrite($file,"\$adminConfig['stylesheetPath'] =   '".xssFilter::path($adminConfig['stylesheetPath'])."';\n\n");
    
    fwrite($file,"\$adminConfig['permissions'] =      ".xssFilter::number($adminConfig['permissions']).";\n");
    fwrite($file,"\$adminConfig['timeZone'] =         '".xssFilter::string($adminConfig['timeZone'],'\/','Europe/London')."';\n"); 
    fwrite($file,"\$adminConfig['dateFormat'] =       '".xssFilter::alphabetical($adminConfig['dateFormat'])."';\n");
    fwrite($file,"\$adminConfig['speakingUrl'] =      ".xssFilter::bool($adminConfig['speakingUrl'],true).";\n\n");
    
    fwrite($file,"\$adminConfig['varName']['page'] =     '".xssFilter::stringStrict($adminConfig['varName']['page'])."';\n");  
    fwrite($file,"\$adminConfig['varName']['category'] = '".xssFilter::stringStrict($adminConfig['varName']['category'])."';\n");  
    fwrite($file,"\$adminConfig['varName']['modul'] =    '".xssFilter::stringStrict($adminConfig['varName']['modul'])."';\n\n");
    
    fwrite($file,"\$adminConfig['user']['fileManager'] =      ".xssFilter::bool($adminConfig['user']['fileManager'],true).";\n");
    fwrite($file,"\$adminConfig['user']['editWebsiteFiles'] = ".xssFilter::bool($adminConfig['user']['editWebsiteFiles'],true).";\n");
    fwrite($file,"\$adminConfig['user']['editStyleSheets'] =  ".xssFilter::bool($adminConfig['user']['editStyleSheets'],true).";\n");  
    fwrite($file,"\$adminConfig['user']['info'] =             '".$adminConfig['user']['info']."';\n\n"); // htmLawed in adminSetup.process.php
    
    fwrite($file,"\$adminConfig['setStartPage'] =          ".xssFilter::bool($adminConfig['setStartPage'],true).";\n");
    fwrite($file,"\$adminConfig['pages']['createDelete'] = ".xssFilter::bool($adminConfig['pages']['createDelete'],true).";\n");
    fwrite($file,"\$adminConfig['pages']['thumbnails'] =   ".xssFilter::bool($adminConfig['pages']['thumbnails'],true).";\n");    
    fwrite($file,"\$adminConfig['pages']['plugins'] =      '".$adminConfig['pages']['plugins']."';\n"); // no xssFilter, comes from a <select>
    fwrite($file,"\$adminConfig['pages']['showTags'] =     ".xssFilter::bool($adminConfig['pages']['showTags'],true).";\n");
    fwrite($file,"\$adminConfig['pages']['showPageDate'] = ".xssFilter::bool($adminConfig['pages']['showPageDate'],true).";\n\n");
    
    fwrite($file,"\$adminConfig['pages']['sorting'] =      '".xssFilter::alphabetical($adminConfig['pages']['sorting'],'manually')."';\n");
    fwrite($file,"\$adminConfig['pages']['sortReverse'] =  ".xssFilter::bool($adminConfig['pages']['sortReverse'],true).";\n\n");
    
    fwrite($file,"\$adminConfig['editor']['safeHtml'] =   ".xssFilter::bool($adminConfig['editor']['safeHtml'],true,true).";\n");
    fwrite($file,"\$adminConfig['editor']['enterMode'] =  '".xssFilter::alphabetical($adminConfig['editor']['enterMode'])."';\n");
    fwrite($file,"\$adminConfig['editor']['styleFile'] =  '".$adminConfig['editor']['styleFile']."';\n"); // xssFilter is in prepareStyleFilePaths() function
    fwrite($file,"\$adminConfig['editor']['styleId'] =    '".xssFilter::string($adminConfig['editor']['styleId'])."';\n");  
    fwrite($file,"\$adminConfig['editor']['styleClass'] = '".xssFilter::string($adminConfig['editor']['styleClass'])."';\n\n");  
  
    fwrite($file,"\$adminConfig['pageThumbnail']['width'] =  '".xssFilter::int($adminConfig['pageThumbnail']['width'])."';\n");
    fwrite($file,"\$adminConfig['pageThumbnail']['height'] = '".xssFilter::int($adminConfig['pageThumbnail']['height'])."';\n");
    fwrite($file,"\$adminConfig['pageThumbnail']['ratio'] =  '".xssFilter::alphabetical($adminConfig['pageThumbnail']['ratio'])."';\n");
    fwrite($file,"\$adminConfig['pageThumbnail']['path'] =   '".xssFilter::path($adminConfig['pageThumbnail']['path'],false,(empty($adminConfig['uploadPath'])) ? '' : 'thumbnails/')."';\n\n");
    
    fwrite($file,"return \$adminConfig;");
       
    fwrite($file,PHPENDTAG); //? >
    flock($file,3); //LOCK_UN
    fclose($file);   
    
    return true;
  } else
    return false;
}

/**
 * <b>Name</b> saveUserConfig()<br />
 * 
 * Saves the user-settings config array to the "config/user.config.php" file.
 * 
 * <b>Used Constants</b><br />
 *    - <var>PHPSTARTTAG</var> the php start tag
 *    - <var>PHPENDTAG</var> the php end tag
 * 
 * @param array $userConfig a $userConfig array to save
 * 
 * @return bool TRUE if the file was succesfull saved, otherwise FALSE
 * 
 * @example backend/userConfig.array.example.php of the $userConfig array
 * 
 * @version 1.0.1
 * <br />
 * <b>ChangeLog</b><br />
 *    - 1.0.1 add xssFilter to every value 
 *    - 1.0 initial release
 * 
 */
function saveUserConfig($userConfig) {
   
  // opens the file for writing
  if($file = fopen(dirname(__FILE__)."/../../config/user.config.php","wb")) {
    
    // *** write
    flock($file,2); //LOCK_EX
      fwrite($file,PHPSTARTTAG); //< ?php      
      foreach($userConfig as $user => $configs) {
        
        // escape \ and '
        xssFilter::escapeBasics($configs);

        fwrite($file,"\$userConfig['".$user."']['id']       = ".xssFilter::int($configs['id'],0).";\n");
        fwrite($file,"\$userConfig['".$user."']['admin']    = ".xssFilter::bool($configs['admin'],true).";\n");
        fwrite($file,"\$userConfig['".$user."']['username'] = '".xssFilter::text($configs['username'])."';\n");
        fwrite($file,"\$userConfig['".$user."']['email']    = '".xssFilter::string($configs['email'])."';\n");
        fwrite($file,"\$userConfig['".$user."']['password'] = '".xssFilter::text($configs['password'])."';\n");  
        
        fwrite($file,"\n");        
      }      
      fwrite($file,"return \$userConfig;");
    
      fwrite($file,PHPENDTAG); //? >
    flock($file,3); //LOCK_UN
    fclose($file);
  
    return true;
  } else
    return false;
}

/**
 * <b>Name</b> saveWebsiteConfig()<br />
 * 
 * Saves the website-settings config array to the "config/website.config.php" file.
 * 
 * <b>Used Constants</b><br />
 *    - <var>PHPSTARTTAG</var> the php start tag
 *    - <var>PHPENDTAG</var> the php end tag
 * 
 * @param array $websiteConfig a $websiteConfig array to save
 * 
 * @return bool TRUE if the file was succesfull saved, otherwise FALSE
 * 
 * @example backend/websiteConfig.array.example.php of the $websiteConfig array
 * 
 * @version 1.0.2
 * <br />
 * <b>ChangeLog</b><br />
 *    - 1.0.2 add xssFilter to every value 
 *    - 1.0.1 removed $websiteconfig['email'], because its now set up in the contactForm plugin
 *    - 1.0 initial release
 * 
 */
function saveWebsiteConfig($websiteConfig) {
   
  // opens the file for writing
  if($file = fopen(dirname(__FILE__)."/../../config/website.config.php","wb")) {
    
    // escape \ and '
    xssFilter::escapeBasics($websiteConfig);
    
    // *** write
    flock($file,2); //LOCK_EX
      fwrite($file,PHPSTARTTAG); //< ?php
  
      fwrite($file,"\$websiteConfig['title']          = '".xssFilter::text($websiteConfig['title'])."';\n");
      fwrite($file,"\$websiteConfig['publisher']      = '".xssFilter::text($websiteConfig['publisher'])."';\n");
      fwrite($file,"\$websiteConfig['copyright']      = '".xssFilter::text($websiteConfig['copyright'])."';\n");
      fwrite($file,"\$websiteConfig['keywords']       = '".xssFilter::text(trim(preg_replace("#[\; ,]+#", ',', $websiteConfig['keywords']),','))."';\n");
      fwrite($file,"\$websiteConfig['description']    = '".xssFilter::text($websiteConfig['description'])."';\n\n");
      
      fwrite($file,"\$websiteConfig['startPage']      = ".xssFilter::int($websiteConfig['startPage'],0).";\n\n");
      
      fwrite($file,"return \$websiteConfig;");
    
      fwrite($file,PHPENDTAG); //? >
    flock($file,3); //LOCK_UN
    fclose($file);
  
    return true;
  } else
    return false;
}


/**
 * <b>Name</b> saveStatisticConfig()<br />
 * 
 * Saves the statiostic-settings config array to the "config/statistic.config.php" file.
 * 
 * <b>Used Constants</b><br />
 *    - <var>PHPSTARTTAG</var> the php start tag
 *    - <var>PHPENDTAG</var> the php end tag
 * 
 * @param array $statisticConfig a $statisticConfig array to save
 * 
 * @return bool TRUE if the file was succesfull saved, otherwise FALSE
 * 
 * @example backend/statisticConfig.array.example.php of the $statisticConfig array
 * 
 * @version 1.0.1
 * <br />
 * <b>ChangeLog</b><br />
 *    - 1.0.1 add xssFilter to every value 
 *    - 1.0 initial release
 * 
 */
function saveStatisticConfig($statisticConfig) {
   
  // opens the file for writing
  if($file = fopen("config/statistic.config.php","wb")) {
        
    // escape \ and '
    xssFilter::escapeBasics($statisticConfig);
    
    // WRITE
    flock($file,2); //LOCK_EX
      fwrite($file,PHPSTARTTAG); //< ?php
  
      fwrite($file,"\$statisticConfig['number']['mostVisitedPages']        = ".xssFilter::int($statisticConfig['number']['mostVisitedPages'],10).";\n");
      fwrite($file,"\$statisticConfig['number']['longestVisitedPages']     = ".xssFilter::int($statisticConfig['number']['longestVisitedPages'],10).";\n");
      fwrite($file,"\$statisticConfig['number']['lastVisitedPages']        = ".xssFilter::int($statisticConfig['number']['lastVisitedPages'],10).";\n");
      fwrite($file,"\$statisticConfig['number']['lastEditedPages']         = ".xssFilter::int($statisticConfig['number']['lastEditedPages'],10).";\n\n");
      
      fwrite($file,"\$statisticConfig['number']['refererLog']    = ".xssFilter::int($statisticConfig['number']['refererLog'],100).";\n");
      fwrite($file,"\$statisticConfig['number']['taskLog']       = ".xssFilter::int($statisticConfig['number']['taskLog'],50).";\n\n");
      
      fwrite($file,"return \$statisticConfig;");
    
      fwrite($file,PHPENDTAG); //? >
    flock($file,3); //LOCK_UN
    fclose($file);
  
    return true;
  } else
    return false;
}

/**
 * <b>Name</b> savePluginsConfig()<br />
 * 
 * Saves the plugins-settings config array to the "config/plugins.config.php" file.
 * 
 * <b>Used Constants</b><br />
 *    - <var>PHPSTARTTAG</var> the php start tag
 *    - <var>PHPENDTAG</var> the php end tag
 * 
 * @param array $pluginsConfig a $pluginsConfig array to save
 * 
 * @return bool TRUE if the file was succesfull saved, otherwise FALSE
 * 
 * @example backend/pluginsConfig.array.example.php of the $adminConfig array
 * 
 * @version 1.0.3
 * <br />
 * <b>ChangeLog</b><br />
 *    - 1.0.3 check now if the pluginsfolder still exist 
 *    - 1.0.2 add xssFilter to every value 
 *    - 1.0.1 add mootools selection 
 *    - 1.0 initial release
 * 
 */
function savePluginsConfig($pluginsConfig) {

  // **** opens plugin.config.php for writing
  if($file = fopen(dirname(__FILE__)."/../../config/plugins.config.php","wb")) {
    
    // escape \ and '
    xssFilter::escapeBasics($pluginsConfig);
    
    // sort the plugins alphabetical
    ksort($pluginsConfig);
    
    // CHECK BOOL VALUES and change to FALSE   
    flock($file,2); // LOCK_EX
    fwrite($file,PHPSTARTTAG); //< ?php
    
    if(is_array($pluginsConfig)) {
      foreach($pluginsConfig as $key => $value) {
        if(file_exists(dirname(__FILE__).'/../../plugins/'.$key))
          fwrite($file,"\$pluginsConfig['$key']['active'] =     ".xssFilter::bool($pluginsConfig[$key]['active'],true).";\n");
      }
    }
    
    fwrite($file,"\nreturn \$pluginsConfig;");
       
    fwrite($file,PHPENDTAG); //? >
    flock($file,3); //LOCK_UN
    fclose($file);   
    
    return true;
  } else
    return false;
}

/**
 * <b>Name</b> saveSpeakingUrl()<br />
 * 
 * Check if speakingUrl is activated and save a speakingUrl redirect (with mod_rewrite) to the .htacces file in the document root.
 * 
 * 
 * <b>Used Constants</b><br />
 *    - <var>DOCUMENTROOT</var> the absolut path of the webserver
 * 
 * <b>Used Global Variables</b><br />
 *    - <var>$adminConfig</var> the administrator-settings config (included in the {@link general.include.php})
 *    - <var>$langFile</var> the language file of the backend (included in the {@link general.include.php})
 *    - <var>$xssFilter</var> the {@link xssFilter::__construct()} class instance created in the {@link general.include.php})
 * 
 * @param false|string $errorWindow will be filled with an error message if an error occurs
 * 
 * @return void
 * 
 * 
 * @version 1.0
 * <br />
 * <b>ChangeLog</b><br />
 *    - 1.0 initial release
 * 
 */
function saveSpeakingUrl(&$errorWindow) {
  
  // vars
  $save = false;
  $data = false;
  $htaccessFile = DOCUMENTROOT.'/.htaccess';
  $newWebsitePath = substr(generalFunctions::getDirname(xssFilter::path($_POST['cfg_websitePath'])),1);
  $oldWebsitePath = substr(generalFunctions::getDirname(xssFilter::path($GLOBALS['adminConfig']['websitePath'])),1);
  
  $newRewriteRule = 'RewriteRule ^'.$newWebsitePath.'category/(.*)/(.*)\.html\?*(.*)$ '.$newWebsitePath.'?category=$1&page=$2$3 [QSA,L]'."\n";
  $newRewriteRule .= 'RewriteRule ^'.$newWebsitePath.'page/(.*)\.html\?*(.*)$ '.$newWebsitePath.'?page=$1$2 [QSA,L]';
  $oldRewriteRule = 'RewriteRule ^'.$oldWebsitePath.'category/(.*)/(.*)\.html\?*(.*)$ '.$oldWebsitePath.'?category=$1&page=$2$3 [QSA,L]'."\n";
  $oldRewriteRule .= 'RewriteRule ^'.$oldWebsitePath.'page/(.*)\.html\?*(.*)$ '.$oldWebsitePath.'?page=$1$2 [QSA,L]';
  
  $speakingUrlCode = '#
# feindura -flat file cms - speakingURL activation
#
<IfModule mod_rewrite.c>
RewriteEngine on
RewriteBase /
# rewrite "/page/*.html" and "/category/*/*.html"
# and also passes the session var
RewriteCond %{REQUEST_URI} !\.(css|jpg|gif|png|js)$ [NC] #do the stuff that follows only if the request doesn’t end in one of these file extensions.
RewriteCond %{HTTP_HOST} ^'.str_replace(array('http://www.','https://www.','http://','https://'),'',$_SERVER["HTTP_HOST"]).'$
'.$newRewriteRule.'
</IfModule>';
  
  $oldSpeakingUrlCode = str_replace($newRewriteRule,$oldRewriteRule,$speakingUrlCode);
  
  // -> looks if the MOD_REWRITE modul exists
  $apacheModules = (function_exists('apache_get_modules')) ? apache_get_modules() : array(false);
  if(!in_array('mod_rewrite',$apacheModules)) {
    $_POST['cfg_speakingUrl'] = '';
    return;
  }
  
  // **********************************
  // ->> if a the .htaccess file exists
  if(file_exists($htaccessFile)) {
    
    // vars
    $currrentContent = file_get_contents($htaccessFile);
    
    // ->> create or change the .htaccess file
    if($_POST['cfg_speakingUrl'] == 'true') {
      
      // -> if no speakingUrl code exists, add new one
      if(strpos($currrentContent,$speakingUrlCode) === false && strpos($currrentContent,$oldSpeakingUrlCode) === false) {
         
        $save = true;
        $data = $currrentContent."\n".$speakingUrlCode;
        
      // -> if speakingUrl code exists, change the old one
      } elseif($newWebsitePath != $oldWebsitePath &&
               strpos($currrentContent,$speakingUrlCode) === false) {
        
        $currrentContent = str_replace($oldSpeakingUrlCode,'',$currrentContent);        
        
        $save = true;
        $data = $currrentContent."\n".$speakingUrlCode;
      }
    
    // ->> delete the .htaccess file or remove the speakingUrl code
    } else {
      
      // -> if ONLY the SPEAKING URL code is in the .htaccess then DELTE the .htaccess file
      if($currrentContent == $speakingUrlCode ||
         $currrentContent == "\n".$speakingUrlCode ||
         $currrentContent == "\n\n".$speakingUrlCode ||
         $currrentContent == $oldSpeakingUrlCode ||
         $currrentContent == "\n".$oldSpeakingUrlCode ||
         $currrentContent == "\n\n".$oldSpeakingUrlCode) {
        @unlink($htaccessFile);
           
      // -> looks if SPEAKING URL code EXISTs in the .htaccess file and remove it
      } elseif(strpos($currrentContent,$speakingUrlCode) !== false ||
               strpos($currrentContent,$oldSpeakingUrlCode) !== false) {
        $newContent = str_replace($speakingUrlCode,'',$currrentContent);
        $newContent = str_replace($oldSpeakingUrlCode,'',$currrentContent);
        
        $save = true;
        $data = $newContent;
      }    
    }
      
  // -> if no .htaccess exists and speaking url is acitvated
  } elseif($_POST['cfg_speakingUrl'] == 'true') {
    $save = true;
    $data = $speakingUrlCode;  
  }
    
  // **************************
  // ->> saves the htacces file
  if($save && !empty($data) && $htaccess = fopen($htaccessFile,"wb")) {
    
    $data = preg_replace("#\\n+$#","\n",$data); // prevent growing of the file with line endings
    
    flock($htaccess,2); // LOCK_EX
    fwrite($htaccess,$data);
    flock($htaccess,3); //LOCK_UN
    fclose($htaccess);
    
    @chmod($htaccessFile,0644);
  
  // ->> throw error
  } elseif($save) {
    $_POST['cfg_speakingUrl'] = '';
    $errorWindow .= $GLOBALS['langFile']['ADMINSETUP_GENERAL_speakingUrl_error_save'];
  }
  
  return;
}

/**
 * <b>Name</b> generateBackupFileName()<br />
 * 
 * generates the backup file name like:
 * 
 * <samp>
 * feinduraBackup_localhost_2010-11-17_17-36.zip
 * </samp>
 * 
 * <b>Used Global Variables</b><br />
 *    - <var>$adminConfig</var> the administrator-settings config (included in the {@link general.include.php})
 * 
 * @param string $backupAppendix (optional) a name which will be appended to the backup file name
 * 
 * @return string the generated backup file name with full path
 * 
 * 
 * @version 1.0
 * <br />
 * <b>ChangeLog</b><br />
 *    - 1.0 initial release
 * 
 */
function generateBackupFileName($backupAppendix = false) {
  
  $backupAppendix = ($backupAppendix) ? '_'.$backupAppendix : '';
  $websitePath = generalFunctions::getDirname($GLOBALS['adminConfig']['websitePath']);
  $websitePath = str_replace(array('/',"\\"),'-',$websitePath);
  $websitePath = ($websitePath != '-') ? substr($websitePath,0,-1) : '';
  $backupName = 'feinduraBackup_'.$_SERVER['SERVER_NAME'].$websitePath.'_'.date('Y-m-d_H-i').$backupAppendix.'.zip';
  $backupFileName = dirname(__FILE__).'/../../backups/'.$backupName;
  
  return $backupFileName;
}

/**
 * <b>Name</b> createBackup()<br />
 * 
 * Creates a backup file from the "config", "statistic" and "pages" folder.
 * 
 * <b>Used Global Variables</b><br />
 *    - <var>$adminConfig</var> the administrator-settings config (included in the {@link general.include.php})
 * 
 * @param string $backupFileName the full path of the new backup file
 * 
 * @return true|string TRUE if the creation of a backup zip was successfull, otherwise a string with the error warning
 * 
 * 
 * @version 1.0
 * <br />
 * <b>ChangeLog</b><br />
 *    - 1.0 initial release
 * 
 */
function createBackup($backupFile) {
  
  // -> generate archive
  require_once(dirname(__FILE__).'/../thirdparty/PHP/pclzip.lib.php');
  $archive = new PclZip($backupFile);
  $catchError = $archive->add($GLOBALS['adminConfig']['realBasePath'].'config/,'.$GLOBALS['adminConfig']['realBasePath'].'statistic/,'.$GLOBALS['adminConfig']['realBasePath'].'pages/',PCLZIP_OPT_REMOVE_PATH, $GLOBALS['adminConfig']['realBasePath']);

  if($catchError == 0)
    return $archive->errorInfo(true);
  else
    return true;
}

/**
 * <b>Name</b> prepareStyleFilePaths()<br />
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
 * @version 1.01
 * <br />
 * <b>ChangeLog</b><br />
 *    - add xssFilter test 
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
        $styleFile = xssFilter::url($styleFile);
      else
        $styleFile = xssFilter::path($styleFile);
      
      // adds back to the string only if its not empty
      if(!empty($styleFile))
        $styleFiles[] = $styleFile;
    }
  }
  return serialize($styleFiles);
}

/**
 * <b>Name</b> setStylesByPriority()<br />
 * 
 * Bubbles through the stylesheet-file path, ID or class-attribute
 * of the page, category and adminSetup and check if the stylesheet-file path, ID or class-attribute already exist.
 * Ff the <var>$givenStyle</var> parameter is empty,
 * it check if the category has a styleheet-file path, ID or class-attribute set return the value if not return the value from the {@link $adminConfig administartor-settings config}.
 * 
 * <b>Used Global Variables</b><br />
 *    - <var>$adminConfig</var> the administrator-settings config (included in the {@link general.include.php}) 
 *    - <var>$categoryConfig</var> the categories-settings config (included in the {@link general.include.php})
 * 
 * @param string   $givenStyle the string with the stylesheet-file path, id or class
 * @param string   $styleType  the key for the $pageContent, {@link $categoryConfig} or {@link $adminConfig} array can be "styleFile", "styleId" or "styleClass" 
 * @param int|true $category   the ID of the category to bubble through or TRUE when the stylesheet-file path, id or class is from a category
 * 
 * @return string an empty string or the $givenStyle parameter if it was not found through while bubbleing up
 * 
 * 
 * @version 1.0
 * <br />
 * <b>ChangeLog</b><br />
 *    - 1.0 initial release
 * 
 */
function setStylesByPriority($givenStyle,$styleType,$category) {
  
  // prepare string
  if($styleType != 'styleFile')
    $givenStyle = str_replace(array('#','.'),'',$givenStyle);
  elseif($styleType == 'styleFile' && !empty($givenStyle) && substr($givenStyle,0,2) !== 'a:' &&substr($givenStyle,0,1) !== '/')
    $givenStyle = '/'.$givenStyle;
  
  // compare string with category
  if($category !== true &&
     (!empty($GLOBALS['categoryConfig'][$category][$styleType]) || $GLOBALS['categoryConfig'][$category][$styleType] != 'a:0:{}') &&
     $givenStyle == $GLOBALS['categoryConfig'][$category][$styleType]) {
      $givenStyle = '';
      
  //  or adminConfig
  } elseif($givenStyle == $GLOBALS['adminConfig']['editor'][$styleType]) {
    $givenStyle = '';
  }  
  
  return $givenStyle;
}

/**
 * <b>Name</b> showStyleFileInputs()<br />
 * 
 * Lists the styleFile inputs from a given styleFile data-string.
 * 
 * 
 * @param string   $styleFiles the string with the stylesheet-file path, id or class
 * @param string   $inputNames  the key for the $pageContent, {@link $categoryConfig} or {@link $adminConfig} array can be "styleFile", "styleId" or "styleClass" 
 * 
 * @return string the style File inputs
 * 
 * 
 * @version 1.0
 * <br />
 * <b>ChangeLog</b><br />
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
      $return .= '<input name="'.$inputNames.'[]" value="'.$styleFileInput.'" />';
    }
  } else
    $return = '<input class="noResize" name="'.$inputNames.'[]" value="" />';
  
  // return the result
  return $return;
}

/**
 * <b>Name</b> showPageDate()<br>
 * 
 * Shows the page date, if the date is invalid it shows an error text.
 * 
 * <b>Used Global Variables</b><br />
 *    - <var>$langFile</var> the language file of the backend (included in the {@link general.include.php})
 * 
 * @param array        $pageContent  the $pageContent array of a page
 * 
 * @uses statisticFunctions::checkPageDate()      to check if the page date is a valid date
 * @uses statisticFunctions::dateDayBeforeAfter() to check if the date was yesterday or is tomorrow
 * @uses statisticFunctions::formatDate()         to format the unix timstamp into the right date format
 * 
 * @return string the page date as text string, or an error text
 * 
 * @static
 * @version 1.0
 * <br>
 * <b>ChangeLog</b><br>
 *    - 1.0 initial release
 * 
 */
function showPageDate($pageContent) {
  
  // vars
  $return = false;
  $titleDateBefore = '';
  $titleDateAfter = '';
  
  if(statisticFunctions::checkPageDate($pageContent)) {
  	// adds spaces on before and after
  	if($pageContent['pageDate']['before']) $titleDateBefore = $pageContent['pageDate']['before'].' ';
  	if($pageContent['pageDate']['after']) $titleDateAfter = ' '.$pageContent['pageDate']['after'];

    // CHECKs the DATE FORMAT
    $return = (statisticFunctions::validateDateFormat(statisticFunctions::formatDate($pageContent['pageDate']['date'])) === false)
    ? '[br /][br /][b]'.$GLOBALS['langFile']['sortablePageList_pagedate'].'[/b][br /]'.$titleDateBefore.'[span style=color:#950300]'.$langFile['editor_pageSettings_pagedate_error'].':[/span][br /] '.$pageContent['pageDate']['date'].$titleDateAfter
    : '[br /][br /][b]'.$GLOBALS['langFile']['sortablePageList_pagedate'].'[/b][br /]'.$titleDateBefore.statisticFunctions::formatDate(statisticFunctions::dateDayBeforeAfter($pageContent['pageDate']['date'],$langFile)).$titleDateAfter;
  }    
  return $return;
}

/**
 * <b>Name</b> editFiles()<br />
 * 
 * Generates a editable textfield with a file selection and a input for creating new files.
 * 
 * <b>Used Constants</b><br />
 *    - <var>DOCUMENTROOT</var> the absolut path of the webserver
 * 
 * <b>Used Global Variables</b><br />
 *    - <var>$_POST</var> to get which form is open
 *    - <var>$langFile</var> the backend language-file (included in the {@link general.include.php})
 *    - <var>$savedForm</var> the variable to tell which form was saved (set in the {@link saveEditedFiles})
 * 
 * @param string		$filesPath	         the path where all files (also files in subfolders) will be shown for editing
 * @param string		$status		           a status name which will be set to the $_GET['status'] variable in the formular action attribute
 * @param string		$titleText	         a title text which will be displayed as the title of the edit files textfield
 * @param string		$anchorName	         the name of the anchor which will be added to the formular action attribute
 * @param string|false		$fileType      (optional) a filetype which will be added to each ne created file
 * @param string|array|false	$excluded	 (optional) a string (seperated with ",") or array with files or folder names which should be excluded from the file selection, if FALSE no file will be excluded
 * 
 * @uses generalFunctions::readFolderRecursive()	reads the $filesPath folder recursive and loads all file paths in an array
 * 
 * @return void displayes the file edit textfield
 * 
 * @version 1.01
 * <br />
 * <b>ChangeLog</b><br />
 *    - 1.01 put fileType to the classe instead of the id of the textarea
 *    - 1.0 initial release
 * 
 */
function editFiles($filesPath, $status, $titleText, $anchorName, $fileType = false, $excluded = false) {
  
  // var
  $fileTypeText = null;
  $isFiles = false;
  $_GET['file'] = xssFilter::path($_GET['file']);
  
  // shows the block below if it is the ones which is saved before
  $hidden = ($_GET['status'] == $status || $GLOBALS['savedForm'] === $status) ? '' : ' hidden';

  echo '<form action="index.php?site='.$_GET['site'].'#'.$anchorName.'" method="post" enctype="multipart/form-data" accept-charset="UTF-8">
        <div>
        <input type="hidden" name="send" value="saveEditedFiles" />
        <input type="hidden" name="status" value="'.$status.'" />
        <input type="hidden" name="filesPath" value="'.$filesPath.'" />';
  if($fileType)
    echo '<input type="hidden" name="fileType" value=".'.$fileType.'" />';
  echo '</div>';
  
  echo '<div class="block'.$hidden.'">
          <h1><a href="#" name="'.$anchorName.'" id="'.$anchorName.'">'.$titleText.'</a></h1>
          <div class="content editFiles"><br />';
      
  //echo $filesPath.'<br />';      
  // gets the files out of the directory --------------
  // adds the DOCUMENTROOT  
  $filesPath = str_replace(DOCUMENTROOT,'',$filesPath);  
  $dir = DOCUMENTROOT.$filesPath;
  if(!empty($filesPath) && is_dir($dir)) {
    $files = generalFunctions::readFolderRecursive($filesPath);
    $files = $files['files'];

  	// ->> EXLUDES files or folders
  	if($excluded !== false) {
  	  
  	  // -> is string convert to array
  	  if(is_string($excluded))
  	    $excluded = explode(',',$excluded);
  	  
  	  if(is_array($excluded)) {  	    
  	    foreach($files as $file) {  	      
  	      $foundToExclud = false;  	      
  	      // looks if any of a excluded file is found
  	      foreach($excluded as $excl) {
  	        if(strstr($file,$excl))
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
    echo '<code>"'.$filesPath.'"</code> <b>'.$GLOBALS['langFile']['editFilesSettings_noDir'].'</b>';
    $isDir = false;
  }
  
  
  // GETS ACTUAL FILE ----------------------------------
  if($_GET['status'] == $status)
    $editFile = $_GET['file'];
  
  // wenn noch nicht per Dateiauswahl $editfile kreiert wurde
  if(empty($editFile) && isset($files)) {
    $editFile = $files[0];
  }
  
  if($isDir) {

    // FILE SELECTION ------------------------------------
    if($isFiles && isset($files)) {
      echo '<div class="editFiles left">
            <h2>'.$GLOBALS['langFile']['editFilesSettings_chooseFile'].'</h2>
            <input value="'.$filesPath.'" readonly="readonly" style="width:auto;" size="'.(strlen($filesPath)-2).'" />'."\n";
      echo '<select onchange="changeEditFile(\''.$_GET['site'].'\',this.value,\''.$status.'\',\''.$anchorName.'\');">'."\n";
 
            // listet die Dateien aus dem Ordner als Mehrfachauswahl auf
            foreach($files as $cFile) {
              $onlyFile = str_replace($filesPath,'',$cFile);
              if($editFile == $cFile)
                echo '<option value="'.$cFile.'" selected="selected">'.$onlyFile.'</option>'."\n";
              else
                echo '<option value="'.$cFile.'">'.$onlyFile.'</option>'."\n";    
            }
      echo '</select></div>'."\n\n";
    } // -------------------------------------------------
    
    // create a NEW FILE ---------------------------------
    if($fileType)
      $fileTypeText = '<b>.'.$fileType.'</b>';
    echo '<div class="editFiles right">
          <h2>'.$GLOBALS['langFile']['editFilesSettings_createFile'].'</h2>
          <input name="newFile" style="width:200px;" class="thumbnailToolTip" title="'.$GLOBALS['langFile']['editFilesSettings_createFile'].'::'.$GLOBALS['langFile']['editFilesSettings_createFile_inputTip'].'" /> '.$fileTypeText.'
          </div>';
  }
  
  // OPEN THE FILE -------------------------------------
  if(@is_file(DOCUMENTROOT.$editFile)) {
    $editFileOpen = fopen(DOCUMENTROOT.$editFile,"r");  
    $file = @fread($editFileOpen,filesize(DOCUMENTROOT.$editFile));
    fclose($editFileOpen);
    $file = str_replace(array('<','>'),array('&lt;','&gt;'),$file);
    
    echo '<input type="hidden" name="file" value="'.$editFile.'" />'."\n";
    echo '<textarea name="fileContent" cols="90" rows="30" class="editFiles '.substr($editFile, strrpos($editFile, '.') + 1).'" id="editFiles'.uniqid().'">'.$file.'</textarea>';
  }  
  
  
  if($isDir) {
    if($isFiles)
      echo '<a href="?site='.$_GET['site'].'&amp;status=deleteEditFiles&amp;editFilesStatus='.$status.'&amp;file='.$editFile.'#'.$anchorName.'" onclick="openWindowBox(\'library/sites/windowBox/deleteEditFiles.php?site='.$_GET['site'].'&amp;status=deleteEditFiles&amp;editFilesStatus='.$status.'&amp;file='.$editFile.'&amp;anchorName='.$anchorName.'\',\''.$GLOBALS['langFile']['editFilesSettings_deleteFile'].'\');return false;" class="cancel left toolTip" title="'.$GLOBALS['langFile']['editFilesSettings_deleteFile'].'::" style="float:left;"></a>';
    echo '<br /><br /><input type="submit" value="" name="saveEditedFiles" class="button submit right" title="'.$GLOBALS['langFile']['form_submit'].'" />';
  }
  echo '</div>
      <div class="bottom"></div>
    </div>
    </form>';
}

/**
 * <b>Name</b> saveEditedFiles()<br />
 * 
 * Save the files edited in {@link editFiles()}.
 * 
 * <b>Used Constants</b><br />
 *    - <var>$_POST</var> for the file data
 *    - <var>DOCUMENTROOT</var> the absolut path of the webserver 
 * 
 * @param string &$savedForm	to set which form was is saved
 * 
 * @return bool TRUE if the file was succesfull saved, otherwise FALSE
 * 
 * @version 1.0.1
 * <br />
 * <b>ChangeLog</b><br />
 *    - 1.0.1 add xssFilter and removed htmlentities 
 *    - 1.0 initial release
 * 
 */
function saveEditedFiles(&$savedForm) {

  // var
  $_POST['filesPath'] = DOCUMENTROOT.str_replace(DOCUMENTROOT,'',$_POST['filesPath']);
  // add DOCUMENTROOT
  $_POST['file'] = xssFilter::path($_POST['file']);
  $_POST['file'] = str_replace(DOCUMENTROOT,'',$_POST['file']);  
  $_POST['file'] = DOCUMENTROOT.$_POST['file'];
  
  // ->> SAVE FILE
  if(@is_file($_POST['file']) && empty($_POST['newFile'])) {
    
    // encode when ISO-8859-1
    if(mb_detect_encoding($_POST['fileContent']) == 'ISO-8859-1') $_POST['fileContent'] = utf8_encode($_POST['fileContent']);
    //$_POST['fileContent'] = preg_replace("#[\\r\\n]+#","\n",$_POST['fileContent']);
    //$_POST['fileContent'] = preg_replace('#(\\r?\\n)#', '$1', $_POST['fileContent']);    
    //$_POST['fileContent'] = preg_replace('#\\\+#','\\',$_POST['fileContent']);
    //$_POST['fileContent'] = str_replace('\"', '"', $_POST['fileContent']);
    //$_POST['fileContent'] = str_replace("\'", "'", $_POST['fileContent']);
    $_POST['fileContent'] = generalFunctions::smartStripslashes($_POST['fileContent']);    
    $_POST['fileContent'] = preg_replace("#\\n#","",$_POST['fileContent']); // prevent double line breaks
    
    // -> SAVE
    if(file_put_contents($_POST['file'],$_POST['fileContent'],LOCK_EX) !== false) {
      
      $_GET['file'] = str_replace(DOCUMENTROOT,'',$_POST['file']);
      $_GET['status'] = $_POST['status'];
      $savedForm = $_POST['status'];
    
      return true;      
    } else
      return false;
    
  // ->> NEW FILE
  } elseif(!empty($_POST['newFile'])) { // creates a new file if a filename was input in the field
        
    //$_POST['newFile'] = str_replace( array(" ","%","+","&","#","!","?","$","§",'"',"'","(",")"), '_', $_POST['newFile']);
    $_POST['newFile'] = xssFilter::path($_POST['newFile'],false,'noname.txt');
    
    // check if a path is included
    if(strpos($_POST['newFile'],'/') !== false) {
      $directory = substr($_POST['newFile'],0,strrpos($_POST['newFile'],'/'));
      $directory = preg_replace("/\/+/", '/', $_POST['filesPath'].'/'.$directory);
      if(!is_dir($directory))
        mkdir($directory,$GLOBALS['admimConfig']['permissions'],true);
      $_POST['filesPath'] = $directory;
      $_POST['newFile'] = substr($_POST['newFile'],strrpos($_POST['newFile'],'/')+1);
    }
    
    $_POST['newFile'] = generalFunctions::cleanSpecialChars($_POST['newFile'],'_');
    $_POST['newFile'] = str_replace($_POST['fileType'],'',$_POST['newFile']);
    
    $fullFilePath = $_POST['filesPath'].'/'.$_POST['newFile'].$_POST['fileType'];
    $fullFilePath = preg_replace("/\/+/", '/', $fullFilePath);
    
    if($file = fopen($fullFilePath,"wb")) {
      
      $_GET['file'] = str_replace(DOCUMENTROOT,'',$fullFilePath);       
      $_GET['status'] = $_POST['status'];
      $savedForm = $_POST['status'];
      
      return true;
    } else
      return false;
  }
}

/**
 * <b>Name</b> delDir()<br />
 * 
 * Deletes a directory and all files in it.
 * 
 * @param string $dir the absolute path to the directory which will be deleted 
 * 
 * @return bool TRUE if the directory was succesfull deleted, otherwise FALSE
 * 
 * @version 1.0
 * <br />
 * <b>ChangeLog</b><br />
 *    - 1.0 initial release
 * 
 */
function delDir($dir) {

    $filesFolders = generalFunctions::readFolderRecursive($dir);
    
    if(is_array($filesFolders)) {
      $return = false;
      $writeerror = false;
      
      if(is_array($filesFolders['files'])) {
        foreach($filesFolders['files'] as $file) {
          if(!is_writable(DOCUMENTROOT.$file))
            $writeerror = true;
          @unlink(DOCUMENTROOT.$file);
        }
      }
      if(is_array($filesFolders['folders'])) {
        foreach($filesFolders['folders'] as $folder) {
          if(!is_writable(DOCUMENTROOT.$folder))
            $writeerror = true;
          @rmdir(DOCUMENTROOT.$folder);
        }
      }
      
      // recheck if everything is deleted
      $checkFilesFolders = generalFunctions::readFolderRecursive($dir);
      
      if(rmdir($dir))
        return true;
      elseif($writeerror === false && (!empty($checkFilesFolders['folders']) || !empty($checkFilesFolders['files'])))
        delDir($dir);
      else
        return false;
    
    } elseif(@rmdir($dir))
      return true;
    else
      return false;
}

/**
 * <b>Name</b> isFolderWarning()<br />
 * 
 * Check if the <var>$folder</var> parameter is a directory, otherwise it return a warning text.
 * 
 * <b>Used Constants</b><br />
 *    - <var>DOCUMENTROOT</var> the absolut path of the webserver
 * 
 * <b>Used Global Variables</b><br />
 *    - <var>$langFile</var> the backend language-file (included in the {@link general.include.php})    
 * 
 * @param string $folder the absolut path of the folder to check
 * 
 * @return string|false a warning text if it's not a directory, otherwise FALSE
 * 
 * @version 1.0
 * <br />
 * <b>ChangeLog</b><br />
 *    - 1.0 initial release
 * 
 */
function isFolderWarning($folder) {
  
  if(!generalFunctions::getRealPath($folder) && is_dir($folder) === false) {
      return '<span class="warning"><b>&quot;'.$folder.'&quot;</b> -> '.$GLOBALS['langFile']['adminSetup_error_isFolder'].'</span><br />';
  } else
    return false;
}

/**
 * <b>Name</b> isWritableWarning()<br />
 * 
 * Check if a file/folder is writeable, otherwise it return a warning text.
 * 
 * <b>Used Constants</b><br />
 *    - <var>DOCUMENTROOT</var> the absolut path of the webserver
 * 
 * <b>Used Global Variables</b><br />
 *    - <var>$langFile</var> the backend language-file (included in the {@link general.include.php})
 * 
 * @param string $fileFolder the absolut path of a file/folder to check
 * 
 * @return string|false a warning text if it's not writable, otherwise FALSE
 * 
 * @version 1.0
 * <br />
 * <b>ChangeLog</b><br />
 *    - 1.0 initial release
 * 
 */
function isWritableWarning($fileFolder) {
  
  $fileFolder = generalFunctions::getRealPath($fileFolder);

  if(file_exists($fileFolder) && is_writable($fileFolder) === false) {
    return '<span class="warning toolTip" title="'.$fileFolder.'::'.$GLOBALS['langFile']['adminSetup_error_writeAccess_tip'].'"><b>&quot;'.$fileFolder.'&quot;</b> -> '.$GLOBALS['langFile']['adminSetup_error_writeAccess'].'</span><br />';
  } else
    return false;
}

/**
 * <b>Name</b> isWritableWarningRecursive()<br />
 * 
 * Check if folders and it's containing files are writeable, otherwise it return a warning text.
 * 
 * @param array $folders an array with absolut paths of folders to check
 * 
 * @uses isFolderWarning()                        to check if the folder is a valid directory, if not return a warning
 * @uses isWritableWarning()                      to check every file/folder if it's writable, if not return a warning
 * @uses generalFunctions::readFolderRecursive()  to read all subfolders and files in a directory
 * 
 * @return string|false warning texts if they are not writable, otherwise FALSE
 * 
 * @version 1.0
 * <br />
 * <b>ChangeLog</b><br />
 *    - 1.0 initial release
 * 
 */
function isWritableWarningRecursive($folders) {
  
  //var
  $return = false;
  
  foreach($folders as $folder) {
    if(!empty($folder)) {    
      if($isFolder = isFolderWarning($folder)) {
        $return .= $isFolder;
      } else {
        $return .= isWritableWarning($folder);
        if($readFolder = generalFunctions::readFolderRecursive($folder)) {
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
 * <b>Name</b> checkBasePath()<br />
 * 
 * Check if the current path of the CMS is matching the <var>$adminConfig['basePath']</var>
 * And if the current URL is matching the <var>$adminConfig['url']</var>.
 * 
 * <b>Used Global Variables</b><br />
 *    - <var>$adminConfig</var> the administrator-settings config (included in the {@link general.include.php})
 * 
 * @return bool TRUE if there are matching, otherwise FALSE
 * 
 * @version 1.0
 * <br />
 * <b>ChangeLog</b><br />
 *    - 1.0 initial release
 * 
 */
function checkBasePath() {
  $baseUrl = preg_replace('#^[a-zA-Z]+[:]{1}[\/\/]{2}#','',$GLOBALS['adminConfig']['url']);
  $checkUrl = preg_replace('#^[a-zA-Z]+[:]{1}[\/\/]{2}#','',$_SERVER["SERVER_NAME"]);
  
  $checkPath = preg_replace('#/+#','/',dirname($_SERVER['SCRIPT_NAME']).'/');
  
  if($GLOBALS['adminConfig']['basePath'] == $checkPath &&
     $baseUrl == $checkUrl)
    return true;
  else
    return false;
}

/**
 * <b>Name</b> checkBasePath()<br />
 * 
 * Returns a warning if the current path of the CMS and the current URL is not matching with the ones set in the <var>$adminConfig</var>.
 * 
 * <b>Used Global Variables</b><br />
 *    - <var>$langFile</var> the backend language-file (included in the {@link general.include.php})
 * 
 * @uses checkBasePath() to check if the current pathand URL are matching
 * 
 * @return string|false a warning if the basePath is wrong, otherwise FALSE
 * 
 * @version 1.0
 * <br />
 * <b>ChangeLog</b><br />
 *    - 1.0 initial release
 * 
 */
function basePathWarning() {
  if(checkBasePath() === false) {
    return '<div class="block warning">
            <h1>'.$GLOBALS['langFile']['warning_fmsConfWarning_h1'].'</h1>
            <div class="content">
              <p>'.$GLOBALS['langFile']['warning_fmsConfWarning'].'</p><!-- need <p> tags for margin-left:..--> 
            </div> 
            <div class="bottom"></div> 
          </div>';
  } else
    return false;
}

/**
 * <b>Name</b> checkBasePath()<br />
 * 
 * Retruns a warning if the current set start page is existing.
 * 
 * <b>Used Global Variables</b><br />
 *    - <var>$adminConfig</var> the administrator-settings config (included in the {@link general.include.php})
 *    - <var>$websiteConfig</var> the website-settings config (included in the {@link general.include.php})
 *    - <var>$generalFunctions</var> for the {@link generalFunctions::getPageCategory()} method (included in the {@link general.include.php})
 *    - <var>$langFile</var> the backend language-file (included in the {@link general.include.php})
 * 
 * @uses generalFunctions::getPageCategory() to get the category of the start page
 * 
 * @return string|false a warning if the start page doesn't exist, otherwise FALSE
 * 
 * @version 1.0
 * <br />
 * <b>ChangeLog</b><br />
 *    - 1.0 initial release
 * 
 */
function startPageWarning() {
  
  if(checkBasePath() === false || !is_dir(dirname(__FILE__).'/../../pages/'))
    return false;
  
  if($GLOBALS['adminConfig']['setStartPage'] && !empty($GLOBALS['websiteConfig']['startPage']) && ($startPageCategory = generalFunctions::getPageCategory($GLOBALS['websiteConfig']['startPage'])) != 0)
    $startPageCategory .= '/';
  else
    $startPageCategory = '';

  if($GLOBALS['adminConfig']['setStartPage'] && (empty($GLOBALS['websiteConfig']['startPage']) || !file_exists(dirname(__FILE__).'/../../pages/'.$startPageCategory.$GLOBALS['websiteConfig']['startPage'].'.php'))) {
    return '<div class="block info">
            <h1>'.$GLOBALS['langFile']['warning_startPageWarning_h1'].'</h1>
            <div class="content">
              <p>'.$GLOBALS['langFile']['warning_startPageWarning'].'</p><!-- need <p> tags for margin-left:..--> 
            </div> 
            <div class="bottom"></div> 
          </div>';
  } else
    return false;
}

?>