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
 * 1.0 rc -> o 1.0
 *
 * @version 0.1
 */


/**
 * Includes all necessary configs, functions and classes
 */
@include("library/includes/backend.include.php");

// VARs
// -----------------------------------------------------------------------------------
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
 </style>
  
</head>
<body>

  <h1><span class="feindura"><em>fein</em>dura</span> Updater</h1>
  <?= $oldVersion ?> &rArr; <?= $newVersion ?><br />
  <br />
  Your current <span class="feindura"><em>fein</em>dura</span> version is <?= $version[2] ?><br />  
  <?php
  
  $updatePossible = ($version[2] == $newVersion) ? true : false;
  
  // WARNING
  if(!$updatePossible)
    echo '<br /><span class="warning">You can not use this updater, it\'s for updating to '.$newVersion.' only!</span>';
  
  $basePath = dirname($_SERVER['PHP_SELF']).'/';
  $basePath = preg_replace('#\/+#','/',$basePath);
  
  // WRONG PATH WARNING
  if($basePath != $adminConfig['basePath']) {
    echo '<br /><span class="warning">You must place the "updater.php" file inside your <span class="feindura"><em>fein</em>dura</span> folder!</span>';
    $updatePossible = false;
  }
  
  // UPDATE QUESTION
  elseif($updatePossible && empty($_POST['asking'])) {

    ?>
<div>
<h2>Do you want to update all pages and configs of <span class="feindura"><em>fein</em>dura</span>, so that they work with feindura <?= $newVersion ?>?</h2>
<form action="<?= $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data" accept-charset="UTF-8">
<input type="hidden" name="asking" value="true" />
<input type="submit" value="UPDATE" />
</div>
    <?php 
  
  // ------------------------------------------------------
  // UPDATE
  } elseif($updatePossible && $_POST['asking'] == 'true') {
    
    echo '<br />';
    
    // ->> SAVE NEW categoryConfig
    $newCategoryConfig = array();
    foreach($categoryConfig as $key => $category) {
      $data = $category['styleFile'];
      if(strpos($data,'|#|') === false)
        $category['styleFile'] = str_replace('|','|#|',$data);
        
      $newCategoryConfig[$key] = $category;
    }    
    if(saveCategories($newCategoryConfig))
      echo 'categoryConfig <span class="succesfull">succesfully updated</span><br />';
    
    // ->> SAVE NEW websiteConfig
    if(saveWebsiteConfig($websiteConfig))
      echo 'websiteConfig <span class="succesfull">succesfully updated</span><br />';
    
    // ->> SAVE NEW adminConfig
    $data = $adminConfig['editor']['styleFile'];
    if(strpos($data,'|#|') === false)
      $adminConfig['editor']['styleFile'] = str_replace('|','|#|',$data);
    
    if(saveAdminConfig($adminConfig))
      echo 'adminConfig <span class="succesfull">succesfully updated</span><br />';
  
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
      if(strpos($data,'|#|') === false)
        $pageContent['log_visitTime_min'] = str_replace('|','|#|',$data);
      
      $data = $pageContent['log_visitTime_max'];
      if(strpos($data,'|#|') === false)
        $pageContent['log_visitTime_max'] = str_replace('|','|#|',$data);
      
      $data = $pageContent['log_searchwords'];
      if(strpos($data,'|#|') === false)
        $pageContent['log_searchwords'] = str_replace('|','|#|',$data);
      
      $generalFunctions->savePage($pageContent);
      
    }
    echo 'pages <span class="succesfull">succesfully updated</span><br />';
    
    // ->> CLEAR activity log
    if($taskLogFile = fopen(dirname(__FILE__)."/statistic/activity.statistic.log","w")) {
      fclose($taskLogFile);
      
      // set documentSaved status
      $documentSaved = true;
      $messageBoxText .= '&rArr; '.$langFile['log_clearStatistic_taskLog'].'<br />';
      $statisticFunctions->saveTaskLog(24); // <- SAVE the task in a LOG FILE
      
      echo 'activity log <span class="succesfull">reset</span><br />';
    }
    
    // ->> SAVE WEBSITE STATISTIC
    $time = $websiteStatistic['firstVisit'];
    if(substr($time,4,1) == '-')
      $websiteStatistic['firstVisit'] = mktime(substr($time,11,2),substr($time,14,2),substr($time,-2),substr($time,5,2),substr($time,8,2),substr($time,0,4));
      
    $time = $websiteStatistic['lastVisit'];
    if(substr($time,4,1) == '-')
      $websiteStatistic['lastVisit'] = mktime(substr($time,11,2),substr($time,14,2),substr($time,-2),substr($time,5,2),substr($time,8,2),substr($time,0,4));
      
    $data = $websiteStatistic['browser'];
    if(strpos($data,'|#|') === false)
      $websiteStatistic['browser'] = str_replace('|','|#|',$data);
    
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
      
    }
    
    delDir($adminConfig['basePath'].'/library/javascript/');
    delDir($adminConfig['basePath'].'/library/thirdparty/javascript/');
    delDir($adminConfig['basePath'].'/library/image/');
    delDir($adminConfig['basePath'].'/library/lang/');
    @unlink(DOCUMENTROOT.$adminConfig['basePath'].'/library/general.include.php');
    @unlink(DOCUMENTROOT.$adminConfig['basePath'].'/library/frontend.include.php');
    @unlink(DOCUMENTROOT.$adminConfig['basePath'].'/library/backend.include.php');
    echo 'removed <span class="succesfull">old files and folders</span><br />';
    
    ?>
  
  <h1>You can delete this file now.</h1>
  
  <?php
  }  
  ?>    
</body>
</html>