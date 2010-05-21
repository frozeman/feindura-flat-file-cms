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
 * This file contains the {@link generalFunctions} class
 * 
 * This class provides functions which will be used by the FRONTEND and the BACKEND.
 * 
 * @package feindura-CMS
 */
/**
* Contains the basic functions for reading and saving pages
* 
* These functions are used by the FRONTEND and the BACKEND.
* 
* @package feindura-CMS
* @subpackage Functions
*    
* @version 1.16
* <br>
*  <b>ChangeLog</b><br>
*    - 1.16 started documentation
*/ 
class generalFunctions {
 
 /* ---------------------------------------------------------------------------------------------------------------------------- */
 /* *** PROPERTIES *** */
 /* **************************************************************************************************************************** */
 
 // PUBLIC
 // *********
  
  /**
  * Contains the administrator-settings config <var>array</var>
  * 
  * @var array
  * @see generalFunctions()
  * 
  */ 
  var $adminConfig;
  
  /**
  * Contains the category-settings config <var>array</var>
  * 
  * @var array
  * @see generalFunctions()
  * 
  */ 
  var $categoryConfig;
  
   /**
  * Contains all page and category IDs on the first loading of a page.
  * 
  * On the first loading of a page, in a #feindura <var>class</var> instance, 
  * it goes trough all category folders and look which pages are in which folders and saves the IDs in the this property,<br>
  * to speed up the page loading process.
  * 
  * Example of the returned array:
  * {@example loadPageIds.return.example.php}
  * 
  * @var array
  * 
  */
  var $storedPageIds = null;
  
 /**
  * Stores page-content <var>array's</var> in this property if a page is loaded
  * 
  * If a page is loaded (<i>included</i>) it's page-content array will be stored in the this array.<br>
  * If the page is later needed again it's page-content will be fetched from this property.<br>
  * It should speed up the page loading process.
  * 
  * @example loadPages.return.example.php of the returned array
  * 
  * @var array
  * 
  */
  var $storedPages = null;
 
 /* ---------------------------------------------------------------------------------------------------------------------------- */
 /* *** CONSTRUCTOR *** */
 /* **************************************************************************************************************************** */
  
 /**
  * <b> Type</b>      constructor<br>
  * <b> Name</b>      generalFunctions()<br>
  * 
  * The constructor of the class, gets the settings.
  * 
  * <b>Used Global Variables</b><br>
  *    - <var>$adminConfig</var> array the administrator-settings config (included in the {@link general.include.php})
  *    - <var>$categoryConfig</var> array the categories-settings config (included in the {@link general.include.php})
  * 
  * @return void
  * 
  * @version 1.0
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.0 initial release
  * 
  */ 
  function generalFunctions() {
    
    // GET CONFIG FILES and SET CONFIG PROPERTIES
    $this->adminConfig = $GLOBALS['adminConfig'];
    $this->categoryConfig = $GLOBALS['categoryConfig'];

  }
  
 /* ---------------------------------------------------------------------------------------------------------------------------- */
 /* *** METHODS *** */
 /* **************************************************************************************************************************** */
  
