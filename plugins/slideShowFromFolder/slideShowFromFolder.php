<?php
/* slideShowFromFolder plugin */
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
 * This file contains the {@link slideShowFromFolder} class.
 * 
 * @package [Plugins]
 * @subpackage slideShowFromFolder
 */

/**
* slideShowFromFolder Plugin class
* 
* This class reads an folder and creates a gallery out of the pictures in it.
* 
* Also looks if a "texts.txt" or "captions.txt" exists, to get image captions. The captions in this file must have the following format:
* <samp>
* filename.jpg###Text which sould apear under the image, when zoomed in
* otherFilname.png###Another text which describes the picture
* ...
* </samp> 
*
* <b>Note</b>: works only with "png", "gif" and "jpg" or "jpeg" filetypes.
* <b>Note</b>: The image gallery is surrounded by an '<div class="feinduraPlugin_slideShowFromFolder">' tag to help to style the image gallery. 
* 
* @author Fabian Vogelsteller <fabian@feindura.org>
* @copyright Fabian Vogelsteller
* @license http://www.gnu.org/licenses GNU General Public License version 3
* 
* @package [Plugins]
* @subpackage slideShowFromFolder
* 
* @version 1.11
* <br>
* <b>ChangeLog</b><br>
*    - 1.11 add milkbox as lightbox
*    - 1.1 removed resize() because it uses now the {@link Image} class
*    - 1.02 fixed image texts
*    - 1.01 fixed file extension, made to lowercase
*    - 1.0 initial release
* 
*/
class slideShowFromFolder {
  
 /* ---------------------------------------------------------------------------------------------------------------------------- */
 /* *** PROPERTIES */
 /* **************************************************************************************************************************** */

/**
  * You can set the document root manually.
  * 
  * @var int
  * @access protected
  * 
  */
  public $documentRoot = null;

 /**
  * TRUE when the pages content should be handled as XHTML
  *
  * In XHTML standalone tags end with " />" instead of ">".<br>
  * Therefor when a page content is displayed and this property is <i>FALSE</i> all " />" will be changed to ">".
  * 
  * @var bool
  * @access public
  * 
  */
  public $xHtml = true;
  
 /**
  * TRUE when images shopuld also be resized, even if they are smaller, than the set width, or height values.
  * 
  * @var int
  * @access public
  * @see slideShowFromFolder::$imageHeight
  * @see slideShowFromFolder::$imageWidth
  * @see slideShowFromFolder::resize()
  * 
  */
  public $resizeWhenSmaller = false;

 /**
  * If TRUE the original ratio will be used, when resizing the images.
  * 
  * If this property is FALSE and only width or height is set, it even though keeps the ratio.
  * 
  * 
  * @var int
  * @access public
  * @see slideShowFromFolder::$imageHeight
  * @see slideShowFromFolder::$imageWidth
  * @see slideShowFromFolder::resize()
  * 
  */
  public $keepRatio = true;

 /**
  * The slideshow container width.
  * 
  * @var int
  * @access public
  * @see slideShow::show()
  * 
  */
  public $width = 600;
  
 /**
  * The slideshow container height.
  * 
  * @var int
  * @access public
  * @see slideShow::show()
  * 
  */
  public $height = 350;

 /**
  * The maximal width of the pictures
  * 
  * All pictures will be resized to this width when the {@link slideShowFromFolder::resizeImages()} method is called.
  * 
  * <b>Note</b>: If the {@link slideShowFromFolder::$imageHeight} property is null, it keeps the aspect ratio of the images.
  * 
  * @var int
  * @access public
  * @see slideShowFromFolder::$imageHeight
  * @see slideShowFromFolder::resizeImages()
  * 
  */
  public $imageWidth = 600;
  
 /**
  * The maximal height of the pictures
  * 
  * All pictures will be resized to this height when the {@link resizeImages()} method is called.
  * 
  * <b>Note</b>: If the {@link slideShowFromFolder::$imageWidth} property is null, it keeps the aspect ratio of the images.
  * 
  * @var int
  * @access public
  * @see slideShowFromFolder::$imageWidth
  * @see slideShowFromFolder::resizeImages()
  * 
  */
  public $imageHeight = 350;
  
