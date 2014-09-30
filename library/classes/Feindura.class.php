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
*    - 2.0 add {@link Feindura::createSubMenuOfPage()}, {@link Feindura::isSubCategory()}, {@link Feindura::isSubCategoryOf()}, {@link Feindura::createMenuOfSubCategory()}, {@link Feindura::createLanguageMenu()}, {@link Feindura::createBreadCrumbsMenu()}, {@link Feindura::hasTags()}, {@link Feindura::getLocalized()}, {@link Feindura::listSubPages()}, {@link Feindura::listSubCategory()}
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
  * Contains the start category ID
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
  * Contains a class, which will be add to any <a ...> tag
  * of any link created by {@link Feindura::createLink()} or {@link Feindura::createMenu()}.
  *
  *
  * You can also add multiple classes, just separate the classes with spaces.
  * <samp>
  * 'class1 class2'
  * </samp>
  *
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
  * when it is matching the currently selected page. When using the {@link Feindura::createMenu()} method,
  * this class will also be add to the wrapping element of the link, like <li> or <td>.
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
  * If this property is TRUE, it overwrites the "show in menu" setting of all pages, so that all pages are visible in the following menus.
  *
  * @var bool
  * @access public
  *
  * @see Feindura::createMenu()
  * @example createMenu.example.php
  *
  */
  public $menuShowAllPages = false;

 /**
  * Contains an id-Attribute which will be add to the menu tag created by any {@link Feindura::createMenu()} method.
  *
  * <b>Notice</b>: You can also add the ID, classes and attributes directly to a specific menu using the <var>$menuTag</var> parameter. See the <var>$menuTag</var> parameter of the {@link Feindura::createMenu()} method for details.
  * <b>Notice</b>: This id-Attribute will only be add, if the <var>$menuTag</var> parameter in the {@link Feindura::createMenu()} method is not FALSE.<br>
  * <b>Notice</b>: You can only set one specific id-Attribute to elements in a HTML page.
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
  * Contains a class which will be add to the menu tag created by any {@link Feindura::createMenu()} method.
  *
  * You can also add multiple classes, just separate the classes with spaces.
  * <samp>
  * 'class1 class2'
  * </samp>
  *
  * <b>Notice</b>: You can also add the ID, classes and attributes directly to a specific menu using the <var>$menuTag</var> parameter. See the <var>$menuTag</var> parameter of the {@link Feindura::createMenu()} method for details.
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
  * Contains string with attributes which will be add to the menu tag created by any {@link Feindura::createMenu()} method.
  *
  *
  * <b>Notice</b>: You can also add the ID, classes and attributes directly to a specific menu using the <var>$menuTag</var> parameter. See the <var>$menuTag</var> parameter of the {@link Feindura::createMenu()} method for details.
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
  * If TRUE the page thumbnail will be wrapped with a link to the page.
  *
  * @var bool
  * @access public
  *
  * @see Feindura::showPage()
  * @see FeinduraBase::createThumbnail()
  *
  */
  public $thumbnailAsLink = false;

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
  * Contains a class which will be add the thumbnail <img> tag.
  *
  *
  * You can also add multiple classes, just separate the classes with spaces.
  * <samp>
  * 'class1 class2'
  * </samp>
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
  * The tag which will be used to wrap the error message. E.g. if a pages is deactivated or doesnt exist.
  *
  * <b>Note</b>: You can add simple Zen Code selectors to this string to add id, classes and attributes. E.g. "div#myId.myClass1.myClass2[attribute1=value][attribute2=value]" converts to <div id="myId" class="myClass1 myClass2" attribute1="value" attribute2="value">
  *
  * Example:
  * <code>
  * <?php
  *
  * // assume we have already created an instance of feindura
  * $feindura->errorTag = 'div.errorMessage';
  *
  * ?>
  *
  * <!-- Will look like this if an error occours -->
  *
  * <div class="errorMessage">The requested page is currently not available.</div>
  *
  * </code>
  *
  * @var string|false If no tag should be add, set it to FALSE.
  * @access public
  *
  * @see Feindura::showPage()
  * @see FeinduraBase::generatePage()
  * @example showPage.example.php
  *
  */
  public $errorTag = '';                // [False or String]      -> the message TAG which is used when creating a message (STANDARD Tag: SPAN; if there is a class and/or id and no TAG is set)


 /**
  * Tells the {@link Feindura::endCache()} method to write the a cache file or not.
  *
  *
  * @var array
  * @access protected
  *
  * @see Feindura::startCache()
  * @see Feindura::endCache()
  *
  */
  protected $cachedScriptCache = false;


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
  * @uses FeinduraBase::__construct()             the constructor of the parent class to load all necessary properties
  * @uses FeinduraBase::setCurrentCategoryId()  to set the fetched category ID from the $_GET variable to the {@link Feindura::$category} property
  * @uses FeinduraBase::setCurrentPageId()      to set the fetched page ID from the $_GET variable to the {@link Feindura::$page} property
  *
  * @return void
  *
  * @see FeinduraBase::__construct()
  *
  * @access public
  * @version 1.3
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.3 add set timezone from the backend as default timezone
  *    - 1.2 changed the name of $_SESSION['feinduraSession']['websiteLanguage'] to $_SESSION['feinduraSession']['language'], so it differs from the backend version
  *    - 1.1 fixed language detection
  *    - 1.0 initial release
  *
  */
  public function __construct($language = false) {

    // RUN the FeinduraBase constructor
    parent::__construct($language);


    // get LOGOUT?
    if(isset($_GET['feinduraLogout']))
      unset($_SESSION['feinduraSession']['login']);

    // CHECK if logged in
    if($_SESSION['feinduraSession']['login']['loggedIn'] === true && $_SESSION['feinduraSession']['login']['host'] === HOST)
      $this->loggedIn = true;
    else
      $this->loggedIn = false;

    // -> CHECKS if cookies, means the cookie in the feindura.include.php file was set
    if(!isset($_COOKIE['feindura_checkCookies']) || $_COOKIE['feindura_checkCookies'] != 'true') {
      $this->sessionId = htmlspecialchars(session_name().'='.session_id()); //SID
    }


    // SET the CURRENT GET vars in the PROPERTIES
    // ********************************************
    $this->setCurrentCategoryId(true);       // get $_GET['category']
    $this->setCurrentPageId(true);           // get $_GET['page'] <- set the $this->websiteConfig['startPage'] if there is no $_GET['page'] variable
    // set category automatically, if it couldn't be retrieved
    if($this->category == null) $this->category = GeneralFunctions::getPageCategory($this->page);


    // SAVE the WEBSITE STATISTICS
    // ***************************
    StatisticFunctions::saveWebsiteStats($this->page);


    // SET the DEFAULT TIMEZONE
    if(function_exists('date_default_timezone_set') && !empty($this->adminConfig['timezone']))
      date_default_timezone_set($this->adminConfig['timezone']);


    // ->> SET LANGUAGE

    // -> first $language PARAMETER
    if(is_string($language) && strlen($language) == 2) {
      $_GET['language'] = $language;
    // -> second $_GET['language'] var if available
    } elseif(is_string($_GET['language']) && strlen($_GET['language']) == 2) {
      $this->language = XssFilter::alphabetical($_GET['language']);
    // -> third SESSION language
    } elseif(!empty($_SESSION['feinduraSession']['language']) && strlen($_SESSION['feinduraSession']['language']) == 2) {
      $this->language = $_SESSION['feinduraSession']['language'];
    // -> last get BROWSER LANGUAGE
    } else
      $this->language = substr(GeneralFunctions::getBrowserLanguages($this->websiteConfig['multiLanguageWebsite']['mainLanguage']),0,2);

    // ->> CHECK LANGUAGE

    // MULTILANGUAGE WEBSITE -> make sure the language exist
    if($this->websiteConfig['multiLanguageWebsite']['active'] && is_array($this->websiteConfig['multiLanguageWebsite']['languages']) && in_array($this->language, $this->websiteConfig['multiLanguageWebsite']['languages']))
      $this->language = $this->language;
    // MULTILANGUAGE WEBSITE -> if not use the MAIN LANGUAGE
    elseif($this->websiteConfig['multiLanguageWebsite']['active'])
      $this->language = $this->websiteConfig['multiLanguageWebsite']['mainLanguage'];
    // SINGLE LANGUAGE -> LOGGED IN use the backend language
    elseif($this->loggedIn && !empty($_SESSION['feinduraSession']['backendLanguage']))
      $this->language = $_SESSION['feinduraSession']['backendLanguage'];

    $_SESSION['feinduraSession']['language'] = $this->language;

    $this->loadFrontendLanguageFile($this->language);

    // -> SET the $metaData PROPERTY
    $this->metaData['title']       = $this->getLocalized($this->websiteConfig,'title');
    $this->metaData['publisher']   = $this->getLocalized($this->websiteConfig,'publisher');
    $this->metaData['copyright']   = $this->getLocalized($this->websiteConfig,'copyright');
    $this->metaData['keywords']    = $this->getLocalized($this->websiteConfig,'keywords');
    $this->metaData['description'] = $this->getLocalized($this->websiteConfig,'description');
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
      $this->setCurrentPageId(true);
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
  * @uses FeinduraBase::$language the language country code like "en", "de", ... which will be returned
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
      $this->metaData['title']       = $this->getLocalized($this->websiteConfig,'title');
      $this->metaData['publisher']   = $this->getLocalized($this->websiteConfig,'publisher');
      $this->metaData['copyright']   = $this->getLocalized($this->websiteConfig,'copyright');
      $this->metaData['keywords']    = $this->getLocalized($this->websiteConfig,'keywords');
      $this->metaData['description'] = $this->getLocalized($this->websiteConfig,'description');

      return $this->language;
    } else
      return false;
  }

 /**
  * <b>Name</b>     getLanguage()<br>
  *
  * Returns the {@link Feindura::$language language country code} which was set in the {@link feinduraBase:__construct()}.
  *
  * @uses FeinduraBase::$language the language country code like "en", "de", ... which will be returned
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
  * <b>Name</b>     getLocalized()<br>
  * <b>Alias</b>    getLocalization()<br>
  *
  * Gets the localized version of given <var>$value</var> parameter from the <var>$localizedArray</var>, which matches the {@link Feindura::$language} property.<br>
  * If no matching localized version for this language exists, it returns the "mainLanguage" or the first one in the localization array.
  *
  * Example usage:
  * <code>
  * <?php
  *
  * require_once('cms/feindura.include.php');
  * $feindura = new Feindura();
  *
  * // For example, you can use this function to get the name of a category (for the current language)
  * echo $feindura->getLocalized($feindura->categoryConfig[1],'name');
  *
  * // RESULT
  * // Name of the Category with ID 1
  *
  * ?>
  * </code>
  *
  * @param array        $localizedArray      an array with an ['localized'] array in the form of: array('de' => .. , 'en' => .. )
  * @param string       $value               the name of the value, which should be returned localized
  * @param string|false $language            (optional) a language code ("en","de", etc) to use for loading the localized version of the given <var>$value</var> paramter
  *
  *
  * @uses GeneralFunctions::getLocalized() to get the right localization
  * @uses Feindura::$language              the language used to get the localized version
  *
  * @return string the localized version of the <var>$value</var> parameter
  *
  * @see FeinduraBase::$websiteConfig
  * @see FeinduraBase::$categoryConfig
  *
  * @access public
  * @version 1.0
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.0 initial release
  *
  */
  public function getLocalized($localizedArray, $value, $language = false) {

    $language = (is_string($language) && strlen($language) == 2) ? $language : $this->language;

    return GeneralFunctions::getLocalized($localizedArray,$value,$language);
  }
 /**
  * Alias of {@link getLocalized()}
  * @ignore
  */
  public function getLocalization($localizedArray, $value) {
    // call the right function
    return $this->getLocalized($localizedArray, $value);
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
  * @param string|false $author         (optional) the author of the website
  * @param bool         $openGraph      (optional) if TRUE it add the following open graph meta tags: "og:site_name", "og:url", "og:title", "og:description" and "og:image", you should add ( prefix="og: http://ogp.me/ns#" ) to the <html> tag, like this <html prefix="og: http://ogp.me/ns#">
  * @param bool         $googleSnippets (optional) if TRUE it add the following google snippets meta tags: "url", "name", "description" and "image"
  *
  * @uses Feindura::$page                         to load the page title of the right page
  * @uses Feindura::$category                     to load the page title of the right page
  * @uses FeinduraBase::$websiteConfig            for the website title, publisher, copyright, description and keywords
  * @uses GeneralFunctions::readPage()            to load the page for the page title
  * @uses GeneralFunctions::setVisitorTimezone()  to try to set the timezone to the visitors one
  *
  * @return string with all meta tags ready to display in a HTML page
  *
  * @access public
  * @version 1.1
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.1 add maintenance message
  *    - 1.0.2 add {@link GeneralFunctions::setVisitorTimzone()} to set the local timezone
  *    - 1.0.1 changed readPage() from getCurrentPage() to use only the page property
  *    - 1.0 initial release
  *
  */
  public function createMetaTags($author = false, $openGraph = true, $googleSnippets = true) {

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
    //$metaTags .= '  <meta http-equiv="content-type" content="'.$siteType.'; charset=UTF-8"'.$tagEnding."\n";
    $metaTags .= '  <meta charset="UTF-8"'.$tagEnding."\n";

    // -> Set Visitors Local Timezone
    $metaTags .= GeneralFunctions::setVisitorTimzone();

    // -> get PAGE TITLE
    if($currentPage = GeneralFunctions::readPage($this->page,GeneralFunctions::getPageCategory($this->page)))
      $pageNameInTitle = strip_tags($this->getLocalized($currentPage,'title')).' | ';

    // -> add TITLE
    $metaTags .= '  <title>'.$pageNameInTitle.$this->getLocalized($this->websiteConfig,'title').'</title>'."\n\n";

    // -> add BASE PATH if PRETTY URLS are ON
    if($this->adminConfig['prettyURL'])
      $metaTags .= '  <base href="'.$this->adminConfig['url'].GeneralFunctions::Path2URI(GeneralFunctions::getDirname($this->adminConfig['websitePath'])).'"'.$tagEnding."\n\n";

    // -> add other META TAGs
    $metaTags .= '  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"'.$tagEnding.' <!-- enable google chrome frame, if available -->'."\n\n";

    // -> add author
    if($author && is_string($author))
      $metaTags .= '  <meta name="author" content="'.$author.'"'.$tagEnding."\n";

    // -> add puplisher
    $websiteConfigPublisher = $this->getLocalized($this->websiteConfig,'publisher');
    if(!empty($websiteConfigPublisher))
      $metaTags .= '  <meta name="publisher" content="'.$websiteConfigPublisher.'"'.$tagEnding."\n";

    // -> add copyright
    $websiteConfigCopyright = $this->getLocalized($this->websiteConfig,'copyright');
    if(!empty($websiteConfigCopyright))
      $metaTags .= '  <meta name="copyright" content="'.$websiteConfigCopyright.'"'.$tagEnding."\n";

    // -> add keywords
    $websiteConfigKeywords =  $this->getLocalized($this->websiteConfig,'keywords');
    $pageTags          =  $this->getLocalized($currentPage,'tags');
    if(!empty($pageTags) && $this->categoryConfig[$currentPage['category']]['showTags'])
      $metaTags .= '  <meta name="keywords" content="'.$pageTags.'"'.$tagEnding."\n";
    elseif(!empty($websiteConfigKeywords))
      $metaTags .= '  <meta name="keywords" content="'.$websiteConfigKeywords.'"'.$tagEnding."\n";

    // -> add description
    if(isset($currentPage)) {
      $websiteConfigDescription = $this->getLocalized($this->websiteConfig,'description');
      $pageDescription = $this->getLocalized($currentPage,'description');
      if($pageDescription)
        $metaTags .= '  <meta name="description" content="'.$pageDescription.'"'.$tagEnding."\n";
      elseif(!empty($websiteConfigDescription))
        $metaTags .= '  <meta name="description" content="'.$websiteConfigDescription.'"'.$tagEnding."\n";
    }


    $metaTags .= '  <meta name="revised" content="'.GeneralFunctions::getDateTimeValue($currentPage['lastSaveDate'],false).'"'.$tagEnding."\n";
    $metaTags .= '  <meta name="modified" content="'.GeneralFunctions::getDateTimeValue($currentPage['lastSaveDate'],false).'"'.$tagEnding."\n";

    $metaTags .= '  <meta name="generator" content="feindura - Flat File CMS '.VERSION.', Build '.BUILD.'"'.$tagEnding."\n";


    // Generate content for open graph and google snippets
    if($openGraph || $googleSnippets) {
      $pageTitle = $pageNameInTitle.$this->getLocalized($this->websiteConfig,'title');
      $pageDescription = str_replace('"','&quot;',strip_tags($this->getLocalized($currentPage,'description')));
      $pagePic = (!empty($currentPage['thumbnail']))
        ? $this->adminConfig['url'].$this->adminConfig['basePath'].'upload/thumbnails/'.$currentPage['thumbnail']
        : '';
    }

    if($openGraph) {
      $metaTags .= "\n".'  <!-- Open Graph Protocol -->'."\n";
      $metaTags .= '  <meta property="og:site_name" content="'.$this->getLocalized($this->websiteConfig,'title').'">'."\n";
      $metaTags .= '  <meta property="og:url" content="'.$this->createHref($currentPage,true).'">'."\n";

      if($currentPage) {

        if(!empty($pageTitle))
          $metaTags .= '  <meta property="og:title" content="'.$pageTitle.'">'."\n";
        if(!empty($pageDescription))
          $metaTags .= '  <meta property="og:description" content="'.$pageDescription.'">'."\n";
        if(!empty($pagePic))
          $metaTags .= '  <meta property="og:image" content="'.$pagePic.'">'."\n";
      }
    }

    if($googleSnippets) {
      $metaTags .= "\n".'  <!-- Google+ Snippets -->'."\n";
      $metaTags .= '  <meta itemprop="url" content="'.$this->createHref($currentPage,true).'">'."\n";

      if($currentPage) {
        if(!empty($pageTitle))
          $metaTags .= '  <meta itemprop="name" content="'.$pageTitle.'">'."\n";
        if(!empty($pageDescription))
          $metaTags .= '  <meta itemprop="description" content="'.$pageDescription.'">'."\n";
        if(!empty($pagePic))
          $metaTags .= '  <meta itemprop="image" content="'.$pagePic.'">'."\n";
      }
    }

    $metaTags .= "\n";

    // -> CHECK if website is currently under MAINTENANCE, if so show ERROR
    if($this->websiteConfig['maintenance'] && !$this->loggedIn) {
      die($metaTags.'  <link rel="stylesheet" type="text/css" href="'.GeneralFunctions::Path2URI($this->adminConfig['basePath']).'library/styles/frontendEditing.css"'.$tagEnding."\n".'</head><body class="feindura_maintenanceWarning"><div class="feindura_box">'.$this->languageFile['INFO_MAINTENACE'].'<div class="feindura_footer">'.$this->metaData['title'].'<br>&copy; '.date('Y').' '.$this->metaData['copyright'].'</div></div></body></html>');
    }

    // ->> add FEED;
    foreach($this->categoryConfig as $category) {

      // check if feeds are is activated for that category
      if($category['public'] && $category['feeds']) {

        // get languages
        if($this->websiteConfig['multiLanguageWebsite']['active'])
          $feedLanguages = $this->websiteConfig['multiLanguageWebsite']['languages'];
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
          $atomLink = $this->adminConfig['url'].GeneralFunctions::Path2URI($this->adminConfig['basePath']).'pages/'.$categoryPath.'atom'.$addLanguageToFilename.'.xml';
          $rss2Link = $this->adminConfig['url'].GeneralFunctions::Path2URI($this->adminConfig['basePath']).'pages/'.$categoryPath.'rss2'.$addLanguageToFilename.'.xml';

          // title
          $websiteTitle = $this->getLocalized($this->websiteConfig,'title',$langCode);
          if($category['id'] == 0)
            $channelTitle = $websiteTitle;
          else
            $channelTitle = $this->getLocalized($category,'name',$langCode).' - '.$websiteTitle;

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

    // ->> ENABLE FRONTEND EDITING (DEACTIVATED)
    // if user is logged into the CMS, add javascripts for implementing ckeditor
    if($this->loggedIn && GeneralFunctions::hasPermission('frontendEditing') && PHP_VERSION >= REQUIREDPHPVERSION) {

      $metaTags .= "\n  <!--- add feindura frontend editing -->\n";
      // add frontend editing stylesheets
      $metaTags .= '  <link rel="stylesheet" type="text/css" href="'.GeneralFunctions::Path2URI($this->adminConfig['basePath']).'library/thirdparty/ckeditor/plugins/feinduraSnippets/styles.css"'.$tagEnding."\n";
      $metaTags .= '  <link rel="stylesheet" type="text/css" href="'.GeneralFunctions::Path2URI($this->adminConfig['basePath']).'library/styles/shared.css"'.$tagEnding."\n";
      $metaTags .= '  <link rel="stylesheet" type="text/css" href="'.GeneralFunctions::Path2URI($this->adminConfig['basePath']).'library/styles/frontendEditing.css"'.$tagEnding."\n";
      $metaTags .= '  <link rel="stylesheet" type="text/css" href="'.GeneralFunctions::Path2URI($this->adminConfig['basePath']).'library/thirdparty/MooRTE/Source/Assets/moorte.css"'.$tagEnding."\n";
      $metaTags .= '  <link rel="stylesheet" type="text/css" href="'.GeneralFunctions::Path2URI($this->adminConfig['basePath']).'library/thirdparty/MooRTE/feinduraSkin/rteFeinduraSkin.css"'.$tagEnding."\n";

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
      $metaTags .= "\n";
      $metaTags .= '  <script type="text/javascript" src="'.GeneralFunctions::Path2URI($this->adminConfig['basePath']).'library/thirdparty/javascripts/mootools-core-1.4.5.js"></script>'."\n";
      $metaTags .= '  <script type="text/javascript" src="'.GeneralFunctions::Path2URI($this->adminConfig['basePath']).'library/thirdparty/javascripts/mootools-more-1.4.0.1.js"></script>'."\n";

      // add MooRTE
      $metaTags .= '  <script type="text/javascript" src="'.GeneralFunctions::Path2URI($this->adminConfig['basePath']).'library/thirdparty/MooRTE/Source/moorte.min.js"></script>'."\n";
      //$metaTags .= '  <script type="text/javascript" src="'.$this->adminConfig['basePath'].'library/thirdparty/MooRTE/dependencies/stickywin/StickyWinModalUI.js"></script>'."\n";
      // add raphael
      $metaTags .= '  <script type="text/javascript" src="'.GeneralFunctions::Path2URI($this->adminConfig['basePath']).'library/thirdparty/javascripts/raphael-1.5.2.js"></script>'."\n";
      // add the javascripts which are shared by the backend and the frontend
      $metaTags .= '  <script type="text/javascript" src="'.GeneralFunctions::Path2URI($this->adminConfig['basePath']).'library/javascripts/shared.js"></script>'."\n";

      // ->> create templates of the TOP BAR and PAGE BAR
      $metaTags .= "  <script type=\"text/javascript\">
  /* <![CDATA[ */
  // transport feindura PHP vars to javascript
  var feindura_url =                       '".$this->adminConfig['url']."';
  var feindura_basePath =                  '".GeneralFunctions::Path2URI($this->adminConfig['basePath'])."';
  var feindura_currentBackendLocation =    '".$_SESSION['feinduraSession']['login']['currentBackendLocation']."';
  var feindura_deactivateFrontendEditing = '".$_SESSION['feinduraSession']['login']['deactivateFrontendEditing']."';
  var feindura_langFile = {
    ERRORWINDOW_TITLE:                    \"".$this->languageFile['errorWindow_h1']."\",
    ERROR_SAVE:                           \"".$this->languageFile['ERROR_SAVEPAGE']."\",
    ERROR_SETSTARTPAGE:                   \"".$this->languageFile['SORTABLEPAGELIST_setStartPage_error_save']."\",
    LOADING_TEXT_LOAD:                    \"".$this->languageFile['LOADING_TEXT_LOAD']."\",
    FUNCTIONS_STARTPAGE_SET:              \"".$this->languageFile['SORTABLEPAGELIST_functions_startPage_set']."\",
    FUNCTIONS_STARTPAGE:                  \"".$this->languageFile['SORTABLEPAGELIST_functions_startPage']."\",
    FUNCTIONS_EDITPAGE:                   \"".$this->languageFile['PAGEFUNCTIONS_TIP_EDITINBACKEND']."\",
    BUTTON_LOGOUT:                        \"".$this->languageFile['HEADER_BUTTON_LOGOUT']."\",
    BUTTON_GOTOBACKEND:                   \"".$this->languageFile['HEADER_TIP_GOTOBACKEND']."\",
    EDITPAGE_TIP_DISABLED:                \"".$this->languageFile['EDITPAGE_TIP_DISABLED']."\",
    TOPBAR_TIP_FRONTENDEDITING:           \"".$this->languageFile['TOPBAR_TIP_FRONTENDEDITING']."\",
    TOPBAR_TIP_DEACTIVATEFRONTENDEDITING: \"".$this->languageFile['TOPBAR_TIP_DEACTIVATEFRONTENDEDITING']."\"
  };
  var feindura_logoutUrl =    '".GeneralFunctions::addParameterToUrl('feinduraLogout','')."';
  var feindura_startPage =    '".$this->startPage."';
  var feindura_xHtml =        '".$this->xHtml."';
  /* ]]> */
  </script>\n";

      // add frontend editing integration
      $metaTags .= '  <script type="text/javascript" src="'.GeneralFunctions::Path2URI($this->adminConfig['basePath']).'library/javascripts/frontendEditing.js"></script>'."\n";
    }

    // -> show the metaTags
    return $metaTags;
  }
 /**
  * Alias of {@link createMetaTags()}
  * @ignore
  */
  public function createMetaTag($author = false, $openGraph = true, $googleSnippets = true) {
    // call the right function
    return $this->createMetaTags($author, $openGraph, $googleSnippets);
  }

 /**
  * <b>Name</b> createHref()<br>
  *
  * Generates a href attribute which links to a page.
  * Depending whether Pretty URLs is in the administrator-settings activated, it generates a different href attribute.<br>
  * If cookies are deactivated it attaches the {@link FeinduraBase::$sessionId} on the end.
  *
  * <b>Note</b>: If the <var>$id</var> parameter is empty or FALSE it uses the {@link Feindura::$page} property.
  *
  *
  * Examples of the returned href string:
  *
  * Pages without category:
  * <samp>?page=1</samp>
  * Pages with category:
  * <samp>?category=1&page=1</samp>
  *
  * Pretty URL href for pages without category:
  * <samp>/page/page-title/</samp>
  * Pretty URL href for pages with category:
  * <samp>/category/category-name/page-title/</samp>
  *
  *
  * @param int|string|array|bool $id       (optional) a page ID, array with page and category ID, or a string/array with "previous","next","first","last" or "random". If FALSE it uses the {@link Feindura::$page} property.<br><i>See Additional -> $id parameter example</i>
  * @param bool                  $fullUrl  (optional) whether the full url should be returned or one relative to the website path.
  *
  * @uses FeinduraBase::getIdsFromString()  to load the right page and category IDs depending on the $ids parameter
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
  public function createHref($id = false, $fullUrl = false) {

    if($id = $this->getIdsFromString($id)) {
      // loads the $pageContent array
      if(($pageContent = GeneralFunctions::readPage($id[0],$id[1])) !== false) {
          return GeneralFunctions::createHref($pageContent,$this->sessionId,$this->language, $fullUrl);
      }
    }
    return false;
  }

 /**
  * <b>Name</b> createLink()<br>
  *
  * <b>This method uses the {@link Feindura::$linkLength $link...} and {@link $thumbnailAlign Feindura::$thumbnail...} properties.</b>
  *
  * Creates a link of a page.
  *
  *
  * If the given <var>$page</var> parameter is a string with "previous" or "next",
  * it creates a link for the previous or the next page, starting from the current page ID stored in the {@link Feindura::$page} property.
  * If there is no current, next or previous page in it returns FALSE.
  *
  * <b>Note</b>: If the <var>$id</var> parameter is empty or FALSE it uses the {@link Feindura::$page} property.<br>
  * <b>Note</b>: It will add the {@link Feindura::$linkActiveClass} property as a CSS class to the link (and also its wrapping element, e.g. <li> or <td>), when the links page is matching the current page, or the current page is a sub page of the links page.
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
  * @uses Feidnura::$linkPageDateSeparator
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
  * @uses FeinduraBase::getIdsFromString()        to load the right page and category IDs depending on the $ids parameter
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
    if($ids = $this->getIdsFromString($id)) {

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
          if(!empty($this->linkActiveClass) &&
             ($this->page == $pageContent['id'] ||
             (!empty($pageContent['subCategory']) && $this->category == $pageContent['subCategory'])))
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
  * Creates a menu from a category(ies) or page(s).<br>
  * In case no page with the given category or page ID(s) exist it returns an empty array.
  *
  * <b>Note</b>: The <var>$menuTag</var> parameter can be an "menu", "ul", "ol" or "table", it will then create the necessary child HTML-tags for this element.
  * If its any other tag name it just enclose the links with this HTML-tag.<br>
  * <b>Note</b>: If the <var>$ids</var> parameter is FALSE it uses the {@link Feindura::$page} or {@link Feindura::$category} property depending on the <var>$idType</var> parameter.<br>
  * <b>Note</b>: It will add the {@link Feindura::$linkActiveClass} property as a CSS class to the link (and also its wrapping element, e.g. <li> or <td>), when the links page is matching the current page, or the current page is a sub page of the links page.
  *
  * Example Usage:
  * {@example createMenu.example.php}
  *
  * Example of the returned Array:
  * {@example createMenu.return.example.php}
  *
  *
  * @param string         $idType             (optional) the ID(s) type can be "cat", "category", "categories" or "pag", "page" or "pages"
  * @param int|array|bool $ids                (optional) the category or page ID(s), can be a number or an array with numbers (can also be a $pageContent array), if TRUE it loads all pages, if FALSE it uses the {@link Feindura::$page} or {@link Feindura::$category} property
  * @param int|bool       $menuTag            (optional) the tag which is used to create the menu, can be an "menu", "ul", "ol", "array('table',<number until new row>)" or any other tag, if TRUE it uses "div". You can also add simple Zen Code selectors to this string to add id, classes and attributes. E.g. "ul#myId.myClass1.myClass2[attribute1=value][attribute2=value]" converts to <ul id="myId" class="myClass1 myClass2" attribute1="value" attribute2="value">
  * @param string|bool    $linkText           (optional) a string with a linktext which all links will use, if TRUE it uses the page titles of the pages, if FALSE no linktext will be used
  * @param bool           $sortPages          (optional) if TRUE it sorts the pages like they are sorted in the backend, if FALSE they are sorted in the order of the given IDs. Can also be a sort function e.g. "sortByLastSaveDate". See {@link GeneralFunctions::sortPages()} for more.
  * @param bool           $reverseList        (optional) if TRUE the pages sorting will be reversed
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
  * @uses GeneralFunctions::sortPages()           to sort the $pageContent arrays by category
  * @uses FeinduraBase::generateMenu()            to generate the final menu
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
  public function createMenu($idType = 'category', $ids = false, $menuTag = false, $linkText = true, $sortPages = false, $reverseList = false) {

    $ids = $this->getPropertyIdsByType($idType,$ids);

    // -> LOADS the PAGES BY TYPE
    $pages = $this->loadPagesByType($idType,$ids);



    // -> SORT PAGES
    // sorts by CATEGORIES like in the backend
    if($sortPages === true) {
      $pages = GeneralFunctions::sortPages($pages);

    // sort by given sort function
    } elseif(is_string($sortPages) && function_exists($sortPages))
      usort($pages,$sortPages);

    // -> flips the pages array if $reverseList === true
    if($reverseList === true)
      $pages = array_reverse($pages);


    // -> STOREs the LINKs in an Array
    $links = array();
    if(!empty($pages)) {
      // create a link out of every page in the array
      foreach($pages as $page) {
        // creates the link
        if(($page['showInMenus'] || $this->menuShowAllPages) && $pageLink = $this->createLink($page,$linkText)) {
          // adds the link to an array
          $link['link']        = $pageLink;
          $link['href']        = $this->createHref($page);
          $link['id']          = $page['id'];
          $link['category']    = $page['category'];
          $link['subCategory'] = $page['subCategory'];
          $link['tags']        = $this->getLocalized($page,'tags');

          // -> add Thumbnail
          if($pageThumbnail = $this->createThumbnail($page)) {
            $link['thumbnail'] = $pageThumbnail['thumbnail'];
            $link['thumbnailPath'] = $pageThumbnail['thumbnailPath'];
          }

          // -> add PAGE DATE
          if($this->categoryConfig[$page['category']]['showPageDate']) {
            // add page date
            $link['pageDate']          = GeneralFunctions::showPageDate($page,true,$this->languageFile);
            $link['pageDateTimestamp']['date']  = $page['pageDate']['start'];
            $link['pageDateTimestamp']['start'] = $page['pageDate']['start'];
            $link['pageDateTimestamp']['end']   = $page['pageDate']['end'];
          } else
            $link['pageDate'] = false;

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
      return array();

    return $this->generateMenu($links,$menuTag);
  }

 /**
  * <b>Name</b>     createMenuByTags()<br>
  * <b>Alias</b>    createMenuByTag()<br>
  *
  * <b>This method uses the {@link Feindura::$linkLength $link...}, {@link Feindura::$menuId $menu...} and {@link Feindura::$thumbnailAlign $thumbnail...} properties.</b>
  *
  * Create a menu from category(ies) or page(s), with pages which have one or more of the tags from the given <var>$tags</var> parameter.<br>
  * In case no page with the given category or page ID(s) or tags exist it returns an empty array.
  *
  *
  * <b>Note</b>: the tags will be compared case insensitive.<br>
  * <b>Note</b>: The <var>$menuTag</var> parameter can be an "menu", "ul", "ol" or "table", it will then create the necessary HTML-tags of this element.
  * If its any other tag name it just enclose the links with this HTML-tag.<br>
  * <b>Note</b>: If the <var>$ids</var> parameter is FALSE it uses the {@link Feindura::$page} or {@link Feindura::$category} property depending on the <var>$idType</var> parameter.<br>
  * <b>Note</b>: It will add the {@link Feindura::$linkActiveClass} property as a CSS class to the link (and also its wrapping element, e.g. <li> or <td>), when the links page is matching the current page, or the current page is a sub page of the links page.
  *
  * Example:
  * {@example createMenuByTags.example.php}
  *
  * Example of the returned Array:
  * {@example createMenu.return.example.php}
  *
  *
  * @param string|array   $tags               a string with tags seperated by "," or ";" or an array with tags
  * @param string         $idType             (optional) the ID(s) type can be "cat", "category", "categories" or "pag", "page" or "pages"
  * @param int|array|bool $ids                (optional) the category or page ID(s), can be a number or an array with numbers (can also be a $pageContent array), if TRUE it loads all pages, if FALSE it uses the {@link Feindura::$page} or {@link Feindura::$category} property
  * @param int|bool       $menuTag            (optional) the tag which is used to create the menu, can be an "ul", "ol", "array('table',<number until new row>)" or any other tag, if TRUE it uses "div"
  * @param string|bool    $linkText           (optional) a string with a linktext which all links will use, if TRUE it uses the page titles of the pages, if FALSE no linktext will be used
  * @param bool           $sortPages          (optional) if TRUE it sorts the pages like they are sorted in the backend, if FALSE they are sorted in the order of the given IDs. Can also be a sort function e.g. "sortByLastSaveDate". See {@link GeneralFunctions::sortPages()} for more.
  * @param bool           $reverseList        (optional) if TRUE the pages sorting will be reversed
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
  public function createMenuByTags($tags, $idType = 'category', $ids = false, $menuTag = false, $linkText = true, $sortPages = false, $reverseList = false) {

    $ids = $this->getPropertyIdsByType($idType,$ids);

    // check for the tags and CREATE A MENU
    if($ids = $this->checkPagesForTags($idType,$ids,$tags)) {
      return $this->createMenu($idType,$ids,$menuTag,$linkText,$sortPages,$reverseList);
    } else
      return array();
  }
 /**
  * Alias of {@link createMenuByTags()}
  * @ignore
  */
  public function createMenuByTag($tags, $idType = 'category', $ids = false, $menuTag = false, $linkText = true, $sortPages = false, $reverseList = false) {
    // call the right function
    return $this->createMenuByTags($tags,$idType,$ids,$menuTag,$linkText,$sortPages,$reverseList);
  }

 /**
  * <b>Name</b>     createMenuByDate()<br>
  * <b>Alias</b>    createMenuByDates()<br>
  *
  * <b>This method uses the {@link Feindura::$linkLength $link...}, {@link Feindura::$menuId $menu...} and {@link Feindura::$thumbnailAlign $thumbnail...} properties.</b>
  *
  * Creates a menu from category(ies) or page(s) parameter.
  * Applies for pages which have a page date (and page date is activated for that category!) and it fit in the time period
  * from the <var>$from</var> and the <var>$to</var> parameter (relative to the current date).
  *
  * The <var>$from</var> and <var>$to</var> parameters can also be a string with a (relative or specific) date, for more information see: {@link http://www.php.net/manual/de/datetime.formats.php}.
  *
  * In case no page with the given category or page ID(s) or tags exist it returns an empty array.
  *
  * <b>Note</b>: The <var>$menuTag</var> parameter can be an "menu", "ul", "ol" or "table", it will then create the necessary HTML-tags of this element.
  * If its any other tag name it just enclose the links with this HTML-tag.<br>
  * <b>Note</b>: If the <var>$ids</var> parameter is FALSE it uses the {@link Feindura::$page} or {@link Feindura::$category} property depending on the <var>$idType</var> parameter.<br>
  * <b>Note</b>: It will add the {@link Feindura::$linkActiveClass} property as a CSS class to the link (and also its wrapping element, e.g. <li> or <td>), when the links page is matching the current page, or the current page is a sub page of the links page.
  *
  * Example:
  * {@example createMenuByDate.example.php}
  *
  * Example of the returned Array:
  * {@example createMenu.return.example.php}
  *
  *
  * @param int|bool|string $from               (optional) number of months in the past, if TRUE it show all pages in the past, if FALSE it loads only pages starting from the current date. Can also be a string with a date format (e.g. '2 weeks' or '27.06.2012'), for more details see: {@link http://www.php.net/manual/en/datetime.formats.php}
  * @param int|bool|string $to                 (optional) number of months in the future, if TRUE it show all pages in the future, if FALSE it loads only pages until the current date. Can also be a string with a date format (e.g. '10 days' or '27.06.2012'), for more details see: {@link http://www.php.net/manual/de/datetime.formats.php}
  * @param string          $idType             (optional) the ID(s) type can be "cat", "category", "categories" or "pag", "page" or "pages"
  * @param int|array|bool  $ids                (optional) the category or page ID(s), can be a number or an array with numbers (can also be a $pageContent array), if TRUE it loads all pages, if FALSE it uses the {@link Feindura::$page} or {@link Feindura::$category} property
  * @param int|bool        $menuTag            (optional) the tag which is used to create the menu, can be an "ul", "ol", "array('table',<number until new row>)" or any other tag, if TRUE it uses "div"
  * @param string|bool     $linkText           (optional) a string with a linktext which all links will use, if TRUE it uses the page titles of the pages, if FALSE no linktext will be used
  * @param bool            $sortPages          (optional) if TRUE it sorts the pages like they are sorted in the backend, if FALSE it sorts the pages by date (If date range: by start date). Can also be a sort function e.g. "sortByEndDate". See {@link GeneralFunctions::sortPages()} for more.
  * @param bool            $reverseList        (optional) if TRUE the pages sorting will be reversed
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
  public function createMenuByDate($from = true, $to = true, $idType = 'category', $ids = false, $menuTag = false, $linkText = true, $sortPages = false, $reverseList = false) {

      // gets the right pages and sorted by page date
      if($pageContents = $this->loadPagesByDate($from,$to,$idType,$ids,$sortPages,$reverseList))
         return $this->createMenu($idType,$pageContents,$menuTag,$linkText,false,false);
      else
        return array();

  }
 /**
  * Alias of {@link createMenuByDate()}
  * @ignore
  */
  public function createMenuByDates($from = true, $to = true, $idType = 'category', $ids = false, $menuTag = false, $linkText = true, $sortPages = false, $reverseList = false) {
    // call the right function
    return $this->createMenuByDate($from, $to, $idType, $ids, $menuTag, $linkText, $sortPages, $reverseList);
  }

 /**
  * <b>Name</b>     createMenuBySortFunction()<br>
  * <b>Alias</b>    createMenuBySort()<br>
  * <b>Alias</b>    createMenuBySortCallback()<br>
  * <b>Alias</b>    createMenuByCallback()<br>
  *
  * <b>This method uses the {@link Feindura::$linkLength $link...}, {@link Feindura::$menuId $menu...} and {@link Feindura::$thumbnailAlign $thumbnail...} properties.</b>
  *
  * Creates a menu from category(ies) or page(s), sorted by a custom sort function passed in the first parameter <var>$sortCallback</var>.
  *
  * In case no page with the given category or page ID(s) or tags exist it returns an empty array.
  *
  * <b>Note</b>: The <var>$menuTag</var> parameter can be an "menu", "ul", "ol" or "table", it will then create the necessary HTML-tags of this element.
  * If its any other tag name it just enclose the links with this HTML-tag.<br>
  * <b>Note</b>: If the <var>$ids</var> parameter is FALSE it uses the {@link Feindura::$page} or {@link Feindura::$category} property depending on the <var>$idType</var> parameter.<br>
  * <b>Note</b>: It will add the {@link Feindura::$linkActiveClass} property as a CSS class to the link (and also its wrapping element, e.g. <li> or <td>), when the links page is matching the current page, or the current page is a sub page of the links page.
  *
  *
  * Example:
  * {@example createMenuBySortFunction.example.php}
  *
  * Example of the returned Array:
  * {@example createMenu.return.example.php}
  *
  *
  * @param string         $sortCallback        the name of the callback function to sort the menu (uses usort()). For a list of available predefined functions see {@link GeneralFunctions::sortPages()}
  * @param string         $idType              (optional) the ID(s) type can be "cat", "category", "categories" or "pag", "page" or "pages"
  * @param int|array|bool $ids                 (optional) the category or page ID(s), can be a number or an array with numbers (can also be a $pageContent array), if TRUE it loads all pages, if FALSE it uses the {@link Feindura::$page} or {@link Feindura::$category} property
  * @param int|bool       $menuTag             (optional) the tag which is used to create the menu, can be an "ul", "ol", "array('table',<number until new row>)" or any other tag, if TRUE it uses "div"
  * @param string|bool    $linkText            (optional) a string with a linktext which all links will use, if TRUE it uses the page titles of the pages, if FALSE no linktext will be used
  * @param bool           $reverseList         (optional) if TRUE the pages sorting will be reversed
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
  public function createMenuBySortFunction($sortCallback, $idType = 'category', $ids = false, $menuTag = false, $linkText = true, $reverseList = false) {

      // load the pages
      $pageContents = $this->loadPagesByType($idType,$ids);
      if(is_array($pageContents)) {
        usort($pageContents,$sortCallback);
        // -> flips the sorted array if $reverseList === true
        if($reverseList === true)
          $pageContents = array_reverse($pageContents);
        return $this->createMenu($idType,$pageContents,$menuTag,$linkText,false,false);

      } else
        return array();
  }
 /**
  * Alias of {@link createMenuBySortFunction()}
  * @ignore
  */
  public function createMenuBySort($sortCallback, $idType = 'category', $ids = false, $menuTag = false, $linkText = true, $reverseList = false) {
      // call the right function
      return $this->createMenuBySortFunction($sortCallback,$idType,$ids,$menuTag,$linkText,$reverseList);
  }
  /**
  * Alias of {@link createMenuBySortFunction()}
  * @ignore
  */
  public function createMenuBySortCallback($sortCallback, $idType = 'category', $ids = false, $menuTag = false, $linkText = true, $reverseList = false) {
      // call the right function
      return $this->createMenuBySortFunction($sortCallback,$idType,$ids,$menuTag,$linkText,$reverseList);
  }
  /**
  * Alias of {@link createMenuBySortFunction()}
  * @ignore
  */
  public function createMenuByCallback($sortCallback, $idType = 'category', $ids = false, $menuTag = false, $linkText = true, $reverseList = false) {
      // call the right function
      return $this->createMenuBySortFunction($sortCallback,$idType,$ids,$menuTag,$linkText,$reverseList);
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
    if($ids = $this->getIdsFromString(array(false,$categoryId))) {
      $categoryId = $ids[1];
      if($this->categoryConfig[$categoryId]['isSubCategory'])
        return true;
    }

    return false;
  }


/**
  * <b>Name</b> isSubCategoryOf()<br>
  *
  * Check if the given <var>$pageId</var> ID has the given <var>$categoryId</var> as a subcategory.<br>
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

    if($ids = $this->getIdsFromString(array($pageId,false)))
      $pageId = $ids[0];

    if($ids = $this->getIdsFromString(array(false,$categoryId)))
      $categoryId = $ids[1];

    $subCategoryPages = unserialize($this->categoryConfig[$categoryId]['isSubCategoryOf']);

    if(is_array($subCategoryPages) && array_key_exists($pageId, $subCategoryPages))
      return true;

    return false;
  }

  /**
  * <b>Name</b> getParentPagesOf()<br>
  *
  * Loads the parent pages of a subcategory.
  *
  * <b>Note</b>: If the <var>$categoryId</var> parameter is FALSE or empty, it uses the current page (means the {@link Feindura::$page} property).<br>
  *
  * @param int|string|bool $categoryId  (optional) a category ID, or a string with "previous","next","first","last" or "random". If FALSE it uses the {@link Feindura::$category} property.
  *
  * @uses Feindura::$category
  * @uses Feindura::$categoryConfig
  *
  *
  * @return array|false and array with all the parent pages or FALSE if it is not a sub category
  *
  * @access public
  * @version 1.0
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.0 initial release
  *
  */
  public function getParentPagesOf($categoryId = false) {

    if($ids = $this->getIdsFromString(array(false,$categoryId)))
      $categoryId = $ids[1];

    // quit if its not a subcategory
    if(!$this->categoryConfig[$categoryId]['isSubCategory'])
      return false;

    else {
      // vars
      $return = array();

      $parentPages = unserialize($this->categoryConfig[$categoryId]['isSubCategoryOf']);
      foreach ($parentPages as $pageId => $categoryId) {
        if($generatedPage = $this->generatePage($pageId,$this->showErrors))
          $return[] = $generatedPage;
      }
      return $return;
    }
  }

 /**
  * <b>Name</b> createSubMenu()<br>
  *
  * <b>This method uses the {@link Feindura::$linkLength $link...}, {@link Feindura::$menuId $menu...} and {@link Feindura::$thumbnailAlign $thumbnail...} properties.</b>
  *
  * Creates a sub menu from the <i>current</i> page ({@link Feindura::$page}) or the current category ({@link Feindura::$category}), if its a subcategory.<br>
  * In case the current page has no subcategory or the current category is no subcategory it returns an empty array.<br>
  *
  *
  * <b>Note</b>: The <var>$menuTag</var> parameter can be an "menu", "ul", "ol" or "table", it will then create the necessary child HTML-tags of this element.
  * If its any other tag name it just enclose the links with this HTML-tag.<br>
  * <b>Note</b>: It will add the {@link Feindura::$linkActiveClass} property as a CSS class to the link (and also its wrapping element, e.g. <li> or <td>), when the links page is matching the current page, or the current page is a sub page of the links page.
  *
  *
  * Example:
  * {@example createSubMenu.example.php}
  *
  * Example of the returned Array:
  * {@example createMenu.return.example.php}
  *
  *
  * @param int|bool               $menuTag            (optional) the tag which is used to create the menu, can be an "ul", "ol", "array('table',<number until new row>)" or any other tag, if TRUE it uses "div"
  * @param string|bool            $linkText           (optional) a string with a linktext which all links will use, if TRUE it uses the page titles of the pages, if FALSE no linktext will be used
  * @param bool                   $sortPages          (optional) if TRUE it sorts the pages like they are sorted in the backend, if FALSE they are sorted in the order of the given IDs. Can also be a sort function e.g. "sortByLastSaveDate". See {@link GeneralFunctions::sortPages()} for more.
  * @param bool                   $reverseList        (optional) if TRUE the pages sorting will be reversed
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
  public function createSubMenu($menuTag = false, $linkText = true, $sortPages = false, $reverseList = false) {

    if(($subMenu = $this->createSubMenuOfPage(false, $menuTag, $linkText, $sortPages, $reverseList)) ||
       ($subMenu = $this->createSubMenuOfSubCategory(false, $menuTag, $linkText, $sortPages, $reverseList))) {
      return $subMenu;
    }

    return array();
  }

 /**
  * <b>Name</b> createSubMenuOfPage()<br>
  * <b>Alias</b> createSubMenuFromPage()<br>
  *
  * <b>This method uses the {@link Feindura::$linkLength $link...}, {@link Feindura::$menuId $menu...} and {@link Feindura::$thumbnailAlign $thumbnail...} properties.</b>
  *
  * Creates a sub menu out of the subcategory of a page. If the page has no subcategory it will return an empty array.<br>
  * In case no page with the given page ID exist, or it has no subcategory it returns an empty array.<br>
  *
  *
  * <b>Note</b>: The <var>$menuTag</var> parameter can be an "menu", "ul", "ol" or "table", it will then create the necessary child HTML-tags of this element.
  * If its any other tag name it just enclose the links with this HTML-tag.<br>
  * <b>Note</b>: If the <var>$id</var> parameter is FALSE or empty, it uses the current page (means the {@link Feindura::$page} property).<br>
  * <b>Note</b>: It will add the {@link Feindura::$linkActiveClass} property as a CSS class to the link (and also its wrapping element, e.g. <li> or <td>), when the links page is matching the current page, or the current page is a sub page of the links page.
  *
  *
  * Example:
  * {@example createSubMenuOfPage.example.php}
  *
  * Example of the returned Array:
  * {@example createMenu.return.example.php}
  *
  *
  * @param int|string|array|bool  $id                 (optional) a page ID, array with page and category ID, or a string/array with "previous","next","first","last" or "random". If FALSE it uses the {@link Feindura::$page} property.<br><i>See Additional -> $id parameter example</i>
  * @param int|bool               $menuTag            (optional) the tag which is used to create the menu, can be an "ul", "ol", "array('table',<number until new row>)" or any other tag, if TRUE it uses "div"
  * @param string|bool            $linkText           (optional) a string with a linktext which all links will use, if TRUE it uses the page titles of the pages, if FALSE no linktext will be used
  * @param bool                   $sortPages          (optional) if TRUE it sorts the pages like they are sorted in the backend, if FALSE they are sorted in the order of the given IDs. Can also be a sort function e.g. "sortByLastSaveDate". See {@link GeneralFunctions::sortPages()} for more.
  * @param bool                   $reverseList        (optional) if TRUE the pages sorting will be reversed
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
  public function createSubMenuOfPage($id = false, $menuTag = false, $linkText = true, $sortPages = false, $reverseList = false) {

    if($ids = $this->getIdsFromString($id)) {
      // loads the $pageContent array
      if(($pageContent = GeneralFunctions::readPage($ids[0],$ids[1])) !== false) {
        // return subcategory
        if(is_numeric($pageContent['subCategory']) && $this->categoryConfig[$pageContent['category']]['showSubCategory'])
          return $this->createMenu('category', $pageContent['subCategory'], $menuTag, $linkText, $sortPages,$reverseList);
      }
    }

    return array();
  }

 /**
  * <b>Name</b> createSubMenuOfSubCategory()<br>
  * <b>Alias</b> createSubMenuOfCategory()<br>
  * <b>Alias</b> createSubMenuFromSubCategory()<br>
  * <b>Alias</b> createSubMenuFromCategory()<br>
  * <b>Alias</b> createMenuFromSubCategory()<br>
  * <b>Alias</b> createMenuOfSubCategory()<br>
  *
  * <b>This method uses the {@link Feindura::$linkLength $link...}, {@link Feindura::$menuId $menu...} and {@link Feindura::$thumbnailAlign $thumbnail...} properties.</b>
  *
  * Creates a sub menu from a subcategory. If the category is not a sub category it will return an empty array.<br>
  * In case no category with the given page ID exist, or it is not a subcategory it returns an empty array.<br>
  *
  *
  * <b>Note</b>: The <var>$menuTag</var> parameter can be an "menu", "ul", "ol" or "table", it will then create the necessary child HTML-tags of this element.
  * If its any other tag name it just enclose the links with this HTML-tag.<br>
  * <b>Note</b>: If the <var>$id</var> parameter is FALSE or empty, it uses the current category (means the {@link Feindura::$category} property).<br>
  * <b>Note</b>: It will add the {@link Feindura::$linkActiveClass} property as a CSS class to the link (and also its wrapping element, e.g. <li> or <td>), when the links page is matching the current page, or the current page is a sub page of the links page.
  *
  *
  * You can use this function in conjunction with {@link Feindura::createSubMenuOfPage()} to display the submenu,
  * even if you're in a page of the subcategory.
  * <code>
  * <?php
  *
  * // we use "false", because we use the current page and category.
  * // NOTE: we need the double (), otherwise it would use the assignment of the $subMenu variable as condition!
  * if(($subMenu = $feindura->createSubMenuOfPage(false,'ul')) || // will create the menu when inside the page which has a subcategory
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
  * @param int|bool        $menuTag            (optional) the tag which is used to create the menu, can be an "ul", "ol", "array('table',<number until new row>)" or any other tag, if TRUE it uses "div"
  * @param string|bool     $linkText           (optional) a string with a linktext which all links will use, if TRUE it uses the page titles of the pages, if FALSE no linktext will be used
  * @param bool            $sortPages          (optional) if TRUE it sorts the pages like they are sorted in the backend, if FALSE they are sorted in the order of the given IDs. Can also be a sort function e.g. "sortByLastSaveDate". See {@link GeneralFunctions::sortPages()} for more.
  * @param bool            $reverseList        (optional) if TRUE the pages sorting will be reversed
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
  * @example createSubMenu.example.php See the example of the createSubMenuOfPage() method
  *
  * @see createSubMenuOfPage()
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
  public function createSubMenuOfSubCategory($categoryId = false, $menuTag = false, $linkText = true, $sortPages = false, $reverseList = false) {

    if($ids = $this->getIdsFromString(array(false,$categoryId))) {
      $categoryId = $ids[1];
      if($this->isSubCategory($categoryId)) {

        // check if subcategory
        if($categoryId && is_numeric($categoryId) && $this->categoryConfig[$categoryId]['isSubCategory'])
          return $this->createMenu('category', $categoryId, $menuTag, $linkText, $sortPages,$reverseList);
      }
    }

    return array();
  }
  /**
  * Alias of {@link createSubMenuOfSubCategory()}
  * @ignore
  */
  public function createSubMenuOfCategory($categoryId = false, $menuTag = false, $linkText = true, $sortPages = false, $reverseList = false) {
    // call the right function
    return $this->createSubMenuOfSubCategory($categoryId, $menuTag, $linkText, $sortPages,$reverseList);
  }
  /**
  * Alias of {@link createSubMenuOfSubCategory()}
  * @ignore
  */
  public function createSubMenuFromSubCategory($categoryId = false, $menuTag = false, $linkText = true, $sortPages = false, $reverseList = false) {
    // call the right function
    return $this->createSubMenuOfSubCategory($categoryId, $menuTag, $linkText, $sortPages,$reverseList);
  }
  /**
  * Alias of {@link createSubMenuOfSubCategory()}
  * @ignore
  */
  public function createSubMenuFromCategory($categoryId = false, $menuTag = false, $linkText = true, $sortPages = false, $reverseList = false) {
    // call the right function
    return $this->createSubMenuOfSubCategory($categoryId, $menuTag, $linkText, $sortPages,$reverseList);
  }
  /**
  * Alias of {@link createSubMenuOfSubCategory()}
  * @ignore
  */
  public function createMenuFromSubCategory($categoryId = false, $menuTag = false, $linkText = true, $sortPages = false, $reverseList = false) {
    // call the right function
    return $this->createSubMenuOfSubCategory($categoryId, $menuTag, $linkText, $sortPages,$reverseList);
  }
  /**
  * Alias of {@link createSubMenuOfSubCategory()}
  * @ignore
  */
  public function createMenuOfSubCategory($categoryId = false, $menuTag = false, $linkText = true, $sortPages = false, $reverseList = false) {
    // call the right function
    return $this->createSubMenuOfSubCategory($categoryId, $menuTag, $linkText, $sortPages,$reverseList);
  }

 /**
  * <b>Name</b> createLanguageMenu()<br>
  * <b>Alias</b> createLanguagesMenu()<br>
  *
  * <b>This method uses the {@link Feindura::$linkLength $link...}, {@link Feindura::$menuId $menu...} properties.</b>
  *
  * Creates a menu as language selection for the multi language website feature.
  * In case that the multi language website feature is deactivated it returns an empty array.
  *
  *
  * <b>Note</b>: The <var>$menuTag</var> parameter can be an "menu", "ul", "ol" or "table", it will then create the necessary child HTML-tags for this element.
  * If its any other tag name it just enclose the links with this HTML-tag.<br>
  * <b>Note</b>: It will add the {@link Feindura::$linkActiveClass} property as CSS class to the link, which is matching the current language.
  *
  *
  * Example Usage:
  * {@example createLanguageMenu.example.php}
  *
  * Example of the returned Array:
  * {@example createLanguageMenu.return.example.php}
  *
  *
  * @param int|bool       $menuTag            (optional) the tag which is used to create the menu, can be an "ul", "ol", "array('table',<number until new row>)" or any other tag, if TRUE it uses "div"
  * @param string|bool    $linkText           (optional) a string with a linktext which all links will use, if TRUE it uses the page titles of the pages, if FALSE no linktext will be used
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
  * @uses FeinduraBase::generateMenu()            to generate the final menu
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
  public function createLanguageMenu($menuTag = false, $linkText = true) {

    // quit if multilanguage website is deactivated
    if(!$this->websiteConfig['multiLanguageWebsite']['active'])
      return array();

    // -> STOREs the LINKs in an Array
    $links = array();
    if(!empty($this->websiteConfig['multiLanguageWebsite']['languages'])) {
      // -> store original values
      $orgLinkShowThumbnail = $this->linkShowThumbnail;
      $orgLanguage = $this->language;
      $orgLinkActiveClass = $this->linkActiveClass;

      //make sure createLink() doesn't add a thumbnail
      $this->linkShowThumbnail = false;

      // create a link out of every language in the array
      foreach($this->websiteConfig['multiLanguageWebsite']['languages'] as $langCode) {

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
          $link['active']   = ($orgLanguage == $langCode) ? true : false;
          $link['href']     = $this->createHref(false);
          $link['language'] = $langCode;
          $link['flag']     = GeneralFunctions::getFlagSrc($langCode, false);
          $links[] = $link;
        }
      }

      // -> reset the old values
      $this->linkShowThumbnail = $orgLinkShowThumbnail;
      $this->language = $orgLanguage;
      $this->linkActiveClass = $orgLinkActiveClass;

    } else
      return array(false);

    return $this->generateMenu($links,$menuTag);
  }
  /**
  * Alias of {@link createLanguageMenu()}
  * @ignore
  */
  public function createLanguagesMenu($menuTag = false, $linkText = true) {
    // call the right function
    return $this->createLanguageMenu($menuTag, $linkText);
  }

 /**
  * <b>Name</b> createBreadCrumbsMenu()<br>
  * <b>Alias</b> createBreadCrumbMenu()<br>
  * <b>Alias</b> createBreadCrumbs()<br>
  * <b>Alias</b> createBreadCrumb()<br>
  *
  * <b>This method uses the {@link Feindura::$linkLength $link...}, {@link Feindura::$menuId $menu...} and {@link Feindura::$thumbnailAlign $thumbnail...} properties.</b>
  *
  * Creates a breadcrumb navigation for the given page.
  * In case no page with the given category or page ID(s) exist it returns an empty array.
  *
  * <b>Note</b>: If the <var>$id</var> parameter is FALSE or empty, it uses the current page (means the {@link Feindura::$page} property).<br>
  * <b>Note</b>: The <var>$menuTag</var> parameter can be an "menu", "ul", "ol" or "table", it will then create the necessary child HTML-tags for this element.
  * If its any other tag name it just enclose the links with this HTML-tag.<br>
  *
  * Example of the returned Array:
  * {@example createMenu.return.example.php}
  *
  *
  * @param int|string|array|bool $id            (optional) a page ID, array with page and category ID, or a string/array with "previous","next","first","last" or "random". If FALSE it uses the {@link Feindura::$page} property.<br><i>See Additional -> $id parameter example</i>
  * @param string|false          $separator     (optional) a string which will be used as separator or FALSE to dont use a separator string
  * @param int|bool              $menuTag       (optional) the tag which is used to create the menu, can be an "ul", "ol", "array('table',<number until new row>)" or any other tag, if TRUE it uses "div"
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
  * @uses Feindura::$linkShowCategory               This is set to FALSE for all links, which are in a sub category (So the sub category name doesn't appear). You can change the separator between the category and the page name by setting the {@link Feindura::$linkCategorySeparator}
  * @uses Feindura::$linkCategorySeparator
  *
  * @uses Feindura::$thumbnailAlign
  * @uses Feindura::$thumbnailId
  * @uses Feindura::$thumbnailClass
  * @uses Feindura::$thumbnailAttributes
  * @uses Feindura::$thumbnailBefore
  * @uses Feindura::$thumbnailAfter
  *
  * @uses FeinduraBase::getIdsFromString()       to load the right page and category IDs depending on the $ids parameter
  * @uses Feindura::readPage()
  * @uses GeneralFunctions::getParentPages()           to get the parent pages in an array
  *
  * @return array the created breadcrumb navigation, or an empty array
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
  public function createBreadCrumbsMenu($id = false, $separator = ' > ', $menuTag = false) {

    // var
    $links = array();
    $orgLinkActiveClass = $this->linkActiveClass;
    $this->linkActiveClass = false;

    if($ids = $this->getIdsFromString($id)) {
      // unset($_SESSION['feinduraSession']['log']['visitedPagesOrder']);
      // print_r($_SESSION['feinduraSession']['log']['visitedPagesOrder']);

      // loads the $breadCrumbsArray
      $breadCrumbsArray = GeneralFunctions::createBreadCrumbsArray($ids[0],$ids[1]);

      if(!empty($breadCrumbsArray)) {

        foreach ($breadCrumbsArray as $parentPageContent) {
          $getLinkCategory = $this->linkShowCategory;

          // only show the category, if the parents page category is not a sub category
          if($this->categoryConfig[$parentPageContent['category']]['isSubCategory'])
            $this->linkShowCategory = false;

          $link['link']     = $this->createLink($parentPageContent);
          $link['href']     = $this->createHref($parentPageContent);
          $link['id']       = $parentPageContent['id'];
          $link['category'] = $parentPageContent['category'];
          $link['tags']     = $this->getLocalized($parentPageContent,'tags');

          $link['title']    = $this->createTitle($parentPageContent,
                                              $this->linkLength,
                                              false, // $titleAsLink
                                              $this->linkShowPageDate,
                                              $this->linkShowCategory,
                                              $this->linkPageDateSeparator,
                                              $this->linkCategorySeparator,
                                              false); // $allowFrontendEditing
          $this->linkShowCategory = $getLinkCategory;

          // -> add Thumbnail
          if($pageThumbnail = $this->createThumbnail($parentPageContent)) {
            $link['thumbnail'] = $pageThumbnail['thumbnail'];
            $link['thumbnailPath'] = $pageThumbnail['thumbnailPath'];
          }

          // add separator to the link
          if($parentPageContent !== end($breadCrumbsArray))
            $link['link'] .= $separator;

          $links[] = $link;
          unset($link);
        }
      }
    }

    // reset the linkActiveClass
    $this->linkActiveClass = $orgLinkActiveClass;

    // return the menu
    return $this->generateMenu($links,$menuTag);
  }
  /**
  * Alias of {@link createBreadCrumbsMenu()}
  * @ignore
  */
  public function createBreadCrumbMenu($id = false, $separator = ' > ', $menuTag = false) {
    // call the right function
    return $this->createBreadCrumbsMenu($id, $separator, $menuTag);
  }
  /**
  * Alias of {@link createBreadCrumbsMenu()}
  * @ignore
  */
  public function createBreadCrumbs($id = false, $separator = ' > ', $menuTag = false) {
    // call the right function
    return $this->createBreadCrumbsMenu($id, $separator, $menuTag);
  }
  /**
  * Alias of {@link createBreadCrumbsMenu()}
  * @ignore
  */
  public function createBreadCrumb($id = false, $separator = ' > ', $menuTag = false) {
    // call the right function
    return $this->createBreadCrumbsMenu($id, $separator, $menuTag);
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
  * @uses Feidnura::$titlePageDateSeparator
  * @uses Feindura::$titleShowCategory
  * @uses Feindura::$titleCategorySeparator
  *
  * @uses FeinduraBase::getIdsFromString()       to load the right page and category IDs depending on the $ids parameter
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

    if($ids = $this->getIdsFromString($id)) {

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
  * Returns an array which contains all elements of the page, ready for displaying in a HTML-page.
  *
  * In case the page doesn't exists or is not public and the {@link Feindura::$showErrors} property is TRUE,
  * an error will be placed in the ['content'] part of the returned array,
  * otherwiese it returns an empty array.<br>
  *
  * <b>Note</b>: If the <var>$id</var> parameter is empty or FALSE it uses the {@link Feindura::$page} property.
  *
  * Example usage:
  * {@example showPage.example.php}
  *
  * Example of the returned array:
  * {@example generatePage.return.example.php}
  *
  *
  * @param int|string|array|bool $id           (optional) a page ID, array with page and category ID, or a string/array with "previous","next","first","last" or "random". If FALSE it uses the {@link Feindura::$page} property.<br><i>See Additional -> $id parameter example</i>
  * @param int|array|bool        $shortenText  (optional) number of the maximal text length displayed, adds a "more" link at the end or FALSE to not shorten. You can also pass an array: value 1: text length as int, value 2: text string for the link, or a link string.  e.g. array(23,false), array(23,'read more'), or array(23,'<a href="%href%"'>read more</a>'). (the <var>%href%</var> will be replaced by the pages href)
  * @param bool|string           $useHtml      (optional) whether the content of the page has HTML-tags or not. It also accepts a string with allowed html tags.
  *
  * @uses Feindura::$page
  *
  * @uses Feindura::$xHtml
  * @uses Feindura::$showErrors
  * @uses Feindura::$errorTag
  *
  * @uses Feindura::$titleLength
  * @uses Feindura::$titleAsLink
  * @uses Feindura::$titleShowPageDate
  * @uses Feindura::$titlePageDateSeparator
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
  * @uses FeinduraBase::getIdsFromString()                to load the right page and category IDs depending on the $ids parameter
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
  * @version 1.0.1
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.0.1 fixed display of error, was not working anymore
  *    - 1.0 initial release
  *
  */
  public function showPage($id = false, $shortenText = false, $useHtml = true) {

    $ids = $this->getIdsFromString($id);
    $page = $ids[0];
    $category = $ids[1];

    // ->> load SINGLE PAGE
    // *******************
    if($generatedPage = $this->generatePage($page,$this->showErrors,$shortenText,$useHtml)) {
      // -> returns the generated page
      return $generatedPage;
    } else
      return false;
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
  * @param int|string|bool       $ids          a page ID, or a string/array with "previous","next","first","last" or "random". If FALSE it uses the {@link Feindura::$page} property. (See examples) (can also be a $pageContent array)
  *
  * @uses Feindura::$page
  * @uses Feindura::showPlugins()                      to check for the activated plugins
  * @uses FeinduraBase::getIdsFromString()       to load the right page and category IDs depending on the $ids parameter
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
  * Example usage:
  * {@example showPlugins.example.php}
  *
  * Example of the returned array:
  * {@example showPlugins.array.example.php}
  *
  *
  * @param string|array|true      $plugins      (optional) the plugin name or an array with plugin names or TRUE to load all plugins. If its a plugin name and you want the plugin number 2. etc, you need to add the plugin number like "imageGallery#2".
  * @param int|string|array|bool  $id           (optional) a page ID, array with page and category ID, or a string/array with "previous","next","first","last" or "random". If FALSE it uses the {@link Feindura::$page} property.<br><i>See Additional -> $id parameter example</i>
  * @param string|false           $divStyles    (optional) a string with styles, which will be add to the warapping div of the plugin. In the format: "witdh: 200px; height: 100px;"
  * @param bool                   $returnPlugin (optional) whether the plugin is returned, or only a boolean to check if the plugin is available for that page (used by {@link Feindura::hasPlugins()})
  *
  * @uses Feindura::$page
  *
  * @uses FeinduraBase::getIdsFromString()       to load the right page and category IDs depending on the $ids parameter
  * @uses FeinduraBase::generatePage()                 to generate the array with the page elements
  *
  * @uses GeneralFunctions::getPageCategory()          to get the category of the page
  *
  * @return array|string|false If a single plugin name is given it returns the plugins HTML-code, ready to display in a HTML-page, otherwise array with plugins, an empty array, or FALSE if the plugin(s) or page doesn't exist or the page is not public
  *
  * @see getPageTitle()
  * @see FeinduraBase::generatePage()
  *
  * @example id.parameter.example.php $id parameter example
  *
  * @access public
  * @version 1.1
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.1 add plugin numbers, to be able to add multile plugins of the same type
  *    - 1.0 initial release
  *
  */
 public function showPlugins($plugins = true, $id = false, $divStyles = false, $returnPlugin = true) {

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

    if($ids = $this->getIdsFromString($id)) {

      // LOAD the $pageContent array
      if(($pageContent = GeneralFunctions::readPage($ids[0],$ids[1])) !== false) {

        // ->> LOAD the PLUGINS and return them
        if(($pageContent['category'] == 0 || $this->categoryConfig[$pageContent['category']]['public']) && $pageContent['public'] && $this->categoryConfig[$pageContent['category']]['plugins']) {
          if(is_array($pageContent['plugins'])) {

            foreach($pageContent['plugins'] as $pluginName => $pagePlugins) {
              foreach($pagePlugins as $pluginNumber => $pluginContent) {
                // go through all plugins and load the required ones
                if($pluginContent['active'] && // check if activated in the page
                   (is_bool($plugins) || ($pluginNumber == 0 && in_array($pluginName,$plugins)) || ($pluginNumber == 1 && in_array($pluginName,$plugins)) || in_array($pluginName.'#'.$pluginNumber,$plugins))) { // is in the requested plugins array

                  if($returnPlugin) {

                    // -> PROVIDE VARS for INSIDE the PLUGIN
                    $feindura         = $this;
                    $feinduraBaseURL  = $this->adminConfig['url'].GeneralFunctions::Path2URI($this->adminConfig['basePath']);
                    $feinduraBasePath = $this->adminConfig['basePath'];
                    $pluginBaseURL    = $this->adminConfig['url'].GeneralFunctions::Path2URI($this->adminConfig['basePath']).'plugins/'.$pluginName.'/';
                    $pluginBasePath   = $this->adminConfig['basePath'].'plugins/'.$pluginName.'/';
                    $pluginConfig     = $pluginContent;
                    //$pluginName
                    //$pluginNumber
                    //$pageContent


                    // remove the active value from the plugin config
                    unset($pluginConfig['active'],$pluginContent,$plugin);

                    // -> include the plugin
                    ob_start();
                      include(dirname(__FILE__).'/../../plugins/'.$pluginName.'/plugin.php');
                      $pluginReturn = ob_get_contents();
                    ob_end_clean();

                    // FALLBACK to support DEPRECATED plugins which use: return $plugin
                    if(isset($plugin))
                      $pluginReturn .= $plugin;

                    // -> add div around the plugin
                    // $divStyles = (is_string($divStyles)) ? ' style="'.$divStyles.'"' : ''; // DEACTIVATED dont add the styles from the plugin placeholder
                    $pluginReturn = '<div class="feinduraPlugins feinduraPlugin_'.$pluginName.'" id="feinduraPlugin_'.$pluginName.'_'.$pageContent['id'].'"'.$divStyles.'>'.$pluginReturn.'</div>';

                    // add plugin stylesheets
                    $pluginReturn = GeneralFunctions::addStylesheetsInBody($pluginBasePath).$pluginReturn;

                    if($singlePlugin) {
                      return $pluginReturn;
                    } else
                      $pluginsReturn[$pluginName] = $pluginReturn;

                  } else
                    $pluginsReturn = true;
                }
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
  * 3 (means 3 pages in category 1 have the 'example tag')
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
  * List pages by given category(ies) or page(s).
  *
  *
  * Returns an array with multiple pages for displaying in a HTML-page.
  *
  * In case no page with the given category or page ID(s) exist it returns an empty array.
  *
  * <b>Note</b>: If the <var>$ids</var> parameter is FALSE it uses the {@link Feindura::$page} or {@link Feindura::$category} property depending on the <var>$idType</var> parameter.
  *
  *
  * Example usage:
  * {@example listPages.example.php}
  *
  * Example of the returned array:
  * {@example listPages.return.example.php}
  *
  *
  * @param string         $idType             (optional) the ID(s) type can be "cat", "category", "categories" or "pag", "page" or "pages"
  * @param int|array|bool $ids                (optional) the category or page ID(s), can be a number or an array with numbers (can also be a $pageContent array), if TRUE it loads all pages, if FALSE it uses the {@link Feindura::$page} or {@link Feindura::$category} property
  * @param int|array|bool $shortenText        (optional) number of the maximal text length displayed, adds a "more" link at the end or FALSE to not shorten. You can also pass an array: value 1: text length as int, value 2: text string for the link, or a link string.  e.g. array(23,false), array(23,'read more'), or array(23,'<a href="%href%"'>read more</a>'). (the <var>%href%</var> will be replaced by the pages href)
  * @param bool|string    $useHtml            (optional) whether the content of the page has HTML-tags or not. It also accepts a string with allowed html tags.
  * @param bool           $sortPages          (optional) if TRUE it sorts the pages like they are sorted in the backend, if FALSE they are sorted in the order of the given IDs. Can also be a sort function e.g. "sortByLastSaveDate". See {@link GeneralFunctions::sortPages()} for more.
  * @param bool           $reverseList        (optional) if TRUE the pages sorting will be reversed
  *
  *
  * @uses Feindura::$xHtml
  * @uses Feindura::$showErrors
  * @uses Feindura::$errorTag
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
  * @uses FeinduraBase::generatePage()            to generate every page which will be listed
  * @uses GeneralFunctions::sortPages()       to sort the $pageContent arrays by category
  *
  * @return array array with page arrays,containing content and title etc., ready to display in a HTML-page, or an empty array
  *
  * @see Feindura::showPage()
  * @see Feindura::listSubPages()
  * @see Feindura::listPagesByTags()
  * @see Feindura::listPagesByDate()
  *
  * @access public
  * @version 1.0
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.0 initial release
  *
  */
  public function listPages($idType = 'category', $ids = false, $shortenText = false, $useHtml = true, $sortPages = false, $reverseList = false) {

    // vars
    $return = array();

    $ids = $this->getPropertyIdsByType($idType,$ids);

    // LOADS the PAGES BY TYPE
    $pages = $this->loadPagesByType($idType,$ids);


    // -> SORT PAGES
    // sorts by CATEGORIES like in the backend
    if($sortPages === true) {
      $pages = GeneralFunctions::sortPages($pages);

    // sort by given sort function
    } elseif(is_string($sortPages) && function_exists($sortPages))
      usort($pages,$sortPages);

    // -> flips the pages array if $reverseList === true
    if($reverseList === true)
      $pages = array_reverse($pages);


    if(!empty($pages)) {

      // -> list a category(ies)
      // ------------------------------
      $countPages = 1;
      foreach($pages as $pageContent) {
        // show the pages
        if($page = $this->generatePage($pageContent,false,$shortenText,$useHtml)) {

          // adds the position
          if($countPages == 1)
            $page['position']            = 'first';
          elseif($countPages == count($pages))
            $page['position']            = 'last';
          else
            $page['position']            = $countPages;

          // add generated Pages to array
          if($page['error'] === false)
            $return[] = $page;

          $countPages++;
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
  public function listPage($idType = 'category', $id = false, $shortenText = false, $useHtml = true, $sortPages = false, $reverseList = false) {
    // call the right function
    return $this->listPages($idType, $id, $shortenText, $useHtml, $sortPages,$reverseList);
  }

/**
  * <b>Name</b> listSubPages()<br>
  * <b>Alias</b> listSubPage()<br>
  *
  * <b>This method uses the {@link Feindura::$showErrors $error...}, {@link Feindura::$titleLength $title...} and {@link Feindura::$thumbnailAlign $thumbnail...} properties.</b>
  *
  * List pages of the subcategory of a given page.
  *
  * Returns an array with multiple pages for displaying in a HTML-page.<br>
  * In case no page with the given category or page ID(s) exist it returns an empty array.
  *
  * <b>Note</b>: If the <var>$id</var> parameter is FALSE or empty, it uses the current page (means the {@link Feindura::$page} property).<br>
  * b>Note</b>: It will add the {@link Feindura::$linkActiveClass} property as a CSS class to the link (and also its wrapping element, e.g. <li> or <td>), when the links page is matching the current page, or the current page is a sub page of the links page.
  *
  * Example:
  * {@example listSubPages.example.php}
  *
  * Example of the returned Array:
  * {@example listPages.return.example.php}
  *
  *
  * @param int|string|array|bool  $id                 (optional) a page ID, array with page and category ID, or a string/array with "previous","next","first","last" or "random". If FALSE it uses the {@link Feindura::$page} property.<br><i>See Additional -> $id parameter example</i>
  * @param int|array|bool         $shortenText        (optional) number of the maximal text length displayed, adds a "more" link at the end or FALSE to not shorten. You can also pass an array: value 1: text length as int, value 2: text string for the link, or a link string.  e.g. array(23,false), array(23,'read more'), or array(23,'<a href="%href%"'>read more</a>'). (the <var>%href%</var> will be replaced by the pages href)
  * @param bool|string            $useHtml            (optional) whether the content of the page has HTML-tags or not. It also accepts a string with allowed html tags.
  * @param bool                   $sortPages          (optional) if TRUE it sorts the pages like they are sorted in the backend, if FALSE they are sorted in the order of the given IDs. Can also be a sort function e.g. "sortByLastSaveDate". See {@link GeneralFunctions::sortPages()} for more.
  * @param bool                   $reverseList        (optional) if TRUE the pages sorting will be reversed
  *
  *
  * @uses Feindura::$xHtml
  * @uses Feindura::$showErrors
  * @uses Feindura::$errorTag
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
  * @uses Feindura::listPages()    to get the pages
  *
  * @return array array with page arrays of the subcategory,containing content and title etc., ready to display in a HTML-page, or an empty array
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
  public function listSubPages($id = false, $shortenText = false, $useHtml = true, $sortPages = false, $reverseList = false) {

    if($ids = $this->getIdsFromString($id)) {
      // loads the $pageContent array
      if(($pageContent = GeneralFunctions::readPage($ids[0],$ids[1])) !== false) {
        // return subcategory
        if(is_numeric($pageContent['subCategory']) && $this->categoryConfig[$pageContent['category']]['showSubCategory'])
          return $this->listPages('category', $pageContent['subCategory'], $shortenText, $useHtml, $sortPages,$reverseList);
      }
    }

    return array();
  }
 /**
  * Alias of {@link listSubPages()}
  * @ignore
  */
  public function listSubPage($id = false, $shortenText = false, $useHtml = true, $sortPages = false, $reverseList = false) {
    // call the right function
    return $this->listSubPages($id, $shortenText, $useHtml, $sortPages,$reverseList);
  }

/**
  * <b>Name</b> listSubCategory()<br>
  * <b>Alias</b> listPagesOfSubCategory()<br>
  * <b>Alias</b> listPagesFromSubCategory()<br>
  *
  * <b>This method uses the {@link Feindura::$showErrors $error...}, {@link Feindura::$titleLength $title...} and {@link Feindura::$thumbnailAlign $thumbnail...} properties.</b>
  *
  * List the pages of a subcategory.<br>
  * In case no category with the given page ID exist, or it is not a subcategory it returns an empty array.<br>
  *
  *
  * <b>Note</b>: If the <var>$id</var> parameter is FALSE or empty, it uses the current category (means the {@link Feindura::$category} property).<br>
  *
  *
  * You can use this function in conjunction with {@link Feindura::listSubPages()} to list subpages,
  * even if you're in a page of the subcategory.
  * <code>
  * <?php
  *
  * // we use "false", because we use the current page and category. The 200 is the number of maximum characters we want to display.
  * // NOTE: we need the double (), otherwise it would use the assignment of the $subMenu variable as condition!
  * if(($subPages = $feindura->listSubPages(false,200)) || // will list the subpages when inside the page which has a subcategory
  *    ($subPages = $feindura->listPagesOfSubCategory(false,200))) { // will list the subpages when inside a page within a subcategory
  *
  *   foreach($subPages as $subPage) {
  *     echo '<h1>'.$subPage['title'].'</h1>';
  *     echo $subPage['content'];
  *   }
  * }
  *
  * ?>
  * </code>
  *
  * Example of the returned Array:
  * {@example listPages.return.example.php}
  *
  *
  * @param int|string|bool $categoryId         (optional) a category ID, or a string with "previous","next","first","last" or "random". If FALSE it uses the {@link Feindura::$category} property.
  * @param int|array|bool  $shortenText        (optional) number of the maximal text length displayed, adds a "more" link at the end or FALSE to not shorten. You can also pass an array: value 1: text length as int, value 2: text string for the link, or a link string.  e.g. array(23,false), array(23,'read more'), or array(23,'<a href="%href%"'>read more</a>'). (the <var>%href%</var> will be replaced by the pages href)
  * @param bool|string     $useHtml            (optional) whether the content of the page has HTML-tags or not. It also accepts a string with allowed html tags.
  * @param bool            $sortPages          (optional) if TRUE it sorts the pages like they are sorted in the backend, if FALSE they are sorted in the order of the given IDs. Can also be a sort function e.g. "sortByLastSaveDate". See {@link GeneralFunctions::sortPages()} for more.
  * @param bool            $reverseList        (optional) if TRUE the pages sorting will be reversed
  *
  *
  * @uses Feindura::$xHtml
  * @uses Feindura::$showErrors
  * @uses Feindura::$errorTag
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
  * @uses Feindura::listPages()    to get the pages
  *
  * @return array array with page arrays of the subcategory,containing content and title etc., ready to display in a HTML-page, or an empty array
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
  public function listSubCategory($categoryId = false, $shortenText = false, $useHtml = true, $sortPages = false, $reverseList = false) {

    if($ids = $this->getIdsFromString(array(false,$categoryId))) {
      $categoryId = $ids[1];
      if($this->isSubCategory($categoryId)) {
        // create subcategory
        if($categoryId && is_numeric($categoryId))
          return $this->listPages('category', $categoryId, $shortenText, $useHtml, $sortPages,$reverseList);
      }
    }

    return array();
  }
  /**
  * Alias of {@link listSubCategory()}
  * @ignore
  */
  public function listPagesFromSubCategory($categoryId = false, $shortenText = false, $useHtml = true, $sortPages = false, $reverseList = false) {
    // call the right function
    return $this->listSubCategory($categoryId, $shortenText, $useHtml, $sortPages,$reverseList);
  }
  /**
  * Alias of {@link listSubCategory()}
  * @ignore
  */
  public function listPagesOfSubCategory($categoryId = false, $shortenText = false, $useHtml = true, $sortPages = false, $reverseList = false) {
    // call the right function
    return $this->listSubCategory($categoryId, $shortenText, $useHtml, $sortPages,$reverseList);
  }

 /**
  * <b>Name</b>     listPagesByTags()<br>
  * <b>Alias</b>    listPagesByTag(), listPageByTags(), listPageByTag()<br>
  *
  * <b>This method uses the {@link Feindura::$showErrors $error...}, {@link Feindura::$titleLength $title...} and {@link Feindura::$thumbnailAlign $thumbnail...} properties.</b>
  *
  * List pages by given category(ies) or page(s), which have one or more of the tags from the given <var>$tags</var> parameter.
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
  * @param int|array|bool $shortenText        (optional) number of the maximal text length displayed, adds a "more" link at the end or FALSE to not shorten. You can also pass an array: value 1: text length as int, value 2: text string for the link, or a link string.  e.g. array(23,false), array(23,'read more'), or array(23,'<a href="%href%"'>read more</a>'). (the <var>%href%</var> will be replaced by the pages href)
  * @param bool|string    $useHtml            (optional) whether the content of the page has HTML-tags or not. It also accepts a string with allowed html tags.
  * @param bool           $sortPages          (optional) if TRUE it sorts the pages like they are sorted in the backend, if FALSE they are sorted in the order of the given IDs. Can also be a sort function e.g. "sortByLastSaveDate". See {@link GeneralFunctions::sortPages()} for more.
  * @param bool           $reverseList        (optional) if TRUE the pages sorting will be reversed
  *
  *
  * @uses Feindura::$xHtml
  * @uses Feindura::$showErrors
  * @uses Feindura::$errorTag
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
  public function listPagesByTags($tags, $idType = 'category', $ids = false, $shortenText = false, $useHtml = true, $sortPages = false, $reverseList = false) {

    $ids = $this->getPropertyIdsByType($idType,$ids);

    // check for the tags and LIST the PAGES
    if($ids = $this->checkPagesForTags($idType,$ids,$tags)) {
      return $this->listPages($idType,$ids,$shortenText,$useHtml,$sortPages,$reverseList);
    } else
      return array();
  }
 /**
  * Alias of {@link listPagesByTags()}
  * @ignore
  */
  public function listPagesByTag($tags, $idType = 'category', $ids = false, $shortenText = false, $useHtml = true, $sortPages = false, $reverseList = false) {
    // call the right function
    return $this->listPagesByTags($tags, $idType, $ids, $shortenText, $useHtml, $sortPages,$reverseList);
  }
 /**
  * Alias of {@link listPagesByTags()}
  * @ignore
  */
  public function listPageByTags($tags, $idType = 'category', $ids = false, $shortenText = false, $useHtml = true, $sortPages = false, $reverseList = false) {
    // call the right function
    return $this->listPagesByTags($tags, $idType, $ids, $shortenText, $useHtml, $sortPages,$reverseList);
  }
 /**
  * Alias of {@link listPagesByTags()}
  * @ignore
  */
  public function listPageByTag($tags, $idType = 'category', $ids = false, $shortenText = false, $useHtml = true, $sortPages = false, $reverseList = false) {
    // call the right function
    return $this->listPagesByTags($tags, $idType, $ids, $shortenText, $useHtml, $sortPages,$reverseList);
  }

 /**
  * <b>Name</b>     listPagesByDate()<br>
  * <b>Alias</b>    listPagesByDates(), listPageByDate(), listPageByDates()<br>
  *
  * <b>This method uses the {@link Feindura::$showErrors $error...}, {@link Feindura::$titleLength $title...} and {@link Feindura::$thumbnailAlign $thumbnail...} properties.</b>
  *
  * List pages by given a category(ies) or page(s) parameter. Applies for pages which have a page date (and page date is activated for that category!) and it fit in the given time period
  * from the <var>$from</var> and the <var>$to</var> parameter (relative to the current date).
  *
  * The <var>$from</var> and <var>$to</var> parameters can also be a string with a (relative or specific) date, for more information see: {@link http://www.php.net/manual/de/datetime.formats.php}.
  *
  * Returns an array with multiple pages for displaying in a HTML-page.
  * In case no page with the given category or page ID(s) exist it returns an empty array.
  *
  * <b>Note</b>: If the <var>$ids</var> parameter is FALSE it uses the {@link Feindura::$page} or {@link Feindura::$category} property depending on the <var>$idType</var> parameter.
  *
  * Example usage:
  * {@example listPagesByTags.example.php}
  *
  * @param int|bool|string $from                  (optional) number of months in the past, if TRUE it show all pages in the past, if FALSE it loads only pages starting from the current date. Can also be a string with a date format (e.g. '2 weeks' or '27.06.2012'), for more details see: {@link http://www.php.net/manual/en/datetime.formats.php}
  * @param int|bool|string $to                    (optional) number of months in the future, if TRUE it show all pages in the future, if FALSE it loads only pages until the current date. Can also be a string with a date format (e.g. '10 days' or '27.06.2012'), for more details see: {@link http://www.php.net/manual/de/datetime.formats.php}
  * @param string          $idType                (optional) the ID(s) type can be "cat", "category", "categories" or "pag", "page" or "pages"
  * @param int|array|bool  $ids                   (optional) the category or page ID(s), can be a number or an array with numbers (can also be a $pageContent array), if TRUE it loads all pages, if FALSE it uses the {@link Feindura::$page} or {@link Feindura::$category} property
  * @param int|array|bool  $shortenText           (optional) number of the maximal text length displayed, adds a "more" link at the end or FALSE to not shorten. You can also pass an array: value 1: text length as int, value 2: text string for the link, or a link string.  e.g. array(23,false), array(23,'read more'), or array(23,'<a href="%href%"'>read more</a>'). (the <var>%href%</var> will be replaced by the pages href)
  * @param bool|string     $useHtml               (optional) whether the content of the page has HTML-tags or not. It also accepts a string with allowed html tags.
  * @param bool            $sortPages             (optional) if TRUE it sorts the pages like they are sorted in the backend, if FALSE it sorts the pages by date (If date range: by start date). Can also be a sort function e.g. "sortByEndDate". See {@link GeneralFunctions::sortPages()} for more.
  * @param bool            $reverseList           (optional) if TRUE the pages sorting will be reversed
  *
  * @uses Feindura::$xHtml
  * @uses Feindura::$showErrors
  * @uses Feindura::$errorTag
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
  public function listPagesByDate($from = true, $to = true, $idType = 'category', $ids = false, $shortenText = false, $useHtml = true, $sortPages = false, $reverseList = false) {

      // gets the right pages and sorted by page date
      $pageContents = $this->loadPagesByDate($from,$to,$idType,$ids,$sortPages,$reverseList);
      if($pageContents !== false)
        return $this->listPages($idType,$pageContents,$shortenText,$useHtml,false,false);
      else
        return array();
  }
 /**
  * Alias of {@link listPagesByDate()}
  * @ignore
  */
  public function listPageByDate($from = true, $to = true, $idType = 'category', $ids = false, $shortenText = false, $useHtml = true, $sortPages = false, $reverseList = false) {
    // call the right function
    return $this->listPagesByDate($from, $to, $idType, $ids, $shortenText, $useHtml,$sortPages, $reverseList);
  }
 /**
  * Alias of {@link listPagesByDate()}
  * @ignore
  */
  public function listPageByDates($from = true, $to = true, $idType = 'category', $ids = false, $shortenText = false, $useHtml = true, $sortPages = false, $reverseList = false) {
    // call the right function
    return $this->listPagesByDate($from, $to, $idType, $ids, $shortenText, $useHtml,$sortPages, $reverseList);
  }
 /**
  * Alias of {@link listPagesByDate()}
  * @ignore
  */
  public function listPagesByDates($from = true, $to = true, $idType = 'category', $ids = false, $shortenText = false, $useHtml = true, $sortPages = false, $reverseList = false) {
    // call the right function
    return $this->listPagesByDate($from, $to, $idType, $ids, $shortenText, $useHtml,$sortPages, $reverseList);
  }

 /**
  * <b>Name</b>     listPagesBySortFunction()<br>
  * <b>Alias</b>    listPagesBySort()<br>
  * <b>Alias</b>    listPagesBySortCallback()<br>
  * <b>Alias</b>    listPagesByCallback()<br>
  *
  * <b>This method uses the {@link $showErrors $error...}, {@link $titleLength $title...} and {@link Feindura::$thumbnailAlign $thumbnail...} properties.</b>
  *
  * List pages from category(ies) or page(s), sorted by a custom sort function, passed in the first parameter <var>$sortCallback</var>.
  * The custom sort function will be executed on the plain <var>$pageContent</var> array returned by the {@link FeinduraBase::loadPagesByType()} method.
  *
  *
  * Returns an array with multiple pages for displaying in a HTML-page.
  *
  * In case no page with the given category or page ID(s) exist it returns an empty array.
  *
  * <b>Note</b>: If the <var>$ids</var> parameter is FALSE it uses the {@link Feindura::$page} or {@link Feindura::$category} property depending on the <var>$idType</var> parameter.
  *
  *
  * Example usage:
  * {@example listPagesBySortFunction.example.php}
  *
  * Example of the returned array:
  * {@example listPages.return.example.php}
  *
  *
  * @param string         $sortCallback       the name of the callback function to sort the pages (uses usort()). For a list of predefined available functions see {@link GeneralFunctions::sortPages()}
  * @param string         $idType             (optional) the ID(s) type can be "cat", "category", "categories" or "pag", "page" or "pages"
  * @param int|array|bool $ids                (optional) the category or page ID(s), can be a number or an array with numbers (can also be a $pageContent array), if TRUE it loads all pages, if FALSE it uses the {@link Feindura::$page} or {@link Feindura::$category} property
  * @param int|array|bool $shortenText        (optional) number of the maximal text length displayed, adds a "more" link at the end or FALSE to not shorten. You can also pass an array: value 1: text length as int, value 2: text string for the link, or a link string.  e.g. array(23,false), array(23,'read more'), or array(23,'<a href="%href%"'>read more</a>'). (the <var>%href%</var> will be replaced by the pages href)
  * @param bool|string    $useHtml            (optional) whether the content of the page has HTML-tags or not. It also accepts a string with allowed html tags.
  * @param bool           $reverseList        (optional) if TRUE the pages sorting will be reversed
  *
  *
  * @uses Feindura::$xHtml
  * @uses Feindura::$showErrors
  * @uses Feindura::$errorTag
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
  * @uses FeinduraBase::generatePage()            to generate every page which will be listed
  * @uses GeneralFunctions::sortPages()           to sort the $pageContent arrays by category
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
      return $this->listPages($idType,$pageContents,$shortenText,$useHtml,false,false);
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
  * <b>Name</b> startCache()<br>
  *
  *
  * This method can cache parts of your script, to speed up page loading time.<br>
  * You need to call {@link Feindura::endCache()} to tell it were the cache part ends.<br>
  * The cache will be resaved after the <var>$timeout</var> parameter is over. The cache will also be deleted when a page is saved in the backend.
  *
  * Because of PHP scope restricions, you need to manually prevent the processing of the original script. See the example for more.
  *
  * <b>Note</b>: This method and the {@link Feindura::endCache()} uses the ob_start() and ob_end_clean() function,
  * if you start a output buffer inside your script which will be cached, make sure to close you output buffer beforec calling {@link Feindura::endCache()}.
  * <b>Note</b>: You cannot nest multiple startCache() calls, this would overwrite the cache of the previous call of startCache().
  *
  * <code>
  *
  * // this will cache the scripts inside the brackets for two hours,
  * // and then recache them again.
  * if(!$feindura->startCache('myScriptCache',2)) {
  *
  * .. your scripts
  *
  * }
  * $feindura->endCache();
  *
  * ..
  *
  *
  * // Since PHP 5.3 you could also write it like this:
  * if($feindura->startCache('myScriptCache',2))
  *   goto usedCache;
  *
  * .. your scripts
  *
  * usedCache:
  * $feindura->endCache();
  *
  * ..
  *
  * </code>
  *
  * @param float  $timeout (optional) the number of hours after whihc the cache should be reloaded
  * @param string $cacheId a unique id to identify the cache e.g "myScriptCache1"
  *
  *
  *
  * @return bool TRUE if the it will output the cached part, FALSE if no cache existed and it was created
  *
  * @see Feindura::endCache()
  *
  * @access public
  * @version 1.0
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.0 initial release
  *
  */
  public function startCache($cacheId ,$timeout = 8) {

    // vars
    $cachedFile = dirname(__FILE__).'/../../pages/cache/scriptCache_'.$cacheId.'.cache';
    $timeoutSec = $timeout * 60 * 60;

    // DebugTools::dump('Time until the next cache reload: '.(filectime($cachedFile) + $timeoutSec - time()).' seconds');

    // SHOW CACHED if exist
    if(file_exists($cachedFile) &&
       ($cachedFileTime = filectime($cachedFile)) + $timeoutSec >= time() ) {

      // load the cached file and display
      if(($cachedScript = file_get_contents($cachedFile)) !== false) {
        echo "\n<!-- Start of Cached Script #".$this->currentScriptCacheNumber."
Cached on ".date('d M Y H:i:s',$cachedFileTime)."
Expires on ".date('d M Y H:i:s',$cachedFileTime + $timeoutSec)."  -->\n".$cachedScript."\n<!-- End of Cached Script #".$this->currentScriptCacheNumber."  -->\n";

        return true;
      } else {
        return false;
      }

    // GENERATE CACHE
    } else {

      // create cache folder
      if(!is_dir(dirname(__FILE__).'/../../pages/cache'))
        @mkdir(dirname(__FILE__).'/../../pages/cache');

      ob_start();
      $this->cachedScriptCache = $cacheId;
    }

    return false;
  }


  /**
  * <b>Name</b> endCache()<br>
  *
  * This method writes the cache, which was started with {@link Feidnura::startCache()}. It will save the last started cache.
  * See the {@link Feidnura::startCache()} method for more.
  *
  *
  * @return void
  *
  * @see Feindura::endCache()
  *
  * @access public
  * @version 1.0
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.0 initial release
  *
  */
  public function endCache() {

    if($this->cachedScriptCache !== false) {
      $scriptCache = ob_get_contents();
      ob_end_flush();
      @file_put_contents(dirname(__FILE__).'/../../pages/cache/scriptCache_'.$this->cachedScriptCache.'.cache', $scriptCache, LOCK_EX);
    }

    $this->cachedScriptCache = false;
  }
}