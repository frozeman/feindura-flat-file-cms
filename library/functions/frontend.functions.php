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

* FRONTEND feindura functions
* 
* library/functions/frontend.functions.php version 1.88
* 
* FUNCTIONS -----------------------------------
* 
* createTitleDate($date)
* 
* createTitle($category, $page, $title, $titleTag, $titleId = false, $titleClass = false, $titleLength = false, $titleAsLink = false, $titleWithCategory = false, $titleDate = false)
*
*/

//error_reporting(E_ALL);
include_once(dirname(__FILE__)."/../frontend.include.php");


// ** -- datumsCheck ----------------------------------------------------------------------------------
// überprüft ob datum innerhalb von zeitraum liegt (input und output format: TT.MM.JJJJ)
// -----------------------------------------------------------------------------------------------------
// $Datum             [datum welches überprüft werden soll],
// $ZeitspanneBeginn  [beginn der Überprüfungs-Zeitraums],
// $ZeitspanneEnde    [ende der Überprüfungs-Zeitraums]
function datumsCheck($Datum, $ZeitspanneBeginn, $ZeitspanneEnde) {
   $ZeitspanneBeginn = substr($ZeitspanneBeginn, 0, 2) + substr($ZeitspanneBeginn, 3, 2)*100 + substr($ZeitspanneBeginn, 6, 4)*10000;
   $ZeitspanneEnde = substr($ZeitspanneEnde, 0, 2) + substr($ZeitspanneEnde, 3, 2)*100 + substr($ZeitspanneEnde, 6, 4)*10000;
   $UmgewandeltesDatum = substr($Datum, 0, 2) + substr($Datum, 3, 2)*100 + substr($Datum, 6, 4)*10000;
           
   if($UmgewandeltesDatum >= $ZeitspanneBeginn && $UmgewandeltesDatum <= $ZeitspanneEnde)
      return true;
   else
      return false;
}


