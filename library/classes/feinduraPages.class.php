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
 * This file contains the {@link feinduraPages} <var>class</var> for implementing the CMS in a website
 */ 
 
/**
* The <var>class</var> for the implimentation of the feindura - Flat File Content Management System in a website.
* 
* It's methods provide necessary functions to impliment the CMS in a website.<br>
* It contains for example methods for building a menu and place the page content, etc.
* 
* @author Fabian Vogelsteller
* @copyright Fabian Vogelsteller
* @license http://www.gnu.org/licenses GNU General Public License version 3
* @version 1.01
*
*/
class feinduraPages extends feindura {
  
 /* ---------------------------------------------------------------------------------------------------------------------------- */
 /* *** PROPERTIES */
 /* **************************************************************************************************************************** */
                            
 /**
  * <i>TRUE</i> when the pages content should be handled as XHTML
  *
  * In XHTML standalone tags end with " />" instead of ">".<br>
  * When a page content is displayed and this property is <i>FALSE</i> all " />" will be changed to ">".
  * 
  * @var bool
  *    
  */
  var $xHtml = true;
  
 /**
  * Contains the current page ID get from the <var>$_GET</var> variable
  *
  * This property is used when a page loading method is called (for example: {@link showPage()}) and no page ID <var>parameter</var> is given.
  *   
  * This property will be set in the {@link feindura()} constructor.
  * 
  * @var int
  *
  * @see feindura()
  *   
  */
  var $page = null;
  
 /**
  * Contains the current category ID get from the <var>$_GET</var> variable
  *
  * This property is used when a page-loading method is called (for example: {@link showPage()}) and no category ID <var>parameter</var> is given.
  *   
  * This property will be set in the {@link feindura()} constructor.
  * 
  * @var int
  *
  * @see feindura()
  *   
  */
  var $category = null;
   
 /**
  * Contains the start-page ID from the website-settings config
  *
  * This property is set to the {@link $page} property when the <var>$_GET</var> page variable is empty<br>
  * and the {@link $page} property is empty.
  *   
  * This property will be set on the first call of the {@link setCurrentPage()} method in the {@link feindura()} constructor.
  * 
  * @var int
  *
  * @see $page
  * @see feindura()
  * @see setCurrentPage()
  *   
  */
  var $startPage = null;
  
 /**
  * Contains the start-category ID
  *
  * Its fetched from the {@link $startPage} through the {@link getPageCategory()} method.<br>
  * This property is set to the {@link $category} property when the <var>$_GET</var> category variable is empty<br>
  * and the {@link $category} property is empty.
  *   
  * This property will be set on the first call of the {@link setCurrentCategory()} method in the {@link feindura()} constructor.
  * 
  * @var int
  *
  * @see $category
  * @see $startPage
  * @see feindura()
  * @see setCurrentPage()
  *   
  */
  var $startCategory = null;
  
 /**
  * Contains a id-Attribute which will be assigned to any link created by {@link createLink()} or {@link createMenu()}
  * 
  * 
  * 
  * @var false|string If no link id-Attribute should be assigned, set it to FALSE.
  * @see createLink(), createMenu()  
  * @example createLink.example.php  
  *   
  */
  var $linkId = false;                    // [False or String]      -> the link ID which is used when creating a link (REMEMBER you can only set ONE ID in an HTML Page)
  var $linkClass = false;                 // [False or String]      -> the link CLASS which is used when creating a link
  var $linkAttributes = false;            // [False or String]      -> a String with Attributes like: 'key="value" key2="value2"'
  var $linkBefore = false;                // [False or String]      -> a String which comes BEFORE the link <a> tag
  var $linkAfter = false;                 // [False or String]      -> a String which comes AFTER the link </a> tag
  var $linkTextBefore = false;            // [False or String]      -> a String which comes BEFORE the linkText <a> tag
  var $linkTextAfter = false;             // [False or String]      -> a String which comes AFTER the linkText </a> tag
  var $linkThumbnail = false;             // [bool]              -> show the thumbnail in the link
  var $linkThumbnailAfterText = false;    // [bool]              -> show the thumbnail after the linkText
  var $linkLength = false;                // [bool or Number]    -> the number of maximun characters for the link Title, after this length it will be shorten with abc..
  var $linkShowCategory = false;          // [bool]              -> show the category name before the title
  var $linkCategorySpacer = ': ';         // [String]               -> the text to be used as a spacer between the category name and the title (example: Category -> Title Text)
  var $linkShowDate = false;              // [bool]              -> show the page date before the title

  var $menuId = false;                    // [False or String]      -> the menu ID which is used when creating a menu (REMEMBER you can only set ONE ID in an HTML Page)
  var $menuClass = false;                 // [False or String]      -> the menu CLASS which is used when creating a menu
  var $menuAttributes = false;            // [False or String]      -> a String with Attributes like: 'key="value" key2="value2"'
  var $menuBefore = false;                // [False or String]      -> a String which comes BEFORE the menu <$menuTag> tag
  //var $menuAfter = false;                 // [False or String]      -> a String which comes AFTER the menu </$menuTag> tag
  //var $menuBetween = false;               // [False or String]      -> a String which comes AFTER EVERY <li></li> OR <td></td> tag EXCEPT THE LAST tag
  
