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
 * @package [backend]
 */

/**
* The class for searching in feindura pages.
* 
* 
* @author Fabian Vogelsteller <fabian@feindura.org>
* @copyright Fabian Vogelsteller
* @license http://www.gnu.org/licenses GNU General Public License version 3
* 
* @package [backend]
* 
* @version 1.0
* <br />
* <b>ChangeLog</b><br />
*    - 1.0 initial release
* 
*/
class search {
  
 /* ---------------------------------------------------------------------------------------------------------------------------- */
 /* *** PROPERTIES */
 /* **************************************************************************************************************************** */
 
 // PROTECTED
 // *********
 
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
  * @see search::__construct()
  * 
  */
  protected $categoryConfig;
  
  // PUBLIC
  // *********
  
  /**
  * If its an number it limits the found results to this number, so the search results are still demonstrable, when a lot of words were found.
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
  public $checkIfPublic = true;
  
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
  public $markStartTag = '<b>';
  
  /**
  * The end-tag to mark the finding in a text.
  * 
  * @var string
  * @access public
  */
  public $markEndTag = '</b>';

  
 /* ---------------------------------------------------------------------------------------------------------------------------- */
 /* *** CONSTRUCTOR *** */
 /* **************************************************************************************************************************** */
  
 /**
  * <b>Type</b> constructor<br />
  * 
  * The constructor of the class, sets the {@link $categoryConfig}.
  * 
  * <b>Used Global Variables</b><br>
  *    - <var>$categoryConfig</var> the categories-settings config (included in the {@link general.include.php})
  * 
  * @return void
  * 
  * @see feinduraBase::__construct()
  * 
  * @access public
  * @version 1.0
  * <br />
  * <b>ChangeLog</b><br />
  *    - 1.0 initial release
  * 
  */
  public function __construct() {    
    $this->categoryConfig = (isset($GLOBALS["categoryConfig"])) ? $GLOBALS["categoryConfig"] : $GLOBALS["feindura_categoryConfig"];    
  } 
  
  // ****************************************************************************************************************
  // METHODs -------------------------------------------------------------------------------------------------
  // ****************************************************************************************************************
  
