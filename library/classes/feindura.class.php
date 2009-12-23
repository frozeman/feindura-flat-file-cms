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
* library/classes/frontend.classes.php version 1.40
* 
*/

//error_reporting(E_ALL);
include_once(dirname(__FILE__)."/../frontend.include.php");

// ***** -- feindura --------------------------------------------------------------------------------
// the class for the implimentation of the feindura - Flat File Content Management System
// -----------------------------------------------------------------------------------------------------
class feindura {
  
  /* VAR PRIORITY INFO:
  *  ->> uses the following PRIORITY for the VARs:
  *  
  *  1: USE the given page(s) AND/OR category(ies) var         -> (if FALSE, go to the NEXT)
  *  *
  *  2: USE the PROPERTY page(s) AND/OR category(ies) var      -> (if FALSE, go to the NEXT)
  *  *
  *  3: page(s) AND/OR category(ies) var is set to FALSE       -> (NO PAGE or CATEGORY will be SHOWN) 
  *    
  *  ->> in the these METHODs:
  *    -> createLink()
  *    -> createMenu()
  *    -> createMenuByTags()
  *    -> createMenuByDate()    
  *    -> showPage()
  *    -> listPages()  
  *    -> listPagesByTags()
  *    -> listPagesByDate()  
  */  
  
  // ----------------------------
  // *** PROPERTIES
  // ****************************
  
  // PROTECTED
  // *********
  var $sessionId = false;                 // the session id, if cookies are deactivated
  var $varNames = array('page' =>     'page',         // [String in an Array]    -> the variable name used for the get variable for the page
                        'category' => 'category',     // [String in an Array]    -> the variable name used for the get variable for the category
                        'modul' =>    'modul');       // [String in an Array]    -> the variable name used for the get variable for the modul
                              
  var $storedPageIds = '';                // (empty or Array) stores all page IDs and category IDs in an Array, if its gone once trough the category folders (saves resources)
  var $storedPages = false;               // (false or Array) stores all pageContentArrays, if they where loaded (saves resources)
                                 
  // PUBLIC
  // *********
  var $adminConfig;                       // [Array] the Array with the adminConfig Data from the feindura CMS
  var $websiteConfig;                     // [Array] the Array with the websiteConfig Data from the feindura CMS
  var $categoryConfig;                    // [Array] the Array with the categoryConfig Data from the feindura CMS
  
  var $generalFunctions;
  var $statisticFunctions;
  var $frontendFunctions;
  
  var $language = 'de';                   // [String]               -> string with the COUNTRY CODE ("de", "en", ..), which is used by the feindura class (for warnings etc)
  var $languageFile = false;              // [Array]                -> Array of the languageFile (example: "/feindura/library/lang/en.frontend.php")
  
  var $xHtml = true;                      // [Boolean]              -> all pages are displayed in xHTML if not in HTML (changes standalone tags " />" to ">")
  
  var $page = false;                      // [Boolean or Number]    -> page ID (if set to false: it will uses the $_GET page var)
  var $pages = false;                     // [Boolean or Array]     -> Array with page IDs
  var $category = false;                  // [Boolean or Number]    -> category ID (if set to false: it will uses the $_GET category var)
  var $categories = false;                // [Boolean or Array]     -> Array with category IDs
  var $modul = false;                     // [Boolean or String]    -> the modul name (if set to false: it will uses the $_GET modul var)
  
  var $linkId = false;                    // [False or String]      -> the link ID which is used when creating a link (REMEMBER you can only set ONE ID in an HTML Page)
  var $linkClass = false;                 // [False or String]      -> the link CLASS which is used when creating a link
  var $linkAttributes = false;            // [False or String]      -> a String with Attributes like: 'key="value" key2="value2"'
  var $linkBefore = false;                // [False or String]      -> a String which comes BEFORE the link <a> tag
  var $linkAfter = false;                 // [False or String]      -> a String which comes AFTER the link </a> tag
  var $linkTextBefore = false;            // [False or String]      -> a String which comes BEFORE the linkText <a> tag
  var $linkTextAfter = false;             // [False or String]      -> a String which comes AFTER the linkText </a> tag
  var $linkThumbnail = false;         // [Boolean]              -> show the thumbnail in the link
  var $linkThumbnailAfterText = false;    // [Boolean]              -> show the thumbnail after the linkText
  var $linkLength = false;                // [Boolean or Number]    -> the number of maximun characters for the link Title, after this length it will be shorten with abc..
  var $linkShowCategory = false;          // [Boolean]              -> show the category name before the title
  var $linkCategorySpacer = ' &rArr; ';   // [String]               -> the text to be used as a spacer between the category name and the title (example: Category -> Title Text)
  var $linkShowDate = false;              // [Boolean]              -> show the page date before the title
  var $linkStartText = false;             // [Boolean or String]    -> a text which appears before the title 

  var $menuTag = false;                   // [False or String (a Block Element, "ul", "ol" or "table")]      -> the menu TAG which is used when creating a menu, (STANDARD Tag: DIV; if there is a class and/or id and no TAG is set it just list the <a..> tags within a DIV tag)
  var $menuId = false;                    // [False or String]      -> the menu ID which is used when creating a menu (REMEMBER you can only set ONE ID in an HTML Page)
  var $menuClass = false;                 // [False or String]      -> the menu CLASS which is used when creating a menu
  var $menuAttributes = false;            // [False or String]      -> a String with Attributes like: 'key="value" key2="value2"'
  var $menuBefore = false;                // [False or String]      -> a String which comes BEFORE the menu <$menuTag> tag
  var $menuAfter = false;                 // [False or String]      -> a String which comes AFTER the menu </$menuTag> tag
  var $menuBetween = false;               // [False or String]      -> a String which comes AFTER EVERY <li></li> OR <td></td> tag EXCEPT THE LAST tag
  
  var $title = true;                      // [Boolean]              -> show the title when SHOW Pages and LISTING Pages
  var $titleTag = 'h1';                   // [Boolean or String]    -> the title TAG which is used when creating a page title (STANDARD Tag: H1)
  var $titleId = false;                   // [False or String]      -> the title ID which is used when creating a page title (REMEMBER you can only set ONE ID in an HTML Page, so dont use this for listing Pages)
  var $titleClass = false;                // [False or String]      -> the title CLASS which is used when creating a page title
  var $titleLength = false;               // [Boolean or Number]    -> the number of maximun characters for the title, after this length it will be shorten with abc..
  var $titleAsLink = false;               // [Boolean]              -> should the title be a link to the Page (ONLY when listing a Page)
  var $titleShowCategory = false;         // [Boolean]              -> show the category name before the title
  var $titleCategorySpacer = ' &rArr; ';  // [String]               -> the text to be used as a spacer between the category name and the title (example: Category -> Title Text)
  var $titleShowDate = false;             // [Boolean]              -> show the page date before the title
  var $titleStartText = false;            // [Boolean or String]    -> a text which appears before the title
  var $titleBefore = false;               // [False or String]      -> a String which comes BEFORE the link <$titleTag> tag
  var $titleAfter = false;                // [False or String]      -> a String which comes AFTER the link </$titleTag> tag
  

  var $content = true;                    // [Boolean]              -> show the page content when SHOW Pages and LISTING Pages
  var $contentTag = false;                // [False or String]      -> the content container TAG which is used when creating a page (STANDARD Tag: DIV; if there is a class and/or id and no TAG is set)
  var $contentId = false;                 // [False or String]      -> the content container  ID which is used when creating a page (REMEMBER you can only set ONE ID in an HTML Page, so dont use this for listing Pages)
  var $contentClass = false;              // [False or String]      -> the content container  CLASS which is used when creating a page
  var $contentLength = false;             // [Boolean or Number]    -> the number of maximun characters for the content, after this length it will be shorten with abc..
  var $contentThumbnail = true;       // [Boolean]              -> show the page thumbnails when SHOW and LISTING Pages
  var $contentBefore = false;             // [False or String]      -> a String which comes BEFORE the link <$contentTag> tag
  var $contentAfter = false;              // [False or String]      -> a String which comes AFTER the link </$contentTag> tag
  
  
  var $thumbnailFloat = false;            // [False or String ("left" or "right")]   -> let the thumbnail float to left or right
  var $thumbnailId = false;               // [False or String]      -> the thumbnail ID which is used when creating a thumbnail (REMEMBER you can only set ONE ID in an HTML Page, so dont use this for listing Pages)
  var $thumbnailClass = false;            // [False or String]      -> the thumbnail CLASS which is used when creating a thumbnail
  var $thumbnailBefore = false;           // [False or String]      -> a String which comes BEFORE the thumbnail img <$titleTag> tag
  var $thumbnailAfter = false;            // [False or String]      -> a String which comes AFTER the thumbnail img </$titleTag> tag
  
  var $error = true;                    // [Boolean]              -> show a message when a error or a notification appears (example: 'The page you requested doesn't exist')
  var $errorTag = false;                // [False or String]      -> the message TAG which is used when creating a message (STANDARD Tag: SPAN; if there is a class and/or id and no TAG is set)
  var $errorId = false;                 // [False or String]      -> the message ID which is used when creating a message (REMEMBER you can only set ONE ID in an HTML Page, so dont use this for listing Pages)
  var $errorClass = false;              // [False or String]      -> the message CLASS which is used when creating a message
  

  // ----------------------------
  // *** METHODS
  // ****************************
  /*
  *
  * createMetaTags($charset = 'UTF-8', $robotTxt = false, $revisitAfter = '10', $author = false, $publisher = false, $copyright = false)
  *      
  *                           
  * createLink($page = false, $category = false, $linkText = true)
  *  
  * createMenu($idType = 'categories', $ids = true, $linkText = true, $menuTag = true, $breakAfter = false, $sortingConsiderCategories = false)
  * 
  * createMenuByTags($tags ,$idType = 'categories', $ids = true, $linkText = true, $menuTag = true, $breakAfter = false, $sortingConsiderCategories = false)
  *    
  * createMenuByDate($idType, $ids = true, $monthsInThePast = true, $monthsInTheFuture = true, $linkText = true, $menuTag = true, $breakAfter = false, $sortingConsiderCategories = false, $flipList = false) 
  * 
  *  
  * showPageTitle($page = false, $category = false, $titleTag = true)
  *    
  * showPage($page = false, $category = false, $shortenText = false, $useHtml = true)             <- also saves the statistics of the page
  *   
  *  
  * listPages($idType, $ids = true, $shortenText = true, $useHtml = true, $sortingConsiderCategories = false)
  *  
  * listPagesByTags($tags, $idType, $ids = true, $shortenText = true, $useHtml = true, $sortingConsiderCategories = false)
  * 
  * listPagesByDate($idType, $ids = true, $monthsInThePast = true, $monthsInTheFuture = true, $shortenText = true,  $useHtml = true,  $sortingConsiderCategories = false, $flipList = false)
  * 
  *  
  * getCurrentPage()
  * 
  * getCurrentCategory()    
  * 
  * setCurrentPage($setStartPage = false)
  * 
  * setCurrentCategory()
  *     
  */ 
  
