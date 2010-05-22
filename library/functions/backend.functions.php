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
 * @package feindura-CMS
 * 
 * @version 1.28
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
 * <b>Name</b> isAdmin()<br>
 * 
 * Open the .htpasswd file and check if one of the usernames is:
 * "admin", "adminstrator", "superuser", "root" or "frozeman".
 * If one of the above usernames exist and the current user has one of this usernames it returns TRUE,
 * otherwise FALSE.<br>
 * If no user with the above usernames exists it assume that there is no admin and returns TRUE.
 * 
 * <b>Used Constants</b><br>
 *    - <var>DOCUMENTROOT</var> the absolut path of the webserver
 *    
 * <b>Used Global Variables</b><br>
 *    - <var>$adminConfig</var> array the administrator-settings config (included in the {@link general.include.php})    
 *     
 * @return bool TRUE if the current user is an admin, or no admins exist, otherwise FALSE
 * 
 * 
 * @version 1.0
 * <br>
 * <b>ChangeLog</b><br>
 *    - 1.0 initial release
 * 
 */
function isAdmin() {

  $currentUser = strtolower($_SERVER["REMOTE_USER"]);
  
  // checks if the current user has a username like:
  if($currentUser == 'admin' || $currentUser == 'administrator' || $currentUser == 'root' || $currentUser == 'superuser' || $currentUser == 'frozeman') {
    return true;
  } else { // otherwise it checks if in the htpasswd is one of the above usernames, if not return true
    // checks for userfile
    if($getHtaccess = @file(DOCUMENTROOT.$GLOBALS['adminConfig']['basePath'].'.htaccess')) {      

      // try to find the .htpasswd path
      foreach($getHtaccess as $htaccessLine) {
        if(strstr(strtolower($htaccessLine),'authuserfile')) {
          $passwdFilePath = substr($htaccessLine,strpos(strtolower($htaccessLine),'authuserfile')+13);
          $passwdFilePath = str_replace("\n", '', $passwdFilePath);
          $passwdFilePath = str_replace("\r", '', $passwdFilePath);          
          $passwdFilePath = str_replace(" ", '', $passwdFilePath);
        }    
      }
      
      // go trough users in .htpasswd, if there is any user with the above names
      // and current user have not such a username return false
      if($getHtpasswd = @file($passwdFilePath)) {        
        
        $adminExists = false;        
        foreach($getHtpasswd as $htpasswdLine) {
          $user = explode(':',strtolower($htpasswdLine));          
          
          if($user[0] == 'admin' || $user[0] == 'administrator' || $user[0] == 'root' || $user[0] == 'superuser' || $user[0] == 'frozeman')
            $adminExists = true;
        }
        
        // checks if the currentuser has such a name
        if($adminExists) {          
          return false; // ONLY WHEN AN ADMIN EXITS AND THE CURRENT USER ISNT THE ADMIN return false
        } else
          return true;
      
      } else
        return true;
      
    } else { // there is no user file      
      return true;
    }    
  } return true;  
}

/**
 * <b>Name</b> getNewCatgoryId()<br>
 * 
 * Returns a new category ID, which is the highest category ID + 1.
 * 
 * <b>Used Global Variables</b><br>
 *    - <var>$categoryConfig</var> array the categories-settings config (included in the {@link general.include.php})
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
 * <b>Name</b> saveCategories()<br>
 * 
 * Saves the category-settings config array to the "config/category.config.php" file.
 * 
 * <b>Used Constants</b><br>
 *    - <var>PHPSTARTTAG</var> the php start tag
 *    - <var>PHPENDTAG</var> the php end tag  
 * 
 * @param array $newCategories a $categoryConfig array
 * 
 * @return bool TRUE if the file was succesfull saved, otherwise FALSE
 * 
 * @example backend/categoryConfig.array.example.php of the $categoryConfig array
 * 
 * @version 1.0
 * <br>
 * <b>ChangeLog</b><br>
 *    - 1.0 initial release
 * 
 */
