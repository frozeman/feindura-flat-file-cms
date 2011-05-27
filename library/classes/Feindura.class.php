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
 * This file contains the {@link feindura} class for implementing the CMS in a website.
 * 
 * @package [Implementation]
 */

/**
* The class for implementing feindura - Flat File Content Management System in a website.
* 
* It's methods provide necessary functions for implementing the CMS in a website.<br />
* It contains, for example, methods for building a menu and get page contents, etc.
* 
* @author Fabian Vogelsteller <fabian@feindura.org>
* @copyright Fabian Vogelsteller
* @license http://www.gnu.org/licenses GNU General Public License version 3
* 
* @package [Implementation]
* 
* @version 1.0.1
* <br />
* <b>ChangeLog</b><br />
*    - 1.0.1 add setStartPage()
*    - 1.0 initial release
* 
*/
class Feindura extends FeinduraBase {
  
 /* ---------------------------------------------------------------------------------------------------------------------------- */
 /* *** PROPERTIES */
 /* **************************************************************************************************************************** */
 
 /* ->> GENERAL <<- */
 
 /**
  * TRUE when the pages content should be handled as XHTML.
  * 
  * In XHTML standalone tags end with " />" instead of ">".<br />
  * Therefor when a page content is displayed and this property is <i>FALSE</i> all " />" will be changed to ">".
  * 
  * @var bool
  * @access public
  */
  public $xHtml = true;
  
 /**
  * Contains the current page ID get from the <var>$_GET</var> variable.
  * 
  * This property is used when a page loading method is called (for example: {@link showPage()}) and no page ID parameter is given.
  * 
  * This property will be set in the {@link feindura()} constructor through the {@link setCurrentPageId()} method.
  * 
  * @var int
  * @access public
  * 
  * @see feindura()
  * @see FeinduraBase::getCurrentPageId()
  * 
  */
  public $page = null;
  
 /**
  * Contains the current category ID get from the <var>$_GET</var> variable.
  * 
  * This property is used when a page-loading method is called (for example: {@link showPage()}) and no category ID parameter is given.
  * 
  * This property will be set in the {@link feindura()} constructor through the {@link setCurrentCategoryId()} method.
  * 
  * @var int
  * @access public
  * 
  * @see feindura()
  * @see FeinduraBase::getCurrentCategoryId()
  * 
  */
  public $category = null;
   
 /**
  * Contains the startpage ID from the {@link FeinduraBase::$websiteConfig website-settings config}.
  * 
  * This property is set to the {@link $page} property when the <var>$_GET</var> page variable
  * and the {@link $page} property is empty and setting a startpage is activated in the {@link $adminConfig page-settings}.
  * 
  * This property will be set in the {@link feindura()} constructor through the {@link setCurrentPageId()} method.
  * 
  * @var int
  * @access public
  * 
  * @see $page
  * @see feindura()
  * @see setCurrentPageId()
  * @see getCurrentPageId()
  * 
  */
  public $startPage = null;
  
 /**
  * Contains the startcategory ID
  * 
  * Its fetched from the {@link $startPage} through the {@link GeneralFunctions::getPageCategory()} method.<br />
  * This property is set to the {@link $category} property when the <var>$_GET</var> category variable
  * and the {@link $category} property is empty and setting a startpage is activated in the {@link $adminConfig page-settings}.
  * 
  * This property will be set in the {@link feindura()} constructor through the {@link setCurrentCategoryId()} method.
  * 
  * @var int
  * @access public
  * 
  * @see $startPage
  * @see $category
  * @see feindura()
  * @see setCurrentCategoryId()
  * @see getCurrentCategoryId()
  * 
  */
  public $startCategory = null;
  
  /* ->> LINK <<- */
  
 /**
  * The number of maximal visible characters in the link text
  * of any link created by {@link createLink()} or {@link createMenu()}.
  * 
  * The link text will be shorten to the last complete word.
  * 
  * For example the following string will be shorten to a <var>$linkLength</var> of <i>"30"</i>:
  * <samp>
  * "Example Category -> Example Page Title" => "Example Category -> Example..."
  * </samp>
  * 
  * @var int|false Number of characters or FALSE to don't shorten the link text
  * @access public
  * 
  * @see createLink()
  * @see createMenu()
  * @example createLink.example.php
  * 
  */
  public $linkLength = false;  

 /**
  * Contains an id-Attribute which will be add to any <a ...> tag
  * of any link created by {@link createLink()} or {@link createMenu()}.
  * 
  * <b>Notice</b>: You can only set one specific id-Attribute to elements in a HTML page,
  * if you set this property and call {@link createMenu()} every link in the menu will get this id-Attribute.
  * 
  * @var string|false If no id-Attribute should be add, set it to FALSE.
  * @access public
  * 
  * @see createLink()
  * @see createMenu()
  * @example createLink.example.php
  * 
  */
  public $linkId = false;
  
 /**
  * Contains an class-Attribute which will be add to any <a ...> tag
  * of any link created by {@link createLink()} or {@link createMenu()}.
  * 
  * <b>Notice</b>: If you set this property and call {@link createMenu()} every link in the menu will get this class-Attribute.
  * 
  * @var string|false If no class-Attribute should be add, set it to FALSE.
  * @access public
  * 
  * @see createLink()
  * @see createMenu()
  * @example createLink.example.php
  * 
  */
  public $linkClass = false;
  
 /**
  * Contains a string with attributes which will be add to any <a ...> tag
  * of any link created by {@link createLink()} or {@link createMenu()}.
  * 
  * <b>Notice</b>: If you set this property and call {@link createMenu()} every link in the menu will get this attributes string.
  * 
  * The string should have the following format
  * <samp>
  * 'key1="value" key2="value"'
  * </samp>
  * 
  * @var string|false If no additional attributes should be add, set it to FALSE.
  * @access public
  * 
  * @see createLink()
  * @see createMenu()
  * @example createLink.example.php
  * 
  */
  public $linkAttributes = false;

 /**
  * Contains a string which will be add before any <a></a> tag
  * of any link created by {@link createLink()} or {@link createMenu()}.
  * 
  * <b>Notice</b>: If you set this property and call {@link createMenu()} every link in the menu will get this text.
  * 
  * @var string|false If no text should be add before a link, set it to FALSE.
  * @access public
  * 
  * @see createLink()
  * @see createMenu()
  * @example createLink.example.php
  * 
  */
  public $linkBefore = false;
  
 /**
  * Contains a string which will be add after any <a></a> tag
  * of any link created by {@link createLink()} or {@link createMenu()}.
  * 
  * <b>Notice</b>: If you set this property and call {@link createMenu()} every link in the menu will get this text.
  * 
  * @var string|false If no text should be add after a link, set it to FALSE.
  * @access public
  * 
  * @see createLink()
  * @see createMenu()
  * @example createLink.example.php
  * 
  */
  public $linkAfter = false;
  
 /**
  * Contains a string which will be add before the link text but inside any <a></a> tag
  * of any link created by {@link createLink()} or {@link createMenu()}.
  * 
  * <b>Notice</b>: If you set this property and call {@link createMenu()} every link in the menu will get this text.  
  * 
  * @var string|false If no text should be add before a link text, set it to FALSE.
  * @access public
  * 
  * @see createLink()
  * @see createMenu()
  * @example createLink.example.php
  * 
  */
  public $linkBeforeText = false;
  
 /**
  * Contains a string which will be add after the link text but inside any <a></a> tag
  * of any link created by {@link createLink()} or {@link createMenu()}.
  * 
  * <b>Notice</b>: If you set this property and call {@link createMenu()} every link in the menu will get this text.  
  * 
  * @var string|false If no text should be add after a link text, set it to FALSE.
  * @access public
  * 
  * @see createLink()
  * @see createMenu()
  * @example createLink.example.php
  * 
  */
  public $linkAfterText = false;
  
 /**
  * If TRUE and the page has a thumbnail it places the thumbnail <img> tag inside the <a></a> tag
  * of any link created by {@link createLink()} or {@link createMenu()}.
  * 
  * @var bool Set it to FALSE to don't show the thumbnails in links
  * @access public
  * 
  * @see createLink()
  * @see createMenu()
  * @example createLink.example.php
  * 
  */
  public $linkShowThumbnail = false;
  
 /**
  * If TRUE and thumbnail <img> tag will be placed after the link text but inside the <a></a> tag
  * of any link created by {@link createLink()} or {@link createMenu()}.
  * 
  * 
  * @var bool Set it to TRUE to place the thumbnail <img> tag after the link text
  * @access public
  * 
  * @see createLink()
  * @see createMenu()
  * @example createLink.example.php
  * 
  */
  public $linkShowThumbnailAfterText = false;
  
 /**
  * If TRUE, page dates are allowed for the pages in this category and the page has a page date then it will be add before the link text
  * of any link created by {@link createLink()} or {@link createMenu()}.
  * 
  * If the {@link $linkShowCategory} property is TRUE, the page date is placed between the category name + seperator and the link text.<br />
  * The page date will be added with the page before-date-text and after-date-text from the page editor in the backend
  *   
  * <b>Notice</b>: The page date will only be displayed if the <var>$linkText</var> parameter of {@link createLink()} or {@link createMenu()} methods is TRUE and not a string.
  * 
  * Example:
  * <samp>
  * <a href="?page=2" ...>Catgory Name: 200-12-31 Page Title</a>
  * </samp>
  *    
  * @var bool Set it to TRUE to place the page date before the link text
  * @access public
  * 
  * @see createLink()
  * @see createMenu()
  * @example createLink.example.php
  * 
  */
  public $linkShowPageDate = false;

 /**
  * If TRUE, the category name of the page will be add before the link text
  * with the {@link $linkCategorySpacer} property as seperator of any link created by {@link createLink()} or {@link createMenu()}.
  * 
  * The category name will only be displayed if the <var>$linkText</var> parameter of {@link createLink()} or {@link createMenu()} methods is TRUE and not a string.
  * 
  * Example:
  * <samp>
  * <a href="?page=2" ...>Catgory Name: Page Title</a>
  * </samp>
  * 
  * @var bool Set it to TRUE to place the category name before the link text
  * @access public
  * 
  * @see createLink()
  * @see createMenu()
  * @example createLink.example.php
  * 
  */
  public $linkShowCategory = false;
  
 /**
  * If the {@link $linkShowCategory} property is TRUE,
  * this string will be used as a seperator between the category name and the link text of any link created by {@link createLink()} or {@link createMenu()}.
  * 
  * <b>Notice</b>: If you set this property and call {@link createMenu()} every link in the menu will use this seperator.
  * 
  * @var string
  * @access public
  * 
  * @see createLink()
  * @see createMenu()
  * @example createLink.example.php
  * 
  */
  public $linkCategorySeparator = ': ';
  
  /* ->> MENU <<- */
  
 /**
  * Contains an id-Attribute which will be add to the menu tag.
  * 
  * <b>Notice 1</b>: This id-Attribute will only be add, if the <var>$menuTag</var> parameter in the {@link createMenu()} method is not FALSE.<br />
  * <b>Notice 2</b>: You can only set one specific id-Attribute to elements in a HTML page.
  * 
  * @var string|false If no id-Attribute should be add, set it to FALSE.
  * @access public
  * 
  * @see createMenu()
  * @example createMenu.example.php
  * 
  */
  public $menuId = false;
  
 /**
  * Contains an class-Attribute which will be add to the menu tag.
  * 
  * <b>Notice</b>: This class-Attribute will only be add, if the <var>$menuTag</var> parameter in the {@link createMenu()} method is not FALSE.<br />
  * 
  * @var string|false If no class-Attribute should be add, set it to FALSE.
  * @access public
  * 
  * @see createMenu()
  * @example createMenu.example.php
  * 
  */
  public $menuClass = false;
  
 /**
  * Contains a string with attributes which will be add to the menu tag.
  * 
  * <b>Notice</b>: This string with attributes will only be add, if the <var>$menuTag</var> parameter in the {@link createMenu()} method is not FALSE.<br />
  * 
  * The string should have the following format
  * <samp>
  * 'key1="value" key2="value"'
  * </samp>
  *    
  * @var string|false If no additional attributes should be add, set it to FALSE.
  * @access public
  * 
  * @see createMenu()
  * @example createMenu.example.php
  * 
  */
  public $menuAttributes = false;
  
  /* ->> TITLE <<- */
  
