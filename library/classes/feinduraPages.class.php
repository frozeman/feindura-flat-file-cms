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
* The class for implementing feindura - Flat File Content Management System in a website.
* 
* It's methods provide necessary functions for implementing the CMS in a website.<br>
* It contains, for example, methods for building a menu and get page contents, etc.
* 
* @author Fabian Vogelsteller <fabian@feindura.org>
* @copyright Fabian Vogelsteller
* @license http://www.gnu.org/licenses GNU General Public License version 3
*
* @version 1.0
* <br>
* <b>ChangeLog</b><br>
*    - 1.0 initial release
*
*/
class feinduraPages extends feindura {
  
 /* ---------------------------------------------------------------------------------------------------------------------------- */
 /* *** PROPERTIES */
 /* **************************************************************************************************************************** */
 
 /* ->> GENERAL <<- */
 
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
  * This property is used when a page loading method is called (for example: {@link getPage()}) and no page ID <var>parameter</var> is given.
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
  * This property is used when a page-loading method is called (for example: {@link getPage()}) and no category ID <var>parameter</var> is given.
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
  
  /* ->> LINK <<- */
  
 /**
  * A number of maximal characters visible of the link text,
  * in any link created by {@link createLink()} or {@link createMenu()}
  * 
  * The link text will be shorten to the last word.
  * 
  * Example shorting of "Example Shorting Text" with a given <var>$linkLength</var> of 14 will shorten to
  * <samp>
  * "Example..."
  * </samp>
  * 
  * @var int|false Number of characters or FALSE to don't shorten the link text
  * @see createLink()
  * @see createMenu()
  * @example createLink.example.php
  * 
  */
  var $linkLength = false;  

 /**
  * Contains an id-Attribute which will be add to any <a ...> tag,
  * in any link created by {@link createLink()} or {@link createMenu()}
  * 
  * <b>Notice</b>: You can only set one specific id-Attribute to elements in a HTML page,
  * if you set this property and call {@link createMenu()} every link will get this id-Attribute.
  * 
  * @var string|false If no id-Attribute should be add, set it to FALSE.
  * @see createLink()
  * @see createMenu()
  * @example createLink.example.php
  * 
  */
  var $linkId = false;
  
 /**
  * Contains an class-Attribute which will be add to any <a ...> tag,
  * in any link created by {@link createLink()} or {@link createMenu()}
  * 
  * <b>Notice</b>: If you set this property and call {@link createMenu()} every link will get this class-Attribute.
  * 
  * @var string|false If no class-Attribute should be add, set it to FALSE.
  * @see createLink()
  * @see createMenu()
  * @example createLink.example.php
  * 
  */
  var $linkClass = false;
  
 /**
  * Contains a string with attributes which will be add to any <a ...> tag,
  * in any link created by {@link createLink()} or {@link createMenu()}
  * 
  * <b>Notice</b>: If you set this property and call {@link createMenu()} every link will get this attributes string.
  * 
  * The string should have the following format
  * <samp>
  * 'key1="value" key2="value"'
  * </samp>
  * 
  * @var string|false If no additional attributes should be add, set it to FALSE.
  * @see createLink()
  * @see createMenu()
  * @example createLink.example.php
  * 
  */
  var $linkAttributes = false;

 /**
  * Contains a string which will be add before any <a></a> tag,
  * in any link created by {@link createLink()} or {@link createMenu()}
  * 
  * <b>Notice</b>: If you set this property and call {@link createMenu()} every link will get this text.
  * 
  * @var string|false If no text should be add before a link, set it to FALSE.
  * @see createLink()
  * @see createMenu()
  * @example createLink.example.php
  * 
  */
  var $linkBefore = false;
  
 /**
  * Contains a string which will be add after any <a></a> tag,
  * in any link created by {@link createLink()} or {@link createMenu()}
  * 
  * <b>Notice</b>: If you set this property and call {@link createMenu()} every link will get this text.
  * 
  * @var string|false If no text should be add after a link, set it to FALSE.
  * @see createLink()
  * @see createMenu()
  * @example createLink.example.php
  * 
  */
  var $linkAfter = false;
  
