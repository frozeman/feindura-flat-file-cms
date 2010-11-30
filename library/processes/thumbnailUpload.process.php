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
 * Includes the login and filters the incoming data by xssFilter
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
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
     "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html lang="<?php echo $_SESSION['language']; ?>" xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
  <link rel="stylesheet" type="text/css" href="../styles/windowBox.css" media="screen" />
</head>
<body id="thumbnailUploadFrame">
<?php

// only shows anything if the post var is sended
if($_POST['upload']) {

  // stops the animation when all data is posted
  echo '<script type="text/javascript">
        /* <![CDATA[ */
        window.top.window.stopUploadAnimation();
        /* ]]> */           
        </script>';
  
  // ---------------- ERROR
  // Check if the file has been correctly uploaded.
  if(!isset($_FILES['thumbFile']) || $_FILES['thumbFile']['name'] == '')
  	$error[] = $langFile['pagethumbnail_upload_error_nofile'];
  
  if($error === false) {
    if($_FILES['thumbFile']['tmp_name'] == '')
      $error[] = $langFile['pagethumbnail_upload_error_nouploadedfile'];
      
    // Check if the file filesize is not 0
    if($_FILES['thumbFile']['size'] == 0)
      $error[] = $langFile['pagethumbnail_upload_error_filesize'].' '.ini_get('upload_max_filesize').'B';
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
        $error[] = $langFile['pagethumbnail_upload_error_wrongformat'].' &quot;<b>'.$fileExtension.'</b>&quot;';
    
    // Initializes the counter used to rename the file, if another one with the same name already exists.
    $fileCounter = 0 ;
    
    // sets the thumbnail UploadPath
    $uploadPath = $adminConfig['uploadPath'].$adminConfig['pageThumbnail']['path'];
    
    // ---------------- ERROR
    // checks if the upload Dir exists
    if(!@is_dir(DOCUMENTROOT.$uploadPath))
      if(!@mkdir(DOCUMENTROOT.$uploadPath, PERMISSIONS))
        $error[] = $langFile['pagethumbnail_upload_error_nodir_part1'].' &quot;<b>'.$uploadPath.'</b>&quot; '.$langFile['pagethumbnail_upload_error_nodir_part2'];
    
    
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
      		$response[] = $langFile['pagethumbnail_upload_response_fileexists'].' $quot;<b>'.$fileName.'</b>&quot;';
      	
      	// if not move the uploaded file
      	}	else	{
      	
      	// stops the while, because the fileName is possible
      	$changeFileName = false;
  
      	if(!move_uploaded_file( $_FILES['thumbFile']['tmp_name'], DOCUMENTROOT.$filePath ))
      	 $error[] = $langFile['pagethumbnail_upload_error_couldntmovefile_part1'].' (<b>'.$uploadPath.'</b>) '.$langFile['pagethumbnail_upload_error_couldntmovefile_part2'];
        
        // CHECK FOR ERROR 3
        // --------------------------------------------------------------------------------
        if($error === false) {
          // sets the rights of the file
        	if(is_file(DOCUMENTROOT.$filePath))	{
        		$oldumask = umask(0);
        		@chmod( $filePath, PERMISSIONS);
        		umask($oldumask);
        	}  	
        	 
          // change thumbnail image width and height -------------------
          
          $newFileName = 'thumb_page'.$page.'.'.$fileExtension;
          $newFilePath = $uploadPath.$newFileName;
          
          $imagesize = getimagesize(DOCUMENTROOT.$filePath);
          
          // -> CALCULATE the RATIO, IF RATIO is X or Y
          if($_POST['thumbRatio']) {            
            // RATIO X
            if($_POST['thumbRatio'] == 'x') {
              $ratio = $imagesize[0] / $imagesize[1];
              $thumbHeight = $thumbWidth / $ratio;
              $thumbHeight = round($thumbHeight);
            }  
            // RATIO Y
            if($_POST['thumbRatio'] == 'y') {
              $ratio = $imagesize[1] / $imagesize[0];
              $thumbWidth = $thumbHeight / $ratio;
              $thumbWidth = round($thumbWidth);
            }
          }
          
          // GETIMAGE jpg
          if($fileExtension == 'jpg' || $fileExtension == 'jpeg')
            $oldImg = imagecreatefromjpeg(DOCUMENTROOT.$filePath);
          // GETIMAGE png
          if($fileExtension == 'gif')
            $oldImg = imagecreatefromgif(DOCUMENTROOT.$filePath); 
          // GETIMAGE png
          if($fileExtension == 'png')
            $oldImg = imagecreatefrompng(DOCUMENTROOT.$filePath);  
            
          // create a blank image
          $newImg = imagecreatetruecolor($thumbWidth, $thumbHeight);
          // resize (ERROR)
          if(!imagecopyresampled($newImg, $oldImg, 0,0,0,0,$thumbWidth,$thumbHeight,$imagesize[0],$imagesize[1]))
            $error[] = $langFile['pagethumbnail_upload_error_changeimagesize'];
          
          // SAVEIMAGE jpg
          if($fileExtension == 'jpg' || $fileExtension == 'jpeg')
            imagejpeg($newImg,DOCUMENTROOT.$newFilePath,100);
          // SAVEIMAGE png
          if($fileExtension == 'gif')
            imagegif($newImg,DOCUMENTROOT.$newFilePath);
          // SAVEIMAGE png
          if($fileExtension == 'png')
            imagepng($newImg,DOCUMENTROOT.$newFilePath);
          
          // deletes the uploaded original file
          unlink(DOCUMENTROOT.$filePath);          
          imagedestroy($newImg);
          imagedestroy($oldImg);
          
          // get pageContent (ERROR)
          if(!$pageContent = generalFunctions::readPage($page,$category))
            $error[] = $langFile['file_error_read'];
        
          // CHECK FOR ERROR 4
          // -------------------------------------------------------------
          if($error === false) {
          
            // delete old thumbnail -------------------
            if(!empty($pageContent['thumbnail']) &&
              $pageContent['thumbnail'] != $newFileName &&
              @is_file(DOCUMENTROOT.$uploadPath.$pageContent['thumbnail'])) {
              
              if(!unlink(DOCUMENTROOT.$uploadPath.$pageContent['thumbnail']))
                $error[] = $langFile['pagethumbnail_upload_error_deleteoldfile'];
            }
            
            // saves the new thumbnail in the flatfile ---------------------  
            $pageContent['thumbnail'] = $newFileName;
            if(generalFunctions::savePage($pageContent)) {
              $response[] = $langFile['pagethumbnail_upload_response_finish'].'<br /><br /><img src="'.$uploadPath.$newFileName.'" />';
              statisticFunctions::saveTaskLog(6,'page='.$pageContent['id']); // <- SAVE the task in a LOG FILE
            }
            
            // call this javascript, on the succesfull finish of the upload
            echo '<script type="text/javascript">
                  /* <![CDATA[ */
                  window.top.window.finishUpload('.($thumbHeight + 100).');
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