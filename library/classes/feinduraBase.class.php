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
 * This file contains the {@link feindura} base class.
 * 
 * @package [Implementation]
 */ 
/**
* The basis feindura class for the implementation classes
* 
* It's methods provide necessary functions for the {@link feindura} and the {@link feinduraModules} <var>classes</var>.
* 
* @author Fabian Vogelsteller <fabian@feindura.org>
* @copyright Fabian Vogelsteller
* @license http://www.gnu.org/licenses GNU General Public License version 3
* 
* @package [Implementation]
* 
* @version 1.58
* <br />
* <b>ChangeLog</b><br />
*    - 1.58 add phpDocumentor documentation
*    - 1.57 startet documentation
*/
class feinduraBase {
  
 /* ---------------------------------------------------------------------------------------------------------------------------- */
 /* *** PROPERTIES */
 /* **************************************************************************************************************************** */

 // PROTECTED
 // *********
  
 /**
  * Is TRUE when the user is logged into the backend of feindura and visits the frontend website.
  * If TRUE, it will enable the the frontend editing feature.  
  * 
  * 
  * @var bool
  */
  var $loggedIn = false;
  
 /**
  * Contains the session-ID, if cookies are deactivated
  * 
  * This session ID is then placed on the end of every link.
  *      
  * @var string
  */
  var $sessionId = null;
  
 /**
  * Contains the variable names used for the <var>$_GET</var> variables
  * 
  * This variable names are configured in the feindura adminstrator-settings and set in the {@link feinduraBase()} constructor to the this property.<br />
  * For standard value see above.
  * 
  * Example of a link using the standard variable names:
  * <samp>
  * http://www.examplepage.com/index.php?category=1&page=6
  * </samp>
  * 
  * @var array
  * @see feinduraBase()
  *   
  */
  var $varNames = array('page' => 'page', 'category' => 'category', 'modul' => 'modul');
                                 
  // PUBLIC
  // *********
    
 /**
  * Contains the administrator-settings and the page-settings set in the CMS backend
  * 
  * The file with the administrator-settings config array is situated at <i>"feindura-CMS/config/admin.config.php"</i>.
  *   
  * This settings will be set to this property in the {@link feinduraBase()} constructor.
  * 
  * Example array:
  * {@example backend/adminConfig.array.example.php}
  * 
  * @var array  
  * @see feinduraBase::feinduraBase()
  * 
  */
  var $adminConfig;

 /**
  * Contains the website-settings config set in the CMS backend
  * 
  * The file with the website-settings config array is situated at <i>"feindura-CMS/config/website.config.php"</i>.
  *   
  * This settings will be set to this property in the {@link feinduraBase()} constructor.
  * 
  * Example array:
  * {@example backend/websiteConfig.array.example.php}
  * 
  * @var array  
  * @see feinduraBase::feinduraBase()
  * 
  */
  var $websiteConfig;
  
 /**
  * Contains the categories-settings config set in the CMS backend
  * 
  * The file with the categories-settings config array is situated at <i>"feindura-CMS/config/category.config.php"</i>.
  *   
  * This settings will be set to this property in the {@link feinduraBase()} constructor.
  * 
  * Example array:
  * {@example backend/categoryConfig.array.example.php}
  * 
  * @var array
  * @see feinduraBase::feinduraBase()
  * 
  */
  var $categoryConfig;
  
 /**
  * Contains the plugin-settings config set in the CMS backend
  * 
  * The file with the plugin-settings config array is situated at <i>"feindura-CMS/config/plugin.config.php"</i>.
  *   
  * This settings will be set to this property in the {@link feinduraBase()} constructor.
  * 
  * Example array:
  * {@example backend/pluginsConfig.array.example.php}
  * 
  * @var array
  * @see feinduraBase::feinduraBase()
  * 
  */
  var $pluginsConfig;
  
  
 /**
  * A country code (example: <i>de, en,</i> ..) to set the language of the frontend language-files
  * 
  * This country code is used to include the right frontend language-file.
  * The frontend language-file is used when displaying page <i>warnings</i> or <i>errors</i> and additional texts like <i>"more"</i>, etc.<br />
  * This property will be set in the {@link feindura} constructor.
  * 
  * The standard value is <i>"en"</i> (english).
  *  
  * @var string
  * @see $languageFile
  * @see feinduraBase()
  *   
  */  
  var $language = 'en';
  
 /**
  * Contains the frontend language-file array
  * 
  * The frontend language file array contains texts for displaying page <i>warnings</i> or <i>errors</i> and additional texts like <i>"more"</i>, etc.<br />
  * The file is situated at <i>"feindura-CMS/library/languages/de.frontend.php"</i>.
  *   
  * It will be <i>included</i> and set to this property in the {@link feinduraBase()} constructor.
  * 
  * @var array  
  * @see feinduraBase()
  * 
  */
  var $languageFile = null;  

 /**
  * Contains a <var>instance</var> of the {@link generalFunctions::generalFunctions() generalFunctions} <var>class</var> for using in this <var>class</var>
  * 
  * The file with the {@link generalFunctions::generalFunctions() generalFunctions} class is situated at <i>"feindura-CMS/library/classes/generalFunctions.class.php"</i>.<br />   
  * A instance of the {@link generalFunctions::generalFunctions() generalFunctions} class will be set to this property in the {@link feinduraBase()} constructor.
  * 
  * @var class
  * @see feinduraBase()
  * @see generalFunctions::generalFunctions()
  *   
  */
  var $generalFunctions;
  
 /**
  * Contains a <var>instance</var> of the {@link statisticFunctions::statisticFunctions() statisticFunctions} <var>class</var> for using in this <var>class</var>
  * 
  * The file with the {@link statisticFunctions::statisticFunctions() statisticFunctions} class is situated at <i>"feindura-CMS/library/classes/statisticFunctions.class.php"</i>.<br />
  * A instance of the {@link statisticFunctions::statisticFunctions() statisticFunctions} class will be set to this property in the {@link feinduraBase()} constructor.
  * 
  * @var class
  * @see feinduraBase()
  * @see statisticFunctions::statisticFunctions()
  * 
  */
  var $statisticFunctions;

  
 
 /* ---------------------------------------------------------------------------------------------------------------------------- */
 /* *** CONSTRUCTOR *** */
 /* **************************************************************************************************************************** */
 