  // -> START ** constructor *****************************************************************************
  // the class constructor
  // get the config Arrays
  // set the varNames from the adminConfig.php
  // gte the GET (if existing) and set it to the PROPERTIES
  // get the language File for the frontend
  // -----------------------------------------------------------------------------------------------------
  function feindura($language = false) {   // (String) string with the COUNTRY CODE ("de", "en", ..)
    global $adminConfig;
    global $websiteConfig;
    global $categories;    
    
    // GET CONFIG FILES and SET CONFIG PROPERTIES
    $this->adminConfig = $adminConfig;
    $this->websiteConfig = $websiteConfig;
    $this->categoryConfig = $categories;
    
    // GET FUNCTIONS
    $this->generalFunctions = new generalFunctions();
    $this->statisticFunctions = new statisticFunctions();
    $this->frontendFunctions = new frontendFunctions();
    
    // save the website statistics
    // ***************************
    $this->statisticFunctions->saveWebsiteStats();
    
    // sets the varNames.. from the adminConfig
    // ****************************************
    // page varName
    if(isset($this->adminConfig['varName']['page']) && !empty($this->adminConfig['varName']['page']))
      $this->varNames['page'] = $this->adminConfig['varName']['page'];
    // category varName
    if(isset($this->adminConfig['varName']['category']) && !empty($this->adminConfig['varName']['category']))
      $this->varNames['category'] = $this->adminConfig['varName']['category'];
    
    
    // saves the current GET vars in the PROPERTIES
    // ********************************************
    $this->setCurrentCategory();           // $_GET['varNameCategory']  // first category to load then the page
    $this->setCurrentPage(true);           // $_GET['varNamePage'] <- gets the $this->websiteConfig['startPage'] if there is no GET page var
          
    // -> CHECKS if cookies are enabled
    if(!isset($_COOKIE['cookiesEnabled'])) {
      // try to set a cookie, for checking pn the next page
      setcookie( "cookiesEnabled", 'true');
      
      $this->sessionId = htmlspecialchars(session_name().'='.session_id()); //SID
    }
    
    // sets the language PROPERTY from the session var AND the languageFile Array
    // **************************************************************************    
    // if no country code is given
    if($language === false || strlen($language) != 2) {
      // gets the BROWSER STANDARD language
      $this->language = $this->generalFunctions->getLanguage($this->adminConfig['langPath'],false); // returns a COUNTRY SHORTNAME
    } else
      $this->language = $language;
    
    // includes the langFile
    $this->languageFile = include(DOCUMENTROOT.$this->adminConfig['basePath'].'library/lang/'.$this->language.'.frontend.php');
    
    return true;
  }
  // -> END -- constructor -------------------------------------------------------------------------------
  
  
  // ****************************************************************************************************************
  // PUBLIC METHODs -------------------------------------------------------------------------------------------------
  // ****************************************************************************************************************
  
  // -> START -- createMetaTags **************************************************************************
  // SHOWs the META TAGS at the position
  // -----------------------------------------------------------------------------------------------------
  function createMetaTags($charset = 'UTF-8',            // (String) the string of the charset used for the metatags
                                 $robotTxt = false,             // (Boolean or String) if TRUE it sees the robot.txt in the root dir of the website, if STRING it uses this path for the robot.txt file
                                 $revisitAfter = '10',          // (false or Number) number of days the robot should revisit this page
                                 $author = false,               // (false or String) the author used in the meta tags
                                 $publisher = false,            // (false or String) the publisher used in the meta tags
                                 $copyright = false) {          // (false or String) the copyright used in the meta tags
      
      // vars
      $metaTags = '';
      $pageNameInTitle = '';
      
      // -> clear xHTML tags from the content
      if($this->xHtml === true)        
        $siteType = 'application/xhtml+xml';
      else
        $siteType = 'text/html';
        
      
      // -> add CHARSET
      $metaTags .= '<meta http-equiv="content-type" content="'.$siteType.'; charset='.$charset.'" />'."\n";
      
      // -> add language
      if($this->language)
        $metaTags .= '  <meta http-equiv="content-language" content="'.$this->language.'" />'."\n\n"; 
      
      // -> create TITLE
      if($this->getCurrentPage() && $currentPage = $this->readPage($this->getCurrentPage(),$this->getCurrentCategory()))
        $pageNameInTitle = ' - '.$currentPage['title'];
      
      // -> add TITLE
      $metaTags .= '  <title>'."\n";      
      $metaTags .= '  '.$this->websiteConfig['title'].$pageNameInTitle."\n";
      $metaTags .= '  </title>'."\n\n";
      
      // -> add robots.txt
      if($robotTxt === true)
        $metaTags .= '  <meta name="siteinfo" content="robots.txt" />'."\n";
      elseif(!empty($robotTxt))
        $metaTags .= '  <meta name="siteinfo" content="'.$robotTxt.'" />'."\n";
      
      if($robotTxt) {
        $metaTags .= '  <meta name="robots" content="index" />'."\n";
        $metaTags .= '  <meta name="robots" content="nofollow" />'."\n";
      }
        
      // -> add REVISIT AFTER
      if($robotTxt && $revisitAfter !== false && is_numeric($revisitAfter))
        $metaTags .= '  <meta name="revisit_after" content="'.$revisitAfter.'" />'."\n\n";
      
      // -> add other META TAGs 
      $metaTags .= '  <meta http-equiv="pragma" content="no-cache" /> <!-- browser/proxy does not cache -->'."\n";
      $metaTags .= '  <meta http-equiv="cache-control" content="no-cache" /> <!-- browser/proxy does not cache -->'."\n\n";
      
      // -> add title
      $metaTags .= '  <meta name="title" content="'.$this->websiteConfig['title'].$pageNameInTitle.'" />'."\n";
      
      // -> add author
      if($author && is_string($author))
        $metaTags .= '  <meta name="author" content="'.$author.'" />'."\n";
        
      // -> add puplisher
      if($publisher && is_string($publisher))
        $metaTags .= '  <meta name="publisher" content="'.$publisher.'" />'."\n";
      elseif(!empty($this->websiteConfig['publisher']))
        $metaTags .= '  <meta name="publisher" content="'.$this->websiteConfig['publisher'].'" />'."\n";
        
      // -> add copyright
      if($copyright && is_string($copyright))
        $metaTags .= '  <meta name="copyright" content="'.$copyright.'" />'."\n";
      elseif(!empty($this->websiteConfig['copyright']))
        $metaTags .= '  <meta name="copyright" content="'.$this->websiteConfig['copyright'].'" />'."\n";
        
      // -> add description
      if($this->websiteConfig['description'])
        $metaTags .= '  <meta name="description" content="'.$this->websiteConfig['description'].'" />'."\n";
        
      // -> add keywords
      if($this->websiteConfig['keywords'])
        $metaTags .= '  <meta name="keywords" content="'.$this->websiteConfig['keywords'].'" />'."\n";
      
      
      
      // -> clear xHTML tags from the content
      if($this->xHtml === false)
        $metaTags = str_replace(' />','>',$metaTags);
      
      // -> show the metaTags
      echo $metaTags;
      return $metaTags;
  }
  // -> *ALIAS* OF createMetaTags ****************************************************************************
  function createMetaTag($charset = 'UTF-8', $robotTxt = false, $revisitAfter = '10', $author = false, $publisher = false, $copyright = false) {
    // call the right function
    return $this->createMetaTags($charset, $robotTxt, $revisitAfter, $author, $publisher, $copyright);
  }
  
  // -> START -- createLink ******************************************************************************
  // SHOWs a link created with the page ID
  // IF $page is a pageContent Array it ONLY RETURNs the LINK
  // * MORE OPTIONs in the PROPERTIES
  // -----------------------------------------------------------------------------------------------------
  function createLink($page = false,                 // (Number or String ("prev" or "next") or pageContent Array) the page ID to show, if FALSE it use VAR PRIORITY
                             $category = false,             // (false or Number) the category where the page is situated, if FALSE it looks automaticly for the category ID
                             $linkText = true) {            // (Boolean or String) the TEXT used for the link, if TRUE it USES the TITLE of the page
    
    // set TAG ENDING (xHTML or HTML) 
    if($this->xHtml === true) $tagEnding = ' />';
    else $tagEnding = '>';     
    
    // -> PREV or NEXT if given direction
    $prevNext = false;
    if(is_string($page)) {
      $page = strtolower($page);
      // PREV
      if($page == 'prev' || $page == 'previous') {
        $prevNext = 'prev';
        $page = false;
      // NEXT
      } elseif($page == 'next') {
        $prevNext = 'next';
        $page = false;
      }
    }
    
    // USES the PRIORITY: 1. -> page var 2. -> PROPERTY page var 3. -> FALSE
    $page = $this->getPropertyPage($page);
    
    // gets the category of the page if it is not given
    if($category === false)
      $category = $this->getPageCategory($page);
    
    //echo 'PAGE: '.$page;
    
    // IF page == pageContent Array, return the LINK to the MENU otherwise SHOW the LINK
    if(is_array($page) && array_key_exists('id',$page) && $pageContent = $page)
      $onlyReturn = true;
    else
      $onlyReturn = false;
    
    if($page &&
       ((is_array($page) && array_key_exists('id',$page) && $pageContent = $page) ||              // the $page var is a pageContent Array
       (is_numeric($page) && $pageContent = $this->readPage($page,$category)))) {    // $the $page var is a page ID
       
        // -> if NEXT or PREV
        // ----------------------------
        if($prevNext !== false) {          
          $pageContent = $this->prevNextPage($prevNext,$pageContent['id'],$pageContent['category']);
        }

      // -> CHECK IF PUBLIC
      // ---------------------------------------->        
      if($pageContent['public'] && $this->publicCategory($pageContent['category']) !== false) {            
        
        // -> sets the LINK
        // ----------------------------  
        $linkTag = 'a';
        $linkAttributes = '';
        $linkStartTag = '';
        $linkEndTag = '';
        $linkTextBefore = '';
        
        // add HREF
        $linkAttributes .= ' href="'.$this->createHref($pageContent).'" title="'.$pageContent['title'].'"';

        // add LINK ID
        if($this->linkId && $this->linkId !== true)
          $linkAttributes .= ' id="'.$this->linkId.'"';
          
        // add LINK CLASS
        if($this->linkClass && $this->linkClass !== true)
          $linkAttributes .= ' class="'.$this->linkClass.'"';
          
        // add LINK ATTRIBUTES
        if($this->linkAttributes && $this->linkAttributes !== true)
          $linkAttributes .= ' '.$this->linkAttributes;
                    
        $linkStartTag = '<'.$linkTag.$linkAttributes.'>';
        $linkEndTag = '</'.$linkTag.'>';        
        
        // -> LINK THUMBNAIL
        // *****************
        if($this->linkThumbnail &&      
          !empty($pageContent['thumbnail']) &&
          @is_file(DOCUMENTROOT.$this->adminConfig['uploadPath'].$this->adminConfig['pageThumbnail']['path'].$pageContent['thumbnail']) &&
          ((!$pageContent['category'] && $this->adminConfig['page']['thumbnailUpload']) ||
          ($pageContent['category'] && $this->categoryConfig['id_'.$pageContent['category']]['thumbnail']))) {
          
          // adds ID and/or Class and/or FLOAT
          $thumbnailAttributes = '';
          // thumbnail ID
          if($this->thumbnailId && $this->thumbnailId !== true)
            $thumbnailAttributes .= ' id="'.$this->thumbnailId.'"';
          // thumbnail CLASS
          if($this->thumbnailClass && $this->thumbnailClass !== true)
            $thumbnailAttributes .= ' class="'.$this->thumbnailClass.'"';
          // thumbnail FLOAT
          if(strtolower($this->thumbnailFloat) === 'left' ||
             strtolower($this->thumbnailFloat) === 'right')
            $thumbnailAttributes .= ' style="float:'.strtolower($this->thumbnailFloat).';"';
          
          $linkThumbnail = '<img src="'.$this->adminConfig['uploadPath'].$this->adminConfig['pageThumbnail']['path'].$pageContent['thumbnail'].'" alt="'.$pageContent['title'].'" title="'.$pageContent['title'].'"'.$thumbnailAttributes.$tagEnding."\n";
        } else $linkThumbnail = '';
      
        
        // -> LINK TITLE
        // *****************
        // -> create the text
        if($linkText === true) {
        
          // title with category name
          if($this->linkShowCategory && $pageContent['category']) {
            if(is_string($this->linkCategorySpacer))
              $linkCategory = $this->linkCategorySpacer;
            else
              $linkCategory = true;
          } else $linkCategory = false;
          
          // add the TITLE
          $linkText = $this->createTitle($pageContent,
                                        false, // linktag
                                        false, // $titleId
                                        false, // $titleClass
                                        $this->linkLength,
                                        false, // $titleAsLink
                                        $linkCategory,
                                        $this->linkShowDate,
                                        $this->linkStartText);
        }
             
        // CHECK if the THUMBNAIL BEFORE & AFTER is !== true
        $thumbnailBefore = false;
        $thumbnailAfter = false;
        
        if(!empty($linkThumbnail)) {
          if($this->thumbnailBefore !== true)
            $thumbnailBefore = $this->thumbnailBefore;
          if($this->thumbnailAfter !== true)
            $thumbnailAfter = $this->thumbnailAfter;          
        }
        
        // CHECK if the LINKTEXT BEFORE & AFTER is !== true
        $linkTextBefore = false;
        $linkTextAfter = false;
        
        if(!empty($linkText)) {
          if($this->linkTextBefore !== true)
            $linkTextBefore = $this->linkTextBefore;
          if($this->linkTextAfter !== true)
            $linkTextAfter = $this->linkTextAfter;
        }
        
        // CHECK if the LINK BEFORE & AFTER is !== true
        $linkBefore = false;
        $linkAfter = false;
        
        if($this->linkBefore !== true)
          $linkBefore = $this->linkBefore;
        if($this->linkAfter !== true)
          $linkAfter = $this->linkAfter;
        
        
        // CHECK IF THUMBNAIL AFTER TEXT
        if($this->linkThumbnailAfterText === true)
          $linkString = $linkTextBefore.$linkText.$linkTextAfter.$thumbnailBefore.$linkThumbnail.$thumbnailAfter;
        else
          $linkString = $thumbnailBefore.$linkThumbnail.$thumbnailAfter.$linkTextBefore.$linkText.$linkTextAfter;            
        
        // -> create the LINK
        // ----------------------------
        $link = $linkBefore.$linkStartTag.$linkString.$linkEndTag.$linkAfter;
        
        // shows the link if page was ONLY a ID
        if($onlyReturn === false)
          echo $link;
          
        // returns the whole link after finish
        return $link;
      } else return false;
    } else return false;
  }
  // -> END -- createLink --------------------------------------------------------------------------------
  