 /**
  * <b>Name</b> checkLanguageFiles()<br>
  * 
  * Checks for the browser language and looks if there is a file in the language folder with tha same country code in the filename end.
  * 
  * If there is a language file which matches the browser language it loads either the language-file or returns the country code,
  * depending on the <var>$returnLangFile</var> parameter.
  * 
  * If no match to the browser language is found it uses the <var>$standardLang</var> parameter for loading a languageFile or returning the country code.
  * 
  * @param string|false $useLangPath      a absolut path to look for language files or FALSE to use the "feindura-cms/library/lang" folder
  * @param bool         $returnLangFile   if TRUE it includes and returns the language-file which matches the browser language
  * @param bool         $standardLang     a standard language for use if no match was found
  * 
  * @uses $adminConfig  for the base path of the CMS
  * 
  * @return string|array|false a country code (like: de, en, fr..) or the language-file array or FALSE if the language file could not be opend
  * 
  * 
  * @version 1.0
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.0 initial release
  * 
  */
  function checkLanguageFiles($useLangPath = false, $returnLangFile = true, $standardLang = 'en') {  
     
      // checks if a path given
      if(is_string($useLangPath)) {
        // adds "/" on the beginnging for absolute path
        if(substr($useLangPath,0,1) != '/')
          $useLangPath = '/'.$useLangPath;
        $langPath = DOCUMENTROOT.$useLangPath;
      } else
        $langPath = DOCUMENTROOT.$this->adminConfig['basePath'].'library/lang/'; // $this->adminConfig['websitefilesPath']
  
      // opens the lang Dir
      if(!$openlangdir = @opendir($langPath)) {
        if(!$returnLangFile)
          return $standardLang;
        else
          return false;
      }   
      
      // go trough the lang Dir
      while(false !== ($lang_file = @readdir($openlangdir))) {
        if($lang_file != "." && $lang_file != ".." && 
           is_file($langPath.$lang_file)) {
          
          $langFileSchema = $lang_file;
          
          // checks if the BROWSER STANDARD LANGUAGE is found in the SUPPORTED COUNTRY CODE
          $l = explode(",", $_SERVER['HTTP_ACCEPT_LANGUAGE']);
        	while(list($key, $value) = each($l)) {
        	  $browserData = strtolower(substr($value, 0, 2));
        		if(strstr(strtolower(substr(substr($lang_file,-6),0,2)).",", $browserData.",") ||
               strstr(strtolower(substr($lang_file,0,2)).",", $browserData.",")) {
        		  // returns either langFile or the COUNTRY CODE
        		  if($returnLangFile) {
        		    if($langFile = @include($langPath.$lang_file))
                  return $langFile;
                else
                  return false;
        		  } else {
        			   return $browserData;
        			}
        		}
        	}
        }
      }
      @closedir($mod_openedmodul);      
      
    	// if there is no SUPPORTED COUNTRY CODE, use the standard Lang  	
    	if($returnLangFile) {
        if(!empty($langFileSchema)) {
          if($langFile = @include($langPath.substr($langFileSchema,0,-6).$standardLang.'.php') ||
             $langFile = @include($langPath.$standardLang.substr($langFileSchema,2)))
            return $langFile;
          else
            return false;
        } else
         return false;
  	     
  	  // return only the standard COUNTRY CODE
  	  } else
  		  return $standardLang;  	 
  }
  
 /**
  * <b>Name</b> getStoredPageIds()<br>
  * 
  * Fetches the {@link $storedPageIds} property.
  * 
  * If the {@link $storedPageIds} property is empty, it loads all page IDs into this property.
  * 
  * Example of the returned {@link $storedPageIds} property:
  * {@example loadPageIds.return.example.php}
  * 
  * @uses $storedPageIds the property to get
  * 
  * @return array the {@link $storedPageIds} property
  * 
  * 
  * @version 1.0
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.0 initial release
  * 
  */
  function getStoredPageIds() { // (false or Array)
  
    // load all page ids, if necessary
    if($this->storedPageIds === null)
      $this->storedPageIds = $this->loadPageIds(true);

    return $this->storedPageIds;
  }

 /**
  * <b>Name</b> getStoredPages()<br>
  * 
  * Fetches the {@link $storedPages} property.
  * 
  * Its also possible to fetch the {@link $storedPages} property from the <var>$_SESSION</var> variable. (CURRENTLY DEACTIVATED)
  * 
  * @uses $storedPages the property to get
  * 
  * @return array the {@link $storedPages} property
  * 
  * @example loadPages.return.example.php of the returned array
  * 
  * @version 1.0
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.0 initial release
  * 
  */
  function getStoredPages() {
    global $HTTP_SESSION_VARS;
    
    unset($_SESSION['storedPages']);    
    //echo 'STORED-PAGES -> '.count($this->storedPages);
    
    // if its an older php version, set the session var
    if(phpversion() <= '4.1.0')
      $_SESSION = $HTTP_SESSION_VARS;    
      
    // -> checks if the SESSION storedPages Array exists
    if(isset($_SESSION['storedPages']))
      return $_SESSION['storedPages']; // if isset, get the storedPages from the SESSION
    else
      return $this->storedPages; // if not get the storedPages from the PROPERTY  
  }

