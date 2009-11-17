<?php
/*
    feindura - Flat File Content Management System
    Copyright (C) 2009 Fabian Vogelsteller [frozeman.de]

    This program is free software;
    you can redistribute it and/or modify it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 3 of the License, or (at your option) any later version.

    This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY;
    without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
    See the GNU General Public License for more details.

    You should have received a copy of the GNU General Public License along with this program;
    if not,see <http://www.gnu.org/licenses/>.
*/
// setup.php version 2.31 (BACKEND)


/* LANGUAGE-VARS

$langFile['search_h1'] = 'Seiten durchsuchen';
$langFile['search_results_h1'] = 'Suchergebnisse f&uuml;r';
$langFile['search_results_text1'] = '&Uuml;bereinstimmungen im Titel';
$langFile['search_results_text2'] = '&Uuml;bereinstimmungen im Datum oder der Kategorie';
$langFile['search_results_text3'] = '&Uuml;bereinstimmende W&ouml;rter:';
$langFile['search_results_text4'] = '&Uuml;bereinstimmenden Satz gefunden';
$langFile['search_results_text5'] = '&Uuml;bereinstimmungen im Datum oder der Kategorie';
$langFile['search_results_text6'] = '&Uuml;bereinstimmenden Satz gefunden';
$langFile['search_results_text7'] = '&Uuml;bereinstimmungen im Text';
$langFile['search_results_count'] = 'Treffer';
$langFile['search_results_time_part1'] = 'in'; // 12 Treffer in 0.32 Sekunden
$langFile['search_results_time_part2'] = 'Sekunden';

*/

// LADEZEIT MESSEN
$time_start = $statisticFunctions->getMicroTime(); //Zeitbeginn am Seitenanfang

// such variablen und php version -----------------------
include(dirname(__FILE__)."/../backend.include.php");


// clean up the searchWord
$searchWord = stripslashes($_POST['searchWord']);
$searchWord = htmlentities($searchWord,ENT_NOQUOTES, 'UTF-8');

// show the form
echo '<form action="?site='.$_GET['site'].'" method="post" enctype="multipart/form-data" accept-charset="UTF-8">';

echo '<div class="block">
      <h1>'.$langFile['search_h1'].'</h1>
        <div class="content">
          <input name="searchWord" type="text" size="50" value="'.$searchWord.'" style="float:left; margin-top: 12px; margin-right:10px;" />
          <input type="submit" value="" class="button search" />
        </div>
        <div class="bottom"></div>
      </div>
      </form>';


$count = '0';

