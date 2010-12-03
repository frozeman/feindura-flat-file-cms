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
  * Contains the categories-settings config set in the CMS backend
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
  * If TRUE it only search in pages and categories which are public.
  * 
  * @var bool
  * @access public
  */
  public $checkIfPublic = true;  

  
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
    
    // clean up the searchWord
    //$searchwords = stripslashes($searchwords);
    
    // -> start search
    return $this->searchPages($searchwords, $category);
    
    
    
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
  * @uses generalFunctions::loadPages() to load the pages
  * @uses sortByPriority                to sort the page array  
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
      //$search['beforeDate'] = $pageContent['pagedate']['before'];
      $search['date'] = statisticFunctions::formatDate($pageContent['pagedate']['date']);
      //$search['afterDate'] = $pageContent['pagedate']['after'];
      $search['searchwords'] = $pageContent['log_searchwords'];
      $search['title'] = $pageContent['title'];
      $search['description'] = $pageContent['description'];
      $search['categoryName'] = $this->categoryConfig[$pageContent['category']]['name'];
      $search['content'] = strip_tags($pageContent['content']);
            
      // ->> SEARCH PROCESS      
			
      // -> 1. ID
      if(is_numeric($searchwords) &&
         preg_match_all($pattern,$search['id'],$matches,PREG_OFFSET_CAPTURE) != 0) {        
        $text .= $langFile['SEARCH_TEXT_MATCH_ID'];
        $pageResults['id'] = $matches[0];
        $priority += 100;
      
      // -> IF NO MATCH in ID, SEARCH in OTHER PLACES
      } else {
        // -> 2. DATE
        if(preg_match_all($pattern,$search['date'],$matches,PREG_OFFSET_CAPTURE) != 0) {
          $text .= $langFile['SEARCH_TEXT_MATCH_DATE'];
          $pageResults['date'] = $matches[0];
          $priority += 15;
          $priority *= count($matches[0]);       
        }
        // -> 2. SEARCHWORDS
        if(preg_match_all($pattern,$search['searchwords'],$matches,PREG_OFFSET_CAPTURE) != 0) {
          $text .= $langFile['SEARCH_TEXT_MATCH_WORDS'];
          $pageResults['searchwords'] = $matches[0];
          $priority += 15;
          $priority *= count($matches[0]);       
        }
        // -> 2. CATEGORY
        if(preg_match_all($pattern,$search['categoryName'],$matches,PREG_OFFSET_CAPTURE) != 0) {
          $text .= $langFile['SEARCH_TEXT_MATCH_CATEGORY'];
          $pageResults['category'] = $matches[0];
          $priority += 10;
          $priority *= count($matches[0]);          
        }
        // -> 2. TITLE
        if(preg_match_all($pattern,$search['title'],$matches,PREG_OFFSET_CAPTURE) != 0) {
          $text .= $langFile['SEARCH_TEXT_MATCH_TITLE'];
          $pageResults['title'] = $matches[0];
          $priority += 12;
          $priority *= count($matches[0]);          
        }
        // -> 2. DESCRIPTION
        if(preg_match_all($pattern,$search['description'],$matches,PREG_OFFSET_CAPTURE) != 0) {
          $text .= $langFile['SEARCH_TEXT_MATCH_WORDS'];
          $pageResults['description'] = $matches[0];
          $priority += 9;
          $priority *= count($matches[0]);          
        }
        // -> 2. WORDS
        if(preg_match_all($pattern,$search['content'],$matches,PREG_OFFSET_CAPTURE) != 0) {
          $text .= $langFile['SEARCH_TEXT_MATCH_WORDS'];
          $pageResults['content'] = $matches[0];
          $priority += 7;
          $priority *= count($matches[0]);          
        }
      }
      
      // -> set results
      if($pageResults) {
        $pageResults['pageId'] = $pageContent['id'];
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
  * <b>Name</b> displayResults()<br />
  * 
  * Create an array with 
  * 
  * 
  * @param string $searchwords one or more searchwords to fing
  * 
  * @uses $startPage
  * @uses generalFunctions::getPageCategory()        to get the category of the page
  * 
  * @return void
  * 
  * @access protected
  * @version 1.0
  * <br />
  * <b>ChangeLog</b><br />
  *    - 1.0 initial release
  * 
  */
  protected function displayResults($results) {
  
    
    
    	if($if_find) {
      	// -> CREATE FINDINGS ARRAY
        $findings[$zaehl] = array("stelle" => $stellen[$zaehl], "wortlaenge" => $wortlaenge[$zaehl], "findtext" => $findtext);
        $zaehl++;
		    unset($findtext);
      }

							   
			// ausgabe wenn was gefunden wurde
			if($if_find === true) {
			  array_multisort($findings,SORT_ASC, SORT_REGULAR);
			  
			  //var_dump($findings);			  
			  $count++;  //zählt die treffer
			 // AUSGABE anfang
			 $beginn_ausgabeblock = @ausgabeblock_start($count,$pageContent); 
			 $ausgabetext = $beginn_ausgabeblock; //schreibt beginn des ausgabeblocks
			 
			  unset($stelle);
			  for ($i = 0; $i < count($findings); $i++) {
				// überprüft ob das wort am anfang steht
				$lenge = $ausgabenlaenge;	 //länge vor dem gefunden wort		
				  if(($findings[$i]['stelle']-$lenge)>='0'){
				  $stellestart = $findings[$i]['stelle']-$lenge;
				  } else {
				  $stellestart = '0';
				  $lenge = $findings[$i]['stelle'];
				  }
				
				//echo '<br />i: '.$i.'<br />';
				//echo '<b>stelle</b>: '.$findings[$i]['stelle'].'<br />';
				//echo 'wortlange: '.$wortlaenge[$i].'<br />';
				//echo $i;
				//echo $ausgabenlaenge;
				
				if($findings[$i]['findtext'] === true) {	
				
					//überprüft ob das vorherige (davor) wort nah am jetzigen ist
					if(isset($findings[($i-1)]['stelle']) && ($findings[($i-1)]['stelle']+$findings[($i-1)]['wortlaenge']) >= ($findings[$i]['stelle']-$ausgabenlaenge)) {
						$auszug_v = '';
						$priority++;
						} else {
						$auszug_v = '..'.substr($pageContent['content'], $stellestart, $lenge);
						}
										
					// überprüft ob das nächste (dahinter) wort nah am jetzigen ist
					if(isset($findings[($i+1)]['stelle']) && ($findings[$i]['stelle']+$findings[$i]['wortlaenge']+$ausgabenlaenge) >= $findings[($i+1)]['stelle'] && $findings[($i+1)]['stelle']-($findings[$i]['stelle']+$findings[$i]['wortlaenge']) <= $ausgabenlaenge) {
						if(($findings[($i+1)]['stelle']-($findings[$i]['stelle']+$findings[$i]['wortlaenge'])) <= $ausgabenlaenge)
							$ausgabenlaenge = ($findings[($i+1)]['stelle']-($findings[$i]['stelle']+$findings[$i]['wortlaenge']));
						$auszug_h_point = '';
						$priority++;
						} else {
						$ausgabenlaenge = $ausgabenlaengereset;
						$auszug_h_point = '..';
						}
							
					$auszug_m = substr($pageContent['content'], $findings[$i]['stelle'], $findings[$i]['wortlaenge']);
					$auszug_h = substr($pageContent['content'], ($findings[$i]['stelle']+$findings[$i]['wortlaenge']), $ausgabenlaenge).$auszug_h_point;
					} elseif($i == 0) {
						// wenn nur im titel und datum gefunden wurde, zeige eine vorschau des inhalts
						$auszug_v = substr($pageContent['content'], 0, 90).'..';
					}
															
					// AUSGABE mitte
					$ausgabetext .= $auszug_v.'<b>'.$auszug_m.'</b>'.$auszug_h;
					
					$ausgabenlaenge = $ausgabenlaengereset;
					unset($auszug_v,$auszug_m,$auszug_h);
				}
				// AUSGABE ende
				$ende_ausgabeblock = @ausgabeblock_end();
				$ausgabetext .= $ende_ausgabeblock; //ausgabeblock ende
				// AUSGABE WIRD IN ARRAY GESPEICHERT
				$ausgabe[] = array('priority' => $priority, 'output' => $ausgabetext, 'words' => $wortanzahl);
				
				unset($findings,$stellen,$wortlaenge,$ausgabetext,$wortanzahl);
				$priority = 0; //setzt priorität wieder auf 0
			} //ende if_find=true
  }
 
}
?>