 /**
  * <b>Name</b> setStoredPages()<br>
  * 
  * Adds or removes a <var>$pageContent</var> array to or from the {@link $storedPages} property.
  * If the second parameter <var>$remove</var> is TRUE it removes this $pageContent array from the {@link $storedPages} property.
  * Its also possible to store the {@link $storedPages} property in a <var>$_SESSION</var> variable. (CURRENTLY DEACTIVATED)
  * 
  * @param int  $pageContent   a $pageContent array which should be add to the {@link $storedPages} property
  * @param bool $remove        if TRUE it removes the given $pageContent array from the {@link $storedPages} property
  * 
  * @uses $storedPages        the property to add the $pageContent array
  * 
  * @return array passes through the given $pageContent array
  * 
  * 
  * @version 1.0
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.0 initial release
  * 
  */
  function setStoredPages($pageContent,$remove = false) {
    global $HTTP_SESSION_VARS;
    
    unset($_SESSION['storedPages']);
    
    // if its an older php version, set the session var
    if(phpversion() <= '4.1.0')
      $_SESSION = $HTTP_SESSION_VARS;  
    
    // stores the given parameter only if its a valid $pageContent array
    if($this->isPageContentArray($pageContent)) {
      
      // ->> ADD
      if($remove === false) {
        // -> checks if the SESSION storedPages Array exists
        if(isset($_SESSION['storedPages']))
          $_SESSION['storedPages'][$pageContent['id']] = $pageContent; // if isset, save the storedPages in the SESSION
        else {
          $this->storedPages[$pageContent['id']] = $pageContent; // if not save the storedPages in the PROPERTY
          $_SESSION['storedPages'][$pageContent['id']] = $pageContent;
        }
      
      // ->> REMOVE
      } elseif($remove === true) {
	// -> checks if the SESSION storedPages Array exists
        if(isset($_SESSION['storedPages']))
          unset($_SESSION['storedPages'][$pageContent['id']]); // if isset, remove from the storedPages in the SESSION
        else {
          unset($this->storedPages[$pageContent['id']]); // if not remove from the storedPages in the PROPERTY
          unset($_SESSION['storedPages'][$pageContent['id']]);
        }
      }
    }
    
    return $pageContent;
  }
  
 /**
  * <b>Name</b> getPageCategory()<br>
  * 
  * Return the category ID of a page.
  * 
  * @param int $page a page ID from which to get the category ID
  * 
  * @uses getStoredPageIds()            to get the {@link storedPageIds} property
  * 
  * @return int|false the right category ID or FALSE if the page ID doesn't exists
  * 
  * @version 1.0
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.0 initial release
  * 
  */
  function getPageCategory($page) {
             
    if($page !== false && is_numeric($page)) {
      // loads only the page IDs and category IDs in an array
      // but only if it hasn't done this yet
      $allPageIds = $this->getStoredPageIds();
        
      if($allPageIds) {
        // gets the category id of the given page
        foreach($allPageIds as $everyPage) {
          // if its the right page, return the category of it        
          if($page == $everyPage['page']) {
             return $everyPage['category'];
          }
        }
        // if it found nothing
        return false;
        
      } else return false;
    } else return false;
  }

