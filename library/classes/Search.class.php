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
 * @package [Backend]
 */

/**
* The class for searching in feindura pages.
*
*
* @author Fabian Vogelsteller <fabian@feindura.org>
* @copyright Fabian Vogelsteller
* @license http://www.gnu.org/licenses GNU General Public License version 3
*
* @package [Backend]
*
* @version 1.3
* <br>
* <b>ChangeLog</b><br>
*    - 1.3 add {@link Search::$checkPermissions}
*    - 1.2 fixed search word pattern
*    - 1.1 add localization and $language + $searchAllLanguages property
*    - 1.0 initial release
*
*/
class Search {

 /* ---------------------------------------------------------------------------------------------------------------------------- */
 /* *** PROPERTIES */
 /* **************************************************************************************************************************** */

 // PROTECTED
 // *********

 /**
  * Contains the admin-settings config set in the CMS backend.
  *
  * The file with the admin-settings config array is situated at <i>"feindura-CMS/config/admin.config.php"</i>.
  *
  * This settings will be set to this property in the {@link __construct() search} constructor.
  *
  * Example array:
  * {@example backend/adminConfig.array.example.php}
  *
  * @var array
  * @access protected
  * @see Search::__construct()
  *
  */
  protected $adminConfig;

 /**
  * Contains the categories-settings config set in the CMS backend.
  *
  * The file with the categories-settings config array is situated at <i>"feindura-CMS/config/category.config.php"</i>.
  *
  * This settings will be set to this property in the {@link __construct() search} constructor.
  *
  * Example array:
  * {@example backend/categoryConfig.array.example.php}
  *
  * @var array
  * @access protected
  * @see Search::__construct()
  *
  */
  protected $categoryConfig;

  /**
  * Whether to search in all languages or not. (Helper variable)
  *
  * @var bool
  * @access protected
  */
  protected $searchAllLanguages = null;


  // PUBLIC
  // *********

  /**
  * The language in which should be searched, if FALSE it searches in all languages
  *
  * @var false|string
  * @access public
  */
  public $language = false;

  /**
  * If its an number it limits the found results in a page to this number, so the search results are still displayable, when a lot of words were found.
  * If FALSE all results will be displayed.
  *
  * @var int|false
  * @access public
  */
  public $limitResults = 5;

  /**
  * If TRUE it only search in pages and categories which are public.
  *
  * @var bool
  * @access public
  */
  public $onlyPublic = true;

  /**
  * If TRUE it will check if the current user has the right to edit the searched page.
  *
  * @var bool
  * @access public
  */
  public $checkPermissions = false;

  /**
  * if TRUE it also search in the category names.
  *
  * @var bool
  * @access public
  */
  public $searchInCategoryNames = true;

  /**
  * The start-tag to mark the finding in a text.
  *
  * @var string
  * @access public
  */
  public $markStartTag = '<mark>';

  /**
  * The end-tag to mark the finding in a text.
  *
  * @var string
  * @access public
  */
  public $markEndTag = '</mark>';


 /* ---------------------------------------------------------------------------------------------------------------------------- */
 /* *** CONSTRUCTOR *** */
 /* **************************************************************************************************************************** */

 /**
  * <b>Type</b> constructor<br>
  *
  * The constructor of the class, sets the {@link $categoryConfig}.
  *
  * <b>Used Global Variables</b><br>
  *    - <var>$categoryConfig</var> the categories-settings config (included in the {@link general.include.php})
  *
  * @param false|string $language The language in which should be searched, if FALSE it searches in all languages
  *
  * @return void
  *
  * @see FeinduraBase::__construct()
  *
  * @access public
  * @version 1.1
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.1 add $adminConfig
  *    - 1.0 initial release
  *
  */
  public function __construct($language = false) {
    $this->adminConfig    = (isset($GLOBALS["adminConfig"])) ? $GLOBALS["adminConfig"] : $GLOBALS["feindura_adminConfig"];
    $this->categoryConfig = (isset($GLOBALS["categoryConfig"])) ? $GLOBALS["categoryConfig"] : $GLOBALS["feindura_categoryConfig"];
    $this->language       = $language;
    $this->searchAllLanguages = (is_string($this->language) && strlen($this->language) == 2) ? false : true;
  }

  // ****************************************************************************************************************
  // METHODs -------------------------------------------------------------------------------------------------
  // ****************************************************************************************************************

