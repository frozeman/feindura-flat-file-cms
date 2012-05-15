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
* It's methods provide necessary functions for implementing the CMS in a website.<br>
* It contains, for example, methods for building a menu and get page contents, etc.
* 
* @author Fabian Vogelsteller <fabian@feindura.org>
* @copyright Fabian Vogelsteller
* @license http://www.gnu.org/licenses GNU General Public License version 3
* 
* @package [Implementation]
* 
* @version 2.0
* <br>
* <b>ChangeLog</b><br>
*    - 2.0 add {@link Feindura::createSubMenu()}, {@link Feindura::isSubCategory()}, {@link Feindura::isSubCategoryOf()}, {@link Feindura::createMenuOfSubCategory()}, {@link Feindura::createLanguageMenu()}, {@link Feindura::createBreadCrumbsMenu()}, {@link Feindura::hasTags()}
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
  * Contains metaData which can be used in the website.
  * 
  * Example of the array
  * {@example metaData.array.example.php} 
  *
  * @var array
  * @access public
  */
  public $metaData = array();

 /**
  * TRUE when the pages content should be handled as XHTML.
  * 
  * In XHTML standalone tags end with " />" instead of ">".<br>
  * Therefor when a page content is displayed and this property is <i>FALSE</i> all " />" will be changed to ">".
  * 
  * @var bool
  * @access public
  */
  public $xHtml = false;


 /**
  * A country code (example: <i>de, en,</i> ..) to set the language of the frontend language-files
  * 
  * This country code is used to include the right frontend language-file.
  * The frontend language-file is used when displaying page <i>warnings</i> or <i>errors</i> and additional texts like <i>"more"</i>, etc.<br>
  * This property will be set in the {@link Feindura::__construct()} constructor.
  * 
  * The standard value is <i>"en"</i> (english).
  *  
  * @var string
  * @access public
  * @see FeinduraBase::$languageFile
  * @see Feindura::__construct()
  * 
  */  
  public $language = 'en';
  
 /**
  * Contains the current page ID get from the <var>$_GET</var> variable.
  * 
  * This property is used when a page loading method is called (for example: {@link Feindura::showPage()}) and no page ID parameter is given.
  * 
  * This property will be set in the {@link Feindura::__construct()} constructor through the {@link FeinduraBase::setCurrentPageId()} method.
  * 
  * @var int
  * @access public
  * 
  * @see Feindura::__construct()
  * @see FeinduraBase::getCurrentPageId()
  * 
  */
  public $page = null;
  
 /**
  * Contains the current category ID get from the <var>$_GET</var> variable.
  * 
  * This property is used when a page-loading method is called (for example: {@link Feindura::showPage()}) and no category ID parameter is given.
  * 
  * This property will be set in the {@link Feindura::__construct()} constructor through the {@link FeinduraBase::setCurrentCategoryId()} method.
  * 
  * @var int
  * @access public
  * 
  * @see Feindura::__construct()
  * @see FeinduraBase::getCurrentCategoryId()
  * 
  */
  public $category = null;
   
 /**
  * Contains the startpage ID from the {@link FeinduraBase::$websiteConfig website-settings config}.
  * 
  * This property is set to the {@link Feindura::$page} property when the <var>$_GET</var> page variable
  * and the {@link Feindura::$page} property is empty and setting a startpage is activated in the {@link FeinduraBase::$adminConfig page-settings}.
  * 
  * This property will be set in the {@link Feindura::__construct()} constructor through the {@link FeinduraBase::setCurrentPageId()} method.
  * 
  * @var int
  * @access public
  * 
  * @see Feindura::$page
  * @see Feindura::__construct()
  * @see setCurrentPageId()
  * @see getCurrentPageId()
  * 
  */
  public $startPage = null;
  
 /**
  * Contains the startcategory ID
  * 
  * Its fetched from the {@link Feindura::$startPage} through the {@link GeneralFunctions::getPageCategory()} method.<br>
  * This property is set to the {@link Feindura::$category} property when the <var>$_GET</var> category variable
  * and the {@link Feindura::$category} property is empty and setting a startpage is activated in the {@link FeinduraBase::$adminConfig page-settings}.
  * 
  * This property will be set in the {@link Feindura::__construct()} constructor through the {@link FeinduraBase::setCurrentCategoryId()} method.
  * 
  * @var int
  * @access public
  * 
  * @see Feindura::$startPage
  * @see Feindura::$category
  * @see Feindura::__construct()
  * @see setCurrentCategoryId()
  * @see getCurrentCategoryId()
  * 
  */
  public $startCategory = null;
  
  /* ->> LINK <<- */
  
 /**
  * The number of maximal visible characters in the link text
  * of any link created by {@link Feindura::createLink()} or {@link Feindura::createMenu()}.
  * 
  * The link text will be shorten to the last complete word.
  * 
  * For example the following string will be shorten to a <var>$linkLength</var> of <i>"30"</i>:
  * <samp>
  * "Example Category -> Example Page Title" => "Example Category -> Example..."
  * </samp>
  * 
  * @var int|false a number of characters, or FALSE to don't shorten the link text.
  * @access public
  * 
  * @see Feindura::createLink()
  * @see Feindura::createMenu()
  * @example createLink.example.php
  * 
  */
  public $linkLength = false;  

 /**
  * Contains an id-Attribute which will be add to any <a ...> tag
  * of any link created by {@link Feindura::createLink()} or {@link Feindura::createMenu()}.
  * 
  * <b>Note</b>: You should set a unique id-Attribute only once to elements in a HTML page,
  * if you set this property and call {@link Feindura::createMenu()} every link in the menu will get this id-Attribute.
  * 
  * @var string|false If no id-Attribute should be add, set it to FALSE.
  * @access public
  * 
  * @see Feindura::createLink()
  * @see Feindura::createMenu()
  * @example createLink.example.php
  * 
  */
  public $linkId = false;
  
 /**
  * Contains an class-Attribute which will be add to any <a ...> tag
  * of any link created by {@link Feindura::createLink()} or {@link Feindura::createMenu()}.
  * 
  * <b>Note</b>: If you set this property and call {@link Feindura::createMenu()} every link in the menu will get this class-Attribute.
  * 
  * @var string|false If no class-Attribute should be add, set it to FALSE.
  * @access public
  * 
  * @see Feindura::createLink()
  * @see Feindura::createMenu()
  * @example createLink.example.php
  * 
  */
  public $linkClass = false;

 /**
  * This class name will be add to every link created with {@link Feindura::createLink()} or {@link Feindura::createMenu()},
  * when it is matching the currently selected page.
  * 
  * @var string
  * @access public
  * 
  * @see Feindura::createLink()
  * @see Feindura::createMenu()
  * @example createLink.example.php
  * 
  */
  public $linkActiveClass = 'active';
  
 /**
  * Contains a string with attributes which will be add to any <a ...> tag
  * of any link created by {@link Feindura::createLink()} or {@link Feindura::createMenu()}.
  * 
  * <b>Note</b>: If you set this property and call {@link Feindura::createMenu()} every link in the menu will get this attributes string.
  * 
  * The string should have the following format
  * <samp>
  * 'key1="value" key2="value"'
  * </samp>
  * 
  * @var string|false If no additional attributes should be add, set it to FALSE.
  * @access public
  * 
  * @see Feindura::createLink()
  * @see Feindura::createMenu()
  * @example createLink.example.php
  * 
  */
  public $linkAttributes = false;

 /**
  * Contains a string which will be add before any <a></a> tag
  * of any link created by {@link Feindura::createLink()} or {@link Feindura::createMenu()}.
  * 
  * <b>Note</b>: If you set this property and call {@link Feindura::createMenu()} every link in the menu will get this string.
  * 
  * @var string|false If no text should be add before a link, set it to FALSE.
  * @access public
  * 
  * @see Feindura::createLink()
  * @see Feindura::createMenu()
  * @example createLink.example.php
  * 
  */
  public $linkBefore = false;
  
 /**
  * Contains a string which will be add after any <a></a> tag
  * of any link created by {@link Feindura::createLink()} or {@link Feindura::createMenu()}.
  * 
  * <b>Note</b>: If you set this property and call {@link Feindura::createMenu()} every link in the menu will get this string.
  * 
  * @var string|false If no text should be add after a link, set it to FALSE.
  * @access public
  * 
  * @see Feindura::createLink()
  * @see Feindura::createMenu()
  * @example createLink.example.php
  * 
  */
  public $linkAfter = false;
  
 /**
  * Contains a string which will be add before the link text but inside any <a></a> tag
  * of any link created by {@link Feindura::createLink()} or {@link Feindura::createMenu()}.
  * 
  * <b>Note</b>: If you set this property and call {@link Feindura::createMenu()} every link in the menu will get this string.  
  * 
  * @var string|false If no text should be add before a link text, set it to FALSE.
  * @access public
  * 
  * @see Feindura::createLink()
  * @see Feindura::createMenu()
  * @example createLink.example.php
  * 
  */
  public $linkBeforeText = false;
  
 /**
  * Contains a string which will be add after the link text but inside any <a></a> tag
  * of any link created by {@link Feindura::createLink()} or {@link Feindura::createMenu()}.
  * 
  * <b>Note</b>: If you set this property and call {@link Feindura::createMenu()} every link in the menu will get this string.  
  * 
  * @var string|false If no text should be add after a link text, set it to FALSE.
  * @access public
  * 
  * @see Feindura::createLink()
  * @see Feindura::createMenu()
  * @example createLink.example.php
  * 
  */
  public $linkAfterText = false;
  
 /**
  * If TRUE and the page has a thumbnail, it places the thumbnail <img> tag inside the <a></a> tag
  * of any link created by {@link Feindura::createLink()} or {@link Feindura::createMenu()}.
  * 
  * @var bool Set it to FALSE to don't show the thumbnails in links
  * @access public
  * 
  * @see Feindura::createLink()
  * @see Feindura::createMenu()
  * @example createLink.example.php
  * 
  */
  public $linkShowThumbnail = false;
  
 /**
  * If TRUE and the page has a thumbnail, it places the thumbnail <img> tag after the link text but inside the <a></a> tag
  * of any link created by {@link Feindura::createLink()} or {@link Feindura::createMenu()}.
  * 
  * 
  * @var bool Set it to TRUE to place the thumbnail <img> tag after the link text
  * @access public
  * 
  * @see Feindura::createLink()
  * @see Feindura::createMenu()
  * @example createLink.example.php
  * 
  */
  public $linkShowThumbnailAfterText = false;
  
 /**
  * If TRUE, page dates are allowed for the pages in this category and the page has a page date then it will be add before the link text
  * of any link created by {@link Feindura::createLink()} or {@link Feindura::createMenu()}.
  * 
  * If the {@link Feindura::$linkShowCategory} property is TRUE, the page date is placed between the category name + separator and the link text.<br>
  * The page date will be added with the page before-date-text and after-date-text from the page editor in the backend
  *   
  * <b>Note</b>: The page date will only be displayed if the <var>$linkText</var> parameter of {@link Feindura::createLink()} or {@link Feindura::createMenu()} methods is TRUE and not a string.
  * 
  * Example:
  * <samp>
  * <a href="?page=2" ...>200-12-31 Page Title</a>
  * </samp>
  *    
  * @var bool Set it to TRUE to place the page date before the link text
  * @access public
  * 
  * @see Feindura::createLink()
  * @see Feindura::createMenu()
  * @example createLink.example.php
  * 
  */
  public $linkShowPageDate = false;

 /**
  * If the {@link Feindura::$linkShowPageDate} property is TRUE,
  * this string will be used as a separator between the page date and the link text of any link created by {@link Feindura::createLink()} or {@link Feindura::createMenu()}.
  * 
  * <b>Note</b>: If you set this property and call {@link Feindura::createMenu()} every link in the menu will use this separator.
  * 
  * @var string
  * @access public
  * 
  * @see Feindura::createLink()
  * @see Feindura::createMenu()
  * @example createLink.example.php
  * 
  */
  public $linkPageDateSeparator = ' ';

 /**
  * If TRUE, the category name of the page will be add before the link text
  * with the {@link Feindura::$linkCategorySpacer} property as separator of any link created by {@link Feindura::createLink()} or {@link Feindura::createMenu()}.
  * 
  * The category name will only be displayed if the <var>$linkText</var> parameter of {@link Feindura::createLink()} or {@link Feindura::createMenu()} methods is TRUE and not a string.
  * 
  * Example:
  * <samp>
  * <a href="?page=2" ...>Catgory Name: Page Title</a>
  * </samp>
  * 
  * @var bool Set it to TRUE to place the category name before the link text
  * @access public
  * 
  * @var bool
  * @see Feindura::createLink()
  * @see Feindura::createMenu()
  * @example createLink.example.php
  * 
  */
  public $linkShowCategory = false;
  
 /**
  * If the {@link Feindura::$linkShowCategory} property is TRUE,
  * this string will be used as a separator between the category name and the link text of any link created by {@link Feindura::createLink()} or {@link Feindura::createMenu()}.
  * 
  * <b>Note</b>: If you set this property and call {@link Feindura::createMenu()} every link in the menu will use this separator.
  * 
  * @var string
  * @access public
  * 
  * @see Feindura::createLink()
  * @see Feindura::createMenu()
  * @example createLink.example.php
  * 
  */
  public $linkCategorySeparator = ': ';
  
  /* ->> MENU <<- */
  
 /**
  * Contains an id-Attribute which will be add to the menu tag.
  * 
  * <b>Notice 1</b>: This id-Attribute will only be add, if the <var>$menuTag</var> parameter in the {@link Feindura::createMenu()} method is not FALSE.<br>
  * <b>Notice 2</b>: You can only set one specific id-Attribute to elements in a HTML page.
  * 
  * @var string|false If no id-Attribute should be add, set it to FALSE.
  * @access public
  * 
  * @see Feindura::createMenu()
  * @example createMenu.example.php
  * 
  */
  public $menuId = false;
  
 /**
  * Contains an class-Attribute which will be add to the menu tag.
  * 
  * <b>Note</b>: This class-Attribute will only be add, if the <var>$menuTag</var> parameter in the {@link Feindura::createMenu()} method is not FALSE.<br>
  * 
  * @var string|false If no class-Attribute should be add, set it to FALSE.
  * @access public
  * 
  * @see Feindura::createMenu()
  * @example createMenu.example.php
  * 
  */
  public $menuClass = false;
  
 /**
  * Contains a string with attributes which will be add to the menu tag.
  * 
  * <b>Note</b>: This string with attributes will only be add, if the <var>$menuTag</var> parameter in the {@link Feindura::createMenu()} method is not FALSE.<br>
  * 
  * The string should have the following format
  * <samp>
  * 'key1="value" key2="value"'
  * </samp>
  *    
  * @var string|false If no additional attributes should be add, set it to FALSE.
  * @access public
  * 
  * @see Feindura::createMenu()
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
  * @see Feindura::getTitle()
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
  * @see Feindura::getTitle()
  * @see FeinduraBase::createTitle()
  * @example showPage.example.php
  * 
  */
  public $titleAsLink = false;

 /**
  * If TRUE, page dates are allowed for the pages in this category and the page has a page date then it will be add before the page title.
  * 
  * If the {@link Feindura::$titleShowCategory} property is TRUE, the page date is placed between the category name + separator and the page title.<br>
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
  * @see Feindura::getTitle()
  * @see FeinduraBase::createTitle()
  * @example showPage.example.php
  * 
  */
  public $titleShowPageDate = false;
  
 /**
  * If the {@link Feindura::$titleShowPageDate} property is TRUE, this string will be used as a separator between the page date and the page title.
  * 
  * @var string
  * @access public
  * 
  * @see Feindura::getTitle()
  * @see FeinduraBase::createTitle()
  * @example showPage.example.php
  * 
  */
  public $titlePageDateSeparator = ' ';
  
 /**
  * If TRUE, the category name of the page will be add before the page title with the {@link Feindura::$linkCategorySpacer} property as separator.
  * 
  * Example:
  * <samp>
  * Catgory Name: Page Title
  * </samp>
  * 
  * @var bool Set it to TRUE to place the category name before the page title
  * @access public
  * 
  * @see Feindura::getTitle()
  * @see FeinduraBase::createTitle()
  * @example showPage.example.php
  * 
  */
  public $titleShowCategory = false;
  
 /**
  * If the {@link Feindura::$titleShowCategory} property is TRUE, this string will be used as a separator between the category name and the page title.
  * 
  * @var string
  * @access public
  * 
  * @see Feindura::getTitle()
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
  * <b>Note</b>: If you set this property, you can't add any style attribute with the {@link Feindura::$thumbnailAttributes} property anymore, it would not be used by the browser.
  * 
  * <samp>
  * <img src="/path/image.png" ... style="float:left;" />
  * </samp>
  * 
  * @var string|false If no style="float:left/right;" attribute should be add, set it to FALSE.
  * @access public
  * 
  * @see Feindura::createLink()
  * @see Feindura::createMenu()
  * @see Feindura::showPage()
  * @see FeinduraBase::generatePage()
  * @example showPage.example.php
  * 
  */
  public $thumbnailAlign = false;
  
 /**
  * Contains an id-Attribute which will be add to the thumbnail <img> tag.
  * 
  * <b>Note</b>: You can only set one specific id-Attribute to elements in a HTML page.
  * 
  * @var string|false If no id-Attribute should be add, set it to FALSE.
  * @access public
  * 
  * @see Feindura::createLink()
  * @see Feindura::createMenu()
  * @see Feindura::showPage()
  * @see FeinduraBase::generatePage()
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
  * @see Feindura::createLink()
  * @see Feindura::createMenu()
  * @see Feindura::showPage()
  * @see FeinduraBase::generatePage()
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
  * @see Feindura::createLink()
  * @see Feindura::createMenu()
  * @see Feindura::showPage()
  * @see FeinduraBase::generatePage()
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
  * @see Feindura::createLink()
  * @see Feindura::createMenu()
  * @see Feindura::showPage()
  * @see FeinduraBase::generatePage()
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
  * @see Feindura::createLink()
  * @see Feindura::createMenu()
  * @see Feindura::showPage()
  * @see FeinduraBase::generatePage()
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
  * @see Feindura::showPage()
  * @see FeinduraBase::generatePage()
  * @example showPage.example.php
  * 
  */
  public $showErrors = true;
  
 /**
  * The tag which should be used for the error message.
  * 
  * <b>Note</b>: If this property is no string, the {@link Feindura::$errorId}, {@link Feindura::$errorClass} and {@link Feindura::$errorAttributes} property will not be add.<br>
  * 
  * Example:
  * <samp>
  * <span>The requested page is currently not available.</span>
  * </samp>
  * 
  * @var string|false If no tag should be add, set it to FALSE.
  * @access public
  * 
  * @see Feindura::showPage()
  * @see FeinduraBase::generatePage()
  * @example showPage.example.php
  * 
  */
  public $errorTag = 'span';                // [False or String]      -> the message TAG which is used when creating a message (STANDARD Tag: SPAN; if there is a class and/or id and no TAG is set)
 
 /**
  * Contains an id-Attribute which will be add to the error tag.
  * 
  * <b>Notice 1</b>: This id-Attribute will only be add, if the {@link Feindura::$errorTag} property is a string and not FALSE.<br>
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
  * @see Feindura::showPage()
  * @see FeinduraBase::generatePage()
  * @example showPage.example.php
  * 
  */
  public $errorId = false;
  
 /**
  * Contains an class-Attribute which will be add to the error tag.
  * 
  * <b>Note</b>: This class-Attribute will only be add, if the {@link Feindura::$errorTag} property is a string and not FALSE.<br>
  * 
  * Example:
  * <samp>
  * <span class="exampleId">The requested page is currently not available.</span>
  * </samp>
  * 
  * @var string|false If no class-Attribute should be add, set it to FALSE.
  * @access public
  * 
  * @see Feindura::showPage()
  * @see FeinduraBase::generatePage()
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
  * @see Feindura::showPage()
  * @see FeinduraBase::generatePage()
  * @example showPage.example.php
  * 
  */
  public $errorAttributes = false;

 /* ---------------------------------------------------------------------------------------------------------------------------- */
 /* *** CONSTRUCTOR *** */
 /* **************************************************************************************************************************** */
  
 /**
  * <b>Type</b> constructor<br> 
  * 
  * The constructor of the class, sets all basic properties.
  * 
  * Calls the {@link FeinduraBase::__construct()} class constructor to set all necessary properties
  * Fetch the <var>$_GET</var> variable (if existing) and set it to the {@link Feindura::$page} and {@link Feindura::$category} properties.<br>
  * If there is no page and category ID it sets the start page ID from the {@link FeinduraBase::$websiteConfig website-settings config}.
  * 
  * 
  * Example:
  * {@example includeFeindura.example.php}
  * 
  * @param string $language (optional) A country code like "de", "en", ... to load the right frontend language-file and is set to the {@link FeinduraBase::$language} property
  * 
  * @uses FeinduraBase::__construct()		          the constructor of the parent class to load all necessary properties
  * @uses FeinduraBase::setCurrentCategoryId()  to set the fetched category ID from the $_GET variable to the {@link Feindura::$category} property
  * @uses FeinduraBase::setCurrentPageId()      to set the fetched page ID from the $_GET variable to the {@link Feindura::$page} property
  * 
  * @return void
  * 
  * @see FeinduraBase::__construct()
  * 
  * @access public
  * @version 1.0
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.0 initial release
  * 
  */
  public function __construct($language = false) {

    // RUN the FeinduraBase constructor
    parent::__construct($language);
    

    // saves the current GET vars in the PROPERTIES
    // ********************************************
    $this->setCurrentPageId(true);           // get $_GET['page'] <- set the $this->websiteConfig['startPage'] if there is no $_GET['page'] variable
    $this->setCurrentCategoryId(true);       // get $_GET['category']
    // set category automatically, if it couldn't be retrieved 
    if($this->category == null) $this->category = GeneralFunctions::getPageCategory($this->page);

    // save the website statistics
    // ***************************
    StatisticFunctions::saveWebsiteStats($this->page);

    // ->> SETS the LANGUAGE PROPERTY from the $_GET['language']
    // -> if the $language PARAMETER was given, it HAS PRIORITY
    if(is_string($language) && strlen($language) == 2)
      $_GET['language'] = $language;

    // -> use the $_GET['language'] if available
    if(is_string($_GET['language']) && strlen($_GET['language']) == 2) {
      $this->language = XssFilter::alphabetical($_GET['language']);
      // make sure the language exist
      if(is_array($this->adminConfig['multiLanguageWebsite']['languages']) && in_array($this->language, $this->adminConfig['multiLanguageWebsite']['languages']))
        $this->language = $this->language;
      else
        $this->language = $this->adminConfig['multiLanguageWebsite']['mainLanguage'];
      $_SESSION['feinduraSession']['websiteLanguage'] = $this->language;

    // -> if NO LANGUAGE WAS GIVEN, it will try to get it automatically
    } else {
      // if language is NOT stored IN the SESSION, try to GET the BROWSERLANGUAGE
      if(empty($_SESSION['feinduraSession']['websiteLanguage']) ||
         (!empty($_SESSION['feinduraSession']['websiteLanguage']) && strlen($_SESSION['feinduraSession']['websiteLanguage']) != 2)) {
        $this->language = GeneralFunctions::getBrowserLanguages($this->adminConfig['multiLanguageWebsite']['mainLanguage']);
        // make sure the language exist
        if(is_array($this->adminConfig['multiLanguageWebsite']['languages']) && in_array($this->language, $this->adminConfig['multiLanguageWebsite']['languages']))
          $this->language = $this->language;
        else
          $this->language = $this->adminConfig['multiLanguageWebsite']['mainLanguage'];
        $_SESSION['feinduraSession']['websiteLanguage'] = $this->language;
      } else
        $this->language = $_SESSION['feinduraSession']['websiteLanguage'];
    }
    $this->loadFrontendLanguageFile($this->language);

    // -> SET the $metaData PROPERTY
    $this->metaData['title']       = GeneralFunctions::getLocalized($this->websiteConfig['localized'],'title',$this->language);
    $this->metaData['publisher']   = GeneralFunctions::getLocalized($this->websiteConfig['localized'],'publisher',$this->language);
    $this->metaData['copyright']   = GeneralFunctions::getLocalized($this->websiteConfig['localized'],'copyright',$this->language);
    $this->metaData['keywords']    = GeneralFunctions::getLocalized($this->websiteConfig['localized'],'keywords',$this->language);
    $this->metaData['description'] = GeneralFunctions::getLocalized($this->websiteConfig['localized'],'description',$this->language);
  }
  
  // ****************************************************************************************************************
  // METHODs -------------------------------------------------------------------------------------------------
  // ****************************************************************************************************************
  
 /**
  * <b>Name</b>     setStartPage()<br>
  * 
  * Set a page ID to the {@link Feindura::$startPage} and {@link Feindura::$page} property.
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
  * <br>
  * <b>ChangeLog</b><br>
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
  * <b>Name</b>     setLanguage()<br>
  * 
  * Set the {@link FeinduraBase::$language} property and reloads the frontend language file.
  * 
  * <b>Note</b> The country code will NOT set to any <var>$_SESSION</var> variable, you have to take care of this yourself.
  * 
  * 
  * @param string $language a language country code like "en", "de", ...
  * 
  * @uses FeinduraBase::$language	the language country code like "en", "de", ... which will be returned
  * @uses FeinduraBase::$metaData to change it to the new language
  * 
  * @return string|false the {@link Feindura::$language language country code} or FALSE if the given $language parameter is no country code
  * 
  * @see FeinduraBase::__construct()
  * 
  * @access public
  * @version 1.0
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.0 initial release
  * 
  */
  public function setLanguage($language) {
    
    if(is_string($language) && strlen($language) == 2) {
      
      $this->language = $language;
      $this->loadFrontendLanguageFile($this->language);

      // CHANGE the $metaData property
      $this->metaData['title']       = GeneralFunctions::getLocalized($this->websiteConfig['localized'],'title',$this->language);
      $this->metaData['publisher']   = GeneralFunctions::getLocalized($this->websiteConfig['localized'],'publisher',$this->language);
      $this->metaData['copyright']   = GeneralFunctions::getLocalized($this->websiteConfig['localized'],'copyright',$this->language);
      $this->metaData['keywords']    = GeneralFunctions::getLocalized($this->websiteConfig['localized'],'keywords',$this->language);
      $this->metaData['description'] = GeneralFunctions::getLocalized($this->websiteConfig['localized'],'description',$this->language);

      return $this->language;
    } else
      return false;
  }  

 /**
  * <b>Name</b>     getLanguage()<br>
  * 
  * Returns the {@link Feindura::$language language country code} which was set in the {@link feinduraBase:__construct()}.
  * 
  * @uses FeinduraBase::$language	the language country code like "en", "de", ... which will be returned
  * 
  * @return string the {@link Feindura::$language language country code}
  * 
  * @see feindura()  
  * @see FeinduraBase::__construct()
  * 
  * @access public
  * @version 1.0
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.0 initial release
  * 
  */
  public function getLanguage() {
    return $this->language;
  }
  
  /**
  * <b>Name</b>     getLanguageFile()<br>
  * 
  * 
  * Check a specific directory for files which have a language code inside the filename (see <var>$filename</var> parameter). When a matching file is found it includes these and return it.
  * If no match could be found it try to find a file with the browser language code, if the <var>$currentLangCode</var> is empty it uses the {@link Feindura::$language} property.
  * 
  * Example of a language file
  * {@example languageFile.array.example.php}
  * 
  * <b>Used Constants</b><br>
  *    - <var>DOCUMENTROOT</var> the absolut path of the webserver
  * 
  * @param string|false $langPath         (optional) a absolut path to look for a language file which fit the $filename parameter or FALSE to use the "feindura-cms/library/languages" folder
  * @param string       $filename         (optional) the structure of the filename, which should be loaded. the "%lang%" will be replaced with the country code like "%lang%.backend.php" -> "en.backend.php"
  * @param string|false &$currentLangCode (optional) (Note: this variable will also be changed outside of this method) a variable with the current language code, if this is set it will be first try to load this language file, when it couldn't find a language file which fits the browsers language code.  
  * @param bool         $standardLang     (optional) a standard language for use if no match was found
  * 
  * 
  * @uses GeneralFunctions::loadLanguageFile() to load the right language file
  * @uses Feindura::$language                  to be loaded if no <var>$currentLangCode</var> parameter is given
  * 
  * @return array the loaded language file array or an empty array
  * 
  * @see GeneralFunctions::loadLanguageFile()
  * 
  * @access public
  * @version 1.0
  * <br>
  * <b>ChangeLog</b><br>
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
  * <b>Name</b>     createMetaTags()<br>
  * <b>Alias</b>    createMetaTag()<br>
  * 
  * Creates a string with basic HTML5 meta tags. See the example for a detailed list of the meta tags created.
  * 
  * <b>Note</b>: You have to call this method in the <head> tags of your website, to enable the frontend editing feature.<br>
  * <b>Note</b>: This method also adds the Feed tags.  
  * 
  * Example:
  * {@example createMetaTags.example.php}
  * 
  * @param string       $charset      (optional) the charset used in the website like "UTF-8", "iso-8859-1", ...
  * @param string|false $author       (optional) the author of the website
  * @param string|bool  $publisher    (optional) the publisher of the website, if TRUE it uses the publisher from the {@link FeinduraBase::$websiteConfig website-settings config}
  * @param string|bool  $copyright    (optional) the copyright owner of the website, if TRUE it uses the copyright from the {@link FeinduraBase::$websiteConfig website-settings config}
  * 
  * @uses Feindura::$page                         to load the page title of teh righte page
  * @uses Feindura::$category                     to load the page title of teh righte page
  * @uses FeinduraBase::$websiteConfig            for the website title, publisher, copyright, description and keywords
  * @uses GeneralFunctions::readPage()	          to load the page for the page title
  * @uses GeneralFunctions::setVisitorTimezone()  to try to set the timezone to the visitors one
  * 
  * @return string with all meta tags ready to display in a HTML page
  * 
  * @access public
  * @version 1.0.2
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.0.2 add {@link GeneralFunctions::setVisitorTimzone()} to set the local timezone
  *    - 1.0.1 changed readPage() from getCurrentPage() to use only the page property
  *    - 1.0 initial release
  * 
  */
  public function createMetaTags($charset = 'UTF-8', $author = false, $publisher = true, $copyright = true) {
      
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
      //$metaTags .= '  <meta http-equiv="content-type" content="'.$siteType.'; charset='.$charset.'"'.$tagEnding."\n";
      $metaTags .= '  <meta charset="'.$charset.'"'.$tagEnding."\n";

      // -> Set Visitors Local Timezone
      $metaTags .= GeneralFunctions::setVisitorTimzone();

      // -> get PAGE TITLE
      if($currentPage = GeneralFunctions::readPage($this->page,GeneralFunctions::getPageCategory($this->page)))
        $pageNameInTitle = strip_tags(GeneralFunctions::getLocalized($currentPage['localized'],'title',$this->language)).' | ';
      
      // -> add TITLE
      $metaTags .= '  <title>'.$pageNameInTitle.GeneralFunctions::getLocalized($this->websiteConfig['localized'],'title',$this->language).'</title>'."\n\n";
      
      // -> add BASE PATH if SPEAKING URLS are ON
      if($this->adminConfig['speakingUrl'])
        $metaTags .= '  <base href="'.$this->adminConfig['url'].GeneralFunctions::getDirname($this->adminConfig['websitePath']).'"'.$tagEnding."\n\n";
      
      // -> add other META TAGs
      $metaTags .= '  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"'.$tagEnding.' <!-- enable google chrome frame, if available -->'."\n\n";
      
      // -> add author
      if($author && is_string($author))
        $metaTags .= '  <meta name="author" content="'.$author.'"'.$tagEnding."\n";
        
      // -> add puplisher
      if($publisher) {
        $websiteConfigPublisher = GeneralFunctions::getLocalized($this->websiteConfig['localized'],'publisher',$this->language);
        if(is_string($publisher) && !is_bool($publisher))
          $metaTags .= '  <meta name="publisher" content="'.$publisher.'"'.$tagEnding."\n";
        elseif(!empty($websiteConfigPublisher))
          $metaTags .= '  <meta name="publisher" content="'.$websiteConfigPublisher.'"'.$tagEnding."\n";
      }

      // -> add copyright
      if($copyright) {
        $websiteConfigCopyright = GeneralFunctions::getLocalized($this->websiteConfig['localized'],'copyright',$this->language);
        if(is_string($copyright) && !is_bool($copyright))
          $metaTags .= '  <meta name="copyright" content="'.$copyright.'"'.$tagEnding."\n";
        elseif(!empty($websiteConfigCopyright))
          $metaTags .= '  <meta name="copyright" content="'.$websiteConfigCopyright.'"'.$tagEnding."\n";
      }
     
      // -> add keywords
      $websiteConfigKeywords =  GeneralFunctions::getLocalized($this->websiteConfig['localized'],'keywords',$this->language);
      $pageTags          =  GeneralFunctions::getLocalized($currentPage['localized'],'tags',$this->language);
      if(!empty($pageTags) && (($currentPage['category'] != 0 && $this->category['showTags']) || ($currentPage['category'] == 0 && $this->adminConfig['pages']['showTags'])))
        $metaTags .= '  <meta name="keywords" content="'.$pageTags.'"'.$tagEnding."\n";
      elseif(!empty($websiteConfigKeywords))
        $metaTags .= '  <meta name="keywords" content="'.$websiteConfigKeywords.'"'.$tagEnding."\n";

      // -> add description
      if(isset($currentPage)) {
        $websiteConfigDescription = GeneralFunctions::getLocalized($this->websiteConfig['localized'],'description',$this->language);
        $pageDescription = GeneralFunctions::getLocalized($currentPage['localized'],'description',$this->language);
        if($pageDescription)
          $metaTags .= '  <meta name="description" content="'.$pageDescription.'"'.$tagEnding."\n";
        elseif(!empty($websiteConfigDescription))
          $metaTags .= '  <meta name="description" content="'.$websiteConfigDescription.'"'.$tagEnding."\n";
      }

      
      $metaTags .= '  <meta name="generator" content="feindura - Flat File CMS '.VERSION.' build:'.BUILD.'"'.$tagEnding."\n";
      $metaTags .= "\n";
      
      // ->> add FEEDS
      $nonCategory[0] = array('id' => 0);
      $allCategories = $nonCategory + $this->categoryConfig;
      // -> for all categories
      foreach($allCategories as $category) {
        
        // check if feeds are is activated for that category
        if(($category['id'] != 0 && $category['public'] && $category['feeds']) ||
           ($category['id'] == 0 && $this->adminConfig['pages']['feeds'])) {

          // get languages
          if($this->adminConfig['multiLanguageWebsite']['active'])
            $feedLanguages = $this->adminConfig['multiLanguageWebsite']['languages'];
          else
            $feedLanguages = array(0 => 0);

          // category path
          if($category['id'] != 0)
            $categoryPath = $category['id'].'/';
          else
            $categoryPath = '';

          foreach ($feedLanguages as $langCode) {

            // filenames
            if(!empty($langCode))
              $addLanguageToFilename = '.'.$langCode;
            else
              $addLanguageToFilename = '';
            $atomLink = $this->adminConfig['url'].$this->adminConfig['basePath'].'pages/'.$categoryPath.'atom'.$addLanguageToFilename.'.xml';
            $rss2Link = $this->adminConfig['url'].$this->adminConfig['basePath'].'pages/'.$categoryPath.'rss2'.$addLanguageToFilename.'.xml';

            // title
            $websiteTitle = GeneralFunctions::getLocalized($this->websiteConfig['localized'],'title',$langCode);
            if($category['id'] == 0)
              $channelTitle = $websiteTitle;
            else
              $channelTitle = GeneralFunctions::getLocalized($category['localized'],'name',$langCode).' - '.$websiteTitle;

            if(!empty($langCode))
              $channelTitleLang = ', '.strtoupper($langCode).')';
            else
              $channelTitleLang = ')';
            
            $metaTags .= '  <link rel="alternate" type="application/atom+xml" title="'.$channelTitle.' (Atom'.$channelTitleLang.'" href="'.$atomLink.'"'.$tagEnding."\n";
            $metaTags .= '  <link rel="alternate" type="application/rss+xml" title="'.$channelTitle.' (RSS 2.0'.$channelTitleLang.'" href="'.$rss2Link.'"'.$tagEnding."\n";

          }
          
          $metaTags .= "\n";
        }
      }
      
      // -> add plugin-stylesheets
      // $plugins = GeneralFunctions::readFolder(dirname(__FILE__).'/../../plugins/');
      // if(is_array($plugins)) {
      //   foreach($plugins['folders'] as $pluginFolder) {
      //     $pluginName = basename($pluginFolder);
      //     $metaTags .= GeneralFunctions::createStyleTags($pluginFolder,false);
      //   }
      // }

      // ->> ENABLE FRONTEND EDITING
      // if user is logged into the CMS, add javascripts for implementing ckeditor      
      if($this->loggedIn && $this->adminConfig['user']['frontendEditing'] && PHP_VERSION >= REQUIREDPHPVERSION) {
        
        $metaTags .= "\n  <!--- add feindura frontend editing -->\n";
        // add frontend editing stylesheets
        $metaTags .= '  <link rel="stylesheet" type="text/css" href="'.$this->adminConfig['basePath'].'library/styles/shared.css"'.$tagEnding."\n";
        $metaTags .= '  <link rel="stylesheet" type="text/css" href="'.$this->adminConfig['basePath'].'library/styles/frontendEditing.css"'.$tagEnding."\n";    
        $metaTags .= '  <link rel="stylesheet" type="text/css" href="'.$this->adminConfig['basePath'].'library/thirdparty/MooRTE/Source/Assets/moorte.css"'.$tagEnding."\n";
        $metaTags .= '  <link rel="stylesheet" type="text/css" href="'.$this->adminConfig['basePath'].'library/thirdparty/MooRTE/feinduraSkin/rteFeinduraSkin.css"'.$tagEnding."\n";
        
        // -> move body padding, if frontend edititng is not deactivated
        if(!$_SESSION['feinduraSession']['login']['deactivateFrontendEditing'])
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
        $metaTags .= "\n".'  <script type="text/javascript" src="'.$this->adminConfig['basePath'].'library/thirdparty/javascripts/mootools-core-1.4.5.js"></script>'."\n";
        $metaTags .= '  <script type="text/javascript" src="'.$this->adminConfig['basePath'].'library/thirdparty/javascripts/mootools-more-1.4.0.1.js"></script>'."\n";   
        
        // add MooRTE
        $metaTags .= '  <script type="text/javascript" src="'.$this->adminConfig['basePath'].'library/thirdparty/MooRTE/Source/moorte.min.js"></script>'."\n";
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
  var feindura_currentBackendLocation =    '".$_SESSION['feinduraSession']['login']['currentBackendLocation']."';
  var feindura_deactivateFrontendEditing = '".$_SESSION['feinduraSession']['login']['deactivateFrontendEditing']."';
  var feindura_langFile = {
    ERRORWINDOW_TITLE:                    \"".$this->languageFile['errorWindow_h1']."\",
    ERROR_SAVE:                           \"".$this->languageFile['EDITOR_savepage_error_save']."\",
    ERROR_SETSTARTPAGE:                   \"".$this->languageFile['SORTABLEPAGELIST_setStartPage_error_save']."\",
    FUNCTIONS_STARTPAGE_SET:              \"".$this->languageFile['SORTABLEPAGELIST_functions_startPage_set']."\",
    FUNCTIONS_STARTPAGE:                  \"".$this->languageFile['SORTABLEPAGELIST_functions_startPage']."\",
    FUNCTIONS_EDITPAGE:                   \"".$this->languageFile['PAGEFUNCTIONS_TIP_EDITINBACKEND']."\",
    BUTTON_LOGOUT:                        \"".$this->languageFile['HEADER_BUTTON_LOGOUT']."\",
    BUTTON_GOTOBACKEND:                   \"".$this->languageFile['HEADER_TIP_GOTOBACKEND']."\",
    EDITPAGE_TIP_DISABLED:                \"".$this->languageFile['EDITPAGE_TIP_DISABLED']."\",
    TOPBAR_TIP_FRONTENDEDITING:           \"".$this->languageFile['TOPBAR_TIP_FRONTENDEDITING']."\",
    TOPBAR_TIP_DEACTIVATEFRONTENDEDITING: \"".$this->languageFile['TOPBAR_TIP_DEACTIVATEFRONTENDEDITING']."\"
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
  public function createMetaTag($charset = 'UTF-8', $author = false, $publisher = true, $copyright = true) {
    // call the right function
    return $this->createMetaTags($charset, $author, $publisher, $copyright);
  }
  
 /**
  * <b>Name</b> createHref()<br>
  * 
  * Generates a href attribute which links to a page.
  * Depending whether speaking URLs is in the administrator-settings activated, it generates a different href attribute.<br>
  * If cookies are deactivated it attaches the {@link FeinduraBase::$sessionId} on the end.
  * 
  * <b>Note</b>: If the <var>$id</var> parameter is empty or FALSE it uses the {@link Feindura::$page} property.
  * 
  *
  * Examples of the returned href string:
  *
  * Pages without category: 
  * <samp>'?page=1'</samp>
  * Pages with category:
  * <samp>'?category=1&page=1'</samp>
  * 
  * Speaking URL href for pages without category: 
  * <samp>'/page/page_title.html'</samp>
  * Speaking URL href for pages with category:
  * <samp>'/category/category_name/page_title.html'</samp>
  * 
  * 
  * @param int|string|array|bool $id  (optional) a page ID, array with page and category ID, or a string/array with "previous","next","first","last" or "random". If FALSE it uses the {@link Feindura::$page} property.<br><i>See Additional -> $id parameter example</i>
  * 
  * @uses FeinduraBase::getPropertyIdsByString()	to load the right page and category IDs depending on the $ids parameter
  * @uses GeneralFunctions::createHref()          call the right createHref functions in the GeneralFunctions class
  * @uses GeneralFunctions::getPageCategory()     to get the category of the page    
  * @uses FeinduraBase::language
  * 
  * @return string|false the generated href attribute, or FALSE if no page could be loaded
  * 
  * @example id.parameter.example.php $id parameter example
  * 
  * @see GeneralFunctions::createHref()
  * 
  * @access public
  * @version 1.0
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.0 initial release
  * 
  */
  public function createHref($id = false) {
    
    if($id = $this->getPropertyIdsByString($id)) {
      // loads the $pageContent array
      if(($pageContent = GeneralFunctions::readPage($id[0],$id[1])) !== false) {
          return GeneralFunctions::createHref($pageContent,$this->sessionId,$this->language);
      }
    }
    return false;    
  }
  
 /**
  * <b>Name</b> createLink()<br>
  * 
  * <b>This method uses the {@link Feindura::$linkLength $link...} and {@link $thumbnailAlign Feindura::$thumbnail...} properties.</b>
  * 
  * Creates a link from a page ID.
  * 
  * 
  * If the given <var>$page</var> parameter is a string with "previous" or "next",
  * it creates a link from the previous or the next page starting from the current page ID stored in the {@link Feindura::$page} property.
  * If there is no current, next or previous page in it returns FALSE.
  * 
  * <b>Note</b>: If the <var>$id</var> parameter is empty or FALSE it uses the {@link Feindura::$page} property.<br>
  * <b>Note</b>: It will add the {@link Feindura::$linkActiveClass} property as CSS class to the link, which is matching the current page.
  * 
  *
  * Example:
  * {@example createLink.example.php}
  * 
  * @param int|string|array|bool $id              (optional) a page ID, array with page and category ID, or a string/array with "previous","next","first","last" or "random". If FALSE it uses the {@link Feindura::$page} property.<br><i>See Additional -> $id parameter example</i>
  * @param string|bool           $linkText        (optional) a string with a linktext which the link will use, if TRUE it uses the page title of the page, if FALSE no linktext will be used
  * 
  * @uses Feindura::$linkLength
  * @uses Feindura::$linkId
  * @uses Feindura::$linkClass
  * @uses Feindura::$linkActiveClass
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
  * @uses FeinduraBase::getPropertyIdsByString()        to load the right page and category IDs depending on the $ids parameter
  * @uses FeinduraBase::createAttributes()              to create the attributes used by the link <a> tag
  * @uses FeinduraBase::createThumbnail()               to create the thumbnail for the link if the {@link $linkShowThumbnail} property is TRUE
  * @uses FeinduraBase::shortenText()                   to shorten the linktext if the {@link $linkLength} property is set
  * @uses GeneralFunctions::getPageCategory()           to get the category of the page
  * @uses GeneralFunctions::isPublicCategory()          to check whether the category is public
  * 
  * @return string|false the created link, ready to display in a HTML-page, or FALSE if the page doesn't exist or is not public
  * 
  * @example id.parameter.example.php $id parameter example
  * 
  * @see createMenu()
  * @see createMenuByTags()
  * @see createMenuByDate()
  * 
  * @access public
  * @version 1.0
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.0 initial release
  * 
  */
  public function createLink($id = false, $linkText = true) {    
        
    //echo 'PAGE: '.$id;
    
    // LOADS the right $pageContent array
    if($ids = $this->getPropertyIdsByString($id)) {
      
      // loads the $pageContent array
      if(($pageContent = GeneralFunctions::readPage($ids[0],$ids[1])) !== false) {
      
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
                                         $this->linkPageDateSeparator,                                      
                                         $this->linkCategorySeparator,
                                         false); // $allowFrontendEditing
          } elseif(is_string($linkText) &&
                   is_numeric($this->linkLength))   
            $linkText = $this->shortenText($linkText, $this->linkLength);
  	
          // -> sets the LINK
          // ----------------------------  
         
          // add HREF
          $linkAttributes = 'href="'.$this->createHref($pageContent,$this->sessionId,$this->language).'" title="'.str_replace('"','&quot;',strip_tags($linkText)).'"';

          // add link "active" class
          if(!empty($this->linkActiveClass) && $this->page == $pageContent['id'])
            $linkClass = $this->linkClass.' '.$this->linkActiveClass;
          else
            $linkClass = $this->linkClass;
  	      
  	      $linkClass = trim($linkClass);
  	      
  	      $linkAttributes .= $this->createAttributes($this->linkId, $linkClass, $this->linkAttributes);
          
          $linkStartTag = '<a '.$linkAttributes.">";
          $linkEndTag = "</a>";
          
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
  * <b>Name</b> createMenu()<br>
  * 
  * <b>This method uses the {@link Feindura::$linkLength $link...}, {@link Feindura::$menuId $menu...} and {@link Feindura::$thumbnailAlign $thumbnail...} properties.</b>
  * 
  * Creates a menu from category or page ID(s).
  * In case no page with the given category or page ID(s) exist it returns an empty array.
  * 
  * <b>Note</b>: The <var>$menuTag</var> parameter can be an "menu", "ul", "ol" or "table", it will then create the necessary child HTML-tags for this element.
  * If its any other tag name it just enclose the links with this HTML-tag.<br>
  * <b>Note</b>: If the <var>$ids</var> parameter is FALSE it uses the {@link Feindura::$page} or {@link Feindura::$category} property depending on the <var>$idType</var> parameter.<br>
  * <b>Note</b>: It will add the {@link Feindura::$linkActiveClass} property as CSS class to the link, which is matching the current page.
  *  
  * Example of the returned Array:
  * {@example createMenu.return.example.php}
  * 
  * Example Usage:
  * {@example createMenu.example.php}
  * 
  * @param string         $idType             (optional) the ID(s) type can be "cat", "category", "categories" or "pag", "page" or "pages"
  * @param int|array|bool $ids                (optional) the category or page ID(s), can be a number or an array with numbers (can also be a $pageContent array), if TRUE it loads all pages, if FALSE it uses the {@link Feindura::$page} or {@link Feindura::$category} property
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
  * @uses Feindura::$linkActiveClass
  * @uses Feindura::$linkAttributes
  * @uses Feindura::$linkBefore
  * @uses Feindura::$linkAfter
  * @uses Feindura::$linkBeforeText
  * @uses Feindura::$linkAfterText
  * @uses Feindura::$linkShowThumbnail
  * @uses Feindura::$linkShowThumbnailAfterText
  * @uses Feindura::$linkShowPageDate
  * @uses Feindura::$linkPageDateSeparator
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
  * @uses createHref()                            to create the href attribute
  * @uses createLink()                            to create a link from every $pageContent array  
  * @uses FeinduraBase::getPropertyIdsByType()    if the $ids parameter is FALSE it gets the property category or page ID, depending on the $idType parameter
  * @uses FeinduraBase::loadPagesByType()         to load the page $pageContent array(s) from the given ID(s)
  * @uses FeinduraBase::createAttributes()        to create the attributes used in the menu tag
  * @uses GeneralFunctions::sortPages()           to sort the $pageContent arrays by category
  * 
  * @return array the created menu in an array, ready to display in a HTML-page, or an empty array
  * 
  * @see createLink()
  * @see createMenuByTags()
  * @see createMenuByDate()
  * 
  * @access public
  * @version 1.1
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.1 changed returned array
  *    - 1.0 initial release
  * 
  */
  public function createMenu($idType = 'category', $ids = false, $menuTag = false, $linkText = true, $breakAfter = false, $sortByCategories = false) {
    
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
          $link['link']     = $pageLink;
          $link['href']     = $this->createHref($page);
          $link['id']       = $page['id'];
          $link['category'] = $page['category'];

          // create a title
          if($linkText === true) {
            $link['title'] = $this->createTitle($page,                         
                                                $this->linkLength,
                                                false, // $titleAsLink
                                                $this->linkShowPageDate,
                                                $this->linkShowCategory,
                                                $this->linkPageDateSeparator,                                      
                                                $this->linkCategorySeparator,
                                                false); // $allowFrontendEditing
          } elseif(is_string($linkText) &&
                   is_numeric($this->linkLength))   
            $link['title'] = $this->shortenText($linkText, $this->linkLength);

          $links[] = $link;
        }
      }
    } else 
      return array(false);

    return $this->generateMenu($links,$menuTag,$breakAfter);
  }
  
 /**
  * <b>Name</b>     createMenuByTags()<br>
  * <b>Alias</b>    createMenuByTag()<br>
  * 
  * <b>This method uses the {@link Feindura::$linkLength $link...}, {@link Feindura::$menuId $menu...} and {@link Feindura::$thumbnailAlign $thumbnail...} properties.</b>
  * 
  * Create a menu from category or page ID(s) with pages which have one or more of the tags from the given <var>$tags</var> parameter.
  * In case no page with the given category or page ID(s) or tags exist it returns an empty array.
  * 
  * 
  * <b>Note</b>: the tags will be compared case insensitive.<br>
  * <b>Note</b>: The <var>$menuTag</var> parameter can be an "menu", "ul", "ol" or "table", it will then create the necessary HTML-tags of this element.
  * If its any other tag name it just enclose the links with this HTML-tag.<br>
  * <b>Note</b>: If the <var>$ids</var> parameter is FALSE it uses the {@link Feindura::$page} or {@link Feindura::$category} property depending on the <var>$idType</var> parameter.<br>
  * <b>Note</b>: It will add the {@link Feindura::$linkActiveClass} property as CSS class to the link, which is matching the current page.
  * 
  * Example of the returned Array:
  * {@example createMenu.return.example.php}
  * 
  * Example:
  * {@example createMenuByTags.example.php}
  * 
  * @param string|array   $tags               a string with tags seperated by "," or ";" or an array with tags 
  * @param string         $idType             (optional) the ID(s) type can be "cat", "category", "categories" or "pag", "page" or "pages"
  * @param int|array|bool $ids                (optional) the category or page ID(s), can be a number or an array with numbers (can also be a $pageContent array), if TRUE it loads all pages, if FALSE it uses the {@link Feindura::$page} or {@link Feindura::$category} property
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
  * @uses Feindura::$linkActiveClass
  * @uses Feindura::$linkAttributes
  * @uses Feindura::$linkBefore
  * @uses Feindura::$linkAfter
  * @uses Feindura::$linkBeforeText
  * @uses Feindura::$linkAfterText
  * @uses Feindura::$linkShowThumbnail
  * @uses Feindura::$linkShowThumbnailAfterText
  * @uses Feindura::$linkShowPageDate
  * @uses Feindura::$linkPageDateSeparator
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
  * @uses FeinduraBase::checkPagesForTags()     to get only the pages which have one or more tags from the given $tags parameter
  * @uses Feindura::createMenu()                to create the menu from the pages load by {@link FeinduraBase::checkPagesForTags()}
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
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.0 initial release
  * 
  */
  public function createMenuByTags($tags, $idType = 'category', $ids = false, $menuTag = false, $linkText = true, $breakAfter = false, $sortByCategories = false) {
                                   
    $ids = $this->getPropertyIdsByType($idType,$ids);
    
    // check for the tags and CREATE A MENU
    if($ids = $this->checkPagesForTags($idType,$ids,$tags)) {
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
  * <b>Name</b>     createMenuByDate()<br>
  * <b>Alias</b>    createMenuByDates()<br>
  * 
  * <b>This method uses the {@link Feindura::$linkLength $link...}, {@link Feindura::$menuId $menu...} and {@link Feindura::$thumbnailAlign $thumbnail...} properties.</b>
  * 
  * Creates a menu from category or page ID(s) sorted by the page date,
  * with pages which have a page date and the page date fit in the time period
  * from the <var>$monthsInThePast</var> and the <var>$monthsInTheFuture</var> parameter starting from the date today.
  * 
  * The <var>$monthsInThePast</var> and <var>$monthsInTheFuture</var> parameters can also be a string with a (relative or specific) date, for more information see: {@link http://www.php.net/manual/de/datetime.formats.php}.
  * 
  * In case no page with the given category or page ID(s) or tags exist it returns an empty array.
  * 
  * <b>Note</b>: The <var>$menuTag</var> parameter can be an "menu", "ul", "ol" or "table", it will then create the necessary HTML-tags of this element.
  * If its any other tag name it just enclose the links with this HTML-tag.<br>
  * <b>Note</b>: If the <var>$ids</var> parameter is FALSE it uses the {@link Feindura::$page} or {@link Feindura::$category} property depending on the <var>$idType</var> parameter.<br>
  * <b>Note</b>: It will add the {@link Feindura::$linkActiveClass} property as CSS class to the link, which is matching the current page.
  * 
  * Example of the returned Array:
  * {@example createMenu.return.example.php}
  * 
  * Example:
  * {@example createMenuByDate.example.php}
  * 
  * @param string         $idType             (optional) the ID(s) type can be "cat", "category", "categories" or "pag", "page" or "pages"
  * @param int|array|bool $ids                (optional) the category or page ID(s), can be a number or an array with numbers (can also be a $pageContent array), if TRUE it loads all pages, if FALSE it uses the {@link Feindura::$page} or {@link Feindura::$category} property
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
  * @uses Feindura::$linkActiveClass
  * @uses Feindura::$linkAttributes
  * @uses Feindura::$linkBefore
  * @uses Feindura::$linkAfter
  * @uses Feindura::$linkBeforeText
  * @uses Feindura::$linkAfterText
  * @uses Feindura::$linkShowThumbnail
  * @uses Feindura::$linkShowThumbnailAfterText
  * @uses Feindura::$linkShowPageDate
  * @uses Feindura::$linkPageDateSeparator
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
  * @uses FeinduraBase::loadPagesByDate()   to load the pages which fit in the given time period parameters, sorted by the page date
  * @uses Feindura::createMenu()            to create the menu from the pages
  * 
  * @return array the created menu in an array, ready to display in a HTML-page, or an empty array
  * 
  * @see createLink()  
  * @see createMenu()
  * @see createMenuByTags()
  * 
  * @access public
  * @version 1.0
  * <br>
  * <b>ChangeLog</b><br>
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
  * <b>Name</b>     createMenuBySortFunction()<br>
  * <b>Alias</b>    createMenuBySort()<br>
  * <b>Alias</b>    createMenuBySortCallback()<br>
  * <b>Alias</b>    createMenuByCallback()<br>
  * 
  * <b>This method uses the {@link Feindura::$linkLength $link...}, {@link Feindura::$menuId $menu...} and {@link Feindura::$thumbnailAlign $thumbnail...} properties.</b>
  * 
  * Creates a menu from category or page ID(s) sorted by a custom sort function, passed in the first parameter <var>$sortCallback</var>.
  * 
  * In case no page with the given category or page ID(s) or tags exist it returns an empty array.
  * 
  * <b>Note</b>: The <var>$menuTag</var> parameter can be an "menu", "ul", "ol" or "table", it will then create the necessary HTML-tags of this element.
  * If its any other tag name it just enclose the links with this HTML-tag.<br>
  * <b>Note</b>: If the <var>$ids</var> parameter is FALSE it uses the {@link Feindura::$page} or {@link Feindura::$category} property depending on the <var>$idType</var> parameter.<br>
  * <b>Note</b>: It will add the {@link Feindura::$linkActiveClass} property as CSS class to the link, which is matching the current page.
  * 
  * Example of the returned Array:
  * {@example createMenu.return.example.php}
  * 
  * Example:
  * {@example createMenuBySortFunction.example.php}
  * 
  * @param string         $sortCallback        the name of the callback function to sort the menu (the callback function is a function which can be passed to usort())
  * @param string         $idType             (optional) the ID(s) type can be "cat", "category", "categories" or "pag", "page" or "pages"
  * @param int|array|bool $ids                (optional) the category or page ID(s), can be a number or an array with numbers (can also be a $pageContent array), if TRUE it loads all pages, if FALSE it uses the {@link Feindura::$page} or {@link Feindura::$category} property
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
  * @uses Feindura::$linkActiveClass
  * @uses Feindura::$linkAttributes
  * @uses Feindura::$linkBefore
  * @uses Feindura::$linkAfter
  * @uses Feindura::$linkBeforeText
  * @uses Feindura::$linkAfterText
  * @uses Feindura::$linkShowThumbnail
  * @uses Feindura::$linkShowThumbnailAfterText
  * @uses Feindura::$linkShowPageDate
  * @uses Feindura::$linkPageDateSeparator
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
  * @uses Feindura::createMenu()            to create the menu from the pages
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
  * <br>
  * <b>ChangeLog</b><br>
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
  * <b>Name</b> isSubCategory()<br>
  * 
  * Check if the given <var>$category</var> ID is a subcategory.
  * 
  * <b>Note</b>: If the <var>$category</var> parameter is FALSE or empty, it uses the current category (means the {@link Feindura::$category} property).<br>
  * 
  * @param int|string|bool $categoryId (optional) a category ID, or a string with "previous","next","first","last" or "random". If FALSE it uses the {@link Feindura::$category} property.
  * 
  * @uses Feindura::$category
  * @uses Feindura::$categoryConfig
  * 
  * 
  * @return bool whether or not the checked category is a subcategory
  * 
  * @access public
  * @version 1.0
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.0 initial release
  * 
  */
  public function isSubCategory($categoryId = false) {
    if($ids = $this->getPropertyIdsByString(array(false,$categoryId))) {
      $categoryId = $ids[1];    
      if($this->categoryConfig[$categoryId]['isSubCategory'])
        return true;     
    }

    return false;
  }


/**
  * <b>Name</b> isSubCategoryOf()<br>
  * 
  * Check if the given <var>$page</var> ID has the <var>$category</var> as a subcategory.<br>
  * 
  * <b>Note</b>: If the <var>$pageID</var> parameter is FALSE or empty, it uses the current page (means the {@link Feindura::$page} property).<br>
  * <b>Note</b>: If the <var>$categoryId</var> parameter is FALSE or empty, it uses the current page (means the {@link Feindura::$page} property).<br>
  *
  * @param int|string|bool $pageId      (optional) a page ID, or a string with "previous","next","first","last" or "random". If FALSE it uses the {@link Feindura::$page} property.
  * @param int|string|bool $categoryId  (optional) a category ID, or a string with "previous","next","first","last" or "random". If FALSE it uses the {@link Feindura::$category} property.
  * 
  * @uses Feindura::$category
  * @uses Feindura::$categoryConfig
  * 
  * 
  * @return bool whether or not the given page has the given category as subcategory
  * 
  * @access public
  * @version 1.0
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.0 initial release
  * 
  */
  public function isSubCategoryOf($pageId = false,$categoryId = false) {

    if($ids = $this->getPropertyIdsByString(array($pageId,false)))
      $pageId = $ids[0];

    if($ids = $this->getPropertyIdsByString(array(false,$categoryId)))
      $categoryId = $ids[1];

    $subCategoryPages = unserialize($this->categoryConfig[$categoryId]['isSubCategoryOf']);

    if(is_array($subCategoryPages) && array_key_exists($pageId, $subCategoryPages))
      return true;

    return false;
  }
  
 /**
  * <b>Name</b> createSubMenu()<br>
  * 
  * <b>This method uses the {@link Feindura::$linkLength $link...}, {@link Feindura::$menuId $menu...} and {@link Feindura::$thumbnailAlign $thumbnail...} properties.</b>
  * 
  * Creates a sub menu out of the subcategory of a page.<br>
  * In case no page with the given page ID exist, or it has no subcategory it returns an empty array.<br>
  * 
  * 
  * <b>Note</b>: The <var>$menuTag</var> parameter can be an "menu", "ul", "ol" or "table", it will then create the necessary child HTML-tags of this element.
  * If its any other tag name it just enclose the links with this HTML-tag.<br>
  * <b>Note</b>: If the <var>$id</var> parameter is FALSE or empty, it uses the current page (means the {@link Feindura::$page} property).<br>
  * <b>Note</b>: It will add the {@link Feindura::$linkActiveClass} property as CSS class to the link, which is matching the current page.
  *
  * Example of the returned Array:
  * {@example createMenu.return.example.php}
  * 
  * Example:
  * {@example createSubMenu.example.php}
  * 
  * @param int|string|array|bool $id          (optional) a page ID, array with page and category ID, or a string/array with "previous","next","first","last" or "random". If FALSE it uses the {@link Feindura::$page} property.<br><i>See Additional -> $id parameter example</i>
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
  * @uses Feindura::$linkActiveClass
  * @uses Feindura::$linkAttributes
  * @uses Feindura::$linkBefore
  * @uses Feindura::$linkAfter
  * @uses Feindura::$linkBeforeText
  * @uses Feindura::$linkAfterText
  * @uses Feindura::$linkShowThumbnail
  * @uses Feindura::$linkShowThumbnailAfterText
  * @uses Feindura::$linkShowPageDate
  * @uses Feindura::$linkPageDateSeparator
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
  * @uses Feindura::createMenu()    to create the menu
  * 
  * @return array the created sub menu in an array, ready to display in a HTML-page, or an empty array
  * 
  * @example id.parameter.example.php $id parameter example
  * 
  * @see createMenuFromCategory()
  * @see createLink()
  * @see createMenu()
  * 
  * @access public
  * @version 1.0
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.0 initial release
  * 
  */
  public function createSubMenu($id = false, $menuTag = false, $linkText = true, $breakAfter = false, $sortByCategories = false) {

    if($ids = $this->getPropertyIdsByString($id)) {
      // loads the $pageContent array
      if(($pageContent = GeneralFunctions::readPage($ids[0],$ids[1])) !== false) {
        // return subcategory
        if(is_numeric($pageContent['subCategory']) &&
           (($pageContent['category'] != 0 && $this->categoryConfig[$pageContent['category']]['showSubCategory']) ||
            ($pageContent['category'] == 0 && $this->adminConfig['pages']['showSubCategory'])))
          return $this->createMenu('category', $pageContent['subCategory'], $menuTag, $linkText, $breakAfter, $sortByCategories);
      }
    }
  
    return array();
  }

 /**
  * <b>Name</b> createMenuOfSubCategory()<br>
  * <b>Alias</b> createMenuFromSubCategory()<br>
  * <b>Alias</b> createSubMenuFromCategory()<br>
  * 
  * <b>This method uses the {@link Feindura::$linkLength $link...}, {@link Feindura::$menuId $menu...} and {@link Feindura::$thumbnailAlign $thumbnail...} properties.</b>
  * 
  * Creates a sub menu out of a subcategory.<br>
  * In case no category with the given page ID exist, or it is not a subcategory it returns an empty array.<br>
  * 
  * 
  * <b>Note</b>: The <var>$menuTag</var> parameter can be an "menu", "ul", "ol" or "table", it will then create the necessary child HTML-tags of this element.
  * If its any other tag name it just enclose the links with this HTML-tag.<br>
  * <b>Note</b>: If the <var>$id</var> parameter is FALSE or empty, it uses the current category (means the {@link Feindura::$category} property).<br>
  * <b>Note</b>: It will add the {@link Feindura::$linkActiveClass} property as CSS class to the link, which is matching the current page.
  *
  * 
  * You can use this function in conjunction with {@link Feindura::createSubMenu()} to display the submenu,
  * even if you're in a page of the subcategory.
  * <code>
  * <?php
  * 
  * // we use "false", because we use the current page and category.
  * // NOTE: we need the double (), otherwise it would use the assignment of the $subMenu variable as condition!
  * if(($subMenu = $feindura->createSubMenu(false,'ul')) || // will create the menu when inside the page which has a subcategory
  *    ($subMenu = $feindura->createMenuOfSubCategory(false,'ul'))) { // will create the menu when inside a page within a subcategory
  *
  *   foreach($subMenu as $item)
  *     echo $item['menuItem'];
  * }
  * 
  * ?>
  * </code>
  * 
  * Example of the returned Array:
  * {@example createMenu.return.example.php}
  * 
  * 
  * @param int|string|bool $categoryId         (optional) a category ID, or a string with "previous","next","first","last" or "random". If FALSE it uses the {@link Feindura::$category} property.
  * @param int|bool        $menuTag            (optional) the tag which is used to create the menu, can be an "menu", "ul", "ol", "table" or any other tag, if TRUE it uses "div" as a standard tag
  * @param string|bool     $linkText           (optional) a string with a linktext which all links will use, if TRUE it uses the page titles of the pages, if FALSE no linktext will be used
  * @param int|false       $breakAfter         (optional) if the $menuTag parameter is "table", this parameter defines after how many "td" tags a "tr" tag will follow, with any other tag this parameter has no effect
  * @param bool            $sortByCategories   (optional) if TRUE it sorts the given category or page ID(s) by category
  * 
  * @uses Feindura::$menuId
  * @uses Feindura::$menuClass
  * @uses Feindura::$menuAttributes
  * 
  * @uses Feindura::$linkLength
  * @uses Feindura::$linkId
  * @uses Feindura::$linkClass
  * @uses Feindura::$linkActiveClass
  * @uses Feindura::$linkAttributes
  * @uses Feindura::$linkBefore
  * @uses Feindura::$linkAfter
  * @uses Feindura::$linkBeforeText
  * @uses Feindura::$linkAfterText
  * @uses Feindura::$linkShowThumbnail
  * @uses Feindura::$linkShowThumbnailAfterText
  * @uses Feindura::$linkShowPageDate
  * @uses Feindura::$linkPageDateSeparator
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
  * @uses Feindura::createMenu()    to create the menu
  * 
  * @return array the created sub menu in an array, ready to display in a HTML-page, or an empty array
  * 
  * @example id.parameter.example.php $id parameter example
  * @example createSubMenu.example.php See the example of the createSubMenu() method
  * 
  * @see createSubMenu()
  * @see createLink()
  * @see createMenu()
  * 
  * @access public
  * @version 1.0
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.0 initial release
  * 
  */
  public function createMenuOfSubCategory($categoryId = false, $menuTag = false, $linkText = true, $breakAfter = false, $sortByCategories = false) {

    if($ids = $this->getPropertyIdsByString(array(false,$categoryId))) {
      $categoryId = $ids[1];
      if($this->isSubCategory($categoryId)) {
        // create subcategory
        if($categoryId && is_numeric($categoryId) &&
           (($pageContent['category'] != 0 && $this->categoryConfig[$categoryId]['showSubCategory']) ||
            ($pageContent['category'] == 0 && $this->adminConfig['pages']['showSubCategory'])))
          return $this->createMenu('category', $categoryId, $menuTag, $linkText, $breakAfter, $sortByCategories);
      }
    }
  
    return array();
  }
  /**
  * Alias of {@link createMenuOfSubCategory()}
  * @ignore
  */
  public function createMenuFromSubCategory($categoryId = false, $menuTag = false, $linkText = true, $breakAfter = false, $sortByCategories = false) {
    // call the right function
    return $this->createMenuOfSubCategory($categoryId, $linkText, $breakAfter, $sortByCategories);
  }
  /**
  * Alias of {@link createMenuOfSubCategory()}
  * @ignore
  */
  public function createSubMenuFromCategory($categoryId = false, $menuTag = false, $linkText = true, $breakAfter = false, $sortByCategories = false) {
    // call the right function
    return $this->createMenuOfSubCategory($categoryId, $linkText, $breakAfter, $sortByCategories);
  }
  
 /**
  * <b>Name</b> createLanguageMenu()<br>
  * 
  * <b>This method uses the {@link Feindura::$linkLength $link...}, {@link Feindura::$menuId $menu...} properties.</b>
  * 
  * Creates a menu as language selection for the multi language website feature.
  * In case that the multi language website feature is deactivated it returns an empty array.
  * 
  * <b>Note</b>: The <var>$menuTag</var> parameter can be an "menu", "ul", "ol" or "table", it will then create the necessary child HTML-tags for this element.
  * If its any other tag name it just enclose the links with this HTML-tag.<br>
  * <b>Note</b>: It will add the {@link Feindura::$linkActiveClass} property as CSS class to the link, which is matching the current language.
  * 
  * Example of the returned Array:
  * {@example createLanguageMenu.return.example.php}
  * 
  * Example Usage:
  * {@example createLanguageMenu.example.php}
  * 
  * @param int|bool       $menuTag            (optional) the tag which is used to create the menu, can be an "menu", "ul", "ol", "table" or any other tag, if TRUE it uses "div" as a standard tag
  * @param string|bool    $linkText           (optional) a string with a linktext which all links will use, if TRUE it uses the page titles of the pages, if FALSE no linktext will be used
  * @param int|false      $breakAfter         (optional) if the $menuTag parameter is "table", this parameter defines after how many "td" tags a "tr" tag will follow, with any other tag this parameter has no effect
  * 
  * @uses Feindura::$menuId
  * @uses Feindura::$menuClass
  * @uses Feindura::$menuAttributes
  * 
  * @uses Feindura::$linkLength
  * @uses Feindura::$linkId
  * @uses Feindura::$linkClass
  * @uses Feindura::$linkActiveClass
  * @uses Feindura::$linkAttributes
  * @uses Feindura::$linkBefore
  * @uses Feindura::$linkAfter
  * @uses Feindura::$linkBeforeText
  * @uses Feindura::$linkAfterText
  * 
  * @uses Feindura::$adminConfig
  * 
  * @uses FeinduraBase::createAttributes()        to create the attributes used in the menu tag
  * @USES FeinduraBase::generateMenu()            to generate the final menu
  * 
  * @return array the created menu in an array, ready to display in a HTML-page, or an empty array
  * 
  * 
  * @access public
  * @version 1.0
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.0 initial release
  * 
  */
  public function createLanguageMenu($menuTag = false, $linkText = true, $breakAfter = false) {
    
    // quit if multilanguage website is deactivated
    if(!$this->adminConfig['multiLanguageWebsite']['active'])
      return array();
    
    // -> STOREs the LINKs in an Array
    $links = array();
    if(!empty($this->adminConfig['multiLanguageWebsite']['languages'])) {
      // -> store original values
      $orgLinkShowThumbnail = $this->linkShowThumbnail;
      $orgLanguage = $this->language;
      $orgLinkActiveClass = $this->linkActiveClass;

      //make sure createLink() doesn't add a thumbnail
      $this->linkShowThumbnail = false;

      // create a link out of every language in the array
      foreach($this->adminConfig['multiLanguageWebsite']['languages'] as $langCode) {

        // set language name as link text
        if($linkText === true)
          $modLinkText = $this->languageNames[$langCode];
        else
          $modLinkText = $linkText;

        // remove the active class, so not all links will get it
        if($orgLanguage == $langCode)
          $this->linkActiveClass = $orgLinkActiveClass;
        else
          $this->linkActiveClass = false;

        // the next functions will use this language
        $this->language = $langCode;

        // creates the link
        if($languageLink = $this->createLink(false,$modLinkText)) {
          // adds the link to an array
          $link['link']     = $languageLink;
          $link['href']     = $this->createHref(false);
          $link['language'] = $langCode;
          $link['flag']     = GeneralFunctions::getFlagHref($langCode, false);
          $links[] = $link;
        }
      }

      // -> reset the old values
      $this->linkShowThumbnail = $orgLinkShowThumbnail;
      $this->language = $orgLanguage;
      $this->linkActiveClass = $orgLinkActiveClass;

    } else 
      return array(false);

    return $this->generateMenu($links,$menuTag,$breakAfter);
  }

 /**
  * <b>Name</b> createBreadCrumbsMenu()<br>
  * <b>Alias</b> createBreadCrumbMenu()<br> 
  * <b>Alias</b> createBreadCrumbs()<br> 
  * <b>Alias</b> createBreadCrumb()<br> 
  * 
  * <b>This method uses the {@link Feindura::$linkLength $link...}, {@link Feindura::$menuId $menu...} and {@link Feindura::$thumbnailAlign $thumbnail...} properties.</b>
  * 
  * Creates a breadcrumb navigation for the given page <var>$id</var> parameter.
  * In case no page with the given category or page ID(s) exist it returns an empty array.
  * 
  * <b>Note</b>: The <var>$menuTag</var> parameter can be an "menu", "ul", "ol" or "table", it will then create the necessary child HTML-tags for this element.
  * If its any other tag name it just enclose the links with this HTML-tag.<br>
  * 
  * Example of the returned Array:
  * {@example createMenu.return.example.php}
  * 
  * @param int|string|array|bool $id            (optional) a page ID, array with page and category ID, or a string/array with "previous","next","first","last" or "random". If FALSE it uses the {@link Feindura::$page} property.<br><i>See Additional -> $id parameter example</i>
  * @param string|false          $separator     (optional) a string which will be used as separator or FALSE to dont use a separator string
  * @param int|bool              $menuTag       (optional) the tag which is used to create the menu, can be an "menu", "ul", "ol", "table" or any other tag, if TRUE it uses "div" as a standard tag
  * @param int|false             $breakAfter    (optional) if the $menuTag parameter is "table", this parameter defines after how many "td" tags a "tr" tag will follow, with any other tag this parameter has no effect
  * 
  * @uses Feindura::$menuId
  * @uses Feindura::$menuClass
  * @uses Feindura::$menuAttributes
  * 
  * @uses Feindura::$linkLength
  * @uses Feindura::$linkId
  * @uses Feindura::$linkClass
  * @uses Feindura::$linkActiveClass
  * @uses Feindura::$linkAttributes
  * @uses Feindura::$linkBefore
  * @uses Feindura::$linkAfter
  * @uses Feindura::$linkBeforeText
  * @uses Feindura::$linkAfterText
  * @uses Feindura::$linkShowThumbnail
  * @uses Feindura::$linkShowThumbnailAfterText
  * @uses Feindura::$linkShowPageDate
  * @uses Feindura::$linkPageDateSeparator
  * @uses Feindura::$linkShowCategory               This is set to TRUE for all links, which are not in a sub category. You can change the separator between the category and the page name by setting the {@link Feindura::$linkCategorySeparator}
  * @uses Feindura::$linkCategorySeparator
  * 
  * @uses Feindura::$thumbnailAlign
  * @uses Feindura::$thumbnailId
  * @uses Feindura::$thumbnailClass
  * @uses Feindura::$thumbnailAttributes
  * @uses Feindura::$thumbnailBefore
  * @uses Feindura::$thumbnailAfter
  * 
  * @uses FeinduraBase::getPropertyIdsByString()       to load the right page and category IDs depending on the $ids parameter
  * @uses Feindura::readPage()
  * @uses GeneralFunctions::getParentPages()           to get the parent pages in an array
  * 
  * @return array the created breadcrumb navigation, or an empty array
  * 
  * 
  * @access public
  * @version 1.0
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.0 initial release
  * 
  */
  public function createBreadCrumbsMenu($id = false, $separator = ' > ', $menuTag = false, $breakAfter = false) {
    
    // var
    $links = array();
    $orgLinkActiveClass = $this->linkActiveClass;
    $this->linkActiveClass = false;

    if($ids = $this->getPropertyIdsByString($id)) {
      // unset($_SESSION['feinduraSession']['log']['visitedPagesOrder']);
      // print_r($_SESSION['feinduraSession']['log']['visitedPagesOrder']);

      // loads the $pageContent array
      if(($pageContent = GeneralFunctions::readPage($ids[0],$ids[1])) !== false) {

        // start page
        if($this->adminConfig['setStartPage'] && !empty($this->websiteConfig['startPage']) && $this->websiteConfig['startPage'] != $pageContent['id'] && ($startPage = GeneralFunctions::readPage($this->websiteConfig['startPage'],GeneralFunctions::getPageCategory($this->websiteConfig['startPage'])))) {
          $link['link']  = $this->createLink($startPage).$separator;
          $link['href']  = $this->createHref($startPage);
          $link['id']    = $startPage['id'];    
          $link['title'] = $this->createTitle($startPage,                        
                                              $this->linkLength,
                                              false, // $titleAsLink
                                              $this->linkShowPageDate,
                                              $this->linkShowCategory,
                                              $this->linkPageDateSeparator,                                      
                                              $this->linkCategorySeparator,
                                              false); // $allowFrontendEditing

          $links[] = $link;
          unset($link,$startPage);
        }

        // parent pages
        if($pageContent['category'] != 0 && $this->categoryConfig[$pageContent['category']]['isSubCategory'] && ($parentPages = GeneralFunctions::getParentPages($pageContent['category']))) {
          foreach ($parentPages as $parentPageContent) {
            $getLinkCategory = $this->linkShowCategory;

            // only show the category, if the parents page category is not a sub category
            if(!$this->categoryConfig[$parentPageContent['category']]['isSubCategory'])
              $this->linkShowCategory = true;

            $link['link']  = $this->createLink($parentPageContent).$separator;
            $link['href']  = $this->createHref($parentPageContent);
            $link['id']    = $parentPageContent['id'];
            $link['title'] = $this->createTitle($parentPageContent,               
                                                $this->linkLength,
                                                false, // $titleAsLink
                                                $this->linkShowPageDate,
                                                $this->linkShowCategory,
                                                $this->linkPageDateSeparator,                                      
                                                $this->linkCategorySeparator,
                                                false); // $allowFrontendEditing
            $this->linkShowCategory = $getLinkCategory;

            $links[] = $link;
            unset($link);
          }
        }

        // add pagelink
        $getLinkCategory = $this->linkShowCategory;
        // only show the category in the link, if the category is not a sub category
        if(!$this->categoryConfig[$pageContent['category']]['isSubCategory'])
          $this->linkShowCategory = true;

        $link['link']     = $this->createLink($pageContent);
        $link['href']     = $this->createHref($pageContent);
        $link['id']       = $pageContent['id'];
        $link['category'] = $pageContent['category'];   
        $link['title']    = $this->createTitle($pageContent,                         
                                              $this->linkLength,
                                              false, // $titleAsLink
                                              $this->linkShowPageDate,
                                              $this->linkShowCategory,
                                              $this->linkPageDateSeparator,                                      
                                              $this->linkCategorySeparator,
                                              false); // $allowFrontendEditing
        $this->linkShowCategory = $getLinkCategory;

        $links[] = $link;
        unset($link);

      }
    }

    // reset the linkActiveClass
    $this->linkActiveClass = $orgLinkActiveClass;

    // return the menu
    return $this->generateMenu($links,$menuTag,$breakAfter);
  }
  /**
  * Alias of {@link createBreadCrumbsMenu()}
  * @ignore
  */
  public function createBreadCrumbMenu($id = false, $separator = ' > ', $menuTag = false, $breakAfter = false) {
    // call the right function
    return $this->createBreadCrumbsMenu($id, $separator, $menuTag, $breakAfter);
  }
  /**
  * Alias of {@link createBreadCrumbsMenu()}
  * @ignore
  */
  public function createBreadCrumbs($id = false, $separator = ' > ', $menuTag = false, $breakAfter = false) {
    // call the right function
    return $this->createBreadCrumbsMenu($id, $separator, $menuTag, $breakAfter);
  }
  /**
  * Alias of {@link createBreadCrumbsMenu()}
  * @ignore
  */
  public function createBreadCrumb($id = false, $separator = ' > ', $menuTag = false, $breakAfter = false) {
    // call the right function
    return $this->createBreadCrumbsMenu($id, $separator, $menuTag, $breakAfter);
  }

 /**
  * <b>Name</b>     showTitle()<br>
  * <b>Alias</b>    getPageTitle()<br>
  * <b>Alias</b>    getTitle()<br>
  * 
  * <b>This method uses the {@link Feindura::$titleLength $title...} properties.</b>
  * 
  * Returns the title of a page.
  * This page title will be generated using the title properties.
  * 
  * <b>Note</b>: If the <var>$id</var> parameter is empty or FALSE it uses the {@link Feindura::$page} property.
  * 
  *
  * Example:
  * {@example showTitle.example.php}
  * 
  * @param int|string|array|bool $id    (optional) a page ID, array with page and category ID, or a string/array with "previous","next","first","last" or "random". If FALSE it uses the {@link Feindura::$page} property.<br><i>See Additional -> $id parameter example</i>
  * 
  * @uses Feindura::$titleLength
  * @uses Feindura::$titleAsLink
  * @uses Feindura::$titleShowPageDate
  * @uses Feindura::$titleShowCategory
  * @uses Feindura::$titleCategorySeparator
  * 
  * @uses FeinduraBase::getPropertyIdsByString()	     to load the right page and category IDs depending on the $ids parameter
  * @uses FeinduraBase::createTitle()                  to generate the page title with the right title properties
  * 
  * @uses GeneralFunctions::getPageCategory()          to get the category of the page
  * @uses GeneralFunctions::isPublicCategory()         to check whether the category is public  
  * 
  * @return string the generated page title, ready to display in a HTML-page, or FALSE if the page doesn't exist or is not public
  * 
  * @example id.parameter.example.php $id parameter example
  * 
  * @see FeinduraBase::createTitle()  
  * 
  * @access public
  * @version 1.0
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.0 initial release
  * 
  */
  public function showTitle($id = false) {    
   
    if($ids = $this->getPropertyIdsByString($id)) {
      
      // loads the $pageContent array
      if(($pageContent = GeneralFunctions::readPage($ids[0],$ids[1])) !== false) {
      
        // -> CHECK status
        if($pageContent['public'] &&  GeneralFunctions::isPublicCategory($pageContent['category']) !== false) {
        
          // shows the TITLE
          $title = $this->createTitle($pageContent,				                           
                                      $this->titleLength,
                                      $this->titleAsLink,                                    
                                      $this->titleShowPageDate,
                                      $this->titleShowCategory,
                                      $this->titlePageDateSeparator,
                                      $this->titleCategorySeparator);
          
          return $title;
          
        } else return false;
      } else return false; 
    } else return false;    
  }
 /**
  * Alias of {@link showTitle()}
  * @ignore
  */
  public function getTitle($id = false) {
    // call the right function
    return $this->showTitle($id);
  }
  /**
  * Alias of {@link showTitle()}
  * @ignore
  */
  public function getPageTitle($id = false) {
    // call the right function
    return $this->showTitle($id);
  } 
  
  
 /**
  * <b>Name</b>  showPage()<br>
  * <b>Alias</b> showPages()<br>  
  * 
  * <b>This method uses the {@link Feindura::$showErrors $error...}, {@link Feindura::$titleLength $title...} and {@link Feindura::$thumbnailAlign $thumbnail...} properties.</b>
  * 
  * Returns a page for displaying in a HTML-page.
  * This array will conatin all elements of the page, ready for displaying in a HTML-page.
  * 
  * In case the page doesn't exists or is not public and the {@link Feindura::$showErrors} property is TRUE, 
  * an error will be placed in the ['content'] part of the returned array,
  * otherwiese it returns an empty array.<br>
  * 
  * <b>Note</b>: If the <var>$id</var> parameter is empty or FALSE it uses the {@link Feindura::$page} property.
  * 
  *
  * Example of the returned array:
  * {@example generatePage.return.example.php}
  * 
  * Example usage:
  * {@example showPage.example.php}
  * 
  * @param int|string|array|bool $id           (optional) a page ID, array with page and category ID, or a string/array with "previous","next","first","last" or "random". If FALSE it uses the {@link Feindura::$page} property.<br><i>See Additional -> $id parameter example</i>
  * @param int|array|bool        $shortenText  (optional) number of the maximal text length displayed, adds a "more" link at the end or FALSE to not shorten. You can also pass an array: value 1: text length as int, value 2: text string for the link, or a link string.  e.g. array(23,false), array(23,'read more'), or array(23,'<a href="…"'>read more</a>')
  * @param bool|string           $useHtml      (optional) whether the content of the page has HTML-tags or not. It also accepts a string with allowed html tags.
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
  * @uses FeinduraBase::getPropertyIdsByString()	              to load the right page and category IDs depending on the $ids parameter
  * @uses FeinduraBase::generatePage()                          to generate the array with the page elements
  * 
  * @uses GeneralFunctions::getPageCategory()      to get the category of the page
  * 
  * @return array with the page elements, ready to display in a HTML-page, or FALSE if the page doesn't exist or is not public
  * 
  * @example id.parameter.example.php $id parameter example
  * 
  * @see getPageTitle()
  * @see FeinduraBase::generatePage()
  * 
  * @access public
  * @version 1.0
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.0 initial release
  * 
  */
  public function showPage($id = false, $shortenText = false, $useHtml = true) {    

    if($ids = $this->getPropertyIdsByString($id)) {
        
        $page = $ids[0];
        $category = $ids[1];
        
        // ->> load SINGLE PAGE
        // *******************
        if($generatedPage = $this->generatePage($page,$this->showErrors,$shortenText,$useHtml)) {          
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
  public function showPages($id = false, $shortenText = false, $useHtml = true) {
    // call the right function
    return $this->showPage($id, $shortenText, $useHtml);
  }

  /**
  * <b>Name</b>  hasPlugins()<br>
  * <b>Alias</b> hasPlugin()<br>
  * <b>Alias</b> isPlugins()<br>
  * <b>Alias</b> isPlugin()<br>
  *
  * Check whether the given plugin(s) are activated for the given page.
  *
  * <b>Note</b>: If the <var>$ids</var> parameter is empty or FALSE it uses the {@link Feindura::$page} property.
  * 
  * Example <var>$ids</var> parameters:
  * {@example id.parameter.example.php}
  *
  *
  * @param string|array|true     $plugins      (optional) the plugin name or an array with plugin names or TRUE to load all plugins
  * @param int|string|bool $ids          a page ID, or a string/array with "previous","next","first","last" or "random". If FALSE it uses the {@link Feindura::$page} property. (See examples) (can also be a $pageContent array)
  *
  * @uses Feindura::$page
  * @uses Feindura::showPlugins()											 to check for the activated plugins
  * @uses FeinduraBase::getPropertyIdsByString()	     to load the right page and category IDs depending on the $ids parameter
  * @uses FeinduraBase::generatePage()                 to generate the array with the page elements
  *
  * @uses GeneralFunctions::getPageCategory()          to get the category of the page
  *
  * @return bool whether the plugin(s) are activated or not
  *
  * @see getPageTitle()
  * @see Feindura::showPlugins()
  * @see FeinduraBase::generatePage()
  *
  * @access public
  * @version 1.0
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.0 initial release
  *
  */
  public function hasPlugins($plugins = true, $ids = false) {
  
    return $this->showPlugins($plugins,$ids,false);
  }
  /**
   * Alias of {@link hasPlugins()}
   * @ignore
   */
  public function hasPlugin($plugins = true, $ids = false) {
    // call the right function
    return $this->hasPlugins($plugins, $ids);
  }
  /**
  * Alias of {@link hasPlugins()}
  * @ignore
  */
  public function isPlugins($plugins = true, $ids = false) {
    // call the right function
    return $this->hasPlugins($plugins, $ids);
  }
  /**
  * Alias of {@link hasPlugins()}
  * @ignore
  */
  public function isPlugin($plugins = true, $ids = false) {
    // call the right function
    return $this->hasPlugins($plugins, $ids);
  }
 
 /**
  * <b>Name</b>  showPlugins()<br>
  * <b>Alias</b> showPlugin()<br>  
  * 
  * Returns the plugin(s) of a page ready for displaying in a HTML page.
  * It can return an array where each element contain the HTML of a plugin (only the activated ones),
  * or if the <var>$plugins</var> parameter is a string with a plugin name (the foldername of the plugin, inside "../feindura_folder/plugins/"), it returns only a string with the HTML of this plugin.   
  * 
  * <b>Note</b>: If the <var>$id</var> parameter is empty or FALSE it uses the {@link Feindura::$page} property.
  * 
  * 
  * Example of the returned array:
  * {@example showPlugins.array.example.php}
  * 
  * Example usage:
  * {@example showPlugins.example.php}
  * 
  * @param string|array|true      $plugins      (optional) the plugin name or an array with plugin names or TRUE to load all plugins
  * @param int|string|array|bool  $id           (optional) a page ID, array with page and category ID, or a string/array with "previous","next","first","last" or "random". If FALSE it uses the {@link Feindura::$page} property.<br><i>See Additional -> $id parameter example</i>
  * @param bool									  $returnPlugin (optional) whether the plugin is returned, or only a boolean to check if the plugin is available for that page (used by {@link Feindura::hasPlugins()})
  * 
  * @uses Feindura::$page
  * 
  * @uses FeinduraBase::getPropertyIdsByString()	     to load the right page and category IDs depending on the $ids parameter
  * @uses FeinduraBase::generatePage()                 to generate the array with the page elements
  * 
  * @uses GeneralFunctions::getPageCategory()          to get the category of the page    
  * 
  * @return array|string|false with the plugin(s) HTML-code, ready to display in a HTML-page, or an empty Array, or FALSE if the plugin(s) or page doesn't exist or the page is not public
  * 
  * @see getPageTitle()
  * @see FeinduraBase::generatePage()
  * 
  * @example id.parameter.example.php $id parameter example
  * 
  * @access public
  * @version 1.0
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.0 initial release
  * 
  */
 public function showPlugins($plugins = true, $id = false, $returnPlugin = true) {    
    
    // var
    if(is_string($plugins) && $plugins != 'true' && $plugins != 'false')
      $singlePlugin = true;
    else
      $singlePlugin = false;
    if(is_string($plugins) && $plugins != 'true' && $plugins != 'false')
      $pluginsReturn = false;
    else
      $pluginsReturn = array();
    if(!is_array($plugins) && !is_bool($plugins))
      $plugins = array($plugins);
     
    if($ids = $this->getPropertyIdsByString($id)) {

      // LOAD the $pageContent array
      if(($pageContent = GeneralFunctions::readPage($ids[0],$ids[1])) !== false) {
        
        // ->> LOAD the PLUGINS and return them 
        if(($pageContent['category'] == 0 || $this->categoryConfig[$pageContent['category']]['public']) && $pageContent['public']) {
          if(is_array($pageContent['plugins'])) {
            // get the activated plugins
            if($pageContent['category'] === 0)
              $activatedPlugins = unserialize($this->adminConfig['pages']['plugins']);
            else
              $activatedPlugins = unserialize($this->categoryConfig[$pageContent['category']]['plugins']);
          
            foreach($pageContent['plugins'] as $pluginName => $plugin) {

              // go through all plugins and load the required ones
              if((is_bool($plugins) || in_array($pluginName,$plugins)) && // is in the requested plugins array
                 is_array($activatedPlugins) && in_array($pluginName,$activatedPlugins) && // activated in the adminConfig or categoryConfig
                 $plugin['active'] // activated in the page                 
                 ) {
                
                if($returnPlugin) {
                
                  // create plugin config
                  $pluginConfig = $plugin;
                  unset($pluginConfig['active']); // remove the active value from the plugin config
  
                  // -> include the plugin
            		  if($singlePlugin)
            		    return include(dirname(__FILE__).'/../../plugins/'.$pluginName.'/include.php');
            		  else  
                    $pluginsReturn[$pluginName] = include(dirname(__FILE__).'/../../plugins/'.$pluginName.'/include.php');
                
                } else
                $pluginsReturn = true;
              }
            }
          }         
        }            
      }       
    }
    
    if($returnPlugin)    
      return $pluginsReturn;
    else {
      if($pluginsReturn)
        return true;
      else
        return false;
    }
  }
  /**
  * Alias of {@link showPlugins()}
  * @ignore
  */
  public function showPlugin($plugins = true, $id = false, $returnPlugin = true) {
    // call the right function
    return $this->showPlugins($plugins, $id, $returnPlugin);
  }

   /**
  * <b>Name</b> hasTags()<br>
  * 
  * Load the <var>$pagesMetaData</var> array of pages which have one or more tags from the given <var>$tags</var> parameter.<br>
  * Can be used to count pages with specific tags, like in the following example.
  * <code>
  * <?php
  * 
  * include('cms/feindura.include.php');
  * $feindura = new Feindura();
  * 
  * echo $feindura->hasTags('example tag', 'category', 1);
  * 
  * // RESULT
  * 3 (means 3 pages in category 1 have this tag)
  * 
  * ?>
  * </code>
  * 
  * 
  * <b>Note</b>: the tags will be compared case insensitive.
  * 
  * @param string|array   $tags             an string (seperated by ",") or an array with tags to compare
  * @param string         $idType           the ID(s) type can be "cat", "category", "categories" or "pag", "page" or "pages"
  * @param int|array|bool $ids              the category or page ID(s), can be a number or an array with numbers, if TRUE it checks all pages tags
  * 
  * @uses FeinduraBase::checkPagesForTags() to check pages for tags
  * 
  * @return array|false an array of $pageContent arrays or FALSE if no $pageContent array has any of the given tags
  * 
  * @access public
  * @version 1.0
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.0 initial release
  * 
  */   
  public function hasTags($tags, $idType, $ids) {
    return $this->checkPagesForTags($idType, $ids, $tags, false);
  }
  /**
  * Alias of {@link hasTags()}
  * @ignore
  */
  public function hasTag($tags, $idType, $ids) {
    // call the right function
    return $this->hasTags($tags, $idType, $ids);
  }

 /**
  * <b>Name</b>     listPages()<br>
  * <b>Alias</b>    listPage()<br>
  * 
  * <b>This method uses the {@link Feindura::$showErrors $error...}, {@link Feindura::$titleLength $title...} and {@link Feindura::$thumbnailAlign $thumbnail...} properties.</b>
  * 
  * List pages by given category or page ID(s).
  * 
  * 
  * Returns an array with multiple pages for displaying in a HTML-page.
  * 
  * In case no page with the given category or page ID(s) exist it returns an empty array.
  * 
  * <b>Note</b>: If the <var>$ids</var> parameter is FALSE it uses the {@link Feindura::$page} or {@link Feindura::$category} property depending on the <var>$idType</var> parameter.
  * 
  * Example of the returned array:
  * {@example listPages.return.example.php}
  * 
  * Example usage:
  * {@example listPages.example.php}
  * 
  * @param string         $idType             (optional) the ID(s) type can be "cat", "category", "categories" or "pag", "page" or "pages"
  * @param int|array|bool $ids                (optional) the category or page ID(s), can be a number or an array with numbers (can also be a $pageContent array), if TRUE it loads all pages, if FALSE it uses the {@link Feindura::$page} or {@link Feindura::$category} property
  * @param int|array|bool $shortenText        (optional) number of the maximal text length displayed, adds a "more" link at the end or FALSE to not shorten. You can also pass an array: value 1: text length as int, value 2: text string for the link, or a link string.  e.g. array(23,false), array(23,'read more'), or array(23,'<a href="…"'>read more</a>')
  * @param bool|string    $useHtml            (optional) whether the content of the page has HTML-tags or not. It also accepts a string with allowed html tags.
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
  * @return array array with page arrays,containing content and title etc., ready to display in a HTML-page, or an empty array
  * 
  * @see showPage()
  * @see listPagesByTags()
  * @see listPagesByDate() 
  * 
  * @access public
  * @version 1.0
  * <br>
  * <b>ChangeLog</b><br>
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
  * <b>Name</b>     listPagesByTags()<br>
  * <b>Alias</b>    listPagesByTag(), listPageByTags(), listPageByTag()<br>
  * 
  * <b>This method uses the {@link Feindura::$showErrors $error...}, {@link Feindura::$titleLength $title...} and {@link Feindura::$thumbnailAlign $thumbnail...} properties.</b>
  * 
  * List pages by given category or page ID(s), which have one or more of the tags from the given <var>$tags</var> parameter.
  * 
  * Returns an array with multiple pages for displaying in a HTML-page. 
  * In case no page with the given category or page ID(s) exist it returns an empty array.
  * 
  * <b>Note</b>: The tags will be compared case insensitive.<br>
  * <b>Note</b>: If the <var>$ids</var> parameter is FALSE it uses the {@link Feindura::$page} or {@link Feindura::$category} property depending on the <var>$idType</var> parameter.
  * 
  * Example usage:
  * {@example listPagesByTags.example.php}
  * 
  * @param string|array   $tags               a string with tags seperated by "," or ";" or an array with tags    
  * @param string         $idType             (optional) the ID(s) type can be "cat", "category", "categories" or "pag", "page" or "pages"
  * @param int|array|bool $ids                (optional) the category or page ID(s), can be a number or an array with numbers (can also be a $pageContent array), if TRUE it loads all pages, if FALSE it uses the {@link Feindura::$page} or {@link Feindura::$category} property
  * @param int|array|bool $shortenText        (optional) number of the maximal text length displayed, adds a "more" link at the end or FALSE to not shorten. You can also pass an array: value 1: text length as int, value 2: text string for the link, or a link string.  e.g. array(23,false), array(23,'read more'), or array(23,'<a href="…"'>read more</a>')
  * @param bool|string    $useHtml            (optional) whether the content of the page has HTML-tags or not. It also accepts a string with allowed html tags.
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
  * @uses FeinduraBase::checkPagesForTags()       to get only the pages which have one or more tags from the given $tags parameter
  * @uses listPages()                         to list the pages  
  * 
  * @return array array with page arrays,containing content and title etc., ready to display in a HTML-page, or an empty array
  * 
  * @see showPage()
  * @see listPages()
  * @see listPagesByDate()
  * 
  * @access public
  * @version 1.0
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.0 initial release
  * 
  */
  public function listPagesByTags($tags, $idType = 'category', $ids = false, $shortenText = false, $useHtml = true, $sortByCategories = false) {
     
    $ids = $this->getPropertyIdsByType($idType,$ids);
    
    // check for the tags and LIST the PAGES
    if($ids = $this->checkPagesForTags($idType,$ids,$tags)) {      
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
  * <b>Name</b>     listPagesByDate()<br>
  * <b>Alias</b>    listPagesByDates(), listPageByDate(), listPageByDates()<br>
  * 
  * <b>This method uses the {@link Feindura::$showErrors $error...}, {@link Feindura::$titleLength $title...} and {@link Feindura::$thumbnailAlign $thumbnail...} properties.</b>
  * 
  * List pages by given category or page ID(s) sorted by the page date which have a page date and it fit in the time period
  * from the <var>$monthsInThePast</var> and the <var>$monthsInTheFuture</var> parameter starting from the date today.
  * 
  * The <var>$monthsInThePast</var> and <var>$monthsInTheFuture</var> parameters can also be a string with a (relative or specific) date, for more information see: {@link http://www.php.net/manual/de/datetime.formats.php}.
  * 
  * Returns an array with multiple pages for displaying in a HTML-page. 
  * In case no page with the given category or page ID(s) exist it returns an empty array.
  * 
  * <b>Note</b>: If the <var>$ids</var> parameter is FALSE it uses the {@link Feindura::$page} or {@link Feindura::$category} property depending on the <var>$idType</var> parameter.
  * 
  * Example usage:
  * {@example listPagesByTags.example.php}
  * 
  * @param string          $idType                (optional) the ID(s) type can be "cat", "category", "categories" or "pag", "page" or "pages"
  * @param int|array|bool  $ids                   (optional) the category or page ID(s), can be a number or an array with numbers (can also be a $pageContent array), if TRUE it loads all pages, if FALSE it uses the {@link Feindura::$page} or {@link Feindura::$category} property
  * @param int|bool|string $monthsInThePast       (optional) number of months before today, if TRUE it show all pages in the past, if FALSE it loads only pages starting from today. it can also be a string with a (relative or specific) date format, for more details see: {@link http://www.php.net/manual/de/datetime.formats.php}
  * @param int|bool|string $monthsInTheFuture     (optional) number of months after today, if TRUE it show all pages in the future, if FALSE it loads only pages until today. it can also be a string with a (relative or specific) date format, for more details see: {@link http://www.php.net/manual/de/datetime.formats.php}
  * @param int|array|bool  $shortenText           (optional) number of the maximal text length displayed, adds a "more" link at the end or FALSE to not shorten. You can also pass an array: value 1: text length as int, value 2: text string for the link, or a link string.  e.g. array(23,false), array(23,'read more'), or array(23,'<a href="…"'>read more</a>')
  * @param bool|string     $useHtml               (optional) whether the content of the page has HTML-tags or not. It also accepts a string with allowed html tags.
  * @param bool            $sortByCategories      (optional) if TRUE it sorts the given category or page ID(s) by category
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
  * @return array array with page arrays,containing content and title etc., ready to display in a HTML-page, or an empty array
  * 
  * @see showPage()
  * @see listPages()
  * @see listPagesByTags()
  * 
  * @access public
  * @version 1.0
  * <br>
  * <b>ChangeLog</b><br>
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
  * <b>Name</b>     listPagesBySortFunction()<br>
  * <b>Alias</b>    listPagesBySort()<br>
  * <b>Alias</b>    listPagesBySortCallback()<br>
  * <b>Alias</b>    listPagesByCallback()<br>
  * 
  * <b>This method uses the {@link $showErrors $error...}, {@link $titleLength $title...} and {@link Feindura::$thumbnailAlign $thumbnail...} properties.</b>
  * 
  * List pages from category or page ID(s) sorted by a custom sort function, passed in the first parameter <var>$sortCallback</var>.
  * The custom sort function will be executed on the plain <var>$pageContent</var> array returned by the {@link FeinduraBase::loadPagesByType()} method.
  * 
  * 
  * Returns an array with multiple pages for displaying in a HTML-page.
  * 
  * In case no page with the given category or page ID(s) exist it returns an empty array.
  * 
  * <b>Note</b>: If the <var>$ids</var> parameter is FALSE it uses the {@link Feindura::$page} or {@link Feindura::$category} property depending on the <var>$idType</var> parameter.
  * 
  * Example of the returned array:
  * {@example listPages.return.example.php}
  * 
  * Example usage:
  * {@example listPagesBySortFunction.example.php}
  * 
  * @param string         $sortCallback       the name of the callback function to sort the pages (the callback function is a function which can be passed to usort())
  * @param string         $idType             (optional) the ID(s) type can be "cat", "category", "categories" or "pag", "page" or "pages"
  * @param int|array|bool $ids                (optional) the category or page ID(s), can be a number or an array with numbers (can also be a $pageContent array), if TRUE it loads all pages, if FALSE it uses the {@link Feindura::$page} or {@link Feindura::$category} property
  * @param int|array|bool $shortenText        (optional) number of the maximal text length displayed, adds a "more" link at the end or FALSE to not shorten. You can also pass an array: value 1: text length as int, value 2: text string for the link, or a link string.  e.g. array(23,false), array(23,'read more'), or array(23,'<a href="…"'>read more</a>')
  * @param bool|string    $useHtml            (optional) whether the content of the page has HTML-tags or not. It also accepts a string with allowed html tags.
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
  * @return array array with page arrays,containing content and title etc., ready to display in a HTML-page, or an empty array
  * 
  * @see showPage()
  * @see listPages()
  * @see listPagesByTags()
  * @see listPagesByDate()
  * 
  * @access public
  * @version 1.0
  * <br>
  * <b>ChangeLog</b><br>
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

 /**
  * <b>Name</b> addPluginStylesheets()<br>
  * 
  * Goes through a folder recursive and gets the css files. 
  * It then tries to add these as <link..> tags inside the <head> tag, using javascript.
  * If no javascript is activated it will just place the <link...> tags to the current position.
  * 
  * 
  * @param string $folder the absolute path of the plugin folder to look for stylesheet files
  * 
  * @uses GeneralFunctions::createStyleTags() to get the stylesheet <link..> tags
  * 
  * @return string|false the HTML <link> tags plus corresponding javascript or FALSE if no stylesheet-file was found
  * 
  * @static 
  * @version 1.0
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.0 initial release
  * 
  */
  public function addPluginStylesheets($folder) {
    
    //var
    $return = false;

    // ->> goes trough all folder and subfolders and gets the stylesheets
    $stylesheets = trim(GeneralFunctions::createStyleTags($folder,false));

    // js adding to the head
    $return .= '<!-- Add the plugin stylesheets to the <head> tag -->
<script type="text/javascript">
/* <![CDATA[ */
var head = document.getElementsByTagName(\'head\')[0];
head.innerHTML = head.innerHTML + \''.str_replace("\n", '', $stylesheets).'\';
/* ]]> */
</script>';

    // non js adding
    $return .= '
<noscript>
  '.$stylesheets.'
</noscript>

';
    return $return;
  }
}
?>