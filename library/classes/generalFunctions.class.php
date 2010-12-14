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
 * This file contains the {@link generalFunctions} class.
 * 
 * @package [Implementation]-[Backend]
 */

/**
* <b>Classname</b> generalFunctions<br>
* 
* Contains the basic functions for reading and saving pages
* 
* <b>Notice</b>: this class will be used by the implementation classes AND the backend of the feindura-CMS.
* 
* @package [Implementation]-[Backend]
* 
* @version 1.20
* <br>
*  <b>ChangeLog</b><br>
*    - 1.20 changed class to static class
*    - 1.19 add parseDefaultLanguage() to checkLanguageFiles()
*    - 1.18 fixed checkLanguageFiles()
*    - 1.17 add chmod to savePage()
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
  * @static
  * @var array
  * @see generalFunctions()
  * 
  */ 
  public static $adminConfig;
  
  /**
  * Contains the category-settings config <var>array</var>
  * 
  * @static
  * @var array
  * @see generalFunctions()
  * 
  */ 
  public static $categoryConfig;
  
   /**
  * Contains all page and category IDs on the first loading of a page.
  * 
  * Run on the first loading of a page.
  * Goes trough all category folders and look which pages are in which folders and saves the IDs in the this property,<br>
  * to speed up the page loading process.
  * 
  * Example of the returned array:
  * {@example loadPageIds.return.example.php}
  * 
  * @static
  * @var array
  * 
  */
  public static $storedPageIds = null;
  
 /**
  * Stores page-content <var>array's</var> in this property if a page is loaded
  * 
  * If a page is loaded (<i>included</i>) it's page-content array will be stored in the this array.<br>
  * If the page is later needed again it's page-content will be fetched from this property.<br>
  * It should speed up the page loading process.
  * 
  * @example loadPages.return.example.php of the returned array
  * 
  * @static
  * @var array
  * 
  */
  public static $storedPages = null;

 
 /* ---------------------------------------------------------------------------------------------------------------------------- */
 /* *** CONSTRUCTOR *** */
 /* **************************************************************************************************************************** */
  
 /**
  * <b> Type</b>      constructor<br>
  * 
  * Constructor is not callable, {@link generalFunctions::init()} is used instead.
  * 
  * @return void
  * 
  * @version 1.0
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.0 initial release
  * 
  */ 
  private function __construct() {
  }
  
 /**
  * <b> Type</b>      init<br>
  * 
  * The real constructor of the static class, gets the settings.
  * 
  * <b>Used Global Variables</b><br>
  *    - <var>$adminConfig</var> the administrator-settings config (included in the {@link general.include.php})
  *    - <var>$categoryConfig</var> the categories-settings config (included in the {@link general.include.php})
  * 
  * @return void
  * 
  * @static
  * @version 1.0
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.0 initial release
  * 
  */ 
  public static function init() {
    
    // GET CONFIG FILES and SET CONFIG PROPERTIES
    self::$adminConfig = (isset($GLOBALS["adminConfig"])) ? $GLOBALS["adminConfig"] : $GLOBALS["feindura_adminConfig"];
    self::$categoryConfig = (isset($GLOBALS["categoryConfig"])) ? $GLOBALS["categoryConfig"] : $GLOBALS["feindura_categoryConfig"];

  }
  
 /* ---------------------------------------------------------------------------------------------------------------------------- */
 /* *** METHODS *** */
 /* **************************************************************************************************************************** */
 
  /**
  * <b>Name</b> parseDefaultLanguage()<br>
  * 
  * Checks for the browser language with the highest q-value
  * 
  * If no match to the browser language is found it uses the <var>$standardLang</var> parameter for loading a languageFile or returning the country code.
  * 
  * @author Darrin Yeager
  * @copyright Copyright (c) 2008 Darrin Yeager
  * @license http://www.dyeager.org/downloads/license-bsd.php BSD license
  * @link   http://www.dyeager.org/post/2008/10/getting-browser-default-language-php
  * @static
  */
  public static function parseDefaultLanguage($http_accept, $deflang = "en") {
     if(isset($http_accept) && strlen($http_accept) > 1)  {
        # Split possible languages into array
        $x = explode(",",$http_accept);
        foreach ($x as $val) {
           #check for q-value and create associative array. No q-value means 1 by rule
           if(preg_match("/(.*);q=([0-1]{0,1}\.\d{0,4})/i",$val,$matches))
              $lang[$matches[1]] = (float)$matches[2];
           else
              $lang[$val] = 1.0;
        }
  
        #return default language (highest q-value)
        $qval = 0.0;
        foreach ($lang as $key => $value) {
           if ($value > $qval) {
              $qval = (float)$value;
              $deflang = $key;
           }
        }
     }
     return strtolower($deflang);
  }

 
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
  * @param string|false $useLangPath      (optional) a absolut path to look for language files or FALSE to use the "feindura-cms/library/languages" folder
  * @param bool         $returnLangFile   (optional) if TRUE it includes and returns the language-file which matches the browser language
  * @param bool         $standardLang     (optional) a standard language for use if no match was found
  * 
  * @uses $adminConfig                           for the base path of the CMS
  * @uses generalFunctions::readFolderRecursive()  to read the language folder
  * @uses generalFunctions::parseDefaultLanguage() to get the right browser language
  * 
  * @return string|array|false a country code (like: de, en, fr..) or the language-file array or FALSE if the language file could not be opend
  * 
  * @static
  * @version 1.02
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.02 add parseDefaultLanguage()
  *    - 1.01 fixed language files check, uses now readFolder recursive  
  *    - 1.0 initial release
  * 
  */
  public static function checkLanguageFiles($useLangPath = false, $returnLangFile = true, $standardLang = 'en') {
     
      // checks if a path given
      if(is_string($useLangPath)) {
        // adds "/" on the beginnging for absolute path
        if(substr($useLangPath,0,1) != '/')
          $useLangPath = '/'.$useLangPath;
          
        // adds the DOCUMENTROOT  
        $useLangPath = str_replace(DOCUMENTROOT,'',$useLangPath);  
        $useLangPath = DOCUMENTROOT.$useLangPath;
        
      } else
        $langPath = dirname(__FILE__).'/../languages/';
       
      // -> read language folder
      $langFiles = self::readFolderRecursive($langPath);
      
      // -> get langFiles
      if(!empty($langFiles['files'])) {
                    
        // checks if the BROWSER STANDARD LANGUAGE is found in the SUPPORTED COUNTRY CODE         
        $browserLang = (isset($_SERVER["HTTP_ACCEPT_LANGUAGE"]))
          ? self::parseDefaultLanguage($_SERVER["HTTP_ACCEPT_LANGUAGE"],$standardLang)
          : self::parseDefaultLanguage(NULL,$standardLang);
        $browserLang = substr($browserLang,0,2);
        
    	  foreach($langFiles['files'] as $langFilePath) {

          $langFile = basename($langFilePath);

      		if(stristr(substr($langFile,-6,2).",", $browserLang.",") ||
             stristr(substr($langFile,0,2).",", $browserLang.",")) {
	  
      		  // returns either langFile or the COUNTRY CODE
      		  if($returnLangFile) {
      		    if($return = include(DOCUMENTROOT.$langFilePath))
                return $return;
             else
                return false;
      		  } else {
      			   return $browserLang;
      			}
      		}
      	}
        
        // if there is no SUPPORTED COUNTRY CODE, use the standard Lang  	
      	if($returnLangFile) {
          if(!empty($langFile)) {
            if($return = @include($langPath.substr($langFile,0,-6).$standardLang.'.php') ||
               $return = @include($langPath.$standardLang.substr($langFile,2)))
              return $return;
            else
              return false;
          } else
           return false;
    	     
    	  // return only the standard COUNTRY CODE
    	  } else
    		  return $standardLang;   		  
  		  
      } elseif($returnLangFile)
          return array();
      else
          return $standardLang;          
  }

 /**
  * <b>Name</b> getCurrentUrl()<br>
  * 
  * Return the current URL ($_SERVER['REQUEST_URI']), optional with add parameters.
  * 
  * @param string $parameter (optional) a string of parameter(s) to add, with the following format: "key=value&key2=value2..."
  * 
  * @return string the current url
  * 
  * @static
  * @version 1.0
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.0 initial release
  * 
  */
  public static function getCurrentUrl($parameter = null) {
    
    $currentURL = $_SERVER['REQUEST_URI'];
    
    if(!empty($parameter)) {
      $currentUrl = (strpos($currentURL,'?') === false)
        ? $_SERVER['REQUEST_URI'].'?'
        : $_SERVER['REQUEST_URI'].'&';
      
      return $currentUrl.$parameter;
    } else
      return $currentURL;
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
  * @static
  * @version 1.0
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.0 initial release
  * 
  */
  public static function getStoredPageIds() { // (false or Array)
    
    // load all page ids, if necessary
    if(self::$storedPageIds === null)
      self::$storedPageIds = self::loadPageIds(true);

    return self::$storedPageIds;
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
  * @static
  * @version 1.0
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.0 initial release
  * 
  */
  public static function getStoredPages() {
    global $HTTP_SESSION_VARS;
    
    unset($_SESSION['storedPages']);    
    //echo 'STORED-PAGES -> '.count(self::$storedPages);
    
    // if its an older php version, set the session var
    if(phpversion() <= '4.1.0')
      $_SESSION = $HTTP_SESSION_VARS;    
      
    // -> checks if the SESSION storedPages Array exists
    if(isset($_SESSION['storedPages']))
      return $_SESSION['storedPages']; // if isset, get the storedPages from the SESSION
    else
      return self::$storedPages; // if not get the storedPages from the PROPERTY  
  }

 /**
  * <b>Name</b> setStoredPages()<br>
  * 
  * Adds a <var>$pageContent</var> array to the {@link $storedPages} property.
  * Its also possible to store the {@link $storedPages} property in a <var>$_SESSION</var> variable. (CURRENTLY DEACTIVATED)
  * 
  * @param int  $pageContent   a $pageContent array which should be add to the {@link $storedPages} property
  * 
  * @uses $storedPages the property to add the $pageContent array
  * 
  * @return array passes through the given $pageContent array
  * 
  * @static
  * @version 1.01
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.01 removed the $remove parameter  
  *    - 1.0 initial release
  * 
  */
  public static function setStoredPages($pageContent,$remove = false) {
    global $HTTP_SESSION_VARS;
    
    unset($_SESSION['storedPages']);
    
    // if its an older php version, set the session var
    if(phpversion() <= '4.1.0')
      $_SESSION = $HTTP_SESSION_VARS;  
    
    // stores the given parameter only if its a valid $pageContent array
    if(self::isPageContentArray($pageContent)) {
      
      // ->> ADD
      // -> checks if the SESSION storedPages Array exists
      if(isset($_SESSION['storedPages']))
        $_SESSION['storedPages'][$pageContent['id']] = $pageContent; // if isset, save the storedPages in the SESSION
      else {
        self::$storedPages[$pageContent['id']] = $pageContent; // if not save the storedPages in the PROPERTY
        $_SESSION['storedPages'][$pageContent['id']] = $pageContent;
      }
    }
    
    return $pageContent;
  }
  
 /**
  * <b>Name</b> removeStoredPage()<br>
  * 
  * Removes a <var>$pageContent</var> array from the {@link $storedPages} property.
  * Its also possible to remove the {@link $storedPages} property from the <var>$_SESSION</var> variable. (CURRENTLY DEACTIVATED)
  * 
  * @param int $id the ID of a page which should be removed from the {@link $storedPages} property
  * 
  * @uses $storedPages the property to remove the $pageContent array
  * 
  * @return bool TRUE if a page with this ID exists and could be removed, otherwise FALSE
  * 
  * @static
  * @version 1.0
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.0 initial release
  * 
  */
  public static function removeStoredPage($id) {
    global $HTTP_SESSION_VARS;
    
    // var
    $return = false;
    
    // if its an older php version, set the session var
    if(phpversion() <= '4.1.0')
      $_SESSION = $HTTP_SESSION_VARS;  
    
    // ->> REMOVE
    if(is_numeric($id)) {
    // -> checks if the SESSION storedPages Array exists
      if(isset($_SESSION['storedPages']) && isset($_SESSION['storedPages'][$id])) {
        unset($_SESSION['storedPages'][$id]); // if isset, remove from the storedPages in the SESSION
        return true;
      } elseif(isset(self::$storedPages[$id])) {
        unset(self::$storedPages[$id]); // if not remove from the storedPages in the PROPERTY
        unset($_SESSION['storedPages'][$id]);
        return true;
      }
    }
    
    return $return;
  }
  
 /**
  * <b>Name</b> getPageCategory()<br>
  * 
  * Return the category ID of a page.
  * 
  * @param int $page a page ID from which to get the category ID
  * 
  * @uses getStoredPageIds() to get the {@link storedPageIds} property
  * 
  * @return int|false the right category ID or FALSE if the page ID doesn't exists
  * 
  * @static
  * @version 1.0
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.0 initial release
  * 
  */
  public static function getPageCategory($page) {

    if($page !== false && is_numeric($page)) {
      // loads only the page IDs and category IDs in an array
      // but only if it hasn't done this yet      
      $allPageIds = self::getStoredPageIds();
      
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
        
      } else
        return false;
    } else
      return false;
  }
  
 /**
  * <b>Name</b> readPage()<br>
  * 
  * Loads the $pageContent array of a page.
  * 
  * Checks first whether the given page ID was already loaded and is contained in the {@link $storedPages} property.
  * If not the {@link generalFunctions::readPage()} public static function is called to include the $pagecontent array of the page
  * and store it in the {@link $storedPages} property.
  * 
  * Example of the returned $pageContent array:
  * {@example readPage.return.example.php}
  * 
  * <b>Used Constants</b><br>
  *    - <var>DOCUMENTROOT</var> the absolut path of the webserver
  * 
  * @param int|array  $page           a page ID or a $pageContent array (will then returned immediately)
  * @param int        $category       (optional) a category ID, if FALSE it will try to load this page from the non-category
  * 
  * @uses getStoredPages()		for getting the {@link $storedPages} property
  * @uses setStoredPages()		to store a new loaded $pageContent array in the {@link $storedPages} property
  * 
  * @return array|FALSE the $pageContent array of the requested page or FALS, if it couldn't open the file
  * 
  * @static
  * @version 1.0
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.0 initial release
  * 
  */
  public static function readPage($page,$category = false) {
    //echo 'PAGE: '.$page.' -> '.$category.'<br />';
    
    // if $page is a valid $pageContent array return it immediately
    if(self::isPageContentArray($page))
      return $page;
       
    $storedPages = self::getStoredPages();
    
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
    
      if(@include(DOCUMENTROOT.self::$adminConfig['basePath'].'pages/'.$category.$page)) {
      
        // UNESCPAE the SINGLE QUOTES '
        $pageContent['content'] = str_replace("\'", "'", $pageContent['content'] );
      
        return self::setStoredPages($pageContent);
      } else  // returns false if it couldn't include the page
        return false;
    }
  }

 /**
  * <b>Name</b> savePage()<br>
  * 
  * Save a page to it's flatfile.
  * 
  * Example of the saved $pageContent array:
  * {@example readPage.return.example.php}
  * 
  * <b>Used Constants</b><br>
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
  * @static
  * @version 1.03
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.03 creates now category folder automatically  
  *    - 1.02 add preg_replace removing multiple slahses
  *    - 1.01 add chmod
  *    - 1.0 initial release
  * 
  */
  public static function savePage($pageContent) {
    
    // check if array is pageContent array
    if(!self::isPageContentArray($pageContent))
      return false;
    
    $pageId = $pageContent['id'];
    $categoryId = $pageContent['category'];
    
    // check if category folder exists
    if($categoryId != 0 && !is_dir(DOCUMENTROOT.self::$adminConfig['basePath'].'pages/'.$categoryId))
      @mkdir(DOCUMENTROOT.self::$adminConfig['basePath'].'pages/'.$categoryId);
    
    // get path
    $filePath = ($categoryId === false || $categoryId == 0)
    ? DOCUMENTROOT.self::$adminConfig['basePath'].'pages/'.$pageId.'.php'
    : DOCUMENTROOT.self::$adminConfig['basePath'].'pages/'.$categoryId.'/'.$pageId.'.php';
    
    // open the flatfile
    if(is_numeric($pageContent['id']) && ($file = @fopen($filePath,"w"))) {
      
      $pageContent = self::escapeQuotesRecursive($pageContent);
      
      // escaps ",',\,NULL but undescappes the double quotes again
      $pageContent['content'] = preg_replace('#\\\\+#', "\\", $pageContent['content']);
      $pageContent['content'] = stripslashes($pageContent['content']);
      $pageContent['content'] = addslashes($pageContent['content']); //escaped ",',\,NUL
      $pageContent['content'] = preg_replace('#\\\\"+#', '"', $pageContent['content'] );
        
      // CHECK BOOL VALUES and change to FALSE
      $pageContent['public'] = (isset($pageContent['public']) && $pageContent['public']) ? 'true' : 'false';
      
      // WRITE
      flock($file,2);            
      fwrite($file,PHPSTARTTAG);
      
      fwrite($file,"\$pageContent['id'] =                 ".$pageContent['id'].";\n");
      fwrite($file,"\$pageContent['category'] =           ".$pageContent['category'].";\n");
      fwrite($file,"\$pageContent['public'] =             ".$pageContent['public'].";\n");
      fwrite($file,"\$pageContent['sortOrder'] =          ".$pageContent['sortOrder'].";\n\n");
      
      fwrite($file,"\$pageContent['lastSaveDate'] =       '".$pageContent['lastSaveDate']."';\n");
      fwrite($file,"\$pageContent['lastSaveAuthor'] =     '".$pageContent['lastSaveAuthor']."';\n\n"); 
      
      fwrite($file,"\$pageContent['title'] =              '".$pageContent['title']."';\n");
      fwrite($file,"\$pageContent['description'] =        '".$pageContent['description']."';\n\n");      
      
      fwrite($file,"\$pageContent['pageDate']['before'] = '".$pageContent['pageDate']['before']."';\n");
      fwrite($file,"\$pageContent['pageDate']['date'] =   '".$pageContent['pageDate']['date']."';\n");
      fwrite($file,"\$pageContent['pageDate']['after'] =  '".$pageContent['pageDate']['after']."';\n");           
      fwrite($file,"\$pageContent['tags'] =               '".$pageContent['tags']."';\n\n");
      
      // write the plugins
      if(is_array($pageContent['plugins'])) {
        foreach($pageContent['plugins'] as $key => $value) {
          // save plugin settings only if plugin is activated
          if($pageContent['plugins'][$key]['active']) {
            foreach($value as $insideKey => $finalValue) {
              // CHECK BOOL VALUES and change to FALSE
              if($pageContent['plugins'][$key][$insideKey] == 'true' ||
                 $pageContent['plugins'][$key][$insideKey] == 'false') {
                $pageContent['plugins'][$key][$insideKey] = (isset($pageContent['plugins'][$key][$insideKey]) && $pageContent['plugins'][$key][$insideKey] !== 'false') ? 'true' : 'false';
                fwrite($file,"\$pageContent['plugins']['".$key."']['".$insideKey."'] = ".$pageContent['plugins'][$key][$insideKey].";\n");
              } else
                fwrite($file,"\$pageContent['plugins']['".$key."']['".$insideKey."'] = '".$pageContent['plugins'][$key][$insideKey]."';\n");
  
            }
            fwrite($file,"\n");
          }        
        }
      }    
      
      fwrite($file,"\$pageContent['thumbnail'] =          '".$pageContent['thumbnail']."';\n");
      fwrite($file,"\$pageContent['styleFile'] =          '".$pageContent['styleFile']."';\n");
      fwrite($file,"\$pageContent['styleId'] =            '".$pageContent['styleId']."';\n");
      fwrite($file,"\$pageContent['styleClass'] =         '".$pageContent['styleClass']."';\n\n");
      
      fwrite($file,"\$pageContent['log_visitorCount'] =   '".$pageContent['log_visitorCount']."';\n");
      fwrite($file,"\$pageContent['log_visitTime_min'] =  '".$pageContent['log_visitTime_min']."';\n");
      fwrite($file,"\$pageContent['log_visitTime_max'] =  '".$pageContent['log_visitTime_max']."';\n");
      fwrite($file,"\$pageContent['log_firstVisit'] =     '".$pageContent['log_firstVisit']."';\n");
      fwrite($file,"\$pageContent['log_lastVisit'] =      '".$pageContent['log_lastVisit']."';\n");
      fwrite($file,"\$pageContent['log_searchWords'] =    '".$pageContent['log_searchWords']."';\n\n");
      
      fwrite($file,"\$pageContent['content'] = \n'".$pageContent['content']."';\n\n");
      
      fwrite($file,"return \$pageContent;");
      
      fwrite($file,PHPENDTAG);
      flock($file,3);
      fclose($file);
      
      @chmod($filePath, PERMISSIONS);
      
      // writes the new saved page to the $storedPages property      
      self::removeStoredPage($pageContent['id']); // remove the old one
      unset($pageContent);
      $pageContent = include($filePath);
      self::setStoredPages($pageContent);
      // reset the stored page ids
      self::$storedPageIds = null;
      
      return true;
    }  
    return false;  
  }
  
 /**
  * <b>Name</b> loadPageIds()<br>
  * 
  * Goes through the flatfiles folder and looks in which category is which page, it then returns an array with all IDs.
  * 
  * Example of the returned array:
  * {@example loadPageIds.return.example.php}
  * 
  * <b>Used Constants</b><br>
  *    - <var>DOCUMENTROOT</var> the absolut path of the webserver
  * 
  * @param int|bool $category   (optional) the category ID to check the containing page IDs, if FALSE its checks the non-category, if TRUE it checks all categories including the non-category (can also be the {@link $categoryConfig} property)
  * 
  * @uses $adminConfig          for the save path of the flatfiles
  * 
  * @return array|false an array with page IDs and the affiliated category IDs or empty array if the category had no pages
  * 
  * @static
  * @version 1.01
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.01 add scandir() to scan category dirs
  *    - 1.0 initial release
  * 
  */
  public static function loadPageIds($category = false) {
                    
    // vars
    $pagesArray = array();
    $categoryDirs = array();

    // if $category === true,
    // load ALL CATEGORIES and the NON-CATEGORY
    if($category === true) {
      $nonCategory[0] = array('id' => 0);
      $category = $nonCategory + self::$categoryConfig;
    }
    
    // COLLECT THE DIRS in an array
    // if $category is an array, it stores all dirs from the pages folder in an array
    if(is_array($category)) {
      
        foreach($category as $categoryArray) {
          $dir = '';
          
          // *** if it is self::$categoryConfig settings array
          if(is_array($categoryArray) &&
             array_key_exists('id',$categoryArray)) {
            // if category == 0, means that the files are saved directly in the pages folder
            if($categoryArray['id'] == 0)
              $dir = DOCUMENTROOT.self::$adminConfig['basePath'].'pages/';
            elseif(is_numeric($categoryArray['id']))
              $dir = DOCUMENTROOT.self::$adminConfig['basePath'].'pages/'.$categoryArray['id'];
          
          // *** if its just an array with the ids of the categories
          } else {
            // if category == 0, means that the files are directly saved in the pages folder
            if(is_numeric($categoryArray) && $categoryArray == 0) //$categoryArray === false ||
              $dir = DOCUMENTROOT.self::$adminConfig['basePath'].'pages/';
            elseif(is_numeric($categoryArray))
              $dir = DOCUMENTROOT.self::$adminConfig['basePath'].'pages/'.$categoryArray;
          }
          
          // stores the paths in an array
          $categoryDirs[] = $dir;
        }
    } else {
      if($category === false || (is_numeric($category) && $category == 0))
        $categoryDirs[0] = DOCUMENTROOT.self::$adminConfig['basePath'].'pages/';
      elseif(is_numeric($category))
        $categoryDirs[0] = DOCUMENTROOT.self::$adminConfig['basePath'].'pages/'.$category;
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
        
        $readFolder = scandir($dir);      
        foreach($readFolder as $inDirObject) {
          if($inDirObject != "." && $inDirObject != ".." && is_file($dir."/".$inDirObject)) {         
            $pages[] = ($categoryId === false)
                ? array('page' => intval(substr($inDirObject,0,-4)), 'category' => 0) // load Pages, without a category                  
                : array('page' => intval(substr($inDirObject,0,-4)), 'category' => intval($categoryId)); // load Pages, with a category
          }
        }
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
  * If not the {@link generalFunctions::readPage()} public static function is called to include the $pagecontent array of the page
  * and store it in the {@link $storedPages} property.
  * 
  * <b>Notice</b>: after loading all $pageContent arrays of a category, the array with the containing $pageContent arrays will be sorted.
  * 
  * Example of the returned $pageContent arrays:
  * {@example loadPages.return.example.php}
  * 
  * @param bool|int|array  $category           (optional) a category ID, or an array with category IDs. TRUE to load all categories (including the non-category) or FALSE to load only the non-category pages
  * @param bool		         $loadPagesInArray   (optional) if TRUE it returns the $pageContent arrays of the pages in the categories, if FALSE it only returns the page IDs of the requested category(ies)
  * 
  * @uses $categoryConfig     to get the sorting of the category
  * @uses getStoredPages()		for getting the {@link $storedPages} property
  * @uses readPage()			    to load the $pageContent array of the page
  * 
  * @return array the $pageContent array of the requested pages
  * 
  * @static
  * @version 1.0
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.0 initial release
  * 
  */  
  public static function loadPages($category = false, $loadPagesInArray = true) {
    
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
      	$category = array(0); // start with the non category
      	foreach(self::$categoryConfig as $eachCategory) {
      	  $category[] = $eachCategory['id'];
      	}
      }
      
      // change category into array
      if(is_numeric($category))
        $category = array($category);
        
      // go trough all given CATEGORIES
      if(is_array($category)) {
        foreach($category as $categoryId) {
          
          // go trough the storedPageIds and open the page in it
          $newPageContentArrays = array();
          foreach(self::getStoredPageIds() as $pageIdAndCategory) {
            // use only pages from the right category
            if($pageIdAndCategory['category'] == $categoryId) {
              //echo 'PAGE: '.$pageIdAndCategory['page'].' -> '.$categoryId.'<br />';
              $newPageContentArrays[] = self::readPage($pageIdAndCategory['page'],$pageIdAndCategory['category']);            
            }
          }
          
          // sorts the category
          if(is_array($newPageContentArrays)) { // && !empty($categoryId) <- prevents sorting of the non-category
            if($categoryId != 0 && self::$categoryConfig[$categoryId]['sortByPageDate'])
              $newPageContentArrays = self::sortPages($newPageContentArrays, 'sortByDate');
            else
              $newPageContentArrays = self::sortPages($newPageContentArrays, 'sortBySortOrder');
          }
        
          // adds the new sorted category to the return array
          $pagesArray = array_merge($pagesArray,$newPageContentArrays);
        }
      }
      //print_r($pagesArray);
      return $pagesArray;
      
    // ->> RETURN ONLY the page & category IDs
    } else {
      
      // -> uses the self::$storedPageIds an filters out only the given category ID(s)
      $pageIds = self::getStoredPageIds();
      
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
  * <b>Name</b> isPublicCategory()<br />
  * 
  * Checks whether the given category(ies) are public and returns the ID or an array with IDs of the public ones.
  * 
  * @param int|array|bool $ids the category or page ID(s), can be a number or an array with numbers, if TRUE then it check all categories
  * 
  * @uses $categoryConfig      to check if a category is public
  * 
  * @return array|false an array with ID(s) of the public category(ies)
  * 
  * @access protected
  * @version 1.0
  * <br />
  * <b>ChangeLog</b><br />
  *    - 1.0 initial release
  * 
  */
  public static function isPublicCategory($ids) {
    
    // var
    $newIds = false;
    
    // ->> ALL categories
    if($ids === true) {
      
        // adds the non-category
        $newIds[] = 0;
        
        foreach(self::$categoryConfig as $category) {
          // checks if the category is public and creates a new array
          if($category['public'])
            $newIds[] = $category['id'];
        }
      // ->> MULITPLE categories
    } elseif(is_array($ids)) {
      // goes trough the given category IDs array
      foreach($ids as $id) {
        // checks if the category is public and creates a new array
      	if($id == 0 || (isset(self::$categoryConfig[$id]) && self::$categoryConfig[$id]['public']))    
      	  $newIds[] = $id;
            }
      
    // -> SINGLE category ID
    } elseif(is_numeric($ids)) {

      // checks if the category is public
      if($ids == 0 || self::$categoryConfig[$ids]['public'])    
        return $ids;
      else return false;
    
    } else return false;
    
    // and return the new category IDs array
    return $newIds;
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
  * @static
  * @version 1.0
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.0 initial release
  * 
  */
  public static function isPageContentArray($page) {               
    return (is_array($page) && array_key_exists('id',$page) && array_key_exists('content',$page)) ? true : false;
  }
  
 /**
  * <b>Name</b> createHref()<br>
  * 
  * Creates a href-attribute from the given <var>$pageContent</var> parameter,
  * if the <var>sessionId</var> parameter is given it adds them on the end of the href string.
  * 
  * @param array        $pageContent  the $pageContent array of a page
  * @param string|false $sessionId    (optional) the session ID string in the following format: "sessionName=sessionId"
  * 
  * @uses $adminConfig    for the variabel names which the $_GET variable will use for category and page and the when speakingURLs, for the websitePath
  * @uses $categoryConfig for the category name if speaking URLs i activated
  * @uses encodeToUrl()   to encode the category and page name to a string useable in URLs
  *  
  * @return string the href string ready to use in a href attribute
  * 
  * @see feindura::createHref()
  * 
  * @static
  * @version 1.0
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.0 initial release
  * 
  */
  public static function createHref($pageContent, $sessionId = false) {
    
    // vars
    $page = $pageContent['id'];
    $category = $pageContent['category'];
    
    // ->> create HREF with speaking URL
    // *************************************
    if(self::$adminConfig['speakingUrl'] == 'true') {
    
      $speakingUrlHref = self::$adminConfig['websitePath'];
      
      // adds the category to the href attribute
      if($category != 0) {
        $categoryLink = '/category/'.self::encodeToUrl(self::$categoryConfig[$category]['name']).'/';
      } else $categoryLink = '';
      
      
      $speakingUrlHref .= $categoryLink;
      if($categoryLink == '')
        $speakingUrlHref .= '/page/'.self::encodeToUrl($pageContent['title']);
      else
        $speakingUrlHref .= self::encodeToUrl($pageContent['title']);
      $speakingUrlHref .= '.html';
      
      if($sessionId)
        $speakingUrlHref .= '?'.$sessionId;
      
      return preg_replace('#/+#','/',$speakingUrlHref);
    
    // ->> create HREF with varNames und Ids
    // *************************************
    } else {
      $getVarHref = '';
      
      // adds the category to the href attribute
      if($category != 0)
        $categoryLink = self::$adminConfig['varName']['category'].'='.$category.'&amp;';
      else $categoryLink = '';
      
      $getVarHref = '?'.$categoryLink.self::$adminConfig['varName']['page'].'='.$page;
      
      if($sessionId)
        $getVarHref .= '&amp;'.$sessionId;
      
      return $getVarHref;
    }  
  }
  
 /**
  * <b>Name</b> sortPages()<br>
  * 
  * Sort an array with the <var>$pageContent</var> arrays by a given sort-public static function.
  * The following sort public static functions can be used for the <var>$sortBy</var> parameter:<br>
  *   - "sortBySortOrder"
  *   - "sortByCategory"
  *   - "sortByDate"
  *   - "sortByVisitedCount"
  *   - "sortByVisitTimeMax"  
  * 
  * @param array        $pageContentArrays  the $pageContent array of a page
  * @param string|false $sortBy             (optional) the name of the sort public static function, if FALSE it uses automaticly the right sort-public static function of the category
  * 
  * @uses $categoryConfig        to find the right sort public static function for every category
  * @uses isPageContentArray()   to check if the given $pageContent arrays are valid
  * 
  * @return array the sorted array with the $pageContent arrays
  * 
  * @see sort.public static functions.php
  * 
  * @static
  * @version 1.0
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.0 initial release
  * 
  */
  public static function sortPages($pageContentArrays, $sortBy = false) {
    
    if(is_array($pageContentArrays) && isset($pageContentArrays[0])) {
    
      // CHECK if the arrays are valid $pageContent arrays
      // OTHER BUTTONSwise return the unchanged array
      if(!self::isPageContentArray($pageContentArrays[0]))
        return $pageContentArrays;
      
      // sorts the array with the given sort public static function
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
          if($category && self::$categoryConfig[$category]['sortByPageDate'])
            usort($categoriesArray, 'sortByDate');
          else
            usort($categoriesArray, 'sortBySortOrder');
        } else
            usort($categoriesArray, $sortBy);  
        
        
        // makes the category ascending, if its in the options
        if($category && self::$categoryConfig[$category]['sortAscending'])
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
   * <b>Name</b> getStylesByPriority()<br />
   * 
   * Returns the right stylesheet-file path, ID or class-attribute.
   * If the <var>$givenStyle</var> parameter is empty,
   * it check if the category has a styleheet-file path, ID or class-attribute set return the value if not return the value from the {@link $adminConfig administartor-settings config}.
   * 
   * <b>Used Global Variables</b><br />
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
   * @version 1.01
   * <br />
   * <b>ChangeLog</b><br />
   *    - 1.01 moved to generalFunctions class   
   *    - 1.0 initial release
   * 
   */
  public static function getStylesByPriority($givenStyle,$styleType,$category) {
    
    // check if the $givenStyle is empty
    if(empty($givenStyle) || $givenStyle == 'a:0:{}') {
    
      return (empty(self::$categoryConfig[$category][$styleType]) || self::$categoryConfig[$category][$styleType] == 'a:0:{}')
        ? self::$adminConfig['editor'][$styleType]
        : self::$categoryConfig[$category][$styleType];
    
    // OTHER BUTTONSwise it passes through the $givenStyle parameter
    } else
      return $givenStyle;
    
  }

 /**
  * <b>Name</b> decodeToPlainText()<br>
  * 
  * Decodes a given <var>string</var> to a plain text, by decoding htmlentities and removing line breaks.
  * 
  * @param string $string the string to decode
  * 
  * @return string the decoded string
  * 
  * @see search::markFindingInText()
  * @see search::displayResults()
  * 
  * @version 1.0
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.0 initial release
  */ 
  public static function decodeToPlainText($string) {
    $string = html_entity_decode($string,ENT_COMPAT,'UTF-8');
    $string = str_replace(array('&nbsp;',"\n","\r","\t"),array(' ','','',''),$string);
    return $string;
  }
  
 /**
  * <b>Name</b> encodePlainText()<br>
  * 
  * Encodes a given plain text to a HTML string, by encoding htmlentities and chaning "&lt;" to "<" and "&gt;" to ">".
  * 
  * @param string $string the string to encode
  * 
  * @return string the decoded string
  * 
  * @see search::markFindingInText()
  * @see search::displayResults()
  * 
  * @version 1.0
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.0 initial release
  */ 
  public static function encodePlainText($string) {
    $string = htmlentities($string,ENT_COMPAT,'UTF-8');
    $string = str_replace(array('&lt;','&gt;'),array('<','>'),$string);
    return $string;
  }  
  
 /**
  * <b>Name</b> escapeQuotesRecursive()<br>
  * 
  * Escapes single quotes of an array or an string, and goes also deeper in the array.
  * 
  * @param array|string $data the data, where the quotes should be escaped
  * 
  * @return array|string the escaped array or string
  * 
  * @static
  * @version 1.0
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.0 initial release
  * 
  */
  public static function escapeQuotesRecursive($data) {
    
    if(is_string($data)) {      
      $data = str_replace("\'","'",$data);
      $data = str_replace("'","\'",$data);
      return  $data;
      
    } elseif(is_array($data)) {
      $newData = array();
      foreach($data as $key => $value) {
        $newData[$key] = self::escapeQuotesRecursive($value);
      }
      return $newData;
    } else
      return $data;
  }
  
 /**
  * <b>Name</b> cleanSpecialChars()<br>
  * 
  * Removes all special chars from a string.
  * 
  * @param string    $string          the string to clear
  * @param string    $replaceString   (optional) the string which replaces all special chars found
  * 
  * @return string the cleaned string
  * 
  * @static
  * @version 1.0
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.0 initial release
  * 
  */
  public static function cleanSpecialChars($string,$replaceString = '') {
    
    // removes multiple spaces
    $string = preg_replace("/ +/", ' ', $string);
    // allows only a-z and 0-9, "_", ".", " "
    $string = preg_replace('/[^\w^.^&^;^ ]/u', $replaceString, $string);
    if(!empty($replaceString))
      $string = preg_replace('/'.$replaceString.'+/', $replaceString, $string);
    //$string = str_replace( array('�','�','�','?','�','|','@','[',']','�','�','�','!','�',',',";","*","�","{",'}','^','�','`','=',":"," ","%",'+','/','\\',"&",'#','!','?','�',"$","�",'"',"'","(",")"), $replaceSign, $string);
    
    return $string;
  }
  
 /**
  * <b>Name</b> prepareStringInput()<br>
  * 
  * Clears a string from double withe spaces, slashes and htmlentities all special chars.
  * 
  * @param string $text the string to clear
  * 
  * @return string the cleaned string
  * 
  * @static
  * @version 1.0
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.0 initial release
  * 
  */
  public static function prepareStringInput($text) {
      
      // format text
      $text = preg_replace("/ +/", " ", $text);
      $text = preg_replace('#\\\\+#', '', $text);
      $text = stripslashes($text);
      $text = htmlentities($text,ENT_QUOTES,'UTF-8');
      
      return $text;
  }
  
 /**
  * <b>Name</b> shortenString()<br>
  * 
  * Shortens a string to its letter numbers (conciders htmlentities as multiple characters).
  * 
  * @param string $title  the title string to shorten
  * @param int    $length the number of letters the string should have after 
  * 
  * @return string the shortend title or the unchanged title, if shorten is not necessary
  * 
  * @static
  * @version 1.0
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.0 initial release
  * 
  */
  public static function shortenString($string, $length) {
      
      //vars
      $string =  self::decodeToPlainText($string);
      
      // chek if shorting is necessary
      if(strlen($string) <= $length)
        return self::encodePlainText($string);
      // shorten the title
      else
        return self::encodePlainText(substr($string,0,($length - 3)).'...'); // -2 because of the add ".."
  }
  
 /**
  * <b>Name</b> encodeToUrl()<br>
  * 
  * Converts a String so that it can be used in an URL.
  * 
  * @param string $string the strign which should be converted
  * 
  * @return string ready to use in an URL
  * 
  * @static
  * @version 1.0
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.0 initial release
  * 
  */
  public static function encodeToUrl($string) {
      
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

 /**
  * <b>Name</b> readFolder()<br />
  * 
  * Reads a folder and return it's subfolders and files.
  * 
  * Example of the returned array:
  * <code>
  * array(
  *    "files" => array(
  *                   0 => '/path/file1.php',
  *                   1 => '/path/file2.php',
  *                   ),
  *    "folders" => array(
  *                   0 => '/path/subfolder1',
  *                   1 => '/path/subfolder2',
  *                   2 => '/path/subfolder3'
  *                   )
  *    )
  * </code>
  * 
  * <b>Used Constants</b><br />
  *    - <var>DOCUMENTROOT</var> the absolut path of the webserver
  * 
  * @param string $folder the absolute path of an folder to read
  * 
  * @return array|false an array with the folder elements, FALSE if the folder not is a directory
  * 
  * @static
  * @version 1.01
  * <br />
  * <b>ChangeLog</b><br />
  *    - 1.01 changed to scandir()
  *    - 1.0 initial release
  * 
  */
  public static function readFolder($folder) {
    
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
      $readFolder = scandir($fullFolder);
      
      foreach($readFolder as $inDirObject) {
        if($inDirObject != "." && $inDirObject != "..") {
          if(is_dir($fullFolder.$inDirObject)) {        
            $return['folders'][] = $folder.$inDirObject;
          } elseif(is_file($fullFolder.$inDirObject)) {
            $return['files'][] = $folder.$inDirObject;
          }
        }
      }
    }
    
    return $return;  
  }

 /**
  * <b>Name</b> readFolderRecursive()<br />
  * 
  * Reads a folder recursive and return it's subfolders and files, opens then also the subfolders and read them, etc.
  * 
  * Example of the returned array:
  * <code>
  * array(
  *    "files" => array(
  *                   0 => '/path/file1.php',
  *                   1 => '/path/subfolder1/file2.php',
  *                   ),
  *    "folders" => array(
  *                   0 => '/path/subfolder1',
  *                   1 => '/path/subfolder2/subsubfolder1',
  *                   2 => '/path/subfolder2/subsubfolder2'
  *                   )
  *    )
  * </code>
  * 
  * <b>Used Constants</b><br />
  *    - <var>DOCUMENTROOT</var> the absolut path of the webserver
  * 
  * @param string $folder the absolute path of an folder to read
  * 
  * @return array|false an array with the folder elements, FALSE if the folder is not a directory
  * 
  * @static
  * @version 1.0
  * <br />
  * <b>ChangeLog</b><br />
  *    - 1.0 initial release
  * 
  */
  public static function readFolderRecursive($folder) {
    
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
        $inDirObjects = self::readFolder($subFolder);
        
        // -> add all subfolders to an array
        if(isset($inDirObjects['folders']) && is_array($inDirObjects['folders'])) {        
          $subFolders = array_merge($subFolders, $inDirObjects['folders']);
        }        
      
        // -> add folders to the $return array
        if(isset($inDirObjects['folders']) && is_array($inDirObjects['folders'])) {
          foreach($inDirObjects['folders'] as $folder) {
            $return['folders'][] = str_replace(DOCUMENTROOT,'',$folder);
          }
        }
        // -> add files to the $return array
        if(isset($inDirObjects['files']) && is_array($inDirObjects['files'])) {
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

 /**
  * <b>Name</b> folderIsEmpty()<br />
  * 
  * Check if a folder is empty.
  * 
  * <b>Used Constants</b><br />
  *    - <var>DOCUMENTROOT</var> the absolut path of the webserver
  * 
  * @param string $folder the absolute path of an folder to check
  * 
  * @return bool TRUE if its empty, otherwise FALSE
  * 
  * @static
  * @version 1.0
  * <br />
  * <b>ChangeLog</b><br />
  *    - 1.0 initial release
  * 
  */
  public static function folderIsEmpty($folder) {
    
    if(self::readFolder(DOCUMENTROOT.$folder) === false)
      return true;
    else
      return false;
  
  }
  
  /**
   * <b>Name</b> createStyleTags()<br />
   * 
   * Goes through a folder recursive and creates a HTML <link> tag for every stylesheet-file found.
   * 
   * <b>Used Global Variables</b><br />
   *    - <var>$adminConfig</var> the administrator-settings config (included in the {@link general.include.php})
   * 
   * @param string $folder  the absolute path of the folder to look for stylesheet files
   * @param bool   $backend if TRUE is substract the {@link feinduraBase::$adminConfig $adminConfig['basePath']} from the stylesheet link
   * 
   * @uses generalFunctions::readFolderRecursive() to read the folder
   * 
   * @return string|false the HTML <link> tags or FALSE if no stylesheet-file was found
   * 
   * @static 
   * @version 1.0
   * <br />
   * <b>ChangeLog</b><br />
   *    - 1.0 initial release
   * 
   */
  public static function createStyleTags($folder, $backend = true) {
    
    //var
    $return = false;
    
    // ->> goes trough all folder and subfolders
    $filesInFolder = self::readFolderRecursive($folder);
    if(is_array($filesInFolder['files'])) {
      foreach($filesInFolder['files'] as $file) {
        // -> check for CSS FILES
        if(substr($file,-4) == '.css') {
          // -> removes the $adminConfig('basePath')
          if($backend)          
            $file = str_replace(self::$adminConfig['basePath'],'',$file);
          // -> WRITES the HTML-Style-Tags
          $return .= '  <link rel="stylesheet" type="text/css" href="'.$file.'" />'."\n";
        }
      }
    }
    
    return $return;
  }
  
 /**
  * <b>Name</b> showMemoryUsage()<br>
  * 
  * Shows the memory usage at the point of the script where this public static function is called.
  * 
  * @return void
  * 
  * @static
  * @version 1.0
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.0 initial release
  * 
  */
  public static function showMemoryUsage() {
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