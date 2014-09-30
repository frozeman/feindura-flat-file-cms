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
* @version 1.6
* <br>
* <b>ChangeLog</b><br>
*    - 1.6 add createMenu()
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
  * An array with country codes and language names.
  *
  * Example array
  * <samp>
  * array(
  *  'ae' => 'Avestan',
  *  'af' => 'Afrikaans',
  *  'de' => 'German',
  *  'en' => 'English',
  *   ...
  * </samp>
  *
  *
  * @var array
  * @access public
  * @see Feindura::createLanguageMenu()
  * @see FeinduraBase()
  *
  */
  public $languageNames = array();

 /**
  * Contains the frontend language-file array
  *
  * The frontend language file array contains texts for displaying page <i>warnings</i> or <i>errors</i> and additional texts like <i>"more"</i>, etc.<br>
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
  * <b> Type</b>      constructor<br>
  *
  * The constructor of the class, sets all basic properties.
  *
  * First gets all settings config <var>arrays</var> and external classes.<br>
  * Then Check if the visitor is a logged in user of the feindura backend and set the {@link FeinduraBase::$loggedIn} property.
  * Then set the <var>$_GET</var> variable names from the {@link FeinduraBase::$adminConfig administrator-settings config} to the {@link $varNames} property.<br>
  * Check if cookies are activated, otherwise store the session ID in the {@link $sessionId} property for use in links.<br>
  * Get the the given <var>$language</var> parameter or try to find the browser language and load the frontend language-file and set it to the {@link Feindura::$languageFile} property.
  *
  *
  * <b>Used Global Variables</b><br>
  *    - <var>$adminConfig</var> the administrator-settings config (included in the {@link general.include.php})
  *    - <var>$websiteConfig</var> the website-settings config (included in the {@link general.include.php})
  *    - <var>$categoryConfig</var> the categories-settings config (included in the {@link general.include.php})
  *
  *
  * @param string $language (optional) A language code "de", "en", ... to load the right frontend language-file and it will be set to the {@link Feindura::$language} property
  *
  * @uses $adminConfig                            the administrator-settings config array will set to this property
  * @uses $websiteConfig                          the website-settings config array will set to this property
  * @uses $categoryConfig                         the category-settings config array will set to this property
  * @uses $loggedIn                               to set whether the visitor is logged in or not
  * @uses $varNames                               the variable names from the administrator-settings config will set to this property
  * @uses $sessionId                              the session ID string will set to this property, if cookies are deactivated
  * @uses $language                               to set the given $language parameter to, or try to get the browser language automatically
  * @uses $languageFile                           set the loaded frontend language-file to this property
  * @uses StatisticFunctions::saveWebsiteStats()  save the website statistic like user visit count, first and last visit AND the visit time of the last visited pages
  *
  * @return void
  *
  * @example includeFeindura.example.php
  *
  * @access protected
  * @version 1.1
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.1 moved languages to the Feindura constructor
  *    - 1.0 initial release
  *
  */
  protected function __construct($language = false) {

    // GET CONFIG FILES and SET CONFIG PROPERTIES
    $this->adminConfig = (isset($GLOBALS['feindura_adminConfig'])) ? $GLOBALS['feindura_adminConfig'] : $GLOBALS['adminConfig'];
    $this->websiteConfig = (isset($GLOBALS['feindura_websiteConfig'])) ? $GLOBALS['feindura_websiteConfig'] : $GLOBALS['websiteConfig'];
    $this->categoryConfig = (isset($GLOBALS['feindura_categoryConfig'])) ? $GLOBALS['feindura_categoryConfig'] : $GLOBALS['categoryConfig'];
    // SETs the language names
    $this->languageNames = $GLOBALS['feindura_languageNames'];

  }


 /* ---------------------------------------------------------------------------------------------------------------------------- */
 /* *** METHODS *** */
 /* **************************************************************************************************************************** */

 /**
  * <b> Name</b> getParentPages()<br>
  *
  * Returns an array with the parent pages of given subcategory.
  * If the given category ID is not a sub category of any page, it will return an empty array.
  *
  * <b>Note</b>: If the <var>$categoryId</var> parameter is FALSE or empty, it uses the current page (means the {@link Feindura::$page} property).<br>
  *
  * @param int|string|bool $categoryId (optional) a category ID, or a string with "previous","next","first","last" or "random". If FALSE it uses the {@link Feindura::$category} property.
  *
  * @return array|false an array with the parent pages in the order from the current category on, or FALSE if this category is not a subcategory
  *
  * @see GeneralFunctions::getParentPages
  *
  * @access public
  * @version 1.0
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.0 initial release
  *
  */
  public function getParentPages($categoryId = false) {

    if($ids = $this->getIdsFromString(array(false,$categoryId))) {
      $categoryId = $ids[1];
      return GeneralFunctions::getParentPages($categoryId);
    }
    return false;
  }

 /**
  * <b> Name</b>      getCurrentPageId()<br>
  * <b> Alias</b>     getPageId()<br>
  *
  * Returns the current page ID from the <var>$_GET</var> variable.
  *
  * Gets the current page ID from the <var>$_GET</var> variable.
  * If <var>$_GET</var> is not a ID but a page name, it loads all pages in an array and look for the right page name and returns the ID.
  * If no <var>$_GET</var> variable exists try to return the {@link Feindura::$startPage} property.
  *
  *
  * <b>Used Global Variables</b><br>
  *    - <var>$_GET</var> to fetch the page ID
  *
  * @uses StatisticFunctions::getCurrentPageId() to get the current page id
  *
  *
  * @return int|false the current page ID or FALSE
  *
  * @access public
  * @version 1.2
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.2 moved method to StatisticFunctions
  *    - 1.1 add localization
  *    - 1.0 initial release
  *
  */
  public function getCurrentPageId() {
    return StatisticFunctions::getCurrentPageId($this->startPage,$this->category);
  }
 /**
  * Alias of {@link getCurrentPageId()}
  * @ignore
  */
  public function getPageId() {
    // call the right function
    return $this->getCurrentPageId();
  }

 /**
  * <b> Name</b>      getCurrentCategoryId()<br>
  * <b> Alias</b>     getCategoryId()<br>
  *
  * Returns the current category ID from the <var>$_GET</var> variable.
  *
  * Gets the current category ID from the <var>$_GET</var> variable.
  * If <var>$_GET</var> is not a ID but a category name, it look in the {@link FeinduraBase::$categoryConfig} for the right category ID.
  * If no <var>$_GET</var> variable exists it try to return the {@link Feindura::$startPage} property.
  *
  *
  * <b>Used Global Variables</b><br>
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
  * @version 1.1
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.1 add localization
  *    - 1.0 initial release
  *
  */
  public function getCurrentCategoryId() {
    return StatisticFunctions::getCurrentCategoryId($this->startCategory);
  }
 /**
  * Alias of {@link getCurrentCategoryId()}
  * @ignore
  */
  public function getCategoryId() {
    // call the right function
    return $this->getCurrentCategoryId();
  }


 /**
  * <b>Name</b> loadPagesByType()<br>
  *
  * Load pages by ID-type and ID(s).
  *
  * If the <var>$idType</var> parameter start with "cat" it takes the given <var>$ids</var> parameter as category IDs.<br>
  * If the <var>$idType</var> parameter start with "pag" it takes the given <var>$ids</var> parameter as page IDs.<br>
  * While it is not important that whether the <var>$idType</var> parameter is written in plural or singular.
  * The <var>$ids</var> parameter is automaticly checked whether its an array with IDs or a single ID.
  *
  * Example of the returned $pageContent array: (<b>Note</b> This array will be wraped in another array, not shown here)
  * {@example readPage.return.example.php}
  *
  * @param string         $idType           the ID(s) type can be "cat", "category", "categories" or "pag", "page" or "pages"
  * @param int|array|bool $ids              the category or page ID(s), can be a number or an array with numbers, if TRUE it loads all pages
  *
  * @uses isPageContentArray()                     to check if the given array is a $pageContent array, if TRUE it just returns this array
  * @uses GeneralFunctions::isPublicCategory()     to check if the category(ies) or page(s) category(ies) are public
  * @uses GeneralFunctions::loadPages()            to load pages
  * @uses GeneralFunctions::readPage()             to load a single page
  * @uses GeneralFunctions::getPageCategory()      to get the category of the page
  *
  * @return array|false an array with $pageContent array(s)
  *
  * @access public
  * @version 1.0
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.0 initial release
  *
  */
  public function loadPagesByType($idType, $ids) {

    // vars
    $return = false;
    $idType = strtolower($idType);
    $shortIdType = substr($idType,0,3);

    // -> category ID(s)
    // ***************
    if($shortIdType === 'cat') {
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
    } elseif($shortIdType === 'pag') {

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
  * <b>Name</b> loadPagesMetaDataByType()<br>
  *
  * Filters the {@link GeneralFunctions::$pagesMetaData} by ID-type and ID(s).
  *
  * If the <var>$idType</var> parameter start with "cat" it takes the given <var>$ids</var> parameter as category IDs.<br>
  * If the <var>$idType</var> parameter start with "pag" it takes the given <var>$ids</var> parameter as page IDs.<br>
  * While it is not important that whether the <var>$idType</var> parameter is written in plural or singular.
  * The <var>$ids</var> parameter is automaticly checked whether its an array with IDs or a single ID.
  *
  * @param string         $idType           the ID(s) type can be "cat", "category", "categories" or "pag", "page" or "pages"
  * @param int|array|bool $ids              the category or page ID(s), can be a number or an array with numbers, if TRUE it loads all pages
  *
  * @uses GeneralFunctions::isPublicCategory()     to check if the category(ies) or page(s) category(ies) are public
  * @uses GeneralFunctions::getPageCategory()      to get the category of the page
  * @uses GeneralFunctions::$pagesMetaData
  *
  * @return array|false the filtered $pagesMetaData array, or FALSE
  *
  * @access public
  * @version 1.0
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.0 initial release
  *
  */
  public function loadPagesMetaDataByType($idType, $ids) {

    // vars
    $return = false;
    $idType = strtolower($idType);
    $shortIdType = substr($idType,0,3);

    // -> category ID(s)
    // ***************
    if($shortIdType === 'cat') {
      if($ids === true || is_array($ids) || is_numeric($ids)) {

          // checks if the categories are public
          if(($ids = GeneralFunctions::isPublicCategory($ids)) !== false) {

            if(is_numeric($ids))
              $ids = array($ids);

            // returns all pagesMetaData fo public categories
            foreach(GeneralFunctions::$pagesMetaData as $pageMetaData) {
              if(in_array($pageMetaData['category'], $ids))
                $return[] = $pageMetaData;
            }

          } else return false;
      } else return false;

    // ->> if PAGE ID(s)
    // **************************
    } elseif($shortIdType === 'pag') {

      // -----------------------------------------
      // ->> load all pages
      // ***************
      if($ids === true) {

        // checks if the categories are public
        if(($ids = GeneralFunctions::isPublicCategory($ids)) !== false) {
          // returns all pagesMetaData fo public categories
          foreach(GeneralFunctions::$pagesMetaData as $pageMetaData) {
            if(in_array($pageMetaData['category'], $ids))
              $return[] = $pageMetaData;
          }
        }

      // -----------------------------------------
      // ->> pages IDs
      // ***************
      } elseif($ids && is_array($ids)) {

        // loads all pagesMetaData with given ids
        foreach($ids as $pageId) {
          $return[] = GeneralFunctions::$pagesMetaData[$pageId];
        }

      // -----------------------------------------
      // ->> single page ID
      // ***************
      } elseif($ids && is_numeric($ids)) {
        // loads the single pageMetaData in an array
        $return[] = GeneralFunctions::$pagesMetaData[$ids];

      } else return false;
    }

    // -> returns an array with the pageContent Arrays
    return $return;
  }

 /**
  * <b>Name</b> loadPagesByDate()<br>
  *
  * Loads pages by ID-type and ID, which fit in the given time period parameters.
  *
  * Checks if the pages to load have a page date
  * and the page date fit in the given <var>$from</var> and <var>$to</var> parameters.
  * All time period parameters are compared against the current date.
  *
  * The <var>$from</var> and <var>$to</var> parameters can also be a string with a (relative or specific) date, for more information see: {@link http://www.php.net/manual/de/datetime.formats.php}.
  *
  * @param string          $idType                the ID(s) type can be "cat", "category", "categories" or "pag", "page" or "pages"
  * @param int|array|bool  $ids                   the category or page ID(s), can be a number or an array with numbers, if TRUE it loads all pages
  * @param int|bool|string $from                  (optional) number of months in the past, if TRUE it show all pages in the past, if FALSE it loads only pages starting from the current date. Can also be a string with a date format (e.g. '2 weeks' or '27.06.2012'), for more details see: {@link http://www.php.net/manual/en/datetime.formats.php}
  * @param int|bool|string $to                    (optional) number of months in the future, if TRUE it show all pages in the future, if FALSE it loads only pages until the current date. Can also be a string with a date format (e.g. '10 days' or '27.06.2012'), for more details see: {@link http://www.php.net/manual/de/datetime.formats.php}
  * @param bool            $sortPages             (optional) if TRUE it sorts the pages like they are sorted in the backend, if FALSE it sorts the pages by date (If date range: by start date). Can also be a sort function e.g. "sortByEndDate". See {@link GeneralFunctions::sortPages()} for more.
  * @param bool            $reverseList           (optional) if TRUE the pages sorting will be reversed
  *
  * @uses $categoryConfig                 to check if in the category is sorting by page date allowed
  * @uses getPropertyIdsByType()          to get the property IDs if the $ids parameter is FALSE
  * @uses loadPagesByType()               load the pages depending on the type
  * @uses changeDate()                    change the current date minus or plus the months from specified in the parameters
  * @uses gernalFunctions::sortPages()    to sort the pages by page date
  *
  * @return array|false an array with the $pageContent arrays or FALSE if no page has a page date or is allowed for sorting
  *
  * @link http://www.php.net/manual/de/datetime.formats.php
  *
  * @see Feindura::listPagesByDate()
  * @see Feindura::createMenuByDate()
  *
  * @access public
  * @version 1.0.1
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.0.1 fixed timezone when using strtotime
  *    - 1.0 initial release
  *
  */
  public function loadPagesByDate($from = true, $to = true, $idType, $ids, $sortPages = false, $reverseList = false) {

    if(!is_bool($from) && is_numeric($from))
      $from = round($from);
    if(!is_bool($to) && is_numeric($to))
      $to = round($to);
    $ids = $this->getPropertyIdsByType($idType,$ids);

    // LOADS the PAGES BY TYPE
    if($pages = $this->loadPagesByType($idType,$ids)) {

      // creates the current date to compare with
      $currentDate = time();

      $pastDate = false;
      $futureDate = false;

      // creates the PAST DATE
      if(!is_bool($from) && is_string($from) && !is_numeric($from))
        $pastDate = strtotime($from,$currentDate);
      elseif(!is_bool($from) && is_numeric($from))
        $pastDate = strtotime('-'.$from.' month',$currentDate);
      elseif($from === false)
        $pastDate = $currentDate;

      // creates the FUTURE DATE
      if(!is_bool($to) && is_string($to) && !is_numeric($to))
        $futureDate = strtotime($to,$currentDate);
      if(!is_bool($to) && is_numeric($to))
        $futureDate = strtotime('+'.$to.' month',$currentDate);
      elseif($to === false)
        $futureDate = $currentDate;

      // echo 'Today: '.date('d-m-Y',$currentDate).'<br>';
      // echo 'pastDate: '.date('d-m-Y',$pastDate).'<br>';
      // echo 'futureDate: '.date('d-m-Y',$futureDate).'<br><br>';

      // convert to number date e.g. 20010911
      $pastDate = date('Ymd',$pastDate);
      $futureDate = date('Ymd',$futureDate);

      // CHECK IF PAGE FITS in the given TIME PERIOD
      $selectedPages = array();
      foreach($pages as $page) {

        // show the pages, if page date is activated
        if($this->categoryConfig[$page['category']]['showPageDate']) {

          // DATE RANGE
          if($this->categoryConfig[$page['category']]['pageDateAsRange'] && !empty($page['pageDate']['end'])) {

            // BOTH dates EXIST
            if(!empty($page['pageDate']['start'])) {

              // convert to number date e.g. 20120911
              $pageDateStart = date('Ymd',$page['pageDate']['start']);
              $pageDateEnd   = date('Ymd',$page['pageDate']['end']);
              // compare
              if(($from === true || ($pageDateStart >= $pastDate) || ($pageDateStart < $pastDate && $pageDateEnd >= $pastDate)) &&
                 ($to === true || ($pageDateEnd <= $futureDate) || ($pageDateEnd > $futureDate && $pageDateStart <= $futureDate)))
                $selectedPages[] = $page;


            // ONLY LAST date EXIST (unlikely)
            } else {
              // convert to number date e.g. 20120911
              $pageDateEnd = date('Ymd',$page['pageDate']['end']);
              // compare
              if(($from === true || $pageDateEnd >= $pastDate) &&
                 ($to === true || $pageDateEnd <= $futureDate))
                $selectedPages[] = $page;
            }

          // SINGLE DATE
          } elseif(!empty($page['pageDate']['start'])) {

            // convert to number date e.g. 20120911
            $pageDate = date('Ymd',$page['pageDate']['start']);
            // compare
            if(($from === true || $pageDate >= $pastDate) &&
               ($to === true || $pageDate <= $futureDate))
              $selectedPages[] = $page;
          }
        }
      }

      // -> SORT PAGES
      // sorts by DATE and CATEGORIES
      if($sortPages === true) {
        $selectedPages = GeneralFunctions::sortPages($selectedPages);

      // sort by given sort function
      } elseif(is_string($sortPages) && function_exists($sortPages)) {
        usort($selectedPages,$sortPages);

      // sort by DATE
      } else {
        usort($selectedPages,'sortByStartDate');
      }

      // -> flips the pages array if $reverseList === true
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


 /* PROTECTED METHODS */

 /**
  * <b>Name</b>     setCurrentPageId()<br>
  * <b>Alias</b>    setPageId()<br>
  *
  * Sets the current page ID from the <var>$_GET</var> variable to the {@link Feindura::$page} property.
  *
  * Gets the current page ID from the <var>$_GET</var> variable (through {@link getCurrentPageId}) and set it to the {@link Feindura::$page} property.
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
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.0 initial release
  *
  */
  protected function setCurrentPageId($setStartPage = false) {

    // sets the startPage if it exists
    if($setStartPage === true && !empty($this->websiteConfig['startPage'])) { //empty($this->category)
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
  * <b>Name</b>     setCurrentCategoryId()<br>
  * <b>Alias</b>    setCategoryId()<br>
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
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.0 initial release
  *
  */
  protected function setCurrentCategoryId($setStartCategory = false) {

    // sets the startPage if it exists
    if($setStartCategory === true && !empty($this->websiteConfig['startPage'])) {
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
  * <b> Name</b>      loadFrontendLanguageFile()<br>
  *
  * Loads the frontend language file into the {@link Feindura::$languageFile} property.
  *
  *
  * @param string $language       (optional) a given country code which will be used to try to load the language file
  *
  * @uses GeneralFunctions::loadLanguageFile() to load the language files
  *
  * @return string the country code which was used to load the frontend language files
  *
  * @access protected
  * @version 1.2
  * <br>
  * <b>ChangeLog</b><br>
  *    - add $standardLang parameter
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
  * <b>Name</b> generateMenu()<br>
  *
  * Generates a menu from a given <var>$links</var> array.
  *
  *
  * <b>Note</b>: It will add the {@link Feindura::$linkActiveClass} property as CSS class to the link, which is matching the current language.
  *
  *
  * @param array        $links      an array with links in the format
  * @param int|bool     $menuTag    (optional) the tag which is used to create the menu, can be an "ul", "ol", "array('table',<number until new row>)" or any other tag, if TRUE it uses "div"
  *
  * @uses Feindura::$menuId
  * @uses Feindura::$menuClass
  * @uses Feindura::$menuAttributes
  *
  *
  * @return array the generated menu array, ready to display in a HTML file
  *
  * @see Feindura::createMenu()
  * @see Feindura::createSubMenu()
  *
  * @access protected
  * @version 1.0
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.0 initial release
  *
  */
  protected function generateMenu($links, $menuTag = false) {

    // vars
    $menu = array();
    $menuItem['menuItem']          = '';
    $menuItem['item']              = ''; // same as 'menuItem'
    $menuItem['startTag']          = '';
    $menuItem['endTag']            = '';
    $menuItem['link']              = '';
    $menuItem['position']          = '';
    $menuItem['flag']              = false;
    $menuItem['href']              = false;
    $menuItem['pageDate']          = false;
    $menuItem['pageDateTimestamp'] = false;
    $menuItem['language']          = false;
    $menuItem['thumbnail']         = false;
    $menuItem['thumbnailPath']     = false;
    $menuItem['tags']              = false;
    $menuItem['id']                = false;
    $menuItem['pageId']            = false; // same as 'id'
    $menuItem['categoryId']        = false;
    $menuItemCopy = $menuItem;

    // if "table", separate the array
    if(is_array($menuTag)) {
      $breakAfter = (is_numeric($menuTag[1])) ? $menuTag[1] : false;
      $menuTag = $menuTag[0];
    }

    // -> sets the MENU attributes
    // ----------------------------
    $menuStartTag = '';
    $menuEndTag   = '';
    $pureTag   = false;

    // -> CREATEs the MENU-TAG (START and END-TAG)
    if($menuTag) { // || !empty($menuAttributes) <- not used because there is no menuTag property, the tag is only set when a $menuTag parameter is given

      // $menuAttributes = $this->createAttributes($this->menuId, $this->menuClass, $this->menuAttributes);

      // get the pure tag
      if(is_string($menuTag)) {

        // remove "
        $menuTag = str_replace('"', '', $menuTag);
        $pureTag = strtolower(preg_replace('#([\.|\#|\>|\[|\{|\+|\<|\:|\%].*)#i', '', $menuTag));

      // or uses standard tag
      } else {
        $pureTag = 'div';
        $menuTag = 'div';
      }

      // add menuClass property to the zencode string
      if(is_string($this->menuClass)) {
        if(($pos = strpos($menuTag, '.')) !== false)
          $menuTag = substr_replace($menuTag, '.'.str_replace(' ','.',trim($this->menuClass)), $pos, 0);
        elseif(($pos = strpos($menuTag, '[')) !== false)
          $menuTag = substr_replace($menuTag, '.'.str_replace(' ','.',trim($this->menuClass)), $pos, 0);
        else
          $menuTag .= '.'.str_replace(' ','.',trim($this->menuClass));
      }
      // add menuId property to the zencode string
      if(strpos($menuTag, '#') === false && is_string($this->menuId)) {
        $menuTag = str_replace($pureTag, $pureTag.'#'.$this->menuId, $menuTag);
      }
      // add Attributes
      if(is_string($this->menuAttributes))
        $menuTag .= '['.str_replace(array('"',' '), array('',']['), $this->menuAttributes).']';

      // generate tag with id, classes and attributes
      $menuTag = ZenPHP::expand($menuTag);

      // remove end tag
      $menuTag = str_replace('</'.$pureTag.'>', '', $menuTag);

      $menuStartTag = "\n".$menuTag;
      $menuEndTag   = "</".$pureTag.'>'."\n\n";
    }

    // --------------------------------------
    // -> builds the final MENU
    // ************************
    if(empty($links))
      return array();

    // SHOW START-TAG
    if($menuStartTag) {
      $menuItemCopy['menuItem'] = $menuStartTag;
      $menuItemCopy['item']     = $menuStartTag;
      $menuItemCopy['startTag'] = $menuStartTag;
      $menu[] = $menuItemCopy;
    }

    // * reset $menuItemCopy
    $menuItemCopy = $menuItem;

    // creating the START TR tag
    if($pureTag === 'table') {
      $menuItemCopy['menuItem'] = "<tbody><tr>\n";
      $menuItemCopy['item']     = "<tbody><tr>\n";
      $menuItemCopy['startTag'] = "<tbody><tr>\n";
      $menu[] = $menuItemCopy;
    }

    // * reset $menuItemCopy
    $menuItemCopy = $menuItem;

    $countCells = 1;
    $countLinks = 1;
    foreach($links as $link) {

      // breaks the CELLs with TR after the given NUMBER of CELLS
      if($pureTag === 'table' &&
         is_numeric($breakAfter) &&
         ($breakAfter + 1) == $countCells) {
        $menuItemCopy['menuItem'] = "\n</tr><tr>\n";
        $menuItemCopy['item']     = "\n</tr><tr>\n";
        $menuItemCopy['startTag'] = "<tr>\n";
        $menuItemCopy['endTag']   = "\n</tr>";
        $menu[] = $menuItemCopy;
        $countCells = 1;
      }

      // * reset $menuItemCopy
      $menuItemCopy = $menuItem;

      // add "active" class to the link wrapping element
      $linkClass = '';
      if(!empty($this->linkActiveClass) && ($link['active'] || $this->page === $link['id']) ||
         (!empty($link['subCategory']) && $this->category == $link['subCategory']))
        $linkClass = ' class="'.$this->linkActiveClass.'"';

      // if menuTag is a LIST ------
      if($pureTag === 'menu' || $pureTag === 'ul' || $pureTag === 'ol') {
        $menuItemCopy['menuItem'] = '<li'.$linkClass.'>'.$link['link']."</li>\n";
        $menuItemCopy['item']     = '<li'.$linkClass.'>'.$link['link']."</li>\n";
        $menuItemCopy['startTag'] = '<li'.$linkClass.'>';
        $menuItemCopy['endTag']   = "</li>\n";

      // if menuTag is a TABLE -----
      } elseif($pureTag === 'table') {
        $menuItemCopy['menuItem'] = "<td".$linkClass.">\n".$link['link']."\n</td>";
        $menuItemCopy['item']     = "<td".$linkClass.">\n".$link['link']."\n</td>";
        $menuItemCopy['startTag'] = "<td".$linkClass.">\n";
        $menuItemCopy['endTag']   = "\n</td>";

      // if just a link
      } else {
        $menuItemCopy['menuItem'] = $link['link']."\n";
        $menuItemCopy['item']     = $link['link']."\n";
      }

      // add the rest of the menu item
      $menuItemCopy['link']                  = $link['link'];
      $menuItemCopy['href']                  = $link['href'];
      $menuItemCopy['active']                = ($link['active'] || $this->page == $link['id'] || (!empty($link['subCategory']) && $this->category == $link['subCategory'])) ? true : false;
      if($link['title'])
        $menuItemCopy['title']               = $link['title'];
      if($link['id']) {
        $menuItemCopy['pageId']              = $link['id'];
        $menuItemCopy['id']                  = $link['id'];
      }
      if($link['category'])
        $menuItemCopy['categoryId']          = $link['category'];
      if($link['flag'])
        $menuItemCopy['flag']                = $link['flag'];
      if($link['pageDate'])
        $menuItemCopy['pageDate']            = $link['pageDate'];
      if($link['pageDateTimestamp'])
        $menuItemCopy['pageDateTimestamp']   = $link['pageDateTimestamp'];
      if($link['language'])
        $menuItemCopy['language']            = $link['language'];
      if($link['tags'])
        $menuItemCopy['tags']                = $link['tags'];

      // add thumbnail
      if($link['thumbnail']) {
        $menuItemCopy['thumbnail']     = $link['thumbnail'];
        $menuItemCopy['thumbnailPath'] = $link['thumbnailPath'];
      }

      // adds the position
      if($countLinks == 1)
        $menuItemCopy['position']            = 'first';
      elseif($countLinks == count($links))
        $menuItemCopy['position']            = 'last';
      else
        $menuItemCopy['position']            = $countLinks;

      // add link
      $menu[] = $menuItemCopy;

      // * reset $menuItemCopy
      $menuItemCopy = $menuItem;

      // count the table cells
      $countCells++;

      // count the links
      $countLinks++;
    }

    // fills in the missing TABLE CELLs
    while($pureTag === 'table' &&
          is_numeric($breakAfter) &&
          $breakAfter >= $countCells) {
      $menuItemCopy['menuItem'] = "\n<td></td>\n";
      $menuItemCopy['item']     = "\n<td></td>\n";
      $menuItemCopy['startTag'] = "\n<td>";
      $menuItemCopy['endTag']   = "</td>\n";
      $menu[] = $menuItemCopy;
      $countCells++;
    }

    // * reset $menuItemCopy
    $menuItemCopy = $menuItem;

    // creating the END TR tag
    if($pureTag === 'table') {
      $menuItemCopy['menuItem'] = "</tr></tbody>\n";
      $menuItemCopy['item']     = "</tr></tbody>\n";
      $menuItemCopy['endTag']   = "</tr></tbody>\n";
      $menu[] = $menuItemCopy;
    }

    // * reset $menuItemCopy
    $menuItemCopy = $menuItem;

    // SHOW END-TAG
    if($menuEndTag) {
      $menuItemCopy['menuItem'] = $menuEndTag;
      $menuItemCopy['item']     = $menuEndTag;
      $menuItemCopy['endTag']   = $menuEndTag;
      $menu[] = $menuItemCopy;
    }

    // returns the whole menu after finish
    return $menu;
  }

/**
  * <b>Name</b> generateContent()<br>
  *
  * Generates the page content and adds the frontend editing when activated and logged in.
  *
  *
  * <b>Note:</b> Activates the frontend editing (adds a div tag with feindura data).
  *
  *
  * @param string         $pageContentString  the localized page content string of a page
  * @param int|array      $pageId             page ID
  *
  * @uses GeneralFunctions::$adminConfig       to check for frontend editing
  * @uses $xHtml
  *
  *
  * @uses GeneralFunctions::htmLawed()
  * @uses GeneralFunctions::replaceLinks()
  * @uses GeneralFunctions::replaceSnippets()
  * @uses GeneralFunctions::shortenHtmlText()
  *
  *
  * @return string the generated page content
  *
  * @see FeinduraBase::generatePage()
  *
  * @access protected
  * @version 1.0
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.0 initial release
  *
  */
  protected function generateContent($pageContentString, $pageId) {
    // -> when content is not empty
    if(!empty($pageContentString)) {

      if($this->adminConfig['editor']['safeHtml'])
        $htmlLawedConfig['safe'] = 1;
      else
        $htmlLawedConfig['safe'] = 0;
      if($xHtml)
        $htmlLawedConfig['valid_xhtml'] = 1;
      else
        $htmlLawedConfig['valid_xhtml'] = 0;
      $pageContentEdited = ($this->adminConfig['editor']['htmlLawed']) ? GeneralFunctions::htmLawed($pageContentString,$htmlLawedConfig) : $pageContentString;

      // replace feindura links
      $pageContentEdited = GeneralFunctions::replaceLinks($pageContentEdited, $this->sessionId, $this->language);
      $pageContentEdited = GeneralFunctions::replaceSnippets($pageContentEdited,$pageId);

    // -> show no content
    } else
      $pageContentEdited = '';

    return $pageContentEdited;
  }


 /**
  * <b>Name</b> generatePage()<br>
  *
  * <b>This method uses the {@link $showErrors $error...}, {@link $titleLength $title...} and {@link $thumbnailAlign $thumbnail...} properties.</b>
  *
  * Generates a page.
  *
  * This method is called in descendant classes.<br>
  * Generates a page by the given page ID.
  * An array will be returned with all elements of the page, ready for displaying in a HTML-page.
  *
  * In case the page doesn't exists or is not public and the <var>$showErrors</var> parameter is TRUE,
  * an error will be placed in the ['content'] part of the returned array,
  * otherwiese it returns an empty array.<br>
  *
  * <b>Note:</b> Activates the frontend editing (adds a span tag with feindura data).
  *
  * Example of the returned array:
  * {@example generatePage.return.example.php}
  *
  * @param int|array      $page          page ID or a $pageContent array
  * @param bool           $showErrors    (optional) says if errors like "The page you requested doesn't exist" will be displayed
  * @param int|array|bool $shortenText   (optional) number of the maximal text length displayed, adds a "more" link at the end or FALSE to not shorten. You can also pass an array: value 1: text length as int, value 2: text string for the link, or a link string.  e.g. array(23,false), array(23,'read more'), or array(23,'<a href="%href%"'>read more</a>'). (the <var>%href%</var> will be replaced by the pages href)
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
  * @uses generateContent()                        to modify the pageContent (and add frontend editing container)
  * @uses GeneralFunctions::formatDate()           to format the page date for output
  * @uses GeneralFunctions::dateDayBeforeAfter()   check if the page date is "yesterday" "today" or "tomorrow"
  * @uses GeneralFunctions::isPublicCategory()     to check whether the category is public
  * @uses GeneralFunctions::isPageContentArray()   to check if the given array is a $pageContent array
  * @uses GeneralFunctions::readPage()             to load the page if the $page parameter is an ID
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
  * @version 1.1
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.1 add <time> tag to the pageDate
  *    - 1.0.1 fixed description return
  *    - 1.0 initial release
  *
  */
  protected function generatePage($page, $showErrors = true, $shortenText = false, $useHtml = true) {

    // vars
    $return['id']                = false;
    $return['pageId']            = false; // same as 'id'
    $return['category']          = false;
    $return['categoryId']        = false;
    $return['subCategory']       = false;
    $return['subCategoryId']     = false;
    $return['pageDate']          = false;
    $return['pageDateTimestamp'] = false;
    $return['title']             = false;
    $return['thumbnail']         = false;
    $return['thumbnailPath']     = false;
    $return['content']           = false;
    $return['description']       = false;
    $return['tags']              = false;
    $return['href']              = false;
    $return['plugins']           = array();
    $return['error']             = true;

    // ->> CHECKS
    // -------------------

    // -> CHECK for right PHP VERSION
    if(PHP_VERSION < REQUIREDPHPVERSION) {
      $return['content'] = '<span style="font-size:15px;">'.$this->languageFile['ADMINSETUP_ERROR_PHPVERSION'].' '.REQUIREDPHPVERSION.'</span>'; // if not throw error and and the method
      return $return;
    }

    // -> sets the ERROR SETTINGS
    // ----------------------------
    if($showErrors) {
      // adds ATTRIBUTES
      $errorStartTag = '';
      $errorEndTag = '';
      // $errorAttributes = $this->createAttributes($this->errorId, $this->errorClass, $this->errorAttributes);

      if(is_string($this->errorTag)) {

        // remove "
        $errorTag = str_replace('"', '', $this->errorTag);
        $pureErrorTag = strtolower(preg_replace('#([\.|\#|\>|\[|\{|\+|\<|\:|\%].*)#i', '', $errorTag));

        // generate tag with id, classes and attributes
        $errorTag = ZenPHP::expand($errorTag);

        // remove end tag
        $errorTag = str_replace('</'.$pureErrorTag.'>', '', $errorTag);

        $errorStartTag = $errorTag;
        $errorEndTag = '</'.$pureErrorTag.'>';
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
        }

        return $return;
      }
    }

    // -> PAGE is PUBLIC? if not throw ERROR
    if(!$pageContent['public'] || GeneralFunctions::isPublicCategory($pageContent['category']) === false) {
      if($showErrors) {
        $return['content'] = $errorStartTag.$this->languageFile['PAGE_ERROR_PAGENOTPUBLIC'].$errorEndTag; // if not throw error and and the method
      }

      return $return;
    }

    // -> START to BUILD THE PAGE CONTENT
    // ----------------------------------

    // -> PAGE DATE
    // *****************
    $pageDate = false;
    if($this->categoryConfig[$pageContent['category']]['showPageDate']) {
      // add page date
      $pageDate          = GeneralFunctions::showPageDate($pageContent,true,$this->languageFile);
      $pageDateTimeStamp['date']  = $pageContent['pageDate']['start'];
      $pageDateTimeStamp['start'] = $pageContent['pageDate']['start'];
      $pageDateTimeStamp['end']   = $pageContent['pageDate']['end'];
    }

    // -> PAGE TITLE
    // *****************
    $title = '';
    $localizedPageTitle = $this->getLocalized($pageContent,'title');
    if(!empty($localizedPageTitle))
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
    if($this->websiteConfig['multiLanguageWebsite']['active'])
      $langCode = $this->language;
    else
      $langCode = 0;
    $localizedPageContent = $this->getLocalized($pageContent,'content',$langCode);

    // -> ADD the FRONTEND EDITING CONTAINER
    // if(!$shortenText && !$GLOBALS['ISSNIPPET'] && $useHtml && $this->loggedIn && GeneralFunctions::hasPermission('frontendEditing') && PHP_VERSION >= REQUIREDPHPVERSION) {

    //   $uniqueId = uniqid();

    //   $pageContentEdited = "\n".'<div class="feindura_editPage" id="feindura_editPage'.$pageContent['id'].'_'.$uniqueId.'" data-feindura="'.$pageContent['id'].' '.$pageContent['category'].' '.$langCode.'">'.$localizedPageContent.'</div>'."\n";
    //   $pageContentEdited .= '<script type="text/javascript">/* <![CDATA[ */ $("feindura_editPage'.$pageContent['id'].'_'.$uniqueId.'").store("editContent",$("feindura_editPage'.$pageContent['id'].'_'.$uniqueId.'").get("html")); /* ]]> */</script>'."\n";

    // // ->> USE modified CONTENT (replaceLinks,replaceSnippets,..)
    // } else {
      $pageContentEdited = $this->generateContent($localizedPageContent, $pageContent['id']);

      // clear Html tags?
      if($useHtml === false || is_string($useHtml)) {
        if(is_string($useHtml))
          $pageContentEdited = strip_tags($pageContentEdited, $useHtml);
        else
          $pageContentEdited = strip_tags($pageContentEdited);
      }

      // -> SHORTEN CONTENT
      if($shortenText && !is_bool($shortenText))
        $pageContentEdited = $this->shortenHtmlText($pageContentEdited, $shortenText, $pageContent);

      // clear xHTML tag endings from the content
      if($this->xHtml === false)
        $pageContentEdited = str_replace(' />','>',$pageContentEdited);
    // }


    // -> get description
    $localizedPageDescription = $this->getLocalized($pageContent,'description');

    // -> get tags
    $localizedPageTags = $this->getLocalized($pageContent,'tags');

    // -> SET UP the PAGE ELEMENTS
    // *******************
    if(!empty($pageContent['id'])) {
      $return['id']                                           = $pageContent['id'];
      $return['pageId']                                       = $pageContent['id'];
    }

    if($pageContent['category'] && $pageContent['category'] != 0) {
      $return['category']                                     = $this->getLocalized($this->categoryConfig[$pageContent['category']],'name');
    }
    $return['categoryId']                                     = $pageContent['category'];

    if($pageContent['subCategory']) {
      $return['subCategory']                                  = $this->getLocalized($this->categoryConfig[$pageContent['subCategory']],'name');
      $return['subCategoryId']                                = $pageContent['subCategory'];
    }

    if($pageDate)
      $return['pageDate']                                     = $pageDate;

    if($pageDate)
      $return['pageDateTimestamp']                            = $pageDateTimeStamp;

    if(!empty($localizedPageTitle))
      $return['title']                                        = $title;

    if($returnThumbnail) {
      $return['thumbnail']                                    = "\n".$returnThumbnail['thumbnail']."\n";
      $return['thumbnailPath']                                = $returnThumbnail['thumbnailPath'];
    }

    if(!empty($localizedPageContent))
      $return['content']                                      = "\n".$pageContentEdited."\n";

    if(!empty($localizedPageDescription))
      $return['description']                                  = $localizedPageDescription;

    if(!empty($localizedPageTags))
      $return['tags']                                         = $localizedPageTags;

    $return['href']                                           = GeneralFunctions::createHref($pageContent,$this->sessionId,$this->language);

    if(isset($pageContent['plugins']))
      $return['plugins']                                      = $pageContent['plugins'];

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
  * <b>Name</b> createTitle()<br>
  *
  * Generates a page title from a given <var>$pageContent</var> array by using the given parameters.
  *
  * <b>Note:</b> Activates the frontend editing (adds a span tag with feindura data).
  *
  * @param array   $pageContent                 the $pageContent Array of a page
  * @param int     $titleLength                 (optional) number of the maximal text length shown or FALSE to not shorten
  * @param bool    $titleAsLink                 (optional) if TRUE, it creates the title as link
  * @param bool    $titleShowPageDate           (optional) if TRUE, it shows the page date before the title text
  * @param bool    $titleShowCategory           (optional) if TRUE, it shows the category name before the title text, and uses the $titleShowCategory parameter string between both
  * @param string  $titleCategorySeparator      (optional) string to seperate the category name and the title text, if the $titleShowCategory parameter is TRUE
  * @param bool    $allowFrontendEditing        (optional) if TRUE it will allow frontendenditing, when it is activated and the user is logged in. If <var>$titleAsLink</var> is TRUE, frontend editing will be deactivated anyway.
  *
  * @uses $categoryConfig                             to check if showing the page date is allowed and for the category name
  * @uses $languageFile                               for showing "yesterday", "today" or "tomorrow" instead of a page date
  * @uses shortenText()                               to shorten the title text, if the $titleLength parameter is TRUE
  * @uses createHref()                                to create the href if the $titleAsLink parameter is TRUE
  * @uses GeneralFunctions::formatDate()            to format the title date for output
  * @uses GeneralFunctions::dateDayBeforeAfter()    check if the title date is "yesterday" "today" or "tomorrow"
  *
  * @return string the generated title string ready to display in a HTML file
  *
  * @see Feindura::getPageTitle()
  *
  * @example getPageTitle.example.php the {@link getPageTitle()} method in this example calls this method with the title properties as parameters
  *
  * @access protected
  * @version 1.1
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.1 add <time> tag to the pageDate
  *    - 1.0 initial release
  *
  */
  protected function createTitle($pageContent, $titleLength = false, $titleAsLink = false, $titleShowPageDate = false, $titleShowCategory = false, $titlePageDateSeparator = false, $titleCategorySeparator = false, $allowFrontendEditing = true) {

      // vars
      $titleBefore = '';
      $titleAfter = '';

      // saves the long version of the title, for the title="" tag
      //$fullTitle = strip_tags($this->getLocalized($pageContent,'title'));

      if($titleShowPageDate && $this->categoryConfig[$pageContent['category']]['showPageDate']) {
          // add page date
          $titleDate          = GeneralFunctions::showPageDate($pageContent,true,$this->languageFile);

          // add pageDate separator
          if(is_string($titlePageDateSeparator) && !empty($titleDate))
            $titleDate .= $titlePageDateSeparator;

        } else
          $titleDate = false;


      // show the CATEGORY NAME
      if($titleShowCategory === true && $pageContent['category'] != 0) {
        if(is_string($titleCategorySeparator))
          $titleShowCategory = $this->getLocalized($this->categoryConfig[$pageContent['category']],'name').$titleCategorySeparator;
        else
          $titleShowCategory = $this->getLocalized($this->categoryConfig[$pageContent['category']],'name');
      } else
        $titleShowCategory = '';

      // ACTIVATE FRONTEND EDITING
      if($allowFrontendEditing && !$GLOBALS['ISSNIPPET'] && !$titleAsLink && $this->loggedIn && GeneralFunctions::hasPermission('frontendEditing') && PHP_VERSION >= REQUIREDPHPVERSION)  {// data-feindura="pageID categoryID language"
        if($this->websiteConfig['multiLanguageWebsite']['active'])
          $langCode = $this->language;
        else
          $langCode = 0;

        $uniqueId = uniqid();

        $titleText = '<span class="feindura_editTitle" id="feindura_editTitle'.$pageContent['id'].'_'.$uniqueId.'" data-feindura="'.$pageContent['id'].' '.$pageContent['category'].' '.$langCode.'">'.$this->getLocalized($pageContent,'title',$langCode).'</span>';
        // $titleText .= '<script type="text/javascript">/* <![CDATA[ */ $("feindura_editTitle'.$pageContent['id'].'_'.$uniqueId.'").store("editContent",$("feindura_editTitle'.$pageContent['id'].'_'.$uniqueId.'").get("html")); /* ]]> */</script>'."\n";

      } else
        $titleText = $this->getLocalized($pageContent,'title');

      // remove the " quotes
      $titleText = str_replace('"', '&quot;', $titleText);


      // GENERATE title
      $title = $titleShowCategory.$titleDate.$titleText;


      // CREATE A LINK for the title
      if($titleAsLink) {
        $titleBefore = '<a href="'.$this->createHref($pageContent,$this->sessionId,$this->language).'" title="'.str_replace('"','&quot;',strip_tags($title)).'">'."\n"; //.$titleBefore;
        $titleAfter = "\n</a>";
      }

      // SHORTEN the title
      if(is_numeric($titleLength))
        $title = $this->shortenText($title, array($titleLength,false), false);

      // -> builds the title
      // *******************
      //$title = $titleStartTag.$titleBefore.$title.$titleAfter.$titleEndTag;
      $title = $titleBefore.$title.$titleAfter;

      // RETURNS the title
      return $title;
  }

 /**
  * <b>Name</b> createThumbnail()<br>
  *
  * Generates a thumbnail <img> tag from the given <var>$pageContent</var> array and
  * returns an array with the ready to display tag and the plain thumbnail path.
  *
  * <b>Note:</b>: It will add the class "feinduraThumbnail" to the image.
  *
  * <b>Used Constants</b><br>
  *    - <var>DOCUMENTROOT</var> the absolut path of the webserver
  *
  * @param array $pageContent   the $pageContent array of a page
  *
  * @uses $adminConfig          for the thumbnail path
  * @uses $categoryConfig       to check if thumbnails are allowed for the th category of this page
  * @uses createAttributes()    to create the attributes used in the thumbnail <img> tag
  *
  * @return array|false the generated thumbnail <img> tag and a the plain thumbnail path or FALSE if no thumbnail exists or is not allowed to show
  *
  * @see Feindura::createLink()
  * @see FeinduraBase::generatePage()
  *
  * @access protected
  * @version 1.0
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.0 initial release
  *
  */
  protected function createThumbnail($pageContent) {

    // ->> CHECK if thumbnail exists and is allowed to show
    if(!empty($pageContent['thumbnail']) && $this->categoryConfig[$pageContent['category']]['thumbnails'] &&
      @is_file(dirname(__FILE__).'/../../upload/thumbnails/'.$pageContent['thumbnail'])) {

      // set TAG ENDING (xHTML or HTML)
      if($this->xHtml === true) $tagEnding = ' />';
      else $tagEnding = '>';

      // adds ATTRIBUTES and/or FLOAT
      $thumbnailAttributes = $this->createAttributes($this->thumbnailId, trim('feinduraThumbnail '.$this->thumbnailClass), $this->thumbnailAttributes);

      // thumbnail FLOAT
      $thumbnailAlign = false;
      if(strtolower($this->thumbnailAlign) === 'left' ||
         strtolower($this->thumbnailAlign) === 'right')
        $thumbnailAlign .= ' float:'.strtolower($this->thumbnailAlign).';';

      // CHECK if the THUMBNAIL BEFORE & AFTER is !== true
      $thumbnailBefore = '';
      $thumbnailAfter = '';

      if($this->thumbnailBefore !== true)
        $thumbnailBefore = $this->thumbnailBefore;
      if($this->thumbnailAfter !== true)
        $thumbnailAfter = $this->thumbnailAfter;

      // CREATE A LINK around the thumbnail
      if($this->thumbnailAsLink === true) {
        $thumbnailBefore = $thumbnailBefore.'<a href="'.$this->createHref($pageContent,$this->sessionId,$this->language).'" title="'.str_replace('"','&quot;',strip_tags($pageContent['title'])).'">'."\n";
        $thumbnailAfter = $thumbnailAfter."\n</a>";
      }

      // get the setting thumbnail sizes
      // THUMB WIDTH
      $configThumbWidth = (!empty($this->categoryConfig[$pageContent['category']]['thumbWidth']))
        ? $this->categoryConfig[$pageContent['category']]['thumbWidth']
        : $this->adminConfig['pageThumbnail']['width'];
      // THUMB HEIGHT
      $configThumbHeight = (!empty($this->categoryConfig[$pageContent['category']]['thumbHeight']))
        ? $this->categoryConfig[$pageContent['category']]['thumbHeight']
        : $this->adminConfig['pageThumbnail']['height'];

      $altTitle = strip_tags($this->getLocalized($pageContent,'title')); // getLocalized function is from the feindura.class.pgp

      if(!empty($configThumbWidth) && !empty($configThumbHeight) && is_numeric($configThumbWidth) && is_numeric($configThumbHeight)) {
        $pageThumbnail['thumbnail'] = $thumbnailBefore.'<img src="'.GeneralFunctions::Path2URI($this->adminConfig['basePath']).'library/images/icons/emptyImage.gif" style="display: inline-block; background-size: cover; width:'.$configThumbWidth.'px; height:'.$configThumbHeight.'px; background: url(\''.GeneralFunctions::Path2URI(dirname(__FILE__).'/../../upload/thumbnails/').$pageContent['thumbnail'].'\') no-repeat center center;'.$thumbnailAlign.'" alt="'.$altTitle.'" title="'.$altTitle.'"'.$thumbnailAttributes.$tagEnding.$thumbnailAfter;
      } else {
        if($thumbnailAlign) $thumbnailAlign = ' style="'.trim($thumbnailAlign).'"';
        $pageThumbnail['thumbnail'] = $thumbnailBefore.'<img src="'.GeneralFunctions::Path2URI(dirname(__FILE__).'/../../upload/thumbnails/').$pageContent['thumbnail'].'" alt="'.$altTitle.'" title="'.$altTitle.'"'.$thumbnailAlign.$thumbnailAttributes.$tagEnding.$thumbnailAfter;
      }

      $pageThumbnail['thumbnailPath'] = GeneralFunctions::Path2URI(dirname(__FILE__).'/../../upload/thumbnails/').$pageContent['thumbnail'];

      return $pageThumbnail;
    } else
      return false;
  }

 /**
  * <b>Name</b> createAttributes()<br>
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
  * <br>
  * <b>ChangeLog</b><br>
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
  * <b>Name</b> checkPagesForTags()<br>
  *
  * Load the <var>$pageContent</var> array of pages, only if the page(s) have one or more tags from the given <var>$tags</var> parameter.
  *
  * <b>Note</b>: the tags will be compared case insensitive.
  *
  * @param string         $idType           the ID(s) type can be "cat", "category", "categories" or "pag", "page" or "pages"
  * @param int|array|bool $ids              the category or page ID(s), can be a number or an array with numbers, if TRUE it checks all pages tags
  * @param string|array   $tags             an string (seperated by ",") or an array with tags to compare
  * @param bool           $loadPageContent  whether or not to return <var>pageContent</var arrays or just the <var>$pagesMetaData</var> arrays
  *
  * @uses loadPagesByType() to load pages by the given ID(s) for comparision
  * @uses compareTags()   to compare each tags between two strings
  *
  * @return array|false an array of $pageContent arrays or FALSE if no $pageContent array has any of the given tags
  *
  * @see Feindura::listPagesByTags()
  * @see Feindura::createMenuByTags()
  *
  * @access protected
  * @version 1.1
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.1 add $pagesMetaData array to get the tags of the page, speeds up the comparision
  *    - 1.0.2 removed separation by ; which has problems with signs like " in utf-8
  *    - 1.0.1 fixed issue when get a single tag as string
  *    - 1.0 initial release
  *
  */
  protected function checkPagesForTags($idType, $ids, $tags, $loadPageContent = true) {

    // var
    $return = false;

    // ->> PREPARE the $tags parameter
    if(is_string($tags)) {
      // clear multiple whitespaces
      $tags = preg_replace("/ +/", ' ', $tags);
      // look for the right seperation character
      if(strstr($tags,','))
        $tags = explode(',',$tags);
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
    // if($pages = $this->loadPagesByType($idType,$ids)) {
    if($pagesMetaData = $this->loadPagesMetaDataByType($idType,$ids)) {

      // goes trough every page and compares the tags
      foreach($pagesMetaData as $pageMetaData) {
        if(GeneralFunctions::compareTags($pageMetaData, $tags)) {
          if(!$loadPageContent)
            $return[] = $pageMetaData;
          elseif($pageContent = GeneralFunctions::readPage($pageMetaData['id'],$pageMetaData['category']))
            $return[] = $pageContent;
        }
      }
    }
    // RETURNs only the page who have the tags
    return $return;
  }

 /**
  * <b>Name</b> getIdsFromString()<br>
  *
  * Gets the right page and category IDs. If the <var>$ids</var> parameter is a an array it uses the first value as page ID and the second as category ID.
  *
  * If the given <var>$ids</var> parameter is a string/array with "previous" or "next" it returns the previous or next page ID from the current {@link Feindura::$page} property/{@link Feindura::$category} property on.
  * If the given <var>$ids</var> parameter is a string/array with "first" or "last" it returns the first or last page ID in that category from the current {@link Feindura::$page} property/{@link Feindura::$category} property on.
  * If the string is "random" it returns a random page ID in the current category, if its an array like: array('random','random') it would return a random page ID from a random category.
  *
  * <b>Note</b>: What is the first or last page/category depends on the sorting you have of the pages/categories in the feindura backend.<br>
  * <b>Note</b>: When using "previous","next","first" or "last" it will jump over pages/categories which are not public and return the next one.
  *
  * Examples of possible <var>$ids</var> parameter.
  * {@example id.parameter.example.php}
  *
  * Example return value, where first value is the page ID and the second value is the category ID.
  * <samp>
  * array(2,1)
  * </samp>
  *
  * @param int|string|array|bool $ids    a page ID, array with page and category IDs, or a string/array with "previous","next","first","last" or "random". (See example) (can also be a $pageContent array)
  *
  * @uses getPropertyPage()                              to get the right {@link Feindura::$page} property
  * @uses GeneralFunctions::getPageCategory()            to get the category ID of the given page
  * @uses GeneralFunctions::getPagesMetaDataOfCategory() to load all pages in a category to find the right previous or next page and return it
  *
  * @return array|false array with the page ID and category ID of the right page, or FALSE if no page could be resolved (e.g. last page and "next"). (will also pass through a given $pageContent array)
  *
  * @access protected
  * @version 2.0
  * <br>
  * <b>ChangeLog</b><br>
  *    - 2.0 change name from loadPrevNextPage() to getIdsFromString(), now handles also categories
  *    - 1.0 initial release
  *
  */
  protected function getIdsFromString($ids) {

    if($ids === null || $ids === '')
      return false;

    // vars
    $categoriesArray = $this->categoryConfig;
    // ??include the non-category??
    unset($categoriesArray[0]);
    // CHECK if its a $pageContent array, set the $page ID to the $page parameter
    if(GeneralFunctions::isPageContentArray($ids))
      return array($ids,intval($ids['category']));


    // -> IF ARRAY, separates into page/category
    if(is_array($ids)) {
      $page = $ids[0];
      $category = $ids[1];
    } else
      $page = $ids;

    // ->> check for page/category ids (will not affect $page/$category, if they are strings)
    // ******
    // GET page by PRIORITY: 1. -> page var 2. -> PROPERTY page var 3. -> false
    if((is_bool($page) || empty($page)) && (!is_bool($category) && !empty($category) ))
      $page = false;
    else
      $page = $this->getPropertyPage($page);

    // GET the right category for this page
    if(is_numeric($page))//&& !is_bool($category) && !is_string($category)
      $category = GeneralFunctions::getPageCategory($page);
    else
      // GET category by PRIORITY: 1. -> category var 2. -> PROPERTY category var 3. -> false
      $category = $this->getPropertyCategory($category);
    // ******

    /*
    echo '<br>BEFORE';
    echo '<br>page: '.$page;
    echo '<br>category: '.$category;
    */

    // -> if page AND category are IDs, return it right away
    if(is_numeric($page) && is_numeric($category))
      return array(intval($page),intval($category));

    // -> if category doesn't exist return false
    if($category != 0 && is_numeric($category) && !array_key_exists($category, $categoriesArray))
      return false;


    // ->> SHORTEN STRINGS
    // page string
    if(is_string($page) && !is_numeric($page)) {
      $page = strtolower($page);
      $page = substr($page,0,4);
      // PREV
      if($page === 'prev') $page = 'prev';
      // NEXT
      elseif($page === 'next') $page = 'next';
      // FIRST
      elseif($page === 'firs' || $page === 'top') $page = 'first';
      // LAST
      elseif($page === 'last' || $page === 'bott') $page = 'last';
      // RANDOM
      elseif($page === 'rand' || $page === 'shuf') $page = 'rand';
    }
    // category string
    if(is_string($category) && !is_numeric($category)) {
      $category = strtolower($category);
      $category = substr($category,0,4);
      // PREV
      if($category === 'prev') $category = 'prev';
      // NEXT
      elseif($category === 'next') $category = 'next';
      // FIRST
      elseif($category === 'firs' || $category === 'top') $category = 'first';
      // LAST
      elseif($category === 'last' || $category === 'bott') $category = 'last';
      // RANDOM
      elseif($category === 'rand' || $category === 'shuf') $category = 'rand';
    }

    // ->> NEXT/PREV PAGE
    // ******
    if($page === 'next' || $page === 'prev') {
      // get category of the current page
      $category = GeneralFunctions::getPageCategory($this->page);
      // loads all pagesMetaData of this category
      $pagesMetaData = GeneralFunctions::getPagesMetaDataOfCategory($category);
      if(is_array($pagesMetaData)) {
        $pagesMetaDataCopy = $pagesMetaData;

        foreach($pagesMetaData as $pageMetaData) {
          // if found current page
          if($pageMetaData['id'] == $this->page) {
            // NEXT
            if($page === 'next' && $next = next($pagesMetaDataCopy)) {
              while($next && !$next['public']) $next = next($pagesMetaDataCopy); // prevent to pick a non public page
              return array(intval($next['id']),intval($next['category']));
            // PREV
            } elseif($page === 'prev' && $prev = prev($pagesMetaDataCopy)) {
              while($prev && !$prev['public']) $prev = prev($pagesMetaDataCopy); // prevent to pick a non public page
              return array(intval($prev['id']),intval($prev['category']));
            // END of CATEGORY
            } else return false;
          }
          next($pagesMetaDataCopy); // move the pointer
        }

        unset($pagesMetaData);
      } else
        return false;
    }

    // ******


    //->> GET CATEGORY (next,prev,first,last,rand)
    // ******

    // NEXT/PREV CATEGORY
    if($category === 'next' || $category === 'prev') {
      $categoriesArrayCopy = $categoriesArray;

      foreach($this->categoryConfig as $eachCategory) {
        // if found current category
        if($eachCategory['id'] == $this->category) {
          // NEXT
          if($category === 'next' && $next = next($categoriesArrayCopy)) {
            while($next && !$this->categoryConfig[$next['id']]['public']) $next = next($categoriesArrayCopy); // prevent to pick a non public category
            $category = $next['id'];
          // PREV
          } elseif($category === 'prev' && $prev = prev($categoriesArrayCopy)) {
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
    } elseif($category === 'first' && $tmpCategory = reset($categoriesArray)) {
      while($tmpCategory && !$this->categoryConfig[$tmpCategory['id']]['public']) $tmpCategory = next($categoriesArray); // prevent to pick a non public category
      $category = $tmpCategory['id'];
      reset($categoriesArray);
      unset($tmpCategory);

    // LAST CATEGORY
    } elseif($category === 'last' && $tmpCategory = end($categoriesArray)) {
      while($tmpCategory && !$this->categoryConfig[$tmpCategory['id']]['public']) $tmpCategory = prev($categoriesArray); // prevent to pick a non public category
      $category = $tmpCategory['id'];
      reset($categoriesArray);
      unset($tmpCategory);

    // RANDOM CATEGORY
    } elseif($category === 'rand') {
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
    if(is_bool($page) || $page === 'first' || $page === 'last' || $page === 'rand') {

      // loads all pagesMetaData of this category
      $pagesMetaData = GeneralFunctions::getPagesMetaDataOfCategory($category);
      if(is_array($pagesMetaData)) {

        // FIRST PAGE (first or bool)
        if(($page === 'first' || is_bool($page)) && $tmpPage = reset($pagesMetaData)) {
          while($tmpPage && !$tmpPage['public']) $tmpPage = next($pagesMetaData); // prevent to pick a non public page
          return array(intval($tmpPage['id']),intval($tmpPage['category']));
        // LAST PAGE
        } elseif($page === 'last' && $tmpPage = end($pagesMetaData)) {
          while($tmpPage && !$tmpPage['public']) $tmpPage = prev($pagesMetaData); // prevent to pick a non public page
          return array(intval($tmpPage['id']),intval($tmpPage['category']));
        // RANDOM PAGE
        } elseif($page === 'rand') {
          $pagesMetaDataCopy = $pagesMetaData;
          shuffle($pagesMetaDataCopy);
          if($tmpPage = reset($pagesMetaDataCopy)) {
            while($tmpPage && !$tmpPage['public']) $tmpPage = next($pagesMetaDataCopy); // prevent to pick a non public category
            // reached the end? go backwards
            if(!$tmpPage) while($tmpPage && !$tmpPage['public']) $tmpPage = prev($pagesMetaDataCopy); // prevent to pick a non public category
            return array(intval($tmpPage['id']),intval($tmpPage['category']));
          }
        }

        unset($pagesMetaData);
      }
    }
    // ******

    return false;
  }

 /**
  * <b>Name</b> getPropertyIdsByType()<br>
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
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.0 initial release
  *
  */
  protected function getPropertyIdsByType($idType,$ids) {

    $idType = strtolower($idType);
    $shortIdType = substr($idType,0,3);

    // USES the PRIORITY: 1. -> page var 2. -> PROPERTY page var 3. -> false
    if($ids === false) {
      if($shortIdType === 'pag')
        // USES the PRIORITY: 1. -> pages var 2. -> PROPERTY pages var 3. -> false
        $ids = $this->getPropertyPage(false);
      elseif($shortIdType === 'cat')
        // USES the PRIORITY: 1. -> category var 2. -> PROPERTY category var 3. -> false
        $ids = $this->getPropertyCategory(false);
    }

    return $ids;
  }

 /**
  * <b>Name</b> getPropertyPage()<br>
  *
  * Returns the {@link Feindura::$page} property if the given <var>$page</var> parameter is a Boolean.
  *
  * @param int|bool $page (optional) a page id or a boolean
  *
  * @return mixed either the {@link Feindura::$page} property or passes the $page parameter
  *
  * @access protected
  * @version 1.0
  * <br>
  * <b>ChangeLog</b><br>
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
  * <b>Name</b> getPropertyCategory()<br>
  *
  * Returns the {@link Feindura::$category} property if the given <var>$category</var> parameter is a Boolean.
  *
  * @param int|bool $category (optional) a category id or a boolean
  *
  * @return int|true the {@link Feindura::$category} property or the $category parameter
  *
  * @access protected
  * @version 1.0
  * <br>
  * <b>ChangeLog</b><br>
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
  * <b>Name</b> shortenText()<br>
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
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.1 $length parameter can now be an array
  *    - 1.0 initial release
  *
  */
  protected function shortenText($string, $length, $pageContent = false, $endString = " ...") {

      // vars
      $moreLink = true;
      if(is_array($length)) {
        $length = $length[0];
        $moreLink = $length[1];
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
        $string .= " \n".str_replace('%href%',$this->createHref($pageContent['id']),$moreLink);;
      } elseif($moreLink && GeneralFunctions::isPageContentArray($pageContent)) {
        if(is_string($moreLink) && !is_bool($moreLink))
          $text = $moreLink;
        else
          $text = $this->languageFile['PAGE_TEXT_MORE'];
        $string .= " \n".'<a href="'.$this->createHref($pageContent,$this->sessionId,$this->language).'">'.$text.'</a>';
      }

      return $string;
  }

 /**
  * <b>Name</b> shortenHtmlText()<br>
  *
  * Shorten a HTML text by to a given length.
  *
  * All HTML tags which are contained in the shortend text will be counted and closed on the end.<br>
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
  * <br>
  * <b>ChangeLog</b><br>
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

          //echo '<br>'.$actualChar.'<br>';
          //echo 'realPos: '.$position.'<br>';
          //echo 'actualPos: '.$actualLength.'<br>';
          //echo 'inTAG. '.$inTag.'<br>';

          // checks if it is in a Tag or not
          if($actualChar === '<')
            $inTag = true;
          elseif($actualChar === '>')
            $inTag = false;

          // count the currentLength up if it is not in a tag
          if(!$inTag)
            $currentLength++;

          // count the real string length
          $position++;
        }
        //echo 'realPos: '.$position.'<br>';

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
            //echo 'Tag: '.$tag."<br>\n";
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
                //echo 'Tag OPEND: '.$tag.'<br>';
                $opened[] = $tag;
              }
            } else {
              // a tag has been closed
              $tag = mb_substr($tag, 1, mb_strlen($tag,'UTF-8'),'UTF-8');
              //echo 'Tag CLOSED: '.$tag.'<br>';
              unset($opened[array_pop(array_keys($opened, $tag))]);
            }
          }
        }

        // close tags that are still open
        if($opened) {
          $tagsToClose = array_reverse($opened);
          foreach($tagsToClose as $tag) {
            //echo 'Tag WRITE: '.$tag.'<br>';
            $input .= '</'.$tag.'>';
          }
        }

        $textWasCut = true;
      }

      // add the MORE LINK
      if(is_string($moreLink) && strpos($moreLink,'<a ') !== false) {
        $moreLink = " \n".str_replace('%href%',$this->createHref($pageContent['id']),$moreLink);
      } elseif($moreLink && GeneralFunctions::isPageContentArray($pageContent)) {
        if(is_string($moreLink) && !is_bool($moreLink))
          $text = $moreLink;
        else
          $text = $this->languageFile['PAGE_TEXT_MORE'];
        $moreLink = " \n".'<a href="'.$this->createHref($pageContent,$this->sessionId,$this->language).'">'.$text.'</a>';
      }

      $output = $input;

      // removes the last \r\n on the end
      if(mb_substr($output,-1,mb_strlen($output,'UTF-8'),'UTF-8') === "\n")
        $output = mb_substr($output,0,-2,'UTF-8');
      if(mb_substr($input,-1,mb_strlen($input,'UTF-8'),'UTF-8') === "\r")
        $output = mb_substr($output,0,-2,'UTF-8');

      // if string was shorten
      if($textWasCut) {
        // try to put the endString before the last HTML-Tag and add the more link
        if(mb_substr($output,-1,mb_strlen($output,'UTF-8'),'UTF-8') === '>') {
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
