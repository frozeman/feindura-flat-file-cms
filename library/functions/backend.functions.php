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

// ** -- redirect ----------------------------------------------------------------------------------
// leitet automatisch weiter auf die angegeben seite
// -----------------------------------------------------------------------------------------------------
// $goToPage      [seite auf die weitergeleitet werden soll (String)],
// $goToCategory  [the category in which to redirect (String)],
// $time          [the time in seconds after which it will redirect (Number)]
//function redirect($goToCategory, $goToPage, $time = 2) {
  //global $adminConfig;
  
  //echo '<meta http-equiv="refresh" content="'.$time.'; URL='.$adminConfig['basePath'].'?category='.$goToCategory.'&amp;page='.$goToPage.'">';
  //echo '<script type="text/javascript">
    /* <![CDATA[ */
      //document.location.href = "'.$adminConfig['basePath'].'?category='.$goToCategory.'&page='.$goToPage.'"
    /* ]]> */
    //</script>';
  //echo 'You should be automatically redirected, if not click <a href="'.$adminConfig['basePath'].'?category='.$goToCategory.'&amp;page='.$goToPage.'">here</a>.';
//}

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
    
    $username = $_SESSION['feinduraLogin'][IDENTITY]['username'];
    
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
 * @version 1.0
 * <br />
 * <b>ChangeLog</b><br />
 *    - 1.0 initial release
 * 
 */