 /**
  * A number of maximal characters visible in the page title.
  * 
  * The page title will be shorten to the last complete word.
  * 
  * For example the following string will be shorten to a <var>$titleLength</var> of <i>"30"</i>:
  * <samp>
  * "Example Category -> Example Page Title" => "Example Category -> Example..."
  * </samp>
  * 
  * @var int|false Number of characters or FALSE to don't shorten the page title
  * @access public
  * 
  * @see getTitle()
  * @see FeinduraBase::createTitle()
  * @example showPage.example.php
  * 
  */
  public $titleLength = false;
  
 /**
  * If TRUE the page title is also a link to the page.
  * 
  * @var bool
  * @access public
  * 
  * @see getTitle()
  * @see FeinduraBase::createTitle()
  * @example showPage.example.php
  * 
  */
  public $titleAsLink = false;

 /**
  * If TRUE, page dates are allowed for the pages in this category and the page has a page date then it will be add before the page title.
  * 
  * If the {@link $titleShowCategory} property is TRUE, the page date is placed between the category name + seperator and the page title.<br />
  * The page date will be added with the page before-date-text and after-date-text from the page editor in the backend.
  * 
  * Example:
  * <samp>
  * Catgory Name: 200-12-31 Page Title
  * </samp>
  * 
  * @var bool Set it to TRUE to place the page date before the page title
  * @access public
  * 
  * @see getTitle()
  * @see FeinduraBase::createTitle()
  * @example showPage.example.php
  * 
  */
  public $titleShowPageDate = false;
  
 /**
  * If TRUE, the category name of the page will be add before the page title with the {@link $linkCategorySpacer} property as seperator.
  * 
  * Example:
  * <samp>
  * Catgory Name: Page Title
  * </samp>
  * 
  * @var bool Set it to TRUE to place the category name before the page title
  * @access public
  * 
  * @see getTitle()
  * @see FeinduraBase::createTitle()
  * @example showPage.example.php
  * 
  */
  public $titleShowCategory = false;
  
 /**
  * If the {@link $titleShowCategory} property is TRUE, this string will be used as a seperator between the category name and the page title.
  * 
  * @var string
  * @access public
  * 
  * @see getTitle()
  * @see FeinduraBase::createTitle()
  * @example showPage.example.php
  * 
  */
  public $titleCategorySeparator = ': ';
  
  /* ->> THUMBAIL <<- */

 /**
  * Contains the position of the thumbnail picture, the possible values are "left", "right" or FALSE.
  * 
  * If the values are "left" or "right" a style-attribute will be add to the thumbnail <img> tag with "float:left/right;".
  * 
  * <b>Notice</b>: If you set this property, you can't add any style attribute with the {@link $thumbnailAttributes} property anymore, it would not be used by the browser.
  * 
  * <samp>
  * <img src="/path/image.png" ... style="float:left;" />
  * </samp>
  * 
  * @var string|false If no style="float:left/right;" attribute should be add, set it to FALSE.
  * @access public
  * 
  * @see createLink()
  * @see createMenu()
  * @see showPage()
  * @see feindura:generatePage()
  * @example showPage.example.php
  * 
  */
  public $thumbnailAlign = false;
  
 /**
  * Contains an id-Attribute which will be add to the thumbnail <img> tag.
  * 
  * <b>Notice</b>: You can only set one specific id-Attribute to elements in a HTML page.
  * 
  * @var string|false If no id-Attribute should be add, set it to FALSE.
  * @access public
  * 
  * @see createLink()
  * @see createMenu()
  * @see showPage()
  * @see feindura:generatePage()
  * @example showPage.example.php
  * 
  */
  public $thumbnailId = false;
  
 /**
  * Contains an class-Attribute which will be add the thumbnail <img> tag.
  * 
  * @var string|false If no class-Attribute should be add, set it to FALSE.
  * @access public
  * 
  * @see createLink()
  * @see createMenu()
  * @see showPage()
  * @see feindura:generatePage()
  * @example showPage.example.php
  * 
  */
  public $thumbnailClass = false;

 /**
  * Contains a string with attributes which will be add the thumbnail <img> tag.
  * 
  * The string should have the following format
  * <samp>
  * 'key1="value" key2="value"'
  * </samp>
  * 
  * @var string|false If no additional attributes should be add, set it to FALSE.
  * @access public
  * 
  * @see createLink()
  * @see createMenu()
  * @see showPage()
  * @see feindura:generatePage()
  * @example showPage.example.php
  * 
  */
  public $thumbnailAttributes = false;
  
 /**
  * Contains a string which will be add before the thumbnail <img> tag.
  * 
  * @var string|false If no string should be add before the thumbnail <img> tag, set it to FALSE.
  * @access public
  * 
  * @see createLink()
  * @see createMenu()
  * @see showPage()
  * @see feindura:generatePage()
  * @example showPage.example.php
  * 
  */
  public $thumbnailBefore = false;
  
 /**
  * Contains a string which will be add after the thumbnail <img> tag.
  * 
  * @var string|false If no string should be add after the thumbnail <img> tag, set it to FALSE.
  * @access public
  *  
  * @see createLink()
  * @see createMenu()
  * @see showPage()
  * @see feindura:generatePage()
  * @example showPage.example.php
  * 
  */
  public $thumbnailAfter = false;
  
  /* ->> ERROR <<- */
  
 /**
  * If TRUE an error will be displayed if the requested page doesn't exists or is currently not public.
  * 
  * Example:
  * <samp>
  * <span>The requested page is currently not available.</span>
  * </samp>
  * 
  * @var bool
  * @access public
  * 
  * @see showPage()
  * @see feindura:generatePage()
  * @example showPage.example.php
  * 
  */
  public $showErrors = true;
  
 /**
  * The tag which should be used for the error message.
  * 
  * <b>Notice</b>: If this property is no string, the {@link $errorId}, {@link $errorClass} and {@link $errorAttributes} property will not be add.<br />
  * 
  * Example:
  * <samp>
  * <span>The requested page is currently not available.</span>
  * </samp>
  * 
  * @var string|false If no tag should be add, set it to FALSE.
  * @access public
  * 
  * @see showPage()
  * @see feindura:generatePage()
  * @example showPage.example.php
  * 
  */
  public $errorTag = 'span';                // [False or String]      -> the message TAG which is used when creating a message (STANDARD Tag: SPAN; if there is a class and/or id and no TAG is set)
 
 /**
  * Contains an id-Attribute which will be add to the error tag.
  * 
  * <b>Notice 1</b>: This id-Attribute will only be add, if the {@link $errorTag} property is a string and not FALSE.<br />
  * <b>Notice 2</b>: You can only set one specific id-Attribute to elements in a HTML page.
  * 
  * Example:
  * <samp>
  * <span id="exampleId">The requested page is currently not available.</span>
  * </samp>
  * 
  * @var string|false If no id-Attribute should be add, set it to FALSE.
  * @access public
  * 
  * @see showPage()
  * @see feindura:generatePage()
  * @example showPage.example.php
  * 
  */
  public $errorId = false;
  
 /**
  * Contains an class-Attribute which will be add to the error tag.
  * 
  * <b>Notice</b>: This class-Attribute will only be add, if the {@link $errorTag} property is a string and not FALSE.<br />
  * 
  * Example:
  * <samp>
  * <span class="exampleId">The requested page is currently not available.</span>
  * </samp>
  * 
  * @var string|false If no class-Attribute should be add, set it to FALSE.
  * @access public
  * 
  * @see showPage()
  * @see feindura:generatePage()
  * @example showPage.example.php
  * 
  */
  public $errorClass = false;
  
 /**
  * Contains a string with attributes which will be add the error tag.
  * 
  * 
  * The string should have the following format
  * <samp>
  * 'key1="value" key2="value"'
  * </samp>
  * 
  * Example:
  * <samp>
  * <span key1="value" key2="value">The requested page is currently not available.</span>
  * </samp>
  * 
  * @var string|false If no additional attributes should be add, set it to FALSE.
  * @access public
  * 
  * @see showPage()
  * @see feindura:generatePage()
  * @example showPage.example.php
  * 
  */
  public $errorAttributes = false;

 /* ---------------------------------------------------------------------------------------------------------------------------- */
 /* *** CONSTRUCTOR *** */
 /* **************************************************************************************************************************** */
  
 /**
  * <b>Type</b> constructor<br /> 
  * 
  * The constructor of the class, sets all basic properties.
  * 
  * Run the {@link FeinduraBase::__construct()} class constructor to set all necessary properties
  * Fetch the <var>$_GET</var> variable (if existing) and set it to the {@link $page} and {@link $category} properties.<br />
  * If there is no page and category ID it sets the start page ID from the {@link FeinduraBase::$websiteConfig website-settings config}.
  * 
  * Example:
  * {@example includeFeindura.example.php}
  * 
  * @param string $language (optional) A country code like "de", "en", ... to load the right frontend language-file and is also set to the {@link FeinduraBase::$language} property 
  * 
  * @uses FeinduraBase::__construct()		          the constructor of the parent class to load all necessary properties
  * @uses FeinduraBase::setCurrentCategoryId()  to set the fetched category ID from the $_GET variable to the {@link $category} property
  * @uses FeinduraBase::setCurrentPageId()      to set the fetched page ID from the $_GET variable to the {@link $page} property
  * 
  * @return void
  * 
  * @see FeinduraBase::__construct()
  * 
  * @access public
  * @version 1.0
  * <br />
  * <b>ChangeLog</b><br />
  *    - 1.0 initial release
  * 
  */
  public function __construct($language = false) {
    
    // RUN the FeinduraBase constructor
    parent::__construct($language);
    
    // saves the current GET vars in the PROPERTIES
    // ********************************************
    $this->setCurrentCategoryId(true);       // get $_GET['category']  -> first load category then the page, because getCurrentPageId need categories
    $this->setCurrentPageId(true);           // get $_GET['page'] <- set the $this->websiteConfig['startPage'] if there is no $_GET['page'] variable
  
  } 
  
  // ****************************************************************************************************************
  // METHODs -------------------------------------------------------------------------------------------------
  // ****************************************************************************************************************
  
 /**
  * <b>Name</b>     setStartPage()<br />
  * 
  * Set a page ID to the {@link $startPage} and {@link $page} property.
  * 
  * 
  * @param int $pageId the page ID to set
  * 
  * @uses $startPage
  * @uses $page
  * @uses GeneralFunctions::getPageCategory()        to get the category of the page    
  * 
  * @return void
  * 
  * @access public
  * @version 1.0
  * <br />
  * <b>ChangeLog</b><br />
  *    - 1.0 initial release
  * 
  */
  public function setStartPage($pageId) {
    
    if(is_numeric($pageId)) {
      $this->startPage = $pageId;
      $this->startCategory = GeneralFunctions::getPageCategory($pageId);
      $this->setCurrentPageId($pageId);
    }  
  }
  
 /**
  * <b>Name</b>     setLanguage()<br />
  * 
  * Set the {@link FeinduraBase::$language} property and reloads the frontend language file.
  * 
  * <b>Notice</b> The country code will NOT set to any <var>$_SESSION</var> variable, you have to take care of this yourself.
  * 
  * 
  * @param string $language a language country code like "en", "de", ...
  * 
  * @uses FeinduraBase::$language	the language country code like "en", "de", ... which will be returned
  * 
  * @return string|false the {@link $language language country code} or FALSE if the given $language parameter is no country code
  * 
  * @see feindura()  
  * @see FeinduraBase::__construct()
  * 
  * @access public
  * @version 1.0
  * <br />
  * <b>ChangeLog</b><br />
  *    - 1.0 initial release
  * 
  */
  public function setLanguage($language) {
    
    if(is_string($language) && strlen($language) == 2) {
      
      $this->language = $language;
      $this->loadFrontendLanguageFile($this->language);
      
      return $this->language;
    } else
      return false;
  }  

 /**
  * <b>Name</b>     getLanguage()<br />
  * 
  * Returns the {@link $language language country code} which was set in the feindura:FeinduraBase() constructor.
  * 
  * @uses FeinduraBase::$language	the language country code like "en", "de", ... which will be returned
  * 
  * @return string the {@link $language language country code}
  * 
  * @see feindura()  
  * @see FeinduraBase::__construct()
  * 
  * @access public
  * @version 1.0
  * <br />
  * <b>ChangeLog</b><br />
  *    - 1.0 initial release
  * 
  */
  public function getLanguage() {
    return $this->language;
  }
  
