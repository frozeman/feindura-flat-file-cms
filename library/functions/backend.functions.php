<?php 
/*
    feindura - Flat File Content Management System
    Copyright (C) 2009 Fabian Vogelsteller [frozeman.de]

    This program is free software;
    you can redistribute it and/or modify it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 3 of the License, or (at your option) any later version.

    This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY;
    without even the implied warranty ;page= MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
    See the GNU General Public License for more details.

    You should have received a copy of the GNU General Public License along with this program;
    if not,see <http://www.gnu.org/licenses/>.
*
* library/functions/backend.functions.php version 1.07
*
* FUNCTIONS -----------------------------------
* 
* redirect($goToCategory, $goToPage, $time = 2)
* 
* numeratePage($group, $pageName, $numerateHowever = false) (NOT IN USE)
* 
* userIsAdmin()
* 
* saveCategories($categories)
* 
* moveCategories($category, $direction)
* 
* editFiles($filesPath, $siteName, $status, $titleText, $anchorName, $fileType)
* 
* saveEditedFiles($post)
* 
* delDir($dir)
* 
* movePage($page, $fromCategory, $toCategory)
* 
* fileFolderIsWritableWarning($fileFolder)
* 
* getHighestId()
* 
* showAddons()*
* 
*/

//error_reporting(E_ALL);
include_once(dirname(__FILE__)."/../backend.include.php");


// ** -- redirect ----------------------------------------------------------------------------------
// leitet automatisch weiter auf die angegeben seite
// -----------------------------------------------------------------------------------------------------
// $goToPage      [seite auf die weitergeleitet werden soll (String)],
// $goToCategory  [the category in which to redirect (String)],
// $time          [the time in seconds after which it will redirect (Number)]
function redirect($goToCategory, $goToPage, $time = 2) {
  global $adminConfig;
  
  echo '<meta http-equiv="refresh" content="'.$time.'; URL='.$adminConfig['basePath'].'?category='.$goToCategory.'&amp;page='.$goToPage.'">';
  echo '<script type="text/javascript">
    /* <![CDATA[ */
      document.location.href = "'.$adminConfig['basePath'].'?category='.$goToCategory.'&page='.$goToPage.'"
    /* ]]> */
    </script>';
  echo 'You should be automatically redirected, if not click <a href="'.$adminConfig['basePath'].'?category='.$goToCategory.'&amp;page='.$goToPage.'">here</a>.';
}


// *************************************** NICHT MEHR VERWENDET *******************************************
// *************************************** NICHT MEHR VERWENDET *******************************************
// ** -- numeratePage ----------------------------------------------------------------------------------
// nummeriert die seiten automatisch, höher/kleiner als die numerierung der letzten seite in dem Gruppenordner
// wird in der htmleditor/postdata.php verwendet
// -----------------------------------------------------------------------------------------------------
// $group           [gruppe in der sich die datei befindet, deren dateiname nummeriert werden soll (String)],
// $pageName        [Dateiname der Datei die nummeriert werden soll (String)],
// $numerateHowever [führt die nummerierung durch, auch wenn die nummerierung für die angegebene Gruppe ausgeschaltet ist (Boolean)]
function numeratePage($group, $pageName, $numerateHowever = false) {
  global $adminConfig;
  global $cfg_groups;
    
  if($cfg_groups[$group]['numerate'] || $numerateHowever) {
      $files = loadPages('../'.$adminConfig['savePath'].$group);  
      if(is_array($files) && !is_numeric(substr($pageName,0,1))) {
        natcasesort($files);
        
        if($cfg_groups[$group]['changesort']) {
          $files = array_reverse($files);
          $fileSortDownward = true; // absteigend (z.b 5 -> 1)
        }    
        //echo 'absteigend? '.$fileSortDownward.'<br />';
      
        // holt die höchste page und speichert ihren dateinamen in der variable $filename
        foreach ($files as $file) {
          $filename = $file;
          $filenameLength = strlen($filename);
          
          // oder holt die Datei die eine Nummer am anfang besitzt
          if(is_numeric(substr($filename,0,1)))
            break;
        }
        
        do {
          // zählt den string von hinten druch und stoppt wenn nur noch eine zahl vorhanden ist
          $filename = substr($filename,0,$filenameLength--);
          //echo 'neee: '.$filename.' '.$filenameLength.'<br />';
          
          // erhöht die vorderste zahl der höhsten flatpage          
          if(is_numeric($filename)) {       
            if($fileSortDownward)
              ++$filename;
            else
              --$filename;
            
            // und fügt die zahl vorne an den neu erstellten dateinamen an
            $pageName = $filename.'_'.$pageName;
          }
                    
        } while (!is_numeric($filename) && $filenameLength >= 0);
        
        // wenn keine Seite mit nummerieung gefunden wurde dann nummeriere mit 1 (z.B. 1_dateiname.php)
        if(!is_numeric($filename))
          $pageName = '1_'.$pageName;
      
      } else // wenn noch keine seite existiert, dann nummeriere mit 1 (z.B. 1_dateiname.php)
        $pageName = '1_'.$pageName;
            
      // gibt den GEÄNDERTEN dateinamen zurück
      return $pageName;
    } else {
      // gibt den UNGEÄNDERTEN dateinamen zurück
      return $pageName;
    }
}
// *************************************** NICHT MEHR VERWENDET --ENDE-- *******************************************


