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
 * This file contains the {@link feindura} base <var>c0,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,lass</var>
 */ 

/**
* The basis <var>class</var> for the implimentation <var>classes</var>
* 
* It's methods provide necessary functions for the {@link feinduraPages} and the {@link feinduraModules} <var>classes</var>.
* 
* @author Fabian Vogelsteller <fabian@feindura.org>
* @copyright Fabian Vogelsteller
* @license http://www.gnu.org/licenses GNU General Public License version 3
* @version 1.56
*
*/
class feindura {
  
 /* ---------------------------------------------------------------------------------------------------------------------------- */
 /* *** PROPERTIES */
 /* **************************************************************************************************************************** */

 // PROTECTED
 // *********
  
 /**
  * Contains the session-ID, if cookies are deactivated
  * 
  * This session ID is then placed on the end of every link.    
  *      
  * @var string
  * @access protected
  */
  var $sessionId = null;
  
 /**
  * Contains the variable names used for the <var>$_GET</var> variables
  * 
  * This variable names are configured in the feindura adminstrator-settings and set in the {@link feindura()} constructor to the this property.<br>
  * For standard value see above.
  * 
  * Example of a link using the standard variable names:
  * <samp>
  * http://www.examplepage.com/index.php?category=1&page=6
  * </samp>
  * 
  * @var array
  * @see feindura()  
  * @access protected
  *   
  */
  var $varNames = array('page' => 'page', 'category' => 'category', 'modul' => 'modul');
                                 
  // PUBLIC
  // *********
    
 /**
  * Contains the administrator-settings config set in the CMS backend
  * 
  * The file with the administrator-settings is situated at <i>"feindura-CMS/config/admin.config.php"</i>.
  *   
  * This settings will be set to this property in the {@link feindura()} constructor.
  * 
  * @var array  
  * @see feindura::feindura()
  *    
  */
  var $adminConfig;

 /**
  * Contains the website-settings config set in the CMS backend
  * 
  * The file with the website-settings is situated at <i>"feindura-CMS/config/website.config.php"</i>.
  *   
  * This settings will be set to this property in the {@link feindura()} constructor.
  * 
  * @var array  
  * @see feindura::feindura()
  *   
  */
  var $websiteConfig;
  
 /**
  * Contains the categories-settings config set in the CMS backend
  * 
  * The file with the categories-settings is situated at <i>"feindura-CMS/config/category.config.php"</i>.
  *   
  * This settings will be set to this property in the {@link feindura()} constructor.
  * 
  * @var array  
  * @see feindura::feindura()
  *   
  */
  var $categoryConfig;
  
 /**
  * Contains a <var>instance</var> of the {@link generalFunctions::generalFunctions() generalFunctions} <var>class</var> for using in this <var>class</var>.
  * 
  * The file with the generalFunctions <var>class</var> is situated at <i>"feindura-CMS/library/classes/generalFunctions.class.php"</i>.
  *   
  * The <var>instance</var> will be set to this property in the {@link feindura()} constructor.
  * 
  * @var object  
  * @see feindura::feindura(), generalFunctions::generalFunctions()
  *   
  */
  var $generalFunctions;
  
 /**
  * Contains a <var>instance</var> of the {@link statisticFunctions::statisticFunctions() statisticFunctions} <var>class</var> for using in this <var>class</var>.
  * 
  * The file with the statisticFunctions <var>class</var> is situated at <i>"feindura-CMS/library/classes/statisticFunctions.class.php"</i>.
  * 
  * The <var>instance</var> will be set to this property in the {@link feindura()} constructor.
  * 
  * @var object  
  * @see feindura::feindura(), statisticFunctions::statisticFunctions()
  *   
  */
  var $statisticFunctions;
  
 /**
  * A country code (example: <i>de, en,</i> ..) to set the language of the frontend language-files.
  * 
  * This country code is used to include the right frontend language-file.
  * The frontend language-file is used when displaying page <i>warnings</i> or <i>errors</i> and additional texts like <i>"more"</i>, etc.<br>
  * This property will be set in the {@link feindura} constructor.
  * 
  * The standad value is <i>"de"</i> (german).
  *  
  * @var string
  * @see $languageFile, feindura()
  *   
  */  
  var $language = 'en';
  
 /**
  * Contains the frontend language-file array
  * 
  * The frontend language file array contains texts for displaying page <i>warnings</i> or <i>errors</i> and additional texts like <i>"more"</i>, etc.<br>
  * The file is situated at <i>"feindura-CMS/library/lang/de.frontend.php"</i>.
  *   
  * It will be <i>included</i> and set to this property in the {@link feindura()} constructor.
  * 
  * @var array  
  * @see feindura()
  *   
  */
  var $languageFile = null;
  
 
 /* ---------------------------------------------------------------------------------------------------------------------------- */
 /* *** METHODS *** */
 /* **************************************************************************************************************************** */
 
