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
 * This file contains the {@link GeneralFunctions} class.
 * 
 * @package [Implementation]-[Backend]
 */

/**
* <b>Classname</b> GeneralFunctions<br>
* 
* Contains the basic functions for reading and saving pages
* 
* <b>Note</b>: this class will be used by the implementation classes AND the backend of the feindura-CMS.
* 
* @package [Implementation]-[Backend]
* 
* @version 1.4
* <br>
*  <b>ChangeLog</b><br>
*    - 1.4 add {@link GeneralFunctions::replaceCodeSnippets()}
*    - 1.3.1 add schemes to htmlLawed
*    - 1.3 rewrite of checkLanguageFiles(), now loadLanguageFile()
*    - 1.2 changed class to static class
*    - 1.19 add parseDefaultLanguage() to checkLanguageFiles()
*    - 1.18 fixed checkLanguageFiles()
*    - 1.17 add chmod to savePage()
*    - 1.16 started documentation
*/ 
class GeneralFunctions {
 
 /* ---------------------------------------------------------------------------------------------------------------------------- */
 /* *** PROPERTIES *** */
 /* **************************************************************************************************************************** */
 
 // PUBLIC
 // *********
  
  /**
  * Contains the administrator-settings config <var>array</var>
  * 
  * @static
  * @var array
  * @see GeneralFunctions()
  * 
  */ 
  public static $adminConfig;
  
  /**
  * Contains the category-settings config <var>array</var>
  * 
  * @static
  * @var array
  * @see GeneralFunctions()
  * 
  */ 
  public static $categoryConfig;

  /**
  * Contains the website-settings config <var>array</var>
  * 
  * @static
  * @var array
  * @see GeneralFunctions()
  * 
  */ 
  public static $websiteConfig;

 /**
  * Contains the pagesMetaData <var>array</var>
  * 
  * This <var>array</var> contains all pages IDs and their category ID, as well as the localized titles
  * 
  * Example array:
  * {@example pagesMetaData.array.example.php}
  * 
  * @static
  * @var array
  * @see init()
  * @see getCurrentPageId()
  */ 
  public static $pagesMetaData;
  
 /**
  * Stores page-content <var>array's</var> in this property if a page is loaded
  * 
  * If a page is loaded (<i>included</i>) it's page-content array will be stored in the this array.<br>
  * If the page is later needed again it's page-content will be fetched from this property.<br>
  * It should speed up the page loading process.
  * 
  * @example loadPages.return.example.php of the returned array
  * 
  * @static
  * @var array
  * 
  */
  public static $storedPages = null;

  
 /**
  * Keeps an instance of the Feindura class to be used in the {@link GeneralFunctions::replaceCodeSnippets()} method.
  * 
  * 
  * @see GeneralFunctions::replaceCodeSnippets()
  * 
  * @static
  * @var array
  * 
  */
  public static $FeinduraCLass = null;


 /**
  * {@link GeneralFunctions::scriptBenchmark()} variables
  * 
  * 
  * @static
  * @var number
  * 
  */
  private static $scriptBenchmarkTime = null;
  private static $scriptBenchmarkPoint = 0;
 
 /* ---------------------------------------------------------------------------------------------------------------------------- */
 /* *** CONSTRUCTOR *** */
 /* **************************************************************************************************************************** */
  
 /**
  * <b> Type</b>      constructor<br>
  * 
  * Constructor is not callable, {@link GeneralFunctions::init()} is used instead.
  * 
  * @return void
  * 
  * @version 1.0
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.0 initial release
  * 
  */ 
  private function __construct() {
  }
  
 /**
  * <b> Type</b>      init<br>
  * 
  * The real constructor of the static class, gets the settings.
  * 
  * <b>Used Global Variables</b><br>
  *    - <var>$adminConfig</var> the administrator-settings config (included in the {@link general.include.php})
  *    - <var>$categoryConfig</var> the categories-settings config (included in the {@link general.include.php})
  * 
  * @return void
  * 
  * @static
  * @version 1.1
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.2 add $pagesMetaData
  *    - 1.0 initial release
  * 
  */ 
  public static function init() {
    
    // GET CONFIG FILES and SET CONFIG PROPERTIES
    self::$adminConfig    = $GLOBALS["adminConfig"];
    self::$categoryConfig = $GLOBALS["categoryConfig"];
    self::$websiteConfig  = $GLOBALS["websiteConfig"];
    self::$pagesMetaData  = $GLOBALS["pagesMetaData"];

    // set local for the url encode transliteration
    setlocale(LC_CTYPE, 'en_US.UTF-8');
  }
  
 /* ---------------------------------------------------------------------------------------------------------------------------- */
 /* *** METHODS *** */
 /* **************************************************************************************************************************** */
 
  /**
  * <b>Name</b> getBrowserLanguages()<br>
  * 
  * Checks for the browser language an create an array with all languages an q-values:
  * 
  * <samp>
  * Array (
  *      [de-de] => 1
  *      [de] => 0.8
  *      [en-us] => 0.5
  *      [en] => 0.3
  *  )
  * </samp>
  * 
  * If no match to the browser language is found it uses the <var>$standardLang</var> parameter for loading a languageFile or returning the country code.
  * 
  * @param string $standardLang the standard country code to return when no language code was get
  * @param bool   $simple       if TRUE it only returns a string with a language code, if FALSE it returns an array with the language
  * 
  * @return string|array  either a string with a language code, or a array in the format: array( [de-de] => 1, [en] => 0.5 ), depending on the <var>$simple</var> parameter
  * 
  * @link   http://www.dyeager.org/post/2008/10/getting-browser-default-language-php
  * @static
  */
  public static function getBrowserLanguages($standardLang = "en", $simple = true) {
    // var
    $language = array(strtolower($standardLang) => 1.0);

    if(isset($_SERVER["HTTP_ACCEPT_LANGUAGE"]) && strlen($_SERVER["HTTP_ACCEPT_LANGUAGE"]) > 1)  {
      # Split possible languages into array
      $x = explode(",",$_SERVER["HTTP_ACCEPT_LANGUAGE"]);
      foreach ($x as $val) {
         #check for q-value and create associative array. No q-value means 1 by rule
         if(preg_match("/(.*);q=([0-1]{0,1}\.\d{0,4})/i",$val,$matches))
            $lang[strtolower($matches[1])] = (float)$matches[2];
         else
            $lang[strtolower($val)] = 1.0;
      }
      
      if(!empty($lang))
        $language = $lang;
    }

    if($simple) {
      $language = key($language);
      $language = substr($language, 0,2);
    }

    return $language;
  }

 
 /**
  * <b>Name</b> loadLanguageFile()<br>
  * 
  * Loads a language file from a folder. The <var>$currentLangCode</var> parameter can contain a language code used to try to load a language file, if empty it uses the browsers language codes.
  * 
  * If no match to the browser language is found it uses the <var>$standardLang</var> parameter for loading a languageFile.
  * 
  *
  * <b>Used Constants</b><br>
  *    - <var>DOCUMENTROOT</var> the absolut path of the webserver
  *
  * @param string|false $langPath         (optional) a absolut path to look for a language file which fit the $filename parameter or FALSE to use the "feindura-cms/library/languages" folder
  * @param string       $filename         (optional) the structure of the filename, which should be loaded. the "%lang%" will be replaced with the country code like "%lang%.backend.php" -> "en.backend.php"
  * @param string|false &$currentLangCode (optional) (Note: this variable will also be changed outside of this method) a variable with the current language code, if this is set it will be first try to load this language file, when it couldn't find any language file which fits the browsers language code.  
  * @param bool         $standardLang     (optional) a standard language for use if no match was found
  * 
  * 
  * @uses GeneralFunctions::getBrowserLanguages() to get the right browser language
  * 
  * @return array the loaded language file array or an empty array
  * 
  * @static
  * @version 1.0.3
  * <br>
  * <b>ChangeLog</b><br>
  *    . 1.0.3 complete rewrite!
  *    - 1.0.2 add parseDefaultLanguage()
  *    - 1.0.1 fixed language files check, uses now readFolder recursive
  *    - 1.0 initial release
  * 
  */
  public static function loadLanguageFile($langPath = false, $filename = '%lang%.php', &$currentLangCode = false, $standardLang = 'en') {
     
    // var
    $return = array();
     
    // checks if a path given
    if(!is_string($langPath) || empty($langPath))
      $langPath = dirname(__FILE__).'/../languages/'; 
    else
      $langPath = (strpos($langPath,DOCUMENTROOT) === false) ? DOCUMENTROOT.$langPath : $langPath;

    // checks if the BROWSER STANDARD LANGUAGE is found in the SUPPORTED COUNTRY CODE         
    $browserLanguages = self::getBrowserLanguages($standardLang,false);
    // add the current language code
    if(!empty($currentLangCode) && !is_array($currentLangCode)) {
      $currentLangCodeArray = array($currentLangCode => 2); // set it as the highest qvalue
      //$browserLanguages = currentLangCodeArray + $browserLanguages;
      $browserLanguages = array_merge($browserLanguages,$currentLangCodeArray);
      natsort($browserLanguages);
      $browserLanguages = array_reverse($browserLanguages);
    }
    foreach($browserLanguages as $browserLanguage => $qValue) {
    
      $filenameReplaced = str_replace('%lang%',substr($browserLanguage,0,2),$filename);
      $fullPath = preg_replace('#/+#','/',$langPath.'/'.$filenameReplaced);
      
      //echo $fullPath."<br>\n";
 
      $languageFile = @include($fullPath);
      if(is_array($languageFile)) {
        $return = $languageFile;
        $currentLangCode = substr($browserLanguage,0,2);
        break;
      }
    }
    return $return;
  }

