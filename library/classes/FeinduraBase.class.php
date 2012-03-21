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
* The basis feindura class for the implementation classes.
* 
* It's methods provide necessary functions for the {@link feindura} and the {@link feinduraModules} <var>classes</var>.
* 
* @author Fabian Vogelsteller <fabian@feindura.org>
* @copyright Fabian Vogelsteller
* @license http://www.gnu.org/licenses GNU General Public License version 3
* 
* @package [Implementation]
* 
* @version 1.59
* <br />
* <b>ChangeLog</b><br />
*    - 1.59 changed it to a PHP5 class, add visibilities (public, protected, private)
*    - 1.58 add phpDocumentor documentation
*    - 1.57 startet documentation
*/
class FeinduraBase {
  
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
  protected $sessionId = null;
  
 /**
  * Contains the variable names used for the <var>$_GET</var> variables
  * 
  * This variable names are configured in the feindura adminstrator-settings and set in the {@link FeinduraBase()} constructor to the this property.<br />
  * For standard value see above.
  * 
  * Example of a link using the standard variable names:
  * <samp>
  * http://www.examplepage.com/index.php?category=1&page=6
  * </samp>
  * 
  * @var array
  * @access protected
  * @see FeinduraBase()
  * 
  */
  protected $varNames = array('page' => 'page', 'category' => 'category', 'modul' => 'modul');
                                 
  // PUBLIC
  // *********
  
 /**
  * Is TRUE when the user is logged into the backend of feindura and visits the frontend website.
  * If TRUE, it will enable the the frontend editing feature.  
  * 
  * 
  * @var bool
  * @access public
  */
  public $loggedIn = false;
  
 /**
  * Contains the administrator-settings and the page-settings set in the CMS backend
  * 
  * The file with the administrator-settings config array is situated at <i>"feindura-CMS/config/admin.config.php"</i>.
  *   
  * This settings will be set to this property in the {@link __construct() FeinduraBase} constructor.
  * 
  * Example array:
  * {@example backend/adminConfig.array.example.php}
  * 
  * @var array
  * @access public
  * @see FeinduraBase::__construct()
  * 
  */
  public $adminConfig;

 /**
  * Contains the website-settings config set in the CMS backend
  * 
  * The file with the website-settings config array is situated at <i>"feindura-CMS/config/website.config.php"</i>.
  *   
  * This settings will be set to this property in the {@link __construct() FeinduraBase} constructor.
  * 
  * Example array:
  * {@example backend/websiteConfig.array.example.php}
  * 
  * @var array
  * @access public
  * @see FeinduraBase::__construct()
  * 
  */
  public $websiteConfig;
  
 /**
  * Contains the categories-settings config set in the CMS backend
  * 
  * The file with the categories-settings config array is situated at <i>"feindura-CMS/config/category.config.php"</i>.
  *   
  * This settings will be set to this property in the {@link __construct() FeinduraBase} constructor.
  * 
  * Example array:
  * {@example backend/categoryConfig.array.example.php}
  * 
  * @var array
  * @access public
  * @see FeinduraBase::__construct()
  * 
  */
  public $categoryConfig;
  
  
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
  * @access public
  * @see $languageFile
  * @see FeinduraBase()
  * 
  */  
  public $language = 'en';
  
 /**
  * Contains the frontend language-file array
  * 
  * The frontend language file array contains texts for displaying page <i>warnings</i> or <i>errors</i> and additional texts like <i>"more"</i>, etc.<br />
  * The file is situated at <i>"feindura-CMS/library/languages/de.frontend.php"</i>.
  *   
  * It will be <i>included</i> and set to this property in the {@link __construct() FeinduraBase} constructor.
  * 
  * @var array
  * @access public
  * @see FeinduraBase()
  * 
  */
  public $languageFile = null;
  
 
 /* ---------------------------------------------------------------------------------------------------------------------------- */
 /* *** CONSTRUCTOR *** */
 /* **************************************************************************************************************************** */
 
 /**
  * <b> Type</b>      constructor<br />
  * 
  * The constructor of the class, sets all basic properties.
  * 
  * First gets all settings config <var>arrays</var> and external classes.<br />
  * Then Check if the visitor is a logged in user of the feindura backend and set the {@link FeinduraBase::$loggedIn} property.  
  * Then set the <var>$_GET</var> variable names from the {@link FeinduraBase::$adminConfig administrator-settings config} to the {@link $varNames} property.<br />
  * Check if cookies are activated, otherwise store the session ID in the {@link $sessionId} property for use in links.<br />
  * Get the the given <var>$language</var> parameter or try to find the browser language and load the frontend language-file and set it to the {@link $languageFile} property.
  * 
  * 
  * <b>Used Global Variables</b><br />
  *    - <var>$adminConfig</var> the administrator-settings config (included in the {@link general.include.php})
  *    - <var>$websiteConfig</var> the website-settings config (included in the {@link general.include.php})
  *    - <var>$categoryConfig</var> the categories-settings config (included in the {@link general.include.php})
  * 
  * 
  * @param string $language (optional) A country code "de", "en", ... to load the right frontend language-file and will be set to the {@link $language} property 
  * 
  * @uses $adminConfig                            the administrator-settings config array will set to this property
  * @uses $websiteConfig                          the website-settings config array will set to this property
  * @uses $categoryConfig                         the category-settings config array will set to this property  * 
  * @uses $loggedIn                               to set whether the visitor is logged in or not  
  * @uses $varNames                               the variable names from the administrator-settings config will set to this property
  * @uses $sessionId                              the session ID string will set to this property, if cookies are deactivated
  * @uses $language                               to set the given $language parameter to, or try to find out the browser language
  * @uses $languageFile                           set the loaded frontend language-file to this property
  * @uses StatisticFunctions::saveWebsiteStats()  save the website statistic like user visit count, first and last visit AND the visit time of the last visited pages
  * 
  * @return void
  * 
  * @example includeFeindura.example.php
  * 
  * @access protected
  * @version 1.0
  * <br />
  * <b>ChangeLog</b><br />
  *    - 1.0 initial release
  * 
  */
  protected function __construct($language = false) {   // (String) string with the COUNTRY CODE ("de", "en", ..)
    
    // GET CONFIG FILES and SET CONFIG PROPERTIES
    $this->adminConfig = $GLOBALS["feindura_adminConfig"];
    $this->websiteConfig = $GLOBALS["feindura_websiteConfig"];
    $this->categoryConfig = $GLOBALS["feindura_categoryConfig"];

    // eventually LOGOUT
    if(isset($_GET['feindura_logout']))
      unset($_SESSION['feinduraSession']['login']);
    // CHECK if logged in
    $this->loggedIn = ($_SESSION['feinduraSession']['login']['loggedIn'] === true && $_SESSION['feinduraSession']['login']['host'] === HOST) ? true : false;
    
    // set backend language if logged in
    if($this->loggedIn && $language === false)
      $language = $_SESSION['feinduraSession']['language'];
    
    // save the website statistics
    // ***************************
    StatisticFunctions::saveWebsiteStats();
    
    // sets the varNames['...'] from the adminConfig
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
    
    // sets the language PROPERTY from the session var AND the languageFile Array
    // **************************************************************************
    $language = XssFilter::alphabetical($language);
    
    // set the given country code
    if(is_string($language) && strlen($language) == 2) {
      $this->language = $language;
      $this->loadFrontendLanguageFile($this->language);
      
    // if no country code is given, it will get the country code automatically
    } else
      $this->language = $this->loadFrontendLanguageFile();
  }
  