 /**
  * The constructor of the class, sets all basic properties
  *
  * <b>Type</b>     constructor<br>
  * <b>Name</b>     feindura()<br>
  *
  * First gets the settings config <var>arrays</var>,<br>
  * then set the <var>$_GET</var> variable names from the administrator-settings config to the {@link $varNames} property.<br>
  * Fetch the <var>$_GET</var> variable (if existing) and set it to the {@link $page} and {@link $category} properties.<br>
  * Check if cookies are activated, otherwise store the session ID in the {@link $sessionId} property for use in links.<br>
  * Get the frontend language-file adn set it to the {@link $languageFile} property.
  *
  *
  * <b>Used Global Variables</b><br>
  *    - <var>$adminConfig</var> array the administrator-settings config (included in the {@link general.include.php})
  *    - <var>$websiteConfig</var> array the website-settings config (included in the {@link general.include.php})
  *    - <var>$categoryConfig</var> array the categories-settings config (included in the {@link general.include.php})
  *
  * @param string $language (optional) A country code (example: de, en, ..) to load the right frontend language-file and is also set to the {@link $language} property 
  *
  * @uses $adminConfig            the administrator-settings config array will set to this property
  * @uses $websiteConfig          the website-settings config array will set to this property
  * @uses $categoryConfig         the category-settings config array will set to this property
  * @uses $generalFunctions       a generalFunctions class instance will set to this property
  * @uses $statisticFunctions     a statisticFunctions class instance will set to this property
  * @uses $varNames               the variable names from the administrator-settings config will set to this property
  * @uses $sessionId              the session ID string will set to this property, if cookies are deactivated
  * 
  * @return void
  *
  * @access public
  * 
  * @see general.include.php
  * @see feindura::feindura()
  *
  * @version 1.0
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.0 initial release
  *
  */
  function feindura($language = false) {   // (String) string with the COUNTRY CODE ("de", "en", ..)
    
    // GET CONFIG FILES and SET CONFIG PROPERTIES
    $this->adminConfig = $GLOBALS["adminConfig"];
    $this->websiteConfig = $GLOBALS["websiteConfig"];
    $this->categoryConfig = $GLOBALS["categoryConfig"];
    
    // GET FUNCTIONS
    $this->generalFunctions = new generalFunctions();
    $this->statisticFunctions = new statisticFunctions();
    
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
    $this->setCurrentCategory(true);           // $_GET['varNameCategory']  // first load category then the page, because getCurrentPage needs categories
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
      $this->language = $this->generalFunctions->getLanguage(true,false); // returns a COUNTRY SHORTNAME
    } else
      $this->language = $language;
    
