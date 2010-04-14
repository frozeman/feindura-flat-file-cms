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
*
* library/functions/generalFunctions.functions.php version 1.12
*
* FUNCTIONS ----------------------------
* 
* getLanguage($useLangPath = false, $returnLangArray = true, $standardLang = 'en')
* 
* savePage($category,$page,$contentArray)
* 
* readPage($page,$category = false)
* 
* loadPages($category = 0,$loadPagesInArray = true)
* 
* getPageCategory($page, $allPageIds = '')
*
* dateDayBeforeAfter($date,$givenLangFile = false)
*
* createHref($pageContent, $sessionId = false)
*
* sortPages($pageContentArrays, $sortBy = false)
*
* getCharacterNumber($string, $characterLength = false)
*
* cleanSpecialChars($string,$replaceSign)
* 
* clearTitle($title)
* 
* encodeToUrl($string)
* 
* showMemoryUsage()
* 
*/

include_once(dirname(__FILE__)."/../functions/sort.functions.php");

class generalFunctions {
  
  // PUBLIC
  // *********
  var $adminConfig;                       // [Array] the Array with the adminConfig Data from the feindura CMS
  var $categoryConfig;                    // [Array] the Array with the categoryConfig Data from the feindura CMS
  
  // -> START ** constructor *****************************************************************************
  // the class constructor
  // get the config arrays
  // -----------------------------------------------------------------------------------------------------
  function generalFunctions() {   // (String) string with the COUNTRY CODE ("de", "en", ..)
    global $adminConfig;
    global $categories;
    
    // GET CONFIG FILES and SET CONFIG PROPERTIES
    $this->adminConfig = $adminConfig;
    $this->categoryConfig = $categories;
  
    return true;
  }  
  