// ** -- userIsAdmin ----------------------------------------------------------------------------------
// open the .htpasswd file and checks the username for: is "admin", "adminstrator", "superuser" or "root" and return true, if no one exists also return true
// -----------------------------------------------------------------------------------------------------
function userIsAdmin() {
 
  $currentUser = strtolower(getenv("REMOTE_USER"));
  
  // checks if the current user has a username like:
  if($currentUser == 'admin' || $currentUser == 'administrator' || $currentUser == 'root' || $currentUser == 'superuser' || $currentUser == 'frozeman') {
    return true;
  } else { // otherwise it checks if in the htpasswd is one of the above usernames, if not return true
    // checks for userfile
    if($getHtaccess = @file(dirname(__FILE__).'/../../.htaccess')) {

      // try to find the .htpasswd path
      foreach($getHtaccess as $htaccessLine) {
        if(strstr(strtolower($htaccessLine),'authuserfile')) {
          $passwdFilePath = substr($htaccessLine,strpos(strtolower($htaccessLine),'authuserfile')+13);
          $passwdFilePath = str_replace("\n", '', $passwdFilePath);
          $passwdFilePath = str_replace("\r", '', $passwdFilePath);          
          $passwdFilePath = str_replace(" ", '', $passwdFilePath);
        }    
      }
      
      // go trough users in .htpasswd, if there is any user with the above names
      // and current user have not such a username return false
      if($getHtpasswd = @file($passwdFilePath)) {
        
        $adminExists = false;        
        foreach($getHtpasswd as $htpasswdLine) {
          $user = explode(':',strtolower($htpasswdLine));          
          
          if($user[0] == 'admin' || $user[0] == 'administrator' || $user[0] == 'root' || $user[0] == 'superuser' || $currentUser == 'frozeman')
            $adminExists = true;
        }
      
        // checks if the currentuser has such a name
        if($adminExists) {
          return false; // ONLY WHEN AN ADMIN EXITS AND THE CURRENT USER ISNT THE ADMIN return false
        } else
          return true;
      
      } else
        return true;
      
    } else { // there is no user file
      return true;
    }    
  }  
  return true;  
}

