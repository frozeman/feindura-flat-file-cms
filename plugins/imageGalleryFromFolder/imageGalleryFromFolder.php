<?php
/* imageGalleryFromFolder plugin */
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
 * This file contains the {@link imageGalleryFromFolder} class.
 *
 * @package [Plugins]
 * @subpackage imageGalleryFromFolder
 */

/**
* imageGalleryFromFolder Plugin class
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
* <b>Note</b>: The image gallery is surrounded by an '<div class="feinduraPlugin_imageGalleryFromFolder">' tag to help to style the image gallery.
*
* @author Fabian Vogelsteller <fabian@feindura.org>
* @copyright Fabian Vogelsteller
* @license http://www.gnu.org/licenses GNU General Public License version 3
*
* @package [Plugins]
* @subpackage imageGalleryFromFolder
*
* @version 1.3
* <br>
* <b>ChangeLog</b><br>
*    - 1.3 fixed image resizing when havein both the height and the width of the thumbnail given
*    - 1.2 add fixed thumbnails by adding image as background url, if width and height of the thumbnail is given
*    - 1.11 add milkbox as lightbox
*    - 1.1 removed resize() because it uses now the {@link Image} class
*    - 1.02 fixed image texts
*    - 1.01 fixed file extension, made to lowercase
*    - 1.0 initial release
*
*/
class imageGalleryFromFolder {

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
  * @see imageGalleryFromFolder::$imageHeight
  * @see imageGalleryFromFolder::$imageWidth
  * @see imageGalleryFromFolder::$thumbnailHeight
  * @see imageGalleryFromFolder::$thumbnailWidth
  * @see imageGalleryFromFolder::resize()
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
  * @see imageGalleryFromFolder::$imageHeight
  * @see imageGalleryFromFolder::$imageWidth
  * @see imageGalleryFromFolder::$thumbnailHeight
  * @see imageGalleryFromFolder::$thumbnailWidth
  * @see imageGalleryFromFolder::resize()
  *
  */
  public $keepRatio = true;

 /**
  * The maximal width of the pictures
  *
  * All pictures will be resized to this width when the {@link imageGalleryFromFolder::resizeImages()} method is called.
  *
  * <b>Note</b>: If the {@link imageGalleryFromFolder::$imageHeight} property is null, it keeps the aspect ratio of the images.
  *
  * @var int
  * @access public
  * @see imageGalleryFromFolder::$imageHeight
  * @see imageGalleryFromFolder::resizeImages()
  *
  */
  public $imageWidth = 800;

 /**
  * The maximal height of the pictures
  *
  * All pictures will be resized to this height when the {@link resizeImages()} method is called.
  *
  * <b>Note</b>: If the {@link imageGalleryFromFolder::$imageWidth} property is null, it keeps the aspect ratio of the images.
  *
  * @var int
  * @access public
  * @see imageGalleryFromFolder::$imageWidth
  * @see imageGalleryFromFolder::resizeImages()
  *
  */
  public $imageHeight = null;

 /**
  * The maximal width of the thumbnails of the pictures
  *
  * the thumbnails will be created with this width when the {@link imageGalleryFromFolder::createThumbanils()} method is called.
  *
  * <b>Note</b>: If the {@link imageGalleryFromFolder::$thumbnailHeight} property is null, it keeps the aspect ratio of the images.
  *
  * @var int
  * @access public
  * @see imageGalleryFromFolder::$thumbnailHeight
  * @see imageGalleryFromFolder::createThumbanils()
  *
  */
  public $thumbnailWidth = 100;

 /**
  * The maximal height of the thumbnails of the pictures
  *
  * the thumbnails will be created with this height when the {@link imageGalleryFromFolder::createThumbanils()} method is called.
  *
  * <b>Note</b>: If the {@link imageGalleryFromFolder::$thumbnailWidth} property is null, it keeps the aspect ratio of the images.
  *
  * @var int
  * @access public
  * @see imageGalleryFromFolder::$thumbnailWidth
  * @see imageGalleryFromFolder::createThumbanils()
  *
  */
  public $thumbnailHeight = null;

 /**
  * A path to and 1px x 1px empty gif image, which is needed when adding the image as background when specifing width and height.
  *
  * @var bool
  * @access public
  * @see imageGallery::getImages()
  *
  */
  public $emptyImage = false;

 /**
  * If this is TRUE it uses the filename as captions, when no line in a captions.txt exist for this file.
  *
  * @var bool
  * @access public
  * @see imageGalleryFromFolder::getImages()
  *
  */
  public $filenameCaptions = false;