// -------------------------------------------------------------------------------------------
// STARTS SEARCH
if(!empty($_POST['searchWord'])) {

echo '<div class="block"><h1>'.$langFile['search_results_h1'].' &quot;'.$searchWord.'&quot;</h1><div class="bottom"></div></div>';

// --- LAYOUT DER AUSGABE
function ausgabeblock_start($count,$pageContent) {
  global $categories;
  
  return '<div class="content"><h3><a href="?category='.$pageContent['category'].'&amp;page='.$pageContent['id'].'">'.$pageContent['title'].'</a> <span>&lArr; '.$categories['id_'.$pageContent['category']]['name'].'</span></h3><p>';
}
function ausgabeblock_end() {
  return '</p></div>
  <div class="bottom"></div>';
}
// --- ENDE LAYOUT DER AUSGABE


array_unshift($categories,array('id' => 0,'name' => $langFile['categories_nocategories_name']));
$allPages = $generalFunctions->loadPages($categories);

//print_r($allPages);

  // schleife die die einzelnen gruppen öffnet
  foreach($allPages as $pageContent)  {
         
    	//setzt die priotität der suchergebnisse am anfang auf 0
    	$priority = 0;
            
      // bereitet $pageContent[content] vor
      $pageContent['content'] = strip_tags($pageContent['content']);
      if($pageContent['public']) {
       	$inhalt = strtolower($pageContent['content']);
        $titel = strtolower($pageContent['title']);
        $categoryName = strtolower($categories['id_'.$pageContent['category']]['name']);
        $datum = strtolower($pageContent['date']);
     	} else {
       	$inhalt = '';
       	$titel = '';
       	$categoryName = '';
    	  $datum = '';
       }
     
      // teile $searchWord in einzelne worte auf
      $searchWord = str_replace( array('/','"',"'"), ' ', $searchWord ) ;
      $searchWord = strtolower($searchWord);
      $searchwords = explode(" ", $searchWord);
          	        	
          // EINZELSUCHWORT
		  if(count($searchwords) == 1) {
				// DURCHSUCHT den inhalt,tiel und datum von der seite /_gruppe/seite.php
				$wortlaenge = strlen($searchwords[0]);
				if(strpos($inhalt, $searchwords[0]) !== false) { //wenn im inhalt gefunden wurde
  					$priority++;
  					$findtext = true;
  					$stelle = strpos($inhalt, $searchwords[0]);
  					$wortanzahl = $langFile['search_results_text7']; //angabe findings im titel
				  } elseif($stelle = strpos($titel, $searchwords[0]) !== false) { //wenn im titel gefunden wurde
  					$priority = $priority + 8;
  					$findtext = false;
  					$stelle = 0;
  					$wortanzahl = $langFile['search_results_text1']; //angabe findings im titel
				  } elseif($stelle = strpos($datum, $searchwords[0]) !== false || $stelle = strpos($categoryName, $searchwords[0]) !== false) { //wenn im datum gefunden wurde
  					$priority = $priority + 3;
  					$findtext = false;
  					$stelle = 0;
  					$wortanzahl = $langFile['search_results_text5']; //angabe findings im datum oder gruppe
				  }  	           
								
				if($stelle!==false){     
					
				$lenge = '40'; //länge vor dem gefunden wort								
				  if(($stelle-$lenge)>='0'){
				  $stellestart = $stelle-$lenge;
				  } else {
				  $stellestart = '0';
				  $lenge = $stelle;
				  }
				
				if($findtext == true) {
				$auszug_v = '..'.substr($pageContent['content'], $stellestart, $lenge);
				$auszug_m = substr($pageContent['content'], $stelle, $wortlaenge);
				$auszug_h = substr($pageContent['content'], ($stelle+$wortlaenge), 90).'..';
				} else {
					// wenn nur im titel und datum gefunden wurde, zeige eine vorschau des inhalts
					$auszug_v = substr($pageContent['content'], 0, 90).'..';
				}
			
				  // ausgabe
				  $count++; 
				  
				  $beginn_ausgabeblock = @ausgabeblock_start($count,$pageContent);
				  $ende_ausgabeblock = @ausgabeblock_end();
				  
				  // AUSGABE einzelwort
				  $ausgabetext = $beginn_ausgabeblock.$auszug_v.'<b>'.$auszug_m.'</b>'.$auszug_h.$ende_ausgabeblock;
				  // AUSGABE WIRD IN ARRAY GESPEICHERT
				  $ausgabe[] = array('priority' => $priority, 'output' => $ausgabetext , 'words' => $wortanzahl);
				  
				  unset($ausgabetext,$stelle,$auszug_v,$auszug_m,$auszug_h,$findtext);
				  $priority = 0; //setzt priorität wieder auf 0
				  }
              
      // MEHRERE SUCHWORTE
			} else {
				// für jedes wort wir eine einzelne suchausgabe erstellt und mit .. getrennt
				$zaehl = 0;
				$if_find = false;
				$words = 0;
				
				foreach($searchwords as $searchword) {         
					      
					// prüft ob der zusammenhängende satz gefunden wurde		
					if(strpos($inhalt, $searchWord)!==false || strpos($titel, $searchWord)!==false || strpos($datum, $searchWord)!==false || strpos($categoryName, $searchWord) !== false) {
						$if_find = true;
						if(strpos($titel, $searchWord)!==false) //wenn im titel gefunden wurde
							$findtext = false;
						elseif (strpos($datum, $searchWord)!==false || strpos($categoryName, $searchWord) !== false) //wenn im datum gefunden wurde
							$findtext = false;
						else //wenn im inhalt gefunden wurde
							$findtext = true;	
						$wortlaenge[0] = strlen($searchWord);
						$stellen[0] = strpos($inhalt, $searchWord);
						$ausgabenlaenge = 90; //ausgabenlänge vor und hinter zusammenhängenden satz
						$ausgabenlaengereset = $ausgabenlaenge;
						$findings[0] = array("stelle" => $stellen[0], "wortlaenge" => $wortlaenge[0], "findtext" => $findtext);						
						
						$priority = 99;
						$wortanzahl = $langFile['search_results_text4']; //text wenn vollständiger satz gefunden wurde
            			break;
						} else {
							// wenn nicht dann durchsucht er alle einzelwörter
							if(@strpos($inhalt, $searchword)!==false || @strpos($titel, $searchword)!==false || @strpos($datum, $searchword)!==false || @strpos($categoryName, $searchword) !== false) {
							$if_find = true;
							if(strpos($titel, $searchword)!==false) { //wenn im titel gefunden wurde
								$findtext = false;
								$priority = $priority + 8;
								$wortanzahl = $langFile['search_results_text1']; //angabe findings im titel
							} elseif (strpos($datum, $searchword)!==false || strpos($categoryName, $searchword) !== false) { //wenn im datum gefunden wurde
								$findtext = false;
								$priority = $priority + 3;
								$wortanzahl = $langFile['search_results_text2']; //angabe findings im datum oder gruppe
							} else { //wenn im inhalt gefunden wurde
								$findtext = true;
								$priority++;
																									
								$wortlaenge[$zaehl] = strlen($searchword);							
								$stellen[$zaehl] = strpos($inhalt, $searchword);
								$ausgabenlaenge = 40; //ausgabenlänge vor und hinter einzelnen wörtern
								$ausgabenlaengereset = $ausgabenlaenge;
								$words++;
								$wortanzahl = $langFile['search_results_text3'].' '.$words; //angabe über wortanzahl bei mehreren wörtern
							}
              			$findings[$zaehl] = array("stelle" => $stellen[$zaehl], "wortlaenge" => $wortlaenge[$zaehl], "findtext" => $findtext);
							}
						}
				  $zaehl++;
				  unset($findtext);
				}
							   
				// ausgabe wenn was gefunden wurde
				if($if_find == true){
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
					
					if($findings[$i]['findtext'] == true) {	
					
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
				 
			} // ende der mehrwort suche
            

    
	} //ende gruppen for schleife
	
// AUSGABE angabe der Treffer vor ausgabe
// LADEZEIT MESSEN ausgabe
$time_end = $statisticFunctions->getMicroTime();
$time = round($time_end - $time_start,2);

$timeOutputText = '<h2>'.$count.' '.$langFile['search_results_count'].' <span style="font-size:10px;">'.$langFile['search_results_time_part1'].' '.$time.' '.$langFile['search_results_time_part2'].'</span></h2>';

// show time and result number above
echo $timeOutputText;


$countoutput = 0; 
// FERTIGE AUSGABE sortiert nach prioritität 
if(isset($ausgabe)) {
	array_multisort($ausgabe,SORT_DESC, SORT_REGULAR);

  foreach($ausgabe as $output) {
    $countoutput++;
    //echo '|-'.$output['priority'].'-||';
    echo '<div class="block"><h1>'.$countoutput.'. <span style="font-size:10px;">'.$output['words'].'</span></h1>'.$output['output'].'</div>';
  }
  
  // show time and result number below
  //echo $timeOutputText;
}

unset($searchWord,$ausgabe);
} // ende if suche


?>