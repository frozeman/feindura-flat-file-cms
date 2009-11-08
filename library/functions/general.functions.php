<?php
/*
    feindura - Flat File Content Management System
    Copyright (C) 2009 Fabian Vogelsteller [frozeman.de]

    This program is free software;
    you can redistribute it and/or modify it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 3 of the License, or (at your option) any later version.

    This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY;
    without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
    See the GNU General Public License for more details.

    You should have received a copy of the GNU General Public License along with this program;
    if not,see <http://www.gnu.org/licenses/>.
*
* library/functions/general.functions.php version 1.02
*
* FUNCTIONS ----------------------------
* 
* getLanguage($useLangPath = false, $returnLangArray = true, $standardLang = 'en')
* 
* readPage($page,$category = false)
* 
* savePage($category,$page,$contentArray)
* 
* loadPages($category = 0,$loadPagesInArray = true)
* 
* getPageCategory($page, $allPageIds = '')
*
* sortPages($pagesArray, $sortBy)
* 
* validateDateFormat($dateString,$format = 'eu')
*
* cleanSpecialChars($string,$replaceSign)
* 
* formatDate($givenDate,$format = 'eu')
* 
* formatTime($givenDate,$showSeconds = false)
*  
*/

//error_reporting(E_ALL);


// ** -- getLanguage ----------------------------------------------------------------------------------
// looks for the standard Browser language
// AND compares this with the files in the language Dir, which should end with a COUNTRY SHORTNAME
// RETURN, the langFile array OR the COUNTRY CODE (like: de, en, fr..)
// -----------------------------------------------------------------------------------------------------
// $useLangPath         [if here is given a ABSOLUT path he scans this folder for lang files, they should end with de or en.. (String or Boolean)],
// $returnCountryCode   [if false he returns the array from the language File (Boolean)],
// $standardLang        [standard country name for languages, if no supported ones is found in the browsers lang (String)]
function getLanguage($useLangPath = false, $returnCountryCode = true, $standardLang = 'de') {  
    global $adminConfig;
    global $documentRoot;
    
    // checks if dther is a different path given
    // and if its a ABSOLUTE PATH
    if($useLangPath && substr($useLangPath,0,1) == '/')
      $adminConfig['langPath'] = $documentRoot.$useLangPath;
    else
      $adminConfig['langPath'] = $documentRoot.$adminConfig['langPath'];
    
    // opens the lang Dir
    if(!$openlangdir = @opendir($adminConfig['langPath'])) {
      if($returnCountryCode)
        return $standardLang;
      else
        return false;
    }   
    
    // go trough the lang Dir
    while(false !== ($lang_file = @readdir($openlangdir))) {
      if($lang_file != "." && $lang_file != ".."
      && is_file($adminConfig['langPath'].$lang_file)) {
        
        $langFileSchema = $lang_file;
        
        // checks if the BROWSER STANDARD LANGUAGE is found in the SUPPORTED COUNTRY CODE
        $l = explode(",", $_SERVER['HTTP_ACCEPT_LANGUAGE']);
      	while(list($key, $value) = each($l)) {
      	  $browserData = strtolower(substr($value, 0, 2));
      		if (strstr(strtolower(substr(substr($lang_file,-6),0,2)).",", $browserData.",") ||
              strstr(strtolower(substr($lang_file,0,2)).",", $browserData.",")) {
      		  // returns either langFile or the COUNTRY CODE
      		  if(!$returnCountryCode) {
      		    if($langFile = @include($adminConfig['langPath'].$lang_file))
                return $langFile;
              else
                return false;
      		  } else
      			 return $browserData;
      		}
      	}
      }
    }
    @closedir($mod_openedmodul);
    
  	// if there is no SUPPORTED COUNTRY CODE, use the standard Lang  	
  	if(!$returnCountryCode) {
      if(!empty($langFileSchema)) {
        if($langFile = @include($adminConfig['langPath'].substr($langFileSchema,0,-6).$standardLang.'.php') ||
           $langFile = @include($adminConfig['langPath'].$standardLang.substr($langFileSchema,2)))
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
function savePage($category,$page,$contentArray) {  
  global $phpTags;
  global $adminConfig;
  
  // escaped ",',\,NUL undescapped aber wieder die "
  $contentArray['content'] = stripslashes($contentArray['content']);
  $contentArray['content'] = addslashes($contentArray['content']); //escaped ",',\,NUL
  $contentArray['content'] = str_replace('\"', '"', $contentArray['content'] );
  
  // fügt hinter der gruppe ein / an wenn sie nicht leer ist
  if(!empty($category) && $category != 0)
    $category = $category.'/';
  
  //öffnet oder erstellt die flatfile
  if((($category === false || $category == 0) &&
      $fp = fopen(dirname(__FILE__).'/../../'.$adminConfig['savePath'].$page.'.php',"w")) ||
      $fp = fopen(dirname(__FILE__).'/../../'.$adminConfig['savePath'].$category.$page.'.php',"w")) {

    // vorher thumbnailpath,
    // und name statt filename,
    // public statt status,
    // publicdate in date
    $z0 = $phpTags[0];
    $z1 = '$pageContent = array('."\n";

  $znew = '
"id"        => \''.$contentArray['id'].'\',
"category"  => \''.$contentArray['category'].'\',
"public"    => \''.$contentArray['public'].'\',
"sortorder" => \''.$contentArray['sortorder'].'\',
"sortdate"  => array(\''.$contentArray['sortdate'][0].'\',\''.$contentArray['sortdate'][1].'\',\''.$contentArray['sortdate'][2].'\'),
"savedate"  => \''.$contentArray['savedate'].'\',
"title"     => \''.$contentArray['title'].'\',
"tags"      => \''.$contentArray['tags'].'\',

"thumbnail"   => \''.$contentArray['thumbnail'].'\',
"styleFile"   => \''.$contentArray['styleFile'].'\',
"styleId"     => \''.$contentArray['styleId'].'\',
"styleClass"  => \''.$contentArray['styleClass'].'\',

"log_visitCount"      => \''.$contentArray['log_visitCount'].'\',
"log_visitTime_min"   => \''.$contentArray['log_visitTime_min'].'\',
"log_visitTime_max"   => \''.$contentArray['log_visitTime_max'].'\',
"log_firstVisit"      => \''.$contentArray['log_firstVisit'].'\',
"log_lastVisit"       => \''.$contentArray['log_lastVisit'].'\',
"log_searchwords"     => \''.$contentArray['log_searchwords'].'\',

"content" => 

\''.$contentArray['content'].'\'

';

    $z3 = ');'."\n\n";
    flock($fp,2);
    
    fwrite($fp,$z0);
    fwrite($fp,$z1);
    
    fwrite($fp,$znew);
    fwrite($fp,$z3);
    
    fwrite($fp,$phpTags[1]);
    
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
  global $adminConfig;

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
  
  if(@include(dirname(__FILE__).'/../../'.$adminConfig['savePath'].$category.$page)) {
    
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
function loadPages($category = false,           // (Boolean, Number or Array with IDs or the $categories Array) the category or categories, which to load in an array, if TRUE it loads all categories
                   $loadPagesInArray = true) {  // (Boolean) if true it loads the pageContentArray in an array, otherwise it stores only the categroy ID and the page ID
  global $adminConfig;
  global $categories;
  
  // vars
  $pagesArray = array();
  $categoryDirs = array();
  $categoryArray = $categories;
  
  // if $category === true,
  // load ALL CATEGORIES and the NON-CATEGORY
  if($category === true) {
    array_unshift($categoryArray,array('id' => 0));
    $category = $categoryArray;
  }
  
  // COLLECT THE DIRS in an array
  // if $category is an array, i stores alle dirs in $adminConfig['savePath'] in an array
  if(is_array($category)) {
      foreach($category as $categoryArray) {
        $dir = '';
        
        // *** if it is $categories settings array
        if(is_array($categoryArray) &&
           array_key_exists('id',$categoryArray)) {
          // if category == 0, means that the files are stored in the $adminConfig['savePath'] folder
          if($categoryArray['id'] == 0)
            $dir = dirname(__FILE__).'/../../'.$adminConfig['savePath'];
          elseif(is_numeric($categoryArray['id']))
            $dir = dirname(__FILE__).'/../../'.$adminConfig['savePath'].$categoryArray['id'];
        
        // *** if its just an array with the ids of the categories
        } else {
          // if category == 0, means that the files are stored in the $adminConfig['savePath'] folder
          if(is_numeric($categoryArray) && $categoryArray == 0) //$categoryArray === false ||
            $dir = dirname(__FILE__).'/../../'.$adminConfig['savePath'];
          elseif(is_numeric($categoryArray))
            $dir = dirname(__FILE__).'/../../'.$adminConfig['savePath'].$categoryArray;
        }
        
        // stores the paths in an array
        $categoryDirs[] = $dir;
      }
  } else {
    if($category === false || (is_numeric($category) && $category == 0)) //$category === false ||
      $categoryDirs[0] = dirname(__FILE__).'/../../'.$adminConfig['savePath'];
    elseif(is_numeric($category))
      $categoryDirs[0] = dirname(__FILE__).'/../../'.$adminConfig['savePath'].$category;
  }
  
  // LOAD THE FILES out of the dirs
  // goes trough all category dirs and put the page arrays into an array an retun it
  foreach($categoryDirs as $dir) {

    // opens every category dir and stores the arrays of the pages in an array
    if(is_dir($dir)) {
    
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
                $pages[] = readPage($file);
              else
                $pages[] = array(substr($file,0,-4),0);
            // load Pages, with a category
            } else {
              if($loadPagesInArray)
                $pages[] = readPage($file,$categoryId);
              else
                $pages[] = array(substr($file,0,-4),$categoryId);
            }
          }
        }
      }
      closedir($catDir);
            
      // sorts the category
      if($loadPagesInArray && is_array($pages) && !empty($categoryId)) {
        if($categories['id_'.$categoryId]['sortbydate'])
          $pages = sortPages($pages, 'sortByDate');
        else
          $pages = sortPages($pages, 'sortBySortOrder');
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
    if($allPageIds == '')
      $allPageIds = loadPages(true,false);
      
    if($allPageIds) {
      // gets the category id of the given page
      foreach($allPageIds as $everyPage) {
        // if its the right page, return the category of it        
        if($page == $everyPage[0]) {
          if($returnPageIds === false) return $everyPage[1];
          else return array($everyPage[1],$allPageIds);
        }
      }
      // if it found nothing
      if($returnPageIds === false) return false;
      else return array(false,$allPageIds);
      
    } else return false;
  } else return false;
}


// -> START -- createHref ******************************************************************************
// generates out of the a pageContent Array a href="" link for this page
// RETURNs a String for the HREF attribute
// -----------------------------------------------------------------------------------------------------
function createHref($pageContent,               // (pageContent Array) the pageContent Array of the page
                    $sessionId = false) {
  global $categories;
  global $adminConfig;
  
  // vars
  $page = $pageContent['id'];
  $category = $pageContent['category'];
  
  // ->> create HREF with speaking URL
  // *************************************
  if($adminConfig['speakingUrl'] == 'true') {
    $speakingUrlHref = '';
    
    // adds the category to the href attribute
    if($category != 0) {
      $categoryLink = '/category/'.encodeToUrl($categories['id_'.$category]['name']).'/';
    } else $categoryLink = '';
    
    
    $speakingUrlHref .= $categoryLink;
    if($categoryLink == '')
      $speakingUrlHref .= '/pages/'.encodeToUrl($pageContent['title']);
    else
      $speakingUrlHref .= encodeToUrl($pageContent['title']);
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
      $categoryLink = $adminConfig['varName']['category'].'='.$category.'&amp;';
    else $categoryLink = '';
    
    $getVarHref = 'index.php?'.$categoryLink.$adminConfig['varName']['page'].'='.$page;
    
    if($sessionId)
      $getVarHref .= '&amp;'.$sessionId;
    
    return $getVarHref;
  }  
}
// -> END -- createHref -----------------------------------------------------------------------------------

// ** -- sortBySortOrder ***************************************************************
// sort an Array with the pageContent Array by SORTORDER
// -------------------------------------------------------------------------------------
// $a       [der aktuelle Wert des Array],
// $b       [der folgende Wert des Array]
function sortBySortOrder($a, $b) {
  if ($a['sortorder'] == $b['sortorder']) {
    return 0;
  }
  return ($a['sortorder'] > $b['sortorder']) ? -1 : 1;
}
// ---- sortBySortOrder is used by the function sortPages ------------------------------

// ** -- sortByDate ********************************************************************
// sort an Array with the pageContent Array by DATE
// -------------------------------------------------------------------------------------
// $a       [der aktuelle Wert des Array],
// $b       [der folgende Wert des Array]
function sortByDate($a, $b) {
  global $adminConfig;
  
  $a['sortdate'] = str_replace('-','',$a['sortdate'][1]);
  $b['sortdate'] = str_replace('-','',$b['sortdate'][1]);  


  //echo $a['sortdate'].'<br>';
  //echo $b['sortdate'].'<br><br>';
  
  if ($a['sortdate'] == $b['sortdate']) {
    return 0;
  }
  return ($a['sortdate'] > $b['sortdate']) ? -1 : 1;
}
// ---- sortByDate is used by the function sortPages -----------------------------------

// ** -- sortbyCategory ****************************************************************
// sort an Array with the pageContent Array by CATEGORY
// -------------------------------------------------------------------------------------
// $a       [der aktuelle Wert des Array],
// $b       [der folgende Wert des Array]
function sortByCategory($a, $b) {
  global $categories;
  
  // looks for the categories order
  $categoryIds = '0 ';
  foreach($categories as $category) {
    $categoryIds .= $category['id'].' ';
  }
  
  if ($a['category'] == $b['category']) {
    return 0;
  }
  // sorts the array like the categories array order is
  return (strpos($categoryIds,$a['category']) < strpos($categoryIds,$b['category'])) ? -1 : 1;
}
// ---- sortbyCategory is used by the function sortPages -------------------------------


// ** -- sortPages ----------------------------------------------------------------------------------
// sort an Array with the pageContent Arrays by the given sort function
// --------------------------------------------------------------------------------------------------
// $pagesArray   [the array with the pageContent array (Array with pageContent Array)],
// $category     [gruppe in der sich die Seiten befinden (String)]
function sortPages($pageContentArrays,           // the ARRAY with the PAGECONTENT ARRAY (Array with pageContent Array)
                   $sortBy = false) {            // (Boolean or String) the sortfunction to be used ('sortBySortOrder';'sortByCategory','sortByDate'), if FALSE it detects the sortfunction by the category

  global $categories;
  
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
        if($category && $categories['id_'.$category]['sortbydate'])
          usort($categoriesArray, 'sortByDate');
        else
          usort($categoriesArray, 'sortBySortOrder');        
      } else
        usort($categoriesArray, $sortBy);
      
      
      
      // makes the category ascending, if its in the options
      if($category && $categories['id_'.$category]['sortascending'])
        $categoriesArray = array_reverse($categoriesArray);
       
      foreach($categoriesArray as $pageContent) {
        // creates the NEW sorted array
        $newPageContentArray[] = $pageContent;
      }
    }
  }
    
  return $newPageContentArray;
}


// ** -- validateDateFormat ----------------------------------------------------------------------------------
// checks the date,
// RETURNs a validated array
// with the array[0] =text before the date,
// and array[1] = the date (in FORMAT YYYY-MM-DD), or FALSE
// -----------------------------------------------------------------------------------------------------
function validateDateFormat($dateString) {       // (String) the given string with an date on the end
  
  if(!is_string($dateString))
    return false;
    
  // get the date out of the $dateString
  //$date = substr($dateString, -10);
  //$beforeDate = substr($dateString,0, -10);
  $date = str_replace(array('\'', ';', '-', '.', ','), '/', $dateString);
  
  $date = explode('/', $date);

  // checks a date with no seperation signs -> has to have the format YYYYMMDD or DDMMYYYY
  if(count($date) == 1)  {
    $date[0] = substr($date[0],-8);
    
    if(is_numeric($date[0])) {
    
      // YYYYMMDD
      if(checkdate(substr($date[0], 4, 2),
                   substr($date[0], 6, 2),
                   substr($date[0], 0, 4)))
        return substr($date[0], 0, 4).'-'.substr($date[0], 4, 2).'-'.substr($date[0], 6, 2);
      // DDMMYYYY
      elseif(checkdate(substr($date[0], 2, 2),
                   substr($date[0], 0, 2),
                   substr($date[0], 4, 4)))
        return substr($date[0], 4, 4).'-'.substr($date[0], 2, 2).'-'.substr($date[0], 0, 2);
      else
        return false;
    } else return false;
  }
  
  // check if it is a date format 'de' or 'int'
  /*
  if (($format == 'eu' && !preg_match('/^(\d{2})\/(\d{2})\/(\d{4})$/', trim($date), $matches)) ||
      ($format == 'int' && !preg_match('/^(\d{4})\/(\d{2})\/(\d{2})$/', trim($date), $matches))) {
      return false;
  }
  */
  
  // checks the array with the date
  if(count($date) == 3 &&
     is_numeric($date[0]) &&
     is_numeric($date[1]) &&
     is_numeric($date[2])) {

    //mmddyyyy
    if(checkdate($date[0], $date[1], $date[2]))
      return $date[2].'-'.$date[0].'-'.$date[1];
    //ddmmyyyy
    elseif(checkdate($date[1], $date[0], $date[2]))
      return $date[2].'-'.$date[1].'-'.$date[0];
    //yyyymmdd
    elseif(checkdate($date[1], $date[2], $date[0]))
      return $date[0].'-'.$date[1].'-'.$date[2];
    else
      return false;
  }
 
  // wenn die funktion nichts anderes zurückgegeben hat return false
  return false;
}

// ** -- cleanSpecialChars --------------------------------------------------------------------------
// removes all special chars
// --------------------------------------------------------------------------------------------------
// $string         [the string where the special chars should be removed  (String)],
// $replaceString    [the string with which they should be replaced (String)]
function cleanSpecialChars($string,$replaceString = '') {
  
  // allows only a-z and 0-9 and _
  $string = preg_replace('/[^\w]/u', $replaceString, $string);
  //$string = str_replace( array('Œ','','™','?','Š','|','@','[',']','Ÿ','','·','!','—',',',";","*","°","{",'}','^','´','`','=',":"," ","%",'+','/','\\',"&",'#','!','?','¿',"$","§",'"',"'","(",")"), $replaceSign, $string);
  
  return $string;
}


// ** -- clearTitle ----------------------------------------------------------------------------------
// clears the title string from not allowed chars and change the speial chars into htmlentities
// -----------------------------------------------------------------------------------------------------
function clearTitle($title) {
    
    // format title
    $title = preg_replace("/ +/", ' ', $title);
    $title = htmlentities($title,ENT_QUOTES,'UTF-8');
    
    return $title;
}

// ** -- encodeToUrl ----------------------------------------------------------------------------------
// encode a String so that it can be used as url
// -----------------------------------------------------------------------------------------------------
function encodeToUrl($string) {
    
    // format string
    $string = preg_replace("/ +/", '_', $string);    
    
    // changes umlaute
    $string = str_replace('&auml;','ae',$string);
    $string = str_replace('&Auml;','Ae',$string);
    $string = str_replace('&uuml;','ue',$string);    
    $string = str_replace('&Uuml;','Ue',$string);
    $string = str_replace('&ouml;','oe',$string);
    $string = str_replace('&Ouml;','Oe',$string);
    
    // clears htmlentities example: &amp;
    $string = preg_replace('/&[a-zA-Z0-9]+;/', '', $string);
    // allows only a-z and 0-9 and _ and -
    $string = preg_replace('/[^\w_-]/u', '', $string);
    
    // clears double __
    $string = preg_replace("/_+/", '_', $string);
    
    return $string;
}

// ** -- formatDate ----------------------------------------------------------------------------------
// returns the date out of a database-date-format in the choosen format
// -------------------------------------------------------------------------------------------------
// $givenDate       [],
// $format          [the format of the date, "de" = dd.mm.yyyy or "int" = yyyy.mm.dd (String)]
function formatDate($givenDate,               // (String like: yyyy-mm-dd hh:mm:ss) the date given in a database-date-format like: yyyy-mm-dd hh:mm:ss
                    $format = false) {        // (false or String) the format to use ("eu" or "int")
    global $adminConfig;
                            
    $year = substr($givenDate,0,4);
    $month = substr($givenDate,5,2);
    $day = substr($givenDate,8,2);
    
    if(strstr($givenDate,'-') && is_numeric($year) && is_numeric($month) && is_numeric($day)) {

      if($format === false)
        $format = $adminConfig['dateFormat'];
      
      if($format == 'eu') {
          return $day.'.'.$month.'.'.$year;        
      } elseif($format == 'int') {
          return $year.'-'.$month.'-'.$day;
      } else
          return false;
    } else return $givenDate;
}

// ** -- formatTime ----------------------------------------------------------------------------------
// returns the time out of a database-date-format with or without seconds
// -------------------------------------------------------------------------------------------------
// $givenDate       [the date given in a database-date-format like: yyyy-mm-dd hh:mm:ss],
// $showSeconds     [if true the secondes in the time will also be returned (Boolean)]
function formatTime($givenDate,$showSeconds = false) {
    $hour = substr($givenDate,-8,2);
    $minute = substr($givenDate,-5,2);
    $second = ':'.substr($givenDate,-2,2);
 
    if(!$showSeconds) {
        $second = '';
    }    
  
    return $hour.':'.$minute.$second;
}

// ** -- showMemoryUsage ----------------------------------------------------------------------------------
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

?>