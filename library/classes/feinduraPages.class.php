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
 * This file contains the {@link feinduraPages} class for implementing the CMS in a website
 * 
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
  * Therefor when a page content is displayed and this property is <i>FALSE</i> all " />" will be changed to ">".
  * 
  * @var bool
  * 
  */
  var $xHtml = true;
  
 /**
  * Contains the current page ID get from the <var>$_GET</var> variable
  *
  * This property is used when a page loading method is called (for example: {@link getPage()}) and no page ID parameter is given.
  *   
  * This property will be set in the {@link feinduraPages()} constructor through the {@link setCurrentPageId()} method.
  * 
  * @var int
  *
  * @see feinduraPages()
  * @see feindura::getCurrentPageId()
  *   
  */
  var $page = null;
  
 /**
  * Contains the current category ID get from the <var>$_GET</var> variable
  *
  * This property is used when a page-loading method is called (for example: {@link getPage()}) and no category ID parameter is given.
  *   
  * This property will be set in the {@link feinduraPages()} constructor through the {@link setCurrentCategoryId()} method.
  * 
  * @var int
  *
  * @see feinduraPages()
  * @see feindura::getCurrentCategoryId()  
  * 
  */
  var $category = null;
   
 /**
  * Contains the startpage ID from the {@link feindura::$websiteConfig website-settings config}
  *
  * This property is set to the {@link $page} property when the <var>$_GET</var> page variable
  * and the {@link $page} property is empty and setting a startpage is activated in the {@link $adminConfig page-settings}.
  *   
  * This property will be set in the {@link feinduraPages()} constructor through the {@link setCurrentPageId()} method.
  * 
  * @var int
  *
  * @see $page
  * @see feinduraPages()
  * @see setCurrentPageId()  
  * @see getCurrentPageId()
  *   
  */
  var $startPage = null;
  
 /**
  * Contains the startcategory ID
  *
  * Its fetched from the {@link $startPage} through the {@link getPageCategory()} method.<br>
  * This property is set to the {@link $category} property when the <var>$_GET</var> category variable
  * and the {@link $category} property is empty and setting a startpage is activated in the {@link $adminConfig page-settings}.
  *   
  * This property will be set in the {@link feinduraPages()} constructor through the {@link setCurrentCategoryId()} method.
  * 
  * @var int
  *
  * @see $startPage
  * @see $category  
  * @see feinduraPages()
  * @see setCurrentCategoryId()  
  * @see getCurrentCategoryId()
  *   
  */
  var $startCategory = null;
  
  /* ->> LINK <<- */
  
 /**
  * The number of maximal visible characters in the link text
  * of any link created by {@link createLink()} or {@link createMenu()}
  * 
  * The link text will be shorten to the last word.
  * 
  * Example shorting of "Example Shorting Text" with a given <var>$linkLength</var> of 14 will shorten to:
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
  * Contains an id-Attribute which will be add to any <a ...> tag
  * of any link created by {@link createLink()} or {@link createMenu()}
  * 
  * <b>Notice</b>: You can only set one specific id-Attribute to elements in a HTML page,
  * if you set this property and call {@link createMenu()} every link in the menu will get this id-Attribute.
  *  
  *    
  * @var string|false If no id-Attribute should be add, set it to FALSE.
  * @see createLink()
  * @see createMenu()
  * @example createLink.example.php
  * 
  */
  var $linkId = false;
  
 /**
  * Contains an class-Attribute which will be add to any <a ...> tag
  * of any link created by {@link createLink()} or {@link createMenu()}
  * 
  * <b>Notice</b>: If you set this property and call {@link createMenu()} every link in the menu will get this class-Attribute.
  * 
  * @var string|false If no class-Attribute should be add, set it to FALSE.
  * @see createLink()
  * @see createMenu()
  * @example createLink.example.php
  * 
  */
  var $linkClass = false;
  
 /**
  * Contains a string with attributes which will be add to any <a ...> tag
  * of any link created by {@link createLink()} or {@link createMenu()}
  * 
  * <b>Notice</b>: If you set this property and call {@link createMenu()} every link in the menu will get this attributes string.
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
  * Contains a string which will be add before any <a></a> tag
  * of any link created by {@link createLink()} or {@link createMenu()}
  * 
  * <b>Notice</b>: If you set this property and call {@link createMenu()} every link in the menu will get this text.
  * 
  * @var string|false If no text should be add before a link, set it to FALSE.
  * @see createLink()
  * @see createMenu()
  * @example createLink.example.php
  * 
  */
  var $linkBefore = false;
  
 /**
  * Contains a string which will be add after any <a></a> tag
  * of any link created by {@link createLink()} or {@link createMenu()}
  * 
  * <b>Notice</b>: If you set this property and call {@link createMenu()} every link in the menu will get this text.
  * 
  * @var string|false If no text should be add after a link, set it to FALSE.
  * @see createLink()
  * @see createMenu()
  * @example createLink.example.php
  * 
  */
  var $linkAfter = false;
  
 /**
  * Contains a string which will be add before the link text but inside any <a></a> tag
  * of any link created by {@link createLink()} or {@link createMenu()}
  * 
  * <b>Notice</b>: If you set this property and call {@link createMenu()} every link in the menu will get this text.  
  * 
  * @var string|false If no text should be add before a link text, set it to FALSE.
  * @see createLink()
  * @see createMenu()
  * @example createLink.example.php
  * 
  */
  var $linkTextBefore = false;
  
 /**
  * Contains a string which will be add after the link text but inside any <a></a> tag
  * of any link created by {@link createLink()} or {@link createMenu()}
  * 
  * <b>Notice</b>: If you set this property and call {@link createMenu()} every link in the menu will get this text.  
  * 
  * @var string|false If no text should be add after a link text, set it to FALSE.
  * @see createLink()
  * @see createMenu()
  * @example createLink.example.php
  * 
  */
  var $linkTextAfter = false;
  
 /**
  * If TRUE and the page has a thumbnail it places the thumbnail <img> tag inside the <a></a> tag
  * of any link created by {@link createLink()} or {@link createMenu()}
  * 
  * 
  * @var bool Set it to FALSE to don't show the thumbnails in links
  * @see createLink()
  * @see createMenu()
  * @example createLink.example.php
  * 
  */
  var $linkShowThumbnail = false;
  
 /**
  * If TRUE and thumbnail <img> tag will be placed after the link text but inside the <a></a> tag
  * of any link created by {@link createLink()} or {@link createMenu()}
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
  * If TRUE, pagedates are allowed for the pages in this category and the page has a pagedate then it will be add before the link text
  * of any link created by {@link createLink()} or {@link createMenu()}
  * 
  * If the {@link $linkShowCategory} property is TRUE, the pagedate is placed between the category name + seperator and the link text.<br>
  * The pagedate will be added with the page before-date-text and after-date-text from the page editor in the backend
  *   
  * <b>Notice</b>: The pagedate will only be displayed if the <var>$linkText</var> parameter of {@link createLink()} or {@link createMenu()} methods is TRUE and not a string.
  * 
  * Example:
  * <samp>
  * <a href="?page=2" ...>Catgory Name: 200-12-31 Page Title</a>
  * </samp>
  *    
  * @var bool Set it to TRUE to place the pagedate before the link text
  * @see createLink()
  * @see createMenu()
  * @example createLink.example.php
  * 
  */
  var $linkShowPageDate = false;

 /**
  * If TRUE, the category name of the page will be add before the link text
  * with the {@link $linkCategorySpacer} property as seperator of any link created by {@link createLink()} or {@link createMenu()}
  * 
  * The category name will only be displayed if the <var>$linkText</var> parameter of {@link createLink()} or {@link createMenu()} methods is TRUE and not a string.
  * 
  * Example:
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
  * this string will be used as a seperator between the category name and the link text of any link created by {@link createLink()} or {@link createMenu()}
  * 
  * <b>Notice</b>: If you set this property and call {@link createMenu()} every link in the menu will use this seperator.  
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
  * A number of maximal characters visible of the pagetitle text
  * 
  * The pagetitle will be shorten to the last word.
  * 
  * Example shorting of "Example Shorting Text" with a given <var>$titleLength</var> of 18 will shorten to:
  * <samp>
  * "Example Shorting..."
  * </samp>
  * 
  * @var int|false Number of characters or FALSE to don't shorten the pagetitle
  * @see getTitle()
  * @see feindura::createTitle()
  * @example getPage.example.php
  * 
  */
  var $titleLength = false;
  
 /**
  * If TRUE the pagetitle is also a link to the page
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
  * If TRUE, pagedates are allowed for the pages in this category and the page has a pagedate then it will be add before the pagetitle
  * 
  * If the {@link $titleShowCategory} property is TRUE, the pagedate is placed between the category name + seperator and the pagetitle.<br>
  * The pagedate will be added with the page before-date-text and after-date-text from the page editor in the backend.
  * 
  * Example:
  * <samp>
  * Catgory Name: 200-12-31 Page Title
  * </samp>
  *    
  * @var bool Set it to TRUE to place the pagedate before the pagetitle
  * @see getTitle()
  * @see feindura::createTitle()
  * @example getPage.example.php
  * 
  */
  var $titleShowPageDate = false;
  
 /**
  * If TRUE, the category name of the page will be add before the pagetitle with the {@link $linkCategorySpacer} property as seperator
  * 
  * 
  * Example:
  * <samp>
  * Catgory Name: Page Title
  * </samp>
  *     
  * @var bool Set it to TRUE to place the category name before the pagetitle
  * @see getTitle()
  * @see feindura::createTitle()
  * @example getPage.example.php
  * 
  */
  var $titleShowCategory = false;
  
 /**
  * If the {@link $titleShowCategory} property is TRUE, this string will be used as a seperator between the category name and the pagetitle
  * 
  * 
  * @var string
  * @see getTitle()
  * @see feindura::createTitle()
  * @example getPage.example.php
  * 
  */
  var $titleCategorySeperator = ': ';
  
  /* old
  var $titleTag = false;                  // [Boolean or String]    -> the title TAG which is used when creating a pagetitle (STANDARD Tag: H1)
  var $titleId = false;                   // [False or String]      -> the title ID which is used when creating a pagetitle (REMEMBER you can only set ONE ID in an HTML Page, so dont use this for listing Pages)
  var $titleClass = false;                // [False or String]      -> the title CLASS which is used when creating a pagetitle
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
  * Example:
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
  * Example:
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
  * Example:
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
  * Example:
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
  * Example:
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
  * If there is no page and category ID it sets the start page ID from the {@link feindura::$websiteConfig website-settings config}.
  * 
  *  <b>Type</b>     constructor<br>
  * <b>Name</b>     feinduraPages()<br>  
  * 
  * Example:
  * {@example includeFeindura.example.php}
  *
  * @param string $language (optional) A country code like "de", "en", ... to load the right frontend language-file and is also set to the {@link feindura::$language} property 
  *
  * @uses feindura::feindura()		          the constructor of the parent class to load all necessary properties
  * @uses feindura::setCurrentCategoryId()  to set the fetched category ID from the $_GET variable to the {@link $category} property
  * @uses feindura::setCurrentPageId()      to set the fetched page ID from the $_GET variable to the {@link $page} property
  * 
  * @return void
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
    $this->setCurrentCategoryId(true);       // $_GET['category']  // first load category then the page, because getCurrentPageId needs categories
    $this->setCurrentPageId(true);           // $_GET['page'] <- set the $this->websiteConfig['startPage'] if there is no $_GET['page'] variable
  }
 
  
  // ****************************************************************************************************************
  // PUBLIC METHODs -------------------------------------------------------------------------------------------------
  // ****************************************************************************************************************
  
 /**
  * Creates a string with all necessary meta tags
  *
  * <b>Name</b>     createMetaTags()<br>
  * <b>Alias</b>    createMetaTag()<br>
  *    
  * Example:
  * {@example createMetaTags.example.php}    
  *
  * @param string       $charset      (optional) the charset used in the website like "UTF-8", "iso-8859-1", ...
  * @param string|false $author       (optional) the author of the website
  * @param string|bool  $publisher    (optional) the publisher of the website, if TRUE it uses the publisher from the {@link feindura::$websiteConfig website-settings config}
  * @param string|bool  $copyright    (optional) the copyright owner of the website, if TRUE it uses the copyright from the {@link feindura::$websiteConfig website-settings config}
  * @param string|bool  $robotTxt     (optional) if TRUE it sets the "robot.txt" file relative to this HTML page, if this parameter is a string it will be used as "path/filename"
  * @param int|false    $revisitAfter (optional) a number of days to revisit the page as information for webcrawler, if FALSE this meta tag will nopt be created
  *
  * @uses feindura::$websiteConfig      for the website title, publisher, copyright, description and keywords
  * @uses generalFunctions::readPage()	to read the page and set the pagetitle
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
      if($this->xHtml === true) {   
        $siteType = 'application/xhtml+xml';
        $tagEnding = ' />';
      } else {
        $siteType = 'text/html';
        $tagEnding = '>';
      }
        
      
      // -> add CHARSET
      $metaTags .= '<meta http-equiv="content-type" content="'.$siteType.'; charset='.$charset.'"'.$tagEnding."\n";
      
      // -> add language
      if($this->language)
        $metaTags .= '  <meta http-equiv="content-language" content="'.$this->language.'"'.$tagEnding."\n\n"; 
      
      // -> create TITLE
      if($this->getCurrentPageId() && $currentPage = $this->generalFunctions->readPage($this->getCurrentPageId(),$this->getCurrentCategoryId()))
        $pageNameInTitle = ' - '.$currentPage['title'];
      
      // -> add TITLE
      $metaTags .= '  <title>'."\n";      
      $metaTags .= '  '.$this->websiteConfig['title'].$pageNameInTitle."\n";
      $metaTags .= '  </title>'."\n\n";
      
      // -> add robots.txt
      if($robotTxt === true)
        $metaTags .= '  <meta name="siteinfo" content="robots.txt"'.$tagEnding."\n";
      elseif(!empty($robotTxt))
        $metaTags .= '  <meta name="siteinfo" content="'.$robotTxt.'"'.$tagEnding."\n";
      
      if($robotTxt) {
        $metaTags .= '  <meta name="robots" content="index"'.$tagEnding."\n";
        $metaTags .= '  <meta name="robots" content="nofollow"'.$tagEnding."\n";
      }
        
      // -> add REVISIT AFTER
      if($robotTxt && $revisitAfter !== false && is_numeric($revisitAfter))
        $metaTags .= '  <meta name="revisit_after" content="'.$revisitAfter.'"'.$tagEnding."\n\n";
      
      // -> add other META TAGs 
      $metaTags .= '  <meta http-equiv="pragma" content="no-cache"'.$tagEnding.' <!-- browser/proxy does not cache -->'."\n";
      $metaTags .= '  <meta http-equiv="cache-control" content="no-cache"'.$tagEnding.' <!-- browser/proxy does not cache -->'."\n\n";
      
      // -> add title
      $metaTags .= '  <meta name="title" content="'.$this->websiteConfig['title'].$pageNameInTitle.'"'.$tagEnding."\n";
      
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
      if($currentPage['description'])
        $metaTags .= '  <meta name="description" content="'.$currentPage['description'].'"'.$tagEnding."\n";
      elseif($this->websiteConfig['description'])
        $metaTags .= '  <meta name="description" content="'.$this->websiteConfig['description'].'"'.$tagEnding."\n";
        
      // -> add keywords
      if($this->websiteConfig['keywords'])
        $metaTags .= '  <meta name="keywords" content="'.$this->websiteConfig['keywords'].'"'.$tagEnding."\n";
      
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
  * Generates a href attribute to link to a page.
  * Depending whether speaking URLs is in the administrator-settings activated, it generates a different href attribute.<br>
  * If cookies are deactivated it attaches the {@link $sessionId} on the end.
  *
  * <b>Name</b>     createHref()<br>
  *     
  * Examples of the returned href string:<br>
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
  function createHref($page = false) {
    
    if($pageContent = $this->loadPrevNextPage($page)) {
    
      return $this->generalFunctions->createHref($pageContent,$this->sessionId);  
        
    } else return false;    
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
          $returnThumbnail = $linkShowThumbnail['thumbnail'];
        
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
  
 /**
  * Creates a menu out of a category or page ID(s)
  *
  * The <var>$menuTag</var> parameter can be an "ul", "ol" or "table", it will then create the necessary sub tags for this elements.
  * If its any other tag name it just enclose the links with this tag.
  *
  * In case the category or page ID(s) doesn't exist it returns an empty array.
  *  
  * Example:

  * 
  * <b>Name</b>     createMenu()<br>    
  * 
  * @param string         $idType             (optional) the ID(s) type can be "cat", "category", "categories" or "pag", "page" or "pages"  *   
  * @param int|array|bool $ids                (optional) the category or page ID(s), can be a number or an array with numbers (can also be a $pageContent array), if TRUE it loads all pages
  * @param int|bool       $menuTag            (optional) the tag which is used to create the menu, can be an "ul", "ol", "table" or any other tag, if TRUE it uses "div" as a standard tag
  * @param string|bool    $linkText           (optional) a string with a linktext which all links will use, if TRUE it uses the pagetitles of the pages, if FALSE no linktext will be used
  * @param int|false      $breakAfter         (optional) if the $menuTag parameter is "table", this parameter defines after how many "td" tags a "tr" tag will follow, with any other tag this parameter has no effect
  * @param bool           $sortByCategories   (optional) if TRUE it sorts the given category or page ID(s) by category
  * 
  * @uses $adminConfig                             for the thumbnail upload path
  * @uses $categoryConfig                          to check whether the category of the page allows thumbnails
  * @uses $languageFile                           for the error texts
  * @uses publicCategory()                        to check whether the category is public
  * @uses isPageContentArray()                    to check if the given array is a $pageContent array
  * @uses createTitle()                           to create the pagetitle
  * @uses createThumbnail()                       to check to show thumbnails are allowed and create the thumbnail <img> tag
  * @uses createAttributes()                      to create the attributes used in the error tag
  * @uses shortenHtmlText()                       to shorten the HTML page content
  * @uses shortenText()                           to shorten the non HTML page content, if the $useHtml parameter is FALSE
  * @uses statisticFunctions::formatDate()        to format the pagedate for output
  * @uses generalFunctions::dateDayBeforeAfter()  check if the pagedate is "yesterday" "today" or "tomorrow"
  * @uses generalFunctions::readPage()		        to load the page if the $page parameter is an ID
  * @uses feinduraPages::$xHtml
  * @uses feinduraPages::$linkLength
  * @uses feinduraPages::$linkId
  * @uses feinduraPages::$linkClass  
  * @uses feinduraPages::$titleShowPageDate  
  * @uses feinduraPages::$titleShowCategory
  * @uses feinduraPages::$titleCategorySeperator
  * @uses feinduraPages::$thumbnailAlign  
  * @uses feinduraPages::$thumbnailId
  * @uses feinduraPages::$thumbnailClass
  * @uses feinduraPages::$thumbnailAttributes
  * @uses feinduraPages::$thumbnailBefore
  * @uses feinduraPages::$thumbnailAfter
  * 
  * @return array the generated page array, ready to display in a HTML file
  *
  *
  * @version 1.0
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.0 initial release
  *
  */
  function createMenu($idType = 'categories', $ids = false, $menuTag = false, $linkText = true, $breakAfter = false, $sortByCategories = false) {
    
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
      
      // gets the right pages and sorted by pagedate                      
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
				                            $this->titleCategorySeperator,
                                    $this->titleLength,
                                    $this->titleAsLink,
                                    $this->titleShowCategory,
                                    $this->titleShowPageDate);                                      
      
        //echo $title;
        return $title;
        
      } else return false; 
    } else return false;    
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
    } else return false;
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
                                    
      
      // gets the right pages and sorted by pagedate                      
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