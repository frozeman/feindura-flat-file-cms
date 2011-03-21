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
 * 1.0 rc -> 1.1
 *
 * @version 0.15
 */

/**
 * Includes all necessary configs, functions and classes
 */
$wrongDiractory = (include("library/includes/backend.include.php"))
  ? false : true;

// VARs
// -----------------------------------------------------------------------------------
error_reporting(E_ALL ^ E_NOTICE);

// gets the version of the feindura CMS
$version = @file("CHANGELOG");
$version[2] = trim($version[2]);
$version[3] = trim($version[3]);

$oldVersion = '1.0 rc';
$newVersion = '1.1 rc7';

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
   
   a {
    text-decoration: none;
    color: #C2802B;
   }
   a:hover {
    color: #ccc;
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
    color: #689420;
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
  
  <?PHP
  // ->> CHECK PHP VERSION
  // *********************
  if(PHP_VERSION < REQUIREDPHPVERSION)
    die('You have the wrong PHP version for feindura '.$newVersion.'. You need at least PHP version'.REQUIREDPHPVERSION);
  ?>
  
  <h1><span class="feindura"><em>fein</em>dura</span> Updater</h1>
  <span style="font-size:25px;"><?= $oldVersion ?> &rArr; <?= $newVersion ?></span><br />
  <br />
  <?php
  
  $updatePossible = ($version[2] == $newVersion) ? true : false;
  
  // WARNING
  if(!$updatePossible) {
    
    echo 'hm... you current version is <b>'.$version[2].'</b> you cannot use this updater, :-(';
    echo '<br /><span class="warning">it\'s only for updating to '.$newVersion.'!</span>';
  }
  //$basePath = dirname($_SERVER['SCRIPT_NAME']).'/';
  //$basePath = preg_replace('#\/+#','/',$basePath);
  
  // WRONG PATH WARNING
  if($wrongDiractory) {
    echo '<br /><span class="warning">You must place the "updater.php" file inside your <span class="feindura"><em>fein</em>dura</span> folder!</span>';
    $updatePossible = false;
  }
  
  // UPDATE QUESTION
  elseif($updatePossible && empty($_POST['asking'])) {
    ?>

Good, your current version is <b><?= $version[2]; ?></b>, but your content isn't updated yet?
<div>
<h2>Do you want to update all pages and configs, so that they work with feindura <?= $newVersion ?>?</h2>
<form action="<?= $_SERVER['SCRIPT_NAME']; ?>" method="post" enctype="multipart/form-data" accept-charset="UTF-8">
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
        if(!empty($data)) {
          $dataExploded = explode(',',$data);
          $newDataArry[] = array('data' => $dataExploded[0], 'number' => $dataExploded[1]);
        }
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
    
    function copyDir($source,$target,&$copyError) {
        if ( is_dir( $source ) ) {
            @mkdir( $target,$GLOBALS['adminConfig']['permissions'],true);
          
            $d = dir( $source );
          
            while ( FALSE !== ( $entry = $d->read() ) ) {
                if ( $entry == '.' || $entry == '..' )
                {
                    continue;
                }
              
                $Entry = $source . '/' . $entry;          
                if ( is_dir( $Entry ) ) {
                    copyDir( $Entry, $target . '/' . $entry );
                    continue;
                }
                
                if(!copy( $Entry, $target . '/' . $entry ))
                  $copyError = true;
            }
          
            $d->close();
        } else {
            if(!copy( $source, $target ));
              $copyError = true;
        }
    }
    
    // and start!
    // *********
    
    echo '<br />';
    
    // try to move the pages folder
    $copyError = false;
    $didntCopy = false;
    if(!empty($adminConfig['savePath']) && is_dir(DOCUMENTROOT.$adminConfig['savePath'])) {
      copyDir(DOCUMENTROOT.$adminConfig['savePath'],dirname(__FILE__).'/pages/',$copyError);
    } else
      $didntCopy = true;
    if($copyError === false && $didntCopy === false) {
      delDir($adminConfig['savePath']);
      echo 'pages <span class="succesfull">succesfully copied to "feindura_folder/pages/"</span><br />';
    } elseif($didntCopy) {
      echo 'old pages folder <span class="succesfull" style="color:#3A74AB;">already copied to "feindura_folder/pages/"? (You must copy the folder with your pages (set in the "save path" setting) to your feindura folder, e.g. "/pages/" -> "/feindura_folder/pages/" )</span><br />';
    } else {
      echo 'pages <span class="notSuccesfull">could not be copied! Please move the folder with your pages (1.php, 2.php, etc..) to "feindura_folder/pages/" manually and run this updater again.</span><br />';
      $succesfullUpdate = false;
    }
    
    // ->> FIX PAGES
    $pages = generalFunctions::loadPages(true);
    
    //print_r($pages);
    $pagesSuccesfullUpdated = true;
    foreach($pages as $pageContent) {
      
      // renaming of some values
      $pageContent['sortOrder'] = (isset($pageContent['sortorder'])) ? $pageContent['sortorder'] : $pageContent['sortOrder'];
      $pageContent['lastSaveDate'] = (isset($pageContent['lastsavedate'])) ? $pageContent['lastsavedate'] : $pageContent['lastSaveDate'];
      $pageContent['lastSaveAuthor'] = (isset($pageContent['lastsaveauthor'])) ? $pageContent['lastsaveauthor'] : $pageContent['lastSaveAuthor'];
      $pageContent['pageDate']['before'] = (isset($pageContent['pagedate']['before'])) ? $pageContent['pagedate']['before'] : $pageContent['pageDate']['before'];
      $pageContent['pageDate']['date'] = (isset($pageContent['pagedate']['date'])) ? $pageContent['pagedate']['date'] : $pageContent['pageDate']['date'];
      $pageContent['pageDate']['after'] = (isset($pageContent['pagedate']['after'])) ? $pageContent['pagedate']['after'] : $pageContent['pageDate']['after'];
      $pageContent['log_visitorCount'] = (isset($pageContent['log_visitorcount'])) ? $pageContent['log_visitorcount'] : $pageContent['log_visitorCount'];
      $pageContent['log_searchWords'] = (isset($pageContent['log_searchwords'])) ? $pageContent['log_searchwords'] : $pageContent['log_searchWords'];
      
      // -> change such a date: 2010-03-20 17:50:27 to unix timestamp
      // mktime(hour,minute,seconds,month,day,year)
      
      $time = $pageContent['lastSaveDate'];
      if(substr($time,4,1) == '-')
        $pageContent['lastSaveDate'] = mktime(substr($time,11,2),substr($time,14,2),substr($time,-2),substr($time,5,2),substr($time,8,2),substr($time,0,4));

      $time = $pageContent['log_firstVisit'];
      if(substr($time,4,1) == '-')
        $pageContent['log_firstVisit'] = mktime(substr($time,11,2),substr($time,14,2),substr($time,-2),substr($time,5,2),substr($time,8,2),substr($time,0,4));
      
      $time = $pageContent['log_lastVisit'];
      if(substr($time,4,1) == '-')
        $pageContent['log_lastVisit'] = mktime(substr($time,11,2),substr($time,14,2),substr($time,-2),substr($time,5,2),substr($time,8,2),substr($time,0,4));
      
      $time = $pageContent['pageDate']['date'];
      if(substr($time,4,1) == '-')
        $pageContent['pageDate']['date'] = mktime(substr($time,11,2),substr($time,14,2),substr($time,-2),substr($time,5,2),substr($time,8,2),substr($time,0,4));

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
          
      
      $data = $pageContent['log_searchWords'];
        if(strpos($data,'|#|') !== false)
          $pageContent['log_searchWords'] = changeToSerializedDataString($data,'|#|');
        elseif(strpos($data,'|') !== false)
          $pageContent['log_searchWords'] = changeToSerializedDataString($data,'|');
        elseif(!empty($data) && substr($data,0,2) != 'a:')
          $pageContent['log_searchWords'] = changeToSerializedDataString($data,' ');

      if(!generalFunctions::savePage($pageContent))
        $pagesSuccesfullUpdated = false;
    }
    if($pagesSuccesfullUpdated)
      echo 'pages <span class="succesfull">succesfully updated</span><br />';
    else {
      echo 'pages <span class="notSuccesfull">could not be updated</span><br />';
      $succesfullUpdate = false;
    }
    
    // ->> SAVE NEW categoryConfig
    $newCategoryConfig = array();
    foreach($categoryConfig as $key => $category) {
      
      // rename
      $category['showTags'] = (isset($category['showtags'])) ? $category['showtags'] : $category['showTags'];
      $category['showPageDate'] = (isset($category['showpagedate'])) ? $category['showpagedate'] : $category['showPageDate'];
      $category['sortByPageDate'] = (isset($category['sortbypagedate'])) ? $category['sortbypagedate'] : $category['sortByPageDate'];
      $category['sortAscending'] = (isset($category['sortascending'])) ? $category['sortascending'] : $category['sortAscending'];
      $category['createDelete'] = (isset($category['createdelete'])) ? $category['createdelete'] : $category['createDelete'];
      
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
    // rename
    $adminConfig['websiteFilesPath'] = (isset($adminConfig['websitefilesPath'])) ? $adminConfig['websitefilesPath'] : $adminConfig['websiteFilesPath'];
    $adminConfig['pages']['showTags'] = (isset($adminConfig['pages']['showtags'])) ? $adminConfig['pages']['showtags'] : $adminConfig['pages']['showTags'];
    $adminConfig['pages']['createDelete'] = (isset($adminConfig['pages']['createdelete'])) ? $adminConfig['pages']['createdelete'] : $adminConfig['pages']['createDelete'];
    $adminConfig['user']['editStyleSheets'] = (isset($adminConfig['user']['editStylesheets'])) ? $adminConfig['user']['editStylesheets'] : $adminConfig['user']['editStyleSheets'];
    
    $data = $adminConfig['editor']['styleFile'];
      if(strpos($data,'|#|') !== false)
        $adminConfig['editor']['styleFile'] = changeToSerializedData($data,'|#|');
      elseif(strpos($data,'|') !== false)
        $adminConfig['editor']['styleFile'] = changeToSerializedData($data,'|');
      elseif(!empty($data) && substr($data,0,2) != 'a:')
        $adminConfig['editor']['styleFile'] = changeToSerializedData($data,' ');
    
    $adminConfig['websitePath'] = (isset($adminConfig['websitePath'])) ? $adminConfig['websitePath'] : '/';
    
    if(saveAdminConfig($adminConfig))
      echo 'adminConfig <span class="succesfull">succesfully updated</span> (if you had SPEAKING URLS activated, you must delete the mod_rewrite code from your .htaccess file, in the root of your webserver and save the administrator settings to create a new one!)<br />';
    else {
      echo 'adminConfig <span class="notSuccesfull">could not be updated</span><br />';
      $succesfullUpdate = false;
    }
    
    // ->> CLEAR activity log
    if($taskLogFile = fopen(dirname(__FILE__)."/statistic/activity.statistic.log","w")) {
      fclose($taskLogFile);
      
      // set documentSaved status
      $documentSaved = true;
      $messageBoxText .= '&rArr; '.$langFile['LOG_CLEARSTATISTICS_ACTIVITYLOG'].'<br />';
      statisticFunctions::saveTaskLog(24); // <- SAVE the task in a LOG FILE
      
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
    if(is_file(dirname(__FILE__).'/.htpasswd'))
      @unlink(dirname(__FILE__).'/.htpasswd');
    
    // folders
    $checkFiles = array();
    if(!delDir(dirname(__FILE__).'/library/javascript/') && 
      is_dir(dirname(__FILE__).'/library/javascript/'))
      $checkFiles[] = dirname(__FILE__).'/library/javascript/';
    if(!delDir(dirname(__FILE__).'/library/thirdparty/javascript/') &&
      is_dir(dirname(__FILE__).'/library/thirdparty/javascript/'))
      $checkFiles[] = dirname(__FILE__).'/library/thirdparty/javascript/';
    if(!delDir(dirname(__FILE__).'/library/thirdparty/customformelements/') &&
      is_dir(dirname(__FILE__).'/library/thirdparty/customformelements/'))
      $checkFiles[] = dirname(__FILE__).'/library/thirdparty/customformelements/';
    if(!delDir(dirname(__FILE__).'/library/image/') &&
      is_dir(dirname(__FILE__).'/library/image/'))
      $checkFiles[] = dirname(__FILE__).'/library/image/';
    if(!delDir(dirname(__FILE__).'/library/lang/') && 
      is_dir(dirname(__FILE__).'/library/lang/'))
      $checkFiles[] = dirname(__FILE__).'/library/lang/';
    if(!delDir(dirname(__FILE__).'/library/process/') && 
      is_dir(dirname(__FILE__).'/library/process/'))
      $checkFiles[] = dirname(__FILE__).'/library/process/';
    if(!delDir(dirname(__FILE__).'/library/style/') && 
      is_dir(dirname(__FILE__).'/library/style/'))
      $checkFiles[] = dirname(__FILE__).'/library/style/';
    if(!delDir(dirname(__FILE__).'/library/images/key/') && 
      is_dir(dirname(__FILE__).'/library/images/key/'))
      $checkFiles[] = dirname(__FILE__).'/library/images/key/';
    if(!delDir(dirname(__FILE__).'/library/images/sign/') && 
      is_dir(dirname(__FILE__).'/library/images/sign/'))
      $checkFiles[] = dirname(__FILE__).'/library/images/sign/';
    if(!delDir(dirname(__FILE__).'/library/thirdparty/iepngfix_v2/') && 
      is_dir(dirname(__FILE__).'/library/thirdparty/iepngfix_v2/'))
      $checkFiles[] = dirname(__FILE__).'/library/thirdparty/iepngfix_v2/';
    if(!delDir(dirname(__FILE__).'/library/thirdparty/CountDown/') && 
      is_dir(dirname(__FILE__).'/library/thirdparty/CountDown/'))
      $checkFiles[] = dirname(__FILE__).'/library/thirdparty/CountDown/';
    
    // files
    if(!unlink(dirname(__FILE__).'/README')&&
      is_file(dirname(__FILE__).'/README'))
      $checkFiles[] = dirname(__FILE__).'/README';
    if(!unlink(dirname(__FILE__).'/library/general.include.php')&&
      is_file(dirname(__FILE__).'/library/general.include.php'))
      $checkFiles[] = dirname(__FILE__).'/library/general.include.php';
    if(!unlink(dirname(__FILE__).'/library/frontend.include.php')&&
      is_file(dirname(__FILE__).'/library/frontend.include.php'))
      $checkFiles[] = dirname(__FILE__).'/library/frontend.include.php';
    if(!unlink(dirname(__FILE__).'/library/backend.include.php') &&
      is_file(dirname(__FILE__).'/library/backend.include.php'))
      $checkFiles[] = dirname(__FILE__).'/library/backend.include.php';
    if(!unlink(dirname(__FILE__).'/library/process/download.php') &&
      is_file(dirname(__FILE__).'/library/process/download.php'))
      $checkFiles[] = dirname(__FILE__).'/library/process/download.php';
    if(!unlink(dirname(__FILE__).'/library/includes/frontend.include.php') &&
      is_file(dirname(__FILE__).'/library/includes/frontend.include.php'))
      $checkFiles[] = dirname(__FILE__).'/library/includes/frontend.include.php';
    if(!unlink(dirname(__FILE__).'/library/processes/showTaskLog.process.php') &&
      is_file(dirname(__FILE__).'/library/processes/showTaskLog.process.php'))
      $checkFiles[] = dirname(__FILE__).'/library/processes/showTaskLog.process.php';
    if(!unlink(dirname(__FILE__).'/library/processes/phptags') &&
      is_file(dirname(__FILE__).'/library/processes/phptags'))
      $checkFiles[] = dirname(__FILE__).'/library/processes/phptags';
    if(!unlink(dirname(__FILE__).'/library/styles/setup.css') &&
      is_file(dirname(__FILE__).'/library/styles/setup.css'))
      $checkFiles[] = dirname(__FILE__).'/library/styles/setup.css';
    if(!unlink(dirname(__FILE__).'/library/styles/menus.css') &&
      is_file(dirname(__FILE__).'/library/styles/menus.css'))
      $checkFiles[] = dirname(__FILE__).'/library/styles/menus.css';
    if(!unlink(dirname(__FILE__).'/library/styles/sidebars.css') &&
      is_file(dirname(__FILE__).'/library/styles/sidebars.css'))
      $checkFiles[] = dirname(__FILE__).'/library/styles/sidebars.css';
    if(!unlink(dirname(__FILE__).'/library/javascripts/sidebar.js') &&
      is_file(dirname(__FILE__).'/library/javascripts/sidebar.js'))
      $checkFiles[] = dirname(__FILE__).'/library/javascripts/sidebar.js';
    if(!unlink(dirname(__FILE__).'/library/images/buttons/mainMenu_home.png') &&
      is_file(dirname(__FILE__).'/library/images/buttons/mainMenu_home.png'))
      $checkFiles[] = dirname(__FILE__).'/library/images/buttons/mainMenu_home.png';
    if(!unlink(dirname(__FILE__).'/library/sites/home.php') &&
      is_file(dirname(__FILE__).'/library/sites/home.php'))
      $checkFiles[] = dirname(__FILE__).'/library/sites/home.php';
      
    if(empty($checkFiles))
      echo 'removed <span class="succesfull">old files and folders</span><br />';
    else {
      echo 'could not remove <span class="notSuccesfull">old files and folders,<br />
      please check these files and folders, and remove them manually:<br />';
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
  <a href="index.php">&lArr; go to the <span class="feindura"><em>fein</em>dura</span> backend</a>
</body>
</html>