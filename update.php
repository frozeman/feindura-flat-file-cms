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
 * @version 2.2
 */

/**
 * Includes all necessary configs, functions and classes
 */
define('FEINDURA_UPDATE',true); // used to prevent caching
$wrongDirectory = (include("library/includes/backend.include.php"))
  ? false : true;

// VARs
// -----------------------------------------------------------------------------------
error_reporting(E_ALL ^ E_NOTICE);

$NEWVERSION = '2.0 beta';
$NEWBUILD = 969;

// gets the version of the feindura CMS
if($prevVersionFile = file(dirname(__FILE__).'/VERSION')) {
  $PREVVERSION = trim($prevVersionFile[1]);
  $PREVBUILD = trim($prevVersionFile[2]);
} else
  $PREVVERSION = '1.0';


$PREVVERSIONSTRING = $PREVVERSION.' <small>Build '.$PREVBUILD.'</small>';
$CURVERSIONSTRING = VERSION.' <small>Build '.BUILD.'</small>';
$NEWVERSIONSTRING = $NEWVERSION.' <small>Build '.$NEWBUILD.'</small>';

?>
<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="content-type" content="application/xhtml+xml; charset=UTF-8">
  <meta http-equiv="content-language" content="en">

  <title>
    feindura Updater
  </title>

  <meta http-equiv="X-UA-Compatible" content="chrome=1">

  <meta http-equiv="pragma" content="no-cache"> <!--browser/proxy dont cache-->
  <meta http-equiv="cache-control" content="no-cache"> <!--proxy dont cache-->

  <meta name="title" content="feindura > Updater">
  <meta name="author" content="Fabian Vogelsteller [frozeman.de]">
  <meta name="publisher" content="Fabian Vogelsteller [frozeman.de]">
  <meta name="copyright" content="Fabian Vogelsteller [frozeman.de]">

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
    die('You have the wrong PHP version for feindura '.$NEWVERSIONSTRING.'. You need at least PHP version'.REQUIREDPHPVERSION.'</body></html>');
  ?>

  <h1><span class="feindura"><em>fein</em>dura</span> Updater</h1>
  <span style="font-size:25px;"><?php echo ($PREVVERSION == '1.0') ? $PREVVERSION.'>': $PREVVERSIONSTRING; ?> &rArr; <?php echo $NEWVERSIONSTRING; ?></span><br>
  <br>
  <?php

  // check version
  if($PREVVERSION.$PREVBUILD == $NEWVERSION.$NEWBUILD)
    die('<span class="succesfull">You content is already up to date.</span><br>
      <small style="color:#999;">(If you don\'t think so, change the number to your previous version of feindura in the "/cms/VERSION" file and run this updater again.)</small>
      <br><br>
      <a href="index.php">&lArr; go to the <span class="feindura"><em>fein</em>dura</span> backend</a></body></html>');

  // check if cms is already updated
  $updatePossible = (VERSION.BUILD == $NEWVERSION.$NEWBUILD) ? true : false;

  // WARNING
  if(!$updatePossible) {

    echo 'hm... you current version is <b>'.$CURVERSIONSTRING.'</b> you cannot use this updater, :-(';
    echo '<br><span class="warning">it\'s only for updating to <span class="feindura"><em>fein</em>dura</span> '.$NEWVERSIONSTRING.'!</span>';
  }

  // WRONG PATH WARNING
  if($wrongDirectory) {
    echo '<br><span class="warning">You must place the "updater.php" file inside your <span class="feindura"><em>fein</em>dura</span> folder!</span>';
    $updatePossible = false;
  }

  // UPDATE QUESTION
  elseif($updatePossible && empty($_POST['asking'])) {
    ?>

Good, your current version is <b><?php echo $CURVERSIONSTRING; ?></b>, but your content isn't updated yet?
<div>
  <h2>Do you want to update all pages and configs, so that they work with <span class="feindura"><em>fein</em>dura</span> <?php echo $CURVERSIONSTRING; ?>?</h2>
  <form action="<?php echo XssFilter::path($_SERVER['PHP_SELF']); ?>" method="post" enctype="multipart/form-data" accept-charset="UTF-8">
  <input type="hidden" name="asking" value="true">
  <input type="submit" value="UPDATE">
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

    // save all activated plugins as serialized string
    function activateAllPluginsSerialized() {
      $activatedPlugins = array();
      foreach($pluginsConfig as $pluginName => $pluginConfig) {
        if($pluginConfig['active'])
          $activatedPlugins[] = $pluginName;
      }
      return serialize($activatedPlugins);
    }

    // check if the last version was until the given build number
    function until($build) {
        return ($GLOBALS['PREVBUILD'] <= $build) ? true : false;
    }

    // and start!
    // *********

    echo '<br>';

    // try to move the pages folder
    $copyError = false;
    $didntCopy = false;
    if(!empty($adminConfig['savePath']) && is_dir($DOCUMENTROOT.$adminConfig['savePath'])) {
      copyDir($DOCUMENTROOT.$adminConfig['savePath'],dirname(__FILE__).'/pages/',$copyError);
    } else
      $didntCopy = true;

    if($copyError === false && $didntCopy === false) {
      GeneralFunctions::deleteFolder($adminConfig['savePath']);
      echo 'pages <span class="succesfull">succesfully copied to "feindura_folder/pages/"</span><br>';
    } elseif($didntCopy) {
      echo 'old pages folder <span class="succesfull" style="color:#3A74AB;">already copied to "feindura_folder/pages/"? (<strong>You must copy the folder with your pages (set in the "save path" setting) to your feindura folder, e.g. "/pages/" -> "/feindura_folder/pages/"</strong>)</span><br>';
    } else {
      echo 'pages <span class="notSuccesfull">could not be copied! Please move the folder with your pages (1.php, 2.php, etc..) to "feindura_folder/pages/" manually and run this updater again.</span><br>';
      $succesfullUpdate = false;
    }

    // save the $pagesMetaData array
    // GeneralFunctions::savePagesMetaData();

    // ->> LOAD PAGES
    $pages = GeneralFunctions::loadPages(true);

    // ->> SAVE NEW adminConfig
    // rename
    $adminConfig['websiteFilesPath'] = (isset($adminConfig['websitefilesPath'])) ? $adminConfig['websitefilesPath'] : $adminConfig['websiteFilesPath'];
    $adminConfig['pages']['showTags'] = (isset($adminConfig['pages']['showtags'])) ? $adminConfig['pages']['showtags'] : $adminConfig['pages']['showTags'];
    $adminConfig['pages']['createDelete'] = (isset($adminConfig['pages']['createdelete'])) ? $adminConfig['pages']['createdelete'] : $adminConfig['pages']['createDelete'];
    $adminConfig['user']['editStyleSheets'] = (isset($adminConfig['user']['editStylesheets'])) ? $adminConfig['user']['editStylesheets'] : $adminConfig['user']['editStyleSheets'];
    if(!isset($adminConfig['editor']['safeHtml'])) $adminConfig['editor']['safeHtml'] = false;
    if(!isset($adminConfig['editor']['htmlLawed'])) $adminConfig['editor']['htmlLawed'] = true;

    // save all activated plugins as serialized string
    if($adminConfig['pages']['plugins'] === true || $adminConfig['pages']['plugins'] === 'true')
      $adminConfig['pages']['plugins'] = activateAllPluginsSerialized();

    $data = $adminConfig['editor']['styleFile'];
    if(strpos($data,'|#|') !== false)
      $adminConfig['editor']['styleFile'] = changeToSerializedData($data,'|#|');
    elseif(strpos($data,'|') !== false)
      $adminConfig['editor']['styleFile'] = changeToSerializedData($data,'|');
    elseif(!empty($data) && substr($data,0,2) != 'a:')
      $adminConfig['editor']['styleFile'] = changeToSerializedData($data,' ');

    $adminConfig['websitePath'] = (isset($adminConfig['websitePath'])) ? $adminConfig['websitePath'] : '/';

    if($adminConfig['dateFormat'] == 'eu')
      $adminConfig['dateFormat'] = 'DMY';
    if($adminConfig['dateFormat'] == 'int')
      $adminConfig['dateFormat'] = 'YMD';

    // only if was below 1.1.6
    if(until(796))
      $adminConfig['speakingUrl'] = false; // beacuse i changed speaking url reg ex and createHref generation

    // only if was until build 947
    if(until(946) && !isset($categoryConfig[0]['id'])) {

      // delete the non-category, which only has the name (set in backend.include.php)
      unset($categoryConfig[0]);

      $nonCat[0]                    = $adminConfig['pages'];

      $nonCat[0]['id']              = 0;
      $nonCat[0]['public']          = true;
      $nonCat[0]['isSubCategory']   = false;
      $nonCat[0]['isSubCategoryOf'] = 'a:0:{}';

      $nonCat[0]['styleFile']       = $adminConfig['editor']['styleFile'];
      $nonCat[0]['styleId']         = $adminConfig['editor']['styleId'];
      $nonCat[0]['styleClass']      = $adminConfig['editor']['styleClass'];

      // merge non category into the categoryConfig
      $categoryConfig = array_merge($nonCat, $categoryConfig);

      unset($adminConfig['pages'],$adminConfig['editor']['styleFile'],$adminConfig['editor']['styleId'],$adminConfig['editor']['styleClass']);
    }

    if(saveAdminConfig($adminConfig))
      echo 'adminConfig <span class="succesfull">succesfully updated</span> (if you had SPEAKING URLS activated, you must delete the mod_rewrite code from your .htaccess file, in the root of your webserver and save the administrator settings to create a new one!)<br>';
    else {
      echo 'adminConfig <span class="notSuccesfull">could not be updated</span><br>';
      $succesfullUpdate = false;
    }
    GeneralFunctions::$adminConfig = $adminConfig;


    //print_r($pages);
    $pagesSuccesfullUpdated = true;
    foreach($pages as $pageContent) {

      // renaming of some values
      $pageContent['sortOrder'] = (isset($pageContent['sortorder'])) ? $pageContent['sortorder'] : $pageContent['sortOrder'];
      $pageContent['lastSaveDate'] = (isset($pageContent['lastsavedate'])) ? $pageContent['lastsavedate'] : $pageContent['lastSaveDate'];
      $pageContent['lastSaveAuthor'] = (isset($pageContent['lastsaveauthor'])) ? $pageContent['lastsaveauthor'] : $pageContent['lastSaveAuthor'];
      $pageContent['pageDate']['date'] = (isset($pageContent['pagedate']['date'])) ? $pageContent['pagedate']['date'] : $pageContent['pageDate']['date'];

      // v2.0
      if(!is_numeric($pageContent['lastSaveAuthor'])) {
        foreach ($userConfig as $user) {
          if($user['username'] == $pageContent['lastSaveAuthor']) {
            $pageContent['lastSaveAuthor'] = $user['id'];
            break;
          }
        }
      }

      // v2.0 change thumbnail filename extension (convert to .jpg)
      $thumbnailExtension = substr($pageContent['thumbnail'], (strrpos($pageContent['thumbnail'], '.') + 1 ));
      $thumbnailExtension = strtolower( $thumbnailExtension );
      $thumbnailPath = DOCUMENTROOT.GeneralFunctions::URI2Path($adminConfig['uploadPath']).$adminConfig['pageThumbnail']['path'].$pageContent['thumbnail'];
      if(!empty($pageContent['thumbnail']) && !empty($thumbnailExtension) && $thumbnailExtension != 'jpg' && is_file($thumbnailPath)) {
        require_once(dirname(__FILE__).'/library/thirdparty/PHP/Image.class.php');
        $newThumbnail = new Image($thumbnailPath);
        $newThumbnail->process('jpg',str_replace('.'.$thumbnailExtension, '.jpg', $thumbnailPath));
        $pageContent['thumbnail'] = str_replace('.'.$thumbnailExtension, '.jpg', $pageContent['thumbnail']);
        unlink($thumbnailPath);
        unset($newThumbnail);
      }

      // v2.0 - localized
      if(!isset($pageContent['localized'])) {

        $pageContent['localized'][0]['title'] = $pageContent['title'];
        $pageContent['localized'][0]['content'] = $pageContent['content'];
        $pageContent['localized'][0]['description'] = $pageContent['description'];
        $pageContent['localized'][0]['tags'] = $pageContent['tags'];

        // page date before/after
        $pageContent['localized'][0]['pageDate']['before'] = (isset($pageContent['pagedate']['before'])) ? $pageContent['pagedate']['before'] : $pageContent['pageDate']['before'];
        $pageContent['localized'][0]['pageDate']['after'] = (isset($pageContent['pagedate']['after'])) ? $pageContent['pagedate']['after'] : $pageContent['pageDate']['after'];

      }

      $pageContent['log_visitorCount'] = (isset($pageContent['log_visitorcount'])) ? $pageContent['log_visitorcount'] : $pageContent['log_visitorCount'];
      $pageContent['log_searchWords'] = (isset($pageContent['log_searchwords'])) ? $pageContent['log_searchwords'] : $pageContent['log_searchWords'];

      // activate the captcha in the contactForm plugins, when the contactForm is activated
      if(isset($pageContent['plugins']['contactForm']) && !isset($pageContent['plugins']['contactForm']['captcha']))
        $pageContent['plugins']['contactForm']['captcha'] = true;


      // only if was until 1.1.6
      // change the plugins names from imageGallery => imageGalleryFromFolder; slideShow => slideShowFromFolder
      if(until(796)) {
        if(isset($pageContent['plugins']['imageGallery']) && !isset($pageContent['plugins']['imageGalleryFromFolder'])) {
          $pageContent['plugins']['imageGalleryFromFolder'] = $pageContent['plugins']['imageGallery'];
          unset($pageContent['plugins']['imageGallery']);
        } elseif(isset($pageContent['plugins']['slideShow']) && !isset($pageContent['plugins']['slideShowFromFolder'])) {
          $pageContent['plugins']['slideShowFromFolder'] = $pageContent['plugins']['slideShow'];
          unset($pageContent['plugins']['slideShow']);
        }
      }

      // v2.0 changed key names of plugins
      // imageGallery
      if(isset($pageContent['plugins']['imageGallery'])) {
        $pageContent['plugins']['imageGallery']['imageWidthNumber'] = (isset($pageContent['plugins']['imageGallery']['imageWidth']))
          ? $pageContent['plugins']['imageGallery']['imageWidth']
          : $pageContent['plugins']['imageGallery']['imageWidthNumber'];
        $pageContent['plugins']['imageGallery']['imageHeightNumber'] = (isset($pageContent['plugins']['imageGallery']['imageHeight']))
          ? $pageContent['plugins']['imageGallery']['imageHeight']
          : $pageContent['plugins']['imageGallery']['imageHeightNumber'];
        $pageContent['plugins']['imageGallery']['thumbnailWidthNumber'] = (isset($pageContent['plugins']['imageGallery']['thumbnailWidth']))
          ? $pageContent['plugins']['imageGallery']['thumbnailWidth']
          : $pageContent['plugins']['imageGallery']['thumbnailWidthNumber'];
        $pageContent['plugins']['imageGallery']['thumbnailHeightNumber'] = (isset($pageContent['plugins']['imageGallery']['thumbnailHeight']))
          ? $pageContent['plugins']['imageGallery']['thumbnailHeight']
          : $pageContent['plugins']['imageGallery']['thumbnailHeightNumber'];
        $pageContent['plugins']['imageGallery']['breakAfterNumber'] = (isset($pageContent['plugins']['imageGallery']['breakAfter']))
          ? $pageContent['plugins']['imageGallery']['breakAfter']
          : $pageContent['plugins']['imageGallery']['breakAfterNumber'];
        $pageContent['plugins']['imageGallery']['tagSelection'] = (isset($pageContent['plugins']['imageGallery']['tag']))
          ? $pageContent['plugins']['imageGallery']['tag']
          : $pageContent['plugins']['imageGallery']['tagSelection'];

        unset($pageContent['plugins']['imageGallery']['imageWidth'],$pageContent['plugins']['imageGallery']['imageHeight'],$pageContent['plugins']['imageGallery']['thumbnailWidth'],$pageContent['plugins']['imageGallery']['thumbnailHeight'],$pageContent['plugins']['imageGallery']['breakAfter'],$pageContent['plugins']['imageGallery']['tag']);
      }
      // imageGalleryFromFolder
      if(isset($pageContent['plugins']['imageGalleryFromFolder'])) {
        $pageContent['plugins']['imageGalleryFromFolder']['imageWidthNumber'] = (isset($pageContent['plugins']['imageGalleryFromFolder']['imageWidth']))
          ? $pageContent['plugins']['imageGalleryFromFolder']['imageWidth']
          : $pageContent['plugins']['imageGalleryFromFolder']['imageWidthNumber'];
        $pageContent['plugins']['imageGalleryFromFolder']['imageHeightNumber'] = (isset($pageContent['plugins']['imageGalleryFromFolder']['imageHeight']))
          ? $pageContent['plugins']['imageGalleryFromFolder']['imageHeight']
          : $pageContent['plugins']['imageGalleryFromFolder']['imageHeightNumber'];
        $pageContent['plugins']['imageGalleryFromFolder']['thumbnailWidthNumber'] = (isset($pageContent['plugins']['imageGalleryFromFolder']['thumbnailWidth']))
          ? $pageContent['plugins']['imageGalleryFromFolder']['thumbnailWidth']
          : $pageContent['plugins']['imageGalleryFromFolder']['thumbnailWidthNumber'];
        $pageContent['plugins']['imageGalleryFromFolder']['thumbnailHeightNumber'] = (isset($pageContent['plugins']['imageGalleryFromFolder']['thumbnailHeight']))
          ? $pageContent['plugins']['imageGalleryFromFolder']['thumbnailHeight']
          : $pageContent['plugins']['imageGalleryFromFolder']['thumbnailHeightNumber'];
        $pageContent['plugins']['imageGalleryFromFolder']['breakAfterNumber'] = (isset($pageContent['plugins']['imageGalleryFromFolder']['breakAfter']))
          ? $pageContent['plugins']['imageGalleryFromFolder']['breakAfter']
          : $pageContent['plugins']['imageGalleryFromFolder']['breakAfterNumber'];
        $pageContent['plugins']['imageGalleryFromFolder']['tagSelection'] = (isset($pageContent['plugins']['imageGalleryFromFolder']['tag']))
          ? $pageContent['plugins']['imageGalleryFromFolder']['tag']
          : $pageContent['plugins']['imageGalleryFromFolder']['tagSelection'];

        unset($pageContent['plugins']['imageGalleryFromFolder']['imageWidth'],$pageContent['plugins']['imageGalleryFromFolder']['imageHeight'],$pageContent['plugins']['imageGalleryFromFolder']['thumbnailWidth'],$pageContent['plugins']['imageGalleryFromFolder']['thumbnailHeight'],$pageContent['plugins']['imageGalleryFromFolder']['breakAfter'],$pageContent['plugins']['imageGalleryFromFolder']['tag']);
      }
      // slideShow
      if(isset($pageContent['plugins']['slideShow'])) {
         $pageContent['plugins']['slideShow']['intervalNumber'] = (isset($pageContent['plugins']['slideShow']['intervalNumber']))
          ? $pageContent['plugins']['slideShow']['intervalNumber']
          : 3;
        $pageContent['plugins']['slideShow']['effectSelection'] = (isset($pageContent['plugins']['slideShow']['effectSelection']))
          ? $pageContent['plugins']['slideShow']['effectSelection']
          : 'fade';
      }
      // slideShowFromFolder
      if(isset($pageContent['plugins']['slideShowFromFolder'])) {
         $pageContent['plugins']['slideShowFromFolder']['intervalNumber'] = (isset($pageContent['plugins']['slideShowFromFolder']['intervalNumber']))
          ? $pageContent['plugins']['slideShowFromFolder']['intervalNumber']
          : 3;
        $pageContent['plugins']['slideShowFromFolder']['effectSelection'] = (isset($pageContent['plugins']['slideShowFromFolder']['effectSelection']))
          ? $pageContent['plugins']['slideShowFromFolder']['effectSelection']
          : 'fade';
      }

      // if below  build 958
      if(until(958)) {
        foreach ($pageContent['plugins'] as $pluginName => $pluginData) {
          unset($pageContent['plugins'][$pluginName]);
          $pageContent['plugins'][$pluginName][1] = $pluginData;
        }
      }

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

      // save page stats
      $pageStatistics = StatisticFunctions::readPageStatistics($pageContent['id']);
      if(!$pageStatistics) {
        $pageStatistics['id'] = $pageContent['id'];
        $pageStatistics['visitorCount'] = $pageContent['log_visitorCount'];
        $pageStatistics['firstVisit'] = $pageContent['log_firstVisit'];
        $pageStatistics['lastVisit'] = $pageContent['log_lastVisit'];
        $pageStatistics['visitTimeMin'] = $pageContent['log_visitTime_min'];
        $pageStatistics['visitTimeMax'] = $pageContent['log_visitTime_max'];
        $pageStatistics['searchWords'] = $pageContent['log_searchWords'];
        StatisticFunctions::savePageStatistics($pageStatistics);
      }

      if(!GeneralFunctions::savePage($pageContent))
        $pagesSuccesfullUpdated = false;
    }
    if($pagesSuccesfullUpdated)
      echo 'pages <span class="succesfull">succesfully updated</span><br>';
    else {
      echo 'pages <span class="notSuccesfull">could not be updated</span><br>';
      $succesfullUpdate = false;
    }

    // ->> SAVE NEW categoryConfig
    foreach($categoryConfig as $key => $category) {

      // rename
      $category['showTags'] = (isset($category['showtags'])) ? $category['showtags'] : $category['showTags'];
      $category['showPageDate'] = (isset($category['showpagedate'])) ? $category['showpagedate'] : $category['showPageDate'];
      if(!isset($category['sorting'])) $category['sorting'] = ($category['sortbypagedate'] || $category['sortByPageDate']) ? 'byPageDate' : 'manually';
      $category['sortReverse'] = ($category['sortascending'] || $category['sortAscending']) ? 'true' : $category['sortReverse'];
      $category['createDelete'] = (isset($category['createdelete'])) ? $category['createdelete'] : $category['createDelete'];
      $category['thumbnails'] = (isset($category['thumbnail'])) ? $category['thumbnail'] : $category['thumbnails'];


      if($category['plugins'] === true || $category['plugins'] === 'true')
      $category['plugins'] = activateAllPluginsSerialized();

      $data = $category['styleFile'];
        if(strpos($data,'|#|') !== false)
          $category['styleFile'] = changeToSerializedData($data,'|#|');
        elseif(strpos($data,'|') !== false)
          $category['styleFile'] = changeToSerializedData($data,'|');

      // v2.0 - localized
      if(!isset($category['localized'])) {
        $category['localized'][0]['name'] = $category['name'];
      }

      // v2.0 subCategory
      if(!isset($category['isSubCategory']))
        $category['isSubCategory'] = false;
      if(!isset($category['isSubCategoryOf']))
        $category['isSubCategoryOf'] = 'a:0:{}';

      // v2.0 - localized
      if(!isset($category['localized'])) {
        $category['localized'][0]['name'] = $category['name'];
      }

      // only if was until 1.1.6
      // change the plugins names from imageGallery => imageGalleryFromFolder; slideShow => slideShowFromFolder
      if(until(796)) {
        $categoryPlugins = unserialize($category['plugins']);
        $newCategoryPlugins = array();

        foreach($categoryPlugins as $categoryPlugin) {
          if($categoryPlugin == 'imageGallery' && !isset($categoryPlugins['imageGalleryFromFolder'])) {
            $categoryPlugin = 'imageGalleryFromFolder';
          } elseif($categoryPlugin == 'slideShow' && !isset($categoryPlugins['slideShowFromFolder'])) {
            $categoryPlugin = 'slideShowFromFolder';
          }
          $newCategoryPlugins[] = $categoryPlugin;
        }

        // serialize the plugins again
        $category['plugins'] = serialize($newCategoryPlugins);
      }

      // change old keys
      $newKey = str_replace('id_','',$key);
      $newKey = intval($newKey);

      $newCategoryConfig[$newKey] = $category;
    }
    if(saveCategories($newCategoryConfig))
      echo 'categoryConfig <span class="succesfull">succesfully updated</span><br>';
    else {
      echo 'categoryConfig <span class="notSuccesfull">could not be updated</span><br>';
      $succesfullUpdate = false;
    }

    // ->> SAVE NEW websiteConfig
    // v2.0 - localized
    if(!isset($websiteConfig['localized'])) {
      $websiteConfig['localized'][0]['title']       = $websiteConfig['title'];
      $websiteConfig['localized'][0]['publisher']   = $websiteConfig['publisher'];
      $websiteConfig['localized'][0]['copyright']   = $websiteConfig['copyright'];
      $websiteConfig['localized'][0]['keywords']    = $websiteConfig['keywords'];
      $websiteConfig['localized'][0]['description'] = $websiteConfig['description'];
    }

    // only if was below 2.0 build 951
    if(until(951)) {
      // maintenance
      if(!isset($websiteConfig['maintenance']))
        $websiteConfig['maintenance'] = $adminConfig['maintenance'];
      // setStartPage
      if(!isset($websiteConfig['setStartPage']))
        $websiteConfig['setStartPage'] = $adminConfig['setStartPage'];
      // multiLanguageWebsite
      if(!isset($websiteConfig['multiLanguageWebsite']))
        $websiteConfig['multiLanguageWebsite'] = $adminConfig['multiLanguageWebsite'];
    }

    if(saveWebsiteConfig($websiteConfig))
      echo 'websiteConfig <span class="succesfull">succesfully updated</span><br>';
    else {
      echo 'websiteConfig <span class="notSuccesfull">could not be updated</span><br>';
      $succesfullUpdate = false;
    }

    // ->> CLEAR activity log
    if($taskLogFile = fopen(dirname(__FILE__)."/statistic/activity.statistic.log","wb")) {
      fclose($taskLogFile);

      // set documentSaved status
      $documentSaved = true;
      $messageBoxText .= '&rArr; '.$langFile['LOG_CLEARSTATISTICS_ACTIVITYLOG'].'<br>';
      saveActivityLog(24); // <- SAVE the task in a LOG FILE

      echo 'activity log <span class="succesfull">reset</span><br>';
    } else {
      echo 'activity log <span class="notSuccesfull">could not be reseted</span><br>';
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

    // rename
    $websiteStatistic['robotVisitCount'] = (isset($websiteStatistic['spiderVisitCount'])) ? $websiteStatistic['spiderVisitCount'] : $websiteStatistic['robotVisitCount'];

    if($statisticFile = fopen(dirname(__FILE__)."/statistic/website.statistic.php","wb")) {

      flock($statisticFile,LOCK_EX);
      fwrite($statisticFile,"<?php\n");

      fwrite($statisticFile,"\$websiteStatistic['userVisitCount'] =    ".XssFilter::int($websiteStatistic["userVisitCount"],0).";\n");
      fwrite($statisticFile,"\$websiteStatistic['robotVisitCount'] =  ".XssFilter::int($websiteStatistic["robotVisitCount"],0).";\n\n");

      fwrite($statisticFile,"\$websiteStatistic['firstVisit'] =        ".XssFilter::int($websiteStatistic["firstVisit"],0).";\n");
      fwrite($statisticFile,"\$websiteStatistic['lastVisit'] =         ".XssFilter::int($websiteStatistic["lastVisit"],0).";\n\n");

      fwrite($statisticFile,"\$websiteStatistic['browser'] =      '".$websiteStatistic["browser"]."';\n\n");

      fwrite($statisticFile,"return \$websiteStatistic;");

      fwrite($statisticFile,"\n?>");
      flock($statisticFile,LOCK_UN);
      fclose($statisticFile);

      echo 'website statistic <span class="succesfull">succesfully updated</span><br>';
    } else {
      echo 'website statistic <span class="notSuccesfull">could not be updated</span><br>';
      $succesfullUpdate = false;
    }

    // ->> refresh the Feeds
    // -> delete old feeds
    clearFeeds();
    // -> save the FEEDS for non-category pages, if activated
    saveFeeds(0);
    // -> save the FEEDS for categories, if activated
    if(is_array($categoryConfig)) {
      foreach($categoryConfig as $category)
        saveFeeds($category['id']);
    }

    // ->> SAVE referer log
    $oldLog = file(dirname(__FILE__)."/statistic/referer.statistic.log");

    if($logFile = fopen(dirname(__FILE__)."/statistic/referer.statistic.log","wb")) {

      // -> write the new log file
      flock($logFile,LOCK_EX);
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
      flock($logFile,LOCK_UN);
      fclose($logFile);

      echo 'referer <span class="succesfull">Succesfully updated</span><br>';

    } else {
      echo 'referer <span class="notSuccesfull">could not be updated</span><br>';
      $succesfullUpdate = false;
    }

    // ->> delete old files
    if(is_file(dirname(__FILE__).'/.htpasswd'))
      @unlink(dirname(__FILE__).'/.htpasswd');

    // -> folders (path is relative to the CMS folder)
    $deleteFolders = array();

    $deleteFolders[] = 'library/javascript/';
    $deleteFolders[] = 'library/thirdparty/customformelements/';
    $deleteFolders[] = 'library/image/';
    $deleteFolders[] = 'library/lang/';
    $deleteFolders[] = 'library/process/';
    $deleteFolders[] = 'library/style/';
    $deleteFolders[] = 'library/images/key/';
    $deleteFolders[] = 'library/images/sign/';
    $deleteFolders[] = 'library/thirdparty/iepngfix_v2/';
    $deleteFolders[] = 'library/thirdparty/CountDown/';
    $deleteFolders[] = 'library/processes/';
    $deleteFolders[] = 'library/sites/';


    // -> files (path is relative to the CMS folder)
    $deleteFiles = array();

    $deleteFiles[] = 'README';
    $deleteFiles[] = 'library/general.include.php';
    $deleteFiles[] = 'library/frontend.include.php';
    $deleteFiles[] = 'library/backend.include.php';
    $deleteFiles[] = 'library/includes/frontend.include.php';
    $deleteFiles[] = 'library/styles/setup.css';
    $deleteFiles[] = 'library/styles/menus.css';
    $deleteFiles[] = 'library/styles/sidebars.css';
    $deleteFiles[] = 'library/javascripts/sidebar.js';
    $deleteFiles[] = 'library/images/buttons/mainMenu_home.png';
    $deleteFiles[] = 'library/thirdparty/javascripts/mootools-core-1.3.1.js';
    $deleteFiles[] = 'library/thirdparty/javascripts/mootools-more-1.3.1.1.js';
    $deleteFiles[] = 'library/thirdparty/spiders.txt';
    $deleteFiles[] = 'statistic/visit.statistic.cache';
    $deleteFiles[] = 'library/thirdparty/PHP/sessionLister.php';
    $deleteFiles[] = 'library/processes.loader.php';
    $deleteFiles[] = 'config/plugins.config.php';
    $deleteFiles[] = 'library/controllers/feinduraWebmasterTool-0.2.controller.php';
    $deleteFiles[] = 'library/thirdparty/spiders.xml';
    $deleteFiles[] = 'library/images/buttons/footerMenu_createPage.png';
    $deleteFiles[] = 'library/images/buttons/footerMenu_deletePage.png';
    $deleteFiles[] = 'library/images/buttons/footerMenu_deleteThumb.png';
    $deleteFiles[] = 'library/images/buttons/footerMenu_editPage.png';
    $deleteFiles[] = 'library/images/buttons/footerMenu_fileManager.png';
    $deleteFiles[] = 'library/images/buttons/footerMenu_spacer.png';
    $deleteFiles[] = 'library/images/buttons/footerMenu_uploadThumb.png';
    $deleteFiles[] = 'library/processes.controller.php';
    $deleteFiles[] = 'library/images/bg/loginBody.php';
    $deleteFiles[] = 'library/thirdparty/javascripts/mootools-core-1.3.2.js';
    $deleteFiles[] = 'library/thirdparty/javascripts/mootools-more-1.3.2.1.js';
    $deleteFiles[] = 'library/images/bg/sortPages_headBg.png';
    $deleteFiles[] = 'library/images/bg/sortPages_liBg.png';
    $deleteFiles[] = 'library/images/bg/errorWindow_bottom.gif';
    $deleteFiles[] = 'library/images/bg/errorWindow_bottom.png';
    $deleteFiles[] = 'library/images/bg/errorWindow_middle.gif';
    $deleteFiles[] = 'library/images/bg/errorWindow_middle.png';
    $deleteFiles[] = 'library/images/bg/errorWindow_top.gif';
    $deleteFiles[] = 'library/images/bg/errorWindow_top.png';
    $deleteFiles[] = 'library/images/bg/loadingBox_bottom.png';
    $deleteFiles[] = 'library/images/bg/loadingBox_middle.png';
    $deleteFiles[] = 'library/images/bg/windowBox_bottom.png';
    $deleteFiles[] = 'library/images/bg/windowBox_middle.png';
    $deleteFiles[] = 'library/images/bg/windowBox_middle.gif';
    $deleteFiles[] = 'library/images/bg/windowBox_top.png';
    $deleteFiles[] = 'library/images/bg/windowBox_top.gif';
    $deleteFiles[] = 'library/images/bg/windowBox_h1.png';
    $deleteFiles[] = 'library/images/bg/toolTip_bottom.png';
    $deleteFiles[] = 'library/images/bg/toolTip_bottom.gif';
    $deleteFiles[] = 'library/images/bg/toolTip_middle.png';
    $deleteFiles[] = 'library/images/bg/toolTip_middle.gif';
    $deleteFiles[] = 'library/images/bg/toolTip_top.png';
    $deleteFiles[] = 'library/images/bg/toolTip_top.gif';
    $deleteFiles[] = 'library/images/bg/errorWindow_bottom.gif';
    $deleteFiles[] = 'library/images/bg/errorWindow_bottom.gif';
    $deleteFiles[] = 'library/images/bg/subMenu_left.png';
    $deleteFiles[] = 'library/images/bg/subMenu_middle.png';
    $deleteFiles[] = 'library/images/bg/subMenu_right.png';
    $deleteFiles[] = 'library/images/bg/sidebarMenu_spacer.png';
    $deleteFiles[] = 'library/images/bg/dimContainer.png';
    $deleteFiles[] = 'library/images/bg/rightSidebar_bg.png';
    $deleteFiles[] = 'library/images/bg/rightSidebar_bgBottom.png';
    $deleteFiles[] = 'library/images/bg/sidebarMenu_key_white.png';
    $deleteFiles[] = 'library/images/bg/sidebarMenu_key_light.png';
    $deleteFiles[] = 'library/images/bg/sidebarMenu_key_dark.png';
    $deleteFiles[] = 'library/images/bg/sidebarMenu_freeTop_brown.png';
    $deleteFiles[] = 'library/images/bg/sidebarMenu_freeTop_gray.png';
    $deleteFiles[] = 'library/images/bg/sidebarMenu_freeTop_blue.png';
    $deleteFiles[] = 'library/images/bg/sidebarMenu_fixedTop_brown.png';
    $deleteFiles[] = 'library/images/bg/content_block_bottom.png';
    $deleteFiles[] = 'library/images/bg/content_block_normal.png';
    $deleteFiles[] = 'library/images/bg/content_block_warning.png';
    $deleteFiles[] = 'library/images/bg/content_block_info.png';
    $deleteFiles[] = 'library/images/bg/content_block_open.png';
    $deleteFiles[] = 'library/images/bg/block_innerBlock_small.png';
    $deleteFiles[] = 'library/images/bg/block_innerBlock_big.png';
    $deleteFiles[] = 'library/images/bg/block_h1.png';
    $deleteFiles[] = 'library/images/buttons/addStyleFilePath.png';
    $deleteFiles[] = 'library/images/bg/content_block_table_left_middle.png';
    $deleteFiles[] = 'library/images/bg/listPages_liBg.png';
    $deleteFiles[] = 'library/images/bg/listPages_liBg_hasSubCategory.png';
    $deleteFiles[] = 'library/images/bg/content_block_table_left_bottom.png';
    $deleteFiles[] = 'library/images/bg/content_block_table_left_middle.png';
    $deleteFiles[] = 'library/images/bg/content_block_table_left_top.png';
    $deleteFiles[] = 'library/images/bg/listPages_pageBar.png';
    $deleteFiles[] = 'library/images/bg/listPages_filterCancel.png';
    $deleteFiles[] = 'library/images/bg/browserBg_amaya.png';
    $deleteFiles[] = 'library/images/bg/browserBg_android.png';
    $deleteFiles[] = 'library/images/bg/browserBg_blackberry.png';
    $deleteFiles[] = 'library/images/bg/browserBg_chrome.png';
    $deleteFiles[] = 'library/images/bg/browserBg_firefox.png';
    $deleteFiles[] = 'library/images/bg/browserBg_galeon.png';
    $deleteFiles[] = 'library/images/bg/browserBg_icab.png';
    $deleteFiles[] = 'library/images/bg/browserBg_icecat.png';
    $deleteFiles[] = 'library/images/bg/browserBg_ie_old.png';
    $deleteFiles[] = 'library/images/bg/browserBg_ie.png';
    $deleteFiles[] = 'library/images/bg/browserBg_ipad.png';
    $deleteFiles[] = 'library/images/bg/browserBg_iphone.png';
    $deleteFiles[] = 'library/images/bg/browserBg_ipod.png';
    $deleteFiles[] = 'library/images/bg/browserBg_konqueror.png';
    $deleteFiles[] = 'library/images/bg/browserBg_lynx.png';
    $deleteFiles[] = 'library/images/bg/browserBg_mozilla.png';
    $deleteFiles[] = 'library/images/bg/browserBg_netpositive.png';
    $deleteFiles[] = 'library/images/bg/browserBg_netscape.png';
    $deleteFiles[] = 'library/images/bg/browserBg_nokia.png';
    $deleteFiles[] = 'library/images/bg/browserBg_omniweb.png';
    $deleteFiles[] = 'library/images/bg/browserBg_opera_mini.png';
    $deleteFiles[] = 'library/images/bg/browserBg_opera.png';
    $deleteFiles[] = 'library/images/bg/browserBg_others.png';
    $deleteFiles[] = 'library/images/bg/browserBg_phoenix.png';
    $deleteFiles[] = 'library/images/bg/browserBg_safari.png';
    $deleteFiles[] = 'library/images/bg/content_block_verticalSeparator.png';
    $deleteFiles[] = 'library/images/buttons/listPages_pageThumbnailUpload.png';
    $deleteFiles[] = 'library/images/buttons/listPages_pageThumbnailDelete.png';
    $deleteFiles[] = 'library/images/buttons/content_deleteIcon.png';
    $deleteFiles[] = 'library/images/buttons/header_out.png';
    $deleteFiles[] = 'library/images/buttons/header_toWebsite.png';
    $deleteFiles[] = 'library/images/buttons/header_toBackend.png';
    $deleteFiles[] = 'library/images/bg/loginBox.png';
    $deleteFiles[] = 'library/images/bg/loginErrorBox_bottom.png';
    $deleteFiles[] = 'library/images/bg/loginErrorBox_middle.png';
    $deleteFiles[] = 'library/images/bg/loginErrorBox_top.png';
    $deleteFiles[] = 'library/images/bg/loginSuccessBox_bottom.png';
    $deleteFiles[] = 'library/images/bg/loginSuccessBox_middle.png';
    $deleteFiles[] = 'library/images/bg/loginSuccessBox_top.png';

    $deleteFiles[] = 'library/styles/reset.css';
    $deleteFiles[] = 'library/styles/layout.css';
    $deleteFiles[] = 'library/styles/content.css';
    $deleteFiles[] = 'library/styles/windowBox.css';
    $deleteFiles[] = 'library/styles/shared.css';
    $deleteFiles[] = 'library/styles/noJavascript.css';
    $deleteFiles[] = 'library/styles/ie7.css';
    $deleteFiles[] = 'library/styles/login.css';

    $deleteFiles[] = 'library/includes/showTaskLog.include.php';
    $deleteFiles[] = 'library/images/bg/leftSidebarInfo_bg.png';
    $deleteFiles[] = 'library/images/bg/footerBlock.png';
    $deleteFiles[] = 'library/images/bg/sidebarScrollDown.png';
    $deleteFiles[] = 'library/images/bg/sidebarScrollUp.png';
    $deleteFiles[] = 'library/images/buttons/sidebarMenu_key_gray.png';
    $deleteFiles[] = 'library/images/buttons/sidebarMenu_key_brown.png';
    $deleteFiles[] = 'library/images/bg/listPages_parentPage_inLineArrow_blue_down.png';
    $deleteFiles[] = 'library/images/bg/listPages_parentPage_inLineArrow_blue_up.png';
    $deleteFiles[] = 'library/images/bg/listPages_parentPage_inLineArrow_blue_start.png';
    $deleteFiles[] = 'library/images/bg/listPages_parentPage_inLineArrow_blue_end.png';
    $deleteFiles[] = 'library/images/bg/listPages_parentPage_inLineArrow_brown_down.png';
    $deleteFiles[] = 'library/images/bg/listPages_parentPage_inLineArrow_brown_up.png';
    $deleteFiles[] = 'library/images/bg/listPages_parentPage_inLineArrow_brown_start.png';
    $deleteFiles[] = 'library/images/bg/listPages_parentPage_inLineArrow_brown_end.png';
    $deleteFiles[] = 'library/images/buttons/login_button.png';
    $deleteFiles[] = 'library/images/icons/mail.gif';
    $deleteFiles[] = 'library/images/buttons/subMenu_editPage.png';



    // CHECK if files could be deleted
    $checkFiles = array();

    // DELTE FILES
    foreach ($deleteFiles as $file) {
      if(!unlink(dirname(__FILE__).'/'.$file) &&
        is_file(dirname(__FILE__).'/'.$file))
        $checkFiles[] = dirname(__FILE__).'/'.$file;
    }

    // DELTE FOLDERS
    foreach ($deleteFolders as $folder) {
      if(!GeneralFunctions::deleteFolder(dirname(__FILE__).'/'.$folder) &&
      is_dir(dirname(__FILE__).'/'.$folder))
      $checkFiles[] = dirname(__FILE__).'/'.$folder;
    }

    // delete lowercase class names
    if(strpos(strtolower(PHP_OS),'win') === false) {
      if(!unlink(dirname(__FILE__).'/library/classes/feindura.class.php') &&
        is_file(dirname(__FILE__).'/library/classes/feindura.class.php'))
        $checkFiles[] = dirname(__FILE__).'/library/classes/feindura.class.php';
      if(!unlink(dirname(__FILE__).'/library/classes/feinduraBase.class.php') &&
        is_file(dirname(__FILE__).'/library/classes/feinduraBase.class.php'))
        $checkFiles[] = dirname(__FILE__).'/library/classes/feinduraBase.class.php';
      if(!unlink(dirname(__FILE__).'/library/classes/generalFunctions.class.php') &&
        is_file(dirname(__FILE__).'/library/classes/generalFunctions.class.php'))
        $checkFiles[] = dirname(__FILE__).'/library/classes/generalFunctions.class.php';
      if(!unlink(dirname(__FILE__).'/library/classes/search.class.php') &&
        is_file(dirname(__FILE__).'/library/classes/search.class.php'))
        $checkFiles[] = dirname(__FILE__).'/library/classes/search.class.php';
      if(!unlink(dirname(__FILE__).'/library/classes/statisticFunctions.class.php') &&
        is_file(dirname(__FILE__).'/library/classes/statisticFunctions.class.php'))
        $checkFiles[] = dirname(__FILE__).'/library/classes/statisticFunctions.class.php';
      // rename editor styles
      if(!rename(dirname(__FILE__).'/config/htmlEditorStyles.js',dirname(__FILE__).'/config/EditorStyles.js') &&
        is_file(dirname(__FILE__).'/config/htmlEditorStyles.js'))
        $checkFiles[] = dirname(__FILE__).'/config/htmlEditorStyles.js';
    }

    // extra, delete old sitemap files
    if(!unlink(GeneralFunctions::getRealPath(GeneralFunctions::getDirname($adminConfig['websitePath'])).'/sitemap-index.xml.gz') &&
      is_file(GeneralFunctions::getRealPath(GeneralFunctions::getDirname($adminConfig['websitePath'])).'/sitemap-index.xml.gz'))
      $checkFiles[] = GeneralFunctions::getRealPath(GeneralFunctions::getDirname($adminConfig['websitePath'])).'/sitemap-index.xml.gz';
    if(!unlink(GeneralFunctions::getRealPath(GeneralFunctions::getDirname($adminConfig['websitePath'])).'/sitemap-pages-1.xml.gz') &&
      is_file(GeneralFunctions::getRealPath(GeneralFunctions::getDirname($adminConfig['websitePath'])).'/sitemap-pages-1.xml.gz'))
      $checkFiles[] = GeneralFunctions::getRealPath(GeneralFunctions::getDirname($adminConfig['websitePath'])).'/sitemap-pages-1.xml.gz';


    if(empty($checkFiles))
      echo 'removed <span class="succesfull">old files and folders</span><br>';
    else {
      echo 'could not remove <span class="notSuccesfull">old files and folders,<br>
      please check these files and folders, and remove them manually:<br>';
      foreach($checkFiles as $checkFile) {
          echo $checkFile.'<br>';
      }
      echo '</span>';
      $succesfullUpdate = false;
    }


    // ->> UPDATE from 1.1.1
    if(!empty($userConfig) && is_array($userConfig)) {
      $newUserConfig = array();
      foreach($userConfig as $user) {
        $newUserConfig[$user['id']] = $user;

        // add the user permissions from the adminConfig to the userConfig
        // only if was until build 953
        if(until(953) && !isset($newUserConfig[$user['id']]['info']))
          $newUserConfig[$user['id']]['info'] = $adminConfig['user']['info'];
        if(until(953) && !isset($newUserConfig[$user['id']]['permissions']))
          $newUserConfig[$user['id']]['permissions'] = $adminConfig['user'];

        // only if was until build 957
        if(until(957) && !isset($newUserConfig[$user['id']]['permissions']['websiteSettings']))
          $newUserConfig[$user['id']]['permissions']['websiteSettings'] = true;
      }

      if(saveUserConfig($newUserConfig))
        echo 'userConfig <span class="succesfull">succesfully updated</span><br>';
      else {
        echo 'userConfig <span class="notSuccesfull">could not be updated</span><br>';
        $succesfullUpdate = false;
      }
    }


    // -> final success text or failure warning
    if($succesfullUpdate) {
      file_put_contents(dirname(__FILE__).'/VERSION', "feindura - Flat File CMS (Version,Build)\n".$NEWVERSION."\n".$NEWBUILD);
      echo '<br>NOTE: If you had Speaking URL activated, you have to activate it again in the admin settings. But before delete the speaking URL code from you .htaccess file manually!<br>';
      echo '<br><h1>You can now delete the "update.php" file.</h1>';
    } else
      echo '<h1>something went wrong :-( could not completely update feindura, check the errors and try again.</h1>';

  }


  ?>
  <br><br>
  <a href="index.php">&lArr; go to the <span class="feindura"><em>fein</em>dura</span> backend</a>
</body>
</html>