 /**
  * <b>Name</b> savePage()<br>
  * 
  * Save a page to it's flatfile.
  * 
  * <b>Used Global Constants</b><br>
  *    - <var>DOCUMENTROOT</var> the absolut path of the webserver
  *    - <var>PHPSTARTTAG</var> the php start tag
  *    - <var>PHPENDTAG</var> the php end tag
  * 
  * @param array $pageContent the $pageContent array of the page to save    
  * 
  * @uses $adminConfig      for the save path of the flatfiles
  * @uses setStoredPages()  to store the saved file agiain, and overwrite th old stored page
  * 
  * @return bool TRUE if the page was succesfull saved, otherwise FALSE
  * 
  * @version 1.0
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.0 initial release
  * 
  */
  function savePage($pageContent) {
        
    // escaped ",',\,NUL undescapped aber wieder die "
    $pageContent['content'] = stripslashes($pageContent['content']);
    $pageContent['content'] = addslashes($pageContent['content']); //escaped ",',\,NUL
    $pageContent['content'] = str_replace('\"', '"', $pageContent['content'] );
    
    $pageId = $pageContent['id'];
    $categoryId = $pageContent['category'];
    
    // fügt hinter der gruppe ein / an wenn sie nicht leer ist
    if(!empty($categoryId) && $categoryId != 0)
      $categoryId = $categoryId.'/';
    
    //öffnet oder erstellt die flatfile
    if((($categoryId === false || $categoryId == 0) && $file = @fopen(DOCUMENTROOT.$this->adminConfig['savePath'].$pageId.'.php',"w")) ||
       $file = @fopen(DOCUMENTROOT.$this->adminConfig['savePath'].$categoryId.$pageId.'.php',"w")) {
        
      // CHECK BOOL VALUES and change to FALSE
      $pageContent['public'] = (isset($pageContent['public']) && $pageContent['public']) ? 'true' : 'false';
      
      // WRITE
      flock($file,2);            
      fwrite($file,PHPSTARTTAG);
      
      fwrite($file,"\$pageContent['id'] =                 ".$pageContent['id'].";\n");
      fwrite($file,"\$pageContent['category'] =           ".$pageContent['category'].";\n");
      fwrite($file,"\$pageContent['public'] =             ".$pageContent['public'].";\n");
      fwrite($file,"\$pageContent['sortorder'] =          ".$pageContent['sortorder'].";\n\n");
      
      fwrite($file,"\$pageContent['lastsavedate'] =       '".$pageContent['lastsavedate']."';\n");
      fwrite($file,"\$pageContent['lastsaveauthor'] =     '".$pageContent['lastsaveauthor']."';\n\n"); 
      
      fwrite($file,"\$pageContent['title'] =              '".$pageContent['title']."';\n");
      fwrite($file,"\$pageContent['description'] =        '".$pageContent['description']."';\n\n");      
      
      fwrite($file,"\$pageContent['pagedate']['before'] = '".$pageContent['pagedate']['before']."';\n");
      fwrite($file,"\$pageContent['pagedate']['date'] =   '".$pageContent['pagedate']['date']."';\n");
      fwrite($file,"\$pageContent['pagedate']['after'] =  '".$pageContent['pagedate']['after']."';\n");           
      fwrite($file,"\$pageContent['tags'] =               '".$pageContent['tags']."';\n");
      fwrite($file,"\$pageContent['plugins'] =            '".$pageContent['plugins']."';\n\n");
      
      fwrite($file,"\$pageContent['thumbnail'] =          '".$pageContent['thumbnail']."';\n");
      fwrite($file,"\$pageContent['styleFile'] =          '".$pageContent['styleFile']."';\n");
      fwrite($file,"\$pageContent['styleId'] =            '".$pageContent['styleId']."';\n");
      fwrite($file,"\$pageContent['styleClass'] =         '".$pageContent['styleClass']."';\n\n");
      
      fwrite($file,"\$pageContent['log_visitCount'] =     '".$pageContent['log_visitCount']."';\n");
      fwrite($file,"\$pageContent['log_visitTime_min'] =  '".$pageContent['log_visitTime_min']."';\n");
      fwrite($file,"\$pageContent['log_visitTime_max'] =  '".$pageContent['log_visitTime_max']."';\n");
      fwrite($file,"\$pageContent['log_firstVisit'] =     '".$pageContent['log_firstVisit']."';\n");
      fwrite($file,"\$pageContent['log_lastVisit'] =      '".$pageContent['log_lastVisit']."';\n");
      fwrite($file,"\$pageContent['log_searchwords'] =    '".$pageContent['log_searchwords']."';\n\n");
      
      fwrite($file,"\$pageContent['content'] = \n'".$pageContent['content']."';\n\n");
      
      fwrite($file,"return \$pageContent;");
      
      fwrite($file,PHPENDTAG);
      flock($file,3);
      fclose($file);
      
      // writes the new saved page to the $storedPages property
      $this->setStoredPages($pageContent);
      
      return true;
    }  
    return false;  
  }
  
 /**
  * <b>Name</b> readPage()<br>
  * 
  * Loads the $pageContent array of a page.
  * 
  * Checks first whether the given page ID was already loaded and is contained in the {@link $storedPages} property.
  * If not the {@link generalFunctions::readPage()} function is called to include the $pagecontent array of the page
  * and store it in the {@link $storedPages} property.
  * 
  * <b>Used Global Constants</b><br>
  *    - <var>DOCUMENTROOT</var> the absolut path of the webserver
  * 
  * @param int|array  $page           a page ID or a $pageContent array (will then returned immediately)
  * @param int        $category       (optional) a category ID, if FALSE it will try to load this page from the non-category
  * 
  * @uses getStoredPages()		for getting the {@link $storedPages} property
  * @uses setStoredPages()		to store a new loaded $pageContent array in the {@link $storedPages} property
  * 
  * @return array the $pageContent array of the requested page
  * 
  * @version 1.0
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.0 initial release
  * 
  */
  function readPage($page,$category = false) {
    //echo 'PAGE: '.$page.' -> '.$category.'<br />';
    
    // if $page is a valid $pageContent array return it immediately
    if($this->isPageContentArray($page))
      return $page;
       
    $storedPages = $this->getStoredPages();
    
    // ->> IF the page is already loaded
    if(isset($storedPages[$page])) {
      //echo '<br />->USED STORED '.$page.'<br />';        
      return $storedPages[$page];
      
    // ->> ELSE load the page and store it in the storePages PROPERTY
    } else {
         
      // adds .php to the end if its missing
      if(substr($page,-4) != '.php')
        $page .= '.php';
    
      // adds a slash behind the $category / if she isn't empty
      if(!empty($category))
        if(substr($category,-1) !== '/')
            $category = $category.'/';
    
      if($category === false || $category == 0)
        $category = '';
    
      //echo '<br />LOAD PAGE: '.$page.'<br />';   
      //echo 'CATEGORY: '.$category.'<br />';
    
      if(@include(DOCUMENTROOT.$this->adminConfig['savePath'].$category.$page)) {
      
        // UNESCPAE the SINGLE QUOTES '
        $pageContent['content'] = str_replace("\'", "'", $pageContent['content'] );
      
        return $this->setStoredPages($pageContent);
      } else  // returns false if it couldn't include the page
        return false;
    }
  }
  
