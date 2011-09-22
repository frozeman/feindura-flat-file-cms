<?php
/*
    feindura - Flat File Content Management System
    Copyright (C) Fabian Vogelsteller [frozeman.de]

    This program is free software;
    you can redistribute it and/or modify it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 3 of the License, or (at your option) any later version.

    This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY;
    without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
    See the GNU General Public License for more details.

    You should have received a copy of the GNU General Public License along with this program;
    if not,see <http://www.gnu.org/licenses/>.
*/
// thumbnailUpload.php v. 1.51

/**
 * Includes the login.include.php and backend.include.php and filter the basic data
 */
require_once(dirname(__FILE__)."/../includes/secure.include.php");

$error = false;
$response = false;

$page	= $_POST['id'];
$category = $_POST['category'];

//print_r($_FILES);
//echo '<br /><br />';
//print_r($_POST);

?>
<!DOCTYPE html>
<html lang="<?php echo $_SESSION['feinduraSession']['language']; ?>">
<head>
  <meta charset="UTF-8" />
  <link rel="stylesheet" type="text/css" href="../styles/windowBox.css" media="screen" />
</head>
<body id="thumbnailUploadFrame">
<?php

// only shows anything if the post var is sended
if($_POST['upload']) {
  ini_set('memory_limit', '50M');   //  handle large images

  // stops the animation when all data is posted
  echo '<script type="text/javascript">
        /* <![CDATA[ */
        window.top.window.stopUploadAnimation();
        /* ]]> */           
        </script>';
  
  // ---------------- ERROR
  // Check if the file has been correctly uploaded.
  if(!isset($_FILES['thumbFile']) || $_FILES['thumbFile']['name'] == '')
  	$error[] = $langFile['PAGETHUMBNAIL_ERROR_nofile'];
  
  if($error === false) {
    if($_FILES['thumbFile']['tmp_name'] == '')
      $error[] = $langFile['PAGETHUMBNAIL_ERROR_nouploadedfile'];
      
    // Check if the file filesize is not 0
    if($_FILES['thumbFile']['size'] == 0)
      $error[] = $langFile['PAGETHUMBNAIL_ERROR_filesize'].' '.ini_get('upload_max_filesize').'B';
  }
  
  // CHECK FOR ERROR 1
  // --------------------------------------------------------------------------------
  if($error === false) {
  
    // Get the posted file.
    $thumbWidth = $_POST['thumbWidth'];
    $thumbHeight = $_POST['thumbHeight'];
    
    // Get the uploaded file name extension.
    $fileName = $_FILES['thumbFile']['name'];
    
    // deletes all special chars
    $fileName = preg_replace("/[^a-zA-Z0-9\.]/", '', $fileName);
    // Replace dots in the name with underscores (only one dot can be there... security issue).
    $fileName = preg_replace( '/\\\\.(?![^.]*$)/', '_', $fileName );
  
    $originalFileName = $fileName;
    
    // Get the extension.
    $fileExtension = substr($fileName, (strrpos($fileName, '.') + 1 ));
    $fileExtension = strtolower( $fileExtension );
    
    // ---------------- ERROR
    // checks the fileExtension for JPEG, JPG, GIF or PNG if not throw an error
    if ( !($fileExtension == 'jpeg' || $fileExtension == 'jpg' ||  $fileExtension == 'png' || $fileExtension == 'gif'))
        $error[] = $langFile['PAGETHUMBNAIL_ERROR_wrongformat'].' &quot;<b>'.$fileExtension.'</b>&quot;';
    
    // Initializes the counter used to rename the file, if another one with the same name already exists.
    $fileCounter = 0 ;
    
    // sets the thumbnail UploadPath
    $uploadPath = $adminConfig['uploadPath'].$adminConfig['pageThumbnail']['path'];
    
    // ---------------- ERROR
    // checks if the upload Dir exists
    if(empty($adminConfig['uploadPath']) || empty($adminConfig['pageThumbnail']['path']))
      $error[] = $langFile['PAGETHUMBNAIL_ERROR_NODIR_START'].' &quot;<b>'.$uploadPath.'</b>&quot; '.$langFile['PAGETHUMBNAIL_ERROR_NODIR_END'];
    elseif(!@is_dir(DOCUMENTROOT.$uploadPath))
      if(!@mkdir(DOCUMENTROOT.$uploadPath, $adminConfig['permissions'],true))
        $error[] = $langFile['PAGETHUMBNAIL_ERROR_NODIR_START'].' &quot;<b>'.$uploadPath.'</b>&quot; '.$langFile['PAGETHUMBNAIL_ERROR_CREATEDIR_END'];
    
    
    // CHECK FOR ERROR 2
    // --------------------------------------------------------------------------------
    // if no error occured until here, change the thumbnail
    if($error === false) {
      
      // the loop is used to rename the uploaded file if the same name already exists
      // it counts it higher
      $changeFileName = true;
      while($changeFileName) {
      	// Compose the file path.
      	$filePath = $uploadPath.$fileName;
      
          
      	// If a file with that name already exists.
      	if(is_file($filePath))	{
      		$fileCounter++;
      		$fileName = substr($originalFileName, 0, strrpos($originalFileName, '.')).'('.$fileCounter.').'.$fileExtension;
      		$response[] = $langFile['PAGETHUMBNAIL_TEXT_fileexists'].' $quot;<b>'.$fileName.'</b>&quot;';
      	
      	// if not move the uploaded file
      	}	else	{
      	
      	// stops the while, because the fileName is possible
      	$changeFileName = false;
  
      	if(!move_uploaded_file( $_FILES['thumbFile']['tmp_name'], DOCUMENTROOT.$filePath ))
      	 $error[] = $langFile['PAGETHUMBNAIL_ERROR_couldntmovefile_part1'].' (<b>'.$uploadPath.'</b>) '.$langFile['PAGETHUMBNAIL_ERROR_couldntmovefile_part2'];
        
        // CHECK FOR ERROR 3
        // --------------------------------------------------------------------------------
        if($error === false) {
          // sets the rights of the file
        	if(is_file(DOCUMENTROOT.$filePath))	{
        		$oldumask = umask(0);
        		@chmod( $filePath, $adminConfig['permissions']);
        		umask($oldumask);
        	}  	
        	 
          // change thumbnail image width and height -------------------
          
          $newFileName = 'thumb_page'.$page.'_'.uniqid().'.'.$fileExtension;
          $newFilePath = $uploadPath.$newFileName;
          
          require_once(dirname(__FILE__).'/../thirdparty/PHP/Image.class.php');
          
          $keepRatio = (empty($adminConfig['pageThumbnail']['ratio'])) ? false : true;
          $resize = new Image(DOCUMENTROOT.$filePath);
          if(!$resize->resize($thumbWidth,$thumbHeight,$keepRatio,true))
            $error[] = $langFile['PAGETHUMBNAIL_ERROR_CHANGEIMAGESIZE'];
          else
            $resize->process($fileExtension,DOCUMENTROOT.$newFilePath);
          unset($resize);
          
          @unlink(DOCUMENTROOT.$filePath);
          
          // get pageContent (ERROR)
          if(!$pageContent = GeneralFunctions::readPage($page,$category))
            $error[] = $langFile['file_error_read'];
        
          // CHECK FOR ERROR 4
          // -------------------------------------------------------------
          if($error === false) {
          
            // delete old thumbnail -------------------
            if(!empty($pageContent['thumbnail']) &&
              $pageContent['thumbnail'] != $newFileName &&
              @is_file(DOCUMENTROOT.$uploadPath.$pageContent['thumbnail'])) {
              
              if(!unlink(DOCUMENTROOT.$uploadPath.$pageContent['thumbnail']))
                $error[] = $langFile['PAGETHUMBNAIL_ERROR_deleteoldfile'];
            }
            
            // saves the new thumbnail in the flatfile ---------------------  
            $pageContent['thumbnail'] = $newFileName;
            if(GeneralFunctions::savePage($pageContent)) {
              // generates a random number to put on the end of the image, to prevent caching
              $randomImage = '?'.md5(uniqid(rand(),1));
              $response[] = $langFile['PAGETHUMBNAIL_TEXT_finish'].'<br /><br /><img src="'.$uploadPath.$newFileName.$randomImage.'" />';
              StatisticFunctions::saveTaskLog(6,'page='.$pageContent['id']); // <- SAVE the task in a LOG FILE
            }
            
            $thumbSize = @getimagesize(DOCUMENTROOT.$newFilePath);
            $frameHeight = (isset($thumbSize[1]) && $thumbSize[1] > 0) ? $thumbSize[1] + 100 : 0;
            
            // call this javascript, on the succesfull finish of the upload
            echo '<script type="text/javascript">
                  /* <![CDATA[ */
                  window.top.window.finishUpload('.$frameHeight.');
                  /* ]]> */
                  </script>';
          	}
        	}
      	}
      }
    }
  }
  
  // displays the erros if one ocurred
  if($error) {
    echo '<ul  class="error">';
    foreach($error as $errorText) {
      echo '<li>'.$errorText.'</li>';
    }
    echo '<ul>';
  }
  
  // displays the responseText if the upload worked
  if($error === false && $response) {
    echo '<ul class="response">';
    foreach($response as $responseText) {
      echo '<li>'.$responseText.'</li>';
    }
    echo '<ul>';
  }
}
?>
</body>
</html>