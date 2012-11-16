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
 * This file contains the {@link imageGallery} class.
 *
 * @package [Plugins]
 * @subpackage imageGallery
 */

/**
* imageGallery Plugin class
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
* <b>Note</b>: The image gallery is surrounded by an '<div class="feinduraPlugin_imageGallery">' tag to help to style the image gallery.
*
* @author Fabian Vogelsteller <fabian@feindura.org>
* @copyright Fabian Vogelsteller
* @license http://www.gnu.org/licenses GNU General Public License version 3
*
* @package [Plugins]
* @subpackage imageGallery
*
* @version 2.2
* <br>
* <b>ChangeLog</b><br>
*    - 2.2 fixed image resizing when havein both the height and the width of the thumbnail given
*    - 2.1 add fixed thumbnails by adding image as background url, if width and height of the thumbnail is given
*    - 2.0 changed to JSON data images
*    - 1.11 add milkbox as lightbox
*    - 1.1 removed resize() because it uses now the {@link Image} class
*    - 1.02 fixed image texts
*    - 1.01 fixed file extension, made to lowercase
*    - 1.0 initial release
*
*/
class imageGallery {

 /* ---------------------------------------------------------------------------------------------------------------------------- */
 /* *** PROPERTIES */
 /* **************************************************************************************************************************** */

/**
  * You can set the document root manually.
  *
  * @var string
  * @access public
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
  * @see imageGallery::$imageHeight
  * @see imageGallery::$imageWidth
  * @see imageGallery::$thumbnailHeight
  * @see imageGallery::$thumbnailWidth
  * @see imageGallery::resize()
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
  * @see imageGallery::$imageHeight
  * @see imageGallery::$imageWidth
  * @see imageGallery::$thumbnailHeight
  * @see imageGallery::$thumbnailWidth
  * @see imageGallery::resize()
  *
  */
  public $keepRatio = true;

 /**
  * The maximal width of the pictures
  *
  * All pictures will be resized to this width when the {@link imageGallery::resizeImages()} method is called.
  *
  * <b>Note</b>: If the {@link imageGallery::$imageHeight} property is null, it keeps the aspect ratio of the images.
  *
  * @var int
  * @access public
  * @see imageGallery::$imageHeight
  * @see imageGallery::resizeImages()
  *
  */
  public $imageWidth = 800;

 /**
  * The maximal height of the pictures
  *
  * All pictures will be resized to this height when the {@link resizeImages()} method is called.
  *
  * <b>Note</b>: If the {@link imageGallery::$imageWidth} property is null, it keeps the aspect ratio of the images.
  *
  * @var int
  * @access public
  * @see imageGallery::$imageWidth
  * @see imageGallery::resizeImages()
  *
  */
  public $imageHeight = null;

 /**
  * The maximal width of the thumbnails of the pictures
  *
  * the thumbnails will be created with this width when the {@link imageGallery::createThumbanils()} method is called.
  *
  * <b>Note</b>: If the {@link imageGallery::$thumbnailHeight} property is null, it keeps the aspect ratio of the images.
  *
  * @var int
  * @access public
  * @see imageGallery::$thumbnailHeight
  * @see imageGallery::createThumbanils()
  *
  */
  public $thumbnailWidth = 100;

 /**
  * The maximal height of the thumbnails of the pictures
  *
  * the thumbnails will be created with this height when the {@link imageGallery::createThumbanils()} method is called.
  *
  * <b>Note</b>: If the {@link imageGallery::$thumbnailWidth} property is null, it keeps the aspect ratio of the images.
  *
  * @var int
  * @access public
  * @see imageGallery::$thumbnailWidth
  * @see imageGallery::createThumbanils()
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
  * @see imageGallery::getImages()
  *
  */
  public $filenameCaptions = false;

/**
  * If This timestamp is newer than the thumbnails modification timestamp, it will resize the thumbnails again.
  *
  * @var int
  * @access protected
  *
  */
  public $resetTimestamp = null;