 /**
  * <b>Name</b> loadPageIds()<br>
  * 
  * Goes through the flatfiles folder and looks in which category is which page, it then returns an array with all IDs.
  * 
  * Example of the returned array:
  * {@example loadPageIds.return.example.php}
  * 
  * <b>Used Global Constants</b><br>
  *    - <var>DOCUMENTROOT</var> the absolut path of the webserver
  * 
  * @param int|bool $category   the category ID to check the containing page IDs, if FALSE its checks the non-category, if TRUE it checks all categories including the non-category (can also be the {@link $categoryConfig} property)
  * 
  * @uses $adminConfig          for the save path of the flatfiles
  * 
  * @return array|false an array with page IDs and the affiliated category IDs or empty array if the category had no pages
  * 
  * @version 1.0
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.0 initial release
  * 
  */
  function loadPageIds($category = false) {
                    
    // vars
    $pagesArray = array();
    $categoryDirs = array();
    $categoryArray = $this->categoryConfig;

    // if $category === true,
    // load ALL CATEGORIES and the NON-CATEGORY
    if($category === true) {
      array_unshift($categoryArray,array('id' => 0));
      $category = $categoryArray;
    }
    
    // COLLECT THE DIRS in an array
    // if $category is an array, i stores alle dirs in $this->adminConfig['savePath'] in an array
    if(is_array($category)) {
      
        foreach($category as $categoryArray) {          
          $dir = '';
          
          // *** if it is $this->categoryConfig settings array
          if(is_array($categoryArray) &&
             array_key_exists('id',$categoryArray)) {
            // if category == 0, means that the files are stored in the $this->adminConfig['savePath'] folder
            if($categoryArray['id'] == 0)
              $dir = DOCUMENTROOT.$this->adminConfig['savePath'];
            elseif(is_numeric($categoryArray['id']))
              $dir = DOCUMENTROOT.$this->adminConfig['savePath'].$categoryArray['id'];
          
          // *** if its just an array with the ids of the categories
          } else {
            // if category == 0, means that the files are stored in the $this->adminConfig['savePath'] folder
            if(is_numeric($categoryArray) && $categoryArray == 0) //$categoryArray === false ||
              $dir = DOCUMENTROOT.$this->adminConfig['savePath'];
            elseif(is_numeric($categoryArray))
              $dir = DOCUMENTROOT.$this->adminConfig['savePath'].$categoryArray;
          }
          
          // stores the paths in an array
          $categoryDirs[] = $dir;
        }
    } else {    
      if($category === false || (is_numeric($category) && $category == 0))
        $categoryDirs[0] = DOCUMENTROOT.$this->adminConfig['savePath'];
      elseif(is_numeric($category))
        $categoryDirs[0] = DOCUMENTROOT.$this->adminConfig['savePath'].$category;
    }
    
    // LOAD THE FILES out of the dirs
    // goes trough all category dirs and put the page arrays into an array an retun it
    foreach($categoryDirs as $dir) {
  
      // opens every category dir and stores the arrays of the pages in an array
      if(is_dir($dir) && $dir != DOCUMENTROOT) {

        $pages = array();
        
        // checks if its a category or the non-category
        if($category === false || $category == 0 || !is_numeric(basename($dir)))
          $categoryId = false;
        else
          $categoryId = basename($dir);
      
        $catDir = opendir($dir);
        while(false !== ($file = readdir($catDir))) {
        if($file != "." && $file != "..") {
            if(is_file($dir."/".$file)){
              // load Pages, without a category
              if($categoryId === false) {
	        $pages[] = array('page' => substr($file,0,-4), 'category' => 0);
              // load Pages, with a category
              } else {
	        $pages[] = array('page' => substr($file,0,-4), 'category' => $categoryId);
              }
            }
          }
        }
        closedir($catDir);
        
        // adds the new sorted category to the return array
        $pagesArray = array_merge($pagesArray,$pages);
      }
    }

    // return the page and category ID(s)
    return $pagesArray;
  }
  