 /* ---------------------------------------------------------------------------------------------------------------------------- */
 /* *** METHODS *** */
 /* **************************************************************************************************************************** */

 /**
  * <b> Name</b>      getCurrentPageId()<br />
  * <b> Alias</b>     getPageId()<br />
  * 
  * Returns the current page ID from the <var>$_GET</var> variable.
  * 
  * Gets the current page ID from the <var>$_GET</var> variable.
  * If <var>$_GET</var> is not a ID but a page name, it loads all pages in an array and look for the right page name and returns the ID.
  * If no <var>$_GET</var> variable exists try to return the {@link Feindura::$startPage} property.
  * 
  * 
  * <b>Used Global Variables</b><br />
  *    - <var>$_GET</var> to fetch the page ID
  * 
  * @uses $varNames                     for variable names which the $_GET will use for the page ID
  * @uses $adminConfig                  to look if set startpage is allowed
  * @uses Feindura::$startPage          if no $_GET variable exists it will try to get the {@link Feindura::$startPage} property
  * @uses GeneralFunctions::loadPages() for loading all pages to get the right page ID, if the $_GET variable is not a ID but a page name
  * 
  * 
  * @return int|false the current page ID or FALSE
  * 
  * @access public
  * @version 1.0
  * <br />
  * <b>ChangeLog</b><br />
  *    - 1.0 initial release
  * 
  */
  public function getCurrentPageId() {
    
    // ->> GET PAGE is an ID
    // *********************
    if(isset($_GET[$this->varNames['page']]) &&
       !empty($_GET[$this->varNames['page']]) &&
       is_numeric($_GET[$this->varNames['page']])) {
       
      // get PAGE GET var
      return XssFilter::int($_GET[$this->varNames['page']],0); // get the page ID from the $_GET var
    
    // ->> GET PAGE is a feindura link
    // **********************
    } elseif(isset($_GET['feinduraLink']) &&
             !empty($_GET['feinduraLink']) &&
             is_numeric($_GET['feinduraLink'])) {
      // get PAGE GET var
      return XssFilter::int($_GET['feinduraLink'],0); // get the page ID from the $_GET var
      
    // ->> GET PAGE is a NAME
    // **********************
    } elseif(isset($_GET['page']) &&
             !empty($_GET['page'])) {
    
      // load the pages of the category
      $pages = GeneralFunctions::loadPages($this->category);
      //print_r($this->storedPages);
      if($pages) {
        foreach($pages as $page) {

          // RETURNs the right page Id
          if(GeneralFunctions::urlEncode($page['title']) == GeneralFunctions::urlEncode($_GET['page'])) { //GeneralFunctions::urlEncode($page['title'])
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
  * <b> Alias</b>     getCategoryId()<br />
  * 
  * Returns the current category ID from the <var>$_GET</var> variable.
  * 
  * Gets the current category ID from the <var>$_GET</var> variable.
  * If <var>$_GET</var> is not a ID but a category name, it look in the {@link FeinduraBase::$categoryConfig} for the right category ID.
  * If no <var>$_GET</var> variable exists it try to return the {@link Feindura::$startPage} property.
  * 
  * 
  * <b>Used Global Variables</b><br />
  *    - <var>$_GET</var> to fetch the category ID
  * 
  * @uses $varNames                  for variable names which the $_GET variable will use for the category ID
  * @uses $adminConfig               to look if set startpage is allowed
  * @uses $categoryConfig            for the right category name, if the $_GET variable is not a ID but a category name
  * @uses Feindura::$startCategory   if no $_GET variable exists it will try to get the {@link Feindura::$startCategory} property
  * 
  * @return int|false the current category ID or FALSE
  * 
  * @access public
  * @version 1.0
  * <br />
  * <b>ChangeLog</b><br />
  *    - 1.0 initial release
  * 
  */
  public function getCurrentCategoryId() {
    
    // ->> GET CATEGORY is an ID
    // *************************
    if(isset($_GET[$this->varNames['category']]) &&
       !empty($_GET[$this->varNames['category']]) &&
       is_numeric($_GET[$this->varNames['category']])) {
       
      return XssFilter::int($_GET[$this->varNames['category']],0); // get the category ID from the $_GET var
      
    // ->> GET CATEGORY is a NAME
    // **************************
    } elseif(isset($_GET['category']) &&
             !empty($_GET['category'])) {
      
      foreach($this->categoryConfig as $category) {      
        // RETURNs the right category Id
        if(GeneralFunctions::urlEncode($category['name']) == GeneralFunctions::urlEncode($_GET['category'])) { //GeneralFunctions::urlEncode($category['name'])
          return $category['id'];
        }
      }
    } elseif(empty($_GET['page']) && $this->adminConfig['setStartPage'] && is_numeric($this->startCategory)) {
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
  * <b>Name</b> replaceLinks()<br />
  * 
  * Replaces all feindura links (e.g. "?feinduraPageID=3") inside the given <var>$pageContentString</var> parameter, with real href links.
  
  * @param string $pageContentString      the page content string, to replace all feindura links, with real hrefs
  * 
  * @uses GeneralFunctions::readPage()		to load the page for createHref()
  * @uses GeneralFunctions::createHref()  to create the hreaf of the link
  * 
  * @return string the $pageContentString woth replaced feindura links
  * 
  * @see FeinduraBase::generatePage()
  * 
  * @access protected
  * @version 1.0
  * <br />
  * <b>ChangeLog</b><br />
  *    - 1.0 initial release
  * 
  */
  public function replaceLinks($pageContentString) {
    if(preg_match_all ('#\?*feinduraPageID\=([0-9]+)#i', $pageContentString, $matches,PREG_SET_ORDER)) {
      // replace each link
      foreach($matches as $match) {
        $pageContentString = str_replace($match[0],GeneralFunctions::createHref(GeneralFunctions::readPage($match[1],GeneralFunctions::getPageCategory($match[1])),$this->sessionId),$pageContentString);
      }
    }
    return $pageContentString;
  }
  
 /**
  * <b>Name</b>     setCurrentPageId()<br />
  * <b>Alias</b>    setPageId()<br />
  * 
  * Sets the current page ID from the <var>$_GET</var> variable to the {@link $page} property.
  * 
  * Gets the current page ID from the <var>$_GET</var> variable (through {@link getCurrentPageId}) and set it to the {@link $page} property.
  * If the <var>$setStartPage</var> parameter is TRUE and the {@link Feindura::$category} is empty, the {@link Feindura::$startPage} property will also be set with the start page ID from the {@link $websiteConfig}.
  * 
  * 
  * @param bool $setStartPage (optional) If set to TRUE it also sets the {@link Feindura::$startPage} property
  * 
  * @uses $adminConfig         to check if setting a startpage is allowed
  * @uses $websiteConfig       to get the startpage ID
  * @uses Feindura::$page      as the property to set
  * @uses Feindura::$startPage if the $setStartPage parameter is TRUE this property will also be set
  * @uses getCurrentPageId()   to get the {@link Feindura::$page} property or the {@link Feindura::$startPage} property  
  * 
  * @return int|false the set page ID or FALSE
  * 
  * @access protected
  * @version 1.0
  * <br />
  * <b>ChangeLog</b><br />
  *    - 1.0 initial release
  * 
  */
  protected function setCurrentPageId($setStartPage = false) {
    
    // sets the startPage if it exists
    if($setStartPage === true && $this->adminConfig['setStartPage'] && !empty($this->websiteConfig['startPage'])) { //empty($this->category)
      $this->startPage = intval($this->websiteConfig['startPage']);
    }
      
    // sets the new page PROPERTY
    $this->page = $this->getCurrentPageId();
    
    return $this->page;
  }
 /**
  * Alias of {@link setCurrentPageId()}
  * @ignore
  */
  protected function setPageId($setStartPage = false) {
    // call the right function
    return $this->setCurrentPageId($setStartPage);
  }
  
 /**
  * <b>Name</b>     setCurrentCategoryId()<br />
  * <b>Alias</b>    setCategoryId()<br />
  * 
  *  Sets the current category ID from the <var>$_GET</var> variable to the {@link Feindura::$category} property.
  * 
  * Gets the current category ID from the <var>$_GET</var> variable (through {@link getCurrentCategoryId}) and set it to the {@link Feindura::$category} property.
  * If the <var>$setStartCategory</var> parameter is TRUE the {@link $startCategory} property will also be set with the startpage ID from the {@link $websiteConfig}.
  * 
  * @param bool $setStartCategory (optional) If set to TRUE it also sets the {@link $startCategory} property
  * 
  * @uses $adminConfig                        to check if setting a startpage is allowed
  * @uses $websiteConfig                      to get the startpage ID
  * @uses Feindura::$category                 as the property to set
  * @uses Feindura::$startCategory            if the $setStartCategory parameter is TRUE this property will also be set
  * @uses getCurrentCategoryId()              to get the {@link Feindura::$category} property or the {@link $startCategory} property
  * @uses GeneralFunctions::getPageCategory() to get the right category ID of the startpage
  * 
  * @return int|false the set category ID or FALSE
  * 
  * @access protected
  * @version 1.0
  * <br />
  * <b>ChangeLog</b><br />
  *    - 1.0 initial release
  * 
  */
  protected function setCurrentCategoryId($setStartCategory = false) {
    
    // sets the startPage if it exists
    if($setStartCategory === true && $this->adminConfig['setStartPage'] && !empty($this->websiteConfig['startPage'])) {   
      $this->startCategory = GeneralFunctions::getPageCategory($this->websiteConfig['startPage']);
    }

    // sets the new category PROPERTY
    $this->category = $this->getCurrentCategoryId();
    
    return $this->category;
  }
 /**
  * Alias of {@link setCurrentCategoryId()}
  * @ignore
  */
  protected function setCategoryId($setStartCategory = false) {
    // call the right function
    return $this->setCurrentCategoryId($setStartCategory = false);
  }

 /**
  * <b> Name</b>      loadFrontendLanguageFile()<br />
  * 
  * Loads the frontend language file into the {@link $languageFile} property.
  * 
  * 
  * @param string $language  (optional) a given country code which will be used to try to load the language file
  * 
  * @uses GeneralFunctions::loadLanguageFile() to load the language files
  * 
  * @return string the country code which was used to load the frontend language files
  * 
  * @access protected
  * @version 1.1
  * <br />
  * <b>ChangeLog</b><br />
  *    - 1.1 add new GeneralFunctions::loadLanguageFile() method
  *    - 1.0 initial release
  * 
  */
  protected function loadFrontendLanguageFile($language = false) {
    
    $frontendLangFile = GeneralFunctions::loadLanguageFile(false,'%lang%.frontend.php',$language);
    $sharedLangFile = GeneralFunctions::loadLanguageFile(false,'%lang%.shared.php',$language);
    
    // SET the FRONTEND LANGUAGE FILE
    $this->languageFile = $sharedLangFile + $frontendLangFile;
    unset($frontendLangFile,$sharedLangFile);
    return $language;
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
  * @param int|array      $page          page ID or a $pageContent array
  * @param bool           $showErrors    (optional) says if errors like "The page you requested doesn't exist" will be displayed
  * @param int|array|bool $shortenText   (optional) number of the maximal text length displayed, adds a "more" link at the end or FALSE to not shorten. You can also pass an array: value 1: text length as int, value 2: text string for the link, or a link string.  e.g. array(23,false), array(23,'read more'), or array(23,'<a href="…"'>read more</a>')
  * @param bool|string    $useHtml       (optional) displays the page content with or without HTML tags. It also accepts a string with allowed html tags.
  * 
  * 
  * @uses $adminConfig       for the thumbnail upload path
  * @uses $categoryConfig    to check whether the category of the page allows thumbnails
  * @uses $languageFile      for the error texts
  * 
  * @uses Feindura::$page   
  * 
  * @uses Feindura::$xHtml
  * @uses Feindura::$showErrors
  * @uses Feindura::$errorTag
  * @uses Feindura::$errorId
  * @uses Feindura::$errorClass
  * @uses Feindura::$errorAttributes
  * 
  * @uses Feindura::$titleLength
  * @uses Feindura::$titleAsLink
  * @uses Feindura::$titleShowPageDate
  * @uses Feindura::$titleShowCategory
  * @uses Feindura::$titleCategorySeparator
  * 
  * @uses Feindura::$thumbnailAlign
  * @uses Feindura::$thumbnailId
  * @uses Feindura::$thumbnailClass
  * @uses Feindura::$thumbnailAttributes
  * @uses Feindura::$thumbnailBefore
  * @uses Feindura::$thumbnailAfter
  * 
  * 
  * @uses createTitle()                            to create the page title
  * @uses createThumbnail()                        to check to show thumbnails are allowed and create the thumbnail <img> tag
  * @uses createAttributes()                       to create the attributes used in the error tag
  * @uses shortenHtmlText()                        to shorten the HTML page content
  * @uses shortenText()                            to shorten the non HTML page content, if the $useHtml parameter is FALSE
  * @uses StatisticFunctions::formatDate()         to format the page date for output
  * @uses StatisticFunctions::dateDayBeforeAfter() check if the page date is "yesterday" "today" or "tomorrow"
  * @uses GeneralFunctions::isPublicCategory()     to check whether the category is public
  * @uses GeneralFunctions::isPageContentArray()   to check if the given array is a $pageContent array
  * @uses GeneralFunctions::readPage()		         to load the page if the $page parameter is an ID
  * @uses GeneralFunctions::getPageCategory()      to get the category of the page
  * 
  * 
  * @return array the generated page array, ready to display in a HTML file
  * 
  * @example showPage.example.php the called showPage method in this example uses the generatePage() method
  * 
  * @see Feindura::showPages()
  * @see Feindura::listPages()
  * 
  * @access protected
  * @version 1.0.1
  * <br />
  * <b>ChangeLog</b><br />
  *    - 1.0.1 fixed description return
  *    - 1.0 initial release
  * 
  */
  protected function generatePage($page, $showErrors = true, $shortenText = false, $useHtml = true) {
    
    // vars
    $return['id'] = false;
    $return['category'] = false;
    $return['pageDate'] = false;
    $return['pageDateTimestamp'] = false;
    $return['title'] = false;
    $return['thumbnail'] = false;
    $return['thumbnailPath'] = false;
    $return['content'] = false;
    $return['description'] = false;
    $return['tags'] = false;
    $return['plugins'] = array();
    $return['error'] = true;

    // ->> CHECKS
    // -------------------
    
    // -> CHECK for right PHP VERSION
    if(PHP_VERSION < REQUIREDPHPVERSION) {
      $return['content'] = '<span style="font-size:15px;">'.$this->languageFile['ADMINSETUP_ERROR_PHPVERSION'].' '.REQUIREDPHPVERSION.'</span>'; // if not throw error and and the method
      return $return;
    }
    
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
    if(GeneralFunctions::isPageContentArray($page)) {
      $pageContent = $page;
      
    // $page is NUMBER
    } else {
      // gets the category of the page
      $category = GeneralFunctions::getPageCategory($page);
      // -> if not try to load the page
      if(!$pageContent = GeneralFunctions::readPage($page,$category)) {
        // if could not load throw ERROR
        if($showErrors) {
	        $return['content'] = $errorStartTag.$this->languageFile['PAGE_ERROR_NOPAGE'].$errorEndTag; // if not throw error and and the method
          return $return;
        } else
          return array();
      }
    }
    
    // -> PAGE is PUBLIC? if not throw ERROR
    if(!$pageContent['public'] || GeneralFunctions::isPublicCategory($pageContent['category']) === false) {
      if($showErrors) {
        $return['content'] = $errorStartTag.$this->languageFile['PAGE_ERROR_PAGENOTPUBLIC'].$errorEndTag; // if not throw error and and the method
        return $return; 
      } else
        return array();
    }
    
    // ->> BEGINNING TO BUILD THE PAGE
    // -------------------
    
    // -> PAGE DATE
    // *****************
    $pageDate = false;
    if(StatisticFunctions::checkPageDate($pageContent)) {
    	$titleDateBefore = '';
    	$titleDateAfter = '';
    	// adds spaces on before and after
    	if($pageContent['pageDate']['before']) $titleDateBefore = $pageContent['pageDate']['before'].' ';
    	if($pageContent['pageDate']['after']) $titleDateAfter = ' '.$pageContent['pageDate']['after'];
    	$pageDate = $titleDateBefore.StatisticFunctions::formatDate(StatisticFunctions::dateDayBeforeAfter($pageContent['pageDate']['date'],$this->languageFile)).$titleDateAfter;
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
                                  $this->titlePageDateSeparator,
                                  $this->titleCategorySeparator);      
      
    // -> PAGE THUMBNAIL
    // *****************
    $returnThumbnail = false;
    if($pageThumbnail = $this->createThumbnail($pageContent))
      $returnThumbnail = $pageThumbnail;
    
    // ->> MODIFING pageContent
    // ************************
    if(!empty($pageContent['content'])) {
      
      $htmlLawedConfig['safe'] = ($this->adminConfig['editor']['safeHtml']) ? 1 : 0;
      $htmlLawedConfig['valid_xhtml'] = ($this->xHtml) ? 1 : 0;
      $pageContentEdited = GeneralFunctions::htmLawed($pageContent['content'],$htmlLawedConfig);
      
      // replace feindura links
      $pageContentEdited = self::replaceLinks($pageContentEdited);
      
      // clear Html tags?
      if($useHtml === false || is_string($useHtml))
        $pageContentEdited = (is_string($useHtml)) ? strip_tags($pageContentEdited, $useHtml) : strip_tags($pageContentEdited);
      
      // -> SHORTEN CONTENT   
      if($shortenText && !is_bool($shortenText))
        $pageContentEdited = $this->shortenHtmlText($pageContentEdited, $shortenText, $pageContent);
      
      // clear xHTML tags from the content
      if($this->xHtml === false)
        $pageContentEdited = str_replace(' />','>',$pageContentEdited);
    
    // -> show no content
    } else {
      $contentStartTag = '';
      $contentEndTag = '';
      $pageContentEdited = '';
    }
    
    // -> SET UP the PAGE ELEMENTS
    // *******************
    if(!empty($pageContent['id']))
      $return['id'] = $pageContent['id'];
    
    if($pageContent['category'] && $pageContent['category'] != 0)
      $return['category'] = $this->categoryConfig[$pageContent['category']]['name'];
    
    if($pageDate)
      $return['pageDate']  = $pageDate;
      
    if($pageDate)
      $return['pageDateTimestamp'] = $pageContent['pageDate']['date'];
       
    if(!empty($pageContent['title']))
       $return['title']	    = $title;
       
    if($returnThumbnail) {
       $return['thumbnail'] = "\n".$returnThumbnail['thumbnail']."\n";
       $return['thumbnailPath'] = $returnThumbnail['thumbnailPath'];
    }
       
    if(!empty($pageContent['content']))
       $return['content']   = "\n".$pageContentEdited."\n"; //$contentBefore.$contentStartTag.$pageContentEdited.$contentEndTag.$contentAfter;
    
    if(!empty($pageContent['description']))
       $return['description'] = $pageContent['description'];
    
    if(!empty($pageContent['tags']))
       $return['tags']   = $pageContent['tags'];
    
    if(isset($pageContent['plugins']))  
      $return['plugins'] = $pageContent['plugins'];
    
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
  * @uses StatisticFunctions::formatDate()            to format the title date for output
  * @uses StatisticFunctions::dateDayBeforeAfter()    check if the title date is "yesterday" "today" or "tomorrow"
  * 
  * @return string the generated title string ready to display in a HTML file
  * 
  * @see Feindura::getPageTitle()
  * 
  * @example getPageTitle.example.php the {@link getPageTitle()} method in this example calls this method with the title properties as parameters
  * 
  * @access protected
  * @version 1.0
  * <br />
  * <b>ChangeLog</b><br />
  *    - 1.0 initial release
  * 
  */
  protected function createTitle($pageContent, $titleLength = false, $titleAsLink = false, $titleShowPageDate = false, $titleShowCategory = false, $titlePageDateSeparator = false, $titleCategorySeparator = false) {
      
      // vars 
      $titleBefore = '';
      $titleAfter = '';
      
      // saves the long version of the title, for the title="" tag
      //$fullTitle = strip_tags($pageContent['title']);
           
      // generate titleDate
      if($titleShowPageDate && StatisticFunctions::checkPageDate($pageContent)) {
        $titleDateBefore = '';
        $titleDateAfter = '';
        // adds spaces on before and after
        if($pageContent['pageDate']['before']) $titleDateBefore = $pageContent['pageDate']['before'].' ';
        if($pageContent['pageDate']['after']) $titleDateAfter = ' '.$pageContent['pageDate']['after'];
        $titleDate = $titleDateBefore.StatisticFunctions::formatDate(StatisticFunctions::dateDayBeforeAfter($pageContent['pageDate']['date'],$this->languageFile)).$titleDateAfter;
        $titleDate = (is_string($titlePageDateSeparator))
          ? $titleDate.$titlePageDateSeparator
          : $titleDate;
      } else $titleDate = false;      
        
      // show the category name
      if($titleShowCategory === true && $pageContent['category'] != 0) {
        $titleShowCategory = (is_string($titleCategorySeparator))
          ? $this->categoryConfig[$pageContent['category']]['name'].$titleCategorySeparator
          : $this->categoryConfig[$pageContent['category']]['name'];
      } else
        $titleShowCategory = '';
        
      // generate titleBefore without tags
      //$titleBefore = $titleShowCategory.$titleDate;
      $title = $titleShowCategory.$titleDate.$pageContent['title'];
      
      // generates the title for the title="" tag
      //$titleTagText = $titleBefore.$fullTitle;      
      
        
      // create a link for the title
      if($titleAsLink) {
        $titleBefore = '<a href="'.$this->createHref($pageContent).'" title="'.str_replace('"','&quot;',strip_tags($title)).'">'."\n"; //.$titleBefore;
        $titleAfter = "\n</a>";
      }
      
      // shorten the title
      if(is_numeric($titleLength))
        $title = $this->shortenText($title, array($titleLength,false), false);
        
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
  * @see Feindura::createLink()
  * @see FeinduraBase::generatePage()
  * 
  * @access protected
  * @version 1.0
  * <br />
  * <b>ChangeLog</b><br />
  *    - 1.0 initial release
  * 
  */
  protected function createThumbnail($pageContent) {
      
    // ->> CHECK if thumbnail exists and is allowed to show
    if(!empty($pageContent['thumbnail']) &&
      @is_file(DOCUMENTROOT.$this->adminConfig['uploadPath'].$this->adminConfig['pageThumbnail']['path'].$pageContent['thumbnail'])) { //&&
      //(($pageContent['category'] == 0 && $this->adminConfig['pages']['thumbnails']) ||
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
      
      $pageThumbnail['thumbnail'] = $thumbnailBefore.'<img src="'.$this->adminConfig['uploadPath'].$this->adminConfig['pageThumbnail']['path'].$pageContent['thumbnail'].'" alt="Thumbnail" title="'.str_replace('"','&quot;',strip_tags($pageContent['title'])).'"'.$thumbnailAttributes.$tagEnding.$thumbnailAfter;
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
  * @access protected
  * @version 1.0
  * <br />
  * <b>ChangeLog</b><br />
  *    - 1.0 initial release
  * 
  */
  protected function createAttributes($id, $class, $attributes) {
  
      $attributeString = '';
 
      // add ID
      if((is_string($id) || is_numeric($id)) && !empty($id))
        $attributeString .= ' id="'.$id.'"';

      // add CLASS
      if((is_string($class) || is_numeric($class)) && !empty($class))
        $attributeString .= ' class="'.$class.'"';
      
      // add ATTRIBUTES
      if((is_string($attributes) || is_numeric($attributes)) && !empty($attributes))
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
  * Example of the returned $pageContent array: (<b>Note</b> This array will be wraped in another array, not shown here)
  * {@example readPage.return.example.php}
  * 
  * @param string         $idType           the ID(s) type can be "cat", "category", "categories" or "pag", "page" or "pages"
  * @param int|array|bool $ids              the category or page ID(s), can be a number or an array with numbers, if TRUE it loads all pages
  * 
  * @uses isPageContentArray()		                 to check if the given array is a $pageContent array, if TRUE it just returns this array
  * @uses GeneralFunctions::isPublicCategory()     to check if the category(ies) or page(s) category(ies) are public
  * @uses GeneralFunctions::loadPages()	           to load pages
  * @uses GeneralFunctions::readPage()	           to load a single page
  * @uses GeneralFunctions::getPageCategory()      to get the category of the page
  * 
  * @return array|false an array with $pageContent array(s)
  * 
  * @access protected
  * @version 1.0
  * <br />
  * <b>ChangeLog</b><br />
  *    - 1.0 initial release
  * 
  */
  protected function loadPagesByType($idType, $ids) {
    
    // vars
    $return = false;
    $idType = strtolower($idType);
    $shortIdType = substr($idType,0,3);
    
    // -> category ID(s)
    // ***************
    if($shortIdType == 'cat') {
      if($ids === true || is_array($ids) || is_numeric($ids)) {
        
        // if its an array with $pageContent arrays -> return this
        if(GeneralFunctions::isPageContentArray($ids) || (isset($ids[0]) && GeneralFunctions::isPageContentArray($ids[0]))) {
          return $ids;
        
        // OTHERWISE load the pages from the category(ies)
        } else {
	
          // checks if the categories are public         
          if(($ids = GeneralFunctions::isPublicCategory($ids)) !== false) {

	          // returns the loaded pages from the CATEGORY IDs
	          // the pages in the returned array also get SORTED
            return GeneralFunctions::loadPages($ids);

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
      	if(($ids = GeneralFunctions::isPublicCategory($ids)) !== false)
      	  return GeneralFunctions::loadPages($ids);
      
      // -----------------------------------------    
      // ->> pages IDs
      // ***************
      } elseif($ids && is_array($ids)) {
        
        // checks if its an Array with pageContent Arrays
        if(GeneralFunctions::isPageContentArray($ids) || (isset($ids[0]) && GeneralFunctions::isPageContentArray($ids[0]))) {
          return $ids;          
        //otherwise load the pages from the categories
        } else {
        
          // loads all pages in an array
          foreach($ids as $page) {
      	    // get category
      	    $category = GeneralFunctions::getPageCategory($page);
      	    if(($category = GeneralFunctions::isPublicCategory($category)) !== false) {
              if($pageContent = GeneralFunctions::readPage($page,$category)) {
                $return[] = $pageContent;
              }
	          }
          }
        }        
      // -----------------------------------------     
      // ->> single page ID
      // *************** 
      } elseif($ids && is_numeric($ids)) {
        $category = GeneralFunctions::getPageCategory($page);
	      if(($category = GeneralFunctions::isPublicCategory($category)) !== false) {
          // loads the single page in an array
          if($pageContent = GeneralFunctions::readPage($ids,$category)) {
            $return[] = $pageContent;
          } else return false;
        } else return false;
      } else return false;
    }
    
    // -> returns an array with the pageContent Arrays
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
  * @see Feindura::listPagesByDate()
  * @see Feindura::createMenuByDate()
  * 
  * @access protected
  * @version 1.0
  * <br />
  * <b>ChangeLog</b><br />
  *    - 1.0 initial release
  * 
  */     
  protected function loadPagesByDate($idType, $ids, $monthsInThePast = true, $monthsInTheFuture = true, $sortByCategories = false, $reverseList = false) {

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
        if(!empty($page['pageDate']['date']) &&
           (($page['category'] != 0 && $this->categoryConfig[$page['category']]['showPageDate']) || ($page['category'] == 0 && $this->adminConfig['pages']['showPageDate']))) {         
           
           // echo $page['pageDate']['date'].' >= '.$pastDate.'<br />';
           
           // adds the page to the array, if:
           // -> the currentdate ist between the minus and the plus month or
           // -> mins or plus month are true (means there is no time limit)
           if(($monthsInThePast === true || $page['pageDate']['date'] >= $pastDate) &&
              ($monthsInTheFuture === true || $page['pageDate']['date'] <= $futureDate))
             $selectedPages[] = $page;
        }
      }      
      
      // -> SORT the pages BY DATE
      // sort by DATE and GIVEN ARRAY
      if($sortByCategories === false)
        usort($selectedPages,'sortByDate');
      // sorts by DATE and CATEGORIES
      else
        $selectedPages = GeneralFunctions::sortPages($selectedPages,'sortByDate');
      
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
  * @see Feindura::listPagesByTags()
  * @see Feindura::createMenuByTags()
  * 
  * @access protected
  * @version 1.0.1
  * <br />
  * <b>ChangeLog</b><br />
  *    - 1.0.1 fixed comparision, beacause i changed separarion of tags from whitespace to ,  
  *    - 1.0 initial release
  *   
  */ 
  protected function compareTags($pageContent,  // (Array) the pageContent Array, need the $pageContent['tags'] var
                                 $tags) {       // (Array) with the search TAGs
    
    // CHECKS if the $tags are in an array,
    // and the pageContent['tags'] var exists and is not empty
    if(is_array($tags) && isset($pageContent['tags']) && !empty($pageContent['tags'])) { 
      // lowercase
      $pageTags = strtolower($pageContent['tags']);
      //$pageTags = str_replace(',',' ',$pageTags);
      
      // goes trough the given TAG Array, and look of one tga is in the pageContent['tags'} var
      foreach($tags as $tag) {
        // lowercase
        $tag = strtolower($tag);
        
        if(strpos(','.$pageTags.',',','.$tag.',') !== false) {
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
  * @see Feindura::listPagesByTags()
  * @see Feindura::createMenuByTags()
  * 
  * @access protected
  * @version 1.0.1
  * <br />
  * <b>ChangeLog</b><br />
  *    - 1.0.1 fixed issue when get a single tag as string
  *    - 1.0 initial release
  * 
  */   
  protected function hasTags($idType, $ids, $tags) {
    
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
      else
        $tags = array($tags);

    // if array clear whitespaces in array
    } elseif(is_array($tags)) {
     foreach($tags as $tag) {
       $newTags[] = trim(preg_replace("/ +/", ' ', $tag));
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
  * <b>Name</b> getPropertyIdsByString()<br />
  * 
  * Gets the right page and category IDs. If the <var>$ids</var> parameter is a an array it uses the first value as page ID and the second as category ID.
  * 
  * If the given <var>$ids</var> parameter is a string/array with "previous" or "next" it returns the previous or next page ID from the current {@link Feindura::$page} property/{@link Feindura::$category} property on.
  * If the given <var>$ids</var> parameter is a string/array with "first" or "last" it returns the first or last page ID in that category from the current {@link Feindura::$page} property/{@link Feindura::$category} property on.
  * If the string is "random" it returns a random page ID in the current category, if its an array like: array('random','random') it would return a random page ID from a random category.
  *
  * <b>Notice</b>: What is the first or last page/category depends on the sorting you have of the pages/categories in the feindura backend.
  * <b>Notice</b>: When using "previous","next","first" or "last" it will jump over pages/categories which are not public and return the next one.
  *
  * Examples of possible <var>$ids</var> parameter.
  * <code>
  * <?php
  * false                  // return the ids of the current $page property
  * 2                      // would return an array with the associated category of that page: array(2,1)
  * 'next'                 // would return the next page, after the current $page property in the current category
  * array('next',false)    // the same as above
  * array('next',45)       // the same as above (it would discard the wrong category ID)
  * array('next','next')   // same as above (it would discard the wrong category ID)
  * array(false,'next')    // would return the first page of the next category, in the $categoryConfig property 
  * array('last','next')   // would return the last page of the next category, in the $categoryConfig property
  * array('last','first')  // would return the last page of the first category, in the $categoryConfig property
  * array('last','first')  // would return the last page of the first category, in the $categoryConfig property
  * array('rand','rand')   // would return a random page of a random category, in the $categoryConfig property
  * ?>
  * </code>
  *
  * Example return value, where first value is the page ID and the second value is the category ID.
  * <samp>
  * array(2,1)
  * </samp>
  * 
  * @param int|string|array|bool $ids    a page ID, array with page and category IDs, or a string/array with "previous","next","first","last" or "random". (See example) (can also be a $pageContent array)
  * 
  * @uses getPropertyPage()		                 to get the right {@link Feindura::$page} property
  * @uses GeneralFunctions::getPageCategory()  to get the category ID of the given page
  * @uses GeneralFunctions::loadPages()	       to load all pages in a category to find the right previous or next page and return it
  * 
  * @return array|false array with the page ID and category ID of the right page, or FALSE if no page could be resolved (e.g. last page and "next"). (will also pass through a given $pageContent array)
  * 
  * @access protected
  * @version 2.0
  * <br />
  * <b>ChangeLog</b><br />
  *    - 2.0 change name from loadPrevNextPage() to getPropertyIdsByString(), and now handles also categories
  *    - 1.0 initial release
  *   
  */ 
  protected function getPropertyIdsByString($ids) {
    
    // vars    
    // ??include the non-category??
    //$nonCategory[0] = array('id' => 0);
    //$categoriesArray = array_merge($nonCategory,$this->categoryConfig);
    $categoriesArray = $this->categoryConfig;
    
    // CHECK if its a $pageContent array, set the $page ID to the $page parameter
    if(GeneralFunctions::isPageContentArray($ids))
      return array($ids,$ids['category']);
    
    // -> IF ARRAY, separates into page/category
    if(is_array($ids)) {
      $page = $ids[0];
      $category = $ids[1];
    } else
      $page = $ids;
    
    // ->> check for page/category ids (will not affect $page/$category, if they are strings)
    // ******
    
    // GET page by PRIORITY: 1. -> page var 2. -> PROPERTY page var 3. -> false
    $page = ((is_bool($page) || empty($page)) && (!is_bool($category) && !empty($category) ))
      ? false
      : $this->getPropertyPage($page);
     
    // GET the right category for this page
    $category = (is_numeric($page))//&& !is_bool($category) && !is_string($category)
      ? GeneralFunctions::getPageCategory($page)
      // GET category by PRIORITY: 1. -> category var 2. -> PROPERTY category var 3. -> false
      : $this->getPropertyCategory($category);
    // ******
    
    /*
    echo '<br>BEFORE';
    echo '<br />page: '.$page;
    echo '<br />category: '.$category;
    */
    
    // -> if page AND category are IDs, return it right away
    if(is_numeric($page) && is_numeric($category))
      return array($page,$category);
      
    // -> if category doesn't exist return false
    if($category != 0 && is_numeric($category) && !array_key_exists($category, $categoriesArray))
      return false;
    
    // ->> SHORTEN STRINGS
    // page string
    if(is_string($page) && !is_numeric($page)) {
      $page = strtolower($page);
      $page = substr($page,0,4);
      // PREV
      if($page == 'prev') $page = 'prev';
      // NEXT
      elseif($page == 'next') $page = 'next';
      // FIRST
      elseif($page == 'firs' || $page == 'top') $page = 'first';
      // LAST
      elseif($page == 'last' || $page == 'bott') $page = 'last';
      // RANDOM
      elseif($page == 'rand' || $page == 'shuf') $page = 'rand';
    }    
    // category string
    if(is_string($category) && !is_numeric($category)) {
      $category = strtolower($category);
      $category = substr($category,0,4);
      // PREV
      if($category == 'prev') $category = 'prev';
      // NEXT
      elseif($category == 'next') $category = 'next';
      // FIRST
      elseif($category == 'firs' || $category == 'top') $category = 'first';
      // LAST
      elseif($category == 'last' || $category == 'bott') $category = 'last';
      // RANDOM
      elseif($category == 'rand' || $category == 'shuf') $category = 'rand';
    }
    
    // ->> NEXT/PREV PAGE
    // ******
    if($page == 'next' || $page == 'prev') {
      // get category of the current page
      $category = GeneralFunctions::getPageCategory($this->page);     
      // loads all pages in this category
      if(($pages = GeneralFunctions::loadPages($category)) !== false) {
        $pagesCopy = $pages;

        foreach($pages as $eachPage) {
          // if found current page
          if($eachPage['id'] == $this->page) {
            // NEXT
            if($page == 'next' && $next = next($pagesCopy)) {
              while($next && !$next['public']) $next = next($pagesCopy); // prevent to pick a non public page
              return array($next['id'],$next['category']);;
            // PREV
            } elseif($page == 'prev' && $prev = prev($pagesCopy)) {
              while($prev && !$prev['public']) $prev = prev($pagesCopy); // prevent to pick a non public page
              return array($prev['id'],$prev['category']);
            // END of CATEGORY
            } else return false;
          }  
          next($pagesCopy); // move the pointer
        }
      } else
        return false;
    }
    
    // ******
    
    
    //->> GET CATEGORY (next,prev,first,last,rand)
    // ******
    
    // NEXT/PREV CATEGORY
    if($category == 'next' || $category == 'prev') {
      $categoriesArrayCopy = $categoriesArray;
      
      foreach($this->categoryConfig as $eachCategory) {
        // if found current category
        if($eachCategory['id'] == $this->category) {
          // NEXT
          if($category == 'next' && $next = next($categoriesArrayCopy)) {
            while($next && !$this->categoryConfig[$next['id']]['public']) $next = next($categoriesArrayCopy); // prevent to pick a non public category
            $category = $next['id'];
          // PREV
          } elseif($category == 'prev' && $prev = prev($categoriesArrayCopy)) {
            while($prev && !$this->categoryConfig[$prev['id']]['public']) $prev = prev($categoriesArrayCopy); // prevent to pick a non public category
            $category = $prev['id'];
          } else
            return false;
          unset($categoriesArrayCopy);
          break;
        }
        next($categoriesArrayCopy); // move the pointer
      }
    
    // FIRST CATEGORY
    } elseif($category == 'first' && $tmpCategory = reset($categoriesArray)) {
      while($tmpCategory && !$this->categoryConfig[$tmpCategory['id']]['public']) $tmpCategory = next($categoriesArray); // prevent to pick a non public category
      $category = $tmpCategory['id'];
      reset($categoriesArray);
      unset($tmpCategory);
    
    // LAST CATEGORY
    } elseif($category == 'last' && $tmpCategory = end($categoriesArray)) {
      while($tmpCategory && !$this->categoryConfig[$tmpCategory['id']]['public']) $tmpCategory = prev($categoriesArray); // prevent to pick a non public category
      $category = $tmpCategory['id'];
      reset($categoriesArray);
      unset($tmpCategory);
    
    // RANDOM CATEGORY
    } elseif($category == 'rand') {
      $categoriesArrayCopy = $categoriesArray;
      shuffle($categoriesArrayCopy);
      if($tmpCategory = reset($categoriesArrayCopy)) {
        while($tmpCategory && !$this->categoryConfig[$tmpCategory['id']]['public']) $tmpCategory = next($categoriesArrayCopy); // prevent to pick a non public category
        // reached the end? go backwards
        if(!$tmpCategory) while($tmpCategory && !$this->categoryConfig[$tmpCategory['id']]['public']) $tmpCategory = prev($categoriesArrayCopy); // prevent to pick a non public category
        $category = $tmpCategory['id'];
      }
      unset($tmpCategory);
      unset($categoriesArrayCopy);
      
    // CATEGORY is still not an id?
    } elseif(!is_numeric($category))
      return false;
    // ******
    
    //->> GET PAGE (first,last,rand)
    // ******
    if(is_bool($page) || $page == 'first' || $page == 'last' || $page == 'rand') {
   
      // loads all pages in this category
      if(($pages = GeneralFunctions::loadPages($category)) !== false) {

        // FIRST PAGE (first or bool)
        if(($page == 'first' || is_bool($page)) && $tmpPage = reset($pages)) {
          while($tmpPage && !$tmpPage['public']) $tmpPage = next($pages); // prevent to pick a non public page
          return array($tmpPage['id'],$tmpPage['category']);
        // LAST PAGE
        } elseif($page == 'last' && $tmpPage = end($pages)) {
          while($tmpPage && !$tmpPage['public']) $tmpPage = prev($pages); // prevent to pick a non public page
          return array($tmpPage['id'],$tmpPage['category']);
        // RANDOM PAGE
        } elseif($page == 'rand') {
          $pagesCopy = $pages;
          shuffle($pagesCopy);
          if($tmpPage = reset($pagesCopy)) {
            while($tmpPage && !$tmpPage['public']) $tmpPage = next($pagesCopy); // prevent to pick a non public category
            // reached the end? go backwards
            if(!$tmpPage) while($tmpPage && !$tmpPage['public']) $tmpPage = prev($pagesCopy); // prevent to pick a non public category
            return array($tmpPage['id'],$tmpPage['category']);
          }
        }
      }
    }
    // ******
    
    return false;
  }
  
 /**
  * <b>Name</b> getPropertyIdsByType()<br />
  * 
  * If <var>$ids</var> parameter is FALSE it check the ID-type and returns then the {@link Feindura::$page} or {@link Feindura::$category} property.
  * 
  * @param string         $idType   the ID type can be "page", "pages" or "category", "categories"
  * @param int|array|bool $ids      the category or page ID(s), if they are FALSE it returns the property ID, otherwise it passes the ID(s) through
  * 
  * @uses getPropertyPage()         to get the right {@link Feindura::$page} property
  * @uses getPropertyCategory()     to get the right {@link Feindura::$category} property
  * 
  * @return int|false a page or category property ID or FALSE, if there are no property IDs
  * 
  * @see Feindura::listPages()
  * @see Feindura::createMenu()
  * 
  * @access protected
  * @version 1.0
  * <br />
  * <b>ChangeLog</b><br />
  *    - 1.0 initial release
  * 
  */ 
  protected function getPropertyIdsByType($idType,$ids) {
  
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
  * Returns the {@link Feindura::$page} property if the given <var>$page</var> parameter is a Boolean.
  * 
  * @param int|bool $page (optional) a page id or a boolean
  * 
  * @return mixed either the {@link Feindura::$page} property or passes the $page parameter
  * 
  * @access protected
  * @version 1.0
  * <br />
  * <b>ChangeLog</b><br />
  *    - 1.0 initial release
  * 
  */  
  protected function getPropertyPage($page = false) {
    if((is_bool($page) || empty($page)) && is_numeric($this->page))
      return $this->page;  // set the page var from PROPERTY var
    else
      return $page;
  }
  
 /**
  * <b>Name</b> getPropertyCategory()<br />
  * 
  * Returns the {@link Feindura::$category} property if the given <var>$category</var> parameter is a Boolean.
  * 
  * @param int|bool $category (optional) a category id or a boolean
  * 
  * @return int|true the {@link Feindura::$category} property or the $category parameter
  * 
  * @access protected
  * @version 1.0
  * <br />
  * <b>ChangeLog</b><br />
  *    - 1.0 initial release
  *   
  */  
  protected function getPropertyCategory($category = false) {
    if((is_bool($category) || empty($category)) && is_numeric($this->category))
      return $this->category;  // set the category var from PROPERTY var
    else
      return $category;
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
  * @param int|array    $length          the number of maximal characters, or an array with a number for text length and the more string, or a bool, whether to add the more link or not. e.g. array(23,false), array(23,'read more'), or array(23,'<a href="…"'>read more</a>')
  * @param array|false  $pageContent     (optional) the pageContent array of the page to create the "more" link to the page from
  * @param string|false $endString       (optional) a string which will be put after the last character and before the "more" link
  * 
  * @uses createHref()                            create the href for the "more" link
  * @uses GeneralFunctions::isPageContentArray()  check if the given $pageContent parameter is valid  
  * 
  * 
  * @return string the shortened string
  * 
  * @access protected
  * @version 1.1
  * <br />
  * <b>ChangeLog</b><br />
  *    - 1.1 $length parameter can now be an array
  *    - 1.0 initial release  
  * 
  */
  protected function shortenText($string, $length, $pageContent = false, $endString = " ...") {
      
      // vars
      $moreLink = true;
      if(is_array($length)) {
        $moreLink = $length[1];
        $length = $length[0];
      }
      
      // shorten the string
      if($length < mb_strlen($string,'UTF-8')) {
        // go until you found a whitespace
        while(mb_substr($string,$length,1,'UTF-8') != ' ' && $length < mb_strlen($string,'UTF-8')) {   
          $length++;
        }        
        $string = mb_substr($string,0,$length,'UTF-8');

        // adds the endString
        if(is_string($endString))
          $string .= $endString;
      }
      
      $string = preg_replace("/ +/", ' ', $string);
      
      // adds the MORE LINK
      if(is_string($moreLink) && strpos($moreLink,'<a ') !== false) {
        $string .= " \n".$moreLink;
      } elseif($moreLink && GeneralFunctions::isPageContentArray($pageContent)) {
        $text = (is_string($moreLink) && !is_bool($moreLink)) ? $moreLink : $this->languageFile['PAGE_TEXT_MORE'];
        $string .= " \n".'<a href="'.$this->createHref($pageContent).'">'.$text.'</a>';
      }
      
      return $string;
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
  * @param int|array    $length          the number of maximal characters, or an array with a number for text length and the more string, or a bool, whether to add the more link or not. e.g. array(23,false), array(23,'read more'), or array(23,'<a href="…"'>read more</a>')
  * @param array|false  $pageContent     (optional) the pageContent array of the page to create the "more" link to the page from
  * @param string|false $endString       (optional) a string which will be put after the last character and before the "more" link
  * 
  * @uses shortenText()   shorten the text
  * @uses createHref()    create the href for the "more" link 
  * 
  * @return string the shortened string
  * 
  * @access protected
  * @version 1.1
  * <br />
  * <b>ChangeLog</b><br />
  *    - 1.1 $length parameter can now be an array
  *    - 1.0 initial release
  * 
  */  
  protected function shortenHtmlText($input, $length, $pageContent = false, $endString = ' ...') {

      // vars
      $textWasCut = false;
      $rawText = strip_tags($input);
      $moreLink = true;
      
      if(is_array($length)) {
        $moreLink = $length[1];
        $length = $length[0];
      }
      
      // only if the given LENGTH is SMALLER than the RAW TEXT, SHORTEN the TEXT
      // ***********************************************
      if(is_numeric($length) && $length < mb_strlen($rawText,'UTF-8')) {
        
        // -> FIND THE REAL POSITION, for LENGTH
        // find the real position in the html text
        // it goes from the beginning trough every char and count only the chars which are not in <...>
        $currentLength = 0;
        $position = 0;
        $inTag = false;
        
        // goes trough the text and find the real position
        while($currentLength != $length) {
          // get the CURRENT CHAR
          $actualChar = mb_substr($input, $position, 1,'UTF-8');
          
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
        $input = $this->shortenText($input,array($position,false),false,false);
        
        // checks if there is a unclosed html tag (example: <h1..)
        // and shortens the string from this unclosed tag
        if(mb_strrpos($input, "<",'UTF-8') !== false && mb_strrpos($input, "<",'UTF-8') > mb_strrpos($input, ">",'UTF-8')) {
          $input = mb_substr($input, 0, mb_strrpos($input, "<",'UTF-8'),'UTF-8');
        }
      
        // goes trough the tags and stores the opend ones in an array
        // (auch die durch daskürzen verlorengegangenen)
        $opened = array();
        // loop through opened and closed tags in order
        // die REGULAR EXPRESSIONS pattern sucht nach allen HTML tags
        if(preg_match_all('!<(/?\w+)((\s+\w+(\s*=\s*(?:".*?"|\'.*?\'|[^\'">\s]+))?)+\s*|\s*)/?\>!is', $input, $matches)) {
          foreach($matches[1] as $tag) {
            //echo 'Tag: '.$tag."<br />\n";        
            $tag = mb_strtolower($tag,'UTF-8');
            
            // looks if its a opening or closing tag
            if(mb_substr($tag, 0, 1,'UTF-8') != '/') {          
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
              $tag = mb_substr($tag, 1, mb_strlen($tag,'UTF-8'),'UTF-8');
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
      
      // add the MORE LINK
      if(is_string($moreLink) && strpos($moreLink,'<a ') !== false) {
        $moreLink = " \n".$moreLink;
      } elseif($moreLink && GeneralFunctions::isPageContentArray($pageContent)) {
        $text = (is_string($moreLink) && !is_bool($moreLink)) ? $moreLink : $this->languageFile['PAGE_TEXT_MORE'];
        $moreLink = " \n".'<a href="'.$this->createHref($pageContent).'">'.$text.'</a>';
      }
      
      $output = $input;
      
      // removes the last \r\n on the end
      if(mb_substr($output,-1,mb_strlen($output,'UTF-8'),'UTF-8') == "\n")
        $output = mb_substr($output,0,-2,'UTF-8');        
      if(mb_substr($input,-1,mb_strlen($input,'UTF-8'),'UTF-8') == "\r")
        $output = mb_substr($output,0,-2,'UTF-8');
      
      // if string was shorten
      if($textWasCut) {
        // try to put the endString before the last HTML-Tag and add the more link
        if(mb_substr($output,-1,mb_strlen($output,'UTF-8'),'UTF-8') == '>') {
          $lastTagPos = mb_strrpos($output, '</','UTF-8');
          $lastTag = mb_substr($output,$lastTagPos,mb_strlen($output,'UTF-8'),'UTF-8');
          $output = mb_substr($output,0,$lastTagPos,'UTF-8').$endString.$lastTag;
        } else
          $output .= $endString;
      }
      
      // returns the shorten HTML-Text
      return $output.$moreLink;
  }
}
?>