 /**
  * An array which contains all image filenames and paths
  *
  * Example Array:
  * {@example plugins/imageGallery/images.array.example.php}
  *
  * @var array
  * @access protected
  *
  */
  protected $images = array();

/**
  * A unique ID which each imageGallery gets to separate them.
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
  * @uses imageGallery::$GeneralFunctions
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
  public function __construct($jsonImages, $baseFolder = false, $documentRoot = false) {
    @ini_set('memory_limit', '160M');   //  handle large images

    // vars
    $this->documentRoot = ($documentRoot === False) ? $_SERVER['DOCUMENT_ROOT'] : $documentRoot;

    // clerars the cache from other operations
    clearstatcache();

    // get unique id
    $this->uniqueId = uniqid();

    // JSON decode
    $images = GeneralFunctions::jsonDecode($jsonImages);

    $count = 0;
    if(is_array($images) && count($images) > 0) {

      // get image texts
      foreach($images as $image => $text) {

        if(!file_exists($this->documentRoot.$baseFolder.$image))
          continue;

        // set images
        // $image = urldecode($image);
        $this->images[$count]['filename'] = basename($image);
        $this->images[$count]['path'] = preg_replace('#\/+|\\\\#', '/', $baseFolder.dirname($image).'/');
        $this->images[$count]['text'] = XssFilter::text($text);

        $count++;
      }
    }
  }

  public function __destruct(){
    unset($this->images);
  }

 /* ---------------------------------------------------------------------------------------------------------------------------- */
 /* *** METHODS *** */
 /* **************************************************************************************************************************** */