 /**
  * <b>Name</b> loadPages()<br>
  * 
  * Loads the $pageContent arrays from pages in a specific category(ies) or all categories.
  * 
  * Loads all $pageContent arrays of a given category, by going through the {@link $storedPageIds} property.
  * It check first whether the current $pageContent array was not already loaded and is contained in the {@link $storedPages} property.
  * If not the {@link generalFunctions::readPage()} function is called to include the $pagecontent array of the page
  * and store it in the {@link $storedPages} property.
  * 
  * <b>Notice</b>: after loading all $pageContent arrays of a category, the array with the containing $pageContent arrays will be sorted.
  * 
  * Example of the returned array:
  * {@example loadPages.return.example.php}
  * 
  * @param bool|int|array  $category           (optional) a category ID, and array with category IDs, TRUE to load all categories (including the non-category) or FALSE to load only the non-category pages
  * @param bool		         $loadPagesInArray   (optional) if TRUE it returns the $pageContent arrays of the pages in the categories, if FALSE it only returns the page IDs of the requested category(ies)
  * 
  * @uses $categoryConfig     to get the sorting of the category
  * @uses getStoredPages()		for getting the {@link $storedPages} property
  * @uses readPage()			    to load the $pageContent array of the page
  * 
  * @return array the $pageContent array of the requested pages
  * 
  * @version 1.0
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.0 initial release
  * 
  */  
  function loadPages($category = false, $loadPagesInArray = true) {
    
    // IF $category FALSE set $category to 0
    if($category === false)
      $category = '0';
    
    // ->> RETURN $pageContent arrays
    if($loadPagesInArray === true) {
      
      //vars
      $pagesArray = array();

      // IF $category TRUE create array with non-category and all category IDs
      if($category === true) {
      	// puts the categories IDs in an array
      	$category = array(0);
      	foreach($this->categoryConfig as $eachCategory) {
      	  $category[] = $eachCategory['id'];
      	}
      }
      
      // change category into array
      if(is_numeric($category))
        $category = array($category);
        
      // go trough all given CATEGORIES       
      foreach($category as $categoryId) {
        
        // go trough the storedPageIds and open the page in it
        $newPageContentArrays = array();
        foreach($this->getStoredPageIds() as $pageIdAndCategory) {
          // use only pages from the right category
          if($pageIdAndCategory['category'] == $categoryId) {
            //echo 'PAGE: '.$pageIdAndCategory['page'].' -> '.$categoryId.'<br />';
            $newPageContentArrays[] = $this->readPage($pageIdAndCategory['page'],$pageIdAndCategory['category']);            
          }
        }
        
        // sorts the category
        if(is_array($newPageContentArrays)) { // && !empty($categoryId) <- prevents sorting of the non-category
          if($categoryId != 0 && $this->categoryConfig['id_'.$categoryId]['sortbypagedate'])
            $newPageContentArrays = $this->sortPages($newPageContentArrays, 'sortByDate');
          else
            $newPageContentArrays = $this->sortPages($newPageContentArrays, 'sortBySortOrder');
        }
      
        // adds the new sorted category to the return array
        $pagesArray = array_merge($pagesArray,$newPageContentArrays);
      }
      //print_r($pagesArray);
      return $pagesArray;
      
    // ->> RETURN ONLY the page & category IDs
    } else {
      
      // -> uses the $this->storedPageIds an filters out only the given category ID(s)
      $pageIds = $this->getStoredPageIds();
      
      if($category !== true) {
      	 $newPageIds = false;
      	 foreach($pageIds as $pageId) {
        	  if((is_array($category) && in_array($pageId['category'],$category)) || 
        	     $category == $pageId['category'])
        	    $newPageIds[] = array('page' => $pageId['page'], 'category' => $pageId['category']);
         }
      } else
	      $newPageIds = $pageIds;
      
      return $newPageIds;
    }
  }
  
 /**
  * <b>Name</b> isPageContentArray()<br>
  * 
  * Checks the given <var>$page</var> parameter is a valid <var>$pageContent</var> array.
  * 
  * @param int|array $page   the variable to check 
  * 
  * @return bool
  * 
  * @version 1.0
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.0 initial release
  * 
  */
  function isPageContentArray($page) {
               
    return (is_array($page) && array_key_exists('content',$page)) ? true : false;
  }
  