function saveCategories($newCategories) {
  
  // öffnet die category.config.php zum schreiben
  if($file = @fopen(dirname(__FILE__)."/../../config/category.config.php","w")) {
 
      // *** write CATEGORIES
      flock($file,2); //LOCK_EX
      fwrite($file,PHPSTARTTAG); //< ?php
      
      // ->> GO through EVERY catgory and write it
      foreach($newCategories as $category) {

        // CHECK BOOL VALUES and change to FALSE
        $category['public'] = (isset($category['public']) && $category['public']) ? 'true' : 'false';
        $category['sortascending'] = (isset($category['sortascending']) && $category['sortascending']) ? 'true' : 'false';
        $category['createdelete'] = (isset($category['createdelete']) && $category['createdelete']) ? 'true' : 'false';
        $category['thumbnail'] = (isset($category['thumbnail']) && $category['thumbnail']) ? 'true' : 'false';
        $category['plugins'] = (isset($category['plugins']) && $category['plugins']) ? 'true' : 'false';
        $category['showtags'] = (isset($category['showtags']) && $category['showtags']) ? 'true' : 'false';
        $category['showpagedate'] = (isset($category['showpagedate']) && $category['showpagedate']) ? 'true' : 'false';
        $category['sortbypagedate'] = (isset($category['sortbypagedate']) && $category['sortbypagedate']) ? 'true' : 'false';
        
        // -> CHECK depency of PAGEDATE
        if($category['showpagedate'] === false)
          $category['sortbypagedate'] = 'false';
        
        if($category['sortbypagedate'])
          $category['showpagedate'] = 'true';
        
        // -> CHECK if the THUMBNAIL HEIGHT/WIDTH is empty, and add the previous ones
        if(!isset($category['thumbWidth']))
          $category['thumbWidth'] = $GLOBALS['categoryConfig']['id_'.$category['id']]['thumbWidth'];
        if(!isset($category['thumbHeight']))
          $category['thumbHeight'] = $GLOBALS['categoryConfig']['id_'.$category['id']]['thumbHeight'];
          
      
        // ** adds a "/" on the beginning of all absolute paths
        if(!empty($category['styleFile']) && substr($category['styleFile'],0,1) !== '/')
              $category['styleFile'] = '/'.$category['styleFile'];  
        
        // -> CLEAN all " out of the strings
        foreach($category as $postKey => $post) {    
          $category[$postKey] = str_replace(array('\"',"\'"),'',$post);
        } 
        
        // WRITE
        fwrite($file,"\$categoryConfig['id_".$category['id']."']['id'] =              ".$category['id'].";\n");
        fwrite($file,"\$categoryConfig['id_".$category['id']."']['name'] =            '".$category['name']."';\n");
        
        fwrite($file,"\$categoryConfig['id_".$category['id']."']['public'] =          ".$category['public'].";\n");
        fwrite($file,"\$categoryConfig['id_".$category['id']."']['sortascending'] =   ".$category['sortascending'].";\n");
        fwrite($file,"\$categoryConfig['id_".$category['id']."']['createdelete'] =    ".$category['createdelete'].";\n");
        fwrite($file,"\$categoryConfig['id_".$category['id']."']['thumbnail'] =       ".$category['thumbnail'].";\n");        
        fwrite($file,"\$categoryConfig['id_".$category['id']."']['plugins'] =         ".$category['plugins'].";\n");
        fwrite($file,"\$categoryConfig['id_".$category['id']."']['showtags'] =        ".$category['showtags'].";\n");
        fwrite($file,"\$categoryConfig['id_".$category['id']."']['showpagedate'] =    ".$category['showpagedate'].";\n");
        fwrite($file,"\$categoryConfig['id_".$category['id']."']['sortbypagedate'] =  ".$category['sortbypagedate'].";\n\n");
        
        fwrite($file,"\$categoryConfig['id_".$category['id']."']['styleFile'] =       '".$category['styleFile']."';\n");
        fwrite($file,"\$categoryConfig['id_".$category['id']."']['styleId'] =         '".str_replace(array('#','.'),'',$category['styleId'])."';\n");
        fwrite($file,"\$categoryConfig['id_".$category['id']."']['styleClass'] =      '".str_replace(array('#','.'),'',$category['styleClass'])."';\n\n");
        
        fwrite($file,"\$categoryConfig['id_".$category['id']."']['thumbWidth'] =      '".$category['thumbWidth']."';\n");
        fwrite($file,"\$categoryConfig['id_".$category['id']."']['thumbHeight'] =     '".$category['thumbHeight']."';\n");
        fwrite($file,"\$categoryConfig['id_".$category['id']."']['thumbRatio'] =      '".$category['thumbRatio']."';\n\n\n");
        
      }    
      fwrite($file,'return $categoryConfig;');
      
      fwrite($file,PHPENDTAG); //? >
    flock($file,3); //LOCK_UN
    fclose($file);
  
    return true;
  } else
    return false;
}