  /**
  * <b>Name</b>     getLanguageFile()<br />
  * 
  * 
  * Check a specific directory for files which have a language code inside the filename (see <var>$filename</var> parameter). hen a matching file is found it includes these and return it.
  * If no match could be found it try to find a file with the browser language code, if this didnt work either it uses the <var>$standardLang</var> parameter.
  * 
  * Example of a language file
  * {@example languageFile.array.example.php}
  * 
  * <b>Used Constants</b><br />
  *    - <var>DOCUMENTROOT</var> the absolut path of the webserver
  * 
  * @param string|false $langPath         (optional) a absolut path to look for a language file which fit the $filename parameter or FALSE to use the "feindura-cms/library/languages" folder
  * @param string       $filename         (optional) the structure of the filename, which should be loaded. the "%lang%" will be replaced with the country code like "%lang%.backend.php" -> "en.backend.php"
  * @param string@false &$currentLangCode (optional) (Note: this variable will also be changed outside of this method) a variable with the current language code, if this is set it will be first try to load this language file, when it couldn't a language file which fits the browsers language code will be loaded.  
  * @param bool         $standardLang     (optional) a standard language for use if no match was found
  * 
  * 
  * @uses GeneralFunctions::loadLanguageFile() to load the right language file 
  * 
  * @return array the loaded language file array or an empty array
  * 
  * @see GeneralFunctions::loadLanguageFile()
  * 
  * @access public
  * @version 1.0
  * <br />
  * <b>ChangeLog</b><br />
  *    - 1.0 initial release
  * 
  */
  public function getLanguageFile($langPath = false, $filename = '%lang%.php', &$currentLangCode = false, $standardLang = 'en') {
    
    // add slash on the end
    if(substr($langPath,-1) != '/')
      $langPath .= '/';
    
    // adds the DOCUMENTROOT
    $langPath = str_replace('\\','/',$langPath);
    $langPath = str_replace(DOCUMENTROOT,'',$langPath);  
    $langPath = DOCUMENTROOT.$langPath;
    
    if(empty($currentLangCode))
      $currentLangCode = $this->language;
    
    $langFile = GeneralFunctions::loadLanguageFile($langPath,$filename,$currentLangCode,$standardLang);
    
    return $langFile;
  }
  
 /**
  * <b>Name</b>     createMetaTags()<br />
  * <b>Alias</b>    createMetaTag()<br />
  * 
  * Creates a string with basic HTML5 meta tags. See the example for a detailed list of the meta tags created.
  * 
  * <b>Notice</b>: You have to call this method in the <head> tags of your website, to enable the frontend editing feature.
  * <b>Notice</b>: This method also adds the Feed tags.  
  * 
  * Example:
  * {@example createMetaTags.example.php}
  * 
  * @param string       $charset      (optional) the charset used in the website like "UTF-8", "iso-8859-1", ...
  * @param string|false $author       (optional) the author of the website
  * @param string|bool  $publisher    (optional) the publisher of the website, if TRUE it uses the publisher from the {@link FeinduraBase::$websiteConfig website-settings config}
  * @param string|bool  $copyright    (optional) the copyright owner of the website, if TRUE it uses the copyright from the {@link FeinduraBase::$websiteConfig website-settings config}
  * @param string|bool  $robotTxt     (optional) if TRUE it sets the "robot.txt" file relative to this HTML page, if this parameter is a string it will be used as e.g. "path/robots.txt"
  * @param int|false    $revisitAfter (optional) a number of days to revisit the page as information for webcrawler, if FALSE this meta tag will not be set
  * 
  * @uses Feindura::$page               to load the page title of teh righte page
  * @uses Feindura::$category         to load the page title of teh righte page
  * @uses FeinduraBase::$websiteConfig  for the website title, publisher, copyright, description and keywords
  * @uses GeneralFunctions::readPage()	to load the page for the page title
  * 
  * @return string with all meta tags ready to display in a HTML page
  * 
  * @access public
  * @version 1.01
  * <br />
  * <b>ChangeLog</b><br />
  *    - 1.01 changed readPage() from getCurrentPage() to use only the page property
  *    - 1.0 initial release
  * 
  */
  public function createMetaTags($charset = 'UTF-8', $author = false, $publisher = true, $copyright = true, $robotTxt = false, $revisitAfter = '10') {
      
      // vars
      $metaTags = '';
      $pageNameInTitle = '';
      $needMootools =  false;
      
      // -> clear xHTML tags from the content
      if($this->xHtml === true) {   
        //$siteType = 'application/xhtml+xml';
        $tagEnding = ' />';
      } else {
        //$siteType = 'text/html';
        $tagEnding = '>';
      }
      
      // -> add CHARSET
      //$metaTags .= '<meta http-equiv="content-type" content="'.$siteType.'; charset='.$charset.'"'.$tagEnding."\n";
      $metaTags .= '<meta charset="'.$charset.'"'.$tagEnding."\n";
      
      // -> add language
      if($this->language)
        $metaTags .= '  <meta http-equiv="content-language" content="'.$this->language.'"'.$tagEnding."\n\n";

      // -> create TITLE
      if($this->getCurrentPageId() && ($currentPage = GeneralFunctions::readPage($this->page,$this->category)))
        $pageNameInTitle = strip_tags($currentPage['title']).' - ';
      
      // -> add TITLE
      $metaTags .= '  <title>'.$pageNameInTitle.$this->websiteConfig['title'].'</title>'."\n\n";
      
      // -> add BASE PATH if SPEAKING URLS are ON
      if($this->adminConfig['speakingUrl'])
        $metaTags .= '  <base href="'.$this->adminConfig['url'].GeneralFunctions::getDirname($this->adminConfig['websitePath']).'"'.$tagEnding."\n\n";
      
      // -> add robots.txt
      if($robotTxt === true)
        $metaTags .= '  <meta name="siteinfo" content="robots.txt"'.$tagEnding."\n";
      elseif(!empty($robotTxt))
        $metaTags .= '  <meta name="siteinfo" content="'.$robotTxt.'"'.$tagEnding."\n";
        
      // -> add REVISIT AFTER
      if($revisitAfter !== false && is_numeric($revisitAfter))
        $metaTags .= '  <meta name="revisit_after" content="'.$revisitAfter.'"'.$tagEnding."\n\n";
      
      // -> add other META TAGs
      $metaTags .= '  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"'.$tagEnding.' <!-- enable google chrome frame, if available -->'."\n";
      $metaTags .= '  <meta name="viewport" content="width=device-width, initial-scale=0.5"'.$tagEnding.' <!-- set width for mobile devices -->'."\n\n";
      //$metaTags .= '  <meta http-equiv="pragma" content="no-cache"'.$tagEnding.' <!-- browser/proxy does not cache -->'."\n";
      //$metaTags .= '  <meta http-equiv="cache-control" content="no-cache"'.$tagEnding.' <!-- browser/proxy does not cache -->'."\n\n";
      
      // -> add title
      $metaTags .= '  <meta name="title" content="'.$pageNameInTitle.$this->websiteConfig['title'].'"'.$tagEnding."\n";
      
      // -> add author
      if($author && is_string($author))
        $metaTags .= '  <meta name="author" content="'.$author.'"'.$tagEnding."\n";
        
      // -> add puplisher
      if($publisher && is_string($publisher))
        $metaTags .= '  <meta name="publisher" content="'.$publisher.'"'.$tagEnding."\n";
      elseif($publisher === true && !empty($this->websiteConfig['publisher']))
        $metaTags .= '  <meta name="publisher" content="'.$this->websiteConfig['publisher'].'"'.$tagEnding."\n";
        
      // -> add copyright
      if($copyright && is_string($copyright))
        $metaTags .= '  <meta name="copyright" content="'.$copyright.'"'.$tagEnding."\n";
      elseif($copyright === true && !empty($this->websiteConfig['copyright']))
        $metaTags .= '  <meta name="copyright" content="'.$this->websiteConfig['copyright'].'"'.$tagEnding."\n";
        
      // -> add description
      if(isset($currentPage) && $currentPage['description'])
        $metaTags .= '  <meta name="description" content="'.$currentPage['description'].'"'.$tagEnding."\n";
      elseif($this->websiteConfig['description'])
        $metaTags .= '  <meta name="description" content="'.$this->websiteConfig['description'].'"'.$tagEnding."\n";
      
      // -> add keywords
      if($this->websiteConfig['keywords'])
        $metaTags .= '  <meta name="keywords" content="'.$this->websiteConfig['keywords'].'"'.$tagEnding."\n";
      
      $metaTags .= "\n";
      
      // -> add FEEDS
      $nonCategory[0] = array('id' => 0);
      $allCategories = $nonCategory + $this->categoryConfig;
      // -----------------------------------------------------------------------------------------------------------
      // ->> LIST CATEGORIES
      foreach($allCategories as $category) {
        
        if(($category['id'] != 0 && $category['public'] && $category['feeds']) ||
           ($category['id'] == 0 && $this->adminConfig['pages']['feeds'])) {
          
          $channelTitle = ($category['id'] == 0)
            ? $this->websiteConfig['title']
            : $category['name'].' - '.$this->websiteConfig['title'];
          
          $feedsLink = ($category['id'] == 0)
            ? $this->adminConfig['url'].$this->adminConfig['basePath'].'pages/'
            : $this->adminConfig['url'].$this->adminConfig['basePath'].'pages/'.$category['id'].'/';
          
          $metaTags .= '  <link rel="alternate" type="application/atom+xml" title="'.$channelTitle.' (Atom)" href="'.$feedsLink.'atom.xml"'.$tagEnding."\n";
          $metaTags .= '  <link rel="alternate" type="application/rss+xml" title="'.$channelTitle.' (RSS 2.0)" href="'.$feedsLink.'rss2.xml"'.$tagEnding."\n";
        }
      }
      
      $metaTags .= "\n";
      
      // -> add plugin-stylesheets
      $plugins = GeneralFunctions::readFolder($this->adminConfig['realBasePath'].'plugins/');
      if(is_array($plugins)) {
        foreach($plugins['folders'] as $pluginFolder) {
          $pluginName = basename($pluginFolder);
          if($this->pluginsConfig[$pluginName]['active'])
            $metaTags .= GeneralFunctions::createStyleTags($pluginFolder,false);
        }
      }
        
      // ->> ENABLE FRONTEND EDITING
      // if user is logged into the CMS, add javascripts for implementing ckeditor      
      if($this->loggedIn && $this->adminConfig['user']['frontendEditing'] && PHP_VERSION >= REQUIREDPHPVERSION) {
        
        $metaTags .= "\n  <!--- add feindura frontend editing -->\n";
        // add frontend editing stylesheets
        $metaTags .= '  <link rel="stylesheet" type="text/css" href="'.$this->adminConfig['basePath'].'library/styles/shared.css" />'."\n";
        $metaTags .= '  <link rel="stylesheet" type="text/css" href="'.$this->adminConfig['basePath'].'library/styles/frontendEditing.css" />'."\n";    
        $metaTags .= '  <link rel="stylesheet" type="text/css" href="'.$this->adminConfig['basePath'].'library/thirdparty/MooRTE/Source/Assets/moorte.css" />'."\n";
        $metaTags .= '  <link rel="stylesheet" type="text/css" href="'.$this->adminConfig['basePath'].'library/thirdparty/MooRTE/feinduraSkin/rteFeinduraSkin.css" />'."\n";
        
        // -> move body padding, if frontend edititng is not deactivated
        if(!$_SESSION['feindura']['session']['deactivateFrontendEditing'])
          $metaTags .= '<style type="text/css" id="feindura_bodyStyle">
   body {
     padding-top: 60px !important;
     background-position-y: 60px !important;
   }
 </style>';
        else
          $metaTags .= '<style type="text/css" id="feindura_bodyStyle">
   body {
     padding-top: 5px !important;
     background-position-y: 5px !important;
   }
 </style>';
        
        // add MOOTOOLS
        $metaTags .= "\n".'  <script type="text/javascript" src="'.$this->adminConfig['basePath'].'library/thirdparty/javascripts/mootools-core-1.3.2.js"></script>'."\n";
        $metaTags .= '  <script type="text/javascript" src="'.$this->adminConfig['basePath'].'library/thirdparty/javascripts/mootools-more-1.3.2.1.js"></script>'."\n";   
        
        // add MooRTE
        $metaTags .= '  <script type="text/javascript" src="'.$this->adminConfig['basePath'].'library/thirdparty/MooRTE/Source/moorte.js"></script>'."\n";
        //$metaTags .= '  <script type="text/javascript" src="'.$this->adminConfig['basePath'].'library/thirdparty/MooRTE/dependencies/stickywin/StickyWinModalUI.js"></script>'."\n";
        // add raphael
        $metaTags .= '  <script type="text/javascript" src="'.$this->adminConfig['basePath'].'library/thirdparty/javascripts/raphael-1.5.2.js"></script>'."\n";
        // add the javascripts which are shared by the backend and the frontend
        $metaTags .= '  <script type="text/javascript" src="'.$this->adminConfig['basePath'].'library/javascripts/shared.js"></script>'."\n";
        
        // ->> create templates of the TOP BAR and PAGE BAR
        $metaTags .= "  <script type=\"text/javascript\">
  /* <![CDATA[ */
  // transport feindura PHP vars to javascript
  var feindura_url =                       '".$this->adminConfig['url']."';
  var feindura_basePath =                  '".$this->adminConfig['basePath']."';
  var feindura_currentBackendLocation =    '".$_SESSION['feindura']['session']['currentBackendLocation']."';
  var feindura_deactivateFrontendEditing = '".$_SESSION['feindura']['session']['deactivateFrontendEditing']."';
  var feindura_langFile = {
    ERRORWINDOW_TITLE:      \"".$this->languageFile['errorWindow_h1']."\",
    ERROR_SAVE:             \"".$this->languageFile['editor_savepage_error_save']."\",
    ERROR_SETSTARTPAGE:     \"".$this->languageFile['sortablePageList_setStartPage_error_save']."\",
    FUNCTIONS_STARTPAGE_SET:\"".$this->languageFile['sortablePageList_functions_startPage_set']."\",
    FUNCTIONS_STARTPAGE:    \"".$this->languageFile['sortablePageList_functions_startPage']."\",
    FUNCTIONS_EDITPAGE:     \"".$this->languageFile['PAGEFUNCTIONS_TIP_EDITINBACKEND']."\",
    BUTTON_LOGOUT:          \"".$this->languageFile['HEADER_BUTTON_LOGOUT']."\",
    BUTTON_GOTOBACKEND:     \"".$this->languageFile['HEADER_TIP_GOTOBACKEND']."\"
  };
  var feindura_logoutUrl =    '".GeneralFunctions::getCurrentUrl('feindura_logout')."';
  var feindura_setStartPage = '".$this->adminConfig['setStartPage']."';
  var feindura_startPage =    '".$this->startPage."';
  /* ]]> */
  </script>\n";

        // add frontend editing integration
        $metaTags .= '  <script type="text/javascript" src="'.$this->adminConfig['basePath'].'library/javascripts/frontendEditing.js"></script>'."\n";
      }
      
      // -> show the metaTags
      return $metaTags;
  }
 /**
  * Alias of {@link createMetaTags()}
  * @ignore
  */
  public function createMetaTag($charset = 'UTF-8', $author = false, $publisher = true, $copyright = true, $robotTxt = false, $revisitAfter = '10') {
    // call the right function
    return $this->createMetaTags($charset, $author, $publisher, $copyright, $robotTxt, $revisitAfter);
  }
  