 /**
  * Contains a string which will be add before the link text but inside any <a></a> tag,
  * in any link created by {@link createLink()} or {@link createMenu()}
  * 
  * <b>Notice</b>: If you set this property and call {@link createMenu()} every link will get this text.  
  * 
  * @var string|false If no text should be add before a link text, set it to FALSE.
  * @see createLink()
  * @see createMenu()
  * @example createLink.example.php
  * 
  */
  var $linkTextBefore = false;
  
 /**
  * Contains a string which will be add after the link text but inside any <a></a> tag,
  * in any link created by {@link createLink()} or {@link createMenu()}
  * 
  * <b>Notice</b>: If you set this property and call {@link createMenu()} every link will get this text.  
  * 
  * @var string|false If no text should be add after a link text, set it to FALSE.
  * @see createLink()
  * @see createMenu()
  * @example createLink.example.php
  * 
  */
  var $linkTextAfter = false;
  
 /**
  * If TRUE and thumbnails are allowed for this page(s) it adds the thumbnail <img> tag inside the <a></a> tags,
  * in any link created by {@link createLink()} or {@link createMenu()}
  * 
  * 
  * @var bool Set it to TRUE to allow thumbnails in links
  * @see createLink()
  * @see createMenu()
  * @example createLink.example.php
  * 
  */
  var $linkShowThumbnail = false;
  
 /**
  * If TRUE and thumbnail <img> tag will be placed after the link text but inside the <a></a> tag,
  * in any link created by {@link createLink()} or {@link createMenu()}
  * 
  * 
  * @var bool Set it to TRUE to place the thumbnail <img> tag after the link text
  * @see createLink()
  * @see createMenu()
  * @example createLink.example.php
  * 
  */
  var $linkShowThumbnailAfterText = false;
  
 /**
  * If TRUE, the page date will be add before the link text in any link created by {@link createLink()} or {@link createMenu()}
  * 
  * If the {@link $linkShowCategory} property is TRUE, the page date is placed between the category name + seperator and the link text.<br>
  * The page date will be added with the page date text before and after from the page editor in the backend.
  *   
  * <b>Notice</b>: The page date will only be displayed if the <var>$linkText</var> parameter of {@link createLink()} or {@link createMenu()} methods is TRUE and not a string.
  * 
  * Example
  * <samp>
  * <a href="?page=2" ...>Catgory Name: 200-12-31 Page Title</a>
  * </samp>
  *    
  * @var bool Set it to TRUE to place the page date before the link text
  * @see createLink()
  * @see createMenu()
  * @example createLink.example.php
  * 
  */
  var $linkShowPageDate = false;

 /**
  * If TRUE, the category name of the page will be add before the link text
  * with the {@link $linkCategorySpacer} property as seperator, in any link created by {@link createLink()} or {@link createMenu()}
  * 
  * The category name will only be displayed if the <var>$linkText</var> parameter of {@link createLink()} or {@link createMenu()} methods is TRUE and not a string.
  * 
  * Example
  * <samp>
  * <a href="?page=2" ...>Catgory Name: Page Title</a>
  * </samp>
  *     
  * @var bool Set it to TRUE to place the category name before the link text
  * @see createLink()
  * @see createMenu()
  * @example createLink.example.php
  * 
  */
  var $linkShowCategory = false;
  
 /**
  * If the {@link $linkShowCategory} property is TRUE,
  * this string will be used as a seperator between the category name and the link text in any link created by {@link createLink()} or {@link createMenu()}
  * 
  * <b>Notice</b>: If you set this property and call {@link createMenu()} every link will use this seperator.  
  * 
  * @var string
  * @see createLink()
  * @see createMenu()
  * @example createLink.example.php
  * 
  */
  var $linkCategorySeperator = ': ';
  