// ** -- saveCategories ----------------------------------------------------------------------------------
// open the config/categoryConfig.php and writes the categories array.
// -----------------------------------------------------------------------------------------------------
// $categories     [der group array der in der settings.php gespeichert werden soll (Array)],
function saveCategories($categories) {
  global $phpTags;

  // öffnet die categoryConfig.php zum schreiben
  if($categoryConfig = @fopen("config/categoryConfig.php","w")) {

    // *** Schreibe CATEGORIES
    flock($categoryConfig,2); //LOCK_EX
      fwrite($categoryConfig,$phpTags[0]); //< ?php
      fwrite($categoryConfig,'$categories = array('."\n");
  
      foreach($categories as $category) {
      
        if($category['sortbydate'] == 'true')
          $category['sortdate'] = 'true';
          
      
        // ** adds a "/" on the beginning of all absolute paths
        if(!empty($category['styleFile']) && substr($category['styleFile'],0,1) !== '/')
              $category['styleFile'] = '/'.$category['styleFile'];  
      
        $znew = '"id_'.$category['id'].'" => array(
          "id"            => \''.$category['id'].'\',
          "name"          => \''.$category['name'].'\',
          
          "public"        => \''.$category['public'].'\',
          "sortascending" => \''.$category['sortascending'].'\',
          "createdelete"  => \''.$category['createdelete'].'\',
          "thumbnail"     => \''.$category['thumbnail'].'\',
          "sortdate"      => \''.$category['sortdate'].'\',
          "sortbydate"    => \''.$category['sortbydate'].'\',
          
          "styleFile"     => \''.$category['styleFile'].'\',
          "styleId"       => \''.$category['styleId'].'\',
          "styleClass"    => \''.$category['styleClass'].'\',
          
          "thumbWidth"    => \''.$category['thumbWidth'].'\',
          "thumbHeight"   => \''.$category['thumbHeight'].'\',),'."\n";
        fwrite($categoryConfig,$znew);
      }
      fwrite($categoryConfig,');'."\n\n");      
      fwrite($categoryConfig,"return \$categories;");
      
      fwrite($categoryConfig,$phpTags[1]); //? >
    flock($categoryConfig,3); //LOCK_UN
    fclose($categoryConfig);
  
    return true;
  } else
    return false;
}

// ** -- moveCategories ----------------------------------------------------------------------------------
// moves a category UP or DOWN in the categories array
// -----------------------------------------------------------------------------------------------------
function moveCategories($category,            // the category id to be moved (Number)
                        $direction,           // the direction in wich to move (String "up" or "down")
                        $position = false) {  // the exact position where to put the category (iof not false, the directioon var dosn't matter)
  global $categories;
  
  $direction = strtolower($direction);
  
  // ->> CHECKS
  // if they fail it returns the unchanged $categories array
  if(is_array($categories) &&                         // is categories is array
    is_numeric($category) &&                          // have the given category id is a number
    $category == $categories['id_'.$category]['id'] &&     // dows the category exists in the $categories array
    (!$direction || $direction == 'up' || $direction == 'down') &&
    (!$position || is_numeric($position))) {   // is the right direction is given
    
    // vars
    $count = 1;
    $currentPosition = false;
    $dropedCategories = array();
    
    // -> finds out the position in the $categories array
    // and extract this category from it
    foreach($categories as $sortCategory) {
      //echo '>'.$sortCategory['id'].' -> '.$count.'<br />';
      
      if($sortCategory['id'] == $category) {
        $currentPosition = $count;
        $extractCategory = $sortCategory;
      } else  
        $dropedCategories[$sortCategory['id']] = $sortCategory;
      
      $count++;
    }    
    //echo 'currentPos: '.$currentPosition;
    
    // -> creates a new array with the category at the new position
    $count = 1;
    $sortetCategories = array();
    foreach($dropedCategories as $sortCategory) {
      
      // MOVE BY POSITION
      if($position !== false && is_numeric($position)) {
        
         //echo 'exactPos: '.$position;
        
        // if the position is lower than 1
        if($position < 1) {
          if($count == 1)
            $sortetCategories[] = $extractCategory;
          // put it at the first position
         $sortetCategories[] = $dropedCategories[$sortCategory['id']];
        }
        
        // if the position is higher than the count() of the array
        if($position > count($dropedCategories)) {
          $sortetCategories[] = $dropedCategories[$sortCategory['id']];
          // put it at the last position
          if($count == count($dropedCategories))
            $sortetCategories[] = $extractCategory;
        }
        
        // if it is in the array put it at the exact position
        if($position >= 1 && $position <= count($dropedCategories)) {
          if($position == $count)
            $sortetCategories[] = $extractCategory;
          // put it at the first position
          $sortetCategories[] = $dropedCategories[$sortCategory['id']];
        }
      
      // MOVE BY DIRECTION
      } else {
        // move the category UP
        // -------------
        if($direction == 'up') {
          
          // if the currentPosition is outside of the foreach
          if(($currentPosition - 1) <= 1) {
            // add the extract at the beginging of the array
            if($count == 1)
              $sortetCategories[] = $extractCategory;
          
          // add the extract at the new position
          } elseif(($currentPosition - 1) == $count)
              $sortetCategories[] = $extractCategory;
        }
        
        // adds the unmoved categories to the array
        // -------------
        $sortetCategories[] = $dropedCategories[$sortCategory['id']];
        
        // move the category DOWN
        // -------------
        if($direction == 'down') {
          
          // if the currentPosition is outside of the foreach
          if(($currentPosition + 1) > count($dropedCategories)) {
            // add the extract at the end of the array
            if($count == count($dropedCategories))
              $sortetCategories[] = $extractCategory;
          
          // add the extract at the new position
          } elseif($currentPosition == $count)
              $sortetCategories[] = $extractCategory; 
        }
      }
     
      $count++;
    }
    
    // -> set back the id as index
    $categories = array();
    foreach($sortetCategories as $sortetCategory) {
      echo '';
      $categories['id_'.$sortetCategory['id']] = $sortetCategory;
    }
    
    return $categories;
  
  } else
    return false;
}