 /**
  * <b>Name</b> createHref()<br />
  * 
  * Generates a href attribute which links to a page.
  * Depending whether speaking URLs is in the administrator-settings activated, it generates a different href attribute.<br />
  * If cookies are deactivated it attaches the {@link $sessionId} on the end.
  * 
  * <b>Notice</b>: if the <var>$page</var> parameter is FALSE it uses the {@link $page} property.
  * 
  * Examples of the returned href string:<br />
  * <i>("user=xyz123" stands for: sessionname=sessionid)</i>
  * 
  * Pages without category: 
  * <samp>'?page=1&user=xyz123'</samp>
  * Pages with category:
  * <samp>'?category=1&page=1&user=xyz123'</samp>
  * 
  * Speaking URL href for pages without category: 
  * <samp>'/page/page_title.html?user=xyz123'</samp>
  * Speaking URL href for pages with category:
  * <samp>'/category/category_name/page_title.html?user=xyz123'</samp>
  * 
  * 
  * @param int $page a page ID
  * 
  * @uses FeinduraBase::loadPrevNextPage()	  to load the current, previous or next page depending of the $page parameter 
  * @uses GeneralFunctions::createHref()      call the right createHref functions in the GeneralFunctions class
  * @uses GeneralFunctions::getPageCategory() to get the category of the page    
  * 
  * 
  * @return string|false the generated href attribute, or FALSE if no page could be loaded
  * 
  * @see GeneralFunctions::createHref()
  * 
  * @access public
  * @version 1.0
  * <br />
  * <b>ChangeLog</b><br />
  *    - 1.0 initial release
  * 
  */
  public function createHref($page = false) {
    
    if($page = $this->loadPrevNextPage($page)) {
 
      // loads the $pageContent array
      if(($pageContent = GeneralFunctions::readPage($page,GeneralFunctions::getPageCategory($page))) !== false) {
          return GeneralFunctions::createHref($pageContent,$this->sessionId);
      }
        
    } else return false;    
  }
  
 /**
  * <b>Name</b> createLink()<br />
  * 
  * <b>This method uses the {@link $linkLength $link...} and {@link $thumbnailAlign $thumbnail...} properties.</b>
  * 
  * Creates a link from a page ID.
  * 
  * 
  * If the given <var>$page</var> parameter is a string with "previous" or "next",
  * it creates a link from the previous or the next page starting from the current page ID stored in the {@link $page} property.
  * If there is no current, next or previous page in it returns FALSE.
  * 
  * <b>Notice</b>: if the <var>$page</var> parameter is FALSE it uses the {@link $page} property AND set the class name <i>"active"</i> to the link.
  * 
  * Example:
  * {@example createLink.example.php}
  * 
  * @param int|string|array|false $page      (optional) the page ID or a string with "previous" or "next" or FALSE to use the {@link $page} property (can also be a $pageContent array)
  * @param string|bool            $linkText  (optional) a string with a linktext which the link will use, if TRUE it uses the page title of the page, if FALSE no linktext will be used
  * 
  * @uses Feindura::$linkLength
  * @uses Feindura::$linkId
  * @uses Feindura::$linkClass
  * @uses Feindura::$linkAttributes
  * @uses Feindura::$linkBefore
  * @uses Feindura::$linkAfter
  * @uses Feindura::$linkBeforeText
  * @uses Feindura::$linkAfterText
  * @uses Feindura::$linkShowThumbnail
  * @uses Feindura::$linkShowThumbnailAfterText
  * @uses Feindura::$linkShowPageDate
  * @uses Feindura::$linkShowCategory
  * @uses Feindura::$linkCategorySeparator
  * 
  * @uses Feindura::$thumbnailAlign
  * @uses Feindura::$thumbnailId
  * @uses Feindura::$thumbnailClass
  * @uses Feindura::$thumbnailAttributes
  * @uses Feindura::$thumbnailBefore
  * @uses Feindura::$thumbnailAfter
  * 
  * @uses Feindura::createHref()                        to create the href-attribute
  * @uses FeinduraBase::loadPrevNextPage()              to load the current, previous or next page depending of the $page parameter
  * @uses FeinduraBase::createAttributes()              to create the attributes used by the link <a> tag
  * @uses FeinduraBase::createThumbnail()               to create the thumbnail for the link if the {@link $linkShowThumbnail} property is TRUE
  * @uses FeinduraBase::shortenText()                   to shorten the linktext if the {@link $linkLength} property is set
  * @uses GeneralFunctions::getPageCategory()           to get the category of the page
  * @uses GeneralFunctions::isPublicCategory()          to check whether the category is public
  * 
  * @return string|false the created link, ready to display in a HTML-page, or FALSE if the page doesn't exist or is not public
  * 
  * @see createMenu()
  * @see createMenuByTags()
  * @see createMenuByDate()
  * 
  * @access public
  * @version 1.0
  * <br />
  * <b>ChangeLog</b><br />
  *    - 1.0 initial release
  * 
  */
  public function createLink($page = false, $linkText = true) {    
        
    //echo 'PAGE: '.$page;
    
    // LOADS the right $pageContent array
    if($page = $this->loadPrevNextPage($page)) {
      
      // loads the $pageContent array
      if(($pageContent = GeneralFunctions::readPage($page,GeneralFunctions::getPageCategory($page))) !== false) {
      
        // -> CHECK status
        if($pageContent['public'] &&  GeneralFunctions::isPublicCategory($pageContent['category']) !== false) {
          
          // -> LINK TITLE
          // *****************
          // -> create the text
          if($linkText === true) {
            // add the TITLE
            $linkText = $this->createTitle($pageContent,	                       
                                         $this->linkLength,
                                         false, // $titleAsLink
                                         $this->linkShowPageDate,
                                         $this->linkShowCategory,                                       
                                         $this->linkCategorySeparator);
          } elseif(is_string($linkText) &&
                   is_numeric($this->linkLength))   
            $linkText = shortenText($linkText, $this->linkLength);
  	
          // -> sets the LINK
          // ----------------------------  
         
          // add HREF
          $linkAttributes = 'href="'.$this->createHref($pageContent).'" title="'.str_replace('"','&quot;',strip_tags($linkText)).'"';
  	      
          $linkClass = ($this->page == $pageContent['id'])
          ? $this->linkClass.' active'
          : $this->linkClass;
  	      
  	      $linkClass = trim($linkClass);
  	      
  	      $linkAttributes .= $this->createAttributes($this->linkId, $linkClass, $this->linkAttributes);
          
          $linkStartTag = '<a '.$linkAttributes.">\n";
          $linkEndTag = "\n</a>";        
          
          // -> LINK THUMBNAIL
          // *****************
  	      $returnThumbnail = false;
          if($this->linkShowThumbnail && $linkShowThumbnail = $this->createThumbnail($pageContent))
            $returnThumbnail = $linkShowThumbnail['thumbnail']."\n";
          
          // CHECK if the LINKTEXT BEFORE & AFTER is !== true
          $linkBeforeText = false;
          $linkAfterText = false;
          
          if($linkText !== false) {
            if($this->linkBeforeText !== true)
              $linkBeforeText = $this->linkBeforeText;
            if($this->linkAfterText !== true)
              $linkAfterText = $this->linkAfterText;
          }
          
          // CHECK if the LINK BEFORE & AFTER is !== true
          $linkBefore = false;
          $linkAfter = false;
          
          if($this->linkBefore !== true)
            $linkBefore = $this->linkBefore;
          if($this->linkAfter !== true)
            $linkAfter = $this->linkAfter;
          
          
          // CHECK IF THUMBNAIL AFTER TEXT
          if($this->linkShowThumbnailAfterText === true)
            $linkString = $linkBeforeText.$linkText.$linkAfterText."\n".$returnThumbnail;
          else
            $linkString = $returnThumbnail.$linkBeforeText.$linkText.$linkAfterText;            
  
          // -> create the LINK
          // ----------------------------
          $link = $linkBefore.$linkStartTag.$linkString.$linkEndTag.$linkAfter;
            
          // returns the whole link after finish
          return $link;
        } else return false;
      } else return false;
    } else return false;
  }
  