 /**
  * <b>Name</b> createHref()<br>
  * 
  * Checks the given <var>$page</var> parameter is a valid <var>$pageContent</var> array.
  *
  * @param int|array $page   the variable to check 
  *
  * @return bool
  *
  * @version 1.0
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.0 initial release
  *   
  */
  // -> START -- createHref ******************************************************************************
  // generates out of the a pageContent Array a href="" link for this page
  // RETURNs a String for the HREF attribute
  // -----------------------------------------------------------------------------------------------------
  function createHref($pageContent,               // (pageContent Array) the pageContent Array of the page
                             $sessionId = null) {
    
    // vars
    $page = $pageContent['id'];
    $category = $pageContent['category'];
    
    // ->> create HREF with speaking URL
    // *************************************
    if($this->adminConfig['speakingUrl'] == 'true') {
      $speakingUrlHref = '';
      
      // adds the category to the href attribute
      if($category != 0) {
        $categoryLink = '/category/'.$this->encodeToUrl($this->categoryConfig['id_'.$category]['name']).'/';
      } else $categoryLink = '';
      
      
      $speakingUrlHref .= $categoryLink;
      if($categoryLink == '')
        $speakingUrlHref .= '/page/'.$this->encodeToUrl($pageContent['title']);
      else
        $speakingUrlHref .= $this->encodeToUrl($pageContent['title']);
      $speakingUrlHref .= '.html';
      
      if($sessionId)
        $speakingUrlHref .= '?'.$sessionId;   
      
        
      return $speakingUrlHref;
    
    // ->> create HREF with varNames und Ids
    // *************************************
    } else {
      $getVarHref = '';
      
      // adds the category to the href attribute
      if($category != 0)
        $categoryLink = $this->adminConfig['varName']['category'].'='.$category.'&amp;';
      else $categoryLink = '';
      
      $getVarHref = '?'.$categoryLink.$this->adminConfig['varName']['page'].'='.$page;
      
      if($sessionId)
        $getVarHref .= '&amp;'.$sessionId;
      
      return $getVarHref;
    }  
  }
  // -> END -- createHref -----------------------------------------------------------------------------------
  
  // ** -- sortPages ----------------------------------------------------------------------------------
  // sort an Array with the pageContent Arrays by the given sort function
  // --------------------------------------------------------------------------------------------------
  // $pagesArray   [the array with the pageContent array (Array with pageContent Array)],
  // $category     [gruppe in der sich die Seiten befinden (String)]
  function sortPages($pageContentArrays,    // the ARRAY with the PAGECONTENT ARRAY (Array with pageContent Array)
                            $sortBy = false) {     // (Boolean or String) the sortfunction to be used ('sortBySortOrder' OR 'sortByCategory' OR 'sortByDate' OR 'sortByVisitedCount' OR 'sortByVisitTimeMax'), if false it detects the sortfunction by the category
    
    if(is_array($pageContentArrays)) {
      // sorts the array with the given sort function
      //natsort($pagesArray);
      
      // first sort the ARRAY by CATEGORY
      usort($pageContentArrays, 'sortByCategory');
      
      // -> SPLIT the ARRAY IN CATEGORIES
      $lastCategory = false;
      $newPageContentArrays = array();
      foreach($pageContentArrays as $pageContentArray) {
          
          //print_r($pageContentArray);
          
          if($pageContentArray['category'] != $lastCategory) {
            $categoriesArrays[] = $newPageContentArrays;
            $newPageContentArrays = array();
          }
          
          // adds the pageContent Array to a new array
          $newPageContentArrays[] = $pageContentArray;  
          $lastCategory = $pageContentArray['category'];
      }
      // adds the last $newPageContentArrays
      $categoriesArrays[] = $newPageContentArrays;
      
      // -> SORTS every CATEGORY
      $newPageContentArray = array();
      $category = false;   
      foreach($categoriesArrays as $categoriesArray) {        
        
        // gets the current category
        if(isset($categoriesArray[0]))
          $category = $categoriesArray[0]['category'];
        
        // SORTS the category the GIVEN SORTFUNCTION
        if($sortBy === false) {
          if($category && $this->categoryConfig['id_'.$category]['sortbypagedate'])
            usort($categoriesArray, 'sortByDate');
          else
            usort($categoriesArray, 'sortBySortOrder');
        } else
          usort($categoriesArray, $sortBy);  
        
        
        // makes the category ascending, if its in the options
        if($category && $this->categoryConfig['id_'.$category]['sortascending'])
          $categoriesArray = array_reverse($categoriesArray);
         
        foreach($categoriesArray as $pageContent) {
          // creates the NEW sorted array
          $newPageContentArray[] = $pageContent;
        }
      }
      
      return $newPageContentArray;
    } else
      return $pageContentArrays;
  }