 /**
  * An array which contains all image filenames and paths
  *
  * Example Array:
  * {@example plugins/imageGalleryFromFolder/images.array.example.php}
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
  protected $galleryPath;

/**
  * The title of the gallery, retrieved from the "title.txt"
  *
  * @var string
  * @access protected
  *
  */
  protected $title = 'unnamed';

/**
  * The image which is shown as the preview image of the gallery, retrieved from the "previewImage.txt"
  *
  * @var string
  * @access protected
  *
  */
  protected $previewImage;

/**
  * the timestamp of the latest modification of the files
  *
  * @var int
  * @access protected
  *
  */
  protected $lastModification = 0;

/**
  * A unique ID which each imageGalleryFromFolder gets to separate them.
  *
  * @var int
  * @access protected
  *
  */
  protected $uniqueId = null;


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
  * @uses imageGalleryFromFolder::$GeneralFunctions
  * @uses imageGalleryFromFolder::readFolder() to read the files in the folder, to store the images in the {@link imageGalleryFromFolder::$images} property
  *
  * @return void
  *
  * @access public
  * @version 1.02
  * <br>
  * <b>ChangeLog</b><br>
  *    - changed thumbnail names to "thumb_filename_jpg.png"
  *    - 1.01 fixed image texts
  *    - 1.0 initial release
  *
  */
  public function __construct($folder,$documentRoot = false) {
    @ini_set('memory_limit', '120M');   //  handle large images

    // vars
    $this->documentRoot = ($documentRoot === False) ? $_SERVER['DOCUMENT_ROOT'] : $documentRoot;

    // clerars the cache from other operations
    clearstatcache();

    // get unique id
    $this->uniqueId = uniqid();

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
            $imageTexts = $newImageTexts;
          }
        }
      }

      natcasesort($files);
      foreach($files as $file) {

        // get images
        $fileExtension = strtolower(pathinfo($file, PATHINFO_EXTENSION));
        if($fileExtension == 'jpg' || $fileExtension == 'jpeg' || $fileExtension == 'png' || $fileExtension == 'gif') {
          $this->galleryPath = dirname($file).'/';

          $this->images[$count]['filename'] = basename($file);
          $this->images[$count]['text'] = (is_array($imageTexts) && array_key_exists($this->images[$count]['filename'],$imageTexts))
            ? XssFilter::text($imageTexts[$this->images[$count]['filename']])
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
  * Resize the images to the size set in the {@link imageGalleryFromFolder::$imageWidth} and {@link imageGalleryFromFolder::$imageHeight} property.
  *
  *
  * @return bool TRUE if all images could be resized, otherwise FALSE
  *
  * @uses imageGalleryFromFolder::$imageWidth
  * @uses imageGalleryFromFolder::$imageHeight
  * @uses imageGalleryFromFolder::$galleryPath
  * @uses imageGalleryFromFolder::resize()
  * @uses imageGalleryFromFolder::readFolder() to read the files in the folder to check if thumbnails are obsolete
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
      $imagePath = $this->galleryPath.$image['filename'];
      $imageSize = getimagesize($this->documentRoot.$imagePath);
      $sizeDifference = ((empty($this->imageHeight) && $this->imageWidth == $imageSize[0]) || (empty($this->imageWidth) && $this->imageHeight == $imageSize[1]) || ($this->imageWidth  == $imageSize[0] && $this->imageHeight == $imageSize[1]))
        ? false
        : true;

      // resize every image
      if($sizeDifference) {

        // get the Image class
        if(!class_exists(Image,false))
          require_once(dirname(__FILE__).'/includes/Image.class.php');

        $resize = new Image($imagePath,$this->documentRoot);
        $resize->resize($this->imageWidth,$this->imageHeight,$this->keepRatio,$this->resizeWhenSmaller);
        $resize->process();
        unset($resize);

        $return = true;
      } else
        $return = false;
    }

    return $return;
  }

 /**
  * <b>Name</b> createThumbnails()<br>
  *
  * Resize the images to the size set in the {@link imageGalleryFromFolder::$thumbnailWidth} and {@link imageGalleryFromFolder::$thumbnailHeight} property and copy them to a "thumbnails/" subfolder.
  *
  *
  * @return bool TRUE if all images could be resized, otherwise FALSE
  *
  * @uses imageGalleryFromFolder::$thumbnailWidth
  * @uses imageGalleryFromFolder::$thumbnailHeight
  * @uses imageGalleryFromFolder::$galleryPath
  * @uses imageGalleryFromFolder::resize()
  *
  * @access protected
  * @version 1.0
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.0 initial release
  *
  */
  protected function createThumbnails() {

    // quit if no image sizes are set
    if(empty($this->thumbnailWidth) && empty($this->thumbnailHeight))
      return false;

    // ->> DELTE OLD THUMBNAILS
    $thumbnails = $this->readFolder($this->galleryPath.'thumbnails/');

    if(is_array($thumbnails)) {
      $oldThumbnails = $thumbnails;
      // -> CHECK for old thumbnails
      foreach($this->images as $image) {
        $thumbnailName = 'thumb_'.str_replace('.','_',$image['filename']).'.png';

        if(in_array($this->galleryPath.'thumbnails/'.$thumbnailName,$thumbnails)) {
          // unset the thumbnail which are still valid
          foreach($oldThumbnails as $key => $value) {
            if($value == $this->galleryPath.'thumbnails/'.$thumbnailName) unset($oldThumbnails[$key]);
          }
        }
      }

      foreach($oldThumbnails as $oldThumbnail) {
        // -> delete old thumbnails
        @unlink($this->documentRoot.$oldThumbnail);
      }
    }

    // resize every image
    foreach($this->images as $image) {

      // vars
      $thumbnailName = 'thumb_'.str_replace('.','_',$image['filename']).'.png';
      $thumbnailPath = $this->galleryPath.'thumbnails/'.$thumbnailName;
      $imagePath = $this->galleryPath.$image['filename'];
      $thumbnailSize = (file_exists($this->documentRoot.$thumbnailPath)) ? getimagesize($this->documentRoot.$thumbnailPath) : array(0,0);
      $imageSize = (file_exists($this->documentRoot.$imagePath)) ? getimagesize($this->documentRoot.$imagePath) : array(0,0);
      $sizeDifference = ((empty($this->thumbnailHeight) && $this->thumbnailWidth == $thumbnailSize[0]) || (empty($this->thumbnailWidth) && $this->thumbnailHeight == $thumbnailSize[1]) || ($this->thumbnailWidth  == $thumbnailSize[0] && $this->thumbnailHeight == $thumbnailSize[1]))
        ? false
        : true;

      // create the thumbnail folder
      if(!is_dir($this->documentRoot.$this->galleryPath.'thumbnails/'))
        if(!mkdir($this->documentRoot.$this->galleryPath.'thumbnails/'))
          return false;

      // resize every thumbnail
      if(!file_exists($this->documentRoot.$this->galleryPath.'thumbnails/'.$thumbnailName) || $sizeDifference) {

        // get the Image class
        require_once(dirname(__FILE__).'/includes/Image.class.php');

        // vars
        $width = $this->thumbnailWidth;
        $height = $this->thumbnailHeight;

        // resize either the height or the width, depending whats bigger, when width/height for the thumbnail was given
        if($imageRatio != 1 && !empty($this->thumbnailWidth) && !empty($this->thumbnailHeight) && is_numeric($this->thumbnailWidth) && is_numeric($this->thumbnailHeight)) {

          $imageRatio = $imageSize[0] / $imageSize[1];
          $thumbRatio = $this->thumbnailWidth / $this->thumbnailHeight;

          if($imageRatio >= 1 && $thumbRatio <= 1)
            $width = false;
          elseif($imageRatio <= 1 && $thumbRatio >= 1)
            $height = false;
          elseif($imageRatio >= 1 && $thumbRatio >= 1 && $imageRatio > $thumbRatio)
            $width = false;
          elseif($imageRatio >= 1 && $thumbRatio >= 1 && $imageRatio < $thumbRatio)
            $height = false;
        }

        $resize = new Image($imagePath,$this->documentRoot);
        $resize->resize($width,$height,$this->keepRatio,$this->resizeWhenSmaller);
        $resize->process('png',$this->documentRoot.$thumbnailPath);
        unset($resize);

        $return = true;
      } else
        $return = false;
    }

    // -> create a timestamp when the gallery was edited
    if($file = @fopen($this->documentRoot.$this->galleryPath.'thumbnails/lastmodification.log',"wb")) {
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
  * When both the thumbnail width and height are set, then it will add the image as background to the <img> tag.
  * This ensures that all images have the same size.
  *
  * @return array an array with image links
  *
  * @uses imageGalleryFromFolder::$galleryPath
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
      $thumbnailName = 'thumb_'.str_replace('.','_',$image['filename']).'.png';

      // add captions
      if($this->filenameCaptions)
        $imageText = (!empty($image['text'])) ? ' title="'.$image['text'].'"' : ' title="'.substr($image['filename'],0,strpos($image['filename'],'.')).'"';
      else
        $imageText = (!empty($image['text'])) ? ' title="'.$image['text'].'"' : '';

      if(!empty($this->thumbnailWidth) && !empty($this->thumbnailHeight) && is_numeric($this->thumbnailWidth) && is_numeric($this->thumbnailHeight))
        $return[] = '<a href="'.GeneralFunctions::Path2URI($this->galleryPath).$image['filename'].'" data-milkbox="imageGalleryFromFolder#'.$this->uniqueId.'"'.$imageText.' style="display:inline-block; width:'.$this->thumbnailWidth.'px; height:'.$this->thumbnailHeight.'px;"><img src="'.$this->emptyImage.'" alt="'.$image['text'].'" style="display: inline-block; background-size: cover; width:'.$this->thumbnailWidth.'px; height:'.$this->thumbnailHeight.'px; background: url(\''.GeneralFunctions::Path2URI($this->galleryPath).'thumbnails/'.$thumbnailName.'\') no-repeat center center;"'.$tagEnd.'</a>';
      else
        $return[] = '<a href="'.GeneralFunctions::Path2URI($this->galleryPath).$image['filename'].'" data-milkbox="imageGalleryFromFolder#'.$this->uniqueId.'"'.$imageText.' style="display:inline-block;"><img src="'.GeneralFunctions::Path2URI($this->galleryPath).'thumbnails/'.$thumbnailName.'" alt="'.$image['text'].'"'.$tagEnd.'</a>';
    }

    return $return;
  }

 /**
  * <b>Name</b> createLinkToGallery()<br>
  *
  * Generates a link to the gallery which shows the {@link imageGalleryFromFolder::$previewImage preview image} and the {@link imageGalleryFromFolder::$title gallery title}.
  *
  *
  * @return string the link to the gallery
  *
  * @uses imageGalleryFromFolder::$galleryPath
  *
  * @access public
  * @version 1.0
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.0 initial release
  *
  */
  public function createLinkToGallery() {
    //var
    $tagEnd = ($this->xHtml === true) ? ' />' : '>';

    $thumbnailName = 'thumb_'.str_replace('.','_',$this->previewImage).'.png';
    $previewImagePath = $this->galleryPath.'thumbnails/'.$thumbnailName;
    $previewImageSize = getimagesize($this->documentRoot.$previewImagePath);

    $previewImage = (!empty($this->previewImage)) ? '<img src="'.$previewImagePath.'" alt="previewImage"'.$tagEnd : '';
    $linkUrl = (strpos($_SERVER['REQUEST_URI'],'?') === false) ? $_SERVER['REQUEST_URI'].'?gallery=' : $_SERVER['REQUEST_URI'].'&amp;gallery=';

    return '<a href="'.$linkUrl.$this->galleryPath.'">'.$previewImage.'<br>'.$this->title.'</a>';
  }

 /**
  * <b>Name</b> showGallery()<br>
  *
  * Generates the gallery for displaying in an HTML-page
  *
  * <b>Note</b>: The image gallery is surrounded by an '<div class="feinduraPlugin_imageGalleryFromFolder">' tag to help to style the image gallery.
  *
  * @param string       $tag         the tag used to create the gallery, can be "ul","menu", "table" or FALSE to return just images
  * @param int          $breakAfter  (optional) if the $tag parameter is "table" then it defines the number after which the table makes a new row
  * @param array        $pageContent (optional) the $pageContent array of the page which uses the plugin, to compare the last edit date with the one from the "lastmodification.log"
  *
  * @return string the generated gallery
  *
  * @uses imageGalleryFromFolder::resizeImages()      to check if the images must be resized first and do it
  * @uses imageGalleryFromFolder::createThumbnail()   to check if thumbnails must be created first
  *
  * @access public
  * @version 1.0
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.0 initial release
  *
  */
  public function showGallery($tag, $breakAfter = false, $pageContent = false) {



    // CHECK if a $pageContent array is given
    $lastEditTimestamp = @file_get_contents($this->documentRoot.$this->galleryPath.'thumbnails/lastmodification.log');
    // -> check if the timestamp of the lastmodification is newer than the one saved in the "thumbnails/lastedit.log"
    //echo $this->lastModification.' > '.$lastEditTimestamp;
    if(($pageContent && $pageContent['lastSaveDate'] > $lastEditTimestamp) || $this->lastModification > $lastEditTimestamp) {
      $this->resizeImages();
      $this->createThumbnails();
    }

    // vars
    if(is_string($tag) && !empty($tag) && $tag != '-') {
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
      if($tag == 'ul' || $tag == 'ol' || $tag == 'menu') {
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