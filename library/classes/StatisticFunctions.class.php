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
 * This file contains the {@link StatisticFunctions} class.
 *
 * @package [Implementation]-[Backend]
 *
 */

/**
* <b>Classname</b> StatisticFunctions<br>
*
* Provides public static functions for the website statistics.
*
* <b>Note</b>: this class will be used by the implementation classes AND the backend of the feindura-CMS.
*
* @package [Implementation]-[Backend]
*
* @version 0.7
* <br>
*  <b>ChangeLog</b><br>
*    - 0.7 moved a lot of functions to and from GeneralFunctions and backend.functions.php; add $pagesMetaData array
*    - 0.6.4 moved createBrowserChart() and createTagCloud() to backend.functions.php
*    - 0.6.3 check if add searchwords and add data to dataString is not empty
*    - 0.62 change to static class
*    - 0.61 doesnt extend GeneralFunctions anymore, no creates an instance of it
*    - 0.60 add hasVistiCache()
*    - 0.59 refreshPageStatistics(): prevent save searchwords to be counted miltuple times
*    - 0.58 fixed isRobot() and saveWebsiteStatistic()
*    - 0.57 add new browsers to createBrowserChart()
*    - 0.56 started documentation
*
*/

class StatisticFunctions {

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
  * @see init()
  *
  */
  public static $adminConfig;

  /**
  * Contains the category-settings config <var>array</var>
  *
  * @static
  * @var array
  * @see init()
  *
  */
  public static $categoryConfig;

 /**
  * Contains the website-config <var>array</var>
  *
  * Example array:
  * {@example backend/websiteConfig.array.example.php}
  *
  * @static
  * @var array
  * @see init()
  */
  public static $websiteConfig = array();

 /**
  * Contains the website-statistic <var>array</var>
  *
  * Example array:
  * {@example backend/websiteStatistic.array.example.php}
  *
  * @static
  * @var array
  * @see init()
  */
  public static $websiteStatistic = array();

 /**
  * Contains the backend-statistic config <var>array</var>
  *
  * This <var>array</var> contains the number of task logs and referrer logs saved until the last line is droped.
  *
  * Example array:
  * {@example backend/statisticConfig.array.example.php}
  *
  * @static
  * @var array
  * @see init()
  */
  public static $statisticConfig = array();

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
  public static $pagesMetaData = array();

 /**
  * The current Browser name
  *
  *
  * @static
  * @var string|false
  * @see StatisticFunctions::getBrowser()
  */
  public static $browser = false;


 /* ---------------------------------------------------------------------------------------------------------------------------- */
 /* *** CONSTRUCTOR *** */
 /* **************************************************************************************************************************** */

 /**
  * <b> Type</b>      constructor<br>
  *
  * Constructor is not callable, {@link StatisticFunctions::init()} is used instead.
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
  *    - <var>$websiteConfig</var> the website-settings config (included in the {@link general.include.php})
  *    - <var>$websiteStatistic</var> the website-statistic (included in the {@link general.include.php})
  *    - <var>$statisticConfig</var> the statistic-settings config (included in the {@link general.include.php})
  *
  *
  * @return void
  *
  * @static
  * @version 1.3
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.3 add $categoryConfig back again
  *    - 1.2 add $pagesMetaData
  *    - 1.1 removed $categoryConfig
  *    - 1.02 removed instatiating of GeneralFunctions class, because GeneralFunctions is now static
  *    - 1.01 add $adminConfig and $categoryConfig and creates an instance of the GeneralFunctions class
  *    - 1.0 initial release
  *
  */
  public static function init() {

    // GET CONFIG FILES and SET CONFIG PROPERTIES
    self::$adminConfig      = $GLOBALS["adminConfig"];
    self::$categoryConfig   = $GLOBALS["categoryConfig"];
    self::$websiteConfig    = $GLOBALS["websiteConfig"];
    self::$websiteStatistic = $GLOBALS["websiteStatistic"];
    self::$statisticConfig  = $GLOBALS["statisticConfig"];
    self::$pagesMetaData    = $GLOBALS["pagesMetaData"];
  }

