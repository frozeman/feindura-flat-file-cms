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
 * <b>Name</b> isAdmin()<br>
 * 
 * Check if the current user is an admin. If no users exist everyone is an admin.
 * 
 * 
 * <b>Used Global Variables</b><br>
 *    - <var>$userConfig</var> the user-settings config (included in the {@link general.include.php})
 * 
 * @return bool TRUE if the current user is an admin, or no admins exist, otherwise FALSE
 * 
 * 
 * @version 1.2
 * <br>
 * <b>ChangeLog</b><br>
 *    - 1.2 returns now also TRUE when no user is admin
 *    - 1.1 changed user managament system, it now get the users from the user.config.php 
 *    - 1.01 add immediately return true if no remote_user exists
 *    - 1.0 initial release
 * 
 */
function isAdmin() {
  
  // var
  $otherUsers = false;

  if(!empty($GLOBALS['userConfig'])) {
    
    $username = $_SESSION['feinduraSession']['login']['username'];
    
    // check if the user exists
    if(!empty($username)) {
      foreach($GLOBALS['userConfig'] as $user) {
        if($user['username'] == $username) {
          // check if the user is admin
          if($user['admin'])
            return true;
        } else {
          if($user['admin'])
            $otherUsers = true;
        }  
      }
    }
  }
  // if no user is admin or no user exists, all are Admins
  if(!$otherUsers)
    return true;
  else
    return false;
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
function isBlocked($returnBool = false) {
  $return = '';
  foreach($GLOBALS['userCache'] as $cachedUser) {
    $location = trim($cachedUser['location']);
    if($cachedUser['identity'] != IDENTITY &&
       $cachedUser['edit'] &&
       $location != 'new' && // dont block when createing a new page (multiple user can do that)
       ($location == $_GET['page'] || $location == $_GET['site'])) {
      $return = ($returnBool) ? true : '<div id="contentBlocked">'.$GLOBALS['langFile']['GENERAL_TEXT_CURRENTLYEDITED'];
      if(!empty($cachedUser['username'])) $return .= '<br><span style="font-size:15px;">'.$GLOBALS['langFile']['DASHBOARD_TITLE_USER'].': <span class="blue">'.$cachedUser['username'].'</span></span>';
      $return .= '</div>';
      return $return;
    }
  }
  return false;
}

/**
 * <b>Name</b> userCache()<br>
 * 
 * Creates a <var>user.statistic.cache</var> file and store the username and the currently visited site/page.
 * 
 * An example of the saved cache lines
 * <samp>
 * c5b5533c8475801044fb7680059d5846|#|1306781298|#|frozeman|#|websiteSetup|#|edit
 * 4afe1d41e2f2edbf07086b1c2c492c10|#|1306781299|#|test|#|websiteSetup
 * </samp>
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
  $cacheFile = dirname(__FILE__)."/../../statistic/user.statistic.cache";
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
      if(isset($cachedLineArray[4]) && IDENTITY != trim($cachedLineArray[0]) && trim($cachedLineArray[3]) == $location) $free = false;
    }
    
    foreach($cachedLines as $cachedLine) {
      $cachedLineArray = explode('|#|', $cachedLine);
      
      // stores the user AGAIN with new timestamp, if the user was less than $maxTime on the page,
      // otherwise remove the user form the cache (dont save his line)
      if(!empty($location) && $timeStamp - $cachedLineArray[1] < $maxTime) {
        
        if($cachedLineArray[0] == IDENTITY) {
          $edit = ($free) ? '|#|edit' : false;
          
          $newLines[] = IDENTITY.'|#|'.$timeStamp.'|#|'.$_SESSION['feinduraSession']['login']['username'].'|#|'.$location.$edit;
          $addArray = array('identity' => IDENTITY, 'timestamp' => $timeStamp, 'username' => $_SESSION['feinduraSession']['login']['username'], 'location' => $location);
          
          if($free) $addArray['edit'] = true;
          $return[] = $addArray;
          $stored = true;
        } elseif(!empty($cachedLineArray[0])) {
          $newLines[] = $cachedLine;
          
          $addArray = array('identity' => $cachedLineArray[0], 'timestamp' => $cachedLineArray[1], 'username' => $cachedLineArray[2], 'location' => trim($cachedLineArray[3]));
          
          if(isset($cachedLineArray[4])) $addArray['edit'] = true;
          $return[] = $addArray;
        }
      }
    }
  }

  // STORE NEW CACHE LINE
  if($stored === false && !empty($location)) {
    $edit = ($free) ? '|#|edit' : false;
    $newLines[] = IDENTITY.'|#|'.$timeStamp.'|#|'.$_SESSION['feinduraSession']['login']['username'].'|#|'.$location.$edit;
    $addArray = array('identity' => IDENTITY, 'timestamp' => $timeStamp, 'username' => $_SESSION['feinduraSession']['login']['username'], 'location' => $location);
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
 *    - <var>$GeneralFunctions</var> for the {@link getStoredPagesIds} (included in the {@link general.include.php})
 * 
 * @return int a new page ID
 * 
 * 
 * @version 1.0
 * <br>
 * <b>ChangeLog</b><br>
 *    - 1.0 initial release
 * 
 */
function getNewPageId() {
  
  // loads the file list in an array
  $pages = GeneralFunctions::getStoredPageIds();
  
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
 * <b>Name</b> createBasicFolders()<br>
 * 
 * Check if the config, pages and statistic folders exist, if not try to create these.
 * 
 * 
 * @version 1.0.1
 * <br>
 * <b>ChangeLog</b><br>
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
 * <b>Name</b> saveCategories()<br>
 * 
 * Saves the category-settings config array to the "config/category.config.php" file.
 * 
 * <b>Used Constants</b><br>
 *    - <var>PHPSTARTTAG</var> the php start tag
 *    - <var>PHPENDTAG</var> the php end tag
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
 * @version 1.2
 * <br>
 * <b>ChangeLog</b><br>
 *    - 1.2 add localization
 *    - 1.1 change from fopen() to file_put_contents()
 *    - 1.0.2 add prevent resetting check
 *    - 1.0.1 add XssFilter to every value
 *    - 1.0 initial release
 * 
 */
function saveCategories($newCategories) {
  
  // prevent resetting config
  if($newCategories !== 1) {
    
    // CREATE file content
    $fileContent = '';
    $fileContent .= PHPSTARTTAG; //< ?php
    
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
      $category['styleFile'] = setStylesByPriority($category['styleFile'],'styleFile',true);
      $category['styleId'] = setStylesByPriority($category['styleId'],'styleId',true);
      $category['styleClass'] = setStylesByPriority($category['styleClass'],'styleClass',true);        
      
      // WRITE
      $fileContent .= "\$categoryConfig[".$category['id']."]['id'] =                 ".XssFilter::int($category['id'],0).";\n";      
      $fileContent .= "\$categoryConfig[".$category['id']."]['public'] =             ".XssFilter::bool($category['public'],true).";\n";
      $fileContent .= "\$categoryConfig[".$category['id']."]['createDelete'] =       ".XssFilter::bool($category['createDelete'],true).";\n";
      $fileContent .= "\$categoryConfig[".$category['id']."]['thumbnail'] =          ".XssFilter::bool($category['thumbnail'],true).";\n";        
      $fileContent .= "\$categoryConfig[".$category['id']."]['plugins'] =            '".$category['plugins']."';\n";
      $fileContent .= "\$categoryConfig[".$category['id']."]['showTags'] =           ".XssFilter::bool($category['showTags'],true).";\n";
      $fileContent .= "\$categoryConfig[".$category['id']."]['showPageDate'] =       ".XssFilter::bool($category['showPageDate'],true).";\n";
      $fileContent .= "\$categoryConfig[".$category['id']."]['feeds'] =              ".XssFilter::bool($category['feeds'],true).";\n\n";
      
      $fileContent .= "\$categoryConfig[".$category['id']."]['sorting'] =            '".XssFilter::alphabetical($category['sorting'],'manually')."';\n";
      $fileContent .= "\$categoryConfig[".$category['id']."]['sortReverse'] =        ".XssFilter::bool($category['sortReverse'],true).";\n\n";
      
      $fileContent .= "\$categoryConfig[".$category['id']."]['styleFile'] =          '".$category['styleFile']."';\n"; //XssFilter is in prepareStyleFilePaths() function
      $fileContent .= "\$categoryConfig[".$category['id']."]['styleId'] =            '".XssFilter::string($category['styleId'])."';\n";
      $fileContent .= "\$categoryConfig[".$category['id']."]['styleClass'] =         '".XssFilter::string($category['styleClass'])."';\n\n";
      
      $fileContent .= "\$categoryConfig[".$category['id']."]['thumbWidth'] =         '".XssFilter::int($category['thumbWidth'])."';\n";
      $fileContent .= "\$categoryConfig[".$category['id']."]['thumbHeight'] =        '".XssFilter::int($category['thumbHeight'])."';\n";
      $fileContent .= "\$categoryConfig[".$category['id']."]['thumbRatio'] =         '".XssFilter::alphabetical($category['thumbRatio'])."';\n\n";
      
      // save localized
      if(is_array($category['localized'])) {
        foreach ($category['localized'] as $langCode => $categoryLocalized) {

          // remove the '' when its 0 (for non localized pages)
          $langCode = (is_numeric($langCode)) ? $langCode : "'".$langCode."'";

          $fileContent .= "\$categoryConfig[".$category['id']."]['localized'][".$langCode."]['name']   = '".XssFilter::text($categoryLocalized['name'])."';\n";
         }
      }
      $fileContent .= "\n\n";

    }    
    $fileContent .= 'return $categoryConfig;';
    $fileContent .= PHPENDTAG; //? >
    
    // -> SAVE the flat file
    if(file_put_contents(dirname(__FILE__)."/../../config/category.config.php", $fileContent, LOCK_EX)) {
      // reset the stored page ids
      GeneralFunctions::$storedPageIds = null;
      return true;
    } else
      return false;
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
 * @version 1.0
 * <br>
 * <b>ChangeLog</b><br>
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
      echo '';
      $categoryConfig[$sortetCategory['id']] = $sortetCategory;
    }
    
    return true;
  
  } else
    return false;
}