    // includes the langFile
    if(file_exists(DOCUMENTROOT.$this->adminConfig['basePath'].'library/lang/'.$this->language.'.frontend.php'))
      $this->languageFile = include(DOCUMENTROOT.$this->adminConfig['basePath'].'library/lang/'.$this->language.'.frontend.php');
    
  }
  
 /**
  * Gets the current page ID from the <var>$_GET</var> variable
  *
  * <b>Type</b>     function<br>
  * <b>Name</b>     getCurrentPage()<br>
  * <b>Alias</b>    getPage()<br>
  *
  * Gets the current page ID from the <var>$_GET</var> variable.
  * If <var>$_GET</var> is not a ID but a page name, it loads all pages in an array and look for the right page name and returns the ID.
  * If no <var>$_GET</var> variable exists try to return the {@link $startPage} property.
  *
  * <b>Used Global Variables</b><br>
  *    - <var>$_GET</var> to fetch the page ID
  * 
  * @uses $varNames                  for variable names which the $_GET will use for the page ID
  * @uses $adminConfig               to look if set start-page is allowed
  * @uses loadPages()                for loading all pages to get the right page ID, if the $_GET variable is not a ID but a page name
  * @uses feinduraPages::$startPage  if no $_GET variable exists it will try to get the {@link $startPage} property
  * 
  * 
  * @return int|false the current page ID or FALSE
  * 
  * @access public
  *
  * @version 1.0
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.0 initial release
  *
  */
  function getCurrentPage() {
    
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
    } elseif($this->adminConfig['setStartPage'] && is_numeric($this->startPage)) {
      return $this->startPage;
    } else
      return false;
  }
 /**
  * Alias of {@link getCurrentPage()}
  * @ignore
  */
  function getPage() {
    // call the right function
    return $this->getCurrentPage();
  }

 /**
  * Gets the current category ID from the <var>$_GET</var> variable
  *
  * <b>Type</b>     function<br>
  * <b>Name</b>     getCurrentCategory()<br>
  * <b>Alias</b>    getCategory()<br>
  *
  * Gets the current category ID from the <var>$_GET</var> variable.
  * If <var>$_GET</var> is not a ID but a category name, it look in the {@link $categoryConfig} for the right category ID.
  * If no <var>$_GET</var> variable exists it try to return the {@link $startPage} property.
  *
  * <b>Used Global Variables</b><br>
  *    - <var>$_GET</var> to fetch the category ID
  *
  * @uses $varNames                for variable names which the $_GET variable will use for the category ID
  * @uses $adminConfig             to look if set start-page is allowed
  * @uses $categoryConfig          for the right category name, if the $_GET variable is not a ID but a category name
  * @uses feinduraPages::$startPage  if no $_GET variable exists it will try to get the {@link $startPage} property
  * 
  * @return int|false the current category ID or FALSE
  * 
  * @access public
  *
  * @version 1.0
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.0 initial release
  *
  */
  function getCurrentCategory() {
    
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
    } elseif($this->adminConfig['setStartPage'] && is_numeric($this->startCategory)) {
	
      return $this->startCategory;
    } else
      return false;
  }
 /**
  * Alias of {@link getCurrentCategory()}
  * @ignore
  */
  function getCategory() {
    // call the right function
    return $this->getCurrentCategory();
  }
  
 /**
  * Sets the current page ID from the <var>$_GET</var> variable to the {@link $page} property
  *
  * <b>Type</b>     function<br>
  * <b>Name</b>     setCurrentPage()<br>
  * <b>Alias</b>    setPage()<br>
  *
  * Gets the current page ID from the <var>$_GET</var> variable (through {@link getCurrentPage}) and set it to the {@link $page} property.
  * If the <var>$setStartPage</var> parameter is TRUE the {@link $startPage} property will also be set with the start-page ID from the {@link $websiteConfig}.
  *
  * @param bool $setStartPage (optional) If set to TRUE it also sets the {@link $startPage} property
  *
  * @uses $adminConfig      to check if setting a start-page is allowed
  * @uses $websiteConfig    to get the start-page ID
  * @uses $page             as the property to set
  * @uses $startPage        if the $setStartPage parameter is TRUE this property will also be set
  * 
  * @return int|false the set page ID or FALSE
  * 
  * @access public
  *
  * @version 1.0
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.0 initial release
  *
  */
  function setCurrentPage($setStartPage = false) {  // (bool) if TRUE it sets the startPage  
    
    // sets the startPage if it exists
    if($setStartPage === true && $this->adminConfig['setStartPage'] && !empty($this->websiteConfig['startPage'])) {
      $this->startPage = $this->websiteConfig['startPage'];
    }
      
    // sets the new page PROPERTY
    $this->page = $this->getCurrentPage();
      
    return $this->page;
  }
 /**
  * Alias of {@link setCurrentPage()}
  * @ignore
  */
  function setPage($setStartPage = false) {
    // call the right function
    return $this->setCurrentPage($setStartPage);
  }
  
 /**
  * Sets the current category ID from the <var>$_GET</var> variable to the {@link $category} property
  *
  * <b>Type</b>     function<br>
  * <b>Name</b>     setCurrentCategory()<br>
  * <b>Alias</b>    setCategory()<br>
  *
  * Gets the current category ID from the <var>$_GET</var> variable (through {@link getCurrentCategory}) and set it to the {@link $category} property.
  * If the <var>$setStartCategory</var> parameter is TRUE the {@link $startCategory} property will also be set with the start-page ID from the {@link $websiteConfig}.
  *
  * @param bool $setStartCategory (optional) If set to TRUE it also sets the {@link $startCategory} property
  *
  * @uses $adminConfig      to check if setting a start-page is allowed
  * @uses $websiteConfig    to get the start-page ID
  * @uses $category         as the property to set
  * @uses $startCategory    if the $setStartCategory parameter is TRUE this property will also be set
  * @uses getPageCategory() to get the right category ID of the start-page
  *
  * @return int|false the set category ID or FALSE
  *
  * @access public
  * 
  * @version 1.0
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.0 initial release
  *
  */
  function setCurrentCategory($setStartCategory = false) {
    
    // sets the startPage if it exists
    if($setStartCategory === true && $this->adminConfig['setStartPage'] && !empty($this->websiteConfig['startPage'])) {   
      $this->startCategory = $this->getPageCategory($this->websiteConfig['startPage']);
    }
    
    // sets the new category PROPERTY
    $this->category = $this->getCurrentCategory();
    
    return $this->category;
  }
 /**
  * Alias of {@link setCurrentCategory()}
  * @ignore
  */
  function setCategory() {
    // call the right function
    return $this->setCurrentCategory();
  }
  
  
 /* ---------------------------------------------------------------------------------------------------------------------------- */
 /* *** PROTECTED METHODS *** */
 /* **************************************************************************************************************************** */

 /**
  * Generates a page
  *
  * <b>Type</b>     function<br>
  * <b>Name</b>     generatePage()<br>
  *
  * This method is called in descendant classes.<br>
  * Generates a page by the given page ID.
  * The returned page array is structured in this order:<br>
  * title, the page thumbnail and then the content, depending on the respective properties.
  *
  * In case the page doesnt exists or is not public an error is shown (depending on the <var>$showError</var> parameter <b>AND</b> the {@link feinduraPages::$showError} property,
  * otherwise it returns an empty array.<br>
  * The error will be then displayed in the <var>array['content']</var> variable.
  * 
  * Example of the returned array:
  * <code>
  * array(
  *	   ['pageDate'] = '2000-12-31', // formated depending on the administrator-settings
  *	   ['title'] = 'Title Example',
  *	   ['thumbnail'] = '<img src="/path/image.png" alt="Image Title" title="Image Title" />',
  *	   ['thumbnailPath'] = '<img src="/path/image.png" alt="Image Title" title="Image Title" />',
  *	   ['content'] = '<p>Content Text..</p>',
  *	   ['tags'] = 'tag1 tag2 tag3',
  *	   ['plugins'] = array (?)
  *     )
  * </code>
  *
  * @param int|array  $page          page ID or a $pageContent array
  * @param bool       $showError     (optional) tells if errors like "The page you requested doesn't exist" will be displayed
  * @param int|false  $shortenText   (optional) number of the maximal text length shown, adds a "more" link at the end or FALSE to not shorten
  * @param bool       $useHtml       (optional) displays the page content with or without HTML tags
  *
  * 
  * @uses adminConfig				  for the thumbnail upload path
  * @uses categoryConfig			  to check whether the category of the page allows thumbnails
  * @uses $languageFile				  for the error texts
  * @uses publicCategory()			  to check whether the category is public
  * @uses createTitle()				  to create the page title
  * @uses createThumbnail()			  to check to show thumbnails are allowed and create the thumbnail <img> tag
  * @uses createAttributes()			  to create the attributes used in the error tag
  * @uses shortenHtmlText()			  to shorten the HTML page content
  * @uses shortenText()				  to shorten the non HTML page content, if the $useHtml parameter is FALSE
  * @uses statisticFunctions::formatDate()	  to format the page date for output
  * @uses generalFunctions::dateDayBeforeAfter()  check if the page date is "yesterday" "today" or "tomorrow"
  * @uses feinduraPages::$xHtml
  * @uses feinduraPages::$showError
  * @uses feinduraPages::$errorTag
  * @uses feinduraPages::$errorId
  * @uses feinduraPages::$errorClass
  * @uses feinduraPages::$errorAttributes
  * @uses feinduraPages::$titleLength
  * @uses feinduraPages::$titleAsLink
  * @uses feinduraPages::$titleShowCategory
  * @uses feinduraPages::$titleShowPageDate 
  * @uses feinduraPages::$thumbnailId
  * @uses feinduraPages::$thumbnailClass
  * @uses feinduraPages::$thumbnailAttributes
  * @uses feinduraPages::$thumbnailAlign
  * @uses feinduraPages::$thumbnailBefore
  * @uses feinduraPages::$thumbnailAfter  
  * 
  * @return array the generated page array, ready to display in a HTML file
  *
  * @access protected
  *
  * @version 1.0
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.0 initial release
  *
  */
  function generatePage($page, $showError = true, $shortenText = false, $useHtml = true) {
    
    // vars   
    $return['pageDate'] = false;
    $return['title'] = false;
    $return['thumbnail'] = false;
    $return['thumbnailPath'] = false;
    $return['content'] = false;
    $return['tags'] = false;
    $return['plugins'] = false;

    // ->> CHECKS
    // -------------------
    
    // LOOKS FOR A GIVEN PAGE, IF NOT STOP THE METHOD
    if(!is_numeric($page) && !is_array($page))
      return array();
    
    // -> sets the ERROR SETTINGS
    // ----------------------------
    if($showError && $this->showError) {
      // adds ATTRIBUTES  
      $errorStartTag = '';
      $errorEndTag = '';
      $errorAttributes = $this->createAttributes($this->errorId, $this->errorClass, $this->errorAttributes);
      
      if(is_string($this->errorTag)) { //|| !empty($errorAttributes)
	// set tag
        $errorTag = $this->errorTag;
	// or uses standard tag
        //else $errorTag = 'span';
                  
        $errorStartTag = '<'.$errorTag.$errorAttributes.'>';
        $errorEndTag = '</'.$errorTag.'>';
      }
    }
    
    // ->> LOAD the pageContent ARRAY
    // -> checks if $page is an pageContent Array
    if(is_array($page) && array_key_exists('id',$page)) {
      $pageContent = $page;
      
    // $page is NUMBER
    } else {
      // gets the category of the page
      $category = $this->getPageCategory($page);
      
      // -> if not try to load the page
      if(!$pageContent = $this->readPage($page,$category)) {
        // if could not load throw ERROR
        if($showError && $this->showError) {
	  $return['content'] = $errorStartTag.$this->languageFile['error_noPage'].$errorEndTag; // if not throw error and and the method
          return $return;
        } else
          return array();
      }
    }

    
    // -> PAGE is PUBLIC? if not throw ERROR
    if(!$pageContent['public'] || $this->publicCategory($pageContent['category']) === false) {
      if($showError && $this->showError) {
        $return['content'] = $errorStartTag.$this->languageFile['error_pageClosed'].$errorEndTag; // if not throw error and and the method
        return $return; 
      } else
        return array();
    }
    
    // ->> BEGINNING TO BUILD THE PAGE
    // -------------------
    
    // -> PAGE DATE
    // *****************
    if($this->generalFunctions->checkPageDate($pageContent)) {
	$titleDateBefore = '';
	$titleDateAfter = '';
	// adds spaces on before and after
	if($pageContent['pagedate']['before']) $titleDateBefore = $pageContent['pagedate']['before'].' ';
	if($pageContent['pagedate']['after']) $titleDateAfter = ' '.$pageContent['pagedate']['after'];
	$pagedate = $titleDateBefore.$this->statisticFunctions->formatDate($this->generalFunctions->dateDayBeforeAfter($pageContent['pagedate']['date'],$this->languageFile)).$titleDateAfter;
    }
      
    // -> PAGE TITLE
    // *****************
    $title = '';
    if(!empty($pageContent['title']))
      $title = $this->createTitle($pageContent,
				  $this->titleCategorySpacer,
                                  $this->titleLength,
                                  $this->titleAsLink,
                                  $this->titleShowCategory,
                                  $this->titleShowPageDate);      
      
    // -> PAGE THUMBNAIL
    // *****************
    $returnThumbnail = false;
    if($pageThumbnail = $this->createThumbnail($pageContent))
      $returnThumbnail = $pageThumbnail;
    
    // ->> MODIFING pageContent
    // ************************
    if(!empty($pageContent['content'])) {
      $pageContentEdited = $pageContent['content'];
      
      /*
      // -> adds ATTRIBUTES
      // -----------------------
      $contentStartTag = '';
      $contentEndTag = '';
      $contentAttributes = $this->createAttributes($this->contentId, $this->contentClass, $this->contentAttributes);
        
      if($this->contentTag || !empty($contentAttributes)) {
	  
	// set tag
        if(is_string($this->contentTag)) $contentTag = $this->contentTag;
	// or uses standard tag
        else $contentTag = 'div';
                  
        $contentStartTag = '<'.$contentTag.$contentAttributes.'>';
        $contentEndTag = '</'.$contentTag.'>';        
      }
      */
      
      // clear Html tags?
      if(!$useHtml)
        $pageContentEdited = strip_tags($pageContentEdited);
      
      // -> SHORTEN CONTENT   
      if($shortenText && $shortenText !== true) {
        // -> SET the PROPERTY $contentLength
        //if($shortenText === true)
          //$shortenText = $this->contentLength; // standard preview length
  
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
    
    /* 
    // CHECK if the CONTENT BEFORE & AFTER is !== true
    $contentBefore = false;
    $contentAfter = false;    
    
    if($this->contentBefore !== true)
      $contentBefore = $this->contentBefore;
    if($this->contentAfter !== true)
      $contentAfter = $this->contentAfter;
    */
    
    // -> RETURNING the PAGE ELEMENTS
    // *******************
    if($pagedate)
       $return['pageDate']  = $pagedate."\n";
       
    if(!empty($pageContent['title']))
       $return['title']	    = $title."\n";
       
    if($returnThumbnail) {
       $return['thumbnail'] = $returnThumbnail['thumbnail']."\n";
       $return['thumbnailPath'] = $returnThumbnail['thumbnailPath']."\n";
    }
       
    if(!empty($pageContent['content']))
       $return['content']   = $pageContentEdited."\n"; //$contentBefore.$contentStartTag.$pageContentEdited.$contentEndTag.$contentAfter;
       
    if(!empty($pageContent['tags']))
       $return['tags']   = $pageContent['tags']."\n";
    
    
    /*
    // adds breaks before and after
    $return = "\n".$return."\n";    
    // removes double breaks
    $return = preg_replace("/\\n+/","\n",$return);
    */
    
    // -> AFTER all RETURN $return
    // *****************
    return $return;
  }  
  
 /**
  * Generates a page title
  *
  * <b>Type</b>     function<br>
  * <b>Name</b>     createTitle()<br>
  *
  * Generates a page title from a given <var>$pageContent</var> array by using the given parameters.
  *
  *
  * @param array   $pageContent                 the $pageContent Array of a page
  * @param string  $titleTag                    (optional) the HTML tag which is used to surround the title text
  * @param string  $titleId                     (optional) the ID which is used in the title tag
  * @param string  $titleClass                  (optional) the CLASS which is used in the title tag
  * @param string  $titleAttributes             (optional) a String with Attributes like: 'key="value" key2="value2"'
  * @param string  $titleCategorySpacer         (optional) string to seperate the category name and the title text, if the $titleShowCategory parameter is TRUE
  * @param int	   $titleLength                 (optional) number of the maximal text length shown or FALSE to not shorten
  * @param bool    $titleAsLink                 (optional) if TRUE, it creates the title as link
  * @param bool    $titleShowCategory           (optional) if TRUE, it shows the category name before the title text, and uses the $titleShowCategory parameter string between both
  * @param bool	   $titleShowPageDate           (optional) if TRUE, it shows the page date before the title text
  *
  * 
  * @uses categoryConfig			  to check if showing the page date is allowed and for the category name
  * @uses languageFile				  for showing "yesterday", "today" or "tomorrow" instead of a page date
  * @uses statisticFunctions			  to check whether the page date is valid and format the page date
  * @uses shortenText()				  to shorten the title text, if the $titleLength parameter is TRUE
  * @uses createHref()				  to create the href if the $titleAsLink parameter is TRUE
  * @uses statisticFunctions::formatDate()	  to format the title date for output
  * @uses generalFunctions::dateDayBeforeAfter()  check if the title date is "yesterday" "today" or "tomorrow"
  * 
  * @return string the generated title string ready to display in a HTML file
  *
  * @access protected
  *
  * @see feinduraPages::showPageTitle()
  *
  * @example showPageTitle.example.php the called showPageTitle() method in this example calls this method with the title properties as parameters
  *
  * @version 1.0
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.0 initial release
  *
  */
  function createTitle($pageContent, $titleCategorySpacer = false, $titleLength = false, $titleAsLink = false, $titleShowCategory = false, $titleShowPageDate = false) {
      
      // vars 
      $titleBefore = '';
      $titleAfter = '';
      
      // saves the long version of the title, for the title="" tag
      $fullTitle = strip_tags($pageContent['title']);
           
      // generate titleDate
      if($titleShowPageDate && $this->generalFunctions->checkPageDate($pageContent)) {
         $titleDateBefore = '';
         $titleDateAfter = '';
	 // adds spaces on before and after
         if($pageContent['pagedate']['before']) $titleDateBefore = $pageContent['pagedate']['before'].' ';
         if($pageContent['pagedate']['after']) $titleDateAfter = ' '.$pageContent['pagedate']['after'];
         $titleDate = $titleDateBefore.$this->statisticFunctions->formatDate($this->generalFunctions->dateDayBeforeAfter($sortedDate,$this->languageFile)).$titleDateAfter.' ';
      } else $titleDate = false;      
      
      // shorten the title
      if(is_numeric($titleLength) && strlen($fullTitle) > $titleLength)
        $title = $this->shortenText($fullTitle, $titleLength, false, "..");
      else
        $title = $fullTitle;
        
      // show the category name
      if($titleShowCategory === true && $pageContent['category'] != 0) {
        if(is_string($titleCategorySpacer))
          $titleShowCategory = $this->categoryConfig['id_'.$pageContent['category']]['name'].$titleCategorySpacer; // adds the Spacer
        else
          $titleShowCategory = $this->categoryConfig['id_'.$pageContent['category']]['name'].' ';
      }      
        
      // generate titleBefore without tags
      $titleBefore = $titleShowCategory.$titleDate;
      
      /*
      // dont put titleTextBefore/After if $inLink is TRUE
      if($inLink === false) {
        // CHECK if the TITLE BEFORE & AFTER is !== true
        if($this->titleBefore !== true)
          $titleBefore = $this->titleBefore.$titleBefore;
        if($this->titleAfter !== true)
          $titleAfter = $this->titleAfter;
      }
      */
      
      // generates the title for the title="" tag
      $titleTagText = $titleBefore.$fullTitle.$titleAfter;
            
      // create a link for the title
      if($titleAsLink) {        
        $titleBefore = '<a href="'.$this->createHref($pageContent).'" title="'.$titleTagText.'">'.$titleBefore;
        $titleAfter = $titleAfter.'</a>';
      }/* else {
        $titleBefore = '<span title="'.$titleTagText.'">'.$titleBefore;
        $titleAfter = $titleAfter.'</span>';
      }   
      */   
      
      /*  
      // -------------------------------
      // adds ATTRIBUTES
      $titleStartTag = '';
      $titleEndTag = '';
      $titleTagAttributes = $this->createAttributes($titleId, $titleClass, $titleAttributes);
        
      if($titleTag || !empty($titleTagAttributes)) {
      
        // set tag
        if(is_string($titleTag)) $titleTag = $titleTag;
	// or uses standard tag
        else $titleTag = 'span';
                  
        $titleStartTag = '<'.$titleTag.$titleTagAttributes.'>';
        $titleEndTag = '</'.$titleTag.'>';
      }
      */
 
      // -> builds the title
      // *******************
      //$title = $titleStartTag.$titleBefore.$title.$titleAfter.$titleEndTag;
      $title = $titleBefore.$title.$titleAfter;
      
      // returns the title
      return $title;
  }

 /**
  * Generates a thumbnail <img> tag
  *
  * <b>Type</b>     function<br>
  * <b>Name</b>     createThumbnail()<br>
  *
  * Generates a thumbnail <img> tag from the given <var>$pageContent</var> array and
  * returns an array with the ready to display tag and the plain thumbnail path.
  *
  *
  * @param array $pageContent           the $pageContent array of a page
  * 
  * @uses adminConfig                   for the thumbnail path
  * @uses categoryConfig                to check if thumbnails are allowed for the th category of this page
  * @uses createAttributes()		to create the attributes used in the thumbnail <img> tag
  * 
  * @return array|false the generated thumbnail <img> tag and a the plain thumbnail path or FALSE if no thumbnail exists or is not allowed to show
  *
  * @access protected
  *
  *
  * @version 1.0
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.0 initial release
  *
  */
  function createThumbnail($pageContent) {
      
    // ->> CHECK if thumbnail exists and is allowed to show
    if(!empty($pageContent['thumbnail']) &&
      @is_file(DOCUMENTROOT.$this->adminConfig['uploadPath'].$this->adminConfig['pageThumbnail']['path'].$pageContent['thumbnail']) &&
      (($pageContent['category'] == '0' && $this->adminConfig['page']['thumbnailUpload']) ||
      ($pageContent['category'] && $this->categoryConfig['id_'.$pageContent['category']]['thumbnail']))) {
      
      // set TAG ENDING (xHTML or HTML) 
      if($this->xHtml === true) $tagEnding = ' />';
      else $tagEnding = '>';
      
      // adds ATTRIBUTES and/or FLOAT

      $thumbnailAttributes = $this->createAttributes($this->thumbnailId, $this->thumbnailClass, $this->thumbnailAttributes);
      
      // thumbnail FLOAT
      if(strtolower($this->thumbnailAlign) === 'left' ||
         strtolower($this->thumbnailAlign) === 'right')
        $thumbnailAttributes .= ' style="float:'.strtolower($this->thumbnailAlign).';"';
      
      // CHECK if the THUMBNAIL BEFORE & AFTER is !== true
      $thumbnailBefore = '';
      $thumbnailAfter = '';

      if($this->thumbnailBefore !== true)
	$thumbnailBefore = $this->thumbnailBefore;
      if($this->thumbnailAfter !== true)
        $thumbnailAfter = $this->thumbnailAfter;
      
      $pageThumbnail['thumbnail'] = $thumbnailBefore.'<img src="'.$this->adminConfig['uploadPath'].$this->adminConfig['pageThumbnail']['path'].$pageContent['thumbnail'].'" alt="'.$pageContent['title'].'" title="'.$pageContent['title'].'"'.$thumbnailAttributes.$tagEnding.$thumbnailAfter;
      $pageThumbnail['thumbnailPath'] = $this->adminConfig['uploadPath'].$this->adminConfig['pageThumbnail']['path'].$pageContent['thumbnail'];
      
      return $pageThumbnail;
    } else 
      return false;      
  }

 /**
  * Generates a string with a given id, class and other attributes
  *
  * <b>Type</b>     function<br>
  * <b>Name</b>     createAttributes()<br>
  *
  * Check whether the given parameters are strings or numbers and add them to a string with attributes.
  * 
  * Example return:
  * <samp>
  * 'id="exampleId" class="exampleClass" key="value"'
  * </samp>
  *
  * @param string|number  $id           a HTML id attribute value
  * @param string|number  $class        a HTML class attribute value
  * @param string|number  $attributes   one or more 'key="values"' attributes
  *
  * @return string the generated attribute string
  *
  * @access protected
  *
  * @version 1.0
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.0 initial release
  *
  */
  function createAttributes($id, $class, $attributes) {
  
      $attributeString = '';
      
      // add ID
      if(is_string($id) || is_numeric($id))
        $attributeString .= ' id="'.$id.'"';
	
      // add CLASS
      if(is_string($class) || is_numeric($class))
        $attributeString .= ' class="'.$class.'"';
      
      // add ATTRIBUTES
      if(is_string($attributes) || is_numeric($attributes))
	$attributeString .= ' '.$attributes;
        
      return $attributeString;    
  }
  
 /**
  * Loads the <var>$pageContent</var> array of a page
  *
  * @uses generalFunctions::readPage()
  * @see generalFunctions::readPage()
  *
  */
  function readPage($page, $category = false) {
    //echo 'PAGE: '.$page.' -> '.$category.'<br />';

    return $this->generalFunctions->readPage($page,$category);
  }

 /**
  * Loads the <var>$pageContent</var> arrays of a pages in a specific category or all categories
  *
  * @uses generalFunctions::loadPages()
  * @see generalFunctions::loadPages()
  *
  */
  function loadPages($category = false, $loadPagesInArray = true) {

    return $this->generalFunctions->loadPages($category,$loadPagesInArray);
  }
  
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
        
        // if its an array with $pageContent arrays -> return this
        if(isset($ids[0]) && is_array($ids[0]) && array_key_exists('id',$ids[0])) {
          return $ids;
        
        // otherwise load the pages from the category(ies)
        } else {
          // checks if the categories are public
          $ids = $this->publicCategory($ids);
          
          if($ids !== false) {

	    // returns the loaded pages from the CATEGORY IDs
	    // the pages in the returned array also get SORTED
            return $this->loadPages($ids);

          } else return false;
        }
      } else return false;
      
    // ->> if PAGE ID(s)
    // **************************
    } elseif($idType == 'page' || $idType == 'pages') {
      
      // -----------------------------------------     
      // ->> load all pages
      // *************** 
      if($ids === true) {
	
	return $this->loadPages($ids);
      
      // -----------------------------------------    
      // ->> pages IDs
      // ***************
      } elseif($ids && is_array($ids)) {
        
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

 /**
  * Gets the category ID of a page
  *
  * @uses generalFunctions::getPageCategory()
  * @see generalFunctions::getPageCategory()
  *
  */
  function getPageCategory($page) {

    return $this->generalFunctions->getPageCategory($page);
  }

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
          
          // NEXT
          if($direction == 'next' && (($count + 1) < count($categoryOfPage)))
            return $categoryOfPage[($count + 1)];
          // PREV
          elseif($direction == 'prev' && (($count - 1) >= 0))
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
  // returns the pageContent Array which have the tags in it, otherwise false
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
  // RETURNs PAGEs, if they have a pageDate set and pagedate is activated in the category, AND its between the given month Number from now and in the past
  // ------------------------------------------------------------------------------------------------------
  function listByDate($type,                                 // (String ["menu" or "pages"]) set the type of the listByDate
                                $idType,                               // (String ["page", "pages" or "category", "categories"]) uses the given IDs for looking in the pages or categories
                                $ids = true,                           // (false or Number or Array) the pages ID(s) or category ID(s) for the menu, if false it use VAR PRIORITY, if TRUE and $idType = "category", it loads all categories
                                $monthsInThePast = true,               // (Boolean or Number) number of month BEFORE today, if TRUE it shows ALL PAGES FROM the PAST, if false it shows ONLY pages FROM TODAY
                                $monthsInTheFuture = true,             // (Boolean or Number) number of month AFTER today, if TRUE it shows ALL PAGES IN the FUTURE, if false it shows ONLY pages UNTIL TODAY                                
                                $shortenTextORlinkText = false,        // (Boolean or Number or String)  the Number of characters to shorten the content text OR the TEXT used for the links, if TRUE it USES the TITLE of the pages
                                $useHtmlORmenuTag = true,              // (Boolean or String) use html in the content text OR the TAG used for the Menu, if TRUE it uses the menuTag from the PROPERTY
                                $sortByCategories = false,    // (Boolean) if TRUE it sorts the pages by categories and the sorting like in the feindura cms
                                $breakAfter = false,                   // (Boolean or Number) if TRUE it makes a br behind each <a..></a> element, if its a NUMBER AND the menuTag IS "table" it breaks the rows after the given Number 
                                $flipList = false) {                   // (Boolean) if TRUE it flips the array with the listet pages

    if(!is_bool($monthsInThePast) && is_numeric($monthsInThePast))
      $monthsInThePast = round($monthsInThePast);
    if(!is_bool($monthsInTheFuture) && is_numeric($monthsInTheFuture))
      $monthsInTheFuture = round($monthsInTheFuture);
    
    $idType = strtolower($idType);
    // USES the PRIORITY: 1. -> page var 2. -> PROPERTY page var 3. -> false
    if(!$ids) {
      if($idType == 'page'|| $idType == 'pages')
        // USES the PRIORITY: 1. -> pages var 2. -> PROPERTY pages var 3. -> false
        $ids = $this->getPropertyPage($ids);      
      if($idType == 'page' || $idType == 'pages')
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
        if(!empty($page['pagedate']['date']) &&
           ($page['category'] != 0 && $this->categoryConfig['id_'.$page['category']]['showpagedate'])) {
           
           // makes the page sort date compareable
           $pageDate = str_replace('-','',$page['pagedate']['date']);
           
           //echo 'pageDate: '.$pageDate.'<br /><br />';           
           
           // adds the page to the array, if:
           // -> the currentdate ist between the minus and the plus month or
           // -> mins or plus month are true (means there is no time limit)
           if(($monthsInThePast === true || $pageDate >= $pastDate) &&
              ($monthsInTheFuture === true || $pageDate <= $futureDate))
             $selectedPages[] = $page;
        }
      }      
      
      // -> SORT the pages BY DATE
      // sort by DATE and GIVEN ARRAY
      if($sortByCategories === false)
        usort($selectedPages,'sortByDate');
      // sorts by DATE and CATEGORIES
      else
        $selectedPages = $this->generalFunctions->sortPages($selectedPages,'sortByDate');
      
      // -> flips the sorted array if $flipList === true
      if($flipList === true)
        $selectedPages = array_reverse($selectedPages);
      
      
      // -> LIST the pages    
      if($type == 'pages') {        
        return $this->listPages($idType,$selectedPages,$shortenTextORlinkText,$useHtmlORmenuTag,$sortByCategories);
      
      // OR  
      // -> CREATE MENU of the pages
      } elseif($type == 'menu')  {
        return $this->createMenu($idType,$selectedPages,$shortenTextORlinkText,$useHtmlORmenuTag,$breakAfter,$sortByCategories);  
      }  
      
      /*
      foreach($selectedPages as $page) {
        // show the pages, if they have a date which can be sorten
                   
        if($pageContent = $this->generatePage($page,false,$shortenText,$useHtml)) {
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
                                  $addMonths = true) {    // (Boolean) the math to use, if TRUE it ADD months if false it SUBTRACT months
    
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
  // if given pages var if false it sets the PAGES PROPERTY
  // ------------------------------------------------------------------------------------------------
  /*
  function getPropertyPages($pages = false) { // (false or Array)
    if($pages === false && is_array($this->pages))
      $pages = $this->pages;  // set the pages var from PROPERTY var

    return $pages;
  }
  */
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

 /**
  * Gets the {@link generalFunctions::$storedPageIds} property
  *
  * @uses generalFunctions::getStoredPageIds()
  * @see generalFunctions::getStoredPageIds()
  *
  */
  function getStoredPageIds() {

    return $this->generalFunctions->getStoredPageIds();
  }

 /**
  * Gets the {@link generalFunctions::$storedPages} property
  *
  * @uses generalFunctions::getStoredPages()
  * @see generalFunctions::getStoredPages()
  *
  */
  function getStoredPages() {

    return $this->generalFunctions->getStoredPages();
  }
  
  // -> START -- shortenText *******************************************************************************
  // shortens a text by the given length number
  // -------------------------------------------------------------------------------------------------------
  function shortenText($string,                   // (String) the string which will be shorten
                                 $length,                   // (Number) the number of characters to which the text will be shorten 
                                 $pageContent = false,      // (false or Array) the pageContent Array of the Page
                                 $endString = " ...") {     // (String) the string add to the end of the shorten text
      
      // cut string
      if(is_numeric($length)) {
        // gets real length, if there are htmlentities like &auml; &uuml; etc
        $length = $this->generalFunctions->getRealCharacterNumber($string,$length);
        $shortenString = substr($string,0,$length);
      }

      // adds $endString only if text was shorten
      if($length < strlen($string)) {
        // search last whitespace and cut until there
        $shortenString = substr($shortenString, 0, strrpos($shortenString, ' '));
      
        // adds the endString
        if(is_string($endString))
          $shortenString .= $endString;
      }
      
      // adds the MORE LINK
      if($endString !== false && $pageContent !== false && is_array($pageContent)) {
        $shortenString .= ' <a href="'.$this->createHref($pageContent).'">'.$this->languageFile['page_more'].'</a>';
      }
      
      $shortenString = preg_replace("/ +/", ' ', $shortenString);
      
      return $shortenString;
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