 /**
  * <b>Name</b> find()<br />
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
  * <br />
  * <b>ChangeLog</b><br />
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
  * <b>Name</b> searchPages()<br />
  * 
  * Goes through pages and search for a matching of the searchwords.
  * Return the results sorted by priority.
  * 
  * 
  * @param string          $searchwords  one or more searchwords to fing
  * @param bool|int|array  $category     the ID or an array with IDs of the category(ies) in which should be searched, if TRUE it searches in all categories, if FALSE it searches only in the non category
  * 
  * @uses $checkPages                   if TRUE it searches only in pages which are public
  * @uses sortByPriority()              to sort the page array
  * @uses generalFunctions::loadPages() to load the pages
  * @uses xssFilter::text()             to filter the searchwords
  * 
  * @return array|false array with matching searchwords or FALSE
  * 
  * @access protected
  * @version 1.0
  * <br />
  * <b>ChangeLog</b><br />
  *    - 1.0 initial release
  * 
  */
  protected function searchPages($searchwords, $category) {
    
    // var
    $results = false;
    
    // -> check if the categories are public
    if($this->checkIfPublic)
      $category = generalFunctions::isPublicCategory($category);
      
    // -> load the pages
    $pages = generalFunctions::loadPages($category,true);
    
    // -> check if the pages are public
    if($this->checkIfPublic) {
      $checkPages = array();
      foreach($pages as $page) {
        if($page['public'] == true)
          $checkPages[] = $page;
      }
    } else
      $checkPages = $pages;
    
    // ->> goes through all pages and search for the keywords
    foreach($checkPages as $pageContent)  {
      
      // var
      $changeChars = array(' ','.','-','/');
      $pageResults = false;
      $text = false;
      
    	// set the priority of the results to 0
    	$priority = 0;
      
      // generate search pattern
      $searchwords = str_replace($changeChars,'|',$searchwords);
      $searchwords = trim($searchwords,'|');
      $searchwords = xssFilter::text($searchwords);
      $pattern = ($searchwords != '') ? '#'.$searchwords.'#i' : '#a^#';

      // prepare the contents to search through
     	$search['id'] = $pageContent['id'];      
      $search['beforeDate'] = $pageContent['pageDate']['before'];
      $search['date'] = statisticFunctions::formatDate($pageContent['pageDate']['date']);
      $search['afterDate'] = $pageContent['pageDate']['after'];
      $search['title'] = strip_tags($pageContent['title']);
      $search['tags'] = $pageContent['tags'];
      $search['description'] = generalFunctions::decodeToPlainText($pageContent['description']);
      $search['categoryName'] = $this->categoryConfig[$pageContent['category']]['name'];
      $search['content'] = strip_tags(generalFunctions::decodeToPlainText($pageContent['content']));
      
      // create a string of the page searchwords
      $search['searchwords'] = unserialize($pageContent['log_searchWords']);
      $pageSearchwords = '';
      foreach($search['searchwords'] as $pageSearchword){
        $pageSearchwords .= '####'.$pageSearchword['data'];
      }
      $search['searchwords'] = trim($pageSearchwords,'####');
      
      // ->> SEARCH PROCESS      
			
      // -> 1. ID
      if(is_numeric($searchwords) &&
         preg_match_all($pattern,$search['id'],$matches,PREG_OFFSET_CAPTURE) != 0) {
        $pageResults['id'] = $matches[0];
        $priority += 999;
      
      // -> IF NO MATCH in ID, SEARCH in OTHER PLACES
      } else {
        // -> DATE
        if(preg_match_all($pattern,$search['beforeDate'],$matches,PREG_OFFSET_CAPTURE) != 0) {
          $pageResults['beforeDate'] = $matches[0];
          $priority += 15;
          $priority *= count($matches[0]);
        }
        if(preg_match_all($pattern,$search['date'],$matches,PREG_OFFSET_CAPTURE) != 0) {
          $pageResults['date'] = $matches[0];
          $priority += 15;
          $priority *= count($matches[0]);
        }
        if(preg_match_all($pattern,$search['afterDate'],$matches,PREG_OFFSET_CAPTURE) != 0) {
          $pageResults['afterDate'] = $matches[0];
          $priority += 15;
          $priority *= count($matches[0]);
        }
        // -> SEARCHWORDS
        if(preg_match_all($pattern,$search['searchwords'],$matches,PREG_OFFSET_CAPTURE) != 0) {
          $pageResults['searchwords'] = $matches[0];
          $priority += 20;
          $priority *= count($matches[0]);       
        }
        // -> TAGS
        if(preg_match_all($pattern,$search['tags'],$matches,PREG_OFFSET_CAPTURE) != 0) {
          $pageResults['tags'] = $matches[0];
          $priority += 20;
          $priority *= count($matches[0]);          
        }
        // -> CATEGORY
        if(preg_match_all($pattern,$search['categoryName'],$matches,PREG_OFFSET_CAPTURE) != 0) {
          $pageResults['category'] = $matches[0];
          $priority += 10;
          $priority *= count($matches[0]);          
        }
        // -> TITLE
        if(preg_match_all($pattern,$search['title'],$matches,PREG_OFFSET_CAPTURE) != 0) {
          $pageResults['title'] = $matches[0];
          $priority += 12;
          $priority *= count($matches[0]);          
        }
        // -> DESCRIPTION
        if(preg_match_all($pattern,$search['description'],$matches,PREG_OFFSET_CAPTURE) != 0) {

          $pageResults['description'] = $matches[0];
          $priority += 9;
          $priority *= count($matches[0]);          
        }
        // -> WORDS
        if(preg_match_all($pattern,$search['content'],$matches,PREG_OFFSET_CAPTURE) != 0) {
          $pageResults['content'] = $matches[0];
          $priority += 7;
          $priority *= count($matches[0]);          
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
  * <b>Name</b> createResultsArray()<br />
  * 
  * Create an array with the page title and content, with marked findings, ready to display in a HTML page.
  * 
  * 
  * Example of the returned array
  * {@example searchResults.array.example.php}
  * 
  * @param array $results an array with the search results created by the {@link searchPages()} method.
  * 
  * @uses $searchInCategoryNames                to set if it will also search in the category names for matches  
  * @uses generalFunctions::readPage()          to read the page for displaying the title and content
  * @uses generalFunctions::decodeToPlainText() to decode the string to plain text, to find the right position
  * 
  * @return array an array with the results ready to display in an HTML page
  * 
  * @access protected
  * @version 1.0
  * <br />
  * <b>ChangeLog</b><br />
  *    - 1.0 initial release
  * 
  */
  protected function createResultsArray($results) {
    
    // var
    $extractLength = 30;
    $return = array();
    
    // return nothing when nothing was found
    if($results === false)
      return array();    
    
    // GO THROUGH RESULTS and mark them in the texts
    foreach($results as $result) {
      
      $page = generalFunctions::readPage($result['pageId'],$result['categoryId']);
    
      // var
      $id = false;
      $date = false;
      $category = false;
      $title = false;
      $searchwords = false;
      $tags = false;
      $description = false;
      $content = false;
      
      // SET ID
      if(isset($result['id']))
      $id = $result['id'];
      
      // GENERATE TITLE
      if(isset($result['beforeDate']) ||
         isset($result['date']) ||
         isset($result['afterDate']) ||
         isset($result['title'])) {
      
        // PREPARE DATE
        if(isset($result['beforeDate']) || isset($result['date']) || isset($result['afterDate'])) {
          // -> add before date
          $date .= $this->markFindingInText($page['pageDate']['before'],$result['beforeDate']).' ';       
          // -> add date
          $date .= $this->markFindingInText(statisticFunctions::formatDate($page['pageDate']['date']),$result['date']);        
          // -> add after date
          $date .= ' '.$this->markFindingInText($page['pageDate']['after'],$result['afterDate']);
          $date .= ' - ';
        }
      
        // ->> PREPARE the TITLE
        $title = $this->markFindingInText(strip_tags($page['title']),$result['title']);
        
        $title = $date.$title;      
      }
     
      // ->> PREPARE the CATEGORY NAME
      if($this->searchInCategoryNames && isset($result['category']))
        $category = $this->markFindingInText($this->categoryConfig[$page['category']]['name'],$result['category']);
     
      // ->> PREPARE the SEARCHWORDS
      if(isset($result['searchwords']))
        $searchwords .= $this->markFindingInDataString($page['log_searchWords'],$result['searchwords']);
      
      // ->> PREPARE the TAGS
      if(isset($result['tags']))
        $tags .= $this->markFindingInText($page['tags'],$result['tags'],$extractLength);
     
      // ->> PREPARE the DESCRIPTION
      if(isset($result['description']))
        $description = $this->markFindingInText($page['description'],$result['description'],$extractLength);
      
      // ->> PREPARE the CONTENT
      if(isset($result['content']))
        $content = $this->markFindingInText(strip_tags($page['content']),$result['content'],$extractLength);
     
      // generate return
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
  * <b>Name</b> markFindingInText()<br />
  * 
  * Marks the results from <var>preg_match_all()</var> in the given texts.
  * 
  * @param string     $text         the text where the result was found to mark the rsult in it
  * @param array      $results      an array with the search results in the format: array[0][0] = 'found text', array[0][1] = 25, array[1][0] = 'other text', ...
  * @param false@int  $extractMax   the maximal number of letters before and after the finding, if FALSE it returns the whole text
  * 
  * @uses $limitResults                          to limit the displayed results
  * @uses generalFunctions::decodeToPlainText()  to decode the string to plain text, to shorten to the right letter number
  * @uses generalFunctions::encodePlainText()    to encode the plain text back to a string with htmlentities
  * 
  * @return string the text with marked results
  * 
  * @access private
  * @version 1.0
  * <br />
  * <b>ChangeLog</b><br />
  *    - 1.0 initial release
  * 
  */
  private function markFindingInText($text,$results,$extractMax = false) {
    
    // var
    $separator = ' ... ';
    $countResults = 1;
    
    // ->> show the parts with the searchwords marked
    if(is_array($results)) {
      
      // -> decode html entities
      $text = generalFunctions::decodeToPlainText($text);
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
      
      // -> encode html entities
      $markedText = generalFunctions::encodePlainText($markedText);
      return $markedText;
    } else return $text;
  }
  
 /**
  * <b>Name</b> markFindingInDataString()<br />
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
  * @see statisticFunctions::addDataToDataString()
  * 
  * @access private
  * @version 1.0
  * <br />
  * <b>ChangeLog</b><br />
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