// ** -- savewebsiteConfig ----------------------------------------------------------------------------------
// open the config/websiteConfig.php and writes the categories array.
// -----------------------------------------------------------------------------------------------------
function saveWebsiteConfig($givenSettings) {  // (Array) with the settings to save
  global $phpTags;
  
  // opens the file for writing
  if($websiteConfig = @fopen("config/websiteConfig.php","w")) {
    
    // format keywords
    $keywords = preg_replace("/ +/", ' ', $givenSettings['keywords']);
    $keywords = preg_replace("/,+/", ',', $keywords);
    $keywords = str_replace(', ',',', $keywords);
    $keywords = str_replace(' ,',',', $keywords);
    $keywords = str_replace(' ',',', $keywords);
    
    // *** Schreibe CATEGORIES
    flock($websiteConfig,2); //LOCK_EX
      fwrite($websiteConfig,$phpTags[0]); //< ?php
  
      fwrite($websiteConfig,"\$websiteConfig['seitentitel']    = '".htmlentities($givenSettings['seitentitel'])."';\n");
      fwrite($websiteConfig,"\$websiteConfig['publisher']    = '".htmlentities($givenSettings['publisher'])."';\n");
      fwrite($websiteConfig,"\$websiteConfig['copyright']    = '".htmlentities($givenSettings['copyright'])."';\n");
      fwrite($websiteConfig,"\$websiteConfig['keywords']       = '".htmlentities($keywords)."';\n");
      fwrite($websiteConfig,"\$websiteConfig['description']    = '".htmlentities($givenSettings['description'])."';\n");
      fwrite($websiteConfig,"\$websiteConfig['contactMail']    = '".$givenSettings['contactMail']."';\n\n");
      
      fwrite($websiteConfig,"\$websiteConfig['startPage']      = '".$givenSettings['startPage']."';\n\n");
      
      fwrite($websiteConfig,"return \$websiteConfig;");
    
      fwrite($websiteConfig,$phpTags[1]); //? >
    flock($websiteConfig,3); //LOCK_UN
    fclose($websiteConfig);
  
    return true;
  } else return false;
}