/**
 * <b>Name</b> movePage()<br>
 * 
 * Moves a file into a new category directory.
 * 
 * <b>Used Global Variables</b><br>
 *    - <var>$adminConfig</var> the administrator-settings config (included in the {@link general.include.php})
 *    - <var>$GeneralFunctions</var> to reset the {@link getStoredPagesIds} (included in the {@link general.include.php})
 * 
 * @param int $page         the page ID
 * @param int $fromCategory the ID of the category where the page is situated
 * @param int $toCategory   the ID of the category where the file will be moved to 
 * 
 * @return bool TRUE if the page was succesfull moved, otherwise FALSE
 * 
 * @version 1.01
 * <br>
 * <b>ChangeLog</b><br>
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
    GeneralFunctions::$storedPages = null;
    GeneralFunctions::$storedPageIds = null;
    
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
 *    - <var>PHPSTARTTAG</var> the php start tag
 *    - <var>PHPENDTAG</var> the php end tag
 * 
 * @param array $adminConfig a $adminConfig array to save
 * 
 * @return bool TRUE if the file was succesfull saved, otherwise FALSE
 * 
 * @example backend/adminConfig.array.example.php of the $adminConfig array
 * 
 * @version 1.2
 * <br>
 * <b>ChangeLog</b><br>
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
    
    // clear the thumbnail path, when no upload path is specified
    if(empty($adminConfig['uploadPath'])) $adminConfig['pageThumbnail']['path'] = '';
    // -> CHECK depency of PAGEDATE
    if(!isset($adminConfig['pages']['showPageDate']) && $adminConfig['pages']['sorting'] == 'byPageDate' && $GLOBALS['adminConfig']['pages']['showPageDate'])
      $adminConfig['pages']['sorting'] = 'manually';
    
    if($adminConfig['pages']['sorting'] == 'byPageDate' && !isset($adminConfig['pages']['showPageDate']))
      $adminConfig['pages']['showPageDate'] = 'true';
    
    // -> escape \ and '
    $adminConfig = XssFilter::escapeBasics($adminConfig);
    
    $permissions = (is_string($adminConfig['permissions']))
       ? octdec($adminConfig['permissions'])
       : $adminConfig['permissions'];
    
    @chmod(dirname(__FILE__)."/../../config/admin.config.php", $permissions);

    // CREATE file content
    $fileContent = '';
    $fileContent .= PHPSTARTTAG; // < ?php

    $fileContent .= "\$adminConfig['url']               = '".XssFilter::url($adminConfig['url'])."';\n";
    $fileContent .= "\$adminConfig['basePath']          = '".XssFilter::path($adminConfig['basePath'])."';\n";
    $fileContent .= "\$adminConfig['realBasePath']      = '".XssFilter::path($adminConfig['realBasePath'])."';\n";
    $fileContent .= "\$adminConfig['websitePath']       = '".XssFilter::path($adminConfig['websitePath'],false,'/')."';\n";
    $fileContent .= "\$adminConfig['uploadPath']        = '".XssFilter::path($adminConfig['uploadPath'])."';\n";
    $fileContent .= "\$adminConfig['websiteFilesPath']  = '".XssFilter::path($adminConfig['websiteFilesPath'])."';\n";
    $fileContent .= "\$adminConfig['stylesheetPath']    = '".XssFilter::path($adminConfig['stylesheetPath'])."';\n\n";
    
    $fileContent .= "\$adminConfig['permissions']       = ".XssFilter::number($adminConfig['permissions']).";\n";
    $fileContent .= "\$adminConfig['timezone']          = '".XssFilter::string($adminConfig['timezone'],'\/','Europe/London')."';\n"; 
    $fileContent .= "\$adminConfig['dateFormat']        = '".XssFilter::alphabetical($adminConfig['dateFormat'])."';\n";
    $fileContent .= "\$adminConfig['speakingUrl']       = ".XssFilter::bool($adminConfig['speakingUrl'],true).";\n\n";
    
    $fileContent .= "\$adminConfig['varName']['page']      = '".XssFilter::stringStrict($adminConfig['varName']['page'],'page')."';\n";  
    $fileContent .= "\$adminConfig['varName']['category']  = '".XssFilter::stringStrict($adminConfig['varName']['category'],'category')."';\n";  
    $fileContent .= "\$adminConfig['varName']['modul']     = '".XssFilter::stringStrict($adminConfig['varName']['modul'],'modul')."';\n\n";

    $fileContent .= "\$adminConfig['cache']['active']      = '".XssFilter::bool($adminConfig['cache']['active'],false)."';\n";
    $fileContent .= "\$adminConfig['cache']['timeout']     = '".XssFilter::number($adminConfig['cache']['timeout'],5)."';\n\n";
    
    $fileContent .= "\$adminConfig['user']['frontendEditing']   = ".XssFilter::bool($adminConfig['user']['frontendEditing'],true).";\n";
    $fileContent .= "\$adminConfig['user']['fileManager']       = ".XssFilter::bool($adminConfig['user']['fileManager'],true).";\n";
    $fileContent .= "\$adminConfig['user']['editWebsiteFiles']  = ".XssFilter::bool($adminConfig['user']['editWebsiteFiles'],true).";\n";
    $fileContent .= "\$adminConfig['user']['editStyleSheets']   = ".XssFilter::bool($adminConfig['user']['editStyleSheets'],true).";\n";  
    $fileContent .= "\$adminConfig['user']['info']              = '".$adminConfig['user']['info']."';\n\n"; // htmLawed in adminSetup.controller.php
    
    $fileContent .= "\$adminConfig['setStartPage']                         = ".XssFilter::bool($adminConfig['setStartPage'],true).";\n";
    $fileContent .= "\$adminConfig['multiLanguageWebsite']['active']       = ".XssFilter::bool($adminConfig['multiLanguageWebsite']['active'],true).";\n";
    if(is_array($adminConfig['multiLanguageWebsite']['languages'])) {
      foreach ($adminConfig['multiLanguageWebsite']['languages'] as $langKey) {
        $fileContent .= "\$adminConfig['multiLanguageWebsite']['languages'][]    = ".XssFilter::alphabetical($langKey,$_SESSION['feinduraSession']['backendLanguage']).";\n";
      }
    }
    $fileContent .= "\$adminConfig['multiLanguageWebsite']['mainLanguage']   = ".XssFilter::alphabetical($adminConfig['multiLanguageWebsite']['mainLanguage'],0).";\n\n";

    $fileContent .= "\$adminConfig['pages']['createDelete']  = ".XssFilter::bool($adminConfig['pages']['createDelete'],true).";\n";
    $fileContent .= "\$adminConfig['pages']['thumbnails']    = ".XssFilter::bool($adminConfig['pages']['thumbnails'],true).";\n";    
    $fileContent .= "\$adminConfig['pages']['plugins']       = '".$adminConfig['pages']['plugins']."';\n"; // no XssFilter, comes from a <select>
    $fileContent .= "\$adminConfig['pages']['showTags']      = ".XssFilter::bool($adminConfig['pages']['showTags'],true).";\n";
    $fileContent .= "\$adminConfig['pages']['showPageDate']  = ".XssFilter::bool($adminConfig['pages']['showPageDate'],true).";\n";
    $fileContent .= "\$adminConfig['pages']['feeds']         = ".XssFilter::bool($adminConfig['pages']['feeds'],true).";\n\n";
    
    $fileContent .= "\$adminConfig['pages']['sorting']       = '".XssFilter::alphabetical($adminConfig['pages']['sorting'],'manually')."';\n";
    $fileContent .= "\$adminConfig['pages']['sortReverse']   = ".XssFilter::bool($adminConfig['pages']['sortReverse'],true).";\n\n";
    
    $fileContent .= "\$adminConfig['editor']['htmlLawed']    = ".XssFilter::bool($adminConfig['editor']['htmlLawed'],true).";\n";
    $fileContent .= "\$adminConfig['editor']['safeHtml']     = ".XssFilter::bool($adminConfig['editor']['safeHtml'],true).";\n";
    $fileContent .= "\$adminConfig['editor']['enterMode']    = '".XssFilter::alphabetical($adminConfig['editor']['enterMode'])."';\n";
    $fileContent .= "\$adminConfig['editor']['styleFile']    = '".$adminConfig['editor']['styleFile']."';\n"; // XssFilter is in prepareStyleFilePaths() function
    $fileContent .= "\$adminConfig['editor']['styleId']      = '".XssFilter::string($adminConfig['editor']['styleId'])."';\n";
    $fileContent .= "\$adminConfig['editor']['styleClass']   = '".XssFilter::string($adminConfig['editor']['styleClass'])."';\n\n";  
  
    $fileContent .= "\$adminConfig['pageThumbnail']['width']   = '".XssFilter::int($adminConfig['pageThumbnail']['width'])."';\n";
    $fileContent .= "\$adminConfig['pageThumbnail']['height']  = '".XssFilter::int($adminConfig['pageThumbnail']['height'])."';\n";
    $fileContent .= "\$adminConfig['pageThumbnail']['ratio']   = '".XssFilter::alphabetical($adminConfig['pageThumbnail']['ratio'])."';\n";
    $fileContent .= "\$adminConfig['pageThumbnail']['path']    = '".XssFilter::path($adminConfig['pageThumbnail']['path'],false,(empty($adminConfig['uploadPath'])) ? '' : 'thumbnails/')."';\n\n";
    
    $fileContent .= "return \$adminConfig;";
    $fileContent .= PHPENDTAG; //? >
    
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
 *    - <var>PHPSTARTTAG</var> the php start tag
 *    - <var>PHPENDTAG</var> the php end tag
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
    $fileContent .= PHPSTARTTAG; //< ?php
    foreach($userConfig as $user => $configs) {

      $fileContent .= "\$userConfig['".$user."']['id']       = ".XssFilter::int($configs['id'],0).";\n";
      $fileContent .= "\$userConfig['".$user."']['admin']    = ".XssFilter::bool($configs['admin'],true).";\n";
      $fileContent .= "\$userConfig['".$user."']['username'] = '".XssFilter::text($configs['username'])."';\n";
      $fileContent .= "\$userConfig['".$user."']['email']    = '".XssFilter::string($configs['email'])."';\n";
      $fileContent .= "\$userConfig['".$user."']['password'] = '".XssFilter::text($configs['password'])."';\n";
      
      $fileContent .= "\n";
    }      
    $fileContent .= "return \$userConfig;";
  
    $fileContent .= PHPENDTAG; //? >

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
 *    - <var>PHPSTARTTAG</var> the php start tag
 *    - <var>PHPENDTAG</var> the php end tag
 * 
 * @param array $websiteConfig a $websiteConfig array to save
 * 
 * @return bool TRUE if the file was succesfull saved, otherwise FALSE
 * 
 * @example backend/websiteConfig.array.example.php of the $websiteConfig array
 * 
 * @version 1.2
 * <br>
 * <b>ChangeLog</b><br>
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
    $fileContent .= PHPSTARTTAG; //< ?php

    $fileContent .= "\$websiteConfig['startPage']      = ".XssFilter::int($websiteConfig['startPage'],0).";\n\n";

    // save localized
    if(is_array($websiteConfig['localized'])) {
      foreach ($websiteConfig['localized'] as $langCode => $websiteConfigLocalized) {

        // remove the '' when its 0 (for non localized pages)
        $langCode = (is_numeric($langCode)) ? $langCode : "'".$langCode."'";

        $fileContent .= "\$websiteConfig['localized'][".$langCode."]['title']          = '".XssFilter::text($websiteConfigLocalized['title'])."';\n";
        $fileContent .= "\$websiteConfig['localized'][".$langCode."]['publisher']      = '".XssFilter::text($websiteConfigLocalized['publisher'])."';\n";
        $fileContent .= "\$websiteConfig['localized'][".$langCode."]['copyright']      = '".XssFilter::text($websiteConfigLocalized['copyright'])."';\n";
        $fileContent .= "\$websiteConfig['localized'][".$langCode."]['keywords']       = '".XssFilter::text(trim(preg_replace("#[\; ,]+#", ',', $websiteConfigLocalized['keywords']),','))."';\n";
        $fileContent .= "\$websiteConfig['localized'][".$langCode."]['description']    = '".XssFilter::text($websiteConfigLocalized['description'])."';\n\n";
      }
    }
    
    $fileContent .= "return \$websiteConfig;";
  
    $fileContent .= PHPENDTAG; //? >

    // -> SAVE the flat file
    if(file_put_contents(dirname(__FILE__)."/../../config/website.config.php", $fileContent, LOCK_EX))
      return true;
    else
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
 *    - <var>PHPSTARTTAG</var> the php start tag
 *    - <var>PHPENDTAG</var> the php end tag
 * 
 * @param array $statisticConfig a $statisticConfig array to save
 * 
 * @return bool TRUE if the file was succesfull saved, otherwise FALSE
 * 
 * @example backend/statisticConfig.array.example.php of the $statisticConfig array
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
function saveStatisticConfig($statisticConfig) {
   
  // prevent resetting config
  if($statisticConfig !== 1) {
    
    // -> escape \ and '
    $statisticConfig = XssFilter::escapeBasics($statisticConfig);
    
    /// CREATE file content
    $fileContent = '';
    $fileContent .= PHPSTARTTAG; //< ?php

    $fileContent .= "\$statisticConfig['number']['mostVisitedPages']        = ".XssFilter::int($statisticConfig['number']['mostVisitedPages'],10).";\n";
    $fileContent .= "\$statisticConfig['number']['longestVisitedPages']     = ".XssFilter::int($statisticConfig['number']['longestVisitedPages'],10).";\n";
    $fileContent .= "\$statisticConfig['number']['lastVisitedPages']        = ".XssFilter::int($statisticConfig['number']['lastVisitedPages'],10).";\n";
    $fileContent .= "\$statisticConfig['number']['lastEditedPages']         = ".XssFilter::int($statisticConfig['number']['lastEditedPages'],10).";\n\n";
    
    $fileContent .= "\$statisticConfig['number']['refererLog']    = ".XssFilter::int($statisticConfig['number']['refererLog'],100).";\n";
    $fileContent .= "\$statisticConfig['number']['taskLog']       = ".XssFilter::int($statisticConfig['number']['taskLog'],50).";\n\n";
    
    $fileContent .= "return \$statisticConfig;";
  
    $fileContent .= PHPENDTAG; //? >

    // -> SAVE the flat file
    if(file_put_contents(dirname(__FILE__)."/../../config/statistic.config.php", $fileContent, LOCK_EX))
      return true;
    else
      return false;
  } else
    return false;
}

/**
 * <b>Name</b> saveSpeakingUrl()<br>
 * 
 * Check if speakingUrl is activated and save a speakingUrl redirect (with mod_rewrite) to the .htacces file in the document root.
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
 * @param false|string $errorWindow will be filled with an error message if an error occurs
 * 
 * @return void
 * 
 * 
 * @version 1.0.2
 * <br>
 * <b>ChangeLog</b><br>
 *    - 1.0.2 add "(?:[a-z]{2}/{1})?" to allow "en/" etc.
 *    - 1.0.1 small fix with website path; add GeneralFunctions::getRealPath()
 *    - 1.0 initial release
 * 
 */
