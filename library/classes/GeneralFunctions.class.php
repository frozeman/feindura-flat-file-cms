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
* @version 1.3.1
* <br>
*  <b>ChangeLog</b><br>
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
  * Contains all page and category IDs on the first loading of a page.
  * 
  * Run on the first loading of a page.
  * Goes trough all category folders and look which pages are in which folders and saves the IDs in the this property,<br>
  * to speed up the page loading process.
  * 
  * Example of the returned array:
  * {@example loadPageIds.return.example.php}
  * 
  * @static
  * @var array
  * 
  */
  public static $storedPageIds = null;
  
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
  * @version 1.0
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.0 initial release
  * 
  */ 
  public static function init() {
    
    // GET CONFIG FILES and SET CONFIG PROPERTIES
    self::$adminConfig = $GLOBALS["adminConfig"];
    self::$categoryConfig = $GLOBALS["categoryConfig"];
    self::$websiteConfig = $GLOBALS["websiteConfig"];

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
  * @version 1.0
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.0 initial release
  * 
  */
  public static function setVisitorTimzone() {

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
          $zonelist = array('Kwajalein' => -12.00, 'Pacific/Midway' => -11.00, 'Pacific/Honolulu' => -10.00, 'America/Anchorage' => -9.00, 'America/Los_Angeles' => -8.00, 'America/Denver' => -7.00, 'America/Tegucigalpa' => -6.00, 'America/New_York' => -5.00, 'America/Caracas' => -4.30, 'America/Halifax' => -4.00, 'America/St_Johns' => -3.30, 'America/Argentina/Buenos_Aires' => -3.00, 'America/Sao_Paulo' => -3.00, 'Atlantic/South_Georgia' => -2.00, 'Atlantic/Azores' => -1.00, 'Europe/Dublin' => 0, 'Europe/Belgrade' => 1.00, 'Europe/Minsk' => 2.00, 'Asia/Kuwait' => 3.00, 'Asia/Tehran' => 3.30, 'Asia/Muscat' => 4.00, 'Asia/Yekaterinburg' => 5.00, 'Asia/Kolkata' => 5.30, 'Asia/Katmandu' => 5.45, 'Asia/Dhaka' => 6.00, 'Asia/Rangoon' => 6.30, 'Asia/Krasnoyarsk' => 7.00, 'Asia/Brunei' => 8.00, 'Asia/Seoul' => 9.00, 'Australia/Darwin' => 9.30, 'Australia/Canberra' => 10.00, 'Asia/Magadan' => 11.00, 'Pacific/Fiji' => 12.00, 'Pacific/Tongatapu' => 13.00);
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
  * @version 1.0
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.0 initial release
  * 
  */
  public static function getDirname($dir) {
    if(!empty($dir) && strpos($dir,'.') !== false && (strlen($dir) - strpos($dir,'.')) <= 5 && substr($dir,-1) != '/')
      return preg_replace('#/+#','/',str_replace('\\','/',dirname($dir)).'/');
    else
      return $dir;
  }

 /**
  * <b>Name</b> getStoredPageIds()<br>
  * 
  * Fetches the {@link $storedPageIds} property.
  * 
  * If the {@link $storedPageIds} property is empty, it loads all page IDs into this property.
  * 
  * Example of the returned {@link $storedPageIds} property:
  * {@example loadPageIds.return.example.php}
  * 
  * @uses $storedPageIds the property to get
  * 
  * @return array the {@link $storedPageIds} property
  * 
  * @static
  * @version 1.0
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.0 initial release
  * 
  */
  public static function getStoredPageIds() { // (false or Array)
    
    // load all page ids, if necessary
    if(self::$storedPageIds === null)
      self::$storedPageIds = self::loadPageIds(true);

    return self::$storedPageIds;
  }

 /**
  * <b>Name</b> getStoredPages()<br>
  * 
  * Fetches the {@link $storedPages} property.
  * 
  * Its also possible to fetch the {@link $storedPages} property from the <var>$_SESSION</var> variable. (CURRENTLY DEACTIVATED)
  * 
  * @uses $storedPages the property to get
  * 
  * @return array the {@link $storedPages} property
  * 
  * @example loadPages.return.example.php of the returned array
  * 
  * @static
  * @version 1.0
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.0 initial release
  * 
  */
  public static function getStoredPages() {
    
    unset($_SESSION['feinduraSession']['storedPages']);    
    //echo 'STORED-PAGES -> '.count(self::$storedPages); 
      
    // -> checks if the SESSION storedPages Array exists
    if(isset($_SESSION['feinduraSession']['storedPages']))
      return $_SESSION['feinduraSession']['storedPages']; // if isset, get the storedPages from the SESSION
    else
      return self::$storedPages; // if not get the storedPages from the PROPERTY  
  }

 /**
  * <b>Name</b> addStoredPage()<br>
  * 
  * Adds a <var>$pageContent</var> array to the {@link $storedPages} property.
  * Its also possible to store the {@link $storedPages} property in a <var>$_SESSION</var> variable. (CURRENTLY DEACTIVATED)
  * 
  * @param int  $pageContent   a $pageContent array which should be add to the {@link $storedPages} property
  * 
  * @uses $storedPages the property to add the $pageContent array
  * 
  * @return array passes through the given $pageContent array
  * 
  * @static
  * @version 1.01
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.01 removed the $remove parameter  
  *    - 1.0 initial release
  * 
  */
  public static function addStoredPage($pageContent) {
   
    unset($_SESSION['feinduraSession']['storedPages']);
    
    // stores the given parameter only if its a valid $pageContent array
    if(self::isPageContentArray($pageContent)) {
      // -> checks if the SESSION storedPages Array exists
      if(isset($_SESSION['feinduraSession']['storedPages']))
        $_SESSION['feinduraSession']['storedPages'][$pageContent['id']] = $pageContent; // if isset, save the storedPages in the SESSION
      else {
        self::$storedPages[$pageContent['id']] = $pageContent; // if not save the storedPages in the PROPERTY
        //$_SESSION['feinduraSession']['storedPages'][$pageContent['id']] = $pageContent;
      }
    }
    return $pageContent;
  }
  
 /**
  * <b>Name</b> removeStoredPage()<br>
  * 
  * Removes a <var>$pageContent</var> array from the {@link $storedPages} property.
  * Its also possible to remove the {@link $storedPages} property from the <var>$_SESSION</var> variable. (CURRENTLY DEACTIVATED)
  * 
  * @param int $id the ID of a page which should be removed from the {@link $storedPages} property
  * 
  * @uses $storedPages the property to remove the $pageContent array
  * 
  * @return bool TRUE if a page with this ID exists and could be removed, otherwise FALSE
  * 
  * @static
  * @version 1.0
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.0 initial release
  * 
  */
  public static function removeStoredPage($id) {
    
    // var
    $return = false; 
    
    // ->> REMOVE
    if(is_numeric($id)) {
    // -> checks if the SESSION storedPages Array exists
      if(isset($_SESSION['feinduraSession']['storedPages']) && isset($_SESSION['feinduraSession']['storedPages'][$id])) {
        unset($_SESSION['feinduraSession']['storedPages'][$id]); // if isset, remove from the storedPages in the SESSION
        return true;
      } elseif(isset(self::$storedPages[$id])) {
        unset(self::$storedPages[$id]); // if not remove from the storedPages in the PROPERTY
        unset($_SESSION['feinduraSession']['storedPages'][$id]);
        return true;
      }
    }
    
    return $return;
  }
  
 /**
  * <b>Name</b> getPageCategory()<br>
  * 
  * Return the category ID of a page.
  * 
  * @param int $page a page ID from which to get the category ID
  * 
  * @uses getStoredPageIds() to get the {@link storedPageIds} property
  * 
  * @return int|false the right category ID or FALSE if the page ID doesn't exists
  * 
  * @static
  * @version 1.0
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.0 initial release
  * 
  */
  public static function getPageCategory($page) {

    if($page !== false && is_numeric($page)) {
      // loads only the page IDs and category IDs in an array
      // but only if it hasn't done this yet      
      $allPageIds = self::getStoredPageIds();
      
      if($allPageIds) {
        // gets the category id of the given page
        foreach($allPageIds as $everyPage) {
          // if its the right page, return the category of it        
          if($page == $everyPage['page']) {
             return $everyPage['category'];
          }
        }
        // if it found nothing
        return false;
        
      } else
        return false;
    } else
      return false;
  }
  
  /**
   * <b>Name</b> getLocalized()<br>
   * 
   * Gets the localized version of given <var>$value</var> parameter, which matches the <var>$_SESSION['feinduraSession']['websiteLanguage']</var> variable.
   * If no matching localized version of this value exists, it returns the one matching the <var>$adminConfig['multiLanguageWebsite']['mainLanguage']</var> variable.
   * 
   * <b>Used Global Variables</b><br>
   *   - <var>$_GET['status']</var> if the value is "addLanguage", it forces to load the <var>$languageCode</var> parameter
   *  
   * @param array        $localizedArray   a localized array in the form of: array('de' => .. , 'en' => .. )
   * @param string       $value               the anme of the value, which should be returned localized
   * @param bool|string  $forceOrUseLanguage  if TRUE the language will be forced to be loaded, even if it does not exist, if string it will use this as the testing language code, instead of the <var>$_SESSION['feinduraSession']['websiteLanguage']</var> var
   *   
   * @return string the localized value of the given <var>$localizedArray</var> parameter
   * 
   * 
   * @static
   * @version 1.1
   * <br>
   * <b>ChangeLog</b><br>
   *    - 1.1 changed $forceLanguage to $forceOrUseLanguage
   *    - 1.0 initial release
   * 
   */
  public static function getLocalized($localizedArray, $value, $forceOrUseLanguage = false) {

    // var
    $languageCode = (!is_bool($forceOrUseLanguage) && is_string($forceOrUseLanguage) && strlen($forceOrUseLanguage) == 2)
      ? $forceOrUseLanguage
      : $_SESSION['feinduraSession']['websiteLanguage'];

    // get the one matching $languageCode
    if((isset($localizedArray[$languageCode]) && !empty($localizedArray[$languageCode][$value])) ||
       (is_bool($forceOrUseLanguage) && $forceOrUseLanguage === true))
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
      //echo '<br>->USED STORED '.$page.'<br>';        
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
  *    - <var>PHPSTARTTAG</var> the php start tag
  *    - <var>PHPENDTAG</var> the php end tag
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
    $fileContent .= PHPSTARTTAG;
    
    $fileContent .= "\$pageContent['id']                 = ".XssFilter::int($pageContent['id'],0).";\n";
    $fileContent .= "\$pageContent['category']           = ".XssFilter::int($pageContent['category'],0).";\n";
    $fileContent .= "\$pageContent['subCategory']        = ".XssFilter::int($pageContent['subCategory'],'false').";\n";
    $fileContent .= "\$pageContent['sortOrder']          = ".XssFilter::int($pageContent['sortOrder'],0).";\n";
    $fileContent .= "\$pageContent['public']             = ".XssFilter::bool($pageContent['public'],true).";\n\n";
    
    $fileContent .= "\$pageContent['lastSaveDate']       = ".XssFilter::int($pageContent['lastSaveDate'],0).";\n";
    $fileContent .= "\$pageContent['lastSaveAuthor']     = '".XssFilter::text($pageContent['lastSaveAuthor'])."';\n\n"; 
    
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
        $fileContent .= "\$pageContent['localized'][".$langCode."]['content']            = '".trim(self::htmLawed($pageContentLocalized['content']))."';\n\n";
      }
    }
    
    $fileContent .= "return \$pageContent;";
    $fileContent .= PHPENDTAG;
    
    if(file_put_contents($filePath, $fileContent, LOCK_EX)) {
      
      @chmod($filePath,self::$adminConfig['permissions']);

      // writes the new saved page to the $storedPages property      
      self::removeStoredPage($pageContent['id']); // remove the old one
      unset($pageContent);
      $pageContent = include($filePath);
      self::addStoredPage($pageContent);
      // reset the stored page ids
      self::$storedPageIds = null;
      
      return true;
    } else
      return false;
  }

 /**
  * <b>Name</b> readPageStatistics()<br>
  * 
  * Loads the $pageContent array of a page.
  * 
  * Includes the page statistics.
  * 
  * Example of the returned $pageStatistics array:
  * {@example readPageStatistics.return.example.php}
  * 
  * @param int $pageId a page ID or a $pageStatistics array (will then returned immediately)
  * 
  * 
  * @return array|FALSE|NULL the $pageStatistics array of the requested page or FALSE, if it couldn't open the file, or NULL when the file exists but couldnt be loaded properly
  * 
  * @static
  * @version 1.0
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.0 initial release
  * 
  */
  public static function readPageStatistics($pageId) {
    //echo 'PAGE: '.$pageId.'<br>';
    // var
    $pageStatistics = false;
    
    // if $page is a valid $pageStatistics array return it immediately
    if(self::isPageStatisticsArray($pageId))
      return $pageId;
    elseif(!is_numeric($pageId))
      return false;
    
    // adds .php to the end if its missing
    if(substr($pageId,-4) != '.statistics.php')
      $pageId .= '.statistics.php';
    // ->> INCLUDE
    if($fp = @fopen(dirname(__FILE__).'/../../statistic/pages/'.$pageId,'r')) {
      flock($fp,LOCK_SH);
      $pageStatistics = @include(dirname(__FILE__).'/../../statistic/pages/'.$pageId);
      flock($fp,LOCK_UN);
      fclose($fp);
    }
    
    // return content array
    if(is_array($pageStatistics)) {
      return $pageStatistics;
      
    // return failure while loading the content (file exists but couldn't be loaded)
    } elseif($pageStatistics === 1) {
      return null;
      
    // returns false if it couldn't include the file (file doesnt exists)
    } else
      return false;
  }

 /**
  * <b>Name</b> savePageStatistics()<br>
  * 
  * Save a page statistics to it's flatfile.
  * 
  * Example of the saved $pageContent array:
  * {@example readPageStatistics.return.example.php}
  * 
  * <b>Used Constants</b><br>
  *    - <var>PHPSTARTTAG</var> the php start tag
  *    - <var>PHPENDTAG</var> the php end tag
  * 
  * @param array $pageStatistics    the $pageStatistics array of the page to save
  * 
  * @uses $adminConfig      for the save path of the flatfiles
  * 
  * @return bool TRUE if the page was succesfull saved, otherwise FALSE
  * 
  * @static
  * @version 1.0
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.0 initial release
  * 
  */
  public static function savePageStatistics($pageStatistics) {

    // check if array is pageContent array
    if(!self::isPageStatisticsArray($pageStatistics))
      return false;

    // check if statistics folder exists
    if(!is_dir(dirname(__FILE__).'/../../statistic/pages/'))
      @mkdir(dirname(__FILE__).'/../../statistic/pages/',self::$adminConfig['permissions'],true);

    // escape \ and '
    //$pageStatistics = XssFilter::escapeBasics($pageStatistics);
   
    // CREATE file content
    $fileContent = '';
    $fileContent .= PHPSTARTTAG;
    
    $fileContent .= "\$pageStatistics['id'] =             ".XssFilter::int($pageStatistics['id'],0).";\n";
    $fileContent .= "\$pageStatistics['visitorCount'] =   ".XssFilter::int($pageStatistics['visitorCount'],0).";\n";
    $fileContent .= "\$pageStatistics['firstVisit'] =     ".XssFilter::int($pageStatistics['firstVisit'],0).";\n";
    $fileContent .= "\$pageStatistics['lastVisit'] =      ".XssFilter::int($pageStatistics['lastVisit'],0).";\n";
    $fileContent .= "\$pageStatistics['visitTimeMin'] =   '".$pageStatistics['visitTimeMin']."';\n"; // XssFilter in saveWebsiteStats() method in the StatisticFunctions.class.php
    $fileContent .= "\$pageStatistics['visitTimeMax'] =   '".$pageStatistics['visitTimeMax']."';\n"; // XssFilter in saveWebsiteStats() method in the StatisticFunctions.class.php
    $fileContent .= "\$pageStatistics['searchWords'] =    '".$pageStatistics['searchWords']."';\n\n"; // XssFilter in the addDataToDataString() method in the StatisticFunctions.class.php
    
    $fileContent .= "return \$pageStatistics;";
    
    $fileContent .= PHPENDTAG;
    
    // -> write file
    if(file_put_contents(dirname(__FILE__).'/../../statistic/pages/'.$pageStatistics['id'].'.statistics.php', $fileContent, LOCK_EX)) {
      @chmod(dirname(__FILE__).'/../../statistic/pages/'.$pageStatistics['id'].'.statistics.php',self::$adminConfig['permissions']);
      return true;
    } else
      return false; 
  }
  
 /**
  * <b>Name</b> loadPageIds()<br>
  * 
  * Goes through the flat file folders and looks in which category is which page, it then returns an array with all IDs.
  * 
  * Example of the returned array:
  * {@example loadPageIds.return.example.php}
  * 
  *
  * <b>Used Constants</b><br>
  *    - <var>DOCUMENTROOT</var> the absolut path of the webserver
  * 
  * @param int|bool $category   (optional) the category ID to check the containing page IDs, if FALSE its checks the non-category, if TRUE it checks all categories including the non-category (can also be the {@link $categoryConfig} property)
  * 
  * @uses $adminConfig          for the save path of the flatfiles
  * 
  * @return array|false an array with page IDs and the affiliated category IDs or empty array if the category had no pages
  * 
  * @static
  * @version 1.1
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.1 add scandir() to scan category dirs
  *    - 1.0 initial release
  * 
  */
  public static function loadPageIds($category = false) {
                    
    // vars
    $pagesArray = array();
    $categoryDirs = array();

    // if $category === true,
    // load ALL CATEGORIES and the NON-CATEGORY
    if($category === true) {
      $nonCategory[0] = array('id' => 0);
      $category = (is_array(self::$categoryConfig)) ? $nonCategory + self::$categoryConfig : $nonCategory;
    }
    
    // COLLECT THE DIRS in an array
    // if $category is an array, it stores all dirs from the pages folder in an array
    if(is_array($category)) {
      
        foreach($category as $categoryArray) {
          $dir = '';
          
          // *** if it is self::$categoryConfig settings array
          if(is_array($categoryArray) &&
             array_key_exists('id',$categoryArray)) {
            // if category == 0, means that the files are saved directly in the pages folder
            if($categoryArray['id'] == 0)
              $dir = dirname(__FILE__).'/../../pages/';
            elseif(is_numeric($categoryArray['id']))
              $dir = dirname(__FILE__).'/../../pages/'.$categoryArray['id'];
          
          // *** if its just an array with the ids of the categories
          } else {
            // if category == 0, means that the files are directly saved in the pages folder
            if(is_numeric($categoryArray) && $categoryArray == 0) //$categoryArray === false ||
              $dir = dirname(__FILE__).'/../../pages/';
            elseif(is_numeric($categoryArray))
              $dir = dirname(__FILE__).'/../../pages/'.$categoryArray;
          }
          
          // stores the paths in an array
          $categoryDirs[] = $dir;
        }
    } else {
      if($category === false || (is_numeric($category) && $category == 0))
        $categoryDirs[0] = dirname(__FILE__).'/../../pages/';
      elseif(is_numeric($category))
        $categoryDirs[0] = dirname(__FILE__).'/../../pages/'.$category;
    }
    
    // LOAD THE FILES out of the dirs
    // goes trough all category dirs and put the page arrays into an array an retun it
    foreach($categoryDirs as $dir) {  
      // opens every category dir and stores the arrays of the pages in an array
      if(is_dir($dir)) {
        $pages = array();
        
        // checks if its a category or the non-category
        if($category === false || $category == 0 || !is_numeric(basename($dir)))
          $categoryId = false;
        else
          $categoryId = basename($dir);
        
        $readFolder = scandir($dir);      
        foreach($readFolder as $inDirObject) {
          if(preg_match('#^[0-9]+\.php$#',$inDirObject) && is_file($dir."/".$inDirObject)) {
            $pages[] = ($categoryId === false)
                ? array('page' => intval(substr($inDirObject,0,-4)), 'category' => 0) // load Pages, without a category                  
                : array('page' => intval(substr($inDirObject,0,-4)), 'category' => intval($categoryId)); // load Pages, with a category
          }
        }
        // adds the new sorted category to the return array
        $pagesArray = array_merge($pagesArray,$pages);
      }
    }

    // return the page and category ID(s)
    return $pagesArray;
  }
  
 /**
  * <b>Name</b> loadPages()<br>
  * 
  * Loads the $pageContent arrays from pages in a specific category(ies) or all categories.
  * 
  * Loads all $pageContent arrays of a given category, by going through the {@link $storedPageIds} property.
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
  * @param bool		         $loadPagesInArray   (optional) if TRUE it returns the $pageContent arrays of the pages in the categories, if FALSE it only returns the page IDs of the requested category(ies)
  * 
  * @uses $categoryConfig     to get the sorting of the category
  * @uses getStoredPages()		for getting the {@link $storedPages} property
  * @uses readPage()			    to load the $pageContent array of the page
  * 
  * @return array an array with the $pageContent arrays of the requested pages
  * 
  * @static
  * @version 1.0.1
  * <br>
  * <b>ChangeLog</b><br>
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
          
          // go trough the storedPageIds and open the page in it
          $newPageContentArrays = array();
          foreach(self::getStoredPageIds() as $pageIdAndCategory) {
            // use only pages from the right category
            if($pageIdAndCategory['category'] == $categoryId) {
              //echo 'PAGE: '.$pageIdAndCategory['page'].' -> '.$categoryId.'<br>';
              $newPageContentArrays[] = self::readPage($pageIdAndCategory['page'],$pageIdAndCategory['category']);            
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
      
      // -> uses the self::$storedPageIds an filters out only the given category ID(s)
      $pageIds = self::getStoredPageIds();
      
      if($category !== true) {
      	 $newPageIds = false;
      	 foreach($pageIds as $pageId) {
        	  if((is_array($category) && in_array($pageId['category'],$category)) || 
        	     $category == $pageId['category'])
        	    $newPageIds[] = array('page' => $pageId['page'], 'category' => $pageId['category']);
         }
      } else
	      $newPageIds = $pageIds;
      
      return $newPageIds;
    }
  }
  
 /**
  * <b>Name</b> loadPagesStatistics()<br>
  * 
  * Loads the $pageStatistics arrays from pages in a specific category(ies) or all categories.
  * 
  * Loads all $pageStatistics arrays of a given category, by going through the {@link $storedPageIds} property and load the right "[pageID].statistics.php".
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
        
        // go trough the storedPageIds and open the page in it
        $pageStatisticsArrays = array();
        foreach(self::getStoredPageIds() as $pageIdAndCategory) {
          // use only pages from the right category
          if($pageIdAndCategory['category'] == $categoryId) {
            //echo 'PAGE: '.$pageIdAndCategory['page'].' -> '.$categoryId.'<br>';
            if($pageStat = self::readPageStatistics($pageIdAndCategory['page']))
              $pageStatisticsArrays[] = $pageStat;
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
  * @return array|false an array with ID(s) of the public category(ies)
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
    return (is_array($page) && array_key_exists('id',$page) && array_key_exists('category',$page) && array_key_exists('sortOrder',$page)) ? true : false;
  }
  
 /**
  * <b>Name</b> isPageStatisticsArray()<br>
  * 
  * Checks the given <var>$page</var> parameter is a valid <var>$pageStatistics</var> array.
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
  public static function isPageStatisticsArray($page) {
    return (is_array($page) && array_key_exists('id',$page) && array_key_exists('visitorCount',$page)) ? true : false;
  }
  
 /**
  * <b>Name</b> saveFeeds()<br>
  * 
  * Saves an Atom and RSS 2.0 Feed for the given category.
  * 
  * <b>Used Global Variables</b><br>
  *    - <var>$adminConfig</var> the administrator-settings config (included in the {@link general.include.php}) 
  *    - <var>$categoryConfig</var> the categories-settings config (included in the {@link general.include.php})
  *    - <var>$websiteConfig</var> the website-settings config (included in the {@link general.include.php})
  * 
  * @param string $category the category of which feeds should be created
  * 
  * @return bool whether the saving of the feeds succeed or not
  * 
  * 
  * @version 0.2
  * <br>
  * <b>ChangeLog</b><br>
  *    - 0.2 add multilanguage website, creating multiple feeds
  *    - 0.1 initial release
  * 
  */
  public static function saveFeeds($category) {
    
    // vars
    $return = false;
    $languages = (self::$adminConfig['multiLanguageWebsite']['active'])
      ? self::$adminConfig['multiLanguageWebsite']['languages']
      : array(0 => 0);

    foreach ($languages as $langCode) {
      
      $addLanguageToFilename = (!empty($langCode)) ? '.'.$langCode : '';

      // vars
      $atomFileName = ($category == 0) 
        ? dirname(__FILE__).'/../../pages/atom'.$addLanguageToFilename.'.xml'
        : dirname(__FILE__).'/../../pages/'.$category.'/atom'.$addLanguageToFilename.'.xml';
      $rss2FileName = ($category == 0) 
        ? dirname(__FILE__).'/../../pages/rss2'.$addLanguageToFilename.'.xml'
        : dirname(__FILE__).'/../../pages/'.$category.'/rss2'.$addLanguageToFilename.'.xml';
      
      // ->> DELETE the xml files, if category is deactivated, or rss feeds are activated for that category
      if(($category != 0 && (!self::$categoryConfig[$category]['public'] || !self::$categoryConfig[$category]['feeds'])) ||
         ($category == 0 && !self::$adminConfig['pages']['feeds'])) {
        if(is_file($atomFileName)) unlink($atomFileName);
        if(is_file($rss2FileName)) unlink($rss2FileName);
        return false;
      }
      
      // get the FeedWriter class
      require_once(dirname(__FILE__).'/../thirdparty/FeedWriter/FeedWriter.php');
      
      // vars
      $feedsPages = self::loadPages($category,true);
      $channelTitle = ($category == 0)
        ? self::getLocalized(self::$websiteConfig['localized'],'title',$langCode)
        : self::getLocalized(self::$categoryConfig[$category]['localized'],'name',$langCode).' - '.self::getLocalized(self::$websiteConfig['localized'],'title',$langCode);
      
      // ->> START feeds
      $atom = new FeedWriter(ATOM);
      $rss2 = new FeedWriter(RSS2);
    
    	// ->> CHANNEL
    	// -> ATOM
    	$atom->setTitle($channelTitle);	
    	$atom->setLink(self::$adminConfig['url']);	
    	$atom->setChannelElement('updated', date(DATE_ATOM , time()));
    	$atom->setChannelElement('author', array('name'=>self::getLocalized(self::$websiteConfig['localized'],'publisher',$langCode)));
    	$atom->setChannelElement('rights', self::getLocalized(self::$websiteConfig['localized'],'copyright',$langCode));
    	$atom->setChannelElement('generator', 'feindura - flat file cms',array('uri'=>'http://feindura.org','version'=>VERSION));
    	
    	// -> RSS2
    	$rss2->setTitle($channelTitle);
    	$rss2->setLink(self::$adminConfig['url']);	
    	$rss2->setDescription(self::getLocalized(self::$websiteConfig['localized'],'description',$langCode));
      //$rss2->setChannelElement('language', 'en-us');
      $rss2->setChannelElement('pubDate', date(DATE_RSS, time()));
      $rss2->setChannelElement('copyright', self::getLocalized(self::$websiteConfig['localized'],'copyright',$langCode));	
      
      // ->> adds the feed ENTRIES/ITEMS
      foreach($feedsPages as $feedsPage) {
        
        if($feedsPage['public']) {
          // shows the page link
          $link = self::createHref($feedsPage,false,$langCode,true);
          $title = strip_tags(self::getLocalized($feedsPage['localized'],'title',$langCode));
          $description = self::getLocalized($feedsPage['localized'],'description',$langCode);
          
          $thumbnail = (!empty($feedsPage['thumbnail'])) ? '<img src="'.self::$adminConfig['url'].self::$adminConfig['uploadPath'].self::$adminConfig['pageThumbnail']['path'].$feedsPage['thumbnail'].'"><br>': '';
          $content = self::replaceLinks(self::getLocalized($feedsPage['localized'],'content',$langCode),false,$langCode,true);
          $content = strip_tags($content,'<h1><h2><h3><h4><h5><h6><p><ul><ol><li><br><a><b><i><em><s><u><strong><small><span>');
          $content = preg_replace('#<h[0-6]>#','<strong>',$content);
          $content = preg_replace('#</h[0-6]>#','</strong><br>',$content);
          
          // ATOM
        	$atomItem = $atom->createNewItem();  	
        	$atomItem->setTitle($title);
        	$atomItem->setLink($link);
        	$atomItem->setDate($feedsPage['lastSaveDate']);
          $atomItem->addElement('content',$thumbnail.$content,array('src'=>$link));
        
          // RSS2
          $rssItem = $rss2->createNewItem();    
          $rssItem->setTitle($title);
          $rssItem->setLink($link);
          $rssItem->setDate($feedsPage['lastSaveDate']);
          $rssItem->addElement('guid', $link,array('isPermaLink'=>'true'));

          // BOTH
          if(empty($description)) {
            //$atomItem->setDescription($thumbnail.self::shortenString(strip_tags($content),450)); // dont create Atom description when, there is already an content tag
            $rssItem->setDescription($thumbnail.self::shortenString(strip_tags($content),450));
          } else {
            $atomItem->setDescription($thumbnail.$description);
            $rssItem->setDescription($thumbnail.$description);
          }
          
        	//Now add the feeds item	
        	$atom->addItem($atomItem);
        	//Now add the feeds item	
        	$rss2->addItem($rssItem);
      	}
      }
        
      // -> SAVE
      if(file_put_contents($atomFileName,$atom->generateFeed(),LOCK_EX) !== false &&
              file_put_contents($rss2FileName,$rss2->generateFeed(),LOCK_EX) !== false) {
        @chmod($atomFileName, self::$adminConfig['permissions']);
        @chmod($rss2FileName, self::$adminConfig['permissions']);
        $return = true; 
      } else
        $return = false;

    }
    return $return;
  }
  
 /**
  * <b>Name</b> saveSitemap()<br>
  * 
  * Saves a sitemap xml file (see http://www.sitemaps.org).
  * 
  * <b>Used Global Variables</b><br>
  *    - <var>$adminConfig</var> the administrator-settings config (included in the {@link general.include.php}) 
  *    - <var>$categoryConfig</var> the categories-settings config (included in the {@link general.include.php})
  *    - <var>$websiteConfig</var> the website-settings config (included in the {@link general.include.php})
  * 
  * 
  * @return bool whether the saving of the sitemap was done or not
  * 
  * @link http://www.sitemaps.org
  * @version 0.2
  * <br>
  * <b>ChangeLog</b><br>
  *    - 0.2 return false if the real website path, couldn't be resolved
  *    - 0.1 initial release
  * 
  */
  public static function saveSitemap() {
    
    // vars
    $websitePath = self::getDirname(self::$adminConfig['websitePath']);
    $realWebsitePath = self::getRealPath($websitePath).'/';
    if($realWebsitePath == '/')
      return false;
    $baseUrl = self::$adminConfig['url'].$websitePath;
    
    // get the Sitemap class
    require_once(dirname(__FILE__).'/../thirdparty/PHP/Sitemap.php');
    
    // vars
    $sitemapPages = self::loadPages(true,true);
    
    // ->> START sitemap
    $sitemap = new Sitemap($baseUrl,$realWebsitePath,true); // gzip encoded
    $sitemap->showError =  false;
    $sitemap->filePermissions =  self::$adminConfig['permissions'];
    $sitemap->page('pages');
    
    // ->> adds the sitemap ENTRIES
    foreach($sitemapPages as $sitemapPage) {
      
      // ->> if category is deactivated jump to the next item in the foreach loop
      if($sitemapPage['category'] != 0 && !self::$categoryConfig[$sitemapPage['category']]['public'])
        continue;
      
      if($sitemapPage['public']) {
        // generate page link
        $link = self::createHref($sitemapPage,false,self::$adminConfig['multiLanguageWebsite']['mainLanguage'],true);
        // add page to sitemap
        $sitemap->url($link, date('Y-m-d',$sitemapPage['lastSaveDate']), 'weekly'); 
    	}
    }
    
    $sitemap->close(); 
    unset ($sitemap);
    return true;
  }
  
 /**
  * <b>Name</b> urlEncode()<br>
  * 
  * Encodes a string to url, but before it removes all tags and htmlentitites.
  * 
  * @param string|false $string    the string to urlencode
  * 
  * 
  * @return string the url encoded string
  * 
  * @see Feindura::createHref()
  * 
  * @static
  * @version 2.0
  * <br>
  * <b>ChangeLog</b><br>
  *   - 2.0 add transliteration from {@link http://php.vrana.cz/vytvoreni-pratelskeho-url.php}
  *   - 1.0 initial release
  * 
  */
  public static function urlEncode($string) {
    $string = html_entity_decode($string,ENT_COMPAT,'UTF-8');
    $string = strip_tags($string);

    $string = preg_replace('#[^\\pL0-9_]+#u', '-', $string);
    $string = trim($string, "-");
    $string = iconv("UTF-8", "ASCII//TRANSLIT", $string);
    $string = strtolower($string);
    $string = preg_replace('#[^a-z0-9_-]+#', '', $string);
    return urlencode($string);
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
  * @return string the $pageContentString woth replaced feindura links
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
  * @version 1.0.1
  * <br>
  * <b>ChangeLog</b><br>
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

      // adds the CATEGORY to the href attribute
      if($category != 0)
        $href .= 'category/';
      else
        $href .= 'page/';

      // adds the CATEGORY NAME to the href attribute
      if($category != 0)
        $href .= self::urlEncode(self::getLocalized(self::$categoryConfig[$category]['localized'],'name',$language)).'/';

      // add PAGE NAME
      $href .= self::urlEncode(self::getLocalized($pageContent['localized'],'title',$language));
      //$href .= '/'; //'.html';
      
      if($sessionId)
        $href .= '?'.$sessionId;
      
      return $href;
    
    // ->> create HREF with varNames und Ids
    // *************************************
    } else {
      
      $href .= self::$adminConfig['websitePath'];
      
      // adds the category to the href attribute
      if($category != 0)
        $categoryLink = self::$adminConfig['varName']['category'].'='.$category.'&amp;';
      else $categoryLink = '';
      
      $href .= '?'.$categoryLink.self::$adminConfig['varName']['page'].'='.$page;

      // add the LANGUAGE if multilanguage page
      if(self::$adminConfig['multiLanguageWebsite']['active'])
        $href .= '&amp;language='.$language;
      
      if($sessionId)
        $href .= '&amp;'.$sessionId;
      
      return $href;
    }  
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
  * @version 1.0
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.0 initial release
  * 
  */
  public static function htmLawed($string, $config = false) {
    
    if(!self::$adminConfig['editor']['htmlLawed'])
      return $string;
    
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
  * @version 0.1
  * <br>
  * <b>ChangeLog</b><br>
  *    - 0.1 initial release
  * 
  */
  public static function getRealPath($path) {
    $path = preg_replace("/[\\\]+/",'/',$path);
    $path = (substr($path,0,1) == '/' && strpos($path,DOCUMENTROOT) === false) ? DOCUMENTROOT.$path : $path;
    $path = preg_replace("/[\\\]+/", '/',realPath($path));
    return ($path === '') ? false : preg_replace("/[\\\]+/", '/',$path);
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
    if(empty($folder)) return false;
    
    //vars  
    $goTroughFolders['folders'][0] = $folder;
    $goTroughFolders['files'] = array();
    $subFolders = array();
    $files = array();
    $return['folders'] = false;
    $return['files'] = false;
      
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
   * <b>Name</b> createStyleTags()<br>
   * 
   * Goes through a folder recursive and creates a HTML <link> tag for every stylesheet-file found.
   * 
   * <b>Used Global Variables</b><br>
   *    - <var>$adminConfig</var> the administrator-settings config (included in the {@link general.include.php})
   * 
   * @param string $folder  the absolute path of the folder to look for stylesheet files
   * @param bool   $backend if TRUE is substract the {@link GeneralFunctions::$adminConfig $adminConfig['basePath']} from the stylesheet link
   * 
   * @uses GeneralFunctions::readFolderRecursive() to read the folder
   * 
   * @return string|false the HTML <link> tags or FALSE if no stylesheet-file was found
   * 
   * @static 
   * @version 1.0
   * <br>
   * <b>ChangeLog</b><br>
   *    - 1.0 initial release
   * 
   */
  public static function createStyleTags($folder, $backend = true) {
    
    //var
    $return = false;

    // ->> goes trough all folder and subfolders
    $filesInFolder = self::readFolderRecursive($folder);
    if(is_array($filesInFolder['files'])) {
      foreach($filesInFolder['files'] as $file) {
        // -> check for CSS FILES
        if(substr($file,-4) == '.css') {
          // -> removes the $adminConfig('realBasePath')
          if($backend) $file = str_replace(self::$adminConfig['realBasePath'],'',$file);
          // -> WRITES the HTML-Style-Tags
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
  * <b>Name</b> showMemoryUsage()<br>
  * 
  * Shows the memory usage at the point of the script where this public static function is called.
  * 
  * @return void
  * 
  * @static
  * @version 1.0
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.0 initial release
  * 
  */
  public static function showMemoryUsage() {
      $mem_usage = memory_get_usage(true);
      
      echo $mem_usage.' -> ';
      
      if ($mem_usage < 1024)
          echo $mem_usage." bytes";
      elseif ($mem_usage < 1048576)
          echo round($mem_usage/1024,2)." kilobytes";
      else
          echo round($mem_usage/1048576,2)." megabytes";
         
      echo "<br>";
  }
}
?>