// ** -- editFiles ----------------------------------------------------------------------------------
// open a file like the language files or stylesheets files and edit it
// -----------------------------------------------------------------------------------------------------
// $filesPath          [Pfad wo sich die Dateien befinden die bearbeitet werden sollen (String)],
// $siteName           [variablenname der $site variable die beim abschicken des Fornmular angegeben wird (String)]
// $status             [status der beim wechsel der Dateien den Dateinamen uebergeben wird (String)],
// $titleText          [Bezeichnung der Dateien die man bearbieten kann (String)],
// $anchorName         [name des Ankers der verwendet werden soll (String)],
// $fileType           [Dateiendung (String)],
// $varNameFile        [variablenname des Dateinames (String)],
// $varNameNewFile     [variablenname der neu erstellten Datei (String)],
// $varNameSendCheck   [variablenname für den sendstatus, ob das formular abgesendet wurde oder nicht (String)],
// $varNameContent     [variablenname für den Inhalt der Dateien]
function editFiles($filesPath, $siteName, $status, $titleText, $anchorName, $fileType) {
  global $_GET;
  global $documentRoot;
  global $langFile;
  global $savedForm;
  
  // shows the block below if it is the ones which is saved before
  if($_GET['status'] == $status || $savedForm == $status)
    $hidden = '';
  else
    $hidden = ' hidden';
  
  echo '<form action="?site='.$siteName.'#'.$anchorName.'" method="post" enctype="multipart/form-data" accept-charset="UTF-8">
        <div>
        <input type="hidden" name="status" value="'.$status.'" />
        <input type="hidden" name="filesPath" value="'.$filesPath.'" />
        <input type="hidden" name="fileType" value="'.$fileType.'" />
        </div>';
  
  echo '<div class="block'.$hidden.'">
          <h1><a href="#" name="'.$anchorName.'">'.$titleText.'</a></h1>
          <div class="content"><br />';

      // gets the files out of the directory --------------
      $dir = $documentRoot.$filesPath;
      if(is_dir($dir)) {
          if ($openDir = opendir($dir)) {
              while (($file = readdir($openDir)) !== false) {
                  if(@is_file($dir . $file)){
                    $files[] = $filesPath.$file;
                  }
              }
              closedir($openDir);
          }
        $isDir = true;
      } else {
        echo '<code>"'.$filesPath.'"</code> <b>'.$langFile['editFilesSettings_noDir'].'</b>';
        $isDir = false;
      }
      
      // GETS ACTUAL FILE ----------------------------------
      if($_GET['status'] == $status)
    
      $editFile = $_GET['file'];
      
      // wenn noch nicht per Dateiauswahl $editfile kreiert wurde
      if(empty($editFile) && isset($files)) {
        $editFile = $files[0];
      }
      
      
      if($isDir) {

      // FILE SELECTION ------------------------------------
      if(isset($files)) {
        echo '<div style="position:relative;left:0px;top:0px;width:300px;" class="right">
              <h2>'.$langFile['editFilesSettings_chooseFile'].'</h2>
              <select onchange="changeFile(\''.$siteName.'\',this.value,\''.$status.'\',\''.$anchorName.'\');">'."\n";
   
              // listet die Dateien aus dem Ordner als Mehrfachauswahl auf
              foreach($files as $cFile) {      
                if($editFile == $cFile)
                  echo '<option value="'.$cFile.'" selected="selected">'.$cFile.'</option>'."\n";
                else
                  echo '<option value="'.$cFile.'">'.$cFile.'</option>'."\n";    
              }
        echo '</select></div>'."\n\n";
      } // -------------------------------------------------
      
      // create a NEW FILE ---------------------------------      
      echo '<div style="position:absolute;right:20px;top:22px;width:250px;" class="right">
            <h2>'.$langFile['editFilesSettings_createFile'].'</h2>
            <input name="newFile" class="toolTip" title="'.$langFile['editFilesSettings_createFile'].'::'.$langFile['editFilesSettings_createFile_inputTip'].'" /> <b>.'.$fileType.'</b>
            </div>';
      }
      
      // OPEN THE FILE -------------------------------------
      if(@is_file($documentRoot.$editFile)) {
        $editFileOpen = fopen($documentRoot.$editFile,"r");  
        $file = @fread($editFileOpen,filesize($documentRoot.$editFile));
        fclose($editFileOpen);
        
        echo '<input type="hidden" name="file" value="'.$editFile.'" />'."\n";

        echo '<textarea name="fileContent" cols="90" rows="30" class="editFiles">'.$file.'</textarea>';
      } 
  
  
  echo '<!--<input type="reset" value="" class="toolTip button cancel" title="'.$langFile['form_cancel'].'" />-->';
  if(is_dir($dir))
    echo '<input type="submit" value="" name="saveEditedFiles" class="toolTip button submit" title="'.$langFile['form_submit'].'" />';
  echo '</div>
      <div class="bottom"></div>
    </div>
    </form>';
}