function saveSpeakingUrl(&$errorWindow) {
  
  // vars
  $save = false;
  $data = false;
  $websitePath = GeneralFunctions::getDirname($_POST['cfg_websitePath']);
  $websitePath = (empty($websitePath)) ? '/': $websitePath;
  $websitePath = GeneralFunctions::getRealPath($websitePath);
  if($websitePath === false) {
    $_POST['cfg_speakingUrl'] = '';
    return false;
  }
  $htaccessFile = $websitePath.'/.htaccess';
  $newWebsitePath = substr(GeneralFunctions::getDirname(XssFilter::path($_POST['cfg_websitePath'])),1);
  $oldWebsitePath = substr(GeneralFunctions::getDirname(XssFilter::path($GLOBALS['adminConfig']['websitePath'])),1);
  
  $newRewriteRule = 'RewriteRule ^'.$newWebsitePath.'(?:([a-z]{2})/{1})?category/([a-z0-9_-]+)/([a-z0-9_-]+).*?$ '.XssFilter::path($_POST['cfg_websitePath']).'?category=$2&page=$3&language=$1 [QSA,L]'."\n";
  $newRewriteRule .= 'RewriteRule ^'.$newWebsitePath.'(?:([a-z]{2})/{1})?page/([a-z0-9_-]+).*?$ '.XssFilter::path($_POST['cfg_websitePath']).'?page=$2&language=$1 [QSA,L]';
  $oldRewriteRule = 'RewriteRule ^'.$oldWebsitePath.'(?:([a-z]{2})/{1})?category/([a-z0-9_-]+)/([a-z0-9_-]+).*?$ '.XssFilter::path($GLOBALS['adminConfig']['websitePath']).'?category=$2&page=$3&language=$1 [QSA,L]'."\n";
  $oldRewriteRule .= 'RewriteRule ^'.$oldWebsitePath.'(?:([a-z]{2})/{1})?page/([a-z0-9_-]+).*?$ '.XssFilter::path($GLOBALS['adminConfig']['websitePath']).'?page=$2&language=$1 [QSA,L]';
  
  $speakingUrlCode = '#
# feindura -flat file cms - speakingURL activation
#
<IfModule mod_rewrite.c>
RewriteEngine on
RewriteBase /
# rewrite "/page/*.html" and "/category/*/*.html"
# and also passes the session var
RewriteCond %{REQUEST_URI} !\.(css|jpg|gif|png|js)$ [NC] #do the stuff that follows only if the request doesnt end in one of these file extensions.
RewriteCond %{HTTP_HOST} ^'.str_replace(array('http://www.','https://www.','http://','https://'),'',$_SERVER["HTTP_HOST"]).'$
'.$newRewriteRule.'
</IfModule>';
  
  $oldSpeakingUrlCode = str_replace($newRewriteRule,$oldRewriteRule,$speakingUrlCode);
  
  // -> looks if the MOD_REWRITE modul exists
  $apacheModules = (function_exists('apache_get_modules')) ? apache_get_modules() : array('mod_rewrite');
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
  if($save && !empty($data)) {
    
    $data = preg_replace("#\\n+$#","\n",$data); // prevent growing of the file with line endings
    
    // -> SAVE the .htaccess
    file_put_contents($htaccessFile, $data, LOCK_EX);
    
    @chmod($htaccessFile,0644);
  
  // ->> throw error
  } elseif($save) {
    $_POST['cfg_speakingUrl'] = '';
    $errorWindow .= $GLOBALS['langFile']['ADMINSETUP_GENERAL_speakingUrl_error_save'];
  }
  
  return;
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
  $backupName = 'feinduraBackup_'.$_SERVER['SERVER_NAME'].$websitePath.'_'.date('Y-m-d_H-i').$backupAppendix.'.zip';
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
  $catchError = $archive->add('config/,statistic/,pages/',PCLZIP_OPT_REMOVE_PATH, $GLOBALS['adminConfig']['realBasePath']);//,PCLZIP_OPT_SET_CHMOD,$GLOBALS['adminConfig']['permissions']);
  
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
 * @version 1.01
 * <br>
 * <b>ChangeLog</b><br>
 *    - add XssFilter test 
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
        $styleFile = XssFilter::path($styleFile);
      
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
 * Ff the <var>$givenStyle</var> parameter is empty,
 * it check if the category has a styleheet-file path, ID or class-attribute set return the value if not return the value from the {@link $adminConfig administartor-settings config}.
 * 
 * <b>Used Global Variables</b><br>
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
 * <br>
 * <b>ChangeLog</b><br>
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
 * <b>Name</b> showStyleFileInputs()<br>
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
      $return .= '<input name="'.$inputNames.'[]" value="'.$styleFileInput.'">';
    }
  } else
    $return = '<input class="noResize" name="'.$inputNames.'[]" value="">';
  
  // return the result
  return $return;
}

