<?php
/* imageGallery plugin */
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
* Image Gallery Plugin class
* 
* This class reads an folder and creates a gallery out of the pictures in it.
* 
* <b>Notice</b>: works only with "png", "gif" and "jpg" or "jpeg" filetypes.
* 
* @author Fabian Vogelsteller <fabian@feindura.org>
* @copyright Fabian Vogelsteller
* @license http://www.gnu.org/licenses GNU General Public License version 3
* 
* @package [Plugins]
* 
* @version 1.0
* <br />
* <b>ChangeLog</b><br />
*    - 1.0 initial release
* 
*/
class imageGallery {
  
 /* ---------------------------------------------------------------------------------------------------------------------------- */
 /* *** PROPERTIES */
 /* **************************************************************************************************************************** */
  
 /**
  * the maximal width of the pictures
  * 
  * All pictures will be resized to this width when the {@link imageGallery::resizeImages()) method is called.
  * 
  * <b>Notice</b>: If the {@link imageGallery::$imageHeight) property is null, it keeps the aspect ratio of the images.
  * 
  * @var int
  * @see imageGallery::$imageHeight  
  * @see imageGallery::resizeImages()
  * 
  */
  var $imageWidth = 800;
  
 /**
  * the maximal height of the pictures
  * 
  * All pictures will be resized to this height when the {@link resizeImages()) method is called.
  * 
  * <b>Notice</b>: If the {@link imageGallery::$imageWidth) property is null, it keeps the aspect ratio of the images.
  * 
  * @var int
  * @see imageGallery::$imageWidth
  * @see imageGallery::resizeImages()
  * 
  */
  var $imageHeight = null;
  
 /**
  * the maximal width of the thumbnails of the pictures
  * 
  * the thumbnails will be created with this width when the {@link imageGallery::createThumbanils()) method is called.
  * 
  * <b>Notice</b>: If the {@link imageGallery::$thumbnailHeight) property is null, it keeps the aspect ratio of the images.
  * 
  * @var int
  * @see imageGallery::$thumbnailHeight  
  * @see imageGallery::createThumbanils()
  * 
  */
  var $thumbnailWidth = 100;
  
 /**
  * the maximal height of the thumbnails of the pictures
  * 
  * the thumbnails will be created with this height when the {@link imageGallery::createThumbanils()) method is called.
  * 
  * <b>Notice</b>: If the {@link imageGallery::$thumbnailWidth) property is null, it keeps the aspect ratio of the images.
  * 
  * @var int
  * @see imageGallery::$thumbnailWidth
  * @see imageGallery::createThumbanils()
  * 
  */
  var $thumbnailHeight = null;
  
 /**
  * An array which contains all image filenames and paths
  * 
  * Example Array:
  * {@example plugins/imagesGallery/images.array.example.php}
  * 
  * @var array
  * 
  */
  var $images = array();
  
/**
  * The absolute path to the gallery
  * 
  * @var string
  * 
  */
  var $galleryPath;
  
/**
  * The title of the gallery, retrieved from the "title.txt"
  * 
  * @var string
  * 
  */
  var $title = 'unnamed';
  
/**
  * The image which is shown as the preview image of the gallery, retrieved from the "previewImage.txt"
  * 
  * @var string
  * 
  */
  var $previewImage;
  
  
 /**
  * <b>Type</b> constructor<br /> 
  * <b>Name</b> imageGallery()<br />
  * 
  * The constructor of the class, sets all basic properties.
  * 
  * 
  * @param string $folder the absolut path of the folder from where a gallery should be created
  * 
  * @uses imageGallery::$generalFunctions  
  * @uses imageGallery::readFolder() to read the files in the folder, to store the images in the {@link imageGallery::$images} property 
  * 
  * @return void
  * 
  * 
  * @version 1.0
  * <br />
  * <b>ChangeLog</b><br />
  *    - 1.0 initial release
  * 
  */
  function imageGallery($folder) {
    
    // The absolut path of the webserver
    define('DOCUMENTROOT',$_SERVER["DOCUMENT_ROOT"]);
    
    // read folder
    $files = $this->readFolder($folder);
   
    $count = 0;
    if(is_array($files)) {
      foreach($files as $file) {
        
        // get title
        //if(strtolower(basename($file)) == 'title.txt')
          //$this->title = @htmlentities(@file_get_contents(DOCUMENTROOT.$file));
  
        // get previewImage
        //if(strtolower(basename($file)) == 'previewimage.txt')
          //$this->previewImage = @file_get_contents(DOCUMENTROOT.$file);
        
        // get image texts
        if(strtolower(basename($file)) == 'texts.txt') {
          $newImageTexts = array();
          if($imageTexts = @file(DOCUMENTROOT.$file)) {
            foreach($imageTexts as $imageText) {
              $filename = substr($imageText,0,strpos($imageText,' '));
              $text = substr($imageText,strpos($imageText,' ') + 1);            
              $newImageTexts[$filename] = $text;
            }
            $imageTexts = $newImageTexts;
          }
        }
        
        // get images
        $fileExtension = strtolower(pathinfo($file, PATHINFO_EXTENSION));
        if($fileExtension == 'jpg' || $fileExtension == 'jpeg' || $fileExtension == 'png' || $fileExtension == 'gif') {
          $this->galleryPath = dirname($file).'/';
          
          $this->images[$count]['filename'] = basename($file);        
          $this->images[$count]['text'] = (is_array($imageTexts) && array_key_exists($this->images[$count]['filename'],$imageTexts))
            ? $imageTexts[$this->images[$count]['filename']] : '' ;
          $count++;
        }
      }
    }
  }
  