 /**
  * <b>Name</b> find()<br>
  *
  * Starts a search.
  *
  *
  * @param string          $searchwords  one or more searchwords to fing
  * @param bool|int|array  $category     (optional) the ID or an array with IDs of the category(ies) in which should be searched, if TRUE it searches in all categories, if FALSE it searches only in the non category
  *
  * @uses searchPages()    to search in the pages
  *
  * @return array an array with the results, or an empty array
  *
  * @access public
  * @version 1.0
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.0 initial release
  *
  */
  public function find($searchwords, $category = true) {

    // -> start search
    $results = $this->searchPages($searchwords, $category);

    // return displayable results
    return $this->createResultsArray($results);

  }

 /**
  * <b>Name</b> searchPages()<br>
  *
  * Goes through pages and search for a matching of the searchwords.
  * Return the results sorted by priority.
  *
  *
  * @param string          $searchwords  one or more searchwords to fing
  * @param bool|int|array  $category     the ID or an array with IDs of the category(ies) in which should be searched, if TRUE it searches in all categories, if FALSE it searches only in the non category
  *
  * @uses Search::$onlyPublic                   if TRUE it searches only in pages which are public
  * @uses sortByPriority()                      to sort the page array
  * @uses GeneralFunctions::isPublicCategory()  to check if the category is public
  * @uses GeneralFunctions::loadPages()         to load the pages
  * @uses XssFilter::text()                     to filter the searchwords
  *
  * @return array|false array with matching searchwords or FALSE
  *
  * @access protected
  * @version 1.0
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.0 initial release
  *
  */
  protected function searchPages($searchwords, $category) {

    // var
    $results = false;

    // -> check if the categories are public
    if($this->onlyPublic)
      $category = GeneralFunctions::isPublicCategory($category);

    // -> load the pages
    $pages = GeneralFunctions::loadPages($category);

    // -> CHECK if the pages are PUBLIC
    if($this->onlyPublic) {
      foreach($pages as $key => $page) {
        if(!$page['public'])
          unset($pages[$key]);
      }
    }

    // -> CHECK if the user has PERMISSIONS to edit these pages
    if($this->checkPermissions) {
      foreach($pages as $key => $page) {
        if(!GeneralFunctions::hasPermission('editablePages',$page['id']))
          unset($pages[$key]);
      }
    }

    // ->> goes through all pages and search for the keywords
    foreach($pages as $pageContent)  {

      // var
      $changeChars = array(' ','.','-','/');
      $pageResults = false;
      $text = false;

      // set the priority of the results to 0
      $priority = 0;

      // generate search pattern
      $pattern = preg_replace('# +#', ' ', $searchwords);
      $pattern = str_replace($changeChars,'|',$pattern);
      $pattern = preg_quote($pattern); // escape regex pattern
      $pattern = str_replace(array('\|',"'",'"'),array('|','',''),$pattern);
      $pattern = trim($pattern,'|');
      $pattern = XssFilter::text($pattern);
      $pattern = ($pattern != '') ? '#'.$pattern.'#i' : '#a^#';

      // DebugTools::dump($pattern);

      // ->> GET LANGUAGE ot SEARCH
      // -> get ALL LANGUAGES
      if($this->searchAllLanguages && is_array($pageContent['localized'])) {
        $languages = array_keys($pageContent['localized']);

      // -> get specified LANGUAGE
      } else {
        $languages = (is_array($pageContent['localized']) && array_key_exists($this->language, $pageContent['localized'])) ? $this->language : $this->websiteConfig['multiLanguageWebsite']['mainLanguage'];
      }


      // create a string of the page searchwords
      $pageStatistics = StatisticFunctions::readPageStatistics($pageContent['id']);
      $search['searchwords'] = unserialize($pageStatistics['searchWords']);
      $pageSearchwords = '';
      if(is_array($search['searchwords'])) {
        foreach($search['searchwords'] as $pageSearchword){
          $pageSearchwords .= '####'.$pageSearchword['data'];
        }
        $search['searchwords'] = trim($pageSearchwords,'####');
      }

      // ->> PREPARE the to SEARCH CONTENTS as an ARRAY
      $search['id']            = $pageContent['id'];
      $search['date']['start'] = GeneralFunctions::formatDate($pageContent['pageDate']['start']);
      $search['date']['end']   = GeneralFunctions::formatDate($pageContent['pageDate']['end']);


      // ->> SEARCH PROCESS

      // -> 1. ID
      if(is_numeric($searchwords) &&
         preg_match_all($pattern,$search['id'],$matches,PREG_OFFSET_CAPTURE) != 0) {
        $pageResults['id'] = $matches[0];
        $priority += 999;

      // -> IF NO MATCH in ID, SEARCH in OTHER PLACES
      } else {

        // -> SEARCHWORDS
        if(preg_match_all($pattern,$search['searchwords'],$matches,PREG_OFFSET_CAPTURE) != 0) {
          $pageResults['searchwords'] = $matches[0];
          $priority += 20;
          $priority *= count($matches[0]);
        }

        // -> PAGE DATE start
        if(preg_match_all($pattern,$search['date']['start'],$matches,PREG_OFFSET_CAPTURE) != 0) {
          $pageResults['date']['start'] = $matches[0];
          $priority += 15;
          $priority *= count($matches[0]);
        }
        // -> PAGE DATE end
        if(preg_match_all($pattern,$search['date']['end'],$matches,PREG_OFFSET_CAPTURE) != 0) {
          $pageResults['date']['end'] = $matches[0];
          $priority += 15;
          $priority *= count($matches[0]);
        }

        // ->> GO THROUGH every LANGUAGE and SEARCH
        if(is_array($languages)) {
          foreach ($languages as $langCode) {

            // LOCALIZATION
            $search['categoryName'] = GeneralFunctions::getLocalized($this->categoryConfig[$pageContent['category']],'name',$langCode);
            $search['title']        = strip_tags(GeneralFunctions::getLocalized($pageContent,'title',$langCode));
            $search['description']  = GeneralFunctions::getLocalized($pageContent,'description',$langCode);
            $search['content']      = strip_tags(GeneralFunctions::getLocalized($pageContent,'content',$langCode));
            $search['tags']         = GeneralFunctions::getLocalized($pageContent,'tags',$langCode);


            // -> TAGS
            if(preg_match_all($pattern,$search['tags'],$matches,PREG_OFFSET_CAPTURE) != 0) {
              $pageResults['tags'][$langCode] = $matches[0];
              $priority += 20;
              $priority *= count($matches[0]);
            }

            // -> CATEGORY
            if(preg_match_all($pattern,$search['categoryName'],$matches,PREG_OFFSET_CAPTURE) != 0) {
              $pageResults['category'][$langCode] = $matches[0];
              $priority += 10;
              $priority *= count($matches[0]);
            }

            // -> TITLE
            if(preg_match_all($pattern,$search['title'],$matches,PREG_OFFSET_CAPTURE) != 0) {
              $pageResults['title'][$langCode] = $matches[0];
              $priority += 12;
              $priority *= count($matches[0]);
            }

            // -> DESCRIPTION
            if(preg_match_all($pattern,$search['description'],$matches,PREG_OFFSET_CAPTURE) != 0) {

              $pageResults['description'][$langCode] = $matches[0];
              $priority += 9;
              $priority *= count($matches[0]);
            }

            // -> WORDS
            if(preg_match_all($pattern,$search['content'],$matches,PREG_OFFSET_CAPTURE) != 0) {
              $pageResults['content'][$langCode] = $matches[0];
              $priority += 7;
              $priority *= count($matches[0]);
            }
          }
        }
      }

      // -> set results
      if($pageResults) {
        $pageResults['pageId'] = $pageContent['id'];
        $pageResults['categoryId'] = $pageContent['category'];
        $pageResults['priority'] = $priority;
        $results[] = $pageResults;
      }
    }

    // sort the searchresults by priority
    if($results)
      usort($results,'sortByPriority');

    return $results;
  }