  // -> START -- createMenu ******************************************************************************
  // SHOW a menu created out of the pages IDs or a category ID(s) and also
  // RETURNs the whole menu as a String
  // * MORE OPTIONs in the PROPERTIES
  // -----------------------------------------------------------------------------------------------------
  function createMenu($idType = 'categories',                      // (String ["page", "pages" or "category", "categories"]) uses the given IDs for looking in the pages or categories
                             $ids = true,                                 // (false or Number or Array or Array with pageContent Arrays) the pages ID(s) or category ID(s) for the menu, if FALSE it use VAR PRIORITY, if TRUE and $idType = "category", it loads all categories
                             $linkText = true,                            // (Boolean or String) the TEXT used for the links, if TRUE it USES the TITLE of the pages
                             $menuTag = false,                            // (Boolean or String like "table" or "ul") the TAG used for the Menu, if TRUE it uses the menuTag from the PROPERTY
                             $breakAfter = false,                         // (Boolean or Number) if TRUE it makes a br behind each <a..></a> element, if its a NUMBER AND the menuTag IS "table" it breaks the rows after the given Number 
                             $sortingConsiderCategories = false) {        // (Boolean) if TRUE it sorts the pages by categories and the sorting like in the backend
    
    $idType = strtolower($idType);
    
    // USES the PRIORITY: 1. -> page var 2. -> PROPERTY page var 3. -> FALSE
    if($ids === false) {
      if($idType == 'page')
        // USES the PRIORITY: 1. -> pages var 2. -> PROPERTY pages var 3. -> FALSE
        $ids = $this->getPropertyPages($ids);
      elseif($idType == 'pages')
        // USES the PRIORITY: 1. -> page var 2. -> PROPERTY page var 3. -> FALSE
        $ids = $this->getPropertyPage($ids);
      elseif($idType == 'category')
        // USES the PRIORITY: 1. -> category var 2. -> PROPERTY category var 3. -> FALSE
        $ids = $this->getPropertyCategory($ids);
      elseif($idType == 'categories')
        // USES the PRIORITY: 1. -> categories var 2. -> PROPERTY categories var 3. -> FALSE
        $ids = $this->getPropertyCategories($ids);
    }
    $menu = false;
          
    // -> sets the MENU attributes
    // ----------------------------
    $menuAttributes = '';
    $menuStartTag = '';
    $menuEndTag = '';        
    $menuTagSet = false;
    
    // add MENU ID, uses the given menuId var, if not set it uses the PROPERTY menuId var
    if($this->menuId && $this->menuId !== true)
      $menuAttributes .= ' id="'.$this->menuId.'"';
      
    // add MENU CLASS, uses the given menuClass var, if not set it uses the PROPERTY menuClass var
    if($this->menuClass && $this->menuClass !== true)
      $menuAttributes .= ' class="'.$this->menuClass.'"';
      
    // add LINK ATTRIBUTES
    if($this->menuAttributes && $this->menuAttributes !== true)
      $menuAttributes .= ' '.$this->menuAttributes;
    
    
    if($menuTag || ($this->menuTag && $this->menuTag !== true) || !empty($menuAttributes)) {
      // creates standard tag
      $menuTagSet = 'div';
      // eventually overwrites standard tag
      
      // -> SET GIVEN $menuTag
      if($menuTag !== true)
        $menuTagSet = strtolower($menuTag);       
      // OR -> SET PROPERTY $menuTag
      elseif($this->menuTag && $this->menuTag !== true)
        $menuTagSet = strtolower($this->menuTag);
                
      $menuStartTag = '<'.$menuTagSet.$menuAttributes.'>'."\n";
      $menuEndTag = "\n".'</'.$menuTagSet.'>'."\n";
    }
    
    // LOADS the PAGES BY TYPE
    $pages = $this->loadPagesByType($idType,$ids);
    
    // -> if pages SORTED BY CATEGORY
    if($sortingConsiderCategories === true)
      $pages = $this->generalFunctions->sortPages($pages);
    
    if($pages !== false) {
      // create a link out of every page in the array
      foreach($pages as $page) {
        // creates the link
        if($pageLink = $this->createLink($page,$page['category'], $linkText)) {
          // adds the link to an array
          $links[] = $pageLink;
        }
      }
    } else return false;
    
    // --------------------------------------
    // -> builds the final MENU
    // ************************
    if(empty($links))
      return false;
    
    // CHECK if the LINK BEFORE & AFTER is !== true
    if($this->menuBefore !== true)
      $menuBefore = $this->menuBefore;
    if($this->menuAfter !== true)
      $menuAfter = $this->menuAfter;
    
    if($this->menuBetween !== true)
      $menuBetween = $this->menuBetween;
    
    // creating the START TR tag
    if($menuTagSet == 'table')
      $menuStartTag .= '<tr>';
    
    // SHOW START-TAG
    if($menuStartTag) {
      echo $menuBefore.$menuStartTag;
      $menu = $menuBefore.$menuStartTag;
    }
    
    $count = 1;
    foreach($links as $link) {
    
      // adds the break after BR
      if($breakAfter === true) {
        if($this->xHtml === true)
          $link .= "<br \>\n";
        else
          $link .= "<br>\n";
          
      // breaks the CELLs with TR after the given NUMBER of CELLS
      } elseif($menuTagSet == 'table' &&
               $breakAfter !== false &&
               is_numeric($breakAfter) &&
               ($breakAfter + 1) == $count) {
        echo "</tr><tr>\n";
        $menu .= "</tr><tr>\n";
        $count = 1;
      }
      
      // clears the $menuBetween String if its the last tag
      if($count == count($links))
        $menuBetween = false;
      
      // if menuTag is a LIST ------
      if($menuTagSet == 'ul' || $menuTagSet == 'ol')
        $link = '<li>'.$link."</li>\n".$menuBetween."\n";
        
      // if menuTag is a TABLE -----
      if($menuTagSet == 'table') {
        $link = '<td>'.$link."</td>\n".$menuBetween."\n";
      }
      
      // SHOW the link
      echo $link;
      $menu .= $link;
      
      // count the table cells
      $count++;
    }
    
    // fills in the missing TABLE CELLs
    while($menuTagSet == 'table' &&
          $breakAfter !== false &&
          is_numeric($breakAfter) &&
          $breakAfter >= $count) {
      echo "<td></td>\n";
      $menu .= "<td></td>\n";
      $count++;
    }
    
    // creating the END TR tag
    if($menuTagSet == 'table')
      $menuEndTag = '</tr>'.$menuEndTag;
    
    // SHOW END-TAG
    if($menuStartTag) {
      echo $menuEndTag.$menuAfter;
      $menu .= $menuEndTag.$menuAfter;
    }
 
    // returns the whole menu after finish
    return $menu;
  }
  // -> END -- createMenu --------------------------------------------------------------------------------
  
  // -> START -- createMenuByTags ******************************************************************************
  // SHOW a menu created out of the pages IDs or a category ID(s) and also, but only if the page has one of the given TAGS
  // RETURNs the whole menu as a String
  // * MORE OPTIONs in the PROPERTIES
  // -----------------------------------------------------------------------------------------------------
  function createMenuByTags($tags,                                     // (String or Array) the tags to select the page(s)/category(ies) with
                                   $idType = 'categories',                    // (String ["page", "pages" or "category", "categories"]) uses the given IDs for looking in the pages or categories
                                   $ids = true,                               // (false or Number or Array) the pages ID(s) or category ID(s) for the menu, if FALSE it use VAR PRIORITY, if TRUE and $idType = "category", it loads all categories
                                   $linkText = true,                          // (Boolean or String) the TEXT used for the links, if TRUE it USES the TITLE of the pages
                                   $menuTag = true,                           // (Boolean or String) the TAG used for the Menu, if TRUE it uses the menuTag from the PROPERTY
                                   $breakAfter = false,                       // (Boolean or Number) if TRUE it makes a br behind each <a..></a> element, if its a NUMBER AND the menuTag IS "table" it breaks the rows after the given Number 
                                   $sortingConsiderCategories = false) {      // (Boolean) if TRUE it sorts the pages by categories and the sorting like in the backend
                                   
    $idType = strtolower($idType);    
    // USES the PRIORITY: 1. -> page var 2. -> PROPERTY page var 3. -> GET page var 4. -> FALSE
    if($ids === false) {
      if($idType == 'page')
        // USES the PRIORITY: 1. -> pages var 2. -> PROPERTY pages var 3. -> FALSE
        $ids = $this->getPropertyPages($ids);
      elseif($idType == 'pages')
        // USES the PRIORITY: 1. -> page var 2. -> PROPERTY page var 3. -> FALSE
        $ids = $this->getPropertyPage($ids);
      elseif($idType == 'category')
        // USES the PRIORITY: 1. -> category var 2. -> PROPERTY category var 3. -> FALSE
        $ids = $this->getPropertyCategory($ids);
      elseif($idType == 'categories')
        // USES the PRIORITY: 1. -> categories var 2. -> PROPERTY categories var 3. -> FALSE
        $ids = $this->getPropertyCategories($ids);
    }
    
    // check for the tags and CREATE A MENU
    if($ids = $this->hasTags($ids,$idType,$tags)) {
      return $this->createMenu($idType,$ids,$linkText,$menuTag,$breakAfter,$sortingConsiderCategories); 
    } else return false;
  }
  // -> *ALIAS* OF createMenuByTags ****************************************************************************
  function createMenuByTag($tags, $idType = 'categories', $ids = true, $linkText = true, $menuTag = true, $breakAfter = false, $sortingConsiderCategories = false) {
    // call the right function
    return $this->createMenuByTags($tags,$idType,$ids,$linkText,$menuTag,$breakAfter,$sortingConsiderCategories);
  }
  
  // -> START -- createMenuByDate **************************************************************************
  // SHOW a menu created out of the pages IDs or a category ID(s), if they have a sortDate set and sortdate is activated in the category, AND its between the given month Number from now and in the past
  // RETURNs the whole menu as a String
  // * MORE OPTIONs in the PROPERTIES
  // ------------------------------------------------------------------------------------------------------
  function createMenuByDate($idType,                               // (String ["page", "pages" or "category", "categories"]) uses the given IDs for looking in the pages or categories
                                   $ids = true,                           // (false or Number or Array) the pages ID(s) or category ID(s) for the menu, if FALSE it use VAR PRIORITY, if TRUE and $idType = "category", it loads all categories
                                   $monthsInThePast = true,               // (Boolean or Number) number of month BEFORE today, if TRUE it shows ALL PAGES FROM the PAST, if FALSE it shows ONLY pages FROM TODAY
                                   $monthsInTheFuture = true,             // (Boolean or Number) number of month AFTER today, if TRUE it shows ALL PAGES IN the FUTURE, if FALSE it shows ONLY pages UNTIL TODAY
                                   $linkText = true,                      // (Boolean or String) the TEXT used for the links, if TRUE it USES the TITLE of the pages
                                   $menuTag = true,                       // (Boolean or String) the TAG used for the Menu, if TRUE it uses the menuTag from the PROPERTY
                                   $breakAfter = false,                   // (Boolean or Number) if TRUE it makes a br behind each <a..></a> element, if its a NUMBER AND the menuTag IS "table" it breaks the rows after the given Number 
                                   $sortingConsiderCategories = false,    // (Boolean) if TRUE it sorts the pages by categories and the sorting like in the backend
                                   $flipList = false) {                   // (Boolean) if TRUE it flips the array with the listet pages
                                   
      return $this->listByDate('menu',$idType,$ids,$monthsInThePast,$monthsInTheFuture,$linkText,$menuTag,$sortingConsiderCategories,$breakAfter,$flipList);
  }
  // -> *ALIAS* OF createMenuByDate **********************************************************************
  function createMenuByDates($idType, $ids = true, $monthsInThePast = true, $monthsInTheFuture = true, $linkText = true, $menuTag = true, $breakAfter = false, $sortingConsiderCategories = false, $flipList = false) {
    // call the right function
    return $this->createMenuByDate($idType, $ids, $monthsInThePast, $monthsInTheFuture, $linkText, $menuTag, $breakAfter, $sortingConsiderCategories, $flipList);
  }  
  