 /* ---------------------------------------------------------------------------------------------------------------------------- */
 /* *** METHODS *** */
 /* **************************************************************************************************************************** */
 
  /**
  * <b>Name</b> readFolder()<br />
  * 
  * Reads a folder and return it's files.
  * 
  * 
  * <b>Used Constants</b><br />
  *    - <var>DOCUMENTROOT</var> the absolut path of the webserver
  * 
  * @param string $folder the absolute path of an folder to read
  * 
  * @return array|false an array with the folder elements, FALSE if the folder is not a directory
  * 
  * @version 1.0
  * <br />
  * <b>ChangeLog</b><br />
  *    - 1.0 initial release
  * 
  */
  function readFolder($folder) {
    
    if(empty($folder))
      return false;
    
    //change windows path
    $folder = str_replace('\\','/',$folder);
    
    // -> adds / on the beginning of the folder
    if(substr($folder,0,1) != '/')
      $folder = '/'.$folder;
    // -> adds / on the end of the folder
    if(substr($folder,-1) != '/')
      $folder .= '/';
    
    //clean vars  
    $folder = preg_replace("/\/+/", '/', $folder);
    $folder = str_replace('/'.DOCUMENTROOT,DOCUMENTROOT,$folder);  
    
    // vars
    $return = false;  
    $fullFolder = $folder;
    
    // adds the DOCUMENTROOT  
    $fullFolder = str_replace(DOCUMENTROOT,'',$fullFolder);  
    $fullFolder = DOCUMENTROOT.$fullFolder;
    
    // open the folder and read the content
    if(is_dir($fullFolder)) {
      $openedDir = @opendir($fullFolder);  // @ zeichen eingefügt
      while(false !== ($inDirObjects = @readdir($openedDir))) {
        if($inDirObjects != "." && $inDirObjects != "..") {
          if(is_file($fullFolder.$inDirObjects)) {
            $return[] = $folder.$inDirObjects;
          }
        }
      }
      @closedir($openedDir);
    }    
    return $return;  
  }
 
