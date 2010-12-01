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
 
 /* ->> GENERAL <<- */
 
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
  * The constructor of the class, sets all basic properties.
  * 
  * @uses feinduraBase::__construct()		          the constructor of the parent class to load all necessary properties
  * @uses feinduraBase::setCurrentCategoryId()  to set the fetched category ID from the $_GET variable to the {@link $category} property
  * @uses feinduraBase::setCurrentPageId()      to set the fetched page ID from the $_GET variable to the {@link $page} property
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
    $searchwords = stripslashes($searchwords);
    
    // -> start search
    return $this->searchPages($searchwords, $category);
    
    
    
  }
  
 /**
  * <b>Name</b> searchPages()<br />
  * 
  * Goes through pages and search for a matching of the searchwords.
  * 
  * 
  * @param string          $searchwords  one or more searchwords to fing
  * @param bool|int|array  $category     the ID or an array with IDs of the category(ies) in which should be searched, if TRUE it searches in all categories, if FALSE it searches only in the non category
  * 
  * @uses $checkPages                   if TRUE it searches only in pages which are public  
  * @uses generalFunctions::loadPages() to load the pages
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
  protected function searchPages($searchwords, $category) {
    
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
    
    return $checkPages;
    
    // ->> goes through all pages and search for the keywords
    foreach($checkPages as $pageContent)  {
      
    	// set the priority of the results to 0
    	$priority = 0;
            
      // bereitet $pageContent[content] vor
      $pageContent['content'] = strip_tags($pageContent['content']);
      
      // -> check for public only in the frontend search
      //if($categoryConfig[$pageContent['category']]['public'] && $pageContent['public']) {
       	$inhalt = strtolower($pageContent['content']);
       	$id = strtolower($pageContent['id']);
        $titel = strtolower($pageContent['title']);
        $categoryName = strtolower($categoryConfig[$pageContent['category']]['name']);
        $beforeDate = strtolower($pageContent['pagedate']['before']);
        $date = statisticFunctions::formatDate($pageContent['pagedate']['date']);
        $afterDate = strtolower($pageContent['pagedate']['after']);
      /*} else {
       	$inhalt = '';
       	$titel = '';
       	$categoryName = '';
    	  $date = '';
       }*/
     
      // teile $searchWord in einzelne worte auf
      $searchWord = generalFunctions::cleanSpecialChars($searchWord);
      if(substr($searchWord,-1) == ' ') // deletes space on the ende
        $searchWord = substr($searchWord,0,-1);
      if(substr($searchWord,0,1) == ' ') // deletes space on the beginning
        $searchWord = substr($searchWord,1);
      $searchWord = strtolower($searchWord);
      $searchwords = explode(" ", $searchWord);
          	        	              
      // ->> SEARCH ALL WORDS
      // *********************
			  
		  // für jedes wort wir eine einzelne suchausgabe erstellt und mit .. getrennt
			$zaehl = 0;
			$if_find = false;
			$words = 0;

		  foreach($searchwords as $searchword) {

				// -> SEARCH TITLE
				if(strpos($titel, $searchword) !== false) { //wenn im titel gefunden wurde
					$findtext = false;
					$priority = $priority + 8;
					$wortanzahl = $langFile['search_results_text1']; //angabe findings im titel							
					$if_find = true;
				// -> SEARCH DATE or CATEGORY
				} elseif(strpos($beforeDate, $searchword) !== false ||
	               strpos($afterDate, $searchword) !== false ||
                 strpos($date, statisticFunctions::validateDateFormat($searchword)) !== false ||
                 strpos($categoryName, $searchword) !== false) { //wenn im datum gefunden wurde
					$findtext = false;
					$priority = $priority + 3;
					$wortanzahl = $langFile['search_results_text2']; //angabe findings im datum oder gruppe
					$if_find = true;
				// -> SEARCH ID
			  } elseif($id == $searchword) { //wenn in der seiten id gefunden
					$priority = $priority + 10;
					$findtext = false;
					$stelle = 0;
					$wortanzahl = $langFile['search_results_text8']; //angabe findings in id
					$if_find = true;
				// -> SEARCH CONTENT
				} elseif(strpos($inhalt, $searchword) !== false) { //wenn im inhalt gefunden wurde
					$findtext = true;
					$priority++;
																			
					$wortlaenge[$zaehl] = strlen($searchword);							
					$stellen[$zaehl] = strpos($inhalt, $searchword);
					$ausgabenlaenge = 40; //ausgabenlänge vor und hinter einzelnen wörtern
					$ausgabenlaengereset = $ausgabenlaenge;
					$words++;
					$wortanzahl = $langFile['search_results_text3'].' '.$words; //angabe über wortanzahl bei mehreren wörtern
					$if_find = true;
				}
				
				if($if_find) {
				  
				
        	// -> CREATE FINDINGS ARRAY
          $findings[$zaehl] = array("stelle" => $stellen[$zaehl], "wortlaenge" => $wortlaenge[$zaehl], "findtext" => $findtext);
          $zaehl++;
			    unset($findtext);
        }
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
  
   /**
  * <b>Name</b> displayResults()<br />
  * 
  * Starts the search.
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
  protected function displayResults($searchwords) {   
    
  }
 
}
?>