 /* ---------------------------------------------------------------------------------------------------------------------------- */
 /* *** METHODS *** */
 /* **************************************************************************************************************************** */

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
  * @version 2.1
  * <br>
  * <b>ChangeLog</b><br>
  *   - moved to StatisticFunctions
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
  * <b> Name</b> getCurrentPageId()<br>
  *
  * Returns the current page ID from the <var>$_GET</var> variable.
  *
  * Gets the current page ID from the <var>$_GET</var> variable.
  * If <var>$_GET</var> is not a ID but a page name, it loads all pages in an array and look for the right page name and returns the ID.
  * If no <var>$_GET</var> variable exists try to return the <var>$startPage</var> parameter.
  *
  *
  * <b>Used Global Variables</b><br>
  *    - <var>$_GET</var> to fetch the page ID
  *    - <var>$varNames</var> the varNames generated in the {@link general.include.php})
  *
  * @param int $startPage the startPage, given when it comes from the {@link Feindura::__construct() Feindura class}
  *
  * @uses $adminConfig                     to look if set startpage is allowed
  * @uses GeneralFunctions::$pagesMetaData to get all page titles, to get the right page ID, if the $_GET variable is not a ID but a page name
  *
  *
  * @return int|false the current page ID or FALSE
  *
  * @access public
  * @version 1.3
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.3 pretty url page name looks now only in the current category for a match
  *    - 1.2 moved to StatisticsFunctions; use now $pagesMetaData
  *    - 1.1 add localization
  *    - 1.0 initial release
  *
  */
  public static function getCurrentPageId($startPage = null,$category = null) {
    // ->> GET PAGE is an ID
    // *********************
    if(isset($_GET[self::$adminConfig['varName']['page']]) &&
       !empty($_GET[self::$adminConfig['varName']['page']]) &&
       is_numeric($_GET[self::$adminConfig['varName']['page']])) {

      // get PAGE GET var
      return intval(XssFilter::int($_GET[self::$adminConfig['varName']['page']],false)); // get the page ID from the $_GET var

    // ->> GET PAGE is a feindura link
    // **********************
    } elseif(isset($_GET['feinduraPageID']) &&
             !empty($_GET['feinduraPageID']) &&
             is_numeric($_GET['feinduraPageID'])) {
      // get PAGE GET var
      return intval(XssFilter::int($_GET['feinduraPageID'],0)); // get the page ID from the $_GET var

    // ->> GET PAGE is a STRING
    // **********************
    } elseif(isset($_GET['page']) &&
             !empty($_GET['page'])) {

      foreach(self::$pagesMetaData as $pageMetaData) {

        // look for the page name only in the right category
        if(!is_numeric($category) ||
           $category == 0 ||
           $pageMetaData['category'] == $category) {

          if(!empty($pageMetaData['editedLink'])) {
            // RETURNs the right page Id
            if(basename($pageMetaData['editedLink']) == self::urlEncode($_GET['page']))
              return intval($pageMetaData['id']);

          } else {
            // goes trough each localization and check if its fit the $_GET['page'] title
            if(is_array($pageMetaData['localized'])) {
              foreach ($pageMetaData['localized'] as $localizedPageContent) {
                // RETURNs the right page Id
                if(self::urlEncode($localizedPageContent['title']) == self::urlEncode($_GET['page'])) {
                  return intval($pageMetaData['id']);
                }
              }
            }
          }
        }


      }

      // -> if no page was found in the current category, look everywhere (same code again)
      foreach(self::$pagesMetaData as $pageMetaData) {

        if(!empty($pageMetaData['editedLink'])) {
          // RETURNs the right page Id
          if(basename($pageMetaData['editedLink']) == self::urlEncode($_GET['page']))
            return intval($pageMetaData['id']);

        } else {
          // goes trough each localization and check if its fit the $_GET['page'] title
          if(is_array($pageMetaData['localized'])) {
            foreach ($pageMetaData['localized'] as $localizedPageContent) {
              // RETURNs the right page Id
              if(self::urlEncode($localizedPageContent['title']) == self::urlEncode($_GET['page'])) {
                return intval($pageMetaData['id']);
              }
            }
          }
        }
      }

    // if only a category is given, return flase, so it loads the first page of that category
    } elseif(isset($_GET[self::$adminConfig['varName']['category']]) &&
             !empty($_GET[self::$adminConfig['varName']['category']]) &&
             is_numeric($_GET[self::$adminConfig['varName']['category']])) {
      return false;

    // otherwise set the startpage
    } elseif(is_numeric($startPage)) {
      return intval($startPage);
    } else
      return false;
  }

   /**
  * <b> Name</b>      getCurrentCategoryId()<br>
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
  * @uses $adminConfig               to look if set startpage is allowed
  * @uses $categoryConfig            for the right category name, if the $_GET variable is not a ID but a category name
  *
  * @return int|false the current category ID or FALSE
  *
  * @access public
  * @version 1.2
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.2 moved to StatisticFunctions class
  *    - 1.1 add localization
  *    - 1.0 initial release
  *
  */
  public function getCurrentCategoryId($startCategory = null) {

    // ->> GET CATEGORY is an ID
    // *************************
    if(isset($_GET[self::$adminConfig['varName']['category']]) &&
       !empty($_GET[self::$adminConfig['varName']['category']]) &&
       is_numeric($_GET[self::$adminConfig['varName']['category']])) {

      return intval(XssFilter::int($_GET[self::$adminConfig['varName']['category']],0)); // get the category ID from the $_GET var

    // ->> GET CATEGORY is a NAME
    // **************************
    } elseif(isset($_GET['category']) &&
             !empty($_GET['category'])) {

      // if the page is set, get its category
      // if(is_numeric(????$page)) {
        // return GeneralFunctions::getPageCategory($this->page);

      // if not try to get the category from the url
      // } else {
        if(is_array(self::$categoryConfig)) {
          foreach(self::$categoryConfig as $category) {
            // goes trough each localization and check if its fit the $_GET['category'] title
            if(is_array($category['localized'])) {
              foreach($category['localized'] as $localizedCategory) {
                // RETURNs the right category Id
                if(self::urlEncode($localizedCategory['name']) === self::urlEncode($_GET['category'])) {
                  return intval($category['id']);
                }
              }
            }
          }
        } else
          return false;
      // }
    } elseif(empty($_GET['page']) && empty($_GET['category']) && is_numeric($startCategory)) {
      return intval($startCategory);
    } else
      return false;
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
  * @version 1.1
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.1 moved to StatisticFunctions
  *    - 1.0 initial release
  *
  */
  public static function isPageStatisticsArray($page) {
    if(is_array($page) && array_key_exists('id',$page) && array_key_exists('visitorCount',$page))
      return true;
    else
      return false;
  }

 /**
  * <b>Name</b> readPageStatistics()<br>
  *
  * Loads the $pageStatistics array of a page.
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
  * @version 1.1
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.1 moved to StatisticFunctions
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
    $pageStatistics = GeneralFunctions::includeFile(dirname(__FILE__).'/../../statistics/pages/'.$pageId);
    if($pageStatistics === null)
      return null;
    elseif(empty($pageStatistics))
      return false;
    else
      return $pageStatistics;
  }

 /**
  * <b>Name</b> savePageStatistics()<br>
  *
  * Save a page statistics to it's flatfile.
  *
  * Example of the saved $pageStatistics array:
  * {@example readPageStatistics.return.example.php}
  *
  *
  * @param array $pageStatistics    the $pageStatistics array of the page to save
  *
  * @uses $adminConfig      for the save path of the flatfiles
  *
  * @return bool TRUE if the page was succesfull saved, otherwise FALSE
  *
  * @static
  * @version 1.1
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.1 moved to StatisticFunctions
  *    - 1.0 initial release
  *
  */
  public static function savePageStatistics($pageStatistics) {
    // check if array is pageContent array
    if(!self::isPageStatisticsArray($pageStatistics))
      return false;

    // check if statistics folder exists
    if(!is_dir(dirname(__FILE__).'/../../statistics/pages/'))
      @mkdir(dirname(__FILE__).'/../../statistics/pages/',self::$adminConfig['permissions'],true);

    // escape \ and '
    //$pageStatistics = XssFilter::escapeBasics($pageStatistics);

    // CREATE file content
    $fileContent = '';
    $fileContent .= "<?php\n";

    $fileContent .= "\$pageStatistics['id'] =             ".XssFilter::int($pageStatistics['id'],0).";\n";
    $fileContent .= "\$pageStatistics['visitorCount'] =   ".XssFilter::int($pageStatistics['visitorCount'],0).";\n";
    $fileContent .= "\$pageStatistics['firstVisit'] =     ".XssFilter::int($pageStatistics['firstVisit'],0).";\n";
    $fileContent .= "\$pageStatistics['lastVisit'] =      ".XssFilter::int($pageStatistics['lastVisit'],0).";\n";
    $fileContent .= "\$pageStatistics['visitTimeMin'] =   '".$pageStatistics['visitTimeMin']."';\n"; // XssFilter in saveWebsiteStats() method in the StatisticFunctions.class.php
    $fileContent .= "\$pageStatistics['visitTimeMax'] =   '".$pageStatistics['visitTimeMax']."';\n"; // XssFilter in saveWebsiteStats() method in the StatisticFunctions.class.php
    $fileContent .= "\$pageStatistics['searchWords'] =    '".$pageStatistics['searchWords']."';\n\n"; // XssFilter in the addDataToDataString() method in the StatisticFunctions.class.php

    $fileContent .= "return \$pageStatistics;";

    $fileContent .= "\n?>";

    // -> write file
    if(file_put_contents(dirname(__FILE__).'/../../statistics/pages/'.$pageStatistics['id'].'.statistics.php', $fileContent, LOCK_EX)) {
      @chmod(dirname(__FILE__).'/../../statistics/pages/'.$pageStatistics['id'].'.statistics.php',self::$adminConfig['permissions']);
      return true;
    } else
      return false;
  }

 /**
  * <b>Name</b> saveRefererLog()<br>
  *
  * Adds a entry to the referer log-file. This log file saves the referer URLS of the users visiting the website.
  *
  * @uses $statisticConfig to get the number of maxmial referer log entries
  * @uses $adminConfig     to prevent storing the own website URL in the referer log
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
  public static function saveRefererLog() {

    if(($_SERVER['HTTP_REFERER'] = XssFilter::url($_SERVER['HTTP_REFERER'])) === false)
      return false;

    $maxEntries = self::$statisticConfig['number']['refererLog'];
    $logFilePath = dirname(__FILE__).'/../../'.'statistics/referer.statistic.log';
    $oldLog =  false;

    if($logFile = @fopen($logFilePath,"r")) {
      flock($logFile,LOCK_SH);
      if(is_file($logFilePath))
        $oldLog = @file($logFilePath);
      flock($logFile,LOCK_UN);
      fclose($logFile);
    }

    // -> SAVE REFERER LOG
    if(isset($_SERVER['HTTP_REFERER']) &&
       !empty($_SERVER['HTTP_REFERER']) &&
       strpos($_SERVER['HTTP_REFERER'],str_replace('www.','',self::$adminConfig['url'])) === false) { // checks if referer is not the own page

      // -> create the new log string
      $newLog = time().'|#|'.$_SERVER['HTTP_REFERER'];

      // CREATE file content
      $fileContent = '';
      $fileContent .= $newLog."\n";
      $count = 2;
      if(is_array($oldLog)) {
        foreach($oldLog as $oldLogRow) {
          $fileContent .= $oldLogRow;
          // stops the log after 120 entries
          if($count == $maxEntries)
            break;
          $count++;
        }
      }

      // -> write file
      if(file_put_contents($logFilePath, $fileContent, LOCK_EX)) {
        // -> add permissions on the first creation
        if(!$oldLog) @chmod($logFilePath, self::$adminConfig['permissions']);

        return true;
      } else
        return false;
    }
    return false;
  }

 /**
  * <b>Name</b> getBrowser()<br>
  *
  * Returns the right browser name.
  *
  * @uses Browser::getBrowser to get the right browser
  * @uses StatisticFunctions::$browser
  *
  * @return string|false the right browser name or FALSE if no useragent is available
  *
  * @static
  * @version 1.01
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.01 add the browser detection class from {@link http://chrisschuld.com/projects/browser-php-detecting-a-users-browser-from-php}
  *    - 1.0 initial release
  *
  */
  public static function getBrowser() {

    if(!self::$browser) {
      require_once(dirname(__FILE__).'/../thirdparty/PHP/BrowserDetection.php');

      $browser = new Browser();
      $return = $browser->getBrowser();

      // check if older IE
      if($return == 'Internet Explorer' && $browser->getVersion() <= 6)
       $return = 'Internet Explorer old';

      if($return == 'Shiretoko')// || $return == 'Mozilla')
        $return = 'Firefox';

      // -> return
      self::$browser = strtolower($return);
    }

    return self::$browser;
  }

 /**
  * <b>Name</b> addDataToDataString()<br>
  *
  * Adds a new string to a data-string and counts the string up if its already existing.
  *
  * Example dataString:
  * {@example dataString.array.example.php}
  *
  * @param string       $dataString           the data-string which the $dataToAdd parameter will be add to
  * @param string|array $dataToAdd            a string or an array with data to add, OR a unserialized data-string
  *
  *
  * @return string the modified data-string
  *
  * @static
  * @version 1.1.1
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.1.1 check if add data is not empty
  *    - 1.1 changed to searialize data
  *    - 1.0 initial release
  *
  */
  public static function addDataToDataString($dataString, $dataToAdd) {

    // if dataToAdd is a serialized data-string
    if(is_string($dataToAdd) && !empty($dataToAdd) && ($unserializedDataToAdd = unserialize($dataToAdd)) !== false) {
      if(is_string($dataString) && !empty($dataString)) {

        // var
        $dataArray = unserialize($dataString);
        $newDataArray = $dataArray;
        $newDataToAddArray = $unserializedDataToAdd;

        // -> check if data already exists, if then add the number from one array to the other one
        foreach($dataArray as $key => $dataArrayVariable) {
          foreach($unserializedDataToAdd as $dataToAddKey => $dataToAddArrayVariable) {
            if($dataArrayVariable['data'] == $dataToAddArrayVariable['data']) {
              $newDataArray[$key]['number'] += $dataToAddArrayVariable['number'];
              unset($newDataToAddArray[$dataToAddKey]);
            }
          }
        }
        // add data
        foreach($newDataToAddArray as $key => $value) {
          if(!empty($value['data'])) { // add only data values which is not empty
            $newDataToAddArray[$key]['data'] = XssFilter::text($value['data']);
            $newDataToAddArray[$key]['number'] = XssFilter::int($value['number'],1);
          }
        }

        $newDataArray = array_merge($newDataArray,$newDataToAddArray);

        // sort the new created array
        usort($newDataArray, 'sortDataString');

        return serialize($newDataArray);
      } else
        return $dataToAdd;

    } else {

      // var
      if(!is_array($dataToAdd))
        $newdata = array($dataToAdd);
      else
        $newdata = $dataToAdd;
      if(($exisitingData = unserialize($dataString)) === false)
        $exisitingData = array();
      $newDataArray = $exisitingData;

      // ->> add new data

      // -> check if data already exists, if then count up the number of the data
      if(is_array($exisitingData) && !empty($exisitingData)) {
        foreach($exisitingData as $key => $exisitingDataVariable) {
          // if then count up the number of the data
          if(false !== ($foundKey = array_search(mb_strtolower($exisitingDataVariable['data'],'UTF-8'),$newdata))) {
            $newDataArray[$key]['number']++;
            // and remove the data from the $data array
            unset($newdata[$foundKey]);
          }
        }
      }

      // -> add the new data
      if(is_array($newdata) && !empty($newdata)) {
        foreach($newdata as $dataVariable) {
          if(!empty($dataVariable)) { // add only data values which is not empty
            $dataVariable = XssFilter::text($dataVariable);
            $newDataArray[] = array('data' => mb_strtolower($dataVariable,'UTF-8'), 'number' => 1);
          }
        }
      }

      // sort the new created array
      usort($newDataArray, 'sortDataString');

      return serialize($newDataArray);
    }
  }

 /**
  * <b>Name</b> isRobot()<br>
  *
  * Check if the user-agent is a spider/bot/webcrawler.
  * This method uses the "library/thirdparty/spider.xml".
  *
  * The list of spiders it uses is from: {@link http://www.wolfshead-solutions.com/spiders-list}
  *
  * @return bool TRUE if its a spider/bot/webcrawler, FALSE if not
  *
  * @static
  * @version 1.0.1
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.0.1 store the isRobot value directly in the session and return it
  *    - 1.0 initial release
  *
  */
  public static function isRobot() {

    // pre check if isRobot is already stored somewhere
    // session
    if(isset($_SESSION['feinduraSession']['log']['isRobot']))
      return $_SESSION['feinduraSession']['log']['isRobot'];
    // cache
    elseif(($currentVisitor = self::getCurrentVisitor()) !== false) {
        if($currentVisitor['type'] == 'robot')
          return true;
        else
          return false;
    }

    if(isset($_SERVER['HTTP_USER_AGENT'])) {

      // var
      $userAgent = $_SERVER['HTTP_USER_AGENT'];

      // get the list of bots from the spiders_vbulletin.xml
      if($xml = simplexml_load_file(dirname(__FILE__)."/../thirdparty/spiders_vbulletin.xml", 'SimpleXMLElement', LIBXML_NOCDATA)) {
        foreach($xml as $xmlData) {
            $bots[] = strtolower($xmlData['ident']);
        }
      }
      //DebugTools::dump($bots);

      $userAgent = strtolower($userAgent);
      $i = 0;
      $summe = count($bots);

      // User-Agent is no Bot
      $_SESSION['feinduraSession']['log']['isRobot'] = false;
      foreach($bots as $bot) {
        if(strpos(strtolower($userAgent), strtolower($bot)) !== false) {
          //echo $_SERVER['HTTP_USER_AGENT'].'<br>'.$bot;
          $_SESSION['feinduraSession']['log']['isRobot'] = true; // User-Agent is a Bot
        }
      }
    } else
      $_SESSION['feinduraSession']['log']['isRobot'] = false; // no HTTP_USER_AGENT available

    return $_SESSION['feinduraSession']['log']['isRobot'];
  }

 /**
  * <b>Name</b> visitorCache()<br>
  *
  * Creates a <var>visitor.statistic.cache</var> file and store the md5 sum of the user agent + ip with a timestamp.
  * If the agent load again the website, it check if the agent is already in the cache and the timelimit of 10 min is not passed.
  *
  * This public static function is used when the session ID cannot be transfered, because of deactivated cookies or no session ID in the link was transfered.
  *
  * An example of the saved cache lines
  * <samp>
  * 1306733465|#|visitor|#|c5b5533c8475801044fb7680059d5846|#|192.168.0.1
  * </samp>
  *
  * @param bool $add if this is FALSE, it only check if the agents in the cache are still up to date, without adding a user agent
  *
  * @return bool TRUE the user agent is in the cache, FALSE if not
  *
  * @static
  * @version 1.01
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.01 add type, which can be "robot" or "visitor"
  *    - 1.0 initial release
  *
  */
  public static function visitorCache($add = true) {

    //var
    $return = false;
    $maxTime = 600; // 3600 seconds = 1 hour
    $userAgentMd5 = md5($_SERVER['HTTP_USER_AGENT'].'::'.$_SERVER['REMOTE_ADDR']);
    $timeStamp = time();
    $cacheFile = dirname(__FILE__)."/../../statistics/visitor.statistic.cache";
    $newLines = array();
    $cachedLines = false;

    // -> OPEN visitor.statistic.cache for reading
    if($cache = @fopen($cacheFile,"r")) {
      flock($cache,LOCK_SH);
      if(is_file($cacheFile))
        $cachedLines = @file($cacheFile);
      flock($cache,LOCK_UN);
      fclose($cache);
    }

      if(is_array($cachedLines)) {
        foreach($cachedLines as $cachedLine) {
          $cachedLineArray = explode('|#|', $cachedLine);
          // print_r($timeStamp - $cachedLineArray[0] ." < ". $maxTime.'<br>');

          // stores the agent AGAIN with new timestamp, if the visitor was less than $maxTime on the page,
          // otherwise remove the agent form the cache (dont save his line)
          if($timeStamp - $cachedLineArray[0] < $maxTime) {
            if($add && $cachedLineArray[2] == $userAgentMd5) {
              $newLines[] = $timeStamp.'|#|'.$cachedLineArray[1].'|#|'.$cachedLineArray[2].'|#|'.$_SERVER['REMOTE_ADDR'];
              $return = true;
            } else
              $newLines[] = $cachedLine;
          }
        }
      }
      // agent doesn't exist, create a new cache line
      if($add && $return === false) {
        if(self::isRobot())
          $type = 'robot';
        else
          $type = 'visitor';
        $newLines[] = $timeStamp.'|#|'.$type.'|#|'.$userAgentMd5.'|#|'.$_SERVER['REMOTE_ADDR'];
      }

    // CREATE file content
    $fileContent = '';
    foreach($newLines as $newLine) {
      $newLine = preg_replace('#[\r\n]+#','',$newLine);
      $fileContent .= $newLine."\n";
    }

    // -> write file
    if(@file_put_contents($cacheFile, $fileContent, LOCK_EX)) {
      // -> add permissions on the first creation
      if(!$cachedLines) @chmod($cacheFile, self::$adminConfig['permissions']);
    }

    // return the right value
    return $return;
  }

 /**
  * <b>Name</b> getCurrentVisitor()<br>
  *
  * Gets the current visitor (only the CURRENT) from the visitCache file (<var>statistics/visitor.statistic.cache</var>)
  *
  * @return array the current visitor with $returnVisitors['ip'], $returnVisitors['time'] and $returnVisitors['type']
  *
  * @static
  * @version 1.0
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.0 initial release
  *
  */
  public static function getCurrentVisitor() {

    //var
    $returnVisitors = array();
    $cacheFile = dirname(__FILE__)."/../../statistics/visitor.statistic.cache";

    if(!file_exists($cacheFile)) return $returnVisitors;
    if($currentVisitors = @file($cacheFile)) {

      foreach($currentVisitors as $currentVisitor) {
        $currentVisitor = explode('|#|',$currentVisitor);
        if($currentVisitor[2] == md5($_SERVER['HTTP_USER_AGENT'].'::'.$_SERVER['REMOTE_ADDR'])) {
          $returnVisitor['time'] = $currentVisitor[0];
          $returnVisitor['type'] = $currentVisitor[1];
          $returnVisitor['ip'] = $currentVisitor[3];
          return $returnVisitor;
        }
      }
    }
    unset($currentVisitors);
    return false;
  }

 /**
  * <b>Name</b> getCurrentVisitors()<br>
  *
  * Gets the current visitors (ALL) from the visitCache file (<var>statistics/visitor.statistic.cache</var>)
  *
  * @return array the current visitors with $returnVisitors['ip'], $returnVisitors['time'] and $returnVisitors['type']
  *
  * @static
  * @version 1.0
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.0 initial release
  *
  */
  public static function getCurrentVisitors() {

    //var
    $returnVisitors = array();
    $cacheFile = dirname(__FILE__)."/../../statistics/visitor.statistic.cache";

    if(!file_exists($cacheFile)) return $returnVisitors;
    if($currentVisitors = @file($cacheFile)) {

      // sort the visitors, the latest one first
      usort($currentVisitors, 'sortCurrentVisitorsByTime');

      foreach($currentVisitors as $currentVisitor) {
        $currentVisitor = explode('|#|',$currentVisitor);
        $returnVisitor['time'] = $currentVisitor[0];
        $returnVisitor['type'] = $currentVisitor[1];
        $returnVisitor['ip'] = $currentVisitor[3];
        $returnVisitors[] = $returnVisitor;
      }
    }
    unset($currentVisitors);
    return $returnVisitors;
  }

 /**
  * <b>Name</b> saveWebsiteStats()<br>
  *
  * Saves the following values of the website-statistic:
  *   - number of user visits
  *   - number of bot visits
  *   - first visit date time
  *   - last visit date time
  *   - which browser and how often visited this website
  *
  * Saves the time spend on the last Pages
  *   - minimal time spend on the page
  *   - maxmimal time spend on the page
  *
  * <b>Used Global Variables</b>
  *    - <var>$_SESSION</var> to store whether the user visited the website already, to prevent double counting
  *
  * @param false|int $page a page ID, of the current page, where the page statistic should be saved
  *
  * @uses $websiteStatistic            for the old website-statistics
  * @uses saveRefererLog()             to save the referer log-file
  * @uses isRobot()                    to check whether the user-agent is a robot or a human
  * @uses addDataToDataString()        to add a browser to the browser data-string
  * @uses readPageStatistics()         to read the last page again, to save the time spend on the page
  * @uses savePageStatistics()         to save the current page statictics
  * @uses refreshPageStatistics()      to save the current page statistics
  * @uses getCurrentPageId()           to get the current page
  *
  * @return bool TRUE if the website-statistics were saved, otherwise FALSE
  *
  * @static
  * @version 1.0.3
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.0.3 moved the visitorCache inside the if condition
  *    - 1.0.2 fixed save visit Time with unix timestamps
  *    - 1.0.1 if Robot it will only be counted nothing else
  *    - 1.0 initial release
  *
  */
  public static function saveWebsiteStats($page = false) {

    // $_SESSION needed for check if the user has already visited the page AND reduce memory, because only run once the isRobot() public static function
    // unset($_SESSION['feinduraSession']);

    // var
    if($page === false) {
      $page = self::getCurrentPageId(self::$websiteConfig['startPage'],self::getCurrentCategoryId(GeneralFunctions::getPageCategory($websiteConfig['startPage'])));
    }

    // STORES all LAST VISITED PAGES in array, in the order they are visited (will also double count pages)
    $_SESSION['feinduraSession']['log']['visitedPagesOrder'][] = $page;
    if(count($_SESSION['feinduraSession']['log']['visitedPagesOrder']) > 20)
      array_shift($_SESSION['feinduraSession']['log']['visitedPagesOrder']);

    // QUIT if LOGGED IN
    // if($_SESSION['feinduraSession']['login']['loggedIn'])
      // return false;

    $hasCurrentVisitors = self::visitorCache(); // count and renew the current visitors

    // #### DUMP ####
    // if(empty(self::$websiteStatistic) || self::$websiteStatistic === 1) {
    //   $dump = (self::isRobot()) ? "Is BOT!\n" : "Is not a bot.\n";
    //   $dump .= 'IDENTITY: '.$_SERVER['HTTP_USER_AGENT'].'::'.$_SERVER['REMOTE_ADDR']."\n";
    //   $dump .= ($hasCurrentVisitors) ? 'got it in the visitor.statistic.cache!'."\n\n" : 'is not in the visitor.statistic.cache'."\n\n".

    //   $dump .= (is_file(dirname(__FILE__)."/../../statistics/website.statistic.php")) ? "website.statistic.php exist!"."\n" : "website.statistic.php is gone!!?"."\n";
    //   $dump .= 'Include again the website.statistic.php: '.print_r(include(dirname(__FILE__)."/../../statistics/website.statistic.php"),true)."\n\n";

    //   $dump .= '$GLOBALS["websiteStatistic"): '.print_r($GLOBALS["websiteStatistic"],true)."\n";
    //   $dump .= '$GLOBALS["feindura_websiteStatistic"]: '.print_r($GLOBALS["feindura_websiteStatistic"],true)."\n";
    //   $dump .= 'self::$websiteStatistic: '.print_r(self::$websiteStatistic,true)."\n";
    //   $dump .= '$_SESSION: '.print_r($_SESSION,true)."\n";
    //   mail('fabian@feindura.org', self::$adminConfig['url'].' statistiken geloescht, dump output OUTSIDE', $dump);
    // }


    // COUNT if the user/robot isn't already counted
    // **********************************************
    if(!self::$websiteStatistic['locked'] && ((isset($_SESSION['feinduraSession']['log']['visited']) && $_SESSION['feinduraSession']['log']['visited'] === false) ||
       (!isset($_SESSION['feinduraSession']['log']['visited']) && $hasCurrentVisitors === false))) {

      // ->> CHECKS if the user is NOT a BOT/SPIDER
      if(self::isRobot() === false) {

        // -------------------------------------------------------------------------------------
        // -------------------------------------------------------------------------------------
        // ->> WEBSITE STATISTIC
        // ---------------------

        // -> saves the FIRST WEBSITE VISIT
        // -----------------------------
        if(!isset(self::$websiteStatistic['firstVisit']) ||
          (isset(self::$websiteStatistic['firstVisit']) && empty(self::$websiteStatistic['firstVisit'])))
          self::$websiteStatistic['firstVisit'] = time();

        // -> saves the LAST WEBSITE VISIT
        // ----------------------------
        self::$websiteStatistic['lastVisit'] = time();

        // -> saves the HTTP REFERER
        // ----------------------------
        self::saveRefererLog();

        // -> COUNT the USER UP
        if(!isset(self::$websiteStatistic['userVisitCount']) ||
           (isset(self::$websiteStatistic['userVisitCount']) && empty(self::$websiteStatistic['userVisitCount'])))
          self::$websiteStatistic['userVisitCount'] = 1;
        else
          self::$websiteStatistic['userVisitCount']++;

        // -> adds the user BROWSER
        $browser = self::getBrowser();
        if(isset(self::$websiteStatistic['browser']))
          self::$websiteStatistic['browser'] = self::addDataToDataString(self::$websiteStatistic['browser'],$browser);
        else
          self::$websiteStatistic['browser'] = $browser.',1';

        if(!isset(self::$websiteStatistic["robotVisitCount"]))
          self::$websiteStatistic["robotVisitCount"] = 0;


      // ->> COUNT the ROBOT UP
      } elseif(self::isRobot() === true &&
               (!isset(self::$websiteStatistic['robotVisitCount']) ||
               (isset(self::$websiteStatistic['robotVisitCount']) && empty(self::$websiteStatistic['robotVisitCount'])))) {
        self::$websiteStatistic['robotVisitCount'] = 1;
      } elseif(self::isRobot() === true) {
        self::$websiteStatistic['robotVisitCount']++;
      }

      // ->> CREATE writing string
      $statisticFile = '';
      $statisticFile .= "<?php\n";
      $statisticFile .= "\$websiteStatistic['userVisitCount'] =    ".XssFilter::int(self::$websiteStatistic["userVisitCount"],0).";\n";
      $statisticFile .= "\$websiteStatistic['robotVisitCount'] =   ".XssFilter::int(self::$websiteStatistic["robotVisitCount"],0).";\n\n";

      $statisticFile .= "\$websiteStatistic['firstVisit'] =        ".XssFilter::int(self::$websiteStatistic["firstVisit"],0).";\n";
      $statisticFile .= "\$websiteStatistic['lastVisit'] =         ".XssFilter::int(self::$websiteStatistic["lastVisit"],0).";\n\n";

      $statisticFile .= "\$websiteStatistic['browser'] =           '".self::$websiteStatistic["browser"]."';\n\n"; // XssFilter in the addDataToDataString() method

      $statisticFile .= "return \$websiteStatistic;";
      $statisticFile .= "\n?>";

      // -> SAVE the flat file
      if(file_put_contents(dirname(__FILE__)."/../../statistics/website.statistic.php", $statisticFile, LOCK_EX))
        // saves the user as visited
        $_SESSION['feinduraSession']['log']['visited'] = true;

      // -> add permissions on the first creation
      if(self::$websiteStatistic["userVisitCount"] === 1) @chmod(dirname(__FILE__)."/../../statistics/website.statistic.php", self::$adminConfig['permissions']);


    // ->> save the time of the last visited page
    // **********************************************
    } elseif(self::isRobot() === false) { // ->> CHECKS if the user is NOT a BOT/SPIDER

      // -------------------------------------------------------------------------------------
      // ->> VISIT TIME of PAGES
      // -----------------------

      $newMinVisitTimes = '';
      $newMaxVisitTimes = '';
      $maxCount = 10; // the maximal number of visit time (min and max) saved

      // -> count the time difference, between the last page and the current
      if(isset($_SESSION['feinduraSession']['log']['lastPages']) && isset($_SESSION['feinduraSession']['log']['lastTimestamp'])) {

        $lastPageId = $_SESSION['feinduraSession']['log']['lastPage'];

        // load the last page again
        $lastPage = self::readPageStatistics($lastPageId);

        // prevent resetting page stats
        if($lastPage === null)
          break;

        if(!$lastPage) $lastPage['id'] = $lastPageId;

        $visitTime = time() - XssFilter::int($_SESSION['feinduraSession']['log']['lastTimestamp'],0);

        // saves time only when longer than 5 seconds
        if($visitTime > 5) {
          $isNotMax = true;

          // -> saves the MAX visitTime
          // **************************
          if(!empty($lastPage['visitTimeMax'])) {

            $maxVisitTimes = unserialize($lastPage['visitTimeMax']);

            // adds the new time if it is bigger than the highest min time
            if($visitTime > $maxVisitTimes[0]) {
              array_unshift($maxVisitTimes,$visitTime);
              $isNotMax = false;
            }
            // adds the new time on the beginnig of the array
            $newMaxVisitTimes = array_slice($maxVisitTimes,0,$maxCount);

            // sort array
            natsort($newMaxVisitTimes);
            $newMaxVisitTimes = array_reverse($newMaxVisitTimes);
            // make array to string
            $newMaxVisitTimes = serialize($newMaxVisitTimes);

          } else
            $newMaxVisitTimes = serialize(array($visitTime));

          // -> saves the MIN visitTime
          // **************************
          if(!empty($lastPage['visitTimeMin']) && $isNotMax) {

            $minVisitTimes = unserialize($lastPage['visitTimeMin']);

            // adds the new time if it is bigger than the highest min time
            if($visitTime > $minVisitTimes[count($minVisitTimes)-1]) {
              array_unshift($minVisitTimes,$visitTime);
            }
            // adds the new time on the beginnig of the array
            $newMinVisitTimes = array_slice($minVisitTimes,0,$maxCount);

            // sort array
            natsort($newMinVisitTimes);
            $newMinVisitTimes = array_reverse($newMinVisitTimes);
            // make array to string
            $newMinVisitTimes = serialize($newMinVisitTimes);

          } elseif(!empty($lastPage['visitTimeMin']))
            $newMinVisitTimes = $lastPage['visitTimeMin'];
          else
            $newMinVisitTimes = serialize(array(0));

          //echo 'MAX -> '.$newMaxVisitTimes.'<br>';
          //echo 'MIN -> '.$newMinVisitTimes.'<br>';

          // -> adds the new max times to the pageContent Array
          $lastPage['visitTimeMax'] = $newMaxVisitTimes;
          $lastPage['visitTimeMin'] = $newMinVisitTimes;

          self::savePageStatistics($lastPage);
        }

      }
      // STORE last visited page IDs in a session array and the time
      $_SESSION['feinduraSession']['log']['lastPage'] = $page;
    }

    // -> store the visitime start
    $_SESSION['feinduraSession']['log']['lastTimestamp'] = time();

    // SAVE CURRENT PAGE STATS
    self:: refreshPageStatistics($page);
  }

 /**
  * <b>Name</b> refreshPageStatistics()<br>
  *
  * Saves the following values of the page-statistic:<br>
  *   - number of visitors
  *   - first visit date time
  *   - last visit date time
  *   - which searchwords and how often they occured
  *
  * <b>Used Global Variables</b><br>
  *    - <var>$_SESSION</var> to store whether the user is a robots and save the time and ID of the last page to calculate the time viewed the pages
  *
  *
  * @param $pageContent     the $pageContent array of the page
  *
  * @uses $adminConfig                            for the save path of the pages
  * @uses isRobot()                               to check whether the user-agent is a robot or a human
  * @uses addDataToDataString()                   to add the searchwords to the searchword data-string
  * @uses readPageStatistics()                    to read the last page again, to save the time spend on the page
  * @uses savePageStatistics()                    to save the current page statictics
  *
  * @return bool TRUE if the page-statistic was saved succesfully or FALSE if the user agent is a robot, or the $pageContent parameter is not a valid $pageContent array
  *
  * @static
  * @version 1.0.3
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.0.3 check if searchwords are not empty
  *    - 1.0.2 fixed scalar value returned from readPageStatistics()
  *    - 1.0.1 prevent save searchwords to be counted miltuple times
  *    - 1.0 initial release
  *
  */
  public static function refreshPageStatistics($pageId) {

    // $_SESSION needed for check if the user has already visited the page AND reduce memory, because only run once the isRobot() public static function
    // unset($_SESSION['feinduraSession']);

    // QUIT if LOGGED IN
    if($_SESSION['feinduraSession']['login']['loggedIn'] || !is_numeric($pageId))
      return false;

    // -------------------------------------------------------------------------------------
    // -->> --------------------------------------------------------------------------------
    // CHECKS if the user is NOT a BOT/SPIDER
    if(self::isRobot() === false) {

      // LOAD the $pageStatistics array
      $pageStatistics = self::readPageStatistics($pageId);
      // prevent resetting page stats
      if($pageStatistics === null)
        return false;

      if(!$pageStatistics) {
        $pageStatistics = array();
        $pageStatistics['id'] = $pageId;
      }

      // -> saves the FIRST PAGE VISIT
      // -----------------------------
      if(empty($pageStatistics['firstVisit'])) {
        $pageStatistics['firstVisit'] = time();
        $pageStatistics['visitorCount'] = 0;
      }

      // -> saves the LAST PAGE VISIT
      // ----------------------------
      $pageStatistics['lastVisit'] = time();

      // -> COUNT vistor, if the user haven't already visited this page in this session
      // --------------------------------------------------------------------------
      if(!isset($_SESSION['feinduraSession']['log']['visitedPages']))
        $_SESSION['feinduraSession']['log']['visitedPages'] = array();

      if(in_array($pageStatistics['id'],$_SESSION['feinduraSession']['log']['visitedPages']) === false) {
        $pageStatistics['visitorCount']++;
        $_SESSION['feinduraSession']['log']['visitedPages'][] = $pageStatistics['id'];
      }


      // ->> SAVE THE SEARCHWORDs from GOOGLE, YAHOO, MSN (Bing)
      // -------------------------------------------------------
      // if(!isset($_SESSION['feinduraSession']['log']['searchwords']))
      //   $_SESSION['feinduraSession']['log']['searchwords'] = array();
      if(isset($_SERVER['HTTP_REFERER']) &&
         !empty($_SERVER['HTTP_REFERER'])) {

        $searchWords = $_SERVER['HTTP_REFERER'];
        // test search querys strings:
        // $searchWords = 'http://www.google.com.tr/url?sa=t&rct=j&q=php%20flat%20file%20image%20gallery%20example&source=web&cd=9&ved=0CGoQFjAI&url=http%3A%2F%2Ffeindura.org%2F&ei=S8csUJ3tMu344QTgpYDQBg&usg=AFQjCNFSegqEPP_sijaHfoj1xrQaXNt9zA';
        // $searchWords = 'http://www.google.com/search?hl=de&q=hall%C3%B6fsdfs++ds%C3%B6%C3%A4&btnG=Suche&aq=f&aqi=&oq=#sclient=psy&hl=de&q=hall%C3%B6fsdfs++da%C3%B6+%C3%9Fddd&aq=f&aqi=&aql=&oq=&pbx=1&fp=59d7fcbbee5898f6';
        // $searchWords = 'http://www.google.de/#sclient=psy&num=10&hl=de&safe=off&q=ich+suche+was&aq=f&aqi=g1&aql=&oq=&gs_rfai=&pbx=1&fp=bea9cbc9f7597291';
        // $searchWords = 'https://www.google.de/search?q=fdsdf&sugexp=chrome,mod=16&sourceid=chrome&ie=UTF-8#hl=de&newwindow=1&sclient=psy-ab&q=fdsdffde&oq=fdsdffde&gs_l=serp.3..0i13i10.1496.2784.0.3553.3.3.0.0.0.0.93.260.3.3.0...0.0...1c.SClebHBDsAc&pbx=1&bav=on.2,or.r_gc.r_pw.r_cp.r_qf.&fp=9d6686a508016dbd&biw=1440&bih=739';
        // $searchWords = 'http://www.bing.com/search?q=sdfsd&go=&qs=n&form=QBLH&filt=all&pq=sdfsd&sc=2-5&sp=-1&sk=';
        // $searchWords = 'http://de.search.yahoo.com/search;_ylt=AoJmH5FT4CkRvDpo3RuiawIqrK5_?vc=&p=hallo+ich+suche+was&toggle=1&cop=mss&ei=UTF-8&fr=yfp-t-708';
        // $searchWords = 'http://de.search.yahoo.com/search;_ylt=Aqok7GSHi2aTQWUyfd05pBkqrK5_;_ylc=X1MDMjE0MjE1Mzc3MARfcgMyBGZyA3lmcC10LTcwOARuX2dwcwMxMARvcmlnaW4DZGUueWFob28uY29tBHF1ZXJ5A3NkZnNkZgRzYW8DMQ--?p=sdfsdf&toggle=1&cop=mss&ei=UTF-8&fr=yfp-t-708';

        $search_engines = array(
          'bing' => 'q',
          'google' => 'q',
          'yahoo' => 'p'
        );
        if($searchWords && preg_match('#('.implode('|', array_keys($search_engines)).')#', $searchWords, $searchEngineMatches) === 1) {

          // gets the searchwords
          $parts = parse_url($searchWords);
          parse_str($parts['query'], $query1);
          parse_str($parts['fragment'], $query2);
          $query = array_merge($query1, $query2);

          $searchEngineQueryName = $search_engines[$searchEngineMatches[0]];

          // get searchwords
          $searchWords = explode(' ',$query[$searchEngineQueryName]);


          // gos through searchwords and check if there already saved
          $newSearchWords = array();
          foreach($searchWords as $searchWord) {
            if(!empty($searchWord)){// && in_array($searchWord,$_SESSION['feinduraSession']['log']['searchwords']) === false) {
              $newSearchWords[] = $searchWord;
              // $_SESSION['feinduraSession']['log']['searchwords'][] = $searchWord;
            }
          }

          if(!empty($newSearchWords)) {
            // adds the searchwords to the searchword data string
            $pageStatistics['searchWords'] = self::addDataToDataString($pageStatistics['searchWords'],$newSearchWords);
          }
        }
      }

      // -> SAVE the PAGE STATISTICS
      return self::savePageStatistics($pageStatistics);

    } else
      return false;
  }
}
