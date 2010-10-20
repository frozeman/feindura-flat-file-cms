<?php
/**
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
 *
 * update.php
 * 
 * for updating from 
 * 1.0 rc -> 1.0
 *
 * @version 0.12
 */

/**
 * Includes all necessary configs, functions and classes
 */
$wrongDiractory = (@include("library/includes/backend.include.php"))
  ? false : true;

// VARs
// -----------------------------------------------------------------------------------
error_reporting(E_ALL ^ E_NOTICE);

// gets the version of the feindura CMS
$version = @file("CHANGELOG");
$version[2] = trim($version[2]);
$version[3] = trim($version[3]);

$oldVersion = '1.0 rc';
$newVersion = '1.0';

?>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="content-type" content="application/xhtml+xml; charset=UTF-8" />
  <meta http-equiv="content-language" content="en" />
  
  <title>      
    feindura Updater
  </title>
  
  <meta http-equiv="X-UA-Compatible" content="chrome=1">
  
  <meta http-equiv="pragma" content="no-cache" /> <!--browser/proxy dont cache-->
  <meta http-equiv="cache-control" content="no-cache" /> <!--proxy dont cache-->
  
  <meta name="title" content="feindura > Updater" />    
  <meta name="author" content="Fabian Vogelsteller [frozeman.de]" />     
  <meta name="publisher" content="Fabian Vogelsteller [frozeman.de]" />
  <meta name="copyright" content="Fabian Vogelsteller [frozeman.de]" />
  
  <style type="text/css">
   body {
    font: 16px verdana, arial;
   }
   
   h1 {
    font-size: 20px;
   }
   
   h2 {
    font-size: 15px;
   }
   
   /* feindura logo inside texts */
   span.feindura {
      color: #3F7DA6;
   }
   span.feindura em {
      color: #DE7124;
      font-style: normal;
   }
   
   .warning {
    color: #8A3100;
    font-weight: bold;
   }   
   
   .succesfull {
    color: #476117;
    line-height: 25px;
   }   
   .succesfull:before {
    content: " -> ";
   }
   
   .notSuccesfull {
    color: #BD3317;
    line-height: 25px;
   }   
   .notSuccesfull:before {
    content: " -> ";
   }
 </style>
  