// ** -- moveCategories ----------------------------------------------------------------------------------
// moves a category UP or DOWN in the categories array
// -----------------------------------------------------------------------------------------------------
function moveCategories($category,            // the category id to be moved (Number)
                        $direction,           // the direction in wich to move (String "up" or "down")
                        $position = false) {  // the exact position where to put the category (iof not false, the directioon var dosn't matter)
  global $categoryConfig;
  
  $direction = strtolower($direction);
  
  // ->> CHECKS
  // if they fail it returns the unchanged $categoryConfig array
  if(is_array($categoryConfig) &&                         // is categories is array
    is_numeric($category) &&                          // have the given category id is a number
    $category == $categoryConfig['id_'.$category]['id'] &&     // dows the category exists in the $categoryConfig array
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
      $categoryConfig['id_'.$sortetCategory['id']] = $sortetCategory;
    }
    
    return $categoryConfig;
  
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
 * @param array $adminConfig a $adminConfig array
 * 
 * @return bool TRUE if the file was succesfull saved, otherwise FALSE
 * 
 * @example backend/adminConfig.array.example.php of the $adminConfig array
 * 
 * @version 1.0
 * <br>
 * <b>ChangeLog</b><br>
 *    - 1.0 initial release
 * 
 */
function saveAdminConfig($adminConfig) {

  // **** opens admin.config.php for writing
  if($file = @fopen(dirname(__FILE__)."/../../config/admin.config.php","w")) {
    
    // CHECK BOOL VALUES and change to FALSE
    $adminConfig['user']['editWebsiteFiles'] = (isset($adminConfig['user']['editWebsiteFiles']) && $adminConfig['user']['editWebsiteFiles']) ? 'true' : 'false';
    $adminConfig['user']['editStylesheets'] = (isset($adminConfig['user']['editStylesheets']) && $adminConfig['user']['editStylesheets']) ? 'true' : 'false';
    $adminConfig['setStartPage'] = (isset($adminConfig['setStartPage']) && $adminConfig['setStartPage']) ? 'true' : 'false';
    $adminConfig['page']['createPages'] = (isset($adminConfig['page']['createPages']) && $adminConfig['page']['createPages']) ? 'true' : 'false';
    $adminConfig['page']['thumbnailUpload'] = (isset($adminConfig['page']['thumbnailUpload']) && $adminConfig['page']['thumbnailUpload']) ? 'true' : 'false';
    $adminConfig['page']['plugins'] = (isset($adminConfig['page']['plugins']) && $adminConfig['page']['plugins']) ? 'true' : 'false';
    $adminConfig['page']['showtags'] = (isset($adminConfig['page']['showtags']) && $adminConfig['page']['showtags']) ? 'true' : 'false';

    flock($file,2); // LOCK_EX
    fwrite($file,PHPSTARTTAG); //< ?php
    
    fwrite($file,"\$adminConfig['url'] =              '".$adminConfig['url']."';\n");
    fwrite($file,"\$adminConfig['basePath'] =         '".$adminConfig['basePath']."';\n");
    fwrite($file,"\$adminConfig['savePath'] =         '".$adminConfig['savePath']."';\n");
    fwrite($file,"\$adminConfig['uploadPath'] =       '".$adminConfig['uploadPath']."';\n");  
    fwrite($file,"\$adminConfig['websitefilesPath'] = '".$adminConfig['websitefilesPath']."';\n");
    fwrite($file,"\$adminConfig['stylesheetPath'] =   '".$adminConfig['stylesheetPath']."';\n");    
    fwrite($file,"\$adminConfig['dateFormat'] =       '".$adminConfig['dateFormat']."';\n");
    fwrite($file,"\$adminConfig['speakingUrl'] =      '".$adminConfig['speakingUrl']."';\n\n");
    
    fwrite($file,"\$adminConfig['varName']['page'] =     '".$adminConfig['varName']['page']."';\n");  
    fwrite($file,"\$adminConfig['varName']['category'] = '".$adminConfig['varName']['category']."';\n");  
    fwrite($file,"\$adminConfig['varName']['modul'] =    '".$adminConfig['varName']['modul']."';\n\n");
    
    fwrite($file,"\$adminConfig['user']['editWebsiteFiles'] =    ".$adminConfig['user']['editWebsiteFiles'].";\n");
    fwrite($file,"\$adminConfig['user']['editStylesheets'] =     ".$adminConfig['user']['editStylesheets'].";\n");  
    fwrite($file,"\$adminConfig['user']['info'] =                '".$adminConfig['user']['info']."';\n\n");
    
    fwrite($file,"\$adminConfig['setStartPage'] =            ".$adminConfig['setStartPage'].";\n");
    fwrite($file,"\$adminConfig['page']['createPages'] =     ".$adminConfig['page']['createPages'].";\n");
    fwrite($file,"\$adminConfig['page']['thumbnailUpload'] = ".$adminConfig['page']['thumbnailUpload'].";\n");    
    fwrite($file,"\$adminConfig['page']['plugins'] =         ".$adminConfig['page']['plugins'].";\n");
    fwrite($file,"\$adminConfig['page']['showtags'] =        ".$adminConfig['page']['showtags'].";\n\n");
    
    fwrite($file,"\$adminConfig['editor']['enterMode'] =   '".$adminConfig['editor']['enterMode']."';\n");
    fwrite($file,"\$adminConfig['editor']['styleFile'] =   '".$adminConfig['editor']['styleFile']."';\n");
    fwrite($file,"\$adminConfig['editor']['styleId'] =     '".$adminConfig['editor']['styleId']."';\n");  
    fwrite($file,"\$adminConfig['editor']['styleClass'] =  '".$adminConfig['editor']['styleClass']."';\n\n");  
  
    fwrite($file,"\$adminConfig['pageThumbnail']['width'] =      '".$adminConfig['pageThumbnail']['width']."';\n");
    fwrite($file,"\$adminConfig['pageThumbnail']['height'] =     '".$adminConfig['pageThumbnail']['height']."';\n");
    fwrite($file,"\$adminConfig['pageThumbnail']['ratio'] =      '".$adminConfig['pageThumbnail']['ratio']."';\n");
    fwrite($file,"\$adminConfig['pageThumbnail']['path'] =       '".$adminConfig['pageThumbnail']['path']."';\n\n");
    
    fwrite($file,"return \$adminConfig;");
       
    fwrite($file,PHPENDTAG); //? >
    flock($file,3); //LOCK_UN
    fclose($file);   
    
    return true;
  } else
    return false;
}

// ** -- saveWebsiteConfig ----------------------------------------------------------------------------------
// open the config/website.config.php
// -----------------------------------------------------------------------------------------------------
function saveWebsiteConfig($websiteConfig) {  // (Array) with the settings to save
   
  // opens the file for writing
  if($file = @fopen("config/website.config.php","w")) {
    
    // CHECK BOOL VALUES and change to FALSE
    //$websiteConfig['noname'] = (isset($websiteConfig['noname']) && $websiteConfig['noname']) ? 'true' : 'false';
    
    
    // format keywords
    $keywords = preg_replace("/ +/", ' ', $websiteConfig['keywords']);
    $keywords = preg_replace("/,+/", ',', $keywords);
    $keywords = str_replace(', ',',', $keywords);
    $keywords = str_replace(' ,',',', $keywords);
    $keywords = str_replace(' ',',', $keywords);
    
    // *** write
    flock($file,2); //LOCK_EX
      fwrite($file,PHPSTARTTAG); //< ?php
  
      fwrite($file,"\$websiteConfig['title']          = '".htmlentities($websiteConfig['title'],ENT_QUOTES,'UTF-8')."';\n");
      fwrite($file,"\$websiteConfig['publisher']      = '".htmlentities($websiteConfig['publisher'],ENT_QUOTES,'UTF-8')."';\n");
      fwrite($file,"\$websiteConfig['copyright']      = '".htmlentities($websiteConfig['copyright'],ENT_QUOTES,'UTF-8')."';\n");
      fwrite($file,"\$websiteConfig['keywords']       = '".htmlentities($keywords,ENT_QUOTES,'UTF-8')."';\n");
      fwrite($file,"\$websiteConfig['description']    = '".htmlentities($websiteConfig['description'],ENT_QUOTES,'UTF-8')."';\n");
      fwrite($file,"\$websiteConfig['contactMail']    = '".$websiteConfig['contactMail']."';\n\n");
      
      fwrite($file,"\$websiteConfig['startPage']      = '".$websiteConfig['startPage']."';\n\n");
      
      fwrite($file,"return \$websiteConfig;");
    
      fwrite($file,PHPENDTAG); //? >
    flock($file,3); //LOCK_UN
    fclose($file);
  
    return true;
  } else
    return false;
}

// ** -- saveStatisticConfig ----------------------------------------------------------------------------------
// open the config/statistic.config.php
// -----------------------------------------------------------------------------------------------------
function saveStatisticConfig($statisticConfig) {  // (Array) with the settings to save
   
  // opens the file for writing
  if($file = @fopen("config/statistic.config.php","w")) {
    
    // CHECK BOOL VALUES and change to FALSE
    //$statisticConfig['noname'] = (isset($statisticConfig['noname']) && $statisticConfig['noname']) ? 'true' : 'false';
    
    // WRITE
    flock($file,2); //LOCK_EX
      fwrite($file,PHPSTARTTAG); //< ?php
  
      fwrite($file,"\$statisticConfig['number']['mostVisitedPages']        = '".$statisticConfig['number']['mostVisitedPages']."';\n");
      fwrite($file,"\$statisticConfig['number']['longestVisitedPages']     = '".$statisticConfig['number']['longestVisitedPages']."';\n");
      fwrite($file,"\$statisticConfig['number']['lastEditedPages']         = '".$statisticConfig['number']['lastEditedPages']."';\n\n");
      
      fwrite($file,"\$statisticConfig['number']['refererLog']    = '".$statisticConfig['number']['refererLog']."';\n");
      fwrite($file,"\$statisticConfig['number']['taskLog']       = '".$statisticConfig['number']['taskLog']."';\n\n");
      
      
      fwrite($file,"return \$statisticConfig;");
    
      fwrite($file,PHPENDTAG); //? >
    flock($file,3); //LOCK_UN
    fclose($file);
  
    return true;
  } else
    return false;
}


 /**
  * Generates a editable textfield with a file selection and a input for creating new files
  *
  * <b>Type</b>     function<br>
  * <b>Name</b>     editFiles()<br>
  * 
  *
  * @param string		$filesPath	the path where all files (also files in subfolders) will be shown for editing
  * @param string		$siteName	a site name which will be set to the $_GET['site'] variable in the formular action attribute
  * @param string		$status		a status name which will be set to the $_GET['status'] variable in the formular action attribute
  * @param string		$titleText	a title text which will be displayed as the title of the edit files textfield
  * @param string		$anchorName	the name of the anchor which will be added to the formular action attribute
  * @param string|false		$fileType       (optional) a filetype which will be added to each ne created file
  * @param string|array|false	$excluded	(optional) a string (seperated with ",") or array with files or folder names which should be excluded from the file selection, if FALSE no file will be excluded
  *
  * @uses DOCUMENTROOT		for the full path to the files for opening
  * @uses readFolderRecursive()	reads the $filesPath folder recursive and loads all file paths in an array
  *
  * @return void displayes the file edit textfield
  *
  * @version 1.0
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.0 initial release
  *
  */
function editFiles($filesPath, $siteName, $status, $titleText, $anchorName, $fileType = false, $excluded = false) {
  global $langFile;
  global $savedForm;
  
  // var
  $fileTypeText = null;
  
  // shows the block below if it is the ones which is saved before
  $hidden = ($_GET['status'] == $status || $savedForm === $status) ? '' : ' hidden';

  echo '<form action="?site='.$siteName.'#'.$anchorName.'" method="post" enctype="multipart/form-data" accept-charset="UTF-8">
        <div>
        <input type="hidden" name="send" value="saveEditedFiles" />
        <input type="hidden" name="status" value="'.$status.'" />
        <input type="hidden" name="filesPath" value="'.$filesPath.'" />';
  if($fileType)
    echo '<input type="hidden" name="fileType" value=".'.$fileType.'" />';
  echo '</div>';
  
  echo '<div class="block'.$hidden.'">
          <h1><a href="#" name="'.$anchorName.'">'.$titleText.'</a></h1>
          <div class="content"><br />';
      
      //echo $filesPath.'<br />';      
      // gets the files out of the directory --------------
      // adds the DOCUMENTROOT  
      $filesPath = str_replace(DOCUMENTROOT,'',$filesPath);  
      $dir = DOCUMENTROOT.$filesPath;
      if(!empty($filesPath) && is_dir($dir)) {
        $files = readFolderRecursive($filesPath);
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
	
	// only if still are files left
	if(is_array($files) && !empty($files)) {
	  $isDir = true;	
	  // sort the files in a natural way (alphabetical)
	  natsort($files);
	}
      // dont show files but show directory error       
      } else {
        echo '<code>"'.$filesPath.'"</code> <b>'.$langFile['editFilesSettings_noDir'].'</b>';
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
        if(isset($files)) {
          echo '<div class="editFiles left">
                <h2>'.$langFile['editFilesSettings_chooseFile'].'</h2>
                <input type="text" value="'.$filesPath.'" readonly="readonly" style="width:auto;" size="'.(strlen($filesPath)-2).'" />'."\n";
          echo '<select onchange="changeFile(\''.$siteName.'\',this.value,\''.$status.'\',\''.$anchorName.'\');">'."\n";
     
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
              <h2>'.$langFile['editFilesSettings_createFile'].'</h2>
              <input name="newFile" style="width:200px;" class="toolTip" title="'.$langFile['editFilesSettings_createFile'].'::'.$langFile['editFilesSettings_createFile_inputTip'].'" /> '.$fileTypeText.'
              </div>';
      }
      
      // OPEN THE FILE -------------------------------------
      if(@is_file(DOCUMENTROOT.$editFile)) {
        $editFileOpen = fopen(DOCUMENTROOT.$editFile,"r");  
        $file = @fread($editFileOpen,filesize(DOCUMENTROOT.$editFile));
        fclose($editFileOpen);
        
        echo '<input type="hidden" name="file" value="'.$editFile.'" />'."\n";

        $file = str_replace(array('<','>'),array('&lt;','&gt;'),$file);
        
        echo '<textarea name="fileContent" cols="90" rows="30" class="editFiles">'.$file.'</textarea>';
      }  
  
  
  if($isDir) {
    echo '<a href="?site='.$siteName.'&amp;status=deleteEditFiles&amp;editFilesStatus='.$status.'&amp;file='.$editFile.'#'.$anchorName.'" onclick="openWindowBox(\'library/sites/deleteEditFiles.php?site='.$siteName.'&amp;status=deleteEditFiles&amp;editFilesStatus='.$status.'&amp;file='.$editFile.'&amp;anchorName='.$anchorName.'\',\''.$langFile['editFilesSettings_deleteFile'].'\');return false;" class="cancel left toolTip" title="'.$langFile['editFilesSettings_deleteFile'].'::" style="float:left;"></a>';
    echo '<br /><br /><br /><input type="submit" value="" name="saveEditedFiles" class="toolTip button submit right" title="'.$langFile['form_submit'].'" />';
  }
  echo '</div>
      <div class="bottom"></div>
    </div>
    </form>';
}

// ** -- saveEditedFiles ----------------------------------------------------------------------------------
// save the files which where edited with editFiles()
// -----------------------------------------------------------------------------------------------------
// $post            [postvariable with the filename and filecontent (array)]
function saveEditedFiles($post) {
    global $_POST;
    
    // add DOCUMENTROOT
    $post['file'] = str_replace(DOCUMENTROOT,'',$post['file']);  
    $post['file'] = DOCUMENTROOT.$post['file'];    
    $post['filesPath'] = str_replace(DOCUMENTROOT,'',$post['filesPath']);  
    $post['filesPath'] = DOCUMENTROOT.$post['filesPath'];    
    
    
    // ->> SAVE FILE
    if(@is_file($post['file']) && empty($post['newFile'])) {

      $post['fileContent'] = str_replace('\"', '"', $post['fileContent']);
      $post['fileContent'] = str_replace("\'", "'", $post['fileContent']);
      //$post['fileContent'] 	= str_replace("<br />", "", $post['fileContent']);
      $post['fileContent'] = stripslashes($post['fileContent']);
      
      // wandelt umlaut in HTML zeichen um
      $post['fileContent'] = htmlentities($post['fileContent'],ENT_NOQUOTES,'UTF-8');      
      // changes & back, because of the $auml;
      $post['fileContent'] = str_replace("&amp;", "&", $post['fileContent']);
      // wandelt die php einleitungstags wieder in zeichen um
      $post['fileContent'] = str_replace(array('&lt;','&gt;'),array('<','>'),$post['fileContent']);
      
      if($file = fopen($post['file'],"w")) {
      flock($file,2);
      fwrite($file,$post['fileContent']);
      flock($file,3);
      fclose($file);      
      
      $_GET['status'] = $_POST['status'];
      $_GET['file'] = $_POST['file'];
      return true;      
      }
      
    // ->> NEW FILE
    } else { // erstellt eine neue datei wenn etwas ins das neu erstellen Feld eingetragen wurde
      
      $post['newFile'] = str_replace( array(" ","%","+","&","#","!","?","$","§",'"',"'","(",")"), '_', $post['newFile'] ) ;
      $post['newFile'] = str_replace( array("ä","ü","ö","ß",'\"'), array("ae","ue","oe","ss","-"), $post['newFile'] ) ;
      
      $post['newFile'] = str_replace($post['fileType'],'',$post['newFile']);
      
      $fullFilePath = $post['filesPath'].'/'.$post['newFile'].$post['fileType'];
      
      //clean vars
      $fullFilePath = preg_replace("/\/+/", '/', $fullFilePath);
      
      if($file = @fopen($fullFilePath,"w")) {
        
        $_GET['status'] = $_POST['status'];
        $_GET['file'] = str_replace(DOCUMENTROOT,'',$fullFilePath);
        
        return true;
      }
    }
    return false;
}

// ** -- delDir ----------------------------------------------------------------------------------------
// deletes a dir, with files in it
// -----------------------------------------------------------------------------------------------------
// $dir            [the directory to be deleted, must end with a slash "/" (array)]
function delDir($dir) {
    $files = glob( $dir . '*', GLOB_MARK );
    foreach( $files as $file ){
        if( substr( $file, -1 ) == '/' )
            delTree( $file );
        else
            unlink( $file );
    }
    if(rmdir( $dir ))
      return true;
    else
      return false;
}

// ** -- movePage ----------------------------------------------------------------------------------
// move a file to a new destination
// -----------------------------------------------------------------------------------------------------
// $page            [page id wich will be moved (String)],
// $fromCategory    [category id where the file is situated (String)]
// $toCategory      [category id where it will be moved in (String)]
function movePage($page, $fromCategory, $toCategory) {
  global $adminConfig;
  
  // if there are pages not in a category set the category to empty
  if($fromCategory === false || $fromCategory == 0)
    $fromCategory = '';
  if($toCategory === false || $toCategory == 0)
    $toCategory = '';
    
  // MOVE categories
  if(@copy(DOCUMENTROOT.$adminConfig['savePath'].$fromCategory.'/'.$page.'.php',
    DOCUMENTROOT.$adminConfig['savePath'].$toCategory.'/'.$page.'.php') &&
    @unlink(DOCUMENTROOT.$adminConfig['savePath'].$fromCategory.'/'.$page.'.php'))
    return true;
  else
    return false;
}

// ** -- fileFolderIsWritableWarning ----------------------------------------------------------------------------------
// checks the file/folder if it is writeable, and gives back an error text if not (made for the admin.config.php)
// -----------------------------------------------------------------------------------------------------
// $fileFolder  [the File or Folder which is checked for writeability, must beginn with a "/" (String)]
function fileFolderIsWritableWarning($fileFolder) {
  global $langFile;
  
  if(substr($fileFolder,0,1) != '/')
    $fileFolder = '/'.$fileFolder;
  
  if(is_writable(DOCUMENTROOT.$fileFolder) === false) {
      return '<span class="warning toolTip" title="'.$fileFolder.'::'.$langFile['adminSetup_error_writeAccess_tip'].'"><b>&quot;'.$fileFolder.'&quot;</b> -> '.$langFile['adminSetup_error_writeAccess'].'</span><br />';
  } else return false;
}

// ** -- isFolderWarning ----------------------------------------------------------------------------------
// checks the folder exists, and gives back an error text if not (made for the admin.config.php)
// -----------------------------------------------------------------------------------------------------
// $folder  [the File or Folder which is checked for writeability, must beginn with a "/" (String)]
function isFolderWarning($folder) {
  global $langFile;
  
  if(substr($folder,0,1) != '/')
    $folder = '/'.$folder;

  if(is_dir(DOCUMENTROOT.$folder) === false) {
      return '<span class="warning"><b>&quot;'.$folder.'&quot;</b> -> '.$langFile['adminSetup_error_isFolder'].'</span><br />';
  } else return false;
}

// ** -- getHighestId ----------------------------------------------------------------------------------
// gets the highest ID of all pages in all categories
// -----------------------------------------------------------------------------------------------------
function getHighestId() {
  
  $cats = $GLOBALS['categoryConfig'];
  array_unshift($cats,array('id' => 0));
  
  // loads the file list in an array
  $pages = $GLOBALS['generalFunctions']->getStoredPageIds();
  
  $highestId = 0;
  
  // go trough the file list and look for the highest number
  if(is_array($pages)) {
    foreach($pages as $page) {
      $pageId = $page['page'];
          
      if($pageId > $highestId)
        $highestId = $pageId;
    }
  }
  return $highestId;
}

// ** -- readFolder ----------------------------------------------------------------------------------
// OPENS a Folder and RETURNs an Hash with $return['folders'][0] ,.. and $return['files'][0] ,..
// -----------------------------------------------------------------------------------------------------------
function readFolder($folder) {
  
  if(empty($folder))
    return false;
  
  //change windows path
  $folder = str_replace('\\','/',$folder);
  
  // -> adds / on the beginning of the folder
  if(substr($folder,0,1) != '/')
    $folder = '/'.$folder;
  // -> adds / on the end of the folder
  if(substr($folder,-1) != '/')
    $folder .= '/';
  
  //clean vars  
  $folder = preg_replace("/\/+/", '/', $folder);
  $folder = str_replace('/'.DOCUMENTROOT,DOCUMENTROOT,$folder);  
  
  // vars
  $return = false;  
  $fullFolder = $folder;
  
  // adds the DOCUMENTROOT  
  $fullFolder = str_replace(DOCUMENTROOT,'',$fullFolder);  
  $fullFolder = DOCUMENTROOT.$fullFolder; 
  
  // open the folder and read the content
  if(is_dir($fullFolder)) {
    $openedDir = @opendir($fullFolder);  // @ zeichen eingefügt
    while(false !== ($inDirObjects = @readdir($openedDir))) {
      if($inDirObjects != "." && $inDirObjects != "..") {      
        if(is_dir($fullFolder.$inDirObjects)) {        
          $return['folders'][] = $folder.$inDirObjects;
        } elseif(is_file($fullFolder.$inDirObjects)) {
          $return['files'][] = $folder.$inDirObjects;
        }
      }
    }
    @closedir($openedDir);
  }
  
  return $return;  
}

// ** -- readFolderRecursive ----------------------------------------------------------------------------------
// OPENS a Folder and ALL SUBFOLDERS and RETURNs an Array with $return['folders'][0] ,.. and $return['files'][0] ,..
// -----------------------------------------------------------------------------------------------------------
function readFolderRecursive($folder) {
  
  if(empty($folder))
    return false;
  
  // adds a slash on the beginning
  if(substr($folder,0,1) != '/')
    $folder = '/'.$folder;
  
  //clean vars
  $folder = preg_replace("/\/+/", '/', $folder);
  $folder = str_replace('/'.DOCUMENTROOT,DOCUMENTROOT,$folder);
  
  //vars  
  $fullFolder = DOCUMENTROOT.$folder;  
  $goTroughFolders['folders'][0] = $fullFolder;
  $goTroughFolders['files'] = array();
  $subFolders = array();
  $files = array();
  $return['folders'] = false;
  $return['files'] = false;
    
  // ->> goes trough all SUB-FOLDERS  
  while(!empty($goTroughFolders['folders'][0])) {

    // ->> GOES TROUGH folders
    foreach($goTroughFolders['folders'] as $subFolder) {
      //echo '<br /><br />'.$subFolder.'<br />';     
      $inDirObjects = readFolder($subFolder);
      
      // -> add all subfolders to an array
      if(is_array($inDirObjects['folders'])) {        
        $subFolders = array_merge($subFolders, $inDirObjects['folders']);
      }        
    
      // -> add folders to the $return array
      if(is_array($inDirObjects['folders'])) {
        foreach($inDirObjects['folders'] as $folder) {
          $return['folders'][] = str_replace(DOCUMENTROOT,'',$folder);
        }
      }
      // -> add files to the $return array
      if(is_array($inDirObjects['files'])) {
        foreach($inDirObjects['files'] as $file) {
          $return['files'][] = str_replace(DOCUMENTROOT,'',$file);
        }
      }
    }
    
    $goTroughFolders['folders'] = $subFolders;
    $goTroughFolders['files'] = $files;

    $subFolders = array();
    $files = array();
  }

  return $return;
} 


// ** -- showModulesPlugins ----------------------------------------------------------------------------------
// opens the modules and plugin folder and return tru if there something in
// -----------------------------------------------------------------------------------------------------------
// $folder    [the ABSOLUTE PATH of the Folder which will be checked (String)]
function folderIsEmpty($folder) {
  
  if(readFolder($folder) === false)
    return true;
  else
    return false;

}

// ** -- checkBasePath ----------------------------------------------------------------------------------
// CHECKs if the current basePath is matching the real basePath
// RETURNs TRUE if the basePath is correct, otherwise false
// -----------------------------------------------------------------------------------------------------------
function checkBasePath() {
  global $adminConfig;
  
  $basePath = str_replace('www.','',$adminConfig['url']);
  $checkPath = str_replace('www.','',$_SERVER["HTTP_HOST"]);
  
  if($adminConfig['basePath'] !=  dirname($_SERVER['PHP_SELF']).'/' ||
     $basePath != $checkPath)
    return false;
  else return true;
}

// ** -- basePathWarning ----------------------------------------------------------------------------------
// CHECKs if the current basePath is matching the real basePath, if not throw a warning
// SHOWs a warning, if the basePath is incorrect
// -----------------------------------------------------------------------------------------------------------
function basePathWarning() {
  global $langFile;
  
  if(checkBasePath() === false) {
    echo '<div class="block warning">
            <h1>'.$langFile['warning_fmsConfWarning_h1'].'</h1>
            <div class="content">
              <p>'.$langFile['warning_fmsConfWarning'].'</p><!-- needs <p> tags for margin-left:..--> 
            </div> 
            <div class="bottom"></div> 
          </div>';
  }
}

// ** -- startPageWarning ----------------------------------------------------------------------------------
// CHECKs if a STARTPAGE is SET and if this page exists
// SHOWs a warning, if the basePath is incorrect
// -----------------------------------------------------------------------------------------------------------
function startPageWarning() {
  global $adminConfig;
  global $websiteConfig;
  global $generalFunctions;
  global $langFile;
  
  if($adminConfig['setStartPage'] && $websiteConfig['startPage'] && ($startPageCategory = $generalFunctions->getPageCategory($websiteConfig['startPage'])) != 0)
    $startPageCategory .= '/';
  else
    $startPageCategory = '';
  
  if($adminConfig['setStartPage'] && (!$websiteConfig['startPage'] || !file_exists(DOCUMENTROOT.$adminConfig['savePath'].$startPageCategory.$websiteConfig['startPage'].'.php'))) {
    echo '<div class="block info">
            <h1>'.$langFile['warning_startPageWarning_h1'].'</h1>
            <div class="content">
              <p>'.$langFile['warning_startPageWarning'].'</p><!-- needs <p> tags for margin-left:..--> 
            </div> 
            <div class="bottom"></div> 
          </div>';
  }
}

// ** -- createStyleTags ----------------------------------------------------------------------------------
// GOs trough a Folder and its Sub-Folders and creates a HTML-Style-Tag out of every CSS-File
// -----------------------------------------------------------------------------------------------------------
function createStyleTags($folder) {
  global $adminConfig;
  
  // ->> goes trough all folder and subfolders
  $filesInFolder = readFolderRecursive($folder);
  if(is_array($filesInFolder['files'])) {
    foreach($filesInFolder['files'] as $file) {
      // -> check for CSS FILES
      if(substr($file,-4) == '.css') {
        // -> removes the $adminConfig('basePath')
        $file = str_replace($adminConfig['basePath'],'',$file);
        // -> WRITES the HTML-Style-Tags
        echo '  <link rel="stylesheet" type="text/css" href="'.$file.'" media="screen" />'."\n";
      }
    }
  }
  
}

?>