  /* ->> MENU <<- */
  
 /**
  * Contains an id-Attribute which will be add to the menu tag
  * 
  * <b>Notice 1</b>: This id-Attribute will only be add, if the <var>$menuTag</var> parameter in the {@link createMenu()} method is not FALSE.<br>
  * <b>Notice 2</b>: You can only set one specific id-Attribute to elements in a HTML page.
  * 
  * @var string|false If no id-Attribute should be add, set it to FALSE.
  * @see createMenu()
  * @example createMenu.example.php
  * 
  */
  var $menuId = false;
  
 /**
  * Contains an class-Attribute which will be add to the menu tag
  * 
  * <b>Notice</b>: This class-Attribute will only be add, if the <var>$menuTag</var> parameter in the {@link createMenu()} method is not FALSE.<br>
  * 
  * @var string|false If no class-Attribute should be add, set it to FALSE.
  * @see createMenu()
  * @example createMenu.example.php
  * 
  */
  var $menuClass = false;
  
 /**
  * Contains a string with attributes which will be add to the menu tag
  * 
  * <b>Notice</b>: This string with attributes will only be add, if the <var>$menuTag</var> parameter in the {@link createMenu()} method is not FALSE.<br>
  * 
  * The string should have the following format
  * <samp>
  * 'key1="value" key2="value"'
  * </samp>
  *    
  * @var string|false If no additional attributes should be add, set it to FALSE.
  * @see createMenu()
  * @example createMenu.example.php
  * 
  */
  var $menuAttributes = false;
  
  /* old
  var $menuBefore = false;                // [False or String]      -> a String which comes BEFORE the menu <$menuTag> tag
  var $menuAfter = false;                 // [False or String]      -> a String which comes AFTER the menu </$menuTag> tag
  var $menuBetween = false;               // [False or String]      -> a String which comes AFTER EVERY <li></li> OR <td></td> tag EXCEPT THE LAST tag
  */
  
  /* ->> TITLE <<- */
  
 /**
  * A number of maximal characters visible of the page title text
  * 
  * The page title will be shorten to the last word.
  * 
  * Example shorting of "Example Shorting Text" with a given <var>$titleLength</var> of 18 will shorten to
  * <samp>
  * "Example Shorting..."
  * </samp>
  * 
  * @var int|false Number of characters or FALSE to don't shorten the page title
  * @see getTitle()
  * @see feindura::createTitle()
  * @example getPage.example.php
  * 
  */
  var $titleLength = false;
  
 /**
  * If TRUE the page title is also a link to the page
  * 
  * 
  * @var bool
  * @see getTitle()
  * @see feindura::createTitle()
  * @example getPage.example.php
  * 
  */
  var $titleAsLink = false;

 /**
  * If TRUE, the page date will be add before the page title
  * 
  * If the {@link $titleShowCategory} property is TRUE, the page date is placed between the category name + seperator and the page title.<br>
  * The page date will be added with the page date text before and after from the page editor in the backend.
  * 
  * Example
  * <samp>
  * Catgory Name: 200-12-31 Page Title
  * </samp>
  *    
  * @var bool Set it to TRUE to place the page date before the page title
  * @see getTitle()
  * @see feindura::createTitle()
  * @example getPage.example.php
  * 
  */
  var $titleShowPageDate = false;
  
 /**
  * If TRUE, the category name of the page will be add before the page title with the {@link $linkCategorySpacer} property as seperator
  * 
  * 
  * Example
  * <samp>
  * Catgory Name: Page Title
  * </samp>
  *     
  * @var bool Set it to TRUE to place the category name before the page title
  * @see getTitle()
  * @see feindura::createTitle()
  * @example getPage.example.php
  * 
  */
  var $titleShowCategory = false;
  