/**
 * <b>Name</b> showPageDate()<br>
 * 
 * Shows the page date, if the date is invalid it shows an error text.
 * 
 * <b>Used Global Variables</b><br>
 *    - <var>$langFile</var> the language file of the backend (included in the {@link general.include.php})
 * 
 * @param array        $pageContent  the $pageContent array of a page
 * 
 * @uses StatisticFunctions::checkPageDate()      to check if the page date is a valid date
 * @uses StatisticFunctions::dateDayBeforeAfter() to check if the date was yesterday or is tomorrow
 * @uses StatisticFunctions::formatDate()         to format the unix timstamp into the right date format
 * 
 * @return string the page date as text string, or an error text
 * 
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
  
  if(StatisticFunctions::checkPageDate($pageContent)) {
    $pageDate = GeneralFunctions::getLocalized($pageContent['localized'],'pageDate');
    $pageDateBefore = $pageDate['before'];
    $pageDateAfter = $pageDate['after'];
  	// adds spaces on before and after
  	if(!empty($pageDateBefore)) $titleDateBefore = $pageDateBefore.' ';
  	if(!empty($pageDateAfter)) $titleDateAfter = ' '.$pageDateAfter;

    // CHECKs the DATE FORMAT
    $return = (StatisticFunctions::validateDateFormat(StatisticFunctions::formatDate($pageContent['pageDate']['date'])) === false)
    ? '[br][b]'.$GLOBALS['langFile']['SORTABLEPAGELIST_TIP_PAGEDATE'].':[/b] '.$titleDateBefore.'[span style=color:#950300]'.$GLOBALS['langFile']['EDITOR_pageSettings_pagedate_error'].':[/span][br] '.$pageContent['pageDate']['date'].$titleDateAfter
    : '[br][b]'.$GLOBALS['langFile']['SORTABLEPAGELIST_TIP_PAGEDATE'].':[/b] '.$titleDateBefore.StatisticFunctions::formatDate(StatisticFunctions::dateDayBeforeAfter($pageContent['pageDate']['date'],$GLOBALS['langFile'])).$titleDateAfter;
  }    
  return $return;
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
 *    - <var>$savedForm</var> the variable to tell which form was saved (set in the {@link saveEditedFiles})
 * 
 * @param string		$filesPath	         the path where all files (also files in subfolders) will be shown for editing
 * @param string		$status		           a status name which will be set to the $_GET['status'] variable in the formular action attribute
 * @param string		$titleText	         a title text which will be displayed as the title of the edit files textfield
 * @param string		$anchorName	         the name of the anchor which will be added to the formular action attribute
 * @param string|false		$fileType      (optional) a filetype which will be added to each ne created file
 * @param string|array|false	$excluded	 (optional) a string (seperated with ",") or array with files or folder names which should be excluded from the file selection, if FALSE no file will be excluded
 * 
 * @uses GeneralFunctions::readFolderRecursive()	reads the $filesPath folder recursive and loads all file paths in an array
 * 
 * @return void displayes the file edit textfield
 * 
 * @version 1.01
 * <br>
 * <b>ChangeLog</b><br>
 *    - 1.01 put fileType to the classe instead of the id of the textarea
 *    - 1.0 initial release
 * 
 */