 /**
  * <b>Name</b> resize()<br />
  * 
  * Resize an image by the given image parameters and returns the image link resource.
  * 
  * <b>Used Constants</b><br />
  *    - <var>DOCUMENTROOT</var> the absolut path of the webserver
  * 
  * @param string $imagePath the absolut path to the image 
  * 
  * @return resource|false the image link resource to save with imagejpeg() or imagepng() or FALSE if the image couldn't be resized
  * 
  * @version 1.0
  * <br />
  * <b>ChangeLog</b><br />
  *    - 1.0 initial release
  * 
  */
  function resize($imagePath,$imageWidth,$imageHeight) {
    ini_set('memory_limit', '100M');   //  handle large images
    
    // quit if no image sizes are set
    if(empty($imageWidth) && empty($imageHeight))
      return false;
    
    // vars
    $imageExtension = pathinfo($imagePath, PATHINFO_EXTENSION);    
    $imagesize = getimagesize(DOCUMENTROOT.$imagePath);
      
    // -> CALCULATE the RATIO, IF RATIO is X or Y
    // RATIO X
    if(!empty($imageWidth) && empty($imageHeight)) {
      $ratio = $imagesize[0] / $imagesize[1];
      $imageHeight = $imageWidth / $ratio;
      $imageHeight = round($imageHeight);
    }  
    // RATIO Y
    if(empty($imageWidth) && !empty($imageHeight)) {
      $ratio = $imagesize[1] / $imagesize[0];
      $imageWidth = $imageHeight / $ratio;
      $imageWidth = round($imageWidth);
    }
    
    // GETIMAGE gif
    if($imageExtension == 'gif')
      $oldImg = imagecreatefromgif(DOCUMENTROOT.$imagePath);
    // GETIMAGE jpg
    if($imageExtension == 'jpg' || $imageExtension == 'jpeg')
      $oldImg = imagecreatefromjpeg(DOCUMENTROOT.$imagePath);
    // GETIMAGE png
    if($imageExtension == 'png')
      $oldImg = imagecreatefrompng(DOCUMENTROOT.$imagePath);  
      
    // create a blank image
    $newImg = imagecreatetruecolor($imageWidth, $imageHeight);
    
    // resize (ERROR)
    if(imagecopyresampled($newImg, $oldImg, 0,0,0,0,$imageWidth,$imageHeight,$imagesize[0],$imagesize[1])) {
      // clean memory
      imagedestroy($oldImg);
      return $newImg;
    } else {
      // clean memory
      imagedestroy($oldImg);
      return false;
    }
  }
 
 /**
  * <b>Name</b> resizeImages()<br />
  * 
  * Resize the images to the size set in the {@link imageGallery::$imageWidth} and {@link imageGallery::$imageHeight} property.
  * 
  * <b>Used Constants</b><br />
  *    - <var>DOCUMENTROOT</var> the absolut path of the webserver  
  * 
  * @return bool TRUE if all images could be resized, otherwise FALSE
  * 
  * @uses imageGallery::$imageWidth
  * @uses imageGallery::$imageHeight
  * @uses imageGallery::$galleryPath  
  * @uses imageGallery::resize()
  * @uses imageGallery::readFolder() to read the files in the folder to check if thumbnails are obsolete
  * 
  * @version 1.0
  * <br />
  * <b>ChangeLog</b><br />
  *    - 1.0 initial release
  * 
  */
  function resizeImages() {
    
    // quit if no image sizes are set
    if(empty($this->imageWidth) && empty($this->imageHeight))
      return false;
    
    // ->> DELTE OLD THUMBNAILS
    $thumbnails = $this->readFolder($this->galleryPath.'thumbnails/');
    
    if(is_array($thumbnails)) {
      $oldThumbnails = $thumbnails;
      // -> CHECK for old thumbnails
      foreach($this->images as $image) {
        if(in_array($this->galleryPath.'thumbnails/thumb_'.$image['filename'],$thumbnails)) {
          // unset the thumbnail which are still valid
          foreach($oldThumbnails as $key => $value) {
            if($value == $this->galleryPath.'thumbnails/thumb_'.$image['filename']) unset($oldThumbnails[$key]);
          }
        }
      }
      
      foreach($oldThumbnails as $oldThumbnail) {
        // -> delete old thumbnails
        $fileExtension = strtolower(pathinfo($oldThumbnail, PATHINFO_EXTENSION));
        if($fileExtension == 'jpg' || $fileExtension == 'jpeg' || $fileExtension == 'png' || $fileExtension == 'gif') {
          @unlink(DOCUMENTROOT.$oldThumbnail);
        }
      }
    }
    
    // ->> RESIZE THUMBNAILS
    foreach($this->images as $image) {
      
      // vars
      $imagePath = $this->galleryPath.$image['filename'];      
      $imageSize = getimagesize(DOCUMENTROOT.$imagePath);
      $sizeDifference = ((empty($this->imageHeight) && $this->imageWidth == $imageSize[0]) || (empty($this->imageWidth) && $this->imageHeight == $imageSize[1]) || ($this->imageWidth  == $imageSize[0] && $this->imageHeight == $imageSize[1]))
        ? false
        : true;
      
      // resize every image      
      if($sizeDifference && ($newImg = $this->resize($imagePath,$this->imageWidth,$this->imageHeight))) {
        
        // var        
        $imageExtension = pathinfo($image['filename'], PATHINFO_EXTENSION);
        
        // deletes the uploaded original file
        unlink(DOCUMENTROOT.$imagePath);
        
        // SAVEIMAGE png
        if($imageExtension == 'gif')
          imagegif($newImg,DOCUMENTROOT.$imagePath);
        // SAVEIMAGE jpg
        if($imageExtension == 'jpg' || $imageExtension == 'jpeg')
          imagejpeg($newImg,DOCUMENTROOT.$imagePath,100);
        // SAVEIMAGE png
        if($imageExtension == 'png')
          imagepng($newImg,DOCUMENTROOT.$imagePath);
        
        // clean memory
        imagedestroy($newImg);
        
        $return = true;
      } else
        $return = false;
    }
    
    return $return;
  }
  