 /**
  * If the {@link $titleShowCategory} property is TRUE, this string will be used as a seperator between the category name and the page title
  * 
  * 
  * @var string
  * @see getTitle()
  * @see feindura::createTitle()
  * @example getPage.example.php
  * 
  */
  var $titleCategorySpacer = ': ';
  
  /* old
  var $titleTag = false;                  // [Boolean or String]    -> the title TAG which is used when creating a page title (STANDARD Tag: H1)
  var $titleId = false;                   // [False or String]      -> the title ID which is used when creating a page title (REMEMBER you can only set ONE ID in an HTML Page, so dont use this for listing Pages)
  var $titleClass = false;                // [False or String]      -> the title CLASS which is used when creating a page title
  var $titleAttributes = false;           // [False or String]      -> a String with Attributes like: 'key="value" key2="value2"'
  var $titleBefore = false;               // [False or String]      -> a String which comes BEFORE the link <$titleTag> tag
  var $titleAfter = false;                // [False or String]      -> a String which comes AFTER the link </$titleTag> tag
  */
  
  /* ->> CONTENT <<- */
  
  //var $pageShowTitle = true;
  //var $pageShowThumbnail = true;
  //var $pageShowContent = true;
  //var $pageShowError = true;
  
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
  
  /* ->> THUMBAIL <<- */

 /**
  * Contains the position of the thumbnail picture, the possible values are "left", "right" or FALSE
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
  * @see createLink()
  * @see createMenu()
  * @see getPage()
  * @see feindura:generatePage()
  * @example getPage.example.php
  * 
  */
  var $thumbnailAlign = false;
  
 /**
  * Contains an id-Attribute which will be add to the thumbnail <img> tag
  * 
  * <b>Notice</b>: You can only set one specific id-Attribute to elements in a HTML page.
  * 
  * @var string|false If no id-Attribute should be add, set it to FALSE.
  * @see createLink()
  * @see createMenu()
  * @see getPage()
  * @see feindura:generatePage()
  * @example getPage.example.php
  * 
  */
  var $thumbnailId = false;
  
 /**
  * Contains an class-Attribute which will be add the thumbnail <img> tag
  * 
  * 
  * @var string|false If no class-Attribute should be add, set it to FALSE.
  * @see createLink()
  * @see createMenu()
  * @see getPage()
  * @see feindura:generatePage()
  * @example getPage.example.php
  * 
  */
  var $thumbnailClass = false;

 /**
  * Contains a string with attributes which will be add the thumbnail <img> tag
  * 
  * 
  * The string should have the following format
  * <samp>
  * 'key1="value" key2="value"'
  * </samp>
  * 
  * @var string|false If no additional attributes should be add, set it to FALSE.
  * @see createLink()
  * @see createMenu()
  * @see getPage()
  * @see feindura:generatePage()
  * @example getPage.example.php
  * 
  */
  var $thumbnailAttributes = false;
  
 /**
  * Contains a string which will be add before the thumbnail <img> tag
  * 
  * 
  * @var string|false If no string should be add before the thumbnail <img> tag, set it to FALSE.
  * @see createLink()
  * @see createMenu()
  * @see getPage()
  * @see feindura:generatePage()
  * @example getPage.example.php
  * 
  */
  var $thumbnailBefore = false;
  
 /**
  * Contains a string which will be add after the thumbnail <img> tag
  * 
  * 
  * @var string|false If no string should be add after the thumbnail <img> tag, set it to FALSE.
  * @see createLink()
  * @see createMenu()
  * @see getPage()
  * @see feindura:generatePage()
  * @example getPage.example.php
  * 
  */
  var $thumbnailAfter = false;
  
  /* ->> ERROR <<- */
  
 /**
  * If TRUE an error will be displayed if the requested page doesn't exists or is currently not public
  * 
  * Example
  * <samp>
  * <span>The requested page is currently not available.</span>
  * </span>  
  * 
  * @var bool
  * @see getPage()
  * @see feindura:generatePage()
  * @example getPage.example.php
  * 
  */
  var $showError = true;
  