  var $titleTag = false;                  // [Boolean or String]    -> the title TAG which is used when creating a page title (STANDARD Tag: H1)
  var $titleId = false;                   // [False or String]      -> the title ID which is used when creating a page title (REMEMBER you can only set ONE ID in an HTML Page, so dont use this for listing Pages)
  var $titleClass = false;                // [False or String]      -> the title CLASS which is used when creating a page title
  var $titleAttributes = false;            // [False or String]      -> a String with Attributes like: 'key="value" key2="value2"'
  var $titleLength = false;               // [Boolean or Number]    -> the number of maximun characters for the title, after this length it will be shorten with abc..
  var $titleAsLink = false;               // [Boolean]              -> should the title be a link to the Page (ONLY when listing a Page)
  var $titleShowCategory = false;         // [Boolean]              -> show the category name before the title
  var $titleCategorySpacer = ': ';        // [String]               -> the text to be used as a spacer between the category name and the title (example: Category -> Title Text)
  var $titleShowDate = false;             // [Boolean]              -> show the page date before the title
  //var $titleBefore = false;               // [False or String]      -> a String which comes BEFORE the link <$titleTag> tag
  //var $titleAfter = false;                // [False or String]      -> a String which comes AFTER the link </$titleTag> tag
  
  var $pageShowTitle = true;
  var $pageShowThumbnail = true;
  var $pageShowContent = true;
  var $pageShowError = true;
  
  /*
  var $showContent = true;                    // [Boolean]              -> show the page content when SHOW Pages and LISTING Pages
  var $contentTag = false;                // [False or String]      -> the content container TAG which is used when creating a page (STANDARD Tag: DIV; if there is a class and/or id and no TAG is set)
  var $contentId = false;                 // [False or String]      -> the content container  ID which is used when creating a page (REMEMBER you can only set ONE ID in an HTML Page, so dont use this for listing Pages)
  var $contentClass = false;              // [False or String]      -> the content container  CLASS which is used when creating a page
  var $contentAttributes = false;            // [False or String]      -> a String with Attributes like: 'key="value" key2="value2"'
  //var $contentLength = false;             // [Boolean or Number]    -> the number of maximun characters for the content, after this length it will be shorten with abc..
  var $contentShowTitle = true;
  var $contentShowThumbnail = true;           // [Boolean]              -> show the page thumbnails when SHOW and LISTING Pages
  var $contentBefore = false;             // [False or String]      -> a String which comes BEFORE the link <$contentTag> tag
  var $contentAfter = false;              // [False or String]      -> a String which comes AFTER the link </$contentTag> tag
  */
  
  var $thumbnailAlign = false;            // [False or String ("left" or "right")]   -> let the thumbnail float to left or right
  var $thumbnailId = false;               // [False or String]      -> the thumbnail ID which is used when creating a thumbnail (REMEMBER you can only set ONE ID in an HTML Page, so dont use this for listing Pages)
  var $thumbnailClass = false;            // [False or String]      -> the thumbnail CLASS which is used when creating a thumbnail
  var $thumbnailAttributes = false;            // [False or String]      -> a String with Attributes like: 'key="value" key2="value2"'
  var $thumbnailBefore = false;           // [False or String]      -> a String which comes BEFORE the thumbnail img <$titleTag> tag
  var $thumbnailAfter = false;            // [False or String]      -> a String which comes AFTER the thumbnail img </$titleTag> tag
  
  //var $showError = true;                    // [Boolean]              -> show a message when a error or a notification appears (example: 'The page you requested doesn't exist')
  var $errorTag = false;                // [False or String]      -> the message TAG which is used when creating a message (STANDARD Tag: SPAN; if there is a class and/or id and no TAG is set)
  var $errorId = false;                 // [False or String]      -> the message ID which is used when creating a message (REMEMBER you can only set ONE ID in an HTML Page, so dont use this for listing Pages)
  var $errorClass = false;              // [False or String]      -> the message CLASS which is used when creating a message
  var $errorAttributes = false;            // [False or String]      -> a String with Attributes like: 'key="value" key2="value2"'

 /* ---------------------------------------------------------------------------------------------------------------------------- */
 /* *** METHODS *** */
 /* **************************************************************************************************************************** */
 