// ** -- saveEditedFiles ----------------------------------------------------------------------------------
// save the files which where edited with editFiles()
// -----------------------------------------------------------------------------------------------------
// $post            [postvariable with the filename and filecontent (array)]
function saveEditedFiles($post) {
    global $documentRoot;
    
    // SAVE FILE
    if(@is_file($documentRoot.$post['file']) && empty($post['newFile'])) {

      $post['fileContent'] 	= str_replace('\"', '"', $post['fileContent']);
      $post['fileContent'] 	= str_replace("\'", "'", $post['fileContent']);
      //$post['fileContent'] 	= str_replace("<br />", "", $post['fileContent']);
      $post['fileContent'] 	= stripslashes($post['fileContent']);
      
      // wandelt umlaut in HTML zeichen um
      $post['fileContent'] = htmlentities($post['fileContent'],ENT_NOQUOTES,'UTF-8');
      // wandelt die php einleitungstags wieder in zeichen um
      $post['fileContent'] = str_replace(array('&lt;','&gt;'),array('<','>'),$post['fileContent']);
      
      if($file = fopen($documentRoot.$post['file'],"w")) {
      flock($file,2);
      fwrite($file,$post['fileContent']);
      flock($file,3);
      fclose($file);
      
      
      $_GET['status'] = $_POST['status'];
      $_GET['file'] = $_POST['file'];
      return true;
      
      }
      
    // NEW FILE
    } else { // erstellt eine neue Sprachdatei wenn etwas ins das neu erstellen Feld eingetragen wurde
      
      $post['newFile'] = str_replace( array(" ","%","+",'/',"&","#","!","?","$","§",'"',"'","(",")"), '_', $post['newFile'] ) ;
      $post['newFile'] = str_replace( array("ä","ü","ö","ß",'\"'), array("ae","ue","oe","ss","-"), $post['newFile'] ) ;
      
      if($file = @fopen($documentRoot.$post['filesPath'].$post['newFile'].'.'.$post['fileType'],"w")) {
      
        $_GET['status'] = $_POST['status'];
        $_GET['file'] = $_POST['file'];
        
        return true;
      }  
    }
    
    return false;
}

// ** -- delDir ----------------------------------------------------------------------------------
// deletes a dir, with files in it
// -----------------------------------------------------------------------------------------------------
// $dir            [the directory to be deleted, must end with a slash "/" (array)]
function delDir($dir) {
    $files = glob( $dir . '*', GLOB_MARK );
    foreach( $files as $file ){
        if( substr( $file, -1 ) == '/' )
            delTree( $file );
        else
            unlink( $file );
    }
    if(rmdir( $dir ))
      return true;
    else
      return false;
}

// ** -- movePage ----------------------------------------------------------------------------------
// move a file to a new destination
// -----------------------------------------------------------------------------------------------------
// $page            [page id wich will be moved (String)],
// $fromCategory    [category id where the file is situated (String)]
// $toCategory      [category id where it will be moved in (String)]
function movePage($page, $fromCategory, $toCategory) {
  global $adminConfig;
  
  // if there are pages not in a category set the category to empty
  if($fromCategory === false || $fromCategory == 0)
    $fromCategory = '';
  if($toCategory === false || $toCategory == 0)
    $toCategory = '';
    
  // MOVE categories
  if(@copy(dirname(__FILE__)."/../../".$adminConfig['savePath'].$fromCategory.'/'.$page.'.php',
    dirname(__FILE__)."/../../".$adminConfig['savePath'].$toCategory.'/'.$page.'.php') &&
    @unlink(dirname(__FILE__)."/../../".$adminConfig['savePath'].$fromCategory.'/'.$page.'.php'))
    return true;
  else
    return false;
}

// ** -- fileFolderIsWritableWarning ----------------------------------------------------------------------------------
// checks the file/folder if it is writeable, and gives back an error text if not (made for the adminConfig.php)
// -----------------------------------------------------------------------------------------------------
// $fileFolder  [the File or Folder which is checked for writeability, must beginn with a "/" (String)]
function fileFolderIsWritableWarning($fileFolder) {
  global $langFile;
  global $documentRoot;
  
  if(is_writable($documentRoot.$fileFolder) === false) {
      return '<span class="warning"><b>&quot;'.$fileFolder.'&quot;</b> -> '.$langFile['txt_adminSetup_writeAccess_error'].'</span><br />';
  } else return false;
}