 /**
  * The tag which should be used for the error message
  * 
  * <b>Notice</b>: If this property is no string, the {@link $errorId}, {@link $errorClass} and {@link $errorAttributes} property will not be add<br>
  * 
  * Example
  * <samp>
  * <span>The requested page is currently not available.</span>
  * </samp>
  *    
  * @var string|false If no tag should be add, set it to FALSE.
  * @see getPage()
  * @see feindura:generatePage()
  * @example getPage.example.php
  * 
  */
  var $errorTag = 'span';                // [False or String]      -> the message TAG which is used when creating a message (STANDARD Tag: SPAN; if there is a class and/or id and no TAG is set)
 
 /**
  * Contains an id-Attribute which will be add to the error tag
  * 
  * <b>Notice 1</b>: This id-Attribute will only be add, if the {@link $errorTag} property is a string and not FALSE.<br>
  * <b>Notice 2</b>: You can only set one specific id-Attribute to elements in a HTML page.
  * 
  * Example
  * <samp>
  * <span id="exampleId">The requested page is currently not available.</span>
  * </samp>
  * 
  * @var string|false If no id-Attribute should be add, set it to FALSE.
  * @see getPage()
  * @see feindura:generatePage()
  * @example getPage.example.php
  * 
  */
  var $errorId = false;
  
 /**
  * Contains an class-Attribute which will be add to the error tag
  * 
  * <b>Notice</b>: This class-Attribute will only be add, if the {@link $errorTag} property is a string and not FALSE.<br>
  * 
  * Example
  * <samp>
  * <span class="exampleId">The requested page is currently not available.</span>
  * </samp>
  *     
  * @var string|false If no class-Attribute should be add, set it to FALSE.
  * @see getPage()
  * @see feindura:generatePage()
  * @example getPage.example.php
  * 
  */
  var $errorClass = false;
  
 /**
  * Contains a string with attributes which will be add the error tag
  * 
  * 
  * The string should have the following format
  * <samp>
  * 'key1="value" key2="value"'
  * </samp>
  * 
  * Example
  * <samp>
  * <span key1="value" key2="value">The requested page is currently not available.</span>
  * </samp>    
  * 
  * @var string|false If no additional attributes should be add, set it to FALSE.
  * @see getPage()
  * @see feindura:generatePage()
  * @example getPage.example.php
  * 
  */
  var $errorAttributes = false;

 /* ---------------------------------------------------------------------------------------------------------------------------- */
 /* *** METHODS *** */
 /* **************************************************************************************************************************** */
  
 /**
  * The constructor of the class, sets all basic properties
  *
  * Run the {@link feindura::feindura()} class constructor to set all necessary properties
  * Fetch the <var>$_GET</var> variable (if existing) and set it to the {@link $page} and {@link $category} properties.<br>
  * If there is no page and category ID it sets the start page ID from the website-settings config.
  *
  * <b>Type</b>     constructor<br>
  * <b>Name</b>     feinduraPages()<br>  
  *
  * @param string $language (optional) A country code like "de", "en", ... to load the right frontend language-file and is also set to the {@link feindura::$language} property 
  *
  * @uses feindura::feindura()		        the constructor of the parent class to load all necessary properties
  * @uses feindura::setCurrentCategory()  to set the fetched category ID from the $_GET variable to the {@link $category} property
  * @uses feindura::setCurrentPage()      to set the fetched page ID from the $_GET variable to the {@link $page} property
  * 
  * @return void
  *
  * 
  * @see feindura::feindura()
  *
  * @version 1.0
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.0 initial release
  *
  */
  function feinduraPages($language = false) {   // (String) string with the COUNTRY CODE ("de", "en", ..)
    
    // RUN the feindura constructor
    $this->feindura($language);        
    
    // saves the current GET vars in the PROPERTIES
    // ********************************************
    $this->setCurrentCategory(true);       // $_GET['category']  // first load category then the page, because getCurrentPage needs categories
    $this->setCurrentPage(true);           // $_GET['page'] <- set the $this->websiteConfig['startPage'] if there is no $_GET['page'] variable
  }
 
  
  // ****************************************************************************************************************
  // PUBLIC METHODs -------------------------------------------------------------------------------------------------
  // ****************************************************************************************************************
  