 /**
  * <b>Name</b> createMenu()<br />
  * 
  * <b>This method uses the {@link $linkLength $link...}, {@link $menuId $menu...} and {@link $thumbnailAlign $thumbnail...} properties.</b>
  * 
  * Creates a menu from category or page ID(s).
  * 
  * 
  * The <var>$menuTag</var> parameter can be an "ul", "ol" or "table", it will then create the necessary child HTML-tags of this element.
  * If its any other tag name it just enclose the links with this HTML-tag.
  * 
  * In case no page with the given category or page ID(s) exist it returns an empty array.
  * 
  * <b>Notice</b>: if the <var>$ids</var> parameter is FALSE it uses the {@link $page} or {@link $category} property depending on the <var>$idType</var> parameter.<br />
  * <b>Notice</b>: the link which fits the current ID in the {@link $page} property will get the class name <i>"active"</i>.
  * 
  * Example:
  * {@example createMenu.example.php}
  * 
  * @param string         $idType             (optional) the ID(s) type can be "cat", "category", "categories" or "pag", "page" or "pages"
  * @param int|array|bool $ids                (optional) the category or page ID(s), can be a number or an array with numbers (can also be a $pageContent array), if TRUE it loads all pages, if FALSE it uses the {@link $page} or {@link $category} property
  * @param int|bool       $menuTag            (optional) the tag which is used to create the menu, can be an "menu", "ul", "ol", "table" or any other tag, if TRUE it uses "div" as a standard tag
  * @param string|bool    $linkText           (optional) a string with a linktext which all links will use, if TRUE it uses the page titles of the pages, if FALSE no linktext will be used
  * @param int|false      $breakAfter         (optional) if the $menuTag parameter is "table", this parameter defines after how many "td" tags a "tr" tag will follow, with any other tag this parameter has no effect
  * @param bool           $sortByCategories   (optional) if TRUE it sorts the given category or page ID(s) by category
  * 
  * @uses Feindura::$menuId
  * @uses Feindura::$menuClass
  * @uses Feindura::$menuAttributes
  * 
  * @uses Feindura::$linkLength
  * @uses Feindura::$linkId
  * @uses Feindura::$linkClass
  * @uses Feindura::$linkAttributes
  * @uses Feindura::$linkBefore
  * @uses Feindura::$linkAfter
  * @uses Feindura::$linkBeforeText
  * @uses Feindura::$linkAfterText
  * @uses Feindura::$linkShowThumbnail
  * @uses Feindura::$linkShowThumbnailAfterText
  * @uses Feindura::$linkShowPageDate
  * @uses Feindura::$linkShowCategory
  * @uses Feindura::$linkCategorySeparator
  * 
  * @uses Feindura::$thumbnailAlign
  * @uses Feindura::$thumbnailId
  * @uses Feindura::$thumbnailClass
  * @uses Feindura::$thumbnailAttributes
  * @uses Feindura::$thumbnailBefore
  * @uses Feindura::$thumbnailAfter
  * 
  * @uses createLink()                        to create a link from every $pageContent array  
  * @uses FeinduraBase::getPropertyIdsByType()    if the $ids parameter is FALSE it gets the property category or page ID, depending on the $idType parameter
  * @uses FeinduraBase::loadPagesByType()         to load the page $pageContent array(s) from the given ID(s)
  * @uses FeinduraBase::createAttributes()        to create the attributes used in the menu tag
  * @uses GeneralFunctions::sortPages()       to sort the $pageContent arrays by category
  * 
  * @return array the created menu in an array, ready to display in a HTML-page, or an empty array
  * 
  * @see createLink()
  * @see createMenuByTags()
  * @see createMenuByDate()
  * 
  * @access public
  * @version 1.0
  * <br />
  * <b>ChangeLog</b><br />
  *    - 1.0 initial release
  * 
  */
  public function createMenu($idType = 'category', $ids = false, $menuTag = false, $linkText = true, $breakAfter = false, $sortByCategories = false) {
    
    // vars
    $menu = array();
    
    $ids = $this->getPropertyIdsByType($idType,$ids);
    
    // -> LOADS the PAGES BY TYPE
    $pages = $this->loadPagesByType($idType,$ids); 
    
    // -> if pages should be SORTED BY CATEGORY
    if($sortByCategories === true)
      $pages = GeneralFunctions::sortPages($pages); 
    
    // -> STOREs the LINKs in an Array
    $links = array();
    if($pages !== false) {
      // create a link out of every page in the array
      foreach($pages as $page) {
        // creates the link
        if($pageLink = $this->createLink($page,$linkText)) {
          // adds the link to an array
          $links[] = $pageLink;
        }
      }      
    } else 
      return array(false);
 
    
    // -> sets the MENU attributes
    // ----------------------------    
    $menuStartTag = '';
    $menuEndTag = '';        
    $menuTagSet = false;
    
    // -> CREATEs the MENU-TAG (START and END-TAG)
    if($menuTag) { // || !empty($menuAttributes) <- not used because there is no menuTag property, the tag is only set when a $menuTag parameter is given
      
      $menuAttributes = $this->createAttributes($this->menuId, $this->menuClass, $this->menuAttributes);
      
      // set tag
      if(is_string($menuTag)) $menuTagSet = strtolower($menuTag);
      // or uses standard tag
      else $menuTagSet = 'div';
                
      $menuStartTag = '<'.$menuTagSet.$menuAttributes.'>'."\n";
      $menuEndTag = '</'.$menuTagSet.'>'."\n";
    } 
    
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
    
      /*
      // adds the break after BR
      if($breakAfter === true) {
        if($this->xHtml === true)
          $link .= "<br />\n";
        else
          $link .= "<br>\n";
      */
          
      // breaks the CELLs with TR after the given NUMBER of CELLS
      if($menuTagSet == 'table' &&
         is_numeric($breakAfter) &&
         ($breakAfter + 1) == $count) {
        //echo "</tr><tr>\n";
        $menu[] = "\n</tr><tr>\n";
        $count = 1;
      }
      
      /*
      // clears the $menuBetween String if its the last tag
      if($count == count($links))
        $menuBetween = false;
      */
      
      // if menuTag is a LIST ------
      if($menuTagSet == 'menu' || $menuTagSet == 'ul' || $menuTagSet == 'ol') {
        $link = '<li>'.$link."</li>\n"; //.$menuBetween;
        
      // if menuTag is a TABLE -----
      } elseif($menuTagSet == 'table') {
        $link = "<td>\n".$link."\n</td>"; //.$menuBetween;
       
      }
      /* 
      // if menuBetween -----
      } elseif(isset($menuBetween)) {
        $link = $link."\n".$menuBetween;
      }
      */
      
      // SHOW the link
      //echo $link;
      $menu[] = $link;
      
      // count the table cells
      $count++;
    }
    
    // fills in the missing TABLE CELLs
    while($menuTagSet == 'table' &&
          is_numeric($breakAfter) &&
          $breakAfter >= $count) {
      //echo "<td></td>\n";
      $menu[] = "<td></td>\n";
      $count++;
    }
    
    // creating the END TR tag
    if($menuTagSet == 'table')
      $menuEndTag = "</tr>\n".$menuEndTag;
    
    // SHOW END-TAG
    if($menuEndTag) {
      //echo $menuEndTag.$menuAfter;
      $menu[] = $menuEndTag; //$menuEndTag.$menuAfter;
    }
    
    // adds breaks before and after
    //$menu = "\n".$menu."\n";
    // removes double breaks
    //$menu = preg_replace("/[\r\n]+/","\n",$menu);
    