 /**
  * <b>Name</b> resizeImages()<br>
  *
  * Resize the images to the size set in the {@link imageGallery::$imageWidth} and {@link imageGallery::$imageHeight} property.
  *
  *
  * @return bool TRUE if all images could be resized, otherwise FALSE
  *
  * @uses imageGallery::$imageWidth
  * @uses imageGallery::$imageHeight
  * @uses imageGallery::resize()
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
      $imagePath = $image['path'].$image['filename'];
      $imageSize = getimagesize($this->documentRoot.$imagePath);
      $sizeDifference = ((empty($this->imageHeight) && $this->imageWidth >= $imageSize[0]) || (empty($this->imageWidth) && $this->imageHeight >= $imageSize[1]) || ($this->imageWidth  >= $imageSize[0] && $this->imageHeight >= $imageSize[1]))
        ? false
        : true;

      // resize every image
      if($sizeDifference) {
        // echo "RESIZE";

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
  * Resize the images to the size set in the {@link imageGallery::$thumbnailWidth} and {@link imageGallery::$thumbnailHeight} property and copy them to a "thumbnails/" subfolder.
  *
  *
  * @return bool TRUE if all images could be resized, otherwise FALSE
  *
  * @uses imageGallery::$thumbnailWidth
  * @uses imageGallery::$thumbnailHeight
  * @uses imageGallery::$galleryPath
  * @uses imageGallery::resize()
  *
  * @access protected
  * @version 2.0
  * <br>
  * <b>ChangeLog</b><br>
  *    - 2.0 changed for imageGallery based on JSON data images
  *    - 1.0 initial release
  *
  */
  protected function createThumbnails() {

    // quit if no image sizes are set
    if(empty($this->thumbnailWidth) && empty($this->thumbnailHeight))
      return false;

    // resize every image
    foreach($this->images as $image) {

      // vars
      $thumbnailName = str_replace('.','_',$image['filename']).'.galleryThumb.png';
      $thumbnailPath = $image['path'].$thumbnailName;
      $imagePath = $image['path'].$image['filename'];
      $thumbnailSize = (file_exists($this->documentRoot.$thumbnailPath)) ? getimagesize($this->documentRoot.$thumbnailPath) : array(0,0);
      $imageSize = (file_exists($this->documentRoot.$imagePath)) ? getimagesize($this->documentRoot.$imagePath) : array(0,0);
      $sizeDifference = ((!empty($this->thumbnailWidth) && $this->thumbnailWidth >= $thumbnailSize[0]) || (!empty($this->thumbnailHeight) && $this->thumbnailHeight >= $thumbnailSize[1]))
        ? false
        : true;

      // check if reset timestamp is newer than the thumbnail timestamp
      if(!empty($this->resetTimestamp) && file_exists($this->documentRoot.$thumbnailPath) && $this->resetTimestamp > filemtime($this->documentRoot.$thumbnailPath))
        $sizeDifference = true;

      // resize every thumbnail
      if(!file_exists($this->documentRoot.$thumbnailPath) || $sizeDifference) {
        // echo "THUMBNAIL";

        // get the Image class
        require_once(dirname(__FILE__).'/includes/Image.class.php');

        // vars
        $width = $this->thumbnailWidth;
        $height = $this->thumbnailHeight;

        // resize either the height or the width, depending whats bigger, when width/height for the thumbnail was given
        if(!empty($this->thumbnailWidth) && !empty($this->thumbnailHeight) && is_numeric($this->thumbnailWidth) && is_numeric($this->thumbnailHeight)) {

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
        $resize->resize($width,$height,$this->keepRatio,$this->resizeWhenSmaller); // dont resize height
        $resize->process('png',$this->documentRoot.$thumbnailPath);
        unset($resize);

        $return = true;
      } else
        $return = false;
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
  * @uses imageGallery::$galleryPath
  *
  * @access protected
  * @version 1.1
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.1 add image as background when having a fixed size of the thumbnails
  *    - 1.0 initial release
  *
  */
  protected function getImages() {

    // var
    $return = array();
    $tagEnd = ($this->xHtml === true) ? ' />' : '>';

    foreach($this->images as $image) {
      $thumbnailName = str_replace('.','_',$image['filename']).'.galleryThumb.png';

      // add captions
      if($this->filenameCaptions)
        $imageText = (!empty($image['text'])) ? ' title="'.$image['text'].'"' : ' title="'.substr($image['filename'],0,strpos($image['filename'],'.')).'"';
      else
        $imageText = (!empty($image['text'])) ? ' title="'.$image['text'].'"' : '';

      if(!empty($this->thumbnailWidth) && !empty($this->thumbnailHeight) && is_numeric($this->thumbnailWidth) && is_numeric($this->thumbnailHeight))
        $return[] = '<a href="'.GeneralFunctions::Path2URI($image['path']).$image['filename'].'" data-milkbox="imageGallery#'.$this->uniqueId.'"'.$imageText.' style="display:inline-block; width:'.$this->thumbnailWidth.'px; height:'.$this->thumbnailHeight.'px;"><img src="'.$this->emptyImage.'" alt="'.$image['text'].'" style="display: inline-block; background-size: cover; width:'.$this->thumbnailWidth.'px; height:'.$this->thumbnailHeight.'px; background: url(\''.GeneralFunctions::Path2URI($image['path']).$thumbnailName.'\') no-repeat center center;"'.$tagEnd.'</a>';
      else
        $return[] = '<a href="'.GeneralFunctions::Path2URI($image['path']).$image['filename'].'" data-milkbox="imageGallery#'.$this->uniqueId.'"'.$imageText.' style="display:inline-block;"><img src="'.GeneralFunctions::Path2URI($image['path']).$thumbnailName.'" alt="'.$image['text'].'"'.$tagEnd.'</a>';
    }

    return $return;
  }

 /**
  * <b>Name</b> showGallery()<br>
  *
  * Generates the gallery for displaying in an HTML-page
  *
  * <b>Note</b>: The image gallery is surrounded by an '<div class="feinduraPlugin_imageGallery">' tag to help to style the image gallery.
  *
  * @param string       $tag         the tag used to create the gallery, can be "ul","menu", "table" or FALSE to return just images
  * @param int          $breakAfter  (optional) if the $tag parameter is "table" then it defines the number after which the table makes a new row
  *
  * @return string the generated gallery
  *
  * @uses imageGallery::resizeImages()      to check if the images must be resized first and do it
  * @uses imageGallery::createThumbnail()   to check if thumbnails must be created first
  *
  * @access public
  * @version 1.0
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.0 initial release
  *
  */
  public function showGallery($tag, $breakAfter = false) {

    $this->resizeImages();
    $this->createThumbnails();

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