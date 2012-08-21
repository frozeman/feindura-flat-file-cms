<?php
/* slideShow plugin */
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
 * This file contains the {@link slideShow} class.
 *
 * @package [Plugins]
 * @subpackage slideShow
 */

/**
* slideShow Plugin class
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
* <b>Note</b>: The image gallery is surrounded by an '<div class="feinduraPlugin_slideShow">' tag to help to style the image gallery.
*
* @author Fabian Vogelsteller <fabian@feindura.org>
* @copyright Fabian Vogelsteller
* @license http://www.gnu.org/licenses GNU General Public License version 3
*
* @package [Plugins]
* @subpackage slideShow
*
* @version 2.0
* <br>
* <b>ChangeLog</b><br>
*    - 2.0 changed to JSON image data
*    - 1.1 removed resize() because it uses now the {@link Image} class
*    - 1.02 fixed image texts
*    - 1.01 fixed file extension, made to lowercase
*    - 1.0 initial release
*
*/
class slideShow {

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
  * @see slideShow::$imageHeight
  * @see slideShow::$imageWidth
  * @see slideShow::resize()
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
  * @see slideShow::$imageHeight
  * @see slideShow::$imageWidth
  * @see slideShow::resize()
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
  * All pictures will be resized to this width when the {@link slideShow::resizeImages()} method is called.
  *
  * <b>Note</b>: If the {@link slideShow::$imageHeight} property is null, it keeps the aspect ratio of the images.
  *
  * @var int
  * @access public
  * @see slideShow::$imageHeight
  * @see slideShow::resizeImages()
  *
  */
  public $imageWidth = 600;

 /**
  * The maximal height of the pictures
  *
  * All pictures will be resized to this height when the {@link resizeImages()} method is called.
  *
  * <b>Note</b>: If the {@link slideShow::$imageWidth} property is null, it keeps the aspect ratio of the images.
  *
  * @var int
  * @access public
  * @see slideShow::$imageWidth
  * @see slideShow::resizeImages()
  *
  */
  public $imageHeight = 350;

/**
  * If This timestamp is newer than the images modification timestamp, it will resize the images again.
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
  * {@example plugins/slideShow/images.array.example.php}
  *
  * @var array
  * @access protected
  *
  */
  protected $images = array();

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
  * @uses slideShow::readFolder() to read the files in the folder, to store the images in the {@link slideShow::$images} property
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
  public function __construct($jsonImages,$baseFolder = false,$documentRoot = false) {
    @ini_set('memory_limit', '120M');   //  handle large images

    // vars
    $this->documentRoot = ($documentRoot === False) ? $_SERVER['DOCUMENT_ROOT'] : $documentRoot;

    // clerars the cache from other operations
    clearstatcache();

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

 /* ---------------------------------------------------------------------------------------------------------------------------- */
 /* *** METHODS *** */
 /* **************************************************************************************************************************** */

 /**
  * <b>Name</b> resizeImages()<br>
  *
  * Resize the images to the size set in the {@link slideShow::$imageWidth} and {@link slideShow::$imageHeight} property.
  *
  *
  * @return bool TRUE if all images could be resized, otherwise FALSE
  *
  * @uses slideShow::$imageWidth
  * @uses slideShow::$imageHeight
  * @uses slideShow::$path
  * @uses slideShow::resize()
  *
  * @access protected
  * @version 1.1
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.1 changed method to resize images, new calculation
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
      $sizeDifference = ((!empty($this->imageWidth) && $this->imageWidth >= $imageSize[0]) || (!empty($this->imageHeight) && $this->imageHeight >= $imageSize[1]))
        ? false
        : true;

      // check if reset timestamp is newer than the thumbnail timestamp
      if(!empty($this->resetTimestamp) && file_exists($this->documentRoot.$imagePath) && $this->resetTimestamp > filemtime($this->documentRoot.$imagePath))
        $sizeDifference = true;

      // resize every image
      if($sizeDifference) {
        // echo "RESIZE";

        // get the Image class
        if(!class_exists(Image,false))
          require_once(dirname(__FILE__).'/includes/Image.class.php');

        // vars
        $width = $this->imageWidth;
        $height = $this->imageHeight;

        // resize either the height or the width, depending whats bigger, when width/height for the thumbnail was given
        if(!empty($this->imageWidth) && !empty($this->imageHeight) && is_numeric($this->imageWidth) && is_numeric($this->imageHeight)) {

          $imageRatio = $imageSize[0] / $imageSize[1];
          $slideRatio = $this->width / $this->height;

          if($imageRatio >= 1 && $slideRatio <= 1)
            $width = false;
          elseif($imageRatio <= 1 && $slideRatio >= 1)
            $height = false;
          elseif($imageRatio >= 1 && $slideRatio >= 1 && $imageRatio > $slideRatio)
            $width = false;
          elseif($imageRatio >= 1 && $slideRatio >= 1 && $imageRatio < $slideRatio)
            $height = false;
        }

        // wont resize the height so it overflows the slideshow, looks better
        $resize = new Image($imagePath,$this->documentRoot);
        $resize->resize($width,$height,$this->keepRatio,$this->resizeWhenSmaller);
        $resize->process();
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
  *
  * @return array an array with image links
  *
  * @uses slideShow::$path
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
      $imageText = (!empty($image['text'])) ? ' title="'.XssFilter::text($image['text']).'"' : '';
      $return[] = '<img src="'.GeneralFunctions::Path2URI($image['path']).$image['filename'].'" alt="slideShowImage"'.$imageText.$tagEnd."\n";
    }

    return $return;
  }

 /**
  * <b>Name</b> show()<br>
  *
  * Generates the slide show for displaying in an HTML-page
  *
  * <b>Note</b>: The slide show div tag has also a 'class="feinduraPlugin_slideShow nivoo-slider"' attribute for styling.
  *
  * @param string       $containerId  the ID if the container div, which holds the slideshow
  *
  * @return string the generated slide show
  *
  * @uses slideShow::resizeImages()      to check if the images must be resized first and do it
  *
  * @access public
  * @version 1.0
  * <br>
  * <b>ChangeLog</b><br>
  *    - 1.0 initial release
  *
  */
  public function show($containerId) {

    $this->resizeImages();

    // add images
    foreach($this->getImages() as $image) {
      // add image to the gallery
      $slideshow .= $image;
    }

    // RETURN
    return '<div id="'.$containerId.'" class="nivoo-slider" style="width:'.$this->width.'px; height:'.$this->height.'px;">'.$slideshow.'</div>';
  }
}
?>