 /**
  * <b> Type</b>      constructor<br />
  * <b> Name</b>      feinduraBase()<br />
  * 
  * The constructor of the class, sets all basic properties.
  * 
  * First gets all settings config <var>arrays</var> and external classes.<br />
  * Then Check if the visitor is a logged in user of the feindura backend and set the {@link feinduraBase::$loggedIn} property.  
  * Then set the <var>$_GET</var> variable names from the {@link feinduraBase::$adminConfig administrator-settings config} to the {@link $varNames} property.<br />
  * Check if cookies are activated, otherwise store the session ID in the {@link $sessionId} property for use in links.<br />
  * Get the the given <var>$language</var> parameter or try to find the browser language and load the frontend language-file and set it to the {@link $languageFile} property.
  * 
  * 
  * <b>Used Global Variables</b><br />
  *    - <var>$adminConfig</var> the administrator-settings config (included in the {@link general.include.php})
  *    - <var>$websiteConfig</var> the website-settings config (included in the {@link general.include.php})
  *    - <var>$categoryConfig</var> the categories-settings config (included in the {@link general.include.php})
  * 
  * <b>Used Constants</b><br />
  *    - <var>DOCUMENTROOT</var> the absolut path of the webserver
  * 
  * @param string $language (optional) A country code "de", "en", ... to load the right frontend language-file and will be set to the {@link $language} property 
  * 
  * @uses $adminConfig                            the administrator-settings config array will set to this property
  * @uses $websiteConfig                          the website-settings config array will set to this property
  * @uses $categoryConfig                         the category-settings config array will set to this property
  * @uses $generalFunctions                       a generalFunctions class instance will set to this property
  * @uses $statisticFunctions                     a statisticFunctions class instance will set to this property
  * @uses $loggedIn                               to set whether the visitor is logged in or not  
  * @uses $varNames                               the variable names from the administrator-settings config will set to this property
  * @uses $sessionId                              the session ID string will set to this property, if cookies are deactivated
  * @uses $language                               to set the given $language parameter to, or try to find out the browser language
  * @uses $languageFile                           set the loaded frontend language-file to this property
  * @uses statisticFunctions::saveWebsiteStats()  save the website statistic like user visit count, first and last visit AND the visit time of the last visited pages
  * 
  * @return void
  * 
  * @example includeFeindura.example.php    
  * 
  * @version 1.0
  * <br />
  * <b>ChangeLog</b><br />
  *    - 1.0 initial release
  * 
  */
  function feinduraBase($language = false) {   // (String) string with the COUNTRY CODE ("de", "en", ..)
    
    // GET CONFIG FILES and SET CONFIG PROPERTIES
    $this->adminConfig = $GLOBALS["feindura_adminConfig"];
    $this->websiteConfig = $GLOBALS["feindura_websiteConfig"];
    $this->categoryConfig = $GLOBALS["feindura_categoryConfig"];
    $this->pluginsConfig = $GLOBALS["feindura_pluginsConfig"];
    
    // GET FUNCTIONS
    $this->generalFunctions = new generalFunctions();
    $this->statisticFunctions = new statisticFunctions($this->generalFunctions);
    
    
    // eventually LOGOUT
    if(isset($_GET['feindura_logout']))
      unset($_SESSION['feinduraLogin'][IDENTITY]['username'],$_SESSION['feinduraLogin'][IDENTITY]['loggedIn']);
    // CHECK if logged in
    $this->loggedIn = ($_SESSION['feinduraLogin'][IDENTITY]['loggedIn'] === true) ? true : false;
    
    // set backend language if logged in
    if($this->loggedIn)
      $language = $_SESSION['language'];
    
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

    // -> CHECKS if cookies the cookie in the feindura.include.php file was set
    if(!isset($_COOKIE['feindura_checkCookies']) || $_COOKIE['feindura_checkCookies'] != 'true') {
      $this->sessionId = htmlspecialchars(session_name().'='.session_id()); //SID
    }
    
    // -> CHECK the GET variables
    $this->generalFunctions->checkGetVariables($this->varNames['category'],$this->varNames['category']);
    
    // sets the language PROPERTY from the session var AND the languageFile Array
    // **************************************************************************
    // set the given country code
    if(is_string($language) && strlen($language) == 2) {
      $this->language = $language;
      
    // if no country code is given, try to get the BROWSER LANGUAGE
    } else
      $this->language = $this->generalFunctions->checkLanguageFiles(false,false,$this->language); // returns a COUNTRY SHORTNAME 

    $this->loadFrontendLanguageFile($this->language);
  }
  
 /* ---------------------------------------------------------------------------------------------------------------------------- */
 /* *** METHODS *** */
 /* **************************************************************************************************************************** */
  
  /**
  * <b> Name</b>      loadFrontendLanguageFile()<br />
  * 
  * Loads the frontend language file into the {@link $languageFile} property.
  * 
  * 
  * <b>Used Constants</b><br />
  *    - <var>DOCUMENTROOT</var> the absolut path of the webserver
  * 
  * @param string $language a given country code which will be used to try to laod the language file
  * 
  * @uses language the country code from the property
  * 
  * @return array|false the frontend language file or FALSE if the file doesn't exist
  * 
  * 
  * @version 1.0
  * <br />
  * <b>ChangeLog</b><br />
  *    - 1.0 initial release
  * 
  */
  function loadFrontendLanguageFile($language) {
    
    // creates the frontend language file path
    $languageFile = dirname(__FILE__).'/../languages/'.$language.'.frontend.php';
    
    // includes the langFile
    if(file_exists($languageFile)) {
      $this->languageFile = include($languageFile);
      
      return $this->languageFile;
    } else
      return false;
    
  }