  // -> START -- showPage ********************************************************************************
  // SHOWs the Title of a given Page
  // * MORE OPTIONs in the PROPERTIES
  // -----------------------------------------------------------------------------------------------------
  function showPageTitle($page = false,              // (Number or String ("prev" or "next")) the page ID to show, if FALSE it use VAR PRIORITY
                                $category = false,          // (false or Number) the category where the page is situated, if FALSE it looks automaticly for the category ID
                                $titleTag = false) {        // (Boolean or String) the TAG which is used by the title (String), if TRUE it loads the titleTag PROPERTY
    
    // -> PREV or NEXT if given direction
    $prevNext = false;
    if(is_string($page)) {
      $page = strtolower($page);
      // PREV
      if($page == 'prev' || $page == 'previous') {
        $prevNext = 'prev';
        $page = false;
      // NEXT
      } elseif($page == 'next') {
        $prevNext = 'next';
        $page = false;
      }
    }
    
    // USES the PRIORITY: 1. -> page var 2. -> PROPERTY page var 3. -> FALSE
    $page = $this->getPropertyPage($page);
    
    // gets the category of the page if it is not given
    if($category === false)
      $category = $this->getPageCategory($page);

    
    if($this->publicCategory($category) !== false &&
       $pageContent = $this->readPage($page,$category)) {  
      
      if($pageContent['public']) { 
        
        // SET the PROPERTY $titleTag
        if($titleTag === true && $this->titleTag && $this->titleTag !== true)
          $titleTag = strtolower($this->titleTag);
        // OR SET GIVEN $titleTag         
        elseif(is_string($titleTag))
          $titleTag = strtolower($titleTag);
      
        // shows the TITLE
        $title = $this->createTitle($pageContent,
                                    $titleTag,
                                    $this->titleId,
                                    $this->titleClass,
                                    $this->titleLength,
                                    $this->titleAsLink,
                                    $this->titleShowCategory,
                                    $this->titleShowDate,
                                    $this->titleStartText);                                      
        
        
        // CHECK if the LINK BEFORE & AFTER is !== true
        if($this->titleBefore !== true)
          $titleBefore = $this->titleBefore;
        if($this->titleAfter !== true)
          $titleAfter = $this->titleAfter;
        
        echo $titleBefore.$title.$titleAfter;        
        return $titleBefore.$title.$titleAfter;        
      } else
      return false; 
    } else
      return false;    
  }
  // -> *ALIAS* OF showPageTitle **********************************************************************
  function showTitle($page = false, $category = false, $titleTag = true) {
    // call the right function
    return $this->showPageTitle($page, $category, $titleTag);
  } 
  
  // -> START -- showPage ********************************************************************************
  // SHOWs a Page, if there is no category set, it opens a page in the non-category and also
  // RETURNs the UNCHANGED pageContent Array
  // * MORE OPTIONs in the PROPERTIES (TITLE and CONTENT layout)
  // -----------------------------------------------------------------------------------------------------
  function showPage($page = false,                 // (Number or String ("prev" or "next")) the page ID to show, if FALSE it use VAR PRIORITY
                           $category = false,             // (false or Number) the category where the page is situated, if FALSE it looks automaticly for the category ID
                           $shortenText = false,          // (false or Number) the Number of characters to shorten the content text
                           $useHtml = true) {             // (Boolean) use html in the content text
    
    // -> PREV or NEXT if given direction
    $prevNext = false;
    if(is_string($page)) {
      $page = strtolower($page);
      // PREV
      if($page == 'prev' || $page == 'previous') {
        $prevNext = 'prev';
        $page = false;
      // NEXT
      } elseif($page == 'next') {
        $prevNext = 'next';
        $page = false;
      }
    }
    
    // USES the PRIORITY: 1. -> page var 2. -> PROPERTY page var 3. -> FALSE
    $page = $this->getPropertyPage($page);
    
    // gets the category of the page if it is not given
    if($category === false)
      $category = $this->getPageCategory($page);
    
    //echo '<br />page: '.$page;
    //echo '<br />category: '.$category;    

    if($this->publicCategory($category) !== false) {
      
      // -> if NEXT or PREV
      // ----------------------------
      if($prevNext !== false) {
        $page = $this->prevNextPage($prevNext,$page);
      }
      
      // ->> load SINGLE PAGE
      // *******************
      if($pageContent = $this->generatePage($page,$category,$this->error,$shortenText,$useHtml)) {
        // -> SAVE PAGE STATISTIC
        // **********************
        $this->statisticFunctions->savePageStats($pageContent);
        
        // returns the UNCHANGED pageContent Array, after showing the page
        return $pageContent;
      }
    }    
    return false;
  }
  // -> END -- showPage -----------------------------------------------------------------------------------
  
  
  // -> START -- listPages ********************************************************************************
  // SHOWs PAGEs, sorted by the categories or by the given array
  // RETURNs an Array of the UNCHANGED pageContent Arrays
  // * MORE OPTIONs in the PROPERTIES (TITLE and CONTENT layout)
  // ------------------------------------------------------------------------------------------------------
  function listPages($idType,                               // (String ["page", "pages" or "category", "categories"]) uses the given IDs for looking in the pages or categories
                            $ids = true,                           // (false or Number or Array or Array with pageContent Arrays) the pages ID(s) or category ID(s) for the menu, if FALSE it use VAR PRIORITY, if TRUE and $idType = "category", it loads all categories, -> can also be a Array with pageContent Arrays
                            $shortenText = true,                  // (Boolean or Number) the Number of characters to shorten the content text
                            $useHtml = true,                       // (Boolean) use html in the content text
                            $sortingConsiderCategories = false) {  // (Boolean) if TRUE it sorts the pages by categories and the sorting like in the feindura cms
    
    $idType = strtolower($idType);
    
    // USES the PRIORITY: 1. -> page var 2. -> PROPERTY page var 3. -> FALSE
    if($ids === false) {
      if($idType == 'page')
        // USES the PRIORITY: 1. -> pages var 2. -> PROPERTY pages var 3. -> FALSE
        $ids = $this->getPropertyPages($ids);
      elseif($idType == 'pages')
        // USES the PRIORITY: 1. -> page var 2. -> PROPERTY page var 3. -> FALSE
        $ids = $this->getPropertyPage($ids);
      elseif($idType == 'category')
        // USES the PRIORITY: 1. -> category var 2. -> PROPERTY category var 3. -> FALSE
        $ids = $this->getPropertyCategory($ids);
      elseif($idType == 'categories')
        // USES the PRIORITY: 1. -> categories var 2. -> PROPERTY categories var 3. -> FALSE
        $ids = $this->getPropertyCategories($ids);
    }
    $return = false;    
        
    // LOADS the PAGES BY TYPE
    $pages = $this->loadPagesByType($idType,$ids);
    
    
    // -> if pages SORTED BY CATEGORY
    if($sortingConsiderCategories === true)
      $pages = $this->generalFunctions->sortPages($pages);
    
    if($pages !== false) {
      // -> list a category(ies)
      // ------------------------------  
      foreach($pages as $page) {
        // show the pages
        if($pageContent = $this->generatePage($page,false,false,$shortenText,$useHtml)) {
          $return[] = $pageContent;
        }
      }
    } else return false;
    return $return;
  }
  // -> END -- listPages ---------------------------------------------------------------------------------  
  // -> *ALIAS* OF listPages *****************************************************************************
  function listPage($idType, $id = true, $shortenText = true, $useHtml = true, $sortingConsiderCategories = false) {
    // call the right function
    return $this->listPages($idType, $id, $shortenText, $useHtml, $sortingConsiderCategories);
  }
  // -> END -- listPage ----------------------------------------------------------------------------------  
  
  // -> START -- listPagesByTags *************************************************************************
  // SHOWs PAGEs, sorted by the categories or by the given array, but only if the page has one of the given TAGS
  // RETURNs an Array of the UNCHANGED pageContent Arrays
  // * MORE OPTIONs in the PROPERTIES (TITLE and CONTENT layout)
  // -----------------------------------------------------------------------------------------------------
  function listPagesByTags($tags,                                 // (String or Array) the tags to select the pages with
                                  $idType,                               // (String ["page", "pages" or "category", "categories"]) uses the given IDs for looking in the pages or categories
                                  $ids = true,                           // (false or Number or Array) the pages ID(s) or category ID(s) for the menu, if FALSE it use VAR PRIORITY, if TRUE and $idType = "category", it loads all categories
                                  $shortenText = true,                   // (false or Number) the Number of characters to shorten the content text
                                  $useHtml = true,                       // (Boolean) use html in the content text
                                  $sortingConsiderCategories = false) {  // (Boolean) if TRUE it sorts the pages by categories and the sorting like in the backend
     
    $idType = strtolower($idType);
    // USES the PRIORITY: 1. -> page var 2. -> PROPERTY page var 3. -> FALSE
    if($ids === false) {
      if($idType == 'page')
        // USES the PRIORITY: 1. -> pages var 2. -> PROPERTY pages var 3. -> FALSE
        $ids = $this->getPropertyPages($ids);
      elseif($idType == 'pages')
        // USES the PRIORITY: 1. -> page var 2. -> PROPERTY page var 3. -> FALSE
        $ids = $this->getPropertyPage($ids);
      elseif($idType == 'category')
        // USES the PRIORITY: 1. -> category var 2. -> PROPERTY category var 3. -> FALSE
        $ids = $this->getPropertyCategory($ids);
      elseif($idType == 'categories')
        // USES the PRIORITY: 1. -> categories var 2. -> PROPERTY categories var 3. -> FALSE
        $ids = $this->getPropertyCategories($ids);
    }
    
    // check for the tags and LIST PAGES
    if($ids = $this->hasTags($ids,$idType,$tags)) {
      
      return $this->listPages($idType,$ids,$shortenText,$useHtml,$sortingConsiderCategories);
    } else return false;
  }  
  // -> *ALIAS* OF listPagesByTags ***********************************************************************
  function listPagesByTag($tags, $idType, $ids = true, $shortenText = true, $useHtml = true, $sortByCategory = false) {
    // call the right function
    return $this->listPagesByTags($tags, $idType, $ids, $shortenText, $useHtml, $sortByCategory);
  }
  // -> *ALIAS* OF listPagesByTags ***********************************************************************
  function listPageByTags($tags, $idType, $ids = true, $shortenText = true, $useHtml = true, $sortByCategory = false) {
    // call the right function
    return $this->listPagesByTags($tags, $idType, $ids, $shortenText, $useHtml, $sortByCategory);
  }
  // -> *ALIAS* OF listPagesByTags ***********************************************************************
  function listPageByTag($tags, $idType, $ids = true, $shortenText = true, $useHtml = true, $sortByCategory = false) {
    // call the right function
    return $this->listPagesByTags($tags, $idType, $ids, $shortenText, $useHtml, $sortByCategory);
  }  
  
