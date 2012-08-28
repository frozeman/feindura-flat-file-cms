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
 * deletePageThumbnail.php
 *
 * @version 0.91
 */

/**
 * Includes the login.include.php and backend.include.php and filter the basic data
 */
require_once(dirname(__FILE__)."/../../includes/secure.include.php");

echo ' '; // hack for safari, otherwise it throws an error that he could not find htmlentities like &ouml;

// gets the vars
if(isset($_POST['category']))
  $category = $_POST['category'];
else
  $category = $_GET['category'];
if(isset($_POST['id']))
  $page = $_POST['id'];
else
  $page = $_GET['page'];
if(isset($_POST['site']))
  $site = $_POST['site'];
else
  $site = $_GET['site'];
$asking = $_POST['asking'];

// load the page
$pageContent = GeneralFunctions::readPage($page,$category);
$thumbnail = $pageContent['thumbnail'];

// QUESTION
$question = '<h2 class="red">'.$langFile['PAGETHUMBNAIL_TEXT_DELETE_QUESTION_START'].' &quot;<span style="color:#000000;">'.strip_tags(GeneralFunctions::getLocalized($pageContent,'title')).'</span>&quot; '.$langFile['PAGETHUMBNAIL_TEXT_DELETE_QUESTION_END'].'</h2>';

// DELETING PROCESS
if($asking && file_exists(dirname(__FILE__).'/../../../upload/thumbnails/'.$thumbnail)) {
  @chmod(dirname(__FILE__).'/../../../upload/thumbnails/'.$thumbnail, $adminConfig['permissions']);

    // DELETING
    $pageContent['thumbnail'] = '';
    if(@unlink(dirname(__FILE__).'/../../../upload/thumbnails/'.$thumbnail) && GeneralFunctions::savePage($pageContent)) {
        saveActivityLog(5,'page='.$pageContent['id']); // <- SAVE the task in a LOG FILE

        $question = false;

        // on listPages REDIRECT
        if($site == 'pages') {

          // create redirect
          $redirect = '?site='.$site.'&category='.$category.'&status=reload'.rand(1,99).'#categoryAnchor'.$category;
          // CLOSE the windowBox and REDIRECT, if the first part of the response is '#REDIRECT#'
          die('#REDIRECT#'.$redirect);

        // on page REMOVE the THUMBNAIL PREVIEW
        } else {

          // CLOSE the windowBox, if the first part of the response is '#CLOSE#'
          echo '#CLOSE#'; // echo not die(), so it executes the javascript below, before closing
          ?>

          <script type="text/javascript">
          /* <![CDATA[ */
            if($('thumbnailUploadButtonInPreviewArea') != null)
              $('thumbnailUploadButtonInPreviewArea').setStyle('display','inline-block');
            if($('thumbnailPreviewContainer') != null)
              $('thumbnailPreviewContainer').setStyle('display','none');
          /* ]]> */
          </script>
 <?php  }

    } else {
      // DELETING ERROR --------------
      $question = '<div class="alert alert-error">'.$langFile['PAGETHUMBNAIL_ERROR_DELETE'].'</div>
      <a href="?category='.$category.'&amp;page='.$page.'" class="button ok center" onclick="closeWindowBox();return false;"></a>'."\n";
    }
} elseif(!file_exists(dirname(__FILE__).'/../../../upload/thumbnails/'.$thumbnail)) {
  $pageContent['thumbnail'] = '';
  GeneralFunctions::savePage($pageContent);
}

echo $question;

if(!$asking) {

?>
<form action="?site=deletePage" method="post" enctype="multipart/form-data" id="deletePageForm" onsubmit="requestSite('<?php echo $_SERVER['PHP_SELF']; ?>','','deletePageForm');return false;" accept-charset="UTF-8">
  <div>
    <input type="hidden" name="category" value="<?php echo $category; ?>">
    <input type="hidden" name="id" value="<?php echo $page; ?>">
    <input type="hidden" name="site" value="<?php echo $site; ?>">
    <input type="hidden" name="asking" value="true">
  </div>

  <div class="row buttons">
    <div class="span4 center">
      <a href="?site=pages&amp;category=<?php echo $category; ?>&amp;page=<?php echo $page; ?>" class="button cancel" onclick="closeWindowBox();return false;"></a>
    </div>
    <div class="span4 center">
      <input type="submit" value="" class="button submit">
    </div>
  </div>
</form>

<!-- show a preview of the thumbnail -->
<div class="center">
  <?php
    $thumbnailWidth = @getimagesize(dirname(__FILE__).'/../../../upload/thumbnails/'.$pageContent['thumbnail']);

    if($thumbnailWidth[0] <= 700)
      $thumbnailWidth = ' style="width: '.$thumbnailWidth[0].'px;"';
    else
      $thumbnailWidth = ' style="width: 700px;"';

    // generates a random number to put on the end of the image, to prevent caching
    $randomImage = '?'.md5(uniqid(rand(),1));
  ?>
  <img src="<?php echo GeneralFunctions::Path2URI(dirname(__FILE__).'/../../../upload/thumbnails/').$thumbnail.$randomImage; ?>" class="thumbnail"<?php echo $thumbnailWidth;?> alt="thumbnail" title="<?php echo dirname(__FILE__).'/../../../upload/thumbnails/'.$thumbnail; ?>">
</div>
<?php
}
?>