 /**
  * <b>Name</b> createThumbnails()<br />
  * 
  * Resize the images to the size set in the {@link imageGallery::$thumbnailWidth} and {@link imageGallery::$thumbnailHeight} property and copy them to a "thumbnails/" subfolder. 
  * 
  * b>Used Constants</b><br />
  *    - <var>DOCUMENTROOT</var> the absolut path of the webserver
  * 
  * @return bool TRUE if all images could be resized, otherwise FALSE
  * 
  * @uses imageGallery::$thumbnailWidth
  * @uses imageGallery::$thumbnailHeight
  * @uses imageGallery::$galleryPath  
  * @uses imageGallery::resize()
  * 
  * @version 1.0
  * <br />
  * <b>ChangeLog</b><br />
  *    - 1.0 initial release
  * 
  */
  function createThumbnails() {
    
    // quit if no image sizes are set
    if(empty($this->thumbnailWidth) && empty($this->thumbnailHeight))
      return false;
    
    
    
    // resize every image
    foreach($this->images as $image) {
    
      // vars
      $thumbnailPath = $this->galleryPath.'thumbnails/thumb_'.$image['filename'];
      $imagePath = $this->galleryPath.$image['filename'];
      $thumbnailSize = @getimagesize(DOCUMENTROOT.$thumbnailPath);
      $sizeDifference = ((empty($this->thumbnailHeight) && $this->thumbnailWidth == $thumbnailSize[0]) || (empty($this->thumbnailWidth) && $this->thumbnailHeight == $thumbnailSize[1]) || ($this->thumbnailWidth  == $thumbnailSize[0] && $this->thumbnailHeight == $thumbnailSize[1]))
        ? false
        : true;
        
      // create the thumbnail folder
      if(!is_dir(DOCUMENTROOT.$this->galleryPath.'thumbnails/'))
        if(!mkdir(DOCUMENTROOT.$this->galleryPath.'thumbnails/'))
          return false;
      
      // resize every thumbnail      
      if((!file_exists(DOCUMENTROOT.$this->galleryPath.'thumbnails/thumb_'.$image['filename']) || $sizeDifference) && ($newImg = $this->resize($imagePath,$this->thumbnailWidth,$this->thumbnailHeight))) {
        
        // var        
        $imageExtension = pathinfo($image['filename'], PATHINFO_EXTENSION);
        
        // SAVEIMAGE png
        if($imageExtension == 'gif')
          imagegif($newImg,DOCUMENTROOT.$thumbnailPath);
        // SAVEIMAGE jpg
        if($imageExtension == 'jpg' || $imageExtension == 'jpeg')
          imagejpeg($newImg,DOCUMENTROOT.$thumbnailPath,100);
        // SAVEIMAGE png
        if($imageExtension == 'png')
          imagepng($newImg,DOCUMENTROOT.$thumbnailPath);
        
        // clean memory
        imagedestroy($newImg);
        
        $return = true;
      } else
        $return = false;
    }
    
    return $return;
  }
  