  // -> START -- listPagesByDate **************************************************************************
  // SHOWs PAGEs, if they have a sortDate set and sortdate is activated in the category, AND its between the given month Number from now and in the past
  // RETURNs an Array of the UNCHANGED pageContent Arrays
  // * MORE OPTIONs in the PROPERTIES (TITLE and CONTENT layout)
  // ------------------------------------------------------------------------------------------------------
  function listPagesByDate($idType,                               // (String ["page", "pages" or "category", "categories"]) uses the given IDs for looking in the pages or categories
                                  $ids = true,                           // (false or Number or Array) the pages ID(s) or category ID(s) for the menu, if FALSE it use VAR PRIORITY, if TRUE and $idType = "category", it loads all categories
                                  $monthsInThePast = true,               // (Boolean or Number) number of month BEFORE today, if TRUE it shows ALL PAGES FROM the PAST, if FALSE it shows ONLY pages FROM TODAY
                                  $monthsInTheFuture = true,             // (Boolean or Number) number of month AFTER today, if TRUE it shows ALL PAGES IN the FUTURE, if FALSE it shows ONLY pages UNTIL TODAY
                                  $shortenText = true,                   // (Boolean or Number) the Number of characters to shorten the content text
                                  $useHtml = true,                       // (Boolean) use html in the content text
                                  $sortingConsiderCategories = false,    // (Boolean) if TRUE it sorts the pages by categories and the sorting like in the feindura cms
                                  $flipList = false) {                   // (Boolean) if TRUE it flips the array with the listet pages
                                    
      return $this->listByDate('pages',$idType,$ids,$monthsInThePast,$monthsInTheFuture,$shortenText,$useHtml,$sortingConsiderCategories,$flipList);
  }
  // -> *ALIAS* OF listPagesByDate ***********************************************************************
  function listPageByDate($idType, $ids = true, $monthsInThePast = true, $monthsInTheFuture = true, $shortenText = true, $useHtml = true,$sortingConsiderCategories = false, $flipList = false) {
    // call the right function
    return $this->listPagesByDate($idType, $ids, $monthsInThePast, $monthsInTheFuture, $shortenText, $useHtml,$sortingConsiderCategories, $flipList);
  }
  // -> *ALIAS* OF listPagesByDate ***********************************************************************
  function listPageByDates($idType, $ids = true, $monthsInThePast = true, $monthsInTheFuture = true, $flipList = false, $shortenText = true, $useHtml = true,$sortingConsiderCategories = false, $flipList = false) {
    // call the right function
    return $this->listPagesByDate($idType, $ids, $monthsInThePast, $monthsInTheFuture, $shortenText, $useHtml,$sortingConsiderCategories, $flipList);
  }  
  // -> *ALIAS* OF listPagesByDate ***********************************************************************
  function listPagesByDates($idType, $ids = true, $monthsInThePast = true, $monthsInTheFuture = true, $flipList = false, $shortenText = true, $useHtml = true,$sortingConsiderCategories = false, $flipList = false) {
    // call the right function
    return $this->listPagesByDate($idType, $ids, $monthsInThePast, $monthsInTheFuture, $shortenText, $useHtml,$sortingConsiderCategories, $flipList);
  }  
  
  // -> START -- getCurrentPage **************************************************************************
  // RETURNs the current GET page var
  // -----------------------------------------------------------------------------------------------------
  function getCurrentPage() {
    global $_GET;
    
    // ->> GET PAGE is an ID
    // *********************
    if(isset($_GET[$this->varNames['page']]) &&
       is_numeric($_GET[$this->varNames['page']])) {
       
      // set PAGE GET var
      if(!empty($_GET[$this->varNames['page']]))
        return $_GET[$this->varNames['page']]; // get the category ID from the $_GET var
    
    // ->> GET PAGE is a NAME
    // **********************
    } elseif(isset($_GET['page']) &&
             !empty($_GET['page'])) {
    
      // load the pages of the category
      $pages = $this->loadPages($this->category);
      //print_r($this->storedPages);
      if($pages) {
        foreach($pages as $page) {
          $transformedCategory = htmlentities($_GET['page'],ENT_QUOTES,'UTF-8');
          
          // RETURNs the right page Id
          if($this->generalFunctions->encodeToUrl($page['title']) == $transformedCategory) {
            return $page['id'];
          }
        }
      }  
    }
    return false;
  }
  // -> *ALIAS* OF getCurrentPage ***********************************************************************
  function getPage() {
    // call the right function
    return $this->getCurrentPage();
  }

  // -> START -- getCurrentCategory **********************************************************************
  // RETURNs the current GET category var
  // -----------------------------------------------------------------------------------------------------
  function getCurrentCategory() {
    global $_GET;
    
    // ->> GET CATEGORY is an ID
    // *************************
    if(isset($_GET[$this->varNames['category']]) &&
       is_numeric($_GET[$this->varNames['category']])) {
       
      // set CATEGORY GET var
      if(!empty($_GET[$this->varNames['category']]))
        return $_GET[$this->varNames['category']]; // get the category ID from the $_GET var
    
    // ->> GET CATEGORY is a NAME
    // **************************
    } elseif(isset($_GET['category']) &&
             !empty($_GET['category'])) {
      
      foreach($this->categoryConfig as $category) {
        $transformedCategory = htmlentities($_GET['category'],ENT_QUOTES,'UTF-8');
      
        // RETURNs the right category Id
        if($this->generalFunctions->encodeToUrl($category['name']) == $transformedCategory) {
          return $category['id'];
        }
      }      
    }
    return false;
  }
  // -> *ALIAS* OF getCurrentCategory ***********************************************************************
  function getCategory() {
    // call the right function
    return $this->getCurrentCategory();
  }
  
  // -> START -- setCurrentPage **************************************************************************
  // saves the the current GET page var in the page PROPERTY
  // and RETURNs the new page PROPERTY
  // -----------------------------------------------------------------------------------------------------
  function setCurrentPage($setStartPage = false) {  // (Boolean) if TRUE it sets the startPage
    
    // sets the new page PROPERTY
    $this->page = $this->getCurrentPage();
    
    // sets the startPage if it exists
    if($setStartPage === true && $this->adminConfig['setStartPage'] && $this->page === false && !empty($this->websiteConfig['startPage']))
      $this->page = $this->websiteConfig['startPage'];
      
    return $this->page;
  }
  // -> *ALIAS* OF setCurrentPage ***********************************************************************
  function setPage($setStartPage = false) {
    // call the right function
    return $this->setCurrentPage($setStartPage);
  }
  