 /**
  * An array which contains all image filenames and paths
  * 
  * Example Array:
  * {@example plugins/slideShowFromFolder/images.array.example.php}
  * 
  * @var array
  * @access protected
  * 
  */
  protected $images = array();
  
/**
  * The absolute path to the gallery
  * 
  * @var string
  * @access protected
  * 
  */
  protected $path;
  
/**
  * The title of the gallery, retrieved from the "title.txt"
  * 
  * @var string
  * @access protected
  * 
  */
  protected $title = 'unnamed';
  
/**
  * the timestamp of the latest modification of the files
  * 
  * @var int
  * @access protected
  * 
  */
  protected $lastModification = 0;
  
  
 /**
  * <b>Type</b> constructor<br>
  * 
  * The constructor of the class, sets all basic properties.
  * 
  * Also looks if a "texts.txt" or "captions.txt" exists, to get image captions. The captions in this file must have the following format:
  * <samp>
  * filename.jpg###Text which sould apear under the image, when zoomed in
  * otherFilname.png###Another text which describes the picture
  * ...
  * </samp>
  * 
  * @param string $folder the absolut path of the folder from where a gallery should be created
  * 
  * @uses slideShowFromFolder::readFolder() to read the files in the folder, to store the images in the {@link slideShowFromFolder::$images} property 
  * 
  * @return void
  * 
  * @access public
  * @version 1.0
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.0 initial release
  * 
  */
  public function __construct($folder,$documentRoot = false) {
    @ini_set('memory_limit', '120M');   //  handle large images
    
    // vars
    $this->documentRoot = ($documentRoot === False) ? $_SERVER['DOCUMENT_ROOT'] : $documentRoot;
    
    // clerars the cache from other operations
    clearstatcache();
    
    // read folder
    $files = $this->readFolder($folder);

    $count = 0;
    if(is_array($files)) {
      
      // get image texts
      foreach($files as $file) {
        // get title
        if(strtolower(basename($file)) == 'title.txt')
          $this->title = @htmlentities(@file_get_contents($this->documentRoot.$file),ENT_QUOTES,'UTF-8');
  
        // get previewImage
        if(strtolower(basename($file)) == 'previewimage.txt')
          $this->previewImage = @file_get_contents($this->documentRoot.$file);
        
        if(strtolower(basename($file)) == 'text.txt' || strtolower(basename($file)) == 'texts.txt' || strtolower(basename($file)) == 'captions.txt') {
          $newImageTexts = array();
          if($imageTexts = @file($this->documentRoot.$file)) {
            foreach($imageTexts as $imageText) {
              $imageText = explode('###',$imageText);
              $filename = trim($imageText[0]);
              $text = trim($imageText[1]);
              $newImageTexts[$filename] = $text;
            }         
            $imageTexts = XssFilter::text($newImageTexts);
          }
        }
      }
    
      natcasesort($files);
      foreach($files as $file) {
        
        // get images
        $fileExtension = strtolower(pathinfo($file, PATHINFO_EXTENSION));
        if($fileExtension == 'jpg' || $fileExtension == 'jpeg' || $fileExtension == 'png' || $fileExtension == 'gif') {
          $this->path = dirname($file).'/';
          
          $this->images[$count]['filename'] = basename($file);
          $this->images[$count]['text'] = (is_array($imageTexts) && array_key_exists($this->images[$count]['filename'],$imageTexts))
            ? $imageTexts[$this->images[$count]['filename']]
            : '' ;
          
          // get the latest modification
          if(($lastMovement = @filectime($this->documentRoot.$file)) > $this->lastModification)
            $this->lastModification = $lastMovement;
          if(($lastModification = @filemtime($this->documentRoot.$file)) > $this->lastModification)
            $this->lastModification = $lastModification;
          
          $count++;
        }
      }
    }
  }
  
 /* ---------------------------------------------------------------------------------------------------------------------------- */
 /* *** METHODS *** */
 /* **************************************************************************************************************************** */
 
  /**
  * <b>Name</b> readFolder()<br>
  * 
  * Reads a folder and return it's files.
  * 
  * 
  * @param string $folder the absolute path of an folder to read
  * 
  * @return array|false an array with the folder elements, FALSE if the folder is not a directory
  * 
  * @access private
  * @version 1.0
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.0 initial release
  * 
  */
  private function readFolder($folder) {
    
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
    $folder = str_replace(array('/'.$this->documentRoot,$this->documentRoot),'',$folder);  
    
    // vars
    $return = false;  
    $fullFolder = $folder;
    
    // adds the $this->documentRoot
    $fullFolder = str_replace($this->documentRoot,'',$fullFolder);  
    $fullFolder = $this->documentRoot.$fullFolder;
    
    // open the folder and read the content
    if(is_dir($fullFolder)) {
      $readFolder = scandir($fullFolder);      
      foreach($readFolder as $inDirObject) {
        if($inDirObject != "." && $inDirObject != ".." && is_file($fullFolder.$inDirObject)) {         
          $return[] = $folder.$inDirObject;
        }
      }
    }
    
    return $return;  
  }
 