 /**
  * <b>Name</b> getImages()<br />
  * 
  * Generates the image links and return them in an array.
  * 
  * @return array an array with image links
  * 
  * @uses imageGallery::$galleryPath  
  * 
  * @version 1.0
  * <br />
  * <b>ChangeLog</b><br />
  *    - 1.0 initial release
  * 
  */
  function getImages() {
    
    // var
    $return = array();
    
    foreach($this->images as $image) {
      $imageText = (!empty($image['text'])) ? ' title="'.$image['text'].'"' : '';    
      $return[] = '<a href="'.$this->galleryPath.$image['filename'].'" rel="lightbox-gallery"'.$imageText.'><img src="'.$this->galleryPath.'thumbnails/thumb_'.$image['filename'].'" alt="thumbnail" /></a>';
    }    
    return $return;    
  }

 /**
  * <b>Name</b> createLinkToGallery()<br />
  * 
  * Generates a link to the gallery which shows the {@link imageGallery::$previewImage preview image} and the {@link imageGallery::$title gallery title}.
  * 
  * 
  * @return string the link to the gallery
  * 
  * @uses imageGallery::$galleryPath
  * 
  * @version 1.0
  * <br />
  * <b>ChangeLog</b><br />
  *    - 1.0 initial release
  * 
  */
  function createLinkToGallery() {
    $previewImagePath = $this->galleryPath.'thumbnails/thumb_'.$this->previewImage;
    $previewImageSize = @getimagesize(DOCUMENTROOT.$previewImagePath);
    
    $previewImage = (!empty($this->previewImage)) ? '<img src="'.$previewImagePath.'" alt="previewImage" />' : '';
    $linkUrl = (strpos($_SERVER['REQUEST_URI'],'?') === false) ? $_SERVER['REQUEST_URI'].'?gallery=' : $_SERVER['REQUEST_URI'].'&amp;gallery=';
    
    return '<a href="'.$linkUrl.$this->galleryPath.'">'.$previewImage.'<br />'.$this->title.'</a>';    
  }
  
 /**
  * <b>Name</b> showGallery()<br />
  * 
  * Generates the gallery for displaying in an HTML-page
  * 
  * @param string $tag         the tag used to create the gallery, can be "ul", "table" or FALSE to return just images
  * @param int    @breakAfter  if the $tag parameter is "table" then it defines the number after which the table makes a new row
  *  
  * @return string the generated gallery
  * 
  * @uses imageGallery::resizeImages()      to check if the images must be resized first and do it
  * @uses imageGallery::createThumbnail()   to check if thumbnails must be created first
  * 
  * @version 1.0
  * <br />
  * <b>ChangeLog</b><br />
  *    - 1.0 initial release
  * 
  */
  function showGallery($tag,$breakAfter) {
    
    // CHECK and DO
    $this->resizeImages();
    $this->createThumbnails();
    
    // vars
    if(is_string($tag)) {
      $startTag = '<'.$tag.'>';
      $endTag = '</'.$tag.'>';
    }
    
    // creating the START TR tag
    if($tag == 'table')
      $startTag .= '<tr>';
    
    // SHOW START-TAG
    if(!is_bool($tag)) {
      $gallery .= $startTag;
    }
    
    $count = 1;
    foreach($this->getImages() as $image) {
          
      // breaks the CELLs with TR after the given NUMBER of CELLS
      if($tag == 'table' &&
         is_numeric($breakAfter) &&
         ($breakAfter + 1) == $count) {
        $gallery .= "\n</tr><tr>\n";
        $count = 1;
      }
      
      // if menuTag is a LIST ------
      if($tag == 'ul' || $tag == 'ol') {
        $image = '<li>'.$image."</li>\n";        
      // if menuTag is a TABLE -----
      } elseif($tag == 'table')
        $image = "<td>\n".$image."\n</td>";
      
      // add image to the gallery
      $gallery .= $image;
      
      // count the table cells
      $count++;
    }
    
    // fills in the missing TABLE CELLs
    while($tag == 'table' &&
          is_numeric($breakAfter) &&
          $breakAfter >= $count) {
      $gallery .= "<td></td>\n";
      $count++;
    }
    
    // creating the END TR tag
    if($tag == 'table')
      $endTag = "</tr>\n".$endTag;
    
    // SHOW END-TAG
    if($startTag) {
      $gallery .= $endTag;
    }
    
    // RETURN
    return $gallery;
  }
  
}
?>