 /**
  * <b> Name</b>      getCurrentPageId()<br />
  * <b> Alias</b>     getPageId()<br />
  * 
  * Returns the current page ID from the <var>$_GET</var> variable.
  * 
  * Gets the current page ID from the <var>$_GET</var> variable.
  * If <var>$_GET</var> is not a ID but a page name, it loads all pages in an array and look for the right page name and returns the ID.
  * If no <var>$_GET</var> variable exists try to return the {@link feindura::$startPage} property.
  * 
  * 
  * <b>Used Global Variables</b><br />
  *    - <var>$_GET</var> to fetch the page ID
  * 
  * @uses $varNames                     for variable names which the $_GET will use for the page ID
  * @uses $adminConfig                  to look if set startpage is allowed
  * @uses feindura::$startPage     if no $_GET variable exists it will try to get the {@link feindura::$startPage} property
  * @uses generalFunctions::loadPages() for loading all pages to get the right page ID, if the $_GET variable is not a ID but a page name
  * 
  * 
  * @return int|false the current page ID or FALSE
  * 
  * 
  * @version 1.0
  * <br />
  * <b>ChangeLog</b><br />
  *    - 1.0 initial release
  * 
  */
  function getCurrentPageId() {
    
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
      $pages = $this->generalFunctions->loadPages($this->category);
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
  * Alias of {@link getCurrentPageId()}
  * @ignore
  */
  function getPageId() {
    // call the right function
    return $this->getCurrentPageId();
  }

 /**
  * <b> Name</b>      getCurrentCategoryId()<br />
  * <b> Alias</b>     getCategory()<br />
  * 
  * Returns the current category ID from the <var>$_GET</var> variable.
  * 
  * Gets the current category ID from the <var>$_GET</var> variable.
  * If <var>$_GET</var> is not a ID but a category name, it look in the {@link feinduraBase::$categoryConfig} for the right category ID.
  * If no <var>$_GET</var> variable exists it try to return the {@link feindura::$startPage} property.
  * 
  * 
  * <b>Used Global Variables</b><br />
  *    - <var>$_GET</var> to fetch the category ID
  * 
  * @uses $varNames                  for variable names which the $_GET variable will use for the category ID
  * @uses $adminConfig               to look if set startpage is allowed
  * @uses $categoryConfig            for the right category name, if the $_GET variable is not a ID but a category name
  * @uses feindura::$startCategory   if no $_GET variable exists it will try to get the {@link feindura::$startCategory} property
  * 
  * @return int|false the current category ID or FALSE
  * 
  * 
  * @version 1.0
  * <br />
  * <b>ChangeLog</b><br />
  *    - 1.0 initial release
  * 
  */
  function getCurrentCategoryId() {
    
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
  * Alias of {@link getCurrentCategoryId()}
  * @ignore
  */
  function getCategoryId() {
    // call the right function
    return $this->getCurrentCategoryId();
  }
  
 /**
  * <b>Name</b>     setCurrentPageId()<br />
  * <b>Alias</b>    setPageId()<br />
  * 
  * Sets the current page ID from the <var>$_GET</var> variable to the {@link $page} property.
  * 
  * Gets the current page ID from the <var>$_GET</var> variable (through {@link getCurrentPageId}) and set it to the {@link $page} property.
  * If the <var>$setStartPage</var> parameter is TRUE and the {@link feindura::$category} is empty, the {@link feindura::$startPage} property will also be set with the start page ID from the {@link $websiteConfig}.
  * 
  * 
  * @param bool $setStartPage (optional) If set to TRUE it also sets the {@link feindura::$startPage} property
  * 
  * @uses $adminConfig         to check if setting a startpage is allowed
  * @uses $websiteConfig       to get the startpage ID
  * @uses feindura::$page      as the property to set
  * @uses feindura::$startPage if the $setStartPage parameter is TRUE this property will also be set
  * @uses getCurrentPageId()   to get the {@link feindura::$page} property or the {@link feindura::$startPage} property  
  * 
  * @return int|false the set page ID or FALSE
  * 
  * 
  * @version 1.0
  * <br />
  * <b>ChangeLog</b><br />
  *    - 1.0 initial release
  * 
  */
  function setCurrentPageId($setStartPage = false) {  // (bool) if TRUE it sets the startPage  
    
    // sets the startPage if it exists
    if($setStartPage === true && $this->adminConfig['setStartPage'] && !empty($this->websiteConfig['startPage'])) { //empty($this->category)
      $this->startPage = $this->websiteConfig['startPage'];
    }
      
    // sets the new page PROPERTY
    $this->page = $this->getCurrentPageId();
      
    return $this->page;
  }
 /**
  * Alias of {@link setCurrentPageId()}
  * @ignore
  */
  function setPageId($setStartPage = false) {
    // call the right function
    return $this->setCurrentPageId($setStartPage);
  }
  
 /**
  * <b>Name</b>     setCurrentCategoryId()<br />
  * <b>Alias</b>    setCategoryId()<br />
  * 
  *  Sets the current category ID from the <var>$_GET</var> variable to the {@link feindura::$category} property.
  * 
  * Gets the current category ID from the <var>$_GET</var> variable (through {@link getCurrentCategoryId}) and set it to the {@link feindura::$category} property.
  * If the <var>$setStartCategory</var> parameter is TRUE the {@link $startCategory} property will also be set with the startpage ID from the {@link $websiteConfig}.
  * 
  * @param bool $setStartCategory (optional) If set to TRUE it also sets the {@link $startCategory} property
  * 
  * @uses $adminConfig              to check if setting a startpage is allowed
  * @uses $websiteConfig            to get the startpage ID
  * @uses feindura::$category       as the property to set
  * @uses feindura::$startCategory  if the $setStartCategory parameter is TRUE this property will also be set
  * @uses getPageCategory()         to get the right category ID of the startpage
  * @uses getCurrentCategoryId()    to get the {@link feindura::$category} property or the {@link $startCategory} property
  * 
  * @return int|false the set category ID or FALSE
  * 
  * 
  * @version 1.0
  * <br />
  * <b>ChangeLog</b><br />
  *    - 1.0 initial release
  * 
  */
  function setCurrentCategoryId($setStartCategory = false) {
    
    // sets the startPage if it exists
    if($setStartCategory === true && $this->adminConfig['setStartPage'] && !empty($this->websiteConfig['startPage'])) {   
      $this->startCategory = $this->getPageCategory($this->websiteConfig['startPage']);
    }
    
    // sets the new category PROPERTY
    $this->category = $this->getCurrentCategoryId();
    
    return $this->category;
  }
 /**
  * Alias of {@link setCurrentCategoryId()}
  * @ignore
  */
  function setCategoryId($setStartCategory = false) {
    // call the right function
    return $this->setCurrentCategoryId($setStartCategory = false);
  }

 /**
  * <b>Name</b> generatePage()<br />
  * 
  * <b>This method uses the {@link $showErrors $error...}, {@link $titleLength $title...} and {@link $thumbnailAlign $thumbnail...} properties.</b>   
  * 
  * Generates a page.
  * 
  * This method is called in descendant classes.<br />
  * Generates a page by the given page ID.
  * An array will be returned with all elements of the page, ready for displaying in a HTML-page.
  * 
  * In case the page doesn't exists or is not public and the <var>$showErrors</var> parameter is TRUE, 
  * an error will be placed in the ['content'] part of the returned array,
  * otherwiese it returns an empty array.<br />  
  * 
  * Example of the returned array:
  * {@example generatePage.return.example.php}
  * 
  * @param int|array  $page          page ID or a $pageContent array
  * @param bool       $showErrors     (optional) says if errors like "The page you requested doesn't exist" will be displayed
  * @param int|false  $shortenText   (optional) number of the maximal text length shown, adds a "more" link at the end or FALSE to not shorten
  * @param bool       $useHtml       (optional) displays the page content with or without HTML tags
  * 
  * 
  * @uses $adminConfig                            for the thumbnail upload path
  * @uses $categoryConfig                         to check whether the category of the page allows thumbnails
  * @uses $languageFile                           for the error texts
  * 
  * @uses feindura::$page   
  * 
  * @uses feindura::$xHtml
  * @uses feindura::$showErrors
  * @uses feindura::$errorTag
  * @uses feindura::$errorId
  * @uses feindura::$errorClass
  * @uses feindura::$errorAttributes
  * 
  * @uses feindura::$titleLength
  * @uses feindura::$titleAsLink
  * @uses feindura::$titleShowPageDate
  * @uses feindura::$titleShowCategory
  * @uses feindura::$titleCategorySeparator
  * 
  * @uses feindura::$thumbnailAlign
  * @uses feindura::$thumbnailId
  * @uses feindura::$thumbnailClass
  * @uses feindura::$thumbnailAttributes
  * @uses feindura::$thumbnailBefore
  * @uses feindura::$thumbnailAfter
  * 
  * @uses publicCategory()                         to check whether the category is public  
  * @uses createTitle()                            to create the page title
  * @uses createThumbnail()                        to check to show thumbnails are allowed and create the thumbnail <img> tag
  * @uses createAttributes()                       to create the attributes used in the error tag
  * @uses shortenHtmlText()                        to shorten the HTML page content
  * @uses shortenText()                            to shorten the non HTML page content, if the $useHtml parameter is FALSE
  * @uses statisticFunctions::formatDate()         to format the page date for output
  * @uses statisticFunctions::dateDayBeforeAfter() check if the page date is "yesterday" "today" or "tomorrow"
  * @uses generalFunctions::isPageContentArray()   to check if the given array is a $pageContent array  
  * @uses generalFunctions::readPage()		         to load the page if the $page parameter is an ID
  * 
  * 
  * @return array the generated page array, ready to display in a HTML file
  * 
  * @example showPage.example.php the called showPage method in this example uses the generatePage() method
  * 
  * @version 1.0
  * <br />
  * <b>ChangeLog</b><br />
  *    - 1.0 initial release
  * 
  */
  function generatePage($page, $showErrors = true, $shortenText = false, $useHtml = true) {
    
    // vars
    $return['id'] = false;
    $return['category'] = false;
    $return['pageDate'] = false;
    $return['title'] = false;
    $return['thumbnail'] = false;
    $return['thumbnailPath'] = false;
    $return['content'] = false;
    $return['description'] = false;  
    $return['tags'] = false;
    
    $return['error'] = true;

    // ->> CHECKS
    // -------------------
    
    // LOOKS FOR A GIVEN PAGE, IF NOT STOP THE METHOD
    if(!is_numeric($page) && !is_array($page))
      return array();

    // -> sets the ERROR SETTINGS
    // ----------------------------
    if($showErrors) {
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
    if($this->generalFunctions->isPageContentArray($page)) {
      $pageContent = $page;
      
    // $page is NUMBER
    } else {
      // gets the category of the page
      $category = $this->getPageCategory($page);
      
      // -> if not try to load the page
      if(!$pageContent = $this->generalFunctions->readPage($page,$category)) {
        // if could not load throw ERROR
        if($showErrors) {
	        $return['content'] = $errorStartTag.$this->languageFile['error_noPage'].$errorEndTag; // if not throw error and and the method
          return $return;
        } else
          return array();
      }
    }
    
    // -> PAGE is PUBLIC? if not throw ERROR
    if(!$pageContent['public'] || $this->publicCategory($pageContent['category']) === false) {
      if($showErrors) {
        $return['content'] = $errorStartTag.$this->languageFile['error_pageClosed'].$errorEndTag; // if not throw error and and the method
        return $return; 
      } else
        return array();
    }
    
    // ->> BEGINNING TO BUILD THE PAGE
    // -------------------
    
    // -> PAGE DATE
    // *****************
    $pagedate = false;
    if($this->statisticFunctions->checkPageDate($pageContent)) {
    	$titleDateBefore = '';
    	$titleDateAfter = '';
    	// adds spaces on before and after
    	if($pageContent['pagedate']['before']) $titleDateBefore = $pageContent['pagedate']['before'].' ';
    	if($pageContent['pagedate']['after']) $titleDateAfter = ' '.$pageContent['pagedate']['after'];
    	$pagedate = $titleDateBefore.$this->statisticFunctions->formatDate($this->statisticFunctions->dateDayBeforeAfter($pageContent['pagedate']['date'],$this->languageFile)).$titleDateAfter;
    }
      
    // -> PAGE TITLE
    // *****************
    $title = '';
    if(!empty($pageContent['title']))
      $title = $this->createTitle($pageContent,				                          
                                  $this->titleLength,
                                  $this->titleAsLink,                                  
                                  $this->titleShowPageDate,
                                  $this->titleShowCategory,
                                  $this->titleCategorySeparator);      
      
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
          $pageContentEdited = $this->shortenHtmlText($pageContentEdited, $shortenText, $pageContent, "...");
        else {
          // clear string of html tags (except BR)
          $pageContentEdited = strip_tags($pageContentEdited, '<br />,<br />');
          $pageContentEdited = $this->shortenText($pageContentEdited, $shortenText, $pageContent, "...");
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
    
    // -> SET UP the PAGE ELEMENTS
    // *******************
    if(!empty($pageContent['id']))
      $return['id'] = $pageContent['id'];
    
    if($pageContent['category'] && $pageContent['category'] != '0')
      $return['category'] = $this->categoryConfig[$pageContent['category']]['name'];
    
    if($pagedate)
       $return['pageDate']  = $pagedate;
       
    if(!empty($pageContent['title']))
       $return['title']	    = $title;
       
    if($returnThumbnail) {
       $return['thumbnail'] = "\n".$returnThumbnail['thumbnail']."\n";
       $return['thumbnailPath'] = $returnThumbnail['thumbnailPath'];
    }
       
    if(!empty($pageContent['content']))
       $return['content']   = "\n".$pageContentEdited."\n"; //$contentBefore.$contentStartTag.$pageContentEdited.$contentEndTag.$contentAfter;
    
    if(!empty($pageContent['description']))
       $return['description'] = $pageContent['content'];
    
    if(!empty($pageContent['tags']))
       $return['tags']   = $pageContent['tags'];
    
    $return['error'] = false;
    
    /*
    // adds breaks before and after
    $return = "\n".$return."\n";    
    // removes double breaks
    $return = preg_replace("/[\r\n]+/","\n",$return);
    */
    
    // -> AFTER all RETURN $return
    // *****************
    return $return;
  }  
  
 /**
  * <b>Name</b> createTitle()<br />
  * 
  * Generates a page title from a given <var>$pageContent</var> array by using the given parameters.
  * 
  * @param array   $pageContent                 the $pageContent Array of a page
  * @param int	   $titleLength                 (optional) number of the maximal text length shown or FALSE to not shorten
  * @param bool    $titleAsLink                 (optional) if TRUE, it creates the title as link
  * @param bool	   $titleShowPageDate           (optional) if TRUE, it shows the page date before the title text
  * @param bool    $titleShowCategory           (optional) if TRUE, it shows the category name before the title text, and uses the $titleShowCategory parameter string between both
  * @param string  $titleCategorySeparator      (optional) string to seperate the category name and the title text, if the $titleShowCategory parameter is TRUE
  * 
  * @uses $categoryConfig			                        to check if showing the page date is allowed and for the category name
  * @uses $languageFile				                        for showing "yesterday", "today" or "tomorrow" instead of a page date
  * @uses shortenText()				                        to shorten the title text, if the $titleLength parameter is TRUE
  * @uses createHref()				                        to create the href if the $titleAsLink parameter is TRUE
  * @uses statisticFunctions::formatDate()            to format the title date for output
  * @uses statisticFunctions::dateDayBeforeAfter()    check if the title date is "yesterday" "today" or "tomorrow"
  * 
  * @return string the generated title string ready to display in a HTML file
  * 
  * @see feindura::getPageTitle()
  * 
  * @example getPageTitle.example.php the {@link getPageTitle()} method in this example calls this method with the title properties as parameters
  * 
  * @version 1.0
  * <br />
  * <b>ChangeLog</b><br />
  *    - 1.0 initial release
  * 
  */
  function createTitle($pageContent, $titleLength = false, $titleAsLink = false, $titleShowPageDate = false, $titleShowCategory = false, $titleCategorySeparator = false) {
      
      // vars 
      $titleBefore = '';
      $titleAfter = '';
      
      // saves the long version of the title, for the title="" tag
      //$fullTitle = strip_tags($pageContent['title']);
           
      // generate titleDate
      if($titleShowPageDate && $this->statisticFunctions->checkPageDate($pageContent)) {
         $titleDateBefore = '';
         $titleDateAfter = '';
	       // adds spaces on before and after
         if($pageContent['pagedate']['before']) $titleDateBefore = $pageContent['pagedate']['before'].' ';
         if($pageContent['pagedate']['after']) $titleDateAfter = ' '.$pageContent['pagedate']['after'];
         $titleDate = $titleDateBefore.$this->statisticFunctions->formatDate($this->statisticFunctions->dateDayBeforeAfter($pageContent['pagedate']['date'],$this->languageFile)).$titleDateAfter.' ';
      } else $titleDate = false;      
      
      
      /*
      // shorten the title
      if(is_numeric($titleLength))
        $title = $this->shortenText($fullTitle, $titleLength, false, "...");
      else
        $title = $fullTitle;
      */
        
      // show the category name
      if($titleShowCategory === true && $pageContent['category'] != 0) {
        if(is_string($titleCategorySeparator))
          $titleShowCategory = $this->categoryConfig[$pageContent['category']]['name'].$titleCategorySeparator; // adds the Spacer
        else
          $titleShowCategory = $this->categoryConfig[$pageContent['category']]['name'].' ';
      } else
        $titleShowCategory = '';
        
      // generate titleBefore without tags
      //$titleBefore = $titleShowCategory.$titleDate;
      $title = $titleShowCategory.$titleDate.$pageContent['title'];
      
      // generates the title for the title="" tag
      //$titleTagText = $titleBefore.$fullTitle;      
      
        
      // create a link for the title
      if($titleAsLink) {
        $titleBefore = '<a href="'.$this->createHref($pageContent).'" title="'.strip_tags($title).'">'."\n"; //.$titleBefore;
        $titleAfter = "\n</a>";
      }
      
      // shorten the title
      if(is_numeric($titleLength))
        $title = $this->shortenText($title, $titleLength, false, "...");
        
      // -> builds the title
      // *******************
      //$title = $titleStartTag.$titleBefore.$title.$titleAfter.$titleEndTag;
      $title = $titleBefore.$title.$titleAfter;
      
      // returns the title
      return $title;
  }

 /**
  * <b>Name</b> createThumbnail()<br />
  * 
  * Generates a thumbnail <img> tag from the given <var>$pageContent</var> array and
  * returns an array with the ready to display tag and the plain thumbnail path.
  * 
  * <b>Used Constants</b><br />
  *    - <var>DOCUMENTROOT</var> the absolut path of the webserver
  * 
  * @param array $pageContent   the $pageContent array of a page
  * 
  * @uses $adminConfig          for the thumbnail path
  * @uses $categoryConfig       to check if thumbnails are allowed for the th category of this page
  * @uses createAttributes()		to create the attributes used in the thumbnail <img> tag
  * 
  * @return array|false the generated thumbnail <img> tag and a the plain thumbnail path or FALSE if no thumbnail exists or is not allowed to show
  * 
  * @version 1.0
  * <br />
  * <b>ChangeLog</b><br />
  *    - 1.0 initial release
  * 
  */
  function createThumbnail($pageContent) {
      
    // ->> CHECK if thumbnail exists and is allowed to show
    if(!empty($pageContent['thumbnail']) &&
      @is_file(DOCUMENTROOT.$this->adminConfig['uploadPath'].$this->adminConfig['pageThumbnail']['path'].$pageContent['thumbnail'])) { //&&
      //(($pageContent['category'] == '0' && $this->adminConfig['pages']['thumbnails']) ||
      //($pageContent['category'] && $this->categoryConfig[$pageContent['category']]['thumbnail']))) {
      
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
      
      $pageThumbnail['thumbnail'] = $thumbnailBefore.'<img src="'.$this->adminConfig['uploadPath'].$this->adminConfig['pageThumbnail']['path'].$pageContent['thumbnail'].'" alt="Thumbnail" title="'.$pageContent['title'].'"'.$thumbnailAttributes.$tagEnding.$thumbnailAfter;
      $pageThumbnail['thumbnailPath'] = $this->adminConfig['uploadPath'].$this->adminConfig['pageThumbnail']['path'].$pageContent['thumbnail'];
      
      return $pageThumbnail;
    } else 
      return false;      
  }

 /**
  * <b>Name</b> createAttributes()<br />
  * 
  * Generates a string with a given id, class and other attributes.
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
  * 
  * @version 1.0
  * <br />
  * <b>ChangeLog</b><br />
  *    - 1.0 initial release
  * 
  */
  function createAttributes($id, $class, $attributes) {
  
      $attributeString = '';
      
      // add ID
      if((is_string($id) || is_numeric($id)) && !empty($class))
        $attributeString .= ' id="'.$id.'"';
	
      // add CLASS
      if((is_string($class) || is_numeric($class)) && !empty($class))
        $attributeString .= ' class="'.$class.'"';
      
      // add ATTRIBUTES
      if((is_string($attributes) || is_numeric($attributes)) && !empty($class))
	      $attributeString .= ' '.$attributes;
        
      return $attributeString;    
  }


 /**
  * <b>Name</b> loadPagesByType()<br />
  * 
  * Load pages by ID-type and ID(s).
  * 
  * If the <var>$idType</var> parameter start with "cat" it takes the given <var>$ids</var> parameter as category IDs.<br />
  * If the <var>$idType</var> parameter start with "pag" it takes the given <var>$ids</var> parameter as page IDs.<br />
  * While it is not important that whether the <var>$idType</var> parameter is written in plural or singular.
  * The <var>$ids</var> parameter is automaticly checked whether its an array with IDs or a single ID.
  * 
  * @param string         $idType           the ID(s) type can be "cat", "category", "categories" or "pag", "page" or "pages"
  * @param int|array|bool $ids              the category or page ID(s), can be a number or an array with numbers, if TRUE it loads all pages
  * 
  * @uses publicCategory()              to check if the category(ies) or page(s) category(ies) are public
  * @uses isPageContentArray()		      to check if the given array is a $pageContent array, if TRUE it just returns this array
  * @uses generalFunctions::loadPages()	to load pages
  * @uses generalFunctions::readPage()	to load a single page
  * 
  * @return array|false an array with $pageContent array(s)
  * 
  * 
  * @version 1.0
  * <br />
  * <b>ChangeLog</b><br />
  *    - 1.0 initial release
  * 
  */
  function loadPagesByType($idType, $ids) {
    
    // vars
    $return = false;
    $idType = strtolower($idType);
    $shortIdType = substr($idType,0,3);
    
    // -> category ID(s)
    // ***************
    if($shortIdType == 'cat') {
      if($ids === true || is_array($ids) || is_numeric($ids)) {
        
        // if its an array with $pageContent arrays -> return this
        if($this->generalFunctions->isPageContentArray($ids) || (isset($ids[0]) && $this->generalFunctions->isPageContentArray($ids[0]))) {
          return $ids;
        
        // otherwise load the pages from the category(ies)
        } else {
	
          // checks if the categories are public         
          if(($ids = $this->publicCategory($ids)) !== false) {

	          // returns the loaded pages from the CATEGORY IDs
	          // the pages in the returned array also get SORTED
            return $this->generalFunctions->loadPages($ids);

          } else return false;
        }
      } else return false;
      
    // ->> if PAGE ID(s)
    // **************************
    } elseif($shortIdType == 'pag') {
      
      // -----------------------------------------     
      // ->> load all pages
      // *************** 
      if($ids === true) {
	
	// checks if the categories are public         
	if(($ids = $this->publicCategory($ids)) !== false) {
	  return $this->generalFunctions->loadPages($ids);
	}
      
      // -----------------------------------------    
      // ->> pages IDs
      // ***************
      } elseif($ids && is_array($ids)) {
        
        // checks if its an Array with pageContent Arrays
        if($this->generalFunctions->isPageContentArray($ids) || (isset($ids[0]) && $this->generalFunctions->isPageContentArray($ids[0]))) {
          return $ids;          
        //otherwise load the pages from the categories
        } else {
        
          // loads all pages in an array
          foreach($ids as $page) {
      	    // get category
      	    $category = $this->getPageCategory($page);
      	    if(($category = $this->publicCategory($category)) !== false) {
              if($pageContent = $this->generalFunctions->readPage($page,$category)) {
                $return[] = $pageContent;
              }
	          }
          }
        }        
      // -----------------------------------------     
      // ->> single page ID
      // *************** 
      } elseif($ids && is_numeric($ids)) {
        $category = $this->getPageCategory($page);
	      if(($category = $this->publicCategory($category)) !== false) {
          // loads the single page in an array 
          if($pageContent = $this->generalFunctions->readPage($ids,$category)) {
            $return[] = $pageContent;
          } else return false;
        } else return false;
      } else return false;
    }
    
    // -> returns an array with the pageContent Arrays
    return $return;
  }
  
 /**
  * <b>Name</b> publicCategory()<br />
  * 
  * Checks whether the given category(ies) are public and returns the ID or an array with IDs of the public ones.
  * 
  * @param int|array|bool $ids the category or page ID(s), can be a number or an array with numbers, if TRUE then it check all categories
  * 
  * @uses $categoryConfig      to check if a category is public
  * 
  * @return array|false an array with ID(s) of the public category(ies)
  * 
  * 
  * @version 1.0
  * <br />
  * <b>ChangeLog</b><br />
  *    - 1.0 initial release
  * 
  */
  function publicCategory($ids) {
    
    // var
    $newIds = false;
    
    // ->> ALL categories
    if($ids === true) {
      
        // adds the non-category
        $newIds[] = 0;
        
        foreach($this->categoryConfig as $category) {
          // checks if the category is public and creates a new array
          if($category['public'])
            $newIds[] = $category['id'];
        }
      // ->> MULITPLE categories
    } elseif(is_array($ids)) {
      // goes trough the given category IDs array
      foreach($ids as $id) {
        // checks if the category is public and creates a new array
      	if($id == 0 || (isset($this->categoryConfig[$id]) && $this->categoryConfig[$id]['public']))    
      	  $newIds[] = $id;
            }
      
    // -> SINGLE category ID
    } elseif(is_numeric($ids)) {

      // checks if the category is public
      if($ids == 0 || $this->categoryConfig[$ids]['public'])    
        return $ids;
      else return false;
    
    } else return false;
    
    // and return the new category IDs array
    return $newIds;
  }

 /**
  * <b>Name</b> getPageCategory()<br />
  * 
  * Gets the category ID of a page.
  * 
  * @uses generalFunctions::getPageCategory()
  * @see generalFunctions::getPageCategory()
  * 
  */
  function getPageCategory($page) {
    return $this->generalFunctions->getPageCategory($page);
  }


 /**
  * <b>Name</b> loadPrevNextPage()<br />
  * 
  * Loads a page, but check first if the given <var>$page</var> parameter is a string with "previous" or "next" and load the right page.
  * 
  * If the given <var>$page</var> parameter is "previous" or "next" it loads the previous or the next page of the current {@link feindura::$page} property.
  * 
  * @param int|array|string $page    a page ID, a $pageContent array or a string with "previous" or "next"
  * 
  * @uses getPropertyPage()		to get the right {@link feindura::$page} property
  * @uses getPageCategory()		to get the category ID of the given page
  * @uses generalFunctions::readPage()	to load the $pageContent array of the page and return it
  * @uses generalFunctions::loadPages()	to load all pages in a category to find the right previous or next page and return it
  * 
  * @return int|array|false the page ID of the right page or FALSE if no page could be loaded (can also return an $pageContent array)
  * 
  * 
  * @version 1.0
  * <br />
  * <b>ChangeLog</b><br />
  *    - 1.0 initial release
  *   
  */ 
  function loadPrevNextPage($page) {
    
    // var
    $prevNext = false;
    
    // -> PREV or NEXT if given direction
    if(is_string($page) && !is_numeric($page)) {
      $page = strtolower($page);
      $page = substr($page,0,4);
      // PREV
      if($page == 'prev') {
        $prevNext = 'prev';
        $page = false;
      // NEXT
      } elseif($page == 'next') {
        $prevNext = 'next';
        $page = false;
      } else return false;
    }
    
    // CHECK if its a $pageContent array, set the $page ID to the $page parameter
    if($this->generalFunctions->isPageContentArray($page))
      return $page;
    
    // USES the PRIORITY: 1. -> page var 2. -> PROPERTY page var 3. -> false
    $page = $this->getPropertyPage($page);

    //echo '<br />page: '.$page;
    //echo '<br />category: '.$category;
     
    // -> IF only $page ID or $pageContent array is given return loaded page
    if($prevNext === false) {
      //return $this->generalFunctions->readPage($page,$category);
      return $page;
      
    // ->> ELSE return the previous or the next $pageContent array in the category
    } else {
    
      // gets the category of the page
      $category = $this->getPageCategory($page);
      
      // loads all pages in this category
      $categoryWithPages = $this->generalFunctions->loadPages($category);
  
      if($categoryWithPages !== false) {
        $count = 0;
        foreach($categoryWithPages as $eachPage) {         

          if($eachPage['id'] == $page) {
        
            // NEXT
            if($prevNext == 'next' && (($count + 1) < count($categoryWithPages)))
              return $categoryWithPages[($count + 1)]['id'];
            // PREV
            elseif($prevNext == 'prev' && (($count - 1) >= 0))
              return $categoryWithPages[($count - 1)]['id'];
            else return false;
          }  
          
          $count++;
        }
      } else
        return false;
    }
  }  

 /**
  * <b>Name</b> compareTags()<br />
  * 
  * Compares the given tags with the tags in the given <var>$pageContent</var> array.
  * 
  * If the given <var>$pageContent</var> array has one or more tags from the <var>$tags</var> parameter,
  * it returns the <var>$pageContent</var> array otherwise it FALSE.<br />
  * <b>Notice</b>: the tags will be compared case insensitive.
  * 
  * @param array $pageContent    the $pageContent array of a page
  * @param array $tags           an array with tags to compare
  * 
  * 
  * @return array|false the $pageContent array or FALSE if the $pageContent['tags'] doesn't match with any of the given tags
  * 
  * 
  * @version 1.0
  * <br />
  * <b>ChangeLog</b><br />
  *    - 1.0 initial release
  *   
  */ 
  function compareTags($pageContent,  // (Array) the pageContent Array, needs the $pageContent['tags'] var
                                 $tags) {       // (Array) with the search TAGs
    
    // CHECKS if the $tags are in an array,
    // and the pageContent['tags'] var exists and is not empty
    if(is_array($tags) && isset($pageContent['tags']) && !empty($pageContent['tags'])) { 
      // lowercase
      $pageTags = strtolower($pageContent['tags']);
      
      // goes trough the given TAG Array, and look of one tga is in the pageContent['tags'} var
      foreach($tags as $tag) {
        // lowercase
        $tag = strtolower($tag);
        
        if(strstr(' '.$pageTags.' ',' '.$tag.' ')) {
          return $pageContent;
        }
      }
    }
    
    // if nothing has been found return FALSE
    return false;
  }

 /**
  * <b>Name</b> hasTags()<br />
  * 
  * Load pages by ID-type and ID(s), but only if the page(s) have one or more tags from the given <var>$tags</var> parameter.
  * 
  * <b>Notice</b>: the tags will be compared case insensitive.
  * 
  * @param string         $idType    the ID(s) type can be "cat", "category", "categories" or "pag", "page" or "pages"
  * @param int|array|bool $ids       the category or page ID(s), can be a number or an array with numbers, if TRUE it checks all pages tags
  * @param string|array   $tags      an string (seperated by "," or ";" or " ") or an array with tags to compare
  * 
  * @uses loadPagesByType()	to load pages by the given ID(s) for comparision
  * @uses compareTags()		to compare each tags between two strings
  * 
  * @return array|false the $pageContent array of $pageContent arrays or FALSE if no $pageContent array have the any of the given tags
  * 
  * 
  * @version 1.0
  * <br />
  * <b>ChangeLog</b><br />
  *    - 1.0 initial release
  * 
  */   
  function hasTags($idType, $ids, $tags) {
    
    // var
    $return = false;
    
    // ->> PREPARE the $tags parameter
    if(is_string($tags)) {
      // clear multiple whitespaces
      $tags = preg_replace("/ +/", ' ', $tags);
      // look for the right seperation character
      if(strstr($tags,','))
        $tags = explode(',',$tags);
      elseif(strstr($tags,';'))
        $tags = explode(';',$tags);
      elseif(strstr($tags,' '))
        $tags = explode(' ',$tags);
      else return false;
      
    // if array clear whitespaces in array
    } elseif(is_array($tags)) {
     foreach($tags as $tag) {
       $newTags[] = preg_replace("/ +/", '', $tag);
    }
      $tags = $newTags;
    } else
      return false;
    
    // get the pages and compare them if they have the tags
    if($pages = $this->loadPagesByType($idType,$ids)) {
      // goes trough every page and compares the tags
      foreach($pages as $page) {
        if($this->compareTags($page, $tags)) {
          $return[] = $page;
        }
      }
    }
    // RETURNs only the page who have the tags
    return $return;
  }


 /**
  * <b>Name</b> loadPagesByDate()<br />
  * 
  * Loads pages by ID-type and ID, which fit in the given time period parameters.
  * 
  * Checks if the pages to load have a page date
  * and the page date fit in the given <var>$monthsInThePast</var> and <var>$monthsInTheFuture</var> parameters.
  * All time period parameters are compared against the date of TODAY.
  * 
  * The <var>$monthsInThePast</var> and <var>$monthsInTheFuture</var> parameters can also be a string with a (relative or specific) date, for more information see: {@link http://www.php.net/manual/de/datetime.formats.php}.
  * 
  * @param string          $idType                the ID(s) type can be "cat", "category", "categories" or "pag", "page" or "pages"
  * @param int|array|bool  $ids                   the category or page ID(s), can be a number or an array with numbers, if TRUE it loads all pages
  * @param int|bool|string $monthsInThePast       (optional) number of months before today, if TRUE it show all pages in the past, if FALSE it loads only pages starting from today. it can also be a string with a (relative or specific) date format, for more details see: {@link http://www.php.net/manual/de/datetime.formats.php}
  * @param int|bool|string $monthsInTheFuture     (optional) number of months after today, if TRUE it show all pages in the future, if FALSE it loads only pages until today. it can also be a string with a (relative or specific) date format, for more details see: {@link http://www.php.net/manual/de/datetime.formats.php}
  * @param bool            $sortByCategories      (optional) determine whether the pages should only by sorted by page date or also seperated by categories and sorted by page date
  * @param bool	           $reverseList           (optional) if TRUE the pages sorting will be reversed
  * 
  * @uses $categoryConfig                 to check if in the category is sorting by page date allowed
  * @uses getPropertyIdsByType()          to get the property IDs if the $ids parameter is FALSE
  * @uses loadPagesByType()               load the pages depending on the type
  * @uses changeDate()                    change the current date minus or plus the months from specified in the parameters
  * @uses gernalFunctions::sortPages()		to sort the pages by page date
  * 
  * @return array|false an array with the $pageContent arrays or FALSE if no page has a page date or is allowed for sorting
  * 
  * @link http://www.php.net/manual/de/datetime.formats.php
  * 
  * @version 1.0
  * <br />
  * <b>ChangeLog</b><br />
  *    - 1.0 initial release
  * 
  */     
  function loadPagesByDate($idType, $ids, $monthsInThePast = true, $monthsInTheFuture = true, $sortByCategories = false, $reverseList = false) {

    if(!is_bool($monthsInThePast) && is_numeric($monthsInThePast))
      $monthsInThePast = round($monthsInThePast);
    if(!is_bool($monthsInTheFuture) && is_numeric($monthsInTheFuture))
      $monthsInTheFuture = round($monthsInTheFuture);
    
    $ids = $this->getPropertyIdsByType($idType,$ids);
        
    // LOADS the PAGES BY TYPE
    if($pages = $this->loadPagesByType($idType,$ids)) {
      
      // creates the current date to compare with
      $currentDate = time();       
      
      $pastDate = false;
      $futureDate = false;
       
      // creates the PAST DATE
      if(is_string($monthsInThePast) && !is_numeric($monthsInThePast))
        $pastDate = strtotime($monthsInThePast,$currentDate);
      elseif(!is_bool($monthsInThePast) && is_numeric($monthsInThePast))
        $pastDate = strtotime('-'.$monthsInThePast.' month',$currentDate);
      elseif($monthsInThePast === false)
        $pastDate = $currentDate;
                      
      // creates the FUTURE DATE
      if(is_string($monthsInTheFuture) && !is_numeric($monthsInTheFuture))
        $pastDate = strtotime($monthsInTheFuture,$currentDate);
      if(!is_bool($monthsInTheFuture) && is_numeric($monthsInTheFuture))
        $futureDate = strtotime('+'.$monthsInTheFuture.' month',$currentDate);
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
           ($page['category'] != 0 && $this->categoryConfig[$page['category']]['showpagedate'])) {         
           
           //echo $page['pagedate']['date'].' >= '.$pastDate.'<br />';
           
           // adds the page to the array, if:
           // -> the currentdate ist between the minus and the plus month or
           // -> mins or plus month are true (means there is no time limit)
           if(($monthsInThePast === true || $page['pagedate']['date'] >= $pastDate) &&
              ($monthsInTheFuture === true || $page['pagedate']['date'] <= $futureDate))
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
      
      // -> flips the sorted array if $reverseList === true
      if($reverseList === true)
        $selectedPages = array_reverse($selectedPages);
      
      
      // -> RETURN the pages the pages    
      if(!empty($selectedPages))
        return $selectedPages;
      else
	     return false;
 
      
    } else return false;
    //return $return;
  }
  
 /**
  * <b>Name</b> getPropertyIdsByType()<br />
  * 
  * If <var>$ids</var> parameter is FALSE it check the ID-type and returns then the {@link feindura::$page} or {@link feindura::$category} property.
  * 
  * @param string         $idType   the ID type can be "page", "pages" or "category", "categories"
  * @param int|array|bool $ids      the category or page ID(s), if they are FALSE it returns the property ID, otherwise it passes the ID(s) through
  * 
  * @uses getPropertyPage()         to get the right {@link feindura::$page} property
  * @uses getPropertyCategory()     to get the right {@link feindura::$category} property
  * 
  * @return int|false a page or category property ID or FALSE, if there are no property IDs
  * 
  * 
  * @version 1.0
  * <br />
  * <b>ChangeLog</b><br />
  *    - 1.0 initial release
  * 
  */ 
  function getPropertyIdsByType($idType,$ids) {
  
    $idType = strtolower($idType);
    $shortIdType = substr($idType,0,3);
    
    // USES the PRIORITY: 1. -> page var 2. -> PROPERTY page var 3. -> false
    if($ids === false) {
      if($shortIdType == 'pag')
        // USES the PRIORITY: 1. -> pages var 2. -> PROPERTY pages var 3. -> false
        $ids = $this->getPropertyPage(false);      
      elseif($shortIdType == 'cat')
        // USES the PRIORITY: 1. -> category var 2. -> PROPERTY category var 3. -> false
        $ids = $this->getPropertyCategory(false);
      /*
      elseif($idType == 'pages')
        // USES the PRIORITY: 1. -> page var 2. -> PROPERTY page var 3. -> false
        $ids = $this->getPropertyPages($ids);
      elseif($idType == 'categories')
        // USES the PRIORITY: 1. -> categories var 2. -> PROPERTY categories var 3. -> false
        $ids = $this->getPropertyCategories($ids);
      */
    }
    
    return $ids;
  }

 /**
  * <b>Name</b> getPropertyPage()<br />
  * 
  * Returns the {@link feindura::$page} property if the given <var>$page</var> parameter is FALSE.
  * 
  * @param int|bool $page (optional) a page id or a boolean
  * 
  * @return int|true the {@link feindura::$page} property or the $page parameter
  * 
  * 
  * @version 1.0
  * <br />
  * <b>ChangeLog</b><br />
  *    - 1.0 initial release
  *   
  */  
  function getPropertyPage($page = false) { // (false or Number)
    if(is_bool($page) && is_numeric($this->page))
      return $this->page;  // set the page var from PROPERTY var
    else
      return $page;
  }
  
  
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
  
  
 /**
  * <b>Name</b> getPropertyCategory()<br />
  * 
  * Returns the {@link feindura::$category} property if the given <var>$category</var> parameter is FALSE.
  * 
  * @param int|bool $category (optional) a category id or a boolean
  * 
  * @return int|true the {@link feindura::$category} property or the $category parameter
  * 
  * 
  * @version 1.0
  * <br />
  * <b>ChangeLog</b><br />
  *    - 1.0 initial release
  *   
  */  
  function getPropertyCategory($category = false) { // (false or Number)
    if(is_bool($category) && is_numeric($this->category))
      return $this->category;  // set the category var from PROPERTY var
    else
      return $category;
  }

 /**
  * <b>Name</b> getStoredPageIds()<br />
  * 
  * Returns the {@link generalFunctions::$storedPageIds} property.
  * 
  * @uses generalFunctions::getStoredPageIds()
  * @see generalFunctions::getStoredPageIds()
  * 
  */
  function getStoredPageIds() {

    return $this->generalFunctions->getStoredPageIds();
  }

 /**
  * <b>Name</b> getStoredPages()<br />
  * 
  * Returns the {@link generalFunctions::$storedPages} property.
  * 
  * @uses generalFunctions::getStoredPages()
  * @see generalFunctions::getStoredPages()
  * 
  */
  function getStoredPages() {

    return $this->generalFunctions->getStoredPages();
  }

 /**
  * <b>Name</b> shortenText()<br />
  * 
  * Shorten a text by to a given length.
  * 
  * If the <var>$endString</var> parameter is set and a <var>$pageContent</var> array is given,
  * it adds the <var>$endString</var> parameter after the last character and a "more" link on the end of the shortened text.
  * 
  * @param string       $string          the string to shorten
  * @param int          $length          the number of maximal characters
  * @param array|false  $pageContent     the pageContent array of the page to create the "more" link to the page from
  * @param string|false $endString       a string which will be put after the last character and before the "more" link
  * 
  * @uses createHref()                                  create the href for the "more" link  
  * @uses generalFunctions::getRealCharacterNumber()    to get the real number of characters of the string (adds the multiple characters of htmlentities)
  * @uses generalFunctions::isPageContentArray()			  check if the given $pageContent parameter is valid
  * 
  * @return string the shortened string
  * 
  * 
  * @version 1.0
  * <br />
  * <b>ChangeLog</b><br />
  *    - 1.0 initial release  
  * 
  */
  function shortenText($string, $length, $pageContent = false, $endString = "...") {
      
      //var
      $output = $string;
      
      // getting length
      if(is_numeric($length)) {
        // gets real length, if there are htmlentities like &auml; &uuml; etc
        $length = $this->generalFunctions->getRealCharacterNumber($string,$length);        
      }
      
      // shorten the string
      if($length < strlen($string)) {      
        $output = substr($string,0,$length);
        
        // search last whitespace and cut until there
        if($endPos = strrpos($output, ' '))
          $output = substr($output, 0, $endPos);

        // adds the endString
        if(is_string($endString))
          $output .= $endString;
      }
      
      // adds the MORE LINK
      if(is_string($endString) && $this->generalFunctions->isPageContentArray($pageContent)) {
        $output .= " \n".'<a href="'.$this->createHref($pageContent).'">'.$this->languageFile['page_more'].'</a>';
      }
      
      $output = preg_replace("/ +/", ' ', $output);
      
      return $output;
  }

 /**
  * <b>Name</b> shortenHtmlText()<br />
  * 
  * Shorten a HTML text by to a given length.
  * 
  * All HTML tags which are contained in the shortend text will be counted and closed on the end.<br />
  * If the <var>$endString</var> parameter is set and a <var>$pageContent</var> array is given,
  * it adds the <var>$endString</var> parameter after the last character and a "more" link on the end of the shortened text.
  * 
  * @param string       $string          the string to shorten
  * @param int          $length          the number of maximal characters
  * @param array|false  $pageContent     the pageContent array of the page to create the "more" link to the page from
  * @param string|false $endString       a string which will be put after the last character and before the "more" link
  * 
  * @uses shortenText()                                 shorten the text
  * @uses createHref()                                  create the href for the "more" link  
  * 
  * @return string the shortened string
  * 
  * 
  * @version 1.0
  * <br />
  * <b>ChangeLog</b><br />
  *    - 1.0 initial release
  * 
  */  
  function shortenHtmlText($input, $length, $pageContent = false, $endString = '...') {

      // vars
      $textWasCut = false;
      $rawText = strip_tags($input);      
      $rawText = str_replace("\n", ' ', $rawText);
      $rawText = str_replace("\r", ' ', $rawText);
      $rawText = preg_replace("/ +/", ' ', $rawText);
      
      if(is_numeric($length))
        $length = $this->generalFunctions->getRealCharacterNumber($rawText,$length);
      
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
        
        // goes trough the text and find the real position
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
            
            // looks if its a opening or closing tag
            if(substr($tag, 0, 1) != '/') {          
              // HTML tags which will not be closed
              if($tag != 'br' &&
              $tag != 'hr' &&
              $tag != 'img' &&
              $tag != 'source' &&
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
        
        $textWasCut = true;
      }
      
      // create the MORE LINK
      if($pageContent !== false && is_array($pageContent)) {
        $moreLink = " \n".'<a href="'.$this->createHref($pageContent).'">'.$this->languageFile['page_more'].'</a>';
      }
      
      $output = $input;
      
      // removes the last \r\n on the end
      if(substr($output,-1) == "\n")
        $output = substr($output,0,-2);        
      if(substr($input,-1) == "\r")
        $output = substr($output,0,-2);
      
      // if string was shorten
      if($textWasCut) {
        // try to put the endString before the last HTML-Tag and add the more link
        if(substr($output,-1) == '>') {
          $lastTagPos = strrpos($output, '</');
          $lastTag = substr($output,$lastTagPos);
          $output = substr($output,0,$lastTagPos).$endString.$lastTag;
        } else
          $output .= $endString;
      }
      
      // returns the shorten HTML-Text
      return $output.$moreLink;
  }
}
?>