 /**
  * <b>Name</b> setVisitorTimzone()<br>
  * 
  * Try to get the visitors timezone by using javascript. It will create a redirect along with the visitors local timezone,
  * which then get catched in the next run of this function and stored in the <var>$_SESSION['feinduraSession']['timezone']</var> variable. 
  * 
  * @return string|false FALSE if it could set the local timezone and the redirect script created the script to redirect.
  *
  * @see Feindura::createMetaTags()
  * 
  * @static
  * @version 1.1
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.1 change timezone offsets to the current timezone offset
  *    - 1.0 initial release
  * 
  */
  public static function setVisitorTimzone() {

    // unset($_SESSION['feinduraSession']['timezone']);

    if(!function_exists('date_default_timezone_set'))
      return false;

    // var
    $return = false;
    //unset($_SESSION['feinduraSession']['timezone']);

    if(!isset($_SESSION['feinduraSession']['timezone'])) {
      
        if(!isset($_GET['localTimezone'])) {
          $return = '   
  <!-- Get the Visitors Timezone -->
  <script>
  var d = new Date()
  var localTimezoneOffset= -d.getTimezoneOffset()/60;
  location.href = "'.self::addParameterToUrl('localTimezone').'"+localTimezoneOffset;
  </script>

';
        } else {
          // -> standard difference
          // $zonelist = array('Kwajalein' => -12.00, 'Pacific/Midway' => -11.00, 'Pacific/Honolulu' => -10.00, 'America/Anchorage' => -9.00, 'America/Los_Angeles' => -8.00, 'America/Denver' => -7.00, 'America/Tegucigalpa' => -6.00, 'America/New_York' => -5.00, 'America/Caracas' => -4.30, 'America/Halifax' => -4.00, 'America/St_Johns' => -3.30, 'America/Argentina/Buenos_Aires' => -3.00, 'America/Sao_Paulo' => -3.00, 'Atlantic/South_Georgia' => -2.00, 'Atlantic/Azores' => -1.00, 'Europe/Dublin' => 0, 'Europe/Belgrade' => 1.00, 'Europe/Minsk' => 2.00, 'Asia/Kuwait' => 3.00, 'Asia/Tehran' => 3.30, 'Asia/Muscat' => 4.00, 'Asia/Yekaterinburg' => 5.00, 'Asia/Kolkata' => 5.30, 'Asia/Katmandu' => 5.45, 'Asia/Dhaka' => 6.00, 'Asia/Rangoon' => 6.30, 'Asia/Krasnoyarsk' => 7.00, 'Asia/Brunei' => 8.00, 'Asia/Seoul' => 9.00, 'Australia/Darwin' => 9.30, 'Australia/Canberra' => 10.00, 'Asia/Magadan' => 11.00, 'Pacific/Fiji' => 12.00, 'Pacific/Tongatapu' => 13.00);
          // -> current difference
          $zonelist = array('Kwajalein' => -12.00, 'Pacific/Midway' => -11.00, 'Pacific/Honolulu' => -10.00, 'America/Anchorage' => -8.00, 'America/Los_Angeles' => -7.00, 'America/Denver' => -6.00, 'America/Tegucigalpa' => -6.00, 'America/New_York' => -4.00, 'America/Caracas' => -4.30, 'America/Halifax' => -3.00, 'America/St_Johns' => -2.30, 'America/Argentina/Buenos_Aires' => -3.00, 'America/Sao_Paulo' => -3.00, 'Atlantic/South_Georgia' => -2.00, 'Atlantic/Azores' => 0, 'Europe/Dublin' => 1.00, 'Europe/Belgrade' => 2.00, 'Europe/Minsk' => 3.00, 'Asia/Kuwait' => 3.00, 'Asia/Tehran' => 4.30, 'Asia/Muscat' => 4.00, 'Asia/Yekaterinburg' => 6.00, 'Asia/Kolkata' => 5.30, 'Asia/Katmandu' => 5.45, 'Asia/Dhaka' => 6.00, 'Asia/Rangoon' => 6.30, 'Asia/Krasnoyarsk' => 8.00, 'Asia/Brunei' => 8.00, 'Asia/Seoul' => 9.00, 'Australia/Darwin' => 9.30, 'Australia/Canberra' => 10.00, 'Asia/Magadan' => 12.00, 'Pacific/Fiji' => 12.00, 'Pacific/Tongatapu' => 13.00);
          $index = array_keys($zonelist, $_GET['localTimezone']);
          $_SESSION['feinduraSession']['timezone'] = $index[0];
        }
    }

    // set to local timezone
    if(!empty($_SESSION['feinduraSession']['timezone']))
      date_default_timezone_set($_SESSION['feinduraSession']['timezone']);

    return $return;
  }

  /**
   * <b>Name</b> addParameterToUrl()<br>
   * 
   * Check if the current $_SERVER['REQUEST_URI'] variable end with ? or & and ads the <var>$parameterString</var> on the end.
   * 
   * 
   * @param string|array        $key   the key of the new parameter to add, if array, the value parameter must also be an array
   * @param string|array|false  $value (optional) the value of the new parameter to add
   * 
   * @return string the new url with add parameter
   * 
   * 
   * @version 2.0
   * <br>
   * <b>ChangeLog</b><br>
   *    - 2.0 complete rewrite based on {@link http://stackoverflow.com/questions/909193/is-there-a-php-library-that-handles-url-parameters-adding-removing-or-replacin}
   *    - 1.0.1 moved to GeneralFunctions class
   *    - 1.0 initial release
   * 
   */
  public static function addParameterToUrl($key,$value = '') {
    $query    = parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY);
    $params = array();
    parse_str($query, $params);
    
    if(is_array($key) && is_array($value)) {
      $count = 0;
      foreach ($key as $k) {
        $params[$k] = $value[$count];
        $count++;
      }
    } else
      $params[$key] = $value;

    $query = http_build_query($params);
    return '?'.$query;
  }

 /**
  * <b>Name</b> getCurrentUrl()<br>
  * 
  * Return the current URL ($_SERVER['REQUEST_URI']), optional with add parameters.
  * 
  * @param string $parameter (optional) a string of parameter(s) to add, with the following format: "key=value&key2=value2..."
  * 
  * @return string the current url
  * 
  * @static
  * @version 1.0
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.0 initial release
  * 
  */
  public static function getCurrentUrl($parameter = null) {
    
    $currentURL = $_SERVER['REQUEST_URI'];
    
    if(!empty($parameter)) {
      $currentUrl = (strpos($currentURL,'?') === false)
        ? $_SERVER['REQUEST_URI'].'?'
        : $_SERVER['REQUEST_URI'].'&';
      
      return $currentUrl.$parameter;
    } else
      return $currentURL;
  }
  