 /**
  * <b>Name</b> createResultsArray()<br>
  *
  * Create an array with the page title and content, with marked findings, ready to display in a HTML page.
  *
  *
  * Example of the returned array
  * {@example searchResults.array.example.php}
  *
  * @param array $results an array with the search results created by the {@link searchPages()} method.
  *
  * @uses Search::markFindingInData             to mark the findings inside a serialized data string
  * @uses Search::markFindingInText             to mark the findings inside the text
  * @uses GeneralFunctions::readPage()          to read the page for displaying the title and content
  *
  * @return array an array with the results ready to display in an HTML page
  *
  * @access protected
  * @version 1.0
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.0 initial release
  *
  */
  protected function createResultsArray($results) {

    // var
    $extractLength = 50;
    $return = array();

    // return nothing when nothing was found
    if($results === false)
      return array();

    // GO THROUGH RESULTS and mark them in the texts
    foreach($results as $result) {

      $page = GeneralFunctions::readPage($result['pageId'],$result['categoryId']);
      $pageStats = StatisticFunctions::readPageStatistics($result['pageId']);

      // var
      $id = false;
      $date = false;
      $category = false;
      $title = false;
      $searchwords = false;
      $tags = false;
      $description = false;
      $content = false;

      // ->> GET LANGUAGE ot SEARCH
      // -> get ALL LANGUAGES
      if($this->searchAllLanguages) {
        $languages = array_keys($page['localized']);

      // -> get specified LANGUAGE
      } else {
        $languages = (array_key_exists($this->language, $page['localized'])) ? $this->language : $this->websiteConfig['multiLanguageWebsite']['mainLanguage'];
      }


      // MARK ID
      if(isset($result['id']))
        $id = $this->markFindingInText($page['id'],$result['id']);

      // ->> MARK the SEARCHWORDS
      if(isset($result['searchwords']))
        $searchwords = $this->markFindingInDataString($pageStats['searchWords'],$result['searchwords']);

      // ->> GO THROUGH every LANGUAGE and MARK the FINDINGS
      foreach ($languages as $langCode) {

        // LOCALIZATION
        $page['categoryName'] = GeneralFunctions::getLocalized($this->categoryConfig[$page['category']],'name',$langCode);
        $page['title']        = strip_tags(GeneralFunctions::getLocalized($page,'title',$langCode));
        $page['description']  = GeneralFunctions::getLocalized($page,'description',$langCode);
        $page['content']      = strip_tags(GeneralFunctions::getLocalized($page,'content',$langCode));
        $page['tags']         = GeneralFunctions::getLocalized($page,'tags',$langCode);


        // GENERATE TITLE
        if(isset($result['date']['start']) ||
           isset($result['date']['end']) ||
           isset($result['title'][$langCode])) {

          // MARK DATE
          if(isset($result['date']['start']) || isset($result['date']['end'])) {
            $date = '';
            // -> add date start
            if(!empty($page['pageDate']['start'])) {
              $date .= $this->markFindingInText(GeneralFunctions::formatDate($page['pageDate']['start']),$result['date']['start']);
              if(!empty($page['pageDate']['end']))
                $date .= ' - ';
            }
            // -> add date end
            if(!empty($page['pageDate']['end']))
              $date .= $this->markFindingInText(GeneralFunctions::formatDate($page['pageDate']['end']),$result['date']['end']);
            $date .= ' | ';
          }

          // ->> PREPARE the TITLE
          $rawTitle = $this->markFindingInText(strip_tags($page['title']),$result['title'][$langCode]);

          $title .= ($title) ? '<br>' : '';
          $title .= ($this->searchAllLanguages && count($result['title']) > 1) ? $langCode.' &rArr; ': '';
          $title .= $date.$rawTitle;

          unset($date);
        }

        // ->> MARK the CATEGORY NAME
        if($this->searchInCategoryNames && isset($result['category'][$langCode])) {
          $category .= ($category) ? '<br>' : '';
          $category .= ($this->searchAllLanguages && count($result['category']) > 1) ? $langCode.' &rArr; ': '';
          $category .= $this->markFindingInText($page['categoryName'],$result['category'][$langCode]);
       }

        // ->> MARK the TAGS
        if(isset($result['tags'][$langCode])) {
          $tags .= ($tags) ? '<br>' : '';
          $tags .= ($this->searchAllLanguages && count($result['tags']) > 1) ? $langCode.' &rArr; ': '';
          $tags .= $this->markFindingInText($page['tags'],$result['tags'][$langCode],$extractLength);
       }
        // ->> MARK the DESCRIPTION
        if(isset($result['description'][$langCode])) {
          $description .= ($description) ? '<br>' : '';
          $description .= ($this->searchAllLanguages && count($result['description']) > 1) ? $langCode.' &rArr; ': '';
          $description = $this->markFindingInText($page['description'],$result['description'][$langCode],$extractLength);
        }
        // ->> MARK the CONTENT
        if(isset($result['content'][$langCode])) {
          $content .= ($content) ? '<br>' : '';
          $content .= ($this->searchAllLanguages && count($result['content']) > 1) ? $langCode.' &rArr; ': '';
          $content .= $this->markFindingInText(strip_tags($page['content']),$result['content'][$langCode],$extractLength);
        }

      }

      // GENERATE RETURN
      $createReturn['page']['id'] = $result['pageId'];
      $createReturn['page']['cateory'] = $result['categoryId'];
      $createReturn['id'] = $id;
      $createReturn['title'] = $title;
      $createReturn['category'] = $category;
      $createReturn['searchwords'] = $searchwords;
      $createReturn['tags'] = $tags;
      $createReturn['description'] = $description;
      $createReturn['content'] = $content;

      $return[] = $createReturn;
    }
    //return $results;
    return $return;

  }