 /**
  * Creates a string all necessary meta tags
  *
  * Run the {@link feindura::feindura()} class constructor to set all necessary properties
  * Fetch the <var>$_GET</var> variable (if existing) and set it to the {@link $page} and {@link $category} properties.<br>
  * If there is no page and category ID it sets the start page ID from the website-settings config.
  *
  * Example
  * {@example createMetaTags.example.php}    
  *  
  * <b>Name</b>     createMetaTags()<br>
  * <b>Alias</b>    createMetaTag()<br>
  *
  * @param string       $charset      (optional) the charset used in the website like "UTF-8", "iso-8859-1", ...
  * @param string|false $author       (optional) the author of the website
  * @param string|bool  $publisher    (optional) the publisher of the website, if TRUE it uses the publisher from the website-settings config
  * @param string|bool  $copyright    (optional) the copyright owner of the website, if TRUE it uses the copyright from the website-settings config
  * @param string|bool  $robotTxt     (optional) if TRUE it sets the path of the "robot.txt" in the root dir of the website, if string it uses the string as "path/filename"
  * @param int|false    $revisitAfter (optional) a number of days to revisit the page as information for webcrawler, if FALSE this meta tag will nopt be created
  *
  * @uses feindura::$websiteConfig    for the website title, publisher, copyright, description and keywords
  * @uses generalFunctions->readPage	to read the page and set the page title
  * 
  * @return string with all meta tags ready to display in a HTML page
  * 
  * 
  * @version 1.0
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.0 initial release
  *
  */
  function createMetaTags($charset = 'UTF-8', $author = false, $publisher = true, $copyright = true, $robotTxt = false, $revisitAfter = '10') {
      
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
      if($this->getCurrentPage() && $currentPage = $this->generalFunctions->readPage($this->getCurrentPage(),$this->getCurrentCategory()))
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
      elseif($publisher === true && !empty($this->websiteConfig['publisher']))
        $metaTags .= '  <meta name="publisher" content="'.$this->websiteConfig['publisher'].'" />'."\n";
        
      // -> add copyright
      if($copyright && is_string($copyright))
        $metaTags .= '  <meta name="copyright" content="'.$copyright.'" />'."\n";
      elseif($copyright === true && !empty($this->websiteConfig['copyright']))
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
 /**
  * Alias of {@link createMetaTags()}
  * @ignore
  */
  function createMetaTag($charset = 'UTF-8', $author = false, $publisher = true, $copyright = true, $robotTxt = false, $revisitAfter = '10') {
    // call the right function
    return $this->createMetaTags($charset, $author, $publisher, $copyright, $robotTxt, $revisitAfter);
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
  * @uses generalFunctions::readPage()	   to load the $pageContent array if the $page parameter is an page ID
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
    if($this->generalFunctions->isPageContentArray($page))
	$pageContent = $page;
	
    // ELSE $page is page ID
    else {
	// gets page category
        $category = $this->getPageCategory($page);
	// load pageContent
	$pageContent = $this->generalFunctions->readPage($page,$category);
    }
    
    return $this->generalFunctions->createHref($pageContent,$this->sessionId);
    
  }
  
  /* -> START -- createLink ******************************************************************************
  // RETURNs a link created with the page ID
  // RETURNs -> STRING
  // * MORE OPTIONs in the PROPERTIES
  
  * @uses createThumbnail()		to check to show thumbnails are allowed and create the thumbnail <img> tag
  
  */
  function createLink($page = false,                 // (Number or String ("prev" or "next") or pageContent Array) the page ID to show, if false it use VAR PRIORITY
                             $linkText = true) {            // (Boolean or String) the TEXT used for the link, if TRUE it USES the TITLE of the page
    
        
    //echo 'PAGE: '.$page;
    
    // LOADS the right $pageContent array
    if($pageContent = $this->loadPrevNextPage($page)) {

      // -> CHECK IF PUBLIC
      // ---------------------------------------->        
      if($pageContent['public']) {            
        //print_r($page);
        
        // -> LINK TITLE
        // *****************
        // -> create the text
        if($linkText === true) {
        // add the TITLE
        $linkText = $this->createTitle($pageContent,
      					                       $this->linkCategorySeperator,
                                       $this->linkLength,
                                       false, // $titleAsLink
                                       $this->linkShowCategory,
                                       $this->linkShowPageDate);
        } elseif(is_string($linkText) &&
                 is_numeric($this->linkLength) &&
                 $this->generalFunctions->getRealCharacterNumber($linkText,$this->linkLength) > $this->linkLength) {
          $linkText = shortenText($linkText, $this->linkLength);
        }
	
        // -> sets the LINK
        // ----------------------------  
        $linkTag = 'a';
        $linkAttributes = '';
        
        // add HREF
        $linkAttributes .= ' href="'.$this->createHref($pageContent).'" title="'.$linkText.'"'; // title="'.$pageContent['title'].'"
	  
	$linkAttributes .= $this->createAttributes($this->linkId, $this->linkClass, $this->linkAttributes);
                    
        $linkStartTag = '<'.$linkTag.$linkAttributes.'>';
        $linkEndTag = '</'.$linkTag.'>';        
        
        // -> LINK THUMBNAIL
        // *****************
	      $returnThumbnail = false;
        if($this->linkShowThumbnail && $linkShowThumbnail = $this->createThumbnail($pageContent))
          $returnThumbnail = $linkShowThumbnail;
        
        // CHECK if the LINKTEXT BEFORE & AFTER is !== true
        $linkTextBefore = false;
        $linkTextAfter = false;
        
        if($linkText !== false) {
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
        if($this->linkShowThumbnailAfterText === true)
          $linkString = $linkTextBefore.$linkText.$linkTextAfter.$returnThumbnail;
        else
          $linkString = $returnThumbnail.$linkTextBefore.$linkText.$linkTextAfter;            

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
    
    $ids = $this->getPropertyIdsByType($idType,$ids);   
          
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
    
    // -> if pages should be SORTED BY CATEGORY
    if($sortByCategories === true)
      $pages = $this->generalFunctions->sortPages($pages);    
    
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
    $menuBetween = '';
    
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
          $link .= "<br \>\n";
        else
          $link .= "<br>\n";
      */
          
      // breaks the CELLs with TR after the given NUMBER of CELLS
      if($menuTagSet == 'table' &&
               is_numeric($breakAfter) &&
               ($breakAfter + 1) == $count) {
        //echo "</tr><tr>\n";
        $menu[] = "</tr><tr>\n";
        $count = 1;
      }
      
      /*
      // clears the $menuBetween String if its the last tag
      if($count == count($links))
        $menuBetween = false;
      */
      
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
                                   
    $ids = $this->getPropertyIdsByType($idType,$ids);
    
    // check for the tags and CREATE A MENU
    if($ids = $this->hasTags($idType,$ids,$tags)) {
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
      
      // gets the right pages and sorted by page date                      
      $pageContents = $this->loadPagesByDate($idType,$ids,$monthsInThePast,$monthsInTheFuture,$sortByCategories,$flipList);
      if($pageContents !== false)
	return $this->createMenu($idType,$pageContents,$menuTag,$linkText,$breakAfter,false);
      else return array();
      
  }
  // -> *ALIAS* OF createMenuByDate **********************************************************************
  function createMenuByDates($idType, $ids = true, $monthsInThePast = true, $monthsInTheFuture = true, $menuTag = false, $linkText = true, $breakAfter = false, $sortByCategories = false, $flipList = false) {
    // call the right function
    return $this->createMenuByDate($idType, $ids, $monthsInThePast, $monthsInTheFuture, $menuTag, $linkText, $breakAfter, $sortByCategories, $flipList);
  }  
  
 /**
  * Returns the language country code which was set in the feindura:feindura() constructor
  *
  * <b>Name</b>     getLanguage()<br>  
  *
  * @uses feindura::$language		        the set language country code like "en", "de", ...
  * 
  * @return string the language country code
  *
  * @see feindura::feindura()
  *
  * @version 1.0
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.0 initial release
  *
  */
  function getLanguage() { 
    return $this->language;
  }
  
  // -> START -- getPageTitle ********************************************************************************
  // RETURNs the Title of a given Page
  // RETURNs -> STRING
  // * MORE OPTIONs in the PROPERTIES
  // -----------------------------------------------------------------------------------------------------
  function getPageTitle($page = false) {              // (Number or String ("prev" or "next")) the page ID to show, if false it use VAR PRIORITY
    
   
    if($pageContent = $this->loadPrevNextPage($page)) {  
      
      if($pageContent['public']) { 
        
        // SET the PROPERTY $titleTag
        if($titleTag === true && $this->titleTag && $this->titleTag !== true)
          $titleTag = strtolower($this->titleTag);
        // OR SET GIVEN $titleTag         
        elseif(is_string($titleTag))
          $titleTag = strtolower($titleTag);
      
        // shows the TITLE
        $title = $this->createTitle($pageContent,
				                            $this->titleCategorySpacer,
                                    $this->titleLength,
                                    $this->titleAsLink,
                                    $this->titleShowCategory,
                                    $this->titleShowPageDate);                                      
      
        //echo $title;
        return $title;
        
      } else
      return false; 
    } else
      return false;    
  }
  // -> *ALIAS* OF showPageTitle **********************************************************************
  function getTitle($page = false) {
    // call the right function
    return $this->getPageTitle($page);
  } 
  
  // -> START -- getPage ********************************************************************************
  // RETURNs a Page, if there is no category set, it opens a page in the non-category
  // RETURNs -> STRING
  // * MORE OPTIONs in the PROPERTIES (TITLE and CONTENT layout)
  // -----------------------------------------------------------------------------------------------------
  /**< \brief \c array -> Stores the frontend language file \c array.
  */ 
  function getPage($page = false,                 // (Number or String ("prev" or "next")) the page ID to show, if false it use VAR PRIORITY
                           $shortenText = false,          // (false or Number) the Number of characters to shorten the content text
                           $useHtml = true) {             // (Boolean) use html in the content text
    
    
    //echo '<br />page: '.$page;
    //echo '<br />category: '.$category;    

    if($pageContent = $this->loadPrevNextPage($page)) {

      // ->> load SINGLE PAGE
      // *******************
      if($generatedPage = $this->generatePage($pageContent,$this->showError,$shortenText,$useHtml)) {
        
        // -> SAVE PAGE STATISTIC
        // **********************
        $this->statisticFunctions->savePageStats($pageContent);
        
        // returns the UNCHANGED pageContent Array, after showing the page
        return $generatedPage;
      }
    }    
    return false;
  }
  // -> END -- getPage -----------------------------------------------------------------------------------
  
  
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
    
    $ids = $this->getPropertyIdsByType($idType,$ids);
        
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
     
    $ids = $this->getPropertyIdsByType($idType,$ids);
    
    // check for the tags and LIST PAGES
    if($ids = $this->hasTags($idType,$ids,$tags)) {      
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
                                    
      
      // gets the right pages and sorted by page date                      
      $pageContents = $this->loadPagesByDate($idType,$ids,$monthsInThePast,$monthsInTheFuture,$sortByCategories,$flipList);
      if($pageContents !== false)
        return $this->listPages($idType,$pageContents,$shortenText,$useHtml,false);
      else return array();

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