  // -> START -- setCurrentCategory **********************************************************************
  // saves the the current GET category var in the category PROPERTY
  // and RETURNs the new category PROPERTY
  // -----------------------------------------------------------------------------------------------------
  function setCurrentCategory() {
    // sets the new category PROPERTY
    $this->category = $this->getCurrentCategory();
    return $this->category;
  }
  // -> *ALIAS* OF setCurrentCategory ***********************************************************************
  function setCategory() {
    // call the right function
    return $this->setCurrentCategory();
  }
  
  
  // ****************************************************************************************************************
  // PROTECTED METHODs ----------------------------------------------------------------------------------------------
  // ****************************************************************************************************************
  
  
  // -> START -- generatePage ****************************************************************************
  // generates a Page with, title, thumbnail and content -> SHOW the page and RETURNS the UNCHANGED pageContent Array of the page
  // -----------------------------------------------------------------------------------------------------
  function generatePage($page = false,              // (Number or pageContent Array) the page (id) to show or the pageContent array
                                  $category = false,          // (Number) the category where the page is situated 
                                  $showErrors = true,         // (Boolean) show warnings (example: 'The page you requested doesn't exist')
                                  $shortenText = false,       // (Boolean or Number)shorten the content Text
                                  $useHtml = true) {          // (Boolean) use Html in the content, or strip all tags

    // set TAG ENDING (xHTML or HTML) 
    if($this->xHtml === true) $tagEnding = ' />';
    else $tagEnding = '>';

    // ->> CHECKS
    // -------------------
    
    // LOOKS FOR A GIVEN PAGE, IF NOT STOP THE METHOD
    if(!$page)
      return false;
    
    // -> sets the MESSAGE SETTINGS
    // ----------------------------
    if($showErrors && $this->error) {
      // adds ID and/or Class    
      $errorAttributes = '';
      $errorStartTag = '';
      $errorEndTag = '';
            
      // message ID
      if($this->errorId && $this->errorId !== true)
        $errorAttributes .= ' id="'.$this->errorId.'"';
      // message CLASS
      if($this->errorClass && $this->errorClass !== true)
        $errorAttributes .= ' class="'.$this->errorClass.'"';
      
      if(($this->errorTag && $this->errorTag !== true) || !empty($errorAttributes)) {
        // creates standard tag
        $errorTag = 'span';
        // eventually overwrites standard tag
        if($this->errorTag && $this->errorTag !== true)
          $errorTag = $this->errorTag;  
                  
        $errorStartTag = '<'.$errorTag.$errorAttributes.'>';
        $errorEndTag = '</'.$errorTag.'>';
      }
    }
    
    // -> LOAD the pageContent ARRAY
    if(is_array($page) && array_key_exists('id',$page)) {
      $pageContent = $page;
    } else {
      // if not throw ERROR
      if(!$pageContent = $this->readPage($page,$category)) {
        if($showErrors && $this->error) {      
          echo $errorStartTag.$this->languageFile['error_noPage'].$errorEndTag; // if not throw error and and the method
        }
        return false;
      }
    }

    
    // -> PAGE is PUBLIC? if not throw ERROR
    if(!$pageContent['public'] || $this->publicCategory($pageContent['category']) === false) {
      if($showErrors && $this->error) {
        echo $errorStartTag.$this->languageFile['error_pageClosed'].$errorEndTag; // if not throw error and and the method
      }
      return false;
    }
    
    // ->> BEGINNING TO BUILD THE PAGE
    // -------------------
    
    // -> PAGE TITLE
    // *****************
    
    // title with category name
    if($this->titleShowCategory && $pageContent['category']) {
      if(is_string($this->titleCategorySpacer))
        $titleShowCategory = $this->titleCategorySpacer;
      else
        $titleShowCategory = true;
    } else $titleShowCategory = false;
    
    // shows the TITLE
    if($this->title)
      $title = $this->createTitle($pageContent,
                                  $this->titleTag,
                                  $this->titleId,
                                  $this->titleClass,
                                  $this->titleLength,
                                  $this->titleAsLink,
                                  $titleShowCategory,
                                  $this->titleShowDate,
                                  $this->titleStartText);      
    else $title = '';
      
    // -> PAGE THUMBNAIL
    // *****************
    if($this->contentThumbnail &&      
      !empty($pageContent['thumbnail']) &&
      @is_file(DOCUMENTROOT.$this->adminConfig['uploadPath'].$this->adminConfig['pageThumbnail']['path'].$pageContent['thumbnail']) &&
      ((!$pageContent['category'] && $this->adminConfig['page']['thumbnailUpload']) ||
      ($pageContent['category'] && $this->categoryConfig['id_'.$pageContent['category']]['thumbnail']))) {
      
      // adds ID and/or Class and/or FLOAT
      $thumbnailAttributes = '';
      // thumbnail ID
      if($this->thumbnailId && $this->thumbnailId !== true)
        $thumbnailAttributes .= ' id="'.$this->thumbnailId.'"';
      // thumbnail CLASS
      if($this->thumbnailClass && $this->thumbnailClass !== true)
        $thumbnailAttributes .= ' class="'.$this->thumbnailClass.'"';
      // thumbnail FLOAT
      if(strtolower($this->thumbnailFloat) === 'left' ||
         strtolower($this->thumbnailFloat) === 'right')
        $thumbnailAttributes .= ' style="float:'.strtolower($this->thumbnailFloat).';"';
      
      $pageThumbnail = '<img src="'.$this->adminConfig['uploadPath'].$this->adminConfig['pageThumbnail']['path'].$pageContent['thumbnail'].'" alt="'.$pageContent['title'].'" title="'.$pageContent['title'].'"'.$thumbnailAttributes.$tagEnding."\n";
    } else $pageThumbnail = '';
    
    // ->> MODIFING pageContent
    // ************************
    if($this->content) {
      $pageContentEdited = $pageContent['content'];
      
      // -> adds ID and/or Class
      // -----------------------
      $contentAttributes = '';
      $contentStartTag = '';
      $contentEndTag = '';     
      // content ID
      if($this->contentId && $this->contentId !== true)
        $contentAttributes .= ' id="'.$this->contentId.'"';
      // content CLASS
      if($this->contentClass && $this->contentClass !== true)
        $contentAttributes .= ' class="'.$this->contentClass.'"';
        
      if(($this->contentTag && $this->contentTag !== true) || !empty($contentAttributes)) {
        // creates standard tag
        $contentTag = 'div';
        // eventually overwrites standard tag
        if($this->contentTag && $this->contentTag !== true)
          $contentTag = $this->contentTag;  
                  
        $contentStartTag = '<'.$contentTag.$contentAttributes.'>';
        $contentEndTag = '</'.$contentTag.'>';        
      } 
      
      // clear Html tags?
      if(!$useHtml)
        $pageContentEdited = strip_tags($pageContentEdited);
      
      // -> SHORTEN CONTENT   
      if($shortenText) {
        // -> SET the PROPERTY $contentLength
        if($shortenText === true)
          $shortenText = $this->contentLength; // standard preview length
  
        if($useHtml)
          $pageContentEdited = $this->shortenHtmlText($pageContentEdited, $shortenText, $pageContent, " ...");
        else {
          // clear string of html tags (except BR)
          $pageContentEdited = strip_tags($pageContentEdited, '<br>,<br />');
          $pageContentEdited = $this->shortenText($pageContentEdited, $shortenText, $pageContent, " ...");
        }
      }
      
      // clear xHTML tags from the content
      if($this->xHtml === false)
        $pageContentEdited = str_replace(' />','>',$pageContentEdited);
    
    // -> show no content
    } else {
      $contentStartTag = '';
      $contentEndTag = '';
      $pageContentEdited = '';
    }
    
    // CHECK if the TITLE BEFORE & AFTER is !== true
    $titleBefore = false;
    $titleAfter = false;
    
    if(!empty($title)) {
      if($this->titleBefore !== true)
        $titleBefore = $this->titleBefore;
      if($this->titleAfter !== true)
        $titleAfter = $this->titleAfter;
    }
    
    // CHECK if the THUMBNAIL BEFORE & AFTER is !== true
    $thumbnailBefore = false;
    $thumbnailAfter = false;
    
    if(!empty($pageThumbnail)) {
      if($this->thumbnailBefore !== true)
        $thumbnailBefore = $this->thumbnailBefore;
      if($this->thumbnailAfter !== true)
        $thumbnailAfter = $this->thumbnailAfter;
    }
      
    // CHECK if the CONTENT BEFORE & AFTER is !== true
    $contentBefore = false;
    $contentAfter = false;
    
    if($this->contentBefore !== true)
      $contentBefore = $this->contentBefore;
    if($this->contentAfter !== true)
      $contentAfter = $this->contentAfter;
    
    // -> BUILDING the PAGE
    // *******************
    echo $titleBefore.$title.$titleAfter."\n";
    echo $thumbnailBefore.$pageThumbnail.$thumbnailAfter;
    echo $contentBefore.$contentStartTag.$pageContentEdited.$contentEndTag.$contentAfter."\n";
    
    // -> AFTER all RETURN $pageContentEdited
    // ***************** 
    return $pageContent;
  }
  // -> END -- generatePage --------------------------------------------------------------------------------  
  
  
  // -> START -- createTitle ******************************************************************************
  // creates a title, with the given parameters
  // ------------------------------------------------------------------------------------------------------
  function createTitle($pageContent,                 // the pageContent Array of the Page (String)
                                 $titleTag = false,            // the TAG which is used by the title (String)
                                 $titleId = false,             // the ID which is used by the title tag (String)
                                 $titleClass = false,          // the CLASS which is used by the title tag (String)
                                 $titleLength = false,         // if Number, it shortens the title characters to this Length (Boolean or Number)
                                 $titleAsLink = false,         // if true, it set the title as a link (Boolean)
                                 $titleShowCategory = false,   // if true, it shows the category name after the title, and uses the given spacer string (Boolean or String)
                                 $titleShowDate = false,       // (Boolean) if TRUE, it shows the pageContent['sortdate'] var before the title (Boolean or String)
                                 $titleStartText = false) {    // if String, it appears before the title text

      // saves the long version of the title, for the title="" tag
      $fullTitle = strip_tags($pageContent['title']);
           
      // title with date
      if($titleShowDate && $pageContent['category'] &&
         isset($this->categoryConfig['id_'.$pageContent['category']]) &&
         $this->categoryConfig['id_'.$pageContent['category']]['sortdate'] &&
         !empty($pageContent['sortdate']) &&
         $sortedDate = $this->statisticFunctions->validateDateFormat($pageContent['sortdate']['date']))
         $titleDate = $pageContent['sortdate']['before'].' '.$this->statisticFunctions->formatDate($this->generalFunctions->dateDayBeforeAfter($sortedDate,$this->languageFile)).' '.$pageContent['sortdate']['after'];
      else $titleDate = false;      
      
      // shorten the title
      if(is_numeric($titleLength) && strlen($fullTitle) > $titleLength)
        $title = substr($fullTitle, 0, $titleLength)."..";
      else
        $title = $fullTitle;
        
        
       // show the page date in the title="" tag
      if($titleDate)
        $fullTitle = $titleDate.' '.$fullTitle;     
        
      // create a link for the title
      if($titleAsLink && $this->varNames !== false && is_array($this->varNames)) {        
        $titleBefore = '<a href="'.$this->createHref($pageContent).'" title="'.$fullTitle.'">';
        $titleAfter = '</a>';
      } else {
        $titleBefore = '<span title="'.$fullTitle.'">';
        $titleAfter = '</span>';
      }
      
      // show the a text before the title text
      if($titleStartText && $titleStartText !== true)
        $titleBefore .= $titleStartText.' ';
            
      // show the category name
      if($titleShowCategory && $pageContent['category'] != 0) {
        if(is_bool($titleShowCategory))
          $titleBefore .= $this->categoryConfig['id_'.$pageContent['category']]['name'];
        else
          $titleBefore .= $this->categoryConfig['id_'.$pageContent['category']]['name'].$titleShowCategory; // adds the Spacer
      }
      
      // show the page date     
      if($titleDate)
        $titleBefore .= $titleDate.' ';      
        
      // -------------------------------
      // adds ID and/or Class
      $titleTagAttributes = '';
      $titleStartTag = '';
      $titleEndTag = '';
      // add TITLE ID
      if($titleId && $titleId !== true)
        $titleTagAttributes .= ' id="'.$titleId.'"';
      // add TITLE CLASS
      if($titleClass && $titleClass !== true)
        $titleTagAttributes .= ' class="'.$titleClass.'"';        
        
      if($titleTag || !empty($titleTagAttributes)) {
        // set tag
        if($titleTag && $titleTag !== true)
          $titleTag = $titleTag;
        else // or uses standard tag          
          $titleTag = 'span';
                  
        $titleStartTag = '<'.$titleTag.$titleTagAttributes.'>';
        $titleEndTag = '</'.$titleTag.'>';
      }
      
      // -> builds the title
      // *******************  
      $title = $titleStartTag.$titleBefore.$title.$titleAfter.$titleEndTag;
      
      // returns the title
      return $title;
  }
  // -> END -- createTitle ---------------------------------------------------------------------------------
  
  // -> START -- createHref ******************************************************************************
  // generates out of the a pageContent Array a href="" link for this page
  // RETURNs a String for the HREF attribute
  // -----------------------------------------------------------------------------------------------------
  function createHref($pageContent) {   // (false or Number) the category (id) of the page to load, if FALSE it loads the pages of the non-category
    
    return $this->generalFunctions->createHref($pageContent,$this->sessionId);
    
  }
  // -> END -- createHref -----------------------------------------------------------------------------------
  
  // -> START -- readPage ********************************************************************************
  // OVERWRITES the readPage() function of the general.functions.php
  // loads only pages if they are not already in the storedPages PROPERTY Array
  // RETURNs the pageContent Array or FALSE
  // -----------------------------------------------------------------------------------------------------
  function readPage($page,                 // (Number) the page (id) of the page to load
                              $category = false) {   // (false or Number) the category (id) of the page to load, if FALSE it loads the pages of the non-category
    //echo 'PAGE: '.$page.' -> '.$category.'<br />';
   
    $storedPages = $this->getStoredPages();
   
    // -> checks if the page is already loaded
    if(isset($storedPages[$page])) {
      //echo '<br />->USED STORED '.$page.'<br />';        
      return $storedPages[$page];
      
    // -> if not load the page and store it in the storePages PROPERTY
    } else {
      if(($page = $this->generalFunctions->readPage($page,$category)) !== false) {        
        //echo '<br />->>> LOAD '.$page['id'].'<br />';
        
        // add the pageContent Array to the PROPERTY and SESSION
        return $this->setStoredPages($page);
      } else return false;
    }
  }
  // -> END -- readPage -----------------------------------------------------------------------------------
  
  // -> START -- loadPages *******************************************************************************
  // OVERWRITES the loadPages() function of the general.functions.php
  // loads only pages if they are not already in the storedPages PROPERTY Array
  // RETURNs the pageContent Arrays or FALSE
  // -----------------------------------------------------------------------------------------------------
  function loadPages($category = false,           // (Boolean, Number or Array with IDs or the $this->categoryConfig Array) the category or categories, which to load in an array, if TRUE it loads all categories
                     $loadPagesInArray = true) {  // (Boolean) if true it loads the pageContentArray in an array, otherwise it stores only the categroy ID and the page ID

    // -> checks if the RETURN should be an Array
    if($loadPagesInArray === true) {
      
      //vars
      $pagesArray = array();      
      
      // set false category to 0
      if($category === false)
        $category = '0';
      
      // change category into array
      if(is_numeric($category))
        $category = array($category);
        
      // go trough all given CATEGORIES       
      foreach($category as $categoryId) {
        
        // go trough the storedPageIds and open the page in it
        $newPageContentArrays = array();
        foreach($this->getStoredPageIds() as $pageIdAndCategory) {
          // use only pages from the right category
          if($pageIdAndCategory[1] == $categoryId) {
            //echo 'PAGE: '.$pageIdAndCategory[0].' -> '.$categoryId.'<br />';
            $newPageContentArrays[] = $this->readPage($pageIdAndCategory[0],$pageIdAndCategory[1]);            
          }
        }
              
        // sorts the category
        if(is_array($newPageContentArrays)) { // && !empty($categoryId) <- prevents sorting of the non-category
          if($categoryId !== 0 && $this->categoryConfig['id_'.$categoryId]['sortbydate'])
            $newPageContentArrays = $this->generalFunctions->sortPages($newPageContentArrays, 'sortByDate');
          else
            $newPageContentArrays = $this->generalFunctions->sortPages($newPageContentArrays, 'sortBySortOrder');
        }
      
        // adds the new sorted category to the return array
        $pagesArray = array_merge($pagesArray,$newPageContentArrays);
      }

      return $pagesArray;
    // -> otherwise just use the loadPages function
    } else
      return $this->generalFunctions->loadPages($category,$loadPagesInArray);
  }
  // -> END -- loadPages ---------------------------------------------------------------------------------- 
  