// ** -- getHighestId ----------------------------------------------------------------------------------
// gets the highest ID of all pages in all categories
// -----------------------------------------------------------------------------------------------------
function getHighestId() {
  global $categories;
  
  $cats = $categories;
  array_unshift($cats,array('id' => 0));
  
  // loads the file list in an array
  if(empty($cats))
    $pages = loadPages(0,false);
  else
    $pages = loadPages($cats,false);
  
  $highestId = 0;
  
  // go trough the file list and look for the highest number
  if(is_array($pages)) {
    foreach($pages as $page) {
      $pageId = $page[0];
          
      if($pageId > $highestId)
        $highestId = $pageId;
    }
  }
  return $highestId;
}

// ** -- showModulesPlugins ----------------------------------------------------------------------------------
// opens the modules and plugin folder and return tru if there something in
// -----------------------------------------------------------------------------------------------------------
// $folder    [the ABSOLUTE PATH of the Folder which will be checked (String)]
function folderIsEmpty($folder) {
  global $documentRoot;
  
  $folder = $documentRoot.$folder;
  
  // opens the "modules/" dir
  // and checks if there are files in
  $openeddir = @opendir($folder);  // @ zeichen eingefügt
  while (false !== ($indir = @readdir($openeddir))) {
    if($indir != "." && $indir != "..") {
      if(is_file($folder.$indir) || is_dir($folder.$indir)) {
        return true;
      }
    }
  }
  @closedir($openeddir);
  
  return false;  
}

// ** -- checkBasePath ----------------------------------------------------------------------------------
// CHECKs if the current basePath is matching the real basePath
// RETURNs TRUE if the basePath is correct, otherwise FALSE
// -----------------------------------------------------------------------------------------------------------
function checkBasePath() {
  global $adminConfig;
  
  if($adminConfig['basePath'] != dirname($_SERVER['PHP_SELF']).'/' || $adminConfig['url'] != $_SERVER["HTTP_HOST"])
    return false;
  else return true;
}

// ** -- basePathWarning ----------------------------------------------------------------------------------
// CHECKs if the current basePath is matching the real basePath, if not throw a warning
// SHOWs a warning, if the basePath is incorrect
// -----------------------------------------------------------------------------------------------------------
function basePathWarning() {
  global $langFile;
  
  if(checkBasePath() === false) {
    echo '<div class="block warning">
            <h1>'.$langFile['warning_fmsConfWarning_h1'].'</h1>
            <div class="content">
              <p>'.$langFile['warning_fmsConfWarning'].'</p><!-- needs <p> tags for margin-left:..--> 
            </div> 
            <div class="bottom"></div> 
          </div>';
  }
}

// ** -- startPageWarning ----------------------------------------------------------------------------------
// CHECKs if a STARTPAGE is SET and if this page exists
// SHOWs a warning, if the basePath is incorrect
// -----------------------------------------------------------------------------------------------------------
function startPageWarning() {
  global $adminConfig;
  global $websiteConfig;
  global $langFile;
  global $_GET;
  
  if($adminConfig['setStartPage'] && $websiteConfig['startPage'] && ($startPageCategory = getPageCategory($websiteConfig['startPage'])) != 0)
    $startPageCategory .= '/';
  else
    $startPageCategory = '';

  if($adminConfig['setStartPage'] && (!$websiteConfig['startPage'] || !file_exists(dirname(__FILE__).'/../../'.$adminConfig['savePath'].$startPageCategory.$websiteConfig['startPage'].'.php'))) {
    echo '<div class="block warning">
            <h1>'.$langFile['warning_startPageWarning_h1'].'</h1>
            <div class="content">
              <p>'.$langFile['warning_startPageWarning'].'</p><!-- needs <p> tags for margin-left:..--> 
            </div> 
            <div class="bottom"></div> 
          </div>';
  }
}

?>