/**
  * <b>Name</b> getDirname()<br>
  * 
  * Returns the dirname of a <var>$dir</var> parameter, by checking whether the last part of the path is a filename or a dir.
  * 
  * @param string $dir the path to get the dirname from
  * 
  * @return string the changed path
  * 
  * @version 2.0
  * <br>
  * <b>ChangeLog</b><br>
  *    - 2.0 changed checking if ends with file, by using is_file()
  *    - 1.0.1 add always adding of a slash on the end
  *    - 1.0 initial release
  * 
  */
  public static function getDirname($dir) {
    
    // vars
    $return = false;
    $realPath = self::getRealPath($dir).'/'.basename($dir);

    if(is_file($realPath))
      $return = preg_replace('#/+#','/',str_replace('\\','/',dirname($dir)));
    else
      $return = $dir;

    // if(!empty($dir) && strpos(basename($dir),'.') !== false && (strlen(basename($dir)) - strpos(basename($dir),'.')) <= 4 && substr(basename($dir),-1) != '/')
    //   $return = preg_replace('#/+#','/',str_replace('\\','/',dirname($dir)));
    // else
    //   $return = $dir;

    return (substr($return, -1) == '/') ? $return : $return.'/';
  }

 /**
  * <b>Name</b> getStoredPages()<br>
  * 
  * Fetches the {@link $storedPages} property.
  * 
  * @uses $storedPages the property to get
  * 
  * @return array the {@link $storedPages} property
  * 
  * @example loadPages.return.example.php of the returned array
  * 
  * @static
  * @version 1.1
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.1 removed the in session storage
  *    - 1.0 initial release
  * 
  */
  public static function getStoredPages() {
      return self::$storedPages; 
  }

 /**
  * <b>Name</b> addStoredPage()<br>
  * 
  * Adds a <var>$pageContent</var> array to the {@link $storedPages} property.
  * 
  * @param int  $pageContent   a $pageContent array which should be add to the {@link $storedPages} property
  * 
  * @uses $storedPages the property to add the $pageContent array
  * 
  * @return array passes through the given $pageContent array
  * 
  * @static
  * @version 1.1
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.1 removed the in session storage
  *    - 1.0.1 removed the $remove parameter  
  *    - 1.0 initial release
  * 
  */
  public static function addStoredPage($pageContent) {
    
    // stores the given parameter only if its a valid $pageContent array
    if(self::isPageContentArray($pageContent)) {
        self::$storedPages[$pageContent['id']] = $pageContent;
    }
    return $pageContent;
  }
  
 /**
  * <b>Name</b> removeStoredPage()<br>
  * 
  * Removes a <var>$pageContent</var> array from the {@link $storedPages} property.
  * 
  * @param int $id the ID of a page which should be removed from the {@link $storedPages} property
  * 
  * @uses $storedPages the property to remove the $pageContent array
  * 
  * @return bool TRUE if a page with this ID exists and could be removed, otherwise FALSE
  * 
  * @static
  * @version 1.1
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.1 removed the in session storage
  *    - 1.0 initial release
  * 
  */
  public static function removeStoredPage($id) {
    
    // ->> REMOVE
    if(is_numeric($id)) {
      if(isset(self::$storedPages[$id])) {
        unset(self::$storedPages[$id]);
        return true;
      }
    }
    return false;
  }
  
 /**
  * <b>Name</b> getPageCategory()<br>
  * 
  * Return the category ID of a page.
  * 
  * @param int $page a page ID from which to get the category ID
  * 
  * @uses $pagesMetaData to get the category of the page
  * 
  * @return int|false the right category ID or FALSE if the page ID doesn't exists
  * 
  * @static
  * @version 2.0
  * <br>
  * <b>ChangeLog</b><br>
  *    - 2.0 uses now the $pagesMetaData array
  *    - 1.0 initial release
  * 
  */
  public static function getPageCategory($page) {
    if($page !== false && is_numeric($page)) {
      return self::$pagesMetaData[$page]['category'];
    } else
      return false;
  }
  

 /**
  * <b> Name</b> getParentPages()<br>
  * 
  * Returns an array with the parent pages of given subcategory.
  * If the given category ID is not a sub category of any page, it will return an empty array.
  * 
  * @param int $categoryId a category ID
  * 
  * @return array|false an array with the parent pages in the order from the current category on, or FALSE if this category is not a subcategory
  * 
  * @access public
  * @version 1.0
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.0 initial release
  * 
  */
  public static function getParentPages($categoryId) {

    // var
    $return = false;
   
    if($categoryId != 0 && self::$categoryConfig[$categoryId]['isSubCategory']) {

      while($categoryId) {

        if(($categoryId != 0 && self::$categoryConfig[$categoryId]['isSubCategory'])) {

          $parentPageId = unserialize(self::$categoryConfig[$categoryId]['isSubCategoryOf']);
          
          // -> determines which page was visited the last. therefor is assumed to be the parent page of the sub category
          if(is_array($_SESSION['feinduraSession']['log']['visitedPagesOrder']) && count($parentPageId) > 1) {
            $vistedPagesReversed = array_reverse($_SESSION['feinduraSession']['log']['visitedPagesOrder']);
            foreach ($vistedPagesReversed as $pageId) {
              if(is_numeric($pageId) && array_key_exists($pageId, $parentPageId)) {
                $parentPageId = $pageId;
                break;
              }
            }
          }
          // if page wasn't set, use the top in the array
          if(is_array($parentPageId))
            $parentPageId = key($parentPageId);

          if(($parentPageContent = self::readPage($parentPageId,self::getPageCategory($parentPageId))) !== false) {
            // check if the parent pages category is a sub category
            if(($parentPageContent['category'] != 0 && self::$categoryConfig[$parentPageContent['category']]['showSubCategory']) ||
               ($parentPageContent['category'] == 0 && self::$adminConfig['pages']['showSubCategory'])) {

              $return[] = $parentPageContent;

              // set the next (sub) category
              $categoryId = $parentPageContent['category'];

            } elseif($parentPageContent['category'] != 0)
              $categoryId = false;
            else
              $categoryId = false;
          } else
            $categoryId = false;

          unset($parentPageContent);

        } else {
          $categoryId = false;
        }

      }
    }
    if(is_array($return))
      $return = array_reverse($return);

    return $return;
  }

  /**
   * <b>Name</b> getLocalized()<br>
   * 
   * Gets the localized version of given <var>$value</var> parameter, which matches the <var>$_SESSION['feinduraSession']['websiteLanguage']</var> variable.
   * If no matching localized version of this value exists, it returns the one matching the <var>$adminConfig['multiLanguageWebsite']['mainLanguage']</var> variable.
   * 
   *  
   * @param array        $localizedArray      an array with an ['localized'] array in the form of: array('de' => .. , 'en' => .. )
   * @param string       $value               the name of the value, which should be returned localized
   * @param bool|string  $forceOrUseLanguage  if TRUE the language will be forced to be loaded, even if it does not exist, if string it will be try this as the testing language code, instead of the <var>$_SESSION['feinduraSession']['websiteLanguage']</var> var
   *   
  * @return string the localized version of the <var>$value</var> parameter
   * 
   * 
   * @static
   * @version 1.2
   * <br>
   * <b>ChangeLog</b><br>
   *    - 1.2 the $localizedArray is now an array with an localized array, e.g. to give the $categoryConfig directly
   *    - 1.1 changed $forceLanguage to $forceOrUseLanguage
   *    - 1.0 initial release
   * 
   */
  public static function getLocalized($localizedArray, $value, $forceOrUseLanguage = false) {

    // var
    $localizedArray = (isset($localizedArray['localized'])) ? $localizedArray['localized'] : $localizedArray; // LEGACY - in case its forgotten somewhere to reomve the 'localized'
    $languageCode = (!is_bool($forceOrUseLanguage) && is_string($forceOrUseLanguage) && strlen($forceOrUseLanguage) == 2)
      ? $forceOrUseLanguage
      : $_SESSION['feinduraSession']['websiteLanguage'];

    // get the one matching $languageCode
    if((isset($localizedArray[$languageCode]) && !empty($localizedArray[$languageCode][$value])) ||
       $forceOrUseLanguage === true)
      $localizedValues = $localizedArray[$languageCode];

    // if not get the one matching the "Main Language"
    elseif(isset($localizedArray[self::$adminConfig['multiLanguageWebsite']['mainLanguage']]) &&
           !empty($localizedArray[self::$adminConfig['multiLanguageWebsite']['mainLanguage']][$value]))
      $localizedValues = $localizedArray[self::$adminConfig['multiLanguageWebsite']['mainLanguage']];

    // if not get the first one in the localization array
    elseif(is_array($localizedArray))
      $localizedValues = current($localizedArray);
    
    // legacy fallback
    else
      return $localizedArray[$value];

    return $localizedValues[$value];
  }

 /**
  * <b>Name</b> readPage()<br>
  * 
  * Loads the $pageContent array of a page.
  * 
  * Checks first whether the given page ID was already loaded and is contained in the {@link $storedPages} property.
  * If not the {@link GeneralFunctions::readPage()} public static function is called to include the $pagecontent array of the page
  * and store it in the {@link $storedPages} property.
  * 
  * Example of the returned $pageContent array:
  * {@example readPage.return.example.php}
  * 
  * @param int|array  $page           a page ID or a $pageContent array (will then returned immediately)
  * @param int        $category       (optional) a category ID, if FALSE it will try to load this page from the non-category
  * 
  * @uses getStoredPages()		for getting the {@link $storedPages} property
  * @uses addStoredPage()		to store a new loaded $pageContent array in the {@link $storedPages} property
  * 
  * @return array|FALSE the $pageContent array of the requested page or FALSE, if it couldn't open the file, or NULL when the file exists but couldnt be loaded properly
  * 
  * @static
  * @version 1.0
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.0 initial release
  * 
  */
  public static function readPage($page,$category = false) {
    //echo 'PAGE: '.$page.' -> '.$category.'<br>';

    // var
    $pageContent = false;
    
    // if $page is a valid $pageContent array return it immediately
    if(self::isPageContentArray($page))
      return $page;
    elseif(!is_numeric($page))
      return false;
       
    $storedPages = self::getStoredPages();
    
    // ->> IF the page is already loaded
    if(isset($storedPages[$page])) {
      // echo '<br>->USED STORED '.$page.'<br>';        
      return $storedPages[$page];
      
    // ->> ELSE load the page and store it in the storePages PROPERTY
    } else {
         
      // adds .php to the end if its missing
      if(substr($page,-4) != '.php')
        $page .= '.php';
    
      // adds a slash behind the $category / if she isn't empty
      if(!empty($category))
        if(substr($category,-1) !== '/')
            $category = $category.'/';
    
      if($category === false || $category == 0)
        $category = '';
    
      //echo '<br>LOAD PAGE: '.$page.'<br>';   
      //echo 'CATEGORY: '.$category.'<br>';
      
      // ->> INCLUDE
      if($fp = @fopen(dirname(__FILE__).'/../../pages/'.$category.$page,'r')) {
        flock($fp,LOCK_SH);
        $pageContent = @include(dirname(__FILE__).'/../../pages/'.$category.$page);
        flock($fp,LOCK_UN);
        fclose($fp);
      }
      
      // return content array
      if(is_array($pageContent)) {
        // UNESCPAE the SINGLE QUOTES '
        if(is_array($pageContent['localized'])) {
          foreach ($pageContent['localized'] as $key => $value)
            $pageContent['localized'][$key]['content'] = str_replace("\'", "'", $value['content']);
        // legacy fallback
        } else
          $pageContent['content'] = str_replace("\'", "'", $pageContent['content']);

        return self::addStoredPage($pageContent);
        
      // return failure while loading the content (file exists but couldn't be loaded)
      } elseif($pageContent === 1) {
        return null;
        
      // returns false if it couldn't include the file (file doesnt exists)
      } else
        return false;
    }
  }

 /**
  * <b>Name</b> savePage()<br>
  * 
  * Save a page to it's flatfile.
  *
  * 
  * Example of the saved $pageContent array:
  * {@example readPage.return.example.php}
  * 
  * <b>Used Constants</b><br>
  *    - <var>"<?php\n"</var> the php start tag
  *    - <var>"\n?>"</var> the php end tag
  * 
  * @param array        $pageContent       the $pageContent array of the page to save
  *
  * @uses $adminConfig      for the save path of the flatfiles
  * @uses addStoredPage()  to store the saved file agiain, and overwrite th old stored page
  * 
  * @return bool TRUE if the page was succesfull saved, otherwise FALSE
  * 
  * @static
  * @version 1.1
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.1 add localization
  *    - 1.0.5 removed page statistics  
  *    - 1.0.4 add XssFilter for every value  
  *    - 1.0.3 creates now category folder automatically  
  *    - 1.0.2 add preg_replace removing multiple slashes
  *    - 1.0.1 add chmod
  *    - 1.0 initial release
  * 
  */
  public static function savePage($pageContent) {
    
    // check if array is pageContent array
    if(!self::isPageContentArray($pageContent))
      return false;

    // safety to dont save pages without ID
    if(empty($pageContent['id']) || !is_numeric($pageContent['id']) || (empty($pageContent['category']) && $pageContent['category'] != 0))
        return false;
    
    $pageId = $pageContent['id'];
    $categoryId = $pageContent['category'];
    
    // check if category folder exists
    if($categoryId != 0 && !is_dir(dirname(__FILE__).'/../../pages/'.$categoryId))
      @mkdir(dirname(__FILE__).'/../../pages/'.$categoryId,self::$adminConfig['permissions'],true);
    
    // get path
    $filePath = ($categoryId === false || $categoryId == 0)
    ? dirname(__FILE__).'/../../pages/'.$pageId.'.php'
    : dirname(__FILE__).'/../../pages/'.$categoryId.'/'.$pageId.'.php';

    // escape \ and '
    $pageContent = XssFilter::escapeBasics($pageContent);
   
    // CREATE file content
    $fileContent = '';
    $fileContent .= "<?php\n";
    
    $fileContent .= "\$pageContent['id']                 = ".XssFilter::int($pageContent['id'],0).";\n";
    $fileContent .= "\$pageContent['category']           = ".XssFilter::int($pageContent['category'],0).";\n";
    $fileContent .= "\$pageContent['subCategory']        = ".XssFilter::int($pageContent['subCategory'],'false').";\n";
    $fileContent .= "\$pageContent['sortOrder']          = ".XssFilter::int($pageContent['sortOrder'],0).";\n";
    $fileContent .= "\$pageContent['public']             = ".XssFilter::bool($pageContent['public'],true).";\n\n";
    
    $fileContent .= "\$pageContent['lastSaveDate']       = ".XssFilter::int($pageContent['lastSaveDate'],0).";\n";
    $fileContent .= "\$pageContent['lastSaveAuthor']     = ".XssFilter::int($pageContent['lastSaveAuthor'],'false').";\n\n"; 
    
    $fileContent .= "\$pageContent['pageDate']['date']   = ".XssFilter::int($pageContent['pageDate']['date'],0).";\n\n";

    // write the plugins
    if(is_array($pageContent['plugins'])) {
      foreach($pageContent['plugins'] as $key => $value) {
        // save plugin settings only if plugin is activated
        if($pageContent['plugins'][$key]['active']) {
          foreach($value as $insideKey => $finalValue) {
            // CHECK BOOL VALUES and change to FALSE
            if(strpos(strtolower($insideKey),'bool') !== false ||
               is_bool($pageContent['plugins'][$key][$insideKey]) ||
               $pageContent['plugins'][$key][$insideKey] == 'true' ||
               $pageContent['plugins'][$key][$insideKey] == 'false')
              $fileContent .= "\$pageContent['plugins']['".$key."']['".$insideKey."'] = ".XssFilter::bool($pageContent['plugins'][$key][$insideKey],true).";\n";
            elseif(strpos(strtolower($insideKey),'url') !== false)
              $fileContent .= "\$pageContent['plugins']['".$key."']['".$insideKey."'] = '".XssFilter::url($pageContent['plugins'][$key][$insideKey])."';\n";
            elseif(strpos(strtolower($insideKey),'path') !== false)
              $fileContent .= "\$pageContent['plugins']['".$key."']['".$insideKey."'] = '".XssFilter::path($pageContent['plugins'][$key][$insideKey])."';\n";
            elseif(strpos(strtolower($insideKey),'number') !== false)
              $fileContent .= "\$pageContent['plugins']['".$key."']['".$insideKey."'] = '".XssFilter::number($pageContent['plugins'][$key][$insideKey])."';\n";
            else
              $fileContent .= "\$pageContent['plugins']['".$key."']['".$insideKey."'] = '".XssFilter::text($pageContent['plugins'][$key][$insideKey])."';\n";
          }
          $fileContent .= "\n";
        }        
      }
    }
    
    $fileContent .= "\$pageContent['thumbnail']          = '".XssFilter::filename($pageContent['thumbnail'])."';\n";
    $fileContent .= "\$pageContent['styleFile']          = '".$pageContent['styleFile']."';\n"; //XssFilter is in prepareStyleFilePaths() function
    $fileContent .= "\$pageContent['styleId']            = '".XssFilter::string($pageContent['styleId'])."';\n";
    $fileContent .= "\$pageContent['styleClass']         = '".XssFilter::string($pageContent['styleClass'])."';\n\n";

    // save localized
    if(is_array($pageContent['localized'])) {
      foreach ($pageContent['localized'] as $langCode => $pageContentLocalized) {

        // remove the '' when its 0 (for non localized pages)
        $langCode = (is_numeric($langCode)) ? $langCode : "'".$langCode."'";

        $fileContent .= "\$pageContent['localized'][".$langCode."]['pageDate']['before'] = '".XssFilter::text($pageContentLocalized['pageDate']['before'])."';\n";
        $fileContent .= "\$pageContent['localized'][".$langCode."]['pageDate']['after']  = '".XssFilter::text($pageContentLocalized['pageDate']['after'])."';\n";
        $fileContent .= "\$pageContent['localized'][".$langCode."]['tags']               = '".XssFilter::text($pageContentLocalized['tags'])."';\n";
        $fileContent .= "\$pageContent['localized'][".$langCode."]['title']              = '".self::htmLawed(strip_tags($pageContentLocalized['title'],'<a><span><em><strong><i><b><abbr><code><samp><kbd><var>'))."';\n";
        $fileContent .= "\$pageContent['localized'][".$langCode."]['description']        = '".XssFilter::text($pageContentLocalized['description'])."';\n";

        $content = (self::$adminConfig['editor']['htmlLawed']) ? self::htmLawed($pageContentLocalized['content']) : $pageContentLocalized['content'];
        $fileContent .= "\$pageContent['localized'][".$langCode."]['content']            = '".trim($content)."';\n\n";
      }
    }
    
    $fileContent .= "return \$pageContent;";
    $fileContent .= "\n?>";
    
    if(file_put_contents($filePath, $fileContent, LOCK_EX)) {
      
      @chmod($filePath,self::$adminConfig['permissions']);

      // writes the new saved page to the $storedPages property      
      self::removeStoredPage($pageContent['id']); // remove the old one
      unset($pageContent);
      $pageContent = include($filePath);
      self::addStoredPage($pageContent);

      // reload the $pagesMetaData array
      self::savePagesMetaData();
      
      return true;
    } else
      return false;
  }

 /**
  * <b>Name</b> savePagesMetaData()<br>
  * 
  * Save all pages meta data in an array, to faster access them.
  * It also reloads them as propertiesin the GeneralFunctions and StatisticsFunctions classes.
  *
  * 
  * Example of the $pagesMetaData array:
  * {@example pagesMetaData.array.example.php}
  * 
  *
  * @uses loadPages()  to get all pages content
  * 
  * @return bool TRUE if the meta data was succesfull saved, otherwise FALSE
  * 
  * @static
  * @version 1.1
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.1 add tags to the meta data, to speed up tag comparision
  *    - 1.0 initial release
  * 
  */
  public static function savePagesMetaData() {

    // vars
    // self::$storedPages = null;
    self::$websiteConfig = $GLOBALS['websiteConfig'];
    $pages = array();

    // ->> GET ALL PAGES, which are inside the /pages/ folder
    $files = self::readFolderRecursive(dirname(__FILE__).'/../../pages/');
    if(is_array($files['files'])) {
      foreach ($files['files'] as $file) {
        // load category pages
        if(preg_match('#^.*\/([0-9]+)/([0-9]+)\.php$#',$file,$match)) {
          $pages[] = self::readPage($match[2],$match[1]);
        // load non category pages
        } elseif(preg_match('#^.*/([0-9]+)\.php$#',$file,$match)) {
          $pages[] = self::readPage($match[1]);
        }
      }
    } 

    // -> dont save the file, if there are no pages
    if(empty($pages)) {
      @unlink(dirname(__FILE__).'/../../pages/pagesMetaData.array.php');
      return false;
    }

    $fileContent = "<?php\n";
   
    foreach ($pages as $pageContent) {

      // CREATE file content      
      $fileContent .= "\$pagesMetaData[".$pageContent['id']."]['id']       = ".XssFilter::int($pageContent['id'],0).";\n";
      $fileContent .= "\$pagesMetaData[".$pageContent['id']."]['category'] = ".XssFilter::int($pageContent['category'],0).";\n";
      if(self::$websiteConfig['startPage'] == $pageContent['id'])
        $fileContent .= "\$pagesMetaData[".$pageContent['id']."]['startPage'] = true;\n";

      // save localized titles
      if(is_array($pageContent['localized'])) {
        foreach ($pageContent['localized'] as $langCode => $pageContentLocalized) {
          // remove the '' when its 0 (for non localized pages)
          $langCode = (is_numeric($langCode)) ? $langCode : "'".$langCode."'";
          $fileContent .= "\$pagesMetaData[".$pageContent['id']."]['localized'][".$langCode."]['title'] = '".XssFilter::text($pageContentLocalized['title'])."';\n";
          $fileContent .= "\$pagesMetaData[".$pageContent['id']."]['localized'][".$langCode."]['tags']  = '".XssFilter::text($pageContentLocalized['tags'])."';\n";
        }
      }
       $fileContent .= "\n";
      
    }
    $fileContent .= "return \$pagesMetaData;";
    $fileContent .= "\n?>";

    // save the array
    if(file_put_contents(dirname(__FILE__).'/../../pages/pagesMetaData.array.php', $fileContent, LOCK_EX)) {
      @chmod($filePath,self::$adminConfig['permissions']);
      // reload the $pagesMetaData array
      unset($GLOBALS['pagesMetaData']); $GLOBALS['pagesMetaData'] = include(dirname(__FILE__)."/../../pages/pagesMetaData.array.php");
      self::$pagesMetaData               = $GLOBALS['pagesMetaData'];
      StatisticFunctions::$pagesMetaData = $GLOBALS['pagesMetaData'];
      return true;
    } else
      return false;

  }
  
 /**
  * <b>Name</b> loadPages()<br>
  * 
  * Loads the $pageContent arrays from pages in a specific category(ies) or all categories.
  * 
  * Loads all $pageContent arrays of a given category, by going through the {@link $pagesMetaData} array.
  * It check first whether the current $pageContent array was not already loaded and is contained in the {@link $storedPages} property.
  * If not the {@link GeneralFunctions::readPage()} public static function is called to include the $pagecontent array of the page
  * and store it in the {@link $storedPages} property.
  * 
  * <b>Note</b>: after loading all $pageContent arrays of a category, the array with the containing $pageContent arrays will be sorted.
  * 
  * Example of the returned $pageContent arrays:
  * {@example loadPages.return.example.php}
  * 
  * @param bool|int|array  $category           (optional) a category ID, or an array with category IDs. TRUE to load all categories (including the non-category) or FALSE to load only the non-category pages
  * @param bool		         $loadPagesInArray   (optional) if TRUE it returns the $pageContent arrays of the pages in the categories, if FALSE it only returns the page IDs of the requested category(ies). See the <var>$pagesMetaData</var> example below
  * 
  * @uses $categoryConfig     to get the sorting of the category
  * @uses getStoredPages()		for getting the {@link $storedPages} property
  * @uses readPage()			    to load the $pageContent array of the page
  * 
  * @return array an array with the $pageContent arrays of the requested pages
  * 
  * @example pagesMetaData.array.example.php
  * 
  * @static
  * @version 1.1
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.1 removed getStroredPageIds and use $pagesMetaData now
  *    - 1.0.1 add a simpler way of createing array with non category id in it
  *    - 1.0 initial release
  * 
  */  
  public static function loadPages($category = false, $loadPagesInArray = true) {
    
    // IF $category FALSE set $category to 0
    if($category === false)
      $category = 0;
    
    // ->> RETURN $pageContent arrays
    if($loadPagesInArray === true) {
      
      //vars
      $pagesArray = array();

      // IF $category TRUE create array with non-category and all category IDs
      if($category === true) {
      	// puts the categories IDs in an array
      	$category = array(0);
        if(is_array(self::$categoryConfig))
          $category = array_merge($category,array_keys(self::$categoryConfig));
      }
      
      // change category into array
      if(is_numeric($category))
        $category = array($category);
      
      // go trough all given CATEGORIES
      if(is_array($category)) {
        foreach($category as $categoryId) {
          
          // go trough the $pagesMetaData and open the page in it
          $newPageContentArrays = array();
          foreach(self::$pagesMetaData as $pageMetaData) {
            // use only pages from the right category
            if($pageMetaData['category'] == $categoryId) {
              //echo 'PAGE: '.$pageIdAndCategory['page'].' -> '.$categoryId.'<br>';
              $newPageContentArrays[] = self::readPage($pageMetaData['id'],$pageMetaData['category']);            
            }
          }
          
          // sorts the category
          if(is_array($newPageContentArrays)) { // && !empty($categoryId) <- prevents sorting of the non-category
            $newPageContentArrays = self::sortPages($newPageContentArrays);
          }
        
          // adds the new sorted category to the return array
          $pagesArray = array_merge($pagesArray,$newPageContentArrays);
        }
      }
      //print_r($pagesArray);
      return $pagesArray;
      
    // ->> RETURN ONLY the page & category IDs
    } else {      
      $newPageIds = false;
      if($category === true)
        $newPageIds = $pageMetaData;
      else {
        foreach(self::$pagesMetaData as $pageMetaData) {
          if($category == $pageMetaData['category'] ||
             (is_array($category) && in_array($pageMetaData['category'],$category)))
            $newPageIds[] = $pageMetaData;
        }
      }
      return $newPageIds;
    }
  }
  
 /**
  * <b>Name</b> loadPagesStatistics()<br>
  * 
  * Loads the $pageStatistics arrays from pages in a specific category(ies) or all categories.
  * 
  * Loads all $pageStatistics arrays of a given category, by going through the {@link $pagesMetaData} property and load the right "[pageID].statistics.php".
  * 
  * <b>Note</b>: after loading all $pageStatistics arrays of a category, the array with the containing $pageStatistics arrays will be sorted.
  * 
  * Example of the returned $pageStatistics arrays:
  * {@example loadPagesStatistics.return.example.php}
  * 
  * @param bool|int|array  $category           (optional) a category ID, or an array with category IDs. TRUE to load all categories (including the non-category) or FALSE to load only the non-category pages
  * 
  * @uses $categoryConfig               to get the sorting of the category
  * @uses getStoredPages()		          for getting the {@link $storedPages} property
  * @uses readPageStatistics()			    to load the $pageStatistics array of the page
  * 
  * @return array an array with the $pageStatistic arrays of the requested pages
  * 
  * @static
  * @version 1.0
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.0 initial release
  * 
  */  
  public static function loadPagesStatistics($category = false) {
    
    // IF $category FALSE set $category to 0
    if($category === false)
      $category = 0;
      
    //vars
    $pagesStatsArray = array();

    // IF $category TRUE create array with non-category and all category IDs
    if($category === true) {
    	// puts the categories IDs in an array
    	$category = array(0); // start with the non category
    	if(is_array(self::$categoryConfig)) {
      	foreach(self::$categoryConfig as $eachCategory) {
      	  $category[] = $eachCategory['id'];
      	}
    	}
    }
    
    // change category into array
    if(is_numeric($category))
      $category = array($category);
      
    // go trough all given CATEGORIES
    if(is_array($category)) {
      foreach($category as $categoryId) {
        
        // go trough the $pagesMetaData and open the page in it
        $pageStatisticsArrays = array();
        foreach(self::$pagesMetaData as $pageMetaData) {
          // use only pages from the right category
          if($pageMetaData['category'] == $categoryId) {
            if($pageStats = StatisticFunctions::readPageStatistics($pageMetaData['id']))
              $pageStatisticsArrays[] = $pageStats;
          }
        }
        
        /*
        // sorts the category
        if(is_array($pageStatisticsArrays)) { // && !empty($categoryId) <- prevents sorting of the non-category
          $newPageContentArrays = self::sortPages($newPageContentArrays);
        }
        */
      
        // adds the new sorted category to the return array
        $pagesStatsArray = array_merge($pagesStatsArray,$pageStatisticsArrays);
      }
    }
    //print_r($pagesArray);
    return $pagesStatsArray;

  }

 /**
  * <b>Name</b> isPublicCategory()<br>
  * 
  * Checks whether the given category(ies) are public and returns the ID or an array with IDs of the public ones.
  * 
  *
  * <b>Note</b>: This method can either return 0 for the non-category or false. Use "… === false" to check if a category is not public.
  *
  * @param int|array|bool $ids the category or page ID(s), can be a number or an array with numbers, if TRUE then it check all categories
  * 
  * @uses $categoryConfig      to check if a category is public
  * 
  * @return array|int|false an array with ID(s) or the ID of the public category(ies)
  * 
  * @access protected
  * @version 1.0.1
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.0.1 add non category to be public
  *    - 1.0 initial release
  * 
  */
  public static function isPublicCategory($ids) {
    
    // var
    $newIds = false;
    
    if($ids === true) {
      
        // adds the non-category
        $newIds[] = 0;
        
        foreach(self::$categoryConfig as $category) {
          // checks if the category is public and creates a new array
          if($category['public'])
            $newIds[] = $category['id'];
        }
      // ->> MULITPLE categories
    } elseif(is_array($ids)) {
      // goes trough the given category IDs array
      foreach($ids as $id) {
        // checks if the category is public and creates a new array
      	if($id == 0 || (isset(self::$categoryConfig[$id]) && self::$categoryConfig[$id]['public']))    
      	  $newIds[] = $id;
            }
      
    // -> SINGLE category ID
    } elseif(is_numeric($ids) || empty($ids)) {

      // checks if the category is public
      if(self::$categoryConfig[$ids]['public'])    
        return $ids;
      elseif(empty($ids))
        return 0;
      else return false;
    
    } else return false;
    
    // and return the new category IDs array
    return $newIds;
  }

 /**
  * <b>Name</b> isPageContentArray()<br>
  * 
  * Checks the given <var>$page</var> parameter is a valid <var>$pageContent</var> array.
  * 
  * @param int|array $page   the variable to check 
  * 
  * @return bool
  * 
  * @static
  * @version 1.0
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.0 initial release
  * 
  */
  public static function isPageContentArray($page) {
    if(is_array($page) && array_key_exists('id',$page) && array_key_exists('category',$page) && array_key_exists('sortOrder',$page))
      return true;
    else
      return false;
  }

 /** 
  * <b>Name</b> getDateTimeValue()<br>
  * 
  * formats the date passed into format required by 'datetime' attribute of <time> tag.
  * If no intDate supplied, uses current date.
  * 
  * @param int  intDate  integer optional
  * @param bool onlyDate whether or not the datetime attribute should contain only the date or add the time also
  * 
  * @return string time value in the format: 2009-09-04T16:31:24+02:00
  * 
  * @link http://petewilliams.info/blog/2010/09/generate-html5-time-tags-datetime-attribute-in-php/
  * 
  * @static
  * @version 1.0
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.0 initial release
  * 
  */
  public static function getDateTimeValue($intDate = null, $onlyDate = true) {


      if($onlyDate)
        $strFormat = 'Y-m-d';
      else
        $strFormat = 'Y-m-d\TH:i:sP';
      $strDate = $intDate ? date( $strFormat, $intDate ) : date( $strFormat ) ; 
      
      return $strDate;
  }

 /**
  * <b>Name</b> formatDate()<br>
  * 
  * Converst a given timestamp into the a specific format type.
  * 
  * @param int    $timeStamp a UNIX-Timestamp
  * @param string $format    (optional) the format type can be "DMY" to format into: "DD-MM-YYYY", "YMD" to format into: "YYYYY-MM-DD" or "MDY" to format into: "MM-DD-YYYYY", if FALSE it uses the format set in the administrator-settings config
  * 
  * @uses $adminConfig  to get the right date format, if no format is given
  * 
  * @return string the formated date or the unchanged $timestamp parameter
  * 
  * @static
  * @version 1.1
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.1 moved to GeneralFunctions
  *    - 1.01 changed from date conversion to timestamp
  *    - 1.0 initial release
  * 
  */
  public static function formatDate($timeStamp, $format = false) {
    
    if(empty($timeStamp) || !preg_match('/^[0-9]{1,}$/',$timeStamp))
      return $timeStamp;
             
    if($format === false)
      $format = self::$adminConfig['dateFormat'];
    
    switch ($format) {
      case 'YMD':
        return date('Y-m-d',$timeStamp);
        break;
      case 'DMY':
        return date('d.m.Y',$timeStamp);
        break;
      case 'MDY':
        return date('m/d/Y',$timeStamp);
        break;
      default:
        return $timeStamp;
        break;
    }
  }

 /**
  * <b>Name</b> dateDayBeforeAfter()<br>
  * 
  * Replaces the given <var>$date</var> parameter with "yesterday", "today" or "tomorrow" if it is one day before or the same day or one day after today.
  * 
  * <b>Used Global Variables</b><br>
  *    - <var>$langFile</var> the backend language-file array (included in the {@link backend.include.php})
  * 
  * @param int          $timestamp      the timestamp to check
  * @param array|false  $langFile       the languageFile which contains the ['DATE_TEXT_YESTERDAY'], ['DATE_TEXT_TODAY'] and ['DATE_TEXT_TOMORROW'] texts, if FALSE it loads the backend language-file
  * 
  * @return string|int a string with "yesterday", "today" or "tomorrow" or the unchanged timestamp
  * 
  * @static
  * @version 1.1
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.1 moved to GeneralFunctions
  *    - 1.0 initial release
  * 
  */ 
  public static function dateDayBeforeAfter($timestamp,$langFile = false) {
    
    if(empty($timestamp) || !preg_match('/^[0-9]{1,}$/',$timestamp))
      return $timestamp;

    //var
    $date = date('Y-m-d',$timestamp);
    
    if($langFile === false)
      $langFile = $GLOBALS['langFile'];
    
    // if the date is TODAY
    if(substr($date,0,10) == date('Y-m-d'))
      return $langFile['DATE_TEXT_TODAY'];
    
    // if the date is YESTERDAY
    elseif(substr($date,0,10) == date('Y-m-').sprintf("%02d",(date('d')-1)))
      return $langFile['DATE_TEXT_YESTERDAY'];
    
    // if the date is TOMORROW
    elseif(substr($date,0,10) == date('Y-m-').sprintf("%02d",(date('d')+1)))
      return $langFile['DATE_TEXT_TOMORROW'];
  
    else
      return $timestamp;
  }
  
 /**
  * <b>Name</b> checkPageDate()<br>
  * 
  * Returns TRUE if the page date exists and is activated in this category of the page.
  * 
  * @param array $pageContent the $pageContent array of a page
  * 
  * @uses $categoryConfig to check if in the category the page date is activated
  * 
  * @return bool
  * 
  * @static
  * @version 1.2
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.2 moved to GeneralFunctions
  *    - 1.1 add pagedate for non-categories  
  *    - 1.0 initial release
  * 
  */
  public static function checkPageDate($pageContent) {
    $pageDate = self::getLocalized($pageContent,'pageDate');
    $pageDateBefore = $pageDate['before'];
    $pageDateAfter = $pageDate['after'];
    if((($pageContent['category'] != 0 && self::$categoryConfig[$pageContent['category']]['showPageDate']) ||
       ($pageContent['category'] == 0 && self::$adminConfig['pages']['showPageDate'])) &&
       (!empty($pageDateBefore) || !empty($pageContent['pageDate']['date']) || $pageContent['pageDate']['date'] === 0 || !empty($pageDateAfter)))
       return true;
    else
       return false;
  }

 /**
  * <b>Name</b> getFlagHref()<br>
  * 
  * Returns the right flag from the <var>library/images/icons/flags</var> folder.
  * If no flag with the given <var>$countryCode</var> parameter exists, it returns a generic flag (<var>library/images/icons/flags/none.png</var>).
  * 
  * @param string $countryCode a country code like "en"
  * @param bool   $backend     (optional) if true it removes the feindura basePath
  * 
  * @return string the URL of the flag, relative to the "feindura" folder
  * 
  * @version 1.1
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.1 moved to GeneralFunctions
  *    - 1.0 initial release
  * 
  */
  public static function getFlagHref($countryCode, $backend = true) {

    // var
    $countryCode = strtolower($countryCode);
    $flagFilename = (file_exists(dirname(__FILE__).'/../images/icons/flags/'.$countryCode.'.png'))
      ? $countryCode.'.png'
      : 'none.png';

    return ($backend)
      ? 'library/images/icons/flags/'.$flagFilename
      : self::$adminConfig['basePath'].'library/images/icons/flags/'.$flagFilename;
  }

 /**
  * <b>Name</b> replaceLinks()<br>
  * 
  * Replaces all feindura links (e.g. "?feinduraPageID=3") inside the given <var>$pageContentString</var> parameter, with real href links.
  *
  * @param string      $pageContentString the page content string, to replace all feindura links, with real hrefs
  * @param bool|string $sessionId         (optional) the session id which should be transported to the {@link GeneralFunctions::createHref()} method
  * @param bool|string $language          (optional) the language code id which should be transported to the {@link GeneralFunctions::createHref()} method
  * @param bool        $fullUrl           (optional) if TRUE it replaces the links with full URLs (containing the domain)
  * 
  * @uses GeneralFunctions::readPage()    to load the page for createHref()
  * @uses GeneralFunctions::createHref()  to create the hreaf of the link
  * @uses FeinduraBase::language
  * 
  * @return string the $pageContentString with replaced feindura links
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
  public function replaceLinks($pageContentString,$sessionId = false,$language = false,$fullUrl = false) {
    if(preg_match_all ('#\?*feinduraPageID\=([0-9]+)#i', $pageContentString, $matches,PREG_SET_ORDER)) {
      // replace each link
      foreach($matches as $match) {
        $pageContentString = str_replace($match[0],self::createHref(GeneralFunctions::readPage($match[1],self::getPageCategory($match[1])),$sessionId,$language,$fullUrl),$pageContentString);
      }
    }
    return $pageContentString;
  }

/**
  * <b>Name</b> replaceCodeSnippets()<br>
  * 
  * Replaces all feindura code snippets (e.g. "<img class="feinduraSnippet"...>) inside the given <var>$pageContentString</var> parameter, with either a code snippet or a plugin.
  *
  * @param string      $pageContentString the page content string, to replace all feindura links, with real hrefs
  * @param int         $pageId            the current page ID to load the right plugins.
  * @param bool        $removeSnippets    (optional) will only remove the snippets placeholder from the <var>$pageContentString</var>
  * 
  * @uses GeneralFunctions::$FeinduraCLass
  * 
  * @return string the $pageContentString with replaced code snippets
  * 
  * @see FeinduraBase::generatePage()
  * @see saveFeeds()
  * 
  * @access protected
  * @version 1.0
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.0 initial release
  * 
  */
  public function replaceCodeSnippets($pageContentString, $pageId, $removeSnippets = false) {

    // get the Feindura class to be used inside the snippets/plugins
    if(!$removeSnippets) {
      if($this instanceof Feindura) {
        $feindura = $this;
      } else {
        if(!(self::$FeinduraCLass instanceof Feindura))
          self::$FeinduraCLass = new Feindura();
        $feindura = self::$FeinduraCLass;
        $feindura->page = $pageId;
        $feindura->category = self::getPageCategory($pageId);
      }
    }

    // vars (change varnames so it doesnt get overwritten)
    $feindura_pageContentString = $pageContentString;


    if(preg_match_all ('#<img.*class\=\"(feinduraSnippet|feinduraPlugin)\"[^>]*(?:style\=\"((?:(?:width|height)\:\s?(?:[0-9]*(?:%|px))\;\s?){0,2})\")?[^>]*title\="([^\"]+)"[^>]*>#i', $feindura_pageContentString, $matches,PREG_SET_ORDER)) {
      // replace each link
      foreach($matches as $feindura_match) {

        // -> REMOVE snippets
        if($removeSnippets) {
          $feindura_pageContentString = str_replace($feindura_match[0],'',$feindura_pageContentString);


        // -> REPLACE snippets
        } else {

          // unset unneccessary vars
          unset($removeSnippets,$pageContentString);

          // -> SNIPPET
          if($feindura_match[1] === 'feinduraSnippet') {

            // available vars in the snippet
            $GLOBALS['ISSNIPPET'] = true;
            $feindura;
            $pageId;
            $categoryId = self::getPageCategory($pageId);

            // Store the content of the snippet in a variable
            ob_start();
              include(dirname(__FILE__).'/../../snippets/'.$feindura_match[3]);
              $snippet = ob_get_contents();
            ob_end_clean();

            // replace snippet placeholder
            $feindura_pageContentString = str_replace($feindura_match[0],$snippet,$feindura_pageContentString);

            unset($GLOBALS['ISSNIPPET']);

          // -> PLUGIN
          } elseif($feindura_match[1] === 'feinduraPlugin') {

            // CHECK if inside FEINDURA class
            if($feindura instanceof Feindura && is_numeric($pageId)) {

              // replace snippet placeholder
              $feindura_pageContentString = str_replace($feindura_match[0],$feindura->showPlugins($feindura_match[3],$pageId,$feindura_match[2]),$feindura_pageContentString);

            // if not Feindura class, remove the plugins snippet
            } else
              $feindura_pageContentString = str_replace($feindura_match[0],'',$feindura_pageContentString);

          }
        }
      }
    }
    return $feindura_pageContentString;
  }

 /**
  * <b>Name</b> createHref()<br>
  * 
  * Creates a href-attribute from the given <var>$pageContent</var> parameter,
  * if the <var>sessionId</var> parameter is given it adds them on the end of the href string.
  * 
  * @param array        $pageContent  the $pageContent array of a page
  * @param string|false $sessionId    (optional) the session ID string in the following format: "sessionName=sessionId"
  * @param bool|string  $languageCode (optional) a language code to use when generating the link, if FALSE it uses the <var>$_SESSION['feinduraSession']['websiteLanguage']</var> variable
  * @param bool         $fullUrl      (optional) if TRUE it add also the URL to the href path  
  * 
  * @uses $adminConfig    for the variabel names which the $_GET variable will use for category and page and the when speakingURLs, for the websitePath
  * @uses $categoryConfig for the category name if speaking URLs i activated
  *  
  * @return string the href string ready to use in a href attribute
  * 
  * @see Feindura::createHref()
  * 
  * @static
  * @version 2.0
  * <br>
  * <b>ChangeLog</b><br>
  *    - 2.0 add parent pages
  *    - 1.0.1 changed websitepath; getting dirname now  
  *    - 1.0 initial release
  * 
  */
  public static function createHref($pageContent, $sessionId = false, $languageCode = false,$fullUrl = false) {
    
    if(!self::isPageContentArray($pageContent))
      return false;
    
    // vars
    $page = $pageContent['id'];
    $category = $pageContent['category'];
    $href = '';
    $language = (is_string($languageCode) && strlen($languageCode) == 2) ? $languageCode : $_SESSION['feinduraSession']['websiteLanguage']; // $languageCode == false is only in the backend

    
    // add (url) and websitepath
    if($fullUrl) $href .= self::$adminConfig['url'];
    
    // ->> create HREF with speaking URL
    // *************************************
    if(self::$adminConfig['speakingUrl'] == 'true') {
      
      $href .= self::getDirname(self::$adminConfig['websitePath']);

      // add the LANGUAGE if multilanguage page
      if(self::$adminConfig['multiLanguageWebsite']['active']) {
        $href .= $language.'/';
      }

      // -> add PARENT PAGES
      $parentPagesString = false;
      $categoryNameString = false;
      if($category != 0 && ($parentPages = self::getParentPages($category))) {
        foreach ($parentPages as $parentPageContent) {

          // only show the category, if the parents page category is not a sub category
          if($parentPageContent['category'] != 0 && !self::$categoryConfig[$parentPageContent['category']]['isSubCategory'])
            $categoryNameString .= StatisticFunctions::urlEncode(self::getLocalized(self::$categoryConfig[$parentPageContent['category']],'name',$language)).'/';

          $parentPagesString .= StatisticFunctions::urlEncode(self::getLocalized($parentPageContent,'title',$language)).'/';
        }

      // -> add the CATEGORY NAME
      } elseif($category != 0)
        $categoryNameString .= StatisticFunctions::urlEncode(self::getLocalized(self::$categoryConfig[$category],'name',$language)).'/';
      
      // -> add the CATEGORY or PAGE word
      if($categoryNameString && $category != 0)
        $href .= 'category/'.$categoryNameString.$parentPagesString;
      else
        $href .= 'page/'.$parentPagesString;

      // -> add PAGE NAME
      $href .= StatisticFunctions::urlEncode(self::getLocalized($pageContent,'title',$language));
      $href .= '/'; //'.html';
      
      if($sessionId)
        $href .= '?'.$sessionId;
      
      return $href;
    
    // ->> create HREF with varNames und Ids
    // *************************************
    } else {
      
      $href .= self::$adminConfig['websitePath'];
      $href .= '?';

      // -> add PARENT PAGES
      $parentPagesString = '';
      if($category != 0 && ($parentPages = self::getParentPages($category))) {
        $parentPagesString .= '&amp;parentPages=';

        $parentPages = array_reverse($parentPages);
        foreach ($parentPages as $parentPageContent) {
          $parentPagesString .= $parentPageContent['id'].',';
        }
        $parentPagesString = trim($parentPagesString,',');
      } 

      // -> add the CATEGORY
      if($category != 0)
        $href .= self::$adminConfig['varName']['category'].'='.$category.'&amp;';
      
      // -> add PAGE
      $href .= self::$adminConfig['varName']['page'].'='.$page;

      // -> add PARENT PAGES
      $href .= $parentPagesString;

      // add the LANGUAGE if multilanguage page
      if(self::$adminConfig['multiLanguageWebsite']['active'])
        $href .= '&amp;language='.$language;
      
      if($sessionId)
        $href .= '&amp;'.$sessionId;
      
      return $href;
    }  
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
  * @param string|false   $sessionId          to transport to {@link GeneralFunctions::replacelinks()}
  * @param string|false   $language           to transport to {@link GeneralFunctions::replacelinks()}
  * 
  * @uses GeneralFunctions::$adminConfig       to check for frontend editing
  * @uses $xHtml
  *   
  * 
  * @uses GeneralFunctions::htmLawed()
  * @uses GeneralFunctions::replaceLinks()
  * @uses GeneralFunctions::replaceCodeSnippets()
  * @uses GeneralFunctions::shortenHtmlText()
  * 
  * 
  * @return string the generated page content
  * 
  * @see FeinduraBase::generatePage()
  * 
  * @static
  * @version 1.0
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.0 initial release
  * 
  */
  public static function generateContent($pageContentString, $pageId, $sessionId, $language) {

    // -> when content is not empty
    if(!empty($pageContentString)) {
      
      if(self::$adminConfig['editor']['safeHtml'])
        $htmlLawedConfig['safe'] = 1;
      else
        $htmlLawedConfig['safe'] = 0;
      if($xHtml)
        $htmlLawedConfig['valid_xhtml'] = 1;
      else
        $htmlLawedConfig['valid_xhtml'] = 0;
      $pageContentEdited = (self::$adminConfig['editor']['htmlLawed']) ? self::htmLawed($pageContentString,$htmlLawedConfig) : $pageContentString;
      
      // replace feindura links
      $pageContentEdited = self::replaceLinks($pageContentEdited,$sessionId,$language);
      $pageContentEdited = self::replaceCodeSnippets($pageContentEdited,$pageId);
    
    // -> show no content
    } else
      $pageContentEdited = '';

    return $pageContentEdited;
  }

 /**
  * <b>Name</b> sortPages()<br>
  * 
  * Sort an array with the <var>$pageContent</var> arrays by a given sort-public static function.
  * The following sort public static functions can be used for the <var>$sortBy</var> parameter:<br>
  *   - "sortBySortOrder"
  *   - "sortByCategory"
  *   - "sortByDate"
  *   - "sortByVisitedCount"
  *   - "sortByVisitTimeMax"  
  * 
  * @param array        $pageContentArrays  the $pageContent array of a page
  * @param string|false $sortBy             (optional) the name of the sort public static function, if FALSE it uses automaticly the right sort-public static function of the category
  * 
  * @uses $categoryConfig        to find the right sort public static function for every category
  * @uses isPageContentArray()   to check if the given $pageContent arrays are valid
  * @uses sortBySortOrder()      to sort the pages by sortorder
  * @uses sortByDate()           to sort the pages by page date  
  * 
  * @return array the sorted array with the $pageContent arrays
  * 
  * @see sort.public static functions.php
  * 
  * @static
  * @version 1.0
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.0 initial release
  * 
  */
  public static function sortPages($pageContentArrays, $sortBy = false) {
    
    if(is_array($pageContentArrays) && isset($pageContentArrays[0])) {
    
      // CHECK if the arrays are valid $pageContent arrays
      // OTHER BUTTONSwise return the unchanged array
      if(!self::isPageContentArray($pageContentArrays[0]))
        return $pageContentArrays;
      
      // sorts the array with the given sort public static function
      //natsort($pagesArray);
      
      // first sort the ARRAY by CATEGORY
      usort($pageContentArrays, 'sortByCategory');
      
      // -> SPLIT the ARRAY IN CATEGORIES
      $lastCategory = false;
      $newPageContentArrays = array();
      foreach($pageContentArrays as $pageContentArray) {
          
          //print_r($pageContentArray);
          
          if($pageContentArray['category'] != $lastCategory) {
            $categoriesArrays[] = $newPageContentArrays;
            $newPageContentArrays = array();
          }
          
          // adds the pageContent Array to a new array
          $newPageContentArrays[] = $pageContentArray;  
          $lastCategory = $pageContentArray['category'];
      }
      // adds the last $newPageContentArrays
      $categoriesArrays[] = $newPageContentArrays;
      
      // -> SORTS every CATEGORY
      $newPageContentArray = array();
      $category = false;   
      foreach($categoriesArrays as $categoriesArray) {        
        
        // gets the current category
        if(isset($categoriesArray[0]))
          $category = $categoriesArray[0]['category'];
        
        // SORTS the category the GIVEN SORTFUNCTION
        if($sortBy === false) {
          if(($category != 0 && self::$categoryConfig[$category]['sorting'] == 'byPageDate') ||
             ($category == 0 && self::$adminConfig['pages']['sorting'] == 'byPageDate'))
            usort($categoriesArray, 'sortByDate');
          elseif(($category != 0 && self::$categoryConfig[$category]['sorting'] == 'alphabetical') ||
                 ($category == 0 && self::$adminConfig['pages']['sorting'] == 'alphabetical'))
            usort($categoriesArray, 'sortAlphabetical');
          else
            usort($categoriesArray, 'sortBySortOrder');
        } else
            usort($categoriesArray, $sortBy);
        
        // reverse the category, if its in the options
        if(($category != 0 && self::$categoryConfig[$category]['sortReverse']) ||
           ($category == 0 && self::$adminConfig['pages']['sortReverse']))
          $categoriesArray = array_reverse($categoriesArray);
         
        foreach($categoriesArray as $pageContent) {
          // creates the NEW sorted array
          $newPageContentArray[] = $pageContent;
        }
      }
      
      return $newPageContentArray;
    } else
      return $pageContentArrays;
  }

  /**
   * <b>Name</b> getStylesByPriority()<br>
   * 
   * Returns the right stylesheet-file path, ID or class-attribute.
   * If the <var>$givenStyle</var> parameter is empty,
   * it check if the category has a styleheet-file path, ID or class-attribute set return the value if not return the value from the {@link $adminConfig administartor-settings config}.
   * 
   * <b>Used Global Variables</b><br>
   *    - <var>$adminConfig</var> the administrator-settings config (included in the {@link general.include.php}) 
   *    - <var>$categoryConfig</var> the categories-settings config (included in the {@link general.include.php})
   * 
   * @param string $givenStyle the string with the stylesheet-file path, id or class
   * @param string $styleType  the key for the $pageContent, {@link $categoryConfig} or {@link $adminConfig} array can be "styleFile", "styleId" or "styleClass" 
   * @param int    $category   the ID of the category to bubble through
   * 
   * @return string the right stylesheet-file, ID or class
   * 
   * @static
   * @version 1.01
   * <br>
   * <b>ChangeLog</b><br>
   *    - 1.01 moved to GeneralFunctions class   
   *    - 1.0 initial release
   * 
   */
  public static function getStylesByPriority($givenStyle,$styleType,$category) {
    
    // check if the $givenStyle is empty
    if(empty($givenStyle) || $givenStyle == 'a:0:{}') {
    
      return (empty(self::$categoryConfig[$category][$styleType]) || self::$categoryConfig[$category][$styleType] == 'a:0:{}')
        ? self::$adminConfig['editor'][$styleType]
        : self::$categoryConfig[$category][$styleType];
    
    // OTHER BUTTONSwise it passes through the $givenStyle parameter
    } else
      return $givenStyle;
    
  }
  
 /**
  * <b>Name</b> cleanSpecialChars()<br>
  * 
  * Removes all special chars from a string.
  * 
  * @param string    $string          the string to clear
  * @param string    $replaceString   (optional) the string which replaces all special chars found
  * 
  * @return string the cleaned string
  * 
  * @static
  * @version 1.0
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.0 initial release
  * 
  */
  public static function cleanSpecialChars($string,$replaceString = '') {
    
    // removes multiple spaces
    $string = preg_replace("/ +/", ' ', $string);
    // allows only a-z and 0-9, "_", ".", " "
    $string = preg_replace('/[^\w^.^&^;^ ]/u', $replaceString, $string);
    if(!empty($replaceString))
      $string = preg_replace('/'.$replaceString.'+/', $replaceString, $string);
    //$string = str_replace( array('�','�','�','?','�','|','@','[',']','�','�','�','!','�',',',";","*","�","{",'}','^','�','`','=',":"," ","%",'+','/','\\',"&",'#','!','?','�',"$","�",'"',"'","(",")"), $replaceSign, $string);
    
    return $string;
  }
  
 /**
  * <b>Name</b> shortenString()<br>
  * 
  * Shortens a string to its letter number (conciders htmlentities as multiple characters).
  * 
  * @param string $title  the title string to shorten
  * @param int    $length the number of letters the string should have after 
  * 
  * @return string the shortend title or the unchanged title, if shorten is not necessary
  * 
  * @static
  * @version 1.0
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.0 initial release
  * 
  */
  public static function shortenString($string, $length) {
      
      $string = str_replace('&nbsp;',' ',$string);
      
      // check if shorting is necessary
      if(mb_strlen($string,'UTF-8') <= $length) return $string;
      // shorten the title
      else return mb_substr($string,0,($length - 3),'UTF-8').'...'; // -3 because of the add "..."
  }

 /**
  * <b>Name</b> htmLawed()<br>
  * 
  * Uses the htmLawed function but decodes first UTF-8 and after encodes again.
  * 
  * @param string $string   the data to check against htmlLawed
  * @param array  $config  (optional) if given it will be used as the config array fpr the htmLawed function
  * 
  * @return string the checked html
  * 
  * @static
  * @version 1.1
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.1 moved the admin settings check if htmlLawed is allow to were the method is called (removed it from here)
  *    - 1.0 initial release
  * 
  */
  public static function htmLawed($string, $config = false) {

    // get the html lawed function
    require_once(dirname(__FILE__)."/../thirdparty/PHP/htmLawed.php");
    
    // default
    $htmlLawedConfig = array(
      'comment' => 2,
      'clean_ms_char'=> 0,
      'tidy' => -1, // will be made tidy in the FeinduraBase::generatePage() method
      'no_deprecated_attr' => 0,
      'and_mark' => 1, // change & to \x06
      'unique_ids' => 0,
      'schemes' => 'href:aim, feed, file, ftp, gopher, http, https, irc, mailto, news, nntp, sftp, ssh, telnet;
      action, cite, codebase, data, href, longdesc, model, pluginspage, pluginurl, src, style, usemap:file, http, https;
      classid: file, http, https,clsid;'
    );
    
    // turn safe mode on, if activated
    $htmlLawedConfig['safe'] = (self::$adminConfig['editor']['safeHtml']) ? 1 : 0;
    // add custom config
    if($config) $htmlLawedConfig = array_merge($htmlLawedConfig,$config);

    $string = htmLawed($string,$htmlLawedConfig);
    return str_replace("\x06", '&', $string); 
  }


 /**
  * <b>Name</b> getRealPath()<br>
  * 
  * Try to get the real path from a given absolute or relative path.
  * If the path contains a filename it will ony return the folders in the path (strapping the filename).
  * 
  * 
  * <b>Used Constants</b><br>
  *    - <var>DOCUMENTROOT</var> the absolut path of the webserver
  * 
  * @param string $path an absolute or relative path
  * 
  * @return string|false the real path, including the DOCUMENTROOT or, FALSE
  * 
  * @static
  * @version 0.2
  * <br>
  * <b>ChangeLog</b><br>
  *    - 0.2 add is_file check, to strap the filename
  *    - 0.1 initial release
  * 
  */
  public static function getRealPath($path) {
    $path = preg_replace("#[\\\]+#",'/',$path);
    $path = (substr($path,0,1) == '/' && strpos($path,DOCUMENTROOT) === false) ? DOCUMENTROOT.$path : $path;
    $path = (is_file($path)) ? dirname($path) : $path;
    $realpath = preg_replace("#[\\\]+#", '/',@realPath($path));
    if(empty($realpath))
      return false;
    else
      return preg_replace("#[\\\]+#", '/',$realpath);
  }

 /**
  * <b>Name</b> readFolder()<br>
  * 
  * Reads a folder and return it's subfolders and files.
  * 
  * Example of the returned array:
  * <code>
  * array(
  *    "files" => array(
  *                   0 => '/path/file1.php',
  *                   1 => '/path/file2.php',
  *                   ),
  *    "folders" => array(
  *                   0 => '/path/subfolder1',
  *                   1 => '/path/subfolder2',
  *                   2 => '/path/subfolder3'
  *                   )
  *    )
  * </code>
  * 
  * <b>Used Constants</b><br>
  *    - <var>DOCUMENTROOT</var> the absolut path of the webserver
  * 
  * @param string $folder an absolute or relative path of an folder to read
  * 
  * @return array|false an array with the folder elements (without DOCUMENTROOT), FALSE if the folder not is a directory
  * 
  * @static
  * @version 1.01
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.01 changed to scandir()
  *    - 1.0 initial release
  * 
  */
  public static function readFolder($folder) {

    //vars
    $folder = self::getRealPath($folder);
    if(empty($folder)) return false;
    
    // vars
    $return = false;  
    
    // open the folder and read the content
    if(is_dir($folder)) {
      $readFolder = scandir($folder);
      foreach($readFolder as $inDirObject) {
        if($inDirObject != "." && $inDirObject != "..") {
          if(is_dir($folder.'/'.$inDirObject)) {            
            $return['folders'][] = str_replace(DOCUMENTROOT,'',$folder.'/'.$inDirObject);
          } elseif(is_file($folder.'/'.$inDirObject)) {
            $return['files'][] = str_replace(DOCUMENTROOT,'',$folder.'/'.$inDirObject);
          }
        }
      }
    }
    
    return $return;  
  }

 /**
  * <b>Name</b> readFolderRecursive()<br>
  * 
  * Reads a folder recursive and return it's subfolders and files, opens then also the subfolders and read them, etc.
  * 
  * Example of the returned array:
  * <code>
  * array(
  *    "files" => array(
  *                   0 => '/path/file1.php',
  *                   1 => '/path/subfolder1/file2.php',
  *                   ),
  *    "folders" => array(
  *                   0 => '/path/subfolder1',
  *                   1 => '/path/subfolder2/subsubfolder1',
  *                   2 => '/path/subfolder2/subsubfolder2'
  *                   )
  *    )
  * </code>
  * 
  * <b>Used Constants</b><br>
  *    - <var>DOCUMENTROOT</var> the absolut path of the webserver
  * 
  * @param string $folder an absolute or relative path of an folder to read
  * 
  * @return array|false an array with the folder elements (without DOCUMENTROOT), FALSE if the folder is not a directory
  * 
  * @static
  * @version 1.0
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.0 initial release
  * 
  */
  public static function readFolderRecursive($folder) {

    //vars  
    $folder = self::getRealPath($folder);
    $goTroughFolders['folders'][0] = $folder;
    $goTroughFolders['files'] = array();
    $subFolders = array();
    $files = array();
    $return['folders'] = false;
    $return['files'] = false;

    if(empty($folder) || !is_dir($folder))
      return $return;
      
    // ->> goes trough all SUB-FOLDERS  
    while(!empty($goTroughFolders['folders'][0])) {
  
      // ->> GOES TROUGH folders
      foreach($goTroughFolders['folders'] as $subFolder) {
        //echo '<br><br>'.$subFolder.'<br>';     
        $inDirObjects = self::readFolder($subFolder);
        
        // -> add all subfolders to an array
        if(isset($inDirObjects['folders']) && is_array($inDirObjects['folders'])) {        
          $subFolders = array_merge($subFolders, $inDirObjects['folders']);
        }        
      
        // -> add folders to the $return array
        if(isset($inDirObjects['folders']) && is_array($inDirObjects['folders'])) {
          foreach($inDirObjects['folders'] as $folder) {
            $return['folders'][] = $folder;
          }
        }
        // -> add files to the $return array
        if(isset($inDirObjects['files']) && is_array($inDirObjects['files'])) {
          foreach($inDirObjects['files'] as $file) {
            $return['files'][] = $file;
          }
        }
      }
      
      $goTroughFolders['folders'] = $subFolders;
      $goTroughFolders['files'] = $files;
  
      $subFolders = array();
      $files = array();
    }
  
    return $return;
  } 

 /**
  * <b>Name</b> folderIsEmpty()<br>
  * 
  * Check if a folder is empty.
  * 
  * <b>Used Constants</b><br>
  *    - <var>DOCUMENTROOT</var> the absolut path of the webserver
  * 
  * @param string $folder the absolute path of an folder to check
  * 
  * @return bool TRUE if its empty, otherwise FALSE
  * 
  * @static
  * @version 1.0
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.0 initial release
  * 
  */
  public static function folderIsEmpty($folder) {
    
    if(self::readFolder($folder) === false)
      return true;
    else
      return false;
  
  }

  /**
   * <b>Name</b> deleteFolder()<br>
   * 
   * Deletes a directory and all files in it.
   * 
   * @param string $dir the absolute path to the directory which will be deleted 
   * 
   * @return bool TRUE if the directory was succesfull deleted, otherwise FALSE
   * 
   * @version 1.0
   * <br>
   * <b>ChangeLog</b><br>
   *    - 1.0 initial release
   * 
   */
  public static function deleteFolder($dir) {

      // retrun false if no directory
      if(!is_dir($dir))
        return false;

      $filesFolders = self::readFolderRecursive($dir);
      
      if(is_array($filesFolders)) {
        $return = false;
        $writeerror = false;
        
        if(is_array($filesFolders['files'])) {
          foreach($filesFolders['files'] as $file) {
            if(!is_writable(DOCUMENTROOT.$file))
              $writeerror = true;
            @unlink(DOCUMENTROOT.$file);
          }
        }
        if(is_array($filesFolders['folders'])) {
          foreach($filesFolders['folders'] as $folder) {
            if(!is_writable(DOCUMENTROOT.$folder))
              $writeerror = true;
            @rmdir(DOCUMENTROOT.$folder);
          }
        }
        
        // recheck if everything is deleted
        $checkFilesFolders = self::readFolderRecursive($dir);
        
        if(rmdir($dir))
          return true;
        elseif($writeerror === false && (!empty($checkFilesFolders['folders']) || !empty($checkFilesFolders['files'])))
          GeneralFunctions::deleteFolder($dir);
        else
          return false;
      
      } elseif(@rmdir($dir))
        return true;
      else
        return false;
  }
  
  /**
   * <b>Name</b> createStyleTags()<br>
   * 
   * Goes through a folder recursive and creates a HTML <link> tag for every stylesheet-file found.
   * 
   * <b>Used Global Variables</b><br>
   *    - <var>$adminConfig</var> the administrator-settings config (included in the {@link general.include.php})
   * 
   * @param string $folder  the absolute path of the folder to look for stylesheet files
   * @param bool   $backend if TRUE is substract the {@link GeneralFunctions::$adminConfig $adminConfig['basePath']} from the stylesheet link
   * @param bool   $returnHrefOnly if TRUE it will return an array with the paths of the style files
   * 
   * @uses GeneralFunctions::readFolderRecursive() to read the folder
   * 
   * @return string|array|false the HTML <link> tags, FALSE if no stylesheet-file was found, or an array with style file paths
   * 
   * @static 
   * @version 1.0
   * <br>
   * <b>ChangeLog</b><br>
   *    - 1.0 initial release
   * 
   */
  public static function createStyleTags($folder, $backend = true, $returnHrefOnly = false) {
    
    //var
    $return = ($returnHrefOnly) ? array() : false;

    // ->> goes trough all folder and subfolders
    $filesInFolder = self::readFolderRecursive($folder);
    if(is_array($filesInFolder['files'])) {
      foreach($filesInFolder['files'] as $file) {
        // -> check for CSS FILES
        if(substr($file,-4) == '.css') {
          // -> removes the $adminConfig('realBasePath')
          if($backend) $file = str_replace(self::$adminConfig['realBasePath'],'',$file);

          // -> return only link
          if($returnHrefOnly) {
            $return[] = $file;
          // -> WRITES the HTML-Style-Tags
          } else
            $return .= '  <link rel="stylesheet" type="text/css" href="'.$file.'">'."\n";
        }
      }
    }
    
    return $return;
  }
  
  /**
   * <b>Name</b> smartStripslashes()<br>
   * 
   * Uses stripslashes depending on "magic_quotes_gpc" and "magic_quotes_sybase"
   * 
   * 
   * @return string the stripslashed string
   * 
   * @version 1.0
   * <br>
   * <b>ChangeLog</b><br>
   *    - 1.0 initial release
   * 
   */
  public static function smartStripslashes($str) {
    // magic_quotes_gpc = On
    if(TRUE == function_exists('get_magic_quotes_gpc') && 1 == get_magic_quotes_gpc()) {
      $mqs = strtolower(ini_get('magic_quotes_sybase'));
      
      // magic_quotes_sybase = Off
      if(TRUE == empty($mqs) || 'off' == $mqs)
        $str = stripslashes($str);
      else
        $str = str_replace("''", "'", $str);
    }
    return $str;
  }

  /**
   * <b>Name</b> jsonDecode()<br>
   * 
   * Decodes a JSON object in php, without using json_decode() so its PHP 5.1 compatible.
   * 
   * @param string $json a json encoded string
   * 
   * @return array the decoded JSON data
   * 
   * @link http://de2.php.net/manual/de/function.json-decode.php#105259 Created by Dragos.U
   * 
   * @version 1.0
   * <br>
   * <b>ChangeLog</b><br>
   *    - 1.0 initial release
   * 
   */
  public static function jsonDecode($json) { 
      $json = str_replace(array("\\\\", "\\\""), array("&#92;", "&#34;"), $json); 
      $parts = preg_split("@(\"[^\"]*\")|([\[\]\{\},:])|\s@is", $json, -1, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE); 
      foreach ($parts as $index => $part) 
      { 
          if (strlen($part) == 1) 
          { 
              switch ($part) 
              { 
                  case "[": 
                  case "{": 
                      $parts[$index] = "array("; 
                      break; 
                  case "]": 
                  case "}": 
                      $parts[$index] = ")"; 
                      break; 
                  case ":": 
                    $parts[$index] = "=>"; 
                    break;    
                  case ",": 
                    break; 
                  default: 
                      return null; 
              } 
          } 
          else 
          { 
              if ((substr($part, 0, 1) != "\"") || (substr($part, -1, 1) != "\"")) 
              { 
                  return null; 
              } 
          } 
      } 
      $json = str_replace(array("&#92;", "&#34;", "$"), array("\\\\", "\\\"", "\\$"), implode("", $parts)); 
      return eval("return $json;"); 
  } 
  
 /**
  * <b>Name</b> scriptBenchmark()<br>
  * 
  * Shows th time the scipt need between this call and the last call of this function.
  * And shows the memory usage at the point of the script where this public static function is called.
  * 
  * @return string the time needed
  * 
  * @static
  * @version 1.0
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.0 initial release
  * 
  */
  function scriptBenchmark() {
    $return = '<br>*** BENCHMARK ***<br>Time: ';

    // ->> time
    $timer = explode( ' ', microtime() );
    $timer = $timer[1] + $timer[0];

    if(self::$scriptBenchmarkTime) {
      ++self::$scriptBenchmarkPoint;
      $return .= round($timer - self::$scriptBenchmarkTime,4).' seconds on point: '.self::$scriptBenchmarkPoint.'<br>';
      // self::$debug_showTime = $timer;

    // first run
    } else {
      self::$scriptBenchmarkPoint = 0;
      self::$scriptBenchmarkTime = $timer;
      $return .= round($timer,4).' start time<br>';
    }

    // ->> memory
    $mem_usage = memory_get_usage(true);
      
    $return .= 'Memory: ';//.$mem_usage.' -> ';
    
    if ($mem_usage < 1024)
        $return .= $mem_usage." bytes";
    elseif ($mem_usage < 1048576)
        $return .= round($mem_usage/1024,2)." kilobytes";
    else
        $return .= round($mem_usage/1048576,2)." megabytes";
       
    $return .= '<br>';
    return $return;
  }
}
?>