 /**
  * <b>Name</b> markFindingInText()<br>
  *
  * Marks the results from <var>preg_match_all()</var> in the given texts.
  *
  * @param string     $text         the text where the result was found to mark the rsult in it
  * @param array      $results      an array with the search results in the format: array[0][0] = 'found text', array[0][1] = 25, array[1][0] = 'other text', ...
  * @param false@int  $extractMax   the maximal number of letters before and after the finding, if FALSE it returns the whole text
  *
  * @uses $limitResults                          to limit the displayed results
  *
  * @return string the text with marked results
  *
  * @access private
  * @version 1.0
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.0 initial release
  *
  */
  private function markFindingInText($text,$results,$extractMax = false) {

    // var
    $separator = ' ... ';
    $countResults = 1;
    $text = (string)$text;

    // ->> show the parts with the searchwords marked
    if(is_array($results)) {

      // var
      $lastPosition = 0;

      foreach($results as $key => $match) {

        // var
        $before = null;
        $after = null;
        $cutStart = false;
        $cutEnd = false;
        $cutBetween = false;

        if($extractMax) {
          // -> CHECK if the FIRST WORD - $extractMax is after the beginning
          // if then cut the beginning
          if($key == 0 &&
             $extractMax < $match[1]) {
            $lastPosition = $match[1] - $extractMax;
            $before = $separator;
            $cutStart = true;
          }

          // -> CHECK if the LAST WORD + $extractMax is after the end
          // if then cut the rest of the text
          if((count($results) == ($key + 1) || ($this->limitResults !== false && $countResults == $this->limitResults)) &&
             ($match[1] + strlen($match[0]) + $extractMax) < strlen($text)) {
            $untilPosition = $extractMax;
            $after = $separator;
            $cutEnd = true;
          }

          // -> CHECK between the words is a space more than $extractMax
          if($key != 0 &&
             ($match[1] - $lastPosition) > $extractMax) {
            $cutBetween = true;
          }
        }

        // echo '2->'.$untilPosition.'-> "'.substr($text,$untilPosition,5).'"<br>';
        if(strpos($text,$match[0]) !== false) {
          // go until a whitespace before
          while($cutStart && substr($text,$lastPosition,1) != ' ' && $lastPosition > 0) {
            $lastPosition--;
          }
          if($lastPosition == 0) $before = false; // remove the ... before if its start at 0

          $markedText .= ($cutBetween)
            ? substr($text,$lastPosition,$extractMax).$separator.substr($text,$match[1] - $extractMax,$extractMax)
            : $before.substr($text,$lastPosition,$match[1] - $lastPosition);
          //$markedText .= $before.substr($text,$lastPosition,$match[1] - $lastPosition);
          $markedText .= $this->markStartTag.$match[0].$this->markEndTag;

          // save last position
          $lastPosition = $match[1] + strlen($match[0]);
        }

        // stop the results when $this->limitResults is set
        if($this->limitResults !== false && $countResults == $this->limitResults)
          break;
        else
          $countResults++;
      }

      // go until a whitespace after
      while($cutEnd && substr($text,($lastPosition + $untilPosition),1) != ' ' && ($lastPosition + $untilPosition) < strlen($text)) {
        $untilPosition++;
      }

      // add the last part of the string
      $markedText .= ($cutEnd)
        ? substr($text,$lastPosition,$untilPosition).$after
        : substr($text,$lastPosition);

      return $markedText;
    } else return $text;
  }

 /**
  * <b>Name</b> markFindingInDataString()<br>
  *
  * Marks the results from <var>preg_match_all()</var> in a given serialized dataString.
  *
  * Example dataString:
  * {@example dataString.array.example.php}
  *
  * @param string $dataString a dataString
  * @param array  $results an array with the search results in the format: array[0][0] = 'found text', array[0][1] = 25, array[1][0] = 'other text', ...
  *
  *
  * @return string|false the elements of the dataString with marked results, or FALSE
  *
  * @access private
  * @version 1.0
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.0 initial release
  *
  */
  private function markFindingInDataString($dataString,$results) {

    // var
    $return = false;

    if(($dataString = unserialize($dataString)) !== false) {
      if(is_array($results)) {
        foreach($dataString as $data) {
          foreach($results as $match) {
            if(strpos($data['data'],$match[0]) !== false) {
              $return .= str_replace($match[0],$this->markStartTag.$match[0].$this->markEndTag,$data['data']).' ';
            }
          }
        }
        return trim($return);
      } else
        return $return;
    } else
      return $return;
  }
}
?>