function editFiles($filesPath, $status, $titleText, $anchorName, $fileType = false, $excluded = false) {
  
  // var
  $fileTypeText = null;
  $isFiles = false;
  $_GET['file'] = XssFilter::path($_GET['file']);
  
  // shows the block below if it is the ones which is saved before
  $hidden = ($_GET['status'] == $status || $GLOBALS['savedForm'] === $status) ? '' : ' hidden';

  echo '<form action="index.php?site='.$_GET['site'].'#'.$anchorName.'" method="post" enctype="multipart/form-data" accept-charset="UTF-8">
        <div>
        <input type="hidden" name="send" value="saveEditedFiles">
        <input type="hidden" name="status" value="'.$status.'">
        <input type="hidden" name="filesPath" value="'.$filesPath.'">';
  if($fileType)
    echo '<input type="hidden" name="fileType" value=".'.$fileType.'">';
  echo '</div>';
  
  echo '<div class="block'.$hidden.'">
          <h1><a href="#" name="'.$anchorName.'" id="'.$anchorName.'">'.$titleText.'</a></h1>
          <div class="content editFiles"><br>';
      
  //echo $filesPath.'<br>';      
  // gets the files out of the directory --------------
  // adds the DOCUMENTROOT  
  $filesPath = str_replace(DOCUMENTROOT,'',$filesPath);  
  $dir = DOCUMENTROOT.$filesPath;
  if(!empty($filesPath) && is_dir($dir)) {
    $files = GeneralFunctions::readFolderRecursive($filesPath);
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
            <input value="'.$filesPath.'" readonly="readonly" style="width:auto;" size="'.(strlen($filesPath)-2).'">'."\n";
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
          <input name="newFile" style="width:200px;" class="thumbnailToolTip" title="'.$GLOBALS['langFile']['editFilesSettings_createFile'].'::'.$GLOBALS['langFile']['editFilesSettings_createFile_inputTip'].'"> '.$fileTypeText.'
          </div>';
  }
  
  // OPEN THE FILE -------------------------------------
  if(@is_file(DOCUMENTROOT.$editFile)) {
    $editFileOpen = fopen(DOCUMENTROOT.$editFile,"r");  
    $file = @fread($editFileOpen,filesize(DOCUMENTROOT.$editFile));
    fclose($editFileOpen);
    $file = str_replace(array('<','>'),array('&lt;','&gt;'),$file);
    
    echo '<input type="hidden" name="file" value="'.$editFile.'">'."\n";
    echo '<textarea name="fileContent" cols="90" rows="30" class="editFiles '.substr($editFile, strrpos($editFile, '.') + 1).'" id="editFiles'.uniqid().'">'.$file.'</textarea>';
  }  
  
  
  if($isDir) {
    if($isFiles)
      echo '<a href="?site='.$_GET['site'].'&amp;status=deleteEditFiles&amp;editFilesStatus='.$status.'&amp;file='.$editFile.'#'.$anchorName.'" onclick="openWindowBox(\'library/views/windowBox/deleteEditFiles.php?site='.$_GET['site'].'&amp;status=deleteEditFiles&amp;editFilesStatus='.$status.'&amp;file='.$editFile.'&amp;anchorName='.$anchorName.'\',\''.$GLOBALS['langFile']['editFilesSettings_deleteFile'].'\');return false;" class="cancel left toolTip" title="'.$GLOBALS['langFile']['editFilesSettings_deleteFile'].'::" style="float:left;"></a>';
    echo '<br><br><input type="submit" value="" name="saveEditedFiles" class="button submit right" title="'.$GLOBALS['langFile']['FORM_BUTTON_SUBMIT'].'">';
  }
  echo '</div>
      <div class="bottom"></div>
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
 * @param string &$savedForm	to set which form was is saved
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
function saveEditedFiles(&$savedForm) {

  // var
  $_POST['filesPath'] = DOCUMENTROOT.str_replace(DOCUMENTROOT,'',$_POST['filesPath']);
  // add DOCUMENTROOT
  $_POST['file'] = XssFilter::path($_POST['file']);
  $_POST['file'] = str_replace(DOCUMENTROOT,'',$_POST['file']);  
  $_POST['file'] = DOCUMENTROOT.$_POST['file'];
  
  // ->> SAVE FILE
  if(@is_file($_POST['file']) && empty($_POST['newFile'])) {
    
    // encode when ISO-8859-1
    if(mb_detect_encoding($_POST['fileContent']) == 'ISO-8859-1') $_POST['fileContent'] = utf8_encode($_POST['fileContent']);
    $_POST['fileContent'] = GeneralFunctions::smartStripslashes($_POST['fileContent']);
    $_POST['fileContent'] = preg_replace("#\\n#","",$_POST['fileContent']); // prevent double line breaks
    
    // -> SAVE
    if(file_put_contents($_POST['file'],$_POST['fileContent'],LOCK_EX) !== false) {
      
      @chmod($_POST['file'], $GLOBALS['adminConfig']['permissions']);
      $_GET['file'] = str_replace(DOCUMENTROOT,'',$_POST['file']);
      $_GET['status'] = $_POST['status'];
      $savedForm = $_POST['status'];
    
      return true;      
    } else
      return false;
    
  // ->> NEW FILE
  } elseif(!empty($_POST['newFile'])) { // creates a new file if a filename was input in the field
        
    //$_POST['newFile'] = str_replace( array(" ","%","+","&","#","!","?","$","§",'"',"'","(",")"), '_', $_POST['newFile']);
    $_POST['newFile'] = XssFilter::path($_POST['newFile'],false,'noname.txt');
    
    // check if a path is included
    if(strpos($_POST['newFile'],'/') !== false) {
      $directory = substr($_POST['newFile'],0,strrpos($_POST['newFile'],'/'));
      $directory = preg_replace("/\/+/", '/', $_POST['filesPath'].'/'.$directory);
      if(!is_dir($directory))
        mkdir($directory,$GLOBALS['admimConfig']['permissions'],true);
      $_POST['filesPath'] = $directory;
      $_POST['newFile'] = substr($_POST['newFile'],strrpos($_POST['newFile'],'/')+1);
    }
    
    $_POST['newFile'] = GeneralFunctions::cleanSpecialChars($_POST['newFile'],'_');
    $_POST['newFile'] = str_replace($_POST['fileType'],'',$_POST['newFile']);
    
    $fullFilePath = $_POST['filesPath'].'/'.$_POST['newFile'].$_POST['fileType'];
    $fullFilePath = preg_replace("/\/+/", '/', $fullFilePath);
    
    if($file = fopen($fullFilePath,"wb")) {
    
      @chmod($fullFilePath, $GLOBALS['adminConfig']['permissions']);  
      $_GET['file'] = str_replace(DOCUMENTROOT,'',$fullFilePath);       
      $_GET['status'] = $_POST['status'];
      $savedForm = $_POST['status'];
      
      return true;
    } else
      return false;
  }
}

/**
 * <b>Name</b> delDir()<br>
 * 
 * Deletes a directory and all files in it.
 * 
 * @param string $dir the absolute path to the directory which will be deleted 
 * 
 * @return bool TRUE if the directory was succesfull deleted, otherwise FALSE
 * 
 * @version 1.0
 * <br>
 * <b>ChangeLog</b><br>
 *    - 1.0 initial release
 * 
 */
function delDir($dir) {

    $filesFolders = GeneralFunctions::readFolderRecursive($dir);
    
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
      $checkFilesFolders = GeneralFunctions::readFolderRecursive($dir);
      
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
  
  $fileFolder = GeneralFunctions::getRealPath($fileFolder);

  if(file_exists($fileFolder) && is_writable($fileFolder) === false) {
    return '<span class="warning toolTip" title="'.$fileFolder.'::'.sprintf($GLOBALS['langFile']['ADMINSETUP_TOOLTIP_WRITEACCESSERROR'],$GLOBALS['adminConfig']['permissions']).'"><b>&quot;'.$fileFolder.'&quot;</b> -> '.$GLOBALS['langFile']['ADMINSETUP_TEXT_WRITEACCESSERROR'].'</span><br>';
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
  $baseUrl = preg_replace('#^[a-zA-Z]+[:]{1}[\/\/]{2}|w{3}\.#','',$GLOBALS['adminConfig']['url']);
  $checkUrl = preg_replace('#^[a-zA-Z]+[:]{1}[\/\/]{2}|w{3}\.#','',$_SERVER["SERVER_NAME"]);
  
  $checkPath = preg_replace('#/+#','/',dirname($_SERVER['PHP_SELF']).'/');
  
  if($GLOBALS['adminConfig']['basePath'] == $checkPath &&
     $baseUrl == $checkUrl)
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
  if(checkBasePathAndURL() && (DOCUMENTROOT === false || empty($GLOBALS['adminConfig']['realBasePath']))) {
    return '<div class="block warning">
            <h1>'.$GLOBALS['langFile']['WARNING_TITLE_DOCUMENTROOT'].'</h1>
            <div class="content">
              <p>'.$GLOBALS['langFile']['WARNING_TEXT_DOCUMENTROOT'].'</p><!-- need <p> tags for margin-left:..--> 
            </div> 
            <div class="bottom"></div> 
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
    return '<div class="block warning">
            <h1>'.$GLOBALS['langFile']['WARNING_TITLE_BASEPATH'].'</h1>
            <div class="content">
              <p>'.$GLOBALS['langFile']['WARNING_TEXT_BASEPATH'].'</p><!-- need <p> tags for margin-left:..--> 
            </div> 
            <div class="bottom"></div> 
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
  
  if($GLOBALS['adminConfig']['setStartPage'] && !empty($GLOBALS['websiteConfig']['startPage']) && ($startPageCategory = GeneralFunctions::getPageCategory($GLOBALS['websiteConfig']['startPage'])) != 0)
    $startPageCategory .= '/';
  else
    $startPageCategory = '';

  if($GLOBALS['adminConfig']['setStartPage'] && (empty($GLOBALS['websiteConfig']['startPage']) || !file_exists(dirname(__FILE__).'/../../pages/'.$startPageCategory.$GLOBALS['websiteConfig']['startPage'].'.php'))) {
    return '<div class="block info">
            <h1>'.$GLOBALS['langFile']['WARNING_TITLE_STARTPAGE'].'</h1>
            <div class="content">
              <p>'.$GLOBALS['langFile']['WARNING_TEXT_STARTPAGE'].'</p><!-- need <p> tags for margin-left:..--> 
            </div> 
            <div class="bottom"></div> 
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
 *    - <var>$languageCodes</var> an array with country codes and language names (included in the {@link general.include.php})
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

  if(!$GLOBALS['adminConfig']['multiLanguageWebsite']['active'])
    return false;
  
  // -> websiteConfig
  $websiteConfig = '';
  if($GLOBALS['adminConfig']['multiLanguageWebsite']['languages'] != array_keys($GLOBALS['websiteConfig']['localized'])) {
    foreach ($GLOBALS['adminConfig']['multiLanguageWebsite']['languages'] as $langCode) {
      if(!isset($GLOBALS['websiteConfig']['localized'][$langCode])) {
        $websiteConfig .= '<span><img src="'.getFlag($langCode).'" class="flag"> <a href="?site=websiteSetup&amp;websiteLanguage='.$langCode.'" class="standardLink gray">'.$GLOBALS['languageCodes'][$langCode].'</a></span><br>';
      }
    }
  }

  // -> categoryConfig
  $categoryHasMissingLanguages = false;
    foreach ($GLOBALS['categoryConfig'] as $category) {
      $arrayDifferences = array_diff($GLOBALS['adminConfig']['multiLanguageWebsite']['languages'],array_keys($category['localized']));
      if(!empty($arrayDifferences)) {
        $categoryHasMissingLanguages = true;
        break;
      }
    }
    if($categoryHasMissingLanguages) {
        foreach ($GLOBALS['categoryConfig'] as $category) {
          foreach ($GLOBALS['adminConfig']['multiLanguageWebsite']['languages'] as $langCode) {
            if(!isset($category['localized'][$langCode])) {
              $categoryName = GeneralFunctions::getLocalized($category['localized'],'name');
              $categoryName = (!empty($categoryName)) ? ' &lArr; '.$categoryName : '';
              $categoryConfig .= '<span><img src="'.getFlag($langCode).'" class="flag"> <a href="?site=pageSetup&amp;websiteLanguage='.$langCode.'" class="standardLink gray">'.$GLOBALS['languageCodes'][$langCode].'</a>'.$categoryName.'</span><br>';
            }
          }
        }
    }

  if(!empty($websiteConfig) || !empty($categoryConfig)) {
    $return .= '<div class="block info missingLanguages">
            <h1>'.$GLOBALS['langFile']['SORTABLEPAGELIST_TOOLTIP_LANGUAGEMISSING'].'</h1>
            <div class="content">
              ';
    if(!empty($websiteConfig))
      $return .= '<h2>'.$GLOBALS['langFile']['BUTTON_WEBSITESETTINGS'].'</h2><p>'.$websiteConfig.'</p><!-- need <p> tags for margin-left:..-->';
    if(!empty($categoryConfig))
      $return .= '<h2>'.$GLOBALS['langFile']['BUTTON_PAGESETUP'].'</h2><p>'.$categoryConfig.'</p><!-- need <p> tags for margin-left:..-->';
    
    $return .= '</div> 
            <div class="bottom"></div> 
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
            $browserColor = 'url(library/images/bg/browserBg_firefox.png)';
            $browserLogo = 'browser_firefox.png';
            $browserTextColor = '#ffffff';
            break;
          case 'firefox':
            $browserName = 'Firefox';
            $browserColor = 'url(library/images/bg/browserBg_firefox.png)';
            $browserLogo = 'browser_firefox.png';
            $browserTextColor = '#ffffff';
            break;
          case 'netscape navigator':
            $browserName = 'Netscape Navigator';
            $browserColor = 'url(library/images/bg/browserBg_netscape.png)';
            $browserLogo = 'browser_netscape.png';
            $browserTextColor = '#ffffff';
            break;
          case 'chrome':
            $browserName = 'Google Chrome';
            $browserColor = 'url(library/images/bg/browserBg_chrome.png)';
            $browserLogo = 'browser_chrome.png';
            $browserTextColor = '#000000';
            break;
          case 'internet explorer':
            $browserName = 'Internet Explorer';
            $browserColor = 'url(library/images/bg/browserBg_ie.png)';
            $browserLogo = 'browser_ie.png';
            $browserTextColor = '#000000';
            break;
          case 'internet explorer old':
            $browserName = 'Internet Explorer 1-6';
            $browserColor = 'url(library/images/bg/browserBg_ie_old.png)';
            $browserLogo = 'browser_ie_old.png';
            $browserTextColor = '#000000';
            break;
          case 'opera':
            $browserName = 'Opera';
            $browserColor = 'url(library/images/bg/browserBg_opera.png)';
            $browserLogo = 'browser_opera.png';
            $browserTextColor = '#000000';
            break;
          case 'konqueror':
            $browserName = 'Konqueror';
            $browserColor = 'url(library/images/bg/browserBg_konqueror.png)';
            $browserLogo = 'browser_konqueror.png';
            $browserTextColor = '#ffffff';
            break;
          case 'lynx':
            $browserName = 'Lynx';
            $browserColor = 'url(library/images/bg/browserBg_lynx.png)';
            $browserLogo = 'browser_lynx.png';
            $browserTextColor = '#ffffff';
            break;
          case 'safari':
            $browserName = 'Safari';
            $browserColor = 'url(library/images/bg/browserBg_safari.png)';
            $browserLogo = 'browser_safari.png';
            $browserTextColor = '#000000';
            break;
          case 'mozilla':
            $browserName = 'Mozilla';
            $browserColor = 'url(library/images/bg/browserBg_mozilla.png)';
            $browserLogo = 'browser_mozilla.png';
            $browserTextColor = '#ffffff';
            break;
          case 'iphone':
            $browserName = 'iPhone';
            $browserColor = 'url(library/images/bg/browserBg_iphone.png)';
            $browserLogo = 'browser_iphone.png';
            $browserTextColor = '#ffffff';
            break;
          case 'ipad':
            $browserName = 'iPad';
            $browserColor = 'url(library/images/bg/browserBg_ipad.png)';
            $browserLogo = 'browser_ipad.png';
            $browserTextColor = '#000000';
            break;
          case 'ipod':
            $browserName = 'iPod';
            $browserColor = 'url(library/images/bg/browserBg_ipod.png)';
            $browserLogo = 'browser_ipod.png';
            $browserTextColor = '#000000';
            break;
          case 'amaya':
            $browserName = 'Amaya';
            $browserColor = 'url(library/images/bg/browserBg_amaya.png)';
            $browserLogo = 'browser_amaya.png';
            $browserTextColor = '#000000';
            break;
          case 'phoenix':
            $browserName = 'Phoenix';
            $browserColor = 'url(library/images/bg/browserBg_phoenix.png)';
            $browserLogo = 'browser_phoenix.png';
            $browserTextColor = '#000000';
            break;
          case 'icab':
            $browserName = 'iCab';
            $browserColor = 'url(library/images/bg/browserBg_icab.png)';
            $browserLogo = 'browser_icab.png';
            $browserTextColor = '#000000';
            break;
          case 'omniweb':
            $browserName = 'OmniWeb';
            $browserColor = 'url(library/images/bg/browserBg_omniweb.png)';
            $browserLogo = 'browser_omniweb.png';
            $browserTextColor = '#000000';
            break;
          case 'galeon':
            $browserName = 'Galeon';
            $browserColor = 'url(library/images/bg/browserBg_galeon.png)';
            $browserLogo = 'browser_galeon.png';
            $browserTextColor = '#000000';
            break;
          case 'netpositive':
            $browserName = 'NetPositive';
            $browserColor = 'url(library/images/bg/browserBg_netpositive.png)';
            $browserLogo = 'browser_netpositive.png';
            $browserTextColor = '#000000';
            break;
          case 'opera mini':
            $browserName = 'Opera Mini';
            $browserColor = 'url(library/images/bg/browserBg_opera_mini.png)';
            $browserLogo = 'browser_opera_mini.png';
            $browserTextColor = '#000000';
            break;
          case 'blackberry':
            $browserName = 'BlackBerry';
            $browserColor = 'url(library/images/bg/browserBg_blackberry.png)';
            $browserLogo = 'browser_blackberry.png';
            $browserTextColor = '#000000';
            break;
          case 'android':
            $browserName = 'Android';
            $browserColor = 'url(library/images/bg/browserBg_android.png)';
            $browserLogo = 'browser_android.png';
            $browserTextColor = '#ffffff';
            break;
          case 'icecat':
            $browserName = 'IceCat';
            $browserColor = 'url(library/images/bg/browserBg_icecat.png)';
            $browserLogo = 'browser_icecat.png';
            $browserTextColor = '#000000';
            break;
          case 'nokia browser': case 'Nokia S60 OSS Browser':
            $browserName = 'Nokia Browser';
            $browserColor = 'url(library/images/bg/browserBg_nokia.png)';
            $browserLogo = 'browser_nokia.png';
            $browserTextColor = '#000000';
            break;
          default:
            $default = true;
            $browserName = $GLOBALS['langFile']['STATISTICS_TEXT_BROWSERCHART_OTHERS'];
            $browserColor = 'url(library/images/bg/browserBg_others.png)';
            $browserLogo = 'browser_others.png';
            $browserTextColor = '#000000';
            break;
        }
        
        if($default) {            
          $listBrowser['unknown']['name'] = $browserName;
          $listBrowser['unknown']['bgImage'] = $browserColor;
          $listBrowser['unknown']['logo'] = $browserLogo;
          $listBrowser['unknown']['textColor'] = $browserTextColor;
          $listBrowser['unknown']['percent'] = round((($browser['number'] + $listBrowser['unknown']['number'])  / $sumOfNumbers) * 100);
          $listBrowser['unknown']['number'] += $browser['number'];
        } else {   
          $listBrowser[$browser['data']]['name'] = $browserName;
          $listBrowser[$browser['data']]['bgImage'] = $browserColor;
          $listBrowser[$browser['data']]['logo'] = $browserLogo;
          $listBrowser[$browser['data']]['textColor'] = $browserTextColor;
          $listBrowser[$browser['data']]['percent'] = round(($browser['number'] / $sumOfNumbers) * 100);
          $listBrowser[$browser['data']]['number'] = $browser['number'];
        }
      }
      
      // sort by number
      usort($listBrowser,'sortDataString');
      
      $return = '<table class="tableChart"><tr>';        
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
          $cellText = '<span style="position: absolute; left: 45px; top: 13px;"><b>'.$displayBrowser['name'].'</b> ('.$displayBrowser['percent'].'%)</span>';
          $logoSize = '';
          $bigLogo = true;
          $cellpadding = '';
        }
        
        // SHOW the table cell with the right browser and color
        $return .= '<td valign="middle" style="padding: '.$cellpadding.'; color: '.$displayBrowser['textColor'].'; width: '.$displayBrowser['percent'].'%; background: '.$displayBrowser['bgImage'].' repeat-x;" class="toolTip" title="[span]'.$displayBrowser['name'].'[/span] ('.$displayBrowser['percent'].'%)::'.$displayBrowser['number'].' '.$GLOBALS['langFile']['STATISTICS_TEXT_VISITORCOUNT'].'">
                    <div style="position: relative;">
                    <img src="library/images/icons/'.$displayBrowser['logo'].'" style="float: left;'.$logoSize.';" alt="browser logo">'.$cellText.'
                    </div>
                    </td>';
                    
        unset($logoSize,$cellText);
      }
      $return .= '</tr></table>';
      
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
      
      $return .= '<a href="?site=search&amp;search='.$tagsHref.'" style="font-size:'.$fontSize.'px;" class="toolTip" title="[span]&quot;'.$tag['data'].'&quot;[/span] '.$GLOBALS['langFile']['STATISTICS_TEXT_SEARCHWORD_PART1'].' [span]'.$tag['number'].'[/span] '.$GLOBALS['langFile']['STATISTICS_TEXT_SEARCHWORD_PART2'].'::'.$GLOBALS['langFile']['STATISTICS_TOOLTIP_SEARCHWORD'].'">'.$tag['data'].'</a>&nbsp;&nbsp;'."\n"; //<span style="color:#888888;">('.$tag['number'].')</span>
    
    }
  }    
  
  // return the tag-cloud or false
  return $return;
}

/**
* <b>Name</b> getFlag()<br>
* 
* Returns the right flag from the <var>library/images/icons/flags</var> folder.
* If no flag with the given <var>$countryCode</var> parameter exists, it returns a generic flag (<var>library/images/icons/flags/none.png</var>).
* 
* @param string $countryCode a country code like "en"
* 
* @return string the URL of the flag, relative to the "feindura" folder
* 
* @version 1.0
* <br>
* <b>ChangeLog</b><br>
*    - 1.0 initial release
* 
*/
function getFlag($countryCode) {

  // var
  $countryCode = strtolower($countryCode);
  return (file_exists(dirname(__FILE__).'/../images/icons/flags/'.$countryCode.'.png'))
    ? 'library/images/icons/flags/'.$countryCode.'.png'
    : 'library/images/icons/flags/none.png';

}

?>