</head>
<body>

  <h1><span class="feindura"><em>fein</em>dura</span> Updater</h1>
  <?= $oldVersion ?> &rArr; <?= $newVersion ?><br />
  <br />
  Good: Your current <span class="feindura"><em>fein</em>dura</span> version is <?= $version[2] ?>, so we can now proceed with the update.<br />  
  <?php
  
  $updatePossible = ($version[2] == $newVersion) ? true : false;
  
  // WARNING
  if(!$updatePossible)
    echo '<br /><span class="warning">You can not use this updater, it\'s for updating to '.$newVersion.' only!</span>';
  
  //$basePath = dirname($_SERVER['PHP_SELF']).'/';
  //$basePath = preg_replace('#\/+#','/',$basePath);
  
  // WRONG PATH WARNING
  if($wrongDiractory) {
    echo '<br /><span class="warning">You must place the "updater.php" file inside your <span class="feindura"><em>fein</em>dura</span> folder!</span>';
    $updatePossible = false;
  }
  
  // UPDATE QUESTION
  elseif($updatePossible && empty($_POST['asking'])) {

    ?>
<div>
<h2>Do you want to update all pages and configs, so that they work with feindura <?= $newVersion ?>?</h2>
<form action="<?= $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data" accept-charset="UTF-8">
<input type="hidden" name="asking" value="true" />
<input type="submit" value="UPDATE" />
</div>
    <?php 
  
  // ------------------------------------------------------
  // UPDATE
  } elseif($updatePossible && $_POST['asking'] == 'true') {
    
    // var
    // **
    $succesfullUpdate = true;    
    
    // functions
    // *********
    // changeToSerializedDataString
    function changeToSerializedDataString($oldDataString,$separator) {
      $dataArray = explode($separator,$oldDataString);
      $newDataArry = array();    
      
      foreach($dataArray as $data) {
        $dataExploded = explode(',',$data);
        $newDataArry[] = array('data' => $dataExploded[0], 'number' => $dataExploded[1]);
      }    
      return serialize($newDataArry);
    }
    
    function changeToSerializedData($oldDataString,$separator) {
      $dataArray = explode($separator,$oldDataString);   
      return serialize($dataArray);
    }
    
    function changeVisitTime($oldDataString,$separator) {
      $dataExploded = explode($separator,$oldDataString);
      $newDataString = array();      
      
      foreach($dataExploded as $data) {        
        $hour = substr($time,0,2);
        $minute = substr($time,3,2);
        $second = substr($time,6,2);
        
        $sec = floor($hour * 3600);
        $sec += floor($minute * 60);
        $sec += $second;
        
        $newDataString = $sec;
      }      
      $newDataString = implode($separator,$newDataString);      
      return changeToSerializedData($newDataString,$separator);
    }
    
    // and start!
    // *********
    
    echo '<br />';
    
    // ->> SAVE NEW categoryConfig
    $newCategoryConfig = array();
    foreach($categoryConfig as $key => $category) {
      $data = $category['styleFile'];
        if(strpos($data,'|#|') !== false)
          $category['styleFile'] = changeToSerializedData($data,'|#|');
        elseif(strpos($data,'|') !== false)
          $category['styleFile'] = changeToSerializedData($data,'|');
      
      $newKey = str_replace('id_','',$key);
      $newKey = intval($newKey);
      
      $newCategoryConfig[$newKey] = $category;
    }    
    if(saveCategories($newCategoryConfig))
      echo 'categoryConfig <span class="succesfull">succesfully updated</span><br />';
    else {
      echo 'categoryConfig <span class="notSuccesfull">could not be updated</span><br />';
      $succesfullUpdate = false;
    }
    
    // ->> SAVE NEW websiteConfig
    if(saveWebsiteConfig($websiteConfig))
      echo 'websiteConfig <span class="succesfull">succesfully updated</span><br />';
    else {
      echo 'websiteConfig <span class="notSuccesfull">could not be updated</span><br />';
      $succesfullUpdate = false;
    }
    
    // ->> SAVE NEW adminConfig
    $data = $adminConfig['editor']['styleFile'];
      if(strpos($data,'|#|') !== false)
        $adminConfig['editor']['styleFile'] = changeToSerializedData($data,'|#|');
      elseif(strpos($data,'|') !== false)
        $adminConfig['editor']['styleFile'] = changeToSerializedData($data,'|');
      elseif(!empty($data) && substr($data,0,2) != 'a:')
        $adminConfig['editor']['styleFile'] = changeToSerializedData($data,' ');
    
    if(saveAdminConfig($adminConfig))
      echo 'adminConfig <span class="succesfull">succesfully updated</span><br />';
    else {
      echo 'adminConfig <span class="notSuccesfull">could not be updated</span><br />';
      $succesfullUpdate = false;
    }
  
    // ->> FIX PAGES
    $pages = $generalFunctions->loadPages(true);
    
    //print_r($pages);
    foreach($pages as $pageContent) {
      
      // remove $pagecontent['plugins']
      unset($pageContent['plugins']);
      
      // -> change such a date: 2010-03-20 17:50:27 to unix timestamp
      // mktime(hour,minute,seconds,month,day,year)
      
      $time = $pageContent['lastsavedate'];
      if(substr($time,4,1) == '-')
        $pageContent['lastsavedate'] = mktime(substr($time,11,2),substr($time,14,2),substr($time,-2),substr($time,5,2),substr($time,8,2),substr($time,0,4));

      $time = $pageContent['log_firstVisit'];
      if(substr($time,4,1) == '-')
        $pageContent['log_firstVisit'] = mktime(substr($time,11,2),substr($time,14,2),substr($time,-2),substr($time,5,2),substr($time,8,2),substr($time,0,4));
      
      $time = $pageContent['log_lastVisit'];
      if(substr($time,4,1) == '-')
        $pageContent['log_lastVisit'] = mktime(substr($time,11,2),substr($time,14,2),substr($time,-2),substr($time,5,2),substr($time,8,2),substr($time,0,4));
      
      $time = $pageContent['pagedate']['date'];
      if(substr($time,4,1) == '-')
        $pageContent['pagedate']['date'] = mktime(substr($time,11,2),substr($time,14,2),substr($time,-2),substr($time,5,2),substr($time,8,2),substr($time,0,4));

      // -> change dataString separator
      $data = $pageContent['log_visitTime_min'];
        if(strpos($data,'|#|') !== false)
          $pageContent['log_visitTime_min'] = changeVisitTime($data,'|#|');
        elseif(strpos($data,'|') !== false)
          $pageContent['log_visitTime_min'] = changeVisitTime($data,'|');
        elseif(!empty($data) && substr($data,0,2) != 'a:')
          $pageContent['log_visitTime_min'] = changeVisitTime($data,' ');
      
      $data = $pageContent['log_visitTime_max'];
        if(strpos($data,'|#|') !== false)
          $pageContent['log_visitTime_max'] = changeVisitTime($data,'|#|');
        elseif(strpos($data,'|') !== false)
          $pageContent['log_visitTime_max'] = changeVisitTime($data,'|');
        elseif(!empty($data) && substr($data,0,2) != 'a:')
          $pageContent['log_visitTime_max'] = changeVisitTime($data,' ');
          
      
      $data = $pageContent['log_searchwords'];
        if(strpos($data,'|#|') !== false)
          $pageContent['log_searchwords'] = changeToSerializedDataString($data,'|#|');
        elseif(strpos($data,'|') !== false)
          $pageContent['log_searchwords'] = changeToSerializedDataString($data,'|');
        elseif(!empty($data) && substr($data,0,2) != 'a:')
          $pageContent['log_searchwords'] = changeToSerializedDataString($data,' ');
      
      $pagesSuccesfullUpdated = ($generalFunctions->savePage($pageContent)) ? true : false;      
    }
    if($pagesSuccesfullUpdated)
      echo 'pages <span class="succesfull">succesfully updated</span><br />';
    else {
      echo 'pages <span class="notSuccesfull">could not be updated</span><br />';
      $succesfullUpdate = false;
    }
    
    // ->> CLEAR activity log
    if($taskLogFile = fopen(dirname(__FILE__)."/statistic/activity.statistic.log","w")) {
      fclose($taskLogFile);
      
      // set documentSaved status
      $documentSaved = true;
      $messageBoxText .= '&rArr; '.$langFile['log_clearStatistic_taskLog'].'<br />';
      $statisticFunctions->saveTaskLog(24); // <- SAVE the task in a LOG FILE
      
      echo 'activity log <span class="succesfull">reset</span><br />';
    } else {
      echo 'activity log <span class="notSuccesfull">could not be reseted</span><br />';
      $succesfullUpdate = false;
    }
    
    // ->> SAVE WEBSITE STATISTIC
    $time = $websiteStatistic['firstVisit'];
    if(substr($time,4,1) == '-')
      $websiteStatistic['firstVisit'] = mktime(substr($time,11,2),substr($time,14,2),substr($time,-2),substr($time,5,2),substr($time,8,2),substr($time,0,4));
      
    $time = $websiteStatistic['lastVisit'];
    if(substr($time,4,1) == '-')
      $websiteStatistic['lastVisit'] = mktime(substr($time,11,2),substr($time,14,2),substr($time,-2),substr($time,5,2),substr($time,8,2),substr($time,0,4));
      
    $data = $websiteStatistic['browser'];
      if(strpos($data,'|#|') !== false)
        $websiteStatistic['browser'] = changeToSerializedDataString($data,'|#|');
      elseif(strpos($data,'|') !== false)
        $websiteStatistic['browser'] = changeToSerializedDataString($data,'|');
      elseif(!empty($data) && substr($data,0,2) != 'a:')
        $websiteStatistic['browser'] = changeToSerializedDataString($data,' ');
    
    if($statisticFile = fopen(dirname(__FILE__)."/statistic/website.statistic.php","w")) {
      
      flock($statisticFile,2);        
      fwrite($statisticFile,PHPSTARTTAG);  
            
      fwrite($statisticFile,"\$websiteStatistic['userVisitCount'] =    '".$websiteStatistic["userVisitCount"]."';\n");
      fwrite($statisticFile,"\$websiteStatistic['spiderVisitCount'] =  '".$websiteStatistic["spiderVisitCount"]."';\n\n");
      
      fwrite($statisticFile,"\$websiteStatistic['firstVisit'] =        '".$websiteStatistic["firstVisit"]."';\n");
      fwrite($statisticFile,"\$websiteStatistic['lastVisit'] =         '".$websiteStatistic["lastVisit"]."';\n\n");
      
      fwrite($statisticFile,"\$websiteStatistic['browser'] =      '".$websiteStatistic["browser"]."';\n\n");
      
      fwrite($statisticFile,"return \$websiteStatistic;");
            
      fwrite($statisticFile,PHPENDTAG);        
      flock($statisticFile,3);
      fclose($statisticFile);
      
      echo 'website statistic <span class="succesfull">succesfully updated</span><br />';      
    } else {
      echo 'website statistic <span class="notSuccesfull">could not be updated</span><br />';
      $succesfullUpdate = false;
    }
    
    // ->> SAVE referer log
    $oldLog = file(dirname(__FILE__)."/statistic/referer.statistic.log");
    
    if($logFile = fopen(dirname(__FILE__)."/statistic/referer.statistic.log","w")) {
        
      // -> write the new log file
      flock($logFile,2);
      foreach($oldLog as $oldLogRow) {
        
       if(strpos($oldLogRow,'|#|') === false) {
        
          $time = substr($oldLogRow,0,19);
          if(substr($time,4,1) == '-')
            $time = mktime(substr($time,11,2),substr($time,14,2),substr($time,-2),substr($time,5,2),substr($time,8,2),substr($time,0,4));
  
          $url = substr($oldLogRow,20);
          
          fwrite($logFile,$time.'|#|'.$url);
        } else
          fwrite($logFile,$oldLogRow);
      }    
      flock($logFile,3);
      fclose($logFile);
      
      echo 'referer <span class="succesfull">Succesfully updated</span><br />';
      
    } else {
      echo 'referer <span class="notSuccesfull">could not be updated</span><br />';
      $succesfullUpdate = false;
    }
    
    // ->> delete old files
    $checkFiles = array();
    if(!delDir($adminConfig['basePath'].'library/javascript/') && 
      is_dir(DOCUMENTROOT.$adminConfig['basePath'].'library/javascript/'))
      $checkFiles[] = $adminConfig['basePath'].'library/javascript/';
    if(!delDir($adminConfig['basePath'].'library/thirdparty/javascript/') &&
      is_dir(DOCUMENTROOT.$adminConfig['basePath'].'library/thirdparty/javascript/'))
      $checkFiles[] = $adminConfig['basePath'].'library/thirdparty/javascript/';
    if(!delDir($adminConfig['basePath'].'library/image/') &&
      is_dir(DOCUMENTROOT.$adminConfig['basePath'].'library/image/'))
      $checkFiles[] = $adminConfig['basePath'].'library/image/';
    if(!delDir($adminConfig['basePath'].'library/lang/') && 
      is_dir(DOCUMENTROOT.$adminConfig['basePath'].'library/lang/'))  
      $checkFiles[] = $adminConfig['basePath'].'library/lang/';
    if(!delDir($adminConfig['basePath'].'library/process/') && 
      is_dir(DOCUMENTROOT.$adminConfig['basePath'].'library/process/'))
      $checkFiles[] = $adminConfig['basePath'].'library/process/';
    if(!delDir($adminConfig['basePath'].'library/style/') && 
      is_dir(DOCUMENTROOT.$adminConfig['basePath'].'library/style/'))
      $checkFiles[] = $adminConfig['basePath'].'library/style/';
      
    if(!unlink(DOCUMENTROOT.$adminConfig['basePath'].'README')&&
      is_file(DOCUMENTROOT.$adminConfig['basePath'].'README'))
      $checkFiles[] = $adminConfig['basePath'].'README';
    if(!unlink(DOCUMENTROOT.$adminConfig['basePath'].'library/general.include.php')&&
      is_file(DOCUMENTROOT.$adminConfig['basePath'].'library/general.include.php'))
      $checkFiles[] = $adminConfig['basePath'].'library/general.include.php';
    if(!unlink(DOCUMENTROOT.$adminConfig['basePath'].'library/frontend.include.php')&&
      is_file(DOCUMENTROOT.$adminConfig['basePath'].'library/frontend.include.php'))
      $checkFiles[] = $adminConfig['basePath'].'library/frontend.include.php';
    if(!unlink(DOCUMENTROOT.$adminConfig['basePath'].'library/backend.include.php') &&
      is_file(DOCUMENTROOT.$adminConfig['basePath'].'library/backend.include.php'))
      $checkFiles[] = $adminConfig['basePath'].'library/backend.include.php';
    if(!unlink(DOCUMENTROOT.$adminConfig['basePath'].'library/process/download.php') &&
      is_file(DOCUMENTROOT.$adminConfig['basePath'].'library/process/download.php'))
      $checkFiles[] = $adminConfig['basePath'].'library/process/download.php';
      
      
    if(empty($checkFiles))
      echo 'removed <span class="succesfull">old files and folders</span><br />';
    else {
      echo 'could not remove <span class="notSuccesfull">old files and folders,<br />
      please check these folders, and remove them manually:<br />';
      foreach($checkFiles as $checkFile) {
          echo $checkFile.'<br />';
      }
      echo '</span>';
      $succesfullUpdate = false;
    }
    
    // -> final success text or failure warning
    if($succesfullUpdate)
      echo '<h1>You can now delete the "update.php" file.</h1>';
    else
      echo '<h1>something went wrong :-( could not completely update feindura, check the errors and try again.</h1>';
    
  }  
  ?>    
</body>
</html>