  /*
  *
  * STRING <- createMetaTags($charset = 'UTF-8', $robotTxt = false, $revisitAfter = '10', $author = false, $publisher = false, $copyright = false)
  *      
  *                           
  * STRING <- createLink($page = false, $category = false, $linkText = true)
  *   
  *  
  * ARRAY <- createMenu($idType = 'categories', $ids = true, $menuTag = false, $linkText = true, $breakAfter = false, $sortByCategories = false)
  * 
  * ARRAY <- createMenuByTags($tags ,$idType = 'categories', $ids = true, $menuTag = false, $linkText = true, $breakAfter = false, $sortByCategories = false)
  *    
  * ARRAY <- createMenuByDate($idType, $ids = true, $monthsInThePast = true, $monthsInTheFuture = true, $menuTag = false, $linkText = true, $breakAfter = false, $sortByCategories = false, $flipList = false) 
  * 
  *  
  * STRING <- showPageTitle($page = false, $category = false, $titleTag = true)
  *    
  * STRING <- showPage($page = false, $category = false, $shortenText = false, $useHtml = true)             <- also SAVEs the PAGE-STATISTICs
  *   
  *  
  * ARRAY <- listPages($idType, $ids = true, $shortenText = false, $useHtml = true, $sortByCategories = false)
  *  
  * ARRAY <- listPagesByTags($tags, $idType, $ids = true, $shortenText = false, $useHtml = true, $sortByCategories = false)
  * 
  * ARRAY <- listPagesByDate($idType, $ids = true, $monthsInThePast = true, $monthsInTheFuture = true, $shortenText = false,  $useHtml = true,  $sortByCategories = false, $flipList = false)
  * 
  *  
  * NUMBER <- getCurrentPage()
  * 
  * NUMBER <- getCurrentCategory()    
  * 
  * NUMBER <- setCurrentPage($setStartPage = false)
  * 
  * NUMBER <- setCurrentCategory()
  *     
  */ 
  
/**
  * The constructor of the class
  *
  * Type:     function<br>
  * Name:     feinduraPages()<br>
  * Purpose:  runs the parent class constructor
  *
  * ChangeLog:<br>
  *           - 1.0 initial release
  *
  * Details:<br> 
  *	      run the {@link feindura::feindura()} class constructor to set all necessary properties
  * 
  * get the \a frontend \a language \a file for the frontend
  * 
  * 
  * \param $language (\c string: \e optional) - A country code (example: \a de, \a en, \a ..) to set the language of the frontend language files and is also set to the #$language \c property.
  * 
  * \par used Properties:
  *   #$sessionId\n
  *   #$sessionId\n
  *   #$sessionId\n
  * 
  * \retval true
  * 
  *    
  * \see feindura()
  * 
  * beispiel hier\n
  * 
  * \code
  * 
  * < href="sdf">dfgdf</a>
  * 
  * \endcode
  * 
  * This is an example of how to use the Test class.
  * More details about this example.
  * inline {@example createFeindura.example.php}
  * 
  * \line (echo)
  * 
  */
  function feinduraPages($language = false) {   // (String) string with the COUNTRY CODE ("de", "en", ..)
    
    // RUN the feindura constructor
    $this->feindura($language);

    return true;
  }
  // -> END -- constructor -------------------------------------------------------------------------------
  
  
  // ****************************************************************************************************************
  // PUBLIC METHODs -------------------------------------------------------------------------------------------------
  // ****************************************************************************************************************
  