function saveCategories($newCategories) {
  
  // öffnet die category.config.php zum schreiben
  if($file = fopen(dirname(__FILE__)."/../../config/category.config.php","w")) {

      // *** write CATEGORIES
      flock($file,2); //LOCK_EX
      fwrite($file,PHPSTARTTAG); //< ?php
      
      // ->> GO through EVERY catgory and write it
      foreach($newCategories as $category) {        

        // CHECK BOOL VALUES and change to FALSE
        $category['public'] = (isset($category['public']) && $category['public']) ? 'true' : 'false';
        $category['createdelete'] = (isset($category['createdelete']) && $category['createdelete']) ? 'true' : 'false';
        $category['thumbnail'] = (isset($category['thumbnail']) && $category['thumbnail']) ? 'true' : 'false';
        $category['plugins'] = (isset($category['plugins']) && $category['plugins']) ? 'true' : 'false';
        $category['showTags'] = (isset($category['showTags']) && $category['showTags']) ? 'true' : 'false';
        $category['showPageDate'] = (isset($category['showPageDate']) && $category['showPageDate']) ? 'true' : 'false';
        $category['sortByPageDate'] = (isset($category['sortByPageDate']) && $category['sortByPageDate']) ? 'true' : 'false';
        $category['sortAscending'] = (isset($category['sortAscending']) && $category['sortAscending']) ? 'true' : 'false';
        
        // -> CHECK depency of PAGEDATE
        if($category['showPageDate'] == 'false')
          $category['sortByPageDate'] = 'false';
        
        if($category['sortByPageDate'] == 'true')
          $category['showPageDate'] = 'true';
        
        // -> CHECK if the THUMBNAIL HEIGHT/WIDTH is empty, and add the previous ones
        if(!isset($category['thumbWidth']))
          $category['thumbWidth'] = $GLOBALS['categoryConfig'][$category['id']]['thumbWidth'];
        if(!isset($category['thumbHeight']))
          $category['thumbHeight'] = $GLOBALS['categoryConfig'][$category['id']]['thumbHeight'];
        
        // escape single quotes
        $category = generalFunctions::escapeQuotesRecursive($category);
        
        // -> CLEAN all " out of the strings
        foreach($category as $postKey => $post) {
          $category[$postKey] = str_replace(array('\"',"\'"),'',$post);
        }
        
        // adds absolute path slash on the beginning and serialize the stylefiles
        $category['styleFile'] = prepareStyleFilePaths($category['styleFile']);
      
        // bubbles through the page, category and adminConfig to see if it should save the styleheet-file path, id or class-attribute
        $category['styleFile'] = setStylesByPriority($category['styleFile'],'styleFile',true);
        $category['styleId'] = setStylesByPriority(xssFilter::string($category['styleId']),'styleId',true);
        $category['styleClass'] = setStylesByPriority(xssFilter::string($category['styleClass']),'styleClass',true);        
        
        // WRITE
        fwrite($file,"\$categoryConfig[".$category['id']."]['id'] =              ".$category['id'].";\n");
        fwrite($file,"\$categoryConfig[".$category['id']."]['name'] =            '".$category['name']."';\n");
        
        fwrite($file,"\$categoryConfig[".$category['id']."]['public'] =          ".$category['public'].";\n");        
        fwrite($file,"\$categoryConfig[".$category['id']."]['createdelete'] =    ".$category['createdelete'].";\n");
        fwrite($file,"\$categoryConfig[".$category['id']."]['thumbnail'] =       ".$category['thumbnail'].";\n");        
        fwrite($file,"\$categoryConfig[".$category['id']."]['plugins'] =         ".$category['plugins'].";\n");
        fwrite($file,"\$categoryConfig[".$category['id']."]['showTags'] =        ".$category['showTags'].";\n");
        fwrite($file,"\$categoryConfig[".$category['id']."]['showPageDate'] =    ".$category['showPageDate'].";\n");
        fwrite($file,"\$categoryConfig[".$category['id']."]['sortByPageDate'] =  ".$category['sortByPageDate'].";\n");
        fwrite($file,"\$categoryConfig[".$category['id']."]['sortAscending'] =   ".$category['sortAscending'].";\n\n");
        
        fwrite($file,"\$categoryConfig[".$category['id']."]['styleFile'] =       '".$category['styleFile']."';\n");
        fwrite($file,"\$categoryConfig[".$category['id']."]['styleId'] =         '".$category['styleId']."';\n");
        fwrite($file,"\$categoryConfig[".$category['id']."]['styleClass'] =      '".$category['styleClass']."';\n\n");
        
        fwrite($file,"\$categoryConfig[".$category['id']."]['thumbWidth'] =      '".xssFilter::int($category['thumbWidth'])."';\n");
        fwrite($file,"\$categoryConfig[".$category['id']."]['thumbHeight'] =     '".xssFilter::int($category['thumbHeight'])."';\n");
        fwrite($file,"\$categoryConfig[".$category['id']."]['thumbRatio'] =      '".$category['thumbRatio']."';\n\n\n");
        
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
  if($fromCategory === false || $fromCategory == 0)
    $fromCategory = '';
  if($toCategory === false || $toCategory == 0)
    $toCategory = '';
    
  // create category folder if its not exist
  if(!is_dir(DOCUMENTROOT.$GLOBALS['adminConfig']['basePath'].'pages/'.$toCategory))
    @mkdir(DOCUMENTROOT.$GLOBALS['adminConfig']['basePath'].'pages/'.$toCategory);
  
  // MOVE categories
  if(copy(DOCUMENTROOT.$GLOBALS['adminConfig']['basePath'].'pages/'.$fromCategory.'/'.$page.'.php',
    DOCUMENTROOT.$GLOBALS['adminConfig']['basePath'].'pages/'.$toCategory.'/'.$page.'.php') &&
    unlink(DOCUMENTROOT.$GLOBALS['adminConfig']['basePath'].'pages/'.$fromCategory.'/'.$page.'.php')) {
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
 * @version 1.01
 * <br />
 * <b>ChangeLog</b><br />
 *    - 1.01 add websitePath 
 *    - 1.0 initial release
 * 
 */
function saveAdminConfig($adminConfig) {

  // **** opens admin.config.php for writing
  if($file = fopen(dirname(__FILE__)."/../../config/admin.config.php","w")) {
    
    // CHECK BOOL VALUES and change to FALSE
    $adminConfig['speakingUrl'] = (isset($adminConfig['speakingUrl']) && $adminConfig['speakingUrl']) ? 'true' : 'false';
    $adminConfig['user']['fileManager'] = (isset($adminConfig['user']['fileManager']) && $adminConfig['user']['fileManager']) ? 'true' : 'false';
    $adminConfig['user']['editWebsiteFiles'] = (isset($adminConfig['user']['editWebsiteFiles']) && $adminConfig['user']['editWebsiteFiles']) ? 'true' : 'false';
    $adminConfig['user']['editStylesheets'] = (isset($adminConfig['user']['editStylesheets']) && $adminConfig['user']['editStylesheets']) ? 'true' : 'false';
    $adminConfig['setStartPage'] = (isset($adminConfig['setStartPage']) && $adminConfig['setStartPage']) ? 'true' : 'false';
    $adminConfig['pages']['createdelete'] = (isset($adminConfig['pages']['createdelete']) && $adminConfig['pages']['createdelete']) ? 'true' : 'false';
    $adminConfig['pages']['thumbnails'] = (isset($adminConfig['pages']['thumbnails']) && $adminConfig['pages']['thumbnails']) ? 'true' : 'false';
    $adminConfig['pages']['plugins'] = (isset($adminConfig['pages']['plugins']) && $adminConfig['pages']['plugins']) ? 'true' : 'false';
    $adminConfig['pages']['showTags'] = (isset($adminConfig['pages']['showTags']) && $adminConfig['pages']['showTags']) ? 'true' : 'false';
    
    // escape single quotes
    $adminConfig = generalFunctions::escapeQuotesRecursive($adminConfig);
    
    flock($file,2); // LOCK_EX
    fwrite($file,PHPSTARTTAG); // < ?php
    
    fwrite($file,"\$adminConfig['url'] =              '".$adminConfig['url']."';\n");
    fwrite($file,"\$adminConfig['basePath'] =         '".$adminConfig['basePath']."';\n");
    fwrite($file,"\$adminConfig['websitePath'] =      '".xssFilter::path($adminConfig['websitePath'])."';\n");
    fwrite($file,"\$adminConfig['uploadPath'] =       '".xssFilter::path($adminConfig['uploadPath'])."';\n");  
    fwrite($file,"\$adminConfig['websitefilesPath'] = '".xssFilter::path($adminConfig['websitefilesPath'])."';\n");
    fwrite($file,"\$adminConfig['stylesheetPath'] =   '".xssFilter::path($adminConfig['stylesheetPath'])."';\n");    
    fwrite($file,"\$adminConfig['dateFormat'] =       '".$adminConfig['dateFormat']."';\n");
    fwrite($file,"\$adminConfig['speakingUrl'] =      ".$adminConfig['speakingUrl'].";\n\n");
    
    fwrite($file,"\$adminConfig['varName']['page'] =     '".xssFilter::alphaNumeric($adminConfig['varName']['page'])."';\n");  
    fwrite($file,"\$adminConfig['varName']['category'] = '".xssFilter::alphaNumeric($adminConfig['varName']['category'])."';\n");  
    fwrite($file,"\$adminConfig['varName']['modul'] =    '".xssFilter::alphaNumeric($adminConfig['varName']['modul'])."';\n\n");
    
    fwrite($file,"\$adminConfig['user']['fileManager'] =      ".$adminConfig['user']['fileManager'].";\n");
    fwrite($file,"\$adminConfig['user']['editWebsiteFiles'] = ".$adminConfig['user']['editWebsiteFiles'].";\n");
    fwrite($file,"\$adminConfig['user']['editStylesheets'] =  ".$adminConfig['user']['editStylesheets'].";\n");  
    fwrite($file,"\$adminConfig['user']['info'] =             '".$adminConfig['user']['info']."';\n\n");
    
    fwrite($file,"\$adminConfig['setStartPage'] =          ".$adminConfig['setStartPage'].";\n");
    fwrite($file,"\$adminConfig['pages']['createdelete'] = ".$adminConfig['pages']['createdelete'].";\n");
    fwrite($file,"\$adminConfig['pages']['thumbnails'] =   ".$adminConfig['pages']['thumbnails'].";\n");    
    fwrite($file,"\$adminConfig['pages']['plugins'] =      ".$adminConfig['pages']['plugins'].";\n");
    fwrite($file,"\$adminConfig['pages']['showTags'] =     ".$adminConfig['pages']['showTags'].";\n\n");
    
    fwrite($file,"\$adminConfig['editor']['enterMode'] =  '".$adminConfig['editor']['enterMode']."';\n");
    fwrite($file,"\$adminConfig['editor']['styleFile'] =  '".$adminConfig['editor']['styleFile']."';\n");
    fwrite($file,"\$adminConfig['editor']['styleId'] =    '".xssFilter::string($adminConfig['editor']['styleId'])."';\n");  
    fwrite($file,"\$adminConfig['editor']['styleClass'] = '".xssFilter::string($adminConfig['editor']['styleClass'])."';\n\n");  
  
    fwrite($file,"\$adminConfig['pageThumbnail']['width'] =  '".xssFilter::int($adminConfig['pageThumbnail']['width'])."';\n");
    fwrite($file,"\$adminConfig['pageThumbnail']['height'] = '".xssFilter::int($adminConfig['pageThumbnail']['height'])."';\n");
    fwrite($file,"\$adminConfig['pageThumbnail']['ratio'] =  '".$adminConfig['pageThumbnail']['ratio']."';\n");
    fwrite($file,"\$adminConfig['pageThumbnail']['path'] =   '".xssFilter::path($adminConfig['pageThumbnail']['path'])."';\n\n");
    
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
 * @version 1.0
 * <br />
 * <b>ChangeLog</b><br />
 *    - 1.0 initial release
 * 
 */
function saveUserConfig($userConfig) {
   
  // opens the file for writing
  if($file = fopen(dirname(__FILE__)."/../../config/user.config.php","w")) {
    
    // CHECK BOOL VALUES and change to FALSE
    foreach($userConfig as $user => $config) {
      $userConfig[$user]['admin'] = (isset($userConfig[$user]['admin']) && $userConfig[$user]['admin']) ? 'true' : 'false';
    }
    
    // *** write
    flock($file,2); //LOCK_EX
      fwrite($file,PHPSTARTTAG); //< ?php      
      foreach($userConfig as $user => $configs) {
        
        // escape single quotes
        $configs = generalFunctions::escapeQuotesRecursive($configs);
      
        // CHECK BOOL VALUES and change to FALSE
        $userConfig[$user]['admin'] = (isset($userConfig[$user]['admin']) && $userConfig[$user]['admin']) ? 'true' : 'false';
        
        foreach($configs as $configKey => $configValue) {
          if($configKey == 'id' || $configKey == 'admin')
            fwrite($file,"\$userConfig['".$user."']['".$configKey."'] = ".$configValue.";\n");
          else
            fwrite($file,"\$userConfig['".$user."']['".$configKey."'] = '".$configValue."';\n");
        }
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
 * @version 1.01
 * <br />
 * <b>ChangeLog</b><br />
 *    - 1.01 removed $websiteconfig['email'], because its now set up in the contactForm plugin
 *    - 1.0 initial release
 * 
 */
function saveWebsiteConfig($websiteConfig) {
   
  // opens the file for writing
  if($file = fopen(dirname(__FILE__)."/../../config/website.config.php","w")) {
    
    // CHECK BOOL VALUES and change to FALSE
    //$websiteConfig['noname'] = (isset($websiteConfig['noname']) && $websiteConfig['noname']) ? 'true' : 'false';
        
    // format keywords
    $keywords = preg_replace("/ +/", ' ', $websiteConfig['keywords']);
    $keywords = preg_replace("/,+/", ',', $keywords);
    $keywords = str_replace(', ',',', $keywords);
    $keywords = str_replace(' ,',',', $keywords);
    $keywords = str_replace(' ',',', $keywords);
    $websiteConfig['keywords'] = $keywords;
    
    // format all other strings
    $websiteConfig['title'] = generalFunctions::prepareStringInput($websiteConfig['title']);
    $websiteConfig['publisher'] = generalFunctions::prepareStringInput($websiteConfig['publisher']);
    $websiteConfig['copyright'] = generalFunctions::prepareStringInput($websiteConfig['copyright']);
    $websiteConfig['keywords'] = generalFunctions::prepareStringInput($websiteConfig['keywords']);
    $websiteConfig['description'] = generalFunctions::prepareStringInput($websiteConfig['description']);
    
    // escape single quotes
    $websiteConfig = generalFunctions::escapeQuotesRecursive($websiteConfig);
    
    // *** write
    flock($file,2); //LOCK_EX
      fwrite($file,PHPSTARTTAG); //< ?php
  
      fwrite($file,"\$websiteConfig['title']          = '".$websiteConfig['title']."';\n");
      fwrite($file,"\$websiteConfig['publisher']      = '".$websiteConfig['publisher']."';\n");
      fwrite($file,"\$websiteConfig['copyright']      = '".$websiteConfig['copyright']."';\n");
      fwrite($file,"\$websiteConfig['keywords']       = '".$websiteConfig['keywords']."';\n");
      fwrite($file,"\$websiteConfig['description']    = '".$websiteConfig['description']."';\n\n");
      
      fwrite($file,"\$websiteConfig['startPage']      = '".$websiteConfig['startPage']."';\n\n");
      
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
 * @version 1.0
 * <br />
 * <b>ChangeLog</b><br />
 *    - 1.0 initial release
 * 
 */
function saveStatisticConfig($statisticConfig) {
   
  // opens the file for writing
  if($file = fopen("config/statistic.config.php","w")) {
        
    // escape single quotes
    $websiteConfig = generalFunctions::escapeQuotesRecursive($websiteConfig);
    
    // WRITE
    flock($file,2); //LOCK_EX
      fwrite($file,PHPSTARTTAG); //< ?php
  
      fwrite($file,"\$statisticConfig['number']['mostVisitedPages']        = '".xssFilter::int($statisticConfig['number']['mostVisitedPages'])."';\n");
      fwrite($file,"\$statisticConfig['number']['longestVisitedPages']     = '".xssFilter::int($statisticConfig['number']['longestVisitedPages'])."';\n");
      fwrite($file,"\$statisticConfig['number']['lastEditedPages']         = '".xssFilter::int($statisticConfig['number']['lastEditedPages'])."';\n\n");
      
      fwrite($file,"\$statisticConfig['number']['refererLog']    = '".xssFilter::int($statisticConfig['number']['refererLog'])."';\n");
      fwrite($file,"\$statisticConfig['number']['taskLog']       = '".xssFilter::int($statisticConfig['number']['taskLog'])."';\n\n");
      
      
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
 * @version 1.0
 * <br />
 * <b>ChangeLog</b><br />
 *    - 1.0 initial release
 * 
 */
function savePluginsConfig($pluginsConfig) {

  // **** opens plugin.config.php for writing
  if($file = fopen(dirname(__FILE__)."/../../config/plugins.config.php","w")) {
    
    // escape single quotes
    $pluginsConfig = generalFunctions::escapeQuotesRecursive($pluginsConfig);
    
    // CHECK BOOL VALUES and change to FALSE   
    flock($file,2); // LOCK_EX
    fwrite($file,PHPSTARTTAG); //< ?php
    
    if(is_array($pluginsConfig)) {
      foreach($pluginsConfig as $key => $value) {
        $pluginsConfig[$key]['active'] = (isset($pluginsConfig[$key]['active']) && $pluginsConfig[$key]['active']) ? 'true' : 'false';    
        fwrite($file,"\$pluginsConfig['$key']['active'] = ".$pluginsConfig[$key]['active'].";\n");
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
  
  $newWebsitePath = 'RewriteRule ^'.xssFilter::path(substr($_POST['cfg_websitePath'],1));
  $oldWebsitePath = 'RewriteRule ^'.xssFilter::path(substr($GLOBALS['adminConfig']['websitePath'],1));
  
  $speakingUrlCode = '<IfModule mod_rewrite.c>
RewriteEngine on
RewriteBase /
# rewrite "/page/*.html" and "/category/*/*.html"
# and also passes the session var
RewriteCond %{HTTP_HOST} ^'.str_replace(array('http://www.','https://www.','http://','https://'),'',$_SERVER["HTTP_HOST"]).'$
'.$newWebsitePath.'category/(.*)/(.*)\.html\?*(.*)$ ?category=$1&page=$2$3 [QSA,L]
'.$newWebsitePath.'page/(.*)\.html\?*(.*)$ ?page=$1$2 [QSA,L]
</IfModule>';
  
  $oldSpeakingUrlCode = str_replace($newWebsitePath,$oldWebsitePath,$speakingUrlCode);
  
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
    $checkCurrrentContent = (strlen($newWebsitePath) >  strlen($oldWebsitePath))
      ? str_replace(array($newWebsitePath,$oldWebsitePath),'',$currrentContent)
      : str_replace(array($oldWebsitePath,$newWebsitePath),'',$currrentContent);
    $checkSpeakingUrlCode = str_replace($newWebsitePath,'',$speakingUrlCode);
    
    // ->> create or change the .htaccess file
    if($_POST['cfg_speakingUrl'] == 'true') {
      
      // -> if no speakingUrl code exists, add new one
      if(strpos($checkCurrrentContent,$checkSpeakingUrlCode) === false) {
         
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
  if($save && !empty($data) && $htaccess = fopen($htaccessFile,"w")) {
    
    $data = preg_replace("# +#"," ",$data);
    $data = preg_replace("#\n+#","\n",$data);
    
    flock($htaccess,2); // LOCK_EX
    fwrite($htaccess,$data);
    flock($htaccess,3); //LOCK_UN
    fclose($htaccess);
    
    @chmod($htaccessFile,0644);
  
  // ->> throw error
  } elseif($save) {
    $_POST['cfg_speakingUrl'] = '';
    $errorWindow .= $GLOBALS['langFile']['adminSetup_fmsSettings_speakingUrl_error_save'];
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
 * @return string the generated backup file name
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

  $websitePath = str_replace(array('/',"\\"),'+',$GLOBALS['adminConfig']['websitePath']);
  $websitePath = ($websitePath != '+') ? substr($websitePath,0,-1) : '';
  $backupName = 'feinduraBackup_'.$_SERVER['HTTP_HOST'].$websitePath.'_'.date('Y-m-d_H-i').$backupAppendix.'.zip';
  $backupFileName = DOCUMENTROOT.$GLOBALS['adminConfig']['basePath'].'backups/'.$backupName;
  
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
 * @param string $backupFileName the backup file name
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
function createBackup($backupFileName) {
  
  // -> generate archive
  require_once(dirname(__FILE__).'/../thirdparty/pclzip.lib.php');
  $archive = new PclZip($backupFileName);
  $catchError = $archive->add(DOCUMENTROOT.$GLOBALS['adminConfig']['basePath'].'config/,'.DOCUMENTROOT.$GLOBALS['adminConfig']['basePath'].'statistic/,'.DOCUMENTROOT.$GLOBALS['adminConfig']['basePath'].'pages/',PCLZIP_OPT_REMOVE_PATH, DOCUMENTROOT.$GLOBALS['adminConfig']['basePath']);

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
          
      if(!strstr($styleFile,'://')) //check path if its not an url (urls dont pass the xssFilter :-))
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
 * @param string		$siteName	           a site name which will be set to the $_GET['site'] variable in the formular action attribute
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
function editFiles($filesPath, $siteName, $status, $titleText, $anchorName, $fileType = false, $excluded = false) {
  
  // var
  $fileTypeText = null;
  $isFiles = false;
  
  // shows the block below if it is the ones which is saved before
  $hidden = ($_GET['status'] == $status || $GLOBALS['savedForm'] === $status) ? '' : ' hidden';

  echo '<form action="index.php?site='.$siteName.'#'.$anchorName.'" method="post" enctype="multipart/form-data" accept-charset="UTF-8">
        <div>
        <input type="hidden" name="send" value="saveEditedFiles" />
        <input type="hidden" name="status" value="'.$status.'" />
        <input type="hidden" name="filesPath" value="'.$filesPath.'" />';
  if($fileType)
    echo '<input type="hidden" name="fileType" value=".'.$fileType.'" />';
  echo '</div>';
  
  echo '<div class="block'.$hidden.'">
          <h1><a href="#" name="'.$anchorName.'" id="'.$anchorName.'">'.$titleText.'</a></h1>
          <div class="content"><br />';
      
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
  	  if(is_string($excluded)) {
  	    $excluded = explode(',',$excluded);
  	  }
  	  
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
            <input type="text" value="'.$filesPath.'" readonly="readonly" style="width:auto;" size="'.(strlen($filesPath)-2).'" />'."\n";
      echo '<select onchange="changeEditFile(\''.$siteName.'\',this.value,\''.$status.'\',\''.$anchorName.'\');">'."\n";
 
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
    
    echo '<input type="hidden" name="file" value="'.$editFile.'" />'."\n";

    $file = str_replace(array('<','>'),array('&lt;','&gt;'),$file);
    
    $fileType = (strtolower($fileType) == 'css') ? ' css' : ' mixed';
    
    echo '<textarea name="fileContent" cols="90" rows="30" class="editFiles'.$fileType.'" id="editFiles'.rand(1,9999).'">'.$file.'</textarea>';
  }  
  
  
  if($isDir) {
    if($isFiles)
      echo '<a href="?site='.$siteName.'&amp;status=deleteEditFiles&amp;editFilesStatus='.$status.'&amp;file='.$editFile.'#'.$anchorName.'" onclick="openWindowBox(\'library/sites/windowBox/deleteEditFiles.php?site='.$siteName.'&amp;status=deleteEditFiles&amp;editFilesStatus='.$status.'&amp;file='.$editFile.'&amp;anchorName='.$anchorName.'\',\''.$GLOBALS['langFile']['editFilesSettings_deleteFile'].'\');return false;" class="cancel left toolTip" title="'.$GLOBALS['langFile']['editFilesSettings_deleteFile'].'::" style="float:left;"></a>';
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
 * @version 1.0
 * <br />
 * <b>ChangeLog</b><br />
 *    - 1.0 initial release
 * 
 */
function saveEditedFiles(&$savedForm) {
    
  // add DOCUMENTROOT
  $file = str_replace(DOCUMENTROOT,'',$_POST['file']);  
  $file = DOCUMENTROOT.$file;    
  $_POST['filesPath'] = str_replace(DOCUMENTROOT,'',$_POST['filesPath']);  
  $_POST['filesPath'] = DOCUMENTROOT.$_POST['filesPath'];
  
  
  // ->> SAVE FILE
  if(@is_file($file) && empty($_POST['newFile'])) {
    
    //$_POST['fileContent'] = preg_replace("#[\r\n]+#","\n",$_POST['fileContent']);
    
    $_POST['fileContent'] = str_replace('\"', '"', $_POST['fileContent']);
    $_POST['fileContent'] = str_replace("\'", "'", $_POST['fileContent']);
    //$_POST['fileContent'] 	= str_replace("<br />", "", $_POST['fileContent']);
    $_POST['fileContent'] = stripslashes($_POST['fileContent']);
    
    // wandelt umlaut in HTML zeichen um
    $_POST['fileContent'] = htmlentities($_POST['fileContent'],ENT_NOQUOTES,'UTF-8');      
    // changes & back, because of the $auml;
    $_POST['fileContent'] = str_replace("&amp;", "&", $_POST['fileContent']);
    // wandelt die php einleitungstags wieder in zeichen um
    $_POST['fileContent'] = str_replace(array('&lt;','&gt;'),array('<','>'),$_POST['fileContent']);
    
    if($file = fopen($file,"w")) {
    flock($file,2);
    fwrite($file,$_POST['fileContent']);
    flock($file,3);
    fclose($file);      
    
    $_GET['file'] = $_POST['file'];
    $_GET['status'] = $_POST['status'];
    $savedForm = $_POST['status'];
    
      return true;      
    } else
      return false;
    
  // ->> NEW FILE
  } else { // creates a new file if a filename was input in the field
        
    //$_POST['newFile'] = str_replace( array(" ","%","+","&","#","!","?","$","§",'"',"'","(",")"), '_', $_POST['newFile']);
    $_POST['newFile'] = str_replace( array("ä","ü","ö","ß","Ä","Ü","Ö"), array("ae","ue","oe","ss","Ae","Ue","Oe"), $_POST['newFile']);
    $_POST['newFile'] = generalFunctions::cleanSpecialChars($_POST['newFile'],'_');
    
    echo $_POST['newFile'];
    
    $_POST['newFile'] = str_replace($_POST['fileType'],'',$_POST['newFile']);
    
    $fullFilePath = $_POST['filesPath'].'/'.$_POST['newFile'].$_POST['fileType'];
    
    //clean vars
    $fullFilePath = preg_replace("/\/+/", '/', $fullFilePath);
    
    if($file = fopen($fullFilePath,"w")) {
      
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
 * @param string $dir the absolute path to the directory which will be deleted, must end with a "/"  
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
      
      if(rmdir(DOCUMENTROOT.$dir))
        return true;
      elseif($writeerror === false && (!empty($checkFilesFolders['folders']) || !empty($checkFilesFolders['files'])))
        delDir($dir);
      else
        return false;
    
    } elseif(@rmdir(DOCUMENTROOT.$dir))
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
  
  if(substr($folder,0,1) != '/')
    $folder = '/'.$folder;

  if(is_dir(DOCUMENTROOT.$folder) === false) {
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
  
  if(substr($fileFolder,0,1) != '/')
    $fileFolder = '/'.$fileFolder;
  
  if(file_exists(DOCUMENTROOT.$fileFolder) && is_writable(DOCUMENTROOT.$fileFolder) === false) {
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
  
  $hostProtocol = (empty($_SERVER["HTTPS"]) || $_SERVER["HTTPS"] == 'off') ? 'http://' : 'https://';
  $baseUrl = str_replace('www.','',$GLOBALS['adminConfig']['url']);
  $checkUrl = str_replace('www.','',$hostProtocol.$_SERVER["HTTP_HOST"]);
  
  $checkPath = preg_replace('#/+#','/',dirname($_SERVER['PHP_SELF']).'/');
  
  if($GLOBALS['adminConfig']['basePath'] ==  $checkPath &&
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
              <p>'.$GLOBALS['langFile']['warning_fmsConfWarning'].'</p><!-- needs <p> tags for margin-left:..--> 
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
  
  if(basePathWarning() !== false || !is_dir(DOCUMENTROOT.$GLOBALS['adminConfig']['basePath'].'pages/'))
    return false;
  
  if($GLOBALS['adminConfig']['setStartPage'] && $GLOBALS['websiteConfig']['startPage'] && ($startPageCategory = generalFunctions::getPageCategory($GLOBALS['websiteConfig']['startPage'])) != 0)
    $startPageCategory .= '/';
  else
    $startPageCategory = '';

  if($GLOBALS['adminConfig']['setStartPage'] && (!$GLOBALS['websiteConfig']['startPage'] || !file_exists(DOCUMENTROOT.$GLOBALS['adminConfig']['basePath'].'pages/'.$startPageCategory.$GLOBALS['websiteConfig']['startPage'].'.php'))) {
    return '<div class="block info">
            <h1>'.$GLOBALS['langFile']['warning_startPageWarning_h1'].'</h1>
            <div class="content">
              <p>'.$GLOBALS['langFile']['warning_startPageWarning'].'</p><!-- needs <p> tags for margin-left:..--> 
            </div> 
            <div class="bottom"></div> 
          </div>';
  } else
    return false;
}

?>