  // -> START -- loadPagesByType **************************************************************************
  // loads the Pages by the given IDs and the given idType
  // RETURNs an Array of pageContent Array(s)
  // ------------------------------------------------------------------------------------------------------
  function loadPagesByType($idType,                    // (String ["page", "pages" or "category", "categories"]) uses the given IDs for looking in the pages or categories
                                     $ids = true) {              // (false or Number or Array or Array with pageContent Arrays) the pages ID(s) or category ID(s) to be loaded, if TRUE and $idType = "category", it loads all categories, -> can also be a Array with pageContent Arrays
    
    // vars
    $return = false;
    
    // -> category ID(s)
    // ***************
    if($idType == 'category' || $idType == 'categories') {
      if($ids === true || is_array($ids) || is_numeric($ids)) {
        
        // if its not a pageContent Array -> return this
        if(isset($ids[0]) && is_array($ids[0]) && array_key_exists('id',$ids[0])) {
          return $ids;
        
        // otherwise load the pages from the category(ies)
        } else {
          // checks if the categories are public
          $ids = $this->publicCategory($ids);
          
          if($ids !== false) {
 
            // loads the pageContent of the pages of the category in an Array
            // the pages in the returned array also get SORTED
            $pages = $this->loadPages($ids);

            // returns the loaded pages from the CATEGORY IDs
            return $pages;
          } else return false;
        }
      } else return false;
      
    // ->> if PAGE ID(s)
    // **************************
    } elseif($idType == 'page' || $idType == 'pages') {
      
      // -----------------------------------------    
      // ->> pages IDs
      // ***************
      if($ids && is_array($ids)) {
        
        // checks if its an Array with pageContent Arrays
        if(is_array($ids[0]) && array_key_exists('id',$ids[0])) {
          return $ids;          
        //otherwise load the pages from the categories
        } else {
        
          // loads all pages in an array
          $pages = array();
          foreach($ids as $page) {
            if($pageContent = $this->readPage($page,$this->getPageCategory($page))) {
              $return[] = $pageContent;
            }
          }
        }        
      // -----------------------------------------     
      // ->> single page ID
      // *************** 
      } elseif($ids && is_numeric($ids)) {
         
        // loads the single page in an array 
        if($pageContent = $this->readPage($ids,$this->getPageCategory($ids))) {
          $return[] = $pageContent;
        } else return false;
      } else return false;
    }
    // -> returns an array with the pageContent Arrays
    return $return;
  }
  // -> END -- loadPagesByType ---------------------------------------------------------------------
  
  
  // -> START -- publicCategory ********************************************************************
  // checks if the category ID(s) are public, returns false or a array with the IDs of the public categories
  // ------------------------------------------------------------------------------------------------
  function publicCategory($ids) {     // (true or Number or Array) the category ID or a array with the category IDs, if TRUE it returns all categories
    
    // -> check an Array of category IDs
    if($ids === true || is_array($ids)) {
      $newIds = false;
      
      // goes trough ALL categories
      if($ids === true) {
        // adds the non-category
        $newIds[] = 0;
        
        foreach($this->categoryConfig as $category) {
          // checks if the category is public and creates a new array
          if($category['public'])
            $newIds[] = $category['id'];
        }
      // goes only trough the given ones
      } else {
        // goes trough the given category IDs array
        foreach($ids as $id) {
          // checks if the category is public and creates a new array
          if($id == 0 || (array_key_exists('id_'.$id,$this->categoryConfig) && $this->categoryConfig['id_'.$id]['public']))    
            $newIds[] = $id;
        }
      }
      // and return the new category IDs array
      return $newIds;
      
    // -> check a single category ID
    } elseif($ids !== true && is_numeric($ids)) {

      // checks if the category is public
      if($ids == 0 || $this->categoryConfig['id_'.$ids]['public'])    
        return $ids;
      else return false;
    
    } else return false;
  }
  // -> END -- publicCategory ------------------------------------------------------------------------
  
  // -> START -- getPageCategory *********************************************************************
  // gets the category ID of a given page ID
  // -------------------------------------------------------------------------------------------------
  function getPageCategory($page) {   // (Number) the page ID, from which to get the category ID
  
    // execute the genral function
    $return = $this->generalFunctions->getPageCategory($page,$this->getStoredPageIds(),true);
    
    $this->storedPageIds = $return[1];
    return $return[0];
  }
  // -> END -- getPageCategory ------------------------------------------------------------------------
  
  // -> START -- prevNextPage *************************************************************************
  // gets the PREVOIUS or NEXT page from the given page ID
  // RETURNs the pageContent Array of the PREVOIUS or NEXT Page
  // --------------------------------------------------------------------------------------------------
  function prevNextPage($direction,               // (String ["prev" or "next"]) direction of the page to go
                                  $page,                    // (Number) the page ID
                                  $category = false) {      // (false or Number) the category ID    
    
    if($category === false)
      $category = $this->getPageCategory($page);
    
    $categoryOfPage = $this->loadPages($category);
    
    if($categoryOfPage !== false) {
      $count = 0;
      foreach($categoryOfPage as $categoryPage) {         
  
        if($categoryPage['id'] == $page) {
          
          // PREV
          if($direction == 'prev' && (($count + 1) < count($categoryOfPage)))
            return $categoryOfPage[($count + 1)];
          // NEXT
          elseif($direction == 'next' && (($count - 1) >= 0))
            return $categoryOfPage[($count - 1)];
          else return false;
        }  
            
        $count++;
      }
    } else return false;
  }  
  // -> END -- prevNextPage ---------------------------------------------------------------------
  
  // -> START -- compareTags **************************************************************************
  // goes trough all TAGs and compares them with the TAGs in the pageContent Array
  // returns the pageContent Array which have the tags in it, otherwise FALSE
  // --------------------------------------------------------------------------------------------------
  function compareTags($pageContent,  // (Array) the pageContent Array, needs the $pageContent['tags'] var
                                 $tags) {       // (Array) with the search TAGs
    
    // CHECKS if the $tags are in an array,
    // and the pageContent['tags'] var exists and is not empty
    if(is_array($tags) && isset($pageContent['tags']) && !empty($pageContent['tags'])) {
    
      // goes trough the given TAG Array, and look of one tga is in the pageContent['tags'} var
      foreach($tags as $tag) {
        if(strstr(' '.$pageContent['tags'].' ',' '.$tag.' ')) {
          return $pageContent;
        }            
      }
    }
    return false;
  }
  // -> END -- compareTags -----------------------------------------------------------------------------
  
  // -> START -- hasTags ******************************************************************************
  // looks if the given page ID(s) or category ID(s) have the given TAGs
  // returns an Array with pageContent Array(s) which have the tags in it
  // --------------------------------------------------------------------------------------------------
  function hasTags($ids,          // (Number or Array) with the page ID(s) or category ID(s), where to look for the tags, if TRUE and $idType = "category", it loads all categories
                             $idType,       // (String ["page", "pages" or "category", "categories"]) uses the given IDs for looking in the pages or categories
                             $tags) {       // (String or Array) with the search TAGs
    // makes sure that the tags are an array
    // and have not multiple spaces or spaces in an array
    if(is_array($tags)) {
      foreach($tags as $tag) {
        $newTags[] = preg_replace("/ +/", '', $tag); // clear spaces in array
      }
      $tags = $newTags;
    } else {
      $tags = preg_replace("/ +/", ' ', $tags); // clear multiple spaces
      $tags = explode(" ", $tags);
    }
    $return = false;
    
    // get the pages and compare them if they have the tags
    if(($pages = $this->loadPagesByType($idType,$ids)) !== false) {
      // goes trough every page and compares the tags
      foreach($pages as $page) {
        if($page['public'] && $this->compareTags($page, $tags)) {
          $return[] = $page;
        }
      }
    }   
    // RETURNs only the page who have the tags
    return $return;
  }
  // -> END -- hasTags --------------------------------------------------------------------------------
  
  // -> START -- listByDate *******************************************************************************
  // SHOWs PAGEs, if they have a sortDate set and sortdate is activated in the category, AND its between the given month Number from now and in the past
  // RETURNs an Array of the UNCHANGED pageContent Arrays
  // ------------------------------------------------------------------------------------------------------
  function listByDate($type,                                 // (String ["menu" or "pages"]) set the type of the listByDate
                                $idType,                               // (String ["page", "pages" or "category", "categories"]) uses the given IDs for looking in the pages or categories
                                $ids = true,                           // (false or Number or Array) the pages ID(s) or category ID(s) for the menu, if FALSE it use VAR PRIORITY, if TRUE and $idType = "category", it loads all categories
                                $monthsInThePast = true,               // (Boolean or Number) number of month BEFORE today, if TRUE it shows ALL PAGES FROM the PAST, if FALSE it shows ONLY pages FROM TODAY
                                $monthsInTheFuture = true,             // (Boolean or Number) number of month AFTER today, if TRUE it shows ALL PAGES IN the FUTURE, if FALSE it shows ONLY pages UNTIL TODAY                                
                                $shortenTextORlinkText = false,        // (Boolean or Number or String)  the Number of characters to shorten the content text OR the TEXT used for the links, if TRUE it USES the TITLE of the pages
                                $useHtmlORmenuTag = true,              // (Boolean or String) use html in the content text OR the TAG used for the Menu, if TRUE it uses the menuTag from the PROPERTY
                                $sortingConsiderCategories = false,    // (Boolean) if TRUE it sorts the pages by categories and the sorting like in the feindura cms
                                $breakAfter = false,                   // (Boolean or Number) if TRUE it makes a br behind each <a..></a> element, if its a NUMBER AND the menuTag IS "table" it breaks the rows after the given Number 
                                $flipList = false) {                   // (Boolean) if TRUE it flips the array with the listet pages

    if(!is_bool($monthsInThePast) && is_numeric($monthsInThePast))
      $monthsInThePast = round($monthsInThePast);
    if(!is_bool($monthsInTheFuture) && is_numeric($monthsInTheFuture))
      $monthsInTheFuture = round($monthsInTheFuture);
    
    $idType = strtolower($idType);
    // USES the PRIORITY: 1. -> page var 2. -> PROPERTY page var 3. -> FALSE
    if($ids === false) {
      if($idType == 'page')
        // USES the PRIORITY: 1. -> pages var 2. -> PROPERTY pages var 3. -> FALSE
        $ids = $this->getPropertyPages($ids);
      elseif($idType == 'pages')
        // USES the PRIORITY: 1. -> page var 2. -> PROPERTY page var 3. -> FALSE
        $ids = $this->getPropertyPage($ids);
      elseif($idType == 'category')
        // USES the PRIORITY: 1. -> category var 2. -> PROPERTY category var 3. -> FALSE
        $ids = $this->getPropertyCategory($ids);
      elseif($idType == 'categories')
        // USES the PRIORITY: 1. -> categories var 2. -> PROPERTY categories var 3. -> FALSE
        $ids = $this->getPropertyCategories($ids);
    }
    //$return = false;
    
    // LOADS the PAGES BY TYPE
    $pages = $this->loadPagesByType($idType,$ids);
      
    if($pages !== false) {
      
      // creates the current date to compare with
      $currentDate = date('Y').date('m').date('d');       
      
      $pastDate = false;
      $futureDate = false;
       
      // creates the PAST DATE
      if(!is_bool($monthsInThePast) && is_numeric($monthsInThePast))
        $pastDate = $this->changeMonth($currentDate,$monthsInThePast,false);
      elseif($monthsInThePast === false)
        $pastDate = $currentDate;
                      
      // creates the FUTURE DATE
      if(!is_bool($monthsInTheFuture) && is_numeric($monthsInTheFuture))
        $futureDate = $this->changeMonth($currentDate,$monthsInTheFuture,true);
      elseif($monthsInTheFuture === false)
        $futureDate = $currentDate;
      
      //echo 'currentDate: '.$currentDate.'<br />';
      //echo 'pastDate: '.$pastDate.'<br />';
      //echo 'futureDate: '.$futureDate.'<br /><br />';
      
      // -> list a category(ies)
      // ------------------------------  
      $selectedPages = array();
      foreach($pages as $page) {
        // show the pages, if they have a date which can be sorten
        if(!empty($page['sortdate']) &&
           !empty($page['sortdate']['date']) &&
           ($page['category'] != 0 && $this->categoryConfig['id_'.$page['category']]['sortdate'])) {
           
           // makes the page sort date compareable
           $pageSortDate = str_replace('-','',$page['sortdate']['date']);
           
           //echo 'pageSortDate: '.$pageSortDate.'<br /><br />';           
           
           // adds the page to the array, if:
           // -> the currentdate ist between the minus and the plus month or
           // -> mins or plus month are true (means there is no time limit)
           if(($monthsInThePast === true || $pageSortDate >= $pastDate) &&
              ($monthsInTheFuture === true || $pageSortDate <= $futureDate))
             $selectedPages[] = $page;
        }
      }      
      
      // -> SORT the pages BY DATE
      // sort by DATE and GIVEN ARRAY
      if($sortingConsiderCategories === false)
        usort($selectedPages,'sortByDate');
      // sorts by DATE and CATEGORIES
      else
        $selectedPages = $this->generalFunctions->sortPages($selectedPages,'sortByDate');
      
      // -> flips the sorted array if $flipList === true
      if($flipList === true)
        $selectedPages = array_reverse($selectedPages);
      
      
      // -> LIST the pages    
      if($type == 'pages') {        
        return $this->listPages($idType,$selectedPages,$shortenTextORlinkText,$useHtmlORmenuTag,$sortingConsiderCategories);
      
      // OR  
      // -> CREATE MENU of the pages
      } elseif($type == 'menu')  {        
        return $this->createMenu($idType,$selectedPages,$shortenTextORlinkText,$useHtmlORmenuTag,$sortingConsiderCategories,$breakAfter);  
      }  
      
      /*
      foreach($selectedPages as $page) {
        // show the pages, if they have a date which can be sorten
                   
        if($pageContent = $this->generatePage($page,false,false,$shortenText,$useHtml)) {
          $return[] = $pageContent;
        }
      }
      */   
      
    } else return false;
    //return $return;
  }
  // -> END -- listByDate -------------------------------------------------------------------------
  