  // -> START -- createMetaTags **************************************************************************
  // RETURNs the META TAGS at the position
  // RETURNs -> STRING
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
      //echo $metaTags;
      return $metaTags;
  }
  // -> *ALIAS* OF createMetaTags ****************************************************************************
  function createMetaTag($charset = 'UTF-8', $robotTxt = false, $revisitAfter = '10', $author = false, $publisher = false, $copyright = false) {
    // call the right function
    return $this->createMetaTags($charset, $robotTxt, $revisitAfter, $author, $publisher, $copyright);
  }
  
 /**
  * Generates a href attribute for using in a link tag to a page
  *
  * <b>Type</b>     function<br>
  * <b>Name</b>     createHref()<br>
  *
  * Generates a href attribute to link to a page.
  * Depending whether speaking URLs is in the administrator-settings activated, it generates a different href attribute.<br>
  * If cookies are deactivated it attaches the {@link $sessionId} on the end.
  *
  * Examples of the returned href string:<br>
  * ("user=xyz123" stands for: sessionname=sessionid)
  *
  * Href with variables for pages without category: 
  * <samp>
  * '?page=1&user=xyz123'
  * </samp>
  * and pages with category:
  * <samp>
  * '?category=1&page=1&user=xyz123'
  * </samp>
  *
  * Speaking URL href for pages without category: 
  * <samp>
  * '/page/page_title.html?user=xyz123'
  * </samp>
  * and pages with category:
  * <samp>
  * '/category/category_name/page_title.html?user=xyz123'
  * </samp>
  *
  *
  * @param int|array $page          page ID or a $pageContent array
  * 
  * @uses feindura::getPageCategory()	   to get the category ID if the $page parameter is not an $pageContent array
  * @uses feindura::readPage()		   to load the $pageContent array if the $page parameter is an page ID
  * @uses generalFunctions::createHref()   call the right createHref functions in the generalFunctions class
  *
  * 
  * @return string the generated href attribute
  *
  * @access public
  *
  * @see generalFunctions::createHref()
  *
  * @version 1.0
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.0 initial release
  *
  */
  function createHref($page) {
    
    // IF given $page is an $pageContent array
    if(is_array($page) && array_key_exists('id',$page))
	$pageContent = $page;
	
    // ELSE $page is page ID
    else {
	// gets page category
        $category = $this->getPageCategory($page);
	// load pageContent
	$pageContent = $this->readPage($page,$category);
    }
    
    return $this->generalFunctions->createHref($pageContent,$this->sessionId);
    
  }
  
  // -> START -- createLink ******************************************************************************
  // RETURNs a link created with the page ID
  // RETURNs -> STRING
  // * MORE OPTIONs in the PROPERTIES
  // -----------------------------------------------------------------------------------------------------
  function createLink($page = false,                 // (Number or String ("prev" or "next") or pageContent Array) the page ID to show, if false it use VAR PRIORITY
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
    
    // USES the PRIORITY: 1. -> page var 2. -> PROPERTY page var 3. -> false
    $page = $this->getPropertyPage($page);
    
    // gets the category of the page
    if(is_numeric($page))
      $category = $this->getPageCategory($page);
    
    //echo 'PAGE: '.$page;
    
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
        //print_r($page);
	
        // -> sets the LINK
        // ----------------------------  
        $linkTag = 'a';
        $linkAttributes = '';
        
        // add HREF
        $linkAttributes .= ' href="'.$this->createHref($pageContent).'"'; // title="'.$pageContent['title'].'"
	  
	$linkAttributes .= $this->createAttributes($this->linkId, $this->linkClass, $this->linkAttributes);
                    
        $linkStartTag = '<'.$linkTag.$linkAttributes.'>';
        $linkEndTag = '</'.$linkTag.'>';        
        
        // -> LINK THUMBNAIL
        // *****************
        if($this->linkThumbnail &&      
          !empty($pageContent['thumbnail']) &&
          @is_file(DOCUMENTROOT.$this->adminConfig['uploadPath'].$this->adminConfig['pageThumbnail']['path'].$pageContent['thumbnail']) &&
          ((!$pageContent['category'] && $this->adminConfig['page']['thumbnailUpload']) ||
          ($pageContent['category'] && $this->categoryConfig['id_'.$pageContent['category']]['thumbnail']))) {
          
          // adds ATTRIBUTES and/or FLOAT  
	  $thumbnailAttributes = $this->createAttributes($this->thumbnailId, $this->thumbnailClass, $this->thumbnailAttributes);
	  
          // thumbnail FLOAT
          if(strtolower($this->thumbnailAlign) === 'left' ||
             strtolower($this->thumbnailAlign) === 'right')
            $thumbnailAttributes .= ' style="float:'.strtolower($this->thumbnailAlign).';"';
          
          $linkThumbnail = '<img src="'.$this->adminConfig['uploadPath'].$this->adminConfig['pageThumbnail']['path'].$pageContent['thumbnail'].'" alt="'.$pageContent['title'].'" title="'.$pageContent['title'].'"'.$thumbnailAttributes.$tagEnding."\n";
        } else $linkThumbnail = '';
      
        
        // -> LINK TITLE
        // *****************
        // -> create the text
        if($linkText === true) {
                 
          // add the TITLE
          $linkText = $this->createTitle($pageContent,
                                        false, // $titletag
                                        false, // $titleId
                                        false, // $titleClass
					false, // $titleAttributes
					$this->linkCategorySpacer,
                                        $this->linkLength,
                                        false, // $titleAsLink
                                        $this->linkShowCategory,
                                        $this->linkShowDate);
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
          
        // returns the whole link after finish
        return $link;
      } else return false;
    } else return false;
  }
  // -> END -- createLink --------------------------------------------------------------------------------
  
  // -> START -- createMenu ******************************************************************************
  // RETURN an Array with LINKs and the given MENU TAG created out of the pages IDs or a category ID(s)
  // RETURNs -> ARRAY
  // * MORE OPTIONs in the PROPERTIES
  // -----------------------------------------------------------------------------------------------------
  function createMenu($idType = 'categories',                      // (String ["page", "pages" or "category", "categories"]) uses the given IDs for looking in the pages or categories
                             $ids = true,                                 // (false or Number or Array or Array with pageContent Arrays) the pages ID(s) or category ID(s) for the menu, if false it use VAR PRIORITY, if TRUE and $idType = "category", it loads all categories                             
                             $menuTag = false,                            // (Boolean or String or [a Block Element, "ul", "ol" or "table"]) the menu TAG which is used when creating a menu, IF false it RETURNs a Array with the links (STANDARD Tag: DIV; if there is a class and/or id and no TAG is set it RETURNs an Array with all the <a..> tags within a DIV tag with the id and/or class)
                             $linkText = true,                            // (Boolean or String) the TEXT used for the links, if TRUE it USES the TITLE of the pages
                             $breakAfter = false,                         // (Boolean or Number) if TRUE it makes a br behind each <a..></a> element, if its a NUMBER AND the menuTag IS "table" it breaks the rows after the given Number 
                             $sortByCategories = false) {        // (Boolean) if TRUE it sorts the pages by categories and the sorting like in the backend
    
    // vars
    $menu = array();
    
    $idType = strtolower($idType);
    
    // USES the PRIORITY: 1. -> page var 2. -> PROPERTY page var 3. -> false
    if(!$ids) {
      if($idType == 'page')
        // USES the PRIORITY: 1. -> pages var 2. -> PROPERTY pages var 3. -> false
        $ids = $this->getPropertyPage($ids);      
      elseif($idType == 'category')
        // USES the PRIORITY: 1. -> category var 2. -> PROPERTY category var 3. -> false
        $ids = $this->getPropertyCategory($ids);
      /*
      elseif($idType == 'pages')
        // USES the PRIORITY: 1. -> page var 2. -> PROPERTY page var 3. -> false
        $ids = $this->getPropertyPages($ids);
      elseif($idType == 'categories')
        // USES the PRIORITY: 1. -> categories var 2. -> PROPERTY categories var 3. -> false
        $ids = $this->getPropertyCategories($ids);
      */
    }    
          
    // -> sets the MENU attributes
    // ----------------------------    
    $menuStartTag = '';
    $menuEndTag = '';        
    $menuTagSet = false;
    
    $menuAttributes = $this->createAttributes($this->menuId, $this->menuClass, $this->menuAttributes);
    
    // -> CREATEs the MENU-TAG (START and END-TAG)
    if($menuTag) { // || !empty($menuAttributes) <- not used because there is no menuTag property, the tag is only set when a $menuTag parameter is given

      // set tag
      if(is_string($menuTag)) $menuTagSet = strtolower($menuTag);
      // or uses standard tag
      else $menuTagSet = 'div';
                
      $menuStartTag = '<'.$menuTagSet.$menuAttributes.'>'."\n";
      $menuEndTag = '</'.$menuTagSet.'>'."\n";
    }
    
    // -> LOADS the PAGES BY TYPE
    $pages = $this->loadPagesByType($idType,$ids);
    
    // -> if pages SORTED BY CATEGORY
    if($sortByCategories === true)
      $pages = $this->generalFunctions->sortPages($pages);    
    
    // -> STOREs the LINKs in an Array
    $links = array();
    if($pages !== false) {
      // create a link out of every page in the array
      foreach($pages as $page) {
        // creates the link
        if($pageLink = $this->createLink($page,$page['category'], $linkText)) {
          // adds the link to an array
          $links[] = $pageLink;
        }
      }      
    } else 
      return array(false);
    
    // --------------------------------------
    // -> RETURNs a Array of LINKs, if there is no menuTag set <- (!!! LEGACY !!!)
    //if($menuTag === false) {
      
      // add a standard tag if there is a class or id (REMOVED)
      //if(!empty($menuStartTag) && !empty($menuEndTag)) {
        //array_unshift($links,$menuStartTag);
        //array_push($links,$menuEndTag);
      //}
      //return $links;
    //}     
    
    // ->> OR
    
    // --------------------------------------
    // -> builds the final MENU
    // ************************
    if(empty($links))
      return array();
    
    /*
    // CHECK if the LINK BEFORE & AFTER is !== true
    if($this->menuBefore !== true)
      $menuBefore = $this->menuBefore;
    if($this->menuAfter !== true)
      $menuAfter = $this->menuAfter;
    
    if(!is_bool($this->menuBetween))
      $menuBetween = $this->menuBetween;
    */
    
    // creating the START TR tag
    if($menuTagSet == 'table')
      $menuStartTag .= '<tr>';
    
    // SHOW START-TAG
    if($menuStartTag) {
      //echo $menuBefore.$menuStartTag;
      $menu[] = $menuStartTag; //$menuBefore.$menuStartTag;
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
        //echo "</tr><tr>\n";
        $menu[] = "</tr><tr>\n";
        $count = 1;
      }
      
      // clears the $menuBetween String if its the last tag
      if($count == count($links))
        $menuBetween = false;
      
      // if menuTag is a LIST ------
      if($menuTagSet == 'ul' || $menuTagSet == 'ol') {
        $link = '<li>'.$link."</li>\n".$menuBetween;
        
      // if menuTag is a TABLE -----
      } elseif($menuTagSet == 'table') {
        $link = '<td>'.$link."</td>\n".$menuBetween;
        
      // if menuTag is a false -----
      } elseif(isset($menuBetween)) {
        $link = $link."\n".$menuBetween;
      }
      
      // SHOW the link
      //echo $link;
      $menu[] = $link."\n";
      
      // count the table cells
      $count++;
    }
    
    // fills in the missing TABLE CELLs
    while($menuTagSet == 'table' &&
          $breakAfter !== false &&
          is_numeric($breakAfter) &&
          $breakAfter >= $count) {
      //echo "<td></td>\n";
      $menu[] = "<td></td>\n";
      $count++;
    }
    
    // creating the END TR tag
    if($menuTagSet == 'table')
      $menuEndTag = '</tr>'.$menuEndTag;
    
    // SHOW END-TAG
    if($menuStartTag) {
      //echo $menuEndTag.$menuAfter;
      $menu[] = $menuEndTag; //$menuEndTag.$menuAfter;
    }
    
    // adds breaks before and after
    //$menu = "\n".$menu."\n";
    // removes double breaks
    //$menu = preg_replace("/\\n+/","\n",$menu);
    
    // returns the whole menu after finish
    return $menu;
  }
  // -> END -- createMenu --------------------------------------------------------------------------------
  
  // -> START -- createMenuByTags ******************************************************************************
  // RETURN a menu created out of the pages IDs or a category ID(s) and also, but only if the page has one of the given TAGS
  // RETURNs -> ARRAY
  // * MORE OPTIONs in the PROPERTIES
  // -----------------------------------------------------------------------------------------------------
  function createMenuByTags($tags,                                     // (String or Array) the tags to select the page(s)/category(ies) with
                                   $idType = 'categories',                    // (String ["page", "pages" or "category", "categories"]) uses the given IDs for looking in the pages or categories
                                   $ids = true,                               // (false or Number or Array) the pages ID(s) or category ID(s) for the menu, if false it use VAR PRIORITY, if TRUE and $idType = "category", it loads all categories                                   
                                   $menuTag = false,                          // (Boolean or String) the TAG used for the Menu, if TRUE it uses the menuTag from the PROPERTY
                                   $linkText = true,                          // (Boolean or String) the TEXT used for the links, if TRUE it USES the TITLE of the pages
                                   $breakAfter = false,                       // (Boolean or Number) if TRUE it makes a br behind each <a..></a> element, if its a NUMBER AND the menuTag IS "table" it breaks the rows after the given Number 
                                   $sortByCategories = false) {      // (Boolean) if TRUE it sorts the pages by categories and the sorting like in the backend
                                   
    $idType = strtolower($idType);    
    // USES the PRIORITY: 1. -> page var 2. -> PROPERTY page var 3. -> GET page var 4. -> false
    if(!$ids) {
      if($idType == 'page')
        // USES the PRIORITY: 1. -> pages var 2. -> PROPERTY pages var 3. -> false
        $ids = $this->getPropertyPage($ids);      
      elseif($idType == 'category')
        // USES the PRIORITY: 1. -> category var 2. -> PROPERTY category var 3. -> false
        $ids = $this->getPropertyCategory($ids);
      /*
      elseif($idType == 'pages')
        // USES the PRIORITY: 1. -> page var 2. -> PROPERTY page var 3. -> false
        $ids = $this->getPropertyPages($ids);
      elseif($idType == 'categories')
        // USES the PRIORITY: 1. -> categories var 2. -> PROPERTY categories var 3. -> false
        $ids = $this->getPropertyCategories($ids);
      */
    }
    
    // check for the tags and CREATE A MENU
    if($ids = $this->hasTags($ids,$idType,$tags)) {
      return $this->createMenu($idType,$ids,$menuTag,$linkText,$breakAfter,$sortByCategories); 
    } else return false;
  }
  // -> *ALIAS* OF createMenuByTags ****************************************************************************
  function createMenuByTag($tags, $idType = 'categories', $ids = true, $menuTag = false, $linkText = true, $breakAfter = false, $sortByCategories = false) {
    // call the right function
    return $this->createMenuByTags($tags,$idType,$ids,$menuTag,$linkText,$breakAfter,$sortByCategories);
  }
  
  // -> START -- createMenuByDate **************************************************************************
  // RETURN a menu created out of the pages IDs or a category ID(s), if they have a pageDate set and pagedate is activated in the category, AND its between the given month Number from now and in the past
  // RETURNs -> ARRAY
  // * MORE OPTIONs in the PROPERTIES
  // ------------------------------------------------------------------------------------------------------  
  function createMenuByDate($idType,                               // (String ["page", "pages" or "category", "categories"]) uses the given IDs for looking in the pages or categories
                                   $ids = true,                           // (false or Number or Array) the pages ID(s) or category ID(s) for the menu, if false it use VAR PRIORITY, if TRUE and $idType = "category", it loads all categories
                                   $monthsInThePast = true,               // (Boolean or Number) number of month BEFORE today, if TRUE it shows ALL PAGES FROM the PAST, if false it shows ONLY pages FROM TODAY
                                   $monthsInTheFuture = true,             // (Boolean or Number) number of month AFTER today, if TRUE it shows ALL PAGES IN the FUTURE, if false it shows ONLY pages UNTIL TODAY                                   
                                   $menuTag = false,                      // (Boolean or String) the TAG used for the Menu, if TRUE it uses the menuTag from the PROPERTY
                                   $linkText = true,                      // (Boolean or String) the TEXT used for the links, if TRUE it USES the TITLE of the pages
                                   $breakAfter = false,                   // (Boolean or Number) if TRUE it makes a br behind each <a..></a> element, if its a NUMBER AND the menuTag IS "table" it breaks the rows after the given Number 
                                   $sortByCategories = false,    // (Boolean) if TRUE it sorts the pages by categories and the sorting like in the backend
                                   $flipList = false) {                   // (Boolean) if TRUE it flips the array with the listet pages
                                   
      return $this->listByDate('menu',$idType,$ids,$monthsInThePast,$monthsInTheFuture,$menuTag,$linkText,$sortByCategories,$breakAfter,$flipList);
  }
  // -> *ALIAS* OF createMenuByDate **********************************************************************
  function createMenuByDates($idType, $ids = true, $monthsInThePast = true, $monthsInTheFuture = true, $menuTag = false, $linkText = true, $breakAfter = false, $sortByCategories = false, $flipList = false) {
    // call the right function
    return $this->createMenuByDate($idType, $ids, $monthsInThePast, $monthsInTheFuture, $menuTag, $linkText, $breakAfter, $sortByCategories, $flipList);
  }  
  
  // -> START -- showPage ********************************************************************************
  // RETURNs the Title of a given Page
  // RETURNs -> STRING
  // * MORE OPTIONs in the PROPERTIES
  // -----------------------------------------------------------------------------------------------------
  function showPageTitle($page = false,              // (Number or String ("prev" or "next")) the page ID to show, if false it use VAR PRIORITY
                                $titleTag = true) {        // (Boolean or String) the TAG which is used by the title (String), if TRUE it loads the titleTag PROPERTY
    
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
    
    // USES the PRIORITY: 1. -> page var 2. -> PROPERTY page var 3. -> false
    $page = $this->getPropertyPage($page);
    
    // gets the category of the page if it is not given
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
				    $this->titleAttributes,
				    $this->titleCategorySpacer,
                                    $this->titleLength,
                                    $this->titleAsLink,
                                    $this->titleShowCategory,
                                    $this->titleShowDate);                                      
      
        //echo $title;
        return $title;
        
      } else
      return false; 
    } else
      return false;    
  }
  // -> *ALIAS* OF showPageTitle **********************************************************************
  function showTitle($page = false, $titleTag = true) {
    // call the right function
    return $this->showPageTitle($page, $titleTag);
  } 
  
  // -> START -- showPage ********************************************************************************
  // RETURNs a Page, if there is no category set, it opens a page in the non-category
  // RETURNs -> STRING
  // * MORE OPTIONs in the PROPERTIES (TITLE and CONTENT layout)
  // -----------------------------------------------------------------------------------------------------
  /**< \brief \c array -> Stores the frontend language file \c array.
  */ 
  function showPage($page = false,                 // (Number or String ("prev" or "next")) the page ID to show, if false it use VAR PRIORITY
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
    
    // USES the PRIORITY: 1. -> page var 2. -> PROPERTY page var 3. -> false
    $page = $this->getPropertyPage($page);
    
    // gets the category of the page
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
      if($generatedPage = $this->generatePage($page,$this->pageShowError,$shortenText,$useHtml)) {
        // -> SAVE PAGE STATISTIC
        // **********************
        $this->statisticFunctions->savePageStats($this->readPage($page,$category));
        
        // returns the UNCHANGED pageContent Array, after showing the page
        return $generatedPage;
      }
    }    
    return false;
  }
  // -> END -- showPage -----------------------------------------------------------------------------------
  
  
  // -> START -- listPages ********************************************************************************
  // RETURNs an Array of PAGEs, sorted by the categories or by the given array
  // * MORE OPTIONs in the PROPERTIES (TITLE and CONTENT layout)
  // ------------------------------------------------------------------------------------------------------
  function listPages($idType,                               // (String ["page", "pages" or "category", "categories"]) uses the given IDs for looking in the pages or categories
                            $ids = true,                           // (false or Number or Array or Array with pageContent Arrays) the pages ID(s) or category ID(s) for the menu, if false it use VAR PRIORITY, if TRUE and $idType = "category", it loads all categories, -> can also be a Array with pageContent Arrays
                            $shortenText = false,                  // (Boolean or Number) the Number of characters to shorten the content text
                            $useHtml = true,                       // (Boolean) use html in the content text
                            $sortByCategories = false) {  // (Boolean) if TRUE it sorts the pages by categories and the sorting like in the feindura cms
    
    // vars
    $return = array();
    
    $idType = strtolower($idType);
    
    // USES the PRIORITY: 1. -> page var 2. -> PROPERTY page var 3. -> false
    if(!$ids) {
      if($idType == 'page' || $idType == 'pages')
        // USES the PRIORITY: 1. -> pages var 2. -> PROPERTY pages var 3. -> false
        $ids = $this->getPropertyPage($ids);      
      elseif($idType == 'category' || $idType == 'categories')
        // USES the PRIORITY: 1. -> category var 2. -> PROPERTY category var 3. -> false
        $ids = $this->getPropertyCategory($ids);
      /*
      elseif($idType == 'pages')
        // USES the PRIORITY: 1. -> page var 2. -> PROPERTY page var 3. -> false
        $ids = $this->getPropertyPages($ids);
      elseif($idType == 'categories')
        // USES the PRIORITY: 1. -> categories var 2. -> PROPERTY categories var 3. -> false
        $ids = $this->getPropertyCategories($ids);
      */
    } 
        
    // LOADS the PAGES BY TYPE
    $pages = $this->loadPagesByType($idType,$ids);

    // -> if pages SORTED BY CATEGORY
    if($sortByCategories === true)
      $pages = $this->generalFunctions->sortPages($pages);
    
    if($pages !== false) {      
      
      // -> list a category(ies)
      // ------------------------------
      foreach($pages as $pageContentArray) {
        // show the pages
        if($pageContent = $this->generatePage($pageContentArray,false,$shortenText,$useHtml)) {
          $return[] = $pageContent;
        }
      }
    } else // IF there are NO PAGES
      return array();
    return $return;
  }
  // -> END -- listPages ---------------------------------------------------------------------------------  
  // -> *ALIAS* OF listPages *****************************************************************************
  function listPage($idType, $id = true, $shortenText = false, $useHtml = true, $sortByCategories = false) {
    // call the right function
    return $this->listPages($idType, $id, $shortenText, $useHtml, $sortByCategories);
  }
  // -> END -- listPage ----------------------------------------------------------------------------------  
  
  // -> START -- listPagesByTags *************************************************************************
  // RETURNs PAGEs, sorted by the categories or by the given array, but only if the page has one of the given TAGS
  // * MORE OPTIONs in the PROPERTIES (TITLE and CONTENT layout)
  // -----------------------------------------------------------------------------------------------------
  function listPagesByTags($tags,                                 // (String or Array) the tags to select the pages with
                                  $idType,                               // (String ["page", "pages" or "category", "categories"]) uses the given IDs for looking in the pages or categories
                                  $ids = true,                           // (false or Number or Array) the pages ID(s) or category ID(s) for the menu, if false it use VAR PRIORITY, if TRUE and $idType = "category", it loads all categories
                                  $shortenText = false,                   // (false or Number) the Number of characters to shorten the content text
                                  $useHtml = true,                       // (Boolean) use html in the content text
                                  $sortByCategories = false) {  // (Boolean) if TRUE it sorts the pages by categories and the sorting like in the backend
     
    $idType = strtolower($idType);
    // USES the PRIORITY: 1. -> page var 2. -> PROPERTY page var 3. -> false
    if(!$ids) {
      if($idType == 'page' || $idType == 'pages')
        // USES the PRIORITY: 1. -> pages var 2. -> PROPERTY pages var 3. -> false
        $ids = $this->getPropertyPage($ids);      
      elseif($idType == 'category' || $idType == 'categories')
        // USES the PRIORITY: 1. -> category var 2. -> PROPERTY category var 3. -> false
        $ids = $this->getPropertyCategory($ids);
      /*
      elseif($idType == 'pages')
        // USES the PRIORITY: 1. -> page var 2. -> PROPERTY page var 3. -> false
        $ids = $this->getPropertyPages($ids);
      elseif($idType == 'categories')
        // USES the PRIORITY: 1. -> categories var 2. -> PROPERTY categories var 3. -> false
        $ids = $this->getPropertyCategories($ids);
      */
    }
    
    // check for the tags and LIST PAGES
    if($ids = $this->hasTags($ids,$idType,$tags)) {
      
      return $this->listPages($idType,$ids,$shortenText,$useHtml,$sortByCategories);
    } else return false;
  }  
  // -> *ALIAS* OF listPagesByTags ***********************************************************************
  function listPagesByTag($tags, $idType, $ids = true, $shortenText = false, $useHtml = true, $sortByCategories = false) {
    // call the right function
    return $this->listPagesByTags($tags, $idType, $ids, $shortenText, $useHtml, $sortByCategories);
  }
  // -> *ALIAS* OF listPagesByTags ***********************************************************************
  function listPageByTags($tags, $idType, $ids = true, $shortenText = false, $useHtml = true, $sortByCategories = false) {
    // call the right function
    return $this->listPagesByTags($tags, $idType, $ids, $shortenText, $useHtml, $sortByCategories);
  }
  // -> *ALIAS* OF listPagesByTags ***********************************************************************
  function listPageByTag($tags, $idType, $ids = true, $shortenText = false, $useHtml = true, $sortByCategories = false) {
    // call the right function
    return $this->listPagesByTags($tags, $idType, $ids, $shortenText, $useHtml, $sortByCategories);
  }  
  
  // -> START -- listPagesByDate **************************************************************************
  // RETURNs an Array of PAGEs, if they have a pageDate set and pagedate is activated in the category, AND its between the given month Number from now and in the past
  // * MORE OPTIONs in the PROPERTIES (TITLE and CONTENT layout)
  // ------------------------------------------------------------------------------------------------------
  function listPagesByDate($idType,                               // (String ["page", "pages" or "category", "categories"]) uses the given IDs for looking in the pages or categories
                                  $ids = true,                           // (false or Number or Array) the pages ID(s) or category ID(s) for the menu, if false it use VAR PRIORITY, if TRUE and $idType = "category", it loads all categories
                                  $monthsInThePast = true,               // (Boolean or Number) number of month BEFORE today, if TRUE it shows ALL PAGES FROM the PAST, if false it shows ONLY pages FROM TODAY
                                  $monthsInTheFuture = true,             // (Boolean or Number) number of month AFTER today, if TRUE it shows ALL PAGES IN the FUTURE, if false it shows ONLY pages UNTIL TODAY
                                  $shortenText = false,                   // (Boolean or Number) the Number of characters to shorten the content text
                                  $useHtml = true,                       // (Boolean) use html in the content text
                                  $sortByCategories = false,    // (Boolean) if TRUE it sorts the pages by categories and the sorting like in the feindura cms
                                  $flipList = false) {                   // (Boolean) if TRUE it flips the array with the listet pages
                                    
      return $this->listByDate('pages',$idType,$ids,$monthsInThePast,$monthsInTheFuture,$shortenText,$useHtml,$sortByCategories,$flipList);
  }
  // -> *ALIAS* OF listPagesByDate ***********************************************************************
  function listPageByDate($idType, $ids = true, $monthsInThePast = true, $monthsInTheFuture = true, $shortenText = false, $useHtml = true,$sortByCategories = false, $flipList = false) {
    // call the right function
    return $this->listPagesByDate($idType, $ids, $monthsInThePast, $monthsInTheFuture, $shortenText, $useHtml,$sortByCategories, $flipList);
  }
  // -> *ALIAS* OF listPagesByDate ***********************************************************************
  function listPageByDates($idType, $ids = true, $monthsInThePast = true, $monthsInTheFuture = true, $shortenText = false, $useHtml = true,$sortByCategories = false, $flipList = false) {
    // call the right function
    return $this->listPagesByDate($idType, $ids, $monthsInThePast, $monthsInTheFuture, $shortenText, $useHtml,$sortByCategories, $flipList);
  }  
  // -> *ALIAS* OF listPagesByDate ***********************************************************************
  function listPagesByDates($idType, $ids = true, $monthsInThePast = true, $monthsInTheFuture = true, $shortenText = false, $useHtml = true,$sortByCategories = false, $flipList = false) {
    // call the right function
    return $this->listPagesByDate($idType, $ids, $monthsInThePast, $monthsInTheFuture, $shortenText, $useHtml,$sortByCategories, $flipList);
  }  
  

}
?>