 /**
  * Check a string for htmlentities and return the $textLength parameter plus the htmlentities length
  *
  * <b>Type</b>     function<br>
  * <b>Name</b>     getRealCharacterNumber()<br>
  *
  * Shortens the given $string parameter to the given $textLength parameter and counts the contained htmlentities.
  * Then adds the length of htmlentites to the $textLength and return it.
  *
  * @param string    $string       the string to find out the real length for shorting
  * @param int|bool  $textLength   the number of which the text should be shorten or FALSE to return only the string length
  *
  * @return int the real string length
  *
  * @version 1.0
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.0 initial release
  */ 
  function getRealCharacterNumber($string, $textLength = false) {
    
    // get the full string length if no maximum characternumber is given
    if($textLength === false)
      return strlen($string);
      
    // shorten the string to the maximum characternumber
    $string = substr($string,0,$textLength);
    
    // find ..ml; and ..lig; etc and adds the number of findings * strlen($finding) (~6) characters to the length
    preg_match_all('/\&[A-Za-z]{1,6}\;/', $string, $entitiesFindings);
    foreach($entitiesFindings[0] as $finding) {
      $finding = preg_replace("/ +/", '', $finding);
      $textLength += (strlen($finding));
    }
      
    return $textLength;
  }
  
  // ** -- cleanSpecialChars --------------------------------------------------------------------------
  // removes all special chars
  // --------------------------------------------------------------------------------------------------
  // $string         [the string where the special chars should be removed  (String)],
  // $replaceString    [the string with which they should be replaced (String)]
  function cleanSpecialChars($string,$replaceString = '') {
    
    // removes multiple spaces
    $string = preg_replace("/ +/", ' ', $string);
    // allows only a-z and 0-9, "_", ".", " "
    $string = preg_replace('/[^\w^.^ ]/u', $replaceString, $string);
    //$string = str_replace( array('Œ','','™','?','Š','|','@','[',']','Ÿ','','·','!','—',',',";","*","°","{",'}','^','´','`','=',":"," ","%",'+','/','\\',"&",'#','!','?','¿',"$","§",'"',"'","(",")"), $replaceSign, $string);
    
    return $string;
  }
  
  
  // ** -- clearTitle ----------------------------------------------------------------------------------
  // clears the title string from not allowed chars and change the speial chars into htmlentities
  // -----------------------------------------------------------------------------------------------------
  function clearTitle($title) {
      
      // format title
      $title = preg_replace("/ +/", ' ', $title);
      $title = str_replace('\\', '', $title);
      $title = htmlentities($title,ENT_QUOTES,'UTF-8');
      
      return $title;
  }
  
  // ** -- encodeToUrl ----------------------------------------------------------------------------------
  // encode a String so that it can be used as url
  // -----------------------------------------------------------------------------------------------------
  function encodeToUrl($string) {
      
      // makes the string to lower
      $string = strtolower($string);
      
      // format string
      $string = preg_replace("/ +/", '_', $string);    
      
      // changes umlaute
      $string = str_replace('&auml;','ae',$string);
      $string = str_replace('&uuml;','ue',$string);
      $string = str_replace('&ouml;','oe',$string);
      //$string = str_replace('&Auml;','Ae',$string);         
      //$string = str_replace('&Uuml;','Ue',$string);      
      //$string = str_replace('&Ouml;','Oe',$string);
      
      // clears htmlentities example: &amp;
      $string = preg_replace('/&[a-zA-Z0-9]+;/', '', $string);
      // allows only a-z and 0-9 and _ and -
      $string = preg_replace('/[^\w_-]/u', '', $string);
      
      // clears double __
      $string = preg_replace("/_+/", '_', $string);
      
      return $string;
  }

  
  // ** -- showMemoryUsage -------------------------------------------------------------------------------
  // display the usage of memory of the script
  // -----------------------------------------------------------------------------------------------------
  function showMemoryUsage() {
      $mem_usage = memory_get_usage(true);
      
      echo $mem_usage.' -> ';
      
      if ($mem_usage < 1024)
          echo $mem_usage." bytes";
      elseif ($mem_usage < 1048576)
          echo round($mem_usage/1024,2)." kilobytes";
      else
          echo round($mem_usage/1048576,2)." megabytes";
         
      echo "<br />";
  }
}
?>