 /**
  * <b>Name</b> resizeImages()<br>
  * 
  * Resize the images to the size set in the {@link slideShowFromFolder::$imageWidth} and {@link slideShowFromFolder::$imageHeight} property.
  * 
  * 
  * @return bool TRUE if all images could be resized, otherwise FALSE
  * 
  * @uses slideShowFromFolder::$imageWidth
  * @uses slideShowFromFolder::$imageHeight
  * @uses slideShowFromFolder::$path  
  * @uses slideShowFromFolder::resize()
  * @uses slideShowFromFolder::readFolder() to read the files in the folder
  * 
  * @access protected
  * @version 1.0
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.0 initial release
  * 
  */
  protected function resizeImages() {    
    
    // quit if no image sizes are set
    if(empty($this->imageWidth) && empty($this->imageHeight))
      return false;
      
    // ->> RESIZE IMAGES
    foreach($this->images as $image) {
      
      // vars
      $imagePath = $this->path.$image['filename'];      
      $imageSize = getimagesize($this->documentRoot.$imagePath);
      $sizeDifference = ((empty($this->imageHeight) && $this->imageWidth >= $imageSize[0]) || (empty($this->imageWidth) && $this->imageHeight >= $imageSize[1]) || ($this->imageWidth  == $imageSize[0] && $this->imageHeight == $imageSize[1]))
        ? false
        : true;
     
      // resize every image      
      if($sizeDifference) {
        
        // get the Image class
        if(!class_exists(Image,false))
          require_once(dirname(__FILE__).'/includes/Image.class.php');
        
        // wont resize the height so it overflows the slideshow, looks better
        $resize = new Image($imagePath);
        $resize->resize($this->imageWidth,$this->imageHeight,$this->keepRatio,$this->resizeWhenSmaller);
        $resize->process();
        unset($resize);
        
        $return = true;
      } else
        $return = false;
    }
    
    // -> create a timestamp when the gallery was edited
    if($file = @fopen($this->documentRoot.$this->path.'lastmodification.log',"wb")) {
      flock($file,LOCK_EX);
        fwrite($file,time());
      flock($file,LOCK_UN);
      fclose($file);    
    }
    
    return $return;
  }
  
 /**
  * <b>Name</b> getImages()<br>
  * 
  * Generates the image links and return them in an array.
  * 
  * @return array an array with image links
  * 
  * @uses slideShowFromFolder::$path
  * @uses XssFilter::text  
  * 
  * @access protected
  * @version 1.0
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.0 initial release
  * 
  */
  protected function getImages() {
    
    // var
    $return = array();
    $tagEnd = ($this->xHtml === true) ? ' />' : '>';
    
    foreach($this->images as $image) {
      $imageText = (!empty($image['text'])) ? ' title="'.XssFilter::text($image['text']).'"' : '';//' title="'.$image['filename'].'"';
      $return[] = '<img src="'.GeneralFunctions::Path2URI($this->path).$image['filename'].'" alt="slideShowImage"'.$imageText.$tagEnd."\n";
    }
    
    return $return;    
  }
  
 /**
  * <b>Name</b> show()<br>
  * 
  * Generates the slide show for displaying in an HTML-page
  * 
  * <b>Note</b>: The slide show div tag has also a 'class="feinduraPlugin_slideShowFromFolder nivoo-slider"' attribute for styling.  
  * 
  * @param string       $containerId  the ID if the container div, which holds the slideShowFromFolder
  * @param array        $pageContent (optional) the $pageContent array of the page which uses the plugin, to compare the last edit date with the one from the "lastmodification.log"
  * 
  * @return string the generated slide show
  * 
  * @uses slideShowFromFolder::resizeImages()      to check if the images must be resized first and do it
  * 
  * @access public
  * @version 1.0
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.0 initial release
  * 
  */
  public function show($containerId, $pageContent = false) {    
    
    // CHECK if a $pageContent array is given
    $lastEditTimestamp = @file_get_contents($this->documentRoot.$this->path.'lastmodification.log');
    // -> check if the timestamp of the lastmodification is newer than the one saved in the "lastmodification.log"
    //echo $this->lastModification.' > '.$lastEditTimestamp;
    if(($pageContent && $pageContent['lastSaveDate'] > $lastEditTimestamp) || $this->lastModification > $lastEditTimestamp) {
      $this->resizeImages();
    }
    
    // add images
    foreach($this->getImages() as $image) {
      // add image to the gallery
      $slideShowFromFolder .= $image;
    }
    
    // RETURN
    return '<div id="'.$containerId.'" class="nivoo-slider" style="width:'.$this->width.'px; height:'.$this->height.'px;">'.$slideShowFromFolder.'</div>';
  }  
}
?>