  // ** -- changeMonth ********************************************************************************
  // add or subtracts month from a given date in the FORMAT: YYYYMMDD (without seperation signs)
  // --------------------------------------------------------------------------------------------------
  function changeMonth($date,                  // (Number) the date to add and sub months in the FORMAT: YYYYMMDD
                                  $monthNumber,           // (Number) number of months to add or to sub
                                  $addMonths = true) {    // (Boolean) the math to use, if TRUE it ADD months if FALSE it SUBTRACT months
    
    // CHECKS if the given date and month are numbers and not a boolean
    if(!is_numeric($date) || (is_bool($monthNumber) && !is_numeric($monthNumber)))
      return $date;
    
    // das aktuelle jahr
    $year = substr($date,0,4);
    $month = substr($date,4,2);
    $day = substr($date,6,2);
    
    // subtrahiert oder addiert monnate zum aktuellen monat
    if($addMonths === true)
      $month += $monthNumber;
    else
      $month -= $monthNumber;  
    // zählt das jahr hoch oder runter wenn der monat größer 12 oder kleiner 1 sind
    while($month > 12) {
        $year++;
        $month -= 12;
    }
    while($month <= 0) {
        $year--;
        $month += 12;
    }  
    
    // sets the month to two chracters MM
    if(strlen($month) == 1)
      $month = "0".$month;
      
  	// returns the new date
  	return $year.$month.$day;
  }
  // -> END -- changeMonth -------------------------------------------------------------------------
  
  // ****************************************************************************************************************
  // GET PROPERTY ---------------------------------------------------------------------------------------------------
  // ****************************************************************************************************************
  
  // -> START -- getPropertyPage ********************************************************************
  // if given page var is false it sets the PAGE PROPERTY
  // ------------------------------------------------------------------------------------------------
  function getPropertyPage($page = false) { // (false or Number)
    if($page === false && is_numeric($this->page))
      $page = $this->page;  // set the page var from PROPERTY var

    return $page;
  }
  // -> END -- getPropertyPage ----------------------------------------------------------------------
  
  // -> START -- getPropertyPages *******************************************************************
  // if given pages var is false it sets the PAGES PROPERTY
  // ------------------------------------------------------------------------------------------------
  function getPropertyPages($pages = false) { // (false or Array)
    if($pages === false && is_array($this->pages))
      $pages = $this->pages;  // set the pages var from PROPERTY var

    return $pages;
  }
  // -> END -- getPropertyPages ---------------------------------------------------------------------
  
  // -> START -- getPropertyCategory ****************************************************************
  // if given category var is false it sets the CATEGORY PROPERTY
  // ------------------------------------------------------------------------------------------------
  function getPropertyCategory($category = false) { // (false or Number)
    if($category === false && is_numeric($this->category))
      $category = $this->category;  // set the category var from PROPERTY var

    return $category;
  }
  // -> END -- getPropertyCategory ------------------------------------------------------------------
  
  // -> START -- getPropertyCategories **************************************************************
  // if given categories var is false it sets the CATEGORIES PROPERTY
  // ------------------------------------------------------------------------------------------------
  function getPropertyCategories($categories = false) { // (false or Array)
    if($categories === false && is_array($this->categories))
      $categories = $this->categories;  // set the categories var from PROPERTY var

    return $categories;
  }
  // -> END -- getPropertyCategories ----------------------------------------------------------------
  
  // -> START -- getStoredPageIds *******************************************************************
  // RETURNs the storedPageIDs PROPERTY
  // ------------------------------------------------------------------------------------------------
  function getStoredPageIds() { // (false or Array)
  
    // load all page ids, if necessary
    if($this->storedPageIds == '')
      $this->storedPageIds = $this->generalFunctions->loadPages(true,false);

    return $this->storedPageIds;
  }
  // -> END -- getStoredPageIds ---------------------------------------------------------------------
  
  // -> START -- getStoredPages ********************************************************************
  // GET the storedPages Array from SESSION or PROPERTY
  // to turn the SESSION storedPages OFF, just unset the session in this function
  // ------------------------------------------------------------------------------------------------
  function getStoredPages() {
    global $_SESSION;
    global $HTTP_SESSION_VARS;
    
    unset($_SESSION['storedPages']);    
    //echo 'STORED-PAGES -> '.count($this->storedPages);
    
    // if its an older php version, set the session var
    if(phpversion() <= '4.1.0')
      $_SESSION = $HTTP_SESSION_VARS;    
      
    // -> checks if the SESSION storedPages Array exists
    if(isset($_SESSION['storedPages']))
      $this->storedPages = $_SESSION['storedPages']; // if isset, get the storedPages from the SESSION
    else
      $storedPages = $this->storedPages; // if not get the storedPages from the PROPERTY

    return $this->storedPages;
  }
  // -> END -- getStoredPages ----------------------------------------------------------------------
  
  // -> START -- setStoredPages ********************************************************************
  // SAVE a new pageContentArray in the storedPages Array from SESSION or PROPERTY
  // ------------------------------------------------------------------------------------------------
  function setStoredPages($pageContent = false) { // (false or PageContent Array)
    global $_SESSION;
    global $HTTP_SESSION_VARS;
    
    unset($_SESSION['storedPages']);
    
    // if its an older php version, set the session var
    if(phpversion() <= '4.1.0')
      $_SESSION = $HTTP_SESSION_VARS;  
    
    if($pageContent) {    
      // -> checks if the SESSION storedPages Array exists
      if(isset($_SESSION['storedPages']))
        $_SESSION['storedPages'][$pageContent['id']] = $pageContent; // if isset, save the storedPages in the SESSION
      else {
        $this->storedPages[$pageContent['id']] = $pageContent; // if not save the storedPages in the PROPERTY
        $_SESSION['storedPages'][$pageContent['id']] = $pageContent;
      }

      return $pageContent;    
    } else return false;
  }
  // -> END -- setStoredPages ----------------------------------------------------------------------
  
  // -> START -- shortenText *******************************************************************************
  // shortens a text by the given length number
  // -------------------------------------------------------------------------------------------------------
  function shortenText($string,                   // (String) the string which will be shorten
                                 $length,                   // (Number) the number of characters to which the text will be shorten 
                                 $pageContent = false,      // (false or Array) the pageContent Array of the Page
                                 $endString = " ...") {     // (String) the string add to the end of the shorten text
      
      // kürzt den string
      if(is_numeric($length))
        $string = substr($string,0,$length);
      
      // sucht das letzte vorkommende leerzeichen und kürzt den string bis dahin 
      $string = substr($string, 0, strrpos($string, ' '));
      
      // adds the MORE LINK to the $endString
      if($pageContent !== false && is_array($pageContent)) {
        $endString .= ' <a href="'.$this->createHref($pageContent).'">'.$this->languageFile['page_more'].'</a>';
      }
      
      // adds the endString
      if($endString !== false)
        $string .= $endString;
      
      $string = preg_replace("/ +/", ' ', $string);
      
      return $string;
  }
  // -> END -- shortenText -----------------------------------------------------------------------------------
  
  // -> START -- shortenHtmlText *****************************************************************************
  // shorten a HTML text and close all tags which are open
  // ---------------------------------------------------------------------------------------------------------
  function shortenHtmlText($input,                    // (String) the string which will be shorten
                                     $length,                   // (Number) the number of characters to which the text will be shorten
                                     $pageContent = false,      // (false or Array) the pageContent Array of the Page
                                     $endString = ' ...') {     // (String) the string add to the end of the shorten text
      
      // gets the raw text
      $rawText = strip_tags($input);
      
      // only if the given LENGTH is SMALLER than the RAW TEXT, SHORTEN the TEXT
      // ***********************************************
      if(is_numeric($length) && $length < strlen($rawText)) {
         
        // wandelt umlaute um im text mit HTML tags
        if(substr(phpversion(),0,1) >= 5)
          $decodedContent = html_entity_decode($input, ENT_QUOTES);
        
        // -> FIND THE REAL POSITION, for LENGTH
        // find the real position in the html text
        // it goes from the beginning trough every char and count only the chars which are not in <...>
        $currentLength = 0;
        $position = 0;
        $inTag = false;
           
        while($currentLength != $length) {        
          // get the CURRENT CHAR
          if(substr(phpversion(),0,1) >= 5)
            $actualChar = substr($decodedContent, $position, 1);
          else
            $actualChar = substr($input, $position, 1);
          
          //echo '<br />'.$actualChar.'<br />';
          //echo 'realPos: '.$position.'<br />';
          //echo 'actualPos: '.$actualLength.'<br />';
          //echo 'inTAG. '.$inTag.'<br />';
          
          // checks if it is in a Tag or not
          if($actualChar == '<')
            $inTag = true;
          elseif($actualChar == '>')
            $inTag = false;   
          
          // count the currentLength up if it is not in a tag
          if(!$inTag)
            $currentLength++;
          
          // count the real string length
          $position++;
        }      
        //echo 'realPos: '.$position.'<br />';
        
        // shortens the text
        $input = $this->shortenText($input,$position,false,false);
        
        // checks if there is a unclosed html tag (example: <h1..)
        // and shortens the string from this unclosed tag
        if(strrpos($input, "<") !== false && strrpos($input, "<") > strrpos($input, ">")) {
          // wenn dann kürzt er den nicht geschlossenen HTML tag weg
          $input = substr($input, 0, strrpos($input, "<"));
        }
      
        // goes trough the tags and stores the opend ones in an array
        // (auch die durch daskürzen verlorengegangenen)
        $opened = array();
        // loop through opened and closed tags in order
        // die REGULAR EXPRESSIONS pattern sucht nach allen HTML tags
        if(preg_match_all('!<(/?\w+)((\s+\w+(\s*=\s*(?:".*?"|\'.*?\'|[^\'">\s]+))?)+\s*|\s*)/?\>!is', $input, $matches)) {
          foreach($matches[1] as $tag) {
            //echo 'Tag: '.$tag."<br />\n";        
            $tag = strtolower($tag);
            
            // schaut ob es ein öffnender oder schliessender HTML tag ist
            if(substr($tag, 0, 1) != '/') {          
              // HTMl tags die nicht wieder geschlossen werden sollen
              if($tag != 'br' &&
              $tag != 'hr' &&
              $tag != 'img' &&
              $tag != 'input' &&
              $tag != 'embed' &&
              $tag != 'param' &&
              $tag != 'area' &&
              $tag != 'basefont' &&          
              $tag != 'meta' &&
              $tag != 'link' &&
              $tag != 'base') {
                // a tag has been opened
                //echo 'Tag OPEND: '.$tag.'<br />';
                $opened[] = $tag;
              }
            } else {
              // a tag has been closed
              $tag = substr($tag, 1, strlen($tag));
              //echo 'Tag CLOSED: '.$tag.'<br />';
              unset($opened[array_pop(array_keys($opened, $tag))]);
            }
          }
        }
        
        // close tags that are still open
        if($opened) {
          $tagsToClose = array_reverse($opened);
          foreach($tagsToClose as $tag) {
            //echo 'Tag WRITE: '.$tag.'<br />';
            $input .= '</'.$tag.'>';
          }
        }     
        
      }
      
      // adds the MORE LINK to the $endString
      if($pageContent !== false && is_array($pageContent)) {
        $endString .= ' <a href="'.$this->createHref($pageContent).'">'.$this->languageFile['page_more'].'</a>';
      }
      
      // try to put the endString before the last HTML-Tag
      if(substr($input,-1) == '>') {
        $lastTagPos = strrpos($input, '</');
        $lastTag = substr($input,$lastTagPos);
        $input = substr($input,0,$lastTagPos).$endString.$lastTag;
      } else
        $input .= $endString;
      
      // returns the shorten Html-Text
      return $input;
  }
  // -> END -- shortenHtmlText ----------------------------------------------------------------------------------
}
?>