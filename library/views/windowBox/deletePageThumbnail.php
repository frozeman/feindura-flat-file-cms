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
if($asking && file_exists(DOCUMENTROOT.$adminConfig['uploadPath'].$adminConfig['pageThumbnail']['path'].$thumbnail)) {
  @chmod(DOCUMENTROOT.$adminConfig['uploadPath'].$adminConfig['pageThumbnail']['path'].$thumbnail, $adminConfig['permissions']);

    // DELETING
    $pageContent['thumbnail'] = '';
    if(@unlink(DOCUMENTROOT.$adminConfig['uploadPath'].$adminConfig['pageThumbnail']['path'].$thumbnail) && GeneralFunctions::savePage($pageContent)) {
        saveActivityLog(5,'page='.$pageContent['id']); // <- SAVE the task in a LOG FILE

        $question = '';
        echo 'DONTSHOW';

        // create redirect
        $redirect = (empty($site))
          ? '?category='.$category.'&page='.$page.'&status=reload'.rand(1,99).'#pageInformation'
          : '?site='.$site.'&category='.$category;

        // redirect, when on listPages
        if($site == 'pages') {
          $redirect .= '&status=reload'.rand(1,99).'#categoryAnchor'.$category;
          echo '<script type="text/javascript">/* <![CDATA[ */closeWindowBox(\'index.php'.$redirect.'\');/* ]]> */</script>';

        // remove the thumbnail preview
        } else { ?>
          <script type="text/javascript">
          /* <![CDATA[ */
            if($('thumbnailUploadButtonInPreviewArea') != null) {
              $('thumbnailUploadButtonInPreviewArea').setStyle('display','block');
              $('thumbnailPreviewContainer').setStyle('display','none');
              closeWindowBox();
            }
          /* ]]> */
          </script>';
 <?php  }

    } else {
      // DELETING ERROR --------------
      $question = '<h2>'.$langFile['PAGETHUMBNAIL_ERROR_DELETE'].'</h2>
      <a href="?category='.$category.'&amp;page='.$page.'" class="ok center" onclick="closeWindowBox();return false;">&nbsp;</a>'."\n";
    }
} elseif(!file_exists(DOCUMENTROOT.$adminConfig['uploadPath'].$adminConfig['pageThumbnail']['path'].$thumbnail)) {
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

  <div class="row">
    <div class="span4 center">
      <a href="?site=pages&amp;category=<?php echo $category; ?>&amp;page=<?php echo $page; ?>" class="button cancel" onclick="closeWindowBox();return false;"></a>
    </div>
    <div class="span4 center">
      <input type="submit" value="" class="button submit">
    </div>
  </div>
</form>

<div class="spacer"></div>

<!-- show a preview of the thumbnail -->
<div class="center">
  <?php
    $thumbnailWidth = @getimagesize(DOCUMENTROOT.$adminConfig['uploadPath'].$adminConfig['pageThumbnail']['path'].$pageContent['thumbnail']);

    if($thumbnailWidth[0] <= 700)
      $thumbnailWidth = ' style="width: '.$thumbnailWidth[0].'px;"';
    else
      $thumbnailWidth = ' style="width: 700px;"';

    // generates a random number to put on the end of the image, to prevent caching
    $randomImage = '?'.md5(uniqid(rand(),1));
  ?>
  <img src="<?php echo GeneralFunctions::Path2URI($adminConfig['uploadPath']).$adminConfig['pageThumbnail']['path'].$thumbnail.$randomImage; ?>" class="thumbnail"<?php echo $thumbnailWidth;?> alt="thumbnail" title="<?php echo $adminConfig['uploadPath'].$adminConfig['pageThumbnail']['path'].$thumbnail; ?>">
</div>
<?php
}
?>