  // ** -- getLanguage ----------------------------------------------------------------------------------
  // looks for the standard Browser language
  // AND compares this with the files in the language Dir, which should end with a COUNTRY SHORTNAME
  // RETURN, the langFile array OR the COUNTRY CODE (like: de, en, fr..)
  // -----------------------------------------------------------------------------------------------------
  // $useLangPath         [if here is given a ABSOLUT path he scans this folder for lang files, they should end with de or en.. (String or Boolean)],
  // $returnCountryCode   [if false he returns the array from the language File (Boolean)],
  // $standardLang        [standard country name for languages, if no supported ones is found in the browsers lang (String)]
  function getLanguage($useLangPath = true, $returnLangFile = true, $standardLang = 'de') {  
     
      // checks if other is a different path given
      // and if its a ABSOLUTE PATH
      if(is_string($useLangPath) && substr($useLangPath,0,1) == '/')
        $langPath = DOCUMENTROOT.$useLangPath;
      else
        $langPath = DOCUMENTROOT.$this->adminConfig['websitefilesPath'];
  
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
  
  // ** -- savePage ----------------------------------------------------------------------------------
  // speichert den inhalt in der jeweiligen _page/group/seite.php
  // -----------------------------------------------------------------------------------------------------
  // $category         [die gruppe innerhalb der sich die datei befindet (String)],
  // $page          [die seite welche gespeichert werden soll (String)]
  // $contentArray  [Array mit dem Inhalt und den Daten der Seite (Array)]
  function savePage($categoryId,$pageId,$pageContentArray) {
        
    // escaped ",',\,NUL undescapped aber wieder die "
    $pageContentArray['content'] = stripslashes($pageContentArray['content']);
    $pageContentArray['content'] = addslashes($pageContentArray['content']); //escaped ",',\,NUL
    $pageContentArray['content'] = str_replace('\"', '"', $pageContentArray['content'] );
    
    // fügt hinter der gruppe ein / an wenn sie nicht leer ist
    if(!empty($categoryId) && $categoryId != 0)
      $categoryId = $categoryId.'/';
    
    //öffnet oder erstellt die flatfile
    if((($categoryId === false || $categoryId == 0) &&
        $fp = fopen(DOCUMENTROOT.$this->adminConfig['savePath'].$pageId.'.php',"w")) ||
        $fp = fopen(DOCUMENTROOT.$this->adminConfig['savePath'].$categoryId.$pageId.'.php',"w")) {


      flock($fp,2);
      
      fwrite($fp,PHPSTARTTAG);
      
      fwrite($fp,"\$pageContent['id'] =                 '".$pageContentArray['id']."';\n");
      fwrite($fp,"\$pageContent['category'] =           '".$pageContentArray['category']."';\n");
      fwrite($fp,"\$pageContent['title'] =              '".$pageContentArray['title']."';\n");
      fwrite($fp,"\$pageContent['public'] =             '".$pageContentArray['public']."';\n");
      fwrite($fp,"\$pageContent['sortorder'] =          '".$pageContentArray['sortorder']."';\n");
      fwrite($fp,"\$pageContent['sortdate']['before'] = '".$pageContentArray['sortdate']['before']."';\n");
      fwrite($fp,"\$pageContent['sortdate']['date'] =   '".$pageContentArray['sortdate']['date']."';\n");
      fwrite($fp,"\$pageContent['sortdate']['after'] =  '".$pageContentArray['sortdate']['after']."';\n");
      fwrite($fp,"\$pageContent['lastsavedate'] =       '".$pageContentArray['lastsavedate']."';\n");
      fwrite($fp,"\$pageContent['lastsaveauthor'] =     '".$pageContentArray['lastsaveauthor']."';\n");      
      fwrite($fp,"\$pageContent['tags'] =               '".$pageContentArray['tags']."';\n\n");
      
      fwrite($fp,"\$pageContent['thumbnail'] =          '".$pageContentArray['thumbnail']."';\n");
      fwrite($fp,"\$pageContent['styleFile'] =          '".$pageContentArray['styleFile']."';\n");
      fwrite($fp,"\$pageContent['styleId'] =            '".$pageContentArray['styleId']."';\n");
      fwrite($fp,"\$pageContent['styleClass'] =         '".$pageContentArray['styleClass']."';\n\n");
      
      fwrite($fp,"\$pageContent['log_visitCount'] =     '".$pageContentArray['log_visitCount']."';\n");
      fwrite($fp,"\$pageContent['log_visitTime_min'] =  '".$pageContentArray['log_visitTime_min']."';\n");
      fwrite($fp,"\$pageContent['log_visitTime_max'] =  '".$pageContentArray['log_visitTime_max']."';\n");
      fwrite($fp,"\$pageContent['log_firstVisit'] =     '".$pageContentArray['log_firstVisit']."';\n");
      fwrite($fp,"\$pageContent['log_lastVisit'] =      '".$pageContentArray['log_lastVisit']."';\n");
      fwrite($fp,"\$pageContent['log_searchwords'] =    '".$pageContentArray['log_searchwords']."';\n\n");
      
      fwrite($fp,"\$pageContent['content'] = \n'".$pageContentArray['content']."';\n\n");
      
      fwrite($fp,"return \$pageContent;");
      
      fwrite($fp,PHPENDTAG);
      
      flock($fp,3);
      fclose($fp);
      
      return true;
    }  
    return false;  
  }
  
  // ** -- readPage ----------------------------------------------------------------------------------
  // loads the page by the given PAGE ID (and CATEGORY ID)
  // -----------------------------------------------------------------------------------------------------
  // $page      [the id of the site page which will be opened (String)]
  // $category  [the categroy id in which the page is (String)],
  function readPage($page,$category = false) {
      
    // fügt ein .php am Ende von $page an sofern es fehlt
    if(substr($page,-4) != '.php')
      $page .= '.php';
    
    // adds a slash behind the $category / if she isn't empty
    if(!empty($category))
      if(substr($category,-1) !== '/')
          $category = $category.'/';
    
    if($category === false || $category == 0)
      $category = '';
    
    //echo 'PAGE: '.$page.'<br />';   
    //echo 'CATEGORY: '.$category.'<br />';
    
    if(@include(DOCUMENTROOT.$this->adminConfig['savePath'].$category.$page)) {
      
      // UNESCPAE the SINGLE QUOTES '
      $pageContent['content'] = str_replace("\'", "'", $pageContent['content'] );
      
      return $pageContent;
    } else  // returns false if it couldn't include the page
      return false;
  }
  
  // ** -- loadPages ----------------------------------------------------------------------------------
  // go trough the category folders and loads the pageContent Array in an Array
  // RETURNs a Array with the pageContent Array in it OR an Array with an Array with the page ID and the category ID
  // -----------------------------------------------------------------------------------------------------
  function loadPages($category = false,                   // (Boolean, Number or Array with IDs or the $this->categoryConfig Array) the category or categories, which to load in an array, if TRUE it loads all categories
                     $loadPagesInArray = true) {          // (Boolean) if true it loads the pageContentArray in an array, otherwise it stores only the categroy ID and the page ID
    
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
                if($loadPagesInArray)
                  $pages[] = $this->readPage($file);
                else
                  $pages[] = array('page' => substr($file,0,-4), 'category' => 0);
              // load Pages, with a category
              } else {
                if($loadPagesInArray)
                  $pages[] = $this->readPage($file,$categoryId);
                else
                  $pages[] = array('page' => substr($file,0,-4), 'category' => $categoryId);
              }
            }
          }
        }
        closedir($catDir);
              
        // sorts the category
        if($loadPagesInArray && is_array($pages)) { // && !empty($categoryId) <- prevents sorting of the non-category
          if($categoryId !== 0 && $this->categoryConfig['id_'.$categoryId]['sortbydate'])
            $pages = $this->sortPages($pages, 'sortByDate');
          else
            $pages = $this->sortPages($pages, 'sortBySortOrder');
        }
        
        // adds the new sorted category to the return array
        $pagesArray = array_merge($pagesArray,$pages);
      }
    }
    
    if(!empty($pagesArray))
      return $pagesArray;
    else
      return false;
  }
  
  // -- getPageCategory ********************************************************************
  // gets the category ID of a given page ID
  // RETURNs an array with the page category and the allPages Ids OR only the page category
  // ------------------------------------------------------------------------------------------------
  function getPageCategory($page,                    // (Number) the page ID, from which to get the category ID
                           $allPageIds = '',         // (empty or Array) an array with all the page IDs and Category IDs
                           $returnPageIds = false) { // (Boolean) if TRUE it RETURNs an array with the category and the $allPageIds, otherwise only the page catgeory
    
    if($page !== false && is_numeric($page)) {
      // loads only the page IDs and category IDs in an array
      // but only if it hasn't done this yet
      if($allPageIds == null)
        $allPageIds = $this->loadPages(true,false);
        
      if($allPageIds) {
        // gets the category id of the given page
        foreach($allPageIds as $everyPage) {
          // if its the right page, return the category of it        
          if($page == $everyPage['page']) {
            if($returnPageIds === false) return $everyPage['category'];
            else return array($everyPage['category'],$allPageIds);
          }
        }
        // if it found nothing
        if($returnPageIds === false) return false;
        else return array(false,$allPageIds);
        
      } else return false;
    } else return false;
  }
  
  // -> START -- dateDayBeforeAfter ***************************************************************************
  // replace the date with "tomorrow" and "today", if it is one day before or the same day
  // -------------------------------------------------------------------------------------------------------
  function dateDayBeforeAfter($date,$givenLangFile = false) { // (String with the format YYYY-MM-DD HH:MM) date which will be check for is today or tomorrow
    global $langFile;
    
    if($givenLangFile === false)
      $givenLangFile = $langFile;
    
    // if the date is TODAY
    if(substr($date,0,10) == date('Y')."-".date('m')."-".date('d'))
      return $givenLangFile['date_today'];
    
    // if the date is YESTERDAY
    elseif(substr($date,0,10) == date('Y')."-".date('m')."-".sprintf("%02d",(date('d')-1)))
      return $givenLangFile['date_yesterday'];
    
    // if the date is TOMORROW
    elseif(substr($date,0,10) == date('Y')."-".date('m')."-".sprintf("%02d",(date('d')+1)))
      return $givenLangFile['date_tomorrow'];
  
    else return $date;
  }
  // -> END -- createTitleDate ----------------------------------------------------------------------------
  
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
      
      $getVarHref = 'index.php?'.$categoryLink.$this->adminConfig['varName']['page'].'='.$page;
      
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
          if($category && $this->categoryConfig['id_'.$category]['sortbydate'])
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

  
  // ** -- getCharacterNumber ----------------------------------------------------------------------------------
  // count htmlspecialchars like &amp; etc as 1 character, and returns the right character number
  // -----------------------------------------------------------------------------------------------------
  function getCharacterNumber($string,                         // (String) the string to count the characters
                              $characterLength = false) {      // (Number of False) the number of maximum characters to count
    
    // get the full string length if no maximum characternumber is given
    if($characterLength === false)
      return strlen($string);
      
    // shorten the string to the maximum characternumber
    $string = substr($string,0,$characterLength);
    
    // find ..ml; and ..lig; etc and adds the number of findings * strlen($finding) (~6) characters to the length
    preg_match_all('/\&[A-Za-z]{1,6}\;/', $string, $entitiesFindings);
    foreach($entitiesFindings[0] as $finding) {
      $characterLength += (strlen($finding) - 1); // -1 because of double spaces
    }
      
    return $characterLength;
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