    // returns the whole menu after finish
    return $menu;
  }
  
 /**
  * <b>Name</b>     createMenuByTags()<br />
  * <b>Alias</b>    createMenuByTag()<br />
  * 
  * <b>This method uses the {@link $linkLength $link...}, {@link $menuId $menu...} and {@link $thumbnailAlign $thumbnail...} properties.</b>
  * 
  * Create a menu from category or page ID(s) with pages which have one or more of the tags from the given <var>$tags</var> parameter.
  * 
  * 
  * <b>Notice</b>: the tags will be compared case insensitive.
  * 
  * The <var>$menuTag</var> parameter can be an "ul", "ol" or "table", it will then create the necessary HTML-tags of this element.
  * If its any other tag name it just enclose the links with this HTML-tag.
  * 
  * In case no page with the given category or page ID(s) or tags exist it returns an empty array.
  * 
  * <b>Notice</b>: if the <var>$ids</var> parameter is FALSE it uses the {@link $page} or {@link $category} property depending on the <var>$idType</var> parameter.
  * <b>Notice</b>: the link which fits the current ID in the {@link $page} property will get the class name <i>"active"</i>.
  * 
  * Example:
  * {@example createMenuByTags.example.php}
  * 
  * @param string|array   $tags               a string with tags seperated by "," or whitespaces, or an array with tags
  * @param string         $idType             (optional) the ID(s) type can be "cat", "category", "categories" or "pag", "page" or "pages"
  * @param int|array|bool $ids                (optional) the category or page ID(s), can be a number or an array with numbers (can also be a $pageContent array), if TRUE it loads all pages, if FALSE it uses the {@link $page} or {@link $category} property
  * @param int|bool       $menuTag            (optional) the tag which is used to create the menu, can be an "ul", "ol", "table" or any other tag, if TRUE it uses "div" as a standard tag
  * @param string|bool    $linkText           (optional) a string with a linktext which all links will use, if TRUE it uses the page titles of the pages, if FALSE no linktext will be used
  * @param int|false      $breakAfter         (optional) if the $menuTag parameter is "table", this parameter defines after how many "td" tags a "tr" tag will follow, with any other tag this parameter has no effect
  * @param bool           $sortByCategories   (optional) if TRUE it sorts the given category or page ID(s) by category
  * 
  * @uses Feindura::$menuId
  * @uses Feindura::$menuClass
  * @uses Feindura::$menuAttributes
  * 
  * @uses Feindura::$linkLength
  * @uses Feindura::$linkId
  * @uses Feindura::$linkClass
  * @uses Feindura::$linkAttributes
  * @uses Feindura::$linkBefore
  * @uses Feindura::$linkAfter
  * @uses Feindura::$linkBeforeText
  * @uses Feindura::$linkAfterText
  * @uses Feindura::$linkShowThumbnail
  * @uses Feindura::$linkShowThumbnailAfterText
  * @uses Feindura::$linkShowPageDate
  * @uses Feindura::$linkShowCategory
  * @uses Feindura::$linkCategorySeparator
  * 
  * @uses Feindura::$thumbnailAlign
  * @uses Feindura::$thumbnailId
  * @uses Feindura::$thumbnailClass
  * @uses Feindura::$thumbnailAttributes
  * @uses Feindura::$thumbnailBefore
  * @uses Feindura::$thumbnailAfter
  * 
  * @uses FeinduraBase::getPropertyIdsByType()  if the $ids parameter is FALSE it gets the property category or page ID, depending on the $idType parameter
  * @uses FeinduraBase::hasTags()               to get only the pages which have one or more tags from the given $tags parameter
  * @uses createMenu()                      to create the menu from the pages load by {@link FeinduraBase::hasTags()}
  * 
  * 
  * @return array the created menu in an array, ready to display in a HTML-page, or an empty array
  * 
  * @see createLink()  
  * @see createMenu()
  * @see createMenuByDate()
  * 
  * @access public
  * @version 1.0
  * <br />
  * <b>ChangeLog</b><br />
  *    - 1.0 initial release
  * 
  */
  public function createMenuByTags($tags, $idType = 'category', $ids = false, $menuTag = false, $linkText = true, $breakAfter = false, $sortByCategories = false) {
                                   
    $ids = $this->getPropertyIdsByType($idType,$ids);
    
    // check for the tags and CREATE A MENU
    if($ids = $this->hasTags($idType,$ids,$tags)) {
      return $this->createMenu($idType,$ids,$menuTag,$linkText,$breakAfter,$sortByCategories); 
    } else
      return array();
  }
 /**
  * Alias of {@link createMenuByTags()}
  * @ignore
  */
  public function createMenuByTag($tags, $idType = 'category', $ids = false, $menuTag = false, $linkText = true, $breakAfter = false, $sortByCategories = false) {
    // call the right function
    return $this->createMenuByTags($tags,$idType,$ids,$menuTag,$linkText,$breakAfter,$sortByCategories);
  }
  
 /**
  * <b>Name</b>     createMenuByDate()<br />
  * <b>Alias</b>    createMenuByDates()<br />
  * 
  * <b>This method uses the {@link $linkLength $link...}, {@link $menuId $menu...} and {@link $thumbnailAlign $thumbnail...} properties.</b>
  * 
  * Creates a menu from category or page ID(s) sorted by the page date,
  * with pages which have a page date and the page date fit in the time period
  * from the <var>$monthsInThePast</var> and the <var>$monthsInTheFuture</var> parameter starting from the date today.
  * 
  * The <var>$monthsInThePast</var> and <var>$monthsInTheFuture</var> parameters can also be a string with a (relative or specific) date, for more information see: {@link http://www.php.net/manual/de/datetime.formats.php}.
  * 
  * The <var>$menuTag</var> parameter can be an "ul", "ol" or "table", it will then create the necessary HTML-tags of this element.
  * If its any other tag name it just enclose the links with this HTML-tag.
  * 
  * In case no page with the given category or page ID(s) or tags exist it returns an empty array.
  * 
  * <b>Notice</b>: if the <var>$ids</var> parameter is FALSE it uses the {@link $page} or {@link $category} property depending on the <var>$idType</var> parameter.
  * <b>Notice</b>: the link which fits the current ID in the {@link $page} property will get the class name <i>"active"</i>.
  * 
  * Example:
  * {@example createMenuByDate.example.php}
  * 
  * @param string         $idType             (optional) the ID(s) type can be "cat", "category", "categories" or "pag", "page" or "pages"
  * @param int|array|bool $ids                (optional) the category or page ID(s), can be a number or an array with numbers (can also be a $pageContent array), if TRUE it loads all pages, if FALSE it uses the {@link $page} or {@link $category} property
  * @param int|bool|string $monthsInThePast       (optional) number of months before today, if TRUE it show all pages in the past, if FALSE it loads only pages starting from today. it can also be a string with a (relative or specific) date format, for more details see: {@link http://www.php.net/manual/de/datetime.formats.php}
  * @param int|bool|string $monthsInTheFuture     (optional) number of months after today, if TRUE it show all pages in the future, if FALSE it loads only pages until today. it can also be a string with a (relative or specific) date format, for more details see: {@link http://www.php.net/manual/de/datetime.formats.php}
  * @param int|bool       $menuTag            (optional) the tag which is used to create the menu, can be an "ul", "ol", "table" or any other tag, if TRUE it uses "div" as a standard tag
  * @param string|bool    $linkText           (optional) a string with a linktext which all links will use, if TRUE it uses the page titles of the pages, if FALSE no linktext will be used
  * @param int|false      $breakAfter         (optional) if the $menuTag parameter is "table", this parameter defines after how many "td" tags a "tr" tag will follow, with any other tag this parameter has no effect
  * @param bool           $sortByCategories   (optional) if TRUE it sorts the given category or page ID(s) by category
  * @param bool           $reverseList        (optional) reverse the menu listing
  *  
  * @uses Feindura::$menuId
  * @uses Feindura::$menuClass
  * @uses Feindura::$menuAttributes
  * 
  * @uses Feindura::$linkLength
  * @uses Feindura::$linkId
  * @uses Feindura::$linkClass
  * @uses Feindura::$linkAttributes
  * @uses Feindura::$linkBefore
  * @uses Feindura::$linkAfter
  * @uses Feindura::$linkBeforeText
  * @uses Feindura::$linkAfterText
  * @uses Feindura::$linkShowThumbnail
  * @uses Feindura::$linkShowThumbnailAfterText
  * @uses Feindura::$linkShowPageDate
  * @uses Feindura::$linkShowCategory
  * @uses Feindura::$linkCategorySeparator
  * 
  * @uses Feindura::$thumbnailAlign
  * @uses Feindura::$thumbnailId
  * @uses Feindura::$thumbnailClass
  * @uses Feindura::$thumbnailAttributes
  * @uses Feindura::$thumbnailBefore
  * @uses Feindura::$thumbnailAfter
  * 
  * @uses FeinduraBase::loadPagesByDate()       to load the pages which fit in the given time period parameters, sorted by the page date
  * @uses createMenu()                      to create the menu from the pages load by {@link FeinduraBase::hasTags()}
  * 
  * @return array the created menu in an array, ready to display in a HTML-page, or an empty array
  * 
  * @see createLink()  
  * @see createMenu()
  * @see createMenuByTags()
  * 
  * @access public
  * @version 1.0
  * <br />
  * <b>ChangeLog</b><br />
  *    - 1.0 initial release
  * 
  */
  public function createMenuByDate($idType = 'category', $ids = false, $monthsInThePast = true, $monthsInTheFuture = true, $menuTag = false, $linkText = true, $breakAfter = false, $sortByCategories = false, $reverseList = false) {
      
      // gets the right pages and sorted by page date                      
      if($pageContents = $this->loadPagesByDate($idType,$ids,$monthsInThePast,$monthsInTheFuture,$sortByCategories,$reverseList))
	       return $this->createMenu($idType,$pageContents,$menuTag,$linkText,$breakAfter,false);
      else
        return array();
      
  }
 /**
  * Alias of {@link createMenuByDate()}
  * @ignore
  */
  public function createMenuByDates($idType = 'category', $ids = false, $monthsInThePast = true, $monthsInTheFuture = true, $menuTag = false, $linkText = true, $breakAfter = false, $sortByCategories = false, $reverseList = false) {
    // call the right function
    return $this->createMenuByDate($idType, $ids, $monthsInThePast, $monthsInTheFuture, $menuTag, $linkText, $breakAfter, $sortByCategories, $reverseList);
  }
  
 /**
  * <b>Name</b>     createMenuBySortFunction()<br />
  * <b>Alias</b>    createMenuBySort()<br />
  * <b>Alias</b>    createMenuBySortCallback()<br />
  * <b>Alias</b>    createMenuByCallback()<br />
  * 
  * <b>This method uses the {@link $linkLength $link...}, {@link $menuId $menu...} and {@link $thumbnailAlign $thumbnail...} properties.</b>
  * 
  * Creates a menu from category or page ID(s) sorted by a custom sort function, passed in the first parameter <var>$sortCallback</var>.
  * 
  * 
  * The <var>$menuTag</var> parameter can be an "ul", "ol" or "table", it will then create the necessary HTML-tags of this element.
  * If its any other tag name it just enclose the links with this HTML-tag.
  * 
  * In case no page with the given category or page ID(s) or tags exist it returns an empty array.
  * 
  * <b>Notice</b>: if the <var>$ids</var> parameter is FALSE it uses the {@link $page} or {@link $category} property depending on the <var>$idType</var> parameter.
  * <b>Notice</b>: the link which fits the current ID in the {@link $page} property will get the class name <i>"active"</i>.
  * 
  * Example:
  * {@example createMenuBySortFunction.example.php}
  * 
  * @param string         $sortCallback        the name of the callback function to sort the menu (the callback function is a function which can be passed to usort())
  * @param string         $idType             (optional) the ID(s) type can be "cat", "category", "categories" or "pag", "page" or "pages"
  * @param int|array|bool $ids                (optional) the category or page ID(s), can be a number or an array with numbers (can also be a $pageContent array), if TRUE it loads all pages, if FALSE it uses the {@link $page} or {@link $category} property
  * @param int|bool       $menuTag            (optional) the tag which is used to create the menu, can be an "menu", "ul", "ol", "table" or any other tag, if TRUE it uses "div" as a standard tag
  * @param string|bool    $linkText           (optional) a string with a linktext which all links will use, if TRUE it uses the page titles of the pages, if FALSE no linktext will be used
  * @param int|false      $breakAfter         (optional) if the $menuTag parameter is "table", this parameter defines after how many "td" tags a "tr" tag will follow, with any other tag this parameter has no effect
  * @param bool           $reverseList        (optional) reverse the menu listing
  *  
  * @uses Feindura::$menuId
  * @uses Feindura::$menuClass
  * @uses Feindura::$menuAttributes
  * 
  * @uses Feindura::$linkLength
  * @uses Feindura::$linkId
  * @uses Feindura::$linkClass
  * @uses Feindura::$linkAttributes
  * @uses Feindura::$linkBefore
  * @uses Feindura::$linkAfter
  * @uses Feindura::$linkBeforeText
  * @uses Feindura::$linkAfterText
  * @uses Feindura::$linkShowThumbnail
  * @uses Feindura::$linkShowThumbnailAfterText
  * @uses Feindura::$linkShowPageDate
  * @uses Feindura::$linkShowCategory
  * @uses Feindura::$linkCategorySeparator
  * 
  * @uses Feindura::$thumbnailAlign
  * @uses Feindura::$thumbnailId
  * @uses Feindura::$thumbnailClass
  * @uses Feindura::$thumbnailAttributes
  * @uses Feindura::$thumbnailBefore
  * @uses Feindura::$thumbnailAfter
  * 
  * @uses FeinduraBase::loadPagesByType()   to load the pages which fit in the given time period parameters, sorted by the page date
  * @uses createMenu()                      to create the menu from the pages load by {@link FeinduraBase::hasTags()}
  * 
  * @return array the created menu in an array, ready to display in a HTML-page, or an empty array
  * 
  * @see createLink()  
  * @see createMenu()
  * @see createMenuByDate()
  * @see createMenuByTags()
  * 
  * @access public
  * @version 1.0
  * <br />
  * <b>ChangeLog</b><br />
  *    - 1.0 initial release
  * 
  */
  public function createMenuBySortFunction($sortCallback, $idType = 'category', $ids = false, $menuTag = false, $linkText = true, $breakAfter = false, $reverseList = false) {
      
      // load the pages                   
      $pageContents = $this->loadPagesByType($idType,$ids);
      usort($pageContents,$sortCallback);
      // -> flips the sorted array if $reverseList === true
      if($reverseList === true)
        $pageContents = array_reverse($pageContents);
	    return $this->createMenu($idType,$pageContents,$menuTag,$linkText,$breakAfter,false);
  }
 /**
  * Alias of {@link createMenuBySortFunction()}
  * @ignore
  */
  public function createMenuBySort($sortCallback, $idType = 'category', $ids = false, $menuTag = false, $linkText = true, $breakAfter = false, $reverseList = false) {
      // call the right function             
	    return $this->createMenuBySortFunction($sortCallback,$idType,$ids,$menuTag,$linkText,$breakAfter,$reverseList);
  }
  /**
  * Alias of {@link createMenuBySortFunction()}
  * @ignore
  */
  public function createMenuBySortCallback($sortCallback, $idType = 'category', $ids = false, $menuTag = false, $linkText = true, $breakAfter = false, $reverseList = false) {
      // call the right function             
	    return $this->createMenuBySortFunction($sortCallback,$idType,$ids,$menuTag,$linkText,$breakAfter,$reverseList);
  }
  /**
  * Alias of {@link createMenuBySortFunction()}
  * @ignore
  */
  public function createMenuByCallback($sortCallback, $idType = 'category', $ids = false, $menuTag = false, $linkText = true, $breakAfter = false, $reverseList = false) {
      // call the right function             
	    return $this->createMenuBySortFunction($sortCallback,$idType,$ids,$menuTag,$linkText,$breakAfter,$reverseList);
  }
  
 /**
  * <b>Name</b>     getPageTitle()<br />
  * <b>Alias</b>    getTitle()<br />
  * 
  * <b>This method uses the {@link $titleLength $title...} properties.</b>
  * 
  * Returns the title of a page.
  * This page title will be generated using the title properties.
  * 
  * <b>Notice</b>: if the <var>$page</var> parameter is FALSE it uses the {@link $page} property.
  * 
  * Example:
  * {@example getPageTitle.example.php}
  * 
  * @param int|string|array|false $page      (optional) the page ID or a string with "previous" or "next" or FALSE to use the {@link $page} property (can also be a $pageContent array)
  * 
  * @uses Feindura::$titleLength
  * @uses Feindura::$titleAsLink
  * @uses Feindura::$titleShowPageDate
  * @uses Feindura::$titleShowCategory
  * @uses Feindura::$titleCategorySeparator
  * 
  * @uses FeinduraBase::loadPrevNextPage()             to load the current, previous or next page depending of the $page parameter
  * @uses FeinduraBase::createTitle()                  to generate the page title with the right title properties
  * 
  * @uses GeneralFunctions::getPageCategory()          to get the category of the page
  * @uses GeneralFunctions::isPublicCategory()         to check whether the category is public  
  * 
  * @return string the generated page title, ready to display in a HTML-page, or FALSE if the page doesn't exist or is not public
  * 
  * @see FeinduraBase::createTitle()  
  * 
  * @access public
  * @version 1.0
  * <br />
  * <b>ChangeLog</b><br />
  *    - 1.0 initial release
  * 
  */
  public function getPageTitle($page = false) {    
   
    if($page = $this->loadPrevNextPage($page)) {
      
      // gets the right category
      $category = GeneralFunctions::getPageCategory($page);
      
      // loads the $pageContent array
      if(($pageContent = GeneralFunctions::readPage($page,$category)) !== false) {
      
        // -> CHECK status
        if($pageContent['public'] &&  GeneralFunctions::isPublicCategory($pageContent['category']) !== false) {
        
          // shows the TITLE
          $title = $this->createTitle($pageContent,				                           
                                      $this->titleLength,
                                      $this->titleAsLink,                                    
                                      $this->titleShowPageDate,
                                      $this->titleShowCategory,
                                      $this->titleCategorySeparator);                                      
          
          if($this->loggedIn && PHP_VERSION >= REQUIREDPHPVERSION) // data-feindura format: "pageID categoryID"
            $title = '<span class="feindura_editTitle" data-feindura="'.$page.' '.$category.'">'.$title.'</span>';
          
          return $title;
          
        } else return false;
      } else return false; 
    } else return false;    
  }
 /**
  * Alias of {@link getPageTitle()}
  * @ignore
  */
  public function getTitle($page = false) {
    // call the right function
    return $this->getPageTitle($page);
  } 
  
  
 /**
  * <b>Name</b>  showPage()<br />
  * <b>Alias</b> showPages()<br />  
  * 
  * <b>This method uses the {@link $showErrors $error...}, {@link $titleLength $title...} and {@link $thumbnailAlign $thumbnail...} properties.</b>
  * 
  * Returns a page for displaying in a HTML-page.
  * This array will conatin all elements of the page, ready for displaying in a HTML-page.
  * 
  * In case the page doesn't exists or is not public and the {@link $showErrors} property is TRUE, 
  * an error will be placed in the ['content'] part of the returned array,
  * otherwiese it returns an empty array.<br />
  * 
  * <b>Notice</b>: if the <var>$page</var> parameter is FALSE it uses the {@link $page} property.
  * 
  * Example of the returned array:
  * {@example generatePage.return.example.php}
  * 
  * Example usage:
  * {@example showPage.example.php}
  * 
  * @param int|string|array|false $page         (optional) the page ID or a string with "previous" or "next" or FALSE to use the {@link $page} property (can also be a $pageContent array)
  * @param int|false              $shortenText  (optional) number of the maximal content text length shown, adds a "more" link at the end or FALSE to not shorten
  * @param bool                   $useHtml      (optional) whether the content of the page has HTML-tags or not
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
  * @uses FeinduraBase::loadPrevNextPage()                      to load the current, previous or next page depending of the $page parameter
  * @uses FeinduraBase::generatePage()                          to generate the array with the page elements
  * @uses StatisticFunctions::countAndSavePageStatistics()      to save the statistic of the page
  * 
  * @uses GeneralFunctions::getPageCategory()      to get the category of the page
  * 
  * @return array with the page elements, ready to display in a HTML-page, or FALSE if the page doesn't exist or is not public
  * 
  * @see getPageTitle()
  * @see FeinduraBase::generatePage()
  * 
  * @access public
  * @version 1.0
  * <br />
  * <b>ChangeLog</b><br />
  *    - 1.0 initial release
  * 
  */
  public function showPage($page = false, $shortenText = false, $useHtml = true) {    

    if($page = $this->loadPrevNextPage($page)) {
         
        // ->> load SINGLE PAGE
        // *******************
        if($generatedPage = $this->generatePage($page,$this->showErrors,$shortenText,$useHtml)) {
                         
          $category = GeneralFunctions::getPageCategory($page);   
          
          // -> loads the $pageContent array
          if(($pageContent = GeneralFunctions::readPage($page,$category)) !== false) {
            // -> SAVE PAGE STATISTIC
            // **********************
            if($pageContent['public'])
              StatisticFunctions::countAndSavePageStatistics($pageContent['id']);
          }
          
          // -> adds the frontend editing container
          if($this->loggedIn && PHP_VERSION >= REQUIREDPHPVERSION && !$generatedPage['error']) {
            
            // data-feindura format: "pageID categoryID"
            $generatedPage['title'] = '<span class="feindura_editTitle" data-feindura="'.$page.' '.$category.'">'.$generatedPage['title'].'</span>';
                        
            if(!preg_match('#<script.*>#',$generatedPage['content']))
              $generatedPage['content'] = "\n".'<div class="feindura_editPage" data-feindura="'.$page.' '.$category.'" style="display:inline-block;">'.$generatedPage['content'].'</div>'."\n";
            else
              $generatedPage['content'] = "\n".'<div class="feindura_editPageDisabled  feindura_toolTip" data-feindura="'.$page.' '.$category.'" title="'.$this->languageFile['EDITPAGE_TIP_DISABLED'].'">'.$generatedPage['content'].'</div>'."\n";
          }
          unset($generatedPage['error']);
          
          // -> returns the generated page
          return $generatedPage;
        }        
    } else return false;
  }
 /**
  * Alias of {@link showPage()}
  * @ignore
  */
  public function showPages($page = false, $shortenText = false, $useHtml = true) {
    // call the right function
    return $this->showPage($page, $shortenText, $useHtml);
  }
  
 /**
  * <b>Name</b>  showPlugins()<br />
  * <b>Alias</b> showPlugin()<br />  
  * 
  * Returns the plugin(s) of a page ready for displaying in a HTML page.
  * It can return an array where each element contain the HTML of a plugin (only the activated ones),
  * or if the <var>$plugins</var> parameter is a string with a plugin name (the foldername of the plugin, inside "../feindura_folder/plugins/"), it returns only a string with the HTML of this plugin.   
  * 
  * <b>Notice</b>: if the <var>$page</var> parameter is FALSE it uses the {@link $page} property.
  * 
  * Example of the returned array:
  * {@example showPlugins.return.example.php}
  * 
  * Example usage:
  * {@example showPlugins.example.php}
  * 
  * @param string|array|true      $plugins      (optional) the plugin name or an array with plugin names or TRUE to load all plugins
  * @param int|string|array|false $page         (optional) the page ID or a string with "previous" or "next" or FALSE to use the {@link $page} property (can also be a $pageContent array)
  * 
  * @uses Feindura::$page
  * 
  * @uses FeinduraBase::loadPrevNextPage()             to load the current, previous or next page depending of the $page parameter
  * @uses FeinduraBase::generatePage()                 to generate the array with the page elements
  * 
  * @uses GeneralFunctions::getPageCategory()          to get the category of the page    
  * 
  * @return array|string|false with the plugin(s) HTML-code, ready to display in a HTML-page, or an empty Array, or FALSE if the plugin(s) or page doesn't exist or the page is not public
  * 
  * @see getPageTitle()
  * @see FeinduraBase::generatePage()
  * 
  * @access public
  * @version 1.0
  * <br />
  * <b>ChangeLog</b><br />
  *    - 1.0 initial release
  * 
  */
  public function showPlugins($plugins = true, $page = false) {    
    
    // var
    $singlePlugin = (is_string($plugins) && $plugins != 'true' && $plugins != 'false') ? true : false;
    $pluginsReturn = (is_string($plugins) && $plugins != 'true' && $plugins != 'false') ? false : array();
    if(!is_array($plugins) && !is_bool($plugins))
      $plugins = array($plugins);
    
    if($page = $this->loadPrevNextPage($page)) {
                                
      // LOAD the $pageContent array
      if(($pageContent = GeneralFunctions::readPage($page,GeneralFunctions::getPageCategory($page))) !== false) {
        
        // ->> LOAD the PLUGINS and return them 
        if(($pageContent['category'] == 0 || $this->categoryConfig[$pageContent['category']]['public']) && $pageContent['public']) {
          if(is_array($pageContent['plugins'])) {
            // get the activated plugins
            $activatedPlugins = ($pageContent['category'] === 0)
              ? unserialize($this->adminConfig['pages']['plugins'])
              : unserialize($this->categoryConfig[$this->category]['plugins']);
          
            foreach($pageContent['plugins'] as $pluginName => $plugin) {

              // go through all plugins and load the required ones
              if((is_bool($plugins) || in_array($pluginName,$plugins)) && // is in the requested plugins array
                 $this->pluginsConfig[$pluginName]['active'] && // activated in the pluginsConfig
                 is_array($activatedPlugins) && in_array($pluginName,$activatedPlugins) && // activated in the adminConfig or categoryConfig
                 $plugin['active'] // activated in the page                 
                 ) {
               
                // create plugin config
                $pluginConfig = $plugin;
                unset($pluginConfig['active']); // remove the active value from the plugin config

                // -> include the plugin
          		  if($singlePlugin)
          		    return include(dirname(__FILE__).'/../../plugins/'.$pluginName.'/include.php');
          		  else  
                  $pluginsReturn[$pluginName] = include(dirname(__FILE__).'/../../plugins/'.$pluginName.'/include.php');
              }
            }
          }         
        }            
      }       
    }    
    return $pluginsReturn;
  }
  /**
  * Alias of {@link showPlugins()}
  * @ignore
  */
  public function showPlugin($plugins = true, $page = false) {
    // call the right function
    return $this->showPlugins($plugins, $page);
  }

 /**
  * <b>Name</b>     listPages()<br />
  * <b>Alias</b>    listPage()<br />
  * 
  * <b>This method uses the {@link $showErrors $error...}, {@link $titleLength $title...} and {@link $thumbnailAlign $thumbnail...} properties.</b>
  * 
  * List pages by given category or page ID(s).
  * 
  * 
  * Returns an array with multiple pages for displaying in a HTML-page.
  * 
  * In case no page with the given category or page ID(s) exist it returns an empty array.
  * <b>Notice</b>: if the <var>$ids</var> parameter is FALSE it uses the {@link $page} or {@link $category} property depending on the <var>$idType</var> parameter.
  * 
  * Example of the returned array:
  * {@example listPages.return.example.php}
  * 
  * Example usage:
  * {@example listPages.example.php}
  * 
  * @param string         $idType             (optional) the ID(s) type can be "cat", "category", "categories" or "pag", "page" or "pages"
  * @param int|array|bool $ids                (optional) the category or page ID(s), can be a number or an array with numbers (can also be a $pageContent array), if TRUE it loads all pages, if FALSE it uses the {@link $page} or {@link $category} property
  * @param int|false      $shortenText	      (optional) number of the maximal content text length shown of the pages, adds a "more" link at the end or FALSE to not shorten
  * @param bool           $useHtml            (optional) whether the content of the pages has HTML-tags or not
  * @param bool           $sortByCategories   (optional) if TRUE it sorts the given category or page ID(s) by category
  * 
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
  * @uses FeinduraBase::getPropertyIdsByType()    if the $ids parameter is FALSE it gets the property category or page ID, depending on the $idType parameter
  * @uses FeinduraBase::loadPagesByType()         to load the page $pageContent array(s) from the given ID(s)
  * @uses FeinduraBase::createAttributes()        to create the attributes used in the menu tag
  * @uses FeinduraBase::generatePage()            to generate every page which will be listed
  * @uses GeneralFunctions::sortPages()       to sort the $pageContent arrays by category
  * 
  * @return array the created menu in an array, ready to display in a HTML-page, or an empty array
  * 
  * @see showPage()
  * @see listPagesByTags()
  * @see listPagesByDate() 
  * 
  * @access public
  * @version 1.0
  * <br />
  * <b>ChangeLog</b><br />
  *    - 1.0 initial release
  * 
  */
  public function listPages($idType = 'category', $ids = false, $shortenText = false, $useHtml = true, $sortByCategories = false) {
    
    // vars
    $return = array();
    
    $ids = $this->getPropertyIdsByType($idType,$ids);
        
    // LOADS the PAGES BY TYPE
    $pages = $this->loadPagesByType($idType,$ids);

    // -> if pages SORTED BY CATEGORY
    if($sortByCategories === true)
      $pages = GeneralFunctions::sortPages($pages);
    
    if($pages !== false) {      
      
      // -> list a category(ies)
      // ------------------------------
      foreach($pages as $pageContent) {
        // show the pages
        if($page = $this->generatePage($pageContent,false,$shortenText,$useHtml)) {
          $return[] = $page;
        }
      }
    } else // IF there are NO PAGES
      return array();
      
    return $return;
  }
 /**
  * Alias of {@link listPages()}
  * @ignore
  */
  public function listPage($idType = 'category', $id = false, $shortenText = false, $useHtml = true, $sortByCategories = false) {
    // call the right function
    return $this->listPages($idType, $id, $shortenText, $useHtml, $sortByCategories);
  }

 /**
  * <b>Name</b>     listPagesByTags()<br />
  * <b>Alias</b>    listPagesByTag(), listPageByTags(), listPageByTag()<br />
  * 
  * <b>This method uses the {@link $showErrors $error...}, {@link $titleLength $title...} and {@link $thumbnailAlign $thumbnail...} properties.</b>
  * 
  * List pages by given category or page ID(s), which have one or more of the tags from the given <var>$tags</var> parameter.
  * 
  * 
  * <b>Notice</b>: the tags will be compared case insensitive.
  * 
  * Returns an array with multiple pages for displaying in a HTML-page. 
  * In case no page with the given category or page ID(s) exist it returns an empty array.
  * 
  * <b>Notice</b>: if the <var>$ids</var> parameter is FALSE it uses the {@link $page} or {@link $category} property depending on the <var>$idType</var> parameter.
  * 
  * Example usage:
  * {@example listPagesByTags.example.php}
  * 
  * @param string|array   $tags               a string with tags seperated by "," or whitespaces, or an array with tags    
  * @param string         $idType             (optional) the ID(s) type can be "cat", "category", "categories" or "pag", "page" or "pages"
  * @param int|array|bool $ids                (optional) the category or page ID(s), can be a number or an array with numbers (can also be a $pageContent array), if TRUE it loads all pages, if FALSE it uses the {@link $page} or {@link $category} property
  * @param int|false      $shortenText	      (optional) number of the maximal content text length shown of the pages, adds a "more" link at the end or FALSE to not shorten
  * @param bool           $useHtml            (optional) whether the content of the pages has HTML-tags or not
  * @param bool           $sortByCategories   (optional) if TRUE it sorts the given category or page ID(s) by category
  * 
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
  * @uses FeinduraBase::getPropertyIdsByType()    if the $ids parameter is FALSE it gets the property category or page ID, depending on the $idType parameter
  * @uses FeinduraBase::hasTags()                 to get only the pages which have one or more tags from the given $tags parameter
  * @uses listPages()                         to list the pages  
  * 
  * @return array the created menu in an array, ready to display in a HTML-page, or an empty array
  * 
  * @see showPage()
  * @see listPages()
  * @see listPagesByDate()
  * 
  * @access public
  * @version 1.0
  * <br />
  * <b>ChangeLog</b><br />
  *    - 1.0 initial release
  * 
  */
  public function listPagesByTags($tags, $idType = 'category', $ids = false, $shortenText = false, $useHtml = true, $sortByCategories = false) {
     
    $ids = $this->getPropertyIdsByType($idType,$ids);
    
    // check for the tags and LIST the PAGES
    if($ids = $this->hasTags($idType,$ids,$tags)) {      
      return $this->listPages($idType,$ids,$shortenText,$useHtml,$sortByCategories);
    } else
      return array();
  }  
 /**
  * Alias of {@link listPagesByTags()}
  * @ignore
  */
  public function listPagesByTag($tags, $idType = 'category', $ids = false, $shortenText = false, $useHtml = true, $sortByCategories = false) {
    // call the right function
    return $this->listPagesByTags($tags, $idType, $ids, $shortenText, $useHtml, $sortByCategories);
  }
 /**
  * Alias of {@link listPagesByTags()}
  * @ignore
  */
  public function listPageByTags($tags, $idType = 'category', $ids = false, $shortenText = false, $useHtml = true, $sortByCategories = false) {
    // call the right function
    return $this->listPagesByTags($tags, $idType, $ids, $shortenText, $useHtml, $sortByCategories);
  }
 /**
  * Alias of {@link listPagesByTags()}
  * @ignore
  */
  public function listPageByTag($tags, $idType = 'category', $ids = false, $shortenText = false, $useHtml = true, $sortByCategories = false) {
    // call the right function
    return $this->listPagesByTags($tags, $idType, $ids, $shortenText, $useHtml, $sortByCategories);
  }  
  
 /**
  * <b>Name</b>     listPagesByDate()<br />
  * <b>Alias</b>    listPagesByDates(), listPageByDate(), listPageByDates()<br />
  * 
  * <b>This method uses the {@link $showErrors $error...}, {@link $titleLength $title...} and {@link $thumbnailAlign $thumbnail...} properties.</b>
  * 
  * List pages by given category or page ID(s) sorted by the page date which have a page date and it fit in the time period
  * from the <var>$monthsInThePast</var> and the <var>$monthsInTheFuture</var> parameter starting from the date today.
  * 
  * The <var>$monthsInThePast</var> and <var>$monthsInTheFuture</var> parameters can also be a string with a (relative or specific) date, for more information see: {@link http://www.php.net/manual/de/datetime.formats.php}.
  * 
  * Returns an array with multiple pages for displaying in a HTML-page. 
  * In case no page with the given category or page ID(s) exist it returns an empty array.
  * 
  * <b>Notice</b>: if the <var>$ids</var> parameter is FALSE it uses the {@link $page} or {@link $category} property depending on the <var>$idType</var> parameter.
  * 
  * Example usage:
  * {@example listPagesByTags.example.php}
  * 
  * @param string         $idType             (optional) the ID(s) type can be "cat", "category", "categories" or "pag", "page" or "pages"
  * @param int|array|bool $ids                (optional) the category or page ID(s), can be a number or an array with numbers (can also be a $pageContent array), if TRUE it loads all pages, if FALSE it uses the {@link $page} or {@link $category} property
  * @param int|bool|string $monthsInThePast       (optional) number of months before today, if TRUE it show all pages in the past, if FALSE it loads only pages starting from today. it can also be a string with a (relative or specific) date format, for more details see: {@link http://www.php.net/manual/de/datetime.formats.php}
  * @param int|bool|string $monthsInTheFuture     (optional) number of months after today, if TRUE it show all pages in the future, if FALSE it loads only pages until today. it can also be a string with a (relative or specific) date format, for more details see: {@link http://www.php.net/manual/de/datetime.formats.php}
  * @param int|false      $shortenText	      (optional) number of the maximal content text length shown of the pages, adds a "more" link at the end or FALSE to not shorten
  * @param bool           $useHtml            (optional) whether the content of the pages has HTML-tags or not
  * @param bool           $sortByCategories   (optional) if TRUE it sorts the given category or page ID(s) by category
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
  * @uses FeinduraBase::loadPagesByDate()   to load the pages which fit in the given time period parameters, sorted by the page date
  * @uses listPages()                   to list the pages  
  * 
  * @return array the created menu in an array, ready to display in a HTML-page, or an empty array
  * 
  * @see showPage()
  * @see listPages()
  * @see listPagesByTags()
  * 
  * @access public
  * @version 1.0
  * <br />
  * <b>ChangeLog</b><br />
  *    - 1.0 initial release
  * 
  */
  public function listPagesByDate($idType = 'category', $ids = false, $monthsInThePast = true, $monthsInTheFuture = true, $shortenText = false, $useHtml = true, $sortByCategories = false, $reverseList = false) {
      
      // gets the right pages and sorted by page date                      
      $pageContents = $this->loadPagesByDate($idType,$ids,$monthsInThePast,$monthsInTheFuture,$sortByCategories,$reverseList);
      if($pageContents !== false)
        return $this->listPages($idType,$pageContents,$shortenText,$useHtml,false);
      else
        return array();
  }
 /**
  * Alias of {@link listPagesByDate()}
  * @ignore
  */
  public function listPageByDate($idType = 'category', $ids = false, $monthsInThePast = true, $monthsInTheFuture = true, $shortenText = false, $useHtml = true,$sortByCategories = false, $reverseList = false) {
    // call the right function
    return $this->listPagesByDate($idType, $ids, $monthsInThePast, $monthsInTheFuture, $shortenText, $useHtml,$sortByCategories, $reverseList);
  }
 /**
  * Alias of {@link listPagesByDate()}
  * @ignore
  */
  public function listPageByDates($idType = 'category', $ids = false, $monthsInThePast = true, $monthsInTheFuture = true, $shortenText = false, $useHtml = true,$sortByCategories = false, $reverseList = false) {
    // call the right function
    return $this->listPagesByDate($idType, $ids, $monthsInThePast, $monthsInTheFuture, $shortenText, $useHtml,$sortByCategories, $reverseList);
  }  
 /**
  * Alias of {@link listPagesByDate()}
  * @ignore
  */
  public function listPagesByDates($idType = 'category', $ids = false, $monthsInThePast = true, $monthsInTheFuture = true, $shortenText = false, $useHtml = true,$sortByCategories = false, $reverseList = false) {
    // call the right function
    return $this->listPagesByDate($idType, $ids, $monthsInThePast, $monthsInTheFuture, $shortenText, $useHtml,$sortByCategories, $reverseList);
  }
  
 /**
  * <b>Name</b>     listPagesBySortFunction()<br />
  * <b>Alias</b>    listPagesBySort()<br />
  * <b>Alias</b>    listPagesBySortCallback()<br />
  * <b>Alias</b>    listPagesByCallback()<br />
  * 
  * <b>This method uses the {@link $showErrors $error...}, {@link $titleLength $title...} and {@link $thumbnailAlign $thumbnail...} properties.</b>
  * 
  * List pages from category or page ID(s) sorted by a custom sort function, passed in the first parameter <var>$sortCallback</var>.
  * 
  * 
  * Returns an array with multiple pages for displaying in a HTML-page.
  * 
  * In case no page with the given category or page ID(s) exist it returns an empty array.
  * <b>Notice</b>: if the <var>$ids</var> parameter is FALSE it uses the {@link $page} or {@link $category} property depending on the <var>$idType</var> parameter.
  * 
  * Example of the returned array:
  * {@example listPages.return.example.php}
  * 
  * Example usage:
  * {@example listPagesBySortFunction.example.php}
  * 
  * @param string         $sortCallback        the name of the callback function to sort the pages (the callback function is a function which can be passed to usort())
  * @param string         $idType             (optional) the ID(s) type can be "cat", "category", "categories" or "pag", "page" or "pages"
  * @param int|array|bool $ids                (optional) the category or page ID(s), can be a number or an array with numbers (can also be a $pageContent array), if TRUE it loads all pages, if FALSE it uses the {@link $page} or {@link $category} property
  * @param int|false      $shortenText	      (optional) number of the maximal content text length shown of the pages, adds a "more" link at the end or FALSE to not shorten
  * @param bool           $useHtml            (optional) whether the content of the pages has HTML-tags or not
  * @param bool           $reverseList        (optional) reverse the menu listing  
  * 
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
  * @uses FeinduraBase::getPropertyIdsByType()    if the $ids parameter is FALSE it gets the property category or page ID, depending on the $idType parameter
  * @uses FeinduraBase::loadPagesByType()         to load the page $pageContent array(s) from the given ID(s)
  * @uses FeinduraBase::createAttributes()        to create the attributes used in the menu tag
  * @uses FeinduraBase::generatePage()            to generate every page which will be listed
  * @uses GeneralFunctions::sortPages()       to sort the $pageContent arrays by category
  * 
  * @return array the created menu in an array, ready to display in a HTML-page, or an empty array
  * 
  * @see showPage()
  * @see listPages()
  * @see listPagesByTags()
  * @see listPagesByDate()
  * 
  * @access public
  * @version 1.0
  * <br />
  * <b>ChangeLog</b><br />
  *    - 1.0 initial release
  * 
  */
  public function listPagesBySortFunction($sortCallback, $idType = 'category', $ids = false, $shortenText = false, $useHtml = true, $reverseList = false) {
      // load the pages                   
      $pageContents = $this->loadPagesByType($idType,$ids);
      usort($pageContents,$sortCallback);
      // -> flips the sorted array if $reverseList === true
      if($reverseList === true)
        $pageContents = array_reverse($pageContents);
	    return $this->listPages($idType,$pageContents,$shortenText,$useHtml,false);
  }
 /**
  * Alias of {@link listPagesBySortFunction()}
  * @ignore
  */
  public function listPagesBySort($sortCallback, $idType = 'category', $ids = false, $shortenText = false, $useHtml = true, $reverseList = false) {
      // call the right function             
	    return $this->listPagesBySortFunction($sortCallback,$idType,$ids,$shortenText,$useHtml,$reverseList);
  }
 /**
  * Alias of {@link listPagesBySortFunction()}
  * @ignore
  */
  public function listPagesBySortCallback($sortCallback, $idType = 'category', $ids = false, $shortenText = false, $useHtml = true, $reverseList = false) {
      // call the right function             
	    return $this->listPagesBySortFunction($sortCallback,$idType,$ids,$shortenText,$useHtml,$reverseList);
  }
 /**
  * Alias of {@link listPagesBySortFunction()}
  * @ignore
  */
  public function listPagesByCallback($sortCallback, $idType = 'category', $ids = false, $shortenText = false, $useHtml = true, $reverseList = false) {
      // call the right function             
	    return $this->listPagesBySortFunction($sortCallback,$idType,$ids,$shortenText,$useHtml,$reverseList);
  }
}
?>