// ** -- listGroupPages ----------------------------------------------------------------------------------
// Listet den Inhalt der übergebenen Gruppe auf (ggf. wird überprüft ob das Dokumentendatum sich im angegeben Zeitraum befindet)
// -------------------------------------------------------------------------------------------------------
function listGroupPages($category,   // [gruppenname]
$hrnumber = 1,                    // [nummer der zu verwendenden Überschrift (Zahl)]
$showthumb = true,                // [Seitenbild anzeigen? (Boolean)]
$showtitle = true,                // [Titel anzeigen? (Boolean)]
$shortenTitle = false,            // [Titel kürzen? (Zahl oder false)]
$showdate = true,                 // [Dokumentendatum im Titel anzeigen?, hier KANN AUCH ein datumsformat mit z.B. TT.MM.JJJJ angegeben werden, ODER ein TEXT der vor den Titel kommt ODER BEIDES]
$useHtml = true,                  // [anreißertext benutzt HTML? (Boolean)]
$reverse = false,                 // [umgekehrte Seitenreihenfolge (Boolean)]
$codeBefore = '',                 // [code der vor den anreißer erzeugt wird ($codeBefore.$title.'<p> ...) (String)]
$codeAfter = '',                  // [code der nach den anreißer erzeugt wird (... '</p>'.$codeAfter) (String)]
$fromPage = 1,                    // [von Seite (Zahl) oder bestimmt Seite mit Dateinamen angeben (String)]
$maxPage = 9999,                  // [bis SeitenANZAHL (limit), wenn sie nicht angezeigt wird wird sie auch nicht mit gezählt (Zahl)] (einschliesslich)
$auszugsize = 300,                // [größe des Ausschnitts, in Anzahl der Zeichen (Zahl)]
$maxwordlength = false,           // [anzahl der zeichen nach der ein zeilenumbruch kommt (Zahl oder false)]
$datumsCheck = false,             // [überprüfen ob das Dokumentendatum sich innerhalb der von bis Monate befindet (Boolean)]
$months_before = 0,               // [Zeitraumüberprüfung von welchem monat (Zahl)]
$months_after = 0) {              // [bis welchen Monat (Zahl) (Monate werden zum aktuellen Datum dazuaddiert oder subtrahiert)]

  global $adminConfig;
  global $cfg_groups;
  

  $files = loadPages($category);
  $files = sortPages($category,$files);
  
  if($files) {
    natcasesort($files); // ordner die Seiten in "natürlicher Reihenfolge"
  
  // dreht die anordnung der Seiten um wenn $reverse == true
  if($reverse)
    
    $count = 0;
    $count_viewable_pages = 0;
    foreach ($files as $pageContent) { // öffnet jede Seite in der Gruppe und zeigt ggf. ihren Inhalt an
      
      //zählt die seiten der gruppe durch
      $count++;
      
      // wenn die Zeitraum-Überprüfung aktiviert ist
      if($datumsCheck) {
        // holt das datum der jeweiligen seite
        $datum = substr($pageContent['date'], -10);
        // ermittelt das Von-Datum
        $datum_von = monateVonBis($months_before, false);	  
      	// ermittelt das Bis-Datum
      	$datum_bis = monateVonBis($months_after);

      	$datumChecked = datumsCheck($datum,$datum_von,$datum_bis);
      	
      // ansonsten zeige immer alle Seiten an
    	} else {
        $datumChecked = true;
      }
      
      // chekct ob $fromPage eine Zahl oder ein Dateiname ist
      if($count >= $fromPage)
        $showPage = true;
      else
        $showPage = false;

      // zeigt die vorschau der seiten an, wenn datumsCheck==true, contentstaus==on und count >= minPage
      // ---------------------------------------------------------------------      
      if($pageContent['public'] && $datumChecked && $showPage) {
      // ---------------------------------------------------------------------
        //zählt nur die seiten der gruppe durch, welche angezeigt werden
        $count_viewable_pages++;
        
        // entfernet HTML tags aus dem Titel
        $pageContent['title'] = strip_tags($pageContent['title']);
        
        //kürzt wörter wenn sie länger sind als $maxwordlength
        if($maxwordlength === true)
          $maxwordlength = 30; //wenn bei $maxwordlength keine zahl angegeben wurde
        if($maxwordlength != false) {       
          // wandelt die &uuml; laute in ü um
          $title_wordwrap = html_entity_decode($pageContent['title'],ENT_QUOTES);
          $content_wordwrap = html_entity_decode($pageContent['content'],ENT_QUOTES);
          // kürzt zulange wörter
          $title_wordwrap = wordwrap($title_wordwrap, $maxwordlength, "-<br />\n", true);
          $content_wordwrap = wordwrap($content_wordwrap, $maxwordlength, "<br />\n", true);        
          // wandelt die ü in &uuml; um
          $pageContent['title'] = htmlentities($title_wordwrap,ENT_QUOTES,"ISO-8859-15"); // ,false) nur ab 5.2.3
          $pageContent['content'] = htmlentities($content_wordwrap,ENT_QUOTES,"ISO-8859-15"); // ,false) nur ab 5.2.3
          // wandelt die restlichen HTML tags wieder in Tags um
          $pageContent['title'] = str_replace("&lt;", "<", $pageContent['title']);
          $pageContent['title'] = str_replace("&gt;", ">", $pageContent['title']);
          $pageContent['content'] = str_replace("&lt;", "<", $pageContent['content']);
          $pageContent['content'] = str_replace("&gt;", ">", $pageContent['content']);
          $pageContent['content'] = str_replace("&quot;", '"', $pageContent['content']); // ""
          $pageContent['content'] = str_replace("&#039;", "'", $pageContent['content']); // ''
        }
        
        // SEITEN-BILD ---------------------
        // ZEIGT das SEITENBILD an WENN es existiert gibt $categories['id_'.$category]['thumbnail'] == true und showThumb == true
        if($showthumb && $categories['id_'.$category]['thumbnail'] && !empty($pageContent['thumbnail']) && @is_file(DOCUMENTROOT.$adminConfig['uploadPath'].$adminConfig['pageThumbnail']['path'].$pageContent['thumbnail'])) {
          $thumbimage = '<a href="?'.$varNameCategory.'='.$category.'&amp;'.$varNamePage.'='.$pageContent['id'].'" class="thumbnail" title="'.$pageContent['title'].'">
                        <img src="'.$adminConfig['uploadPath'].$adminConfig['pageThumbnail']['path'].$pageContent['thumbnail'].'" class="thumbnail" alt="'.$pageContent['title'].'" title="'.$pageContent['title'].'" />
                        </a>';
        } else
          $thumbimage = '';
        
        // SEITEN-DATUM oder TITEL-TEXT --------------------         
        // wenn $showdate == false, zeigt er das Datum nicht an
        $titleDate = createTitleDate($pageContent['date'], $showdate, " - ");
        
        // SEITEN-TITEL --------------------
        if($showtitle) {
          $title = createTitle($category,$pageContent['id'], $pageContent['title'], $hrnumber, true, false, $shortenTitle, $titleDate);
        } else
          $title = '';
      
      // erzeugt den AUSCHNITTSTEXT in HTML ------------------
      if($useHtml) {        
        
        $auszug = shortenHtmlText($pageContent['content'], $auszugsize, ' ... <a href="?'.$varNameCategory.'='.$category.'&amp;'.$varNamePage.'='.$pageContent['id'].'">mehr</a>');
        
        // schaut ob es am anfang und ende einen <p> Tag gibt und entfernet ggf. diese    
        if(substr($auszug, 0, 3) == '<p>' && substr($auszug, -4) == '</p>') {
          $auszug = substr($auszug, 3); // <p>
          $auszug = substr($auszug, 0, -4); // </p>
        }
        
      // erzeugt den AUSCHNITTSTEXT OHNE HTML ------------------
      } else {
        $pageContent['content'] = strip_tags ($pageContent['content'], '<br>,<br />'); // alle HTML tags entfernen außer diese angegeben
        $auszug = shortenText($pageContent['content'], $auszugsize, ' ... <a href="?'.$varNameCategory.'='.$category.'&amp;'.$varNamePage.'='.$pageContent['id'].'">mehr</a>');
      }     
      
      // ERZEUGT die SEITEN-VORSCHAU --------------------------------------------
            
      echo $codeBefore.$title.'<p>
      '.$thumbimage.$auszug.'
      </p>'.$codeAfter;
      
        // bricht das anzeigen der Seiten ab wenn die anzhal der maximal anzeigbaren Seitne erreicht ist
      	if($maxPage == $count_viewable_pages) {
      		break;
      		return;
		    }
      }
    }
  }  
  unset($files,$category,$hrnumber,$showdate,$showtitle,$shortenTitle,$reverse,$fromPage,$maxPage,$auszugsize,$maxwordlength,$datumsCheck,$months_before,$months_after);
}

?>